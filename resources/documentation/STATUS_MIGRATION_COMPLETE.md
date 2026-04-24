# User Status Migration - Complete Guide

## 🎯 Overview

The system has been updated from **numeric status (0/1)** to **string status (Pending/Active/Suspended)** for better clarity and user experience.

---

## 📊 Status Value Changes

### Old System (Numeric):
```
0 = Inactive/Pending (cannot login)
1 = Active (can login)
```

### New System (String):
```
'Pending' = Awaiting activation (cannot login) 🟡
'Active' = Activated (can login) 🟢
'Suspended' = Account locked (cannot login) 🔴
```

---

## ✅ Files Updated

### 1. **Login Controller** (`application/controllers/Login.php`)
- ✅ `activate_rec()` - Now sets status to `'Active'` instead of `1`

### 2. **Signup Model** (`application/models/Signup_model.php`)
- ✅ `Create_rec()` - New signups get `'Pending'` status and `'Recruiter'` role
- ✅ `add_rec()` - Direct additions get `'Active'` status

### 3. **Login Model** (`application/models/Login_model.php`)
- ✅ `check_rec_status()` - Checks for `'Active'` or `'1'` (backward compatible)
- ✅ `check_admin_status()` - Checks for `'Active'` or `'1'`
- ✅ `check_interviewer_status()` - Checks for `'Active'` or `'1'`
- ✅ `check_candidate_status()` - Checks for `'Active'` or `'1'`

### 4. **Setup Controller** (`application/controllers/Setup.php`)
- ✅ `add_user()` - New users get `'Pending'` status
- ✅ `update_user()` - Can change status via dropdown
- ✅ `toggle_user_status()` - Toggles between `'Active'` and `'Pending'`

### 5. **Manage Users View** (`application/views/Admin_dashboard_view/Setup/manage_users.php`)
- ✅ Shows color-coded status badges
- ✅ Filter tabs (All/Pending/Active)
- ✅ Clear "Activate" buttons for pending users

---

## 🔄 Migration Process

### Step 1: Run the Fix Script

**Option A: PHP Script (Recommended)**
```
http://localhost/rms/fix_user_status.php
```

**Option B: SQL Script**
```sql
-- Change column type
ALTER TABLE `users` MODIFY COLUMN `u_status` VARCHAR(20) DEFAULT 'Active';

-- Convert values
UPDATE `users` SET `u_status` = 'Active' WHERE `u_status` = '1';
UPDATE `users` SET `u_status` = 'Pending' WHERE `u_status` = '0';
UPDATE `users` SET `u_status` = 'Pending' WHERE `u_status` IS NULL OR `u_status` = '';
```

### Step 2: Verify Changes
1. Go to **Setup → Manage Users**
2. Check status badges:
   - 🟢 Green = Active
   - 🟡 Yellow = Pending Activation
3. Click **"Pending Activation"** tab to see users needing activation

### Step 3: Clean Up
Delete these files after migration:
- `fix_user_status.php`
- `fix_user_status.sql`

---

## 🔍 Backward Compatibility

The system is **backward compatible** with old numeric values:

### Login Checks:
```php
// Accepts both old and new formats
$this->db->where('u_status', '1');  // Old format
$this->db->or_where('u_status', 'Active');  // New format
```

This means:
- ✅ Old users with status `1` can still login
- ✅ New users with status `'Active'` can login
- ✅ Users with status `0` or `'Pending'` cannot login

---

## 📝 Signup Flow

### New Recruiter Signup:

1. **User fills signup form**
   - Username, email, password

2. **System creates account**
   ```php
   u_username: 'newuser'
   u_email: 'user@example.com'
   u_password: md5('password')
   u_role: 'Recruiter'
   u_status: 'Pending'  // ← New users start as Pending
   ```

3. **Email sent to admin**
   - Admin receives activation request

4. **User tries to login**
   - ❌ Error: "Account is not activated. Please contact administrator."

5. **Admin activates account**
   - Admin clicks activation link or uses Manage Users
   - Status changes: `'Pending'` → `'Active'`

6. **User can now login**
   - ✅ Login successful

---

## 🎨 Visual Indicators

### Status Badges:

| Status | Color | Icon | Meaning |
|--------|-------|------|---------|
| Active | 🟢 Green | ✓ | Can login |
| Pending Activation | 🟡 Yellow | ⏰ | Needs activation |
| Suspended | 🔴 Red | 🚫 | Account locked |

### Action Buttons:

| Status | Button | Action |
|--------|--------|--------|
| Pending | 🟢 **Activate** (with text) | Changes to Active |
| Active | ⚪ 🚫 (small icon) | Changes to Pending |
| Suspended | 🟢 **Activate** (with text) | Changes to Active |

---

## 🧪 Testing Checklist

### Test Existing Users:
- [ ] Users with `u_status = 1` show as "Active" (green)
- [ ] Users with `u_status = 0` show as "Pending Activation" (yellow)
- [ ] Active users can login
- [ ] Pending users cannot login

### Test New Signups:
- [ ] New signup creates user with status "Pending"
- [ ] New user cannot login before activation
- [ ] Admin receives activation email
- [ ] Admin can activate via email link
- [ ] Admin can activate via Manage Users page
- [ ] After activation, user can login

### Test Admin Functions:
- [ ] Filter tabs work (All/Pending/Active)
- [ ] Activate button changes status to Active
- [ ] Deactivate button changes status to Pending
- [ ] Edit user can change status manually
- [ ] Status changes are saved to database

---

## 🚨 Important Notes

### For Admins:
1. **Run the migration script** to convert existing data
2. **Test login** with both old and new users
3. **Delete migration files** after successful conversion
4. **Activate pending users** as needed

### For Developers:
1. **Always use string status** in new code
2. **Maintain backward compatibility** in login checks
3. **Set new users to 'Pending'** by default
4. **Use 'Active' for activated users**

---

## 🔧 Troubleshooting

### Problem: All users show as Active
**Solution:** Run the migration script to convert database values

### Problem: New signups can login immediately
**Solution:** Check Signup_model - should set status to 'Pending'

### Problem: Activation link doesn't work
**Solution:** Check Login controller activate_rec() method - should set 'Active'

### Problem: Old users can't login
**Solution:** Login_model should check for both '1' and 'Active'

---

## 📞 Support

If you encounter issues:
1. Check database `u_status` column values
2. Verify Login_model checks both old and new formats
3. Run migration script again if needed
4. Check error logs for details

---

## ✅ Migration Checklist

- [ ] Run migration script (fix_user_status.php)
- [ ] Verify all users have string status values
- [ ] Test existing user login
- [ ] Test new signup flow
- [ ] Test admin activation
- [ ] Test filter tabs in Manage Users
- [ ] Delete migration files
- [ ] Update documentation

---

## 🎉 Benefits of New System

✅ **Clearer Status** - "Pending Activation" vs "0"
✅ **Better UX** - Color-coded badges
✅ **Easy Filtering** - One-click to see pending users
✅ **More Options** - Can add more statuses (Suspended, etc.)
✅ **Self-Documenting** - Code is easier to understand
✅ **Backward Compatible** - Works with old data

---

## 📚 Related Files

- `fix_user_status.php` - Migration script
- `fix_user_status.sql` - SQL migration
- `USER_ACTIVATION_GUIDE.md` - User activation documentation
- `USER_ROLES_GUIDE.md` - User roles documentation

---

**Migration completed successfully! 🎉**
