<?php
/**
 * TEST_REGISTRATION.PHP · Debug Registration Issues
 * Run this to test if database insertion works
 */

define('SECURE_ACCESS', true);
session_start();
require_once '../php/config.php';
require_once '../php/database.php';
require_once '../php//security.php';
require_once '../php//auth.php';

echo "<!DOCTYPE html>
<html>
<head>
    <title>Registration Test · R-CORP</title>
    <style>
        body { background: #0a0a0a; color: #dddddd; font-family: monospace; padding: 20px; }
        .success { color: #55ff55; }
        .error { color: #ff5555; }
        .info { color: #ffff55; }
        pre { background: #1a1a1a; padding: 10px; border-left: 4px solid #8b0000; overflow: auto; }
        table { border-collapse: collapse; width: 100%; }
        td, th { border: 1px solid #8b0000; padding: 8px; text-align: left; }
        th { background: #1a0000; }
    </style>
</head>
<body>
    <h1>🔧 R-CORP Registration Debug Tool</h1>";

// Test database connection first
try {
    $db = Database::getConnection();
    echo "<p class='success'>✅ Database connected successfully</p>";
    
    // Check if users table exists
    $tables = $db->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "<p>📋 Tables in database: " . implode(', ', $tables) . "</p>";
    
    if (!in_array('users', $tables)) {
        echo "<p class='error'>❌ users table does not exist! Run the SQL schema.</p>";
    } else {
        // Show table structure
        $columns = $db->query("DESCRIBE users")->fetchAll();
        echo "<h3>📊 Users Table Structure:</h3>";
        echo "<table>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
        foreach ($columns as $col) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($col['Field']) . "</td>";
            echo "<td>" . htmlspecialchars($col['Type']) . "</td>";
            echo "<td>" . htmlspecialchars($col['Null']) . "</td>";
            echo "<td>" . htmlspecialchars($col['Key']) . "</td>";
            echo "<td>" . htmlspecialchars($col['Default'] ?? 'NULL') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
} catch (Exception $e) {
    echo "<p class='error'>❌ Database error: " . htmlspecialchars($e->getMessage()) . "</p>";
}

// Test registration if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<h2>🔬 Testing Registration:</h2>";
    
    $test_username = 'testuser_' . rand(1000, 9999);
    $test_email = 'test_' . rand(1000, 9999) . '@example.com';
    $test_password = 'TestPass123!';
    
    echo "<pre>";
    echo "Username: $test_username\n";
    echo "Email: $test_email\n";
    echo "Password: $test_password\n";
    echo "</pre>";
    
    $auth = new Auth();
    $result = $auth->register($test_username, $test_email, $test_password);
    
    if ($result['success']) {
        echo "<p class='success'>✅ Registration SUCCESSFUL!</p>";
        echo "<pre>";
        print_r($result);
        echo "</pre>";
        
        // Verify user was inserted
        try {
            $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$test_email]);
            $user = $stmt->fetch();
            
            if ($user) {
                echo "<p class='success'>✅ User found in database:</p>";
                echo "<pre>";
                echo "ID: " . $user['id'] . "\n";
                echo "Username: " . $user['username'] . "\n";
                echo "Email: " . $user['email'] . "\n";
                echo "Created: " . $user['created_at'] . "\n";
                echo "Doctrine: " . ($user['doctrine_accepted'] ? 'Accepted' : 'Not accepted') . "\n";
                echo "</pre>";
            }
        } catch (Exception $e) {
            echo "<p class='error'>❌ Verification error: " . $e->getMessage() . "</p>";
        }
        
    } else {
        echo "<p class='error'>❌ Registration FAILED:</p>";
        echo "<pre class='error'>";
        print_r($result);
        echo "</pre>";
    }
}

?>

<!-- Manual test form -->
<h2>🧪 Manual Registration Test</h2>
<form method="POST" style="background: #1a1a1a; padding: 20px; border: 1px solid #8b0000;">
    <button type="submit" style="background: #8b0000; color: white; padding: 10px 20px; border: none; font-family: monospace; cursor: pointer;">
        🔬 RUN REGISTRATION TEST
    </button>
    <p style="color: #aaaaaa; margin-top: 10px;">This will create a random test user in the database.</p>
</form>

<h2>📋 Current Users in Database</h2>
<?php
try {
    $users = $db->query("SELECT id, username, email, created_at, doctrine_accepted FROM users ORDER BY id DESC LIMIT 10")->fetchAll();
    
    if (count($users) > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Created</th><th>Doctrine</th></tr>";
        foreach ($users as $user) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($user['id']) . "</td>";
            echo "<td>" . htmlspecialchars($user['username']) . "</td>";
            echo "<td>" . htmlspecialchars($user['email']) . "</td>";
            echo "<td>" . htmlspecialchars($user['created_at']) . "</td>";
            echo "<td>" . ($user['doctrine_accepted'] ? '✓' : '✗') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No users found in database.</p>";
    }
} catch (Exception $e) {
    echo "<p class='error'>Error loading users: " . $e->getMessage() . "</p>";
}
?>

</body>
</html>