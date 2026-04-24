<?php
/**
 * Insert Sample Job Posting Data
 * Run this file: http://localhost/rms/insert_sample_job_data.php
 */

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'rmsdb';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>Inserting Sample Job Posting Data</h2>";
echo "<style>
    body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
    .success { color: green; padding: 10px; background: #d4edda; margin: 10px 0; border-radius: 5px; }
    .info { color: #0c5460; padding: 10px; background: #d1ecf1; margin: 10px 0; border-radius: 5px; }
    h3 { color: #333; margin-top: 20px; }
    .btn { display: inline-block; padding: 10px 20px; margin: 10px 5px; background: #667eea; color: white; text-decoration: none; border-radius: 5px; }
</style>";

// Sample job postings
$sample_jobs = [
    [
        'title' => 'Senior Software Engineer',
        'description' => 'We are looking for an experienced Senior Software Engineer to join our dynamic team. You will be responsible for designing, developing, and maintaining high-quality software solutions.',
        'requirements' => 'Bachelor\'s degree in Computer Science or related field, 5+ years of experience in software development, Strong knowledge of Java, Python, or C++, Experience with cloud platforms (AWS, Azure, or GCP)',
        'responsibilities' => 'Design and develop scalable software solutions, Lead technical discussions and code reviews, Mentor junior developers, Collaborate with cross-functional teams',
        'location' => 'San Francisco, CA',
        'employment_type' => 'Full-time',
        'salary_min' => 120000,
        'salary_max' => 180000,
        'status' => 'Active',
        'experience_min' => 5,
        'experience_max' => 10
    ],
    [
        'title' => 'Marketing Manager',
        'description' => 'Join our marketing team as a Marketing Manager. You will develop and execute marketing strategies to drive brand awareness and customer engagement.',
        'requirements' => 'Bachelor\'s degree in Marketing or Business, 3+ years of marketing experience, Strong analytical and communication skills, Experience with digital marketing tools',
        'responsibilities' => 'Develop marketing strategies and campaigns, Manage social media presence, Analyze market trends, Coordinate with sales team',
        'location' => 'New York, NY',
        'employment_type' => 'Full-time',
        'salary_min' => 80000,
        'salary_max' => 110000,
        'status' => 'Active',
        'experience_min' => 3,
        'experience_max' => 7
    ],
    [
        'title' => 'Data Analyst',
        'description' => 'We need a Data Analyst to help us make data-driven decisions. You will analyze complex datasets and provide actionable insights.',
        'requirements' => 'Bachelor\'s degree in Statistics, Mathematics, or related field, 2+ years of data analysis experience, Proficiency in SQL and Python, Experience with data visualization tools',
        'responsibilities' => 'Analyze large datasets, Create reports and dashboards, Identify trends and patterns, Present findings to stakeholders',
        'location' => 'Austin, TX',
        'employment_type' => 'Full-time',
        'salary_min' => 70000,
        'salary_max' => 95000,
        'status' => 'Active',
        'experience_min' => 2,
        'experience_max' => 5
    ],
    [
        'title' => 'UX/UI Designer',
        'description' => 'Creative UX/UI Designer needed to design intuitive and engaging user interfaces for our web and mobile applications.',
        'requirements' => 'Bachelor\'s degree in Design or related field, 3+ years of UX/UI design experience, Proficiency in Figma, Sketch, or Adobe XD, Strong portfolio demonstrating design skills',
        'responsibilities' => 'Design user interfaces and experiences, Create wireframes and prototypes, Conduct user research, Collaborate with developers',
        'location' => 'Seattle, WA',
        'employment_type' => 'Full-time',
        'salary_min' => 85000,
        'salary_max' => 115000,
        'status' => 'Draft',
        'experience_min' => 3,
        'experience_max' => 6
    ],
    [
        'title' => 'DevOps Engineer',
        'description' => 'Looking for a DevOps Engineer to manage our infrastructure and deployment pipelines. You will ensure smooth operations and continuous delivery.',
        'requirements' => 'Bachelor\'s degree in Computer Science, 4+ years of DevOps experience, Strong knowledge of Docker and Kubernetes, Experience with CI/CD tools',
        'responsibilities' => 'Manage cloud infrastructure, Implement CI/CD pipelines, Monitor system performance, Automate deployment processes',
        'location' => 'Boston, MA',
        'employment_type' => 'Full-time',
        'salary_min' => 110000,
        'salary_max' => 150000,
        'status' => 'Active',
        'experience_min' => 4,
        'experience_max' => 8
    ]
];

$inserted = 0;
$current_user = 'admin'; // Change this to your actual username

foreach ($sample_jobs as $job) {
    $sql = "INSERT INTO job_postings (
        jp_title, jp_description, jp_requirements, jp_responsibilities,
        jp_location, jp_employment_type, jp_salary_min, jp_salary_max,
        jp_salary_currency, jp_status, jp_posted_by, jp_experience_min,
        jp_experience_max, jp_created_at, jp_expires_at
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, 'USD', ?, ?, ?, ?, NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY)
    )";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        'ssssssddsiii',
        $job['title'],
        $job['description'],
        $job['requirements'],
        $job['responsibilities'],
        $job['location'],
        $job['employment_type'],
        $job['salary_min'],
        $job['salary_max'],
        $job['status'],
        $current_user,
        $job['experience_min'],
        $job['experience_max']
    );
    
    if ($stmt->execute()) {
        $job_id = $conn->insert_id;
        echo "<div class='success'>✓ Created job: {$job['title']} (ID: $job_id)</div>";
        $inserted++;
        
        // Insert sample posting history for active jobs
        if ($job['status'] == 'Active') {
            // Get random platforms
            $platforms = $conn->query("SELECT platform_id FROM job_platforms ORDER BY RAND() LIMIT 2")->fetch_all(MYSQLI_ASSOC);
            
            foreach ($platforms as $platform) {
                $history_sql = "INSERT INTO job_posting_history (
                    jp_id, platform_id, external_job_id, status, posted_at,
                    views_count, clicks_count, applications_count, created_at
                ) VALUES (?, ?, ?, 'Posted', NOW(), ?, ?, ?, NOW())";
                
                $hist_stmt = $conn->prepare($history_sql);
                $external_id = 'ext_' . $job_id . '_' . $platform['platform_id'];
                $views = rand(50, 500);
                $clicks = rand(10, 100);
                $applications = rand(1, 20);
                
                $hist_stmt->bind_param(
                    'iisiii',
                    $job_id,
                    $platform['platform_id'],
                    $external_id,
                    $views,
                    $clicks,
                    $applications
                );
                
                $hist_stmt->execute();
            }
        }
    } else {
        echo "<div class='error'>✗ Failed to create: {$job['title']}</div>";
    }
}

echo "<hr>";
echo "<h3>Summary:</h3>";
echo "<div class='info'>";
echo "<p><strong>Jobs Created:</strong> $inserted</p>";
echo "<p><strong>Status:</strong> Sample data inserted successfully!</p>";
echo "</div>";

echo "<h3>Next Steps:</h3>";
echo "<p><a href='http://localhost/rms/Job_posting' class='btn'>View Job Postings</a></p>";
echo "<p><a href='http://localhost/rms/Job_posting/analytics' class='btn'>View Analytics</a></p>";

echo "<hr>";
echo "<p style='color: #666; font-size: 12px;'>You can delete this file after inserting sample data.</p>";

$conn->close();
?>
