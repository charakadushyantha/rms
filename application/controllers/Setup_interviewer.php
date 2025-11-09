<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup_interviewer extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function index() {
        echo "<h1>🚀 Setting up Interviewer & Candidate Portal Tables</h1>";
        echo "<style>
            body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
            .success { color: green; font-weight: bold; }
            .error { color: red; font-weight: bold; }
            .info { color: blue; }
            table { border-collapse: collapse; width: 100%; margin: 20px 0; background: white; }
            th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
            th { background: #667eea; color: white; }
        </style>";

        // 1. Interview Assignments Table
        $sql = "CREATE TABLE IF NOT EXISTS `interview_assignments` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `interview_id` INT(11) NOT NULL,
            `interviewer_username` VARCHAR(100) NOT NULL,
            `candidate_id` INT(11) NOT NULL,
            `status` ENUM('pending', 'accepted', 'declined', 'completed') DEFAULT 'pending',
            `assigned_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
            `responded_at` DATETIME NULL,
            `notes` TEXT NULL,
            PRIMARY KEY (`id`),
            KEY `interviewer_username` (`interviewer_username`),
            KEY `interview_id` (`interview_id`),
            KEY `candidate_id` (`candidate_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

        if ($this->db->query($sql)) {
            echo "<p class='success'>✅ Table 'interview_assignments' created successfully!</p>";
        } else {
            echo "<p class='error'>❌ Error creating interview_assignments: " . $this->db->error()['message'] . "</p>";
        }

        // 2. Interviewer Feedback Table
        $sql = "CREATE TABLE IF NOT EXISTS `interviewer_feedback` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `interview_id` INT(11) NOT NULL,
            `interviewer_username` VARCHAR(100) NOT NULL,
            `candidate_id` INT(11) NOT NULL,
            `technical_skills` INT(1) DEFAULT NULL COMMENT '1-5 rating',
            `communication` INT(1) DEFAULT NULL COMMENT '1-5 rating',
            `problem_solving` INT(1) DEFAULT NULL COMMENT '1-5 rating',
            `cultural_fit` INT(1) DEFAULT NULL COMMENT '1-5 rating',
            `overall_rating` INT(1) DEFAULT NULL COMMENT '1-5 rating',
            `strengths` TEXT NULL,
            `weaknesses` TEXT NULL,
            `detailed_feedback` TEXT NULL,
            `recommendation` ENUM('strong_hire', 'hire', 'maybe', 'no_hire', 'strong_no_hire') DEFAULT NULL,
            `submitted_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
            `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `interview_id` (`interview_id`),
            KEY `interviewer_username` (`interviewer_username`),
            KEY `candidate_id` (`candidate_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

        if ($this->db->query($sql)) {
            echo "<p class='success'>✅ Table 'interviewer_feedback' created successfully!</p>";
        } else {
            echo "<p class='error'>❌ Error creating interviewer_feedback: " . $this->db->error()['message'] . "</p>";
        }

        // 3. Candidate Applications Table
        $sql = "CREATE TABLE IF NOT EXISTS `candidate_applications` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `candidate_username` VARCHAR(100) NOT NULL,
            `job_id` INT(11) NOT NULL,
            `job_title` VARCHAR(255) NOT NULL,
            `status` ENUM('applied', 'screening', 'interview_scheduled', 'interviewed', 'offer_extended', 'hired', 'rejected', 'withdrawn') DEFAULT 'applied',
            `applied_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
            `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `notes` TEXT NULL,
            PRIMARY KEY (`id`),
            KEY `candidate_username` (`candidate_username`),
            KEY `job_id` (`job_id`),
            KEY `status` (`status`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

        if ($this->db->query($sql)) {
            echo "<p class='success'>✅ Table 'candidate_applications' created successfully!</p>";
        } else {
            echo "<p class='error'>❌ Error creating candidate_applications: " . $this->db->error()['message'] . "</p>";
        }

        // 4. Candidate Documents Table
        $sql = "CREATE TABLE IF NOT EXISTS `candidate_documents` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `candidate_username` VARCHAR(100) NOT NULL,
            `document_type` ENUM('resume', 'cover_letter', 'certificate', 'portfolio', 'other') NOT NULL,
            `file_name` VARCHAR(255) NOT NULL,
            `file_path` VARCHAR(500) NOT NULL,
            `file_size` INT(11) NOT NULL COMMENT 'in bytes',
            `uploaded_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `candidate_username` (`candidate_username`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

        if ($this->db->query($sql)) {
            echo "<p class='success'>✅ Table 'candidate_documents' created successfully!</p>";
        } else {
            echo "<p class='error'>❌ Error creating candidate_documents: " . $this->db->error()['message'] . "</p>";
        }

        // 5. Interview Confirmations Table
        $sql = "CREATE TABLE IF NOT EXISTS `interview_confirmations` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `interview_id` INT(11) NOT NULL,
            `candidate_username` VARCHAR(100) NOT NULL,
            `status` ENUM('pending', 'confirmed', 'declined', 'reschedule_requested') DEFAULT 'pending',
            `confirmed_at` DATETIME NULL,
            `reschedule_reason` TEXT NULL,
            `preferred_dates` TEXT NULL COMMENT 'JSON array of preferred dates',
            PRIMARY KEY (`id`),
            KEY `interview_id` (`interview_id`),
            KEY `candidate_username` (`candidate_username`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

        if ($this->db->query($sql)) {
            echo "<p class='success'>✅ Table 'interview_confirmations' created successfully!</p>";
        } else {
            echo "<p class='error'>❌ Error creating interview_confirmations: " . $this->db->error()['message'] . "</p>";
        }

        // 6. Messages Table
        $sql = "CREATE TABLE IF NOT EXISTS `messages` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `from_username` VARCHAR(100) NOT NULL,
            `to_username` VARCHAR(100) NOT NULL,
            `subject` VARCHAR(255) NOT NULL,
            `message` TEXT NOT NULL,
            `is_read` TINYINT(1) DEFAULT 0,
            `sent_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
            `read_at` DATETIME NULL,
            `parent_message_id` INT(11) NULL COMMENT 'For threading',
            PRIMARY KEY (`id`),
            KEY `from_username` (`from_username`),
            KEY `to_username` (`to_username`),
            KEY `is_read` (`is_read`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

        if ($this->db->query($sql)) {
            echo "<p class='success'>✅ Table 'messages' created successfully!</p>";
        } else {
            echo "<p class='error'>❌ Error creating messages: " . $this->db->error()['message'] . "</p>";
        }

        // 7. Interviewer Availability Table
        $sql = "CREATE TABLE IF NOT EXISTS `interviewer_availability` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `interviewer_username` VARCHAR(100) NOT NULL,
            `day_of_week` TINYINT(1) NOT NULL COMMENT '0=Sunday, 6=Saturday',
            `start_time` TIME NOT NULL,
            `end_time` TIME NOT NULL,
            `is_available` TINYINT(1) DEFAULT 1,
            PRIMARY KEY (`id`),
            KEY `interviewer_username` (`interviewer_username`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

        if ($this->db->query($sql)) {
            echo "<p class='success'>✅ Table 'interviewer_availability' created successfully!</p>";
        } else {
            echo "<p class='error'>❌ Error creating interviewer_availability: " . $this->db->error()['message'] . "</p>";
        }

        echo "<hr>";
        echo "<h2>✅ Database Setup Complete!</h2>";
        echo "<p class='info'>All tables have been created successfully.</p>";

        echo "<h3>📋 Created Tables:</h3>";
        echo "<ul>";
        echo "<li>✅ interview_assignments</li>";
        echo "<li>✅ interviewer_feedback</li>";
        echo "<li>✅ candidate_applications</li>";
        echo "<li>✅ candidate_documents</li>";
        echo "<li>✅ interview_confirmations</li>";
        echo "<li>✅ messages</li>";
        echo "<li>✅ interviewer_availability</li>";
        echo "</ul>";

        echo "<h3>🎯 Next Steps:</h3>";
        echo "<ol>";
        echo "<li>✅ Database tables created</li>";
        echo "<li>🔄 <a href='" . base_url('Setup_interviewer/add_sample_data') . "'>Add Sample Data</a></li>";
        echo "<li>🎨 <a href='" . base_url('I_dashboard') . "'>Open Interviewer Dashboard</a></li>";
        echo "</ol>";
    }

    public function add_sample_data() {
        echo "<h1>📊 Adding Sample Data</h1>";
        echo "<style>
            body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
            .success { color: green; font-weight: bold; }
            .error { color: red; font-weight: bold; }
        </style>";

        // Add sample interview assignment
        $sample_assignment = [
            'interview_id' => 1,
            'interviewer_username' => 'interviewer1',
            'candidate_id' => 1,
            'status' => 'pending',
            'assigned_at' => date('Y-m-d H:i:s', strtotime('+2 days'))
        ];

        if ($this->db->insert('interview_assignments', $sample_assignment)) {
            echo "<p class='success'>✅ Sample interview assignment added</p>";
        } else {
            echo "<p class='error'>❌ Error adding sample data</p>";
        }

        echo "<hr>";
        echo "<h3>🎯 Next Steps:</h3>";
        echo "<p><a href='" . base_url('I_dashboard') . "'>Open Interviewer Dashboard</a></p>";
    }
}
