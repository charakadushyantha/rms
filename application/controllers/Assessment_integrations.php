<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assessment_integrations extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Assessment_integrations_model');
        $this->logged_in();
    }

    private function logged_in()
    {
        if (!$this->session->userdata('authenticated')) {
            redirect(LOGIN_URL);
        }
    }

    /**
     * Main assessment integrations dashboard
     */
    public function index()
    {
        $data['page_title'] = 'Assessment Tool Integrations';
        $data['uname'] = $this->session->userdata('username');
        
        // Get all configured platforms
        $data['hackerrank_config'] = $this->Assessment_integrations_model->get_platform_config('hackerrank');
        $data['codility_config'] = $this->Assessment_integrations_model->get_platform_config('codility');
        
        // Get usage statistics
        $data['stats'] = $this->Assessment_integrations_model->get_usage_stats() ?? array();
        
        // Get recent assessments
        $data['recent_assessments'] = $this->Assessment_integrations_model->get_recent_assessments(10) ?? array();
        
        // Check if tables exist
        if (!$data['hackerrank_config'] && !$data['codility_config']) {
            $data['error_message'] = 'Database tables not found. Please run the migration script.';
        }
        
        $this->load->view('Assessment_integrations_view/index', $data);
    }

    /**
     * Configure HackerRank integration
     */
    public function configure_hackerrank()
    {
        if ($this->input->post()) {
            $config_data = array(
                'platform' => 'hackerrank',
                'api_key' => $this->input->post('api_key'),
                'webhook_secret' => $this->input->post('webhook_secret'),
                'is_enabled' => $this->input->post('is_enabled') ? 1 : 0,
                'settings' => json_encode(array(
                    'default_duration' => $this->input->post('default_duration'),
                    'auto_send' => $this->input->post('auto_send'),
                    'difficulty_level' => $this->input->post('difficulty_level'),
                    'test_type' => $this->input->post('test_type')
                ))
            );
            
            if ($this->Assessment_integrations_model->save_config($config_data)) {
                $this->session->set_flashdata('success', 'HackerRank configuration saved successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to save HackerRank configuration');
            }
            
            redirect('Assessment_integrations');
        }
        
        $data['page_title'] = 'Configure HackerRank';
        $data['config'] = $this->Assessment_integrations_model->get_platform_config('hackerrank');
        $this->load->view('Assessment_integrations_view/configure_hackerrank', $data);
    }

    /**
     * Configure Codility integration
     */
    public function configure_codility()
    {
        if ($this->input->post()) {
            $config_data = array(
                'platform' => 'codility',
                'api_key' => $this->input->post('api_key'),
                'api_secret' => $this->input->post('api_secret'),
                'is_enabled' => $this->input->post('is_enabled') ? 1 : 0,
                'settings' => json_encode(array(
                    'default_duration' => $this->input->post('default_duration'),
                    'auto_send' => $this->input->post('auto_send'),
                    'test_type' => $this->input->post('test_type')
                ))
            );
            
            if ($this->Assessment_integrations_model->save_config($config_data)) {
                $this->session->set_flashdata('success', 'Codility configuration saved successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to save Codility configuration');
            }
            
            redirect('Assessment_integrations');
        }
        
        $data['page_title'] = 'Configure Codility';
        $data['config'] = $this->Assessment_integrations_model->get_platform_config('codility');
        $this->load->view('Assessment_integrations_view/configure_codility', $data);
    }

    /**
     * Send assessment to candidate
     */
    public function send_assessment()
    {
        if ($this->input->post()) {
            $platform = $this->input->post('platform');
            $assessment_data = array(
                'candidate_id' => $this->input->post('candidate_id'),
                'candidate_email' => $this->input->post('candidate_email'),
                'test_id' => $this->input->post('test_id'),
                'duration' => $this->input->post('duration'),
                'deadline' => $this->input->post('deadline')
            );
            
            $result = $this->Assessment_integrations_model->send_assessment($platform, $assessment_data);
            
            if ($result['success']) {
                echo json_encode(array(
                    'success' => true,
                    'assessment_url' => $result['assessment_url'],
                    'assessment_id' => $result['assessment_id']
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
     * Get assessment results
     */
    public function get_results($assessment_id)
    {
        $result = $this->Assessment_integrations_model->get_assessment_results($assessment_id);
        echo json_encode($result);
    }

    /**
     * Test platform connection
     */
    public function test_connection($platform)
    {
        $result = $this->Assessment_integrations_model->test_connection($platform);
        echo json_encode($result);
    }

    /**
     * Webhook handler for assessment results
     */
    public function webhook($platform)
    {
        $payload = file_get_contents('php://input');
        $result = $this->Assessment_integrations_model->process_webhook($platform, $payload);
        
        if ($result) {
            http_response_code(200);
            echo json_encode(array('status' => 'success'));
        } else {
            http_response_code(400);
            echo json_encode(array('status' => 'error'));
        }
    }
}
