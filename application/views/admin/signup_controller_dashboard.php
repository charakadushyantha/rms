<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - RMS Admin</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    
    <style>
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .stats-card {
            border-left: 4px solid #007bff;
            transition: transform 0.2s;
        }
        .stats-card:hover {
            transform: translateY(-2px);
        }
        .role-badge {
            font-size: 0.8em;
            padding: 0.3em 0.6em;
        }
        .status-pending { background-color: #ffc107; }
        .status-active { background-color: #28a745; }
        .status-rejected { background-color: #dc3545; }
        .status-inactive { background-color: #6c757d; }
        
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }
        
        .switch input {
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
            border-radius: 34px;
        }
        
        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        
        input:checked + .slider {
            background-color: #2196F3;
        }
        
        input:checked + .slider:before {
            transform: translateX(26px);
        }
    </style>
</head>
<body class="bg-light">

<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0"><i class="fas fa-user-cog me-2"></i><?php echo $page_title; ?></h1>
                    <p class="text-muted">Manage user registration and access control settings</p>
                </div>
                <div>
                    <a href="<?php echo base_url('Signup_controller/audit_logs'); ?>" class="btn btn-info me-2">
                        <i class="fas fa-history me-1"></i>Audit Logs
                    </a>
                    <a href="<?php echo A_DASHBOARD_URL; ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i><?php echo $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i><?php echo $this->session->flashdata('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stats-card" style="cursor: pointer;" onclick="quickFilterByStatus('Pending')">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title text-muted">Pending Approvals</h6>
                            <h3 class="mb-0"><?php echo count($pending_registrations); ?></h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-clock fa-2x text-warning"></i>
                        </div>
                    </div>
                    <small class="text-muted"><i class="fas fa-filter"></i> Click to filter</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card" style="cursor: pointer;" onclick="quickFilterByStatus('Active')">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title text-muted">Recent Registrations</h6>
                            <h3 class="mb-0"><?php echo count($recent_registrations); ?></h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-user-plus fa-2x text-info"></i>
                        </div>
                    </div>
                    <small class="text-muted"><i class="fas fa-filter"></i> Click to filter</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title text-muted">Auto-Approve Enabled</h6>
                            <h3 class="mb-0">
                                <?php 
                                $auto_count = 0;
                                if ($signup_settings->auto_approve_admin) $auto_count++;
                                if ($signup_settings->auto_approve_recruiter) $auto_count++;
                                if ($signup_settings->auto_approve_interviewer) $auto_count++;
                                if ($signup_settings->auto_approve_candidate) $auto_count++;
                                echo $auto_count . '/4';
                                ?>
                            </h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check-double fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title text-muted">Signup Enabled Roles</h6>
                            <h3 class="mb-0">
                                <?php 
                                $enabled_count = 0;
                                if ($signup_settings->admin_signup_enabled) $enabled_count++;
                                if ($signup_settings->recruiter_signup_enabled) $enabled_count++;
                                if ($signup_settings->interviewer_signup_enabled) $enabled_count++;
                                if ($signup_settings->candidate_signup_enabled) $enabled_count++;
                                echo $enabled_count . '/4';
                                ?>
                            </h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-users fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Signup Settings -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-cogs me-2"></i>Signup Access Control Settings</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="<?php echo base_url('Signup_controller/update_settings'); ?>">
                        
                        <!-- Role-based Signup Enable/Disable -->
                        <h6 class="mb-3">Enable Signup by Role</h6>
                        
                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="admin_signup_enabled" 
                                           <?php echo $signup_settings->admin_signup_enabled ? 'checked' : ''; ?>>
                                    <label class="form-check-label">
                                        <i class="fas fa-user-shield text-danger me-1"></i>Admin Signup
                                    </label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="recruiter_signup_enabled" 
                                           <?php echo $signup_settings->recruiter_signup_enabled ? 'checked' : ''; ?>>
                                    <label class="form-check-label">
                                        <i class="fas fa-user-tie text-primary me-1"></i>Recruiter Signup
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="interviewer_signup_enabled" 
                                           <?php echo $signup_settings->interviewer_signup_enabled ? 'checked' : ''; ?>>
                                    <label class="form-check-label">
                                        <i class="fas fa-user-check text-info me-1"></i>Interviewer Signup
                                    </label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="candidate_signup_enabled" 
                                           <?php echo $signup_settings->candidate_signup_enabled ? 'checked' : ''; ?>>
                                    <label class="form-check-label">
                                        <i class="fas fa-user text-success me-1"></i>Candidate Signup
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Auto-Approval Settings -->
                        <h6 class="mb-3">Auto-Approval Settings</h6>
                        
                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="auto_approve_admin" 
                                           <?php echo $signup_settings->auto_approve_admin ? 'checked' : ''; ?>>
                                    <label class="form-check-label">Auto-approve Admin</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="auto_approve_recruiter" 
                                           <?php echo $signup_settings->auto_approve_recruiter ? 'checked' : ''; ?>>
                                    <label class="form-check-label">Auto-approve Recruiter</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="auto_approve_interviewer" 
                                           <?php echo $signup_settings->auto_approve_interviewer ? 'checked' : ''; ?>>
                                    <label class="form-check-label">Auto-approve Interviewer</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="auto_approve_candidate" 
                                           <?php echo $signup_settings->auto_approve_candidate ? 'checked' : ''; ?>>
                                    <label class="form-check-label">Auto-approve Candidate</label>
                                </div>
                            </div>
                        </div>

                        <!-- General Settings -->
                        <h6 class="mb-3">General Settings</h6>
                        
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="require_email_verification" 
                                       <?php echo $signup_settings->require_email_verification ? 'checked' : ''; ?>>
                                <label class="form-check-label">Require Email Verification</label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Default Signup Role</label>
                            <select class="form-select" name="default_signup_role">
                                <option value="Recruiter" <?php echo $signup_settings->default_signup_role == 'Recruiter' ? 'selected' : ''; ?>>Recruiter</option>
                                <option value="Candidate" <?php echo $signup_settings->default_signup_role == 'Candidate' ? 'selected' : ''; ?>>Candidate</option>
                                <option value="Interviewer" <?php echo $signup_settings->default_signup_role == 'Interviewer' ? 'selected' : ''; ?>>Interviewer</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Update Settings
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Create New User -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-user-plus me-2"></i>Create New User Account</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="<?php echo base_url('Signup_controller/create_user'); ?>">
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
                            <label class="form-label">Role</label>
                            <select class="form-select" name="role" required>
                                <option value="">Select Role</option>
                                <option value="Admin">Admin</option>
                                <option value="Recruiter">Recruiter</option>
                                <option value="Interviewer">Interviewer</option>
                                <option value="Candidate">Candidate</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="auto_activate" checked>
                                <label class="form-check-label">
                                    Activate account immediately
                                </label>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-plus me-1"></i>Create User
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-search me-2"></i>Search & Filter Users</h5>
                </div>
                <div class="card-body">
                    <form id="searchFilterForm" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Search</label>
                            <input type="text" class="form-control" id="searchQuery" name="search" 
                                   placeholder="Username or Email...">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Role</label>
                            <select class="form-select" id="filterRole" name="role">
                                <option value="">All Roles</option>
                                <option value="Admin">Admin</option>
                                <option value="Recruiter">Recruiter</option>
                                <option value="Interviewer">Interviewer</option>
                                <option value="Candidate">Candidate</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" id="filterStatus" name="status">
                                <option value="">All Statuses</option>
                                <option value="Active">Active</option>
                                <option value="Pending">Pending</option>
                                <option value="Inactive">Inactive</option>
                                <option value="Suspended">Suspended</option>
                                <option value="Rejected">Rejected</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-primary" onclick="applyFilters()">
                                    <i class="fas fa-filter me-1"></i>Filter
                                </button>
                                <button type="button" class="btn btn-secondary" onclick="clearFilters()">
                                    <i class="fas fa-times me-1"></i>Clear
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- All Users Table (Filtered Results) -->
    <div class="row mt-4" id="filteredUsersSection" style="display: none;">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-users me-2"></i>Filtered Users (<span id="filteredCount">0</span>)</h5>
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="clearFilters()">
                        <i class="fas fa-times me-1"></i>Clear Filters
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="filteredUsersTable">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Created Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="filteredUsersBody">
                                <!-- Results will be loaded here via AJAX -->
                            </tbody>
                        </table>
                    </div>
                    <div id="noResults" style="display: none;" class="text-center py-4 text-muted">
                        <i class="fas fa-search fa-3x mb-3"></i>
                        <p>No users found matching your criteria</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Registrations -->
    <?php if (!empty($pending_registrations)): ?>
    <div class="row mt-4" id="pendingSection">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-hourglass-half me-2"></i>Pending Registrations</h5>
                    <button type="button" class="btn btn-success btn-sm" onclick="bulkApprove()">
                        <i class="fas fa-check-double me-1"></i>Bulk Approve
                    </button>
                </div>
                <div class="card-body">
                    <form id="bulkApproveForm" method="post" action="<?php echo base_url('Signup_controller/bulk_approve'); ?>">
                        <div class="table-responsive">
                            <table class="table table-hover" id="pendingTable">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectAll"></th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Registration Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pending_registrations as $user): ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="selected_users[]" value="<?php echo $user->u_id; ?>" class="user-checkbox">
                                        </td>
                                        <td><?php echo htmlspecialchars($user->u_username); ?></td>
                                        <td><?php echo htmlspecialchars($user->u_email); ?></td>
                                        <td>
                                            <span class="badge role-badge bg-secondary">
                                                <?php echo $user->u_role; ?>
                                            </span>
                                        </td>
                                        <td><?php echo isset($user->created_at) ? date('M d, Y', strtotime($user->created_at)) : 'N/A'; ?></td>
                                        <td>
                                            <a href="<?php echo base_url('Signup_controller/approve_registration/' . $user->u_id); ?>" 
                                               class="btn btn-success btn-sm" title="Approve">
                                                <i class="fas fa-check"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm" 
                                                    onclick="rejectUser(<?php echo $user->u_id; ?>)" title="Reject">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            <button type="button" class="btn btn-info btn-sm" 
                                                    onclick="editUser(<?php echo $user->u_id; ?>)" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-warning btn-sm" 
                                                    onclick="deleteUser(<?php echo $user->u_id; ?>)" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Recent Registrations -->
    <?php if (!empty($recent_registrations)): ?>
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>Recent Registrations (Last 30 Days)</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="recentTable">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Registration Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_registrations as $user): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($user->u_username); ?></td>
                                    <td><?php echo htmlspecialchars($user->u_email); ?></td>
                                    <td>
                                        <span class="badge role-badge bg-secondary">
                                            <?php echo $user->u_role; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge status-<?php echo strtolower($user->u_status); ?>">
                                            <?php echo $user->u_status; ?>
                                        </span>
                                    </td>
                                    <td><?php echo isset($user->created_at) ? date('M d, Y H:i', strtotime($user->created_at)) : 'N/A'; ?></td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" 
                                                onclick="editUser(<?php echo $user->u_id; ?>)" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <?php if ($user->u_status == 'Active'): ?>
                                        <button type="button" class="btn btn-secondary btn-sm" 
                                                onclick="changeStatus(<?php echo $user->u_id; ?>, 'Inactive')" title="Deactivate">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                        <?php else: ?>
                                        <button type="button" class="btn btn-success btn-sm" 
                                                onclick="changeStatus(<?php echo $user->u_id; ?>, 'Active')" title="Activate">
                                            <i class="fas fa-check-circle"></i>
                                        </button>
                                        <?php endif; ?>
                                        <button type="button" class="btn btn-danger btn-sm" 
                                                onclick="deleteUser(<?php echo $user->u_id; ?>)" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Rejection Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject Registration</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="rejectForm" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Rejection Reason (Optional)</label>
                        <textarea class="form-control" name="rejection_reason" rows="3" 
                                  placeholder="Provide a reason for rejection..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Registration</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm">
                <div class="modal-body">
                    <input type="hidden" id="edit_user_id" name="user_id">
                    
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" id="edit_username" name="username" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select class="form-select" id="edit_role" name="role" required>
                            <option value="Admin">Admin</option>
                            <option value="Recruiter">Recruiter</option>
                            <option value="Interviewer">Interviewer</option>
                            <option value="Candidate">Candidate</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" id="edit_status" name="status" required>
                            <option value="Active">Active</option>
                            <option value="Pending">Pending</option>
                            <option value="Inactive">Inactive</option>
                            <option value="Suspended">Suspended</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">New Password (Leave blank to keep current)</label>
                        <input type="password" class="form-control" id="edit_password" name="password" 
                               placeholder="Enter new password or leave blank">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize DataTables
    $('#pendingTable, #recentTable').DataTable({
        pageLength: 10,
        responsive: true,
        order: [[4, 'desc']] // Sort by date
    });
    
    // Select all checkbox functionality
    $('#selectAll').change(function() {
        $('.user-checkbox').prop('checked', this.checked);
    });
    
    $('.user-checkbox').change(function() {
        if (!this.checked) {
            $('#selectAll').prop('checked', false);
        }
    });
});

