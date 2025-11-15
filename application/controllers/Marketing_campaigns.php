<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marketing_campaigns extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->logged_in();
        $this->load->model('Marketing_campaign_model');
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
        $data['page_title'] = 'Marketing Campaigns';
        
        $filters = [
            'status' => $this->input->get('status'),
            'type' => $this->input->get('type')
        ];
        
        $data['campaigns'] = $this->Marketing_campaign_model->get_all_campaigns($filters);
        $data['stats'] = $this->Marketing_campaign_model->get_statistics();
        
        $this->load->view('Marketing_campaigns_view/index', $data);
    }

    // Create campaign
    public function create()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Create Campaign';
        
        $this->load->view('Marketing_campaigns_view/create', $data);
    }

    // Save campaign
    public function save()
    {
        $username = $this->session->userdata('username');
        
        $campaign_data = [
            'campaign_name' => $this->input->post('campaign_name'),
            'campaign_type' => $this->input->post('campaign_type'),
            'description' => $this->input->post('description'),
            'start_date' => $this->input->post('start_date'),
            'end_date' => $this->input->post('end_date'),
            'budget' => $this->input->post('budget'),
            'target_audience' => $this->input->post('target_audience'),
            'goals' => $this->input->post('goals'),
            'status' => 'Draft',
            'created_by' => $username
        ];
        
        $campaign_id = $this->Marketing_campaign_model->create_campaign($campaign_data);
        
        if ($campaign_id) {
            $this->session->set_flashdata('success_msg', 'Campaign created successfully!');
            redirect('Marketing_campaigns/view/' . $campaign_id);
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to create campaign.');
            redirect('Marketing_campaigns/create');
        }
    }

    // View campaign
    public function view($campaign_id)
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Campaign Details';
        
        $data['campaign'] = $this->Marketing_campaign_model->get_campaign($campaign_id);
        $data['email_campaigns'] = $this->Marketing_campaign_model->get_email_campaigns($campaign_id);
        $data['social_posts'] = $this->Marketing_campaign_model->get_social_posts($campaign_id);
        $data['ad_campaigns'] = $this->Marketing_campaign_model->get_ad_campaigns($campaign_id);
        $data['performance'] = $this->Marketing_campaign_model->get_campaign_performance($campaign_id);
        
        $this->load->view('Marketing_campaigns_view/view', $data);
    }

    // Email campaigns
    public function email_campaigns()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Email Campaigns';
        
        $data['templates'] = $this->Marketing_campaign_model->get_all_templates();
        
        $this->load->view('Marketing_campaigns_view/email_campaigns', $data);
    }

    // Social media
    public function social_media()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Social Media Marketing';
        
        $this->load->view('Marketing_campaigns_view/social_media', $data);
    }

    // Analytics
    public function analytics()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Campaign Analytics';
        
        $data['stats'] = $this->Marketing_campaign_model->get_statistics();
        $data['campaigns'] = $this->Marketing_campaign_model->get_all_campaigns();
        
        $this->load->view('Marketing_campaigns_view/analytics', $data);
    }

    // Update status
    public function update_status()
    {
        $campaign_id = $this->input->post('campaign_id');
        $status = $this->input->post('status');
        
        if ($this->Marketing_campaign_model->update_campaign($campaign_id, ['status' => $status])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

    // Delete campaign
    public function delete($campaign_id)
    {
        if ($this->Marketing_campaign_model->delete_campaign($campaign_id)) {
            $this->session->set_flashdata('success_msg', 'Campaign deleted successfully!');
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to delete campaign.');
        }
        
        redirect('Marketing_campaigns');
    }
}
