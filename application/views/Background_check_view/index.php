<?php $this->load->view('templates/admin_header'); ?>

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="page-header mb-4">
            <h1 class="h2 mb-2">
                <i class="fas fa-shield-alt text-danger"></i> Background Check Services
            </h1>
            <p class="text-muted">Manage background check integrations for candidate verification</p>
        </div>
        
        <?php if(isset($error_message)): ?>
            <div class="alert alert-warning alert-dismissible fade show">
                <i class="fas fa-exclamation-triangle"></i> <?= $error_message ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <i class="fas fa-shield-alt fa-3x text-danger"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="card-title mb-0">Checkr</h5>
                                <span class="badge bg-secondary">Not Configured</span>
                            </div>
                        </div>
                        <p class="card-text">FCRA-compliant background screening with real-time updates</p>
                        <a href="<?= base_url('Background_check/configure_checkr') ?>" class="btn btn-danger btn-sm">
                            <i class="fas fa-cog"></i> Configure
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle fa-3x text-warning"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="card-title mb-0">Sterling</h5>
                                <span class="badge bg-secondary">Not Configured</span>
                            </div>
                        </div>
                        <p class="card-text">Professional background verification and employment history</p>
                        <a href="<?= base_url('Background_check/configure_sterling') ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-cog"></i> Configure
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <i class="fas fa-user-check fa-3x text-success"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="card-title mb-0">Accurate</h5>
                                <span class="badge bg-secondary">Not Configured</span>
                            </div>
                        </div>
                        <p class="card-text">Fast background checks with quick turnaround time</p>
                        <a href="<?= base_url('Background_check/configure_accurate') ?>" class="btn btn-success btn-sm">
                            <i class="fas fa-cog"></i> Configure
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('templates/admin_footer'); ?>
