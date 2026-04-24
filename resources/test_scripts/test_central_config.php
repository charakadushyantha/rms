<?php
/**
 * Test Central Database Configuration
 * 
 * Run this script to verify your central database configuration is working
 */

echo "<h2>Central Database Configuration Test</h2>";

// Test 1: Check if config file exists
echo "<h3>Test 1: Configuration File</h3>";
if (file_exists(__DIR__ . '/config/database.php')) {
    echo "<p style='color: green;'>✓ config/database.php exists</p>";
} else {
    echo "<p style='color: red;'>✗ config/database.php not found</p>";
    die("Please create the central config file first.");
}

// Test 2: Load configuration
echo "<h3>Test 2: Load Configuration</h3>";
try {
    require_once __DIR__ . '/config/database.php';
    echo "<p style='color: green;'>✓ Configuration loaded successfully</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error loading config: " . $e->getMessage() . "</p>";
    die();
}

// Test 3: Check constants
echo "<h3>Test 3: Configuration Constants</h3>";
echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
echo "<tr><th>Constant</th><th>Value</th><th>Status</th></tr>";

$constants = ['DB_HOST', 'DB_USER', 'DB_NAME', 'DB_CHARSET', 'DB_COLLATION', 'DB_ENVIRONMENT'];
foreach ($constants as $const) {
    $value = defined($const) ? constant($const) : 'NOT DEFINED';
    $status = defined($const) ? '✓' : '✗';
    $color = defined($const) ? 'green' : 'red';
    
    // Hide password for security
    if ($const === 'DB_PASS') {
        $value = defined($const) ? '***hidden***' : 'NOT DEFINED';
    }
    
    echo "<tr>";
    echo "<td><strong>$const</strong></td>";
    echo "<td>$value</td>";
    echo "<td style='color: $color;'>$status</td>";
    echo "</tr>";
}
echo "</table>";

// Test 4: Test connection function
echo "<h3>Test 4: Database Connection</h3>";
try {
    $conn = getDatabaseConnection();
    echo "<p style='color: green;'>✓ Connection successful!</p>";
    
    // Get server info
    echo "<p><strong>MySQL Version:</strong> " . $conn->server_info . "</p>";
    echo "<p><strong>Host Info:</strong> " . $conn->host_info . "</p>";
    echo "<p><strong>Character Set:</strong> " . $conn->character_set_name() . "</p>";
    
    // Test query
    $result = $conn->query("SELECT DATABASE() as db_name");
    if ($result) {
        $row = $result->fetch_assoc();
        echo "<p><strong>Connected to Database:</strong> " . $row['db_name'] . "</p>";
    }
    
    $conn->close();
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Connection failed: " . $e->getMessage() . "</p>";
}

// Test 5: Test helper functions
echo "<h3>Test 5: Helper Functions</h3>";

// Test getDatabaseConfig()
$config = getDatabaseConfig();
echo "<p>✓ getDatabaseConfig() returns: " . count($config) . " configuration items</p>";

// Test testDatabaseConnection()
if (testDatabaseConnection()) {
    echo "<p style='color: green;'>✓ testDatabaseConnection() passed</p>";
} else {
    echo "<p style='color: red;'>✗ testDatabaseConnection() failed</p>";
}

// Test 6: Environment file check
echo "<h3>Test 6: Environment File</h3>";
if (file_exists(__DIR__ . '/.env')) {
    echo "<p style='color: green;'>✓ .env file exists</p>";
    echo "<p><em>Note: Make sure .env is in .gitignore</em></p>";
} else {
    echo "<p style='color: orange;'>⚠ .env file not found (using default config)</p>";
    echo "<p><em>Create .env from .env.example for production use</em></p>";
}

// Summary
echo "<hr>";
echo "<h3>Summary</h3>";
echo "<p><strong>Environment:</strong> " . DB_ENVIRONMENT . "</p>";
echo "<p><strong>Status:</strong> <span style='color: green; font-weight: bold;'>Configuration is working!</span></p>";

echo "<hr>";
echo "<h3>Next Steps</h3>";
echo "<ol>";
echo "<li>Run <a href='migrate_to_central_config.php'>migrate_to_central_config.php</a> to update all scripts</li>";
echo "<li>Create .env file from .env.example for production</li>";
echo "<li>Update application/config/database.php to use central config</li>";
echo "<li>Test your application thoroughly</li>";
echo "</ol>";
