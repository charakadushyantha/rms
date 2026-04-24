<?php
/**
 * Debug Bot Connection Issues
 */

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Bot Connection Debug</h2>";
echo "<style>body{font-family:Arial;padding:20px;} .success{color:green;} .error{color:red;} .info{color:blue;} pre{background:#f5f5f5;padding:10px;border-radius:5px;}</style>";

// Test 1: Database Connection
echo "<h3>Test 1: Database Connection</h3>";
try {
    require_once __DIR__ . '/config/database.php';
    $conn = getDatabaseConnection();
    echo "<p class='success'>✓ Database connected</p>";
    echo "<p>Database: " . DB_NAME . "</p>";
} catch (Exception $e) {
    echo "<p class='error'>✗ Database error: " . $e->getMessage() . "</p>";
    die();
}

// Test 2: Check Tables
echo "<h3>Test 2: Check Required Tables</h3>";
$required_tables = ['bot_config', 'chat_sessions', 'chat_history', 'bot_intents', 'knowledge_base'];
foreach ($required_tables as $table) {
    $result = $conn->query("SHOW TABLES LIKE '$table'");
    if ($result && $result->num_rows > 0) {
        echo "<p class='success'>✓ Table '$table' exists</p>";
    } else {
        echo "<p class='error'>✗ Table '$table' missing</p>";
    }
}

// Test 3: Check CodeIgniter
echo "<h3>Test 3: CodeIgniter Framework</h3>";
if (file_exists('index.php')) {
    echo "<p class='success'>✓ index.php exists</p>";
} else {
    echo "<p class='error'>✗ index.php missing</p>";
}

if (file_exists('application/config/config.php')) {
    echo "<p class='success'>✓ CodeIgniter config exists</p>";
    
    // Check base_url
    require_once 'application/config/config.php';
    if (isset($config['base_url'])) {
        echo "<p class='info'>Base URL: " . $config['base_url'] . "</p>";
    }
} else {
    echo "<p class='error'>✗ CodeIgniter config missing</p>";
}

// Test 4: Check Bot Files
echo "<h3>Test 4: Check Bot Files</h3>";
$bot_files = [
    'application/controllers/Bot.php' => 'Bot Controller',
    'application/models/Bot_model.php' => 'Bot Model',
    'application/models/Chat_history_model.php' => 'Chat History Model',
    'application/libraries/BotEngine.php' => 'Bot Engine',
    'application/views/bot/chat_widget.php' => 'Chat Widget'
];

foreach ($bot_files as $file => $name) {
    if (file_exists($file)) {
        echo "<p class='success'>✓ $name</p>";
    } else {
        echo "<p class='error'>✗ $name missing at: $file</p>";
    }
}

// Test 5: Test Bot Controller Directly
echo "<h3>Test 5: Test Bot Endpoint</h3>";
echo "<p class='info'>Testing: index.php/bot/send_message</p>";

// Simulate a POST request
$_POST['message'] = 'test message';
$_POST['session_id'] = 'test_session_' . time();

// Try to load CodeIgniter
if (file_exists('index.php')) {
    echo "<p class='info'>Attempting to call bot endpoint...</p>";
    
    // Use cURL to test the endpoint
    $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php/bot/send_message';
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'message' => 'test',
        'session_id' => 'test_' . time()
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    echo "<p>HTTP Code: <strong>$http_code</strong></p>";
    
    if ($error) {
        echo "<p class='error'>cURL Error: $error</p>";
    }
    
    if ($response) {
        echo "<p class='info'>Response:</p>";
        echo "<pre>" . htmlspecialchars($response) . "</pre>";
        
        // Try to decode JSON
        $json = json_decode($response, true);
        if ($json) {
            echo "<p class='success'>✓ Valid JSON response</p>";
            if (isset($json['success'])) {
                if ($json['success']) {
                    echo "<p class='success'>✓ Bot is working!</p>";
                } else {
                    echo "<p class='error'>✗ Bot returned error: " . ($json['error'] ?? 'Unknown') . "</p>";
                }
            }
        } else {
            echo "<p class='error'>✗ Response is not valid JSON</p>";
        }
    } else {
        echo "<p class='error'>✗ No response from bot endpoint</p>";
    }
}

// Test 6: Check for PHP Errors
echo "<h3>Test 6: Check PHP Configuration</h3>";
echo "<p>PHP Version: <strong>" . phpversion() . "</strong></p>";
echo "<p>Required: PHP 7.0+</p>";

$required_extensions = ['mysqli', 'json', 'curl'];
foreach ($required_extensions as $ext) {
    if (extension_loaded($ext)) {
        echo "<p class='success'>✓ Extension '$ext' loaded</p>";
    } else {
        echo "<p class='error'>✗ Extension '$ext' missing</p>";
    }
}

// Test 7: Check Session
echo "<h3>Test 7: Session Check</h3>";
if (session_status() === PHP_SESSION_ACTIVE) {
    echo "<p class='success'>✓ Session active</p>";
} else {
    session_start();
    echo "<p class='info'>Session started</p>";
}

// Test 8: Manual Bot Test
echo "<h3>Test 8: Manual Bot Model Test</h3>";
try {
    // Define BASEPATH for CodeIgniter
    define('BASEPATH', __DIR__ . '/system/');
    
    // Try to instantiate models manually
    echo "<p class='info'>Attempting to load Bot_model...</p>";
    
    // Check if we can query bot_config
    $result = $conn->query("SELECT * FROM bot_config LIMIT 1");
    if ($result) {
        echo "<p class='success'>✓ Can query bot_config table</p>";
        if ($result->num_rows > 0) {
            echo "<p class='success'>✓ Bot config has data</p>";
        } else {
            echo "<p class='error'>✗ Bot config is empty - run create_bot_tables.php</p>";
        }
    }
    
    // Check chat_history
    $result = $conn->query("SELECT COUNT(*) as count FROM chat_history");
    if ($result) {
        $row = $result->fetch_assoc();
        echo "<p class='info'>Chat history records: " . $row['count'] . "</p>";
    }
    
} catch (Exception $e) {
    echo "<p class='error'>Error: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<h3>Summary</h3>";
echo "<p>If all tests pass but chatbot still shows connection error:</p>";
echo "<ol>";
echo "<li>Clear browser cache (Ctrl+Shift+Delete)</li>";
echo "<li>Check browser console (F12) for JavaScript errors</li>";
echo "<li>Verify base_url in application/config/config.php</li>";
echo "<li>Check .htaccess file exists</li>";
echo "<li>Ensure mod_rewrite is enabled in Apache</li>";
echo "</ol>";

echo "<hr>";
echo "<p><a href='test_bot.php'>Run Full Test</a> | ";
echo "<a href='create_bot_tables.php'>Recreate Tables</a> | ";
echo "<a href='bot_demo_standalone.html'>Try Standalone Demo</a></p>";

$conn->close();
?>
