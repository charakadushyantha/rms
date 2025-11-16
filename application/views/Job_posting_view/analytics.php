<?php $this->load->view('templates/admin_header'); ?>

<div class="content-area">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Job Posting Analytics</h1>
                <p class="text-muted">Track performance across all platforms</p>
            </div>
            <a href="<?= base_url('Job_posting') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Jobs
            </a>
        </div>

        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Posts</h5>
                        <h2><?= $total_posts ?? 0 ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-info mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Views</h5>
                        <h2><?= number_format($total_views ?? 0) ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Clicks</h5>
                        <h2><?= number_format($total_clicks ?? 0) ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Applications</h5>
                        <h2><?= number_format($total_applications ?? 0) ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Platform Performance -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-bar"></i> Platform Performance</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($analytics['platform_performance'])): ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Platform</th>
                                    <th>Total Posts</th>
                                    <th>Views</th>
                                    <th>Clicks</th>
                                    <th>Applications</th>
                                    <th>Conversion Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($analytics['platform_performance'] as $platform): ?>
                                    <?php 
                                    $conversion = $platform->total_clicks > 0 
                                        ? round(($platform->total_applications / $platform->total_clicks) * 100, 2) 
                                        : 0;
                                    ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($platform->platform_name) ?></strong></td>
                                        <td><?= number_format($platform->total_posts ?? 0) ?></td>
                                        <td><?= number_format($platform->total_views ?? 0) ?></td>
                                        <td><?= number_format($platform->total_clicks ?? 0) ?></td>
                                        <td><?= number_format($platform->total_applications ?? 0) ?></td>
                                        <td>
                                            <span class="badge bg-<?= $conversion > 5 ? 'success' : ($conversion > 2 ? 'warning' : 'secondary') ?>">
                                                <?= $conversion ?>%
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-chart-bar fa-3x mb-3"></i>
                        <p>No platform data available yet</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-history"></i> Recent Activity</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($analytics['recent_activity'])): ?>
                    <div class="list-group">
                        <?php foreach ($analytics['recent_activity'] as $activity): ?>
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1"><?= htmlspecialchars($activity->jp_title) ?></h6>
                                    <small><?= date('M d, Y', strtotime($activity->posted_at)) ?></small>
                                </div>
                                <p class="mb-1">
                                    <span class="badge bg-primary"><?= htmlspecialchars($activity->platform_name) ?></span>
                                    <span class="badge bg-<?= $activity->status == 'Posted' ? 'success' : 'warning' ?>">
                                        <?= htmlspecialchars($activity->status) ?>
                                    </span>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-history fa-3x mb-3"></i>
                        <p>No recent activity</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}

.card-header {
    background-color: #f8f9fc;
    border-bottom: 1px solid #e3e6f0;
}
</style>

<?php $this->load->view('templates/admin_footer'); ?>
