# Fix API 404 Error

## The Problem
Getting 404 error when accessing: `http://localhost/rms/index.php/api/interview_api`

## Quick Fixes

### Option 1: Test Routes (Recommended)
Run this test to diagnose the issue:
```
http://localhost/rms/test_direct_api.php
```

This will show you exactly what's wrong.

### Option 2: Use Alternative URL Format
Instead of:
```
http://localhost/rms/index.php/api/interview_api/get_flows
```

Try:
```
http://localhost/rms/index.php?c=api/interview_api&m=get_flows&api_key=test
```

### Option 3: Update Routes (Already Done)
The routes have been added to `application/config/routes.php`:
```php
$route['api/interview_api/create_flow'] = 'api/interview_api/create_flow';
$route['api/interview_api/get_flows'] = 'api/interview_api/get_flows';
// ... etc
```

### Option 4: Check Apache mod_rewrite
Ensure mod_rewrite is enabled in Apache:

1. Open `httpd.conf`
2. Find: `#LoadModule rewrite_module modules/mod_rewrite.so`
3. Remove the `#` to uncomment it
4. Restart Apache

### Option 5: Verify .htaccess
Your `.htaccess` should have:
```apache
RewriteEngine On
RewriteBase /rms/
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?/$1 [L,QSA]
```

## Testing

### Test 1: Check if controller exists
```
http://localhost/rms/test_direct_api.php
```

### Test 2: Test API routes
```
http://localhost/rms/test_api_routes.php
```

### Test 3: Use the API tester
```
http://localhost/rms/test_interview_api.php
```

## Working URLs

Once fixed, these should work:

**Get Flows:**
```
GET http://localhost/rms/index.php/api/interview_api/get_flows?api_key=test
```

**Create Flow:**
```
POST http://localhost/rms/index.php/api/interview_api/create_flow?api_key=test
Content-Type: application/json

{
  "job_title": "Test Job",
  "questions": [...],
  "interview_type": "video"
}
```

## Alternative: Use Web Interface Instead

If API routes are problematic, use the web interface:

```
http://localhost/rms/index.php/interview
```

This provides the same functionality with a user-friendly interface:
- Create interview flows
- Generate interview links
- View interview results
- Manage interviews

## Still Not Working?

1. Check Apache error logs
2. Verify PHP version (7.0+)
3. Check file permissions
4. Ensure database tables exist
5. Try restarting Apache

## Contact

If issues persist, the web interface at `/interview` provides all the same features without needing the API routes.
