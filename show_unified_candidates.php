<?php
/**
 * Show Unified Candidate Data
 * Displays candidates from both candidate_details and users tables
 */

$conn = new mysqli('localhost', 'root', '', 'cmsadver_rmsdb');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<!DOCTYPE html><html><head><title>Unified Candidate Data</title>";
echo "<style>
body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
.header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; border-radius: 10px; margin-bottom: 30px; }
.section { background: white; padding: 20px; margin: 20px 0; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
h2 { color: #667eea; border-bottom: 2px solid #667eea; padding-bottom: 10px; }
h3 { color: #764ba2; margin-top: 20px; }
table { width: 100%; border-collapse: collapse; margin: 10px 0; font-size: 14px; }
th, td { padding: 12px 8px; text-align: left; border: 1px solid #ddd; }
th { background: #667eea; color: white; font-weight: 600; }
tr:nth-child(even) { background: #f8f9fa; }
tr:hover { background: #e3f2fd; }
.badge { padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: 600; display: inline-block; }
.badge-success { background: #e8f5e9; color: #2e7d32; }
.badge-warning { background: #fff3e0; color: #e65100; }
.badge-info { background: #e3f2fd; color: #1976d2; }
.badge-secondary { background: #e0e0e0; color: #424242; }
.stats { display: flex; gap: 20px; margin: 20px 0; }
.stat-card { flex: 1; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center; }
.stat-number { font-size: 36px; font-weight: bold; color: #667eea; }
.stat-label { color: #666; margin-top: 10px; }
.info { background: #e3f2fd; padding: 15px; border-left: 4px solid #2196f3; margin: 15px 0; border-radius: 4px; }
.success { background: #e8f5e9; padding: 15px; border-left: 4px solid #4caf50; margin: 15px 0; border-radius: 4px; }
.warning { background: #fff3e0; padding: 15px; border-left: 4px solid #ff9800; margin: 15px 0; border-radius: 4px; }
</style></head><body>";

echo "<div class='header'>";
echo "<h1>🎯 Unified Candidate Data Analysis</h1>";
echo "<p>Combining candidates from both <strong>candidate_details</strong> and <strong>users</strong> tables</p>";
echo "</div>";

// Get statistics
$stats = [];

// From candidate_details
$result = $conn->query("SELECT COUNT(*) as cnt FROM candidate_details WHERE cd_email IS NOT NULL AND cd_email != ''");
$stats['cd_total'] = $result->fetch_assoc()['cnt'];

// From users (candidates)
$result = $conn->query("SELECT COUNT(*) as cnt FROM users WHERE u_role = 'candidate'");
$stats['users_total'] = $result->fetch_assoc()['cnt'];

// Candidates with accounts
$result = $conn->query("
    SELECT COUNT(DISTINCT cd.cd_email) as cnt 
    FROM candidate_details cd 
    INNER JOIN users u ON cd.cd_email = u.u_email 
    WHERE u.u_role = 'candidate' 
    AND cd.cd_email IS NOT NULL 
    AND cd.cd_email != ''
");
$stats['with_accounts'] = $result->fetch_assoc()['cnt'];

// Candidates without accounts
$stats['without_accounts'] = $stats['cd_total'] - $stats['with_accounts'];

// Users not in candidate_details
$result = $conn->query("
    SELECT COUNT(*) as cnt 
    FROM users u 
    WHERE u.u_role = 'candidate' 
    AND u.u_email NOT IN (SELECT cd_email FROM candidate_details WHERE cd_email IS NOT NULL AND cd_email != '')
");
$stats['users_only'] = $result->fetch_assoc()['cnt'];

// Total unified
$stats['total_unified'] = $stats['cd_total'] + $stats['users_only'];

// Display statistics
echo "<div class='stats'>";
echo "<div class='stat-card'><div class='stat-number'>{$stats['total_unified']}</div><div class='stat-label'>Total Unified Candidates</div></div>";
echo "<div class='stat-card'><div class='stat-number'>{$stats['cd_total']}</div><div class='stat-label'>From candidate_details</div></div>";
echo "<div class='stat-card'><div class='stat-number'>{$stats['users_total']}</div><div class='stat-label'>Registered Users</div></div>";
echo "<div class='stat-card'><div class='stat-number'>{$stats['with_accounts']}</div><div class='stat-label'>With User Accounts</div></div>";
echo "</div>";

// Section 1: Candidates from candidate_details with account status
echo "<div class='section'>";
echo "<h2>1. Candidates from candidate_details Table</h2>";
echo "<p>Shows all candidates added by recruiters, with their user account status</p>";

$query = "
    SELECT 
        cd.cd_id,
        cd.cd_name,
        cd.cd_email,
        cd.cd_phone,
        cd.cd_job_title,
        cd.cd_status,
        cd.cd_rec_username,
        u.u_id,
        u.u_status as user_status,
        CASE WHEN u.u_id IS NOT NULL THEN 1 ELSE 0 END as has_account
    FROM candidate_details cd
    LEFT JOIN users u ON cd.cd_email = u.u_email AND u.u_role = 'candidate'
    WHERE cd.cd_email IS NOT NULL AND cd.cd_email != ''
    GROUP BY cd.cd_email
    ORDER BY cd.cd_name ASC
";

$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Job Title</th><th>Status</th><th>Recruiter</th><th>Account Status</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        $has_account = $row['has_account'] == 1;
        $badge_class = $has_account ? 'badge-success' : 'badge-warning';
        $badge_text = $has_account ? '✓ Has Account' : '⚠ No Account';
        $user_status = $has_account ? " (User: {$row['user_status']})" : '';
        
        echo "<tr>";
        echo "<td>{$row['cd_id']}</td>";
        echo "<td>{$row['cd_name']}</td>";
        echo "<td>{$row['cd_email']}</td>";
        echo "<td>{$row['cd_phone']}</td>";
        echo "<td>{$row['cd_job_title']}</td>";
        echo "<td><span class='badge badge-info'>{$row['cd_status']}</span></td>";
        echo "<td>{$row['cd_rec_username']}</td>";
        echo "<td><span class='badge $badge_class'>$badge_text</span>$user_status</td>";
        echo "</tr>";
    }
    
    echo "</table>";
} else {
    echo "<p class='warning'>No candidates found in candidate_details</p>";
}

echo "</div>";

// Section 2: Registered users NOT in candidate_details
echo "<div class='section'>";
echo "<h2>2. Registered Candidate Users (Not in candidate_details)</h2>";
echo "<p>Shows candidate users who registered but are not in the candidate_details table</p>";

$query = "
    SELECT 
        u.u_id,
        u.u_username,
        u.u_email,
        u.u_status,
        u.u_created_at
    FROM users u
    WHERE u.u_role = 'candidate'
    AND u.u_email NOT IN (SELECT cd_email FROM candidate_details WHERE cd_email IS NOT NULL AND cd_email != '')
    ORDER BY u.u_username ASC
";

$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>User ID</th><th>Username</th><th>Email</th><th>Status</th><th>Created At</th><th>Source</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['u_id']}</td>";
        echo "<td>{$row['u_username']}</td>";
        echo "<td>{$row['u_email']}</td>";
        echo "<td><span class='badge badge-info'>{$row['u_status']}</span></td>";
        echo "<td>{$row['u_created_at']}</td>";
        echo "<td><span class='badge badge-secondary'>Users Only</span></td>";
        echo "</tr>";
    }
    
    echo "</table>";
} else {
    echo "<p class='success'>✓ All registered candidate users are in candidate_details table</p>";
}

echo "</div>";

// Section 3: Summary and Recommendations
echo "<div class='section'>";
echo "<h2>3. Implementation Summary</h2>";

echo "<div class='success'>";
echo "<h3>✅ Unified Approach Benefits:</h3>";
echo "<ul>";
echo "<li><strong>Complete Coverage:</strong> Shows all {$stats['total_unified']} candidates from both sources</li>";
echo "<li><strong>Account Status:</strong> Clearly indicates which candidates have user accounts ({$stats['with_accounts']} candidates)</li>";
echo "<li><strong>No Data Loss:</strong> Includes {$stats['users_only']} registered users not in candidate_details</li>";
echo "<li><strong>Better UX:</strong> Users can see account status when creating interviews</li>";
echo "</ul>";
echo "</div>";

echo "<div class='info'>";
echo "<h3>📊 Data Breakdown:</h3>";
echo "<ul>";
echo "<li><strong>candidate_details entries:</strong> {$stats['cd_total']}</li>";
echo "<li><strong>Registered candidate users:</strong> {$stats['users_total']}</li>";
echo "<li><strong>Candidates with accounts:</strong> {$stats['with_accounts']} (can login to portal)</li>";
echo "<li><strong>Candidates without accounts:</strong> {$stats['without_accounts']} (added by recruiters only)</li>";
echo "<li><strong>Users not in candidate_details:</strong> {$stats['users_only']} (registered but not added by recruiter)</li>";
echo "</ul>";
echo "</div>";

if ($stats['without_accounts'] > 0) {
    echo "<div class='warning'>";
    echo "<h3>⚠️ Action Items:</h3>";
    echo "<p><strong>{$stats['without_accounts']} candidates don't have user accounts.</strong> Consider:</p>";
    echo "<ul>";
    echo "<li>Creating user accounts for these candidates so they can access the candidate portal</li>";
    echo "<li>Sending them registration invitations</li>";
    echo "<li>Or keeping them as recruiter-managed only (no portal access needed)</li>";
    echo "</ul>";
    echo "</div>";
}

echo "</div>";

echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<a href='http://localhost/rms/interview/create_interview' style='padding: 15px 30px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border-radius: 8px; font-weight: 600; display: inline-block;'>";
echo "🎯 Go to Create Interview Form";
echo "</a>";
echo "</div>";

echo "</body></html>";

$conn->close();
?>
