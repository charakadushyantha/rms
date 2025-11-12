<?php
$data['page_title'] = 'Security Settings';
$this->load->view('templates/admin_header', $data);
?>

<style>
.section-header {
    background: linear-gradient(135deg, #e74a3b 0%, #c92a2a 100%);
    color: white;
    padding: 16px 24px;
    border-radius: 12px;
    margin-bottom: 24px;
}
</style>

<div class="section-header">
    <h2 class="mb-1"><i class="fas fa-shield-alt me-2"></i>Security Settings</h2>
    <p class="mb-0 opacity-90">Configure password policies and two-factor authentication</p>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0"><i class="fas fa-lock me-2"></i>Password Policy</h5>
            </div>
            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Minimum Length</label>
                        <input type="number" class="form-control" value="8" min="6" max="20">
                    </div>
                    
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" checked>
                        <label class="form-check-label">Require uppercase letters</label>
                    </div>
                    
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" checked>
                        <label class="form-check-label">Require lowercase letters</label>
                    </div>
                    
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" checked>
                        <label class="form-check-label">Require numbers</label>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox">
                        <label class="form-check-label">Require special characters</label>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Password Expiry (days)</label>
                        <input type="number" class="form-control" value="90">
                    </div>
                    
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-save me-2"></i>Save Policy
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="fas fa-mobile-alt me-2"></i>Two-Factor Authentication</h5>
            </div>
            <div class="card-body">
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox">
                    <label class="form-check-label">Enable 2FA for all users</label>
                </div>
                
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" checked>
                    <label class="form-check-label">Enable 2FA for admins only</label>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">2FA Method</label>
                    <select class="form-select">
                        <option>SMS</option>
                        <option selected>Email</option>
                        <option>Authenticator App</option>
                    </select>
                </div>
                
                <button class="btn btn-warning">
                    <i class="fas fa-save me-2"></i>Save Settings
                </button>
            </div>
        </div>
        
        <div class="card border-0 shadow-sm mt-3">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Session Settings</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Session Timeout (minutes)</label>
                    <input type="number" class="form-control" value="30">
                </div>
                
                <button class="btn btn-info">
                    <i class="fas fa-save me-2"></i>Save Settings
                </button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('templates/admin_footer'); ?>
