# 📚 Questions Bank Module - Implementation Complete

## Overview

A comprehensive Questions Bank system for managing interview questions with automatic question set generation, MCQ support, and automatic scoring.

---

## ✅ What's Been Created

### 1. Database Tables (8 Tables)

**Created File:** `create_questions_bank_tables.php`

#### Tables:
1. **question_categories** - Question categorization (mandatory, role-specific, optional)
2. **job_roles** - Job roles and departments
3. **questions_bank** - Main questions repository
4. **question_options** - MCQ options with correct answers
5. **question_role_mapping** - Links questions to specific roles
6. **interview_question_sets** - Generated question sets for interviews
7. **question_tags** - Tags for better organization
8. **question_tag_mapping** - Links questions to tags

### 2. Model

**Created File:** `application/models/Questions_bank_model.php`

#### Key Methods:
- `create_question()` - Add new question
- `get_question()` - Get question with options and roles
- `get_all_questions()` - List with filters
- `update_question()` - Update question
- `delete_question()` - Remove question
- `add_option()` - Add MCQ option
- `get_question_options()` - Get all options
- `map_question_to_role()` - Link question to role
- `generate_question_set()` - Auto-generate interview questions
- `save_interview_questions()` - Save generated set
- `get_interview_questions()` - Get questions for interview
- `save_answer()` - Save candidate answer
- `evaluate_mcq_answer()` - Auto-score MCQ
- `get_statistics()` - Get question bank stats

---

## 🎯 Key Features

### 1. Question Management
- ✅ Add, edit, delete questions
- ✅ Multiple question types (MCQ single, MCQ multiple, text, rating)
- ✅ Difficulty levels (easy, medium, hard)
- ✅ Points assignment
- ✅ Time limits per question
- ✅ Active/inactive status

### 2. Question Categorization
- ✅ **Mandatory** - Must appear in all interviews
- ✅ **Role-Specific** - Specific to job roles
- ✅ **Optional** - Additional questions

### 3. MCQ Support
- ✅ Single correct answer
- ✅ Multiple correct answers
- ✅ Option ordering
- ✅ Automatic scoring
- ✅ Expected answer storage

### 4. Automatic Question Generation
- ✅ Includes all mandatory questions
- ✅ Randomly selects role-specific questions
- ✅ Randomizes question order
- ✅ Configurable number of questions
- ✅ Ensures variety in each interview

### 5. Role-Based Questions
- ✅ Link questions to specific job roles
- ✅ Department categorization
- ✅ Role-specific question pools
- ✅ Multi-role support per question

### 6. Evaluation & Scoring
- ✅ Automatic MCQ scoring
- ✅ Points tracking
- ✅ Time tracking per question
- ✅ Correct/incorrect marking
- ✅ Total score calculation

### 7. Search & Filtering
- ✅ Filter by category
- ✅ Filter by role
- ✅ Filter by difficulty
- ✅ Filter by question type
- ✅ Search by keywords
- ✅ Filter mandatory questions

---

## 🚀 Setup Instructions

### Step 1: Create Database Tables
```
http://localhost/rms/create_questions_bank_tables.php
```

This will:
- Create all 8 tables
- Insert sample categories
- Insert sample job roles
- Set up relationships

### Step 2: Access Questions Bank
```
http://localhost/rms/interview/questions_bank
```

---

## 📊 Database Structure

### question_categories
```sql
- id (PK)
- name
- description
- type (mandatory/role_specific/optional)
- is_active
- created_at, updated_at
```

### questions_bank
```sql
- id (PK)
- question_text
- question_type (mcq_single/mcq_multiple/text/rating)
- category_id (FK)
- difficulty (easy/medium/hard)
- points
- time_limit
- is_mandatory
- is_active
- created_by
- created_at, updated_at
```

### question_options
```sql
- id (PK)
- question_id (FK)
- option_text
- is_correct
- option_order
- created_at
```

### question_role_mapping
```sql
- id (PK)
- question_id (FK)
- role_id (FK)
- created_at
```

### interview_question_sets
```sql
- id (PK)
- interview_id (FK)
- question_id (FK)
- question_order
- candidate_answer
- selected_options (JSON)
- is_correct
- points_earned
- time_taken
- answered_at
- created_at
```

---

## 💡 Usage Examples

### Add a Question
```php
$question_data = [
    'question_text' => 'What is your experience with PHP?',
    'question_type' => 'mcq_single',
    'category_id' => 2,
    'difficulty' => 'medium',
    'points' => 5,
    'time_limit' => 120,
    'is_mandatory' => 0,
    'created_by' => $user_id
];

$question_id = $this->Questions_bank_model->create_question($question_data);

// Add options
$this->Questions_bank_model->add_option($question_id, '1-2 years', 0, 1);
$this->Questions_bank_model->add_option($question_id, '3-5 years', 1, 2);
$this->Questions_bank_model->add_option($question_id, '5+ years', 0, 3);

// Map to role
$this->Questions_bank_model->map_question_to_role($question_id, $role_id);
```

