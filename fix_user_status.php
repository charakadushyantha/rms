<?php
/**
 * Fix User Status Script
 * Converts old numeric status (0/1) to new string status (Pending/Active)
 * Run this once: http://localhost/rms/fix_user_status.php
 */

// Load CodeIgniter
require_once 'index.php';

// Get CI instance
$CI =& get_instance();

echo "<!DOCTYPE html>
<html>
<head>
    <title>Fix User Status</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        .success { color: green; padding: 10px; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 5px; margin: 10px 0; }
        .error { color: red; padding: 10px; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px; margin: 10px 0; }
        .info { color: blue; padding: 10px; background: #d1ecf1; border: 1px solid #bee5eb; border-radius: 5px; margin: 10px 0; }
        h1 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background: #667eea; color: white; }
        .badge { padding: 5px 10px; border-radius: 12px; font-size: 12px; font-weight: bold; }
        .badge-active { background: #d4edda; color: #155724; }
        .badge-pending { background: #fff3cd; color: #856404; }
    </style>
</head>
<body>
    <h1>🔧 Fix User Status Script</h1>
";

try {
    // Step 1: Check current column type
    echo "<div class='info'>Step 1: Checking u_status column type...</div>";
    $columns = $CI->db->query("SHOW COLUMNS FROM " . TBL_USERS . " LIKE 'u_status'")->result();
    
    if (empty($columns)) {
        echo "<div class='error'>❌ u_status column does not exist! Please run the installer first.</div>";
        echo "</body></html>";
        exit;
    }
    
    $column = $columns[0];
    echo "<div class='info'>Current type: " . $column->Type . "</div>";
    
    // Step 2: Modify column to VARCHAR if needed
    if (strpos(strtolower($column->Type), 'int') !== false) {
        echo "<div class='info'>Step 2: Converting column from INT to VARCHAR...</div>";
        $CI->db->query("ALTER TABLE " . TBL_USERS . " MODIFY COLUMN `u_status` VARCHAR(20) DEFAULT 'Active'");
        echo "<div class='success'>✓ Column type changed to VARCHAR(20)</div>";
    } else {
        echo "<div class='info'>Step 2: Column is already VARCHAR, skipping...</div>";
    }
    
    // Step 3: Get all users before update
    echo "<div class='info'>Step 3: Fetching current user statuses...</div>";
    $users_before = $CI->db->select('u_id, u_username, u_role, u_status')->get(TBL_USERS)->result();
    
    echo "<h3>Before Update:</h3>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Username</th><th>Role</th><th>Status (Old)</th></tr>";
    foreach ($users_before as $user) {
        $status_display = $user->u_status === null ? 'NULL' : $user->u_status;
        echo "<tr><td>{$user->u_id}</td><td>{$user->u_username}</td><td>{$user->u_role}</td><td>{$status_display}</td></tr>";
    }
    echo "</table>";
    
    // Step 4: Update status values
    echo "<div class='info'>Step 4: Converting status values...</div>";
    
    // Convert 1 to Active
    $CI->db->where('u_status', '1');
    $CI->db->update(TBL_USERS, ['u_status' => 'Active']);
    $count_active = $CI->db->affected_rows();
    echo "<div class='success'>✓ Converted {$count_active} users from '1' to 'Active'</div>";
    
    // Convert 0 to Pending
    $CI->db->where('u_status', '0');
    $CI->db->update(TBL_USERS, ['u_status' => 'Pending']);
    $count_pending = $CI->db->affected_rows();
    echo "<div class='success'>✓ Converted {$count_pending} users from '0' to 'Pending'</div>";
    
    // Convert NULL to Pending
    $CI->db->where('u_status IS NULL', null, false);
    $CI->db->update(TBL_USERS, ['u_status' => 'Pending']);
    $count_null = $CI->db->affected_rows();
    echo "<div class='success'>✓ Converted {$count_null} users from NULL to 'Pending'</div>";
    
    // Convert empty string to Pending
    $CI->db->where('u_status', '');
    $CI->db->update(TBL_USERS, ['u_status' => 'Pending']);
    $count_empty = $CI->db->affected_rows();
    echo "<div class='success'>✓ Converted {$count_empty} users from empty to 'Pending'</div>";
    
    // Step 5: Get all users after update
    echo "<div class='info'>Step 5: Verifying changes...</div>";
    $users_after = $CI->db->select('u_id, u_username, u_role, u_status')->get(TBL_USERS)->result();
    
    echo "<h3>After Update:</h3>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Username</th><th>Role</th><th>Status (New)</th></tr>";
    foreach ($users_after as $user) {
        $badge_class = ($user->u_status == 'Active') ? 'badge-active' : 'badge-pending';
        echo "<tr><td>{$user->u_id}</td><td>{$user->u_username}</td><td>{$user->u_role}</td><td><span class='badge {$badge_class}'>{$user->u_status}</span></td></tr>";
    }
    echo "</table>";
    
    // Summary
    $total_updated = $count_active + $count_pending + $count_null + $count_empty;
    echo "<div class='success' style='font-size: 18px; font-weight: bold; margin-top: 30px;'>
        🎉 Status conversion completed successfully!<br>
        Total users updated: {$total_updated}
    </div>";
    
    echo "<p><a href='" . base_url('Setup/manage_users') . "' style='display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 5px; margin-top: 20px;'>Go to Manage Users</a></p>";
    
    echo "<p style='margin-top: 20px; color: #666;'>
        <strong>Note:</strong> You can now delete this file (fix_user_status.php) for security.
    </p>";
    
} catch (Exception $e) {
    echo "<div class='error'>❌ Error: " . $e->getMessage() . "</div>";
    echo "<p>Please check your database connection and try again.</p>";
}

echo "</body></html>";
?>
