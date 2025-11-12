<?php
// Set page-specific variables
$data['page_title'] = 'Interviewers';
$data['use_datatable'] = true;

// Load the header template
$this->load->view('templates/admin_header', $data);
?>

<!-- Stats Row -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card primary">
            <div class="stat-card-header">
                <div class="stat-card-title">Total Interviewers</div>
                <div class="stat-card-icon" style="background: rgba(102, 126, 234, 0.1); color: var(--primary-color);">
                    <i class="fas fa-user-check"></i>
                </div>
            </div>
            <div class="stat-card-value"><?= isset($total_interviewers) ? $total_interviewers : 0 ?></div>
            <div class="stat-card-footer">Registered interviewers</div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="stat-card success">
            <div class="stat-card-header">
                <div class="stat-card-title">Active Interviewers</div>
                <div class="stat-card-icon" style="background: rgba(28, 200, 138, 0.1); color: var(--success-color);">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
            <div class="stat-card-value"><?= isset($active_interviewers) ? $active_interviewers : 0 ?></div>
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
            <div class="stat-card-value"><?= isset($total_interviewers) && $total_interviewers > 0 ? round(($active_interviewers / $total_interviewers) * 100) : 0 ?>%</div>
            <div class="stat-card-footer">Utilization rate</div>
        </div>
    </div>
</div>

<!-- Add Interviewer Modal -->
<div class="modal fade" id="addInterviewerModal" tabindex="-1" aria-labelledby="addInterviewerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white;">
                <h5 class="modal-title" id="addInterviewerModalLabel">
                    <i class="fas fa-user-plus me-2"></i>Add New Interviewer
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addInterviewerForm" method="POST" action="<?= base_url('A_dashboard/add_interviewer') ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="username" class="form-label">
                            <i class="fas fa-user me-1"></i>Username <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="username" name="username" required 
                               placeholder="Enter username" pattern="[a-zA-Z0-9_]+" 
                               title="Only letters, numbers and underscore allowed">
                        <small class="text-muted">Only letters, numbers and underscore allowed</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope me-1"></i>Email <span class="text-danger">*</span>
                        </label>
                        <input type="email" class="form-control" id="email" name="email" required 
                               placeholder="interviewer@example.com">
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock me-1"></i>Password <span class="text-danger">*</span>
                        </label>
                        <input type="password" class="form-control" id="password" name="password" required 
                               placeholder="Enter password" minlength="6">
                        <small class="text-muted">Minimum 6 characters</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="phone" class="form-label">
                            <i class="fas fa-phone me-1"></i>Phone
                        </label>
                        <input type="tel" class="form-control" id="phone" name="phone" 
                               placeholder="Enter phone number">
                    </div>
                    
                    <div class="mb-3">
                        <label for="gender" class="form-label">
                            <i class="fas fa-venus-mars me-1"></i>Gender
                        </label>
                        <select class="form-select" id="gender" name="gender">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Add Interviewer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Interviewers Table -->
<div class="data-card">
    <div class="data-card-header">
        <h3 class="data-card-title">All Interviewers</h3>
        <div>
            <button class="btn btn-success-modern btn-modern" data-bs-toggle="modal" data-bs-target="#addInterviewerModal">
                <i class="fas fa-plus me-2"></i>Add Interviewer
            </button>
        </div>
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
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if(isset($interviewers) && $interviewers->num_rows() > 0): 
                    $i = 1; 
                    foreach ($interviewers->result() as $row): 
                ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td>
                                <div style="font-weight: 600;">
                                    <i class="fas fa-user-circle me-2" style="color: var(--primary-color);"></i>
                                    <?= $row->u_username ?>
                                </div>
                            </td>
                            <td><?= $row->u_email ?></td>
                            <td><?= $row->pi_phone ?? 'N/A' ?></td>
                            <td><?= $row->pi_gender ?? 'N/A' ?></td>
                            <td>
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle me-1"></i>Active
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-primary-modern btn-modern view-interviewer-btn" data-interviewer-username="<?= $row->u_username ?>">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-danger-modern btn-modern" onclick="deleteInterviewer('<?= $row->u_username ?>')">
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
                                <i class="fas fa-user-check fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No interviewers found</p>
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
    console.log('Document ready - attaching form handler');
    
    // Handle add interviewer form submission using event delegation
    $(document).on('submit', '#addInterviewerForm', function(e) {
        e.preventDefault();
        e.stopPropagation();
        console.log('Form submitted via AJAX');
        
        var form = $(this);
        var formData = form.serialize();
        var actionUrl = form.attr('action');
        
        console.log('Submitting to:', actionUrl);
        
        $.ajax({
            url: actionUrl,
            type: 'POST',
            data: formData,
            dataType: 'json',
            beforeSend: function() {
                Swal.fire({
                    title: 'Adding Interviewer...',
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
                        text: 'Interviewer added successfully',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Failed to add interviewer'
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to add interviewer: ' + error
                });
            }
        });
        
        return false; // Prevent default form submission
    });
    
    $('#interviewersTable').DataTable({
        responsive: true,
        pageLength: 10,
        language: {
            emptyTable: 'No interviewers yet',
            zeroRecords: 'No matching interviewers found',
            search: '_INPUT_',
            searchPlaceholder: 'Search interviewers...'
        },
        columnDefs: [
            { orderable: false, targets: 6 }
        ]
    });
    
    // View interviewer details
    $(document).on('click', '.view-interviewer-btn', function() {
        var username = $(this).data('interviewer-username');
        viewInterviewerDetails(username);
    });
});

