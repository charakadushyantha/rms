# User Roles & Permissions Guide

## 🎭 Four User Types in RMS

The Recruitment Management System supports **4 distinct user roles**, each with specific permissions and access levels:

---

## 1. 👑 Admin
**Full System Access & Control**

### Permissions:
- ✅ Complete system configuration
- ✅ Manage all users (create, edit, delete)
- ✅ Access all setup modules
- ✅ View all candidates and recruiters
- ✅ Conduct interviews
- ✅ Generate reports and analytics
- ✅ Manage company settings
- ✅ Configure integrations
- ✅ Access audit logs
- ✅ Backup and recovery

### Access Areas:
- Admin Dashboard
- System Setup (all modules)
- User Management
- Company Settings
- All Recruiter features
- All Interviewer features
- Real-Time Dashboard
- Database Management

### Badge Color: 🔴 Red (Danger)

---

## 2. 👔 Recruiter
**Candidate & Interview Management**

### Permissions:
- ✅ Add and manage candidates
- ✅ Schedule interviews
- ✅ View candidate pipeline
- ✅ Update candidate status
- ✅ Conduct interviews
- ✅ Access calendar
- ✅ View selected candidates
- ✅ Generate recruitment reports
- ✅ Manage own profile
- ❌ Cannot access system setup
- ❌ Cannot manage users
- ❌ Cannot change company settings

### Access Areas:
- Recruiter Dashboard
- Add Candidate
- Pipeline (Candidate Status)
- Calendar
- Selected Candidates
- Real-Time Dashboard
- My Account

### Badge Color: 🔵 Blue (Primary)

---

## 3. 🎯 Interviewer
**Interview Conduct & Feedback**

### Permissions:
- ✅ View assigned interviews
- ✅ Conduct interviews
- ✅ Provide interview feedback
- ✅ Rate candidates
- ✅ View candidate profiles (assigned only)
- ✅ Access interview calendar
- ✅ Update interview status
- ✅ Manage own profile
- ❌ Cannot add candidates
- ❌ Cannot schedule interviews
- ❌ Cannot access system setup
- ❌ Cannot manage users

### Access Areas:
- Interviewer Dashboard
- My Interviews
- Interview Calendar
- Candidate Profiles (assigned)
- Feedback Forms
- My Account

### Badge Color: 🟡 Yellow (Warning)

---

## 4. 👤 Candidate
**Application Tracking & Profile Management**

### Permissions:
- ✅ Create and update profile
- ✅ Apply for job positions
- ✅ Track application status
- ✅ View interview schedules
- ✅ Upload resume and documents
- ✅ Receive notifications
- ✅ View job listings
- ✅ Manage own profile
- ❌ Cannot view other candidates
- ❌ Cannot access admin features
- ❌ Cannot schedule interviews
- ❌ Cannot access system setup

### Access Areas:
- Candidate Dashboard
- My Profile
- Job Listings
- My Applications
- Interview Schedule
- Document Upload
- Notifications

### Badge Color: 🟢 Green (Success)

---

## 🔐 Role Hierarchy

```
Admin (Highest)
  ↓
Recruiter
  ↓
Interviewer
  ↓
Candidate (Lowest)
```

---

## 📊 Role Comparison Matrix

| Feature | Admin | Recruiter | Interviewer | Candidate |
|---------|-------|-----------|-------------|-----------|
| System Setup | ✅ | ❌ | ❌ | ❌ |
| User Management | ✅ | ❌ | ❌ | ❌ |
| Add Candidates | ✅ | ✅ | ❌ | ❌ |
| Schedule Interviews | ✅ | ✅ | ❌ | ❌ |
| Conduct Interviews | ✅ | ✅ | ✅ | ❌ |
| View All Candidates | ✅ | ✅ | ❌ | ❌ |
| Provide Feedback | ✅ | ✅ | ✅ | ❌ |
| Apply for Jobs | ❌ | ❌ | ❌ | ✅ |
| Track Application | ❌ | ❌ | ❌ | ✅ |
| Company Settings | ✅ | ❌ | ❌ | ❌ |
| Reports & Analytics | ✅ | ✅ | ❌ | ❌ |

