<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AIService {
    
    private $api_key;
    private $model;
    private $base_url = 'https://api.openai.com/v1';
    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->model('Bot_model');
        
        // Load configuration
        $config = $this->CI->Bot_model->get_config();
        $this->api_key = $config['openai_api_key'] ?? getenv('OPENAI_API_KEY');
        $this->model = $config['ai_model'] ?? 'gpt-3.5-turbo';
    }

    /**
     * Generate response using OpenAI
     */
    public function generate_response($prompt, $context = [], $system_message = null) {
        if (empty($this->api_key)) {
            return [
                'success' => false,
                'error' => 'API key not configured'
            ];
        }

        $messages = [];

        // Add system message
        if ($system_message) {
            $messages[] = [
                'role' => 'system',
                'content' => $system_message
            ];
        } else {
            $messages[] = [
                'role' => 'system',
                'content' => $this->get_default_system_message()
            ];
        }

        // Add conversation context
        foreach ($context as $msg) {
            $messages[] = [
                'role' => $msg['sender'] === 'user' ? 'user' : 'assistant',
                'content' => $msg['message']
            ];
        }

        // Add current prompt
        $messages[] = [
            'role' => 'user',
            'content' => $prompt
        ];

        // Make API call
        $response = $this->call_api('chat/completions', [
            'model' => $this->model,
            'messages' => $messages,
            'temperature' => 0.7,
            'max_tokens' => 500
        ]);

        if ($response['success']) {
            return [
                'success' => true,
                'text' => $response['data']['choices'][0]['message']['content'],
                'usage' => $response['data']['usage']
            ];
        }

        return [
            'success' => false,
            'error' => $response['error']
        ];
    }

    /**
     * Extract structured data from CV text
     */
    public function extract_cv_data($cv_text) {
        $prompt = "Extract the following information from this CV in JSON format:\n" .
                 "- name\n- email\n- phone\n- location\n- skills (array)\n" .
                 "- experience (array of objects with title, company, duration)\n" .
                 "- education (array of objects with degree, institution, year)\n\n" .
                 "CV Text:\n{$cv_text}";

        $system_message = "You are a CV parsing assistant. Extract information accurately and return only valid JSON.";

        $response = $this->generate_response($prompt, [], $system_message);

        if ($response['success']) {
            try {
                $data = json_decode($response['text'], true);
                return ['success' => true, 'data' => $data];
            } catch (Exception $e) {
                return ['success' => false, 'error' => 'Invalid JSON response'];
            }
        }

        return $response;
    }

    /**
     * Make API call to OpenAI
     */
    private function call_api($endpoint, $data) {
        $ch = curl_init("{$this->base_url}/{$endpoint}");
        
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                "Authorization: Bearer {$this->api_key}"
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30
        ]);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code === 200) {
            return [
                'success' => true,
                'data' => json_decode($response, true)
            ];
        }

        return [
            'success' => false,
            'error' => "API Error: {$http_code}",
            'response' => $response
        ];
    }

    /**
     * Default system message for the bot
     */
    private function get_default_system_message() {
        return "You are RecruitBot, an AI assistant for a recruitment management system. " .
               "You help candidates with job applications, CV submissions, interview scheduling, " .
               "and provide information about the company and open positions. " .
               "You also assist recruiters with candidate management and scheduling. " .
               "Be professional, helpful, and concise in your responses.";
    }
}
