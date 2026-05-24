-- ============================================
-- Add 10 Real Viva Questions to Questions Bank
-- Date: May 24, 2026
-- ============================================

-- First, let's ensure we have categories
-- Insert categories if they don't exist
INSERT INTO `question_categories` (`name`, `description`, `is_active`, `created_at`) 
SELECT 'Technical Skills', 'Questions related to technical knowledge and skills', 1, NOW()
WHERE NOT EXISTS (SELECT 1 FROM `question_categories` WHERE `name` = 'Technical Skills');

INSERT INTO `question_categories` (`name`, `description`, `is_active`, `created_at`) 
SELECT 'Behavioral', 'Questions about behavior, attitude, and soft skills', 1, NOW()
WHERE NOT EXISTS (SELECT 1 FROM `question_categories` WHERE `name` = 'Behavioral');

INSERT INTO `question_categories` (`name`, `description`, `is_active`, `created_at`) 
SELECT 'Problem Solving', 'Questions to assess analytical and problem-solving abilities', 1, NOW()
WHERE NOT EXISTS (SELECT 1 FROM `question_categories` WHERE `name` = 'Problem Solving');

INSERT INTO `question_categories` (`name`, `description`, `is_active`, `created_at`) 
SELECT 'Communication', 'Questions to evaluate communication and presentation skills', 1, NOW()
WHERE NOT EXISTS (SELECT 1 FROM `question_categories` WHERE `name` = 'Communication');

