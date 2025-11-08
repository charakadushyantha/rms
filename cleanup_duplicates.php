<?php
/**
 * Clean Up Duplicate Pipeline Entries
 * Run: http://localhost/rms/cleanup_duplicates.php
 */

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'rmsdb';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h1>🧹 Cleaning Up Duplicate Pipeline Entries</h1>";
echo "<hr>";

// Find duplicates
$sql = "SELECT candidate_id, COUNT(*) as count 
        FROM candidate_pipeline 
        GROUP BY candidate_id 
        HAVING count > 1";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h3>Found duplicates for " . $result->num_rows . " candidates</h3>";
    
    $cleaned = 0;
    
    while ($row = $result->fetch_assoc()) {
        $candidate_id = $row['candidate_id'];
        $count = $row['count'];
        
        echo "<p>Candidate ID $candidate_id has $count entries. Keeping the most recent one...</p>";
        
        // Keep only the most recent entry
        $cleanup_sql = "DELETE FROM candidate_pipeline 
                       WHERE candidate_id = $candidate_id 
                       AND id NOT IN (
                           SELECT id FROM (
                               SELECT id FROM candidate_pipeline 
                               WHERE candidate_id = $candidate_id 
                               ORDER BY moved_at DESC 
                               LIMIT 1
                           ) as temp
                       )";
        
        if ($conn->query($cleanup_sql)) {
            $cleaned += ($count - 1);
            echo "✅ Cleaned up " . ($count - 1) . " duplicate(s)<br>";
        }
    }
    
    echo "<hr>";
    echo "<h3 style='color: green;'>✅ Cleanup Complete!</h3>";
    echo "<p>Removed <strong>$cleaned</strong> duplicate entries</p>";
} else {
    echo "<p style='color: green;'>✅ No duplicates found! Your pipeline is clean.</p>";
}

echo "<hr>";
echo "<h3>Next Steps:</h3>";
echo "<p><a href='realtime_dashboard' style='display: inline-block; background: #667eea; color: white; padding: 15px 30px; border-radius: 8px; text-decoration: none; font-weight: bold;'>→ Open Dashboard</a></p>";

$conn->close();
?>

<style>
body { font-family: Arial; max-width: 800px; margin: 50px auto; padding: 20px; background: #f5f5f5; }
h1 { color: #333; }
a { color: #667eea; text-decoration: none; font-weight: bold; }
</style>
