<?php
// Set page-specific variables
$data['page_title'] = 'Recruiter Dashboard';
$data['page_specific_css'] = [
    'assets/modern/css/components/dashboard-cards.css',
    'assets/modern/css/components/charts.css'
];
$data['page_specific_js'] = [
    'assets/modern/js/charts/dashboard-charts.js'
];

// Load the header template
$this->load->view('templates/header', $data);
?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <div>
        <a href="<?= base_url('R_dashboard/reports_view') ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm me-2">
            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
        </a>
        <button class="btn btn-sm btn-outline-secondary" onclick="toggleTheme()">
            <i class="fas fa-moon"></i> <span class="d-none d-md-inline">Theme</span>
        </button>
    </div>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Total Candidates Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card card-dashboard card-primary h-100 shadow">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="card-title text-primary">Total Candidates</div>
                        <div class="card-value"><?= $rtotal ?></div>
                        <div class="text-muted small mt-2">
                            All candidates in your pipeline
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-primary opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- First Round Interviews Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card card-dashboard card-info h-100 shadow">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="card-title text-info">First Round</div>
                        <div class="card-value"><?= $r1 ?></div>
                        <div class="text-muted small mt-2">
                            First round interview candidates
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-info opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Second Round Interviews Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card card-dashboard card-warning h-100 shadow">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="card-title text-warning">Second Round</div>
                        <div class="card-value"><?= $r2 ?></div>
                        <div class="text-muted small mt-2">
                            Second round interview candidates
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-check fa-2x text-warning opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Selected Candidates Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card card-dashboard card-success h-100 shadow">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="card-title text-success">Selected</div>
                        <div class="card-value"><?= $rc ?></div>
                        <div class="text-muted small mt-2">
                            Successfully selected candidates
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-trophy fa-2x text-success opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Recruitment Progress Chart -->
    <div class="col-xl-8 col-lg-7">
        <div class="card card-dashboard shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Recruitment Progress</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Chart Options:</div>
                        <a class="dropdown-item" href="#" onclick="updateChart('week')">Last Week</a>
                        <a class="dropdown-item" href="#" onclick="updateChart('month')">Last Month</a>
                        <a class="dropdown-item" href="#" onclick="updateChart('quarter')">Last Quarter</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" onclick="exportChartData()">Export Data</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="recruitmentProgressChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Candidate Status Pie Chart -->
    <div class="col-xl-4 col-lg-5">
        <div class="card card-dashboard shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Candidate Status</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Chart Options:</div>
                        <a class="dropdown-item" href="#" onclick="updatePieChart('status')">By Status</a>
                        <a class="dropdown-item" href="#" onclick="updatePieChart('source')">By Source</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" onclick="exportPieData()">Export Data</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="candidateStatusChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Latest Candidates -->
    <div class="col-xl-8 col-lg-7">
        <div class="card card-dashboard shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Latest Candidates</h6>
                <a href="<?= base_url('R_dashboard/Rstatus_view') ?>" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body">
                <?php if(isset($last_can) && !empty($last_can)): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Source</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($last_can as $row): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?= base_url('Assets/Admin_Dashboard/img/profile/' . ($row->cd_gender === 'Female' ? 'femaleprofile.png' : 'maleprofile.png')) ?>" class="rounded-circle me-2" width="32">
                                        <?= $row->cd_name ?>
                                    </div>
                                </td>
                                <td><?= $row->cd_job_title ?></td>
                                <td><span class="badge bg-<?= getSourceBadgeClass($row->cd_source) ?>"><?= $row->cd_source ?></span></td>
                                <td><span class="badge bg-<?= getStatusBadgeClass($row->cd_status) ?>"><?= $row->cd_status ?></span></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewCandidateModal" data-candidate-id="<?= $row->cd_id ?>"><i class="fas fa-eye"></i></button>
                                        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#editCandidateModal" data-candidate-id="<?= $row->cd_id ?>"><i class="fas fa-edit"></i></button>
                                        <?php if($row->cd_status === 'Shortlisted' || $row->cd_status === 'In Process'): ?>
                                        <a href="<?= base_url('R_dashboard/schedule_btn_action/' . $row->cd_id) ?>" class="btn btn-outline-info"><i class="fas fa-calendar-plus"></i></a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="text-center p-4">
                    <p class="text-muted">No candidates found.</p>
                    <a href="<?= base_url('R_dashboard/Rcandidate_view') ?>" class="btn btn-primary">Add Candidate</a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Upcoming Interviews -->
    <div class="col-xl-4 col-lg-5">
        <div class="card card-dashboard shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Upcoming Interviews</h6>
                <a href="<?= base_url('R_dashboard/Rcalendar_view') ?>" class="btn btn-sm btn-primary">View Calendar</a>
            </div>
            <div class="card-body">
                <div id="upcomingInterviews">
                    <!-- This section will be populated with AJAX to show upcoming interviews from Calendar model -->
                    <div class="text-center p-3">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Loading upcoming interviews...</p>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <a href="<?= base_url('R_dashboard/Rschedule_view') ?>" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-calendar-plus me-1"></i> Schedule New Interview
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions Row -->
<div class="row">
    <div class="col-12">
        <div class="card card-dashboard shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-sm-6 mb-3">
                        <a href="<?= base_url('R_dashboard/Rcandidate_view') ?>" class="btn btn-primary btn-icon-split w-100 h-100 p-3">
                            <span class="icon text-white-50">
                                <i class="fas fa-user-plus"></i>
                            </span>
                            <span class="text">Add New Candidate</span>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <a href="<?= base_url('R_dashboard/Rschedule_view') ?>" class="btn btn-info btn-icon-split w-100 h-100 p-3">
                            <span class="icon text-white-50">
                                <i class="fas fa-calendar-plus"></i>
                            </span>
                            <span class="text">Schedule Interview</span>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <a href="<?= base_url('R_dashboard/kanban_view') ?>" class="btn btn-success btn-icon-split w-100 h-100 p-3">
                            <span class="icon text-white-50">
                                <i class="fas fa-columns"></i>
                            </span>
                            <span class="text">Candidate Pipeline</span>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <a href="<?= base_url('R_dashboard/Rscandidate_view') ?>" class="btn btn-warning btn-icon-split w-100 h-100 p-3">
                            <span class="icon text-white-50">
                                <i class="fas fa-trophy"></i>
                            </span>
                            <span class="text">View Selected Candidates</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Candidate Detail Modal -->
