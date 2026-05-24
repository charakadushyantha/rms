# 10 Real Viva Questions Added to Questions Bank

## Date: May 24, 2026
## Status: ✅ READY TO IMPORT

---

## OVERVIEW

Added 10 realistic, professional viva (interview) questions covering various categories:
- **Technical Skills** (5 questions)
- **Behavioral** (3 questions)
- **Problem Solving** (2 questions)
- **Communication** (1 question)

All questions are **descriptive/open-ended** type, suitable for viva/oral interviews.

---

## QUESTIONS LIST

### 1. **Object-Oriented vs Functional Programming**
- **Category:** Technical Skills
- **Difficulty:** Medium
- **Points:** 10
- **Time Limit:** 5 minutes (300 seconds)
- **Question:** "Explain the difference between Object-Oriented Programming (OOP) and Functional Programming. Provide examples of when you would use each approach."
- **Purpose:** Tests understanding of programming paradigms

---

### 2. **Database Normalization**
- **Category:** Technical Skills
- **Difficulty:** Medium
- **Points:** 10
- **Time Limit:** 5 minutes (300 seconds)
- **Question:** "What is database normalization? Explain the first three normal forms (1NF, 2NF, 3NF) with practical examples."
- **Purpose:** Assesses database design knowledge

---

### 3. **Handling Difficult Team Members**
- **Category:** Behavioral
- **Difficulty:** Easy
- **Points:** 8
- **Time Limit:** 4 minutes (240 seconds)
- **Question:** "Describe a situation where you had to work with a difficult team member. How did you handle the situation, and what was the outcome?"
- **Purpose:** Evaluates teamwork and conflict resolution skills

---

### 4. **Project Crisis Management**
- **Category:** Problem Solving
- **Difficulty:** Medium
- **Points:** 10
- **Time Limit:** 5 minutes (300 seconds)
- **Question:** "You are given a project with a tight deadline, but halfway through, you discover a major technical issue that could delay delivery. Walk me through your problem-solving approach."
- **Purpose:** Tests critical thinking and crisis management

---

### 5. **RESTful APIs**
- **Category:** Technical Skills
- **Difficulty:** Medium
- **Points:** 10
- **Time Limit:** 5 minutes (300 seconds)
- **Question:** "Explain the concept of RESTful APIs. What are the main HTTP methods used in REST, and what does each method do?"
- **Purpose:** Assesses web development and API knowledge

---

### 6. **Leadership Experience**
- **Category:** Behavioral
- **Difficulty:** Medium
- **Points:** 10
- **Time Limit:** 5 minutes (300 seconds)
- **Question:** "Tell me about a time when you had to take the lead on a project. What challenges did you face, and how did you motivate your team?"
- **Purpose:** Evaluates leadership and team management skills

---

### 7. **SQL Injection Prevention**
- **Category:** Technical Skills
- **Difficulty:** Hard
- **Points:** 12
- **Time Limit:** 6 minutes (360 seconds)
- **Question:** "What is SQL injection, and how can you prevent it in your applications? Provide code examples if possible."
- **Purpose:** Tests security awareness and best practices

---

### 8. **Technical Communication**
- **Category:** Communication
- **Difficulty:** Easy
- **Points:** 8
- **Time Limit:** 4 minutes (240 seconds)
- **Question:** "Imagine you need to explain a complex technical concept to a non-technical stakeholder. How would you approach this communication challenge?"
- **Purpose:** Assesses communication and presentation skills

---

### 9. **Debugging Approach**
- **Category:** Problem Solving
- **Difficulty:** Medium
- **Points:** 10
- **Time Limit:** 5 minutes (300 seconds)
- **Question:** "Describe your systematic approach to debugging a production issue. What tools and techniques do you use to identify and resolve the problem?"
- **Purpose:** Evaluates analytical and troubleshooting skills

---

