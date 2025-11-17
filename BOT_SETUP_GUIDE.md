# AI Recruitment Bot - Setup Guide

## 🚀 Quick Start

### Step 1: Create Database Tables

Run the database setup script:
```
http://localhost/your-project/create_bot_tables.php
```

This will create all necessary tables:
- `bot_config` - Bot configuration settings
- `chat_sessions` - User chat sessions
- `chat_history` - Conversation history
- `bot_intents` - Intent definitions
- `bot_entities` - Entity definitions
- `knowledge_base` - FAQ and information
- `cv_processing_history` - CV parsing logs
- `bot_analytics` - Usage analytics
- `bot_feedback` - User feedback

### Step 2: Configure OpenAI API (Optional)

For advanced AI features, add your OpenAI API key:

1. Get API key from https://platform.openai.com/api-keys
2. Add to database:
```sql
INSERT INTO bot_config (config_key, config_value, config_type) 
VALUES ('openai_api_key', 'your-api-key-here', 'string');
```

Or set environment variable:
```
OPENAI_API_KEY=your-api-key-here
```

### Step 3: Create Upload Directory

```bash
mkdir -p uploads/cvs
chmod 755 uploads/cvs
```

### Step 4: Test the Bot

Access the chat interface:
```
http://localhost/your-project/index.php/bot
```

Or embed the widget on any page:
```
http://localhost/your-project/index.php/bot/widget
```

## 📁 File Structure

```
application/
├── controllers/
│   └── Bot.php                    # Main bot controller
├── models/
│   ├── Bot_model.php              # Bot configuration
│   ├── Chat_history_model.php    # Chat storage
│   └── Knowledge_base_model.php  # FAQ management
├── libraries/
│   ├── BotEngine.php             # Core AI logic
│   ├── IntentRecognizer.php     # Intent detection
│   ├── EntityExtractor.php      # Entity extraction
│   ├── CvParser.php             # CV processing
│   └── AIService.php            # OpenAI integration
├── helpers/
│   └── bot_helper.php           # Utility functions
└── views/
    └── bot/
        ├── chat_widget.php      # Chat widget
        ├── chat_interface.php   # Full chat page
        └── admin_dashboard.php  # Admin panel
```

## 🎯 Core Features

### 1. Intent Recognition
The bot recognizes these intents:
- `apply_job` - Job applications
- `job_inquiry` - Job information requests
- `status_check` - Application status
- `interview_scheduling` - Interview management
- `company_info` - Company information
- `general_question` - General queries

### 2. CV Processing
Supports multiple formats:
- PDF files
- DOCX files
- TXT files
- Image files (with OCR)

Extracts:
- Personal information
- Education history
- Work experience
- Skills (technical & soft)
- Languages
- Certifications

### 3. Knowledge Base
Store and retrieve:
- Company information
- Process guidelines
- Benefits information
- FAQs

### 4. Analytics
Track:
- Total conversations
- Messages per session
- Intent distribution
- CV processing stats
- User satisfaction

## 🔧 Configuration

### Bot Settings

Update in `bot_config` table:

```sql
-- Bot name
UPDATE bot_config SET config_value = 'YourBotName' WHERE config_key = 'bot_name';

-- Welcome message
UPDATE bot_config SET config_value = 'Your custom welcome message' 
WHERE config_key = 'welcome_message';

-- Enable/disable CV parsing
UPDATE bot_config SET config_value = 'true' WHERE config_key = 'enable_cv_parsing';

-- Enable/disable auto job matching
UPDATE bot_config SET config_value = 'true' WHERE config_key = 'enable_auto_matching';
```

### Add Custom Intents

```sql
INSERT INTO bot_intents (intent_name, display_name, description, training_phrases, action_handler)
VALUES (
    'custom_intent',
    'Custom Intent',
    'Description of what this intent does',
    '["phrase 1", "phrase 2", "phrase 3"]',
    'handle_custom_intent'
);
```

### Add Knowledge Base Entries

