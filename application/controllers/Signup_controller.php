<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup_controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Signup_controller_model');
        $this->load->library('session');
        
        // Check if user is logged in and is Admin
        if (!$this->session->userdata('authenticated') || $this->session->userdata('Role') != 'Admin') {
            redirect(LOGIN_URL);
        }
    }

    /**
     * Main Signup Controller Dashboard
     */
    public function index()
    {
        // Check if setup is required
        if (!$this->db->table_exists('signup_settings')) {
            $this->show_setup_required();
            return;
        }
        
        $data['page_title'] = 'Signup Access Control';
        $data['signup_settings'] = $this->Signup_controller_model->get_signup_settings();
        $data['pending_registrations'] = $this->Signup_controller_model->get_pending_registrations();
        $data['recent_registrations'] = $this->Signup_controller_model->get_recent_registrations();
        
        $this->load->view('admin/signup_controller_dashboard', $data);
    }
    
    /**
     * Show setup required page
     */
    private function show_setup_required()
    {
        $data['page_title'] = 'Signup Controller - Setup Required';
        $data['setup_url'] = base_url('create_signup_settings_table.php');
        
        echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Required - Signup Controller</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; font-family: "Inter", sans-serif; }
        .setup-container { max-width: 600px; margin: 100px auto; }
        .setup-card { background: white; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); padding: 40px; text-align: center; }
        .setup-icon { font-size: 64px; color: #667eea; margin-bottom: 24px; }
        .setup-title { font-size: 28px; font-weight: 700; color: #2d3748; margin-bottom: 16px; }
        .setup-description { color: #718096; margin-bottom: 32px; line-height: 1.6; }
        .btn-setup { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 12px 32px; border-radius: 8px; font-weight: 600; text-decoration: none; display: inline-block; transition: all 0.3s; }
        .btn-setup:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4); color: white; }
        .setup-steps { text-align: left; margin-top: 32px; }
        .setup-step { display: flex; align-items: center; margin-bottom: 12px; }
        .step-number { width: 24px; height: 24px; background: #667eea; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 600; margin-right: 12px; }
    </style>
</head>
<body>
    <div class="setup-container">
        <div class="setup-card">
            <div class="setup-icon">
                <i class="fas fa-database"></i>
            </div>
            <h1 class="setup-title">Setup Required</h1>
            <p class="setup-description">
                The Signup Controller requires database tables to be created before it can be used. 
                Please run the setup script to initialize the required tables.
            </p>
            
            <a href="' . $data['setup_url'] . '" class="btn-setup" target="_blank">
                <i class="fas fa-play me-2"></i>Run Setup Script
            </a>
            
            <div class="setup-steps">
                <h6 style="color: #2d3748; font-weight: 600; margin-bottom: 16px;">Setup Steps:</h6>
                <div class="setup-step">
                    <div class="step-number">1</div>
                    <span>Click "Run Setup Script" above</span>
                </div>
                <div class="setup-step">
                    <div class="step-number">2</div>
                    <span>Wait for tables to be created</span>
                </div>
                <div class="setup-step">
                    <div class="step-number">3</div>
                    <span>Return to this page and refresh</span>
                </div>
            </div>
            
            <div style="margin-top: 24px; padding-top: 24px; border-top: 1px solid #e2e8f0;">
                <a href="' . A_DASHBOARD_URL . '" class="text-muted" style="text-decoration: none;">
                    <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</body>
</html>';
    }

    /**
     * Update signup settings for each role
     */
    public function update_settings()
    {
        if ($this->input->method() == 'post') {
            $settings = array(
                'admin_signup_enabled' => $this->input->post('admin_signup_enabled') ? 1 : 0,
                'recruiter_signup_enabled' => $this->input->post('recruiter_signup_enabled') ? 1 : 0,
                'interviewer_signup_enabled' => $this->input->post('interviewer_signup_enabled') ? 1 : 0,
                'candidate_signup_enabled' => $this->input->post('candidate_signup_enabled') ? 1 : 0,
                'auto_approve_admin' => $this->input->post('auto_approve_admin') ? 1 : 0,
                'auto_approve_recruiter' => $this->input->post('auto_approve_recruiter') ? 1 : 0,
                'auto_approve_interviewer' => $this->input->post('auto_approve_interviewer') ? 1 : 0,
                'auto_approve_candidate' => $this->input->post('auto_approve_candidate') ? 1 : 0,
                'require_email_verification' => $this->input->post('require_email_verification') ? 1 : 0,
                'default_signup_role' => $this->input->post('default_signup_role'),
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => $this->session->userdata('username')
            );

            if ($this->Signup_controller_model->update_signup_settings($settings)) {
                // Log the activity with readable format
                $enabled_roles = array();
                if ($settings['admin_signup_enabled']) $enabled_roles[] = 'Admin';
                if ($settings['recruiter_signup_enabled']) $enabled_roles[] = 'Recruiter';
                if ($settings['interviewer_signup_enabled']) $enabled_roles[] = 'Interviewer';
                if ($settings['candidate_signup_enabled']) $enabled_roles[] = 'Candidate';
                
                $auto_approve = array();
                if ($settings['auto_approve_admin']) $auto_approve[] = 'Admin';
                if ($settings['auto_approve_recruiter']) $auto_approve[] = 'Recruiter';
                if ($settings['auto_approve_interviewer']) $auto_approve[] = 'Interviewer';
                if ($settings['auto_approve_candidate']) $auto_approve[] = 'Candidate';
                
                $details = 'Enabled Roles: ' . (empty($enabled_roles) ? 'None' : implode(', ', $enabled_roles)) . 
                          ' | Auto-approve: ' . (empty($auto_approve) ? 'None' : implode(', ', $auto_approve)) .
                          ' | Default Role: ' . $settings['default_signup_role'];
                
                $this->log_activity('settings_updated', $details);
                
                $this->session->set_flashdata('success', 'Signup settings updated successfully!');
            } else {
                $this->session->set_flashdata('error', 'Failed to update signup settings.');
            }
        }
        
        redirect('Signup_controller');
    }
    
    /**
     * Log signup activity
     */
    private function log_activity($action, $details, $extra_data = null)
    {
        try {
            if ($this->db->table_exists('signup_audit_log')) {
                $log_data = array(
                    'action' => $action,
                    'details' => $details,
                    'ip_address' => $this->input->ip_address(),
                    'user_agent' => $this->input->user_agent(),
                    'performed_by' => $this->session->userdata('username'),
                    'created_at' => date('Y-m-d H:i:s')
                );
                
                if ($extra_data) {
                    $log_data['details'] .= ' - ' . $extra_data;
                }
                
                $this->db->insert('signup_audit_log', $log_data);
            }
        } catch (Exception $e) {
            log_message('error', 'Failed to log activity: ' . $e->getMessage());
        }
    }

    /**
     * Approve pending registration
     */
    public function approve_registration($user_id)
    {
        if ($this->Signup_controller_model->approve_user($user_id)) {
            // Send approval email
            $user = $this->Signup_controller_model->get_user_by_id($user_id);
            if ($user) {
                $this->send_approval_email($user);
                
                // Log the activity
                $this->log_activity('user_approved', "Approved user: {$user->u_username} ({$user->u_role})");
            }
            
            $this->session->set_flashdata('success', 'User registration approved successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to approve user registration.');
        }
        
        redirect('Signup_controller');
    }

    /**
     * Reject pending registration
     */
    public function reject_registration($user_id)
    {
        $reason = $this->input->post('rejection_reason');
        
        if ($this->Signup_controller_model->reject_user($user_id, $reason)) {
            // Send rejection email
            $user = $this->Signup_controller_model->get_user_by_id($user_id);
            if ($user) {
                $this->send_rejection_email($user, $reason);
                
                // Log the activity
                $this->log_activity('user_rejected', "Rejected user: {$user->u_username} ({$user->u_role})", "Reason: {$reason}");
            }
            
            $this->session->set_flashdata('success', 'User registration rejected.');
        } else {
            $this->session->set_flashdata('error', 'Failed to reject user registration.');
        }
        
        redirect('Signup_controller');
    }

    /**
     * Bulk approve multiple registrations
     */
    public function bulk_approve()
    {
        $user_ids = $this->input->post('selected_users');
        
        if (!empty($user_ids)) {
            $approved_count = 0;
            $usernames = array();
            
            foreach ($user_ids as $user_id) {
                if ($this->Signup_controller_model->approve_user($user_id)) {
                    $approved_count++;
                    
                    // Send approval email
                    $user = $this->Signup_controller_model->get_user_by_id($user_id);
                    if ($user) {
                        $this->send_approval_email($user);
                        $usernames[] = $user->u_username;
                    }
                }
            }
            
            // Log bulk approval
            if ($approved_count > 0) {
                $this->log_activity('bulk_approval', "Bulk approved {$approved_count} users", implode(', ', $usernames));
            }
            
            $this->session->set_flashdata('success', "Successfully approved {$approved_count} user registrations!");
        } else {
            $this->session->set_flashdata('error', 'No users selected for approval.');
        }
        
        redirect('Signup_controller');
    }

    /**
     * Create new user account (Admin function)
     */
    public function create_user()
    {
        if ($this->input->method() == 'post') {
            $user_data = array(
                'u_username' => $this->input->post('username'),
                'u_email' => $this->input->post('email'),
                'u_password' => md5($this->input->post('password')),
                'u_role' => $this->input->post('role'),
                'u_status' => $this->input->post('auto_activate') ? 'Active' : 'Pending',
                'created_by' => $this->session->userdata('username')
            );

            // Check if username or email already exists
            if ($this->Signup_controller_model->check_username_exists($user_data['u_username'])) {
                $this->session->set_flashdata('error', 'Username already exists!');
                redirect('Signup_controller');
                return;
            }

            if ($this->Signup_controller_model->check_email_exists($user_data['u_email'])) {
                $this->session->set_flashdata('error', 'Email already exists!');
                redirect('Signup_controller');
                return;
            }

            if ($this->Signup_controller_model->create_user($user_data)) {
                // Log the activity
                $this->log_activity('user_created', "Created user: {$user_data['u_username']} ({$user_data['u_role']})", "Status: {$user_data['u_status']}");
                
                $this->session->set_flashdata('success', 'User account created successfully!');
                
                // Send welcome email if activated
                if ($user_data['u_status'] == 'Active') {
                    $this->send_welcome_email($user_data);
                }
            } else {
                $this->session->set_flashdata('error', 'Failed to create user account.');
            }
        }
        
        redirect('Signup_controller');
    }

    /**
     * Get signup settings via AJAX
     */
    public function get_settings()
    {
        $settings = $this->Signup_controller_model->get_signup_settings();
        header('Content-Type: application/json');
        echo json_encode($settings);
    }
    
    /**
     * View audit logs
     */
    public function audit_logs()
    {
        $data['page_title'] = 'Signup Audit Logs';
        
        // Get pagination parameters
        $limit = 50;
        $offset = $this->input->get('offset') ? (int)$this->input->get('offset') : 0;
        
        // Get audit logs
        $data['audit_logs'] = $this->Signup_controller_model->get_audit_logs($limit, $offset);
        $data['total_logs'] = $this->Signup_controller_model->count_audit_logs();
        $data['limit'] = $limit;
        $data['offset'] = $offset;
        
        $this->load->view('admin/signup_audit_logs', $data);
    }
    
    /**
     * Export audit logs to CSV
     */
    public function export_audit_logs()
    {
        $logs = $this->Signup_controller_model->get_all_audit_logs();
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=signup_audit_logs_' . date('Y-m-d') . '.csv');
        
        $output = fopen('php://output', 'w');
        fputcsv($output, array('ID', 'Action', 'Details', 'Performed By', 'IP Address', 'Date/Time'));
        
        foreach ($logs as $log) {
            fputcsv($output, array(
                $log->id,
                $log->action,
                $log->details,
                $log->performed_by,
                $log->ip_address,
                $log->created_at
            ));
        }
        
        fclose($output);
        exit;
    }
    
    /**
     * Get user details for editing (AJAX)
     */
    public function get_user_details()
    {
        $user_id = $this->input->post('user_id');
        
        if (!$user_id) {
            echo json_encode(['success' => false, 'message' => 'User ID is required']);
            return;
        }
        
        $user = $this->Signup_controller_model->get_user_by_id($user_id);
        
        if ($user) {
            echo json_encode(['success' => true, 'user' => $user]);
        } else {
            echo json_encode(['success' => false, 'message' => 'User not found']);
        }
    }
    
    /**
     * Update user details
     */
    public function update_user()
    {
        if ($this->input->method() == 'post') {
            $user_id = $this->input->post('user_id');
            $username = $this->input->post('username');
            $email = $this->input->post('email');
            $role = $this->input->post('role');
            $status = $this->input->post('status');
            $password = $this->input->post('password');
            
            // Get current user data
            $current_user = $this->Signup_controller_model->get_user_by_id($user_id);
            
            if (!$current_user) {
                echo json_encode(['success' => false, 'message' => 'User not found']);
                return;
            }
            
            // Check if username changed and if new username exists
            if ($username != $current_user->u_username) {
                if ($this->Signup_controller_model->check_username_exists($username)) {
                    echo json_encode(['success' => false, 'message' => 'Username already exists']);
                    return;
                }
            }
            
            // Check if email changed and if new email exists
            if ($email != $current_user->u_email) {
                if ($this->Signup_controller_model->check_email_exists($email)) {
                    echo json_encode(['success' => false, 'message' => 'Email already exists']);
                    return;
                }
            }
            
            // Prepare update data
            $update_data = array(
                'u_username' => $username,
                'u_email' => $email,
                'u_role' => $role,
                'u_status' => $status
            );
            
            // Add password if provided
            if (!empty($password)) {
                $update_data['u_password'] = md5($password);
            }
            
            // Update user
            if ($this->Signup_controller_model->update_user($user_id, $update_data)) {
                // Log the activity
                $this->log_activity('user_updated', "Updated user: {$username} ({$role})", "Status: {$status}");
                
                echo json_encode(['success' => true, 'message' => 'User updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update user']);
            }
        }
    }
    
    /**
     * Delete user
     */
    public function delete_user()
    {
        $user_id = $this->input->post('user_id');
        
        if (!$user_id) {
            echo json_encode(['success' => false, 'message' => 'User ID is required']);
            return;
        }
        
        // Get user details before deletion
        $user = $this->Signup_controller_model->get_user_by_id($user_id);
        
        if (!$user) {
            echo json_encode(['success' => false, 'message' => 'User not found']);
            return;
        }
        
        // Prevent deleting yourself
        if ($user->u_username == $this->session->userdata('username')) {
            echo json_encode(['success' => false, 'message' => 'You cannot delete your own account']);
            return;
        }
        
        // Delete user
        if ($this->Signup_controller_model->delete_user($user_id)) {
            // Log the activity
            $this->log_activity('user_deleted', "Deleted user: {$user->u_username} ({$user->u_role})");
            
            echo json_encode(['success' => true, 'message' => 'User deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete user']);
        }
    }
    
    /**
     * Change user status (Activate/Deactivate)
     */
    public function change_user_status()
    {
        $user_id = $this->input->post('user_id');
        $status = $this->input->post('status');
        
        if (!$user_id || !$status) {
            echo json_encode(['success' => false, 'message' => 'User ID and status are required']);
            return;
        }
        
        $user = $this->Signup_controller_model->get_user_by_id($user_id);
        
        if (!$user) {
            echo json_encode(['success' => false, 'message' => 'User not found']);
            return;
        }
        
        // Update status
        if ($this->Signup_controller_model->update_user($user_id, array('u_status' => $status))) {
            // Log the activity
            $this->log_activity('status_changed', "Changed status for user: {$user->u_username} to {$status}");
            
            echo json_encode(['success' => true, 'message' => 'User status updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update user status']);
        }
    }
    
    /**
     * Search and filter users (AJAX)
     */
    public function search_users()
    {
        $search = $this->input->post('search');
        $role = $this->input->post('role');
        $status = $this->input->post('status');
        
        // Get filtered users
        $users = $this->Signup_controller_model->search_users($search, $role, $status);
        
        if (!empty($users)) {
            echo json_encode([
                'success' => true,
                'users' => $users,
                'count' => count($users)
            ]);
        } else {
            echo json_encode([
                'success' => true,
                'users' => [],
                'count' => 0
            ]);
        }
    }

    /**
     * Send approval email to user
     */
    private function send_approval_email($user)
    {
        try {
            $config = array(
                'protocol'    => 'smtp',
                'smtp_host'   => 'smtp.gmail.com',
                'smtp_port'   => 587,
                'smtp_timeout' => 60,
                'smtp_user'   => SENDER_EMAIL,
                'smtp_pass'   => SENDER_PASSWORD,
                'smtp_crypto' => 'tls',
                'charset'     => 'utf-8',
                'newline'     => "\r\n",
                'mailtype'    => 'html',
                'validation'  => TRUE
            );
            
            $this->load->library('email', $config);
            
            $this->email->from(SENDER_EMAIL, 'RMS Admin');
            $this->email->to($user->u_email);
            $this->email->subject('Account Approved - Welcome to RMS');
            
            $message = "
                <html>
                <head><title>Account Approved</title></head>
                <body>
                    <h2>Welcome to RMS!</h2>
                    <p>Dear {$user->u_username},</p>
                    <p>Your account has been approved and activated.</p>
                    <p><strong>Role:</strong> {$user->u_role}</p>
                    <p>You can now login to the system using your credentials.</p>
                    <p><a href='".LOGIN_URL."' style='background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Login Now</a></p>
                    <p>Best regards,<br>RMS Admin Team</p>
                </body>
                </html>
            ";
            
            $this->email->message($message);
            return $this->email->send();
        } catch (Exception $e) {
            log_message('error', 'Approval email failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send rejection email to user
     */
    private function send_rejection_email($user, $reason = '')
    {
        try {
            $config = array(
                'protocol'    => 'smtp',
                'smtp_host'   => 'smtp.gmail.com',
                'smtp_port'   => 587,
                'smtp_timeout' => 60,
                'smtp_user'   => SENDER_EMAIL,
                'smtp_pass'   => SENDER_PASSWORD,
                'smtp_crypto' => 'tls',
                'charset'     => 'utf-8',
                'newline'     => "\r\n",
                'mailtype'    => 'html',
                'validation'  => TRUE
            );
            
            $this->load->library('email', $config);
            
            $this->email->from(SENDER_EMAIL, 'RMS Admin');
            $this->email->to($user->u_email);
            $this->email->subject('Account Registration - Update Required');
            
            $reason_text = $reason ? "<p><strong>Reason:</strong> {$reason}</p>" : '';
            
            $message = "
                <html>
                <head><title>Registration Update</title></head>
                <body>
                    <h2>Registration Status Update</h2>
                    <p>Dear {$user->u_username},</p>
                    <p>We have reviewed your registration request and require additional information or corrections.</p>
                    {$reason_text}
                    <p>Please contact our support team for assistance.</p>
                    <p>Best regards,<br>RMS Admin Team</p>
                </body>
                </html>
            ";
            
            $this->email->message($message);
            return $this->email->send();
        } catch (Exception $e) {
            log_message('error', 'Rejection email failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send welcome email to new user
     */
    private function send_welcome_email($user_data)
    {
        try {
            $config = array(
                'protocol'    => 'smtp',
                'smtp_host'   => 'smtp.gmail.com',
                'smtp_port'   => 587,
                'smtp_timeout' => 60,
                'smtp_user'   => SENDER_EMAIL,
                'smtp_pass'   => SENDER_PASSWORD,
                'smtp_crypto' => 'tls',
                'charset'     => 'utf-8',
                'newline'     => "\r\n",
                'mailtype'    => 'html',
                'validation'  => TRUE
            );
            
            $this->load->library('email', $config);
            
            $this->email->from(SENDER_EMAIL, 'RMS Admin');
            $this->email->to($user_data['u_email']);
            $this->email->subject('Welcome to RMS - Account Created');
            
            $message = "
                <html>
                <head><title>Welcome to RMS</title></head>
                <body>
                    <h2>Welcome to RMS!</h2>
                    <p>Dear {$user_data['u_username']},</p>
                    <p>Your account has been created successfully by the administrator.</p>
                    <p><strong>Username:</strong> {$user_data['u_username']}</p>
                    <p><strong>Role:</strong> {$user_data['u_role']}</p>
                    <p>You can now login to the system using your credentials.</p>
                    <p><a href='".LOGIN_URL."' style='background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Login Now</a></p>
                    <p>Best regards,<br>RMS Admin Team</p>
                </body>
                </html>
            ";
            
            $this->email->message($message);
            return $this->email->send();
        } catch (Exception $e) {
            log_message('error', 'Welcome email failed: ' . $e->getMessage());
            return false;
        }
    }
}