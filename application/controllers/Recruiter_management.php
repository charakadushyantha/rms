<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recruiter_management extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Recruiter_model');
        $this->load->library('session');
        
        // Check if user is authenticated (Admin role check)
        if (!$this->session->userdata('authenticated')) {
            if ($this->input->is_ajax_request()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Not authenticated']);
                exit;
            } else {
                redirect('login');
            }
        }
        
        // Optional: Check if user is Admin (uncomment if needed)
        // $role = $this->session->userdata('Role');
        // if ($role !== 'Admin') {
        //     if ($this->input->is_ajax_request()) {
        //         header('Content-Type: application/json');
        //         echo json_encode(['success' => false, 'message' => 'Access denied']);
        //         exit;
        //     } else {
        //         redirect('login');
        //     }
        // }
    }

    /**
     * Get all recruiters (AJAX)
     */
    public function get_recruiters() {
        header('Content-Type: application/json');
        
        $recruiters = $this->Recruiter_model->get_all_recruiters();
        echo json_encode(['success' => true, 'data' => $recruiters]);
    }

    /**
     * Add new recruiter
     */
    public function add_recruiter() {
        header('Content-Type: application/json');
        
        $input = json_decode(file_get_contents('php://input'), true);
        
        // Validate input
        if (empty($input['username']) || empty($input['email']) || empty($input['password'])) {
            echo json_encode(['success' => false, 'message' => 'All fields are required']);
            return;
        }

        // Check if username exists
        if ($this->Recruiter_model->username_exists($input['username'])) {
            echo json_encode(['success' => false, 'message' => 'Username already exists']);
            return;
        }

        // Check if email exists
        if ($this->Recruiter_model->email_exists($input['email'])) {
            echo json_encode(['success' => false, 'message' => 'Email already exists']);
            return;
        }

        // Hash password using md5 to match existing system
        $hashed_password = md5($input['password']);

        // Convert numeric status to text for VARCHAR column
        $status_value = isset($input['status']) ? (int)$input['status'] : 0;
        $status_text = ($status_value == 1) ? 'Active' : 'Pending';

        $data = [
            'u_username' => $input['username'],
            'u_email' => $input['email'],
            'u_password' => $hashed_password,
            'u_role' => 'Recruiter',
            'u_status' => $status_text
        ];

        $result = $this->Recruiter_model->create_recruiter($data);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Recruiter added successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add recruiter']);
        }
    }

    /**
     * Get single recruiter details (AJAX)
     */
    public function get_recruiter() {
        header('Content-Type: application/json');

        $input = json_decode(file_get_contents('php://input'), true);

        if (empty($input['id'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid recruiter ID']);
            return;
        }

        $this->db->select('u_id as id, u_username as username, u_email as email, u_status as status');
        $this->db->where('u_id', $input['id']);
        $this->db->where('u_role', 'Recruiter');
        $recruiter = $this->db->get('users')->row_array();

        if ($recruiter) {
            // Normalize status to numeric for JavaScript
            if (isset($recruiter['status'])) {
                if ($recruiter['status'] === 'Active' || $recruiter['status'] == '1' || $recruiter['status'] == 1) {
                    $recruiter['status'] = 1;
                } else {
                    $recruiter['status'] = 0;
                }
            }
            echo json_encode(['success' => true, 'data' => $recruiter]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Recruiter not found']);
        }
    }

    /**
     * Update recruiter details (AJAX)
     */
    public function update_recruiter() {
        header('Content-Type: application/json');

        $input = json_decode(file_get_contents('php://input'), true);

        if (empty($input['id']) || empty($input['email'])) {
            echo json_encode(['success' => false, 'message' => 'ID and email are required']);
            return;
        }

        // Check email not taken by another user
        $this->db->where('u_email', $input['email']);
        $this->db->where('u_id !=', (int)$input['id']);
        if ($this->db->count_all_results('users') > 0) {
            echo json_encode(['success' => false, 'message' => 'Email already in use by another account']);
            return;
        }

        $update = ['u_email' => $input['email']];

        if (!empty($input['password'])) {
            $update['u_password'] = md5($input['password']); // match existing md5 pattern
        }

        if (isset($input['status'])) {
            // Convert numeric status to text for VARCHAR column
            $status_value = (int)$input['status'];
            $update['u_status'] = ($status_value == 1) ? 'Active' : 'Pending';
        }

        $this->db->where('u_id', (int)$input['id']);
        $this->db->where('u_role', 'Recruiter');
        $this->db->update('users', $update);

        if ($this->db->affected_rows() >= 0) {
            echo json_encode(['success' => true, 'message' => 'Recruiter updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update recruiter']);
        }
    }

    /**
     * Update recruiter status
     */
    public function update_status() {
        header('Content-Type: application/json');
        
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (empty($input['id'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid recruiter ID']);
            return;
        }

        // Convert numeric status to text for VARCHAR column
        $status = isset($input['status']) ? (int)$input['status'] : 1;
        $status_text = ($status == 1) ? 'Active' : 'Pending';
        
        $result = $this->Recruiter_model->update_status($input['id'], $status_text);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Status updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update status']);
        }
    }

    /**
     * Delete recruiter
     */
    public function delete_recruiter() {
        header('Content-Type: application/json');
        
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (empty($input['id'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid recruiter ID']);
            return;
        }

        $result = $this->Recruiter_model->delete_recruiter($input['id']);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Recruiter deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete recruiter']);
        }
    }

    /**
     * Get recruiter statistics
     */
    public function get_stats() {
        header('Content-Type: application/json');
        
        $stats = $this->Recruiter_model->get_statistics();
        echo json_encode(['success' => true, 'stats' => $stats]);
    }
}
