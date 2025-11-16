# 🔌 RMS API Documentation - Part 2

## 4. Interview Scheduling APIs

### 4.1 Get Calendar Events

**Endpoint:** `POST /R_dashboard/get_events`

**Description:** Get all interview events for calendar display

**Authentication:** Required (Recruiter/Admin role)

**Example Request:**
```bash
curl -X POST http://localhost/rms/index.php/R_dashboard/get_events \
  -H "Cookie: ci_session=your_session_id"
```

**Success Response:**
```json
[
    {
        "id": 1,
        "Recruiter_username": "recruiter1",
        "Can_name": "John Doe",
        "Interviewer": "interviewer1",
        "start": "2025-11-15T14:00:00",
        "end": "2025-11-15T15:00:00",
        "interview_round": "Technical Round"
    },
    {
        "id": 2,
        "Recruiter_username": "recruiter1",
        "Can_name": "Jane Smith",
        "Interviewer": "interviewer2",
        "start": "2025-11-16T10:00:00",
        "end": "2025-11-16T11:00:00",
        "interview_round": "HR Round"
    }
]
```

---

### 4.2 Schedule Interview

**Endpoint:** `POST /R_dashboard/schedule_interview`

**Description:** Schedule a new interview

**Authentication:** Required (Recruiter/Admin role)

**Request Body:**
```
ce_can_name: string (required)
ce_interviewer: string (required)
ce_start_date: datetime (required)
ce_end_date: datetime (required)
ce_interview_round: string (required)
ce_rec_username: string (required)
```

**Example Request:**
```bash
curl -X POST http://localhost/rms/index.php/R_dashboard/schedule_interview \
  -H "Cookie: ci_session=your_session_id" \
  -F "ce_can_name=John Doe" \
  -F "ce_interviewer=interviewer1" \
  -F "ce_start_date=2025-11-15 14:00:00" \
  -F "ce_end_date=2025-11-15 15:00:00" \
  -F "ce_interview_round=Technical Round" \
  -F "ce_rec_username=recruiter1"
```

**Success Response:**
```json
{
    "success": true,
    "message": "Interview scheduled successfully",
    "event_id": 123
}
```

---

### 4.3 Update Interview

**Endpoint:** `POST /R_dashboard/update_interview`

**Description:** Update existing interview

**Authentication:** Required (Recruiter/Admin role)

**Request Body:**
```json
{
    "ce_id": 123,
    "ce_start_date": "2025-11-15 15:00:00",
    "ce_end_date": "2025-11-15 16:00:00",
    "ce_interviewer": "interviewer2"
}
```

**Example Request:**
```bash
curl -X POST http://localhost/rms/index.php/R_dashboard/update_interview \
  -H "Content-Type: application/json" \
  -H "Cookie: ci_session=your_session_id" \
  -d '{"ce_id":123,"ce_start_date":"2025-11-15 15:00:00","ce_end_date":"2025-11-15 16:00:00"}'
```

**Success Response:**
```json
{
    "success": true,
    "message": "Interview updated successfully"
}
```

---

### 4.4 Delete Interview

**Endpoint:** `POST /R_dashboard/delete_interview`

**Description:** Cancel/delete an interview

**Authentication:** Required (Recruiter/Admin role)

**Request Body:**
```json
{
    "ce_id": 123
}
```

**Example Request:**
```bash
curl -X POST http://localhost/rms/index.php/R_dashboard/delete_interview \
  -H "Content-Type: application/json" \
  -H "Cookie: ci_session=your_session_id" \
  -d '{"ce_id":123}'
```

**Success Response:**
```json
{
    "success": true,
    "message": "Interview deleted successfully"
}
```



---

## 5. User Management APIs

### 5.1 Add User

**Endpoint:** `POST /Setup/add_user`

**Description:** Create a new user account

**Authentication:** Required (Admin role)

**Request Body:**
```
username: string (required)
email: string (required)
password: string (required)
role: string (required) - Admin|Recruiter|Interviewer|Candidate
status: string (required) - Active|Pending|Inactive
```

