<?php
/**
 * Events & Employee Advocacy - Database Setup
 * Run: http://localhost/rms/create_events_advocacy_tables.php
 */

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'rmsdb';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>Events & Employee Advocacy - Database Setup</h2>";
echo "<style>
    body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
    .success { color: green; padding: 10px; background: #d4edda; margin: 10px 0; border-radius: 5px; }
    .info { color: #0c5460; padding: 10px; background: #d1ecf1; margin: 10px 0; border-radius: 5px; }
</style>";

$tables_created = 0;

// 1. Recruitment Events
$sql = "CREATE TABLE IF NOT EXISTS `recruitment_events` (
    `event_id` int(11) NOT NULL AUTO_INCREMENT,
    `event_name` varchar(255) NOT NULL,
    `event_type` varchar(50) NOT NULL,
    `description` text,
    `event_date` date NOT NULL,
    `start_time` time,
    `end_time` time,
    `location` varchar(255),
    `venue_type` varchar(50) DEFAULT 'Physical',
    `virtual_link` varchar(500),
    `max_attendees` int(11),
    `registered_count` int(11) DEFAULT 0,
    `status` varchar(50) DEFAULT 'Upcoming',
    `budget` decimal(10,2),
    `organizer` varchar(100),
    `contact_email` varchar(255),
    `contact_phone` varchar(50),
    `created_by` varchar(100),
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`event_id`),
    KEY `idx_event_date` (`event_date`),
    KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ Table 'recruitment_events' created</div>";
    $tables_created++;
}

// 2. Event Registrations
$sql = "CREATE TABLE IF NOT EXISTS `event_registrations` (
    `registration_id` int(11) NOT NULL AUTO_INCREMENT,
    `event_id` int(11) NOT NULL,
    `candidate_name` varchar(255) NOT NULL,
    `candidate_email` varchar(255) NOT NULL,
    `candidate_phone` varchar(50),
    `registration_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `attendance_status` varchar(50) DEFAULT 'Registered',
    `checked_in_at` datetime,
    `feedback_rating` int(11),
    `feedback_comments` text,
    `source` varchar(100),
    PRIMARY KEY (`registration_id`),
    KEY `idx_event` (`event_id`),
    KEY `idx_email` (`candidate_email`),
    FOREIGN KEY (`event_id`) REFERENCES `recruitment_events`(`event_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ Table 'event_registrations' created</div>";
    $tables_created++;
}

// 3. Event Jobs
$sql = "CREATE TABLE IF NOT EXISTS `event_jobs` (
    `event_job_id` int(11) NOT NULL AUTO_INCREMENT,
    `event_id` int(11) NOT NULL,
    `job_title` varchar(255) NOT NULL,
    `job_description` text,
    `positions_available` int(11) DEFAULT 1,
    `applications_received` int(11) DEFAULT 0,
    `is_active` tinyint(1) DEFAULT 1,
    PRIMARY KEY (`event_job_id`),
    KEY `idx_event` (`event_id`),
    FOREIGN KEY (`event_id`) REFERENCES `recruitment_events`(`event_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ Table 'event_jobs' created</div>";
    $tables_created++;
}

// 4. Employee Advocates
$sql = "CREATE TABLE IF NOT EXISTS `employee_advocates` (
    `advocate_id` int(11) NOT NULL AUTO_INCREMENT,
    `employee_name` varchar(255) NOT NULL,
    `employee_email` varchar(255) NOT NULL,
    `department` varchar(100),
    `job_title` varchar(255),
    `linkedin_url` varchar(500),
    `twitter_handle` varchar(100),
    `facebook_url` varchar(500),
    `status` varchar(50) DEFAULT 'Active',
    `total_shares` int(11) DEFAULT 0,
    `total_reach` int(11) DEFAULT 0,
    `total_engagements` int(11) DEFAULT 0,
    `joined_date` date,
    `created_by` varchar(100),
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`advocate_id`),
    KEY `idx_email` (`employee_email`),
    KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ Table 'employee_advocates' created</div>";
    $tables_created++;
}

// 5. Advocacy Content
$sql = "CREATE TABLE IF NOT EXISTS `advocacy_content` (
    `content_id` int(11) NOT NULL AUTO_INCREMENT,
    `content_title` varchar(255) NOT NULL,
    `content_type` varchar(50) NOT NULL,
    `content_text` text,
    `content_url` varchar(500),
    `image_url` varchar(500),
    `target_platform` varchar(50),
    `campaign_name` varchar(255),
    `status` varchar(50) DEFAULT 'Draft',
    `created_by` varchar(100),
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`content_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ Table 'advocacy_content' created</div>";
    $tables_created++;
}

