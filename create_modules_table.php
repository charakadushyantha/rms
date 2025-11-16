<?php
/**
 * Create custom_modules table for Module Manager
 * Run this file once to create the table
 */

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'rmsdb';

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to create table
$sql = "CREATE TABLE IF NOT EXISTS `custom_modules` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(100) NOT NULL,
    `section` varchar(50) NOT NULL,
    `icon` varchar(100) NOT NULL,
    `url` varchar(255) NOT NULL,
    `order_num` int(11) DEFAULT 10,
    `is_active` tinyint(1) DEFAULT 1,
    `show_badge` tinyint(1) DEFAULT 0,
    `badge_text` varchar(20) DEFAULT 'NEW',
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "✅ Table 'custom_modules' created successfully!<br>";
    
    // Insert sample data
    $sample_sql = "INSERT INTO `custom_modules` (`name`, `section`, `icon`, `url`, `order_num`, `is_active`, `show_badge`) VALUES
    ('Training', 'CUSTOM', 'fas fa-graduation-cap', 'A_dashboard/training_view', 5, 1, 1),
    ('Documents', 'CUSTOM', 'fas fa-file-alt', 'A_dashboard/documents_view', 6, 1, 0);";
    
    if ($conn->query($sample_sql) === TRUE) {
        echo "✅ Sample modules added successfully!<br>";
    } else {
        echo "⚠️ Sample data: " . $conn->error . "<br>";
    }
    
} else {
    echo "❌ Error creating table: " . $conn->error . "<br>";
}

// Create module_visibility table
$visibility_sql = "CREATE TABLE IF NOT EXISTS `module_visibility` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `module_key` varchar(50) NOT NULL UNIQUE,
    `is_visible` tinyint(1) DEFAULT 1,
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($visibility_sql) === TRUE) {
    echo "✅ Table 'module_visibility' created successfully!<br>";
    
    // Insert default visibility settings
    $default_visibility = "INSERT IGNORE INTO `module_visibility` (`module_key`, `is_visible`) VALUES
    ('dashboard', 1),
    ('candidates', 1),
    ('calendar', 1),
    ('analytics', 1),
    ('recruiters', 1),
    ('interviewers', 1),
    ('candidate_users', 1),
    ('reports', 1),
    ('roles', 1),
    ('setup', 1),
    ('account', 1);";
    
    if ($conn->query($default_visibility) === TRUE) {
        echo "✅ Default visibility settings added!<br>";
    }
} else {
    echo "❌ Error creating visibility table: " . $conn->error . "<br>";
}

$conn->close();

echo "<br><br>";
echo "<div style='padding: 20px; background: #d1fae5; border: 2px solid #10b981; border-radius: 8px; margin: 20px;'>";
echo "<h3 style='color: #065f46; margin: 0 0 10px 0;'>✅ Setup Complete!</h3>";
echo "<p style='color: #065f46; margin: 0;'>The custom_modules table has been created successfully.</p>";
echo "<p style='color: #065f46; margin: 10px 0 0 0;'>You can now use the Module Manager to add custom modules to your sidebar.</p>";
echo "</div>";

echo "<div style='padding: 20px; margin: 20px;'>";
echo "<a href='index.php' style='display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 6px; margin-right: 10px;'>← Back to Home</a>";
echo "<a href='Setup/module_manager' style='display: inline-block; padding: 10px 20px; background: #10b981; color: white; text-decoration: none; border-radius: 6px;'>Open Module Manager →</a>";
echo "</div>";
?>
