# ⚡ RMS API Quick Reference

## Base URL
```
http://localhost/rms/index.php
```

## Authentication
All endpoints require session-based authentication (except login endpoints).

---

## Quick Reference Table

| Category | Method | Endpoint | Auth Required |
|----------|--------|----------|---------------|
| **Authentication** |
| Login | POST | `/Login/loginproc` | No |
| Google Login | GET | `/Login/google_login` | No |
| Logout | GET | `/Login/logout` | Yes |
| **Dashboard** |
| Admin Dashboard | GET | `/A_dashboard` | Yes (Admin) |
| Global Search | POST | `/A_dashboard/global_search` | Yes |
| Get Notifications | GET | `/A_dashboard/get_notifications` | Yes |
| Mark Read | POST | `/A_dashboard/mark_notification_read` | Yes |
| **Candidates** |
| List Candidates | GET | `/R_dashboard/Rcandidate_view` | Yes |
| Add Candidate | POST | `/R_dashboard/add_candidate` | Yes |
| Update Candidate | POST | `/R_dashboard/update_candidate` | Yes |
| Delete Candidate | GET | `/R_dashboard/delete_candidate/{id}` | Yes |
| Get Details | POST | `/A_dashboard/get_candidate_details` | Yes |
| **Interviews** |
| Get Events | POST | `/R_dashboard/get_events` | Yes |
| Schedule | POST | `/R_dashboard/schedule_interview` | Yes |
| Update | POST | `/R_dashboard/update_interview` | Yes |
| Delete | POST | `/R_dashboard/delete_interview` | Yes |
| **Users** |
| Add User | POST | `/Setup/add_user` | Yes (Admin) |
| Update User | POST | `/Setup/update_user` | Yes (Admin) |
| Delete User | GET | `/Setup/delete_user/{id}` | Yes (Admin) |
| Toggle Status | GET | `/Setup/toggle_user_status/{id}` | Yes (Admin) |
| **Setup** |
| OAuth Config | GET | `/Setup/google_oauth_config` | Yes (Admin) |
| Save OAuth | POST | `/Setup/save_google_oauth_config` | Yes (Admin) |
| Test OAuth | GET | `/Setup/test_google_oauth` | Yes (Admin) |
| **Audit Logs** |
| View Logs | GET | `/Setup/audit_logs` | Yes (Admin) |
| Export Logs | POST | `/Setup/export_audit_logs` | Yes (Admin) |
| Log Details | GET | `/Setup/audit_log_details/{id}` | Yes (Admin) |
| **Reports** |
| Generate Report | GET | `/A_dashboard/generate_report/{type}` | Yes |
| Report Stats | GET | `/A_dashboard/reports_view` | Yes |

---

## Common Request Examples

### Login
```bash
curl -X POST http://localhost/rms/index.php/Login/loginproc \
  -d "username=admin&userpass=admin123" \
  -c cookies.txt
```

### Add Candidate
```bash
curl -X POST http://localhost/rms/index.php/R_dashboard/add_candidate \
  -b cookies.txt \
  -F "cd_name=John Doe" \
  -F "cd_email=john@example.com" \
  -F "cd_phone=555-1234"
```

### Search
```bash
curl -X POST http://localhost/rms/index.php/A_dashboard/global_search \
  -b cookies.txt \
  -H "Content-Type: application/json" \
  -d '{"query":"john"}'
```

### Get Notifications
```bash
curl http://localhost/rms/index.php/A_dashboard/get_notifications \
  -b cookies.txt
```

---

## Response Codes

| Code | Meaning |
|------|---------|
| 200 | Success |
| 302 | Redirect (usually success) |
| 401 | Not authenticated |
| 403 | No permission |
| 404 | Not found |
| 500 | Server error |

---

## Common Parameters

### Candidate Fields
```
cd_name: string (required)
cd_email: string (required)
cd_phone: string (required)
cd_gender: string (required)
cd_job_title: string (required)
cd_source: string (required)
cd_description: text (optional)
cd_status: string (optional)
```

### Interview Fields
```
ce_can_name: string (required)
ce_interviewer: string (required)
ce_start_date: datetime (required)
ce_end_date: datetime (required)
ce_interview_round: string (required)
ce_rec_username: string (required)
```

### User Fields
```
username: string (required)
email: string (required)
password: string (required)
role: string (required) - Admin|Recruiter|Interviewer|Candidate
status: string (required) - Active|Pending|Inactive
```

---

## Full Documentation

For complete API documentation with detailed examples, see:
- **API_DOCUMENTATION.md** - Main API reference
- **API_DOCUMENTATION_PART2.md** - Additional endpoints
- **API_REFERENCE_GUIDE.md** - Usage examples and best practices

---

**Version:** 2.1  
**Updated:** November 14, 2025
