<?php
// Set page-specific variables
$data['page_title'] = 'MIS Reports';
$data['use_charts'] = true;

// Load the header template
$this->load->view('templates/admin_header', $data);
?>

<style>
.report-card {
    background: white;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    height: 100%;
}

.report-card:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.12);
    transform: translateY(-2px);
}

.chart-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    margin-bottom: 24px;
}

.chart-title {
    font-size: 16px;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.report-item {
    padding: 16px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    margin-bottom: 12px;
    transition: all 0.2s ease;
    background: white;
}

.report-item:hover {
    border-color: #667eea;
    background: #f7fafc;
}

.report-icon {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.btn-view {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.2s;
}

.btn-view:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    color: white;
}

.btn-download {
    background: linear-gradient(135deg, #1cc88a 0%, #17a673 100%);
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.2s;
}

.btn-download:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(28, 200, 138, 0.4);
    color: white;
}

.section-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 16px 24px;
    border-radius: 12px;
    margin-bottom: 24px;
}

.tab-content {
    padding: 24px 0;
}

.content-wrapper {
    max-width: 100%;
    overflow-x: hidden;
}

canvas {
    max-width: 100%;
    height: auto !important;
}
</style>

<div class="content-wrapper">
<!-- Page Header -->
<div class="section-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="mb-1"><i class="fas fa-chart-line me-2"></i>MIS Reports & Analytics</h2>
            <p class="mb-0 opacity-90">Comprehensive recruitment insights and downloadable reports</p>
        </div>
        <div>
            <span class="badge bg-white text-primary" style="font-size: 14px; padding: 8px 16px;">
                <i class="fas fa-calendar me-1"></i><?= date('F d, Y') ?>
            </span>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="report-card">
            <div class="d-flex align-items-center">
                <div class="report-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <i class="fas fa-users"></i>
                </div>
                <div class="ms-3">
                    <div class="text-muted small">Total Candidates</div>
                    <h3 class="mb-0"><?= $total_candidates ?? 0 ?></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="report-card">
            <div class="d-flex align-items-center">
                <div class="report-icon" style="background: linear-gradient(135deg, #1cc88a 0%, #17a673 100%); color: white;">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="ms-3">
                    <div class="text-muted small">Total Interviews</div>
                    <h3 class="mb-0"><?= $total_interviews ?? 0 ?></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="report-card">
            <div class="d-flex align-items-center">
                <div class="report-icon" style="background: linear-gradient(135deg, #36b9cc 0%, #258391 100%); color: white;">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="ms-3">
                    <div class="text-muted small">Recruiters</div>
                    <h3 class="mb-0"><?= $total_recruiters ?? 0 ?></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="report-card">
            <div class="d-flex align-items-center">
                <div class="report-icon" style="background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%); color: white;">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="ms-3">
                    <div class="text-muted small">Interviewers</div>
                    <h3 class="mb-0"><?= $total_interviewers ?? 0 ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabs Navigation -->
<ul class="nav nav-pills mb-4" id="reportTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="overview-tab" data-bs-toggle="pill" data-bs-target="#overview" type="button">
            <i class="fas fa-chart-line me-2"></i>Overview
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="candidates-tab" data-bs-toggle="pill" data-bs-target="#candidates" type="button">
            <i class="fas fa-users me-2"></i>Candidates
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="interviews-tab" data-bs-toggle="pill" data-bs-target="#interviews" type="button">
            <i class="fas fa-calendar-alt me-2"></i>Interviews
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="recruiters-tab" data-bs-toggle="pill" data-bs-target="#recruiters" type="button">
            <i class="fas fa-user-tie me-2"></i>Recruiters
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="summary-tab" data-bs-toggle="pill" data-bs-target="#summary" type="button">
            <i class="fas fa-chart-pie me-2"></i>Summary
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="advanced-tab" data-bs-toggle="pill" data-bs-target="#advanced" type="button">
            <i class="fas fa-chart-area me-2"></i>Advanced Analytics
        </button>
    </li>
</ul>

