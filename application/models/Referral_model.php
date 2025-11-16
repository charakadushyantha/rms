<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Referral_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // Get all referrals
    public function get_all_referrals($filters = [])
    {
        $this->db->select('r.*, u.u_username as referrer_full_name');
        $this->db->from('referrals r');
        $this->db->join('users u', 'r.referrer_id = u.u_id', 'left');
        
        if (!empty($filters['status'])) {
            $this->db->where('r.referral_status', $filters['status']);
        }
        
        if (!empty($filters['referrer_id'])) {
            $this->db->where('r.referrer_id', $filters['referrer_id']);
        }
        
        if (!empty($filters['date_from'])) {
            $this->db->where('r.referral_date >=', $filters['date_from']);
        }
        
        if (!empty($filters['date_to'])) {
            $this->db->where('r.referral_date <=', $filters['date_to']);
        }
        
        $this->db->order_by('r.created_at', 'DESC');
        return $this->db->get()->result();
    }

    // Get single referral
    public function get_referral($referral_id)
    {
        $this->db->select('r.*, u.u_username as referrer_full_name, u.u_email as referrer_user_email');
        $this->db->from('referrals r');
        $this->db->join('users u', 'r.referrer_id = u.u_id', 'left');
        $this->db->where('r.referral_id', $referral_id);
        return $this->db->get()->row();
    }

    // Create referral
    public function create_referral($data)
    {
        // Generate unique referral code
        $data['referral_code'] = $this->generate_referral_code();
        
        if ($this->db->insert('referrals', $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    // Update referral
    public function update_referral($referral_id, $data)
    {
        $this->db->where('referral_id', $referral_id);
        return $this->db->update('referrals', $data);
    }

    // Delete referral
    public function delete_referral($referral_id)
    {
        $this->db->where('referral_id', $referral_id);
        return $this->db->delete('referrals');
    }

    // Get referrals by user
    public function get_user_referrals($user_id)
    {
        $this->db->where('referrer_id', $user_id);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('referrals')->result();
    }

    // Count referrals by status
    public function count_by_status($status = null, $user_id = null)
    {
        if ($status) {
            $this->db->where('referral_status', $status);
        }
        if ($user_id) {
            $this->db->where('referrer_id', $user_id);
        }
        return $this->db->count_all_results('referrals');
    }

    // Get top referrers
    public function get_top_referrers($limit = 10)
    {
        $sql = "SELECT 
                    r.referrer_id,
                    r.referrer_name,
                    COUNT(*) as total_referrals,
                    SUM(CASE WHEN r.referral_status = 'Hired' THEN 1 ELSE 0 END) as hired_count,
                    SUM(CASE WHEN r.bonus_status = 'Paid' THEN r.bonus_amount ELSE 0 END) as total_bonuses
                FROM referrals r
                GROUP BY r.referrer_id, r.referrer_name
                ORDER BY hired_count DESC, total_referrals DESC
                LIMIT ?";
        
        return $this->db->query($sql, [$limit])->result();
    }

    // Get referral statistics
    public function get_statistics($user_id = null)
    {
        $stats = [];
        
        $where = $user_id ? "WHERE referrer_id = $user_id" : "";
        $and_where = $user_id ? "AND" : "WHERE";
        
        // Total referrals
        $stats['total'] = $this->db->query("SELECT COUNT(*) as count FROM referrals $where")->row()->count;
        
        // By status
        $stats['submitted'] = $this->db->query("SELECT COUNT(*) as count FROM referrals $where $and_where referral_status = 'Submitted'")->row()->count;
        $stats['screening'] = $this->db->query("SELECT COUNT(*) as count FROM referrals $where $and_where referral_status = 'Screening'")->row()->count;
        $stats['interviewing'] = $this->db->query("SELECT COUNT(*) as count FROM referrals $where $and_where referral_status = 'Interviewing'")->row()->count;
        $stats['hired'] = $this->db->query("SELECT COUNT(*) as count FROM referrals $where $and_where referral_status = 'Hired'")->row()->count;
        $stats['rejected'] = $this->db->query("SELECT COUNT(*) as count FROM referrals $where $and_where referral_status = 'Rejected'")->row()->count;
        
        // Bonus stats
        $bonus_query = $this->db->query("SELECT 
            SUM(CASE WHEN bonus_status = 'Paid' THEN bonus_amount ELSE 0 END) as paid,
            SUM(CASE WHEN bonus_status = 'Pending' THEN bonus_amount ELSE 0 END) as pending,
            SUM(CASE WHEN bonus_status = 'Approved' THEN bonus_amount ELSE 0 END) as approved
            FROM referrals $where")->row();
        
        $stats['bonus_paid'] = $bonus_query->paid ?? 0;
        $stats['bonus_pending'] = $bonus_query->pending ?? 0;
        $stats['bonus_approved'] = $bonus_query->approved ?? 0;
        
        // Conversion rate
        $stats['conversion_rate'] = $stats['total'] > 0 ? round(($stats['hired'] / $stats['total']) * 100, 2) : 0;
        
        return $stats;
    }

    // Generate unique referral code
    private function generate_referral_code()
    {
        do {
            $code = 'REF' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));
            $exists = $this->db->where('referral_code', $code)->count_all_results('referrals');
        } while ($exists > 0);
        
        return $code;
    }

    // Get or create user referral code
    public function get_user_referral_code($user_id, $username)
    {
        // Validate user_id
        if (!$user_id || empty($user_id)) {
            $user_id = 1; // Default to admin user
        }
        
        $this->db->where('user_id', $user_id);
        $code = $this->db->get('referral_codes')->row();
        
        if (!$code) {
            // Create new code
            $referral_code = strtoupper(substr($username, 0, 3) . rand(1000, 9999));
            $data = [
                'user_id' => $user_id,
                'username' => $username,
                'referral_code' => $referral_code,
                'code_type' => 'personal',
                'is_active' => 1
            ];
            $this->db->insert('referral_codes', $data);
            return $referral_code;
        }
        
        return $code->referral_code;
    }

    // Get program configuration
    public function get_config($key = null)
    {
        if ($key) {
            $this->db->where('config_key', $key);
            $config = $this->db->get('referral_program_config')->row();
            return $config ? $config->config_value : null;
        }
        
        $configs = $this->db->get('referral_program_config')->result();
        $result = [];
        foreach ($configs as $config) {
            $result[$config->config_key] = $config->config_value;
        }
        return $result;
    }

    // Update configuration
    public function update_config($key, $value)
    {
        $this->db->where('config_key', $key);
        return $this->db->update('referral_program_config', ['config_value' => $value]);
    }
}
