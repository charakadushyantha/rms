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

echo "<h2>Inserting Sample Marketing Campaign Data</h2>";
echo "<style>
    body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
    .success { color: green; padding: 10px; background: #d4edda; margin: 10px 0; border-radius: 5px; }
    .info { color: blue; padding: 10px; background: #d1ecf1; margin: 10px 0; border-radius: 5px; }
</style>";

// Sample Campaigns
$campaigns = [
    [
        'campaign_name' => 'Summer 2024 Tech Talent Drive',
        'campaign_type' => 'Multi-Channel',
        'description' => 'Comprehensive campaign to attract top tech talent for summer hiring season',
        'start_date' => '2024-06-01',
        'end_date' => '2024-08-31',
        'budget' => 15000.00,
        'target_audience' => 'Software Engineers, Data Scientists, and DevOps professionals with 3-5 years experience',
        'goals' => 'Generate 200 qualified applications, Increase brand awareness by 40%',
        'status' => 'Active',
        'created_by' => 'admin'
    ],
    [
        'campaign_name' => 'Healthcare Professionals Recruitment',
        'campaign_type' => 'Email',
        'description' => 'Targeted email campaign for healthcare positions',
        'start_date' => '2024-07-01',
        'end_date' => '2024-09-30',
        'budget' => 8000.00,
        'target_audience' => 'Registered Nurses, Medical Technicians, Healthcare Administrators',
        'goals' => 'Fill 50 healthcare positions, Build talent pipeline',
        'status' => 'Active',
        'created_by' => 'admin'
    ],
    [
        'campaign_name' => 'LinkedIn Sponsored Jobs Campaign',
        'campaign_type' => 'Paid Ads',
        'description' => 'Sponsored job postings on LinkedIn for senior positions',
        'start_date' => '2024-08-01',
        'end_date' => '2024-10-31',
        'budget' => 12000.00,
        'target_audience' => 'Senior Software Engineers, Engineering Managers, Product Managers',
        'goals' => 'Reach 50,000 professionals, Generate 150 applications',
        'status' => 'Active',
        'created_by' => 'admin'
    ],
    [
        'campaign_name' => 'Graduate Recruitment Program 2024',
        'campaign_type' => 'Social Media',
        'description' => 'Campus recruitment campaign targeting recent graduates',
        'start_date' => '2024-09-01',
        'end_date' => '2024-11-30',
        'budget' => 5000.00,
        'target_audience' => 'Recent graduates in Computer Science, Engineering, Business',
        'goals' => 'Hire 30 entry-level positions, Build employer brand on campus',
        'status' => 'Draft',
        'created_by' => 'admin'
    ],
    [
        'campaign_name' => 'Remote Work Opportunities Campaign',
        'campaign_type' => 'Multi-Channel',
        'description' => 'Promoting remote work opportunities across all channels',
        'start_date' => '2024-10-01',
        'end_date' => '2024-12-31',
        'budget' => 10000.00,
        'target_audience' => 'Remote workers, Digital nomads, Work-from-home professionals',
        'goals' => 'Fill 40 remote positions, Expand geographic reach',
        'status' => 'Paused',
        'created_by' => 'admin'
    ]
];

foreach ($campaigns as $campaign) {
    $stmt = $conn->prepare("INSERT INTO marketing_campaigns (campaign_name, campaign_type, description, start_date, end_date, budget, target_audience, goals, status, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('sssssdssss', 
        $campaign['campaign_name'],
        $campaign['campaign_type'],
        $campaign['description'],
        $campaign['start_date'],
        $campaign['end_date'],
        $campaign['budget'],
        $campaign['target_audience'],
        $campaign['goals'],
        $campaign['status'],
        $campaign['created_by']
    );
    
    if ($stmt->execute()) {
        $campaign_id = $conn->insert_id;
        echo "<div class='success'>✓ Campaign created: {$campaign['campaign_name']} (ID: $campaign_id)</div>";
        
        // Add sample analytics for active campaigns
        if ($campaign['status'] == 'Active') {
            $reach = rand(5000, 25000);
            $impressions = $reach * rand(2, 4);
            $clicks = rand(500, 2000);
            $applications = rand(50, 200);
            $spent = $campaign['budget'] * (rand(30, 70) / 100);
            
            $analytics_stmt = $conn->prepare("INSERT INTO campaign_analytics (campaign_id, date, reach, impressions, clicks, applications, spent) VALUES (?, CURDATE(), ?, ?, ?, ?, ?)");
            if ($analytics_stmt) {
                $analytics_stmt->bind_param('iiiiii', $campaign_id, $reach, $impressions, $clicks, $applications, $spent);
                $analytics_stmt->execute();
                echo "<div class='info'>  → Analytics added: Reach: $reach, Clicks: $clicks, Applications: $applications</div>";
            }
        }
    }
}

// Sample Email Templates
$templates = [
    [
        'template_name' => 'Job Alert - Tech Positions',
        'subject' => 'Exciting Tech Opportunities at {{company_name}}',
        'body_html' => '<h2>New Opportunities Available</h2><p>Dear {{candidate_name}},</p><p>We have exciting new positions that match your profile:</p><ul><li>{{job_title}}</li></ul><p>Apply now!</p>',
        'template_type' => 'Job Alert'
    ],
    [
        'template_name' => 'Welcome to Talent Network',
        'subject' => 'Welcome to Our Talent Network!',
        'body_html' => '<h2>Welcome!</h2><p>Thank you for joining our talent network. We will keep you updated on opportunities that match your skills.</p>',
        'template_type' => 'Welcome'
    ],
    [
        'template_name' => 'Interview Invitation',
        'subject' => 'Interview Invitation for {{job_title}}',
        'body_html' => '<h2>Interview Invitation</h2><p>Dear {{candidate_name}},</p><p>We would like to invite you for an interview for the position of {{job_title}}.</p><p>Please confirm your availability.</p>',
        'template_type' => 'Interview'
    ],
    [
        'template_name' => 'Application Received',
        'subject' => 'Application Received - {{job_title}}',
        'body_html' => '<h2>Application Received</h2><p>Thank you for your application! We will review it and get back to you soon.</p>',
        'template_type' => 'Confirmation'
    ]
];

foreach ($templates as $template) {
    $stmt = $conn->prepare("INSERT INTO email_templates (template_name, subject, body_html, template_type) VALUES (?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param('ssss', $template['template_name'], $template['subject'], $template['body_html'], $template['template_type']);
        
        if ($stmt->execute()) {
            echo "<div class='success'>✓ Email template created: {$template['template_name']}</div>";
        }
    }
}

// Sample Social Posts
$social_posts = [
    [
        'campaign_id' => 1,
        'platform' => 'linkedin',
        'content' => 'We are hiring! Join our amazing tech team. Check out our latest openings for Software Engineers. #hiring #techjobs #careers',
        'scheduled_time' => '2024-06-15 10:00:00',
        'status' => 'Published',
        'reach' => 8500,
        'engagement' => 450
    ],
    [
        'campaign_id' => 1,
        'platform' => 'facebook',
        'content' => 'Looking for talented developers! We offer competitive salaries, remote work options, and amazing benefits. Apply now!',
        'scheduled_time' => '2024-06-20 14:00:00',
        'status' => 'Published',
        'reach' => 6200,
        'engagement' => 320
    ],
    [
        'campaign_id' => 3,
        'platform' => 'linkedin',
        'content' => 'Senior Engineering positions available! Lead innovative projects and work with cutting-edge technology. #engineering #leadership',
        'scheduled_time' => '2024-08-10 09:00:00',
        'status' => 'Published',
        'reach' => 12000,
        'engagement' => 680
    ]
];

foreach ($social_posts as $post) {
    $stmt = $conn->prepare("INSERT INTO social_posts (campaign_id, platform, content, scheduled_time, status, reach, engagement) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param('issssii', 
            $post['campaign_id'],
            $post['platform'],
            $post['content'],
            $post['scheduled_time'],
            $post['status'],
            $post['reach'],
            $post['engagement']
        );
        
        if ($stmt->execute()) {
            echo "<div class='success'>✓ Social post created on {$post['platform']}</div>";
        }
    }
}

echo "<hr>";
echo "<h3>Summary:</h3>";
echo "<div class='success'>";
echo "<p><strong>Campaigns created:</strong> " . count($campaigns) . "</p>";
echo "<p><strong>Email templates created:</strong> " . count($templates) . "</p>";
echo "<p><strong>Social posts created:</strong> " . count($social_posts) . "</p>";
echo "<p><strong>Status:</strong> Sample data inserted successfully!</p>";
echo "</div>";

echo "<h3>Access the System:</h3>";
echo "<p><a href='http://localhost/rms/Marketing_campaigns' style='display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 5px; margin: 5px;'>View Campaigns</a></p>";
echo "<p><a href='http://localhost/rms/Marketing_campaigns/analytics' style='display: inline-block; padding: 10px 20px; background: #27ae60; color: white; text-decoration: none; border-radius: 5px; margin: 5px;'>View Analytics</a></p>";

$conn->close();
?>
