<?php
/**
 * Create Questions Bank Database Tables
 * Interview Questions Management System
 */

require_once __DIR__ . '/config/database.php';

try {
    $conn = getDatabaseConnection();
    echo "<h2>Creating Questions Bank Tables</h2>";
    echo "<style>body{font-family:Arial;padding:20px;} .success{color:green;} .error{color:red;}</style>";
    
    // Question Categories Table
    $sql = "CREATE TABLE IF NOT EXISTS question_categories (
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(100) NOT NULL,
        description TEXT,
        type ENUM('mandatory', 'role_specific', 'optional') DEFAULT 'role_specific',
        is_active BOOLEAN DEFAULT TRUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_type (type),
        INDEX idx_active (is_active)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($sql)) {
        echo "<p class='success'>✓ question_categories table created</p>";
    } else {
        echo "<p class='error'>✗ Error: " . $conn->error . "</p>";
    }
    
    // Job Roles Table
    $sql = "CREATE TABLE IF NOT EXISTS job_roles (
        id INT PRIMARY KEY AUTO_INCREMENT,
        title VARCHAR(255) NOT NULL,
        description TEXT,
        department VARCHAR(100),
        is_active BOOLEAN DEFAULT TRUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_title (title),
        INDEX idx_active (is_active)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($sql)) {
        echo "<p class='success'>✓ job_roles table created</p>";
    } else {
        echo "<p class='error'>✗ Error: " . $conn->error . "</p>";
    }
    
    // Questions Bank Table
    $sql = "CREATE TABLE IF NOT EXISTS questions_bank (
        id INT PRIMARY KEY AUTO_INCREMENT,
        question_text TEXT NOT NULL,
        question_type ENUM('mcq_single', 'mcq_multiple', 'text', 'rating') DEFAULT 'mcq_single',
        category_id INT,
        difficulty ENUM('easy', 'medium', 'hard') DEFAULT 'medium',
        points INT DEFAULT 1,
        time_limit INT DEFAULT 120 COMMENT 'Time in seconds',
        is_mandatory BOOLEAN DEFAULT FALSE,
        is_active BOOLEAN DEFAULT TRUE,
        created_by INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_category (category_id),
        INDEX idx_type (question_type),
        INDEX idx_difficulty (difficulty),
        INDEX idx_mandatory (is_mandatory),
        INDEX idx_active (is_active),
        FOREIGN KEY (category_id) REFERENCES question_categories(id) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($sql)) {
        echo "<p class='success'>✓ questions_bank table created</p>";
    } else {
        echo "<p class='error'>✗ Error: " . $conn->error . "</p>";
    }
    
    // Question Options Table (for MCQ)
    $sql = "CREATE TABLE IF NOT EXISTS question_options (
        id INT PRIMARY KEY AUTO_INCREMENT,
        question_id INT NOT NULL,
        option_text TEXT NOT NULL,
        is_correct BOOLEAN DEFAULT FALSE,
        option_order INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_question (question_id),
        INDEX idx_correct (is_correct),
        FOREIGN KEY (question_id) REFERENCES questions_bank(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($sql)) {
        echo "<p class='success'>✓ question_options table created</p>";
    } else {
        echo "<p class='error'>✗ Error: " . $conn->error . "</p>";
    }
    
    // Question-Role Mapping Table
    $sql = "CREATE TABLE IF NOT EXISTS question_role_mapping (
        id INT PRIMARY KEY AUTO_INCREMENT,
        question_id INT NOT NULL,
        role_id INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY unique_mapping (question_id, role_id),
        INDEX idx_question (question_id),
        INDEX idx_role (role_id),
        FOREIGN KEY (question_id) REFERENCES questions_bank(id) ON DELETE CASCADE,
        FOREIGN KEY (role_id) REFERENCES job_roles(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($sql)) {
        echo "<p class='success'>✓ question_role_mapping table created</p>";
    } else {
        echo "<p class='error'>✗ Error: " . $conn->error . "</p>";
    }
    
    // Interview Question Sets Table
    $sql = "CREATE TABLE IF NOT EXISTS interview_question_sets (
        id INT PRIMARY KEY AUTO_INCREMENT,
        interview_id INT NOT NULL,
        question_id INT NOT NULL,
        question_order INT DEFAULT 0,
        candidate_answer TEXT,
        selected_options JSON COMMENT 'Array of selected option IDs',
        is_correct BOOLEAN,
        points_earned INT DEFAULT 0,
        time_taken INT DEFAULT 0 COMMENT 'Time in seconds',
        answered_at TIMESTAMP NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_interview (interview_id),
        INDEX idx_question (question_id),
        FOREIGN KEY (interview_id) REFERENCES interviews(id) ON DELETE CASCADE,
        FOREIGN KEY (question_id) REFERENCES questions_bank(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($sql)) {
        echo "<p class='success'>✓ interview_question_sets table created</p>";
    } else {
        echo "<p class='error'>✗ Error: " . $conn->error . "</p>";
    }
    
    // Question Tags Table
    $sql = "CREATE TABLE IF NOT EXISTS question_tags (
        id INT PRIMARY KEY AUTO_INCREMENT,
        tag_name VARCHAR(50) NOT NULL UNIQUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_tag (tag_name)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($sql)) {
        echo "<p class='success'>✓ question_tags table created</p>";
    } else {
        echo "<p class='error'>✗ Error: " . $conn->error . "</p>";
    }
    
    // Question-Tag Mapping Table
    $sql = "CREATE TABLE IF NOT EXISTS question_tag_mapping (
        id INT PRIMARY KEY AUTO_INCREMENT,
        question_id INT NOT NULL,
        tag_id INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY unique_tag_mapping (question_id, tag_id),
        INDEX idx_question (question_id),
        INDEX idx_tag (tag_id),
        FOREIGN KEY (question_id) REFERENCES questions_bank(id) ON DELETE CASCADE,
        FOREIGN KEY (tag_id) REFERENCES question_tags(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($sql)) {
        echo "<p class='success'>✓ question_tag_mapping table created</p>";
    } else {
        echo "<p class='error'>✗ Error: " . $conn->error . "</p>";
    }
    
    echo "<h3>Inserting Sample Data...</h3>";
    
    // Insert sample categories
    $categories = [
        ['Behavioral Questions', 'Questions about past behavior and experiences', 'mandatory'],
        ['Technical Skills', 'Role-specific technical questions', 'role_specific'],
        ['Problem Solving', 'Analytical and problem-solving questions', 'role_specific'],
        ['Communication', 'Communication and interpersonal skills', 'optional'],
        ['Leadership', 'Leadership and management questions', 'optional']
    ];
    
    foreach ($categories as $cat) {
        $stmt = $conn->prepare("INSERT INTO question_categories (name, description, type) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $cat[0], $cat[1], $cat[2]);
        if ($stmt->execute()) {
            echo "<p class='success'>✓ Category added: {$cat[0]}</p>";
        }
    }
    
    // Insert sample job roles
    $roles = [
        ['Software Engineer', 'Develops and maintains software applications', 'Engineering'],
        ['Marketing Manager', 'Manages marketing campaigns and strategies', 'Marketing'],
        ['HR Manager', 'Manages human resources and recruitment', 'Human Resources'],
        ['Sales Executive', 'Handles sales and client relationships', 'Sales'],
        ['Data Analyst', 'Analyzes data and creates reports', 'Analytics']
    ];
    
    foreach ($roles as $role) {
        $stmt = $conn->prepare("INSERT INTO job_roles (title, description, department) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $role[0], $role[1], $role[2]);
        if ($stmt->execute()) {
            echo "<p class='success'>✓ Role added: {$role[0]}</p>";
        }
    }
    
    echo "<h3 class='success'>✅ Questions Bank Setup Complete!</h3>";
    echo "<p>All tables created successfully. You can now:</p>";
    echo "<ul>";
    echo "<li>Add questions to the bank</li>";
    echo "<li>Categorize questions by role and type</li>";
    echo "<li>Generate interview question sets</li>";
    echo "<li>Conduct interviews with automatic scoring</li>";
    echo "</ul>";
    echo "<p><a href='interview/questions_bank' style='padding:10px 20px; background:#667eea; color:white; text-decoration:none; border-radius:5px;'>Go to Questions Bank</a></p>";
    
    $conn->close();
    
} catch (Exception $e) {
    echo "<p class='error'>Error: " . $e->getMessage() . "</p>";
}
?>
