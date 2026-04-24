# User Activation System Guide

## 🔐 Overview

The RMS now includes a **User Activation System** where administrators must activate new users before they can log in. This adds an extra layer of security and control.

---

## 🎯 How It Works

### 1. **User Creation**
When an admin creates a new user:
- User is created with status: **"Inactive"**
- User receives credentials but **cannot log in yet**
- User will see: *"Account is not activated. Please contact administrator."*

### 2. **Admin Activation**
Admin must manually activate the user:
- Go to **Setup → Manage Users**
- Find the user with **Inactive** status (gray badge)
- Click the **green checkmark button** to activate
- User status changes to **Active** (green badge)
- User can now log in successfully

### 3. **User Login**
- **Active users**: Can log in normally
- **Inactive users**: See activation message
- **Suspended users**: Account is locked

---

## 📊 User Status Types

### 🟢 Active
- **Color**: Green badge
- **Icon**: ✓ Check circle
- **Access**: Full login access
- **Description**: User can log in and use the system

### ⚪ Inactive
- **Color**: Gray badge
- **Icon**: ✗ Times circle
- **Access**: Login blocked
- **Description**: New users or deactivated accounts

### 🔴 Suspended
- **Color**: Red badge
- **Icon**: 🚫 Ban
- **Access**: Login blocked
- **Description**: Account temporarily locked (disciplinary action)

---

## 🔧 Admin Actions

### Activate a User
1. Go to **Setup → Manage Users**
2. Find user with **Inactive** status
3. Click **green checkmark button** (✓)
4. Confirm activation
5. User can now log in

### Deactivate a User
1. Go to **Setup → Manage Users**
2. Find user with **Active** status
3. Click **gray X button** (✗)
4. Confirm deactivation
5. User cannot log in until reactivated

### Edit User Status
1. Click **Edit** button (pencil icon)
2. Change **Status** dropdown:
   - Active - Can login
   - Inactive - Cannot login
   - Suspended - Account locked
3. Click **Update User**

---

## 🎨 Visual Indicators

### In User Table:

| Status | Badge Color | Icon | Button |
|--------|-------------|------|--------|
| Active | 🟢 Green | ✓ | Gray X (deactivate) |
| Inactive | ⚪ Gray | ✗ | Green ✓ (activate) |
| Suspended | 🔴 Red | 🚫 | Green ✓ (activate) |

### Quick Actions:
- **Green ✓ button**: Activate user (for Inactive/Suspended)
- **Gray ✗ button**: Deactivate user (for Active)
- **Yellow pencil**: Edit user details
- **Red trash**: Delete user permanently

---

## 🔄 Workflow Example

### New Interviewer Registration:

1. **Admin creates Interviewer account**
   ```
   Username: john_interviewer
   Email: john@company.com
   Role: Interviewer
   Status: Inactive (automatic)
   ```

2. **Interviewer tries to login**
   ```
   ❌ Error: "Account is not activated. Please contact administrator."
   ```

3. **Admin activates account**
   ```
   Setup → Manage Users → Click ✓ button
   Status changes: Inactive → Active
   ```

4. **Interviewer logs in successfully**
   ```
   ✅ Login successful
   Redirected to dashboard
   ```

---

## 🚨 Important Notes

### For Admins:
- ⚠️ **New users cannot login until activated**
- ⚠️ **You cannot change your own status** (security measure)
- ⚠️ **Suspended users need manual reactivation**
- ✅ **Existing users are automatically set to Active**

### For Users:
- 📧 **Contact admin if account not activated**
- 🔒 **Cannot self-activate accounts**
- ⏰ **Wait for admin approval**
- 📞 **Check with HR/Admin for activation**

---

## 🔍 Checking User Status

### As Admin:

**Method 1: User Table**
```
Setup → Manage Users
Look at "Status" column
```

**Method 2: Edit User**
```
Click Edit button
Check "Status" dropdown
```

### As User:
```
Try to login
If inactive: See error message
If active: Login successful
```

---

## 📝 Database Structure

### u_status Column:
```sql
Column: u_status
Type: VARCHAR(20) or ENUM('Active', 'Inactive', 'Suspended')
Default: 'Inactive' (for new users)
Values:
  - 'Active': Can login
  - 'Inactive': Cannot login
  - 'Suspended': Account locked
  - '1': Legacy active (converted to 'Active')
  - '0': Legacy inactive (converted to 'Inactive')
```

---

## 🔧 Installation

### Automatic (Recommended):
```
Run: http://localhost/rms/install_company_settings.php
```
This will:
- ✅ Add u_status column if missing
- ✅ Convert old numeric status (0/1) to new format
- ✅ Set existing users to 'Active'
- ✅ Configure new users as 'Inactive'

### Manual SQL:
```sql
-- Add column if doesn't exist
ALTER TABLE `users` 
ADD COLUMN `u_status` VARCHAR(20) DEFAULT 'Active' 
AFTER `u_role`;

-- Update existing users
UPDATE `users` SET `u_status` = 'Active' 
WHERE `u_status` IS NULL OR `u_status` = '' OR `u_status` = '1';

UPDATE `users` SET `u_status` = 'Inactive' 
WHERE `u_status` = '0';
```

---

## 🎯 Use Cases

### 1. New Employee Onboarding
```
1. HR creates account (Inactive)
2. IT verifies setup
3. Manager approves
4. Admin activates account
5. Employee can login
```

### 2. Temporary Suspension
```
1. Issue identified
2. Admin suspends account
3. Investigation completed
4. Admin reactivates account
```

### 3. Employee Departure
```
1. Employee leaves company
2. Admin deactivates account
3. Data retained but access blocked
4. Later: Admin deletes account if needed
```

---

## 🔐 Security Benefits

✅ **Prevents unauthorized access**
- New accounts can't be used immediately
- Admin must explicitly grant access

✅ **Audit trail**
- Track who activated accounts
- Monitor inactive accounts

✅ **Flexible control**
- Temporary suspension without deletion
- Easy reactivation when needed

✅ **Compliance**
- Meet security requirements
- Control user lifecycle

---

## 🆘 Troubleshooting

### Problem: "Account is not activated"
**Solution**: Contact admin to activate your account

### Problem: Can't activate user
**Solution**: 
1. Check you're logged in as Admin
2. Refresh the page
3. Try editing user and changing status manually

### Problem: Status column missing
**Solution**: Run the installer script

### Problem: All users inactive
**Solution**: 
```sql
UPDATE users SET u_status = 'Active' WHERE u_role = 'Admin';
```

---

## 📞 Support

For activation issues:
- **Users**: Contact your administrator
- **Admins**: Check this guide or system logs
- **Technical**: Review database u_status column

---

## ✅ Quick Reference

### Admin Tasks:
```
Activate User: Setup → Manage Users → Click ✓
Deactivate User: Setup → Manage Users → Click ✗
Edit Status: Setup → Manage Users → Edit → Change Status
View Status: Setup → Manage Users → Status column
```

### Status Meanings:
```
🟢 Active = Can login
⚪ Inactive = Cannot login (needs activation)
🔴 Suspended = Cannot login (locked)
```

### Login Behavior:
```
Active → ✅ Login successful
Inactive → ❌ "Account is not activated"
Suspended → ❌ "Account is not activated"
```

---

## 🎉 Summary

The User Activation System provides:
- ✅ Enhanced security
- ✅ Admin control over access
- ✅ Flexible user management
- ✅ Clear visual indicators
- ✅ Support for all 4 user roles

New users must be activated by admin before they can log in!
