# Quick Integration Example

## Adding Chatbot to Login Page

Here's a simple example of how to add the chatbot widget to your login page:

### Before (Original login.php ending):
```php
    </div>
  </div>
</body>
</html>
```

### After (With Chatbot):
```php
    </div>
  </div>

  <!-- AI Chatbot Widget -->
  <?php $this->load->view('chatbot_widget'); ?>

</body>
</html>
```

That's it! Just add one line before `</body>`.

---

## Adding to Multiple Pages

### 1. Login Page
File: `application/views/login.php`
```php
<?php $this->load->view('chatbot_widget'); ?>
</body>
</html>
```

### 2. Signup Page
File: `application/views/signup.php`
```php
<?php $this->load->view('chatbot_widget'); ?>
</body>
</html>
```

### 3. Admin Dashboard
File: `application/views/Admin_dashboard_view/admin_dashboard.php`
```php
<?php $this->load->view('chatbot_widget'); ?>
</body>
</html>
```

### 4. Recruiter Dashboard
File: `application/views/Recruiter_dashboard_view/recruiter_dashboard.php`
```php
<?php $this->load->view('chatbot_widget'); ?>
</body>
</html>
```

---

## Testing the Chatbot

### 1. Setup Database
```bash
# Import the SQL file
mysql -u root -p rmsdb < Database/chatbot_schema.sql
```

### 2. Configure API Key
Edit `application/config/chatbot.php`:
```php
$config['api_key'] = 'sk-your-openai-api-key-here';
```

### 3. Add to a Page
Edit `application/views/login.php` and add before `</body>`:
```php
<?php $this->load->view('chatbot_widget'); ?>
```

### 4. Test It
1. Open: `http://localhost/rms/login`
2. Look for chat button in bottom-right corner
3. Click it and type: "What job openings do you have?"
4. The AI should respond!

---

## Sample Questions to Test

Try asking the chatbot:
- "What job openings do you have?"
- "How do I apply for a position?"
- "What's the interview process like?"
- "Tell me about company culture"
- "How long does the hiring process take?"
- "What documents do I need to apply?"

---

## Customizing for Your Company

Edit the system prompt in `application/controllers/Chatbot.php`:

```php
private function _get_system_prompt() {
    return "You are a helpful Recruitment Officer AI assistant for [YOUR COMPANY NAME]. 
    
    Our company specializes in [YOUR INDUSTRY].
    
    Current open positions:
    - Software Engineer (3 openings)
    - Product Manager (1 opening)
    - UX Designer (2 openings)
    
    Application process:
    1. Submit resume through our portal
    2. Initial screening call (1 week)
    3. Technical interview (2 weeks)
    4. Final interview with team (3 weeks)
    5. Offer decision (4 weeks)
    
    Benefits:
    - Health insurance
    - 401k matching
    - Remote work options
    - Professional development budget
    
    Be professional, friendly, and encouraging. If you don't know something specific, 
    suggest contacting HR at hr@yourcompany.com";
}
```

This way, the AI will have context about your actual company and can provide accurate information!

---

## Quick Troubleshooting

### Chatbot button doesn't appear?
1. Check browser console (F12) for errors
2. Verify `Assets/js/chatbot.js` exists
3. Clear browser cache

### "API key not configured" error?
1. Check `application/config/chatbot.php`
2. Make sure API key starts with `sk-`
3. Get key from: https://platform.openai.com/api-keys

### Database errors?
1. Run the SQL file: `Database/chatbot_schema.sql`
2. Check database name is `rmsdb`
3. Verify database connection in `application/config/database.php`

---

## Cost Estimate

Using GPT-3.5-turbo:
- 100 conversations/day = ~$0.20/day = ~$6/month
- 500 conversations/day = ~$1/day = ~$30/month
- 1000 conversations/day = ~$2/day = ~$60/month

Very affordable for most use cases!

---

That's all you need to get started! 🚀
