<!DOCTYPE html>
<html>
<head>
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f7fa; padding: 20px; }
        .container { max-width: 1400px; margin: 0 auto; }
        .header { background: white; padding: 25px; border-radius: 10px; margin-bottom: 25px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; margin-bottom: 10px; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 25px; }
        .stat-card { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center; }
        .stat-card .value { font-size: 32px; font-weight: 600; color: #2c3e50; margin-bottom: 5px; }
        .stat-card .label { color: #7f8c8d; font-size: 14px; }
        .advocates-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }
        .advocate-card { background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .advocate-card h3 { color: #2c3e50; margin-bottom: 5px; }
        .advocate-card .title { color: #7f8c8d; font-size: 14px; margin-bottom: 10px; }
        .advocate-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-top: 15px; padding-top: 15px; border-top: 1px solid #ecf0f1; }
        .advocate-stat { text-align: center; }
        .advocate-stat .value { font-size: 20px; font-weight: 600; color: #3498db; }
        .advocate-stat .label { font-size: 11px; color: #7f8c8d; margin-top: 3px; }
        .btn { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-primary { background: #3498db; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-user-shield"></i> Employee Advocacy</h1>
            <p>Empower employees to share company content and amplify your employer brand</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="value"><?php echo $stats['total_advocates']; ?></div>
                <div class="label">Total Advocates</div>
            </div>
            <div class="stat-card">
                <div class="value"><?php echo number_format($stats['total_shares']); ?></div>
                <div class="label">Total Shares</div>
            </div>
            <div class="stat-card">
                <div class="value"><?php echo number_format($stats['total_reach']); ?></div>
                <div class="label">Total Reach</div>
            </div>
            <div class="stat-card">
                <div class="value"><?php echo number_format($stats['total_engagements']); ?></div>
                <div class="label">Total Engagements</div>
            </div>
        </div>

        <h2 style="color: #2c3e50; margin-bottom: 20px;">Top Advocates</h2>
        <div class="advocates-grid">
            <?php foreach($top_advocates as $advocate): ?>
                <div class="advocate-card">
                    <h3><?php echo htmlspecialchars($advocate['employee_name']); ?></h3>
                    <div class="title"><?php echo htmlspecialchars($advocate['job_title']); ?> - <?php echo htmlspecialchars($advocate['department']); ?></div>
                    
                    <div class="advocate-stats">
                        <div class="advocate-stat">
                            <div class="value"><?php echo number_format($advocate['total_shares']); ?></div>
                            <div class="label">Shares</div>
                        </div>
                        <div class="advocate-stat">
                            <div class="value"><?php echo number_format($advocate['total_reach']); ?></div>
                            <div class="label">Reach</div>
                        </div>
                        <div class="advocate-stat">
                            <div class="value"><?php echo number_format($advocate['total_engagements']); ?></div>
                            <div class="label">Engagements</div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div style="margin-top: 20px; text-align: center;">
            <a href="<?php echo base_url('Sales_marketing'); ?>" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Back to Hub
            </a>
        </div>
    </div>
</body>
</html>
