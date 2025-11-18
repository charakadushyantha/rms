<?php
// Temporary debug file to check configuration
// DELETE THIS FILE AFTER DEBUGGING!

// Define BASEPATH for CodeIgniter compatibility
define('BASEPATH', dirname(__FILE__) . '/system/');
define('APPPATH', dirname(__FILE__) . '/application/');

// Load environment configuration
require_once('application/config/environment.php');
require_once('application/config/constants.php');

echo "<h2>Configuration Check</h2>";
echo "<table border='1' style='border-collapse:collapse; padding:10px;'>";
echo "<tr><th style='padding:10px; background:#f0f0f0;'>Setting</th><th style='padding:10px; background:#f0f0f0;'>Value</th></tr>";

echo "<tr><td style='padding:10px;'><strong>Current Domain</strong></td><td style='padding:10px;'>" . $_SERVER['HTTP_HOST'] . "</td></tr>";
echo "<tr><td style='padding:10px;'><strong>Environment</strong></td><td style='padding:10px;'>" . APP_ENVIRONMENT . "</td></tr>";
echo "<tr><td style='padding:10px;'><strong>APP_URL</strong></td><td style='padding:10px;'>" . APP_URL . "</td></tr>";
echo "<tr><td style='padding:10px;'><strong>BASE_URL</strong></td><td style='padding:10px;'>" . BASE_URL . "</td></tr>";
echo "<tr><td style='padding:10px;'><strong>LOGIN_URL</strong></td><td style='padding:10px;'>" . LOGIN_URL . "</td></tr>";
echo "<tr><td style='padding:10px;'><strong>A_DASHBOARD_URL</strong></td><td style='padding:10px;'>" . A_DASHBOARD_URL . "</td></tr>";
echo "<tr><td style='padding:10px;'><strong>R_DASHBOARD_URL</strong></td><td style='padding:10px;'>" . R_DASHBOARD_URL . "</td></tr>";

echo "</table>";

echo "<br><hr><br>";
echo "<h3>Expected Values for Production:</h3>";
echo "<ul>";
echo "<li>Current Domain: <strong>rms.lankantech.com</strong></li>";
echo "<li>Environment: <strong>production</strong></li>";
echo "<li>APP_URL: <strong>https://rms.lankantech.com/</strong></li>";
echo "<li>BASE_URL: <strong>https://rms.lankantech.com</strong></li>";
echo "<li>LOGIN_URL: <strong>https://rms.lankantech.com/index.php/Login</strong></li>";
echo "</ul>";

echo "<br><p style='background:#ffe6e6; padding:10px; border:1px solid #ff0000;'>";
echo "<strong>⚠️ SECURITY WARNING:</strong> Delete this file (check_config.php) immediately after checking!";
echo "</p>";
?>