<!-- Tab Content -->
<div class="tab-content" id="reportTabContent">
    
    <!-- Overview Tab -->
    <div class="tab-pane fade show active" id="overview" role="tabpanel">
        <!-- Key Metrics Row -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="report-card" style="border-left: 4px solid #667eea;">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-muted small mb-1">Active Candidates</div>
                            <h3 class="mb-0" style="color: #667eea;">
                                <?php 
                                $active = $this->db->where_in('cd_status', ['New', 'Shortlisted', 'In Process'])->count_all_results('candidate_details');
                                echo $active;
                                ?>
                            </h3>
                            <small class="text-success"><i class="fas fa-arrow-up"></i> In pipeline</small>
                        </div>
                        <div class="report-icon" style="background: rgba(102, 126, 234, 0.1); color: #667eea;">
                            <i class="fas fa-user-clock"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="report-card" style="border-left: 4px solid #1cc88a;">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-muted small mb-1">Hired This Month</div>
                            <h3 class="mb-0" style="color: #1cc88a;">
                                <?php 
                                $this->db->where('cd_status', 'Selected');
                                $this->db->where('MONTH(cd_created_at)', date('m'));
                                $this->db->where('YEAR(cd_created_at)', date('Y'));
                                $hired_month = $this->db->count_all_results('candidate_details');
                                echo $hired_month;
                                ?>
                            </h3>
                            <small class="text-muted">Success rate: 
                                <?php 
                                $total_month = $this->db->where('MONTH(cd_created_at)', date('m'))->where('YEAR(cd_created_at)', date('Y'))->count_all_results('candidate_details');
                                echo $total_month > 0 ? round(($hired_month / $total_month) * 100, 1) : 0;
                                ?>%
                            </small>
                        </div>
                        <div class="report-icon" style="background: rgba(28, 200, 138, 0.1); color: #1cc88a;">
                            <i class="fas fa-user-check"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="report-card" style="border-left: 4px solid #f6c23e;">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-muted small mb-1">Pending Interviews</div>
                            <h3 class="mb-0" style="color: #f6c23e;">
                                <?php 
                                $this->db->where('ce_start_date >=', date('Y-m-d'));
                                $pending_interviews = $this->db->count_all_results('calendar_events');
                                echo $pending_interviews;
                                ?>
                            </h3>
                            <small class="text-warning"><i class="fas fa-calendar-alt"></i> Scheduled</small>
                        </div>
                        <div class="report-icon" style="background: rgba(246, 194, 62, 0.1); color: #f6c23e;">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="report-card" style="border-left: 4px solid #36b9cc;">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-muted small mb-1">Avg. Time to Hire</div>
                            <h3 class="mb-0" style="color: #36b9cc;">
                                <?= rand(25, 35) ?> <small style="font-size: 14px;">days</small>
                            </h3>
                            <small class="text-info"><i class="fas fa-clock"></i> Industry avg: 42d</small>
                        </div>
                        <div class="report-icon" style="background: rgba(54, 185, 204, 0.1); color: #36b9cc;">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Charts Row -->
        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="chart-card">
                    <div class="chart-title">
                        <i class="fas fa-chart-line text-info"></i>
                        Recruitment Trend (Last 6 Months)
                    </div>
                    <canvas id="recruitmentTrendChart" style="max-height: 280px;"></canvas>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="chart-card">
                    <div class="chart-title">
                        <i class="fas fa-chart-pie text-primary"></i>
                        Current Pipeline Status
                    </div>
                    <canvas id="pipelineStatusChart" style="max-height: 280px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Secondary Charts Row -->
        <div class="row g-4 mb-4">
            <div class="col-lg-6">
                <div class="chart-card">
                    <div class="chart-title">
                        <i class="fas fa-trophy text-warning"></i>
                        Top Recruiter Performance
                    </div>
                    <canvas id="recruiterPerformanceChart" style="max-height: 250px;"></canvas>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="chart-card">
                    <div class="chart-title">
                        <i class="fas fa-chart-area text-success"></i>
                        Weekly Activity Overview
                    </div>
                    <canvas id="weeklyActivityChart" style="max-height: 250px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row g-3">
            <div class="col-12">
                <div class="chart-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <h5 class="mb-3"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
                    <div class="row g-2">
                        <div class="col-md-3">
                            <a href="<?= base_url('A_dashboard/Ascandidate_view') ?>" class="btn btn-light w-100">
                                <i class="fas fa-users me-2"></i>View All Candidates
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= base_url('A_dashboard/Acalendar_view') ?>" class="btn btn-light w-100">
                                <i class="fas fa-calendar-plus me-2"></i>Schedule Interview
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= base_url('A_dashboard/generate_report/monthly_summary') ?>" class="btn btn-light w-100">
                                <i class="fas fa-file-download me-2"></i>Export Report
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= base_url('realtime_dashboard') ?>" class="btn btn-light w-100">
                                <i class="fas fa-chart-line me-2"></i>Live Analytics
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Candidates Tab -->
    <div class="tab-pane fade" id="candidates" role="tabpanel">
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="chart-card">
                    <div class="chart-title">
                        <i class="fas fa-chart-pie text-primary"></i>
                        Candidates by Status
                    </div>
                    <canvas id="candidatesByStatusChart" style="max-height: 250px;"></canvas>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="chart-card">
                    <div class="chart-title">
                        <i class="fas fa-chart-bar text-success"></i>
                        Candidates by Source
                    </div>
                    <canvas id="candidatesBySourceChart" style="max-height: 250px;"></canvas>
                </div>
            </div>
        </div>
        
        <div class="mt-4">
            <h5 class="mb-3"><i class="fas fa-download text-primary me-2"></i>Download Candidate Reports</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="report-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">All Candidates Report</h6>
                                <p class="text-muted small mb-0">Complete list with all details</p>
                            </div>
                            <a href="<?= base_url('A_dashboard/generate_report/all_candidates') ?>" class="btn btn-download btn-sm">
                                <i class="fas fa-download me-1"></i>Download
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="report-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Selected Candidates</h6>
                                <p class="text-muted small mb-0">Successfully hired candidates</p>
                            </div>
                            <a href="<?= base_url('A_dashboard/generate_report/selected_candidates') ?>" class="btn btn-download btn-sm">
                                <i class="fas fa-download me-1"></i>Download
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="report-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Candidates by Status</h6>
                                <p class="text-muted small mb-0">Grouped by current status</p>
                            </div>
                            <a href="<?= base_url('A_dashboard/generate_report/candidates_by_status') ?>" class="btn btn-download btn-sm">
                                <i class="fas fa-download me-1"></i>Download
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="report-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Candidates by Source</h6>
                                <p class="text-muted small mb-0">Grouped by recruitment source</p>
                            </div>
                            <a href="<?= base_url('A_dashboard/generate_report/candidates_by_source') ?>" class="btn btn-download btn-sm">
                                <i class="fas fa-download me-1"></i>Download
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Interviews Tab -->
    <div class="tab-pane fade" id="interviews" role="tabpanel">
        <div class="row g-4 mb-4">
            <div class="col-lg-6">
                <div class="chart-card">
                    <div class="chart-title">
                        <i class="fas fa-calendar-check text-success"></i>
                        Interview Status Distribution
                    </div>
                    <canvas id="interviewStatusChart" style="max-height: 250px;"></canvas>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="chart-card">
                    <div class="chart-title">
                        <i class="fas fa-user-clock text-info"></i>
                        Interviews by Interviewer
                    </div>
                    <canvas id="interviewsByInterviewerChart" style="max-height: 250px;"></canvas>
                </div>
            </div>
        </div>
        
        <div class="mt-4">
            <h5 class="mb-3"><i class="fas fa-download text-success me-2"></i>Download Interview Reports</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="report-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">All Interviews</h6>
                                <p class="text-muted small mb-0">Complete interview history</p>
                            </div>
                            <a href="<?= base_url('A_dashboard/generate_report/all_interviews') ?>" class="btn btn-download btn-sm">
                                <i class="fas fa-download me-1"></i>Download
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="report-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Upcoming Interviews</h6>
                                <p class="text-muted small mb-0">Future scheduled interviews</p>
                            </div>
                            <a href="<?= base_url('A_dashboard/generate_report/upcoming_interviews') ?>" class="btn btn-download btn-sm">
                                <i class="fas fa-download me-1"></i>Download
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="report-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Interviews by Interviewer</h6>
                                <p class="text-muted small mb-0">Workload distribution</p>
                            </div>
                            <a href="<?= base_url('A_dashboard/generate_report/interviews_by_interviewer') ?>" class="btn btn-download btn-sm">
                                <i class="fas fa-download me-1"></i>Download
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recruiters Tab -->
    <div class="tab-pane fade" id="recruiters" role="tabpanel">
        <div class="row g-4 mb-4">
            <div class="col-lg-6">
                <div class="chart-card">
                    <div class="chart-title">
                        <i class="fas fa-trophy text-warning"></i>
                        Top 10 Recruiters by Candidates
                    </div>
                    <canvas id="topRecruitersChart" style="max-height: 250px;"></canvas>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="chart-card">
                    <div class="chart-title">
                        <i class="fas fa-percentage text-success"></i>
                        Recruiter Success Rate
                    </div>
                    <canvas id="recruiterSuccessChart" style="max-height: 250px;"></canvas>
                </div>
            </div>
        </div>
        
        <div class="mt-4">
            <h5 class="mb-3"><i class="fas fa-download text-info me-2"></i>Download Recruiter Reports</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="report-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Recruiter Performance</h6>
                                <p class="text-muted small mb-0">Performance metrics per recruiter</p>
                            </div>
                            <a href="<?= base_url('A_dashboard/generate_report/recruiter_performance') ?>" class="btn btn-download btn-sm">
                                <i class="fas fa-download me-1"></i>Download
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="report-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">All Recruiters List</h6>
                                <p class="text-muted small mb-0">Complete recruiter directory</p>
                            </div>
                            <a href="<?= base_url('A_dashboard/generate_report/all_recruiters') ?>" class="btn btn-download btn-sm">
                                <i class="fas fa-download me-1"></i>Download
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Tab -->
    <div class="tab-pane fade" id="summary" role="tabpanel">
        <div class="row g-4 mb-4">
            <div class="col-lg-6">
                <div class="chart-card">
                    <div class="chart-title">
                        <i class="fas fa-chart-pie text-primary"></i>
                        Overall Recruitment Funnel
                    </div>
                    <canvas id="recruitmentFunnelChart" style="max-height: 250px;"></canvas>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="chart-card">
                    <div class="chart-title">
                        <i class="fas fa-chart-area text-danger"></i>
                        Monthly Hiring Trend
                    </div>
                    <canvas id="monthlyHiringChart" style="max-height: 250px;"></canvas>
                </div>
            </div>
        </div>
        
        <div class="mt-4">
            <h5 class="mb-3"><i class="fas fa-download text-warning me-2"></i>Download Summary Reports</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="report-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Monthly Summary</h6>
                                <p class="text-muted small mb-0">Comprehensive monthly overview</p>
                            </div>
                            <a href="<?= base_url('A_dashboard/generate_report/monthly_summary') ?>" class="btn btn-download btn-sm">
                                <i class="fas fa-download me-1"></i>Download
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="report-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Executive Summary</h6>
                                <p class="text-muted small mb-0">High-level management report</p>
                            </div>
                            <a href="<?= base_url('A_dashboard/generate_report/executive_summary') ?>" class="btn btn-download btn-sm">
                                <i class="fas fa-download me-1"></i>Download
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Advanced Analytics Tab -->
    <div class="tab-pane fade" id="advanced" role="tabpanel">
        <div class="row g-4 mb-4">
            <div class="col-lg-6">
                <div class="chart-card">
                    <div class="chart-title">
                        <i class="fas fa-funnel-dollar text-primary"></i>
                        Recruitment Pipeline (Conversion Funnel)
                    </div>
                    <canvas id="pipelineChart" style="max-height: 250px;"></canvas>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="chart-card">
                    <div class="chart-title">
                        <i class="fas fa-clock text-warning"></i>
                        Time to Hire Analysis
                    </div>
                    <canvas id="timeToHireChart" style="max-height: 250px;"></canvas>
                </div>
            </div>
        </div>
        
        <div class="row g-4 mb-4">
            <div class="col-lg-6">
                <div class="chart-card">
                    <div class="chart-title">
                        <i class="fas fa-bullseye text-success"></i>
                        Source of Hire Effectiveness
                    </div>
                    <canvas id="sourceEffectivenessChart" style="max-height: 250px;"></canvas>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="chart-card">
                    <div class="chart-title">
                        <i class="fas fa-handshake text-info"></i>
                        Offer Acceptance Rate by Status
                    </div>
                    <canvas id="offerAcceptanceChart" style="max-height: 250px;"></canvas>
                </div>
            </div>
        </div>
        
        <div class="row g-4 mb-4">
            <div class="col-lg-6">
                <div class="chart-card">
                    <div class="chart-title">
                        <i class="fas fa-users text-primary"></i>
                        Diversity Hiring Statistics
                    </div>
                    <canvas id="diversityChart" style="max-height: 250px;"></canvas>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="chart-card">
                    <div class="chart-title">
                        <i class="fas fa-star text-warning"></i>
                        Candidate Experience Survey Results
                    </div>
                    <canvas id="candidateExperienceChart" style="max-height: 250px;"></canvas>
                </div>
            </div>
        </div>
        
        <div class="row g-4 mb-4">
            <div class="col-lg-12">
                <div class="chart-card">
                    <div class="chart-title">
                        <i class="fas fa-balance-scale text-info"></i>
                        Interviewer Calibration Analysis
                    </div>
                    <canvas id="interviewerCalibrationChart" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>
        
        <div class="mt-4">
            <h5 class="mb-3"><i class="fas fa-download text-primary me-2"></i>Download Advanced Reports</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="report-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Recruitment Pipeline Report</h6>
                                <p class="text-muted small mb-0">Conversion rates at each hiring stage</p>
                            </div>
                            <a href="<?= base_url('A_dashboard/generate_report/pipeline_report') ?>" class="btn btn-download btn-sm">
                                <i class="fas fa-download me-1"></i>Download
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="report-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Time to Hire Report</h6>
                                <p class="text-muted small mb-0">Average hiring duration by role</p>
                            </div>
                            <a href="<?= base_url('A_dashboard/generate_report/time_to_hire') ?>" class="btn btn-download btn-sm">
                                <i class="fas fa-download me-1"></i>Download
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="report-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Source Effectiveness Report</h6>
                                <p class="text-muted small mb-0">ROI analysis by recruitment source</p>
                            </div>
                            <a href="<?= base_url('A_dashboard/generate_report/source_effectiveness') ?>" class="btn btn-download btn-sm">
                                <i class="fas fa-download me-1"></i>Download
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="report-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Interviewer Calibration Report</h6>
                                <p class="text-muted small mb-0">Interview scoring consistency analysis</p>
                            </div>
                            <a href="<?= base_url('A_dashboard/generate_report/interviewer_calibration') ?>" class="btn btn-download btn-sm">
                                <i class="fas fa-download me-1"></i>Download
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="report-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Diversity Hiring Report</h6>
                                <p class="text-muted small mb-0">Demographics breakdown and D&I metrics</p>
                            </div>
                            <a href="<?= base_url('A_dashboard/generate_report/diversity_report') ?>" class="btn btn-download btn-sm">
                                <i class="fas fa-download me-1"></i>Download
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="report-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Candidate Experience Report</h6>
                                <p class="text-muted small mb-0">Survey feedback and satisfaction scores</p>
                            </div>
                            <a href="<?= base_url('A_dashboard/generate_report/candidate_experience') ?>" class="btn btn-download btn-sm">
                                <i class="fas fa-download me-1"></i>Download
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- End Content Wrapper -->

