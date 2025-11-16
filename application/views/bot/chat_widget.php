<!-- Chat Widget Trigger Button -->
<div id="chatbot-trigger" class="chatbot-trigger">
    <i class="fas fa-comments"></i>
</div>

<!-- Chat Widget Container -->
<div id="chatbot-widget" class="chatbot-widget" style="display: none;">
    <div class="chatbot-header">
        <div class="chatbot-header-left">
            <div class="chatbot-avatar">
                <i class="fas fa-robot"></i>
            </div>
            <div class="chatbot-info">
                <h4>RecruitBot</h4>
                <span class="status online">Online</span>
            </div>
        </div>
        <div class="chatbot-header-right">
            <button class="btn-close"><i class="fas fa-times"></i></button>
        </div>
    </div>

    <div class="chatbot-body">
        <div id="chat-messages-widget" class="chat-messages">
            <div class="message bot-message">
                <div class="message-avatar"><i class="fas fa-robot"></i></div>
                <div class="message-content">
                    <p>Hi! 👋 I'm RecruitBot. How can I help you?</p>
                    <div class="quick-replies">
                        <button class="quick-reply-btn" data-reply="Apply for a job">Apply</button>
                        <button class="quick-reply-btn" data-reply="Check status">Status</button>
                        <button class="quick-reply-btn" data-reply="View jobs">Jobs</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="typing-indicator-widget" class="typing-indicator" style="display: none;">
            <div class="typing-dot"></div>
            <div class="typing-dot"></div>
            <div class="typing-dot"></div>
        </div>
    </div>

    <div class="chatbot-footer">
        <input type="file" id="cv-upload-widget" accept=".pdf,.doc,.docx,.txt" style="display: none;">
        <button class="btn-attach" title="Upload CV"><i class="fas fa-paperclip"></i></button>
        <input type="text" id="chat-input-widget" class="chat-input" placeholder="Type message..." autocomplete="off">
        <button class="btn-send-widget" id="send-message-widget"><i class="fas fa-paper-plane"></i></button>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
