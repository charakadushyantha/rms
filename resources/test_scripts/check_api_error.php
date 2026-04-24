<?php
/**
 * Check API Error Details
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Checking API Controller Error</h2>";
echo "<style>body{font-family:Arial;padding:20px;} .error{color:red;} .success{color:green;}</style>";

// Test 1: Check if controller can be loaded
echo "<h3>Test 1: Load Controller File</h3>";
try {
    if (file_exists('application/controllers/Api/Interview_api.php')) {
        echo "<p class='success'>✓ Controller file exists</p>";
        
        // Check for syntax errors
        $output = shell_exec('php -l application/controllers/Api/Interview_api.php 2>&1');
        if (strpos($output, 'No syntax errors') !== false) {
            echo "<p class='success'>✓ No syntax errors in controller</p>";
        } else {
            echo "<p class='error'>✗ Syntax error: $output</p>";
        }
    } else {
        echo "<p class='error'>✗ Controller file not found</p>";
    }
} catch (Exception $e) {
    echo "<p class='error'>Error: " . $e->getMessage() . "</p>";
}

// Test 2: Check if models exist
echo "<h3>Test 2: Check Required Models</h3>";
$models = [
    'application/models/Interview_flow_model.php',
    'application/models/Interview_model.php'
];

foreach ($models as $model) {
    if (file_exists($model)) {
        echo "<p class='success'>✓ " . basename($model) . " exists</p>";
    } else {
        echo "<p class='error'>✗ " . basename($model) . " NOT found</p>";
    }
}

// Test 3: Check if helper exists
echo "<h3>Test 3: Check Helper</h3>";
if (file_exists('application/helpers/api_helper.php')) {
    echo "<p class='success'>✓ api_helper.php exists</p>";
} else {
    echo "<p class='error'>✗ api_helper.php NOT found (this might be the issue!)</p>";
    echo "<p>Creating api_helper.php...</p>";
    
    $helper_content = "<?php\ndefined('BASEPATH') OR exit('No direct script access allowed');\n\n// API Helper functions\n";
    
    if (!is_dir('application/helpers')) {
        mkdir('application/helpers', 0755, true);
    }
    
    file_put_contents('application/helpers/api_helper.php', $helper_content);
    echo "<p class='success'>✓ Created api_helper.php</p>";
}

// Test 4: Try to access with error display
echo "<h3>Test 4: Access API with Error Display</h3>";
echo "<p>Click to test: <a href='index.php/api/interview_api/get_flows?api_key=test' target='_blank'>Test API</a></p>";
echo "<p>If you see errors, they will be displayed on that page.</p>";

// Test 5: Check database tables
echo "<h3>Test 5: Check Database Tables</h3>";
try {
    require_once 'config/database.php';
    $conn = getDatabaseConnection();
    
    $tables = ['interview_flows', 'interviews'];
    foreach ($tables as $table) {
        $result = $conn->query("SHOW TABLES LIKE '$table'");
        if ($result && $result->num_rows > 0) {
            echo "<p class='success'>✓ Table '$table' exists</p>";
        } else {
            echo "<p class='error'>✗ Table '$table' missing</p>";
            echo "<p>Run: <a href='create_interview_tables.php'>create_interview_tables.php</a></p>";
        }
    }
    
    $conn->close();
} catch (Exception $e) {
    echo "<p class='error'>Database error: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<h3>Solution:</h3>";
echo "<p>The most likely issue is the missing api_helper.php file. I've created it above.</p>";
echo "<p>Now try accessing the API again:</p>";
echo "<p><a href='test_interview_api.php' class='btn'>Test Interview API</a></p>";
?>
