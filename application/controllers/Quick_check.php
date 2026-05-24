<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quick_check extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Quick system check
     * Access via: http://localhost/rms/quick_check
     */
    public function index() {
        echo '<html><head><title>Quick System Check</title>';
        echo '<style>
            body { font-family: Arial; padding: 20px; background: #f5f5f5; }
            .section { background: white; padding: 20px; margin: 20px 0; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
            h2 { color: #667eea; border-bottom: 2px solid #667eea; padding-bottom: 10px; }
            .success { color: #28a745; font-weight: bold; }
            .error { color: #dc3545; font-weight: bold; }
            .warning { color: #ffc107; font-weight: bold; }
            table { width: 100%; border-collapse: collapse; margin: 10px 0; }
            th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
            th { background: #f8f9fa; font-weight: bold; }
            code { background: #f8f9fa; padding: 2px 6px; border-radius: 3px; }
            .btn { display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 5px; margin: 5px; }
            pre { background: #f8f9fa; padding: 15px; border-radius: 5px; overflow-x: auto; }
        </style></head><body>';
        
        echo '<h1>🔍 Quick System Check</h1>';
        
        // Database Info
        echo '<div class="section">';
        echo '<h2>1. Database Connection</h2>';
        echo '<p class="success">✓ Database connected successfully</p>';
        echo '<p><strong>Database:</strong> <code>' . $this->db->database . '</code></p>';
        echo '<p><strong>Hostname:</strong> <code>' . $this->db->hostname . '</code></p>';
        echo '<p><strong>Username:</strong> <code>' . $this->db->username . '</code></p>';
        echo '</div>';
        
        // Check users table
        echo '<div class="section">';
        echo '<h2>2. Users Table Check</h2>';
        
        if ($this->db->table_exists('users')) {
            echo '<p class="success">✓ <code>users</code> table exists</p>';
            
            // Get table structure
            $fields = $this->db->list_fields('users');
            
            echo '<p><strong>Columns:</strong></p>';
            echo '<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 10px;">';
            foreach ($fields as $field) {
                $color = '#667eea';
                if ($field == 'u_status') $color = '#28a745';
                if ($field == 'u_created_at') $color = '#17a2b8';
                echo '<div style="padding: 8px; background: #f8f9fa; border-radius: 4px; border-left: 3px solid ' . $color . ';"><code>' . $field . '</code></div>';
            }
            echo '</div>';
            
            // Check for required columns
            $required = ['u_id', 'u_username', 'u_email', 'u_password', 'u_role', 'u_status', 'u_created_at'];
            $missing = array_diff($required, $fields);
            
            if (empty($missing)) {
                echo '<p class="success" style="margin-top: 15px;">✓ All required columns exist</p>';
            } else {
                echo '<p class="error" style="margin-top: 15px;">✗ Missing columns: ' . implode(', ', array_map(function($c) { return "<code>$c</code>"; }, $missing)) . '</p>';
                echo '<p><a href="' . base_url('debug_recruiters/add_missing_columns') . '" class="btn">Add Missing Columns</a></p>';
            }
            
        } else {
            echo '<p class="error">✗ <code>users</code> table does not exist</p>';
        }
        echo '</div>';
        
        // Check for recruiters
        echo '<div class="section">';
        echo '<h2>3. Recruiters in Database</h2>';
        
        $this->db->where('u_role', 'Recruiter');
        $recruiters = $this->db->get('users');
        
        if ($recruiters->num_rows() > 0) {
            echo '<p class="success">✓ Found ' . $recruiters->num_rows() . ' recruiter(s)</p>';
            echo '<table>';
            echo '<thead><tr><th>ID</th><th>Username</th><th>Email</th><th>Status</th><th>Created</th></tr></thead>';
            echo '<tbody>';
            
            foreach ($recruiters->result() as $rec) {
                $status = isset($rec->u_status) ? ($rec->u_status == 1 ? '<span class="success">Active</span>' : '<span class="warning">Pending</span>') : 'N/A';
                $created = isset($rec->u_created_at) ? $rec->u_created_at : 'N/A';
                
                echo '<tr>';
                echo '<td>' . $rec->u_id . '</td>';
                echo '<td>' . $rec->u_username . '</td>';
                echo '<td>' . $rec->u_email . '</td>';
                echo '<td>' . $status . '</td>';
                echo '<td>' . $created . '</td>';
                echo '</tr>';
            }
            
            echo '</tbody></table>';
        } else {
            echo '<p class="warning">⚠ No recruiters found</p>';
            echo '<p>Add a recruiter from the admin panel.</p>';
        }
        echo '</div>';
        
        // Test AJAX endpoints
        echo '<div class="section">';
        echo '<h2>4. Test AJAX Endpoints</h2>';
        
        echo '<button class="btn" onclick="testGetRecruiters()">Test Get Recruiters</button>';
        echo '<button class="btn" onclick="testGetStats()">Test Get Stats</button>';
        
        echo '<div id="ajax-results" style="margin-top: 20px; display: none;"></div>';
        
        echo '<script>
        function testGetRecruiters() {
            const resultsDiv = document.getElementById("ajax-results");
            resultsDiv.style.display = "block";
            resultsDiv.innerHTML = "<p>Testing get_recruiters...</p>";
            
            fetch("' . base_url('recruiter_management/get_recruiters') . '", {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest"
                },
                credentials: "include"
            })
            .then(response => response.json())
            .then(data => {
                resultsDiv.innerHTML = "<p class=\"success\">✓ Success!</p><pre>" + JSON.stringify(data, null, 2) + "</pre>";
            })
            .catch(error => {
                resultsDiv.innerHTML = "<p class=\"error\">✗ Error: " + error.message + "</p>";
            });
        }
        
        function testGetStats() {
            const resultsDiv = document.getElementById("ajax-results");
            resultsDiv.style.display = "block";
            resultsDiv.innerHTML = "<p>Testing get_stats...</p>";
            
            fetch("' . base_url('recruiter_management/get_stats') . '", {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest"
                },
                credentials: "include"
            })
            .then(response => response.json())
            .then(data => {
                resultsDiv.innerHTML = "<p class=\"success\">✓ Success!</p><pre>" + JSON.stringify(data, null, 2) + "</pre>";
            })
            .catch(error => {
                resultsDiv.innerHTML = "<p class=\"error\">✗ Error: " + error.message + "</p>";
            });
        }
        </script>';
        
        echo '</div>';
        
        // Session check
        echo '<div class="section">';
        echo '<h2>5. Session Status</h2>';
        
        if ($this->session->userdata('authenticated')) {
            echo '<p class="success">✓ User is authenticated</p>';
            echo '<p><strong>Username:</strong> <code>' . $this->session->userdata('username') . '</code></p>';
            echo '<p><strong>Role:</strong> <code>' . $this->session->userdata('Role') . '</code></p>';
        } else {
            echo '<p class="error">✗ User is NOT authenticated</p>';
            echo '<p class="warning">⚠ You need to be logged in for the recruiter management to work</p>';
            echo '<p><a href="' . base_url('login') . '" class="btn">Go to Login</a></p>';
        }
        echo '</div>';
        
        // File check
        echo '<div class="section">';
        echo '<h2>6. Required Files</h2>';
        
        $files = [
            'Controller' => APPPATH . 'controllers/Recruiter_management.php',
            'Model' => APPPATH . 'models/Recruiter_model.php',
            'View' => APPPATH . 'views/Admin_dashboard_view/Arecruiter.php'
        ];
        
        foreach ($files as $name => $path) {
            if (file_exists($path)) {
                echo '<p class="success">✓ ' . $name . ' exists</p>';
            } else {
                echo '<p class="error">✗ ' . $name . ' NOT FOUND</p>';
            }
        }
        echo '</div>';
        
        // Quick actions
        echo '<div class="section">';
        echo '<h2>7. Quick Actions</h2>';
        echo '<a href="' . base_url('debug_recruiters') . '" class="btn">Full Debug Tool</a>';
        echo '<a href="' . base_url('debug_recruiters/add_missing_columns') . '" class="btn">Add Missing Columns</a>';
        echo '<a href="' . base_url('A_dashboard/Arecruiter_view') . '" class="btn">Go to Recruiters Page</a>';
        echo '</div>';
        
        // Instructions
        echo '<div class="section">';
        echo '<h2>8. Next Steps</h2>';
        echo '<ol>';
        echo '<li>If any columns are missing, click "Add Missing Columns"</li>';
        echo '<li>Test the AJAX endpoints using the buttons above</li>';
        echo '<li>Go to the Recruiters page and press F12 to check browser console for errors</li>';
        echo '<li>If buttons still don\'t work, check the Network tab in browser DevTools</li>';
        echo '</ol>';
        echo '</div>';
        
        echo '</body></html>';
    }
}
