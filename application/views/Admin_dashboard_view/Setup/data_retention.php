<?php
$data['page_title'] = 'Data Retention';
$this->load->view('templates/admin_header', $data);
?>

<style>
.section-header {
    background: linear-gradient(135deg, #e74a3b 0%, #c92a2a 100%);
    color: white;
    padding: 16px 24px;
    border-radius: 12px;
    margin-bottom: 24px;
}
</style>

<div class="section-header">
    <h2 class="mb-1"><i class="fas fa-archive me-2"></i>Data Retention Policies</h2>
    <p class="mb-0 opacity-90">Configure how long data is retained in the system</p>
</div>

<!-- Flash Messages -->
<?php if($this->session->flashdata('success_msg')): ?>
<div class="alert alert-success alert-dismissible fade show">
    <i class="fas fa-check-circle me-2"></i>
    <?= $this->session->flashdata('success_msg') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="<?= base_url('Setup/save_data_retention') ?>" method="POST">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card border-primary">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0"><i class="fas fa-users me-2"></i>Candidate Data</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Rejected Candidates</label>
                                <select class="form-select" name="retention_rejected">
                                    <option value="30">30 days</option>
                                    <option value="90">90 days</option>
                                    <option value="180" selected>6 months</option>
                                    <option value="365">1 year</option>
                                    <option value="730">2 years</option>
                                    <option value="-1">Keep forever</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Inactive Candidates</label>
                                <select class="form-select" name="retention_inactive">
                                    <option value="180">6 months</option>
                                    <option value="365" selected>1 year</option>
                                    <option value="730">2 years</option>
                                    <option value="1095">3 years</option>
                                    <option value="-1">Keep forever</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card border-success">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0"><i class="fas fa-briefcase me-2"></i>Job Postings</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Closed Job Postings</label>
                                <select class="form-select" name="retention_jobs">
                                    <option value="90">90 days</option>
                                    <option value="180">6 months</option>
                                    <option value="365" selected>1 year</option>
                                    <option value="730">2 years</option>
                                    <option value="-1">Keep forever</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Draft Job Postings</label>
                                <select class="form-select" name="retention_drafts">
                                    <option value="30">30 days</option>
                                    <option value="90" selected>90 days</option>
                                    <option value="180">6 months</option>
                                    <option value="-1">Keep forever</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card border-warning">
                        <div class="card-header bg-warning text-dark">
                            <h6 class="mb-0"><i class="fas fa-file-alt me-2"></i>Documents & Files</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Uploaded Documents</label>
                                <select class="form-select" name="retention_documents">
                                    <option value="365">1 year</option>
                                    <option value="730">2 years</option>
                                    <option value="1095" selected>3 years</option>
                                    <option value="1825">5 years</option>
                                    <option value="-1">Keep forever</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card border-info">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0"><i class="fas fa-history me-2"></i>Activity Logs</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">System Logs</label>
                                <select class="form-select" name="retention_logs">
                                    <option value="30">30 days</option>
                                    <option value="90" selected>90 days</option>
                                    <option value="180">6 months</option>
                                    <option value="365">1 year</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Warning:</strong> Data will be permanently deleted after the retention period expires. This action cannot be undone.
                    </div>
                </div>
                
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i>Save Retention Policies
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php $this->load->view('templates/admin_footer'); ?>
