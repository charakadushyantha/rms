<?php
$this->load->view('templates/admin_header', array('page_title' => 'Interview Configuration'));
?>

<style>
.config-section {
    background: white;
    border-radius: 10px;
    padding: 25px;
    margin-bottom: 25px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.section-header {
    border-bottom: 2px solid #f0f0f0;
    padding-bottom: 15px;
    margin-bottom: 20px;
}

.section-header h4 {
    color: #667eea;
    font-weight: 600;
    margin: 0;
}

.section-header p {
    color: #6b7280;
    font-size: 14px;
    margin: 5px 0 0 0;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
    display: block;
}

.form-control {
    width: 100%;
    padding: 10px 15px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 14px;
}

.form-control:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 24px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 24px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}

input:checked + .slider {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

input:checked + .slider:before {
    transform: translateX(26px);
}


.switch-label {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 15px;
}

.switch-label span {
    font-weight: 500;
    color: #333;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 12px 30px;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.info-box {
    background: #e3f2fd;
    border-left: 4px solid #2196f3;
    padding: 15px;
    border-radius: 6px;
    margin-bottom: 20px;
}

.info-box i {
    color: #2196f3;
    margin-right: 10px;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    margin-bottom: 25px;
}

.stat-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
}

.stat-card h3 {
    font-size: 32px;
    margin: 0 0 5px 0;
}

.stat-card p {
    margin: 0;
    opacity: 0.9;
    font-size: 14px;
}
</style>

<div class="row">
    <div class="col-12">
        <div class="data-card">
            <div class="data-card-header">
                <h3 class="data-card-title">
                    <i class="fas fa-cog me-2"></i>Interview Configuration
                </h3>
            </div>
        </div>
    </div>
</div>

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

<!-- Statistics -->
<div class="stats-grid">
    <div class="stat-card">
        <h3><?= count($rounds) ?></h3>
        <p>Interview Rounds</p>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #1cc88a, #13855c);">
        <h3><?= count($platforms) ?></h3>
        <p>Active Platforms</p>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #36b9cc, #258391);">
        <h3><?= count($durations) ?></h3>
        <p>Duration Presets</p>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #f6c23e, #dda20a);">
        <h3><?= count($locations) ?></h3>
        <p>Interview Locations</p>
    </div>
</div>

