<?php
/**
 * Company Settings Module Installer
 * Run this file once to create the required database tables
 * Access: http://localhost/rms/install_company_settings.php
 */

// Load CodeIgniter bootstrap
require_once 'index.php';

// Get CI instance
$CI =& get_instance();

echo "<!DOCTYPE html>
<html>
<head>
    <title>Company Settings Installer</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        .success { color: green; padding: 10px; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 5px; margin: 10px 0; }
        .error { color: red; padding: 10px; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px; margin: 10px 0; }
        .info { color: blue; padding: 10px; background: #d1ecf1; border: 1px solid #bee5eb; border-radius: 5px; margin: 10px 0; }
        h1 { color: #333; }
        .btn { display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 5px; margin-top: 20px; }
    </style>
</head>
<body>
    <h1>Company Settings Module Installer</h1>
";

try {
    // Create company_settings table
    echo "<div class='info'>Creating company_settings table...</div>";
    $sql1 = "CREATE TABLE IF NOT EXISTS `company_settings` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `company_name` varchar(255) NOT NULL,
      `company_email` varchar(255) NOT NULL,
      `company_phone` varchar(50) DEFAULT NULL,
      `company_logo` varchar(255) DEFAULT NULL,
      `company_address` text DEFAULT NULL,
      `company_city` varchar(100) DEFAULT NULL,
      `company_state` varchar(100) DEFAULT NULL,
      `company_country` varchar(100) DEFAULT NULL,
      `company_postal_code` varchar(20) DEFAULT NULL,
      `registration_number` varchar(100) DEFAULT NULL,
      `tax_id` varchar(100) DEFAULT NULL,
      `website` varchar(255) DEFAULT NULL,
      `business_hours_start` time DEFAULT '09:00:00',
      `business_hours_end` time DEFAULT '17:00:00',
      `financial_year_start` date DEFAULT NULL,
      `financial_year_end` date DEFAULT NULL,
      `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
      `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    $CI->db->query($sql1);
    echo "<div class='success'>✓ company_settings table created successfully!</div>";
    
    // Add u_status column to users table if it doesn't exist
    echo "<div class='info'>Checking users table for u_status column...</div>";
    $columns = $CI->db->list_fields(TBL_USERS);
    if (!in_array('u_status', $columns)) {
        $sql_status = "ALTER TABLE `" . TBL_USERS . "` ADD COLUMN `u_status` VARCHAR(20) DEFAULT 'Active' AFTER `u_role`";
        $CI->db->query($sql_status);
        echo "<div class='success'>✓ u_status column added to users table!</div>";
    } else {
        echo "<div class='info'>u_status column already exists.</div>";
    }
    
    // Update existing users to Active status
    echo "<div class='info'>Updating existing users to Active status...</div>";
    $CI->db->where('u_status IS NULL', NULL, FALSE);
    $CI->db->or_where('u_status', '');
    $CI->db->or_where('u_status', '0');
    $CI->db->update(TBL_USERS, ['u_status' => 'Active']);
    
    $CI->db->where('u_status', '1');
    $CI->db->update(TBL_USERS, ['u_status' => 'Active']);
    echo "<div class='success'>✓ Existing users updated to Active status!</div>";
    
    // Create departments table
    echo "<div class='info'>Creating departments table...</div>";
    $sql2 = "CREATE TABLE IF NOT EXISTS `departments` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `department_name` varchar(255) NOT NULL,
      `department_head` varchar(255) DEFAULT NULL,
      `description` text DEFAULT NULL,
      `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
      `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    $CI->db->query($sql2);
    echo "<div class='success'>✓ departments table created successfully!</div>";
    
    // Create job_categories table
    echo "<div class='info'>Creating job_categories table...</div>";
    $sql3 = "CREATE TABLE IF NOT EXISTS `job_categories` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `category_name` varchar(255) NOT NULL,
      `description` text DEFAULT NULL,
      `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
      `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    $CI->db->query($sql3);
    echo "<div class='success'>✓ job_categories table created successfully!</div>";
    
    // Create job_positions table
    echo "<div class='info'>Creating job_positions table...</div>";
    $sql4 = "CREATE TABLE IF NOT EXISTS `job_positions` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `position_name` varchar(255) NOT NULL,
      `category_id` int(11) DEFAULT NULL,
      `description` text DEFAULT NULL,
      `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
      `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      KEY `category_id` (`category_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    $CI->db->query($sql4);
    echo "<div class='success'>✓ job_positions table created successfully!</div>";
    
    // Create branches table
    echo "<div class='info'>Creating branches table...</div>";
    $sql5 = "CREATE TABLE IF NOT EXISTS `branches` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `branch_name` varchar(255) NOT NULL,
      `branch_code` varchar(50) NOT NULL,
      `address` text DEFAULT NULL,
      `city` varchar(100) DEFAULT NULL,
      `state` varchar(100) DEFAULT NULL,
      `country` varchar(100) DEFAULT NULL,
      `postal_code` varchar(20) DEFAULT NULL,
      `phone` varchar(50) DEFAULT NULL,
      `email` varchar(255) DEFAULT NULL,
      `manager` varchar(255) DEFAULT NULL,
      `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
      `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      UNIQUE KEY `branch_code` (`branch_code`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    $CI->db->query($sql5);
    echo "<div class='success'>✓ branches table created successfully!</div>";
    
    // Insert sample data
    echo "<div class='info'>Inserting sample data...</div>";
    
    // Check if company_settings already has data
    $existing = $CI->db->get('company_settings')->num_rows();
    if ($existing == 0) {
        $CI->db->insert('company_settings', [
            'company_name' => 'Your Company Name',
            'company_email' => 'info@company.com',
            'company_phone' => '+1-234-567-8900',
            'website' => 'https://www.company.com',
            'business_hours_start' => '09:00:00',
            'business_hours_end' => '17:00:00'
        ]);
        echo "<div class='success'>✓ Sample company settings inserted!</div>";
    } else {
        echo "<div class='info'>Company settings already exist, skipping...</div>";
    }
    
    // Insert sample departments
    $dept_exists = $CI->db->get('departments')->num_rows();
    if ($dept_exists == 0) {
        $departments = [
            ['department_name' => 'Human Resources', 'department_head' => 'HR Manager', 'description' => 'Manages recruitment, employee relations, and HR policies'],
            ['department_name' => 'Information Technology', 'department_head' => 'IT Manager', 'description' => 'Manages technology infrastructure and software development'],
            ['department_name' => 'Finance', 'department_head' => 'Finance Manager', 'description' => 'Handles financial planning, accounting, and budgeting'],
            ['department_name' => 'Marketing', 'department_head' => 'Marketing Manager', 'description' => 'Manages marketing campaigns and brand strategy']
        ];
        
        foreach ($departments as $dept) {
            $CI->db->insert('departments', $dept);
        }
        echo "<div class='success'>✓ Sample departments inserted!</div>";
    } else {
        echo "<div class='info'>Departments already exist, skipping...</div>";
    }
    
    // Insert sample job categories
    $cat_exists = $CI->db->get('job_categories')->num_rows();
    if ($cat_exists == 0) {
        $categories = [
            ['category_name' => 'Information Technology', 'description' => 'Software development, IT support, and technology roles'],
            ['category_name' => 'Engineering', 'description' => 'Mechanical, electrical, civil, and other engineering positions'],
            ['category_name' => 'Sales & Marketing', 'description' => 'Sales representatives, marketing specialists, and business development'],
            ['category_name' => 'Human Resources', 'description' => 'HR managers, recruiters, and talent acquisition specialists'],
            ['category_name' => 'Finance & Accounting', 'description' => 'Accountants, financial analysts, and finance managers']
        ];
        
        foreach ($categories as $cat) {
            $CI->db->insert('job_categories', $cat);
        }
        echo "<div class='success'>✓ Sample job categories inserted!</div>";
    } else {
        echo "<div class='info'>Job categories already exist, skipping...</div>";
    }
    
    // Insert sample job positions
    $pos_exists = $CI->db->get('job_positions')->num_rows();
    if ($pos_exists == 0) {
        $positions = [
            ['position_name' => 'Software Engineer', 'category_id' => 1, 'description' => 'Develop and maintain software applications'],
            ['position_name' => 'Frontend Developer', 'category_id' => 1, 'description' => 'Build user interfaces and client-side applications'],
            ['position_name' => 'Backend Developer', 'category_id' => 1, 'description' => 'Develop server-side logic and databases'],
            ['position_name' => 'Sales Executive', 'category_id' => 3, 'description' => 'Drive sales and business development'],
            ['position_name' => 'HR Manager', 'category_id' => 4, 'description' => 'Manage human resources and recruitment']
        ];
        
        foreach ($positions as $pos) {
            $CI->db->insert('job_positions', $pos);
        }
        echo "<div class='success'>✓ Sample job positions inserted!</div>";
    } else {
        echo "<div class='info'>Job positions already exist, skipping...</div>";
    }
    
    // Insert sample branches
    $branch_exists = $CI->db->get('branches')->num_rows();
    if ($branch_exists == 0) {
        $branches = [
            ['branch_name' => 'Head Office', 'branch_code' => 'HQ001', 'city' => 'New York', 'state' => 'NY', 'country' => 'USA', 'phone' => '+1-234-567-8900', 'email' => 'hq@company.com', 'manager' => 'John Doe'],
            ['branch_name' => 'Branch Office', 'branch_code' => 'BR001', 'city' => 'Los Angeles', 'state' => 'CA', 'country' => 'USA', 'phone' => '+1-234-567-8901', 'email' => 'la@company.com', 'manager' => 'Jane Smith']
        ];
        
        foreach ($branches as $branch) {
            $CI->db->insert('branches', $branch);
        }
        echo "<div class='success'>✓ Sample branches inserted!</div>";
    } else {
        echo "<div class='info'>Branches already exist, skipping...</div>";
    }
    
    // Create uploads directory
    echo "<div class='info'>Creating uploads directory...</div>";
    $upload_dir = './uploads/company';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
        echo "<div class='success'>✓ Uploads directory created at: $upload_dir</div>";
    } else {
        echo "<div class='info'>Uploads directory already exists.</div>";
    }
    
    echo "<div class='success' style='font-size: 18px; font-weight: bold; margin-top: 30px;'>
        🎉 Installation completed successfully!
    </div>";
    
    echo "<p>You can now access the Company Settings module:</p>";
    echo "<a href='" . base_url('Setup/company_settings') . "' class='btn'>Go to Company Settings</a>";
    
    echo "<p style='margin-top: 20px; color: #666;'>
        <strong>Note:</strong> For security reasons, please delete this installer file (install_company_settings.php) after installation.
    </p>";
    
} catch (Exception $e) {
    echo "<div class='error'>Error: " . $e->getMessage() . "</div>";
    echo "<p>Please check your database connection and try again.</p>";
}

echo "</body></html>";
?>
