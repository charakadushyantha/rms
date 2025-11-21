<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ats_integrations extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Ats_integrations_model');
        $this->logged_in();
    }

    private function logged_in()
    {
        if (!$this->session->userdata('authenticated')) {
            redirect(LOGIN_URL);
        }
    }

    /**
     * Main ATS integrations dashboard
     */
    public function index()
    {
        $data['page_title'] = 'ATS Integrations';
        $data['uname'] = $this->session->userdata('username');
        
        // Get all configured ATS platforms
        $data['greenhouse_config'] = $this->Ats_integrations_model->get_platform_config('greenhouse');
        $data['lever_config'] = $this->Ats_integrations_model->get_platform_config('lever');
        $data['workday_config'] = $this->Ats_integrations_model->get_platform_config('workday');
        $data['bamboohr_config'] = $this->Ats_integrations_model->get_platform_config('bamboohr');
        
        // Get sync statistics
        $data['sync_stats'] = $this->Ats_integrations_model->get_sync_stats() ?? array();
        
        // Get recent sync logs
        $data['recent_syncs'] = $this->Ats_integrations_model->get_recent_syncs(10) ?? array();
        
        // Check if tables exist
        if (!$data['greenhouse_config'] && !$data['lever_config'] && !$data['workday_config'] && !$data['bamboohr_config']) {
            $data['error_message'] = 'Database tables not found. Please run the migration script.';
        }
        
        $this->load->view('Ats_integrations_view/index', $data);
    }

    /**
     * Configure Greenhouse integration
     */
    public function configure_greenhouse()
    {
        if ($this->input->post()) {
            $config_data = array(
                'platform' => 'greenhouse',
                'api_key' => $this->input->post('api_key'),
                'webhook_secret' => $this->input->post('webhook_secret'),
                'is_enabled' => $this->input->post('is_enabled') ? 1 : 0,
                'settings' => json_encode(array(
                    'sync_direction' => $this->input->post('sync_direction'),
                    'auto_sync' => $this->input->post('auto_sync'),
                    'sync_interval' => $this->input->post('sync_interval'),
                    'sync_candidates' => $this->input->post('sync_candidates'),
                    'sync_jobs' => $this->input->post('sync_jobs'),
                    'sync_interviews' => $this->input->post('sync_interviews')
                ))
            );
            
            if ($this->Ats_integrations_model->save_config($config_data)) {
                $this->session->set_flashdata('success', 'Greenhouse configuration saved successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to save Greenhouse configuration');
            }
            
            redirect('Ats_integrations');
        }
        
        $data['page_title'] = 'Configure Greenhouse';
        $data['config'] = $this->Ats_integrations_model->get_platform_config('greenhouse');
        $this->load->view('Ats_integrations_view/configure_greenhouse', $data);
    }

    /**
     * Configure Lever integration
     */
    public function configure_lever()
    {
        if ($this->input->post()) {
            $config_data = array(
                'platform' => 'lever',
                'api_key' => $this->input->post('api_key'),
                'webhook_secret' => $this->input->post('webhook_secret'),
                'is_enabled' => $this->input->post('is_enabled') ? 1 : 0,
                'settings' => json_encode(array(
                    'sync_direction' => $this->input->post('sync_direction'),
                    'auto_sync' => $this->input->post('auto_sync'),
                    'sync_interval' => $this->input->post('sync_interval')
                ))
            );
            
            if ($this->Ats_integrations_model->save_config($config_data)) {
                $this->session->set_flashdata('success', 'Lever configuration saved successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to save Lever configuration');
            }
            
            redirect('Ats_integrations');
        }
        
        $data['page_title'] = 'Configure Lever';
        $data['config'] = $this->Ats_integrations_model->get_platform_config('lever');
        $this->load->view('Ats_integrations_view/configure_lever', $data);
    }

    /**
     * Configure Workday integration
     */
    public function configure_workday()
    {
        if ($this->input->post()) {
            $config_data = array(
                'platform' => 'workday',
                'tenant_name' => $this->input->post('tenant_name'),
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'is_enabled' => $this->input->post('is_enabled') ? 1 : 0,
                'settings' => json_encode(array(
                    'sync_direction' => $this->input->post('sync_direction'),
                    'auto_sync' => $this->input->post('auto_sync')
                ))
            );
            
            if ($this->Ats_integrations_model->save_config($config_data)) {
                $this->session->set_flashdata('success', 'Workday configuration saved successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to save Workday configuration');
            }
            
            redirect('Ats_integrations');
        }
        
        $data['page_title'] = 'Configure Workday';
        $data['config'] = $this->Ats_integrations_model->get_platform_config('workday');
        $this->load->view('Ats_integrations_view/configure_workday', $data);
    }

    /**
     * Configure BambooHR integration
     */
    public function configure_bamboohr()
    {
        if ($this->input->post()) {
            $config_data = array(
                'platform' => 'bamboohr',
                'api_key' => $this->input->post('api_key'),
                'subdomain' => $this->input->post('subdomain'),
                'is_enabled' => $this->input->post('is_enabled') ? 1 : 0,
                'settings' => json_encode(array(
                    'sync_direction' => $this->input->post('sync_direction'),
                    'auto_sync' => $this->input->post('auto_sync')
                ))
            );
            
            if ($this->Ats_integrations_model->save_config($config_data)) {
                $this->session->set_flashdata('success', 'BambooHR configuration saved successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to save BambooHR configuration');
            }
            
            redirect('Ats_integrations');
        }
        
        $data['page_title'] = 'Configure BambooHR';
        $data['config'] = $this->Ats_integrations_model->get_platform_config('bamboohr');
        $this->load->view('Ats_integrations_view/configure_bamboohr', $data);
    }

    /**
     * Manual sync trigger
     */
    public function sync_now($platform)
    {
        $result = $this->Ats_integrations_model->trigger_sync($platform);
        
        if ($result['success']) {
            $this->session->set_flashdata('success', 'Sync initiated successfully');
        } else {
            $this->session->set_flashdata('error', 'Sync failed: ' . $result['error']);
        }
        
        redirect('Ats_integrations');
    }

    /**
     * View sync logs
     */
    public function sync_logs()
    {
        $data['page_title'] = 'Sync Logs';
        $data['logs'] = $this->Ats_integrations_model->get_sync_logs(50);
        
        $this->load->view('Ats_integrations_view/sync_logs', $data);
    }

    /**
     * Export candidate to ATS
     */
    public function export_candidate()
    {
        if ($this->input->post()) {
            $export_data = array(
                'platform' => $this->input->post('platform'),
                'candidate_id' => $this->input->post('candidate_id'),
                'job_id' => $this->input->post('job_id')
            );
            
            $result = $this->Ats_integrations_model->export_candidate($export_data);
            
            echo json_encode($result);
        }
    }

    /**
     * Import candidate from ATS
     */
    public function import_candidate()
    {
        if ($this->input->post()) {
            $import_data = array(
                'platform' => $this->input->post('platform'),
                'external_id' => $this->input->post('external_id')
            );
            
            $result = $this->Ats_integrations_model->import_candidate($import_data);
            
            echo json_encode($result);
        }
    }

    /**
     * Webhook handler for ATS updates
     */
    public function webhook($platform)
    {
        $payload = file_get_contents('php://input');
        $result = $this->Ats_integrations_model->process_webhook($platform, $payload);
        
        if ($result) {
            http_response_code(200);
            echo json_encode(array('status' => 'success'));
        } else {
            http_response_code(400);
            echo json_encode(array('status' => 'error'));
        }
    }

    /**
     * Test platform connection
     */
    public function test_connection($platform)
    {
        $result = $this->Ats_integrations_model->test_connection($platform);
        echo json_encode($result);
    }

    /**
     * Field mapping configuration
     */
    public function field_mapping($platform)
    {
        if ($this->input->post()) {
            $mapping_data = $this->input->post('field_mapping');
            
            if ($this->Ats_integrations_model->save_field_mapping($platform, $mapping_data)) {
                $this->session->set_flashdata('success', 'Field mapping saved successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to save field mapping');
            }
            
            redirect('Ats_integrations/field_mapping/' . $platform);
        }
        
        $data['page_title'] = 'Field Mapping - ' . ucfirst($platform);
        $data['platform'] = $platform;
        $data['mapping'] = $this->Ats_integrations_model->get_field_mapping($platform);
        $data['local_fields'] = $this->Ats_integrations_model->get_local_fields();
        $data['remote_fields'] = $this->Ats_integrations_model->get_remote_fields($platform);
        
        $this->load->view('Ats_integrations_view/field_mapping', $data);
    }
}
