# Complete System Setup Guide

## 🚀 Quick Installation

### Option 1: Automated Installer (RECOMMENDED)
Simply open this URL in your browser:
```
http://localhost/rms/install_company_settings.php
```

This will automatically:
- ✅ Create all 5 tables (company_settings, departments, branches, job_categories, job_positions)
- ✅ Insert sample data
- ✅ Create uploads directory
- ✅ Show success confirmation

**After installation, delete `install_company_settings.php` for security!**

### Option 2: Manual SQL Installation
1. Open phpMyAdmin: `http://localhost/phpmyadmin`
2. Select database: `rmsdb`
3. Click "SQL" tab
4. Copy and paste entire content from: `database_migrations/company_settings_tables.sql`
5. Click "Go"

---

## 📋 What's Included

### ✅ Fully Working Modules

#### 1. **Core Configuration**
- **Company Settings** - `Setup/company_settings`
  - Company profile with logo upload
  - Branches/locations management
  - Departments structure
  - Business hours & financial year

- **Job Categories** - `Setup/job_categories`
  - Create job categories (IT, Engineering, Sales, etc.)
  - Edit and delete categories
  - Category descriptions

- **Job Positions** - `Setup/job_positions`
  - Define job positions
  - Link to categories
  - Position descriptions

#### 2. **User Management**
- **Manage Users** - `Setup/manage_users`
  - Add/edit/delete users
  - Assign roles (Admin, Recruiter)
  - Password management

- **Recruiters** - `Setup/manage_recruiters`
  - View all recruiters
  - See candidate counts
  - Performance metrics

- **Interviewers** - `Setup/manage_interviewers`
  - View all interviewers
  - Interview statistics
  - Role-based access

#### 3. **System**
- **Database** - `Setup/database`
  - View all tables
  - Table statistics
  - Row counts

- **Sample Data** - `Setup/sample_data`
  - Generate test candidates
  - Assign candidates to recruiters
  - Clear sample data

### 🔜 Coming Soon Modules

#### Communication
- Email Configuration (SMTP setup)
- SMS Settings (Gateway integration)
- WhatsApp Setup (Business API)
- Notification Center

#### Automation
- Workflow Builder
- Email Campaigns
- Assessment Settings
- Scoring Rules

#### Compliance (Sri Lankan Specific)
- EPF/ETF Settings
- Legal Templates
- Document Requirements
- Data Retention Policies

#### Integration
- Job Boards (LinkedIn, Indeed)
- Calendar Sync (Google, Outlook)
- API Management
- Webhooks

#### System
- Backup & Recovery
- Security Settings
- Audit Logs
- Roles & Permissions

---

## 📊 Database Tables Created

### 1. company_settings
Company profile and configuration
- Company name, logo, contact info
- Address details
- Legal information (registration, tax ID)
- Business hours
- Financial year settings

### 2. departments
Organizational structure
- Department name
- Department head
- Description

### 3. branches
Office locations
- Branch name and code
- Complete address
- Contact details
- Manager assignment

### 4. job_categories
Job classifications
- Category name
- Description

### 5. job_positions
Available positions
- Position name
- Linked to category
- Description

---

## 🎯 Access URLs

After installation, access these pages:

```
Main Setup Page:
http://localhost/rms/Setup

Core Configuration:
http://localhost/rms/Setup/company_settings
http://localhost/rms/Setup/job_categories
http://localhost/rms/Setup/job_positions

User Management:
http://localhost/rms/Setup/manage_users
http://localhost/rms/Setup/manage_recruiters
http://localhost/rms/Setup/manage_interviewers

System:
http://localhost/rms/Setup/database
http://localhost/rms/Setup/sample_data
```

---

## 🎨 Features

✨ **Modern UI Design**
- Categorized card layout
- Color-coded sections
- Smooth animations
- Responsive design

✨ **User Experience**
- SweetAlert2 confirmations
- Flash messages for feedback
- Modal-based forms
- Inline editing

✨ **Functionality**
- Full CRUD operations
- Image upload (company logo)
- Form validation
- Search and filter
- Sample data generation

---

## 🔧 Troubleshooting

### Tables Not Found Error
**Solution:** Run the installer at `http://localhost/rms/install_company_settings.php`

### Logo Upload Not Working
1. Create directory: `mkdir uploads\company`
2. Set permissions (Linux): `chmod 777 uploads/company`

### Permission Denied
- Ensure you're logged in as Admin
- Check session authentication

### Database Connection Error
- Verify XAMPP MySQL is running
- Check database name in config (should be `rmsdb`)
- Verify database credentials

---

## 📁 File Structure

```
application/
├── controllers/
│   └── Setup.php (all setup methods)
├── views/
│   └── Admin_dashboard_view/
│       └── Setup/
│           ├── index.php (main setup page)
│           ├── company_settings.php
│           ├── job_categories.php
│           ├── job_positions.php
│           ├── manage_users.php
│           ├── manage_recruiters.php
│           ├── manage_interviewers.php
│           ├── database.php
│           └── sample_data.php
database_migrations/
└── company_settings_tables.sql
uploads/
└── company/ (for logo uploads)
install_company_settings.php (run once, then delete)
```

---

## 🔐 Security Notes

- Only Admin users can access Setup pages
- File uploads restricted to images (2MB max)
- All inputs sanitized with htmlspecialchars()
- Delete operations require confirmation
- **Delete installer after use!**

---

## 🎓 Sample Data Included

### Job Categories (8)
- Information Technology
- Engineering
- Sales & Marketing
- Human Resources
- Finance & Accounting
- Operations
- Customer Service
- Design & Creative

### Job Positions (14)
- Software Engineer
- Frontend Developer
- Backend Developer
- Full Stack Developer
- DevOps Engineer
- QA Engineer
- Product Manager
- UI/UX Designer
- Sales Executive
- Marketing Manager
- HR Manager
- Accountant
- Operations Manager
- Customer Support Representative

### Departments (4)
- Human Resources
- Information Technology
- Finance
- Marketing

### Branches (2)
- Head Office
- Branch Office

---

## 📞 Support

For issues or questions:
1. Check this documentation
2. Review error messages
3. Check browser console for JavaScript errors
4. Verify database tables exist
5. Ensure proper permissions

---

## ✅ Installation Checklist

- [ ] Run installer or execute SQL
- [ ] Verify all 5 tables created
- [ ] Create uploads/company directory
- [ ] Delete install_company_settings.php
- [ ] Access Setup page successfully
- [ ] Test adding a job category
- [ ] Test adding a job position
- [ ] Upload company logo
- [ ] Add a department
- [ ] Add a branch

---

## 🎉 You're All Set!

Your System Setup is now fully configured and ready to use. Start by:
1. Updating company profile
2. Adding your job categories
3. Defining job positions
4. Setting up departments
5. Adding branch locations

Enjoy your comprehensive RMS System Setup! 🚀
