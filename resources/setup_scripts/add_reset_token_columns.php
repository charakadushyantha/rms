<?php
/**
 * Migration: Add reset_token and reset_expires columns to users table
 * Run this once: http://localhost/rms/add_reset_token_columns.php
 */

// Bootstrap CodeIgniter just enough to get DB access
define('BASEPATH', __DIR__ . '/system/');
define('APPPATH', __DIR__ . '/application/');
define('FCPATH', __DIR__ . '/');
define('ENVIRONMENT', 'development');

require_once(APPPATH . 'config/environment.php');

$conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

if ($conn->connect_error) {
    die('<p style="color:red">Connection failed: ' . $conn->connect_error . '</p>');
}

$results = [];

// Check if reset_token column already exists
$check = $conn->query("SHOW COLUMNS FROM `users` LIKE 'reset_token'");
if ($check->num_rows === 0) {
    $sql = "ALTER TABLE `users` ADD COLUMN `reset_token` VARCHAR(64) NULL DEFAULT NULL";
    if ($conn->query($sql)) {
        $results[] = ['ok', 'Added column: reset_token'];
    } else {
        $results[] = ['err', 'Failed to add reset_token: ' . $conn->error];
    }
} else {
    $results[] = ['ok', 'Column reset_token already exists — skipped'];
}

// Check if reset_expires column already exists
$check = $conn->query("SHOW COLUMNS FROM `users` LIKE 'reset_expires'");
if ($check->num_rows === 0) {
    $sql = "ALTER TABLE `users` ADD COLUMN `reset_expires` DATETIME NULL DEFAULT NULL";
    if ($conn->query($sql)) {
        $results[] = ['ok', 'Added column: reset_expires'];
    } else {
        $results[] = ['err', 'Failed to add reset_expires: ' . $conn->error];
    }
} else {
    $results[] = ['ok', 'Column reset_expires already exists — skipped'];
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Migration: Reset Token Columns</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 60px auto; padding: 20px; }
        .ok  { color: #2e7d32; background: #e8f5e9; padding: 10px 14px; border-radius: 6px; margin: 8px 0; }
        .err { color: #c33;    background: #fee;    padding: 10px 14px; border-radius: 6px; margin: 8px 0; }
        h2   { color: #333; }
        a    { display:inline-block; margin-top:20px; padding:10px 20px; background:#667eea; color:white; border-radius:6px; text-decoration:none; }
    </style>
</head>
<body>
    <h2>Migration: Add Password Reset Columns</h2>
    <?php foreach ($results as [$type, $msg]): ?>
        <div class="<?= $type ?>"><?= $type === 'ok' ? '✅' : '❌' ?> <?= htmlspecialchars($msg) ?></div>
    <?php endforeach; ?>
    <a href="http://localhost/rms/">← Back to RMS</a>
</body>
</html>
