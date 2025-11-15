<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auto_distribution_model extends CI_Model
{
    public function get_all_rules()
    {
        // Placeholder - returns empty array until database tables are created
        return [];
    }

    public function get_statistics()
    {
        return [
            'total_rules' => 0,
            'active_rules' => 0,
            'jobs_distributed' => 0,
            'success_rate' => 0
        ];
    }

    public function get_recent_logs($limit = 50)
    {
        // Placeholder - returns empty array until database tables are created
        return [];
    }
}