### 10. **Learning Agility**
- **Category:** Behavioral
- **Difficulty:** Easy
- **Points:** 8
- **Time Limit:** 4 minutes (240 seconds)
- **Question:** "Tell me about a time when you had to quickly learn a new technology or skill for a project. How did you approach the learning process, and what was the result?"
- **Purpose:** Tests adaptability and continuous learning mindset

---

## CATEGORIES BREAKDOWN

### Technical Skills (5 questions)
1. OOP vs Functional Programming
2. Database Normalization
3. RESTful APIs
4. SQL Injection Prevention
5. (Covered in other categories)

### Behavioral (3 questions)
1. Handling Difficult Team Members
2. Leadership Experience
3. Learning Agility

### Problem Solving (2 questions)
1. Project Crisis Management
2. Debugging Approach

### Communication (1 question)
1. Technical Communication

---

## DIFFICULTY DISTRIBUTION

- **Easy:** 3 questions (30%)
- **Medium:** 6 questions (60%)
- **Hard:** 1 question (10%)

---

## POINTS DISTRIBUTION

- **8 points:** 3 questions (Easy level)
- **10 points:** 6 questions (Medium level)
- **12 points:** 1 question (Hard level)

**Total Points:** 96 points

---

## TIME LIMITS

- **4 minutes (240s):** 3 questions (Easy)
- **5 minutes (300s):** 6 questions (Medium)
- **6 minutes (360s):** 1 question (Hard)

**Total Interview Time:** ~48 minutes for all 10 questions

---

## HOW TO IMPORT

### Method 1: Using phpMyAdmin
1. Open phpMyAdmin: `http://localhost/phpmyadmin`
2. Select database: `cmsadver_rmsdb`
3. Click "Import" tab
4. Choose file: `add_viva_questions.sql`
5. Click "Go" button
6. Wait for success message

### Method 2: Using MySQL Command Line
```bash
cd D:\dev\new-servers\xampp\htdocs\rms
mysql -u root -p cmsadver_rmsdb < add_viva_questions.sql
```

### Method 3: Using XAMPP Shell
```bash
cd D:\dev\new-servers\xampp\htdocs\rms
D:\dev\new-servers\xampp\mysql\bin\mysql -u root -p cmsadver_rmsdb < add_viva_questions.sql
```

---

## VERIFICATION STEPS

After importing, verify the questions were added:

### Step 1: Check Questions Bank Page
1. Go to: `http://localhost/rms/questions_bank`
2. You should see **10** in "Total Questions" stat
3. Questions should appear in the table

### Step 2: Check Categories
1. Click "Categories" button
2. You should see 4 categories:
   - Technical Skills
   - Behavioral
   - Problem Solving
   - Communication
3. Each category should show question count

### Step 3: Check Database
```sql
-- Check total questions
SELECT COUNT(*) as total FROM questions_bank WHERE is_active = 1;

-- Check questions by category
SELECT 
    qc.name as category,
    COUNT(qb.id) as question_count
FROM question_categories qc
LEFT JOIN questions_bank qb ON qc.id = qb.category_id AND qb.is_active = 1
WHERE qc.is_active = 1
GROUP BY qc.id, qc.name;

-- View all questions
SELECT 
    qb.id,
    qb.question_text,
    qc.name as category,
    qb.difficulty,
    qb.points
FROM questions_bank qb
LEFT JOIN question_categories qc ON qb.category_id = qc.id
WHERE qb.is_active = 1
ORDER BY qb.id DESC
LIMIT 10;
```

---

## QUESTION CHARACTERISTICS

### All Questions Are:
✅ **Real and Professional** - Based on actual interview scenarios
✅ **Open-Ended** - Require detailed, thoughtful responses
✅ **Descriptive Type** - Suitable for viva/oral interviews
✅ **Properly Categorized** - Organized by skill area
✅ **Difficulty-Rated** - Easy, Medium, or Hard
✅ **Point-Weighted** - Higher difficulty = more points
✅ **Time-Limited** - Realistic time constraints
✅ **Industry-Relevant** - Cover important job skills

