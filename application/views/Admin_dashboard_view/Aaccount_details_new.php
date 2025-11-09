<?php
// Set page-specific variables
$data['page_title'] = 'My Account';

// Load the header template
$this->load->view('templates/admin_header', $data);
?>

<!-- Success/Error Messages -->
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

<?php
// Get user data safely
$username = $this->session->userdata('username');
$email = $this->session->userdata('email');
$phone = '';
$gender = '';

if(isset($admin_details)) {
    if(is_object($admin_details)) {
        $email = isset($admin_details->u_email) ? $admin_details->u_email : $email;
        $phone = isset($admin_details->pi_phone) ? $admin_details->pi_phone : '';
        $gender = isset($admin_details->pi_gender) ? $admin_details->pi_gender : '';
    } elseif(is_array($admin_details)) {
        $email = isset($admin_details['u_email']) ? $admin_details['u_email'] : $email;
        $phone = isset($admin_details['pi_phone']) ? $admin_details['pi_phone'] : '';
        $gender = isset($admin_details['pi_gender']) ? $admin_details['pi_gender'] : '';
    }
}
?>

<div class="row g-4">
    <!-- Profile Card -->
    <div class="col-lg-4">
        <div class="data-card text-center">
            <div class="py-4">
                <div class="mb-4 position-relative" style="width: 120px; margin: 0 auto;">
                    <?php 
                    $profile_pic = '';
                    if(isset($admin_details)) {
                        if(is_object($admin_details)) {
                            $profile_pic = isset($admin_details->profile_picture) ? $admin_details->profile_picture : '';
                        } elseif(is_array($admin_details)) {
                            $profile_pic = isset($admin_details['profile_picture']) ? $admin_details['profile_picture'] : '';
                        }
                    }
                    ?>
                    
                    <?php if($profile_pic && file_exists('./uploads/profiles/' . $profile_pic)): ?>
                        <img src="<?= base_url('uploads/profiles/' . $profile_pic) ?>" 
                             alt="Profile Picture" 
                             id="profileImage"
                             style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 4px solid white; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                    <?php else: ?>
                        <div id="profileImage" style="width: 120px; height: 120px; border-radius: 50%; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); display: flex; align-items: center; justify-content: center; color: white; font-size: 48px; font-weight: 700; border: 4px solid white; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                            <?= strtoupper(substr($username, 0, 1)) ?>
                        </div>
                    <?php endif; ?>
                    
                    <button type="button" 
                            class="btn btn-sm btn-primary-modern" 
                            onclick="document.getElementById('profilePicInput').click()"
                            style="position: absolute; bottom: 0; right: 0; width: 36px; height: 36px; border-radius: 50%; padding: 0; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.2);">
                        <i class="fas fa-camera"></i>
                    </button>
                    
                    <form id="profilePicForm" action="<?= base_url('A_dashboard/upload_profile_picture') ?>" method="post" enctype="multipart/form-data" style="display: none;">
                        <input type="file" 
                               id="profilePicInput" 
                               name="profile_picture" 
                               accept="image/jpeg,image/png,image/jpg,image/gif"
                               onchange="uploadProfilePicture()">
                    </form>
                </div>
                <h3 style="font-weight: 700; color: var(--dark-color); margin-bottom: 8px;">
                    <?= $username ?>
                </h3>
                <p style="color: #999; margin-bottom: 20px;">
                    <i class="fas fa-shield-alt me-2"></i>Administrator
                </p>
                <div style="display: flex; gap: 10px; justify-content: center;">
                    <span class="badge bg-success">Active</span>
                    <span class="badge bg-info">Admin</span>
                </div>
            </div>
            
            <div style="border-top: 1px solid #e0e0e0; padding: 20px;">
                <div class="d-grid gap-2">
                    <button class="btn btn-primary-modern btn-modern" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                        <i class="fas fa-key me-2"></i>Change Password
                    </button>
                    <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        <i class="fas fa-edit me-2"></i>Edit Profile
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Account Details -->
    <div class="col-lg-8">
        <div class="data-card">
            <div class="data-card-header">
                <h3 class="data-card-title">Account Information</h3>
                <button class="btn btn-primary-modern btn-modern" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                    <i class="fas fa-edit me-2"></i>Edit
                </button>
            </div>
            
            <div class="row g-4 p-3">
                <div class="col-md-6">
                    <div class="mb-4">
                        <label style="font-size: 12px; color: #999; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; display: block;">Username</label>
                        <div style="font-size: 16px; font-weight: 600; color: var(--dark-color);">
                            <?= $username ?>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-4">
                        <label style="font-size: 12px; color: #999; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; display: block;">Email</label>
                        <div style="font-size: 16px; font-weight: 600; color: var(--dark-color);">
                            <?= $email ?: 'Not set' ?>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-4">
                        <label style="font-size: 12px; color: #999; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; display: block;">Role</label>
                        <div style="font-size: 16px; font-weight: 600; color: var(--dark-color);">
                            Administrator
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6"></div>
                    <div class="mb-4">
                        <label style="font-size: 12px; color: #999; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; display: block;">Status</label>
                        <div>
                            <span class="badge bg-success" style="font-size: 14px; padding: 6px 12px;">
                                <i class="fas fa-check-circle me-1"></i>Active
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-4">
                        <label style="font-size: 12px; color: #999; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; display: block;">Phone</label>
                        <div style="font-size: 16px; font-weight: 600; color: var(--dark-color);">
                            <?= $phone ?: 'Not set' ?>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-4">
                        <label style="font-size: 12px; color: #999; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; display: block;">Gender</label>
                        <div style="font-size: 16px; font-weight: 600; color: var(--dark-color);">
                            <?= $gender ?: 'Not set' ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Activity Card -->
        <div class="data-card mt-4">
            <div class="data-card-header">
                <h3 class="data-card-title">Recent Activity</h3>
            </div>
            
            <div class="list-group list-group-flush">
                <div class="list-group-item" style="border: none; padding: 16px;">
                    <div class="d-flex align-items-center">
                        <div style="width: 40px; height: 40px; border-radius: 50%; background: rgba(102, 126, 234, 0.1); display: flex; align-items: center; justify-content: center; color: var(--primary-color); margin-right: 15px;">
                            <i class="fas fa-sign-in-alt"></i>
                        </div>
                        <div>
                            <div style="font-weight: 600; color: var(--dark-color);">Logged in</div>
                            <small style="color: #999;">Today at <?= date('h:i A') ?></small>
                        </div>
                    </div>
                </div>
                
                <div class="list-group-item" style="border: none; padding: 16px;">
                    <div class="d-flex align-items-center">
                        <div style="width: 40px; height: 40px; border-radius: 50%; background: rgba(28, 200, 138, 0.1); display: flex; align-items: center; justify-content: center; color: var(--success-color); margin-right: 15px;">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div>
                            <div style="font-weight: 600; color: var(--dark-color);">Account verified</div>
                            <small style="color: #999;">Active account</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('A_dashboard/update_profile') ?>" method="post" id="editProfileForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" value="<?= $username ?>" readonly style="background: #f5f5f5;">
                        <small class="text-muted">Username cannot be changed</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="<?= $email ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="tel" class="form-control" name="phone" value="<?= $phone ?>" placeholder="Enter phone number">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gender</label>
                        <select class="form-select" name="gender">
                            <option value="">Select Gender</option>
                            <option value="Male" <?= $gender == 'Male' ? 'selected' : '' ?>>Male</option>
                            <option value="Female" <?= $gender == 'Female' ? 'selected' : '' ?>>Female</option>
                            <option value="Other" <?= $gender == 'Other' ? 'selected' : '' ?>>Other</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-modern btn-modern">
                        <i class="fas fa-save me-2"></i>Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Upload Confirm Modal -->
