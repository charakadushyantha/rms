<?php
/**
 * Simple Signup Controller Setup
 * Run: http://localhost/rms/simple_setup.php
 */

// Direct database connection - Update these if needed
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cmsadver_rmsdb";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    echo "<!DOCTYPE html><html><head><title>Setup Signup Controller</title>";
    echo "<style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; max-width: 800px; margin: 0 auto; }
        .success { color: #28a745; background: #d4edda; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .error { color: #dc3545; background: #f8d7da; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .info { color: #0c5460; background: #d1ecf1; padding: 10px; border-radius: 5px; margin: 10px 0; }
        h1 { color: #333; }
        .btn { display: inline-block; padding: 10px 20px; margin: 10px 5px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; }
        .btn:hover { background: #0056b3; }
    </style></head><body>";
    
    echo "<h1>🚀 Signup Controller Setup</h1>";
    echo "<p class='info'>📊 <strong>Database:</strong> $dbname on $servername</p>";

    $errors = 0;
    $success = 0;

    // 1. Create signup_settings table
    echo "<h3>Creating signup_settings table...</h3>";
    $sql = "CREATE TABLE IF NOT EXISTS `signup_settings` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `admin_signup_enabled` TINYINT(1) DEFAULT 0,
        `recruiter_signup_enabled` TINYINT(1) DEFAULT 1,
        `interviewer_signup_enabled` TINYINT(1) DEFAULT 0,
        `candidate_signup_enabled` TINYINT(1) DEFAULT 1,
        `auto_approve_admin` TINYINT(1) DEFAULT 0,
        `auto_approve_recruiter` TINYINT(1) DEFAULT 0,
        `auto_approve_interviewer` TINYINT(1) DEFAULT 0,
        `auto_approve_candidate` TINYINT(1) DEFAULT 1,
        `require_email_verification` TINYINT(1) DEFAULT 1,
        `default_signup_role` VARCHAR(50) DEFAULT 'Recruiter',
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `updated_by` VARCHAR(100) NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

    if ($conn->query($sql)) {
        echo "<p class='success'>✅ Table 'signup_settings' created successfully!</p>";
        $success++;
    } else {
        echo "<p class='error'>❌ Error: " . $conn->error . "</p>";
        $errors++;
    }

    // 2. Insert default settings
    echo "<h3>Inserting default settings...</h3>";
    $check_sql = "SELECT COUNT(*) as count FROM signup_settings WHERE id = 1";
    $result = $conn->query($check_sql);
    $row = $result->fetch_assoc();
    
    if ($row['count'] == 0) {
        $insert_sql = "INSERT INTO `signup_settings` (
            `id`, `admin_signup_enabled`, `recruiter_signup_enabled`, 
            `interviewer_signup_enabled`, `candidate_signup_enabled`,
            `auto_approve_admin`, `auto_approve_recruiter`,
            `auto_approve_interviewer`, `auto_approve_candidate`,
            `require_email_verification`, `default_signup_role`, `updated_by`
        ) VALUES (
            1, 0, 1, 0, 1, 0, 0, 0, 1, 1, 'Recruiter', 'system'
        )";
        
        if ($conn->query($insert_sql)) {
            echo "<p class='success'>✅ Default settings inserted!</p>";
            $success++;
        } else {
            echo "<p class='error'>❌ Error: " . $conn->error . "</p>";
            $errors++;
        }
    } else {
        echo "<p class='info'>ℹ️ Default settings already exist.</p>";
    }

    // 3. Create signup_audit_log table
    echo "<h3>Creating signup_audit_log table...</h3>";
    $audit_sql = "CREATE TABLE IF NOT EXISTS `signup_audit_log` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `user_id` INT(11) NULL,
        `username` VARCHAR(100) NULL,
        `action` VARCHAR(100) NOT NULL,
        `details` TEXT NULL,
        `ip_address` VARCHAR(45) NULL,
        `user_agent` TEXT NULL,
        `performed_by` VARCHAR(100) NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `user_id` (`user_id`),
        KEY `action` (`action`),
        KEY `created_at` (`created_at`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

    if ($conn->query($audit_sql)) {
        echo "<p class='success'>✅ Table 'signup_audit_log' created!</p>";
        $success++;
    } else {
        echo "<p class='error'>❌ Error: " . $conn->error . "</p>";
        $errors++;
    }

    // 4. Add columns to users table
    echo "<h3>Enhancing users table...</h3>";
    $columns = array(
        'created_at' => "ALTER TABLE `users` ADD COLUMN `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP",
        'created_by' => "ALTER TABLE `users` ADD COLUMN `created_by` VARCHAR(100) NULL",
        'approved_at' => "ALTER TABLE `users` ADD COLUMN `approved_at` TIMESTAMP NULL",
        'approved_by' => "ALTER TABLE `users` ADD COLUMN `approved_by` VARCHAR(100) NULL",
        'rejected_at' => "ALTER TABLE `users` ADD COLUMN `rejected_at` TIMESTAMP NULL",
        'rejected_by' => "ALTER TABLE `users` ADD COLUMN `rejected_by` VARCHAR(100) NULL",
        'rejection_reason' => "ALTER TABLE `users` ADD COLUMN `rejection_reason` TEXT NULL"
    );

    foreach ($columns as $column => $sql) {
        $check = "SHOW COLUMNS FROM `users` LIKE '$column'";
        $result = $conn->query($check);
        
        if ($result->num_rows == 0) {
            if ($conn->query($sql)) {
                echo "<p class='success'>✅ Added column '$column'</p>";
                $success++;
            } else {
                echo "<p class='error'>❌ Error adding '$column': " . $conn->error . "</p>";
                $errors++;
            }
        } else {
            echo "<p class='info'>ℹ️ Column '$column' already exists</p>";
        }
    }

    echo "<hr>";
    
    if ($errors == 0) {
        echo "<h2 class='success'>🎉 Setup Complete!</h2>";
        echo "<p>All database tables and columns have been created successfully.</p>";
        echo "<h3>Next Steps:</h3>";
        echo "<ol>";
        echo "<li>Login to your RMS as Admin</li>";
        echo "<li>Navigate to <strong>Settings → Signup Controller</strong></li>";
        echo "<li>Configure your signup preferences</li>";
        echo "</ol>";
        echo "<a href='index.php/Signup_controller' class='btn'>Access Signup Controller</a>";
        echo "<a href='index.php/A_dashboard' class='btn'>Go to Admin Dashboard</a>";
    } else {
        echo "<h2 class='error'>⚠️ Setup completed with $errors error(s)</h2>";
        echo "<p>Please check the errors above and try again.</p>";
        echo "<a href='simple_setup.php' class='btn'>Retry Setup</a>";
    }

    echo "</body></html>";

} catch (Exception $e) {
    echo "<!DOCTYPE html><html><head><title>Setup Error</title></head><body>";
    echo "<h1 style='color: red;'>❌ Error</h1>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<p><strong>Please check:</strong></p>";
    echo "<ul>";
    echo "<li>XAMPP MySQL is running</li>";
    echo "<li>Database name is correct: <strong>cmsadver_rmsdb</strong></li>";
    echo "<li>Database user has proper permissions</li>";
    echo "</ul>";
    echo "</body></html>";
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?>