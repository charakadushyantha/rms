<?php
$data['page_title'] = 'Audit Logs';
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
.stat-card {
    border-left: 4px solid;
    transition: transform 0.2s;
}
.stat-card:hover {
    transform: translateY(-2px);
}
.action-badge {
    font-size: 11px;
    padding: 4px 8px;
    font-weight: 600;
}
.log-row {
    transition: background 0.2s;
}
.log-row:hover {
    background: #f8f9fa;
}
</style>

<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="section-header">
    <h2 class="mb-1"><i class="fas fa-history me-2"></i>Audit Logs</h2>
    <p class="mb-0 opacity-90">Track all system activities and user actions</p>
</div>

<!-- Flash Messages -->
<?php if($this->session->flashdata('success_msg')): ?>
<div class="alert alert-success alert-dismissible fade show">
    <i class="fas fa-check-circle me-2"></i>
    <?= $this->session->flashdata('success_msg') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card stat-card border-0 shadow-sm" style="border-left-color: #4e73df !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Total Logs</div>
                        <div class="h4 mb-0"><?= number_format($stats['total']) ?></div>
                    </div>
                    <div class="text-primary">
                        <i class="fas fa-database fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card border-0 shadow-sm" style="border-left-color: #1cc88a !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Today</div>
                        <div class="h4 mb-0"><?= number_format($stats['today']) ?></div>
                    </div>
                    <div class="text-success">
                        <i class="fas fa-calendar-day fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card border-0 shadow-sm" style="border-left-color: #36b9cc !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">This Week</div>
                        <div class="h4 mb-0"><?= number_format($stats['this_week']) ?></div>
                    </div>
                    <div class="text-info">
                        <i class="fas fa-calendar-week fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card border-0 shadow-sm" style="border-left-color: #f6c23e !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">This Month</div>
                        <div class="h4 mb-0"><?= number_format($stats['this_month']) ?></div>
                    </div>
                    <div class="text-warning">
                        <i class="fas fa-calendar-alt fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card border-0 shadow-sm mb-3">
    <div class="card-header bg-white">
        <h6 class="mb-0"><i class="fas fa-filter me-2"></i>Filters</h6>
    </div>
    <div class="card-body">
        <form method="GET" action="<?= base_url('Setup/audit_logs') ?>" id="filterForm">
            <div class="row g-3">
                <div class="col-md-2">
                    <label class="form-label small">From Date</label>
                    <input type="date" class="form-control" name="from_date" value="<?= $this->input->get('from_date') ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label small">To Date</label>
                    <input type="date" class="form-control" name="to_date" value="<?= $this->input->get('to_date') ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Action</label>
                    <select class="form-select" name="action">
                        <option value="all">All Actions</option>
                        <?php foreach($actions as $act): ?>
                            <option value="<?= $act->action ?>" <?= $this->input->get('action') == $act->action ? 'selected' : '' ?>>
                                <?= $act->action ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Resource Type</label>
                    <select class="form-select" name="resource_type">
                        <option value="all">All Resources</option>
                        <?php foreach($resource_types as $type): ?>
                            <option value="<?= $type->resource_type ?>" <?= $this->input->get('resource_type') == $type->resource_type ? 'selected' : '' ?>>
                                <?= $type->resource_type ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small">User</label>
                    <input type="text" class="form-control" name="user" placeholder="Username/Email" value="<?= $this->input->get('user') ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label small">&nbsp;</label>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i>Filter
                        </button>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-8">
                    <input type="text" class="form-control" name="search" placeholder="Search in description, resource name, or username..." value="<?= $this->input->get('search') ?>">
                </div>
                <div class="col-md-2">
                    <a href="<?= base_url('Setup/audit_logs') ?>" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-redo me-1"></i>Reset
                    </a>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-success w-100" onclick="exportLogs()">
                        <i class="fas fa-download me-1"></i>Export CSV
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Logs Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0">
            <i class="fas fa-list me-2"></i>Audit Logs 
            <span class="badge bg-primary"><?= number_format($total_logs) ?> records</span>
        </h6>
        <button class="btn btn-sm btn-outline-danger" onclick="clearOldLogs()">
            <i class="fas fa-trash me-1"></i>Clear Old Logs
        </button>
    </div>
    <div class="card-body p-0">
        <?php if(empty($logs)): ?>
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <p class="text-muted">No audit logs found</p>
            </div>
        <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 150px;">Timestamp</th>
                        <th>User</th>
                        <th style="width: 100px;">Action</th>
                        <th>Resource</th>
                        <th>Description</th>
                        <th style="width: 120px;">IP Address</th>
                        <th style="width: 80px;">Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($logs as $log): ?>
                    <tr class="log-row">
                        <td>
                            <small class="text-muted">
                                <?= date('M d, Y', strtotime($log->created_at)) ?><br>
                                <?= date('h:i:s A', strtotime($log->created_at)) ?>
                            </small>
                        </td>
                        <td>
                            <div>
                                <strong><?= $log->username ?></strong>
                                <?php if($log->user_role): ?>
                                    <span class="badge bg-secondary ms-1" style="font-size: 9px;"><?= $log->user_role ?></span>
                                <?php endif; ?>
                            </div>
                            <small class="text-muted"><?= $log->user_email ?></small>
                        </td>
                        <td>
                            <?php
                            $badge_class = 'secondary';
                            switch($log->action) {
                                case 'CREATE': $badge_class = 'success'; break;
                                case 'UPDATE': $badge_class = 'warning'; break;
                                case 'DELETE': $badge_class = 'danger'; break;
                                case 'LOGIN': $badge_class = 'primary'; break;
                                case 'LOGOUT': $badge_class = 'info'; break;
                                case 'EXPORT': $badge_class = 'dark'; break;
                            }
                            ?>
                            <span class="badge bg-<?= $badge_class ?> action-badge"><?= $log->action ?></span>
                        </td>
                        <td>
                            <div><strong><?= $log->resource_type ?></strong></div>
                            <?php if($log->resource_name): ?>
                                <small class="text-muted"><?= $log->resource_name ?></small>
                            <?php endif; ?>
                        </td>
                        <td>
                            <small><?= $log->description ?></small>
                        </td>
                        <td>
                            <small class="text-muted">
                                <i class="fas fa-map-marker-alt me-1"></i><?= $log->ip_address ?>
                            </small>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" onclick="viewLogDetails(<?= $log->id ?>)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
    
    <!-- Pagination -->
    <?php if($total_pages > 1): ?>
    <div class="card-footer bg-white">
        <nav>
            <ul class="pagination justify-content-center mb-0">
                <li class="page-item <?= $current_page <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $current_page - 1 ?><?= http_build_query(array_filter($_GET, function($k) { return $k != 'page'; }, ARRAY_FILTER_USE_KEY)) ? '&' . http_build_query(array_filter($_GET, function($k) { return $k != 'page'; }, ARRAY_FILTER_USE_KEY)) : '' ?>">
                        <i class="fas fa-chevron-left"></i> Previous
                    </a>
                </li>
                
                <?php for($i = max(1, $current_page - 2); $i <= min($total_pages, $current_page + 2); $i++): ?>
                    <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?><?= http_build_query(array_filter($_GET, function($k) { return $k != 'page'; }, ARRAY_FILTER_USE_KEY)) ? '&' . http_build_query(array_filter($_GET, function($k) { return $k != 'page'; }, ARRAY_FILTER_USE_KEY)) : '' ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>
                
                <li class="page-item <?= $current_page >= $total_pages ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $current_page + 1 ?><?= http_build_query(array_filter($_GET, function($k) { return $k != 'page'; }, ARRAY_FILTER_USE_KEY)) ? '&' . http_build_query(array_filter($_GET, function($k) { return $k != 'page'; }, ARRAY_FILTER_USE_KEY)) : '' ?>">
                        Next <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="text-center text-muted small mt-2">
            Showing page <?= $current_page ?> of <?= $total_pages ?> (<?= number_format($total_logs) ?> total records)
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
function viewLogDetails(id) {
    Swal.fire({
        title: 'Loading...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    fetch('<?= base_url('Setup/view_audit_log/') ?>' + id, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const log = data.log;
            let html = `
                <div class="text-start">
                    <table class="table table-sm">
                        <tr><th>ID:</th><td>${log.id}</td></tr>
                        <tr><th>Timestamp:</th><td>${log.created_at}</td></tr>
                        <tr><th>User:</th><td>${log.username} (${log.user_email})</td></tr>
                        <tr><th>Role:</th><td>${log.user_role || 'N/A'}</td></tr>
                        <tr><th>Action:</th><td><span class="badge bg-primary">${log.action}</span></td></tr>
                        <tr><th>Resource Type:</th><td>${log.resource_type}</td></tr>
                        <tr><th>Resource Name:</th><td>${log.resource_name || 'N/A'}</td></tr>
                        <tr><th>Description:</th><td>${log.description || 'N/A'}</td></tr>
                        <tr><th>IP Address:</th><td>${log.ip_address}</td></tr>
                        <tr><th>User Agent:</th><td><small>${log.user_agent || 'N/A'}</small></td></tr>
                        <tr><th>Request Method:</th><td>${log.request_method || 'N/A'}</td></tr>
                        <tr><th>Request URL:</th><td><small>${log.request_url || 'N/A'}</small></td></tr>
                        <tr><th>Status:</th><td><span class="badge bg-${log.status === 'success' ? 'success' : 'danger'}">${log.status}</span></td></tr>
            `;
            
            if (log.old_values) {
                html += `<tr><th>Old Values:</th><td><pre class="mb-0">${log.old_values}</pre></td></tr>`;
            }
            if (log.new_values) {
                html += `<tr><th>New Values:</th><td><pre class="mb-0">${log.new_values}</pre></td></tr>`;
            }
            
            html += `</table></div>`;
            
            Swal.fire({
                title: 'Audit Log Details',
                html: html,
                width: '800px',
                confirmButtonText: 'Close'
            });
        } else {
            Swal.fire('Error', 'Failed to load log details', 'error');
        }
    })
    .catch(error => {
        Swal.fire('Error', 'Failed to load log details', 'error');
    });
}

function exportLogs() {
    const params = new URLSearchParams(window.location.search);
    window.location.href = '<?= base_url('Setup/export_audit_logs') ?>?' + params.toString();
}

function clearOldLogs() {
    Swal.fire({
        title: 'Clear Old Logs',
        html: `
            <p>Delete audit logs older than:</p>
            <select id="daysSelect" class="form-select">
                <option value="30">30 days</option>
                <option value="60">60 days</option>
                <option value="90" selected>90 days</option>
                <option value="180">180 days</option>
                <option value="365">1 year</option>
            </select>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Delete Old Logs',
        cancelButtonText: 'Cancel',
        preConfirm: () => {
            return document.getElementById('daysSelect').value;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?= base_url('Setup/clear_old_logs') ?>';
            
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'days';
            input.value = result.value;
            
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>

<?php $this->load->view('templates/admin_footer'); ?>
