# Module Manager Setup Instructions

## 🚀 Quick Setup

The Module Manager allows you to dynamically add custom modules to your sidebar navigation without touching code.

### Step 1: Create the Database Table

**Option A: Via Browser (Recommended)**
1. Open your browser
2. Navigate to: `http://localhost/rms/create_modules_table.php`
3. Wait for the success message
4. Click "Open Module Manager" button

**Option B: Via phpMyAdmin**
1. Open phpMyAdmin
2. Select your database (`rmsdb`)
3. Go to SQL tab
4. Run this query:

```sql
CREATE TABLE IF NOT EXISTS `custom_modules` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(100) NOT NULL,
    `section` varchar(50) NOT NULL,
    `icon` varchar(100) NOT NULL,
    `url` varchar(255) NOT NULL,
    `order_num` int(11) DEFAULT 10,
    `is_active` tinyint(1) DEFAULT 1,
    `show_badge` tinyint(1) DEFAULT 0,
    `badge_text` varchar(20) DEFAULT 'NEW',
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### Step 2: Access Module Manager

1. Login to your admin panel
2. Navigate to: **Setup → System Setup**
3. Click on **"Module Manager"** card
4. You'll see the module management interface

### Step 3: Add Your First Module

1. Fill in the form on the right side:
   - **Module Name**: e.g., "Training"
   - **Section**: Choose from dropdown or create custom
   - **Icon**: Font Awesome class (e.g., `fas fa-graduation-cap`)
   - **URL**: Controller path (e.g., `A_dashboard/training_view`)
   - **Display Order**: Number (lower = higher in sidebar)
   - **Active**: Toggle on/off
   - **Show Badge**: Optional "NEW" badge

2. Click **"Save Module"**

3. Refresh the page to see your new module in the sidebar!

## 📋 Features

- ✅ Add unlimited custom modules
- ✅ Organize by sections (Recruitment, Reports, Custom, etc.)
- ✅ Font Awesome icon support with live preview
- ✅ Drag-and-drop ordering (via order number)
- ✅ Enable/disable modules without deleting
- ✅ Optional "NEW" badges
- ✅ Edit and delete functionality
- ✅ No code changes required

## 🎨 Icon Resources

Browse Font Awesome icons: https://fontawesome.com/icons

Popular icons:
- `fas fa-graduation-cap` - Training/Education
- `fas fa-file-alt` - Documents
- `fas fa-money-bill` - Payroll
- `fas fa-clock` - Attendance
- `fas fa-star` - Performance
- `fas fa-laptop` - Assets
- `fas fa-book` - Knowledge Base

## 🔧 Troubleshooting

**Problem**: Table doesn't exist error
**Solution**: Run `create_modules_table.php` first

**Problem**: Module doesn't appear in sidebar
**Solution**: 
1. Check if module is set to "Active"
2. Refresh the page (Ctrl+F5)
3. Clear browser cache

**Problem**: Icon not showing
**Solution**: 
1. Verify Font Awesome class is correct
2. Check icon preview in Module Manager
3. Use format: `fas fa-icon-name` or `far fa-icon-name`

## 📝 Example Modules

Here are some example modules you can add:

### Training Module
- Name: Training
- Section: CUSTOM
- Icon: fas fa-graduation-cap
- URL: A_dashboard/training_view
- Order: 5

### Documents Module
- Name: Documents
- Section: CUSTOM
- Icon: fas fa-file-alt
- URL: A_dashboard/documents_view
- Order: 6

### Payroll Module
- Name: Payroll
- Section: CUSTOM
- Icon: fas fa-money-bill-wave
- URL: A_dashboard/payroll_view
- Order: 7

## 🎯 Best Practices

1. **Create the controller first** before adding the module
2. **Use descriptive names** for easy identification
3. **Group related modules** in the same section
4. **Use consistent ordering** (e.g., 10, 20, 30 for easy reordering)
5. **Test the URL** before saving the module
6. **Use appropriate icons** that match the module purpose

## 🔐 Security Note

Only administrators should have access to the Module Manager. The system modules (Dashboard, Candidates, etc.) cannot be deleted to maintain system integrity.

## 📞 Support

If you encounter any issues:
1. Check the troubleshooting section above
2. Verify database connection
3. Check PHP error logs
4. Contact system administrator

---

**Version**: 1.0  
**Last Updated**: November 2024
