<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recruitment_events_model extends CI_Model
{
    public function get_all_events($filters = [])
    {
        $this->db->select('*');
        $this->db->from('recruitment_events');
        
        if (!empty($filters['type'])) {
            if ($filters['type'] == 'Virtual') {
                $this->db->where('venue_type', 'Virtual');
            } else {
                $this->db->where('event_type', $filters['type']);
            }
        }
        
        if (!empty($filters['status'])) {
            $this->db->where('status', $filters['status']);
        }
        
        $this->db->order_by('event_date', 'ASC');
        return $this->db->get()->result_array();
    }

    public function get_event($event_id)
    {
        return $this->db->where('event_id', $event_id)
                       ->get('recruitment_events')->row_array();
    }

    public function create_event($data)
    {
        if ($this->db->insert('recruitment_events', $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    public function delete_event($event_id)
    {
        $this->db->where('event_id', $event_id);
        return $this->db->delete('recruitment_events');
    }

    public function get_event_types()
    {
        return $this->db->where('is_active', 1)
                       ->order_by('type_name')
                       ->get('event_types')->result_array();
    }

    public function get_registrations($event_id)
    {
        return $this->db->where('event_id', $event_id)
                       ->order_by('registration_date', 'DESC')
                       ->get('event_registrations')->result_array();
    }

    public function get_event_jobs($event_id)
    {
        return $this->db->where('event_id', $event_id)
                       ->where('is_active', 1)
                       ->get('event_jobs')->result_array();
    }

    public function get_statistics()
    {
        $stats = [];
        $stats['total_events'] = $this->db->count_all('recruitment_events');
        $stats['upcoming_events'] = $this->db->where('status', 'Upcoming')->count_all_results('recruitment_events');
        
        $totals = $this->db->select('SUM(registered_count) as registrations, SUM(budget) as budget')
                          ->get('recruitment_events')->row_array();
        $stats['total_registrations'] = $totals['registrations'] ?? 0;
        $stats['total_budget'] = $totals['budget'] ?? 0;
        
        return $stats;
    }
}
