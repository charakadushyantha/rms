<?php
/**
 * Add Sample Data for Real-Time Dashboard
 * Run: http://localhost/rms/add_sample_data.php
 */

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'rmsdb';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

echo "<h1>🎯 Adding Sample Data to Real-Time Dashboard</h1>";
echo "<hr>";

// Check if required tables exist
$required_tables = ['candidates', 'pipeline_stages', 'candidate_pipeline'];
$missing_tables = [];

foreach ($required_tables as $table) {
    $result = $conn->query("SHOW TABLES LIKE '$table'");
    if ($result->num_rows == 0) {
        $missing_tables[] = $table;
    }
}

if (!empty($missing_tables)) {
    echo "<div style='background: #ffebee; padding: 20px; border-left: 4px solid #f44336; margin: 20px 0;'>";
    echo "<h3 style='color: #c62828; margin-top: 0;'>❌ Missing Tables</h3>";
    echo "<p>The following tables are missing:</p>";
    echo "<ul>";
    foreach ($missing_tables as $table) {
        echo "<li><strong>$table</strong></li>";
    }
    echo "</ul>";
    echo "<p>Please create the candidates table first or run the main database setup.</p>";
    echo "</div>";
    die();
}

echo "<p style='color: green;'>✅ All required tables found</p>";
echo "<hr>";

// Sample candidates data
$sample_candidates = [
    ['name' => 'John Smith', 'email' => 'john.smith@email.com', 'phone' => '555-0101', 'position' => 'Senior Software Engineer', 'stage' => 1, 'urgency' => 'medium'],
    ['name' => 'Sarah Johnson', 'email' => 'sarah.j@email.com', 'phone' => '555-0102', 'position' => 'Frontend Developer', 'stage' => 2, 'urgency' => 'high'],
    ['name' => 'Michael Chen', 'email' => 'mchen@email.com', 'phone' => '555-0103', 'position' => 'Full Stack Developer', 'stage' => 2, 'urgency' => 'medium'],
    ['name' => 'Emily Davis', 'email' => 'emily.d@email.com', 'phone' => '555-0104', 'position' => 'UI/UX Designer', 'stage' => 3, 'urgency' => 'high'],
    ['name' => 'David Wilson', 'email' => 'dwilson@email.com', 'phone' => '555-0105', 'position' => 'Backend Developer', 'stage' => 3, 'urgency' => 'critical'],
    ['name' => 'Lisa Anderson', 'email' => 'lisa.a@email.com', 'phone' => '555-0106', 'position' => 'DevOps Engineer', 'stage' => 4, 'urgency' => 'medium'],
    ['name' => 'James Martinez', 'email' => 'jmartinez@email.com', 'phone' => '555-0107', 'position' => 'Data Scientist', 'stage' => 4, 'urgency' => 'high'],
    ['name' => 'Jennifer Taylor', 'email' => 'jtaylor@email.com', 'phone' => '555-0108', 'position' => 'Product Manager', 'stage' => 5, 'urgency' => 'medium'],
    ['name' => 'Robert Brown', 'email' => 'rbrown@email.com', 'phone' => '555-0109', 'position' => 'QA Engineer', 'stage' => 5, 'urgency' => 'low'],
    ['name' => 'Maria Garcia', 'email' => 'mgarcia@email.com', 'phone' => '555-0110', 'position' => 'Mobile Developer', 'stage' => 6, 'urgency' => 'high'],
    ['name' => 'William Lee', 'email' => 'wlee@email.com', 'phone' => '555-0111', 'position' => 'Security Engineer', 'stage' => 1, 'urgency' => 'medium'],
    ['name' => 'Jessica White', 'email' => 'jwhite@email.com', 'phone' => '555-0112', 'position' => 'Cloud Architect', 'stage' => 1, 'urgency' => 'low'],
    ['name' => 'Christopher Hall', 'email' => 'chall@email.com', 'phone' => '555-0113', 'position' => 'Machine Learning Engineer', 'stage' => 2, 'urgency' => 'critical'],
    ['name' => 'Amanda Young', 'email' => 'ayoung@email.com', 'phone' => '555-0114', 'position' => 'Scrum Master', 'stage' => 3, 'urgency' => 'medium'],
    ['name' => 'Daniel King', 'email' => 'dking@email.com', 'phone' => '555-0115', 'position' => 'Technical Writer', 'stage' => 4, 'urgency' => 'low'],
];