function viewInterviewerDetails(username) {
    console.log('Viewing interviewer:', username);
    
    // Fetch interviewer details via AJAX
    $.ajax({
        url: '{$base_url}A_dashboard/get_interviewer_details',
        type: 'POST',
        data: { username: username },
        dataType: 'json',
        beforeSend: function() {
            console.log('Fetching interviewer details...');
        },
        success: function(response) {
            console.log('Response:', response);
            
            if(response.success) {
                const interviewer = response.interviewer;
                const interviews = response.interviews || [];
                
                let interviewsHtml = '';
                if(interviews.length > 0) {
                    interviewsHtml = '<div class="table-responsive mt-3"><table class="table table-sm"><thead><tr><th>Candidate</th><th>Date</th><th>Round</th></tr></thead><tbody>';
                    interviews.forEach(function(interview) {
                        interviewsHtml += '<tr><td>' + interview.ce_can_name + '</td><td>' + interview.ce_start_date + '</td><td>Round ' + Math.round(interview.ce_interview_round * 4) + '</td></tr>';
                    });
                    interviewsHtml += '</tbody></table></div>';
                } else {
                    interviewsHtml = '<p class="text-muted mt-3">No interviews conducted yet.</p>';
                }
                
                let modalContent = `
                    <div class="modal fade" id="interviewerModal" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white;">
                                    <h5 class="modal-title"><i class="fas fa-user-check me-2"></i>Interviewer Details</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="detail-item">
                                                <label><i class="fas fa-user me-2"></i>Username</label>
                                                <p>\${interviewer.u_username || 'N/A'}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="detail-item">
                                                <label><i class="fas fa-envelope me-2"></i>Email</label>
                                                <p>\${interviewer.u_email || 'N/A'}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="detail-item">
                                                <label><i class="fas fa-phone me-2"></i>Phone</label>
                                                <p>\${interviewer.pi_phone || 'N/A'}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="detail-item">
                                                <label><i class="fas fa-venus-mars me-2"></i>Gender</label>
                                                <p>\${interviewer.pi_gender || 'N/A'}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="detail-item">
                                                <label><i class="fas fa-user-tag me-2"></i>Role</label>
                                                <p><span class="badge bg-primary">\${interviewer.u_role || 'Interviewer'}</span></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="detail-item">
                                                <label><i class="fas fa-calendar-check me-2"></i>Total Interviews</label>
                                                <p><strong>\${interviews.length}</strong> interviews conducted</p>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="detail-item">
                                                <label><i class="fas fa-history me-2"></i>Interview History</label>
                                                \${interviewsHtml}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <a href="mailto:\${interviewer.u_email}" class="btn btn-primary">
                                        <i class="fas fa-envelope me-2"></i>Send Email
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                // Remove existing modal if any
                $('#interviewerModal').remove();
                
                // Append and show modal
                $('body').append(modalContent);
                $('#interviewerModal').modal('show');
                
                // Clean up modal after it's hidden
                $('#interviewerModal').on('hidden.bs.modal', function() {
                    $(this).remove();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message || 'Failed to load interviewer details'
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to fetch interviewer details: ' + error
            });
        }
    });
}

function deleteInterviewer(username) {
    Swal.fire({
        title: 'Delete Interviewer?',
        text: "This will remove " + username + " from the system. This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading
            Swal.fire({
                title: 'Deleting...',
                text: 'Please wait',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Send delete request
            $.ajax({
                url: '{$base_url}A_dashboard/delete_interviewer',
                type: 'POST',
                data: { username: username },
                dataType: 'json',
                success: function(response) {
                    if(response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Interviewer has been deleted successfully.',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            // Reload the page to refresh the table
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'Failed to delete interviewer'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to delete interviewer: ' + error
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
