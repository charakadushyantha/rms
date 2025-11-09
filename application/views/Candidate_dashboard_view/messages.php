<?php
$data['page_title'] = 'Messages';
$this->load->view('templates/candidate_header', $data);
?>

<style>
.messages-container {
    padding: 2rem;
}

.messages-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

.message-item {
    padding: 1.5rem;
    background: #f9fafb;
    border-radius: 12px;
    margin-bottom: 1rem;
    cursor: pointer;
    transition: all 0.2s;
}

.message-item:hover {
    background: #f3f4f6;
}

.message-item.unread {
    background: #ecfdf5;
    border-left: 4px solid #14b8a6;
}

.message-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
}

.message-from {
    font-weight: 700;
    color: #1f2937;
}

.message-date {
    font-size: 0.875rem;
    color: #6b7280;
}

.message-subject {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.message-preview {
    color: #6b7280;
    font-size: 0.875rem;
}
</style>

<div class="messages-container">
    <div class="messages-card">
        <h1><i class="fas fa-envelope me-2"></i>Messages</h1>
        
        <?php if (!empty($messages)): ?>
            <?php foreach ($messages as $msg): ?>
                <div class="message-item <?php echo $msg['is_read'] ? '' : 'unread'; ?>" 
                     onclick="viewMessage(<?php echo $msg['id']; ?>)">
                    <div class="message-header">
                        <span class="message-from">
                            <?php echo $msg['is_read'] ? '' : '<i class="fas fa-circle text-success me-2" style="font-size: 0.5rem;"></i>'; ?>
                            From: <?php echo htmlspecialchars($msg['from_username']); ?>
                        </span>
                        <span class="message-date">
                            <?php echo date('M d, Y h:i A', strtotime($msg['sent_at'])); ?>
                        </span>
                    </div>
                    <div class="message-subject"><?php echo htmlspecialchars($msg['subject']); ?></div>
                    <div class="message-preview">
                        <?php echo substr(htmlspecialchars($msg['message']), 0, 100); ?>...
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-muted">No messages yet</p>
        <?php endif; ?>
    </div>
</div>

<?php
$custom_script = "
function viewMessage(id) {
    fetch('" . base_url('C_dashboard/mark_message_read') . "', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'message_id=' + id
    });
}
";

$data['custom_script'] = $custom_script;
$this->load->view('templates/candidate_footer', $data);
?>
