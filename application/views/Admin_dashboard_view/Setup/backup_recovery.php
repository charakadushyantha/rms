<?php
$data['page_title'] = 'Backup & Recovery';
$this->load->view('templates/admin_header', $data);
?>

<style>
.section-header {
    background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
    color: white;
    padding: 16px 24px;
    border-radius: 12px;
    margin-bottom: 24px;
}
</style>

<div class="section-header">
    <h2 class="mb-1"><i class="fas fa-hdd me-2"></i>Backup & Recovery</h2>
    <p class="mb-0 opacity-90">Database backup management and restoration</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-clock me-2 text-primary"></i>Automatic Backups</h5>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" checked>
                    <label class="form-check-label">Enable automatic backups</label>
                </div>
                <div class="mb-3">
                    <label class="form-label">Frequency</label>
                    <select class="form-select">
                        <option>Every 6 hours</option>
                        <option selected>Daily</option>
                        <option>Weekly</option>
                    </select>
                </div>
                <button class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Save Settings
                </button>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-list me-2"></i>Backup History</h5>
            </div>
            <div class="card-body">
                <button class="btn btn-primary mb-3">
                    <i class="fas fa-plus me-2"></i>Create Manual Backup
                </button>
                
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Size</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2024-11-12 08:00</td>
                                <td><span class="badge bg-primary">Automatic</span></td>
                                <td>245 MB</td>
                                <td><span class="badge bg-success">Complete</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-download"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-undo"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>2024-11-11 08:00</td>
                                <td><span class="badge bg-primary">Automatic</span></td>
                                <td>243 MB</td>
                                <td><span class="badge bg-success">Complete</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-download"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-undo"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('templates/admin_footer'); ?>