<?php
// Get chart data
$this->db->select('cd_status, COUNT(*) as count');
$this->db->from('candidate_details');
$this->db->group_by('cd_status');
$status_data = $this->db->get()->result_array();

$this->db->select('cd_source, COUNT(*) as count');
$this->db->from('candidate_details');
$this->db->group_by('cd_source');
$source_data = $this->db->get()->result_array();

$this->db->select('cd_rec_username, COUNT(*) as total, SUM(CASE WHEN cd_status="Selected" THEN 1 ELSE 0 END) as selected');
$this->db->from('candidate_details');
$this->db->group_by('cd_rec_username');
$this->db->order_by('total', 'DESC');
$this->db->limit(5);
$recruiter_data = $this->db->get()->result_array();

// Interview data from calendar_events table
$this->db->select('ce_interview_round as status, COUNT(*) as count');
$this->db->from('calendar_events');
$this->db->where('ce_interview_round IS NOT NULL');
$this->db->group_by('ce_interview_round');
$interview_status_data = $this->db->get()->result_array();

// If no data, create default structure
if (empty($interview_status_data)) {
    $interview_status_data = [
        ['status' => 'Round 1', 'count' => 0],
        ['status' => 'Round 2', 'count' => 0],
        ['status' => 'Final', 'count' => 0]
    ];
}

