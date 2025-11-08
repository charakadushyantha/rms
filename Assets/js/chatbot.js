/**
 * AI Chatbot Widget for Recruitment System
 */
class RecruitmentChatbot {
    constructor(config = {}) {
        this.config = {
            baseUrl: config.baseUrl || window.location.origin + '/rms/',
            position: config.position || 'bottom-right',
            color: config.color || '#007bff',
            title: config.title || 'Recruitment Assistant',
            welcomeMessage: config.welcomeMessage || 'Hi! How can I help you today?',
            ...config
        };
        
        this.isOpen = false;
        this.messages = [];
        this.init();
    }

    init() {
        this.createWidget();
        this.attachEventListeners();
        this.loadHistory();
    }

    createWidget() {
        const widgetHTML = `
            <div id="chatbot-widget" class="chatbot-widget ${this.config.position}">
                <!-- Chat Button -->
                <button id="chatbot-toggle" class="chatbot-toggle" style="background-color: ${this.config.color}">
                    <svg class="chatbot-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                    </svg>
                    <svg class="chatbot-close-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>

                <!-- Chat Window -->
                <div id="chatbot-window" class="chatbot-window">
                    <div class="chatbot-header" style="background-color: ${this.config.color}">
                        <h3>${this.config.title}</h3>
                        <button id="chatbot-clear" class="chatbot-clear-btn" title="Clear chat">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            </svg>
                        </button>
                    </div>
                    <div id="chatbot-messages" class="chatbot-messages">
                        <div class="chatbot-message assistant">
                            <div class="message-content">${this.config.welcomeMessage}</div>
                        </div>
                    </div>
                    <div class="chatbot-input-area">
                        <input type="text" id="chatbot-input" placeholder="Type your message..." />
                        <button id="chatbot-send" style="background-color: ${this.config.color}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="22" y1="2" x2="11" y2="13"></line>
                                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', widgetHTML);
        this.injectStyles();
    }

    injectStyles() {
        const styles = `
            <style>
                .chatbot-widget {
                    position: fixed;
                    z-index: 9999;
                }
                .chatbot-widget.bottom-right {
                    bottom: 20px;
                    right: 20px;
                }
                .chatbot-widget.bottom-left {
                    bottom: 20px;
                    left: 20px;
                }
                .chatbot-toggle {
                    width: 60px;
                    height: 60px;
                    border-radius: 50%;
                    border: none;
                    color: white;
                    cursor: pointer;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                    transition: transform 0.3s;
                }
                .chatbot-toggle:hover {
                    transform: scale(1.1);
                }
                .chatbot-toggle svg {
                    width: 28px;
                    height: 28px;
                }
                .chatbot-icon {
                    display: block;
                }
                .chatbot-close-icon {
                    display: none;
                }
                .chatbot-widget.open .chatbot-icon {
                    display: none;
                }
                .chatbot-widget.open .chatbot-close-icon {
                    display: block;
                }
                .chatbot-window {
                    position: absolute;
                    bottom: 80px;
                    right: 0;
                    width: 380px;
                    height: 500px;
                    background: white;
                    border-radius: 12px;
                    box-shadow: 0 8px 24px rgba(0,0,0,0.15);
                    display: none;
                    flex-direction: column;
                }
                .chatbot-widget.open .chatbot-window {
                    display: flex;
                }
                .chatbot-header {
                    padding: 16px;
                    color: white;
                    border-radius: 12px 12px 0 0;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                }
                .chatbot-header h3 {
                    margin: 0;
                    font-size: 18px;
                    font-weight: 600;
                }
                .chatbot-clear-btn {
                    background: transparent;
                    border: none;
                    color: white;
                    cursor: pointer;
                    padding: 4px;
                    width: 28px;
                    height: 28px;
                }
                .chatbot-clear-btn svg {
                    width: 20px;
                    height: 20px;
                }
                .chatbot-messages {
                    flex: 1;
                    overflow-y: auto;
                    padding: 16px;
                    background: #f8f9fa;
                }
                .chatbot-message {
                    margin-bottom: 12px;
                    display: flex;
                }
                .chatbot-message.user {
                    justify-content: flex-end;
                }
                .message-content {
                    max-width: 75%;
                    padding: 10px 14px;
                    border-radius: 12px;
                    word-wrap: break-word;
                }
                .chatbot-message.user .message-content {
                    background: ${this.config.color};
                    color: white;
                    border-bottom-right-radius: 4px;
                }
                .chatbot-message.assistant .message-content {
                    background: white;
                    color: #333;
                    border-bottom-left-radius: 4px;
                    box-shadow: 0 1px 2px rgba(0,0,0,0.1);
                }
                .chatbot-message.typing .message-content {
                    background: white;
                    padding: 14px;
                }
                .typing-indicator {
                    display: flex;
                    gap: 4px;
                }
                .typing-indicator span {
                    width: 8px;
                    height: 8px;
                    background: #999;
                    border-radius: 50%;
                    animation: typing 1.4s infinite;
                }
                .typing-indicator span:nth-child(2) {
                    animation-delay: 0.2s;
                }
                .typing-indicator span:nth-child(3) {
                    animation-delay: 0.4s;
                }
                @keyframes typing {
                    0%, 60%, 100% { transform: translateY(0); }
                    30% { transform: translateY(-10px); }
                }
                .chatbot-input-area {
                    display: flex;
                    padding: 12px;
                    border-top: 1px solid #e0e0e0;
                    background: white;
                    border-radius: 0 0 12px 12px;
                }
                #chatbot-input {
                    flex: 1;
                    border: 1px solid #e0e0e0;
                    border-radius: 20px;
                    padding: 10px 16px;
                    font-size: 14px;
                    outline: none;
                }
                #chatbot-input:focus {
                    border-color: ${this.config.color};
                }
                #chatbot-send {
                    margin-left: 8px;
                    width: 40px;
                    height: 40px;
                    border-radius: 50%;
                    border: none;
                    color: white;
                    cursor: pointer;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
                #chatbot-send svg {
                    width: 20px;
                    height: 20px;
                }
                #chatbot-send:disabled {
                    opacity: 0.5;
                    cursor: not-allowed;
                }
                @media (max-width: 480px) {
                    .chatbot-window {
                        width: calc(100vw - 40px);
                        height: calc(100vh - 100px);
                    }
                }
            </style>
        `;
        document.head.insertAdjacentHTML('beforeend', styles);
    }

    attachEventListeners() {
        const toggle = document.getElementById('chatbot-toggle');
        const send = document.getElementById('chatbot-send');
        const input = document.getElementById('chatbot-input');
        const clear = document.getElementById('chatbot-clear');

        toggle.addEventListener('click', () => this.toggleChat());
        send.addEventListener('click', () => this.sendMessage());
        input.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') this.sendMessage();
        });
        clear.addEventListener('click', () => this.clearChat());
    }

    toggleChat() {
        this.isOpen = !this.isOpen;
        const widget = document.getElementById('chatbot-widget');
        widget.classList.toggle('open');
        
        if (this.isOpen) {
            document.getElementById('chatbot-input').focus();
        }
    }

    async sendMessage() {
        const input = document.getElementById('chatbot-input');
        const message = input.value.trim();
        
        if (!message) return;

        // Add user message to UI
        this.addMessage('user', message);
        input.value = '';

        // Show typing indicator
        this.showTyping();

        // Send to backend
        try {
            const response = await fetch(this.config.baseUrl + 'chatbot/send_message', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ message })
            });

            const data = await response.json();
            this.hideTyping();

            if (data.success) {
                this.addMessage('assistant', data.message);
            } else {
                this.addMessage('assistant', 'Sorry, I encountered an error. Please try again.');
            }
        } catch (error) {
            this.hideTyping();
            this.addMessage('assistant', 'Sorry, I\'m having trouble connecting. Please try again later.');
        }
    }

    addMessage(role, content) {
        const messagesDiv = document.getElementById('chatbot-messages');
        const messageHTML = `
            <div class="chatbot-message ${role}">
                <div class="message-content">${this.escapeHtml(content)}</div>
            </div>
        `;
        messagesDiv.insertAdjacentHTML('beforeend', messageHTML);
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    }

    showTyping() {
        const messagesDiv = document.getElementById('chatbot-messages');
        const typingHTML = `
            <div class="chatbot-message assistant typing" id="typing-indicator">
                <div class="message-content">
                    <div class="typing-indicator">
                        <span></span><span></span><span></span>
                    </div>
                </div>
            </div>
        `;
        messagesDiv.insertAdjacentHTML('beforeend', typingHTML);
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    }

    hideTyping() {
        const typing = document.getElementById('typing-indicator');
        if (typing) typing.remove();
    }

    async loadHistory() {
        try {
            const response = await fetch(this.config.baseUrl + 'chatbot/get_history');
            const data = await response.json();
            
            if (data.success && data.messages.length > 0) {
                const messagesDiv = document.getElementById('chatbot-messages');
                messagesDiv.innerHTML = '';
                
                data.messages.forEach(msg => {
                    this.addMessage(msg.role, msg.message);
                });
            }
        } catch (error) {
            console.error('Failed to load chat history:', error);
        }
    }

    async clearChat() {
        if (!confirm('Clear chat history?')) return;
        
        try {
            await fetch(this.config.baseUrl + 'chatbot/clear_chat', { method: 'POST' });
            
            const messagesDiv = document.getElementById('chatbot-messages');
            messagesDiv.innerHTML = `
                <div class="chatbot-message assistant">
                    <div class="message-content">${this.config.welcomeMessage}</div>
                </div>
            `;
        } catch (error) {
            console.error('Failed to clear chat:', error);
        }
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
}

// Auto-initialize if config is provided
if (typeof chatbotConfig !== 'undefined') {
    // Initialize immediately if DOM is ready, otherwise wait
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            new RecruitmentChatbot(chatbotConfig);
        });
    } else {
        // DOM is already ready, initialize now
        new RecruitmentChatbot(chatbotConfig);
    }
}
