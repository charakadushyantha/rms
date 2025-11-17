<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class IntentRecognizer {
    
    protected $CI;
    private $intents;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->model('Bot_model');
        $this->load_intents();
    }

    /**
     * Load intents from database
     */
    private function load_intents() {
        $this->intents = $this->CI->Bot_model->get_all_intents();
    }

    /**
     * Recognize intent from user message
     */
    public function recognize($message) {
        $message = strtolower(trim($message));
        $best_match = ['intent' => 'general_question', 'confidence' => 0.0];

        foreach ($this->intents as $intent) {
            $training_phrases = json_decode($intent['training_phrases'], true);
            
            if (!$training_phrases) continue;

            foreach ($training_phrases as $phrase) {
                $confidence = $this->calculate_similarity($message, strtolower($phrase));
                
                if ($confidence > $best_match['confidence']) {
                    $best_match = [
                        'intent' => $intent['intent_name'],
                        'confidence' => $confidence
                    ];
                }
            }
        }

        // Check for keyword-based patterns
        $keyword_match = $this->check_keywords($message);
        if ($keyword_match['confidence'] > $best_match['confidence']) {
            $best_match = $keyword_match;
        }

        return $best_match;
    }

    /**
     * Calculate similarity between two strings
     */
    private function calculate_similarity($str1, $str2) {
        similar_text($str1, $str2, $percent);
        
        // Boost score if key words match
        $words1 = explode(' ', $str1);
        $words2 = explode(' ', $str2);
        $common_words = count(array_intersect($words1, $words2));
        
        if ($common_words > 0) {
            $percent += ($common_words * 10);
        }

        return min($percent / 100, 1.0);
    }

    /**
     * Check for keyword-based intent patterns
     */
    private function check_keywords($message) {
        $patterns = [
            'apply_job' => ['apply', 'application', 'submit', 'cv', 'resume', 'upload', 'join', 'career'],
            'job_inquiry' => ['job', 'position', 'vacancy', 'opening', 'available', 'hiring', 'role'],
            'status_check' => ['status', 'progress', 'update', 'where is', 'application status', 'check'],
            'interview_scheduling' => ['interview', 'schedule', 'reschedule', 'appointment', 'meeting', 'date', 'time'],
            'company_info' => ['company', 'about', 'culture', 'office', 'location', 'organization', 'who are you'],
        ];

        $best_match = ['intent' => 'general_question', 'confidence' => 0.0];

        foreach ($patterns as $intent => $keywords) {
            $matches = 0;
            foreach ($keywords as $keyword) {
                if (strpos($message, $keyword) !== false) {
                    $matches++;
                }
            }

            if ($matches > 0) {
                $confidence = min($matches * 0.3, 0.9);
                if ($confidence > $best_match['confidence']) {
                    $best_match = [
                        'intent' => $intent,
                        'confidence' => $confidence
                    ];
                }
            }
        }

        return $best_match;
    }
}