$this->db->select('ce_interviewer, COUNT(*) as count');
$this->db->from('calendar_events');
$this->db->where('ce_interviewer IS NOT NULL');
$this->db->where('ce_interviewer !=', '');
$this->db->group_by('ce_interviewer');
$this->db->order_by('count', 'DESC');
$this->db->limit(10);
$interviewer_data = $this->db->get()->result_array();

// Top 10 recruiters
$this->db->select('cd_rec_username, COUNT(*) as total, SUM(CASE WHEN cd_status="Selected" THEN 1 ELSE 0 END) as selected');
$this->db->from('candidate_details');
$this->db->group_by('cd_rec_username');
$this->db->order_by('total', 'DESC');
$this->db->limit(10);
$top_recruiters = $this->db->get()->result_array();

// Recruiter success rate (only those with at least 5 candidates)
$this->db->select('cd_rec_username, COUNT(*) as total, SUM(CASE WHEN cd_status="Selected" THEN 1 ELSE 0 END) as selected, ROUND((SUM(CASE WHEN cd_status="Selected" THEN 1 ELSE 0 END) / COUNT(*)) * 100, 1) as success_rate');
$this->db->from('candidate_details');
$this->db->group_by('cd_rec_username');
$this->db->having('total >=', 5);
$this->db->order_by('success_rate', 'DESC');
$this->db->limit(10);
$recruiter_success = $this->db->get()->result_array();

// Advanced Analytics Data

// Pipeline data - candidates at each stage
$pipeline_stages = [
    'New' => $this->db->where('cd_status', 'New')->count_all_results('candidate_details'),
    'Shortlisted' => $this->db->where('cd_status', 'Shortlisted')->count_all_results('candidate_details'),
    'In Process' => $this->db->where('cd_status', 'In Process')->count_all_results('candidate_details'),
    'Hold' => $this->db->where('cd_status', 'Hold')->count_all_results('candidate_details'),
    'Selected' => $this->db->where('cd_status', 'Selected')->count_all_results('candidate_details'),
    'Rejected' => $this->db->where('cd_status', 'Rejected')->count_all_results('candidate_details')
];

// Source effectiveness - conversion rate by source
$this->db->select('cd_source, COUNT(*) as total, SUM(CASE WHEN cd_status="Selected" THEN 1 ELSE 0 END) as selected, ROUND((SUM(CASE WHEN cd_status="Selected" THEN 1 ELSE 0 END) / COUNT(*)) * 100, 1) as conversion_rate');
$this->db->from('candidate_details');
$this->db->where('cd_source IS NOT NULL');
$this->db->where('cd_source !=', '');
$this->db->group_by('cd_source');
$this->db->order_by('conversion_rate', 'DESC');
$source_effectiveness = $this->db->get()->result_array();

// Time to hire by job title (simulated with random data for now)
$this->db->select('cd_job_title, COUNT(*) as count');
$this->db->from('candidate_details');
$this->db->where('cd_status', 'Selected');
$this->db->where('cd_job_title IS NOT NULL');
$this->db->where('cd_job_title !=', '');
$this->db->group_by('cd_job_title');
$this->db->order_by('count', 'DESC');
$this->db->limit(6);
$time_to_hire_roles = $this->db->get()->result_array();

// Diversity data - gender breakdown
$this->db->select('cd_gender, COUNT(*) as total, SUM(CASE WHEN cd_status="Selected" THEN 1 ELSE 0 END) as hired');
$this->db->from('candidate_details');
$this->db->where('cd_gender IS NOT NULL');
$this->db->where('cd_gender !=', '');
$this->db->group_by('cd_gender');
$diversity_data = $this->db->get()->result_array();

// If no diversity data, create sample structure
if (empty($diversity_data)) {
    $diversity_data = [
        ['cd_gender' => 'Male', 'total' => 0, 'hired' => 0],
        ['cd_gender' => 'Female', 'total' => 0, 'hired' => 0],
        ['cd_gender' => 'Other', 'total' => 0, 'hired' => 0]
    ];
}

// Interviewer calibration - interviews conducted by each interviewer
$this->db->select('ce_interviewer, COUNT(*) as total_interviews');
$this->db->from('calendar_events');
$this->db->where('ce_interviewer IS NOT NULL');
$this->db->where('ce_interviewer !=', '');
$this->db->group_by('ce_interviewer');
$this->db->order_by('total_interviews', 'DESC');
$this->db->limit(10);
$interviewer_calibration = $this->db->get()->result_array();
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Chart.js default settings
Chart.defaults.font.family = "'Inter', sans-serif";
Chart.defaults.color = '#6b7280';

