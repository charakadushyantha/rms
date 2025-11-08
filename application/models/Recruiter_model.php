<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recruiter_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all recruiters
     */
    public function get_all_recruiters() {
        $this->db->select('u_id as id, u_username as username, u_email as email, u_status as status, u_created_at as created_at');
        $this->db->where('u_role', 'Recruiter');
        $this->db->order_by('u_created_at', 'DESC');
        
        return $this->db->get('users')->result_array();
    }

    /**
     * Check if username exists
     */
    public function username_exists($username) {
        $this->db->where('u_username', $username);
        $query = $this->db->get('users');
        return $query->num_rows() > 0;
    }

    /**
     * Check if email exists
     */
    public function email_exists($email) {
        $this->db->where('u_email', $email);
        $query = $this->db->get('users');
        return $query->num_rows() > 0;
    }

    /**
     * Create new recruiter
     */
    public function create_recruiter($data) {
        $data['u_created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('users', $data);
    }

    /**
     * Update recruiter status
     */
    public function update_status($id, $status) {
        $this->db->where('u_id', $id);
        return $this->db->update('users', ['u_status' => $status]);
    }

    /**
     * Delete recruiter
     */
    public function delete_recruiter($id) {
        $this->db->where('u_id', $id);
        $this->db->where('u_role', 'Recruiter'); // Safety check
        return $this->db->delete('users');
    }

    /**
     * Get statistics
     */
    public function get_statistics() {
        $stats = [];
        
        // Total recruiters
        $this->db->where('u_role', 'Recruiter');
        $stats['total'] = $this->db->count_all_results('users');
        
        // Active recruiters
        $this->db->where('u_role', 'Recruiter');
        $this->db->where('u_status', 1);
        $stats['active'] = $this->db->count_all_results('users');
        
        // Pending recruiters
        $this->db->where('u_role', 'Recruiter');
        $this->db->where('u_status', 0);
        $stats['pending'] = $this->db->count_all_results('users');
        
        return $stats;
    }
}
