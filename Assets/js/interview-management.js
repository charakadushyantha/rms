// Interview Management Dashboard - JavaScript

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    initializeCalendar();
    initializeFilters();
    loadInterviews();
});

// Calendar Functions
let currentDate = new Date();

function initializeCalendar() {
    renderCalendar();
}

function renderCalendar() {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    
    // Update month display
    const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
                       'July', 'August', 'September', 'October', 'November', 'December'];
    document.getElementById('current-month').textContent = `${monthNames[month]} ${year}`;
    
    // Get first day of month and number of days
    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const daysInPrevMonth = new Date(year, month, 0).getDate();
    
    const calendarDays = document.getElementById('calendar-days');
    calendarDays.innerHTML = '';
    
    // Previous month days
    for (let i = firstDay - 1; i >= 0; i--) {
        const day = daysInPrevMonth - i;
        const dayEl = createDayElement(day, 'other-month');
        calendarDays.appendChild(dayEl);
    }
    
    // Current month days
    const today = new Date();
    for (let day = 1; day <= daysInMonth; day++) {
        const isToday = (day === today.getDate() && 
                        month === today.getMonth() && 
                        year === today.getFullYear());
        const hasInterview = checkInterviewOnDate(year, month, day);
        
        let classes = [];
        if (isToday) classes.push('today');
        if (hasInterview) classes.push('has-interview');
        
        const dayEl = createDayElement(day, classes.join(' '));
        calendarDays.appendChild(dayEl);
    }
    
    // Next month days
    const totalCells = calendarDays.children.length;
    const remainingCells = 42 - totalCells; // 6 rows * 7 days
    for (let day = 1; day <= remainingCells; day++) {
        const dayEl = createDayElement(day, 'other-month');
        calendarDays.appendChild(dayEl);
    }
}

function createDayElement(day, className) {
    const div = document.createElement('div');
    div.className = `calendar-day ${className}`;
    div.textContent = day;
    div.onclick = () => selectDate(day);
    return div;
}

function checkInterviewOnDate(year, month, day) {
    // This would check against actual interview data
    // For demo, randomly mark some days
    return Math.random() > 0.8;
}

function previousMonth() {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar();
}

function nextMonth() {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar();
}

function selectDate(day) {
    console.log('Selected date:', day);
    // Filter interviews by selected date
}

// Filter Functions
function initializeFilters() {
    const searchInput = document.getElementById('search-input');
    if (searchInput) {
        searchInput.addEventListener('input', debounce(applyFilters, 300));
    }
}

function applyFilters() {
    const search = document.getElementById('search-input')?.value || '';
    const status = document.getElementById('status-filter')?.value || '';
    const position = document.getElementById('position-filter')?.value || '';
    const dateFrom = document.getElementById('date-from')?.value || '';
    const dateTo = document.getElementById('date-to')?.value || '';
    
    const filters = {
        search,
        status,
        position,
        dateFrom,
        dateTo
    };
    
    loadInterviews(filters);
}

function loadInterviews(filters = {}) {
    // Show loading state
    showLoading();
    
    // Build query string
    const params = new URLSearchParams(filters);
    
    // Fetch interviews
    fetch(`/rms/interview/get_interviews?${params}`)
        .then(response => response.json())
        .then(data => {
            renderInterviews(data.interviews);
            hideLoading();
        })
        .catch(error => {
            console.error('Error loading interviews:', error);
            hideLoading();
        });
}

function renderInterviews(interviews) {
    // This would update the interview list
    console.log('Rendering interviews:', interviews);
}

// Interview Actions
function viewInterview(id) {
    window.location.href = `/rms/interview/view/${id}`;
}

function rescheduleInterview(id) {
    if (confirm('Are you sure you want to reschedule this interview?')) {
        // Show reschedule modal
        showRescheduleModal(id);
    }
}

function sendReminder(id) {
    if (confirm('Send reminder email to candidate?')) {
        fetch(`/rms/interview/send_reminder/${id}`, {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Reminder sent successfully', 'success');
            } else {
                showNotification('Failed to send reminder', 'error');
            }
        });
    }
}

function cancelInterview(id) {
    if (confirm('Are you sure you want to cancel this interview? This action cannot be undone.')) {
        fetch(`/rms/interview/cancel/${id}`, {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Interview cancelled', 'success');
                loadInterviews();
            } else {
                showNotification('Failed to cancel interview', 'error');
            }
        });
    }
}

function toggleDetails(id) {
    const details = document.getElementById(`details-${id}`);
    if (details) {
        const isVisible = details.style.display !== 'none';
        details.style.display = isVisible ? 'none' : 'block';
        
        // Update button icon
        const btn = event.target.closest('button');
        const icon = btn.querySelector('i');
        icon.className = isVisible ? 'fas fa-chevron-down' : 'fas fa-chevron-up';
    }
}

// Quick Actions
function scheduleInterview() {
    window.location.href = '/rms/interview/create_interview';
}

function exportReport() {
    window.location.href = '/rms/interview/export_report';
}

function openEmailTemplates() {
    window.location.href = '/rms/interview/email_templates';
}

function manageInterviewers() {
    window.location.href = '/rms/interview/interviewers';
}

function viewFeedbackForms() {
    window.location.href = '/rms/interview/feedback_forms';
}

function viewNotifications() {
    window.location.href = '/rms/interview/notifications';
}

function generateReports() {
    window.location.href = '/rms/interview/reports';
}

function viewSettings() {
    window.location.href = '/rms/interview/settings';
}

// Pagination
function changePage(page) {
    const currentFilters = getCurrentFilters();
    currentFilters.page = page;
    loadInterviews(currentFilters);
}

function getCurrentFilters() {
    return {
        search: document.getElementById('search-input')?.value || '',
        status: document.getElementById('status-filter')?.value || '',
        position: document.getElementById('position-filter')?.value || '',
        dateFrom: document.getElementById('date-from')?.value || '',
        dateTo: document.getElementById('date-to')?.value || ''
    };
}

// Utility Functions
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

function showLoading() {
    // Show loading spinner
    console.log('Loading...');
}

function hideLoading() {
    // Hide loading spinner
    console.log('Loading complete');
}

function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 16px 24px;
        background: ${type === 'success' ? '#48bb78' : type === 'error' ? '#f56565' : '#4299e1'};
        color: white;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 9999;
        animation: slideIn 0.3s ease;
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

function showRescheduleModal(id) {
    // This would show a modal for rescheduling
    console.log('Show reschedule modal for interview:', id);
}

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
