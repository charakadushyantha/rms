<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_chatbot extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Chatbot_model');
        $this->load->library('session');
        
        // Check if user is admin
        if ($this->session->userdata('role') !== 'admin') {
            redirect('login');
        }
    }

    /**
     * View all chat sessions
     */
    public function index() {
        $data['sessions'] = $this->Chatbot_model->get_all_sessions(100);
        $this->load->view('Admin_dashboard_view/admin_chatbot_sessions', $data);
    }

    /**
     * View specific chat session
     */
    public function view_session($session_id) {
        $data['session'] = $this->Chatbot_model->get_session_details($session_id);
        
        if (!$data['session']) {
            show_404();
        }
        
        $this->load->view('Admin_dashboard_view/admin_chatbot_detail', $data);
    }

    /**
     * Get sessions as JSON (for AJAX)
     */
    public function get_sessions() {
        header('Content-Type: application/json');
        
        $sessions = $this->Chatbot_model->get_all_sessions(100);
        echo json_encode(['success' => true, 'sessions' => $sessions]);
    }
}
