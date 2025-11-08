<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recruiter_management extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Recruiter_model');
        $this->load->library('session');
        
        // Check if admin
        if (!$this->session->userdata('authenticated') || $this->session->userdata('Role') !== 'Admin') {
            redirect('login');
        }
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

        // Hash password
        $hashed_password = password_hash($input['password'], PASSWORD_DEFAULT);

        $data = [
            'u_username' => $input['username'],
            'u_email' => $input['email'],
            'u_password' => $hashed_password,
            'u_role' => 'Recruiter',
            'u_status' => isset($input['status']) ? (int)$input['status'] : 0
        ];

        $result = $this->Recruiter_model->create_recruiter($data);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Recruiter added successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add recruiter']);
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

        $status = isset($input['status']) ? (int)$input['status'] : 1;
        $result = $this->Recruiter_model->update_status($input['id'], $status);

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
