<?php
/**
 * Insert Sample Referral Data
 * Run this file: http://localhost/rms/insert_sample_referral_data.php
 */

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'rmsdb';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>Inserting Sample Referral Data</h2>";
echo "<style>
    body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
    .success { color: green; padding: 10px; background: #d4edda; margin: 10px 0; border-radius: 5px; }
    .info { color: #0c5460; padding: 10px; background: #d1ecf1; margin: 10px 0; border-radius: 5px; }
</style>";

// Get admin user ID
$admin_query = $conn->query("SELECT u_id, u_username, u_name, u_email FROM users LIMIT 1");
if ($admin_query && $admin_query->num_rows > 0) {
    $admin = $admin_query->fetch_assoc();
    $admin_id = $admin['u_id'];
    $admin_name = $admin['u_name'] ?? $admin['u_username'];
    $admin_email = $admin['u_email'] ?? 'admin@company.com';
    $admin_username = $admin['u_username'];
} else {
    // Fallback if no users found
    $admin_id = 1;
    $admin_name = 'Admin User';
    $admin_email = 'admin@company.com';
    $admin_username = 'admin';
}

// Sample referrals
$sample_referrals = [
    [
        'candidate_name' => 'John Smith',
        'candidate_email' => 'john.smith@email.com',
        'candidate_phone' => '555-0101',
        'position_name' => 'Senior Software Engineer',
        'status' => 'Hired',
        'bonus_status' => 'Paid',
        'bonus_amount' => 2000,
        'days_ago' => 120
    ],
    [
        'candidate_name' => 'Sarah Johnson',
        'candidate_email' => 'sarah.j@email.com',
        'candidate_phone' => '555-0102',
        'position_name' => 'Marketing Manager',
        'status' => 'Interviewing',
        'bonus_status' => 'Pending',
        'bonus_amount' => 1000,
        'days_ago' => 15
    ],
    [
        'candidate_name' => 'Michael Chen',
        'candidate_email' => 'mchen@email.com',
        'candidate_phone' => '555-0103',
        'position_name' => 'Data Analyst',
        'status' => 'Screening',
        'bonus_status' => 'Pending',
        'bonus_amount' => 1000,
        'days_ago' => 7
    ],
    [
        'candidate_name' => 'Emily Davis',
        'candidate_email' => 'emily.davis@email.com',
        'candidate_phone' => '555-0104',
        'position_name' => 'UX Designer',
        'status' => 'Hired',
        'bonus_status' => 'Approved',
        'bonus_amount' => 1500,
        'days_ago' => 45
    ],
    [
        'candidate_name' => 'Robert Wilson',
        'candidate_email' => 'rwilson@email.com',
        'candidate_phone' => '555-0105',
        'position_name' => 'DevOps Engineer',
        'status' => 'Submitted',
        'bonus_status' => 'Pending',
        'bonus_amount' => 2000,
        'days_ago' => 3
    ],
    [
        'candidate_name' => 'Lisa Anderson',
        'candidate_email' => 'l.anderson@email.com',
        'candidate_phone' => '555-0106',
        'position_name' => 'Product Manager',
        'status' => 'Interviewing',
        'bonus_status' => 'Pending',
        'bonus_amount' => 2000,
        'days_ago' => 20
    ],
    [
        'candidate_name' => 'David Martinez',
        'candidate_email' => 'dmartinez@email.com',
        'candidate_phone' => '555-0107',
        'position_name' => 'Sales Representative',
        'status' => 'Rejected',
        'bonus_status' => 'N/A',
        'bonus_amount' => 0,
        'days_ago' => 30
    ],
    [
        'candidate_name' => 'Jennifer Taylor',
        'candidate_email' => 'jtaylor@email.com',
        'candidate_phone' => '555-0108',
        'position_name' => 'HR Specialist',
        'status' => 'Hired',
        'bonus_status' => 'Paid',
        'bonus_amount' => 1000,
        'days_ago' => 150
    ]
];

$inserted = 0;

foreach ($sample_referrals as $ref) {
    $referral_date = date('Y-m-d', strtotime("-{$ref['days_ago']} days"));
    $hired_date = $ref['status'] == 'Hired' ? date('Y-m-d', strtotime("-" . ($ref['days_ago'] - 10) . " days")) : null;
    $bonus_paid_date = $ref['bonus_status'] == 'Paid' ? date('Y-m-d', strtotime("-" . ($ref['days_ago'] - 100) . " days")) : null;
    
    $sql = "INSERT INTO referrals (
        referrer_id, referrer_name, referrer_email,
        candidate_name, candidate_email, candidate_phone,
        position_name, referral_date, referral_status,
        bonus_amount, bonus_status, bonus_paid_date,
        hired_date, created_by, created_at
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $created_at = date('Y-m-d H:i:s', strtotime("-{$ref['days_ago']} days"));
    
    $stmt->bind_param(
        'issssssssdsssss',
        $admin_id,
        $admin_name,
        $admin_email,
        $ref['candidate_name'],
        $ref['candidate_email'],
        $ref['candidate_phone'],
        $ref['position_name'],
        $referral_date,
        $ref['status'],
        $ref['bonus_amount'],
        $ref['bonus_status'],
        $bonus_paid_date,
        $hired_date,
        $admin_username,
        $created_at
    );
    
    if ($stmt->execute()) {
        $referral_id = $stmt->insert_id;
        echo "<div class='success'>✓ Created referral: {$ref['candidate_name']} - {$ref['position_name']} (Status: {$ref['status']})</div>";
        $inserted++;
        
        // Insert bonus payment for paid bonuses
        if ($ref['bonus_status'] == 'Paid' && $ref['bonus_amount'] > 0) {
            $payment_sql = "INSERT INTO referral_bonus_payments (
                referral_id, referrer_id, payment_amount, payment_date,
                payment_status, payment_method, approved_by, approved_date
            ) VALUES (?, ?, ?, ?, 'Completed', 'Bank Transfer', ?, ?)";
            
            $pay_stmt = $conn->prepare($payment_sql);
            $pay_stmt->bind_param(
                'iidsss',
                $referral_id,
                $admin_id,
                $ref['bonus_amount'],
                $bonus_paid_date,
                $admin_username,
                $bonus_paid_date
            );
            $pay_stmt->execute();
        }
    }
}

// Create referral code for admin
$ref_code = strtoupper(substr($admin_username, 0, 3) . rand(1000, 9999));
$conn->query("INSERT INTO referral_codes (user_id, username, referral_code, is_active) 
             VALUES ({$admin_id}, '{$admin_username}', '{$ref_code}', 1)");

echo "<hr>";
echo "<h3>Summary:</h3>";
echo "<div class='info'>";
echo "<p><strong>Referrals Created:</strong> $inserted</p>";
echo "<p><strong>Your Referral Code:</strong> <strong style='color: #667eea; font-size: 1.2em;'>$ref_code</strong></p>";
echo "<p><strong>Status:</strong> Sample data inserted successfully!</p>";
echo "</div>";

echo "<h3>Statistics:</h3>";
$stats = $conn->query("SELECT 
    COUNT(*) as total,
    SUM(CASE WHEN referral_status = 'Hired' THEN 1 ELSE 0 END) as hired,
    SUM(CASE WHEN referral_status = 'Interviewing' THEN 1 ELSE 0 END) as interviewing,
    SUM(CASE WHEN bonus_status = 'Paid' THEN bonus_amount ELSE 0 END) as paid_bonuses
    FROM referrals")->fetch_assoc();

echo "<div class='info'>";
echo "<p>Total Referrals: <strong>{$stats['total']}</strong></p>";
echo "<p>Hired: <strong>{$stats['hired']}</strong></p>";
echo "<p>Interviewing: <strong>{$stats['interviewing']}</strong></p>";
echo "<p>Bonuses Paid: <strong>\$" . number_format($stats['paid_bonuses']) . "</strong></p>";
echo "</div>";

echo "<h3>Next Steps:</h3>";
echo "<p><a href='http://localhost/rms/Referral' class='btn' style='display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 5px;'>View Referral Dashboard</a></p>";

$conn->close();
?>
