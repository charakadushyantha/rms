<?php
$data['page_title'] = 'Job Boards Integration';
$this->load->view('templates/admin_header', $data);
?>

<style>
.section-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 16px 24px;
    border-radius: 12px;
    margin-bottom: 24px;
}
.integration-card {
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 16px;
    transition: all 0.3s;
}
.integration-card:hover {
    border-color: #667eea;
    transform: translateY(-2px);
}
</style>

<div class="section-header">
    <h2 class="mb-1"><i class="fas fa-briefcase me-2"></i>Job Boards Integration</h2>
    <p class="mb-0 opacity-90">Connect with LinkedIn, Indeed, Glassdoor and more</p>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="integration-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h5 class="mb-1"><i class="fab fa-linkedin me-2" style="color: #0077b5;"></i>LinkedIn</h5>
                    <p class="text-muted small mb-0">Post jobs directly to LinkedIn</p>
                </div>
                <span class="badge bg-secondary">Not Connected</span>
            </div>
            <button class="btn btn-primary btn-sm">
                <i class="fas fa-plug me-1"></i>Connect LinkedIn
            </button>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="integration-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h5 class="mb-1"><i class="fas fa-search me-2" style="color: #2164f3;"></i>Indeed</h5>
                    <p class="text-muted small mb-0">Reach millions of job seekers</p>
                </div>
                <span class="badge bg-secondary">Not Connected</span>
            </div>
            <button class="btn btn-primary btn-sm">
                <i class="fas fa-plug me-1"></i>Connect Indeed
            </button>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="integration-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h5 class="mb-1"><i class="fas fa-building me-2" style="color: #0caa41;"></i>Glassdoor</h5>
                    <p class="text-muted small mb-0">Employer branding & job posting</p>
                </div>
                <span class="badge bg-secondary">Not Connected</span>
            </div>
            <button class="btn btn-primary btn-sm">
                <i class="fas fa-plug me-1"></i>Connect Glassdoor
            </button>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="integration-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h5 class="mb-1"><i class="fas fa-globe me-2" style="color: #ff6b35;"></i>TopJobs.lk</h5>
                    <p class="text-muted small mb-0">Sri Lanka's leading job portal</p>
                </div>
                <span class="badge bg-secondary">Not Connected</span>
            </div>
            <button class="btn btn-primary btn-sm">
                <i class="fas fa-plug me-1"></i>Connect TopJobs
            </button>
        </div>
    </div>
</div>

<?php $this->load->view('templates/admin_footer'); ?>
