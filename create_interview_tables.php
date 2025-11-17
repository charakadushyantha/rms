<?php
/**
 * Create Interview System Tables
 */

require_once __DIR__ . '/config/database.php';

try {
    $conn = getDatabaseConnection();
    echo "<h2>Creating Interview System Tables</h2>";
    echo "<style>body{font-family:Arial;padding:20px;} .success{color:green;} .error{color:red;}</style>";
    
    // Interview Flows Table
    $sql = "CREATE TABLE IF NOT EXISTS interview_flows (
        id INT PRIMARY KEY AUTO_INCREMENT,
        job_title VARCHAR(255) NOT NULL,
        job_description TEXT,
        questions JSON NOT NULL,
        interview_type ENUM('video', 'audio', 'text') DEFAULT 'video',
        enable_video_capture BOOLEAN DEFAULT FALSE,
        duration_minutes INT DEFAULT 30,
        passing_score INT DEFAULT 70,
        status ENUM('active', 'inactive', 'archived') DEFAULT 'active',
        created_by INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_status (status),
        INDEX idx_created_at (created_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($sql)) {
        echo "<p class='success'>✓ interview_flows table created</p>";
    } else {
        echo "<p class='error'>✗ Error creating interview_flows: " . $conn->error . "</p>";
    }
    
    // Interviews Table
    $sql = "CREATE TABLE IF NOT EXISTS interviews (
        id INT PRIMARY KEY AUTO_INCREMENT,
        flow_id INT NOT NULL,
        candidate_name VARCHAR(255),
        candidate_email VARCHAR(255) NOT NULL,
        candidate_phone VARCHAR(50),
        token VARCHAR(255) UNIQUE NOT NULL,
        status ENUM('pending', 'in_progress', 'completed', 'cancelled', 'expired') DEFAULT 'pending',
        score INT,
        started_at TIMESTAMP NULL,
        completed_at TIMESTAMP NULL,
        expires_at TIMESTAMP NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_token (token),
        INDEX idx_flow_id (flow_id),
        INDEX idx_status (status),
        INDEX idx_candidate_email (candidate_email),
        FOREIGN KEY (flow_id) REFERENCES interview_flows(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($sql)) {
        echo "<p class='success'>✓ interviews table created</p>";
    } else {
        echo "<p class='error'>✗ Error creating interviews: " . $conn->error . "</p>";
    }
    
    // Interview Responses Table
    $sql = "CREATE TABLE IF NOT EXISTS interview_responses (
        id INT PRIMARY KEY AUTO_INCREMENT,
        interview_id INT NOT NULL,
        question_id INT NOT NULL,
        response_text TEXT,
        response_audio VARCHAR(255),
        response_video VARCHAR(255),
        duration_seconds INT DEFAULT 0,
        score INT,
        feedback TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_interview_id (interview_id),
        INDEX idx_question_id (question_id),
        FOREIGN KEY (interview_id) REFERENCES interviews(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($sql)) {
        echo "<p class='success'>✓ interview_responses table created</p>";
    } else {
        echo "<p class='error'>✗ Error creating interview_responses: " . $conn->error . "</p>";
    }
    
    // Interview Analytics Table
    $sql = "CREATE TABLE IF NOT EXISTS interview_analytics (
        id INT PRIMARY KEY AUTO_INCREMENT,
        interview_id INT NOT NULL,
        event_type VARCHAR(50) NOT NULL,
        event_data JSON,
        timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_interview_id (interview_id),
        INDEX idx_event_type (event_type),
        FOREIGN KEY (interview_id) REFERENCES interviews(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($sql)) {
        echo "<p class='success'>✓ interview_analytics table created</p>";
    } else {
        echo "<p class='error'>✗ Error creating interview_analytics: " . $conn->error . "</p>";
    }
    
    echo "<hr>";
    echo "<h3>Inserting Sample Data...</h3>";
    
    // Sample Interview Flow
    $sample_questions = json_encode([
        [
            'id' => 1,
            'question' => 'Tell us about yourself and your background.',
            'type' => 'open',
            'duration' => 120
        ],
        [
            'id' => 2,
            'question' => 'Why are you interested in this position?',
            'type' => 'open',
            'duration' => 90
        ],
        [
            'id' => 3,
            'question' => 'Describe a challenging project you worked on.',
            'type' => 'open',
            'duration' => 120
        ],
        [
            'id' => 4,
            'question' => 'What are your salary expectations?',
            'type' => 'open',
            'duration' => 60
        ]
    ]);
    
    $stmt = $conn->prepare("INSERT INTO interview_flows (job_title, job_description, questions, interview_type, enable_video_capture, duration_minutes) VALUES (?, ?, ?, ?, ?, ?)");
    
    $job_title = "Software Engineer";
    $job_desc = "We are looking for a talented Software Engineer to join our team.";
    $interview_type = "video";
    $enable_video = 1;
    $duration = 30;
    
    $stmt->bind_param("ssssii", $job_title, $job_desc, $sample_questions, $interview_type, $enable_video, $duration);
    
    if ($stmt->execute()) {
        echo "<p class='success'>✓ Sample interview flow created</p>";
    }
    
    $stmt->close();
    
    echo "<hr>";
    echo "<h3 class='success'>✅ Interview System Setup Complete!</h3>";
    echo "<p>All tables created successfully.</p>";
    
    echo "<hr>";
    echo "<h3>Next Steps:</h3>";
    echo "<ol>";
    echo "<li>Test the API endpoints</li>";
    echo "<li>Create interview flows via API</li>";
    echo "<li>Generate interview links for candidates</li>";
    echo "<li>Review interview responses</li>";
    echo "</ol>";
    
    echo "<p><a href='test_interview_api.php'>Test Interview API</a></p>";
    
    $conn->close();
    
} catch (Exception $e) {
    echo "<p class='error'>Error: " . $e->getMessage() . "</p>";
}
?>
