<?php
// Set page-specific variables
$data['page_title'] = 'Notification Center';

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

.section-header {
    background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%);
    color: white;
    padding: 16px 24px;
    border-radius: 12px;
    margin-bottom: 24px;
}

.notification-card {
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 16px;
    transition: all 0.3s;
}

.notification-card:hover {
    border-color: #f6c23e;
    background: #fffbeb;
}

.notification-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.form-check-input:checked {
    background-color: #f6c23e;
    border-color: #f6c23e;
}

.channel-badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
    margin-right: 4px;
}

.badge-email {
    background: #dbeafe;
    color: #1e40af;
}

.badge-sms {
    background: #fce7f3;
    color: #9f1239;
}

.badge-whatsapp {
    background: #d1fae5;
    color: #065f46;
}

.badge-system {
    background: #e0e7ff;
    color: #3730a3;
}
</style>

<!-- Page Header -->
<div class="section-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="mb-1"><i class="fas fa-bell me-2"></i>Notification Center</h2>
            <p class="mb-0 opacity-90">Manage all system notifications and alerts</p>
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

<form action="<?= base_url('Setup/save_notification_settings') ?>" method="POST">
    
    <!-- Candidate Notifications -->
    <div class="config-card">
        <h4 class="mb-4"><i class="fas fa-user-graduate me-2 text-primary"></i>Candidate Notifications</h4>
        
        <div class="row g-3">
            <div class="col-md-6">
                <div class="notification-card">
                    <div class="d-flex align-items-start">
                        <div class="notification-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="ms-3 flex-grow-1">
                            <h6 class="mb-1">New Candidate Added</h6>
                            <p class="text-muted small mb-2">Notify when a new candidate is added to the system</p>
                            <div class="mb-2">
                                <span class="channel-badge badge-email"><i class="fas fa-envelope me-1"></i>Email</span>
                                <span class="channel-badge badge-sms"><i class="fas fa-sms me-1"></i>SMS</span>
                                <span class="channel-badge badge-system"><i class="fas fa-desktop me-1"></i>System</span>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="notify_candidate_added" value="1" checked>
                                <label class="form-check-label small">Enable notification</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="notification-card">
                    <div class="d-flex align-items-start">
                        <div class="notification-icon" style="background: linear-gradient(135deg, #1cc88a 0%, #17a673 100%); color: white;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="ms-3 flex-grow-1">
                            <h6 class="mb-1">Candidate Selected</h6>
                            <p class="text-muted small mb-2">Notify candidate when they are selected</p>
                            <div class="mb-2">
                                <span class="channel-badge badge-email"><i class="fas fa-envelope me-1"></i>Email</span>
                                <span class="channel-badge badge-sms"><i class="fas fa-sms me-1"></i>SMS</span>
                                <span class="channel-badge badge-whatsapp"><i class="fab fa-whatsapp me-1"></i>WhatsApp</span>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="notify_candidate_selected" value="1" checked>
                                <label class="form-check-label small">Enable notification</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="notification-card">
                    <div class="d-flex align-items-start">
                        <div class="notification-icon" style="background: linear-gradient(135deg, #e74a3b 0%, #c92a2a 100%); color: white;">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <div class="ms-3 flex-grow-1">
                            <h6 class="mb-1">Candidate Rejected</h6>
                            <p class="text-muted small mb-2">Notify candidate when they are not selected</p>
                            <div class="mb-2">
                                <span class="channel-badge badge-email"><i class="fas fa-envelope me-1"></i>Email</span>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="notify_candidate_rejected" value="1">
                                <label class="form-check-label small">Enable notification</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="notification-card">
                    <div class="d-flex align-items-start">
                        <div class="notification-icon" style="background: linear-gradient(135deg, #36b9cc 0%, #258391 100%); color: white;">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <div class="ms-3 flex-grow-1">
                            <h6 class="mb-1">Profile Updated</h6>
                            <p class="text-muted small mb-2">Notify when candidate profile is updated</p>
                            <div class="mb-2">
                                <span class="channel-badge badge-system"><i class="fas fa-desktop me-1"></i>System</span>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="notify_profile_updated" value="1" checked>
                                <label class="form-check-label small">Enable notification</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Interview Notifications -->
    <div class="config-card">
        <h4 class="mb-4"><i class="fas fa-calendar-check me-2 text-success"></i>Interview Notifications</h4>
        
        <div class="row g-3">
            <div class="col-md-6">
                <div class="notification-card">
                    <div class="d-flex align-items-start">
                        <div class="notification-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                            <i class="fas fa-calendar-plus"></i>
                        </div>
                        <div class="ms-3 flex-grow-1">
                            <h6 class="mb-1">Interview Scheduled</h6>
                            <p class="text-muted small mb-2">Notify all parties when interview is scheduled</p>
                            <div class="mb-2">
                                <span class="channel-badge badge-email"><i class="fas fa-envelope me-1"></i>Email</span>
                                <span class="channel-badge badge-sms"><i class="fas fa-sms me-1"></i>SMS</span>
                                <span class="channel-badge badge-whatsapp"><i class="fab fa-whatsapp me-1"></i>WhatsApp</span>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="notify_interview_scheduled" value="1" checked>
                                <label class="form-check-label small">Enable notification</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="notification-card">
                    <div class="d-flex align-items-start">
                        <div class="notification-icon" style="background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%); color: white;">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div class="ms-3 flex-grow-1">
                            <h6 class="mb-1">Interview Reminder</h6>
                            <p class="text-muted small mb-2">Send reminder 24 hours before interview</p>
                            <div class="mb-2">
                                <span class="channel-badge badge-email"><i class="fas fa-envelope me-1"></i>Email</span>
                                <span class="channel-badge badge-sms"><i class="fas fa-sms me-1"></i>SMS</span>
                                <span class="channel-badge badge-whatsapp"><i class="fab fa-whatsapp me-1"></i>WhatsApp</span>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="notify_interview_reminder" value="1" checked>
                                <label class="form-check-label small">Enable notification</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="notification-card">
                    <div class="d-flex align-items-start">
                        <div class="notification-icon" style="background: linear-gradient(135deg, #e74a3b 0%, #c92a2a 100%); color: white;">
                            <i class="fas fa-calendar-times"></i>
                        </div>
                        <div class="ms-3 flex-grow-1">
                            <h6 class="mb-1">Interview Cancelled</h6>
                            <p class="text-muted small mb-2">Notify when interview is cancelled</p>
                            <div class="mb-2">
                                <span class="channel-badge badge-email"><i class="fas fa-envelope me-1"></i>Email</span>
                                <span class="channel-badge badge-sms"><i class="fas fa-sms me-1"></i>SMS</span>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="notify_interview_cancelled" value="1" checked>
                                <label class="form-check-label small">Enable notification</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="notification-card">
                    <div class="d-flex align-items-start">
                        <div class="notification-icon" style="background: linear-gradient(135deg, #36b9cc 0%, #258391 100%); color: white;">
                            <i class="fas fa-edit"></i>
                        </div>
                        <div class="ms-3 flex-grow-1">
                            <h6 class="mb-1">Interview Rescheduled</h6>
                            <p class="text-muted small mb-2">Notify when interview time is changed</p>
                            <div class="mb-2">
                                <span class="channel-badge badge-email"><i class="fas fa-envelope me-1"></i>Email</span>
                                <span class="channel-badge badge-sms"><i class="fas fa-sms me-1"></i>SMS</span>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="notify_interview_rescheduled" value="1" checked>
                                <label class="form-check-label small">Enable notification</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- System Notifications -->
    <div class="config-card">
        <h4 class="mb-4"><i class="fas fa-cog me-2 text-info"></i>System Notifications</h4>
        
        <div class="row g-3">
            <div class="col-md-6">
                <div class="notification-card">
                    <div class="d-flex align-items-start">
                        <div class="notification-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="ms-3 flex-grow-1">
                            <h6 class="mb-1">New User Registration</h6>
                            <p class="text-muted small mb-2">Notify admin when new user registers</p>
                            <div class="mb-2">
                                <span class="channel-badge badge-email"><i class="fas fa-envelope me-1"></i>Email</span>
                                <span class="channel-badge badge-system"><i class="fas fa-desktop me-1"></i>System</span>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="notify_new_user" value="1" checked>
                                <label class="form-check-label small">Enable notification</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="notification-card">
                    <div class="d-flex align-items-start">
                        <div class="notification-icon" style="background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%); color: white;">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="ms-3 flex-grow-1">
                            <h6 class="mb-1">Daily Summary Report</h6>
                            <p class="text-muted small mb-2">Send daily activity summary to admin</p>
                            <div class="mb-2">
                                <span class="channel-badge badge-email"><i class="fas fa-envelope me-1"></i>Email</span>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="notify_daily_summary" value="1">
                                <label class="form-check-label small">Enable notification</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Save Button -->
    <div class="text-end">
        <button type="submit" class="btn btn-lg" style="background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%); color: white; border: none; padding: 12px 40px; border-radius: 8px; font-weight: 600;">
            <i class="fas fa-save me-2"></i>Save Notification Settings
        </button>
    </div>
</form>

<?php
// Load the footer template
$this->load->view('templates/admin_footer');
?>
