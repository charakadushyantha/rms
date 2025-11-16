<!DOCTYPE html>
<html>
<head>
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f7fa; padding: 20px; }
        .container { max-width: 1200px; margin: 0 auto; }
        .header { background: white; padding: 25px; border-radius: 10px; margin-bottom: 25px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; margin-bottom: 10px; }
        .content-grid { display: grid; gap: 20px; }
        .content-card { background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .content-card h3 { color: #2c3e50; margin-bottom: 10px; }
        .content-type { display: inline-block; padding: 4px 10px; background: #27ae60; color: white; border-radius: 4px; font-size: 12px; margin-bottom: 10px; }
        .content-text { color: #555; line-height: 1.6; margin: 15px 0; }
        .content-meta { color: #7f8c8d; font-size: 13px; }
        .btn { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-primary { background: #3498db; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-share-square"></i> Advocacy Content Library</h1>
            <p>Shareable content for employee advocates</p>
        </div>

        <div class="content-grid">
            <?php foreach($content as $item): ?>
                <div class="content-card">
                    <span class="content-type"><?php echo $item['content_type']; ?></span>
                    <h3><?php echo htmlspecialchars($item['content_title']); ?></h3>
                    <div class="content-text"><?php echo htmlspecialchars($item['content_text']); ?></div>
                    <div class="content-meta">
                        <i class="fas fa-bullhorn"></i> Campaign: <?php echo htmlspecialchars($item['campaign_name']); ?> | 
                        <i class="fas fa-globe"></i> Platform: <?php echo $item['target_platform']; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div style="margin-top: 20px; text-align: center;">
            <a href="<?php echo base_url('Employee_advocacy'); ?>" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Back to Advocacy
            </a>
        </div>
    </div>
</body>
</html>
