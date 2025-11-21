<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Background_check extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Background_check_model');
        $this->logged_in();
    }

    private function logged_in()
    {
        if (!$this->session->userdata('authenticated')) {
            redirect(LOGIN_URL);
        }
    }

    /**
     * Main background check dashboard
     */
    public function index()
    {
        $data['page_title'] = 'Background Check Services';
        $data['uname'] = $this->session->userdata('username');
        
        // Get all configured services
        $data['checkr_config'] = $this->Background_check_model->get_service_config('checkr');
        $data['sterling_config'] = $this->Background_check_model->get_service_config('sterling');
        $data['accurate_config'] = $this->Background_check_model->get_service_config('accurate');
        
        // Get pending checks
        $data['pending_checks'] = $this->Background_check_model->get_checks_by_status('pending') ?? array();
        
        // Get completed checks
        $data['completed_checks'] = $this->Background_check_model->get_checks_by_status('completed', 10) ?? array();
        
        // Get statistics
        $data['stats'] = $this->Background_check_model->get_stats() ?? array();
        
        // Check if tables exist
        if (!$data['checkr_config'] && !$data['sterling_config'] && !$data['accurate_config']) {
            $data['error_message'] = 'Database tables not found. Please run the migration script.';
        }
        
        $this->load->view('Background_check_view/index', $data);
    }

    /**
     * Configure Checkr integration
     */
    public function configure_checkr()
    {
        if ($this->input->post()) {
            $config_data = array(
                'service' => 'checkr',
                'api_key' => $this->input->post('api_key'),
                'webhook_url' => base_url('Background_check/webhook/checkr'),
                'is_enabled' => $this->input->post('is_enabled') ? 1 : 0,
                'settings' => json_encode(array(
                    'package_type' => $this->input->post('package_type'),
                    'auto_initiate' => $this->input->post('auto_initiate'),
                    'check_types' => $this->input->post('check_types')
                ))
            );
            
            if ($this->Background_check_model->save_config($config_data)) {
                $this->session->set_flashdata('success', 'Checkr configuration saved successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to save Checkr configuration');
            }
            
            redirect('Background_check');
        }
        
        $data['page_title'] = 'Configure Checkr';
        $data['config'] = $this->Background_check_model->get_service_config('checkr');
        $this->load->view('Background_check_view/configure_checkr', $data);
    }

    /**
     * Configure Sterling integration
     */
    public function configure_sterling()
    {
        if ($this->input->post()) {
            $config_data = array(
                'service' => 'sterling',
                'api_key' => $this->input->post('api_key'),
                'client_id' => $this->input->post('client_id'),
                'is_enabled' => $this->input->post('is_enabled') ? 1 : 0,
                'settings' => json_encode(array(
                    'package_type' => $this->input->post('package_type'),
                    'auto_initiate' => $this->input->post('auto_initiate')
                ))
            );
            
            if ($this->Background_check_model->save_config($config_data)) {
                $this->session->set_flashdata('success', 'Sterling configuration saved successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to save Sterling configuration');
            }
            
            redirect('Background_check');
        }
        
        $data['page_title'] = 'Configure Sterling';
        $data['config'] = $this->Background_check_model->get_service_config('sterling');
        $this->load->view('Background_check_view/configure_sterling', $data);
    }

    /**
     * Initiate background check
     */
    public function initiate_check()
    {
        if ($this->input->post()) {
            $check_data = array(
                'candidate_id' => $this->input->post('candidate_id'),
                'service' => $this->input->post('service'),
                'package_type' => $this->input->post('package_type'),
                'candidate_info' => array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'email' => $this->input->post('email'),
                    'phone' => $this->input->post('phone'),
                    'dob' => $this->input->post('dob'),
                    'ssn' => $this->input->post('ssn'),
                    'address' => $this->input->post('address')
                )
            );
            
            $result = $this->Background_check_model->initiate_check($check_data);
            
            if ($result['success']) {
                $this->session->set_flashdata('success', 'Background check initiated successfully');
                echo json_encode(array(
                    'success' => true,
                    'check_id' => $result['check_id']
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
     * View check details
     */
    public function view_check($check_id)
    {
        $data['page_title'] = 'Background Check Details';
        $data['check'] = $this->Background_check_model->get_check_details($check_id);
        $data['candidate'] = $this->Background_check_model->get_candidate_info($data['check']->candidate_id);
        
        $this->load->view('Background_check_view/view_check', $data);
    }

    /**
     * Get check status
     */
    public function get_status($check_id)
    {
        $result = $this->Background_check_model->get_check_status($check_id);
        echo json_encode($result);
    }

    /**
     * Webhook handler for background check updates
     */
    public function webhook($service)
    {
        $payload = file_get_contents('php://input');
        $result = $this->Background_check_model->process_webhook($service, $payload);
        
        if ($result) {
            http_response_code(200);
            echo json_encode(array('status' => 'success'));
        } else {
            http_response_code(400);
            echo json_encode(array('status' => 'error'));
        }
    }

    /**
     * Download background check report
     */
    public function download_report($check_id)
    {
        $report = $this->Background_check_model->get_report($check_id);
        
        if ($report) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="background_check_' . $check_id . '.pdf"');
            echo $report;
        } else {
            show_404();
        }
    }
}
