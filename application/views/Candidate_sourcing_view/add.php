<?php $this->load->view('templates/admin_header'); ?>

<div class="content-area">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Add Candidate</h1>
                <p class="text-muted">Add a new candidate to your talent database</p>
            </div>
            <a href="<?= base_url('Candidate_sourcing') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-header">
                        <h5 class="mb-0">Candidate Information</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('Candidate_sourcing/save') ?>" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="first_name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="last_name" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="tel" class="form-control" name="phone">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Current Title</label>
                                    <input type="text" class="form-control" name="current_title">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Current Company</label>
                                    <input type="text" class="form-control" name="current_company">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Location</label>
                                    <input type="text" class="form-control" name="location" placeholder="City, State">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Total Experience (Years)</label>
                                    <input type="number" class="form-control" name="total_experience" min="0">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Notice Period</label>
                                    <input type="text" class="form-control" name="notice_period" placeholder="e.g., 30 days">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Skills (comma separated)</label>
                                <input type="text" class="form-control" name="skills" 
                                       placeholder="PHP, JavaScript, Python, React...">
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Expected Salary</label>
                                    <input type="number" class="form-control" name="expected_salary" step="0.01">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Source <span class="text-danger">*</span></label>
                                    <select class="form-select" name="source" required>
                                        <option value="">Select Source</option>
                                        <?php foreach ($sources as $source): ?>
                                            <option value="<?= $source->source_name ?>"><?= $source->source_name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">LinkedIn URL</label>
                                    <input type="url" class="form-control" name="linkedin_url">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">GitHub URL</label>
                                    <input type="url" class="form-control" name="github_url">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Portfolio URL</label>
                                    <input type="url" class="form-control" name="portfolio_url">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Resume/CV</label>
                                <input type="file" class="form-control" name="resume" accept=".pdf,.doc,.docx">
                                <small class="form-text text-muted">Accepted: PDF, DOC, DOCX (Max 5MB)</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Summary/Notes</label>
                                <textarea class="form-control" name="summary" rows="4" 
                                          placeholder="Brief summary about the candidate..."></textarea>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save"></i> Save Candidate
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-lightbulb"></i> Tips</h5>
                    </div>
                    <div class="card-body">
                        <ul class="small mb-0">
                            <li>Fill in as much information as possible</li>
                            <li>Add relevant skills for better matching</li>
                            <li>Upload resume for automatic parsing</li>
                            <li>Include social profiles for verification</li>
                            <li>Track the source for analytics</li>
                        </ul>
                    </div>
                </div>

                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-info-circle"></i> Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <p class="small">After adding the candidate, you can:</p>
                        <ul class="small mb-0">
                            <li>Add to talent pools</li>
                            <li>Send engagement emails</li>
                            <li>Schedule interviews</li>
                            <li>Track communication history</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('templates/admin_footer'); ?>
