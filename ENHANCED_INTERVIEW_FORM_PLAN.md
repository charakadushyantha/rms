# 🎯 Enhanced Interview Scheduling Form - Implementation Plan

## Current Status
✅ Database fields added via `add_interview_fields.php`  
✅ Unified candidate data source implemented  
⏳ Form UI enhancement in progress  

---

## New Fields Added to Database

### Interview Scheduling
- `interview_date` - DATE
- `interview_start_time` - TIME
- `interview_end_time` - TIME  
- `interview_duration` - INT (minutes)
- `interview_round` - VARCHAR (Round 1, Technical, HR, Final)

### Interview Mode
- `interview_type` - ENUM (online, in_person, phone)

### Online Interview Details
- `online_platform` - VARCHAR (Zoom, Google Meet, Teams)
- `meeting_link` - TEXT
- `meeting_id` - VARCHAR
- `meeting_password` - VARCHAR

### In-Person Interview Details
- `venue_location` - TEXT
- `venue_room` - VARCHAR

### Phone Interview Details
- `phone_number` - VARCHAR

### Assignment & Tracking
- `assigned_interviewer` - VARCHAR (username)
- `assigned_interviewer_id` - INT
- `job_position` - VARCHAR
- `job_id` - INT

### Notes & Communication
- `interview_notes` - TEXT (visible to candidate)
- `internal_notes` - TEXT (internal only)
- `send_whatsapp` - TINYINT
- `calendar_synced` - TINYINT
- `calendar_event_id` - VARCHAR
- `reminder_sent` - TINYINT
- `timezone` - VARCHAR

---

## Enhanced Form Structure

### Section 1: Interview Flow Selection
```
[Dropdown] Select Interview Flow *
```

### Section 2: Candidate Selection (Existing - Enhanced)
```
[Toggle] Select Existing Candidate | Add New Candidate
[Dropdown with badges] Candidate list showing account status
[Info] Statistics: Total, With accounts, Without accounts
```

### Section 3: Interview Schedule
```
[Date Picker] Interview Date *
[Time Picker] Start Time *
[Duration Buttons] 30 min | 1 hour | 2 hours | Custom
[Text] End Time (auto-calculated)
```

### Section 4: Interview Round
```
[Dropdown] Round 1 | Round 2 | Technical Round | HR Round | Final Round | Custom
```

### Section 5: Interview Type & Details
```
[Radio Cards] 
  📹 Online | 🏢 In-Person | 📞 Phone

If Online:
  [Dropdown] Platform: Zoom | Google Meet | Microsoft Teams | Other
  [Text] Meeting Link (or button to auto-generate)
  [Text] Meeting ID (optional)
  [Text] Meeting Password (optional)

If In-Person:
  [Text] Venue/Location *
  [Text] Room Number/Name

If Phone:
  [Text] Phone Number *
```

### Section 6: Interviewer Assignment
```
[Dropdown/Multi-select] Assigned Interviewer(s) *
  - Fetch from users table where role='interviewer'
  - Show availability status
  - Conflict detection
```

### Section 7: Job Position
```
[Dropdown] Job Position/Vacancy
  - Fetch from job_postings or candidate_details.cd_job_title
  - Optional field
```

### Section 8: Notes & Instructions
```
[Textarea] Interview Notes (visible to candidate)
  - Instructions, preparation guidelines
  - What to bring, dress code, etc.

[Textarea] Internal Notes (admin only)
  - Internal comments, special considerations
```

### Section 9: Notifications
```
[Checkbox] ✉️ Send interview invitation via email
[Checkbox] 📱 Send WhatsApp notification (Sri Lanka context)
[Checkbox] 📅 Add to Google Calendar automatically
```

---

## Smart Features for Academic Value

### 1. Auto-Generate Meeting Links
```javascript
// Integration with Zoom/Google Meet API
function generateMeetingLink(platform) {
    // Call backend API to create meeting
    // Return meeting link, ID, password
}
```

### 2. Conflict Detection
```php
// Check if interviewer is already booked
$conflicts = check_interviewer_availability(
    $interviewer_id, 
    $interview_date, 
    $start_time, 
    $end_time
);

if ($conflicts) {
    show_warning("Interviewer has another interview at this time");
}
```

### 3. WhatsApp Integration
```php
// Send WhatsApp notification via Twilio/WhatsApp Business API
function send_whatsapp_notification($phone, $message) {
    // Integration code
}
```

### 4. Google Calendar Sync
```php
// Add event to Google Calendar
function sync_to_google_calendar($interview_data) {
    // Google Calendar API integration
    // Return event_id for tracking
}
```

