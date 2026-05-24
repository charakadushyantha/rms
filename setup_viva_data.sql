-- ============================================
-- VIVA DATA SETUP SCRIPT
-- Recruitment Management System (RMS)
-- ============================================
-- This script adds real data for viva demonstration
-- Run this in phpMyAdmin after importing add_viva_questions.sql
-- ============================================

USE cmsadver_rmsdb;

-- ============================================
-- 1. ADD REAL CANDIDATES
-- ============================================
INSERT INTO candidate_details (cd_name, cd_email, cd_phone, cd_job_title, cd_status, cd_rec_username, cd_created_at) VALUES
('Amal Perera', 'amal.perera@email.com', '+94771234567', 'Software Engineer', 'Interested', 'admin', NOW()),
('Nimal Silva', 'nimal.silva@email.com', '+94772345678', 'Data Scientist', 'Applied', 'admin', NOW()),
('Kamal Fernando', 'kamal.fernando@email.com', '+94773456789', 'Full Stack Developer', 'Interested', 'admin', NOW()),
('Sunil Jayawardena', 'sunil.j@email.com', '+94774567890', 'DevOps Engineer', 'Applied', 'admin', NOW()),
('Chamara Bandara', 'chamara.b@email.com', '+94775678901', 'UI/UX Designer', 'Interested', 'admin', NOW()),
('Dilshan Rajapaksa', 'dilshan.r@email.com', '+94776789012', 'Backend Developer', 'Applied', 'admin', NOW()),
('Tharushi Wickramasinghe', 'tharushi.w@email.com', '+94777890123', 'Frontend Developer', 'Interested', 'admin', NOW()),
('Kasun Gamage', 'kasun.g@email.com', '+94778901234', 'QA Engineer', 'Applied', 'admin', NOW());

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

-- Add interviewer profiles
INSERT INTO profile_info (pi_username, pi_phone, pi_gender)
SELECT * FROM (
    SELECT 'interviewer1' as pi_username, '+94771111111' as pi_phone, 'Male' as pi_gender
    UNION ALL
    SELECT 'interviewer2', '+94772222222', 'Female'
    UNION ALL
    SELECT 'interviewer3', '+94773333333', 'Male'
    UNION ALL
    SELECT 'hr_manager', '+94774444444', 'Female'
) AS tmp
WHERE NOT EXISTS (
    SELECT pi_username FROM profile_info WHERE pi_username = tmp.pi_username
) LIMIT 4;

-- ============================================
-- 3. SCHEDULE INTERVIEWS
-- ============================================
-- Mix of past, today, and future interviews for demonstration
INSERT INTO calendar_events (ce_can_name, ce_interviewer, ce_start_date, ce_end_date, ce_interview_round, ce_rec_username) VALUES
-- Today's interviews
('Amal Perera', 'interviewer1', DATE_ADD(NOW(), INTERVAL 2 HOUR), DATE_ADD(NOW(), INTERVAL 3 HOUR), 'Round 1', 'admin'),
('Nimal Silva', 'interviewer2', DATE_ADD(NOW(), INTERVAL 4 HOUR), DATE_ADD(NOW(), INTERVAL 5 HOUR), 'Round 1', 'admin'),

-- Tomorrow's interviews
('Kamal Fernando', 'interviewer1', DATE_ADD(NOW(), INTERVAL 1 DAY), DATE_ADD(DATE_ADD(NOW(), INTERVAL 1 DAY), INTERVAL 1 HOUR), 'Round 2', 'admin'),
('Sunil Jayawardena', 'interviewer3', DATE_ADD(DATE_ADD(NOW(), INTERVAL 1 DAY), INTERVAL 3 HOUR), DATE_ADD(DATE_ADD(NOW(), INTERVAL 1 DAY), INTERVAL 4 HOUR), 'Round 1', 'admin'),

-- Day after tomorrow
('Chamara Bandara', 'interviewer2', DATE_ADD(NOW(), INTERVAL 2 DAY), DATE_ADD(DATE_ADD(NOW(), INTERVAL 2 DAY), INTERVAL 1 HOUR), 'Technical Round', 'admin'),
('Dilshan Rajapaksa', 'hr_manager', DATE_ADD(DATE_ADD(NOW(), INTERVAL 2 DAY), INTERVAL 2 HOUR), DATE_ADD(DATE_ADD(NOW(), INTERVAL 2 DAY), INTERVAL 3 HOUR), 'HR Round', 'admin'),

-- Next week
('Tharushi Wickramasinghe', 'interviewer1', DATE_ADD(NOW(), INTERVAL 7 DAY), DATE_ADD(DATE_ADD(NOW(), INTERVAL 7 DAY), INTERVAL 1 HOUR), 'Round 1', 'admin'),
('Kasun Gamage', 'interviewer3', DATE_ADD(DATE_ADD(NOW(), INTERVAL 7 DAY), INTERVAL 3 HOUR), DATE_ADD(DATE_ADD(NOW(), INTERVAL 7 DAY), INTERVAL 4 HOUR), 'Round 1', 'admin'),

