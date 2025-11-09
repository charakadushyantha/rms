<?php
$data['page_title'] = 'My Profile';
$this->load->view('templates/candidate_header', $data);
?>

<style>
.profile-container {
    padding: 2rem;
    max-width: 1200px;
    margin: 0 auto;
}

.profile-layout {
    display: grid;
    grid-template-columns: 350px 1fr;
    gap: 2rem;
}

.profile-sidebar {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    height: fit-content;
}

.profile-avatar-section {
    text-align: center;
    margin-bottom: 2rem;
}

.profile-avatar-wrapper {
    position: relative;
    width: 150px;
    height: 150px;
    margin: 0 auto 1rem;
}

.profile-avatar {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #14b8a6;
}

.profile-avatar-placeholder {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    background: linear-gradient(135deg, #14b8a6 0%, #06b6d4 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 4rem;
    font-weight: 700;
    border: 4px solid #14b8a6;
}

.avatar-upload-btn {
    position: absolute;
    bottom: 5px;
    right: 5px;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #14b8a6;
    color: white;
    border: 3px solid white;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
}

.avatar-upload-btn:hover {
    background: #0d9488;
    transform: scale(1.1);
}

.avatar-upload-btn input {
    display: none;
}

.profile-name {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.profile-role {
    display: inline-block;
    padding: 0.5rem 1rem;
    background: #d1fae5;
    color: #065f46;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.profile-status {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: #d1fae5;
    color: #065f46;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
}

.status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #10b981;
}

.profile-actions {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    margin-top: 1.5rem;
}

.btn-action {
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    border: none;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.btn-primary {
    background: #14b8a6;
    color: white;
}

.btn-primary:hover {
    background: #0d9488;
}

.btn-secondary {
    background: white;
    color: #14b8a6;
    border: 2px solid #14b8a6;
}

.btn-secondary:hover {
    background: #f0fdfa;
}

.profile-main {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

.section-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #f3f4f6;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
    display: block;
}

.form-control {
    width: 100%;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    padding: 0.75rem;
    transition: all 0.2s;
}

.form-control:focus {
    border-color: #14b8a6;
    box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
    outline: none;
}

.btn-save {
    background: #14b8a6;
    color: white;
    padding: 1rem 2rem;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    width: 100%;
}

.btn-save:hover {
    background: #0d9488;
}

@media (max-width: 968px) {
    .profile-layout {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="profile-container">
    <div class="profile-layout">
        <!-- Sidebar -->
        <div class="profile-sidebar">
            <div class="profile-avatar-section">
                <div class="profile-avatar-wrapper">
                    <?php if (isset($user_info['u_profile_picture']) && !empty($user_info['u_profile_picture'])): ?>
                        <img src="<?php echo base_url($user_info['u_profile_picture']); ?>" alt="Profile" class="profile-avatar" id="profileImage">
                    <?php else: ?>
                        <div class="profile-avatar-placeholder" id="profileImage">
                            <?php echo strtoupper(substr($uname, 0, 1)); ?>
                        </div>
                    <?php endif; ?>
                    
                    <label class="avatar-upload-btn" title="Change Profile Picture">
                        <i class="fas fa-camera"></i>
                        <input type="file" id="profilePictureInput" accept="image/*">
                    </label>
                </div>
                
                <div class="profile-name"><?php echo htmlspecialchars($uname); ?></div>
                <div class="profile-role">Candidate</div>
                <div class="profile-status">
                    <span class="status-dot"></span>
                    Active
                </div>
            </div>

            <div class="profile-actions">
                <button class="btn-action btn-primary" onclick="document.getElementById('profileForm').scrollIntoView({behavior: 'smooth'})">
                    <i class="fas fa-edit"></i>
                    Edit Profile
                </button>
                <a href="<?php echo base_url('C_dashboard/my_cv'); ?>" class="btn-action btn-secondary">
                    <i class="fas fa-id-card"></i>
                    My CV
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="profile-main">
            <h3 class="section-title">Account Information</h3>
            <form id="profileForm">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" 
                           value="<?php echo htmlspecialchars($user_info['u_email']); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Phone</label>
                    <input type="tel" class="form-control" name="phone" 
                           value="<?php echo isset($candidate_info['cd_phone']) ? htmlspecialchars($candidate_info['cd_phone']) : ''; ?>">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" class="form-control" name="address" 
                       value="<?php echo isset($candidate_info['cd_address']) ? htmlspecialchars($candidate_info['cd_address']) : ''; ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">City</label>
                <input type="text" class="form-control" name="city" 
                       value="<?php echo isset($candidate_info['cd_city']) ? htmlspecialchars($candidate_info['cd_city']) : ''; ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Skills</label>
                <textarea class="form-control" name="skills" rows="3"><?php echo isset($candidate_info['cd_skills']) ? htmlspecialchars($candidate_info['cd_skills']) : ''; ?></textarea>
            </div>
                <button type="submit" class="btn-save">
                    <i class="fas fa-save me-2"></i>Save Profile
                </button>
            </form>
        </div>
    </div>
</div>

<?php
$custom_script = "
// Profile Picture Upload
document.getElementById('profilePictureInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;
    
    // Preview image
    const reader = new FileReader();
    reader.onload = function(e) {
        const img = document.getElementById('profileImage');
        if (img.tagName === 'IMG') {
            img.src = e.target.result;
        } else {
            img.outerHTML = '<img src=\"' + e.target.result + '\" alt=\"Profile\" class=\"profile-avatar\" id=\"profileImage\">';
        }
    };
    reader.readAsDataURL(file);
    
    // Upload image
    const formData = new FormData();
    formData.append('profile_picture', file);
    
    Swal.fire({
        title: 'Uploading...',
        text: 'Please wait',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    fetch('" . base_url('C_dashboard/upload_profile_picture') . "', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Profile Picture Updated!',
                text: data.message,
                timer: 2000
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire('Error', data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error', 'Failed to upload profile picture', 'error');
    });
});

// Profile Form Submit
document.getElementById('profileForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    
    Swal.fire({
        title: 'Saving...',
        text: 'Please wait',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    fetch('" . base_url('C_dashboard/update_profile') . "', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Profile Updated!',
                text: data.message,
                timer: 2000
            });
        } else {
            Swal.fire('Error', data.message, 'error');
        }
    });
});
";

$data['custom_script'] = $custom_script;
$this->load->view('templates/candidate_footer', $data);
?>
