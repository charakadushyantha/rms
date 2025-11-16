<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_advocacy_model extends CI_Model
{
    public function get_all_advocates($filters = [])
    {
        $this->db->select('*');
        $this->db->from('employee_advocates');
        $this->db->where('status', 'Active');
        $this->db->order_by('total_reach', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_top_advocates($limit = 10)
    {
        $this->db->select('*');
        $this->db->from('employee_advocates');
        $this->db->where('status', 'Active');
        $this->db->order_by('total_engagements', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    public function get_all_content()
    {
        $this->db->select('*');
        $this->db->from('advocacy_content');
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_statistics()
    {
        $stats = [];
        $stats['total_advocates'] = $this->db->count_all('employee_advocates');
        $stats['active_advocates'] = $this->db->where('status', 'Active')->count_all_results('employee_advocates');
        
        $totals = $this->db->select('SUM(total_shares) as shares, SUM(total_reach) as reach, SUM(total_engagements) as engagements')
                          ->get('employee_advocates')->row_array();
        $stats['total_shares'] = $totals['shares'] ?? 0;
        $stats['total_reach'] = $totals['reach'] ?? 0;
        $stats['total_engagements'] = $totals['engagements'] ?? 0;
        
        return $stats;
    }
}