---

## 🎨 Visual Identification

### Badge Colors in UI:
- **Admin**: Red badge (bg-danger)
- **Recruiter**: Blue badge (bg-primary)
- **Interviewer**: Yellow badge (bg-warning)
- **Candidate**: Green badge (bg-success)

### Icons:
- **Admin**: 🛡️ Shield (fa-user-shield)
- **Recruiter**: 👥 Users (fa-users)
- **Interviewer**: 👔 Tie (fa-user-tie)
- **Candidate**: 👤 User (fa-user)

---

## 🔧 How to Manage Users

### Adding a New User:

1. **Login as Admin**
2. Go to **Setup → Manage Users**
3. Click **"Add New User"**
4. Fill in details:
   - Username (required)
   - Email (required)
   - Password (required)
   - **Select Role** (Admin/Recruiter/Interviewer/Candidate)
5. Click **"Add User"**

### Role Descriptions in Form:
- **Admin:** Full system access
- **Recruiter:** Manage candidates & interviews
- **Interviewer:** Conduct interviews & provide feedback
- **Candidate:** Apply for jobs & track application status

---

## 🎯 Who Can Conduct Interviews?

Users with these roles can conduct interviews:
1. ✅ **Admin**
2. ✅ **Recruiter**
3. ✅ **Interviewer**

When scheduling an interview, you can select from users with any of these three roles.

---

## 📝 Best Practices

### For Admins:
- Create separate accounts for each role
- Don't share admin credentials
- Regularly review user access
- Disable inactive accounts
- Use strong passwords

### For Recruiters:
- Keep candidate information updated
- Schedule interviews promptly
- Provide detailed feedback
- Maintain communication with candidates

### For Interviewers:
- Review candidate profiles before interviews
- Provide timely feedback
- Be objective in evaluations
- Keep interview notes confidential

### For Candidates:
- Keep profile updated
- Upload latest resume
- Check interview schedules regularly
- Respond to communications promptly

---

## 🔄 Role Changes

### Changing a User's Role:

1. Go to **Setup → Manage Users**
2. Click **Edit** button for the user
3. Select new role from dropdown
4. Click **"Update User"**
5. User will have new permissions on next login

### Important Notes:
- Role changes take effect immediately
- User may need to logout and login again
- Changing role affects access to all features
- Cannot change your own role (security measure)

---

## 🚨 Security Considerations

### Password Requirements:
- Minimum 8 characters (recommended)
- Use strong passwords
- Change passwords regularly
- Don't share credentials

### Access Control:
- Each user should have only one account
- Assign minimum required permissions
- Review access logs regularly
- Disable accounts when users leave

### Data Privacy:
- Candidates can only see their own data
- Interviewers see only assigned candidates
- Recruiters see all candidates they manage
- Admins have full visibility

---

## 📞 Support

For role-related questions:
- Contact system administrator
- Review this documentation
- Check user management guide
- Submit support ticket

---

## ✅ Quick Reference

### Default Login URLs:
```
Admin: http://localhost/rms/A_dashboard
Recruiter: http://localhost/rms/R_dashboard
Interviewer: http://localhost/rms/I_dashboard (if implemented)
Candidate: http://localhost/rms/C_dashboard (if implemented)
```

### User Management:
```
Add User: Setup → Manage Users → Add New User
Edit User: Setup → Manage Users → Edit button
Delete User: Setup → Manage Users → Delete button
View Recruiters: Setup → Manage Recruiters
View Interviewers: Setup → Manage Interviewers
```

---

## 🎉 Summary

The RMS system now supports **4 distinct user roles** with clear permissions and access levels:

1. **Admin** - Full control (Red badge)
2. **Recruiter** - Candidate management (Blue badge)
3. **Interviewer** - Interview conduct (Yellow badge)
4. **Candidate** - Application tracking (Green badge)

Each role is designed to provide the right level of access for specific job functions while maintaining security and data privacy.
