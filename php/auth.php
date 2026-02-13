<?php
/**
 * AUTH.PHP · USER AUTHENTICATION
 * FIXED: Removed CONFIG references, using defined constants
 * VERSION: 2.0.1
 */

// Prevent direct access
if (!defined('SECURE_ACCESS')) {
    header('HTTP/1.0 403 Forbidden');
    exit('Direct access forbidden · R-CORP security');
}

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/security.php';

class Auth {
    private PDO $db;
    
    public function __construct() {
        $this->db = Database::getConnection();
    }
    
    /**
     * Register a new user
     */
    public function register(string $username, string $email, string $password): array {
        // Validate input
        if (strlen($username) < 3 || strlen($username) > 50) {
            return ['success' => false, 'message' => 'Username must be 3-50 characters'];
        }
        
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
            return ['success' => false, 'message' => 'Username can only contain letters, numbers, and underscores'];
        }
        
        if (!validateEmail($email)) {
            return ['success' => false, 'message' => 'Invalid email format'];
        }
        
        if (strlen($password) < 8) {
            return ['success' => false, 'message' => 'Password must be at least 8 characters'];
        }
        
        // Check rate limit
        if (!checkRateLimit(getClientIP())) {
            return ['success' => false, 'message' => 'Too many attempts. Try again later.'];
        }
        
        try {
            // Check if user exists (email OR username)
            $stmt = $this->db->prepare('SELECT id FROM users WHERE email = :email OR username = :username');
            $stmt->execute([
                'email' => $email, 
                'username' => $username
            ]);
            
            if ($stmt->fetch()) {
                return ['success' => false, 'message' => 'User already exists'];
            }
            
            // Hash password
            $hashedPassword = hashPassword($password);
            
            // Insert user
            $stmt = $this->db->prepare('
                INSERT INTO users (
                    username, 
                    email, 
                    password_hash, 
                    doctrine_accepted, 
                    created_at,
                    login_attempts,
                    is_banned
                ) VALUES (
                    :username, 
                    :email, 
                    :password, 
                    :doctrine, 
                    NOW(),
                    0,
                    0
                )
            ');
            
            $result = $stmt->execute([
                'username' => $username,
                'email' => $email,
                'password' => $hashedPassword,
                'doctrine' => 1
            ]);
            
            if (!$result) {
                error_log('Registration failed: Execute returned false');
                return ['success' => false, 'message' => 'Registration failed · Database error'];
            }
            
            $userId = $this->db->lastInsertId();
            
            if (!$userId) {
                error_log('Registration failed: No insert ID returned');
                return ['success' => false, 'message' => 'Registration failed · No user ID'];
            }
            
            // Log doctrine acceptance
            $this->logDoctrineAcceptance($userId);
            
            error_log("New user registered: ID: $userId, Username: $username from IP: " . getClientIP());
            
            return [
                'success' => true,
                'message' => 'Registration successful',
                'user_id' => $userId
            ];
            
        } catch (PDOException $e) {
            error_log('Registration PDO Error: ' . $e->getMessage());
            
            $response = [
                'success' => false, 
                'message' => 'Registration failed · R-CORP security'
            ];
            
            if (defined('DEBUG_MODE') && DEBUG_MODE === true) {
                $response['debug'] = $e->getMessage();
                $response['sql_state'] = $e->errorInfo[0] ?? 'N/A';
                $response['error_code'] = $e->errorInfo[1] ?? 'N/A';
            }
            
            return $response;
            
        } catch (Exception $e) {
            error_log('Registration General Error: ' . $e->getMessage());
            
            $response = ['success' => false, 'message' => 'Registration failed · System error'];
            
            if (defined('DEBUG_MODE') && DEBUG_MODE === true) {
                $response['debug'] = $e->getMessage();
            }
            
            return $response;
        }
    }
    
