<?php
$data['page_title'] = 'Document Requirements';
$this->load->view('templates/admin_header', $data);
?>

<style>
.section-header {
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    color: white;
    padding: 16px 24px;
    border-radius: 12px;
    margin-bottom: 24px;
}
.doc-card {
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 16px;
}
</style>

<div class="section-header">
    <h2 class="mb-1"><i class="fas fa-folder-open me-2"></i>Document Requirements</h2>
    <p class="mb-0 opacity-90">Configure required documents for candidate onboarding</p>
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
        <h5 class="card-title mb-4"><i class="fas fa-list-check me-2 text-primary"></i>Required Documents Checklist</h5>
        
        <form action="<?= base_url('Setup/save_document_requirements') ?>" method="POST">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="doc-card">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" name="doc_nic" checked>
                            <label class="form-check-label fw-bold">National Identity Card (NIC)</label>
                        </div>
                        <small class="text-muted">Copy of valid NIC (both sides)</small>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="doc-card">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" name="doc_birth_cert" checked>
                            <label class="form-check-label fw-bold">Birth Certificate</label>
                        </div>
                        <small class="text-muted">Certified copy of birth certificate</small>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="doc-card">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" name="doc_education" checked>
                            <label class="form-check-label fw-bold">Educational Certificates</label>
                        </div>
                        <small class="text-muted">Degree, diploma, or relevant qualifications</small>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="doc-card">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" name="doc_experience">
                            <label class="form-check-label fw-bold">Experience Letters</label>
                        </div>
                        <small class="text-muted">Previous employment verification</small>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="doc-card">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" name="doc_police" checked>
                            <label class="form-check-label fw-bold">Police Report</label>
                        </div>
                        <small class="text-muted">Character certificate from police</small>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="doc-card">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" name="doc_medical">
                            <label class="form-check-label fw-bold">Medical Certificate</label>
                        </div>
                        <small class="text-muted">Health fitness certificate</small>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="doc-card">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" name="doc_passport">
                            <label class="form-check-label fw-bold">Passport Copy</label>
                        </div>
                        <small class="text-muted">For international travel (if applicable)</small>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="doc-card">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" name="doc_bank">
                            <label class="form-check-label fw-bold">Bank Account Details</label>
                        </div>
                        <small class="text-muted">For salary payments</small>
                    </div>
                </div>
                
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save Requirements
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php $this->load->view('templates/admin_footer'); ?>
