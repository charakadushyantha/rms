# Database Migration Guide

## Issue: Missing `cd_created_at` Column

The warning message you're seeing indicates that the `candidate_details` table is missing the `cd_created_at` column, which is required for time-based statistics (This Month, This Week, Today).

## Solution

I've created a database migration controller to fix this issue. You have **two options**:

### Option 1: Use the Web Interface (Recommended)

1. **Click the "Add Column Now" button** in the warning message on the Selected Candidates page
   - URL: `http://localhost/rms/database_migration/add_created_at_column`

2. **Or check the database structure first:**
   - URL: `http://localhost/rms/database_migration/check_structure`
   - This will show you which columns exist and which are missing

### Option 2: Run SQL Manually

If you prefer to add the column manually via phpMyAdmin or MySQL command line:

```sql
-- Add cd_created_at column
ALTER TABLE `candidate_details` 
ADD COLUMN `cd_created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP;

-- Update existing records with current timestamp
UPDATE `candidate_details` 
SET `cd_created_at` = NOW() 
WHERE `cd_created_at` IS NULL;
```

## What the Migration Does

1. **Checks if the column already exists** - prevents duplicate column errors
2. **Adds `cd_created_at` column** with TIMESTAMP type
3. **Sets default value** to CURRENT_TIMESTAMP for new records
4. **Updates existing records** with the current timestamp

## After Migration

Once the column is added:
- ✅ The warning message will disappear
- ✅ Time-based statistics will work correctly
- ✅ "This Month", "This Week", and "Today" counts will show accurate data

## Optional: Add Updated At Column

You can also add a `cd_updated_at` column to track when candidate records are modified:

- URL: `http://localhost/rms/database_migration/add_updated_at_column`

## Available Migration URLs

| URL | Description |
|-----|-------------|
| `http://localhost/rms/database_migration/check_structure` | Check database structure |
| `http://localhost/rms/database_migration/add_created_at_column` | Add cd_created_at column |
| `http://localhost/rms/database_migration/add_updated_at_column` | Add cd_updated_at column (optional) |

## Troubleshooting

If you encounter any errors:

1. **Check database permissions** - ensure your database user has ALTER TABLE privileges
2. **Check table exists** - verify the `candidate_details` table exists
3. **Check for conflicts** - ensure no other process is locking the table

## Notes

- The migration is **safe to run multiple times** - it checks if the column exists first
- All existing candidate records will be timestamped with the current date/time
- New candidates will automatically get the timestamp when created
