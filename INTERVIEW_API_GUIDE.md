# 🎯 Interview API - Complete Guide

## Quick Start: Conducting Recruitment Interviews

This guide walks you through setting up and managing recruitment interviews using the RMS API.

## 📋 Summary Table

| Step | API Endpoint | Purpose |
|------|--------------|---------|
| Create Interview Flow | `POST /api/interview-flows` | Define job details & interview questions |
| Create Interview & Link | `POST /api/interviews` | Generate unique link for candidate |
| Retrieve Interviews | `GET /api/interviews` | Fetch list & transcripts of interviews |
| Get Single Interview | `GET /api/interviews/:id` | Get detailed interview with responses |
| Update Status | `PUT /api/interviews/:id/status` | Update interview status |

## 🚀 Setup

### 1. Create Database Tables

Run the setup script:
```
http://localhost/rms/create_interview_tables.php
```

This creates:
- `interview_flows` - Interview templates
- `interviews` - Individual interview instances
- `interview_responses` - Candidate responses
- `interview_analytics` - Tracking data

### 2. Get API Key

For now, any API key works. In production, implement proper authentication.

## 📡 API Endpoints

### Base URL
```
http://localhost/rms/index.php/api/interview_api
```

### Authentication
Include API key in header:
```
Authorization: Bearer YOUR_API_KEY
```

Or as query parameter:
```
?api_key=YOUR_API_KEY
```

---

## 1️⃣ Create Interview Flow

Define your interview template with questions.

### Endpoint
```http
POST /api/interview_api/create_flow
```

### Request Body
```json
{
  "job_title": "Software Engineer",
  "job_description": "We are looking for a talented software engineer...",
  "questions": [
    {
      "id": 1,
      "question": "Tell us about yourself and your background.",
      "type": "open",
      "duration": 120
    },
    {
      "id": 2,
      "question": "Why are you interested in this position?",
      "type": "open",
      "duration": 90
    },
    {
      "id": 3,
      "question": "Describe a challenging project you worked on.",
      "type": "open",
      "duration": 120
    }
  ],
  "interview_type": "video",
  "enable_video_capture": true,
  "duration_minutes": 30,
  "passing_score": 70
}
```

### Parameters

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| job_title | string | Yes | Position title |
| job_description | string | No | Job details |
| questions | array | Yes | Array of question objects |
| interview_type | string | Yes | `video`, `audio`, or `text` |
| enable_video_capture | boolean | No | Enable video recording (default: false) |
| duration_minutes | integer | No | Total interview duration (default: 30) |
| passing_score | integer | No | Minimum score to pass (default: 70) |

### Response
```json
{
  "success": true,
  "message": "Interview flow created successfully",
  "data": {
    "id": 1,
    "job_title": "Software Engineer",
    "questions": [...],
    "interview_type": "video",
    "status": "active",
    "created_at": "2024-01-15 10:30:00"
  }
}
```

### cURL Example
```bash
curl -X POST http://localhost/rms/index.php/api/interview_api/create_flow \
  -H "Authorization: Bearer YOUR_API_KEY" \
  -H "Content-Type: application/json" \
  -d '{
    "job_title": "Software Engineer",
    "questions": [
      {
        "id": 1,
        "question": "Tell us about yourself",
        "type": "open",
        "duration": 120
      }
    ],
    "interview_type": "video",
    "enable_video_capture": true
  }'
```

---

## 2️⃣ Create Interview & Generate Link

Create an interview instance for a specific candidate.

### Endpoint
```http
POST /api/interview_api/create_interview
```

### Request Body
```json
{
  "flow_id": 1,
  "candidate_name": "John Doe",
  "candidate_email": "john@example.com",
  "candidate_phone": "+94771234567",
  "send_email": true
}
```

### Parameters

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| flow_id | integer | Yes | Interview flow ID |
| candidate_name | string | No | Candidate's full name |
| candidate_email | string | Yes | Candidate's email |
| candidate_phone | string | No | Candidate's phone |
| send_email | boolean | No | Send email with link (default: false) |

### Response
```json
{
  "success": true,
  "message": "Interview created successfully",
  "data": {
    "interview_id": 1,
    "token": "a1b2c3d4e5f6...",
    "interview_link": "http://localhost/rms/interview/take/a1b2c3d4e5f6...",
    "expires_at": "2024-01-22 10:30:00",
    "interview": {
      "id": 1,
      "flow_id": 1,
      "candidate_email": "john@example.com",
      "status": "pending",
      "created_at": "2024-01-15 10:30:00"
    }
  }
}
```

### cURL Example
```bash
curl -X POST http://localhost/rms/index.php/api/interview_api/create_interview \
  -H "Authorization: Bearer YOUR_API_KEY" \
  -H "Content-Type: application/json" \
  -d '{
    "flow_id": 1,
    "candidate_name": "John Doe",
    "candidate_email": "john@example.com",
    "send_email": true
  }'
```

---

## 3️⃣ Get Interview Flows

Retrieve all interview flows.

### Endpoint
```http
GET /api/interview_api/get_flows
```

### Query Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| status | string | Filter by status: `active`, `inactive`, `archived` |
| limit | integer | Results per page (default: 50) |
| offset | integer | Pagination offset (default: 0) |

### Response
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "job_title": "Software Engineer",
      "interview_type": "video",
      "status": "active",
      "created_at": "2024-01-15 10:30:00"
    }
  ],
  "pagination": {
    "total": 10,
    "limit": 50,
    "offset": 0
  }
}
```

### cURL Example
```bash
curl -X GET "http://localhost/rms/index.php/api/interview_api/get_flows?status=active&limit=10" \
  -H "Authorization: Bearer YOUR_API_KEY"
