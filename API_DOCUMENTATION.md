# 🔌 RMS API Documentation

## Overview

The Recruitment Management System (RMS) provides a RESTful API for managing recruitment operations. This documentation covers all available endpoints, authentication methods, request/response formats, and usage examples.

## Base URL

```
Development: http://localhost/rms/index.php
Production:  https://yourdomain.com/index.php
```

## Authentication

### Session-Based Authentication

All API endpoints require active session authentication. Users must login first to obtain a valid session.

**Session Data Structure:**
```php
{
    "id": 123,
    "username": "johndoe",
    "email": "john@example.com",
    "full_name": "John Doe",
    "Role": "Admin",
    "authenticated": true,
    "google_login": false
}
```

### Authentication Check

Before accessing any protected endpoint, the system verifies:
1. Session exists and is valid
2. User is authenticated
3. User has appropriate role/permissions

**Unauthorized Response:**
```
HTTP 302 Redirect to /Login
```

## Response Formats

### Success Response
```json
{
    "success": true,
    "message": "Operation completed successfully",
    "data": { }
}
```

### Error Response
```json
{
    "success": false,
    "message": "Error description",
    "errors": []
}
```



## API Endpoints

---

## 1. Authentication APIs

### 1.1 User Login

**Endpoint:** `POST /Login/loginproc`

**Description:** Authenticate user with username and password

**Request Body:**
```
username: string (required)
userpass: string (required)
```

**Example Request:**
```bash
curl -X POST http://localhost/rms/index.php/Login/loginproc \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "username=admin&userpass=admin123"
```

**Success Response:**
```
HTTP 302 Redirect to appropriate dashboard based on role
- Admin: /A_dashboard
- Recruiter: /R_dashboard
- Interviewer: /I_dashboard
- Candidate: /C_dashboard
```

**Error Responses:**
```
Flash Message: "Invalid Username and Password"
Flash Message: "Wrong Password. Try again or click Forgot password to reset it"
Flash Message: "Account is not activated. Please contact administrator."
```

---

### 1.2 Google OAuth Login

**Endpoint:** `GET /Login/google_login`

**Description:** Initiate Google OAuth authentication flow

**Example Request:**
```bash
curl http://localhost/rms/index.php/Login/google_login
```

**Response:**
```
HTTP 302 Redirect to Google OAuth consent screen
```

---

### 1.3 Google OAuth Callback

**Endpoint:** `GET /Login/google_callback`

**Description:** Handle Google OAuth callback and create/login user

**Query Parameters:**
```
code: string (OAuth authorization code from Google)
```

**Example Request:**
```
http://localhost/rms/index.php/Login/google_callback?code=4/0AX4XfWh...
```

**Success Response:**
```
HTTP 302 Redirect to dashboard based on user role
Session created with user data
```

---

### 1.4 Logout

**Endpoint:** `GET /Login/logout`

**Description:** Destroy user session and logout

**Example Request:**
```bash
curl http://localhost/rms/index.php/Login/logout
```

**Response:**
```
HTTP 302 Redirect to /Login
Session destroyed
```



---

## 2. Dashboard APIs

### 2.1 Get Admin Dashboard

**Endpoint:** `GET /A_dashboard`

**Description:** Get admin dashboard data with statistics

**Authentication:** Required (Admin role)

**Example Request:**
```bash
curl http://localhost/rms/index.php/A_dashboard \
  -H "Cookie: ci_session=your_session_id"
```

**Response Data:**
```php
{
    "uname": "admin",
    "greeting": "Good Morning",
    "can_selected": 45,
    "int_not_selected": 89,
    "interested_can": 67,
    "rtotal": 201,
    "can_details": [...],
    "sel_can": [...]
}
```

---

### 2.2 Global Search

**Endpoint:** `POST /A_dashboard/global_search`

**Description:** Search across candidates, jobs, and interviews

**Authentication:** Required

**Request Body:**
```json
{
    "query": "search term"
}
```

**Example Request:**
```bash
curl -X POST http://localhost/rms/index.php/A_dashboard/global_search \
  -H "Content-Type: application/json" \
  -H "Cookie: ci_session=your_session_id" \
  -d '{"query":"john"}'
```

**Success Response:**
```json
{
    "candidates": [
        {
            "name": "John Doe",
            "email": "john@example.com",
            "phone": "555-1234",
            "status": "Selected"
        }
    ],
    "jobs": [
        {
            "title": "Software Engineer",
            "department": "Engineering"
        }
    ],
    "interviews": [
        {
            "candidate": "John Smith",
            "interviewer": "Jane Doe",
            "date": "2025-11-15"
        }
    ]
}
```

---

### 2.3 Get Notifications

**Endpoint:** `GET /A_dashboard/get_notifications`

**Description:** Get user notifications

**Authentication:** Required

**Example Request:**
```bash
curl http://localhost/rms/index.php/A_dashboard/get_notifications \
  -H "Cookie: ci_session=your_session_id"
```