```sql
INSERT INTO knowledge_base (category, question, answer, keywords)
VALUES (
    'company',
    'What are your working hours?',
    'Our standard working hours are 9 AM to 5 PM, Monday to Friday.',
    '["working hours", "office hours", "schedule"]'
);
```

## 🎨 Customization

### Embed Chat Widget

Add to any page:

```html
<!-- Add before </body> -->
<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
<script>
$(document).ready(function() {
    $.get('<?= base_url('bot/widget') ?>', function(data) {
        $('body').append(data);
    });
});
</script>
```

### Custom Styling

The chat widget uses CSS variables for easy customization:

```css
:root {
    --bot-primary-color: #667eea;
    --bot-secondary-color: #764ba2;
    --bot-text-color: #333;
    --bot-bg-color: #f5f6fa;
}
```

## 📊 Admin Dashboard

Access at: `http://localhost/your-project/index.php/bot/admin_dashboard`

Features:
- Real-time statistics
- Recent conversations
- Intent analysis
- Performance metrics

## 🔐 Security

### Input Validation
All user inputs are sanitized and validated.

### File Upload Security
- File type validation
- Size limits (5MB default)
- Encrypted file names
- Secure storage path

### API Security
- API keys stored securely
- Rate limiting recommended
- HTTPS required for production

## 🧪 Testing

### Test Intent Recognition

```php
$this->load->library('IntentRecognizer');
$result = $this->intentrecognizer->recognize("I want to apply for a job");
print_r($result);
```

### Test CV Parsing

```php
$this->load->library('CvParser');
$result = $this->cvparser->parse('/path/to/cv.pdf');
print_r($result);
```

### Test Bot Response

```php
$this->load->library('BotEngine');
$response = $this->botengine->process_message(
    "What jobs are available?",
    $user_id,
    $session_id
);
print_r($response);
```

## 📈 Performance Optimization

### Database Indexing
All tables have appropriate indexes for fast queries.

### Caching
Consider implementing Redis for:
- Session data
- Frequently accessed knowledge base
- Intent recognition results

### Queue Processing
For CV parsing, consider using a queue system:
- Faster response times
- Better resource management
- Scalability

## 🐛 Troubleshooting

### Bot not responding
1. Check database connection
2. Verify bot_config table has data
3. Check error logs

### CV parsing fails
1. Verify upload directory exists and is writable
2. Check file size limits
3. Ensure supported file format

### OpenAI errors
1. Verify API key is correct
2. Check API quota/limits
3. Review error messages in logs

## 🚀 Production Deployment

### Checklist
- [ ] Set up HTTPS
- [ ] Configure production database
- [ ] Set OpenAI API key (if using)
- [ ] Configure file upload limits
- [ ] Set up error logging
- [ ] Enable rate limiting
- [ ] Test all features
- [ ] Monitor performance
- [ ] Set up backups

### Environment Variables
```env
OPENAI_API_KEY=your-production-key
BOT_ENVIRONMENT=production
MAX_UPLOAD_SIZE=5242880
```

## 📚 API Endpoints

### Send Message
```
POST /bot/send_message
Body: {
    "message": "User message",
    "session_id": "session_123"
}
```

### Upload CV
```
POST /bot/upload_cv
Body: FormData with 'cv_file'
```

### Get Chat History
```
GET /bot/history?session_id=session_123
```

## 🎓 Training the Bot

### Improve Intent Recognition
1. Monitor misclassified intents
2. Add more training phrases
3. Adjust confidence thresholds

### Expand Knowledge Base
1. Collect common questions
2. Add detailed answers
3. Update regularly

### Optimize Responses
1. Analyze user feedback
2. A/B test different responses
3. Refine based on metrics

## 📞 Support

For issues or questions:
1. Check this documentation
2. Review error logs
3. Test with sample data
4. Check database tables

## 🎉 You're Ready!

Your AI Recruitment Bot is now set up and ready to assist candidates and recruiters!

Next steps:
1. Customize welcome message
2. Add your company information to knowledge base
3. Test with real job postings
4. Monitor and improve based on usage
