<?php
$this->load->view('templates/admin_header', array('page_title' => 'Email Templates'));
?>

<style>
.placeholder-container {
    max-width: 1200px;
    margin: 30px auto;
    padding: 40px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    text-align: center;
}

.placeholder-icon {
    font-size: 80px;
    color: #667eea;
    margin-bottom: 20px;
}

.placeholder-title {
    font-size: 32px;
    color: #333;
    margin-bottom: 15px;
    font-weight: 700;
}

.placeholder-subtitle {
    font-size: 18px;
    color: #666;
    margin-bottom: 30px;
}

.feature-list {
    text-align: left;
    max-width: 600px;
    margin: 30px auto;
    background: #f8f9fa;
    padding: 30px;
    border-radius: 8px;
}

.feature-list h4 {
    color: #667eea;
    margin-bottom: 20px;
}

.feature-list ul {
    list-style: none;
    padding: 0;
}

.feature-list li {
    padding: 10px 0;
    border-bottom: 1px solid #e0e0e0;
}

.feature-list li:last-child {
    border-bottom: none;
}

.feature-list li i {
    color: #4caf50;
    margin-right: 10px;
}

.btn-back {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 12px 30px;
    border-radius: 6px;
    text-decoration: none;
    display: inline-block;
    margin-top: 20px;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-back:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    color: white;
    text-decoration: none;
}

.template-preview {
    text-align: left;
    max-width: 800px;
    margin: 30px auto;
}

.template-card {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    border-left: 4px solid #667eea;
}

.template-card h5 {
    color: #667eea;
    margin-bottom: 10px;
}

.template-card .template-subject {
    font-weight: 600;
    color: #333;
    margin-bottom: 10px;
}

.template-card .template-body {
    color: #666;
    font-size: 14px;
    line-height: 1.6;
    background: white;
    padding: 15px;
    border-radius: 4px;
}

.placeholder-tag {
    background: #e3f2fd;
    color: #1976d2;
    padding: 2px 8px;
    border-radius: 3px;
    font-size: 12px;
    font-family: monospace;
}
</style>

<div class="placeholder-container">
    <div class="placeholder-icon">
        <i class="fas fa-envelope"></i>
    </div>
    
    <h1 class="placeholder-title">Email Templates</h1>
    <p class="placeholder-subtitle">Manage interview invitation and notification email templates</p>
    
    <div class="feature-list">
        <h4><i class="fas fa-wrench"></i> Planned Features</h4>
        <ul>
            <li><i class="fas fa-check"></i> Create custom email templates</li>
            <li><i class="fas fa-check"></i> Edit existing templates</li>
            <li><i class="fas fa-check"></i> Use placeholders: {candidate_name}, {interview_date}, {meeting_link}</li>
            <li><i class="fas fa-check"></i> Preview templates before sending</li>
            <li><i class="fas fa-check"></i> Set default templates for different interview types</li>
            <li><i class="fas fa-check"></i> HTML email support</li>
        </ul>
    </div>
    
    <div class="template-preview">
        <h3 style="color: #667eea; margin-bottom: 20px; text-align: center;">
            <i class="fas fa-eye"></i> Sample Templates
        </h3>
        
        <div class="template-card">
            <h5><i class="fas fa-paper-plane"></i> Interview Invitation</h5>
            <div class="template-subject">
                Subject: Interview Invitation - <span class="placeholder-tag">{job_position}</span>
            </div>
            <div class="template-body">
                Dear <span class="placeholder-tag">{candidate_name}</span>,<br><br>
                
                We are pleased to invite you for an interview for the <span class="placeholder-tag">{job_position}</span> position.<br><br>
                
                <strong>Interview Details:</strong><br>
                Date: <span class="placeholder-tag">{interview_date}</span><br>
                Time: <span class="placeholder-tag">{interview_time}</span><br>
                Duration: <span class="placeholder-tag">{duration}</span><br>
                Type: <span class="placeholder-tag">{interview_type}</span><br>
                Meeting Link: <span class="placeholder-tag">{meeting_link}</span><br><br>
                
                Interviewer: <span class="placeholder-tag">{interviewer_name}</span><br><br>
                
                Please confirm your availability by replying to this email.<br><br>
                
                Best regards,<br>
                HR Team
            </div>
        </div>
        
        <div class="template-card">
            <h5><i class="fas fa-clock"></i> Interview Reminder</h5>
            <div class="template-subject">
                Subject: Reminder: Interview Tomorrow - <span class="placeholder-tag">{job_position}</span>
            </div>
            <div class="template-body">
                Dear <span class="placeholder-tag">{candidate_name}</span>,<br><br>
                
                This is a friendly reminder about your upcoming interview scheduled for tomorrow.<br><br>
                
                <strong>Interview Details:</strong><br>
                Date: <span class="placeholder-tag">{interview_date}</span><br>
                Time: <span class="placeholder-tag">{interview_time}</span><br>
                Meeting Link: <span class="placeholder-tag">{meeting_link}</span><br><br>
                
                Please join the meeting 5 minutes early.<br><br>
                
                We look forward to meeting you!<br><br>
                
                Best regards,<br>
                HR Team
            </div>
        </div>
        
        <div class="template-card">
            <h5><i class="fas fa-calendar-times"></i> Interview Cancellation</h5>
            <div class="template-subject">
                Subject: Interview Rescheduling - <span class="placeholder-tag">{job_position}</span>
            </div>
            <div class="template-body">
                Dear <span class="placeholder-tag">{candidate_name}</span>,<br><br>
                
                We regret to inform you that we need to reschedule your interview originally scheduled for <span class="placeholder-tag">{interview_date}</span>.<br><br>
                
                We will contact you shortly with alternative dates and times.<br><br>
                
                We apologize for any inconvenience this may cause.<br><br>
                
                Best regards,<br>
                HR Team
            </div>
        </div>
        
        <p style="text-align: center; color: #666; margin-top: 30px;">
            <i class="fas fa-info-circle"></i> These are sample templates. Full template editor coming soon!
        </p>
    </div>
    
    <a href="<?= base_url('Setup/interview_configuration') ?>" class="btn-back">
        <i class="fas fa-arrow-left"></i> Back to Interview Configuration
    </a>
</div>

<?php
$this->load->view('templates/admin_footer');
?>
