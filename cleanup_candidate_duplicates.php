<?php
/**
 * Cleanup Script for Duplicate Candidates
 * This script removes duplicate entries from the users and candidate_details tables
 * Run this once: http://localhost/rms/cleanup_candidate_duplicates.php
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

echo "<h2>Candidate Duplicate Cleanup Script</h2>";
echo "<p>Database: $database</p>";
echo "<hr>";

// Step 1: Find and display duplicates in users table
echo "<h3>Step 1: Checking for duplicate candidates in users table...</h3>";
$sql = "SELECT u_username, u_email, COUNT(*) as count 
        FROM users 
        WHERE u_role = 'Candidate' 
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
            AND u1.u_role = 'Candidate'";
    if ($conn->query($sql)) {
        echo "<p style='color: green;'>✓ Duplicates removed from users table. Affected rows: " . $conn->affected_rows . "</p>";
    } else {
        echo "<p style='color: red;'>✗ Error: " . $conn->error . "</p>";
    }
} else {
    echo "<p style='color: green;'>✓ No duplicates found in users table.</p>";
}

echo "<hr>";

// Step 2: Find and display duplicates in candidate_details table
echo "<h3>Step 2: Checking for duplicate candidates in candidate_details table...</h3>";
$sql = "SELECT cd_email, cd_name, COUNT(*) as count 
        FROM candidate_details 
        GROUP BY cd_email 
        HAVING count > 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<p style='color: orange;'>Found duplicates in candidate_details table:</p>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Email</th><th>Name</th><th>Count</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['cd_email']}</td><td>{$row['cd_name']}</td><td>{$row['count']}</td></tr>";
    }
    echo "</table>";
    
    // Remove duplicates from candidate_details table, keeping only the first entry
    echo "<p>Removing duplicates from candidate_details table...</p>";
    $sql = "DELETE cd1 FROM candidate_details cd1
            INNER JOIN candidate_details cd2 
            WHERE cd1.cd_id > cd2.cd_id 
            AND cd1.cd_email = cd2.cd_email";
    if ($conn->query($sql)) {
        echo "<p style='color: green;'>✓ Duplicates removed from candidate_details table. Affected rows: " . $conn->affected_rows . "</p>";
    } else {
        echo "<p style='color: red;'>✗ Error: " . $conn->error . "</p>";
    }
} else {
    echo "<p style='color: green;'>✓ No duplicates found in candidate_details table.</p>";
}

echo "<hr>";

// Step 3: Verify cleanup
echo "<h3>Step 3: Verification - Current candidate list:</h3>";
$sql = "SELECT u.u_username, u.u_email, u.u_status, cd.cd_name, cd.cd_phone 
        FROM users u 
        LEFT JOIN candidate_details cd ON u.u_email = cd.cd_email 
        WHERE u.u_role = 'Candidate' 
        GROUP BY u.u_username
        ORDER BY u.u_username";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Username</th><th>Email</th><th>Status</th><th>Name</th><th>Phone</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['u_username']}</td>";
        echo "<td>{$row['u_email']}</td>";
        echo "<td>{$row['u_status']}</td>";
        echo "<td>" . ($row['cd_name'] ?: 'N/A') . "</td>";
        echo "<td>" . ($row['cd_phone'] ?: 'N/A') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<p><strong>Total unique candidates: " . $result->num_rows . "</strong></p>";
} else {
    echo "<p>No candidates found.</p>";
}

$conn->close();

echo "<hr>";
echo "<h3 style='color: green;'>✓ Cleanup Complete!</h3>";
echo "<p><a href='http://localhost/rms/A_dashboard/Acandidate_users_view'>Go to Candidate Users Management Page</a></p>";
?>
