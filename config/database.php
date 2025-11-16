<?php
/**
 * Central Database Configuration
 * 
 * This file serves as the single source of truth for all database connections
 * across the entire application, including standalone scripts.
 * 
 * Usage in standalone scripts:
 * require_once __DIR__ . '/config/database.php';
 * $conn = getDatabaseConnection();
 */

// Environment detection
define('DB_ENVIRONMENT', getenv('DB_ENVIRONMENT') ?: 'development');

// Database configurations for different environments
$db_config = [
    'development' => [
        'host'     => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'cmsadver_rmsdb',
        'charset'  => 'utf8',
        'collation' => 'utf8_general_ci'
    ],
    'production' => [
        'host'     => getenv('DB_HOST') ?: 'localhost',
        'username' => getenv('DB_USER') ?: 'root',
        'password' => getenv('DB_PASS') ?: '',
        'database' => getenv('DB_NAME') ?: 'cmsadver_rmsdb',
        'charset'  => 'utf8',
        'collation' => 'utf8_general_ci'
    ],
    'testing' => [
        'host'     => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'cmsadver_rmsdb_test',
        'charset'  => 'utf8',
        'collation' => 'utf8_general_ci'
    ]
];

// Get current environment config
$current_config = $db_config[DB_ENVIRONMENT];

// Define global constants for backward compatibility
define('DB_HOST', $current_config['host']);
define('DB_USER', $current_config['username']);
define('DB_PASS', $current_config['password']);
define('DB_NAME', $current_config['database']);
define('DB_CHARSET', $current_config['charset']);
define('DB_COLLATION', $current_config['collation']);

/**
 * Get database connection
 * 
 * @return mysqli Database connection object
 * @throws Exception if connection fails
 */
function getDatabaseConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        throw new Exception("Database connection failed: " . $conn->connect_error);
    }
    
    $conn->set_charset(DB_CHARSET);
    
    return $conn;
}

/**
 * Get database configuration array
 * 
 * @return array Database configuration
 */
function getDatabaseConfig() {
    return [
        'host'     => DB_HOST,
        'username' => DB_USER,
        'password' => DB_PASS,
        'database' => DB_NAME,
        'charset'  => DB_CHARSET,
        'collation' => DB_COLLATION
    ];
}

/**
 * Test database connection
 * 
 * @return bool True if connection successful
 */
function testDatabaseConnection() {
    try {
        $conn = getDatabaseConnection();
        $conn->close();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
