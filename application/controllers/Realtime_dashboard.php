<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Realtime_dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Realtime_model');
        $this->load->library('session');
        
        // Check authentication
        if (!$this->session->userdata('authenticated')) {
            redirect('login');
        }
    }

    /**
     * Main dashboard view
     */
    public function index() {
        $data['user_role'] = $this->session->userdata('Role');
        $data['user_id'] = $this->session->userdata('id');
        $data['stages'] = $this->Realtime_model->get_pipeline_stages();
        
        $this->load->view('realtime_dashboard_view', $data);
    }

    /**
     * Get pipeline data (AJAX)
     */
    public function get_pipeline_data() {
        header('Content-Type: application/json');
        
        $data = $this->Realtime_model->get_pipeline_overview();
        echo json_encode(['success' => true, 'data' => $data]);
    }

    /**
     * Move candidate to different stage
     */
    public function move_candidate() {
        header('Content-Type: application/json');
        
        $input = json_decode(file_get_contents('php://input'), true);
        $candidate_id = $input['candidate_id'] ?? 0;
        $stage_id = $input['stage_id'] ?? 0;
        $notes = $input['notes'] ?? '';
        
        if ($candidate_id && $stage_id) {
            $result = $this->Realtime_model->move_candidate(
                $candidate_id,
                $stage_id,
                $this->session->userdata('id'),
                $notes
            );
            
            if ($result) {
                // Log activity
                $this->Realtime_model->log_activity(
                    $candidate_id,
                    $this->session->userdata('id'),
                    'stage_change',
                    json_encode(['stage_id' => $stage_id, 'notes' => $notes])
                );
                
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Failed to move candidate']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Invalid parameters']);
        }
    }

    /**
     * Get real-time metrics
     */
    public function get_metrics() {
        header('Content-Type: application/json');
        
        $metrics = $this->Realtime_model->get_dashboard_metrics();
        echo json_encode(['success' => true, 'metrics' => $metrics]);
    }

    /**
     * Get recent activity
     */
    public function get_activity() {
        header('Content-Type: application/json');
        
        $limit = $this->input->get('limit') ?? 20;
        $activity = $this->Realtime_model->get_recent_activity($limit);
        
        echo json_encode(['success' => true, 'activity' => $activity]);
    }

    /**
     * Create hiring decision
     */
    public function create_decision() {
        header('Content-Type: application/json');
        
        $input = json_decode(file_get_contents('php://input'), true);
        
        $decision_id = $this->Realtime_model->create_decision([
            'candidate_id' => $input['candidate_id'],
            'decision_type' => $input['decision_type'],
            'created_by' => $this->session->userdata('id'),
            'deadline' => $input['deadline'] ?? null
        ]);
        
        if ($decision_id) {
            echo json_encode(['success' => true, 'decision_id' => $decision_id]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to create decision']);
        }
    }

    /**
     * Submit vote on candidate
     */
    public function submit_vote() {
        header('Content-Type: application/json');
        
        $input = json_decode(file_get_contents('php://input'), true);
        
        $result = $this->Realtime_model->submit_vote([
            'decision_id' => $input['decision_id'],
            'user_id' => $this->session->userdata('id'),
            'vote' => $input['vote'],
            'comment' => $input['comment'] ?? '',
            'is_anonymous' => $input['is_anonymous'] ?? 0
        ]);
        
        if ($result) {
            // Get updated vote counts
            $votes = $this->Realtime_model->get_decision_votes($input['decision_id']);
            echo json_encode(['success' => true, 'votes' => $votes]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to submit vote']);
        }
    }

    /**
     * Get interviewer availability
     */
    public function get_interviewer_availability() {
        header('Content-Type: application/json');
        
        $date = $this->input->get('date') ?? date('Y-m-d');
        $availability = $this->Realtime_model->get_interviewer_availability($date);
        
        echo json_encode(['success' => true, 'availability' => $availability]);
    }

    /**
     * Schedule interview panel
     */
    public function schedule_interview() {
        header('Content-Type: application/json');
        
        $input = json_decode(file_get_contents('php://input'), true);
        
        $result = $this->Realtime_model->schedule_interview([
            'candidate_id' => $input['candidate_id'],
            'interviewer_id' => $input['interviewer_id'],
            'interview_date' => $input['interview_date'],
            'duration_minutes' => $input['duration_minutes'] ?? 60,
            'interview_type' => $input['interview_type'] ?? 'technical'
        ]);
        
        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to schedule interview']);
        }
    }

    /**
     * Get bottlenecks analysis
     */
    public function get_bottlenecks() {
        header('Content-Type: application/json');
        
        $bottlenecks = $this->Realtime_model->identify_bottlenecks();
        echo json_encode(['success' => true, 'bottlenecks' => $bottlenecks]);
    }
    
    /**
     * Get candidate details for quick view
     */
    public function get_candidate($id) {
        header('Content-Type: application/json');
        
        $this->load->model('Realtime_model');
        $candidate = $this->Realtime_model->get_candidate_by_id($id);
        
        if ($candidate) {
            echo json_encode(['success' => true, 'candidate' => $candidate]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Candidate not found']);
        }
    }
    
    /**
     * Candidate detail page
     */
    public function candidate_detail($id) {
        $this->load->model('Realtime_model');
        
        $data['candidate'] = $this->Realtime_model->get_candidate_by_id($id);
        $data['pipeline_history'] = $this->Realtime_model->get_candidate_pipeline_history($id);
        $data['interviews'] = $this->Realtime_model->get_candidate_interviews($id);
        $data['decisions'] = $this->Realtime_model->get_candidate_decisions($id);
        
        if (!$data['candidate']) {
            show_404();
        }
        
        $this->load->view('candidate_detail_view', $data);
    }
}
