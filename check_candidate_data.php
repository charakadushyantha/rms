<?php
/**
 * Check Candidate Data Structure
 * Analyzes all candidate-related tables and their relationships
 */

$conn = new mysqli('localhost', 'root', '', 'cmsadver_rmsdb');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<!DOCTYPE html><html><head><title>Candidate Data Analysis</title>";
echo "<style>
body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
.section { background: white; padding: 20px; margin: 20px 0; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
h2 { color: #667eea; border-bottom: 2px solid #667eea; padding-bottom: 10px; }
h3 { color: #764ba2; margin-top: 20px; }
table { width: 100%; border-collapse: collapse; margin: 10px 0; }
th, td { padding: 10px; text-align: left; border: 1px solid #ddd; }
th { background: #667eea; color: white; }
.info { background: #e3f2fd; padding: 10px; border-left: 4px solid #2196f3; margin: 10px 0; }
.warning { background: #fff3e0; padding: 10px; border-left: 4px solid #ff9800; margin: 10px 0; }
.success { background: #e8f5e9; padding: 10px; border-left: 4px solid #4caf50; margin: 10px 0; }
.error { background: #ffebee; padding: 10px; border-left: 4px solid #f44336; margin: 10px 0; }
</style></head><body>";

echo "<h1>🔍 Candidate Data Structure Analysis</h1>";

// 1. Check candidate_details table
echo "<div class='section'>";
echo "<h2>1. candidate_details Table</h2>";
$result = $conn->query("DESCRIBE candidate_details");
if ($result) {
    echo "<table><tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['Field']}</td><td>{$row['Type']}</td><td>{$row['Null']}</td><td>{$row['Key']}</td><td>{$row['Default']}</td></tr>";
    }
    echo "</table>";
    
    $count = $conn->query("SELECT COUNT(*) as cnt FROM candidate_details")->fetch_assoc()['cnt'];
    echo "<p class='info'><strong>Total Records:</strong> $count</p>";
    
    // Sample data
    echo "<h3>Sample Data (First 5):</h3>";
    $result = $conn->query("SELECT cd_id, cd_name, cd_email, cd_phone, cd_job_title, cd_status, cd_rec_username FROM candidate_details LIMIT 5");
    if ($result && $result->num_rows > 0) {
        echo "<table><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Job Title</th><th>Status</th><th>Recruiter</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>{$row['cd_id']}</td><td>{$row['cd_name']}</td><td>{$row['cd_email']}</td><td>{$row['cd_phone']}</td><td>{$row['cd_job_title']}</td><td>{$row['cd_status']}</td><td>{$row['cd_rec_username']}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='warning'>No data found</p>";
    }
} else {
    echo "<p class='error'>Table does not exist</p>";
}
echo "</div>";

// 2. Check interviews table
echo "<div class='section'>";
echo "<h2>2. interviews Table</h2>";
$result = $conn->query("DESCRIBE interviews");
if ($result) {
    echo "<table><tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['Field']}</td><td>{$row['Type']}</td><td>{$row['Null']}</td><td>{$row['Key']}</td><td>{$row['Default']}</td></tr>";
    }
    echo "</table>";
    
    $count = $conn->query("SELECT COUNT(*) as cnt FROM interviews")->fetch_assoc()['cnt'];
    echo "<p class='info'><strong>Total Records:</strong> $count</p>";
    
    // Sample data
    echo "<h3>Sample Data (First 5):</h3>";
    $result = $conn->query("SELECT * FROM interviews LIMIT 5");
    if ($result && $result->num_rows > 0) {
        echo "<table><tr><th>ID</th><th>Flow ID</th><th>Candidate Name</th><th>Candidate Email</th><th>Status</th><th>Created At</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>{$row['id']}</td><td>{$row['flow_id']}</td><td>{$row['candidate_name']}</td><td>{$row['candidate_email']}</td><td>{$row['status']}</td><td>{$row['created_at']}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='warning'>No data found</p>";
    }
} else {
    echo "<p class='error'>Table does not exist</p>";
}
echo "</div>";

// 3. Check candidate_applications table
echo "<div class='section'>";
echo "<h2>3. candidate_applications Table</h2>";
$result = $conn->query("DESCRIBE candidate_applications");
if ($result) {
    echo "<table><tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['Field']}</td><td>{$row['Type']}</td><td>{$row['Null']}</td><td>{$row['Key']}</td><td>{$row['Default']}</td></tr>";
    }
    echo "</table>";
    
    $count = $conn->query("SELECT COUNT(*) as cnt FROM candidate_applications")->fetch_assoc()['cnt'];
    echo "<p class='info'><strong>Total Records:</strong> $count</p>";
} else {
    echo "<p class='error'>Table does not exist</p>";
}
echo "</div>";

// 4. Check users table for candidates
echo "<div class='section'>";
echo "<h2>4. users Table (Candidate Role)</h2>";
$result = $conn->query("SELECT COUNT(*) as cnt FROM users WHERE u_role = 'candidate'");
if ($result) {
    $count = $result->fetch_assoc()['cnt'];
    echo "<p class='info'><strong>Total Candidate Users:</strong> $count</p>";
    
    // Sample data
    echo "<h3>Sample Candidate Users (First 5):</h3>";
    $result = $conn->query("SELECT u_id, u_username, u_email, u_role, u_status FROM users WHERE u_role = 'candidate' LIMIT 5");
    if ($result && $result->num_rows > 0) {
        echo "<table><tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Status</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>{$row['u_id']}</td><td>{$row['u_username']}</td><td>{$row['u_email']}</td><td>{$row['u_role']}</td><td>{$row['u_status']}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='warning'>No candidate users found</p>";
    }
}
echo "</div>";

// 5. Data Consistency Analysis
echo "<div class='section'>";
echo "<h2>5. Data Consistency Analysis</h2>";

// Check if candidate_details emails match users table
$result = $conn->query("
    SELECT 
        (SELECT COUNT(DISTINCT cd_email) FROM candidate_details WHERE cd_email IS NOT NULL AND cd_email != '') as cd_emails,
        (SELECT COUNT(*) FROM users WHERE u_role = 'candidate') as user_candidates,
        (SELECT COUNT(*) FROM candidate_details cd 
         INNER JOIN users u ON cd.cd_email = u.u_email 
         WHERE u.u_role = 'candidate') as matched_records
");

if ($result) {
    $row = $result->fetch_assoc();
    echo "<table>";
    echo "<tr><th>Metric</th><th>Count</th></tr>";
    echo "<tr><td>Unique emails in candidate_details</td><td>{$row['cd_emails']}</td></tr>";
    echo "<tr><td>Candidate users in users table</td><td>{$row['user_candidates']}</td></tr>";
    echo "<tr><td>Matched records (cd_email = u_email)</td><td>{$row['matched_records']}</td></tr>";
    echo "</table>";
    
    if ($row['cd_emails'] != $row['user_candidates']) {
        echo "<p class='warning'><strong>⚠️ Inconsistency Detected:</strong> candidate_details has {$row['cd_emails']} unique emails but users table has {$row['user_candidates']} candidate users.</p>";
    } else {
        echo "<p class='success'><strong>✅ Consistency Check:</strong> Data appears consistent between tables.</p>";
    }
}

// Check interviews vs candidate_details
$result = $conn->query("
    SELECT 
        (SELECT COUNT(*) FROM interviews) as total_interviews,
        (SELECT COUNT(*) FROM interviews i 
         INNER JOIN candidate_details cd ON i.candidate_email = cd.cd_email) as interviews_with_cd_match
");

if ($result) {
    $row = $result->fetch_assoc();
    echo "<h3>Interview-Candidate Relationship:</h3>";
    echo "<table>";
    echo "<tr><th>Metric</th><th>Count</th></tr>";
    echo "<tr><td>Total interviews</td><td>{$row['total_interviews']}</td></tr>";
    echo "<tr><td>Interviews matching candidate_details</td><td>{$row['interviews_with_cd_match']}</td></tr>";
    echo "</table>";
    
    if ($row['total_interviews'] > 0 && $row['interviews_with_cd_match'] < $row['total_interviews']) {
        $unmatched = $row['total_interviews'] - $row['interviews_with_cd_match'];
        echo "<p class='warning'><strong>⚠️ Issue:</strong> $unmatched interviews don't have matching candidate_details records.</p>";
    }
}

echo "</div>";

// 6. Recommendations
echo "<div class='section'>";
echo "<h2>6. Recommendations</h2>";
echo "<div class='info'>";
echo "<h3>Current Data Structure:</h3>";
echo "<ul>";
echo "<li><strong>candidate_details:</strong> Main candidate information (added by recruiters)</li>";
echo "<li><strong>users (role=candidate):</strong> Candidate login accounts</li>";
echo "<li><strong>interviews:</strong> Interview records with candidate_name and candidate_email</li>";
echo "<li><strong>candidate_applications:</strong> Job applications submitted by candidates</li>";
echo "</ul>";

echo "<h3>For Create Interview Form:</h3>";
echo "<ul>";
echo "<li><strong>Option 1:</strong> Use candidate_details table (current implementation) - Shows all candidates added by recruiters</li>";
echo "<li><strong>Option 2:</strong> Use users table with role='candidate' - Shows only registered candidate users</li>";
echo "<li><strong>Option 3:</strong> Combine both - Show candidates from both sources</li>";
echo "</ul>";
echo "</div>";
echo "</div>";

echo "</body></html>";

$conn->close();
?>
