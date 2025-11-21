<?php
/**
 * FORCE Add Missing Columns to module_visibility Table
 */

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'rmsdb';

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>🔧 Force Adding Missing Columns</h2>";

// Check current structure
echo "<h3>1. Current Table Structure</h3>";
$columns = $conn->query("SHOW COLUMNS FROM module_visibility");
$existing_columns = array();
echo "<ul>";
while ($col = $columns->fetch_assoc()) {
    $existing_columns[] = $col['Field'];
    echo "<li>" . $col['Field'] . " (" . $col['Type'] . ")</li>";
}
echo "</ul>";

// Add module_name if missing
if (!in_array('module_name', $existing_columns)) {
    echo "<h3>2. Adding 'module_name' column...</h3>";
    $sql = "ALTER TABLE `module_visibility` ADD COLUMN `module_name` VARCHAR(100) NULL AFTER `module_key`";
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>✅ Successfully added 'module_name' column</p>";
    } else {
        echo "<p style='color: red;'>❌ Error: " . $conn->error . "</p>";
    }
} else {
    echo "<h3>2. Column 'module_name' already exists ✅</h3>";
}

// Add section if missing
if (!in_array('section', $existing_columns)) {
    echo "<h3>3. Adding 'section' column...</h3>";
    $sql = "ALTER TABLE `module_visibility` ADD COLUMN `section` VARCHAR(50) NULL AFTER `module_name`";
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>✅ Successfully added 'section' column</p>";
    } else {
        echo "<p style='color: red;'>❌ Error: " . $conn->error . "</p>";
    }
} else {
    echo "<h3>3. Column 'section' already exists ✅</h3>";
}

// Show updated structure
echo "<h3>4. Updated Table Structure</h3>";
$columns = $conn->query("SHOW COLUMNS FROM module_visibility");
echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th></tr>";
while ($col = $columns->fetch_assoc()) {
    echo "<tr>";
    echo "<td><strong>" . $col['Field'] . "</strong></td>";
    echo "<td>" . $col['Type'] . "</td>";
    echo "<td>" . $col['Null'] . "</td>";
    echo "<td>" . $col['Key'] . "</td>";
    echo "</tr>";
}
echo "</table>";

// Count modules
$count = $conn->query("SELECT COUNT(*) as total FROM module_visibility")->fetch_assoc();
echo "<h3>5. Total Modules: " . $count['total'] . "</h3>";

// Test the query that was failing
echo "<h3>6. Testing Query</h3>";
try {
    $test = $conn->query("SELECT * FROM module_visibility ORDER BY section ASC, module_name ASC");
    if ($test) {
        echo "<p style='color: green;'>✅ Query works! Found " . $test->num_rows . " modules</p>";
    } else {
        echo "<p style='color: red;'>❌ Query failed: " . $conn->error . "</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Exception: " . $e->getMessage() . "</p>";
}

$conn->close();

echo "<br><br>";
echo "<div style='padding: 20px; background: #d1fae5; border: 2px solid #10b981; border-radius: 8px; margin: 20px 0;'>";
echo "<h3 style='color: #065f46;'>✅ Columns Added!</h3>";
echo "<p style='color: #065f46;'>Now try opening Module Manager again:</p>";
echo "<p style='margin: 10px 0;'><a href='Setup/module_manager' style='display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 6px; font-weight: bold;'>Open Module Manager →</a></p>";
echo "</div>";

echo "<br>";
echo "<div style='padding: 20px; margin: 20px 0; border-top: 2px solid #e5e7eb;'>";
echo "<a href='index.php' style='display: inline-block; padding: 10px 20px; background: #6b7280; color: white; text-decoration: none; border-radius: 6px;'>← Back to Home</a>";
echo "</div>";
?>
