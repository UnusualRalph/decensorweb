<?php
define('SECURE_ACCESS', true);
require '../php/config.php';

echo "<h1>Test Database Insert</h1>";

try {
    // Test data
    $username = 'testuser_' . rand(1000, 9999);
    $email = 'test' . rand(1000, 9999) . '@example.com';
    $password_hash = password_hash('test123', PASSWORD_DEFAULT);
    
    echo "<p>Attempting to insert: $username - $email</p>";
    
    $sql = "INSERT INTO users (
        username, email, password_hash, doctrine_accepted, 
        created_at, updated_at, is_banned, login_attempts
    ) VALUES (?, ?, ?, 1, NOW(), NOW(), 0, 0)";
    
    $stmt = $db->prepare($sql);
    $result = $stmt->execute([$username, $email, $password_hash]);
    
    if ($result) {
        $id = $db->lastInsertId();
        echo "<p style='color:green'>✓ SUCCESS! Inserted with ID: $id</p>";
        
        // Show the inserted record
        $check = $db->prepare("SELECT * FROM users WHERE id = ?");
        $check->execute([$id]);
        $user = $check->fetch(PDO::FETCH_ASSOC);
        
        echo "<pre>";
        print_r($user);
        echo "</pre>";
    } else {
        echo "<p style='color:red'>✗ Insert failed</p>";
        print_r($stmt->errorInfo());
    }
    
} catch (PDOException $e) {
    echo "<p style='color:red'>Error: " . $e->getMessage() . "</p>";
}
?>