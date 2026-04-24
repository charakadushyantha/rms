<?php
$conn = new mysqli('localhost', 'root', '', 'rmsdb');
$result = $conn->query('SELECT COUNT(*) as count FROM email_templates');
$row = $result->fetch_assoc();
echo "Email templates count: " . $row['count'] . "\n";

if ($row['count'] == 0) {
    echo "No templates found. Adding sample templates...\n";
    
    $templates = [
        ['Job Alert - Tech Positions', 'Exciting Tech Opportunities at {{company_name}}', '<h2>New Opportunities Available</h2><p>Dear {{candidate_name}},</p><p>We have exciting new positions that match your profile.</p>', 'Job Alert'],
        ['Welcome to Talent Network', 'Welcome to Our Talent Network!', '<h2>Welcome!</h2><p>Thank you for joining our talent network. We will keep you updated on opportunities that match your skills.</p>', 'Welcome'],
        ['Interview Invitation', 'Interview Invitation for {{job_title}}', '<h2>Interview Invitation</h2><p>Dear {{candidate_name}},</p><p>We would like to invite you for an interview.</p>', 'Interview'],
        ['Application Received', 'Application Received - {{job_title}}', '<h2>Application Received</h2><p>Thank you for your application! We will review it and get back to you soon.</p>', 'Confirmation']
    ];
    
    foreach ($templates as $template) {
        $stmt = $conn->prepare("INSERT INTO email_templates (template_name, subject, body_html, category, is_active) VALUES (?, ?, ?, ?, 1)");
        $stmt->bind_param('ssss', $template[0], $template[1], $template[2], $template[3]);
        $stmt->execute();
        echo "Added template: {$template[0]}\n";
    }
}

$conn->close();
?>