function bulkApprove() {
    const selected = $('.user-checkbox:checked').length;
    if (selected === 0) {
        alert('Please select at least one user to approve.');
        return;
    }
    
    if (confirm(`Are you sure you want to approve ${selected} user registration(s)?`)) {
        $('#bulkApproveForm').submit();
    }
}

function rejectUser(userId) {
    $('#rejectForm').attr('action', '<?php echo base_url("Signup_controller/reject_registration/"); ?>' + userId);
    $('#rejectModal').modal('show');
}

function editUser(userId) {
    // Fetch user details via AJAX
    $.ajax({
        url: '<?php echo base_url("Signup_controller/get_user_details"); ?>',
        type: 'POST',
        data: { user_id: userId },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('#edit_user_id').val(response.user.u_id);
                $('#edit_username').val(response.user.u_username);
                $('#edit_email').val(response.user.u_email);
                $('#edit_role').val(response.user.u_role);
                $('#edit_status').val(response.user.u_status);
                $('#edit_password').val('');
                $('#editModal').modal('show');
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function() {
            alert('Failed to fetch user details');
        }
    });
}

function deleteUser(userId) {
    if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
        $.ajax({
            url: '<?php echo base_url("Signup_controller/delete_user"); ?>',
            type: 'POST',
            data: { user_id: userId },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    location.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                alert('Failed to delete user');
            }
        });
    }
}

