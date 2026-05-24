<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Debug_recruiters extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Check database structure and test endpoints
     * Access via: http://localhost/rms/debug_recruiters
     */
    public function index() {
        echo '<html><head><title>Recruiter Debug</title>';
        echo '<style>
            body { font-family: Arial; padding: 20px; background: #f5f5f5; }
            .section { background: white; padding: 20px; margin: 20px 0; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
            h2 { color: #667eea; border-bottom: 2px solid #667eea; padding-bottom: 10px; }
            .success { color: #28a745; }
            .error { color: #dc3545; }
            .warning { color: #ffc107; }
            table { width: 100%; border-collapse: collapse; margin: 10px 0; }
            th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
            th { background: #f8f9fa; font-weight: bold; }
            code { background: #f8f9fa; padding: 2px 6px; border-radius: 3px; }
            .btn { display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 5px; margin: 5px; }
        </style></head><body>';
        
        echo '<h1>🔍 Recruiter Management Debug</h1>';
        
        // Check if users table exists
        echo '<div class="section">';
        echo '<h2>1. Database Tables Check</h2>';
        
        $tables = $this->db->list_tables();
        if (in_array('users', $tables)) {
            echo '<p class="success">✓ <code>users</code> table exists</p>';
        } else {
            echo '<p class="error">✗ <code>users</code> table NOT found</p>';
        }
        echo '</div>';
        
        // Check users table structure
        echo '<div class="section">';
        echo '<h2>2. Users Table Structure</h2>';
        
        if ($this->db->table_exists('users')) {
            $fields = $this->db->list_fields('users');
            
            echo '<table>';
            echo '<thead><tr><th>Column Name</th><th>Status</th></tr></thead>';
            echo '<tbody>';
            
            $required_fields = ['u_id', 'u_username', 'u_email', 'u_password', 'u_role', 'u_status', 'u_created_at'];
            foreach ($required_fields as $field) {
                $exists = in_array($field, $fields);
                $status = $exists ? '<span class="success">✓ EXISTS</span>' : '<span class="error">✗ MISSING</span>';
                echo "<tr><td><code>$field</code></td><td>$status</td></tr>";
            }
            
            echo '</tbody></table>';
            
            // Show all columns
            echo '<p><strong>All columns in users table:</strong></p>';
            echo '<p>' . implode(', ', array_map(function($f) { return "<code>$f</code>"; }, $fields)) . '</p>';
        } else {
            echo '<p class="error">Cannot check structure - table does not exist</p>';
        }
        echo '</div>';
        
        // Check for recruiters
        echo '<div class="section">';
        echo '<h2>3. Existing Recruiters</h2>';
        
        $this->db->where('u_role', 'Recruiter');
        $recruiters = $this->db->get('users');
        
        if ($recruiters->num_rows() > 0) {
            echo '<p class="success">Found ' . $recruiters->num_rows() . ' recruiter(s)</p>';
            echo '<table>';
            echo '<thead><tr><th>ID</th><th>Username</th><th>Email</th><th>Status</th><th>Created</th></tr></thead>';
            echo '<tbody>';
            foreach ($recruiters->result() as $rec) {
                $status = isset($rec->u_status) ? ($rec->u_status == 1 ? '<span class="success">Active</span>' : '<span class="warning">Pending</span>') : 'N/A';
                $created = isset($rec->u_created_at) ? $rec->u_created_at : 'N/A';
                echo "<tr>";
                echo "<td>{$rec->u_id}</td>";
                echo "<td>{$rec->u_username}</td>";
                echo "<td>{$rec->u_email}</td>";
                echo "<td>$status</td>";
                echo "<td>$created</td>";
                echo "</tr>";
            }
            echo '</tbody></table>';
        } else {
            echo '<p class="warning">⚠ No recruiters found in database</p>';
        }
        echo '</div>';
        
        // Check if Recruiter_model exists
        echo '<div class="section">';
        echo '<h2>4. Model & Controller Check</h2>';
        
        $model_path = APPPATH . 'models/Recruiter_model.php';
        $controller_path = APPPATH . 'controllers/Recruiter_management.php';
        
        if (file_exists($model_path)) {
            echo '<p class="success">✓ Recruiter_model.php exists</p>';
        } else {
            echo '<p class="error">✗ Recruiter_model.php NOT found</p>';
        }
        
        if (file_exists($controller_path)) {
            echo '<p class="success">✓ Recruiter_management.php exists</p>';
        } else {
            echo '<p class="error">✗ Recruiter_management.php NOT found</p>';
        }
        echo '</div>';
        
        // Test AJAX endpoints
        echo '<div class="section">';
        echo '<h2>5. Test AJAX Endpoints</h2>';
        echo '<p>Click the buttons below to test each endpoint:</p>';
        
        echo '<button class="btn" onclick="testEndpoint(\'get_recruiters\')">Test Get Recruiters</button>';
        echo '<button class="btn" onclick="testEndpoint(\'get_stats\')">Test Get Stats</button>';
        
        echo '<div id="test-results" style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 5px; display: none;"></div>';
        
        echo '<script>
        function testEndpoint(endpoint) {
            const resultsDiv = document.getElementById("test-results");
            resultsDiv.style.display = "block";
            resultsDiv.innerHTML = "<p>Testing endpoint: <code>" + endpoint + "</code>...</p>";
            
            fetch("' . base_url('recruiter_management/') . '" + endpoint, {
                method: "GET",
                headers: {
                    "Content-Type": "application/json"
                }
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
        echo '<h2>6. Session Check</h2>';
        
        if ($this->session->userdata('authenticated')) {
            echo '<p class="success">✓ User is authenticated</p>';
            echo '<p>Username: <code>' . $this->session->userdata('username') . '</code></p>';
            echo '<p>Role: <code>' . $this->session->userdata('Role') . '</code></p>';
        } else {
            echo '<p class="error">✗ User is NOT authenticated</p>';
            echo '<p class="warning">⚠ This might cause AJAX requests to fail if the controller requires authentication</p>';
        }
        echo '</div>';
        
        // Quick fixes
        echo '<div class="section">';
        echo '<h2>7. Quick Actions</h2>';
        echo '<a href="' . base_url('debug_recruiters/add_missing_columns') . '" class="btn">Add Missing Columns</a>';
        echo '<a href="' . base_url('A_dashboard/Arecruiter_view') . '" class="btn">Go to Recruiters Page</a>';
        echo '</div>';
        
        echo '</body></html>';
    }

    /**
     * Add missing columns to users table
     */
    public function add_missing_columns() {
        $this->load->dbforge();
        
        echo '<html><head><title>Add Missing Columns</title>';
        echo '<style>
            body { font-family: Arial; padding: 20px; background: #f5f5f5; }
            .section { background: white; padding: 20px; margin: 20px 0; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
            .success { color: #28a745; }
            .error { color: #dc3545; }
            .btn { display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 5px; margin: 5px; }
        </style></head><body>';
        
        echo '<div class="section">';
        echo '<h2>Adding Missing Columns</h2>';
        
        $fields = $this->db->list_fields('users');
        
        // Add u_status if missing
        if (!in_array('u_status', $fields)) {
            try {
                $this->dbforge->add_column('users', [
                    'u_status' => [
                        'type' => 'TINYINT',
                        'constraint' => 1,
                        'default' => 0,
                        'null' => FALSE
                    ]
                ]);
                echo '<p class="success">✓ Added <code>u_status</code> column</p>';
            } catch (Exception $e) {
                echo '<p class="error">✗ Failed to add u_status: ' . $e->getMessage() . '</p>';
            }
        } else {
            echo '<p>✓ <code>u_status</code> already exists</p>';
        }
        
        // Add u_created_at if missing
        if (!in_array('u_created_at', $fields)) {
            try {
                $this->dbforge->add_column('users', [
                    'u_created_at' => [
                        'type' => 'TIMESTAMP',
                        'null' => TRUE,
                        'default' => 'CURRENT_TIMESTAMP'
                    ]
                ]);
                echo '<p class="success">✓ Added <code>u_created_at</code> column</p>';
                
                // Update existing records
                $this->db->query("UPDATE users SET u_created_at = NOW() WHERE u_created_at IS NULL");
                echo '<p class="success">✓ Updated existing records</p>';
            } catch (Exception $e) {
                echo '<p class="error">✗ Failed to add u_created_at: ' . $e->getMessage() . '</p>';
            }
        } else {
            echo '<p>✓ <code>u_created_at</code> already exists</p>';
        }
        
        echo '<p style="margin-top: 20px;">';
        echo '<a href="' . base_url('debug_recruiters') . '" class="btn">Run Debug Again</a>';
        echo '<a href="' . base_url('A_dashboard/Arecruiter_view') . '" class="btn">Go to Recruiters Page</a>';
        echo '</p>';
        
        echo '</div>';
        echo '</body></html>';
    }
}
