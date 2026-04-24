<!DOCTYPE html>
<html>
<head>
    <title>Interview System Setup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        h1 { color: #667eea; }
        .success { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
        .step {
            background: #f5f6fa;
            padding: 20px;
            margin: 20px 0;
            border-radius: 10px;
            border-left: 4px solid #667eea;
        }
        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin: 5px;
        }
        .code {
            background: #2d2d2d;
            color: #f8f8f2;
            padding: 15px;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            overflow-x: auto;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎯 Interview System Setup</h1>
        <p>Complete setup for the Interview Management System</p>

        <?php
        require_once __DIR__ . '/config/database.php';

        try {
            $conn = getDatabaseConnection();
            
            // Check if tables exist
            echo "<div class='step'>";
            echo "<h3>Step 1: Database Tables</h3>";
            
            $tables = ['interview_flows', 'interviews', 'interview_responses', 'interview_analytics'];
            $all_exist = true;
            
            foreach ($tables as $table) {
                $result = $conn->query("SHOW TABLES LIKE '$table'");
                if ($result && $result->num_rows > 0) {
                    echo "<p class='success'>✓ Table '$table' exists</p>";
                } else {
                    echo "<p class='error'>✗ Table '$table' missing</p>";
                    $all_exist = false;
                }
            }
            
            if (!$all_exist) {
                echo "<p><a href='create_interview_tables.php' class='btn'>Create Tables Now</a></p>";
            } else {
                echo "<p class='success'><strong>All tables exist!</strong></p>";
            }
            echo "</div>";
            
            // Check controllers
            echo "<div class='step'>";
            echo "<h3>Step 2: Controllers & Models</h3>";
            
            $files = [
                'application/controllers/Interview.php' => 'Interview Controller',
                'application/controllers/Api/Interview_api.php' => 'Interview API',
                'application/models/Interview_model.php' => 'Interview Model',
                'application/models/Interview_flow_model.php' => 'Interview Flow Model'
            ];
            
            $all_files_exist = true;
            foreach ($files as $file => $name) {
                if (file_exists($file)) {
                    echo "<p class='success'>✓ $name</p>";
                } else {
                    echo "<p class='error'>✗ $name missing</p>";
                    $all_files_exist = false;
                }
            }
            
            if ($all_files_exist) {
                echo "<p class='success'><strong>All files exist!</strong></p>";
            }
            echo "</div>";
            
            // Menu integration
            echo "<div class='step'>";
            echo "<h3>Step 3: Add to Navigation Menu</h3>";
            echo "<p>Add this code to your admin sidebar menu:</p>";
            echo "<div class='code'>";
            echo htmlspecialchars('<li>
    <a href="<?= base_url(\'interview\') ?>">
        <i class="fas fa-video"></i>
        <span>Interviews</span>
    </a>
</li>');
            echo "</div>";
            echo "<p><strong>Location:</strong> application/views/templates/admin_header.php (in the sidebar menu section)</p>";
            echo "</div>";
            
            // Access points
            echo "<div class='step'>";
            echo "<h3>Step 4: Access the System</h3>";
            echo "<p><strong>Web Interface:</strong></p>";
            echo "<p><a href='index.php/interview' class='btn'>Open Interview Dashboard</a></p>";
            
            echo "<p style='margin-top: 20px;'><strong>API Testing:</strong></p>";
            echo "<p><a href='test_interview_api.php' class='btn'>Test API Endpoints</a></p>";
            echo "</div>";
            
            // Documentation
            echo "<div class='step'>";
            echo "<h3>Step 5: Documentation</h3>";
            echo "<ul>";
            echo "<li><a href='INTERVIEW_INTEGRATION_COMPLETE.md'>Integration Guide</a></li>";
            echo "<li><a href='INTERVIEW_API_GUIDE.md'>API Documentation</a></li>";
            echo "<li><a href='INTERVIEW_API_QUICK_START.txt'>Quick Start Guide</a></li>";
            echo "</ul>";
            echo "</div>";
            
            $conn->close();
            
        } catch (Exception $e) {
            echo "<p class='error'>Error: " . $e->getMessage() . "</p>";
        }
        ?>

        <div class="step">
            <h3>✅ Setup Complete!</h3>
            <p>Your Interview Management System is ready to use.</p>
            <p><strong>Next Steps:</strong></p>
            <ol>
                <li>Add menu item to your sidebar</li>
                <li>Access the interview dashboard</li>
                <li>Create your first interview flow</li>
                <li>Generate interview links for candidates</li>
            </ol>
        </div>
    </div>
</body>
</html>
