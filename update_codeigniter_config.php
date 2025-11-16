<?php
/**
 * Update CodeIgniter Database Configuration
 * 
 * This script updates application/config/database.php to use the central config
 */

echo "<h2>Update CodeIgniter Database Configuration</h2>";

$ci_db_file = 'application/config/database.php';

if (!file_exists($ci_db_file)) {
    die("<p style='color: red;'>Error: $ci_db_file not found!</p>");
}

// Backup original file
$backup_file = $ci_db_file . '.backup.' . date('Y-m-d_His');
if (copy($ci_db_file, $backup_file)) {
    echo "<p style='color: green;'>✓ Backup created: $backup_file</p>";
} else {
    die("<p style='color: red;'>Error: Could not create backup!</p>");
}

// New content for CodeIgniter database config
$new_content = <<<'PHP'
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Database Configuration
 * 
 * Now uses the central database configuration system.
 * To change database credentials, edit: config/database.php or .env file
 */

// Load central database configuration
require_once FCPATH . 'config/database.php';

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => DB_HOST,
	'username' => DB_USER,
	'password' => DB_PASS,
	'database' => DB_NAME,
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => DB_CHARSET,
	'dbcollat' => DB_COLLATION,
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
PHP;

// Write new content
if (file_put_contents($ci_db_file, $new_content)) {
    echo "<p style='color: green;'>✓ Successfully updated $ci_db_file</p>";
    
    echo "<hr>";
    echo "<h3>What Changed:</h3>";
    echo "<ul>";
    echo "<li>Added: <code>require_once FCPATH . 'config/database.php';</code></li>";
    echo "<li>Changed: <code>'hostname' => 'localhost'</code> to <code>'hostname' => DB_HOST</code></li>";
    echo "<li>Changed: <code>'username' => 'root'</code> to <code>'username' => DB_USER</code></li>";
    echo "<li>Changed: <code>'password' => ''</code> to <code>'password' => DB_PASS</code></li>";
    echo "<li>Changed: <code>'database' => 'rmsdb'</code> to <code>'database' => DB_NAME</code></li>";
    echo "<li>Changed: <code>'char_set' => 'utf8'</code> to <code>'char_set' => DB_CHARSET</code></li>";
    echo "<li>Changed: <code>'dbcollat' => 'utf8_general_ci'</code> to <code>'dbcollat' => DB_COLLATION</code></li>";
    echo "</ul>";
    
    echo "<hr>";
    echo "<h3>Testing:</h3>";
    echo "<p>Your CodeIgniter application should now use the central database configuration.</p>";
    echo "<p>Test by:</p>";
    echo "<ol>";
    echo "<li>Loading any page in your application</li>";
    echo "<li>Checking if database queries work</li>";
    echo "<li>Verifying no connection errors appear</li>";
    echo "</ol>";
    
    echo "<hr>";
    echo "<h3>Rollback (if needed):</h3>";
    echo "<p>If something goes wrong, restore the backup:</p>";
    echo "<pre>copy $backup_file $ci_db_file</pre>";
    
} else {
    echo "<p style='color: red;'>✗ Error: Could not write to $ci_db_file</p>";
    echo "<p>Check file permissions and try again.</p>";
}

echo "<hr>";
echo "<p><a href='test_central_config.php'>← Back to Configuration Test</a></p>";
