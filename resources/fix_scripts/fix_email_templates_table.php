<?php
/**
 * Fix Email Templates Table - Add missing columns
 */

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'rmsdb';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>Fixing Email Templates Table</h2>";
echo "<style>
    body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
    .success { color: green; padding: 10px; background: #d4edda; margin: 10px 0; border-radius: 5px; }
    .info { color: blue; padding: 10px; background: #d1ecf1; margin: 10px 0; border-radius: 5px; }
</style>";

// Check if is_active column exists
$check = $conn->query("SHOW COLUMNS FROM email_templates LIKE 'is_active'");
if ($check->num_rows == 0) {
    // Add is_active column
    $sql = "ALTER TABLE email_templates ADD COLUMN is_active tinyint(1) DEFAULT 1 AFTER template_type";
    if ($conn->query($sql) === TRUE) {
        echo "<div class='success'>✓ Added 'is_active' column to email_templates</div>";
    } else {
        echo "<div class='info'>Note: " . $conn->error . "</div>";
    }
} else {
    echo "<div class='info'>✓ Column 'is_active' already exists</div>";
}

// Check if body_html column exists (should be used instead of content)
$check = $conn->query("SHOW COLUMNS FROM email_templates LIKE 'body_html'");
if ($check->num_rows == 0) {
    // Check if content column exists
    $check_content = $conn->query("SHOW COLUMNS FROM email_templates LIKE 'content'");
    if ($check_content->num_rows > 0) {
        // Rename content to body_html
        $sql = "ALTER TABLE email_templates CHANGE COLUMN content body_html text NOT NULL";
        if ($conn->query($sql) === TRUE) {
            echo "<div class='success'>✓ Renamed 'content' column to 'body_html'</div>";
        }
    } else {
        // Add body_html column
        $sql = "ALTER TABLE email_templates ADD COLUMN body_html text NOT NULL AFTER subject";
        if ($conn->query($sql) === TRUE) {
            echo "<div class='success'>✓ Added 'body_html' column to email_templates</div>";
        }
    }
} else {
    echo "<div class='info'>✓ Column 'body_html' already exists</div>";
}

// Check if category column exists
$check = $conn->query("SHOW COLUMNS FROM email_templates LIKE 'category'");
if ($check->num_rows == 0) {
    // Check if template_type exists
    $check_type = $conn->query("SHOW COLUMNS FROM email_templates LIKE 'template_type'");
    if ($check_type->num_rows > 0) {
        // Rename template_type to category
        $sql = "ALTER TABLE email_templates CHANGE COLUMN template_type category varchar(100)";
        if ($conn->query($sql) === TRUE) {
            echo "<div class='success'>✓ Renamed 'template_type' column to 'category'</div>";
        }
    } else {
        // Add category column
        $sql = "ALTER TABLE email_templates ADD COLUMN category varchar(100) AFTER body_html";
        if ($conn->query($sql) === TRUE) {
            echo "<div class='success'>✓ Added 'category' column to email_templates</div>";
        }
    }
} else {
    echo "<div class='info'>✓ Column 'category' already exists</div>";
}

// Update existing templates to be active
$conn->query("UPDATE email_templates SET is_active = 1 WHERE is_active IS NULL");

echo "<hr>";
echo "<div class='success'><strong>Table structure fixed successfully!</strong></div>";
echo "<p><a href='http://localhost/rms/Marketing_campaigns/email_campaigns' style='display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 5px;'>View Email Campaigns</a></p>";

$conn->close();
?>
