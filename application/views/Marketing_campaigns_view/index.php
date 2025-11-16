<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f7fa; }
        .container { max-width: 1400px; margin: 0 auto; padding: 20px; }
        .header { background: white; padding: 25px; border-radius: 10px; margin-bottom: 25px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; margin-bottom: 10px; }
        .header p { color: #7f8c8d; }
        
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 25px; }
        .stat-card { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .stat-card .icon { font-size: 32px; margin-bottom: 15px; }
        .stat-card .icon.blue { color: #3498db; }
        .stat-card .icon.green { color: #27ae60; }
        .stat-card .icon.orange { color: #e67e22; }
        .stat-card .icon.purple { color: #9b59b6; }
        .stat-card h3 { font-size: 32px; color: #2c3e50; margin-bottom: 5px; }
        .stat-card p { color: #7f8c8d; font-size: 14px; }
        
        .toolbar { background: white; padding: 20px; border-radius: 10px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .toolbar .filters { display: flex; gap: 10px; }
        .toolbar select { padding: 10px 15px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; }
        .btn { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; text-decoration: none; display: inline-block; }
        .btn-primary { background: #3498db; color: white; }
        .btn-primary:hover { background: #2980b9; }
        .btn-success { background: #27ae60; color: white; }
        .btn-danger { background: #e74c3c; color: white; }
        .btn-sm { padding: 6px 12px; font-size: 12px; }
        
        .campaigns-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 20px; }
        .campaign-card { background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: transform 0.2s; }
        .campaign-card:hover { transform: translateY(-5px); box-shadow: 0 4px 8px rgba(0,0,0,0.15); }
        .campaign-header { display: flex; justify-content: space-between; align-items: start; margin-bottom: 15px; }
        .campaign-header h3 { color: #2c3e50; font-size: 18px; }
        .status-badge { padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .status-badge.active { background: #d4edda; color: #155724; }
        .status-badge.draft { background: #fff3cd; color: #856404; }
        .status-badge.completed { background: #d1ecf1; color: #0c5460; }
        .status-badge.paused { background: #f8d7da; color: #721c24; }
        
        .campaign-type { display: inline-block; padding: 4px 10px; background: #ecf0f1; color: #34495e; border-radius: 4px; font-size: 12px; margin-bottom: 10px; }
        .campaign-meta { color: #7f8c8d; font-size: 13px; margin-bottom: 15px; }
        .campaign-meta i { margin-right: 5px; }
        .campaign-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin: 15px 0; padding: 15px 0; border-top: 1px solid #ecf0f1; border-bottom: 1px solid #ecf0f1; }
        .campaign-stat { text-align: center; }
        .campaign-stat .value { font-size: 20px; font-weight: 600; color: #2c3e50; }
        .campaign-stat .label { font-size: 11px; color: #7f8c8d; margin-top: 3px; }
        
        .campaign-actions { display: flex; gap: 8px; margin-top: 15px; }
        .empty-state { text-align: center; padding: 60px 20px; background: white; border-radius: 10px; }
        .empty-state i { font-size: 64px; color: #bdc3c7; margin-bottom: 20px; }
        .empty-state h3 { color: #7f8c8d; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-bullhorn"></i> Marketing Campaigns</h1>
            <p>Create and manage recruitment marketing campaigns across multiple channels</p>
        </div>

        <?php if($this->session->flashdata('success_msg')): ?>
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                <?php echo $this->session->flashdata('success_msg'); ?>
            </div>
        <?php endif; ?>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="icon blue"><i class="fas fa-bullhorn"></i></div>
                <h3><?php echo $stats['total_campaigns']; ?></h3>
                <p>Total Campaigns</p>
            </div>
            <div class="stat-card">
                <div class="icon green"><i class="fas fa-play-circle"></i></div>
                <h3><?php echo $stats['active_campaigns']; ?></h3>
                <p>Active Campaigns</p>
            </div>
            <div class="stat-card">
                <div class="icon orange"><i class="fas fa-dollar-sign"></i></div>
                <h3>$<?php echo number_format($stats['total_budget'], 0); ?></h3>
                <p>Total Budget</p>
            </div>
            <div class="stat-card">
                <div class="icon purple"><i class="fas fa-chart-line"></i></div>
                <h3><?php echo number_format($stats['total_reach'], 0); ?></h3>
                <p>Total Reach</p>
            </div>
        </div>

        <div class="toolbar">
            <div class="filters">
                <select id="statusFilter" onchange="filterCampaigns()">
                    <option value="">All Status</option>
                    <option value="Active">Active</option>
                    <option value="Draft">Draft</option>
                    <option value="Paused">Paused</option>
                    <option value="Completed">Completed</option>
                </select>
                <select id="typeFilter" onchange="filterCampaigns()">
                    <option value="">All Types</option>
                    <option value="Email">Email</option>
                    <option value="Social Media">Social Media</option>
                    <option value="Paid Ads">Paid Ads</option>
                    <option value="Multi-Channel">Multi-Channel</option>
                </select>
            </div>
            <div>
                <a href="<?php echo base_url('Marketing_campaigns/analytics'); ?>" class="btn btn-primary">
                    <i class="fas fa-chart-bar"></i> Analytics
                </a>
                <a href="<?php echo base_url('Marketing_campaigns/create'); ?>" class="btn btn-success">
                    <i class="fas fa-plus"></i> New Campaign
                </a>
            </div>
        </div>

        <?php if(empty($campaigns)): ?>
            <div class="empty-state">
                <i class="fas fa-bullhorn"></i>
                <h3>No campaigns yet</h3>
                <p>Create your first marketing campaign to start reaching candidates</p>
                <a href="<?php echo base_url('Marketing_campaigns/create'); ?>" class="btn btn-primary" style="margin-top: 20px;">
                    <i class="fas fa-plus"></i> Create Campaign
                </a>
            </div>
        <?php else: ?>
            <div class="campaigns-grid">
                <?php foreach($campaigns as $campaign): ?>
                    <div class="campaign-card">
                        <div class="campaign-header">
                            <h3><?php echo htmlspecialchars($campaign['campaign_name']); ?></h3>
                            <span class="status-badge <?php echo strtolower($campaign['status']); ?>">
                                <?php echo $campaign['status']; ?>
                            </span>
                        </div>
                        
                        <span class="campaign-type">
                            <i class="fas fa-tag"></i> <?php echo $campaign['campaign_type']; ?>
                        </span>
                        
                        <div class="campaign-meta">
                            <div><i class="fas fa-calendar"></i> <?php echo date('M d, Y', strtotime($campaign['start_date'])); ?> - <?php echo date('M d, Y', strtotime($campaign['end_date'])); ?></div>
                            <div><i class="fas fa-dollar-sign"></i> Budget: $<?php echo number_format($campaign['budget'], 2); ?></div>
                        </div>
                        
                        <div class="campaign-stats">
                            <div class="campaign-stat">
                                <div class="value"><?php echo number_format($campaign['total_reach'] ?? 0); ?></div>
                                <div class="label">Reach</div>
                            </div>
                            <div class="campaign-stat">
                                <div class="value"><?php echo number_format($campaign['total_clicks'] ?? 0); ?></div>
                                <div class="label">Clicks</div>
                            </div>
                            <div class="campaign-stat">
                                <div class="value"><?php echo number_format($campaign['total_applications'] ?? 0); ?></div>
                                <div class="label">Applications</div>
                            </div>
                        </div>
                        
                        <div class="campaign-actions">
                            <a href="<?php echo base_url('Marketing_campaigns/view/' . $campaign['campaign_id']); ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <?php if($campaign['status'] == 'Draft'): ?>
                                <button onclick="updateStatus(<?php echo $campaign['campaign_id']; ?>, 'Active')" class="btn btn-success btn-sm">
                                    <i class="fas fa-play"></i> Launch
                                </button>
                            <?php elseif($campaign['status'] == 'Active'): ?>
                                <button onclick="updateStatus(<?php echo $campaign['campaign_id']; ?>, 'Paused')" class="btn btn-danger btn-sm">
                                    <i class="fas fa-pause"></i> Pause
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function filterCampaigns() {
            const status = document.getElementById('statusFilter').value;
            const type = document.getElementById('typeFilter').value;
            window.location.href = '<?php echo base_url('Marketing_campaigns'); ?>?status=' + status + '&type=' + type;
        }

        function updateStatus(campaignId, status) {
            if(confirm('Are you sure you want to change the campaign status?')) {
                fetch('<?php echo base_url('Marketing_campaigns/update_status'); ?>', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: 'campaign_id=' + campaignId + '&status=' + status
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        location.reload();
                    } else {
                        alert('Failed to update status');
                    }
                });
            }
        }
    </script>
</body>
</html>
