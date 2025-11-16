<?php
/**
 * Migration Script: Update all standalone scripts to use central database config
 * 
 * This script will update all PHP files that have hardcoded database credentials
 * to use the new central configuration system.
 */

echo "<h2>Database Configuration Migration</h2>";
echo "<p>This will update all standalone scripts to use the central config...</p>";

// Files to update (add more as needed)
$files_to_update = [
    'add_comprehensive_sample_data.php',
    'add_created_at_column.php',
    'add_sample_data.php',
    'assign_candidates_to_current_user.php',
    'check_database.php',
    'check_email_templates_structure.php',
    'check_job_posting_setup.php',
    'check_templates.php',
    'cleanup_duplicates.php',
    'create_audit_logs_table.php',
    'create_candidates_table.php',
    'create_candidate_crm_tables.php',
    'create_candidate_sourcing_tables.php',
    'create_email_tables.php',
    'create_events_advocacy_tables.php',
    'create_job_posting_tables.php',
    'create_marketing_campaigns_tables.php',
    'create_modules_table.php',
    'create_notifications_table.php',
    'create_referral_tables.php',
    'fix_campaign_analytics_table.php',
    'fix_candidate_dates.php',
    'fix_email_templates_final.php',
    'fix_email_templates_table.php',
    'insert_candidate_sourcing_sample_data.php',
    'insert_events_advocacy_sample_data.php',
    'insert_marketing_sample_data.php',
    'insert_sample_candidates.php',
    'insert_sample_job_data.php',
    'insert_sample_pools.php',
    'insert_sample_referral_data.php',
    'load_sample_data_direct.php',
    'setup_chatbot.php',
    'setup_realtime_dashboard.php',
    'install_dashboard.php',
    'verify_job_data.php'
];

$updated = 0;
$skipped = 0;
$errors = 0;

foreach ($files_to_update as $file) {
    if (!file_exists($file)) {
        echo "<p style='color: orange;'>⚠ Skipped: $file (not found)</p>";
        $skipped++;
        continue;
    }
    
    $content = file_get_contents($file);
    $original = $content;
    
    // Check if already using central config
    if (strpos($content, "require_once __DIR__ . '/config/database.php'") !== false ||
        strpos($content, 'require_once __DIR__ . \'/config/database.php\'') !== false) {
        echo "<p style='color: blue;'>ℹ Already updated: $file</p>";
        $skipped++;
        continue;
    }
    
    // Pattern to match database configuration blocks
    $patterns = [
        // Pattern 1: Standard config block
        '/\/\/ Database configuration.*?\n(\$host|\$db_host|\$servername) = [\'"].*?[\'"];.*?\n(\$username|\$db_user) = [\'"].*?[\'"];.*?\n(\$password|\$db_pass) = [\'"].*?[\'"];.*?\n(\$database|\$db_name|\$dbname) = [\'"].*?[\'"];/s',
        
        // Pattern 2: Inline mysqli connection
        '/\$conn = new mysqli\([\'"]localhost[\'"], [\'"]root[\'"], [\'"][\'"], [\'"]rmsdb[\'"].*?\);/s'
    ];
    
    $replaced = false;
    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $content)) {
            $replaced = true;
            break;
        }
    }
    
    if ($replaced) {
        // Add central config require at the top (after opening PHP tag)
        $content = preg_replace(
            '/<\?php\s*\n/',
            "<?php\n// Use central database configuration\nrequire_once __DIR__ . '/config/database.php';\n\n",
            $content,
            1
        );
        
        // Remove old database configuration blocks
        $content = preg_replace($patterns[0], '', $content);
        
        // Replace mysqli connections
        $content = preg_replace(
            '/\$conn = new mysqli\(\$(?:host|db_host|servername), \$(?:username|db_user), \$(?:password|db_pass), \$(?:database|db_name|dbname)\);/',
            '$conn = getDatabaseConnection();',
            $content
        );
        
        // Replace inline mysqli connections
        $content = preg_replace(
            '/\$conn = new mysqli\([\'"]localhost[\'"], [\'"]root[\'"], [\'"][\'"], [\'"]rmsdb[\'"].*?\);/',
            '$conn = getDatabaseConnection();',
            $content
        );
        
        // Backup original file
        $backup_dir = 'backups_db_migration';
        if (!is_dir($backup_dir)) {
            mkdir($backup_dir, 0755, true);
        }
        file_put_contents("$backup_dir/$file", $original);
        
        // Write updated file
        file_put_contents($file, $content);
        
        echo "<p style='color: green;'>✓ Updated: $file</p>";
        $updated++;
    } else {
        echo "<p style='color: gray;'>- No changes needed: $file</p>";
        $skipped++;
    }
}

echo "<hr>";
echo "<h3>Migration Summary</h3>";
echo "<p><strong>Updated:</strong> $updated files</p>";
echo "<p><strong>Skipped:</strong> $skipped files</p>";
echo "<p><strong>Errors:</strong> $errors files</p>";
echo "<p><strong>Backups:</strong> Original files saved in 'backups_db_migration/' directory</p>";

echo "<hr>";
echo "<h3>Next Steps:</h3>";
echo "<ol>";
echo "<li>Review the updated files to ensure they work correctly</li>";
echo "<li>Copy .env.example to .env and configure for production if needed</li>";
echo "<li>Update application/config/database.php to use the central config</li>";
echo "<li>Test all scripts to ensure database connections work</li>";
echo "</ol>";
