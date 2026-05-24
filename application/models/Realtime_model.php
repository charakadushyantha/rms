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
        
        // If no stages exist, return empty array
        if (empty($stages)) {
            return [];
        }
        
        foreach ($stages as &$stage) {
            // Get candidates in this stage (only their LATEST pipeline entry)
            // Using candidate_details table instead of candidates
            $sql = "SELECT cp.*, 
                    cd.cd_id as id,
                    cd.cd_name as name, 
                    cd.cd_email as email, 
                    cd.cd_phone as phone, 
                    cd.cd_job_title as job_title,
                    cd.cd_status,
                    DATEDIFF(NOW(), cp.moved_at) as days_in_stage
                    FROM candidate_pipeline cp
                    INNER JOIN candidate_details cd ON cd.cd_id = cp.candidate_id
                    INNER JOIN (
                        SELECT candidate_id, MAX(id) as latest_id
                        FROM candidate_pipeline
                        GROUP BY candidate_id
                    ) latest ON cp.id = latest.latest_id
                    WHERE cp.stage_id = ?
                    ORDER BY cp.moved_at DESC";
            
            try {
                $query = $this->db->query($sql, [$stage['id']]);
                $stage['candidates'] = $query->result_array();
                $stage['count'] = count($stage['candidates']);
            } catch (Exception $e) {
                // If query fails, set empty candidates
                $stage['candidates'] = [];
                $stage['count'] = 0;
            }
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
        
        // Total candidates in pipeline (unique candidates)
        $this->db->select('COUNT(DISTINCT candidate_id) as count');
        $result = $this->db->get('candidate_pipeline')->row();
        $metrics['total_candidates'] = $result->count ?? 0;
        
        // Candidates by stage
        $this->db->select('ps.name, COUNT(DISTINCT cp.candidate_id) as count');
        $this->db->from('candidate_pipeline cp');
        $this->db->join('pipeline_stages ps', 'ps.id = cp.stage_id');
        $this->db->group_by('cp.stage_id');
        $metrics['by_stage'] = $this->db->get()->result_array();
        
        // Average time in pipeline
        $this->db->select('AVG(DATEDIFF(NOW(), moved_at)) as avg_days');
        $result = $this->db->get('candidate_pipeline')->row();
        $metrics['avg_days_in_pipeline'] = round($result->avg_days ?? 0, 1);
        
        // Urgent candidates (candidates in pipeline for more than 7 days)
        $this->db->select('COUNT(DISTINCT candidate_id) as count');
        $this->db->where('DATEDIFF(NOW(), moved_at) >', 7);
        $result = $this->db->get('candidate_pipeline')->row();
        $metrics['urgent_count'] = $result->count ?? 0;
        
        // Today's interviews from calendar_events
        $this->db->where('DATE(ce_start_date)', date('Y-m-d'));
        $metrics['todays_interviews'] = $this->db->count_all_results('calendar_events');
        
        return $metrics;
    }

    /**
     * Get recent activity
     */
    public function get_recent_activity($limit = 20) {
        // Check if pipeline_activity_log table has data
        $count = $this->db->count_all('pipeline_activity_log');
        
        if ($count > 0) {
            $this->db->select('pal.*, u.u_username as username, cd.cd_name as candidate_name');
            $this->db->from('pipeline_activity_log pal');
            $this->db->join('users u', 'u.u_id = pal.user_id', 'left');
            $this->db->join('candidate_details cd', 'cd.cd_id = pal.candidate_id', 'left');
            $this->db->order_by('pal.created_at', 'DESC');
            $this->db->limit($limit);
            
            $activities = $this->db->get()->result_array();
            
            // Format activities
            foreach ($activities as &$activity) {
                $activity['description'] = $this->format_activity_description($activity);
                $activity['time_ago'] = $this->time_ago($activity['created_at']);
            }
            
            return $activities;
        }
        
        // Fallback: Generate activity from candidate_pipeline changes
        $this->db->select('cp.*, cd.cd_name as candidate_name, ps.name as stage_name, u.u_username as username');
        $this->db->from('candidate_pipeline cp');
        $this->db->join('candidate_details cd', 'cd.cd_id = cp.candidate_id', 'left');
        $this->db->join('pipeline_stages ps', 'ps.id = cp.stage_id', 'left');
        $this->db->join('users u', 'u.u_id = cp.moved_by', 'left');
        $this->db->order_by('cp.moved_at', 'DESC');
        $this->db->limit($limit);
        
        $activities = $this->db->get()->result_array();
        
        // Format activities
        foreach ($activities as &$activity) {
            $activity['description'] = ($activity['username'] ?? 'Someone') . ' moved ' . 
                                      ($activity['candidate_name'] ?? 'a candidate') . ' to ' . 
                                      ($activity['stage_name'] ?? 'a stage');
            $activity['time_ago'] = $this->time_ago($activity['moved_at']);
            $activity['created_at'] = $activity['moved_at'];
        }
        
        return $activities;
    }
    
    /**
     * Format activity description
     */
    private function format_activity_description($activity) {
        $user = $activity['username'] ?? 'Someone';
        $candidate = $activity['candidate_name'] ?? 'a candidate';
        $action = $activity['action_type'] ?? 'updated';
        
        switch ($action) {
            case 'stage_change':
                return "$user moved $candidate to a new stage";
            case 'interview_scheduled':
                return "$user scheduled an interview for $candidate";
            case 'note_added':
                return "$user added a note for $candidate";
            default:
                return "$user performed an action on $candidate";
        }
    }
    
    /**
     * Convert timestamp to time ago format
     */
    private function time_ago($datetime) {
        $timestamp = strtotime($datetime);
        $diff = time() - $timestamp;
        
        if ($diff < 60) return $diff . ' seconds ago';
        if ($diff < 3600) return floor($diff / 60) . ' minutes ago';
        if ($diff < 86400) return floor($diff / 3600) . ' hours ago';
        if ($diff < 604800) return floor($diff / 86400) . ' days ago';
        
        return date('M j, Y', $timestamp);
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
        $this->db->where('cd_id', $id);
        return $this->db->get('candidate_details')->row_array();
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
