<?php
// Set page-specific variables
$data['page_title'] = 'Admin Dashboard';
$data['use_charts'] = true;
$data['use_datatable'] = true;

// Load the header template
$this->load->view('templates/admin_header', $data);
?>

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
            <div class="data-card-header">
                <h3 class="data-card-title">Recent Candidates</h3>
            </div>
            <div class="list-group list-group-flush">
                <?php if(isset($sel_can) && !empty($sel_can)): ?>
                    <?php $i = 1; foreach($sel_can as $can): ?>
                        <div class="list-group-item d-flex align-items-center" style="border: none; padding: 12px 0;">
                            <div class="me-3" style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                                <?= $i ?>
                            </div>
                            <div>
                                <div style="font-weight: 600; color: var(--dark-color);"><?= $can['ce_can_name'] ?></div>
                                <small style="color: #999;">Recently added</small>
                            </div>
                        </div>
                    <?php $i++; endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-4" style="color: #999;">
                        <i class="fas fa-inbox fa-3x mb-3" style="opacity: 0.3;"></i>
                        <p>No candidates added yet</p>
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
    <div class="data-card-header">
        <h3 class="data-card-title">All Candidates</h3>
        <button class="btn btn-primary-modern btn-modern">
            <i class="fas fa-download me-2"></i>Export Data
        </button>
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
// Initialize DataTable
$(document).ready(function() {
    $('#dashboardTable').DataTable({
        responsive: true,
        pageLength: 10,
        language: {
            emptyTable: 'No candidates found',
            zeroRecords: 'No matching candidates found',
            search: '_INPUT_',
            searchPlaceholder: 'Search candidates...'
        },
        order: [[0, 'asc']]
    });
});

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