function changeStatus(userId, status) {
    const action = status === 'Active' ? 'activate' : 'deactivate';
    if (confirm(`Are you sure you want to ${action} this user?`)) {
        $.ajax({
            url: '<?php echo base_url("Signup_controller/change_user_status"); ?>',
            type: 'POST',
            data: { user_id: userId, status: status },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    location.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                alert('Failed to change user status');
            }
        });
    }
}

// Handle edit form submission
$('#editForm').on('submit', function(e) {
    e.preventDefault();
    
    $.ajax({
        url: '<?php echo base_url("Signup_controller/update_user"); ?>',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                alert(response.message);
                $('#editModal').modal('hide');
                location.reload();
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function() {
            alert('Failed to update user');
        }
    });
});

// Search and Filter Functions
function applyFilters() {
    const search = $('#searchQuery').val();
    const role = $('#filterRole').val();
    const status = $('#filterStatus').val();
    
    // Show loading state
    $('#filteredUsersBody').html('<tr><td colspan="6" class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading...</td></tr>');
    $('#filteredUsersSection').show();
    $('#noResults').hide();
    
    // Hide default sections when filtering
    $('#pendingSection').hide();
    $('#recentSection').hide();
    
    $.ajax({
        url: '<?php echo base_url("Signup_controller/search_users"); ?>',
        type: 'POST',
        data: {
            search: search,
            role: role,
            status: status
        },
        dataType: 'json',
        success: function(response) {
            if (response.success && response.users.length > 0) {
                displayFilteredUsers(response.users);
                $('#filteredCount').text(response.count);
                $('#noResults').hide();
            } else {
                $('#filteredUsersBody').html('');
                $('#noResults').show();
                $('#filteredCount').text(0);
            }
        },
        error: function() {
            alert('Failed to search users');
            $('#filteredUsersBody').html('<tr><td colspan="6" class="text-center text-danger">Error loading results</td></tr>');
        }
    });
}

