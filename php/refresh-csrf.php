<?php
/**
 * REFRESH-CSRF.PHP · AJAX CSRF Token Refresh
 * R-CORP SECURITY · PREVENT TOKEN EXPIRATION
 */

define('SECURE_ACCESS', true);
session_start();

// Only accept AJAX requests
if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || 
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
    http_response_code(403);
    exit('Direct access forbidden');
}

// Generate new CSRF token
$new_token = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $new_token;
$_SESSION['csrf_token_time'] = time();

// Return JSON response
header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'token' => $new_token,
    'doctrine' => 'R-CORP · CSRF protection active'
]);