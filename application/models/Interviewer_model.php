<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Interviewer_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Get today's interviews
    public function get_today_interviews($username) {
        $today = date('Y-m-d');
        
        $this->db->select('ia.*, cd.cd_name as Can_name, cd.cd_email as Can_email, cd.cd_phone as Can_phone, cd.cd_job_title as Can_position');
        $this->db->from('interview_assignments ia');
        $this->db->join('candidate_details cd', 'ia.candidate_id = cd.cd_id');
        $this->db->where('ia.interviewer_username', $username);
        $this->db->where('DATE(ia.assigned_at)', $today);
        $this->db->where('ia.status !=', 'declined');
        $this->db->order_by('ia.assigned_at', 'ASC');
        
        return $this->db->get()->result_array();
    }

    // Get pending feedback
    public function get_pending_feedback($username) {
        $this->db->select('ia.*, cd.cd_name as Can_name, cd.cd_job_title as Can_position');
        $this->db->from('interview_assignments ia');
        $this->db->join('candidate_details cd', 'ia.candidate_id = cd.cd_id');
        $this->db->where('ia.interviewer_username', $username);
        $this->db->where('ia.status', 'completed');
        $this->db->where('ia.id NOT IN (SELECT interview_id FROM interviewer_feedback WHERE interviewer_username = "' . $username . '")', NULL, FALSE);
        $this->db->order_by('ia.assigned_at', 'DESC');
        
        return $this->db->get()->result_array();
    }

    // Get upcoming interviews
    public function get_upcoming_interviews($username, $limit = 5) {
        $now = date('Y-m-d H:i:s');
        
        $this->db->select('ia.*, cd.cd_name as Can_name, cd.cd_email as Can_email, cd.cd_job_title as Can_position');
        $this->db->from('interview_assignments ia');
        $this->db->join('candidate_details cd', 'ia.candidate_id = cd.cd_id');
        $this->db->where('ia.interviewer_username', $username);
        $this->db->where('ia.assigned_at >', $now);
        $this->db->where('ia.status !=', 'declined');
        $this->db->order_by('ia.assigned_at', 'ASC');
        $this->db->limit($limit);
        
        return $this->db->get()->result_array();
    }

    // Get interviewer statistics
    public function get_interviewer_stats($username) {
        $stats = [];
        
        // Total interviews conducted
        $this->db->where('interviewer_username', $username);
        $this->db->where('status', 'completed');
        $stats['total_interviews'] = $this->db->count_all_results('interview_assignments');
        
        // Pending feedback count
        $stats['pending_feedback'] = count($this->get_pending_feedback($username));
        
        // This week's interviews
        $week_start = date('Y-m-d', strtotime('monday this week'));
        $week_end = date('Y-m-d', strtotime('sunday this week'));
        $this->db->where('interviewer_username', $username);
        $this->db->where('DATE(assigned_at) >=', $week_start);
        $this->db->where('DATE(assigned_at) <=', $week_end);
        $stats['week_interviews'] = $this->db->count_all_results('interview_assignments');
        
        // Average rating given
        $this->db->select_avg('overall_rating');
        $this->db->where('interviewer_username', $username);
        $result = $this->db->get('interviewer_feedback')->row_array();
        $stats['avg_rating'] = $result['overall_rating'] ? round($result['overall_rating'], 1) : 0;
        
        return $stats;
    }

    // Get interviewer events for calendar
    public function get_interviewer_events($username) {
        $this->db->select('ia.id, ia.interview_id, ia.assigned_at as start, ia.status, 
                          cd.cd_name as Can_name, cd.cd_job_title as Can_position, cd.cd_id as candidate_id');
        $this->db->from('interview_assignments ia');
        $this->db->join('candidate_details cd', 'ia.candidate_id = cd.cd_id');
        $this->db->where('ia.interviewer_username', $username);
        $this->db->order_by('ia.assigned_at', 'ASC');
        
        $results = $this->db->get()->result_array();
        
        $events = [];
        foreach ($results as $row) {
            $events[] = [
                'id' => $row['id'],
                'title' => $row['Can_name'] . ' - ' . $row['Can_position'],
                'start' => $row['start'],
                'end' => date('Y-m-d H:i:s', strtotime($row['start'] . ' +1 hour')),
                'status' => $row['status'],
                'candidate_id' => $row['candidate_id'],
                'className' => 'interview-' . $row['status']
            ];
        }
        
        return $events;
    }

    // Update assignment status
    public function update_assignment_status($assignment_id, $status, $notes = null) {
        $data = [
            'status' => $status,
            'responded_at' => date('Y-m-d H:i:s')
        ];
        
        if ($notes) {
            $data['notes'] = $notes;
        }
        
        $this->db->where('id', $assignment_id);
        $result = $this->db->update('interview_assignments', $data);
        
        return [
            'success' => $result,
            'message' => $result ? 'Status updated successfully' : 'Failed to update status'
        ];
    }

    // Get interview details
    public function get_interview_details($interview_id) {
        $this->db->where('id', $interview_id);
        return $this->db->get('interview_assignments')->row_array();
    }

    // Get candidate details
    public function get_candidate_details($candidate_id) {
        $this->db->where('cd_id', $candidate_id);
        $candidate = $this->db->get('candidate_details')->row_array();
        
        if ($candidate) {
            // Map to expected format
            $candidate['Can_id'] = $candidate['cd_id'];
            $candidate['Can_name'] = $candidate['cd_name'];
            $candidate['Can_email'] = $candidate['cd_email'];
            $candidate['Can_phone'] = isset($candidate['cd_phone']) ? $candidate['cd_phone'] : '';
            $candidate['Can_position'] = isset($candidate['cd_job_title']) ? $candidate['cd_job_title'] : '';
            
            // Get documents
            $this->db->where('candidate_username', $candidate['cd_email']);
            $candidate['documents'] = $this->db->get('candidate_documents')->result_array();
        }
        
        return $candidate;
    }

    // Get existing feedback
    public function get_feedback($interview_id, $username) {
        $this->db->where('interview_id', $interview_id);
        $this->db->where('interviewer_username', $username);
        return $this->db->get('interviewer_feedback')->row_array();
    }

    // Save feedback
    public function save_feedback($feedback_data) {
        // Check if feedback already exists
        $existing = $this->get_feedback($feedback_data['interview_id'], $feedback_data['interviewer_username']);
        
        if ($existing) {
            // Update existing feedback
            $this->db->where('id', $existing['id']);
            $result = $this->db->update('interviewer_feedback', $feedback_data);
        } else {
            // Insert new feedback
            $result = $this->db->insert('interviewer_feedback', $feedback_data);
        }
        
        // Update assignment status to completed
        if ($result) {
            $this->db->where('interview_id', $feedback_data['interview_id']);
            $this->db->where('interviewer_username', $feedback_data['interviewer_username']);
            $this->db->update('interview_assignments', ['status' => 'completed']);
        }
        
        return [
            'success' => $result,
            'message' => $result ? 'Feedback submitted successfully' : 'Failed to submit feedback'
        ];
    }

    // Get feedback history
    public function get_feedback_history($username) {
        $this->db->select('f.*, cd.cd_name as Can_name, cd.cd_job_title as Can_position, cd.cd_email as Can_email');
        $this->db->from('interviewer_feedback f');
        $this->db->join('candidate_details cd', 'f.candidate_id = cd.cd_id');
        $this->db->where('f.interviewer_username', $username);
        $this->db->order_by('f.submitted_at', 'DESC');
        
        return $this->db->get()->result_array();
    }

    // Get user info
    public function get_user_info($username) {
        // Get user data with profile info
        $this->db->select('users.*, profile_info.pi_full_name, profile_info.pi_first_name, profile_info.pi_last_name, profile_info.pi_phone, profile_info.pi_gender');
        $this->db->from('users');
        $this->db->join('profile_info', 'users.u_username = profile_info.pi_username', 'left');
        $this->db->where('users.u_username', $username);
        $user_data = $this->db->get()->row_array();
        
        // If full name exists in profile, use it; otherwise use username
        if ($user_data && !empty($user_data['pi_full_name'])) {
            $user_data['display_name'] = $user_data['pi_full_name'];
        } else {
            $user_data['display_name'] = $user_data['u_username'];
        }
        
        return $user_data;
    }

    // Get availability
    public function get_availability($username) {
        try {
            // Check if table exists
            if (!$this->db->table_exists('interviewer_availability')) {
                return [];
            }
            
            $this->db->where('interviewer_username', $username);
            $this->db->order_by('day_of_week', 'ASC');
            return $this->db->get('interviewer_availability')->result_array();
        } catch (Exception $e) {
            // Table doesn't exist or has different structure
            return [];
        }
    }

    // Update profile
    public function update_profile($username, $profile_data) {
        try {
            // Get existing columns in users table
            $fields = $this->db->list_fields('users');
            
            // Filter profile data to only include existing columns
            $filtered_data = [];
            foreach ($profile_data as $key => $value) {
                if (in_array($key, $fields)) {
                    $filtered_data[$key] = $value;
                }
            }
            
            if (empty($filtered_data)) {
                return [
                    'success' => false,
                    'message' => 'No valid fields to update'
                ];
            }
            
            $this->db->where('u_username', $username);
            $result = $this->db->update('users', $filtered_data);
            
            return [
                'success' => $result,
                'message' => $result ? 'Profile updated successfully' : 'Failed to update profile'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error updating profile: ' . $e->getMessage()
            ];
        }
    }

    // Update availability
    public function update_availability($username, $availability) {
        try {
            // Check if table exists
            $tables = $this->db->list_tables();
            if (!in_array('interviewer_availability', $tables)) {
                return [
                    'success' => false,
                    'message' => 'Availability table not found. Please run: http://localhost/rms/index.php/Setup_interviewer'
                ];
            }
            
            // Check if column exists by trying a simple query
            $this->db->limit(1);
            $test = $this->db->get('interviewer_availability');
            
            // Delete existing availability
            $this->db->where('interviewer_username', $username);
            $this->db->delete('interviewer_availability');
            
            // Insert new availability
            if (!empty($availability)) {
                foreach ($availability as $slot) {
                    $slot['interviewer_username'] = $username;
                    $this->db->insert('interviewer_availability', $slot);
                }
            }
            
            return [
                'success' => true,
                'message' => 'Availability updated successfully'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Please run database setup first: http://localhost/rms/index.php/Setup_interviewer - Error: ' . $e->getMessage()
            ];
        }
    }

    // Get candidate resume
    public function get_candidate_resume($candidate_id) {
        $this->db->select('cd.*');
        $this->db->from('candidate_documents cd');
        $this->db->join('candidate_details c', 'cd.candidate_username = c.cd_email');
        $this->db->where('c.cd_id', $candidate_id);
        $this->db->where('cd.document_type', 'resume');
        $this->db->order_by('cd.uploaded_at', 'DESC');
        $this->db->limit(1);
        
        return $this->db->get()->row_array();
    }
}
