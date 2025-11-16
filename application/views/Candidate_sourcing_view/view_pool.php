<?php $this->load->view('templates/admin_header'); ?>

<div class="content-area">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0"><?= htmlspecialchars($pool->pool_name) ?></h1>
                <p class="text-muted">
                    <span class="badge bg-<?= $pool->pool_type == 'Dynamic' ? 'info' : 'secondary' ?>">
                        <?= htmlspecialchars($pool->pool_type) ?>
                    </span>
                    <?= htmlspecialchars($pool->description) ?>
                </p>
            </div>
            <div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCandidateModal">
                    <i class="fas fa-user-plus"></i> Add Candidates
                </button>
                <a href="<?= base_url('Candidate_sourcing/pools') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Pools
                </a>
            </div>
        </div>

        <!-- Pool Statistics -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h6 class="text-white-75">Total Members</h6>
                        <h2><?= count($members) ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h6 class="text-white-75">Active</h6>
                        <h2><?= count(array_filter($members, function($m) { return $m->status == 'Active'; })) ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h6 class="text-white-75">In Pipeline</h6>
                        <h2><?= count(array_filter($members, function($m) { return $m->status == 'In Pipeline'; })) ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h6 class="text-white-75">Avg Experience</h6>
                        <h2>
                            <?php 
                            $avg_exp = count($members) > 0 
                                ? round(array_sum(array_column($members, 'total_experience')) / count($members), 1) 
                                : 0;
                            echo $avg_exp;
                            ?> yrs
                        </h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pool Members -->
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">Pool Members (<?= count($members) ?>)</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($members)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover" id="poolMembersTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Current Role</th>
                                    <th>Location</th>
                                    <th>Experience</th>
                                    <th>Status</th>
                                    <th>Added</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($members as $member): ?>
                                    <tr>
                                        <td>
                                            <strong><?= htmlspecialchars($member->first_name . ' ' . $member->last_name) ?></strong><br>
                                            <small class="text-muted"><?= htmlspecialchars($member->email) ?></small>
                                        </td>
                                        <td>
                                            <?= htmlspecialchars($member->current_title ?? 'N/A') ?><br>
                                            <small class="text-muted"><?= htmlspecialchars($member->current_company ?? '') ?></small>
                                        </td>
                                        <td><?= htmlspecialchars($member->location ?? 'N/A') ?></td>
                                        <td><?= $member->total_experience ?? 0 ?> years</td>
                                        <td>
                                            <?php
                                            $status_colors = [
                                                'New' => 'secondary',
                                                'Active' => 'success',
                                                'In Pipeline' => 'warning',
                                                'Contacted' => 'info',
                                                'Not Interested' => 'danger'
                                            ];
                                            $color = $status_colors[$member->status] ?? 'secondary';
                                            ?>
                                            <span class="badge bg-<?= $color ?>"><?= htmlspecialchars($member->status) ?></span>
                                        </td>
                                        <td><?= date('M d, Y', strtotime($member->added_at)) ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="<?= base_url('Candidate_sourcing/view/' . $member->candidate_id) ?>" 
                                                   class="btn btn-sm btn-outline-primary" title="View Profile">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button class="btn btn-sm btn-outline-danger" 
                                                        onclick="removeFromPool(<?= $member->candidate_id ?>)" title="Remove from Pool">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <h5>No Candidates in Pool</h5>
                        <p class="text-muted">Add candidates to this pool to get started</p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCandidateModal">
                            <i class="fas fa-user-plus"></i> Add Candidates
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Add Candidate Modal -->
<div class="modal fade" id="addCandidateModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Candidates to Pool</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted">Search and select candidates to add to this pool</p>
                <div class="mb-3">
                    <input type="text" class="form-control" id="candidateSearch" 
                           placeholder="Search candidates by name, email, or title...">
                </div>
                <div id="candidateList" style="max-height: 400px; overflow-y: auto;">
                    <p class="text-center text-muted">Use search to find candidates</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    if ($.fn.DataTable && $('#poolMembersTable tbody tr').length > 0) {
        $('#poolMembersTable').DataTable({
            "pageLength": 25,
            "order": [[ 5, "desc" ]],
            "columnDefs": [
                { "orderable": false, "targets": 6 }
            ]
        });
    }

    // Candidate search
    $('#candidateSearch').on('keyup', function() {
        const query = $(this).val();
        if (query.length >= 2) {
            $.ajax({
                url: '<?= base_url("Candidate_sourcing/search_candidates") ?>',
                method: 'GET',
                data: { q: query, pool_id: <?= $pool->pool_id ?> },
                success: function(response) {
                    $('#candidateList').html(response);
                }
            });
        }
    });
});

function addToPool(candidateId) {
    $.ajax({
        url: '<?= base_url("Candidate_sourcing/add_to_pool") ?>',
        method: 'POST',
        data: {
            pool_id: <?= $pool->pool_id ?>,
            candidate_id: candidateId
        },
        success: function(response) {
            if (response.success) {
                location.reload();
            } else {
                alert(response.message || 'Failed to add candidate');
            }
        },
        dataType: 'json'
    });
}

function removeFromPool(candidateId) {
    if (confirm('Remove this candidate from the pool?')) {
        $.ajax({
            url: '<?= base_url("Candidate_sourcing/remove_from_pool") ?>',
            method: 'POST',
            data: {
                pool_id: <?= $pool->pool_id ?>,
                candidate_id: candidateId
            },
            success: function(response) {
                location.reload();
            }
        });
    }
}
</script>

<style>
.text-white-75 {
    color: rgba(255, 255, 255, 0.75) !important;
}
</style>

<?php $this->load->view('templates/admin_footer'); ?>
