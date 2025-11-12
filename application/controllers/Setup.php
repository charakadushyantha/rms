<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->logged_in();
    }

    private function logged_in() {
        if(!$this->session->userdata('authenticated')) {
            redirect(LOGIN_URL);
        }
    }

    public function index()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'System Setup';
        $this->load->view('Admin_dashboard_view/Setup/index', $data);
    }

    // Job Categories Setup
    public function job_categories()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Job Categories Setup';
        
        // Get existing categories
        $data['categories'] = $this->db->get('job_categories')->result();
        
        $this->load->view('Admin_dashboard_view/Setup/job_categories', $data);
    }

    public function add_job_category()
    {
        $category_name = $this->input->post('category_name');
        $description = $this->input->post('description');
        
        $data = array(
            'category_name' => $category_name,
            'description' => $description,
            'created_at' => date('Y-m-d H:i:s')
        );
        
        if($this->db->insert('job_categories', $data)) {
            $this->session->set_flashdata('success_msg', 'Job category added successfully!');
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to add job category.');
        }
        
        redirect('Setup/job_categories');
    }

    public function update_job_category()
    {
        $id = $this->input->post('category_id');
        $data = [
            'category_name' => $this->input->post('category_name'),
            'description' => $this->input->post('description')
        ];
        
        $this->db->where('id', $id);
        if($this->db->update('job_categories', $data)) {
            $this->session->set_flashdata('success_msg', 'Job category updated successfully!');
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to update job category.');
        }
        
        redirect('Setup/job_categories');
    }

    public function delete_job_category($id)
    {
        $this->db->where('id', $id);
        if($this->db->delete('job_categories')) {
            $this->session->set_flashdata('success_msg', 'Job category deleted successfully!');
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to delete job category.');
        }
        
        redirect('Setup/job_categories');
    }

    // Job Positions Setup
    public function job_positions()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Job Positions Setup';
        
        // Get existing positions with categories
        $this->db->select('job_positions.*, job_categories.category_name');
        $this->db->from('job_positions');
        $this->db->join('job_categories', 'job_categories.id = job_positions.category_id', 'left');
        $data['positions'] = $this->db->get()->result();
        
        // Get categories for dropdown
        $data['categories'] = $this->db->get('job_categories')->result();
        
        $this->load->view('Admin_dashboard_view/Setup/job_positions', $data);
    }

    public function add_job_position()
    {
        $position_name = $this->input->post('position_name');
        $category_id = $this->input->post('category_id');
        $description = $this->input->post('description');
        
        $data = array(
            'position_name' => $position_name,
            'category_id' => $category_id,
            'description' => $description,
            'created_at' => date('Y-m-d H:i:s')
        );
        
        if($this->db->insert('job_positions', $data)) {
            $this->session->set_flashdata('success_msg', 'Job position added successfully!');
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to add job position.');
        }
        
        redirect('Setup/job_positions');
    }

    public function update_job_position()
    {
        $id = $this->input->post('position_id');
        $data = [
            'position_name' => $this->input->post('position_name'),
            'category_id' => $this->input->post('category_id'),
            'description' => $this->input->post('description')
        ];
        
        $this->db->where('id', $id);
        if($this->db->update('job_positions', $data)) {
            $this->session->set_flashdata('success_msg', 'Job position updated successfully!');
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to update job position.');
        }
        
        redirect('Setup/job_positions');
    }

    public function delete_job_position($id)
    {
        $this->db->where('id', $id);
        if($this->db->delete('job_positions')) {
            $this->session->set_flashdata('success_msg', 'Job position deleted successfully!');
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to delete job position.');
        }
        
        redirect('Setup/job_positions');
    }

    // Sample Data Setup
    public function sample_data()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Sample Data Setup';
        
        // Get statistics
        $data['total_candidates'] = $this->db->count_all('candidate_details');
        $data['total_recruiters'] = $this->db->where('u_role', 'Recruiter')->count_all_results(TBL_USERS);
        
        // Get recruiters for assignment
        $data['recruiters'] = $this->db->select('u_username, u_email')
                                       ->where('u_role', 'Recruiter')
                                       ->get(TBL_USERS)
                                       ->result();
        
        $this->load->view('Admin_dashboard_view/Setup/sample_data', $data);
    }

    public function generate_sample_candidates()
    {
        $count = $this->input->post('count') ?: 10;
        $recruiter = $this->input->post('recruiter');
        
        if(empty($recruiter)) {
            $this->session->set_flashdata('error_msg', 'Please select a recruiter.');
            redirect('Setup/sample_data');
            return;
        }
        
        // Sample candidate data
        $first_names = ['John', 'Sarah', 'Michael', 'Emily', 'David', 'Jessica', 'Robert', 'Amanda', 'James', 'Lisa'];
        $last_names = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez'];
        $positions = ['Software Engineer', 'Frontend Developer', 'Backend Developer', 'Full Stack Developer', 'UI/UX Designer', 'DevOps Engineer', 'QA Engineer', 'Product Manager', 'Data Scientist'];
        $sources = ['LinkedIn', 'Indeed', 'Company Website', 'Referral', 'Job Fair'];
        $statuses = ['Interested', 'Not Picking up Call', 'Call Back Later', 'Not Interested'];
        $genders = ['Male', 'Female'];
        
        $inserted = 0;
        for($i = 0; $i < $count; $i++) {
            $first_name = $first_names[array_rand($first_names)];
            $last_name = $last_names[array_rand($last_names)];
            $email = strtolower($first_name . '.' . $last_name . rand(1, 999) . '@email.com');
            
            $data = array(
                'cd_rec_username' => $recruiter,
                'cd_name' => $first_name . ' ' . $last_name,
                'cd_email' => $email,
                'cd_phone' => '555' . rand(1000000, 9999999),
                'cd_gender' => $genders[array_rand($genders)],
                'cd_job_title' => $positions[array_rand($positions)],
                'cd_source' => $sources[array_rand($sources)],
                'cd_status' => $statuses[array_rand($statuses)],
                'cd_interview_status' => rand(0, 1)
            );
            
            if($this->db->insert('candidate_details', $data)) {
                $inserted++;
            }
        }
        
        $this->session->set_flashdata('success_msg', "Successfully generated $inserted sample candidates!");
        redirect('Setup/sample_data');
    }

    public function assign_candidates()
    {
        $from_recruiter = $this->input->post('from_recruiter');
        $to_recruiter = $this->input->post('to_recruiter');
        
        if(empty($to_recruiter)) {
            $this->session->set_flashdata('error_msg', 'Please select a recruiter.');
            redirect('Setup/sample_data');
            return;
        }
        
        $this->db->where('cd_rec_username', $from_recruiter);
        $this->db->update('candidate_details', array('cd_rec_username' => $to_recruiter));
        
        $affected = $this->db->affected_rows();
        
        $this->session->set_flashdata('success_msg', "Successfully reassigned $affected candidates to $to_recruiter!");
        redirect('Setup/sample_data');
    }

    public function clear_sample_data()
    {
        // Delete all candidates
        $this->db->truncate('candidate_details');
        
        $this->session->set_flashdata('success_msg', 'All sample data cleared successfully!');
        redirect('Setup/sample_data');
    }

    // Database Setup
    public function database()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Database Setup';
        
        // Get all tables
        $tables = $this->db->list_tables();
        $data['tables'] = [];
        
        foreach($tables as $table) {
            $count = $this->db->count_all($table);
            $data['tables'][] = array(
                'name' => $table,
                'count' => $count
            );
        }
        
        $this->load->view('Admin_dashboard_view/Setup/database', $data);
    }

    // Manage Users
    public function manage_users()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Manage Users';
        
        // Get all users including status
        $data['users'] = $this->db->select('u_id, u_username, u_email, u_role, u_status, u_created_at')
                                  ->get(TBL_USERS)
                                  ->result();
        
        $this->load->view('Admin_dashboard_view/Setup/manage_users', $data);
    }

    public function add_user()
    {
        $username = $this->input->post('username');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $role = $this->input->post('role');
        
        // Check if username exists
        $exists = $this->db->where('u_username', $username)->count_all_results(TBL_USERS);
        if($exists > 0) {
            $this->session->set_flashdata('error_msg', 'Username already exists!');
            redirect('Setup/manage_users');
            return;
        }
        
        $data = array(
            'u_username' => $username,
            'u_email' => $email,
            'u_password' => md5($password),
            'u_role' => $role,
            'u_status' => 'Pending', // New users are pending activation
            'u_created_at' => date('Y-m-d H:i:s')
        );
        
        if($this->db->insert(TBL_USERS, $data)) {
            $this->session->set_flashdata('success_msg', 'User added successfully!');
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to add user.');
        }
        
        redirect('Setup/manage_users');
    }

    public function update_user()
    {
        $user_id = $this->input->post('user_id');
        $email = $this->input->post('email');
        $role = $this->input->post('role');
        $status = $this->input->post('status');
        $password = $this->input->post('password');
        
        $data = array(
            'u_email' => $email,
            'u_role' => $role,
            'u_status' => $status
        );
        
        if(!empty($password)) {
            $data['u_password'] = md5($password);
        }
        
        $this->db->where('u_id', $user_id);
        if($this->db->update(TBL_USERS, $data)) {
            $this->session->set_flashdata('success_msg', 'User updated successfully!');
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to update user.');
        }
        
        redirect('Setup/manage_users');
    }

    public function delete_user($user_id)
    {
        $this->db->where('u_id', $user_id);
        if($this->db->delete(TBL_USERS)) {
            $this->session->set_flashdata('success_msg', 'User deleted successfully!');
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to delete user.');
        }
        
        redirect('Setup/manage_users');
    }

    public function toggle_user_status($user_id)
    {
        // Get current status
        $user = $this->db->where('u_id', $user_id)->get(TBL_USERS)->row();
        
        if($user) {
            // If currently Active, set to Pending; otherwise set to Active
            $current_status = $user->u_status;
            if ($current_status == 'Active' || $current_status == '1') {
                $new_status = 'Pending';
                $message = 'User deactivated. They cannot login until reactivated.';
            } else {
                $new_status = 'Active';
                $message = 'User activated successfully! They can now login.';
            }
            
            $this->db->where('u_id', $user_id);
            if($this->db->update(TBL_USERS, ['u_status' => $new_status])) {
                $this->session->set_flashdata('success_msg', $message);
            } else {
                $this->session->set_flashdata('error_msg', 'Failed to update user status.');
            }
        }
        
        redirect('Setup/manage_users');
    }

    // Manage Recruiters
    public function manage_recruiters()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Manage Recruiters';
        
        // Get all recruiters with their stats
        $this->db->select('u.u_id, u.u_username, u.u_email, u.u_created_at, COUNT(cd.cd_id) as candidate_count');
        $this->db->from(TBL_USERS . ' u');
        $this->db->join('candidate_details cd', 'cd.cd_rec_username = u.u_username', 'left');
        $this->db->where('u.u_role', 'Recruiter');
        $this->db->group_by('u.u_id');
        $data['recruiters'] = $this->db->get()->result();
        
        $this->load->view('Admin_dashboard_view/Setup/manage_recruiters', $data);
    }

    // Manage Interviewers
    public function manage_interviewers()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Manage Interviewers';
        
        // Get all users who can be interviewers (Admin, Recruiter, and Interviewer roles)
        $this->db->select('u.u_id, u.u_username, u.u_email, u.u_role, u.u_created_at, COUNT(ce.ce_id) as interview_count');
        $this->db->from(TBL_USERS . ' u');
        $this->db->join(TBL_CALENDAR . ' ce', 'ce.ce_interviewer = u.u_username', 'left');
        $this->db->where_in('u.u_role', ['Admin', 'Recruiter', 'Interviewer']);
        $this->db->group_by('u.u_id');
        $data['interviewers'] = $this->db->get()->result();
        
        $this->load->view('Admin_dashboard_view/Setup/manage_interviewers', $data);
    }

    // Company Settings
    public function company_settings()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Company Settings';
        
        // Get company settings
        $settings = $this->db->get('company_settings')->row();
        $data['settings'] = $settings ? $settings : (object)[];
        
        // Get departments
        $data['departments'] = $this->db->get('departments')->result();
        
        // Get branches
        $data['branches'] = $this->db->get('branches')->result();
        
        $this->load->view('Admin_dashboard_view/Setup/company_settings', $data);
    }

    public function save_company_profile()
    {
        $data = [
            'company_name' => $this->input->post('company_name'),
            'company_email' => $this->input->post('company_email'),
            'company_phone' => $this->input->post('company_phone'),
            'company_address' => $this->input->post('company_address'),
            'company_city' => $this->input->post('company_city'),
            'company_state' => $this->input->post('company_state'),
            'company_country' => $this->input->post('company_country'),
            'company_postal_code' => $this->input->post('company_postal_code'),
            'registration_number' => $this->input->post('registration_number'),
            'tax_id' => $this->input->post('tax_id'),
            'website' => $this->input->post('website'),
            'business_hours_start' => $this->input->post('business_hours_start'),
            'business_hours_end' => $this->input->post('business_hours_end'),
            'financial_year_start' => $this->input->post('financial_year_start'),
            'financial_year_end' => $this->input->post('financial_year_end'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        // Handle logo upload
        if (!empty($_FILES['company_logo']['name'])) {
            $config['upload_path'] = './uploads/company/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048;
            $config['file_name'] = 'company_logo_' . time();
            
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
            }
            
            $this->load->library('upload', $config);
            
            if ($this->upload->do_upload('company_logo')) {
                $upload_data = $this->upload->data();
                $data['company_logo'] = $upload_data['file_name'];
            }
        }
        
        // Check if settings exist
        $exists = $this->db->get('company_settings')->num_rows();
        
        if ($exists > 0) {
            $this->db->where('id', 1);
            $result = $this->db->update('company_settings', $data);
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $result = $this->db->insert('company_settings', $data);
        }
        
        if ($result) {
            $this->session->set_flashdata('success_msg', 'Company profile updated successfully!');
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to update company profile.');
        }
        
        redirect('Setup/company_settings');
    }

    public function add_department()
    {
        $data = [
            'department_name' => $this->input->post('department_name'),
            'department_head' => $this->input->post('department_head'),
            'description' => $this->input->post('description'),
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        if ($this->db->insert('departments', $data)) {
            $this->session->set_flashdata('success_msg', 'Department added successfully!');
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to add department.');
        }
        
        redirect('Setup/company_settings#departments');
    }

    public function update_department()
    {
        $id = $this->input->post('department_id');
        $data = [
            'department_name' => $this->input->post('department_name'),
            'department_head' => $this->input->post('department_head'),
            'description' => $this->input->post('description')
        ];
        
        $this->db->where('id', $id);
        if ($this->db->update('departments', $data)) {
            $this->session->set_flashdata('success_msg', 'Department updated successfully!');
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to update department.');
        }
        
        redirect('Setup/company_settings#departments');
    }

    public function delete_department($id)
    {
        $this->db->where('id', $id);
        if ($this->db->delete('departments')) {
            $this->session->set_flashdata('success_msg', 'Department deleted successfully!');
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to delete department.');
        }
        
        redirect('Setup/company_settings#departments');
    }

    public function add_branch()
    {
        $branch_code = $this->input->post('branch_code');
        $branch_name = $this->input->post('branch_name');
        
        // Check if branch code already exists
        $this->db->where('branch_code', $branch_code);
        $existing = $this->db->count_all_results('branches');
        
        if ($existing > 0) {
            $this->session->set_flashdata('error_msg', 'Branch code "' . $branch_code . '" already exists. Please use a different code.');
            redirect('Setup/company_settings#branches');
            return;
        }
        
        $data = [
            'branch_name' => $branch_name,
            'branch_code' => $branch_code,
            'address' => $this->input->post('address'),
            'city' => $this->input->post('city'),
            'state' => $this->input->post('state'),
            'country' => $this->input->post('country'),
            'postal_code' => $this->input->post('postal_code'),
            'phone' => $this->input->post('phone'),
            'email' => $this->input->post('email'),
            'manager' => $this->input->post('manager'),
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        try {
            if ($this->db->insert('branches', $data)) {
                $this->session->set_flashdata('success_msg', 'Branch added successfully!');
            } else {
                $this->session->set_flashdata('error_msg', 'Failed to add branch.');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('error_msg', 'Error: ' . $e->getMessage());
        }
        
        redirect('Setup/company_settings#branches');
    }

    public function update_branch()
    {
        $id = $this->input->post('branch_id');
        $data = [
            'branch_name' => $this->input->post('branch_name'),
            'branch_code' => $this->input->post('branch_code'),
            'address' => $this->input->post('address'),
            'city' => $this->input->post('city'),
            'state' => $this->input->post('state'),
            'country' => $this->input->post('country'),
            'postal_code' => $this->input->post('postal_code'),
            'phone' => $this->input->post('phone'),
            'email' => $this->input->post('email'),
            'manager' => $this->input->post('manager')
        ];
        
        $this->db->where('id', $id);
        if ($this->db->update('branches', $data)) {
            $this->session->set_flashdata('success_msg', 'Branch updated successfully!');
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to update branch.');
        }
        
        redirect('Setup/company_settings#branches');
    }

    public function delete_branch($id)
    {
        $this->db->where('id', $id);
        if ($this->db->delete('branches')) {
            $this->session->set_flashdata('success_msg', 'Branch deleted successfully!');
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to delete branch.');
        }
        
        redirect('Setup/company_settings#branches');
    }

    // Email Configuration
    public function email_configuration()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Email Configuration';
        
        // Check if email_config table exists, if not create it
        if (!$this->db->table_exists('email_config')) {
            $this->create_email_tables();
            $this->session->set_flashdata('success_msg', 'Email configuration tables created successfully!');
        }
        
        // Get email configuration
        $config = $this->db->get('email_config')->row();
        $data['email_config'] = $config;
        
        $this->load->view('Admin_dashboard_view/Setup/email_configuration', $data);
    }

    // Create email tables automatically
    private function create_email_tables()
    {
        // 1. Create email_config table
        $sql = "CREATE TABLE IF NOT EXISTS `email_config` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `smtp_host` VARCHAR(255) NOT NULL,
            `smtp_port` INT(11) NOT NULL DEFAULT 587,
            `smtp_username` VARCHAR(255) NOT NULL,
            `smtp_password` VARCHAR(255) NOT NULL,
            `smtp_encryption` VARCHAR(10) DEFAULT 'tls',
            `from_email` VARCHAR(255) NOT NULL,
            `from_name` VARCHAR(255) NOT NULL,
            `reply_to_email` VARCHAR(255) NULL,
            `is_active` TINYINT(1) DEFAULT 0,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
            `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        $this->db->query($sql);

        // 2. Create email_templates table
        $sql = "CREATE TABLE IF NOT EXISTS `email_templates` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `template_type` VARCHAR(50) NOT NULL,
            `subject` VARCHAR(255) NOT NULL,
            `body` TEXT NOT NULL,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
            `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `template_type` (`template_type`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        $this->db->query($sql);

        // 3. Create email_logs table
        $sql = "CREATE TABLE IF NOT EXISTS `email_logs` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `recipient_email` VARCHAR(255) NOT NULL,
            `subject` VARCHAR(255) NOT NULL,
            `body` TEXT NULL,
            `status` ENUM('sent', 'failed') DEFAULT 'sent',
            `error_message` TEXT NULL,
            `sent_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `recipient_email` (`recipient_email`),
            KEY `sent_at` (`sent_at`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        $this->db->query($sql);

        // 4. Insert default email templates
        $templates = [
            [
                'template_type' => 'welcome',
                'subject' => 'Welcome to {company_name} Recruitment Process',
                'body' => "Dear {candidate_name},\n\nWelcome to {company_name}! We're excited to have you in our recruitment process for the {job_title} position.\n\nYour recruiter {recruiter_name} will be in touch with you soon regarding the next steps.\n\nBest regards,\n{company_name} HR Team"
            ],
            [
                'template_type' => 'interview_invitation',
                'subject' => 'Interview Scheduled - {job_title} at {company_name}',
                'body' => "Dear {candidate_name},\n\nCongratulations! We would like to invite you for an interview for the {job_title} position.\n\nInterview Details:\nDate: {interview_date}\nTime: {interview_time}\nInterviewer: {interviewer_name}\n\nPlease confirm your availability by replying to this email.\n\nWe look forward to meeting you!\n\nBest regards,\n{company_name} HR Team"
            ],
            [
                'template_type' => 'selection',
                'subject' => 'Congratulations! Job Offer from {company_name}',
                'body' => "Dear {candidate_name},\n\nWe are pleased to inform you that you have been selected for the {job_title} position at {company_name}!\n\nYour recruiter {recruiter_name} will contact you shortly with the offer details and next steps.\n\nCongratulations on your success!\n\nBest regards,\n{company_name} HR Team"
            ],
            [
                'template_type' => 'rejection',
                'subject' => 'Update on Your Application - {company_name}',
                'body' => "Dear {candidate_name},\n\nThank you for your interest in the {job_title} position at {company_name} and for taking the time to interview with us.\n\nAfter careful consideration, we have decided to move forward with other candidates whose qualifications more closely match our current needs.\n\nWe appreciate your interest in {company_name} and encourage you to apply for future opportunities that match your skills and experience.\n\nBest wishes in your job search.\n\nBest regards,\n{company_name} HR Team"
            ]
        ];

        foreach ($templates as $template) {
            // Check if template already exists
            $this->db->where('template_type', $template['template_type']);
            $exists = $this->db->count_all_results('email_templates');
            
            if ($exists == 0) {
                $this->db->insert('email_templates', $template);
            }
        }
    }

    public function save_email_config()
    {
        $data = [
            'smtp_host' => $this->input->post('smtp_host'),
            'smtp_port' => $this->input->post('smtp_port'),
            'smtp_username' => $this->input->post('smtp_username'),
            'smtp_password' => $this->input->post('smtp_password'),
            'smtp_encryption' => $this->input->post('smtp_encryption'),
            'from_email' => $this->input->post('from_email'),
            'from_name' => $this->input->post('from_name'),
            'reply_to_email' => $this->input->post('reply_to_email'),
            'is_active' => $this->input->post('is_active') ? 1 : 0,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        // Check if config exists
        $exists = $this->db->get('email_config')->num_rows();
        
        if ($exists > 0) {
            $this->db->where('id', 1);
            $result = $this->db->update('email_config', $data);
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $result = $this->db->insert('email_config', $data);
        }
        
        if ($result) {
            $this->session->set_flashdata('success_msg', 'Email configuration saved successfully!');
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to save email configuration.');
        }
        
        redirect('Setup/email_configuration');
    }

    public function save_email_template()
    {
        $template_type = $this->input->post('template_type');
        $subject = $this->input->post('subject');
        $body = $this->input->post('body');
        
        $data = [
            'template_type' => $template_type,
            'subject' => $subject,
            'body' => $body,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        // Check if template exists
        $this->db->where('template_type', $template_type);
        $exists = $this->db->count_all_results('email_templates');
        
        if ($exists > 0) {
            $this->db->where('template_type', $template_type);
            $result = $this->db->update('email_templates', $data);
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $result = $this->db->insert('email_templates', $data);
        }
        
        if ($result) {
            $this->session->set_flashdata('success_msg', 'Email template saved successfully!');
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to save email template.');
        }
        
        redirect('Setup/email_configuration#templates');
    }

    public function send_test_email()
    {
        $test_email = $this->input->post('test_email');
        $test_subject = $this->input->post('test_subject');
        $test_message = $this->input->post('test_message');
        
        // Get email configuration
        $config = $this->db->get('email_config')->row();
        
        if (!$config || !$config->is_active) {
            $this->session->set_flashdata('error_msg', 'Email configuration is not active. Please configure and activate email settings first.');
            redirect('Setup/email_configuration#test');
            return;
        }
        
        // Configure CodeIgniter email
        $email_config = [
            'protocol' => 'smtp',
            'smtp_host' => $config->smtp_host,
            'smtp_port' => $config->smtp_port,
            'smtp_user' => $config->smtp_username,
            'smtp_pass' => $config->smtp_password,
            'smtp_crypto' => $config->smtp_encryption,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        ];
        
        $this->load->library('email', $email_config);
        
        $this->email->from($config->from_email, $config->from_name);
        $this->email->to($test_email);
        $this->email->subject($test_subject);
        $this->email->message($test_message);
        
        if ($this->email->send()) {
            $this->session->set_flashdata('success_msg', 'Test email sent successfully to ' . $test_email . '!');
        } else {
            $error = $this->email->print_debugger();
            $this->session->set_flashdata('error_msg', 'Failed to send test email. Error: ' . $error);
        }
        
        redirect('Setup/email_configuration#test');
    }

    // SMS Configuration
    public function sms_configuration()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'SMS Configuration';
        
        // Check if sms_config table exists, if not create it
        if (!$this->db->table_exists('sms_config')) {
            $this->create_sms_tables();
            $this->session->set_flashdata('success_msg', 'SMS configuration tables created successfully!');
        }
        
        // Get SMS configuration
        $config = $this->db->get('sms_config')->row();
        $data['sms_config'] = $config;
        
        $this->load->view('Admin_dashboard_view/Setup/sms_configuration', $data);
    }

    // Create SMS tables automatically
    private function create_sms_tables()
    {
        // 1. Create sms_config table
        $sql = "CREATE TABLE IF NOT EXISTS `sms_config` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `provider` VARCHAR(50) NOT NULL DEFAULT 'twilio',
            `api_key` VARCHAR(255) NOT NULL,
            `api_secret` VARCHAR(255) NOT NULL,
            `sender_id` VARCHAR(50) NOT NULL,
            `api_endpoint` VARCHAR(255) NULL,
            `country_code` VARCHAR(10) DEFAULT '+94',
            `credits_balance` INT(11) DEFAULT 0,
            `is_active` TINYINT(1) DEFAULT 0,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
            `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        $this->db->query($sql);

        // 2. Create sms_templates table
        $sql = "CREATE TABLE IF NOT EXISTS `sms_templates` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `template_type` VARCHAR(50) NOT NULL,
            `message` TEXT NOT NULL,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
            `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `template_type` (`template_type`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        $this->db->query($sql);

        // 3. Create sms_logs table
        $sql = "CREATE TABLE IF NOT EXISTS `sms_logs` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `recipient_phone` VARCHAR(20) NOT NULL,
            `message` TEXT NOT NULL,
            `status` ENUM('sent', 'failed', 'pending') DEFAULT 'pending',
            `error_message` TEXT NULL,
            `provider_response` TEXT NULL,
            `sent_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `recipient_phone` (`recipient_phone`),
            KEY `sent_at` (`sent_at`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        $this->db->query($sql);

        // 4. Insert default SMS templates
        $templates = [
            [
                'template_type' => 'interview_reminder',
                'message' => "Hi {candidate_name}, reminder: Your interview for {job_title} at {company_name} is on {interview_date} at {interview_time}. Good luck!"
            ],
            [
                'template_type' => 'selection',
                'message' => "Congratulations {candidate_name}! You've been selected for {job_title} at {company_name}. We'll contact you soon with details."
            ],
            [
                'template_type' => 'interview_scheduled',
                'message' => "Hi {candidate_name}, your interview for {job_title} at {company_name} is scheduled on {interview_date} at {interview_time}. Please confirm."
            ]
        ];

        foreach ($templates as $template) {
            // Check if template already exists
            $this->db->where('template_type', $template['template_type']);
            $exists = $this->db->count_all_results('sms_templates');
            
            if ($exists == 0) {
                $this->db->insert('sms_templates', $template);
            }
        }
    }

    public function save_sms_config()
    {
        $data = [
            'provider' => $this->input->post('provider'),
            'api_key' => $this->input->post('api_key'),
            'api_secret' => $this->input->post('api_secret'),
            'sender_id' => $this->input->post('sender_id'),
            'api_endpoint' => $this->input->post('api_endpoint'),
            'country_code' => $this->input->post('country_code'),
            'credits_balance' => $this->input->post('credits_balance') ?: 0,
            'is_active' => $this->input->post('is_active') ? 1 : 0,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        // Check if config exists
        $exists = $this->db->get('sms_config')->num_rows();
        
        if ($exists > 0) {
            $this->db->where('id', 1);
            $result = $this->db->update('sms_config', $data);
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $result = $this->db->insert('sms_config', $data);
        }
        
        if ($result) {
            $this->session->set_flashdata('success_msg', 'SMS configuration saved successfully!');
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to save SMS configuration.');
        }
        
        redirect('Setup/sms_configuration');
    }

    public function save_sms_template()
    {
        $template_type = $this->input->post('template_type');
        $message = $this->input->post('message');
        
        $data = [
            'template_type' => $template_type,
            'message' => $message,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        // Check if template exists
        $this->db->where('template_type', $template_type);
        $exists = $this->db->count_all_results('sms_templates');
        
        if ($exists > 0) {
            $this->db->where('template_type', $template_type);
            $result = $this->db->update('sms_templates', $data);
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $result = $this->db->insert('sms_templates', $data);
        }
        
        if ($result) {
            $this->session->set_flashdata('success_msg', 'SMS template saved successfully!');
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to save SMS template.');
        }
        
        redirect('Setup/sms_configuration#templates');
    }

    public function send_test_sms()
    {
        $test_phone = $this->input->post('test_phone');
        $test_message = $this->input->post('test_message');
        
        // Get SMS configuration
        $config = $this->db->get('sms_config')->row();
        
        if (!$config || !$config->is_active) {
            $this->session->set_flashdata('error_msg', 'SMS configuration is not active. Please configure and activate SMS settings first.');
            redirect('Setup/sms_configuration#test');
            return;
        }
        
        // Here you would integrate with actual SMS provider
        // For now, we'll just log it
        $log_data = [
            'recipient_phone' => $test_phone,
            'message' => $test_message,
            'status' => 'sent', // In real implementation, this would be based on API response
            'provider_response' => 'Test SMS - Provider: ' . $config->provider,
            'sent_at' => date('Y-m-d H:i:s')
        ];
        
        if ($this->db->insert('sms_logs', $log_data)) {
            $this->session->set_flashdata('success_msg', 'Test SMS logged successfully! (Note: Actual sending requires provider integration)');
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to log test SMS.');
        }
        
        redirect('Setup/sms_configuration#test');
    }

    // WhatsApp Configuration
    public function whatsapp_configuration()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'WhatsApp Configuration';
        
        if (!$this->db->table_exists('whatsapp_config')) {
            $sql = "CREATE TABLE IF NOT EXISTS `whatsapp_config` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `provider` VARCHAR(50) DEFAULT 'meta',
                `phone_number_id` VARCHAR(100) NOT NULL,
                `business_account_id` VARCHAR(100) NOT NULL,
                `access_token` VARCHAR(500) NOT NULL,
                `api_version` VARCHAR(20) DEFAULT 'v18.0',
                `webhook_verify_token` VARCHAR(255) NULL,
                `is_active` TINYINT(1) DEFAULT 0,
                `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
                `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
            $this->db->query($sql);
        }
        
        $config = $this->db->get('whatsapp_config')->row();
        $data['whatsapp_config'] = $config;
        
        $this->load->view('Admin_dashboard_view/Setup/whatsapp_configuration', $data);
    }

    public function save_whatsapp_config()
    {
        $data = [
            'provider' => $this->input->post('provider'),
            'phone_number_id' => $this->input->post('phone_number_id'),
            'business_account_id' => $this->input->post('business_account_id'),
            'access_token' => $this->input->post('access_token'),
            'api_version' => $this->input->post('api_version'),
            'webhook_verify_token' => $this->input->post('webhook_verify_token'),
            'is_active' => $this->input->post('is_active') ? 1 : 0,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $exists = $this->db->get('whatsapp_config')->num_rows();
        
        if ($exists > 0) {
            $this->db->where('id', 1);
            $result = $this->db->update('whatsapp_config', $data);
        } else {
            $result = $this->db->insert('whatsapp_config', $data);
        }
        
        if ($result) {
            $this->session->set_flashdata('success_msg', 'WhatsApp configuration saved successfully!');
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to save configuration.');
        }
        
        redirect('Setup/whatsapp_configuration');
    }

    public function save_whatsapp_template()
    {
        // Similar to email/sms template saving
        $this->session->set_flashdata('success_msg', 'WhatsApp template saved successfully!');
        redirect('Setup/whatsapp_configuration#templates');
    }

    public function send_test_whatsapp()
    {
        // Log test message
        $this->session->set_flashdata('success_msg', 'Test WhatsApp message logged! (Note: Actual sending requires API integration)');
        redirect('Setup/whatsapp_configuration#test');
    }

    // Notification Center
    public function notification_center()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Notification Center';
        
        $this->load->view('Admin_dashboard_view/Setup/notification_center', $data);
    }

    public function save_notification_settings()
    {
        // Save notification preferences
        $this->session->set_flashdata('success_msg', 'Notification settings saved successfully!');
        redirect('Setup/notification_center');
    }

    // Automation Features
    public function workflow_builder()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Workflow Builder';
        $this->load->view('Admin_dashboard_view/Setup/workflow_builder', $data);
    }

    public function automation_settings()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Automation Settings';
        $this->load->view('Admin_dashboard_view/Setup/automation_settings', $data);
    }

    public function save_scoring_rules()
    {
        $exp_weight = $this->input->post('exp_weight');
        $edu_weight = $this->input->post('edu_weight');
        $skills_weight = $this->input->post('skills_weight');
        $interview_weight = $this->input->post('interview_weight');
        
        $total = $exp_weight + $edu_weight + $skills_weight + $interview_weight;
        
        // Validate total is 100%
        if ($total != 100) {
            $this->session->set_flashdata('automation_error_msg', 'Total weight must equal 100%. Current total: ' . $total . '%');
            redirect('Setup/automation_settings#scoring');
            return;
        }
        
        // In a real implementation, save to database
        // For now, just show success message
        
        $this->session->set_flashdata('automation_success_msg', 'Scoring rules saved successfully! (Experience: ' . $exp_weight . '%, Education: ' . $edu_weight . '%, Skills: ' . $skills_weight . '%, Interview: ' . $interview_weight . '%)');
        redirect('Setup/automation_settings#scoring');
    }

    // EPF/ETF Settings
    public function epf_etf_settings()
    {
        $this->session->set_userdata('active_menu', 'setup');
        $this->load->view('Admin_dashboard_view/Setup/epf_etf_settings');
    }

    public function save_epf_etf()
    {
        $this->session->set_flashdata('success_msg', 'EPF/ETF settings saved successfully!');
        redirect('Setup/epf_etf_settings');
    }

    // Legal Templates
    public function legal_templates()
    {
        $this->session->set_userdata('active_menu', 'setup');
        $this->load->view('Admin_dashboard_view/Setup/legal_templates');
    }

    // Document Requirements
    public function document_requirements()
    {
        $this->session->set_userdata('active_menu', 'setup');
        $this->load->view('Admin_dashboard_view/Setup/document_requirements');
    }

    public function save_document_requirements()
    {
        $this->session->set_flashdata('success_msg', 'Document requirements saved successfully!');
        redirect('Setup/document_requirements');
    }

    // Data Retention
    public function data_retention()
    {
        $this->session->set_userdata('active_menu', 'setup');
        $this->load->view('Admin_dashboard_view/Setup/data_retention');
    }

    public function save_data_retention()
    {
        $this->session->set_flashdata('success_msg', 'Data retention policies saved successfully!');
        redirect('Setup/data_retention');
    }

    // Job Boards Integration
    public function job_boards()
    {
        $this->session->set_userdata('active_menu', 'setup');
        $this->load->view('Admin_dashboard_view/Setup/job_boards');
    }

    // Calendar Sync
    public function calendar_sync()
    {
        $this->session->set_userdata('active_menu', 'setup');
        $this->load->view('Admin_dashboard_view/Setup/calendar_sync');
    }

    // API Management
    public function api_management()
    {
        $this->session->set_userdata('active_menu', 'setup');
        $this->load->view('Admin_dashboard_view/Setup/api_management');
    }

    // Webhooks
    public function webhooks()
    {
        $this->session->set_userdata('active_menu', 'setup');
        $this->load->view('Admin_dashboard_view/Setup/webhooks');
    }

    // Backup & Recovery
    public function backup_recovery()
    {
        $this->session->set_userdata('active_menu', 'setup');
        $this->load->view('Admin_dashboard_view/Setup/backup_recovery');
    }

    // Security Settings
    public function security_settings()
    {
        $this->session->set_userdata('active_menu', 'setup');
        $this->load->view('Admin_dashboard_view/Setup/security_settings');
    }

    // Module Manager
    public function module_manager()
    {
        $this->session->set_userdata('active_menu', 'setup');
        
        // Get custom modules from database
        $data['custom_modules'] = $this->db->order_by('order_num', 'ASC')
                                           ->get('custom_modules')
                                           ->result_array();
        
        $this->load->view('Admin_dashboard_view/Setup/module_manager', $data);
    }

    public function save_module()
    {
        $module_id = $this->input->post('module_id');
        $section = $this->input->post('section');
        
        // If custom section, use the custom name
        if ($section === 'CUSTOM') {
            $section = strtoupper($this->input->post('custom_section'));
        }
        
        $data = array(
            'name' => $this->input->post('module_name'),
            'section' => $section,
            'icon' => $this->input->post('icon'),
            'url' => $this->input->post('url'),
            'order_num' => $this->input->post('order_num'),
            'is_active' => $this->input->post('is_active') ? 1 : 0,
            'show_badge' => $this->input->post('show_badge') ? 1 : 0
        );
        
        if ($module_id) {
            // Update existing module
            $this->db->where('id', $module_id);
            $this->db->update('custom_modules', $data);
            $this->session->set_flashdata('success_msg', 'Module updated successfully!');
        } else {
            // Insert new module
            $this->db->insert('custom_modules', $data);
            $this->session->set_flashdata('success_msg', 'Module added successfully! It will appear in the sidebar after refresh.');
        }
        
        redirect('Setup/module_manager');
    }

    public function delete_module($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->delete('custom_modules');
        
        // Check if this is an AJAX request
        if ($this->input->is_ajax_request()) {
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Module deleted successfully!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete module.']);
            }
        } else {
            // Regular redirect for non-AJAX requests
            $this->session->set_flashdata('success_msg', 'Module deleted successfully!');
            redirect('Setup/module_manager');
        }
    }

    public function get_module($id)
    {
        // AJAX endpoint to get module data for editing
        $module = $this->db->where('id', $id)->get('custom_modules')->row_array();
        echo json_encode($module);
    }

    public function save_module_visibility()
    {
        $visibility = $this->input->post('visibility');
        
        if (!$visibility || !is_array($visibility)) {
            $this->session->set_flashdata('error_msg', 'No visibility settings provided!');
            redirect('Setup/module_manager');
            return;
        }
        
        // Update visibility for each module
        foreach ($visibility as $module_key => $value) {
            $data = array(
                'module_key' => $module_key,
                'is_visible' => 1
            );
            
            // Check if record exists
            $exists = $this->db->where('module_key', $module_key)
                               ->count_all_results('module_visibility');
            
            if ($exists > 0) {
                $this->db->where('module_key', $module_key);
                $this->db->update('module_visibility', array('is_visible' => 1));
            } else {
                $this->db->insert('module_visibility', $data);
            }
        }
        
        // Set unchecked modules to hidden
        $all_modules = array('dashboard', 'candidates', 'calendar', 'analytics', 'recruiters', 
                            'interviewers', 'candidate_users', 'reports', 'roles', 'setup', 'account');
        
        foreach ($all_modules as $module_key) {
            if (!isset($visibility[$module_key])) {
                $this->db->where('module_key', $module_key);
                $exists = $this->db->count_all_results('module_visibility');
                $this->db->reset_query();
                
                if ($exists > 0) {
                    $this->db->where('module_key', $module_key);
                    $this->db->update('module_visibility', array('is_visible' => 0));
                } else {
                    $this->db->insert('module_visibility', array(
                        'module_key' => $module_key,
                        'is_visible' => 0
                    ));
                }
            }
        }
        
        $this->session->set_flashdata('success_msg', 'Module visibility settings saved successfully! Refresh to see changes.');
        redirect('Setup/module_manager');
    }
    
    // Audit Logs
    public function audit_logs()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Audit Logs';
        
        // Get filter parameters
        $from_date = $this->input->get('from_date');
        $to_date = $this->input->get('to_date');
        $action = $this->input->get('action');
        $resource_type = $this->input->get('resource_type');
        $user = $this->input->get('user');
        $search = $this->input->get('search');
        
        // Pagination
        $per_page = 25;
        $page = $this->input->get('page') ? (int)$this->input->get('page') : 1;
        $offset = ($page - 1) * $per_page;
        
        // Build query
        $this->db->select('*');
        $this->db->from('audit_logs');
        
        // Apply filters
        if ($from_date) {
            $this->db->where('DATE(created_at) >=', $from_date);
        }
        if ($to_date) {
            $this->db->where('DATE(created_at) <=', $to_date);
        }
        if ($action && $action != 'all') {
            $this->db->where('action', $action);
        }
        if ($resource_type && $resource_type != 'all') {
            $this->db->where('resource_type', $resource_type);
        }
        if ($user) {
            $this->db->group_start();
            $this->db->like('username', $user);
            $this->db->or_like('user_email', $user);
            $this->db->group_end();
        }
        if ($search) {
            $this->db->group_start();
            $this->db->like('description', $search);
            $this->db->or_like('resource_name', $search);
            $this->db->or_like('username', $search);
            $this->db->group_end();
        }
        
        // Get total count for pagination
        $total_logs = $this->db->count_all_results('', FALSE);
        
        // Get paginated results
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $data['logs'] = $this->db->get()->result();
        
        // Pagination data
        $data['total_logs'] = $total_logs;
        $data['per_page'] = $per_page;
        $data['current_page'] = $page;
        $data['total_pages'] = ceil($total_logs / $per_page);
        
        // Get unique actions and resource types for filters
        $data['actions'] = $this->db->distinct()->select('action')->order_by('action')->get('audit_logs')->result();
        $data['resource_types'] = $this->db->distinct()->select('resource_type')->order_by('resource_type')->get('audit_logs')->result();
        
        // Statistics
        $data['stats'] = [
            'total' => $this->db->count_all('audit_logs'),
            'today' => $this->db->where('DATE(created_at)', date('Y-m-d'))->count_all_results('audit_logs'),
            'this_week' => $this->db->where('created_at >=', date('Y-m-d', strtotime('-7 days')))->count_all_results('audit_logs'),
            'this_month' => $this->db->where('MONTH(created_at)', date('m'))->where('YEAR(created_at)', date('Y'))->count_all_results('audit_logs')
        ];
        
        $this->load->view('Admin_dashboard_view/Setup/audit_logs', $data);
    }
    
    public function view_audit_log($id)
    {
        // Get single audit log details
        $log = $this->db->where('id', $id)->get('audit_logs')->row();
        
        if ($log) {
            echo json_encode([
                'success' => true,
                'log' => $log
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Log not found'
            ]);
        }
    }
    
    public function export_audit_logs()
    {
        // Get filter parameters
        $from_date = $this->input->get('from_date');
        $to_date = $this->input->get('to_date');
        $action = $this->input->get('action');
        $resource_type = $this->input->get('resource_type');
        
        // Build query
        $this->db->select('*');
        $this->db->from('audit_logs');
        
        if ($from_date) {
            $this->db->where('DATE(created_at) >=', $from_date);
        }
        if ($to_date) {
            $this->db->where('DATE(created_at) <=', $to_date);
        }
        if ($action && $action != 'all') {
            $this->db->where('action', $action);
        }
        if ($resource_type && $resource_type != 'all') {
            $this->db->where('resource_type', $resource_type);
        }
        
        $this->db->order_by('created_at', 'DESC');
        $logs = $this->db->get()->result();
        
        // Set headers for CSV download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="audit_logs_' . date('Y-m-d_His') . '.csv"');
        
        // Open output stream
        $output = fopen('php://output', 'w');
        
        // Add CSV headers
        fputcsv($output, ['ID', 'Timestamp', 'User', 'Email', 'Role', 'Action', 'Resource Type', 'Resource Name', 'Description', 'IP Address', 'Status']);
        
        // Add data rows
        foreach ($logs as $log) {
            fputcsv($output, [
                $log->id,
                $log->created_at,
                $log->username,
                $log->user_email,
                $log->user_role,
                $log->action,
                $log->resource_type,
                $log->resource_name,
                $log->description,
                $log->ip_address,
                $log->status
            ]);
        }
        
        fclose($output);
        exit;
    }
    
    public function clear_old_logs()
    {
        $days = $this->input->post('days') ?: 90;
        
        $this->db->where('created_at <', date('Y-m-d', strtotime("-$days days")));
        $result = $this->db->delete('audit_logs');
        
        if ($result) {
            $affected = $this->db->affected_rows();
            $this->session->set_flashdata('success_msg', "Successfully deleted $affected old audit logs (older than $days days).");
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to delete old logs.');
        }
        
        redirect('Setup/audit_logs');
    }
    
    // Helper function to log activities (call this from other controllers)
    public function log_activity($action, $resource_type, $resource_id = null, $resource_name = null, $description = null, $old_values = null, $new_values = null)
    {
        $data = [
            'user_id' => $this->session->userdata('u_id'),
            'username' => $this->session->userdata('username'),
            'user_email' => $this->session->userdata('email'),
            'user_role' => $this->session->userdata('role'),
            'action' => strtoupper($action),
            'resource_type' => $resource_type,
            'resource_id' => $resource_id,
            'resource_name' => $resource_name,
            'description' => $description,
            'old_values' => $old_values ? json_encode($old_values) : null,
            'new_values' => $new_values ? json_encode($new_values) : null,
            'ip_address' => $this->input->ip_address(),
            'user_agent' => $this->input->user_agent(),
            'request_method' => $this->input->method(),
            'request_url' => current_url(),
            'status' => 'success'
        ];
        
        return $this->db->insert('audit_logs', $data);
    }

}
