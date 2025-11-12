<?php
/**
 * Create Email Configuration Tables
 * Run this file once: http://localhost/rms/create_email_tables.php
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

echo "<h1>Creating Email Configuration Tables</h1>";
echo "<style>body { font-family: Arial, sans-serif; padding: 20px; } .success { color: green; } .error { color: red; }</style>";

// 1. Create email_config table
$sql = "CREATE TABLE IF NOT EXISTS `email_config` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `smtp_host` VARCHAR(255) NOT NULL,
    `smtp_port` INT(11) NOT NULL DEFAULT 587,
    `smtp_username` VARCHAR(255) NOT NULL,
    `smtp_password` VARCHAR(255) NOT NULL,
    `smtp_encryption` VARCHAR(10) DEFAULT 'tls',
    `from_email` VARCHAR(255) NOT NULL,
    `from_name` VARCHAR(255) NOT NULL,
    `reply_to_email` VARCHAR(255) NULL,
    `is_active` TINYINT(1) DEFAULT 0,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if ($conn->query($sql)) {
    echo "<p class='success'>✓ Table 'email_config' created successfully!</p>";
} else {
    echo "<p class='error'>✗ Error creating email_config: " . $conn->error . "</p>";
}

// 2. Create email_templates table
$sql = "CREATE TABLE IF NOT EXISTS `email_templates` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `template_type` VARCHAR(50) NOT NULL,
    `subject` VARCHAR(255) NOT NULL,
    `body` TEXT NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `template_type` (`template_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if ($conn->query($sql)) {
    echo "<p class='success'>✓ Table 'email_templates' created successfully!</p>";
} else {
    echo "<p class='error'>✗ Error creating email_templates: " . $conn->error . "</p>";
}

// 3. Create email_logs table (optional - for tracking sent emails)
$sql = "CREATE TABLE IF NOT EXISTS `email_logs` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `recipient_email` VARCHAR(255) NOT NULL,
    `subject` VARCHAR(255) NOT NULL,
    `body` TEXT NULL,
    `status` ENUM('sent', 'failed') DEFAULT 'sent',
    `error_message` TEXT NULL,
    `sent_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `recipient_email` (`recipient_email`),
    KEY `sent_at` (`sent_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if ($conn->query($sql)) {
    echo "<p class='success'>✓ Table 'email_logs' created successfully!</p>";
} else {
    echo "<p class='error'>✗ Error creating email_logs: " . $conn->error . "</p>";
}

// 4. Insert default email templates
$templates = [
    [
        'template_type' => 'welcome',
        'subject' => 'Welcome to {company_name} Recruitment Process',
        'body' => "Dear {candidate_name},\n\nWelcome to {company_name}! We're excited to have you in our recruitment process for the {job_title} position.\n\nYour recruiter {recruiter_name} will be in touch with you soon regarding the next steps.\n\nBest regards,\n{company_name} HR Team"
    ],
    [
        'template_type' => 'interview_invitation',
        'subject' => 'Interview Scheduled - {job_title} at {company_name}',
        'body' => "Dear {candidate_name},\n\nCongratulations! We would like to invite you for an interview for the {job_title} position.\n\nInterview Details:\nDate: {interview_date}\nTime: {interview_time}\nInterviewer: {interviewer_name}\n\nPlease confirm your availability by replying to this email.\n\nWe look forward to meeting you!\n\nBest regards,\n{company_name} HR Team"
    ],
    [
        'template_type' => 'selection',
        'subject' => 'Congratulations! Job Offer from {company_name}',
        'body' => "Dear {candidate_name},\n\nWe are pleased to inform you that you have been selected for the {job_title} position at {company_name}!\n\nYour recruiter {recruiter_name} will contact you shortly with the offer details and next steps.\n\nCongratulations on your success!\n\nBest regards,\n{company_name} HR Team"
    ],
    [
        'template_type' => 'rejection',
        'subject' => 'Update on Your Application - {company_name}',
        'body' => "Dear {candidate_name},\n\nThank you for your interest in the {job_title} position at {company_name} and for taking the time to interview with us.\n\nAfter careful consideration, we have decided to move forward with other candidates whose qualifications more closely match our current needs.\n\nWe appreciate your interest in {company_name} and encourage you to apply for future opportunities that match your skills and experience.\n\nBest wishes in your job search.\n\nBest regards,\n{company_name} HR Team"
    ]
];

foreach ($templates as $template) {
    $type = $template['template_type'];
    $subject = $conn->real_escape_string($template['subject']);
    $body = $conn->real_escape_string($template['body']);
    
    // Check if template already exists
    $check = $conn->query("SELECT id FROM email_templates WHERE template_type = '$type'");
    
    if ($check->num_rows == 0) {
        $sql = "INSERT INTO email_templates (template_type, subject, body) 
                VALUES ('$type', '$subject', '$body')";
        
        if ($conn->query($sql)) {
            echo "<p class='success'>✓ Default template '$type' inserted!</p>";
        } else {
            echo "<p class='error'>✗ Error inserting template '$type': " . $conn->error . "</p>";
        }
    } else {
        echo "<p style='color: orange;'>⚠ Template '$type' already exists, skipping...</p>";
    }
}

$conn->close();

echo "<hr>";
echo "<h3>✅ Setup Complete!</h3>";
echo "<p>Email configuration tables have been created successfully.</p>";
echo "<p><a href='Setup/email_configuration' style='background: #667eea; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Go to Email Configuration</a></p>";
?>
