<?php $this->load->view('templates/admin_header'); ?>

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="page-header mb-4">
            <h1 class="h2 mb-2">
                <i class="fas fa-video text-primary"></i> Video Platform Integrations
            </h1>
            <p class="text-muted">Manage video conferencing integrations for interviews</p>
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
                                <i class="fas fa-video fa-3x text-primary"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="card-title mb-0">Zoom</h5>
                                <span class="badge bg-secondary">Not Configured</span>
                            </div>
                        </div>
                        <p class="card-text">Video interviews with recording, waiting room, and attendance tracking</p>
                        <a href="<?= base_url('Video_integrations/configure_zoom') ?>" class="btn btn-primary btn-sm">
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
                                <i class="fab fa-microsoft fa-3x text-info"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="card-title mb-0">Microsoft Teams</h5>
                                <span class="badge bg-secondary">Not Configured</span>
                            </div>
                        </div>
                        <p class="card-text">Enterprise meetings with Outlook sync and lobby control</p>
                        <a href="<?= base_url('Video_integrations/configure_teams') ?>" class="btn btn-info btn-sm text-white">
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
                                <i class="fab fa-google fa-3x text-danger"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="card-title mb-0">Google Meet</h5>
                                <span class="badge bg-secondary">Not Configured</span>
                            </div>
                        </div>
                        <p class="card-text">Simple video calls with Google Calendar integration</p>
                        <a href="<?= base_url('Video_integrations/configure_meet') ?>" class="btn btn-danger btn-sm">
                            <i class="fas fa-cog"></i> Configure
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('templates/admin_footer'); ?>
