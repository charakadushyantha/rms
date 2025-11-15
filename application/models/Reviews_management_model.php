<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reviews_management_model extends CI_Model
{
    public function get_all_reviews()
    {
        return [
            [
                'review_id' => 1,
                'platform' => 'Glassdoor',
                'rating' => 4.5,
                'title' => 'Great place to work with excellent benefits',
                'review_text' => 'I\'ve been with TechCorp for 3 years and it\'s been an amazing journey. The work-life balance is excellent, management is supportive, and the benefits are top-notch.',
                'pros' => 'Great culture, competitive salary, learning opportunities',
                'cons' => 'Fast-paced environment can be challenging',
                'reviewer_role' => 'Software Engineer',
                'employment_status' => 'Current Employee',
                'date' => '2024-11-10',
                'helpful_count' => 24,
                'responded' => true,
                'response_date' => '2024-11-11',
                'sentiment' => 'positive'
            ],
            [
                'review_id' => 2,
                'platform' => 'Indeed',
                'rating' => 5.0,
                'title' => 'Best company I\'ve ever worked for',
                'review_text' => 'The leadership team genuinely cares about employees. Unlimited PTO is real, not just on paper. Great opportunities for career growth.',
                'pros' => 'Excellent benefits, supportive management, innovation-driven',
                'cons' => 'None that I can think of',
                'reviewer_role' => 'Product Manager',
                'employment_status' => 'Current Employee',
                'date' => '2024-11-08',
                'helpful_count' => 31,
                'responded' => true,
                'response_date' => '2024-11-09',
                'sentiment' => 'positive'
            ],
            [
                'review_id' => 3,
                'platform' => 'Glassdoor',
                'rating' => 3.5,
                'title' => 'Good company but room for improvement',
                'review_text' => 'Overall positive experience. Good pay and benefits. However, communication between departments could be better.',
                'pros' => 'Good compensation, nice office, smart colleagues',
                'cons' => 'Communication gaps, sometimes unclear priorities',
                'reviewer_role' => 'Marketing Specialist',
                'employment_status' => 'Current Employee',
                'date' => '2024-11-05',
                'helpful_count' => 18,
                'responded' => false,
                'response_date' => null,
                'sentiment' => 'neutral'
            ],
            [
                'review_id' => 4,
                'platform' => 'LinkedIn',
                'rating' => 5.0,
                'title' => 'Incredible learning environment',
                'review_text' => 'As a junior developer, I couldn\'t ask for a better place to start my career. The mentorship program is outstanding.',
                'pros' => 'Great mentorship, learning budget, modern tech stack',
                'cons' => 'High expectations for performance',
                'reviewer_role' => 'Junior Developer',
                'employment_status' => 'Current Employee',
                'date' => '2024-11-03',
                'helpful_count' => 27,
                'responded' => true,
                'response_date' => '2024-11-04',
                'sentiment' => 'positive'
            ],
            [
                'review_id' => 5,
                'platform' => 'Indeed',
                'rating' => 4.0,
                'title' => 'Solid company with good work-life balance',
                'review_text' => 'Been here for 2 years. The hybrid work model is great. Management is generally supportive though some teams are better than others.',
                'pros' => 'Flexible schedule, good benefits, interesting projects',
                'cons' => 'Inconsistent management quality across teams',
                'reviewer_role' => 'Data Analyst',
                'employment_status' => 'Current Employee',
                'date' => '2024-10-28',
                'helpful_count' => 15,
                'responded' => false,
                'response_date' => null,
                'sentiment' => 'positive'
            ]
        ];
    }

    public function get_review($review_id)
    {
        $reviews = $this->get_all_reviews();
        foreach ($reviews as $review) {
            if ($review['review_id'] == $review_id) {
                return $review;
            }
        }
        return null;
    }

    public function get_review_stats()
    {
        $reviews = $this->get_all_reviews();
        $total = count($reviews);
        $total_rating = array_sum(array_column($reviews, 'rating'));
        
        $sentiment_counts = [
            'positive' => 0,
            'neutral' => 0,
            'negative' => 0
        ];
        
        foreach ($reviews as $review) {
            $sentiment_counts[$review['sentiment']]++;
        }
        
        return [
            'total_reviews' => $total,
            'average_rating' => round($total_rating / $total, 1),
            'response_rate' => round((count(array_filter($reviews, function($r) { return $r['responded']; })) / $total) * 100, 1),
            'positive_reviews' => $sentiment_counts['positive'],
            'neutral_reviews' => $sentiment_counts['neutral'],
            'negative_reviews' => $sentiment_counts['negative'],
            'recent_reviews' => 12,
            'rating_trend' => '+0.3'
        ];
    }

    public function get_platform_stats()
    {
        return [
            [
                'platform' => 'Glassdoor',
                'total_reviews' => 234,
                'average_rating' => 4.3,
                'recent_reviews' => 8
            ],
            [
                'platform' => 'Indeed',
                'total_reviews' => 189,
                'average_rating' => 4.5,
                'recent_reviews' => 6
            ],
            [
                'platform' => 'LinkedIn',
                'total_reviews' => 156,
                'average_rating' => 4.6,
                'recent_reviews' => 4
            ],
            [
                'platform' => 'Google',
                'total_reviews' => 98,
                'average_rating' => 4.4,
                'recent_reviews' => 3
            ]
        ];
    }

    public function get_review_trends()
    {
        return [
            'monthly' => [
                ['month' => 'Jun', 'reviews' => 18, 'rating' => 4.2],
                ['month' => 'Jul', 'reviews' => 22, 'rating' => 4.3],
                ['month' => 'Aug', 'reviews' => 25, 'rating' => 4.4],
                ['month' => 'Sep', 'reviews' => 20, 'rating' => 4.3],
                ['month' => 'Oct', 'reviews' => 28, 'rating' => 4.5],
                ['month' => 'Nov', 'reviews' => 15, 'rating' => 4.4]
            ]
        ];
    }

    public function get_sentiment_analysis()
    {
        return [
            'positive_keywords' => ['culture', 'benefits', 'balance', 'growth', 'supportive'],
            'negative_keywords' => ['communication', 'priorities', 'pressure'],
            'top_pros' => [
                'Work-life balance' => 78,
                'Benefits' => 72,
                'Company culture' => 68,
                'Career growth' => 65,
                'Management' => 58
            ],
            'top_cons' => [
                'Fast-paced' => 32,
                'Communication' => 28,
                'High expectations' => 24,
                'Workload' => 18
            ]
        ];
    }
}
