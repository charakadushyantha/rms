<?php
$this->load->view('templates/admin_header', array('page_title' => 'Manage Recruiters'));
?>

<div class="data-card">
    <div class="data-card-header">
        <h3 class="data-card-title">
            <i class="fas fa-users me-2"></i>Manage Recruiters
        </h3>
        <a href="<?= base_url('Setup/manage_users') ?>" class="btn btn-primary-modern btn-modern">
            <i class="fas fa-user-plus me-2"></i>Add New Recruiter
        </a>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Candidates</th>
                    <th>Joined Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($recruiters)): ?>
                    <?php foreach($recruiters as $recruiter): ?>
                    <tr>
                        <td><?= $recruiter->u_id ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-2" style="width: 35px; height: 35px; font-size: 14px;">
                                    <?= strtoupper(substr($recruiter->u_username, 0, 1)) ?>
                                </div>
                                <strong><?= htmlspecialchars($recruiter->u_username) ?></strong>
                            </div>
                        </td>
                        <td><?= htmlspecialchars($recruiter->u_email) ?></td>
                        <td>
                            <span class="badge bg-info">
                                <?= $recruiter->candidate_count ?> Candidates
                            </span>
                        </td>
                        <td><?= date('M d, Y', strtotime($recruiter->u_created_at)) ?></td>
                        <td>
                            <a href="<?= base_url('A_dashboard/Arecruiter_view') ?>" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i> View Details
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No recruiters found. Add a new user with "Recruiter" role.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-4">
        <div class="stat-card info">
            <div class="stat-card-header">
                <span class="stat-card-title">Total Recruiters</span>
                <div class="stat-card-icon" style="background: var(--info-color);">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="stat-card-value"><?= count($recruiters) ?></div>
            <div class="stat-card-footer">Active recruiter accounts</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card success">
            <div class="stat-card-header">
                <span class="stat-card-title">Total Candidates</span>
                <div class="stat-card-icon" style="background: var(--success-color);">
                    <i class="fas fa-user-check"></i>
                </div>
            </div>
            <div class="stat-card-value"><?= array_sum(array_column($recruiters, 'candidate_count')) ?></div>
            <div class="stat-card-footer">Managed by all recruiters</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card warning">
            <div class="stat-card-header">
                <span class="stat-card-title">Avg per Recruiter</span>
                <div class="stat-card-icon" style="background: var(--warning-color);">
                    <i class="fas fa-chart-bar"></i>
                </div>
            </div>
            <div class="stat-card-value">
                <?= count($recruiters) > 0 ? round(array_sum(array_column($recruiters, 'candidate_count')) / count($recruiters), 1) : 0 ?>
            </div>
            <div class="stat-card-footer">Average candidates per recruiter</div>
        </div>
    </div>
</div>

<?php
$this->load->view('templates/admin_footer');
?>
