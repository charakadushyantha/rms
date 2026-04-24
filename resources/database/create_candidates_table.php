<?php
/**
 * Create Candidates Table
 * Run: http://localhost/rms/create_candidates_table.php
 */

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'rmsdb';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h1>Creating Candidates Table</h1>";
echo "<hr>";

// Create candidates table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS `candidates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `position_applied` varchar(255) DEFAULT NULL,
  `resume_path` varchar(500) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if ($conn->query($sql)) {
    echo "<p style='color: green;'>✅ Candidates table created successfully!</p>";
} else {
    echo "<p style='color: red;'>❌ Error: " . $conn->error . "</p>";
}

// Check if table exists
$result = $conn->query("SHOW TABLES LIKE 'candidates'");
if ($result->num_rows > 0) {
    echo "<p>✅ Table verified: <strong>candidates</strong></p>";
    
    // Show table structure
    $result = $conn->query("DESCRIBE candidates");
    echo "<h3>Table Structure:</h3>";
    echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['Field']}</td>";
        echo "<td>{$row['Type']}</td>";
        echo "<td>{$row['Null']}</td>";
        echo "<td>{$row['Key']}</td>";
        echo "</tr>";
    }
    echo "</table>";
}

echo "<hr>";
echo "<h3>Next Steps:</h3>";
echo "<ol>";
echo "<li>✅ Candidates table is ready</li>";
echo "<li>🎯 <a href='add_sample_data.php'>Add Sample Data</a></li>";
echo "<li>📊 <a href='realtime_dashboard'>Open Dashboard</a></li>";
echo "</ol>";

$conn->close();
?>

<style>
body { font-family: Arial; max-width: 800px; margin: 50px auto; padding: 20px; background: #f5f5f5; }
h1 { color: #333; }
a { color: #667eea; text-decoration: none; font-weight: bold; }
table { background: white; margin: 20px 0; }
th { background: #667eea; color: white; }
</style>
