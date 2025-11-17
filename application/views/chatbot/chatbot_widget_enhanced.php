<!-- Enhanced Chatbot Widget -->
<style>
/* Chatbot Button */
.chatbot-button {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 4px 20px rgba(102, 126, 234, 0.4);
    z-index: 9998;
    transition: all 0.3s ease;
}

.chatbot-button:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 30px rgba(102, 126, 234, 0.6);
}

.chatbot-button i {
    color: white;
    font-size: 24px;
}

.chatbot-button .notification-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #e74a3b;
    color: white;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 600;
}

/* Chatbot Container */
.chatbot-container {
    position: fixed;
    bottom: 100px;
    right: 30px;
    width: 380px;
    height: 600px;
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 50px rgba(0, 0, 0, 0.2);
    z-index: 9999;
    display: none;
    flex-direction: column;
    overflow: hidden;
    animation: slideUp 0.3s ease;
}

.chatbot-container.show {
    display: flex;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Chatbot Header */
.chatbot-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chatbot-header-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.chatbot-avatar {
    width: 40px;
    height: 40px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #667eea;
    font-size: 20px;
}

.chatbot-header-text h4 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
}

.chatbot-header-text p {
    margin: 0;
    font-size: 12px;
    opacity: 0.9;
}

.chatbot-close {
    background: none;
    border: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
    padding: 0;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: background 0.2s;
}

.chatbot-close:hover {
    background: rgba(255, 255, 255, 0.2);
}

/* Welcome Screen */
.chatbot-welcome {
    flex: 1;
    display: flex;
    flex-direction: column;
    padding: 30px;
    background: linear-gradient(180deg, #f7fafc 0%, #ffffff 100%);
}

.welcome-content {
    text-align: center;
    margin-bottom: 30px;
}

.welcome-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    color: white;
    font-size: 40px;
}

.welcome-content h3 {
    font-size: 20px;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 10px;
}

.welcome-content p {
    color: #718096;
    font-size: 14px;
    line-height: 1.6;
}

.new-chat-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 15px 30px;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: all 0.3s;
    margin-bottom: 20px;
}

.new-chat-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

.recent-chats {
    flex: 1;
    overflow-y: auto;
}

