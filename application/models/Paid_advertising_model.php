<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paid_advertising_model extends CI_Model
{
    public function get_all_campaigns()
    {
        // Sample data until database tables are created
        return [
            [
                'campaign_id' => 1,
                'campaign_name' => 'LinkedIn Sponsored Jobs - Engineering',
                'platform' => 'LinkedIn',
                'status' => 'Active',
                'budget' => 5000.00,
                'spent' => 2340.50,
                'impressions' => 45000,
                'clicks' => 1200,
                'applications' => 89,
                'cpc' => 1.95,
                'cpa' => 26.30,
                'start_date' => '2024-11-01',
                'end_date' => '2024-11-30'
            ],
            [
                'campaign_id' => 2,
                'campaign_name' => 'Indeed Sponsored Posts - Sales',
                'platform' => 'Indeed',
                'status' => 'Active',
                'budget' => 3000.00,
                'spent' => 1890.75,
                'impressions' => 32000,
                'clicks' => 890,
                'applications' => 67,
                'cpc' => 2.12,
                'cpa' => 28.22,
                'start_date' => '2024-11-05',
                'end_date' => '2024-12-05'
            ],
            [
                'campaign_id' => 3,
                'campaign_name' => 'Google Jobs - Marketing Roles',
                'platform' => 'Google Jobs',
                'status' => 'Paused',
                'budget' => 2500.00,
                'spent' => 1200.00,
                'impressions' => 28000,
                'clicks' => 650,
                'applications' => 45,
                'cpc' => 1.85,
                'cpa' => 26.67,
                'start_date' => '2024-10-15',
                'end_date' => '2024-11-15'
            ]
        ];
    }

    public function get_statistics()
    {
        $campaigns = $this->get_all_campaigns();
        
        $stats = [
            'total_campaigns' => count($campaigns),
            'active_campaigns' => 0,
            'total_budget' => 0,
            'total_spent' => 0,
            'total_impressions' => 0,
            'total_clicks' => 0,
            'total_applications' => 0
        ];
        
        foreach ($campaigns as $campaign) {
            if ($campaign['status'] == 'Active') {
                $stats['active_campaigns']++;
            }
            $stats['total_budget'] += $campaign['budget'];
            $stats['total_spent'] += $campaign['spent'];
            $stats['total_impressions'] += $campaign['impressions'];
            $stats['total_clicks'] += $campaign['clicks'];
            $stats['total_applications'] += $campaign['applications'];
        }
        
        $stats['avg_cpc'] = $stats['total_clicks'] > 0 ? $stats['total_spent'] / $stats['total_clicks'] : 0;
        $stats['avg_cpa'] = $stats['total_applications'] > 0 ? $stats['total_spent'] / $stats['total_applications'] : 0;
        $stats['ctr'] = $stats['total_impressions'] > 0 ? ($stats['total_clicks'] / $stats['total_impressions']) * 100 : 0;
        
        return $stats;
    }

    public function get_performance_data()
    {
        return $this->get_all_campaigns();
    }
}
