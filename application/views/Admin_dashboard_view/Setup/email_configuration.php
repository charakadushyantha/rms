<?php
// Set page-specific variables
$data['page_title'] = 'Email Configuration';

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
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 16px 24px;
    border-radius: 12px;
    margin-bottom: 24px;
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
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.btn-save {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 12px 30px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
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
    background: #f0f9ff;
    border-left: 4px solid #3b82f6;
    padding: 16px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.template-card {
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    padding: 16px;
    margin-bottom: 12px;
    transition: all 0.3s;
}

.template-card:hover {
    border-color: #667eea;
    background: #f7fafc;
}

.template-preview {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    padding: 12px;
    font-family: monospace;
    font-size: 13px;
    max-height: 200px;
    overflow-y: auto;
}
</style>

<!-- Page Header -->
<div class="section-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="mb-1"><i class="fas fa-envelope-open-text me-2"></i>Email Configuration</h2>
            <p class="mb-0 opacity-90">Configure SMTP settings and email templates</p>
        </div>
        <div>
            <?php if(isset($email_config) && $email_config->is_active): ?>
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
<ul class="nav nav-pills mb-4" id="emailTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="smtp-tab" data-bs-toggle="pill" data-bs-target="#smtp" type="button">
            <i class="fas fa-server me-2"></i>SMTP Settings
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="templates-tab" data-bs-toggle="pill" data-bs-target="#templates" type="button">
            <i class="fas fa-file-alt me-2"></i>Email Templates
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="test-tab" data-bs-toggle="pill" data-bs-target="#test" type="button">
            <i class="fas fa-paper-plane me-2"></i>Test Email
        </button>
    </li>
</ul>

<div class="tab-content" id="emailTabContent">
    
    <!-- SMTP Settings Tab -->
    <div class="tab-pane fade show active" id="smtp" role="tabpanel">
        <div class="config-card">
            <h4 class="mb-4"><i class="fas fa-cog me-2 text-primary"></i>SMTP Configuration</h4>
            
            <div class="info-box">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Note:</strong> Configure your SMTP server details to enable email functionality. 
                Common providers: Gmail, Outlook, SendGrid, Mailgun, AWS SES.
            </div>

            <form action="<?= base_url('Setup/save_email_config') ?>" method="POST">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">SMTP Host <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="smtp_host" 
                               value="<?= isset($email_config) ? $email_config->smtp_host : '' ?>" 
                               placeholder="smtp.gmail.com" required>
                        <small class="text-muted">Your SMTP server address</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">SMTP Port <span class="text-danger">*</span></label>
                        <select class="form-select" name="smtp_port" required>
                            <option value="587" <?= (isset($email_config) && $email_config->smtp_port == 587) ? 'selected' : '' ?>>587 (TLS - Recommended)</option>
                            <option value="465" <?= (isset($email_config) && $email_config->smtp_port == 465) ? 'selected' : '' ?>>465 (SSL)</option>
                            <option value="25" <?= (isset($email_config) && $email_config->smtp_port == 25) ? 'selected' : '' ?>>25 (Non-encrypted)</option>
                            <option value="2525" <?= (isset($email_config) && $email_config->smtp_port == 2525) ? 'selected' : '' ?>>2525 (Alternative)</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">SMTP Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="smtp_username" 
                               value="<?= isset($email_config) ? $email_config->smtp_username : '' ?>" 
                               placeholder="your-email@gmail.com" required>
                        <small class="text-muted">Your email address or SMTP username</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">SMTP Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="smtp_password" 
                               value="<?= isset($email_config) ? $email_config->smtp_password : '' ?>" 
                               placeholder="••••••••" required>
                        <small class="text-muted">App password or SMTP password</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Encryption Type</label>
                        <select class="form-select" name="smtp_encryption">
                            <option value="tls" <?= (isset($email_config) && $email_config->smtp_encryption == 'tls') ? 'selected' : 'selected' ?>>TLS (Recommended)</option>
                            <option value="ssl" <?= (isset($email_config) && $email_config->smtp_encryption == 'ssl') ? 'selected' : '' ?>>SSL</option>
                            <option value="" <?= (isset($email_config) && empty($email_config->smtp_encryption)) ? 'selected' : '' ?>>None</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">From Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="from_email" 
                               value="<?= isset($email_config) ? $email_config->from_email : '' ?>" 
                               placeholder="noreply@company.com" required>
                        <small class="text-muted">Email address shown as sender</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">From Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="from_name" 
                               value="<?= isset($email_config) ? $email_config->from_name : '' ?>" 
                               placeholder="Company Name" required>
                        <small class="text-muted">Name shown as sender</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Reply-To Email</label>
                        <input type="email" class="form-control" name="reply_to_email" 
                               value="<?= isset($email_config) ? $email_config->reply_to_email : '' ?>" 
                               placeholder="support@company.com">
                        <small class="text-muted">Email for replies (optional)</small>
                    </div>

                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" 
                                   id="isActive" <?= (isset($email_config) && $email_config->is_active) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="isActive">
                                <strong>Enable Email Sending</strong>
                                <small class="d-block text-muted">Turn on to start sending emails</small>
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

        <!-- Quick Setup Guides -->
        <div class="config-card">
            <h5 class="mb-3"><i class="fas fa-book me-2 text-info"></i>Quick Setup Guides</h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="template-card">
                        <h6><i class="fab fa-google me-2"></i>Gmail</h6>
                        <small class="text-muted">
                            <strong>Host:</strong> smtp.gmail.com<br>
                            <strong>Port:</strong> 587 (TLS)<br>
                            <strong>Note:</strong> Use App Password, not regular password
                        </small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="template-card">
                        <h6><i class="fab fa-microsoft me-2"></i>Outlook/Office 365</h6>
                        <small class="text-muted">
                            <strong>Host:</strong> smtp.office365.com<br>
                            <strong>Port:</strong> 587 (TLS)<br>
                            <strong>Note:</strong> Use your full email address
                        </small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="template-card">
                        <h6><i class="fas fa-paper-plane me-2"></i>SendGrid</h6>
                        <small class="text-muted">
                            <strong>Host:</strong> smtp.sendgrid.net<br>
                            <strong>Port:</strong> 587 (TLS)<br>
                            <strong>Username:</strong> apikey
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Email Templates Tab -->
    <div class="tab-pane fade" id="templates" role="tabpanel">
        <div class="config-card">
            <h4 class="mb-4"><i class="fas fa-file-alt me-2 text-primary"></i>Email Templates</h4>
            
            <div class="info-box">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Available Variables:</strong> {candidate_name}, {job_title}, {interview_date}, {interview_time}, 
                {interviewer_name}, {company_name}, {recruiter_name}
            </div>

            <!-- Welcome Email Template -->
            <div class="template-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0"><i class="fas fa-user-plus me-2 text-success"></i>Welcome Email</h5>
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#welcomeTemplate">
                        <i class="fas fa-edit me-1"></i>Edit
                    </button>
                </div>
                <p class="text-muted small mb-2">Sent when a new candidate is added to the system</p>
                <div class="collapse" id="welcomeTemplate">
                    <form action="<?= base_url('Setup/save_email_template') ?>" method="POST">
                        <input type="hidden" name="template_type" value="welcome">
                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <input type="text" class="form-control" name="subject" 
                                   value="Welcome to {company_name} Recruitment Process" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Body</label>
                            <textarea class="form-control" name="body" rows="6" required>Dear {candidate_name},

Welcome to {company_name}! We're excited to have you in our recruitment process for the {job_title} position.

Your recruiter {recruiter_name} will be in touch with you soon regarding the next steps.

Best regards,
{company_name} HR Team</textarea>
                        </div>
                        <button type="submit" class="btn btn-sm btn-save">
                            <i class="fas fa-save me-1"></i>Save Template
                        </button>
                    </form>
                </div>
            </div>

            <!-- Interview Invitation Template -->
            <div class="template-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0"><i class="fas fa-calendar-check me-2 text-info"></i>Interview Invitation</h5>
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#interviewTemplate">
                        <i class="fas fa-edit me-1"></i>Edit
                    </button>
                </div>
                <p class="text-muted small mb-2">Sent when an interview is scheduled</p>
                <div class="collapse" id="interviewTemplate">
                    <form action="<?= base_url('Setup/save_email_template') ?>" method="POST">
                        <input type="hidden" name="template_type" value="interview_invitation">
                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <input type="text" class="form-control" name="subject" 
                                   value="Interview Scheduled - {job_title} at {company_name}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Body</label>
                            <textarea class="form-control" name="body" rows="8" required>Dear {candidate_name},

Congratulations! We would like to invite you for an interview for the {job_title} position.

Interview Details:
Date: {interview_date}
Time: {interview_time}
Interviewer: {interviewer_name}

Please confirm your availability by replying to this email.

We look forward to meeting you!

Best regards,
{company_name} HR Team</textarea>
                        </div>
                        <button type="submit" class="btn btn-sm btn-save">
                            <i class="fas fa-save me-1"></i>Save Template
                        </button>
                    </form>
                </div>
            </div>

            <!-- Selection Email Template -->
            <div class="template-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0"><i class="fas fa-check-circle me-2 text-success"></i>Selection Email</h5>
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#selectionTemplate">
                        <i class="fas fa-edit me-1"></i>Edit
                    </button>
                </div>
                <p class="text-muted small mb-2">Sent when a candidate is selected</p>
                <div class="collapse" id="selectionTemplate">
                    <form action="<?= base_url('Setup/save_email_template') ?>" method="POST">
                        <input type="hidden" name="template_type" value="selection">
                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <input type="text" class="form-control" name="subject" 
                                   value="Congratulations! Job Offer from {company_name}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Body</label>
                            <textarea class="form-control" name="body" rows="8" required>Dear {candidate_name},

We are pleased to inform you that you have been selected for the {job_title} position at {company_name}!

Your recruiter {recruiter_name} will contact you shortly with the offer details and next steps.

Congratulations on your success!

Best regards,
{company_name} HR Team</textarea>
                        </div>
                        <button type="submit" class="btn btn-sm btn-save">
                            <i class="fas fa-save me-1"></i>Save Template
                        </button>
                    </form>
                </div>
            </div>

            <!-- Rejection Email Template -->
            <div class="template-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0"><i class="fas fa-times-circle me-2 text-danger"></i>Rejection Email</h5>
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#rejectionTemplate">
                        <i class="fas fa-edit me-1"></i>Edit
                    </button>
                </div>
                <p class="text-muted small mb-2">Sent when a candidate is not selected</p>
                <div class="collapse" id="rejectionTemplate">
                    <form action="<?= base_url('Setup/save_email_template') ?>" method="POST">
                        <input type="hidden" name="template_type" value="rejection">
                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <input type="text" class="form-control" name="subject" 
                                   value="Update on Your Application - {company_name}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Body</label>
                            <textarea class="form-control" name="body" rows="8" required>Dear {candidate_name},

Thank you for your interest in the {job_title} position at {company_name} and for taking the time to interview with us.

After careful consideration, we have decided to move forward with other candidates whose qualifications more closely match our current needs.

We appreciate your interest in {company_name} and encourage you to apply for future opportunities that match your skills and experience.

Best wishes in your job search.

Best regards,
{company_name} HR Team</textarea>
                        </div>
                        <button type="submit" class="btn btn-sm btn-save">
                            <i class="fas fa-save me-1"></i>Save Template
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Test Email Tab -->
    <div class="tab-pane fade" id="test" role="tabpanel">
        <div class="config-card">
            <h4 class="mb-4"><i class="fas fa-paper-plane me-2 text-primary"></i>Send Test Email</h4>
            
            <div class="info-box">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Test your email configuration</strong> by sending a test email to verify that your SMTP settings are working correctly.
            </div>

            <form action="<?= base_url('Setup/send_test_email') ?>" method="POST">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Recipient Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="test_email" 
                               placeholder="test@example.com" required>
                        <small class="text-muted">Email address to receive the test email</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Subject</label>
                        <input type="text" class="form-control" name="test_subject" 
                               value="Test Email from RMS" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Message</label>
                        <textarea class="form-control" name="test_message" rows="5" required>This is a test email from your Recruitment Management System.

If you received this email, your SMTP configuration is working correctly!

Timestamp: <?= date('Y-m-d H:i:s') ?></textarea>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-test">
                            <i class="fas fa-paper-plane me-2"></i>Send Test Email
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Email Log -->
        <div class="config-card">
            <h5 class="mb-3"><i class="fas fa-history me-2 text-info"></i>Recent Email Activity</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date/Time</th>
                            <th>Recipient</th>
                            <th>Subject</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                <i class="fas fa-inbox me-2"></i>No email activity yet
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