**Example Request:**
```bash
curl -X POST http://localhost/rms/index.php/Setup/add_user \
  -H "Cookie: ci_session=your_session_id" \
  -F "username=newuser" \
  -F "email=newuser@example.com" \
  -F "password=password123" \
  -F "role=Recruiter" \
  -F "status=Active"
```

**Success Response:**
```json
{
    "success": true,
    "message": "User added successfully",
    "user_id": 456
}
```

**Error Response:**
```json
{
    "success": false,
    "message": "Username already exists"
}
```

---

### 5.2 Update User

**Endpoint:** `POST /Setup/update_user`

**Description:** Update existing user

**Authentication:** Required (Admin role)

**Request Body:**
```json
{
    "user_id": 456,
    "email": "updated@example.com",
    "role": "Interviewer",
    "status": "Active"
}
```

**Example Request:**
```bash
curl -X POST http://localhost/rms/index.php/Setup/update_user \
  -H "Content-Type: application/json" \
  -H "Cookie: ci_session=your_session_id" \
  -d '{"user_id":456,"email":"updated@example.com","role":"Interviewer"}'
```

**Success Response:**
```json
{
    "success": true,
    "message": "User updated successfully"
}
```

---

### 5.3 Delete User

**Endpoint:** `GET /Setup/delete_user/{user_id}`

**Description:** Delete a user account

**Authentication:** Required (Admin role)

**URL Parameters:**
```
user_id: integer (user ID)
```

**Example Request:**
```bash
curl http://localhost/rms/index.php/Setup/delete_user/456 \
  -H "Cookie: ci_session=your_session_id"
```

**Success Response:**
```
HTTP 302 Redirect to user list
Flash Message: "User deleted successfully"
```

---

### 5.4 Toggle User Status

**Endpoint:** `GET /Setup/toggle_user_status/{user_id}`

**Description:** Activate/Deactivate user account

**Authentication:** Required (Admin role)

**URL Parameters:**
```
user_id: integer (user ID)
```

**Example Request:**
```bash
curl http://localhost/rms/index.php/Setup/toggle_user_status/456 \
  -H "Cookie: ci_session=your_session_id"
```

**Success Response:**
```json
{
    "success": true,
    "message": "User status updated",
    "new_status": "Active"
}
```



---

## 6. Setup & Configuration APIs

### 6.1 Get Google OAuth Configuration

**Endpoint:** `GET /Setup/google_oauth_config`

**Description:** Get current Google OAuth settings

**Authentication:** Required (Admin role)

**Example Request:**
```bash
curl http://localhost/rms/index.php/Setup/google_oauth_config \
  -H "Cookie: ci_session=your_session_id"
```

**Response:** HTML view with configuration form

---

### 6.2 Save Google OAuth Configuration

**Endpoint:** `POST /Setup/save_google_oauth_config`

**Description:** Update Google OAuth settings

**Authentication:** Required (Admin role)

**Request Body:**
```
client_id: string (required)
client_secret: string (required)
is_enabled: boolean (0 or 1)
auto_activate_users: boolean (0 or 1)
default_role: string (Candidate|Recruiter|Interviewer)
```

**Example Request:**
```bash
curl -X POST http://localhost/rms/index.php/Setup/save_google_oauth_config \
  -H "Cookie: ci_session=your_session_id" \
  -F "client_id=123456789.apps.googleusercontent.com" \
  -F "client_secret=GOCSPX-abc123" \
  -F "is_enabled=1" \
  -F "auto_activate_users=1" \
  -F "default_role=Candidate"
```

**Success Response:**
```
HTTP 302 Redirect to config page
Flash Message: "Google OAuth configuration saved successfully!"
```

---

### 6.3 Test Google OAuth

**Endpoint:** `GET /Setup/test_google_oauth`

**Description:** Test Google OAuth configuration

**Authentication:** Required (Admin role)

**Example Request:**
```bash
curl http://localhost/rms/index.php/Setup/test_google_oauth \
  -H "Cookie: ci_session=your_session_id"
```

**Success Response:**
```json
{
    "success": true,
    "message": "Configuration looks good! Click the button below to test login.",
    "auth_url": "https://accounts.google.com/o/oauth2/v2/auth?..."
}
```

