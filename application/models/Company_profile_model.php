<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company_profile_model extends CI_Model
{
    public function get_company_profile()
    {
        return [
            'company_name' => 'TechCorp Solutions',
            'tagline' => 'Innovating the Future of Technology',
            'industry' => 'Information Technology & Services',
            'company_size' => '500-1000 employees',
            'founded' => '2010',
            'headquarters' => 'San Francisco, CA',
            'website' => 'https://techcorp.example.com',
            'description' => 'TechCorp Solutions is a leading technology company specializing in cloud computing, AI, and enterprise software solutions. We empower businesses worldwide with innovative technology that drives growth and efficiency.',
            'mission' => 'To transform businesses through cutting-edge technology and exceptional service.',
            'vision' => 'To be the world\'s most trusted technology partner.',
            'values' => ['Innovation', 'Integrity', 'Collaboration', 'Excellence', 'Customer Focus'],
            'locations' => [
                ['city' => 'San Francisco', 'country' => 'USA', 'employees' => 450],
                ['city' => 'London', 'country' => 'UK', 'employees' => 200],
                ['city' => 'Singapore', 'country' => 'Singapore', 'employees' => 150],
                ['city' => 'Toronto', 'country' => 'Canada', 'employees' => 100]
            ],
            'social_media' => [
                'linkedin' => 'https://linkedin.com/company/techcorp',
                'twitter' => 'https://twitter.com/techcorp',
                'facebook' => 'https://facebook.com/techcorp',
                'instagram' => 'https://instagram.com/techcorp'
            ]
        ];
    }

    public function get_profile_stats()
    {
        return [
            'total_employees' => 900,
            'open_positions' => 45,
            'departments' => 12,
            'countries' => 4,
            'profile_views' => 15420,
            'follower_growth' => 23.5
        ];
    }

    public function get_culture_data()
    {
        return [
            'work_environment' => 'Hybrid - Flexible work arrangements',
            'dress_code' => 'Business Casual',
            'perks' => [
                'Unlimited PTO',
                'Remote Work Options',
                'Learning & Development Budget',
                'Gym Membership',
                'Free Lunch & Snacks',
                'Team Building Events',
                'Wellness Programs',
                'Pet-Friendly Office'
            ],
            'diversity' => [
                'women_in_leadership' => 42,
                'ethnic_diversity' => 65,
                'lgbtq_inclusive' => true,
                'disability_friendly' => true
            ],
            'employee_testimonials' => [
                [
                    'name' => 'Sarah Johnson',
                    'role' => 'Senior Software Engineer',
                    'quote' => 'Best company culture I\'ve experienced. The work-life balance is exceptional.',
                    'rating' => 5
                ],
                [
                    'name' => 'Michael Chen',
                    'role' => 'Product Manager',
                    'quote' => 'Great opportunities for growth and learning. Management truly cares about employees.',
                    'rating' => 5
                ]
            ]
        ];
    }

    public function get_benefits()
    {
        return [
            'health' => [
                'Medical Insurance' => 'Comprehensive health coverage',
                'Dental Insurance' => 'Full dental care',
                'Vision Insurance' => 'Eye care coverage',
                'Mental Health Support' => '24/7 counseling services'
            ],
            'financial' => [
                '401(k) Matching' => 'Up to 6% employer match',
                'Stock Options' => 'Employee equity program',
                'Performance Bonuses' => 'Quarterly and annual bonuses',
                'Relocation Assistance' => 'Full relocation package'
            ],
            'time_off' => [
                'Unlimited PTO' => 'Take time when you need it',
                'Parental Leave' => '16 weeks paid leave',
                'Sabbatical Program' => '4 weeks after 5 years',
                'Volunteer Days' => '5 paid volunteer days/year'
            ],
            'development' => [
                'Learning Budget' => '$2,000/year for courses',
                'Conference Attendance' => 'Sponsored conference trips',
                'Mentorship Program' => 'Career development support',
                'Tuition Reimbursement' => 'Up to $10,000/year'
            ]
        ];
    }
}
