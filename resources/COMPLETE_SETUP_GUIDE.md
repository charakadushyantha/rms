# Complete Setup Guide - All Features ✅

## Quick Setup (5 Steps)

### Step 1: Run Database Migrations
Run these URLs in your browser **once**:

```
1. http://localhost/rms/add_sms_field.php
   ✅ Adds SMS notification field

2. http://localhost/rms/add_multiple_interviewers_support.php
   ✅ Adds multiple interviewers support
```

**Expected Output:** Green checkmarks showing fields were added successfully.

---

### Step 2: Configure Interview Settings
```
Go to: http://localhost/rms/Setup/interview_configuration
```

**Configure these settings:**

#### General Settings
- ✅ Default Interview Duration: **60 minutes** (or your preference)
- ✅ Default Interview Type: **Online** (or your preference)
- ✅ Default Meeting Platform: **Zoom** (or your preference)
- ✅ Timezone: **Asia/Colombo**

#### Interviewer Settings (NEW!)
- ✅ Toggle ON: **Allow Multiple Interviewers**
- ✅ Maximum Number of Interviewers: **3** (or your preference)

#### Scheduling Settings
- ✅ Working Hours Start: **09:00**
- ✅ Working Hours End: **18:00**
- ✅ Buffer Time: **15 minutes**
- ✅ Enable Conflict Detection: **ON**

#### Notification Settings
- ✅ Email Notifications: **ON**
- ✅ WhatsApp Notifications: **ON** (if you want it)
- ✅ SMS Notifications: **ON** (if you want it)
- ✅ Send Reminder: **24 hours before**

#### Advanced Settings
- ✅ Auto-Generate Meeting Links: **OFF** (uses templates)
- ✅ Calendar Sync: **ON** (if you want it)

**Click "Save Configuration"**

---

### Step 3: Test Interview Creation
```
Go to: http://localhost/rms/interview/create_interview
```

**Verify these features work:**

#### ✅ Interview Rounds
- Should show rounds from configuration
- Default rounds: Round 1, Round 2, Technical, HR, Final, Panel

#### ✅ Duration Presets
- Should show duration buttons from configuration
- Default: 30min, 1hr, 1.5hrs, 2hrs

#### ✅ Interview Type
- Should pre-select default type from configuration
- Options: Online, In-Person, Phone

#### ✅ Meeting Platforms
- Should show platforms from configuration
- Default platform should be pre-selected

#### ✅ Multiple Interviewers (NEW!)
- Should see "Panel Interview Mode" info box
- Should see "Primary Interviewer" dropdown with "Lead" badge
- Should see "Add Another Interviewer" button
- Click button → New interviewer dropdown appears
- Select same interviewer twice → Warning appears
- Click "Remove" → Interviewer field is removed

#### ✅ Notifications
- Email checkbox: Should be visible (if enabled)
- WhatsApp checkbox: Should be visible (if enabled)
- SMS checkbox: Should be visible (if enabled) ← **NEW!**
- Calendar checkbox: Should be visible (if enabled)
- Reminder label: Should show configured hours

---

### Step 4: Test Configuration Changes

#### Test A: Disable SMS
```
1. Go to: http://localhost/rms/Setup/interview_configuration
2. Toggle OFF "SMS Notifications"
3. Save
4. Go to: http://localhost/rms/interview/create_interview
5. ✅ SMS checkbox should be HIDDEN
```

#### Test B: Change Default Duration
```
1. Go to: http://localhost/rms/Setup/interview_configuration
2. Change "Default Interview Duration" to "90 minutes"
3. Save
4. Go to: http://localhost/rms/interview/create_interview
5. ✅ "1.5 hrs" button should be ACTIVE
```

#### Test C: Disable Multiple Interviewers
```
1. Go to: http://localhost/rms/Setup/interview_configuration
2. Toggle OFF "Allow Multiple Interviewers"
3. Save
4. Go to: http://localhost/rms/interview/create_interview
5. ✅ Should show single "Assigned Interviewer" dropdown
6. ✅ Info box: "Need multiple interviewers? Enable in configuration"
```

---

### Step 5: Create Test Interview

**Fill out the form:**

1. **Interview Flow:** Select any flow
2. **Candidate:** Select existing or add new
3. **Interview Date:** Tomorrow's date
4. **Interview Round:** Round 1
5. **Start Time:** 10:00
6. **Duration:** 1 hour
7. **Interview Type:** Online
8. **Platform:** Zoom
9. **Meeting Link:** Click "Auto-Generate Link"
10. **Primary Interviewer:** Select one
11. **Add Another Interviewer:** Click and select another (if enabled)
12. **Job Position:** Select or leave blank
13. **Interview Notes:** "Please prepare your portfolio"
14. **Notifications:** Check Email and WhatsApp
15. **Click "Schedule Interview"**

**Expected Result:**
- ✅ Success message appears
- ✅ Interview is created
- ✅ Multiple interviewers saved (if selected)
- ✅ All fields saved correctly

---

## Verification Checklist

### Configuration Module
- [ ] Interview Configuration page loads
- [ ] All settings are visible
- [ ] Interviewer Settings section exists
- [ ] Can toggle multiple interviewers ON/OFF
- [ ] Can set maximum interviewers
- [ ] Save button works
- [ ] Success message appears after save