**Error Response:**
```json
{
    "success": false,
    "message": "Please configure Client ID and Client Secret first."
}
```



---

## 7. Audit Log APIs

### 7.1 Get Audit Logs

**Endpoint:** `GET /Setup/audit_logs`

**Description:** Retrieve audit logs with filtering

**Authentication:** Required (Admin role)

**Query Parameters:**
```
from_date: date (optional) - YYYY-MM-DD
to_date: date (optional) - YYYY-MM-DD
action: string (optional) - CREATE|UPDATE|DELETE|LOGIN|LOGOUT
user_id: integer (optional)
resource_type: string (optional) - candidate|interview|user
```

**Example Request:**
```bash
curl "http://localhost/rms/index.php/Setup/audit_logs?from_date=2025-11-01&action=CREATE" \
  -H "Cookie: ci_session=your_session_id"
```

**Response:** HTML view with filtered audit logs

---

### 7.2 Export Audit Logs

**Endpoint:** `POST /Setup/export_audit_logs`

**Description:** Export audit logs to CSV

**Authentication:** Required (Admin role)

**Request Body:**
```json
{
    "from_date": "2025-11-01",
    "to_date": "2025-11-30",
    "action": "CREATE"
}
```

**Example Request:**
```bash
curl -X POST http://localhost/rms/index.php/Setup/export_audit_logs \
  -H "Content-Type: application/json" \
  -H "Cookie: ci_session=your_session_id" \
  -d '{"from_date":"2025-11-01","to_date":"2025-11-30"}'
```

**Success Response:**
```
Content-Type: text/csv
Content-Disposition: attachment; filename="audit_logs_2025-11-14.csv"

CSV file download
```

---

### 7.3 View Audit Log Details

**Endpoint:** `GET /Setup/audit_log_details/{log_id}`

**Description:** Get detailed information about a specific audit log entry

**Authentication:** Required (Admin role)

**URL Parameters:**
```
log_id: integer (audit log ID)
```

**Example Request:**
```bash
curl http://localhost/rms/index.php/Setup/audit_log_details/789 \
  -H "Cookie: ci_session=your_session_id"
```

**Success Response:**
```json
{
    "id": 789,
    "user_id": 123,
    "username": "admin",
    "action": "UPDATE",
    "resource_type": "candidate",
    "resource_id": 456,
    "old_values": {
        "cd_status": "In Progress"
    },
    "new_values": {
        "cd_status": "Selected"
    },
    "ip_address": "192.168.1.100",
    "user_agent": "Mozilla/5.0...",
    "created_at": "2025-11-14 10:30:00"
}
```



---

## 8. Report APIs

### 8.1 Generate Report

**Endpoint:** `GET /A_dashboard/generate_report/{report_type}`

**Description:** Generate and download various reports

**Authentication:** Required (Admin/Recruiter role)

**URL Parameters:**
```
report_type: string (required)
  - all_candidates
  - selected_candidates
  - candidates_by_status
  - candidates_by_source
  - all_interviews
  - upcoming_interviews
  - interviews_by_interviewer
  - recruiter_performance
  - all_recruiters
```

**Example Request:**
```bash
curl http://localhost/rms/index.php/A_dashboard/generate_report/all_candidates \
  -H "Cookie: ci_session=your_session_id"
```

**Success Response:**
```
Content-Type: text/csv
Content-Disposition: attachment; filename="all_candidates_2025-11-14_103000.csv"

CSV file download
```

---

### 8.2 Get Report Statistics

**Endpoint:** `GET /A_dashboard/reports_view`

**Description:** Get statistics for reports dashboard

**Authentication:** Required (Admin/Recruiter role)

**Example Request:**
```bash
curl http://localhost/rms/index.php/A_dashboard/reports_view \
  -H "Cookie: ci_session=your_session_id"
```

**Response Data:**
```php
{
    "total_candidates": 1234,
    "total_interviews": 567,
    "total_recruiters": 15,
    "total_interviewers": 20,
    "selected_candidates": 45,
    "pending_interviews": 23
}
```

