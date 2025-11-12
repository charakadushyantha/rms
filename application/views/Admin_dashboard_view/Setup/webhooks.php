<?php
$data['page_title'] = 'Webhooks';
$this->load->view('templates/admin_header', $data);
?>

<style>
.section-header {
    background: linear-gradient(135deg, #36b9cc 0%, #258391 100%);
    color: white;
    padding: 16px 24px;
    border-radius: 12px;
    margin-bottom: 24px;
}
</style>

<div class="section-header">
    <h2 class="mb-1"><i class="fas fa-webhook me-2"></i>Webhooks</h2>
    <p class="mb-0 opacity-90">Configure event-driven integrations</p>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <button class="btn btn-primary mb-3">
            <i class="fas fa-plus me-2"></i>Add New Webhook
        </button>
        
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Event</th>
                        <th>URL</th>
                        <th>Status</th>
                        <th>Last Triggered</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><span class="badge bg-primary">candidate.created</span></td>
                        <td><code>https://example.com/webhook</code></td>
                        <td><span class="badge bg-success">Active</span></td>
                        <td>5 minutes ago</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="badge bg-success">interview.scheduled</span></td>
                        <td><code>https://example.com/interview</code></td>
                        <td><span class="badge bg-success">Active</span></td>
                        <td>1 hour ago</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Available Events</h5>
    </div>
    <div class="card-body">
        <div class="row g-2">
            <div class="col-md-6">
                <span class="badge bg-primary">candidate.created</span>
                <span class="badge bg-primary">candidate.updated</span>
                <span class="badge bg-primary">candidate.deleted</span>
            </div>
            <div class="col-md-6">
                <span class="badge bg-success">interview.scheduled</span>
                <span class="badge bg-success">interview.completed</span>
                <span class="badge bg-success">interview.cancelled</span>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('templates/admin_footer'); ?>
