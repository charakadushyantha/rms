<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Awards_recognition_model extends CI_Model
{
    public function get_all_awards()
    {
        return [
            [
                'award_id' => 1,
                'title' => 'Best Place to Work 2024',
                'organization' => 'Fortune Magazine',
                'category' => 'Workplace Culture',
                'year' => 2024,
                'description' => 'Recognized as one of the top 100 best companies to work for in the United States',
                'badge_url' => 'https://via.placeholder.com/150/667eea/ffffff?text=Fortune',
                'date_received' => '2024-09-15',
                'importance' => 'high'
            ],
            [
                'award_id' => 2,
                'title' => 'Top Employer for Diversity',
                'organization' => 'DiversityInc',
                'category' => 'Diversity & Inclusion',
                'year' => 2024,
                'description' => 'Awarded for outstanding commitment to diversity, equity, and inclusion initiatives',
                'badge_url' => 'https://via.placeholder.com/150/f093fb/ffffff?text=DiversityInc',
                'date_received' => '2024-08-20',
                'importance' => 'high'
            ],
            [
                'award_id' => 3,
                'title' => 'Innovation Excellence Award',
                'organization' => 'Tech Innovation Summit',
                'category' => 'Innovation',
                'year' => 2024,
                'description' => 'Recognized for breakthrough innovations in cloud computing and AI technology',
                'badge_url' => 'https://via.placeholder.com/150/4facfe/ffffff?text=Innovation',
                'date_received' => '2024-07-10',
                'importance' => 'high'
            ],
            [
                'award_id' => 4,
                'title' => 'Great Place to Work Certified',
                'organization' => 'Great Place to Work Institute',
                'category' => 'Workplace Culture',
                'year' => 2024,
                'description' => 'Certified based on employee feedback and workplace practices',
                'badge_url' => 'https://via.placeholder.com/150/11998e/ffffff?text=GPTW',
                'date_received' => '2024-06-05',
                'importance' => 'medium'
            ],
            [
                'award_id' => 5,
                'title' => 'Best Benefits Package',
                'organization' => 'HR Excellence Awards',
                'category' => 'Employee Benefits',
                'year' => 2024,
                'description' => 'Awarded for comprehensive and innovative employee benefits program',
                'badge_url' => 'https://via.placeholder.com/150/fa709a/ffffff?text=HR+Excellence',
                'date_received' => '2024-05-15',
                'importance' => 'medium'
            ],
            [
                'award_id' => 6,
                'title' => 'Top 50 Startups to Watch',
                'organization' => 'TechCrunch',
                'category' => 'Business Growth',
                'year' => 2023,
                'description' => 'Featured in TechCrunch\'s annual list of most promising tech companies',
                'badge_url' => 'https://via.placeholder.com/150/ffecd2/333333?text=TechCrunch',
                'date_received' => '2023-12-01',
                'importance' => 'high'
            ],
            [
                'award_id' => 7,
                'title' => 'Environmental Leadership Award',
                'organization' => 'Green Business Council',
                'category' => 'Sustainability',
                'year' => 2023,
                'description' => 'Recognized for commitment to environmental sustainability and carbon neutrality',
                'badge_url' => 'https://via.placeholder.com/150/38ef7d/ffffff?text=Green',
                'date_received' => '2023-10-20',
                'importance' => 'medium'
            ],
            [
                'award_id' => 8,
                'title' => 'Customer Choice Award',
                'organization' => 'Gartner Peer Insights',
                'category' => 'Customer Satisfaction',
                'year' => 2023,
                'description' => 'Highest customer satisfaction ratings in enterprise software category',
                'badge_url' => 'https://via.placeholder.com/150/764ba2/ffffff?text=Gartner',
                'date_received' => '2023-09-10',
                'importance' => 'high'
            ]
        ];
    }

    public function get_award_stats()
    {
        return [
            'total_awards' => 8,
            'awards_2024' => 5,
            'categories' => 7,
            'high_importance' => 5,
            'recent_awards' => 3
        ];
    }

    public function get_categories()
    {
        return [
            ['name' => 'Workplace Culture', 'count' => 2],
            ['name' => 'Diversity & Inclusion', 'count' => 1],
            ['name' => 'Innovation', 'count' => 1],
            ['name' => 'Employee Benefits', 'count' => 1],
            ['name' => 'Business Growth', 'count' => 1],
            ['name' => 'Sustainability', 'count' => 1],
            ['name' => 'Customer Satisfaction', 'count' => 1]
        ];
    }

    public function get_certifications()
    {
        return [
            [
                'cert_id' => 1,
                'name' => 'ISO 9001:2015',
                'type' => 'Quality Management',
                'issuer' => 'International Organization for Standardization',
                'issue_date' => '2023-01-15',
                'expiry_date' => '2026-01-15',
                'status' => 'Active'
            ],
            [
                'cert_id' => 2,
                'name' => 'ISO 27001:2013',
                'type' => 'Information Security',
                'issuer' => 'International Organization for Standardization',
                'issue_date' => '2023-03-20',
                'expiry_date' => '2026-03-20',
                'status' => 'Active'
            ],
            [
                'cert_id' => 3,
                'name' => 'SOC 2 Type II',
                'type' => 'Security & Compliance',
                'issuer' => 'AICPA',
                'issue_date' => '2024-01-10',
                'expiry_date' => '2025-01-10',
                'status' => 'Active'
            ],
            [
                'cert_id' => 4,
                'name' => 'B Corporation Certification',
                'type' => 'Social & Environmental',
                'issuer' => 'B Lab',
                'issue_date' => '2023-06-01',
                'expiry_date' => '2026-06-01',
                'status' => 'Active'
            ]
        ];
    }
}
