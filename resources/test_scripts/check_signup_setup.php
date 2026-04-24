<?php
/**
 * Check Signup Controller Setup Status
 * Run: http://localhost/rms/check_signup_setup.php
 */

// Load CodeIgniter database configuration
require_once('application/config/database.php');

// Get database configuration
$db_config = $db['default'];
$servername = $db_config['hostname'];
$username = $db_config['username'];
$password = $db_config['password'];
$dbname = $db_config['database'];

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    echo "<h1>🔍 Signup Controller Setup Status</h1>";
    echo "<style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
        .success { color: #28a745; background: #d4edda; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .error { color: #dc3545; background: #f8d7da; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .warning { color: #856404; background: #fff3cd; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .info { color: #0c5460; background: #d1ecf1; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .btn { padding: 10px 20px; margin: 5px; text-decoration: none; border-radius: 5px; display: inline-block; }
        .btn-primary { background: #007bff; color: white; }
        .btn-success { background: #28a745; color: white; }
        .btn-warning { background: #ffc107; color: black; }
    </style>";

    $setup_complete = true;
    $issues = array();

    // 1. Check if signup_settings table exists
    $result = $conn->query("SHOW TABLES LIKE 'signup_settings'");
    if ($result->num_rows > 0) {
        echo "<p class='success'>✅ Table 'signup_settings' exists</p>";
        
        // Check if it has data
        $data_check = $conn->query("SELECT COUNT(*) as count FROM signup_settings");
        $row = $data_check->fetch_assoc();
        if ($row['count'] > 0) {
            echo "<p class='success'>✅ Signup settings configured</p>";
        } else {
            echo "<p class='warning'>⚠️ Signup settings table is empty</p>";
            $issues[] = "No signup settings configured";
        }
    } else {
        echo "<p class='error'>❌ Table 'signup_settings' does not exist</p>";
        $setup_complete = false;
        $issues[] = "Missing signup_settings table";
    }

    // 2. Check if signup_audit_log table exists
    $result = $conn->query("SHOW TABLES LIKE 'signup_audit_log'");
    if ($result->num_rows > 0) {
        echo "<p class='success'>✅ Table 'signup_audit_log' exists</p>";
    } else {
        echo "<p class='error'>❌ Table 'signup_audit_log' does not exist</p>";
        $setup_complete = false;
        $issues[] = "Missing signup_audit_log table";
    }

    // 3. Check if users table has additional columns
    $columns_to_check = array('created_at', 'created_by', 'approved_at', 'approved_by', 'rejected_at', 'rejected_by', 'rejection_reason');
    $missing_columns = array();
    
    foreach ($columns_to_check as $column) {
        $result = $conn->query("SHOW COLUMNS FROM users LIKE '$column'");
        if ($result->num_rows > 0) {
            echo "<p class='success'>✅ Column 'users.$column' exists</p>";
        } else {
            echo "<p class='warning'>⚠️ Column 'users.$column' missing (optional)</p>";
            $missing_columns[] = $column;
        }
    }

    // 4. Check if controller files exist
    $files_to_check = array(
        'application/controllers/Signup_controller.php' => 'Signup Controller',
        'application/models/Signup_controller_model.php' => 'Signup Controller Model',
        'application/views/admin/signup_controller_dashboard.php' => 'Admin Dashboard View'
    );

    foreach ($files_to_check as $file => $description) {
        if (file_exists($file)) {
            echo "<p class='success'>✅ $description file exists</p>";
        } else {
            echo "<p class='error'>❌ $description file missing</p>";
            $setup_complete = false;
            $issues[] = "Missing $description file";
        }
    }

    echo "<hr>";

    if ($setup_complete && empty($issues)) {
        echo "<h3 class='success'>🎉 Setup Complete!</h3>";
        echo "<p class='info'>Your Signup Controller is ready to use.</p>";
        echo "<a href='index.php/Signup_controller' class='btn btn-success'>Access Signup Controller</a>";
        echo "<a href='index.php/A_dashboard' class='btn btn-primary'>Go to Admin Dashboard</a>";
    } else {
        echo "<h3 class='error'>⚠️ Setup Required</h3>";
        echo "<p class='warning'>The following issues need to be resolved:</p>";
        echo "<ul>";
        foreach ($issues as $issue) {
            echo "<li>$issue</li>";
        }
        echo "</ul>";
        
        echo "<h4>🔧 Fix Issues:</h4>";
        echo "<a href='create_signup_settings_table.php' class='btn btn-warning'>Run Database Setup</a>";
        echo "<a href='check_signup_setup.php' class='btn btn-primary'>Recheck Status</a>";
    }

    if (!empty($missing_columns)) {
        echo "<div class='info'>";
        echo "<h4>ℹ️ Optional Enhancements:</h4>";
        echo "<p>The following columns are missing but not required for basic functionality:</p>";
        echo "<ul>";
        foreach ($missing_columns as $column) {
            echo "<li>users.$column</li>";
        }
        echo "</ul>";
        echo "<p>Run the database setup script to add these columns for enhanced tracking.</p>";
        echo "</div>";
    }

} catch (Exception $e) {
    echo "<p class='error'>❌ Error: " . $e->getMessage() . "</p>";
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?>