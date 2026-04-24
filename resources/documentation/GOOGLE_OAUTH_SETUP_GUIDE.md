# 🔐 Google OAuth Login - Complete Setup Guide

## Overview

Google OAuth login has been implemented in your Recruitment Management System. Users can now sign in using their Google accounts, making the login process faster and more secure.

## ✅ What's Been Implemented

### 1. Controller Methods (`application/controllers/Login.php`)
- ✅ `google_login()` - Initiates Google OAuth flow
- ✅ `google_callback()` - Handles Google's response
- ✅ Auto-creates user accounts for new Google sign-ins
- ✅ Maps existing users by email
- ✅ Role-based redirection after login

### 2. Configuration (`application/config/constants.php`)
- ✅ `GOOGLE_CLIENT_ID` - Your Google OAuth Client ID
- ✅ `GOOGLE_CLIENT_SECRET` - Your Google OAuth Client Secret
- ✅ `GOOGLE_LOGIN_ENABLED` - Enable/disable Google login

### 3. Login View (`application/views/login_new.php`)
- ✅ "Continue with Google" button
- ✅ Conditional display based on configuration
- ✅ Helpful error message when not configured

## 🚀 Setup Instructions

### Step 1: Get Google OAuth Credentials

#### 1.1 Go to Google Cloud Console
Visit: https://console.cloud.google.com/

#### 1.2 Create or Select a Project
- Click on the project dropdown at the top
- Click "New Project"
- Enter project name: "RMS OAuth" (or any name you prefer)
- Click "Create"

#### 1.3 Enable Google+ API
- In the left sidebar, go to "APIs & Services" > "Library"
- Search for "Google+ API"
- Click on it and click "Enable"

#### 1.4 Create OAuth 2.0 Credentials
1. Go to "APIs & Services" > "Credentials"
2. Click "Create Credentials" > "OAuth 2.0 Client ID"
3. If prompted, configure the OAuth consent screen:
   - User Type: External
   - App name: "Recruitment Management System"
   - User support email: Your email
   - Developer contact: Your email
   - Click "Save and Continue"
   - Scopes: Click "Save and Continue" (default scopes are fine)
   - Test users: Add your email for testing
   - Click "Save and Continue"

4. Create OAuth Client ID:
   - Application type: "Web application"
   - Name: "RMS Web Client"
   - Authorized JavaScript origins:
     ```
     http://localhost
     ```
   - Authorized redirect URIs:
     ```
     http://localhost/rms/index.php/Login/google_callback
     ```
   - Click "Create"

5. **Copy your credentials:**
   - Client ID: (looks like: 123456789-abc123.apps.googleusercontent.com)
   - Client Secret: (looks like: GOCSPX-abc123xyz)

### Step 2: Configure Your Application

#### 2.1 Update Constants File
Open `application/config/constants.php` and update:

```php
// Google OAuth Client ID (paste your Client ID here)
define('GOOGLE_CLIENT_ID', '123456789-abc123.apps.googleusercontent.com');

// Google OAuth Client Secret (paste your Client Secret here)
define('GOOGLE_CLIENT_SECRET', 'GOCSPX-abc123xyz');

// Enable Google Login
define('GOOGLE_LOGIN_ENABLED', TRUE);
```

#### 2.2 Save the File
Save `constants.php` after making changes.

### Step 3: Test Google Login

#### 3.1 Visit Login Page
```
http://localhost/rms/index.php/Login
```

#### 3.2 Click "Continue with Google"
- You should be redirected to Google's login page
- Select your Google account
- Grant permissions
- You'll be redirected back to your application

#### 3.3 Verify Login
- Check if you're logged in successfully
- Verify you're redirected to the appropriate dashboard based on your role

## 🔧 Configuration Options

### For Production Environment

When deploying to production, update the redirect URI:

**In Google Cloud Console:**
```
https://yourdomain.com/index.php/Login/google_callback
```

**In constants.php:**
```php
define('BASE_URL', 'https://yourdomain.com');
```

### User Role Assignment

By default, new Google sign-ups are created as "Candidate" users. To change this behavior, modify the `google_callback()` method in `Login.php`:

```php
// Find this line:
'u_role' => 'Candidate', // Default role for Google sign-ups

// Change to:
'u_role' => 'Recruiter', // or 'Admin', 'Interviewer'
```

### Auto-Activation

New Google users are automatically activated. To require admin approval:

```php
// In google_callback() method, change:
'u_status' => 'Active', // Auto-activate Google users

// To:
'u_status' => 'Pending', // Require admin activation
```

## 🎯 How It Works

### For Existing Users:
1. User clicks "Continue with Google"
2. Redirected to Google login
3. Google verifies identity
4. System checks if email exists in database
5. If exists and active → Log in and redirect to dashboard
6. If exists but inactive → Show "account not activated" message

