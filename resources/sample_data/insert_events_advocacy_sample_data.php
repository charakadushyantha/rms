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

echo "<h2>Inserting Sample Events & Advocacy Data</h2>";
echo "<style>
    body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
    .success { color: green; padding: 10px; background: #d4edda; margin: 10px 0; border-radius: 5px; }
    .info { color: blue; padding: 10px; background: #d1ecf1; margin: 10px 0; border-radius: 5px; }
</style>";

// Sample Recruitment Events
$events = [
    [
        'event_name' => 'Tech Talent Job Fair 2024',
        'event_type' => 'Job Fair',
        'description' => 'Annual technology job fair featuring top tech companies and startups',
        'event_date' => '2024-12-15',
        'start_time' => '09:00:00',
        'end_time' => '17:00:00',
        'location' => 'San Francisco Convention Center',
        'venue_type' => 'Physical',
        'max_attendees' => 500,
        'registered_count' => 234,
        'status' => 'Upcoming',
        'budget' => 25000.00,
        'organizer' => 'HR Team',
        'contact_email' => 'events@company.com',
        'created_by' => 'admin'
    ],
    [
        'event_name' => 'Virtual Career Day - Engineering',
        'event_type' => 'Virtual Job Fair',
        'description' => 'Online career day for engineering positions across all levels',
        'event_date' => '2024-11-25',
        'start_time' => '10:00:00',
        'end_time' => '16:00:00',
        'venue_type' => 'Virtual',
        'virtual_link' => 'https://zoom.us/j/example123',
        'max_attendees' => 1000,
        'registered_count' => 567,
        'status' => 'Upcoming',
        'budget' => 5000.00,
        'organizer' => 'Recruitment Team',
        'contact_email' => 'careers@company.com',
        'created_by' => 'admin'
    ],
    [
        'event_name' => 'Campus Recruitment - MIT',
        'event_type' => 'Campus Recruitment',
        'description' => 'On-campus recruitment drive at MIT for fresh graduates',
        'event_date' => '2024-12-01',
        'start_time' => '11:00:00',
        'end_time' => '15:00:00',
        'location' => 'MIT Career Center',
        'venue_type' => 'Physical',
        'max_attendees' => 200,
        'registered_count' => 156,
        'status' => 'Upcoming',
        'budget' => 8000.00,
        'organizer' => 'Campus Relations',
        'contact_email' => 'campus@company.com',
        'created_by' => 'admin'
    ],
    [
        'event_name' => 'Data Science Networking Mixer',
        'event_type' => 'Networking Event',
        'description' => 'Informal networking event for data science professionals',
        'event_date' => '2024-11-20',
        'start_time' => '18:00:00',
        'end_time' => '21:00:00',
        'location' => 'Downtown Tech Hub',
        'venue_type' => 'Physical',
        'max_attendees' => 100,
        'registered_count' => 89,
        'status' => 'Upcoming',
        'budget' => 3000.00,
        'organizer' => 'Data Team',
        'contact_email' => 'data@company.com',
        'created_by' => 'admin'
    ]
];

foreach ($events as $event) {
    $location = $event['location'] ?? null;
    $virtual_link = $event['virtual_link'] ?? null;
    
    $stmt = $conn->prepare("INSERT INTO recruitment_events (event_name, event_type, description, event_date, start_time, end_time, location, venue_type, virtual_link, max_attendees, registered_count, status, budget, organizer, contact_email, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->bind_param('sssssssssiisdsss',
        $event['event_name'],
        $event['event_type'],
        $event['description'],
        $event['event_date'],
        $event['start_time'],
        $event['end_time'],
        $location,
        $event['venue_type'],
        $virtual_link,
        $event['max_attendees'],
        $event['registered_count'],
        $event['status'],
        $event['budget'],
        $event['organizer'],
        $event['contact_email'],
        $event['created_by']
    );
    
    if ($stmt->execute()) {
        echo "<div class='success'>✓ Event created: {$event['event_name']}</div>";
    }
}

// Sample Employee Advocates
$advocates = [
    [
        'employee_name' => 'Sarah Johnson',
        'employee_email' => 'sarah.j@company.com',
        'department' => 'Engineering',
        'job_title' => 'Senior Software Engineer',
        'linkedin_url' => 'https://linkedin.com/in/sarahjohnson',
        'twitter_handle' => '@sarahj_tech',
        'status' => 'Active',
        'total_shares' => 45,
        'total_reach' => 12500,
        'total_engagements' => 890,
        'joined_date' => '2024-01-15'
    ],
    [
        'employee_name' => 'Michael Chen',
        'employee_email' => 'michael.c@company.com',
        'department' => 'Product',
        'job_title' => 'Product Manager',
        'linkedin_url' => 'https://linkedin.com/in/michaelchen',
        'status' => 'Active',
        'total_shares' => 38,
        'total_reach' => 9800,
        'total_engagements' => 654,
        'joined_date' => '2024-02-01'
    ],
    [
        'employee_name' => 'Emily Rodriguez',
        'employee_email' => 'emily.r@company.com',
        'department' => 'Marketing',
        'job_title' => 'Marketing Manager',
        'linkedin_url' => 'https://linkedin.com/in/emilyrodriguez',
        'twitter_handle' => '@emily_marketing',
        'facebook_url' => 'https://facebook.com/emilyrodriguez',
        'status' => 'Active',
        'total_shares' => 52,
        'total_reach' => 15200,
        'total_engagements' => 1120,
        'joined_date' => '2024-01-20'
    ],
    [
        'employee_name' => 'David Kim',
        'employee_email' => 'david.k@company.com',
        'department' => 'Design',
        'job_title' => 'UX Designer',
        'linkedin_url' => 'https://linkedin.com/in/davidkim',
        'status' => 'Active',
        'total_shares' => 29,
        'total_reach' => 7600,
        'total_engagements' => 445,
        'joined_date' => '2024-03-10'
    ]
];

foreach ($advocates as $advocate) {
    $twitter_handle = $advocate['twitter_handle'] ?? null;
    $facebook_url = $advocate['facebook_url'] ?? null;
    
    $stmt = $conn->prepare("INSERT INTO employee_advocates (employee_name, employee_email, department, job_title, linkedin_url, twitter_handle, facebook_url, status, total_shares, total_reach, total_engagements, joined_date, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'admin')");
    
    $stmt->bind_param('ssssssssiiis',
        $advocate['employee_name'],
        $advocate['employee_email'],
        $advocate['department'],
        $advocate['job_title'],
        $advocate['linkedin_url'],
        $twitter_handle,
        $facebook_url,
        $advocate['status'],
        $advocate['total_shares'],
        $advocate['total_reach'],
        $advocate['total_engagements'],
        $advocate['joined_date']
    );
    
    if ($stmt->execute()) {
        echo "<div class='success'>✓ Advocate added: {$advocate['employee_name']}</div>";
    }
}

// Sample Advocacy Content
$content = [
    [
        'content_title' => 'Join Our Amazing Team!',
        'content_type' => 'Job Post',
        'content_text' => 'We are hiring talented engineers! Check out our open positions and join a team that values innovation and collaboration.',
        'target_platform' => 'LinkedIn',
        'campaign_name' => 'Engineering Hiring 2024',
        'status' => 'Published'
    ],
    [
        'content_title' => 'Life at Our Company',
        'content_type' => 'Culture Post',
        'content_text' => 'What makes our company special? Our people! Learn about our culture, values, and what it is like to work here.',
        'target_platform' => 'All',
        'campaign_name' => 'Employer Branding',
        'status' => 'Published'
    ],
    [
        'content_title' => 'Tech Talk: AI in Recruitment',
        'content_type' => 'Thought Leadership',
        'content_text' => 'Our team is revolutionizing recruitment with AI. Read about our innovative approach to talent acquisition.',
        'target_platform' => 'LinkedIn',
        'campaign_name' => 'Thought Leadership',
        'status' => 'Published'
    ]
];

foreach ($content as $item) {
    $stmt = $conn->prepare("INSERT INTO advocacy_content (content_title, content_type, content_text, target_platform, campaign_name, status, created_by) VALUES (?, ?, ?, ?, ?, ?, 'admin')");
    
    $stmt->bind_param('ssssss',
        $item['content_title'],
        $item['content_type'],
        $item['content_text'],
        $item['target_platform'],
        $item['campaign_name'],
        $item['status']
    );
    
    if ($stmt->execute()) {
        echo "<div class='success'>✓ Content created: {$item['content_title']}</div>";
    }
}

echo "<hr>";
echo "<h3>Summary:</h3>";
echo "<div class='success'>";
echo "<p><strong>Events created:</strong> " . count($events) . "</p>";
echo "<p><strong>Advocates added:</strong> " . count($advocates) . "</p>";
echo "<p><strong>Content created:</strong> " . count($content) . "</p>";
echo "<p><strong>Status:</strong> Sample data inserted successfully!</p>";
echo "</div>";

echo "<h3>Access the System:</h3>";
echo "<p><a href='http://localhost/rms/Recruitment_events' style='display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 5px; margin: 5px;'>Recruitment Events</a></p>";
echo "<p><a href='http://localhost/rms/Employee_advocacy' style='display: inline-block; padding: 10px 20px; background: #27ae60; color: white; text-decoration: none; border-radius: 5px; margin: 5px;'>Employee Advocacy</a></p>";

$conn->close();
?>
