<?php
/**
 * Insert Sample Talent Pools
 * Run: http://localhost/rms/insert_sample_pools.php
 */

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'rmsdb';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>Creating Sample Talent Pools</h2>";
echo "<style>
    body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
    .success { color: green; padding: 10px; background: #d4edda; margin: 10px 0; border-radius: 5px; }
</style>";

// Get admin username
$admin_query = $conn->query("SELECT u_username FROM users LIMIT 1");
$admin = $admin_query && $admin_query->num_rows > 0 ? $admin_query->fetch_assoc()['u_username'] : 'admin';

$sample_pools = [
    [
        'name' => 'Senior Developers',
        'description' => 'Experienced developers with 5+ years of experience',
        'type' => 'Static'
    ],
    [
        'name' => 'Data Science Experts',
        'description' => 'Data scientists and ML engineers',
        'type' => 'Static'
    ],
    [
        'name' => 'Product Management',
        'description' => 'Product managers and product owners',
        'type' => 'Static'
    ],
    [
        'name' => 'UX/UI Designers',
        'description' => 'User experience and interface designers',
        'type' => 'Static'
    ]
];

$inserted = 0;

foreach ($sample_pools as $pool) {
    $sql = "INSERT INTO talent_pools (pool_name, description, pool_type, created_by, is_active) 
            VALUES (?, ?, ?, ?, 1)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssss', $pool['name'], $pool['description'], $pool['type'], $admin);
    
    if ($stmt->execute()) {
        $pool_id = $stmt->insert_id;
        echo "<div class='success'>✓ Created pool: {$pool['name']}</div>";
        $inserted++;
        
        // Add some candidates to pools based on their roles
        if ($pool['name'] == 'Senior Developers') {
            $candidates = $conn->query("SELECT candidate_id FROM sourced_candidates WHERE current_title LIKE '%Developer%' OR current_title LIKE '%Engineer%'");
        } elseif ($pool['name'] == 'Data Science Experts') {
            $candidates = $conn->query("SELECT candidate_id FROM sourced_candidates WHERE current_title LIKE '%Data%' OR current_title LIKE '%Scientist%'");
        } elseif ($pool['name'] == 'Product Management') {
            $candidates = $conn->query("SELECT candidate_id FROM sourced_candidates WHERE current_title LIKE '%Product%' OR current_title LIKE '%Manager%'");
        } elseif ($pool['name'] == 'UX/UI Designers') {
            $candidates = $conn->query("SELECT candidate_id FROM sourced_candidates WHERE current_title LIKE '%Designer%' OR current_title LIKE '%UX%'");
        }
        
        if (isset($candidates) && $candidates->num_rows > 0) {
            while ($candidate = $candidates->fetch_assoc()) {
                $member_sql = "INSERT INTO talent_pool_members (pool_id, candidate_id, added_by) VALUES (?, ?, ?)";
                $member_stmt = $conn->prepare($member_sql);
                $member_stmt->bind_param('iis', $pool_id, $candidate['candidate_id'], $admin);
                $member_stmt->execute();
            }
        }
    }
}

echo "<hr>";
echo "<h3>Summary:</h3>";
echo "<div class='success'>";
echo "<p><strong>Pools Created:</strong> $inserted</p>";
echo "<p><strong>Status:</strong> Sample pools created and populated!</p>";
echo "</div>";

echo "<h3>Next Steps:</h3>";
echo "<p><a href='http://localhost/rms/Candidate_sourcing/pools' style='display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 5px;'>View Talent Pools</a></p>";

$conn->close();
?>
