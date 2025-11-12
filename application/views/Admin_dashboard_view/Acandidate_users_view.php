<?php
// Set page-specific variables
$data['page_title'] = 'Candidate Users';
$data['use_datatable'] = true;

// Load the header template
$this->load->view('templates/admin_header', $data);
?>

<!-- Stats Row -->
<div class="row g-4 mb-4">
    <div class="col-md-12">
        <div class="stat-card primary">
            <div class="stat-card-header">
                <div class="stat-card-title">Total Candidate Users</div>
                <div class="stat-card-icon" style="background: rgba(102, 126, 234, 0.1); color: var(--primary-color);">
                    <i class="fas fa-user-graduate"></i>
                </div>
            </div>
            <div class="stat-card-value"><?= isset($total_candidate_users) ? $total_candidate_users : 0 ?></div>
            <div class="stat-card-footer">Candidates with portal access</div>
        </div>
    </div>
</div>

<!-- Add Candidate User Modal -->
<div class="modal fade" id="addCandidateUserModal" tabindex="-1" aria-labelledby="addCandidateUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white;">
                <h5 class="modal-title" id="addCandidateUserModalLabel">
                    <i class="fas fa-user-plus me-2"></i>Add New Candidate User
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addCandidateUserForm" method="POST" action="<?= base_url('A_dashboard/add_candidate_user') ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="username" class="form-label">
                            <i class="fas fa-user me-1"></i>Username <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="username" name="username" required 
                               placeholder="Enter username" pattern="[a-zA-Z0-9_]+" 
                               title="Only letters, numbers and underscore allowed">
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope me-1"></i>Email <span class="text-danger">*</span>
                        </label>
                        <input type="email" class="form-control" id="email" name="email" required 
                               placeholder="candidate@example.com">
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock me-1"></i>Password <span class="text-danger">*</span>
                        </label>
                        <input type="password" class="form-control" id="password" name="password" required 
                               placeholder="Enter password" minlength="6">
                    </div>
                    
                    <div class="mb-3">
                        <label for="full_name" class="form-label">
                            <i class="fas fa-id-card me-1"></i>Full Name
                        </label>
                        <input type="text" class="form-control" id="full_name" name="full_name" 
                               placeholder="Enter full name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Add Candidate User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Candidate User Modal -->
<div class="modal fade" id="editCandidateUserModal" tabindex="-1" aria-labelledby="editCandidateUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #f59e0b, #f97316); color: white;">
                <h5 class="modal-title" id="editCandidateUserModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Candidate User
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editCandidateUserForm" method="POST" action="<?= base_url('A_dashboard/update_candidate_user') ?>">
                <input type="hidden" id="edit_username" name="username">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">
                            <i class="fas fa-envelope me-1"></i>Email <span class="text-danger">*</span>
                        </label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_full_name" class="form-label">
                            <i class="fas fa-id-card me-1"></i>Full Name
                        </label>
                        <input type="text" class="form-control" id="edit_full_name" name="full_name">
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_phone" class="form-label">
                            <i class="fas fa-phone me-1"></i>Phone
                        </label>
                        <input type="tel" class="form-control" id="edit_phone" name="phone">
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_password" class="form-label">
                            <i class="fas fa-lock me-1"></i>New Password
                        </label>
                        <input type="password" class="form-control" id="edit_password" name="password" 
                               placeholder="Leave blank to keep current password" minlength="6">
                        <small class="text-muted">Leave blank if you don't want to change the password</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save me-1"></i>Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Candidate Users Table -->
