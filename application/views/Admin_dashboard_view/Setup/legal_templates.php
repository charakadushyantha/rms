<?php
$data['page_title'] = 'Legal Templates';
$this->load->view('templates/admin_header', $data);
?>

<style>
.section-header {
    background: linear-gradient(135deg, #858796 0%, #60616f 100%);
    color: white;
    padding: 16px 24px;
    border-radius: 12px;
    margin-bottom: 24px;
}
.template-card {
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 16px;
    transition: all 0.3s;
}
.template-card:hover {
    border-color: #667eea;
    background: #f7fafc;
}
</style>

<div class="section-header">
    <h2 class="mb-1"><i class="fas fa-file-contract me-2"></i>Legal Templates</h2>
    <p class="mb-0 opacity-90">Manage employment contracts and legal documents</p>
</div>

<!-- Flash Messages -->
<?php if($this->session->flashdata('success_msg')): ?>
<div class="alert alert-success alert-dismissible fade show">
    <i class="fas fa-check-circle me-2"></i>
    <?= $this->session->flashdata('success_msg') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="row g-3">
    <div class="col-md-6">
        <div class="template-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h5 class="mb-1"><i class="fas fa-file-signature me-2 text-primary"></i>Employment Contract</h5>
                    <p class="text-muted small mb-0">Standard employment agreement template</p>
                </div>
                <span class="badge bg-success">Active</span>
            </div>
            <div class="mb-3">
                <small class="text-muted">Last updated: 2 weeks ago</small>
            </div>
            <div class="btn-group btn-group-sm">
                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editTemplate1">
                    <i class="fas fa-edit me-1"></i>Edit
                </button>
                <button class="btn btn-outline-secondary">
                    <i class="fas fa-eye me-1"></i>Preview
                </button>
                <button class="btn btn-outline-info">
                    <i class="fas fa-download me-1"></i>Download
                </button>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="template-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h5 class="mb-1"><i class="fas fa-file-alt me-2 text-success"></i>Offer Letter</h5>
                    <p class="text-muted small mb-0">Job offer letter template</p>
                </div>
                <span class="badge bg-success">Active</span>
            </div>
            <div class="mb-3">
                <small class="text-muted">Last updated: 1 month ago</small>
            </div>
            <div class="btn-group btn-group-sm">
                <button class="btn btn-outline-primary">
                    <i class="fas fa-edit me-1"></i>Edit
                </button>
                <button class="btn btn-outline-secondary">
                    <i class="fas fa-eye me-1"></i>Preview
                </button>
                <button class="btn btn-outline-info">
                    <i class="fas fa-download me-1"></i>Download
                </button>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="template-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h5 class="mb-1"><i class="fas fa-user-shield me-2 text-warning"></i>NDA Agreement</h5>
                    <p class="text-muted small mb-0">Non-disclosure agreement</p>
                </div>
                <span class="badge bg-success">Active</span>
            </div>
            <div class="mb-3">
                <small class="text-muted">Last updated: 3 months ago</small>
            </div>
            <div class="btn-group btn-group-sm">
                <button class="btn btn-outline-primary">
                    <i class="fas fa-edit me-1"></i>Edit
                </button>
                <button class="btn btn-outline-secondary">
                    <i class="fas fa-eye me-1"></i>Preview
                </button>
                <button class="btn btn-outline-info">
                    <i class="fas fa-download me-1"></i>Download
                </button>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="template-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h5 class="mb-1"><i class="fas fa-handshake me-2 text-info"></i>Termination Letter</h5>
                    <p class="text-muted small mb-0">Employment termination template</p>
                </div>
                <span class="badge bg-secondary">Draft</span>
            </div>
            <div class="mb-3">
                <small class="text-muted">Last updated: 1 week ago</small>
            </div>
            <div class="btn-group btn-group-sm">
                <button class="btn btn-outline-primary">
                    <i class="fas fa-edit me-1"></i>Edit
                </button>
                <button class="btn btn-outline-secondary">
                    <i class="fas fa-eye me-1"></i>Preview
                </button>
                <button class="btn btn-outline-info">
                    <i class="fas fa-download me-1"></i>Download
                </button>
            </div>
        </div>
    </div>
    
    <div class="col-12">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTemplate">
            <i class="fas fa-plus me-2"></i>Add New Template
        </button>
    </div>
</div>

<?php $this->load->view('templates/admin_footer'); ?>