$candidates_added = 0;
$pipeline_added = 0;

// Check if candidates table exists
$result = $conn->query("SHOW TABLES LIKE 'candidates'");
if ($result->num_rows > 0) {
    echo "<h3>Adding Candidates...</h3>";
    
    foreach ($sample_candidates as $candidate) {
        // Check if candidate already exists
        $check = $conn->query("SELECT id FROM candidates WHERE email = '{$candidate['email']}'");
        
        if ($check->num_rows == 0) {
            // Insert candidate
            $sql = "INSERT INTO candidates (name, email, phone, position_applied, created_at) 
                    VALUES ('{$candidate['name']}', '{$candidate['email']}', '{$candidate['phone']}', '{$candidate['position']}', NOW())";
            
            if ($conn->query($sql)) {
                $candidate_id = $conn->insert_id;
                $candidates_added++;
                echo "✅ Added: <strong>{$candidate['name']}</strong> - {$candidate['position']}<br>";
                
                // Add to pipeline (only if not already in pipeline)
                $check_pipeline = $conn->query("SELECT id FROM candidate_pipeline WHERE candidate_id = $candidate_id");
                
                if ($check_pipeline->num_rows == 0) {
                    $days_ago = rand(1, 14);
                    $moved_at = date('Y-m-d H:i:s', strtotime("-$days_ago days"));
                    
                    $pipeline_sql = "INSERT INTO candidate_pipeline (candidate_id, stage_id, urgency_level, moved_at, days_in_stage) 
                                    VALUES ($candidate_id, {$candidate['stage']}, '{$candidate['urgency']}', '$moved_at', $days_ago)";
                    
                    if ($conn->query($pipeline_sql)) {
                        $pipeline_added++;
                    
                        // Add activity log
                        $log_sql = "INSERT INTO pipeline_activity_log (candidate_id, user_id, action_type, action_data, created_at) 
                                   VALUES ($candidate_id, 1, 'added_to_pipeline', '{\"stage_id\": {$candidate['stage']}}', '$moved_at')";
                        $conn->query($log_sql);
                    }
                }
            }
        } else {
            echo "⚠️ Skipped: <strong>{$candidate['name']}</strong> (already exists)<br>";
        }
    }
} else {
    echo "<p style='color:red;'>❌ Candidates table not found. Please create it first.</p>";
}

echo "<hr>";
echo "<h3>📊 Summary</h3>";
echo "<p>✅ Candidates added: <strong>$candidates_added</strong></p>";
echo "<p>✅ Pipeline entries added: <strong>$pipeline_added</strong></p>";

// Add some sample hiring decisions
echo "<hr>";
echo "<h3>Adding Sample Hiring Decisions...</h3>";

$decisions_added = 0;
$votes_added = 0;

// Get some candidate IDs
$result = $conn->query("SELECT id FROM candidates LIMIT 5");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $candidate_id = $row['id'];
        
        // Create a decision
        $decision_sql = "INSERT INTO hiring_decisions (candidate_id, decision_type, created_by, status, created_at) 
                        VALUES ($candidate_id, 'move_forward', 1, 'open', NOW())";
        
        if ($conn->query($decision_sql)) {
            $decision_id = $conn->insert_id;
            $decisions_added++;
            
            // Add some votes
            $votes = [
                ['user_id' => 1, 'vote' => 'yes', 'comment' => 'Strong technical skills'],
                ['user_id' => 2, 'vote' => 'yes', 'comment' => 'Great culture fit'],
                ['user_id' => 3, 'vote' => 'abstain', 'comment' => 'Need more information'],
            ];
            
            foreach ($votes as $vote) {
                $vote_sql = "INSERT INTO decision_votes (decision_id, user_id, vote, comment, voted_at) 
                            VALUES ($decision_id, {$vote['user_id']}, '{$vote['vote']}', '{$vote['comment']}', NOW())";
                if ($conn->query($vote_sql)) {
                    $votes_added++;
                }
            }
        }
    }
    
    echo "<p>✅ Decisions created: <strong>$decisions_added</strong></p>";
    echo "<p>✅ Votes added: <strong>$votes_added</strong></p>";
}