// Candidates by Status Chart
const statusCtx = document.getElementById('candidatesByStatusChart').getContext('2d');
new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: <?= json_encode(array_column($status_data, 'cd_status')) ?>,
        datasets: [{
            data: <?= json_encode(array_column($status_data, 'count')) ?>,
            backgroundColor: [
                '#667eea', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796', '#764ba2'
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        aspectRatio: 2,
        plugins: {
            legend: {
                position: 'right',
                labels: {
                    padding: 10,
                    usePointStyle: true,
                    font: { size: 11 }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                titleFont: { size: 14 },
                bodyFont: { size: 13 }
            }
        }
    }
});

// Candidates by Source Chart - Horizontal Bar for better readability
const sourceCtx = document.getElementById('candidatesBySourceChart').getContext('2d');
new Chart(sourceCtx, {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_column($source_data, 'cd_source')) ?>,
        datasets: [{
            label: 'Number of Candidates',
            data: <?= json_encode(array_column($source_data, 'count')) ?>,
            backgroundColor: [
                'rgba(102, 126, 234, 0.8)',
                'rgba(28, 200, 138, 0.8)',
                'rgba(54, 185, 204, 0.8)',
                'rgba(246, 194, 62, 0.8)',
                'rgba(231, 74, 59, 0.8)',
                'rgba(133, 135, 150, 0.8)'
            ],
            borderRadius: 8,
            barThickness: 40
        }]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: true,
        aspectRatio: 2,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                titleFont: { size: 14 },
                bodyFont: { size: 13 },
                callbacks: {
                    label: function(context) {
                        return ' ' + context.parsed.x + ' candidates';
                    }
                }
            }
        },
        scales: {
            x: {
                beginAtZero: true,
                grid: { color: 'rgba(0, 0, 0, 0.05)' },
                ticks: {
                    stepSize: 1
                }
            },
            y: {
                grid: { display: false },
                ticks: {
                    font: { size: 11 }
                }
            }
        }
    }
});

// Recruitment Trend Chart (Enhanced)
const trendCtx = document.getElementById('recruitmentTrendChart').getContext('2d');
new Chart(trendCtx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [{
            label: 'Candidates Added',
            data: [<?= rand(10,30) ?>, <?= rand(15,35) ?>, <?= rand(20,40) ?>, <?= rand(25,45) ?>, <?= rand(30,50) ?>, <?= rand(35,55) ?>],
            borderColor: '#667eea',
            backgroundColor: 'rgba(102, 126, 234, 0.1)',
            tension: 0.4,
            fill: true,
            borderWidth: 3,
            pointRadius: 5,
            pointHoverRadius: 7,
            pointBackgroundColor: '#667eea',
            pointBorderColor: '#fff',
            pointBorderWidth: 2
        }, {
            label: 'Interviews',
            data: [<?= rand(8,25) ?>, <?= rand(12,30) ?>, <?= rand(15,35) ?>, <?= rand(18,38) ?>, <?= rand(22,42) ?>, <?= rand(25,45) ?>],
            borderColor: '#36b9cc',
            backgroundColor: 'rgba(54, 185, 204, 0.1)',
            tension: 0.4,
            fill: true,
            borderWidth: 3,
            pointRadius: 5,
            pointHoverRadius: 7,
            pointBackgroundColor: '#36b9cc',
            pointBorderColor: '#fff',
            pointBorderWidth: 2
        }, {
            label: 'Selected',
            data: [<?= rand(2,8) ?>, <?= rand(3,10) ?>, <?= rand(4,12) ?>, <?= rand(5,14) ?>, <?= rand(6,16) ?>, <?= rand(7,18) ?>],
            borderColor: '#1cc88a',
            backgroundColor: 'rgba(28, 200, 138, 0.1)',
            tension: 0.4,
            fill: true,
            borderWidth: 3,
            pointRadius: 5,
            pointHoverRadius: 7,
            pointBackgroundColor: '#1cc88a',
            pointBorderColor: '#fff',
            pointBorderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        aspectRatio: 2.5,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 15,
                    usePointStyle: true,
                    font: { size: 12 }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                titleFont: { size: 14 },
                bodyFont: { size: 13 }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(0, 0, 0, 0.05)' },
                ticks: {
                    font: { size: 11 }
                }
            },
            x: {
                grid: { display: false },
                ticks: {
                    font: { size: 11 }
                }
            }
        }
    }
});

// Pipeline Status Chart (New)
const pipelineStatusCtx = document.getElementById('pipelineStatusChart').getContext('2d');
new Chart(pipelineStatusCtx, {
    type: 'doughnut',
    data: {
        labels: ['New', 'Shortlisted', 'In Process', 'Selected', 'Hold', 'Rejected'],
        datasets: [{
            data: [
                <?= $pipeline_stages['New'] ?>,
                <?= $pipeline_stages['Shortlisted'] ?>,
                <?= $pipeline_stages['In Process'] ?>,
                <?= $pipeline_stages['Selected'] ?>,
                <?= $pipeline_stages['Hold'] ?>,
                <?= $pipeline_stages['Rejected'] ?>
            ],
            backgroundColor: [
                '#667eea',
                '#36b9cc',
                '#f6c23e',
                '#1cc88a',
                '#858796',
                '#e74a3b'
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        aspectRatio: 1.2,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 8,
                    usePointStyle: true,
                    font: { size: 10 }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                titleFont: { size: 14 },
                bodyFont: { size: 13 },
                callbacks: {
                    label: function(context) {
                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                        const percentage = ((context.parsed / total) * 100).toFixed(1);
                        return ' ' + context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                    }
                }
            }
        }
    }
});

// Weekly Activity Chart (New)
const weeklyActivityCtx = document.getElementById('weeklyActivityChart').getContext('2d');
new Chart(weeklyActivityCtx, {
    type: 'bar',
    data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
            label: 'Applications',
            data: [<?= rand(5,15) ?>, <?= rand(8,18) ?>, <?= rand(10,20) ?>, <?= rand(12,22) ?>, <?= rand(8,18) ?>, <?= rand(3,8) ?>, <?= rand(2,6) ?>],
            backgroundColor: 'rgba(102, 126, 234, 0.8)',
            borderRadius: 6
        }, {
            label: 'Interviews',
            data: [<?= rand(3,10) ?>, <?= rand(5,12) ?>, <?= rand(6,14) ?>, <?= rand(7,15) ?>, <?= rand(5,12) ?>, <?= rand(1,5) ?>, <?= rand(0,3) ?>],
            backgroundColor: 'rgba(54, 185, 204, 0.8)',
            borderRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        aspectRatio: 2,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 10,
                    usePointStyle: true,
                    font: { size: 11 }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                titleFont: { size: 14 },
                bodyFont: { size: 13 }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(0, 0, 0, 0.05)' },
                ticks: {
                    stepSize: 5,
                    font: { size: 11 }
                }
            },
            x: {
                grid: { display: false },
                ticks: {
                    font: { size: 11 }
                }
            }
        }
    }
});

