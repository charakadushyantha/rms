<?php
// Set page-specific variables
$data['page_title'] = 'Manage Candidate Users';
$data['use_datatable'] = true;

// Load the header template
$this->load->view('templates/admin_header', $data);
?>

<!-- Stats Row -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-card-title">Total Candidates</div>
                <div class="stat-card-icon" style="background: rgba(102, 126, 234, 0.1); color: var(--primary-color);">
                    <i class="fas fa-user-graduate"></i>
                </div>
            </div>
            <div class="stat-card-value" id="totalCandidates">0</div>
            <div class="stat-card-footer">Registered candidates</div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card success">
            <div class="stat-card-header">
                <div class="stat-card-title">Selected</div>
                <div class="stat-card-icon" style="background: rgba(28, 200, 138, 0.1); color: var(--success-color);">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
            <div class="stat-card-value" id="selectedCandidates">0</div>
            <div class="stat-card-footer">Hired candidates</div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card info">
            <div class="stat-card-header">
                <div class="stat-card-title">In Process</div>
                <div class="stat-card-icon" style="background: rgba(54, 185, 204, 0.1); color: var(--info-color);">
                    <i class="fas fa-spinner"></i>
                </div>
            </div>
            <div class="stat-card-value" id="inProcessCandidates">0</div>
            <div class="stat-card-footer">Under review</div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card warning">
            <div class="stat-card-header">
                <div class="stat-card-title">No Application</div>
                <div class="stat-card-icon" style="background: rgba(255, 193, 7, 0.1); color: var(--warning-color);">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
            </div>
            <div class="stat-card-value" id="noApplicationCandidates">0</div>
            <div class="stat-card-footer">Not applied yet</div>
        </div>
    </div>
</div>

<!-- Candidate Users Table -->
<div class="data-card">
    <div class="data-card-header">
        <h3 class="data-card-title">All Candidate Users</h3>
        <div>
            <button class="btn btn-success-modern btn-modern me-2" data-bs-toggle="modal" data-bs-target="#addCandidateModal">
                <i class="fas fa-user-plus me-2"></i>Add Candidate User
            </button>
            <button class="btn btn-primary-modern btn-modern" onclick="exportData()">
                <i class="fas fa-download me-2"></i>Export Data
            </button>
        </div>
    </div>
    
    <!-- Filters Section -->
    <div class="p-3 bg-light border-bottom">
        <div class="row g-3">
            <div class="col-md-2">
                <label class="form-label small fw-bold">
                    <i class="fas fa-flag me-1"></i>Status
                </label>
                <select class="form-select form-select-sm" id="statusFilter">
                    <option value="">All Status</option>
                    <option value="New">New</option>
                    <option value="Selected">Selected</option>
                    <option value="In Process">In Process</option>
                    <option value="Rejected">Rejected</option>
                    <option value="On Hold">On Hold</option>
                    <option value="No Application">No Application</option>
                </select>
            </div>
            
            <div class="col-md-2">
                <label class="form-label small fw-bold">
                    <i class="fas fa-tasks me-1"></i>Progress
                </label>
                <select class="form-select form-select-sm" id="progressFilter">
                    <option value="">All Progress</option>
                    <option value="100">100% Complete</option>
                    <option value="75-99">75-99% Complete</option>
                    <option value="50-74">50-74% Complete</option>
                    <option value="25-49">25-49% Complete</option>
                    <option value="0-24">0-24% Complete</option>
                </select>
            </div>
            
            <div class="col-md-3">
                <label class="form-label small fw-bold">
                    <i class="fas fa-user-tie me-1"></i>Recruiter
                </label>
                <select class="form-select form-select-sm" id="recruiterFilter">
                    <option value="">All Recruiters</option>
                </select>
            </div>
            
            <div class="col-md-3">
                <label class="form-label small fw-bold">
                    <i class="fas fa-briefcase me-1"></i>Job Title
                </label>
                <select class="form-select form-select-sm" id="jobFilter">
                    <option value="">All Jobs</option>
                </select>
            </div>
            
            <div class="col-md-2 d-flex align-items-end">
                <button class="btn btn-sm btn-outline-secondary w-100" onclick="resetFilters()" title="Reset Filters">
                    <i class="fas fa-redo me-1"></i> Reset
                </button>
            </div>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover" id="candidatesTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- DataTables will populate this -->
            </tbody>
        </table>
    </div>
