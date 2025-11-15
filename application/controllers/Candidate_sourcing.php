<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidate_sourcing extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->logged_in();
        $this->load->model('Candidate_sourcing_model');
    }

    private function logged_in()
    {
        if (!$this->session->userdata('authenticated')) {
            redirect(LOGIN_URL);
        }
    }

    // Dashboard
    public function index()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Candidate Sourcing';
        
        // Get filters from query string
        $filters = [
            'search' => $this->input->get('search'),
            'skills' => $this->input->get('skills'),
            'location' => $this->input->get('location'),
            'experience_min' => $this->input->get('exp_min'),
            'experience_max' => $this->input->get('exp_max'),
            'status' => $this->input->get('status'),
            'source' => $this->input->get('source')
        ];
        
        $data['candidates'] = $this->Candidate_sourcing_model->get_all_candidates($filters);
        $data['stats'] = $this->Candidate_sourcing_model->get_statistics();
        $data['sources'] = $this->Candidate_sourcing_model->get_all_sources();
        $data['pools'] = $this->Candidate_sourcing_model->get_all_pools();
        
        $this->load->view('Candidate_sourcing_view/index', $data);
    }

    // Add new candidate
    public function add()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Add Candidate';
        $data['sources'] = $this->Candidate_sourcing_model->get_all_sources();
        
        $this->load->view('Candidate_sourcing_view/add', $data);
    }

    // Save candidate
    public function save()
    {
        $username = $this->session->userdata('username');
        
        $candidate_data = [
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
            'location' => $this->input->post('location'),
            'current_title' => $this->input->post('current_title'),
            'current_company' => $this->input->post('current_company'),
            'total_experience' => $this->input->post('total_experience'),
            'expected_salary' => $this->input->post('expected_salary'),
            'notice_period' => $this->input->post('notice_period'),
            'linkedin_url' => $this->input->post('linkedin_url'),
            'github_url' => $this->input->post('github_url'),
            'portfolio_url' => $this->input->post('portfolio_url'),
            'summary' => $this->input->post('summary'),
            'source' => $this->input->post('source'),
            'source_details' => $this->input->post('source_details'),
            'status' => 'New',
            'added_by' => $username
        ];
        
        $candidate_id = $this->Candidate_sourcing_model->create_candidate($candidate_data);
        
        if ($candidate_id) {
            // Add skills
            $skills = $this->input->post('skills');
            if ($skills) {
                $skills_array = explode(',', $skills);
                foreach ($skills_array as $skill) {
                    $skill = trim($skill);
                    if ($skill) {
                        $this->Candidate_sourcing_model->add_skill($candidate_id, [
                            'skill_name' => $skill,
                            'proficiency_level' => 'Intermediate'
                        ]);
                    }
                }
            }
            
            // Handle resume upload
            if (!empty($_FILES['resume']['name'])) {
                $this->upload_resume($candidate_id);
            }
            
            $this->session->set_flashdata('success_msg', 'Candidate added successfully!');
            redirect('Candidate_sourcing/view/' . $candidate_id);
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to add candidate.');
            redirect('Candidate_sourcing/add');
        }
    }

    // View candidate profile
    public function view($candidate_id)
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Candidate Profile';
        
        $data['candidate'] = $this->Candidate_sourcing_model->get_candidate($candidate_id);
        
        if (!$data['candidate']) {
            show_404();
        }
        
        $data['pools'] = $this->Candidate_sourcing_model->get_all_pools();
        
        $this->load->view('Candidate_sourcing_view/view', $data);
    }

    // Upload resume
    private function upload_resume($candidate_id)
    {
        $config['upload_path'] = './uploads/resumes/';
        $config['allowed_types'] = 'pdf|doc|docx';
        $config['max_size'] = 5120; // 5MB
        $config['file_name'] = 'resume_' . $candidate_id . '_' . time();
        
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
        }
        
        $this->load->library('upload', $config);
        
        if ($this->upload->do_upload('resume')) {
            $upload_data = $this->upload->data();
            
            $this->Candidate_sourcing_model->add_document($candidate_id, [
                'document_type' => 'Resume',
                'file_name' => $upload_data['orig_name'],
                'file_path' => $upload_data['file_name'],
                'file_size' => $upload_data['file_size'],
                'uploaded_by' => $this->session->userdata('username')
            ]);
            
            return true;
        }
        
        return false;
    }

    // Talent Pools
    public function pools()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Talent Pools';
        
        $data['pools'] = $this->Candidate_sourcing_model->get_all_pools();
        
        $this->load->view('Candidate_sourcing_view/pools', $data);
    }

    // View pool
    public function view_pool($pool_id)
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Talent Pool';
        
        $data['pool'] = $this->db->where('pool_id', $pool_id)->get('talent_pools')->row();
        $data['members'] = $this->Candidate_sourcing_model->get_pool_members($pool_id);
        
        $this->load->view('Candidate_sourcing_view/view_pool', $data);
    }

    // Add to pool
    public function add_to_pool()
    {
        $pool_id = $this->input->post('pool_id');
        $candidate_id = $this->input->post('candidate_id');
        $username = $this->session->userdata('username');
        
        if ($this->Candidate_sourcing_model->add_to_pool($pool_id, $candidate_id, $username)) {
            $this->session->set_flashdata('success_msg', 'Candidate added to pool!');
        } else {
            $this->session->set_flashdata('error_msg', 'Candidate already in pool or error occurred.');
        }
        
        redirect('Candidate_sourcing/view/' . $candidate_id);
    }

    // Analytics
    public function analytics()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Sourcing Analytics';
        
        $data['stats'] = $this->Candidate_sourcing_model->get_statistics();
        
        $this->load->view('Candidate_sourcing_view/analytics', $data);
    }

    // Update status
    public function update_status()
    {
        $candidate_id = $this->input->post('candidate_id');
        $status = $this->input->post('status');
        
        if ($this->Candidate_sourcing_model->update_candidate($candidate_id, ['status' => $status])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

    // Delete candidate
    public function delete($candidate_id)
    {
        if ($this->Candidate_sourcing_model->delete_candidate($candidate_id)) {
            $this->session->set_flashdata('success_msg', 'Candidate deleted successfully!');
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to delete candidate.');
        }
        
        redirect('Candidate_sourcing');
    }

    // Create pool
    public function create_pool()
    {
        $username = $this->session->userdata('username');
        
        $pool_data = [
            'pool_name' => $this->input->post('pool_name'),
            'description' => $this->input->post('description'),
            'pool_type' => $this->input->post('pool_type'),
            'created_by' => $username,
            'is_active' => 1
        ];
        
        if ($this->Candidate_sourcing_model->create_pool($pool_data)) {
            $this->session->set_flashdata('success_msg', 'Talent pool created successfully!');
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to create pool.');
        }
        
        redirect('Candidate_sourcing/pools');
    }

    // Delete pool
    public function delete_pool($pool_id)
    {
        $this->db->where('pool_id', $pool_id);
        if ($this->db->delete('talent_pools')) {
            $this->session->set_flashdata('success_msg', 'Pool deleted successfully!');
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to delete pool.');
        }
        
        redirect('Candidate_sourcing/pools');
    }

    // Remove from pool
    public function remove_from_pool()
    {
        $pool_id = $this->input->post('pool_id');
        $candidate_id = $this->input->post('candidate_id');
        
        $this->db->where('pool_id', $pool_id);
        $this->db->where('candidate_id', $candidate_id);
        
        if ($this->db->delete('talent_pool_members')) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

    // Search candidates for adding to pool
    public function search_candidates()
    {
        $query = $this->input->get('q');
        $pool_id = $this->input->get('pool_id');
        
        // Get candidates not in this pool
        $this->db->select('sc.*');
        $this->db->from('sourced_candidates sc');
        $this->db->where("(sc.first_name LIKE '%$query%' OR sc.last_name LIKE '%$query%' OR sc.email LIKE '%$query%' OR sc.current_title LIKE '%$query%')");
        $this->db->where("sc.candidate_id NOT IN (SELECT candidate_id FROM talent_pool_members WHERE pool_id = $pool_id)");
        $this->db->limit(10);
        
        $candidates = $this->db->get()->result();
        
        if (!empty($candidates)) {
            foreach ($candidates as $candidate) {
                echo '<div class="border-bottom p-3 candidate-item" style="cursor: pointer;" onclick="addToPool(' . $candidate->candidate_id . ')">';
                echo '<strong>' . htmlspecialchars($candidate->first_name . ' ' . $candidate->last_name) . '</strong><br>';
                echo '<small class="text-muted">' . htmlspecialchars($candidate->current_title ?? 'N/A') . ' | ' . htmlspecialchars($candidate->email) . '</small>';
                echo '<button class="btn btn-sm btn-primary float-end"><i class="fas fa-plus"></i> Add</button>';
                echo '</div>';
            }
        } else {
            echo '<p class="text-center text-muted p-3">No candidates found</p>';
        }
    }
}
