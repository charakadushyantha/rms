<?php
/**
 * Quick Chatbot Setup Script
 * Run this file once to set up the chatbot: http://localhost/rms/setup_chatbot.php
 */

// Database configuration
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'rmsdb';

// Connect to database
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

echo "<h1>🤖 AI Chatbot Setup</h1>";
echo "<hr>";

// Read SQL file
$sql_file = 'Database/chatbot_schema.sql';
if (!file_exists($sql_file)) {
    die("❌ SQL file not found: $sql_file");
}

$sql = file_get_contents($sql_file);

// Split into individual queries
$queries = array_filter(array_map('trim', explode(';', $sql)));

$success_count = 0;
$error_count = 0;

foreach ($queries as $query) {
    if (empty($query)) continue;
    
    if ($conn->query($query)) {
        $success_count++;
        
        // Extract table name
        if (preg_match('/CREATE TABLE.*?`(\w+)`/i', $query, $matches)) {
            echo "✅ Created table: <strong>{$matches[1]}</strong><br>";
        }
    } else {
        $error_count++;
        echo "⚠️ Error: " . $conn->error . "<br>";
    }
}

echo "<hr>";
echo "<h2>Setup Complete!</h2>";
echo "<p>✅ Successfully created $success_count table(s)</p>";

if ($error_count > 0) {
    echo "<p>⚠️ $error_count error(s) occurred (might be tables already exist)</p>";
}

// Check if tables exist
echo "<h3>Verification:</h3>";
$tables = ['chat_sessions', 'chat_messages', 'chat_feedback'];
foreach ($tables as $table) {
    $result = $conn->query("SHOW TABLES LIKE '$table'");
    if ($result->num_rows > 0) {
        echo "✅ Table <strong>$table</strong> exists<br>";
    } else {
        echo "❌ Table <strong>$table</strong> NOT found<br>";
    }
}

echo "<hr>";
echo "<h3>Next Steps:</h3>";
echo "<ol>";
echo "<li>✅ Database tables created</li>";
echo "<li>⚠️ <strong>Add your OpenAI API key</strong> in <code>application/config/chatbot.php</code></li>";
echo "<li>🎯 Visit your login page: <a href='login'>http://localhost/rms/login</a></li>";
echo "<li>👀 Look for the blue chat button in the bottom-right corner</li>";
echo "<li>🧪 Or test here: <a href='chatbot_test'>http://localhost/rms/chatbot_test</a></li>";
echo "</ol>";

echo "<hr>";
echo "<h3>⚠️ Important:</h3>";
echo "<p>Get your OpenAI API key from: <a href='https://platform.openai.com/api-keys' target='_blank'>https://platform.openai.com/api-keys</a></p>";
echo "<p>Then edit: <code>application/config/chatbot.php</code> and replace <code>YOUR_API_KEY_HERE</code> with your actual key.</p>";

echo "<hr>";
echo "<p><strong>You can delete this file after setup is complete.</strong></p>";

$conn->close();
?>

<style>
    body {
        font-family: Arial, sans-serif;
        max-width: 800px;
        margin: 50px auto;
        padding: 20px;
        background: #f5f5f5;
    }
    h1 { color: #333; }
    code {
        background: #f4f4f4;
        padding: 2px 6px;
        border-radius: 3px;
        font-family: monospace;
    }
    a {
        color: #007bff;
        text-decoration: none;
    }
    a:hover {
        text-decoration: underline;
    }
</style>
