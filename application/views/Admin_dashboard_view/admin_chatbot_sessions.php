<!DOCTYPE html>
<html>
<head>
    <title>Chat Sessions - Admin</title>
    <link rel="stylesheet" href="<?php echo base_url('Assets/css/bootstrap.min.css'); ?>">
    <style>
        .chat-sessions-table { margin-top: 20px; }
        .badge { padding: 5px 10px; }
        .session-row:hover { background-color: #f8f9fa; cursor: pointer; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2>AI Chatbot Sessions</h2>
                <p class="text-muted">View and monitor all chat conversations</p>
                
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover chat-sessions-table">
                            <thead>
                                <tr>
                                    <th>Session ID</th>
                                    <th>User Type</th>
                                    <th>Messages</th>
                                    <th>Started</th>
                                    <th>Last Activity</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($sessions)): ?>
                                    <?php foreach ($sessions as $session): ?>
                                        <tr class="session-row">
                                            <td><code><?php echo substr($session['session_id'], 0, 20); ?>...</code></td>
                                            <td>
                                                <span class="badge badge-<?php 
                                                    echo $session['user_type'] === 'admin' ? 'danger' : 
                                                        ($session['user_type'] === 'recruiter' ? 'warning' : 
                                                        ($session['user_type'] === 'candidate' ? 'info' : 'secondary')); 
                                                ?>">
                                                    <?php echo ucfirst($session['user_type']); ?>
                                                </span>
                                            </td>
                                            <td><?php echo $session['message_count']; ?></td>
                                            <td><?php echo date('M d, Y H:i', strtotime($session['created_at'])); ?></td>
                                            <td><?php echo date('M d, Y H:i', strtotime($session['updated_at'])); ?></td>
                                            <td>
                                                <a href="<?php echo base_url('admin_chatbot/view_session/' . $session['session_id']); ?>" 
                                                   class="btn btn-sm btn-primary">View</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No chat sessions found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
