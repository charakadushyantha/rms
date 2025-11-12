<?php
// Set page-specific variables
$data['page_title'] = 'WhatsApp Configuration';

// Load the header template
$this->load->view('templates/admin_header', $data);
?>

<style>
.config-card {
    background: white;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    margin-bottom: 24px;
    transition: all 0.3s ease;
}

.config-card:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.12);
}

.section-header {
    background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
    color: white;
    padding: 16px 24px;
    border-radius: 12px;
    margin-bottom: 24px;
}

.status-badge {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.status-active {
    background: #d1fae5;
    color: #065f46;
}

.status-inactive {
    background: #fee2e2;
    color: #991b1b;
}

.info-box {
    background: #f0fdf4;
    border-left: 4px solid #25D366;
    padding: 16px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.warning-box {
    background: #fffbeb;
    border-left: 4px solid #f59e0b;
    padding: 16px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.form-label {
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 8px;
}

.form-control, .form-select {
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    padding: 10px 15px;
    transition: all 0.3s;
}

.form-control:focus, .form-select:focus {
    border-color: #25D366;
    box-shadow: 0 0 0 3px rgba(37, 211, 102, 0.1);
}

.btn-save {
    background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
    color: white;
    border: none;
    padding: 12px 30px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(37, 211, 102, 0.4);
    color: white;
}

.btn-test {
    background: linear-gradient(135deg, #1cc88a 0%, #17a673 100%);
    color: white;
    border: none;
    padding: 12px 30px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-test:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(28, 200, 138, 0.4);
    color: white;
}

.template-card {
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    padding: 16px;
    margin-bottom: 12px;
    transition: all 0.3s;
}

.template-card:hover {
    border-color: #25D366;
    background: #f0fdf4;
}

.qr-code-box {
    background: white;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 30px;
    text-align: center;
}

.step-card {
    background: #f9fafb;
    border-left: 4px solid #25D366;
    padding: 16px;
    margin-bottom: 12px;
    border-radius: 8px;
}
</style>

<!-- Page Header -->
<div class="section-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="mb-1"><i class="fab fa-whatsapp me-2"></i>WhatsApp Business API Configuration</h2>
            <p class="mb-0 opacity-90">Connect WhatsApp Business API for automated messaging</p>
        </div>
        <div>
            <?php if(isset($whatsapp_config) && $whatsapp_config->is_active): ?>
                <span class="status-badge status-active">
                    <i class="fas fa-check-circle me-1"></i>Connected
                </span>
            <?php else: ?>
                <span class="status-badge status-inactive">
                    <i class="fas fa-times-circle me-1"></i>Not Connected
                </span>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Flash Messages -->
<?php if($this->session->flashdata('success_msg')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i><?= $this->session->flashdata('success_msg') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if($this->session->flashdata('error_msg')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i><?= $this->session->flashdata('error_msg') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Tabs -->
<ul class="nav nav-pills mb-4" id="whatsappTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="setup-tab" data-bs-toggle="pill" data-bs-target="#setup" type="button">
            <i class="fas fa-cog me-2"></i>Setup
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="templates-tab" data-bs-toggle="pill" data-bs-target="#templates" type="button">
            <i class="fas fa-file-alt me-2"></i>Message Templates
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="test-tab" data-bs-toggle="pill" data-bs-target="#test" type="button">
            <i class="fas fa-paper-plane me-2"></i>Test Message
        </button>
    </li>
</ul>

<div class="tab-content" id="whatsappTabContent">
    
    <!-- Setup Tab -->
    <div class="tab-pane fade show active" id="setup" role="tabpanel">
        
        <!-- Setup Guide -->
        <div class="config-card">
            <h4 class="mb-4"><i class="fas fa-book me-2 text-success"></i>Setup Guide</h4>
            
            <div class="warning-box">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Important:</strong> WhatsApp Business API requires approval from Meta (Facebook). 
                This is different from WhatsApp Business App. You'll need to apply for API access.
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="step-card">
                        <h6><i class="fas fa-check-circle text-success me-2"></i>Step 1: Get API Access</h6>
                        <p class="small mb-0">Apply for WhatsApp Business API through Meta Business Suite or use providers like Twilio, MessageBird, or 360Dialog.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="step-card">
                        <h6><i class="fas fa-check-circle text-success me-2"></i>Step 2: Get Credentials</h6>
                        <p class="small mb-0">Obtain your Phone Number ID, Business Account ID, and Access Token from your provider.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="step-card">
                        <h6><i class="fas fa-check-circle text-success me-2"></i>Step 3: Configure Below</h6>
                        <p class="small mb-0">Enter your API credentials in the configuration form below.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="step-card">
                        <h6><i class="fas fa-check-circle text-success me-2"></i>Step 4: Test Connection</h6>
                        <p class="small mb-0">Send a test message to verify your configuration is working.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Configuration Form -->
        <div class="config-card">
            <h4 class="mb-4"><i class="fas fa-cog me-2 text-primary"></i>API Configuration</h4>
            
            <div class="info-box">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Supported Providers:</strong> Meta (Facebook), Twilio, MessageBird, 360Dialog, Vonage, Gupshup
            </div>

            <form action="<?= base_url('Setup/save_whatsapp_config') ?>" method="POST">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Provider <span class="text-danger">*</span></label>
                        <select class="form-select" name="provider" required>
                            <option value="meta" <?= (isset($whatsapp_config) && $whatsapp_config->provider == 'meta') ? 'selected' : 'selected' ?>>Meta (Facebook)</option>
                            <option value="twilio" <?= (isset($whatsapp_config) && $whatsapp_config->provider == 'twilio') ? 'selected' : '' ?>>Twilio</option>
                            <option value="messagebird" <?= (isset($whatsapp_config) && $whatsapp_config->provider == 'messagebird') ? 'selected' : '' ?>>MessageBird</option>
                            <option value="360dialog" <?= (isset($whatsapp_config) && $whatsapp_config->provider == '360dialog') ? 'selected' : '' ?>>360Dialog</option>
                            <option value="vonage" <?= (isset($whatsapp_config) && $whatsapp_config->provider == 'vonage') ? 'selected' : '' ?>>Vonage</option>
                            <option value="gupshup" <?= (isset($whatsapp_config) && $whatsapp_config->provider == 'gupshup') ? 'selected' : '' ?>>Gupshup</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Phone Number ID <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="phone_number_id" 
                               value="<?= isset($whatsapp_config) ? $whatsapp_config->phone_number_id : '' ?>" 
                               placeholder="1234567890" required>
                        <small class="text-muted">Your WhatsApp Business phone number ID</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Business Account ID <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="business_account_id" 
                               value="<?= isset($whatsapp_config) ? $whatsapp_config->business_account_id : '' ?>" 
                               placeholder="1234567890" required>
                        <small class="text-muted">Your WhatsApp Business Account ID</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Access Token <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="access_token" 
                               value="<?= isset($whatsapp_config) ? $whatsapp_config->access_token : '' ?>" 
                               placeholder="EAAxxxxxxxxxx" required>
                        <small class="text-muted">Your API access token</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">API Version</label>
                        <select class="form-select" name="api_version">
                            <option value="v18.0" <?= (isset($whatsapp_config) && $whatsapp_config->api_version == 'v18.0') ? 'selected' : 'selected' ?>>v18.0 (Latest)</option>
                            <option value="v17.0" <?= (isset($whatsapp_config) && $whatsapp_config->api_version == 'v17.0') ? 'selected' : '' ?>>v17.0</option>
                            <option value="v16.0" <?= (isset($whatsapp_config) && $whatsapp_config->api_version == 'v16.0') ? 'selected' : '' ?>>v16.0</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Webhook Verify Token</label>
                        <input type="text" class="form-control" name="webhook_verify_token" 
                               value="<?= isset($whatsapp_config) ? $whatsapp_config->webhook_verify_token : '' ?>" 
                               placeholder="your_verify_token">
                        <small class="text-muted">Token for webhook verification</small>
                    </div>

                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" 
                                   id="isActive" <?= (isset($whatsapp_config) && $whatsapp_config->is_active) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="isActive">
                                <strong>Enable WhatsApp Messaging</strong>
                                <small class="d-block text-muted">Turn on to start sending WhatsApp messages</small>
                            </label>
                        </div>
                    </div>

                    <div class="col-12">
                        <hr>
                        <button type="submit" class="btn btn-save">
                            <i class="fas fa-save me-2"></i>Save Configuration
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Message Templates Tab -->
    <div class="tab-pane fade" id="templates" role="tabpanel">
        <div class="config-card">
            <h4 class="mb-4"><i class="fas fa-file-alt me-2 text-primary"></i>WhatsApp Message Templates</h4>
            
            <div class="info-box">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Note:</strong> WhatsApp requires pre-approved message templates. You must submit templates to Meta for approval before using them.
                <br><strong>Variables:</strong> {{1}}, {{2}}, {{3}} (numbered placeholders)
            </div>

            <!-- Interview Reminder Template -->
            <div class="template-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0"><i class="fab fa-whatsapp me-2 text-success"></i>Interview Reminder</h5>
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#reminderTemplate">
                        <i class="fas fa-edit me-1"></i>Edit
                    </button>
                </div>
                <p class="text-muted small mb-2">Template Name: interview_reminder</p>
                <div class="collapse" id="reminderTemplate">
                    <form action="<?= base_url('Setup/save_whatsapp_template') ?>" method="POST">
                        <input type="hidden" name="template_type" value="interview_reminder">
                        <div class="mb-3">
                            <label class="form-label">Template Name (Meta Approved)</label>
                            <input type="text" class="form-control" name="template_name" value="interview_reminder" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message Body</label>
                            <textarea class="form-control" name="message" rows="5" required>Hi {{1}},

This is a reminder about your interview for {{2}} position at {{3}}.

📅 Date: {{4}}
🕐 Time: {{5}}

Good luck! 🎯</textarea>
                            <small class="text-muted">Use {{1}}, {{2}}, {{3}} for variables</small>
                        </div>
                        <button type="submit" class="btn btn-sm btn-save">
                            <i class="fas fa-save me-1"></i>Save Template
                        </button>
                    </form>
                </div>
            </div>

            <!-- Selection Message Template -->
            <div class="template-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0"><i class="fab fa-whatsapp me-2 text-success"></i>Selection Message</h5>
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#selectionTemplate">
                        <i class="fas fa-edit me-1"></i>Edit
                    </button>
                </div>
                <p class="text-muted small mb-2">Template Name: candidate_selection</p>
                <div class="collapse" id="selectionTemplate">
                    <form action="<?= base_url('Setup/save_whatsapp_template') ?>" method="POST">
                        <input type="hidden" name="template_type" value="selection">
                        <div class="mb-3">
                            <label class="form-label">Template Name (Meta Approved)</label>
                            <input type="text" class="form-control" name="template_name" value="candidate_selection" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message Body</label>
                            <textarea class="form-control" name="message" rows="5" required>🎉 Congratulations {{1}}!

We're pleased to inform you that you've been selected for the {{2}} position at {{3}}.

Our HR team will contact you soon with the offer details.

Welcome to the team! 🤝</textarea>
                        </div>
                        <button type="submit" class="btn btn-sm btn-save">
                            <i class="fas fa-save me-1"></i>Save Template
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Test Message Tab -->
    <div class="tab-pane fade" id="test" role="tabpanel">
        <div class="config-card">
            <h4 class="mb-4"><i class="fas fa-paper-plane me-2 text-primary"></i>Send Test WhatsApp Message</h4>
            
            <div class="info-box">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Test your WhatsApp configuration</strong> by sending a test message. Make sure the recipient has WhatsApp installed.
            </div>

            <form action="<?= base_url('Setup/send_test_whatsapp') ?>" method="POST">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" name="test_phone" 
                               placeholder="+94771234567" required>
                        <small class="text-muted">Include country code (e.g., +94771234567)</small>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Message</label>
                        <textarea class="form-control" name="test_message" rows="5" required>Hello! 👋

This is a test message from your Recruitment Management System.

If you received this message, your WhatsApp Business API configuration is working correctly! ✅

Best regards,
RMS Team</textarea>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-test">
                            <i class="fab fa-whatsapp me-2"></i>Send Test Message
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Message Log -->
        <div class="config-card">
            <h5 class="mb-3"><i class="fas fa-history me-2 text-info"></i>Recent WhatsApp Activity</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date/Time</th>
                            <th>Recipient</th>
                            <th>Message</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                <i class="fab fa-whatsapp me-2"></i>No WhatsApp activity yet
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
// Load the footer template
$this->load->view('templates/admin_footer');
?>
