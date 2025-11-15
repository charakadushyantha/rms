<?php
/**
 * Referral Program Management - Database Setup
 * Run this file once: http://localhost/rms/create_referral_tables.php
 */

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'rmsdb';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>Referral Program Management - Database Setup</h2>";
echo "<style>
    body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
    .success { color: green; padding: 10px; background: #d4edda; margin: 10px 0; border-radius: 5px; }
    .info { color: #0c5460; padding: 10px; background: #d1ecf1; margin: 10px 0; border-radius: 5px; }
    h3 { color: #333; margin-top: 20px; }
</style>";

$tables_created = 0;

// 1. Referral Program Configuration
$sql = "CREATE TABLE IF NOT EXISTS `referral_program_config` (
    `config_id` int(11) NOT NULL AUTO_INCREMENT,
    `config_key` varchar(100) NOT NULL UNIQUE,
    `config_value` text,
    `config_type` varchar(50) DEFAULT 'string',
    `description` text,
    `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ Table 'referral_program_config' created</div>";
    $tables_created++;
}

// 2. Referrals Table
$sql = "CREATE TABLE IF NOT EXISTS `referrals` (
    `referral_id` int(11) NOT NULL AUTO_INCREMENT,
    `referral_code` varchar(50) UNIQUE,
    `referrer_id` int(11) NOT NULL,
    `referrer_name` varchar(255) NOT NULL,
    `referrer_email` varchar(255),
    `candidate_name` varchar(255) NOT NULL,
    `candidate_email` varchar(255) NOT NULL,
    `candidate_phone` varchar(50),
    `candidate_resume` varchar(255),
    `position_id` int(11),
    `position_name` varchar(255),
    `referral_date` date NOT NULL,
    `referral_status` varchar(50) DEFAULT 'Submitted',
    `candidate_status` varchar(50) DEFAULT 'New',
    `interview_date` date,
    `hired_date` date,
    `bonus_eligible` tinyint(1) DEFAULT 1,
    `bonus_amount` decimal(10,2),
    `bonus_status` varchar(50) DEFAULT 'Pending',
    `bonus_paid_date` date,
    `notes` text,
    `created_by` varchar(100),
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`referral_id`),
    KEY `idx_referrer` (`referrer_id`),
    KEY `idx_status` (`referral_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ Table 'referrals' created</div>";
    $tables_created++;
}

// 3. Referral Bonuses Configuration
$sql = "CREATE TABLE IF NOT EXISTS `referral_bonuses` (
    `bonus_id` int(11) NOT NULL AUTO_INCREMENT,
    `position_level` varchar(100),
    `job_category_id` int(11),
    `bonus_amount` decimal(10,2) NOT NULL,
    `bonus_currency` varchar(10) DEFAULT 'USD',
    `eligibility_criteria` text,
    `payout_schedule` varchar(100),
    `is_active` tinyint(1) DEFAULT 1,
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`bonus_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ Table 'referral_bonuses' created</div>";
    $tables_created++;
}

// 4. Referral Bonus Payments
$sql = "CREATE TABLE IF NOT EXISTS `referral_bonus_payments` (
    `payment_id` int(11) NOT NULL AUTO_INCREMENT,
    `referral_id` int(11) NOT NULL,
    `referrer_id` int(11) NOT NULL,
    `payment_amount` decimal(10,2) NOT NULL,
    `payment_currency` varchar(10) DEFAULT 'USD',
    `payment_date` date,
    `payment_method` varchar(50),
    `payment_status` varchar(50) DEFAULT 'Pending',
    `payment_reference` varchar(100),
    `approved_by` varchar(100),
    `approved_date` date,
    `notes` text,
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`payment_id`),
    FOREIGN KEY (`referral_id`) REFERENCES `referrals`(`referral_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ Table 'referral_bonus_payments' created</div>";
    $tables_created++;
}

// 5. Referral Codes
$sql = "CREATE TABLE IF NOT EXISTS `referral_codes` (
    `code_id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `username` varchar(100) NOT NULL,
    `referral_code` varchar(50) NOT NULL UNIQUE,
    `code_type` varchar(50) DEFAULT 'personal',
    `is_active` tinyint(1) DEFAULT 1,
    `uses_count` int(11) DEFAULT 0,
    `max_uses` int(11),
    `expires_at` date,
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`code_id`),
    KEY `idx_code` (`referral_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ Table 'referral_codes' created</div>";
    $tables_created++;
}

// 6. Referral Campaigns
$sql = "CREATE TABLE IF NOT EXISTS `referral_campaigns` (
    `campaign_id` int(11) NOT NULL AUTO_INCREMENT,
    `campaign_name` varchar(255) NOT NULL,
    `campaign_description` text,
    `start_date` date NOT NULL,
    `end_date` date,
    `bonus_multiplier` decimal(5,2) DEFAULT 1.00,
    `target_positions` text,
    `campaign_status` varchar(50) DEFAULT 'Active',
    `created_by` varchar(100),
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`campaign_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'>✓ Table 'referral_campaigns' created</div>";
    $tables_created++;
}

// Insert default configuration
$default_configs = [
    ['program_enabled', '1', 'boolean', 'Enable/disable referral program'],
    ['default_bonus_amount', '1000', 'number', 'Default referral bonus amount'],
    ['bonus_currency', 'USD', 'string', 'Currency for bonus payments'],
    ['min_employment_days', '90', 'number', 'Minimum days candidate must stay employed'],
    ['bonus_payout_days', '30', 'number', 'Days after hire to pay bonus'],
    ['allow_self_referral', '0', 'boolean', 'Allow employees to refer themselves'],
    ['max_referrals_per_month', '10', 'number', 'Maximum referrals per employee per month'],
    ['require_approval', '1', 'boolean', 'Require admin approval for referrals']
];

foreach ($default_configs as $config) {
    $check = $conn->query("SELECT * FROM referral_program_config WHERE config_key = '{$config[0]}'");
    if ($check->num_rows == 0) {
        $conn->query("INSERT INTO referral_program_config (config_key, config_value, config_type, description) 
                     VALUES ('{$config[0]}', '{$config[1]}', '{$config[2]}', '{$config[3]}')");
        echo "<div class='info'>→ Added config: {$config[0]}</div>";
    }
}

// Insert default bonus tiers
$default_bonuses = [
    ['Entry Level', 500],
    ['Mid Level', 1000],
    ['Senior Level', 2000],
    ['Executive Level', 5000],
    ['Technical Specialist', 1500]
];

foreach ($default_bonuses as $bonus) {
    $check = $conn->query("SELECT * FROM referral_bonuses WHERE position_level = '{$bonus[0]}'");
    if ($check->num_rows == 0) {
        $conn->query("INSERT INTO referral_bonuses (position_level, bonus_amount, payout_schedule) 
                     VALUES ('{$bonus[0]}', {$bonus[1]}, 'After 90 days of employment')");
        echo "<div class='info'>→ Added bonus tier: {$bonus[0]} - \${$bonus[1]}</div>";
    }
}

echo "<hr>";
echo "<h3>Summary:</h3>";
echo "<div class='success'>";
echo "<p><strong>Tables created:</strong> $tables_created</p>";
echo "<p><strong>Status:</strong> Referral Program database setup complete!</p>";
echo "</div>";

echo "<h3>Next Steps:</h3>";
echo "<p>1. Delete this file for security</p>";
echo "<p>2. Access the referral program at: <a href='http://localhost/rms/Referral'>Referral Dashboard</a></p>";

$conn->close();
?>
