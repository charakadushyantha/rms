# 🔍 Audit Log System - Complete Setup Guide

## Overview
A comprehensive audit logging system that tracks all user activities, system changes, and security events in your recruitment management system.

## Features
✅ **Complete Activity Tracking** - Logs all CREATE, UPDATE, DELETE, LOGIN, LOGOUT, EXPORT actions  
✅ **Advanced Filtering** - Filter by date range, action type, resource type, and user  
✅ **Search Functionality** - Full-text search across descriptions and resource names  
✅ **Detailed View** - View complete details of each log entry including old/new values  
✅ **Export to CSV** - Export filtered logs for external analysis  
✅ **Statistics Dashboard** - View activity statistics (today, this week, this month)  
✅ **Pagination** - Efficient pagination for large datasets  
✅ **Auto-cleanup** - Remove old logs to maintain database performance  
✅ **IP Tracking** - Track user IP addresses and user agents  
✅ **Status Tracking** - Track success/failure of operations  

---

## 📋 Installation Steps

### Step 1: Create Database Table
Run the setup script to create the audit_logs table:

```bash
http://localhost/rms/create_audit_logs_table.php
```

This will:
- Create the `audit_logs` table with all necessary columns
- Insert sample data for testing
- Set up proper indexes for performance

### Step 2: Verify Controller Methods
The following methods have been added to `application/controllers/Setup.php`:

- `audit_logs()` - Main view with filtering and pagination
- `view_audit_log($id)` - Get details of a single log entry
- `export_audit_logs()` - Export logs to CSV
- `clear_old_logs()` - Delete logs older than specified days
- `log_activity()` - Helper method to log activities

### Step 3: Access the Audit Logs
Navigate to:
```
http://localhost/rms/Setup/audit_logs
```

---

## 🎯 Usage Examples

### Using the Audit Logger Library

#### 1. Load the Library
```php
$this->load->library('audit_logger');
```

#### 2. Log a Create Action
```php
// When creating a new candidate
$candidate_id = $this->db->insert_id();
$this->audit_logger->log_create(
    'Candidate',
    $candidate_id,
    $candidate_name,
    ['name' => $candidate_name, 'email' => $email, 'phone' => $phone]
);
```

#### 3. Log an Update Action
```php
// When updating a candidate
$old_data = $this->db->where('id', $id)->get('candidates')->row_array();
// ... perform update ...
$new_data = $this->db->where('id', $id)->get('candidates')->row_array();

$this->audit_logger->log_update(
    'Candidate',
    $id,
    $candidate_name,
    $old_data,
    $new_data
);
```

#### 4. Log a Delete Action
```php
// Before deleting
$candidate = $this->db->where('id', $id)->get('candidates')->row();
$this->audit_logger->log_delete(
    'Candidate',
    $id,
    $candidate->name,
    (array)$candidate
);
// ... perform delete ...
```

#### 5. Log Login/Logout
```php
// On successful login
$this->audit_logger->log_login($username, true);

// On failed login
$this->audit_logger->log_login($username, false, 'Invalid password');

// On logout
$this->audit_logger->log_logout();
```

#### 6. Log Export Actions
```php
// When exporting data
$this->audit_logger->log_export('Candidate', 'Exported 150 candidates to CSV');
```

#### 7. Custom Log Entry
```php
// For any custom action
$this->audit_logger->log(
    'CUSTOM_ACTION',
    'ResourceType',
    $resource_id,
    $resource_name,
    'Description of what happened',
    $old_values,  // optional
    $new_values,  // optional
    'success',    // or 'failed'
    null          // error message if failed
);
```

---

## 🔧 Integration Examples

### Example 1: Add to Candidate Controller

```php
// In application/controllers/A_dashboard.php

public function __construct()
{
    parent::__construct();
    $this->load->library('audit_logger');
}

public function add_candidate()
{
    // ... your existing code ...
    
    if ($this->db->insert('candidate_details', $data)) {
        $candidate_id = $this->db->insert_id();
        
        // Log the activity
        $this->audit_logger->log_create(
            'Candidate',
            $candidate_id,
            $data['cd_name'],
            $data
        );
        
        $this->session->set_flashdata('success_msg', 'Candidate added successfully!');
    }
    
    redirect('A_dashboard/candidates');
}

public function update_candidate()
{
    $id = $this->input->post('candidate_id');
    
    // Get old data before update
    $old_data = $this->db->where('cd_id', $id)->get('candidate_details')->row_array();
    
    // ... perform update ...
    $this->db->where('cd_id', $id);
    $this->db->update('candidate_details', $data);
    
    // Get new data after update
    $new_data = $this->db->where('cd_id', $id)->get('candidate_details')->row_array();
    
    // Log the activity
    $this->audit_logger->log_update(
        'Candidate',
        $id,
        $data['cd_name'],
        $old_data,
        $new_data
    );
    
    redirect('A_dashboard/candidates');
}

public function delete_candidate($id)
{
    // Get candidate data before deletion
    $candidate = $this->db->where('cd_id', $id)->get('candidate_details')->row();
    
    // Delete
    $this->db->where('cd_id', $id);
    $this->db->delete('candidate_details');
    
    // Log the activity
    $this->audit_logger->log_delete(
        'Candidate',
        $id,
        $candidate->cd_name,
        (array)$candidate
    );
    
    redirect('A_dashboard/candidates');
}
```