<div class="modal fade" id="viewCandidateModal" tabindex="-1" aria-labelledby="viewCandidateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewCandidateModalLabel">Candidate Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4" id="candidateLoadingSpinner">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading candidate details...</p>
                </div>
                <div id="candidateDetails" style="display: none;">
                    <!-- Will be populated with AJAX when modal opens -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="editCandidateBtn">Edit Candidate</button>
            </div>
        </div>
    </div>
</div>

<?php
// Helper functions to get badge classes based on status and source
function getStatusBadgeClass($status) {
    switch($status) {
        case 'Selected':
            return 'success';
        case 'Shortlisted':
            return 'primary';
        case 'In Process':
        case 'In Review':
            return 'info';
        case 'Rejected':
            return 'danger';
        case 'Hold':
            return 'warning';
        default:
            return 'secondary';
    }
}

function getSourceBadgeClass($source) {
    switch($source) {
        case 'LinkedIn':
            return 'primary';
        case 'Indeed':
            return 'success';
        case 'Referral':
            return 'info';
        case 'Company Website':
            return 'warning';
        case 'Job Portal':
            return 'secondary';
        default:
            return 'light';
    }
}

// Custom script for the dashboard
$custom_script = "
// Load upcoming interviews via AJAX
function loadUpcomingInterviews() {
    $.ajax({
        url: '" . base_url('R_dashboard/get_upcoming_interviews') . "',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            let htmlContent = '';
            
            if (response.length === 0) {
                htmlContent = `
                    <div class='text-center py-4'>
                        <i class='fas fa-calendar-day fa-3x text-muted mb-3'></i>
                        <p class='text-muted'>No upcoming interviews scheduled.</p>
                    </div>
                `;
            } else {
                response.forEach(function(interview) {
                    // Format date and time
                    const interviewDate = new Date(interview.start);
                    const formattedDate = interviewDate.toLocaleDateString('en-US', {
                        weekday: 'short',
                        month: 'short',
                        day: 'numeric'
                    });
                    const formattedTime = interviewDate.toLocaleTimeString('en-US', {
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                    
                    // Determine badge color based on interview round
                    let badgeClass = 'primary';
                    if (interview.interview_round === '0.25') {
                        badgeClass = 'info';
                    } else if (interview.interview_round === '0.5') {
                        badgeClass = 'warning';
                    } else if (interview.interview_round === '0.75') {
                        badgeClass = 'success';
                    }
                    
                    htmlContent += `
                        <div class='interview-item p-3 mb-2 border-start border-3 border-\${badgeClass} rounded shadow-sm'>
                            <div class='d-flex justify-content-between'>
                                <h6 class='mb-1'>\${interview.title}</h6>
                                <span class='badge bg-\${badgeClass}'>Round \${Math.round(interview.interview_round * 4)}</span>
                            </div>
                            <div class='d-flex align-items-center text-muted small'>
                                <i class='far fa-calendar-alt me-1'></i>
                                <span>\${formattedDate}, \${formattedTime}</span>
                                <span class='mx-2'>|</span>
                                <i class='far fa-user me-1'></i>
                                <span>\${interview.Interviewer}</span>
                            </div>
                        </div>
                    `;
                });
            }
            
            $('#upcomingInterviews').html(htmlContent);
        },
        error: function(xhr, status, error) {
            $('#upcomingInterviews').html(`
                <div class='text-center py-4'>
                    <i class='fas fa-exclamation-triangle fa-3x text-warning mb-3'></i>
                    <p class='text-muted'>Error loading interviews. Please try again.</p>
                </div>
            `);
            console.error('Error loading upcoming interviews:', error);
        }
    });
}

// Load candidate details when modal opens
$('#viewCandidateModal').on('show.bs.modal', function (event) {
    const button = $(event.relatedTarget);
    const candidateId = button.data('candidate-id');
    $('#candidateLoadingSpinner').show();
    $('#candidateDetails').hide();
    
    $.ajax({
        url: '" . base_url('R_dashboard/find_can_details') . "',
        type: 'POST',
        data: { can_id: candidateId },
        dataType: 'json',
        success: function(data) {
            let resumeLink = '';
            if (data.cd_resume_link) {
                resumeLink = `<a href='" . base_url() . "uploads/\${data.cd_resume_link}' target='_blank' class='btn btn-sm btn-outline-primary'><i class='fas fa-file-pdf me-1'></i> View Resume</a>`;
            } else {
                resumeLink = `<span class='text-muted'>No resume uploaded</span>`;
            }
            
            let statusBadge = `<span class='badge bg-\${getStatusClass(data.cd_status)}'>\${data.cd_status}</span>`;
            
            const html = `
                <div class='row'>
                    <div class='col-md-4 text-center mb-4'>
                        <img src='" . base_url('Assets/Admin_Dashboard/img/profile/') . "' + (data.cd_gender === 'Female' ? 'femaleprofile.png' : 'maleprofile.png') class='img-fluid rounded-circle mb-3' style='width: 150px; height: 150px;'>
                        <h5>\${data.cd_name}</h5>
                        <p class='text-muted'>\${data.cd_job_title}</p>
                        <div class='mt-3'>
                            \${statusBadge}
                        </div>
                    </div>
                    <div class='col-md-8'>
                        <div class='row mb-3'>
                            <div class='col-md-6'>
                                <label class='form-label fw-bold'><i class='fas fa-envelope me-2'></i> Email</label>
                                <p>\${data.cd_email}</p>
                            </div>
                            <div class='col-md-6'>
                                <label class='form-label fw-bold'><i class='fas fa-phone me-2'></i> Phone</label>
                                <p>\${data.cd_phone}</p>
                            </div>
                        </div>
                        <div class='row mb-3'>
                            <div class='col-md-6'>
                                <label class='form-label fw-bold'><i class='fas fa-venus-mars me-2'></i> Gender</label>
                                <p>\${data.cd_gender}</p>
                            </div>
                            <div class='col-md-6'>
                                <label class='form-label fw-bold'><i class='fas fa-briefcase me-2'></i> Position</label>
                                <p>\${data.cd_job_title}</p>
                            </div>
                        </div>
                        <div class='row mb-3'>
                            <div class='col-md-6'>
                                <label class='form-label fw-bold'><i class='fas fa-globe me-2'></i> Source</label>
                                <p><span class='badge bg-\${getSourceClass(data.cd_source)}'>\${data.cd_source}</span></p>
                            </div>
                            <div class='col-md-6'>
                                <label class='form-label fw-bold'><i class='fas fa-file-alt me-2'></i> Resume</label>
                                <p>\${resumeLink}</p>
                            </div>
                        </div>
                        <div class='mb-3'>
                            <label class='form-label fw-bold'><i class='fas fa-sticky-note me-2'></i> Description</label>
                            <p>\${data.cd_description || 'No description available.'}</p>
                        </div>
                    </div>
                </div>
            `;
            
            $('#candidateLoadingSpinner').hide();
            $('#candidateDetails').html(html).show();
            $('#editCandidateBtn').data('candidate-id', candidateId);
        },
        error: function(xhr, status, error) {
            $('#candidateLoadingSpinner').hide();
            $('#candidateDetails').html(`
                <div class='alert alert-danger'>
                    <i class='fas fa-exclamation-circle me-2'></i> Error loading candidate details. Please try again.
                </div>
            `).show();
            console.error('Error loading candidate details:', error);
        }
    });
});

// Helper functions for badge classes
function getStatusClass(status) {
    switch(status) {
        case 'Selected': return 'success';
        case 'Shortlisted': return 'primary';
        case 'In Process':
        case 'In Review': return 'info';
        case 'Rejected': return 'danger';
        case 'Hold': return 'warning';
        default: return 'secondary';
    }
}

function getSourceClass(source) {
    switch(source) {
        case 'LinkedIn': return 'primary';
        case 'Indeed': return 'success';
        case 'Referral': return 'info';
        case 'Company Website': return 'warning';
        case 'Job Portal': return 'secondary';
        default: return 'light';
    }
}

// Edit candidate button handler
$('#editCandidateBtn').on('click', function() {
    const candidateId = $(this).data('candidate-id');
    $('#viewCandidateModal').modal('hide');
    window.location.href = '" . base_url('R_dashboard/edit_candidate/') . "' + candidateId;
});

// Initialize charts when the page loads
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Recruitment Progress Chart
    const progressCtx = document.getElementById('recruitmentProgressChart').getContext('2d');
    window.recruitmentProgressChart = new Chart(progressCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [
                {
                    label: 'Applications',
                    data: [" . rand(50, 80) . ", " . rand(60, 90) . ", " . rand(70, 100) . ", " . rand(80, 110) . ", " . rand(90, 120) . ", " . rand(100, 130) . "],
                    backgroundColor: 'rgba(78, 115, 223, 0.05)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                    pointBorderColor: '#fff',
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: 'rgba(78, 115, 223, 1)',
                    pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    tension: 0.3,
                    fill: true
                },
                {
                    label: 'Interviews',
                    data: [" . $r1 . ", " . $r2 . ", " . $r3 . ", " . rand(20, 40) . ", " . rand(25, 45) . ", " . rand(30, 50) . "],
                    backgroundColor: 'rgba(28, 200, 138, 0.05)',
                    borderColor: 'rgba(28, 200, 138, 1)',
                    pointBackgroundColor: 'rgba(28, 200, 138, 1)',
                    pointBorderColor: '#fff',
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: 'rgba(28, 200, 138, 1)',
                    pointHoverBorderColor: 'rgba(28, 200, 138, 1)',
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    tension: 0.3,
                    fill: true
                },
                {
                    label: 'Selected',
                    data: [" . $rc . ", " . rand(5, 15) . ", " . rand(10, 20) . ", " . rand(15, 25) . ", " . rand(20, 30) . ", " . rand(25, 35) . "],
                    backgroundColor: 'rgba(246, 194, 62, 0.05)',
                    borderColor: 'rgba(246, 194, 62, 1)',
                    pointBackgroundColor: 'rgba(246, 194, 62, 1)',
                    pointBorderColor: '#fff',
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: 'rgba(246, 194, 62, 1)',
                    pointHoverBorderColor: 'rgba(246, 194, 62, 1)',
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    tension: 0.3,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.8)',
                    titleColor: '#6e707e',
                    bodyColor: '#858796',
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    displayColors: false,
                    caretPadding: 10,
                    boxPadding: 5
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    }
                },
                y: {
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        zeroLineColor: 'rgba(0, 0, 0, 0.1)',
                        drawBorder: false
                    },
                    beginAtZero: true
                }
            }
        }
    });
    
    // Initialize Candidate Status Chart
    const statusCtx = document.getElementById('candidateStatusChart').getContext('2d');
    window.candidateStatusChart = new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['New Applications', 'In Review', 'Shortlisted', 'Selected', 'Rejected'],
            datasets: [{
                data: [
                    " . ($rtotal - ($r1 + $r2 + $r3 + $rc)) . ", 
                    " . $r1 . ", 
                    " . $r2 . ", 
                    " . $rc . ", 
                    " . rand(5, 15) . "
                ],
                backgroundColor: [
                    '#4e73df',
                    '#36b9cc',
                    '#1cc88a',
                    '#f6c23e',
                    '#e74a3b'
                ],
                hoverBackgroundColor: [
                    '#2e59d9',
                    '#2c9faf',
                    '#17a673',
                    '#dda20a',
                    '#c23b2b'
                ],
                hoverBorderColor: 'rgba(234, 236, 244, 1)',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.8)',
                    titleColor: '#6e707e',
                    bodyColor: '#858796',
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    displayColors: false
                }
            },
            cutout: '70%'
        }
    });
    
    // Load upcoming interviews
    loadUpcomingInterviews();
});

