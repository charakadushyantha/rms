<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Bot Setup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
        }
        .step {
            background: #f5f5f5;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }
        .success { color: green; }
        .error { color: red; }
        .warning { color: orange; }
        a.button {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin: 5px;
        }
        a.button:hover {
            background: #5568d3;
        }
    </style>
</head>
<body>
    <h1>🤖 AI Bot Setup Test</h1>

    <?php
    // Use central database configuration
    require_once __DIR__ . '/config/database.php';

    try {
        $conn = getDatabaseConnection();
        echo "<div class='step'>";
        echo "<h3>✅ Step 1: Database Connection</h3>";
        echo "<p class='success'>Database connected successfully!</p>";
        echo "<p>Database: " . DB_NAME . "</p>";
        echo "</div>";

        // Check if bot tables exist
        echo "<div class='step'>";
        echo "<h3>Step 2: Bot Tables</h3>";
        
        $tables = [
            'bot_config',
            'chat_sessions',
            'chat_history',
            'bot_intents',
            'knowledge_base'
        ];

        $missing_tables = [];
        foreach ($tables as $table) {
            $result = $conn->query("SHOW TABLES LIKE '$table'");
            if ($result->num_rows > 0) {
                echo "<p class='success'>✓ Table '$table' exists</p>";
            } else {
                echo "<p class='error'>✗ Table '$table' missing</p>";
                $missing_tables[] = $table;
            }
        }

        if (empty($missing_tables)) {
            echo "<p class='success'><strong>All bot tables exist!</strong></p>";
        } else {
            echo "<p class='warning'><strong>Some tables are missing. Please run the setup script.</strong></p>";
            echo "<a href='create_bot_tables.php' class='button'>Run Setup Script</a>";
        }
        echo "</div>";

        // Check bot configuration
        echo "<div class='step'>";
        echo "<h3>Step 3: Bot Configuration</h3>";
        
        $result = $conn->query("SELECT COUNT(*) as count FROM bot_config");
        if ($result) {
            $row = $result->fetch_assoc();
            if ($row['count'] > 0) {
                echo "<p class='success'>✓ Bot configuration found ({$row['count']} settings)</p>";
                
                // Show some configs
                $configs = $conn->query("SELECT config_key, config_value FROM bot_config LIMIT 5");
                echo "<ul>";
                while ($config = $configs->fetch_assoc()) {
                    echo "<li><strong>{$config['config_key']}:</strong> {$config['config_value']}</li>";
                }
                echo "</ul>";
            } else {
                echo "<p class='warning'>⚠ No bot configuration found. Run setup script to add default config.</p>";
            }
        }
        echo "</div>";

        // Check CodeIgniter files
        echo "<div class='step'>";
        echo "<h3>Step 4: CodeIgniter Files</h3>";
        
        $files = [
            'application/controllers/Bot.php' => 'Bot Controller',
            'application/libraries/BotEngine.php' => 'Bot Engine',
            'application/models/Bot_model.php' => 'Bot Model',
            'application/views/bot/chat_interface.php' => 'Chat Interface',
            'application/views/bot/chat_widget.php' => 'Chat Widget'
        ];

        $all_exist = true;
        foreach ($files as $file => $name) {
            if (file_exists($file)) {
                echo "<p class='success'>✓ $name</p>";
            } else {
                echo "<p class='error'>✗ $name missing</p>";
                $all_exist = false;
            }
        }

        if ($all_exist) {
            echo "<p class='success'><strong>All required files exist!</strong></p>";
        }
        echo "</div>";

        // Test links
        echo "<div class='step'>";
        echo "<h3>Step 5: Test the Bot</h3>";
        echo "<p>Try these links to test the bot:</p>";
        echo "<a href='index.php/bot' class='button'>Open Chat Interface</a>";
        echo "<a href='index.php/bot/widget' class='button'>View Chat Widget</a>";
        echo "</div>";

        $conn->close();

    } catch (Exception $e) {
        echo "<div class='step'>";
        echo "<h3 class='error'>❌ Error</h3>";
        echo "<p class='error'>Database connection failed: " . $e->getMessage() . "</p>";
        echo "<p>Please check your database configuration in <code>config/database.php</code></p>";
        echo "</div>";
    }
    ?>

    <div class="step">
        <h3>📚 Next Steps</h3>
        <ol>
            <li>If tables are missing, run <a href="create_bot_tables.php">create_bot_tables.php</a></li>
            <li>Test the chat interface at <code>index.php/bot</code></li>
            <li>Embed the widget on your pages</li>
            <li>Customize bot responses in the database</li>
        </ol>
    </div>

    <div class="step">
        <h3>🔧 Troubleshooting</h3>
        <ul>
            <li><strong>404 Error:</strong> Check your .htaccess and mod_rewrite</li>
            <li><strong>Database Error:</strong> Verify credentials in config/database.php</li>
            <li><strong>Blank Page:</strong> Check PHP error logs</li>
            <li><strong>Widget not showing:</strong> Check jQuery is loaded</li>
        </ul>
    </div>
</body>
</html>
