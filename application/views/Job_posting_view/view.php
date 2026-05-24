<?php
$data['page_title'] = 'Job Details';
$data['use_datatable'] = false;
$this->load->view('templates/admin_header', $data);
?>

<div class="content-area">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">
                    <i class="fas fa-briefcase me-2"></i>Job Details
                </h1>
                <p class="text-muted">View complete job posting information</p>
            </div>
            <div>
                <a href="<?= base_url('Job_posting') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
                <a href="<?= base_url('Job_posting/edit/' . $job->jp_id) ?>" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit Job
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Job Header Card -->
                <div class="card shadow mb-4">
                    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="mb-1" style="color: white;"><?= htmlspecialchars($job->jp_title) ?></h2>
                                <p class="mb-0" style="color: rgba(255,255,255,0.9);">
                                    <i class="fas fa-map-marker-alt me-2"></i><?= htmlspecialchars($job->jp_location) ?>
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-clock me-2"></i><?= htmlspecialchars($job->jp_employment_type) ?>
                                </p>
                            </div>
                            <div>
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
                                <span class="badge <?= $status_class ?>" style="font-size: 14px; padding: 8px 16px;">
                                    <?= htmlspecialchars($job->jp_status) ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label><i class="fas fa-folder me-2"></i>Category</label>
                                    <p><?= htmlspecialchars($job->category_name ?? 'N/A') ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label><i class="fas fa-user-tie me-2"></i>Position</label>
                                    <p><?= htmlspecialchars($job->position_name ?? 'N/A') ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label><i class="fas fa-building me-2"></i>Department</label>
                                    <p><?= htmlspecialchars($job->jp_department ?? 'N/A') ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label><i class="fas fa-calendar-alt me-2"></i>Expires On</label>
                                    <p><?= $job->jp_expires_at ? date('M d, Y', strtotime($job->jp_expires_at)) : 'No expiry date' ?></p>
                                </div>
                            </div>
                        </div>

                        <?php if ($job->jp_salary_min || $job->jp_salary_max): ?>
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="info-item">
                                    <label><i class="fas fa-dollar-sign me-2"></i>Salary Range</label>
                                    <p class="text-success fw-bold">
                                        <?php if ($job->jp_salary_min && $job->jp_salary_max): ?>
                                            $<?= number_format($job->jp_salary_min) ?> - $<?= number_format($job->jp_salary_max) ?>
                                        <?php elseif ($job->jp_salary_min): ?>
                                            From $<?= number_format($job->jp_salary_min) ?>
                                        <?php elseif ($job->jp_salary_max): ?>
                                            Up to $<?= number_format($job->jp_salary_max) ?>
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if ($job->jp_experience_min || $job->jp_experience_max): ?>
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="info-item">
                                    <label><i class="fas fa-chart-line me-2"></i>Experience Required</label>
                                    <p>
                                        <?php if ($job->jp_experience_min && $job->jp_experience_max): ?>
                                            <?= $job->jp_experience_min ?> - <?= $job->jp_experience_max ?> years
                                        <?php elseif ($job->jp_experience_min): ?>
                                            Minimum <?= $job->jp_experience_min ?> years
                                        <?php elseif ($job->jp_experience_max): ?>
                                            Up to <?= $job->jp_experience_max ?> years
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Job Description -->
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-align-left me-2"></i>Job Description</h5>
                    </div>
                    <div class="card-body">
                        <div class="job-content">
                            <?= nl2br(htmlspecialchars($job->jp_description)) ?>
                        </div>
                    </div>
                </div>

                <!-- Responsibilities -->
                <?php if (!empty($job->jp_responsibilities)): ?>
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-tasks me-2"></i>Key Responsibilities</h5>
                    </div>
                    <div class="card-body">
                        <div class="job-content">
                            <?= nl2br(htmlspecialchars($job->jp_responsibilities)) ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Requirements -->
                <?php if (!empty($job->jp_requirements)): ?>
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-check-circle me-2"></i>Requirements</h5>
                    </div>
                    <div class="card-body">
                        <div class="job-content">
                            <?= nl2br(htmlspecialchars($job->jp_requirements)) ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Job Information -->
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Job Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="info-item mb-3">
                            <label><i class="fas fa-user me-2"></i>Posted By</label>
                            <p><?= htmlspecialchars($job->jp_posted_by) ?></p>
                        </div>
                        <div class="info-item mb-3">
                            <label><i class="fas fa-calendar-plus me-2"></i>Created</label>
                            <p><?= date('M d, Y H:i', strtotime($job->jp_created_at)) ?></p>
                        </div>
                        <?php if (isset($job->jp_updated_at) && $job->jp_updated_at): ?>
                        <div class="info-item mb-3">
                            <label><i class="fas fa-calendar-check me-2"></i>Last Updated</label>
                            <p><?= date('M d, Y H:i', strtotime($job->jp_updated_at)) ?></p>
                        </div>
                        <?php endif; ?>
                        <div class="info-item">
                            <label><i class="fas fa-hashtag me-2"></i>Job ID</label>
                            <p><?= $job->jp_id ?></p>
                        </div>
                    </div>
                </div>

                <!-- Posting History -->
                <?php if (!empty($posting_history)): ?>
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-history me-2"></i>Posting History</h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <?php foreach ($posting_history as $history): ?>
                                <div class="timeline-item mb-3">
                                    <div class="d-flex align-items-start">
                                        <div class="timeline-marker me-3">
                                            <?php if ($history->status == 'Posted'): ?>
                                                <i class="fas fa-check-circle text-success fa-lg"></i>
                                            <?php else: ?>
                                                <i class="fas fa-times-circle text-danger fa-lg"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div class="flex-grow-1">
                                            <strong><?= htmlspecialchars($history->platform_name) ?></strong>
                                            <br>
                                            <span class="badge bg-<?= $history->status == 'Posted' ? 'success' : 'danger' ?>">
                                                <?= htmlspecialchars($history->status) ?>
                                            </span>
                                            <br>
                                            <small class="text-muted">
                                                <?= date('M d, Y H:i', strtotime($history->posted_at)) ?>
                                            </small>
                                            <?php if ($history->error_message): ?>
                                                <br>
                                                <small class="text-danger"><?= htmlspecialchars($history->error_message) ?></small>
                                            <?php endif; ?>
                                            <?php if ($history->external_job_id): ?>
                                                <br>
                                                <small class="text-muted">ID: <?= htmlspecialchars($history->external_job_id) ?></small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-history me-2"></i>Posting History</h5>
                    </div>
                    <div class="card-body text-center text-muted">
                        <i class="fas fa-inbox fa-3x mb-3"></i>
                        <p>This job hasn't been posted to any platforms yet.</p>
                        <a href="<?= base_url('Job_posting/edit/' . $job->jp_id) ?>" class="btn btn-sm btn-primary">
                            <i class="fas fa-share-alt"></i> Post to Platforms
                        </a>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Quick Actions -->
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="<?= base_url('Job_posting/edit/' . $job->jp_id) ?>" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit Job
                            </a>
                            <?php if ($job->jp_status == 'Draft'): ?>
                            <button onclick="changeStatus(<?= $job->jp_id ?>, 'Active')" class="btn btn-success">
                                <i class="fas fa-check"></i> Publish Job
                            </button>
                            <?php elseif ($job->jp_status == 'Active'): ?>
                            <button onclick="changeStatus(<?= $job->jp_id ?>, 'Closed')" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Close Job
                            </button>
                            <?php endif; ?>
                            <button onclick="deleteJob(<?= $job->jp_id ?>)" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Delete Job
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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

.info-item {
    padding: 12px;
    background: #f8f9fa;
    border-radius: 8px;
    border-left: 3px solid #667eea;
}

.info-item label {
    font-weight: 600;
    color: #666;
    font-size: 13px;
    margin-bottom: 5px;
    display: block;
}

.info-item p {
    margin: 0;
    color: #333;
    font-size: 14px;
}

.job-content {
    line-height: 1.8;
    color: #333;
    font-size: 15px;
}

.timeline-item {
    position: relative;
}

.timeline-marker {
    font-size: 1.2rem;
}

.btn {
    border-radius: 8px;
}

.badge {
    font-size: 0.75em;
}
</style>

<script>
function changeStatus(jobId, newStatus) {
    if (confirm('Are you sure you want to change the job status to "' + newStatus + '"?')) {
        // Create a form and submit
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= base_url('Job_posting/change_status/') ?>' + jobId;
        
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'status';
        input.value = newStatus;
        
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    }
}

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

<?php $this->load->view('templates/admin_footer'); ?>
