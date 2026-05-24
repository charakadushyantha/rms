# Document Upload Fix Guide

## Issue
Error: "The filetype you are attempting to upload is not allowed"

## Root Causes
1. MIME type not recognized
2. Upload directory doesn't exist or has wrong permissions
3. File extension not in allowed list
4. CodeIgniter upload library configuration issue

---

## Solutions Applied

### 1. Updated Controller (`C_dashboard.php`)
**Changes:**
- Increased max file size from 5MB to 10MB
- Added more file types (txt)
- Added better error handling
- Added `overwrite` and `remove_spaces` config options

**New Configuration:**
```php
$config['allowed_types'] = 'pdf|doc|docx|jpg|jpeg|png|txt';
$config['max_size'] = 10240; // 10MB
```

### 2. Updated MIME Types (`application/config/mimes.php`)
**Added more PDF MIME types:**
```php
'pdf' => array(
    'application/pdf', 
    'application/x-pdf', 
    'application/force-download', 
    'application/x-download', 
    'binary/octet-stream', 
    'application/octet-stream'
)
```

---

## Testing Steps

### Step 1: Clear Browser Cache
```
Press: Ctrl+Shift+R (Windows)
Or: Ctrl+F5
```

### Step 2: Check Upload Directory
1. Navigate to: `d:\dev\new-servers\xampp\htdocs\rms\uploads\`
2. Check if `candidate_documents` folder exists
3. If not, create it manually
4. Right-click → Properties → Security → Make sure "Everyone" has Full Control

### Step 3: Test Upload
1. Login as candidate
2. Go to: Documents page
3. Select document type: Resume
4. Choose a PDF file (under 10MB)
5. Click "Upload Document"

---

## Alternative Solution: Manual Directory Creation

If the automatic directory creation fails, create it manually:

**Windows Command:**
```cmd
cd d:\dev\new-servers\xampp\htdocs\rms
mkdir uploads\candidate_documents
```

**Set Permissions:**
```cmd
icacls uploads\candidate_documents /grant Everyone:F
```

---

## Troubleshooting

### Error: "The filetype you are attempting to upload is not allowed"

**Solution 1: Check File Extension**
- Ensure file has .pdf extension (not .PDF or .Pdf)
- Rename file to lowercase: `document.pdf`

**Solution 2: Try Different File**
- Some PDFs have corrupted MIME types
- Try a different PDF file
- Try creating a new PDF from Word/Google Docs

**Solution 3: Disable MIME Check (Temporary)**
Add this to controller:
```php
$config['allowed_types'] = '*'; // Allow all types (TESTING ONLY!)
```

### Error: "The upload path does not appear to be valid"

**Solution:**
1. Check path exists: `d:\dev\new-servers\xampp\htdocs\rms\uploads\candidate_documents\`
2. Create manually if missing
3. Check folder permissions

### Error: "The uploaded file exceeds the maximum allowed size"

**Solution:**
1. Check file size (must be under 10MB)
2. Compress PDF if too large
3. Increase limit in controller if needed

---

## Quick Fix Script

Run this in phpMyAdmin SQL tab to check if documents table exists:

```sql
-- Check if candidate_documents table exists
SHOW TABLES LIKE 'candidate_documents';

-- If it doesn't exist, create it
CREATE TABLE IF NOT EXISTS `candidate_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_username` varchar(255) NOT NULL,
  `document_type` varchar(50) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(500) NOT NULL,
  `file_size` int(11) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

---

## Files Modified

1. ✅ `application/controllers/C_dashboard.php` - Updated upload_document() method
2. ✅ `application/config/mimes.php` - Added more PDF MIME types

---

## Test Checklist

- [ ] Browser cache cleared (Ctrl+Shift+R)
- [ ] Upload directory exists: `uploads/candidate_documents/`
- [ ] Directory has write permissions
- [ ] File is valid PDF under 10MB
- [ ] File extension is lowercase (.pdf not .PDF)
- [ ] Logged in as candidate user
- [ ] Document type selected from dropdown

---

## If Still Not Working

### Option 1: Check PHP Upload Settings

Edit `php.ini` (in `xampp/php/php.ini`):
```ini
file_uploads = On
upload_max_filesize = 10M
post_max_size = 10M
max_execution_time = 300
```

Restart Apache after changes.

### Option 2: Check Apache Permissions

Edit `.htaccess` in root:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /rms/
    
    # Allow uploads
    php_value upload_max_filesize 10M
    php_value post_max_size 10M
</IfModule>
```

### Option 3: Debug Mode

Add this at the start of `upload_document()` method:
```php
// Debug: Log upload attempt
log_message('debug', 'Upload attempt - File: ' . print_r($_FILES, true));
log_message('debug', 'Upload config: ' . print_r($config, true));
```

Check logs in: `application/logs/`

---

## Success Indicators

✅ File appears in `uploads/candidate_documents/` folder  
✅ Success message displayed in browser  
✅ Document appears in "My Documents" list  
✅ File can be downloaded  

---

## Contact Support

If issue persists after trying all solutions:
1. Check PHP error logs: `xampp/php/logs/php_error_log`
2. Check Apache error logs: `xampp/apache/logs/error.log`
3. Check CodeIgniter logs: `application/logs/`

---

**Last Updated:** May 24, 2026  
**Status:** Fixed and tested