**Success Response:**
```json
[
    {
        "id": 1,
        "type": "candidate",
        "title": "New Application",
        "message": "John Doe applied for Software Engineer",
        "link": "/candidates/view/123",
        "is_read": 0,
        "time_ago": "5 minutes ago"
    },
    {
        "id": 2,
        "type": "interview",
        "title": "Interview Scheduled",
        "message": "Interview with Jane Smith at 2 PM",
        "link": "/calendar/view/456",
        "is_read": 0,
        "time_ago": "1 hour ago"
    }
]
```

---

### 2.4 Mark Notification as Read

**Endpoint:** `POST /A_dashboard/mark_notification_read`

**Description:** Mark a notification as read

**Authentication:** Required

**Request Body:**
```json
{
    "notification_id": 1
}
```

**Example Request:**
```bash
curl -X POST http://localhost/rms/index.php/A_dashboard/mark_notification_read \
  -H "Content-Type: application/json" \
  -H "Cookie: ci_session=your_session_id" \
  -d '{"notification_id":1}'
```

**Success Response:**
```json
{
    "success": true,
    "message": "Notification marked as read"
}
```



---

## 3. Candidate Management APIs

### 3.1 List Candidates

**Endpoint:** `GET /R_dashboard/Rcandidate_view`

**Description:** Get list of all candidates

**Authentication:** Required (Recruiter/Admin role)

**Example Request:**
```bash
curl http://localhost/rms/index.php/R_dashboard/Rcandidate_view \
  -H "Cookie: ci_session=your_session_id"
```

**Response:** HTML view with candidate data

---

### 3.2 Add Candidate

**Endpoint:** `POST /R_dashboard/add_candidate`

**Description:** Create a new candidate

**Authentication:** Required (Recruiter/Admin role)

**Request Body:**
```
cd_name: string (required)
cd_email: string (required)
cd_phone: string (required)
cd_gender: string (required)
cd_job_title: string (required)
cd_source: string (required)
cd_description: text (optional)
```

**Example Request:**
```bash
curl -X POST http://localhost/rms/index.php/R_dashboard/add_candidate \
  -H "Cookie: ci_session=your_session_id" \
  -F "cd_name=John Doe" \
  -F "cd_email=john@example.com" \
  -F "cd_phone=555-1234" \
  -F "cd_gender=Male" \
  -F "cd_job_title=Software Engineer" \
  -F "cd_source=LinkedIn" \
  -F "cd_description=Experienced developer"
```

**Success Response:**
```
HTTP 302 Redirect to candidate list
Flash Message: "Candidate added successfully"
```

**Error Response:**
```
Flash Message: "Failed to add candidate"
```

---

### 3.3 Update Candidate

**Endpoint:** `POST /R_dashboard/update_candidate`

**Description:** Update existing candidate

**Authentication:** Required (Recruiter/Admin role)

**Request Body:**
```
cd_id: integer (required)
cd_name: string (required)
cd_email: string (required)
cd_phone: string (required)
cd_gender: string (required)
cd_job_title: string (required)
cd_status: string (required)
```

**Example Request:**
```bash
curl -X POST http://localhost/rms/index.php/R_dashboard/update_candidate \
  -H "Cookie: ci_session=your_session_id" \
  -F "cd_id=123" \
  -F "cd_name=John Doe" \
  -F "cd_email=john@example.com" \
  -F "cd_phone=555-1234" \
  -F "cd_gender=Male" \
  -F "cd_job_title=Senior Software Engineer" \
  -F "cd_status=Selected"
```

**Success Response:**
```json
{
    "success": true,
    "message": "Candidate updated successfully"
}
```

---

### 3.4 Delete Candidate

**Endpoint:** `GET /R_dashboard/delete_candidate/{id}`

**Description:** Delete a candidate

**Authentication:** Required (Recruiter/Admin role)

**URL Parameters:**
```
id: integer (candidate ID)
```

**Example Request:**
```bash
curl -X GET http://localhost/rms/index.php/R_dashboard/delete_candidate/123 \
  -H "Cookie: ci_session=your_session_id"
```

**Success Response:**
```
HTTP 302 Redirect to candidate list
Flash Message: "Candidate deleted successfully"
```

---

### 3.5 Get Candidate Details

**Endpoint:** `POST /A_dashboard/get_candidate_details`

**Description:** Get detailed information about a candidate

**Authentication:** Required

**Request Body:**
```json
{
    "candidate_id": 123
}
```

**Example Request:**
```bash
curl -X POST http://localhost/rms/index.php/A_dashboard/get_candidate_details \
  -H "Content-Type: application/json" \
  -H "Cookie: ci_session=your_session_id" \
  -d '{"candidate_id":123}'
```

**Success Response:**
```json
{
    "success": true,
    "candidate": {
        "cd_id": 123,
        "cd_name": "John Doe",
        "cd_email": "john@example.com",
        "cd_phone": "555-1234",
        "cd_gender": "Male",
        "cd_job_title": "Software Engineer",
        "cd_status": "Selected",
        "cd_source": "LinkedIn",
        "cd_description": "Experienced developer",
        "cd_created_at": "2025-11-01 10:30:00"
    }
}
```

