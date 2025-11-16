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
        
        .toolbar { background: white; padding: 20px; border-radius: 10px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .btn { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; text-decoration: none; display: inline-block; }
        .btn-primary { background: #3498db; color: white; }
        .btn-success { background: #27ae60; color: white; }
        
        .templates-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 20px; }
        .template-card { background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: transform 0.2s; }
        .template-card:hover { transform: translateY(-5px); box-shadow: 0 4px 8px rgba(0,0,0,0.15); }
        .template-header { display: flex; justify-content: space-between; align-items: start; margin-bottom: 15px; }
        .template-header h3 { color: #2c3e50; font-size: 18px; }
        .template-type { display: inline-block; padding: 4px 10px; background: #3498db; color: white; border-radius: 4px; font-size: 12px; }
        .template-preview { background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 15px 0; min-height: 100px; color: #495057; font-size: 14px; }
        .template-meta { color: #7f8c8d; font-size: 13px; margin-bottom: 15px; }
        .template-actions { display: flex; gap: 8px; }
        .btn-sm { padding: 6px 12px; font-size: 12px; }
        
        .empty-state { text-align: center; padding: 60px 20px; background: white; border-radius: 10px; }
        .empty-state i { font-size: 64px; color: #bdc3c7; margin-bottom: 20px; }
        .empty-state h3 { color: #7f8c8d; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-envelope"></i> Email Campaigns</h1>
            <p>Create and manage email marketing campaigns</p>
        </div>

        <div class="toolbar">
            <div>
                <h3 style="color: #2c3e50;">Email Templates</h3>
            </div>
            <div>
                <a href="<?php echo base_url('Marketing_campaigns'); ?>" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <button class="btn btn-success" onclick="alert('Email builder coming soon!')">
                    <i class="fas fa-plus"></i> Create Email Campaign
                </button>
            </div>
        </div>

        <?php if(empty($templates)): ?>
            <div class="empty-state">
                <i class="fas fa-envelope-open-text"></i>
                <h3>No email templates yet</h3>
                <p>Create your first email template to start sending campaigns</p>
                <button class="btn btn-success" style="margin-top: 20px;" onclick="alert('Template builder coming soon!')">
                    <i class="fas fa-plus"></i> Create Template
                </button>
            </div>
        <?php else: ?>
            <div class="templates-grid">
                <?php foreach($templates as $template): ?>
                    <div class="template-card">
                        <div class="template-header">
                            <h3><?php echo htmlspecialchars($template['template_name']); ?></h3>
                            <span class="template-type"><?php echo $template['category'] ?? 'General'; ?></span>
                        </div>
                        
                        <div class="template-meta">
                            <div><i class="fas fa-tag"></i> Subject: <?php echo htmlspecialchars($template['subject'] ?? 'No subject'); ?></div>
                            <div><i class="fas fa-calendar"></i> Created: <?php echo date('M d, Y', strtotime($template['created_at'])); ?></div>
                        </div>
                        
                        <div class="template-preview">
                            <?php echo htmlspecialchars(substr(strip_tags($template['body_html'] ?? ''), 0, 150)) . '...'; ?>
                        </div>
                        
                        <div class="template-actions">
                            <button class="btn btn-primary btn-sm" onclick="alert('Preview coming soon!')">
                                <i class="fas fa-eye"></i> Preview
                            </button>
                            <button class="btn btn-success btn-sm" onclick="alert('Use template coming soon!')">
                                <i class="fas fa-paper-plane"></i> Use Template
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
