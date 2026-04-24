# RMS Production Deployment Guide
## Recruitment Management System - https://rms.lankantech.com/

---

## 📋 Table of Contents
1. [Server Information](#server-information)
2. [Centralized Configuration](#centralized-configuration)
3. [Pre-Deployment Checklist](#pre-deployment-checklist)
4. [Deployment Steps](#deployment-steps)
5. [Post-Deployment Verification](#post-deployment-verification)
6. [Troubleshooting](#troubleshooting)
7. [Maintenance](#maintenance)

---

## 🖥️ Server Information

### Production Server Details
- **Domain**: https://rms.lankantech.com/
- **Server Type**: cPanel/Linux Hosting
- **PHP Version**: 7.4+ (Recommended: 7.4 or 8.0)
- **Database**: MySQL 5.7+ / MariaDB

### Database Credentials
```
Hostname: localhost
Username: cmsadver_rmsdbuser
Password: Charaka@321
Database: cmsadver_rmsdb
```

### cPanel Access
- **cPanel URL**: https://yourdomain.com:2083
- **Username**: cmsadver
- **Database Prefix**: cmsadver_

---

## ⚙️ Centralized Configuration

### New Configuration System
We've implemented a centralized configuration system that automatically detects the environment and applies the correct settings.

### Configuration File: `application/config/environment.php`

This single file manages all environment-specific settings:

#### Production Environment (Auto-detected)
- Triggered when domain contains: `lankantech.com` or `rms.lankantech.com`
- Base URL: `https://rms.lankantech.com/`
- Database: Production credentials
- Debug: Disabled
- Error Display: Disabled

#### Development Environment (Auto-detected)
- Triggered when running on: `localhost`
- Base URL: `http://localhost/rms/`
- Database: Local credentials
- Debug: Enabled
- Error Display: Enabled

### Benefits of Centralized Configuration
✅ **Single Point of Management**: Update one file instead of multiple
✅ **Auto Environment Detection**: No manual switching needed
✅ **Secure**: Sensitive data in one protected file
✅ **Easy Maintenance**: Clear and organized settings
✅ **Version Control Friendly**: Easy to manage different environments

---

## ✅ Pre-Deployment Checklist

### 1. Files to Update Before Deployment

#### A. Environment Configuration
**File**: `application/config/environment.php`

Update these settings if needed:
```php
// Email Settings (Lines 60-65)
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_USER', 'your-email@gmail.com');
define('SMTP_PASS', 'your-app-password');
define('SMTP_FROM', 'noreply@lankantech.com');

// Security (Line 74)
define('ENCRYPTION_KEY', 'your-32-character-key-here');
```

#### B. .htaccess File
**File**: `.htaccess` (in root directory)

Create if doesn't exist:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /
    
    # Remove index.php from URLs
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php/$1 [L]
    
    # Force HTTPS
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
</IfModule>

# Disable directory browsing
Options -Indexes

# Protect sensitive files
<FilesMatch "(^#.*#|\.(bak|conf|dist|fla|in[ci]|log|psd|sh|sql|sw[op])|~)$">
    Order allow,deny
    Deny from all
    Satisfy All
</FilesMatch>
```

### 2. Files to Exclude from Upload
❌ Do NOT upload these files:
- `.git/` folder
- `.env` files (if any)
- `CPANEL_DEPLOYMENT_CHECKLIST.md`
- `COMPREHENSIVE_SYSTEM_DESIGN_DIAGRAM.md`
- Local development files
- `load_sample_data.php` (delete after use)

### 3. Required Folders
✅ Ensure these folders exist and are writable:
```
uploads/
uploads/resumes/
uploads/photos/
uploads/documents/
uploads/referrals/
application/cache/
application/logs/
```

---

## 🚀 Deployment Steps

### Step 1: Backup Current System (If Updating)
```bash
# In cPanel File Manager or via SSH
tar -czf rms_backup_$(date +%Y%m%d).tar.gz public_html/
```

### Step 2: Upload Files to Server

#### Option A: Using cPanel File Manager
1. Login to cPanel: https://yourdomain.com:2083
2. Go to **File Manager**
3. Navigate to `public_html/` (or your web root)
4. Upload your RMS files
5. Extract if uploaded as ZIP

#### Option B: Using FTP/SFTP
```
Host: ftp.lankantech.com
Username: cmsadver
Port: 21 (FTP) or 22 (SFTP)
Protocol: FTP or SFTP
```

Upload all files to: `/public_html/` or `/public_html/rms/`

### Step 3: Set File Permissions

In cPanel File Manager or via SSH:
```bash
# Set folder permissions (755)
find . -type d -exec chmod 755 {} \;

# Set file permissions (644)
find . -type f -exec chmod 644 {} \;

# Make specific folders writable
chmod 777 application/cache
chmod 777 application/logs
chmod 777 uploads
chmod 777 uploads/resumes
chmod 777 uploads/photos
chmod 777 uploads/documents
chmod 777 uploads/referrals
```

### Step 4: Database Setup

#### A. Create Database (if not exists)
1. cPanel → **MySQL Databases**
2. Database already exists: `cmsadver_rmsdb`
3. User already exists: `cmsadver_rmsdbuser`
4. Verify user has ALL PRIVILEGES on database

#### B. Import Database
1. cPanel → **phpMyAdmin**
2. Select database: `cmsadver_rmsdb`
3. Click **Import** tab
4. Choose your SQL file
5. Click **Go**

### Step 5: Verify Configuration

The system will automatically use production settings when accessed via `rms.lankantech.com`.

Verify in `application/config/environment.php`:
- Production domain detection is correct (Line 15-16)
- Database credentials are correct (Lines 22-25)
- Base URL is correct (Line 19)

### Step 6: Security Hardening

#### A. Protect environment.php
Add to `.htaccess`:
```apache
<Files "environment.php">
    Order allow,deny
    Deny from all
</Files>
```

#### B. Generate Encryption Key
```php
// Generate a secure 32-character key
$key = bin2hex(random_bytes(16));
echo $key; // Use this in environment.php
```

#### C. Update index.php Environment
**File**: `index.php` (Line 54)
```php
define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'production');
```

---

## ✅ Post-Deployment Verification

### 1. Basic Functionality Tests
- [ ] Homepage loads: https://rms.lankantech.com/
- [ ] HTTPS is working (SSL certificate)
- [ ] Login page accessible
- [ ] Can login with credentials
- [ ] Dashboard displays correctly
- [ ] No PHP errors visible

### 2. Database Connection Test
Create temporary file: `test_connection.php`
```php
<?php
$conn = mysqli_connect('localhost', 'cmsadver_rmsdbuser', 'Charaka@321', 'cmsadver_rmsdb');
if ($conn) {
    echo "✅ Database connected successfully!";
    echo "<br>Server: " . mysqli_get_server_info($conn);
} else {
    echo "❌ Connection failed: " . mysqli_connect_error();
}
mysqli_close($conn);
?>
```
Access: https://rms.lankantech.com/test_connection.php
**Delete this file after testing!**

### 3. Feature Testing Checklist
Test all 28 features:
- [ ] Job Posting & Distribution (4 features)
- [ ] Referral & Sourcing (4 features)
- [ ] Employer Branding (4 features)
- [ ] Recruitment Marketing (4 features)
- [ ] CRM & Automation (4 features)
- [ ] Events & Advocacy (4 features)
- [ ] Analytics & Reporting (4 features)

### 4. File Upload Test
- [ ] Upload resume in candidate profile
- [ ] Upload photo in media gallery
- [ ] Check files are saved in correct folders

### 5. Email Test (if configured)
- [ ] Test email sending functionality
- [ ] Verify SMTP settings work

---

## 🔧 Troubleshooting

### Issue 1: Blank Page / White Screen
**Symptoms**: Page loads but shows nothing

**Solutions**:
1. Check PHP error logs in cPanel
2. Enable error display temporarily:
```php
// Add to index.php (top, after <?php)
error_reporting(E_ALL);
ini_set('display_errors', 1);
```
3. Check file permissions
4. Verify .htaccess is correct

### Issue 2: Database Connection Error
**Symptoms**: "Unable to connect to database"

**Solutions**:
1. Verify credentials in `environment.php`
2. Check database exists in cPanel
3. Verify user has privileges
4. Test connection with test_connection.php

### Issue 3: 404 Errors on Pages
**Symptoms**: Homepage works but other pages show 404

**Solutions**:
1. Check .htaccess exists and is correct
2. Verify mod_rewrite is enabled (contact host)
3. Check base_url in config
4. Try adding index.php to URL temporarily

### Issue 4: CSS/JS Not Loading
**Symptoms**: Page loads but no styling

**Solutions**:
1. Check base_url is correct with trailing slash
2. Verify assets folder uploaded correctly
3. Check file permissions (644)
4. Clear browser cache
5. Check browser console for errors

### Issue 5: Session/Login Issues
**Symptoms**: Can't login or session expires immediately

**Solutions**:
1. Check session folder is writable
2. Verify cookie settings in environment.php
3. Check COOKIE_SECURE is TRUE for HTTPS
4. Clear browser cookies

### Issue 6: File Upload Fails
**Symptoms**: Cannot upload files

**Solutions**:
1. Check folder permissions (777)
2. Verify upload folders exist
3. Check PHP upload_max_filesize
4. Check disk space on server

---

## 🔒 Security Best Practices

### 1. Protect Sensitive Files
```apache
# Add to .htaccess
<FilesMatch "(environment\.php|database\.php|config\.php)$">
    Order allow,deny
    Deny from all
</FilesMatch>
```

### 2. Regular Backups
```bash
# Database backup (via cPanel or command)
mysqldump -u cmsadver_rmsdbuser -p cmsadver_rmsdb > backup_$(date +%Y%m%d).sql

# Files backup
tar -czf files_backup_$(date +%Y%m%d).tar.gz public_html/
```

### 3. Update Regularly
- Keep CodeIgniter updated
- Update PHP version
- Monitor security advisories

### 4. Monitor Logs
- Check `application/logs/` regularly
- Monitor cPanel error logs
- Set up log rotation

---

## 📊 Maintenance

### Daily Tasks
- Monitor error logs
- Check system performance
- Verify backups running

### Weekly Tasks
- Review user activity
- Check disk space
- Test critical features

### Monthly Tasks
- Full system backup
- Security audit
- Performance optimization
- Database optimization:
```sql
OPTIMIZE TABLE table_name;
```

### Quarterly Tasks
- Update dependencies
- Review and update documentation
- Security penetration testing
- Performance benchmarking

---

## 📞 Support Contacts

### Technical Support
- **Developer**: [Your Contact]
- **Hosting Support**: cPanel Support
- **Domain**: LankanTech Support

### Emergency Contacts
- **Database Issues**: Check cPanel phpMyAdmin
- **Server Down**: Contact hosting provider
- **Security Breach**: Immediately change passwords, check logs

---

## 📝 Quick Reference

### Important URLs
- **Production Site**: https://rms.lankantech.com/
- **cPanel**: https://yourdomain.com:2083
- **phpMyAdmin**: Via cPanel
- **File Manager**: Via cPanel

### Important Files
- **Environment Config**: `application/config/environment.php`
- **Database Config**: `application/config/database.php`
- **Main Config**: `application/config/config.php`
- **URL Rewrite**: `.htaccess`
- **Entry Point**: `index.php`

### Important Folders
- **Application**: `application/`
- **Uploads**: `uploads/`
- **Assets**: `assets/`
- **Logs**: `application/logs/`
- **Cache**: `application/cache/`

---

## ✅ Deployment Completion Checklist

- [ ] Files uploaded to server
- [ ] File permissions set correctly
- [ ] Database imported successfully
- [ ] Configuration verified
- [ ] .htaccess in place
- [ ] HTTPS working
- [ ] Login tested
- [ ] All features tested
- [ ] Error logs checked
- [ ] Backup created
- [ ] Documentation updated
- [ ] Team notified
- [ ] Monitoring enabled

---

**Document Version**: 1.0  
**Last Updated**: November 15, 2024  
**Deployment Date**: [To be filled]  
**Deployed By**: [Your Name]  

---

**🎉 Your RMS system is now live at https://rms.lankantech.com/**
