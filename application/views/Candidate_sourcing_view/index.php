<?php $this->load->view('templates/admin_header'); ?>

<div class="content-area">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Candidate Sourcing</h1>
                <p class="text-muted">Search and manage your talent database</p>
            </div>
            <div>
                <a href="<?= base_url('Candidate_sourcing/add') ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Candidate
                </a>
                <a href="<?= base_url('Candidate_sourcing/pools') ?>" class="btn btn-info">
                    <i class="fas fa-layer-group"></i> Talent Pools
                </a>
                <a href="<?= base_url('Candidate_sourcing/analytics') ?>" class="btn btn-success">
                    <i class="fas fa-chart-bar"></i> Analytics
                </a>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h6 class="text-white-75">Total Candidates</h6>
                        <h2><?= $stats['total_candidates'] ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h6 class="text-white-75">Active</h6>
                        <h2><?= count(array_filter($stats['by_status'], function($s) { return isset($s['status']) && $s['status'] == 'Active'; })) ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h6 class="text-white-75">In Pipeline</h6>
                        <h2><?= count(array_filter($stats['by_status'], function($s) { return isset($s['status']) && $s['status'] == 'In Pipeline'; })) ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h6 class="text-white-75">Talent Pools</h6>
                        <h2><?= count($pools) ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Filters -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-search"></i> Search Candidates</h5>
            </div>
            <div class="card-body">
                <form method="get" action="<?= base_url('Candidate_sourcing') ?>">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Keywords</label>
                            <input type="text" class="form-control" name="search" 
                                   placeholder="Name, title, company..." 
                                   value="<?= $this->input->get('search') ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Skills</label>
                            <input type="text" class="form-control" name="skills" 
                                   placeholder="PHP, Java, Python..." 
                                   value="<?= $this->input->get('skills') ?>">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Location</label>
                            <input type="text" class="form-control" name="location" 
                                   placeholder="City, State" 
                                   value="<?= $this->input->get('location') ?>">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Experience</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="exp_min" 
                                       placeholder="Min" value="<?= $this->input->get('exp_min') ?>">
                                <span class="input-group-text">-</span>
                                <input type="number" class="form-control" name="exp_max" 
                                       placeholder="Max" value="<?= $this->input->get('exp_max') ?>">
                            </div>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <select class="form-select" name="status">
                                <option value="">All Status</option>
                                <option value="New">New</option>
                                <option value="Active">Active</option>
                                <option value="In Pipeline">In Pipeline</option>
                                <option value="Contacted">Contacted</option>
                                <option value="Not Interested">Not Interested</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" name="source">
                                <option value="">All Sources</option>
                                <?php foreach ($sources as $source): ?>
                                    <option value="<?= $source->source_name ?>"><?= $source->source_name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Candidates Table -->
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">Candidates (<?= count($candidates) ?>)</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="candidatesTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Current Role</th>
                                <th>Location</th>
                                <th>Experience</th>
                                <th>Skills</th>
                                <th>Source</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($candidates)): ?>
                                <?php foreach ($candidates as $candidate): ?>
                                    <tr>
                                        <td>
                                            <strong><?= htmlspecialchars(($candidate['first_name']??'') . ' ' . ($candidate['last_name']??'')) ?></strong><br>
                                            <small class="text-muted"><?= htmlspecialchars($candidate['email']??'') ?></small>
                                        </td>
                                        <td>
                                            <?= htmlspecialchars($candidate['current_title'] ?? 'N/A') ?><br>
                                            <small class="text-muted"><?= htmlspecialchars($candidate['current_company'] ?? '') ?></small>
                                        </td>
                                        <td><?= htmlspecialchars($candidate['location'] ?? 'N/A') ?></td>
                                        <td><?= $candidate['total_experience'] ?? 0 ?> years</td>
                                        <td>
                                            <span class="badge bg-secondary"><?= $candidate['skill_count']??0 ?> skills</span>
                                        </td>
                                        <td><span class="badge bg-info"><?= htmlspecialchars($candidate['source']??'N/A') ?></span></td>
                                        <td>
                                            <?php
                                            $status_colors = [
                                                'New' => 'secondary',
                                                'Active' => 'success',
                                                'In Pipeline' => 'warning',
                                                'Contacted' => 'info',
                                                'Not Interested' => 'danger'
                                            ];
                                            $color = $status_colors[$candidate['status']??'New'] ?? 'secondary';
                                            ?>
                                            <span class="badge bg-<?= $color ?>"><?= htmlspecialchars($candidate['status']??'New') ?></span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="<?= base_url('Candidate_sourcing/view/' . ($candidate['candidate_id']??'')) ?>" 
                                                   class="btn btn-sm btn-outline-primary" title="View Profile">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button class="btn btn-sm btn-outline-danger" 
                                                        onclick="deleteCandidate(<?= $candidate['candidate_id']??0 ?>)" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                        <h5>No Candidates Found</h5>
                                        <p class="text-muted">Start building your talent database!</p>
                                        <a href="<?= base_url('Candidate_sourcing/add') ?>" class="btn btn-primary">
                                            <i class="fas fa-plus"></i> Add First Candidate
                                        </a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    if ($.fn.DataTable && $('#candidatesTable tbody tr').length > 1) {
        $('#candidatesTable').DataTable({
            "pageLength": 25,
            "order": [[ 0, "asc" ]],
            "columnDefs": [
                { "orderable": false, "targets": 7 }
            ]
        });
    }
});

function deleteCandidate(id) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Are you sure?',
            text: "This will permanently delete the candidate!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= base_url("Candidate_sourcing/delete/") ?>' + id;
            }
        });
    } else {
        if (confirm('Are you sure you want to delete this candidate?')) {
            window.location.href = '<?= base_url("Candidate_sourcing/delete/") ?>' + id;
        }
    }
}
</script>

<style>
.text-white-75 {
    color: rgba(255, 255, 255, 0.75) !important;
}
</style>

<?php $this->load->view('templates/admin_footer'); ?>
