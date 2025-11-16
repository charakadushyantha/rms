<?php
/**
 * Final Fix for Email Templates Table
 */

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'rmsdb';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>Final Fix for Email Templates Table</h2>";
echo "<style>
    body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
    .success { color: green; padding: 10px; background: #d4edda; margin: 10px 0; border-radius: 5px; }
    .info { color: blue; padding: 10px; background: #d1ecf1; margin: 10px 0; border-radius: 5px; }
</style>";

// Drop and recreate the table with correct structure
$sql = "DROP TABLE IF EXISTS email_templates";
if ($conn->query($sql) === TRUE) {
    echo "<div class='info'>✓ Dropped old email_templates table</div>";
}

// Create with correct structure
$sql = "CREATE TABLE `email_templates` (
    `template_id` int(11) NOT NULL AUTO_INCREMENT,
    `template_name` varchar(255) NOT NULL,
    `subject` varchar(255),
    `body_html` text NOT NULL,
    `category` varchar(100),
    `is_active` tinyint(1) DEFAULT 1,
    `created_by` varchar(100),
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ Created email_templates table with correct structure</div>";
}

// Insert sample templates
$templates = [
    [
        'template_name' => 'Job Alert - Tech Positions',
        'subject' => 'Exciting Tech Opportunities at {{company_name}}',
        'body_html' => '<h2>New Opportunities Available</h2><p>Dear {{candidate_name}},</p><p>We have exciting new positions that match your profile:</p><ul><li>{{job_title}}</li></ul><p>Apply now!</p>',
        'category' => 'Job Alert'
    ],
    [
        'template_name' => 'Welcome to Talent Network',
        'subject' => 'Welcome to Our Talent Network!',
        'body_html' => '<h2>Welcome!</h2><p>Thank you for joining our talent network. We will keep you updated on opportunities that match your skills.</p>',
        'category' => 'Welcome'
    ],
    [
        'template_name' => 'Interview Invitation',
        'subject' => 'Interview Invitation for {{job_title}}',
        'body_html' => '<h2>Interview Invitation</h2><p>Dear {{candidate_name}},</p><p>We would like to invite you for an interview for the position of {{job_title}}.</p><p>Please confirm your availability.</p>',
        'category' => 'Interview'
    ],
    [
        'template_name' => 'Application Received',
        'subject' => 'Application Received - {{job_title}}',
        'body_html' => '<h2>Application Received</h2><p>Thank you for your application! We will review it and get back to you soon.</p>',
        'category' => 'Confirmation'
    ],
    [
        'template_name' => 'Job Offer',
        'subject' => 'Job Offer - {{job_title}} at {{company_name}}',
        'body_html' => '<h2>Congratulations!</h2><p>Dear {{candidate_name}},</p><p>We are pleased to offer you the position of {{job_title}}.</p><p>Please review the attached offer letter.</p>',
        'category' => 'Offer'
    ],
    [
        'template_name' => 'Rejection - Polite',
        'subject' => 'Update on Your Application',
        'body_html' => '<h2>Thank You for Your Interest</h2><p>Dear {{candidate_name}},</p><p>Thank you for your interest in {{company_name}}. After careful consideration, we have decided to move forward with other candidates.</p><p>We wish you the best in your job search.</p>',
        'category' => 'Rejection'
    ]
];

foreach ($templates as $template) {
    $stmt = $conn->prepare("INSERT INTO email_templates (template_name, subject, body_html, category, is_active, created_by) VALUES (?, ?, ?, ?, 1, 'admin')");
    $stmt->bind_param('ssss', $template['template_name'], $template['subject'], $template['body_html'], $template['category']);
    
    if ($stmt->execute()) {
        echo "<div class='success'>✓ Added template: {$template['template_name']}</div>";
    }
}

echo "<hr>";
echo "<div class='success'><strong>Email templates table fixed and populated!</strong></div>";
echo "<p><a href='http://localhost/rms/Marketing_campaigns/email_campaigns' style='display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 5px;'>View Email Campaigns</a></p>";

$conn->close();
?>
