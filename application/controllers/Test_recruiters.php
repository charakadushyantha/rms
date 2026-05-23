<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_recruiters extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Recruiter_model');
    }

    /**
     * Test recruiter endpoints
     * Access via: http://localhost/rms/test_recruiters
     */
    public function index() {
        echo '<html><head><title>Test Recruiters</title>';
        echo '<style>
            body { font-family: Arial; padding: 20px; background: #f5f5f5; }
            .section { background: white; padding: 20px; margin: 20px 0; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
            h2 { color: #667eea; }
            .success { color: #28a745; }
            .error { color: #dc3545; }
            pre { background: #f8f9fa; padding: 15px; border-radius: 5px; overflow-x: auto; }
            .btn { display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 5px; margin: 5px; }
        </style></head><body>';
        
        echo '<h1>🧪 Test Recruiter Functions</h1>';
        
        // Test get_all_recruiters
        echo '<div class="section">';
        echo '<h2>1. Test get_all_recruiters()</h2>';
        
        try {
            $recruiters = $this->Recruiter_model->get_all_recruiters();
            echo '<p class="success">✓ Success! Found ' . count($recruiters) . ' recruiter(s)</p>';
            echo '<pre>' . json_encode($recruiters, JSON_PRETTY_PRINT) . '</pre>';
        } catch (Exception $e) {
            echo '<p class="error">✗ Error: ' . $e->getMessage() . '</p>';
        }
        
        echo '</div>';
        
        // Test get_statistics
        echo '<div class="section">';
        echo '<h2>2. Test get_statistics()</h2>';
        
        try {
            $stats = $this->Recruiter_model->get_statistics();
            echo '<p class="success">✓ Success!</p>';
            echo '<pre>' . json_encode($stats, JSON_PRETTY_PRINT) . '</pre>';
        } catch (Exception $e) {
            echo '<p class="error">✗ Error: ' . $e->getMessage() . '</p>';
        }
        
        echo '</div>';
        
        // Test AJAX endpoints
        echo '<div class="section">';
        echo '<h2>3. Test AJAX Endpoints</h2>';
        echo '<p>Click buttons to test:</p>';
        
        echo '<button class="btn" onclick="testGetRecruiters()">Test Get Recruiters</button>';
        echo '<button class="btn" onclick="testGetStats()">Test Get Stats</button>';
        echo '<button class="btn" onclick="testActivate()">Test Activate (ID: 39)</button>';
        
        echo '<div id="ajax-results" style="margin-top: 20px;"></div>';
        
        echo '<script>
        function showResult(title, data, isError = false) {
            const div = document.getElementById("ajax-results");
            const className = isError ? "error" : "success";
            div.innerHTML = `<p class="${className}">${title}</p><pre>${JSON.stringify(data, null, 2)}</pre>`;
        }
        
        function testGetRecruiters() {
            fetch("' . base_url('recruiter_management/get_recruiters') . '", {
                method: "GET",
                headers: { "Content-Type": "application/json" },
                credentials: "include"
            })
            .then(r => r.json())
            .then(data => showResult("✓ Get Recruiters Success", data))
            .catch(err => showResult("✗ Get Recruiters Failed", {error: err.message}, true));
        }
        
        function testGetStats() {
            fetch("' . base_url('recruiter_management/get_stats') . '", {
                method: "GET",
                headers: { "Content-Type": "application/json" },
                credentials: "include"
            })
            .then(r => r.json())
            .then(data => showResult("✓ Get Stats Success", data))
            .catch(err => showResult("✗ Get Stats Failed", {error: err.message}, true));
        }
        
        function testActivate() {
            fetch("' . base_url('recruiter_management/update_status') . '", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                credentials: "include",
                body: JSON.stringify({ id: 39, status: 1 })
            })
            .then(r => r.json())
            .then(data => showResult("✓ Activate Success", data))
            .catch(err => showResult("✗ Activate Failed", {error: err.message}, true));
        }
        </script>';
        
        echo '</div>';
        
        // Quick links
        echo '<div class="section">';
        echo '<h2>4. Quick Links</h2>';
        echo '<a href="' . base_url('A_dashboard/Arecruiter_view') . '" class="btn">Go to Recruiters Page</a>';
        echo '<a href="' . base_url('quick_check') . '" class="btn">Run Quick Check</a>';
        echo '</div>';
        
        echo '</body></html>';
    }
}
