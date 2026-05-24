# Recruitment Management System (RMS)

## 🎯 Latest Updates - May 24, 2026

### ✅ Recent Fixes Applied

1. **File Upload Extensions** - Files now download with proper extensions (.pdf, .doc, etc.)
2. **Candidate Visibility** - Self-registered candidates now appear in admin's Schedule Interview

See `FIXES_APPLIED.md` for details.

---

## 📁 Project Structure

```
rms/
├── application/          # CodeIgniter application files
│   ├── controllers/      # Application controllers
│   ├── models/          # Database models
│   ├── views/           # View templates
│   └── config/          # Configuration files
├── uploads/             # Uploaded files
│   ├── candidate_documents/  # Candidate CVs and documents
│   └── profile_pictures/     # User profile pictures
├── resources/           # Documentation and SQL scripts
│   ├── README.md        # Resources documentation
│   ├── *.sql           # Database scripts
│   └── *.md            # Documentation files
└── README.md           # This file
```

---

## 🚀 Quick Start

### 1. Database Setup
```
Database: cmsadver_rmsdb
Import: resources/setup_viva_data_simple.sql (for demo data)
```

### 2. Fix Existing Candidates (One Time)
```sql
-- Run in phpMyAdmin
-- File: resources/fix_existing_candidates.sql
```

### 3. Access URLs
```
Main URL: http://localhost/rms/
Admin Dashboard: http://localhost/rms/A_dashboard
Candidate Dashboard: http://localhost/rms/C_dashboard
Schedule Interview: http://localhost/rms/Interview/schedule
```

---

## 👥 User Roles

- **Admin** - Full system access
- **Recruiter** - Manage candidates and interviews
- **Interviewer** - Conduct interviews and provide feedback
- **Candidate** - Apply for jobs and track applications

---

## 📚 Documentation

All documentation is organized in the `resources/` folder:

- **Complete Guides:** ALL_FIXES_COMPLETE.md, VIVA_PREPARATION_GUIDE.md
- **Quick References:** QUICK_FIX_GUIDE.txt, VIVA_QUICK_REFERENCE.txt
- **SQL Scripts:** fix_existing_candidates.sql, setup_viva_data_simple.sql
- **Testing:** TESTING_CHECKLIST.txt

---

## 🔧 Recent Technical Changes

### Modified Files
- `application/controllers/C_dashboard.php` - File upload/download fixes
- `application/models/Signup_model.php` - Candidate registration fix

### Database Changes
- Candidates now added to both `users` and `candidate_details` tables

---

## 🧪 Testing

1. **File Upload:** Test at `C_dashboard/documents`
2. **Candidate Visibility:** Test at `Interview/schedule`
3. **New Registration:** Test at `Login/signup`

---

## 📞 Support

For issues or questions, refer to documentation in `resources/` folder.

---

**Version:** 1.0
**Last Updated:** May 24, 2026
**Status:** ✅ Production Ready
