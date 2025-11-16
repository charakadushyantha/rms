<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f7fa; }
        .container { max-width: 1400px; margin: 0 auto; padding: 20px; }
        
        .header { background: white; padding: 25px; border-radius: 10px; margin-bottom: 25px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; margin-bottom: 10px; }
        .header p { color: #7f8c8d; }
        
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 25px; }
        .stat-card { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center; }
        .stat-card .icon { font-size: 32px; margin-bottom: 15px; }
        .stat-card .icon.blue { color: #3498db; }
        .stat-card .icon.green { color: #27ae60; }
        .stat-card .icon.orange { color: #e67e22; }
        .stat-card .icon.purple { color: #9b59b6; }
        .stat-card .icon.red { color: #e74c3c; }
        .stat-card h3 { font-size: 32px; color: #2c3e50; margin-bottom: 5px; }
        .stat-card p { color: #7f8c8d; font-size: 14px; }
        
        .chart-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 25px; }
        .chart-card { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .chart-card h3 { color: #2c3e50; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #3498db; }
        .chart-card.full-width { grid-column: 1 / -1; }
        
        .table-card { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .table-card h3 { color: #2c3e50; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #3498db; }
        
        table { width: 100%; border-collapse: collapse; }
        table th { background: #f8f9fa; padding: 12px; text-align: left; color: #2c3e50; font-weight: 600; border-bottom: 2px solid #dee2e6; }
        table td { padding: 12px; border-bottom: 1px solid #dee2e6; color: #495057; }
        table tr:hover { background: #f8f9fa; }
        
        .status-badge { padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .status-badge.active { background: #d4edda; color: #155724; }
        .status-badge.draft { background: #fff3cd; color: #856404; }
        .status-badge.completed { background: #d1ecf1; color: #0c5460; }
        .status-badge.paused { background: #f8d7da; color: #721c24; }
        
        .btn { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; text-decoration: none; display: inline-block; }
        .btn-primary { background: #3498db; color: white; }
        .btn-secondary { background: #95a5a6; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-chart-bar"></i> Campaign Analytics</h1>
            <p>Comprehensive performance metrics and insights</p>
        </div>

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
                <div class="icon purple"><i class="fas fa-eye"></i></div>
                <h3><?php echo number_format($stats['total_reach'], 0); ?></h3>
                <p>Total Reach</p>
            </div>
            <div class="stat-card">
                <div class="icon red"><i class="fas fa-mouse-pointer"></i></div>
                <h3><?php echo number_format($stats['total_clicks'], 0); ?></h3>
                <p>Total Clicks</p>
            </div>
        </div>

        <div class="chart-grid">
            <div class="chart-card">
                <h3><i class="fas fa-chart-pie"></i> Campaign Status Distribution</h3>
                <canvas id="statusChart"></canvas>
            </div>
            
            <div class="chart-card">
                <h3><i class="fas fa-chart-bar"></i> Campaign Types</h3>
                <canvas id="typeChart"></canvas>
            </div>
        </div>

        <div class="chart-card full-width">
            <h3><i class="fas fa-chart-line"></i> Campaign Performance Comparison</h3>
            <canvas id="performanceChart"></canvas>
        </div>

        <div class="table-card">
            <h3><i class="fas fa-table"></i> Campaign Performance Details</h3>
            <table>
                <thead>
                    <tr>
                        <th>Campaign Name</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Budget</th>
                        <th>Reach</th>
                        <th>Clicks</th>
                        <th>Applications</th>
                        <th>CTR</th>
                        <th>CPA</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($campaigns as $campaign): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($campaign['campaign_name']); ?></strong></td>
                            <td><?php echo $campaign['campaign_type']; ?></td>
                            <td><span class="status-badge <?php echo strtolower($campaign['status']); ?>"><?php echo $campaign['status']; ?></span></td>
                            <td>$<?php echo number_format($campaign['budget'], 2); ?></td>
                            <td><?php echo number_format($campaign['total_reach'] ?? 0); ?></td>
                            <td><?php echo number_format($campaign['total_clicks'] ?? 0); ?></td>
                            <td><?php echo number_format($campaign['total_applications'] ?? 0); ?></td>
                            <td>
                                <?php 
                                $ctr = ($campaign['total_reach'] > 0) ? ($campaign['total_clicks'] / $campaign['total_reach'] * 100) : 0;
                                echo number_format($ctr, 2) . '%';
                                ?>
                            </td>
                            <td>
                                <?php 
                                $cpa = ($campaign['total_applications'] > 0) ? ($campaign['budget'] / $campaign['total_applications']) : 0;
                                echo '$' . number_format($cpa, 2);
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px; text-align: center;">
            <a href="<?php echo base_url('Marketing_campaigns'); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Campaigns
            </a>
        </div>
    </div>

    <script>
        // Status Distribution Chart
        const statusData = {
            'Active': <?php echo $stats['active_campaigns']; ?>,
            'Draft': 0,
            'Paused': 0,
            'Completed': 0
        };
        
        <?php foreach($campaigns as $c): ?>
            if(statusData['<?php echo $c['status']; ?>'] !== undefined) {
                statusData['<?php echo $c['status']; ?>']++;
            }
        <?php endforeach; ?>
        
        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: Object.keys(statusData),
                datasets: [{
                    data: Object.values(statusData),
                    backgroundColor: ['#27ae60', '#f39c12', '#e74c3c', '#3498db']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true
            }
        });

        // Campaign Types Chart
        const typeData = {};
        <?php foreach($campaigns as $c): ?>
            const type = '<?php echo $c['campaign_type']; ?>';
            typeData[type] = (typeData[type] || 0) + 1;
        <?php endforeach; ?>
        
        new Chart(document.getElementById('typeChart'), {
            type: 'bar',
            data: {
                labels: Object.keys(typeData),
                datasets: [{
                    label: 'Campaigns',
                    data: Object.values(typeData),
                    backgroundColor: '#3498db'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });

        // Performance Comparison Chart
        new Chart(document.getElementById('performanceChart'), {
            type: 'bar',
            data: {
                labels: [
                    <?php foreach($campaigns as $c): ?>
                        '<?php echo addslashes(substr($c['campaign_name'], 0, 20)); ?>',
                    <?php endforeach; ?>
                ],
                datasets: [
                    {
                        label: 'Reach',
                        data: [<?php foreach($campaigns as $c): echo ($c['total_reach'] ?? 0) . ','; endforeach; ?>],
                        backgroundColor: '#3498db'
                    },
                    {
                        label: 'Clicks',
                        data: [<?php foreach($campaigns as $c): echo ($c['total_clicks'] ?? 0) . ','; endforeach; ?>],
                        backgroundColor: '#27ae60'
                    },
                    {
                        label: 'Applications',
                        data: [<?php foreach($campaigns as $c): echo ($c['total_applications'] ?? 0) . ','; endforeach; ?>],
                        backgroundColor: '#e67e22'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
</body>
</html>
