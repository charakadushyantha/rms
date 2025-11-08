<?php
// Set page-specific variables
$data['page_title'] = 'Calendar';
$data['use_calendar'] = true;

// Load the header template
$this->load->view('templates/admin_header', $data);
?>

<!-- Calendar Card -->
<div class="data-card">
    <div class="data-card-header">
        <h3 class="data-card-title">Interview Schedule Calendar</h3>
        <div>
            <button class="btn btn-primary-modern btn-modern" data-bs-toggle="modal" data-bs-target="#addEventModal">
                <i class="fas fa-plus me-2"></i>Add Event
            </button>
        </div>
    </div>
    
    <div id="calendar"></div>
</div>

<!-- Add Event Modal -->
<div class="modal fade" id="addEventModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Interview Event</h5>
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
                        <label class="form-label">Start Date & Time</label>
                        <input type="datetime-local" class="form-control" name="start_date" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">End Date & Time</label>
                        <input type="datetime-local" class="form-control" name="end_date" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary-modern btn-modern" onclick="saveEvent()">Save Event</button>
            </div>
        </div>
    </div>
</div>

<?php
// Custom script for calendar
$custom_script = "
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: function(info, successCallback, failureCallback) {
            fetch('" . base_url('A_dashboard/get_events') . "')
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
                            recruiter: event.Recruiter_username,
                            interviewer: event.Interviewer,
                            round: event.interview_round
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
            alert('Event: ' + info.event.title + '\\nRecruiter: ' + info.event.extendedProps.recruiter);
        },
        editable: true,
        selectable: true
    });
    calendar.render();
});

function getEventColor(round) {
    if (round == 0) return '#858796';
    if (round == 0.25) return '#36b9cc';
    if (round == 0.5) return '#667eea';
    if (round == 0.75) return '#f6c23e';
    if (round == 1) return '#1cc88a';
    return '#667eea';
}

function saveEvent() {
    // Add your save event logic here
    alert('Event save functionality to be implemented');
}
";

$data['custom_script'] = $custom_script;

// Load the footer template
$this->load->view('templates/admin_footer', $data);
?>
