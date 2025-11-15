<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Media_gallery_model extends CI_Model
{
    public function get_all_media()
    {
        return [
            [
                'media_id' => 1,
                'type' => 'image',
                'title' => 'Modern Office Space',
                'description' => 'Our state-of-the-art San Francisco headquarters',
                'category' => 'Office',
                'url' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=800',
                'thumbnail' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=400',
                'uploaded_date' => '2024-11-01',
                'views' => 1245,
                'likes' => 89
            ],
            [
                'media_id' => 2,
                'type' => 'image',
                'title' => 'Team Collaboration',
                'description' => 'Our engineering team working on innovative solutions',
                'category' => 'Team',
                'url' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800',
                'thumbnail' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=400',
                'uploaded_date' => '2024-10-28',
                'views' => 987,
                'likes' => 76
            ],
            [
                'media_id' => 3,
                'type' => 'video',
                'title' => 'Company Culture Video',
                'description' => 'A day in the life at TechCorp',
                'category' => 'Culture',
                'url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'thumbnail' => 'https://images.unsplash.com/photo-1551434678-e076c223a692?w=400',
                'uploaded_date' => '2024-10-25',
                'views' => 3421,
                'likes' => 234
            ],
            [
                'media_id' => 4,
                'type' => 'image',
                'title' => 'Annual Company Event',
                'description' => 'Our 2024 annual gathering in Lake Tahoe',
                'category' => 'Events',
                'url' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?w=800',
                'thumbnail' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?w=400',
                'uploaded_date' => '2024-10-20',
                'views' => 1567,
                'likes' => 145
            ],
            [
                'media_id' => 5,
                'type' => 'image',
                'title' => 'Innovation Lab',
                'description' => 'Where breakthrough ideas come to life',
                'category' => 'Office',
                'url' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=800',
                'thumbnail' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=400',
                'uploaded_date' => '2024-10-15',
                'views' => 892,
                'likes' => 67
            ],
            [
                'media_id' => 6,
                'type' => 'video',
                'title' => 'Employee Testimonials',
                'description' => 'Hear from our team members',
                'category' => 'Culture',
                'url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'thumbnail' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400',
                'uploaded_date' => '2024-10-10',
                'views' => 2156,
                'likes' => 178
            ],
            [
                'media_id' => 7,
                'type' => 'image',
                'title' => 'Hackathon 2024',
                'description' => 'Our annual internal hackathon',
                'category' => 'Events',
                'url' => 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=800',
                'thumbnail' => 'https://images.unsplash.com/photo-504384308090-c894fdcc538d?w=400',
                'uploaded_date' => '2024-10-05',
                'views' => 1123,
                'likes' => 94
            ],
            [
                'media_id' => 8,
                'type' => 'image',
                'title' => 'Wellness Program',
                'description' => 'Yoga and wellness activities',
                'category' => 'Culture',
                'url' => 'https://images.unsplash.com/photo-1545205597-3d9d02c29597?w=800',
                'thumbnail' => 'https://images.unsplash.com/photo-1545205597-3d9d02c29597?w=400',
                'uploaded_date' => '2024-09-28',
                'views' => 756,
                'likes' => 58
            ]
        ];
    }

    public function get_media_stats()
    {
        return [
            'total_photos' => 156,
            'total_videos' => 24,
            'total_views' => 45678,
            'total_likes' => 3421,
            'recent_uploads' => 12,
            'storage_used' => '2.4 GB'
        ];
    }

    public function get_categories()
    {
        return [
            ['name' => 'Office', 'count' => 45],
            ['name' => 'Team', 'count' => 38],
            ['name' => 'Events', 'count' => 52],
            ['name' => 'Culture', 'count' => 45]
        ];
    }

    public function get_videos()
    {
        $all_media = $this->get_all_media();
        return array_filter($all_media, function($item) {
            return $item['type'] === 'video';
        });
    }
}
