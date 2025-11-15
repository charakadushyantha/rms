<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marketing_campaign_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // Get all campaigns
    public function get_all_campaigns($filters = [])
    {
        $this->db->select('mc.*, 
            COUNT(DISTINCT ec.email_campaign_id) as email_count,
            COUNT(DISTINCT sp.post_id) as social_count,
            COUNT(DISTINCT ac.ad_campaign_id) as ad_count,
            COALESCE(SUM(ca.reach), 0) as total_reach,
            COALESCE(SUM(ca.clicks), 0) as total_clicks,
            COALESCE(SUM(ca.applications), 0) as total_applications');
        $this->db->from('marketing_campaigns mc');
        $this->db->join('email_campaigns ec', 'mc.campaign_id = ec.campaign_id', 'left');
        $this->db->join('social_posts sp', 'mc.campaign_id = sp.campaign_id', 'left');
        $this->db->join('ad_campaigns ac', 'mc.campaign_id = ac.campaign_id', 'left');
        $this->db->join('campaign_analytics ca', 'mc.campaign_id = ca.campaign_id', 'left');
        
        if (!empty($filters['status'])) {
            $this->db->where('mc.status', $filters['status']);
        }
        
        if (!empty($filters['type'])) {
            $this->db->where('mc.campaign_type', $filters['type']);
        }
        
        $this->db->group_by('mc.campaign_id');
        $this->db->order_by('mc.created_at', 'DESC');
        
        return $this->db->get()->result_array();
    }

    // Get single campaign
    public function get_campaign($campaign_id)
    {
        return $this->db->where('campaign_id', $campaign_id)
                       ->get('marketing_campaigns')->row_array();
    }

    // Create campaign
    public function create_campaign($data)
    {
        if ($this->db->insert('marketing_campaigns', $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    // Update campaign
    public function update_campaign($campaign_id, $data)
    {
        $this->db->where('campaign_id', $campaign_id);
        return $this->db->update('marketing_campaigns', $data);
    }

    // Delete campaign
    public function delete_campaign($campaign_id)
    {
        $this->db->where('campaign_id', $campaign_id);
        return $this->db->delete('marketing_campaigns');
    }

    // Email campaigns
    public function get_email_campaigns($campaign_id)
    {
        return $this->db->where('campaign_id', $campaign_id)
                       ->get('email_campaigns')->result_array();
    }

    public function create_email_campaign($data)
    {
        if ($this->db->insert('email_campaigns', $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    // Social posts
    public function get_social_posts($campaign_id)
    {
        return $this->db->where('campaign_id', $campaign_id)
                       ->order_by('scheduled_date', 'DESC')
                       ->get('social_posts')->result_array();
    }

    public function create_social_post($data)
    {
        if ($this->db->insert('social_posts', $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    // Ad campaigns
    public function get_ad_campaigns($campaign_id)
    {
        return $this->db->where('campaign_id', $campaign_id)
                       ->get('ad_campaigns')->result_array();
    }

    public function create_ad_campaign($data)
    {
        if ($this->db->insert('ad_campaigns', $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    // Templates
    public function get_all_templates()
    {
        return $this->db->where('is_active', 1)
                       ->order_by('template_name')
                       ->get('email_templates')->result_array();
    }

    // Statistics
    public function get_statistics()
    {
        $stats = [];
        
        $stats['total_campaigns'] = $this->db->count_all('marketing_campaigns');
        $stats['active_campaigns'] = $this->db->where('status', 'Active')->count_all_results('marketing_campaigns');
        
        // Campaign budget
        $budget_query = $this->db->select('SUM(budget) as total_budget')->get('marketing_campaigns')->row_array();
        $stats['total_budget'] = $budget_query['total_budget'] ?? 0;
        
        // Analytics aggregation
        $analytics = $this->db->select('SUM(reach) as total_reach, SUM(clicks) as total_clicks, SUM(applications) as total_applications')
                             ->get('campaign_analytics')->row_array();
        $stats['total_reach'] = $analytics['total_reach'] ?? 0;
        $stats['total_clicks'] = $analytics['total_clicks'] ?? 0;
        $stats['total_applications'] = $analytics['total_applications'] ?? 0;
        
        // Email stats
        $email_stats = $this->db->select('SUM(total_sent) as sent, SUM(total_opened) as opened, SUM(total_clicked) as clicked')
                               ->get('email_campaigns')->row_array();
        $stats['emails_sent'] = $email_stats['sent'] ?? 0;
        $stats['emails_opened'] = $email_stats['opened'] ?? 0;
        $stats['emails_clicked'] = $email_stats['clicked'] ?? 0;
        
        // Social stats
        $social_stats = $this->db->select('SUM(impressions) as impressions, SUM(engagements) as engagements, SUM(clicks) as clicks')
                                ->get('social_posts')->row_array();
        $stats['social_impressions'] = $social_stats['impressions'] ?? 0;
        $stats['social_engagements'] = $social_stats['engagements'] ?? 0;
        
        // Ad stats
        $ad_stats = $this->db->select('SUM(budget) as budget, SUM(spent) as spent, SUM(applications) as applications')
                            ->get('ad_campaigns')->row_array();
        $stats['ad_budget'] = $ad_stats['budget'] ?? 0;
        $stats['ad_spent'] = $ad_stats['spent'] ?? 0;
        $stats['ad_applications'] = $ad_stats['applications'] ?? 0;
        
        return $stats;
    }

    // Get campaign performance
    public function get_campaign_performance($campaign_id)
    {
        return $this->db->where('campaign_id', $campaign_id)
                       ->order_by('date', 'DESC')
                       ->get('campaign_analytics')->result_array();
    }
}
