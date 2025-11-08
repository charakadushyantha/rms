# AI Chatbot Integration Guide
## Recruitment Officer AI Assistant

This guide will help you integrate an AI-powered chatbot into your CodeIgniter recruitment management system.

---

## 🚀 Features

- **Real-time AI Conversations** - Powered by OpenAI GPT
- **Context-Aware Responses** - Maintains conversation history
- **User-Friendly Widget** - Modern, responsive chat interface
- **Session Management** - Tracks all conversations
- **Admin Dashboard** - Monitor and review chat logs
- **Multi-User Support** - Works for guests, candidates, recruiters, and admins
- **Customizable** - Easy to configure colors, position, and messages

---

## 📋 Prerequisites

1. PHP 7.0 or higher
2. MySQL database
3. OpenAI API key (get one at https://platform.openai.com/api-keys)
4. CodeIgniter 3.x (already installed)

---

## 🔧 Installation Steps

### Step 1: Create Database Tables

Run the SQL script to create the necessary tables:

```bash
mysql -u root -p rmsdb < Database/chatbot_schema.sql
```

Or manually execute the SQL in phpMyAdmin:
- Open `Database/chatbot_schema.sql`
- Copy and run the SQL commands

This creates three tables:
- `chat_sessions` - Stores chat session information
- `chat_messages` - Stores all messages
- `chat_feedback` - Stores user feedback (optional)

### Step 2: Configure API Key

Edit `application/config/chatbot.php` and add your OpenAI API key:

```php
$config['api_key'] = 'sk-your-actual-api-key-here';
```

**Important:** Keep your API key secure! For production, use environment variables:

```php
$config['api_key'] = getenv('OPENAI_API_KEY');
```

### Step 3: Customize Settings (Optional)

In `application/config/chatbot.php`, you can customize:

```php
$config['model'] = 'gpt-3.5-turbo';  // or 'gpt-4' for better responses
$config['widget_position'] = 'bottom-right';  // or 'bottom-left'
$config['widget_color'] = '#007bff';  // Your brand color
$config['widget_title'] = 'Recruitment Assistant';
$config['welcome_message'] = 'Hi! How can I help you today?';
```

### Step 4: Add Widget to Your Pages

Add the chatbot widget to any page by including this line before the closing `</body>` tag:

```php
<?php $this->load->view('chatbot_widget'); ?>
```

**Example locations:**
- `application/views/login.php`
- `application/views/signup.php`
- `application/views/Admin_dashboard_view/admin_dashboard.php`
- `application/views/Recruiter_dashboard_view/recruiter_dashboard.php`

### Step 5: Update Routes (Optional)

Add these routes to `application/config/routes.php` for cleaner URLs:

```php
$route['chatbot/send'] = 'chatbot/send_message';
$route['chatbot/history'] = 'chatbot/get_history';
$route['admin/chatbot'] = 'admin_chatbot/index';
$route['admin/chatbot/(:any)'] = 'admin_chatbot/view_session/$1';
```

---

## 🎨 Usage

### For End Users

1. Click the chat button in the bottom-right corner
2. Type your question and press Enter or click Send
3. The AI will respond with helpful information
4. Clear chat history using the trash icon

### For Admins

1. Navigate to: `http://localhost/rms/admin_chatbot`
2. View all chat sessions
3. Click "View" to see full conversation details
4. Monitor user interactions and AI responses

---

## 💡 Customization

### Change AI Personality

Edit the system prompt in `application/controllers/Chatbot.php`:

```php
private function _get_system_prompt() {
    return "You are a helpful Recruitment Officer...";
}
```

### Add Custom Responses

You can add rule-based responses before calling the AI:

```php
// In Chatbot.php, before calling _get_ai_response()
$message_lower = strtolower($message);

if (strpos($message_lower, 'job openings') !== false) {
    return [
        'success' => true,
        'message' => 'We have several positions open! Visit our careers page...'
    ];
}
```

### Change Widget Appearance

Edit `Assets/js/chatbot.js` to modify:
- Colors and styling
- Animation effects
- Message formatting
- Button positions

---

## 🔒 Security Best Practices

1. **Protect API Key**: Never commit API keys to version control
2. **Rate Limiting**: Consider adding rate limits to prevent abuse
3. **Input Validation**: The system already sanitizes inputs
4. **HTTPS**: Use HTTPS in production to encrypt conversations
5. **Access Control**: Admin panel requires authentication

---

## 💰 Cost Considerations

OpenAI API pricing (as of 2024):
- **GPT-3.5-turbo**: ~$0.002 per 1K tokens (very affordable)
- **GPT-4**: ~$0.03 per 1K tokens (more expensive but better)

Average conversation: 500-1000 tokens
Estimated cost: $0.001 - $0.03 per conversation

**Tip:** Start with GPT-3.5-turbo for cost-effectiveness.

---

## 🐛 Troubleshooting

### Chatbot doesn't appear
- Check if `chatbot.js` is loaded (view page source)
- Verify `chatbot_widget.php` is included
- Check browser console for JavaScript errors

### "API key not configured" error
- Verify API key in `application/config/chatbot.php`
- Ensure key starts with `sk-`
- Test key at https://platform.openai.com/playground

### Messages not saving
- Check database tables exist
- Verify database connection in `application/config/database.php`
- Check `application/logs` for errors

### AI responses are slow
- Normal for first request (cold start)
- Consider using GPT-3.5-turbo instead of GPT-4
- Check your internet connection

---

## 🔄 Alternative AI Providers

Want to use a different AI service? Modify `_get_ai_response()` in `Chatbot.php`:

### Anthropic Claude
```php
private function _call_anthropic($api_key, $model, $messages) {
    // Implementation for Claude API
}
```

### Local LLM (Ollama)
```php
private function _call_ollama($model, $messages) {
    // Implementation for local Ollama
}
```

---

## 📊 Analytics & Monitoring

Track chatbot performance:

```sql
-- Most active users
SELECT user_type, COUNT(*) as sessions 
FROM chat_sessions 
GROUP BY user_type;

-- Average messages per session
SELECT AVG(message_count) 
FROM (
    SELECT session_id, COUNT(*) as message_count 
    FROM chat_messages 
    GROUP BY session_id
) as counts;

-- Popular topics (requires text analysis)
SELECT message, COUNT(*) as frequency 
FROM chat_messages 
WHERE role = 'user' 
GROUP BY message 
ORDER BY frequency DESC 
LIMIT 10;
```

---

## 🎯 Next Steps

1. **Train on Your Data**: Customize the system prompt with company-specific info
2. **Add Quick Replies**: Implement suggested questions
3. **Multi-language**: Add language detection and translation
4. **Voice Input**: Integrate speech-to-text
5. **Analytics Dashboard**: Build detailed reporting
6. **Email Integration**: Send transcripts to users
7. **Sentiment Analysis**: Track user satisfaction

---

## 📞 Support

For issues or questions:
1. Check the troubleshooting section
2. Review CodeIgniter logs in `application/logs/`
3. Test API key at OpenAI playground
4. Check browser console for JavaScript errors

---

## 📝 License

This chatbot integration is part of your recruitment management system.

---

**Happy Recruiting! 🎉**
