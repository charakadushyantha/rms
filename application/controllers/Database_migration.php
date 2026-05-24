<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Database_migration extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    /**
     * Add cd_created_at column to candidate_details table
     * Access via: http://localhost/rms/database_migration/add_created_at_column
     */
    public function add_created_at_column()
    {
        // Check if column already exists
        $fields = $this->db->list_fields('candidate_details');
        
        if (in_array('cd_created_at', $fields)) {
            echo '<div style="font-family: Arial; padding: 20px; background: #fff3cd; border: 1px solid #ffc107; border-radius: 8px; margin: 20px;">';
            echo '<h3 style="color: #856404;"><i class="fas fa-info-circle"></i> Column Already Exists</h3>';
            echo '<p>The <code>cd_created_at</code> column already exists in the <code>candidate_details</code> table.</p>';
            echo '<a href="' . base_url('A_dashboard/Ascandidate_view') . '" style="display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 5px; margin-top: 10px;">Go to Selected Candidates</a>';
            echo '</div>';
            return;
        }

        try {
            // Add the column
            $fields = array(
                'cd_created_at' => array(
                    'type' => 'TIMESTAMP',
                    'null' => TRUE,
                    'default' => 'CURRENT_TIMESTAMP'
                )
            );
            
            $this->dbforge->add_column('candidate_details', $fields);
            
            // Update existing records to have current timestamp
            $this->db->query("UPDATE candidate_details SET cd_created_at = NOW() WHERE cd_created_at IS NULL");
            
            echo '<div style="font-family: Arial; padding: 20px; background: #d4edda; border: 1px solid #28a745; border-radius: 8px; margin: 20px;">';
            echo '<h3 style="color: #155724;"><i class="fas fa-check-circle"></i> Success!</h3>';
            echo '<p>The <code>cd_created_at</code> column has been successfully added to the <code>candidate_details</code> table.</p>';
            echo '<p><strong>What was done:</strong></p>';
            echo '<ul>';
            echo '<li>Added <code>cd_created_at</code> column with TIMESTAMP type</li>';
            echo '<li>Set default value to CURRENT_TIMESTAMP for new records</li>';
            echo '<li>Updated all existing records with current timestamp</li>';
            echo '</ul>';
            echo '<a href="' . base_url('A_dashboard/Ascandidate_view') . '" style="display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 5px; margin-top: 10px;">Go to Selected Candidates</a>';
            echo '</div>';
            
        } catch (Exception $e) {
            echo '<div style="font-family: Arial; padding: 20px; background: #f8d7da; border: 1px solid #dc3545; border-radius: 8px; margin: 20px;">';
            echo '<h3 style="color: #721c24;"><i class="fas fa-exclamation-triangle"></i> Error!</h3>';
            echo '<p>Failed to add the column. Error: ' . $e->getMessage() . '</p>';
            echo '<a href="' . base_url('A_dashboard/Ascandidate_view') . '" style="display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 5px; margin-top: 10px;">Go Back</a>';
            echo '</div>';
        }
    }

    /**
     * Add cd_updated_at column to candidate_details table (optional)
     * Access via: http://localhost/rms/database_migration/add_updated_at_column
     */
    public function add_updated_at_column()
    {
        // Check if column already exists
        $fields = $this->db->list_fields('candidate_details');
        
        if (in_array('cd_updated_at', $fields)) {
            echo '<div style="font-family: Arial; padding: 20px; background: #fff3cd; border: 1px solid #ffc107; border-radius: 8px; margin: 20px;">';
            echo '<h3 style="color: #856404;">Column Already Exists</h3>';
            echo '<p>The <code>cd_updated_at</code> column already exists in the <code>candidate_details</code> table.</p>';
            echo '<a href="' . base_url('A_dashboard/Ascandidate_view') . '" style="display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 5px; margin-top: 10px;">Go to Selected Candidates</a>';
            echo '</div>';
            return;
        }

        try {
            // Add the column
            $fields = array(
                'cd_updated_at' => array(
                    'type' => 'TIMESTAMP',
                    'null' => TRUE,
                    'default' => 'CURRENT_TIMESTAMP',
                    'on_update' => 'CURRENT_TIMESTAMP'
                )
            );
            
            $this->dbforge->add_column('candidate_details', $fields);
            
            // Update existing records
            $this->db->query("UPDATE candidate_details SET cd_updated_at = NOW() WHERE cd_updated_at IS NULL");
            
            echo '<div style="font-family: Arial; padding: 20px; background: #d4edda; border: 1px solid #28a745; border-radius: 8px; margin: 20px;">';
            echo '<h3 style="color: #155724;">Success!</h3>';
            echo '<p>The <code>cd_updated_at</code> column has been successfully added to the <code>candidate_details</code> table.</p>';
            echo '<a href="' . base_url('A_dashboard/Ascandidate_view') . '" style="display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 5px; margin-top: 10px;">Go to Selected Candidates</a>';
            echo '</div>';
            
        } catch (Exception $e) {
            echo '<div style="font-family: Arial; padding: 20px; background: #f8d7da; border: 1px solid #dc3545; border-radius: 8px; margin: 20px;">';
            echo '<h3 style="color: #721c24;">Error!</h3>';
            echo '<p>Failed to add the column. Error: ' . $e->getMessage() . '</p>';
            echo '<a href="' . base_url('A_dashboard/Ascandidate_view') . '" style="display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 5px; margin-top: 10px;">Go Back</a>';
            echo '</div>';
        }
    }

    /**
     * Check database structure
     * Access via: http://localhost/rms/database_migration/check_structure
     */
    public function check_structure()
    {
        echo '<div style="font-family: Arial; padding: 20px; max-width: 1200px; margin: 20px auto;">';
        echo '<h2 style="color: #667eea;">Database Structure Check</h2>';
        
        // Check candidate_details table
        echo '<div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 20px;">';
        echo '<h3>candidate_details Table</h3>';
        
        $fields = $this->db->list_fields('candidate_details');
        
        echo '<table style="width: 100%; border-collapse: collapse;">';
        echo '<thead><tr style="background: #f8f9fa;"><th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Column Name</th><th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Status</th></tr></thead>';
        echo '<tbody>';
        
        $required_columns = ['cd_created_at', 'cd_updated_at'];
        foreach ($required_columns as $col) {
            $exists = in_array($col, $fields);
            $status = $exists ? '<span style="color: #28a745;">✓ EXISTS</span>' : '<span style="color: #dc3545;">✗ MISSING</span>';
            echo '<tr><td style="padding: 10px; border: 1px solid #ddd;"><code>' . $col . '</code></td><td style="padding: 10px; border: 1px solid #ddd;">' . $status . '</td></tr>';
        }
        
        echo '</tbody></table>';
        
        echo '<div style="margin-top: 20px;">';
        if (!in_array('cd_created_at', $fields)) {
            echo '<a href="' . base_url('database_migration/add_created_at_column') . '" style="display: inline-block; padding: 10px 20px; background: #28a745; color: white; text-decoration: none; border-radius: 5px; margin-right: 10px;">Add cd_created_at Column</a>';
        }
        if (!in_array('cd_updated_at', $fields)) {
            echo '<a href="' . base_url('database_migration/add_updated_at_column') . '" style="display: inline-block; padding: 10px 20px; background: #17a2b8; color: white; text-decoration: none; border-radius: 5px; margin-right: 10px;">Add cd_updated_at Column</a>';
        }
        echo '<a href="' . base_url('A_dashboard/Ascandidate_view') . '" style="display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 5px;">Go to Selected Candidates</a>';
        echo '</div>';
        
        echo '</div>';
        
        // Show all columns
        echo '<div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">';
        echo '<h3>All Columns in candidate_details</h3>';
        echo '<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 10px;">';
        foreach ($fields as $field) {
            echo '<div style="padding: 8px; background: #f8f9fa; border-radius: 4px; border-left: 3px solid #667eea;"><code>' . $field . '</code></div>';
        }
        echo '</div>';
        echo '</div>';
        
        echo '</div>';
    }
}
