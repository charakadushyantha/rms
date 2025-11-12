<?php
// Set page-specific variables
$data['page_title'] = 'Roles & Permissions';
$data['use_datatable'] = true;

// Load the header template
$this->load->view('templates/admin_header', $data);
?>

<style>
.permission-card {
    background: white;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    margin-bottom: 24px;
    transition: all 0.3s ease;
}

.permission-card:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.12);
    transform: translateY(-2px);
}

.role-badge {
    display: inline-block;
    padding: 8px 16px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 14px;
    margin-right: 8px;
    margin-bottom: 8px;
}

.role-admin {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.role-recruiter {
    background: linear-gradient(135deg, #36b9cc 0%, #258391 100%);
    color: white;
}

.role-interviewer {
    background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%);
    color: white;
}

.role-candidate {
    background: linear-gradient(135deg, #1cc88a 0%, #17a673 100%);
    color: white;
}

.permission-item {
    padding: 12px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: all 0.2s;
}

.permission-item:hover {
    background: #f7fafc;
    border-color: #667eea;
}

.permission-switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 24px;
}

.permission-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 24px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}

input:checked + .slider {
    background-color: #1cc88a;
}

input:checked + .slider:before {
    transform: translateX(26px);
}

.section-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 16px 24px;
    border-radius: 12px;
    margin-bottom: 24px;
}

.stats-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    text-align: center;
    transition: all 0.3s;
}

.stats-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.12);
}

.stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    margin: 0 auto 12px;
}

.permission-group {
    margin-bottom: 24px;
}

.permission-group-title {
    font-size: 16px;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 12px;
    padding-bottom: 8px;
    border-bottom: 2px solid #e2e8f0;
}
</style>

<!-- Page Header -->
<div class="section-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="mb-1"><i class="fas fa-shield-alt me-2"></i>Roles & Permissions Management</h2>
            <p class="mb-0 opacity-90">Configure user roles and access control</p>
        </div>
        <div>
            <button class="btn btn-light" onclick="saveAllPermissions()">
                <i class="fas fa-save me-2"></i>Save Changes
            </button>
        </div>
    </div>
</div>