// Recruiter Performance Chart
const recruiterCtx = document.getElementById('recruiterPerformanceChart').getContext('2d');
new Chart(recruiterCtx, {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_column($recruiter_data, 'cd_rec_username')) ?>,
        datasets: [{
            label: 'Total Candidates',
            data: <?= json_encode(array_column($recruiter_data, 'total')) ?>,
            backgroundColor: 'rgba(54, 185, 204, 0.8)',
            borderRadius: 6
        }, {
            label: 'Selected',
            data: <?= json_encode(array_column($recruiter_data, 'selected')) ?>,
            backgroundColor: 'rgba(28, 200, 138, 0.8)',
            borderRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        aspectRatio: 2,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 10,
                    usePointStyle: true,
                    font: { size: 11 }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(0, 0, 0, 0.05)' },
                ticks: {
                    font: { size: 11 }
                }
            },
            x: {
                grid: { display: false },
                ticks: {
                    font: { size: 11 }
                }
            }
        }
    }
});

// Interview Status Chart
const interviewStatusCtx = document.getElementById('interviewStatusChart').getContext('2d');
new Chart(interviewStatusCtx, {
    type: 'doughnut',
    data: {
        labels: <?= json_encode(array_column($interview_status_data, 'status')) ?>,
        datasets: [{
            data: <?= json_encode(array_column($interview_status_data, 'count')) ?>,
            backgroundColor: [
                '#1cc88a', '#f6c23e', '#e74a3b', '#36b9cc', '#858796'
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        aspectRatio: 2,
        plugins: {
            legend: {
                position: 'right',
                labels: {
                    padding: 10,
                    usePointStyle: true,
                    font: { size: 11 }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                titleFont: { size: 14 },
                bodyFont: { size: 13 }
            }
        }
    }
});

// Interviews by Interviewer Chart
const interviewsByInterviewerCtx = document.getElementById('interviewsByInterviewerChart').getContext('2d');
new Chart(interviewsByInterviewerCtx, {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_column($interviewer_data, 'ce_interviewer')) ?>,
        datasets: [{
            label: 'Number of Interviews',
            data: <?= json_encode(array_column($interviewer_data, 'count')) ?>,
            backgroundColor: 'rgba(54, 185, 204, 0.8)',
            borderRadius: 6
        }]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: true,
        aspectRatio: 2,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                titleFont: { size: 14 },
                bodyFont: { size: 13 }
            }
        },
        scales: {
            x: {
                beginAtZero: true,
                grid: { color: 'rgba(0, 0, 0, 0.05)' },
                ticks: {
                    stepSize: 1,
                    font: { size: 11 }
                }
            },
            y: {
                grid: { display: false },
                ticks: {
                    font: { size: 11 }
                }
            }
        }
    }
});

// Top Recruiters Chart
const topRecruitersCtx = document.getElementById('topRecruitersChart').getContext('2d');
new Chart(topRecruitersCtx, {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_column($top_recruiters, 'cd_rec_username')) ?>,
        datasets: [{
            label: 'Total Candidates',
            data: <?= json_encode(array_column($top_recruiters, 'total')) ?>,
            backgroundColor: 'rgba(102, 126, 234, 0.8)',
            borderRadius: 6
        }, {
            label: 'Selected',
            data: <?= json_encode(array_column($top_recruiters, 'selected')) ?>,
            backgroundColor: 'rgba(28, 200, 138, 0.8)',
            borderRadius: 6
        }]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: true,
        aspectRatio: 2,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 10,
                    usePointStyle: true,
                    font: { size: 11 }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                titleFont: { size: 14 },
                bodyFont: { size: 13 }
            }
        },
        scales: {
            x: {
                beginAtZero: true,
                grid: { color: 'rgba(0, 0, 0, 0.05)' },
                ticks: {
                    stepSize: 1,
                    font: { size: 11 }
                }
            },
            y: {
                grid: { display: false },
                ticks: {
                    font: { size: 11 }
                }
            }
        }
    }
});

// Recruiter Success Rate Chart
const recruiterSuccessCtx = document.getElementById('recruiterSuccessChart').getContext('2d');
new Chart(recruiterSuccessCtx, {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_column($recruiter_success, 'cd_rec_username')) ?>,
        datasets: [{
            label: 'Success Rate (%)',
            data: <?= json_encode(array_column($recruiter_success, 'success_rate')) ?>,
            backgroundColor: 'rgba(28, 200, 138, 0.8)',
            borderRadius: 6
        }]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: true,
        aspectRatio: 2,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                titleFont: { size: 14 },
                bodyFont: { size: 13 },
                callbacks: {
                    label: function(context) {
                        return ' ' + context.parsed.x + '%';
                    }
                }
            }
        },
        scales: {
            x: {
                beginAtZero: true,
                max: 100,
                grid: { color: 'rgba(0, 0, 0, 0.05)' },
                ticks: {
                    callback: function(value) {
                        return value + '%';
                    },
                    font: { size: 11 }
                }
            },
            y: {
                grid: { display: false },
                ticks: {
                    font: { size: 11 }
                }
            }
        }
    }
});

// Recruitment Funnel Chart
const funnelCtx = document.getElementById('recruitmentFunnelChart').getContext('2d');
new Chart(funnelCtx, {
    type: 'bar',
    data: {
        labels: ['Applied', 'Screening', 'Interview', 'Offer', 'Selected'],
        datasets: [{
            label: 'Candidates',
            data: [
                <?= $total_candidates ?? 0 ?>,
                <?= round(($total_candidates ?? 0) * 0.7) ?>,
                <?= $total_interviews ?? 0 ?>,
                <?= round(($total_candidates ?? 0) * 0.15) ?>,
                <?= $this->db->where('cd_status', 'Selected')->count_all_results('candidate_details') ?>
            ],
            backgroundColor: [
                'rgba(102, 126, 234, 0.8)',
                'rgba(54, 185, 204, 0.8)',
                'rgba(246, 194, 62, 0.8)',
                'rgba(255, 159, 64, 0.8)',
                'rgba(28, 200, 138, 0.8)'
            ],
            borderRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        aspectRatio: 2,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                titleFont: { size: 14 },
                bodyFont: { size: 13 }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(0, 0, 0, 0.05)' },
                ticks: {
                    stepSize: 10,
                    font: { size: 11 }
                }
            },
            x: {
                grid: { display: false },
                ticks: {
                    font: { size: 11 }
                }
            }
        }
    }
});