.recent-chats h4 {
    font-size: 14px;
    color: #718096;
    margin-bottom: 15px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.recent-chat-item {
    padding: 12px;
    background: white;
    border-radius: 10px;
    margin-bottom: 10px;
    cursor: pointer;
    transition: all 0.2s;
    border: 1px solid #e2e8f0;
}

.recent-chat-item:hover {
    background: #f7fafc;
    border-color: #667eea;
}

.recent-chat-title {
    font-size: 14px;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 4px;
}

.recent-chat-preview {
    font-size: 12px;
    color: #a0aec0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* User Info Form */
.chatbot-user-form {
    flex: 1;
    display: none;
    flex-direction: column;
    padding: 30px;
    background: linear-gradient(180deg, #f7fafc 0%, #ffffff 100%);
}

.chatbot-user-form.show {
    display: flex;
}

.form-header {
    text-align: center;
    margin-bottom: 30px;
}

.form-header h3 {
    font-size: 20px;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 10px;
}

.form-header p {
    color: #718096;
    font-size: 14px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 8px;
}

.form-group input {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    font-size: 14px;
    transition: all 0.2s;
}

.form-group input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.start-chat-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 15px 30px;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: all 0.3s;
    margin-top: 10px;
}

.start-chat-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

.back-btn {
    background: #f7fafc;
    color: #667eea;
    border: 2px solid #e2e8f0;
    padding: 12px 24px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    margin-top: 10px;
}

.back-btn:hover {
    background: #edf2f7;
    border-color: #667eea;
}

/* Chat Messages */
.chatbot-messages {
    flex: 1;
    display: none;
    flex-direction: column;
    background: #f7fafc;
}

.chatbot-messages.show {
    display: flex;
}

.messages-container {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
}

.message {
    display: flex;
    margin-bottom: 15px;
    animation: messageSlide 0.3s ease;
}

@keyframes messageSlide {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.message.bot {
    justify-content: flex-start;
}

.message.user {
    justify-content: flex-end;
}

.message-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
}

.message.bot .message-avatar {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    margin-right: 10px;
}

.message.user .message-avatar {
    background: #e2e8f0;
    color: #4a5568;
    margin-left: 10px;
}

.message-content {
    max-width: 70%;
    padding: 12px 16px;
    border-radius: 12px;
    font-size: 14px;
    line-height: 1.5;
}

.message.bot .message-content {
    background: white;
    color: #2d3748;
    border-bottom-left-radius: 4px;
}

.message.user .message-content {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-bottom-right-radius: 4px;
}

.message-time {
    font-size: 11px;
    color: #a0aec0;
    margin-top: 4px;
}

.typing-indicator {
    display: flex;
    gap: 4px;
    padding: 12px 16px;
}

.typing-dot {
    width: 8px;
    height: 8px;
    background: #cbd5e0;
    border-radius: 50%;
    animation: typing 1.4s infinite;
}

.typing-dot:nth-child(2) {
    animation-delay: 0.2s;
}

.typing-dot:nth-child(3) {
    animation-delay: 0.4s;
}

@keyframes typing {
    0%, 60%, 100% {
        transform: translateY(0);
    }
    30% {
        transform: translateY(-10px);
    }
}

/* Chat Input */
.chatbot-input {
    padding: 15px 20px;
    background: white;
    border-top: 1px solid #e2e8f0;
    display: flex;
    gap: 10px;
    align-items: center;
}

.chatbot-input input {
    flex: 1;
    padding: 12px 16px;
    border: 2px solid #e2e8f0;
    border-radius: 25px;
    font-size: 14px;
    transition: all 0.2s;
}

.chatbot-input input:focus {
    outline: none;
    border-color: #667eea;
}

.send-btn {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 50%;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.send-btn:hover {
    transform: scale(1.1);
}

.send-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Responsive */
@media (max-width: 768px) {
    .chatbot-container {
        width: 100%;
        height: 100%;
        bottom: 0;
        right: 0;
        border-radius: 0;
    }
    
    .chatbot-button {
        bottom: 20px;
        right: 20px;
    }
}
</style>

<!-- Chatbot Button -->
<div class="chatbot-button" id="chatbotButton">
    <i class="fas fa-comments"></i>
    <span class="notification-badge" style="display: none;">1</span>
</div>

<!-- Chatbot Container -->
<div class="chatbot-container" id="chatbotContainer">
    <!-- Header -->
    <div class="chatbot-header">
        <div class="chatbot-header-info">
            <div class="chatbot-avatar">
                <i class="fas fa-robot"></i>
            </div>
            <div class="chatbot-header-text">
                <h4>RMS Assistant</h4>
                <p>We're here to help!</p>
            </div>
        </div>
        <button class="chatbot-close" id="chatbotClose">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- Welcome Screen -->
    <div class="chatbot-welcome" id="welcomeScreen">
        <div class="welcome-content">
            <div class="welcome-icon">
                <i class="fas fa-comments"></i>
            </div>
            <h3>Have sales related questions? Let's talk!</h3>
            <p>We'd love to talk - we just need your name and email to connect you!</p>
        </div>

        <button class="new-chat-btn" id="newChatBtn">
            <i class="fas fa-plus"></i>
            New Conversation
            <small style="display: block; font-size: 11px; opacity: 0.8;">We typically reply in a few minutes</small>
        </button>

        <div class="recent-chats">
            <h4>Recent</h4>
            <div class="recent-chat-item" onclick="loadRecentChat(1)">
                <div class="recent-chat-title">RMS Support</div>
                <div class="recent-chat-preview">Thank you for visiting RMS! We'd love to...</div>
            </div>
        </div>
    </div>

    <!-- User Info Form -->
    <div class="chatbot-user-form" id="userInfoForm">
        <div class="form-header">
            <h3>We'd love to talk - we just need your name and email to connect you!</h3>
        </div>

        <form id="chatUserForm">
            <div class="form-group">
                <label>Name</label>
                <input type="text" id="userName" placeholder="Enter your name" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" id="userEmail" placeholder="Enter your email" required>
            </div>

            <button type="submit" class="start-chat-btn">
                <i class="fas fa-paper-plane"></i>
                Start Chat
            </button>

            <button type="button" class="back-btn" onclick="showWelcomeScreen()">
                <i class="fas fa-arrow-left"></i> Back
            </button>
        </form>
    </div>

    <!-- Chat Messages -->
    <div class="chatbot-messages" id="chatMessages">
        <div class="messages-container" id="messagesContainer">
            <!-- Messages will be added here -->
        </div>

        <div class="chatbot-input">
            <input type="text" id="messageInput" placeholder="Write a reply..." />
            <button class="send-btn" id="sendBtn">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>

<script>
// Chatbot State
let chatbotState = {
    isOpen: false,
    currentScreen: 'welcome', // welcome, userInfo, chat
    userName: '',
    userEmail: '',
    conversationId: null
};

// Toggle Chatbot
document.getElementById('chatbotButton').addEventListener('click', function() {
    toggleChatbot();
});

document.getElementById('chatbotClose').addEventListener('click', function() {
    toggleChatbot();
});

function toggleChatbot() {
    const container = document.getElementById('chatbotContainer');
    chatbotState.isOpen = !chatbotState.isOpen;
    
    if (chatbotState.isOpen) {
        container.classList.add('show');
    } else {
        container.classList.remove('show');
    }
}

// New Chat Button
document.getElementById('newChatBtn').addEventListener('click', function() {
    showUserInfoForm();
});

function showWelcomeScreen() {
    document.getElementById('welcomeScreen').style.display = 'flex';
    document.getElementById('userInfoForm').classList.remove('show');
    document.getElementById('chatMessages').classList.remove('show');
    chatbotState.currentScreen = 'welcome';
}

function showUserInfoForm() {
    document.getElementById('welcomeScreen').style.display = 'none';
    document.getElementById('userInfoForm').classList.add('show');
    document.getElementById('chatMessages').classList.remove('show');
    chatbotState.currentScreen = 'userInfo';
}

function showChatScreen() {
    document.getElementById('welcomeScreen').style.display = 'none';
    document.getElementById('userInfoForm').classList.remove('show');
    document.getElementById('chatMessages').classList.add('show');
    chatbotState.currentScreen = 'chat';
}

// User Info Form Submit
document.getElementById('chatUserForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const name = document.getElementById('userName').value;
    const email = document.getElementById('userEmail').value;
    
    if (name && email) {
        chatbotState.userName = name;
        chatbotState.userEmail = email;
        
        // Start chat
        startChat();
    }
});

function startChat() {
    showChatScreen();
    
    // Send welcome message
    setTimeout(() => {
        addBotMessage(`Hi ${chatbotState.userName}! 👋 Welcome to RMS. How can I help you today?`);
    }, 500);
}

// Send Message
document.getElementById('sendBtn').addEventListener('click', sendMessage);
document.getElementById('messageInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        sendMessage();
    }
});