<div class="modal fade" id="uploadConfirmModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Profile Picture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="cancelUpload()"></button>
            </div>
            <div class="modal-body text-center">
                <p class="mb-3">Upload this image as your profile picture?</p>
                <img id="previewImage" src="" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="cancelUpload()">Cancel</button>
                <button type="button" class="btn btn-primary-modern btn-modern" onclick="confirmUpload()" data-bs-dismiss="modal">
                    <i class="fas fa-upload me-2"></i>Upload
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('A_dashboard/change_password') ?>" method="post" id="changePasswordForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="current_password" id="currentPassword" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('currentPassword')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="new_password" id="newPassword" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('newPassword')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <small class="text-muted">Minimum 6 characters</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm New Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="confirm_password" id="confirmPassword" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirmPassword')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div id="passwordMatch" class="mt-2"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-modern btn-modern" id="changePasswordBtn" disabled>
                        <i class="fas fa-key me-2"></i>Change Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
$custom_script = "
// Profile picture upload
let selectedFile = null;

function uploadProfilePicture() {
    const fileInput = document.getElementById('profilePicInput');
    const file = fileInput.files[0];
    
    if (!file) return;
    
    // Validate file type
    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
    if (!allowedTypes.includes(file.type)) {
        showCustomAlert('Please select a valid image file (JPG, PNG, or GIF)', 'error');
        fileInput.value = '';
        return;
    }
    
    // Validate file size (max 2MB)
    if (file.size > 2 * 1024 * 1024) {
        showCustomAlert('File size must be less than 2MB', 'error');
        fileInput.value = '';
        return;
    }
    
    // Store file and show preview
    selectedFile = file;
    showUploadConfirmModal(file);
}

