# 🎯 Interviewer & Candidate Portal Implementation Plan

## Phase 1: Database Schema Setup

### New Tables Needed:
1. **interviewer_feedback** - Store interview feedback and scores
2. **interview_assignments** - Track interviewer assignments to interviews
3. **candidate_applications** - Track candidate job applications
4. **candidate_documents** - Store candidate uploaded documents
5. **interview_confirmations** - Track interview attendance confirmations
6. **messages** - Communication between users

## Phase 2: Interviewer Features

### 2.1 Interviewer Dashboard
- [ ] Create `I_dashboard.php` controller
- [ ] Create interviewer dashboard view
- [ ] Today's interviews widget
- [ ] Pending feedback widget
- [ ] Quick stats (total interviews, feedback pending)

### 2.2 Interview Schedule
- [ ] Personal calendar view (similar to recruiter calendar)
- [ ] Candidate details modal
- [ ] Accept/Decline interview assignments
- [ ] Download candidate resume

### 2.3 Feedback System
- [ ] Feedback submission form
- [ ] Rating system (1-5 stars or custom rubric)
- [ ] Historical feedback view
- [ ] Job description & interview guide access

### 2.4 Profile Management
- [ ] Update personal info
- [ ] Set availability calendar
- [ ] Notification preferences

## Phase 3: Candidate Features

### 3.1 Candidate Portal Dashboard
- [ ] Create `C_dashboard.php` controller
- [ ] Application status overview
- [ ] Interview alerts
- [ ] Application timeline

### 3.2 Application Tracking
- [ ] List of applied jobs
- [ ] Application status for each
- [ ] Upload/update resume
- [ ] Upload supporting documents

### 3.3 Interview Management
- [ ] View scheduled interviews
- [ ] Interview details (date, time, interviewer, location/link)
- [ ] Confirm attendance
- [ ] Request reschedule
- [ ] Access preparation materials

### 3.4 Communication Center
- [ ] Message inbox
- [ ] Notifications
- [ ] Email alerts

### 3.5 Profile Management
- [ ] Update contact information
- [ ] Update resume
- [ ] View application history

## Phase 4: Integration
- [ ] Update login to route to correct dashboard based on role
- [ ] Add role-based access control
- [ ] Email notifications
- [ ] Real-time updates

## Tech Stack
- **Backend**: PHP (CodeIgniter)
- **Frontend**: HTML, CSS, JavaScript, Bootstrap 5
- **Database**: MySQL
- **Calendar**: FullCalendar.js
- **Charts**: Chart.js
- **Icons**: Font Awesome

---

## 🚀 Let's Start Building!
