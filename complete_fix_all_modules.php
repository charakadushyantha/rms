<?php
/**
 * COMPLETE FIX - Add Columns AND Populate All 45 Modules
 */

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'rmsdb';

// Create connection
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>🔧 Complete Fix - Adding Columns and All Modules</h2>";

// STEP 1: Add columns if missing
echo "<h3>Step 1: Checking/Adding Columns</h3>";
$columns = $conn->query("SHOW COLUMNS FROM module_visibility");
$existing_columns = array();
while ($col = $columns->fetch_assoc()) {
    $existing_columns[] = $col['Field'];
}

if (!in_array('module_name', $existing_columns)) {
    $conn->query("ALTER TABLE `module_visibility` ADD COLUMN `module_name` VARCHAR(100) NULL AFTER `module_key`");
    echo "<p>✅ Added 'module_name' column</p>";
} else {
    echo "<p>✅ 'module_name' column exists</p>";
}

if (!in_array('section', $existing_columns)) {
    $conn->query("ALTER TABLE `module_visibility` ADD COLUMN `section` VARCHAR(50) NULL AFTER `module_name`");
    echo "<p>✅ Added 'section' column</p>";
} else {
    echo "<p>✅ 'section' column exists</p>";
}

// STEP 2: Define ALL 45 modules
echo "<h3>Step 2: Preparing All 45 Modules</h3>";

$all_modules = [
    // Main
    ['key' => 'dashboard', 'name' => 'Dashboard', 'section' => 'Main'],
    
    // Core Recruitment
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
    
    // Reports
    ['key' => 'reports', 'name' => 'MIS Reports', 'section' => 'Reports'],
    ['key' => 'custom_reports', 'name' => 'Custom Reports', 'section' => 'Reports'],
    ['key' => 'export_data', 'name' => 'Export Data', 'section' => 'Reports'],
    
    // Automation
    ['key' => 'marketing_automation', 'name' => 'Marketing Automation', 'section' => 'Automation'],
    ['key' => 'auto_distribution', 'name' => 'Auto Distribution', 'section' => 'Automation'],
    
    // Settings
    ['key' => 'roles', 'name' => 'Roles & Permissions', 'section' => 'Settings'],
    ['key' => 'signup_controller', 'name' => 'Signup Controller', 'section' => 'Settings'],
    ['key' => 'chatbot', 'name' => 'AI Chatbot', 'section' => 'Settings'],
    ['key' => 'setup', 'name' => 'System Setup', 'section' => 'Settings'],
    ['key' => 'module_manager', 'name' => 'Module Manager', 'section' => 'Settings'],
    ['key' => 'company_settings', 'name' => 'Company Settings', 'section' => 'Settings'],
    ['key' => 'email_configuration', 'name' => 'Email Configuration', 'section' => 'Settings'],
    ['key' => 'account', 'name' => 'My Account', 'section' => 'Settings'],
];

echo "<p>✅ Prepared " . count($all_modules) . " modules</p>";

// STEP 3: Insert or Update ALL modules
echo "<h3>Step 3: Inserting/Updating Modules</h3>";

$inserted = 0;
$updated = 0;

foreach ($all_modules as $module) {
    // Check if module exists
    $check = $conn->query("SELECT id FROM module_visibility WHERE module_key = '" . $conn->real_escape_string($module['key']) . "'");
    
    if ($check->num_rows > 0) {
        // Update existing
        $sql = "UPDATE module_visibility SET 
                module_name = '" . $conn->real_escape_string($module['name']) . "',
                section = '" . $conn->real_escape_string($module['section']) . "'
                WHERE module_key = '" . $conn->real_escape_string($module['key']) . "'";
        
        if ($conn->query($sql)) {
            $updated++;
        }
    } else {
        // Insert new
        $sql = "INSERT INTO module_visibility (module_key, module_name, section, is_visible) VALUES (
                '" . $conn->real_escape_string($module['key']) . "',
                '" . $conn->real_escape_string($module['name']) . "',
                '" . $conn->real_escape_string($module['section']) . "',
                1)";
        
        if ($conn->query($sql)) {
            $inserted++;
        }
    }
}

echo "<p>✅ Inserted <strong>$inserted</strong> new modules</p>";
echo "<p>✅ Updated <strong>$updated</strong> existing modules</p>";

// STEP 4: Verify
echo "<h3>Step 4: Verification</h3>";

$total = $conn->query("SELECT COUNT(*) as count FROM module_visibility")->fetch_assoc();
echo "<p><strong>Total modules in database:</strong> " . $total['count'] . "</p>";

$by_section = $conn->query("SELECT section, COUNT(*) as count FROM module_visibility GROUP BY section ORDER BY section");
echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
echo "<tr><th>Section</th><th>Count</th></tr>";
while ($row = $by_section->fetch_assoc()) {
    echo "<tr><td>" . $row['section'] . "</td><td>" . $row['count'] . "</td></tr>";
}
echo "</table>";

$conn->close();

echo "<br><br>";
echo "<div style='padding: 20px; background: #d1fae5; border: 2px solid #10b981; border-radius: 8px; margin: 20px 0;'>";
echo "<h3 style='color: #065f46;'>✅ Complete Fix Applied!</h3>";
echo "<p style='color: #065f46;'><strong>" . $total['count'] . "</strong> modules are now in the database with proper names and sections.</p>";
echo "<p style='color: #065f46; margin: 10px 0 0 0;'>Now open Module Manager to see all modules!</p>";
echo "<p style='margin: 10px 0;'><a href='Setup/module_manager' style='display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 6px; font-weight: bold;'>Open Module Manager →</a></p>";
echo "</div>";

echo "<br>";
echo "<div style='padding: 20px; margin: 20px 0; border-top: 2px solid #e5e7eb;'>";
echo "<a href='index.php' style='display: inline-block; padding: 10px 20px; background: #6b7280; color: white; text-decoration: none; border-radius: 6px;'>← Back to Home</a>";
echo "</div>";
?>
