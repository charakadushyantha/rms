-- =====================================================
-- RMS Integration Expansion - Database Migration
-- =====================================================
-- This script adds tables for:
-- 1. Video Platform Integrations (Zoom, Teams, Google Meet)
-- 2. Assessment Tool Integrations (HackerRank, Codility)
-- 3. Background Check Services
-- 4. ATS Integrations
-- =====================================================

-- =====================================================
-- VIDEO PLATFORM INTEGRATIONS
-- =====================================================

-- Video platform configurations
CREATE TABLE IF NOT EXISTS `video_platform_config` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `platform` VARCHAR(50) NOT NULL UNIQUE COMMENT 'zoom, teams, meet',
  `api_key` VARCHAR(255) DEFAULT NULL,
  `api_secret` VARCHAR(255) DEFAULT NULL,
  `client_id` VARCHAR(255) DEFAULT NULL,
  `client_secret` VARCHAR(255) DEFAULT NULL,
  `tenant_id` VARCHAR(255) DEFAULT NULL,
  `webhook_secret` VARCHAR(255) DEFAULT NULL,
  `is_enabled` TINYINT(1) DEFAULT 0,
  `settings` TEXT COMMENT 'JSON settings',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Video meetings
CREATE TABLE IF NOT EXISTS `video_meetings` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `platform` VARCHAR(50) NOT NULL,
  `meeting_id` VARCHAR(255) NOT NULL,
  `meeting_url` VARCHAR(500) NOT NULL,
  `password` VARCHAR(100) DEFAULT NULL,
  `title` VARCHAR(255) NOT NULL,
  `start_time` DATETIME NOT NULL,
  `duration` INT NOT NULL COMMENT 'Duration in minutes',
  `interview_id` INT DEFAULT NULL,
  `candidate_id` INT DEFAULT NULL,
  `created_by` VARCHAR(100) NOT NULL,
  `status` VARCHAR(50) DEFAULT 'scheduled' COMMENT 'scheduled, started, ended, cancelled',
  `recording_url` VARCHAR(500) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_interview` (`interview_id`),
  INDEX `idx_candidate` (`candidate_id`),
  INDEX `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Video meeting attendees
CREATE TABLE IF NOT EXISTS `video_meeting_attendees` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `meeting_id` INT NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `role` VARCHAR(50) DEFAULT 'attendee' COMMENT 'host, co-host, attendee',
  `join_time` DATETIME DEFAULT NULL,
  `leave_time` DATETIME DEFAULT NULL,
  `duration` INT DEFAULT NULL COMMENT 'Duration in minutes',
  FOREIGN KEY (`meeting_id`) REFERENCES `video_meetings`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- ASSESSMENT TOOL INTEGRATIONS
-- =====================================================

-- Assessment platform configurations
CREATE TABLE IF NOT EXISTS `assessment_platform_config` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `platform` VARCHAR(50) NOT NULL UNIQUE COMMENT 'hackerrank, codility',
  `api_key` VARCHAR(255) NOT NULL,
  `api_secret` VARCHAR(255) DEFAULT NULL,
  `webhook_secret` VARCHAR(255) DEFAULT NULL,
  `is_enabled` TINYINT(1) DEFAULT 0,
  `settings` TEXT COMMENT 'JSON settings',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Assessments sent to candidates
CREATE TABLE IF NOT EXISTS `candidate_assessments` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `platform` VARCHAR(50) NOT NULL,
  `assessment_id` VARCHAR(255) NOT NULL,
  `assessment_url` VARCHAR(500) NOT NULL,
  `candidate_id` INT NOT NULL,
  `candidate_email` VARCHAR(255) NOT NULL,
  `test_id` VARCHAR(255) NOT NULL,
  `test_name` VARCHAR(255) NOT NULL,
  `duration` INT NOT NULL COMMENT 'Duration in minutes',
  `deadline` DATETIME DEFAULT NULL,
  `status` VARCHAR(50) DEFAULT 'sent' COMMENT 'sent, started, completed, expired',
  `score` DECIMAL(5,2) DEFAULT NULL,
  `max_score` DECIMAL(5,2) DEFAULT NULL,
  `percentage` DECIMAL(5,2) DEFAULT NULL,
  `result` VARCHAR(50) DEFAULT NULL COMMENT 'pass, fail, pending',
  `report_url` VARCHAR(500) DEFAULT NULL,
  `started_at` DATETIME DEFAULT NULL,
  `completed_at` DATETIME DEFAULT NULL,
  `created_by` VARCHAR(100) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_candidate` (`candidate_id`),
  INDEX `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Assessment results details
