<?php
$this->load->view('templates/admin_header', array('page_title' => 'Job Positions'));
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
            <i class="fas fa-briefcase me-2"></i>Job Positions
        </h3>
        <button class="btn btn-primary-modern btn-modern" data-bs-toggle="modal" data-bs-target="#addPositionModal">
            <i class="fas fa-plus me-2"></i>Add Position
        </button>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Position Name</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($positions)): ?>
                    <?php foreach($positions as $position): ?>
                    <tr>
                        <td><?= $position->id ?></td>
                        <td><strong><?= htmlspecialchars($position->position_name) ?></strong></td>
                        <td>
                            <?php if($position->category_name): ?>
                                <span class="badge bg-primary"><?= htmlspecialchars($position->category_name) ?></span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Uncategorized</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($position->description) ?></td>
                        <td><?= date('M d, Y', strtotime($position->created_at)) ?></td>
                        <td>
                            <button class="btn btn-sm btn-warning" onclick="editPosition(<?= htmlspecialchars(json_encode($position)) ?>)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="deletePosition(<?= $position->id ?>, '<?= htmlspecialchars($position->position_name) ?>')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <i class="fas fa-briefcase fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No job positions found. Add your first position.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Position Modal -->
<div class="modal fade" id="addPositionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus me-2"></i>Add Job Position</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('Setup/add_job_position') ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Position Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="position_name" required placeholder="e.g., Software Engineer">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category <span class="text-danger">*</span></label>
                        <select class="form-select" name="category_id" required>
                            <option value="">Select Category</option>
                            <?php foreach($categories as $category): ?>
                                <option value="<?= $category->id ?>"><?= htmlspecialchars($category->category_name) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3" placeholder="Brief description of this position..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-modern">Add Position</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Position Modal -->
<div class="modal fade" id="editPositionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Job Position</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('Setup/update_job_position') ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="position_id" id="edit_position_id">
                    <div class="mb-3">
                        <label class="form-label">Position Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="position_name" id="edit_position_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category <span class="text-danger">*</span></label>
                        <select class="form-select" name="category_id" id="edit_position_category" required>
                            <option value="">Select Category</option>
                            <?php foreach($categories as $category): ?>
                                <option value="<?= $category->id ?>"><?= htmlspecialchars($category->category_name) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="edit_position_desc" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning text-white">Update Position</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editPosition(position) {
    document.getElementById('edit_position_id').value = position.id;
    document.getElementById('edit_position_name').value = position.position_name;
    document.getElementById('edit_position_category').value = position.category_id;
    document.getElementById('edit_position_desc').value = position.description;
    
    const modal = new bootstrap.Modal(document.getElementById('editPositionModal'));
    modal.show();
}

function deletePosition(id, name) {
    if(typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Delete Position?',
            text: `Are you sure you want to delete "${name}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74a3b',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= base_url('Setup/delete_job_position/') ?>' + id;
            }
        });
    } else {
        if(confirm(`Are you sure you want to delete "${name}"?`)) {
            window.location.href = '<?= base_url('Setup/delete_job_position/') ?>' + id;
        }
    }
}
</script>

<?php
$this->load->view('templates/admin_footer');
?>
