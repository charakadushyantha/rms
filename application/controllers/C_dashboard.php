<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Candidate_model');
        $this->load->library('session');
        $this->load->helper('url');
    }

    // Main Dashboard
    public function index() {
        if (!$this->session->userdata('authenticated')) {
            redirect(LOGIN_URL);
        }

        $data['uname'] = $this->session->userdata('username');
        $data['email'] = $this->session->userdata('email');
        $data['page_title'] = 'Candidate Dashboard';
        
        // Get dashboard data
        $data['applications'] = $this->Candidate_model->get_my_applications($data['email']);
        $data['upcoming_interviews'] = $this->Candidate_model->get_upcoming_interviews($data['email']);
        $data['stats'] = $this->Candidate_model->get_candidate_stats($data['email']);
        
        $this->load->view('Candidate_dashboard_view/dashboard', $data);
    }

    // Application Tracking
    public function applications() {
        if (!$this->session->userdata('authenticated')) {
            redirect(LOGIN_URL);
        }

        $data['uname'] = $this->session->userdata('username');
        $data['email'] = $this->session->userdata('email');
        $data['page_title'] = 'My Applications';
        $data['applications'] = $this->Candidate_model->get_my_applications($data['email']);
        
        $this->load->view('Candidate_dashboard_view/applications', $data);
    }

    // Interview Schedule
    public function interviews() {
        if (!$this->session->userdata('authenticated')) {
            redirect(LOGIN_URL);
        }

        $data['uname'] = $this->session->userdata('username');
        $data['email'] = $this->session->userdata('email');
        $data['page_title'] = 'My Interviews';
        
        $this->load->view('Candidate_dashboard_view/interviews', $data);
    }

    // Get interview events for calendar (AJAX)
    public function get_interview_events() {
        if (!$this->session->userdata('authenticated')) {
            echo json_encode([]);
            return;
        }

        $email = $this->session->userdata('email');
        $events = $this->Candidate_model->get_interview_events($email);
        
        echo json_encode($events);
    }

    // Confirm Interview Attendance
    public function confirm_interview() {
        if (!$this->session->userdata('authenticated')) {
            echo json_encode(['success' => false, 'message' => 'Not authenticated']);
            return;
        }

        $interview_id = $this->input->post('interview_id');
        $status = $this->input->post('status'); // 'confirmed' or 'declined'
        $email = $this->session->userdata('email');

        $result = $this->Candidate_model->confirm_interview($interview_id, $email, $status);
        echo json_encode($result);
    }

    // Request Interview Reschedule
    public function request_reschedule() {
        if (!$this->session->userdata('authenticated')) {
            echo json_encode(['success' => false, 'message' => 'Not authenticated']);
            return;
        }

        $interview_id = $this->input->post('interview_id');
        $reason = $this->input->post('reason');
        $preferred_dates = $this->input->post('preferred_dates');
        $email = $this->session->userdata('email');

        $result = $this->Candidate_model->request_reschedule($interview_id, $email, $reason, $preferred_dates);
        echo json_encode($result);
    }

    // Documents Management
    public function documents() {
        if (!$this->session->userdata('authenticated')) {
            redirect(LOGIN_URL);
        }

        $data['uname'] = $this->session->userdata('username');
        $data['email'] = $this->session->userdata('email');
        $data['page_title'] = 'My Documents';
        $data['documents'] = $this->Candidate_model->get_my_documents($data['email']);
        
        $this->load->view('Candidate_dashboard_view/documents', $data);
    }

    // Upload Document
    public function upload_document() {
        if (!$this->session->userdata('authenticated')) {
            echo json_encode(['success' => false, 'message' => 'Not authenticated']);
            return;
        }

        $email = $this->session->userdata('email');
        $document_type = $this->input->post('document_type');

        // Configure upload
        $config['upload_path'] = './uploads/candidate_documents/';
        $config['allowed_types'] = 'pdf|doc|docx|jpg|jpeg|png';
        $config['max_size'] = 5120; // 5MB
        $config['file_name'] = $email . '_' . $document_type . '_' . time();

        // Create directory if it doesn't exist
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
        }

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('document')) {
            $upload_data = $this->upload->data();
            
            $document_data = [
                'candidate_username' => $email,
                'document_type' => $document_type,
                'file_name' => $upload_data['file_name'],
                'file_path' => $config['upload_path'] . $upload_data['file_name'],
                'file_size' => $upload_data['file_size'] * 1024 // Convert to bytes
            ];

            $result = $this->Candidate_model->save_document($document_data);
            echo json_encode($result);
        } else {
            echo json_encode([
                'success' => false,
                'message' => $this->upload->display_errors('', '')
            ]);
        }
    }

    // Delete Document
    public function delete_document() {
        if (!$this->session->userdata('authenticated')) {
            echo json_encode(['success' => false, 'message' => 'Not authenticated']);
            return;
        }

        $document_id = $this->input->post('document_id');
        $email = $this->session->userdata('email');

        $result = $this->Candidate_model->delete_document($document_id, $email);
        echo json_encode($result);
    }

    // Messages/Communication Center
    public function messages() {
        if (!$this->session->userdata('authenticated')) {
            redirect(LOGIN_URL);
        }

        $data['uname'] = $this->session->userdata('username');
        $data['email'] = $this->session->userdata('email');
        $data['page_title'] = 'Messages';
        $data['messages'] = $this->Candidate_model->get_my_messages($data['uname']);
        
        $this->load->view('Candidate_dashboard_view/messages', $data);
    }

    // Mark Message as Read
    public function mark_message_read() {
        if (!$this->session->userdata('authenticated')) {
            echo json_encode(['success' => false]);
            return;
        }

        $message_id = $this->input->post('message_id');
        $result = $this->Candidate_model->mark_message_read($message_id);
        
        echo json_encode($result);
    }

    // My CV / Resume Builder
    public function my_cv() {
        if (!$this->session->userdata('authenticated')) {
            redirect(LOGIN_URL);
        }

        $data['uname'] = $this->session->userdata('username');
        $data['email'] = $this->session->userdata('email');
        $data['page_title'] = 'My CV';
        $data['cv_data'] = $this->Candidate_model->get_cv_data($data['email']);
        
        $this->load->view('Candidate_dashboard_view/my_cv', $data);
    }

    // Save CV Data
    public function save_cv() {
        if (!$this->session->userdata('authenticated')) {
            echo json_encode(['success' => false, 'message' => 'Not authenticated']);
            return;
        }

        $email = $this->session->userdata('email');
        $cv_data = $this->input->post();
        
        $result = $this->Candidate_model->save_cv_data($email, $cv_data);
        echo json_encode($result);
    }

    // Profile Management
    public function profile() {
        if (!$this->session->userdata('authenticated')) {
            redirect(LOGIN_URL);
        }

        $data['uname'] = $this->session->userdata('username');
        $data['email'] = $this->session->userdata('email');
        $data['page_title'] = 'My Profile';
        $data['user_info'] = $this->Candidate_model->get_user_info($data['uname']);
        $data['candidate_info'] = $this->Candidate_model->get_candidate_info($data['email']);
        
        $this->load->view('Candidate_dashboard_view/profile', $data);
    }

    // Upload Profile Picture
    public function upload_profile_picture() {
        if (!$this->session->userdata('authenticated')) {
            echo json_encode(['success' => false, 'message' => 'Not authenticated']);
            return;
        }

        $username = $this->session->userdata('username');

        // Configure upload
        $config['upload_path'] = './uploads/profile_pictures/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 2048; // 2MB
        $config['file_name'] = $username . '_' . time();

        // Create directory if it doesn't exist
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
        }

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('profile_picture')) {
            $upload_data = $this->upload->data();
            $file_path = 'uploads/profile_pictures/' . $upload_data['file_name'];

            $result = $this->Candidate_model->update_profile_picture($username, $file_path);
            echo json_encode($result);
        } else {
            echo json_encode([
                'success' => false,
                'message' => $this->upload->display_errors('', '')
            ]);
        }
    }

    // Update Profile
    public function update_profile() {
        if (!$this->session->userdata('authenticated')) {
            echo json_encode(['success' => false, 'message' => 'Not authenticated']);
            return;
        }

        $username = $this->session->userdata('username');
        $email = $this->session->userdata('email');
        
        $profile_data = [
            'u_email' => $this->input->post('email'),
            'u_phone' => $this->input->post('phone')
        ];

        $candidate_data = [
            'cd_phone' => $this->input->post('phone'),
            'cd_address' => $this->input->post('address'),
            'cd_city' => $this->input->post('city'),
            'cd_skills' => $this->input->post('skills')
        ];

        $result = $this->Candidate_model->update_profile($username, $email, $profile_data, $candidate_data);
        echo json_encode($result);
    }
}
