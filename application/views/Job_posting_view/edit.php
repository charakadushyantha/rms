<?php
$data['page_title'] = 'Edit Job Posting';
$data['use_datatable'] = false;
$this->load->view('templates/admin_header', $data);
?>

<div class="content-area">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">
                    <i class="fas fa-edit me-2"></i>Edit Job Posting
                </h1>
                <p class="text-muted">Update job details and manage platform postings</p>
            </div>
            <div>
                <a href="<?= base_url('Job_posting') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>

        <!-- Edit Form -->
        <form action="<?= base_url('Job_posting/update/' . $job->jp_id) ?>" method="POST" id="editJobForm">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <!-- Basic Information -->
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Basic Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="jp_title" class="form-label">Job Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="jp_title" name="jp_title" 
                                       value="<?= htmlspecialchars($job->jp_title) ?>" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="jp_category_id" class="form-label">Category</label>
                                    <select class="form-select" id="jp_category_id" name="jp_category_id">
                                        <option value="">Select Category</option>
                                        <?php if (!empty($categories)): ?>
                                            <?php foreach ($categories as $category): ?>
                                                <option value="<?= $category->id ?>" 
                                                    <?= $job->jp_category_id == $category->id ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($category->category_name) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="jp_position_id" class="form-label">Position</label>
                                    <select class="form-select" id="jp_position_id" name="jp_position_id">
                                        <option value="">Select Position</option>
                                        <?php if (!empty($positions)): ?>
                                            <?php foreach ($positions as $position): ?>
                                                <option value="<?= $position->id ?>" 
                                                    <?= $job->jp_position_id == $position->id ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($position->position_name) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="jp_location" class="form-label">Location <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="jp_location" name="jp_location" 
                                           value="<?= htmlspecialchars($job->jp_location) ?>" required 
                                           placeholder="e.g., San Francisco, CA">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="jp_employment_type" class="form-label">Employment Type <span class="text-danger">*</span></label>
                                    <select class="form-select" id="jp_employment_type" name="jp_employment_type" required>
                                        <option value="">Select Type</option>
                                        <option value="Full-time" <?= $job->jp_employment_type == 'Full-time' ? 'selected' : '' ?>>Full-time</option>
                                        <option value="Part-time" <?= $job->jp_employment_type == 'Part-time' ? 'selected' : '' ?>>Part-time</option>
                                        <option value="Contract" <?= $job->jp_employment_type == 'Contract' ? 'selected' : '' ?>>Contract</option>
                                        <option value="Temporary" <?= $job->jp_employment_type == 'Temporary' ? 'selected' : '' ?>>Temporary</option>
                                        <option value="Internship" <?= $job->jp_employment_type == 'Internship' ? 'selected' : '' ?>>Internship</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="jp_department" class="form-label">Department</label>
                                    <input type="text" class="form-control" id="jp_department" name="jp_department" 
                                           value="<?= htmlspecialchars($job->jp_department ?? '') ?>" 
                                           placeholder="e.g., Engineering">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="jp_expires_at" class="form-label">Expiry Date</label>
                                    <input type="date" class="form-control" id="jp_expires_at" name="jp_expires_at" 
                                           value="<?= $job->jp_expires_at ? date('Y-m-d', strtotime($job->jp_expires_at)) : '' ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Job Description -->
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-align-left me-2"></i>Job Description</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="jp_description" class="form-label">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="jp_description" name="jp_description" 
                                          rows="6" required><?= htmlspecialchars($job->jp_description) ?></textarea>
                                <small class="text-muted">Provide a detailed description of the role</small>
                            </div>

                            <div class="mb-3">
                                <label for="jp_responsibilities" class="form-label">Responsibilities</label>
                                <textarea class="form-control" id="jp_responsibilities" name="jp_responsibilities" 
                                          rows="5"><?= htmlspecialchars($job->jp_responsibilities ?? '') ?></textarea>
                                <small class="text-muted">List key responsibilities (one per line)</small>
                            </div>

                            <div class="mb-3">
                                <label for="jp_requirements" class="form-label">Requirements</label>
                                <textarea class="form-control" id="jp_requirements" name="jp_requirements" 
                                          rows="5"><?= htmlspecialchars($job->jp_requirements ?? '') ?></textarea>
                                <small class="text-muted">List required qualifications and skills</small>
                            </div>
                        </div>
                    </div>

                    <!-- Compensation & Experience -->
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-dollar-sign me-2"></i>Compensation & Experience</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="jp_salary_min" class="form-label">Minimum Salary</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control" id="jp_salary_min" name="jp_salary_min" 
                                               value="<?= $job->jp_salary_min ?? '' ?>" placeholder="50000">
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="jp_salary_max" class="form-label">Maximum Salary</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control" id="jp_salary_max" name="jp_salary_max" 
                                               value="<?= $job->jp_salary_max ?? '' ?>" placeholder="80000">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="jp_experience_min" class="form-label">Minimum Experience (years)</label>
                                    <input type="number" class="form-control" id="jp_experience_min" name="jp_experience_min" 
                                           value="<?= $job->jp_experience_min ?? '' ?>" placeholder="2" min="0">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="jp_experience_max" class="form-label">Maximum Experience (years)</label>
                                    <input type="number" class="form-control" id="jp_experience_max" name="jp_experience_max" 
                                           value="<?= $job->jp_experience_max ?? '' ?>" placeholder="5" min="0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Status & Actions -->
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-cog me-2"></i>Status & Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="jp_status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select" id="jp_status" name="jp_status" required>
                                    <option value="Draft" <?= $job->jp_status == 'Draft' ? 'selected' : '' ?>>Draft</option>
                                    <option value="Active" <?= $job->jp_status == 'Active' ? 'selected' : '' ?>>Active</option>
                                    <option value="Closed" <?= $job->jp_status == 'Closed' ? 'selected' : '' ?>>Closed</option>
                                </select>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Job Posting
                                </button>
                                <a href="<?= base_url('Job_posting') ?>" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Posting Platforms -->
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-share-alt me-2"></i>Posting Platforms</h5>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($platforms)): ?>
                                <?php foreach ($platforms as $platform): ?>
                                    <?php
                                    // Check if already posted to this platform
                                    $is_posted = false;
                                    if (!empty($posting_history)) {
                                        foreach ($posting_history as $history) {
                                            if ($history->platform_id == $platform->platform_id && $history->status == 'Posted') {
                                                $is_posted = true;
                                                break;
                                            }
                                        }
                                    }
                                    ?>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="platforms[]" 
                                               value="<?= $platform->platform_id ?>" 
                                               id="platform_<?= $platform->platform_id ?>"
                                               <?= $is_posted ? 'checked disabled' : '' ?>>
                                        <label class="form-check-label" for="platform_<?= $platform->platform_id ?>">
                                            <?= htmlspecialchars($platform->platform_name) ?>
                                            <?php if ($is_posted): ?>
                                                <span class="badge bg-success ms-2">Posted</span>
                                            <?php endif; ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                                <small class="text-muted">Select platforms to post this job (already posted platforms are disabled)</small>
                            <?php else: ?>
                                <p class="text-muted mb-0">No platforms configured. <a href="<?= base_url('Job_posting/platforms') ?>">Configure platforms</a></p>
                            <?php endif; ?>
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
                                                    <i class="fas fa-check-circle text-success"></i>
                                                <?php else: ?>
                                                    <i class="fas fa-times-circle text-danger"></i>
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
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Job Info -->
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-info me-2"></i>Job Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <small class="text-muted">Posted By:</small>
                                <br>
                                <strong><?= htmlspecialchars($job->jp_posted_by) ?></strong>
                            </div>
                            <div class="mb-2">
                                <small class="text-muted">Created:</small>
                                <br>
                                <strong><?= date('M d, Y H:i', strtotime($job->jp_created_at)) ?></strong>
                            </div>
                            <?php if (isset($job->jp_updated_at) && $job->jp_updated_at): ?>
                            <div class="mb-2">
                                <small class="text-muted">Last Updated:</small>
                                <br>
                                <strong><?= date('M d, Y H:i', strtotime($job->jp_updated_at)) ?></strong>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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

.timeline-item {
    position: relative;
}

.timeline-marker {
    font-size: 1.2rem;
}

.form-label {
    font-weight: 600;
    color: #5a5c69;
    font-size: 0.9rem;
}

.btn {
    border-radius: 8px;
}
</style>

<script>
$(document).ready(function() {
    // Form validation
    $('#editJobForm').on('submit', function(e) {
        var title = $('#jp_title').val().trim();
        var description = $('#jp_description').val().trim();
        var location = $('#jp_location').val().trim();
        var employmentType = $('#jp_employment_type').val();
        var status = $('#jp_status').val();

        if (!title || !description || !location || !employmentType || !status) {
            e.preventDefault();
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Please fill in all required fields'
                });
            } else {
                alert('Please fill in all required fields');
            }
            return false;
        }
    });
});
</script>

<?php $this->load->view('templates/admin_footer'); ?>
