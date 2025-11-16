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
        
        .header { background: white; padding: 25px; border-radius: 10px; margin-bottom: 25px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center; }
        .header-left h1 { color: #2c3e50; margin-bottom: 5px; }
        .header-left .meta { color: #7f8c8d; font-size: 14px; }
        .status-badge { padding: 8px 16px; border-radius: 20px; font-size: 14px; font-weight: 600; }
        .status-badge.active { background: #d4edda; color: #155724; }
        .status-badge.draft { background: #fff3cd; color: #856404; }
        .status-badge.completed { background: #d1ecf1; color: #0c5460; }
        .status-badge.paused { background: #f8d7da; color: #721c24; }
        
        .btn { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; text-decoration: none; display: inline-block; }
        .btn-primary { background: #3498db; color: white; }
        .btn-success { background: #27ae60; color: white; }
        .btn-danger { background: #e74c3c; color: white; }
        .btn-secondary { background: #95a5a6; color: white; }
        
        .content-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; }
        .card { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .card h3 { color: #2c3e50; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #3498db; }
        
        .info-row { display: grid; grid-template-columns: 150px 1fr; padding: 12px 0; border-bottom: 1px solid #ecf0f1; }
        .info-row:last-child { border-bottom: none; }
        .info-row .label { color: #7f8c8d; font-weight: 500; }
        .info-row .value { color: #2c3e50; }
        
        .stats-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; }
        .stat-box { background: #f8f9fa; padding: 20px; border-radius: 8px; text-align: center; }
        .stat-box .value { font-size: 32px; font-weight: 600; color: #2c3e50; margin-bottom: 5px; }
        .stat-box .label { color: #7f8c8d; font-size: 13px; }
        
        .performance-metrics { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-top: 20px; }
        .metric { text-align: center; padding: 15px; background: #f8f9fa; border-radius: 8px; }
        .metric .value { font-size: 24px; font-weight: 600; color: #3498db; }
        .metric .label { font-size: 12px; color: #7f8c8d; margin-top: 5px; }
        
        .channel-list { list-style: none; }
        .channel-item { padding: 15px; background: #f8f9fa; border-radius: 8px; margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center; }
        .channel-item .name { font-weight: 500; color: #2c3e50; }
        .channel-item .count { background: #3498db; color: white; padding: 4px 12px; border-radius: 12px; font-size: 12px; }
        
        .empty-state { text-align: center; padding: 40px; color: #7f8c8d; }
        .empty-state i { font-size: 48px; margin-bottom: 15px; opacity: 0.5; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-left">
                <h1><?php echo htmlspecialchars($campaign['campaign_name']); ?></h1>
                <div class="meta">
                    <i class="fas fa-tag"></i> <?php echo $campaign['campaign_type']; ?> | 
                    <i class="fas fa-user"></i> Created by <?php echo $campaign['created_by']; ?> | 
                    <i class="fas fa-calendar"></i> <?php echo date('M d, Y', strtotime($campaign['created_at'])); ?>
                </div>
            </div>
            <div>
                <span class="status-badge <?php echo strtolower($campaign['status']); ?>">
                    <?php echo $campaign['status']; ?>
                </span>
            </div>
        </div>

        <div class="content-grid">
            <div>
                <div class="card">
                    <h3><i class="fas fa-info-circle"></i> Campaign Details</h3>
                    <div class="info-row">
                        <div class="label">Description:</div>
                        <div class="value"><?php echo nl2br(htmlspecialchars($campaign['description'] ?? 'No description')); ?></div>
                    </div>
                    <div class="info-row">
                        <div class="label">Duration:</div>
                        <div class="value">
                            <?php echo date('M d, Y', strtotime($campaign['start_date'])); ?> - 
                            <?php echo date('M d, Y', strtotime($campaign['end_date'])); ?>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="label">Budget:</div>
                        <div class="value">$<?php echo number_format($campaign['budget'], 2); ?></div>
                    </div>
                    <div class="info-row">
                        <div class="label">Target Audience:</div>
                        <div class="value"><?php echo nl2br(htmlspecialchars($campaign['target_audience'] ?? 'Not specified')); ?></div>
                    </div>
                    <div class="info-row">
                        <div class="label">Goals:</div>
                        <div class="value"><?php echo nl2br(htmlspecialchars($campaign['goals'] ?? 'Not specified')); ?></div>
                    </div>
                </div>

                <div class="card">
                    <h3><i class="fas fa-chart-line"></i> Performance Overview</h3>
                    <div class="performance-metrics">
                        <?php 
                        $total_reach = 0;
                        $total_impressions = 0;
                        $total_clicks = 0;
                        $total_applications = 0;
                        $total_spent = 0;
                        
                        if (!empty($performance)) {
                            foreach ($performance as $perf) {
                                $total_reach += $perf['reach'] ?? 0;
                                $total_impressions += $perf['impressions'] ?? 0;
                                $total_clicks += $perf['clicks'] ?? 0;
                                $total_applications += $perf['applications'] ?? 0;
                                $total_spent += $perf['spent'] ?? 0;
                            }
                        }
                        
                        $conversion_rate = ($total_reach > 0) ? ($total_applications / $total_reach * 100) : 0;
                        ?>
                        <div class="metric">
                            <div class="value"><?php echo number_format($total_reach); ?></div>
                            <div class="label">Total Reach</div>
                        </div>
                        <div class="metric">
                            <div class="value"><?php echo number_format($total_impressions); ?></div>
                            <div class="label">Impressions</div>
                        </div>
                        <div class="metric">
                            <div class="value"><?php echo number_format($total_clicks); ?></div>
                            <div class="label">Clicks</div>
                        </div>
                        <div class="metric">
                            <div class="value"><?php echo number_format($total_applications); ?></div>
                            <div class="label">Applications</div>
                        </div>
                        <div class="metric">
                            <div class="value">$<?php echo number_format($total_spent, 2); ?></div>
                            <div class="label">Spent</div>
                        </div>
                        <div class="metric">
                            <div class="value"><?php echo number_format($conversion_rate, 2); ?>%</div>
                            <div class="label">Conversion Rate</div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <h3><i class="fas fa-envelope"></i> Email Campaigns</h3>
                    <?php if(empty($email_campaigns)): ?>
                        <div class="empty-state">
                            <i class="fas fa-envelope"></i>
                            <p>No email campaigns yet</p>
                        </div>
                    <?php else: ?>
                        <ul class="channel-list">
                            <?php foreach($email_campaigns as $email): ?>
                                <li class="channel-item">
                                    <div>
                                        <div class="name"><?php echo htmlspecialchars($email['subject']); ?></div>
                                        <small style="color: #7f8c8d;">
                                            Sent: <?php echo number_format($email['sent_count']); ?> | 
                                            Opens: <?php echo number_format($email['open_count']); ?> | 
                                            Clicks: <?php echo number_format($email['click_count']); ?>
                                        </small>
                                    </div>
                                    <span class="count"><?php echo $email['status']; ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>

                <div class="card">
                    <h3><i class="fas fa-share-alt"></i> Social Media Posts</h3>
                    <?php if(empty($social_posts)): ?>
                        <div class="empty-state">
                            <i class="fas fa-share-alt"></i>
                            <p>No social media posts yet</p>
                        </div>
                    <?php else: ?>
                        <ul class="channel-list">
                            <?php foreach($social_posts as $post): ?>
                                <li class="channel-item">
                                    <div>
                                        <div class="name"><?php echo htmlspecialchars(substr($post['content'], 0, 60)) . '...'; ?></div>
                                        <small style="color: #7f8c8d;">
                                            <?php echo ucfirst($post['platform']); ?> | 
                                            Reach: <?php echo number_format($post['reach']); ?> | 
                                            Engagement: <?php echo number_format($post['engagement']); ?>
                                        </small>
                                    </div>
                                    <span class="count"><?php echo $post['status']; ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>

            <div>
                <div class="card">
                    <h3><i class="fas fa-cog"></i> Actions</h3>
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <?php if($campaign['status'] == 'Draft'): ?>
                            <button onclick="updateStatus('Active')" class="btn btn-success" style="width: 100%;">
                                <i class="fas fa-play"></i> Launch Campaign
                            </button>
                        <?php elseif($campaign['status'] == 'Active'): ?>
                            <button onclick="updateStatus('Paused')" class="btn btn-danger" style="width: 100%;">
                                <i class="fas fa-pause"></i> Pause Campaign
                            </button>
                        <?php elseif($campaign['status'] == 'Paused'): ?>
                            <button onclick="updateStatus('Active')" class="btn btn-success" style="width: 100%;">
                                <i class="fas fa-play"></i> Resume Campaign
                            </button>
                        <?php endif; ?>
                        
                        <a href="<?php echo base_url('Marketing_campaigns'); ?>" class="btn btn-secondary" style="width: 100%; text-align: center;">
                            <i class="fas fa-arrow-left"></i> Back to Campaigns
                        </a>
                    </div>
                </div>

                <div class="card">
                    <h3><i class="fas fa-chart-pie"></i> Quick Stats</h3>
                    <div class="stats-grid">
                        <div class="stat-box">
                            <div class="value"><?php echo count($email_campaigns); ?></div>
                            <div class="label">Email Campaigns</div>
                        </div>
                        <div class="stat-box">
                            <div class="value"><?php echo count($social_posts); ?></div>
                            <div class="label">Social Posts</div>
                        </div>
                        <div class="stat-box">
                            <div class="value"><?php echo count($ad_campaigns); ?></div>
                            <div class="label">Ad Campaigns</div>
                        </div>
                        <div class="stat-box">
                            <div class="value">
                                <?php 
                                $days_running = max(1, (strtotime('now') - strtotime($campaign['start_date'])) / 86400);
                                echo round($days_running);
                                ?>
                            </div>
                            <div class="label">Days Running</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateStatus(status) {
            if(confirm('Are you sure you want to change the campaign status to ' + status + '?')) {
                fetch('<?php echo base_url('Marketing_campaigns/update_status'); ?>', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: 'campaign_id=<?php echo $campaign['campaign_id']; ?>&status=' + status
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
