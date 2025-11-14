<?php $this->load->view('templates/admin_header'); ?>

<div class="content-area">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Google OAuth Configuration</h1>
                <p class="text-muted">Configure Google Sign-In for your application</p>
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

        <div class="row">
            <!-- Configuration Form -->
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fab fa-google"></i> Google OAuth Settings</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('Setup/save_google_oauth_config') ?>" method="post">
                            <!-- Enable/Disable -->
                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_enabled" name="is_enabled" 
                                           <?= (isset($config) && $config->is_enabled) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="is_enabled">
                                        <strong>Enable Google Login</strong>
                                        <small class="d-block text-muted">Allow users to sign in with their Google accounts</small>
                                    </label>
                                </div>
                            </div>

                            <hr>

                            <!-- Client ID -->
                            <div class="mb-3">
                                <label for="client_id" class="form-label">
                                    <i class="fas fa-key"></i> Client ID <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="client_id" name="client_id" 
                                       value="<?= isset($config) ? $config->client_id : '' ?>" 
                                       placeholder="123456789-abc123.apps.googleusercontent.com" required>
                                <small class="form-text text-muted">
                                    Get this from Google Cloud Console
                                </small>
                            </div>

                            <!-- Client Secret -->
                            <div class="mb-3">
                                <label for="client_secret" class="form-label">
                                    <i class="fas fa-lock"></i> Client Secret <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="client_secret" name="client_secret" 
                                           value="<?= isset($config) ? $config->client_secret : '' ?>" 
                                           placeholder="GOCSPX-abc123xyz" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
                                        <i class="fas fa-eye" id="toggleIcon"></i>
                                    </button>
                                </div>
                                <small class="form-text text-muted">
                                    Get this from Google Cloud Console
                                </small>
                            </div>

                            <!-- Redirect URI (Read-only) -->
                            <div class="mb-3">
                                <label for="redirect_uri" class="form-label">
                                    <i class="fas fa-link"></i> Redirect URI
                                </label>
                                <input type="text" class="form-control" id="redirect_uri" 
                                       value="<?= base_url('Login/google_callback') ?>" readonly>
                                <small class="form-text text-muted">
                                    Add this URL to your Google Cloud Console Authorized redirect URIs
                                </small>
                            </div>

                            <hr>

                            <!-- Auto-activate Users -->
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="auto_activate_users" name="auto_activate_users" 
                                           <?= (isset($config) && $config->auto_activate_users) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="auto_activate_users">
                                        Auto-activate new users
                                        <small class="d-block text-muted">New Google sign-ups will be automatically activated</small>
                                    </label>
                                </div>
                            </div>

                            <!-- Default Role -->
                            <div class="mb-4">
                                <label for="default_role" class="form-label">
                                    <i class="fas fa-user-tag"></i> Default Role for New Users
                                </label>
                                <select class="form-select" id="default_role" name="default_role">
                                    <option value="Candidate" <?= (isset($config) && $config->default_role == 'Candidate') ? 'selected' : '' ?>>Candidate</option>
                                    <option value="Recruiter" <?= (isset($config) && $config->default_role == 'Recruiter') ? 'selected' : '' ?>>Recruiter</option>
                                    <option value="Interviewer" <?= (isset($config) && $config->default_role == 'Interviewer') ? 'selected' : '' ?>>Interviewer</option>
                                </select>
                                <small class="form-text text-muted">
                                    Role assigned to new users who sign up via Google
                                </small>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save Configuration
                                </button>
                                <button type="button" class="btn btn-info" onclick="testConfiguration()">
                                    <i class="fas fa-vial"></i> Test Configuration
                                </button>
                                <a href="<?= base_url('Login') ?>" class="btn btn-success" target="_blank">
                                    <i class="fas fa-external-link-alt"></i> View Login Page
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Setup Instructions -->
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-info-circle"></i> Setup Instructions</h5>
                    </div>
                    <div class="card-body">
                        <h6 class="fw-bold">Step 1: Google Cloud Console</h6>
                        <ol class="small">
                            <li>Visit <a href="https://console.cloud.google.com/" target="_blank">Google Cloud Console</a></li>
                            <li>Create a new project or select existing</li>
                            <li>Enable "Google+ API"</li>
                            <li>Go to Credentials → Create OAuth 2.0 Client ID</li>
                            <li>Choose "Web application"</li>
                        </ol>

                        <h6 class="fw-bold mt-3">Step 2: Configure Redirect URI</h6>
                        <p class="small">Add this to Authorized redirect URIs:</p>
                        <div class="alert alert-secondary p-2 small">
                            <code><?= base_url('Login/google_callback') ?></code>
                            <button class="btn btn-sm btn-link" onclick="copyToClipboard('<?= base_url('Login/google_callback') ?>')">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>

                        <h6 class="fw-bold mt-3">Step 3: Get Credentials</h6>
                        <p class="small">Copy your Client ID and Client Secret from Google Console and paste them in the form.</p>

                        <h6 class="fw-bold mt-3">Step 4: Enable & Test</h6>
                        <p class="small">Enable Google Login, save configuration, and click "Test Configuration" to verify.</p>

                        <hr>

                        <div class="alert alert-warning small mb-0">
                            <i class="fas fa-exclamation-triangle"></i> <strong>Important:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Keep your Client Secret secure</li>
                                <li>Use HTTPS in production</li>
                                <li>Test thoroughly before enabling</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Current Status -->
                <div class="card shadow-sm mt-3">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="fas fa-chart-line"></i> Current Status</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Google Login:</span>
                            <span class="badge <?= (isset($config) && $config->is_enabled) ? 'bg-success' : 'bg-secondary' ?>">
                                <?= (isset($config) && $config->is_enabled) ? 'Enabled' : 'Disabled' ?>
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Client ID:</span>
                            <span class="badge <?= (isset($config) && !empty($config->client_id)) ? 'bg-success' : 'bg-warning' ?>">
                                <?= (isset($config) && !empty($config->client_id)) ? 'Configured' : 'Not Set' ?>
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Client Secret:</span>
                            <span class="badge <?= (isset($config) && !empty($config->client_secret)) ? 'bg-success' : 'bg-warning' ?>">
                                <?= (isset($config) && !empty($config->client_secret)) ? 'Configured' : 'Not Set' ?>
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Auto-activate:</span>
                            <span class="badge bg-info">
                                <?= (isset($config) && $config->auto_activate_users) ? 'Yes' : 'No' ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="card shadow-sm mt-3">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="fas fa-link"></i> Quick Links</h5>
                    </div>
                    <div class="card-body">
                        <a href="https://console.cloud.google.com/" target="_blank" class="btn btn-sm btn-outline-primary w-100 mb-2">
                            <i class="fab fa-google"></i> Google Cloud Console
                        </a>
                        <a href="<?= base_url('Login') ?>" target="_blank" class="btn btn-sm btn-outline-success w-100 mb-2">
                            <i class="fas fa-sign-in-alt"></i> Test Login Page
                        </a>
                        <a href="<?= base_url('Setup/manage_users') ?>" class="btn btn-sm btn-outline-info w-100">
                            <i class="fas fa-users"></i> Manage Users
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const passwordField = document.getElementById('client_secret');
    const toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Copied to clipboard!');
    }, function(err) {
        console.error('Could not copy text: ', err);
    });
}

function testConfiguration() {
    // Show loading
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Testing...';
    btn.disabled = true;
    
    fetch('<?= base_url('Setup/test_google_oauth') ?>')
        .then(response => response.json())
        .then(data => {
            btn.innerHTML = originalText;
            btn.disabled = false;
            
            if (data.success) {
                if (confirm(data.message + '\n\nDo you want to test login now?')) {
                    window.open(data.auth_url, '_blank');
                }
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            btn.innerHTML = originalText;
            btn.disabled = false;
            alert('Error testing configuration: ' + error);
        });
}
</script>

<style>
.card {
    border: none;
    border-radius: 12px;
}

.card-header {
    border-radius: 12px 12px 0 0 !important;
    padding: 1rem 1.5rem;
}

.form-control, .form-select {
    border-radius: 8px;
}

.btn {
    border-radius: 8px;
}

code {
    background: #f8f9fa;
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 0.9em;
}

.alert {
    border-radius: 8px;
}
</style>

<?php $this->load->view('templates/admin_footer'); ?>
