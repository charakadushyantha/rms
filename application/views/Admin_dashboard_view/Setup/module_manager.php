<?php
$data['page_title'] = 'Module Manager';
$this->load->view('templates/admin_header', $data);
?>

<style>
.section-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 16px 24px;
    border-radius: 12px;
    margin-bottom: 24px;
}
.module-card {
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 16px;
    transition: all 0.3s;
}
.module-card:hover {
    border-color: #667eea;
    background: #f7fafc;
}
.icon-preview {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: white;
    margin-bottom: 10px;
}
.module-row {
    transition: all 0.3s;
}
.module-row:hover {
    background: #f8f9fa;
}
.drag-handle {
    cursor: move;
    color: #999;
}
.drag-handle:hover {
    color: #667eea;
}
.table-actions .btn {
    padding: 4px 8px;
    font-size: 12px;
}
</style>

<!-- Include SweetAlert2 for better dialogs -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="section-header">
    <h2 class="mb-1"><i class="fas fa-puzzle-piece me-2"></i>Module Manager</h2>
    <p class="mb-0 opacity-90">Add and manage custom modules in the sidebar navigation</p>
</div>

<!-- DEBUG MESSAGE - VERY VISIBLE -->
<?php
if (!isset($system_modules)) {
    echo "<div class='alert alert-danger' style='font-size: 18px; font-weight: bold; border: 3px solid red;'>";
    echo "❌ DEBUG: Variable \$system_modules is NOT SET from controller!<br>";
    echo "This means the controller is not passing data to the view.<br>";
    echo "Solution: Restart Apache in XAMPP and refresh this page.";
    echo "</div>";
} elseif (empty($system_modules)) {
    echo "<div class='alert alert-warning' style='font-size: 18px; font-weight: bold; border: 3px solid orange;'>";
    echo "⚠️ DEBUG: Variable \$system_modules is EMPTY!<br>";
    echo "Database query returned no results.<br>";
    echo "Solution: Run update_module_visibility_complete.php again.";
    echo "</div>";
} else {
    echo "<div class='alert alert-success' style='font-size: 18px; font-weight: bold; border: 3px solid green;'>";
    echo "✅ DEBUG: Found " . count($system_modules) . " modules from controller!<br>";
    echo "The data is being passed correctly. You should see " . count($system_modules) . " modules below.";
    echo "</div>";
}
?>

<!-- Flash Messages -->
<?php if($this->session->flashdata('success_msg')): ?>
<div class="alert alert-success alert-dismissible fade show" id="successAlert">
    <i class="fas fa-check-circle me-2"></i>
    <?= $this->session->flashdata('success_msg') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<script>
// Auto-dismiss success message after 5 seconds
setTimeout(function() {
    var alert = document.getElementById('successAlert');
    if (alert) {
        var bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    }
}, 5000);
</script>
<?php endif; ?>

<?php if($this->session->flashdata('error_msg')): ?>
<div class="alert alert-danger alert-dismissible fade show" id="errorAlert">
    <i class="fas fa-exclamation-circle me-2"></i>
    <?= $this->session->flashdata('error_msg') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<script>
// Auto-dismiss error message after 8 seconds
setTimeout(function() {
    var alert = document.getElementById('errorAlert');
    if (alert) {
        var bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    }
}, 8000);
</script>
<?php endif; ?>