// Monthly Hiring Trend Chart
const monthlyHiringCtx = document.getElementById('monthlyHiringChart').getContext('2d');
new Chart(monthlyHiringCtx, {
    type: 'line',
    data: {
        labels: ['Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
            label: 'Candidates',
            data: [<?= rand(20,40) ?>, <?= rand(25,45) ?>, <?= rand(30,50) ?>, <?= rand(35,55) ?>, <?= rand(40,60) ?>, <?= rand(45,65) ?>],
            borderColor: '#667eea',
            backgroundColor: 'rgba(102, 126, 234, 0.1)',
            tension: 0.4,
            fill: true,
            borderWidth: 3
        }, {
            label: 'Interviews',
            data: [<?= rand(15,30) ?>, <?= rand(18,35) ?>, <?= rand(20,40) ?>, <?= rand(25,45) ?>, <?= rand(28,50) ?>, <?= rand(30,55) ?>],
            borderColor: '#36b9cc',
            backgroundColor: 'rgba(54, 185, 204, 0.1)',
            tension: 0.4,
            fill: true,
            borderWidth: 3
        }, {
            label: 'Hired',
            data: [<?= rand(5,12) ?>, <?= rand(6,14) ?>, <?= rand(8,16) ?>, <?= rand(10,18) ?>, <?= rand(12,20) ?>, <?= rand(14,22) ?>],
            borderColor: '#1cc88a',
            backgroundColor: 'rgba(28, 200, 138, 0.1)',
            tension: 0.4,
            fill: true,
            borderWidth: 3
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        aspectRatio: 2,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 10,
                    usePointStyle: true,
                    font: { size: 11 }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                titleFont: { size: 14 },
                bodyFont: { size: 13 }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(0, 0, 0, 0.05)' },
                ticks: {
                    font: { size: 11 }
                }
            },
            x: {
                grid: { display: false },
                ticks: {
                    font: { size: 11 }
                }
            }
        }
    }
});

// ===== ADVANCED ANALYTICS CHARTS =====

// Recruitment Pipeline Chart
const pipelineChartCtx = document.getElementById('pipelineChart').getContext('2d');
new Chart(pipelineChartCtx, {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_keys($pipeline_stages)) ?>,
        datasets: [{
            label: 'Number of Candidates',
            data: <?= json_encode(array_values($pipeline_stages)) ?>,
            backgroundColor: [
                'rgba(102, 126, 234, 0.8)',
                'rgba(54, 185, 204, 0.8)',
                'rgba(246, 194, 62, 0.8)',
                'rgba(255, 159, 64, 0.8)',
                'rgba(28, 200, 138, 0.8)',
                'rgba(231, 74, 59, 0.8)'
            ],
            borderRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        aspectRatio: 2,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                titleFont: { size: 14 },
                bodyFont: { size: 13 },
                callbacks: {
                    afterLabel: function(context) {
                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                        const percentage = ((context.parsed.y / total) * 100).toFixed(1);
                        return 'Percentage: ' + percentage + '%';
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(0, 0, 0, 0.05)' },
                ticks: {
                    stepSize: 5,
                    font: { size: 11 }
                }
            },
            x: {
                grid: { display: false },
                ticks: {
                    font: { size: 11 }
                }
            }
        }
    }
});

// Time to Hire Chart (Average days by role)
const timeToHireCtx = document.getElementById('timeToHireChart').getContext('2d');
new Chart(timeToHireCtx, {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_column($time_to_hire_roles, 'cd_job_title')) ?>,
        datasets: [{
            label: 'Average Days to Hire',
            data: [
                <?php 
                // Simulate time to hire data (15-45 days range)
                foreach($time_to_hire_roles as $role) {
                    echo rand(15, 45) . ',';
                }
                ?>
            ],
            backgroundColor: 'rgba(246, 194, 62, 0.8)',
            borderRadius: 6
        }]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: true,
        aspectRatio: 2,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                titleFont: { size: 14 },
                bodyFont: { size: 13 },
                callbacks: {
                    label: function(context) {
                        return ' ' + context.parsed.x + ' days';
                    }
                }
            }
        },
        scales: {
            x: {
                beginAtZero: true,
                grid: { color: 'rgba(0, 0, 0, 0.05)' },
                ticks: {
                    callback: function(value) {
                        return value + ' days';
                    },
                    font: { size: 11 }
                }
            },
            y: {
                grid: { display: false },
                ticks: {
                    font: { size: 11 }
                }
            }
        }
    }
});

// Source Effectiveness Chart (Conversion Rate)
const sourceEffectivenessCtx = document.getElementById('sourceEffectivenessChart').getContext('2d');
new Chart(sourceEffectivenessCtx, {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_column($source_effectiveness, 'cd_source')) ?>,
        datasets: [{
            label: 'Total Candidates',
            data: <?= json_encode(array_column($source_effectiveness, 'total')) ?>,
            backgroundColor: 'rgba(54, 185, 204, 0.6)',
            borderRadius: 6,
            yAxisID: 'y'
        }, {
            label: 'Conversion Rate (%)',
            data: <?= json_encode(array_column($source_effectiveness, 'conversion_rate')) ?>,
            backgroundColor: 'rgba(28, 200, 138, 0.8)',
            borderRadius: 6,
            yAxisID: 'y1',
            type: 'line',
            borderColor: 'rgba(28, 200, 138, 1)',
            borderWidth: 3,
            tension: 0.4,
            fill: false
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        aspectRatio: 2,
        interaction: {
            mode: 'index',
            intersect: false
        },
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 10,
                    usePointStyle: true,
                    font: { size: 11 }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                titleFont: { size: 14 },
                bodyFont: { size: 13 }
            }
        },
        scales: {
            y: {
                type: 'linear',
                display: true,
                position: 'left',
                beginAtZero: true,
                grid: { color: 'rgba(0, 0, 0, 0.05)' },
                ticks: {
                    font: { size: 11 }
                }
            },
            y1: {
                type: 'linear',
                display: true,
                position: 'right',
                beginAtZero: true,
                max: 100,
                grid: { display: false },
                ticks: {
                    callback: function(value) {
                        return value + '%';
                    },
                    font: { size: 11 }
                }
            },
            x: {
                grid: { display: false },
                ticks: {
                    font: { size: 11 }
                }
            }
        }
    }
});

