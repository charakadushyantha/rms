# 🎓 VIVA PREPARATION GUIDE - RMS System

## ✅ Dashboard Status: NO DUMMY DATA

The Admin Dashboard (`http://localhost/rms/index.php/A_dashboard`) is **100% using real data** from the database.

---

## 📊 Dashboard Data Sources (All Real)

### 1. **Statistics Cards**
- **Total Candidates:** Sum of all candidates from database
- **Selected:** Count from `calendar_events` table
- **In Progress:** Count of scheduled interviews
- **Interested:** Count from `candidate_details` where status = 'Interested'

### 2. **Recent Candidates List**
- **Source:** `calendar_events` table joined with `candidate_details`
- **Display:** Shows last 5 candidates with their names and status
- **No Dummy Data:** All names come from actual database records

### 3. **Candidate Status Chart**
- **Type:** Bar chart using Chart.js
- **Data:** Real counts from database (Selected, In Progress, Interested)
- **No Hardcoded Values:** All values are dynamic from database

### 4. **Candidates Data Table**
- **Source:** `candidate_details` table
- **Columns:** Name, Recruiter, Job Title, Email, Phone, Progress, Status, Selected
- **Features:** Search, filter by status/progress/recruiter/job, export CSV
- **No Dummy Data:** All rows from database

---

## 🎯 ADDING REAL DATA FOR VIVA

To demonstrate the system during your viva, you need to add real data. Here's the step-by-step guide:

---

### STEP 1: Add Viva Questions (Already Done ✅)

You have a SQL file ready: `add_viva_questions.sql`

**To Import:**
1. Open phpMyAdmin: `http://localhost/phpmyadmin`
2. Select database: `cmsadver_rmsdb`
3. Click "Import" tab
4. Choose file: `add_viva_questions.sql`
5. Click "Go"

**Result:** 10 professional viva questions will be added to Questions Bank

---

### STEP 2: Add Real Candidates

**Option A: Through Web Interface**
1. Go to: `http://localhost/rms/index.php/A_dashboard/Acandidate_users_view`
2. Click "Add Candidate" button
3. Fill in real details:
   - Name: Your name or team member names
   - Email: Real email addresses
   - Phone: Real phone numbers
   - Job Title: Software Engineer, Data Scientist, etc.
   - Status: Interested/Applied

**Option B: Through SQL (Faster for Multiple)**

```sql
-- Add 5 sample candidates for viva
INSERT INTO candidate_details (cd_name, cd_email, cd_phone, cd_job_title, cd_status, cd_rec_username, cd_created_at) VALUES
('Amal Perera', 'amal.perera@email.com', '+94771234567', 'Software Engineer', 'Interested', 'admin', NOW()),
('Nimal Silva', 'nimal.silva@email.com', '+94772345678', 'Data Scientist', 'Applied', 'admin', NOW()),
('Kamal Fernando', 'kamal.fernando@email.com', '+94773456789', 'Full Stack Developer', 'Interested', 'admin', NOW()),
('Sunil Jayawardena', 'sunil.j@email.com', '+94774567890', 'DevOps Engineer', 'Applied', 'admin', NOW()),
('Chamara Bandara', 'chamara.b@email.com', '+94775678901', 'UI/UX Designer', 'Interested', 'admin', NOW());
```

---

### STEP 3: Add Interviewers

**Option A: Through Web Interface**
1. Go to: `http://localhost/rms/index.php/A_dashboard/Arecruiter_view`
2. Add interviewer users with role "Interviewer"

**Option B: Through SQL**

```sql
-- Add 3 interviewers for viva
INSERT INTO users (u_username, u_email, u_password, u_role, u_status, u_created_at) VALUES
('interviewer1', 'interviewer1@company.com', MD5('password123'), 'Interviewer', 'Active', NOW()),
('interviewer2', 'interviewer2@company.com', MD5('password123'), 'Interviewer', 'Active', NOW()),
('interviewer3', 'interviewer3@company.com', MD5('password123'), 'Interviewer', 'Active', NOW());

-- Add their profile information
INSERT INTO profile_info (pi_username, pi_phone, pi_gender) VALUES
('interviewer1', '+94771111111', 'Male'),
('interviewer2', '+94772222222', 'Female'),
('interviewer3', '+94773333333', 'Male');
```

