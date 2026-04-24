-- Create Database
CREATE DATABASE IF NOT EXISTS `rmsdb` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `rmsdb`;

-- Set session parameters
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------
-- Table structure for table `calendar_events`
-- --------------------------------------------------------
CREATE TABLE `calendar_events` (
  `ce_id` int(11) NOT NULL AUTO_INCREMENT,
  `ce_rec_username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ce_can_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ce_interviewer` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ce_start_date` datetime NOT NULL,
  `ce_end_date` datetime NOT NULL,
  `ce_interview_round` double NOT NULL DEFAULT 0,
  PRIMARY KEY (`ce_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `candidate_details`
-- --------------------------------------------------------
CREATE TABLE `candidate_details` (
  `cd_id` int(15) NOT NULL AUTO_INCREMENT,
  `cd_rec_username` varchar(255) NOT NULL,
  `cd_name` varchar(255) NOT NULL,
  `cd_email` varchar(255) NOT NULL,
  `cd_phone` BIGINT NOT NULL,
  `cd_gender` varchar(25) NOT NULL,
  `cd_job_title` varchar(25) NOT NULL,
  `cd_source` varchar(255) NOT NULL,
  `cd_description` varchar(1000) NOT NULL,
  `cd_resume_link` varchar(255) DEFAULT NULL,
  `cd_status` varchar(255) NOT NULL,
  `cd_interview_status` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`cd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
-- Table structure for table `ci_sessions`
-- --------------------------------------------------------
CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
-- Table structure for table `profile_info`
-- --------------------------------------------------------
CREATE TABLE `profile_info` (
  `pi_id` int(20) NOT NULL AUTO_INCREMENT,
  `pi_username` varchar(255) NOT NULL,
  `pi_name` varchar(255) NOT NULL,
  `pi_email` varchar(255) NOT NULL,
  `pi_phone` varchar(20) NOT NULL,
  `pi_gender` varchar(255) NOT NULL,
  `pi_jobtitle` varchar(255) NOT NULL DEFAULT 'Admin',
  `pi_role` varchar(255) NOT NULL,
  PRIMARY KEY (`pi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
-- Table structure for table `users`
-- --------------------------------------------------------
CREATE TABLE `users` (
  `u_id` int(15) NOT NULL AUTO_INCREMENT,
  `u_username` varchar(255) NOT NULL,
  `u_email` varchar(255) NOT NULL,
  `u_password` varchar(255) NOT NULL,
  `u_role` varchar(25) NOT NULL DEFAULT 'Recruiter',
  `u_status` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`u_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
-- Sample data for users table
-- --------------------------------------------------------
INSERT INTO `users` (`u_username`, `u_email`, `u_password`, `u_role`, `u_status`) VALUES
('johndoe', 'john.doe@example.com', '$2y$10$GqBm5xzEPhE7qBP1zL3H8etVfz0wDfZkl5ULsafkFX9D36QFNQu.u', 'Admin', 1),
('janedoe', 'jane.doe@example.com', '$2y$10$Qsx3vLNf.wbT5Qz1L1dFxeU7ozd5LwQvJD6zCnJZXZIrsb7/fPBbm', 'Recruiter', 1),
('mikebrown', 'mike.brown@example.com', '$2y$10$NL4oN3SyQH/R9TQW1fMtZuPwpIjZIufUGJrz.bsNgGJb8upjqX4b6', 'Recruiter', 1),
('sarahlee', 'sarah.lee@example.com', '$2y$10$YoZfQaXlHGiCJJEr9rM1Du5Upt.LZDUw5dZuq5lJ/B5LY1YFmxYCS', 'Interviewer', 1),
('davidkim', 'david.kim@example.com', '$2y$10$8NKv6XrW/WW4Eq6IxMfPJO5hhSG46ZGHULu72aSAGKlIf7J4UJbRO', 'Interviewer', 1);

-- --------------------------------------------------------
-- Sample data for profile_info table
-- --------------------------------------------------------
INSERT INTO `profile_info` (`pi_username`, `pi_name`, `pi_email`, `pi_phone`, `pi_gender`, `pi_jobtitle`, `pi_role`) VALUES
('johndoe', 'John Doe', 'john.doe@example.com', '1234567890', 'Male', 'HR Manager', 'Admin'),
('janedoe', 'Jane Doe', 'jane.doe@example.com', '9876543210', 'Female', 'Senior Recruiter', 'Recruiter'),
('mikebrown', 'Mike Brown', 'mike.brown@example.com', '5556667777', 'Male', 'Talent Acquisition', 'Recruiter'),
('sarahlee', 'Sarah Lee', 'sarah.lee@example.com', '1112223333', 'Female', 'Tech Lead', 'Interviewer'),
('davidkim', 'David Kim', 'david.kim@example.com', '4445556666', 'Male', 'Engineering Manager', 'Interviewer');

-- --------------------------------------------------------
-- Sample data for candidate_details table
-- --------------------------------------------------------
INSERT INTO `candidate_details` (`cd_rec_username`, `cd_name`, `cd_email`, `cd_phone`, `cd_gender`, `cd_job_title`, `cd_source`, `cd_description`, `cd_resume_link`, `cd_status`, `cd_interview_status`) VALUES
('janedoe', 'Alex Johnson', 'alex.johnson@email.com', 9871234560, 'Male', 'Software Developer', 'LinkedIn', 'Experienced Java developer with 5 years of experience in backend development. Skilled in Spring Boot and microservices architecture.', 'resumes/alex_johnson_resume.pdf', 'Shortlisted', 1),
('janedoe', 'Emily Parker', 'emily.parker@email.com', 8765432109, 'Female', 'UI/UX Designer', 'Indeed', 'Creative UI/UX designer with strong portfolio. Proficient in Figma, Adobe XD, and user research methodologies.', 'resumes/emily_parker_resume.pdf', 'In Review', 0),
('mikebrown', 'Robert Chen', 'robert.chen@email.com', 7654321098, 'Male', 'Data Scientist', 'Referral', 'PhD in Statistics with expertise in machine learning algorithms, NLP, and data visualization. Experience with Python, R, and TensorFlow.', 'resumes/robert_chen_resume.pdf', 'Shortlisted', 1),
('mikebrown', 'Sophia Rodriguez', 'sophia.rodriguez@email.com', 6549873210, 'Female', 'Product Manager', 'Company Website', 'Product manager with 7 years of experience in agile environments. Strong background in market research and product development lifecycle.', 'resumes/sophia_rodriguez_resume.pdf', 'Selected', 2),
('janedoe', 'Michael Wilson', 'michael.wilson@email.com', 8907654321, 'Male', 'DevOps Engineer', 'Stack Overflow', 'DevOps engineer with expertise in CI/CD pipelines, Docker, Kubernetes, and AWS infrastructure. Strong automation skills.', 'resumes/michael_wilson_resume.pdf', 'In Review', 0);

-- --------------------------------------------------------
-- Sample data for calendar_events table
-- --------------------------------------------------------
INSERT INTO `calendar_events` (`ce_rec_username`, `ce_can_name`, `ce_interviewer`, `ce_start_date`, `ce_end_date`, `ce_interview_round`) VALUES
('janedoe', 'Alex Johnson', 'sarahlee', '2025-03-23 10:00:00', '2025-03-23 11:00:00', 1),
('janedoe', 'Alex Johnson', 'davidkim', '2025-03-25 14:00:00', '2025-03-25 15:00:00', 2),
('mikebrown', 'Robert Chen', 'davidkim', '2025-03-22 11:00:00', '2025-03-22 12:30:00', 1),
('mikebrown', 'Sophia Rodriguez', 'sarahlee', '2025-03-24 09:00:00', '2025-03-24 10:00:00', 1),
('mikebrown', 'Sophia Rodriguez', 'davidkim', '2025-03-26 15:30:00', '2025-03-26 16:30:00', 2);

-- --------------------------------------------------------
-- Sample data for ci_sessions table
-- --------------------------------------------------------
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('fac8e5f65cd5f94d44b876dd3e699d883ca9fe37', '192.168.1.101', UNIX_TIMESTAMP(NOW() - INTERVAL 2 HOUR), 0x7b22757365726e616d65223a226a6f686e646f65222c226c6f67676564696e223a747275657d),
('a9ce8f342e9d7c5a1b3824c76e98f6a37f4b03e9', '192.168.1.102', UNIX_TIMESTAMP(NOW() - INTERVAL 1 HOUR), 0x7b22757365726e616d65223a226a616e65646f65222c226c6f67676564696e223a747275657d),
('b2d15e4c6c7a8f9d3b1e2a5c4d7e8f9a2b3c4d5e', '192.168.1.103', UNIX_TIMESTAMP(NOW() - INTERVAL 30 MINUTE), 0x7b22757365726e616d65223a226d696b6562726f776e222c226c6f67676564696e223a747275657d);

COMMIT;