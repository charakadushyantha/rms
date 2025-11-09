<?php
$this->load->view('templates/admin_header', array('page_title' => 'Manage Users'));
?>

<?php if($this->session->flashdata('success_msg')): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i><?= $this->session->flashdata('success_msg') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<?php if($this->session->flashdata('error_msg')): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle me-2"></i><?= $this->session->flashdata('error_msg') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="data-card">
    <div class="data-card-header">
        <h3 class="data-card-title">
            <i class="fas fa-user-cog me-2"></i>Manage Users
        </h3>
        <div class="d-flex gap-2">
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-sm btn-outline-primary active" onclick="filterUsers('all')">
                    All Users
                </button>
                <button type="button" class="btn btn-sm btn-outline-warning" onclick="filterUsers('pending')">
                    <i class="fas fa-clock"></i> Pending Activation
                    <?php 
                    $pending_count = 0;
                    foreach($users as $u) {
                        $s = isset($u->u_status) ? $u->u_status : 'Active';
                        if($s == 'Pending' || $s == 'Inactive' || $s == '0' || $s == '') $pending_count++;
                    }
                    if($pending_count > 0): ?>
                    <span class="badge bg-warning text-dark"><?= $pending_count ?></span>
                    <?php endif; ?>
                </button>
                <button type="button" class="btn btn-sm btn-outline-success" onclick="filterUsers('active')">
                    <i class="fas fa-check"></i> Active
                </button>
            </div>
            <button class="btn btn-primary-modern btn-modern" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="fas fa-plus me-2"></i>Add New User
            </button>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover" id="usersTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($users)): ?>
                    <?php foreach($users as $user): ?>
                    <?php
                    // Determine status first (before using in tr tag)
                    $status = isset($user->u_status) ? $user->u_status : 'Active';
                    
                    // Handle different status values
                    if ($status == 'Active' || $status == '1') {
                        $status_color = 'success';
                        $status_icon = 'check-circle';
                        $status_text = 'Active';
                        $status_filter = 'active';
                    } elseif ($status == 'Pending' || $status == 'Inactive' || $status == '0' || $status == '') {
                        $status_color = 'warning';
                        $status_icon = 'clock';
                        $status_text = 'Pending Activation';
                        $status_filter = 'pending';
                    } elseif ($status == 'Suspended') {
                        $status_color = 'danger';
                        $status_icon = 'ban';
                        $status_text = 'Suspended';
                        $status_filter = 'suspended';
                    } else {
                        $status_color = 'secondary';
                        $status_icon = 'question-circle';
                        $status_text = $status;
                        $status_filter = 'other';
                    }
                    ?>
                    <tr data-status="<?= $status_filter ?>">
                        <td><?= $user->u_id ?></td>
                        <td><strong><?= htmlspecialchars($user->u_username) ?></strong></td>
                        <td><?= htmlspecialchars($user->u_email) ?></td>
                        <td>
                            <?php
                            $badge_color = 'secondary';
                            switch($user->u_role) {
                                case 'Admin': $badge_color = 'danger'; break;
                                case 'Recruiter': $badge_color = 'primary'; break;
                                case 'Interviewer': $badge_color = 'warning'; break;
                                case 'Candidate': $badge_color = 'success'; break;
                            }
                            ?>
                            <span class="badge bg-<?= $badge_color ?>">
                                <?= $user->u_role ?>
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-<?= $status_color ?>" style="font-size: 0.85rem; padding: 0.4rem 0.8rem;">
                                <i class="fas fa-<?= $status_icon ?>"></i> <?= $status_text ?>
                            </span>
                        </td>
                        <td><?= date('M d, Y', strtotime($user->u_created_at)) ?></td>
                        <td>
                            <div class="btn-group" role="group">
                                <?php if($user->u_username != $this->session->userdata('username')): ?>
                                    <?php if($status_text == 'Pending Activation' || $status == 'Pending' || $status == 'Inactive' || $status == '0' || $status == 'Suspended'): ?>
                                    <button class="btn btn-sm btn-success" onclick="toggleStatus(<?= $user->u_id ?>, '<?= htmlspecialchars($user->u_username) ?>', 'activate')" title="Activate User - Allow Login">
                                        <i class="fas fa-check-circle"></i> Activate
                                    </button>
                                    <?php else: ?>
                                    <button class="btn btn-sm btn-outline-secondary" onclick="toggleStatus(<?= $user->u_id ?>, '<?= htmlspecialchars($user->u_username) ?>', 'deactivate')" title="Deactivate User - Block Login">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <button class="btn btn-sm btn-warning" onclick="editUser(<?= htmlspecialchars(json_encode($user)) ?>)" title="Edit User">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <?php if($user->u_username != $this->session->userdata('username')): ?>
                                <button class="btn btn-sm btn-danger" onclick="deleteUser(<?= $user->u_id ?>, '<?= htmlspecialchars($user->u_username) ?>')" title="Delete User">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">No users found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('Setup/add_user') ?>" method="post">
                <div class="modal-body">
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
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role <span class="text-danger">*</span></label>
                        <select class="form-select" name="role" required>
                            <option value="">Select Role</option>
                            <option value="Admin">Admin</option>
                            <option value="Recruiter">Recruiter</option>
                            <option value="Interviewer">Interviewer</option>
                            <option value="Candidate">Candidate</option>
                        </select>
                        <small class="text-muted">
                            <strong>Admin:</strong> Full system access<br>
                            <strong>Recruiter:</strong> Manage candidates & interviews<br>
                            <strong>Interviewer:</strong> Conduct interviews & provide feedback<br>
                            <strong>Candidate:</strong> Apply for jobs & track application status
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-modern">Add User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('Setup/update_user') ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="user_id" id="edit_user_id">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" id="edit_username" readonly style="background: #f5f5f5;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" id="edit_email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Password <small class="text-muted">(leave blank to keep current)</small></label>
                        <input type="password" class="form-control" name="password" id="edit_password">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role <span class="text-danger">*</span></label>
                        <select class="form-select" name="role" id="edit_role" required>
                            <option value="Admin">Admin</option>
                            <option value="Recruiter">Recruiter</option>
                            <option value="Interviewer">Interviewer</option>
                            <option value="Candidate">Candidate</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Account Status <span class="text-danger">*</span></label>
                        <select class="form-select" name="status" id="edit_status" required>
                            <option value="Active">✅ Active - User can login</option>
                            <option value="Pending">⏳ Pending - Awaiting activation</option>
                            <option value="Suspended">🚫 Suspended - Account locked</option>
                        </select>
                        <small class="text-muted">
                            <strong>Active:</strong> User can login and use the system<br>
                            <strong>Pending:</strong> User cannot login until activated<br>
                            <strong>Suspended:</strong> Account temporarily locked
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning text-white">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editUser(user) {
    document.getElementById('edit_user_id').value = user.u_id;
    document.getElementById('edit_username').value = user.u_username;
    document.getElementById('edit_email').value = user.u_email;
    document.getElementById('edit_role').value = user.u_role;
    document.getElementById('edit_status').value = user.u_status || 'Active';
    document.getElementById('edit_password').value = '';
    
    const modal = new bootstrap.Modal(document.getElementById('editUserModal'));
    modal.show();
}