    /**
     * Login user
     */
    public function login(string $login, string $password, bool $remember = false): array {
        // Check rate limit
        if (!checkRateLimit(getClientIP())) {
            return ['success' => false, 'message' => 'Too many login attempts. Try again later.'];
        }
        
        try {
            // Find user by email or username
            $stmt = $this->db->prepare('
                SELECT id, username, email, password_hash, is_banned, login_attempts
                FROM users 
                WHERE email = :login OR username = :login
            ');
            $stmt->execute(['login' => $login]);
            
            $user = $stmt->fetch();
            
            if (!$user) {
                return ['success' => false, 'message' => 'Invalid credentials'];
            }
            
            // Check if banned
            if ($user['is_banned']) {
                error_log("Banned user attempted login: {$user['username']} from IP: " . getClientIP());
                return ['success' => false, 'message' => 'Account suspended · Contact R-CORP'];
            }
            
            // Verify password
            if (!password_verify($password, $user['password_hash'])) {
                $this->incrementLoginAttempts($user['id']);
                return ['success' => false, 'message' => 'Invalid credentials'];
            }
            
            // Check if password needs rehash
            $cost = defined('BCRYPT_COST') ? BCRYPT_COST : 12;
            if (password_needs_rehash($user['password_hash'], PASSWORD_BCRYPT, ['cost' => $cost])) {
                $this->rehashPassword($user['id'], $password);
            }
            
            // Reset login attempts
            $this->resetLoginAttempts($user['id']);
            
            // Create session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['login_time'] = time();
            $_SESSION['r_corp_doctrine'] = true;
            
            // Regenerate session ID
            session_regenerate_id(true);
            
            // Set remember me cookie if requested
            if ($remember) {
                $this->setRememberMe($user['id']);
            }
            
            error_log("User logged in: {$user['username']} (ID: {$user['id']}) from IP: " . getClientIP());
            
            return [
                'success' => true,
                'message' => 'Login successful',
                'user' => [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email']
                ]
            ];
            
        } catch (PDOException $e) {
            error_log('Login error: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Login failed · R-CORP security'];
        }
    }
    
    /**
     * Log doctrine acceptance
     */
    private function logDoctrineAcceptance(int $userId): void {
        try {
            // Check if doctrine_acceptance table exists
            $stmt = $this->db->query("SHOW TABLES LIKE 'doctrine_acceptance'");
            if ($stmt->rowCount() === 0) {
                return; // Table doesn't exist, skip logging
            }
            
            $stmt = $this->db->prepare('
                INSERT INTO doctrine_acceptance (
                    user_id, 
                    doctrine_version, 
                    accepted_at, 
                    ip_address
                ) VALUES (
                    :user_id,
                    :version,
                    NOW(),
                    :ip
                )
            ');
            
            $stmt->execute([
                'user_id' => $userId,
                'version' => 'v3.5',
                'ip' => getClientIP()
            ]);
        } catch (PDOException $e) {
            // Non-critical, just log it
            error_log('Doctrine logging failed (non-critical): ' . $e->getMessage());
        }
    }
    
    /**
     * Set remember me cookie
     */
    private function setRememberMe(int $userId): void {
        $token = generateRememberToken();
        $expires = time() + 30 * 86400; // 30 days
        
        try {
            // Check if user_tokens table exists
            $stmt = $this->db->query("SHOW TABLES LIKE 'user_tokens'");
            if ($stmt->rowCount() === 0) {
                return; // Table doesn't exist, skip token storage
            }
            
            // Store token in database
            $stmt = $this->db->prepare('
                INSERT INTO user_tokens (user_id, token, expires_at)
                VALUES (:user_id, :token, FROM_UNIXTIME(:expires))
            ');
            
            $stmt->execute([
                'user_id' => $userId,
                'token' => hash('sha256', $token),
                'expires' => $expires
            ]);
            
            // Set secure cookie
            setcookie('remember_token', $token, [
                'expires' => $expires,
                'path' => '/',
                'domain' => '',
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Strict'
            ]);
        } catch (PDOException $e) {
            error_log('Remember me token storage failed: ' . $e->getMessage());
        }
    }
    
    /**
     * Check if user is logged in
     */
    public static function isLoggedIn(): bool {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check session
        if (isset($_SESSION['user_id']) && isset($_SESSION['login_time'])) {
            $timeout = defined('SESSION_TIMEOUT') ? SESSION_TIMEOUT : 7200;
            if (time() - $_SESSION['login_time'] < $timeout) {
                return true;
            }
            self::logout();
        }
        
        return self::checkRememberMe();
    }
    
    /**
     * Check remember me cookie
     */
    private static function checkRememberMe(): bool {
        if (!isset($_COOKIE['remember_token'])) {
            return false;
        }
        
        try {
            $db = Database::getConnection();
            
            // Check if user_tokens table exists
            $stmt = $db->query("SHOW TABLES LIKE 'user_tokens'");
            if ($stmt->rowCount() === 0) {
                return false;
            }
            
            $token = hash('sha256', $_COOKIE['remember_token']);
            
            $stmt = $db->prepare('
                SELECT user_id FROM user_tokens 
                WHERE token = :token AND expires_at > NOW()
            ');
            $stmt->execute(['token' => $token]);
            
            $result = $stmt->fetch();
            
            if ($result) {
                $_SESSION['user_id'] = $result['user_id'];
                $_SESSION['login_time'] = time();
                $_SESSION['r_corp_doctrine'] = true;
                
                $stmt = $db->prepare('SELECT username FROM users WHERE id = :id');
                $stmt->execute(['id' => $result['user_id']]);
                $user = $stmt->fetch();
                
                if ($user) {
                    $_SESSION['username'] = $user['username'];
                }
                
                return true;
            }
            
        } catch (PDOException $e) {
            error_log('Remember me error: ' . $e->getMessage());
        }
        
        return false;
    }
    
    /**
     * Logout user
     */
    public static function logout(): void {
        $_SESSION = [];
        
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', [
                'expires' => time() - 3600,
                'path' => '/',
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Strict'
            ]);
        }
        
        if (isset($_COOKIE['remember_token'])) {
            try {
                $db = Database::getConnection();
                
                // Check if user_tokens table exists
                $stmt = $db->query("SHOW TABLES LIKE 'user_tokens'");
                if ($stmt->rowCount() > 0) {
                    $token = hash('sha256', $_COOKIE['remember_token']);
                    $stmt = $db->prepare('DELETE FROM user_tokens WHERE token = :token');
                    $stmt->execute(['token' => $token]);
                }
            } catch (PDOException $e) {
                error_log('Logout token cleanup error: ' . $e->getMessage());
            }
            
            setcookie('remember_token', '', [
                'expires' => time() - 3600,
                'path' => '/',
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Strict'
            ]);
        }
        
        session_destroy();
    }
    
    /**
     * Get current user data
     */
    public static function getCurrentUser(): ?array {
        if (!self::isLoggedIn()) {
            return null;
        }
        
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare('
                SELECT id, username, email, created_at, doctrine_accepted
                FROM users WHERE id = :id
            ');
            $stmt->execute(['id' => $_SESSION['user_id']]);
            
            return $stmt->fetch();
            
        } catch (PDOException $e) {
            error_log('Get current user error: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Increment login attempts
     */
    private function incrementLoginAttempts(int $userId): void {
        $stmt = $this->db->prepare('
            UPDATE users SET login_attempts = login_attempts + 1 
            WHERE id = :id
        ');
        $stmt->execute(['id' => $userId]);
    }
    
    /**
     * Reset login attempts
     */
    private function resetLoginAttempts(int $userId): void {
        $stmt = $this->db->prepare('
            UPDATE users SET login_attempts = 0 
            WHERE id = :id
        ');
        $stmt->execute(['id' => $userId]);
    }
    
    /**
     * Rehash password
     */
    private function rehashPassword(int $userId, string $password): void {
        $hashed = hashPassword($password);
        $stmt = $this->db->prepare('
            UPDATE users SET password_hash = :password 
            WHERE id = :id
        ');
        $stmt->execute(['password' => $hashed, 'id' => $userId]);
    }
}