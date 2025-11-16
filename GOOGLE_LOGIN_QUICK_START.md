# 🚀 Google Login - Quick Start Guide

## Current Status
✅ **Code Implemented** - Google OAuth login is ready
⏳ **Configuration Needed** - You need to add your Google credentials

## 3-Step Setup

### Step 1: Get Google Credentials (5 minutes)

1. Visit: https://console.cloud.google.com/
2. Create new project → Enable Google+ API
3. Create OAuth 2.0 Client ID
4. Add redirect URI:
   ```
   http://localhost/rms/index.php/Login/google_callback
   ```
5. Copy your **Client ID** and **Client Secret**

### Step 2: Update Configuration (1 minute)

Open `application/config/constants.php` and update these lines:

```php
// Line ~140 (at the bottom of the file)
define('GOOGLE_CLIENT_ID', 'YOUR_CLIENT_ID_HERE');
define('GOOGLE_CLIENT_SECRET', 'YOUR_CLIENT_SECRET_HERE');
define('GOOGLE_LOGIN_ENABLED', TRUE);  // Change FALSE to TRUE
```

### Step 3: Test (1 minute)

1. Visit: http://localhost/rms/index.php/Login
2. Click "Continue with Google"
3. Login with your Google account
4. You should be redirected to your dashboard!

## That's It! 🎉

Your Google login is now working!

## Need Help?

See **GOOGLE_OAUTH_SETUP_GUIDE.md** for detailed instructions and troubleshooting.

---

## What Happens When Users Login with Google?

### Existing Users:
- System finds user by email
- Logs them in automatically
- Redirects to their dashboard

### New Users:
- System creates new account automatically
- Assigns "Candidate" role
- Activates account immediately
- Redirects to Candidate dashboard

## Security

✅ No passwords stored
✅ Google handles authentication
✅ OAuth 2.0 protocol
✅ Secure token-based login

## Current Button Behavior

**Before Configuration:**
- Button shows message: "Google login not configured yet"
- Provides setup instructions

**After Configuration:**
- Button redirects to Google login
- Works seamlessly

---

**Quick Reference:**
- Config File: `application/config/constants.php`
- Controller: `application/controllers/Login.php`
- View: `application/views/login_new.php`
- Full Guide: `GOOGLE_OAUTH_SETUP_GUIDE.md`