<div class="row">
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-eye me-2"></i>System Modules Visibility</h5>
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">Control which default system modules appear in the sidebar navigation.</p>
                
                <form action="<?= base_url('Setup/save_module_visibility') ?>" method="POST">
                    <div class="row g-3">
                        <?php
                        // Get current visibility settings
                        $visibility_settings = array();
                        if ($this->db->table_exists('module_visibility')) {
                            $settings = $this->db->get('module_visibility')->result_array();
                            foreach ($settings as $setting) {
                                $visibility_settings[$setting['module_key']] = $setting['is_visible'];
                            }
                        }
                        
                        // Load ALL modules from controller data
                        $default_modules = array();
                        
                        // DEBUG: Check if data is passed from controller
                        if (!isset($system_modules)) {
                            echo "<div class='alert alert-danger' style='font-size: 16px;'>❌ DEBUG: \$system_modules NOT SET from controller!</div>";
                        } elseif (empty($system_modules)) {
                            echo "<div class='alert alert-warning' style='font-size: 16px;'>⚠️ DEBUG: \$system_modules is EMPTY!</div>";
                        } else {
                            echo "<div class='alert alert-info' style='font-size: 16px;'>✅ DEBUG: Found " . count($system_modules) . " modules from controller</div>";
                            echo "<div class='alert alert-secondary' style='font-size: 14px;'>First module: " . $system_modules[0]['module_key'] . " - " . (isset($system_modules[0]['module_name']) ? $system_modules[0]['module_name'] : 'NO NAME') . "</div>";
                        }
                        
                        if (isset($system_modules) && !empty($system_modules)) {
                            $modules_from_db = $system_modules;
                            
                            foreach ($modules_from_db as $mod) {
                                // Map module keys to icons
                                $icon_map = array(
                                    'dashboard' => 'fas fa-tachometer-alt',
                                    'candidates' => 'fas fa-users',
                                    'calendar' => 'fas fa-calendar-alt',
                                    'interviews' => 'fas fa-video',
                                    'interview_management' => 'fas fa-calendar-check',
                                    'questions_bank' => 'fas fa-question-circle',
                                    'analytics' => 'fas fa-chart-line',
                                    'job_posting' => 'fas fa-briefcase',
                                    'job_analytics' => 'fas fa-chart-pie',
                                    'sales_marketing' => 'fas fa-bullhorn',
                                    'marketing_campaigns' => 'fas fa-envelope-open-text',
                                    'candidate_sourcing' => 'fas fa-search',
                                    'talent_pools' => 'fas fa-layer-group',
                                    'referral_program' => 'fas fa-user-friends',
                                    'recruitment_events' => 'fas fa-calendar-star',
                                    'employee_advocacy' => 'fas fa-users-cog',
                                    'employer_branding' => 'fas fa-building',
                                    'paid_advertising' => 'fas fa-ad',
                                    'roi_tracking' => 'fas fa-chart-line',
                                    'candidate_crm' => 'fas fa-handshake',
                                    'media_gallery' => 'fas fa-images',
                                    'reviews_management' => 'fas fa-star',
                                    'awards_recognition' => 'fas fa-trophy',
                                    'integration_hub' => 'fas fa-plug',
                                    'video_integrations' => 'fas fa-video',
                                    'assessment_integrations' => 'fas fa-code',
                                    'background_check' => 'fas fa-shield-alt',
                                    'ats_integrations' => 'fas fa-sync-alt',
                                    'job_board_platforms' => 'fas fa-share-alt',
                                    'recruiters' => 'fas fa-user-tie',
                                    'interviewers' => 'fas fa-user-check',
                                    'candidate_users' => 'fas fa-user-graduate',
                                    'reports' => 'fas fa-chart-bar',
                                    'custom_reports' => 'fas fa-file-chart-line',
                                    'export_data' => 'fas fa-file-export',
                                    'marketing_automation' => 'fas fa-robot',
                                    'auto_distribution' => 'fas fa-random',
                                    'roles' => 'fas fa-shield-alt',
                                    'signup_controller' => 'fas fa-user-cog',
                                    'chatbot' => 'fas fa-robot',
                                    'setup' => 'fas fa-cog',
                                    'module_manager' => 'fas fa-th-large',
                                    'company_settings' => 'fas fa-building',
                                    'email_configuration' => 'fas fa-envelope',
                                    'account' => 'fas fa-user-circle',
                                );
                                
                                $default_modules[] = array(
                                    'key' => $mod['module_key'],
                                    'name' => isset($mod['module_name']) && $mod['module_name'] ? $mod['module_name'] : ucwords(str_replace('_', ' ', $mod['module_key'])),
                                    'icon' => isset($icon_map[$mod['module_key']]) ? $icon_map[$mod['module_key']] : 'fas fa-puzzle-piece',
                                    'section' => isset($mod['section']) && $mod['section'] ? $mod['section'] : 'Other'
                                );
                            }
                        }
                        
                        // DEBUG: Show how many modules were processed
                        echo "<div class='alert alert-primary' style='font-size: 16px;'>📊 DEBUG: Processed " . count($default_modules) . " modules into \$default_modules array</div>";
                        
                        // If no modules in database, use fallback
                        if (empty($default_modules)) {
                            echo "<div class='alert alert-danger' style='font-size: 16px;'>❌ DEBUG: \$default_modules is EMPTY! Using fallback (3 modules)</div>";
                            $default_modules = array(
                                array('key' => 'dashboard', 'name' => 'Dashboard', 'icon' => 'fas fa-tachometer-alt', 'section' => 'Main'),
                                array('key' => 'candidates', 'name' => 'Candidates', 'icon' => 'fas fa-users', 'section' => 'Recruitment'),
                                array('key' => 'calendar', 'name' => 'Calendar', 'icon' => 'fas fa-calendar-alt', 'section' => 'Recruitment'),
                            );
                        } else {
                            echo "<div class='alert alert-success' style='font-size: 16px;'>✅ DEBUG: \$default_modules has " . count($default_modules) . " modules - will display them below</div>";
                        }
                        
                        foreach ($default_modules as $module):
                            $is_visible = isset($visibility_settings[$module['key']]) ? $visibility_settings[$module['key']] : 1;
                        ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="module-card">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="<?= $module['icon'] ?> fa-2x text-primary me-3"></i>
                                        <div>
                                            <h6 class="mb-0"><?= $module['name'] ?></h6>
                                            <small class="text-muted"><?= $module['section'] ?></small>
                                        </div>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="visibility[<?= $module['key'] ?>]" 
                                               <?= $is_visible ? 'checked' : '' ?> 
                                               style="width: 3em; height: 1.5em;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Save Visibility Settings
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="checkAll()">
                            <i class="fas fa-check-double me-2"></i>Show All
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="uncheckAll()">
                            <i class="fas fa-times me-2"></i>Hide All
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-list me-2"></i>Custom Modules</h5>
                <div class="input-group" style="width: 300px;">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" id="moduleSearch" placeholder="Search modules..." style="background: white;">
                </div>
            </div>
            <div class="card-body">
                <!-- Quick Stats -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="d-flex gap-3">
                            <div class="badge bg-primary p-2">
                                <i class="fas fa-puzzle-piece me-1"></i>
                                <span id="moduleCount"><?= isset($custom_modules) ? count($custom_modules) + 4 : 4 ?></span> Total Modules
                            </div>
                            <div class="badge bg-success p-2">
                                <i class="fas fa-check-circle me-1"></i>
                                <span><?= isset($custom_modules) ? count(array_filter($custom_modules, function($m) { return $m['is_active']; })) : 0 ?></span> Active
                            </div>
                            <div class="badge bg-warning p-2">
                                <i class="fas fa-plus-circle me-1"></i>
                                <span><?= isset($custom_modules) ? count($custom_modules) : 0 ?></span> Custom
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Icon</th>
                                <th>Module Name</th>
                                <th>Section</th>
                                <th>URL</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="moduleList">
                            <!-- Default Modules -->
                            <tr>
                                <td>1</td>
                                <td><i class="fas fa-tachometer-alt text-primary"></i></td>
                                <td>Dashboard</td>
                                <td><span class="badge bg-secondary">Main</span></td>
                                <td><code>A_dashboard</code></td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>
                                    <span class="badge bg-info">System</span>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td><i class="fas fa-users text-primary"></i></td>
                                <td>Candidates</td>
                                <td><span class="badge bg-info">Recruitment</span></td>
                                <td><code>A_dashboard/Acandidate_users_view</code></td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>
                                    <span class="badge bg-info">System</span>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td><i class="fas fa-calendar text-primary"></i></td>
                                <td>Calendar</td>
                                <td><span class="badge bg-info">Recruitment</span></td>
                                <td><code>A_dashboard/Ainterviewer_view</code></td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>
                                    <span class="badge bg-info">System</span>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td><i class="fas fa-chart-line text-success"></i></td>
                                <td>Analytics</td>
                                <td><span class="badge bg-info">Recruitment</span></td>
                                <td><code>A_dashboard/reports_view</code></td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>
                                    <span class="badge bg-info">System</span>
                                </td>
                            </tr>
                            
                            <!-- Custom Modules will be loaded here from database -->
                            <?php if(isset($custom_modules) && !empty($custom_modules)): ?>
                                <?php foreach($custom_modules as $module): ?>
                                <tr>
                                    <td><?= $module['order_num'] ?></td>
                                    <td><i class="<?= $module['icon'] ?> text-primary"></i></td>
                                    <td><?= $module['name'] ?></td>
                                    <td><span class="badge bg-warning"><?= $module['section'] ?></span></td>
                                    <td><code><?= $module['url'] ?></code></td>
                                    <td>
                                        <?php if($module['is_active']): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" onclick="editModule(<?= $module['id'] ?>)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" onclick="deleteModule(<?= $module['id'] ?>)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header text-white" id="formHeader" style="background: linear-gradient(135deg, #10b981, #059669);">
                <h5 class="mb-0">
                    <i class="fas fa-plus me-2" id="formIcon"></i>
                    <span id="formTitle">Add New Module</span>
                </h5>
            </div>
            <div class="card-body">
                <form action="<?= base_url('Setup/save_module') ?>" method="POST" id="moduleForm">
                    <input type="hidden" name="module_id" id="module_id">
                    
                    <div class="mb-3">
                        <label class="form-label">Module Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="module_name" id="module_name" required placeholder="e.g., Training">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Section <span class="text-danger">*</span></label>
                        <select class="form-select" name="section" id="section" required>
                            <option value="">Select Section</option>
                            <option value="RECRUITMENT">Recruitment</option>
                            <option value="USER MANAGEMENT">User Management</option>
                            <option value="REPORTS">Reports</option>
                            <option value="SETTINGS">Settings</option>
                            <option value="CUSTOM">Custom Section</option>
                        </select>
                    </div>
                    
                    <div class="mb-3" id="customSectionDiv" style="display: none;">
                        <label class="form-label">Custom Section Name</label>
                        <input type="text" class="form-control" name="custom_section" id="custom_section" placeholder="e.g., TRAINING">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Icon Class <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="icon" id="icon" required placeholder="fas fa-book">
                        <small class="text-muted">Use Font Awesome icons. <a href="https://fontawesome.com/icons" target="_blank">Browse icons</a></small>
                        <div class="mt-2">
                            <div class="icon-preview" id="iconPreview" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                                <i class="fas fa-question"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Controller/URL <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="url" id="url" required placeholder="A_dashboard/training_view">
                        <small class="text-muted">Relative URL path</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Display Order</label>
                        <input type="number" class="form-control" name="order_num" id="order_num" value="10" min="1">
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked>
                            <label class="form-check-label">Active</label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="show_badge" id="show_badge">
                            <label class="form-check-label">Show "NEW" Badge</label>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-save me-2"></i>Save Module
                    </button>
                    <button type="button" class="btn btn-secondary w-100 mt-2" onclick="resetForm()">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                </form>
            </div>
        </div>
        
        <div class="card border-0 shadow-sm mt-3">
            <div class="card-body">
                <h6 class="mb-3"><i class="fas fa-info-circle me-2 text-info"></i>Quick Guide</h6>
                <ul class="small">
                    <li>Create a controller and view for your module first</li>
                    <li>Use Font Awesome icon classes</li>
                    <li>Order determines position in sidebar</li>
                    <li>Inactive modules won't appear in sidebar</li>
                    <li>System modules cannot be deleted</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
// Check/Uncheck all visibility toggles
function checkAll() {
    document.querySelectorAll('input[name^="visibility["]').forEach(function(checkbox) {
        checkbox.checked = true;
    });
}

function uncheckAll() {
    if (confirm('Are you sure you want to hide all system modules? This will make navigation difficult.')) {
        document.querySelectorAll('input[name^="visibility["]').forEach(function(checkbox) {
            checkbox.checked = false;
        });
    }
}

// Show/hide custom section input
document.getElementById('section').addEventListener('change', function() {
    const customDiv = document.getElementById('customSectionDiv');
    if (this.value === 'CUSTOM') {
        customDiv.style.display = 'block';
        document.getElementById('custom_section').required = true;
    } else {
        customDiv.style.display = 'none';
        document.getElementById('custom_section').required = false;
    }
});

// Icon preview
document.getElementById('icon').addEventListener('input', function() {
    const iconPreview = document.getElementById('iconPreview');
    const iconClass = this.value || 'fas fa-question';
    iconPreview.innerHTML = '<i class="' + iconClass + '"></i>';
});

// Edit module - Load data into form
function editModule(id) {
    // Show loading
    Swal.fire({
        title: 'Loading...',
        text: 'Fetching module data',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    // Fetch module data via fetch API
    fetch('<?= base_url('Setup/get_module/') ?>' + id, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(module => {
        Swal.close();
        
        // Populate form
        document.getElementById('module_id').value = module.id;
        document.getElementById('module_name').value = module.name;
        document.getElementById('icon').value = module.icon;
        document.getElementById('url').value = module.url;
        document.getElementById('order_num').value = module.order_num;
        document.getElementById('is_active').checked = module.is_active == 1;
        document.getElementById('show_badge').checked = module.show_badge == 1;
        
        // Handle section
        const sectionSelect = document.getElementById('section');
        const predefinedSections = ['RECRUITMENT', 'USER MANAGEMENT', 'REPORTS', 'SETTINGS'];
        
        if (predefinedSections.includes(module.section)) {
            sectionSelect.value = module.section;
        } else {
            sectionSelect.value = 'CUSTOM';
            document.getElementById('customSectionDiv').style.display = 'block';
            document.getElementById('custom_section').value = module.section;
        }
        
        // Update icon preview
        document.getElementById('iconPreview').innerHTML = '<i class="' + module.icon + '"></i>';
        
        // Scroll to form
        document.querySelector('.col-md-4').scrollIntoView({ behavior: 'smooth', block: 'start' });
        
        // Highlight form
        const formCard = document.querySelector('.col-md-4 .card');
        formCard.style.border = '3px solid #667eea';
        formCard.style.boxShadow = '0 0 20px rgba(102, 126, 234, 0.3)';
        
        setTimeout(() => {
            formCard.style.border = '';
            formCard.style.boxShadow = '';
        }, 2000);
        
        // Show success notification
        Swal.fire({
            icon: 'success',
            title: 'Module Loaded',
            text: 'You can now edit the module details',
            timer: 2000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to load module data. Please try again.'
        });
    });
}

// Delete module with SweetAlert2
function deleteModule(id) {
    Swal.fire({
        title: 'Delete Module?',
        text: "This module will be removed from the sidebar. You can add it back later.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-trash me-2"></i>Yes, delete it',
        cancelButtonText: '<i class="fas fa-times me-2"></i>Cancel',
        customClass: {
            popup: 'animated fadeIn faster'
        }
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
            
            // Use fetch to delete
            fetch('<?= base_url('Setup/delete_module/') ?>' + id, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Module has been deleted successfully.',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        // Reload page to refresh the list
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Failed to delete module.'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to delete module. Please try again.'
                });
            });
        }
    });
}

// Reset form
function resetForm() {
    document.getElementById('moduleForm').reset();
    document.getElementById('module_id').value = '';
    document.getElementById('iconPreview').innerHTML = '<i class="fas fa-question"></i>';
    document.getElementById('customSectionDiv').style.display = 'none';
    
    // Reset form header to "Add New"
    document.getElementById('formTitle').textContent = 'Add New Module';
    document.getElementById('formIcon').className = 'fas fa-plus me-2';
    document.getElementById('formHeader').style.background = 'linear-gradient(135deg, #10b981, #059669)';
}

// Search modules
document.getElementById('moduleSearch')?.addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#moduleList tr');
    let visibleCount = 0;
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    // Update count if exists
    const countElement = document.getElementById('moduleCount');
    if (countElement) {
        countElement.textContent = visibleCount;
    }
});

// Add module count
document.addEventListener('DOMContentLoaded', function() {
    const totalModules = document.querySelectorAll('#moduleList tr').length;
    const systemModules = document.querySelectorAll('#moduleList tr .badge-info').length;
    const customModules = totalModules - systemModules;
    
    console.log('Total modules:', totalModules);
    console.log('Custom modules:', customModules);
});
</script>

<?php $this->load->view('templates/admin_footer'); ?>