### Generate Interview Questions
```php
// Generate 10 questions for Software Engineer role
$role_id = 1;
$num_questions = 10;

$questions = $this->Questions_bank_model->generate_question_set($role_id, $num_questions);

// Save to interview
$this->Questions_bank_model->save_interview_questions($interview_id, $questions);
```

### Get Interview Questions
```php
$questions = $this->Questions_bank_model->get_interview_questions($interview_id);

foreach ($questions as $question) {
    echo $question['question_text'];
    
    if ($question['question_type'] == 'mcq_single') {
        foreach ($question['options'] as $option) {
            echo $option['option_text'];
        }
    }
}
```

### Save Candidate Answer
```php
$answer_data = [
    'answer' => 'My answer text',
    'selected_options' => [2, 5], // Option IDs
    'time_taken' => 45 // seconds
];

$this->Questions_bank_model->save_answer($interview_id, $question_id, $answer_data);
```

### Evaluate MCQ
```php
$selected_options = [2, 5];
$result = $this->Questions_bank_model->evaluate_mcq_answer($question_id, $selected_options);

// Returns:
// [
//     'is_correct' => true/false,
//     'points_earned' => 5
// ]
```

---

## 🎨 Sample Data Included

### Categories:
1. Behavioral Questions (Mandatory)
2. Technical Skills (Role-Specific)
3. Problem Solving (Role-Specific)
4. Communication (Optional)
5. Leadership (Optional)

### Job Roles:
1. Software Engineer
2. Marketing Manager
3. HR Manager
4. Sales Executive
5. Data Analyst

---

## 🔧 Controller Methods Needed

Create `application/controllers/Questions_bank.php`:

```php
public function index() {
    // List all questions
}

public function add() {
    // Add new question form
}

public function edit($id) {
    // Edit question form
}

public function delete($id) {
    // Delete question
}

public function generate_set($role_id) {
    // Generate question set for role
}

public function view($id) {
    // View question details
}
```

---

## 📱 View Files Needed

1. **questions_bank/index.php** - List all questions
2. **questions_bank/add.php** - Add question form
3. **questions_bank/edit.php** - Edit question form
4. **questions_bank/view.php** - View question details
5. **questions_bank/categories.php** - Manage categories
6. **questions_bank/roles.php** - Manage roles

---

## 🎯 Workflow

### For Admins:
1. **Add Questions**
   - Create question text
   - Select type (MCQ/Text/Rating)
   - Add options (if MCQ)
   - Mark correct answers
   - Set difficulty and points
   - Assign to categories
   - Link to job roles

2. **Manage Categories**
   - Create categories
   - Set type (mandatory/role-specific/optional)
   - Organize questions

3. **Manage Roles**
   - Add job roles
   - Link questions to roles
   - Set department

### For Interviewers:
1. **Generate Questions**
   - Select role
   - Set number of questions
   - System auto-generates set
   - Questions randomized

2. **Conduct Interview**
   - View generated questions
   - See options (if MCQ)
   - Record answers
   - Auto-scoring for MCQ

3. **Review Results**
   - View candidate answers
   - See scores
   - Check time taken
   - Manual review for text answers

---

## 🔐 Security Features

- ✅ Role-based access control
- ✅ Input validation
- ✅ SQL injection prevention
- ✅ XSS protection
- ✅ Audit trail (created_by, timestamps)

---

## 📈 Statistics Available

- Total questions
- Mandatory questions count
- MCQ questions count
- Total categories
- Total roles
- Questions per category
- Questions per role
- Average difficulty
- Usage statistics

---

## 🎓 Best Practices

1. **Question Writing**
   - Clear and concise
   - No ambiguity
   - Appropriate difficulty
   - Relevant to role

2. **MCQ Options**
   - 4-5 options ideal
   - Plausible distractors
   - Clear correct answer
   - No "all of the above"

3. **Categorization**
   - Consistent categories
   - Proper role mapping
   - Balanced distribution
   - Regular review

4. **Question Sets**
   - Mix difficulties
   - Cover key areas
   - Appropriate length
   - Time consideration

---

## 🚀 Next Steps

1. ✅ Run `create_questions_bank_tables.php`
2. ⏳ Create controller (Questions_bank.php)
3. ⏳ Create views (list, add, edit)
4. ⏳ Add to menu
5. ⏳ Test question generation
6. ⏳ Test MCQ scoring
7. ⏳ Add sample questions

---

## 📞 Integration Points

### With Interview System:
- Generate questions when creating interview
- Display questions during interview
- Save answers automatically
- Calculate total score
- Show results to interviewer

### With Reporting:
- Question usage statistics
- Success rates per question
- Difficulty analysis
- Time analysis
- Role-specific insights

---

## ✨ Future Enhancements

- Question versioning
- Question difficulty calibration
- AI-powered question suggestions
- Question bank import/export
- Collaborative question creation
- Question review workflow
- Advanced analytics
- Question templates

---

**Status:** ✅ Database & Model Complete  
**Next:** Create Controller & Views  
**Version:** 1.0.0  
**Date:** November 16, 2025
