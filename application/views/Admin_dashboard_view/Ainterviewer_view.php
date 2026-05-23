<?php
// Set page-specific variables
$data['page_title'] = 'Manage Interviewers';
$data['use_datatable'] = true;

// Load the header template
$this->load->view('templates/admin_header', $data);
?>

<!-- Stats Row -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-card-title">Total Interviewers</div>
                <div class="stat-card-icon" style="background: rgba(102, 126, 234, 0.1); color: var(--primary-color);">
                    <i class="fas fa-user-check"></i>
                </div>
            </div>
            <div class="stat-card-value" id="totalInterviewers">0</div>
            <div class="stat-card-footer">Registered interviewers</div>
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
            <div class="stat-card-value" id="activeInterviewers">0</div>
            <div class="stat-card-footer">Conducted interviews</div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="stat-card info">
            <div class="stat-card-header">
                <div class="stat-card-title">Availability</div>
                <div class="stat-card-icon" style="background: rgba(54, 185, 204, 0.1); color: var(--info-color);">
                    <i class="fas fa-calendar-check"></i>
                </div>
            </div>
            <div class="stat-card-value" id="availabilityRate">0%</div>
            <div class="stat-card-footer">Utilization rate</div>
        </div>
    </div>
</div>

<!-- Interviewers Table -->
<div class="data-card">
    <div class="data-card-header">
        <h3 class="data-card-title">All Interviewers</h3>
        <button class="btn btn-primary-modern btn-modern" data-bs-toggle="modal" data-bs-target="#addInterviewerModal">
            <i class="fas fa-user-plus me-2"></i>Add Interviewer
        </button>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover" id="interviewersTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Gender</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- DataTables will populate this -->
            </tbody>
        </table>
    </div>
</div>

<!-- Add Interviewer Modal -->
<div class="modal fade" id="addInterviewerModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white;">
                <h5 class="modal-title">
                    <i class="fas fa-user-plus me-2"></i>Add New Interviewer
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addInterviewerForm">
                    <div class="mb-3">
                        <label class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="password" required minlength="6">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="tel" class="form-control" name="phone">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gender</label>
                        <select class="form-select" name="gender">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary-modern btn-modern" onclick="saveInterviewer()">Add Interviewer</button>
            </div>
        </div>
    </div>
</div>

<!-- View Interviewer Modal -->
<div class="modal fade" id="viewInterviewerModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #17a2b8, #138496); color: white;">
                <h5 class="modal-title"><i class="fas fa-user-check me-2"></i>Interviewer Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="interviewerDetailsContent">
                <div class="text-center py-4">
                    <i class="fas fa-spinner fa-spin fa-2x"></i>
                    <p class="mt-2">Loading...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Interviewer Modal -->
<div class="modal fade" id="editInterviewerModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #f59e0b, #f97316); color: white;">
                <h5 class="modal-title"><i class="fas fa-user-edit me-2"></i>Edit Interviewer</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editInterviewerForm">
                    <input type="hidden" id="edit_int_username" name="username">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Username</label>
                        <input type="text" class="form-control" id="edit_int_username_display" readonly
                               style="background:#f8f9fa; color:#888;">
                        <small class="text-muted">Username cannot be changed</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="edit_int_email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">New Password</label>
                        <input type="password" class="form-control" id="edit_int_password" name="password"
                               placeholder="Leave blank to keep current password" minlength="6">
                        <small class="text-muted">Leave blank to keep the existing password</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Phone</label>
                        <input type="tel" class="form-control" id="edit_int_phone" name="phone">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Gender</label>
                        <select class="form-select" id="edit_int_gender" name="gender">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" onclick="saveEditInterviewer()"
                        style="background:linear-gradient(135deg,#f59e0b,#f97316);border:none;color:#fff;">
                    <i class="fas fa-save me-1"></i>Save Changes
                </button>
            </div>
        </div>
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

<style>
.detail-item {
    padding: 12px;
    background: #f8f9fa;
    border-radius: 8px;
    border-left: 3px solid var(--primary-color);
    margin-bottom: 10px;
}
.detail-item label {
    font-weight: 600;
    color: #666;
    font-size: 13px;
    margin-bottom: 5px;
    display: block;
}
.detail-item p {
    margin: 0;
    color: #333;
    font-size: 14px;
}
</style>

