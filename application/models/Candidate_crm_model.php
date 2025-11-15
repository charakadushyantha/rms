<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidate_crm_model extends CI_Model
{
    public function get_all_candidates($filters = [])
    {
        $this->db->select('*');
        $this->db->from('crm_candidates');
        $this->db->where('pipeline_status', 'Active');
        $this->db->order_by('relationship_score', 'DESC');
        $this->db->limit(50);
        return $this->db->get()->result_array();
    }

    public function get_pipeline_stages()
    {
        $this->db->select('*');
        $this->db->from('crm_pipeline_stages');
        $this->db->where('is_active', 1);
        $this->db->order_by('stage_order', 'ASC');
        return $this->db->get()->result_array();
    }

    public function get_candidates_by_stage()
    {
        $stages = $this->get_pipeline_stages();
        $result = [];
        
        foreach ($stages as $stage) {
            $this->db->select('*');
            $this->db->from('crm_candidates');
            $this->db->where('current_stage', $stage['stage_name']);
            $this->db->where('pipeline_status', 'Active');
            $result[$stage['stage_name']] = $this->db->get()->result_array();
        }
        
        return $result;
    }

    public function get_statistics()
    {
        $stats = [];
        $stats['total_candidates'] = $this->db->where('pipeline_status', 'Active')->count_all_results('crm_candidates');
        $stats['hot_leads'] = $this->db->where('priority', 'High')->where('pipeline_status', 'Active')->count_all_results('crm_candidates');
        $stats['total_interactions'] = $this->db->count_all('crm_interactions');
        $stats['pending_activities'] = $this->db->where('status', 'Pending')->count_all_results('crm_activities');
        
        return $stats;
    }
}
