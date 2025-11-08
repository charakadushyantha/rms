# 🤖 AI Recruitment Officer Chatbot

A complete AI-powered chatbot integration for your CodeIgniter Recruitment Management System.

## ✨ What's Included

### Backend (CodeIgniter)
- **`application/controllers/Chatbot.php`** - Main chatbot API controller
- **`application/controllers/Admin_chatbot.php`** - Admin panel for viewing chat logs
- **`application/controllers/Chatbot_test.php`** - Test page controller
- **`application/models/Chatbot_model.php`** - Database operations
- **`application/config/chatbot.php`** - Configuration file

### Frontend
- **`Assets/js/chatbot.js`** - Chat widget JavaScript (vanilla JS, no dependencies)
- **`application/views/chatbot_widget.php`** - Widget include file
- **`application/views/chatbot_test.php`** - Test page
- **`application/views/Admin_dashboard_view/admin_chatbot_sessions.php`** - Admin sessions list
- **`application/views/Admin_dashboard_view/admin_chatbot_detail.php`** - Admin session detail

### Database
- **`Database/chatbot_schema.sql`** - Database schema (3 tables)

### Documentation
- **`CHATBOT_SETUP_GUIDE.md`** - Complete setup instructions
- **`CHATBOT_INTEGRATION_EXAMPLE.md`** - Quick integration examples

---

## 🚀 Quick Start (5 Minutes)

### 1. Create Database Tables
```bash
mysql -u root -p rmsdb < Database/chatbot_schema.sql
```

### 2. Get OpenAI API Key
- Visit: https://platform.openai.com/api-keys
- Create new API key
- Copy it (starts with `sk-`)

### 3. Configure
Edit `application/config/chatbot.php`:
```php
$config['api_key'] = 'sk-your-actual-key-here';
```

### 4. Test
Visit: `http://localhost/rms/chatbot_test`

### 5. Add to Your Pages
Add before `</body>` tag:
```php
<?php $this->load->view('chatbot_widget'); ?>
```

Done! 🎉

---

## 📁 Files Created

```
application/
├── controllers/
│   ├── Chatbot.php              (Main API)
│   ├── Admin_chatbot.php        (Admin panel)
│   └── Chatbot_test.php         (Test page)
├── models/
│   └── Chatbot_model.php        (Database)
├── config/
│   └── chatbot.php              (Settings)
└── views/
    ├── chatbot_widget.php       (Widget include)
    ├── chatbot_test.php         (Test page)
    └── Admin_dashboard_view/
        ├── admin_chatbot_sessions.php
        └── admin_chatbot_detail.php

Assets/
└── js/
    └── chatbot.js               (Frontend widget)

Database/
└── chatbot_schema.sql           (Database tables)

Documentation/
├── CHATBOT_SETUP_GUIDE.md       (Full guide)
├── CHATBOT_INTEGRATION_EXAMPLE.md
└── CHATBOT_README.md            (This file)
```

---

## 🎯 Features

### For Users
- ✅ Real-time AI conversations
- ✅ Context-aware responses
- ✅ Chat history persistence
- ✅ Mobile responsive
- ✅ Clean, modern UI
- ✅ No page reload needed

### For Admins
- ✅ View all chat sessions
- ✅ Read full conversations
- ✅ Track user types (guest/candidate/recruiter/admin)
- ✅ Monitor AI performance
- ✅ Export capabilities

### Technical
- ✅ OpenAI GPT-3.5/GPT-4 integration
- ✅ Session management
- ✅ Message history
- ✅ Feedback system
- ✅ Error handling
- ✅ Security (XSS protection, input sanitization)

---

## 💰 Cost

Using GPT-3.5-turbo (recommended):
- **~$0.002 per conversation**
- **~$6/month for 100 conversations/day**
- **~$30/month for 500 conversations/day**

Very affordable! Start with GPT-3.5-turbo, upgrade to GPT-4 if needed.

---

## 🔧 Configuration Options

In `application/config/chatbot.php`:

```php
// AI Provider
$config['provider'] = 'openai';

// API Key
$config['api_key'] = 'sk-your-key';

// Model (gpt-3.5-turbo or gpt-4)
$config['model'] = 'gpt-3.5-turbo';

// Widget Appearance
$config['widget_position'] = 'bottom-right';  // or 'bottom-left'
$config['widget_color'] = '#007bff';          // Your brand color
$config['widget_title'] = 'Recruitment Assistant';
$config['welcome_message'] = 'Hi! How can I help?';
```

---

## 📊 Database Tables

### `chat_sessions`
Stores chat session information
- session_id, user_id, user_type, ip_address, timestamps

### `chat_messages`
Stores all messages
- session_id, role (user/assistant), message, timestamp

### `chat_feedback`
Stores user feedback (optional)
- message_id, rating, comment

---

## 🔗 URLs

- **Test Page**: `http://localhost/rms/chatbot_test`
- **Admin Panel**: `http://localhost/rms/admin_chatbot`
- **API Endpoint**: `http://localhost/rms/chatbot/send_message`

---

## 🎨 Customization

### Change AI Personality
Edit `application/controllers/Chatbot.php`:
```php
private function _get_system_prompt() {
    return "You are a helpful Recruitment Officer for [YOUR COMPANY]...";
}
```

### Change Widget Colors
Edit `application/config/chatbot.php`:
```php
$config['widget_color'] = '#ff6b6b';  // Red
$config['widget_color'] = '#51cf66';  // Green
$config['widget_color'] = '#339af0';  // Blue
```

### Add to Specific Pages
```php
// Login page
application/views/login.php

// Signup page
application/views/signup.php

// Dashboard
application/views/Admin_dashboard_view/admin_dashboard.php
```

---

## 🐛 Troubleshooting

### Chat button not appearing?
1. Check browser console (F12)
2. Verify `Assets/js/chatbot.js` exists
3. Clear cache

### API errors?
1. Check API key in config
2. Verify key at https://platform.openai.com
3. Check `application/logs/`

### Database errors?
1. Run SQL file
2. Check database connection
3. Verify table names

---

## 📚 Documentation

- **Full Setup Guide**: `CHATBOT_SETUP_GUIDE.md`
- **Integration Examples**: `CHATBOT_INTEGRATION_EXAMPLE.md`
- **Test Page**: Visit `/chatbot_test`

---

## 🔒 Security

- ✅ Input sanitization
- ✅ XSS protection
- ✅ SQL injection prevention
- ✅ Session management
- ✅ Admin authentication
- ✅ API key protection

---

## 🚀 Next Steps

1. **Customize the AI prompt** with your company info
2. **Add to key pages** (login, signup, dashboards)
3. **Test with real questions**
4. **Monitor in admin panel**
5. **Gather user feedback**
6. **Iterate and improve**

---

## 💡 Pro Tips

1. **Start with GPT-3.5-turbo** - It's fast and cheap
2. **Customize the system prompt** - Add your company details
3. **Monitor conversations** - Use admin panel to improve responses
4. **Add quick replies** - Common questions as buttons
5. **Use HTTPS in production** - Encrypt conversations

---

## 📞 Support

Check these resources:
1. `CHATBOT_SETUP_GUIDE.md` - Detailed instructions
2. `CHATBOT_INTEGRATION_EXAMPLE.md` - Code examples
3. Test page at `/chatbot_test` - Verify setup
4. Browser console (F12) - Check for errors
5. `application/logs/` - Server-side errors

---

## 🎉 You're All Set!

The chatbot is ready to use. Just:
1. Import the SQL
2. Add your API key
3. Include the widget
4. Start chatting!

**Happy recruiting! 🚀**