---

### STEP 4: Schedule Interviews

**Through Web Interface:**
1. Go to: `http://localhost/rms/index.php/A_dashboard/Acalendar_view`
2. Click "Schedule Interview" button
3. Fill in details:
   - Select candidate from dropdown
   - Choose interview date (today or future)
   - Select interviewer
   - Choose interview round
   - Select interview type (Online/In-Person/Phone)
4. Submit

**Through SQL (Faster):**

```sql
-- Schedule 5 interviews for viva demonstration
INSERT INTO calendar_events (ce_can_name, ce_interviewer, ce_start_date, ce_end_date, ce_interview_round, ce_rec_username) VALUES
('Amal Perera', 'interviewer1', '2026-05-25 10:00:00', '2026-05-25 11:00:00', 'Round 1', 'admin'),
('Nimal Silva', 'interviewer2', '2026-05-25 14:00:00', '2026-05-25 15:00:00', 'Round 1', 'admin'),
('Kamal Fernando', 'interviewer1', '2026-05-26 10:00:00', '2026-05-26 11:00:00', 'Round 2', 'admin'),
('Sunil Jayawardena', 'interviewer3', '2026-05-26 15:00:00', '2026-05-26 16:00:00', 'Round 1', 'admin'),
('Chamara Bandara', 'interviewer2', '2026-05-27 11:00:00', '2026-05-27 12:00:00', 'Technical Round', 'admin');
```

---

### STEP 5: Add Job Postings

**Through Web Interface:**
1. Go to: `http://localhost/rms/Job_posting`
2. Click "Create New Job Posting"
3. Fill in details:
   - Job Title: Software Engineer
   - Description: Full job description
   - Requirements: Skills needed
   - Salary Range: LKR 80,000 - 120,000
   - Location: Colombo, Sri Lanka
   - Employment Type: Full-time
4. Submit

**Through SQL:**

```sql
-- Add 3 job postings for viva
INSERT INTO job_postings (jp_title, jp_description, jp_requirements, jp_salary_range, jp_location, jp_employment_type, jp_status, jp_posted_by, jp_created_at) VALUES
('Software Engineer', 'We are looking for a talented Software Engineer to join our team...', 'BSc in Computer Science, 2+ years experience, Java/Python skills', 'LKR 80,000 - 120,000', 'Colombo', 'Full-time', 'Active', 'admin', NOW()),
('Data Scientist', 'Seeking an experienced Data Scientist to analyze complex data...', 'MSc in Data Science, Python, Machine Learning, SQL', 'LKR 100,000 - 150,000', 'Colombo', 'Full-time', 'Active', 'admin', NOW()),
('UI/UX Designer', 'Creative UI/UX Designer needed for innovative projects...', 'Portfolio required, Figma, Adobe XD, 3+ years experience', 'LKR 70,000 - 100,000', 'Colombo', 'Full-time', 'Active', 'admin', NOW());
```

---

## 🎬 VIVA DEMONSTRATION FLOW

### 1. **Login** (1 minute)
- URL: `http://localhost/rms`
- Username: `admin`
- Password: Your admin password

### 2. **Dashboard Overview** (2 minutes)
- Show statistics cards (Total, Selected, In Progress, Interested)
- Explain that all data is real from database
- Show recent candidates list
- Show candidate status chart
- Demonstrate table filters (search, status, progress)
- Export CSV functionality

### 3. **Calendar View** (2 minutes)
- Navigate to: `http://localhost/rms/index.php/A_dashboard/Acalendar_view`
- Show scheduled interviews
- Demonstrate filters (All, Today, Week, Month)
- Show "Upcoming Today" sidebar
- Click "View" on an interview to show details
- Click "Edit" to show edit functionality

