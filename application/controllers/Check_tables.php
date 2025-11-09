<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Check_tables extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function index() {
        echo "<h1>Database Table Check</h1>";
        echo "<style>
            body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
            .success { color: green; }
            .error { color: red; }
            table { border-collapse: collapse; width: 100%; margin: 20px 0; background: white; }
            th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
            th { background: #667eea; color: white; }
        </style>";

        // Check if interviewer_availability table exists
        if ($this->db->table_exists('interviewer_availability')) {
            echo "<p class='success'>✅ Table 'interviewer_availability' exists</p>";
            
            // Get column information
            $query = $this->db->query("SHOW COLUMNS FROM interviewer_availability");
            $columns = $query->result_array();
            
            echo "<h3>Current Columns:</h3>";
            echo "<table>";
            echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
            foreach ($columns as $col) {
                echo "<tr>";
                echo "<td>{$col['Field']}</td>";
                echo "<td>{$col['Type']}</td>";
                echo "<td>{$col['Null']}</td>";
                echo "<td>{$col['Key']}</td>";
                echo "<td>{$col['Default']}</td>";
                echo "</tr>";
            }
            echo "</table>";
            
            // Check if we need to rename column
            $has_interviewer_username = false;
            foreach ($columns as $col) {
                if ($col['Field'] == 'interviewer_username') {
                    $has_interviewer_username = true;
                    break;
                }
            }
            
            if (!$has_interviewer_username) {
                echo "<p class='error'>❌ Column 'interviewer_username' not found!</p>";
                echo "<p>Would you like to fix this? <a href='" . base_url('Check_tables/fix_table') . "'>Click here to fix</a></p>";
            } else {
                echo "<p class='success'>✅ Column 'interviewer_username' exists</p>";
            }
            
        } else {
            echo "<p class='error'>❌ Table 'interviewer_availability' does not exist</p>";
            echo "<p>Please run: <a href='" . base_url('Setup_interviewer') . "'>Setup Interviewer Tables</a></p>";
        }
    }

    public function fix_table() {
        echo "<h1>Fixing interviewer_availability Table</h1>";
        echo "<style>
            body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
            .success { color: green; }
            .error { color: red; }
        </style>";

        // Drop and recreate the table
        $this->db->query("DROP TABLE IF EXISTS interviewer_availability");
        
        $sql = "CREATE TABLE `interviewer_availability` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `interviewer_username` VARCHAR(100) NOT NULL,
            `day_of_week` TINYINT(1) NOT NULL COMMENT '0=Sunday, 6=Saturday',
            `start_time` TIME NOT NULL,
            `end_time` TIME NOT NULL,
            `is_available` TINYINT(1) DEFAULT 1,
            PRIMARY KEY (`id`),
            KEY `interviewer_username` (`interviewer_username`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

        if ($this->db->query($sql)) {
            echo "<p class='success'>✅ Table recreated successfully!</p>";
            echo "<p><a href='" . base_url('I_dashboard/profile') . "'>Go back to Profile</a></p>";
        } else {
            echo "<p class='error'>❌ Error recreating table</p>";
        }
    }
}
