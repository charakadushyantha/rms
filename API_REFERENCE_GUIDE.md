# 📖 RMS API Reference Guide

## Quick Start

### 1. Authentication Flow

```javascript
// Step 1: Login
fetch('http://localhost/rms/index.php/Login/loginproc', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: 'username=admin&userpass=admin123',
    credentials: 'include' // Important for session cookies
})
.then(response => {
    if (response.redirected) {
        console.log('Login successful, redirected to:', response.url);
    }
});

// Step 2: Make authenticated requests
fetch('http://localhost/rms/index.php/A_dashboard/get_notifications', {
    credentials: 'include' // Include session cookie
})
.then(response => response.json())
.then(data => console.log(data));
```

---

## Common Use Cases

### Use Case 1: Add a Candidate

```javascript
const formData = new FormData();
formData.append('cd_name', 'John Doe');
formData.append('cd_email', 'john@example.com');
formData.append('cd_phone', '555-1234');
formData.append('cd_gender', 'Male');
formData.append('cd_job_title', 'Software Engineer');
formData.append('cd_source', 'LinkedIn');
formData.append('cd_description', 'Experienced developer');

fetch('http://localhost/rms/index.php/R_dashboard/add_candidate', {
    method: 'POST',
    body: formData,
    credentials: 'include'
})
.then(response => {
    console.log('Candidate added successfully');
});
```

---

### Use Case 2: Schedule an Interview

```javascript
const interviewData = new FormData();
interviewData.append('ce_can_name', 'John Doe');
interviewData.append('ce_interviewer', 'interviewer1');
interviewData.append('ce_start_date', '2025-11-15 14:00:00');
interviewData.append('ce_end_date', '2025-11-15 15:00:00');
interviewData.append('ce_interview_round', 'Technical Round');
interviewData.append('ce_rec_username', 'recruiter1');

fetch('http://localhost/rms/index.php/R_dashboard/schedule_interview', {
    method: 'POST',
    body: interviewData,
    credentials: 'include'
})
.then(response => response.json())
.then(data => console.log('Interview scheduled:', data));
```

---

### Use Case 3: Search Globally

```javascript
fetch('http://localhost/rms/index.php/A_dashboard/global_search', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify({ query: 'john' }),
    credentials: 'include'
})
.then(response => response.json())
.then(data => {
    console.log('Candidates:', data.candidates);
    console.log('Jobs:', data.jobs);
    console.log('Interviews:', data.interviews);
});
```



---

## PHP Examples

### Example 1: Using cURL in PHP

```php
<?php
// Initialize cURL session
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, 'http://localhost/rms/index.php/Login/loginproc');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'username' => 'admin',
    'userpass' => 'admin123'
]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt'); // Save cookies
curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt'); // Use cookies

// Execute request
$response = curl_exec($ch);
curl_close($ch);

// Make authenticated request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/rms/index.php/A_dashboard/get_notifications');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt'); // Use saved cookies

$notifications = curl_exec($ch);
curl_close($ch);

echo $notifications;
?>
```

---

### Example 2: Add Candidate with PHP

```php
<?php
$ch = curl_init();

$candidateData = [
    'cd_name' => 'John Doe',
    'cd_email' => 'john@example.com',
    'cd_phone' => '555-1234',
    'cd_gender' => 'Male',
    'cd_job_title' => 'Software Engineer',
    'cd_source' => 'LinkedIn',
    'cd_description' => 'Experienced developer'
];

curl_setopt($ch, CURLOPT_URL, 'http://localhost/rms/index.php/R_dashboard/add_candidate');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($candidateData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt');

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);

if ($httpCode == 302) {
    echo "Candidate added successfully!";
} else {
    echo "Failed to add candidate";
}
?>
```

---

## Python Examples

### Example 1: Using Requests Library

```python
import requests

# Create session to maintain cookies
session = requests.Session()

# Login
login_data = {
    'username': 'admin',
    'userpass': 'admin123'
}

response = session.post(
    'http://localhost/rms/index.php/Login/loginproc',
    data=login_data
)

if response.history:
    print('Login successful')

# Get notifications
notifications = session.get(
    'http://localhost/rms/index.php/A_dashboard/get_notifications'
)

print(notifications.json())
```

---

### Example 2: Add Candidate with Python

```python
import requests

session = requests.Session()

# Login first
session.post(
    'http://localhost/rms/index.php/Login/loginproc',
    data={'username': 'admin', 'userpass': 'admin123'}
)

# Add candidate
candidate_data = {
    'cd_name': 'John Doe',
    'cd_email': 'john@example.com',
    'cd_phone': '555-1234',
    'cd_gender': 'Male',
    'cd_job_title': 'Software Engineer',
    'cd_source': 'LinkedIn',
    'cd_description': 'Experienced developer'
}

response = session.post(
    'http://localhost/rms/index.php/R_dashboard/add_candidate',
    data=candidate_data
)

if response.status_code == 200:
    print('Candidate added successfully')
```

---

### Example 3: Global Search with Python

```python
import requests
import json

session = requests.Session()

# Login
session.post(
    'http://localhost/rms/index.php/Login/loginproc',
    data={'username': 'admin', 'userpass': 'admin123'}
)

# Search
search_response = session.post(
    'http://localhost/rms/index.php/A_dashboard/global_search',
    json={'query': 'john'},
    headers={'Content-Type': 'application/json'}
)

results = search_response.json()
print('Candidates:', results.get('candidates', []))
print('Jobs:', results.get('jobs', []))
print('Interviews:', results.get('interviews', []))
```