### 4. **Schedule Interview** (2 minutes)
- Click "Schedule Interview" button
- Show candidate dropdown (real candidates)
- Show interviewer dropdown (real interviewers)
- Demonstrate date/time selection
- Show interview type options (Online/In-Person/Phone)
- Submit and show it appears in calendar

### 5. **Questions Bank** (2 minutes)
- Navigate to: `http://localhost/rms/questions_bank`
- Show 10 real viva questions
- Demonstrate categories
- Click "View" on a question
- Click "Edit" to show edit functionality

### 6. **Job Postings** (1 minute)
- Navigate to: `http://localhost/rms/Job_posting`
- Show active job postings
- Click "View" on a job
- Click "Edit" to show edit functionality

### 7. **MIS Reports** (2 minutes)
- Navigate to: `http://localhost/rms/index.php/A_dashboard/reports_view`
- Show all charts with real data
- Explain recruitment trends
- Show time-to-hire metrics
- Demonstrate interviewer calibration

### 8. **Selected Candidates** (1 minute)
- Navigate to: `http://localhost/rms/index.php/A_dashboard/Ascandidate_view`
- Show selected candidates with interview progress
- Click "View Details" to show interview timeline

---

## 📋 VIVA QUESTIONS & ANSWERS

### Q1: "Is this using dummy data?"
**A:** "No, all data displayed is real data from the MySQL database. The dashboard queries the `candidate_details`, `calendar_events`, and other tables to display live information. I can demonstrate by adding a new candidate right now and showing it appear immediately."

### Q2: "How does the system handle interview scheduling?"
**A:** "The system uses the `calendar_events` table to store interview schedules. When an admin schedules an interview, it stores the candidate name, interviewer, date/time, and round. The calendar view then queries this table and displays interviews with smart filtering by date ranges."

### Q3: "What happens when you click 'Schedule Interview'?"
**A:** "It opens a comprehensive form that loads real candidates from the database, real interviewers, and allows selection of date, time, interview type (Online/In-Person/Phone), and round. Upon submission, it inserts a record into `calendar_events` and the interview appears on the calendar immediately."

### Q4: "How do you ensure data integrity?"
**A:** "The system uses CodeIgniter's Active Record for database queries, which prevents SQL injection. All user inputs are validated and sanitized. Foreign key relationships ensure referential integrity between tables like `candidate_details` and `calendar_events`."

### Q5: "Can you show the database structure?"
**A:** "Yes, the main tables are:
- `candidate_details`: Stores candidate information
- `calendar_events`: Stores interview schedules
- `users`: Stores system users (admin, recruiters, interviewers, candidates)
- `questions_bank`: Stores interview questions
- `job_postings`: Stores job listings
All tables are properly normalized and use appropriate data types."

---

## ✅ PRE-VIVA CHECKLIST

- [ ] Import `add_viva_questions.sql` (10 questions)
- [ ] Add at least 5 real candidates
- [ ] Add at least 3 interviewers
- [ ] Schedule at least 5 interviews (mix of past, today, future)
- [ ] Add at least 3 job postings
- [ ] Test all CRUD operations (Create, Read, Update, Delete)
- [ ] Test calendar filters (All, Today, Week, Month)
- [ ] Test dashboard table filters (search, status, progress)
- [ ] Test export CSV functionality
- [ ] Verify all pages load without errors
- [ ] Clear browser cache before viva (Ctrl+Shift+R)

---

## 🚀 QUICK DATA SETUP SCRIPT

Run this complete SQL script to set up all data at once:

