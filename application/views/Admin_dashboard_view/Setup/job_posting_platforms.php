<?php $this->load->view('templates/admin_header'); ?>

<div class="content-area">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Job Posting Platforms</h1>
                <p class="text-muted">Configure API credentials for job board integrations</p>
            </div>
            <a href="<?= base_url('Setup') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Setup
            </a>
        </div>

        <!-- Flash Messages -->
        <?php if($this->session->flashdata('success_msg')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> <?= $this->session->flashdata('success_msg') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if($this->session->flashdata('error_msg')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> <?= $this->session->flashdata('error_msg') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Platform Cards -->
        <div class="row">
            <?php if (!empty($platforms)): ?>
                <?php foreach ($platforms as $platform): ?>
                    <div class="col-lg-6 col-xl-4 mb-4">
                        <div class="card h-100 shadow-sm platform-card">
                            <div class="card-header bg-white border-bottom-0">
                                <div class="d-flex align-items-center">
                                    <div class="platform-logo me-3">
                                        <?php
                                        $icons = [
                                            'linkedin' => 'fab fa-linkedin',
                                            'indeed' => 'fas fa-search',
                                            'glassdoor' => 'fas fa-building',
                                            'monster' => 'fas fa-monster',
                                            'ziprecruiter' => 'fas fa-zip',
                                            'careerbuilder' => 'fas fa-hammer'
                                        ];
                                        $icon = $icons[$platform->platform_key] ?? 'fas fa-briefcase';
                                        ?>
                                        <i class="<?= $icon ?> fa-2x text-primary"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0"><?= htmlspecialchars($platform->platform_name) ?></h5>
                                        <small class="text-muted"><?= htmlspecialchars($platform->platform_key) ?></small>
                                    </div>
                                    <div class="ms-auto">
                                        <?php if ($platform->credentials_enabled): ?>
                                            <span class="badge bg-success">Configured</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning">Not Configured</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="<?= base_url('Setup/save_job_platform_credentials') ?>" method="post">
                                    <input type="hidden" name="platform_id" value="<?= $platform->platform_id ?>">
                                    
                                    <div class="mb-3">
                                        <label class="form-label">API Key</label>
                                        <input type="text" class="form-control" name="api_key" 
                                               placeholder="Enter API Key" required>
                                        <small class="form-text text-muted">Get this from <?= $platform->platform_name ?> developer portal</small>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">API Secret</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" name="api_secret" 
                                                   placeholder="Enter API Secret">
                                            <button class="btn btn-outline-secondary" type="button" 
                                                    onclick="togglePassword(this)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Access Token (Optional)</label>
                                        <textarea class="form-control" name="access_token" rows="3" 
                                                  placeholder="Paste access token here"></textarea>
                                        <small class="form-text text-muted">Required for OAuth-based platforms</small>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="is_enabled" 
                                                   id="enabled-<?= $platform->platform_id ?>">
                                            <label class="form-check-label" for="enabled-<?= $platform->platform_id ?>">
                                                Enable this platform
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <?php if (isset($platform->last_sync) && $platform->last_sync): ?>
                                        <div class="alert alert-info mb-3">
                                            <small><i class="fas fa-sync"></i> Last synced: <?= date('M d, Y H:i', strtotime($platform->last_sync)) ?></small>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Save Configuration
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary" 
                                                onclick="testPlatform(<?= $platform->platform_id ?>)">
                                            <i class="fas fa-plug"></i> Test Connection
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer bg-light">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle"></i> 
                                    Status: <?= $platform->is_active ? '<span class="text-success">Active</span>' : '<span class="text-danger">Inactive</span>' ?>
                                </small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> No job platforms found. Please run the database migration.
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Documentation Section -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-book"></i> Integration Documentation</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>LinkedIn Integration</h6>
                        <ul>
                            <li>Create a LinkedIn App at <a href="https://www.linkedin.com/developers/" target="_blank">LinkedIn Developers</a></li>
                            <li>Enable Job Posting API access</li>
                            <li>Copy Client ID (API Key) and Client Secret (API Secret)</li>
                            <li>Generate OAuth 2.0 access token</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>Indeed Integration</h6>
                        <ul>
                            <li>Sign up for Indeed Publisher account</li>
                            <li>Get your Publisher ID from Indeed dashboard</li>
                            <li>Configure XML feed or use Indeed API</li>
                            <li>Enter Publisher ID as API Key</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(button) {
    const input = button.previousElementSibling;
    const icon = button.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

function testPlatform(platformId) {
    const btn = event.target;
    const originalHtml = btn.innerHTML;
    
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Testing...';
    
    $.ajax({
        url: '<?= base_url("Setup/test_job_platform") ?>',
        method: 'POST',
        data: { platform_id: platformId },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Connection Successful',
                    text: response.message,
                    timer: 3000
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Connection Failed',
                    text: response.message
                });
            }
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to test connection'
            });
        },
        complete: function() {
            btn.disabled = false;
            btn.innerHTML = originalHtml;
        }
    });
}
</script>

<style>
.platform-card {
    transition: transform 0.2s;
}

.platform-card:hover {
    transform: translateY(-5px);
}

.platform-logo {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    border-radius: 10px;
}

.card {
    border-radius: 12px;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.btn-primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #764ba2, #667eea);
}
</style>

<?php $this->load->view('templates/admin_footer'); ?>
