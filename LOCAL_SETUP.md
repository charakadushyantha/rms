# Local Development Environment Setup

## ✅ Current Status
- Production site: **Working** ✅
- Local environment: **Needs setup**

## 📋 Local Setup Steps

### 1. Database Setup

#### Create Local Database
```sql
CREATE DATABASE cmsadver_rmsdb CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

#### Import Database
If you have a database dump from production:
```bash
mysql -u root -p cmsadver_rmsdb < database_backup.sql
```

Or use phpMyAdmin to import the SQL file.

#### Create Admin User (if database is empty)
```sql
USE cmsadver_rmsdb;

INSERT INTO users (u_username, u_password, u_email, u_role, u_status) 
VALUES ('admin', MD5('admin123'), 'admin@localhost', 'Admin', 'Active');
```

### 2. File Configuration

#### .htaccess (Already configured for local)
- RewriteBase is set to `/rms/`
- This is correct for `http://localhost/rms/`

#### Environment Detection
The system automatically detects:
- **Production**: When domain contains "lankantech.com" OR path contains "/home/cmsadver/" OR `.production` file exists
- **Local**: Everything else (defaults to localhost)

### 3. Access Local Site

#### URL
```
http://localhost/rms/
```

**Note**: Use `http://` NOT `https://` for localhost (unless you have SSL configured)

#### Login Credentials
```
Username: admin
Password: admin123
```

### 4. Common Local Issues & Solutions

#### Issue 1: "Connection is not private" (SSL Error)
**Solution**: Use `http://localhost/rms/` instead of `https://`

#### Issue 2: 404 Errors on all pages
**Solution**: 
- Make sure mod_rewrite is enabled in Apache
- Check that `.htaccess` file exists in root directory
- Verify `RewriteBase /rms/` matches your folder name

#### Issue 3: Database connection error
**Solution**:
- Check MySQL is running
- Verify database name is `cmsadver_rmsdb`
- Default credentials: username=`root`, password=`` (empty)
- Update `application/config/environment.php` if needed

#### Issue 4: Blank page or PHP errors
**Solution**:
- Check PHP version (requires PHP 7.4+)
- Enable error display in `php.ini`:
  ```ini
  display_errors = On
  error_reporting = E_ALL
  ```

### 5. Enable mod_rewrite (if needed)

#### Windows (XAMPP)
1. Open `xampp/apache/conf/httpd.conf`
2. Find and uncomment:
   ```
   LoadModule rewrite_module modules/mod_rewrite.so
   ```
3. Find `AllowOverride None` and change to `AllowOverride All`
4. Restart Apache

#### Linux/Mac
```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### 6. Verify Setup

Visit: `http://localhost/rms/diagnose.php`

This will show:
- Current domain detection
- Environment (should show "development")
- Database connection status

### 7. File Structure
```
rms/
├── .htaccess (local version)
├── .production (only on production server)
├── index.php
├── application/
│   ├── config/
│   │   ├── environment.php (auto-detects environment)
│   │   ├── config.php
│   │   └── constants.php
│   ├── controllers/
│   ├── models/
│   └── views/
├── system/
└── Assets/
```

### 8. Switching Between Environments

The system automatically detects the environment:

**Local Development**:
- URL: `http://localhost/rms/`
- Database: `cmsadver_rmsdb` (local MySQL)
- Debug: ON
- No `.production` file

**Production**:
- URL: `https://rms.lankantech.com/`
- Database: `cmsadver_rmsdb` (production MySQL)
- Debug: OFF
- Has `.production` file

### 9. Quick Test

1. Start XAMPP/WAMP/MAMP
2. Make sure Apache and MySQL are running
3. Visit: `http://localhost/rms/`
4. Should see login page
5. Login with: `admin` / `admin123`

### 10. Troubleshooting

If you still have issues, check:
1. Apache error log: `xampp/apache/logs/error.log`
2. PHP error log: `xampp/php/logs/php_error_log`
3. CodeIgniter logs: `application/logs/`

## 🔧 Need Help?

If you encounter any specific error messages, share them and I can help troubleshoot!
