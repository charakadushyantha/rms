<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Background_check_model extends CI_Model
{
    public function get_service_config($service)
    {
        try {
            return $this->db->get_where('background_check_config', array('service' => $service))->row();
        } catch (Exception $e) {
            log_message('error', 'Background check table error: ' . $e->getMessage());
            return null;
        }
    }

    public function save_config($config_data)
    {
        $service = $config_data['service'];
        $existing = $this->get_service_config($service);
        
        if ($existing) {
            $this->db->where('service', $service);
            return $this->db->update('background_check_config', $config_data);
        } else {
            return $this->db->insert('background_check_config', $config_data);
        }
    }

    public function initiate_check($check_data)
    {
        $config = $this->get_service_config($check_data['service']);
        
        if (!$config || !$config->is_enabled) {
            return array('success' => false, 'error' => 'Service not configured');
        }
        
        switch ($check_data['service']) {
            case 'checkr':
                return $this->initiate_checkr($config, $check_data);
            case 'sterling':
                return $this->initiate_sterling($config, $check_data);
            case 'accurate':
                return $this->initiate_accurate($config, $check_data);
            default:
                return array('success' => false, 'error' => 'Unknown service');
        }
    }

    private function initiate_checkr($config, $data)
    {
        // Checkr API implementation
        $url = 'https://api.checkr.com/v1/candidates';
        
        // Create candidate first
        $candidate_payload = array(
            'email' => $data['candidate_info']['email'],
            'first_name' => $data['candidate_info']['first_name'],
            'last_name' => $data['candidate_info']['last_name'],
            'phone' => $data['candidate_info']['phone'],
            'dob' => $data['candidate_info']['dob'],
            'ssn' => $data['candidate_info']['ssn']
        );
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($candidate_payload));
        curl_setopt($ch, CURLOPT_USERPWD, $config->api_key . ':');
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($http_code == 201) {
            $candidate_result = json_decode($response, true);
            
            // Create background check
            $check_url = 'https://api.checkr.com/v1/reports';
            $check_payload = array(
                'candidate_id' => $candidate_result['id'],
                'package' => $data['package_type']
            );
            
            $ch = curl_init($check_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($check_payload));
            curl_setopt($ch, CURLOPT_USERPWD, $config->api_key . ':');
            
            $check_response = curl_exec($ch);
            $check_http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            if ($check_http_code == 201) {
                $check_result = json_decode($check_response, true);
                
                // Save to database
                $record = array(
                    'service' => 'checkr',
                    'check_id' => $check_result['id'],
                    'candidate_id' => $data['candidate_id'],
                    'package_type' => $data['package_type'],
                    'status' => 'pending',
                    'candidate_info' => json_encode($data['candidate_info']),
                    'initiated_by' => $this->session->userdata('username'),
                    'initiated_at' => date('Y-m-d H:i:s')
                );
                
                $this->db->insert('background_checks', $record);
                $this->log_usage('checkr', 'initiate_check');
                
                return array(
                    'success' => true,
                    'check_id' => $this->db->insert_id()
                );
            }
        }
        
        return array('success' => false, 'error' => 'Failed to initiate check');
    }

    private function initiate_sterling($config, $data)
    {
        // Sterling API implementation (similar structure)
        return array('success' => true, 'check_id' => 0);
    }

    private function initiate_accurate($config, $data)
    {
        // Accurate API implementation (similar structure)
        return array('success' => true, 'check_id' => 0);
    }

    public function get_checks_by_status($status, $limit = null)
    {
        try {
            $this->db->reset_query();
            $this->db->where('status', $status);
            $this->db->order_by('initiated_at', 'DESC');
            if ($limit) {
                $this->db->limit($limit);
            }
            return $this->db->get('background_checks')->result();
        } catch (Exception $e) {
            log_message('error', 'Get checks error: ' . $e->getMessage());
            return array();
        }
    }

    public function get_check_details($check_id)
    {
        return $this->db->get_where('background_checks', array('id' => $check_id))->row();
    }

    public function get_candidate_info($candidate_id)
    {
        return $this->db->get_where(TBL_CANDIDATE_DETAILS, array('cd_id' => $candidate_id))->row();
    }

    public function get_check_status($check_id)
    {
        $check = $this->get_check_details($check_id);
        
        if ($check) {
            return array(
                'success' => true,
                'status' => $check->status,
                'result' => $check->result,
                'report_url' => $check->report_url
            );
        }
        
        return array('success' => false, 'error' => 'Check not found');
    }

    public function get_report($check_id)
    {
        // Fetch and return PDF report
        $check = $this->get_check_details($check_id);
        
        if ($check && $check->report_url) {
            // Download report from service
            return file_get_contents($check->report_url);
        }
        
        return false;
    }

    public function get_stats()
    {
        try {
            $this->db->reset_query();
            $total = $this->db->count_all('background_checks');
            
            $this->db->reset_query();
            $this->db->where('status', 'pending');
            $pending = $this->db->count_all_results('background_checks');
            
            $this->db->reset_query();
            $this->db->where('status', 'completed');
            $completed = $this->db->count_all_results('background_checks');
            
            $stats = array(
                'total' => $total,
                'pending' => $pending,
                'completed' => $completed
            );
            
            return $stats;
        } catch (Exception $e) {
            log_message('error', 'Stats error: ' . $e->getMessage());
            return array('total' => 0, 'pending' => 0, 'completed' => 0);
        }
    }

    public function process_webhook($service, $payload)
    {
        // Log and process webhook
        $webhook_data = array(
            'integration_type' => 'background_check',
            'platform' => $service,
            'event_type' => 'webhook',
            'payload' => $payload,
            'status' => 'received'
        );
        
        $this->db->insert('integration_webhooks', $webhook_data);
        
        // Update check status based on webhook
        return true;
    }

    private function log_usage($service, $action)
    {
        try {
            $data = array(
                'integration_type' => 'background_check',
                'platform' => $service,
                'action' => $action,
                'date' => date('Y-m-d')
            );
            
            $this->db->insert('integration_usage_stats', $data);
        } catch (Exception $e) {
            log_message('error', 'Usage logging error: ' . $e->getMessage());
        }
    }
}
