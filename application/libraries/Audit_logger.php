<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Audit Logger Library
 * 
 * Use this library to log user activities throughout the application
 * 
 * Usage:
 * $this->load->library('audit_logger');
 * $this->audit_logger->log('CREATE', 'Candidate', $candidate_id, $candidate_name, 'Created new candidate');
 */
class Audit_logger
{
    protected $CI;
    
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->database();
    }
    
    /**
     * Log an activity
     * 
     * @param string $action Action performed (CREATE, UPDATE, DELETE, LOGIN, LOGOUT, EXPORT, etc.)
     * @param string $resource_type Type of resource (Candidate, User, Job, Interview, etc.)
     * @param int $resource_id ID of the resource (optional)
     * @param string $resource_name Name of the resource (optional)
     * @param string $description Human-readable description (optional)
     * @param array $old_values Old values before change (optional)
     * @param array $new_values New values after change (optional)
     * @param string $status Status of the action (success/failed)
     * @param string $error_message Error message if failed (optional)
     * @return bool
     */
    public function log($action, $resource_type, $resource_id = null, $resource_name = null, $description = null, $old_values = null, $new_values = null, $status = 'success', $error_message = null)
    {
        // Check if audit_logs table exists
        if (!$this->CI->db->table_exists('audit_logs')) {
            return false;
        }
        
        $data = [
            'user_id' => $this->CI->session->userdata('u_id'),
            'username' => $this->CI->session->userdata('username'),
            'user_email' => $this->CI->session->userdata('email'),
            'user_role' => $this->CI->session->userdata('role'),
            'action' => strtoupper($action),
            'resource_type' => $resource_type,
            'resource_id' => $resource_id,
            'resource_name' => $resource_name,
            'description' => $description,
            'old_values' => $old_values ? json_encode($old_values) : null,
            'new_values' => $new_values ? json_encode($new_values) : null,
            'ip_address' => $this->CI->input->ip_address(),
            'user_agent' => $this->CI->input->user_agent(),
            'request_method' => $this->CI->input->method(),
            'request_url' => current_url(),
            'status' => $status,
            'error_message' => $error_message
        ];
        
        return $this->CI->db->insert('audit_logs', $data);
    }
    
    /**
     * Log a login attempt
     */
    public function log_login($username, $success = true, $error_message = null)
    {
        return $this->log(
            'LOGIN',
            'System',
            null,
            null,
            $success ? 'User logged in successfully' : 'Failed login attempt',
            null,
            null,
            $success ? 'success' : 'failed',
            $error_message
        );
    }
    
    /**
     * Log a logout
     */
    public function log_logout()
    {
        return $this->log(
            'LOGOUT',
            'System',
            null,
            null,
            'User logged out'
        );
    }
    
    /**
     * Log a create action
     */
    public function log_create($resource_type, $resource_id, $resource_name, $new_values = null)
    {
        return $this->log(
            'CREATE',
            $resource_type,
            $resource_id,
            $resource_name,
            "Created new $resource_type: $resource_name",
            null,
            $new_values
        );
    }
    
    /**
     * Log an update action
     */
    public function log_update($resource_type, $resource_id, $resource_name, $old_values = null, $new_values = null)
    {
        return $this->log(
            'UPDATE',
            $resource_type,
            $resource_id,
            $resource_name,
            "Updated $resource_type: $resource_name",
            $old_values,
            $new_values
        );
    }
    
    /**
     * Log a delete action
     */
    public function log_delete($resource_type, $resource_id, $resource_name, $old_values = null)
    {
        return $this->log(
            'DELETE',
            $resource_type,
            $resource_id,
            $resource_name,
            "Deleted $resource_type: $resource_name",
            $old_values
        );
    }
    
    /**
     * Log an export action
     */
    public function log_export($resource_type, $description = null)
    {
        return $this->log(
            'EXPORT',
            $resource_type,
            null,
            null,
            $description ?: "Exported $resource_type data"
        );
    }
    
    /**
     * Log a view action
     */
    public function log_view($resource_type, $resource_id, $resource_name)
    {
        return $this->log(
            'VIEW',
            $resource_type,
            $resource_id,
            $resource_name,
            "Viewed $resource_type: $resource_name"
        );
    }
    
    /**
     * Log a download action
     */
    public function log_download($resource_type, $resource_id, $resource_name)
    {
        return $this->log(
            'DOWNLOAD',
            $resource_type,
            $resource_id,
            $resource_name,
            "Downloaded $resource_type: $resource_name"
        );
    }
}
