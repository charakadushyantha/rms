<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chatbot_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Create a new chat session
     */
    public function create_session($session_id, $data) {
        $insert_data = [
            'session_id' => $session_id,
            'user_id' => $data['user_id'] ?? null,
            'user_type' => $data['user_type'] ?? 'guest',
            'ip_address' => $data['ip_address'] ?? null,
            'user_agent' => $data['user_agent'] ?? null
        ];
        
        return $this->db->insert('chat_sessions', $insert_data);
    }

    /**
     * Save a chat message
     */
    public function save_message($session_id, $role, $message, $metadata = null) {
        $data = [
            'session_id' => $session_id,
            'role' => $role,
            'message' => $message,
            'metadata' => $metadata ? json_encode($metadata) : null
        ];
        
        return $this->db->insert('chat_messages', $data);
    }

    /**
     * Get messages for a session
     */
    public function get_session_messages($session_id, $limit = null) {
        $this->db->select('id, role, message, created_at');
        $this->db->where('session_id', $session_id);
        $this->db->order_by('created_at', 'ASC');
        
        if ($limit) {
            $this->db->limit($limit);
        }
        
        $query = $this->db->get('chat_messages');
        return $query->result_array();
    }

    /**
     * Save feedback for a message
     */
    public function save_feedback($message_id, $session_id, $rating, $comment = null) {
        $data = [
            'message_id' => $message_id,
            'session_id' => $session_id,
            'rating' => $rating,
            'comment' => $comment
        ];
        
        return $this->db->insert('chat_feedback', $data);
    }

    /**
     * Get all chat sessions (for admin)
     */
    public function get_all_sessions($limit = 50, $offset = 0) {
        $this->db->select('cs.*, COUNT(cm.id) as message_count');
        $this->db->from('chat_sessions cs');
        $this->db->join('chat_messages cm', 'cs.session_id = cm.session_id', 'left');
        $this->db->group_by('cs.id');
        $this->db->order_by('cs.updated_at', 'DESC');
        $this->db->limit($limit, $offset);
        
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Get session details with messages
     */
    public function get_session_details($session_id) {
        $session = $this->db->get_where('chat_sessions', ['session_id' => $session_id])->row_array();
        
        if ($session) {
            $session['messages'] = $this->get_session_messages($session_id);
        }
        
        return $session;
    }
}
