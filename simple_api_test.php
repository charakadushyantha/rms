<!DOCTYPE html>
<html>
<head>
    <title>Simple API Test</title>
    <style>
        body { font-family: Arial; padding: 20px; max-width: 800px; margin: 0 auto; }
        .success { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
        .warning { color: orange; font-weight: bold; }
        pre { background: #f5f5f5; padding: 15px; border-radius: 5px; overflow-x: auto; }
        .btn { background: #667eea; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin: 5px; }
    </style>
</head>
<body>
    <h2>Simple API Test</h2>

    <?php
    // Step 1: Check files
    echo "<h3>Step 1: Check Files</h3>";
    $files_ok = true;
    
    $required_files = [
        'application/controllers/Api/Interview_api.php' => 'API Controller',
        'application/models/Interview_model.php' => 'Interview Model',
        'application/models/Interview_flow_model.php' => 'Interview Flow Model',
        'application/helpers/api_helper.php' => 'API Helper'
    ];
    
    foreach ($required_files as $file => $name) {
        if (file_exists($file)) {
            echo "<p class='success'>✓ $name exists</p>";
        } else {
            echo "<p class='error'>✗ $name missing at: $file</p>";
            $files_ok = false;
        }
    }
    
    if (!$files_ok) {
        echo "<p class='error'>Some files are missing. Please check the installation.</p>";
        exit;
    }
    
    // Step 2: Check database tables
    echo "<h3>Step 2: Check Database Tables</h3>";
    $tables_ok = true;
    
    try {
        require_once 'config/database.php';
        $conn = getDatabaseConnection();
        
        $required_tables = ['interview_flows', 'interviews', 'interview_responses'];
        
        foreach ($required_tables as $table) {
            $result = $conn->query("SHOW TABLES LIKE '$table'");
            if ($result && $result->num_rows > 0) {
                echo "<p class='success'>✓ Table '$table' exists</p>";
            } else {
                echo "<p class='error'>✗ Table '$table' missing</p>";
                $tables_ok = false;
            }
        }
        
        if (!$tables_ok) {
            echo "<p class='warning'>Tables are missing!</p>";
            echo "<p><a href='create_interview_tables.php' class='btn'>Create Tables Now</a></p>";
        }
        
        $conn->close();
    } catch (Exception $e) {
        echo "<p class='error'>Database error: " . $e->getMessage() . "</p>";
        $tables_ok = false;
    }
    
    // Step 3: Test API
    if ($files_ok && $tables_ok) {
        echo "<h3>Step 3: Test API</h3>";
        echo "<p>All prerequisites met. Testing API...</p>";
        
        $test_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php/api/interview_api/get_flows?api_key=test_key_123';
        
        echo "<p>Testing URL: <code>$test_url</code></p>";
        
        $ch = curl_init($test_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        echo "<p>HTTP Status: <strong>$http_code</strong></p>";
        
        if ($http_code === 200) {
            echo "<p class='success'>✓ API is working!</p>";
            echo "<h4>Response:</h4>";
            echo "<pre>" . htmlspecialchars($response) . "</pre>";
            
            $json = json_decode($response, true);
            if ($json && isset($json['success'])) {
                echo "<p class='success'>✓ Valid JSON response received</p>";
            }
        } elseif ($http_code === 404) {
            echo "<p class='error'>✗ API endpoint not found (404)</p>";
            echo "<p>The route might not be configured correctly.</p>";
        } elseif ($http_code === 500) {
            echo "<p class='error'>✗ Server error (500)</p>";
            echo "<p>There's a PHP error in the controller. Response:</p>";
            echo "<pre>" . htmlspecialchars($response) . "</pre>";
        } else {
            echo "<p class='error'>✗ Unexpected status code: $http_code</p>";
            if ($error) {
                echo "<p>Error: $error</p>";
            }
            if ($response) {
                echo "<pre>" . htmlspecialchars($response) . "</pre>";
            }
        }
    }
    ?>

    <hr>
    <h3>Next Steps:</h3>
    <ul>
        <?php if (!$tables_ok): ?>
        <li><a href="create_interview_tables.php" class="btn">Create Database Tables</a></li>
        <?php endif; ?>
        <li><a href="test_interview_api.php" class="btn">Full API Tester</a></li>
        <li><a href="index.php/interview" class="btn">Web Interface</a></li>
        <li><a href="check_api_error.php" class="btn">Detailed Error Check</a></li>
    </ul>
</body>
</html>
