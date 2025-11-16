<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roi_tracking_model extends CI_Model
{
    public function get_roi_overview()
    {
        return [
            'total_investment' => 125000,
            'total_revenue' => 487500,
            'total_roi' => 290,
            'roi_percentage' => 290,
            'cost_per_hire' => 2840,
            'hires_made' => 44,
            'average_time_to_hire' => 28,
            'quality_of_hire_score' => 8.4
        ];
    }

    public function get_channel_roi()
    {
        return [
            [
                'channel' => 'Job Boards',
                'investment' => 35000,
                'revenue' => 140000,
                'roi' => 300,
                'hires' => 15,
                'cost_per_hire' => 2333,
                'applications' => 450,
                'conversion_rate' => 3.3,
                'trend' => 'up'
            ],
            [
                'channel' => 'Social Media',
                'investment' => 25000,
                'revenue' => 112500,
                'roi' => 350,
                'hires' => 12,
                'cost_per_hire' => 2083,
                'applications' => 380,
                'conversion_rate' => 3.2,
                'trend' => 'up'
            ],
            [
                'channel' => 'Employee Referrals',
                'investment' => 20000,
                'revenue' => 100000,
                'roi' => 400,
                'hires' => 10,
                'cost_per_hire' => 2000,
                'applications' => 120,
                'conversion_rate' => 8.3,
                'trend' => 'up'
            ],
            [
                'channel' => 'Recruitment Events',
                'investment' => 30000,
                'revenue' => 87500,
                'roi' => 192,
                'hires' => 5,
                'cost_per_hire' => 6000,
                'applications' => 200,
                'conversion_rate' => 2.5,
                'trend' => 'stable'
            ],
            [
                'channel' => 'Paid Advertising',
                'investment' => 15000,
                'revenue' => 47500,
                'roi' => 217,
                'hires' => 2,
                'cost_per_hire' => 7500,
                'applications' => 150,
                'conversion_rate' => 1.3,
                'trend' => 'down'
            ]
        ];
    }

    public function get_campaign_roi()
    {
        return [
            [
                'campaign_name' => 'Q4 Engineering Hiring',
                'channel' => 'Job Boards',
                'investment' => 12000,
                'revenue' => 50000,
                'roi' => 317,
                'hires' => 5,
                'start_date' => '2024-10-01',
                'end_date' => '2024-12-31',
                'status' => 'Active'
            ],
            [
                'campaign_name' => 'LinkedIn Talent Campaign',
                'channel' => 'Social Media',
                'investment' => 8000,
                'revenue' => 37500,
                'roi' => 369,
                'hires' => 4,
                'start_date' => '2024-09-15',
                'end_date' => '2024-11-30',
                'status' => 'Active'
            ],
            [
                'campaign_name' => 'Referral Bonus Program',
                'channel' => 'Employee Referrals',
                'investment' => 10000,
                'revenue' => 50000,
                'roi' => 400,
                'hires' => 5,
                'start_date' => '2024-08-01',
                'end_date' => '2024-12-31',
                'status' => 'Active'
            ],
            [
                'campaign_name' => 'Tech Career Fair 2024',
                'channel' => 'Recruitment Events',
                'investment' => 15000,
                'revenue' => 37500,
                'roi' => 150,
                'hires' => 3,
                'start_date' => '2024-09-20',
                'end_date' => '2024-09-22',
                'status' => 'Completed'
            ]
        ];
    }

    public function get_roi_trends()
    {
        return [
            'monthly' => [
                ['month' => 'Jun', 'roi' => 245, 'investment' => 18000, 'revenue' => 62100],
                ['month' => 'Jul', 'roi' => 268, 'investment' => 20000, 'revenue' => 73600],
                ['month' => 'Aug', 'roi' => 282, 'investment' => 22000, 'revenue' => 84040],
                ['month' => 'Sep', 'roi' => 275, 'investment' => 21000, 'revenue' => 78750],
                ['month' => 'Oct', 'roi' => 290, 'investment' => 23000, 'revenue' => 89700],
                ['month' => 'Nov', 'roi' => 305, 'investment' => 21000, 'revenue' => 85050]
            ],
            'quarterly' => [
                ['quarter' => 'Q1 2024', 'roi' => 235, 'investment' => 52000, 'revenue' => 174200],
                ['quarter' => 'Q2 2024', 'roi' => 265, 'investment' => 58000, 'revenue' => 211700],
                ['quarter' => 'Q3 2024', 'roi' => 279, 'investment' => 63000, 'revenue' => 238770],
                ['quarter' => 'Q4 2024', 'roi' => 298, 'investment' => 64000, 'revenue' => 254720]
            ]
        ];
    }

    public function get_channel_details($channel_name)
    {
        $channels = $this->get_channel_roi();
        foreach ($channels as $channel) {
            if (strtolower(str_replace(' ', '_', $channel['channel'])) == strtolower($channel_name)) {
                return $channel;
            }
        }
        return null;
    }

    public function get_roi_forecast()
    {
        return [
            'next_quarter' => [
                'projected_investment' => 68000,
                'projected_revenue' => 217600,
                'projected_roi' => 320,
                'confidence' => 85
            ],
            'next_6_months' => [
                'projected_investment' => 135000,
                'projected_revenue' => 459000,
                'projected_roi' => 340,
                'confidence' => 78
            ],
            'next_year' => [
                'projected_investment' => 280000,
                'projected_revenue' => 1008000,
                'projected_roi' => 360,
                'confidence' => 65
            ]
        ];
    }
}
