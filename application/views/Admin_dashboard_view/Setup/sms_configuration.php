<?php
// Set page-specific variables
$data['page_title'] = 'SMS Configuration';

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
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
    padding: 16px 24px;
    border-radius: 12px;
    margin-bottom: 24px;
}

.provider-card {
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 16px;
    transition: all 0.3s;
    cursor: pointer;
}

.provider-card:hover {
    border-color: #f093fb;
    background: #fef3f8;
    transform: translateY(-2px);
}

.provider-card.active {
    border-color: #f093fb;
    background: linear-gradient(135deg, rgba(240, 147, 251, 0.1) 0%, rgba(245, 87, 108, 0.1) 100%);
}

.provider-logo {
    width: 80px;
    height: 80px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    margin: 0 auto 12px;
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
    background: #fef3f8;
    border-left: 4px solid #f093fb;
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
    border-color: #f093fb;
    box-shadow: 0 0 0 3px rgba(240, 147, 251, 0.1);
}

.btn-save {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
    border: none;
    padding: 12px 30px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(240, 147, 251, 0.4);
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
    border-color: #f093fb;
    background: #fef3f8;
}

.char-counter {
    font-size: 12px;
    color: #6b7280;
    text-align: right;
    margin-top: 4px;
}

.char-counter.warning {
    color: #f59e0b;
}

.char-counter.danger {
    color: #ef4444;
}
</style>

<!-- Page Header -->
<div class="section-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="mb-1"><i class="fas fa-sms me-2"></i>SMS Gateway Configuration</h2>
            <p class="mb-0 opacity-90">Configure SMS provider and message templates</p>
        </div>
        <div>
            <?php if(isset($sms_config) && $sms_config->is_active): ?>
                <span class="status-badge status-active">
                    <i class="fas fa-check-circle me-1"></i>Active
                </span>
            <?php else: ?>
                <span class="status-badge status-inactive">
                    <i class="fas fa-times-circle me-1"></i>Inactive
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
<ul class="nav nav-pills mb-4" id="smsTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="provider-tab" data-bs-toggle="pill" data-bs-target="#provider" type="button">
            <i class="fas fa-server me-2"></i>SMS Provider
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="templates-tab" data-bs-toggle="pill" data-bs-target="#templates" type="button">
            <i class="fas fa-file-alt me-2"></i>SMS Templates
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="test-tab" data-bs-toggle="pill" data-bs-target="#test" type="button">
            <i class="fas fa-paper-plane me-2"></i>Test SMS
        </button>
    </li>
</ul>

