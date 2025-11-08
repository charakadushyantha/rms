<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $candidate['name']; ?> - Candidate Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url('Assets/css/bootstrap.min.css'); ?>">
    <style>
        body { background: #f5f7fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .detail-container { max-width: 1200px; margin: 30px auto; padding: 20px; }
        .header-card { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; border-radius: 12px; margin-bottom: 30px; }
        .candidate-avatar { width: 100px; height: 100px; border-radius: 50%; background: rgba(255,255,255,0.3); display: flex; align-items: center; justify-content: center; font-size: 48px; font-weight: 700; margin-bottom: 20px; }
        .info-card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); margin-bottom: 20px; }
        .info-card h3 { color: #667eea; margin-bottom: 20px; font-size: 20px; font-weight: 600; }
        .info-row { display: flex; padding: 12px 0; border-bottom: 1px solid #f0f0f0; }
        .info-row:last-child { border-bottom: none; }
        .info-label { font-weight: 600; width: 200px; color: #666; }
        .info-value { flex: 1; color: #333; }
        .timeline { position: relative; padding-left: 30px; }
        .timeline-item { position: relative; padding-bottom: 30px; }
        .timeline-item:before { content: ''; position: absolute; left: -23px; top: 5px; width: 12px; height: 12px; border-radius: 50%; background: #667eea; }
        .timeline-item:after { content: ''; position: absolute; left: -18px; top: 17px; width: 2px; height: calc(100% - 12px); background: #e0e0e0; }
        .timeline-item:last-child:after { display: none; }
        .stage-badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 13px; font-weight: 600; color: white; }
        .btn-back { background: white; color: #667eea; border: 2px solid #667eea; padding: 10px 20px; border-radius: 8px; text-decoration: none; display: inline-block; margin-bottom: 20px; }
        .btn-back:hover { background: #667eea; color: white; }
        .status-badge { padding: 6px 15px; border-radius: 20px; font-size: 14px; font-weight: 600; }
        .status-active { background: #d4edda; color: #155724; }
        .status-completed { background: #cce5ff; color: #004085; }
        .status-scheduled { background: #fff3cd; color: #856404; }
    </style>
</head>
<body>
    <div class="detail-container">
        <a href="<?php echo base_url('realtime_dashboard'); ?>" class="btn-back">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
        
        <div class="header-card">
            <div class="candidate-avatar">
                <?php echo strtoupper(substr($candidate['name'], 0, 1)); ?>
            </div>
            <h1><?php echo $candidate['name']; ?></h1>
            <p style="font-size: 18px; opacity: 0.9; margin: 10px 0;">
                <?php echo $candidate['position_applied'] ?? 'Position Not Specified'; ?>
            </p>
            <span class="status-badge status-active">
                <?php echo ucfirst($candidate['status'] ?? 'Active'); ?>
            </span>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="info-card">
                    <h3><i class="fas fa-user"></i> Contact Information</h3>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-envelope"></i> Email</div>
                        <div class="info-value"><?php echo $candidate['email']; ?></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-phone"></i> Phone</div>
                        <div class="info-value"><?php echo $candidate['phone'] ?? 'N/A'; ?></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-calendar"></i> Applied On</div>
                        <div class="info-value"><?php echo date('F d, Y', strtotime($candidate['created_at'])); ?></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-clock"></i> Last Updated</div>
                        <div class="info-value"><?php echo date('F d, Y H:i', strtotime($candidate['updated_at'])); ?></div>
                    </div>
                </div>

                <?php if (!empty($interviews)): ?>
                <div class="info-card">
                    <h3><i class="fas fa-calendar-check"></i> Interviews</h3>
                    <?php foreach ($interviews as $interview): ?>
                    <div class="info-row">
                        <div class="info-label"><?php echo ucfirst($interview['interview_type']); ?></div>
                        <div class="info-value">
                            <?php echo date('M d, Y H:i', strtotime($interview['interview_date'])); ?>
                            <span class="status-badge status-<?php echo $interview['status']; ?>">
                                <?php echo ucfirst($interview['status']); ?>
                            </span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <div class="col-md-6">
                <div class="info-card">
                    <h3><i class="fas fa-history"></i> Pipeline History</h3>
                    <div class="timeline">
                        <?php if (!empty($pipeline_history)): ?>
                            <?php foreach ($pipeline_history as $history): ?>
                            <div class="timeline-item">
                                <span class="stage-badge" style="background: <?php echo $history['color']; ?>">
                                    <?php echo $history['stage_name']; ?>
                                </span>
                                <div style="margin-top: 8px; color: #666; font-size: 14px;">
                                    <?php echo date('M d, Y H:i', strtotime($history['moved_at'])); ?>
                                    <?php if (!empty($history['notes'])): ?>
                                        <br><em><?php echo $history['notes']; ?></em>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted">No pipeline history available</p>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if (!empty($decisions)): ?>
                <div class="info-card">
                    <h3><i class="fas fa-vote-yea"></i> Hiring Decisions</h3>
                    <?php foreach ($decisions as $decision): ?>
                    <div class="info-row">
                        <div class="info-label"><?php echo ucfirst(str_replace('_', ' ', $decision['decision_type'])); ?></div>
                        <div class="info-value">
                            <?php echo date('M d, Y', strtotime($decision['created_at'])); ?>
                            <span class="status-badge status-<?php echo $decision['status']; ?>">
                                <?php echo ucfirst($decision['status']); ?>
                            </span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