<?php
$custom_script = "
(function() {
    let interviewersTable;

    $(document).ready(function() {
        interviewersTable = $('#interviewersTable').DataTable({
        responsive: true,
        pageLength: 10,
        language: {
            emptyTable: 'No interviewers found. Add your first interviewer!',
            zeroRecords: 'No matching interviewers found',
            search: '_INPUT_',
            searchPlaceholder: 'Search interviewers...'
        },
        columnDefs: [
            { orderable: false, targets: 5 }
        ]
    });
    
    loadInterviewers();
});

function loadInterviewers() {
    $.ajax({
        url: '" . base_url('A_dashboard/get_all_interviewers') . "',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                interviewersTable.clear();
                
                $('#totalInterviewers').text(response.stats.total);
                $('#activeInterviewers').text(response.stats.active);
                const rate = response.stats.total > 0 ? Math.round((response.stats.active / response.stats.total) * 100) : 0;
                $('#availabilityRate').text(rate + '%');
                
                if (response.data && response.data.length > 0) {
                    response.data.forEach(function(interviewer, index) {
                        const actions = '<button class=\"btn btn-sm btn-info\" onclick=\"viewInterviewer(' + \"'\" + interviewer.username + \"'\" + ')\" title=\"View\"><i class=\"fas fa-eye\"></i></button> ' +
                            '<button class=\"btn btn-sm\" onclick=\"editInterviewer(' + \"'\" + interviewer.username + \"'\" + ')\" title=\"Edit\" style=\"background:linear-gradient(135deg,#f59e0b,#f97316);border:none;color:#fff;\"><i class=\"fas fa-edit\"></i></button> ' +
                            '<button class=\"btn btn-sm btn-danger\" onclick=\"deleteInterviewer(' + \"'\" + interviewer.username + \"'\" + ')\" title=\"Delete\"><i class=\"fas fa-trash\"></i></button>';
                        
                        interviewersTable.row.add([
                            index + 1,
                            interviewer.username,
                            interviewer.email,
                            interviewer.phone || 'N/A',
                            interviewer.gender || 'N/A',
                            actions
                        ]);
                    });
                }
                
                interviewersTable.draw();
            }
        },
        error: function() {
            showToast('Failed to load interviewers', 'error');
        }
    });
}

function saveInterviewer() {
    const form = $('#addInterviewerForm');
    const data = {
        username: form.find('[name=\"username\"]').val(),
        email: form.find('[name=\"email\"]').val(),
        password: form.find('[name=\"password\"]').val(),
        phone: form.find('[name=\"phone\"]').val(),
        gender: form.find('[name=\"gender\"]').val()
    };
    
    $.ajax({
        url: '" . base_url('A_dashboard/add_interviewer') . "',
        type: 'POST',
        data: data,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                showToast(response.message, 'success');
                const modal = bootstrap.Modal.getInstance(document.getElementById('addInterviewerModal'));
                if (modal) modal.hide();
                form[0].reset();
                loadInterviewers();
            } else {
                showToast(response.message, 'error');
            }
        },
        error: function() {
            showToast('Failed to add interviewer', 'error');
        }
    });
}

function viewInterviewer(username) {
    $.ajax({
        url: '" . base_url('A_dashboard/get_interviewer_details') . "',
        type: 'POST',
        data: { username: username },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                const interviewer = response.interviewer;
                const interviews = response.interviews || [];
                
                let interviewsHtml = '';
                if (interviews.length > 0) {
                    interviewsHtml = '<div class=\"table-responsive mt-3\"><table class=\"table table-sm\"><thead><tr><th>Candidate</th><th>Date</th><th>Round</th></tr></thead><tbody>';
                    interviews.forEach(function(interview) {
                        interviewsHtml += '<tr><td>' + interview.ce_can_name + '</td><td>' + interview.ce_start_date + '</td><td>Round ' + interview.ce_interview_round + '</td></tr>';
                    });
                    interviewsHtml += '</tbody></table></div>';
                } else {
                    interviewsHtml = '<p class=\"text-muted mt-3\">No interviews conducted yet.</p>';
                }
                
                const content = '<div class=\"row g-3\">' +
                    '<div class=\"col-md-6\"><div class=\"detail-item\"><label><i class=\"fas fa-user me-2\"></i>Username</label><p>' + (interviewer.u_username || 'N/A') + '</p></div></div>' +
                    '<div class=\"col-md-6\"><div class=\"detail-item\"><label><i class=\"fas fa-envelope me-2\"></i>Email</label><p>' + (interviewer.u_email || 'N/A') + '</p></div></div>' +
                    '<div class=\"col-md-6\"><div class=\"detail-item\"><label><i class=\"fas fa-phone me-2\"></i>Phone</label><p>' + (interviewer.pi_phone || 'N/A') + '</p></div></div>' +
                    '<div class=\"col-md-6\"><div class=\"detail-item\"><label><i class=\"fas fa-venus-mars me-2\"></i>Gender</label><p>' + (interviewer.pi_gender || 'N/A') + '</p></div></div>' +
                    '<div class=\"col-12\"><div class=\"detail-item\"><label><i class=\"fas fa-history me-2\"></i>Interview History (' + interviews.length + ' total)</label>' + interviewsHtml + '</div></div>' +
                '</div>';
                
                $('#interviewerDetailsContent').html(content);
                const modal = new bootstrap.Modal(document.getElementById('viewInterviewerModal'));
                modal.show();
            } else {
                showToast(response.message || 'Failed to load interviewer details', 'error');
            }
        },
        error: function() {
            showToast('Failed to fetch interviewer details', 'error');
        }
    });
}

