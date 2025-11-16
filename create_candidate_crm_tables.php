<?php
/**
 * Candidate CRM - Comprehensive Database Setup
 * Run: http://localhost/rms/create_candidate_crm_tables.php
 */

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'rmsdb';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>Candidate CRM - Comprehensive Database Setup</h2>";
echo "<style>
    body { font-family: Arial, sans-serif; padding: 20px; background: #f5f7fa; }
    .success { color: green; padding: 10px; background: #d4edda; margin: 10px 0; border-radius: 5px; }
    .info { color: #0c5460; padding: 10px; background: #d1ecf1; margin: 10px 0; border-radius: 5px; }
</style>";

$tables_created = 0;

// 1. CRM Candidates (Extended profiles)
$sql = "CREATE TABLE IF NOT EXISTS `crm_candidates` (
    `crm_candidate_id` int(11) NOT NULL AUTO_INCREMENT,
    `candidate_id` int(11),
    `first_name` varchar(100) NOT NULL,
    `last_name` varchar(100) NOT NULL,
    `email` varchar(255) NOT NULL,
    `phone` varchar(50),
    `current_stage` varchar(100) DEFAULT 'New Lead',
    `pipeline_status` varchar(50) DEFAULT 'Active',
    `relationship_score` int(11) DEFAULT 0,
    `engagement_level` varchar(50) DEFAULT 'Cold',
    `last_contact_date` datetime,
    `next_follow_up` datetime,
    `source` varchar(100),
    `assigned_to` varchar(100),
    `priority` varchar(50) DEFAULT 'Medium',
    `tags` text,
    `custom_fields` text,
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`crm_candidate_id`),
    KEY `idx_email` (`email`),
    KEY `idx_stage` (`current_stage`),
    KEY `idx_assigned` (`assigned_to`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ Table 'crm_candidates' created</div>";
    $tables_created++;
}

// 2. CRM Interactions
$sql = "CREATE TABLE IF NOT EXISTS `crm_interactions` (
    `interaction_id` int(11) NOT NULL AUTO_INCREMENT,
    `crm_candidate_id` int(11) NOT NULL,
    `interaction_type` varchar(50) NOT NULL,
    `subject` varchar(255),
    `description` text,
    `interaction_date` datetime NOT NULL,
    `duration_minutes` int(11),
    `outcome` varchar(100),
    `sentiment` varchar(50),
    `created_by` varchar(100),
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`interaction_id`),
    KEY `idx_candidate` (`crm_candidate_id`),
    KEY `idx_type` (`interaction_type`),
    KEY `idx_date` (`interaction_date`),
    FOREIGN KEY (`crm_candidate_id`) REFERENCES `crm_candidates`(`crm_candidate_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ Table 'crm_interactions' created</div>";
    $tables_created++;
}

// 3. CRM Activities (Tasks)
$sql = "CREATE TABLE IF NOT EXISTS `crm_activities` (
    `activity_id` int(11) NOT NULL AUTO_INCREMENT,
    `crm_candidate_id` int(11) NOT NULL,
    `activity_type` varchar(50) NOT NULL,
    `title` varchar(255) NOT NULL,
    `description` text,
    `due_date` datetime,
    `priority` varchar(50) DEFAULT 'Medium',
    `status` varchar(50) DEFAULT 'Pending',
    `assigned_to` varchar(100),
    `completed_at` datetime,
    `created_by` varchar(100),
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`activity_id`),
    KEY `idx_candidate` (`crm_candidate_id`),
    KEY `idx_status` (`status`),
    KEY `idx_assigned` (`assigned_to`),
    FOREIGN KEY (`crm_candidate_id`) REFERENCES `crm_candidates`(`crm_candidate_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ Table 'crm_activities' created</div>";
    $tables_created++;
}

// 4. CRM Notes
$sql = "CREATE TABLE IF NOT EXISTS `crm_notes` (
    `note_id` int(11) NOT NULL AUTO_INCREMENT,
    `crm_candidate_id` int(11) NOT NULL,
    `note_text` text NOT NULL,
    `note_type` varchar(50) DEFAULT 'General',
    `is_pinned` tinyint(1) DEFAULT 0,
    `created_by` varchar(100),
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`note_id`),
    KEY `idx_candidate` (`crm_candidate_id`),
    FOREIGN KEY (`crm_candidate_id`) REFERENCES `crm_candidates`(`crm_candidate_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ Table 'crm_notes' created</div>";
    $tables_created++;
}

// 5. CRM Pipeline Stages
$sql = "CREATE TABLE IF NOT EXISTS `crm_pipeline_stages` (
    `stage_id` int(11) NOT NULL AUTO_INCREMENT,
    `stage_name` varchar(100) NOT NULL,
    `stage_order` int(11) NOT NULL,
    `stage_color` varchar(20),
    `is_active` tinyint(1) DEFAULT 1,
    `automation_rules` text,
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`stage_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ Table 'crm_pipeline_stages' created</div>";
    $tables_created++;
}