CREATE TABLE IF NOT EXISTS `assessment_results` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `assessment_id` INT NOT NULL,
  `question_id` VARCHAR(255) DEFAULT NULL,
  `question_title` VARCHAR(255) DEFAULT NULL,
  `score` DECIMAL(5,2) DEFAULT NULL,
  `max_score` DECIMAL(5,2) DEFAULT NULL,
  `time_taken` INT DEFAULT NULL COMMENT 'Time in seconds',
  `result_data` TEXT COMMENT 'JSON data',
  FOREIGN KEY (`assessment_id`) REFERENCES `candidate_assessments`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- BACKGROUND CHECK SERVICES
-- =====================================================

-- Background check service configurations
CREATE TABLE IF NOT EXISTS `background_check_config` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `service` VARCHAR(50) NOT NULL UNIQUE COMMENT 'checkr, sterling, accurate',
  `api_key` VARCHAR(255) NOT NULL,
  `client_id` VARCHAR(255) DEFAULT NULL,
  `webhook_url` VARCHAR(500) DEFAULT NULL,
  `is_enabled` TINYINT(1) DEFAULT 0,
  `settings` TEXT COMMENT 'JSON settings',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Background checks
CREATE TABLE IF NOT EXISTS `background_checks` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `service` VARCHAR(50) NOT NULL,
  `check_id` VARCHAR(255) NOT NULL,
  `candidate_id` INT NOT NULL,
  `package_type` VARCHAR(100) NOT NULL,
  `status` VARCHAR(50) DEFAULT 'pending' COMMENT 'pending, in_progress, completed, cancelled, disputed',
  `result` VARCHAR(50) DEFAULT NULL COMMENT 'clear, consider, suspended',
  `report_url` VARCHAR(500) DEFAULT NULL,
  `candidate_info` TEXT COMMENT 'JSON candidate information',
  `check_data` TEXT COMMENT 'JSON check results',
  `initiated_by` VARCHAR(100) NOT NULL,
  `initiated_at` DATETIME NOT NULL,
  `completed_at` DATETIME DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_candidate` (`candidate_id`),
  INDEX `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Background check components
CREATE TABLE IF NOT EXISTS `background_check_components` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `check_id` INT NOT NULL,
  `component_type` VARCHAR(100) NOT NULL COMMENT 'criminal, employment, education, credit, etc',
  `status` VARCHAR(50) DEFAULT 'pending',
  `result` VARCHAR(50) DEFAULT NULL,
  `details` TEXT COMMENT 'JSON details',
  `completed_at` DATETIME DEFAULT NULL,
  FOREIGN KEY (`check_id`) REFERENCES `background_checks`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- ATS INTEGRATIONS
-- =====================================================

-- ATS platform configurations
CREATE TABLE IF NOT EXISTS `ats_platform_config` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `platform` VARCHAR(50) NOT NULL UNIQUE COMMENT 'greenhouse, lever, workday, bamboohr',
  `api_key` VARCHAR(255) DEFAULT NULL,
  `client_id` VARCHAR(255) DEFAULT NULL,
  `client_secret` VARCHAR(255) DEFAULT NULL,
  `tenant_name` VARCHAR(255) DEFAULT NULL,
  `subdomain` VARCHAR(255) DEFAULT NULL,
  `username` VARCHAR(255) DEFAULT NULL,
  `password` VARCHAR(255) DEFAULT NULL,
  `webhook_secret` VARCHAR(255) DEFAULT NULL,
  `is_enabled` TINYINT(1) DEFAULT 0,
  `settings` TEXT COMMENT 'JSON settings',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ATS sync logs