// 6. Advocacy Shares
$sql = "CREATE TABLE IF NOT EXISTS `advocacy_shares` (
    `share_id` int(11) NOT NULL AUTO_INCREMENT,
    `advocate_id` int(11) NOT NULL,
    `content_id` int(11) NOT NULL,
    `platform` varchar(50) NOT NULL,
    `shared_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `reach` int(11) DEFAULT 0,
    `impressions` int(11) DEFAULT 0,
    `clicks` int(11) DEFAULT 0,
    `likes` int(11) DEFAULT 0,
    `comments` int(11) DEFAULT 0,
    `shares` int(11) DEFAULT 0,
    PRIMARY KEY (`share_id`),
    KEY `idx_advocate` (`advocate_id`),
    KEY `idx_content` (`content_id`),
    FOREIGN KEY (`advocate_id`) REFERENCES `employee_advocates`(`advocate_id`) ON DELETE CASCADE,
    FOREIGN KEY (`content_id`) REFERENCES `advocacy_content`(`content_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ Table 'advocacy_shares' created</div>";
    $tables_created++;
}

// 7. Advocacy Rewards
$sql = "CREATE TABLE IF NOT EXISTS `advocacy_rewards` (
    `reward_id` int(11) NOT NULL AUTO_INCREMENT,
    `advocate_id` int(11) NOT NULL,
    `reward_type` varchar(100) NOT NULL,
    `reward_description` text,
    `points_earned` int(11) DEFAULT 0,
    `reward_date` date,
    `status` varchar(50) DEFAULT 'Pending',
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`reward_id`),
    KEY `idx_advocate` (`advocate_id`),
    FOREIGN KEY (`advocate_id`) REFERENCES `employee_advocates`(`advocate_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ Table 'advocacy_rewards' created</div>";
    $tables_created++;
}

// 8. Event Types (lookup table)
$sql = "CREATE TABLE IF NOT EXISTS `event_types` (
    `type_id` int(11) NOT NULL AUTO_INCREMENT,
    `type_name` varchar(100) NOT NULL UNIQUE,
    `description` text,
    `icon` varchar(50),
    `is_active` tinyint(1) DEFAULT 1,
    PRIMARY KEY (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ Table 'event_types' created</div>";
    $tables_created++;
}

// Insert default event types
$event_types = [
    ['Job Fair', 'Traditional job fair with multiple employers', 'fa-briefcase'],
    ['Career Day', 'Career exploration and networking event', 'fa-graduation-cap'],
    ['Virtual Job Fair', 'Online recruitment event', 'fa-video'],
    ['Campus Recruitment', 'University campus hiring event', 'fa-university'],
    ['Open House', 'Company open house for potential candidates', 'fa-door-open'],
    ['Networking Event', 'Professional networking mixer', 'fa-users'],
    ['Workshop', 'Skills workshop and recruitment', 'fa-chalkboard-teacher'],
    ['Webinar', 'Online information session', 'fa-desktop'],
    ['Assessment Center', 'Candidate assessment event', 'fa-clipboard-check'],
    ['Meet & Greet', 'Informal meeting with hiring team', 'fa-handshake']
];

foreach ($event_types as $type) {
    $check = $conn->query("SELECT * FROM event_types WHERE type_name = '{$type[0]}'");
    if ($check->num_rows == 0) {
        $conn->query("INSERT INTO event_types (type_name, description, icon) VALUES ('{$type[0]}', '{$type[1]}', '{$type[2]}')");
        echo "<div class='info'>→ Added event type: {$type[0]}</div>";
    }
}

echo "<hr>";
echo "<h3>Summary:</h3>";
echo "<div class='success'>";
echo "<p><strong>Tables created:</strong> $tables_created</p>";
echo "<p><strong>Status:</strong> Events & Employee Advocacy database setup complete!</p>";
echo "</div>";

echo "<h3>Next Steps:</h3>";
echo "<p>1. Run sample data script: <a href='insert_events_advocacy_sample_data.php'>Insert Sample Data</a></p>";
echo "<p>2. Access features:</p>";
echo "<p><a href='http://localhost/rms/Recruitment_events' style='display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 5px; margin: 5px;'>Recruitment Events</a></p>";
echo "<p><a href='http://localhost/rms/Employee_advocacy' style='display: inline-block; padding: 10px 20px; background: #27ae60; color: white; text-decoration: none; border-radius: 5px; margin: 5px;'>Employee Advocacy</a></p>";

$conn->close();
?>
