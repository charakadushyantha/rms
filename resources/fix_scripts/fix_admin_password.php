<?php
// Script to fix admin user password to use MD5
// DELETE THIS FILE AFTER USE!

// Define BASEPATH for CodeIgniter compatibility
define('BASEPATH', dirname(__FILE__) . '/system/');
define('APPPATH', dirname(__FILE__) . '/application/');

// Load CodeIgniter environment
require_once('application/config/environment.php');

echo "<h2>Fix Admin User Password</h2>";

// Use constants if defined, otherwise use production values directly
$hostname = defined('DB_HOSTNAME') ? DB_HOSTNAME : 'localhost';
$username = defined('DB_USERNAME') ? DB_USERNAME : 'cmsadver_rmsdbuser';
$password = defined('DB_PASSWORD') ? DB_PASSWORD : 'Charaka@321';
$database = defined('DB_DATABASE') ? DB_DATABASE : 'cmsadver_rmsdb';

try {
    $conn = new mysqli($hostname, $username, $password, $database);
    
    if ($conn->connect_error) {
        die("❌ Connection failed: " . $conn->connect_error);
    }
    
    echo "✅ Connected to database<br><br>";
    
    // Check current admin user
    $result = $conn->query("SELECT u_id, u_username, u_email, u_role, u_password FROM users WHERE u_username = 'admin'");
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo "<h3>Current Admin User:</h3>";
        echo "Username: <strong>" . $user['u_username'] . "</strong><br>";
        echo "Email: " . $user['u_email'] . "<br>";
        echo "Role: " . $user['u_role'] . "<br>";
        echo "Current password hash: " . substr($user['u_password'], 0, 30) . "...<br><br>";
        
        // Update password to MD5
        $new_password = 'admin123';
        $md5_password = md5($new_password);
        
        $stmt = $conn->prepare("UPDATE users SET u_password = ? WHERE u_username = 'admin'");
        $stmt->bind_param("s", $md5_password);
        
        if ($stmt->execute()) {
            echo "<h3 style='color:green;'>✅ Password Updated Successfully!</h3>";
            echo "<div style='background:#e8f5e9; padding:15px; border:1px solid #4caf50; margin:10px 0;'>";
            echo "<strong>Login Credentials:</strong><br>";
            echo "Username: <strong>admin</strong><br>";
            echo "Password: <strong>admin123</strong><br>";
            echo "</div>";
            
            echo "<h3>Next Steps:</h3>";
            echo "<ol>";
            echo "<li>Go to: <a href='https://rms.lankantech.com/' target='_blank'>https://rms.lankantech.com/</a></li>";
            echo "<li>Login with: <strong>admin</strong> / <strong>admin123</strong></li>";
            echo "<li>Change the password after login</li>";
            echo "<li><strong>DELETE this file (fix_admin_password.php) immediately!</strong></li>";
            echo "</ol>";
        } else {
            echo "❌ Error updating password: " . $stmt->error . "<br>";
        }
        $stmt->close();
    } else {
        echo "❌ Admin user not found. Creating new admin user...<br><br>";
        
        // Create admin user with MD5 password
        $admin_username = 'admin';
        $admin_password = md5('admin123');
        $admin_email = 'admin@lankantech.com';
        $admin_role = 'Admin';
        $admin_status = 'Active';
        
        $stmt = $conn->prepare("INSERT INTO users (u_username, u_password, u_email, u_role, u_status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $admin_username, $admin_password, $admin_email, $admin_role, $admin_status);
        
        if ($stmt->execute()) {
            echo "✅ Admin user created successfully!<br><br>";
            echo "<div style='background:#e8f5e9; padding:15px; border:1px solid #4caf50; margin:10px 0;'>";
            echo "<strong>Login Credentials:</strong><br>";
            echo "Username: <strong>admin</strong><br>";
            echo "Password: <strong>admin123</strong><br>";
            echo "</div>";
        } else {
            echo "❌ Error creating admin user: " . $stmt->error . "<br>";
        }
        $stmt->close();
    }
    
    $conn->close();
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

echo "<br><p style='background:#ffe6e6; padding:10px; border:1px solid #ff0000;'>";
echo "<strong>⚠️ SECURITY WARNING:</strong> Delete this file immediately after use!";
echo "</p>";
?>
