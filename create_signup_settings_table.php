<?php
/**
 * Create Signup Settings Table for Admin Access Control
 * Run: http://localhost/rms/create_signup_settings_table.php
 */

// Load CodeIgniter database configuration
require_once('application/config/database.php');

// Get database configuration
$db_config = $db['default'];
$servername = $db_config['hostname'];
$username = $db_config['username'];
$password = $db_config['password'];
$dbname = $db_config['database'];

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    echo "<h1>🚀 Creating Signup Settings Table</h1>";
    echo "<style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
        .success { color: #28a745; background: #d4edda; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .error { color: #dc3545; background: #f8d7da; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .info { color: #0c5460; background: #d1ecf1; padding: 10px; border-radius: 5px; margin: 10px 0; }
    </style>";

    // 1. Create signup_settings table
    $sql = "CREATE TABLE IF NOT EXISTS `signup_settings` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `admin_signup_enabled` TINYINT(1) DEFAULT 0 COMMENT 'Allow Admin signup',
        `recruiter_signup_enabled` TINYINT(1) DEFAULT 1 COMMENT 'Allow Recruiter signup',
        `interviewer_signup_enabled` TINYINT(1) DEFAULT 0 COMMENT 'Allow Interviewer signup',
        `candidate_signup_enabled` TINYINT(1) DEFAULT 1 COMMENT 'Allow Candidate signup',
        `auto_approve_admin` TINYINT(1) DEFAULT 0 COMMENT 'Auto-approve Admin registrations',
        `auto_approve_recruiter` TINYINT(1) DEFAULT 0 COMMENT 'Auto-approve Recruiter registrations',
        `auto_approve_interviewer` TINYINT(1) DEFAULT 0 COMMENT 'Auto-approve Interviewer registrations',
        `auto_approve_candidate` TINYINT(1) DEFAULT 1 COMMENT 'Auto-approve Candidate registrations',
        `require_email_verification` TINYINT(1) DEFAULT 1 COMMENT 'Require email verification',
        `default_signup_role` VARCHAR(50) DEFAULT 'Recruiter' COMMENT 'Default role for signup',
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `updated_by` VARCHAR(100) NULL COMMENT 'Admin who updated settings',
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Signup access control settings'";

    if ($conn->query($sql)) {
        echo "<p class='success'>✅ Table 'signup_settings' created successfully!</p>";
    } else {
        echo "<p class='error'>❌ Error creating signup_settings: " . $conn->error . "</p>";
    }

    // 2. Insert default settings
    $check_sql = "SELECT COUNT(*) as count FROM signup_settings WHERE id = 1";
    $result = $conn->query($check_sql);
    $row = $result->fetch_assoc();
    
    if ($row['count'] == 0) {
        $insert_sql = "INSERT INTO `signup_settings` (
            `id`,
            `admin_signup_enabled`,
            `recruiter_signup_enabled`, 
            `interviewer_signup_enabled`,
            `candidate_signup_enabled`,
            `auto_approve_admin`,
            `auto_approve_recruiter`,
            `auto_approve_interviewer`, 
            `auto_approve_candidate`,
            `require_email_verification`,
            `default_signup_role`,
            `updated_by`
        ) VALUES (
            1,
            0,  -- Admin signup disabled by default
            1,  -- Recruiter signup enabled
            0,  -- Interviewer signup disabled by default
            1,  -- Candidate signup enabled
            0,  -- Admin auto-approve disabled
            0,  -- Recruiter auto-approve disabled (requires admin approval)
            0,  -- Interviewer auto-approve disabled
            1,  -- Candidate auto-approve enabled
            1,  -- Email verification required
            'Recruiter',  -- Default role
            'system'
        )";
        
        if ($conn->query($insert_sql)) {
            echo "<p class='success'>✅ Default signup settings inserted successfully!</p>";
        } else {
            echo "<p class='error'>❌ Error inserting default settings: " . $conn->error . "</p>";
        }
    } else {
        echo "<p class='info'>ℹ️ Default signup settings already exist.</p>";
    }

    // 3. Add additional columns to users table if they don't exist
    $columns_to_add = array(
        'created_at' => "ALTER TABLE `users` ADD COLUMN `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP",
        'created_by' => "ALTER TABLE `users` ADD COLUMN `created_by` VARCHAR(100) NULL COMMENT 'Who created this user'",
        'approved_at' => "ALTER TABLE `users` ADD COLUMN `approved_at` TIMESTAMP NULL COMMENT 'When user was approved'",
        'approved_by' => "ALTER TABLE `users` ADD COLUMN `approved_by` VARCHAR(100) NULL COMMENT 'Admin who approved user'",
        'rejected_at' => "ALTER TABLE `users` ADD COLUMN `rejected_at` TIMESTAMP NULL COMMENT 'When user was rejected'",
        'rejected_by' => "ALTER TABLE `users` ADD COLUMN `rejected_by` VARCHAR(100) NULL COMMENT 'Admin who rejected user'",
        'rejection_reason' => "ALTER TABLE `users` ADD COLUMN `rejection_reason` TEXT NULL COMMENT 'Reason for rejection'"
    );

    foreach ($columns_to_add as $column => $sql) {
        // Check if column exists
        $check_column = "SHOW COLUMNS FROM `users` LIKE '$column'";
        $result = $conn->query($check_column);
        
        if ($result->num_rows == 0) {
            if ($conn->query($sql)) {
                echo "<p class='success'>✅ Added column '$column' to users table!</p>";
            } else {
                echo "<p class='error'>❌ Error adding column '$column': " . $conn->error . "</p>";
            }
        } else {
            echo "<p class='info'>ℹ️ Column '$column' already exists in users table.</p>";
        }
    }

    // 4. Create audit log for signup activities
    $audit_sql = "CREATE TABLE IF NOT EXISTS `signup_audit_log` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `user_id` INT(11) NULL COMMENT 'User ID if applicable',
        `username` VARCHAR(100) NULL COMMENT 'Username involved',
        `action` VARCHAR(100) NOT NULL COMMENT 'Action performed',
        `details` TEXT NULL COMMENT 'Additional details',
        `ip_address` VARCHAR(45) NULL COMMENT 'IP address',
        `user_agent` TEXT NULL COMMENT 'Browser user agent',
        `performed_by` VARCHAR(100) NULL COMMENT 'Admin who performed action',
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `user_id` (`user_id`),
        KEY `action` (`action`),
        KEY `created_at` (`created_at`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Audit log for signup activities'";

    if ($conn->query($audit_sql)) {
        echo "<p class='success'>✅ Table 'signup_audit_log' created successfully!</p>";
    } else {
        echo "<p class='error'>❌ Error creating signup_audit_log: " . $conn->error . "</p>";
    }

    echo "<hr>";
    echo "<h3 class='success'>✅ Signup Controller Setup Complete!</h3>";
    echo "<div class='info'>";
    echo "<h4>📋 What was created:</h4>";
    echo "<ul>";
    echo "<li>✅ signup_settings table with default configuration</li>";
    echo "<li>✅ Additional columns added to users table for tracking</li>";
    echo "<li>✅ signup_audit_log table for activity tracking</li>";
    echo "</ul>";
    
    echo "<h4>🎯 Next Steps:</h4>";
    echo "<ol>";
    echo "<li>Access the Signup Controller from Admin Dashboard</li>";
    echo "<li>Configure which roles can signup</li>";
    echo "<li>Set auto-approval preferences</li>";
    echo "<li>Manage pending registrations</li>";
    echo "</ol>";
    
    echo "<h4>🔗 Access URLs:</h4>";
    echo "<ul>";
    echo "<li><strong>Signup Controller:</strong> <a href='http://localhost/rms/index.php/Signup_controller' target='_blank'>http://localhost/rms/index.php/Signup_controller</a></li>";
    echo "<li><strong>Admin Dashboard:</strong> <a href='http://localhost/rms/index.php/A_dashboard' target='_blank'>http://localhost/rms/index.php/A_dashboard</a></li>";
    echo "</ul>";
    echo "</div>";

} catch (Exception $e) {
    echo "<p class='error'>❌ Error: " . $e->getMessage() . "</p>";
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?>