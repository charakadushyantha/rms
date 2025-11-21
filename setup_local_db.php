<?php
// Local Database Setup Script
// Run this ONLY on localhost to set up your local database
// DELETE THIS FILE after setup!

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Local Database Setup</h2>";

// Check if running on localhost
if (!in_array($_SERVER['HTTP_HOST'], ['localhost', '127.0.0.1', 'localhost:80', 'localhost:8080'])) {
    die("<p style='color:red;'>⚠️ This script should only be run on localhost!</p>");
}

echo "<p>Setting up local database...</p>";

// Local database credentials
$hostname = 'localhost';
$username = 'root';
$password = ''; // Default XAMPP/WAMP password is empty
$database = 'cmsadver_rmsdb';

try {
    // Connect to MySQL (without selecting database first)
    $conn = new mysqli($hostname, $username, $password);
    
    if ($conn->connect_error) {
        die("❌ Connection failed: " . $conn->connect_error . "<br>Make sure MySQL is running!");
    }
    
    echo "✅ Connected to MySQL<br>";
    
    // Create database if it doesn't exist
    $sql = "CREATE DATABASE IF NOT EXISTS $database CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    if ($conn->query($sql) === TRUE) {
        echo "✅ Database '$database' created or already exists<br>";
    } else {
        echo "❌ Error creating database: " . $conn->error . "<br>";
    }
    
    // Select the database
    $conn->select_db($database);
    
    // Check if users table exists
    $result = $conn->query("SHOW TABLES LIKE 'users'");
    
    if ($result->num_rows == 0) {
        echo "<br><h3>Creating users table...</h3>";
        
        // Create users table
        $create_table = "CREATE TABLE users (
            u_id INT AUTO_INCREMENT PRIMARY KEY,
            u_username VARCHAR(100) NOT NULL UNIQUE,
            u_password VARCHAR(255) NOT NULL,
            u_email VARCHAR(255) NOT NULL,
            u_role VARCHAR(50) NOT NULL,
            u_status VARCHAR(50) DEFAULT 'Active',
            profile_picture VARCHAR(255) NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        
        if ($conn->query($create_table) === TRUE) {
            echo "✅ Users table created<br>";
        } else {
            echo "❌ Error creating table: " . $conn->error . "<br>";
        }
    } else {
        echo "✅ Users table already exists<br>";
    }
    
    // Check if admin user exists
    $result = $conn->query("SELECT * FROM users WHERE u_username = 'admin'");
    
    if ($result->num_rows == 0) {
        echo "<br><h3>Creating admin user...</h3>";
        
        // Create admin user with MD5 password
        $admin_username = 'admin';
        $admin_password = md5('admin123');
        $admin_email = 'admin@localhost';
        $admin_role = 'Admin';
        $admin_status = 'Active';
        
        $stmt = $conn->prepare("INSERT INTO users (u_username, u_password, u_email, u_role, u_status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $admin_username, $admin_password, $admin_email, $admin_role, $admin_status);
        
        if ($stmt->execute()) {
            echo "✅ Admin user created successfully!<br>";
        } else {
            echo "❌ Error creating admin user: " . $stmt->error . "<br>";
        }
        $stmt->close();
    } else {
        echo "✅ Admin user already exists<br>";
    }
    
    // Show current users
    echo "<br><h3>Current Users:</h3>";
    $result = $conn->query("SELECT u_id, u_username, u_email, u_role, u_status FROM users");
    
    if ($result->num_rows > 0) {
        echo "<table border='1' style='border-collapse:collapse;'>";
        echo "<tr style='background:#f0f0f0;'><th style='padding:8px;'>ID</th><th style='padding:8px;'>Username</th><th style='padding:8px;'>Email</th><th style='padding:8px;'>Role</th><th style='padding:8px;'>Status</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td style='padding:8px;'>".$row['u_id']."</td>";
            echo "<td style='padding:8px;'><strong>".$row['u_username']."</strong></td>";
            echo "<td style='padding:8px;'>".$row['u_email']."</td>";
            echo "<td style='padding:8px;'>".$row['u_role']."</td>";
            echo "<td style='padding:8px;'>".$row['u_status']."</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    $conn->close();
    
    echo "<br><div style='background:#e8f5e9; padding:15px; border:1px solid #4caf50; margin:10px 0;'>";
    echo "<h3 style='color:green;'>✅ Local Setup Complete!</h3>";
    echo "<p><strong>Login Credentials:</strong></p>";
    echo "<p>Username: <strong>admin</strong><br>";
    echo "Password: <strong>admin123</strong></p>";
    echo "<p>Access your site at: <a href='http://localhost/rms/'>http://localhost/rms/</a></p>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

echo "<br><p style='background:#ffe6e6; padding:10px; border:1px solid #ff0000;'>";
echo "<strong>⚠️ SECURITY:</strong> Delete this file (setup_local_db.php) after setup!";
echo "</p>";
?>
