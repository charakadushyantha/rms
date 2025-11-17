<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Questions_bank extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Questions_bank_model');
        $this->load->library('session');
        
        // Check authentication
        if (!$this->session->userdata('authenticated')) {
            redirect('login');
        }
    }

    /**
     * Questions Bank Dashboard
     */
    public function index() {
        $data['title'] = 'Questions Bank';
        $data['uname'] = $this->session->userdata('username');
        
        // Get filters
        $filters = [
            'category_id' => $this->input->get('category'),
            'difficulty' => $this->input->get('difficulty'),
            'question_type' => $this->input->get('type'),
            'role_id' => $this->input->get('role'),
            'search' => $this->input->get('search')
        ];
        
        // Pagination
        $page = $this->input->get('page') ?? 1;
        $per_page = 20;
        $offset = ($page - 1) * $per_page;
        
        // Get questions
        $data['questions'] = $this->Questions_bank_model->get_all_questions($filters, $per_page, $offset);
        $data['total_questions'] = $this->Questions_bank_model->count_questions($filters);
        $data['total_pages'] = ceil($data['total_questions'] / $per_page);
        $data['page'] = $page;
        
        // Get filter options
        $data['categories'] = $this->Questions_bank_model->get_categories();
        $data['roles'] = $this->Questions_bank_model->get_roles();
        
        // Get statistics
        $data['stats'] = $this->Questions_bank_model->get_statistics();
        
        $this->load->view('templates/admin_header', $data);
        $this->load->view('questions_bank/index', $data);
        $this->load->view('templates/admin_footer');
    }

    /**
     * Add Question Form
     */
    public function add() {
        $data['title'] = 'Add Question';
        $data['uname'] = $this->session->userdata('username');
        
        if ($this->input->post()) {
            $this->_save_question();
            return;
        }
        
        $data['categories'] = $this->Questions_bank_model->get_categories();
        $data['roles'] = $this->Questions_bank_model->get_roles();
        
        $this->load->view('templates/admin_header', $data);
        $this->load->view('questions_bank/add', $data);
        $this->load->view('templates/admin_footer');
    }

    /**
     * Edit Question
     */
    public function edit($id) {
        $data['title'] = 'Edit Question';
        $data['uname'] = $this->session->userdata('username');
        
        $data['question'] = $this->Questions_bank_model->get_question($id);
        
        if (!$data['question']) {
            show_404();
        }
        
        if ($this->input->post()) {
            $this->_save_question($id);
            return;
        }
        
        $data['categories'] = $this->Questions_bank_model->get_categories();
        $data['roles'] = $this->Questions_bank_model->get_roles();
        
        $this->load->view('templates/admin_header', $data);
        $this->load->view('questions_bank/edit', $data);
        $this->load->view('templates/admin_footer');
    }

    /**
     * View Question
     */
    public function view($id) {
        $data['title'] = 'View Question';
        $data['uname'] = $this->session->userdata('username');
        
        $data['question'] = $this->Questions_bank_model->get_question($id);
        
        if (!$data['question']) {
            show_404();
        }
        
        $this->load->view('templates/admin_header', $data);
        $this->load->view('questions_bank/view', $data);
        $this->load->view('templates/admin_footer');
    }

    /**
     * Delete Question
     */
    public function delete($id) {
        if ($this->Questions_bank_model->delete_question($id)) {
            $this->session->set_flashdata('success', 'Question deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete question');
        }
        
        redirect('questions_bank');
    }

    /**
     * Save Question (Create or Update)
     */
    private function _save_question($id = null) {
        $question_data = [
            'question_text' => $this->input->post('question_text'),
            'question_type' => $this->input->post('question_type'),
            'category_id' => $this->input->post('category_id'),
            'difficulty' => $this->input->post('difficulty'),
            'points' => $this->input->post('points'),
            'time_limit' => $this->input->post('time_limit'),
            'is_mandatory' => $this->input->post('is_mandatory') ? 1 : 0,
            'created_by' => $this->session->userdata('id')
        ];
        
        if ($id) {
            // Update
            $this->Questions_bank_model->update_question($id, $question_data);
            $question_id = $id;
            $message = 'Question updated successfully';
        } else {
            // Create
            $question_id = $this->Questions_bank_model->create_question($question_data);
            $message = 'Question added successfully';
        }
        
        // Handle MCQ options
        if (in_array($question_data['question_type'], ['mcq_single', 'mcq_multiple'])) {
            // Delete existing options if updating
            if ($id) {
                $this->Questions_bank_model->delete_question_options($question_id);
            }
            
            $options = $this->input->post('options');
            $correct_options = $this->input->post('correct_options') ?? [];
            
            if ($options) {
                foreach ($options as $index => $option_text) {
                    if (!empty($option_text)) {
                        $is_correct = in_array($index, $correct_options) ? 1 : 0;
                        $this->Questions_bank_model->add_option($question_id, $option_text, $is_correct, $index);
                    }
                }
            }
        }
        
        // Handle role mappings
        if ($id) {
            $this->Questions_bank_model->delete_question_role_mappings($question_id);
        }
        
        $roles = $this->input->post('roles') ?? [];
        foreach ($roles as $role_id) {
            $this->Questions_bank_model->map_question_to_role($question_id, $role_id);
        }
        
        $this->session->set_flashdata('success', $message);
        redirect('questions_bank');
    }

    /**
     * Generate Question Set for Interview
     */
    public function generate_set() {
        header('Content-Type: application/json');
        
        $role_id = $this->input->post('role_id');
        $num_questions = $this->input->post('num_questions') ?? 10;
        
        $questions = $this->Questions_bank_model->generate_question_set($role_id, $num_questions);
        
        echo json_encode([
            'success' => true,
            'questions' => $questions,
            'count' => count($questions)
        ]);
    }

    /**
     * Categories Management
     */
    public function categories() {
        $data['title'] = 'Question Categories';
        $data['uname'] = $this->session->userdata('username');
        $data['categories'] = $this->Questions_bank_model->get_categories();
        
        $this->load->view('templates/admin_header', $data);
        $this->load->view('questions_bank/categories', $data);
        $this->load->view('templates/admin_footer');
    }

    /**
     * Roles Management
     */
    public function roles() {
        $data['title'] = 'Job Roles';
        $data['uname'] = $this->session->userdata('username');
        $data['roles'] = $this->Questions_bank_model->get_roles();
        
        $this->load->view('templates/admin_header', $data);
        $this->load->view('questions_bank/roles', $data);
        $this->load->view('templates/admin_footer');
    }
}
