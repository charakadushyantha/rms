<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Job_posting_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // Get all job postings with platform info
    public function get_all_jobs()
    {
        $this->db->select('jp.*, jc.category_name, jpos.position_name');
        $this->db->from('job_postings jp');
        $this->db->join('job_categories jc', 'jp.jp_category_id = jc.id', 'left');
        $this->db->join('job_positions jpos', 'jp.jp_position_id = jpos.id', 'left');
        $this->db->order_by('jp.jp_created_at', 'DESC');
        return $this->db->get()->result();
    }

    // Get single job posting
    public function get_job($job_id)
    {
        $this->db->select('jp.*, jc.category_name, jpos.position_name');
        $this->db->from('job_postings jp');
        $this->db->join('job_categories jc', 'jp.jp_category_id = jc.id', 'left');
        $this->db->join('job_positions jpos', 'jp.jp_position_id = jpos.id', 'left');
        $this->db->where('jp.jp_id', $job_id);
        return $this->db->get()->row();
    }

    // Create new job posting
    public function create_job($data)
    {
        if ($this->db->insert('job_postings', $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    // Update job posting
    public function update_job($job_id, $data)
    {
        $this->db->where('jp_id', $job_id);
        return $this->db->update('job_postings', $data);
    }

    // Delete job posting
    public function delete_job($job_id)
    {
        $this->db->where('jp_id', $job_id);
        return $this->db->delete('job_postings');
    }

    // Count jobs by status
    public function count_jobs_by_status($status = null)
    {
        if ($status) {
            $this->db->where('jp_status', $status);
        }
        return $this->db->count_all_results('job_postings');
    }

    // Count total jobs
    public function count_jobs()
    {
        return $this->db->count_all('job_postings');
    }

    // Save posting history
    public function save_history($data)
    {
        return $this->db->insert('job_posting_history', $data);
    }

    // Get posting history for a job
    public function get_posting_history($job_id)
    {
        $this->db->select('jph.*, jp_platforms.platform_name');
        $this->db->from('job_posting_history jph');
        $this->db->join('job_platforms jp_platforms', 'jph.platform_id = jp_platforms.platform_id');
        $this->db->where('jph.jp_id', $job_id);
        $this->db->order_by('jph.created_at', 'DESC');
        return $this->db->get()->result();
    }

    // Get jobs by user
    public function get_jobs_by_user($username)
    {
        $this->db->where('jp_posted_by', $username);
        return $this->db->get('job_postings')->result();
    }

    // Update job status
    public function update_job_status($job_id, $status)
    {
        $this->db->where('jp_id', $job_id);
        return $this->db->update('job_postings', ['jp_status' => $status]);
    }

    // Get expired jobs
    public function get_expired_jobs()
    {
        $this->db->where('jp_expires_at <', date('Y-m-d H:i:s'));
        $this->db->where('jp_status', 'Active');
        return $this->db->get('job_postings')->result();
    }

    // Search jobs
    public function search_jobs($query)
    {
        $this->db->select('jp.*, jc.category_name, jpos.position_name');
        $this->db->from('job_postings jp');
        $this->db->join('job_categories jc', 'jp.jp_category_id = jc.id', 'left');
        $this->db->join('job_positions jpos', 'jp.jp_position_id = jpos.id', 'left');
        $this->db->group_start();
        $this->db->like('jp.jp_title', $query);
        $this->db->or_like('jp.jp_description', $query);
        $this->db->or_like('jp.jp_location', $query);
        $this->db->or_like('jc.category_name', $query);
        $this->db->or_like('jpos.position_name', $query);
        $this->db->group_end();
        $this->db->order_by('jp.jp_created_at', 'DESC');
        return $this->db->get()->result();
    }

    // Get analytics data
    public function get_analytics()
    {
        $analytics = [];
        
        // Total jobs by status
        $analytics['jobs_by_status'] = $this->db->query("
            SELECT jp_status, COUNT(*) as count 
            FROM job_postings 
            GROUP BY jp_status
        ")->result();
        
        // Platform performance
        $analytics['platform_performance'] = $this->db->query("
            SELECT 
                jp_platforms.platform_name,
                COUNT(jph.history_id) as total_posts,
                SUM(jph.views_count) as total_views,
                SUM(jph.clicks_count) as total_clicks,
                SUM(jph.applications_count) as total_applications
            FROM job_platforms jp_platforms
            LEFT JOIN job_posting_history jph ON jp_platforms.platform_id = jph.platform_id
            GROUP BY jp_platforms.platform_id, jp_platforms.platform_name
        ")->result();
        
        // Recent activity
        $analytics['recent_activity'] = $this->db->query("
            SELECT 
                jp.jp_title,
                jp_platforms.platform_name,
                jph.status,
                jph.posted_at
            FROM job_posting_history jph
            JOIN job_postings jp ON jph.jp_id = jp.jp_id
            JOIN job_platforms jp_platforms ON jph.platform_id = jp_platforms.platform_id
            ORDER BY jph.created_at DESC
            LIMIT 10
        ")->result();
        
        // Monthly posting trends
        $analytics['monthly_trends'] = $this->db->query("
            SELECT 
                DATE_FORMAT(jp_created_at, '%Y-%m') as month,
                COUNT(*) as jobs_created
            FROM job_postings 
            WHERE jp_created_at >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
            GROUP BY DATE_FORMAT(jp_created_at, '%Y-%m')
            ORDER BY month
        ")->result();
        
        return $analytics;
    }

    // Get top performing jobs
    public function get_top_performing_jobs($limit = 5)
    {
        $this->db->select('jp.jp_title, jp.jp_id, SUM(jph.applications_count) as total_applications');
        $this->db->from('job_postings jp');
        $this->db->join('job_posting_history jph', 'jp.jp_id = jph.jp_id');
        $this->db->group_by('jp.jp_id');
        $this->db->order_by('total_applications', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }
}
