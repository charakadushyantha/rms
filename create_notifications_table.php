<?php
/**
 * Create Notifications Table
 * Run this file once to create the notifications table in your database
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

// Create notifications table
$sql = "CREATE TABLE IF NOT EXISTS `notifications` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) NULL COMMENT 'NULL for system-wide notifications',
    `type` VARCHAR(50) NOT NULL COMMENT 'candidate, interview, job, system',
    `title` VARCHAR(255) NOT NULL,
    `message` TEXT NOT NULL,
    `link` VARCHAR(500) NULL,
    `is_read` TINYINT(1) DEFAULT 0,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `read_at` DATETIME NULL,
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`),
    KEY `is_read` (`is_read`),
    KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if ($conn->query($sql) === TRUE) {
    echo "✓ Table 'notifications' created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

// Insert sample notifications
$sample_notifications = [
    [
        'user_id' => NULL,
        'type' => 'system',
        'title' => 'Welcome to Enhanced Dashboard',
        'message' => 'New UI/UX improvements have been added including search and notifications!',
        'link' => 'http://localhost/rms/A_dashboard',
        'created_at' => date('Y-m-d H:i:s', strtotime('-5 minutes'))
    ],
    [
        'user_id' => NULL,
        'type' => 'candidate',
        'title' => 'New Candidate Application',
        'message' => 'A new candidate has applied for the Software Engineer position',
        'link' => 'http://localhost/rms/A_dashboard/Acandidate_users_view',
        'created_at' => date('Y-m-d H:i:s', strtotime('-1 hour'))
    ],
    [
        'user_id' => NULL,
        'type' => 'interview',
        'title' => 'Interview Reminder',
        'message' => 'You have an interview scheduled for tomorrow at 2:00 PM',
        'link' => 'http://localhost/rms/A_dashboard/Ainterviewer_view',
        'created_at' => date('Y-m-d H:i:s', strtotime('-2 hours'))
    ],
    [
        'user_id' => NULL,
        'type' => 'job',
        'title' => 'Job Posting Expiring Soon',
        'message' => 'Your job posting for Senior Developer will expire in 3 days',
        'link' => 'http://localhost/rms/A_dashboard/Ajob_post_view',
        'created_at' => date('Y-m-d H:i:s', strtotime('-3 hours'))
    ],
    [
        'user_id' => NULL,
        'type' => 'system',
        'title' => 'Audit Logs Available',
        'message' => 'Track all system activities with the new audit log feature',
        'link' => 'http://localhost/rms/Setup/audit_logs',
        'created_at' => date('Y-m-d H:i:s', strtotime('-5 hours'))
    ]
];

foreach ($sample_notifications as $notif) {
    $user_id = $notif['user_id'] === NULL ? 'NULL' : $notif['user_id'];
    $insert_sql = "INSERT INTO notifications (user_id, type, title, message, link, created_at) 
                   VALUES ($user_id, '{$notif['type']}', '{$notif['title']}', '{$notif['message']}', '{$notif['link']}', '{$notif['created_at']}')";
    
    if ($conn->query($insert_sql) === TRUE) {
        echo "✓ Sample notification inserted<br>";
    } else {
        echo "Error inserting sample data: " . $conn->error . "<br>";
    }
}

echo "<br><strong>Setup Complete!</strong><br>";
echo "The notifications system is now ready to use.<br>";
echo "<a href='http://localhost/rms/A_dashboard'>Go to Dashboard</a>";

$conn->close();
?>