function toggleStatus(userId, username, action) {
    const actionText = action === 'activate' ? 'activate' : 'deactivate';
    const message = action === 'activate' 
        ? `Activate user "${username}"? They will be able to login after activation.`
        : `Deactivate user "${username}"? They will not be able to login until reactivated.`;
    
    if(typeof Swal !== 'undefined') {
        Swal.fire({
            title: action === 'activate' ? 'Activate User?' : 'Deactivate User?',
            text: message,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: action === 'activate' ? '#1cc88a' : '#858796',
            cancelButtonColor: '#6b7280',
            confirmButtonText: action === 'activate' ? '<i class="fas fa-check me-2"></i>Yes, Activate' : '<i class="fas fa-times me-2"></i>Yes, Deactivate',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= base_url('Setup/toggle_user_status/') ?>' + userId;
            }
        });
    } else {
        if(confirm(message)) {
            window.location.href = '<?= base_url('Setup/toggle_user_status/') ?>' + userId;
        }
    }
}

function filterUsers(filter) {
    const rows = document.querySelectorAll('#usersTable tbody tr');
    const buttons = document.querySelectorAll('.btn-group[role="group"] button');
    
    // Update button states
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.closest('button').classList.add('active');
    
    // Filter rows
    let visibleCount = 0;
    rows.forEach(row => {
        const status = row.getAttribute('data-status');
        if (filter === 'all') {
            row.style.display = '';
            visibleCount++;
        } else if (filter === 'pending' && status === 'pending') {
            row.style.display = '';
            visibleCount++;
        } else if (filter === 'active' && status === 'active') {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    console.log(`Filter: ${filter}, Visible rows: ${visibleCount}`);
}

function deleteUser(userId, username) {
    if(typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Delete User?',
            text: `Are you sure you want to delete user "${username}"? This action cannot be undone.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74a3b',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= base_url('Setup/delete_user/') ?>' + userId;
            }
        });
    } else {
        if(confirm(`Are you sure you want to delete user "${username}"?`)) {
            window.location.href = '<?= base_url('Setup/delete_user/') ?>' + userId;
        }
    }
}
</script>

<?php
$this->load->view('templates/admin_footer');
?>
