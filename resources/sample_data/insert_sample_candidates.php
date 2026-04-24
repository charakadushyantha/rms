<?php
/**
 * Insert Sample Candidate Data
 * Run: http://localhost/rms/insert_sample_candidates.php
 */

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'rmsdb';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>Inserting Sample Candidate Data</h2>";
echo "<style>
    body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
    .success { color: green; padding: 10px; background: #d4edda; margin: 10px 0; border-radius: 5px; }
</style>";

// Get admin username
$admin_query = $conn->query("SELECT u_username FROM users LIMIT 1");
$admin = $admin_query && $admin_query->num_rows > 0 ? $admin_query->fetch_assoc()['u_username'] : 'admin';

$sample_candidates = [
    [
        'first_name' => 'Alex',
        'last_name' => 'Johnson',
        'email' => 'alex.johnson@email.com',
        'phone' => '555-0201',
        'location' => 'San Francisco, CA',
        'current_title' => 'Senior Full Stack Developer',
        'current_company' => 'Tech Corp',
        'total_experience' => 8,
        'expected_salary' => 150000,
        'notice_period' => '30 days',
        'source' => 'LinkedIn',
        'status' => 'Active',
        'skills' => ['JavaScript', 'React', 'Node.js', 'Python', 'AWS']
    ],
    [
        'first_name' => 'Maria',
        'last_name' => 'Garcia',
        'email' => 'maria.garcia@email.com',
        'phone' => '555-0202',
        'location' => 'Austin, TX',
        'current_title' => 'Data Scientist',
        'current_company' => 'Analytics Inc',
        'total_experience' => 5,
        'expected_salary' => 120000,
        'notice_period' => '2 weeks',
        'source' => 'GitHub',
        'status' => 'In Pipeline',
        'skills' => ['Python', 'Machine Learning', 'TensorFlow', 'SQL', 'R']
    ],
    [
        'first_name' => 'James',
        'last_name' => 'Brown',
        'email' => 'james.brown@email.com',
        'phone' => '555-0203',
        'location' => 'New York, NY',
        'current_title' => 'DevOps Engineer',
        'current_company' => 'Cloud Systems',
        'total_experience' => 6,
        'expected_salary' => 140000,
        'notice_period' => '1 month',
        'source' => 'Indeed',
        'status' => 'Contacted',
        'skills' => ['Docker', 'Kubernetes', 'AWS', 'Jenkins', 'Terraform']
    ],
    [
        'first_name' => 'Sarah',
        'last_name' => 'Lee',
        'email' => 'sarah.lee@email.com',
        'phone' => '555-0204',
        'location' => 'Seattle, WA',
        'current_title' => 'UX/UI Designer',
        'current_company' => 'Design Studio',
        'total_experience' => 4,
        'expected_salary' => 95000,
        'notice_period' => '2 weeks',
        'source' => 'Referral',
        'status' => 'New',
        'skills' => ['Figma', 'Adobe XD', 'Sketch', 'User Research', 'Prototyping']
    ],
    [
        'first_name' => 'Michael',
        'last_name' => 'Chen',
        'email' => 'michael.chen@email.com',
        'phone' => '555-0205',
        'location' => 'Boston, MA',
        'current_title' => 'Product Manager',
        'current_company' => 'Product Co',
        'total_experience' => 7,
        'expected_salary' => 130000,
        'notice_period' => '1 month',
        'source' => 'LinkedIn',
        'status' => 'Active',
        'skills' => ['Product Strategy', 'Agile', 'Jira', 'Analytics', 'Roadmapping']
    ]
];

$inserted = 0;

foreach ($sample_candidates as $candidate) {
    $sql = "INSERT INTO sourced_candidates (
        first_name, last_name, email, phone, location,
        current_title, current_company, total_experience,
        expected_salary, notice_period, source, status, added_by
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        'sssssssidssss',
        $candidate['first_name'],
        $candidate['last_name'],
        $candidate['email'],
        $candidate['phone'],
        $candidate['location'],
        $candidate['current_title'],
        $candidate['current_company'],
        $candidate['total_experience'],
        $candidate['expected_salary'],
        $candidate['notice_period'],
        $candidate['source'],
        $candidate['status'],
        $admin
    );
    
    if ($stmt->execute()) {
        $candidate_id = $stmt->insert_id;
        echo "<div class='success'>✓ Added: {$candidate['first_name']} {$candidate['last_name']} - {$candidate['current_title']}</div>";
        $inserted++;
        
        // Add skills
        foreach ($candidate['skills'] as $skill) {
            $skill_sql = "INSERT INTO candidate_skills (candidate_id, skill_name, proficiency_level) VALUES (?, ?, 'Intermediate')";
            $skill_stmt = $conn->prepare($skill_sql);
            $skill_stmt->bind_param('is', $candidate_id, $skill);
            $skill_stmt->execute();
        }
    }
}

echo "<hr>";
echo "<h3>Summary:</h3>";
echo "<div class='success'>";
echo "<p><strong>Candidates Added:</strong> $inserted</p>";
echo "<p><strong>Status:</strong> Sample data inserted successfully!</p>";
echo "</div>";

echo "<h3>Next Steps:</h3>";
echo "<p><a href='http://localhost/rms/Candidate_sourcing' style='display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 5px;'>View Candidates</a></p>";

$conn->close();
?>
