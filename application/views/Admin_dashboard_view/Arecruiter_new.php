<?php
// Set page-specific variables
$data['page_title'] = 'Manage Recruiters';
$data['use_datatable'] = true;

// Load the header template
$this->load->view('templates/admin_header', $data);
?>

<!-- Stats Row -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-card-title">Total Recruiters</div>
                <div class="stat-card-icon" style="background: rgba(102, 126, 234, 0.1); color: var(--primary-color);">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="stat-card-value">0</div>
            <div class="stat-card-footer">Active recruiters in system</div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="stat-card success">
            <div class="stat-card-header">
                <div class="stat-card-title">Active</div>
                <div class="stat-card-icon" style="background: rgba(28, 200, 138, 0.1); color: var(--success-color);">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
            <div class="stat-card-value">0</div>
            <div class="stat-card-footer">Activated accounts</div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="stat-card warning">
            <div class="stat-card-header">
                <div class="stat-card-title">Pending</div>
                <div class="stat-card-icon" style="background: rgba(246, 194, 62, 0.1); color: var(--warning-color);">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
            <div class="stat-card-value">0</div>
            <div class="stat-card-footer">Awaiting activation</div>
        </div>
    </div>
</div>

<!-- Recruiters Table -->
<div class="data-card">
    <div class="data-card-header">
        <h3 class="data-card-title">All Recruiters</h3>
        <button class="btn btn-primary-modern btn-modern" data-bs-toggle="modal" data-bs-target="#addRecruiterModal">
            <i class="fas fa-user-plus me-2"></i>Add Recruiter
        </button>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover" id="recruitersTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Joined Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be loaded here -->
                <tr>
                    <td>1</td>
                    <td>-</td>
                    <td>-</td>
                    <td><span class="badge bg-secondary">No Data</span></td>
                    <td>-</td>
                    <td>-</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="confirmModalTitle">Confirm Action</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="mb-3">
                    <i class="fas fa-exclamation-triangle" style="font-size: 48px; color: #ffc107;"></i>
                </div>
                <p id="confirmModalMessage" style="font-size: 16px; color: #333;"></p>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary-modern btn-modern" id="confirmModalBtn">Confirm</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Recruiter Modal -->
<div class="modal fade" id="addRecruiterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Recruiter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addRecruiterForm">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <option value="0">Pending</option>
                            <option value="1">Active</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary-modern btn-modern" onclick="saveRecruiter()">Add Recruiter</button>
            </div>
        </div>
    </div>
</div>

<?php
$custom_script = "
let recruitersTable;

// Initialize DataTable and load data
$(document).ready(function() {
    recruitersTable = $('#recruitersTable').DataTable({
        responsive: true,
        pageLength: 10,
        language: {
            emptyTable: 'No recruiters found. Add your first recruiter!',
            zeroRecords: 'No matching recruiters found',
            search: '_INPUT_',
            searchPlaceholder: 'Search recruiters...'
        },
        columnDefs: [
            { orderable: false, targets: 5 } // Disable sorting on Actions column
        ]
    });
    
    loadRecruiters();
    loadStats();
});

// Load recruiters data
function loadRecruiters() {
    $.ajax({
        url: '" . base_url('recruiter_management/get_recruiters') . "',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                recruitersTable.clear();
                
                response.data.forEach(function(recruiter, index) {
                    const statusBadge = recruiter.status == 1 
                        ? '<span class=\"badge bg-success\">Active</span>' 
                        : '<span class=\"badge bg-warning\">Pending</span>';
                    
                    const statusButton = recruiter.status == 1
                        ? `<button class=\"btn btn-sm btn-warning\" onclick=\"deactivateRecruiter(\${recruiter.id})\" title=\"Deactivate\">
                            <i class=\"fas fa-ban\"></i>
                           </button>`
                        : `<button class=\"btn btn-sm btn-success\" onclick=\"activateRecruiter(\${recruiter.id})\" title=\"Activate\">
                            <i class=\"fas fa-check\"></i>
                           </button>`;
                    
                    const actions = `
                        \${statusButton}
                        <button class=\"btn btn-sm btn-danger\" onclick=\"deleteRecruiter(\${recruiter.id})\" title=\"Delete\">
                            <i class=\"fas fa-trash\"></i>
                        </button>
                    `;
                    
                    recruitersTable.row.add([
                        index + 1,
                        recruiter.username,
                        recruiter.email,
                        statusBadge,
                        recruiter.created_at ? new Date(recruiter.created_at).toLocaleDateString() : '-',
                        actions
                    ]);
                });
                
                recruitersTable.draw();
            }
        },
        error: function() {
            alert('Failed to load recruiters');
        }
    });
}

