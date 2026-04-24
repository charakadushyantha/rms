<!DOCTYPE html>
<html>
<head>
    <title>Direct API Test</title>
    <style>
        body { font-family: Arial; padding: 20px; max-width: 800px; margin: 0 auto; }
        .success { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
        pre { background: #f5f5f5; padding: 15px; border-radius: 5px; overflow-x: auto; }
    </style>
</head>
<body>
    <h2>Direct API Controller Test</h2>

    <?php
    // Test 1: Check if controller file exists
    echo "<h3>Test 1: Controller File</h3>";
    $controller_path = 'application/controllers/Api/Interview_api.php';
    if (file_exists($controller_path)) {
        echo "<p class='success'>✓ Controller file exists at: $controller_path</p>";
    } else {
        echo "<p class='error'>✗ Controller file NOT found at: $controller_path</p>";
    }

    // Test 2: Check routes
    echo "<h3>Test 2: Routes Configuration</h3>";
    $routes_content = file_get_contents('application/config/routes.php');
    if (strpos($routes_content, 'interview_api') !== false) {
        echo "<p class='success'>✓ Interview API routes are configured</p>";
    } else {
        echo "<p class='error'>✗ Interview API routes NOT found in routes.php</p>";
    }

    // Test 3: Try to access via cURL
    echo "<h3>Test 3: Direct API Access</h3>";
    
    $test_urls = [
        'index.php/api/interview_api/get_flows?api_key=test',
        'api/interview_api/get_flows?api_key=test'
    ];

    foreach ($test_urls as $url) {
        $full_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/' . $url;
        echo "<p>Testing: <code>$url</code></p>";
        
        $ch = curl_init($full_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($http_code === 200) {
            echo "<p class='success'>✓ HTTP $http_code - API accessible!</p>";
            echo "<pre>" . htmlspecialchars(substr($response, 0, 500)) . "</pre>";
        } elseif ($http_code === 404) {
            echo "<p class='error'>✗ HTTP $http_code - Route not found</p>";
        } elseif ($http_code === 401) {
            echo "<p class='success'>✓ HTTP $http_code - API accessible (auth required)</p>";
        } else {
            echo "<p class='error'>✗ HTTP $http_code - " . curl_error($ch) . "</p>";
        }
    }

    // Test 4: Check .htaccess
    echo "<h3>Test 4: .htaccess Configuration</h3>";
    if (file_exists('.htaccess')) {
        echo "<p class='success'>✓ .htaccess file exists</p>";
        $htaccess = file_get_contents('.htaccess');
        if (strpos($htaccess, 'RewriteEngine On') !== false) {
            echo "<p class='success'>✓ RewriteEngine is enabled</p>";
        }
    } else {
        echo "<p class='error'>✗ .htaccess file NOT found</p>";
    }

    // Test 5: Alternative access method
    echo "<h3>Test 5: Alternative Access (Without Routes)</h3>";
    echo "<p>Try accessing directly without custom routes:</p>";
    echo "<p><a href='index.php?c=api/interview_api&m=get_flows&api_key=test' target='_blank'>Test Direct Access</a></p>";
    ?>

    <hr>
    <h3>Recommendations:</h3>
    <ol>
        <li>If routes don't work, try: <code>index.php?c=api/interview_api&m=get_flows</code></li>
        <li>Check if mod_rewrite is enabled in Apache</li>
        <li>Verify base_url in application/config/config.php</li>
        <li>Try the test page: <a href="test_api_routes.php">test_api_routes.php</a></li>
    </ol>
</body>
</html>
