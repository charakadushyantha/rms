<?php
/**
 * Fix Campaign Analytics Table Structure
 */

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'rmsdb';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>Fixing Campaign Analytics Table</h2>";
echo "<style>
    body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
    .success { color: green; padding: 10px; background: #d4edda; margin: 10px 0; border-radius: 5px; }
    .info { color: blue; padding: 10px; background: #d1ecf1; margin: 10px 0; border-radius: 5px; }
</style>";

// Drop the old table
$sql = "DROP TABLE IF EXISTS `campaign_analytics`";
if ($conn->query($sql) === TRUE) {
    echo "<div class='info'>✓ Old campaign_analytics table dropped</div>";
}

// Recreate with correct structure
$sql = "CREATE TABLE `campaign_analytics` (
    `analytics_id` int(11) NOT NULL AUTO_INCREMENT,
    `campaign_id` int(11) NOT NULL,
    `date` date NOT NULL,
    `reach` int(11) DEFAULT 0,
    `impressions` int(11) DEFAULT 0,
    `clicks` int(11) DEFAULT 0,
    `applications` int(11) DEFAULT 0,
    `spent` decimal(10,2) DEFAULT 0,
    `conversions` int(11) DEFAULT 0,
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`analytics_id`),
    FOREIGN KEY (`campaign_id`) REFERENCES `marketing_campaigns`(`campaign_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ New campaign_analytics table created with correct structure</div>";
}

// Re-insert sample analytics data for active campaigns
$campaigns = $conn->query("SELECT campaign_id, budget, status FROM marketing_campaigns WHERE status = 'Active'");

if ($campaigns && $campaigns->num_rows > 0) {
    while ($campaign = $campaigns->fetch_assoc()) {
        $reach = rand(5000, 25000);
        $impressions = $reach * rand(2, 4);
        $clicks = rand(500, 2000);
        $applications = rand(50, 200);
        $spent = $campaign['budget'] * (rand(30, 70) / 100);
        $date = date('Y-m-d');
        
        $stmt = $conn->prepare("INSERT INTO campaign_analytics (campaign_id, date, reach, impressions, clicks, applications, spent) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param('isiiiid', $campaign['campaign_id'], $date, $reach, $impressions, $clicks, $applications, $spent);
            if ($stmt->execute()) {
                echo "<div class='info'>✓ Analytics added for campaign ID: {$campaign['campaign_id']} - Reach: $reach, Clicks: $clicks, Applications: $applications</div>";
            }
        }
    }
}

echo "<hr>";
echo "<div class='success'><strong>Table fixed successfully!</strong></div>";
echo "<p><a href='http://localhost/rms/Marketing_campaigns' style='display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 5px;'>View Campaigns</a></p>";

$conn->close();
?>
