# Database Schema Fix - MIS Reports

## Issue
The MIS Reports page was trying to use `cd_updated_at` column which doesn't exist in the `candidate_details` table.

**Error:**
```
Unknown column 'cd_updated_at' in 'field list'
```

---

## Solution Applied

### Changed Queries:
Instead of using non-existent `cd_updated_at`, we now use:
- **Interview date** (`ce_start_date` from `calendar_events` table) as a milestone
- **JOIN** with `calendar_events` to get interview dates for selected candidates

### Time to Hire Calculation:
```sql
-- OLD (BROKEN):
DATEDIFF(cd_updated_at, cd_created_at) as days_to_hire

-- NEW (WORKING):
DATEDIFF(ce.ce_start_date, cd.cd_created_at) as days_to_hire
FROM candidate_details cd
JOIN calendar_events ce ON cd.cd_name = ce.ce_can_name
WHERE cd.cd_status = 'Selected'
```

---

## Current Database Schema

### candidate_details table:
```
cd_id               - Primary Key
cd_rec_username     - Recruiter username
cd_name             - Candidate name
cd_email            - Email
cd_phone            - Phone number
cd_gender           - Gender
cd_job_title        - Job title
cd_source           - Source of candidate
cd_description      - Description
cd_resume_link      - Resume link
cd_status           - Status (New, Shortlisted, Selected, etc.)
cd_interview_status - Interview status flag
cd_created_at       - Timestamp (auto)
```

**Missing:** `cd_updated_at`, `cd_hired_date`

### calendar_events table:
```
ce_id              - Primary Key
ce_rec_username    - Recruiter username
ce_can_name        - Candidate name
ce_interviewer     - Interviewer username
ce_start_date      - Interview start datetime
ce_end_date        - Interview end datetime
ce_interview_round - Interview round number
```

---

## Recommendation: Add Missing Columns

For better tracking and accurate reporting, add these columns:

### 1. Add cd_updated_at (Auto-update timestamp):
```sql
ALTER TABLE candidate_details 
ADD COLUMN cd_updated_at TIMESTAMP NULL 
DEFAULT NULL 
ON UPDATE CURRENT_TIMESTAMP 
AFTER cd_created_at;
```

### 2. Add cd_hired_date (Manual hire date):
```sql
ALTER TABLE candidate_details 
ADD COLUMN cd_hired_date DATETIME NULL 
AFTER cd_status;
```

### 3. Update existing records (optional):
```sql
-- Set cd_updated_at to cd_created_at for existing records
UPDATE candidate_details 
SET cd_updated_at = cd_created_at 
WHERE cd_updated_at IS NULL;

-- Set cd_hired_date from interview dates for selected candidates
UPDATE candidate_details cd
INNER JOIN calendar_events ce ON cd.cd_name = ce.ce_can_name
SET cd.cd_hired_date = ce.ce_start_date
WHERE cd.cd_status = 'Selected' 
AND cd.cd_hired_date IS NULL;
```

---

## After Adding Columns

Once you add the recommended columns, update the controller methods:

### In `A_dashboard.php`:

**Update `reports_view()` method:**
```php
// Change from:
$this->db->select('DATEDIFF(ce.ce_start_date, cd.cd_created_at) as days_to_hire');
$this->db->from('candidate_details cd');
$this->db->join('calendar_events ce', 'cd.cd_name = ce.ce_can_name', 'inner');

// To:
$this->db->select('DATEDIFF(cd_hired_date, cd_created_at) as days_to_hire');
$this->db->from('candidate_details cd');
$this->db->where('cd_hired_date IS NOT NULL');
```

**Update `get_time_to_hire_by_role()` method:**
```php
// Change from:
$this->db->select('cd.cd_job_title, AVG(DATEDIFF(ce.ce_start_date, cd.cd_created_at)) as avg_days');
$this->db->join('calendar_events ce', 'cd.cd_name = ce.ce_can_name', 'inner');

// To:
$this->db->select('cd_job_title, AVG(DATEDIFF(cd_hired_date, cd_created_at)) as avg_days');
$this->db->where('cd_hired_date IS NOT NULL');
```

**Update trend methods to use `cd_updated_at`:**
```php
// In get_recruitment_trend_data() and get_monthly_hiring_data()
// Change from:
$this->db->where('DATE_FORMAT(cd_created_at, "%Y-%m")', $month);

// To (for selected/hired counts):
$this->db->where('DATE_FORMAT(cd_updated_at, "%Y-%m")', $month);
// or
$this->db->where('DATE_FORMAT(cd_hired_date, "%Y-%m")', $month);
```

---

## Benefits of Adding These Columns

### cd_updated_at:
- Track when candidate status changes
- Better audit trail
- More accurate reporting of status changes
- Automatic updates on any record modification

### cd_hired_date:
- Precise hire date tracking
- Accurate time-to-hire calculations
- Better monthly/quarterly hiring reports
- Separate from interview date (interview ≠ hire)

---

## Status

✅ **Current:** Working with interview dates as proxy  
⚠️ **Recommended:** Add missing columns for accurate tracking  
📊 **Impact:** Reports work now, but will be more accurate with proper columns

---

## Files Modified

1. `application/controllers/A_dashboard.php`
   - Fixed `reports_view()` method
   - Fixed `get_recruitment_trend_data()` method
   - Fixed `get_monthly_hiring_data()` method
   - Fixed `get_time_to_hire_by_role()` method

2. `REPORTS_DUMMY_DATA_REMOVAL.md`
   - Updated documentation with schema notes

---

**Last Updated:** May 24, 2026  
**Status:** ✅ Fixed and Working
