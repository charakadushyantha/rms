# Company Settings Module - Setup Guide

## Overview
The Company Settings module provides comprehensive management of company information, organizational structure, and business configuration.

## Features

### 1. Company Profile
- Company name, logo, and contact information
- Physical address with city, state, country, and postal code
- Legal information (registration number, tax ID)
- Website URL
- Business hours configuration
- Financial year settings

### 2. Department Management
- Create and manage organizational departments
- Assign department heads
- Add descriptions for each department
- Full CRUD operations (Create, Read, Update, Delete)

### 3. Branch/Location Management
- Manage multiple office locations
- Unique branch codes for identification
- Complete address information for each branch
- Contact details (phone, email)
- Branch manager assignment
- Full CRUD operations

## Installation

### Step 1: Run Database Migration
Execute the SQL file to create required tables:

```sql
-- Run this in your MySQL database
source database_migrations/company_settings_tables.sql
```

Or manually execute the SQL commands in phpMyAdmin or your preferred MySQL client.

### Step 2: Create Upload Directory
Create the directory for company logo uploads:

```bash
mkdir -p uploads/company
chmod 777 uploads/company
```

On Windows (using Command Prompt):
```cmd
mkdir uploads\company
```

### Step 3: Access the Module
Navigate to: `http://localhost/rms/Setup/company_settings`

Or access via Admin Dashboard → Setup → Company Settings

## Database Tables

### company_settings
Stores core company information and configuration.

**Key Fields:**
- company_name, company_email, company_phone
- company_logo (file path)
- address fields (address, city, state, country, postal_code)
- registration_number, tax_id
- business_hours_start, business_hours_end
- financial_year_start, financial_year_end

### departments
Manages organizational departments.

**Key Fields:**
- department_name
- department_head
- description

### branches
Manages company branches/locations.

**Key Fields:**
- branch_name, branch_code
- address, city, state, country, postal_code
- phone, email
- manager

## Usage

### Managing Company Profile
1. Go to Setup → Company Settings
2. Click on "Company Profile" tab
3. Fill in company information
4. Upload company logo (max 2MB, JPG/PNG/GIF)
5. Set business hours and financial year
6. Click "Save Company Profile"

### Managing Departments
1. Go to "Departments" tab
2. Click "Add Department"
3. Enter department name, head, and description
4. Click "Add Department"
5. Edit or delete departments using action buttons

### Managing Branches
1. Go to "Branches" tab
2. Click "Add Branch"
3. Fill in branch details including:
   - Branch name and unique code
   - Complete address
   - Contact information
   - Branch manager
4. Click "Add Branch"
5. Edit or delete branches using action buttons

## Features Included

✅ Modern tabbed interface
✅ Responsive design
✅ SweetAlert2 confirmations for deletions
✅ Image upload for company logo
✅ Form validation
✅ Success/error flash messages
✅ Full CRUD operations for all entities
✅ Sample data included

## File Structure

```
application/
├── controllers/
│   └── Setup.php (company_settings methods added)
├── views/
│   └── Admin_dashboard_view/
│       └── Setup/
│           ├── index.php (updated with Company Settings card)
│           └── company_settings.php (new)
database_migrations/
└── company_settings_tables.sql
uploads/
└── company/ (for logo uploads)
```

## API Endpoints

- `GET  /Setup/company_settings` - View company settings page
- `POST /Setup/save_company_profile` - Save company profile
- `POST /Setup/add_department` - Add new department
- `POST /Setup/update_department` - Update department
- `GET  /Setup/delete_department/{id}` - Delete department
- `POST /Setup/add_branch` - Add new branch
- `POST /Setup/update_branch` - Update branch
- `GET  /Setup/delete_branch/{id}` - Delete branch

## Security Notes

- Only authenticated admin users can access these settings
- File uploads are restricted to images only (JPG, PNG, GIF)
- Maximum upload size: 2MB
- All user inputs are sanitized using htmlspecialchars()
- Delete operations require confirmation

## Troubleshooting

### Logo Upload Not Working
- Check if `uploads/company/` directory exists
- Verify directory has write permissions (777 on Linux)
- Ensure file size is under 2MB
- Check allowed file types (jpg, jpeg, png, gif)

### Tables Not Found Error
- Run the SQL migration file
- Verify tables were created in your database
- Check database connection in config

### Permission Denied
- Ensure you're logged in as Admin
- Check session authentication

## Future Enhancements

Potential additions:
- Document storage for company files
- Multi-language support
- Company holidays calendar
- Employee count per department
- Branch performance metrics
- Department budget tracking

## Support

For issues or questions, refer to the main RMS documentation or contact the development team.