.chatbot-trigger {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transition: all 0.3s ease;
    z-index: 1000;
}
.chatbot-trigger:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(0,0,0,0.2);
}
.chatbot-trigger i {
    color: white;
    font-size: 28px;
}
.chatbot-widget {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 380px;
    height: 600px;
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    display: flex;
    flex-direction: column;
    z-index: 1001;
    animation: slideUp 0.3s ease;
}
@keyframes slideUp {
    from { transform: translateY(20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}
.chatbot-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 15px;
    border-radius: 15px 15px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.chatbot-header-left {
    display: flex;
    align-items: center;
    gap: 10px;
}
.chatbot-avatar {
    width: 40px;
    height: 40px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.chatbot-info h4 {
    margin: 0;
    font-size: 16px;
}
.chatbot-info .status {
    font-size: 12px;
    opacity: 0.9;
}
.status.online::before {
    content: '';
    display: inline-block;
    width: 6px;
    height: 6px;
    background: #2ecc71;
    border-radius: 50%;
    margin-right: 5px;
}
.chatbot-header-right button {
    background: transparent;
    border: none;
    color: white;
    cursor: pointer;
    padding: 5px 10px;
    font-size: 16px;
}
.chatbot-body {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
    background: #f5f6fa;
}
.chat-messages {
    display: flex;
    flex-direction: column;
    gap: 15px;
}
.message {
    display: flex;
    gap: 10px;
    animation: fadeIn 0.3s ease;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
.message-avatar {
    width: 35px;
    height: 35px;
    background: #667eea;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    flex-shrink: 0;
}
.user-message {
    flex-direction: row-reverse;
}
.user-message .message-content {
    background: #667eea;
    color: white;
    border-radius: 15px 15px 0 15px;
}
.bot-message .message-content {
    background: white;
    border-radius: 15px 15px 15px 0;
}
.message-content {
    padding: 12px 15px;
    max-width: 70%;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}
.message-content p {
    margin: 0;
    line-height: 1.5;
    font-size: 14px;
}
.quick-replies {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 10px;
}
.quick-reply-btn {
    background: #f0f0f0;
    border: 1px solid #ddd;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.2s;
}
.quick-reply-btn:hover {
    background: #667eea;
    color: white;
    border-color: #667eea;
}
.typing-indicator {
    display: flex;
    gap: 5px;
    padding: 10px 15px;
    background: white;
    border-radius: 15px;
    width: fit-content;
}
.typing-dot {
    width: 8px;
    height: 8px;
    background: #999;
    border-radius: 50%;
    animation: typing 1.4s infinite;
}
.typing-dot:nth-child(2) { animation-delay: 0.2s; }
.typing-dot:nth-child(3) { animation-delay: 0.4s; }
@keyframes typing {
    0%, 60%, 100% { transform: translateY(0); }
    30% { transform: translateY(-10px); }
}
.chatbot-footer {
    padding: 15px;
    background: white;
    border-top: 1px solid #e0e0e0;
    display: flex;
    gap: 10px;
    align-items: center;
    border-radius: 0 0 15px 15px;
}
.btn-attach, .btn-send-widget {
    background: transparent;
    border: none;
    color: #667eea;
    font-size: 20px;
    cursor: pointer;
    padding: 8px;
    transition: all 0.2s;
}
.btn-attach:hover, .btn-send-widget:hover {
    color: #764ba2;
    transform: scale(1.1);
}
.chat-input {
    flex: 1;
    border: 1px solid #e0e0e0;
    border-radius: 20px;
    padding: 10px 15px;
    font-size: 14px;
    outline: none;
}
.chat-input:focus {
    border-color: #667eea;
}
@media (max-width: 768px) {
    .chatbot-widget {
        width: 100%;
        height: 100%;
        bottom: 0;
        right: 0;
        border-radius: 0;
    }
}
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    let sessionId = 'session_' + Date.now();

    $('#chatbot-trigger').click(function() {
        $('#chatbot-widget').fadeIn();
        $(this).hide();
        $('#chat-input-widget').focus();
    });

    $('.btn-close').click(function() {
        $('#chatbot-widget').fadeOut();
        $('#chatbot-trigger').show();
    });

    function sendMessage(message) {
        if (!message.trim()) return;

        appendMessage('user', message);
        $('#chat-input-widget').val('');
        $('#typing-indicator-widget').show();

        $.ajax({
            url: '<?= base_url('bot/send_message') ?>',
            method: 'POST',
            data: { message: message, session_id: sessionId },
            dataType: 'json',
            success: function(response) {
                $('#typing-indicator-widget').hide();
                if (response.success) {
                    appendMessage('bot', response.message, response.suggestions);
                }
            },
            error: function() {
                $('#typing-indicator-widget').hide();
                appendMessage('bot', 'Sorry, connection error. Please try again.');
            }
        });
    }

    function appendMessage(sender, text, suggestions = []) {
        let html = '';
        if (sender === 'user') {
            html = `<div class="message user-message">
                <div class="message-avatar"><i class="fas fa-user"></i></div>
                <div class="message-content"><p>${escapeHtml(text)}</p></div>
            </div>`;
        } else {
            let suggestionsHtml = '';
            if (suggestions && suggestions.length > 0) {
                suggestionsHtml = '<div class="quick-replies">';
                suggestions.forEach(s => {
                    suggestionsHtml += `<button class="quick-reply-btn" data-reply="${escapeHtml(s)}">${escapeHtml(s)}</button>`;
                });
                suggestionsHtml += '</div>';
            }
            html = `<div class="message bot-message">
                <div class="message-avatar"><i class="fas fa-robot"></i></div>
                <div class="message-content"><p>${text}</p>${suggestionsHtml}</div>
            </div>`;
        }
        $('#chat-messages-widget').append(html);
        $('.chatbot-body').scrollTop($('.chatbot-body')[0].scrollHeight);
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    $('#send-message-widget').click(function() {
        sendMessage($('#chat-input-widget').val());
    });

    $('#chat-input-widget').keypress(function(e) {
        if (e.which === 13) {
            sendMessage($(this).val());
        }
    });

    $(document).on('click', '.quick-reply-btn', function() {
        sendMessage($(this).data('reply'));
    });

    $('.btn-attach').click(function() {
        $('#cv-upload-widget').click();
    });

    $('#cv-upload-widget').change(function() {
        const file = this.files[0];
        if (file) {
            const formData = new FormData();
            formData.append('cv_file', file);
            formData.append('session_id', sessionId);

            appendMessage('user', `📎 Uploading ${file.name}...`);
            $('#typing-indicator-widget').show();

            $.ajax({
                url: '<?= base_url('bot/upload_cv') ?>',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    $('#typing-indicator-widget').hide();
                    if (response.success) {
                        appendMessage('bot', response.message);
                    } else {
                        appendMessage('bot', 'CV upload failed: ' + response.error);
                    }
                },
                error: function() {
                    $('#typing-indicator-widget').hide();
                    appendMessage('bot', 'Upload failed. Please try again.');
                }
            });
            $('#cv-upload-widget').val('');
        }
    });
});
</script>
