<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Interview_flow_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Create interview flow
     */
    public function create($data) {
        $this->db->insert('interview_flows', $data);
        return $this->db->insert_id();
    }

    /**
     * Get interview flow by ID
     */
    public function get_by_id($id) {
        $query = $this->db->get_where('interview_flows', ['id' => $id]);
        $result = $query->row_array();
        
        if ($result && !empty($result['questions'])) {
            $result['questions'] = json_decode($result['questions'], true);
        }
        
        return $result;
    }

    /**
     * Get all interview flows
     */
    public function get_all($status = null, $limit = 50, $offset = 0) {
        if ($status) {
            $this->db->where('status', $status);
        }
        
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit, $offset);
        
        $query = $this->db->get('interview_flows');
        $results = $query->result_array();
        
        foreach ($results as &$result) {
            if (!empty($result['questions'])) {
                $result['questions'] = json_decode($result['questions'], true);
            }
        }
        
        return $results;
    }

    /**
     * Count all interview flows
     */
    public function count_all($status = null) {
        if ($status) {
            $this->db->where('status', $status);
        }
        
        return $this->db->count_all_results('interview_flows');
    }

    /**
     * Update interview flow
     */
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('interview_flows', $data);
    }

    /**
     * Delete interview flow
     */
    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('interview_flows');
    }

    /**
     * Get active flows
     */
    public function get_active() {
        $this->db->where('status', 'active');
        $this->db->order_by('created_at', 'DESC');
        
        $query = $this->db->get('interview_flows');
        return $query->result_array();
    }
}
