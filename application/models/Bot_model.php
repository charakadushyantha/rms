<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bot_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get bot configuration
     */
    public function get_config($key = null) {
        if ($key) {
            $query = $this->db->get_where('bot_config', ['config_key' => $key, 'is_active' => 1]);
            $result = $query->row_array();
            return $result ? $this->parse_config_value($result) : null;
        }

        $query = $this->db->get_where('bot_config', ['is_active' => 1]);
        $configs = [];
        
        foreach ($query->result_array() as $row) {
            $configs[$row['config_key']] = $this->parse_config_value($row);
        }
        
        return $configs;
    }

    /**
     * Parse config value based on type
     */
    private function parse_config_value($config) {
        switch ($config['config_type']) {
            case 'boolean':
                return filter_var($config['config_value'], FILTER_VALIDATE_BOOLEAN);
            case 'number':
                return is_numeric($config['config_value']) ? (int)$config['config_value'] : 0;
            case 'json':
                return json_decode($config['config_value'], true);
            default:
                return $config['config_value'];
        }
    }

    /**
     * Update bot configuration
     */
    public function update_config($key, $value) {
        return $this->db->update('bot_config', 
            ['config_value' => $value], 
            ['config_key' => $key]
        );
    }

    /**
     * Get bot statistics
     */
    public function get_statistics() {
        $stats = [];

        // Total conversations
        $this->db->select('COUNT(DISTINCT session_id) as total');
        $query = $this->db->get('chat_sessions');
        $stats['total_conversations'] = $query->row()->total;

        // Total messages
        $this->db->select('COUNT(*) as total');
        $query = $this->db->get('chat_history');
        $stats['total_messages'] = $query->row()->total;

        // Active sessions today
        $this->db->where('DATE(last_activity)', date('Y-m-d'));
        $this->db->where('is_active', 1);
        $query = $this->db->get('chat_sessions');
        $stats['active_today'] = $query->num_rows();

        // CV processed
        $this->db->where('processing_status', 'completed');
        $query = $this->db->get('cv_processing_history');
        $stats['cvs_processed'] = $query->num_rows();

        return $stats;
    }

    /**
     * Analyze intents usage
     */
    public function analyze_intents() {
        $this->db->select('intent, COUNT(*) as count');
        $this->db->where('sender', 'bot');
        $this->db->where('intent IS NOT NULL');
        $this->db->group_by('intent');
        $this->db->order_by('count', 'DESC');
        $this->db->limit(10);
        
        $query = $this->db->get('chat_history');
        return $query->result_array();
    }

    /**
     * Get intent by name
     */
    public function get_intent($intent_name) {
        $query = $this->db->get_where('bot_intents', [
            'intent_name' => $intent_name,
            'is_active' => 1
        ]);
        
        return $query->row_array();
    }

    /**
     * Get all active intents
     */
    public function get_all_intents() {
        $this->db->where('is_active', 1);
        $this->db->order_by('priority', 'DESC');
        $query = $this->db->get('bot_intents');
        
        return $query->result_array();
    }
}
