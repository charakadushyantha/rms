# Recruiter Buttons Not Working - Diagnostic Guide

## Issue
The action buttons (Activate, Edit, Delete) on the Manage Recruiters page are not working.

## Diagnostic Steps

### Step 1: Run the Debug Tool
Visit this URL to check your database structure and test endpoints:
```
http://localhost/rms/debug_recruiters
```

This will show you:
- ✅ If the `users` table exists
- ✅ If required columns exist (`u_id`, `u_username`, `u_email`, `u_status`, `u_created_at`)
- ✅ Current recruiters in the database
- ✅ If the model and controller files exist
- ✅ Your authentication status

### Step 2: Add Missing Columns (if needed)
If the debug tool shows missing columns, click the "Add Missing Columns" button or visit:
```
http://localhost/rms/debug_recruiters/add_missing_columns
```

This will automatically add:
- `u_status` column (TINYINT, default 0)
- `u_created_at` column (TIMESTAMP, default CURRENT_TIMESTAMP)

### Step 3: Test AJAX Endpoints
Open the test page in your browser:
```
http://localhost/rms/test_recruiter_ajax.html
```

Click each button and check:
- ✅ If the endpoints return data
- ✅ If there are authentication errors
- ✅ Browser console for JavaScript errors (Press F12)

### Step 4: Check Browser Console
1. Open the Manage Recruiters page: `http://localhost/rms/A_dashboard/Arecruiter_view`
2. Press **F12** to open Developer Tools
3. Go to the **Console** tab
4. Look for errors (red text)
5. Try clicking a button and watch for new errors

Common errors to look for:
- `404 Not Found` - Controller or method doesn't exist
- `500 Internal Server Error` - PHP error in controller
- `Uncaught ReferenceError` - JavaScript function not defined
- `Unexpected token` - JavaScript syntax error
- `Not authenticated` - Session issue

### Step 5: Check Network Tab
1. Keep Developer Tools open (F12)
2. Go to the **Network** tab
3. Click an action button (e.g., Edit)
4. Look for the AJAX request in the network list
5. Click on it to see:
   - Request URL
   - Request Method
   - Status Code
   - Response data

## Common Issues and Fixes

### Issue 1: Missing Database Columns
**Symptoms:** Buttons don't work, no data loads
**Fix:** Run `http://localhost/rms/debug_recruiters/add_missing_columns`

### Issue 2: Authentication Error
**Symptoms:** Console shows "Not authenticated" or redirects to login
**Fix:** Make sure you're logged in as Admin

### Issue 3: JavaScript Errors
**Symptoms:** Console shows syntax errors
**Fix:** Check if jQuery and DataTables are loaded properly

### Issue 4: CORS or Session Issues
**Symptoms:** AJAX requests fail with network errors
**Fix:** Check `application/config/config.php`:
```php
$config['sess_cookie_name'] = 'ci_session';
$config['sess_expire_on_close'] = FALSE;
$config['sess_save_path'] = APPPATH . 'cache/';
```

### Issue 5: Base URL Not Set
**Symptoms:** AJAX URLs are incorrect
**Fix:** Check `application/config/config.php`:
```php
$config['base_url'] = 'http://localhost/rms/';
```

## Manual Testing

### Test 1: Check if recruiters load
Open browser console and run:
```javascript
$.ajax({
    url: 'http://localhost/rms/recruiter_management/get_recruiters',
    type: 'GET',
    dataType: 'json',
    success: function(response) {
        console.log('Success:', response);
    },
    error: function(xhr, status, error) {
        console.log('Error:', xhr.responseText);
    }
});
```

### Test 2: Check if stats load
```javascript
$.ajax({
    url: 'http://localhost/rms/recruiter_management/get_stats',
    type: 'GET',
    dataType: 'json',
    success: function(response) {
        console.log('Stats:', response);
    },
    error: function(xhr, status, error) {
        console.log('Error:', xhr.responseText);
    }
});
```

## Files to Check

1. **Controller:** `application/controllers/Recruiter_management.php`
2. **Model:** `application/models/Recruiter_model.php`
3. **View:** `application/views/Admin_dashboard_view/Arecruiter.php`
4. **Config:** `application/config/config.php`
5. **Database:** Check `users` table structure in phpMyAdmin

## Quick Fixes Applied

I've already made these changes:
- ✅ Updated `Recruiter_management` controller to handle authentication better
- ✅ Created debug tool to diagnose issues
- ✅ Created test page for AJAX endpoints
- ✅ Added column migration script

## Next Steps

1. **Run the debug tool first:** `http://localhost/rms/debug_recruiters`
2. **Fix any missing columns** using the "Add Missing Columns" button
3. **Test AJAX endpoints:** `http://localhost/rms/test_recruiter_ajax.html`
4. **Check browser console** for JavaScript errors
5. **Report back** with any error messages you see

## Getting Help

When reporting the issue, please provide:
1. Screenshot of the debug tool output
2. Browser console errors (F12 → Console tab)
3. Network tab showing failed requests (F12 → Network tab)
4. Any PHP errors from the server logs
