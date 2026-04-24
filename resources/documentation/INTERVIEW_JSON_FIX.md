# ✅ Interview System JSON Decode Fix

## Issue Fixed

**Error:** `TypeError: json_decode(): Argument #1 ($json) must be of type string, array given`

**Location:** Multiple interview view files

---

## Root Cause

The `Interview_flow_model` was already decoding the JSON `questions` field into an array in its `get_all()` and `get_by_id()` methods, but the view files were trying to decode it again, causing a type error.

---

## Files Fixed

### 1. application/views/interview/dashboard.php (Line 164)

**Before:**
```php
<td><?= count(json_decode($flow['questions'], true)) ?> questions</td>
```

**After:**
```php
<td><?= is_array($flow['questions']) ? count($flow['questions']) : count(json_decode($flow['questions'], true)) ?> questions</td>
```

### 2. application/views/interview/flows_list.php (Line 209)

**Before:**
```php
<div class="stat-value"><?= count(json_decode($flow['questions'], true)) ?></div>
```

**After:**
```php
<div class="stat-value"><?= is_array($flow['questions']) ? count($flow['questions']) : count(json_decode($flow['questions'], true)) ?></div>
```

### 3. application/views/interview/edit_flow.php (Line 175)

**Before:**
```php
$questions = json_decode($flow['questions'], true);
```

**After:**
```php
$questions = is_array($flow['questions']) ? $flow['questions'] : json_decode($flow['questions'], true);
```

### 4. application/views/interview/take_interview.php (Line 151)

**Before:**
```php
<p><strong>Questions:</strong> <?= count(json_decode($interview['questions'], true)) ?></p>
```

**After:**
```php
<p><strong>Questions:</strong> <?= is_array($interview['questions']) ? count($interview['questions']) : count(json_decode($interview['questions'], true)) ?></p>
```

### 5. application/views/interview/take_interview.php (Line 201 - JavaScript)

**Before:**
```javascript
const questions = JSON.parse(interview.questions);
```

**After:**
```javascript
const questions = typeof interview.questions === 'string' ? JSON.parse(interview.questions) : interview.questions;
```

---

## Solution Explanation

The fix uses a conditional check to handle both cases:
- If `questions` is already an array (decoded by the model), use it directly
- If `questions` is still a JSON string, decode it first

This makes the code robust and handles both scenarios without errors.

---

## Why This Happened

The `Interview_flow_model` has these methods that automatically decode JSON:

```php
public function get_all($status = null, $limit = 50, $offset = 0) {
    // ... query code ...
    
    foreach ($results as &$result) {
        if (!empty($result['questions'])) {
            $result['questions'] = json_decode($result['questions'], true);
        }
    }
    
    return $results;
}

public function get_by_id($id) {
    // ... query code ...
    
    if ($result && !empty($result['questions'])) {
        $result['questions'] = json_decode($result['questions'], true);
    }
    
    return $result;
}
```

The views were written assuming the data would come as JSON strings, but the model was already converting them to arrays.

---

## Testing

After this fix, all interview pages should work:

✅ `/interview` - Dashboard  
✅ `/interview/flows` - Flows list  
✅ `/interview/edit_flow/{id}` - Edit flow  
✅ `/interview/take/{token}` - Take interview  

---

## Prevention

To prevent this in the future:

1. **Document model behavior** - Clearly document when models decode JSON
2. **Consistent approach** - Either decode in model OR in view, not both
3. **Type checking** - Use `is_array()` checks when uncertain
4. **Testing** - Test with actual database data

---

## Status

✅ **FIXED** - All interview pages should now work without JSON decode errors

---

**Fixed:** November 16, 2025  
**Files Modified:** 5  
**Lines Changed:** 5