<form method="post" action="<?= base_url('Setup/save_interview_configuration') ?>">
    
    <!-- General Settings -->
    <div class="config-section">
        <div class="section-header">
            <h4><i class="fas fa-sliders-h me-2"></i>General Settings</h4>
            <p>Configure default interview settings</p>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Default Interview Duration</label>
                    <select name="default_duration" class="form-control">
                        <option value="30" <?= $config->default_duration == 30 ? 'selected' : '' ?>>30 minutes</option>
                        <option value="45" <?= $config->default_duration == 45 ? 'selected' : '' ?>>45 minutes</option>
                        <option value="60" <?= $config->default_duration == 60 ? 'selected' : '' ?>>1 hour</option>
                        <option value="90" <?= $config->default_duration == 90 ? 'selected' : '' ?>>1.5 hours</option>
                        <option value="120" <?= $config->default_duration == 120 ? 'selected' : '' ?>>2 hours</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Default Interview Type</label>
                    <select name="default_interview_type" class="form-control">
                        <option value="online" <?= $config->default_interview_type == 'online' ? 'selected' : '' ?>>Online</option>
                        <option value="in_person" <?= $config->default_interview_type == 'in_person' ? 'selected' : '' ?>>In-Person</option>
                        <option value="phone" <?= $config->default_interview_type == 'phone' ? 'selected' : '' ?>>Phone</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Default Meeting Platform</label>
                    <select name="default_platform" class="form-control">
                        <option value="Zoom" <?= $config->default_platform == 'Zoom' ? 'selected' : '' ?>>Zoom</option>
                        <option value="Google Meet" <?= $config->default_platform == 'Google Meet' ? 'selected' : '' ?>>Google Meet</option>
                        <option value="Microsoft Teams" <?= $config->default_platform == 'Microsoft Teams' ? 'selected' : '' ?>>Microsoft Teams</option>
                        <option value="Skype" <?= $config->default_platform == 'Skype' ? 'selected' : '' ?>>Skype</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Timezone</label>
                    <select name="timezone" class="form-control">
                        <option value="Asia/Colombo" <?= $config->timezone == 'Asia/Colombo' ? 'selected' : '' ?>>Asia/Colombo (Sri Lanka)</option>
                        <option value="Asia/Kolkata" <?= $config->timezone == 'Asia/Kolkata' ? 'selected' : '' ?>>Asia/Kolkata (India)</option>
                        <option value="Asia/Dubai" <?= $config->timezone == 'Asia/Dubai' ? 'selected' : '' ?>>Asia/Dubai (UAE)</option>
                        <option value="UTC" <?= $config->timezone == 'UTC' ? 'selected' : '' ?>>UTC</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Interviewer Settings -->
    <div class="config-section">
        <div class="section-header">
            <h4><i class="fas fa-user-tie me-2"></i>Interviewer Settings</h4>
            <p>Configure interviewer assignment options</p>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>&nbsp;</label>
                    <div class="switch-label">
                        <label class="switch">
                            <input type="checkbox" name="allow_multiple_interviewers" value="1" 
                                   id="allow_multiple_interviewers"
                                   onchange="toggleMaxInterviewers()"
                                   <?= isset($config->allow_multiple_interviewers) && $config->allow_multiple_interviewers ? 'checked' : '' ?>>
                            <span class="slider"></span>
                        </label>
                        <span>Allow Multiple Interviewers</span>
                    </div>
                    <small class="text-muted">Enable panel interviews with multiple interviewers</small>
                </div>
            </div>
            <div class="col-md-6" id="max_interviewers_container" style="<?= isset($config->allow_multiple_interviewers) && $config->allow_multiple_interviewers ? '' : 'display: none;' ?>">
                <div class="form-group">
                    <label>Maximum Number of Interviewers</label>
                    <select name="max_interviewers" class="form-control" id="max_interviewers">
                        <option value="2" <?= isset($config->max_interviewers) && $config->max_interviewers == 2 ? 'selected' : '' ?>>2 interviewers</option>
                        <option value="3" <?= isset($config->max_interviewers) && $config->max_interviewers == 3 ? 'selected' : '' ?>>3 interviewers</option>
                        <option value="4" <?= isset($config->max_interviewers) && $config->max_interviewers == 4 ? 'selected' : '' ?>>4 interviewers</option>
                        <option value="5" <?= isset($config->max_interviewers) && $config->max_interviewers == 5 ? 'selected' : '' ?>>5 interviewers</option>
                        <option value="10" <?= isset($config->max_interviewers) && $config->max_interviewers == 10 ? 'selected' : '' ?>>10 interviewers</option>
                    </select>
                    <small class="text-muted">Maximum interviewers per interview (for panel interviews)</small>
                </div>
            </div>
        </div>
        
        <div class="info-box" id="panel_info_box" style="<?= isset($config->allow_multiple_interviewers) && $config->allow_multiple_interviewers ? '' : 'display: none;' ?>">
            <i class="fas fa-info-circle"></i>
            <strong>Panel Interviews:</strong> When enabled, you can assign multiple interviewers to a single interview. 
            This is useful for panel interviews, technical assessments with multiple evaluators, or interviews requiring different expertise areas.
        </div>
    </div>

    <!-- Scheduling Settings -->
    <div class="config-section">
        <div class="section-header">
            <h4><i class="fas fa-calendar-alt me-2"></i>Scheduling Settings</h4>
            <p>Configure interview scheduling rules and working hours</p>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Working Hours Start</label>
                    <input type="time" name="working_hours_start" class="form-control" value="<?= $config->working_hours_start ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Working Hours End</label>
                    <input type="time" name="working_hours_end" class="form-control" value="<?= $config->working_hours_end ?>">
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Buffer Time Between Interviews (minutes)</label>
                    <select name="buffer_time_minutes" class="form-control">
                        <option value="0" <?= $config->buffer_time_minutes == 0 ? 'selected' : '' ?>>No buffer</option>
                        <option value="5" <?= $config->buffer_time_minutes == 5 ? 'selected' : '' ?>>5 minutes</option>
                        <option value="10" <?= $config->buffer_time_minutes == 10 ? 'selected' : '' ?>>10 minutes</option>
                        <option value="15" <?= $config->buffer_time_minutes == 15 ? 'selected' : '' ?>>15 minutes</option>
                        <option value="30" <?= $config->buffer_time_minutes == 30 ? 'selected' : '' ?>>30 minutes</option>
                    </select>
                    <small class="text-muted">Time gap between consecutive interviews</small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>&nbsp;</label>
                    <div class="switch-label">
                        <label class="switch">
                            <input type="checkbox" name="enable_conflict_detection" value="1" <?= $config->enable_conflict_detection ? 'checked' : '' ?>>
                            <span class="slider"></span>
                        </label>
                        <span>Enable Conflict Detection</span>
                    </div>
                    <small class="text-muted">Warn if interviewer is already booked</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification Settings -->
    <div class="config-section">
        <div class="section-header">
            <h4><i class="fas fa-bell me-2"></i>Notification Settings</h4>
            <p>Configure how candidates and interviewers are notified</p>
        </div>
        
        <div class="info-box">
            <i class="fas fa-info-circle"></i>
            <strong>Note:</strong> Email notifications are always enabled. Additional notification channels can be configured below.
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="switch-label">
                    <label class="switch">
                        <input type="checkbox" name="enable_email_notifications" value="1" <?= $config->enable_email_notifications ? 'checked' : '' ?>>
                        <span class="slider"></span>
                    </label>
                    <span><i class="fas fa-envelope me-2"></i>Email Notifications</span>
                </div>
                <small class="text-muted d-block mb-3">Send interview invitations via email</small>
                
                <div class="switch-label">
                    <label class="switch">
                        <input type="checkbox" name="enable_whatsapp_notifications" value="1" <?= $config->enable_whatsapp_notifications ? 'checked' : '' ?>>
                        <span class="slider"></span>
                    </label>
                    <span><i class="fab fa-whatsapp me-2"></i>WhatsApp Notifications</span>
                </div>
                <small class="text-muted d-block mb-3">Send interview reminders via WhatsApp (requires Twilio setup)</small>
            </div>
            
            <div class="col-md-6">
                <div class="switch-label">
                    <label class="switch">
                        <input type="checkbox" name="enable_sms_notifications" value="1" <?= $config->enable_sms_notifications ? 'checked' : '' ?>>
                        <span class="slider"></span>
                    </label>
                    <span><i class="fas fa-sms me-2"></i>SMS Notifications</span>
                </div>
                <small class="text-muted d-block mb-3">Send interview reminders via SMS (requires SMS gateway)</small>
                
                <div class="form-group">
                    <label>Send Reminder Before Interview</label>
                    <select name="reminder_hours_before" class="form-control">
                        <option value="1" <?= $config->reminder_hours_before == 1 ? 'selected' : '' ?>>1 hour before</option>
                        <option value="2" <?= $config->reminder_hours_before == 2 ? 'selected' : '' ?>>2 hours before</option>
                        <option value="4" <?= $config->reminder_hours_before == 4 ? 'selected' : '' ?>>4 hours before</option>
                        <option value="12" <?= $config->reminder_hours_before == 12 ? 'selected' : '' ?>>12 hours before</option>
                        <option value="24" <?= $config->reminder_hours_before == 24 ? 'selected' : '' ?>>24 hours before</option>
                        <option value="48" <?= $config->reminder_hours_before == 48 ? 'selected' : '' ?>>48 hours before</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Advanced Settings -->
    <div class="config-section">
        <div class="section-header">
            <h4><i class="fas fa-cogs me-2"></i>Advanced Settings</h4>
            <p>Configure advanced features and integrations</p>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="switch-label">
                    <label class="switch">
                        <input type="checkbox" name="auto_generate_links" value="1" <?= $config->auto_generate_links ? 'checked' : '' ?>>
                        <span class="slider"></span>
                    </label>
                    <span><i class="fas fa-link me-2"></i>Auto-Generate Meeting Links</span>
                </div>
                <small class="text-muted d-block mb-3">Automatically generate meeting links for online interviews (requires API setup)</small>
            </div>
            
            <div class="col-md-6">
                <div class="switch-label">
                    <label class="switch">
                        <input type="checkbox" name="enable_calendar_sync" value="1" <?= $config->enable_calendar_sync ? 'checked' : '' ?>>
                        <span class="slider"></span>
                    </label>
                    <span><i class="fas fa-calendar-check me-2"></i>Calendar Sync</span>
                </div>
                <small class="text-muted d-block mb-3">Sync interviews with Google Calendar (requires OAuth setup)</small>
            </div>
        </div>
        
        <div class="info-box" style="background: #fff3cd; border-left-color: #ffc107;">
            <i class="fas fa-exclamation-triangle" style="color: #ffc107;"></i>
            <strong>API Integration Required:</strong> Some features require API keys and configuration. Visit the respective configuration pages to set up integrations.
        </div>
    </div>

    <!-- Submit Button -->
    <div class="text-end">
        <button type="submit" class="btn-primary">
            <i class="fas fa-save me-2"></i>Save Configuration
        </button>
    </div>
