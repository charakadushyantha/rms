# 🚀 Audit Log - Quick Reference Card

## Setup (One Time)
```bash
# 1. Run this URL in browser
http://localhost/rms/create_audit_logs_table.php

# 2. Access audit logs
http://localhost/rms/Setup/audit_logs
```

## Load Library (In Constructor)
```php
public function __construct()
{
    parent::__construct();
    $this->load->library('audit_logger');
}
```

## Quick Methods

### 📝 Create
```php
$this->audit_logger->log_create('Candidate', $id, $name, $data);
```

### ✏️ Update
```php
$this->audit_logger->log_update('Candidate', $id, $name, $old_data, $new_data);
```

### 🗑️ Delete
```php
$this->audit_logger->log_delete('Candidate', $id, $name, $old_data);
```

### 🔐 Login
```php
// Success
$this->audit_logger->log_login($username, true);

// Failed
$this->audit_logger->log_login($username, false, 'Invalid password');
```

### 🚪 Logout
```php
$this->audit_logger->log_logout();
```

### 📊 Export
```php
$this->audit_logger->log_export('Candidate', 'Exported 100 candidates');
```

### 👁️ View
```php
$this->audit_logger->log_view('Candidate', $id, $name);
```

### 📥 Download
```php
$this->audit_logger->log_download('Document', $id, $filename);
```

## Common Action Types
- `CREATE` - Creating new records
- `UPDATE` - Updating existing records
- `DELETE` - Deleting records
- `LOGIN` - User login
- `LOGOUT` - User logout
- `EXPORT` - Exporting data
- `VIEW` - Viewing records
- `DOWNLOAD` - Downloading files
- `IMPORT` - Importing data
- `APPROVE` - Approving something
- `REJECT` - Rejecting something

## Common Resource Types
- `Candidate`
- `User`
- `Job`
- `Interview`
- `Document`
- `Report`
- `Settings`
- `System`

## Full Example - Add Candidate
```php
public function add_candidate()
{
    $data = [
        'cd_name' => $this->input->post('name'),
        'cd_email' => $this->input->post('email'),
        'cd_phone' => $this->input->post('phone')
    ];
    
    if ($this->db->insert('candidate_details', $data)) {
        $id = $this->db->insert_id();
        
        // Log it!
        $this->audit_logger->log_create(
            'Candidate',
            $id,
            $data['cd_name'],
            $data
        );
        
        $this->session->set_flashdata('success_msg', 'Added!');
    }
    
    redirect('candidates');
}
```

## Full Example - Update Candidate
```php
public function update_candidate($id)
{
    // Get old data
    $old = $this->db->where('cd_id', $id)
                    ->get('candidate_details')
                    ->row_array();
    
    // Update
    $data = ['cd_status' => 'Interview Scheduled'];
    $this->db->where('cd_id', $id)->update('candidate_details', $data);
    
    // Get new data
    $new = $this->db->where('cd_id', $id)
                    ->get('candidate_details')
                    ->row_array();
    
    // Log it!
    $this->audit_logger->log_update(
        'Candidate',
        $id,
        $old['cd_name'],
        $old,
        $new
    );
    
    redirect('candidates');
}
```

## Full Example - Delete Candidate
```php
public function delete_candidate($id)
{
    // Get data before delete
    $candidate = $this->db->where('cd_id', $id)
                          ->get('candidate_details')
                          ->row();
    
    // Delete
    $this->db->where('cd_id', $id)->delete('candidate_details');
    
    // Log it!
    $this->audit_logger->log_delete(
        'Candidate',
        $id,
        $candidate->cd_name,
        (array)$candidate
    );
    
    redirect('candidates');
}
```

## Custom Log Entry
```php
$this->audit_logger->log(
    'APPROVE',              // action
    'Job Application',      // resource type
    $application_id,        // resource id
    'John Doe Application', // resource name
    'Approved application for Software Engineer position',
    null,                   // old values
    ['status' => 'approved'], // new values
    'success',              // status
    null                    // error message
);
```

## Tips
✅ Always load the library in constructor  
✅ Log before AND after important operations  
✅ Use consistent resource type names  
✅ Include meaningful descriptions  
✅ Store old/new values for updates  
✅ Log both successes and failures  

## That's It!
Copy-paste these examples and modify for your needs. Happy logging! 🎉
