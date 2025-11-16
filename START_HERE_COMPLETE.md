# 🚀 RMS - Complete System Guide

## Welcome to Your Complete Recruitment Management System!

This guide will help you get started with all the newly implemented features.

---

## 📋 Table of Contents

1. [Quick Start](#quick-start)
2. [System Overview](#system-overview)
3. [Installation](#installation)
4. [Features](#features)
5. [Usage Guide](#usage-guide)
6. [API Documentation](#api-documentation)
7. [Troubleshooting](#troubleshooting)

---

## 🎯 Quick Start

### Step 1: Setup Database Tables

Run these scripts to create all necessary tables:

```bash
# Bot System Tables
php create_bot_tables.php

# Interview System Tables
php create_interview_tables.php
```

### Step 2: Access the System

Open your browser and navigate to:

```
http://localhost/rms/system_overview.html
```

This landing page provides access to all features!

### Step 3: Login

Use your existing RMS credentials to access the admin panel.

---

## 🎨 System Overview

### 1. 🤖 AI Recruitment Chatbot

**What it does:**
- Chats with candidates 24/7
- Parses CVs automatically (PDF, DOCX, TXT)
- Matches candidates to jobs
- Extracts contact information
- Answers common questions
- Tracks conversation history

**Access Points:**
- Main Interface: `/bot`
- Chat Widget: `/bot/chat`
- Standalone Demo: `bot_demo.html`

**Key Files:**
- Controller: `application/controllers/Bot.php`
- Engine: `application/libraries/BotEngine.php`
- Views: `application/views/bot/`

### 2. 🎯 Interview Management System

**What it does:**
- Creates interview templates (flows)
- Generates unique interview links
- Sends interviews to candidates
- Tracks responses and scores
- Provides analytics dashboard
- Manages interview lifecycle

**Access Points:**
- Dashboard: `/interview`
- Flows: `/interview/flows`
- Interviews: `/interview/interviews`

**Key Files:**
- Controller: `application/controllers/Interview.php`
- Models: `application/models/Interview_*.php`
- Views: `application/views/interview/`

---

## 💻 Installation

### Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- CodeIgniter 3.x (already included)

### Database Setup

1. **Create Database** (if not exists):
```sql
CREATE DATABASE rms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. **Configure Connection**:
Edit `config/database.php` with your credentials:
```php
$db['default'] = array(
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'rms',
);
```

3. **Run Setup Scripts**:
```bash
php create_bot_tables.php
php create_interview_tables.php
```

### Verify Installation

Visit: `http://localhost/rms/system_overview.html`

You should see the system overview page with all features accessible.

---

## ✨ Features

### AI Chatbot Features

#### 1. Intent Recognition
The bot understands various intents:
- Greetings
- Job inquiries
- CV submission
- Application status
- Company information
- Goodbye

#### 2. CV Parsing
Automatically extracts:
- Name
- Email
- Phone
- Skills
- Experience
- Education

Supported formats:
- PDF
- DOCX
- TXT

#### 3. Job Matching
- Matches candidates to suitable positions
- Considers skills and experience
- Provides job recommendations

#### 4. Conversation Tracking
- Stores all chat history
- Tracks user sessions
- Analyzes conversation patterns

### Interview System Features

#### 1. Interview Flows
- Create reusable templates
- Define custom questions
- Set time limits per question
- Configure passing scores
- Support multiple interview types (video/audio/text)

#### 2. Interview Management
- Generate unique candidate links
- Set expiration dates
- Track interview status
- Send email notifications
- View candidate responses

#### 3. Candidate Experience
- Clean, professional interface
- Progress tracking
- Timer display
- Auto-save responses
- Mobile-friendly

#### 4. Analytics
- Completion rates
- Average scores
- Time spent per question
- Interview statistics

---

## 📖 Usage Guide

### Using the AI Chatbot

#### For Administrators:

1. **Access the Bot Interface**:
   ```
   http://localhost/rms/bot
   ```

2. **View Chat History**:
   - All conversations are stored in the database
   - Access via `bot_conversations` and `bot_messages` tables

3. **Update Knowledge Base**:
   - Add FAQs to `bot_knowledge_base` table
   - Bot will use these for responses

#### For Candidates:

1. **Start Chatting**:
   - Visit the bot interface
   - Type your message
   - Upload CV when prompted

2. **Example Conversations**:
   ```
   Candidate: "Hello"
   Bot: "Hi! I'm here to help with your job application..."

   Candidate: "I want to apply for a job"
   Bot: "Great! Please tell me about your skills..."

   Candidate: [Uploads CV]
   Bot: "Thanks! I've analyzed your CV. Here are matching jobs..."
   ```

### Using the Interview System

#### Creating an Interview Flow:

1. **Navigate to Flows**:
   ```
   http://localhost/rms/interview/flows
   ```

2. **Click "Create New Flow"**

3. **Fill in Details**:
   - Job Title: "Senior Developer"
   - Interview Type: Video/Text/Audio
   - Duration: 30 minutes
   - Passing Score: 70%

4. **Add Questions**:
   - Click "Add Question"
   - Enter question text
   - Set duration per question
   - Repeat for all questions

5. **Save the Flow**

#### Sending an Interview:

1. **Navigate to Create Interview**:
   ```
   http://localhost/rms/interview/create_interview
   ```

2. **Select Flow**: Choose from your templates

3. **Enter Candidate Details**:
   - Name
   - Email
   - Phone (optional)

4. **Send**:
   - Check "Send email" to notify candidate
   - Copy the unique link
   - Share with candidate

#### Reviewing Responses:

1. **Go to Interviews List**:
   ```
   http://localhost/rms/interview/interviews
   ```

2. **Filter** by flow or status

3. **Click "View"** on any interview

4. **Review**:
   - Candidate responses
   - Time spent per question
   - Overall score
   - Status

---

## 🔌 API Documentation

### Bot API Endpoints

#### POST `/api/bot/chat`
Send a message to the bot

**Request:**
```json
{
    "message": "Hello",
    "session_id": "unique-session-id"
}
```

**Response:**
```json
{
    "success": true,
    "response": "Hi! How can I help you today?",
    "intent": "greeting"
}
```

#### POST `/api/bot/upload_cv`
Upload and parse a CV

**Request:**
- Multipart form data with file

**Response:**
```json
{
    "success": true,
    "parsed_data": {
        "name": "John Doe",
        "email": "john@example.com",
        "skills": ["PHP", "JavaScript"]
    }
}
```

### Interview API Endpoints

#### GET `/api/interview/flows`
Get all interview flows

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "job_title": "Senior Developer",
            "status": "active"
        }
    ]
}
```

#### POST `/api/interview/interviews`
Create a new interview

**Request:**
```json
{
    "flow_id": 1,
    "candidate_name": "Jane Smith",
    "candidate_email": "jane@example.com"
}
```

**Response:**
```json
{
    "success": true,
    "interview_id": 123,
    "token": "unique-token",
    "link": "http://localhost/rms/interview/take/unique-token"
}
```

For complete API documentation, see:
- `INTERVIEW_API_GUIDE.md`
- `BOT_QUICK_START.md`

---

## 🔧 Troubleshooting

### Common Issues

#### 1. Database Connection Error

**Problem:** "Unable to connect to database"

**Solution:**
- Check `config/database.php` credentials
- Verify MySQL is running
- Test connection: `php test_central_config.php`

#### 2. Bot Not Responding

**Problem:** Bot doesn't reply to messages

**Solution:**
- Check database tables exist: `php create_bot_tables.php`
- Verify session is active
- Check browser console for errors

#### 3. Interview Link Not Working

**Problem:** "Interview not found or link is invalid"

**Solution:**
- Check if interview exists in database
- Verify token is correct
- Check expiration date
- Ensure interview status is not "completed"

#### 4. CV Upload Fails

**Problem:** CV file won't upload

**Solution:**
- Check file size (max 5MB)
- Verify file format (PDF, DOCX, TXT)
- Check `uploads/` folder permissions
- Ensure PHP `upload_max_filesize` is sufficient

#### 5. Email Not Sending

**Problem:** Interview emails not delivered

**Solution:**
- Configure `config/email.php`
- Test email settings
- Check spam folder
- Verify SMTP credentials

### Debug Mode

Enable debug mode in `index.php`:
```php
define('ENVIRONMENT', 'development');
```

This will show detailed error messages.

### Check Logs

- PHP Error Log: Check your server's error log
- Application Log: `application/logs/`
- Browser Console: Check for JavaScript errors

---

## 📚 Additional Resources

### Documentation Files

- `BOT_SETUP_GUIDE.md` - Detailed bot setup
- `INTERVIEW_SYSTEM_COMPLETE.md` - Interview system guide
- `COMPLETE_SYSTEM_STATUS.md` - Overall system status
- `INTERVIEW_API_GUIDE.md` - API reference

### Test Files

- `test_bot.php` - Test bot functionality
- `test_interview_api.php` - Test interview API
- `bot_demo.html` - Standalone bot demo

### Setup Scripts

- `create_bot_tables.php` - Create bot tables
- `create_interview_tables.php` - Create interview tables
- `migrate_to_central_config.php` - Migrate DB config

---

## 🎓 Best Practices

### For Bot Usage

1. **Keep Knowledge Base Updated**
   - Add common questions and answers
   - Update regularly based on user queries

2. **Monitor Conversations**
   - Review chat logs periodically
   - Identify areas for improvement

3. **Test CV Parsing**
   - Try different CV formats
   - Verify extraction accuracy

### For Interview System

1. **Create Clear Questions**
   - Be specific and concise
   - Set appropriate time limits

2. **Set Realistic Passing Scores**
   - Consider question difficulty
   - Adjust based on results

3. **Monitor Completion Rates**
   - Track how many candidates complete
   - Optimize interview length

4. **Review Regularly**
   - Check candidate responses
   - Update flows based on feedback

---

## 🚀 Next Steps

### Immediate Actions

1. ✅ Run database setup scripts
2. ✅ Test the chatbot interface
3. ✅ Create your first interview flow
4. ✅ Generate a test interview
5. ✅ Complete a test interview as a candidate

### Customization

1. **Branding**
   - Update colors in CSS
   - Add your company logo
   - Customize welcome messages

2. **Email Templates**
   - Configure SMTP settings
   - Customize email content
   - Add company signature

3. **Knowledge Base**
   - Add company-specific FAQs
   - Include job descriptions
   - Update regularly

### Advanced Features

1. **Video Recording**
   - Implement actual video capture
   - Store video responses

2. **AI Scoring**
   - Add automated response evaluation
   - Use NLP for answer analysis

3. **Analytics**
   - Build custom reports
   - Track KPIs
   - Export data

---

## 💡 Tips & Tricks

### Chatbot Tips

- Use clear, conversational language
- Keep responses concise
- Provide helpful suggestions
- Always offer next steps

### Interview Tips

- Start with easier questions
- Mix question types
- Allow adequate time
- Provide clear instructions

---

## 📞 Support

### Getting Help

1. **Check Documentation**
   - Review relevant guide files
   - Check API documentation

2. **Test Scripts**
   - Run test files to verify functionality
   - Check database connections

3. **Debug Mode**
   - Enable development mode
   - Check error logs

4. **Database**
   - Verify tables exist
   - Check data integrity

---

## ✨ Summary

You now have a complete recruitment management system with:

- ✅ AI-powered chatbot
- ✅ CV parsing and analysis
- ✅ Interview management
- ✅ Candidate tracking
- ✅ Response scoring
- ✅ Email notifications
- ✅ Analytics dashboard
- ✅ REST API
- ✅ Modern UI

**Everything is ready to use!** 🎉

Start by visiting: `http://localhost/rms/system_overview.html`

---

**Version:** 1.0.0  
**Last Updated:** November 16, 2025  
**Status:** ✅ Production Ready
