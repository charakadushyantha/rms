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
        .pipeline-stages { display: flex; gap: 15px; overflow-x: auto; padding: 20px 0; }
        .stage-column { min-width: 280px; background: white; border-radius: 10px; padding: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .stage-header { font-weight: 600; color: #2c3e50; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 3px solid; }
        .candidate-card { background: #f8f9fa; border-radius: 8px; padding: 15px; margin-bottom: 10px; cursor: pointer; transition: transform 0.2s; }
        .candidate-card:hover { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .candidate-card h4 { color: #2c3e50; margin-bottom: 5px; font-size: 14px; }
        .candidate-card .meta { color: #7f8c8d; font-size: 12px; }
        .btn { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-primary { background: #3498db; color: white; }
        .empty-state { text-align: center; padding: 40px; color: #7f8c8d; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-handshake"></i> Candidate CRM</h1>
            <p>Comprehensive candidate relationship management system</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="value"><?php echo $stats['total_candidates']; ?></div>
                <div class="label">Active Candidates</div>
            </div>
            <div class="stat-card">
                <div class="value"><?php echo $stats['hot_leads']; ?></div>
                <div class="label">Hot Leads</div>
            </div>
            <div class="stat-card">
                <div class="value"><?php echo $stats['total_interactions']; ?></div>
                <div class="label">Total Interactions</div>
            </div>
            <div class="stat-card">
                <div class="value"><?php echo $stats['pending_activities']; ?></div>
                <div class="label">Pending Activities</div>
            </div>
        </div>

        <h2 style="color: #2c3e50; margin-bottom: 20px;">Pipeline Overview</h2>
        
        <?php if(empty($candidates)): ?>
            <div class="empty-state" style="background: white; border-radius: 10px; padding: 60px;">
                <i class="fas fa-users" style="font-size: 64px; color: #bdc3c7; margin-bottom: 20px;"></i>
                <h3>No candidates in CRM yet</h3>
                <p>Start adding candidates to track relationships and manage your pipeline</p>
                <p style="margin-top: 20px;">
                    <strong>Database Ready:</strong> 8 tables created with 9 pipeline stages and 8 tags configured
                </p>
            </div>
        <?php else: ?>
            <div class="pipeline-stages">
                <?php foreach($pipeline_stages as $stage): ?>
                    <div class="stage-column">
                        <div class="stage-header" style="border-color: <?php echo $stage['stage_color']; ?>;">
                            <?php echo $stage['stage_name']; ?>
                            <span style="float: right; background: <?php echo $stage['stage_color']; ?>; color: white; padding: 2px 8px; border-radius: 12px; font-size: 11px;">
                                0
                            </span>
                        </div>
                        <div class="empty-state" style="padding: 20px;">
                            <small>No candidates</small>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div style="margin-top: 30px; text-align: center; background: white; padding: 30px; border-radius: 10px;">
            <h3 style="color: #2c3e50; margin-bottom: 15px;">CRM Features Available</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin: 20px 0;">
                <div style="padding: 15px; background: #ecf0f1; border-radius: 8px;">
                    <i class="fas fa-project-diagram" style="font-size: 24px; color: #3498db; margin-bottom: 10px;"></i>
                    <div><strong>Pipeline Management</strong></div>
                    <small>9 customizable stages</small>
                </div>
                <div style="padding: 15px; background: #ecf0f1; border-radius: 8px;">
                    <i class="fas fa-comments" style="font-size: 24px; color: #27ae60; margin-bottom: 10px;"></i>
                    <div><strong>Interaction Tracking</strong></div>
                    <small>Calls, emails, meetings</small>
                </div>
                <div style="padding: 15px; background: #ecf0f1; border-radius: 8px;">
                    <i class="fas fa-tasks" style="font-size: 24px; color: #e67e22; margin-bottom: 10px;"></i>
                    <div><strong>Activity Management</strong></div>
                    <small>Tasks & follow-ups</small>
                </div>
                <div style="padding: 15px; background: #ecf0f1; border-radius: 8px;">
                    <i class="fas fa-chart-line" style="font-size: 24px; color: #9b59b6; margin-bottom: 10px;"></i>
                    <div><strong>Relationship Scoring</strong></div>
                    <small>Engagement metrics</small>
                </div>
            </div>
            <a href="<?php echo base_url('Sales_marketing'); ?>" class="btn btn-primary" style="margin-top: 20px;">
                <i class="fas fa-arrow-left"></i> Back to Hub
            </a>
        </div>
    </div>
</body>
</html>
