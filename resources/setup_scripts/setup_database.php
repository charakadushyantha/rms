<?php
/**
 * RMS Database Setup
 * Run once: http://localhost/rms/setup_database.php
 * Creates the database if missing, adds required columns.
 */
define('BASEPATH', __DIR__ . '/system/');
define('APPPATH', __DIR__ . '/application/');
define('FCPATH', __DIR__ . '/');

require_once __DIR__ . '/application/config/environment.php';

// Connect WITHOUT selecting a database first
$conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD);
if ($conn->connect_error) {
    die('<p style="color:red"><b>Cannot connect to MySQL:</b> ' . $conn->connect_error . '<br>Make sure XAMPP MySQL is running and credentials are correct (user: <b>' . DB_USERNAME . '</b>).</p>');
}

$results = [];

// 1. Create database if not exists
$sql = "CREATE DATABASE IF NOT EXISTS `" . DB_DATABASE . "` CHARACTER SET utf8 COLLATE utf8_general_ci";
if ($conn->query($sql)) {
    $results[] = ['ok', 'Database <b>' . DB_DATABASE . '</b> ready'];
} else {
    $results[] = ['err', 'Failed to create database: ' . $conn->error];
}

// Select the database
$conn->select_db(DB_DATABASE);

// 2. Create users table if not exists
$sql = "CREATE TABLE IF NOT EXISTS `users` (
    `u_id`          INT(11) NOT NULL AUTO_INCREMENT,
    `u_username`    VARCHAR(100) NOT NULL,
    `u_email`       VARCHAR(150) NOT NULL,
    `u_password`    VARCHAR(255) NOT NULL,
    `u_role`        VARCHAR(50)  NOT NULL DEFAULT 'Recruiter',
    `u_status`      VARCHAR(20)  NOT NULL DEFAULT 'Pending',
    `profile_picture` VARCHAR(255) NULL DEFAULT NULL,
    `reset_token`   VARCHAR(64)  NULL DEFAULT NULL,
    `reset_expires` DATETIME     NULL DEFAULT NULL,
    PRIMARY KEY (`u_id`),
    UNIQUE KEY `u_username` (`u_username`),
    UNIQUE KEY `u_email` (`u_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8";
if ($conn->query($sql)) {
    $results[] = ['ok', 'Table <b>users</b> ready'];
} else {
    $results[] = ['err', 'Failed to create users table: ' . $conn->error];
}

// 3. Add reset_token column if missing
$check = $conn->query("SHOW COLUMNS FROM `users` LIKE 'reset_token'");
if ($check && $check->num_rows === 0) {
    if ($conn->query("ALTER TABLE `users` ADD COLUMN `reset_token` VARCHAR(64) NULL DEFAULT NULL")) {
        $results[] = ['ok', 'Added column <b>reset_token</b>'];
    } else {
        $results[] = ['err', 'Failed to add reset_token: ' . $conn->error];
    }
} else {
    $results[] = ['ok', 'Column <b>reset_token</b> already exists'];
}

// 4. Add reset_expires column if missing
$check = $conn->query("SHOW COLUMNS FROM `users` LIKE 'reset_expires'");
if ($check && $check->num_rows === 0) {
    if ($conn->query("ALTER TABLE `users` ADD COLUMN `reset_expires` DATETIME NULL DEFAULT NULL")) {
        $results[] = ['ok', 'Added column <b>reset_expires</b>'];
    } else {
        $results[] = ['err', 'Failed to add reset_expires: ' . $conn->error];
    }
} else {
    $results[] = ['ok', 'Column <b>reset_expires</b> already exists'];
}

// 5. Create ci_sessions table (required for CodeIgniter DB sessions)
$sql = "CREATE TABLE IF NOT EXISTS `ci_sessions` (
    `id`         VARCHAR(128) NOT NULL,
    `ip_address` VARCHAR(45)  NOT NULL,
    `timestamp`  INT(10) UNSIGNED DEFAULT 0 NOT NULL,
    `data`       BLOB NOT NULL,
    KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8";
if ($conn->query($sql)) {
    $results[] = ['ok', 'Table <b>ci_sessions</b> ready'];
} else {
    $results[] = ['err', 'Failed to create ci_sessions: ' . $conn->error];
}

// 6. Create profile_info table
$sql = "CREATE TABLE IF NOT EXISTS `profile_info` (
    `pi_id`         INT(11) NOT NULL AUTO_INCREMENT,
    `pi_username`   VARCHAR(100) NOT NULL,
    `pi_email`      VARCHAR(150) NULL,
    `pi_role`       VARCHAR(50)  NULL,
    `pi_first_name` VARCHAR(100) NULL,
    `pi_last_name`  VARCHAR(100) NULL,
    `pi_full_name`  VARCHAR(200) NULL,
    PRIMARY KEY (`pi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8";
if ($conn->query($sql)) {
    $results[] = ['ok', 'Table <b>profile_info</b> ready'];
} else {
    $results[] = ['err', 'Failed to create profile_info: ' . $conn->error];
}

// 7. Create candidate_details table
$sql = "CREATE TABLE IF NOT EXISTS `candidate_details` (
    `cd_id`               INT(11) NOT NULL AUTO_INCREMENT,
    `cd_rec_username`     VARCHAR(100) NULL,
    `cd_name`             VARCHAR(200) NULL,
    `cd_email`            VARCHAR(150) NULL,
    `cd_phone`            VARCHAR(20)  NULL,
    `cd_gender`           VARCHAR(20)  NULL,
    `cd_job_title`        VARCHAR(200) NULL,
    `cd_source`           VARCHAR(100) NULL,
    `cd_description`      TEXT NULL,
    `cd_status`           VARCHAR(50)  NULL DEFAULT 'New',
    `cd_interview_status` TINYINT(1)   NULL DEFAULT 0,
    `cd_created_at`       DATETIME     NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`cd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8";
if ($conn->query($sql)) {
    $results[] = ['ok', 'Table <b>candidate_details</b> ready'];
} else {
    $results[] = ['err', 'Failed to create candidate_details: ' . $conn->error];
}

// 8. Create calendar_events table
$sql = "CREATE TABLE IF NOT EXISTS `calendar_events` (
    `event_id`    INT(11) NOT NULL AUTO_INCREMENT,
    `title`       VARCHAR(255) NOT NULL,
    `start`       DATETIME NULL,
    `end`         DATETIME NULL,
    `description` TEXT NULL,
    `created_by`  VARCHAR(100) NULL,
    PRIMARY KEY (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8";
if ($conn->query($sql)) {
    $results[] = ['ok', 'Table <b>calendar_events</b> ready'];
} else {
    $results[] = ['err', 'Failed to create calendar_events: ' . $conn->error];
}

// 9. Create oauth_config table
$sql = "CREATE TABLE IF NOT EXISTS `oauth_config` (
    `id`                 INT(11) NOT NULL AUTO_INCREMENT,
    `provider`           VARCHAR(50) NOT NULL DEFAULT 'google',
    `client_id`          VARCHAR(255) NULL,
    `client_secret`      VARCHAR(255) NULL,
    `is_enabled`         TINYINT(1) NOT NULL DEFAULT 0,
    `auto_activate_users` TINYINT(1) NOT NULL DEFAULT 1,
    `default_role`       VARCHAR(50) NOT NULL DEFAULT 'Candidate',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8";
if ($conn->query($sql)) {
    $results[] = ['ok', 'Table <b>oauth_config</b> ready'];
    // Insert default Google OAuth row if empty
    $check = $conn->query("SELECT id FROM oauth_config WHERE provider='google'");
    if ($check && $check->num_rows === 0) {
        $conn->query("INSERT INTO oauth_config (provider, is_enabled, auto_activate_users, default_role) VALUES ('google', 0, 1, 'Candidate')");
        $results[] = ['ok', 'Inserted default Google OAuth config row'];
    }
} else {
    $results[] = ['err', 'Failed to create oauth_config: ' . $conn->error];
}

// 10. Check if admin user exists, create if not
$check = $conn->query("SELECT u_id FROM users WHERE u_role='Admin' LIMIT 1");
if ($check && $check->num_rows === 0) {
    $admin_pass = md5('admin123');
    $conn->query("INSERT INTO users (u_username, u_email, u_password, u_role, u_status)
                  VALUES ('admin', 'admin@rms.local', '$admin_pass', 'Admin', 'Active')");
    $results[] = ['new', 'Created default Admin account: <b>username: admin</b> / <b>password: admin123</b> — change this after login!'];
} else {
    $row = $check->fetch_assoc();
    // Get username for display
    $urow = $conn->query("SELECT u_username, u_email, u_status FROM users WHERE u_role='Admin' LIMIT 1")->fetch_assoc();
    $results[] = ['ok', 'Admin user already exists: <b>' . htmlspecialchars($urow['u_username']) . '</b> (' . htmlspecialchars($urow['u_email']) . ') — Status: <b>' . $urow['u_status'] . '</b>'];
}

$conn->close();

// Count errors
$errors = array_filter($results, fn($r) => $r[0] === 'err');
?>
<!DOCTYPE html>
<html>
<head>
<title>RMS Database Setup</title>
<style>
  body  { font-family: Arial, sans-serif; max-width: 700px; margin: 40px auto; padding: 20px; background: #f5f5f5; }
  .card { background: white; border-radius: 10px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,.1); }
  h2   { color: #333; margin-bottom: 20px; }
  .ok  { color: #2e7d32; background: #e8f5e9; padding: 10px 14px; border-radius: 6px; margin: 6px 0; }
  .err { color: #c33;    background: #fee;    padding: 10px 14px; border-radius: 6px; margin: 6px 0; }
  .new { color: #e65100; background: #fff3e0; padding: 10px 14px; border-radius: 6px; margin: 6px 0; font-weight: bold; }
  .btn { display:inline-block; margin-top:24px; padding:12px 24px; background:#667eea; color:white; border-radius:8px; text-decoration:none; font-weight:bold; }
  .btn-green { background: #2e7d32; margin-left: 10px; }
  .warn { background:#fff3cd; border:1px solid #ffc107; padding:14px; border-radius:8px; margin-top:20px; font-size:14px; }
</style>
</head>
<body>
<div class="card">
  <h2>🗄️ RMS Database Setup</h2>
  <?php foreach ($results as [$type, $msg]): ?>
    <div class="<?= $type ?>"><?= $type === 'ok' ? '✅' : ($type === 'new' ? '🆕' : '❌') ?> <?= $msg ?></div>
  <?php endforeach; ?>

  <?php if (empty($errors)): ?>
    <div class="warn">⚠️ <b>Delete this file after setup:</b> <code>setup_database.php</code></div>
    <a href="http://localhost/rms/" class="btn">← Go to Login</a>
    <a href="http://localhost/rms/check_admin.php" class="btn btn-green">View All Users</a>
  <?php else: ?>
    <div style="margin-top:20px;color:#c33;font-weight:bold;">❌ Some steps failed. Check the errors above.</div>
  <?php endif; ?>
</div>
</body>
</html>
