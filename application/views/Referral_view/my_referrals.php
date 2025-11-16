<?php $this->load->view('templates/admin_header'); ?>

<div class="content-area">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">My Referrals</h1>
                <p class="text-muted">Track the status of your referrals</p>
            </div>
            <div>
                <a href="<?= base_url('Referral/submit') ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> New Referral
                </a>
                <a href="<?= base_url('Referral') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Dashboard
                </a>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h6 class="text-white-75">Total Referrals</h6>
                        <h2><?= $stats['total'] ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h6 class="text-white-75">Hired</h6>
                        <h2><?= $stats['hired'] ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h6 class="text-white-75">In Progress</h6>
                        <h2><?= $stats['screening'] + $stats['interviewing'] ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h6 class="text-white-75">Bonuses Earned</h6>
                        <h2>$<?= number_format($stats['bonus_paid']) ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Referrals Table -->
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">All My Referrals</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="referralsTable">
                        <thead>
                            <tr>
                                <th>Ref Code</th>
                                <th>Candidate</th>
                                <th>Position</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Bonus</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($referrals)): ?>
                                <?php foreach ($referrals as $ref): ?>
                                    <tr>
                                        <td>
                                            <code><?= htmlspecialchars($ref->referral_code) ?></code>
                                        </td>
                                        <td>
                                            <strong><?= htmlspecialchars($ref->candidate_name) ?></strong><br>
                                            <small class="text-muted"><?= htmlspecialchars($ref->candidate_email) ?></small>
                                        </td>
                                        <td><?= htmlspecialchars($ref->position_name ?? 'N/A') ?></td>
                                        <td><?= date('M d, Y', strtotime($ref->referral_date)) ?></td>
                                        <td>
                                            <?php
                                            $badge_class = [
                                                'Submitted' => 'bg-secondary',
                                                'Screening' => 'bg-info',
                                                'Interviewing' => 'bg-warning',
                                                'Hired' => 'bg-success',
                                                'Rejected' => 'bg-danger'
                                            ];
                                            ?>
                                            <span class="badge <?= $badge_class[$ref->referral_status] ?? 'bg-secondary' ?>">
                                                <?= htmlspecialchars($ref->referral_status) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($ref->bonus_amount > 0): ?>
                                                <strong>$<?= number_format($ref->bonus_amount) ?></strong><br>
                                                <small class="badge <?= $ref->bonus_status == 'Paid' ? 'bg-success' : ($ref->bonus_status == 'Approved' ? 'bg-info' : 'bg-secondary') ?>">
                                                    <?= htmlspecialchars($ref->bonus_status) ?>
                                                </small>
                                            <?php else: ?>
                                                <span class="text-muted">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('Referral/view/' . $ref->referral_id) ?>" 
                                               class="btn btn-sm btn-outline-primary" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <h5>No Referrals Yet</h5>
                                        <p class="text-muted">Start referring candidates to earn bonuses!</p>
                                        <a href="<?= base_url('Referral/submit') ?>" class="btn btn-primary">
                                            <i class="fas fa-plus"></i> Submit Your First Referral
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
    if ($.fn.DataTable) {
        $('#referralsTable').DataTable({
            "pageLength": 25,
            "order": [[ 3, "desc" ]],
            "columnDefs": [
                { "orderable": false, "targets": 6 }
            ]
        });
    }
});
</script>

<style>
.text-white-75 {
    color: rgba(255, 255, 255, 0.75) !important;
}
</style>

<?php $this->load->view('templates/admin_footer'); ?>
