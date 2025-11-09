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
            'manager' => $this->input->post('manager'),
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        if ($this->db->insert('branches', $data)) {
            $this->session->set_flashdata('success_msg', 'Branch added successfully!');
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to add branch.');
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
}
