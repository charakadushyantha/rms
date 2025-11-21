<?php
/**
 * Fix Module Data - Ensure all modules have proper names and sections
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

echo "<h2>🔧 Fixing Module Data</h2>";

// First, check current state
$result = $conn->query("SELECT COUNT(*) as total FROM module_visibility");
$count = $result->fetch_assoc();
echo "<p><strong>Total modules in database:</strong> " . $count['total'] . "</p>";

// Check if columns exist
$columns = $conn->query("SHOW COLUMNS FROM module_visibility");
$has_module_name = false;
$has_section = false;

echo "<p><strong>Current columns:</strong> ";
while ($col = $columns->fetch_assoc()) {
    echo $col['Field'] . ", ";
    if ($col['Field'] == 'module_name') $has_module_name = true;
    if ($col['Field'] == 'section') $has_section = true;
}
echo "</p>";

if (!$has_module_name || !$has_section) {
    echo "<div style='padding: 20px; background: #fee2e2; border: 2px solid #ef4444; border-radius: 8px; margin: 20px 0;'>";
    echo "<h3 style='color: #991b1b;'>❌ Missing Columns!</h3>";
    echo "<p style='color: #991b1b;'>Please run update_module_visibility_complete.php first!</p>";
    echo "</div>";
    $conn->close();
    exit;
}

// Now check if modules have NULL or empty names/sections
$null_check = $conn->query("SELECT COUNT(*) as total FROM module_visibility WHERE module_name IS NULL OR module_name = '' OR section IS NULL OR section = ''");
$null_count = $null_check->fetch_assoc();

echo "<p><strong>Modules with missing data:</strong> " . $null_count['total'] . "</p>";

if ($null_count['total'] > 0) {
    echo "<p>Fixing modules with missing data...</p>";
    
    // Define proper module data
    $module_data = [
        'dashboard' => ['name' => 'Dashboard', 'section' => 'Main'],
        'candidates' => ['name' => 'Candidates', 'section' => 'Core Recruitment'],
        'calendar' => ['name' => 'Calendar', 'section' => 'Core Recruitment'],
        'interviews' => ['name' => 'Interviews', 'section' => 'Core Recruitment'],
        'interview_management' => ['name' => 'Interview Management', 'section' => 'Core Recruitment'],
        'questions_bank' => ['name' => 'Questions Bank', 'section' => 'Core Recruitment'],
        'analytics' => ['name' => 'Analytics & Reports', 'section' => 'Core Recruitment'],
        'job_posting' => ['name' => 'Job Postings', 'section' => 'Job Management'],
        'job_analytics' => ['name' => 'Job Analytics', 'section' => 'Job Management'],
        'sales_marketing' => ['name' => 'Marketing Campaigns', 'section' => 'Recruitment Marketing'],
        'marketing_campaigns' => ['name' => 'Email Campaigns', 'section' => 'Recruitment Marketing'],
        'candidate_sourcing' => ['name' => 'Candidate Sourcing', 'section' => 'Recruitment Marketing'],
        'talent_pools' => ['name' => 'Talent Pools', 'section' => 'Recruitment Marketing'],
        'referral_program' => ['name' => 'Referral Program', 'section' => 'Recruitment Marketing'],
        'recruitment_events' => ['name' => 'Recruitment Events', 'section' => 'Recruitment Marketing'],
        'employee_advocacy' => ['name' => 'Employee Advocacy', 'section' => 'Recruitment Marketing'],
        'employer_branding' => ['name' => 'Employer Branding', 'section' => 'Recruitment Marketing'],
        'paid_advertising' => ['name' => 'Paid Advertising', 'section' => 'Recruitment Marketing'],
        'roi_tracking' => ['name' => 'ROI Tracking', 'section' => 'Recruitment Marketing'],
        'candidate_crm' => ['name' => 'Candidate CRM', 'section' => 'CRM & Engagement'],
        'media_gallery' => ['name' => 'Media Gallery', 'section' => 'CRM & Engagement'],
        'reviews_management' => ['name' => 'Reviews Management', 'section' => 'CRM & Engagement'],
        'awards_recognition' => ['name' => 'Awards & Recognition', 'section' => 'CRM & Engagement'],
        'integration_hub' => ['name' => 'Integration Hub', 'section' => 'Integrations'],
        'video_integrations' => ['name' => 'Video Platforms', 'section' => 'Integrations'],
        'assessment_integrations' => ['name' => 'Assessment Tools', 'section' => 'Integrations'],
        'background_check' => ['name' => 'Background Checks', 'section' => 'Integrations'],
        'ats_integrations' => ['name' => 'ATS Integrations', 'section' => 'Integrations'],
        'job_board_platforms' => ['name' => 'Job Board Platforms', 'section' => 'Integrations'],
        'recruiters' => ['name' => 'Recruiters', 'section' => 'User Management'],
        'interviewers' => ['name' => 'Interviewers', 'section' => 'User Management'],
        'candidate_users' => ['name' => 'Candidate Users', 'section' => 'User Management'],
        'reports' => ['name' => 'MIS Reports', 'section' => 'Reports'],
        'custom_reports' => ['name' => 'Custom Reports', 'section' => 'Reports'],
        'export_data' => ['name' => 'Export Data', 'section' => 'Reports'],
        'marketing_automation' => ['name' => 'Marketing Automation', 'section' => 'Automation'],
        'auto_distribution' => ['name' => 'Auto Distribution', 'section' => 'Automation'],
        'roles' => ['name' => 'Roles & Permissions', 'section' => 'Settings'],
        'signup_controller' => ['name' => 'Signup Controller', 'section' => 'Settings'],
        'chatbot' => ['name' => 'AI Chatbot', 'section' => 'Settings'],
        'setup' => ['name' => 'System Setup', 'section' => 'Settings'],
        'module_manager' => ['name' => 'Module Manager', 'section' => 'Settings'],
        'company_settings' => ['name' => 'Company Settings', 'section' => 'Settings'],
        'email_configuration' => ['name' => 'Email Configuration', 'section' => 'Settings'],
        'account' => ['name' => 'My Account', 'section' => 'Settings'],
    ];
    
    $updated = 0;
    foreach ($module_data as $key => $data) {
        $name = $conn->real_escape_string($data['name']);
        $section = $conn->real_escape_string($data['section']);
        $key_escaped = $conn->real_escape_string($key);
        
        $update_sql = "UPDATE module_visibility 
                      SET module_name = '$name', section = '$section' 
                      WHERE module_key = '$key_escaped'";
        
        if ($conn->query($update_sql)) {
            if ($conn->affected_rows > 0) {
                $updated++;
                echo "✅ Updated: $key → $name ($section)<br>";
            }
        }
    }
    
    echo "<br><p><strong>✅ Updated $updated modules</strong></p>";
}

// Final check
$final_result = $conn->query("SELECT COUNT(*) as total FROM module_visibility WHERE module_name IS NOT NULL AND module_name != '' AND section IS NOT NULL AND section != ''");
$final_count = $final_result->fetch_assoc();

echo "<div style='padding: 20px; background: #d1fae5; border: 2px solid #10b981; border-radius: 8px; margin: 20px 0;'>";
echo "<h3 style='color: #065f46;'>✅ Fix Complete!</h3>";
echo "<p style='color: #065f46;'><strong>" . $final_count['total'] . "</strong> modules now have proper names and sections.</p>";
echo "</div>";

// Show modules by section
echo "<h3>📋 Modules by Section</h3>";
$sections = $conn->query("SELECT section, COUNT(*) as count FROM module_visibility WHERE section IS NOT NULL AND section != '' GROUP BY section ORDER BY section");
echo "<table border='1' cellpadding='10' style='border-collapse: collapse; width: 100%;'>";
echo "<tr style='background: #667eea; color: white;'><th>Section</th><th>Module Count</th></tr>";
while ($sec = $sections->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $sec['section'] . "</td>";
    echo "<td style='text-align: center;'>" . $sec['count'] . "</td>";
    echo "</tr>";
}
echo "</table>";

$conn->close();

echo "<br><br>";
echo "<div style='padding: 20px; margin: 20px 0;'>";
echo "<a href='Setup/module_manager' style='display: inline-block; padding: 10px 20px; background: #10b981; color: white; text-decoration: none; border-radius: 6px; font-weight: bold;'>Open Module Manager →</a>";
echo " ";
echo "<a href='index.php' style='display: inline-block; padding: 10px 20px; background: #6b7280; color: white; text-decoration: none; border-radius: 6px;'>← Back to Home</a>";
echo "</div>";

echo "<div style='padding: 15px; background: #fef3c7; border-left: 4px solid #f59e0b; margin: 20px 0;'>";
echo "<strong>⚠️ Important:</strong> After running this script, clear your browser cache (Ctrl+Shift+Delete) and hard refresh (Ctrl+F5) the Module Manager page.";
echo "</div>";
?>
