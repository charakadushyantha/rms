<?php
/**
 * Cleanup Script for Duplicate Interviewers
 * This script removes duplicate entries from the users and profile_info tables
 * Run this once: http://localhost/rms/cleanup_interviewer_duplicates.php
 */

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'cmsadver_rmsdb';

// Connect to database
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>Interviewer Duplicate Cleanup Script</h2>";
echo "<p>Database: $database</p>";
echo "<hr>";

// Step 1: Find and display duplicates in users table
echo "<h3>Step 1: Checking for duplicate interviewers in users table...</h3>";
$sql = "SELECT u_username, u_email, COUNT(*) as count 
        FROM users 
        WHERE u_role = 'Interviewer' 
        GROUP BY u_username, u_email 
        HAVING count > 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<p style='color: orange;'>Found duplicates in users table:</p>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Username</th><th>Email</th><th>Count</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['u_username']}</td><td>{$row['u_email']}</td><td>{$row['count']}</td></tr>";
    }
    echo "</table>";
    
    // Remove duplicates from users table, keeping only the first entry
    echo "<p>Removing duplicates from users table...</p>";
    $sql = "DELETE u1 FROM users u1
            INNER JOIN users u2 
            WHERE u1.u_id > u2.u_id 
            AND u1.u_username = u2.u_username 
            AND u1.u_role = 'Interviewer'";
    if ($conn->query($sql)) {
        echo "<p style='color: green;'>✓ Duplicates removed from users table. Affected rows: " . $conn->affected_rows . "</p>";
    } else {
        echo "<p style='color: red;'>✗ Error: " . $conn->error . "</p>";
    }
} else {
    echo "<p style='color: green;'>✓ No duplicates found in users table.</p>";
}

echo "<hr>";

// Step 2: Find and display duplicates in profile_info table
echo "<h3>Step 2: Checking for duplicate interviewers in profile_info table...</h3>";
$sql = "SELECT pi_username, pi_email, COUNT(*) as count 
        FROM profile_info 
        WHERE pi_role = 'Interviewer' 
        GROUP BY pi_username 
        HAVING count > 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<p style='color: orange;'>Found duplicates in profile_info table:</p>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Username</th><th>Email</th><th>Count</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['pi_username']}</td><td>{$row['pi_email']}</td><td>{$row['count']}</td></tr>";
    }
    echo "</table>";
    
    // Remove duplicates from profile_info table, keeping only the first entry
    echo "<p>Removing duplicates from profile_info table...</p>";
    $sql = "DELETE p1 FROM profile_info p1
            INNER JOIN profile_info p2 
            WHERE p1.pi_id > p2.pi_id 
            AND p1.pi_username = p2.pi_username 
            AND p1.pi_role = 'Interviewer'";
    if ($conn->query($sql)) {
        echo "<p style='color: green;'>✓ Duplicates removed from profile_info table. Affected rows: " . $conn->affected_rows . "</p>";
    } else {
        echo "<p style='color: red;'>✗ Error: " . $conn->error . "</p>";
    }
} else {
    echo "<p style='color: green;'>✓ No duplicates found in profile_info table.</p>";
}

echo "<hr>";

// Step 3: Verify cleanup
echo "<h3>Step 3: Verification - Current interviewer list:</h3>";
$sql = "SELECT u.u_username, u.u_email, u.u_status, p.pi_phone, p.pi_gender 
        FROM users u 
        LEFT JOIN profile_info p ON u.u_username = p.pi_username 
        WHERE u.u_role = 'Interviewer' 
        ORDER BY u.u_username";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Username</th><th>Email</th><th>Status</th><th>Phone</th><th>Gender</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['u_username']}</td>";
        echo "<td>{$row['u_email']}</td>";
        echo "<td>{$row['u_status']}</td>";
        echo "<td>" . ($row['pi_phone'] ?: 'N/A') . "</td>";
        echo "<td>" . ($row['pi_gender'] ?: 'N/A') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<p><strong>Total unique interviewers: " . $result->num_rows . "</strong></p>";
} else {
    echo "<p>No interviewers found.</p>";
}

$conn->close();

echo "<hr>";
echo "<h3 style='color: green;'>✓ Cleanup Complete!</h3>";
echo "<p><a href='http://localhost/rms/A_dashboard/Ainterviewer_view'>Go to Interviewer Management Page</a></p>";
?>
