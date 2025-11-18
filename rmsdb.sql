-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.32-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for cmsadver_rmsdb
DROP DATABASE IF EXISTS `cmsadver_rmsdb`;
CREATE DATABASE IF NOT EXISTS `cmsadver_rmsdb` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `cmsadver_rmsdb`;

-- Dumping structure for table cmsadver_rmsdb.advocacy_content
DROP TABLE IF EXISTS `advocacy_content`;
CREATE TABLE IF NOT EXISTS `advocacy_content` (
  `content_id` int(11) NOT NULL AUTO_INCREMENT,
  `content_title` varchar(255) NOT NULL,
  `content_type` varchar(50) NOT NULL,
  `content_text` text DEFAULT NULL,
  `content_url` varchar(500) DEFAULT NULL,
  `image_url` varchar(500) DEFAULT NULL,
  `target_platform` varchar(50) DEFAULT NULL,
  `campaign_name` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Draft',
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`content_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.advocacy_content: ~3 rows (approximately)
DELETE FROM `advocacy_content`;
INSERT INTO `advocacy_content` (`content_id`, `content_title`, `content_type`, `content_text`, `content_url`, `image_url`, `target_platform`, `campaign_name`, `status`, `created_by`, `created_at`) VALUES
	(1, 'Join Our Amazing Team!', 'Job Post', 'We are hiring talented engineers! Check out our open positions and join a team that values innovation and collaboration.', NULL, NULL, 'LinkedIn', 'Engineering Hiring 2024', 'Published', 'admin', '2025-11-14 19:23:46'),
	(2, 'Life at Our Company', 'Culture Post', 'What makes our company special? Our people! Learn about our culture, values, and what it is like to work here.', NULL, NULL, 'All', 'Employer Branding', 'Published', 'admin', '2025-11-14 19:23:46'),
	(3, 'Tech Talk: AI in Recruitment', 'Thought Leadership', 'Our team is revolutionizing recruitment with AI. Read about our innovative approach to talent acquisition.', NULL, NULL, 'LinkedIn', 'Thought Leadership', 'Published', 'admin', '2025-11-14 19:23:46');

-- Dumping structure for table cmsadver_rmsdb.advocacy_rewards
DROP TABLE IF EXISTS `advocacy_rewards`;
CREATE TABLE IF NOT EXISTS `advocacy_rewards` (
  `reward_id` int(11) NOT NULL AUTO_INCREMENT,
  `advocate_id` int(11) NOT NULL,
  `reward_type` varchar(100) NOT NULL,
  `reward_description` text DEFAULT NULL,
  `points_earned` int(11) DEFAULT 0,
  `reward_date` date DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`reward_id`),
  KEY `idx_advocate` (`advocate_id`),
  CONSTRAINT `advocacy_rewards_ibfk_1` FOREIGN KEY (`advocate_id`) REFERENCES `employee_advocates` (`advocate_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.advocacy_rewards: ~0 rows (approximately)
DELETE FROM `advocacy_rewards`;

-- Dumping structure for table cmsadver_rmsdb.advocacy_shares
DROP TABLE IF EXISTS `advocacy_shares`;
CREATE TABLE IF NOT EXISTS `advocacy_shares` (
  `share_id` int(11) NOT NULL AUTO_INCREMENT,
  `advocate_id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `platform` varchar(50) NOT NULL,
  `shared_at` timestamp NULL DEFAULT current_timestamp(),
  `reach` int(11) DEFAULT 0,
  `impressions` int(11) DEFAULT 0,
  `clicks` int(11) DEFAULT 0,
  `likes` int(11) DEFAULT 0,
  `comments` int(11) DEFAULT 0,
  `shares` int(11) DEFAULT 0,
  PRIMARY KEY (`share_id`),
  KEY `idx_advocate` (`advocate_id`),
  KEY `idx_content` (`content_id`),
  CONSTRAINT `advocacy_shares_ibfk_1` FOREIGN KEY (`advocate_id`) REFERENCES `employee_advocates` (`advocate_id`) ON DELETE CASCADE,
  CONSTRAINT `advocacy_shares_ibfk_2` FOREIGN KEY (`content_id`) REFERENCES `advocacy_content` (`content_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.advocacy_shares: ~0 rows (approximately)
DELETE FROM `advocacy_shares`;

-- Dumping structure for table cmsadver_rmsdb.ad_campaigns
DROP TABLE IF EXISTS `ad_campaigns`;
CREATE TABLE IF NOT EXISTS `ad_campaigns` (
  `ad_campaign_id` int(11) NOT NULL AUTO_INCREMENT,
  `campaign_id` int(11) NOT NULL,
  `platform` varchar(50) NOT NULL,
  `ad_name` varchar(255) NOT NULL,
  `ad_content` text DEFAULT NULL,
  `target_audience` text DEFAULT NULL,
  `budget` decimal(10,2) DEFAULT NULL,
  `spent` decimal(10,2) DEFAULT 0.00,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Draft',
  `impressions` int(11) DEFAULT 0,
  `clicks` int(11) DEFAULT 0,
  `applications` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ad_campaign_id`),
  KEY `campaign_id` (`campaign_id`),
  CONSTRAINT `ad_campaigns_ibfk_1` FOREIGN KEY (`campaign_id`) REFERENCES `marketing_campaigns` (`campaign_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.ad_campaigns: ~0 rows (approximately)
DELETE FROM `ad_campaigns`;

-- Dumping structure for table cmsadver_rmsdb.audit_logs
DROP TABLE IF EXISTS `audit_logs`;
CREATE TABLE IF NOT EXISTS `audit_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `user_role` varchar(50) DEFAULT NULL,
  `action` varchar(50) NOT NULL,
  `resource_type` varchar(100) NOT NULL,
  `resource_id` int(11) DEFAULT NULL,
  `resource_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `old_values` text DEFAULT NULL,
  `new_values` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `request_method` varchar(10) DEFAULT NULL,
  `request_url` text DEFAULT NULL,
  `status` enum('success','failed') DEFAULT 'success',
  `error_message` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `username` (`username`),
  KEY `action` (`action`),
  KEY `resource_type` (`resource_type`),
  KEY `created_at` (`created_at`),
  KEY `ip_address` (`ip_address`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table cmsadver_rmsdb.audit_logs: ~8 rows (approximately)
DELETE FROM `audit_logs`;
INSERT INTO `audit_logs` (`id`, `user_id`, `username`, `user_email`, `user_role`, `action`, `resource_type`, `resource_id`, `resource_name`, `description`, `old_values`, `new_values`, `ip_address`, `user_agent`, `request_method`, `request_url`, `status`, `error_message`, `created_at`) VALUES
	(1, NULL, 'admin', 'admin@example.com', 'Admin', 'LOGIN', 'System', NULL, NULL, 'User logged into the system', NULL, NULL, '192.168.1.100', NULL, NULL, NULL, 'success', NULL, '2025-11-12 03:26:27'),
	(2, NULL, 'recruiter1', 'recruiter@example.com', 'Recruiter', 'CREATE', 'Candidate', NULL, 'John Doe', 'Created new candidate record', NULL, NULL, '192.168.1.105', NULL, NULL, NULL, 'success', NULL, '2025-11-12 04:26:27'),
	(3, NULL, 'recruiter1', 'recruiter@example.com', 'Recruiter', 'UPDATE', 'Candidate', NULL, 'Jane Smith', 'Updated candidate status to "Interview Scheduled"', '{"status":"Interested"}', '{"status":"Interview Scheduled"}', '192.168.1.105', NULL, NULL, NULL, 'success', NULL, '2025-11-12 04:41:27'),
	(4, NULL, 'interviewer1', 'interviewer@example.com', 'Interviewer', 'DELETE', 'Interview', NULL, 'Interview #123', 'Deleted interview schedule', NULL, NULL, '192.168.1.110', NULL, NULL, NULL, 'success', NULL, '2025-11-12 04:56:27'),
	(5, NULL, 'admin', 'admin@example.com', 'Admin', 'UPDATE', 'Settings', NULL, 'Company Settings', 'Updated company profile information', NULL, NULL, '192.168.1.100', NULL, NULL, NULL, 'success', NULL, '2025-11-12 05:11:27'),
	(6, NULL, 'recruiter2', 'recruiter2@example.com', 'Recruiter', 'EXPORT', 'Report', NULL, 'Candidate Report', 'Exported candidate list to CSV', NULL, NULL, '192.168.1.108', NULL, NULL, NULL, 'success', NULL, '2025-11-12 05:16:27'),
	(7, NULL, 'admin', 'admin@example.com', 'Admin', 'CREATE', 'User', NULL, 'newrecruiter@example.com', 'Created new recruiter account', NULL, NULL, '192.168.1.100', NULL, NULL, NULL, 'success', NULL, '2025-11-12 05:21:27'),
	(8, NULL, 'recruiter1', 'recruiter@example.com', 'Recruiter', 'LOGOUT', 'System', NULL, NULL, 'User logged out of the system', NULL, NULL, '192.168.1.105', NULL, NULL, NULL, 'success', NULL, '2025-11-12 05:24:27');

-- Dumping structure for table cmsadver_rmsdb.bot_analytics
DROP TABLE IF EXISTS `bot_analytics`;
CREATE TABLE IF NOT EXISTS `bot_analytics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_type` varchar(50) NOT NULL,
  `event_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`event_data`)),
  `user_id` int(11) DEFAULT NULL,
  `session_id` varchar(100) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_event_type` (`event_type`),
  KEY `idx_timestamp` (`timestamp`),
  KEY `idx_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.bot_analytics: ~0 rows (approximately)
DELETE FROM `bot_analytics`;

-- Dumping structure for table cmsadver_rmsdb.bot_config
DROP TABLE IF EXISTS `bot_config`;
CREATE TABLE IF NOT EXISTS `bot_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config_key` varchar(100) NOT NULL,
  `config_value` text DEFAULT NULL,
  `config_type` enum('string','json','boolean','number') DEFAULT 'string',
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `config_key` (`config_key`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.bot_config: ~7 rows (approximately)
DELETE FROM `bot_config`;
INSERT INTO `bot_config` (`id`, `config_key`, `config_value`, `config_type`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 'bot_name', 'RecruitBot', 'string', 'Display name of the bot', 1, '2025-11-16 06:59:48', '2025-11-16 06:59:48'),
	(2, 'welcome_message', 'Hi! ???? I\'m RecruitBot, your AI recruitment assistant. How can I help you today?', 'string', 'Initial greeting message', 1, '2025-11-16 06:59:48', '2025-11-16 06:59:48'),
	(3, 'ai_provider', 'openai', 'string', 'AI service provider (openai, claude, local)', 1, '2025-11-16 06:59:49', '2025-11-16 06:59:49'),
	(4, 'ai_model', 'gpt-4', 'string', 'AI model to use', 1, '2025-11-16 06:59:49', '2025-11-16 06:59:49'),
	(5, 'max_conversation_history', '10', 'number', 'Number of messages to keep in context', 1, '2025-11-16 06:59:49', '2025-11-16 06:59:49'),
	(6, 'enable_cv_parsing', 'true', 'boolean', 'Enable automatic CV parsing', 1, '2025-11-16 06:59:49', '2025-11-16 06:59:49'),
	(7, 'enable_auto_matching', 'true', 'boolean', 'Enable automatic job matching', 1, '2025-11-16 06:59:49', '2025-11-16 06:59:49');

-- Dumping structure for table cmsadver_rmsdb.bot_entities
DROP TABLE IF EXISTS `bot_entities`;
CREATE TABLE IF NOT EXISTS `bot_entities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entity_type` varchar(50) NOT NULL,
  `entity_value` text DEFAULT NULL,
  `synonyms` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`synonyms`)),
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_entity_type` (`entity_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.bot_entities: ~0 rows (approximately)
DELETE FROM `bot_entities`;

-- Dumping structure for table cmsadver_rmsdb.bot_feedback
DROP TABLE IF EXISTS `bot_feedback`;
CREATE TABLE IF NOT EXISTS `bot_feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(100) DEFAULT NULL,
  `message_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating` enum('helpful','not_helpful') NOT NULL,
  `feedback_text` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_session` (`session_id`),
  KEY `idx_rating` (`rating`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.bot_feedback: ~0 rows (approximately)
DELETE FROM `bot_feedback`;

-- Dumping structure for table cmsadver_rmsdb.bot_intents
DROP TABLE IF EXISTS `bot_intents`;
CREATE TABLE IF NOT EXISTS `bot_intents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `intent_name` varchar(50) NOT NULL,
  `display_name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `training_phrases` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`training_phrases`)),
  `response_templates` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`response_templates`)),
  `action_handler` varchar(100) DEFAULT NULL,
  `priority` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `intent_name` (`intent_name`),
  KEY `idx_intent_name` (`intent_name`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.bot_intents: ~4 rows (approximately)
DELETE FROM `bot_intents`;
INSERT INTO `bot_intents` (`id`, `intent_name`, `display_name`, `description`, `training_phrases`, `response_templates`, `action_handler`, `priority`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 'apply_job', 'Job Application', 'User wants to apply for a position', '["I want to apply", "Apply for job", "Submit application", "Upload CV", "I\'d like to join"]', NULL, 'handle_job_application', 0, 1, '2025-11-16 06:59:50', '2025-11-16 06:59:50'),
	(2, 'job_inquiry', 'Job Information', 'User asking about job positions', '["What jobs are available", "Open positions", "Tell me about roles", "Job vacancies"]', NULL, 'handle_job_inquiry', 0, 1, '2025-11-16 06:59:50', '2025-11-16 06:59:50'),
	(3, 'status_check', 'Application Status', 'User checking application status', '["What\'s my status", "Application progress", "Where is my application", "Any updates"]', NULL, 'handle_status_check', 0, 1, '2025-11-16 06:59:50', '2025-11-16 06:59:50'),
	(4, 'company_info', 'Company Information', 'User asking about company', '["Tell me about company", "Company culture", "Office location", "About your organization"]', NULL, 'handle_company_info', 0, 1, '2025-11-16 06:59:50', '2025-11-16 06:59:50');

-- Dumping structure for table cmsadver_rmsdb.branches
DROP TABLE IF EXISTS `branches`;
CREATE TABLE IF NOT EXISTS `branches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_name` varchar(255) NOT NULL,
  `branch_code` varchar(50) NOT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `manager` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `branch_code` (`branch_code`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.branches: ~5 rows (approximately)
DELETE FROM `branches`;
INSERT INTO `branches` (`id`, `branch_name`, `branch_code`, `address`, `city`, `state`, `country`, `postal_code`, `phone`, `email`, `manager`, `created_at`, `updated_at`) VALUES
	(1, 'Head Office', 'HQ001', NULL, 'New York', 'NY', 'USA', NULL, '+1-234-567-8900', 'hq@company.com', 'John Doe', '2025-11-09 07:01:40', '2025-11-09 07:01:40'),
	(2, 'Branch Office', 'BR001', NULL, 'Los Angeles', 'CA', 'USA', NULL, '+1-234-567-8901', 'la@company.com', 'Jane Smith', '2025-11-09 07:01:40', '2025-11-09 07:01:40'),
	(3, 'Siyambalape', 'SB', '345,\r\nDickwela Road,', 'Siyambalape', 'Outside US or Canada', 'Sri Lanka', '11607', '0777772379', 'dushya7@gmail.com', 'Charaka', '2025-11-09 02:42:16', '2025-11-09 07:12:16'),
	(5, 'Siyambalape', 'SB2', '345,\r\nDickwela Road,', 'Siyambalape', 'Outside US or Canada', 'Sri Lanka', '11607', '0777772379', 'dushya7@gmail.com', 'CharakaNB1', '2025-11-12 02:41:59', '2025-11-12 07:11:59'),
	(6, 'Siyambalape1', 'SB3', '345,\r\nDickwela Road,', 'Siyambalape', 'Outside US or Canada', 'Sri Lanka', '11607', '0777772379', 'dushya7@gmail.com', 'CharakaNB2', '2025-11-12 02:46:08', '2025-11-12 07:16:08');

-- Dumping structure for table cmsadver_rmsdb.calendar_events
DROP TABLE IF EXISTS `calendar_events`;
CREATE TABLE IF NOT EXISTS `calendar_events` (
  `ce_id` int(11) NOT NULL AUTO_INCREMENT,
  `ce_rec_username` varchar(255) NOT NULL,
  `ce_can_name` varchar(255) NOT NULL,
  `ce_interviewer` varchar(255) NOT NULL,
  `ce_start_date` datetime NOT NULL,
  `ce_end_date` datetime NOT NULL,
  `ce_interview_round` double NOT NULL DEFAULT 0,
  PRIMARY KEY (`ce_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table cmsadver_rmsdb.calendar_events: ~31 rows (approximately)
DELETE FROM `calendar_events`;
INSERT INTO `calendar_events` (`ce_id`, `ce_rec_username`, `ce_can_name`, `ce_interviewer`, `ce_start_date`, `ce_end_date`, `ce_interview_round`) VALUES
	(1, 'janedoe', 'Alex Johnson', 'sarahlee', '2025-03-23 10:00:00', '2025-03-23 11:00:00', 1),
	(2, 'janedoe', 'Alex Johnson', 'davidkim', '2025-03-25 14:00:00', '2025-03-25 15:00:00', 2),
	(3, 'mikebrown', 'Robert Chen', 'davidkim', '2025-03-22 11:00:00', '2025-03-22 12:30:00', 1),
	(4, 'mikebrown', 'Sophia Rodriguez', 'sarahlee', '2025-03-24 09:00:00', '2025-03-24 10:00:00', 1),
	(5, 'mikebrown', 'Sophia Rodriguez', 'davidkim', '2025-03-26 15:30:00', '2025-03-26 16:30:00', 2),
	(6, 'sarah_rec', 'Alex Johnson', 'david_int', '2025-11-05 10:00:00', '2025-11-05 11:00:00', 1),
	(7, 'sarah_rec', 'Robert Chen', 'emma_int', '2025-11-06 14:00:00', '2025-11-06 15:00:00', 1),
	(8, 'mike_rec', 'Sophia Rodriguez', 'david_int', '2025-11-07 09:00:00', '2025-11-07 10:00:00', 1),
	(9, 'sarah_rec', 'Emily Watson', 'emma_int', '2025-11-08 11:00:00', '2025-11-08 12:00:00', 1),
	(10, 'mike_rec', 'James Miller', 'david_int', '2025-11-09 15:00:00', '2025-11-09 16:00:00', 1),
	(11, 'sarah_rec', 'Matthew Harris', 'emma_int', '2025-11-15 10:00:00', '2025-11-15 11:00:00', 0.5),
	(12, 'mike_rec', 'Sarah Thompson', 'david_int', '2025-11-16 14:00:00', '2025-11-16 15:30:00', 0.25),
	(13, 'sarah_rec', 'Kevin Moore', 'emma_int', '2025-11-17 09:00:00', '2025-11-17 10:00:00', 0.5),
	(14, 'mike_rec', 'Rachel Green', 'david_int', '2025-11-18 13:00:00', '2025-11-18 14:00:00', 0.25),
	(15, 'sarah_rec', 'Brian Clark', 'emma_int', '2025-11-19 11:00:00', '2025-11-19 12:00:00', 0.75),
	(16, 'mike_rec', 'Nicole Adams', 'david_int', '2025-11-20 10:00:00', '2025-11-20 11:00:00', 0.5),
	(17, 'sarah_rec', 'Justin Baker', 'emma_int', '2025-11-21 15:00:00', '2025-11-21 16:00:00', 0.25),
	(18, 'mike_rec', 'Melissa Scott', 'david_int', '2025-11-22 09:00:00', '2025-11-22 10:00:00', 0.5),
	(19, 'sarah_rec', 'Alex Johnson', 'david_int', '2025-11-05 10:00:00', '2025-11-05 11:00:00', 1),
	(20, 'sarah_rec', 'Robert Chen', 'emma_int', '2025-11-06 14:00:00', '2025-11-06 15:00:00', 1),
	(21, 'mike_rec', 'Sophia Rodriguez', 'david_int', '2025-11-07 09:00:00', '2025-11-07 10:00:00', 1),
	(22, 'sarah_rec', 'Emily Watson', 'emma_int', '2025-11-08 11:00:00', '2025-11-08 12:00:00', 1),
	(23, 'mike_rec', 'James Miller', 'david_int', '2025-11-09 15:00:00', '2025-11-09 16:00:00', 1),
	(24, 'sarah_rec', 'Matthew Harris', 'emma_int', '2025-11-15 10:00:00', '2025-11-15 11:00:00', 0.5),
	(25, 'mike_rec', 'Sarah Thompson', 'david_int', '2025-11-16 14:00:00', '2025-11-16 15:30:00', 0.25),
	(26, 'sarah_rec', 'Kevin Moore', 'emma_int', '2025-11-17 09:00:00', '2025-11-17 10:00:00', 0.5),
	(27, 'mike_rec', 'Rachel Green', 'david_int', '2025-11-18 13:00:00', '2025-11-18 14:00:00', 0.25),
	(28, 'sarah_rec', 'Brian Clark', 'emma_int', '2025-11-19 11:00:00', '2025-11-19 12:00:00', 0.75),
	(29, 'mike_rec', 'Nicole Adams', 'david_int', '2025-11-20 10:00:00', '2025-11-20 11:00:00', 0.5),
	(30, 'sarah_rec', 'Justin Baker', 'emma_int', '2025-11-21 15:00:00', '2025-11-21 16:00:00', 0.25),
	(31, 'mike_rec', 'Melissa Scott', 'david_int', '2025-11-22 09:00:00', '2025-11-22 10:00:00', 0.5);

-- Dumping structure for table cmsadver_rmsdb.campaign_analytics
DROP TABLE IF EXISTS `campaign_analytics`;
CREATE TABLE IF NOT EXISTS `campaign_analytics` (
  `analytics_id` int(11) NOT NULL AUTO_INCREMENT,
  `campaign_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `reach` int(11) DEFAULT 0,
  `impressions` int(11) DEFAULT 0,
  `clicks` int(11) DEFAULT 0,
  `applications` int(11) DEFAULT 0,
  `spent` decimal(10,2) DEFAULT 0.00,
  `conversions` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`analytics_id`),
  KEY `campaign_id` (`campaign_id`),
  CONSTRAINT `campaign_analytics_ibfk_1` FOREIGN KEY (`campaign_id`) REFERENCES `marketing_campaigns` (`campaign_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.campaign_analytics: ~7 rows (approximately)
DELETE FROM `campaign_analytics`;
INSERT INTO `campaign_analytics` (`analytics_id`, `campaign_id`, `date`, `reach`, `impressions`, `clicks`, `applications`, `spent`, `conversions`, `created_at`) VALUES
	(1, 1, '2025-11-14', 12836, 38508, 1678, 159, 6150.00, 0, '2025-11-14 18:39:45'),
	(2, 2, '2025-11-14', 8098, 24294, 1042, 167, 7800.00, 0, '2025-11-14 18:39:45'),
	(3, 3, '2025-11-14', 6707, 13414, 931, 173, 2640.00, 0, '2025-11-14 18:39:45'),
	(4, 4, '2025-11-14', 13131, 39393, 1129, 66, 5400.00, 0, '2025-11-14 18:39:45'),
	(5, 7, '2025-11-14', 11454, 34362, 1207, 64, 8850.00, 0, '2025-11-14 18:39:45'),
	(6, 8, '2025-11-14', 7041, 14082, 549, 98, 3600.00, 0, '2025-11-14 18:39:45'),
	(7, 9, '2025-11-14', 15742, 31484, 1947, 61, 7080.00, 0, '2025-11-14 18:39:45');

-- Dumping structure for table cmsadver_rmsdb.candidates
DROP TABLE IF EXISTS `candidates`;
CREATE TABLE IF NOT EXISTS `candidates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `position_applied` varchar(255) DEFAULT NULL,
  `resume_path` varchar(500) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.candidates: ~15 rows (approximately)
DELETE FROM `candidates`;
INSERT INTO `candidates` (`id`, `name`, `email`, `phone`, `position_applied`, `resume_path`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'John Smith', 'john.smith@email.com', '555-0101', 'Senior Software Engineer', NULL, 'active', '2025-11-08 22:30:40', '2025-11-08 22:30:40'),
	(2, 'Sarah Johnson', 'sarah.j@email.com', '555-0102', 'Frontend Developer', NULL, 'active', '2025-11-08 22:30:40', '2025-11-08 22:30:40'),
	(3, 'Michael Chen', 'mchen@email.com', '555-0103', 'Full Stack Developer', NULL, 'active', '2025-11-08 22:30:40', '2025-11-08 22:30:40'),
	(4, 'Emily Davis', 'emily.d@email.com', '555-0104', 'UI/UX Designer', NULL, 'active', '2025-11-08 22:30:40', '2025-11-08 22:30:40'),
	(5, 'David Wilson', 'dwilson@email.com', '555-0105', 'Backend Developer', NULL, 'active', '2025-11-08 22:30:40', '2025-11-08 22:30:40'),
	(6, 'Lisa Anderson', 'lisa.a@email.com', '555-0106', 'DevOps Engineer', NULL, 'active', '2025-11-08 22:30:40', '2025-11-08 22:30:40'),
	(7, 'James Martinez', 'jmartinez@email.com', '555-0107', 'Data Scientist', NULL, 'active', '2025-11-08 22:30:41', '2025-11-08 22:30:41'),
	(8, 'Jennifer Taylor', 'jtaylor@email.com', '555-0108', 'Product Manager', NULL, 'active', '2025-11-08 22:30:41', '2025-11-08 22:30:41'),
	(9, 'Robert Brown', 'rbrown@email.com', '555-0109', 'QA Engineer', NULL, 'active', '2025-11-08 22:30:41', '2025-11-08 22:30:41'),
	(10, 'Maria Garcia', 'mgarcia@email.com', '555-0110', 'Mobile Developer', NULL, 'active', '2025-11-08 22:30:41', '2025-11-08 22:30:41'),
	(11, 'William Lee', 'wlee@email.com', '555-0111', 'Security Engineer', NULL, 'active', '2025-11-08 22:30:41', '2025-11-08 22:30:41'),
	(12, 'Jessica White', 'jwhite@email.com', '555-0112', 'Cloud Architect', NULL, 'active', '2025-11-08 22:30:41', '2025-11-08 22:30:41'),
	(13, 'Christopher Hall', 'chall@email.com', '555-0113', 'Machine Learning Engineer', NULL, 'active', '2025-11-08 22:30:41', '2025-11-08 22:30:41'),
	(14, 'Amanda Young', 'ayoung@email.com', '555-0114', 'Scrum Master', NULL, 'active', '2025-11-08 22:30:41', '2025-11-08 22:30:41'),
	(15, 'Daniel King', 'dking@email.com', '555-0115', 'Technical Writer', NULL, 'active', '2025-11-08 22:30:41', '2025-11-08 22:30:41');

-- Dumping structure for table cmsadver_rmsdb.candidate_applications
DROP TABLE IF EXISTS `candidate_applications`;
CREATE TABLE IF NOT EXISTS `candidate_applications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_username` varchar(100) NOT NULL,
  `job_id` int(11) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `status` enum('applied','screening','interview_scheduled','interviewed','offer_extended','hired','rejected','withdrawn') DEFAULT 'applied',
  `applied_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `notes` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `candidate_username` (`candidate_username`),
  KEY `job_id` (`job_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.candidate_applications: ~0 rows (approximately)
DELETE FROM `candidate_applications`;

-- Dumping structure for table cmsadver_rmsdb.candidate_details
DROP TABLE IF EXISTS `candidate_details`;
CREATE TABLE IF NOT EXISTS `candidate_details` (
  `cd_id` int(15) NOT NULL AUTO_INCREMENT,
  `cd_rec_username` varchar(255) NOT NULL,
  `cd_name` varchar(255) NOT NULL,
  `cd_email` varchar(255) NOT NULL,
  `cd_phone` bigint(20) NOT NULL,
  `cd_gender` varchar(25) NOT NULL,
  `cd_job_title` varchar(25) NOT NULL,
  `cd_source` varchar(255) NOT NULL,
  `cd_description` varchar(1000) NOT NULL,
  `cd_resume_link` varchar(255) DEFAULT NULL,
  `cd_status` varchar(255) NOT NULL,
  `cd_interview_status` int(1) NOT NULL DEFAULT 0,
  `cd_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`cd_id`)
) ENGINE=InnoDB AUTO_INCREMENT=263 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table cmsadver_rmsdb.candidate_details: ~261 rows (approximately)
DELETE FROM `candidate_details`;
INSERT INTO `candidate_details` (`cd_id`, `cd_rec_username`, `cd_name`, `cd_email`, `cd_phone`, `cd_gender`, `cd_job_title`, `cd_source`, `cd_description`, `cd_resume_link`, `cd_status`, `cd_interview_status`, `cd_created_at`) VALUES
	(1, 'ucsc', 'Alex Johnson', 'alex.johnson@email.com', 9871234560, 'Male', 'Software Developer', 'LinkedIn', 'Experienced Java developer with 5 years of experience in backend development. Skilled in Spring Boot and microservices architecture.', 'resumes/alex_johnson_resume.pdf', 'Shortlisted', 1, '2025-11-12 00:42:35'),
	(2, 'ucsc', 'Emily Parker', 'emily.parker@email.com', 8765432109, 'Female', 'UI/UX Designer', 'Indeed', 'Creative UI/UX designer with strong portfolio. Proficient in Figma, Adobe XD, and user research methodologies.', 'resumes/emily_parker_resume.pdf', 'In Review', 0, '2025-11-12 00:42:35'),
	(3, 'ucsc', 'Robert Chen', 'robert.chen@email.com', 7654321098, 'Male', 'Data Scientist', 'Referral', 'PhD in Statistics with expertise in machine learning algorithms, NLP, and data visualization. Experience with Python, R, and TensorFlow.', 'resumes/robert_chen_resume.pdf', 'Shortlisted', 1, '2025-11-12 00:42:35'),
	(4, 'ucsc', 'Sophia Rodriguez', 'sophia.rodriguez@email.com', 6549873210, 'Female', 'Product Manager', 'Company Website', 'Product manager with 7 years of experience in agile environments. Strong background in market research and product development lifecycle.', 'resumes/sophia_rodriguez_resume.pdf', 'Selected', 2, '2025-11-11 20:22:29'),
	(5, 'ucsc', 'Michael Wilson', 'michael.wilson@email.com', 8907654321, 'Male', 'DevOps Engineer', 'Stack Overflow', 'DevOps engineer with expertise in CI/CD pipelines, Docker, Kubernetes, and AWS infrastructure. Strong automation skills.', 'resumes/michael_wilson_resume.pdf', 'In Review', 0, '2025-11-12 00:42:35'),
	(6, 'ucsc', 'Sarah Johnson', 'sarah.johnson@email.com', 2343243242342, 'Female', 'Software Engineer', 'LinkedIn', '', NULL, 'Interested', 1, '2025-11-12 00:42:35'),
	(7, 'ucsc', 'Michael Chen', 'michael.chen@email.com', 13253252353225, 'Male', 'Frontend Developer', 'Indeed', '', NULL, 'Interested', 0, '2025-11-12 00:42:35'),
	(8, 'ucsc', 'Emily Rodriguez', 'emily.rodriguez@email.com', 1, 'Female', 'Full Stack Developer', 'Company Website', '', NULL, 'Interested', 1, '2025-11-12 00:42:35'),
	(9, 'ucsc', 'David Kim', 'david.kim@email.com', 1, 'Male', 'Backend Developer', 'Referral', '', NULL, 'Interested', 1, '2025-11-12 00:42:35'),
	(10, 'ucsc', 'Jessica Martinez', 'jessica.martinez@email.com', 1, 'Female', 'UI/UX Designer', 'LinkedIn', '', NULL, 'Not Picking up Call', 0, '2025-11-12 00:42:35'),
	(11, 'ucsc', 'Robert Taylor', 'robert.taylor@email.com', 1, 'Male', 'DevOps Engineer', 'Job Fair', '', NULL, 'Call Back Later', 0, '2025-11-12 00:42:35'),
	(12, 'ucsc', 'Amanda White', 'amanda.white@email.com', 1, 'Female', 'Product Manager', 'LinkedIn', '', NULL, 'Interested', 0, '2025-11-12 00:42:35'),
	(13, 'ucsc', 'James Anderson', 'james.anderson@email.com', 1, 'Male', 'QA Engineer', 'Indeed', '', NULL, 'Interested', 1, '2025-11-12 00:42:35'),
	(14, 'ucsc', 'Lisa Thompson', 'lisa.thompson@email.com', 1, 'Female', 'Data Scientist', 'Company Website', '', NULL, 'Not Interested', 0, '2025-11-12 00:42:35'),
	(15, 'ucsc', 'Christopher Lee', 'christopher.lee@email.com', 14325325322, 'Male', 'Software Engineer', 'Referral', '', NULL, 'Interested', 1, '2025-11-12 00:42:35'),
	(16, 'ucsc', 'Test', 'candi1@gmail.com', 0, 'Male', 'Full Stack Developer', 'Company Website', 'test', 'b1377eaff8f6280e36b1fd827654473a.docx', 'Interested', 0, '2025-11-12 00:42:35'),
	(17, 'ucsc', 'Test', 'candi3@gmail.com', 21323213213213, 'Male', 'Full Stack Developer', 'Company Website', 'test', '9b37db0afc6e5b458c395061dbf91eac.docx', 'Not Picking up Call', 0, '2025-11-12 00:42:35'),
	(18, 'ucsc', 'Test', 'candi2@gmail.com', 23214215121511, 'Male', 'Full Stack Developer', 'Job Fair', 'test', NULL, 'Not Interested', 0, '2025-11-12 00:42:35'),
	(19, '', 'charakaint', 'dushya7@gmail.com', 42142142111111, '', '', '', '', NULL, '', 0, '2025-11-12 00:42:35'),
	(20, 'sarah_rec', 'Alex Johnson', 'alex.johnson@email.com', 555, 'Male', 'Senior Software Engineer', 'LinkedIn', 'Excellent full-stack developer', NULL, 'Selected', 1, '2025-11-11 20:22:29'),
	(21, 'sarah_rec', 'Robert Chen', 'robert.chen@email.com', 555, 'Male', 'DevOps Engineer', 'Indeed', 'Strong cloud infrastructure background', NULL, 'Selected', 1, '2025-11-06 20:22:29'),
	(22, 'mike_rec', 'Sophia Rodriguez', 'sophia.r@email.com', 555, 'Female', 'Frontend Developer', 'Referral', 'Creative UI/UX developer', NULL, 'Selected', 1, '2025-11-05 20:22:29'),
	(23, 'sarah_rec', 'Emily Watson', 'emily.watson@email.com', 555, 'Female', 'Backend Developer', 'Company Website', 'Strong Python and Node.js skills', NULL, 'Selected', 1, '2025-11-07 20:22:29'),
	(24, 'mike_rec', 'James Miller', 'james.miller@email.com', 555, 'Male', 'Full Stack Developer', 'Job Portal', 'MERN stack specialist', NULL, 'Selected', 1, '2025-11-05 20:22:29'),
	(25, 'sarah_rec', 'Maria Garcia', 'maria.garcia@email.com', 555, 'Female', 'QA Engineer', 'LinkedIn', 'Automation testing expert', NULL, 'Selected', 1, '2025-11-07 20:22:29'),
	(26, 'mike_rec', 'David Kim', 'david.kim@email.com', 555, 'Male', 'Data Analyst', 'Indeed', 'SQL and Python analytics', NULL, 'Selected', 1, '2025-10-27 20:22:29'),
	(27, 'sarah_rec', 'Lisa Anderson', 'lisa.anderson@email.com', 555, 'Female', 'Product Manager', 'Referral', 'Agile methodology expert', NULL, 'Selected', 1, '2025-11-02 20:22:29'),
	(28, 'mike_rec', 'Michael Brown', 'michael.brown@email.com', 555, 'Male', 'UI/UX Designer', 'Company Website', 'Award-winning designer', NULL, 'Selected', 1, '2025-10-25 20:22:29'),
	(29, 'sarah_rec', 'Jennifer Lee', 'jennifer.lee@email.com', 555, 'Female', 'Mobile Developer', 'LinkedIn', 'iOS and Android expert', NULL, 'Selected', 1, '2025-11-03 20:22:29'),
	(30, 'mike_rec', 'Thomas Wilson', 'thomas.wilson@email.com', 555, 'Male', 'Security Engineer', 'Job Portal', 'Cybersecurity certified', NULL, 'Selected', 1, '2025-10-20 20:22:29'),
	(31, 'sarah_rec', 'Amanda Taylor', 'amanda.taylor@email.com', 555, 'Female', 'Business Analyst', 'Indeed', 'Strong communication skills', NULL, 'Selected', 1, '2025-10-18 20:22:29'),
	(32, 'mike_rec', 'Christopher Davis', 'chris.davis@email.com', 555, 'Male', 'Cloud Architect', 'LinkedIn', 'AWS and Azure certified', NULL, 'Selected', 1, '2025-10-26 20:22:29'),
	(33, 'sarah_rec', 'Jessica Martinez', 'jessica.m@email.com', 555, 'Female', 'Data Scientist', 'Referral', 'ML and AI specialist', NULL, 'Selected', 1, '2025-10-28 20:22:29'),
	(34, 'mike_rec', 'Daniel White', 'daniel.white@email.com', 555, 'Male', 'Tech Lead', 'Company Website', 'Team leadership experience', NULL, 'Selected', 1, '2025-08-30 20:22:29'),
	(35, 'sarah_rec', 'Matthew Harris', 'matthew.h@email.com', 555, 'Male', 'Software Engineer', 'LinkedIn', 'Second round interview scheduled', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(36, 'mike_rec', 'Sarah Thompson', 'sarah.t@email.com', 555, 'Female', 'Frontend Developer', 'Indeed', 'Technical assessment completed', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(37, 'sarah_rec', 'Kevin Moore', 'kevin.moore@email.com', 555, 'Male', 'Backend Developer', 'Job Portal', 'Coding challenge passed', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(38, 'mike_rec', 'Rachel Green', 'rachel.green@email.com', 555, 'Female', 'QA Automation', 'Referral', 'First interview completed', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(39, 'sarah_rec', 'Brian Clark', 'brian.clark@email.com', 555, 'Male', 'DevOps Engineer', 'LinkedIn', 'Technical round in progress', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(40, 'mike_rec', 'Nicole Adams', 'nicole.adams@email.com', 555, 'Female', 'Product Designer', 'Company Website', 'Portfolio review completed', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(41, 'sarah_rec', 'Justin Baker', 'justin.baker@email.com', 555, 'Male', 'Data Engineer', 'Indeed', 'SQL test passed', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(42, 'mike_rec', 'Melissa Scott', 'melissa.scott@email.com', 555, 'Female', 'Scrum Master', 'Referral', 'HR interview done', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(43, 'sarah_rec', 'Ryan Phillips', 'ryan.phillips@email.com', 555, 'Male', 'Mobile Developer', 'LinkedIn', 'App demo scheduled', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(44, 'mike_rec', 'Laura Mitchell', 'laura.mitchell@email.com', 555, 'Female', 'Business Analyst', 'Job Portal', 'Case study submitted', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(45, 'sarah_rec', 'Eric Turner', 'eric.turner@email.com', 555, 'Male', 'Full Stack Developer', 'Indeed', 'Final round pending', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(46, 'mike_rec', 'Stephanie Hill', 'stephanie.hill@email.com', 555, 'Female', 'UI Designer', 'Company Website', 'Design challenge completed', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(47, 'sarah_rec', 'Brandon Lewis', 'brandon.lewis@email.com', 555, 'Male', 'Security Analyst', 'LinkedIn', 'Security assessment done', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(48, 'mike_rec', 'Christina Young', 'christina.young@email.com', 555, 'Female', 'Project Manager', 'Referral', 'Management interview scheduled', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(49, 'sarah_rec', 'Gregory King', 'gregory.king@email.com', 555, 'Male', 'Cloud Engineer', 'Indeed', 'AWS certification verified', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(50, 'mike_rec', 'Samantha Wright', 'samantha.wright@email.com', 555, 'Female', 'Data Analyst', 'Job Portal', 'Analytics test completed', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(51, 'sarah_rec', 'Patrick Lopez', 'patrick.lopez@email.com', 555, 'Male', 'Software Architect', 'LinkedIn', 'Architecture review pending', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(52, 'mike_rec', 'Angela Hall', 'angela.hall@email.com', 555, 'Female', 'QA Lead', 'Company Website', 'Leadership assessment done', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(53, 'sarah_rec', 'Timothy Allen', 'timothy.allen@email.com', 555, 'Male', 'Backend Engineer', 'Referral', 'System design interview scheduled', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(54, 'mike_rec', 'Rebecca Nelson', 'rebecca.nelson@email.com', 555, 'Female', 'Frontend Engineer', 'Indeed', 'React assessment passed', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(55, 'sarah_rec', 'Kenneth Carter', 'kenneth.carter@email.com', 555, 'Male', 'DevOps Lead', 'LinkedIn', 'CI/CD knowledge verified', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(56, 'mike_rec', 'Michelle Perez', 'michelle.perez@email.com', 555, 'Female', 'UX Researcher', 'Job Portal', 'Research presentation done', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(57, 'sarah_rec', 'Steven Roberts', 'steven.roberts@email.com', 555, 'Male', 'Machine Learning Engineer', 'Referral', 'ML model review pending', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(58, 'mike_rec', 'Kimberly Edwards', 'kimberly.edwards@email.com', 555, 'Female', 'Technical Writer', 'Company Website', 'Writing sample submitted', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(59, 'sarah_rec', 'Jason Collins', 'jason.collins@email.com', 555, 'Male', 'Site Reliability Engineer', 'LinkedIn', 'SRE assessment completed', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(60, 'sarah_rec', 'Andrew Stewart', 'andrew.stewart@email.com', 555, 'Male', 'Software Developer', 'Indeed', 'Strong coding skills', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(61, 'mike_rec', 'Brittany Morris', 'brittany.morris@email.com', 555, 'Female', 'Frontend Developer', 'LinkedIn', 'React and Vue experience', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(62, 'sarah_rec', 'Joshua Rogers', 'joshua.rogers@email.com', 555, 'Male', 'Backend Developer', 'Job Portal', 'Node.js specialist', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(63, 'mike_rec', 'Megan Reed', 'megan.reed@email.com', 555, 'Female', 'QA Engineer', 'Referral', 'Manual and automation testing', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(64, 'sarah_rec', 'Nathan Cook', 'nathan.cook@email.com', 555, 'Male', 'DevOps Engineer', 'Company Website', 'Docker and Kubernetes', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(65, 'mike_rec', 'Heather Morgan', 'heather.morgan@email.com', 555, 'Female', 'Product Manager', 'LinkedIn', 'Product strategy experience', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(66, 'sarah_rec', 'Aaron Bell', 'aaron.bell@email.com', 555, 'Male', 'Data Scientist', 'Indeed', 'Python and R programming', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(67, 'mike_rec', 'Danielle Murphy', 'danielle.murphy@email.com', 555, 'Female', 'UI/UX Designer', 'Job Portal', 'Figma and Adobe XD', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(68, 'sarah_rec', 'Jeremy Bailey', 'jeremy.bailey@email.com', 555, 'Male', 'Mobile Developer', 'Referral', 'Flutter and React Native', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(69, 'mike_rec', 'Katherine Rivera', 'katherine.rivera@email.com', 555, 'Female', 'Business Analyst', 'Company Website', 'Requirements gathering', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(70, 'sarah_rec', 'Tyler Cooper', 'tyler.cooper@email.com', 555, 'Male', 'Full Stack Developer', 'LinkedIn', 'MEAN stack developer', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(71, 'mike_rec', 'Amber Richardson', 'amber.richardson@email.com', 555, 'Female', 'Scrum Master', 'Indeed', 'Agile certified', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(72, 'sarah_rec', 'Jordan Cox', 'jordan.cox@email.com', 555, 'Male', 'Cloud Engineer', 'Job Portal', 'Azure specialist', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(73, 'mike_rec', 'Crystal Howard', 'crystal.howard@email.com', 555, 'Female', 'Data Analyst', 'Referral', 'Tableau and Power BI', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(74, 'sarah_rec', 'Austin Ward', 'austin.ward@email.com', 555, 'Male', 'Security Engineer', 'LinkedIn', 'Penetration testing', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(75, 'mike_rec', 'Courtney Torres', 'courtney.torres@email.com', 555, 'Female', 'Technical Lead', 'Company Website', 'Team management', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(76, 'sarah_rec', 'Marcus Peterson', 'marcus.peterson@email.com', 555, 'Male', 'Software Engineer', 'Indeed', 'Java and Spring Boot', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(77, 'mike_rec', 'Vanessa Gray', 'vanessa.gray@email.com', 555, 'Female', 'Frontend Developer', 'Job Portal', 'Angular specialist', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(78, 'sarah_rec', 'Carl Ramirez', 'carl.ramirez@email.com', 555, 'Male', 'Backend Developer', 'Referral', 'Django and Flask', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(79, 'mike_rec', 'Tiffany James', 'tiffany.james@email.com', 555, 'Female', 'QA Automation', 'LinkedIn', 'Selenium and Cypress', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(80, 'sarah_rec', 'Victor Watson', 'victor.watson@email.com', 555, 'Male', 'DevOps Engineer', 'Company Website', 'Jenkins and GitLab CI', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(81, 'mike_rec', 'Monica Brooks', 'monica.brooks@email.com', 555, 'Female', 'Product Designer', 'Indeed', 'User research expert', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(82, 'sarah_rec', 'Keith Kelly', 'keith.kelly@email.com', 555, 'Male', 'Data Engineer', 'Job Portal', 'ETL and data pipelines', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(83, 'mike_rec', 'Jacqueline Sanders', 'jacqueline.sanders@email.com', 555, 'Female', 'Project Manager', 'Referral', 'PMP certified', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(84, 'sarah_rec', 'Sean Price', 'sean.price@email.com', 555, 'Male', 'Mobile Developer', 'LinkedIn', 'Swift and Kotlin', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(85, 'mike_rec', 'Denise Bennett', 'denise.bennett@email.com', 555, 'Female', 'Business Analyst', 'Company Website', 'Process improvement', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(86, 'sarah_rec', 'Craig Wood', 'craig.wood@email.com', 555, 'Male', 'Full Stack Developer', 'Indeed', 'PHP and Laravel', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(87, 'mike_rec', 'Cheryl Barnes', 'cheryl.barnes@email.com', 555, 'Female', 'UI Designer', 'Job Portal', 'Responsive design', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(88, 'sarah_rec', 'Philip Ross', 'philip.ross@email.com', 555, 'Male', 'Security Analyst', 'Referral', 'CISSP certified', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(89, 'mike_rec', 'Janet Henderson', 'janet.henderson@email.com', 555, 'Female', 'Scrum Master', 'LinkedIn', 'SAFe certified', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(90, 'sarah_rec', 'Douglas Coleman', 'douglas.coleman@email.com', 555, 'Male', 'Cloud Architect', 'Company Website', 'Multi-cloud experience', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(91, 'mike_rec', 'Teresa Jenkins', 'teresa.jenkins@email.com', 555, 'Female', 'Data Analyst', 'Indeed', 'Statistical analysis', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(92, 'sarah_rec', 'Peter Perry', 'peter.perry@email.com', 555, 'Male', 'Software Architect', 'Job Portal', 'Microservices design', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(93, 'mike_rec', 'Frances Powell', 'frances.powell@email.com', 555, 'Female', 'QA Lead', 'Referral', 'Test strategy planning', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(94, 'sarah_rec', 'Harold Long', 'harold.long@email.com', 555, 'Male', 'Backend Engineer', 'LinkedIn', 'Go and Rust', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(95, 'mike_rec', 'Evelyn Patterson', 'evelyn.patterson@email.com', 555, 'Female', 'Frontend Engineer', 'Company Website', 'TypeScript expert', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(96, 'sarah_rec', 'Henry Hughes', 'henry.hughes@email.com', 555, 'Male', 'DevOps Lead', 'Indeed', 'Infrastructure as code', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(97, 'mike_rec', 'Diane Flores', 'diane.flores@email.com', 555, 'Female', 'UX Researcher', 'Job Portal', 'User testing', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(98, 'sarah_rec', 'Walter Washington', 'walter.washington@email.com', 555, 'Male', 'ML Engineer', 'Referral', 'TensorFlow and PyTorch', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(99, 'mike_rec', 'Joyce Butler', 'joyce.butler@email.com', 555, 'Female', 'Technical Writer', 'LinkedIn', 'API documentation', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(100, 'sarah_rec', 'Arthur Simmons', 'arthur.simmons@email.com', 555, 'Male', 'Software Developer', 'Indeed', 'Did not meet technical requirements', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(101, 'mike_rec', 'Gloria Foster', 'gloria.foster@email.com', 555, 'Female', 'Frontend Developer', 'LinkedIn', 'Insufficient experience', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(102, 'sarah_rec', 'Ralph Gonzales', 'ralph.gonzales@email.com', 555, 'Male', 'Backend Developer', 'Job Portal', 'Failed coding assessment', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(103, 'mike_rec', 'Doris Bryant', 'doris.bryant@email.com', 555, 'Female', 'QA Engineer', 'Referral', 'Not a cultural fit', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(104, 'sarah_rec', 'Roy Alexander', 'roy.alexander@email.com', 555, 'Male', 'DevOps Engineer', 'Company Website', 'Salary expectations too high', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(105, 'mike_rec', 'Marilyn Russell', 'marilyn.russell@email.com', 555, 'Female', 'Product Manager', 'LinkedIn', 'Lack of product experience', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(106, 'sarah_rec', 'Eugene Griffin', 'eugene.griffin@email.com', 555, 'Male', 'Data Scientist', 'Indeed', 'Weak statistical knowledge', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(107, 'mike_rec', 'Beverly Diaz', 'beverly.diaz@email.com', 555, 'Female', 'UI/UX Designer', 'Job Portal', 'Portfolio not strong enough', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(108, 'sarah_rec', 'Russell Hayes', 'russell.hayes@email.com', 555, 'Male', 'Mobile Developer', 'Referral', 'Limited mobile experience', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(109, 'mike_rec', 'Judith Myers', 'judith.myers@email.com', 555, 'Female', 'Business Analyst', 'Company Website', 'Poor communication skills', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(110, 'sarah_rec', 'Willie Ford', 'willie.ford@email.com', 555, 'Male', 'Full Stack Developer', 'LinkedIn', 'Failed technical interview', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(111, 'mike_rec', 'Virginia Hamilton', 'virginia.hamilton@email.com', 555, 'Female', 'Scrum Master', 'Indeed', 'No agile certification', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(112, 'sarah_rec', 'Albert Graham', 'albert.graham@email.com', 555, 'Male', 'Cloud Engineer', 'Job Portal', 'Insufficient cloud knowledge', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(113, 'mike_rec', 'Kathryn Sullivan', 'kathryn.sullivan@email.com', 555, 'Female', 'Data Analyst', 'Referral', 'Weak SQL skills', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(114, 'sarah_rec', 'Lawrence Wallace', 'lawrence.wallace@email.com', 555, 'Male', 'Security Engineer', 'LinkedIn', 'No security certifications', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(115, 'mike_rec', 'Pamela Woods', 'pamela.woods@email.com', 555, 'Female', 'Technical Lead', 'Company Website', 'Lack of leadership experience', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(116, 'sarah_rec', 'Joe West', 'joe.west@email.com', 555, 'Male', 'Software Engineer', 'Indeed', 'Overqualified for position', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(117, 'mike_rec', 'Carolyn Cole', 'carolyn.cole@email.com', 555, 'Female', 'Frontend Developer', 'Job Portal', 'Relocated to different city', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(118, 'sarah_rec', 'Ernest Owens', 'ernest.owens@email.com', 555, 'Male', 'Backend Developer', 'Referral', 'Accepted another offer', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(119, 'mike_rec', 'Martha Reynolds', 'martha.reynolds@email.com', 555, 'Female', 'QA Automation', 'LinkedIn', 'Not available for start date', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(120, 'sarah_rec', 'Louis Fisher', 'louis.fisher@email.com', 555, 'Male', 'Software Developer', 'Company Website', 'Waiting for budget approval', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(121, 'mike_rec', 'Sara Porter', 'sara.porter@email.com', 555, 'Female', 'Frontend Developer', 'Indeed', 'Position temporarily frozen', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(122, 'sarah_rec', 'Jack Hunter', 'jack.hunter@email.com', 555, 'Male', 'Backend Developer', 'LinkedIn', 'Pending reference checks', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(123, 'mike_rec', 'Alice Hicks', 'alice.hicks@email.com', 555, 'Female', 'QA Engineer', 'Job Portal', 'Awaiting team decision', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(124, 'sarah_rec', 'Gerald Crawford', 'gerald.crawford@email.com', 555, 'Male', 'DevOps Engineer', 'Referral', 'Waiting for project confirmation', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(125, 'mike_rec', 'Judith Boyd', 'judith.boyd@email.com', 555, 'Female', 'Product Manager', 'Company Website', 'Budget review in progress', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(126, 'sarah_rec', 'Carl Mason', 'carl.mason@email.com', 555, 'Male', 'Data Scientist', 'LinkedIn', 'Headcount approval pending', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(127, 'mike_rec', 'Madison Dixon', 'madison.dixon@email.com', 555, 'Female', 'UI/UX Designer', 'Indeed', 'Waiting for design team feedback', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(128, 'sarah_rec', 'Keith Reid', 'keith.reid@email.com', 555, 'Male', 'Mobile Developer', 'Job Portal', 'Project timeline uncertain', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(129, 'mike_rec', 'Judy Fox', 'judy.fox@email.com', 555, 'Female', 'Business Analyst', 'Referral', 'Department restructuring', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(130, 'sarah_rec', 'Willie McDonald', 'willie.mcdonald@email.com', 555, 'Male', 'Full Stack Developer', 'Company Website', 'Waiting for senior approval', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(131, 'mike_rec', 'Theresa Kennedy', 'theresa.kennedy@email.com', 555, 'Female', 'Scrum Master', 'LinkedIn', 'Team capacity review', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(132, 'sarah_rec', 'Lawrence Wells', 'lawrence.wells@email.com', 555, 'Male', 'Cloud Engineer', 'Indeed', 'Cloud migration timeline TBD', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(133, 'mike_rec', 'Deborah Vargas', 'deborah.vargas@email.com', 555, 'Female', 'Data Analyst', 'Job Portal', 'Analytics team expansion on hold', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(134, 'sarah_rec', 'Nicholas Chavez', 'nicholas.chavez@email.com', 555, 'Male', 'Security Engineer', 'Referral', 'Security audit completion pending', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(135, 'mike_rec', 'Julie Sims', 'julie.sims@email.com', 555, 'Female', 'Technical Lead', 'Company Website', 'Leadership structure review', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(136, 'sarah_rec', 'Bruce Castillo', 'bruce.castillo@email.com', 555, 'Male', 'Software Engineer', 'LinkedIn', 'Waiting for team availability', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(137, 'mike_rec', 'Olivia Montgomery', 'olivia.montgomery@email.com', 555, 'Female', 'Frontend Developer', 'Indeed', 'Project scope clarification needed', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(138, 'sarah_rec', 'Billy Richards', 'billy.richards@email.com', 555, 'Male', 'Backend Developer', 'Job Portal', 'Tech stack decision pending', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(139, 'mike_rec', 'Emma Williamson', 'emma.williamson@email.com', 555, 'Female', 'QA Automation', 'Referral', 'QA process review in progress', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(140, 'sarah_rec', 'Alex Johnson', 'alex.johnson@email.com', 555, 'Male', 'Senior Software Engineer', 'LinkedIn', 'Excellent full-stack developer', NULL, 'Selected', 1, '2025-08-17 20:22:29'),
	(141, 'sarah_rec', 'Robert Chen', 'robert.chen@email.com', 555, 'Male', 'DevOps Engineer', 'Indeed', 'Strong cloud infrastructure background', NULL, 'Selected', 1, '2025-08-24 20:22:29'),
	(142, 'mike_rec', 'Sophia Rodriguez', 'sophia.r@email.com', 555, 'Female', 'Frontend Developer', 'Referral', 'Creative UI/UX developer', NULL, 'Selected', 1, '2025-09-24 20:22:29'),
	(143, 'sarah_rec', 'Emily Watson', 'emily.watson@email.com', 555, 'Female', 'Backend Developer', 'Company Website', 'Strong Python and Node.js skills', NULL, 'Selected', 1, '2025-09-19 20:22:29'),
	(144, 'mike_rec', 'James Miller', 'james.miller@email.com', 555, 'Male', 'Full Stack Developer', 'Job Portal', 'MERN stack specialist', NULL, 'Selected', 1, '2025-09-08 20:22:29'),
	(145, 'sarah_rec', 'Maria Garcia', 'maria.garcia@email.com', 555, 'Female', 'QA Engineer', 'LinkedIn', 'Automation testing expert', NULL, 'Selected', 1, '2025-08-13 20:22:29'),
	(146, 'mike_rec', 'David Kim', 'david.kim@email.com', 555, 'Male', 'Data Analyst', 'Indeed', 'SQL and Python analytics', NULL, 'Selected', 1, '2025-09-20 20:22:29'),
	(147, 'sarah_rec', 'Lisa Anderson', 'lisa.anderson@email.com', 555, 'Female', 'Product Manager', 'Referral', 'Agile methodology expert', NULL, 'Selected', 1, '2025-08-31 20:22:29'),
	(148, 'mike_rec', 'Michael Brown', 'michael.brown@email.com', 555, 'Male', 'UI/UX Designer', 'Company Website', 'Award-winning designer', NULL, 'Selected', 1, '2025-10-01 20:22:29'),
	(149, 'sarah_rec', 'Jennifer Lee', 'jennifer.lee@email.com', 555, 'Female', 'Mobile Developer', 'LinkedIn', 'iOS and Android expert', NULL, 'Selected', 1, '2025-09-15 20:22:29'),
	(150, 'mike_rec', 'Thomas Wilson', 'thomas.wilson@email.com', 555, 'Male', 'Security Engineer', 'Job Portal', 'Cybersecurity certified', NULL, 'Selected', 1, '2025-09-19 20:22:29'),
	(151, 'sarah_rec', 'Amanda Taylor', 'amanda.taylor@email.com', 555, 'Female', 'Business Analyst', 'Indeed', 'Strong communication skills', NULL, 'Selected', 1, '2025-09-01 20:22:29'),
	(152, 'mike_rec', 'Christopher Davis', 'chris.davis@email.com', 555, 'Male', 'Cloud Architect', 'LinkedIn', 'AWS and Azure certified', NULL, 'Selected', 1, '2025-09-01 20:22:29'),
	(153, 'sarah_rec', 'Jessica Martinez', 'jessica.m@email.com', 555, 'Female', 'Data Scientist', 'Referral', 'ML and AI specialist', NULL, 'Selected', 1, '2025-08-27 20:22:29'),
	(154, 'mike_rec', 'Daniel White', 'daniel.white@email.com', 555, 'Male', 'Tech Lead', 'Company Website', 'Team leadership experience', NULL, 'Selected', 1, '2025-08-22 20:22:29'),
	(155, 'sarah_rec', 'Matthew Harris', 'matthew.h@email.com', 555, 'Male', 'Software Engineer', 'LinkedIn', 'Second round interview scheduled', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(156, 'mike_rec', 'Sarah Thompson', 'sarah.t@email.com', 555, 'Female', 'Frontend Developer', 'Indeed', 'Technical assessment completed', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(157, 'sarah_rec', 'Kevin Moore', 'kevin.moore@email.com', 555, 'Male', 'Backend Developer', 'Job Portal', 'Coding challenge passed', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(158, 'mike_rec', 'Rachel Green', 'rachel.green@email.com', 555, 'Female', 'QA Automation', 'Referral', 'First interview completed', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(159, 'sarah_rec', 'Brian Clark', 'brian.clark@email.com', 555, 'Male', 'DevOps Engineer', 'LinkedIn', 'Technical round in progress', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(160, 'mike_rec', 'Nicole Adams', 'nicole.adams@email.com', 555, 'Female', 'Product Designer', 'Company Website', 'Portfolio review completed', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(161, 'sarah_rec', 'Justin Baker', 'justin.baker@email.com', 555, 'Male', 'Data Engineer', 'Indeed', 'SQL test passed', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(162, 'mike_rec', 'Melissa Scott', 'melissa.scott@email.com', 555, 'Female', 'Scrum Master', 'Referral', 'HR interview done', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(163, 'sarah_rec', 'Ryan Phillips', 'ryan.phillips@email.com', 555, 'Male', 'Mobile Developer', 'LinkedIn', 'App demo scheduled', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(164, 'mike_rec', 'Laura Mitchell', 'laura.mitchell@email.com', 555, 'Female', 'Business Analyst', 'Job Portal', 'Case study submitted', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(165, 'sarah_rec', 'Eric Turner', 'eric.turner@email.com', 555, 'Male', 'Full Stack Developer', 'Indeed', 'Final round pending', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(166, 'mike_rec', 'Stephanie Hill', 'stephanie.hill@email.com', 555, 'Female', 'UI Designer', 'Company Website', 'Design challenge completed', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(167, 'sarah_rec', 'Brandon Lewis', 'brandon.lewis@email.com', 555, 'Male', 'Security Analyst', 'LinkedIn', 'Security assessment done', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(168, 'mike_rec', 'Christina Young', 'christina.young@email.com', 555, 'Female', 'Project Manager', 'Referral', 'Management interview scheduled', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(169, 'sarah_rec', 'Gregory King', 'gregory.king@email.com', 555, 'Male', 'Cloud Engineer', 'Indeed', 'AWS certification verified', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(170, 'mike_rec', 'Samantha Wright', 'samantha.wright@email.com', 555, 'Female', 'Data Analyst', 'Job Portal', 'Analytics test completed', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(171, 'sarah_rec', 'Patrick Lopez', 'patrick.lopez@email.com', 555, 'Male', 'Software Architect', 'LinkedIn', 'Architecture review pending', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(172, 'mike_rec', 'Angela Hall', 'angela.hall@email.com', 555, 'Female', 'QA Lead', 'Company Website', 'Leadership assessment done', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(173, 'sarah_rec', 'Timothy Allen', 'timothy.allen@email.com', 555, 'Male', 'Backend Engineer', 'Referral', 'System design interview scheduled', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(174, 'mike_rec', 'Rebecca Nelson', 'rebecca.nelson@email.com', 555, 'Female', 'Frontend Engineer', 'Indeed', 'React assessment passed', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(175, 'sarah_rec', 'Kenneth Carter', 'kenneth.carter@email.com', 555, 'Male', 'DevOps Lead', 'LinkedIn', 'CI/CD knowledge verified', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(176, 'mike_rec', 'Michelle Perez', 'michelle.perez@email.com', 555, 'Female', 'UX Researcher', 'Job Portal', 'Research presentation done', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(177, 'sarah_rec', 'Steven Roberts', 'steven.roberts@email.com', 555, 'Male', 'Machine Learning Engineer', 'Referral', 'ML model review pending', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(178, 'mike_rec', 'Kimberly Edwards', 'kimberly.edwards@email.com', 555, 'Female', 'Technical Writer', 'Company Website', 'Writing sample submitted', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(179, 'sarah_rec', 'Jason Collins', 'jason.collins@email.com', 555, 'Male', 'Site Reliability Engineer', 'LinkedIn', 'SRE assessment completed', NULL, 'In Process', 1, '2025-11-12 00:42:35'),
	(180, 'sarah_rec', 'Andrew Stewart', 'andrew.stewart@email.com', 555, 'Male', 'Software Developer', 'Indeed', 'Strong coding skills', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(181, 'mike_rec', 'Brittany Morris', 'brittany.morris@email.com', 555, 'Female', 'Frontend Developer', 'LinkedIn', 'React and Vue experience', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(182, 'sarah_rec', 'Joshua Rogers', 'joshua.rogers@email.com', 555, 'Male', 'Backend Developer', 'Job Portal', 'Node.js specialist', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(183, 'mike_rec', 'Megan Reed', 'megan.reed@email.com', 555, 'Female', 'QA Engineer', 'Referral', 'Manual and automation testing', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(184, 'sarah_rec', 'Nathan Cook', 'nathan.cook@email.com', 555, 'Male', 'DevOps Engineer', 'Company Website', 'Docker and Kubernetes', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(185, 'mike_rec', 'Heather Morgan', 'heather.morgan@email.com', 555, 'Female', 'Product Manager', 'LinkedIn', 'Product strategy experience', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(186, 'sarah_rec', 'Aaron Bell', 'aaron.bell@email.com', 555, 'Male', 'Data Scientist', 'Indeed', 'Python and R programming', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(187, 'mike_rec', 'Danielle Murphy', 'danielle.murphy@email.com', 555, 'Female', 'UI/UX Designer', 'Job Portal', 'Figma and Adobe XD', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(188, 'sarah_rec', 'Jeremy Bailey', 'jeremy.bailey@email.com', 555, 'Male', 'Mobile Developer', 'Referral', 'Flutter and React Native', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(189, 'mike_rec', 'Katherine Rivera', 'katherine.rivera@email.com', 555, 'Female', 'Business Analyst', 'Company Website', 'Requirements gathering', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(190, 'sarah_rec', 'Tyler Cooper', 'tyler.cooper@email.com', 555, 'Male', 'Full Stack Developer', 'LinkedIn', 'MEAN stack developer', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(191, 'mike_rec', 'Amber Richardson', 'amber.richardson@email.com', 555, 'Female', 'Scrum Master', 'Indeed', 'Agile certified', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(192, 'sarah_rec', 'Jordan Cox', 'jordan.cox@email.com', 555, 'Male', 'Cloud Engineer', 'Job Portal', 'Azure specialist', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(193, 'mike_rec', 'Crystal Howard', 'crystal.howard@email.com', 555, 'Female', 'Data Analyst', 'Referral', 'Tableau and Power BI', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(194, 'sarah_rec', 'Austin Ward', 'austin.ward@email.com', 555, 'Male', 'Security Engineer', 'LinkedIn', 'Penetration testing', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(195, 'mike_rec', 'Courtney Torres', 'courtney.torres@email.com', 555, 'Female', 'Technical Lead', 'Company Website', 'Team management', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(196, 'sarah_rec', 'Marcus Peterson', 'marcus.peterson@email.com', 555, 'Male', 'Software Engineer', 'Indeed', 'Java and Spring Boot', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(197, 'mike_rec', 'Vanessa Gray', 'vanessa.gray@email.com', 555, 'Female', 'Frontend Developer', 'Job Portal', 'Angular specialist', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(198, 'sarah_rec', 'Carl Ramirez', 'carl.ramirez@email.com', 555, 'Male', 'Backend Developer', 'Referral', 'Django and Flask', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(199, 'mike_rec', 'Tiffany James', 'tiffany.james@email.com', 555, 'Female', 'QA Automation', 'LinkedIn', 'Selenium and Cypress', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(200, 'sarah_rec', 'Victor Watson', 'victor.watson@email.com', 555, 'Male', 'DevOps Engineer', 'Company Website', 'Jenkins and GitLab CI', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(201, 'mike_rec', 'Monica Brooks', 'monica.brooks@email.com', 555, 'Female', 'Product Designer', 'Indeed', 'User research expert', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(202, 'sarah_rec', 'Keith Kelly', 'keith.kelly@email.com', 555, 'Male', 'Data Engineer', 'Job Portal', 'ETL and data pipelines', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(203, 'mike_rec', 'Jacqueline Sanders', 'jacqueline.sanders@email.com', 555, 'Female', 'Project Manager', 'Referral', 'PMP certified', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(204, 'sarah_rec', 'Sean Price', 'sean.price@email.com', 555, 'Male', 'Mobile Developer', 'LinkedIn', 'Swift and Kotlin', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(205, 'mike_rec', 'Denise Bennett', 'denise.bennett@email.com', 555, 'Female', 'Business Analyst', 'Company Website', 'Process improvement', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(206, 'sarah_rec', 'Craig Wood', 'craig.wood@email.com', 555, 'Male', 'Full Stack Developer', 'Indeed', 'PHP and Laravel', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(207, 'mike_rec', 'Cheryl Barnes', 'cheryl.barnes@email.com', 555, 'Female', 'UI Designer', 'Job Portal', 'Responsive design', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(208, 'sarah_rec', 'Philip Ross', 'philip.ross@email.com', 555, 'Male', 'Security Analyst', 'Referral', 'CISSP certified', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(209, 'mike_rec', 'Janet Henderson', 'janet.henderson@email.com', 555, 'Female', 'Scrum Master', 'LinkedIn', 'SAFe certified', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(210, 'sarah_rec', 'Douglas Coleman', 'douglas.coleman@email.com', 555, 'Male', 'Cloud Architect', 'Company Website', 'Multi-cloud experience', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(211, 'mike_rec', 'Teresa Jenkins', 'teresa.jenkins@email.com', 555, 'Female', 'Data Analyst', 'Indeed', 'Statistical analysis', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(212, 'sarah_rec', 'Peter Perry', 'peter.perry@email.com', 555, 'Male', 'Software Architect', 'Job Portal', 'Microservices design', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(213, 'mike_rec', 'Frances Powell', 'frances.powell@email.com', 555, 'Female', 'QA Lead', 'Referral', 'Test strategy planning', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(214, 'sarah_rec', 'Harold Long', 'harold.long@email.com', 555, 'Male', 'Backend Engineer', 'LinkedIn', 'Go and Rust', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(215, 'mike_rec', 'Evelyn Patterson', 'evelyn.patterson@email.com', 555, 'Female', 'Frontend Engineer', 'Company Website', 'TypeScript expert', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(216, 'sarah_rec', 'Henry Hughes', 'henry.hughes@email.com', 555, 'Male', 'DevOps Lead', 'Indeed', 'Infrastructure as code', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(217, 'mike_rec', 'Diane Flores', 'diane.flores@email.com', 555, 'Female', 'UX Researcher', 'Job Portal', 'User testing', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(218, 'sarah_rec', 'Walter Washington', 'walter.washington@email.com', 555, 'Male', 'ML Engineer', 'Referral', 'TensorFlow and PyTorch', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(219, 'mike_rec', 'Joyce Butler', 'joyce.butler@email.com', 555, 'Female', 'Technical Writer', 'LinkedIn', 'API documentation', NULL, 'Shortlisted', 0, '2025-11-12 00:42:35'),
	(220, 'sarah_rec', 'Arthur Simmons', 'arthur.simmons@email.com', 555, 'Male', 'Software Developer', 'Indeed', 'Did not meet technical requirements', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(221, 'mike_rec', 'Gloria Foster', 'gloria.foster@email.com', 555, 'Female', 'Frontend Developer', 'LinkedIn', 'Insufficient experience', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(222, 'sarah_rec', 'Ralph Gonzales', 'ralph.gonzales@email.com', 555, 'Male', 'Backend Developer', 'Job Portal', 'Failed coding assessment', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(223, 'mike_rec', 'Doris Bryant', 'doris.bryant@email.com', 555, 'Female', 'QA Engineer', 'Referral', 'Not a cultural fit', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(224, 'sarah_rec', 'Roy Alexander', 'roy.alexander@email.com', 555, 'Male', 'DevOps Engineer', 'Company Website', 'Salary expectations too high', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(225, 'mike_rec', 'Marilyn Russell', 'marilyn.russell@email.com', 555, 'Female', 'Product Manager', 'LinkedIn', 'Lack of product experience', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(226, 'sarah_rec', 'Eugene Griffin', 'eugene.griffin@email.com', 555, 'Male', 'Data Scientist', 'Indeed', 'Weak statistical knowledge', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(227, 'mike_rec', 'Beverly Diaz', 'beverly.diaz@email.com', 555, 'Female', 'UI/UX Designer', 'Job Portal', 'Portfolio not strong enough', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(228, 'sarah_rec', 'Russell Hayes', 'russell.hayes@email.com', 555, 'Male', 'Mobile Developer', 'Referral', 'Limited mobile experience', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(229, 'mike_rec', 'Judith Myers', 'judith.myers@email.com', 555, 'Female', 'Business Analyst', 'Company Website', 'Poor communication skills', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(230, 'sarah_rec', 'Willie Ford', 'willie.ford@email.com', 555, 'Male', 'Full Stack Developer', 'LinkedIn', 'Failed technical interview', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(231, 'mike_rec', 'Virginia Hamilton', 'virginia.hamilton@email.com', 555, 'Female', 'Scrum Master', 'Indeed', 'No agile certification', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(232, 'sarah_rec', 'Albert Graham', 'albert.graham@email.com', 555, 'Male', 'Cloud Engineer', 'Job Portal', 'Insufficient cloud knowledge', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(233, 'mike_rec', 'Kathryn Sullivan', 'kathryn.sullivan@email.com', 555, 'Female', 'Data Analyst', 'Referral', 'Weak SQL skills', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(234, 'sarah_rec', 'Lawrence Wallace', 'lawrence.wallace@email.com', 555, 'Male', 'Security Engineer', 'LinkedIn', 'No security certifications', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(235, 'mike_rec', 'Pamela Woods', 'pamela.woods@email.com', 555, 'Female', 'Technical Lead', 'Company Website', 'Lack of leadership experience', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(236, 'sarah_rec', 'Joe West', 'joe.west@email.com', 555, 'Male', 'Software Engineer', 'Indeed', 'Overqualified for position', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(237, 'mike_rec', 'Carolyn Cole', 'carolyn.cole@email.com', 555, 'Female', 'Frontend Developer', 'Job Portal', 'Relocated to different city', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(238, 'sarah_rec', 'Ernest Owens', 'ernest.owens@email.com', 555, 'Male', 'Backend Developer', 'Referral', 'Accepted another offer', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(239, 'mike_rec', 'Martha Reynolds', 'martha.reynolds@email.com', 555, 'Female', 'QA Automation', 'LinkedIn', 'Not available for start date', NULL, 'Rejected', 0, '2025-11-12 00:42:35'),
	(240, 'sarah_rec', 'Louis Fisher', 'louis.fisher@email.com', 555, 'Male', 'Software Developer', 'Company Website', 'Waiting for budget approval', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(241, 'mike_rec', 'Sara Porter', 'sara.porter@email.com', 555, 'Female', 'Frontend Developer', 'Indeed', 'Position temporarily frozen', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(242, 'sarah_rec', 'Jack Hunter', 'jack.hunter@email.com', 555, 'Male', 'Backend Developer', 'LinkedIn', 'Pending reference checks', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(243, 'mike_rec', 'Alice Hicks', 'alice.hicks@email.com', 555, 'Female', 'QA Engineer', 'Job Portal', 'Awaiting team decision', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(244, 'sarah_rec', 'Gerald Crawford', 'gerald.crawford@email.com', 555, 'Male', 'DevOps Engineer', 'Referral', 'Waiting for project confirmation', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(245, 'mike_rec', 'Judith Boyd', 'judith.boyd@email.com', 555, 'Female', 'Product Manager', 'Company Website', 'Budget review in progress', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(246, 'sarah_rec', 'Carl Mason', 'carl.mason@email.com', 555, 'Male', 'Data Scientist', 'LinkedIn', 'Headcount approval pending', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(247, 'mike_rec', 'Madison Dixon', 'madison.dixon@email.com', 555, 'Female', 'UI/UX Designer', 'Indeed', 'Waiting for design team feedback', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(248, 'sarah_rec', 'Keith Reid', 'keith.reid@email.com', 555, 'Male', 'Mobile Developer', 'Job Portal', 'Project timeline uncertain', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(249, 'mike_rec', 'Judy Fox', 'judy.fox@email.com', 555, 'Female', 'Business Analyst', 'Referral', 'Department restructuring', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(250, 'sarah_rec', 'Willie McDonald', 'willie.mcdonald@email.com', 555, 'Male', 'Full Stack Developer', 'Company Website', 'Waiting for senior approval', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(251, 'mike_rec', 'Theresa Kennedy', 'theresa.kennedy@email.com', 555, 'Female', 'Scrum Master', 'LinkedIn', 'Team capacity review', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(252, 'sarah_rec', 'Lawrence Wells', 'lawrence.wells@email.com', 555, 'Male', 'Cloud Engineer', 'Indeed', 'Cloud migration timeline TBD', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(253, 'mike_rec', 'Deborah Vargas', 'deborah.vargas@email.com', 555, 'Female', 'Data Analyst', 'Job Portal', 'Analytics team expansion on hold', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(254, 'sarah_rec', 'Nicholas Chavez', 'nicholas.chavez@email.com', 555, 'Male', 'Security Engineer', 'Referral', 'Security audit completion pending', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(255, 'mike_rec', 'Julie Sims', 'julie.sims@email.com', 555, 'Female', 'Technical Lead', 'Company Website', 'Leadership structure review', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(256, 'sarah_rec', 'Bruce Castillo', 'bruce.castillo@email.com', 555, 'Male', 'Software Engineer', 'LinkedIn', 'Waiting for team availability', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(257, 'mike_rec', 'Olivia Montgomery', 'olivia.montgomery@email.com', 555, 'Female', 'Frontend Developer', 'Indeed', 'Project scope clarification needed', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(258, 'sarah_rec', 'Billy Richards', 'billy.richards@email.com', 555, 'Male', 'Backend Developer', 'Job Portal', 'Tech stack decision pending', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(259, 'mike_rec', 'Emma Williamson', 'emma.williamson@email.com', 555, 'Female', 'QA Automation', 'Referral', 'QA process review in progress', NULL, 'Hold', 0, '2025-11-12 00:42:35'),
	(260, 'johndoe', 'test candidate 1', 'testcandidate1@gmail.com', 21321321321, 'Not Specified', 'Not Specified', 'Admin Portal', 'Created via admin panel', NULL, 'New', 0, '2025-11-12 01:24:41'),
	(262, 'system', 'Charaka Creations', 'charakacreations@gmail.com', 0, 'Not Specified', 'Not Specified', 'Google OAuth', 'Registered via Google Sign-In', NULL, 'New', 0, '2025-11-14 06:52:42');

-- Dumping structure for table cmsadver_rmsdb.candidate_documents
DROP TABLE IF EXISTS `candidate_documents`;
CREATE TABLE IF NOT EXISTS `candidate_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_username` varchar(100) NOT NULL,
  `document_type` enum('resume','cover_letter','certificate','portfolio','other') NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(500) NOT NULL,
  `file_size` int(11) NOT NULL COMMENT 'in bytes',
  `uploaded_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `candidate_username` (`candidate_username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.candidate_documents: ~0 rows (approximately)
DELETE FROM `candidate_documents`;

-- Dumping structure for table cmsadver_rmsdb.candidate_education
DROP TABLE IF EXISTS `candidate_education`;
CREATE TABLE IF NOT EXISTS `candidate_education` (
  `education_id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_id` int(11) NOT NULL,
  `institution` varchar(255) NOT NULL,
  `degree` varchar(255) NOT NULL,
  `field_of_study` varchar(255) DEFAULT NULL,
  `start_year` int(11) DEFAULT NULL,
  `end_year` int(11) DEFAULT NULL,
  `grade` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`education_id`),
  KEY `idx_candidate` (`candidate_id`),
  CONSTRAINT `candidate_education_ibfk_1` FOREIGN KEY (`candidate_id`) REFERENCES `sourced_candidates` (`candidate_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.candidate_education: ~0 rows (approximately)
DELETE FROM `candidate_education`;

-- Dumping structure for table cmsadver_rmsdb.candidate_engagement
DROP TABLE IF EXISTS `candidate_engagement`;
CREATE TABLE IF NOT EXISTS `candidate_engagement` (
  `engagement_id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_id` int(11) NOT NULL,
  `engagement_type` varchar(50) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `sent_by` varchar(100) DEFAULT NULL,
  `sent_at` timestamp NULL DEFAULT current_timestamp(),
  `response_received` tinyint(1) DEFAULT 0,
  `response_date` datetime DEFAULT NULL,
  `notes` text DEFAULT NULL,
  PRIMARY KEY (`engagement_id`),
  KEY `idx_candidate` (`candidate_id`),
  CONSTRAINT `candidate_engagement_ibfk_1` FOREIGN KEY (`candidate_id`) REFERENCES `sourced_candidates` (`candidate_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.candidate_engagement: ~0 rows (approximately)
DELETE FROM `candidate_engagement`;

-- Dumping structure for table cmsadver_rmsdb.candidate_experience
DROP TABLE IF EXISTS `candidate_experience`;
CREATE TABLE IF NOT EXISTS `candidate_experience` (
  `experience_id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `is_current` tinyint(1) DEFAULT 0,
  `description` text DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`experience_id`),
  KEY `idx_candidate` (`candidate_id`),
  CONSTRAINT `candidate_experience_ibfk_1` FOREIGN KEY (`candidate_id`) REFERENCES `sourced_candidates` (`candidate_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.candidate_experience: ~0 rows (approximately)
DELETE FROM `candidate_experience`;

-- Dumping structure for table cmsadver_rmsdb.candidate_pipeline
DROP TABLE IF EXISTS `candidate_pipeline`;
CREATE TABLE IF NOT EXISTS `candidate_pipeline` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_id` int(11) NOT NULL,
  `stage_id` int(11) NOT NULL,
  `moved_by` int(11) DEFAULT NULL,
  `moved_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `notes` text DEFAULT NULL,
  `urgency_level` enum('low','medium','high','critical') DEFAULT 'medium',
  `days_in_stage` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `candidate_id` (`candidate_id`),
  KEY `stage_id` (`stage_id`),
  KEY `moved_by` (`moved_by`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.candidate_pipeline: ~21 rows (approximately)
DELETE FROM `candidate_pipeline`;
INSERT INTO `candidate_pipeline` (`id`, `candidate_id`, `stage_id`, `moved_by`, `moved_at`, `notes`, `urgency_level`, `days_in_stage`) VALUES
	(1, 1, 1, NULL, '2025-10-25 18:00:40', NULL, 'medium', 14),
	(2, 2, 2, NULL, '2025-10-25 18:00:40', NULL, 'high', 14),
	(3, 3, 2, NULL, '2025-10-30 18:00:40', NULL, 'medium', 9),
	(4, 4, 3, NULL, '2025-11-01 18:00:40', NULL, 'high', 7),
	(5, 5, 3, NULL, '2025-11-03 18:00:40', NULL, 'critical', 5),
	(6, 6, 4, NULL, '2025-11-06 18:00:40', NULL, 'medium', 2),
	(7, 7, 4, NULL, '2025-11-02 18:00:41', NULL, 'high', 6),
	(8, 8, 5, NULL, '2025-10-27 18:00:41', NULL, 'medium', 12),
	(9, 9, 5, NULL, '2025-10-25 18:00:41', NULL, 'low', 14),
	(10, 10, 6, NULL, '2025-11-01 18:00:41', NULL, 'high', 7),
	(11, 11, 1, NULL, '2025-10-27 18:00:41', NULL, 'medium', 12),
	(12, 12, 1, NULL, '2025-11-05 18:00:41', NULL, 'low', 3),
	(13, 13, 2, NULL, '2025-11-04 18:00:41', NULL, 'critical', 4),
	(14, 14, 3, NULL, '2025-11-04 18:00:41', NULL, 'medium', 4),
	(15, 15, 4, NULL, '2025-10-31 18:00:41', NULL, 'low', 8),
	(16, 10, 6, 1, '2025-11-08 18:02:01', '', 'medium', 0),
	(17, 10, 6, 1, '2025-11-08 18:02:07', '', 'medium', 0),
	(18, 10, 7, 1, '2025-11-08 18:04:46', 'Add', 'medium', 0),
	(19, 10, 8, 1, '2025-11-08 18:04:56', 'rejected', 'medium', 0),
	(20, 10, 8, 1, '2025-11-08 18:09:05', 'test', 'medium', 0),
	(21, 10, 7, 1, '2025-11-08 18:09:14', 'hired', 'medium', 0);

-- Dumping structure for table cmsadver_rmsdb.candidate_skills
DROP TABLE IF EXISTS `candidate_skills`;
CREATE TABLE IF NOT EXISTS `candidate_skills` (
  `skill_id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_id` int(11) NOT NULL,
  `skill_name` varchar(100) NOT NULL,
  `proficiency_level` varchar(50) DEFAULT NULL,
  `years_of_experience` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`skill_id`),
  KEY `idx_candidate` (`candidate_id`),
  KEY `idx_skill` (`skill_name`),
  CONSTRAINT `candidate_skills_ibfk_1` FOREIGN KEY (`candidate_id`) REFERENCES `sourced_candidates` (`candidate_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.candidate_skills: ~65 rows (approximately)
DELETE FROM `candidate_skills`;
INSERT INTO `candidate_skills` (`skill_id`, `candidate_id`, `skill_name`, `proficiency_level`, `years_of_experience`, `created_at`) VALUES
	(1, 1, 'JavaScript', 'Intermediate', NULL, '2025-11-14 14:11:02'),
	(2, 1, 'React', 'Intermediate', NULL, '2025-11-14 14:11:02'),
	(3, 1, 'Node.js', 'Intermediate', NULL, '2025-11-14 14:11:02'),
	(4, 1, 'Python', 'Intermediate', NULL, '2025-11-14 14:11:02'),
	(5, 1, 'AWS', 'Intermediate', NULL, '2025-11-14 14:11:02'),
	(6, 2, 'Python', 'Intermediate', NULL, '2025-11-14 14:11:02'),
	(7, 2, 'Machine Learning', 'Intermediate', NULL, '2025-11-14 14:11:02'),
	(8, 2, 'TensorFlow', 'Intermediate', NULL, '2025-11-14 14:11:02'),
	(9, 2, 'SQL', 'Intermediate', NULL, '2025-11-14 14:11:02'),
	(10, 2, 'R', 'Intermediate', NULL, '2025-11-14 14:11:02'),
	(11, 3, 'Docker', 'Intermediate', NULL, '2025-11-14 14:11:02'),
	(12, 3, 'Kubernetes', 'Intermediate', NULL, '2025-11-14 14:11:02'),
	(13, 3, 'AWS', 'Intermediate', NULL, '2025-11-14 14:11:02'),
	(14, 3, 'Jenkins', 'Intermediate', NULL, '2025-11-14 14:11:02'),
	(15, 3, 'Terraform', 'Intermediate', NULL, '2025-11-14 14:11:02'),
	(16, 4, 'Figma', 'Intermediate', NULL, '2025-11-14 14:11:02'),
	(17, 4, 'Adobe XD', 'Intermediate', NULL, '2025-11-14 14:11:02'),
	(18, 4, 'Sketch', 'Intermediate', NULL, '2025-11-14 14:11:02'),
	(19, 4, 'User Research', 'Intermediate', NULL, '2025-11-14 14:11:02'),
	(20, 4, 'Prototyping', 'Intermediate', NULL, '2025-11-14 14:11:02'),
	(21, 5, 'Product Strategy', 'Intermediate', NULL, '2025-11-14 14:11:02'),
	(22, 5, 'Agile', 'Intermediate', NULL, '2025-11-14 14:11:02'),
	(23, 5, 'Jira', 'Intermediate', NULL, '2025-11-14 14:11:02'),
	(24, 5, 'Analytics', 'Intermediate', NULL, '2025-11-14 14:11:02'),
	(25, 5, 'Roadmapping', 'Intermediate', NULL, '2025-11-14 14:11:02'),
	(26, 6, 'JavaScript', 'Intermediate', NULL, '2025-11-14 18:44:00'),
	(27, 6, 'React', 'Intermediate', NULL, '2025-11-14 18:44:00'),
	(28, 6, 'Node.js', 'Intermediate', NULL, '2025-11-14 18:44:00'),
	(29, 6, 'AWS', 'Intermediate', NULL, '2025-11-14 18:44:00'),
	(30, 6, 'Docker', 'Intermediate', NULL, '2025-11-14 18:44:00'),
	(31, 7, 'Python', 'Intermediate', NULL, '2025-11-14 18:44:00'),
	(32, 7, 'Machine Learning', 'Intermediate', NULL, '2025-11-14 18:44:00'),
	(33, 7, 'TensorFlow', 'Intermediate', NULL, '2025-11-14 18:44:01'),
	(34, 7, 'SQL', 'Intermediate', NULL, '2025-11-14 18:44:01'),
	(35, 7, 'R', 'Intermediate', NULL, '2025-11-14 18:44:01'),
	(36, 8, 'Kubernetes', 'Intermediate', NULL, '2025-11-14 18:44:01'),
	(37, 8, 'Docker', 'Intermediate', NULL, '2025-11-14 18:44:01'),
	(38, 8, 'Jenkins', 'Intermediate', NULL, '2025-11-14 18:44:01'),
	(39, 8, 'Terraform', 'Intermediate', NULL, '2025-11-14 18:44:01'),
	(40, 8, 'AWS', 'Intermediate', NULL, '2025-11-14 18:44:01'),
	(41, 9, 'Product Management', 'Intermediate', NULL, '2025-11-14 18:44:01'),
	(42, 9, 'Agile', 'Intermediate', NULL, '2025-11-14 18:44:01'),
	(43, 9, 'Scrum', 'Intermediate', NULL, '2025-11-14 18:44:01'),
	(44, 9, 'User Research', 'Intermediate', NULL, '2025-11-14 18:44:01'),
	(45, 9, 'Analytics', 'Intermediate', NULL, '2025-11-14 18:44:01'),
	(46, 10, 'UI/UX Design', 'Intermediate', NULL, '2025-11-14 18:44:01'),
	(47, 10, 'Figma', 'Intermediate', NULL, '2025-11-14 18:44:01'),
	(48, 10, 'Adobe XD', 'Intermediate', NULL, '2025-11-14 18:44:01'),
	(49, 10, 'User Research', 'Intermediate', NULL, '2025-11-14 18:44:01'),
	(50, 10, 'Prototyping', 'Intermediate', NULL, '2025-11-14 18:44:01'),
	(51, 11, 'JavaScript', 'Intermediate', NULL, '2025-11-14 18:44:01'),
	(52, 11, 'Vue.js', 'Intermediate', NULL, '2025-11-14 18:44:01'),
	(53, 11, 'CSS', 'Intermediate', NULL, '2025-11-14 18:44:01'),
	(54, 11, 'HTML5', 'Intermediate', NULL, '2025-11-14 18:44:01'),
	(55, 11, 'Responsive Design', 'Intermediate', NULL, '2025-11-14 18:44:01'),
	(56, 12, 'Java', 'Intermediate', NULL, '2025-11-14 18:44:01'),
	(57, 12, 'Spring Boot', 'Intermediate', NULL, '2025-11-14 18:44:01'),
	(58, 12, 'Microservices', 'Intermediate', NULL, '2025-11-14 18:44:01'),
	(59, 12, 'PostgreSQL', 'Intermediate', NULL, '2025-11-14 18:44:01'),
	(60, 12, 'Redis', 'Intermediate', NULL, '2025-11-14 18:44:01'),
	(61, 13, 'Test Automation', 'Intermediate', NULL, '2025-11-14 18:44:01'),
	(62, 13, 'Selenium', 'Intermediate', NULL, '2025-11-14 18:44:01'),
	(63, 13, 'Jest', 'Intermediate', NULL, '2025-11-14 18:44:01'),
	(64, 13, 'Cypress', 'Intermediate', NULL, '2025-11-14 18:44:01'),
	(65, 13, 'API Testing', 'Intermediate', NULL, '2025-11-14 18:44:01');

-- Dumping structure for table cmsadver_rmsdb.candidate_sources
DROP TABLE IF EXISTS `candidate_sources`;
CREATE TABLE IF NOT EXISTS `candidate_sources` (
  `source_id` int(11) NOT NULL AUTO_INCREMENT,
  `source_name` varchar(100) NOT NULL,
  `source_type` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`source_id`),
  UNIQUE KEY `source_name` (`source_name`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.candidate_sources: ~10 rows (approximately)
DELETE FROM `candidate_sources`;
INSERT INTO `candidate_sources` (`source_id`, `source_name`, `source_type`, `description`, `is_active`, `created_at`) VALUES
	(1, 'LinkedIn', 'Social Media', 'Professional networking platform', 1, '2025-11-14 14:05:07'),
	(2, 'Indeed', 'Job Board', 'Job search engine', 1, '2025-11-14 14:05:07'),
	(3, 'Monster', 'Job Board', 'Online job board', 1, '2025-11-14 14:05:07'),
	(4, 'Referral', 'Internal', 'Employee referrals', 1, '2025-11-14 14:05:07'),
	(5, 'Company Website', 'Direct', 'Career page applications', 1, '2025-11-14 14:05:07'),
	(6, 'GitHub', 'Social Media', 'Developer platform', 1, '2025-11-14 14:05:07'),
	(7, 'Stack Overflow', 'Social Media', 'Developer community', 1, '2025-11-14 14:05:07'),
	(8, 'University', 'Campus', 'Campus recruitment', 1, '2025-11-14 14:05:07'),
	(9, 'Job Fair', 'Event', 'Recruitment events', 1, '2025-11-14 14:05:07'),
	(10, 'Agency', 'External', 'Recruitment agencies', 1, '2025-11-14 14:05:07');

-- Dumping structure for table cmsadver_rmsdb.chat_history
DROP TABLE IF EXISTS `chat_history`;
CREATE TABLE IF NOT EXISTS `chat_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(100) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `sender` enum('user','bot') NOT NULL,
  `message` text NOT NULL,
  `intent` varchar(50) DEFAULT NULL,
  `confidence` decimal(5,2) DEFAULT NULL,
  `entities` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`entities`)),
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_session` (`session_id`),
  KEY `idx_user` (`user_id`),
  KEY `idx_timestamp` (`timestamp`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.chat_history: ~68 rows (approximately)
DELETE FROM `chat_history`;
INSERT INTO `chat_history` (`id`, `session_id`, `user_id`, `sender`, `message`, `intent`, `confidence`, `entities`, `timestamp`, `is_read`) VALUES
	(1, 'session_1763278602657', NULL, 'user', 'View jobs', NULL, NULL, NULL, '2025-11-16 03:06:46', 0),
	(2, 'session_1763278648389', NULL, 'user', 'Check status', NULL, NULL, NULL, '2025-11-16 03:07:32', 0),
	(3, 'session_1763278648389', NULL, 'bot', 'To check your application status, please log in first or provide your email address.', 'status_check', 0.67, NULL, '2025-11-16 03:07:32', 0),
	(4, 'session_1763278648389', NULL, 'user', 'Login', NULL, NULL, NULL, '2025-11-16 03:07:39', 0),
	(5, 'session_1763278648389', NULL, 'bot', 'We are a leading technology company specializing in innovative solutions for businesses across Sri Lanka and beyond. Our mission is to empower organizations through cutting-edge technology.', 'company_info', 0.40, NULL, '2025-11-16 03:07:39', 0),
	(6, 'session_1763278648389', NULL, 'user', 'Company benefits', NULL, NULL, NULL, '2025-11-16 03:07:41', 0),
	(7, 'session_1763278648389', NULL, 'bot', 'We are a leading technology company specializing in innovative solutions for businesses across Sri Lanka and beyond. Our mission is to empower organizations through cutting-edge technology.', 'company_info', 0.68, NULL, '2025-11-16 03:07:41', 0),
	(8, 'session_1763278648389', NULL, 'user', 'View jobs', NULL, NULL, NULL, '2025-11-16 03:07:50', 0),
	(9, 'session_1763282171189', NULL, 'user', 'Check status', NULL, NULL, NULL, '2025-11-16 04:06:15', 0),
	(10, 'session_1763282171189', NULL, 'bot', 'To check your application status, please log in first or provide your email address.', 'status_check', 0.67, NULL, '2025-11-16 04:06:15', 0),
	(11, 'session_1763282171189', NULL, 'user', 'Login', NULL, NULL, NULL, '2025-11-16 04:06:21', 0),
	(12, 'session_1763282171189', NULL, 'bot', 'We are a leading technology company specializing in innovative solutions for businesses across Sri Lanka and beyond. Our mission is to empower organizations through cutting-edge technology.', 'company_info', 0.40, NULL, '2025-11-16 04:06:21', 0),
	(13, 'session_1763282171189', NULL, 'user', 'View jobs', NULL, NULL, NULL, '2025-11-16 04:06:31', 0),
	(14, 'session_1763282171189', NULL, 'user', 'Company benefits', NULL, NULL, NULL, '2025-11-16 04:06:33', 0),
	(15, 'session_1763282171189', NULL, 'bot', 'We are a leading technology company specializing in innovative solutions for businesses across Sri Lanka and beyond. Our mission is to empower organizations through cutting-edge technology.', 'company_info', 0.68, NULL, '2025-11-16 04:06:33', 0),
	(16, 'session_1763282171189', NULL, 'user', 'Office location', NULL, NULL, NULL, '2025-11-16 04:06:36', 0),
	(17, 'session_1763282171189', NULL, 'bot', 'We are a leading technology company specializing in innovative solutions for businesses across Sri Lanka and beyond. Our mission is to empower organizations through cutting-edge technology.', 'company_info', 1.00, NULL, '2025-11-16 04:06:36', 0),
	(18, 'session_1763282171189', NULL, 'user', 'View jobs', NULL, NULL, NULL, '2025-11-16 04:06:38', 0),
	(19, 'session_1763282171189', NULL, 'user', 'Company benefits', NULL, NULL, NULL, '2025-11-16 04:07:14', 0),
	(20, 'session_1763282171189', NULL, 'bot', 'We are a leading technology company specializing in innovative solutions for businesses across Sri Lanka and beyond. Our mission is to empower organizations through cutting-edge technology.', 'company_info', 0.68, NULL, '2025-11-16 04:07:14', 0),
	(21, 'session_1763282462972', NULL, 'user', 'Check status', NULL, NULL, NULL, '2025-11-16 04:11:15', 0),
	(22, 'session_1763282462972', NULL, 'bot', 'To check your application status, please log in first or provide your email address.', 'status_check', 0.67, NULL, '2025-11-16 04:11:15', 0),
	(23, 'session_1763282462972', NULL, 'user', 'Login', NULL, NULL, NULL, '2025-11-16 04:11:17', 0),
	(24, 'session_1763282462972', NULL, 'bot', 'We are a leading technology company specializing in innovative solutions for businesses across Sri Lanka and beyond. Our mission is to empower organizations through cutting-edge technology.', 'company_info', 0.40, NULL, '2025-11-16 04:11:17', 0),
	(25, 'session_1763282462972', NULL, 'user', 'View jobs', NULL, NULL, NULL, '2025-11-16 04:11:19', 0),
	(26, 'session_1763282462972', NULL, 'user', 'Company benefits', NULL, NULL, NULL, '2025-11-16 04:11:22', 0),
	(27, 'session_1763282462972', NULL, 'bot', 'We are a leading technology company specializing in innovative solutions for businesses across Sri Lanka and beyond. Our mission is to empower organizations through cutting-edge technology.', 'company_info', 0.68, NULL, '2025-11-16 04:11:22', 0),
	(28, 'session_1763282462972', NULL, 'user', 'Company benefits', NULL, NULL, NULL, '2025-11-16 04:11:25', 0),
	(29, 'session_1763282462972', NULL, 'bot', 'We are a leading technology company specializing in innovative solutions for businesses across Sri Lanka and beyond. Our mission is to empower organizations through cutting-edge technology.', 'company_info', 0.68, NULL, '2025-11-16 04:11:25', 0),
	(30, 'session_1763282462972', NULL, 'user', 'Office location', NULL, NULL, NULL, '2025-11-16 04:11:27', 0),
	(31, 'session_1763282462972', NULL, 'bot', 'We are a leading technology company specializing in innovative solutions for businesses across Sri Lanka and beyond. Our mission is to empower organizations through cutting-edge technology.', 'company_info', 1.00, NULL, '2025-11-16 04:11:27', 0),
	(32, 'session_1763282462972', NULL, 'user', 'how many employee working that company', NULL, NULL, NULL, '2025-11-16 04:11:48', 0),
	(33, 'session_1763282462972', NULL, 'bot', 'We are a leading technology company specializing in innovative solutions for businesses across Sri Lanka and beyond. Our mission is to empower organizations through cutting-edge technology.', 'company_info', 0.57, NULL, '2025-11-16 04:11:48', 0),
	(34, 'session_1763282462972', NULL, 'user', 'Office location', NULL, NULL, NULL, '2025-11-16 04:11:58', 0),
	(35, 'session_1763282462972', NULL, 'bot', 'We are a leading technology company specializing in innovative solutions for businesses across Sri Lanka and beyond. Our mission is to empower organizations through cutting-edge technology.', 'company_info', 1.00, NULL, '2025-11-16 04:11:58', 0),
	(36, 'test_1763282566145', NULL, 'user', 'Hello bot', NULL, NULL, NULL, '2025-11-16 04:12:46', 0),
	(37, 'test_1763282710848', NULL, 'user', 'Hello', NULL, NULL, NULL, '2025-11-16 04:15:11', 0),
	(38, 'test_1763282710848', NULL, 'bot', 'We have the following positions available:\n\n\n\nWhich one would you like to know more about?', 'job_inquiry', 0.33, NULL, '2025-11-16 04:15:12', 0),
	(39, 'test_1763282710848', NULL, 'user', 'HI', NULL, NULL, NULL, '2025-11-16 04:15:16', 0),
	(40, 'test_1763282710848', NULL, 'bot', 'We have the following positions available:\n\n\n\nWhich one would you like to know more about?', 'job_inquiry', 0.16, NULL, '2025-11-16 04:15:16', 0),
	(41, 'test_1763282710848', NULL, 'user', 'i would like to apply Software Engineering jon', NULL, NULL, NULL, '2025-11-16 04:15:40', 0),
	(42, 'test_1763282710848', NULL, 'bot', 'We don\'t have any open positions listed at the moment, but you can still submit your CV for future opportunities! Our team reviews all applications and will contact you when suitable positions become available.', 'apply_job', 0.69, NULL, '2025-11-16 04:15:40', 0),
	(43, 'session_1763282804883', NULL, 'user', 'Check status', NULL, NULL, NULL, '2025-11-16 04:16:48', 0),
	(44, 'session_1763282804883', NULL, 'bot', 'To check your application status, please log in first or provide your email address.', 'status_check', 0.67, NULL, '2025-11-16 04:16:48', 0),
	(45, 'session_1763282804883', NULL, 'user', 'Provide email', NULL, NULL, NULL, '2025-11-16 04:16:51', 0),
	(46, 'session_1763282804883', NULL, 'bot', 'We are a leading technology company specializing in innovative solutions for businesses across Sri Lanka and beyond. Our mission is to empower organizations through cutting-edge technology.', 'company_info', 0.43, NULL, '2025-11-16 04:16:51', 0),
	(47, 'session_1763282804883', NULL, 'user', 'View jobs', NULL, NULL, NULL, '2025-11-16 04:16:53', 0),
	(48, 'session_1763282804883', NULL, 'bot', 'We have the following positions available:\n\n\n\nWhich one would you like to know more about?', 'job_inquiry', 0.48, NULL, '2025-11-16 04:16:53', 0),
	(49, 'session_1763283992872', NULL, 'user', 'Apply for a job', NULL, NULL, NULL, '2025-11-16 04:36:36', 0),
	(50, 'session_1763283992872', NULL, 'bot', 'We don\'t have any open positions listed at the moment, but you can still submit your CV for future opportunities! Our team reviews all applications and will contact you when suitable positions become available.', 'apply_job', 1.00, NULL, '2025-11-16 04:36:36', 0),
	(51, 'session_1763298234975', NULL, 'user', 'Check status', NULL, NULL, NULL, '2025-11-16 08:34:00', 0),
	(52, 'session_1763298234975', NULL, 'bot', 'To check your application status, please log in first or provide your email address.', 'status_check', 0.67, NULL, '2025-11-16 08:34:00', 0),
	(53, 'session_1763298234975', NULL, 'user', 'Provide email', NULL, NULL, NULL, '2025-11-16 08:34:03', 0),
	(54, 'session_1763298234975', NULL, 'bot', 'We are a leading technology company specializing in innovative solutions for businesses across Sri Lanka and beyond. Our mission is to empower organizations through cutting-edge technology.', 'company_info', 0.43, NULL, '2025-11-16 08:34:03', 0),
	(55, 'session_1763298234975', NULL, 'user', 'View jobs', NULL, NULL, NULL, '2025-11-16 08:34:04', 0),
	(56, 'session_1763298234975', NULL, 'bot', 'We have the following positions available:\n\n\n\nWhich one would you like to know more about?', 'job_inquiry', 0.48, NULL, '2025-11-16 08:34:04', 0),
	(57, 'session_1763344702171', NULL, 'user', 'Check status', NULL, NULL, NULL, '2025-11-16 21:29:03', 0),
	(58, 'session_1763344702171', NULL, 'bot', 'To check your application status, please log in first or provide your email address.', 'status_check', 0.67, NULL, '2025-11-16 21:29:04', 0),
	(59, 'session_1763344702171', NULL, 'user', 'Apply for a job', NULL, NULL, NULL, '2025-11-16 21:29:05', 0),
	(60, 'session_1763344702171', NULL, 'bot', 'We don\'t have any open positions listed at the moment, but you can still submit your CV for future opportunities! Our team reviews all applications and will contact you when suitable positions become available.', 'apply_job', 1.00, NULL, '2025-11-16 21:29:05', 0),
	(61, 'session_1763351859202', NULL, 'user', 'Apply for a job', NULL, NULL, NULL, '2025-11-16 23:27:43', 0),
	(62, 'session_1763351859202', NULL, 'bot', 'We don\'t have any open positions listed at the moment, but you can still submit your CV for future opportunities! Our team reviews all applications and will contact you when suitable positions become available.', 'apply_job', 1.00, NULL, '2025-11-16 23:27:44', 0),
	(63, 'session_1763351859202', NULL, 'user', 'Upload CV', NULL, NULL, NULL, '2025-11-16 23:27:47', 0),
	(64, 'session_1763351859202', NULL, 'bot', 'We don\'t have any open positions listed at the moment, but you can still submit your CV for future opportunities! Our team reviews all applications and will contact you when suitable positions become available.', 'apply_job', 1.00, NULL, '2025-11-16 23:27:47', 0),
	(65, 'session_1763351859202', NULL, 'user', 'Tell me about the company', NULL, NULL, NULL, '2025-11-16 23:27:49', 0),
	(66, 'session_1763351859202', NULL, 'bot', 'We are a leading technology company specializing in innovative solutions for businesses across Sri Lanka and beyond. Our mission is to empower organizations through cutting-edge technology.', 'company_info', 1.00, NULL, '2025-11-16 23:27:49', 0),
	(67, 'session_1763400481816', NULL, 'user', 'Check status', NULL, NULL, NULL, '2025-11-17 12:58:05', 0),
	(68, 'session_1763400481816', NULL, 'bot', 'To check your application status, please log in first or provide your email address.', 'status_check', 0.67, NULL, '2025-11-17 12:58:05', 0);

-- Dumping structure for table cmsadver_rmsdb.chat_sessions
DROP TABLE IF EXISTS `chat_sessions`;
CREATE TABLE IF NOT EXISTS `chat_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(100) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_type` enum('candidate','recruiter','interviewer','admin','guest') DEFAULT 'guest',
  `started_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_activity` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_active` tinyint(1) DEFAULT 1,
  `session_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`session_data`)),
  PRIMARY KEY (`id`),
  UNIQUE KEY `session_id` (`session_id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_session_id` (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.chat_sessions: ~0 rows (approximately)
DELETE FROM `chat_sessions`;

-- Dumping structure for table cmsadver_rmsdb.ci_sessions
DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT 0,
  `data` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table cmsadver_rmsdb.ci_sessions: ~2 rows (approximately)
DELETE FROM `ci_sessions`;
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
	('135tatm98u5qgvcpu4vla8kqgaslopf4', '::1', 1763460472, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736333436303437323b69647c733a323a223337223b757365726e616d657c733a373a2243686172616b61223b656d61696c7c733a32313a2263686172616b616e69626d40676d61696c2e636f6d223b526f6c657c733a353a2241646d696e223b61757468656e746963617465647c623a313b),
	('j2beukukqrv25m9j4lmlucc64uashd7d', '::1', 1763460623, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736333436303437323b69647c733a323a223337223b757365726e616d657c733a373a2243686172616b61223b656d61696c7c733a32313a2263686172616b616e69626d40676d61696c2e636f6d223b526f6c657c733a353a2241646d696e223b61757468656e746963617465647c623a313b);

-- Dumping structure for table cmsadver_rmsdb.company_settings
DROP TABLE IF EXISTS `company_settings`;
CREATE TABLE IF NOT EXISTS `company_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) NOT NULL,
  `company_email` varchar(255) NOT NULL,
  `company_phone` varchar(50) DEFAULT NULL,
  `company_logo` varchar(255) DEFAULT NULL,
  `company_address` text DEFAULT NULL,
  `company_city` varchar(100) DEFAULT NULL,
  `company_state` varchar(100) DEFAULT NULL,
  `company_country` varchar(100) DEFAULT NULL,
  `company_postal_code` varchar(20) DEFAULT NULL,
  `registration_number` varchar(100) DEFAULT NULL,
  `tax_id` varchar(100) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `business_hours_start` time DEFAULT '09:00:00',
  `business_hours_end` time DEFAULT '17:00:00',
  `financial_year_start` date DEFAULT NULL,
  `financial_year_end` date DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.company_settings: ~1 rows (approximately)
DELETE FROM `company_settings`;
INSERT INTO `company_settings` (`id`, `company_name`, `company_email`, `company_phone`, `company_logo`, `company_address`, `company_city`, `company_state`, `company_country`, `company_postal_code`, `registration_number`, `tax_id`, `website`, `business_hours_start`, `business_hours_end`, `financial_year_start`, `financial_year_end`, `created_at`, `updated_at`) VALUES
	(1, 'RMS', 'rms@gmail.com', '+1-234-567-8900', 'company_logo_1762911364.png', '345, Dickwela Road,', 'Siyambalape', 'Outside US or Canada', 'Sri Lanka', '11607', '1111-222-33-4', '1111-2222', 'https://www.rms.com', '09:00:00', '17:00:00', '2025-04-01', '2026-03-31', '2025-11-09 07:01:40', '2025-11-12 02:36:04');

-- Dumping structure for table cmsadver_rmsdb.crm_activities
DROP TABLE IF EXISTS `crm_activities`;
CREATE TABLE IF NOT EXISTS `crm_activities` (
  `activity_id` int(11) NOT NULL AUTO_INCREMENT,
  `crm_candidate_id` int(11) NOT NULL,
  `activity_type` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `priority` varchar(50) DEFAULT 'Medium',
  `status` varchar(50) DEFAULT 'Pending',
  `assigned_to` varchar(100) DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`activity_id`),
  KEY `idx_candidate` (`crm_candidate_id`),
  KEY `idx_status` (`status`),
  KEY `idx_assigned` (`assigned_to`),
  CONSTRAINT `crm_activities_ibfk_1` FOREIGN KEY (`crm_candidate_id`) REFERENCES `crm_candidates` (`crm_candidate_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.crm_activities: ~0 rows (approximately)
DELETE FROM `crm_activities`;

-- Dumping structure for table cmsadver_rmsdb.crm_candidates
DROP TABLE IF EXISTS `crm_candidates`;
CREATE TABLE IF NOT EXISTS `crm_candidates` (
  `crm_candidate_id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_id` int(11) DEFAULT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `current_stage` varchar(100) DEFAULT 'New Lead',
  `pipeline_status` varchar(50) DEFAULT 'Active',
  `relationship_score` int(11) DEFAULT 0,
  `engagement_level` varchar(50) DEFAULT 'Cold',
  `last_contact_date` datetime DEFAULT NULL,
  `next_follow_up` datetime DEFAULT NULL,
  `source` varchar(100) DEFAULT NULL,
  `assigned_to` varchar(100) DEFAULT NULL,
  `priority` varchar(50) DEFAULT 'Medium',
  `tags` text DEFAULT NULL,
  `custom_fields` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`crm_candidate_id`),
  KEY `idx_email` (`email`),
  KEY `idx_stage` (`current_stage`),
  KEY `idx_assigned` (`assigned_to`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.crm_candidates: ~0 rows (approximately)
DELETE FROM `crm_candidates`;

-- Dumping structure for table cmsadver_rmsdb.crm_candidate_tags
DROP TABLE IF EXISTS `crm_candidate_tags`;
CREATE TABLE IF NOT EXISTS `crm_candidate_tags` (
  `candidate_tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `crm_candidate_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `added_by` varchar(100) DEFAULT NULL,
  `added_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`candidate_tag_id`),
  KEY `idx_candidate` (`crm_candidate_id`),
  KEY `idx_tag` (`tag_id`),
  CONSTRAINT `crm_candidate_tags_ibfk_1` FOREIGN KEY (`crm_candidate_id`) REFERENCES `crm_candidates` (`crm_candidate_id`) ON DELETE CASCADE,
  CONSTRAINT `crm_candidate_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `crm_tags` (`tag_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.crm_candidate_tags: ~0 rows (approximately)
DELETE FROM `crm_candidate_tags`;

-- Dumping structure for table cmsadver_rmsdb.crm_interactions
DROP TABLE IF EXISTS `crm_interactions`;
CREATE TABLE IF NOT EXISTS `crm_interactions` (
  `interaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `crm_candidate_id` int(11) NOT NULL,
  `interaction_type` varchar(50) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `interaction_date` datetime NOT NULL,
  `duration_minutes` int(11) DEFAULT NULL,
  `outcome` varchar(100) DEFAULT NULL,
  `sentiment` varchar(50) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`interaction_id`),
  KEY `idx_candidate` (`crm_candidate_id`),
  KEY `idx_type` (`interaction_type`),
  KEY `idx_date` (`interaction_date`),
  CONSTRAINT `crm_interactions_ibfk_1` FOREIGN KEY (`crm_candidate_id`) REFERENCES `crm_candidates` (`crm_candidate_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.crm_interactions: ~0 rows (approximately)
DELETE FROM `crm_interactions`;

-- Dumping structure for table cmsadver_rmsdb.crm_notes
DROP TABLE IF EXISTS `crm_notes`;
CREATE TABLE IF NOT EXISTS `crm_notes` (
  `note_id` int(11) NOT NULL AUTO_INCREMENT,
  `crm_candidate_id` int(11) NOT NULL,
  `note_text` text NOT NULL,
  `note_type` varchar(50) DEFAULT 'General',
  `is_pinned` tinyint(1) DEFAULT 0,
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`note_id`),
  KEY `idx_candidate` (`crm_candidate_id`),
  CONSTRAINT `crm_notes_ibfk_1` FOREIGN KEY (`crm_candidate_id`) REFERENCES `crm_candidates` (`crm_candidate_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.crm_notes: ~0 rows (approximately)
DELETE FROM `crm_notes`;

-- Dumping structure for table cmsadver_rmsdb.crm_pipeline_stages
DROP TABLE IF EXISTS `crm_pipeline_stages`;
CREATE TABLE IF NOT EXISTS `crm_pipeline_stages` (
  `stage_id` int(11) NOT NULL AUTO_INCREMENT,
  `stage_name` varchar(100) NOT NULL,
  `stage_order` int(11) NOT NULL,
  `stage_color` varchar(20) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `automation_rules` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`stage_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.crm_pipeline_stages: ~9 rows (approximately)
DELETE FROM `crm_pipeline_stages`;
INSERT INTO `crm_pipeline_stages` (`stage_id`, `stage_name`, `stage_order`, `stage_color`, `is_active`, `automation_rules`, `created_at`) VALUES
	(1, 'New Lead', 1, '#3498db', 1, NULL, '2025-11-14 19:33:39'),
	(2, 'Contacted', 2, '#9b59b6', 1, NULL, '2025-11-14 19:33:39'),
	(3, 'Qualified', 3, '#f39c12', 1, NULL, '2025-11-14 19:33:39'),
	(4, 'Interview Scheduled', 4, '#e67e22', 1, NULL, '2025-11-14 19:33:39'),
	(5, 'Interview Completed', 5, '#1abc9c', 1, NULL, '2025-11-14 19:33:39'),
	(6, 'Offer Extended', 6, '#27ae60', 1, NULL, '2025-11-14 19:33:39'),
	(7, 'Hired', 7, '#2ecc71', 1, NULL, '2025-11-14 19:33:40'),
	(8, 'Rejected', 8, '#e74c3c', 1, NULL, '2025-11-14 19:33:40'),
	(9, 'Withdrawn', 9, '#95a5a6', 1, NULL, '2025-11-14 19:33:40');

-- Dumping structure for table cmsadver_rmsdb.crm_relationships
DROP TABLE IF EXISTS `crm_relationships`;
CREATE TABLE IF NOT EXISTS `crm_relationships` (
  `relationship_id` int(11) NOT NULL AUTO_INCREMENT,
  `crm_candidate_id` int(11) NOT NULL,
  `engagement_score` int(11) DEFAULT 0,
  `response_rate` decimal(5,2) DEFAULT 0.00,
  `interaction_count` int(11) DEFAULT 0,
  `last_interaction_date` datetime DEFAULT NULL,
  `quality_score` int(11) DEFAULT 0,
  `calculated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`relationship_id`),
  KEY `idx_candidate` (`crm_candidate_id`),
  CONSTRAINT `crm_relationships_ibfk_1` FOREIGN KEY (`crm_candidate_id`) REFERENCES `crm_candidates` (`crm_candidate_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.crm_relationships: ~0 rows (approximately)
DELETE FROM `crm_relationships`;

-- Dumping structure for table cmsadver_rmsdb.crm_tags
DROP TABLE IF EXISTS `crm_tags`;
CREATE TABLE IF NOT EXISTS `crm_tags` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(100) NOT NULL,
  `tag_color` varchar(20) DEFAULT NULL,
  `tag_category` varchar(50) DEFAULT NULL,
  `usage_count` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`tag_id`),
  UNIQUE KEY `tag_name` (`tag_name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.crm_tags: ~8 rows (approximately)
DELETE FROM `crm_tags`;
INSERT INTO `crm_tags` (`tag_id`, `tag_name`, `tag_color`, `tag_category`, `usage_count`, `created_at`) VALUES
	(1, 'Hot Lead', '#e74c3c', 'Priority', 0, '2025-11-14 19:33:40'),
	(2, 'Passive Candidate', '#3498db', 'Status', 0, '2025-11-14 19:33:40'),
	(3, 'Senior Level', '#9b59b6', 'Experience', 0, '2025-11-14 19:33:40'),
	(4, 'Tech Stack Match', '#27ae60', 'Skills', 0, '2025-11-14 19:33:40'),
	(5, 'Culture Fit', '#1abc9c', 'Assessment', 0, '2025-11-14 19:33:40'),
	(6, 'Referral', '#f39c12', 'Source', 0, '2025-11-14 19:33:40'),
	(7, 'LinkedIn', '#0077b5', 'Source', 0, '2025-11-14 19:33:40'),
	(8, 'High Potential', '#e67e22', 'Priority', 0, '2025-11-14 19:33:40');

-- Dumping structure for table cmsadver_rmsdb.custom_modules
DROP TABLE IF EXISTS `custom_modules`;
CREATE TABLE IF NOT EXISTS `custom_modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `section` varchar(50) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `url` varchar(255) NOT NULL,
  `order_num` int(11) DEFAULT 10,
  `is_active` tinyint(1) DEFAULT 1,
  `show_badge` tinyint(1) DEFAULT 0,
  `badge_text` varchar(20) DEFAULT 'NEW',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.custom_modules: ~2 rows (approximately)
DELETE FROM `custom_modules`;
INSERT INTO `custom_modules` (`id`, `name`, `section`, `icon`, `url`, `order_num`, `is_active`, `show_badge`, `badge_text`, `created_at`, `updated_at`) VALUES
	(1, 'Training', 'CUSTOM', 'fas fa-graduation-cap', 'A_dashboard/training_view', 5, 1, 1, 'NEW', '2025-11-12 03:44:30', '2025-11-12 03:44:30'),
	(2, 'Test', 'CUSTOM', 'fas fa-file-alt', 'A_dashboard/documents_view', 6, 1, 0, 'NEW', '2025-11-12 03:44:30', '2025-11-12 04:12:54');

-- Dumping structure for table cmsadver_rmsdb.cv_processing_history
DROP TABLE IF EXISTS `cv_processing_history`;
CREATE TABLE IF NOT EXISTS `cv_processing_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_id` int(11) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_type` varchar(20) DEFAULT NULL,
  `processing_status` enum('pending','processing','completed','failed') DEFAULT 'pending',
  `extracted_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`extracted_data`)),
  `confidence_scores` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`confidence_scores`)),
  `processing_time_ms` int(11) DEFAULT NULL,
  `error_message` text DEFAULT NULL,
  `processed_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_candidate` (`candidate_id`),
  KEY `idx_status` (`processing_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.cv_processing_history: ~0 rows (approximately)
DELETE FROM `cv_processing_history`;

-- Dumping structure for table cmsadver_rmsdb.dashboard_metrics
DROP TABLE IF EXISTS `dashboard_metrics`;
CREATE TABLE IF NOT EXISTS `dashboard_metrics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `metric_name` varchar(100) NOT NULL,
  `metric_value` decimal(10,2) NOT NULL,
  `metric_data` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `metric_name` (`metric_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.dashboard_metrics: ~4 rows (approximately)
DELETE FROM `dashboard_metrics`;
INSERT INTO `dashboard_metrics` (`id`, `metric_name`, `metric_value`, `metric_data`, `updated_at`) VALUES
	(1, 'total_candidates', 15.00, NULL, '2025-11-08 22:30:42'),
	(2, 'avg_days_in_pipeline', 7.50, NULL, '2025-11-08 22:30:42'),
	(3, 'urgent_count', 5.00, NULL, '2025-11-08 22:30:42'),
	(4, 'today_interviews', 3.00, NULL, '2025-11-08 22:30:42');

-- Dumping structure for table cmsadver_rmsdb.decision_votes
DROP TABLE IF EXISTS `decision_votes`;
CREATE TABLE IF NOT EXISTS `decision_votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `decision_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `vote` enum('yes','no','abstain') NOT NULL,
  `comment` text DEFAULT NULL,
  `is_anonymous` tinyint(1) DEFAULT 0,
  `voted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `decision_id` (`decision_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.decision_votes: ~15 rows (approximately)
DELETE FROM `decision_votes`;
INSERT INTO `decision_votes` (`id`, `decision_id`, `user_id`, `vote`, `comment`, `is_anonymous`, `voted_at`) VALUES
	(1, 1, 1, 'yes', 'Strong technical skills', 0, '2025-11-08 22:30:41'),
	(2, 1, 2, 'yes', 'Great culture fit', 0, '2025-11-08 22:30:41'),
	(3, 1, 3, 'abstain', 'Need more information', 0, '2025-11-08 22:30:41'),
	(4, 2, 1, 'yes', 'Strong technical skills', 0, '2025-11-08 22:30:41'),
	(5, 2, 2, 'yes', 'Great culture fit', 0, '2025-11-08 22:30:41'),
	(6, 2, 3, 'abstain', 'Need more information', 0, '2025-11-08 22:30:41'),
	(7, 3, 1, 'yes', 'Strong technical skills', 0, '2025-11-08 22:30:41'),
	(8, 3, 2, 'yes', 'Great culture fit', 0, '2025-11-08 22:30:41'),
	(9, 3, 3, 'abstain', 'Need more information', 0, '2025-11-08 22:30:41'),
	(10, 4, 1, 'yes', 'Strong technical skills', 0, '2025-11-08 22:30:41'),
	(11, 4, 2, 'yes', 'Great culture fit', 0, '2025-11-08 22:30:41'),
	(12, 4, 3, 'abstain', 'Need more information', 0, '2025-11-08 22:30:41'),
	(13, 5, 1, 'yes', 'Strong technical skills', 0, '2025-11-08 22:30:41'),
	(14, 5, 2, 'yes', 'Great culture fit', 0, '2025-11-08 22:30:41'),
	(15, 5, 3, 'abstain', 'Need more information', 0, '2025-11-08 22:30:41');

-- Dumping structure for table cmsadver_rmsdb.departments
DROP TABLE IF EXISTS `departments`;
CREATE TABLE IF NOT EXISTS `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_name` varchar(255) NOT NULL,
  `department_head` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.departments: ~5 rows (approximately)
DELETE FROM `departments`;
INSERT INTO `departments` (`id`, `department_name`, `department_head`, `description`, `created_at`, `updated_at`) VALUES
	(1, 'Human Resources', 'HR Manager', 'Manages recruitment, employee relations, and HR policies', '2025-11-09 07:01:40', '2025-11-09 07:01:40'),
	(2, 'Information Technology', 'IT Manager', 'Manages technology infrastructure and software development', '2025-11-09 07:01:40', '2025-11-09 07:01:40'),
	(3, 'Finance', 'Finance Manager', 'Handles financial planning, accounting, and budgeting', '2025-11-09 07:01:40', '2025-11-09 07:01:40'),
	(4, 'Marketing', 'Marketing Manager', 'Manages marketing campaigns and brand strategy', '2025-11-09 07:01:40', '2025-11-09 07:01:40'),
	(5, 'QA', 'Charaka', 'Test', '2025-11-09 02:41:36', '2025-11-09 07:11:36');

-- Dumping structure for table cmsadver_rmsdb.email_campaigns
DROP TABLE IF EXISTS `email_campaigns`;
CREATE TABLE IF NOT EXISTS `email_campaigns` (
  `email_campaign_id` int(11) NOT NULL AUTO_INCREMENT,
  `campaign_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `from_name` varchar(100) DEFAULT NULL,
  `from_email` varchar(255) DEFAULT NULL,
  `email_content` text NOT NULL,
  `template_id` int(11) DEFAULT NULL,
  `send_date` datetime DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Draft',
  `total_sent` int(11) DEFAULT 0,
  `total_opened` int(11) DEFAULT 0,
  `total_clicked` int(11) DEFAULT 0,
  `total_bounced` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`email_campaign_id`),
  KEY `campaign_id` (`campaign_id`),
  CONSTRAINT `email_campaigns_ibfk_1` FOREIGN KEY (`campaign_id`) REFERENCES `marketing_campaigns` (`campaign_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.email_campaigns: ~0 rows (approximately)
DELETE FROM `email_campaigns`;

-- Dumping structure for table cmsadver_rmsdb.email_config
DROP TABLE IF EXISTS `email_config`;
CREATE TABLE IF NOT EXISTS `email_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `smtp_host` varchar(255) NOT NULL,
  `smtp_port` int(11) NOT NULL DEFAULT 587,
  `smtp_username` varchar(255) NOT NULL,
  `smtp_password` varchar(255) NOT NULL,
  `smtp_encryption` varchar(10) DEFAULT 'tls',
  `from_email` varchar(255) NOT NULL,
  `from_name` varchar(255) NOT NULL,
  `reply_to_email` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.email_config: ~0 rows (approximately)
DELETE FROM `email_config`;

-- Dumping structure for table cmsadver_rmsdb.email_logs
DROP TABLE IF EXISTS `email_logs`;
CREATE TABLE IF NOT EXISTS `email_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recipient_email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text DEFAULT NULL,
  `status` enum('sent','failed') DEFAULT 'sent',
  `error_message` text DEFAULT NULL,
  `sent_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `recipient_email` (`recipient_email`),
  KEY `sent_at` (`sent_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.email_logs: ~0 rows (approximately)
DELETE FROM `email_logs`;

-- Dumping structure for table cmsadver_rmsdb.email_templates
DROP TABLE IF EXISTS `email_templates`;
CREATE TABLE IF NOT EXISTS `email_templates` (
  `template_id` int(11) NOT NULL AUTO_INCREMENT,
  `template_name` varchar(255) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `body_html` text NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`template_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.email_templates: ~6 rows (approximately)
DELETE FROM `email_templates`;
INSERT INTO `email_templates` (`template_id`, `template_name`, `subject`, `body_html`, `category`, `is_active`, `created_by`, `created_at`) VALUES
	(1, 'Job Alert - Tech Positions', 'Exciting Tech Opportunities at {{company_name}}', '<h2>New Opportunities Available</h2><p>Dear {{candidate_name}},</p><p>We have exciting new positions that match your profile:</p><ul><li>{{job_title}}</li></ul><p>Apply now!</p>', 'Job Alert', 1, 'admin', '2025-11-14 18:56:14'),
	(2, 'Welcome to Talent Network', 'Welcome to Our Talent Network!', '<h2>Welcome!</h2><p>Thank you for joining our talent network. We will keep you updated on opportunities that match your skills.</p>', 'Welcome', 1, 'admin', '2025-11-14 18:56:15'),
	(3, 'Interview Invitation', 'Interview Invitation for {{job_title}}', '<h2>Interview Invitation</h2><p>Dear {{candidate_name}},</p><p>We would like to invite you for an interview for the position of {{job_title}}.</p><p>Please confirm your availability.</p>', 'Interview', 1, 'admin', '2025-11-14 18:56:15'),
	(4, 'Application Received', 'Application Received - {{job_title}}', '<h2>Application Received</h2><p>Thank you for your application! We will review it and get back to you soon.</p>', 'Confirmation', 1, 'admin', '2025-11-14 18:56:15'),
	(5, 'Job Offer', 'Job Offer - {{job_title}} at {{company_name}}', '<h2>Congratulations!</h2><p>Dear {{candidate_name}},</p><p>We are pleased to offer you the position of {{job_title}}.</p><p>Please review the attached offer letter.</p>', 'Offer', 1, 'admin', '2025-11-14 18:56:15'),
	(6, 'Rejection - Polite', 'Update on Your Application', '<h2>Thank You for Your Interest</h2><p>Dear {{candidate_name}},</p><p>Thank you for your interest in {{company_name}}. After careful consideration, we have decided to move forward with other candidates.</p><p>We wish you the best in your job search.</p>', 'Rejection', 1, 'admin', '2025-11-14 18:56:15');

-- Dumping structure for table cmsadver_rmsdb.employee_advocates
DROP TABLE IF EXISTS `employee_advocates`;
CREATE TABLE IF NOT EXISTS `employee_advocates` (
  `advocate_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_name` varchar(255) NOT NULL,
  `employee_email` varchar(255) NOT NULL,
  `department` varchar(100) DEFAULT NULL,
  `job_title` varchar(255) DEFAULT NULL,
  `linkedin_url` varchar(500) DEFAULT NULL,
  `twitter_handle` varchar(100) DEFAULT NULL,
  `facebook_url` varchar(500) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Active',
  `total_shares` int(11) DEFAULT 0,
  `total_reach` int(11) DEFAULT 0,
  `total_engagements` int(11) DEFAULT 0,
  `joined_date` date DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`advocate_id`),
  KEY `idx_email` (`employee_email`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.employee_advocates: ~4 rows (approximately)
DELETE FROM `employee_advocates`;
INSERT INTO `employee_advocates` (`advocate_id`, `employee_name`, `employee_email`, `department`, `job_title`, `linkedin_url`, `twitter_handle`, `facebook_url`, `status`, `total_shares`, `total_reach`, `total_engagements`, `joined_date`, `created_by`, `created_at`) VALUES
	(1, 'Sarah Johnson', 'sarah.j@company.com', 'Engineering', 'Senior Software Engineer', 'https://linkedin.com/in/sarahjohnson', '@sarahj_tech', NULL, 'Active', 45, 12500, 890, '2024-01-15', 'admin', '2025-11-14 19:23:46'),
	(2, 'Michael Chen', 'michael.c@company.com', 'Product', 'Product Manager', 'https://linkedin.com/in/michaelchen', NULL, NULL, 'Active', 38, 9800, 654, '2024-02-01', 'admin', '2025-11-14 19:23:46'),
	(3, 'Emily Rodriguez', 'emily.r@company.com', 'Marketing', 'Marketing Manager', 'https://linkedin.com/in/emilyrodriguez', '@emily_marketing', 'https://facebook.com/emilyrodriguez', 'Active', 52, 15200, 1120, '2024-01-20', 'admin', '2025-11-14 19:23:46'),
	(4, 'David Kim', 'david.k@company.com', 'Design', 'UX Designer', 'https://linkedin.com/in/davidkim', NULL, NULL, 'Active', 29, 7600, 445, '2024-03-10', 'admin', '2025-11-14 19:23:46');

-- Dumping structure for table cmsadver_rmsdb.event_jobs
DROP TABLE IF EXISTS `event_jobs`;
CREATE TABLE IF NOT EXISTS `event_jobs` (
  `event_job_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `job_description` text DEFAULT NULL,
  `positions_available` int(11) DEFAULT 1,
  `applications_received` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`event_job_id`),
  KEY `idx_event` (`event_id`),
  CONSTRAINT `event_jobs_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `recruitment_events` (`event_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.event_jobs: ~0 rows (approximately)
DELETE FROM `event_jobs`;

-- Dumping structure for table cmsadver_rmsdb.event_registrations
DROP TABLE IF EXISTS `event_registrations`;
CREATE TABLE IF NOT EXISTS `event_registrations` (
  `registration_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `candidate_name` varchar(255) NOT NULL,
  `candidate_email` varchar(255) NOT NULL,
  `candidate_phone` varchar(50) DEFAULT NULL,
  `registration_date` timestamp NULL DEFAULT current_timestamp(),
  `attendance_status` varchar(50) DEFAULT 'Registered',
  `checked_in_at` datetime DEFAULT NULL,
  `feedback_rating` int(11) DEFAULT NULL,
  `feedback_comments` text DEFAULT NULL,
  `source` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`registration_id`),
  KEY `idx_event` (`event_id`),
  KEY `idx_email` (`candidate_email`),
  CONSTRAINT `event_registrations_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `recruitment_events` (`event_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.event_registrations: ~0 rows (approximately)
DELETE FROM `event_registrations`;

-- Dumping structure for table cmsadver_rmsdb.event_types
DROP TABLE IF EXISTS `event_types`;
CREATE TABLE IF NOT EXISTS `event_types` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`type_id`),
  UNIQUE KEY `type_name` (`type_name`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.event_types: ~10 rows (approximately)
DELETE FROM `event_types`;
INSERT INTO `event_types` (`type_id`, `type_name`, `description`, `icon`, `is_active`) VALUES
	(1, 'Job Fair', 'Traditional job fair with multiple employers', 'fa-briefcase', 1),
	(2, 'Career Day', 'Career exploration and networking event', 'fa-graduation-cap', 1),
	(3, 'Virtual Job Fair', 'Online recruitment event', 'fa-video', 1),
	(4, 'Campus Recruitment', 'University campus hiring event', 'fa-university', 1),
	(5, 'Open House', 'Company open house for potential candidates', 'fa-door-open', 1),
	(6, 'Networking Event', 'Professional networking mixer', 'fa-users', 1),
	(7, 'Workshop', 'Skills workshop and recruitment', 'fa-chalkboard-teacher', 1),
	(8, 'Webinar', 'Online information session', 'fa-desktop', 1),
	(9, 'Assessment Center', 'Candidate assessment event', 'fa-clipboard-check', 1),
	(10, 'Meet & Greet', 'Informal meeting with hiring team', 'fa-handshake', 1);

-- Dumping structure for table cmsadver_rmsdb.hiring_decisions
DROP TABLE IF EXISTS `hiring_decisions`;
CREATE TABLE IF NOT EXISTS `hiring_decisions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_id` int(11) NOT NULL,
  `decision_type` enum('move_forward','reject','hold','offer') NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deadline` datetime DEFAULT NULL,
  `status` enum('open','closed') DEFAULT 'open',
  `final_decision` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `candidate_id` (`candidate_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.hiring_decisions: ~5 rows (approximately)
DELETE FROM `hiring_decisions`;
INSERT INTO `hiring_decisions` (`id`, `candidate_id`, `decision_type`, `created_by`, `created_at`, `deadline`, `status`, `final_decision`) VALUES
	(1, 14, 'move_forward', 1, '2025-11-08 22:30:41', NULL, 'open', NULL),
	(2, 13, 'move_forward', 1, '2025-11-08 22:30:41', NULL, 'open', NULL),
	(3, 15, 'move_forward', 1, '2025-11-08 22:30:41', NULL, 'open', NULL),
	(4, 5, 'move_forward', 1, '2025-11-08 22:30:41', NULL, 'open', NULL),
	(5, 4, 'move_forward', 1, '2025-11-08 22:30:41', NULL, 'open', NULL);

-- Dumping structure for table cmsadver_rmsdb.interviewer_availability
DROP TABLE IF EXISTS `interviewer_availability`;
CREATE TABLE IF NOT EXISTS `interviewer_availability` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `interviewer_username` varchar(100) NOT NULL,
  `day_of_week` tinyint(1) NOT NULL COMMENT '0=Sunday, 6=Saturday',
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `is_available` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `interviewer_username` (`interviewer_username`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.interviewer_availability: ~3 rows (approximately)
DELETE FROM `interviewer_availability`;
INSERT INTO `interviewer_availability` (`id`, `interviewer_username`, `day_of_week`, `start_time`, `end_time`, `is_available`) VALUES
	(4, 'sarahlee', 0, '09:00:00', '17:00:00', 1),
	(5, 'sarahlee', 1, '09:00:00', '17:00:00', 1),
	(6, 'sarahlee', 2, '09:00:00', '17:00:00', 1);

-- Dumping structure for table cmsadver_rmsdb.interviewer_feedback
DROP TABLE IF EXISTS `interviewer_feedback`;
CREATE TABLE IF NOT EXISTS `interviewer_feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `interview_id` int(11) NOT NULL,
  `interviewer_username` varchar(100) NOT NULL,
  `candidate_id` int(11) NOT NULL,
  `technical_skills` int(1) DEFAULT NULL COMMENT '1-5 rating',
  `communication` int(1) DEFAULT NULL COMMENT '1-5 rating',
  `problem_solving` int(1) DEFAULT NULL COMMENT '1-5 rating',
  `cultural_fit` int(1) DEFAULT NULL COMMENT '1-5 rating',
  `overall_rating` int(1) DEFAULT NULL COMMENT '1-5 rating',
  `strengths` text DEFAULT NULL,
  `weaknesses` text DEFAULT NULL,
  `detailed_feedback` text DEFAULT NULL,
  `recommendation` enum('strong_hire','hire','maybe','no_hire','strong_no_hire') DEFAULT NULL,
  `submitted_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `interview_id` (`interview_id`),
  KEY `interviewer_username` (`interviewer_username`),
  KEY `candidate_id` (`candidate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.interviewer_feedback: ~0 rows (approximately)
DELETE FROM `interviewer_feedback`;

-- Dumping structure for table cmsadver_rmsdb.interviews
DROP TABLE IF EXISTS `interviews`;
CREATE TABLE IF NOT EXISTS `interviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `flow_id` int(11) NOT NULL,
  `candidate_name` varchar(255) DEFAULT NULL,
  `candidate_email` varchar(255) NOT NULL,
  `candidate_phone` varchar(50) DEFAULT NULL,
  `token` varchar(255) NOT NULL,
  `status` enum('pending','in_progress','completed','cancelled','expired') DEFAULT 'pending',
  `score` int(11) DEFAULT NULL,
  `started_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`),
  KEY `idx_token` (`token`),
  KEY `idx_flow_id` (`flow_id`),
  KEY `idx_status` (`status`),
  KEY `idx_candidate_email` (`candidate_email`),
  CONSTRAINT `interviews_ibfk_1` FOREIGN KEY (`flow_id`) REFERENCES `interview_flows` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.interviews: ~1 rows (approximately)
DELETE FROM `interviews`;
INSERT INTO `interviews` (`id`, `flow_id`, `candidate_name`, `candidate_email`, `candidate_phone`, `token`, `status`, `score`, `started_at`, `completed_at`, `expires_at`, `created_at`, `updated_at`) VALUES
	(1, 1, 'John Doe', 'john@example.com', '', '1a47692b7e4e387eee6e3b049e65a7c93984251d3e1b38672acc2d804d13d7a6', 'completed', 75, '2025-11-16 08:14:19', '2025-11-16 08:18:38', '2025-11-23 05:42:53', '2025-11-16 05:42:53', '2025-11-16 12:48:38');

-- Dumping structure for table cmsadver_rmsdb.interview_analytics
DROP TABLE IF EXISTS `interview_analytics`;
CREATE TABLE IF NOT EXISTS `interview_analytics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `interview_id` int(11) NOT NULL,
  `event_type` varchar(50) NOT NULL,
  `event_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`event_data`)),
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_interview_id` (`interview_id`),
  KEY `idx_event_type` (`event_type`),
  CONSTRAINT `interview_analytics_ibfk_1` FOREIGN KEY (`interview_id`) REFERENCES `interviews` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.interview_analytics: ~0 rows (approximately)
DELETE FROM `interview_analytics`;

-- Dumping structure for table cmsadver_rmsdb.interview_assignments
DROP TABLE IF EXISTS `interview_assignments`;
CREATE TABLE IF NOT EXISTS `interview_assignments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `interview_id` int(11) NOT NULL,
  `interviewer_username` varchar(100) NOT NULL,
  `candidate_id` int(11) NOT NULL,
  `status` enum('pending','accepted','declined','completed') DEFAULT 'pending',
  `assigned_at` datetime DEFAULT current_timestamp(),
  `responded_at` datetime DEFAULT NULL,
  `notes` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `interviewer_username` (`interviewer_username`),
  KEY `interview_id` (`interview_id`),
  KEY `candidate_id` (`candidate_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.interview_assignments: ~6 rows (approximately)
DELETE FROM `interview_assignments`;
INSERT INTO `interview_assignments` (`id`, `interview_id`, `interviewer_username`, `candidate_id`, `status`, `assigned_at`, `responded_at`, `notes`) VALUES
	(1, 1, 'interviewer1', 1, 'pending', '2025-11-11 04:32:30', NULL, NULL),
	(2, 1, 'interviewer1', 1, 'pending', '2025-11-11 04:36:09', NULL, NULL),
	(3, 1, 'interviewer1', 1, 'pending', '2025-11-11 04:37:48', NULL, NULL),
	(4, 1, 'interviewer1', 1, 'pending', '2025-11-11 04:48:23', NULL, NULL),
	(5, 1, 'interviewer1', 1, 'pending', '2025-11-11 04:48:27', NULL, NULL),
	(6, 1, 'interviewer1', 1, 'pending', '2025-11-11 04:51:45', NULL, NULL);

-- Dumping structure for table cmsadver_rmsdb.interview_confirmations
DROP TABLE IF EXISTS `interview_confirmations`;
CREATE TABLE IF NOT EXISTS `interview_confirmations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `interview_id` int(11) NOT NULL,
  `candidate_username` varchar(100) NOT NULL,
  `status` enum('pending','confirmed','declined','reschedule_requested') DEFAULT 'pending',
  `confirmed_at` datetime DEFAULT NULL,
  `reschedule_reason` text DEFAULT NULL,
  `preferred_dates` text DEFAULT NULL COMMENT 'JSON array of preferred dates',
  PRIMARY KEY (`id`),
  KEY `interview_id` (`interview_id`),
  KEY `candidate_username` (`candidate_username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.interview_confirmations: ~0 rows (approximately)
DELETE FROM `interview_confirmations`;

-- Dumping structure for table cmsadver_rmsdb.interview_flows
DROP TABLE IF EXISTS `interview_flows`;
CREATE TABLE IF NOT EXISTS `interview_flows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_title` varchar(255) NOT NULL,
  `job_description` text DEFAULT NULL,
  `questions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`questions`)),
  `interview_type` enum('video','audio','text') DEFAULT 'video',
  `enable_video_capture` tinyint(1) DEFAULT 0,
  `duration_minutes` int(11) DEFAULT 30,
  `passing_score` int(11) DEFAULT 70,
  `status` enum('active','inactive','archived') DEFAULT 'active',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.interview_flows: ~7 rows (approximately)
DELETE FROM `interview_flows`;
INSERT INTO `interview_flows` (`id`, `job_title`, `job_description`, `questions`, `interview_type`, `enable_video_capture`, `duration_minutes`, `passing_score`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, 'Software Engineer', 'We are looking for a talented Software Engineer to join our team.', '[{"id":1,"question":"Tell us about yourself and your background.","type":"open","duration":120},{"id":2,"question":"Why are you interested in this position?","type":"open","duration":90},{"id":3,"question":"Describe a challenging project you worked on.","type":"open","duration":120},{"id":4,"question":"What are your salary expectations?","type":"open","duration":60}]', 'video', 1, 30, 70, 'active', NULL, '2025-11-16 09:07:03', '2025-11-16 09:07:03'),
	(2, 'Software Engineer', 'We are looking for a talented Software Engineer to join our team.', '[{"id":1,"question":"Tell us about yourself and your background.","type":"open","duration":120},{"id":2,"question":"Why are you interested in this position?","type":"open","duration":90},{"id":3,"question":"Describe a challenging project you worked on.","type":"open","duration":120},{"id":4,"question":"What are your salary expectations?","type":"open","duration":60}]', 'video', 1, 30, 70, 'active', NULL, '2025-11-16 09:55:23', '2025-11-16 09:55:23'),
	(3, 'Software Engineer', 'We are looking for a talented Software Engineer to join our team.', '[{"id":1,"question":"Tell us about yourself and your background.","type":"open","duration":120},{"id":2,"question":"Why are you interested in this position?","type":"open","duration":90},{"id":3,"question":"Describe a challenging project you worked on.","type":"open","duration":120},{"id":4,"question":"What are your salary expectations?","type":"open","duration":60}]', 'video', 1, 30, 70, 'active', NULL, '2025-11-16 10:12:18', '2025-11-16 10:12:18'),
	(4, 'Software Engineer', 'We are looking for a talented Software Engineer to join our team.', '[{"id":1,"question":"Tell us about yourself and your background.","type":"open","duration":120},{"id":2,"question":"Why are you interested in this position?","type":"open","duration":90},{"id":3,"question":"Describe a challenging project you worked on.","type":"open","duration":120},{"id":4,"question":"What are your salary expectations?","type":"open","duration":60}]', 'video', 1, 30, 70, 'active', NULL, '2025-11-16 10:12:29', '2025-11-16 10:12:29'),
	(5, 'Software Engineer', 'We are looking for a talented software engineer to join our team.', '[{"id":1,"question":"Tell us about yourself and your background.","type":"open","duration":120},{"id":2,"question":"Why are you interested in this position?","type":"open","duration":90},{"id":3,"question":"Describe a challenging project you worked on.","type":"open","duration":120}]', 'video', 1, 30, 70, 'active', 1, '2025-11-16 05:42:47', '2025-11-16 10:12:47'),
	(6, 'Software Engineer', 'We are looking for a talented Software Engineer to join our team.', '[{"id":1,"question":"Tell us about yourself and your background.","type":"open","duration":120},{"id":2,"question":"Why are you interested in this position?","type":"open","duration":90},{"id":3,"question":"Describe a challenging project you worked on.","type":"open","duration":120},{"id":4,"question":"What are your salary expectations?","type":"open","duration":60}]', 'video', 1, 30, 70, 'active', NULL, '2025-11-16 10:13:47', '2025-11-16 10:13:47'),
	(7, 'Software Engineer', 'We are looking for a talented software engineer to join our team.', '[{"id":1,"question":"Tell us about yourself and your background.","type":"open","duration":120},{"id":2,"question":"Why are you interested in this position?","type":"open","duration":90},{"id":3,"question":"Describe a challenging project you worked on.","type":"open","duration":120}]', 'video', 1, 30, 70, 'active', 1, '2025-11-16 05:45:50', '2025-11-16 10:15:50');

-- Dumping structure for table cmsadver_rmsdb.interview_panels
DROP TABLE IF EXISTS `interview_panels`;
CREATE TABLE IF NOT EXISTS `interview_panels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_id` int(11) NOT NULL,
  `interviewer_id` int(11) NOT NULL,
  `interview_date` datetime NOT NULL,
  `duration_minutes` int(11) DEFAULT 60,
  `interview_type` varchar(50) DEFAULT 'technical',
  `status` enum('scheduled','completed','cancelled','rescheduled') DEFAULT 'scheduled',
  `feedback_submitted` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `candidate_id` (`candidate_id`),
  KEY `interviewer_id` (`interviewer_id`),
  KEY `interview_date` (`interview_date`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.interview_panels: ~8 rows (approximately)
DELETE FROM `interview_panels`;
INSERT INTO `interview_panels` (`id`, `candidate_id`, `interviewer_id`, `interview_date`, `duration_minutes`, `interview_type`, `status`, `feedback_submitted`, `created_at`) VALUES
	(1, 14, 1, '2025-11-15 23:30:41', 60, 'technical', 'scheduled', 0, '2025-11-08 22:30:41'),
	(2, 13, 1, '2025-11-14 23:30:41', 60, 'phone_screen', 'completed', 0, '2025-11-08 22:30:41'),
	(3, 15, 1, '2025-11-12 23:30:41', 60, 'final', 'completed', 0, '2025-11-08 22:30:41'),
	(4, 5, 1, '2025-11-12 23:30:41', 60, 'phone_screen', 'scheduled', 0, '2025-11-08 22:30:41'),
	(5, 4, 1, '2025-11-09 23:30:42', 60, 'final', 'completed', 0, '2025-11-08 22:30:42'),
	(6, 7, 1, '2025-11-09 23:30:42', 60, 'behavioral', 'scheduled', 0, '2025-11-08 22:30:42'),
	(7, 1, 1, '2025-11-10 23:30:42', 60, 'phone_screen', 'scheduled', 0, '2025-11-08 22:30:42'),
	(8, 8, 1, '2025-11-14 23:30:42', 60, 'phone_screen', 'scheduled', 0, '2025-11-08 22:30:42');

-- Dumping structure for table cmsadver_rmsdb.interview_question_sets
DROP TABLE IF EXISTS `interview_question_sets`;
CREATE TABLE IF NOT EXISTS `interview_question_sets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `interview_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `question_order` int(11) DEFAULT 0,
  `candidate_answer` text DEFAULT NULL,
  `selected_options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Array of selected option IDs' CHECK (json_valid(`selected_options`)),
  `is_correct` tinyint(1) DEFAULT NULL,
  `points_earned` int(11) DEFAULT 0,
  `time_taken` int(11) DEFAULT 0 COMMENT 'Time in seconds',
  `answered_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_interview` (`interview_id`),
  KEY `idx_question` (`question_id`),
  CONSTRAINT `interview_question_sets_ibfk_1` FOREIGN KEY (`interview_id`) REFERENCES `interviews` (`id`) ON DELETE CASCADE,
  CONSTRAINT `interview_question_sets_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `questions_bank` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.interview_question_sets: ~0 rows (approximately)
DELETE FROM `interview_question_sets`;

-- Dumping structure for table cmsadver_rmsdb.interview_responses
DROP TABLE IF EXISTS `interview_responses`;
CREATE TABLE IF NOT EXISTS `interview_responses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `interview_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `response_text` text DEFAULT NULL,
  `response_audio` varchar(255) DEFAULT NULL,
  `response_video` varchar(255) DEFAULT NULL,
  `duration_seconds` int(11) DEFAULT 0,
  `score` int(11) DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_interview_id` (`interview_id`),
  KEY `idx_question_id` (`question_id`),
  CONSTRAINT `interview_responses_ibfk_1` FOREIGN KEY (`interview_id`) REFERENCES `interviews` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.interview_responses: ~4 rows (approximately)
DELETE FROM `interview_responses`;
INSERT INTO `interview_responses` (`id`, `interview_id`, `question_id`, `response_text`, `response_audio`, `response_video`, `duration_seconds`, `score`, `feedback`, `created_at`) VALUES
	(1, 1, 1, 'Test', '', '', 6, NULL, NULL, '2025-11-16 08:18:33'),
	(2, 1, 2, 'TEst', '', '', 1, NULL, NULL, '2025-11-16 08:18:34'),
	(3, 1, 3, 'TEst', '', '', 2, NULL, NULL, '2025-11-16 08:18:36'),
	(4, 1, 4, 'TEst', '', '', 1, NULL, NULL, '2025-11-16 08:18:38');

-- Dumping structure for table cmsadver_rmsdb.job_categories
DROP TABLE IF EXISTS `job_categories`;
CREATE TABLE IF NOT EXISTS `job_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.job_categories: ~6 rows (approximately)
DELETE FROM `job_categories`;
INSERT INTO `job_categories` (`id`, `category_name`, `description`, `created_at`, `updated_at`) VALUES
	(1, 'Information Technology', 'Software development, IT support, and technology roles', '2025-11-09 07:10:14', '2025-11-09 07:10:14'),
	(2, 'Engineering', 'Mechanical, electrical, civil, and other engineering positions', '2025-11-09 07:10:14', '2025-11-09 07:10:14'),
	(3, 'Sales & Marketing', 'Sales representatives, marketing specialists, and business development', '2025-11-09 07:10:14', '2025-11-09 07:10:14'),
	(4, 'Human Resources', 'HR managers, recruiters, and talent acquisition specialists', '2025-11-09 07:10:15', '2025-11-09 07:10:15'),
	(5, 'Finance & Accounting', 'Accountants, financial analysts, and finance managers', '2025-11-09 07:10:15', '2025-11-09 07:10:15'),
	(6, 'QAE', 'Software QA', '2025-11-09 02:40:41', '2025-11-09 07:10:41');

-- Dumping structure for table cmsadver_rmsdb.job_platforms
DROP TABLE IF EXISTS `job_platforms`;
CREATE TABLE IF NOT EXISTS `job_platforms` (
  `platform_id` int(11) NOT NULL AUTO_INCREMENT,
  `platform_name` varchar(100) NOT NULL,
  `platform_key` varchar(50) NOT NULL,
  `platform_logo` varchar(255) DEFAULT NULL,
  `api_endpoint` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `requires_api_key` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`platform_id`),
  UNIQUE KEY `platform_key` (`platform_key`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.job_platforms: ~6 rows (approximately)
DELETE FROM `job_platforms`;
INSERT INTO `job_platforms` (`platform_id`, `platform_name`, `platform_key`, `platform_logo`, `api_endpoint`, `is_active`, `requires_api_key`, `created_at`) VALUES
	(1, 'LinkedIn', 'linkedin', NULL, 'https://api.linkedin.com/v2/jobs', 1, 1, '2025-11-14 11:12:15'),
	(2, 'Indeed', 'indeed', NULL, 'https://api.indeed.com/ads', 1, 1, '2025-11-14 11:12:15'),
	(3, 'Glassdoor', 'glassdoor', NULL, 'https://api.glassdoor.com/api/employer', 1, 1, '2025-11-14 11:12:15'),
	(4, 'Monster', 'monster', NULL, 'https://api.monster.com/v1', 1, 1, '2025-11-14 11:12:15'),
	(5, 'ZipRecruiter', 'ziprecruiter', NULL, 'https://api.ziprecruiter.com/v1', 1, 1, '2025-11-14 11:12:15'),
	(6, 'CareerBuilder', 'careerbuilder', NULL, 'https://api.careerbuilder.com/v2', 1, 1, '2025-11-14 11:12:15');

-- Dumping structure for table cmsadver_rmsdb.job_platform_credentials
DROP TABLE IF EXISTS `job_platform_credentials`;
CREATE TABLE IF NOT EXISTS `job_platform_credentials` (
  `cred_id` int(11) NOT NULL AUTO_INCREMENT,
  `platform_id` int(11) NOT NULL,
  `api_key` varchar(255) DEFAULT NULL,
  `api_secret` varchar(255) DEFAULT NULL,
  `access_token` text DEFAULT NULL,
  `refresh_token` text DEFAULT NULL,
  `is_enabled` tinyint(1) DEFAULT 0,
  `last_sync` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`cred_id`),
  KEY `platform_id` (`platform_id`),
  CONSTRAINT `job_platform_credentials_ibfk_1` FOREIGN KEY (`platform_id`) REFERENCES `job_platforms` (`platform_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.job_platform_credentials: ~0 rows (approximately)
DELETE FROM `job_platform_credentials`;

-- Dumping structure for table cmsadver_rmsdb.job_positions
DROP TABLE IF EXISTS `job_positions`;
CREATE TABLE IF NOT EXISTS `job_positions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position_name` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.job_positions: ~6 rows (approximately)
DELETE FROM `job_positions`;
INSERT INTO `job_positions` (`id`, `position_name`, `category_id`, `description`, `created_at`, `updated_at`) VALUES
	(1, 'Software Engineer', 1, 'Develop and maintain software applications', '2025-11-09 07:10:15', '2025-11-09 07:10:15'),
	(2, 'Frontend Developer', 1, 'Build user interfaces and client-side applications', '2025-11-09 07:10:15', '2025-11-09 07:10:15'),
	(3, 'Backend Developer', 1, 'Develop server-side logic and databases', '2025-11-09 07:10:15', '2025-11-09 07:10:15'),
	(4, 'Sales Executive', 3, 'Drive sales and business development', '2025-11-09 07:10:15', '2025-11-09 07:10:15'),
	(5, 'HR Manager', 4, 'Manage human resources and recruitment', '2025-11-09 07:10:15', '2025-11-09 07:10:15'),
	(6, 'Trainee SQA', 6, 'Test  QAE', '2025-11-09 02:41:17', '2025-11-09 07:11:17');

-- Dumping structure for table cmsadver_rmsdb.job_postings
DROP TABLE IF EXISTS `job_postings`;
CREATE TABLE IF NOT EXISTS `job_postings` (
  `jp_id` int(11) NOT NULL AUTO_INCREMENT,
  `jp_title` varchar(255) NOT NULL,
  `jp_description` text NOT NULL,
  `jp_requirements` text DEFAULT NULL,
  `jp_responsibilities` text DEFAULT NULL,
  `jp_location` varchar(255) DEFAULT NULL,
  `jp_employment_type` varchar(50) DEFAULT 'Full-time',
  `jp_salary_min` decimal(10,2) DEFAULT NULL,
  `jp_salary_max` decimal(10,2) DEFAULT NULL,
  `jp_salary_currency` varchar(10) DEFAULT 'USD',
  `jp_category_id` int(11) DEFAULT NULL,
  `jp_position_id` int(11) DEFAULT NULL,
  `jp_department` varchar(100) DEFAULT NULL,
  `jp_experience_min` int(11) DEFAULT NULL,
  `jp_experience_max` int(11) DEFAULT NULL,
  `jp_status` varchar(50) DEFAULT 'Draft',
  `jp_posted_by` varchar(100) DEFAULT NULL,
  `jp_created_at` timestamp NULL DEFAULT current_timestamp(),
  `jp_updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `jp_expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`jp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.job_postings: ~5 rows (approximately)
DELETE FROM `job_postings`;
INSERT INTO `job_postings` (`jp_id`, `jp_title`, `jp_description`, `jp_requirements`, `jp_responsibilities`, `jp_location`, `jp_employment_type`, `jp_salary_min`, `jp_salary_max`, `jp_salary_currency`, `jp_category_id`, `jp_position_id`, `jp_department`, `jp_experience_min`, `jp_experience_max`, `jp_status`, `jp_posted_by`, `jp_created_at`, `jp_updated_at`, `jp_expires_at`) VALUES
	(1, 'Senior Software Engineer', 'We are looking for an experienced Senior Software Engineer to join our dynamic team. You will be responsible for designing, developing, and maintaining high-quality software solutions.', 'Bachelor\'s degree in Computer Science or related field, 5+ years of experience in software development, Strong knowledge of Java, Python, or C++, Experience with cloud platforms (AWS, Azure, or GCP)', 'Design and develop scalable software solutions, Lead technical discussions and code reviews, Mentor junior developers, Collaborate with cross-functional teams', 'San Francisco, CA', 'Full-time', 120000.00, 180000.00, 'USD', NULL, NULL, NULL, 5, 10, 'Active', '0', '2025-11-14 11:57:22', '2025-11-14 11:57:22', '2025-12-14 17:27:22'),
	(2, 'Marketing Manager', 'Join our marketing team as a Marketing Manager. You will develop and execute marketing strategies to drive brand awareness and customer engagement.', 'Bachelor\'s degree in Marketing or Business, 3+ years of marketing experience, Strong analytical and communication skills, Experience with digital marketing tools', 'Develop marketing strategies and campaigns, Manage social media presence, Analyze market trends, Coordinate with sales team', 'New York, NY', 'Full-time', 80000.00, 110000.00, 'USD', NULL, NULL, NULL, 3, 7, 'Active', '0', '2025-11-14 11:57:22', '2025-11-14 11:57:22', '2025-12-14 17:27:22'),
	(3, 'Data Analyst', 'We need a Data Analyst to help us make data-driven decisions. You will analyze complex datasets and provide actionable insights.', 'Bachelor\'s degree in Statistics, Mathematics, or related field, 2+ years of data analysis experience, Proficiency in SQL and Python, Experience with data visualization tools', 'Analyze large datasets, Create reports and dashboards, Identify trends and patterns, Present findings to stakeholders', 'Austin, TX', 'Full-time', 70000.00, 95000.00, 'USD', NULL, NULL, NULL, 2, 5, 'Active', '0', '2025-11-14 11:57:22', '2025-11-14 11:57:22', '2025-12-14 17:27:22'),
	(4, 'UX/UI Designer', 'Creative UX/UI Designer needed to design intuitive and engaging user interfaces for our web and mobile applications.', 'Bachelor\'s degree in Design or related field, 3+ years of UX/UI design experience, Proficiency in Figma, Sketch, or Adobe XD, Strong portfolio demonstrating design skills', 'Design user interfaces and experiences, Create wireframes and prototypes, Conduct user research, Collaborate with developers', 'Seattle, WA', 'Full-time', 85000.00, 115000.00, 'USD', NULL, NULL, NULL, 3, 6, 'Draft', '0', '2025-11-14 11:57:22', '2025-11-14 11:57:22', '2025-12-14 17:27:22'),
	(5, 'DevOps Engineer', 'Looking for a DevOps Engineer to manage our infrastructure and deployment pipelines. You will ensure smooth operations and continuous delivery.', 'Bachelor\'s degree in Computer Science, 4+ years of DevOps experience, Strong knowledge of Docker and Kubernetes, Experience with CI/CD tools', 'Manage cloud infrastructure, Implement CI/CD pipelines, Monitor system performance, Automate deployment processes', 'Boston, MA', 'Full-time', 110000.00, 150000.00, 'USD', NULL, NULL, NULL, 4, 8, 'Active', '0', '2025-11-14 11:57:22', '2025-11-14 11:57:22', '2025-12-14 17:27:22');

-- Dumping structure for table cmsadver_rmsdb.job_posting_history
DROP TABLE IF EXISTS `job_posting_history`;
CREATE TABLE IF NOT EXISTS `job_posting_history` (
  `history_id` int(11) NOT NULL AUTO_INCREMENT,
  `jp_id` int(11) NOT NULL,
  `platform_id` int(11) NOT NULL,
  `external_job_id` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `posted_at` datetime DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `views_count` int(11) DEFAULT 0,
  `clicks_count` int(11) DEFAULT 0,
  `applications_count` int(11) DEFAULT 0,
  `last_synced` datetime DEFAULT NULL,
  `error_message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`history_id`),
  KEY `jp_id` (`jp_id`),
  KEY `platform_id` (`platform_id`),
  CONSTRAINT `job_posting_history_ibfk_1` FOREIGN KEY (`jp_id`) REFERENCES `job_postings` (`jp_id`) ON DELETE CASCADE,
  CONSTRAINT `job_posting_history_ibfk_2` FOREIGN KEY (`platform_id`) REFERENCES `job_platforms` (`platform_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.job_posting_history: ~8 rows (approximately)
DELETE FROM `job_posting_history`;
INSERT INTO `job_posting_history` (`history_id`, `jp_id`, `platform_id`, `external_job_id`, `status`, `posted_at`, `expires_at`, `views_count`, `clicks_count`, `applications_count`, `last_synced`, `error_message`, `created_at`) VALUES
	(1, 1, 5, 'ext_1_5', 'Posted', '2025-11-14 17:27:22', NULL, 58, 21, 10, NULL, NULL, '2025-11-14 11:57:22'),
	(2, 1, 4, 'ext_1_4', 'Posted', '2025-11-14 17:27:22', NULL, 76, 49, 4, NULL, NULL, '2025-11-14 11:57:22'),
	(3, 2, 3, 'ext_2_3', 'Posted', '2025-11-14 17:27:22', NULL, 180, 22, 10, NULL, NULL, '2025-11-14 11:57:22'),
	(4, 2, 2, 'ext_2_2', 'Posted', '2025-11-14 17:27:22', NULL, 136, 36, 20, NULL, NULL, '2025-11-14 11:57:22'),
	(5, 3, 2, 'ext_3_2', 'Posted', '2025-11-14 17:27:22', NULL, 285, 64, 7, NULL, NULL, '2025-11-14 11:57:22'),
	(6, 3, 4, 'ext_3_4', 'Posted', '2025-11-14 17:27:22', NULL, 279, 66, 7, NULL, NULL, '2025-11-14 11:57:22'),
	(7, 5, 2, 'ext_5_2', 'Posted', '2025-11-14 17:27:22', NULL, 415, 46, 14, NULL, NULL, '2025-11-14 11:57:22'),
	(8, 5, 6, 'ext_5_6', 'Posted', '2025-11-14 17:27:22', NULL, 480, 28, 6, NULL, NULL, '2025-11-14 11:57:22');

-- Dumping structure for table cmsadver_rmsdb.job_roles
DROP TABLE IF EXISTS `job_roles`;
CREATE TABLE IF NOT EXISTS `job_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_title` (`title`),
  KEY `idx_active` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.job_roles: ~5 rows (approximately)
DELETE FROM `job_roles`;
INSERT INTO `job_roles` (`id`, `title`, `description`, `department`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 'Software Engineer', 'Develops and maintains software applications', 'Engineering', 1, '2025-11-16 13:28:43', '2025-11-16 13:28:43'),
	(2, 'Marketing Manager', 'Manages marketing campaigns and strategies', 'Marketing', 1, '2025-11-16 13:28:44', '2025-11-16 13:28:44'),
	(3, 'HR Manager', 'Manages human resources and recruitment', 'Human Resources', 1, '2025-11-16 13:28:44', '2025-11-16 13:28:44'),
	(4, 'Sales Executive', 'Handles sales and client relationships', 'Sales', 1, '2025-11-16 13:28:44', '2025-11-16 13:28:44'),
	(5, 'Data Analyst', 'Analyzes data and creates reports', 'Analytics', 1, '2025-11-16 13:28:44', '2025-11-16 13:28:44');

-- Dumping structure for table cmsadver_rmsdb.knowledge_base
DROP TABLE IF EXISTS `knowledge_base`;
CREATE TABLE IF NOT EXISTS `knowledge_base` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(50) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `keywords` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`keywords`)),
  `relevance_score` int(11) DEFAULT 0,
  `usage_count` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_category` (`category`),
  FULLTEXT KEY `idx_question` (`question`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.knowledge_base: ~9 rows (approximately)
DELETE FROM `knowledge_base`;
INSERT INTO `knowledge_base` (`id`, `category`, `question`, `answer`, `keywords`, `relevance_score`, `usage_count`, `is_active`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, 'company', 'What is your company about?', 'We are a leading technology company specializing in innovative solutions for businesses across Sri Lanka and beyond. Our mission is to empower organizations through cutting-edge technology.', '["company", "about", "mission", "what do you do"]', 0, 0, 1, NULL, '2025-11-16 06:59:50', '2025-11-16 06:59:50'),
	(2, 'process', 'How long does the hiring process take?', 'Our typical hiring process takes 2-3 weeks from application to final decision. This includes CV review (2-3 days), initial interview (within 1 week), technical assessment (if applicable), and final interview.', '["timeline", "how long", "hiring process", "duration"]', 0, 0, 1, NULL, '2025-11-16 06:59:50', '2025-11-16 06:59:50'),
	(3, 'benefits', 'What benefits do you offer?', 'We offer comprehensive benefits including competitive salary, health insurance, annual leave, professional development opportunities, flexible work arrangements, and performance bonuses.', '["benefits", "perks", "salary", "compensation", "insurance"]', 0, 0, 1, NULL, '2025-11-16 06:59:50', '2025-11-16 06:59:50'),
	(4, 'company', 'What is your company about?', 'We are a leading technology company specializing in innovative solutions for businesses across Sri Lanka and beyond. Our mission is to empower organizations through cutting-edge technology.', '["company", "about", "mission", "what do you do"]', 0, 0, 1, NULL, '2025-11-16 08:39:19', '2025-11-16 08:39:19'),
	(5, 'process', 'How long does the hiring process take?', 'Our typical hiring process takes 2-3 weeks from application to final decision. This includes CV review (2-3 days), initial interview (within 1 week), technical assessment (if applicable), and final interview.', '["timeline", "how long", "hiring process", "duration"]', 0, 0, 1, NULL, '2025-11-16 08:39:19', '2025-11-16 08:39:19'),
	(6, 'benefits', 'What benefits do you offer?', 'We offer comprehensive benefits including competitive salary, health insurance, annual leave, professional development opportunities, flexible work arrangements, and performance bonuses.', '["benefits", "perks", "salary", "compensation", "insurance"]', 0, 0, 1, NULL, '2025-11-16 08:39:19', '2025-11-16 08:39:19'),
	(7, 'company', 'What is your company about?', 'We are a leading technology company specializing in innovative solutions for businesses across Sri Lanka and beyond. Our mission is to empower organizations through cutting-edge technology.', '["company", "about", "mission", "what do you do"]', 0, 0, 1, NULL, '2025-11-16 12:37:48', '2025-11-16 12:37:48'),
	(8, 'process', 'How long does the hiring process take?', 'Our typical hiring process takes 2-3 weeks from application to final decision. This includes CV review (2-3 days), initial interview (within 1 week), technical assessment (if applicable), and final interview.', '["timeline", "how long", "hiring process", "duration"]', 0, 0, 1, NULL, '2025-11-16 12:37:48', '2025-11-16 12:37:48'),
	(9, 'benefits', 'What benefits do you offer?', 'We offer comprehensive benefits including competitive salary, health insurance, annual leave, professional development opportunities, flexible work arrangements, and performance bonuses.', '["benefits", "perks", "salary", "compensation", "insurance"]', 0, 0, 1, NULL, '2025-11-16 12:37:48', '2025-11-16 12:37:48');

-- Dumping structure for table cmsadver_rmsdb.marketing_campaigns
DROP TABLE IF EXISTS `marketing_campaigns`;
CREATE TABLE IF NOT EXISTS `marketing_campaigns` (
  `campaign_id` int(11) NOT NULL AUTO_INCREMENT,
  `campaign_name` varchar(255) NOT NULL,
  `campaign_type` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Draft',
  `budget` decimal(10,2) DEFAULT NULL,
  `target_audience` text DEFAULT NULL,
  `goals` text DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`campaign_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.marketing_campaigns: ~11 rows (approximately)
DELETE FROM `marketing_campaigns`;
INSERT INTO `marketing_campaigns` (`campaign_id`, `campaign_name`, `campaign_type`, `description`, `start_date`, `end_date`, `status`, `budget`, `target_audience`, `goals`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, 'Summer 2024 Tech Talent Drive', 'Multi-Channel', 'Comprehensive campaign to attract top tech talent for summer hiring season', '2024-06-01', '2024-08-31', 'Active', 15000.00, 'Software Engineers, Data Scientists, and DevOps professionals with 3-5 years experience', 'Generate 200 qualified applications, Increase brand awareness by 40%', 'admin', '2025-11-14 18:21:57', '2025-11-14 18:21:57'),
	(2, 'Summer 2024 Tech Talent Drive', 'Multi-Channel', 'Comprehensive campaign to attract top tech talent for summer hiring season', '2024-06-01', '2024-08-31', 'Active', 15000.00, 'Software Engineers, Data Scientists, and DevOps professionals with 3-5 years experience', 'Generate 200 qualified applications, Increase brand awareness by 40%', 'admin', '2025-11-14 18:23:43', '2025-11-14 18:23:43'),
	(3, 'Healthcare Professionals Recruitment', 'Email', 'Targeted email campaign for healthcare positions', '2024-07-01', '2024-09-30', 'Active', 8000.00, 'Registered Nurses, Medical Technicians, Healthcare Administrators', 'Fill 50 healthcare positions, Build talent pipeline', 'admin', '2025-11-14 18:23:43', '2025-11-14 18:23:43'),
	(4, 'LinkedIn Sponsored Jobs Campaign', 'Paid Ads', 'Sponsored job postings on LinkedIn for senior positions', '2024-08-01', '2024-10-31', 'Active', 12000.00, 'Senior Software Engineers, Engineering Managers, Product Managers', 'Reach 50,000 professionals, Generate 150 applications', 'admin', '2025-11-14 18:23:43', '2025-11-14 18:23:43'),
	(5, 'Graduate Recruitment Program 2024', 'Social Media', 'Campus recruitment campaign targeting recent graduates', '2024-09-01', '2024-11-30', 'Draft', 5000.00, 'Recent graduates in Computer Science, Engineering, Business', 'Hire 30 entry-level positions, Build employer brand on campus', 'admin', '2025-11-14 18:23:43', '2025-11-14 18:23:43'),
	(6, 'Remote Work Opportunities Campaign', 'Multi-Channel', 'Promoting remote work opportunities across all channels', '2024-10-01', '2024-12-31', 'Paused', 10000.00, 'Remote workers, Digital nomads, Work-from-home professionals', 'Fill 40 remote positions, Expand geographic reach', 'admin', '2025-11-14 18:23:43', '2025-11-14 18:23:43'),
	(7, 'Summer 2024 Tech Talent Drive', 'Multi-Channel', 'Comprehensive campaign to attract top tech talent for summer hiring season', '2024-06-01', '2024-08-31', 'Active', 15000.00, 'Software Engineers, Data Scientists, and DevOps professionals with 3-5 years experience', 'Generate 200 qualified applications, Increase brand awareness by 40%', 'admin', '2025-11-14 18:27:47', '2025-11-14 18:27:47'),
	(8, 'Healthcare Professionals Recruitment', 'Email', 'Targeted email campaign for healthcare positions', '2024-07-01', '2024-09-30', 'Active', 8000.00, 'Registered Nurses, Medical Technicians, Healthcare Administrators', 'Fill 50 healthcare positions, Build talent pipeline', 'admin', '2025-11-14 18:27:47', '2025-11-14 18:27:47'),
	(9, 'LinkedIn Sponsored Jobs Campaign', 'Paid Ads', 'Sponsored job postings on LinkedIn for senior positions', '2024-08-01', '2024-10-31', 'Active', 12000.00, 'Senior Software Engineers, Engineering Managers, Product Managers', 'Reach 50,000 professionals, Generate 150 applications', 'admin', '2025-11-14 18:27:47', '2025-11-14 18:27:47'),
	(10, 'Graduate Recruitment Program 2024', 'Social Media', 'Campus recruitment campaign targeting recent graduates', '2024-09-01', '2024-11-30', 'Draft', 5000.00, 'Recent graduates in Computer Science, Engineering, Business', 'Hire 30 entry-level positions, Build employer brand on campus', 'admin', '2025-11-14 18:27:47', '2025-11-14 18:27:47'),
	(11, 'Remote Work Opportunities Campaign', 'Multi-Channel', 'Promoting remote work opportunities across all channels', '2024-10-01', '2024-12-31', 'Paused', 10000.00, 'Remote workers, Digital nomads, Work-from-home professionals', 'Fill 40 remote positions, Expand geographic reach', 'admin', '2025-11-14 18:27:47', '2025-11-14 18:27:47');

-- Dumping structure for table cmsadver_rmsdb.messages
DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_username` varchar(100) NOT NULL,
  `to_username` varchar(100) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `sent_at` datetime DEFAULT current_timestamp(),
  `read_at` datetime DEFAULT NULL,
  `parent_message_id` int(11) DEFAULT NULL COMMENT 'For threading',
  PRIMARY KEY (`id`),
  KEY `from_username` (`from_username`),
  KEY `to_username` (`to_username`),
  KEY `is_read` (`is_read`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.messages: ~0 rows (approximately)
DELETE FROM `messages`;

-- Dumping structure for table cmsadver_rmsdb.module_visibility
DROP TABLE IF EXISTS `module_visibility`;
CREATE TABLE IF NOT EXISTS `module_visibility` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_key` varchar(50) NOT NULL,
  `is_visible` tinyint(1) DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `module_key` (`module_key`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.module_visibility: ~11 rows (approximately)
DELETE FROM `module_visibility`;
INSERT INTO `module_visibility` (`id`, `module_key`, `is_visible`, `updated_at`) VALUES
	(1, 'dashboard', 1, '2025-11-12 03:53:45'),
	(2, 'candidates', 1, '2025-11-12 03:53:45'),
	(3, 'calendar', 1, '2025-11-12 03:53:45'),
	(4, 'analytics', 1, '2025-11-12 03:53:45'),
	(5, 'recruiters', 1, '2025-11-12 03:53:45'),
	(6, 'interviewers', 1, '2025-11-12 03:53:45'),
	(7, 'candidate_users', 1, '2025-11-12 03:53:45'),
	(8, 'reports', 1, '2025-11-12 03:53:45'),
	(9, 'roles', 0, '2025-11-12 03:53:52'),
	(10, 'setup', 1, '2025-11-12 03:53:45'),
	(11, 'account', 1, '2025-11-12 03:53:45');

-- Dumping structure for table cmsadver_rmsdb.notifications
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT 'NULL for system-wide notifications',
  `type` varchar(50) NOT NULL COMMENT 'candidate, interview, job, system',
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `link` varchar(500) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `read_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `is_read` (`is_read`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table cmsadver_rmsdb.notifications: ~5 rows (approximately)
DELETE FROM `notifications`;
INSERT INTO `notifications` (`id`, `user_id`, `type`, `title`, `message`, `link`, `is_read`, `created_at`, `read_at`) VALUES
	(1, NULL, 'system', 'Welcome to Enhanced Dashboard', 'New UI/UX improvements have been added including search and notifications!', 'http://localhost/rms/A_dashboard', 0, '2025-11-12 05:37:15', NULL),
	(2, NULL, 'candidate', 'New Candidate Application', 'A new candidate has applied for the Software Engineer position', 'http://localhost/rms/A_dashboard/Acandidate_users_view', 0, '2025-11-12 04:42:15', NULL),
	(3, NULL, 'interview', 'Interview Reminder', 'You have an interview scheduled for tomorrow at 2:00 PM', 'http://localhost/rms/A_dashboard/Ainterviewer_view', 0, '2025-11-12 03:42:15', NULL),
	(4, NULL, 'job', 'Job Posting Expiring Soon', 'Your job posting for Senior Developer will expire in 3 days', 'http://localhost/rms/A_dashboard/Ajob_post_view', 0, '2025-11-12 02:42:15', NULL),
	(5, NULL, 'system', 'Audit Logs Available', 'Track all system activities with the new audit log feature', 'http://localhost/rms/Setup/audit_logs', 0, '2025-11-12 00:42:15', NULL);

-- Dumping structure for table cmsadver_rmsdb.oauth_config
DROP TABLE IF EXISTS `oauth_config`;
CREATE TABLE IF NOT EXISTS `oauth_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `provider` varchar(50) NOT NULL DEFAULT 'google',
  `client_id` varchar(255) DEFAULT NULL,
  `client_secret` varchar(255) DEFAULT NULL,
  `is_enabled` tinyint(1) DEFAULT 0,
  `redirect_uri` varchar(255) DEFAULT NULL,
  `auto_activate_users` tinyint(1) DEFAULT 1,
  `default_role` varchar(50) DEFAULT 'Candidate',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.oauth_config: ~1 rows (approximately)
DELETE FROM `oauth_config`;
INSERT INTO `oauth_config` (`id`, `provider`, `client_id`, `client_secret`, `is_enabled`, `redirect_uri`, `auto_activate_users`, `default_role`, `created_at`, `updated_at`) VALUES
	(1, 'google', '211766688118-sid64ufknl82qceqlaneefmsk5rdo1vt.apps.googleusercontent.com', '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', 1, 'http://localhost/rms/Login/google_callback', 1, 'Candidate', '2025-11-14 06:12:37', '2025-11-14 06:39:07');

-- Dumping structure for table cmsadver_rmsdb.pipeline_activity_log
DROP TABLE IF EXISTS `pipeline_activity_log`;
CREATE TABLE IF NOT EXISTS `pipeline_activity_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action_type` varchar(50) NOT NULL,
  `action_data` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `candidate_id` (`candidate_id`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.pipeline_activity_log: ~21 rows (approximately)
DELETE FROM `pipeline_activity_log`;
INSERT INTO `pipeline_activity_log` (`id`, `candidate_id`, `user_id`, `action_type`, `action_data`, `created_at`) VALUES
	(1, 1, 1, 'added_to_pipeline', '{"stage_id": 1}', '2025-10-25 18:00:40'),
	(2, 2, 1, 'added_to_pipeline', '{"stage_id": 2}', '2025-10-25 18:00:40'),
	(3, 3, 1, 'added_to_pipeline', '{"stage_id": 2}', '2025-10-30 18:00:40'),
	(4, 4, 1, 'added_to_pipeline', '{"stage_id": 3}', '2025-11-01 18:00:40'),
	(5, 5, 1, 'added_to_pipeline', '{"stage_id": 3}', '2025-11-03 18:00:40'),
	(6, 6, 1, 'added_to_pipeline', '{"stage_id": 4}', '2025-11-06 18:00:40'),
	(7, 7, 1, 'added_to_pipeline', '{"stage_id": 4}', '2025-11-02 18:00:41'),
	(8, 8, 1, 'added_to_pipeline', '{"stage_id": 5}', '2025-10-27 18:00:41'),
	(9, 9, 1, 'added_to_pipeline', '{"stage_id": 5}', '2025-10-25 18:00:41'),
	(10, 10, 1, 'added_to_pipeline', '{"stage_id": 6}', '2025-11-01 18:00:41'),
	(11, 11, 1, 'added_to_pipeline', '{"stage_id": 1}', '2025-10-27 18:00:41'),
	(12, 12, 1, 'added_to_pipeline', '{"stage_id": 1}', '2025-11-05 18:00:41'),
	(13, 13, 1, 'added_to_pipeline', '{"stage_id": 2}', '2025-11-04 18:00:41'),
	(14, 14, 1, 'added_to_pipeline', '{"stage_id": 3}', '2025-11-04 18:00:41'),
	(15, 15, 1, 'added_to_pipeline', '{"stage_id": 4}', '2025-10-31 18:00:41'),
	(16, 10, 1, 'stage_change', '{"stage_id":"6","notes":""}', '2025-11-08 22:32:01'),
	(17, 10, 1, 'stage_change', '{"stage_id":"6","notes":""}', '2025-11-08 22:32:07'),
	(18, 10, 1, 'stage_change', '{"stage_id":"7","notes":"Add"}', '2025-11-08 22:34:46'),
	(19, 10, 1, 'stage_change', '{"stage_id":"8","notes":"rejected"}', '2025-11-08 22:34:56'),
	(20, 10, 1, 'stage_change', '{"stage_id":"8","notes":"test"}', '2025-11-08 22:39:05'),
	(21, 10, 1, 'stage_change', '{"stage_id":"7","notes":"hired"}', '2025-11-08 22:39:14');

-- Dumping structure for table cmsadver_rmsdb.pipeline_stages
DROP TABLE IF EXISTS `pipeline_stages`;
CREATE TABLE IF NOT EXISTS `pipeline_stages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `order_position` int(11) NOT NULL,
  `color` varchar(20) DEFAULT '#007bff',
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.pipeline_stages: ~8 rows (approximately)
DELETE FROM `pipeline_stages`;
INSERT INTO `pipeline_stages` (`id`, `name`, `order_position`, `color`, `description`, `is_active`, `created_at`) VALUES
	(1, 'Applied', 1, '#6c757d', 'Initial application received', 1, '2025-11-08 22:12:50'),
	(2, 'Screening', 2, '#17a2b8', 'Resume screening in progress', 1, '2025-11-08 22:12:50'),
	(3, 'Phone Interview', 3, '#ffc107', 'Phone screening scheduled', 1, '2025-11-08 22:12:50'),
	(4, 'Technical Interview', 4, '#fd7e14', 'Technical assessment', 1, '2025-11-08 22:12:50'),
	(5, 'Final Interview', 5, '#007bff', 'Final round with management', 1, '2025-11-08 22:12:50'),
	(6, 'Offer', 6, '#28a745', 'Offer extended', 1, '2025-11-08 22:12:50'),
	(7, 'Hired', 7, '#20c997', 'Candidate accepted offer', 1, '2025-11-08 22:12:50'),
	(8, 'Rejected', 8, '#dc3545', 'Not moving forward', 1, '2025-11-08 22:12:50');

-- Dumping structure for table cmsadver_rmsdb.profile_info
DROP TABLE IF EXISTS `profile_info`;
CREATE TABLE IF NOT EXISTS `profile_info` (
  `pi_id` int(20) NOT NULL AUTO_INCREMENT,
  `pi_username` varchar(255) NOT NULL,
  `pi_name` varchar(255) NOT NULL,
  `pi_email` varchar(255) NOT NULL,
  `pi_first_name` varchar(100) DEFAULT NULL,
  `pi_last_name` varchar(100) DEFAULT NULL,
  `pi_full_name` varchar(200) DEFAULT NULL,
  `pi_phone` varchar(20) NOT NULL,
  `pi_gender` varchar(255) NOT NULL,
  `pi_jobtitle` varchar(255) NOT NULL DEFAULT 'Admin',
  `pi_role` varchar(255) NOT NULL,
  PRIMARY KEY (`pi_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table cmsadver_rmsdb.profile_info: ~20 rows (approximately)
DELETE FROM `profile_info`;
INSERT INTO `profile_info` (`pi_id`, `pi_username`, `pi_name`, `pi_email`, `pi_first_name`, `pi_last_name`, `pi_full_name`, `pi_phone`, `pi_gender`, `pi_jobtitle`, `pi_role`) VALUES
	(1, 'johndoe', 'John Doe', 'john.doe@example.com', NULL, NULL, NULL, '0716060269', 'Male', 'HR Manager', 'Admin'),
	(2, 'janedoe', 'Jane Doe', 'jane.doe@example.com', NULL, NULL, NULL, '9876543210', 'Female', 'Senior Recruiter', 'Recruiter'),
	(3, 'mikebrown', 'Mike Brown', 'mike.brown@example.com', NULL, NULL, NULL, '5556667777', 'Male', 'Talent Acquisition', 'Recruiter'),
	(4, 'sarahlee', 'Sarah Lee', 'dushya7@gmail.com', 'Dushyantha', 'Sooriyaarachchi', 'Dushyantha Sooriyaarachchi', '1112223333', 'Female', 'Tech Lead', 'Interviewer'),
	(5, 'davidkim', 'David Kim', 'david.kim@example.com', NULL, NULL, NULL, '4445556666', 'Male', 'Engineering Manager', 'Interviewer'),
	(6, 'johndoe', '', 'admin@rms.com', NULL, NULL, NULL, '555-1001', 'Male', 'Admin', 'Admin'),
	(7, 'sarah_rec', '', 'sarah@rms.com', NULL, NULL, NULL, '555-1002', 'Female', 'Admin', 'Recruiter'),
	(8, 'mike_rec', '', 'mike@rms.com', NULL, NULL, NULL, '555-1003', 'Male', 'Admin', 'Recruiter'),
	(9, 'david_int', '', 'david@rms.com', NULL, NULL, NULL, '555-1004', 'Male', 'Admin', 'Interviewer'),
	(10, 'emma_int', '', 'emma@rms.com', NULL, NULL, NULL, '555-1005', 'Female', 'Admin', 'Interviewer'),
	(11, 'johndoe', '', 'admin@rms.com', NULL, NULL, NULL, '555-1001', 'Male', 'Admin', 'Admin'),
	(12, 'sarah_rec', '', 'sarah@rms.com', NULL, NULL, NULL, '555-1002', 'Female', 'Admin', 'Recruiter'),
	(13, 'mike_rec', '', 'mike@rms.com', NULL, NULL, NULL, '555-1003', 'Male', 'Admin', 'Recruiter'),
	(14, 'david_int', '', 'david@rms.com', NULL, NULL, NULL, '555-1004', 'Male', 'Admin', 'Interviewer'),
	(15, 'emma_int', '', 'emma@rms.com', NULL, NULL, NULL, '555-1005', 'Female', 'Admin', 'Interviewer'),
	(16, 'charaka3', '', 'charaka@rms.com', NULL, NULL, NULL, '0716060100', 'Male', 'Admin', 'Interviewer'),
	(18, 'charaka2', '', 'charakanibm@gmail.com', 'Charaka', 'Nibm', 'Charaka Nibm', '', '', 'Admin', 'Interviewer'),
	(19, 'ucsc', '', 'charakaucsc@gmail.com', 'charaka', 'ucsc', 'charaka ucsc', '', '', 'Admin', 'Recruiter'),
	(20, 'charakacreations', '', 'charakacreations@gmail.com', 'Charaka', 'Creations', 'Charaka Creations', '', '', 'Admin', 'Candidate'),
	(21, 'rasika', '', '', NULL, NULL, NULL, '', 'Male', 'Admin', '');

-- Dumping structure for table cmsadver_rmsdb.questions_bank
DROP TABLE IF EXISTS `questions_bank`;
CREATE TABLE IF NOT EXISTS `questions_bank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_text` text NOT NULL,
  `question_type` enum('mcq_single','mcq_multiple','text','rating') DEFAULT 'mcq_single',
  `category_id` int(11) DEFAULT NULL,
  `difficulty` enum('easy','medium','hard') DEFAULT 'medium',
  `points` int(11) DEFAULT 1,
  `time_limit` int(11) DEFAULT 120 COMMENT 'Time in seconds',
  `is_mandatory` tinyint(1) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_category` (`category_id`),
  KEY `idx_type` (`question_type`),
  KEY `idx_difficulty` (`difficulty`),
  KEY `idx_mandatory` (`is_mandatory`),
  KEY `idx_active` (`is_active`),
  CONSTRAINT `questions_bank_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `question_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.questions_bank: ~0 rows (approximately)
DELETE FROM `questions_bank`;

-- Dumping structure for table cmsadver_rmsdb.question_categories
DROP TABLE IF EXISTS `question_categories`;
CREATE TABLE IF NOT EXISTS `question_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `type` enum('mandatory','role_specific','optional') DEFAULT 'role_specific',
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_type` (`type`),
  KEY `idx_active` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.question_categories: ~5 rows (approximately)
DELETE FROM `question_categories`;
INSERT INTO `question_categories` (`id`, `name`, `description`, `type`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 'Behavioral Questions', 'Questions about past behavior and experiences', 'mandatory', 1, '2025-11-16 13:28:43', '2025-11-16 13:28:43'),
	(2, 'Technical Skills', 'Role-specific technical questions', 'role_specific', 1, '2025-11-16 13:28:43', '2025-11-16 13:28:43'),
	(3, 'Problem Solving', 'Analytical and problem-solving questions', 'role_specific', 1, '2025-11-16 13:28:43', '2025-11-16 13:28:43'),
	(4, 'Communication', 'Communication and interpersonal skills', 'optional', 1, '2025-11-16 13:28:43', '2025-11-16 13:28:43'),
	(5, 'Leadership', 'Leadership and management questions', 'optional', 1, '2025-11-16 13:28:43', '2025-11-16 13:28:43');

-- Dumping structure for table cmsadver_rmsdb.question_options
DROP TABLE IF EXISTS `question_options`;
CREATE TABLE IF NOT EXISTS `question_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `option_text` text NOT NULL,
  `is_correct` tinyint(1) DEFAULT 0,
  `option_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_question` (`question_id`),
  KEY `idx_correct` (`is_correct`),
  CONSTRAINT `question_options_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions_bank` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.question_options: ~0 rows (approximately)
DELETE FROM `question_options`;

-- Dumping structure for table cmsadver_rmsdb.question_role_mapping
DROP TABLE IF EXISTS `question_role_mapping`;
CREATE TABLE IF NOT EXISTS `question_role_mapping` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_mapping` (`question_id`,`role_id`),
  KEY `idx_question` (`question_id`),
  KEY `idx_role` (`role_id`),
  CONSTRAINT `question_role_mapping_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions_bank` (`id`) ON DELETE CASCADE,
  CONSTRAINT `question_role_mapping_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `job_roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.question_role_mapping: ~0 rows (approximately)
DELETE FROM `question_role_mapping`;

-- Dumping structure for table cmsadver_rmsdb.question_tags
DROP TABLE IF EXISTS `question_tags`;
CREATE TABLE IF NOT EXISTS `question_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag_name` (`tag_name`),
  KEY `idx_tag` (`tag_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.question_tags: ~0 rows (approximately)
DELETE FROM `question_tags`;

-- Dumping structure for table cmsadver_rmsdb.question_tag_mapping
DROP TABLE IF EXISTS `question_tag_mapping`;
CREATE TABLE IF NOT EXISTS `question_tag_mapping` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_tag_mapping` (`question_id`,`tag_id`),
  KEY `idx_question` (`question_id`),
  KEY `idx_tag` (`tag_id`),
  CONSTRAINT `question_tag_mapping_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions_bank` (`id`) ON DELETE CASCADE,
  CONSTRAINT `question_tag_mapping_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `question_tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.question_tag_mapping: ~0 rows (approximately)
DELETE FROM `question_tag_mapping`;

-- Dumping structure for table cmsadver_rmsdb.recruitment_events
DROP TABLE IF EXISTS `recruitment_events`;
CREATE TABLE IF NOT EXISTS `recruitment_events` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_name` varchar(255) NOT NULL,
  `event_type` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `event_date` date NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `venue_type` varchar(50) DEFAULT 'Physical',
  `virtual_link` varchar(500) DEFAULT NULL,
  `max_attendees` int(11) DEFAULT NULL,
  `registered_count` int(11) DEFAULT 0,
  `status` varchar(50) DEFAULT 'Upcoming',
  `budget` decimal(10,2) DEFAULT NULL,
  `organizer` varchar(100) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(50) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`event_id`),
  KEY `idx_event_date` (`event_date`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.recruitment_events: ~4 rows (approximately)
DELETE FROM `recruitment_events`;
INSERT INTO `recruitment_events` (`event_id`, `event_name`, `event_type`, `description`, `event_date`, `start_time`, `end_time`, `location`, `venue_type`, `virtual_link`, `max_attendees`, `registered_count`, `status`, `budget`, `organizer`, `contact_email`, `contact_phone`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, 'Tech Talent Job Fair 2024', 'Job Fair', 'Annual technology job fair featuring top tech companies and startups', '2024-12-15', '09:00:00', '17:00:00', 'San Francisco Convention Center', 'Physical', NULL, 500, 234, 'Upcoming', 25000.00, 'HR Team', 'events@company.com', NULL, 'admin', '2025-11-14 19:23:46', '2025-11-14 19:23:46'),
	(2, 'Virtual Career Day - Engineering', 'Virtual Job Fair', 'Online career day for engineering positions across all levels', '2024-11-25', '10:00:00', '16:00:00', NULL, 'Virtual', 'https://zoom.us/j/example123', 1000, 567, 'Upcoming', 5000.00, 'Recruitment Team', 'careers@company.com', NULL, 'admin', '2025-11-14 19:23:46', '2025-11-14 19:23:46'),
	(3, 'Campus Recruitment - MIT', 'Campus Recruitment', 'On-campus recruitment drive at MIT for fresh graduates', '2024-12-01', '11:00:00', '15:00:00', 'MIT Career Center', 'Physical', NULL, 200, 156, 'Upcoming', 8000.00, 'Campus Relations', 'campus@company.com', NULL, 'admin', '2025-11-14 19:23:46', '2025-11-14 19:23:46'),
	(4, 'Data Science Networking Mixer', 'Networking Event', 'Informal networking event for data science professionals', '2024-11-20', '18:00:00', '21:00:00', 'Downtown Tech Hub', 'Physical', NULL, 100, 89, 'Upcoming', 3000.00, 'Data Team', 'data@company.com', NULL, 'admin', '2025-11-14 19:23:46', '2025-11-14 19:23:46');

-- Dumping structure for table cmsadver_rmsdb.referrals
DROP TABLE IF EXISTS `referrals`;
CREATE TABLE IF NOT EXISTS `referrals` (
  `referral_id` int(11) NOT NULL AUTO_INCREMENT,
  `referral_code` varchar(50) DEFAULT NULL,
  `referrer_id` int(11) NOT NULL,
  `referrer_name` varchar(255) NOT NULL,
  `referrer_email` varchar(255) DEFAULT NULL,
  `candidate_name` varchar(255) NOT NULL,
  `candidate_email` varchar(255) NOT NULL,
  `candidate_phone` varchar(50) DEFAULT NULL,
  `candidate_resume` varchar(255) DEFAULT NULL,
  `position_id` int(11) DEFAULT NULL,
  `position_name` varchar(255) DEFAULT NULL,
  `referral_date` date NOT NULL,
  `referral_status` varchar(50) DEFAULT 'Submitted',
  `candidate_status` varchar(50) DEFAULT 'New',
  `interview_date` date DEFAULT NULL,
  `hired_date` date DEFAULT NULL,
  `bonus_eligible` tinyint(1) DEFAULT 1,
  `bonus_amount` decimal(10,2) DEFAULT NULL,
  `bonus_status` varchar(50) DEFAULT 'Pending',
  `bonus_paid_date` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`referral_id`),
  UNIQUE KEY `referral_code` (`referral_code`),
  KEY `idx_referrer` (`referrer_id`),
  KEY `idx_status` (`referral_status`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.referrals: ~9 rows (approximately)
DELETE FROM `referrals`;
INSERT INTO `referrals` (`referral_id`, `referral_code`, `referrer_id`, `referrer_name`, `referrer_email`, `candidate_name`, `candidate_email`, `candidate_phone`, `candidate_resume`, `position_id`, `position_name`, `referral_date`, `referral_status`, `candidate_status`, `interview_date`, `hired_date`, `bonus_eligible`, `bonus_amount`, `bonus_status`, `bonus_paid_date`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, NULL, 1, 'Admin User', 'admin@company.com', 'John Smith', 'john.smith@email.com', '555-0101', NULL, NULL, 'Senior Software Engineer', '2025-07-17', 'Hired', 'New', NULL, '2025-07-27', 1, 2000.00, 'Paid', '2025-10-25', NULL, 'admin', '2025-07-17 07:57:35', '2025-11-14 12:27:35'),
	(2, NULL, 1, 'Admin User', 'admin@company.com', 'John Smith', 'john.smith@email.com', '555-0101', NULL, NULL, 'Senior Software Engineer', '2025-07-17', 'Hired', 'New', NULL, '2025-07-27', 1, 2000.00, 'Paid', '2025-10-25', NULL, 'admin', '2025-07-17 08:06:04', '2025-11-14 12:36:04'),
	(3, NULL, 1, 'Admin User', 'admin@company.com', 'Sarah Johnson', 'sarah.j@email.com', '555-0102', NULL, NULL, 'Marketing Manager', '2025-10-30', 'Interviewing', 'New', NULL, NULL, 1, 1000.00, 'Pending', NULL, NULL, 'admin', '2025-10-30 08:06:05', '2025-11-14 12:36:05'),
	(4, NULL, 1, 'Admin User', 'admin@company.com', 'Michael Chen', 'mchen@email.com', '555-0103', NULL, NULL, 'Data Analyst', '2025-11-07', 'Screening', 'New', NULL, NULL, 1, 1000.00, 'Pending', NULL, NULL, 'admin', '2025-11-07 08:06:05', '2025-11-14 12:36:05'),
	(5, NULL, 1, 'Admin User', 'admin@company.com', 'Emily Davis', 'emily.davis@email.com', '555-0104', NULL, NULL, 'UX Designer', '2025-09-30', 'Hired', 'New', NULL, '2025-10-10', 1, 1500.00, 'Approved', NULL, NULL, 'admin', '2025-09-30 08:06:05', '2025-11-14 12:36:05'),
	(6, NULL, 1, 'Admin User', 'admin@company.com', 'Robert Wilson', 'rwilson@email.com', '555-0105', NULL, NULL, 'DevOps Engineer', '2025-11-11', 'Submitted', 'New', NULL, NULL, 1, 2000.00, 'Pending', NULL, NULL, 'admin', '2025-11-11 08:06:05', '2025-11-14 12:36:05'),
	(7, NULL, 1, 'Admin User', 'admin@company.com', 'Lisa Anderson', 'l.anderson@email.com', '555-0106', NULL, NULL, 'Product Manager', '2025-10-25', 'Interviewing', 'New', NULL, NULL, 1, 2000.00, 'Pending', NULL, NULL, 'admin', '2025-10-25 08:06:05', '2025-11-14 12:36:05'),
	(8, NULL, 1, 'Admin User', 'admin@company.com', 'David Martinez', 'dmartinez@email.com', '555-0107', NULL, NULL, 'Sales Representative', '2025-10-15', 'Rejected', 'New', NULL, NULL, 1, 0.00, 'N/A', NULL, NULL, 'admin', '2025-10-15 08:06:05', '2025-11-14 12:36:05'),
	(9, NULL, 1, 'Admin User', 'admin@company.com', 'Jennifer Taylor', 'jtaylor@email.com', '555-0108', NULL, NULL, 'HR Specialist', '2025-06-17', 'Hired', 'New', NULL, '2025-06-27', 1, 1000.00, 'Paid', '2025-09-25', NULL, 'admin', '2025-06-17 08:06:05', '2025-11-14 12:36:05');

-- Dumping structure for table cmsadver_rmsdb.referral_bonuses
DROP TABLE IF EXISTS `referral_bonuses`;
CREATE TABLE IF NOT EXISTS `referral_bonuses` (
  `bonus_id` int(11) NOT NULL AUTO_INCREMENT,
  `position_level` varchar(100) DEFAULT NULL,
  `job_category_id` int(11) DEFAULT NULL,
  `bonus_amount` decimal(10,2) NOT NULL,
  `bonus_currency` varchar(10) DEFAULT 'USD',
  `eligibility_criteria` text DEFAULT NULL,
  `payout_schedule` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`bonus_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.referral_bonuses: ~5 rows (approximately)
DELETE FROM `referral_bonuses`;
INSERT INTO `referral_bonuses` (`bonus_id`, `position_level`, `job_category_id`, `bonus_amount`, `bonus_currency`, `eligibility_criteria`, `payout_schedule`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 'Entry Level', NULL, 500.00, 'USD', NULL, 'After 90 days of employment', 1, '2025-11-14 12:08:09', '2025-11-14 12:08:09'),
	(2, 'Mid Level', NULL, 1000.00, 'USD', NULL, 'After 90 days of employment', 1, '2025-11-14 12:08:09', '2025-11-14 12:08:09'),
	(3, 'Senior Level', NULL, 2000.00, 'USD', NULL, 'After 90 days of employment', 1, '2025-11-14 12:08:09', '2025-11-14 12:08:09'),
	(4, 'Executive Level', NULL, 5000.00, 'USD', NULL, 'After 90 days of employment', 1, '2025-11-14 12:08:09', '2025-11-14 12:08:09'),
	(5, 'Technical Specialist', NULL, 1500.00, 'USD', NULL, 'After 90 days of employment', 1, '2025-11-14 12:08:09', '2025-11-14 12:08:09');

-- Dumping structure for table cmsadver_rmsdb.referral_bonus_payments
DROP TABLE IF EXISTS `referral_bonus_payments`;
CREATE TABLE IF NOT EXISTS `referral_bonus_payments` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `referral_id` int(11) NOT NULL,
  `referrer_id` int(11) NOT NULL,
  `payment_amount` decimal(10,2) NOT NULL,
  `payment_currency` varchar(10) DEFAULT 'USD',
  `payment_date` date DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT 'Pending',
  `payment_reference` varchar(100) DEFAULT NULL,
  `approved_by` varchar(100) DEFAULT NULL,
  `approved_date` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`payment_id`),
  KEY `referral_id` (`referral_id`),
  CONSTRAINT `referral_bonus_payments_ibfk_1` FOREIGN KEY (`referral_id`) REFERENCES `referrals` (`referral_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.referral_bonus_payments: ~2 rows (approximately)
DELETE FROM `referral_bonus_payments`;
INSERT INTO `referral_bonus_payments` (`payment_id`, `referral_id`, `referrer_id`, `payment_amount`, `payment_currency`, `payment_date`, `payment_method`, `payment_status`, `payment_reference`, `approved_by`, `approved_date`, `notes`, `created_at`) VALUES
	(1, 2, 1, 2000.00, 'USD', '2025-10-25', 'Bank Transfer', 'Completed', NULL, 'admin', '2025-10-25', NULL, '2025-11-14 12:36:05'),
	(2, 9, 1, 1000.00, 'USD', '2025-09-25', 'Bank Transfer', 'Completed', NULL, 'admin', '2025-09-25', NULL, '2025-11-14 12:36:05');

-- Dumping structure for table cmsadver_rmsdb.referral_campaigns
DROP TABLE IF EXISTS `referral_campaigns`;
CREATE TABLE IF NOT EXISTS `referral_campaigns` (
  `campaign_id` int(11) NOT NULL AUTO_INCREMENT,
  `campaign_name` varchar(255) NOT NULL,
  `campaign_description` text DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `bonus_multiplier` decimal(5,2) DEFAULT 1.00,
  `target_positions` text DEFAULT NULL,
  `campaign_status` varchar(50) DEFAULT 'Active',
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`campaign_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.referral_campaigns: ~0 rows (approximately)
DELETE FROM `referral_campaigns`;

-- Dumping structure for table cmsadver_rmsdb.referral_codes
DROP TABLE IF EXISTS `referral_codes`;
CREATE TABLE IF NOT EXISTS `referral_codes` (
  `code_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `referral_code` varchar(50) NOT NULL,
  `code_type` varchar(50) DEFAULT 'personal',
  `is_active` tinyint(1) DEFAULT 1,
  `uses_count` int(11) DEFAULT 0,
  `max_uses` int(11) DEFAULT NULL,
  `expires_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`code_id`),
  UNIQUE KEY `referral_code` (`referral_code`),
  KEY `idx_code` (`referral_code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.referral_codes: ~1 rows (approximately)
DELETE FROM `referral_codes`;
INSERT INTO `referral_codes` (`code_id`, `user_id`, `username`, `referral_code`, `code_type`, `is_active`, `uses_count`, `max_uses`, `expires_at`, `created_at`) VALUES
	(1, 1, 'admin', 'ADM4882', 'personal', 1, 0, NULL, NULL, '2025-11-14 12:36:05');

-- Dumping structure for table cmsadver_rmsdb.referral_program_config
DROP TABLE IF EXISTS `referral_program_config`;
CREATE TABLE IF NOT EXISTS `referral_program_config` (
  `config_id` int(11) NOT NULL AUTO_INCREMENT,
  `config_key` varchar(100) NOT NULL,
  `config_value` text DEFAULT NULL,
  `config_type` varchar(50) DEFAULT 'string',
  `description` text DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`config_id`),
  UNIQUE KEY `config_key` (`config_key`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.referral_program_config: ~8 rows (approximately)
DELETE FROM `referral_program_config`;
INSERT INTO `referral_program_config` (`config_id`, `config_key`, `config_value`, `config_type`, `description`, `updated_at`) VALUES
	(1, 'program_enabled', '1', 'boolean', 'Enable/disable referral program', '2025-11-14 12:08:08'),
	(2, 'default_bonus_amount', '1000', 'number', 'Default referral bonus amount', '2025-11-14 12:08:08'),
	(3, 'bonus_currency', 'USD', 'string', 'Currency for bonus payments', '2025-11-14 12:08:08'),
	(4, 'min_employment_days', '90', 'number', 'Minimum days candidate must stay employed', '2025-11-14 12:08:08'),
	(5, 'bonus_payout_days', '30', 'number', 'Days after hire to pay bonus', '2025-11-14 12:08:08'),
	(6, 'allow_self_referral', '0', 'boolean', 'Allow employees to refer themselves', '2025-11-14 12:08:09'),
	(7, 'max_referrals_per_month', '10', 'number', 'Maximum referrals per employee per month', '2025-11-14 12:08:09'),
	(8, 'require_approval', '1', 'boolean', 'Require admin approval for referrals', '2025-11-14 12:08:09');

-- Dumping structure for table cmsadver_rmsdb.saved_searches
DROP TABLE IF EXISTS `saved_searches`;
CREATE TABLE IF NOT EXISTS `saved_searches` (
  `search_id` int(11) NOT NULL AUTO_INCREMENT,
  `search_name` varchar(255) NOT NULL,
  `search_criteria` text NOT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `is_alert` tinyint(1) DEFAULT 0,
  `alert_frequency` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`search_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.saved_searches: ~0 rows (approximately)
DELETE FROM `saved_searches`;

-- Dumping structure for table cmsadver_rmsdb.signup_audit_log
DROP TABLE IF EXISTS `signup_audit_log`;
CREATE TABLE IF NOT EXISTS `signup_audit_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `details` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `performed_by` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `action` (`action`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.signup_audit_log: ~3 rows (approximately)
DELETE FROM `signup_audit_log`;
INSERT INTO `signup_audit_log` (`id`, `user_id`, `username`, `action`, `details`, `ip_address`, `user_agent`, `performed_by`, `created_at`) VALUES
	(1, NULL, NULL, 'settings_updated', 'Signup settings updated - {"admin_signup_enabled":1,"recruiter_signup_enabled":1,"interviewer_signup_enabled":0,"candidate_signup_enabled":1,"auto_approve_admin":1,"auto_approve_recruiter":0,"auto_approve_interviewer":0,"auto_approve_candidate":1,"require_email_verification":1,"default_signup_role":"Recruiter","updated_at":"2025-11-17 03:16:29","updated_by":"johndoe"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'johndoe', '2025-11-16 21:46:30'),
	(2, NULL, NULL, 'settings_updated', 'Signup settings updated - {"admin_signup_enabled":0,"recruiter_signup_enabled":0,"interviewer_signup_enabled":0,"candidate_signup_enabled":1,"auto_approve_admin":1,"auto_approve_recruiter":0,"auto_approve_interviewer":0,"auto_approve_candidate":1,"require_email_verification":1,"default_signup_role":"Recruiter","updated_at":"2025-11-17 03:19:32","updated_by":"Charaka"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'Charaka', '2025-11-16 21:49:32'),
	(3, NULL, NULL, 'settings_updated', 'Signup settings updated - {"admin_signup_enabled":0,"recruiter_signup_enabled":0,"interviewer_signup_enabled":0,"candidate_signup_enabled":1,"auto_approve_admin":0,"auto_approve_recruiter":0,"auto_approve_interviewer":0,"auto_approve_candidate":1,"require_email_verification":1,"default_signup_role":"Recruiter","updated_at":"2025-11-17 03:19:38","updated_by":"Charaka"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'Charaka', '2025-11-16 21:49:39');

-- Dumping structure for table cmsadver_rmsdb.signup_settings
DROP TABLE IF EXISTS `signup_settings`;
CREATE TABLE IF NOT EXISTS `signup_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_signup_enabled` tinyint(1) DEFAULT 0,
  `recruiter_signup_enabled` tinyint(1) DEFAULT 1,
  `interviewer_signup_enabled` tinyint(1) DEFAULT 0,
  `candidate_signup_enabled` tinyint(1) DEFAULT 1,
  `auto_approve_admin` tinyint(1) DEFAULT 0,
  `auto_approve_recruiter` tinyint(1) DEFAULT 0,
  `auto_approve_interviewer` tinyint(1) DEFAULT 0,
  `auto_approve_candidate` tinyint(1) DEFAULT 1,
  `require_email_verification` tinyint(1) DEFAULT 1,
  `default_signup_role` varchar(50) DEFAULT 'Recruiter',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.signup_settings: ~1 rows (approximately)
DELETE FROM `signup_settings`;
INSERT INTO `signup_settings` (`id`, `admin_signup_enabled`, `recruiter_signup_enabled`, `interviewer_signup_enabled`, `candidate_signup_enabled`, `auto_approve_admin`, `auto_approve_recruiter`, `auto_approve_interviewer`, `auto_approve_candidate`, `require_email_verification`, `default_signup_role`, `created_at`, `updated_at`, `updated_by`) VALUES
	(1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 'Recruiter', '2025-11-17 02:13:49', '2025-11-16 21:49:38', 'Charaka');

-- Dumping structure for table cmsadver_rmsdb.sms_config
DROP TABLE IF EXISTS `sms_config`;
CREATE TABLE IF NOT EXISTS `sms_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `provider` varchar(50) NOT NULL DEFAULT 'twilio',
  `api_key` varchar(255) NOT NULL,
  `api_secret` varchar(255) NOT NULL,
  `sender_id` varchar(50) NOT NULL,
  `api_endpoint` varchar(255) DEFAULT NULL,
  `country_code` varchar(10) DEFAULT '+94',
  `credits_balance` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.sms_config: ~0 rows (approximately)
DELETE FROM `sms_config`;

-- Dumping structure for table cmsadver_rmsdb.sms_logs
DROP TABLE IF EXISTS `sms_logs`;
CREATE TABLE IF NOT EXISTS `sms_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recipient_phone` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `status` enum('sent','failed','pending') DEFAULT 'pending',
  `error_message` text DEFAULT NULL,
  `provider_response` text DEFAULT NULL,
  `sent_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `recipient_phone` (`recipient_phone`),
  KEY `sent_at` (`sent_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.sms_logs: ~0 rows (approximately)
DELETE FROM `sms_logs`;

-- Dumping structure for table cmsadver_rmsdb.sms_templates
DROP TABLE IF EXISTS `sms_templates`;
CREATE TABLE IF NOT EXISTS `sms_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `template_type` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `template_type` (`template_type`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.sms_templates: ~3 rows (approximately)
DELETE FROM `sms_templates`;
INSERT INTO `sms_templates` (`id`, `template_type`, `message`, `created_at`, `updated_at`) VALUES
	(1, 'interview_reminder', 'Hi {candidate_name}, reminder: Your interview for {job_title} at {company_name} is on {interview_date} at {interview_time}. Good luck!', '2025-11-12 08:36:18', '2025-11-12 08:36:18'),
	(2, 'selection', 'Congratulations {candidate_name}! You\'ve been selected for {job_title} at {company_name}. We\'ll contact you soon with details.', '2025-11-12 08:36:18', '2025-11-12 08:36:18'),
	(3, 'interview_scheduled', 'Hi {candidate_name}, your interview for {job_title} at {company_name} is scheduled on {interview_date} at {interview_time}. Please confirm.', '2025-11-12 08:36:18', '2025-11-12 08:36:18');

-- Dumping structure for table cmsadver_rmsdb.social_posts
DROP TABLE IF EXISTS `social_posts`;
CREATE TABLE IF NOT EXISTS `social_posts` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `campaign_id` int(11) NOT NULL,
  `platform` varchar(50) NOT NULL,
  `post_content` text NOT NULL,
  `media_url` varchar(500) DEFAULT NULL,
  `scheduled_date` datetime DEFAULT NULL,
  `posted_date` datetime DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Scheduled',
  `impressions` int(11) DEFAULT 0,
  `engagements` int(11) DEFAULT 0,
  `clicks` int(11) DEFAULT 0,
  `shares` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`post_id`),
  KEY `campaign_id` (`campaign_id`),
  CONSTRAINT `social_posts_ibfk_1` FOREIGN KEY (`campaign_id`) REFERENCES `marketing_campaigns` (`campaign_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.social_posts: ~0 rows (approximately)
DELETE FROM `social_posts`;

-- Dumping structure for table cmsadver_rmsdb.sourced_candidates
DROP TABLE IF EXISTS `sourced_candidates`;
CREATE TABLE IF NOT EXISTS `sourced_candidates` (
  `candidate_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `current_title` varchar(255) DEFAULT NULL,
  `current_company` varchar(255) DEFAULT NULL,
  `total_experience` int(11) DEFAULT NULL,
  `expected_salary` decimal(10,2) DEFAULT NULL,
  `notice_period` varchar(50) DEFAULT NULL,
  `linkedin_url` varchar(500) DEFAULT NULL,
  `github_url` varchar(500) DEFAULT NULL,
  `portfolio_url` varchar(500) DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `source` varchar(100) DEFAULT NULL,
  `source_details` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'New',
  `rating` int(11) DEFAULT 0,
  `tags` text DEFAULT NULL,
  `added_by` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`candidate_id`),
  KEY `idx_email` (`email`),
  KEY `idx_status` (`status`),
  KEY `idx_source` (`source`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.sourced_candidates: ~13 rows (approximately)
DELETE FROM `sourced_candidates`;
INSERT INTO `sourced_candidates` (`candidate_id`, `first_name`, `last_name`, `email`, `phone`, `location`, `current_title`, `current_company`, `total_experience`, `expected_salary`, `notice_period`, `linkedin_url`, `github_url`, `portfolio_url`, `summary`, `source`, `source_details`, `status`, `rating`, `tags`, `added_by`, `created_at`, `updated_at`) VALUES
	(1, 'Alex', 'Johnson', 'alex.johnson@email.com', '555-0201', 'San Francisco, CA', 'Senior Full Stack Developer', 'Tech Corp', 8, 150000.00, '30 days', NULL, NULL, NULL, NULL, 'LinkedIn', NULL, 'Active', 0, NULL, 'johndoe', '2025-11-14 14:11:02', '2025-11-14 14:11:02'),
	(2, 'Maria', 'Garcia', 'maria.garcia@email.com', '555-0202', 'Austin, TX', 'Data Scientist', 'Analytics Inc', 5, 120000.00, '2 weeks', NULL, NULL, NULL, NULL, 'GitHub', NULL, 'In Pipeline', 0, NULL, 'johndoe', '2025-11-14 14:11:02', '2025-11-14 14:11:02'),
	(3, 'James', 'Brown', 'james.brown@email.com', '555-0203', 'New York, NY', 'DevOps Engineer', 'Cloud Systems', 6, 140000.00, '1 month', NULL, NULL, NULL, NULL, 'Indeed', NULL, 'Contacted', 0, NULL, 'johndoe', '2025-11-14 14:11:02', '2025-11-14 14:11:02'),
	(4, 'Sarah', 'Lee', 'sarah.lee@email.com', '555-0204', 'Seattle, WA', 'UX/UI Designer', 'Design Studio', 4, 95000.00, '2 weeks', NULL, NULL, NULL, NULL, 'Referral', NULL, 'New', 0, NULL, 'johndoe', '2025-11-14 14:11:02', '2025-11-14 14:11:02'),
	(5, 'Michael', 'Chen', 'michael.chen@email.com', '555-0205', 'Boston, MA', 'Product Manager', 'Product Co', 7, 130000.00, '1 month', NULL, NULL, NULL, NULL, 'LinkedIn', NULL, 'Active', 0, NULL, 'johndoe', '2025-11-14 14:11:02', '2025-11-14 14:11:02'),
	(6, 'John', 'Smith', 'john.smith@email.com', '+1-555-0101', 'San Francisco, CA', 'Senior Software Engineer', 'Tech Corp', 8, 150000.00, '2 weeks', 'https://linkedin.com/in/johnsmith', 'https://github.com/johnsmith', NULL, 'Experienced full-stack developer with expertise in React, Node.js, and cloud technologies.', 'LinkedIn', NULL, 'Active', 5, NULL, 'admin', '2025-11-14 18:44:00', '2025-11-14 18:44:00'),
	(7, 'Sarah', 'Johnson', 'sarah.johnson@email.com', '+1-555-0102', 'New York, NY', 'Data Scientist', 'Analytics Inc', 5, 130000.00, '1 month', 'https://linkedin.com/in/sarahjohnson', NULL, NULL, 'Data scientist specializing in machine learning and predictive analytics.', 'Indeed', NULL, 'Active', 4, NULL, 'admin', '2025-11-14 18:44:00', '2025-11-14 18:44:00'),
	(8, 'Michael', 'Chen', 'michael.chen@email.com', '+1-555-0103', 'Seattle, WA', 'DevOps Engineer', 'Cloud Systems', 6, 140000.00, '3 weeks', 'https://linkedin.com/in/michaelchen', 'https://github.com/mchen', NULL, 'DevOps engineer with strong background in CI/CD, Kubernetes, and infrastructure automation.', 'GitHub', NULL, 'Active', 5, NULL, 'admin', '2025-11-14 18:44:01', '2025-11-14 18:44:01'),
	(9, 'Emily', 'Davis', 'emily.davis@email.com', '+1-555-0104', 'Austin, TX', 'Product Manager', 'Startup XYZ', 7, 145000.00, '2 weeks', 'https://linkedin.com/in/emilydavis', NULL, NULL, 'Product manager with experience in B2B SaaS and agile methodologies.', 'Referral', NULL, 'Contacted', 4, NULL, 'admin', '2025-11-14 18:44:01', '2025-11-14 18:44:01'),
	(10, 'David', 'Martinez', 'david.martinez@email.com', '+1-555-0105', 'Boston, MA', 'UX Designer', 'Design Studio', 4, 110000.00, '2 weeks', 'https://linkedin.com/in/davidmartinez', NULL, 'https://davidmartinez.design', 'UX designer passionate about creating intuitive and accessible user experiences.', 'Company Website', NULL, 'New', 4, NULL, 'admin', '2025-11-14 18:44:01', '2025-11-14 18:44:01'),
	(11, 'Lisa', 'Anderson', 'lisa.anderson@email.com', '+1-555-0106', 'Chicago, IL', 'Frontend Developer', 'Web Solutions', 3, 95000.00, '2 weeks', 'https://linkedin.com/in/lisaanderson', 'https://github.com/landerson', NULL, 'Frontend developer specializing in modern JavaScript frameworks and responsive design.', 'Stack Overflow', NULL, 'Active', 3, NULL, 'admin', '2025-11-14 18:44:01', '2025-11-14 18:44:01'),
	(12, 'Robert', 'Taylor', 'robert.taylor@email.com', '+1-555-0107', 'Denver, CO', 'Backend Developer', 'Enterprise Systems', 9, 155000.00, '1 month', 'https://linkedin.com/in/roberttaylor', 'https://github.com/rtaylor', NULL, 'Senior backend developer with expertise in microservices architecture and distributed systems.', 'LinkedIn', NULL, 'Interviewed', 5, NULL, 'admin', '2025-11-14 18:44:01', '2025-11-14 18:44:01'),
	(13, 'Jennifer', 'Wilson', 'jennifer.wilson@email.com', '+1-555-0108', 'Portland, OR', 'QA Engineer', 'Quality First', 5, 105000.00, '2 weeks', 'https://linkedin.com/in/jenniferwilson', NULL, NULL, 'QA engineer with strong automation testing skills and attention to detail.', 'Indeed', NULL, 'Active', 4, NULL, 'admin', '2025-11-14 18:44:01', '2025-11-14 18:44:01');

-- Dumping structure for table cmsadver_rmsdb.talent_pools
DROP TABLE IF EXISTS `talent_pools`;
CREATE TABLE IF NOT EXISTS `talent_pools` (
  `pool_id` int(11) NOT NULL AUTO_INCREMENT,
  `pool_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `pool_type` varchar(50) DEFAULT 'Static',
  `criteria` text DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`pool_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.talent_pools: ~8 rows (approximately)
DELETE FROM `talent_pools`;
INSERT INTO `talent_pools` (`pool_id`, `pool_name`, `description`, `pool_type`, `criteria`, `created_by`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 'Senior Developers', 'Experienced developers with 5+ years of experience', 'Static', NULL, 'johndoe', 1, '2025-11-14 14:19:42', '2025-11-14 14:19:42'),
	(2, 'Data Science Experts', 'Data scientists and ML engineers', 'Static', NULL, 'johndoe', 1, '2025-11-14 14:19:42', '2025-11-14 14:19:42'),
	(3, 'Product Management', 'Product managers and product owners', 'Static', NULL, 'johndoe', 1, '2025-11-14 14:19:42', '2025-11-14 14:19:42'),
	(4, 'UX/UI Designers', 'User experience and interface designers', 'Static', NULL, 'johndoe', 1, '2025-11-14 14:19:42', '2025-11-14 14:19:42'),
	(5, 'Senior Developers', 'Experienced developers with 5+ years of experience', 'Static', NULL, 'admin', 1, '2025-11-14 18:44:01', '2025-11-14 18:44:01'),
	(6, 'Data Science Talent', 'Data scientists and ML engineers', 'Static', NULL, 'admin', 1, '2025-11-14 18:44:01', '2025-11-14 18:44:01'),
	(7, 'Frontend Specialists', 'Frontend developers and UX designers', 'Static', NULL, 'admin', 1, '2025-11-14 18:44:01', '2025-11-14 18:44:01'),
	(8, 'DevOps & Cloud', 'DevOps engineers and cloud architects', 'Static', NULL, 'admin', 1, '2025-11-14 18:44:01', '2025-11-14 18:44:01');

-- Dumping structure for table cmsadver_rmsdb.talent_pool_members
DROP TABLE IF EXISTS `talent_pool_members`;
CREATE TABLE IF NOT EXISTS `talent_pool_members` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT,
  `pool_id` int(11) NOT NULL,
  `candidate_id` int(11) NOT NULL,
  `added_by` varchar(100) DEFAULT NULL,
  `added_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`member_id`),
  KEY `idx_pool` (`pool_id`),
  KEY `idx_candidate` (`candidate_id`),
  CONSTRAINT `talent_pool_members_ibfk_1` FOREIGN KEY (`pool_id`) REFERENCES `talent_pools` (`pool_id`) ON DELETE CASCADE,
  CONSTRAINT `talent_pool_members_ibfk_2` FOREIGN KEY (`candidate_id`) REFERENCES `sourced_candidates` (`candidate_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.talent_pool_members: ~11 rows (approximately)
DELETE FROM `talent_pool_members`;
INSERT INTO `talent_pool_members` (`member_id`, `pool_id`, `candidate_id`, `added_by`, `added_at`) VALUES
	(1, 1, 1, 'johndoe', '2025-11-14 14:19:42'),
	(2, 1, 3, 'johndoe', '2025-11-14 14:19:42'),
	(3, 2, 2, 'johndoe', '2025-11-14 14:19:42'),
	(4, 3, 5, 'johndoe', '2025-11-14 14:19:42'),
	(5, 4, 4, 'johndoe', '2025-11-14 14:19:42'),
	(6, 1, 1, 'admin', '2025-11-14 18:44:01'),
	(7, 1, 7, 'admin', '2025-11-14 18:44:01'),
	(8, 2, 2, 'admin', '2025-11-14 18:44:01'),
	(9, 3, 5, 'admin', '2025-11-14 18:44:01'),
	(10, 3, 6, 'admin', '2025-11-14 18:44:01'),
	(11, 4, 3, 'admin', '2025-11-14 18:44:01');

-- Dumping structure for table cmsadver_rmsdb.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `u_id` int(15) NOT NULL AUTO_INCREMENT,
  `u_username` varchar(255) NOT NULL,
  `u_email` varchar(255) NOT NULL,
  `u_profile_picture` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `u_password` varchar(255) NOT NULL,
  `u_role` varchar(25) NOT NULL DEFAULT 'Recruiter',
  `u_status` varchar(20) DEFAULT 'Active',
  `u_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(100) DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `approved_by` varchar(100) DEFAULT NULL,
  `rejected_at` timestamp NULL DEFAULT NULL,
  `rejected_by` varchar(100) DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  PRIMARY KEY (`u_id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table cmsadver_rmsdb.users: ~26 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`u_id`, `u_username`, `u_email`, `u_profile_picture`, `profile_picture`, `u_password`, `u_role`, `u_status`, `u_created_at`, `created_at`, `created_by`, `approved_at`, `approved_by`, `rejected_at`, `rejected_by`, `rejection_reason`) VALUES
	(1, 'johndoe', 'john.doe@example.com', NULL, '4d5c702558be058030bd9a51e0f680d2.png', 'cc03e747a6afbbcbf8be7668acfebee5', 'Admin', 'Active', '2025-11-08 23:03:25', '2025-11-17 02:13:50', NULL, NULL, NULL, NULL, NULL, NULL),
	(2, 'janedoe', 'jane.doe@example.com', NULL, NULL, '$2y$10$Qsx3vLNf.wbT5Qz1L1dFxeU7ozd5LwQvJD6zCnJZXZIrsb7/fPBbm', 'Recruiter', 'Active', '2025-11-08 23:03:25', '2025-11-17 02:13:50', NULL, NULL, NULL, NULL, NULL, NULL),
	(3, 'mikebrown', 'mike.brown@example.com', NULL, NULL, '$2y$10$NL4oN3SyQH/R9TQW1fMtZuPwpIjZIufUGJrz.bsNgGJb8upjqX4b6', 'Recruiter', 'Pending', '2025-11-08 23:03:25', '2025-11-17 02:13:50', NULL, NULL, NULL, NULL, NULL, NULL),
	(4, 'sarahlee', 'dushya7@gmail.com', NULL, 'https://lh3.googleusercontent.com/a/ACg8ocIZYOlASHqgDb4c_ENSXX-g1DhHwTHOIXWvw-RMSxAO7x2csu0a=s96-c', 'fe3a4038a951dea171805fc6e056c889', 'Interviewer', 'Active', '2025-11-08 23:03:25', '2025-11-17 02:13:50', NULL, NULL, NULL, NULL, NULL, NULL),
	(5, 'davidkim', 'david.kim@example.com', NULL, NULL, '$2y$10$8NKv6XrW/WW4Eq6IxMfPJO5hhSG46ZGHULu72aSAGKlIf7J4UJbRO', 'Interviewer', 'Active', '2025-11-08 23:03:25', '2025-11-17 02:13:50', NULL, NULL, NULL, NULL, NULL, NULL),
	(14, 'ucsc', 'charakaucsc1@gmail.com', NULL, 'https://lh3.googleusercontent.com/a/ACg8ocKE-fEuECSA3QIFTdIU0ckjpByg-VYXEFxL-lclrTrdWejUh6Y=s96-c', '2f75390f5a65e6f13b6db40aa67b5542', 'Recruiter', 'Active', '2025-11-08 23:03:25', '2025-11-17 02:13:50', NULL, NULL, NULL, NULL, NULL, NULL),
	(15, 'test1', 'test1@gmail.com', NULL, NULL, '$2y$10$magMqck1Wy3Fa3m74y0QW.IpuvcQq7XgUcoK1HvjOdETcSN6vpWX6', 'Recruiter', 'Active', '2025-11-08 23:03:25', '2025-11-17 02:13:50', NULL, NULL, NULL, NULL, NULL, NULL),
	(16, 'test2', 'test2@gmail.com', NULL, NULL, '$2y$10$/OMqPI8vkSXE5.SZ9cUyOeWLdLj.3XFRZ5AaXgGpHKH9B7sHe/8Ia', 'Recruiter', 'Active', '2025-11-08 23:03:25', '2025-11-17 02:13:50', NULL, NULL, NULL, NULL, NULL, NULL),
	(17, 'test3', 'test3@gmail.com', NULL, NULL, '$2y$10$RohFblKRHzE5pYCox9Akf.zyOdIgLy446nqSCAAsNgbmSJ1t7K.GC', 'Recruiter', 'Pending', '2025-11-08 18:34:07', '2025-11-17 02:13:50', NULL, NULL, NULL, NULL, NULL, NULL),
	(18, 'charakaint', 'dushya7@gmail.com', 'uploads/profile_pictures/charakaint_1762661854.png', NULL, 'fe3a4038a951dea171805fc6e056c889', 'Candidate', 'Active', '2025-11-08 21:21:41', '2025-11-17 02:13:50', NULL, NULL, NULL, NULL, NULL, NULL),
	(19, 'charaka2', 'charakanibm1@gmail.com', NULL, 'https://lh3.googleusercontent.com/a/ACg8ocIxoIZEEM9ZjrfQxIGIoXQea-nEYzbFYH_E7pDO9hiapdbE0A=s96-c', 'fe3a4038a951dea171805fc6e056c889', 'Interviewer', 'Active', '2025-11-09 02:14:21', '2025-11-17 02:13:50', NULL, NULL, NULL, NULL, NULL, NULL),
	(20, 'johndoe', 'admin@rms.com', NULL, NULL, '0192023a7bbd73250516f069df18b500', 'Admin', 'Active', '2025-11-12 00:27:03', '2025-11-17 02:13:50', NULL, NULL, NULL, NULL, NULL, NULL),
	(21, 'sarah_rec', 'sarah@rms.com', NULL, NULL, '77f294d9e92f699797f569ff125d7c1b', 'Recruiter', 'Active', '2025-11-12 00:27:03', '2025-11-17 02:13:50', NULL, NULL, NULL, NULL, NULL, NULL),
	(22, 'mike_rec', 'mike@rms.com', NULL, NULL, '77f294d9e92f699797f569ff125d7c1b', 'Recruiter', 'Active', '2025-11-12 00:27:03', '2025-11-17 02:13:50', NULL, NULL, NULL, NULL, NULL, NULL),
	(23, 'david_int', 'david@rms.com', NULL, NULL, '7b5895a2cdedffe8ed9c5d17d7d7f775', 'Interviewer', 'Active', '2025-11-12 00:27:03', '2025-11-17 02:13:50', NULL, NULL, NULL, NULL, NULL, NULL),
	(24, 'emma_int', 'emma@rms.com', NULL, NULL, '7b5895a2cdedffe8ed9c5d17d7d7f775', 'Interviewer', 'Active', '2025-11-12 00:27:03', '2025-11-17 02:13:50', NULL, NULL, NULL, NULL, NULL, NULL),
	(25, 'johndoe', 'admin@rms.com', NULL, NULL, '0192023a7bbd73250516f069df18b500', 'Admin', 'Active', '2025-11-12 00:27:49', '2025-11-17 02:13:50', NULL, NULL, NULL, NULL, NULL, NULL),
	(26, 'sarah_rec', 'sarah@rms.com', NULL, NULL, '77f294d9e92f699797f569ff125d7c1b', 'Recruiter', 'Active', '2025-11-12 00:27:49', '2025-11-17 02:13:50', NULL, NULL, NULL, NULL, NULL, NULL),
	(27, 'mike_rec', 'mike@rms.com', NULL, NULL, '77f294d9e92f699797f569ff125d7c1b', 'Recruiter', 'Active', '2025-11-12 00:27:49', '2025-11-17 02:13:50', NULL, NULL, NULL, NULL, NULL, NULL),
	(28, 'david_int', 'david@rms.com', NULL, NULL, '7b5895a2cdedffe8ed9c5d17d7d7f775', 'Interviewer', 'Active', '2025-11-12 00:27:49', '2025-11-17 02:13:50', NULL, NULL, NULL, NULL, NULL, NULL),
	(29, 'emma_int', 'emma@rms.com', NULL, NULL, '7b5895a2cdedffe8ed9c5d17d7d7f775', 'Interviewer', 'Active', '2025-11-12 00:27:49', '2025-11-17 02:13:50', NULL, NULL, NULL, NULL, NULL, NULL),
	(30, 'charaka3', 'charaka@rms.com', NULL, NULL, 'fe3a4038a951dea171805fc6e056c889', 'Interviewer', 'Active', '2025-11-12 01:16:09', '2025-11-17 02:13:50', NULL, NULL, NULL, NULL, NULL, NULL),
	(33, 'testcandidate1', 'testcandidate1@gmail.com', NULL, NULL, 'fe3a4038a951dea171805fc6e056c889', 'Candidate', 'Active', '2025-11-12 01:24:41', '2025-11-17 02:13:50', NULL, NULL, NULL, NULL, NULL, NULL),
	(35, 'charakacreations', 'charakacreations@gmail.com', NULL, 'https://lh3.googleusercontent.com/a/ACg8ocJddEQMoxIICLzW3S6KtMsto1kcTqoc0EeJHzQlUAz1SsBEpqY=s96-c', 'caef72b317170a55fc05f15412e70a2a', 'Candidate', 'Active', '2025-11-14 06:52:42', '2025-11-17 02:13:50', NULL, NULL, NULL, NULL, NULL, NULL),
	(36, 'rasika', 'charakaucsc@gmail.com', NULL, NULL, '272c3321acd69c0113ec0a6ff3a8608c', 'Admin', 'Active', '2025-11-16 16:40:08', '2025-11-17 02:13:50', NULL, NULL, NULL, NULL, NULL, NULL),
	(37, 'Charaka', 'charakanibm@gmail.com', NULL, NULL, '5c81248257d1c13f9ca0a88bb8b94866', 'Admin', 'Active', '2025-11-17 02:18:45', '2025-11-16 21:48:45', 'self_registration', NULL, NULL, NULL, NULL, NULL);

-- Dumping structure for table cmsadver_rmsdb.whatsapp_config
DROP TABLE IF EXISTS `whatsapp_config`;
CREATE TABLE IF NOT EXISTS `whatsapp_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `provider` varchar(50) DEFAULT 'meta',
  `phone_number_id` varchar(100) NOT NULL,
  `business_account_id` varchar(100) NOT NULL,
  `access_token` varchar(500) NOT NULL,
  `api_version` varchar(20) DEFAULT 'v18.0',
  `webhook_verify_token` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table cmsadver_rmsdb.whatsapp_config: ~0 rows (approximately)
DELETE FROM `whatsapp_config`;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
