<?php
$data['page_title'] = 'API Management';
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
    <h2 class="mb-1"><i class="fas fa-code me-2"></i>API Management</h2>
    <p class="mb-0 opacity-90">Manage API keys and endpoints</p>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-key me-2"></i>API Keys</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Key</th>
                        <th>Created</th>
                        <th>Last Used</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Production API</td>
                        <td><code>rms_prod_***************</code></td>
                        <td>2024-01-15</td>
                        <td>2 hours ago</td>
                        <td>
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>Development API</td>
                        <td><code>rms_dev_***************</code></td>
                        <td>2024-02-01</td>
                        <td>1 day ago</td>
                        <td>
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <button class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Generate New API Key
        </button>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0"><i class="fas fa-link me-2"></i>API Endpoints</h5>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <strong>Base URL:</strong> <code>https://yourdomain.com/api/v1/</code>
        </div>
        <div class="list-group">
            <div class="list-group-item">
                <div class="d-flex justify-content-between">
                    <span><span class="badge bg-success">GET</span> <code>/candidates</code></span>
                    <small class="text-muted">List all candidates</small>
                </div>
            </div>
            <div class="list-group-item">
                <div class="d-flex justify-content-between">
                    <span><span class="badge bg-primary">POST</span> <code>/candidates</code></span>
                    <small class="text-muted">Create new candidate</small>
                </div>
            </div>
            <div class="list-group-item">
                <div class="d-flex justify-content-between">
                    <span><span class="badge bg-success">GET</span> <code>/jobs</code></span>
                    <small class="text-muted">List all jobs</small>
                </div>
            </div>
            <div class="list-group-item">
                <div class="d-flex justify-content-between">
                    <span><span class="badge bg-primary">POST</span> <code>/jobs</code></span>
                    <small class="text-muted">Create new job</small>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('templates/admin_footer'); ?>
