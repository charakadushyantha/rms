<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Job_posting extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->logged_in();
        $this->load->model('Job_posting_model');
        $this->load->model('Job_platform_model');
    }

    private function logged_in()
    {
        if (!$this->session->userdata('authenticated')) {
            redirect(LOGIN_URL);
        }
    }

    // Main job posting dashboard
    public function index()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['display_name'] = $this->session->userdata('full_name') 
            ? $this->session->userdata('full_name') 
            : $this->session->userdata('username');
        $data['page_title'] = 'Job Postings';
        
        // Get all job postings
        $data['job_postings'] = $this->Job_posting_model->get_all_jobs();
        
        // Get statistics
        $data['total_jobs'] = $this->Job_posting_model->count_jobs();
        $data['active_jobs'] = $this->Job_posting_model->count_jobs_by_status('Active');
        $data['draft_jobs'] = $this->Job_posting_model->count_jobs_by_status('Draft');
        $data['closed_jobs'] = $this->Job_posting_model->count_jobs_by_status('Closed');
        
        $this->load->view('Job_posting_view/index', $data);
    }

    // Create new job posting
    public function create()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['display_name'] = $this->session->userdata('full_name') 
            ? $this->session->userdata('full_name') 
            : $this->session->userdata('username');
        $data['page_title'] = 'Create Job Posting';
        
        // Get platforms for selection
        $data['platforms'] = $this->Job_platform_model->get_active_platforms();
        
        // Get categories and positions
        $data['categories'] = $this->db->get('job_categories')->result();
        $data['positions'] = $this->db->get('job_positions')->result();
        
        $this->load->view('Job_posting_view/create', $data);
    }



    // Save job posting
    public function save()
    {
        $job_data = [
            'jp_title' => $this->input->post('jp_title'),
            'jp_description' => $this->input->post('jp_description'),
            'jp_requirements' => $this->input->post('jp_requirements'),
            'jp_responsibilities' => $this->input->post('jp_responsibilities'),
            'jp_location' => $this->input->post('jp_location'),
            'jp_employment_type' => $this->input->post('jp_employment_type'),
            'jp_salary_min' => $this->input->post('jp_salary_min'),
            'jp_salary_max' => $this->input->post('jp_salary_max'),
            'jp_category_id' => $this->input->post('jp_category_id'),
            'jp_position_id' => $this->input->post('jp_position_id'),
            'jp_department' => $this->input->post('jp_department'),
            'jp_experience_min' => $this->input->post('jp_experience_min'),
            'jp_experience_max' => $this->input->post('jp_experience_max'),
            'jp_status' => $this->input->post('jp_status'),
            'jp_posted_by' => $this->session->userdata('username'),
            'jp_expires_at' => $this->input->post('jp_expires_at')
        ];

        $job_id = $this->Job_posting_model->create_job($job_data);

        if ($job_id) {
            // Get selected platforms
            $platforms = $this->input->post('platforms');
            
            if ($platforms && is_array($platforms)) {
                // Post to selected platforms
                foreach ($platforms as $platform_id) {
                    $this->post_to_platform($job_id, $platform_id);
                }
            }

            $this->session->set_flashdata('success_msg', 'Job posted successfully!');
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to create job posting');
        }

        redirect('Job_posting');
    }

    // Post job to specific platform
    private function post_to_platform($job_id, $platform_id)
    {
        $job = $this->Job_posting_model->get_job($job_id);
        $platform = $this->Job_platform_model->get_platform($platform_id);
        $credentials = $this->Job_platform_model->get_credentials($platform_id);

        if (!$credentials || !$credentials->is_enabled) {
            return false;
        }

        // Load appropriate integration library
        $library_name = ucfirst($platform->platform_key) . '_integration';
        
        try {
            $this->load->library($library_name);
            $result = $this->$library_name->post_job($job, $credentials);
            
            // Save posting history
            $history_data = [
                'jp_id' => $job_id,
                'platform_id' => $platform_id,
                'external_job_id' => $result['job_id'] ?? null,
                'status' => $result['success'] ? 'Posted' : 'Failed',
                'posted_at' => date('Y-m-d H:i:s'),
                'error_message' => $result['error'] ?? null
            ];
            
            $this->Job_posting_model->save_history($history_data);
            
            return $result['success'];
        } catch (Exception $e) {
            log_message('error', 'Job posting error: ' . $e->getMessage());
            return false;
        }
    }

    // View job details
    public function view($job_id)
    {
        $data['uname'] = $this->session->userdata('username');
        $data['display_name'] = $this->session->userdata('full_name') 
            ? $this->session->userdata('full_name') 
            : $this->session->userdata('username');
        $data['page_title'] = 'Job Details';
        
        $data['job'] = $this->Job_posting_model->get_job($job_id);
        $data['posting_history'] = $this->Job_posting_model->get_posting_history($job_id);
        
        $this->load->view('Job_posting_view/view', $data);
    }

    // Analytics dashboard
    public function analytics()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['display_name'] = $this->session->userdata('full_name') 
            ? $this->session->userdata('full_name') 
            : $this->session->userdata('username');
        $data['page_title'] = 'Job Posting Analytics';
        
        $data['analytics'] = $this->Job_posting_model->get_analytics();
        
        // Calculate summary statistics
        $data['total_posts'] = 0;
        $data['total_views'] = 0;
        $data['total_clicks'] = 0;
        $data['total_applications'] = 0;
        
        if (!empty($data['analytics']['platform_performance'])) {
            foreach ($data['analytics']['platform_performance'] as $platform) {
                $data['total_posts'] += $platform->total_posts ?? 0;
                $data['total_views'] += $platform->total_views ?? 0;
                $data['total_clicks'] += $platform->total_clicks ?? 0;
                $data['total_applications'] += $platform->total_applications ?? 0;
            }
        }
        
        $this->load->view('Job_posting_view/analytics', $data);
    }

    // Platform configuration
    public function platforms()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['display_name'] = $this->session->userdata('full_name') 
            ? $this->session->userdata('full_name') 
            : $this->session->userdata('username');
        $data['page_title'] = 'Platform Configuration';
        
        $data['platforms'] = $this->Job_platform_model->get_all_platforms();
        
        $this->load->view('Job_posting_view/platforms', $data);
    }

    // Save platform credentials
    public function save_credentials()
    {
        $cred_data = [
            'platform_id' => $this->input->post('platform_id'),
            'api_key' => $this->input->post('api_key'),
            'api_secret' => $this->input->post('api_secret'),
            'is_enabled' => $this->input->post('is_enabled') ? 1 : 0
        ];

        if ($this->Job_platform_model->save_credentials($cred_data)) {
            echo json_encode(['success' => true, 'message' => 'Credentials saved successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to save credentials']);
        }
    }

    // Delete job posting
    public function delete($job_id)
    {
        if ($this->Job_posting_model->delete_job($job_id)) {
            $this->session->set_flashdata('success_msg', 'Job deleted successfully');
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to delete job');
        }
        redirect('Job_posting');
    }
}
