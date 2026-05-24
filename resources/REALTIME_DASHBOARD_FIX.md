# Realtime Dashboard - Fix Summary

## Issue
The Realtime Dashboard was showing "Loading pipeline..." indefinitely with empty metrics.

## Root Causes
1. **Authentication Issue** - AJAX requests were being redirected to login page
2. **Wrong Table Names** - Model was using `candidates` table instead of `candidate_details`
3. **Column Name Mismatch** - Using `id`, `name`, `email` instead of `cd_id`, `cd_name`, `cd_email`

## Solutions Applied

### 1. Fixed Authentication for AJAX Requests
**File:** `application/controllers/Realtime_dashboard.php`

Added proper AJAX authentication handling:
```php
// For AJAX requests, return JSON error instead of redirecting
if ($this->input->is_ajax_request() || 
    strpos($this->input->server('HTTP_ACCEPT'), 'application/json') !== false) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Not authenticated']);
    exit;
}
```

### 2. Updated Model to Use Correct Tables
**File:** `application/models/Realtime_model.php`

**Changed:**
- `candidates` → `candidate_details`
- `c.id` → `cd.cd_id`
- `c.name` → `cd.cd_name`
- `c.email` → `cd.cd_email`
- `c.phone` → `cd.cd_phone`
- `c.position_applied` → `cd.cd_job_title`

### 3. Fixed Methods

#### `get_pipeline_overview()`
- Now joins with `candidate_details` table
- Uses correct column names (`cd_id`, `cd_name`, etc.)
- Added `days_in_stage` calculation
- Added error handling for failed queries

#### `get_dashboard_metrics()`
- Fixed to count unique candidates
- Uses `calendar_events` for today's interviews
- Calculates urgent candidates based on days in pipeline (>7 days)

#### `get_recent_activity()`
- Added fallback logic if `pipeline_activity_log` is empty
- Generates activity from `candidate_pipeline` changes
- Added `time_ago()` formatting function
- Fixed table joins to use `candidate_details`

#### `get_candidate_by_id()`
- Changed from `candidates.id` to `candidate_details.cd_id`

### 4. Added Helper Functions
- `format_activity_description()` - Formats activity messages
- `time_ago()` - Converts timestamps to "X minutes ago" format

## How to Use

### Step 1: Login First
You **MUST** be logged in to access the realtime dashboard:
1. Go to `http://localhost/rms/`
2. Login with your credentials
3. Then navigate to the realtime dashboard

### Step 2: Access Dashboard
Once logged in, visit:
```
http://localhost/rms/realtime_dashboard
```

### Step 3: Verify Data
The dashboard should now show:
- ✅ **Metrics Cards** - Total candidates, avg days, urgent count, today's interviews
- ✅ **Pipeline Stages** - Visual kanban board with candidates in each stage
- ✅ **Recent Activity** - Timeline of recent actions
- ✅ **Auto-Refresh** - Updates every 5 seconds (configurable)

## Dashboard Features

### Live Metrics
- **Total Candidates** - Count of unique candidates in pipeline
- **Avg Days in Pipeline** - Average time candidates spend in pipeline
- **Urgent** - Candidates stuck for more than 7 days
- **Today's Interviews** - Interviews scheduled for today

### Pipeline View
- Visual kanban board showing all stages
- Candidates displayed in each stage
- Days in stage for each candidate
- Quick actions: View, Edit, Assign

### Activity Feed
- Real-time activity updates
- Shows who moved which candidate
- Time ago formatting (e.g., "5 minutes ago")

### Settings
- Configurable auto-refresh interval (3s to 1min)
- Enable/disable notifications
- Enable/disable sound alerts

## Troubleshooting

### Issue: Still showing "Loading pipeline..."

**Solution 1: Check if you're logged in**
```
1. Open browser console (F12)
2. Check for 401/403 errors
3. If you see authentication errors, log in first
```

**Solution 2: Check if pipeline_stages has data**
```sql
SELECT * FROM pipeline_stages WHERE is_active = 1;
```
If empty, you need to create pipeline stages first.

**Solution 3: Check if candidate_pipeline has data**
```sql
SELECT COUNT(*) FROM candidate_pipeline;
```
If zero, you need to add candidates to the pipeline.

### Issue: Metrics showing zeros

This is normal if:
- No candidates in pipeline yet
- No interviews scheduled for today
- No candidates have been in pipeline for >7 days

### Issue: Activity feed empty

This is normal if:
- No recent pipeline movements
- `pipeline_activity_log` table is empty
- No candidates have been moved between stages recently

## Database Requirements

### Required Tables:
- ✅ `pipeline_stages` - Pipeline stage definitions
- ✅ `candidate_pipeline` - Candidate stage tracking
- ✅ `candidate_details` - Candidate information
- ✅ `calendar_events` - Interview scheduling
- ⚠️ `pipeline_activity_log` - Activity tracking (optional, has fallback)

### Sample Data Check:
```sql
-- Check pipeline stages
SELECT id, name, order_position, is_active FROM pipeline_stages;

-- Check candidates in pipeline
SELECT cp.id, cd.cd_name, ps.name as stage, cp.moved_at
FROM candidate_pipeline cp
JOIN candidate_details cd ON cd.cd_id = cp.candidate_id
JOIN pipeline_stages ps ON ps.id = cp.stage_id
ORDER BY cp.moved_at DESC
LIMIT 10;
```

## Next Steps

### If Dashboard is Empty:
1. **Create Pipeline Stages** (if not exist):
   ```sql
   INSERT INTO pipeline_stages (name, order_position, color, is_active) VALUES
   ('Applied', 1, '#6b7280', 1),
   ('Screening', 2, '#06b6d4', 1),
   ('Phone Interview', 3, '#f59e0b', 1),
   ('Technical Interview', 4, '#f97316', 1),
   ('Final Interview', 5, '#3b82f6', 1),
   ('Offer', 6, '#8b5cf6', 1),
   ('Hired', 7, '#22c55e', 1),
   ('Rejected', 8, '#ef4444', 1);
   ```

2. **Add Candidates to Pipeline**:
   ```sql
   -- Example: Add existing candidates to "Applied" stage
   INSERT INTO candidate_pipeline (candidate_id, stage_id, moved_by, moved_at)
   SELECT cd_id, 1, 1, NOW()
   FROM candidate_details
   WHERE cd_status = 'New'
   LIMIT 10;
   ```

3. **Refresh Dashboard**:
   - Click the "Refresh" button
   - Or wait for auto-refresh (5 seconds)

## Files Modified

1. ✅ `application/controllers/Realtime_dashboard.php` - Fixed AJAX authentication
2. ✅ `application/models/Realtime_model.php` - Updated to use correct tables and columns

## Status

✅ **FIXED** - Dashboard now works with existing database schema
✅ **TESTED** - All AJAX endpoints return proper JSON
✅ **DOCUMENTED** - Complete troubleshooting guide provided

---

**Last Updated:** May 24, 2026  
**Status:** Ready for use (requires login)
