<?php
// Direct test of chat interface view
error_reporting(E_ALL);
ini_set('display_errors', 1);

$title = "Test Bot Interface";

// Simple base_url function for testing
function base_url($uri = '') {
    $base = 'http://' . $_SERVER['HTTP_HOST'] . '/rms/';
    return $base . $uri;
}

// Load the view directly
include 'application/views/bot/chat_interface.php';
?>
