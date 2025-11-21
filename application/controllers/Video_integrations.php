<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Video_integrations extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Video_integrations_model');
        $this->logged_in();
    }

    private function logged_in()
    {
        if (!$this->session->userdata('authenticated')) {
            redirect(LOGIN_URL);
        }
    }

    /**
     * Main video integrations dashboard
     */
    public function index()
    {
        $data['page_title'] = 'Video Platform Integrations';
        $data['uname'] = $this->session->userdata('username');
        
        // Get all configured platforms
        $data['zoom_config'] = $this->Video_integrations_model->get_platform_config('zoom');
        $data['teams_config'] = $this->Video_integrations_model->get_platform_config('teams');
        $data['meet_config'] = $this->Video_integrations_model->get_platform_config('meet');
        
        // Get usage statistics
        $data['stats'] = $this->Video_integrations_model->get_usage_stats() ?? array();
        
        // Check if tables exist
        if (!$data['zoom_config'] && !$data['teams_config'] && !$data['meet_config']) {
            $data['error_message'] = 'Database tables not found. Please run the migration script.';
        }
        
        $this->load->view('Video_integrations_view/index', $data);
    }

    /**
     * Configure Zoom integration
     */
    public function configure_zoom()
    {
        if ($this->input->post()) {
            $config_data = array(
                'platform' => 'zoom',
                'api_key' => $this->input->post('api_key'),
                'api_secret' => $this->input->post('api_secret'),
                'webhook_secret' => $this->input->post('webhook_secret'),
                'is_enabled' => $this->input->post('is_enabled') ? 1 : 0,
                'settings' => json_encode(array(
                    'default_duration' => $this->input->post('default_duration'),
                    'auto_recording' => $this->input->post('auto_recording'),
                    'waiting_room' => $this->input->post('waiting_room'),
                    'join_before_host' => $this->input->post('join_before_host')
                ))
            );
            
            if ($this->Video_integrations_model->save_config($config_data)) {
                $this->session->set_flashdata('success', 'Zoom configuration saved successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to save Zoom configuration');
            }
            
            redirect('Video_integrations');
        }
        
        $data['page_title'] = 'Configure Zoom';
        $data['config'] = $this->Video_integrations_model->get_platform_config('zoom');
        $this->load->view('Video_integrations_view/configure_zoom', $data);
    }

    /**
     * Configure Microsoft Teams integration
     */
    public function configure_teams()
    {
        if ($this->input->post()) {
            $config_data = array(
                'platform' => 'teams',
                'client_id' => $this->input->post('client_id'),
                'client_secret' => $this->input->post('client_secret'),
                'tenant_id' => $this->input->post('tenant_id'),
                'is_enabled' => $this->input->post('is_enabled') ? 1 : 0,
                'settings' => json_encode(array(
                    'default_duration' => $this->input->post('default_duration'),
                    'auto_recording' => $this->input->post('auto_recording'),
                    'lobby_enabled' => $this->input->post('lobby_enabled')
                ))
            );
            
            if ($this->Video_integrations_model->save_config($config_data)) {
                $this->session->set_flashdata('success', 'Microsoft Teams configuration saved successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to save Teams configuration');
            }
            
            redirect('Video_integrations');
        }
        
        $data['page_title'] = 'Configure Microsoft Teams';
        $data['config'] = $this->Video_integrations_model->get_platform_config('teams');
        $this->load->view('Video_integrations_view/configure_teams', $data);
    }

    /**
     * Configure Google Meet integration
     */
    public function configure_meet()
    {
        if ($this->input->post()) {
            $config_data = array(
                'platform' => 'meet',
                'client_id' => $this->input->post('client_id'),
                'client_secret' => $this->input->post('client_secret'),
                'api_key' => $this->input->post('api_key'),
                'is_enabled' => $this->input->post('is_enabled') ? 1 : 0,
                'settings' => json_encode(array(
                    'default_duration' => $this->input->post('default_duration'),
                    'auto_recording' => $this->input->post('auto_recording')
                ))
            );
            
            if ($this->Video_integrations_model->save_config($config_data)) {
                $this->session->set_flashdata('success', 'Google Meet configuration saved successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to save Google Meet configuration');
            }
            
            redirect('Video_integrations');
        }
        
        $data['page_title'] = 'Configure Google Meet';
        $data['config'] = $this->Video_integrations_model->get_platform_config('meet');
        $this->load->view('Video_integrations_view/configure_meet', $data);
    }

    /**
     * Create video meeting
     */
    public function create_meeting()
    {
        if ($this->input->post()) {
            $platform = $this->input->post('platform');
            $meeting_data = array(
                'title' => $this->input->post('title'),
                'start_time' => $this->input->post('start_time'),
                'duration' => $this->input->post('duration'),
                'attendees' => $this->input->post('attendees'),
                'interview_id' => $this->input->post('interview_id')
            );
            
            $result = $this->Video_integrations_model->create_meeting($platform, $meeting_data);
            
            if ($result['success']) {
                echo json_encode(array(
                    'success' => true,
                    'meeting_url' => $result['meeting_url'],
                    'meeting_id' => $result['meeting_id']
                ));
            } else {
                echo json_encode(array(
                    'success' => false,
                    'error' => $result['error']
                ));
            }
        }
    }

    /**
     * Test platform connection
     */
    public function test_connection($platform)
    {
        $result = $this->Video_integrations_model->test_connection($platform);
        echo json_encode($result);
    }
}
