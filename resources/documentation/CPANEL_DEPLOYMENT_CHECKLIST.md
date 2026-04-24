# cPanel Deployment Checklist - Case Sensitivity Issues Fixed

## ✅ Issues Found and Fixed

### 1. Model File Name Case Mismatch
- **File**: `profile_record_model.php` (lowercase)
- **Class**: `Profile_record_model` (capitalized)
- **Fix**: ✅ Renamed file to `Profile_record_model.php`
- **Fix**: ✅ Updated class name to match

### 2. All Other Files Verified
- ✅ All 40+ controllers: File names match class names
- ✅ All 35+ models: File names match class names (except the one fixed above)
- ✅ All views: Properly organized in folders

## 📋 Pre-Deployment Checklist

### File & Folder Structure
- [x] All controller files start with capital letter
- [x] All model files start with capital letter
- [x] All class names match file names exactly
- [ ] File permissions set correctly (644 for files, 755 for folders)

### Configuration Files to Update

#### 1. Database Configuration
**File**: `application/config/database.php`
```php
$db['default'] = array(
    'hostname' => 'localhost',           // Usually localhost on cPanel
    'username' => 'cpanel_username',     // Your cPanel MySQL username
    'password' => 'your_password',       // Your MySQL password
    'database' => 'cpanel_dbname',       // Your database name
    'dbdriver' => 'mysqli',
    // ... rest of config
);
```

#### 2. Base URL Configuration
**File**: `application/config/config.php`
```php
$config['base_url'] = 'https://yourdomain.com/';  // Your actual domain
```

#### 3. Index Page (Optional - for clean URLs)
**File**: `application/config/config.php`
```php
$config['index_page'] = '';  // Remove index.php from URLs
```

### .htaccess File
**File**: `.htaccess` (in root directory)
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php/$1 [L]
```

### File Permissions on cPanel
```bash
# Set folder permissions
find . -type d -exec chmod 755 {} \;

# Set file permissions
find . -type f -exec chmod 644 {} \;

# Make writable folders
chmod 777 application/cache
chmod 777 application/logs
chmod 777 uploads
```

## 🔍 Common cPanel Issues & Solutions

### Issue 1: "Unable to locate the model"
**Cause**: Case sensitivity (Linux is case-sensitive, Windows is not)
**Solution**: ✅ FIXED - File name now matches class name

### Issue 2: "404 Page Not Found"
**Cause**: Missing or incorrect .htaccess
**Solution**: 
1. Ensure .htaccess exists in root
2. Check if mod_rewrite is enabled
3. Update base_url in config.php

### Issue 3: "Database connection failed"
**Cause**: Incorrect database credentials
**Solution**: Update application/config/database.php with cPanel MySQL details

### Issue 4: "Permission denied" errors
**Cause**: Incorrect file permissions
**Solution**: Set correct permissions (see above)

### Issue 5: Blank page or 500 error
**Cause**: PHP errors not displayed
**Solution**: 
1. Check error logs in cPanel
2. Enable error display temporarily:
```php
// In index.php (top of file)
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

## 📁 Files That Must Be Writable

```
application/cache/          (755 or 777)
application/logs/           (755 or 777)
uploads/                    (755 or 777)
uploads/resumes/           (755 or 777)
uploads/photos/            (755 or 777)
uploads/documents/         (755 or 777)
uploads/referrals/         (755 or 777)
```

## 🗄️ Database Setup on cPanel

1. **Create Database**
   - Go to cPanel → MySQL Databases
   - Create new database: `cpanel_rms`

2. **Create User**
   - Create MySQL user
   - Set strong password

3. **Grant Privileges**
   - Add user to database
   - Grant ALL PRIVILEGES

4. **Import Database**
   - Go to phpMyAdmin
   - Select your database
   - Import your SQL file

5. **Update Config**
   - Update `application/config/database.php`

## 🚀 Deployment Steps

1. **Upload Files**
   - Use FTP/SFTP or cPanel File Manager
   - Upload to public_html or subdirectory

2. **Set Permissions**
   - Run permission commands (see above)

3. **Update Configuration**
   - database.php
   - config.php
   - .htaccess

4. **Import Database**
   - Use phpMyAdmin
   - Import your database

5. **Test Application**
   - Visit your domain
   - Test login
   - Check all features

## ✅ Verification Checklist

After deployment, verify:
- [ ] Homepage loads correctly
- [ ] Login works
- [ ] Dashboard displays
- [ ] All 28 features accessible
- [ ] Database connections work
- [ ] File uploads work
- [ ] No PHP errors in logs
- [ ] All images/CSS/JS load
- [ ] Forms submit correctly
- [ ] Reports generate

## 🔧 Troubleshooting Commands

### Check PHP Version
```bash
php -v
```

### Check File Permissions
```bash
ls -la application/
```

### View Error Logs
```bash
tail -f application/logs/log-*.php
```

### Test Database Connection
Create `test_db.php` in root:
```php
<?php
$conn = mysqli_connect('localhost', 'username', 'password', 'database');
if ($conn) {
    echo "Database connected successfully!";
} else {
    echo "Connection failed: " . mysqli_connect_error();
}
?>
```

## 📞 Support Resources

- CodeIgniter Documentation: https://codeigniter.com/userguide3/
- cPanel Documentation: https://docs.cpanel.net/
- PHP Documentation: https://www.php.net/docs.php

---

## Summary

✅ **All case-sensitivity issues have been fixed**
✅ **File name**: `Profile_record_model.php` (capitalized)
✅ **Class name**: `Profile_record_model` (capitalized)
✅ **All other files verified and correct**

Your application is now ready for cPanel deployment!