### 5. Timezone Support
```javascript
// Convert times based on user timezone
const userTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
// Display times in user's local timezone
```

---

## Form Validation Rules

### Required Fields:
- Interview Flow
- Candidate (existing or new)
- Interview Date
- Start Time
- Interview Type
- Assigned Interviewer

### Conditional Required:
- If Online → Platform required
- If In-Person → Venue required
- If Phone → Phone number required

### Business Rules:
- Interview date cannot be in the past
- End time must be after start time
- Duration must be between 15 minutes and 8 hours
- Interviewer must be available (no conflicts)

---

## Controller Updates Needed

### `Interview.php::create_interview()`

```php
public function create_interview() {
    // ... existing candidate loading code ...
    
    // Add interviewers list
    $this->db->select('u_id, u_username, u_email');
    $this->db->from('users');
    $this->db->where('u_role', 'interviewer');
    $this->db->where('u_status', 'Active');
    $data['interviewers'] = $this->db->get()->result_array();
    
    // Add job positions
    $this->db->select('DISTINCT cd_job_title');
    $this->db->from('candidate_details');
    $this->db->where('cd_job_title IS NOT NULL');
    $this->db->where('cd_job_title !=', '');
    $data['job_positions'] = $this->db->get()->result_array();
    
    if ($this->input->post()) {
        // Collect all new fields
        $interview_data = [
            'flow_id' => $this->input->post('flow_id'),
            'candidate_name' => $this->input->post('candidate_name'),
            'candidate_email' => $this->input->post('candidate_email'),
            'candidate_phone' => $this->input->post('candidate_phone'),
            
            // NEW FIELDS
            'interview_date' => $this->input->post('interview_date'),
            'interview_start_time' => $this->input->post('interview_start_time'),
            'interview_end_time' => $this->input->post('interview_end_time'),
            'interview_duration' => $this->input->post('interview_duration'),
            'interview_type' => $this->input->post('interview_type'),
            'interview_round' => $this->input->post('interview_round'),
            
            'online_platform' => $this->input->post('online_platform'),
            'meeting_link' => $this->input->post('meeting_link'),
            'meeting_id' => $this->input->post('meeting_id'),
            'meeting_password' => $this->input->post('meeting_password'),
            
            'venue_location' => $this->input->post('venue_location'),
            'venue_room' => $this->input->post('venue_room'),
            'phone_number' => $this->input->post('phone_number'),
            
            'assigned_interviewer' => $this->input->post('assigned_interviewer'),
            'job_position' => $this->input->post('job_position'),
            'interview_notes' => $this->input->post('interview_notes'),
            'internal_notes' => $this->input->post('internal_notes'),
            
            'send_whatsapp' => $this->input->post('send_whatsapp') ? 1 : 0,
            'timezone' => 'Asia/Colombo',
            
            // Existing fields
            'token' => bin2hex(random_bytes(32)),
            'status' => 'pending',
            'expires_at' => date('Y-m-d H:i:s', strtotime('+7 days')),
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        // Check interviewer availability
        if ($this->check_interviewer_conflict($interview_data)) {
            $this->session->set_flashdata('warning', 'Interviewer has a conflict at this time');
        }
        
        $interview_id = $this->Interview_model->create($interview_data);
        
        if ($interview_id) {
            // Send email if requested
            if ($this->input->post('send_email')) {
                $this->send_interview_email($interview_data);
            }
            
            // Send WhatsApp if requested
            if ($this->input->post('send_whatsapp')) {
                $this->send_whatsapp_notification($interview_data);
            }
            
            // Sync to Google Calendar if requested
            if ($this->input->post('sync_calendar')) {
                $this->sync_to_google_calendar($interview_id, $interview_data);
            }
            
            redirect('interview/view/' . $interview_id);
        }
    }
}
```

---

## Next Steps

1. ✅ Run `add_interview_fields.php` to add database fields
2. ⏳ Create enhanced form UI (in progress)
3. ⏳ Update controller to handle new fields
4. ⏳ Add interviewer availability checking
5. ⏳ Implement email/WhatsApp notifications
6. ⏳ Add Google Calendar integration (optional)
7. ⏳ Test complete flow

---

## Files to Modify

1. `application/views/interview/create_interview.php` - Complete rewrite
2. `application/controllers/Interview.php` - Update create_interview() method
3. `application/models/Interview_model.php` - Update create() method
4. Add new helper methods for:
   - Conflict detection
   - WhatsApp notifications
   - Calendar sync

---

**Status:** Database ready, form enhancement in progress
**Priority:** High - Critical for SME recruitment system
**Academic Value:** High - Shows real-world enterprise features
