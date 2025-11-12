<?php
$data['page_title'] = 'EPF/ETF Settings';
$this->load->view('templates/admin_header', $data);
?>

<style>
.section-header {
    background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%);
    color: white;
    padding: 16px 24px;
    border-radius: 12px;
    margin-bottom: 24px;
}
.config-card {
    background: white;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    margin-bottom: 24px;
}
</style>

<div class="section-header">
    <h2 class="mb-1"><i class="fas fa-piggy-bank me-2"></i>EPF/ETF Settings</h2>
    <p class="mb-0 opacity-90">Configure Employee Provident Fund and Employee Trust Fund settings</p>
</div>

<!-- Flash Messages -->
<?php if($this->session->flashdata('success_msg')): ?>
<div class="alert alert-success alert-dismissible fade show">
    <i class="fas fa-check-circle me-2"></i>
    <?= $this->session->flashdata('success_msg') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="config-card">
    <h4 class="mb-4"><i class="fas fa-cog me-2 text-warning"></i>EPF/ETF Configuration</h4>
    
    <form action="<?= base_url('Setup/save_epf_etf') ?>" method="POST">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><i class="fas fa-percentage me-2 text-primary"></i>EPF Rates</h5>
                        
                        <div class="mb-3">
                            <label class="form-label">Employee Contribution (%)</label>
                            <input type="number" class="form-control" name="epf_employee" value="8" step="0.01" min="0" max="100">
                            <small class="text-muted">Standard: 8%</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Employer Contribution (%)</label>
                            <input type="number" class="form-control" name="epf_employer" value="12" step="0.01" min="0" max="100">
                            <small class="text-muted">Standard: 12%</small>
                        </div>
                        
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="epf_enabled" checked>
                            <label class="form-check-label">Enable EPF Calculation</label>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><i class="fas fa-percentage me-2 text-success"></i>ETF Rates</h5>
                        
                        <div class="mb-3">
                            <label class="form-label">Employer Contribution (%)</label>
                            <input type="number" class="form-control" name="etf_employer" value="3" step="0.01" min="0" max="100">
                            <small class="text-muted">Standard: 3%</small>
                        </div>
                        
                        <div class="alert alert-info mb-3">
                            <small><i class="fas fa-info-circle me-1"></i>ETF is paid entirely by the employer</small>
                        </div>
                        
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="etf_enabled" checked>
                            <label class="form-check-label">Enable ETF Calculation</label>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><i class="fas fa-building me-2 text-info"></i>Registration Details</h5>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">EPF Registration Number</label>
                                <input type="text" class="form-control" name="epf_reg_number" placeholder="EPF/XXX/XXXX">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">ETF Registration Number</label>
                                <input type="text" class="form-control" name="etf_reg_number" placeholder="ETF/XXX/XXXX">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-12">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save me-2"></i>Save EPF/ETF Settings
                </button>
            </div>
        </div>
    </form>
</div>

<?php $this->load->view('templates/admin_footer'); ?>