// Chart update functions
function updateChart(timeframe) {
    // Placeholder for actual implementation
    // In a real application, this would fetch data from the server based on the timeframe
    console.log('Update chart for timeframe:', timeframe);
    
    // Example of how to update the chart
    const newData = {
        week: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [
                {data: [10, 15, 12, 18, 20, 15, 14]},
                {data: [5, 8, 6, 10, 12, 8, 9]},
                {data: [2, 3, 2, 4, 5, 3, 4]}
            ]
        },
        month: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            datasets: [
                {data: [45, 60, 75, 85]},
                {data: [25, 30, 40, 50]},
                {data: [10, 15, 20, 25]}
            ]
        },
        quarter: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [
                {data: [" . rand(50, 80) . ", " . rand(60, 90) . ", " . rand(70, 100) . ", " . rand(80, 110) . ", " . rand(90, 120) . ", " . rand(100, 130) . "]},
                {data: [" . $r1 . ", " . $r2 . ", " . $r3 . ", " . rand(20, 40) . ", " . rand(25, 45) . ", " . rand(30, 50) . "]},
                {data: [" . $rc . ", " . rand(5, 15) . ", " . rand(10, 20) . ", " . rand(15, 25) . ", " . rand(20, 30) . ", " . rand(25, 35) . "]}
            ]
        }
    };
    
    const chartData = newData[timeframe];
    
    window.recruitmentProgressChart.data.labels = chartData.labels;
    window.recruitmentProgressChart.data.datasets.forEach((dataset, i) => {
        dataset.data = chartData.datasets[i].data;
    });
    
    window.recruitmentProgressChart.update();
}

