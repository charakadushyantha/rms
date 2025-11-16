<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class I_dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Interviewer_model');
        $this->load->library('session');
        $this->load->helper('url');
    }

    // Main Dashboard
    public function index() {
        if (!$this->session->userdata('authenticated')) {
            redirect(LOGIN_URL);
        }

        $data['uname'] = $this->session->userdata('username');
        // Use full name if available from Google login, otherwise use username
        $data['display_name'] = $this->session->userdata('full_name') ? $this->session->userdata('full_name') : $this->session->userdata('username');
        $data['page_title'] = 'Interviewer Dashboard';
        
        // Get dashboard stats
        $data['today_interviews'] = $this->Interviewer_model->get_today_interviews($data['uname']);
        $data['pending_feedback'] = $this->Interviewer_model->get_pending_feedback($data['uname']);
        $data['upcoming_interviews'] = $this->Interviewer_model->get_upcoming_interviews($data['uname']);
        $data['stats'] = $this->Interviewer_model->get_interviewer_stats($data['uname']);
        
        $this->load->view('Interviewer_dashboard_view/dashboard', $data);
    }

    // Interview Schedule
    public function schedule() {
        if (!$this->session->userdata('authenticated')) {
            redirect(LOGIN_URL);
        }

        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'My Interview Schedule';
        
        $this->load->view('Interviewer_dashboard_view/schedule', $data);
    }

    // Get events for calendar (AJAX)
    public function get_events() {
        if (!$this->session->userdata('authenticated')) {
            echo json_encode([]);
            return;
        }

        $username = $this->session->userdata('username');
        $events = $this->Interviewer_model->get_interviewer_events($username);
        
        echo json_encode($events);
    }

    // Accept/Decline Interview Assignment
    public function respond_to_assignment() {
        if (!$this->session->userdata('authenticated')) {
            echo json_encode(['success' => false, 'message' => 'Not authenticated']);
            return;
        }

        $assignment_id = $this->input->post('assignment_id');
        $status = $this->input->post('status'); // 'accepted' or 'declined'
        $notes = $this->input->post('notes');

        $result = $this->Interviewer_model->update_assignment_status(
            $assignment_id, 
            $status, 
            $notes
        );

        echo json_encode($result);
    }

    // Feedback Form
    public function feedback($interview_id = null) {
        if (!$this->session->userdata('authenticated')) {
            redirect(LOGIN_URL);
        }

        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Submit Interview Feedback';
        
        if ($interview_id) {
            $data['interview'] = $this->Interviewer_model->get_interview_details($interview_id);
            $data['candidate'] = $this->Interviewer_model->get_candidate_details($data['interview']['candidate_id']);
            $data['existing_feedback'] = $this->Interviewer_model->get_feedback($interview_id, $data['uname']);
        }
        
        $this->load->view('Interviewer_dashboard_view/feedback', $data);
    }

    // Submit Feedback (AJAX)
    public function submit_feedback() {
        if (!$this->session->userdata('authenticated')) {
            echo json_encode(['success' => false, 'message' => 'Not authenticated']);
            return;
        }

        $feedback_data = [
            'interview_id' => $this->input->post('interview_id'),
            'interviewer_username' => $this->session->userdata('username'),
            'candidate_id' => $this->input->post('candidate_id'),
            'technical_skills' => $this->input->post('technical_skills'),
            'communication' => $this->input->post('communication'),
            'problem_solving' => $this->input->post('problem_solving'),
            'cultural_fit' => $this->input->post('cultural_fit'),
            'overall_rating' => $this->input->post('overall_rating'),
            'strengths' => $this->input->post('strengths'),
            'weaknesses' => $this->input->post('weaknesses'),
            'detailed_feedback' => $this->input->post('detailed_feedback'),
            'recommendation' => $this->input->post('recommendation')
        ];

        $result = $this->Interviewer_model->save_feedback($feedback_data);
        echo json_encode($result);
    }

    // View Historical Feedback
    public function feedback_history() {
        if (!$this->session->userdata('authenticated')) {
            redirect(LOGIN_URL);
        }

        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Feedback History';
        $data['feedback_list'] = $this->Interviewer_model->get_feedback_history($data['uname']);
        
        $this->load->view('Interviewer_dashboard_view/feedback_history', $data);
    }

    // Get Candidate Details (AJAX)
    public function get_candidate_details() {
        if (!$this->session->userdata('authenticated')) {
            echo json_encode(['success' => false]);
            return;
        }

        $candidate_id = $this->input->post('candidate_id');
        $candidate = $this->Interviewer_model->get_candidate_details($candidate_id);
        
        echo json_encode(['success' => true, 'candidate' => $candidate]);
    }

    // Profile Management
    public function profile() {
        if (!$this->session->userdata('authenticated')) {
            redirect(LOGIN_URL);
        }

        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'My Profile';
        $data['user_info'] = $this->Interviewer_model->get_user_info($data['uname']);
        $data['availability'] = $this->Interviewer_model->get_availability($data['uname']);
        
        $this->load->view('Interviewer_dashboard_view/profile', $data);
    }

    // Update Profile
    public function update_profile() {
        if (!$this->session->userdata('authenticated')) {
            echo json_encode(['success' => false, 'message' => 'Not authenticated']);
            return;
        }

        $username = $this->session->userdata('username');
        
        // Only update email which exists in users table
        $profile_data = [
            'u_email' => $this->input->post('email')
        ];
        
        // Add optional fields if they're provided
        $phone = $this->input->post('phone');
        $department = $this->input->post('department');
        $expertise = $this->input->post('expertise');
        
        if (!empty($phone)) {
            $profile_data['u_phone'] = $phone;
        }

        $result = $this->Interviewer_model->update_profile($username, $profile_data);
        echo json_encode($result);
    }

    // Update Availability
    public function update_availability() {
        if (!$this->session->userdata('authenticated')) {
            echo json_encode(['success' => false, 'message' => 'Not authenticated']);
            return;
        }

        $username = $this->session->userdata('username');
        
        // Get JSON input
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $availability = isset($data['availability']) ? $data['availability'] : [];

        $result = $this->Interviewer_model->update_availability($username, $availability);
        echo json_encode($result);
    }

    // Download Candidate Resume
    public function download_resume($candidate_id) {
        if (!$this->session->userdata('authenticated')) {
            show_404();
            return;
        }

        $resume = $this->Interviewer_model->get_candidate_resume($candidate_id);
        
        if ($resume) {
            $this->load->helper('download');
            force_download($resume['file_path'], NULL);
        } else {
            show_404();
        }
    }
}
