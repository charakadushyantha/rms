<?php
// Set page-specific variables
$data['page_title'] = 'Calendar';
$data['use_calendar'] = true;

// Load the recruiter header template
$this->load->view('templates/recruiter_header', $data);
?>

<!-- Calendar Card -->
<div class="data-card" style="background: white; border-radius: 12px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
    <div class="data-card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h3 class="data-card-title" style="margin: 0; font-size: 20px; font-weight: 600; color: #333;">
            <i class="fas fa-calendar-alt"></i> Interview Schedule Calendar
        </h3>
        <div>
            <button class="btn btn-primary-modern btn-modern" data-bs-toggle="modal" data-bs-target="#addEventModal">
                <i class="fas fa-plus me-2"></i>Add Interview
            </button>
        </div>
    </div>
    
    <div id="calendar" style="padding: 20px;"></div>
</div>

<!-- Add Event Modal -->
<div class="modal fade" id="addEventModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Schedule Interview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addEventForm">
                    <div class="mb-3">
                        <label class="form-label">Candidate Name</label>
                        <input type="text" class="form-control" name="candidate_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Interviewer</label>
                        <input type="text" class="form-control" name="interviewer" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Interview Round</label>
                        <select class="form-select" name="interview_round">
                            <option value="0">Screening</option>
                            <option value="0.25">First Round</option>
                            <option value="0.5">Second Round</option>
                            <option value="0.75">Final Round</option>
                            <option value="1">Selected</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Start Date & Time</label>
                        <input type="datetime-local" class="form-control" name="start_date" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">End Date & Time</label>
                        <input type="datetime-local" class="form-control" name="end_date" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes (Optional)</label>
                        <textarea class="form-control" name="notes" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary-modern btn-modern" onclick="saveEvent()">Schedule Interview</button>
            </div>
        </div>
    </div>
</div>

<!-- Event Details Modal -->
<div class="modal fade" id="eventDetailsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Interview Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="eventDetailsContent">
                <!-- Content will be loaded dynamically -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" onclick="deleteEvent()">Delete</button>
            </div>
        </div>
    </div>
</div>

<?php
// Custom script for calendar
$custom_script = "
let calendar;
let selectedEvent = null;

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        buttonText: {
            today: 'Today',
            month: 'Month',
            week: 'Week',
            day: 'Day',
            list: 'List'
        },
        events: function(info, successCallback, failureCallback) {
            fetch('" . base_url('R_dashboard/get_events') . "')
                .then(response => response.json())
                .then(data => {
                    const events = data.map(event => ({
                        id: event.id,
                        title: event.Can_name + ' - ' + event.Interviewer,
                        start: event.start,
                        end: event.end,
                        backgroundColor: getEventColor(event.interview_round),
                        borderColor: getEventColor(event.interview_round),
                        extendedProps: {
                            candidate: event.Can_name,
                            recruiter: event.Recruiter_username,
                            interviewer: event.Interviewer,
                            round: event.interview_round,
                            roundName: getRoundName(event.interview_round)
                        }
                    }));
                    successCallback(events);
                })
                .catch(error => {
                    console.error('Error loading events:', error);
                    failureCallback(error);
                });
        },
        eventClick: function(info) {
            selectedEvent = info.event;
            showEventDetails(info.event);
        },
        editable: true,
        selectable: true,
        select: function(info) {
            $('#addEventModal').modal('show');
            document.querySelector('[name=\"start_date\"]').value = info.startStr;
            document.querySelector('[name=\"end_date\"]').value = info.endStr;
        },
        eventDrop: function(info) {
            updateEventDate(info.event);
        },
        eventResize: function(info) {
            updateEventDate(info.event);
        }
    });
    calendar.render();
});

function getEventColor(round) {
    if (round == 0) return '#858796';      // Screening - Gray
    if (round == 0.25) return '#36b9cc';   // First Round - Cyan
    if (round == 0.5) return '#667eea';    // Second Round - Purple
    if (round == 0.75) return '#f6c23e';   // Final Round - Yellow
    if (round == 1) return '#1cc88a';      // Selected - Green
    return '#667eea';
}

function getRoundName(round) {
    if (round == 0) return 'Screening';
    if (round == 0.25) return 'First Round';
    if (round == 0.5) return 'Second Round';
    if (round == 0.75) return 'Final Round';
    if (round == 1) return 'Selected';
    return 'Interview';
}

function showEventDetails(event) {
    const content = `
        <div style=\"padding: 10px;\">
            <div style=\"margin-bottom: 15px;\">
                <strong style=\"color: #667eea;\">Candidate:</strong><br>
                <span style=\"font-size: 18px;\">\${event.extendedProps.candidate}</span>
            </div>
            <div style=\"margin-bottom: 15px;\">
                <strong style=\"color: #667eea;\">Interviewer:</strong><br>
                \${event.extendedProps.interviewer}
            </div>
            <div style=\"margin-bottom: 15px;\">
                <strong style=\"color: #667eea;\">Round:</strong><br>
                <span class=\"badge\" style=\"background: \${event.backgroundColor}; padding: 5px 10px;\">\${event.extendedProps.roundName}</span>
            </div>
            <div style=\"margin-bottom: 15px;\">
                <strong style=\"color: #667eea;\">Start:</strong><br>
                \${event.start.toLocaleString()}
            </div>
            <div style=\"margin-bottom: 15px;\">
                <strong style=\"color: #667eea;\">End:</strong><br>
                \${event.end ? event.end.toLocaleString() : 'N/A'}
            </div>
            <div style=\"margin-bottom: 15px;\">
                <strong style=\"color: #667eea;\">Scheduled by:</strong><br>
                \${event.extendedProps.recruiter}
            </div>
        </div>
    `;
    
    document.getElementById('eventDetailsContent').innerHTML = content;
    $('#eventDetailsModal').modal('show');
}

function saveEvent() {
    const form = document.getElementById('addEventForm');
    const formData = new FormData(form);
    
    // Add your save event logic here
    alert('Event will be saved. Implement the save functionality in your controller.');
    $('#addEventModal').modal('hide');
    form.reset();
    calendar.refetchEvents();
}

function deleteEvent() {
    if (selectedEvent && confirm('Are you sure you want to delete this interview?')) {
        // Add your delete event logic here
        alert('Event will be deleted. Implement the delete functionality in your controller.');
        selectedEvent.remove();
        $('#eventDetailsModal').modal('hide');
    }
}

function updateEventDate(event) {
    // Add your update event logic here
    console.log('Event updated:', event);
}
";

$data['custom_script'] = $custom_script;

// Load the recruiter footer template
$this->load->view('templates/recruiter_footer', $data);
?>
