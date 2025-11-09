<?php
$data['page_title'] = 'My Profile';
$this->load->view('templates/interviewer_header', $data);
?>

<style>
.profile-container {
    padding: 2rem;
    background: #f8f9fa;
    min-height: calc(100vh - 70px);
}

.profile-wrapper {
    max-width: 1000px;
    margin: 0 auto;
}

.profile-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin-bottom: 1.5rem;
}

.profile-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 12px;
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 2rem;
}

.profile-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: white;
    color: #667eea;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    font-weight: 700;
}

.profile-info h2 {
    margin: 0 0 0.5rem 0;
    font-size: 2rem;
}

.profile-info p {
    margin: 0;
    opacity: 0.9;
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
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    outline: none;
}

.availability-grid {
    display: grid;
    gap: 1rem;
}

.day-slot {
    background: #f9fafb;
    padding: 1rem;
    border-radius: 8px;
    border: 2px solid #e5e7eb;
}

.day-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.75rem;
}

.day-name {
    font-weight: 700;
    color: #1f2937;
}

.toggle-switch {
    position: relative;
    width: 50px;
    height: 26px;
}

.toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.toggle-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 26px;
}

.toggle-slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}

input:checked + .toggle-slider {
    background-color: #667eea;
}

input:checked + .toggle-slider:before {
    transform: translateX(24px);
}