-- Get category IDs (we'll use these in the questions)
SET @tech_cat = (SELECT id FROM question_categories WHERE name = 'Technical Skills' LIMIT 1);
SET @behav_cat = (SELECT id FROM question_categories WHERE name = 'Behavioral' LIMIT 1);
SET @prob_cat = (SELECT id FROM question_categories WHERE name = 'Problem Solving' LIMIT 1);
SET @comm_cat = (SELECT id FROM question_categories WHERE name = 'Communication' LIMIT 1);

-- ============================================
-- VIVA QUESTIONS (Open-ended, descriptive)
-- ============================================

-- Question 1: Technical - Software Development
INSERT INTO `questions_bank` (
    `question_text`, 
    `question_type`, 
    `category_id`, 
    `difficulty`, 
    `points`, 
    `time_limit`, 
    `is_mandatory`, 
    `is_active`, 
    `created_at`
) VALUES (
    'Explain the difference between Object-Oriented Programming (OOP) and Functional Programming. Provide examples of when you would use each approach.',
    'descriptive',
    @tech_cat,
    'medium',
    10,
    300,
    0,
    1,
    NOW()
);

-- Question 2: Technical - Database
INSERT INTO `questions_bank` (
    `question_text`, 
    `question_type`, 
    `category_id`, 
    `difficulty`, 
    `points`, 
    `time_limit`, 
    `is_mandatory`, 
    `is_active`, 
    `created_at`
) VALUES (
    'What is database normalization? Explain the first three normal forms (1NF, 2NF, 3NF) with practical examples.',
    'descriptive',
    @tech_cat,
    'medium',
    10,
    300,
    0,
    1,
    NOW()
);

-- Question 3: Behavioral - Teamwork
INSERT INTO `questions_bank` (
    `question_text`, 
    `question_type`, 
    `category_id`, 
    `difficulty`, 
    `points`, 
    `time_limit`, 
    `is_mandatory`, 
    `is_active`, 
    `created_at`
) VALUES (
    'Describe a situation where you had to work with a difficult team member. How did you handle the situation, and what was the outcome?',
    'descriptive',
    @behav_cat,
    'easy',
    8,
    240,
    0,
    1,
    NOW()
);

-- Question 4: Problem Solving - Critical Thinking
INSERT INTO `questions_bank` (
    `question_text`, 
    `question_type`, 
    `category_id`, 
    `difficulty`, 
    `points`, 
    `time_limit`, 
    `is_mandatory`, 
    `is_active`, 
    `created_at`
) VALUES (
    'You are given a project with a tight deadline, but halfway through, you discover a major technical issue that could delay delivery. Walk me through your problem-solving approach.',
    'descriptive',
    @prob_cat,
    'medium',
    10,
    300,
    0,
    1,
    NOW()
);

-- Question 5: Technical - Web Development
INSERT INTO `questions_bank` (
    `question_text`, 
    `question_type`, 
    `category_id`, 
    `difficulty`, 
    `points`, 
    `time_limit`, 
    `is_mandatory`, 
    `is_active`, 
    `created_at`
) VALUES (
    'Explain the concept of RESTful APIs. What are the main HTTP methods used in REST, and what does each method do?',
    'descriptive',
    @tech_cat,
    'medium',
    10,
    300,
    0,
    1,
    NOW()
);

-- Question 6: Behavioral - Leadership
INSERT INTO `questions_bank` (
    `question_text`, 
    `question_type`, 
    `category_id`, 
    `difficulty`, 
    `points`, 
    `time_limit`, 
    `is_mandatory`, 
    `is_active`, 
    `created_at`
) VALUES (
    'Tell me about a time when you had to take the lead on a project. What challenges did you face, and how did you motivate your team?',
    'descriptive',
    @behav_cat,
    'medium',
    10,
    300,
    0,
    1,
    NOW()
);

-- Question 7: Technical - Security
INSERT INTO `questions_bank` (
    `question_text`, 
    `question_type`, 
    `category_id`, 
    `difficulty`, 
    `points`, 
    `time_limit`, 
    `is_mandatory`, 
    `is_active`, 
    `created_at`
) VALUES (
    'What is SQL injection, and how can you prevent it in your applications? Provide code examples if possible.',
    'descriptive',
    @tech_cat,
    'hard',
    12,
    360,
    0,
    1,
    NOW()
);

-- Question 8: Communication - Presentation
INSERT INTO `questions_bank` (
    `question_text`, 
    `question_type`, 
    `category_id`, 
    `difficulty`, 
    `points`, 
    `time_limit`, 
    `is_mandatory`, 
    `is_active`, 
    `created_at`
) VALUES (
    'Imagine you need to explain a complex technical concept to a non-technical stakeholder. How would you approach this communication challenge?',
    'descriptive',
    @comm_cat,
    'easy',
    8,
    240,
    0,
    1,
    NOW()
);

-- Question 9: Problem Solving - Debugging
INSERT INTO `questions_bank` (
    `question_text`, 
    `question_type`, 
    `category_id`, 
    `difficulty`, 
    `points`, 
    `time_limit`, 
    `is_mandatory`, 
    `is_active`, 
    `created_at`
) VALUES (
    'Describe your systematic approach to debugging a production issue. What tools and techniques do you use to identify and resolve the problem?',
    'descriptive',
    @prob_cat,
    'medium',
    10,
    300,
    0,
    1,
    NOW()
);

-- Question 10: Behavioral - Adaptability
INSERT INTO `questions_bank` (
    `question_text`, 
    `question_type`, 
    `category_id`, 
    `difficulty`, 
    `points`, 
    `time_limit`, 
    `is_mandatory`, 
    `is_active`, 
    `created_at`
) VALUES (
    'Tell me about a time when you had to quickly learn a new technology or skill for a project. How did you approach the learning process, and what was the result?',
    'descriptive',
    @behav_cat,
    'easy',
    8,
    240,
    0,
    1,
    NOW()
);

-- ============================================
-- Summary
-- ============================================
SELECT 'Successfully added 10 viva questions!' as Status;
SELECT COUNT(*) as 'Total Questions' FROM questions_bank WHERE is_active = 1;
SELECT name as 'Category', COUNT(qb.id) as 'Question Count' 
FROM question_categories qc 
LEFT JOIN questions_bank qb ON qc.id = qb.category_id AND qb.is_active = 1
WHERE qc.is_active = 1
GROUP BY qc.id, qc.name;
