<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Environment Configuration
|--------------------------------------------------------------------------
| Centralized configuration for different environments (development, production)
| This file should be updated based on your deployment environment
|
*/

// Detect environment based on domain
$current_domain = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';

// Environment settings
if (strpos($current_domain, 'lankantech.com') !== false || strpos($current_domain, 'rms.lankantech.com') !== false) {
    // PRODUCTION ENVIRONMENT
    define('APP_ENVIRONMENT', 'production');
    define('APP_URL', 'https://rms.lankantech.com/');
    define('APP_NAME', 'RMS - Recruitment Management System');
    
    // Database Configuration
    define('DB_HOSTNAME', 'localhost');
    define('DB_USERNAME', 'cmsadver_rmsdbuser');
    define('DB_PASSWORD', 'Charaka@321');
    define('DB_DATABASE', 'cmsadver_rmsdb');
    define('DB_DRIVER', 'mysqli');
    
    // Debug Settings
    define('APP_DEBUG', false);
    define('DISPLAY_ERRORS', false);
    
} else {
    // DEVELOPMENT ENVIRONMENT (localhost)
    define('APP_ENVIRONMENT', 'development');
    define('APP_URL', 'http://localhost/rms/');
    define('APP_NAME', 'RMS - Development');
    
    // Database Configuration
    define('DB_HOSTNAME', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_DATABASE', 'rms');
    define('DB_DRIVER', 'mysqli');
    
    // Debug Settings
    define('APP_DEBUG', true);
    define('DISPLAY_ERRORS', true);
}

// Common Settings (applies to all environments)
define('APP_TIMEZONE', 'Asia/Colombo');
define('APP_CHARSET', 'UTF-8');
define('SESSION_EXPIRATION', 7200); // 2 hours
define('COOKIE_PREFIX', 'rms_');
define('COOKIE_DOMAIN', '');
define('COOKIE_PATH', '/');
define('COOKIE_SECURE', APP_ENVIRONMENT === 'production'); // TRUE for HTTPS
define('COOKIE_HTTPONLY', true);

// File Upload Settings
define('UPLOAD_MAX_SIZE', 5120); // 5MB in KB
define('ALLOWED_FILE_TYPES', 'pdf|doc|docx|jpg|jpeg|png|gif');
define('UPLOAD_PATH', './uploads/');

// Email Settings (Update with your SMTP details)
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'your-email@gmail.com');
define('SMTP_PASS', 'your-app-password');
define('SMTP_FROM', 'noreply@lankantech.com');
define('SMTP_FROM_NAME', 'RMS System');

// Pagination
define('PER_PAGE', 20);

// Security
define('ENCRYPTION_KEY', 'your-32-character-encryption-key-here');
define('CSRF_PROTECTION', true);
define('CSRF_TOKEN_NAME', 'csrf_token');
define('CSRF_COOKIE_NAME', 'csrf_cookie');
define('CSRF_EXPIRE', 7200);

// API Keys (if needed)
define('GOOGLE_CLIENT_ID', '');
define('GOOGLE_CLIENT_SECRET', '');
define('LINKEDIN_API_KEY', '');
define('INDEED_API_KEY', '');

// Logging
define('LOG_THRESHOLD', APP_ENVIRONMENT === 'production' ? 1 : 4);
define('LOG_PATH', APPPATH . 'logs/');
define('LOG_FILE_EXTENSION', 'log');
define('LOG_FILE_PERMISSIONS', 0644);
define('LOG_DATE_FORMAT', 'Y-m-d H:i:s');
