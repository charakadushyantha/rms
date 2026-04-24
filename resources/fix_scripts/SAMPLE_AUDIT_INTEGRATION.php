<?php
/**
 * SAMPLE AUDIT LOG INTEGRATION
 * 
 * This file shows how to integrate audit logging into your existing controllers.
 * Copy the relevant sections to your actual controllers.
 */

// ============================================
// EXAMPLE 1: Candidate Controller with Audit Logging
// ============================================

class A_dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->logged_in();
        
        // Load the audit logger library
        $this->load->library('audit_logger');
    }
    
    // CREATE - Add new candidate
    public function add_candidate()
    {
        $data = array(
            'cd_rec_username' => $this->session->userdata('username'),
            'cd_name' => $this->input->post('name'),
            'cd_email' => $this->input->post('email'),
            'cd_phone' => $this->input->post('phone'),
            'cd_gender' => $this->input->post('gender'),
            'cd_job_title' => $this->input->post('job_title'),
            'cd_source' => $this->input->post('source'),
            'cd_status' => 'Interested'
        );
        
        if ($this->db->insert('candidate_details', $data)) {
            $candidate_id = $this->db->insert_id();
            
            // ✅ LOG THE CREATE ACTION
            $this->audit_logger->log_create(
                'Candidate',
                $candidate_id,
                $data['cd_name'],
                $data  // Store all the data that was created
            );
            
            $this->session->set_flashdata('success_msg', 'Candidate added successfully!');
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to add candidate.');
        }
        
        redirect('A_dashboard/Acandidate_users_view');
    }
    
    // UPDATE - Update candidate
    public function update_candidate()
    {
        $candidate_id = $this->input->post('candidate_id');
        
        // ✅ GET OLD DATA BEFORE UPDATE
        $old_data = $this->db->where('cd_id', $candidate_id)
                             ->get('candidate_details')
                             ->row_array();
        
        $data = array(
            'cd_name' => $this->input->post('name'),
            'cd_email' => $this->input->post('email'),
            'cd_phone' => $this->input->post('phone'),
            'cd_status' => $this->input->post('status')
        );
        
        $this->db->where('cd_id', $candidate_id);
        if ($this->db->update('candidate_details', $data)) {
            
            // ✅ GET NEW DATA AFTER UPDATE
            $new_data = $this->db->where('cd_id', $candidate_id)
                                 ->get('candidate_details')
                                 ->row_array();
            
            // ✅ LOG THE UPDATE ACTION
            $this->audit_logger->log_update(
                'Candidate',
                $candidate_id,
                $data['cd_name'],
                $old_data,  // What it was before
                $new_data   // What it is now
            );
            
            $this->session->set_flashdata('success_msg', 'Candidate updated successfully!');
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to update candidate.');
        }
        
        redirect('A_dashboard/Acandidate_users_view');
    }
    
    // DELETE - Delete candidate
    public function delete_candidate($candidate_id)
    {
        // ✅ GET DATA BEFORE DELETION
        $candidate = $this->db->where('cd_id', $candidate_id)
                              ->get('candidate_details')
                              ->row();
        
        if ($candidate) {
            $this->db->where('cd_id', $candidate_id);
            if ($this->db->delete('candidate_details')) {
                
                // ✅ LOG THE DELETE ACTION
                $this->audit_logger->log_delete(
                    'Candidate',
                    $candidate_id,
                    $candidate->cd_name,
                    (array)$candidate  // Store what was deleted
                );
                
                $this->session->set_flashdata('success_msg', 'Candidate deleted successfully!');
            } else {
                $this->session->set_flashdata('error_msg', 'Failed to delete candidate.');
            }
        }
        
        redirect('A_dashboard/Acandidate_users_view');
    }
    
    // EXPORT - Export candidates to CSV
    public function export_candidates()
    {
        $candidates = $this->db->get('candidate_details')->result();
        
        // Set CSV headers
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="candidates_' . date('Y-m-d') . '.csv"');
        
        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Name', 'Email', 'Phone', 'Status']);
        
        foreach ($candidates as $candidate) {
            fputcsv($output, [
                $candidate->cd_id,
                $candidate->cd_name,
                $candidate->cd_email,
                $candidate->cd_phone,
                $candidate->cd_status
            ]);
        }
        
        fclose($output);
        
        // ✅ LOG THE EXPORT ACTION
        $this->audit_logger->log_export(
            'Candidate',
            'Exported ' . count($candidates) . ' candidates to CSV'
        );
        
        exit;
    }
    
    // BULK UPDATE - Update multiple candidates
    public function bulk_update_status()
    {
        $candidate_ids = $this->input->post('candidate_ids'); // Array of IDs
        $new_status = $this->input->post('status');
        
        $updated_count = 0;
        foreach ($candidate_ids as $id) {
            $old_data = $this->db->where('cd_id', $id)->get('candidate_details')->row_array();
            
            $this->db->where('cd_id', $id);
            $this->db->update('candidate_details', ['cd_status' => $new_status]);
            
            if ($this->db->affected_rows() > 0) {
                $updated_count++;
                
                // ✅ LOG EACH UPDATE
                $this->audit_logger->log_update(
                    'Candidate',
                    $id,
                    $old_data['cd_name'],
                    ['status' => $old_data['cd_status']],
                    ['status' => $new_status]
                );
            }
        }
        
        $this->session->set_flashdata('success_msg', "Updated $updated_count candidates");
        redirect('A_dashboard/Acandidate_users_view');
    }
}