<!-- Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <i class="fas fa-user-shield"></i>
            </div>
            <h3 class="mb-1"><?= $total_admins ?? 0 ?></h3>
            <p class="text-muted mb-0">Administrators</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-icon" style="background: linear-gradient(135deg, #36b9cc 0%, #258391 100%); color: white;">
                <i class="fas fa-user-tie"></i>
            </div>
            <h3 class="mb-1"><?= $total_recruiters ?? 0 ?></h3>
            <p class="text-muted mb-0">Recruiters</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-icon" style="background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%); color: white;">
                <i class="fas fa-user-check"></i>
            </div>
            <h3 class="mb-1"><?= $total_interviewers ?? 0 ?></h3>
            <p class="text-muted mb-0">Interviewers</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-icon" style="background: linear-gradient(135deg, #1cc88a 0%, #17a673 100%); color: white;">
                <i class="fas fa-user-graduate"></i>
            </div>
            <h3 class="mb-1"><?= $total_candidates ?? 0 ?></h3>
            <p class="text-muted mb-0">Candidates</p>
        </div>
    </div>
</div>

<!-- Roles Overview -->
<div class="row mb-4">
    <div class="col-12">
        <div class="permission-card">
            <h4 class="mb-3"><i class="fas fa-users-cog me-2 text-primary"></i>System Roles</h4>
            <div class="d-flex flex-wrap">
                <span class="role-badge role-admin">
                    <i class="fas fa-crown me-2"></i>Administrator
                </span>
                <span class="role-badge role-recruiter">
                    <i class="fas fa-user-tie me-2"></i>Recruiter
                </span>
                <span class="role-badge role-interviewer">
                    <i class="fas fa-user-check me-2"></i>Interviewer
                </span>
                <span class="role-badge role-candidate">
                    <i class="fas fa-user-graduate me-2"></i>Candidate
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Permissions Matrix -->
<div class="row">
    <!-- Administrator Permissions -->
    <div class="col-lg-6 mb-4">
        <div class="permission-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">
                    <span class="role-badge role-admin">
                        <i class="fas fa-crown me-2"></i>Administrator
                    </span>
                </h4>
                <span class="badge bg-success">Full Access</span>
            </div>
            
            <div class="permission-group">
                <div class="permission-group-title">
                    <i class="fas fa-users me-2"></i>User Management
                </div>
                <div class="permission-item">
                    <span><i class="fas fa-check-circle text-success me-2"></i>Create/Edit/Delete Users</span>
                    <label class="permission-switch">
                        <input type="checkbox" checked disabled>
                        <span class="slider"></span>
                    </label>
                </div>
                <div class="permission-item">
                    <span><i class="fas fa-check-circle text-success me-2"></i>Manage Roles & Permissions</span>
                    <label class="permission-switch">
                        <input type="checkbox" checked disabled>
                        <span class="slider"></span>
                    </label>
                </div>
                <div class="permission-item">
                    <span><i class="fas fa-check-circle text-success me-2"></i>View All Users</span>
                    <label class="permission-switch">
                        <input type="checkbox" checked disabled>
                        <span class="slider"></span>
                    </label>
                </div>
            </div>

            <div class="permission-group">
                <div class="permission-group-title">
                    <i class="fas fa-user-friends me-2"></i>Candidate Management
                </div>
                <div class="permission-item">
                    <span><i class="fas fa-check-circle text-success me-2"></i>Full Candidate Access</span>
                    <label class="permission-switch">
                        <input type="checkbox" checked disabled>
                        <span class="slider"></span>
                    </label>
                </div>
                <div class="permission-item">
                    <span><i class="fas fa-check-circle text-success me-2"></i>Delete Candidates</span>
                    <label class="permission-switch">
                        <input type="checkbox" checked disabled>
                        <span class="slider"></span>
                    </label>
                </div>
            </div>

            <div class="permission-group">
                <div class="permission-group-title">
                    <i class="fas fa-cog me-2"></i>System Settings
                </div>
                <div class="permission-item">
                    <span><i class="fas fa-check-circle text-success me-2"></i>System Configuration</span>
                    <label class="permission-switch">
                        <input type="checkbox" checked disabled>
                        <span class="slider"></span>
                    </label>
                </div>
                <div class="permission-item">
                    <span><i class="fas fa-check-circle text-success me-2"></i>View Reports & Analytics</span>
                    <label class="permission-switch">
                        <input type="checkbox" checked disabled>
                        <span class="slider"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- Recruiter Permissions -->
    <div class="col-lg-6 mb-4">
        <div class="permission-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">
                    <span class="role-badge role-recruiter">
                        <i class="fas fa-user-tie me-2"></i>Recruiter
                    </span>
                </h4>
                <span class="badge bg-info">Limited Access</span>
            </div>
            
            <div class="permission-group">
                <div class="permission-group-title">
                    <i class="fas fa-user-friends me-2"></i>Candidate Management
                </div>
                <div class="permission-item">
                    <span><i class="fas fa-check-circle text-success me-2"></i>Add New Candidates</span>
                    <label class="permission-switch">
                        <input type="checkbox" checked data-role="recruiter" data-permission="add_candidates">
                        <span class="slider"></span>
                    </label>
                </div>
                <div class="permission-item">
                    <span><i class="fas fa-check-circle text-success me-2"></i>Edit Own Candidates</span>
                    <label class="permission-switch">
                        <input type="checkbox" checked data-role="recruiter" data-permission="edit_own_candidates">
                        <span class="slider"></span>
                    </label>
                </div>
                <div class="permission-item">
                    <span><i class="fas fa-times-circle text-danger me-2"></i>Delete Candidates</span>
                    <label class="permission-switch">
                        <input type="checkbox" data-role="recruiter" data-permission="delete_candidates">
                        <span class="slider"></span>
                    </label>
                </div>
                <div class="permission-item">
                    <span><i class="fas fa-check-circle text-success me-2"></i>View All Candidates</span>
                    <label class="permission-switch">
                        <input type="checkbox" checked data-role="recruiter" data-permission="view_all_candidates">
                        <span class="slider"></span>
                    </label>
                </div>
            </div>

            <div class="permission-group">
                <div class="permission-group-title">
                    <i class="fas fa-calendar-alt me-2"></i>Interview Management
                </div>
                <div class="permission-item">
                    <span><i class="fas fa-check-circle text-success me-2"></i>Schedule Interviews</span>
                    <label class="permission-switch">
                        <input type="checkbox" checked data-role="recruiter" data-permission="schedule_interviews">
                        <span class="slider"></span>
                    </label>
                </div>
                <div class="permission-item">
                    <span><i class="fas fa-check-circle text-success me-2"></i>View Calendar</span>
                    <label class="permission-switch">
                        <input type="checkbox" checked data-role="recruiter" data-permission="view_calendar">
                        <span class="slider"></span>
                    </label>
                </div>
            </div>

            <div class="permission-group">
                <div class="permission-group-title">
                    <i class="fas fa-chart-bar me-2"></i>Reports
                </div>
                <div class="permission-item">
                    <span><i class="fas fa-check-circle text-success me-2"></i>View Own Reports</span>
                    <label class="permission-switch">
                        <input type="checkbox" checked data-role="recruiter" data-permission="view_own_reports">
                        <span class="slider"></span>
                    </label>
                </div>
                <div class="permission-item">
                    <span><i class="fas fa-times-circle text-danger me-2"></i>View All Reports</span>
                    <label class="permission-switch">
                        <input type="checkbox" data-role="recruiter" data-permission="view_all_reports">
                        <span class="slider"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- Interviewer Permissions -->
    <div class="col-lg-6 mb-4">
        <div class="permission-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">
                    <span class="role-badge role-interviewer">
                        <i class="fas fa-user-check me-2"></i>Interviewer
                    </span>
                </h4>
                <span class="badge bg-warning">View & Feedback</span>
            </div>
            
            <div class="permission-group">
                <div class="permission-group-title">
                    <i class="fas fa-calendar-check me-2"></i>Interview Access
                </div>
                <div class="permission-item">
                    <span><i class="fas fa-check-circle text-success me-2"></i>View Assigned Interviews</span>
                    <label class="permission-switch">
                        <input type="checkbox" checked data-role="interviewer" data-permission="view_assigned_interviews">
                        <span class="slider"></span>
                    </label>
                </div>
                <div class="permission-item">
                    <span><i class="fas fa-check-circle text-success me-2"></i>Submit Feedback</span>
                    <label class="permission-switch">
                        <input type="checkbox" checked data-role="interviewer" data-permission="submit_feedback">
                        <span class="slider"></span>
                    </label>
                </div>
                <div class="permission-item">
                    <span><i class="fas fa-check-circle text-success me-2"></i>View Candidate Details</span>
                    <label class="permission-switch">
                        <input type="checkbox" checked data-role="interviewer" data-permission="view_candidate_details">
                        <span class="slider"></span>
                    </label>
                </div>
            </div>

            <div class="permission-group">
                <div class="permission-group-title">
                    <i class="fas fa-user-friends me-2"></i>Candidate Management
                </div>
                <div class="permission-item">
                    <span><i class="fas fa-times-circle text-danger me-2"></i>Add Candidates</span>
                    <label class="permission-switch">
                        <input type="checkbox" data-role="interviewer" data-permission="add_candidates">
                        <span class="slider"></span>
                    </label>
                </div>
                <div class="permission-item">
                    <span><i class="fas fa-times-circle text-danger me-2"></i>Edit Candidates</span>
                    <label class="permission-switch">
                        <input type="checkbox" data-role="interviewer" data-permission="edit_candidates">
                        <span class="slider"></span>
                    </label>
                </div>
            </div>

            <div class="permission-group">
                <div class="permission-group-title">
                    <i class="fas fa-clock me-2"></i>Availability
                </div>
                <div class="permission-item">
                    <span><i class="fas fa-check-circle text-success me-2"></i>Manage Availability</span>
                    <label class="permission-switch">
                        <input type="checkbox" checked data-role="interviewer" data-permission="manage_availability">
                        <span class="slider"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- Candidate Permissions -->
    <div class="col-lg-6 mb-4">
        <div class="permission-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">
                    <span class="role-badge role-candidate">
                        <i class="fas fa-user-graduate me-2"></i>Candidate
                    </span>
                </h4>
                <span class="badge bg-secondary">Self-Service</span>
            </div>
            
            <div class="permission-group">
                <div class="permission-group-title">
                    <i class="fas fa-user-circle me-2"></i>Profile Access
                </div>
                <div class="permission-item">
                    <span><i class="fas fa-check-circle text-success me-2"></i>View Own Profile</span>
                    <label class="permission-switch">
                        <input type="checkbox" checked data-role="candidate" data-permission="view_own_profile">
                        <span class="slider"></span>
                    </label>
                </div>
                <div class="permission-item">
                    <span><i class="fas fa-check-circle text-success me-2"></i>Update Profile</span>
                    <label class="permission-switch">
                        <input type="checkbox" checked data-role="candidate" data-permission="update_profile">
                        <span class="slider"></span>
                    </label>
                </div>
                <div class="permission-item">
                    <span><i class="fas fa-check-circle text-success me-2"></i>Upload Documents</span>
                    <label class="permission-switch">
                        <input type="checkbox" checked data-role="candidate" data-permission="upload_documents">
                        <span class="slider"></span>
                    </label>
                </div>
            </div>

            <div class="permission-group">
                <div class="permission-group-title">
                    <i class="fas fa-calendar-alt me-2"></i>Interview Access
                </div>
                <div class="permission-item">
                    <span><i class="fas fa-check-circle text-success me-2"></i>View Interview Schedule</span>
                    <label class="permission-switch">
                        <input type="checkbox" checked data-role="candidate" data-permission="view_interview_schedule">
                        <span class="slider"></span>
                    </label>
                </div>
                <div class="permission-item">
                    <span><i class="fas fa-check-circle text-success me-2"></i>Confirm/Reschedule</span>
                    <label class="permission-switch">
                        <input type="checkbox" checked data-role="candidate" data-permission="confirm_reschedule">
                        <span class="slider"></span>
                    </label>
                </div>
            </div>

            <div class="permission-group">
                <div class="permission-group-title">
                    <i class="fas fa-envelope me-2"></i>Communication
                </div>
                <div class="permission-item">
                    <span><i class="fas fa-check-circle text-success me-2"></i>View Messages</span>
                    <label class="permission-switch">
                        <input type="checkbox" checked data-role="candidate" data-permission="view_messages">
                        <span class="slider"></span>
                    </label>
                </div>
                <div class="permission-item">
                    <span><i class="fas fa-check-circle text-success me-2"></i>Contact Recruiter</span>
                    <label class="permission-switch">
                        <input type="checkbox" checked data-role="candidate" data-permission="contact_recruiter">
                        <span class="slider"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function saveAllPermissions() {
    const permissions = {};
    
    // Collect all permission switches
    document.querySelectorAll('input[data-role]').forEach(input => {
        const role = input.dataset.role;
        const permission = input.dataset.permission;
        const enabled = input.checked;
        
        if (!permissions[role]) {
            permissions[role] = {};
        }
        permissions[role][permission] = enabled;
    });
    
    // Send to server
    fetch('<?= base_url('A_dashboard/save_permissions') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(permissions)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Saved!',
                text: 'Permissions updated successfully',
                timer: 2000,
                showConfirmButton: false
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'Failed to save permissions'
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while saving permissions'
        });
    });
}

// Auto-save on toggle
document.querySelectorAll('input[data-role]').forEach(input => {
    input.addEventListener('change', function() {
        // Optional: Auto-save individual permission
        console.log(`Permission ${this.dataset.permission} for ${this.dataset.role} changed to ${this.checked}`);
    });
});
</script>

<?php
// Load the footer template
$this->load->view('templates/admin_footer');
?>