// Add sample interviews
echo "<hr>";
echo "<h3>Adding Sample Interviews...</h3>";

$interviews_added = 0;

$result = $conn->query("SELECT id FROM candidates LIMIT 8");
if ($result->num_rows > 0) {
    $interview_types = ['phone_screen', 'technical', 'behavioral', 'final'];
    $statuses = ['scheduled', 'completed', 'scheduled'];
    
    while ($row = $result->fetch_assoc()) {
        $candidate_id = $row['id'];
        $days_ahead = rand(1, 7);
        $interview_date = date('Y-m-d H:i:s', strtotime("+$days_ahead days"));
        $type = $interview_types[array_rand($interview_types)];
        $status = $statuses[array_rand($statuses)];
        
        $interview_sql = "INSERT INTO interview_panels (candidate_id, interviewer_id, interview_date, duration_minutes, interview_type, status, created_at) 
                         VALUES ($candidate_id, 1, '$interview_date', 60, '$type', '$status', NOW())";
        
        if ($conn->query($interview_sql)) {
            $interviews_added++;
        }
    }
    
    echo "<p>✅ Interviews scheduled: <strong>$interviews_added</strong></p>";
}

// Update dashboard metrics
echo "<hr>";
echo "<h3>Updating Dashboard Metrics...</h3>";

$metrics = [
    ['metric_name' => 'total_candidates', 'metric_value' => $candidates_added],
    ['metric_name' => 'avg_days_in_pipeline', 'metric_value' => 7.5],
    ['metric_name' => 'urgent_count', 'metric_value' => 5],
    ['metric_name' => 'today_interviews', 'metric_value' => 3],
];

foreach ($metrics as $metric) {
    $sql = "INSERT INTO dashboard_metrics (metric_name, metric_value, updated_at) 
            VALUES ('{$metric['metric_name']}', {$metric['metric_value']}, NOW())
            ON DUPLICATE KEY UPDATE metric_value = {$metric['metric_value']}, updated_at = NOW()";
    $conn->query($sql);
}

echo "<p>✅ Metrics updated</p>";

echo "<hr>";
echo "<div style='background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; border-radius: 12px; text-align: center;'>";
echo "<h2>🎉 Sample Data Added Successfully!</h2>";
echo "<p style='font-size: 18px; margin: 20px 0;'>Your Real-Time Dashboard is now populated with sample data</p>";
echo "<a href='realtime_dashboard' style='display: inline-block; background: white; color: #667eea; padding: 15px 30px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 18px;'>→ Open Dashboard</a>";
echo "</div>";

echo "<hr>";
echo "<h3>✨ What You Can Now Do:</h3>";
echo "<ul style='font-size: 16px; line-height: 2;'>";
echo "<li>🎯 <strong>Drag & Drop:</strong> Move candidates between pipeline stages</li>";
echo "<li>📊 <strong>View Metrics:</strong> See live statistics at the top</li>";
echo "<li>🗳️ <strong>Vote on Candidates:</strong> Click the vote icon on candidate cards</li>";
echo "<li>📅 <strong>Schedule Interviews:</strong> Coordinate with team members</li>";
echo "<li>🔴 <strong>Real-Time Updates:</strong> Dashboard refreshes every 5 seconds</li>";
echo "<li>⚡ <strong>Urgency Levels:</strong> Color-coded priority indicators</li>";
echo "</ul>";

echo "<p style='margin-top: 30px;'><strong>You can delete this file after running it once.</strong></p>";

$conn->close();
?>

<style>
    body {
        font-family: Arial, sans-serif;
        max-width: 1000px;
        margin: 50px auto;
        padding: 20px;
        background: #f5f5f5;
    }
    h1 { color: #333; }
    h3 { color: #667eea; margin-top: 20px; }
    a {
        color: #667eea;
        text-decoration: none;
        font-weight: bold;
    }
    a:hover {
        text-decoration: underline;
    }
</style>
