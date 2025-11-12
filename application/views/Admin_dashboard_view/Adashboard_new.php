<?php
// Set page-specific variables
$data['page_title'] = 'Admin Dashboard';
$data['use_charts'] = true;
$data['use_datatable'] = true;

// Load the header template
$this->load->view('templates/admin_header', $data);
?>

<style>
/* Enhanced Dashboard Styles */
.dashboard-welcome {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 24px;
    border-radius: 16px;
    margin-bottom: 24px;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    animation: slideDown 0.5s ease-out;
}

.dashboard-welcome h2 {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 8px;
}

.dashboard-welcome p {
    opacity: 0.9;
    margin: 0;
}

.stat-card {
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
    animation: fadeInUp 0.6s ease-out;
}

.stat-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.15) !important;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 100px;
    height: 100px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
    transform: translate(30%, -30%);
}

.stat-card-value {
    font-size: 36px !important;
    font-weight: 700;
    animation: countUp 1s ease-out;
}

.quick-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    margin-bottom: 24px;
}

.quick-action-btn {
    flex: 1;
    min-width: 200px;
    padding: 16px 24px;
    border-radius: 12px;
    border: 2px solid #e2e8f0;
    background: white;
    display: flex;
    align-items: center;
    gap: 12px;
    transition: all 0.3s ease;
    cursor: pointer;
    text-decoration: none;
    color: #2d3748;
}

.quick-action-btn:hover {
    border-color: #667eea;
    background: #f7fafc;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
    color: #667eea;
}

.quick-action-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

.quick-action-content h4 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
}

.quick-action-content p {
    margin: 0;
    font-size: 13px;
    color: #718096;
}

.data-card {
    animation: fadeInUp 0.7s ease-out;
}

.recent-candidate-item {
    transition: all 0.2s ease;
    cursor: pointer;
}

.recent-candidate-item:hover {
    background: #f7fafc;
    transform: translateX(4px);
}

.filter-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    background: #667eea;
    color: white;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    margin-right: 8px;
    margin-bottom: 8px;
    animation: fadeIn 0.3s ease;
}

.filter-badge i {
    cursor: pointer;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #a0aec0;
}

.empty-state i {
    font-size: 64px;
    opacity: 0.3;
    margin-bottom: 16px;
}