---

## Error Handling

### Common HTTP Status Codes

| Code | Meaning | Description |
|------|---------|-------------|
| 200 | OK | Request successful |
| 302 | Redirect | Successful operation, redirecting |
| 400 | Bad Request | Invalid request parameters |
| 401 | Unauthorized | Not authenticated |
| 403 | Forbidden | Insufficient permissions |
| 404 | Not Found | Resource not found |
| 500 | Server Error | Internal server error |

### Error Response Examples

**Authentication Error:**
```
HTTP 302 Redirect to /Login
Flash Message: "Please login to continue"
```

**Validation Error:**
```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "cd_email": "Email is required",
        "cd_phone": "Phone number is invalid"
    }
}
```

**Permission Error:**
```json
{
    "success": false,
    "message": "You don't have permission to perform this action"
}
```

---

## Rate Limiting

Currently, the RMS API does not implement rate limiting. For production deployments, consider implementing:

- Request throttling per user/IP
- API key authentication
- Rate limit headers
- Quota management

---

## Best Practices

### 1. Session Management
```javascript
// Always include credentials for session cookies
fetch(url, {
    credentials: 'include'
});
```

### 2. Error Handling
```javascript
fetch(url)
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .catch(error => {
        console.error('API Error:', error);
    });
```

### 3. Data Validation
```javascript
// Validate data before sending
function validateCandidate(data) {
    if (!data.cd_email || !data.cd_email.includes('@')) {
        throw new Error('Invalid email');
    }
    if (!data.cd_phone || data.cd_phone.length < 10) {
        throw new Error('Invalid phone number');
    }
    return true;
}
```

### 4. Timeout Handling
```javascript
const controller = new AbortController();
const timeoutId = setTimeout(() => controller.abort(), 5000);

fetch(url, {
    signal: controller.signal,
    credentials: 'include'
})
.then(response => response.json())
.finally(() => clearTimeout(timeoutId));
```

---

## Security Considerations

### 1. HTTPS in Production
Always use HTTPS in production to encrypt data in transit:
```
https://yourdomain.com/index.php/...
```

### 2. CSRF Protection
CodeIgniter provides built-in CSRF protection. Include CSRF token in requests:
```javascript
// Get CSRF token from cookie or meta tag
const csrfToken = getCookie('csrf_cookie_name');

fetch(url, {
    method: 'POST',
    headers: {
        'X-CSRF-TOKEN': csrfToken
    },
    body: formData
});
```

### 3. Input Sanitization
Always sanitize user input before sending to API:
```javascript
function sanitizeInput(input) {
    return input.replace(/[<>]/g, '');
}
```

### 4. Secure Password Handling
Never log or expose passwords:
```javascript
// ❌ Bad
console.log('Password:', password);

// ✅ Good
console.log('Attempting login...');
```



---

## Testing APIs

### Using Postman

**1. Setup Environment:**
```
Base URL: http://localhost/rms/index.php
```

**2. Login Request:**
```
Method: POST
URL: {{baseUrl}}/Login/loginproc
Body (x-www-form-urlencoded):
  username: admin
  userpass: admin123
```

**3. Save Cookies:**
- Postman automatically saves cookies from responses
- Ensure "Automatically follow redirects" is enabled

**4. Test Authenticated Endpoint:**
```
Method: GET
URL: {{baseUrl}}/A_dashboard/get_notifications
```

### Using cURL

**Login:**
```bash
curl -X POST http://localhost/rms/index.php/Login/loginproc \
  -d "username=admin&userpass=admin123" \
  -c cookies.txt \
  -L
```

**Get Notifications:**
```bash
curl http://localhost/rms/index.php/A_dashboard/get_notifications \
  -b cookies.txt
```

**Add Candidate:**
```bash
curl -X POST http://localhost/rms/index.php/R_dashboard/add_candidate \
  -b cookies.txt \
  -F "cd_name=John Doe" \
  -F "cd_email=john@example.com" \
  -F "cd_phone=555-1234" \
  -F "cd_gender=Male" \
  -F "cd_job_title=Software Engineer" \
  -F "cd_source=LinkedIn"
```

---

## API Versioning

Currently, the RMS API does not implement versioning. For future versions, consider:

```
/api/v1/candidates
/api/v2/candidates
```

---

## Webhooks (Future Feature)

Planned webhook support for:
- New candidate applications
- Interview scheduled/completed
- Status changes
- User actions

Example webhook payload:
```json
{
    "event": "candidate.created",
    "timestamp": "2025-11-14T10:30:00Z",
    "data": {
        "candidate_id": 123,
        "name": "John Doe",
        "email": "john@example.com"
    }
}
```

---

## Support & Resources

### Documentation Files
- **API_DOCUMENTATION.md** - Complete API reference
- **API_DOCUMENTATION_PART2.md** - Additional endpoints
- **API_REFERENCE_GUIDE.md** - This guide
- **SYSTEM_ARCHITECTURE_DIAGRAM.md** - System architecture
- **COMPLETE_SYSTEM_OVERVIEW.md** - System overview

### Getting Help
- Check error logs: `application/logs/`
- Review audit logs: Setup → Audit Logs
- Contact support: support@rms.com

### Useful Links
- CodeIgniter Documentation: https://codeigniter.com/docs
- PHP Documentation: https://php.net/docs
- Bootstrap Documentation: https://getbootstrap.com/docs

---

**API Version:** 2.1
**Last Updated:** November 14, 2025
**Status:** ✅ Production Ready