CREATE TABLE IF NOT EXISTS `ats_sync_logs` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `platform` VARCHAR(50) NOT NULL,
  `sync_type` VARCHAR(50) NOT NULL COMMENT 'candidates, jobs, interviews, full',
  `direction` VARCHAR(20) NOT NULL COMMENT 'import, export, bidirectional',
  `status` VARCHAR(50) DEFAULT 'in_progress' COMMENT 'in_progress, completed, failed',
  `records_processed` INT DEFAULT 0,
  `records_success` INT DEFAULT 0,
  `records_failed` INT DEFAULT 0,
  `error_message` TEXT DEFAULT NULL,
  `started_at` DATETIME NOT NULL,
  `completed_at` DATETIME DEFAULT NULL,
  `triggered_by` VARCHAR(100) DEFAULT 'system',
  INDEX `idx_platform` (`platform`),
  INDEX `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ATS field mapping
CREATE TABLE IF NOT EXISTS `ats_field_mapping` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `platform` VARCHAR(50) NOT NULL,
  `local_field` VARCHAR(100) NOT NULL,
  `remote_field` VARCHAR(100) NOT NULL,
  `field_type` VARCHAR(50) DEFAULT 'text',
  `is_required` TINYINT(1) DEFAULT 0,
  `transform_rule` TEXT DEFAULT NULL COMMENT 'JSON transformation rules',
  UNIQUE KEY `unique_mapping` (`platform`, `local_field`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ATS candidate mapping
CREATE TABLE IF NOT EXISTS `ats_candidate_mapping` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `platform` VARCHAR(50) NOT NULL,
  `local_candidate_id` INT NOT NULL,
  `remote_candidate_id` VARCHAR(255) NOT NULL,
  `last_synced_at` DATETIME DEFAULT NULL,
  `sync_status` VARCHAR(50) DEFAULT 'synced',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `unique_candidate_mapping` (`platform`, `local_candidate_id`),
  INDEX `idx_local_candidate` (`local_candidate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ATS job mapping
CREATE TABLE IF NOT EXISTS `ats_job_mapping` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `platform` VARCHAR(50) NOT NULL,
  `local_job_id` INT NOT NULL,
  `remote_job_id` VARCHAR(255) NOT NULL,
  `last_synced_at` DATETIME DEFAULT NULL,
  `sync_status` VARCHAR(50) DEFAULT 'synced',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `unique_job_mapping` (`platform`, `local_job_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- INTEGRATION WEBHOOKS LOG
-- =====================================================

CREATE TABLE IF NOT EXISTS `integration_webhooks` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `integration_type` VARCHAR(50) NOT NULL COMMENT 'video, assessment, background_check, ats',
  `platform` VARCHAR(50) NOT NULL,
  `event_type` VARCHAR(100) NOT NULL,
  `payload` TEXT NOT NULL,
  `status` VARCHAR(50) DEFAULT 'received' COMMENT 'received, processed, failed',
  `error_message` TEXT DEFAULT NULL,
  `processed_at` DATETIME DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_integration` (`integration_type`, `platform`),
  INDEX `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- INTEGRATION USAGE STATISTICS
-- =====================================================

CREATE TABLE IF NOT EXISTS `integration_usage_stats` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `integration_type` VARCHAR(50) NOT NULL,
  `platform` VARCHAR(50) NOT NULL,
  `action` VARCHAR(100) NOT NULL,
  `count` INT DEFAULT 1,
  `date` DATE NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `unique_stat` (`integration_type`, `platform`, `action`, `date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- INSERT DEFAULT CONFIGURATIONS
-- =====================================================

-- Insert default video platform configs
INSERT IGNORE INTO `video_platform_config` (`platform`, `is_enabled`, `settings`) VALUES
('zoom', 0, '{"default_duration": 60, "auto_recording": false, "waiting_room": true, "join_before_host": false}'),
('teams', 0, '{"default_duration": 60, "auto_recording": false, "lobby_enabled": true}'),
('meet', 0, '{"default_duration": 60, "auto_recording": false}');

-- Insert default assessment platform configs
INSERT IGNORE INTO `assessment_platform_config` (`platform`, `api_key`, `is_enabled`, `settings`) VALUES
('hackerrank', '', 0, '{"default_duration": 90, "auto_send": false, "difficulty_level": "medium", "test_type": "coding"}'),
('codility', '', 0, '{"default_duration": 90, "auto_send": false, "test_type": "coding"}');

-- Insert default background check configs
INSERT IGNORE INTO `background_check_config` (`service`, `api_key`, `is_enabled`, `settings`) VALUES
('checkr', '', 0, '{"package_type": "standard", "auto_initiate": false, "check_types": ["criminal", "employment"]}'),
('sterling', '', 0, '{"package_type": "standard", "auto_initiate": false}'),
('accurate', '', 0, '{"package_type": "standard", "auto_initiate": false}');

-- Insert default ATS platform configs
INSERT IGNORE INTO `ats_platform_config` (`platform`, `is_enabled`, `settings`) VALUES
('greenhouse', 0, '{"sync_direction": "bidirectional", "auto_sync": false, "sync_interval": 3600, "sync_candidates": true, "sync_jobs": true, "sync_interviews": true}'),
('lever', 0, '{"sync_direction": "bidirectional", "auto_sync": false, "sync_interval": 3600}'),
('workday', 0, '{"sync_direction": "export", "auto_sync": false}'),
('bamboohr', 0, '{"sync_direction": "export", "auto_sync": false}');

-- =====================================================
-- END OF MIGRATION
-- =====================================================
