<?php
/**
 * Candidate Sourcing - Database Setup
 * Run this file: http://localhost/rms/create_candidate_sourcing_tables.php
 */

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'rmsdb';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>Candidate Sourcing - Database Setup</h2>";
echo "<style>
    body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
    .success { color: green; padding: 10px; background: #d4edda; margin: 10px 0; border-radius: 5px; }
    .info { color: #0c5460; padding: 10px; background: #d1ecf1; margin: 10px 0; border-radius: 5px; }
</style>";

$tables_created = 0;

// 1. Sourced Candidates Table
$sql = "CREATE TABLE IF NOT EXISTS `sourced_candidates` (
    `candidate_id` int(11) NOT NULL AUTO_INCREMENT,
    `first_name` varchar(100) NOT NULL,
    `last_name` varchar(100) NOT NULL,
    `email` varchar(255) NOT NULL,
    `phone` varchar(50),
    `location` varchar(255),
    `current_title` varchar(255),
    `current_company` varchar(255),
    `total_experience` int(11),
    `expected_salary` decimal(10,2),
    `notice_period` varchar(50),
    `linkedin_url` varchar(500),
    `github_url` varchar(500),
    `portfolio_url` varchar(500),
    `summary` text,
    `source` varchar(100),
    `source_details` varchar(255),
    `status` varchar(50) DEFAULT 'New',
    `rating` int(11) DEFAULT 0,
    `tags` text,
    `added_by` varchar(100),
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`candidate_id`),
    KEY `idx_email` (`email`),
    KEY `idx_status` (`status`),
    KEY `idx_source` (`source`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ Table 'sourced_candidates' created</div>";
    $tables_created++;
}

// 2. Candidate Skills
$sql = "CREATE TABLE IF NOT EXISTS `candidate_skills` (
    `skill_id` int(11) NOT NULL AUTO_INCREMENT,
    `candidate_id` int(11) NOT NULL,
    `skill_name` varchar(100) NOT NULL,
    `proficiency_level` varchar(50),
    `years_of_experience` int(11),
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`skill_id`),
    KEY `idx_candidate` (`candidate_id`),
    KEY `idx_skill` (`skill_name`),
    FOREIGN KEY (`candidate_id`) REFERENCES `sourced_candidates`(`candidate_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ Table 'candidate_skills' created</div>";
    $tables_created++;
}

// 3. Candidate Experience
$sql = "CREATE TABLE IF NOT EXISTS `candidate_experience` (
    `experience_id` int(11) NOT NULL AUTO_INCREMENT,
    `candidate_id` int(11) NOT NULL,
    `company_name` varchar(255) NOT NULL,
    `job_title` varchar(255) NOT NULL,
    `start_date` date,
    `end_date` date,
    `is_current` tinyint(1) DEFAULT 0,
    `description` text,
    `location` varchar(255),
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`experience_id`),
    KEY `idx_candidate` (`candidate_id`),
    FOREIGN KEY (`candidate_id`) REFERENCES `sourced_candidates`(`candidate_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ Table 'candidate_experience' created</div>";
    $tables_created++;
}

// 4. Candidate Education
$sql = "CREATE TABLE IF NOT EXISTS `candidate_education` (
    `education_id` int(11) NOT NULL AUTO_INCREMENT,
    `candidate_id` int(11) NOT NULL,
    `institution` varchar(255) NOT NULL,
    `degree` varchar(255) NOT NULL,
    `field_of_study` varchar(255),
    `start_year` int(11),
    `end_year` int(11),
    `grade` varchar(50),
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`education_id`),
    KEY `idx_candidate` (`candidate_id`),
    FOREIGN KEY (`candidate_id`) REFERENCES `sourced_candidates`(`candidate_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ Table 'candidate_education' created</div>";
    $tables_created++;
}

// 5. Candidate Documents
$sql = "CREATE TABLE IF NOT EXISTS `candidate_documents` (
    `document_id` int(11) NOT NULL AUTO_INCREMENT,
    `candidate_id` int(11) NOT NULL,
    `document_type` varchar(50) NOT NULL,
    `file_name` varchar(255) NOT NULL,
    `file_path` varchar(500) NOT NULL,
    `file_size` int(11),
    `uploaded_by` varchar(100),
    `uploaded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`document_id`),
    KEY `idx_candidate` (`candidate_id`),
    FOREIGN KEY (`candidate_id`) REFERENCES `sourced_candidates`(`candidate_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ Table 'candidate_documents' created</div>";
    $tables_created++;
}

// 6. Talent Pools
$sql = "CREATE TABLE IF NOT EXISTS `talent_pools` (
    `pool_id` int(11) NOT NULL AUTO_INCREMENT,
    `pool_name` varchar(255) NOT NULL,
    `description` text,
    `pool_type` varchar(50) DEFAULT 'Static',
    `criteria` text,
    `created_by` varchar(100),
    `is_active` tinyint(1) DEFAULT 1,
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`pool_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ Table 'talent_pools' created</div>";
    $tables_created++;
}

