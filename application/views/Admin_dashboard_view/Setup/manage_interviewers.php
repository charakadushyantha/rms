<?php
$this->load->view('templates/admin_header', array('page_title' => 'Manage Interviewers'));
?>

<div class="data-card">
    <div class="data-card-header">
        <h3 class="data-card-title">
            <i class="fas fa-user-tie me-2"></i>Manage Interviewers
        </h3>
        <a href="<?= base_url('Setup/manage_users') ?>" class="btn btn-primary-modern btn-modern">
            <i class="fas fa-user-plus me-2"></i>Add New User
        </a>
    </div>
    
    <p class="px-3 text-muted">
        <i class="fas fa-info-circle me-2"></i>
        Users with Admin, Recruiter, or Interviewer roles can conduct interviews. Manage their accounts to control interviewer access.
    </p>
    
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Interviews Conducted</th>
                    <th>Joined Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($interviewers)): ?>
                    <?php foreach($interviewers as $interviewer): ?>
                    <tr>
                        <td><?= $interviewer->u_id ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-2" style="width: 35px; height: 35px; font-size: 14px;">
                                    <?= strtoupper(substr($interviewer->u_username, 0, 1)) ?>
                                </div>
                                <strong><?= htmlspecialchars($interviewer->u_username) ?></strong>
                            </div>
                        </td>
                        <td><?= htmlspecialchars($interviewer->u_email) ?></td>
                        <td>
                            <?php
                            $badge_color = 'secondary';
                            switch($interviewer->u_role) {
                                case 'Admin': $badge_color = 'danger'; break;
                                case 'Recruiter': $badge_color = 'primary'; break;
                                case 'Interviewer': $badge_color = 'warning'; break;
                            }
                            ?>
                            <span class="badge bg-<?= $badge_color ?>">
                                <?= $interviewer->u_role ?>
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-success">
                                <?= $interviewer->interview_count ?> Interviews
                            </span>
                        </td>
                        <td><?= date('M d, Y', strtotime($interviewer->u_created_at)) ?></td>
                        <td>
                            <span class="badge bg-success">
                                <i class="fas fa-check-circle"></i> Active
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="fas fa-user-tie fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No interviewers found. Add users with Admin or Recruiter roles.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6 col-lg-3">
        <div class="stat-card danger">
            <div class="stat-card-header">
                <span class="stat-card-title">Total Interviewers</span>
                <div class="stat-card-icon" style="background: var(--danger-color);">
                    <i class="fas fa-user-tie"></i>
                </div>
            </div>
            <div class="stat-card-value"><?= count($interviewers) ?></div>
            <div class="stat-card-footer">Available interviewers</div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card success">
            <div class="stat-card-header">
                <span class="stat-card-title">Total Interviews</span>
                <div class="stat-card-icon" style="background: var(--success-color);">
                    <i class="fas fa-calendar-check"></i>
                </div>
            </div>
            <div class="stat-card-value"><?= array_sum(array_column($interviewers, 'interview_count')) ?></div>
            <div class="stat-card-footer">Interviews conducted</div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card info">
            <div class="stat-card-header">
                <span class="stat-card-title">Admins</span>
                <div class="stat-card-icon" style="background: var(--info-color);">
                    <i class="fas fa-user-shield"></i>
                </div>
            </div>
            <div class="stat-card-value">
                <?= count(array_filter($interviewers, function($i) { return $i->u_role == 'Admin'; })) ?>
            </div>
            <div class="stat-card-footer">Admin interviewers</div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card" style="border-left-color: #667eea;">
            <div class="stat-card-header">
                <span class="stat-card-title">Recruiters</span>
                <div class="stat-card-icon" style="background: #667eea;">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="stat-card-value">
                <?= count(array_filter($interviewers, function($i) { return $i->u_role == 'Recruiter'; })) ?>
            </div>
            <div class="stat-card-footer">Recruiter interviewers</div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card warning">
            <div class="stat-card-header">
                <span class="stat-card-title">Interviewers</span>
                <div class="stat-card-icon" style="background: var(--warning-color);">
                    <i class="fas fa-user-tie"></i>
                </div>
            </div>
            <div class="stat-card-value">
                <?= count(array_filter($interviewers, function($i) { return $i->u_role == 'Interviewer'; })) ?>
            </div>
            <div class="stat-card-footer">Dedicated interviewers</div>
        </div>
    </div>
</div>

<?php
$this->load->view('templates/admin_footer');
?>
