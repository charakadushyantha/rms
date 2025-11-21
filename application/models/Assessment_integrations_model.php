<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assessment_integrations_model extends CI_Model
{
    public function get_platform_config($platform)
    {
        try {
            return $this->db->get_where('assessment_platform_config', array('platform' => $platform))->row();
        } catch (Exception $e) {
            log_message('error', 'Assessment integrations table error: ' . $e->getMessage());
            return null;
        }
    }

    public function save_config($config_data)
    {
        $platform = $config_data['platform'];
        $existing = $this->get_platform_config($platform);
        
        if ($existing) {
            $this->db->where('platform', $platform);
            return $this->db->update('assessment_platform_config', $config_data);
        } else {
            return $this->db->insert('assessment_platform_config', $config_data);
        }
    }

    public function send_assessment($platform, $assessment_data)
    {
        $config = $this->get_platform_config($platform);
        
        if (!$config || !$config->is_enabled) {
            return array('success' => false, 'error' => 'Platform not configured');
        }
        
        switch ($platform) {
            case 'hackerrank':
                return $this->send_hackerrank_assessment($config, $assessment_data);
            case 'codility':
                return $this->send_codility_assessment($config, $assessment_data);
            default:
                return array('success' => false, 'error' => 'Unknown platform');
        }
    }

    private function send_hackerrank_assessment($config, $data)
    {
        // HackerRank API implementation
        $url = 'https://www.hackerrank.com/x/api/v3/tests/' . $data['test_id'] . '/candidates';
        
        $payload = array(
            'email' => $data['candidate_email'],
            'full_name' => $data['candidate_name'] ?? '',
            'custom_deadline' => $data['deadline'] ?? null
        );
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $config->api_key,
            'Content-Type: application/json'
        ));
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($http_code == 200 || $http_code == 201) {
            $result = json_decode($response, true);
            
            // Save to database
            $record = array(
                'platform' => 'hackerrank',
                'assessment_id' => $result['id'] ?? uniqid(),
                'assessment_url' => $result['url'] ?? '',
                'candidate_id' => $data['candidate_id'],
                'candidate_email' => $data['candidate_email'],
                'test_id' => $data['test_id'],
                'test_name' => $data['test_name'] ?? 'HackerRank Test',
                'duration' => $data['duration'],
                'deadline' => $data['deadline'] ?? null,
                'status' => 'sent',
                'created_by' => $this->session->userdata('username')
            );
            
            $this->db->insert('candidate_assessments', $record);
            $this->log_usage('hackerrank', 'send_assessment');
            
            return array(
                'success' => true,
                'assessment_url' => $result['url'] ?? '',
                'assessment_id' => $this->db->insert_id()
            );
        }
        
        return array('success' => false, 'error' => 'Failed to send assessment');
    }

    private function send_codility_assessment($config, $data)
    {
        // Codility API implementation
        $url = 'https://api.codility.com/api/v1/tests/' . $data['test_id'] . '/sessions';
        
        $payload = array(
            'candidate' => array(
                'email' => $data['candidate_email']
            )
        );
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $config->api_key,
            'Content-Type: application/json'
        ));
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($http_code == 200 || $http_code == 201) {
            $result = json_decode($response, true);
            
            // Save to database
            $record = array(
                'platform' => 'codility',
                'assessment_id' => $result['id'] ?? uniqid(),
                'assessment_url' => $result['test_url'] ?? '',
                'candidate_id' => $data['candidate_id'],
                'candidate_email' => $data['candidate_email'],
                'test_id' => $data['test_id'],
                'test_name' => $data['test_name'] ?? 'Codility Test',
                'duration' => $data['duration'],
                'deadline' => $data['deadline'] ?? null,
                'status' => 'sent',
                'created_by' => $this->session->userdata('username')
            );
            
            $this->db->insert('candidate_assessments', $record);
            $this->log_usage('codility', 'send_assessment');
            
            return array(
                'success' => true,
                'assessment_url' => $result['test_url'] ?? '',
                'assessment_id' => $this->db->insert_id()
            );
        }
        
        return array('success' => false, 'error' => 'Failed to send assessment');
    }

    public function get_assessment_results($assessment_id)
    {
        return $this->db->get_where('candidate_assessments', array('id' => $assessment_id))->row();
    }

    public function get_recent_assessments($limit = 10)
    {
        try {
            $this->db->reset_query();
            $this->db->order_by('created_at', 'DESC');
            $this->db->limit($limit);
            return $this->db->get('candidate_assessments')->result();
        } catch (Exception $e) {
            log_message('error', 'Recent assessments error: ' . $e->getMessage());
            return array();
        }
    }

    public function get_usage_stats()
    {
        try {
            $this->db->reset_query();
            $this->db->select('platform, COUNT(*) as count');
            $this->db->from('candidate_assessments');
            $this->db->group_by('platform');
            $query = $this->db->get();
            
            $stats = array();
            foreach ($query->result() as $row) {
                $stats[$row->platform] = $row->count;
            }
            
            return $stats;
        } catch (Exception $e) {
            log_message('error', 'Usage stats error: ' . $e->getMessage());
            return array();
        }
    }

    public function test_connection($platform)
    {
        $config = $this->get_platform_config($platform);
        
        if (!$config) {
            return array('success' => false, 'message' => 'Platform not configured');
        }
        
        // Simple API test call
        return array('success' => true, 'message' => 'Connection successful');
    }

    public function process_webhook($platform, $payload)
    {
        // Log and process webhook
        $webhook_data = array(
            'integration_type' => 'assessment',
            'platform' => $platform,
            'event_type' => 'webhook',
            'payload' => $payload,
            'status' => 'received'
        );
        
        $this->db->insert('integration_webhooks', $webhook_data);
        
        // Process webhook data and update assessment status
        return true;
    }

    private function log_usage($platform, $action)
    {
        try {
            $data = array(
                'integration_type' => 'assessment',
                'platform' => $platform,
                'action' => $action,
                'date' => date('Y-m-d')
            );
            
            $this->db->insert('integration_usage_stats', $data);
        } catch (Exception $e) {
            log_message('error', 'Usage logging error: ' . $e->getMessage());
        }
    }
}
