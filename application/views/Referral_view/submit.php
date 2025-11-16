<?php $this->load->view('templates/admin_header'); ?>

<div class="content-area">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Submit Referral</h1>
                <p class="text-muted">Refer a candidate for an open position</p>
            </div>
            <a href="<?= base_url('Referral') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        <!-- Referral Form -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-header">
                        <h5 class="mb-0">Candidate Information</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('Referral/save') ?>" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Candidate Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="candidate_name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="candidate_email" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" name="candidate_phone">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Position <span class="text-danger">*</span></label>
                                    <select class="form-select" name="position_id" id="position_select" required>
                                        <option value="">Select Position</option>
                                        <?php if (!empty($positions)): ?>
                                            <?php foreach ($positions as $position): ?>
                                                <option value="<?= $position->id ?>" data-name="<?= htmlspecialchars($position->position_name) ?>">
                                                    <?= htmlspecialchars($position->position_name) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                        <option value="0" data-name="Other">Other</option>
                                    </select>
                                    <input type="hidden" name="position_name" id="position_name">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Resume/CV</label>
                                <input type="file" class="form-control" name="candidate_resume" accept=".pdf,.doc,.docx">
                                <small class="form-text text-muted">Accepted formats: PDF, DOC, DOCX (Max 5MB)</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Additional Notes</label>
                                <textarea class="form-control" name="notes" rows="4" 
                                          placeholder="Why do you think this candidate would be a good fit?"></textarea>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-paper-plane"></i> Submit Referral
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Info Sidebar -->
            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-info-circle"></i> Referral Guidelines</h5>
                    </div>
                    <div class="card-body">
                        <h6>Eligibility Criteria:</h6>
                        <ul class="small">
                            <li>Candidate must not be currently employed by the company</li>
                            <li>Candidate must meet minimum qualifications for the position</li>
                            <li>You cannot refer yourself</li>
                            <li>Candidate must stay employed for 90 days for bonus eligibility</li>
                        </ul>

                        <h6 class="mt-3">Bonus Structure:</h6>
                        <ul class="small">
                            <li>Entry Level: $500</li>
                            <li>Mid Level: $1,000</li>
                            <li>Senior Level: $2,000</li>
                            <li>Executive: $5,000</li>
                        </ul>

                        <h6 class="mt-3">Process Timeline:</h6>
                        <ol class="small">
                            <li>Submit referral</li>
                            <li>HR reviews application</li>
                            <li>Interview process</li>
                            <li>Offer extended</li>
                            <li>Bonus paid after 90 days</li>
                        </ol>
                    </div>
                </div>

                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-lightbulb"></i> Tips for Success</h5>
                    </div>
                    <div class="card-body">
                        <ul class="small mb-0">
                            <li>Ensure candidate's skills match the job requirements</li>
                            <li>Provide detailed notes about the candidate</li>
                            <li>Include an updated resume</li>
                            <li>Follow up with HR after submission</li>
                            <li>Keep candidate informed of progress</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('position_select').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const positionName = selectedOption.getAttribute('data-name');
    document.getElementById('position_name').value = positionName;
});
</script>

<?php $this->load->view('templates/admin_footer'); ?>
