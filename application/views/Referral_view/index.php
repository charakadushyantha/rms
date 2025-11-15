<?php $this->load->view('templates/admin_header'); ?>

<div class="content-area">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Referral Program Dashboard</h1>
                <p class="text-muted">Track and manage employee referrals</p>
            </div>
            <div>
                <a href="<?= base_url('Referral/submit') ?>" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Submit Referral
                </a>
                <a href="<?= base_url('Referral/my_referrals') ?>" class="btn btn-info">
                    <i class="fas fa-list"></i> My Referrals
                </a>
            </div>
        </div>

        <!-- Flash Messages -->
        <?php if($this->session->flashdata('success_msg')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle"></i> <?= $this->session->flashdata('success_msg') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- My Referral Code -->
        <div class="card mb-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body text-white">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h5 class="mb-2"><i class="fas fa-gift"></i> Your Referral Code</h5>
                        <h2 class="mb-2"><?= $my_referral_code ?></h2>
                        <p class="mb-0">Share this code with candidates. Earn $<?= number_format($config['default_bonus_amount'] ?? 1000) ?> for each successful hire!</p>
                    </div>
                    <div class="col-md-4 text-end">
                        <button class="btn btn-light btn-lg" onclick="copyReferralCode()">
                            <i class="fas fa-copy"></i> Copy Code
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-white-75 small">My Referrals</div>
                                <div class="text-lg font-weight-bold"><?= $user_stats['total'] ?></div>
                            </div>
                            <div class="fa-3x text-white-25">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-white-75 small">Hired</div>
                                <div class="text-lg font-weight-bold"><?= $user_stats['hired'] ?></div>
                            </div>
                            <div class="fa-3x text-white-25">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-white-75 small">In Progress</div>
                                <div class="text-lg font-weight-bold"><?= $user_stats['screening'] + $user_stats['interviewing'] ?></div>
                            </div>
                            <div class="fa-3x text-white-25">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-info text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-white-75 small">Bonuses Earned</div>
                                <div class="text-lg font-weight-bold">$<?= number_format($user_stats['bonus_paid']) ?></div>
                            </div>
                            <div class="fa-3x text-white-25">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Recent Referrals -->
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Recent Referrals</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Candidate</th>
                                        <th>Position</th>
                                        <th>Referred By</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($recent_referrals)): ?>
                                        <?php foreach (array_slice($recent_referrals, 0, 10) as $ref): ?>
                                            <tr>
                                                <td>
                                                    <strong><?= htmlspecialchars($ref->candidate_name) ?></strong><br>
                                                    <small class="text-muted"><?= htmlspecialchars($ref->candidate_email) ?></small>
                                                </td>
                                                <td><?= htmlspecialchars($ref->position_name ?? 'N/A') ?></td>
                                                <td><?= htmlspecialchars($ref->referrer_name) ?></td>
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
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                <p>No referrals yet. Start referring candidates!</p>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Referrers & Stats -->
            <div class="col-lg-4">
                <!-- Top Referrers -->
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-trophy text-warning"></i> Top Referrers</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($top_referrers)): ?>
                            <?php foreach ($top_referrers as $index => $referrer): ?>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="me-3">
                                        <div class="avatar-circle <?= $index == 0 ? 'bg-warning' : ($index == 1 ? 'bg-secondary' : 'bg-info') ?>">
                                            <?= $index + 1 ?>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <strong><?= htmlspecialchars($referrer->referrer_name) ?></strong><br>
                                        <small class="text-muted">
                                            <?= $referrer->hired_count ?> hired / <?= $referrer->total_referrals ?> total
                                        </small>
                                    </div>
                                    <div class="text-end">
                                        <strong class="text-success">$<?= number_format($referrer->total_bonuses) ?></strong>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted text-center">No data yet</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Program Stats -->
                <div class="card shadow">
                    <div class="card-header">
                        <h5 class="mb-0">Program Statistics</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Total Referrals</span>
                                <strong><?= $stats['total'] ?></strong>
                            </div>
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar bg-primary" style="width: 100%"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Conversion Rate</span>
                                <strong><?= $stats['conversion_rate'] ?>%</strong>
                            </div>
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar bg-success" style="width: <?= $stats['conversion_rate'] ?>%"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Total Bonuses Paid</span>
                                <strong>$<?= number_format($stats['bonus_paid']) ?></strong>
                            </div>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between mb-1">
                                <span>Pending Bonuses</span>
                                <strong>$<?= number_format($stats['bonus_pending']) ?></strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyReferralCode() {
    const code = '<?= $my_referral_code ?>';
    navigator.clipboard.writeText(code).then(() => {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'success',
                title: 'Copied!',
                text: 'Referral code copied to clipboard',
                timer: 2000,
                showConfirmButton: false
            });
        } else {
            alert('Referral code copied: ' + code);
        }
    });
}
</script>

<style>
.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
}

.text-lg {
    font-size: 2rem;
}

.text-white-25 {
    color: rgba(255, 255, 255, 0.25) !important;
}

.text-white-75 {
    color: rgba(255, 255, 255, 0.75) !important;
}

.fa-3x {
    font-size: 2.5em;
}
</style>

<?php $this->load->view('templates/admin_footer'); ?>