function updatePieChart(type) {
    // Placeholder for actual implementation
    console.log('Update pie chart for type:', type);
    
    if (type === 'status') {
        window.candidateStatusChart.data.labels = ['New Applications', 'In Review', 'Shortlisted', 'Selected', 'Rejected'];
        window.candidateStatusChart.data.datasets[0].data = [
            " . ($rtotal - ($r1 + $r2 + $r3 + $rc)) . ", 
            " . $r1 . ", 
            " . $r2 . ", 
            " . $rc . ", 
            " . rand(5, 15) . "
        ];
    } else if (type === 'source') {
        window.candidateStatusChart.data.labels = ['LinkedIn', 'Indeed', 'Referral', 'Company Website', 'Other'];
        window.candidateStatusChart.data.datasets[0].data = [
            " . rand(30, 50) . ", 
            " . rand(15, 30) . ", 
            " . rand(10, 20) . ", 
            " . rand(5, 15) . ", 
            " . rand(3, 10) . "
        ];
    }
    
    window.candidateStatusChart.update();
}

function exportChartData() {
    alert('Export functionality will be implemented in future updates.');
}

function exportPieData() {
    alert('Export functionality will be implemented in future updates.');
}
";

// Add the custom script to data
$data['custom_script'] = $custom_script;

// Load the footer template
$this->load->view('templates/footer', $data);