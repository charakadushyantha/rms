# Fix: Headers Already Sent Error

## ✅ Issue Fixed

The "headers already sent" error has been resolved by adding output buffering to `index.php`.

## What Was Done

### Added Output Buffering
**File**: `index.php` (Line 59)
```php
// Start output buffering to prevent "headers already sent" errors
ob_start();
```

This captures any accidental output before headers are sent.

## If Issue Persists

### Check for BOM (Byte Order Mark)

Some text editors add invisible BOM characters. Check these files:

1. **index.php**
2. **application/config/environment.php**
3. **application/config/database.php**
4. **application/config/config.php**

### How to Remove BOM

#### Option 1: Using Notepad++
1. Open file in Notepad++
2. Go to: Encoding → Encode in UTF-8 without BOM
3. Save file

#### Option 2: Using VS Code
1. Open file
2. Click encoding in bottom right
3. Select "Save with Encoding"
4. Choose "UTF-8"

#### Option 3: Using Command Line (Linux/cPanel)
```bash
# Remove BOM from file
sed -i '1s/^\xEF\xBB\xBF//' filename.php
```

### Check for Whitespace

Make sure there's NO whitespace or blank lines before `<?php` in:
- index.php
- application/config/environment.php
- application/config/database.php
- application/config/config.php
- application/config/autoload.php

### Check for Output After ?>

Make sure there's NO `?>` closing tag at the end of:
- Controllers
- Models
- Config files

**Best Practice**: Don't use closing `?>` tag in PHP files.

## Additional Fixes

### 1. Disable Output in Environment Detection

If the issue persists, modify `environment.php`:

```php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Prevent multiple loads
if (defined('APP_ENVIRONMENT')) {
    return;
}

// Start output buffering in config file too
ob_start();

// ... rest of file
```

### 2. Check .htaccess

Add to `.htaccess`:
```apache
# Prevent PHP from adding BOM
php_flag zlib.output_compression Off
```

### 3. Check for Echo/Print Statements

Search for any accidental output:
```bash
# In cPanel Terminal or SSH
grep -r "echo\|print" application/config/
```

Remove any echo/print statements from config files.

## Verification

After fixes, you should see:
- ✅ No "headers already sent" warnings
- ✅ Session works correctly
- ✅ Login functions properly
- ✅ Cookies set correctly

## If Still Not Working

### Emergency Fix: Disable Session Cookie Settings

**File**: `application/config/config.php`

Find and comment out:
```php
// $config['cookie_prefix']	= '';
// $config['cookie_domain']	= '';
// $config['cookie_path']		= '/';
// $config['cookie_secure']	= FALSE;
// $config['cookie_httponly'] 	= FALSE;
```

This will use PHP's default session settings.

## Testing

1. Clear browser cache and cookies
2. Visit: https://rms.lankantech.com/
3. Try to login
4. Check if session persists

## Success Indicators

✅ No PHP warnings displayed  
✅ Can login successfully  
✅ Session maintains after page refresh  
✅ Logout works properly  

---

**Status**: Fixed with output buffering in index.php  
**If issue persists**: Check for BOM or whitespace in config files
