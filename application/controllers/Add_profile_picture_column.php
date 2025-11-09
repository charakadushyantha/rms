<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_profile_picture_column extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function index() {
        echo "<h1>Adding Profile Picture Column</h1>";
        echo "<style>
            body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
            .success { color: green; font-weight: bold; }
            .error { color: red; font-weight: bold; }
            .info { color: blue; }
        </style>";

        // Check if column already exists
        $query = $this->db->query("SHOW COLUMNS FROM users LIKE 'u_profile_picture'");
        
        if ($query->num_rows() > 0) {
            echo "<p class='info'>✓ Column 'u_profile_picture' already exists in users table</p>";
        } else {
            // Add the column
            $sql = "ALTER TABLE `users` ADD COLUMN `u_profile_picture` VARCHAR(255) NULL AFTER `u_email`";
            
            if ($this->db->query($sql)) {
                echo "<p class='success'>✅ Successfully added 'u_profile_picture' column to users table!</p>";
            } else {
                echo "<p class='error'>❌ Error adding column: " . $this->db->error()['message'] . "</p>";
            }
        }

        // Verify the column
        $result = $this->db->query("SHOW COLUMNS FROM users LIKE 'u_profile_picture'");
        if ($result->num_rows() > 0) {
            echo "<p class='success'>✓ Column verified successfully!</p>";
            
            $column = $result->row_array();
            echo "<h3>Column Details:</h3>";
            echo "<table border='1' cellpadding='10' style='border-collapse: collapse; background: white;'>";
            echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Default</th></tr>";
            echo "<tr>";
            echo "<td>{$column['Field']}</td>";
            echo "<td>{$column['Type']}</td>";
            echo "<td>{$column['Null']}</td>";
            echo "<td>" . ($column['Default'] ?: 'NULL') . "</td>";
            echo "</tr>";
            echo "</table>";
        }

        echo "<hr>";
        echo "<h3>✅ Setup Complete!</h3>";
        echo "<p><a href='" . base_url('C_dashboard/profile') . "'>Go to Profile Page</a></p>";
    }
}