<div class="tab-content" id="smsTabContent">
    
    <!-- SMS Provider Tab -->
    <div class="tab-pane fade show active" id="provider" role="tabpanel">
        
        <!-- Provider Selection -->
        <div class="config-card">
            <h4 class="mb-4"><i class="fas fa-building me-2 text-primary"></i>Select SMS Provider</h4>
            
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="provider-card <?= (isset($sms_config) && $sms_config->provider == 'twilio') ? 'active' : '' ?>" 
                         onclick="selectProvider('twilio')">
                        <div class="provider-logo" style="background: linear-gradient(135deg, #f22f46 0%, #ff6b6b 100%); color: white;">
                            <i class="fas fa-comment-dots"></i>
                        </div>
                        <h5 class="text-center mb-2">Twilio</h5>
                        <p class="text-center text-muted small mb-0">Global SMS provider</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="provider-card <?= (isset($sms_config) && $sms_config->provider == 'dialog') ? 'active' : '' ?>" 
                         onclick="selectProvider('dialog')">
                        <div class="provider-logo" style="background: linear-gradient(135deg, #e31e24 0%, #ff4444 100%); color: white;">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h5 class="text-center mb-2">Dialog Axiata</h5>
                        <p class="text-center text-muted small mb-0">Sri Lankan provider</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="provider-card <?= (isset($sms_config) && $sms_config->provider == 'mobitel') ? 'active' : '' ?>" 
                         onclick="selectProvider('mobitel')">
                        <div class="provider-logo" style="background: linear-gradient(135deg, #0066cc 0%, #0088ff 100%); color: white;">
                            <i class="fas fa-signal"></i>
                        </div>
                        <h5 class="text-center mb-2">Mobitel</h5>
                        <p class="text-center text-muted small mb-0">Sri Lankan provider</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="provider-card <?= (isset($sms_config) && $sms_config->provider == 'nexmo') ? 'active' : '' ?>" 
                         onclick="selectProvider('nexmo')">
                        <div class="provider-logo" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h5 class="text-center mb-2">Vonage (Nexmo)</h5>
                        <p class="text-center text-muted small mb-0">Global SMS API</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="provider-card <?= (isset($sms_config) && $sms_config->provider == 'msg91') ? 'active' : '' ?>" 
                         onclick="selectProvider('msg91')">
                        <div class="provider-logo" style="background: linear-gradient(135deg, #1cc88a 0%, #17a673 100%); color: white;">
                            <i class="fas fa-comments"></i>
                        </div>
                        <h5 class="text-center mb-2">MSG91</h5>
                        <p class="text-center text-muted small mb-0">Indian SMS provider</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="provider-card <?= (isset($sms_config) && $sms_config->provider == 'custom') ? 'active' : '' ?>" 
                         onclick="selectProvider('custom')">
                        <div class="provider-logo" style="background: linear-gradient(135deg, #858796 0%, #60616f 100%); color: white;">
                            <i class="fas fa-cog"></i>
                        </div>
                        <h5 class="text-center mb-2">Custom API</h5>
                        <p class="text-center text-muted small mb-0">Your own SMS gateway</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Provider Configuration Form -->
        <div class="config-card">
            <h4 class="mb-4"><i class="fas fa-cog me-2 text-primary"></i>Provider Configuration</h4>
            
            <div class="info-box">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Note:</strong> Enter your SMS provider credentials. Make sure you have an active account with sufficient credits.
            </div>

            <form action="<?= base_url('Setup/save_sms_config') ?>" method="POST">
                <input type="hidden" name="provider" id="selectedProvider" value="<?= isset($sms_config) ? $sms_config->provider : 'twilio' ?>">
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">API Key / Account SID <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="api_key" 
                               value="<?= isset($sms_config) ? $sms_config->api_key : '' ?>" 
                               placeholder="Enter your API key" required>
                        <small class="text-muted">Your provider's API key or Account SID</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">API Secret / Auth Token <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="api_secret" 
                               value="<?= isset($sms_config) ? $sms_config->api_secret : '' ?>" 
                               placeholder="Enter your API secret" required>
                        <small class="text-muted">Your provider's API secret or Auth Token</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Sender ID / From Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="sender_id" 
                               value="<?= isset($sms_config) ? $sms_config->sender_id : '' ?>" 
                               placeholder="CompanyName or +1234567890" required>
                        <small class="text-muted">Sender name or phone number</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">API Endpoint (Optional)</label>
                        <input type="url" class="form-control" name="api_endpoint" 
                               value="<?= isset($sms_config) ? $sms_config->api_endpoint : '' ?>" 
                               placeholder="https://api.provider.com/sms">
                        <small class="text-muted">Custom API endpoint (for custom provider)</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Country Code</label>
                        <select class="form-select" name="country_code">
                            <option value="+94" <?= (isset($sms_config) && $sms_config->country_code == '+94') ? 'selected' : 'selected' ?>>+94 (Sri Lanka)</option>
                            <option value="+1" <?= (isset($sms_config) && $sms_config->country_code == '+1') ? 'selected' : '' ?>>+1 (USA/Canada)</option>
                            <option value="+44" <?= (isset($sms_config) && $sms_config->country_code == '+44') ? 'selected' : '' ?>>+44 (UK)</option>
                            <option value="+91" <?= (isset($sms_config) && $sms_config->country_code == '+91') ? 'selected' : '' ?>>+91 (India)</option>
                            <option value="+61" <?= (isset($sms_config) && $sms_config->country_code == '+61') ? 'selected' : '' ?>>+61 (Australia)</option>
                        </select>
                        <small class="text-muted">Default country code for phone numbers</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">SMS Credits Balance</label>
                        <input type="number" class="form-control" name="credits_balance" 
                               value="<?= isset($sms_config) ? $sms_config->credits_balance : 0 ?>" 
                               placeholder="0" readonly>
                        <small class="text-muted">Current SMS credits (read-only)</small>
                    </div>

                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" 
                                   id="isActive" <?= (isset($sms_config) && $sms_config->is_active) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="isActive">
                                <strong>Enable SMS Sending</strong>
                                <small class="d-block text-muted">Turn on to start sending SMS messages</small>
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

    <!-- SMS Templates Tab -->
    <div class="tab-pane fade" id="templates" role="tabpanel">
        <div class="config-card">
            <h4 class="mb-4"><i class="fas fa-file-alt me-2 text-primary"></i>SMS Templates</h4>
            
            <div class="info-box">
                <i class="fas fa-info-circle me-2"></i>
                <strong>SMS Character Limit:</strong> Standard SMS is 160 characters. Messages longer than 160 characters will be split into multiple SMS.
                <br><strong>Variables:</strong> {candidate_name}, {job_title}, {interview_date}, {interview_time}, {company_name}
            </div>

            <!-- Interview Reminder Template -->
            <div class="template-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0"><i class="fas fa-calendar-check me-2 text-info"></i>Interview Reminder</h5>
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#reminderTemplate">
                        <i class="fas fa-edit me-1"></i>Edit
                    </button>
                </div>
                <p class="text-muted small mb-2">Sent before scheduled interviews</p>
                <div class="collapse" id="reminderTemplate">
                    <form action="<?= base_url('Setup/save_sms_template') ?>" method="POST">
                        <input type="hidden" name="template_type" value="interview_reminder">
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea class="form-control" name="message" rows="4" maxlength="320" 
                                      onkeyup="updateCharCount(this, 'reminder')" required>Hi {candidate_name}, reminder: Your interview for {job_title} at {company_name} is on {interview_date} at {interview_time}. Good luck!</textarea>
                            <div class="char-counter" id="reminder-count">0 / 160 characters (1 SMS)</div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-save">
                            <i class="fas fa-save me-1"></i>Save Template
                        </button>
                    </form>
                </div>
            </div>

            <!-- Selection SMS Template -->
            <div class="template-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0"><i class="fas fa-check-circle me-2 text-success"></i>Selection SMS</h5>
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#selectionTemplate">
                        <i class="fas fa-edit me-1"></i>Edit
                    </button>
                </div>
                <p class="text-muted small mb-2">Sent when candidate is selected</p>
                <div class="collapse" id="selectionTemplate">
                    <form action="<?= base_url('Setup/save_sms_template') ?>" method="POST">
                        <input type="hidden" name="template_type" value="selection">
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea class="form-control" name="message" rows="4" maxlength="320" 
                                      onkeyup="updateCharCount(this, 'selection')" required>Congratulations {candidate_name}! You've been selected for {job_title} at {company_name}. We'll contact you soon with details.</textarea>
                            <div class="char-counter" id="selection-count">0 / 160 characters (1 SMS)</div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-save">
                            <i class="fas fa-save me-1"></i>Save Template
                        </button>
                    </form>
                </div>
            </div>

            <!-- Interview Scheduled Template -->
            <div class="template-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0"><i class="fas fa-calendar-plus me-2 text-primary"></i>Interview Scheduled</h5>
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#scheduledTemplate">
                        <i class="fas fa-edit me-1"></i>Edit
                    </button>
                </div>
                <p class="text-muted small mb-2">Sent when interview is scheduled</p>
                <div class="collapse" id="scheduledTemplate">
                    <form action="<?= base_url('Setup/save_sms_template') ?>" method="POST">
                        <input type="hidden" name="template_type" value="interview_scheduled">
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea class="form-control" name="message" rows="4" maxlength="320" 
                                      onkeyup="updateCharCount(this, 'scheduled')" required>Hi {candidate_name}, your interview for {job_title} at {company_name} is scheduled on {interview_date} at {interview_time}. Please confirm.</textarea>
                            <div class="char-counter" id="scheduled-count">0 / 160 characters (1 SMS)</div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-save">
                            <i class="fas fa-save me-1"></i>Save Template
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Test SMS Tab -->
    <div class="tab-pane fade" id="test" role="tabpanel">
        <div class="config-card">
            <h4 class="mb-4"><i class="fas fa-paper-plane me-2 text-primary"></i>Send Test SMS</h4>
            
            <div class="info-box">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Test your SMS configuration</strong> by sending a test message to verify that your provider settings are working correctly.
            </div>

            <form action="<?= base_url('Setup/send_test_sms') ?>" method="POST">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" name="test_phone" 
                               placeholder="+94771234567" required>
                        <small class="text-muted">Include country code (e.g., +94771234567)</small>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Message</label>
                        <textarea class="form-control" name="test_message" rows="4" maxlength="320" 
                                  onkeyup="updateCharCount(this, 'test')" required>This is a test SMS from your Recruitment Management System. If you received this message, your SMS configuration is working correctly!</textarea>
                        <div class="char-counter" id="test-count">0 / 160 characters (1 SMS)</div>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-test">
                            <i class="fas fa-paper-plane me-2"></i>Send Test SMS
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- SMS Log -->
        <div class="config-card">
            <h5 class="mb-3"><i class="fas fa-history me-2 text-info"></i>Recent SMS Activity</h5>
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
                                <i class="fas fa-inbox me-2"></i>No SMS activity yet
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function selectProvider(provider) {
    document.getElementById('selectedProvider').value = provider;
    
    // Update active state
    document.querySelectorAll('.provider-card').forEach(card => {
        card.classList.remove('active');
    });
    event.currentTarget.classList.add('active');
}

function updateCharCount(textarea, id) {
    const length = textarea.value.length;
    const smsCount = Math.ceil(length / 160);
    const counter = document.getElementById(id + '-count');
    
    counter.textContent = length + ' / 160 characters (' + smsCount + ' SMS)';
    
    if (length > 160) {
        counter.classList.add('warning');
    } else {
        counter.classList.remove('warning');
    }
    
    if (length > 320) {
        counter.classList.add('danger');
    } else {
        counter.classList.remove('danger');
    }
}

// Initialize character counters on page load
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('textarea[onkeyup*="updateCharCount"]').forEach(textarea => {
        textarea.dispatchEvent(new Event('keyup'));
    });
});
</script>

<?php
// Load the footer template
$this->load->view('templates/admin_footer');
?>