### For New Users:
1. User clicks "Continue with Google"
2. Redirected to Google login
3. Google verifies identity
4. System checks if email exists in database
5. If doesn't exist → Create new account automatically
6. Assign "Candidate" role by default
7. Auto-activate account
8. Log in and redirect to Candidate dashboard

## 🔍 Troubleshooting

### Error: "redirect_uri_mismatch"

**Problem:** The redirect URI doesn't match what's configured in Google Console.

**Solution:**
1. Check your BASE_URL in `constants.php`
2. Verify the redirect URI in Google Console exactly matches:
   ```
   http://localhost/rms/index.php/Login/google_callback
   ```
3. Make sure there are no trailing slashes or extra spaces

### Error: "invalid_client"

**Problem:** Client ID or Client Secret is incorrect.

**Solution:**
1. Double-check your Client ID and Client Secret in `constants.php`
2. Make sure you copied them correctly from Google Console
3. Ensure there are no extra spaces or quotes

### Error: "access_denied"

**Problem:** User cancelled the login or didn't grant permissions.

**Solution:**
- This is normal if user clicks "Cancel" on Google's consent screen
- User can try again by clicking "Continue with Google" again

### Button Shows "Not Configured" Message

**Problem:** Google OAuth credentials are not set up.

**Solution:**
1. Complete Step 1 and Step 2 above
2. Make sure `GOOGLE_LOGIN_ENABLED` is set to `TRUE`
3. Verify `GOOGLE_CLIENT_ID` is not empty

### User Created But Can't Access Dashboard

**Problem:** New Google user doesn't have proper permissions.

**Solution:**
1. Check the user's role in the database (`users` table)
2. Verify the user's status is "Active"
3. Check if the appropriate dashboard exists for that role

## 📊 Database Changes

### Users Table
When a user signs in with Google, the following data is stored:

```sql
u_username: Generated from email (e.g., john.doe or john.doe_1234)
u_email: User's Google email
u_password: Random hash (not used for Google login)
u_role: 'Candidate' (default for new sign-ups)
u_status: 'Active' (auto-activated)
profile_picture: Google profile picture URL (if available)
```

### Candidate Details Table
For new Google sign-ups, a candidate profile is created:

```sql
cd_name: User's name from Google
cd_email: User's Google email
cd_source: 'Google OAuth'
cd_description: 'Registered via Google Sign-In'
cd_status: 'New'
```

## 🔒 Security Features

✅ **OAuth 2.0 Protocol** - Industry-standard authentication
✅ **No Password Storage** - Google handles authentication
✅ **HTTPS Support** - Secure data transmission (in production)
✅ **Token-Based** - Short-lived access tokens
✅ **Email Verification** - Google verifies email ownership
✅ **Session Management** - Secure session handling

## 📝 Testing Checklist

- [ ] Google Cloud Console project created
- [ ] OAuth 2.0 Client ID created
- [ ] Redirect URI configured correctly
- [ ] Client ID and Secret added to constants.php
- [ ] GOOGLE_LOGIN_ENABLED set to TRUE
- [ ] Login page shows "Continue with Google" button
- [ ] Clicking button redirects to Google
- [ ] Can select Google account
- [ ] Successfully redirected back to application
- [ ] Logged in and redirected to correct dashboard
- [ ] User data saved correctly in database
- [ ] Can logout and login again with Google

## 🎨 Customization

### Change Button Text
In `login_new.php`:
```php
Continue with Google
// Change to:
Sign in with Google
// or:
Login with Google Account
```

### Change Button Style
The button uses the `.btn-google` class. Modify the CSS in `login_new.php`:
```css
.btn-google {
  background: white;
  color: #333;
  border: 2px solid #e0e0e0;
  /* Add your custom styles */
}
```

### Add More OAuth Providers
You can add Facebook, GitHub, or other OAuth providers using the same pattern:
1. Create `facebook_login()` and `facebook_callback()` methods
2. Add Facebook credentials to constants.php
3. Add "Continue with Facebook" button to login view

## 📞 Support

### Common Questions

**Q: Can existing users login with Google?**
A: Yes, if their email in the database matches their Google email.

**Q: What happens if username already exists?**
A: System appends a random number (e.g., john.doe_1234).

**Q: Can I disable Google login later?**
A: Yes, set `GOOGLE_LOGIN_ENABLED` to `FALSE` in constants.php.

**Q: Is it secure?**
A: Yes, OAuth 2.0 is an industry-standard secure protocol.

**Q: Do I need HTTPS?**
A: For local development, HTTP is fine. For production, HTTPS is required.

## 🎉 Summary

✅ **Google OAuth login implemented**
✅ **Secure authentication flow**
✅ **Auto-creates new users**
✅ **Maps existing users by email**
✅ **Role-based dashboard redirection**
✅ **Easy to configure**
✅ **Production-ready**

Follow the setup instructions above to enable Google login in your application!

---

**Last Updated:** November 14, 2025
**Version:** 1.0
**Status:** ✅ Ready for Configuration
