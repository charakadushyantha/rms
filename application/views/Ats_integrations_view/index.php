<?php $this->load->view('templates/admin_header'); ?>

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="page-header mb-4">
            <h1 class="h2 mb-2">
                <i class="fas fa-sync-alt text-info"></i> ATS Integrations
            </h1>
            <p class="text-muted">Manage ATS platform integrations for seamless data synchronization</p>
        </div>
        
        <?php if(isset($error_message)): ?>
            <div class="alert alert-warning alert-dismissible fade show">
                <i class="fas fa-exclamation-triangle"></i> <?= $error_message ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <i class="fas fa-sync-alt fa-3x text-success"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="card-title mb-0">Greenhouse</h5>
                                <span class="badge bg-secondary">Not Configured</span>
                            </div>
                        </div>
                        <p class="card-text">Full ATS sync with bidirectional data synchronization</p>
                        <a href="<?= base_url('Ats_integrations/configure_greenhouse') ?>" class="btn btn-success btn-sm">
                            <i class="fas fa-cog"></i> Configure
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <i class="fas fa-link fa-3x text-primary"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="card-title mb-0">Lever</h5>
                                <span class="badge bg-secondary">Not Configured</span>
                            </div>
                        </div>
                        <p class="card-text">Candidate management with real-time updates</p>
                        <a href="<?= base_url('Ats_integrations/configure_lever') ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-cog"></i> Configure
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <i class="fas fa-building fa-3x text-info"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="card-title mb-0">Workday</h5>
                                <span class="badge bg-secondary">Not Configured</span>
                            </div>
                        </div>
                        <p class="card-text">HRIS integration for employee onboarding</p>
                        <a href="<?= base_url('Ats_integrations/configure_workday') ?>" class="btn btn-info btn-sm text-white">
                            <i class="fas fa-cog"></i> Configure
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <i class="fas fa-leaf fa-3x text-success"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="card-title mb-0">BambooHR</h5>
                                <span class="badge bg-secondary">Not Configured</span>
                            </div>
                        </div>
                        <p class="card-text">HR system sync with profile and document transfer</p>
                        <a href="<?= base_url('Ats_integrations/configure_bamboohr') ?>" class="btn btn-success btn-sm">
                            <i class="fas fa-cog"></i> Configure
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('templates/admin_footer'); ?>
