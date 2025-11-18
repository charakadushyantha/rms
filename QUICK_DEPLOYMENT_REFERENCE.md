# 🚀 Quick Deployment Reference Card
## RMS - https://rms.lankantech.com/

---

## 📦 What Changed?

### ✅ Centralized Configuration System
All environment settings now managed in **ONE FILE**:
```
application/config/environment.php
```

### Auto-Detection
- **Production**: Detected when domain = `rms.lankantech.com`
- **Development**: Detected when domain = `localhost`

---

## 🔑 Production Credentials

```
Domain:   https://rms.lankantech.com/
Database: cmsadver_rmsdb
User:     cmsadver_rmsdbuser
Password: Charaka@321
Host:     localhost
```

---

## 📋 5-Minute Deployment

### 1. Upload Files
```
Upload to: /public_html/
Method: FTP or cPanel File Manager
```

### 2. Set Permissions
```bash
chmod 777 application/cache
chmod 777 application/logs
chmod 777 uploads
```

### 3. Import Database
```
cPanel → phpMyAdmin → Import SQL file
```

### 4. Verify
```
Visit: https://rms.lankantech.com/
Login and test
```

---

## 🔧 Files to Check

### Must Update (if needed):
1. `application/config/environment.php`
   - Email settings (Lines 60-65)
   - Encryption key (Line 74)

2. `.htaccess` (root directory)
   - Must exist for clean URLs

### Auto-Configured:
✅ `application/config/database.php` - Uses environment.php
✅ `application/config/config.php` - Uses environment.php

---

## ⚠️ Common Issues & Fixes

### Blank Page
```php
// Add to index.php temporarily
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

### Database Error
```
Check: application/config/environment.php
Lines: 22-25 (DB credentials)
```

### 404 Errors
```
Check: .htaccess exists in root
Check: base_url has trailing slash
```

### CSS Not Loading
```
Check: base_url = https://rms.lankantech.com/
Clear browser cache
```

---

## 📁 Folder Permissions

```
755 - All folders (default)
644 - All files (default)
777 - application/cache/
777 - application/logs/
777 - uploads/ (and subfolders)
```

---

## 🧪 Quick Tests

### Test Database Connection
Create `test_db.php`:
```php
<?php
$c = mysqli_connect('localhost','cmsadver_rmsdbuser','Charaka@321','cmsadver_rmsdb');
echo $c ? "✅ Connected" : "❌ Failed: ".mysqli_connect_error();
?>
```
**Delete after testing!**

### Test Environment Detection
Check which environment is active:
```php
// Add to any controller temporarily
echo "Environment: " . APP_ENVIRONMENT;
echo "<br>URL: " . APP_URL;
```

---

## 🔒 Security Checklist

- [ ] Change default passwords
- [ ] Generate new encryption key
- [ ] Set ENVIRONMENT to 'production' in index.php
- [ ] Disable error display in production
- [ ] Delete test files (test_db.php, etc.)
- [ ] Delete load_sample_data.php
- [ ] Protect environment.php via .htaccess
- [ ] Enable HTTPS (SSL certificate)
- [ ] Set up regular backups

---

## 📞 Emergency Contacts

**Hosting Issues**: cPanel Support  
**Database Issues**: phpMyAdmin in cPanel  
**Application Issues**: Check `application/logs/`

---

## 🎯 Success Indicators

✅ Site loads at https://rms.lankantech.com/  
✅ HTTPS (padlock) is showing  
✅ Login works  
✅ Dashboard displays  
✅ No PHP errors  
✅ All 28 features accessible  

---

## 📚 Full Documentation

See: `PRODUCTION_DEPLOYMENT_GUIDE.md`

---

**Quick Help**: If anything fails, check error logs in cPanel or `application/logs/`