.time-inputs {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.time-input-group {
    display: flex;
    flex-direction: column;
}

.time-input-group label {
    font-size: 0.875rem;
    color: #6b7280;
    margin-bottom: 0.25rem;
}

.time-input-group input {
    padding: 0.5rem;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
}

.btn-save {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 1rem 2rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.2s;
    width: 100%;
}

.btn-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.stat-box {
    background: #f9fafb;
    padding: 1.5rem;
    border-radius: 12px;
    text-align: center;
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: #667eea;
}

.stat-label {
    font-size: 0.875rem;
    color: #6b7280;
    margin-top: 0.5rem;
}
</style>

<div class="profile-container">
    <div class="profile-wrapper">
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-avatar">
                <?php echo strtoupper(substr($uname, 0, 1)); ?>
            </div>
            <div class="profile-info">
                <h2><?php echo htmlspecialchars($uname); ?></h2>
                <p><i class="fas fa-envelope me-2"></i><?php echo htmlspecialchars($user_info['u_email']); ?></p>
            </div>
        </div>

        <!-- Statistics -->
        <div class="profile-card">
            <h3 class="section-title">
                <i class="fas fa-chart-line me-2"></i>Your Statistics
            </h3>
            <div class="stats-grid">
                <div class="stat-box">
                    <div class="stat-value">0</div>
                    <div class="stat-label">Total Interviews</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value">0</div>
                    <div class="stat-label">This Month</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value">0</div>
                    <div class="stat-label">Feedback Given</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value">0.0</div>
                    <div class="stat-label">Avg Rating</div>
                </div>
            </div>
        </div>

        <!-- Personal Information -->
        <div class="profile-card">
            <h3 class="section-title">
                <i class="fas fa-user me-2"></i>Personal Information
            </h3>
            <form id="profileForm">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" name="full_name" 
                                   value="<?php echo htmlspecialchars($user_info['u_username']); ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" name="email" 
                                   value="<?php echo htmlspecialchars($user_info['u_email']); ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" name="phone" 
                                   value="<?php echo isset($user_info['u_phone']) ? htmlspecialchars($user_info['u_phone']) : ''; ?>" 
                                   placeholder="+1 (555) 123-4567">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Department</label>
                            <input type="text" class="form-control" name="department" 
                                   value="<?php echo isset($user_info['department']) ? htmlspecialchars($user_info['department']) : ''; ?>" 
                                   placeholder="e.g., Engineering, HR">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Areas of Expertise</label>
                    <textarea class="form-control" name="expertise" rows="3" 
                              placeholder="e.g., JavaScript, React, Node.js, System Design"><?php echo isset($user_info['expertise']) ? htmlspecialchars($user_info['expertise']) : ''; ?></textarea>
                </div>

                <button type="submit" class="btn-save">
                    <i class="fas fa-save me-2"></i>Save Profile
                </button>
            </form>
        </div>

        <!-- Availability Schedule -->
        <div class="profile-card">
            <h3 class="section-title">
                <i class="fas fa-calendar-check me-2"></i>Availability Schedule
            </h3>
            <p style="color: #6b7280; margin-bottom: 1.5rem;">
                Set your weekly availability for conducting interviews
            </p>

            <form id="availabilityForm">
                <div class="availability-grid">
                    <?php
                    $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                    $existing_availability = [];
                    
                    if (!empty($availability)) {
                        foreach ($availability as $slot) {
                            $existing_availability[$slot['day_of_week']] = $slot;
                        }
                    }
                    
                    for ($i = 0; $i < 7; $i++):
                        $is_available = isset($existing_availability[$i]);
                        $start_time = $is_available ? $existing_availability[$i]['start_time'] : '09:00';
                        $end_time = $is_available ? $existing_availability[$i]['end_time'] : '17:00';
                    ?>
                    <div class="day-slot">
                        <div class="day-header">
                            <span class="day-name"><?php echo $days[$i]; ?></span>
                            <label class="toggle-switch">
                                <input type="checkbox" class="day-toggle" data-day="<?php echo $i; ?>" 
                                       <?php echo $is_available ? 'checked' : ''; ?>>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                        <div class="time-inputs" id="times-<?php echo $i; ?>" 
                             style="display: <?php echo $is_available ? 'grid' : 'none'; ?>;">
                            <div class="time-input-group">
                                <label>Start Time</label>
                                <input type="time" name="availability[<?php echo $i; ?>][start_time]" 
                                       value="<?php echo $start_time; ?>">
                            </div>
                            <div class="time-input-group">
                                <label>End Time</label>
                                <input type="time" name="availability[<?php echo $i; ?>][end_time]" 
                                       value="<?php echo $end_time; ?>">
                            </div>
                        </div>
                    </div>
                    <?php endfor; ?>
                </div>

                <button type="submit" class="btn-save mt-3">
                    <i class="fas fa-calendar-check me-2"></i>Save Availability
                </button>
            </form>
        </div>
    </div>
</div>

<?php
$custom_script = "
// Toggle day availability
document.querySelectorAll('.day-toggle').forEach(toggle => {
    toggle.addEventListener('change', function() {
        const day = this.dataset.day;
        const timesDiv = document.getElementById('times-' + day);
        timesDiv.style.display = this.checked ? 'grid' : 'none';
    });
});

// Profile Form Submission
document.getElementById('profileForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    Swal.fire({
        title: 'Updating...',
        text: 'Please wait',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    fetch('" . base_url('I_dashboard/update_profile') . "', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Profile Updated!',
                text: 'Your profile has been updated successfully',
                timer: 2000
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'Failed to update profile'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while updating profile'
        });
    });
});

// Availability Form Submission
document.getElementById('availabilityForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Collect availability data
    const availability = [];
    document.querySelectorAll('.day-toggle:checked').forEach(toggle => {
        const day = toggle.dataset.day;
        const startTime = document.querySelector('input[name=\"availability[' + day + '][start_time]\"]').value;
        const endTime = document.querySelector('input[name=\"availability[' + day + '][end_time]\"]').value;
        
        availability.push({
            day_of_week: day,
            start_time: startTime,
            end_time: endTime,
            is_available: 1
        });
    });
    
    Swal.fire({
        title: 'Updating...',
        text: 'Please wait',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    fetch('" . base_url('I_dashboard/update_availability') . "', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ availability: availability })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Availability Updated!',
                text: 'Your availability has been updated successfully',
                timer: 2000
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'Failed to update availability'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while updating availability'
        });
    });
});
";

$data['custom_script'] = $custom_script;
$this->load->view('templates/interviewer_footer', $data);
?>
