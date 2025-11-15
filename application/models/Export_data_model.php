<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Export_data_model extends CI_Model
{
    public function get_export_options()
    {
        return [
            [
                'category' => 'Candidates',
                'name' => 'All Candidates',
                'description' => 'Export complete candidate database',
                'record_count' => 2450,
                'formats' => ['CSV', 'Excel', 'PDF'],
                'icon' => 'fa-users'
            ],
            [
                'category' => 'Candidates',
                'name' => 'Active Candidates',
                'description' => 'Export candidates in active pipeline',
                'record_count' => 380,
                'formats' => ['CSV', 'Excel'],
                'icon' => 'fa-user-check'
            ],
            [
                'category' => 'Jobs',
                'name' => 'Job Postings',
                'description' => 'Export all job postings and details',
                'record_count' => 45,
                'formats' => ['CSV', 'Excel', 'PDF'],
                'icon' => 'fa-briefcase'
            ],
            [
                'category' => 'Jobs',
                'name' => 'Applications',
                'description' => 'Export job applications data',
                'record_count' => 1250,
                'formats' => ['CSV', 'Excel'],
                'icon' => 'fa-file-alt'
            ],
            [
                'category' => 'Analytics',
                'name' => 'Recruitment Metrics',
                'description' => 'Export key recruitment KPIs',
                'record_count' => 150,
                'formats' => ['CSV', 'Excel', 'PDF'],
                'icon' => 'fa-chart-line'
            ],
            [
                'category' => 'Analytics',
                'name' => 'Source Performance',
                'description' => 'Export candidate source analytics',
                'record_count' => 25,
                'formats' => ['CSV', 'Excel', 'PDF'],
                'icon' => 'fa-chart-bar'
            ],
            [
                'category' => 'Financial',
                'name' => 'Cost Analysis',
                'description' => 'Export recruitment cost data',
                'record_count' => 180,
                'formats' => ['CSV', 'Excel'],
                'icon' => 'fa-dollar-sign'
            ],
            [
                'category' => 'Financial',
                'name' => 'ROI Reports',
                'description' => 'Export ROI tracking data',
                'record_count' => 60,
                'formats' => ['CSV', 'Excel', 'PDF'],
                'icon' => 'fa-chart-pie'
            ],
            [
                'category' => 'Marketing',
                'name' => 'Campaign Data',
                'description' => 'Export marketing campaign results',
                'record_count' => 35,
                'formats' => ['CSV', 'Excel'],
                'icon' => 'fa-bullhorn'
            ],
            [
                'category' => 'Marketing',
                'name' => 'Email Analytics',
                'description' => 'Export email campaign metrics',
                'record_count' => 120,
                'formats' => ['CSV', 'Excel'],
                'icon' => 'fa-envelope'
            ]
        ];
    }

    public function get_recent_exports()
    {
        return [
            [
                'export_id' => 1,
                'name' => 'All Candidates - November 2024',
                'data_type' => 'Candidates',
                'format' => 'Excel',
                'records' => 2450,
                'file_size' => '3.2 MB',
                'exported_by' => 'Admin',
                'export_date' => '2024-11-12 10:30:00',
                'status' => 'Completed',
                'filename' => 'candidates_2024-11-12.xlsx'
            ],
            [
                'export_id' => 2,
                'name' => 'Recruitment Metrics - Q4',
                'data_type' => 'Analytics',
                'format' => 'PDF',
                'records' => 150,
                'file_size' => '1.8 MB',
                'exported_by' => 'HR Manager',
                'export_date' => '2024-11-10 14:15:00',
                'status' => 'Completed',
                'filename' => 'metrics_q4_2024.pdf'
            ],
            [
                'export_id' => 3,
                'name' => 'Active Applications',
                'data_type' => 'Applications',
                'format' => 'CSV',
                'records' => 380,
                'file_size' => '450 KB',
                'exported_by' => 'Recruiter',
                'export_date' => '2024-11-08 09:20:00',
                'status' => 'Completed',
                'filename' => 'applications_active.csv'
            ],
            [
                'export_id' => 4,
                'name' => 'Cost Analysis Report',
                'data_type' => 'Financial',
                'format' => 'Excel',
                'records' => 180,
                'file_size' => '2.1 MB',
                'exported_by' => 'Finance',
                'export_date' => '2024-11-05 16:45:00',
                'status' => 'Completed',
                'filename' => 'cost_analysis_nov.xlsx'
            ],
            [
                'export_id' => 5,
                'name' => 'Job Postings Archive',
                'data_type' => 'Jobs',
                'format' => 'PDF',
                'records' => 45,
                'file_size' => '5.4 MB',
                'exported_by' => 'Admin',
                'export_date' => '2024-11-01 11:00:00',
                'status' => 'Completed',
                'filename' => 'jobs_archive_2024.pdf'
            ]
        ];
    }

    public function get_export_stats()
    {
        return [
            'total_exports' => 127,
            'exports_this_month' => 18,
            'total_data_exported' => '2.4 GB',
            'most_exported' => 'Candidates',
            'average_export_time' => 4.5,
            'scheduled_exports' => 5
        ];
    }

    public function get_available_fields($data_type)
    {
        $fields = [
            'candidates' => [
                'Basic Info' => ['Name', 'Email', 'Phone', 'Location', 'Status'],
                'Professional' => ['Current Title', 'Company', 'Experience Years', 'Education'],
                'Application' => ['Applied Date', 'Source', 'Current Stage', 'Assigned Recruiter'],
                'Skills' => ['Skills', 'Certifications', 'Languages'],
                'Additional' => ['Resume URL', 'LinkedIn', 'Portfolio', 'Notes']
            ],
            'jobs' => [
                'Basic Info' => ['Job Title', 'Department', 'Location', 'Employment Type'],
                'Details' => ['Description', 'Requirements', 'Salary Range', 'Benefits'],
                'Status' => ['Status', 'Posted Date', 'Closing Date', 'Filled Date'],
                'Metrics' => ['Applications', 'Views', 'Hires', 'Time to Fill']
            ],
            'analytics' => [
                'Metrics' => ['Applications', 'Interviews', 'Offers', 'Hires', 'Rejections'],
                'Time' => ['Time to Fill', 'Time to Hire', 'Response Time'],
                'Cost' => ['Cost Per Hire', 'Total Cost', 'ROI'],
                'Quality' => ['Quality Score', 'Retention Rate', 'Performance Rating']
            ]
        ];

        return isset($fields[$data_type]) ? $fields[$data_type] : [];
    }

    public function get_available_filters($data_type)
    {
        return [
            'Date Range' => ['Last 7 Days', 'Last 30 Days', 'Last Quarter', 'Last Year', 'Custom Range'],
            'Status' => ['Active', 'Inactive', 'Completed', 'Pending', 'All'],
            'Department' => ['Engineering', 'Sales', 'Marketing', 'Operations', 'All'],
            'Location' => ['San Francisco', 'New York', 'London', 'Remote', 'All']
        ];
    }

    public function get_export_history()
    {
        return $this->get_recent_exports();
    }

    public function get_export($export_id)
    {
        $exports = $this->get_recent_exports();
        foreach ($exports as $export) {
            if ($export['export_id'] == $export_id) {
                return $export;
            }
        }
        return null;
    }
}