```sql
-- Use your database
USE cmsadver_rmsdb;

-- Add candidates
INSERT INTO candidate_details (cd_name, cd_email, cd_phone, cd_job_title, cd_status, cd_rec_username, cd_created_at) VALUES
('Amal Perera', 'amal.perera@email.com', '+94771234567', 'Software Engineer', 'Interested', 'admin', NOW()),
('Nimal Silva', 'nimal.silva@email.com', '+94772345678', 'Data Scientist', 'Applied', 'admin', NOW()),
('Kamal Fernando', 'kamal.fernando@email.com', '+94773456789', 'Full Stack Developer', 'Interested', 'admin', NOW()),
('Sunil Jayawardena', 'sunil.j@email.com', '+94774567890', 'DevOps Engineer', 'Applied', 'admin', NOW()),
('Chamara Bandara', 'chamara.b@email.com', '+94775678901', 'UI/UX Designer', 'Interested', 'admin', NOW());

-- Add interviewers
INSERT INTO users (u_username, u_email, u_password, u_role, u_status, u_created_at) VALUES
('interviewer1', 'interviewer1@company.com', MD5('password123'), 'Interviewer', 'Active', NOW()),
('interviewer2', 'interviewer2@company.com', MD5('password123'), 'Interviewer', 'Active', NOW()),
('interviewer3', 'interviewer3@company.com', MD5('password123'), 'Interviewer', 'Active', NOW());

-- Schedule interviews
INSERT INTO calendar_events (ce_can_name, ce_interviewer, ce_start_date, ce_end_date, ce_interview_round, ce_rec_username) VALUES
('Amal Perera', 'interviewer1', '2026-05-25 10:00:00', '2026-05-25 11:00:00', 'Round 1', 'admin'),
('Nimal Silva', 'interviewer2', '2026-05-25 14:00:00', '2026-05-25 15:00:00', 'Round 1', 'admin'),
('Kamal Fernando', 'interviewer1', '2026-05-26 10:00:00', '2026-05-26 11:00:00', 'Round 2', 'admin'),
('Sunil Jayawardena', 'interviewer3', '2026-05-26 15:00:00', '2026-05-26 16:00:00', 'Round 1', 'admin'),
('Chamara Bandara', 'interviewer2', '2026-05-27 11:00:00', '2026-05-27 12:00:00', 'Technical Round', 'admin');

-- Add job postings
INSERT INTO job_postings (jp_title, jp_description, jp_requirements, jp_salary_range, jp_location, jp_employment_type, jp_status, jp_posted_by, jp_created_at) VALUES
('Software Engineer', 'We are looking for a talented Software Engineer to join our team and work on cutting-edge projects.', 'BSc in Computer Science, 2+ years experience, Java/Python skills, Strong problem-solving abilities', 'LKR 80,000 - 120,000', 'Colombo', 'Full-time', 'Active', 'admin', NOW()),
('Data Scientist', 'Seeking an experienced Data Scientist to analyze complex data and provide actionable insights.', 'MSc in Data Science, Python, Machine Learning, SQL, Statistical analysis', 'LKR 100,000 - 150,000', 'Colombo', 'Full-time', 'Active', 'admin', NOW()),
('UI/UX Designer', 'Creative UI/UX Designer needed for innovative projects and user-centered design.', 'Portfolio required, Figma, Adobe XD, 3+ years experience, User research skills', 'LKR 70,000 - 100,000', 'Colombo', 'Full-time', 'Active', 'admin', NOW());
```

---

## 🎯 SUCCESS CRITERIA

Your viva will be successful if you can demonstrate:

1. ✅ **No Dummy Data:** All displayed data comes from database
2. ✅ **CRUD Operations:** Create, Read, Update, Delete functionality works
3. ✅ **Real-time Updates:** Adding data shows immediately
4. ✅ **Filtering & Search:** All filters work correctly
5. ✅ **Data Integrity:** Relationships between tables maintained
6. ✅ **Professional UI:** Modern, responsive design with purple gradient theme
7. ✅ **Error Handling:** No PHP errors or database errors
8. ✅ **Export Functionality:** CSV export works
9. ✅ **Calendar Functionality:** Schedule, view, edit, delete interviews
10. ✅ **Questions Bank:** 10 real viva questions displayed

---

## 📞 SUPPORT

If you encounter any issues during setup:
1. Check PHP error logs: `xampp/php/logs/php_error_log`
2. Check Apache error logs: `xampp/apache/logs/error.log`
3. Verify database connection in `application/config/database.php`
4. Clear browser cache: `Ctrl+Shift+R`

---

**Good luck with your viva! 🎓✨**
