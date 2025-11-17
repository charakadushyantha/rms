<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BotEngine {
    
    protected $CI;
    private $ai_service;
    private $intent_recognizer;
    private $entity_extractor;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->library('AIService');
        $this->CI->load->library('IntentRecognizer');
        $this->CI->load->library('EntityExtractor');
        $this->CI->load->model('Bot_model');
        $this->CI->load->model('Knowledge_base_model');
        
        $this->ai_service = $this->CI->aiservice;
        $this->intent_recognizer = $this->CI->intentrecognizer;
        $this->entity_extractor = $this->CI->entityextractor;
    }

    /**
     * Process user message and generate response
     */
    public function process_message($message, $user_id, $session_id) {
        // Step 1: Recognize intent
        $intent_result = $this->intent_recognizer->recognize($message);
        $intent = $intent_result['intent'];
        $confidence = $intent_result['confidence'];

        // Step 2: Extract entities
        $entities = $this->entity_extractor->extract($message, $intent);

        // Step 3: Get conversation context
        $context = $this->get_conversation_context($session_id);

        // Step 4: Generate response based on intent
        $response = $this->generate_response($intent, $entities, $context, $user_id);

        return [
            'message' => $response['text'],
            'intent' => $intent,
            'confidence' => $confidence,
            'actions' => $response['actions'] ?? [],
            'suggestions' => $response['suggestions'] ?? []
        ];
    }

    /**
     * Generate contextual response
     */
    private function generate_response($intent, $entities, $context, $user_id) {
        switch ($intent) {
            case 'apply_job':
                return $this->handle_job_application($entities, $user_id);
            
            case 'job_inquiry':
                return $this->handle_job_inquiry($entities);
            
            case 'status_check':
                return $this->handle_status_check($user_id);
            
            case 'interview_scheduling':
                return $this->handle_interview_scheduling($entities, $user_id);
            
            case 'company_info':
                return $this->handle_company_info($entities);
            
            case 'general_question':
                return $this->handle_general_question($entities);
            
            default:
                return $this->handle_fallback();
        }
    }

    /**
     * Handle job application intent
     */
    private function handle_job_application($entities, $user_id) {
        $this->CI->load->model('Job_model');

        if (isset($entities['job_title'])) {
            $job = $this->CI->Job_model->find_by_title($entities['job_title']);
            
            if ($job) {
                return [
                    'text' => "Great! I can help you apply for the {$job['title']} position. Please upload your CV and I'll process your application.",
                    'actions' => [
                        ['type' => 'request_cv_upload', 'job_id' => $job['id']]
                    ],
                    'suggestions' => [
                        'Upload CV',
                        'Tell me more about this role',
                        'What are the requirements?'
                    ]
                ];
            }
        }

        $jobs = $this->CI->Job_model->get_active_jobs(5);
        
        if (empty($jobs)) {
            return [
                'text' => "We don't have any open positions listed at the moment, but you can still submit your CV for future opportunities! Our team reviews all applications and will contact you when suitable positions become available.",
                'suggestions' => ['Upload CV', 'Tell me about the company', 'Contact us']
            ];
        }

        $job_list = array_map(function($job) {
            $location = isset($job['location']) ? $job['location'] : 'Location TBD';
            return "• {$job['title']} - {$location}";
        }, $jobs);

        return [
            'text' => "Here are our current openings:\n\n" . implode("\n", $job_list) . "\n\nWhich position interests you?",
            'suggestions' => array_column($jobs, 'title')
        ];
    }

    /**
     * Handle job inquiry intent
     */
    private function handle_job_inquiry($entities) {
        $this->CI->load->model('Job_model');

        if (isset($entities['job_title'])) {
            $job = $this->CI->Job_model->find_by_title($entities['job_title']);
            
            if ($job) {
                $text = "**{$job['title']}**\n\n";
                $text .= "📍 Location: {$job['location']}\n";
                $text .= "💼 Type: {$job['employment_type']}\n\n";
                $text .= "**Description:**\n{$job['description']}\n\n";
                $text .= "**Requirements:**\n{$job['requirements']}";

                return [
                    'text' => $text,
                    'suggestions' => ['Apply for this job', 'View other positions', 'Ask a question']
                ];
            }
        }

        $jobs = $this->CI->Job_model->get_active_jobs();
        $job_list = array_map(function($job) {
            return "• {$job['title']} ({$job['location']})";
        }, $jobs);

        return [
            'text' => "We have the following positions available:\n\n" . implode("\n", $job_list) . "\n\nWhich one would you like to know more about?",
            'suggestions' => array_column($jobs, 'title')
        ];
    }

    /**
     * Handle status check intent
     */
    private function handle_status_check($user_id) {
        if (!$user_id) {
            return [
                'text' => "To check your application status, please log in first or provide your email address.",
                'suggestions' => ['Login', 'Provide email']
            ];
        }

        $this->CI->load->model('Candidate_model');
        $applications = $this->CI->Candidate_model->get_by_user($user_id);

        if (empty($applications)) {
            return [
                'text' => "I don't see any applications from you yet. Would you like to apply for one of our open positions?",
                'suggestions' => ['View open positions', 'Upload my CV']
            ];
        }

        $status_text = "Here's the status of your applications:\n\n";
        foreach ($applications as $app) {
            $status_text .= "• {$app['position']} - Status: **{$app['status']}**\n";
            if (!empty($app['interview_date'])) {
                $status_text .= "  📅 Interview: {$app['interview_date']}\n";
            }
        }

        return [
            'text' => $status_text,
            'actions' => [
                ['type' => 'show_application_details', 'applications' => $applications]
            ],
            'suggestions' => ['View details', 'Ask a question']
        ];
    }

    /**
     * Handle interview scheduling
     */
    private function handle_interview_scheduling($entities, $user_id) {
        return [
            'text' => "I can help you with interview scheduling. Please let me know:\n1. Your preferred date and time\n2. Any specific requirements or constraints",
            'suggestions' => ['Check my interview', 'Reschedule interview']
        ];
    }

    /**
     * Handle company information
     */
    private function handle_company_info($entities) {
        $this->CI->load->model('Knowledge_base_model');
        $info = $this->CI->Knowledge_base_model->get_by_category('company');

        if ($info) {
            return [
                'text' => $info['answer'],
                'suggestions' => ['View jobs', 'Company benefits', 'Office location']
            ];
        }

        return [
            'text' => "We are a leading recruitment management company helping businesses find the best talent. Would you like to know more about our open positions?",
            'suggestions' => ['View jobs', 'Apply now']
        ];
    }

    /**
     * Handle general questions
     */
    private function handle_general_question($entities) {
        $this->CI->load->model('Knowledge_base_model');
        $answer = $this->CI->Knowledge_base_model->search($entities['question'] ?? '');

        if ($answer) {
            return [
                'text' => $answer['answer'],
                'suggestions' => ['Ask another question', 'View jobs']
            ];
        }

        return $this->handle_fallback();
    }

    /**
     * Get conversation context from history
     */
    private function get_conversation_context($session_id) {
        $this->CI->load->model('Chat_history_model');
        return $this->CI->Chat_history_model->get_context($session_id, 5);
    }

    /**
     * Fallback response for unrecognized intents
     */
    private function handle_fallback() {
        return [
            'text' => "I'm not sure I understood that. I can help you with:\n\n" .
                     "• Job applications and CV submission\n" .
                     "• Checking your application status\n" .
                     "• Interview scheduling\n" .
                     "• Information about our company and positions\n\n" .
                     "What would you like to know?",
            'suggestions' => [
                'Apply for a job',
                'Check my status',
                'View open positions',
                'Company information'
            ]
        ];
    }
}
