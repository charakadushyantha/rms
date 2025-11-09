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
}
