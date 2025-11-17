<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Interview Controller
 * Manages interview flows and interviews in the web application
 */
class Interview extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Interview_flow_model');
        $this->load->model('Interview_model');
        $this->load->library('session');
        
        // Check if user is logged in
        if (!$this->session->userdata('authenticated')) {
            redirect('login');
        }
    }

    /**
     * Interview Dashboard
     */
    public function index() {
        $data['title'] = 'Interview Management';
        $data['uname'] = $this->session->userdata('username');
        $data['flows'] = $this->Interview_flow_model->get_all('active', 100, 0);
        $data['recent_interviews'] = $this->Interview_model->get_all(null, null, 10, 0);
        $data['statistics'] = $this->Interview_model->get_statistics();
        
        $this->load->view('templates/admin_header', $data);
        $this->load->view('interview/dashboard', $data);
        $this->load->view('templates/admin_footer');
    }
    
    /**
     * Comprehensive Interview Management Dashboard
     */
    public function management() {
        // Check authentication
        if (!$this->session->userdata('authenticated')) {
            redirect('login');
        }
        
        $data['title'] = 'Interview Management';
        $data['uname'] = $this->session->userdata('username');
        
        // Get statistics
        $data['stats'] = [
            'scheduled' => $this->Interview_model->count_by_status('pending'),
            'completed' => $this->Interview_model->count_by_status('completed'),
            'pending' => $this->Interview_model->count_by_status('in_progress'),
            'cancelled' => $this->Interview_model->count_by_status('cancelled')
        ];
        
        // Get all interviews with pagination
        $page = $this->input->get('page') ?? 1;
        $per_page = 10;
        $offset = ($page - 1) * $per_page;
        
        $data['interviews'] = $this->Interview_model->get_all(null, null, $per_page, $offset);
        $data['total_interviews'] = $this->Interview_model->count_all();
        $data['total_pages'] = ceil($data['total_interviews'] / $per_page);
        $data['page'] = $page;
        
        // Get unique positions for filter
        $data['positions'] = $this->Interview_model->get_unique_positions();
        
        // Get today's interviews
        $data['today_interviews'] = $this->Interview_model->get_today_interviews();
        
        // Get upcoming interviews this week
        $data['upcoming_interviews'] = $this->Interview_model->get_upcoming_week();
        
        // Load the comprehensive management view
        $this->load->view('interview/management_dashboard', $data);
    }

    /**
     * Interview Flows List
     */
    public function flows() {
        $data['title'] = 'Interview Flows';
        $data['uname'] = $this->session->userdata('username');
        $data['flows'] = $this->Interview_flow_model->get_all(null, 100, 0);
        
        $this->load->view('templates/admin_header', $data);
        $this->load->view('interview/flows_list', $data);
        $this->load->view('templates/admin_footer');
    }

    /**
     * Create Interview Flow
     */
    public function create_flow() {
        $data['title'] = 'Create Interview Flow';
        $data['uname'] = $this->session->userdata('username');
        
        if ($this->input->post()) {
            $questions = [];
            $question_texts = $this->input->post('questions');
            $question_durations = $this->input->post('durations');
            
            if ($question_texts) {
                foreach ($question_texts as $index => $text) {
                    if (!empty($text)) {
                        $questions[] = [
                            'id' => $index + 1,
                            'question' => $text,
                            'type' => 'open',
                            'duration' => (int)($question_durations[$index] ?? 120)
                        ];
                    }
                }
            }
            
            $flow_data = [
                'job_title' => $this->input->post('job_title'),
                'job_description' => $this->input->post('job_description'),
                'questions' => json_encode($questions),
                'interview_type' => $this->input->post('interview_type'),
                'enable_video_capture' => $this->input->post('enable_video_capture') ? 1 : 0,
                'duration_minutes' => $this->input->post('duration_minutes'),
                'passing_score' => $this->input->post('passing_score'),
                'status' => 'active',
                'created_by' => $this->session->userdata('id'),
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $flow_id = $this->Interview_flow_model->create($flow_data);
            
            if ($flow_id) {
                $this->session->set_flashdata('success', 'Interview flow created successfully!');
                redirect('interview/flows');
            } else {
                $this->session->set_flashdata('error', 'Failed to create interview flow.');
            }
        }
        
        $this->load->view('templates/admin_header', $data);
        $this->load->view('interview/create_flow', $data);
        $this->load->view('templates/admin_footer');
    }

    /**
     * Edit Interview Flow
     */
    public function edit_flow($id) {
        $data['title'] = 'Edit Interview Flow';
        $data['uname'] = $this->session->userdata('username');
        $data['flow'] = $this->Interview_flow_model->get_by_id($id);
        
        if (!$data['flow']) {
            show_404();
        }
        
        if ($this->input->post()) {
            $questions = [];
            $question_texts = $this->input->post('questions');
            $question_durations = $this->input->post('durations');
            
            if ($question_texts) {
                foreach ($question_texts as $index => $text) {
                    if (!empty($text)) {
                        $questions[] = [
                            'id' => $index + 1,
                            'question' => $text,
                            'type' => 'open',
                            'duration' => (int)($question_durations[$index] ?? 120)
                        ];
                    }
                }
            }
            
            $flow_data = [
                'job_title' => $this->input->post('job_title'),
                'job_description' => $this->input->post('job_description'),
                'questions' => json_encode($questions),
                'interview_type' => $this->input->post('interview_type'),
                'enable_video_capture' => $this->input->post('enable_video_capture') ? 1 : 0,
                'duration_minutes' => $this->input->post('duration_minutes'),
                'passing_score' => $this->input->post('passing_score'),
                'status' => $this->input->post('status')
            ];
            
            if ($this->Interview_flow_model->update($id, $flow_data)) {
                $this->session->set_flashdata('success', 'Interview flow updated successfully!');
                redirect('interview/flows');
            } else {
                $this->session->set_flashdata('error', 'Failed to update interview flow.');
            }
        }
        
        $this->load->view('templates/admin_header', $data);
        $this->load->view('interview/edit_flow', $data);
        $this->load->view('templates/admin_footer');
    }

    /**
     * Interviews List
     */
    public function interviews() {
        $flow_id = $this->input->get('flow_id');
        $status = $this->input->get('status');
        
        $data['title'] = 'Interviews';
        $data['uname'] = $this->session->userdata('username');
        $data['interviews'] = $this->Interview_model->get_all($flow_id, $status, 100, 0);
        $data['flows'] = $this->Interview_flow_model->get_active();
        
        $this->load->view('templates/admin_header', $data);
        $this->load->view('interview/interviews_list', $data);
        $this->load->view('templates/admin_footer');
    }

    /**
     * Create Interview
     */
    public function create_interview() {
        $data['title'] = 'Create Interview';
        $data['uname'] = $this->session->userdata('username');
        $data['flows'] = $this->Interview_flow_model->get_active();
        
        if ($this->input->post()) {
            $token = bin2hex(random_bytes(32));
            
            $interview_data = [
                'flow_id' => $this->input->post('flow_id'),
                'candidate_name' => $this->input->post('candidate_name'),
                'candidate_email' => $this->input->post('candidate_email'),
                'candidate_phone' => $this->input->post('candidate_phone'),
                'token' => $token,
                'status' => 'pending',
                'expires_at' => date('Y-m-d H:i:s', strtotime('+7 days')),
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $interview_id = $this->Interview_model->create($interview_data);
            
            if ($interview_id) {
                $interview_link = base_url("interview/take/$token");
                
                // Send email if requested
                if ($this->input->post('send_email')) {
                    $this->send_interview_email($interview_data, $interview_link);
                }
                
                $this->session->set_flashdata('success', 'Interview created successfully!');
                $this->session->set_flashdata('interview_link', $interview_link);
                redirect('interview/view/' . $interview_id);
            } else {
                $this->session->set_flashdata('error', 'Failed to create interview.');
            }
        }
        
        $this->load->view('templates/admin_header', $data);
        $this->load->view('interview/create_interview', $data);
        $this->load->view('templates/admin_footer');
    }

    /**
     * View Interview Details
     */
    public function view($id) {
        $data['title'] = 'Interview Details';
        $data['uname'] = $this->session->userdata('username');
        $data['interview'] = $this->Interview_model->get_by_id($id);
        
        if (!$data['interview']) {
            show_404();
        }
        
        $data['responses'] = $this->Interview_model->get_responses($id);
        $data['interview_link'] = base_url("interview/take/" . $data['interview']['token']);
        
        $this->load->view('templates/admin_header', $data);
        $this->load->view('interview/view_interview', $data);
        $this->load->view('templates/admin_footer');
    }

    /**
     * Take Interview (Candidate View)
     */
    public function take($token) {
        $interview = $this->Interview_model->get_by_token($token);
        
        if (!$interview) {
            show_error('Interview not found or link is invalid.');
            return;
        }
        
        // Check if expired
        if (strtotime($interview['expires_at']) < time()) {
            $this->Interview_model->update_status($interview['id'], 'expired');
            show_error('This interview link has expired.');
            return;
        }
        
        // Check if already completed
        if ($interview['status'] === 'completed') {
            show_error('This interview has already been completed.');
            return;
        }
        
        // Update status to in_progress if pending
        if ($interview['status'] === 'pending') {
            $this->Interview_model->update($interview['id'], [
                'status' => 'in_progress',
                'started_at' => date('Y-m-d H:i:s')
            ]);
        }
        
        $data['interview'] = $interview;
        $data['title'] = 'Interview - ' . $interview['job_title'];
        
        $this->load->view('interview/take_interview', $data);
    }

    /**
     * Submit Interview Response (AJAX)
     */
    public function submit_response() {
        header('Content-Type: application/json');
        
        $interview_id = $this->input->post('interview_id');
        $question_id = $this->input->post('question_id');
        $response_text = $this->input->post('response_text');
        
        $response_data = [
            'text' => $response_text,
            'duration' => $this->input->post('duration') ?? 0
        ];
        
        $response_id = $this->Interview_model->save_response($interview_id, $question_id, $response_data);
        
        if ($response_id) {
            echo json_encode(['success' => true, 'response_id' => $response_id]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to save response']);
        }
    }

    /**
     * Complete Interview (AJAX)
     */
    public function complete_interview() {
        header('Content-Type: application/json');
        
        $interview_id = $this->input->post('interview_id');
        
        $updated = $this->Interview_model->update($interview_id, [
            'status' => 'completed',
            'completed_at' => date('Y-m-d H:i:s'),
            'score' => $this->Interview_model->calculate_score($interview_id)
        ]);
        
        if ($updated) {
            echo json_encode(['success' => true, 'message' => 'Interview completed successfully']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to complete interview']);
        }
    }

    /**
     * Delete Interview Flow
     */
    public function delete_flow($id) {
        if ($this->Interview_flow_model->delete($id)) {
            $this->session->set_flashdata('success', 'Interview flow deleted successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete interview flow.');
        }
        
        redirect('interview/flows');
    }

    /**
     * Send Interview Email
     */
    private function send_interview_email($interview, $link) {
        $this->load->library('email');
        
        $this->email->from('noreply@rms.com', 'RMS Interview System');
        $this->email->to($interview['candidate_email']);
        $this->email->subject('Your Interview Link');
        
        $message = "Dear " . ($interview['candidate_name'] ?: 'Candidate') . ",\n\n";
        $message .= "You have been invited to complete an interview.\n\n";
        $message .= "Please click the link below to start your interview:\n";
        $message .= $link . "\n\n";
        $message .= "This link will expire on: " . $interview['expires_at'] . "\n\n";
        $message .= "Best regards,\nRMS Team";
        
        $this->email->message($message);
        return $this->email->send();
    }
}
