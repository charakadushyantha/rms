<!DOCTYPE html>
<html>
<head>
    <title>Simple Bot Test</title>
    <style>
        body { font-family: Arial; padding: 20px; max-width: 800px; margin: 0 auto; }
        .success { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
        .message { background: #f5f5f5; padding: 15px; margin: 10px 0; border-radius: 5px; }
        .bot { background: #e3f2fd; border-left: 4px solid #2196f3; }
        .user { background: #f3e5f5; border-left: 4px solid #9c27b0; }
        input { width: 100%; padding: 10px; font-size: 16px; border: 2px solid #ddd; border-radius: 5px; }
        button { background: #667eea; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; margin-top: 10px; }
        button:hover { background: #5568d3; }
    </style>
</head>
<body>
    <h2>🤖 Simple Bot Test</h2>
    <p>Type a message and press Send to test the bot:</p>
    
    <input type="text" id="messageInput" placeholder="Type your message here..." onkeypress="if(event.key==='Enter') sendMessage()">
    <button onclick="sendMessage()">Send Message</button>
    
    <div id="chat"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const sessionId = 'test_' + Date.now();
        
        function sendMessage() {
            const input = document.getElementById('messageInput');
            const message = input.value.trim();
            
            if (!message) return;
            
            // Show user message
            addMessage('user', message);
            input.value = '';
            
            // Send to bot
            $.ajax({
                url: 'index.php/bot/send_message',
                method: 'POST',
                data: {
                    message: message,
                    session_id: sessionId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success && response.message) {
                        addMessage('bot', response.message);
                        
                        // Show suggestions if any
                        if (response.suggestions && response.suggestions.length > 0) {
                            let suggestionsHtml = '<div style="margin-top: 10px;">';
                            response.suggestions.forEach(s => {
                                suggestionsHtml += `<button onclick="sendMessage('${s}')" style="margin: 5px; padding: 5px 10px; font-size: 14px;">${s}</button>`;
                            });
                            suggestionsHtml += '</div>';
                            document.getElementById('chat').lastChild.innerHTML += suggestionsHtml;
                        }
                    } else {
                        addMessage('bot', 'Error: ' + (response.error || 'Unknown error'));
                    }
                },
                error: function(xhr, status, error) {
                    addMessage('bot', '❌ Connection error: ' + error + '\n\nResponse: ' + xhr.responseText);
                }
            });
        }
        
        function addMessage(sender, text) {
            const chat = document.getElementById('chat');
            const div = document.createElement('div');
            div.className = 'message ' + sender;
            div.innerHTML = '<strong>' + (sender === 'user' ? 'You' : 'Bot') + ':</strong><br>' + text.replace(/\n/g, '<br>');
            chat.appendChild(div);
            div.scrollIntoView({ behavior: 'smooth' });
        }
        
        // Auto-send test message
        window.onload = function() {
            document.getElementById('messageInput').value = 'Hello';
            setTimeout(() => sendMessage(), 500);
        };
    </script>
</body>
</html>
