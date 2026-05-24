# Quick Test Guide - Interview Configuration Integration

## 🎯 Quick Test (5 minutes)

### Test 1: Change Default Duration
1. Open: `http://localhost/rms/Setup/interview_configuration`
2. Change "Default Interview Duration" to **90 minutes** (1.5 hours)
3. Click **"Save Configuration"**
4. Open: `http://localhost/rms/interview/create_interview`
5. ✅ **Expected:** The "1.5 hrs" button should be highlighted/active

---

### Test 2: Disable WhatsApp Notifications
1. Open: `http://localhost/rms/Setup/interview_configuration`
2. Scroll to "Notification Settings"
3. **Toggle OFF** the "WhatsApp Notifications" switch
4. Click **"Save Configuration"**
5. Open: `http://localhost/rms/interview/create_interview`
6. Scroll to "Notifications & Calendar Sync" section
7. ✅ **Expected:** WhatsApp checkbox should be **completely hidden**

---

### Test 3: Change Default Interview Type
1. Open: `http://localhost/rms/Setup/interview_configuration`
2. Change "Default Interview Type" to **"In-Person"**
3. Click **"Save Configuration"**
4. Open: `http://localhost/rms/interview/create_interview`
5. Scroll to "Interview Mode & Details" section
6. ✅ **Expected:** 
   - "In-Person" card should be selected (highlighted)
   - Venue details section should be visible
   - Online details section should be hidden

---

### Test 4: Change Default Platform
1. Open: `http://localhost/rms/Setup/interview_configuration`
2. Change "Default Meeting Platform" to **"Google Meet"**
3. Click **"Save Configuration"**
4. Open: `http://localhost/rms/interview/create_interview`
5. Select "Online" interview type
6. Look at the "Platform" dropdown
7. ✅ **Expected:** "Google Meet" should be pre-selected

---

### Test 5: Change Reminder Hours
1. Open: `http://localhost/rms/Setup/interview_configuration`
2. Change "Send Reminder Before Interview" to **"48 hours before"**
3. Click **"Save Configuration"**
4. Open: `http://localhost/rms/interview/create_interview`
5. Scroll to "Notifications & Calendar Sync" section
6. Look at the reminder checkbox label
7. ✅ **Expected:** Label should say "Send reminder **48 hours** before interview"

---

## 🔍 Visual Verification

### Before Configuration Changes:
- Duration: 1 hour button active
- Interview Type: Online selected
- Platform: Zoom selected
- WhatsApp: Checkbox visible
- Reminder: "24 hours before"

### After Configuration Changes:
- Duration: 1.5 hours button active ✅
- Interview Type: In-Person selected ✅
- Platform: Google Meet selected ✅
- WhatsApp: Checkbox hidden ✅
- Reminder: "48 hours before" ✅

---

## 🐛 Troubleshooting

### If changes don't appear:
1. **Clear browser cache** (Ctrl+Shift+Delete)
2. **Hard refresh** the page (Ctrl+F5)
3. Check if configuration was saved (go back to config page and verify)
4. Check browser console for JavaScript errors (F12)

### If configuration page doesn't load:
1. Tables might not be created yet
2. Access the page once - it will auto-create tables
3. Refresh the page

### If interview form shows errors:
1. Check if all required fields are filled
2. Check browser console (F12) for errors
3. Verify database tables exist:
   - `interview_config`
   - `interview_rounds`
   - `meeting_platforms`
   - `interview_duration_presets`
   - `interview_locations`

---

## 📊 Database Check

Run these queries to verify configuration is saved:

```sql
-- Check main configuration
SELECT * FROM interview_config;

-- Check interview rounds
SELECT * FROM interview_rounds WHERE is_active = 1;

-- Check meeting platforms
SELECT * FROM meeting_platforms WHERE is_active = 1;

-- Check duration presets
SELECT * FROM interview_duration_presets;

-- Check interview locations
SELECT * FROM interview_locations WHERE is_active = 1;
```

---

## ✅ Success Criteria

Configuration integration is working if:
- [x] Changing duration in config changes active button in form
- [x] Changing interview type in config changes selected type in form
- [x] Changing platform in config changes selected platform in form
- [x] Disabling WhatsApp in config hides checkbox in form
- [x] Changing reminder hours in config updates label in form
- [x] All changes persist after page refresh

---

## 🎉 What's Working Now

1. **Dynamic Interview Rounds** - Loaded from database
2. **Dynamic Duration Presets** - Loaded from database
3. **Dynamic Meeting Platforms** - Loaded from database (filtered by active)
4. **Dynamic Interview Locations** - Loaded from database with auto-fill
5. **Conditional Notifications** - Show/hide based on configuration
6. **Default Values** - All defaults come from configuration
7. **Fallback Behavior** - Works even if configuration doesn't exist

---

## 📝 Notes

- Configuration changes take effect **immediately** (no restart needed)
- Form always has fallback values if configuration is missing
- Deactivated items don't appear in form dropdowns
- All changes are saved to database and persist across sessions

---

**Ready to test? Start with Test 1 above!** 🚀
