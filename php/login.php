<?php
/**
 * LOGIN.PHP · DECENSORWEB SECURE LOGIN
 * R-CORP ACCOUNTABILITY · ZERO TRACKING
 */

// Enable secure access
define('SECURE_ACCESS', true);

// Start session
session_start();

// Load configuration
require_once 'config.php';
require_once 'security.php';
require_once 'auth.php';

// Redirect if already logged in
if (Auth::isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

// Handle login form submission
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!validateCSRFToken($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid security token · R-CORP protection';
    } else {
        $login = $_POST['login'] ?? '';
        $password = $_POST['password'] ?? '';
        $remember = isset($_POST['remember']);
        
        $auth = new Auth();
        $result = $auth->login($login, $password, $remember);
        
        if ($result['success']) {
            $_SESSION['login_success'] = true;
            header('Location: dashboard.php');
            exit;
        } else {
            $error = $result['message'];
        }
    }
}

// Generate CSRF token
$csrf_token = generateCSRFToken();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>LOGIN · DECENSORWEB · R-CORP</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="../css/roadmap.css">
    <link rel="stylesheet" href="../css/login.css">
    
    <!-- Favicon -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' fill='%23000000'/><text x='20' y='70' font-size='70' fill='%23ff0000'>⛧</text></svg>">
</head>
<body>
    <div class="login-container">
        <!-- MAP CORNERS -->
        <div class="map-corner top-left"></div>
        <div class="map-corner top-right"></div>
        <div class="map-corner bottom-left"></div>
        <div class="map-corner bottom-right"></div>
        
        <!-- HEADER -->
        <div class="login-header">
            <span class="insignia">⛧</span>
            <h1 class="login-title">SECURE LOGIN</h1>
            <span class="insignia">⛧</span>
        </div>
        
        <div class="doctrine-banner">
            <span class="doctrine-text"><?php echo R_CORP_DOCTRINE; ?></span>
        </div>
        
        <!-- LOGIN FORM -->
        <form method="POST" action="login.php" class="login-form">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            
            <?php if ($error): ?>
                <div class="alert error">⛔ <?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert success">✓ <?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            
            <div class="form-group">
                <label for="login" class="form-label">USERNAME OR EMAIL</label>
                <input type="text" 
                       id="login" 
                       name="login" 
                       class="form-input" 
                       placeholder="Enter your username or email"
                       required 
                       autofocus
                       autocomplete="username">
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">PASSWORD</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       class="form-input" 
                       placeholder="Enter your password"
                       required
                       autocomplete="current-password">
            </div>
            
            <div class="form-group form-checkbox">
                <input type="checkbox" id="remember" name="remember" class="checkbox-input">
                <label for="remember" class="checkbox-label">Remember this device (30 days)</label>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="login-button">⚡ LOGIN ⚡</button>
            </div>
        </form>
        
        <!-- LINKS -->
        <div class="login-links">
            <a href="register.php" class="auth-link">Create account</a>
            <span class="link-separator">|</span>
            <a href="forgot.php" class="auth-link">Reset password</a>
        </div>
        
        <!-- R-CORP ACCOUNTABILITY -->
        <div class="accountability-footer">
            <div class="footer-doctrine">
                <span class="doctrine-short">R-CORP · PARENT COMPANY · FULL ACCOUNTABILITY</span>
            </div>
            <div class="footer-nav">
                <a href="../index.html" class="back-btn">← MAIN TERMINAL</a>
                <a href="../navigate.php" class="back-btn">← NAVIGATION HUB</a>
            </div>
        </div>
        
        <!-- FINGERPRINT -->
        <div class="login-fingerprint">
            <span class="fingerprint">[<?php echo substr(hash('sha256', $_SERVER['REMOTE_ADDR'] ?? ''), 0, 8); ?>]</span>
        </div>
    </div>
    
    <!-- JavaScript -->
    <script src="../js/login.js" defer></script>
</body>
</html>