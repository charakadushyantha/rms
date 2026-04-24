<?php
/**
 * Job Posting Integration - Setup Checker
 * Run this file: http://localhost/rms/check_job_posting_setup.php
 */

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'rmsdb';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>Job Posting Integration - Setup Status</h2>";
echo "<style>
    body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
    .status { padding: 10px; margin: 10px 0; border-radius: 5px; }
    .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    .warning { background: #fff3cd; color: #856404; border: 1px solid #ffeaa7; }
    .info { background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }
    h3 { color: #333; margin-top: 20px; }
    .btn { display: inline-block; padding: 10px 20px; margin: 10px 5px; background: #667eea; color: white; text-decoration: none; border-radius: 5px; }
    .btn:hover { background: #5568d3; }
</style>";

$tables_to_check = [
    'job_postings',
    'job_platforms',
    'job_platform_credentials',
    'job_posting_history'
];

$all_exist = true;
$missing_tables = [];

echo "<h3>Database Tables Status:</h3>";

foreach ($tables_to_check as $table) {
    $result = $conn->query("SHOW TABLES LIKE '$table'");
    if ($result->num_rows > 0) {
        echo "<div class='status success'>✓ Table '$table' exists</div>";
        
        // Count records
        $count_result = $conn->query("SELECT COUNT(*) as count FROM $table");
        $count = $count_result->fetch_assoc()['count'];
        echo "<div class='status info'>  → Contains $count record(s)</div>";
    } else {
        echo "<div class='status error'>✗ Table '$table' is missing</div>";
        $all_exist = false;
        $missing_tables[] = $table;
    }
}

echo "<h3>Model Files Status:</h3>";

$models_to_check = [
    'Job_posting_model.php',
    'Job_platform_model.php'
];

$models_exist = true;

foreach ($models_to_check as $model) {
    $path = __DIR__ . '/application/models/' . $model;
    if (file_exists($path)) {
        echo "<div class='status success'>✓ Model '$model' exists</div>";
    } else {
        echo "<div class='status error'>✗ Model '$model' is missing</div>";
        $models_exist = false;
    }
}

echo "<h3>Controller Files Status:</h3>";

$controllers_to_check = [
    'Job_posting.php'
];

$controllers_exist = true;

foreach ($controllers_to_check as $controller) {
    $path = __DIR__ . '/application/controllers/' . $controller;
    if (file_exists($path)) {
        echo "<div class='status success'>✓ Controller '$controller' exists</div>";
    } else {
        echo "<div class='status error'>✗ Controller '$controller' is missing</div>";
        $controllers_exist = false;
    }
}

echo "<h3>Integration Libraries Status:</h3>";

$libraries_to_check = [
    'Linkedin_integration.php',
    'Indeed_integration.php'
];

$libraries_exist = 0;

foreach ($libraries_to_check as $library) {
    $path = __DIR__ . '/application/libraries/' . $library;
    if (file_exists($path)) {
        echo "<div class='status success'>✓ Library '$library' exists</div>";
        $libraries_exist++;
    } else {
        echo "<div class='status warning'>⚠ Library '$library' is missing (optional)</div>";
    }
}

echo "<hr>";
echo "<h3>Overall Status:</h3>";

if ($all_exist && $models_exist && $controllers_exist) {
    echo "<div class='status success'>";
    echo "<h2>✓ Job Posting Integration is Ready!</h2>";
    echo "<p>All required components are installed and configured.</p>";
    echo "<p><a href='" . "http://localhost/rms/Job_posting" . "' class='btn'>Go to Job Postings</a></p>";
    echo "<p><a href='" . "http://localhost/rms/Setup/job_posting_platforms" . "' class='btn'>Configure Platforms</a></p>";
    echo "</div>";
} else {
    echo "<div class='status error'>";
    echo "<h2>✗ Setup Incomplete</h2>";
    echo "<p>Some components are missing. Please complete the setup:</p>";
    
    if (!$all_exist) {
        echo "<p><strong>Missing Tables:</strong> " . implode(', ', $missing_tables) . "</p>";
        echo "<p><a href='create_job_posting_tables.php' class='btn'>Run Database Migration</a></p>";
    }
    
    if (!$models_exist) {
        echo "<p><strong>Missing Models:</strong> Please ensure model files are created in application/models/</p>";
    }
    
    if (!$controllers_exist) {
        echo "<p><strong>Missing Controllers:</strong> Please ensure controller files are created in application/controllers/</p>";
    }
    
    echo "</div>";
}

// Show platform data if tables exist
if ($all_exist) {
    echo "<h3>Configured Platforms:</h3>";
    $platforms = $conn->query("SELECT * FROM job_platforms");
    
    if ($platforms->num_rows > 0) {
        echo "<table style='width: 100%; border-collapse: collapse; background: white;'>";
        echo "<tr style='background: #667eea; color: white;'>";
        echo "<th style='padding: 10px; text-align: left;'>Platform</th>";
        echo "<th style='padding: 10px; text-align: left;'>Key</th>";
        echo "<th style='padding: 10px; text-align: center;'>Status</th>";
        echo "<th style='padding: 10px; text-align: center;'>Credentials</th>";
        echo "</tr>";
        
        while ($platform = $platforms->fetch_assoc()) {
            $cred_check = $conn->query("SELECT * FROM job_platform_credentials WHERE platform_id = " . $platform['platform_id']);
            $has_creds = $cred_check->num_rows > 0;
            $cred = $has_creds ? $cred_check->fetch_assoc() : null;
            
            echo "<tr style='border-bottom: 1px solid #ddd;'>";
            echo "<td style='padding: 10px;'>" . $platform['platform_name'] . "</td>";
            echo "<td style='padding: 10px;'>" . $platform['platform_key'] . "</td>";
            echo "<td style='padding: 10px; text-align: center;'>" . ($platform['is_active'] ? "✓ Active" : "✗ Inactive") . "</td>";
            echo "<td style='padding: 10px; text-align: center;'>" . ($has_creds && $cred['is_enabled'] ? "✓ Configured" : "⚠ Not Configured") . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    }
}

echo "<hr>";
echo "<p style='color: #666; font-size: 12px;'>For security, delete this file after setup is complete.</p>";

$conn->close();
?>
