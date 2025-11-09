<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidate_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Get candidate's applications
    public function get_my_applications($email) {
        $this->db->select('ca.*, cd.cd_name');
        $this->db->from('candidate_applications ca');
        $this->db->join('candidate_details cd', 'ca.candidate_username = cd.cd_email', 'left');
        $this->db->where('ca.candidate_username', $email);
        $this->db->order_by('ca.applied_at', 'DESC');
        
        return $this->db->get()->result_array();
    }

    // Get upcoming interviews
    public function get_upcoming_interviews($email, $limit = 5) {
        $now = date('Y-m-d H:i:s');
        
        // Get candidate_id from email
        $this->db->select('cd_id');
        $this->db->where('cd_email', $email);
        $candidate = $this->db->get('candidate_details')->row_array();
        
        if (!$candidate) {
            return [];
        }
        
        $this->db->select('ia.*, ic.status as confirmation_status');
        $this->db->from('interview_assignments ia');
        $this->db->join('interview_confirmations ic', 'ia.interview_id = ic.interview_id AND ic.candidate_username = "' . $email . '"', 'left');
        $this->db->where('ia.candidate_id', $candidate['cd_id']);
        $this->db->where('ia.assigned_at >', $now);
        $this->db->order_by('ia.assigned_at', 'ASC');
        $this->db->limit($limit);
        
        return $this->db->get()->result_array();
    }

    // Get candidate statistics
    public function get_candidate_stats($email) {
        $stats = [];
        
        // Total applications
        $this->db->where('candidate_username', $email);
        $stats['total_applications'] = $this->db->count_all_results('candidate_applications');
        
        // Active applications
        $this->db->where('candidate_username', $email);
        $this->db->where_in('status', ['applied', 'screening', 'interview_scheduled', 'interviewed']);
        $stats['active_applications'] = $this->db->count_all_results('candidate_applications');
        
        // Interviews scheduled
        $this->db->select('cd_id');
        $this->db->where('cd_email', $email);
        $candidate = $this->db->get('candidate_details')->row_array();
        
        if ($candidate) {
            $this->db->where('candidate_id', $candidate['cd_id']);
            $stats['total_interviews'] = $this->db->count_all_results('interview_assignments');
        } else {
            $stats['total_interviews'] = 0;
        }
        
        // Unread messages
        $this->db->where('to_username', $email);
        $this->db->where('is_read', 0);
        $stats['unread_messages'] = $this->db->count_all_results('messages');
        
        return $stats;
    }

    // Get interview events for calendar
    public function get_interview_events($email) {
        // Get candidate_id
        $this->db->select('cd_id, cd_name');
        $this->db->where('cd_email', $email);
        $candidate = $this->db->get('candidate_details')->row_array();
        
        if (!$candidate) {
            return [];
        }
        
        $this->db->select('ia.*, ic.status as confirmation_status');
        $this->db->from('interview_assignments ia');
        $this->db->join('interview_confirmations ic', 'ia.interview_id = ic.interview_id AND ic.candidate_username = "' . $email . '"', 'left');
        $this->db->where('ia.candidate_id', $candidate['cd_id']);
        $this->db->order_by('ia.assigned_at', 'ASC');
        
        $results = $this->db->get()->result_array();
        
        $events = [];
        foreach ($results as $row) {
            $status = $row['confirmation_status'] ?: 'pending';
            $events[] = [
                'id' => $row['id'],
                'title' => 'Interview with ' . $row['interviewer_username'],
                'start' => $row['assigned_at'],
                'end' => date('Y-m-d H:i:s', strtotime($row['assigned_at'] . ' +1 hour')),
                'status' => $status,
                'interview_id' => $row['interview_id'],
                'className' => 'interview-' . $status
            ];
        }
        
        return $events;
    }

    // Confirm interview
    public function confirm_interview($interview_id, $email, $status) {
        // Check if confirmation already exists
        $this->db->where('interview_id', $interview_id);
        $this->db->where('candidate_username', $email);
        $existing = $this->db->get('interview_confirmations')->row_array();
        
        $data = [
            'status' => $status,
            'confirmed_at' => date('Y-m-d H:i:s')
        ];
        
        if ($existing) {
            $this->db->where('id', $existing['id']);
            $result = $this->db->update('interview_confirmations', $data);
        } else {
            $data['interview_id'] = $interview_id;
            $data['candidate_username'] = $email;
            $result = $this->db->insert('interview_confirmations', $data);
        }
        
        return [
            'success' => $result,
            'message' => $result ? 'Interview ' . $status . ' successfully' : 'Failed to update status'
        ];
    }

    // Request reschedule
    public function request_reschedule($interview_id, $email, $reason, $preferred_dates) {
        $data = [
            'interview_id' => $interview_id,
            'candidate_username' => $email,
            'status' => 'reschedule_requested',
            'reschedule_reason' => $reason,
            'preferred_dates' => json_encode($preferred_dates)
        ];
        
        // Check if exists
        $this->db->where('interview_id', $interview_id);
        $this->db->where('candidate_username', $email);
        $existing = $this->db->get('interview_confirmations')->row_array();
        
        if ($existing) {
            $this->db->where('id', $existing['id']);
            $result = $this->db->update('interview_confirmations', $data);
        } else {
            $result = $this->db->insert('interview_confirmations', $data);
        }
        
        return [
            'success' => $result,
            'message' => $result ? 'Reschedule request submitted' : 'Failed to submit request'
        ];
    }

    // Get candidate documents
    public function get_my_documents($email) {
        $this->db->where('candidate_username', $email);
        $this->db->order_by('uploaded_at', 'DESC');
        return $this->db->get('candidate_documents')->result_array();
    }

    // Save document
    public function save_document($document_data) {
        $result = $this->db->insert('candidate_documents', $document_data);
        
        return [
            'success' => $result,
            'message' => $result ? 'Document uploaded successfully' : 'Failed to upload document'
        ];
    }

    // Delete document
    public function delete_document($document_id, $email) {
        // Get document info
        $this->db->where('id', $document_id);
        $this->db->where('candidate_username', $email);
        $document = $this->db->get('candidate_documents')->row_array();
        
        if ($document) {
            // Delete file
            if (file_exists($document['file_path'])) {
                unlink($document['file_path']);
            }
            
            // Delete record
            $this->db->where('id', $document_id);
            $result = $this->db->delete('candidate_documents');
            
            return [
                'success' => $result,
                'message' => $result ? 'Document deleted successfully' : 'Failed to delete document'
            ];
        }
        
        return [
            'success' => false,
            'message' => 'Document not found'
        ];
    }

    // Get messages
    public function get_my_messages($username) {
        $this->db->where('to_username', $username);
        $this->db->order_by('sent_at', 'DESC');
        return $this->db->get('messages')->result_array();
    }

    // Mark message as read
    public function mark_message_read($message_id) {
        $this->db->where('id', $message_id);
        $result = $this->db->update('messages', ['is_read' => 1, 'read_at' => date('Y-m-d H:i:s')]);
        
        return ['success' => $result];
    }

    // Get user info
    public function get_user_info($username) {
        $this->db->where('u_username', $username);
        return $this->db->get('users')->row_array();
    }

    // Get candidate info
    public function get_candidate_info($email) {
        $this->db->where('cd_email', $email);
        return $this->db->get('candidate_details')->row_array();
    }

    // Get CV data
    public function get_cv_data($email) {
        $this->db->where('cd_email', $email);
        $candidate = $this->db->get('candidate_details')->row_array();
        
        if (!$candidate) {
            return [];
        }
        
        // Return all candidate details as CV data
        return $candidate;
    }

    // Save CV data
    public function save_cv_data($email, $cv_data) {
        try {
            // Map form fields to database columns
            $update_data = [];
            $field_mapping = [
                'full_name' => 'cd_name',
                'email' => 'cd_email',
                'phone' => 'cd_phone',
                'address' => 'cd_address',
                'city' => 'cd_city',
                'country' => 'cd_country',
                'postal_code' => 'cd_postal_code',
                'linkedin' => 'cd_linkedin',
                'website' => 'cd_website',
                'summary' => 'cd_summary',
                'skills' => 'cd_skills',
                'education' => 'cd_education',
                'experience' => 'cd_experience',
                'certifications' => 'cd_certifications',
                'languages' => 'cd_languages',
                'hobbies' => 'cd_hobbies'
            ];
            
            foreach ($field_mapping as $form_field => $db_field) {
                if (isset($cv_data[$form_field])) {
                    $update_data[$db_field] = $cv_data[$form_field];
                }
            }
            
            if (empty($update_data)) {
                return ['success' => false, 'message' => 'No data to update'];
            }
            
            // Check if candidate exists
            $this->db->where('cd_email', $email);
            $existing = $this->db->get('candidate_details')->row_array();
            
            if ($existing) {
                $this->db->where('cd_email', $email);
                $result = $this->db->update('candidate_details', $update_data);
            } else {
                $update_data['cd_email'] = $email;
                $result = $this->db->insert('candidate_details', $update_data);
            }
            
            return [
                'success' => $result,
                'message' => $result ? 'CV saved successfully' : 'Failed to save CV'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error saving CV: ' . $e->getMessage()
            ];
        }
    }

    // Update profile picture
    public function update_profile_picture($username, $file_path) {
        try {
            // Check if u_profile_picture column exists
            $fields = $this->db->list_fields('users');
            
            if (!in_array('u_profile_picture', $fields)) {
                return [
                    'success' => false,
                    'message' => 'Profile picture column not found. Please run: ' . base_url('Add_profile_picture_column')
                ];
            }
            
            // Delete old profile picture if exists
            $this->db->select('u_profile_picture');
            $this->db->where('u_username', $username);
            $user = $this->db->get('users')->row_array();
            
            if ($user && !empty($user['u_profile_picture']) && file_exists($user['u_profile_picture'])) {
                unlink($user['u_profile_picture']);
            }
            
            // Update with new picture
            $this->db->where('u_username', $username);
            $result = $this->db->update('users', ['u_profile_picture' => $file_path]);
            
            return [
                'success' => $result,
                'message' => $result ? 'Profile picture updated successfully' : 'Failed to update profile picture'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error updating profile picture: ' . $e->getMessage()
            ];
        }
    }

    // Update profile
    public function update_profile($username, $email, $profile_data, $candidate_data) {
        try {
            $updated = false;
            
            // Update users table
            $fields = $this->db->list_fields('users');
            $filtered_profile = [];
            foreach ($profile_data as $key => $value) {
                if (in_array($key, $fields)) {
                    $filtered_profile[$key] = $value;
                }
            }
            
            if (!empty($filtered_profile)) {
                $this->db->where('u_username', $username);
                if ($this->db->update('users', $filtered_profile)) {
                    $updated = true;
                }
            }
            
            // Update candidate_details table
            $cd_fields = $this->db->list_fields('candidate_details');
            $filtered_candidate = [];
            foreach ($candidate_data as $key => $value) {
                if (in_array($key, $cd_fields) && !empty($value)) {
                    $filtered_candidate[$key] = $value;
                }
            }
            
            if (!empty($filtered_candidate)) {
                // Check if candidate record exists
                $this->db->where('cd_email', $email);
                $existing = $this->db->get('candidate_details')->row_array();
                
                if ($existing) {
                    $this->db->where('cd_email', $email);
                    if ($this->db->update('candidate_details', $filtered_candidate)) {
                        $updated = true;
                    }
                } else {
                    // Create new candidate record
                    $filtered_candidate['cd_email'] = $email;
                    $filtered_candidate['cd_name'] = $username;
                    if ($this->db->insert('candidate_details', $filtered_candidate)) {
                        $updated = true;
                    }
                }
            }
            
            return [
                'success' => $updated,
                'message' => $updated ? 'Profile updated successfully' : 'No changes were made'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error updating profile: ' . $e->getMessage()
            ];
        }
    }

    // Get all selected candidates for Admin
    public function get_selected_all_candidate($data) {
        $this->db->select('cd.*, ce.ce_interview_round, ce.ce_start_date, ce.ce_end_date, ce.ce_interviewer');
        $this->db->from('candidate_details cd');
        $this->db->join('calendar_events ce', 'cd.cd_id = ce.ce_id', 'left');
        $this->db->where('cd.cd_status', 'Selected');
        $this->db->order_by('cd.cd_id', 'DESC');
        return $this->db->get();
    }

    // Get selected candidates for specific recruiter
    public function get_selected_candidate($data) {
        $this->db->select('*');
        $this->db->from('candidate_details');
        $this->db->where('cd_rec_username', $data['uname']);
        $this->db->where('cd_status', 'Selected');
        $this->db->order_by('cd_id', 'DESC');
        return $this->db->get();
    }

    // Get last candidate added by recruiter
    public function last_candidate($data) {
        $this->db->select('*');
        $this->db->from('candidate_details');
        $this->db->where('cd_rec_username', $data['uname']);
        $this->db->order_by('cd_id', 'DESC');
        $this->db->limit(5); // Get last 5 candidates instead of 1
        $query = $this->db->get();
        return $query->result_array(); // Return array of rows instead of single row
    }

    // Get all candidates for recruiter
    public function get_candidate($data) {
        $this->db->select('*');
        $this->db->from('candidate_details');
        $this->db->where('cd_rec_username', $data['uname']);
        $this->db->order_by('cd_id', 'DESC');
        return $this->db->get();
    }

    // Get only interested candidates
    public function only_interested_can() {
        $this->db->select('*');
        $this->db->from('candidate_details');
        $this->db->where('cd_status', 'Interested');
        $query = $this->db->get();
        return $query->num_rows();
    }

    // Check candidate status
    public function check_status() {
        $status = $this->input->post('can_current_status');
        return ($status == 'Interested' || $status == 'Selected');
    }

    // Update interview status
    public function update_interview_status() {
        $can_id = $this->input->post('can_id');
        $data = array(
            'cd_interview_status' => 1
        );
        $this->db->where('cd_id', $can_id);
        return $this->db->update('candidate_details', $data);
    }

    // Upload candidate
    public function upload_can($rec_username) {
        $data = array(
            'cd_rec_username' => $rec_username,
            'cd_name' => $this->input->post('cname'),
            'cd_email' => $this->input->post('cemail'),
            'cd_phone' => $this->input->post('cphone'),
            'cd_gender' => $this->input->post('cgender'),
            'cd_job_title' => $this->input->post('cjob_title'),
            'cd_source' => $this->input->post('csource'),
            'cd_description' => $this->input->post('cdescription'),
            'cd_status' => $this->input->post('can_current_status'),
            'cd_interview_status' => 0
        );
        
        return $this->db->insert('candidate_details', $data);
    }

    // Get last inserted candidate ID
    public function get_id() {
        return $this->db->insert_id();
    }

    // Get candidate by ID
    public function get_can_by_id($can_id) {
        $this->db->select('*');
        $this->db->from('candidate_details');
        $this->db->where('cd_id', $can_id);
        $query = $this->db->get();
        return $query->result_array();
    }
}