function editInterviewer(username) {
    $.ajax({
        url: '" . base_url('A_dashboard/get_interviewer_details') . "',
        type: 'POST',
        data: { username: username },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                const interviewer = response.interviewer;
                $('#edit_int_username').val(interviewer.u_username);
                $('#edit_int_username_display').val(interviewer.u_username);
                $('#edit_int_email').val(interviewer.u_email);
                $('#edit_int_password').val('');
                $('#edit_int_phone').val(interviewer.pi_phone || '');
                $('#edit_int_gender').val(interviewer.pi_gender || '');
                const modal = new bootstrap.Modal(document.getElementById('editInterviewerModal'));
                modal.show();
            } else {
                showToast(response.message || 'Failed to load interviewer', 'error');
            }
        },
        error: function() {
            showToast('Failed to load interviewer details', 'error');
        }
    });
}

function saveEditInterviewer() {
    const username = $('#edit_int_username').val();
    const email = $('#edit_int_email').val().trim();
    const password = $('#edit_int_password').val();
    const phone = $('#edit_int_phone').val();
    const gender = $('#edit_int_gender').val();

    if (!email) {
        showToast('Email is required', 'error');
        return;
    }

    $.ajax({
        url: '" . base_url('A_dashboard/update_interviewer') . "',
        type: 'POST',
        data: { username: username, email: email, password: password, phone: phone, gender: gender },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                showToast(response.message, 'success');
                const modal = bootstrap.Modal.getInstance(document.getElementById('editInterviewerModal'));
                if (modal) modal.hide();
                loadInterviewers();
            } else {
                showToast(response.message || 'Failed to update interviewer', 'error');
            }
        },
        error: function() {
            showToast('Failed to update interviewer', 'error');
        }
    });
}

function deleteInterviewer(username) {
    showConfirm(
        'Delete Interviewer',
        'Are you sure you want to delete ' + username + '? This action cannot be undone.',
        function() {
            $.ajax({
                url: '" . base_url('A_dashboard/delete_interviewer') . "',
                type: 'POST',
                data: { username: username },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        showToast(response.message, 'success');
                        loadInterviewers();
                    } else {
                        showToast(response.message, 'error');
                    }
                },
                error: function() {
                    showToast('Failed to delete interviewer', 'error');
                }
            });
        }
    );
}

function showConfirm(title, message, callback) {
    $('#confirmModalTitle').text(title);
    $('#confirmModalMessage').text(message);
    
    $('#confirmModalBtn').off('click');
    $('#confirmModalBtn').on('click', function() {
        const modal = bootstrap.Modal.getInstance(document.getElementById('confirmModal'));
        if (modal) modal.hide();
        callback();
    });
    
    const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
    confirmModal.show();
}

function showToast(message, type) {
    const bgColor = type === 'success' ? '#28a745' : type === 'error' ? '#dc3545' : '#ffc107';
    const icon = type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle';
    
    const toast = $('<div class=\"toast-notification\" style=\"position: fixed; top: 20px; right: 20px; background: ' + bgColor + '; color: white; padding: 15px 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.3); z-index: 9999; display: flex; align-items: center; gap: 10px; min-width: 300px;\">' +
            '<i class=\"fas fa-' + icon + '\" style=\"font-size: 20px;\"></i>' +
            '<span>' + message + '</span>' +
        '</div>');
    
    $('body').append(toast);
    
    setTimeout(function() {
        toast.fadeOut(300, function() {
            $(this).remove();
        });
    }, 3000);
}

// Make functions globally accessible
window.saveInterviewer = saveInterviewer;
window.viewInterviewer = viewInterviewer;
window.editInterviewer = editInterviewer;
window.saveEditInterviewer = saveEditInterviewer;
window.deleteInterviewer = deleteInterviewer;

})(); // End IIFE
";

$data['custom_script'] = $custom_script;

// Load the footer template
$this->load->view('templates/admin_footer', $data);
?>
