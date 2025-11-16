<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Job_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get active jobs
     */
    public function get_active_jobs($limit = null) {
        // Check if jobs table exists
        if (!$this->table_exists('jobs')) {
            return []; // Return empty array if table doesn't exist
        }
        
        $this->db->where('status', 'active');
        $this->db->or_where('status', 'open');
        $this->db->order_by('created_at', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit);
        }
        
        $query = $this->db->get('jobs');
        return $query->result_array();
    }
    
    /**
     * Check if table exists
     */
    private function table_exists($table) {
        $query = $this->db->query("SHOW TABLES LIKE '$table'");
        return $query->num_rows() > 0;
    }

    /**
     * Find job by title
     */
    public function find_by_title($title) {
        if (!$this->table_exists('jobs')) {
            return null;
        }
        
        $this->db->like('title', $title);
        $this->db->where('status', 'active');
        $this->db->or_where('status', 'open');
        $query = $this->db->get('jobs', 1);
        
        return $query->row_array();
    }

    /**
     * Get job by ID
     */
    public function get_by_id($id) {
        if (!$this->table_exists('jobs')) {
            return null;
        }
        
        $query = $this->db->get_where('jobs', ['id' => $id]);
        return $query->row_array();
    }

    /**
     * Get all jobs
     */
    public function get_all() {
        if (!$this->table_exists('jobs')) {
            return [];
        }
        
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get('jobs');
        return $query->result_array();
    }
}
