# 🔄 Google OAuth Login Flow

## Visual Flow Diagram

```
┌─────────────────────────────────────────────────────────────────┐
│                     USER CLICKS "CONTINUE WITH GOOGLE"          │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│  Login.php → google_login()                                     │
│  • Checks if Google OAuth is configured                         │
│  • Builds Google OAuth URL with Client ID                       │
│  • Redirects user to Google                                     │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│  GOOGLE LOGIN PAGE (accounts.google.com)                        │
│  • User selects Google account                                  │
│  • User grants permissions                                      │
│  • Google generates authorization code                          │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│  Login.php → google_callback()                                  │
│  • Receives authorization code from Google                      │
│  • Exchanges code for access token                              │
│  • Gets user info (email, name, picture)                        │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             ▼
                    ┌────────┴────────┐
                    │                 │
                    ▼                 ▼
        ┌───────────────────┐  ┌──────────────────┐
        │  USER EXISTS?     │  │  USER NEW?       │
        │  (Check by email) │  │  (Not in DB)     │
        └─────────┬─────────┘  └────────┬─────────┘
                  │                     │
                  ▼                     ▼
        ┌───────────────────┐  ┌──────────────────┐
        │  Check Status     │  │  Create Account  │
        │  • Active?        │  │  • Username      │
        │  • Pending?       │  │  • Email         │
        │  • Inactive?      │  │  • Role          │
        └─────────┬─────────┘  │  • Status        │
                  │             │  • Profile pic   │
                  │             └────────┬─────────┘
                  │                      │
                  ▼                      ▼
        ┌───────────────────┐  ┌──────────────────┐
        │  If Active:       │  │  Create Profile  │
        │  • Create session │  │  • Candidate     │
        │  • Set user data  │  │  • Details       │
        │  • Redirect       │  └────────┬─────────┘
        └─────────┬─────────┘           │
                  │                     │
                  │                     ▼
                  │            ┌──────────────────┐
                  │            │  Create Session  │
                  │            │  • Set user data │
                  │            │  • Mark as auth  │
                  │            └────────┬─────────┘
                  │                     │
                  └──────────┬──────────┘
                             │
                             ▼
                ┌────────────────────────┐
                │  REDIRECT TO DASHBOARD │
                │  Based on Role:        │
                │  • Admin → Admin       │
                │  • Recruiter → Rec     │
                │  • Interviewer → Int   │
                │  • Candidate → Cand    │
                └────────────────────────┘
```

## Detailed Step-by-Step

### 1. User Initiates Login
```
User clicks: "Continue with Google"
↓
Browser sends request to: /Login/google_login
```

### 2. Redirect to Google
```
Controller builds URL:
https://accounts.google.com/o/oauth2/v2/auth?
  client_id=YOUR_CLIENT_ID
  &redirect_uri=http://localhost/rms/index.php/Login/google_callback
  &response_type=code
  &scope=email profile
  &access_type=online
  &prompt=select_account
```

### 3. Google Authentication
```
User at Google:
1. Selects account
2. Reviews permissions
3. Clicks "Allow"

Google generates:
- Authorization code
- Redirects back to your app
```

### 4. Callback Processing
```
Your app receives:
http://localhost/rms/index.php/Login/google_callback?code=AUTHORIZATION_CODE

Controller:
1. Extracts code
2. Exchanges for access token
3. Uses token to get user info
```

### 5. User Info Retrieved
```json
{
  "email": "user@gmail.com",
  "name": "John Doe",
  "picture": "https://lh3.googleusercontent.com/...",
  "verified_email": true
}
```

### 6. Database Check
```sql
SELECT * FROM users WHERE u_email = 'user@gmail.com'
```

**If Found:**
```
Check u_status:
- Active → Login ✅
- Pending → Show message ⏳
- Inactive → Show message ❌
```

**If Not Found:**
```
Create new user:
INSERT INTO users (
  u_username,
  u_email,
  u_password,
  u_role,
  u_status,
  profile_picture
) VALUES (
  'johndoe',
  'user@gmail.com',
  'random_hash',
  'Candidate',
  'Active',
  'https://...'
)
```

