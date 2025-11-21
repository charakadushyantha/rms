# ⚠️ IMPORTANT - RUN THIS FIRST!

## 🔴 Error You're Seeing

```
Unknown column 'section' in 'order clause'
```

## ✅ Solution (2 Steps)

### Step 1: Run Database Update Script

**Open this URL in your browser:**
```
http://localhost/rms/update_module_visibility_complete.php
```

**What it does:**
- Adds `module_name` column to `module_visibility` table
- Adds `section` column to `module_visibility` table  
- Inserts all 47 system modules
- Organizes them by section

**Expected output:**
```
✅ Table structure updated
✅ 36 new modules added
✅ 11 existing modules updated
✅ Module Visibility System Updated!
47 total system modules are now tracked.
```

### Step 2: Refresh Module Manager

**After the script completes:**
```
1. Go to: http://localhost/rms/Setup/module_manager
2. You should now see ALL 47 modules
3. No more errors!
```

## 🎯 Why This Happened

The `module_visibility` table was created with only these columns:
- `id`
- `module_key`
- `is_visible`
- `updated_at`

But the updated Module Manager needs:
- `module_name` (to display proper names)
- `section` (to group modules)

The update script adds these columns and populates them.

## ⏱️ Time Required

**Total: 30 seconds**
- Run script: 10 seconds
- Refresh page: 5 seconds
- Verify: 15 seconds

## 📞 Still Getting Errors?

### Error: "Table 'module_visibility' doesn't exist"
**Solution**: Run `create_modules_table.php` first, then run the update script

### Error: "Connection failed"
**Solution**: Check database credentials in `update_module_visibility_complete.php`:
```php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'rmsdb';
```

### Error: "Access denied"
**Solution**: Update database password in the script

## ✅ Success Indicators

After running the script, you should see:
- ✅ No errors on Module Manager page
- ✅ 47 modules displayed (not 11)
- ✅ Modules grouped by section
- ✅ Toggle switches for all modules
- ✅ Can save visibility settings

## 🚀 Next Steps

After the update:
1. ✅ Module Manager works perfectly
2. ✅ All 47 modules controllable
3. ✅ Can add custom modules
4. ✅ Sidebar respects visibility settings

---

**Ready? Run the script now!**
👉 http://localhost/rms/update_module_visibility_complete.php
