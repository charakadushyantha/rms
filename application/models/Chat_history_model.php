<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat_history_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Save chat message
     */
    public function save_message($data) {
        return $this->db->insert('chat_history', $data);
    }

    /**
     * Get user chat history
     */
    public function get_user_chats($user_id, $limit = 50) {
        $this->db->where('user_id', $user_id);
        $this->db->order_by('timestamp', 'DESC');
        $this->db->limit($limit);
        
        $query = $this->db->get('chat_history');
        return $query->result_array();
    }

    /**
     * Get conversation context
     */
    public function get_context($session_id, $limit = 5) {
        $this->db->where('session_id', $session_id);
        $this->db->order_by('timestamp', 'DESC');
        $this->db->limit($limit);
        
        $query = $this->db->get('chat_history');
        return array_reverse($query->result_array());
    }

    /**
     * Get recent conversations
     */
    public function get_recent($limit = 20) {
        $this->db->select('chat_history.*, users.name as user_name');
        $this->db->join('users', 'users.id = chat_history.user_id', 'left');
        $this->db->order_by('chat_history.timestamp', 'DESC');
        $this->db->limit($limit);
        
        $query = $this->db->get('chat_history');
        return $query->result_array();
    }

    /**
     * Get session messages
     */
    public function get_session_messages($session_id) {
        $this->db->where('session_id', $session_id);
        $this->db->order_by('timestamp', 'ASC');
        
        $query = $this->db->get('chat_history');
        return $query->result_array();
    }

    /**
     * Mark messages as read
     */
    public function mark_as_read($session_id) {
        return $this->db->update('chat_history', 
            ['is_read' => 1], 
            ['session_id' => $session_id, 'sender' => 'user']
        );
    }

    /**
     * Delete user chat history
     */
    public function delete_by_user($user_id) {
        return $this->db->delete('chat_history', ['user_id' => $user_id]);
    }

    /**
     * Get chat statistics
     */
    public function get_stats($session_id) {
        $this->db->select('
            COUNT(*) as total_messages,
            SUM(CASE WHEN sender = "user" THEN 1 ELSE 0 END) as user_messages,
            SUM(CASE WHEN sender = "bot" THEN 1 ELSE 0 END) as bot_messages,
            AVG(confidence) as avg_confidence
        ');
        $this->db->where('session_id', $session_id);
        
        $query = $this->db->get('chat_history');
        return $query->row_array();
    }
}
