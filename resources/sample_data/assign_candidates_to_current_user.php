<?php
/**
 * Assign Sample Candidates to Current Logged-in User
 * Updates all sample candidates to be assigned to a specific recruiter
 * 
 * Run this file by accessing: http://localhost/rms/assign_candidates_to_current_user.php?username=YOUR_USERNAME
 */

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'rmsdb';

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>Assign Candidates to Recruiter</h2>";
echo "<style>
    body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
    .success { color: green; }
    .error { color: red; }
    .info { color: blue; }
    .form-box { background: white; padding: 20px; border-radius: 8px; max-width: 500px; margin: 20px 0; }
    input, select { padding: 10px; width: 100%; margin: 10px 0; border: 1px solid #ddd; border-radius: 4px; }
    button { background: #667eea; color: white; padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; }
    button:hover { background: #5568d3; }
</style>";

// Get target username from URL parameter
$target_username = isset($_GET['username']) ? $_GET['username'] : '';

if (empty($target_username)) {
    // Show form to select recruiter
    echo "<div class='form-box'>";
    echo "<h3>Select Recruiter</h3>";
    echo "<p>Choose which recruiter should own the sample candidates:</p>";
    
    // Get all recruiters
    $recruiters_query = "SELECT u_username, u_email FROM users WHERE u_role = 'Recruiter'";
    $recruiters_result = $conn->query($recruiters_query);
    
    if ($recruiters_result->num_rows > 0) {
        echo "<form method='GET'>";
        echo "<select name='username' required>";
        echo "<option value=''>-- Select Recruiter --</option>";
        while ($recruiter = $recruiters_result->fetch_assoc()) {
            echo "<option value='{$recruiter['u_username']}'>{$recruiter['u_username']} ({$recruiter['u_email']})</option>";
        }
        echo "</select>";
        echo "<button type='submit'>Assign Candidates</button>";
        echo "</form>";
    } else {
        echo "<p class='error'>No recruiters found in the system.</p>";
    }
    echo "</div>";
    
} else {
    // Verify the username exists
    $check_user = "SELECT u_username, u_email FROM users WHERE u_username = ? AND u_role = 'Recruiter'";
    $stmt = $conn->prepare($check_user);
    $stmt->bind_param("s", $target_username);
    $stmt->execute();
    $user_result = $stmt->get_result();
    
    if ($user_result->num_rows == 0) {
        echo "<p class='error'>✗ Recruiter '$target_username' not found!</p>";
        echo "<p><a href='?'>← Go back</a></p>";
    } else {
        $user = $user_result->fetch_assoc();
        echo "<p class='info'>Assigning candidates to: <strong>{$user['u_username']}</strong> ({$user['u_email']})</p>";
        
        // Update all candidates to this recruiter
        $update_sql = "UPDATE candidate_details SET cd_rec_username = ? WHERE cd_rec_username != ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ss", $target_username, $target_username);
        
        if ($update_stmt->execute()) {
            $affected_rows = $update_stmt->affected_rows;
            echo "<p class='success'>✓ Successfully assigned $affected_rows candidates to {$target_username}</p>";
            
            // Show summary
            $count_sql = "SELECT COUNT(*) as total FROM candidate_details WHERE cd_rec_username = ?";
            $count_stmt = $conn->prepare($count_sql);
            $count_stmt->bind_param("s", $target_username);
            $count_stmt->execute();
            $count_result = $count_stmt->get_result();
            $count = $count_result->fetch_assoc();
            
            echo "<div class='form-box'>";
            echo "<h3>Summary</h3>";
            echo "<p><strong>Total candidates for {$target_username}:</strong> {$count['total']}</p>";
            
            // Show breakdown by status
            $status_sql = "SELECT cd_status, COUNT(*) as count FROM candidate_details WHERE cd_rec_username = ? GROUP BY cd_status";
            $status_stmt = $conn->prepare($status_sql);
            $status_stmt->bind_param("s", $target_username);
            $status_stmt->execute();
            $status_result = $status_stmt->get_result();
            
            echo "<p><strong>By Status:</strong></p><ul>";
            while ($status = $status_result->fetch_assoc()) {
                echo "<li>{$status['cd_status']}: {$status['count']}</li>";
            }
            echo "</ul>";
            echo "</div>";
            
            echo "<p class='success'><strong>Done! Now log in as '{$target_username}' to see the candidates.</strong></p>";
            
        } else {
            echo "<p class='error'>✗ Error updating candidates: " . $conn->error . "</p>";
        }
        
        echo "<p><a href='index.php'>← Back to Application</a></p>";
    }
}

$conn->close();
?>
