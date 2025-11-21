<?php
/**
 * Update module_visibility table to include ALL system modules
 * This ensures Module Manager can control ALL sidebar items
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

echo "<h2>🔧 Updating Module Visibility System</h2>";
echo "<p>Adding ALL system modules to Module Manager control...</p><br>";

// Define ALL system modules organized by section
$all_modules = [
    // Core Recruitment
    ['key' => 'dashboard', 'name' => 'Dashboard', 'section' => 'Main'],
    ['key' => 'candidates', 'name' => 'Candidates', 'section' => 'Core Recruitment'],
    ['key' => 'calendar', 'name' => 'Calendar', 'section' => 'Core Recruitment'],
    ['key' => 'interviews', 'name' => 'Interviews', 'section' => 'Core Recruitment'],
    ['key' => 'interview_management', 'name' => 'Interview Management (IMS)', 'section' => 'Core Recruitment'],
    ['key' => 'questions_bank', 'name' => 'Questions Bank', 'section' => 'Core Recruitment'],
    ['key' => 'analytics', 'name' => 'Analytics & Reports', 'section' => 'Core Recruitment'],
    
    // Job Management
    ['key' => 'job_posting', 'name' => 'Job Postings', 'section' => 'Job Management'],
    ['key' => 'job_analytics', 'name' => 'Job Analytics', 'section' => 'Job Management'],
    
    // Recruitment Marketing
    ['key' => 'sales_marketing', 'name' => 'Marketing Campaigns', 'section' => 'Recruitment Marketing'],
    ['key' => 'marketing_campaigns', 'name' => 'Email Campaigns', 'section' => 'Recruitment Marketing'],
    ['key' => 'candidate_sourcing', 'name' => 'Candidate Sourcing', 'section' => 'Recruitment Marketing'],
    ['key' => 'talent_pools', 'name' => 'Talent Pools', 'section' => 'Recruitment Marketing'],
    ['key' => 'referral_program', 'name' => 'Referral Program', 'section' => 'Recruitment Marketing'],
    ['key' => 'recruitment_events', 'name' => 'Recruitment Events', 'section' => 'Recruitment Marketing'],
    ['key' => 'employee_advocacy', 'name' => 'Employee Advocacy', 'section' => 'Recruitment Marketing'],
    ['key' => 'employer_branding', 'name' => 'Employer Branding', 'section' => 'Recruitment Marketing'],
    ['key' => 'paid_advertising', 'name' => 'Paid Advertising', 'section' => 'Recruitment Marketing'],
    ['key' => 'roi_tracking', 'name' => 'ROI Tracking', 'section' => 'Recruitment Marketing'],
    
    // CRM & Engagement
    ['key' => 'candidate_crm', 'name' => 'Candidate CRM', 'section' => 'CRM & Engagement'],
    ['key' => 'media_gallery', 'name' => 'Media Gallery', 'section' => 'CRM & Engagement'],
    ['key' => 'reviews_management', 'name' => 'Reviews Management', 'section' => 'CRM & Engagement'],
    ['key' => 'awards_recognition', 'name' => 'Awards & Recognition', 'section' => 'CRM & Engagement'],
    
    // Integrations
    ['key' => 'integration_hub', 'name' => 'Integration Hub', 'section' => 'Integrations'],
    ['key' => 'video_integrations', 'name' => 'Video Platforms', 'section' => 'Integrations'],
    ['key' => 'assessment_integrations', 'name' => 'Assessment Tools', 'section' => 'Integrations'],
    ['key' => 'background_check', 'name' => 'Background Checks', 'section' => 'Integrations'],
    ['key' => 'ats_integrations', 'name' => 'ATS Integrations', 'section' => 'Integrations'],
    ['key' => 'job_board_platforms', 'name' => 'Job Board Platforms', 'section' => 'Integrations'],
    
    // User Management
    ['key' => 'recruiters', 'name' => 'Recruiters', 'section' => 'User Management'],
    ['key' => 'interviewers', 'name' => 'Interviewers', 'section' => 'User Management'],
    ['key' => 'candidate_users', 'name' => 'Candidate Users', 'section' => 'User Management'],
    
    // Reports & Analytics
    ['key' => 'reports', 'name' => 'MIS Reports', 'section' => 'Reports'],
    ['key' => 'custom_reports', 'name' => 'Custom Reports', 'section' => 'Reports'],
    ['key' => 'export_data', 'name' => 'Export Data', 'section' => 'Reports'],
    
    // Automation
    ['key' => 'marketing_automation', 'name' => 'Marketing Automation', 'section' => 'Automation'],
    ['key' => 'auto_distribution', 'name' => 'Auto Distribution', 'section' => 'Automation'],
    
    // System & Settings
    ['key' => 'roles', 'name' => 'Roles & Permissions', 'section' => 'Settings'],
    ['key' => 'signup_controller', 'name' => 'Signup Controller', 'section' => 'Settings'],
    ['key' => 'chatbot', 'name' => 'AI Chatbot', 'section' => 'Settings'],
    ['key' => 'setup', 'name' => 'System Setup', 'section' => 'Settings'],
    ['key' => 'module_manager', 'name' => 'Module Manager', 'section' => 'Settings'],
    ['key' => 'company_settings', 'name' => 'Company Settings', 'section' => 'Settings'],
    ['key' => 'email_configuration', 'name' => 'Email Configuration', 'section' => 'Settings'],
    ['key' => 'account', 'name' => 'My Account', 'section' => 'Settings'],
];

// First, check if columns already exist
$columns_exist = true;
$check_columns = $conn->query("SHOW COLUMNS FROM `module_visibility` LIKE 'module_name'");
if ($check_columns->num_rows == 0) {
    $columns_exist = false;
    $alter_sql = "ALTER TABLE `module_visibility` ADD COLUMN `module_name` VARCHAR(100) NULL AFTER `module_key`";
    if ($conn->query($alter_sql) === TRUE) {
        echo "✅ Added 'module_name' column<br>";
    } else {
        echo "❌ Error adding module_name: " . $conn->error . "<br>";
    }
}

$check_columns = $conn->query("SHOW COLUMNS FROM `module_visibility` LIKE 'section'");
if ($check_columns->num_rows == 0) {
    $columns_exist = false;
    $alter_sql = "ALTER TABLE `module_visibility` ADD COLUMN `section` VARCHAR(50) NULL AFTER `module_name`";
    if ($conn->query($alter_sql) === TRUE) {
        echo "✅ Added 'section' column<br>";
    } else {
        echo "❌ Error adding section: " . $conn->error . "<br>";
    }
}

if ($columns_exist) {
    echo "✅ Table structure already up to date<br>";
}

// Insert or update all modules
$inserted = 0;
$updated = 0;

foreach ($all_modules as $module) {
    // Check if module exists
    $check_sql = "SELECT id FROM module_visibility WHERE module_key = '" . $conn->real_escape_string($module['key']) . "'";
    $result = $conn->query($check_sql);
    
    if ($result->num_rows > 0) {
        // Update existing
        $update_sql = "UPDATE module_visibility SET 
                      module_name = '" . $conn->real_escape_string($module['name']) . "',
                      section = '" . $conn->real_escape_string($module['section']) . "'
                      WHERE module_key = '" . $conn->real_escape_string($module['key']) . "'";
        
        if ($conn->query($update_sql)) {
            $updated++;
        }
    } else {
        // Insert new
        $insert_sql = "INSERT INTO module_visibility (module_key, module_name, section, is_visible) VALUES (
                      '" . $conn->real_escape_string($module['key']) . "',
                      '" . $conn->real_escape_string($module['name']) . "',
                      '" . $conn->real_escape_string($module['section']) . "',
                      1)";
        
        if ($conn->query($insert_sql)) {
            $inserted++;
        }
    }
}

echo "<br>";
echo "✅ <strong>$inserted</strong> new modules added<br>";
echo "✅ <strong>$updated</strong> existing modules updated<br>";
echo "<br>";

// Show summary
$total_sql = "SELECT COUNT(*) as total FROM module_visibility";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();

echo "<div style='padding: 20px; background: #d1fae5; border: 2px solid #10b981; border-radius: 8px; margin: 20px 0;'>";
echo "<h3 style='color: #065f46; margin: 0 0 10px 0;'>✅ Module Visibility System Updated!</h3>";
echo "<p style='color: #065f46; margin: 0;'><strong>" . $total_row['total'] . "</strong> total system modules are now tracked.</p>";
echo "<p style='color: #065f46; margin: 10px 0 0 0;'>All modules can now be controlled via Module Manager!</p>";
echo "</div>";

// Show modules by section
echo "<h3>📋 Modules by Section</h3>";
$section_sql = "SELECT section, COUNT(*) as count FROM module_visibility GROUP BY section ORDER BY section";
$section_result = $conn->query($section_sql);

echo "<table style='border-collapse: collapse; width: 100%; margin: 20px 0;'>";
echo "<tr style='background: #667eea; color: white;'>";
echo "<th style='padding: 10px; text-align: left; border: 1px solid #ddd;'>Section</th>";
echo "<th style='padding: 10px; text-align: center; border: 1px solid #ddd;'>Module Count</th>";
echo "</tr>";

while ($row = $section_result->fetch_assoc()) {
    echo "<tr>";
    echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . $row['section'] . "</td>";
    echo "<td style='padding: 10px; text-align: center; border: 1px solid #ddd;'>" . $row['count'] . "</td>";
    echo "</tr>";
}

echo "</table>";

$conn->close();

echo "<br>";
echo "<div style='padding: 20px; margin: 20px 0;'>";
echo "<a href='index.php' style='display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 6px; margin-right: 10px;'>← Back to Home</a>";
echo "<a href='Setup/module_manager' style='display: inline-block; padding: 10px 20px; background: #10b981; color: white; text-decoration: none; border-radius: 6px;'>Open Module Manager →</a>";
echo "</div>";

echo "<div style='padding: 15px; background: #fef3c7; border-left: 4px solid #f59e0b; margin: 20px 0;'>";
echo "<strong>⚠️ Next Step:</strong> The Module Manager view needs to be updated to display all these modules. Check the updated view file.";
echo "</div>";
?>
