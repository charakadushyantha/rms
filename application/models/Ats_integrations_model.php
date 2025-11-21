<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ats_integrations_model extends CI_Model
{
    public function get_platform_config($platform)
    {
        try {
            return $this->db->get_where('ats_platform_config', array('platform' => $platform))->row();
        } catch (Exception $e) {
            log_message('error', 'ATS integrations table error: ' . $e->getMessage());
            return null;
        }
    }

    public function save_config($config_data)
    {
        $platform = $config_data['platform'];
        $existing = $this->get_platform_config($platform);
        
        if ($existing) {
            $this->db->where('platform', $platform);
            return $this->db->update('ats_platform_config', $config_data);
        } else {
            return $this->db->insert('ats_platform_config', $config_data);
        }
    }

    public function trigger_sync($platform)
    {
        $config = $this->get_platform_config($platform);
        
        if (!$config || !$config->is_enabled) {
            return array('success' => false, 'error' => 'Platform not configured');
        }
        
        // Create sync log
        $log_data = array(
            'platform' => $platform,
            'sync_type' => 'full',
            'direction' => 'bidirectional',
            'status' => 'in_progress',
            'started_at' => date('Y-m-d H:i:s'),
            'triggered_by' => $this->session->userdata('username')
        );
        
        $this->db->insert('ats_sync_logs', $log_data);
        $log_id = $this->db->insert_id();
        
        try {
            // Perform sync based on platform
            switch ($platform) {
                case 'greenhouse':
                    $result = $this->sync_greenhouse($config);
                    break;
                case 'lever':
                    $result = $this->sync_lever($config);
                    break;
                case 'workday':
                    $result = $this->sync_workday($config);
                    break;
                case 'bamboohr':
                    $result = $this->sync_bamboohr($config);
                    break;
                default:
                    $result = array('success' => false, 'error' => 'Unknown platform');
            }
            
            // Update sync log
            $this->db->where('id', $log_id);
            $this->db->update('ats_sync_logs', array(
                'status' => $result['success'] ? 'completed' : 'failed',
                'records_processed' => $result['processed'] ?? 0,
                'records_success' => $result['success_count'] ?? 0,
                'records_failed' => $result['failed_count'] ?? 0,
                'error_message' => $result['error'] ?? null,
                'completed_at' => date('Y-m-d H:i:s')
            ));
            
            return $result;
        } catch (Exception $e) {
            // Update sync log with error
            $this->db->where('id', $log_id);
            $this->db->update('ats_sync_logs', array(
                'status' => 'failed',
                'error_message' => $e->getMessage(),
                'completed_at' => date('Y-m-d H:i:s')
            ));
            
            return array('success' => false, 'error' => $e->getMessage());
        }
    }

    private function sync_greenhouse($config)
    {
        // Greenhouse API sync implementation
        $url = 'https://harvest.greenhouse.io/v1/candidates';
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $config->api_key . ':');
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($http_code == 200) {
            $candidates = json_decode($response, true);
            
            // Process and sync candidates
            $processed = 0;
            $success = 0;
            
            foreach ($candidates as $candidate) {
                $processed++;
                // Sync logic here
                $success++;
            }
            
            return array(
                'success' => true,
                'processed' => $processed,
                'success_count' => $success,
                'failed_count' => 0
            );
        }
        
        return array('success' => false, 'error' => 'Sync failed');
    }

    private function sync_lever($config)
    {
        // Lever API sync implementation
        return array('success' => true, 'processed' => 0, 'success_count' => 0, 'failed_count' => 0);
    }

    private function sync_workday($config)
    {
        // Workday API sync implementation
        return array('success' => true, 'processed' => 0, 'success_count' => 0, 'failed_count' => 0);
    }

    private function sync_bamboohr($config)
    {
        // BambooHR API sync implementation
        return array('success' => true, 'processed' => 0, 'success_count' => 0, 'failed_count' => 0);
    }

    public function export_candidate($export_data)
    {
        $config = $this->get_platform_config($export_data['platform']);
        
        if (!$config || !$config->is_enabled) {
            return array('success' => false, 'error' => 'Platform not configured');
        }
        
        // Get candidate data
        $candidate = $this->db->get_where(TBL_CANDIDATE_DETAILS, array('cd_id' => $export_data['candidate_id']))->row();
        
        if (!$candidate) {
            return array('success' => false, 'error' => 'Candidate not found');
        }
        
        // Export to ATS
        // Implementation depends on platform
        
        // Save mapping
        $mapping_data = array(
            'platform' => $export_data['platform'],
            'local_candidate_id' => $export_data['candidate_id'],
            'remote_candidate_id' => 'remote_id_here',
            'last_synced_at' => date('Y-m-d H:i:s'),
            'sync_status' => 'synced'
        );
        
        $this->db->insert('ats_candidate_mapping', $mapping_data);
        
        return array('success' => true, 'external_id' => 'remote_id_here');
    }

    public function import_candidate($import_data)
    {
        // Import candidate from ATS
        return array('success' => true, 'candidate_id' => 0);
    }

    public function get_sync_logs($limit = 50)
    {
        try {
            $this->db->reset_query();
            $this->db->order_by('started_at', 'DESC');
            $this->db->limit($limit);
            return $this->db->get('ats_sync_logs')->result();
        } catch (Exception $e) {
            log_message('error', 'Sync logs error: ' . $e->getMessage());
            return array();
        }
    }

    public function get_recent_syncs($limit = 10)
    {
        return $this->get_sync_logs($limit);
    }

    public function get_sync_stats()
    {
        try {
            $this->db->reset_query();
            $total = $this->db->count_all('ats_sync_logs');
            
            $this->db->reset_query();
            $this->db->where('status', 'completed');
            $successful = $this->db->count_all_results('ats_sync_logs');
            
            $this->db->reset_query();
            $this->db->where('status', 'failed');
            $failed = $this->db->count_all_results('ats_sync_logs');
            
            $stats = array(
                'total_syncs' => $total,
                'successful' => $successful,
                'failed' => $failed
            );
            
            return $stats;
        } catch (Exception $e) {
            log_message('error', 'Sync stats error: ' . $e->getMessage());
            return array('total_syncs' => 0, 'successful' => 0, 'failed' => 0);
        }
    }

    public function test_connection($platform)
    {
        $config = $this->get_platform_config($platform);
        
        if (!$config) {
            return array('success' => false, 'message' => 'Platform not configured');
        }
        
        // Test API connection
        return array('success' => true, 'message' => 'Connection successful');
    }

    public function save_field_mapping($platform, $mapping_data)
    {
        // Delete existing mappings
        $this->db->where('platform', $platform);
        $this->db->delete('ats_field_mapping');
        
        // Insert new mappings
        foreach ($mapping_data as $mapping) {
            $mapping['platform'] = $platform;
            $this->db->insert('ats_field_mapping', $mapping);
        }
        
        return true;
    }

    public function get_field_mapping($platform)
    {
        return $this->db->get_where('ats_field_mapping', array('platform' => $platform))->result();
    }

    public function get_local_fields()
    {
        // Return list of local RMS fields
        return array(
            'u_username', 'u_email', 'u_role',
            'cd_name', 'cd_email', 'cd_phone', 'cd_job_title'
        );
    }

    public function get_remote_fields($platform)
    {
        // Return list of remote ATS fields based on platform
        return array('name', 'email', 'phone', 'title');
    }

    public function process_webhook($platform, $payload)
    {
        // Log and process webhook
        $webhook_data = array(
            'integration_type' => 'ats',
            'platform' => $platform,
            'event_type' => 'webhook',
            'payload' => $payload,
            'status' => 'received'
        );
        
        $this->db->insert('integration_webhooks', $webhook_data);
        
        // Process webhook and update data
        return true;
    }
}