### 7. Session Creation
```php
$userdata = array(
  'id' => $user->u_id,
  'username' => $user->u_username,
  'email' => $user->u_email,
  'Role' => $user->u_role,
  'authenticated' => TRUE,
  'google_login' => TRUE
);

$this->session->set_userdata($userdata);
```

### 8. Dashboard Redirect
```
Switch based on role:
- Admin → /A_dashboard
- Recruiter → /R_dashboard
- Interviewer → /I_dashboard
- Candidate → /C_dashboard
```

## Error Handling

### Scenario 1: User Cancels
```
User clicks "Cancel" at Google
↓
Google redirects with error
↓
Show message: "Google login failed"
↓
Redirect to login page
```

### Scenario 2: Invalid Credentials
```
Client ID/Secret wrong
↓
Google returns error
↓
Show message: "Failed to authenticate"
↓
Redirect to login page
```

### Scenario 3: Account Inactive
```
User exists but status = 'Pending'
↓
Show message: "Account not activated"
↓
Redirect to login page
```

## Security Measures

### 1. Token Validation
```
✅ Verify authorization code
✅ Validate access token
✅ Check token expiry
✅ Verify email from Google
```

### 2. Session Security
```
✅ Secure session storage
✅ Session timeout
✅ CSRF protection
✅ XSS prevention
```

### 3. Database Security
```
✅ Prepared statements
✅ Input validation
✅ SQL injection prevention
✅ Password hashing (for non-Google users)
```

## Configuration Check

### Before Login Attempt:
```php
if (!defined('GOOGLE_CLIENT_ID') || !defined('GOOGLE_CLIENT_SECRET')) {
  // Show error message
  // Redirect to login
}

if (empty(GOOGLE_CLIENT_ID) || empty(GOOGLE_CLIENT_SECRET)) {
  // Show configuration needed message
}
```

### Button Display Logic:
```php
if (GOOGLE_LOGIN_ENABLED && !empty(GOOGLE_CLIENT_ID)) {
  // Show working Google button
} else {
  // Show "not configured" message
}
```

## Data Flow Summary

```
┌──────────┐     ┌──────────┐     ┌──────────┐     ┌──────────┐
│  User    │────▶│  Your    │────▶│  Google  │────▶│  Your    │
│  Browser │     │  App     │     │  OAuth   │     │  App     │
└──────────┘     └──────────┘     └──────────┘     └──────────┘
     │                │                  │                │
     │  Click Button  │                  │                │
     │───────────────▶│                  │                │
     │                │  Redirect        │                │
     │                │─────────────────▶│                │
     │                │                  │                │
     │  Google Login  │                  │                │
     │◀───────────────────────────────────│                │
     │                │                  │                │
     │  Authorize     │                  │                │
     │───────────────────────────────────▶│                │
     │                │                  │                │
     │                │  Callback + Code │                │
     │                │◀─────────────────────────────────│
     │                │                  │                │
     │                │  Get Token       │                │
     │                │─────────────────▶│                │
     │                │                  │                │
     │                │  Token + Data    │                │
     │                │◀─────────────────│                │
     │                │                  │                │
     │                │  Create Session  │                │
     │                │  & Redirect      │                │
     │◀───────────────│                  │                │
     │                │                  │                │
     │  Dashboard     │                  │                │
     │───────────────▶│                  │                │
```

## Testing Checklist

- [ ] Configuration complete
- [ ] Button visible on login page
- [ ] Click redirects to Google
- [ ] Can select Google account
- [ ] Permissions screen shows
- [ ] Callback URL works
- [ ] User data retrieved
- [ ] Session created
- [ ] Redirected to dashboard
- [ ] Can access protected pages
- [ ] Logout works
- [ ] Can login again

---

**Implementation Status:** ✅ Complete
**Configuration Status:** ⏳ Pending (Add your credentials)
**Documentation:** ✅ Complete
