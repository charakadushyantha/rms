<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cleanup_duplicates extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Find duplicate recruiters
     * Access via: http://localhost/rms/cleanup_duplicates
     */
    public function index() {
        echo '<html><head><title>Cleanup Duplicates</title>';
        echo '<style>
            body { font-family: Arial; padding: 20px; background: #f5f5f5; }
            .section { background: white; padding: 20px; margin: 20px 0; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
            h2 { color: #667eea; }
            .error { color: #dc3545; font-weight: bold; }
            .warning { color: #ffc107; font-weight: bold; }
            .success { color: #28a745; font-weight: bold; }
            table { width: 100%; border-collapse: collapse; margin: 10px 0; }
            th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
            th { background: #f8f9fa; font-weight: bold; }
            .btn { display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 5px; margin: 5px; border: none; cursor: pointer; }
            .btn-danger { background: #dc3545; }
            .btn-warning { background: #ffc107; color: #000; }
        </style></head><body>';
        
        echo '<h1>🧹 Cleanup Duplicate Recruiters</h1>';
        
        // Find duplicate usernames
        echo '<div class="section">';
        echo '<h2>1. Duplicate Usernames</h2>';
        
        $sql = "SELECT u_username, COUNT(*) as count, GROUP_CONCAT(u_id) as ids, GROUP_CONCAT(u_email) as emails
                FROM users 
                WHERE u_role = 'Recruiter'
                GROUP BY u_username 
                HAVING count > 1";
        
        $duplicates = $this->db->query($sql)->result();
        
        if (count($duplicates) > 0) {
            echo '<p class="error">Found ' . count($duplicates) . ' duplicate username(s)</p>';
            echo '<table>';
            echo '<thead><tr><th>Username</th><th>Count</th><th>IDs</th><th>Emails</th><th>Action</th></tr></thead>';
            echo '<tbody>';
            
            foreach ($duplicates as $dup) {
                echo '<tr>';
                echo '<td>' . $dup->u_username . '</td>';
                echo '<td>' . $dup->count . '</td>';
                echo '<td>' . $dup->ids . '</td>';
                echo '<td>' . $dup->emails . '</td>';
                echo '<td><a href="' . base_url('cleanup_duplicates/view_details/' . urlencode($dup->u_username)) . '" class="btn btn-warning">View Details</a></td>';
                echo '</tr>';
            }
            
            echo '</tbody></table>';
        } else {
            echo '<p class="success">✓ No duplicate usernames found</p>';
        }
        
        echo '</div>';
        
        // Find duplicate emails
        echo '<div class="section">';
        echo '<h2>2. Duplicate Emails</h2>';
        
        $sql = "SELECT u_email, COUNT(*) as count, GROUP_CONCAT(u_id) as ids, GROUP_CONCAT(u_username) as usernames
                FROM users 
                WHERE u_role = 'Recruiter'
                GROUP BY u_email 
                HAVING count > 1";
        
        $duplicates = $this->db->query($sql)->result();
        
        if (count($duplicates) > 0) {
            echo '<p class="error">Found ' . count($duplicates) . ' duplicate email(s)</p>';
            echo '<table>';
            echo '<thead><tr><th>Email</th><th>Count</th><th>IDs</th><th>Usernames</th></tr></thead>';
            echo '<tbody>';
            
            foreach ($duplicates as $dup) {
                echo '<tr>';
                echo '<td>' . $dup->u_email . '</td>';
                echo '<td>' . $dup->count . '</td>';
                echo '<td>' . $dup->ids . '</td>';
                echo '<td>' . $dup->usernames . '</td>';
                echo '</tr>';
            }
            
            echo '</tbody></table>';
        } else {
            echo '<p class="success">✓ No duplicate emails found</p>';
        }
        
        echo '</div>';
        
        // All recruiters
        echo '<div class="section">';
        echo '<h2>3. All Recruiters</h2>';
        
        $this->db->select('u_id, u_username, u_email, u_status, u_created_at');
        $this->db->where('u_role', 'Recruiter');
        $this->db->order_by('u_username', 'ASC');
        $recruiters = $this->db->get('users')->result();
        
        echo '<table>';
        echo '<thead><tr><th>ID</th><th>Username</th><th>Email</th><th>Status</th><th>Created</th><th>Action</th></tr></thead>';
        echo '<tbody>';
        
        foreach ($recruiters as $rec) {
            echo '<tr>';
            echo '<td>' . $rec->u_id . '</td>';
            echo '<td>' . $rec->u_username . '</td>';
            echo '<td>' . $rec->u_email . '</td>';
            echo '<td>' . $rec->u_status . '</td>';
            echo '<td>' . $rec->u_created_at . '</td>';
            echo '<td>';
            echo '<form method="post" action="' . base_url('cleanup_duplicates/delete_by_id') . '" style="display:inline;" onsubmit="return confirm(\'Are you sure you want to delete ID ' . $rec->u_id . '?\');">';
            echo '<input type="hidden" name="id" value="' . $rec->u_id . '">';
            echo '<button type="submit" class="btn btn-danger">Delete</button>';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }
        
        echo '</tbody></table>';
        echo '</div>';
        
        // Recommendations
        echo '<div class="section">';
        echo '<h2>4. Recommendations</h2>';
        echo '<p><strong>How to clean up duplicates:</strong></p>';
        echo '<ol>';
        echo '<li>Review the duplicate entries above</li>';
        echo '<li>Decide which entries to keep (usually the oldest/first created)</li>';
        echo '<li>Delete the duplicate entries using the Delete button</li>';
        echo '<li>Or use the automatic cleanup below (keeps oldest entry)</li>';
        echo '</ol>';
        
        if (count($this->db->query("SELECT u_username FROM users WHERE u_role = 'Recruiter' GROUP BY u_username HAVING COUNT(*) > 1")->result()) > 0) {
            echo '<form method="post" action="' . base_url('cleanup_duplicates/auto_cleanup') . '" onsubmit="return confirm(\'This will delete duplicate entries, keeping only the oldest one for each username. Continue?\');">';
            echo '<button type="submit" class="btn btn-danger">Auto Cleanup (Keep Oldest)</button>';
            echo '</form>';
        }
        
        echo '</div>';
        
        echo '<div class="section">';
        echo '<a href="' . base_url('A_dashboard/Arecruiter_view') . '" class="btn">Back to Recruiters</a>';
        echo '</div>';
        
        echo '</body></html>';
    }

    /**
     * Delete recruiter by ID
     */
    public function delete_by_id() {
        $id = $this->input->post('id');
        
        if ($id) {
            $this->db->where('u_id', $id);
            $this->db->where('u_role', 'Recruiter');
            $this->db->delete('users');
            
            $this->session->set_flashdata('success', 'Recruiter deleted successfully');
        }
        
        redirect('cleanup_duplicates');
    }

    /**
     * Auto cleanup - keep oldest entry for each username
     */
    public function auto_cleanup() {
        // Get duplicate usernames
        $sql = "SELECT u_username, MIN(u_id) as keep_id
                FROM users 
                WHERE u_role = 'Recruiter'
                GROUP BY u_username 
                HAVING COUNT(*) > 1";
        
        $duplicates = $this->db->query($sql)->result();
        
        $deleted_count = 0;
        
        foreach ($duplicates as $dup) {
            // Delete all except the oldest (lowest ID)
            $this->db->where('u_username', $dup->u_username);
            $this->db->where('u_role', 'Recruiter');
            $this->db->where('u_id !=', $dup->keep_id);
            $this->db->delete('users');
            
            $deleted_count += $this->db->affected_rows();
        }
        
        $this->session->set_flashdata('success', 'Deleted ' . $deleted_count . ' duplicate entries');
        redirect('cleanup_duplicates');
    }

    /**
     * View details of a specific username
     */
    public function view_details($username) {
        $username = urldecode($username);
        
        echo '<html><head><title>Details: ' . $username . '</title>';
        echo '<style>
            body { font-family: Arial; padding: 20px; background: #f5f5f5; }
            .section { background: white; padding: 20px; margin: 20px 0; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
            table { width: 100%; border-collapse: collapse; }
            th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
            th { background: #f8f9fa; }
            .btn { display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 5px; margin: 5px; }
        </style></head><body>';
        
        echo '<h1>Details for: ' . $username . '</h1>';
        
        $this->db->where('u_username', $username);
        $this->db->where('u_role', 'Recruiter');
        $this->db->order_by('u_id', 'ASC');
        $entries = $this->db->get('users')->result();
        
        echo '<div class="section">';
        echo '<table>';
        echo '<thead><tr><th>ID</th><th>Email</th><th>Status</th><th>Created</th></tr></thead>';
        echo '<tbody>';
        
        foreach ($entries as $entry) {
            echo '<tr>';
            echo '<td>' . $entry->u_id . '</td>';
            echo '<td>' . $entry->u_email . '</td>';
            echo '<td>' . $entry->u_status . '</td>';
            echo '<td>' . $entry->u_created_at . '</td>';
            echo '</tr>';
        }
        
        echo '</tbody></table>';
        echo '</div>';
        
        echo '<a href="' . base_url('cleanup_duplicates') . '" class="btn">Back</a>';
        
        echo '</body></html>';
    }
}
