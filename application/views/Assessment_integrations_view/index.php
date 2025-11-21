<?php $this->load->view('templates/admin_header'); ?>

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="page-header mb-4">
            <h1 class="h2 mb-2">
                <i class="fas fa-code text-success"></i> Assessment Tool Integrations
            </h1>
            <p class="text-muted">Manage technical assessment platforms for candidate evaluation</p>
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
                                <i class="fas fa-code fa-3x text-success"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="card-title mb-0">HackerRank</h5>
                                <span class="badge bg-secondary">Not Configured</span>
                            </div>
                        </div>
                        <p class="card-text">Send coding tests and technical assessments with anti-cheating features</p>
                        <a href="<?= base_url('Assessment_integrations/configure_hackerrank') ?>" class="btn btn-success btn-sm">
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
                                <i class="fas fa-laptop-code fa-3x text-primary"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="card-title mb-0">Codility</h5>
                                <span class="badge bg-secondary">Not Configured</span>
                            </div>
                        </div>
                        <p class="card-text">Programming challenges in 50+ languages with plagiarism detection</p>
                        <a href="<?= base_url('Assessment_integrations/configure_codility') ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-cog"></i> Configure
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('templates/admin_footer'); ?>
