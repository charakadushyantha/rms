<!DOCTYPE html>
<html>
<head>
    <title>Chat Session Details - Admin</title>
    <link rel="stylesheet" href="<?php echo base_url('Assets/css/bootstrap.min.css'); ?>">
    <style>
        .chat-container { max-width: 800px; margin: 20px auto; }
        .chat-message { margin-bottom: 15px; padding: 12px; border-radius: 8px; }
        .chat-message.user { background: #007bff; color: white; margin-left: 20%; }
        .chat-message.assistant { background: #f1f3f5; margin-right: 20%; }
        .message-meta { font-size: 0.85em; opacity: 0.7; margin-top: 5px; }
        .session-info { background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="chat-container">
            <a href="<?php echo base_url('admin_chatbot'); ?>" class="btn btn-secondary mb-3">← Back to Sessions</a>
            
            <h2>Chat Session Details</h2>
            
            <div class="session-info">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Session ID:</strong> <code><?php echo $session['session_id']; ?></code><br>
                        <strong>User Type:</strong> <?php echo ucfirst($session['user_type']); ?><br>
                        <strong>User ID:</strong> <?php echo $session['user_id'] ?? 'N/A'; ?>
                    </div>
                    <div class="col-md-6">
                        <strong>Started:</strong> <?php echo date('M d, Y H:i:s', strtotime($session['created_at'])); ?><br>
                        <strong>Last Activity:</strong> <?php echo date('M d, Y H:i:s', strtotime($session['updated_at'])); ?><br>
                        <strong>IP Address:</strong> <?php echo $session['ip_address']; ?>
                    </div>
                </div>
            </div>

            <h4>Conversation</h4>
            <div class="chat-messages">
                <?php if (!empty($session['messages'])): ?>
                    <?php foreach ($session['messages'] as $message): ?>
                        <div class="chat-message <?php echo $message['role']; ?>">
                            <div><?php echo nl2br(htmlspecialchars($message['message'])); ?></div>
                            <div class="message-meta">
                                <?php echo date('H:i:s', strtotime($message['created_at'])); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted">No messages in this session</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