// 6. CRM Relationships (Scoring)
$sql = "CREATE TABLE IF NOT EXISTS `crm_relationships` (
    `relationship_id` int(11) NOT NULL AUTO_INCREMENT,
    `crm_candidate_id` int(11) NOT NULL,
    `engagement_score` int(11) DEFAULT 0,
    `response_rate` decimal(5,2) DEFAULT 0,
    `interaction_count` int(11) DEFAULT 0,
    `last_interaction_date` datetime,
    `quality_score` int(11) DEFAULT 0,
    `calculated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`relationship_id`),
    KEY `idx_candidate` (`crm_candidate_id`),
    FOREIGN KEY (`crm_candidate_id`) REFERENCES `crm_candidates`(`crm_candidate_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ Table 'crm_relationships' created</div>";
    $tables_created++;
}

// 7. CRM Tags
$sql = "CREATE TABLE IF NOT EXISTS `crm_tags` (
    `tag_id` int(11) NOT NULL AUTO_INCREMENT,
    `tag_name` varchar(100) NOT NULL UNIQUE,
    `tag_color` varchar(20),
    `tag_category` varchar(50),
    `usage_count` int(11) DEFAULT 0,
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ Table 'crm_tags' created</div>";
    $tables_created++;
}

// 8. CRM Candidate Tags (Junction table)
$sql = "CREATE TABLE IF NOT EXISTS `crm_candidate_tags` (
    `candidate_tag_id` int(11) NOT NULL AUTO_INCREMENT,
    `crm_candidate_id` int(11) NOT NULL,
    `tag_id` int(11) NOT NULL,
    `added_by` varchar(100),
    `added_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`candidate_tag_id`),
    KEY `idx_candidate` (`crm_candidate_id`),
    KEY `idx_tag` (`tag_id`),
    FOREIGN KEY (`crm_candidate_id`) REFERENCES `crm_candidates`(`crm_candidate_id`) ON DELETE CASCADE,
    FOREIGN KEY (`tag_id`) REFERENCES `crm_tags`(`tag_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ Table 'crm_candidate_tags' created</div>";
    $tables_created++;
}

// Insert default pipeline stages
$default_stages = [
    ['New Lead', 1, '#3498db'],
    ['Contacted', 2, '#9b59b6'],
    ['Qualified', 3, '#f39c12'],
    ['Interview Scheduled', 4, '#e67e22'],
    ['Interview Completed', 5, '#1abc9c'],
    ['Offer Extended', 6, '#27ae60'],
    ['Hired', 7, '#2ecc71'],
    ['Rejected', 8, '#e74c3c'],
    ['Withdrawn', 9, '#95a5a6']
];

foreach ($default_stages as $stage) {
    $check = $conn->query("SELECT * FROM crm_pipeline_stages WHERE stage_name = '{$stage[0]}'");
    if ($check->num_rows == 0) {
        $conn->query("INSERT INTO crm_pipeline_stages (stage_name, stage_order, stage_color) VALUES ('{$stage[0]}', {$stage[1]}, '{$stage[2]}')");
        echo "<div class='info'>→ Added pipeline stage: {$stage[0]}</div>";
    }
}

// Insert default tags
$default_tags = [
    ['Hot Lead', '#e74c3c', 'Priority'],
    ['Passive Candidate', '#3498db', 'Status'],
    ['Senior Level', '#9b59b6', 'Experience'],
    ['Tech Stack Match', '#27ae60', 'Skills'],
    ['Culture Fit', '#1abc9c', 'Assessment'],
    ['Referral', '#f39c12', 'Source'],
    ['LinkedIn', '#0077b5', 'Source'],
    ['High Potential', '#e67e22', 'Priority']
];

foreach ($default_tags as $tag) {
    $check = $conn->query("SELECT * FROM crm_tags WHERE tag_name = '{$tag[0]}'");
    if ($check->num_rows == 0) {
        $conn->query("INSERT INTO crm_tags (tag_name, tag_color, tag_category) VALUES ('{$tag[0]}', '{$tag[1]}', '{$tag[2]}')");
        echo "<div class='info'>→ Added tag: {$tag[0]}</div>";
    }
}

echo "<hr>";
echo "<h3>Summary:</h3>";
echo "<div class='success'>";
echo "<p><strong>Tables created:</strong> $tables_created</p>";
echo "<p><strong>Pipeline stages:</strong> 9 stages</p>";
echo "<p><strong>Default tags:</strong> 8 tags</p>";
echo "<p><strong>Status:</strong> Candidate CRM database setup complete!</p>";
echo "</div>";

echo "<h3>Next Steps:</h3>";
echo "<p>1. Run sample data script: <a href='insert_candidate_crm_sample_data.php'>Insert Sample Data</a></p>";
echo "<p>2. Access CRM: <a href='http://localhost/rms/Candidate_crm' style='display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 5px;'>Candidate CRM</a></p>";

$conn->close();
?>
