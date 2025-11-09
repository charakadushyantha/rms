<?php
/**
 * Comprehensive Sample Data Generator
 * Adds realistic test data for candidates, interviews, and schedules
 * 
 * Run this file once by accessing: http://localhost/rms/add_comprehensive_sample_data.php
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

echo "<h2>Adding Comprehensive Sample Data...</h2>";
echo "<style>
    body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
    .success { color: green; }
    .error { color: red; }
    .info { color: blue; }
    h3 { margin-top: 30px; border-bottom: 2px solid #667eea; padding-bottom: 10px; }
</style>";

// Sample candidate data
$candidates = [
    [
        'name' => 'Sarah Johnson',
        'email' => 'sarah.johnson@email.com',
        'phone' => '+1 555-0101',
        'gender' => 'Female',
        'job_title' => 'Software Engineer',
        'source' => 'LinkedIn',
        'status' => 'Interested',
        'current_status' => 'Completed phone screening, awaiting technical interview',
        'interview_status' => 0,
        'interview_round' => 0.25
    ],
    [
        'name' => 'Michael Chen',
        'email' => 'michael.chen@email.com',
        'phone' => '+1 555-0102',
        'gender' => 'Male',
        'job_title' => 'Frontend Developer',
        'source' => 'Indeed',
        'status' => 'Interested',
        'current_status' => 'First round interview scheduled',
        'interview_status' => 1,
        'interview_round' => 0.5
    ],
    [
        'name' => 'Emily Rodriguez',
        'email' => 'emily.rodriguez@email.com',
        'phone' => '+1 555-0103',
        'gender' => 'Female',
        'job_title' => 'Full Stack Developer',
        'source' => 'Company Website',
        'status' => 'Interested',
        'current_status' => 'Passed technical round, HR interview pending',
        'interview_status' => 1,
        'interview_round' => 0.75
    ],
    [
        'name' => 'David Kim',
        'email' => 'david.kim@email.com',
        'phone' => '+1 555-0104',
        'gender' => 'Male',
        'job_title' => 'Backend Developer',
        'source' => 'Referral',
        'status' => 'Interested',
        'current_status' => 'Successfully completed all rounds',
        'interview_status' => 1,
        'interview_round' => 1
    ],
    [
        'name' => 'Jessica Martinez',
        'email' => 'jessica.martinez@email.com',
        'phone' => '+1 555-0105',
        'gender' => 'Female',
        'job_title' => 'UI/UX Designer',
        'source' => 'LinkedIn',
        'status' => 'Not Picking up Call',
        'current_status' => 'Multiple call attempts made',
        'interview_status' => 0,
        'interview_round' => 0
    ],
    [
        'name' => 'Robert Taylor',
        'email' => 'robert.taylor@email.com',
        'phone' => '+1 555-0106',
        'gender' => 'Male',
        'job_title' => 'DevOps Engineer',
        'source' => 'Job Fair',
        'status' => 'Call Back Later',
        'current_status' => 'Requested callback next week',
        'interview_status' => 0,
        'interview_round' => 0
    ],
    [
        'name' => 'Amanda White',
        'email' => 'amanda.white@email.com',
        'phone' => '+1 555-0107',
        'gender' => 'Female',
        'job_title' => 'Product Manager',
        'source' => 'LinkedIn',
        'status' => 'Interested',
        'current_status' => 'Initial screening completed',
        'interview_status' => 0,
        'interview_round' => 0.25
    ],
    [
        'name' => 'James Anderson',
        'email' => 'james.anderson@email.com',
        'phone' => '+1 555-0108',
        'gender' => 'Male',
        'job_title' => 'QA Engineer',
        'source' => 'Indeed',
        'status' => 'Interested',
        'current_status' => 'Technical assessment in progress',
        'interview_status' => 1,
        'interview_round' => 0.5
    ],
    [
        'name' => 'Lisa Thompson',
        'email' => 'lisa.thompson@email.com',
        'phone' => '+1 555-0109',
        'gender' => 'Female',
        'job_title' => 'Data Scientist',
        'source' => 'Company Website',
        'status' => 'Not Interested',
        'current_status' => 'Declined offer due to location',
        'interview_status' => 0,
        'interview_round' => 0
    ],
    [
        'name' => 'Christopher Lee',
        'email' => 'christopher.lee@email.com',
        'phone' => '+1 555-0110',
        'gender' => 'Male',
        'job_title' => 'Software Engineer',
        'source' => 'Referral',
        'status' => 'Interested',
        'current_status' => 'Final round with CEO scheduled',
        'interview_status' => 1,
        'interview_round' => 0.75
    ]
];

echo "<h3>Detecting Database Schema</h3>";

// First, let's check what columns exist in candidate_details table
$columns_query = "SHOW COLUMNS FROM candidate_details";
$columns_result = $conn->query($columns_query);

echo "<p class='info'>Columns in candidate_details table:</p><ul>";
$available_columns = [];
while ($col = $columns_result->fetch_assoc()) {
    echo "<li>{$col['Field']} ({$col['Type']})</li>";
    $available_columns[] = $col['Field'];
}
echo "</ul>";

echo "<h3>Adding Candidates</h3>";

// Get a recruiter username (assuming 'ucsc' exists, or use the first available)
$recruiter_query = "SELECT u_username FROM users WHERE u_role = 'Recruiter' LIMIT 1";
$recruiter_result = $conn->query($recruiter_query);
$recruiter = $recruiter_result->fetch_assoc();
$recruiter_username = $recruiter ? $recruiter['u_username'] : 'ucsc';

echo "<p class='info'>Using recruiter: <strong>$recruiter_username</strong></p>";

$inserted_count = 0;
$candidate_ids = [];

foreach ($candidates as $candidate) {
    // Check if candidate already exists
    $check_sql = "SELECT cd_id FROM candidate_details WHERE cd_email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $candidate['email']);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo "<p class='info'>⚠ Candidate {$candidate['name']} already exists, skipping...</p>";
        $row = $result->fetch_assoc();
        $candidate_ids[] = $row['cd_id'];
        continue;
    }
    
    // Build INSERT query based on available columns
    $columns = ['cd_name', 'cd_email', 'cd_phone', 'cd_gender', 'cd_job_title', 'cd_source', 'cd_status'];
    $values = [$candidate['name'], $candidate['email'], $candidate['phone'], $candidate['gender'], $candidate['job_title'], $candidate['source'], $candidate['status']];
    $types = 'sssssss';
    
    // Add optional columns if they exist
    if (in_array('cd_interview_status', $available_columns)) {
        $columns[] = 'cd_interview_status';
        $values[] = $candidate['interview_status'];
        $types .= 'i';
    }
    
    if (in_array('cd_interview_round', $available_columns)) {
        $columns[] = 'cd_interview_round';
        $values[] = $candidate['interview_round'];
        $types .= 'd';
    }
    
    if (in_array('cd_rec_username', $available_columns)) {
        $columns[] = 'cd_rec_username';
        $values[] = $recruiter_username;
        $types .= 's';
    } elseif (in_array('cd_recruiter', $available_columns)) {
        $columns[] = 'cd_recruiter';
        $values[] = $recruiter_username;
        $types .= 's';
    }
    
    if (in_array('created_at', $available_columns)) {
        $columns[] = 'created_at';
        $values[] = date('Y-m-d H:i:s');
        $types .= 's';
    }
    
    $placeholders = implode(', ', array_fill(0, count($columns), '?'));
    $sql = "INSERT INTO candidate_details (" . implode(', ', $columns) . ") VALUES ($placeholders)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$values);
    
    if ($stmt->execute()) {
        $candidate_ids[] = $conn->insert_id;
        echo "<p class='success'>✓ Added candidate: {$candidate['name']} - {$candidate['job_title']}</p>";
        $inserted_count++;
    } else {
        echo "<p class='error'>✗ Error adding {$candidate['name']}: " . $conn->error . "</p>";
    }
}

echo "<p class='success'><strong>Total candidates added: $inserted_count</strong></p>";

// Add interview schedules for candidates with interview_status = 1
echo "<h3>Adding Interview Schedules</h3>";

// Check if calendar table exists
$check_calendar_table = "SHOW TABLES LIKE 'calendar'";
$calendar_exists = $conn->query($check_calendar_table);

if ($calendar_exists->num_rows == 0) {
    echo "<p class='info'>ℹ Calendar table does not exist. Skipping interview schedules...</p>";
    echo "<p class='info'>Note: Interview schedules can be added manually through the application.</p>";
    $interview_count = 0;
} else {
    $interview_dates = [
        date('Y-m-d', strtotime('+1 day')),
        date('Y-m-d', strtotime('+2 days')),
        date('Y-m-d', strtotime('+3 days')),
        date('Y-m-d', strtotime('+5 days')),
        date('Y-m-d', strtotime('+7 days'))
    ];

    $interview_times = ['09:00:00', '10:30:00', '14:00:00', '15:30:00', '16:00:00'];
    $interview_count = 0;

    // Detect calendar table columns
    $calendar_columns_query = "SHOW COLUMNS FROM calendar";
    $calendar_columns_result = $conn->query($calendar_columns_query);
    $recruiter_col = 'recruiter'; // default
    $calendar_cols = [];
    
    while ($col = $calendar_columns_result->fetch_assoc()) {
        $calendar_cols[] = $col['Field'];
        if (stripos($col['Field'], 'rec') !== false && stripos($col['Field'], 'username') !== false) {
            $recruiter_col = $col['Field'];
        }
    }
    
    echo "<p class='info'>Calendar table found. Using column: <strong>$recruiter_col</strong> for recruiter</p>";

    // Get candidates with interviews scheduled
    $interview_candidates_sql = "SELECT cd_id, cd_name, cd_job_title FROM candidate_details WHERE cd_interview_status = 1 AND cd_rec_username = ?";
    $stmt = $conn->prepare($interview_candidates_sql);
    $stmt->bind_param("s", $recruiter_username);
    $stmt->execute();
    $interview_candidates = $stmt->get_result();

    $index = 0;
    while ($candidate = $interview_candidates->fetch_assoc()) {
        $date = $interview_dates[$index % count($interview_dates)];
        $time = $interview_times[$index % count($interview_times)];
        
        // Check if schedule already exists
        $check_sql = "SELECT * FROM calendar WHERE can_id = ? AND $recruiter_col = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("is", $candidate['cd_id'], $recruiter_username);
        $check_stmt->execute();
        
        if ($check_stmt->get_result()->num_rows > 0) {
            echo "<p class='info'>⚠ Interview for {$candidate['cd_name']} already scheduled, skipping...</p>";
            $index++;
            continue;
        }
        
        // Build insert based on available columns
        $insert_cols = ['can_id', 'can_name', 'date', 'time', $recruiter_col];
        $insert_vals = [$candidate['cd_id'], $candidate['cd_name'], $date, $time, $recruiter_username];
        $insert_types = 'issss';
        
        if (in_array('created_at', $calendar_cols)) {
            $insert_cols[] = 'created_at';
            $insert_vals[] = date('Y-m-d H:i:s');
            $insert_types .= 's';
        }
        
        $placeholders = implode(', ', array_fill(0, count($insert_cols), '?'));
        $insert_sql = "INSERT INTO calendar (" . implode(', ', $insert_cols) . ") VALUES ($placeholders)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param($insert_types, ...$insert_vals);
        
        if ($insert_stmt->execute()) {
            echo "<p class='success'>✓ Scheduled interview for {$candidate['cd_name']} on $date at $time</p>";
            $interview_count++;
        } else {
            echo "<p class='error'>✗ Error scheduling interview: " . $conn->error . "</p>";
        }
        
        $index++;
    }

    echo "<p class='success'><strong>Total interviews scheduled: $interview_count</strong></p>";
}

// Summary
echo "<h3>Summary</h3>";
echo "<div style='background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);'>";
echo "<p><strong>✓ Candidates Added:</strong> $inserted_count</p>";
echo "<p><strong>✓ Interviews Scheduled:</strong> $interview_count</p>";
echo "<p><strong>✓ Recruiter:</strong> $recruiter_username</p>";
echo "</div>";

$conn->close();

echo "<h3 style='color: green;'>Sample Data Added Successfully!</h3>";
echo "<p><a href='index.php' style='display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 6px;'>← Back to Application</a></p>";
?>
