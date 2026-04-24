# ✅ Interview View Response Fix

## Issue Fixed

**Error:** `Undefined array key "question"` and `Undefined array key "duration"`

**Location:** `application/views/interview/view_interview.php` (Lines 148, 153)

**URL:** `/interview/view/{id}`

---

## Root Cause

The `get_responses()` method in `Interview_model` was only returning raw data from the `interview_responses` table, which contains:
- `question_id` (just the ID number)
- `response_text` (the answer)
- `duration_seconds` (time taken)

But the view was expecting:
- `question` (the actual question text)
- `duration` (renamed from duration_seconds)

The question text is stored in the `interview_flows.questions` JSON field, not in the responses table.

---

## Solution Applied

### Modified: `application/models/Interview_model.php`

Enhanced the `get_responses()` method to:

1. **Fetch the interview** to get the flow_id
2. **Fetch the flow** to get the questions JSON
3. **Decode the questions** JSON into an array
4. **Create a question map** (question_id => question data)
5. **Fetch responses** from interview_responses table
6. **Merge question text** with each response
7. **Rename duration_seconds** to `duration` for consistency

### New Method Logic:

```php
public function get_responses($interview_id) {
    // Get interview to find flow_id
    $interview = $this->get_by_id($interview_id);
    
    // Get flow to get questions
    $flow = $this->db->get_where('interview_flows', ['id' => $interview['flow_id']])->row_array();
    
    // Decode questions JSON
    $questions = is_array($flow['questions']) ? $flow['questions'] : json_decode($flow['questions'], true);
    
    // Create question map
    $question_map = [];
    foreach ($questions as $q) {
        $question_map[$q['id']] = $q;
    }
    
    // Get responses
    $responses = $this->db->get_where('interview_responses', ['interview_id' => $interview_id])->result_array();
    
    // Merge question text with responses
    foreach ($responses as &$response) {
        $qid = $response['question_id'];
        $response['question'] = $question_map[$qid]['question'] ?? 'Question not found';
        $response['duration'] = $response['duration_seconds'];
    }
    
    return $responses;
}
```

---

## What This Fixes

### Before (Broken):
```php
// Response array only had:
[
    'id' => 1,
    'interview_id' => 1,
    'question_id' => 1,  // Just the ID!
    'response_text' => 'My answer...',
    'duration_seconds' => 120  // Wrong key name!
]

// View tried to access:
$response['question']  // ❌ Undefined!
$response['duration']  // ❌ Undefined!
```

### After (Fixed):
```php
// Response array now has:
[
    'id' => 1,
    'interview_id' => 1,
    'question_id' => 1,
    'question' => 'What is your experience with PHP?',  // ✅ Added!
    'response_text' => 'My answer...',
    'duration_seconds' => 120,
    'duration' => 120,  // ✅ Added!
    'question_type' => 'open'  // ✅ Bonus!
]

// View can now access:
$response['question']  // ✅ Works!
$response['duration']  // ✅ Works!
```

---

## Database Structure

### interview_flows table:
```sql
- id
- job_title
- questions (JSON) -- Contains array of question objects
  [
    {"id": 1, "question": "What is...", "type": "open", "duration": 120},
    {"id": 2, "question": "Describe...", "type": "open", "duration": 180}
  ]
```

### interview_responses table:
```sql
- id
- interview_id
- question_id (references the id in questions JSON)
- response_text
- duration_seconds
```

The fix joins these two data sources to provide complete information.

---

## Testing

After this fix, visiting `/interview/view/1` should show:

✅ Interview details  
✅ Candidate information  
✅ Interview link  
✅ **Candidate Responses section with:**
  - Question text displayed
  - Response text displayed
  - Duration displayed
  - No PHP errors

---

## Additional Benefits

The enhanced method also provides:
- `question_type` field (open, multiple choice, etc.)
- Graceful handling if question not found
- Consistent field naming (`duration` instead of `duration_seconds`)
- Better error handling (returns empty array if interview/flow not found)

---

## Files Modified

1. **application/models/Interview_model.php**
   - Enhanced `get_responses()` method (Lines 124-170)
   - Added question text lookup
   - Added duration field mapping

---

## Prevention

To prevent similar issues:

1. **Document data structures** - Clearly document what each method returns
2. **Use DTOs** - Consider using Data Transfer Objects for complex data
3. **Test with real data** - Always test with actual database records
4. **Consistent naming** - Use same field names across tables when possible

---

## Status

✅ **FIXED** - Interview view page now displays responses correctly

---

**Fixed:** November 16, 2025  
**Files Modified:** 1  
**Method Enhanced:** `Interview_model::get_responses()`