<div class="data-card">
    <div class="data-card-header">
        <h3 class="data-card-title">All Candidate Users</h3>
        <div>
            <button class="btn btn-success-modern btn-modern" data-bs-toggle="modal" data-bs-target="#addCandidateUserModal">
                <i class="fas fa-plus me-2"></i>Add Candidate User
            </button>
            <button class="btn btn-primary-modern btn-modern" onclick="exportData()">
                <i class="fas fa-download me-2"></i>Export Data
            </button>
        </div>
    </div>
    
    <!-- Filters Section -->
    <div class="p-3 bg-light border-bottom">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label small fw-bold">
                    <i class="fas fa-search me-1"></i>Search
                </label>
                <input type="text" class="form-control form-control-sm" id="searchInput" placeholder="Search candidates...">
            </div>
            
            <div class="col-md-2">
                <label class="form-label small fw-bold">
                    <i class="fas fa-flag me-1"></i>Status
                </label>
                <select class="form-select form-select-sm" id="statusFilter">
                    <option value="">All Status</option>
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
            
            <div class="col-md-2">
                <label class="form-label small fw-bold">
                    <i class="fas fa-user-tie me-1"></i>Recruiter
                </label>
                <select class="form-select form-select-sm" id="recruiterFilter">
                    <option value="">All Recruiters</option>
                    <?php if(isset($recruiters) && $recruiters->num_rows() > 0): ?>
                        <?php foreach($recruiters->result() as $recruiter): ?>
                            <option value="<?= $recruiter->u_username ?>"><?= $recruiter->u_username ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            
            <div class="col-md-2">
                <label class="form-label small fw-bold">
                    <i class="fas fa-briefcase me-1"></i>Job Title
                </label>
                <select class="form-select form-select-sm" id="jobFilter">
                    <option value="">All Jobs</option>
                    <?php if(isset($job_titles) && !empty($job_titles)): ?>
                        <?php foreach($job_titles as $job): ?>
                            <option value="<?= $job ?>"><?= $job ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            
            <div class="col-md-1 d-flex align-items-end">
                <button class="btn btn-sm btn-outline-secondary w-100" onclick="resetFilters()" title="Reset Filters">
                    <i class="fas fa-redo"></i>
                </button>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-12">
                <small class="text-muted">
                    <i class="fas fa-info-circle me-1"></i>
                    Showing <span id="filteredCount">0</span> of <span id="totalCount">0</span> candidates
                </small>
            </div>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover" id="candidateUsersTable">
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
                <?php 
                if(isset($candidate_users) && $candidate_users->num_rows() > 0): 
                    $i = 1; 
                    foreach ($candidate_users->result() as $row): 
                ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td>
                                <div style="font-weight: 600;">
                                    <i class="fas fa-user me-2" style="color: var(--primary-color);"></i>
                                    <?= $row->u_username ?>
                                </div>
                            </td>
                            <td><?= $row->u_email ?></td>
                            <td><?= $row->cd_name ?? 'N/A' ?></td>
                            <td><?= $row->cd_phone ?? 'N/A' ?></td>
                            <td>
                                <?php if($row->cd_status): ?>
                                    <span class="badge bg-<?= $row->cd_status == 'Selected' ? 'success' : ($row->cd_status == 'In Process' ? 'info' : 'secondary') ?>">
                                        <?= $row->cd_status ?>
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">No Application</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-primary-modern btn-modern" onclick="viewCandidateUser('<?= $row->u_username ?>')" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-warning-modern btn-modern" onclick="editCandidateUser('<?= $row->u_username ?>')" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger-modern btn-modern" onclick="deleteCandidateUser('<?= $row->u_username ?>')" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                <?php 
                    endforeach; 
                else:
                ?>
                    <tr>
                        <td colspan="7" class="text-center">
                            <div class="py-4">
                                <i class="fas fa-user-graduate fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No candidate users found</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$base_url = base_url();
$custom_script = <<<JAVASCRIPT
// Initialize DataTable
$(document).ready(function() {
    console.log('Document ready - attaching handlers');
    
    // Handle add candidate user form submission
    $(document).on('submit', '#addCandidateUserForm', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        var form = $(this);
        var formData = form.serialize();
        var actionUrl = form.attr('action');
        
        $.ajax({
            url: actionUrl,
            type: 'POST',
            data: formData,
            dataType: 'json',
            beforeSend: function() {
                Swal.fire({
                    title: 'Adding Candidate User...',
                    text: 'Please wait',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(response) {
                if(response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Candidate user added successfully',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Failed to add candidate user'
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to add candidate user: ' + error
                });
            }
        });
        
        return false;
    });
    
    // Handle edit candidate user form submission
    $(document).on('submit', '#editCandidateUserForm', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        var form = $(this);
        var formData = form.serialize();
        var actionUrl = form.attr('action');
        
        $.ajax({
            url: actionUrl,
            type: 'POST',
            data: formData,
            dataType: 'json',
            beforeSend: function() {
                Swal.fire({
                    title: 'Updating...',
                    text: 'Please wait',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(response) {
                if(response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: 'Candidate user updated successfully',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Failed to update candidate user'
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to update candidate user: ' + error
                });
            }
        });
        
        return false;
    });
    
    var table = $('#candidateUsersTable').DataTable({
        responsive: true,
        pageLength: 10,
        language: {
            emptyTable: 'No candidate users yet',
            zeroRecords: 'No matching users found',
            search: '_INPUT_',
            searchPlaceholder: 'Search users...'
        },
        columnDefs: [
            { orderable: false, targets: 6 }
        ],
        dom: 'lrtip', // Remove default search box
        initComplete: function() {
            updateCounts();
        }
    });
    
    // Custom search filter
    $('#searchInput').on('keyup', function() {
        table.search(this.value).draw();
        updateCounts();
    });
    
    // Status filter
    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            var statusFilter = $('#statusFilter').val();
            var progressFilter = $('#progressFilter').val();
            var recruiterFilter = $('#recruiterFilter').val();
            var jobFilter = $('#jobFilter').val();
            
            var status = data[5] || ''; // Status column
            var recruiter = data[1] || ''; // Recruiter column (if exists)
            var job = data[3] || ''; // Job Title column (if exists)
            
            // Status filter
            if (statusFilter && !status.includes(statusFilter)) {
                return false;
            }
            
            // Recruiter filter
            if (recruiterFilter && !recruiter.includes(recruiterFilter)) {
                return false;
            }
            
            // Job filter
            if (jobFilter && !job.includes(jobFilter)) {
                return false;
            }
            
            return true;
        }
    );
    
    // Apply filters on change
    $('#statusFilter, #progressFilter, #recruiterFilter, #jobFilter').on('change', function() {
        table.draw();
        updateCounts();
    });
    
    // Update counts
    function updateCounts() {
        var info = table.page.info();
        $('#filteredCount').text(info.recordsDisplay);
        $('#totalCount').text(info.recordsTotal);
    }
});