### No Dummy Data:
❌ No "Test Question 1, 2, 3..."
❌ No placeholder text
❌ No generic questions
❌ No Lorem Ipsum
✅ All questions are meaningful and usable

---

## USE CASES

### 1. **Software Developer Interviews**
- OOP vs Functional Programming
- RESTful APIs
- SQL Injection Prevention
- Debugging Approach

### 2. **Team Lead Interviews**
- Leadership Experience
- Handling Difficult Team Members
- Project Crisis Management

### 3. **General Interviews**
- Technical Communication
- Learning Agility
- All behavioral questions

### 4. **Technical Assessments**
- Database Normalization
- All technical questions

---

## CUSTOMIZATION OPTIONS

You can easily modify the SQL file to:

### Change Difficulty:
```sql
-- Change from 'medium' to 'hard'
difficulty = 'hard'
```

### Change Points:
```sql
-- Increase points for harder questions
points = 15
```

### Change Time Limit:
```sql
-- Increase to 10 minutes (600 seconds)
time_limit = 600
```

### Make Mandatory:
```sql
-- Make question appear in all interviews
is_mandatory = 1
```

### Add to Specific Job Roles:
After importing, you can map questions to job roles through the UI or SQL:
```sql
INSERT INTO question_role_mapping (question_id, role_id)
VALUES (1, 1); -- Map question 1 to role 1
```

---

## EXPECTED RESULTS AFTER IMPORT

### Questions Bank Dashboard:
- **Total Questions:** 10
- **Mandatory:** 0
- **MCQ Questions:** 0
- **Categories:** 4 (or 6 if you already had 2)
- **Job Roles:** (unchanged)

### Questions Table:
- 10 new rows with real questions
- All marked as active (`is_active = 1`)
- All marked as descriptive type
- Proper difficulty levels
- Realistic point values
- Appropriate time limits

---

## TROUBLESHOOTING

### Issue: SQL import fails
**Solution:** 
- Check if `questions_bank` table exists
- Check if `question_categories` table exists
- Verify database name is correct
- Check MySQL user has INSERT permissions

### Issue: Questions don't appear
**Solution:**
- Check `is_active = 1` in database
- Clear browser cache (Ctrl+Shift+R)
- Verify category IDs are correct
- Check if questions were actually inserted

### Issue: Categories not showing
**Solution:**
- Categories are created automatically by SQL
- If they exist, SQL will skip creation
- Check `question_categories` table

### Issue: Wrong question count
**Solution:**
- Run verification SQL queries
- Check for duplicate entries
- Verify `is_active` flag

---

## NEXT STEPS

After importing questions:

1. **Review Questions** - Check each question in the UI
2. **Add More Questions** - Use "Add Question" button
3. **Create Question Sets** - Generate sets for interviews
4. **Map to Job Roles** - Assign questions to specific roles
5. **Test Interview Flow** - Try generating a question set
6. **Add MCQ Questions** - Add multiple choice questions if needed
7. **Set Mandatory Questions** - Mark critical questions as mandatory

---

## BENEFITS OF THESE QUESTIONS

✅ **Save Time** - No need to create questions from scratch
✅ **Professional Quality** - Industry-standard interview questions
✅ **Diverse Coverage** - Technical, behavioral, and soft skills
✅ **Ready to Use** - Import and start interviewing immediately
✅ **Customizable** - Easy to modify for your needs
✅ **Realistic** - Based on actual interview scenarios
✅ **Balanced** - Good mix of difficulty levels

---

## SUMMARY

✅ **10 real viva questions ready to import**
✅ **4 categories automatically created**
✅ **No dummy data - all professional content**
✅ **Proper difficulty levels and point values**
✅ **Realistic time limits**
✅ **Easy to import via SQL file**
✅ **Fully documented and explained**

**Import the SQL file now and start using these questions in your interviews!**

---

**Created:** May 24, 2026
**File:** `add_viva_questions.sql`
**Questions:** 10
**Categories:** 4
**Status:** Ready to Import ✅
