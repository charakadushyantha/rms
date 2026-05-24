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
        
        // Load interview configuration settings
        $config_query = $this->db->get('interview_config');
        if ($config_query->num_rows() > 0) {
            $data['interview_config'] = $config_query->row();
        } else {
            // Default configuration if not set
            $data['interview_config'] = (object)[
                'default_duration' => 60,
                'default_interview_type' => 'online',
                'default_platform' => 'Zoom',
                'enable_whatsapp_notifications' => 1,
                'enable_email_notifications' => 1,
                'enable_calendar_sync' => 1,
                'working_hours_start' => '09:00:00',
                'working_hours_end' => '18:00:00',
                'timezone' => 'Asia/Colombo'
            ];
        }
        
        // Load interview rounds from configuration
        $rounds_query = $this->db->where('is_active', 1)->order_by('display_order', 'ASC')->get('interview_rounds');
        $data['interview_rounds'] = $rounds_query->result_array();
        
        // Load meeting platforms from configuration
        $platforms_query = $this->db->where('is_active', 1)->get('meeting_platforms');
        $data['meeting_platforms'] = $platforms_query->result_array();
        
        // Load duration presets from configuration
        $durations_query = $this->db->order_by('duration_minutes', 'ASC')->get('interview_duration_presets');
        $data['duration_presets'] = $durations_query->result_array();
        
        // Load interview locations from configuration
        $locations_query = $this->db->where('is_active', 1)->get('interview_locations');
        $data['interview_locations'] = $locations_query->result_array();
        
        // UNIFIED APPROACH: Combine candidates from both sources
        $this->load->model('Candidate_model');
        
        // Get candidates from candidate_details with user account status using raw query
        $sql = "SELECT 
                    cd.cd_id, 
                    cd.cd_name, 
                    cd.cd_email, 
                    cd.cd_phone, 
                    cd.cd_job_title, 
                    cd.cd_status, 
                    u.u_id, 
                    u.u_status as user_status, 
                    u.u_role,
                    CASE WHEN u.u_id IS NOT NULL THEN 1 ELSE 0 END as has_account
                FROM candidate_details cd
                LEFT JOIN users u ON cd.cd_email = u.u_email AND u.u_role = 'candidate'
                WHERE cd.cd_email IS NOT NULL 
                AND cd.cd_email != ''
                GROUP BY cd.cd_email
                ORDER BY cd.cd_name ASC";
        
        $query = $this->db->query($sql);
        $candidates_from_details = $query->result_array();
        
        // Get registered candidate users NOT in candidate_details
        $sql2 = "SELECT 
                    u.u_id, 
                    u.u_username as cd_name, 
                    u.u_email as cd_email, 
                    '' as cd_phone, 
                    '' as cd_job_title, 
                    u.u_status as cd_status, 
                    u.u_id, 
                    u.u_status as user_status, 
                    u.u_role, 
                    1 as has_account
                FROM users u
                WHERE u.u_role = 'candidate'
                AND u.u_email NOT IN (
                    SELECT cd_email 
                    FROM candidate_details 
                    WHERE cd_email IS NOT NULL 
                    AND cd_email != ''
                )
                ORDER BY u.u_username ASC";
        
        $query2 = $this->db->query($sql2);
        $candidates_from_users = $query2->result_array();
        
        // Combine both sources
        $data['candidates'] = array_merge($candidates_from_details, $candidates_from_users);
        
        // Add source indicator and ensure has_account is set for all
        foreach ($data['candidates'] as &$candidate) {
            if (isset($candidate['cd_id']) && $candidate['cd_id']) {
                $candidate['source'] = 'candidate_details';
            } else {
                $candidate['source'] = 'users_only';
            }
            // Ensure has_account is always set
            if (!isset($candidate['has_account'])) {
                $candidate['has_account'] = 0;
            }
        }
        
        // Get interviewers list
        $sql_interviewers = "SELECT u_id, u_username, u_email 
                            FROM users 
                            WHERE u_role = 'interviewer' 
                            AND (u_status = 'Active' OR u_status = '1')
                            ORDER BY u_username ASC";
        $query_interviewers = $this->db->query($sql_interviewers);
        $data['interviewers'] = $query_interviewers->result_array();
        
        // Get job positions
        $sql_positions = "SELECT DISTINCT cd_job_title 
                         FROM candidate_details 
                         WHERE cd_job_title IS NOT NULL 
                         AND cd_job_title != '' 
                         ORDER BY cd_job_title ASC";
        $query_positions = $this->db->query($sql_positions);
        $data['job_positions'] = $query_positions->result_array();
        
        if ($this->input->post()) {
            $token = bin2hex(random_bytes(32));
            
            $interview_data = [
                'flow_id' => $this->input->post('flow_id'),
                'candidate_name' => $this->input->post('candidate_name'),
                'candidate_email' => $this->input->post('candidate_email'),
                'candidate_phone' => $this->input->post('candidate_phone'),
                
                // Interview Schedule
                'interview_date' => $this->input->post('interview_date'),
                'interview_start_time' => $this->input->post('interview_start_time'),
                'interview_end_time' => $this->input->post('interview_end_time'),
                'interview_duration' => $this->input->post('interview_duration') ?: 60,
                'interview_round' => $this->input->post('interview_round') ?: 'Round 1',
                
                // Interview Type & Details
                'interview_type' => $this->input->post('interview_type') ?: 'online',
                'online_platform' => $this->input->post('online_platform'),
                'meeting_link' => $this->input->post('meeting_link'),
                'meeting_id' => $this->input->post('meeting_id'),
                'meeting_password' => $this->input->post('meeting_password'),
                'venue_location' => $this->input->post('venue_location'),
                'venue_room' => $this->input->post('venue_room'),
                'phone_number' => $this->input->post('phone_number'),
                
                // Assignment
                'assigned_interviewer' => null, // Will be set below
                'job_position' => $this->input->post('job_position'),
                
                // Notes
                'interview_notes' => $this->input->post('interview_notes'),
                'internal_notes' => $this->input->post('internal_notes'),
                
                // Notifications
                'send_whatsapp' => $this->input->post('send_whatsapp') ? 1 : 0,
                'send_sms' => $this->input->post('send_sms') ? 1 : 0,
                'timezone' => 'Asia/Colombo',
                
                // Existing fields
                'token' => $token,
                'status' => 'pending',
                'expires_at' => date('Y-m-d H:i:s', strtotime('+7 days')),
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            // Handle interviewer assignment (single or multiple)
            $assigned_interviewers_array = $this->input->post('assigned_interviewers');
            if ($assigned_interviewers_array && is_array($assigned_interviewers_array)) {
                // Multiple interviewers mode
                $assigned_interviewers_array = array_filter($assigned_interviewers_array); // Remove empty values
                $interview_data['assigned_interviewer'] = implode(',', $assigned_interviewers_array);
            } else {
                // Single interviewer mode
                $interview_data['assigned_interviewer'] = $this->input->post('assigned_interviewer');
            }
            
            $interview_id = $this->Interview_model->create($interview_data);
            
            if ($interview_id) {
                $interview_link = base_url("interview/take/$token");
                
                // Send email if requested
                if ($this->input->post('send_email')) {
                    $this->send_interview_email($interview_data, $interview_link);
                }
                
                $this->session->set_flashdata('success', 'Interview scheduled successfully!');
                $this->session->set_flashdata('interview_link', $interview_link);
                redirect('interview/view/' . $interview_id);
            } else {
                $this->session->set_flashdata('error', 'Failed to schedule interview.');
            }
        }
        
        $this->load->view('templates/admin_header', $data);
        $this->load->view('interview/create_interview_enhanced', $data);
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
    
    /**
     * Cancel Interview (AJAX)
     */
    public function cancel_interview_ajax() {
        header('Content-Type: application/json');
        
        $interview_id = $this->input->post('interview_id');
        
        if (!$interview_id) {
            echo json_encode(['success' => false, 'message' => 'Interview ID is required']);
            return;
        }
        
        $result = $this->Interview_model->cancel_interview($interview_id);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Interview cancelled successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to cancel interview']);
        }
    }
    
    /**
     * Send Reminder (AJAX)
     */
    public function send_reminder_ajax() {
        header('Content-Type: application/json');
        
        $interview_id = $this->input->post('interview_id');
        
        if (!$interview_id) {
            echo json_encode(['success' => false, 'message' => 'Interview ID is required']);
            return;
        }
        
        $interview = $this->Interview_model->get_by_id($interview_id);
        
        if (!$interview) {
            echo json_encode(['success' => false, 'message' => 'Interview not found']);
            return;
        }
        
        // Send reminder email
        $interview_link = base_url("interview/take/" . $interview['token']);
        $this->send_interview_email($interview, $interview_link);
        
        echo json_encode(['success' => true, 'message' => 'Reminder sent successfully']);
    }
    
    /**
     * Get Calendar Data (AJAX)
     */
    public function get_calendar_data() {
        header('Content-Type: application/json');
        
        $month = $this->input->get('month');
        $year = $this->input->get('year');
        
        if (!$month || !$year) {
            echo json_encode(['success' => false, 'message' => 'Month and year are required']);
            return;
        }
        
        $dates = $this->Interview_model->get_interview_dates($month, $year);
        
        echo json_encode(['success' => true, 'dates' => $dates]);
    }
    
    /**
     * Export Report
     */
    public function export_report() {
        // Get all interviews
        $interviews = $this->Interview_model->get_all(null, null, 1000, 0);
        
        // Set headers for CSV download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="interviews_report_' . date('Y-m-d') . '.csv"');
        
        $output = fopen('php://output', 'w');
        
        // CSV headers
        fputcsv($output, [
            'ID',
            'Candidate Name',
            'Candidate Email',
            'Candidate Phone',
            'Job Position',
            'Interview Date',
            'Interview Time',
            'Duration (min)',
            'Round',
            'Type',
            'Platform/Location',
            'Assigned Interviewer',
            'Status',
            'Created At',
            'Started At',
            'Completed At'
        ]);
        
        // CSV data
        foreach ($interviews as $interview) {
            $platform_location = '';
            if ($interview['interview_type'] === 'online') {
                $platform_location = $interview['online_platform'] ?? '';
            } elseif ($interview['interview_type'] === 'in_person') {
                $platform_location = $interview['venue_location'] ?? '';
            } elseif ($interview['interview_type'] === 'phone') {
                $platform_location = $interview['phone_number'] ?? '';
            }
            
            fputcsv($output, [
                $interview['id'],
                $interview['candidate_name'] ?? '',
                $interview['candidate_email'] ?? '',
                $interview['candidate_phone'] ?? '',
                $interview['job_title'] ?? '',
                $interview['interview_date'] ?? '',
                $interview['interview_start_time'] ?? '',
                $interview['interview_duration'] ?? '',
                $interview['interview_round'] ?? '',
                ucfirst($interview['interview_type'] ?? ''),
                $platform_location,
                $interview['assigned_interviewer'] ?? '',
                ucfirst($interview['status'] ?? ''),
                $interview['created_at'] ?? '',
                $interview['started_at'] ?? '',
                $interview['completed_at'] ?? ''
            ]);
        }
        
        fclose($output);
        exit;
    }
}
