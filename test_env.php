<?php
// Quick environment detection test
// DELETE THIS FILE AFTER TESTING!

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Environment Detection Test</h2>";

echo "<h3>System Information:</h3>";
echo "Operating System: <strong>" . PHP_OS . "</strong><br>";
echo "Is Windows: <strong>" . (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? 'YES' : 'NO') . "</strong><br>";
echo "HTTP_HOST: <strong>" . $_SERVER['HTTP_HOST'] . "</strong><br>";
echo "DOCUMENT_ROOT: <strong>" . $_SERVER['DOCUMENT_ROOT'] . "</strong><br>";

echo "<h3>Detection Logic:</h3>";

$current_domain = $_SERVER['HTTP_HOST'];
$is_production = false;

// Check domain
if (strpos($current_domain, 'lankantech.com') !== false) {
    echo "✅ Domain contains 'lankantech.com' → PRODUCTION<br>";
    $is_production = true;
} else {
    echo "❌ Domain does NOT contain 'lankantech.com'<br>";
}

// Check server path
if (isset($_SERVER['DOCUMENT_ROOT']) && strpos($_SERVER['DOCUMENT_ROOT'], '/home/cmsadver') !== false) {
    echo "✅ Path contains '/home/cmsadver' → PRODUCTION<br>";
    $is_production = true;
} else {
    echo "❌ Path does NOT contain '/home/cmsadver'<br>";
}

// Check localhost
if (in_array($current_domain, ['localhost', '127.0.0.1', 'localhost:80', 'localhost:8080'])) {
    echo "✅ Domain is localhost → DEVELOPMENT (forced)<br>";
    $is_production = false;
}

// Check Windows
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    echo "✅ Running on Windows → DEVELOPMENT (forced)<br>";
    $is_production = false;
}

echo "<br><h3>Final Result:</h3>";
if ($is_production) {
    echo "<div style='background:#ffebee; padding:15px; border:2px solid #f44336;'>";
    echo "<strong style='color:#f44336;'>PRODUCTION ENVIRONMENT</strong><br>";
    echo "Database: cmsadver_rmsdbuser@localhost<br>";
    echo "URL: https://rms.lankantech.com/";
    echo "</div>";
} else {
    echo "<div style='background:#e8f5e9; padding:15px; border:2px solid #4caf50;'>";
    echo "<strong style='color:#4caf50;'>DEVELOPMENT ENVIRONMENT</strong><br>";
    echo "Database: root@localhost (no password)<br>";
    echo "URL: http://localhost/rms/";
    echo "</div>";
}

echo "<br><h3>Next Steps:</h3>";
if ($is_production) {
    echo "<p style='color:red;'>⚠️ Environment detection is WRONG! You're on localhost but it detected production.</p>";
    echo "<p>This should not happen with the updated environment.php</p>";
} else {
    echo "<p style='color:green;'>✅ Environment detection is CORRECT!</p>";
    echo "<p>Now run: <a href='setup_local_db.php'>setup_local_db.php</a> to set up your database.</p>";
}

echo "<br><p style='background:#ffe6e6; padding:10px; border:1px solid #ff0000;'>";
echo "<strong>⚠️ DELETE THIS FILE:</strong> test_env.php";
echo "</p>";
?>
