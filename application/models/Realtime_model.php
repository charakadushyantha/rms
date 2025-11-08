<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Realtime_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all pipeline stages
     */
    public function get_pipeline_stages() {
        $this->db->where('is_active', 1);
        $this->db->order_by('order_position', 'ASC');
        return $this->db->get('pipeline_stages')->result_array();
    }

    /**
     * Get pipeline overview with candidates
     */
    public function get_pipeline_overview() {
        $stages = $this->get_pipeline_stages();
        
        foreach ($stages as &$stage) {
            // Get candidates in this stage (only their LATEST pipeline entry)
            $sql = "SELECT cp.*, c.name, c.email, c.phone, c.position_applied
                    FROM candidate_pipeline cp
                    INNER JOIN candidates c ON c.id = cp.candidate_id
                    INNER JOIN (
                        SELECT candidate_id, MAX(id) as latest_id
                        FROM candidate_pipeline
                        GROUP BY candidate_id
                    ) latest ON cp.id = latest.latest_id
                    WHERE cp.stage_id = ?
                    ORDER BY cp.moved_at DESC";
            
            $query = $this->db->query($sql, [$stage['id']]);
            $stage['candidates'] = $query->result_array();
            $stage['count'] = count($stage['candidates']);
        }
        
        return $stages;
    }

    /**
     * Move candidate to new stage
     */
    public function move_candidate($candidate_id, $stage_id, $user_id, $notes = '') {
        $data = [
            'candidate_id' => $candidate_id,
            'stage_id' => $stage_id,
            'moved_by' => $user_id,
            'notes' => $notes,
            'moved_at' => date('Y-m-d H:i:s')
        ];
        
        return $this->db->insert('candidate_pipeline', $data);
    }

    /**
     * Get dashboard metrics
     */
    public function get_dashboard_metrics() {
        $metrics = [];
        
        // Total candidates in pipeline
        $metrics['total_candidates'] = $this->db->count_all('candidate_pipeline');
        
        // Candidates by stage
        $this->db->select('ps.name, COUNT(*) as count');
        $this->db->from('candidate_pipeline cp');
        $this->db->join('pipeline_stages ps', 'ps.id = cp.stage_id');
        $this->db->group_by('cp.stage_id');
        $metrics['by_stage'] = $this->db->get()->result_array();
        
        // Average time in pipeline
        $this->db->select('AVG(DATEDIFF(NOW(), moved_at)) as avg_days');
        $result = $this->db->get('candidate_pipeline')->row();
        $metrics['avg_days_in_pipeline'] = round($result->avg_days ?? 0, 1);
        
        // Urgent candidates
        $this->db->where('urgency_level', 'high');
        $metrics['urgent_count'] = $this->db->count_all_results('candidate_pipeline');
        
        // Today's interviews
        $this->db->where('DATE(interview_date)', date('Y-m-d'));
        $this->db->where('status', 'scheduled');
        $metrics['today_interviews'] = $this->db->count_all_results('interview_panels');
        
        return $metrics;
    }

    /**
     * Get recent activity
     */
    public function get_recent_activity($limit = 20) {
        $this->db->select('pal.*, u.username, c.name as candidate_name');
        $this->db->from('pipeline_activity_log pal');
        $this->db->join('users u', 'u.id = pal.user_id', 'left');
        $this->db->join('candidates c', 'c.id = pal.candidate_id', 'left');
        $this->db->order_by('pal.created_at', 'DESC');
        $this->db->limit($limit);
        
        return $this->db->get()->result_array();
    }

    /**
     * Log activity
     */
    public function log_activity($candidate_id, $user_id, $action_type, $action_data = null) {
        $data = [
            'candidate_id' => $candidate_id,
            'user_id' => $user_id,
            'action_type' => $action_type,
            'action_data' => $action_data
        ];
        
        return $this->db->insert('pipeline_activity_log', $data);
    }

    /**
     * Create hiring decision
     */
    public function create_decision($data) {
        if ($this->db->insert('hiring_decisions', $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    /**
     * Submit vote
     */
    public function submit_vote($data) {
        // Check if user already voted
        $this->db->where('decision_id', $data['decision_id']);
        $this->db->where('user_id', $data['user_id']);
        $existing = $this->db->get('decision_votes')->row();
        
        if ($existing) {
            // Update existing vote
            $this->db->where('id', $existing->id);
            return $this->db->update('decision_votes', $data);
        } else {
            // Insert new vote
            return $this->db->insert('decision_votes', $data);
        }
    }

    /**
     * Get decision votes
     */
    public function get_decision_votes($decision_id) {
        $this->db->select('vote, COUNT(*) as count');
        $this->db->where('decision_id', $decision_id);
        $this->db->group_by('vote');
        
        return $this->db->get('decision_votes')->result_array();
    }

    /**
     * Get interviewer availability
     */
    public function get_interviewer_availability($date) {
        $this->db->select('ia.*, u.username, u.email');
        $this->db->from('interviewer_availability ia');
        $this->db->join('users u', 'u.id = ia.user_id');
        $this->db->where('ia.date', $date);
        $this->db->where('ia.is_available', 1);
        
        return $this->db->get()->result_array();
    }

    /**
     * Schedule interview
     */
    public function schedule_interview($data) {
        return $this->db->insert('interview_panels', $data);
    }

    /**
     * Identify bottlenecks
     */
    public function identify_bottlenecks() {
        $bottlenecks = [];
        
        // Stages with too many candidates
        $this->db->select('ps.name, ps.color, COUNT(*) as count');
        $this->db->from('candidate_pipeline cp');
        $this->db->join('pipeline_stages ps', 'ps.id = cp.stage_id');
        $this->db->group_by('cp.stage_id');
        $this->db->having('count >', 10);
        $bottlenecks['overcrowded_stages'] = $this->db->get()->result_array();
        
        // Candidates stuck too long
        $this->db->select('cp.*, c.name, ps.name as stage_name, DATEDIFF(NOW(), cp.moved_at) as days_stuck');
        $this->db->from('candidate_pipeline cp');
        $this->db->join('candidates c', 'c.id = cp.candidate_id');
        $this->db->join('pipeline_stages ps', 'ps.id = cp.stage_id');
        $this->db->having('days_stuck >', 7);
        $this->db->order_by('days_stuck', 'DESC');
        $this->db->limit(10);
        $bottlenecks['stuck_candidates'] = $this->db->get()->result_array();
        
        return $bottlenecks;
    }
    
    /**
     * Get candidate by ID
     */
    public function get_candidate_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get('candidates')->row_array();
    }
    
    /**
     * Get candidate pipeline history
     */
    public function get_candidate_pipeline_history($candidate_id) {
        $this->db->select('cp.*, ps.name as stage_name, ps.color');
        $this->db->from('candidate_pipeline cp');
        $this->db->join('pipeline_stages ps', 'ps.id = cp.stage_id');
        $this->db->where('cp.candidate_id', $candidate_id);
        $this->db->order_by('cp.moved_at', 'DESC');
        
        return $this->db->get()->result_array();
    }
    
    /**
     * Get candidate interviews
     */
    public function get_candidate_interviews($candidate_id) {
        $this->db->select('ip.*');
        $this->db->from('interview_panels ip');
        $this->db->where('ip.candidate_id', $candidate_id);
        $this->db->order_by('ip.interview_date', 'DESC');
        
        return $this->db->get()->result_array();
    }
    
    /**
     * Get candidate decisions
     */
    public function get_candidate_decisions($candidate_id) {
        $this->db->select('hd.*');
        $this->db->from('hiring_decisions hd');
        $this->db->where('hd.candidate_id', $candidate_id);
        $this->db->order_by('hd.created_at', 'DESC');
        
        return $this->db->get()->result_array();
    }
}
