<?php
$data['page_title'] = 'Database';
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
</style>

<div class="section-header">
    <h2 class="mb-1"><i class="fas fa-database me-2"></i>Database Management</h2>
    <p class="mb-0 opacity-90">View database tables and statistics</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="fas fa-table fa-2x text-primary mb-2"></i>
                <h3 class="mb-0">42</h3>
                <small class="text-muted">Total Tables</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="fas fa-users fa-2x text-success mb-2"></i>
                <h3 class="mb-0">1,234</h3>
                <small class="text-muted">Total Records</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="fas fa-hdd fa-2x text-warning mb-2"></i>
                <h3 class="mb-0">245 MB</h3>
                <small class="text-muted">Database Size</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="fas fa-clock fa-2x text-info mb-2"></i>
                <h3 class="mb-0">2 hours</h3>
                <small class="text-muted">Last Backup</small>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Database Tables</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Table Name</th>
                        <th>Rows</th>
                        <th>Size</th>
                        <th>Engine</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><code>candidates</code></td>
                        <td>456</td>
                        <td>12.5 MB</td>
                        <td>InnoDB</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i> View
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><code>jobs</code></td>
                        <td>89</td>
                        <td>3.2 MB</td>
                        <td>InnoDB</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i> View
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><code>interviews</code></td>
                        <td>234</td>
                        <td>5.8 MB</td>
                        <td>InnoDB</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i> View
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><code>users</code></td>
                        <td>45</td>
                        <td>1.2 MB</td>
                        <td>InnoDB</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i> View
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $this->load->view('templates/admin_footer'); ?>
