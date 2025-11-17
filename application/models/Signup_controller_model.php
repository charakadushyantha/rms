<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup_controller_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get current signup settings
     */
    public function get_signup_settings()
    {
        try {
            // Check if table exists first
            if (!$this->db->table_exists('signup_settings')) {
                return $this->get_default_settings();
            }
            
            $this->db->where('id', 1);
            $result = $this->db->get('signup_settings');
            
            if ($result->num_rows() > 0) {
                return $result->row();
            } else {
                return $this->get_default_settings();
            }
        } catch (Exception $e) {
            // Return default settings if any error occurs
            log_message('error', 'Signup settings error: ' . $e->getMessage());
            return $this->get_default_settings();
        }
    }
    
    /**
     * Get default settings
     */
    private function get_default_settings()
    {
        return (object) array(
            'admin_signup_enabled' => 0,
            'recruiter_signup_enabled' => 1,
            'interviewer_signup_enabled' => 0,
            'candidate_signup_enabled' => 1,
            'auto_approve_admin' => 0,
            'auto_approve_recruiter' => 0,
            'auto_approve_interviewer' => 0,
            'auto_approve_candidate' => 1,
            'require_email_verification' => 1,
            'default_signup_role' => 'Recruiter'
        );
    }

    /**
     * Update signup settings
     */
    public function update_signup_settings($settings)
    {
        try {
            // Check if table exists first
            if (!$this->db->table_exists('signup_settings')) {
                return false; // Cannot update if table doesn't exist
            }
            
            // Check if settings exist
            $this->db->where('id', 1);
            $existing = $this->db->get('signup_settings');
            
            if ($existing->num_rows() > 0) {
                // Update existing settings
                $this->db->where('id', 1);
                return $this->db->update('signup_settings', $settings);
            } else {
                // Insert new settings
                $settings['id'] = 1;
                return $this->db->insert('signup_settings', $settings);
            }
        } catch (Exception $e) {
            log_message('error', 'Update signup settings error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get pending user registrations
     */
    public function get_pending_registrations()
    {
        try {
            $this->db->where('u_status', 'Pending');
            $this->db->order_by('u_id', 'DESC');
            $result = $this->db->get(TBL_USERS);
            
            return $result->result();
        } catch (Exception $e) {
            log_message('error', 'Get pending registrations error: ' . $e->getMessage());
            return array();
        }
    }

    /**
     * Get recent registrations (last 30 days)
     */
    public function get_recent_registrations($limit = 10)
    {
        try {
            // Check if created_at column exists
            $fields = $this->db->list_fields(TBL_USERS);
            if (in_array('created_at', $fields)) {
                $this->db->where('created_at >=', date('Y-m-d H:i:s', strtotime('-30 days')));
            }
            $this->db->order_by('u_id', 'DESC');
            $this->db->limit($limit);
            $result = $this->db->get(TBL_USERS);
            
            return $result->result();
        } catch (Exception $e) {
            log_message('error', 'Get recent registrations error: ' . $e->getMessage());
            return array();
        }
    }

    /**
     * Approve user registration
     */
    public function approve_user($user_id)
    {
        $data = array(
            'u_status' => 'Active',
            'approved_at' => date('Y-m-d H:i:s'),
            'approved_by' => $this->session->userdata('username')
        );
        
        $this->db->where('u_id', $user_id);
        return $this->db->update(TBL_USERS, $data);
    }

    /**
     * Reject user registration
     */
    public function reject_user($user_id, $reason = '')
    {
        $data = array(
            'u_status' => 'Rejected',
            'rejection_reason' => $reason,
            'rejected_at' => date('Y-m-d H:i:s'),
            'rejected_by' => $this->session->userdata('username')
        );
        
        $this->db->where('u_id', $user_id);
        return $this->db->update(TBL_USERS, $data);
    }

    /**
     * Get user by ID
     */
    public function get_user_by_id($user_id)
    {
        $this->db->where('u_id', $user_id);
        $result = $this->db->get(TBL_USERS);
        
        if ($result->num_rows() > 0) {
            return $result->row();
        }
        
        return false;
    }

    /**
     * Check if username exists
     */
    public function check_username_exists($username)
    {
        $this->db->where('u_username', $username);
        $result = $this->db->get(TBL_USERS);
        
        return $result->num_rows() > 0;
    }

    /**
     * Check if email exists
     */
    public function check_email_exists($email)
    {
        $this->db->where('u_email', $email);
        $result = $this->db->get(TBL_USERS);
        
        return $result->num_rows() > 0;
    }

    /**
     * Create new user
     */
    public function create_user($user_data)
    {
        $user_data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert(TBL_USERS, $user_data);
    }

    /**
     * Get signup statistics
     */
    public function get_signup_statistics()
    {
        $stats = array();
        
        // Total users by role
        $this->db->select('u_role, COUNT(*) as count');
        $this->db->group_by('u_role');
        $result = $this->db->get(TBL_USERS);
        $stats['by_role'] = $result->result();
        
        // Total users by status
        $this->db->select('u_status, COUNT(*) as count');
        $this->db->group_by('u_status');
        $result = $this->db->get(TBL_USERS);
        $stats['by_status'] = $result->result();
        
        // Recent registrations (last 7 days)
        $this->db->where('created_at >=', date('Y-m-d H:i:s', strtotime('-7 days')));
        $stats['recent_count'] = $this->db->count_all_results(TBL_USERS);
        
        // Pending approvals
        $this->db->where('u_status', 'Pending');
        $stats['pending_count'] = $this->db->count_all_results(TBL_USERS);
        
        return $stats;
    }

    /**
     * Check if role signup is enabled
     */
    public function is_role_signup_enabled($role)
    {
        $settings = $this->get_signup_settings();
        
        switch (strtolower($role)) {
            case 'admin':
                return $settings->admin_signup_enabled;
            case 'recruiter':
                return $settings->recruiter_signup_enabled;
            case 'interviewer':
                return $settings->interviewer_signup_enabled;
            case 'candidate':
                return $settings->candidate_signup_enabled;
            default:
                return false;
        }
    }

    /**
     * Check if role auto-approval is enabled
     */
    public function is_auto_approve_enabled($role)
    {
        $settings = $this->get_signup_settings();
        
        switch (strtolower($role)) {
            case 'admin':
                return $settings->auto_approve_admin;
            case 'recruiter':
                return $settings->auto_approve_recruiter;
            case 'interviewer':
                return $settings->auto_approve_interviewer;
            case 'candidate':
                return $settings->auto_approve_candidate;
            default:
                return false;
        }
    }

    /**
     * Get all users with pagination
     */
    public function get_all_users($limit = 20, $offset = 0, $search = '', $role_filter = '', $status_filter = '')
    {
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('u_username', $search);
            $this->db->or_like('u_email', $search);
            $this->db->group_end();
        }
        
        if (!empty($role_filter)) {
            $this->db->where('u_role', $role_filter);
        }
        
        if (!empty($status_filter)) {
            $this->db->where('u_status', $status_filter);
        }
        
        $this->db->order_by('u_id', 'DESC');
        $this->db->limit($limit, $offset);
        $result = $this->db->get(TBL_USERS);
        
        return $result->result();
    }

    /**
     * Count total users (for pagination)
     */
    public function count_users($search = '', $role_filter = '', $status_filter = '')
    {
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('u_username', $search);
            $this->db->or_like('u_email', $search);
            $this->db->group_end();
        }
        
        if (!empty($role_filter)) {
            $this->db->where('u_role', $role_filter);
        }
        
        if (!empty($status_filter)) {
            $this->db->where('u_status', $status_filter);
        }
        
        return $this->db->count_all_results(TBL_USERS);
    }
    
    /**
     * Get audit logs with pagination
     */
    public function get_audit_logs($limit = 50, $offset = 0)
    {
        try {
            if (!$this->db->table_exists('signup_audit_log')) {
                return array();
            }
            
            $this->db->order_by('created_at', 'DESC');
            $this->db->limit($limit, $offset);
            $result = $this->db->get('signup_audit_log');
            
            return $result->result();
        } catch (Exception $e) {
            log_message('error', 'Get audit logs error: ' . $e->getMessage());
            return array();
        }
    }
    
    /**
     * Count total audit logs
     */
    public function count_audit_logs()
    {
        try {
            if (!$this->db->table_exists('signup_audit_log')) {
                return 0;
            }
            
            return $this->db->count_all('signup_audit_log');
        } catch (Exception $e) {
            log_message('error', 'Count audit logs error: ' . $e->getMessage());
            return 0;
        }
    }
    
    /**
     * Get all audit logs (for export)
     */
    public function get_all_audit_logs()
    {
        try {
            if (!$this->db->table_exists('signup_audit_log')) {
                return array();
            }
            
            $this->db->order_by('created_at', 'DESC');
            $result = $this->db->get('signup_audit_log');
            
            return $result->result();
        } catch (Exception $e) {
            log_message('error', 'Get all audit logs error: ' . $e->getMessage());
            return array();
        }
    }
    
    /**
     * Update user
     */
    public function update_user($user_id, $data)
    {
        try {
            $this->db->where('u_id', $user_id);
            return $this->db->update(TBL_USERS, $data);
        } catch (Exception $e) {
            log_message('error', 'Update user error: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Delete user
     */
    public function delete_user($user_id)
    {
        try {
            $this->db->where('u_id', $user_id);
            return $this->db->delete(TBL_USERS);
        } catch (Exception $e) {
            log_message('error', 'Delete user error: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Search and filter users
     */
    public function search_users($search = '', $role = '', $status = '')
    {
        try {
            $this->db->select('*');
            $this->db->from(TBL_USERS);
            
            // Apply search filter
            if (!empty($search)) {
                $this->db->group_start();
                $this->db->like('u_username', $search);
                $this->db->or_like('u_email', $search);
                $this->db->group_end();
            }
            
            // Apply role filter
            if (!empty($role)) {
                $this->db->where('u_role', $role);
            }
            
            // Apply status filter
            if (!empty($status)) {
                $this->db->where('u_status', $status);
            }
            
            $this->db->order_by('u_id', 'DESC');
            $result = $this->db->get();
            
            return $result->result();
        } catch (Exception $e) {
            log_message('error', 'Search users error: ' . $e->getMessage());
            return array();
        }
    }
}