-- Past interviews (completed)
('Amal Perera', 'interviewer2', DATE_SUB(NOW(), INTERVAL 2 DAY), DATE_SUB(DATE_SUB(NOW(), INTERVAL 2 DAY), INTERVAL -1 HOUR), 'Initial Screening', 'admin'),
('Nimal Silva', 'interviewer1', DATE_SUB(NOW(), INTERVAL 3 DAY), DATE_SUB(DATE_SUB(NOW(), INTERVAL 3 DAY), INTERVAL -1 HOUR), 'Phone Screening', 'admin');

-- ============================================
-- 4. ADD JOB POSTINGS
-- ============================================
-- Note: Adjust column names based on your actual job_postings table structure
-- Common variations: jp_title/job_title, jp_description/job_description, etc.

-- First, let's check if job_postings table exists and add basic jobs
-- If this fails, you may need to adjust column names to match your table

INSERT INTO job_postings (jp_title, jp_description, jp_status, jp_posted_by, jp_created_at) VALUES
(
    'Senior Software Engineer',
    'We are looking for a talented Senior Software Engineer to join our team and work on cutting-edge projects. Requirements: BSc/MSc in Computer Science, 2+ years experience, Java/Python/JavaScript skills, microservices architecture, cloud platforms (AWS/Azure/GCP). Salary: LKR 80,000 - 120,000. Location: Colombo, Sri Lanka.',
    'Active',
    'admin',
    NOW()
),
(
    'Data Scientist',
    'Seeking an experienced Data Scientist to analyze complex data and provide actionable insights. Requirements: MSc in Data Science, Python, R, Machine Learning (TensorFlow, PyTorch), SQL, data visualization (Tableau, Power BI), 3+ years experience. Salary: LKR 100,000 - 150,000. Location: Colombo, Sri Lanka.',
    'Active',
    'admin',
    NOW()
),
(
    'UI/UX Designer',
    'Creative UI/UX Designer needed for innovative projects and user-centered design. Requirements: Portfolio required, Figma, Adobe XD, 3+ years experience, user research skills, design systems, HTML/CSS basics. Salary: LKR 70,000 - 100,000. Location: Colombo, Sri Lanka.',
    'Active',
    'admin',
    NOW()
),
(
    'DevOps Engineer',
    'Looking for a skilled DevOps Engineer to manage our infrastructure and deployment pipelines. Requirements: BSc in Computer Science, Docker, Kubernetes, CI/CD tools (Jenkins, GitLab CI), cloud platforms (AWS/Azure), scripting (Bash, Python), monitoring tools (Prometheus, Grafana), 2+ years experience. Salary: LKR 90,000 - 130,000. Location: Colombo, Sri Lanka.',
    'Active',
    'admin',
    NOW()
),
(
    'Full Stack Developer',
    'We need a versatile Full Stack Developer who can work on both frontend and backend technologies. Requirements: BSc in Computer Science, React.js, Node.js, databases (MySQL, MongoDB), RESTful API, Git, Agile/Scrum, 2+ years experience. Salary: LKR 75,000 - 110,000. Location: Colombo, Sri Lanka.',
    'Active',
    'admin',
    NOW()
);

-- ============================================
-- 5. ADD RECRUITERS (if needed)
-- ============================================
INSERT INTO users (u_username, u_email, u_password, u_role, u_status, u_created_at)
SELECT * FROM (
    SELECT 'recruiter1' as u_username, 'recruiter1@company.com' as u_email, MD5('password123') as u_password, 'Recruiter' as u_role, 'Active' as u_status, NOW() as u_created_at
    UNION ALL
    SELECT 'recruiter2', 'recruiter2@company.com', MD5('password123'), 'Recruiter', 'Active', NOW()
) AS tmp
WHERE NOT EXISTS (
    SELECT u_username FROM users WHERE u_username = tmp.u_username
) LIMIT 2;

-- Add recruiter profiles
INSERT INTO profile_info (pi_username, pi_phone, pi_gender)
SELECT * FROM (
    SELECT 'recruiter1' as pi_username, '+94775555555' as pi_phone, 'Male' as pi_gender
    UNION ALL
    SELECT 'recruiter2', '+94776666666', 'Female'
) AS tmp
WHERE NOT EXISTS (
    SELECT pi_username FROM profile_info WHERE pi_username = tmp.pi_username
) LIMIT 2;

-- ============================================
-- VERIFICATION QUERIES
-- ============================================
-- Run these to verify data was inserted correctly

-- Check candidates
SELECT COUNT(*) as total_candidates FROM candidate_details;

-- Check interviewers
SELECT COUNT(*) as total_interviewers FROM users WHERE u_role = 'Interviewer';

-- Check scheduled interviews
SELECT COUNT(*) as total_interviews FROM calendar_events;

-- Check job postings (if table exists)
-- SELECT COUNT(*) as total_jobs FROM job_postings;

-- Check questions (should be 10 if you imported add_viva_questions.sql)
-- SELECT COUNT(*) as total_questions FROM questions_bank;

-- ============================================
-- SUCCESS MESSAGE
-- ============================================
SELECT 'VIVA DATA SETUP COMPLETE!' as status,
       'All real data has been added to the system.' as message,
       'You can now demonstrate the RMS during your viva.' as note;

-- ============================================
-- NEXT STEPS
-- ============================================
-- 1. Go to: http://localhost/rms
-- 2. Login with admin credentials
-- 3. Navigate to dashboard to see real data
-- 4. Test all CRUD operations
-- 5. Clear browser cache (Ctrl+Shift+R) before viva
-- ============================================
