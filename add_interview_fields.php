<?php
/**
 * Add Missing Fields to Interviews Table
 * Adds comprehensive interview scheduling fields
 */

$conn = new mysqli('localhost', 'root', '', 'cmsadver_rmsdb');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<!DOCTYPE html><html><head><title>Add Interview Fields</title>";
echo "<style>
body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
.success { background: #e8f5e9; padding: 15px; border-left: 4px solid #4caf50; margin: 10px 0; border-radius: 4px; }
.error { background: #ffebee; padding: 15px; border-left: 4px solid #f44336; margin: 10px 0; border-radius: 4px; }
.info { background: #e3f2fd; padding: 15px; border-left: 4px solid #2196f3; margin: 10px 0; border-radius: 4px; }
h1 { color: #667eea; }
</style></head><body>";

echo "<h1>🔧 Adding Interview Scheduling Fields</h1>";

// Check existing columns
$result = $conn->query("DESCRIBE interviews");
$existing_columns = [];
while ($row = $result->fetch_assoc()) {
    $existing_columns[] = $row['Field'];
}

echo "<div class='info'><strong>Existing columns:</strong> " . implode(', ', $existing_columns) . "</div>";

// Fields to add
$fields_to_add = [
    "interview_date DATE NULL COMMENT 'Interview date'",
    "interview_start_time TIME NULL COMMENT 'Start time'",
    "interview_end_time TIME NULL COMMENT 'End time'",
    "interview_duration INT DEFAULT 60 COMMENT 'Duration in minutes'",
    "interview_type ENUM('online', 'in_person', 'phone') DEFAULT 'online' COMMENT 'Interview mode'",
    "interview_round VARCHAR(100) DEFAULT 'Round 1' COMMENT 'Interview round (Round 1, Technical, HR, Final)'",
    "online_platform VARCHAR(50) NULL COMMENT 'Zoom, Google Meet, Teams, etc'",
    "meeting_link TEXT NULL COMMENT 'Online meeting link'",
    "meeting_id VARCHAR(255) NULL COMMENT 'Meeting ID/Room ID'",
    "meeting_password VARCHAR(255) NULL COMMENT 'Meeting password'",
    "venue_location TEXT NULL COMMENT 'Physical location for in-person interviews'",
    "venue_room VARCHAR(100) NULL COMMENT 'Room number/name'",
    "phone_number VARCHAR(50) NULL COMMENT 'Phone number for phone interviews'",
    "assigned_interviewer VARCHAR(255) NULL COMMENT 'Interviewer username'",
    "assigned_interviewer_id INT NULL COMMENT 'Interviewer user ID'",
    "job_position VARCHAR(255) NULL COMMENT 'Job position/vacancy'",
    "job_id INT NULL COMMENT 'Job posting ID if applicable'",
    "interview_notes TEXT NULL COMMENT 'Instructions/notes for candidate'",
    "internal_notes TEXT NULL COMMENT 'Internal notes (not visible to candidate)'",
    "send_whatsapp TINYINT(1) DEFAULT 0 COMMENT 'Send WhatsApp notification'",
    "calendar_synced TINYINT(1) DEFAULT 0 COMMENT 'Synced to Google Calendar'",
    "calendar_event_id VARCHAR(255) NULL COMMENT 'Google Calendar event ID'",
    "reminder_sent TINYINT(1) DEFAULT 0 COMMENT 'Reminder email sent'",
    "timezone VARCHAR(50) DEFAULT 'Asia/Colombo' COMMENT 'Timezone for interview'"
];

$added_count = 0;
$skipped_count = 0;

foreach ($fields_to_add as $field_def) {
    // Extract field name
    preg_match('/^(\w+)/', $field_def, $matches);
    $field_name = $matches[1];
    
    if (in_array($field_name, $existing_columns)) {
        echo "<div class='info'>⏭️ Skipped: <strong>$field_name</strong> (already exists)</div>";
        $skipped_count++;
        continue;
    }
    
    $sql = "ALTER TABLE interviews ADD COLUMN $field_def";
    
    if ($conn->query($sql)) {
        echo "<div class='success'>✅ Added: <strong>$field_name</strong></div>";
        $added_count++;
    } else {
        echo "<div class='error'>❌ Failed to add <strong>$field_name</strong>: " . $conn->error . "</div>";
    }
}

echo "<hr>";
echo "<div class='success'>";
echo "<h2>✅ Summary</h2>";
echo "<p><strong>Fields added:</strong> $added_count</p>";
echo "<p><strong>Fields skipped:</strong> $skipped_count</p>";
echo "</div>";

// Show updated structure
echo "<h2>📋 Updated Table Structure</h2>";
$result = $conn->query("DESCRIBE interviews");
echo "<table border='1' cellpadding='10' style='border-collapse: collapse; width: 100%; background: white;'>";
echo "<tr style='background: #667eea; color: white;'><th>Field</th><th>Type</th><th>Null</th><th>Default</th><th>Comment</th></tr>";
while ($row = $result->fetch_assoc()) {
    // Get column comment
    $comment_query = $conn->query("SELECT COLUMN_COMMENT FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'cmsadver_rmsdb' AND TABLE_NAME = 'interviews' AND COLUMN_NAME = '{$row['Field']}'");
    $comment = $comment_query ? $comment_query->fetch_assoc()['COLUMN_COMMENT'] : '';
    
    echo "<tr>";
    echo "<td><strong>{$row['Field']}</strong></td>";
    echo "<td>{$row['Type']}</td>";
    echo "<td>{$row['Null']}</td>";
    echo "<td>{$row['Default']}</td>";
    echo "<td style='color: #666; font-size: 12px;'>$comment</td>";
    echo "</tr>";
}
echo "</table>";

echo "<div style='margin: 30px 0; text-align: center;'>";
echo "<a href='http://localhost/rms/interview/create_interview' style='padding: 15px 30px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border-radius: 8px; font-weight: 600; display: inline-block;'>";
echo "🎯 Go to Enhanced Create Interview Form";
echo "</a>";
echo "</div>";

echo "</body></html>";

$conn->close();
?>
