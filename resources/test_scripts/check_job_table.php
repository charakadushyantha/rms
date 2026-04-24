<?php
require_once 'config/database.php';

$conn = getDatabaseConnection();

echo "<h2>Checking Job-related Tables</h2>";
echo "<style>body{font-family:Arial;padding:20px;} .success{color:green;} .error{color:red;}</style>";

// Get all tables
$result = $conn->query("SHOW TABLES");

echo "<h3>All Tables in Database:</h3>";
echo "<ul>";
$job_tables = [];
while ($row = $result->fetch_array()) {
    $table = $row[0];
    echo "<li>$table</li>";
    if (stripos($table, 'job') !== false) {
        $job_tables[] = $table;
    }
}
echo "</ul>";

if (!empty($job_tables)) {
    echo "<h3 class='success'>Job-related tables found:</h3>";
    echo "<ul>";
    foreach ($job_tables as $table) {
        echo "<li class='success'>$table</li>";
        
        // Show structure
        $result = $conn->query("DESCRIBE $table");
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li>{$row['Field']} ({$row['Type']})</li>";
        }
        echo "</ul>";
    }
    echo "</ul>";
} else {
    echo "<p class='error'>No job-related tables found!</p>";
    echo "<p>You need to create a jobs table. Would you like me to create it?</p>";
}

$conn->close();
?>
