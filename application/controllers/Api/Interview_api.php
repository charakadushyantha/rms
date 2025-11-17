<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Interview API Controller
 * Handles interview flow creation, management, and retrieval
 */
class Interview_api extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Interview_flow_model');
        $this->load->model('Interview_model');
        $this->load->helper('api_helper');
        
        // Set JSON header
        header('Content-Type: application/json');
        
        // Enable CORS if needed
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        
        // Handle preflight requests
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit();
        }
    }

    /**
     * Create Interview Flow
     * POST /api/interview-flows
     */
    public function create_flow() {
        // Validate API key
        if (!$this->validate_api_key()) {
            return $this->response(['error' => 'Invalid API key'], 401);
        }

        // Get JSON input
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!$input) {
            $input = $this->input->post();
        }

        // Validate required fields
        $required = ['job_title', 'questions', 'interview_type'];
        foreach ($required as $field) {
            if (empty($input[$field])) {
                return $this->response(['error' => "Missing required field: $field"], 400);
            }
        }

        // Prepare data
        $data = [
            'job_title' => $input['job_title'],
            'job_description' => $input['job_description'] ?? '',
            'questions' => is_array($input['questions']) ? json_encode($input['questions']) : $input['questions'],
            'interview_type' => $input['interview_type'], // 'video', 'audio', 'text'
            'enable_video_capture' => isset($input['enable_video_capture']) ? (bool)$input['enable_video_capture'] : false,
            'duration_minutes' => $input['duration_minutes'] ?? 30,
            'passing_score' => $input['passing_score'] ?? 70,
            'status' => 'active',
            'created_by' => $this->get_api_user_id(),
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Create interview flow
        $flow_id = $this->Interview_flow_model->create($data);

        if ($flow_id) {
            $flow = $this->Interview_flow_model->get_by_id($flow_id);
            return $this->response([
                'success' => true,
                'message' => 'Interview flow created successfully',
                'data' => $flow
            ], 201);
        } else {
            return $this->response(['error' => 'Failed to create interview flow'], 500);
        }
    }

    /**
     * Get Interview Flows
     * GET /api/interview-flows
     */
    public function get_flows() {
        if (!$this->validate_api_key()) {
            return $this->response(['error' => 'Invalid API key'], 401);
        }

        $status = $this->input->get('status');
        $limit = $this->input->get('limit') ?? 50;
        $offset = $this->input->get('offset') ?? 0;

        $flows = $this->Interview_flow_model->get_all($status, $limit, $offset);
        $total = $this->Interview_flow_model->count_all($status);

        return $this->response([
            'success' => true,
            'data' => $flows,
            'pagination' => [
                'total' => $total,
                'limit' => (int)$limit,
                'offset' => (int)$offset
            ]
        ]);
    }

    /**
     * Get Single Interview Flow
     * GET /api/interview-flows/:id
     */
    public function get_flow($id) {
        if (!$this->validate_api_key()) {
            return $this->response(['error' => 'Invalid API key'], 401);
        }

        $flow = $this->Interview_flow_model->get_by_id($id);

        if ($flow) {
            return $this->response([
                'success' => true,
                'data' => $flow
            ]);
        } else {
            return $this->response(['error' => 'Interview flow not found'], 404);
        }
    }

    /**
     * Create Interview & Generate Link
     * POST /api/interviews
     */
    public function create_interview() {
        if (!$this->validate_api_key()) {
            return $this->response(['error' => 'Invalid API key'], 401);
        }

        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!$input) {
            $input = $this->input->post();
        }

        // Validate required fields
        if (empty($input['flow_id']) || empty($input['candidate_email'])) {
            return $this->response(['error' => 'Missing required fields: flow_id, candidate_email'], 400);
        }

        // Check if flow exists
        $flow = $this->Interview_flow_model->get_by_id($input['flow_id']);
        if (!$flow) {
            return $this->response(['error' => 'Interview flow not found'], 404);
        }

        // Generate unique token
        $token = $this->generate_interview_token();

        // Prepare data
        $data = [
            'flow_id' => $input['flow_id'],
            'candidate_name' => $input['candidate_name'] ?? '',
            'candidate_email' => $input['candidate_email'],
            'candidate_phone' => $input['candidate_phone'] ?? '',
            'token' => $token,
            'status' => 'pending',
            'expires_at' => date('Y-m-d H:i:s', strtotime('+7 days')),
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Create interview
        $interview_id = $this->Interview_model->create($data);

        if ($interview_id) {
            $interview = $this->Interview_model->get_by_id($interview_id);
            
            // Generate interview link
            $interview_link = base_url("interview/take/$token");

            // Send email to candidate (optional)
            if (!empty($input['send_email']) && $input['send_email']) {
                $this->send_interview_email($interview, $interview_link);
            }

            return $this->response([
                'success' => true,
                'message' => 'Interview created successfully',
                'data' => [
                    'interview_id' => $interview_id,
                    'token' => $token,
                    'interview_link' => $interview_link,
                    'expires_at' => $data['expires_at'],
                    'interview' => $interview
                ]
            ], 201);
        } else {
            return $this->response(['error' => 'Failed to create interview'], 500);
        }
    }

    /**
     * Get Interviews
     * GET /api/interviews
     */
    public function get_interviews() {
        if (!$this->validate_api_key()) {
            return $this->response(['error' => 'Invalid API key'], 401);
        }

        $flow_id = $this->input->get('flow_id');
        $status = $this->input->get('status');
        $limit = $this->input->get('limit') ?? 50;
        $offset = $this->input->get('offset') ?? 0;

        $interviews = $this->Interview_model->get_all($flow_id, $status, $limit, $offset);
        $total = $this->Interview_model->count_all($flow_id, $status);

        return $this->response([
            'success' => true,
            'data' => $interviews,
            'pagination' => [
                'total' => $total,
                'limit' => (int)$limit,
                'offset' => (int)$offset
            ]
        ]);
    }

    /**
     * Get Single Interview with Transcript
     * GET /api/interviews/:id
     */
    public function get_interview($id) {
        if (!$this->validate_api_key()) {
            return $this->response(['error' => 'Invalid API key'], 401);
        }

        $interview = $this->Interview_model->get_by_id($id);

        if ($interview) {
            // Include responses/transcript
            $interview['responses'] = $this->Interview_model->get_responses($id);
            
            return $this->response([
                'success' => true,
                'data' => $interview
            ]);
        } else {
            return $this->response(['error' => 'Interview not found'], 404);
        }
    }

    /**
     * Update Interview Status
     * PUT /api/interviews/:id/status
     */
    public function update_status($id) {
        if (!$this->validate_api_key()) {
            return $this->response(['error' => 'Invalid API key'], 401);
        }

        $input = json_decode(file_get_contents('php://input'), true);
        
        if (empty($input['status'])) {
            return $this->response(['error' => 'Missing required field: status'], 400);
        }

        $allowed_statuses = ['pending', 'in_progress', 'completed', 'cancelled', 'expired'];
        if (!in_array($input['status'], $allowed_statuses)) {
            return $this->response(['error' => 'Invalid status'], 400);
        }

        $updated = $this->Interview_model->update_status($id, $input['status']);

        if ($updated) {
            return $this->response([
                'success' => true,
                'message' => 'Interview status updated successfully'
            ]);
        } else {
            return $this->response(['error' => 'Failed to update interview status'], 500);
        }
    }

    /**
     * Validate API Key
     */
    private function validate_api_key() {
        $api_key = $this->input->get_request_header('Authorization');
        
        if (!$api_key) {
            $api_key = $this->input->get('api_key');
        }

        if ($api_key && strpos($api_key, 'Bearer ') === 0) {
            $api_key = substr($api_key, 7);
        }

        // For now, accept any key (you can implement proper validation)
        // In production, validate against database
        return !empty($api_key);
    }

    /**
     * Get API User ID
     */
    private function get_api_user_id() {
        // Get from session or API key mapping
        return $this->session->userdata('user_id') ?? 1;
    }

    /**
     * Generate Interview Token
     */
    private function generate_interview_token() {
        return bin2hex(random_bytes(32));
    }

    /**
     * Send Interview Email
     */
    private function send_interview_email($interview, $link) {
        $this->load->library('email');
        
        $this->email->from('noreply@rms.com', 'RMS Interview System');
        $this->email->to($interview['candidate_email']);
        $this->email->subject('Your Interview Link - ' . $interview['job_title']);
        
        $message = "Dear " . ($interview['candidate_name'] ?: 'Candidate') . ",\n\n";
        $message .= "You have been invited to complete an interview for the position: " . $interview['job_title'] . "\n\n";
        $message .= "Please click the link below to start your interview:\n";
        $message .= $link . "\n\n";
        $message .= "This link will expire on: " . $interview['expires_at'] . "\n\n";
        $message .= "Best regards,\nRMS Team";
        
        $this->email->message($message);
        $this->email->send();
    }

    /**
     * Send JSON Response
     */
    private function response($data, $status_code = 200) {
        http_response_code($status_code);
        echo json_encode($data);
        exit();
    }
}
