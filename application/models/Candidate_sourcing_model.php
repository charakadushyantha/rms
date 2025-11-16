<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidate_sourcing_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // Get all candidates with filters
    public function get_all_candidates($filters = [])
    {
        $this->db->select('sc.*, COUNT(DISTINCT cs.skill_id) as skill_count');
        $this->db->from('sourced_candidates sc');
        $this->db->join('candidate_skills cs', 'sc.candidate_id = cs.candidate_id', 'left');
        
        // Apply filters
        if (!empty($filters['search'])) {
            $search = $this->db->escape_like_str($filters['search']);
            $this->db->group_start();
            $this->db->like('sc.first_name', $search);
            $this->db->or_like('sc.last_name', $search);
            $this->db->or_like('sc.email', $search);
            $this->db->or_like('sc.current_title', $search);
            $this->db->or_like('sc.current_company', $search);
            $this->db->group_end();
        }
        
        if (!empty($filters['skills'])) {
            $skills = explode(',', $filters['skills']);
            $this->db->join('candidate_skills cs2', 'sc.candidate_id = cs2.candidate_id');
            $this->db->where_in('cs2.skill_name', $skills);
        }
        
        if (!empty($filters['location'])) {
            $this->db->like('sc.location', $filters['location']);
        }
        
        if (!empty($filters['experience_min'])) {
            $this->db->where('sc.total_experience >=', $filters['experience_min']);
        }
        
        if (!empty($filters['experience_max'])) {
            $this->db->where('sc.total_experience <=', $filters['experience_max']);
        }
        
        if (!empty($filters['status'])) {
            $this->db->where('sc.status', $filters['status']);
        }
        
        if (!empty($filters['source'])) {
            $this->db->where('sc.source', $filters['source']);
        }
        
        $this->db->group_by('sc.candidate_id');
        $this->db->order_by('sc.created_at', 'DESC');
        
        if (!empty($filters['limit'])) {
            $this->db->limit($filters['limit']);
        }
        
        return $this->db->get()->result_array();
    }

    // Get single candidate with full details
    public function get_candidate($candidate_id)
    {
        $candidate = $this->db->where('candidate_id', $candidate_id)
                              ->get('sourced_candidates')->row_array();
        
        if ($candidate) {
            $candidate->skills = $this->get_candidate_skills($candidate_id);
            $candidate->experience = $this->get_candidate_experience($candidate_id);
            $candidate->education = $this->get_candidate_education($candidate_id);
            $candidate->documents = $this->get_candidate_documents($candidate_id);
            $candidate->engagement_history = $this->get_engagement_history($candidate_id);
        }
        
        return $candidate;
    }

    // Create candidate
    public function create_candidate($data)
    {
        if ($this->db->insert('sourced_candidates', $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    // Update candidate
    public function update_candidate($candidate_id, $data)
    {
        $this->db->where('candidate_id', $candidate_id);
        return $this->db->update('sourced_candidates', $data);
    }

    // Delete candidate
    public function delete_candidate($candidate_id)
    {
        $this->db->where('candidate_id', $candidate_id);
        return $this->db->delete('sourced_candidates');
    }

    // Skills management
    public function add_skill($candidate_id, $skill_data)
    {
        $skill_data['candidate_id'] = $candidate_id;
        return $this->db->insert('candidate_skills', $skill_data);
    }

    public function get_candidate_skills($candidate_id)
    {
        return $this->db->where('candidate_id', $candidate_id)
                       ->get('candidate_skills')->result_array();
    }

    public function delete_skill($skill_id)
    {
        return $this->db->where('skill_id', $skill_id)
                       ->delete('candidate_skills');
    }

    // Experience management
    public function add_experience($candidate_id, $exp_data)
    {
        $exp_data['candidate_id'] = $candidate_id;
        return $this->db->insert('candidate_experience', $exp_data);
    }

    public function get_candidate_experience($candidate_id)
    {
        return $this->db->where('candidate_id', $candidate_id)
                       ->order_by('start_date', 'DESC')
                       ->get('candidate_experience')->result_array();
    }

    // Education management
    public function add_education($candidate_id, $edu_data)
    {
        $edu_data['candidate_id'] = $candidate_id;
        return $this->db->insert('candidate_education', $edu_data);
    }

    public function get_candidate_education($candidate_id)
    {
        return $this->db->where('candidate_id', $candidate_id)
                       ->order_by('end_year', 'DESC')
                       ->get('candidate_education')->result_array();
    }

    // Document management
    public function add_document($candidate_id, $doc_data)
    {
        $doc_data['candidate_id'] = $candidate_id;
        return $this->db->insert('candidate_documents', $doc_data);
    }

    public function get_candidate_documents($candidate_id)
    {
        return $this->db->where('candidate_id', $candidate_id)
                       ->order_by('uploaded_at', 'DESC')
                       ->get('candidate_documents')->result_array();
    }

    // Talent Pools
    public function get_all_pools()
    {
        $this->db->select('tp.*, COUNT(tpm.member_id) as member_count');
        $this->db->from('talent_pools tp');
        $this->db->join('talent_pool_members tpm', 'tp.pool_id = tpm.pool_id', 'left');
        $this->db->where('tp.is_active', 1);
        $this->db->group_by('tp.pool_id');
        $this->db->order_by('tp.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function create_pool($data)
    {
        if ($this->db->insert('talent_pools', $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    public function add_to_pool($pool_id, $candidate_id, $added_by)
    {
        // Check if already in pool
        $exists = $this->db->where('pool_id', $pool_id)
                          ->where('candidate_id', $candidate_id)
                          ->count_all_results('talent_pool_members');
        
        if ($exists == 0) {
            return $this->db->insert('talent_pool_members', [
                'pool_id' => $pool_id,
                'candidate_id' => $candidate_id,
                'added_by' => $added_by
            ]);
        }
        return false;
    }

    public function get_pool_members($pool_id)
    {
        $this->db->select('sc.*, tpm.added_at');
        $this->db->from('talent_pool_members tpm');
        $this->db->join('sourced_candidates sc', 'tpm.candidate_id = sc.candidate_id');
        $this->db->where('tpm.pool_id', $pool_id);
        $this->db->order_by('tpm.added_at', 'DESC');
        return $this->db->get()->result_array();
    }

    // Engagement
    public function log_engagement($engagement_data)
    {
        return $this->db->insert('candidate_engagement', $engagement_data);
    }

    public function get_engagement_history($candidate_id)
    {
        return $this->db->where('candidate_id', $candidate_id)
                       ->order_by('sent_at', 'DESC')
                       ->get('candidate_engagement')->result_array();
    }

    // Statistics
    public function get_statistics()
    {
        $stats = [];
        
        $stats['total_candidates'] = $this->db->count_all('sourced_candidates');
        
        $stats['by_status'] = $this->db->select('status, COUNT(*) as count')
                                       ->group_by('status')
                                       ->get('sourced_candidates')->result_array();
        
        $stats['by_source'] = $this->db->select('source, COUNT(*) as count')
                                      ->group_by('source')
                                      ->order_by('count', 'DESC')
                                      ->limit(10)
                                      ->get('sourced_candidates')->result_array();
        
        $stats['top_skills'] = $this->db->select('skill_name, COUNT(*) as count')
                                       ->group_by('skill_name')
                                       ->order_by('count', 'DESC')
                                       ->limit(20)
                                       ->get('candidate_skills')->result_array();
        
        return $stats;
    }

    // Get all sources
    public function get_all_sources()
    {
        return $this->db->where('is_active', 1)
                       ->order_by('source_name')
                       ->get('candidate_sources')->result_array();
    }

    // Saved searches
    public function save_search($data)
    {
        return $this->db->insert('saved_searches', $data);
    }

    public function get_saved_searches($user)
    {
        return $this->db->where('created_by', $user)
                       ->order_by('created_at', 'DESC')
                       ->get('saved_searches')->result_array();
    }
}
