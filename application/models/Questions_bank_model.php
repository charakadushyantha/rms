<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Questions_bank_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Create a new question
     */
    public function create_question($data) {
        $this->db->insert('questions_bank', $data);
        return $this->db->insert_id();
    }

    /**
     * Get question by ID
     */
    public function get_question($id) {
        $this->db->select('questions_bank.*, question_categories.name as category_name');
        $this->db->from('questions_bank');
        $this->db->join('question_categories', 'question_categories.id = questions_bank.category_id', 'left');
        $this->db->where('questions_bank.id', $id);
        
        $query = $this->db->get();
        $question = $query->row_array();
        
        if ($question) {
            // Get options if MCQ
            if (in_array($question['question_type'], ['mcq_single', 'mcq_multiple'])) {
                $question['options'] = $this->get_question_options($id);
            }
            
            // Get associated roles
            $question['roles'] = $this->get_question_roles($id);
            
            // Get tags
            $question['tags'] = $this->get_question_tags($id);
        }
        
        return $question;
    }

    /**
     * Get all questions with filters
     */
    public function get_all_questions($filters = [], $limit = 50, $offset = 0) {
        $this->db->select('questions_bank.*, question_categories.name as category_name, question_categories.type as category_type');
        $this->db->from('questions_bank');
        $this->db->join('question_categories', 'question_categories.id = questions_bank.category_id', 'left');
        
        // Apply filters
        if (!empty($filters['category_id'])) {
            $this->db->where('questions_bank.category_id', $filters['category_id']);
        }
        
        if (!empty($filters['difficulty'])) {
            $this->db->where('questions_bank.difficulty', $filters['difficulty']);
        }
        
        if (!empty($filters['question_type'])) {
            $this->db->where('questions_bank.question_type', $filters['question_type']);
        }
        
        if (!empty($filters['is_mandatory'])) {
            $this->db->where('questions_bank.is_mandatory', $filters['is_mandatory']);
        }
        
        if (!empty($filters['role_id'])) {
            $this->db->join('question_role_mapping', 'question_role_mapping.question_id = questions_bank.id');
            $this->db->where('question_role_mapping.role_id', $filters['role_id']);
        }
        
        if (!empty($filters['search'])) {
            $this->db->like('questions_bank.question_text', $filters['search']);
        }
        
        $this->db->where('questions_bank.is_active', 1);
        $this->db->order_by('questions_bank.created_at', 'DESC');
        $this->db->limit($limit, $offset);
        
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Update question
     */
    public function update_question($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('questions_bank', $data);
    }

    /**
     * Delete question
     */
    public function delete_question($id) {
        $this->db->where('id', $id);
        return $this->db->delete('questions_bank');
    }

    /**
     * Add question option
     */
    public function add_option($question_id, $option_text, $is_correct, $order = 0) {
        $data = [
            'question_id' => $question_id,
            'option_text' => $option_text,
            'is_correct' => $is_correct,
            'option_order' => $order
        ];
        
        $this->db->insert('question_options', $data);
        return $this->db->insert_id();
    }

    /**
     * Get question options
     */
    public function get_question_options($question_id) {
        $this->db->where('question_id', $question_id);
        $this->db->order_by('option_order', 'ASC');
        $query = $this->db->get('question_options');
        return $query->result_array();
    }

    /**
     * Delete question options
     */
    public function delete_question_options($question_id) {
        $this->db->where('question_id', $question_id);
        return $this->db->delete('question_options');
    }

    /**
     * Map question to role
     */
    public function map_question_to_role($question_id, $role_id) {
        $data = [
            'question_id' => $question_id,
            'role_id' => $role_id
        ];
        
        $this->db->insert('question_role_mapping', $data);
        return $this->db->insert_id();
    }

    /**
     * Get question roles
     */
    public function get_question_roles($question_id) {
        $this->db->select('job_roles.*');
        $this->db->from('question_role_mapping');
        $this->db->join('job_roles', 'job_roles.id = question_role_mapping.role_id');
        $this->db->where('question_role_mapping.question_id', $question_id);
        
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Delete question role mappings
     */
    public function delete_question_role_mappings($question_id) {
        $this->db->where('question_id', $question_id);
        return $this->db->delete('question_role_mapping');
    }

    /**
     * Generate interview question set
     */
    public function generate_question_set($role_id, $num_questions = 10) {
        $questions = [];
        
        // Get all mandatory questions
        $this->db->where('is_mandatory', 1);
        $this->db->where('is_active', 1);
        $mandatory = $this->db->get('questions_bank')->result_array();
        
        foreach ($mandatory as $q) {
            $questions[] = $q;
        }
        
        // Get role-specific questions
        $remaining = $num_questions - count($questions);
        
        if ($remaining > 0) {
            $this->db->select('questions_bank.*');
            $this->db->from('questions_bank');
            $this->db->join('question_role_mapping', 'question_role_mapping.question_id = questions_bank.id');
            $this->db->where('question_role_mapping.role_id', $role_id);
            $this->db->where('questions_bank.is_mandatory', 0);
            $this->db->where('questions_bank.is_active', 1);
            $this->db->order_by('RAND()');
            $this->db->limit($remaining);
            
            $role_questions = $this->db->get()->result_array();
            
            foreach ($role_questions as $q) {
                $questions[] = $q;
            }
        }
        
        // Randomize order
        shuffle($questions);
        
        return $questions;
    }

    /**
     * Save interview question set
     */
    public function save_interview_questions($interview_id, $questions) {
        $order = 1;
        foreach ($questions as $question) {
            $data = [
                'interview_id' => $interview_id,
                'question_id' => $question['id'],
                'question_order' => $order++
            ];
            
            $this->db->insert('interview_question_sets', $data);
        }
        
        return true;
    }

    /**
     * Get interview questions
     */
    public function get_interview_questions($interview_id) {
        $this->db->select('interview_question_sets.*, questions_bank.question_text, questions_bank.question_type, questions_bank.points');
        $this->db->from('interview_question_sets');
        $this->db->join('questions_bank', 'questions_bank.id = interview_question_sets.question_id');
        $this->db->where('interview_question_sets.interview_id', $interview_id);
        $this->db->order_by('interview_question_sets.question_order', 'ASC');
        
        $query = $this->db->get();
        $questions = $query->result_array();
        
        // Get options for MCQ questions
        foreach ($questions as &$question) {
            if (in_array($question['question_type'], ['mcq_single', 'mcq_multiple'])) {
                $question['options'] = $this->get_question_options($question['question_id']);
            }
        }
        
        return $questions;
    }

    /**
     * Save candidate answer
     */
    public function save_answer($interview_id, $question_id, $answer_data) {
        $this->db->where('interview_id', $interview_id);
        $this->db->where('question_id', $question_id);
        
        $data = [
            'candidate_answer' => $answer_data['answer'] ?? null,
            'selected_options' => isset($answer_data['selected_options']) ? json_encode($answer_data['selected_options']) : null,
            'time_taken' => $answer_data['time_taken'] ?? 0,
            'answered_at' => date('Y-m-d H:i:s')
        ];
        
        // Auto-evaluate MCQ
        if (!empty($answer_data['selected_options'])) {
            $evaluation = $this->evaluate_mcq_answer($question_id, $answer_data['selected_options']);
            $data['is_correct'] = $evaluation['is_correct'];
            $data['points_earned'] = $evaluation['points_earned'];
        }
        
        return $this->db->update('interview_question_sets', $data);
    }

    /**
     * Evaluate MCQ answer
     */
    public function evaluate_mcq_answer($question_id, $selected_options) {
        // Get correct options
        $this->db->where('question_id', $question_id);
        $this->db->where('is_correct', 1);
        $correct_options = $this->db->get('question_options')->result_array();
        
        $correct_ids = array_column($correct_options, 'id');
        sort($correct_ids);
        sort($selected_options);
        
        $is_correct = ($correct_ids === $selected_options);
        
        // Get question points
        $question = $this->db->get_where('questions_bank', ['id' => $question_id])->row_array();
        $points_earned = $is_correct ? $question['points'] : 0;
        
        return [
            'is_correct' => $is_correct,
            'points_earned' => $points_earned
        ];
    }

    /**
     * Get categories
     */
    public function get_categories() {
        $this->db->where('is_active', 1);
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get('question_categories');
        return $query->result_array();
    }

    /**
     * Get roles
     */
    public function get_roles() {
        $this->db->where('is_active', 1);
        $this->db->order_by('title', 'ASC');
        $query = $this->db->get('job_roles');
        return $query->result_array();
    }

    /**
     * Get question tags
     */
    public function get_question_tags($question_id) {
        $this->db->select('question_tags.*');
        $this->db->from('question_tag_mapping');
        $this->db->join('question_tags', 'question_tags.id = question_tag_mapping.tag_id');
        $this->db->where('question_tag_mapping.question_id', $question_id);
        
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Count questions
     */
    public function count_questions($filters = []) {
        $this->db->from('questions_bank');
        
        if (!empty($filters['category_id'])) {
            $this->db->where('category_id', $filters['category_id']);
        }
        
        if (!empty($filters['role_id'])) {
            $this->db->join('question_role_mapping', 'question_role_mapping.question_id = questions_bank.id');
            $this->db->where('question_role_mapping.role_id', $filters['role_id']);
        }
        
        $this->db->where('is_active', 1);
        
        return $this->db->count_all_results();
    }

    /**
     * Get statistics
     */
    public function get_statistics() {
        $stats = [];
        
        $stats['total_questions'] = $this->db->where('is_active', 1)->count_all_results('questions_bank');
        $stats['mandatory_questions'] = $this->db->where(['is_active' => 1, 'is_mandatory' => 1])->count_all_results('questions_bank');
        $stats['mcq_questions'] = $this->db->where('is_active', 1)->where_in('question_type', ['mcq_single', 'mcq_multiple'])->count_all_results('questions_bank');
        $stats['total_categories'] = $this->db->where('is_active', 1)->count_all_results('question_categories');
        $stats['total_roles'] = $this->db->where('is_active', 1)->count_all_results('job_roles');
        
        return $stats;
    }
}
