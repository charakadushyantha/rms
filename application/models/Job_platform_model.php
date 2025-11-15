<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Job_platform_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // Get all platforms
    public function get_all_platforms()
    {
        $this->db->select('jp.*, jpc.is_enabled as credentials_enabled, jpc.last_sync');
        $this->db->from('job_platforms jp');
        $this->db->join('job_platform_credentials jpc', 'jp.platform_id = jpc.platform_id', 'left');
        $this->db->order_by('jp.platform_name');
        return $this->db->get()->result();
    }

    // Get active platforms only
    public function get_active_platforms()
    {
        $this->db->where('is_active', 1);
        $this->db->order_by('platform_name');
        return $this->db->get('job_platforms')->result();
    }

    // Get enabled platforms (with valid credentials)
    public function get_enabled_platforms()
    {
        $this->db->select('jp.*, jpc.*');
        $this->db->from('job_platforms jp');
        $this->db->join('job_platform_credentials jpc', 'jp.platform_id = jpc.platform_id');
        $this->db->where('jp.is_active', 1);
        $this->db->where('jpc.is_enabled', 1);
        return $this->db->get()->result();
    }

    // Get single platform
    public function get_platform($platform_id)
    {
        $this->db->where('platform_id', $platform_id);
        return $this->db->get('job_platforms')->row();
    }

    // Get platform by key
    public function get_platform_by_key($platform_key)
    {
        $this->db->where('platform_key', $platform_key);
        return $this->db->get('job_platforms')->row();
    }

    // Get platform credentials
    public function get_credentials($platform_id)
    {
        $this->db->where('platform_id', $platform_id);
        return $this->db->get('job_platform_credentials')->row();
    }

    // Save platform credentials
    public function save_credentials($data)
    {
        // Check if credentials exist
        $existing = $this->get_credentials($data['platform_id']);
        
        if ($existing) {
            // Update existing credentials
            $this->db->where('platform_id', $data['platform_id']);
            return $this->db->update('job_platform_credentials', $data);
        } else {
            // Insert new credentials
            return $this->db->insert('job_platform_credentials', $data);
        }
    }

    // Update platform status
    public function update_platform_status($platform_id, $is_active)
    {
        $this->db->where('platform_id', $platform_id);
        return $this->db->update('job_platforms', ['is_active' => $is_active]);
    }

    // Test platform connection
    public function test_platform_connection($platform_id)
    {
        $platform = $this->get_platform($platform_id);
        $credentials = $this->get_credentials($platform_id);
        
        if (!$credentials || !$credentials->is_enabled) {
            return ['success' => false, 'message' => 'No credentials configured'];
        }
        
        // Load integration library and test connection
        $CI = &get_instance();
        $library_name = ucfirst($platform->platform_key) . '_integration';
        
        try {
            $CI->load->library($library_name);
            return $CI->$library_name->test_connection($credentials);
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    // Update last sync time
    public function update_last_sync($platform_id)
    {
        $this->db->where('platform_id', $platform_id);
        return $this->db->update('job_platform_credentials', ['last_sync' => date('Y-m-d H:i:s')]);
    }

    // Get platform statistics
    public function get_platform_stats($platform_id)
    {
        $stats = [];
        
        // Total jobs posted
        $this->db->where('platform_id', $platform_id);
        $stats['total_posts'] = $this->db->count_all_results('job_posting_history');
        
        // Active jobs
        $this->db->where('platform_id', $platform_id);
        $this->db->where('status', 'Posted');
        $stats['active_posts'] = $this->db->count_all_results('job_posting_history');
        
        // Total views, clicks, applications
        $this->db->select('SUM(views_count) as total_views, SUM(clicks_count) as total_clicks, SUM(applications_count) as total_applications');
        $this->db->where('platform_id', $platform_id);
        $result = $this->db->get('job_posting_history')->row();
        
        $stats['total_views'] = $result->total_views ?? 0;
        $stats['total_clicks'] = $result->total_clicks ?? 0;
        $stats['total_applications'] = $result->total_applications ?? 0;
        
        return $stats;
    }
}
