<?php
/**
 * REGISTER.PHP · CREATE ACCOUNT
 * FIXED: Database structure compatibility
 */

define('SECURE_ACCESS', true);
session_start();
require 'config.php';
require 'security.php';
require 'auth.php';

// Enable error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create debug log file
define('DEBUG_LOG', __DIR__ . '/register_debug.log');

function debug_log($message, $data = null) {
    $log = date('Y-m-d H:i:s') . ' - ' . $message;
    if ($data !== null) {
        $log .= ' - ' . print_r($data, true);
    }
    $log .= PHP_EOL;
    file_put_contents(DEBUG_LOG, $log, FILE_APPEND);
}

debug_log('Register page accessed');

if (Auth::isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    debug_log('POST request received', $_POST);
    
    // Validate CSRF
    if (!validateCSRFToken($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid security token · R-CORP protection';
        debug_log('CSRF validation failed');
    } else {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';
        $doctrine = isset($_POST['doctrine']) ? 1 : 0;
        
        debug_log('Form data processed', [
            'username' => $username,
            'email' => $email,
            'doctrine' => $doctrine,
            'password_length' => strlen($password)
        ]);
        
        // Validate
        if (!$doctrine) {
            $error = 'You must accept the R-CORP accountability doctrine';
            debug_log('Doctrine not accepted');
        } elseif ($password !== $confirm) {
            $error = 'Passwords do not match';
            debug_log('Password mismatch');
        } elseif (strlen($password) < 8) {
            $error = 'Password must be at least 8 characters';
            debug_log('Password too short');
        } else {
            debug_log('Attempting to register user');
            
            // Hash the password
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            
            // Check if username already exists
            try {
                $check = $db->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
                $check->execute([$username, $email]);
                $existing = $check->fetch();
                
                if ($existing) {
                    $error = 'Username or email already exists';
                    debug_log('User already exists');
                } else {
                    // Insert new user with correct field mappings
                    $sql = "INSERT INTO users (
                        username, 
                        email, 
                        password_hash, 
                        doctrine_accepted, 
                        created_at,
                        updated_at,
                        is_banned,
                        login_attempts
                    ) VALUES (?, ?, ?, ?, NOW(), NOW(), 0, 0)";
                    
                    debug_log('SQL Query: ' . $sql);
                    debug_log('Parameters: ', [$username, $email, '[HASHED]', $doctrine]);
                    
                    $stmt = $db->prepare($sql);
                    $result = $stmt->execute([$username, $email, $password_hash, $doctrine]);
                    
                    if ($result) {
                        $userId = $db->lastInsertId();
                        debug_log('User inserted successfully with ID: ' . $userId);
                        
                        // Verify the user was actually inserted
                        $verify = $db->prepare("SELECT * FROM users WHERE id = ?");
                        $verify->execute([$userId]);
                        $newUser = $verify->fetch(PDO::FETCH_ASSOC);
                        
                        if ($newUser) {
                            debug_log('VERIFICATION SUCCESS: User found in database', $newUser);
                            $success = 'Account created! You can now login.';
                            $_POST = [];
                            
                            // Auto-redirect after 3 seconds
                            header('refresh:3;url=login.php');
                        } else {
                            debug_log('VERIFICATION FAILED: User not found after insert');
                            $error = 'Account creation failed - verification error';
                        }
                    } else {
                        $errorInfo = $stmt->errorInfo();
                        debug_log('Insert failed: ' . print_r($errorInfo, true));
                        $error = 'Database error: ' . $errorInfo[2];
                    }
                }
            } catch (PDOException $e) {
                debug_log('Database exception: ' . $e->getMessage());
                debug_log('SQL State: ' . $e->errorInfo[0]);
                $error = 'Database error: ' . $e->getMessage();
            }
        }
    }
}

