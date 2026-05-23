<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quick Recruiter Check</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .box {
            background: white;
            padding: 20px;
            margin: 15px 0;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .success { color: #28a745; font-weight: bold; }
        .error { color: #dc3545; font-weight: bold; }
        .warning { color: #ffc107; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background: #f8f9fa; }
        code { background: #f8f9fa; padding: 2px 6px; border-radius: 3px; }
        .btn { display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 5px; margin: 5px 5px 5px 0; }
    </style>
</head>
<body>
    <h1>🔍 Quick Recruiter System Check</h1>
    
    <?php
    // Database configuration
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'cmsadver_rmsdb'; // Your database name
    
    // Connect to database
    $conn = new mysqli($host, $username, $password, $database);
    
    if ($conn->connect_error) {
        echo '<div class="box"><p class="error">✗ Database connection failed: ' . $conn->connect_error . '</p></div>';
        exit;
    }
    
    echo '<div class="box"><p class="success">✓ Database connected successfully</p></div>';
    
    // Check if users table exists
    $result = $conn->query("SHOW TABLES LIKE 'users'");
    if ($result->num_rows > 0) {
        echo '<div class="box"><p class="success">✓ <code>users</code> table exists</p></div>';
        
        // Check table structure
        echo '<div class="box">';
        echo '<h3>Users Table Structure</h3>';
        $columns = $conn->query("SHOW COLUMNS FROM users");
        
        echo '<table>';
        echo '<thead><tr><th>Column</th><th>Type</th><th>Null</th><th>Default</th></tr></thead>';
        echo '<tbody>';
        
        $has_status = false;
        $has_created_at = false;
        
        while ($col = $columns->fetch_assoc()) {
            echo '<tr>';
            echo '<td><code>' . $col['Field'] . '</code></td>';
            echo '<td>' . $col['Type'] . '</td>';
            echo '<td>' . $col['Null'] . '</td>';
            echo '<td>' . ($col['Default'] ?? 'NULL') . '</td>';
            echo '</tr>';
            
            if ($col['Field'] == 'u_status') $has_status = true;
            if ($col['Field'] == 'u_created_at') $has_created_at = true;
        }
        
        echo '</tbody></table>';
        
        // Check for missing columns
        if (!$has_status) {
            echo '<p class="warning">⚠ Missing column: <code>u_status</code></p>';
            echo '<p>Run this SQL to add it:</p>';
            echo '<code>ALTER TABLE users ADD COLUMN u_status TINYINT(1) NOT NULL DEFAULT 0;</code>';
        } else {
            echo '<p class="success">✓ <code>u_status</code> column exists</p>';
        }
        
        if (!$has_created_at) {
            echo '<p class="warning">⚠ Missing column: <code>u_created_at</code></p>';
            echo '<p>Run this SQL to add it:</p>';
            echo '<code>ALTER TABLE users ADD COLUMN u_created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP;</code>';
        } else {
            echo '<p class="success">✓ <code>u_created_at</code> column exists</p>';
        }
        
        echo '</div>';
        
        // Check for recruiters
        echo '<div class="box">';
        echo '<h3>Existing Recruiters</h3>';
        
        $recruiters = $conn->query("SELECT * FROM users WHERE u_role = 'Recruiter' ORDER BY u_id DESC");
        
        if ($recruiters->num_rows > 0) {
            echo '<p class="success">Found ' . $recruiters->num_rows . ' recruiter(s)</p>';
            echo '<table>';
            echo '<thead><tr><th>ID</th><th>Username</th><th>Email</th><th>Status</th><th>Created</th></tr></thead>';
            echo '<tbody>';
            
            while ($rec = $recruiters->fetch_assoc()) {
                $status = isset($rec['u_status']) ? ($rec['u_status'] == 1 ? '<span class="success">Active</span>' : '<span class="warning">Pending</span>') : 'N/A';
                $created = isset($rec['u_created_at']) ? $rec['u_created_at'] : 'N/A';
                
                echo '<tr>';
                echo '<td>' . $rec['u_id'] . '</td>';
                echo '<td>' . $rec['u_username'] . '</td>';
                echo '<td>' . $rec['u_email'] . '</td>';
                echo '<td>' . $status . '</td>';
                echo '<td>' . $created . '</td>';
                echo '</tr>';
            }
            
            echo '</tbody></table>';
        } else {
            echo '<p class="warning">⚠ No recruiters found in database</p>';
            echo '<p>You need to add recruiters first.</p>';
        }
        
        echo '</div>';
        
    } else {
        echo '<div class="box"><p class="error">✗ <code>users</code> table does not exist</p></div>';
    }
    
    // Check if required files exist
    echo '<div class="box">';
    echo '<h3>Required Files Check</h3>';
    
    $files = [
        'Controller' => 'application/controllers/Recruiter_management.php',
        'Model' => 'application/models/Recruiter_model.php',
        'View' => 'application/views/Admin_dashboard_view/Arecruiter.php'
    ];
    
    foreach ($files as $name => $path) {
        if (file_exists($path)) {
            echo '<p class="success">✓ ' . $name . ': <code>' . $path . '</code></p>';
        } else {
            echo '<p class="error">✗ ' . $name . ' NOT FOUND: <code>' . $path . '</code></p>';
        }
    }
    
    echo '</div>';
    
    $conn->close();
    ?>
    
    <div class="box">
        <h3>Next Steps</h3>
        <a href="http://localhost/rms/debug_recruiters" class="btn">Run Full Debug Tool</a>
        <a href="http://localhost/rms/test_recruiter_ajax.html" class="btn">Test AJAX Endpoints</a>
        <a href="http://localhost/rms/A_dashboard/Arecruiter_view" class="btn">Go to Recruiters Page</a>
    </div>
    
    <div class="box">
        <h3>Browser Console Check</h3>
        <p>After visiting the Recruiters page, press <strong>F12</strong> and check the Console tab for JavaScript errors.</p>
        <p>Common issues:</p>
        <ul>
            <li>jQuery not loaded</li>
            <li>DataTables not loaded</li>
            <li>AJAX URL incorrect</li>
            <li>Authentication failed</li>
        </ul>
    </div>
</body>
</html>
