<?php
/**
 * Create Audit Logs Table
 * Run this file once to create the audit_logs table in your database
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

echo "Connected successfully<br>";

// Create audit_logs table
$sql = "CREATE TABLE IF NOT EXISTS `audit_logs` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) NULL,
    `username` VARCHAR(255) NULL,
    `user_email` VARCHAR(255) NULL,
    `user_role` VARCHAR(50) NULL,
    `action` VARCHAR(50) NOT NULL,
    `resource_type` VARCHAR(100) NOT NULL,
    `resource_id` INT(11) NULL,
    `resource_name` VARCHAR(255) NULL,
    `description` TEXT NULL,
    `old_values` TEXT NULL,
    `new_values` TEXT NULL,
    `ip_address` VARCHAR(45) NULL,
    `user_agent` TEXT NULL,
    `request_method` VARCHAR(10) NULL,
    `request_url` TEXT NULL,
    `status` ENUM('success', 'failed') DEFAULT 'success',
    `error_message` TEXT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`),
    KEY `username` (`username`),
    KEY `action` (`action`),
    KEY `resource_type` (`resource_type`),
    KEY `created_at` (`created_at`),
    KEY `ip_address` (`ip_address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if ($conn->query($sql) === TRUE) {
    echo "✓ Table 'audit_logs' created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

// Insert sample audit log data
$sample_data = [
    [
        'username' => 'admin',
        'user_email' => 'admin@example.com',
        'user_role' => 'Admin',
        'action' => 'LOGIN',
        'resource_type' => 'System',
        'description' => 'User logged into the system',
        'ip_address' => '192.168.1.100',
        'created_at' => date('Y-m-d H:i:s', strtotime('-2 hours'))
    ],
    [
        'username' => 'recruiter1',
        'user_email' => 'recruiter@example.com',
        'user_role' => 'Recruiter',
        'action' => 'CREATE',
        'resource_type' => 'Candidate',
        'resource_name' => 'John Doe',
        'description' => 'Created new candidate record',
        'ip_address' => '192.168.1.105',
        'created_at' => date('Y-m-d H:i:s', strtotime('-1 hour'))
    ],
    [
        'username' => 'recruiter1',
        'user_email' => 'recruiter@example.com',
        'user_role' => 'Recruiter',
        'action' => 'UPDATE',
        'resource_type' => 'Candidate',
        'resource_name' => 'Jane Smith',
        'description' => 'Updated candidate status to "Interview Scheduled"',
        'old_values' => '{"status":"Interested"}',
        'new_values' => '{"status":"Interview Scheduled"}',
        'ip_address' => '192.168.1.105',
        'created_at' => date('Y-m-d H:i:s', strtotime('-45 minutes'))
    ],
    [
        'username' => 'interviewer1',
        'user_email' => 'interviewer@example.com',
        'user_role' => 'Interviewer',
        'action' => 'DELETE',
        'resource_type' => 'Interview',
        'resource_name' => 'Interview #123',
        'description' => 'Deleted interview schedule',
        'ip_address' => '192.168.1.110',
        'created_at' => date('Y-m-d H:i:s', strtotime('-30 minutes'))
    ],
    [
        'username' => 'admin',
        'user_email' => 'admin@example.com',
        'user_role' => 'Admin',
        'action' => 'UPDATE',
        'resource_type' => 'Settings',
        'resource_name' => 'Company Settings',
        'description' => 'Updated company profile information',
        'ip_address' => '192.168.1.100',
        'created_at' => date('Y-m-d H:i:s', strtotime('-15 minutes'))
    ],
    [
        'username' => 'recruiter2',
        'user_email' => 'recruiter2@example.com',
        'user_role' => 'Recruiter',
        'action' => 'EXPORT',
        'resource_type' => 'Report',
        'resource_name' => 'Candidate Report',
        'description' => 'Exported candidate list to CSV',
        'ip_address' => '192.168.1.108',
        'created_at' => date('Y-m-d H:i:s', strtotime('-10 minutes'))
    ],
    [
        'username' => 'admin',
        'user_email' => 'admin@example.com',
        'user_role' => 'Admin',
        'action' => 'CREATE',
        'resource_type' => 'User',
        'resource_name' => 'newrecruiter@example.com',
        'description' => 'Created new recruiter account',
        'ip_address' => '192.168.1.100',
        'created_at' => date('Y-m-d H:i:s', strtotime('-5 minutes'))
    ],
    [
        'username' => 'recruiter1',
        'user_email' => 'recruiter@example.com',
        'user_role' => 'Recruiter',
        'action' => 'LOGOUT',
        'resource_type' => 'System',
        'description' => 'User logged out of the system',
        'ip_address' => '192.168.1.105',
        'created_at' => date('Y-m-d H:i:s', strtotime('-2 minutes'))
    ]
];

foreach ($sample_data as $data) {
    $columns = implode(', ', array_keys($data));
    $values = "'" . implode("', '", array_values($data)) . "'";
    $insert_sql = "INSERT INTO audit_logs ($columns) VALUES ($values)";
    
    if ($conn->query($insert_sql) === TRUE) {
        echo "✓ Sample log inserted<br>";
    } else {
        echo "Error inserting sample data: " . $conn->error . "<br>";
    }
}

echo "<br><strong>Setup Complete!</strong><br>";
echo "You can now use the audit logs system.<br>";
echo "<a href='http://localhost/rms/Setup/audit_logs'>View Audit Logs</a>";

$conn->close();
?>
