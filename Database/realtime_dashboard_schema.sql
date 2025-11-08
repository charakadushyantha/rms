-- Real-Time Collaborative Hiring Dashboard Schema

-- Candidate pipeline stages
CREATE TABLE IF NOT EXISTS `pipeline_stages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `order_position` int(11) NOT NULL,
  `color` varchar(20) DEFAULT '#007bff',
  `description` text,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default pipeline stages
INSERT INTO `pipeline_stages` (`name`, `order_position`, `color`, `description`) VALUES
('Applied', 1, '#6c757d', 'Initial application received'),
('Screening', 2, '#17a2b8', 'Resume screening in progress'),
('Phone Interview', 3, '#ffc107', 'Phone screening scheduled'),
('Technical Interview', 4, '#fd7e14', 'Technical assessment'),
('Final Interview', 5, '#007bff', 'Final round with management'),
('Offer', 6, '#28a745', 'Offer extended'),
('Hired', 7, '#20c997', 'Candidate accepted offer'),
('Rejected', 8, '#dc3545', 'Not moving forward');

-- Candidate pipeline tracking
CREATE TABLE IF NOT EXISTS `candidate_pipeline` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_id` int(11) NOT NULL,
  `stage_id` int(11) NOT NULL,
  `moved_by` int(11) DEFAULT NULL,
  `moved_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `notes` text,
  `urgency_level` enum('low','medium','high','critical') DEFAULT 'medium',
  `days_in_stage` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `candidate_id` (`candidate_id`),
  KEY `stage_id` (`stage_id`),
  KEY `moved_by` (`moved_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Collaborative decisions/voting
CREATE TABLE IF NOT EXISTS `hiring_decisions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_id` int(11) NOT NULL,
  `decision_type` enum('move_forward','reject','hold','offer') NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deadline` datetime DEFAULT NULL,
  `status` enum('open','closed') DEFAULT 'open',
  `final_decision` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `candidate_id` (`candidate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Voting on candidates
CREATE TABLE IF NOT EXISTS `decision_votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `decision_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `vote` enum('yes','no','abstain') NOT NULL,
  `comment` text,
  `is_anonymous` tinyint(1) DEFAULT 0,
  `voted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `decision_id` (`decision_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Interview panel assignments
CREATE TABLE IF NOT EXISTS `interview_panels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_id` int(11) NOT NULL,
  `interviewer_id` int(11) NOT NULL,
  `interview_date` datetime NOT NULL,
  `duration_minutes` int(11) DEFAULT 60,
  `interview_type` varchar(50) DEFAULT 'technical',
  `status` enum('scheduled','completed','cancelled','rescheduled') DEFAULT 'scheduled',
  `feedback_submitted` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `candidate_id` (`candidate_id`),
  KEY `interviewer_id` (`interviewer_id`),
  KEY `interview_date` (`interview_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Interviewer availability
CREATE TABLE IF NOT EXISTS `interviewer_availability` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `is_available` tinyint(1) DEFAULT 1,
  `max_interviews` int(11) DEFAULT 3,
  `current_interviews` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Real-time activity log
CREATE TABLE IF NOT EXISTS `pipeline_activity_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action_type` varchar(50) NOT NULL,
  `action_data` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `candidate_id` (`candidate_id`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dashboard metrics cache
CREATE TABLE IF NOT EXISTS `dashboard_metrics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `metric_name` varchar(100) NOT NULL,
  `metric_value` decimal(10,2) NOT NULL,
  `metric_data` text,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `metric_name` (`metric_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
