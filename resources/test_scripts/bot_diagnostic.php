<!DOCTYPE html>
<html>
<head>
    <title>Bot Diagnostic</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .success { color: green; }
        .error { color: red; }
        .info { color: blue; }
        pre { background: #f5f5f5; padding: 10px; border-radius: 5px; }
    </style>
</head>
<body>
    <h1>🔍 Bot System Diagnostic</h1>
    
    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    echo "<h2>1. Checking Files</h2>";
    
    $files_to_check = [
        'application/controllers/Bot.php',
        'application/models/Bot_model.php',
        'application/models/Chat_history_model.php',
        'application/libraries/BotEngine.php',
        'application/views/bot/chat_interface.php',
        'application/views/bot/chat_widget.php'
    ];
    
    foreach ($files_to_check as $file) {
        if (file_exists($file)) {
            $size = filesize($file);
            echo "<p class='success'>✓ $file exists ($size bytes)</p>";
        } else {
            echo "<p class='error'>✗ $file NOT FOUND</p>";
        }
    }
    
    echo "<h2>2. Checking Database Connection</h2>";
    
    try {
        require_once 'config/database.php';
        $conn = getDatabaseConnection();
        echo "<p class='success'>✓ Database connection successful</p>";
        
        // Check if bot tables exist
        $tables = ['chat_sessions', 'chat_history', 'bot_config'];
        foreach ($tables as $table) {
            $result = $conn->query("SHOW TABLES LIKE '$table'");
            if ($result && $result->num_rows > 0) {
                echo "<p class='success'>✓ Table '$table' exists</p>";
            } else {
                echo "<p class='error'>✗ Table '$table' NOT FOUND - Run create_bot_tables.php</p>";
            }
        }
        
    } catch (Exception $e) {
        echo "<p class='error'>✗ Database error: " . $e->getMessage() . "</p>";
    }
    
    echo "<h2>3. Testing Bot Controller</h2>";
    
    // Try to load CodeIgniter
    define('BASEPATH', __DIR__ . '/system/');
    define('APPPATH', __DIR__ . '/application/');
    define('ENVIRONMENT', 'development');
    
    echo "<p class='info'>Attempting to access bot page...</p>";
    echo "<p><a href='bot' target='_blank'>Click here to test /bot</a></p>";
    echo "<p><a href='bot/chat' target='_blank'>Click here to test /bot/chat</a></p>";
    echo "<p><a href='bot/widget' target='_blank'>Click here to test /bot/widget</a></p>";
    
    echo "<h2>4. Checking PHP Configuration</h2>";
    echo "<p>PHP Version: " . phpversion() . "</p>";
    echo "<p>Display Errors: " . ini_get('display_errors') . "</p>";
    echo "<p>Error Reporting: " . error_reporting() . "</p>";
    
    echo "<h2>5. Checking Apache/Server</h2>";
    echo "<p>Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
    echo "<p>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
    echo "<p>Script Filename: " . $_SERVER['SCRIPT_FILENAME'] . "</p>";
    
    echo "<h2>6. Testing Direct View Load</h2>";
    echo "<p class='info'>Attempting to load chat_interface.php directly...</p>";
    
    if (file_exists('application/views/bot/chat_interface.php')) {
        echo "<iframe src='test_bot_direct.php' width='100%' height='600' style='border:1px solid #ccc; margin-top:10px;'></iframe>";
    }
    
    echo "<h2>7. Recommendations</h2>";
    echo "<ul>";
    echo "<li>If tables are missing, run: <a href='create_bot_tables.php'>create_bot_tables.php</a></li>";
    echo "<li>Check Apache error logs for PHP errors</li>";
    echo "<li>Enable error display in index.php (set ENVIRONMENT to 'development')</li>";
    echo "<li>Clear browser cache and try again</li>";
    echo "</ul>";
    ?>
    
    <h2>8. Quick Actions</h2>
    <p><a href="create_bot_tables.php" style="padding:10px 20px; background:#667eea; color:white; text-decoration:none; border-radius:5px;">Setup Database Tables</a></p>
    <p><a href="bot" style="padding:10px 20px; background:#28a745; color:white; text-decoration:none; border-radius:5px;">Test Bot Page</a></p>
    
</body>
</html>
