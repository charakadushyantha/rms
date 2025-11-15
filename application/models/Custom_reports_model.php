<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Custom_reports_model extends CI_Model
{
    public function get_all_reports()
    {
        return [
            [
                'report_id' => 1,
                'report_name' => 'Monthly Recruitment Performance',
                'description' => 'Comprehensive monthly recruitment metrics and KPIs',
                'type' => 'Scheduled',
                'frequency' => 'Monthly',
                'last_run' => '2024-11-01',
                'next_run' => '2024-12-01',
                'created_by' => 'Admin',
                'created_date' => '2024-06-15',
                'status' => 'Active'
            ],
            [
                'report_id' => 2,
                'report_name' => 'Source Effectiveness Analysis',
                'description' => 'Analysis of candidate sources and their effectiveness',
                'type' => 'On-Demand',
                'frequency' => 'As Needed',
                'last_run' => '2024-11-10',
                'next_run' => null,
                'created_by' => 'HR Manager',
                'created_date' => '2024-07-20',
                'status' => 'Active'
            ],
            [
                'report_id' => 3,
                'report_name' => 'Time-to-Hire Dashboard',
                'description' => 'Detailed breakdown of hiring timeline metrics',
                'type' => 'Scheduled',
                'frequency' => 'Weekly',
                'last_run' => '2024-11-11',
                'next_run' => '2024-11-18',
                'created_by' => 'Recruiter',
                'created_date' => '2024-08-05',
                'status' => 'Active'
            ],
            [
                'report_id' => 4,
                'report_name' => 'Diversity Hiring Report',
                'description' => 'Diversity and inclusion metrics across hiring pipeline',
                'type' => 'Scheduled',
                'frequency' => 'Quarterly',
                'last_run' => '2024-10-01',
                'next_run' => '2025-01-01',
                'created_by' => 'Admin',
                'created_date' => '2024-05-10',
                'status' => 'Active'
            ],
            [
                'report_id' => 5,
                'report_name' => 'Cost Per Hire Analysis',
                'description' => 'Detailed cost breakdown by department and role',
                'type' => 'On-Demand',
                'frequency' => 'As Needed',
                'last_run' => '2024-11-05',
                'next_run' => null,
                'created_by' => 'Finance',
                'created_date' => '2024-09-01',
                'status' => 'Active'
            ]
        ];
    }

    public function get_report_templates()
    {
        return [
            [
                'template_id' => 1,
                'name' => 'Recruitment Funnel',
                'description' => 'Track candidates through each stage',
                'category' => 'Pipeline',
                'metrics' => ['Applications', 'Screenings', 'Interviews', 'Offers', 'Hires']
            ],
            [
                'template_id' => 2,
                'name' => 'Source Performance',
                'description' => 'Compare effectiveness of candidate sources',
                'category' => 'Sourcing',
                'metrics' => ['Applications', 'Quality Score', 'Conversion Rate', 'Cost']
            ],
            [
                'template_id' => 3,
                'name' => 'Hiring Manager Satisfaction',
                'description' => 'Survey results and feedback analysis',
                'category' => 'Quality',
                'metrics' => ['Satisfaction Score', 'Time to Fill', 'Quality of Hire']
            ],
            [
                'template_id' => 4,
                'name' => 'Department Hiring Trends',
                'description' => 'Hiring patterns by department',
                'category' => 'Trends',
                'metrics' => ['Headcount', 'Open Positions', 'Fill Rate', 'Turnover']
            ]
        ];
    }

    public function get_report_stats()
    {
        return [
            'total_reports' => 5,
            'active_reports' => 5,
            'scheduled_reports' => 3,
            'reports_run_this_month' => 12,
            'average_generation_time' => 3.2
        ];
    }

    public function get_available_metrics()
    {
        return [
            'Recruitment' => [
                'Total Applications',
                'Qualified Candidates',
                'Interviews Conducted',
                'Offers Made',
                'Offers Accepted',
                'Hires Made',
                'Rejection Rate'
            ],
            'Time Metrics' => [
                'Time to Fill',
                'Time to Hire',
                'Time in Stage',
                'Application Response Time',
                'Interview Scheduling Time'
            ],
            'Cost Metrics' => [
                'Cost Per Hire',
                'Cost Per Application',
                'Advertising Spend',
                'Agency Fees',
                'Total Recruitment Cost'
            ],
            'Quality Metrics' => [
                'Quality of Hire Score',
                'Candidate Satisfaction',
                'Hiring Manager Satisfaction',
                'First Year Retention',
                'Performance Rating'
            ],
            'Source Metrics' => [
                'Applications by Source',
                'Hires by Source',
                'Source Conversion Rate',
                'Source Cost Effectiveness'
            ]
        ];
    }

    public function get_available_dimensions()
    {
        return [
            'Time' => ['Day', 'Week', 'Month', 'Quarter', 'Year'],
            'Organization' => ['Department', 'Location', 'Division', 'Team'],
            'Position' => ['Job Title', 'Job Level', 'Job Category', 'Employment Type'],
            'Source' => ['Source Channel', 'Source Name', 'Campaign'],
            'Demographics' => ['Gender', 'Age Group', 'Education Level', 'Experience Level']
        ];
    }

    public function get_report($report_id)
    {
        $reports = $this->get_all_reports();
        foreach ($reports as $report) {
            if ($report['report_id'] == $report_id) {
                return $report;
            }
        }
        return null;
    }

    public function get_report_data($report_id)
    {
        // Sample data for report visualization
        return [
            'summary' => [
                'total_applications' => 1250,
                'qualified_candidates' => 380,
                'interviews' => 145,
                'offers' => 52,
                'hires' => 44
            ],
            'by_department' => [
                ['department' => 'Engineering', 'applications' => 450, 'hires' => 18],
                ['department' => 'Sales', 'applications' => 320, 'hires' => 12],
                ['department' => 'Marketing', 'applications' => 280, 'hires' => 8],
                ['department' => 'Operations', 'applications' => 200, 'hires' => 6]
            ],
            'by_source' => [
                ['source' => 'Job Boards', 'applications' => 450, 'hires' => 15],
                ['source' => 'Social Media', 'applications' => 380, 'hires' => 12],
                ['source' => 'Referrals', 'applications' => 120, 'hires' => 10],
                ['source' => 'Career Site', 'applications' => 300, 'hires' => 7]
            ]
        ];
    }

    public function get_scheduled_reports()
    {
        return array_filter($this->get_all_reports(), function($report) {
            return $report['type'] === 'Scheduled';
        });
    }
}