$csrf_token = generateCSRFToken();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTER · DECENSORWEB</title>
    <link rel="stylesheet" href="../css/roadmap.css">
    <link rel="stylesheet" href="../css/login.css">
    <style>
        .debug-info {
            margin-top: 20px;
            padding: 10px;
            background: #1a1a1a;
            border: 1px solid #ff00ff33;
            color: #00ff00;
            font-family: monospace;
            font-size: 12px;
            text-align: left;
        }
        .debug-link {
            color: #ff00ff;
            cursor: pointer;
            text-decoration: underline;
            margin-top: 10px;
            display: inline-block;
        }
        .field-guide {
            font-size: 11px;
            color: #888;
            border-top: 1px solid #333;
            margin-top: 20px;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="map-corner top-left"></div>
        <div class="map-corner top-right"></div>
        <div class="map-corner bottom-left"></div>
        <div class="map-corner bottom-right"></div>
        
        <div class="login-header">
            <span class="insignia">⛧</span>
            <h1 class="login-title">CREATE ACCOUNT</h1>
            <span class="insignia">⛧</span>
        </div>
        
        <div class="doctrine-banner">
            <span class="doctrine-text">R-CORP · FULL ACCOUNTABILITY</span>
        </div>
        
        <?php if ($error): ?>
            <div class="alert error">⛔ <?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert success">✓ <?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        
        <?php if (defined('DEBUG_MODE') && DEBUG_MODE): ?>
            <div class="debug-info">
                <strong>DEBUG INFO:</strong><br>
                - Debug log: <?php echo DEBUG_LOG; ?><br>
                - Last 5 entries: 
                <pre style="font-size: 10px; margin-top: 5px;"><?php 
                    if (file_exists(DEBUG_LOG)) {
                        $lines = array_slice(file(DEBUG_LOG), -5);
                        echo htmlspecialchars(implode('', $lines));
                    } else {
                        echo "No log entries yet";
                    }
                ?></pre>
            </div>
            <div onclick="window.location.href='?show_debug=1'" class="debug-link">
                🔧 Show full debug log
            </div>
        <?php endif; ?>
        
        <form method="POST" action="register.php" class="login-form">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            
            <div class="form-group">
                <label for="username" class="form-label">USERNAME</label>
                <input type="text" 
                       id="username" 
                       name="username" 
                       class="form-input" 
                       value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"
                       required 
                       minlength="3" 
                       maxlength="50" 
                       pattern="[a-zA-Z0-9_]+"
                       title="Username can only contain letters, numbers, and underscores"
                       autofocus>
                <small style="color: #888; display: block; margin-top: 4px;">3-50 characters, letters/numbers/underscores only</small>
            </div>
            
            <div class="form-group">
                <label for="email" class="form-label">EMAIL ADDRESS</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       class="form-input"
                       value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                       required
                       maxlength="255">
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">PASSWORD (min 8 chars)</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       class="form-input"
                       required 
                       minlength="8">
                <div class="password-strength-meter"></div>
            </div>
            
            <div class="form-group">
                <label for="confirm_password" class="form-label">CONFIRM PASSWORD</label>
                <input type="password" 
                       id="confirm_password" 
                       name="confirm_password" 
                       class="form-input"
                       required 
                       minlength="8">
            </div>
            
            <div class="form-group form-checkbox">
                <input type="checkbox" id="doctrine" name="doctrine" value="1" class="checkbox-input" required>
                <label for="doctrine" class="checkbox-label">
                    I accept the R-CORP accountability doctrine · <strong>WE DO NOT SELL · WE DO NOT LOG</strong>
                </label>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="login-button">⚡ CREATE ACCOUNT ⚡</button>
            </div>
        </form>
        
        <div class="login-links">
            <a href="login.php" class="auth-link">← BACK TO LOGIN</a>
        </div>
        
        <div class="accountability-footer">
            <div class="footer-nav">
                <a href="../index.html" class="back-btn">← MAIN TERMINAL</a>
                <a href="../navigate.php" class="back-btn">← NAVIGATION HUB</a>
            </div>
        </div>
        
        <div class="field-guide">
            <span>⚡ SYSTEM: READY ⚡</span>
        </div>
    </div>
    
    <script src="../js/login.js" defer></script>
    
    <?php if (isset($_GET['show_debug']) && defined('DEBUG_MODE') && DEBUG_MODE): ?>
    <div style="position: fixed; bottom: 10px; right: 10px; background: black; border: 2px solid magenta; padding: 20px; max-width: 600px; max-height: 400px; overflow: auto; z-index: 9999;">
        <h3 style="color: magenta;">DEBUG LOG CONTENTS:</h3>
        <pre style="color: lime; font-size: 11px;"><?php 
            if (file_exists(DEBUG_LOG)) {
                echo htmlspecialchars(file_get_contents(DEBUG_LOG));
            } else {
                echo "Debug log file not found yet.";
            }
        ?></pre>
        <button onclick="this.parentElement.style.display='none'" style="background: magenta; border: none; padding: 5px 10px; cursor: pointer; color: black;">CLOSE</button>
    </div>
    <?php endif; ?>
</body>
</html>