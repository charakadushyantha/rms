<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bot extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Bot_model');
        $this->load->model('Chat_history_model');
        $this->load->model('Candidate_model');
        $this->load->library('BotEngine');
        $this->load->library('CvParser');
        $this->load->helper('bot_helper');
    }

    /**
     * Display chat interface (standalone page)
     */
    public function index() {
        $data['title'] = 'AI Recruitment Assistant';
        $user_id = $this->session->userdata('user_id');
        
        if ($user_id) {
            $data['chat_history'] = $this->Chat_history_model->get_user_chats($user_id);
        }
        
        // Load standalone chat interface (no header/footer wrapper)
        $this->load->view('bot/chat_interface', $data);
    }

    /**
     * Process incoming message from user
     */
    public function send_message() {
        header('Content-Type: application/json');
        
        if (!$this->input->post('message')) {
            echo json_encode(['success' => false, 'error' => 'No message provided']);
            return;
        }

        $user_id = $this->session->userdata('user_id');
        $user_message = $this->input->post('message');
        $session_id = $this->input->post('session_id') ?: $this->generate_session_id();

        // Save user message
        $this->Chat_history_model->save_message([
            'session_id' => $session_id,
            'user_id' => $user_id,
            'sender' => 'user',
            'message' => $user_message,
            'timestamp' => date('Y-m-d H:i:s')
        ]);

        // Process with AI Bot Engine
        $bot_response = $this->botengine->process_message($user_message, $user_id, $session_id);

        // Save bot response
        $this->Chat_history_model->save_message([
            'session_id' => $session_id,
            'user_id' => $user_id,
            'sender' => 'bot',
            'message' => $bot_response['message'],
            'intent' => $bot_response['intent'],
            'confidence' => $bot_response['confidence'],
            'timestamp' => date('Y-m-d H:i:s')
        ]);

        echo json_encode([
            'success' => true,
            'message' => $bot_response['message'],
            'actions' => $bot_response['actions'] ?? [],
            'suggestions' => $bot_response['suggestions'] ?? []
        ]);
    }

    /**
     * Handle CV upload and processing
     */
    public function upload_cv() {
        header('Content-Type: application/json');
        
        $config['upload_path'] = './uploads/cvs/';
        $config['allowed_types'] = 'pdf|doc|docx|txt|jpg|png';
        $config['max_size'] = 5120; // 5MB
        $config['encrypt_name'] = TRUE;

        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, true);
        }

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('cv_file')) {
            echo json_encode([
                'success' => false,
                'error' => strip_tags($this->upload->display_errors())
            ]);
            return;
        }

        $upload_data = $this->upload->data();
        $file_path = $upload_data['full_path'];

        // Parse CV
        $cv_data = $this->cvparser->parse($file_path);

        if ($cv_data['success']) {
            // Create or update candidate profile
            $candidate_id = $this->Candidate_model->create_from_cv($cv_data['data']);

            $response_message = "Thank you for uploading your CV! I've successfully processed it. ";
            
            if (!empty($cv_data['data']['skills']['technical'])) {
                $top_skills = array_slice($cv_data['data']['skills']['technical'], 0, 3);
                $response_message .= "I found that you have experience in " . implode(', ', $top_skills) . ". ";
            }
            
            $response_message .= "Would you like me to suggest suitable job positions?";

            echo json_encode([
                'success' => true,
                'message' => $response_message,
                'candidate_id' => $candidate_id,
                'extracted_data' => $cv_data['data']
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'error' => 'Failed to parse CV. Please ensure it\'s in a supported format.'
            ]);
        }
    }

    /**
     * Chat interface within dashboard (embedded version)
     */
    public function chat() {
        // Check authentication
        if (!$this->session->userdata('authenticated')) {
            redirect('login');
        }

        $data['title'] = 'AI Chat Assistant';
        $data['uname'] = $this->session->userdata('username');
        
        $this->load->view('templates/admin_header', $data);
        $this->load->view('bot/chat_widget', $data);
        $this->load->view('templates/admin_footer');
    }

    /**
     * Get chat widget for embedding
     */
    public function widget() {
        $this->load->view('bot/chat_widget');
    }

    /**
     * Admin dashboard for bot management
     */
    public function admin_dashboard() {
        if ($this->session->userdata('role') !== 'admin') {
            redirect('login');
        }

        $data['title'] = 'Bot Management Dashboard';
        $data['stats'] = $this->Bot_model->get_statistics();
        $data['recent_conversations'] = $this->Chat_history_model->get_recent(20);
        $data['intents_analysis'] = $this->Bot_model->analyze_intents();

        $this->load->view('templates/header', $data);
        $this->load->view('bot/admin_dashboard', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Generate unique session ID
     */
    private function generate_session_id() {
        return 'session_' . uniqid() . '_' . time();
    }
}
