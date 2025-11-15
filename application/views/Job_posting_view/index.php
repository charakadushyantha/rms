<?php $this->load->view('templates/admin_header'); ?>

<div class="content-area">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Job Postings</h1>
                <p class="text-muted">Manage and post jobs to multiple platforms</p>
            </div>
            <div>
                <a href="<?= base_url('Job_posting/create') ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create Job Posting
                </a>
                <a href="<?= base_url('Job_posting/analytics') ?>" class="btn btn-info">
                    <i class="fas fa-chart-bar"></i> Analytics
                </a>
            </div>
        </div>

        <!-- Flash Messages -->
        <?php if($this->session->flashdata('success_msg')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> <?= $this->session->flashdata('success_msg') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if($this->session->flashdata('error_msg')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> <?= $this->session->flashdata('error_msg') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-white-75 small">Total Jobs</div>
                                <div class="text-lg font-weight-bold"><?= $total_jobs ?></div>
                            </div>
                            <div class="fa-3x text-white-25">
                                <i class="fas fa-briefcase"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-white-75 small">Active Jobs</div>
                                <div class="text-lg font-weight-bold"><?= $active_jobs ?></div>
                            </div>
                            <div class="fa-3x text-white-25">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-white-75 small">Draft Jobs</div>
                                <div class="text-lg font-weight-bold"><?= $draft_jobs ?></div>
                            </div>
                            <div class="fa-3x text-white-25">
                                <i class="fas fa-edit"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-secondary text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-white-75 small">Closed Jobs</div>
                                <div class="text-lg font-weight-bold"><?= $closed_jobs ?></div>
                            </div>
                            <div class="fa-3x text-white-25">
                                <i class="fas fa-times-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Job Postings Table -->
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">All Job Postings</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="jobPostingsTable">
                        <thead>
                            <tr>
                                <th>Job Title</th>
                                <th>Category</th>
                                <th>Location</th>
                                <th>Employment Type</th>
                                <th>Status</th>
                                <th>Posted By</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($job_postings)): ?>
                                <?php foreach ($job_postings as $job): ?>
                                    <tr>
                                        <td>
                                            <strong><?= htmlspecialchars($job->jp_title) ?></strong>
                                            <br>
                                            <small class="text-muted"><?= htmlspecialchars($job->position_name ?? 'N/A') ?></small>
                                        </td>
                                        <td><?= htmlspecialchars($job->category_name ?? 'N/A') ?></td>
                                        <td><?= htmlspecialchars($job->jp_location) ?></td>
                                        <td>
                                            <span class="badge bg-info"><?= htmlspecialchars($job->jp_employment_type) ?></span>
                                        </td>
                                        <td>
                                            <?php
                                            $status_class = '';
                                            switch($job->jp_status) {
                                                case 'Active':
                                                    $status_class = 'bg-success';
                                                    break;
                                                case 'Draft':
                                                    $status_class = 'bg-warning';
                                                    break;
                                                case 'Closed':
                                                    $status_class = 'bg-secondary';
                                                    break;
                                                default:
                                                    $status_class = 'bg-primary';
                                            }
                                            ?>
                                            <span class="badge <?= $status_class ?>"><?= htmlspecialchars($job->jp_status) ?></span>
                                        </td>
                                        <td><?= htmlspecialchars($job->jp_posted_by) ?></td>
                                        <td><?= date('M d, Y', strtotime($job->jp_created_at)) ?></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="<?= base_url('Job_posting/view/' . $job->jp_id) ?>" 
                                                   class="btn btn-sm btn-outline-primary" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="<?= base_url('Job_posting/edit/' . $job->jp_id) ?>" 
                                                   class="btn btn-sm btn-outline-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-sm btn-outline-danger" 
                                                        onclick="deleteJob(<?= $job->jp_id ?>)" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-briefcase fa-3x mb-3"></i>
                                            <h5>No Job Postings Found</h5>
                                            <p>Create your first job posting to get started.</p>
                                            <a href="<?= base_url('Job_posting/create') ?>" class="btn btn-primary">
                                                <i class="fas fa-plus"></i> Create Job Posting
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize DataTable if available
    if ($.fn.DataTable) {
        $('#jobPostingsTable').DataTable({
            "pageLength": 25,
            "order": [[ 6, "desc" ]], // Sort by created date
            "columnDefs": [
                { "orderable": false, "targets": 7 } // Disable sorting on actions column
            ]
        });
    }
});

function deleteJob(jobId) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Are you sure?',
            text: "This will delete the job posting and all associated data!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= base_url("Job_posting/delete/") ?>' + jobId;
            }
        });
    } else {
        if (confirm('Are you sure you want to delete this job posting?')) {
            window.location.href = '<?= base_url("Job_posting/delete/") ?>' + jobId;
        }
    }
}
</script>

<style>
.card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}

.card-header {
    background-color: #f8f9fc;
    border-bottom: 1px solid #e3e6f0;
    border-radius: 12px 12px 0 0;
}

.btn {
    border-radius: 8px;
}

.badge {
    font-size: 0.75em;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #5a5c69;
    font-size: 0.85rem;
}

.fa-3x {
    font-size: 2.5em;
}

.text-white-25 {
    color: rgba(255, 255, 255, 0.25) !important;
}

.text-white-75 {
    color: rgba(255, 255, 255, 0.75) !important;
}

.text-lg {
    font-size: 2rem;
}
</style>

<?php $this->load->view('templates/admin_footer'); ?>
