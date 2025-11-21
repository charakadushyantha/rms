<!DOCTYPE html>
<html>
<head>
    <title>Simple Module Test</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .success { background: #d1fae5; border: 2px solid #10b981; padding: 20px; margin: 20px 0; border-radius: 8px; }
        .error { background: #fee2e2; border: 2px solid #ef4444; padding: 20px; margin: 20px 0; border-radius: 8px; }
        .module-card { border: 1px solid #ddd; padding: 15px; margin: 10px 0; border-radius: 8px; }
        .section-header { background: #667eea; color: white; padding: 10px; margin: 20px 0 10px 0; border-radius: 6px; }
    </style>
</head>
<body>
    <h1>🔍 Simple Module Test</h1>
    <p>This page directly queries the database and shows what SHOULD appear in Module Manager.</p>

    <?php
    // Database connection
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'rmsdb';

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        echo "<div class='error'>";
        echo "<h3>❌ Database Connection Failed</h3>";
        echo "<p>Error: " . $conn->connect_error . "</p>";
        echo "</div>";
        exit;
    }

    echo "<div class='success'>";
    echo "<h3>✅ Database Connected</h3>";
    echo "</div>";

    // Query modules
    $query = "SELECT * FROM module_visibility ORDER BY section ASC, module_name ASC";
    $result = $conn->query($query);

    if (!$result) {
        echo "<div class='error'>";
        echo "<h3>❌ Query Failed</h3>";
        echo "<p>Error: " . $conn->error . "</p>";
        echo "</div>";
        exit;
    }

    $total = $result->num_rows;
    
    echo "<div class='success'>";
    echo "<h3>✅ Query Successful</h3>";
    echo "<p><strong>Total modules found:</strong> $total</p>";
    echo "</div>";

    if ($total == 0) {
        echo "<div class='error'>";
        echo "<h3>❌ No Modules Found</h3>";
        echo "<p>Run update_module_visibility_complete.php to add modules.</p>";
        echo "</div>";
        exit;
    }

    // Group by section
    $modules_by_section = array();
    while ($row = $result->fetch_assoc()) {
        $section = $row['section'] ? $row['section'] : 'Other';
        $modules_by_section[$section][] = $row;
    }

    echo "<h2>📋 Modules by Section</h2>";
    echo "<p>This is what Module Manager SHOULD show:</p>";

    foreach ($modules_by_section as $section => $modules) {
        echo "<div class='section-header'>";
        echo "<strong>$section</strong> (" . count($modules) . " modules)";
        echo "</div>";
        
        foreach ($modules as $module) {
            $visible = $module['is_visible'] ? '✅ Visible' : '❌ Hidden';
            echo "<div class='module-card'>";
            echo "<strong>" . $module['module_name'] . "</strong><br>";
            echo "<small>Key: " . $module['module_key'] . " | Status: $visible</small>";
            echo "</div>";
        }
    }

    $conn->close();
    ?>

    <hr style="margin: 40px 0;">
    
    <h2>🎯 What This Means</h2>
    
    <div class="success">
        <h3>✅ Database Has <?= $total ?> Modules</h3>
        <p>The database is correct. The problem is that Module Manager is not loading them.</p>
    </div>

    <h3>📋 Next Steps:</h3>
    <ol>
        <li><strong>Restart Apache</strong> in XAMPP Control Panel</li>
        <li><strong>Open Module Manager:</strong> <a href="Setup/module_manager">Setup/module_manager</a></li>
        <li><strong>Look for the BIG colored debug message</strong> at the top</li>
        <li><strong>Take a screenshot</strong> of what you see and share it</li>
    </ol>

    <h3>🔍 What to Look For:</h3>
    <ul>
        <li>✅ <strong>Green message:</strong> "Found <?= $total ?> modules" = Working!</li>
        <li>⚠️ <strong>Orange message:</strong> "system_modules is EMPTY" = Database issue</li>
        <li>❌ <strong>Red message:</strong> "system_modules NOT SET" = Controller issue</li>
    </ul>

    <hr style="margin: 40px 0;">
    
    <p>
        <a href="clear_cache_and_test.php" style="display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 6px;">Clear Cache First</a>
        <a href="Setup/module_manager" style="display: inline-block; padding: 10px 20px; background: #10b981; color: white; text-decoration: none; border-radius: 6px; margin-left: 10px;">Open Module Manager</a>
        <a href="index.php" style="display: inline-block; padding: 10px 20px; background: #6b7280; color: white; text-decoration: none; border-radius: 6px; margin-left: 10px;">Back to Home</a>
    </p>
</body>
</html>
