<?php
/**
 * Job Posting Integration - Database Setup
 * Run this file once: http://localhost/rms/create_job_posting_tables.php
 */

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'rmsdb';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>Job Posting Integration - Database Setup</h2>";
echo "<p>Creating tables...</p>";

$tables_created = 0;
$tables_existed = 0;

// 1. Job Postings Table
$sql = "CREATE TABLE IF NOT EXISTS `job_postings` (
    `jp_id` int(11) NOT NULL AUTO_INCREMENT,
    `jp_title` varchar(255) NOT NULL,
    `jp_description` text NOT NULL,
    `jp_requirements` text,
    `jp_responsibilities` text,
    `jp_location` varchar(255),
    `jp_employment_type` varchar(50) DEFAULT 'Full-time',
    `jp_salary_min` decimal(10,2),
    `jp_salary_max` decimal(10,2),
    `jp_salary_currency` varchar(10) DEFAULT 'USD',
    `jp_category_id` int(11),
    `jp_position_id` int(11),
    `jp_department` varchar(100),
    `jp_experience_min` int(11),
    `jp_experience_max` int(11),
    `jp_status` varchar(50) DEFAULT 'Draft',
    `jp_posted_by` varchar(100),
    `jp_created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `jp_updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `jp_expires_at` datetime,
    PRIMARY KEY (`jp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<p style='color: green;'>✓ Table 'job_postings' created</p>";
    $tables_created++;
} else {
    echo "<p style='color: blue;'>• Table 'job_postings' already exists</p>";
    $tables_existed++;
}

// 2. Job Platforms Table
$sql = "CREATE TABLE IF NOT EXISTS `job_platforms` (
    `platform_id` int(11) NOT NULL AUTO_INCREMENT,
    `platform_name` varchar(100) NOT NULL,
    `platform_key` varchar(50) NOT NULL UNIQUE,
    `platform_logo` varchar(255),
    `api_endpoint` varchar(255),
    `is_active` tinyint(1) DEFAULT 1,
    `requires_api_key` tinyint(1) DEFAULT 1,
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`platform_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<p style='color: green;'>✓ Table 'job_platforms' created</p>";
    $tables_created++;
} else {
    echo "<p style='color: blue;'>• Table 'job_platforms' already exists</p>";
    $tables_existed++;
}



// 3. Job Platform Credentials Table
$sql = "CREATE TABLE IF NOT EXISTS `job_platform_credentials` (
    `cred_id` int(11) NOT NULL AUTO_INCREMENT,
    `platform_id` int(11) NOT NULL,
    `api_key` varchar(255),
    `api_secret` varchar(255),
    `access_token` text,
    `refresh_token` text,
    `is_enabled` tinyint(1) DEFAULT 0,
    `last_sync` datetime,
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`cred_id`),
    FOREIGN KEY (`platform_id`) REFERENCES `job_platforms`(`platform_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<p style='color: green;'>✓ Table 'job_platform_credentials' created</p>";
    $tables_created++;
} else {
    echo "<p style='color: blue;'>• Table 'job_platform_credentials' already exists</p>";
    $tables_existed++;
}

// 4. Job Posting History Table
$sql = "CREATE TABLE IF NOT EXISTS `job_posting_history` (
    `history_id` int(11) NOT NULL AUTO_INCREMENT,
    `jp_id` int(11) NOT NULL,
    `platform_id` int(11) NOT NULL,
    `external_job_id` varchar(255),
    `status` varchar(50) DEFAULT 'Pending',
    `posted_at` datetime,
    `expires_at` datetime,
    `views_count` int(11) DEFAULT 0,
    `clicks_count` int(11) DEFAULT 0,
    `applications_count` int(11) DEFAULT 0,
    `last_synced` datetime,
    `error_message` text,
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`history_id`),
    FOREIGN KEY (`jp_id`) REFERENCES `job_postings`(`jp_id`) ON DELETE CASCADE,
    FOREIGN KEY (`platform_id`) REFERENCES `job_platforms`(`platform_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<p style='color: green;'>✓ Table 'job_posting_history' created</p>";
    $tables_created++;
} else {
    echo "<p style='color: blue;'>• Table 'job_posting_history' already exists</p>";
    $tables_existed++;
}

// Insert default platforms
$platforms = [
    ['LinkedIn', 'linkedin', 'https://api.linkedin.com/v2/jobs', 1],
    ['Indeed', 'indeed', 'https://api.indeed.com/ads', 1],
    ['Glassdoor', 'glassdoor', 'https://api.glassdoor.com/api/employer', 1],
    ['Monster', 'monster', 'https://api.monster.com/v1', 1],
    ['ZipRecruiter', 'ziprecruiter', 'https://api.ziprecruiter.com/v1', 1],
    ['CareerBuilder', 'careerbuilder', 'https://api.careerbuilder.com/v2', 1]
];

foreach ($platforms as $platform) {
    $check = $conn->query("SELECT * FROM job_platforms WHERE platform_key = '{$platform[1]}'");
    if ($check->num_rows == 0) {
        $conn->query("INSERT INTO job_platforms (platform_name, platform_key, api_endpoint, is_active) 
                     VALUES ('{$platform[0]}', '{$platform[1]}', '{$platform[2]}', {$platform[3]})");
        echo "<p style='color: green;'>✓ Added platform: {$platform[0]}</p>";
    }
}

echo "<hr>";
echo "<h3>Summary:</h3>";
echo "<p>Tables created: <strong>$tables_created</strong></p>";
echo "<p>Already existed: <strong>$tables_existed</strong></p>";
echo "<p style='color: green; font-weight: bold;'>✓ Database setup complete!</p>";
echo "<p><strong>Next Step:</strong> Delete this file for security</p>";

$conn->close();
?>
