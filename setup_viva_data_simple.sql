-- ============================================
-- SIMPLE VIVA DATA SETUP SCRIPT
-- Recruitment Management System (RMS)
-- ============================================
-- This script adds ONLY essential data for viva
-- Candidates + Interviewers + Interviews
-- ============================================

USE cmsadver_rmsdb;

-- ============================================
-- 1. ADD REAL CANDIDATES
-- ============================================
INSERT INTO candidate_details (cd_name, cd_email, cd_phone, cd_job_title, cd_status, cd_rec_username, cd_gender, cd_source, cd_description, cd_created_at) VALUES
('Amal Perera', 'amal.perera@email.com', '+94771234567', 'Software Engineer', 'Interested', 'admin', 'Male', 'Direct Application', 'Experienced software engineer with strong Java and Python skills', NOW()),
('Nimal Silva', 'nimal.silva@email.com', '+94772345678', 'Data Scientist', 'Applied', 'admin', 'Male', 'Job Portal', 'Data scientist with expertise in machine learning and analytics', NOW()),
('Kamal Fernando', 'kamal.fernando@email.com', '+94773456789', 'Full Stack Developer', 'Interested', 'admin', 'Male', 'Referral', 'Full stack developer proficient in React and Node.js', NOW()),
('Sunil Jayawardena', 'sunil.j@email.com', '+94774567890', 'DevOps Engineer', 'Applied', 'admin', 'Male', 'LinkedIn', 'DevOps engineer with Docker and Kubernetes experience', NOW()),
('Chamara Bandara', 'chamara.b@email.com', '+94775678901', 'UI/UX Designer', 'Interested', 'admin', 'Male', 'Direct Application', 'Creative UI/UX designer with strong portfolio', NOW()),
('Dilshan Rajapaksa', 'dilshan.r@email.com', '+94776789012', 'Backend Developer', 'Applied', 'admin', 'Male', 'Job Portal', 'Backend developer specializing in microservices', NOW()),
('Tharushi Wickramasinghe', 'tharushi.w@email.com', '+94777890123', 'Frontend Developer', 'Interested', 'admin', 'Female', 'Referral', 'Frontend developer with React and Vue.js expertise', NOW()),
('Kasun Gamage', 'kasun.g@email.com', '+94778901234', 'QA Engineer', 'Applied', 'admin', 'Male', 'LinkedIn', 'QA engineer with automation testing experience', NOW());

-- ============================================
-- 2. ADD INTERVIEWERS
-- ============================================
-- Check if interviewers already exist before inserting
INSERT INTO users (u_username, u_email, u_password, u_role, u_status, u_created_at)
SELECT * FROM (
    SELECT 'interviewer1' as u_username, 'interviewer1@company.com' as u_email, MD5('password123') as u_password, 'Interviewer' as u_role, 'Active' as u_status, NOW() as u_created_at
    UNION ALL
    SELECT 'interviewer2', 'interviewer2@company.com', MD5('password123'), 'Interviewer', 'Active', NOW()
    UNION ALL
    SELECT 'interviewer3', 'interviewer3@company.com', MD5('password123'), 'Interviewer', 'Active', NOW()
    UNION ALL
    SELECT 'hr_manager', 'hr.manager@company.com', MD5('password123'), 'Interviewer', 'Active', NOW()
) AS tmp
WHERE NOT EXISTS (
    SELECT u_username FROM users WHERE u_username = tmp.u_username
) LIMIT 4;

-- ============================================
-- 3. SCHEDULE INTERVIEWS
-- ============================================
-- Note: ce_interview_round expects a number (0, 0.25, 0.5, 0.75, 1)
-- 0 = Not Started, 0.25 = Round 1, 0.5 = Round 2, 0.75 = Round 3, 1 = Completed

INSERT INTO calendar_events (ce_can_name, ce_interviewer, ce_start_date, ce_end_date, ce_interview_round, ce_rec_username) VALUES
-- Today's interviews
('Amal Perera', 'interviewer1', DATE_ADD(NOW(), INTERVAL 2 HOUR), DATE_ADD(NOW(), INTERVAL 3 HOUR), 0.25, 'admin'),
('Nimal Silva', 'interviewer2', DATE_ADD(NOW(), INTERVAL 4 HOUR), DATE_ADD(NOW(), INTERVAL 5 HOUR), 0.25, 'admin'),

-- Tomorrow's interviews
('Kamal Fernando', 'interviewer1', DATE_ADD(NOW(), INTERVAL 1 DAY), DATE_ADD(DATE_ADD(NOW(), INTERVAL 1 DAY), INTERVAL 1 HOUR), 0.5, 'admin'),
('Sunil Jayawardena', 'interviewer3', DATE_ADD(DATE_ADD(NOW(), INTERVAL 1 DAY), INTERVAL 3 HOUR), DATE_ADD(DATE_ADD(NOW(), INTERVAL 1 DAY), INTERVAL 4 HOUR), 0.25, 'admin'),

-- Day after tomorrow
('Chamara Bandara', 'interviewer2', DATE_ADD(NOW(), INTERVAL 2 DAY), DATE_ADD(DATE_ADD(NOW(), INTERVAL 2 DAY), INTERVAL 1 HOUR), 0.75, 'admin'),
('Dilshan Rajapaksa', 'hr_manager', DATE_ADD(DATE_ADD(NOW(), INTERVAL 2 DAY), INTERVAL 2 HOUR), DATE_ADD(DATE_ADD(NOW(), INTERVAL 2 DAY), INTERVAL 3 HOUR), 0.75, 'admin'),

-- Next week
('Tharushi Wickramasinghe', 'interviewer1', DATE_ADD(NOW(), INTERVAL 7 DAY), DATE_ADD(DATE_ADD(NOW(), INTERVAL 7 DAY), INTERVAL 1 HOUR), 0.25, 'admin'),
('Kasun Gamage', 'interviewer3', DATE_ADD(DATE_ADD(NOW(), INTERVAL 7 DAY), INTERVAL 3 HOUR), DATE_ADD(DATE_ADD(NOW(), INTERVAL 7 DAY), INTERVAL 4 HOUR), 0.25, 'admin'),

-- Past interviews (completed)
('Amal Perera', 'interviewer2', DATE_SUB(NOW(), INTERVAL 2 DAY), DATE_SUB(DATE_SUB(NOW(), INTERVAL 2 DAY), INTERVAL -1 HOUR), 0.25, 'admin'),
('Nimal Silva', 'interviewer1', DATE_SUB(NOW(), INTERVAL 3 DAY), DATE_SUB(DATE_SUB(NOW(), INTERVAL 3 DAY), INTERVAL -1 HOUR), 0.25, 'admin');

-- ============================================
-- VERIFICATION QUERIES
-- ============================================
SELECT 'DATA IMPORT COMPLETE!' as status;

SELECT COUNT(*) as total_candidates FROM candidate_details;
SELECT COUNT(*) as total_interviewers FROM users WHERE u_role = 'Interviewer';
SELECT COUNT(*) as total_interviews FROM calendar_events;

-- ============================================
-- SUCCESS!
-- ============================================
-- Now go to: http://localhost/rms
-- Login and check the dashboard
-- ============================================
