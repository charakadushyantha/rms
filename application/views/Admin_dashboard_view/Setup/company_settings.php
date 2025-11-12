<?php
$this->load->view('templates/admin_header', array('page_title' => 'Company Settings'));
?>

<?php 
// Only show one message at a time - error takes priority
// Use keep_flashdata to prevent it from showing on other pages
$has_alert = false;
$error_msg = $this->session->flashdata('error_msg');
$success_msg = $this->session->flashdata('success_msg');

// Mark flashdata as consumed so it doesn't show on other pages
if($error_msg || $success_msg) {
    $this->session->mark_as_flash('error_msg');
    $this->session->mark_as_flash('success_msg');
}

if($error_msg): 
    $has_alert = true;
?>
<div class="alert alert-danger alert-dismissible fade show auto-dismiss-alert" role="alert">
    <i class="fas fa-exclamation-circle me-2"></i><?= $error_msg ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php elseif($success_msg): 
    $has_alert = true;
?>
<div class="alert alert-success alert-dismissible fade show auto-dismiss-alert" role="alert">
    <i class="fas fa-check-circle me-2"></i><?= $success_msg ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php 
endif;

// Unset the flashdata after displaying to prevent it from showing on other pages
$this->session->unset_userdata('__ci_vars');
?>

<?php if($has_alert): ?>
<script>
// Auto-dismiss alert after 5 seconds - inline script to ensure it runs
setTimeout(function() {
    var alerts = document.querySelectorAll('.auto-dismiss-alert');
    alerts.forEach(function(alert) {
        // Fade out effect
        alert.style.transition = 'opacity 0.5s ease';
        alert.style.opacity = '0';
        
        // Remove after fade
        setTimeout(function() {
            alert.remove();
        }, 500);
    });
}, 5000);
</script>
<?php endif; ?>

<!-- Navigation Tabs -->
<ul class="nav nav-tabs mb-4" id="companyTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button">
            <i class="fas fa-building me-2"></i>Company Profile
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="departments-tab" data-bs-toggle="tab" data-bs-target="#departments" type="button">
            <i class="fas fa-sitemap me-2"></i>Departments
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="branches-tab" data-bs-toggle="tab" data-bs-target="#branches" type="button">
            <i class="fas fa-map-marker-alt me-2"></i>Branches
        </button>
    </li>
</ul>

