# 🔧 Bot Troubleshooting Guide

## Issue: Bot Pages Not Displaying

All three bot URLs (`/bot`, `/bot/chat`, `/bot/widget`) are showing blank or not loading.

---

## Diagnostic Steps

### Step 1: Run Diagnostic Tool

Visit: `http://localhost/rms/bot_diagnostic.php`

This will check:
- ✅ All required files exist
- ✅ Database connection works
- ✅ Bot tables are created
- ✅ PHP configuration
- ✅ Server settings

### Step 2: Test Direct View Load

Visit: `http://localhost/rms/test_bot_direct.php`

This loads the chat interface directly without CodeIgniter to isolate the issue.

---

## Common Issues & Solutions

### Issue 1: Database Tables Not Created

**Symptoms:**
- Blank page
- PHP errors about missing tables
- Models fail to load

**Solution:**
```
Visit: http://localhost/rms/create_bot_tables.php
```

Wait for all tables to be created successfully.

### Issue 2: PHP Errors Not Showing

**Symptoms:**
- Blank white page
- No error messages

**Solution:**

Edit `index.php` and change:
```php
define('ENVIRONMENT', 'production');
```

To:
```php
define('ENVIRONMENT', 'development');
```

This will show PHP errors.

### Issue 3: Models Not Loading

**Symptoms:**
- Error: "Unable to locate the model you have specified"
- Blank page

**Solution:**

Check these files exist:
- `application/models/Bot_model.php`
- `application/models/Chat_history_model.php`
- `application/models/Candidate_model.php`

### Issue 4: Libraries Not Loading

**Symptoms:**
- Error: "Unable to load the requested class"
- Blank page

**Solution:**

Check these files exist:
- `application/libraries/BotEngine.php`
- `application/libraries/CvParser.php`
- `application/libraries/IntentRecognizer.php`
- `application/libraries/EntityExtractor.php`
- `application/libraries/AIService.php`

### Issue 5: View Files Missing or Empty

**Symptoms:**
- Blank page with no errors
- Page loads but shows nothing

**Solution:**

Check these files exist and have content:
- `application/views/bot/chat_interface.php` (should be ~15KB)
- `application/views/bot/chat_widget.php` (should be ~11KB)

If files are empty (0 bytes), they need to be recreated.

### Issue 6: Apache mod_rewrite Not Enabled

**Symptoms:**
- 404 errors
- "Page not found"
- URLs don't work

**Solution:**

1. Check if mod_rewrite is enabled in Apache
2. Verify `.htaccess` file exists in root
3. Check Apache config allows `.htaccess` overrides

### Issue 7: Base URL Not Configured

**Symptoms:**
- Links don't work
- AJAX calls fail
- Resources not loading

**Solution:**

Edit `application/config/config.php`:
```php
$config['base_url'] = 'http://localhost/rms/';
```

---

## Manual Testing Steps

### Test 1: Check Controller Exists
```
File: application/controllers/Bot.php
Should have methods: index(), chat(), widget(), send_message(), upload_cv()
```

### Test 2: Check Views Exist
```
File: application/views/bot/chat_interface.php
Should be a complete HTML page with chat interface
```

### Test 3: Check Database
```sql
SHOW TABLES LIKE 'chat_%';
SHOW TABLES LIKE 'bot_%';
```

Should show:
- chat_sessions
- chat_history
- bot_config
- bot_intents (if created)
- bot_entities (if created)

### Test 4: Check Apache Error Log
```
Location: xampp/apache/logs/error.log
Look for PHP errors related to Bot controller
```

---

## Quick Fix Checklist

- [ ] Run `create_bot_tables.php`
- [ ] Enable error display in `index.php`
- [ ] Check all model files exist
- [ ] Check all library files exist
- [ ] Check view files exist and have content
- [ ] Verify base_url is configured
- [ ] Check Apache mod_rewrite is enabled
- [ ] Clear browser cache
- [ ] Check Apache error logs

---

## Alternative: Use Standalone Demo

If the CodeIgniter integration isn't working, you can use the standalone demo:

Visit: `http://localhost/rms/bot_demo.html`

This is a fully functional bot interface that doesn't require CodeIgniter.

---

## Debug Mode

To see detailed errors, add this to the top of `application/controllers/Bot.php`:

```php
public function __construct() {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    parent::__construct();
    // ... rest of constructor
}
```

---

## Expected Behavior

### At `/bot`:
- Should see full-screen chat interface
- Purple gradient background
- White chat container in center
- "RecruitBot" header
- Welcome message
- Input field at bottom

### At `/bot/chat`:
- Should see dashboard header
- Chat widget in content area
- Dashboard footer

### At `/bot/widget`:
- Should see just the chat widget
- No dashboard wrapper

---

## Still Not Working?

### Check These:

1. **PHP Version**: Requires PHP 7.4+
   ```
   php -v
   ```

2. **CodeIgniter Version**: Should be 3.x
   ```
   Check system/core/CodeIgniter.php
   ```

3. **File Permissions**: Views should be readable
   ```
   chmod 644 application/views/bot/*.php
   ```

4. **Session Configuration**: Check `application/config/config.php`
   ```php
   $config['sess_driver'] = 'files';
   $config['sess_save_path'] = APPPATH . 'cache/';
   ```

5. **Database Connection**: Test with `test_central_config.php`

---

## Emergency Fallback

If nothing works, use the standalone HTML version:

1. Copy `bot_demo.html` to your web root
2. Open `http://localhost/rms/bot_demo.html`
3. This version works without any backend

---

## Getting Help

If you've tried everything:

1. Run `bot_diagnostic.php` and note the results
2. Check Apache error log for PHP errors
3. Enable development mode in `index.php`
4. Test with `test_bot_direct.php`
5. Try the standalone `bot_demo.html`

---

## Success Indicators

✅ No PHP errors in Apache log  
✅ Database tables exist  
✅ All files present and have content  
✅ Base URL configured correctly  
✅ mod_rewrite enabled  
✅ Chat interface loads and displays  
✅ Can type and send messages  
✅ Bot responds to messages  

---

**Last Updated:** November 16, 2025  
**Version:** 1.0.1