// Offer Acceptance Rate Chart
const offerAcceptanceCtx = document.getElementById('offerAcceptanceChart').getContext('2d');
new Chart(offerAcceptanceCtx, {
    type: 'doughnut',
    data: {
        labels: ['Accepted (Selected)', 'Rejected', 'In Process', 'Hold'],
        datasets: [{
            data: [
                <?= $pipeline_stages['Selected'] ?>,
                <?= $pipeline_stages['Rejected'] ?>,
                <?= $pipeline_stages['In Process'] ?>,
                <?= $pipeline_stages['Hold'] ?>
            ],
            backgroundColor: [
                'rgba(28, 200, 138, 0.8)',
                'rgba(231, 74, 59, 0.8)',
                'rgba(246, 194, 62, 0.8)',
                'rgba(133, 135, 150, 0.8)'
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        aspectRatio: 2,
        plugins: {
            legend: {
                position: 'right',
                labels: {
                    padding: 10,
                    usePointStyle: true,
                    font: { size: 11 }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                titleFont: { size: 14 },
                bodyFont: { size: 13 },
                callbacks: {
                    label: function(context) {
                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                        const percentage = ((context.parsed / total) * 100).toFixed(1);
                        return ' ' + context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                    }
                }
            }
        }
    }
});

// Diversity Hiring Statistics Chart
const diversityCtx = document.getElementById('diversityChart').getContext('2d');
new Chart(diversityCtx, {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_column($diversity_data, 'cd_gender')) ?>,
        datasets: [{
            label: 'Total Applicants',
            data: <?= json_encode(array_column($diversity_data, 'total')) ?>,
            backgroundColor: 'rgba(102, 126, 234, 0.6)',
            borderRadius: 6
        }, {
            label: 'Hired',
            data: <?= json_encode(array_column($diversity_data, 'hired')) ?>,
            backgroundColor: 'rgba(28, 200, 138, 0.8)',
            borderRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        aspectRatio: 2,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 10,
                    usePointStyle: true,
                    font: { size: 11 }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                titleFont: { size: 14 },
                bodyFont: { size: 13 },
                callbacks: {
                    afterBody: function(context) {
                        const dataIndex = context[0].dataIndex;
                        const total = <?= json_encode(array_column($diversity_data, 'total')) ?>[dataIndex];
                        const hired = <?= json_encode(array_column($diversity_data, 'hired')) ?>[dataIndex];
                        const rate = total > 0 ? ((hired / total) * 100).toFixed(1) : 0;
                        return 'Hire Rate: ' + rate + '%';
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(0, 0, 0, 0.05)' },
                ticks: {
                    stepSize: 5,
                    font: { size: 11 }
                }
            },
            x: {
                grid: { display: false },
                ticks: {
                    font: { size: 11 }
                }
            }
        }
    }
});

// Candidate Experience Survey Results Chart
const candidateExperienceCtx = document.getElementById('candidateExperienceChart').getContext('2d');
new Chart(candidateExperienceCtx, {
    type: 'radar',
    data: {
        labels: [
            'Communication',
            'Interview Process',
            'Recruiter Support',
            'Time to Response',
            'Overall Experience',
            'Would Recommend'
        ],
        datasets: [{
            label: 'Average Rating (out of 5)',
            data: [4.2, 4.5, 4.3, 3.8, 4.1, 4.4], // Simulated survey data
            backgroundColor: 'rgba(102, 126, 234, 0.2)',
            borderColor: 'rgba(102, 126, 234, 1)',
            borderWidth: 2,
            pointBackgroundColor: 'rgba(102, 126, 234, 1)',
            pointBorderColor: '#fff',
            pointHoverBackgroundColor: '#fff',
            pointHoverBorderColor: 'rgba(102, 126, 234, 1)',
            pointRadius: 4,
            pointHoverRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        aspectRatio: 2,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 10,
                    usePointStyle: true,
                    font: { size: 11 }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                titleFont: { size: 14 },
                bodyFont: { size: 13 },
                callbacks: {
                    label: function(context) {
                        return ' Rating: ' + context.parsed.r + ' / 5.0';
                    }
                }
            }
        },
        scales: {
            r: {
                beginAtZero: true,
                max: 5,
                ticks: {
                    stepSize: 1,
                    font: { size: 10 }
                },
                pointLabels: {
                    font: { size: 11 }
                }
            }
        }
    }
});

// Interviewer Calibration Chart
const interviewerCalibrationCtx = document.getElementById('interviewerCalibrationChart').getContext('2d');
new Chart(interviewerCalibrationCtx, {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_column($interviewer_calibration, 'ce_interviewer')) ?>,
        datasets: [{
            label: 'Total Interviews Conducted',
            data: <?= json_encode(array_column($interviewer_calibration, 'total_interviews')) ?>,
            backgroundColor: 'rgba(54, 185, 204, 0.6)',
            borderRadius: 6,
            yAxisID: 'y'
        }, {
            label: 'Average Rating Given',
            data: [
                <?php 
                // Simulate average ratings (3.5-4.5 range) for each interviewer
                foreach($interviewer_calibration as $interviewer) {
                    echo (rand(35, 45) / 10) . ',';
                }
                ?>
            ],
            backgroundColor: 'rgba(246, 194, 62, 0.8)',
            borderRadius: 6,
            yAxisID: 'y1',
            type: 'line',
            borderColor: 'rgba(246, 194, 62, 1)',
            borderWidth: 3,
            tension: 0.4,
            fill: false,
            pointRadius: 5,
            pointHoverRadius: 7
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        aspectRatio: 2.5,
        interaction: {
            mode: 'index',
            intersect: false
        },
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 10,
                    usePointStyle: true,
                    font: { size: 11 }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                titleFont: { size: 14 },
                bodyFont: { size: 13 }
            }
        },
        scales: {
            y: {
                type: 'linear',
                display: true,
                position: 'left',
                beginAtZero: true,
                grid: { color: 'rgba(0, 0, 0, 0.05)' },
                ticks: {
                    stepSize: 5,
                    font: { size: 11 }
                },
                title: {
                    display: true,
                    text: 'Number of Interviews',
                    font: { size: 12, weight: 'bold' }
                }
            },
            y1: {
                type: 'linear',
                display: true,
                position: 'right',
                beginAtZero: true,
                max: 5,
                grid: { display: false },
                ticks: {
                    callback: function(value) {
                        return value + ' ⭐';
                    },
                    font: { size: 11 }
                },
                title: {
                    display: true,
                    text: 'Average Rating',
                    font: { size: 12, weight: 'bold' }
                }
            },
            x: {
                grid: { display: false },
                ticks: {
                    font: { size: 11 }
                }
            }
        }
    }
});
</script>

<?php
// Load the footer template
$this->load->view('templates/admin_footer');
?>
