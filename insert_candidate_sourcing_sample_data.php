<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rmsdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>Inserting Sample Candidate Sourcing Data</h2>";
echo "<style>
    body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
    .success { color: green; padding: 10px; background: #d4edda; margin: 10px 0; border-radius: 5px; }
    .info { color: blue; padding: 10px; background: #d1ecf1; margin: 10px 0; border-radius: 5px; }
</style>";

// Sample Candidates
$candidates = [
    [
        'first_name' => 'John',
        'last_name' => 'Smith',
        'email' => 'john.smith@email.com',
        'phone' => '+1-555-0101',
        'location' => 'San Francisco, CA',
        'current_title' => 'Senior Software Engineer',
        'current_company' => 'Tech Corp',
        'total_experience' => 8,
        'expected_salary' => 150000.00,
        'notice_period' => '2 weeks',
        'linkedin_url' => 'https://linkedin.com/in/johnsmith',
        'github_url' => 'https://github.com/johnsmith',
        'summary' => 'Experienced full-stack developer with expertise in React, Node.js, and cloud technologies.',
        'source' => 'LinkedIn',
        'status' => 'Active',
        'rating' => 5,
        'added_by' => 'admin',
        'skills' => ['JavaScript', 'React', 'Node.js', 'AWS', 'Docker']
    ],
    [
        'first_name' => 'Sarah',
        'last_name' => 'Johnson',
        'email' => 'sarah.johnson@email.com',
        'phone' => '+1-555-0102',
        'location' => 'New York, NY',
        'current_title' => 'Data Scientist',
        'current_company' => 'Analytics Inc',
        'total_experience' => 5,
        'expected_salary' => 130000.00,
        'notice_period' => '1 month',
        'linkedin_url' => 'https://linkedin.com/in/sarahjohnson',
        'summary' => 'Data scientist specializing in machine learning and predictive analytics.',
        'source' => 'Indeed',
        'status' => 'Active',
        'rating' => 4,
        'added_by' => 'admin',
        'skills' => ['Python', 'Machine Learning', 'TensorFlow', 'SQL', 'R']
    ],
    [
        'first_name' => 'Michael',
        'last_name' => 'Chen',
        'email' => 'michael.chen@email.com',
        'phone' => '+1-555-0103',
        'location' => 'Seattle, WA',
        'current_title' => 'DevOps Engineer',
        'current_company' => 'Cloud Systems',
        'total_experience' => 6,
        'expected_salary' => 140000.00,
        'notice_period' => '3 weeks',
        'linkedin_url' => 'https://linkedin.com/in/michaelchen',
        'github_url' => 'https://github.com/mchen',
        'summary' => 'DevOps engineer with strong background in CI/CD, Kubernetes, and infrastructure automation.',
        'source' => 'GitHub',
        'status' => 'Active',
        'rating' => 5,
        'added_by' => 'admin',
        'skills' => ['Kubernetes', 'Docker', 'Jenkins', 'Terraform', 'AWS']
    ],
    [
        'first_name' => 'Emily',
        'last_name' => 'Davis',
        'email' => 'emily.davis@email.com',
        'phone' => '+1-555-0104',
        'location' => 'Austin, TX',
        'current_title' => 'Product Manager',
        'current_company' => 'Startup XYZ',
        'total_experience' => 7,
        'expected_salary' => 145000.00,
        'notice_period' => '2 weeks',
        'linkedin_url' => 'https://linkedin.com/in/emilydavis',
        'summary' => 'Product manager with experience in B2B SaaS and agile methodologies.',
        'source' => 'Referral',
        'status' => 'Contacted',
        'rating' => 4,
        'added_by' => 'admin',
        'skills' => ['Product Management', 'Agile', 'Scrum', 'User Research', 'Analytics']
    ],
    [
        'first_name' => 'David',
        'last_name' => 'Martinez',
        'email' => 'david.martinez@email.com',
        'phone' => '+1-555-0105',
        'location' => 'Boston, MA',
        'current_title' => 'UX Designer',
        'current_company' => 'Design Studio',
        'total_experience' => 4,
        'expected_salary' => 110000.00,
        'notice_period' => '2 weeks',
        'linkedin_url' => 'https://linkedin.com/in/davidmartinez',
        'portfolio_url' => 'https://davidmartinez.design',
        'summary' => 'UX designer passionate about creating intuitive and accessible user experiences.',
        'source' => 'Company Website',
        'status' => 'New',
        'rating' => 4,
        'added_by' => 'admin',
        'skills' => ['UI/UX Design', 'Figma', 'Adobe XD', 'User Research', 'Prototyping']
    ],
    [
        'first_name' => 'Lisa',
        'last_name' => 'Anderson',
        'email' => 'lisa.anderson@email.com',
        'phone' => '+1-555-0106',
        'location' => 'Chicago, IL',
        'current_title' => 'Frontend Developer',
        'current_company' => 'Web Solutions',
        'total_experience' => 3,
        'expected_salary' => 95000.00,
        'notice_period' => '2 weeks',
        'linkedin_url' => 'https://linkedin.com/in/lisaanderson',
        'github_url' => 'https://github.com/landerson',
        'summary' => 'Frontend developer specializing in modern JavaScript frameworks and responsive design.',
        'source' => 'Stack Overflow',
        'status' => 'Active',
        'rating' => 3,
        'added_by' => 'admin',
        'skills' => ['JavaScript', 'Vue.js', 'CSS', 'HTML5', 'Responsive Design']
    ],
    [
        'first_name' => 'Robert',
        'last_name' => 'Taylor',
        'email' => 'robert.taylor@email.com',
        'phone' => '+1-555-0107',
        'location' => 'Denver, CO',
        'current_title' => 'Backend Developer',
        'current_company' => 'Enterprise Systems',
        'total_experience' => 9,
        'expected_salary' => 155000.00,
        'notice_period' => '1 month',
        'linkedin_url' => 'https://linkedin.com/in/roberttaylor',
        'github_url' => 'https://github.com/rtaylor',
        'summary' => 'Senior backend developer with expertise in microservices architecture and distributed systems.',
        'source' => 'LinkedIn',
        'status' => 'Interviewed',
        'rating' => 5,
        'added_by' => 'admin',
        'skills' => ['Java', 'Spring Boot', 'Microservices', 'PostgreSQL', 'Redis']
    ],
    [
        'first_name' => 'Jennifer',
        'last_name' => 'Wilson',
        'email' => 'jennifer.wilson@email.com',
        'phone' => '+1-555-0108',
        'location' => 'Portland, OR',
        'current_title' => 'QA Engineer',
        'current_company' => 'Quality First',
        'total_experience' => 5,
        'expected_salary' => 105000.00,
        'notice_period' => '2 weeks',
        'linkedin_url' => 'https://linkedin.com/in/jenniferwilson',
        'summary' => 'QA engineer with strong automation testing skills and attention to detail.',
        'source' => 'Indeed',
        'status' => 'Active',
        'rating' => 4,
        'added_by' => 'admin',
        'skills' => ['Test Automation', 'Selenium', 'Jest', 'Cypress', 'API Testing']
    ]
];

foreach ($candidates as $candidate) {
    $skills = $candidate['skills'];
    unset($candidate['skills']);
    
    $stmt = $conn->prepare("INSERT INTO sourced_candidates (first_name, last_name, email, phone, location, current_title, current_company, total_experience, expected_salary, notice_period, linkedin_url, github_url, portfolio_url, summary, source, status, rating, added_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->bind_param('sssssssidsssssssss', 
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
        $candidate['linkedin_url'],
        $candidate['github_url'],
        $candidate['portfolio_url'],
        $candidate['summary'],
        $candidate['source'],
        $candidate['status'],
        $candidate['rating'],
        $candidate['added_by']
    );
    
    if ($stmt->execute()) {
        $candidate_id = $conn->insert_id;
        echo "<div class='success'>✓ Candidate added: {$candidate['first_name']} {$candidate['last_name']} (ID: $candidate_id)</div>";
        
        // Add skills
        foreach ($skills as $skill) {
            $skill_stmt = $conn->prepare("INSERT INTO candidate_skills (candidate_id, skill_name, proficiency_level) VALUES (?, ?, ?)");
            $proficiency = 'Intermediate';
            $skill_stmt->bind_param('iss', $candidate_id, $skill, $proficiency);
            $skill_stmt->execute();
        }
        echo "<div class='info'>  → Added " . count($skills) . " skills</div>";
    }
}

// Sample Talent Pools
$pools = [
    [
        'pool_name' => 'Senior Developers',
        'description' => 'Experienced developers with 5+ years of experience',
        'pool_type' => 'Static',
        'created_by' => 'admin'
    ],
    [
        'pool_name' => 'Data Science Talent',
        'description' => 'Data scientists and ML engineers',
        'pool_type' => 'Static',
        'created_by' => 'admin'
    ],
    [
        'pool_name' => 'Frontend Specialists',
        'description' => 'Frontend developers and UX designers',
        'pool_type' => 'Static',
        'created_by' => 'admin'
    ],
    [
        'pool_name' => 'DevOps & Cloud',
        'description' => 'DevOps engineers and cloud architects',
        'pool_type' => 'Static',
        'created_by' => 'admin'
    ]
];

foreach ($pools as $pool) {
    $stmt = $conn->prepare("INSERT INTO talent_pools (pool_name, description, pool_type, created_by) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssss', $pool['pool_name'], $pool['description'], $pool['pool_type'], $pool['created_by']);
    
    if ($stmt->execute()) {
        $pool_id = $conn->insert_id;
        echo "<div class='success'>✓ Talent pool created: {$pool['pool_name']} (ID: $pool_id)</div>";
    }
}

// Add candidates to pools
$pool_assignments = [
    [1, 1], // John Smith -> Senior Developers
    [1, 7], // Robert Taylor -> Senior Developers
    [2, 2], // Sarah Johnson -> Data Science Talent
    [3, 5], // David Martinez -> Frontend Specialists
    [3, 6], // Lisa Anderson -> Frontend Specialists
    [4, 3]  // Michael Chen -> DevOps & Cloud
];

foreach ($pool_assignments as $assignment) {
    $stmt = $conn->prepare("INSERT INTO talent_pool_members (pool_id, candidate_id, added_by) VALUES (?, ?, ?)");
    $added_by = 'admin';
    $stmt->bind_param('iis', $assignment[0], $assignment[1], $added_by);
    $stmt->execute();
}

echo "<div class='info'>✓ Added candidates to talent pools</div>";

echo "<hr>";
echo "<h3>Summary:</h3>";
echo "<div class='success'>";
echo "<p><strong>Candidates added:</strong> " . count($candidates) . "</p>";
echo "<p><strong>Talent pools created:</strong> " . count($pools) . "</p>";
echo "<p><strong>Status:</strong> Sample data inserted successfully!</p>";
echo "</div>";

echo "<h3>Access the System:</h3>";
echo "<p><a href='http://localhost/rms/Candidate_sourcing' style='display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 5px; margin: 5px;'>View Candidates</a></p>";
echo "<p><a href='http://localhost/rms/Candidate_sourcing/pools' style='display: inline-block; padding: 10px 20px; background: #27ae60; color: white; text-decoration: none; border-radius: 5px; margin: 5px;'>View Talent Pools</a></p>";

$conn->close();
?>
