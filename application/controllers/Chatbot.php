<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chatbot extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Chatbot_model');
        $this->load->library('session');
    }

    /**
     * Send a message to the AI chatbot
     */
    public function send_message() {
        header('Content-Type: application/json');
        
        $input = json_decode(file_get_contents('php://input'), true);
        $message = isset($input['message']) ? trim($input['message']) : '';
        
        if (empty($message)) {
            echo json_encode(['success' => false, 'error' => 'Message cannot be empty']);
            return;
        }

        // Get or create session ID
        $session_id = $this->session->userdata('chat_session_id');
        if (!$session_id) {
            $session_id = $this->_generate_session_id();
            $this->session->set_userdata('chat_session_id', $session_id);
            
            // Create new chat session
            $this->Chatbot_model->create_session($session_id, [
                'user_id' => $this->session->userdata('user_id'),
                'user_type' => $this->_get_user_type(),
                'ip_address' => $this->input->ip_address(),
                'user_agent' => $this->input->user_agent()
            ]);
        }

        // Save user message
        $this->Chatbot_model->save_message($session_id, 'user', $message);

        // Get chat history for context
        $history = $this->Chatbot_model->get_session_messages($session_id, 10);

        // Get AI response
        $ai_response = $this->_get_ai_response($message, $history);

        if ($ai_response['success']) {
            // Save AI response
            $this->Chatbot_model->save_message($session_id, 'assistant', $ai_response['message']);
            
            echo json_encode([
                'success' => true,
                'message' => $ai_response['message'],
                'session_id' => $session_id
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'error' => $ai_response['error']
            ]);
        }
    }

    /**
     * Get chat history
     */
    public function get_history() {
        header('Content-Type: application/json');
        
        $session_id = $this->session->userdata('chat_session_id');
        if (!$session_id) {
            echo json_encode(['success' => true, 'messages' => []]);
            return;
        }

        $messages = $this->Chatbot_model->get_session_messages($session_id);
        echo json_encode(['success' => true, 'messages' => $messages]);
    }

    /**
     * Clear chat history
     */
    public function clear_chat() {
        header('Content-Type: application/json');
        
        $this->session->unset_userdata('chat_session_id');
        echo json_encode(['success' => true]);
    }

    /**
     * Submit feedback for a message
     */
    public function submit_feedback() {
        header('Content-Type: application/json');
        
        $input = json_decode(file_get_contents('php://input'), true);
        $message_id = isset($input['message_id']) ? (int)$input['message_id'] : 0;
        $rating = isset($input['rating']) ? (int)$input['rating'] : null;
        
        $session_id = $this->session->userdata('chat_session_id');
        
        if ($message_id && $session_id) {
            $this->Chatbot_model->save_feedback($message_id, $session_id, $rating);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Invalid request']);
        }
    }

    /**
     * Get AI response from OpenAI or other provider
     */
    private function _get_ai_response($message, $history = []) {
        // Load configuration
        $this->config->load('chatbot', TRUE);
        $config = $this->config->item('chatbot');
        
        $api_key = $config['api_key'] ?? '';
        $model = $config['model'] ?? 'gpt-3.5-turbo';
        $provider = $config['provider'] ?? 'openai';

        if (empty($api_key)) {
            return [
                'success' => false,
                'error' => 'AI service not configured. Please set API key in config.'
            ];
        }

        // Build conversation context
        $messages = [
            [
                'role' => 'system',
                'content' => $this->_get_system_prompt()
            ]
        ];

        // Add recent history
        foreach (array_slice($history, -5) as $msg) {
            $messages[] = [
                'role' => $msg['role'],
                'content' => $msg['message']
            ];
        }

        // Add current message
        $messages[] = [
            'role' => 'user',
            'content' => $message
        ];

        // Call AI API based on provider
        if ($provider === 'openai') {
            return $this->_call_openai($api_key, $model, $messages);
        } else {
            return [
                'success' => false,
                'error' => 'Unsupported AI provider'
            ];
        }
    }

    /**
     * Call OpenAI API
     */
    private function _call_openai($api_key, $model, $messages) {
        $ch = curl_init('https://api.openai.com/v1/chat/completions');
        
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $api_key
            ],
            CURLOPT_POSTFIELDS => json_encode([
                'model' => $model,
                'messages' => $messages,
                'temperature' => 0.7,
                'max_tokens' => 500
            ])
        ]);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code === 200) {
            $data = json_decode($response, true);
            return [
                'success' => true,
                'message' => $data['choices'][0]['message']['content'] ?? 'No response'
            ];
        } else {
            log_message('error', 'OpenAI API Error: ' . $response);
            return [
                'success' => false,
                'error' => 'Failed to get AI response. Please try again.'
            ];
        }
    }

    /**
     * Get system prompt for the AI
     */
    private function _get_system_prompt() {
        return "You are a helpful Recruitment Officer AI assistant for a recruitment management system. Your role is to:
- Answer questions about job openings and application process
- Guide candidates through the application steps
- Provide information about company culture and benefits
- Help with resume tips and interview preparation
- Answer FAQs about recruitment timeline and process
- Be professional, friendly, and encouraging
- If you don't know something, be honest and suggest contacting HR directly

Keep responses concise and helpful. Always maintain a professional yet warm tone.";
    }

    /**
     * Generate unique session ID
     */
    private function _generate_session_id() {
        return 'chat_' . uniqid() . '_' . bin2hex(random_bytes(8));
    }

    /**
     * Get current user type
     */
    private function _get_user_type() {
        if ($this->session->userdata('user_id')) {
            $role = $this->session->userdata('role');
            if ($role === 'admin') return 'admin';
            if ($role === 'recruiter') return 'recruiter';
            return 'candidate';
        }
        return 'guest';
    }
}