</div>

<!-- Add Candidate Modal -->
<div class="modal fade" id="addCandidateModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white;">
                <h5 class="modal-title">
                    <i class="fas fa-user-plus me-2"></i>Add New Candidate
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addCandidateForm">
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
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="full_name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="tel" class="form-control" name="phone">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary-modern btn-modern" onclick="saveCandidate()">Add Candidate</button>
            </div>
        </div>
    </div>
</div>

<!-- View Candidate Modal -->
<div class="modal fade" id="viewCandidateModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #17a2b8, #138496); color: white;">
                <h5 class="modal-title"><i class="fas fa-user-graduate me-2"></i>Candidate Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="candidateDetailsContent">
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

<!-- Edit Candidate Modal -->
<div class="modal fade" id="editCandidateModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #f59e0b, #f97316); color: white;">
                <h5 class="modal-title"><i class="fas fa-user-edit me-2"></i>Edit Candidate</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editCandidateForm">
                    <input type="hidden" id="edit_cand_username" name="username">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Username</label>
                        <input type="text" class="form-control" id="edit_cand_username_display" readonly
                               style="background:#f8f9fa; color:#888;">
                        <small class="text-muted">Username cannot be changed</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="edit_cand_email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Full Name</label>
                        <input type="text" class="form-control" id="edit_cand_name" name="full_name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Phone</label>
                        <input type="tel" class="form-control" id="edit_cand_phone" name="phone">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">New Password</label>
                        <input type="password" class="form-control" id="edit_cand_password" name="password"
                               placeholder="Leave blank to keep current password" minlength="6">
                        <small class="text-muted">Leave blank to keep the existing password</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" onclick="saveEditCandidate()"
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
    let candidatesTable;
    let allCandidatesData = [];

    $(document).ready(function() {
        // Destroy existing DataTable if it exists
        if ($.fn.DataTable.isDataTable('#candidatesTable')) {
            $('#candidatesTable').DataTable().destroy();
        }
        
        candidatesTable = $('#candidatesTable').DataTable({
            responsive: true,
            pageLength: 10,
            language: {
                emptyTable: 'No candidates found. Add your first candidate!',
                zeroRecords: 'No matching candidates found',
                search: '_INPUT_',
                searchPlaceholder: 'Search candidates...'
            },
            columnDefs: [
                { orderable: false, targets: 6 }
            ]
        });
        
        loadCandidates();
        loadFilters();
    });

    function loadFilters() {
        // Load recruiters for filter
        $.ajax({
            url: '" . base_url('A_dashboard/get_recruiters_list') . "',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success && response.data) {
                    let options = '<option value=\"\">All Recruiters</option>';
                    response.data.forEach(function(recruiter) {
                        options += '<option value=\"' + recruiter.username + '\">' + recruiter.username + '</option>';
                    });
                    $('#recruiterFilter').html(options);
                }
            }
        });

        // Load job titles for filter
        $.ajax({
            url: '" . base_url('A_dashboard/get_job_titles_list') . "',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success && response.data) {
                    let options = '<option value=\"\">All Jobs</option>';
                    response.data.forEach(function(job) {
                        options += '<option value=\"' + job + '\">' + job + '</option>';
                    });
                    $('#jobFilter').html(options);
                }
            }
        });
    }

    function loadCandidates() {
        $.ajax({
            url: '" . base_url('A_dashboard/get_all_candidate_users') . "',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    allCandidatesData = response.data;
                    candidatesTable.clear();
                    
                    $('#totalCandidates').text(response.stats.total);
                    $('#selectedCandidates').text(response.stats.selected);
                    $('#inProcessCandidates').text(response.stats.in_process);
                    $('#noApplicationCandidates').text(response.stats.no_application);
                    
                    if (response.data && response.data.length > 0) {
                        response.data.forEach(function(candidate, index) {
                            let actions = '';
                            
                            if (candidate.user_status == 1) {
                                actions = '<button class=\"btn btn-sm btn-success\" onclick=\"toggleCandidateStatus(' + \"'\" + candidate.username + \"'\" + ', 1)\" title=\"Active\" disabled style=\"opacity:0.6;\"><i class=\"fas fa-check\"></i></button> ' +
                                    '<button class=\"btn btn-sm\" onclick=\"editCandidate(' + \"'\" + candidate.username + \"'\" + ')\" title=\"Edit\" style=\"background:#dc3545;border:none;color:#fff;\"><i class=\"fas fa-edit\"></i></button> ' +
                                    '<button class=\"btn btn-sm btn-danger\" onclick=\"deleteCandidate(' + \"'\" + candidate.username + \"'\" + ')\" title=\"Delete\"><i class=\"fas fa-trash\"></i></button> ' +
                                    '<button class=\"btn btn-sm btn-warning\" onclick=\"toggleCandidateStatus(' + \"'\" + candidate.username + \"'\" + ', 0)\" title=\"Deactivate\"><i class=\"fas fa-ban\"></i></button>';
                            } else {
                                actions = '<button class=\"btn btn-sm btn-warning\" onclick=\"toggleCandidateStatus(' + \"'\" + candidate.username + \"'\" + ', 1)\" title=\"Activate\"><i class=\"fas fa-check\"></i></button> ' +
                                    '<button class=\"btn btn-sm\" onclick=\"editCandidate(' + \"'\" + candidate.username + \"'\" + ')\" title=\"Edit\" style=\"background:#dc3545;border:none;color:#fff;\"><i class=\"fas fa-edit\"></i></button> ' +
                                    '<button class=\"btn btn-sm btn-danger\" onclick=\"deleteCandidate(' + \"'\" + candidate.username + \"'\" + ')\" title=\"Delete\"><i class=\"fas fa-trash\"></i></button> ' +
                                    '<button class=\"btn btn-sm btn-secondary\" onclick=\"toggleCandidateStatus(' + \"'\" + candidate.username + \"'\" + ', 0)\" title=\"Deactivated\" disabled style=\"opacity:0.6;\"><i class=\"fas fa-ban\"></i></button>';
                            }
                            
                            let statusBadge = '';
                            let appStatus = candidate.application_status || 'No Application';
                            if (appStatus === 'Selected') {
                                statusBadge = '<span class=\"badge bg-success\">' + appStatus + '</span>';
                            } else if (appStatus === 'In Process') {
                                statusBadge = '<span class=\"badge bg-info\">' + appStatus + '</span>';
                            } else if (appStatus === 'Rejected') {
                                statusBadge = '<span class=\"badge bg-danger\">' + appStatus + '</span>';
                            } else if (appStatus === 'On Hold') {
                                statusBadge = '<span class=\"badge bg-warning\">' + appStatus + '</span>';
                            } else if (appStatus === 'New') {
                                statusBadge = '<span class=\"badge bg-primary\">' + appStatus + '</span>';
                            } else {
                                statusBadge = '<span class=\"badge bg-secondary\">' + appStatus + '</span>';
                            }
                            
                            candidatesTable.row.add([
                                index + 1,
                                candidate.username,
                                candidate.email,
                                candidate.name || 'N/A',
                                candidate.phone || 'N/A',
                                statusBadge,
                                actions
                            ]);
                        });
                    }
                    
                    candidatesTable.draw();
                    applyFilters();
                }
            },
            error: function() {
                showToast('Failed to load candidates', 'error');
            }
        });
    }

    // Apply filters
    $('#statusFilter, #progressFilter, #recruiterFilter, #jobFilter').on('change', function() {
        applyFilters();
    });

    function applyFilters() {
        let statusFilter = $('#statusFilter').val();
        let recruiterFilter = $('#recruiterFilter').val();
        let jobFilter = $('#jobFilter').val();
        
        candidatesTable.column(5).search(statusFilter).draw();
    }

    function resetFilters() {
        $('#statusFilter').val('');
        $('#progressFilter').val('');
        $('#recruiterFilter').val('');
        $('#jobFilter').val('');
        candidatesTable.search('').columns().search('').draw();
    }

    function exportData() {
        window.location.href = '" . base_url('A_dashboard/export_candidate_users') . "';
    }

    function saveCandidate() {
        const form = $('#addCandidateForm');
        const data = {
            username: form.find('[name=\"username\"]').val(),
            email: form.find('[name=\"email\"]').val(),
            password: form.find('[name=\"password\"]').val(),
            full_name: form.find('[name=\"full_name\"]').val(),
            phone: form.find('[name=\"phone\"]').val()
        };
        
        $.ajax({
            url: '" . base_url('A_dashboard/add_candidate_user') . "',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    showToast(response.message, 'success');
                    const modal = bootstrap.Modal.getInstance(document.getElementById('addCandidateModal'));
                    if (modal) modal.hide();
                    form[0].reset();
                    loadCandidates();
                } else {
                    showToast(response.message, 'error');
                }
            },
            error: function() {
                showToast('Failed to add candidate', 'error');
            }
        });
    }

    function editCandidate(username) {
        $.ajax({
            url: '" . base_url('A_dashboard/get_candidate_user_details') . "',
            type: 'POST',
            data: { username: username },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const candidate = response.user;
                    $('#edit_cand_username').val(candidate.u_username);
                    $('#edit_cand_username_display').val(candidate.u_username);
                    $('#edit_cand_email').val(candidate.u_email);
                    $('#edit_cand_name').val(candidate.cd_name || '');
                    $('#edit_cand_phone').val(candidate.cd_phone || '');
                    $('#edit_cand_password').val('');
                    const modal = new bootstrap.Modal(document.getElementById('editCandidateModal'));
                    modal.show();
                } else {
                    showToast(response.message || 'Failed to load candidate', 'error');
                }
            },
            error: function() {
                showToast('Failed to load candidate details', 'error');
            }
        });
    }

    function saveEditCandidate() {
        const username = $('#edit_cand_username').val();
        const email = $('#edit_cand_email').val().trim();
        const full_name = $('#edit_cand_name').val();
        const phone = $('#edit_cand_phone').val();
        const password = $('#edit_cand_password').val();

        if (!email) {
            showToast('Email is required', 'error');
            return;
        }

        $.ajax({
            url: '" . base_url('A_dashboard/update_candidate_user') . "',
            type: 'POST',
            data: { username: username, email: email, full_name: full_name, phone: phone, password: password },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    showToast(response.message, 'success');
                    const modal = bootstrap.Modal.getInstance(document.getElementById('editCandidateModal'));
                    if (modal) modal.hide();
                    loadCandidates();
                } else {
                    showToast(response.message || 'Failed to update candidate', 'error');
                }
            },
            error: function() {
                showToast('Failed to update candidate', 'error');
            }
        });
    }

    function toggleCandidateStatus(username, newStatus) {
        const action = newStatus == 1 ? 'activate' : 'deactivate';
        const actionText = newStatus == 1 ? 'Activate' : 'Deactivate';
        
        showConfirm(
            actionText + ' Candidate',
            'Are you sure you want to ' + action + ' ' + username + '?',
            function() {
                $.ajax({
                    url: '" . base_url('A_dashboard/toggle_candidate_status') . "',
                    type: 'POST',
                    data: { username: username, status: newStatus },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            showToast(response.message, 'success');
                            loadCandidates();
                        } else {
                            showToast(response.message, 'error');
                        }
                    },
                    error: function() {
                        showToast('Failed to update candidate status', 'error');
                    }
                });
            }
        );
    }

    function deleteCandidate(username) {
        showConfirm(
            'Delete Candidate',
            'Are you sure you want to delete ' + username + '? This action cannot be undone.',
            function() {
                $.ajax({
                    url: '" . base_url('A_dashboard/delete_candidate_user') . "',
                    type: 'POST',
                    data: { username: username },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            showToast(response.message, 'success');
                            loadCandidates();
                        } else {
                            showToast(response.message, 'error');
                        }
                    },
                    error: function() {
                        showToast('Failed to delete candidate', 'error');
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
    window.saveCandidate = saveCandidate;
    window.editCandidate = editCandidate;
    window.saveEditCandidate = saveEditCandidate;
    window.toggleCandidateStatus = toggleCandidateStatus;
    window.deleteCandidate = deleteCandidate;

})(); // End IIFE
";

$data['custom_script'] = $custom_script;

// Load the footer template
$this->load->view('templates/admin_footer', $data);
?>