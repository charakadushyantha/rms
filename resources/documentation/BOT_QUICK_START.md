# 🤖 AI Chatbot - Quick Start Guide

## ⚡ Get Started in 3 Steps

### Step 1: Run Database Setup (2 minutes)

Open in your browser:
```
http://localhost/your-project/create_bot_tables.php
```

This creates all necessary database tables and adds sample data.

### Step 2: Test the Setup (1 minute)

Open the test page:
```
http://localhost/your-project/test_bot.php
```

Verify all checks pass ✅

### Step 3: Try the Bot! (30 seconds)

**Option A: Full Chat Interface**
```
http://localhost/your-project/index.php/bot
```

**Option B: Demo Page with Widget**
```
http://localhost/your-project/bot_demo.html
```

**Option C: Just the Widget**
```
http://localhost/your-project/index.php/bot/widget
```

## 🎯 What Can the Bot Do?

### For Candidates:
- ✅ Apply for jobs
- ✅ Upload and parse CVs (PDF, DOCX, TXT, images)
- ✅ Check application status
- ✅ Get job recommendations
- ✅ Schedule interviews
- ✅ Ask about company info

### For Recruiters:
- ✅ Search candidates
- ✅ View parsed CV data
- ✅ Get candidate summaries
- ✅ Track conversations
- ✅ View analytics

## 📁 Files Created

```
application/
├── controllers/
│   └── Bot.php                    ✅ Main controller
├── models/
│   ├── Bot_model.php              ✅ Configuration
│   ├── Chat_history_model.php    ✅ Conversations
│   ├── Knowledge_base_model.php  ✅ FAQs
│   └── Job_model.php              ✅ Job data
├── libraries/
│   ├── BotEngine.php             ✅ Core AI
│   ├── IntentRecognizer.php     ✅ Intent detection
│   ├── EntityExtractor.php      ✅ Data extraction
│   ├── CvParser.php             ✅ CV processing
│   └── AIService.php            ✅ OpenAI (optional)
├── helpers/
│   └── bot_helper.php           ✅ Utilities
└── views/
    └── bot/
        ├── chat_interface.php   ✅ Full page
        └── chat_widget.php      ✅ Floating widget

Setup Files:
├── create_bot_tables.php         ✅ Database setup
├── test_bot.php                  ✅ Test page
├── bot_demo.html                 ✅ Demo page
├── BOT_SETUP_GUIDE.md           ✅ Full docs
└── BOT_QUICK_START.md           ✅ This file
```

## 🚀 Embed Widget on Any Page

Add this code before `</body>`:

```html
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $.get('index.php/bot/widget', function(data) {
        $('body').append(data);
    });
});
</script>
```

## 🎨 Customize the Bot

### Change Bot Name
```sql
UPDATE bot_config 
SET config_value = 'YourBotName' 
WHERE config_key = 'bot_name';
```

### Change Welcome Message
```sql
UPDATE bot_config 
SET config_value = 'Your custom welcome message!' 
WHERE config_key = 'welcome_message';
```

### Add Knowledge Base Entry
```sql
INSERT INTO knowledge_base (category, question, answer, keywords)
VALUES (
    'company',
    'What are your office hours?',
    'We are open Monday to Friday, 9 AM to 5 PM.',
    '["hours", "office", "timing"]'
);
```

## 🧪 Test Features

### Test Job Application
1. Open chat
2. Type: "I want to apply for a job"
3. Bot shows available positions

### Test CV Upload
1. Click paperclip icon
2. Upload a CV (PDF/DOCX)
3. Bot extracts information

### Test Status Check
1. Type: "Check my application status"
2. Bot shows your applications

## 🔧 Troubleshooting

### Bot not showing?
- Check jQuery is loaded
- Open browser console for errors
- Verify `index.php/bot/widget` loads

### Database errors?
- Run `create_bot_tables.php`
- Check database credentials in `config/database.php`

### 404 errors?
- Check `.htaccess` exists
- Verify `mod_rewrite` is enabled
- Check CodeIgniter `base_url` in config

### CV upload fails?
- Create folder: `mkdir uploads/cvs`
- Set permissions: `chmod 755 uploads/cvs`
- Check file size limits in php.ini

## 📊 View Analytics

Admin dashboard (requires admin login):
```
http://localhost/your-project/index.php/bot/admin_dashboard
```

Shows:
- Total conversations
- Messages count
- Intent distribution
- CV processing stats

## 🎓 Add More Intents

```sql
INSERT INTO bot_intents (
    intent_name, 
    display_name, 
    description, 
    training_phrases, 
    action_handler
) VALUES (
    'salary_inquiry',
    'Salary Information',
    'User asking about salary',
    '["salary", "pay", "compensation", "how much"]',
    'handle_salary_inquiry'
);
```

Then add handler in `BotEngine.php`:
```php
case 'salary_inquiry':
    return $this->handle_salary_inquiry($entities);
```

## 🔐 Security Tips

1. **Production**: Set up HTTPS
2. **API Keys**: Store in environment variables
3. **File Uploads**: Validate file types
4. **Rate Limiting**: Add to prevent abuse
5. **Input Sanitization**: Already implemented ✅

## 📈 Next Steps

1. ✅ Run setup script
2. ✅ Test the bot
3. ✅ Customize messages
4. ✅ Add your job postings
5. ✅ Add company info to knowledge base
6. ✅ Embed widget on your site
7. ✅ Monitor analytics
8. ✅ Improve based on feedback

## 💡 Pro Tips

- Add more training phrases for better intent recognition
- Keep knowledge base updated
- Monitor chat history for common questions
- Use analytics to improve responses
- Test with real users early

## 🆘 Need Help?

1. Check `BOT_SETUP_GUIDE.md` for detailed docs
2. Run `test_bot.php` to diagnose issues
3. Check browser console for JavaScript errors
4. Review PHP error logs

## 🎉 You're Ready!

Your AI chatbot is now live and ready to assist candidates!

**Test it now:** Open `bot_demo.html` in your browser!
