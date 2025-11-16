<?php
$data['page_title'] = 'Calendar Sync';
$this->load->view('templates/admin_header', $data);
?>

<style>
.section-header {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
    padding: 16px 24px;
    border-radius: 12px;
    margin-bottom: 24px;
}
</style>

<div class="section-header">
    <h2 class="mb-1"><i class="fas fa-calendar-alt me-2"></i>Calendar Synchronization</h2>
    <p class="mb-0 opacity-90">Sync interviews with Google Calendar, Outlook, and iCal</p>
</div>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fab fa-google fa-3x" style="color: #4285f4;"></i>
                </div>
                <h5>Google Calendar</h5>
                <p class="text-muted small">Sync with Google Workspace</p>
                <span class="badge bg-secondary mb-3">Not Connected</span>
                <div>
                    <button class="btn btn-primary btn-sm">
                        <i class="fas fa-plug me-1"></i>Connect
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fab fa-microsoft fa-3x" style="color: #0078d4;"></i>
                </div>
                <h5>Outlook Calendar</h5>
                <p class="text-muted small">Sync with Microsoft 365</p>
                <span class="badge bg-secondary mb-3">Not Connected</span>
                <div>
                    <button class="btn btn-primary btn-sm">
                        <i class="fas fa-plug me-1"></i>Connect
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-calendar fa-3x" style="color: #667eea;"></i>
                </div>
                <h5>iCal / CalDAV</h5>
                <p class="text-muted small">Universal calendar format</p>
                <span class="badge bg-secondary mb-3">Not Connected</span>
                <div>
                    <button class="btn btn-primary btn-sm">
                        <i class="fas fa-plug me-1"></i>Connect
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('templates/admin_footer'); ?>