// 7. Talent Pool Members
$sql = "CREATE TABLE IF NOT EXISTS `talent_pool_members` (
    `member_id` int(11) NOT NULL AUTO_INCREMENT,
    `pool_id` int(11) NOT NULL,
    `candidate_id` int(11) NOT NULL,
    `added_by` varchar(100),
    `added_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`member_id`),
    KEY `idx_pool` (`pool_id`),
    KEY `idx_candidate` (`candidate_id`),
    FOREIGN KEY (`pool_id`) REFERENCES `talent_pools`(`pool_id`) ON DELETE CASCADE,
    FOREIGN KEY (`candidate_id`) REFERENCES `sourced_candidates`(`candidate_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ Table 'talent_pool_members' created</div>";
    $tables_created++;
}

// 8. Candidate Sources
$sql = "CREATE TABLE IF NOT EXISTS `candidate_sources` (
    `source_id` int(11) NOT NULL AUTO_INCREMENT,
    `source_name` varchar(100) NOT NULL UNIQUE,
    `source_type` varchar(50),
    `description` text,
    `is_active` tinyint(1) DEFAULT 1,
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`source_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ Table 'candidate_sources' created</div>";
    $tables_created++;
}

// 9. Candidate Engagement
$sql = "CREATE TABLE IF NOT EXISTS `candidate_engagement` (
    `engagement_id` int(11) NOT NULL AUTO_INCREMENT,
    `candidate_id` int(11) NOT NULL,
    `engagement_type` varchar(50) NOT NULL,
    `subject` varchar(255),
    `message` text,
    `sent_by` varchar(100),
    `sent_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `response_received` tinyint(1) DEFAULT 0,
    `response_date` datetime,
    `notes` text,
    PRIMARY KEY (`engagement_id`),
    KEY `idx_candidate` (`candidate_id`),
    FOREIGN KEY (`candidate_id`) REFERENCES `sourced_candidates`(`candidate_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ Table 'candidate_engagement' created</div>";
    $tables_created++;
}

// 10. Saved Searches
$sql = "CREATE TABLE IF NOT EXISTS `saved_searches` (
    `search_id` int(11) NOT NULL AUTO_INCREMENT,
    `search_name` varchar(255) NOT NULL,
    `search_criteria` text NOT NULL,
    `created_by` varchar(100),
    `is_alert` tinyint(1) DEFAULT 0,
    `alert_frequency` varchar(50),
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`search_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ Table 'saved_searches' created</div>";
    $tables_created++;
}

// Insert default sources
$default_sources = [
    ['LinkedIn', 'Social Media', 'Professional networking platform'],
    ['Indeed', 'Job Board', 'Job search engine'],
    ['Monster', 'Job Board', 'Online job board'],
    ['Referral', 'Internal', 'Employee referrals'],
    ['Company Website', 'Direct', 'Career page applications'],
    ['GitHub', 'Social Media', 'Developer platform'],
    ['Stack Overflow', 'Social Media', 'Developer community'],
    ['University', 'Campus', 'Campus recruitment'],
    ['Job Fair', 'Event', 'Recruitment events'],
    ['Agency', 'External', 'Recruitment agencies']
];

foreach ($default_sources as $source) {
    $check = $conn->query("SELECT * FROM candidate_sources WHERE source_name = '{$source[0]}'");
    if ($check->num_rows == 0) {
        $conn->query("INSERT INTO candidate_sources (source_name, source_type, description) 
                     VALUES ('{$source[0]}', '{$source[1]}', '{$source[2]}')");
        echo "<div class='info'>→ Added source: {$source[0]}</div>";
    }
}

echo "<hr>";
echo "<h3>Summary:</h3>";
echo "<div class='success'>";
echo "<p><strong>Tables created:</strong> $tables_created</p>";
echo "<p><strong>Status:</strong> Candidate Sourcing database setup complete!</p>";
echo "</div>";

echo "<h3>Next Steps:</h3>";
echo "<p>1. Delete this file for security</p>";
echo "<p>2. Access candidate sourcing at: <a href='http://localhost/rms/Candidate_sourcing'>Candidate Sourcing</a></p>";

$conn->close();
?>
