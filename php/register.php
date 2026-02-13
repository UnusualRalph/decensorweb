<?php
/**
 * REGISTER.PHP · CREATE ACCOUNT
 * FIXED: Better error handling and debugging
 */

define('SECURE_ACCESS', true);
session_start();
require_once 'config.php';
require_once 'includes/security.php';
require_once 'includes/auth.php';

if (Auth::isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF
    if (!validateCSRFToken($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid security token · R-CORP protection';
    } else {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';
        $doctrine = isset($_POST['doctrine']);
        
        // Validate
        if (!$doctrine) {
            $error = 'You must accept the R-CORP accountability doctrine';
        } elseif ($password !== $confirm) {
            $error = 'Passwords do not match';
        } elseif (strlen($password) < 8) {
            $error = 'Password must be at least 8 characters';
        } else {
            $auth = new Auth();
            $result = $auth->register($username, $email, $password);
            
            if ($result['success']) {
                $success = 'Account created! You can now login.';
                // Clear form
                $_POST = [];
                
                // Optional: Auto-redirect after 3 seconds
                header('refresh:3;url=login.php');
            } else {
                $error = $result['message'];
                
                // Show debug info if in development
                if (defined('DEBUG_MODE') && DEBUG_MODE && isset($result['debug'])) {
                    $error .= ' <!-- DEBUG: ' . htmlspecialchars($result['debug']) . ' -->';
                }
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
    <link rel="stylesheet" href="css/roadmap.css">
    <link rel="stylesheet" href="css/login.css">
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
                       required>
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
                <input type="checkbox" id="doctrine" name="doctrine" class="checkbox-input" required>
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
                <a href="index.html" class="back-btn">← MAIN TERMINAL</a>
                <a href="navigate.php" class="back-btn">← NAVIGATION HUB</a>
            </div>
        </div>
    </div>
    
    <script src="js/login.js" defer></script>
</body>
</html>