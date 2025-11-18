<?php $this->load->view('templates/admin_header'); ?>

<div class="content-area">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Talent Pools</h1>
                <p class="text-muted">Organize candidates into talent pools</p>
            </div>
            <div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPoolModal">
                    <i class="fas fa-plus"></i> Create Pool
                </button>
                <a href="<?= base_url('Candidate_sourcing') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <!-- Pools Grid -->
        <div class="row">
            <?php if (!empty($pools)): ?>
                <?php foreach ($pools as $pool): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card shadow-sm h-100 pool-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h5 class="card-title mb-1"><?= htmlspecialchars($pool['pool_name']??'Unnamed Pool') ?></h5>
                                        <span class="badge bg-<?= ($pool['pool_type']??'Static') == 'Dynamic' ? 'info' : 'secondary' ?>">
                                            <?= htmlspecialchars($pool['pool_type']??'Static') ?>
                                        </span>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="<?= base_url('Candidate_sourcing/view_pool/' . ($pool['pool_id']??'')) ?>">
                                                <i class="fas fa-eye"></i> View Pool
                                            </a></li>
                                            <li><a class="dropdown-item" href="#" onclick="editPool(<?= $pool['pool_id']??0 ?>)">
                                                <i class="fas fa-edit"></i> Edit
                                            </a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="#" onclick="deletePool(<?= $pool['pool_id']??0 ?>)">
                                                <i class="fas fa-trash"></i> Delete
                                            </a></li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <p class="card-text text-muted small">
                                    <?= htmlspecialchars($pool['description'] ?? 'No description') ?>
                                </p>
                                
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div>
                                        <i class="fas fa-users text-primary"></i>
                                        <strong><?= $pool['member_count']??0 ?></strong> candidates
                                    </div>
                                    <a href="<?= base_url('Candidate_sourcing/view_pool/' . ($pool['pool_id']??'')) ?>" 
                                       class="btn btn-sm btn-outline-primary">
                                        View Pool <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                                
                                <div class="mt-3 pt-3 border-top">
                                    <small class="text-muted">
                                        <i class="fas fa-user"></i> Created by <?= htmlspecialchars($pool['created_by']??'Unknown') ?>
                                        <br>
                                        <i class="fas fa-clock"></i> <?= date('M d, Y', strtotime($pool['created_at']??date('Y-m-d'))) ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-layer-group fa-4x text-muted mb-3"></i>
                            <h4>No Talent Pools Yet</h4>
                            <p class="text-muted">Create your first talent pool to organize candidates</p>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPoolModal">
                                <i class="fas fa-plus"></i> Create First Pool
                            </button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Create Pool Modal -->
<div class="modal fade" id="createPoolModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Talent Pool</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('Candidate_sourcing/create_pool') ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pool Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="pool_name" required 
                               placeholder="e.g., Senior Developers, Marketing Specialists">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3" 
                                  placeholder="Brief description of this talent pool..."></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Pool Type</label>
                        <select class="form-select" name="pool_type">
                            <option value="Static">Static - Manually add candidates</option>
                            <option value="Dynamic">Dynamic - Auto-update based on criteria</option>
                        </select>
                        <small class="form-text text-muted">
                            Dynamic pools automatically update based on search criteria (coming soon)
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Create Pool
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.pool-card {
    transition: transform 0.2s, box-shadow 0.2s;
}

.pool-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15) !important;
}
</style>

<script>
function deletePool(poolId) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Delete Talent Pool?',
            text: "This will remove all candidates from this pool!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= base_url("Candidate_sourcing/delete_pool/") ?>' + poolId;
            }
        });
    } else {
        if (confirm('Are you sure you want to delete this pool?')) {
            window.location.href = '<?= base_url("Candidate_sourcing/delete_pool/") ?>' + poolId;
        }
    }
}
</script>

<?php $this->load->view('templates/admin_footer'); ?>