<div class="tab-content" id="companyTabsContent">
    <!-- Company Profile Tab -->
    <div class="tab-pane fade show active" id="profile" role="tabpanel">
        <div class="data-card">
            <div class="data-card-header">
                <h3 class="data-card-title">
                    <i class="fas fa-building me-2"></i>Company Profile
                </h3>
            </div>
            
            <form action="<?= base_url('Setup/save_company_profile') ?>" method="post" enctype="multipart/form-data" class="p-4">
                <div class="row">
                    <div class="col-md-8">
                        <h5 class="mb-3">Basic Information</h5>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Company Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="company_name" 
                                       value="<?= isset($settings->company_name) ? htmlspecialchars($settings->company_name) : '' ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="company_email" 
                                       value="<?= isset($settings->company_email) ? htmlspecialchars($settings->company_email) : '' ?>" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" class="form-control" name="company_phone" 
                                       value="<?= isset($settings->company_phone) ? htmlspecialchars($settings->company_phone) : '' ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Website</label>
                                <input type="url" class="form-control" name="website" 
                                       value="<?= isset($settings->website) ? htmlspecialchars($settings->website) : '' ?>">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <h5 class="mb-3">Company Logo</h5>
                        <div class="text-center">
                            <?php if(isset($settings->company_logo) && !empty($settings->company_logo)): ?>
                                <img src="<?= base_url('uploads/company/' . $settings->company_logo) ?>" 
                                     alt="Company Logo" class="img-fluid mb-3" style="max-height: 150px;">
                            <?php else: ?>
                                <div class="mb-3" style="width: 150px; height: 150px; margin: 0 auto; background: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-building fa-3x text-muted"></i>
                                </div>
                            <?php endif; ?>
                            <input type="file" class="form-control" name="company_logo" accept="image/*">
                            <small class="text-muted">Max 2MB (JPG, PNG, GIF)</small>
                        </div>
                    </div>
                </div>
                
                <hr class="my-4">
                
                <h5 class="mb-3">Address Information</h5>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Street Address</label>
                        <textarea class="form-control" name="company_address" rows="2"><?= isset($settings->company_address) ? htmlspecialchars($settings->company_address) : '' ?></textarea>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">City</label>
                        <input type="text" class="form-control" name="company_city" 
                               value="<?= isset($settings->company_city) ? htmlspecialchars($settings->company_city) : '' ?>">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">State/Province</label>
                        <input type="text" class="form-control" name="company_state" 
                               value="<?= isset($settings->company_state) ? htmlspecialchars($settings->company_state) : '' ?>">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Country</label>
                        <input type="text" class="form-control" name="company_country" 
                               value="<?= isset($settings->company_country) ? htmlspecialchars($settings->company_country) : '' ?>">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Postal Code</label>
                        <input type="text" class="form-control" name="company_postal_code" 
                               value="<?= isset($settings->company_postal_code) ? htmlspecialchars($settings->company_postal_code) : '' ?>">
                    </div>
                </div>
                
                <hr class="my-4">
                
                <h5 class="mb-3">Legal & Registration</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Registration Number</label>
                        <input type="text" class="form-control" name="registration_number" 
                               value="<?= isset($settings->registration_number) ? htmlspecialchars($settings->registration_number) : '' ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tax ID / VAT Number</label>
                        <input type="text" class="form-control" name="tax_id" 
                               value="<?= isset($settings->tax_id) ? htmlspecialchars($settings->tax_id) : '' ?>">
                    </div>
                </div>
                
                <hr class="my-4">
                
                <h5 class="mb-3">Business Configuration</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Business Hours Start</label>
                        <input type="time" class="form-control" name="business_hours_start" 
                               value="<?= isset($settings->business_hours_start) ? $settings->business_hours_start : '09:00' ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Business Hours End</label>
                        <input type="time" class="form-control" name="business_hours_end" 
                               value="<?= isset($settings->business_hours_end) ? $settings->business_hours_end : '17:00' ?>">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Financial Year Start</label>
                        <input type="date" class="form-control" name="financial_year_start" 
                               value="<?= isset($settings->financial_year_start) ? $settings->financial_year_start : '' ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Financial Year End</label>
                        <input type="date" class="form-control" name="financial_year_end" 
                               value="<?= isset($settings->financial_year_end) ? $settings->financial_year_end : '' ?>">
                    </div>
                </div>
                
                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary-modern btn-modern">
                        <i class="fas fa-save me-2"></i>Save Company Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Departments Tab -->
    <div class="tab-pane fade" id="departments" role="tabpanel">
        <div class="data-card">
            <div class="data-card-header">
                <h3 class="data-card-title">
                    <i class="fas fa-sitemap me-2"></i>Departments
                </h3>
                <button class="btn btn-primary-modern btn-modern" data-bs-toggle="modal" data-bs-target="#addDepartmentModal">
                    <i class="fas fa-plus me-2"></i>Add Department
                </button>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Department Name</th>
                            <th>Department Head</th>
                            <th>Description</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($departments)): ?>
                            <?php foreach($departments as $dept): ?>
                            <tr>
                                <td><?= $dept->id ?></td>
                                <td><strong><?= htmlspecialchars($dept->department_name) ?></strong></td>
                                <td><?= htmlspecialchars($dept->department_head) ?></td>
                                <td><?= htmlspecialchars($dept->description) ?></td>
                                <td><?= date('M d, Y', strtotime($dept->created_at)) ?></td>
                                <td>
                                    <button class="btn btn-sm btn-warning" onclick="editDepartment(<?= htmlspecialchars(json_encode($dept)) ?>)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteDepartment(<?= $dept->id ?>, '<?= htmlspecialchars($dept->department_name) ?>')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-sitemap fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No departments found. Add your first department.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Branches Tab -->
    <div class="tab-pane fade" id="branches" role="tabpanel">
        <div class="data-card">
            <div class="data-card-header">
                <h3 class="data-card-title">
                    <i class="fas fa-map-marker-alt me-2"></i>Branches / Locations
                </h3>
                <button class="btn btn-primary-modern btn-modern" data-bs-toggle="modal" data-bs-target="#addBranchModal">
                    <i class="fas fa-plus me-2"></i>Add Branch
                </button>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Branch Name</th>
                            <th>Code</th>
                            <th>Location</th>
                            <th>Contact</th>
                            <th>Manager</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($branches)): ?>
                            <?php foreach($branches as $branch): ?>
                            <tr>
                                <td><?= $branch->id ?></td>
                                <td><strong><?= htmlspecialchars($branch->branch_name) ?></strong></td>
                                <td><span class="badge bg-info"><?= htmlspecialchars($branch->branch_code) ?></span></td>
                                <td><?= htmlspecialchars($branch->city . ', ' . $branch->state) ?></td>
                                <td>
                                    <div style="font-size: 0.85rem;">
                                        <div><?= htmlspecialchars($branch->phone) ?></div>
                                        <div class="text-muted"><?= htmlspecialchars($branch->email) ?></div>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($branch->manager) ?></td>
                                <td>
                                    <button class="btn btn-sm btn-warning" onclick="editBranch(<?= htmlspecialchars(json_encode($branch)) ?>)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteBranch(<?= $branch->id ?>, '<?= htmlspecialchars($branch->branch_name) ?>')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-map-marker-alt fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No branches found. Add your first branch location.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Department Modal -->