function sendMessage() {
    const input = document.getElementById('messageInput');
    const message = input.value.trim();
    
    if (message) {
        addUserMessage(message);
        input.value = '';
        
        // Show typing indicator
        showTypingIndicator();
        
        // Simulate bot response
        setTimeout(() => {
            hideTypingIndicator();
            getBotResponse(message);
        }, 1500);
    }
}

function addUserMessage(message) {
    const container = document.getElementById('messagesContainer');
    const messageEl = document.createElement('div');
    messageEl.className = 'message user';
    messageEl.innerHTML = `
        <div class="message-content">
            ${escapeHtml(message)}
            <div class="message-time">${getCurrentTime()}</div>
        </div>
        <div class="message-avatar">
            <i class="fas fa-user"></i>
        </div>
    `;
    container.appendChild(messageEl);
    scrollToBottom();
}

function addBotMessage(message) {
    const container = document.getElementById('messagesContainer');
    const messageEl = document.createElement('div');
    messageEl.className = 'message bot';
    messageEl.innerHTML = `
        <div class="message-avatar">
            <i class="fas fa-robot"></i>
        </div>
        <div class="message-content">
            ${message}
            <div class="message-time">${getCurrentTime()}</div>
        </div>
    `;
    container.appendChild(messageEl);
    scrollToBottom();
}

function showTypingIndicator() {
    const container = document.getElementById('messagesContainer');
    const typingEl = document.createElement('div');
    typingEl.className = 'message bot';
    typingEl.id = 'typingIndicator';
    typingEl.innerHTML = `
        <div class="message-avatar">
            <i class="fas fa-robot"></i>
        </div>
        <div class="message-content">
            <div class="typing-indicator">
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
            </div>
        </div>
    `;
    container.appendChild(typingEl);
    scrollToBottom();
}

function hideTypingIndicator() {
    const typingEl = document.getElementById('typingIndicator');
    if (typingEl) {
        typingEl.remove();
    }
}

function getBotResponse(userMessage) {
    // Simple bot responses - Replace with actual AI/backend logic
    const responses = {
        'hello': 'Hello! How can I assist you with RMS today?',
        'hi': 'Hi there! What can I help you with?',
        'help': 'I can help you with:\n• Job postings\n• Candidate management\n• Interview scheduling\n• System features\n\nWhat would you like to know?',
        'default': 'Thank you for your message! Our team will get back to you shortly. Is there anything else I can help you with?'
    };
    
    const lowerMessage = userMessage.toLowerCase();
    let response = responses.default;
    
    for (let key in responses) {
        if (lowerMessage.includes(key)) {
            response = responses[key];
            break;
        }
    }
    
    addBotMessage(response);
}

function loadRecentChat(chatId) {
    // Load recent chat conversation
    showChatScreen();
    addBotMessage('Loading previous conversation...');
}

function getCurrentTime() {
    const now = new Date();
    return now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
}

function scrollToBottom() {
    const container = document.getElementById('messagesContainer');
    container.scrollTop = container.scrollHeight;
}

function escapeHtml(text) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, m => map[m]);
}
</script>