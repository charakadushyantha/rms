<?php
/**
 * Create AI Bot Database Tables
 * Run this script to set up all required tables for the chatbot system
 */

// Use central database configuration
require_once __DIR__ . '/config/database.php';

try {
    $conn = getDatabaseConnection();
    echo "<h2>Creating AI Bot Database Tables</h2>";
    
    // Bot Configuration Table
    $sql = "CREATE TABLE IF NOT EXISTS bot_config (
        id INT PRIMARY KEY AUTO_INCREMENT,
        config_key VARCHAR(100) UNIQUE NOT NULL,
        config_value TEXT,
        config_type ENUM('string', 'json', 'boolean', 'number') DEFAULT 'string',
        description TEXT,
        is_active BOOLEAN DEFAULT TRUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($sql)) {
        echo "<p style='color: green;'>✓ bot_config table created</p>";
    }
    
    // Chat Sessions Table
    $sql = "CREATE TABLE IF NOT EXISTS chat_sessions (
        id INT PRIMARY KEY AUTO_INCREMENT,
        session_id VARCHAR(100) UNIQUE NOT NULL,
        user_id INT,
        user_type ENUM('candidate', 'recruiter', 'interviewer', 'admin', 'guest') DEFAULT 'guest',
        started_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        last_activity TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        is_active BOOLEAN DEFAULT TRUE,
        session_data JSON,
        INDEX idx_user_id (user_id),
        INDEX idx_session_id (session_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($sql)) {
        echo "<p style='color: green;'>✓ chat_sessions table created</p>";
    }
    
    // Chat History Table
    $sql = "CREATE TABLE IF NOT EXISTS chat_history (
        id INT PRIMARY KEY AUTO_INCREMENT,
        session_id VARCHAR(100) NOT NULL,
        user_id INT,
        sender ENUM('user', 'bot') NOT NULL,
        message TEXT NOT NULL,
        intent VARCHAR(50),
        confidence DECIMAL(5,2),
        entities JSON,
        timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        is_read BOOLEAN DEFAULT FALSE,
        INDEX idx_session (session_id),
        INDEX idx_user (user_id),
        INDEX idx_timestamp (timestamp)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($sql)) {
        echo "<p style='color: green;'>✓ chat_history table created</p>";
    }
    
    // Bot Intents Table
    $sql = "CREATE TABLE IF NOT EXISTS bot_intents (
        id INT PRIMARY KEY AUTO_INCREMENT,
        intent_name VARCHAR(50) UNIQUE NOT NULL,
        display_name VARCHAR(100),
        description TEXT,
        training_phrases JSON,
        response_templates JSON,
        action_handler VARCHAR(100),
        priority INT DEFAULT 0,
        is_active BOOLEAN DEFAULT TRUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_intent_name (intent_name)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($sql)) {
        echo "<p style='color: green;'>✓ bot_intents table created</p>";
    }
    
    // Bot Entities Table
    $sql = "CREATE TABLE IF NOT EXISTS bot_entities (
        id INT PRIMARY KEY AUTO_INCREMENT,
        entity_type VARCHAR(50) NOT NULL,
        entity_value TEXT,
        synonyms JSON,
        metadata JSON,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_entity_type (entity_type)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($sql)) {
        echo "<p style='color: green;'>✓ bot_entities table created</p>";
    }
    
    // Knowledge Base Table
    $sql = "CREATE TABLE IF NOT EXISTS knowledge_base (
        id INT PRIMARY KEY AUTO_INCREMENT,
        category VARCHAR(50) NOT NULL,
        question TEXT NOT NULL,
        answer TEXT NOT NULL,
        keywords JSON,
        relevance_score INT DEFAULT 0,
        usage_count INT DEFAULT 0,
        is_active BOOLEAN DEFAULT TRUE,
        created_by INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_category (category),
        FULLTEXT idx_question (question)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($sql)) {
        echo "<p style='color: green;'>✓ knowledge_base table created</p>";
    }
    
    // CV Processing History Table
    $sql = "CREATE TABLE IF NOT EXISTS cv_processing_history (
        id INT PRIMARY KEY AUTO_INCREMENT,
        candidate_id INT,
        file_path VARCHAR(255),
        file_type VARCHAR(20),
        processing_status ENUM('pending', 'processing', 'completed', 'failed') DEFAULT 'pending',
        extracted_data JSON,
        confidence_scores JSON,
        processing_time_ms INT,
        error_message TEXT,
        processed_at TIMESTAMP,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_candidate (candidate_id),
        INDEX idx_status (processing_status)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($sql)) {
        echo "<p style='color: green;'>✓ cv_processing_history table created</p>";
    }
    
    // Bot Analytics Table
    $sql = "CREATE TABLE IF NOT EXISTS bot_analytics (
        id INT PRIMARY KEY AUTO_INCREMENT,
        event_type VARCHAR(50) NOT NULL,
        event_data JSON,
        user_id INT,
        session_id VARCHAR(100),
        timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_event_type (event_type),
        INDEX idx_timestamp (timestamp),
        INDEX idx_user (user_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($sql)) {
        echo "<p style='color: green;'>✓ bot_analytics table created</p>";
    }
    
    // Bot Feedback Table
    $sql = "CREATE TABLE IF NOT EXISTS bot_feedback (
        id INT PRIMARY KEY AUTO_INCREMENT,
        session_id VARCHAR(100),
        message_id INT,
        user_id INT,
        rating ENUM('helpful', 'not_helpful') NOT NULL,
        feedback_text TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_session (session_id),
        INDEX idx_rating (rating)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($sql)) {
        echo "<p style='color: green;'>✓ bot_feedback table created</p>";
    }
    
    echo "<hr>";
    echo "<h3>Inserting Sample Data...</h3>";
    
    // Insert sample bot configuration
    $configs = [
        ['bot_name', 'RecruitBot', 'string', 'Display name of the bot'],
        ['welcome_message', 'Hi! 👋 I\'m RecruitBot, your AI recruitment assistant. How can I help you today?', 'string', 'Initial greeting message'],
        ['ai_provider', 'openai', 'string', 'AI service provider (openai, claude, local)'],
        ['ai_model', 'gpt-4', 'string', 'AI model to use'],
        ['max_conversation_history', '10', 'number', 'Number of messages to keep in context'],
        ['enable_cv_parsing', 'true', 'boolean', 'Enable automatic CV parsing'],
        ['enable_auto_matching', 'true', 'boolean', 'Enable automatic job matching']
    ];
    
    foreach ($configs as $config) {
        $stmt = $conn->prepare("INSERT IGNORE INTO bot_config (config_key, config_value, config_type, description) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $config[0], $config[1], $config[2], $config[3]);
        $stmt->execute();
    }
    echo "<p style='color: green;'>✓ Sample bot configuration inserted</p>";
    
    // Insert sample intents
    $intents = [
        ['apply_job', 'Job Application', 'User wants to apply for a position', 
         '["I want to apply", "Apply for job", "Submit application", "Upload CV", "I\'d like to join"]', 
         'handle_job_application'],
        ['job_inquiry', 'Job Information', 'User asking about job positions',
         '["What jobs are available", "Open positions", "Tell me about roles", "Job vacancies"]',
         'handle_job_inquiry'],
        ['status_check', 'Application Status', 'User checking application status',
         '["What\'s my status", "Application progress", "Where is my application", "Any updates"]',
         'handle_status_check'],
        ['company_info', 'Company Information', 'User asking about company',
         '["Tell me about company", "Company culture", "Office location", "About your organization"]',
         'handle_company_info']
    ];
    
    foreach ($intents as $intent) {
        $stmt = $conn->prepare("INSERT IGNORE INTO bot_intents (intent_name, display_name, description, training_phrases, action_handler) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $intent[0], $intent[1], $intent[2], $intent[3], $intent[4]);
        $stmt->execute();
    }
    echo "<p style='color: green;'>✓ Sample intents inserted</p>";
    
    // Insert sample knowledge base
    $kb_items = [
        ['company', 'What is your company about?', 
         'We are a leading technology company specializing in innovative solutions for businesses across Sri Lanka and beyond. Our mission is to empower organizations through cutting-edge technology.',
         '["company", "about", "mission", "what do you do"]'],
        ['process', 'How long does the hiring process take?',
         'Our typical hiring process takes 2-3 weeks from application to final decision. This includes CV review (2-3 days), initial interview (within 1 week), technical assessment (if applicable), and final interview.',
         '["timeline", "how long", "hiring process", "duration"]'],
        ['benefits', 'What benefits do you offer?',
         'We offer comprehensive benefits including competitive salary, health insurance, annual leave, professional development opportunities, flexible work arrangements, and performance bonuses.',
         '["benefits", "perks", "salary", "compensation", "insurance"]']
    ];
    
    foreach ($kb_items as $item) {
        $stmt = $conn->prepare("INSERT IGNORE INTO knowledge_base (category, question, answer, keywords) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $item[0], $item[1], $item[2], $item[3]);
        $stmt->execute();
    }
    echo "<p style='color: green;'>✓ Sample knowledge base inserted</p>";
    
    echo "<hr>";
    echo "<h3 style='color: green;'>✅ All tables created successfully!</h3>";
    echo "<p>Your AI Bot database is ready to use.</p>";
    
    $conn->close();
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>