// Reset filters
function resetFilters() {
    $('#searchInput').val('');
    $('#statusFilter').val('');
    $('#progressFilter').val('');
    $('#recruiterFilter').val('');
    $('#jobFilter').val('');
    $('#candidateUsersTable').DataTable().search('').draw();
    updateCounts();
}

// Export data
function exportData() {
    var table = $('#candidateUsersTable').DataTable();
    var data = table.rows({ search: 'applied' }).data();
    
    // Create CSV content
    var csv = 'No,Username,Email,Name,Phone,Status\\n';
    data.each(function(row) {
        csv += row.join(',') + '\\n';
    });
    
    // Download CSV
    var blob = new Blob([csv], { type: 'text/csv' });
    var url = window.URL.createObjectURL(blob);
    var a = document.createElement('a');
    a.href = url;
    a.download = 'candidates_' + new Date().toISOString().slice(0,10) + '.csv';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
}

function viewCandidateUser(username) {
    console.log('Viewing candidate user:', username);
    
    // Fetch candidate user details via AJAX
    $.ajax({
        url: '{$base_url}A_dashboard/get_candidate_user_details',
        type: 'POST',
        data: { username: username },
        dataType: 'json',
        success: function(response) {
            if(response.success) {
                const user = response.user;
                
                let modalContent = `
                    <div class="modal fade" id="candidateUserModal" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white;">
                                    <h5 class="modal-title"><i class="fas fa-user-graduate me-2"></i>Candidate User Details</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="detail-item">
                                                <label><i class="fas fa-user me-2"></i>Username</label>
                                                <p>\${user.u_username || 'N/A'}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="detail-item">
                                                <label><i class="fas fa-id-card me-2"></i>Full Name</label>
                                                <p>\${user.cd_name || 'N/A'}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="detail-item">
                                                <label><i class="fas fa-envelope me-2"></i>Email</label>
                                                <p>\${user.u_email || 'N/A'}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="detail-item">
                                                <label><i class="fas fa-phone me-2"></i>Phone</label>
                                                <p>\${user.cd_phone || 'N/A'}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="detail-item">
                                                <label><i class="fas fa-briefcase me-2"></i>Job Title</label>
                                                <p>\${user.cd_job_title || 'N/A'}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="detail-item">
                                                <label><i class="fas fa-info-circle me-2"></i>Application Status</label>
                                                <p><span class="badge bg-\${user.cd_status == 'Selected' ? 'success' : (user.cd_status == 'In Process' ? 'info' : 'secondary')}">\${user.cd_status || 'No Application'}</span></p>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="detail-item">
                                                <label><i class="fas fa-align-left me-2"></i>Description</label>
                                                <p>\${user.cd_description || 'No description available'}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <a href="mailto:\${user.u_email}" class="btn btn-primary">
                                        <i class="fas fa-envelope me-2"></i>Send Email
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                $('#candidateUserModal').remove();
                $('body').append(modalContent);
                $('#candidateUserModal').modal('show');
                $('#candidateUserModal').on('hidden.bs.modal', function() {
                    $(this).remove();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message || 'Failed to load user details'
                });
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to fetch user details'
            });
        }
    });
}

function editCandidateUser(username) {
    console.log('Editing candidate user:', username);
    
    // Fetch user details first
    $.ajax({
        url: '{$base_url}A_dashboard/get_candidate_user_details',
        type: 'POST',
        data: { username: username },
        dataType: 'json',
        success: function(response) {
            if(response.success) {
                const user = response.user;
                
                // Populate the edit form
                $('#edit_username').val(user.u_username);
                $('#edit_email').val(user.u_email);
                $('#edit_full_name').val(user.cd_name || '');
                $('#edit_phone').val(user.cd_phone || '');
                $('#edit_password').val('');
                
                // Show the modal
                $('#editCandidateUserModal').modal('show');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message || 'Failed to load user details'
                });
            }
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to fetch user details'
            });
        }
    });
}

function deleteCandidateUser(username) {
    Swal.fire({
        title: 'Delete Candidate User?',
        text: "This will remove " + username + " from the system. This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Deleting...',
                text: 'Please wait',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            $.ajax({
                url: '{$base_url}A_dashboard/delete_candidate_user',
                type: 'POST',
                data: { username: username },
                dataType: 'json',
                success: function(response) {
                    if(response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Candidate user has been deleted successfully.',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'Failed to delete candidate user'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to delete candidate user: ' + error
                    });
                }
            });
        }
    });
}
JAVASCRIPT;

// Load the footer template
$this->load->view('templates/admin_footer');
?>

<style>
.detail-item {
    padding: 12px;
    background: #f8f9fa;
    border-radius: 8px;
    border-left: 3px solid var(--primary-color);
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

<script>
<?= $custom_script ?>
</script>