function displayFilteredUsers(users) {
    let html = '';
    
    users.forEach(function(user) {
        // Determine status badge class
        let statusClass = 'status-' + user.u_status.toLowerCase();
        
        // Format date
        let createdDate = user.created_at ? new Date(user.created_at).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        }) : 'N/A';
        
        html += '<tr>';
        html += '<td>' + escapeHtml(user.u_username) + '</td>';
        html += '<td>' + escapeHtml(user.u_email) + '</td>';
        html += '<td><span class="badge role-badge bg-secondary">' + user.u_role + '</span></td>';
        html += '<td><span class="badge ' + statusClass + '">' + user.u_status + '</span></td>';
        html += '<td>' + createdDate + '</td>';
        html += '<td>';
        
        // Edit button
        html += '<button type="button" class="btn btn-info btn-sm" onclick="editUser(' + user.u_id + ')" title="Edit">';
        html += '<i class="fas fa-edit"></i></button> ';
        
        // Status toggle button
        if (user.u_status === 'Active') {
            html += '<button type="button" class="btn btn-secondary btn-sm" onclick="changeStatus(' + user.u_id + ', \'Inactive\')" title="Deactivate">';
            html += '<i class="fas fa-ban"></i></button> ';
        } else if (user.u_status === 'Pending') {
            html += '<button type="button" class="btn btn-success btn-sm" onclick="changeStatus(' + user.u_id + ', \'Active\')" title="Approve">';
            html += '<i class="fas fa-check"></i></button> ';
        } else {
            html += '<button type="button" class="btn btn-success btn-sm" onclick="changeStatus(' + user.u_id + ', \'Active\')" title="Activate">';
            html += '<i class="fas fa-check-circle"></i></button> ';
        }
        
        // Delete button
        html += '<button type="button" class="btn btn-danger btn-sm" onclick="deleteUser(' + user.u_id + ')" title="Delete">';
        html += '<i class="fas fa-trash"></i></button>';
        
        html += '</td>';
        html += '</tr>';
    });
    
    $('#filteredUsersBody').html(html);
}

function clearFilters() {
    // Clear form inputs
    $('#searchQuery').val('');
    $('#filterRole').val('');
    $('#filterStatus').val('');
    
    // Hide filtered section
    $('#filteredUsersSection').hide();
    
    // Show default sections
    $('#pendingSection').show();
    $('#recentSection').show();
}

function escapeHtml(text) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}

// Enable Enter key to trigger search
$('#searchQuery').on('keypress', function(e) {
    if (e.which === 13) {
        e.preventDefault();
        applyFilters();
    }
});

// Quick filter buttons (optional enhancement)
function quickFilterByRole(role) {
    $('#filterRole').val(role);
    $('#searchQuery').val('');
    $('#filterStatus').val('');
    applyFilters();
}

function quickFilterByStatus(status) {
    $('#filterStatus').val(status);
    $('#searchQuery').val('');
    $('#filterRole').val('');
    applyFilters();
}
</script>

</body>
</html>