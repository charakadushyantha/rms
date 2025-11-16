<?php
/**
 * Recruitment Marketing Campaigns - Database Setup
 * Run: http://localhost/rms/create_marketing_campaigns_tables.php
 */

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'rmsdb';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>Recruitment Marketing Campaigns - Database Setup</h2>";
echo "<style>
    body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
    .success { color: green; padding: 10px; background: #d4edda; margin: 10px 0; border-radius: 5px; }
</style>";

$tables_created = 0;

// 1. Marketing Campaigns
$sql = "CREATE TABLE IF NOT EXISTS `marketing_campaigns` (
    `campaign_id` int(11) NOT NULL AUTO_INCREMENT,
    `campaign_name` varchar(255) NOT NULL,
    `campaign_type` varchar(50) NOT NULL,
    `description` text,
    `start_date` date NOT NULL,
    `end_date` date,
    `status` varchar(50) DEFAULT 'Draft',
    `budget` decimal(10,2),
    `target_audience` text,
    `goals` text,
    `created_by` varchar(100),
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`campaign_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ Table 'marketing_campaigns' created</div>";
    $tables_created++;
}

// 2. Email Campaigns
$sql = "CREATE TABLE IF NOT EXISTS `email_campaigns` (
    `email_campaign_id` int(11) NOT NULL AUTO_INCREMENT,
    `campaign_id` int(11) NOT NULL,
    `subject` varchar(255) NOT NULL,
    `from_name` varchar(100),
    `from_email` varchar(255),
    `email_content` text NOT NULL,
    `template_id` int(11),
    `send_date` datetime,
    `status` varchar(50) DEFAULT 'Draft',
    `total_sent` int(11) DEFAULT 0,
    `total_opened` int(11) DEFAULT 0,
    `total_clicked` int(11) DEFAULT 0,
    `total_bounced` int(11) DEFAULT 0,
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`email_campaign_id`),
    FOREIGN KEY (`campaign_id`) REFERENCES `marketing_campaigns`(`campaign_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ Table 'email_campaigns' created</div>";
    $tables_created++;
}

// 3. Email Templates
$sql = "CREATE TABLE IF NOT EXISTS `email_templates` (
    `template_id` int(11) NOT NULL AUTO_INCREMENT,
    `template_name` varchar(255) NOT NULL,
    `subject` varchar(255),
    `content` text NOT NULL,
    `category` varchar(100),
    `is_active` tinyint(1) DEFAULT 1,
    `created_by` varchar(100),
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ Table 'email_templates' created</div>";
    $tables_created++;
}

// 4. Social Posts
$sql = "CREATE TABLE IF NOT EXISTS `social_posts` (
    `post_id` int(11) NOT NULL AUTO_INCREMENT,
    `campaign_id` int(11) NOT NULL,
    `platform` varchar(50) NOT NULL,
    `post_content` text NOT NULL,
    `media_url` varchar(500),
    `scheduled_date` datetime,
    `posted_date` datetime,
    `status` varchar(50) DEFAULT 'Scheduled',
    `impressions` int(11) DEFAULT 0,
    `engagements` int(11) DEFAULT 0,
    `clicks` int(11) DEFAULT 0,
    `shares` int(11) DEFAULT 0,
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`post_id`),
    FOREIGN KEY (`campaign_id`) REFERENCES `marketing_campaigns`(`campaign_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ Table 'social_posts' created</div>";
    $tables_created++;
}

// 5. Ad Campaigns
$sql = "CREATE TABLE IF NOT EXISTS `ad_campaigns` (
    `ad_campaign_id` int(11) NOT NULL AUTO_INCREMENT,
    `campaign_id` int(11) NOT NULL,
    `platform` varchar(50) NOT NULL,
    `ad_name` varchar(255) NOT NULL,
    `ad_content` text,
    `target_audience` text,
    `budget` decimal(10,2),
    `spent` decimal(10,2) DEFAULT 0,
    `start_date` date,
    `end_date` date,
    `status` varchar(50) DEFAULT 'Draft',
    `impressions` int(11) DEFAULT 0,
    `clicks` int(11) DEFAULT 0,
    `applications` int(11) DEFAULT 0,
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`ad_campaign_id`),
    FOREIGN KEY (`campaign_id`) REFERENCES `marketing_campaigns`(`campaign_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ Table 'ad_campaigns' created</div>";
    $tables_created++;
}

// 6. Campaign Analytics
$sql = "CREATE TABLE IF NOT EXISTS `campaign_analytics` (
    `analytics_id` int(11) NOT NULL AUTO_INCREMENT,
    `campaign_id` int(11) NOT NULL,
    `date` date NOT NULL,
    `reach` int(11) DEFAULT 0,
    `impressions` int(11) DEFAULT 0,
    `clicks` int(11) DEFAULT 0,
    `applications` int(11) DEFAULT 0,
    `spent` decimal(10,2) DEFAULT 0,
    `conversions` int(11) DEFAULT 0,
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`analytics_id`),
    FOREIGN KEY (`campaign_id`) REFERENCES `marketing_campaigns`(`campaign_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ Table 'campaign_analytics' created</div>";
    $tables_created++;
}

// Insert default email templates
$default_templates = [
    ['Job Alert', 'New Job Opportunity: {{job_title}}', 'Hi {{candidate_name}},\n\nWe have a new opportunity that matches your profile!\n\nPosition: {{job_title}}\nLocation: {{location}}\n\nApply now!', 'Job Alert'],
    ['Interview Invitation', 'Interview Invitation for {{job_title}}', 'Dear {{candidate_name}},\n\nWe would like to invite you for an interview.\n\nBest regards', 'Interview'],
    ['Application Received', 'Application Received', 'Thank you for your application!\n\nWe will review and get back to you soon.', 'Confirmation']
];

foreach ($default_templates as $template) {
    $check = $conn->query("SELECT * FROM email_templates WHERE template_name = '{$template[0]}'");
    if ($check && $check->num_rows == 0) {
        $stmt = $conn->prepare("INSERT INTO email_templates (template_name, subject, body_html, template_type) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param('ssss', $template[0], $template[1], $template[2], $template[3]);
            $stmt->execute();
        }
    }
}

echo "<hr>";
echo "<h3>Summary:</h3>";
echo "<div class='success'>";
echo "<p><strong>Tables created:</strong> $tables_created</p>";
echo "<p><strong>Status:</strong> Marketing Campaigns database setup complete!</p>";
echo "</div>";

echo "<h3>Next Steps:</h3>";
echo "<p><a href='http://localhost/rms/Marketing_campaigns' style='display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 5px;'>View Campaigns</a></p>";

$conn->close();
?>
