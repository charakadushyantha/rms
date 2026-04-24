<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fix Chatbot Connection Error</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        h1 {
            color: #e74c3c;
            margin-bottom: 20px;
        }
        .error-icon {
            font-size: 60px;
            margin-bottom: 20px;
        }
        .problem {
            background: #fee;
            border-left: 4px solid #e74c3c;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .solution {
            background: #e8f5e9;
            border-left: 4px solid #4caf50;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .step {
            background: #f5f6fa;
            padding: 20px;
            margin: 15px 0;
            border-radius: 10px;
            border-left: 4px solid #667eea;
        }
        .step h3 {
            color: #667eea;
            margin-bottom: 10px;
        }
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 40px;
            border-radius: 30px;
            text-decoration: none;
            font-size: 18px;
            font-weight: 600;
            margin: 10px 5px;
            transition: transform 0.2s;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
        }
        .btn-success {
            background: linear-gradient(135deg, #4caf50, #45a049);
        }
        .code {
            background: #2d2d2d;
            color: #f8f8f2;
            padding: 15px;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            margin: 10px 0;
            overflow-x: auto;
        }
        .checklist {
            list-style: none;
            padding: 0;
        }
        .checklist li {
            padding: 10px;
            margin: 5px 0;
            background: #f5f6fa;
            border-radius: 5px;
        }
        .checklist li:before {
            content: "☐ ";
            font-size: 20px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="error-icon">⚠️</div>
        <h1>Connection Error - Let's Fix It!</h1>
        
        <div class="problem">
            <h3>❌ The Problem:</h3>
            <p>The chatbot is showing "Sorry, connection error. Please try again." because the database tables haven't been created yet.</p>
        </div>

        <div class="solution">
            <h3>✅ The Solution:</h3>
            <p>Run the database setup script to create all required tables. This takes about 30 seconds.</p>
        </div>

        <div class="step">
            <h3>Step 1: Check Database Connection</h3>
            <p>First, let's verify your database is accessible:</p>
            <?php
            require_once __DIR__ . '/config/database.php';
            
            try {
                $conn = getDatabaseConnection();
                echo "<p style='color: green; font-weight: bold;'>✓ Database connection successful!</p>";
                echo "<p>Database: <strong>" . DB_NAME . "</strong></p>";
                
                // Check if bot tables exist
                $tables_needed = ['bot_config', 'chat_sessions', 'chat_history', 'bot_intents', 'knowledge_base'];
                $tables_exist = [];
                $tables_missing = [];
                
                foreach ($tables_needed as $table) {
                    $result = $conn->query("SHOW TABLES LIKE '$table'");
                    if ($result && $result->num_rows > 0) {
                        $tables_exist[] = $table;
                    } else {
                        $tables_missing[] = $table;
                    }
                }
                
                if (empty($tables_missing)) {
                    echo "<p style='color: green; font-weight: bold; margin-top: 15px;'>✓ All bot tables exist!</p>";
                    echo "<p style='color: orange;'>If you're still seeing errors, try clearing your browser cache.</p>";
                } else {
                    echo "<p style='color: red; font-weight: bold; margin-top: 15px;'>✗ Missing " . count($tables_missing) . " tables</p>";
                    echo "<p>Missing: " . implode(', ', $tables_missing) . "</p>";
                }
                
                $conn->close();
            } catch (Exception $e) {
                echo "<p style='color: red; font-weight: bold;'>✗ Database connection failed!</p>";
                echo "<p>Error: " . $e->getMessage() . "</p>";
                echo "<p>Please check your database configuration in <code>config/database.php</code></p>";
            }
            ?>
        </div>

        <div class="step">
            <h3>Step 2: Create Database Tables</h3>
            <p>Click this button to create all required tables:</p>
            <a href="create_bot_tables.php" class="btn btn-success">Create Bot Tables Now</a>
            <p style="margin-top: 15px; font-size: 14px; color: #666;">
                This will create 9 tables: bot_config, chat_sessions, chat_history, bot_intents, bot_entities, knowledge_base, cv_processing_history, bot_analytics, and bot_feedback.
            </p>
        </div>

        <div class="step">
            <h3>Step 3: Test the Bot</h3>
            <p>After creating tables, test the bot:</p>
            <a href="test_bot.php" class="btn">Run Diagnostic Test</a>
            <a href="bot_demo_standalone.html" class="btn">Try Standalone Demo</a>
        </div>

        <div class="step">
            <h3>Step 4: Verify Integration</h3>
            <p>Once tables are created, the chatbot should work on all dashboards:</p>
            <ul class="checklist">
                <li>Login to Admin Dashboard</li>
                <li>Look at bottom right corner</li>
                <li>Click the chat icon</li>
                <li>Type a message</li>
                <li>Bot should respond!</li>
            </ul>
        </div>

        <div class="step">
            <h3>🔧 Alternative: Manual Database Setup</h3>
            <p>If the button doesn't work, run this SQL manually:</p>
            <div class="code">
-- Open phpMyAdmin or MySQL client
-- Select database: <?= DB_NAME ?>

-- Then run the SQL from create_bot_tables.php
            </div>
        </div>

        <div class="step">
            <h3>🐛 Still Having Issues?</h3>
            <p><strong>Check these common problems:</strong></p>
            <ul style="margin-left: 20px; margin-top: 10px;">
                <li>Database credentials incorrect in <code>config/database.php</code></li>
                <li>MySQL server not running</li>
                <li>Database doesn't exist (create it first)</li>
                <li>PHP doesn't have permission to create tables</li>
                <li>Browser cache needs clearing</li>
            </ul>
        </div>

        <div style="margin-top: 30px; padding-top: 20px; border-top: 2px solid #e0e0e0; text-align: center;">
            <p style="color: #666;">Need more help? Check the documentation:</p>
            <a href="BOT_SETUP_GUIDE.md" style="color: #667eea; margin: 0 10px;">Setup Guide</a> •
            <a href="BOT_QUICK_START.md" style="color: #667eea; margin: 0 10px;">Quick Start</a> •
            <a href="BOT_DASHBOARD_INTEGRATION.md" style="color: #667eea; margin: 0 10px;">Integration Guide</a>
        </div>
    </div>
</body>
</html>