</form>

<!-- Quick Links to Sub-Configuration Pages -->
<div class="config-section mt-4">
    <div class="section-header">
        <h4><i class="fas fa-link me-2"></i>Quick Configuration Links</h4>
        <p>Manage detailed settings for each component</p>
    </div>
    
    <div class="row">
        <div class="col-md-3 mb-3">
            <a href="<?= base_url('Setup/interview_rounds') ?>" class="btn btn-outline-primary w-100">
                <i class="fas fa-list-ol me-2"></i>Manage Interview Rounds
            </a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="<?= base_url('Setup/meeting_platforms') ?>" class="btn btn-outline-primary w-100">
                <i class="fas fa-video me-2"></i>Configure Platforms
            </a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="<?= base_url('Setup/interview_locations') ?>" class="btn btn-outline-primary w-100">
                <i class="fas fa-map-marker-alt me-2"></i>Manage Locations
            </a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="<?= base_url('Setup/interview_templates') ?>" class="btn btn-outline-primary w-100">
                <i class="fas fa-envelope me-2"></i>Email Templates
            </a>
        </div>
    </div>
</div>

<style>
.btn-outline-primary {
    border: 2px solid #667eea;
    color: #667eea;
    background: white;
    padding: 12px 20px;
    border-radius: 6px;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s;
    text-align: center;
}

.btn-outline-primary:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.text-end {
    text-align: right;
}

.text-muted {
    color: #6c757d;
    font-size: 13px;
}

.d-block {
    display: block;
}

.mb-3 {
    margin-bottom: 1rem;
}

.mt-4 {
    margin-top: 1.5rem;
}

.w-100 {
    width: 100%;
}
</style>

<script>
// Toggle max interviewers field visibility
function toggleMaxInterviewers() {
    var checkbox = document.getElementById('allow_multiple_interviewers');
    var container = document.getElementById('max_interviewers_container');
    var infoBox = document.getElementById('panel_info_box');
    
    if (checkbox.checked) {
        container.style.display = 'block';
        if (infoBox) infoBox.style.display = 'block';
    } else {
        container.style.display = 'none';
        if (infoBox) infoBox.style.display = 'none';
    }
}
</script>

<?php
$this->load->view('templates/admin_footer');
?>