function showUploadConfirmModal(file) {
    // Create preview
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('previewImage').src = e.target.result;
    };
    reader.readAsDataURL(file);
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('uploadConfirmModal'));
    modal.show();
}

function confirmUpload() {
    const form = document.getElementById('profilePicForm');
    form.submit();
}

function cancelUpload() {
    const fileInput = document.getElementById('profilePicInput');
    fileInput.value = '';
    selectedFile = null;
}

function showCustomAlert(message, type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-\${type === 'error' ? 'danger' : 'success'} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        <i class=\"fas fa-\${type === 'error' ? 'exclamation-circle' : 'check-circle'} me-2\"></i>\${message}
        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
    `;
    
    const container = document.querySelector('.content-area');
    container.insertBefore(alertDiv, container.firstChild);
    
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}

// Toggle password visibility
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = event.currentTarget.querySelector('i');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Password match validation
document.getElementById('newPassword').addEventListener('input', checkPasswordMatch);
document.getElementById('confirmPassword').addEventListener('input', checkPasswordMatch);

function checkPasswordMatch() {
    const newPass = document.getElementById('newPassword').value;
    const confirmPass = document.getElementById('confirmPassword').value;
    const matchDiv = document.getElementById('passwordMatch');
    const submitBtn = document.getElementById('changePasswordBtn');
    
    if (confirmPass === '') {
        matchDiv.innerHTML = '';
        submitBtn.disabled = true;
        return;
    }
    
    if (newPass === confirmPass && newPass.length >= 6) {
        matchDiv.innerHTML = '<small class=\"text-success\"><i class=\"fas fa-check-circle\"></i> Passwords match</small>';
        submitBtn.disabled = false;
    } else if (newPass.length < 6) {
        matchDiv.innerHTML = '<small class=\"text-danger\"><i class=\"fas fa-times-circle\"></i> Password must be at least 6 characters</small>';
        submitBtn.disabled = true;
    } else {
        matchDiv.innerHTML = '<small class=\"text-danger\"><i class=\"fas fa-times-circle\"></i> Passwords do not match</small>';
        submitBtn.disabled = true;
    }
}

// Form validation
document.getElementById('editProfileForm').addEventListener('submit', function(e) {
    const email = this.querySelector('[name=\"email\"]').value;
    if (!email || !email.includes('@')) {
        e.preventDefault();
        alert('Please enter a valid email address');
        return false;
    }
});

document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
    const newPass = document.getElementById('newPassword').value;
    const confirmPass = document.getElementById('confirmPassword').value;
    
    if (newPass !== confirmPass) {
        e.preventDefault();
        alert('Passwords do not match');
        return false;
    }
    
    if (newPass.length < 6) {
        e.preventDefault();
        alert('Password must be at least 6 characters');
        return false;
    }
});
";

$data['custom_script'] = $custom_script;

// Load the footer template
$this->load->view('templates/admin_footer', $data);
?>
