<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Referral extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->logged_in();
        $this->load->model('Referral_model');
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
        $data['page_title'] = 'Referral Program';
        
        // Get user info - use a default user_id if not in session
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            // If no user_id in session, use username or default to 1
            $user_id = 1; // Default admin user
        }
        
        // Get statistics
        $data['stats'] = $this->Referral_model->get_statistics();
        $data['user_stats'] = $this->Referral_model->get_statistics($user_id);
        
        // Get recent referrals
        $data['recent_referrals'] = $this->Referral_model->get_all_referrals(['limit' => 10]);
        
        // Get top referrers
        $data['top_referrers'] = $this->Referral_model->get_top_referrers(5);
        
        // Get user's referral code
        $data['my_referral_code'] = $this->Referral_model->get_user_referral_code(
            $user_id,
            $data['uname']
        );
        
        // Get program config
        $data['config'] = $this->Referral_model->get_config();
        
        $this->load->view('Referral_view/index', $data);
    }

    // Submit new referral
    public function submit()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Submit Referral';
        
        // Get job positions for dropdown
        if ($this->db->table_exists('job_positions')) {
            $data['positions'] = $this->db->get('job_positions')->result();
        } else {
            $data['positions'] = [];
        }
        
        $this->load->view('Referral_view/submit', $data);
    }

    // Process referral submission
    public function save()
    {
        $user_id = $this->session->userdata('user_id');
        $username = $this->session->userdata('username');
        
        // Get user details
        $user = $this->db->where('u_id', $user_id)->get('users')->row();
        
        $referral_data = [
            'referrer_id' => $user_id,
            'referrer_name' => $user->u_username ?? $username,
            'referrer_email' => $user->u_email ?? '',
            'candidate_name' => $this->input->post('candidate_name'),
            'candidate_email' => $this->input->post('candidate_email'),
            'candidate_phone' => $this->input->post('candidate_phone'),
            'position_id' => $this->input->post('position_id'),
            'position_name' => $this->input->post('position_name'),
            'referral_date' => date('Y-m-d'),
            'referral_status' => 'Submitted',
            'candidate_status' => 'New',
            'notes' => $this->input->post('notes'),
            'created_by' => $username
        ];
        
        // Handle resume upload
        if (!empty($_FILES['candidate_resume']['name'])) {
            $config['upload_path'] = './uploads/referrals/';
            $config['allowed_types'] = 'pdf|doc|docx';
            $config['max_size'] = 5120; // 5MB
            $config['file_name'] = time() . '_' . $_FILES['candidate_resume']['name'];
            
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
            }
            
            $this->load->library('upload', $config);
            
            if ($this->upload->do_upload('candidate_resume')) {
                $upload_data = $this->upload->data();
                $referral_data['candidate_resume'] = $upload_data['file_name'];
            }
        }
        
        // Get default bonus amount
        $default_bonus = $this->Referral_model->get_config('default_bonus_amount');
        $referral_data['bonus_amount'] = $default_bonus ?? 1000;
        
        if ($this->Referral_model->create_referral($referral_data)) {
            $this->session->set_flashdata('success_msg', 'Referral submitted successfully!');
            redirect('Referral/my_referrals');
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to submit referral.');
            redirect('Referral/submit');
        }
    }

    // My referrals
    public function my_referrals()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'My Referrals';
        
        $user_id = $this->session->userdata('user_id');
        $data['referrals'] = $this->Referral_model->get_user_referrals($user_id);
        $data['stats'] = $this->Referral_model->get_statistics($user_id);
        
        $this->load->view('Referral_view/my_referrals', $data);
    }

    // View referral details
    public function view($referral_id)
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Referral Details';
        
        $data['referral'] = $this->Referral_model->get_referral($referral_id);
        
        if (!$data['referral']) {
            show_404();
        }
        
        $this->load->view('Referral_view/view', $data);
    }

    // Admin: All referrals
    public function manage()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Manage Referrals';
        
        $filters = [];
        if ($this->input->get('status')) {
            $filters['status'] = $this->input->get('status');
        }
        
        $data['referrals'] = $this->Referral_model->get_all_referrals($filters);
        $data['stats'] = $this->Referral_model->get_statistics();
        
        $this->load->view('Referral_view/manage', $data);
    }

    // Update referral status
    public function update_status()
    {
        $referral_id = $this->input->post('referral_id');
        $status = $this->input->post('status');
        
        $update_data = ['referral_status' => $status];
        
        // If hired, set hired date
        if ($status == 'Hired') {
            $update_data['hired_date'] = date('Y-m-d');
            $update_data['bonus_status'] = 'Approved';
        }
        
        if ($this->Referral_model->update_referral($referral_id, $update_data)) {
            $this->session->set_flashdata('success_msg', 'Status updated successfully!');
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to update status.');
        }
        
        redirect('Referral/manage');
    }

    // Analytics
    public function analytics()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Referral Analytics';
        
        $data['stats'] = $this->Referral_model->get_statistics();
        $data['top_referrers'] = $this->Referral_model->get_top_referrers(10);
        
        // Monthly trends - check if table exists first
        if ($this->db->table_exists('referrals')) {
            $data['monthly_trends'] = $this->db->query("
                SELECT 
                    DATE_FORMAT(referral_date, '%Y-%m') as month,
                    COUNT(*) as total_referrals,
                    SUM(CASE WHEN referral_status = 'Hired' THEN 1 ELSE 0 END) as hired_count
                FROM referrals
                WHERE referral_date >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
                GROUP BY DATE_FORMAT(referral_date, '%Y-%m')
                ORDER BY month
            ")->result();
        } else {
            // Return sample data if table doesn't exist
            $data['monthly_trends'] = [];
        }
        
        $this->load->view('Referral_view/analytics', $data);
    }

    // Program settings (Admin only)
    public function settings()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Referral Program Settings';
        
        $data['config'] = $this->Referral_model->get_config();
        $data['bonus_tiers'] = $this->db->get('referral_bonuses')->result();
        
        $this->load->view('Referral_view/settings', $data);
    }

    // Save settings
    public function save_settings()
    {
        $configs = $this->input->post('config');
        
        foreach ($configs as $key => $value) {
            $this->Referral_model->update_config($key, $value);
        }
        
        $this->session->set_flashdata('success_msg', 'Settings updated successfully!');
        redirect('Referral/settings');
    }

    // Delete referral
    public function delete($referral_id)
    {
        if ($this->Referral_model->delete_referral($referral_id)) {
            $this->session->set_flashdata('success_msg', 'Referral deleted successfully!');
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to delete referral.');
        }
        
        redirect('Referral/manage');
    }
}