.table-action-btn {
    padding: 6px 12px;
    border-radius: 6px;
    border: none;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.table-action-btn:hover {
    transform: scale(1.05);
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes countUp {
    from {
        opacity: 0;
        transform: scale(0.5);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.progress-ring {
    width: 40px;
    height: 40px;
}

.progress-ring-circle {
    transition: stroke-dashoffset 0.5s ease;
}

.candidate-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    color: white;
    font-size: 16px;
}

.status-indicator {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
    margin-right: 6px;
}

.status-indicator.active {
    background: #48bb78;
    box-shadow: 0 0 8px rgba(72, 187, 120, 0.5);
}

.status-indicator.pending {
    background: #ed8936;
    box-shadow: 0 0 8px rgba(237, 137, 54, 0.5);
}

.status-indicator.inactive {
    background: #cbd5e0;
}
</style>

<!-- Welcome Banner -->
<div class="dashboard-welcome">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2>Welcome back, <?= $this->session->userdata('username') ?>! 👋</h2>
            <p>Here's what's happening with your recruitment today</p>
        </div>
        <div>
            <button class="btn btn-light" onclick="refreshDashboard()">
                <i class="fas fa-sync-alt me-2"></i>Refresh
            </button>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="quick-actions">
    <a href="<?= base_url('A_dashboard/Acandidate_users_view') ?>" class="quick-action-btn">
        <div class="quick-action-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
            <i class="fas fa-user-plus" style="color: white;"></i>
        </div>
        <div class="quick-action-content">
            <h4>Add Candidate</h4>
            <p>Register new candidate</p>
        </div>
    </a>
    
    <a href="<?= base_url('A_dashboard/Ainterviewer_view') ?>" class="quick-action-btn">
        <div class="quick-action-icon" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
            <i class="fas fa-calendar-alt" style="color: white;"></i>
        </div>
        <div class="quick-action-content">
            <h4>Schedule Interview</h4>
            <p>Book interview slots</p>
        </div>
    </a>
    
    <a href="<?= base_url('A_dashboard/reports_view') ?>" class="quick-action-btn">
        <div class="quick-action-icon" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
            <i class="fas fa-chart-bar" style="color: white;"></i>
        </div>
        <div class="quick-action-content">
            <h4>View Reports</h4>
            <p>Analytics & insights</p>
        </div>
    </a>
    
    <a href="<?= base_url('Setup/audit_logs') ?>" class="quick-action-btn">
        <div class="quick-action-icon" style="background: linear-gradient(135deg, #fa709a, #fee140);">
            <i class="fas fa-history" style="color: white;"></i>
        </div>
        <div class="quick-action-content">
            <h4>Audit Logs</h4>
            <p>Track activities</p>
        </div>
    </a>
</div>

<!-- Dashboard Stats -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-card-title">Total Candidates</div>
                <div class="stat-card-icon" style="background: rgba(102, 126, 234, 0.1); color: var(--primary-color);">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="stat-card-value"><?= isset($rtotal) ? $rtotal : 0 ?></div>
            <div class="stat-card-footer">All candidates in the system</div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card success">
            <div class="stat-card-header">
                <div class="stat-card-title">Selected</div>
                <div class="stat-card-icon" style="background: rgba(28, 200, 138, 0.1); color: var(--success-color);">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
            <div class="stat-card-value"><?= isset($can_selected) ? $can_selected : 0 ?></div>
            <div class="stat-card-footer">Successfully selected candidates</div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card warning">
            <div class="stat-card-header">
                <div class="stat-card-title">In Progress</div>
                <div class="stat-card-icon" style="background: rgba(246, 194, 62, 0.1); color: var(--warning-color);">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
            <div class="stat-card-value"><?= isset($int_not_selected) ? $int_not_selected : 0 ?></div>
            <div class="stat-card-footer">Interview scheduled</div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card info">
            <div class="stat-card-header">
                <div class="stat-card-title">Interested</div>
                <div class="stat-card-icon" style="background: rgba(54, 185, 204, 0.1); color: var(--info-color);">
                    <i class="fas fa-star"></i>
                </div>
            </div>
            <div class="stat-card-value"><?= isset($interested_can) ? $interested_can : 0 ?></div>
            <div class="stat-card-footer">Interested candidates</div>
        </div>
    </div>
</div>

<!-- Charts and Recent Candidates -->
<div class="row g-4 mb-4">
    <!-- Recent Candidates -->
    <div class="col-lg-4">
        <div class="data-card">
            <div class="data-card-header d-flex justify-content-between align-items-center">
                <h3 class="data-card-title mb-0">
                    <i class="fas fa-users me-2 text-primary"></i>Recent Candidates
                </h3>
                <span class="badge bg-primary rounded-pill"><?= isset($sel_can) ? count($sel_can) : 0 ?></span>
            </div>
            <div class="list-group list-group-flush" style="max-height: 400px; overflow-y: auto;">
                <?php if(isset($sel_can) && !empty($sel_can)): ?>
                    <?php 
                    $colors = ['#667eea', '#f093fb', '#4facfe', '#fa709a', '#43e97b'];
                    $i = 0;
                    $max_display = 5; // Show only 5 candidates
                    $displayed = 0;
                    foreach($sel_can as $can): 
                        if($displayed >= $max_display) break;
                        $color = $colors[$i % count($colors)];
                        $initials = strtoupper(substr($can['ce_can_name'], 0, 1));
                    ?>
                        <div class="list-group-item recent-candidate-item d-flex align-items-center" style="border: none; padding: 12px 0; border-bottom: 1px solid #f0f0f0;">
                            <div class="candidate-avatar me-2" style="background: <?= $color ?>; width: 36px; height: 36px; font-size: 14px;">
                                <?= $initials ?>
                            </div>
                            <div class="flex-grow-1" style="min-width: 0;">
                                <div style="font-weight: 600; color: #2d3748; font-size: 14px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?= $can['ce_can_name'] ?></div>
                                <small style="color: #a0aec0; font-size: 11px;">
                                    <i class="fas fa-clock" style="font-size: 10px;"></i> Recently added
                                </small>
                            </div>
                            <div>
                                <span class="status-indicator active" title="Active"></span>
                            </div>
                        </div>
                    <?php 
                        $i++; 
                        $displayed++;
                    endforeach; ?>
                    
                    <?php if(count($sel_can) > $max_display): ?>
                        <div class="text-center py-2" style="background: #f7fafc; border-top: 1px solid #e2e8f0;">
                            <small class="text-muted">+<?= count($sel_can) - $max_display ?> more candidates</small>
                        </div>
                    <?php endif; ?>
                    
                    <div class="text-center pt-2 pb-1">
                        <a href="<?= base_url('A_dashboard/Acandidate_users_view') ?>" class="btn btn-sm btn-outline-primary" style="font-size: 13px;">
                            View All Candidates <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                <?php else: ?>
                    <div class="empty-state" style="padding: 40px 20px;">
                        <i class="fas fa-user-friends" style="font-size: 48px;"></i>
                        <p class="mb-2" style="font-size: 14px;">No candidates yet</p>
                        <a href="<?= base_url('A_dashboard/Acandidate_users_view') ?>" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus me-1"></i>Add First Candidate
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Candidate Status Chart -->
    <div class="col-lg-8">
        <div class="data-card">
            <div class="data-card-header">
                <h3 class="data-card-title">Candidate Status Overview</h3>
            </div>
            <canvas id="candidateChart" style="max-height: 350px;"></canvas>
        </div>
    </div>
</div>

<!-- Candidates Data Table -->
<div class="data-card">
    <div class="data-card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h3 class="data-card-title mb-1">
                <i class="fas fa-table me-2 text-primary"></i>All Candidates
            </h3>
            <p class="text-muted small mb-0">Manage and track all candidates in one place</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary btn-sm" onclick="printDashboardTable()">
                <i class="fas fa-print me-2"></i>Print
            </button>
            <button class="btn btn-success btn-sm" onclick="exportDashboardData()">
                <i class="fas fa-download me-2"></i>Export CSV
            </button>
            <a href="<?= base_url('A_dashboard/Acandidate_users_view') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-2"></i>Add Candidate
            </a>
        </div>
    </div>
    
    <!-- Filters Section -->
    <div class="p-3 bg-light border-bottom">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label small fw-bold">
                    <i class="fas fa-search me-1"></i>Search
                </label>
                <input type="text" class="form-control form-control-sm" id="dashboardSearchInput" placeholder="Search candidates...">
            </div>
            
            <div class="col-md-2">
                <label class="form-label small fw-bold">
                    <i class="fas fa-flag me-1"></i>Status
                </label>
                <select class="form-select form-select-sm" id="dashboardStatusFilter">
                    <option value="">All Status</option>
                    <option value="Not Started">Not Started</option>
                    <option value="Round 1">Round 1</option>
                    <option value="Round 2">Round 2</option>
                    <option value="Round 3">Round 3</option>
                    <option value="Completed">Completed</option>
                </select>
            </div>
            
            <div class="col-md-2">
                <label class="form-label small fw-bold">
                    <i class="fas fa-tasks me-1"></i>Progress
                </label>
                <select class="form-select form-select-sm" id="dashboardProgressFilter">
                    <option value="">All Progress</option>
                    <option value="100">100% Complete</option>
                    <option value="75-99">75-99% Complete</option>
                    <option value="50-74">50-74% Complete</option>
                    <option value="25-49">25-49% Complete</option>
                    <option value="0-24">0-24% Complete</option>
                </select>
            </div>
            
            <div class="col-md-2">
                <label class="form-label small fw-bold">
                    <i class="fas fa-user-tie me-1"></i>Recruiter
                </label>
                <select class="form-select form-select-sm" id="dashboardRecruiterFilter">
                    <option value="">All Recruiters</option>
                    <?php if(isset($can_details) && $can_details->num_rows() > 0): ?>
                        <?php 
                        $recruiters = array();
                        foreach($can_details->result_array() as $row) {
                            if(!empty($row['cd_rec_username']) && !in_array($row['cd_rec_username'], $recruiters)) {
                                $recruiters[] = $row['cd_rec_username'];
                            }
                        }
                        foreach($recruiters as $recruiter): 
                        ?>
                            <option value="<?= $recruiter ?>"><?= $recruiter ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            
            <div class="col-md-2">
                <label class="form-label small fw-bold">
                    <i class="fas fa-briefcase me-1"></i>Job Title
                </label>
                <select class="form-select form-select-sm" id="dashboardJobFilter">
                    <option value="">All Jobs</option>
                    <?php if(isset($can_details) && $can_details->num_rows() > 0): ?>
                        <?php 
                        $jobs = array();
                        foreach($can_details->result_array() as $row) {
                            if(!empty($row['cd_job_title']) && !in_array($row['cd_job_title'], $jobs)) {
                                $jobs[] = $row['cd_job_title'];
                            }
                        }
                        foreach($jobs as $job): 
                        ?>
                            <option value="<?= $job ?>"><?= $job ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            
            <div class="col-md-1 d-flex align-items-end">
                <button class="btn btn-sm btn-outline-secondary w-100" onclick="resetDashboardFilters()" title="Reset Filters">
                    <i class="fas fa-redo"></i>
                </button>
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="col-md-6">
                <small class="text-muted">
                    <i class="fas fa-info-circle me-1"></i>
                    Showing <strong><span id="dashboardFilteredCount">0</span></strong> of <strong><span id="dashboardTotalCount">0</span></strong> candidates
                </small>
            </div>
            <div class="col-md-6 text-end">
                <div id="activeFilters"></div>
            </div>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover" id="dashboardTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Recruiter</th>
                    <th>Job Title</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Progress</th>
                    <th>Status</th>
                    <th>Selected</th>
                </tr>
            </thead>
            <tbody>
                <?php if(isset($can_details) && $can_details->num_rows() > 0): ?>
                    <?php $i = 1; foreach ($can_details->result_array() as $row): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td>
                                <div style="font-weight: 600;"><?= $row['cd_name'] ?></div>
                            </td>
                            <td><?= $row['cd_rec_username'] ?></td>
                            <td><?= $row['cd_job_title'] ?></td>
                            <td><?= $row['cd_email'] ?></td>
                            <td><?= $row['cd_phone'] ?></td>
                            <td>
                                <?php
                                $round = isset($row['ce_interview_round']) ? $row['ce_interview_round'] : 0;
                                $progress = $round * 100;
                                $progressClass = 'bg-info';
                                if ($progress >= 75) $progressClass = 'bg-success';
                                elseif ($progress >= 50) $progressClass = 'bg-warning';
                                ?>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar <?= $progressClass ?>" role="progressbar" style="width: <?= $progress ?>%" aria-valuenow="<?= $progress ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <small style="color: #999;"><?= $progress ?>% Complete</small>
                            </td>
                            <td>
                                <?php
                                $round = isset($row['ce_interview_round']) ? $row['ce_interview_round'] : 0;
                                if ($round == 0) {
                                    echo '<span class="badge bg-secondary">Not Started</span>';
                                } elseif ($round == 0.25) {
                                    echo '<span class="badge bg-info">Round 1</span>';
                                } elseif ($round == 0.5) {
                                    echo '<span class="badge bg-primary">Round 2</span>';
                                } elseif ($round == 0.75) {
                                    echo '<span class="badge bg-warning">Round 3</span>';
                                } elseif ($round == 1) {
                                    echo '<span class="badge bg-success">Completed</span>';
                                }
                                ?>
                            </td>
                            <td class="text-center">
                                <?php 
                                $round = isset($row['ce_interview_round']) ? $row['ce_interview_round'] : 0;
                                if ($round == 1): 
                                ?>
                                    <i class="fas fa-check-circle text-success" style="font-size: 20px;"></i>
                                <?php else: ?>
                                    <i class="fas fa-times-circle text-danger" style="font-size: 20px;"></i>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td><span class="badge bg-secondary">No Data</span></td>
                        <td>-</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
// Custom script for charts
$custom_script = "
// Initialize DataTable with Filters
$(document).ready(function() {
    var dashboardTable = $('#dashboardTable').DataTable({
        responsive: true,
        pageLength: 10,
        language: {
            emptyTable: 'No candidates found',
            zeroRecords: 'No matching candidates found',
            search: '_INPUT_',
            searchPlaceholder: 'Search candidates...'
        },
        order: [[0, 'asc']],
        dom: 'lrtip' // Remove default search box
    });
    
    // Custom search filter
    $('#dashboardSearchInput').on('keyup', function() {
        dashboardTable.search(this.value).draw();
        updateDashboardCounts();
        updateActiveFilters();
    });
    
    // Custom column filters
    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            if (settings.nTable.id !== 'dashboardTable') return true;
            
            var statusFilter = $('#dashboardStatusFilter').val();
            var progressFilter = $('#dashboardProgressFilter').val();
            var recruiterFilter = $('#dashboardRecruiterFilter').val();
            var jobFilter = $('#dashboardJobFilter').val();
            
            var status = data[7] || ''; // Status column
            var recruiter = data[2] || ''; // Recruiter column
            var job = data[3] || ''; // Job Title column
            var progress = data[6] || ''; // Progress column
            
            // Status filter
            if (statusFilter && !status.includes(statusFilter)) {
                return false;
            }
            
            // Recruiter filter
            if (recruiterFilter && !recruiter.includes(recruiterFilter)) {
                return false;
            }
            
            // Job filter
            if (jobFilter && !job.includes(jobFilter)) {
                return false;
            }
            
            // Progress filter
            if (progressFilter) {
                var progressMatch = progress.match(/(\d+)%/);
                if (progressMatch) {
                    var progressNum = parseInt(progressMatch[1]);
                    if (progressFilter === '100' && progressNum !== 100) return false;
                    if (progressFilter === '75-99' && (progressNum < 75 || progressNum >= 100)) return false;
                    if (progressFilter === '50-74' && (progressNum < 50 || progressNum >= 75)) return false;
                    if (progressFilter === '25-49' && (progressNum < 25 || progressNum >= 50)) return false;
                    if (progressFilter === '0-24' && (progressNum < 0 || progressNum >= 25)) return false;
                }
            }
            
            return true;
        }
    );
    
    // Apply filters on change
    $('#dashboardStatusFilter, #dashboardProgressFilter, #dashboardRecruiterFilter, #dashboardJobFilter').on('change', function() {
        dashboardTable.draw();
        updateDashboardCounts();
        updateActiveFilters();
    });
    
    // Update counts
    function updateDashboardCounts() {
        if (dashboardTable && dashboardTable.page) {
            var info = dashboardTable.page.info();
            $('#dashboardFilteredCount').text(info.recordsDisplay);
            $('#dashboardTotalCount').text(info.recordsTotal);
        }
    }
    
    // Make functions global
    window.updateDashboardCounts = updateDashboardCounts;
    window.dashboardTable = dashboardTable;
    
    // Initial count update
    setTimeout(function() {
        updateDashboardCounts();
        updateActiveFilters();
    }, 100);
    
    // Add smooth scroll to table when filtering
    $('#dashboardStatusFilter, #dashboardProgressFilter, #dashboardRecruiterFilter, #dashboardJobFilter').on('change', function() {
        $('html, body').animate({
            scrollTop: $('#dashboardTable').offset().top - 100
        }, 500);
    });
});

// Reset filters
function resetDashboardFilters() {
    $('#dashboardSearchInput').val('');
    $('#dashboardStatusFilter').val('');
    $('#dashboardProgressFilter').val('');
    $('#dashboardRecruiterFilter').val('');
    $('#dashboardJobFilter').val('');
    if (window.dashboardTable) {
        window.dashboardTable.search('').draw();
        if (typeof window.updateDashboardCounts === 'function') {
            window.updateDashboardCounts();
        }
    }
    updateActiveFilters();
}

// Update active filters display
function updateActiveFilters() {
    var filters = [];
    var search = $('#dashboardSearchInput').val();
    var status = $('#dashboardStatusFilter').val();
    var progress = $('#dashboardProgressFilter').val();
    var recruiter = $('#dashboardRecruiterFilter').val();
    var job = $('#dashboardJobFilter').val();
    
    if (search) filters.push({ label: 'Search: ' + search, type: 'search' });
    if (status) filters.push({ label: 'Status: ' + status, type: 'status' });
    if (progress) filters.push({ label: 'Progress: ' + progress, type: 'progress' });
    if (recruiter) filters.push({ label: 'Recruiter: ' + recruiter, type: 'recruiter' });
    if (job) filters.push({ label: 'Job: ' + job, type: 'job' });
    
    var html = '';
    filters.forEach(function(filter) {
        html += '<span class=\"filter-badge\"><i class=\"fas fa-filter me-1\"></i>' + filter.label + ' <i class=\"fas fa-times ms-1\" onclick=\"removeFilter(\'' + filter.type + '\')\"></i></span>';
    });
    
    $('#activeFilters').html(html);
}

// Remove specific filter
function removeFilter(type) {
    switch(type) {
        case 'search': $('#dashboardSearchInput').val('').trigger('keyup'); break;
        case 'status': $('#dashboardStatusFilter').val('').trigger('change'); break;
        case 'progress': $('#dashboardProgressFilter').val('').trigger('change'); break;
        case 'recruiter': $('#dashboardRecruiterFilter').val('').trigger('change'); break;
        case 'job': $('#dashboardJobFilter').val('').trigger('change'); break;
    }
    updateActiveFilters();
}

// Refresh dashboard
function refreshDashboard() {
    location.reload();
}

// Print table
function printDashboardTable() {
    window.print();
}

// Export filtered data
function exportDashboardData() {
    if (!window.dashboardTable) return;
    
    var data = window.dashboardTable.rows({ search: 'applied' }).data();
    
    // Create CSV content
    var csv = 'No,Name,Recruiter,Job Title,Email,Phone,Progress,Status,Selected\\n';
    data.each(function(row) {
        // Clean HTML tags from data
        var cleanRow = [];
        for (var i = 0; i < row.length; i++) {
            var cell = row[i].toString().replace(/<[^>]*>/g, '').replace(/,/g, ';').trim();
            cleanRow.push(cell);
        }
        csv += cleanRow.join(',') + '\\n';
    });
    
    // Download CSV
    var blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    var url = window.URL.createObjectURL(blob);
    var a = document.createElement('a');
    a.href = url;
    a.download = 'dashboard_candidates_' + new Date().toISOString().slice(0,10) + '.csv';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
}

// Candidate Status Chart
const ctx = document.getElementById('candidateChart').getContext('2d');
const candidateChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Selected', 'In Progress', 'Interested'],
        datasets: [{
            label: 'Number of Candidates',
            data: [" . (isset($can_selected) ? $can_selected : 0) . ", " . (isset($int_not_selected) ? $int_not_selected : 0) . ", " . (isset($interested_can) ? $interested_can : 0) . "],
            backgroundColor: [
                'rgba(28, 200, 138, 0.8)',
                'rgba(246, 194, 62, 0.8)',
                'rgba(54, 185, 204, 0.8)'
            ],
            borderColor: [
                'rgba(28, 200, 138, 1)',
                'rgba(246, 194, 62, 1)',
                'rgba(54, 185, 204, 1)'
            ],
            borderWidth: 2,
            borderRadius: 8
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: false
            },
            title: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                },
                grid: {
                    display: true,
                    drawBorder: false
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});
";

$data['custom_script'] = $custom_script;

// Load the footer template
$this->load->view('templates/admin_footer', $data);
?>
