<?php
/**
 * Debug Module Manager - Check what's in the database
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

echo "<h2>🔍 Module Manager Debug</h2>";

// Check table structure
echo "<h3>1. Table Structure</h3>";
$columns = $conn->query("SHOW COLUMNS FROM module_visibility");
echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th></tr>";
while ($col = $columns->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $col['Field'] . "</td>";
    echo "<td>" . $col['Type'] . "</td>";
    echo "<td>" . $col['Null'] . "</td>";
    echo "<td>" . $col['Key'] . "</td>";
    echo "</tr>";
}
echo "</table>";

// Count total modules
echo "<h3>2. Total Modules</h3>";
$count_result = $conn->query("SELECT COUNT(*) as total FROM module_visibility");
$count = $count_result->fetch_assoc();
echo "<p><strong>Total modules in database:</strong> " . $count['total'] . "</p>";

// Show all modules
echo "<h3>3. All Modules in Database</h3>";
$modules = $conn->query("SELECT * FROM module_visibility ORDER BY section, module_name");
echo "<table border='1' cellpadding='5' style='border-collapse: collapse; width: 100%;'>";
echo "<tr><th>ID</th><th>Module Key</th><th>Module Name</th><th>Section</th><th>Visible</th></tr>";
while ($mod = $modules->fetch_assoc()) {
    $visible = $mod['is_visible'] ? '✅ Yes' : '❌ No';
    echo "<tr>";
    echo "<td>" . $mod['id'] . "</td>";
    echo "<td>" . $mod['module_key'] . "</td>";
    echo "<td>" . (isset($mod['module_name']) ? $mod['module_name'] : 'N/A') . "</td>";
    echo "<td>" . (isset($mod['section']) ? $mod['section'] : 'N/A') . "</td>";
    echo "<td>" . $visible . "</td>";
    echo "</tr>";
}
echo "</table>";

// Group by section
echo "<h3>4. Modules by Section</h3>";
$sections = $conn->query("SELECT section, COUNT(*) as count FROM module_visibility GROUP BY section ORDER BY section");
echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
echo "<tr><th>Section</th><th>Count</th></tr>";
while ($sec = $sections->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . (isset($sec['section']) && $sec['section'] ? $sec['section'] : 'NULL/Empty') . "</td>";
    echo "<td>" . $sec['count'] . "</td>";
    echo "</tr>";
}
echo "</table>";

// Test the query used in Module Manager
echo "<h3>5. Testing Module Manager Query</h3>";
$test_query = "SELECT * FROM module_visibility";

// Check if columns exist
$columns_check = $conn->query("SHOW COLUMNS FROM module_visibility LIKE 'section'");
if ($columns_check->num_rows > 0) {
    $test_query .= " ORDER BY section ASC";
    echo "<p>✅ 'section' column exists - ordering by section</p>";
} else {
    echo "<p>❌ 'section' column does NOT exist</p>";
}

$columns_check = $conn->query("SHOW COLUMNS FROM module_visibility LIKE 'module_name'");
if ($columns_check->num_rows > 0) {
    $test_query .= ", module_name ASC";
    echo "<p>✅ 'module_name' column exists - ordering by module_name</p>";
} else {
    echo "<p>❌ 'module_name' column does NOT exist</p>";
    $test_query .= ", module_key ASC";
}

echo "<p><strong>Query:</strong> <code>$test_query</code></p>";

$result = $conn->query($test_query);
echo "<p><strong>Results:</strong> " . $result->num_rows . " modules found</p>";

if ($result->num_rows > 0) {
    echo "<div style='padding: 20px; background: #d1fae5; border: 2px solid #10b981; border-radius: 8px; margin: 20px 0;'>";
    echo "<h3 style='color: #065f46;'>✅ Query Works!</h3>";
    echo "<p style='color: #065f46;'>The Module Manager should be able to load " . $result->num_rows . " modules.</p>";
    echo "</div>";
} else {
    echo "<div style='padding: 20px; background: #fee2e2; border: 2px solid #ef4444; border-radius: 8px; margin: 20px 0;'>";
    echo "<h3 style='color: #991b1b;'>❌ Query Returns No Results!</h3>";
    echo "<p style='color: #991b1b;'>This is why Module Manager shows fallback modules.</p>";
    echo "</div>";
}

$conn->close();

echo "<br><br>";
echo "<div style='padding: 20px; margin: 20px 0; border-top: 2px solid #e5e7eb;'>";
echo "<a href='Setup/module_manager' style='display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 6px;'>Open Module Manager →</a>";
echo " ";
echo "<a href='index.php' style='display: inline-block; padding: 10px 20px; background: #6b7280; color: white; text-decoration: none; border-radius: 6px;'>← Back to Home</a>";
echo "</div>";
?>
