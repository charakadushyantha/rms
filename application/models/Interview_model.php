<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Interview_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Create interview
     */
    public function create($data) {
        $this->db->insert('interviews', $data);
        return $this->db->insert_id();
    }

    /**
     * Get interview by ID
     */
    public function get_by_id($id) {
        $this->db->select('interviews.*, interview_flows.job_title, interview_flows.questions, interview_flows.interview_type');
        $this->db->from('interviews');
        $this->db->join('interview_flows', 'interview_flows.id = interviews.flow_id', 'left');
        $this->db->where('interviews.id', $id);
        
        $query = $this->db->get();
        $result = $query->row_array();
        
        if ($result && !empty($result['questions'])) {
            $result['questions'] = json_decode($result['questions'], true);
        }
        
        return $result;
    }

    /**
     * Get interview by token
     */
    public function get_by_token($token) {
        $this->db->select('interviews.*, interview_flows.job_title, interview_flows.questions, interview_flows.interview_type, interview_flows.duration_minutes');
        $this->db->from('interviews');
        $this->db->join('interview_flows', 'interview_flows.id = interviews.flow_id', 'left');
        $this->db->where('interviews.token', $token);
        
        $query = $this->db->get();
        $result = $query->row_array();
        
        if ($result && !empty($result['questions'])) {
            $result['questions'] = json_decode($result['questions'], true);
        }
        
        return $result;
    }

    /**
     * Get all interviews
     */
    public function get_all($flow_id = null, $status = null, $limit = 50, $offset = 0) {
        $this->db->select('interviews.*, interview_flows.job_title');
        $this->db->from('interviews');
        $this->db->join('interview_flows', 'interview_flows.id = interviews.flow_id', 'left');
        
        if ($flow_id) {
            $this->db->where('interviews.flow_id', $flow_id);
        }
        
        if ($status) {
            $this->db->where('interviews.status', $status);
        }
        
        $this->db->order_by('interviews.created_at', 'DESC');
        $this->db->limit($limit, $offset);
        
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Count all interviews
     */
    public function count_all($flow_id = null, $status = null) {
        $this->db->from('interviews');
        
        if ($flow_id) {
            $this->db->where('flow_id', $flow_id);
        }
        
        if ($status) {
            $this->db->where('status', $status);
        }
        
        return $this->db->count_all_results();
    }

    /**
     * Update interview
     */
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('interviews', $data);
    }

    /**
     * Update interview status
     */
    public function update_status($id, $status) {
        $data = [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        if ($status === 'completed') {
            $data['completed_at'] = date('Y-m-d H:i:s');
        }
        
        $this->db->where('id', $id);
        return $this->db->update('interviews', $data);
    }

    /**
     * Save interview response
     */
    public function save_response($interview_id, $question_id, $response_data) {
        $data = [
            'interview_id' => $interview_id,
            'question_id' => $question_id,
            'response_text' => $response_data['text'] ?? '',
            'response_audio' => $response_data['audio'] ?? '',
            'response_video' => $response_data['video'] ?? '',
            'duration_seconds' => $response_data['duration'] ?? 0,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->insert('interview_responses', $data);
        return $this->db->insert_id();
    }

    /**
     * Get interview responses with question text
     */
    public function get_responses($interview_id) {
        // First get the interview to get the flow_id
        $interview = $this->get_by_id($interview_id);
        if (!$interview) {
            return [];
        }
        
        // Get the flow to get questions
        $this->db->where('id', $interview['flow_id']);
        $flow_query = $this->db->get('interview_flows');
        $flow = $flow_query->row_array();
        
        if (!$flow) {
            return [];
        }
        
        // Decode questions
        $questions = is_array($flow['questions']) ? $flow['questions'] : json_decode($flow['questions'], true);
        
        // Create a map of question_id to question text
        $question_map = [];
        foreach ($questions as $q) {
            $question_map[$q['id']] = $q;
        }
        
        // Get responses
        $this->db->where('interview_id', $interview_id);
        $this->db->order_by('question_id', 'ASC');
        $query = $this->db->get('interview_responses');
        $responses = $query->result_array();
        
        // Merge question text with responses
        foreach ($responses as &$response) {
            $qid = $response['question_id'];
            if (isset($question_map[$qid])) {
                $response['question'] = $question_map[$qid]['question'];
                $response['question_type'] = $question_map[$qid]['type'] ?? 'open';
            } else {
                $response['question'] = 'Question not found';
            }
            
            // Rename duration_seconds to duration for consistency
            if (isset($response['duration_seconds'])) {
                $response['duration'] = $response['duration_seconds'];
            }
        }
        
        return $responses;
    }

    /**
     * Calculate interview score
     */
    public function calculate_score($interview_id) {
        // Implement scoring logic based on responses
        // This is a placeholder
        return 75;
    }

    /**
     * Get interview statistics
     */
    public function get_statistics($flow_id = null) {
        $stats = [];
        
        // Total interviews
        $this->db->from('interviews');
        if ($flow_id) $this->db->where('flow_id', $flow_id);
        $stats['total'] = $this->db->count_all_results();
        
        // Completed
        $this->db->from('interviews');
        if ($flow_id) $this->db->where('flow_id', $flow_id);
        $this->db->where('status', 'completed');
        $stats['completed'] = $this->db->count_all_results();
        
        // Pending
        $this->db->from('interviews');
        if ($flow_id) $this->db->where('flow_id', $flow_id);
        $this->db->where('status', 'pending');
        $stats['pending'] = $this->db->count_all_results();
        
        // In Progress
        $this->db->from('interviews');
        if ($flow_id) $this->db->where('flow_id', $flow_id);
        $this->db->where('status', 'in_progress');
        $stats['in_progress'] = $this->db->count_all_results();
        
        return $stats;
    }

    /**
     * Count interviews by status
     */
    public function count_by_status($status) {
        $this->db->where('status', $status);
        return $this->db->count_all_results('interviews');
    }
    
    /**
     * Get unique positions
     */
    public function get_unique_positions() {
        $this->db->select('job_title');
        $this->db->from('interview_flows');
        $this->db->group_by('job_title');
        $query = $this->db->get();
        
        $positions = [];
        foreach ($query->result_array() as $row) {
            $positions[] = $row['job_title'];
        }
        
        return $positions;
    }
    
    /**
     * Get today's interviews
     */
    public function get_today_interviews() {
        $today = date('Y-m-d');
        
        $this->db->select('interviews.*, interview_flows.job_title as position');
        $this->db->from('interviews');
        $this->db->join('interview_flows', 'interviews.flow_id = interview_flows.id');
        $this->db->where('DATE(interviews.created_at)', $today);
        $this->db->where_in('interviews.status', ['pending', 'in_progress']);
        $this->db->order_by('interviews.created_at', 'ASC');
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * Get upcoming interviews this week
     */
    public function get_upcoming_week() {
        $start_date = date('Y-m-d');
        $end_date = date('Y-m-d', strtotime('+7 days'));
        
        $this->db->select('interviews.*, interview_flows.job_title as position');
        $this->db->from('interviews');
        $this->db->join('interview_flows', 'interviews.flow_id = interview_flows.id');
        $this->db->where('DATE(interviews.created_at) >=', $start_date);
        $this->db->where('DATE(interviews.created_at) <=', $end_date);
        $this->db->where_in('interviews.status', ['pending', 'in_progress']);
        $this->db->order_by('interviews.created_at', 'ASC');
        $this->db->limit(5);
        
        $query = $this->db->get();
        return $query->result_array();
    }
}