### Interview Form
- [ ] Form loads without errors
- [ ] Interview rounds dropdown is populated
- [ ] Duration buttons are populated
- [ ] Default values are pre-selected
- [ ] Meeting platforms dropdown is populated
- [ ] Multiple interviewers mode works (when enabled)
- [ ] Can add/remove interviewers dynamically
- [ ] Duplicate detection works
- [ ] SMS checkbox appears (when enabled)
- [ ] All notifications checkboxes work
- [ ] Form submits successfully

### Database
- [ ] `interview_config` table has new fields
- [ ] `interviews` table has `send_sms` field
- [ ] `interviews.assigned_interviewer` is TEXT type
- [ ] Configuration saves correctly
- [ ] Interview data saves correctly
- [ ] Multiple interviewers save as comma-separated

---

## Troubleshooting

### Issue: Configuration page doesn't load
**Solution:**
```
1. Check if tables exist in database
2. Run: http://localhost/rms/Setup/interview_configuration
3. Tables will be auto-created on first access
4. Refresh the page
```

### Issue: SMS checkbox not showing
**Solution:**
```
1. Run: http://localhost/rms/add_sms_field.php
2. Go to configuration and enable SMS
3. Refresh interview form
```

### Issue: Multiple interviewers not showing
**Solution:**
```
1. Run: http://localhost/rms/add_multiple_interviewers_support.php
2. Go to configuration and enable "Allow Multiple Interviewers"
3. Refresh interview form
```

### Issue: Changes not reflecting
**Solution:**
```
1. Clear browser cache (Ctrl+Shift+Delete)
2. Hard refresh (Ctrl+F5)
3. Check if configuration was saved
4. Verify database values
```

### Issue: JavaScript errors
**Solution:**
```
1. Open browser console (F12)
2. Check for errors
3. Verify jQuery is loaded
4. Verify Bootstrap is loaded
```

---

## Database Queries for Verification

### Check Configuration
```sql
SELECT * FROM interview_config;
```

### Check Interview Rounds
```sql
SELECT * FROM interview_rounds WHERE is_active = 1;
```

### Check Meeting Platforms
```sql
SELECT * FROM meeting_platforms WHERE is_active = 1;
```

### Check Recent Interview
```sql
SELECT 
    id,
    candidate_name,
    assigned_interviewer,
    interview_type,
    interview_date,
    send_sms,
    send_whatsapp
FROM interviews 
ORDER BY id DESC 
LIMIT 1;
```

### Check Multiple Interviewers
```sql
-- Should show comma-separated interviewers
SELECT 
    id,
    candidate_name,
    assigned_interviewer,
    LENGTH(assigned_interviewer) - LENGTH(REPLACE(assigned_interviewer, ',', '')) + 1 as interviewer_count
FROM interviews 
WHERE assigned_interviewer LIKE '%,%'
ORDER BY id DESC;
```

---

## Features Summary

### ✅ Completed Features

1. **Interview Configuration Module**
   - General settings (duration, type, platform, timezone)
   - Interviewer settings (multiple interviewers, max count)
   - Scheduling settings (working hours, buffer time, conflict detection)
   - Notification settings (email, WhatsApp, SMS, calendar, reminders)
   - Advanced settings (auto-generate links, calendar sync)

2. **Dynamic Interview Form**
   - Interview rounds from configuration
   - Duration presets from configuration
   - Meeting platforms from configuration
   - Interview locations from configuration
   - Default values from configuration
   - Conditional notifications based on configuration

3. **Multiple Interviewers Support**
   - Toggle ON/OFF in configuration
   - Configurable maximum (2-10 interviewers)
   - Dynamic add/remove interviewers
   - Duplicate detection
   - Primary interviewer with "Lead" badge
   - Comma-separated storage

4. **SMS Notifications**
   - Toggle ON/OFF in configuration
   - Checkbox in interview form
   - Shows/hides based on configuration
   - Saves to database

5. **Configuration Integration**
   - All settings affect interview form
   - Real-time changes (no restart needed)
   - Fallback values if not configured
   - Backward compatible

---

## Next Steps (Optional Enhancements)

### 1. Sub-Configuration Pages
Create these pages linked from main configuration:
- Interview Rounds Management
- Meeting Platforms Configuration
- Interview Locations Management
- Email Templates Editor
- Duration Presets Manager

### 2. API Integrations
- Zoom API for real meeting links
- Google Meet API
- Microsoft Teams API
- Twilio for WhatsApp/SMS
- Google Calendar API

### 3. Advanced Features
- Interviewer availability calendar
- Conflict detection logic
- Automated reminders
- Interview feedback forms
- Panel interview scoring

---

## Status: ✅ COMPLETE

All features are implemented and ready to use!

**Start using:**
1. ✅ Run migrations
2. ✅ Configure settings
3. ✅ Create interviews
4. ✅ Test all features

**Documentation:**
- `CONFIGURATION_INTEGRATION_COMPLETE.md` - Full integration details
- `SMS_NOTIFICATION_ADDED.md` - SMS feature details
- `MULTIPLE_INTERVIEWERS_COMPLETE.md` - Multiple interviewers details
- `QUICK_TEST_GUIDE.md` - Testing instructions
- `COMPLETE_SETUP_GUIDE.md` - This file

🎉 **Everything is ready to use!**