// Load statistics
function loadStats() {
    $.ajax({
        url: '" . base_url('recruiter_management/get_stats') . "',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('.stat-card:eq(0) .stat-card-value').text(response.stats.total);
                $('.stat-card:eq(1) .stat-card-value').text(response.stats.active);
                $('.stat-card:eq(2) .stat-card-value').text(response.stats.pending);
            }
        }
    });
}

// Save recruiter
function saveRecruiter() {
    const form = $('#addRecruiterForm');
    const data = {
        username: form.find('[name=\"username\"]').val(),
        email: form.find('[name=\"email\"]').val(),
        password: form.find('[name=\"password\"]').val(),
        status: form.find('[name=\"status\"]').val()
    };
    
    $.ajax({
        url: '" . base_url('recruiter_management/add_recruiter') . "',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(data),
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                showToast(response.message, 'success');
                $('#addRecruiterModal').modal('hide');
                form[0].reset();
                loadRecruiters();
                loadStats();
            } else {
                showToast(response.message, 'error');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', xhr.responseText);
            showToast('Failed to add recruiter: ' + (xhr.responseJSON ? xhr.responseJSON.message : error), 'error');
        }
    });
}

// Custom confirm dialog
function showConfirm(title, message, callback) {
    $('#confirmModalTitle').text(title);
    $('#confirmModalMessage').text(message);
    
    // Remove old click handlers
    $('#confirmModalBtn').off('click');
    
    // Add new click handler
    $('#confirmModalBtn').on('click', function() {
        $('#confirmModal').modal('hide');
        callback();
    });
    
    $('#confirmModal').modal('show');
}

// Show toast notification
function showToast(message, type = 'success') {
    const bgColor = type === 'success' ? '#28a745' : type === 'error' ? '#dc3545' : '#ffc107';
    const icon = type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle';
    
    const toast = $(`
        <div class=\"toast-notification\" style=\"position: fixed; top: 20px; right: 20px; background: \${bgColor}; color: white; padding: 15px 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.3); z-index: 9999; display: flex; align-items: center; gap: 10px; min-width: 300px;\">
            <i class=\"fas fa-\${icon}\" style=\"font-size: 20px;\"></i>
            <span>\${message}</span>
        </div>
    `);
    
    $('body').append(toast);
    
    setTimeout(function() {
        toast.fadeOut(300, function() {
            $(this).remove();
        });
    }, 3000);
}

// Activate recruiter
function activateRecruiter(id) {
    showConfirm(
        'Activate Recruiter',
        'Are you sure you want to activate this recruiter?',
        function() {
            $.ajax({
            url: '" . base_url('recruiter_management/update_status') . "',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ id: id, status: 1 }),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    showToast(response.message, 'success');
                    loadRecruiters();
                    loadStats();
                } else {
                    showToast(response.message, 'error');
                }
            },
            error: function() {
                showToast('Failed to activate recruiter', 'error');
            }
        });
        }
    );
}

// Deactivate recruiter
function deactivateRecruiter(id) {
    showConfirm(
        'Deactivate Recruiter',
        'Are you sure you want to deactivate this recruiter?',
        function() {
            $.ajax({
            url: '" . base_url('recruiter_management/update_status') . "',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ id: id, status: 0 }),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    showToast('Recruiter deactivated successfully', 'success');
                    loadRecruiters();
                    loadStats();
                } else {
                    showToast(response.message, 'error');
                }
            },
            error: function() {
                showToast('Failed to deactivate recruiter', 'error');
            }
        });
        }
    );
}

// Delete recruiter
function deleteRecruiter(id) {
    showConfirm(
        'Delete Recruiter',
        'Are you sure you want to delete this recruiter? This action cannot be undone.',
        function() {
            $.ajax({
            url: '" . base_url('recruiter_management/delete_recruiter') . "',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ id: id }),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    showToast(response.message, 'success');
                    loadRecruiters();
                    loadStats();
                } else {
                    showToast(response.message, 'error');
                }
            },
            error: function() {
                showToast('Failed to delete recruiter', 'error');
            }
        });
        }
    );
}
";

$data['custom_script'] = $custom_script;

// Load the footer template
$this->load->view('templates/admin_footer', $data);
?>
