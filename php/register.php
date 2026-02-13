<?php
/**
 * REGISTER.PHP · CREATE ACCOUNT
 * R-CORP ACCOUNTABILITY · ZERO DATA MINING
 */

define('SECURE_ACCESS', true);
session_start();
require_once 'config.php';
require_once 'security.php';
require_once 'auth.php';

if (Auth::isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCSRFToken($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid security token · R-CORP protection';
    } else {
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';
        $doctrine = isset($_POST['doctrine']);
        
        // Validate
        if (!$doctrine) {
            $error = 'You must accept the R-CORP accountability doctrine';
        } elseif ($password !== $confirm) {
            $error = 'Passwords do not match';
        } else {
            $auth = new Auth();
            $result = $auth->register($username, $email, $password);
            
            if ($result['success']) {
                $success = 'Account created! You can now login.';
                // Clear form
                $_POST = [];
            } else {
                $error = $result['message'];
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
        
        <form method="POST" action="register.php" class="login-form">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            
            <?php if ($error): ?>
                <div class="alert error">⛔ <?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert success">✓ <?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            
            <div class="form-group">
                <label for="username" class="form-label" required>USERNAME</label>
                <input type="text" id="username" name="username" class="form-input" 
                       value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"
                       required minlength="3" maxlength="50" autofocus>
            </div>
            
            <div class="form-group">
                <label for="email" class="form-label" type="email" required>EMAIL ADDRESS</label>
                <input type="email" id="email" name="email" class="form-input"
                       value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                       required>
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">PASSWORD (min 8 chars)</label>
                <input type="password" id="password" name="password" class="form-input"
                       required minlength="8">
            </div>
            
            <div class="form-group">
                <label for="confirm_password" class="form-label">CONFIRM PASSWORD</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-input"
                       required minlength="8">
            </div>
            
            <div class="form-group form-checkbox">
                <input type="checkbox" id="doctrine" name="doctrine" class="checkbox-input" required>
                <label for="doctrine" class="checkbox-label">
                    I accept the R-CORP accountability doctrine · WE DO NOT SELL · WE DO NOT LOG
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
    
    <script src="../js/login.js" defer></script>
</body>
</html>