<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Knowledge_base_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Search knowledge base
     */
    public function search($query, $limit = 5) {
        if (empty($query)) {
            return null;
        }

        // Try exact match first
        $this->db->like('question', $query);
        $this->db->or_like('answer', $query);
        $this->db->where('is_active', 1);
        $this->db->order_by('relevance_score', 'DESC');
        $this->db->limit($limit);
        
        $result = $this->db->get('knowledge_base');
        
        if ($result->num_rows() > 0) {
            $row = $result->row_array();
            
            // Update usage count
            $this->db->where('id', $row['id']);
            $this->db->set('usage_count', 'usage_count + 1', FALSE);
            $this->db->update('knowledge_base');
            
            return $row;
        }

        return null;
    }

    /**
     * Get by category
     */
    public function get_by_category($category) {
        $this->db->where('category', $category);
        $this->db->where('is_active', 1);
        $this->db->order_by('relevance_score', 'DESC');
        
        $query = $this->db->get('knowledge_base');
        return $query->row_array();
    }

    /**
     * Get all categories
     */
    public function get_categories() {
        $this->db->select('DISTINCT category');
        $this->db->where('is_active', 1);
        
        $query = $this->db->get('knowledge_base');
        return array_column($query->result_array(), 'category');
    }

    /**
     * Add knowledge base entry
     */
    public function add($data) {
        return $this->db->insert('knowledge_base', $data);
    }

    /**
     * Update knowledge base entry
     */
    public function update($id, $data) {
        return $this->db->update('knowledge_base', $data, ['id' => $id]);
    }

    /**
     * Delete knowledge base entry
     */
    public function delete($id) {
        return $this->db->update('knowledge_base', ['is_active' => 0], ['id' => $id]);
    }

    /**
     * Get all entries
     */
    public function get_all($category = null) {
        if ($category) {
            $this->db->where('category', $category);
        }
        
        $this->db->where('is_active', 1);
        $this->db->order_by('category', 'ASC');
        $this->db->order_by('relevance_score', 'DESC');
        
        $query = $this->db->get('knowledge_base');
        return $query->result_array();
    }
}