// ============================================
// EXAMPLE 2: Login Controller with Audit Logging
// ============================================

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        // Load the audit logger library
        $this->load->library('audit_logger');
    }
    
    public function authenticate()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        
        // Check credentials
        $user = $this->db->where('u_username', $username)
                         ->where('u_password', md5($password))
                         ->where('u_status', 'Active')
                         ->get(TBL_USERS)
                         ->row();
        
        if ($user) {
            // Set session data
            $session_data = array(
                'authenticated' => true,
                'username' => $user->u_username,
                'email' => $user->u_email,
                'role' => $user->u_role,
                'u_id' => $user->u_id
            );
            $this->session->set_userdata($session_data);
            
            // ✅ LOG SUCCESSFUL LOGIN
            $this->audit_logger->log_login($username, true);
            
            // Redirect based on role
            if ($user->u_role == 'Admin') {
                redirect('A_dashboard');
            } else if ($user->u_role == 'Recruiter') {
                redirect('R_dashboard');
            } else {
                redirect('I_dashboard');
            }
        } else {
            // ✅ LOG FAILED LOGIN
            $this->audit_logger->log_login($username, false, 'Invalid username or password');
            
            $this->session->set_flashdata('error_msg', 'Invalid username or password');
            redirect('Login');
        }
    }
    
    public function logout()
    {
        // ✅ LOG LOGOUT BEFORE DESTROYING SESSION
        $this->audit_logger->log_logout();
        
        $this->session->sess_destroy();
        redirect('Login');
    }
}

// ============================================
// EXAMPLE 3: Setup Controller with Audit Logging
// ============================================