```

---

## 4️⃣ Get Interviews

Retrieve all interviews with optional filtering.

### Endpoint
```http
GET /api/interview_api/get_interviews
```

### Query Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| flow_id | integer | Filter by interview flow |
| status | string | Filter by status: `pending`, `in_progress`, `completed`, `cancelled`, `expired` |
| limit | integer | Results per page (default: 50) |
| offset | integer | Pagination offset (default: 0) |

### Response
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "flow_id": 1,
      "job_title": "Software Engineer",
      "candidate_name": "John Doe",
      "candidate_email": "john@example.com",
      "status": "completed",
      "score": 85,
      "completed_at": "2024-01-15 11:00:00",
      "created_at": "2024-01-15 10:30:00"
    }
  ],
  "pagination": {
    "total": 25,
    "limit": 50,
    "offset": 0
  }
}
```

### cURL Example
```bash
curl -X GET "http://localhost/rms/index.php/api/interview_api/get_interviews?flow_id=1&status=completed" \
  -H "Authorization: Bearer YOUR_API_KEY"
```

---

## 5️⃣ Get Single Interview with Transcript

Get detailed interview information including all responses.

### Endpoint
```http
GET /api/interview_api/get_interview/:id
```

### Response
```json
{
  "success": true,
  "data": {
    "id": 1,
    "flow_id": 1,
    "job_title": "Software Engineer",
    "candidate_name": "John Doe",
    "candidate_email": "john@example.com",
    "status": "completed",
    "score": 85,
    "started_at": "2024-01-15 10:35:00",
    "completed_at": "2024-01-15 11:00:00",
    "responses": [
      {
        "id": 1,
        "question_id": 1,
        "response_text": "I am a software engineer with 5 years of experience...",
        "response_video": "uploads/interviews/video_1.mp4",
        "duration_seconds": 120,
        "score": 90,
        "created_at": "2024-01-15 10:37:00"
      },
      {
        "id": 2,
        "question_id": 2,
        "response_text": "I am interested in this position because...",
        "response_video": "uploads/interviews/video_2.mp4",
        "duration_seconds": 85,
        "score": 80,
        "created_at": "2024-01-15 10:40:00"
      }
    ]
  }
}
```

### cURL Example
```bash
curl -X GET http://localhost/rms/index.php/api/interview_api/get_interview/1 \
  -H "Authorization: Bearer YOUR_API_KEY"
```

---

## 6️⃣ Update Interview Status

Update the status of an interview.

### Endpoint
```http
PUT /api/interview_api/update_status/:id
```

### Request Body
```json
{
  "status": "completed"
}
```

### Allowed Statuses
- `pending` - Interview not started
- `in_progress` - Interview in progress
- `completed` - Interview finished
- `cancelled` - Interview cancelled
- `expired` - Interview link expired

### Response
```json
{
  "success": true,
  "message": "Interview status updated successfully"
}
```

### cURL Example
```bash
curl -X PUT http://localhost/rms/index.php/api/interview_api/update_status/1 \
  -H "Authorization: Bearer YOUR_API_KEY" \
  -H "Content-Type: application/json" \
  -d '{"status": "completed"}'
```

---

## 🔒 Error Responses

### 400 Bad Request
```json
{
  "error": "Missing required field: job_title"
}
```

### 401 Unauthorized
```json
{
  "error": "Invalid API key"
}
```

### 404 Not Found
```json
{
  "error": "Interview flow not found"
}
```

### 500 Internal Server Error
```json
{
  "error": "Failed to create interview flow"
}
```

---

## 📊 Complete Workflow Example

### Step 1: Create Interview Flow
```bash
curl -X POST http://localhost/rms/index.php/api/interview_api/create_flow \
  -H "Authorization: Bearer test_key_123" \
  -H "Content-Type: application/json" \
  -d @interview_flow.json
```

### Step 2: Create Interview for Candidate
```bash
curl -X POST http://localhost/rms/index.php/api/interview_api/create_interview \
  -H "Authorization: Bearer test_key_123" \
  -H "Content-Type: application/json" \
  -d '{
    "flow_id": 1,
    "candidate_email": "candidate@example.com",
    "send_email": true
  }'
```

### Step 3: Candidate Completes Interview
Candidate clicks link and completes interview.

### Step 4: Retrieve Interview Results
```bash
curl -X GET http://localhost/rms/index.php/api/interview_api/get_interview/1 \
  -H "Authorization: Bearer test_key_123"
```

---

## 🧪 Testing

### Test Page
```
http://localhost/rms/test_interview_api.php
```

### Postman Collection
Import the provided Postman collection for easy testing.

---

## 📝 Notes

- Interview links expire after 7 days by default
- Video/audio files are stored in `uploads/interviews/`
- All timestamps are in server timezone
- Responses are automatically saved as candidate progresses

---

## 🎯 Best Practices

1. **Always validate** candidate email before creating interview
2. **Set appropriate** expiration times for interview links
3. **Monitor** interview completion rates
4. **Review** responses promptly
5. **Provide feedback** to candidates when possible

---

## 🔧 Troubleshooting

### Interview link not working
- Check if interview has expired
- Verify token is correct
- Ensure interview status is 'pending' or 'in_progress'

### API returns 401
- Check API key is included in request
- Verify Authorization header format

### Cannot create interview
- Ensure interview flow exists
- Check all required fields are provided
- Verify database tables are created

---

## 📞 Support

For issues or questions:
1. Check this documentation
2. Review error messages
3. Test with provided examples
4. Check database tables exist

---

**Made with ❤️ for efficient recruitment**