### Example 2: Add to Login Controller

```php
// In application/controllers/Login.php

public function __construct()
{
    parent::__construct();
    $this->load->library('audit_logger');
}

public function authenticate()
{
    $username = $this->input->post('username');
    $password = $this->input->post('password');
    
    $user = $this->db->where('u_username', $username)
                     ->where('u_password', md5($password))
                     ->get(TBL_USERS)
                     ->row();
    
    if ($user) {
        // Set session data
        $this->session->set_userdata([
            'authenticated' => true,
            'username' => $user->u_username,
            'email' => $user->u_email,
            'role' => $user->u_role,
            'u_id' => $user->u_id
        ]);
        
        // Log successful login
        $this->audit_logger->log_login($username, true);
        
        redirect('A_dashboard');
    } else {
        // Log failed login
        $this->audit_logger->log_login($username, false, 'Invalid credentials');
        
        $this->session->set_flashdata('error_msg', 'Invalid username or password');
        redirect('Login');
    }
}

public function logout()
{
    // Log logout before destroying session
    $this->audit_logger->log_logout();
    
    $this->session->sess_destroy();
    redirect('Login');
}
```

---

## 📊 Database Schema

```sql
CREATE TABLE `audit_logs` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) NULL,
    `username` VARCHAR(255) NULL,
    `user_email` VARCHAR(255) NULL,
    `user_role` VARCHAR(50) NULL,
    `action` VARCHAR(50) NOT NULL,
    `resource_type` VARCHAR(100) NOT NULL,
    `resource_id` INT(11) NULL,
    `resource_name` VARCHAR(255) NULL,
    `description` TEXT NULL,
    `old_values` TEXT NULL,
    `new_values` TEXT NULL,
    `ip_address` VARCHAR(45) NULL,
    `user_agent` TEXT NULL,
    `request_method` VARCHAR(10) NULL,
    `request_url` TEXT NULL,
    `status` ENUM('success', 'failed') DEFAULT 'success',
    `error_message` TEXT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`),
    KEY `username` (`username`),
    KEY `action` (`action`),
    KEY `resource_type` (`resource_type`),
    KEY `created_at` (`created_at`),
    KEY `ip_address` (`ip_address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

---

## 🎨 Features in Detail

### 1. Statistics Dashboard
- **Total Logs**: All-time log count
- **Today**: Logs created today
- **This Week**: Logs from the last 7 days
- **This Month**: Logs from current month

### 2. Advanced Filtering
- **Date Range**: Filter by from/to dates
- **Action Type**: Filter by specific actions (CREATE, UPDATE, DELETE, etc.)
- **Resource Type**: Filter by resource (Candidate, User, Job, etc.)
- **User**: Search by username or email
- **Full-Text Search**: Search in descriptions and resource names

### 3. Export Functionality
- Export filtered results to CSV
- Includes all relevant columns
- Timestamped filename

### 4. Log Details Modal
- View complete log entry details
- See old and new values (for updates)
- View user agent and request information
- See success/failure status

### 5. Cleanup Feature
- Delete logs older than specified days (30, 60, 90, 180, 365)
- Helps maintain database performance
- Confirmation dialog before deletion

---

## 🔒 Security Considerations

1. **Access Control**: Only admins should access audit logs
2. **Data Retention**: Implement a policy for how long to keep logs
3. **Sensitive Data**: Be careful not to log passwords or sensitive information
4. **Performance**: Regularly clean up old logs to maintain performance
5. **Backup**: Regularly backup audit logs before cleanup

---

## 📈 Performance Tips

1. **Indexes**: The table has indexes on frequently queried columns
2. **Pagination**: Use pagination to avoid loading too many records
3. **Regular Cleanup**: Delete old logs periodically
4. **Selective Logging**: Don't log every single action, focus on important ones
5. **Async Logging**: Consider using queue systems for high-traffic applications

---

## 🎯 Best Practices

1. **Consistent Naming**: Use consistent resource type names (e.g., always "Candidate", not "candidate" or "Candidates")
2. **Meaningful Descriptions**: Write clear, human-readable descriptions
3. **Include Context**: Store old and new values for updates
4. **Log Failures**: Don't just log successes, log failures too
5. **Regular Review**: Periodically review logs for security and compliance

---

## 🚀 Quick Start Checklist

- [ ] Run `create_audit_logs_table.php` to create the database table
- [ ] Verify the table was created successfully
- [ ] Access the audit logs page at `/Setup/audit_logs`
- [ ] Test filtering and search functionality
- [ ] Add `$this->load->library('audit_logger');` to your controllers
- [ ] Start logging activities using the provided methods
- [ ] Test the export functionality
- [ ] Set up a cleanup schedule for old logs

---

## 📞 Support

For issues or questions:
1. Check the sample data in the audit logs page
2. Review the usage examples above
3. Verify the audit_logger library is loaded
4. Check that the audit_logs table exists

---

## 🎉 You're All Set!

Your audit log system is now ready to track all activities in your recruitment management system. Start integrating it into your controllers to maintain a complete audit trail.