class Setup extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->logged_in();
        
        // Load the audit logger library
        $this->load->library('audit_logger');
    }
    
    // Update company settings
    public function save_company_profile()
    {
        // Get old settings
        $old_settings = $this->db->get('company_settings')->row_array();
        
        $data = [
            'company_name' => $this->input->post('company_name'),
            'company_email' => $this->input->post('company_email'),
            'company_phone' => $this->input->post('company_phone'),
            'company_address' => $this->input->post('company_address')
        ];
        
        $this->db->where('id', 1);
        if ($this->db->update('company_settings', $data)) {
            
            // Get new settings
            $new_settings = $this->db->get('company_settings')->row_array();
            
            // ✅ LOG THE SETTINGS UPDATE
            $this->audit_logger->log_update(
                'Settings',
                1,
                'Company Settings',
                $old_settings,
                $new_settings
            );
            
            $this->session->set_flashdata('success_msg', 'Settings updated!');
        }
        
        redirect('Setup/company_settings');
    }
    
    // Add new user
    public function add_user()
    {
        $data = [
            'u_username' => $this->input->post('username'),
            'u_email' => $this->input->post('email'),
            'u_password' => md5($this->input->post('password')),
            'u_role' => $this->input->post('role'),
            'u_status' => 'Active'
        ];
        
        if ($this->db->insert(TBL_USERS, $data)) {
            $user_id = $this->db->insert_id();
            
            // ✅ LOG USER CREATION (without password)
            $log_data = $data;
            unset($log_data['u_password']); // Don't log passwords!
            
            $this->audit_logger->log_create(
                'User',
                $user_id,
                $data['u_username'],
                $log_data
            );
            
            $this->session->set_flashdata('success_msg', 'User created!');
        }
        
        redirect('Setup/manage_users');
    }
    
    // Delete user
    public function delete_user($user_id)
    {
        $user = $this->db->where('u_id', $user_id)->get(TBL_USERS)->row();
        
        if ($user) {
            $this->db->where('u_id', $user_id);
            if ($this->db->delete(TBL_USERS)) {
                
                // ✅ LOG USER DELETION (without password)
                $user_data = (array)$user;
                unset($user_data['u_password']); // Don't log passwords!
                
                $this->audit_logger->log_delete(
                    'User',
                    $user_id,
                    $user->u_username,
                    $user_data
                );
                
                $this->session->set_flashdata('success_msg', 'User deleted!');
            }
        }
        
        redirect('Setup/manage_users');
    }
}

// ============================================
// EXAMPLE 4: Interview Controller with Audit Logging
// ============================================

class Interview extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->logged_in();
        $this->load->library('audit_logger');
    }
    
    // Schedule interview
    public function schedule_interview()
    {
        $data = [
            'ce_candidate_id' => $this->input->post('candidate_id'),
            'ce_interviewer' => $this->input->post('interviewer'),
            'ce_date' => $this->input->post('date'),
            'ce_time' => $this->input->post('time'),
            'ce_location' => $this->input->post('location')
        ];
        
        if ($this->db->insert(TBL_CALENDAR, $data)) {
            $interview_id = $this->db->insert_id();
            
            // Get candidate name for better logging
            $candidate = $this->db->where('cd_id', $data['ce_candidate_id'])
                                  ->get('candidate_details')
                                  ->row();
            
            // ✅ LOG INTERVIEW SCHEDULING
            $this->audit_logger->log_create(
                'Interview',
                $interview_id,
                'Interview with ' . $candidate->cd_name,
                $data
            );
            
            $this->session->set_flashdata('success_msg', 'Interview scheduled!');
        }
        
        redirect('interviews');
    }
    
    // Cancel interview
    public function cancel_interview($interview_id)
    {
        $interview = $this->db->where('ce_id', $interview_id)
                              ->get(TBL_CALENDAR)
                              ->row();
        
        if ($interview) {
            $this->db->where('ce_id', $interview_id);
            if ($this->db->delete(TBL_CALENDAR)) {
                
                // ✅ LOG INTERVIEW CANCELLATION
                $this->audit_logger->log_delete(
                    'Interview',
                    $interview_id,
                    'Interview #' . $interview_id,
                    (array)$interview
                );
                
                $this->session->set_flashdata('success_msg', 'Interview cancelled!');
            }
        }
        
        redirect('interviews');
    }
}

// ============================================
// TIPS AND BEST PRACTICES
// ============================================

/*
1. ALWAYS load the library in constructor:
   $this->load->library('audit_logger');

2. For UPDATES, get old data BEFORE updating:
   $old = $this->db->where('id', $id)->get('table')->row_array();

3. For DELETES, get data BEFORE deleting:
   $data = $this->db->where('id', $id)->get('table')->row();

4. NEVER log sensitive data like passwords:
   unset($data['password']);

5. Use meaningful resource names:
   'Interview with John Doe' instead of just 'Interview'

6. Log both successes AND failures:
   $this->audit_logger->log_login($user, false, 'Invalid password');

7. For bulk operations, log each item individually

8. Use consistent resource type names throughout your app

9. Include context in descriptions:
   'Updated candidate status from "Interested" to "Interview Scheduled"'

10. Consider performance - don't log every single view/read operation
*/
?>