<div class="modal fade" id="addDepartmentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus me-2"></i>Add Department</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('Setup/add_department') ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Department Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="department_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Department Head</label>
                        <input type="text" class="form-control" name="department_head">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-modern">Add Department</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Department Modal -->
<div class="modal fade" id="editDepartmentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Department</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('Setup/update_department') ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="department_id" id="edit_dept_id">
                    <div class="mb-3">
                        <label class="form-label">Department Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="department_name" id="edit_dept_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Department Head</label>
                        <input type="text" class="form-control" name="department_head" id="edit_dept_head">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="edit_dept_desc" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning text-white">Update Department</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Branch Modal -->
<div class="modal fade" id="addBranchModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus me-2"></i>Add Branch</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('Setup/add_branch') ?>" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Branch Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="branch_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Branch Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="branch_code" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" name="address" rows="2"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">City</label>
                            <input type="text" class="form-control" name="city">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">State/Province</label>
                            <input type="text" class="form-control" name="state">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Country</label>
                            <input type="text" class="form-control" name="country">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Postal Code</label>
                            <input type="text" class="form-control" name="postal_code">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" name="phone">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Manager</label>
                            <input type="text" class="form-control" name="manager">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-modern">Add Branch</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Branch Modal -->
<div class="modal fade" id="editBranchModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Branch</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('Setup/update_branch') ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="branch_id" id="edit_branch_id">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Branch Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="branch_name" id="edit_branch_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Branch Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="branch_code" id="edit_branch_code" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" name="address" id="edit_branch_address" rows="2"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">City</label>
                            <input type="text" class="form-control" name="city" id="edit_branch_city">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">State/Province</label>
                            <input type="text" class="form-control" name="state" id="edit_branch_state">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Country</label>
                            <input type="text" class="form-control" name="country" id="edit_branch_country">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Postal Code</label>
                            <input type="text" class="form-control" name="postal_code" id="edit_branch_postal">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" name="phone" id="edit_branch_phone">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="edit_branch_email">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Manager</label>
                            <input type="text" class="form-control" name="manager" id="edit_branch_manager">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning text-white">Update Branch</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Department functions
function editDepartment(dept) {
    document.getElementById('edit_dept_id').value = dept.id;
    document.getElementById('edit_dept_name').value = dept.department_name;
    document.getElementById('edit_dept_head').value = dept.department_head;
    document.getElementById('edit_dept_desc').value = dept.description;
    
    const modal = new bootstrap.Modal(document.getElementById('editDepartmentModal'));
    modal.show();
}

function deleteDepartment(id, name) {
    if(typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Delete Department?',
            text: `Are you sure you want to delete "${name}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74a3b',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= base_url('Setup/delete_department/') ?>' + id;
            }
        });
    } else {
        if(confirm(`Are you sure you want to delete "${name}"?`)) {
            window.location.href = '<?= base_url('Setup/delete_department/') ?>' + id;
        }
    }
}

// Branch functions
function editBranch(branch) {
    document.getElementById('edit_branch_id').value = branch.id;
    document.getElementById('edit_branch_name').value = branch.branch_name;
    document.getElementById('edit_branch_code').value = branch.branch_code;
    document.getElementById('edit_branch_address').value = branch.address;
    document.getElementById('edit_branch_city').value = branch.city;
    document.getElementById('edit_branch_state').value = branch.state;
    document.getElementById('edit_branch_country').value = branch.country;
    document.getElementById('edit_branch_postal').value = branch.postal_code;
    document.getElementById('edit_branch_phone').value = branch.phone;
    document.getElementById('edit_branch_email').value = branch.email;
    document.getElementById('edit_branch_manager').value = branch.manager;
    
    const modal = new bootstrap.Modal(document.getElementById('editBranchModal'));
    modal.show();
}

function deleteBranch(id, name) {
    if(typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Delete Branch?',
            text: `Are you sure you want to delete "${name}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74a3b',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= base_url('Setup/delete_branch/') ?>' + id;
            }
        });
    } else {
        if(confirm(`Are you sure you want to delete "${name}"?`)) {
            window.location.href = '<?= base_url('Setup/delete_branch/') ?>' + id;
        }
    }
}

// Handle hash navigation for tabs
window.addEventListener('load', function() {
    const hash = window.location.hash;
    if(hash === '#departments') {
        document.getElementById('departments-tab').click();
    } else if(hash === '#branches') {
        document.getElementById('branches-tab').click();
    }
});
</script>

<?php
$this->load->view('templates/admin_footer');
?>
