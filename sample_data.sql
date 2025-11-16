-- Sample Data for RMS Application Testing (100+ Candidates)
-- Run this script to populate the database with test data

-- ============================================
-- 1. USERS (Admin, Recruiters, Interviewers, Candidates)
-- ============================================

-- Admin user (password: admin123)
INSERT INTO `users` (`u_username`, `u_password`, `u_email`, `u_role`, `profile_picture`) VALUES
('johndoe', MD5('admin123'), 'admin@rms.com', 'Admin', NULL);

-- Recruiter users (password: recruiter123)
INSERT INTO `users` (`u_username`, `u_password`, `u_email`, `u_role`, `profile_picture`) VALUES
('sarah_rec', MD5('recruiter123'), 'sarah@rms.com', 'Recruiter', NULL),
('mike_rec', MD5('recruiter123'), 'mike@rms.com', 'Recruiter', NULL);

-- Interviewer users (password: interviewer123)
INSERT INTO `users` (`u_username`, `u_password`, `u_email`, `u_role`, `profile_picture`) VALUES
('david_int', MD5('interviewer123'), 'david@rms.com', 'Interviewer', NULL),
('emma_int', MD5('interviewer123'), 'emma@rms.com', 'Interviewer', NULL);

-- ============================================
-- 2. ADD CREATED_AT COLUMN IF NOT EXISTS
-- ============================================
ALTER TABLE `candidate_details` 
ADD COLUMN IF NOT EXISTS `cd_created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP AFTER `cd_interview_status`;

-- ============================================
-- 3. CANDIDATE DETAILS (120 Total Candidates)
-- ============================================

-- Selected Candidates (15) - Mix of dates (some today, some this week, some this month)
INSERT INTO `candidate_details` (`cd_rec_username`, `cd_name`, `cd_email`, `cd_phone`, `cd_gender`, `cd_job_title`, `cd_source`, `cd_description`, `cd_status`, `cd_interview_status`, `cd_created_at`) VALUES
('sarah_rec', 'Alex Johnson', 'alex.johnson@email.com', '555-0101', 'Male', 'Senior Software Engineer', 'LinkedIn', 'Excellent full-stack developer', 'Selected', 1, NOW()),
('sarah_rec', 'Robert Chen', 'robert.chen@email.com', '555-0102', 'Male', 'DevOps Engineer', 'Indeed', 'Strong cloud infrastructure background', 'Selected', 1, NOW()),
('mike_rec', 'Sophia Rodriguez', 'sophia.r@email.com', '555-0103', 'Female', 'Frontend Developer', 'Referral', 'Creative UI/UX developer', 'Selected', 1, DATE_SUB(NOW(), INTERVAL 1 DAY)),
('sarah_rec', 'Emily Watson', 'emily.watson@email.com', '555-0104', 'Female', 'Backend Developer', 'Company Website', 'Strong Python and Node.js skills', 'Selected', 1, DATE_SUB(NOW(), INTERVAL 2 DAY)),
('mike_rec', 'James Miller', 'james.miller@email.com', '555-0105', 'Male', 'Full Stack Developer', 'Job Portal', 'MERN stack specialist', 'Selected', 1, DATE_SUB(NOW(), INTERVAL 3 DAY)),
('sarah_rec', 'Maria Garcia', 'maria.garcia@email.com', '555-0106', 'Female', 'QA Engineer', 'LinkedIn', 'Automation testing expert', 'Selected', 1, DATE_SUB(NOW(), INTERVAL 5 DAY)),
('mike_rec', 'David Kim', 'david.kim@email.com', '555-0107', 'Male', 'Data Analyst', 'Indeed', 'SQL and Python analytics', 'Selected', 1, DATE_SUB(NOW(), INTERVAL 7 DAY)),
('sarah_rec', 'Lisa Anderson', 'lisa.anderson@email.com', '555-0108', 'Female', 'Product Manager', 'Referral', 'Agile methodology expert', 'Selected', 1, DATE_SUB(NOW(), INTERVAL 10 DAY)),
('mike_rec', 'Michael Brown', 'michael.brown@email.com', '555-0109', 'Male', 'UI/UX Designer', 'Company Website', 'Award-winning designer', 'Selected', 1, DATE_SUB(NOW(), INTERVAL 12 DAY)),
('sarah_rec', 'Jennifer Lee', 'jennifer.lee@email.com', '555-0110', 'Female', 'Mobile Developer', 'LinkedIn', 'iOS and Android expert', 'Selected', 1, DATE_SUB(NOW(), INTERVAL 15 DAY)),
('mike_rec', 'Thomas Wilson', 'thomas.wilson@email.com', '555-0111', 'Male', 'Security Engineer', 'Job Portal', 'Cybersecurity certified', 'Selected', 1, DATE_SUB(NOW(), INTERVAL 18 DAY)),
('sarah_rec', 'Amanda Taylor', 'amanda.taylor@email.com', '555-0112', 'Female', 'Business Analyst', 'Indeed', 'Strong communication skills', 'Selected', 1, DATE_SUB(NOW(), INTERVAL 20 DAY)),
('mike_rec', 'Christopher Davis', 'chris.davis@email.com', '555-0113', 'Male', 'Cloud Architect', 'LinkedIn', 'AWS and Azure certified', 'Selected', 1, DATE_SUB(NOW(), INTERVAL 22 DAY)),
('sarah_rec', 'Jessica Martinez', 'jessica.m@email.com', '555-0114', 'Female', 'Data Scientist', 'Referral', 'ML and AI specialist', 'Selected', 1, DATE_SUB(NOW(), INTERVAL 25 DAY)),
('mike_rec', 'Daniel White', 'daniel.white@email.com', '555-0115', 'Male', 'Tech Lead', 'Company Website', 'Team leadership experience', 'Selected', 1, DATE_SUB(NOW(), INTERVAL 28 DAY));

-- In Progress Candidates (25)
INSERT INTO `candidate_details` (`cd_rec_username`, `cd_name`, `cd_email`, `cd_phone`, `cd_gender`, `cd_job_title`, `cd_source`, `cd_description`, `cd_status`, `cd_interview_status`) VALUES
('sarah_rec', 'Matthew Harris', 'matthew.h@email.com', '555-0116', 'Male', 'Software Engineer', 'LinkedIn', 'Second round interview scheduled', 'In Process', 1),
('mike_rec', 'Sarah Thompson', 'sarah.t@email.com', '555-0117', 'Female', 'Frontend Developer', 'Indeed', 'Technical assessment completed', 'In Process', 1),
('sarah_rec', 'Kevin Moore', 'kevin.moore@email.com', '555-0118', 'Male', 'Backend Developer', 'Job Portal', 'Coding challenge passed', 'In Process', 1),
('mike_rec', 'Rachel Green', 'rachel.green@email.com', '555-0119', 'Female', 'QA Automation', 'Referral', 'First interview completed', 'In Process', 1),
('sarah_rec', 'Brian Clark', 'brian.clark@email.com', '555-0120', 'Male', 'DevOps Engineer', 'LinkedIn', 'Technical round in progress', 'In Process', 1),
('mike_rec', 'Nicole Adams', 'nicole.adams@email.com', '555-0121', 'Female', 'Product Designer', 'Company Website', 'Portfolio review completed', 'In Process', 1),
('sarah_rec', 'Justin Baker', 'justin.baker@email.com', '555-0122', 'Male', 'Data Engineer', 'Indeed', 'SQL test passed', 'In Process', 1),
('mike_rec', 'Melissa Scott', 'melissa.scott@email.com', '555-0123', 'Female', 'Scrum Master', 'Referral', 'HR interview done', 'In Process', 1),
('sarah_rec', 'Ryan Phillips', 'ryan.phillips@email.com', '555-0124', 'Male', 'Mobile Developer', 'LinkedIn', 'App demo scheduled', 'In Process', 1),
('mike_rec', 'Laura Mitchell', 'laura.mitchell@email.com', '555-0125', 'Female', 'Business Analyst', 'Job Portal', 'Case study submitted', 'In Process', 1),
('sarah_rec', 'Eric Turner', 'eric.turner@email.com', '555-0126', 'Male', 'Full Stack Developer', 'Indeed', 'Final round pending', 'In Process', 1),
('mike_rec', 'Stephanie Hill', 'stephanie.hill@email.com', '555-0127', 'Female', 'UI Designer', 'Company Website', 'Design challenge completed', 'In Process', 1),
('sarah_rec', 'Brandon Lewis', 'brandon.lewis@email.com', '555-0128', 'Male', 'Security Analyst', 'LinkedIn', 'Security assessment done', 'In Process', 1),
('mike_rec', 'Christina Young', 'christina.young@email.com', '555-0129', 'Female', 'Project Manager', 'Referral', 'Management interview scheduled', 'In Process', 1),
('sarah_rec', 'Gregory King', 'gregory.king@email.com', '555-0130', 'Male', 'Cloud Engineer', 'Indeed', 'AWS certification verified', 'In Process', 1),
('mike_rec', 'Samantha Wright', 'samantha.wright@email.com', '555-0131', 'Female', 'Data Analyst', 'Job Portal', 'Analytics test completed', 'In Process', 1),
('sarah_rec', 'Patrick Lopez', 'patrick.lopez@email.com', '555-0132', 'Male', 'Software Architect', 'LinkedIn', 'Architecture review pending', 'In Process', 1),
('mike_rec', 'Angela Hall', 'angela.hall@email.com', '555-0133', 'Female', 'QA Lead', 'Company Website', 'Leadership assessment done', 'In Process', 1),
('sarah_rec', 'Timothy Allen', 'timothy.allen@email.com', '555-0134', 'Male', 'Backend Engineer', 'Referral', 'System design interview scheduled', 'In Process', 1),
('mike_rec', 'Rebecca Nelson', 'rebecca.nelson@email.com', '555-0135', 'Female', 'Frontend Engineer', 'Indeed', 'React assessment passed', 'In Process', 1),
('sarah_rec', 'Kenneth Carter', 'kenneth.carter@email.com', '555-0136', 'Male', 'DevOps Lead', 'LinkedIn', 'CI/CD knowledge verified', 'In Process', 1),
('mike_rec', 'Michelle Perez', 'michelle.perez@email.com', '555-0137', 'Female', 'UX Researcher', 'Job Portal', 'Research presentation done', 'In Process', 1),
('sarah_rec', 'Steven Roberts', 'steven.roberts@email.com', '555-0138', 'Male', 'Machine Learning Engineer', 'Referral', 'ML model review pending', 'In Process', 1),
('mike_rec', 'Kimberly Edwards', 'kimberly.edwards@email.com', '555-0139', 'Female', 'Technical Writer', 'Company Website', 'Writing sample submitted', 'In Process', 1),
('sarah_rec', 'Jason Collins', 'jason.collins@email.com', '555-0140', 'Male', 'Site Reliability Engineer', 'LinkedIn', 'SRE assessment completed', 'In Process', 1);

-- Shortlisted Candidates (40)
INSERT INTO `candidate_details` (`cd_rec_username`, `cd_name`, `cd_email`, `cd_phone`, `cd_gender`, `cd_job_title`, `cd_source`, `cd_description`, `cd_status`, `cd_interview_status`) VALUES
('sarah_rec', 'Andrew Stewart', 'andrew.stewart@email.com', '555-0141', 'Male', 'Software Developer', 'Indeed', 'Strong coding skills', 'Shortlisted', 0),
('mike_rec', 'Brittany Morris', 'brittany.morris@email.com', '555-0142', 'Female', 'Frontend Developer', 'LinkedIn', 'React and Vue experience', 'Shortlisted', 0),
('sarah_rec', 'Joshua Rogers', 'joshua.rogers@email.com', '555-0143', 'Male', 'Backend Developer', 'Job Portal', 'Node.js specialist', 'Shortlisted', 0),
('mike_rec', 'Megan Reed', 'megan.reed@email.com', '555-0144', 'Female', 'QA Engineer', 'Referral', 'Manual and automation testing', 'Shortlisted', 0),
('sarah_rec', 'Nathan Cook', 'nathan.cook@email.com', '555-0145', 'Male', 'DevOps Engineer', 'Company Website', 'Docker and Kubernetes', 'Shortlisted', 0),
('mike_rec', 'Heather Morgan', 'heather.morgan@email.com', '555-0146', 'Female', 'Product Manager', 'LinkedIn', 'Product strategy experience', 'Shortlisted', 0),
('sarah_rec', 'Aaron Bell', 'aaron.bell@email.com', '555-0147', 'Male', 'Data Scientist', 'Indeed', 'Python and R programming', 'Shortlisted', 0),
('mike_rec', 'Danielle Murphy', 'danielle.murphy@email.com', '555-0148', 'Female', 'UI/UX Designer', 'Job Portal', 'Figma and Adobe XD', 'Shortlisted', 0),
('sarah_rec', 'Jeremy Bailey', 'jeremy.bailey@email.com', '555-0149', 'Male', 'Mobile Developer', 'Referral', 'Flutter and React Native', 'Shortlisted', 0),
('mike_rec', 'Katherine Rivera', 'katherine.rivera@email.com', '555-0150', 'Female', 'Business Analyst', 'Company Website', 'Requirements gathering', 'Shortlisted', 0),
('sarah_rec', 'Tyler Cooper', 'tyler.cooper@email.com', '555-0151', 'Male', 'Full Stack Developer', 'LinkedIn', 'MEAN stack developer', 'Shortlisted', 0),
('mike_rec', 'Amber Richardson', 'amber.richardson@email.com', '555-0152', 'Female', 'Scrum Master', 'Indeed', 'Agile certified', 'Shortlisted', 0),
('sarah_rec', 'Jordan Cox', 'jordan.cox@email.com', '555-0153', 'Male', 'Cloud Engineer', 'Job Portal', 'Azure specialist', 'Shortlisted', 0),
('mike_rec', 'Crystal Howard', 'crystal.howard@email.com', '555-0154', 'Female', 'Data Analyst', 'Referral', 'Tableau and Power BI', 'Shortlisted', 0),
('sarah_rec', 'Austin Ward', 'austin.ward@email.com', '555-0155', 'Male', 'Security Engineer', 'LinkedIn', 'Penetration testing', 'Shortlisted', 0),
('mike_rec', 'Courtney Torres', 'courtney.torres@email.com', '555-0156', 'Female', 'Technical Lead', 'Company Website', 'Team management', 'Shortlisted', 0),
('sarah_rec', 'Marcus Peterson', 'marcus.peterson@email.com', '555-0157', 'Male', 'Software Engineer', 'Indeed', 'Java and Spring Boot', 'Shortlisted', 0),
('mike_rec', 'Vanessa Gray', 'vanessa.gray@email.com', '555-0158', 'Female', 'Frontend Developer', 'Job Portal', 'Angular specialist', 'Shortlisted', 0),
('sarah_rec', 'Carl Ramirez', 'carl.ramirez@email.com', '555-0159', 'Male', 'Backend Developer', 'Referral', 'Django and Flask', 'Shortlisted', 0),
('mike_rec', 'Tiffany James', 'tiffany.james@email.com', '555-0160', 'Female', 'QA Automation', 'LinkedIn', 'Selenium and Cypress', 'Shortlisted', 0),
('sarah_rec', 'Victor Watson', 'victor.watson@email.com', '555-0161', 'Male', 'DevOps Engineer', 'Company Website', 'Jenkins and GitLab CI', 'Shortlisted', 0),
('mike_rec', 'Monica Brooks', 'monica.brooks@email.com', '555-0162', 'Female', 'Product Designer', 'Indeed', 'User research expert', 'Shortlisted', 0),
('sarah_rec', 'Keith Kelly', 'keith.kelly@email.com', '555-0163', 'Male', 'Data Engineer', 'Job Portal', 'ETL and data pipelines', 'Shortlisted', 0),
('mike_rec', 'Jacqueline Sanders', 'jacqueline.sanders@email.com', '555-0164', 'Female', 'Project Manager', 'Referral', 'PMP certified', 'Shortlisted', 0),
('sarah_rec', 'Sean Price', 'sean.price@email.com', '555-0165', 'Male', 'Mobile Developer', 'LinkedIn', 'Swift and Kotlin', 'Shortlisted', 0),
('mike_rec', 'Denise Bennett', 'denise.bennett@email.com', '555-0166', 'Female', 'Business Analyst', 'Company Website', 'Process improvement', 'Shortlisted', 0),
('sarah_rec', 'Craig Wood', 'craig.wood@email.com', '555-0167', 'Male', 'Full Stack Developer', 'Indeed', 'PHP and Laravel', 'Shortlisted', 0),
('mike_rec', 'Cheryl Barnes', 'cheryl.barnes@email.com', '555-0168', 'Female', 'UI Designer', 'Job Portal', 'Responsive design', 'Shortlisted', 0),
('sarah_rec', 'Philip Ross', 'philip.ross@email.com', '555-0169', 'Male', 'Security Analyst', 'Referral', 'CISSP certified', 'Shortlisted', 0),
('mike_rec', 'Janet Henderson', 'janet.henderson@email.com', '555-0170', 'Female', 'Scrum Master', 'LinkedIn', 'SAFe certified', 'Shortlisted', 0),
('sarah_rec', 'Douglas Coleman', 'douglas.coleman@email.com', '555-0171', 'Male', 'Cloud Architect', 'Company Website', 'Multi-cloud experience', 'Shortlisted', 0),
('mike_rec', 'Teresa Jenkins', 'teresa.jenkins@email.com', '555-0172', 'Female', 'Data Analyst', 'Indeed', 'Statistical analysis', 'Shortlisted', 0),
('sarah_rec', 'Peter Perry', 'peter.perry@email.com', '555-0173', 'Male', 'Software Architect', 'Job Portal', 'Microservices design', 'Shortlisted', 0),
('mike_rec', 'Frances Powell', 'frances.powell@email.com', '555-0174', 'Female', 'QA Lead', 'Referral', 'Test strategy planning', 'Shortlisted', 0),
('sarah_rec', 'Harold Long', 'harold.long@email.com', '555-0175', 'Male', 'Backend Engineer', 'LinkedIn', 'Go and Rust', 'Shortlisted', 0),
('mike_rec', 'Evelyn Patterson', 'evelyn.patterson@email.com', '555-0176', 'Female', 'Frontend Engineer', 'Company Website', 'TypeScript expert', 'Shortlisted', 0),
('sarah_rec', 'Henry Hughes', 'henry.hughes@email.com', '555-0177', 'Male', 'DevOps Lead', 'Indeed', 'Infrastructure as code', 'Shortlisted', 0),
('mike_rec', 'Diane Flores', 'diane.flores@email.com', '555-0178', 'Female', 'UX Researcher', 'Job Portal', 'User testing', 'Shortlisted', 0),
('sarah_rec', 'Walter Washington', 'walter.washington@email.com', '555-0179', 'Male', 'ML Engineer', 'Referral', 'TensorFlow and PyTorch', 'Shortlisted', 0),
('mike_rec', 'Joyce Butler', 'joyce.butler@email.com', '555-0180', 'Female', 'Technical Writer', 'LinkedIn', 'API documentation', 'Shortlisted', 0);

-- Rejected Candidates (20)
INSERT INTO `candidate_details` (`cd_rec_username`, `cd_name`, `cd_email`, `cd_phone`, `cd_gender`, `cd_job_title`, `cd_source`, `cd_description`, `cd_status`, `cd_interview_status`) VALUES
('sarah_rec', 'Arthur Simmons', 'arthur.simmons@email.com', '555-0181', 'Male', 'Software Developer', 'Indeed', 'Did not meet technical requirements', 'Rejected', 0),
('mike_rec', 'Gloria Foster', 'gloria.foster@email.com', '555-0182', 'Female', 'Frontend Developer', 'LinkedIn', 'Insufficient experience', 'Rejected', 0),
('sarah_rec', 'Ralph Gonzales', 'ralph.gonzales@email.com', '555-0183', 'Male', 'Backend Developer', 'Job Portal', 'Failed coding assessment', 'Rejected', 0),
('mike_rec', 'Doris Bryant', 'doris.bryant@email.com', '555-0184', 'Female', 'QA Engineer', 'Referral', 'Not a cultural fit', 'Rejected', 0),
('sarah_rec', 'Roy Alexander', 'roy.alexander@email.com', '555-0185', 'Male', 'DevOps Engineer', 'Company Website', 'Salary expectations too high', 'Rejected', 0),
('mike_rec', 'Marilyn Russell', 'marilyn.russell@email.com', '555-0186', 'Female', 'Product Manager', 'LinkedIn', 'Lack of product experience', 'Rejected', 0),
('sarah_rec', 'Eugene Griffin', 'eugene.griffin@email.com', '555-0187', 'Male', 'Data Scientist', 'Indeed', 'Weak statistical knowledge', 'Rejected', 0),
('mike_rec', 'Beverly Diaz', 'beverly.diaz@email.com', '555-0188', 'Female', 'UI/UX Designer', 'Job Portal', 'Portfolio not strong enough', 'Rejected', 0),
('sarah_rec', 'Russell Hayes', 'russell.hayes@email.com', '555-0189', 'Male', 'Mobile Developer', 'Referral', 'Limited mobile experience', 'Rejected', 0),
('mike_rec', 'Judith Myers', 'judith.myers@email.com', '555-0190', 'Female', 'Business Analyst', 'Company Website', 'Poor communication skills', 'Rejected', 0),
('sarah_rec', 'Willie Ford', 'willie.ford@email.com', '555-0191', 'Male', 'Full Stack Developer', 'LinkedIn', 'Failed technical interview', 'Rejected', 0),
('mike_rec', 'Virginia Hamilton', 'virginia.hamilton@email.com', '555-0192', 'Female', 'Scrum Master', 'Indeed', 'No agile certification', 'Rejected', 0),
('sarah_rec', 'Albert Graham', 'albert.graham@email.com', '555-0193', 'Male', 'Cloud Engineer', 'Job Portal', 'Insufficient cloud knowledge', 'Rejected', 0),
('mike_rec', 'Kathryn Sullivan', 'kathryn.sullivan@email.com', '555-0194', 'Female', 'Data Analyst', 'Referral', 'Weak SQL skills', 'Rejected', 0),
('sarah_rec', 'Lawrence Wallace', 'lawrence.wallace@email.com', '555-0195', 'Male', 'Security Engineer', 'LinkedIn', 'No security certifications', 'Rejected', 0),
('mike_rec', 'Pamela Woods', 'pamela.woods@email.com', '555-0196', 'Female', 'Technical Lead', 'Company Website', 'Lack of leadership experience', 'Rejected', 0),
('sarah_rec', 'Joe West', 'joe.west@email.com', '555-0197', 'Male', 'Software Engineer', 'Indeed', 'Overqualified for position', 'Rejected', 0),
('mike_rec', 'Carolyn Cole', 'carolyn.cole@email.com', '555-0198', 'Female', 'Frontend Developer', 'Job Portal', 'Relocated to different city', 'Rejected', 0),
('sarah_rec', 'Ernest Owens', 'ernest.owens@email.com', '555-0199', 'Male', 'Backend Developer', 'Referral', 'Accepted another offer', 'Rejected', 0),
('mike_rec', 'Martha Reynolds', 'martha.reynolds@email.com', '555-0200', 'Female', 'QA Automation', 'LinkedIn', 'Not available for start date', 'Rejected', 0);

-- Hold Candidates (20)
INSERT INTO `candidate_details` (`cd_rec_username`, `cd_name`, `cd_email`, `cd_phone`, `cd_gender`, `cd_job_title`, `cd_source`, `cd_description`, `cd_status`, `cd_interview_status`) VALUES
('sarah_rec', 'Louis Fisher', 'louis.fisher@email.com', '555-0201', 'Male', 'Software Developer', 'Company Website', 'Waiting for budget approval', 'Hold', 0),
('mike_rec', 'Sara Porter', 'sara.porter@email.com', '555-0202', 'Female', 'Frontend Developer', 'Indeed', 'Position temporarily frozen', 'Hold', 0),
('sarah_rec', 'Jack Hunter', 'jack.hunter@email.com', '555-0203', 'Male', 'Backend Developer', 'LinkedIn', 'Pending reference checks', 'Hold', 0),
('mike_rec', 'Alice Hicks', 'alice.hicks@email.com', '555-0204', 'Female', 'QA Engineer', 'Job Portal', 'Awaiting team decision', 'Hold', 0),
('sarah_rec', 'Gerald Crawford', 'gerald.crawford@email.com', '555-0205', 'Male', 'DevOps Engineer', 'Referral', 'Waiting for project confirmation', 'Hold', 0),
('mike_rec', 'Judith Boyd', 'judith.boyd@email.com', '555-0206', 'Female', 'Product Manager', 'Company Website', 'Budget review in progress', 'Hold', 0),
('sarah_rec', 'Carl Mason', 'carl.mason@email.com', '555-0207', 'Male', 'Data Scientist', 'LinkedIn', 'Headcount approval pending', 'Hold', 0),
('mike_rec', 'Madison Dixon', 'madison.dixon@email.com', '555-0208', 'Female', 'UI/UX Designer', 'Indeed', 'Waiting for design team feedback', 'Hold', 0),
('sarah_rec', 'Keith Reid', 'keith.reid@email.com', '555-0209', 'Male', 'Mobile Developer', 'Job Portal', 'Project timeline uncertain', 'Hold', 0),
('mike_rec', 'Judy Fox', 'judy.fox@email.com', '555-0210', 'Female', 'Business Analyst', 'Referral', 'Department restructuring', 'Hold', 0),
('sarah_rec', 'Willie McDonald', 'willie.mcdonald@email.com', '555-0211', 'Male', 'Full Stack Developer', 'Company Website', 'Waiting for senior approval', 'Hold', 0),
('mike_rec', 'Theresa Kennedy', 'theresa.kennedy@email.com', '555-0212', 'Female', 'Scrum Master', 'LinkedIn', 'Team capacity review', 'Hold', 0),
('sarah_rec', 'Lawrence Wells', 'lawrence.wells@email.com', '555-0213', 'Male', 'Cloud Engineer', 'Indeed', 'Cloud migration timeline TBD', 'Hold', 0),
('mike_rec', 'Deborah Vargas', 'deborah.vargas@email.com', '555-0214', 'Female', 'Data Analyst', 'Job Portal', 'Analytics team expansion on hold', 'Hold', 0),
('sarah_rec', 'Nicholas Chavez', 'nicholas.chavez@email.com', '555-0215', 'Male', 'Security Engineer', 'Referral', 'Security audit completion pending', 'Hold', 0),
('mike_rec', 'Julie Sims', 'julie.sims@email.com', '555-0216', 'Female', 'Technical Lead', 'Company Website', 'Leadership structure review', 'Hold', 0),
('sarah_rec', 'Bruce Castillo', 'bruce.castillo@email.com', '555-0217', 'Male', 'Software Engineer', 'LinkedIn', 'Waiting for team availability', 'Hold', 0),
('mike_rec', 'Olivia Montgomery', 'olivia.montgomery@email.com', '555-0218', 'Female', 'Frontend Developer', 'Indeed', 'Project scope clarification needed', 'Hold', 0),
('sarah_rec', 'Billy Richards', 'billy.richards@email.com', '555-0219', 'Male', 'Backend Developer', 'Job Portal', 'Tech stack decision pending', 'Hold', 0),
('mike_rec', 'Emma Williamson', 'emma.williamson@email.com', '555-0220', 'Female', 'QA Automation', 'Referral', 'QA process review in progress', 'Hold', 0);

-- ============================================
-- 3. CALENDAR EVENTS (Interviews)
-- ============================================

-- Past interviews for selected candidates
INSERT INTO `calendar_events` (`ce_rec_username`, `ce_can_name`, `ce_interviewer`, `ce_start_date`, `ce_end_date`, `ce_interview_round`) VALUES
('sarah_rec', 'Alex Johnson', 'david_int', '2025-11-05 10:00:00', '2025-11-05 11:00:00', 1),
('sarah_rec', 'Robert Chen', 'emma_int', '2025-11-06 14:00:00', '2025-11-06 15:00:00', 1),
('mike_rec', 'Sophia Rodriguez', 'david_int', '2025-11-07 09:00:00', '2025-11-07 10:00:00', 1),
('sarah_rec', 'Emily Watson', 'emma_int', '2025-11-08 11:00:00', '2025-11-08 12:00:00', 1),
('mike_rec', 'James Miller', 'david_int', '2025-11-09 15:00:00', '2025-11-09 16:00:00', 1);

-- Upcoming interviews for in-progress candidates
INSERT INTO `calendar_events` (`ce_rec_username`, `ce_can_name`, `ce_interviewer`, `ce_start_date`, `ce_end_date`, `ce_interview_round`) VALUES
('sarah_rec', 'Matthew Harris', 'emma_int', '2025-11-15 10:00:00', '2025-11-15 11:00:00', 0.5),
('mike_rec', 'Sarah Thompson', 'david_int', '2025-11-16 14:00:00', '2025-11-16 15:30:00', 0.25),
('sarah_rec', 'Kevin Moore', 'emma_int', '2025-11-17 09:00:00', '2025-11-17 10:00:00', 0.5),
('mike_rec', 'Rachel Green', 'david_int', '2025-11-18 13:00:00', '2025-11-18 14:00:00', 0.25),
('sarah_rec', 'Brian Clark', 'emma_int', '2025-11-19 11:00:00', '2025-11-19 12:00:00', 0.75),
('mike_rec', 'Nicole Adams', 'david_int', '2025-11-20 10:00:00', '2025-11-20 11:00:00', 0.5),
('sarah_rec', 'Justin Baker', 'emma_int', '2025-11-21 15:00:00', '2025-11-21 16:00:00', 0.25),
('mike_rec', 'Melissa Scott', 'david_int', '2025-11-22 09:00:00', '2025-11-22 10:00:00', 0.5);

-- ============================================
-- 4. PROFILE INFO (Optional - for user profiles)
-- ============================================

INSERT INTO `profile_info` (`pi_username`, `pi_email`, `pi_phone`, `pi_gender`, `pi_role`) VALUES
('johndoe', 'admin@rms.com', '555-1001', 'Male', 'Admin'),
('sarah_rec', 'sarah@rms.com', '555-1002', 'Female', 'Recruiter'),
('mike_rec', 'mike@rms.com', '555-1003', 'Male', 'Recruiter'),
('david_int', 'david@rms.com', '555-1004', 'Male', 'Interviewer'),
('emma_int', 'emma@rms.com', '555-1005', 'Female', 'Interviewer');

-- ============================================
-- SUMMARY OF TEST DATA
-- ============================================
-- Total Candidates: 120
-- - Selected: 15
-- - In Progress: 25
-- - Shortlisted: 40
-- - Rejected: 20
-- - Hold: 20
--
-- Users:
-- - Admin: johndoe / admin123
-- - Recruiters: sarah_rec, mike_rec / recruiter123
-- - Interviewers: david_int, emma_int / interviewer123
--
-- Calendar Events: 13 (5 past, 8 upcoming)
-- ============================================
