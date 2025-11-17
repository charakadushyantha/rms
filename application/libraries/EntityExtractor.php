<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EntityExtractor {
    
    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
    }

    /**
     * Extract entities from message based on intent
     */
    public function extract($message, $intent) {
        $entities = [];

        switch ($intent) {
            case 'apply_job':
            case 'job_inquiry':
                $entities['job_title'] = $this->extract_job_title($message);
                break;

            case 'interview_scheduling':
                $entities['date'] = $this->extract_date($message);
                $entities['time'] = $this->extract_time($message);
                break;

            case 'company_info':
                $entities['info_type'] = $this->extract_info_type($message);
                break;

            case 'general_question':
                $entities['question'] = $message;
                break;
        }

        // Extract common entities
        $entities['email'] = $this->extract_email($message);
        $entities['phone'] = $this->extract_phone($message);

        return array_filter($entities);
    }

    /**
     * Extract job title from message
     */
    private function extract_job_title($message) {
        $this->CI->load->model('Job_model');
        $jobs = $this->CI->Job_model->get_active_jobs();

        foreach ($jobs as $job) {
            $title = strtolower($job['title']);
            if (strpos(strtolower($message), $title) !== false) {
                return $job['title'];
            }
        }

        // Try to extract common job titles
        $common_titles = [
            'software engineer', 'developer', 'designer', 'manager', 
            'analyst', 'consultant', 'accountant', 'marketing', 
            'sales', 'hr', 'admin', 'intern'
        ];

        foreach ($common_titles as $title) {
            if (strpos(strtolower($message), $title) !== false) {
                return ucwords($title);
            }
        }

        return null;
    }

    /**
     * Extract date from message
     */
    private function extract_date($message) {
        // Match common date patterns
        $patterns = [
            '/\d{4}-\d{2}-\d{2}/',  // YYYY-MM-DD
            '/\d{2}\/\d{2}\/\d{4}/', // DD/MM/YYYY
            '/\d{1,2}\s+(january|february|march|april|may|june|july|august|september|october|november|december)/i',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $message, $matches)) {
                return $matches[0];
            }
        }

        // Check for relative dates
        if (preg_match('/(tomorrow|next week|next month)/i', $message, $matches)) {
            return $matches[0];
        }

        return null;
    }

    /**
     * Extract time from message
     */
    private function extract_time($message) {
        // Match time patterns
        if (preg_match('/\d{1,2}:\d{2}\s*(am|pm)?/i', $message, $matches)) {
            return $matches[0];
        }

        if (preg_match('/\d{1,2}\s*(am|pm)/i', $message, $matches)) {
            return $matches[0];
        }

        return null;
    }

    /**
     * Extract information type
     */
    private function extract_info_type($message) {
        $types = [
            'culture' => ['culture', 'environment', 'work life'],
            'location' => ['location', 'office', 'address', 'where'],
            'benefits' => ['benefits', 'perks', 'salary', 'compensation'],
            'about' => ['about', 'who are you', 'what do you do']
        ];

        foreach ($types as $type => $keywords) {
            foreach ($keywords as $keyword) {
                if (strpos(strtolower($message), $keyword) !== false) {
                    return $type;
                }
            }
        }

        return 'general';
    }

    /**
     * Extract email from message
     */
    private function extract_email($message) {
        if (preg_match('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/', $message, $matches)) {
            return $matches[0];
        }
        return null;
    }

    /**
     * Extract phone number from message
     */
    private function extract_phone($message) {
        // Sri Lankan phone patterns
        if (preg_match('/(\+94|0)?[0-9]{9,10}/', $message, $matches)) {
            return $matches[0];
        }
        return null;
    }
}
