<?php
// Set page-specific variables
$data['page_title'] = 'Automation Settings';
$this->load->view('templates/admin_header', $data);
?>

<style>
.section-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 16px 24px;
    border-radius: 12px;
    margin-bottom: 24px;
}
.config-card {
    background: white;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    margin-bottom: 24px;
}
.feature-card {
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 16px;
    transition: all 0.3s;
}
.feature-card:hover {
    border-color: #667eea;
    background: #f7fafc;
}
</style>

<!-- Page Header -->
<div class="section-header">
    <h2 class="mb-1"><i class="fas fa-robot me-2"></i>Automation Settings</h2>
    <p class="mb-0 opacity-90">Configure email campaigns, assessments, and scoring rules</p>
</div>

<!-- Flash Messages -->
<?php if($this->session->flashdata('automation_success_msg')): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert" id="automationSuccessAlert">
    <i class="fas fa-check-circle me-2"></i>
    <?= $this->session->flashdata('automation_success_msg') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<script>
setTimeout(function() {
    var alert = document.getElementById('automationSuccessAlert');
    if (alert) {
        var bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    }
}, 5000);
</script>
<?php endif; ?>

<?php if($this->session->flashdata('automation_error_msg')): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert" id="automationErrorAlert">
    <i class="fas fa-exclamation-circle me-2"></i>
    <?= $this->session->flashdata('automation_error_msg') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<script>
setTimeout(function() {
    var alert = document.getElementById('automationErrorAlert');
    if (alert) {
        var bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    }
}, 8000);
</script>
<?php endif; ?>

<!-- Tabs -->
<ul class="nav nav-pills mb-4">
    <li class="nav-item">
        <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#campaigns">
            <i class="fas fa-mail-bulk me-2"></i>Email Campaigns
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#assessments">
            <i class="fas fa-clipboard-check me-2"></i>Assessment Settings
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#scoring">
            <i class="fas fa-star me-2"></i>Scoring Rules
        </button>
    </li>
</ul>

<div class="tab-content">
    
    <!-- Email Campaigns Tab -->
    <div class="tab-pane fade show active" id="campaigns">
        <div class="config-card">
            <h4 class="mb-4"><i class="fas fa-mail-bulk me-2 text-primary"></i>Email Campaign Sequences</h4>
            
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="feature-card">
                        <h5 class="mb-2">Welcome Series</h5>
                        <p class="text-muted small mb-3">3-email sequence for new candidates</p>
                        <div class="mb-2"><small><strong>Day 1:</strong> Welcome & Introduction</small></div>
                        <div class="mb-2"><small><strong>Day 3:</strong> Company Culture & Benefits</small></div>
                        <div class="mb-3"><small><strong>Day 7:</strong> Next Steps & FAQ</small></div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" checked>
                            <label class="form-check-label small">Enable campaign</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="feature-card">
                        <h5 class="mb-2">Interview Follow-up</h5>
                        <p class="text-muted small mb-3">Post-interview engagement sequence</p>
                        <div class="mb-2"><small><strong>Day 1:</strong> Thank you for interviewing</small></div>
                        <div class="mb-2"><small><strong>Day 3:</strong> Status update</small></div>
                        <div class="mb-3"><small><strong>Day 7:</strong> Final decision notification</small></div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" checked>
                            <label class="form-check-label small">Enable campaign</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="feature-card">
                        <h5 class="mb-2">Re-engagement Campaign</h5>
                        <p class="text-muted small mb-3">For candidates in "Hold" status</p>
                        <div class="mb-2"><small><strong>Week 2:</strong> Check-in email</small></div>
                        <div class="mb-2"><small><strong>Week 4:</strong> New opportunities</small></div>
                        <div class="mb-3"><small><strong>Week 8:</strong> Final follow-up</small></div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox">
                            <label class="form-check-label small">Enable campaign</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="feature-card">
                        <h5 class="mb-2">Onboarding Series</h5>
                        <p class="text-muted small mb-3">For selected candidates</p>
                        <div class="mb-2"><small><strong>Day 1:</strong> Congratulations & offer details</small></div>
                        <div class="mb-2"><small><strong>Day 3:</strong> Onboarding checklist</small></div>
                        <div class="mb-3"><small><strong>Day 7:</strong> First day preparation</small></div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" checked>
                            <label class="form-check-label small">Enable campaign</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Assessment Settings Tab -->
    <div class="tab-pane fade" id="assessments">
        <div class="config-card">
            <h4 class="mb-4"><i class="fas fa-clipboard-check me-2 text-success"></i>Assessment Configuration</h4>
            
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="feature-card">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="mb-0">Technical Skills Test</h5>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" checked>
                            </div>
                        </div>
                        <p class="text-muted small mb-3">For technical positions</p>
                        <div class="mb-2"><small><i class="fas fa-clock me-1"></i>Duration: 60 minutes</small></div>
                        <div class="mb-2"><small><i class="fas fa-question-circle me-1"></i>Questions: 30</small></div>
                        <div class="mb-3"><small><i class="fas fa-check-circle me-1"></i>Pass Score: 70%</small></div>
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#techConfig">
                            <i class="fas fa-cog me-1"></i>Configure
                        </button>
                        
                        <div class="collapse mt-3" id="techConfig">
                            <hr>
                            <form action="<?= base_url('Setup/save_assessment_config') ?>" method="POST">
                                <input type="hidden" name="assessment_type" value="technical">
                                <div class="mb-2">
                                    <label class="form-label small">Duration (minutes)</label>
                                    <input type="number" class="form-control form-control-sm" name="duration" value="60">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small">Number of Questions</label>
                                    <input type="number" class="form-control form-control-sm" name="questions" value="30">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small">Pass Score (%)</label>
                                    <input type="number" class="form-control form-control-sm" name="pass_score" value="70" min="0" max="100">
                                </div>
                                <button type="submit" class="btn btn-sm btn-success">
                                    <i class="fas fa-save me-1"></i>Save
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="feature-card">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="mb-0">Aptitude Test</h5>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" checked>
                            </div>
                        </div>
                        <p class="text-muted small mb-3">General reasoning & logic</p>
                        <div class="mb-2"><small><i class="fas fa-clock me-1"></i>Duration: 45 minutes</small></div>
                        <div class="mb-2"><small><i class="fas fa-question-circle me-1"></i>Questions: 40</small></div>
                        <div class="mb-3"><small><i class="fas fa-check-circle me-1"></i>Pass Score: 60%</small></div>
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#aptitudeConfig">
                            <i class="fas fa-cog me-1"></i>Configure
                        </button>
                        
                        <div class="collapse mt-3" id="aptitudeConfig">
                            <hr>
                            <form action="<?= base_url('Setup/save_assessment_config') ?>" method="POST">
                                <input type="hidden" name="assessment_type" value="aptitude">
                                <div class="mb-2">
                                    <label class="form-label small">Duration (minutes)</label>
                                    <input type="number" class="form-control form-control-sm" name="duration" value="45">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small">Number of Questions</label>
                                    <input type="number" class="form-control form-control-sm" name="questions" value="40">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small">Pass Score (%)</label>
                                    <input type="number" class="form-control form-control-sm" name="pass_score" value="60" min="0" max="100">
                                </div>
                                <button type="submit" class="btn btn-sm btn-success">
                                    <i class="fas fa-save me-1"></i>Save
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="feature-card">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="mb-0">Personality Assessment</h5>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox">
                            </div>
                        </div>
                        <p class="text-muted small mb-3">Cultural fit evaluation</p>
                        <div class="mb-2"><small><i class="fas fa-clock me-1"></i>Duration: 20 minutes</small></div>
                        <div class="mb-2"><small><i class="fas fa-question-circle me-1"></i>Questions: 50</small></div>
                        <div class="mb-3"><small><i class="fas fa-chart-bar me-1"></i>Type: Personality Profile</small></div>
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#personalityConfig">
                            <i class="fas fa-cog me-1"></i>Configure
                        </button>
                        
                        <div class="collapse mt-3" id="personalityConfig">
                            <hr>
                            <form action="<?= base_url('Setup/save_assessment_config') ?>" method="POST">
                                <input type="hidden" name="assessment_type" value="personality">
                                <div class="mb-2">
                                    <label class="form-label small">Duration (minutes)</label>
                                    <input type="number" class="form-control form-control-sm" name="duration" value="20">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small">Number of Questions</label>
                                    <input type="number" class="form-control form-control-sm" name="questions" value="50">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small">Assessment Type</label>
                                    <select class="form-select form-select-sm" name="assessment_subtype">
                                        <option>MBTI</option>
                                        <option>Big Five</option>
                                        <option>DISC</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-sm btn-success">
                                    <i class="fas fa-save me-1"></i>Save
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="feature-card">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="mb-0">Coding Challenge</h5>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" checked>
                            </div>
                        </div>
                        <p class="text-muted small mb-3">For software developers</p>
                        <div class="mb-2"><small><i class="fas fa-clock me-1"></i>Duration: 90 minutes</small></div>
                        <div class="mb-2"><small><i class="fas fa-code me-1"></i>Problems: 3</small></div>
                        <div class="mb-3"><small><i class="fas fa-check-circle me-1"></i>Pass Score: 2/3</small></div>
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#codingConfig">
                            <i class="fas fa-cog me-1"></i>Configure
                        </button>
                        
                        <div class="collapse mt-3" id="codingConfig">
                            <hr>
                            <form action="<?= base_url('Setup/save_assessment_config') ?>" method="POST">
                                <input type="hidden" name="assessment_type" value="coding">
                                <div class="mb-2">
                                    <label class="form-label small">Duration (minutes)</label>
                                    <input type="number" class="form-control form-control-sm" name="duration" value="90">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small">Number of Problems</label>
                                    <input type="number" class="form-control form-control-sm" name="questions" value="3">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small">Difficulty Level</label>
                                    <select class="form-select form-select-sm" name="difficulty">
                                        <option>Easy</option>
                                        <option selected>Medium</option>
                                        <option>Hard</option>
                                        <option>Mixed</option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small">Pass Score (problems solved)</label>
                                    <input type="number" class="form-control form-control-sm" name="pass_score" value="2" min="1" max="3">
                                </div>
                                <button type="submit" class="btn btn-sm btn-success">
                                    <i class="fas fa-save me-1"></i>Save
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scoring Rules Tab -->
    <div class="tab-pane fade" id="scoring">
        <div class="config-card">
            <h4 class="mb-4"><i class="fas fa-star me-2 text-warning"></i>Candidate Scoring Rules</h4>
            
            <form action="<?= base_url('Setup/save_scoring_rules') ?>" method="POST" id="scoringForm">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="feature-card">
                            <h5 class="mb-3">Experience Weight</h5>
                            <p class="text-muted small mb-3">Years of Experience</p>
                            <input type="range" class="form-range scoring-slider" id="expSlider" min="0" max="100" value="30" name="exp_weight">
                            <div class="d-flex justify-content-between mt-2">
                                <small class="text-muted">0%</small>
                                <strong class="text-primary" id="expValue">30%</strong>
                                <small class="text-muted">100%</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="feature-card">
                            <h5 class="mb-3">Education Weight</h5>
                            <p class="text-muted small mb-3">Educational Qualification</p>
                            <input type="range" class="form-range scoring-slider" id="eduSlider" min="0" max="100" value="20" name="edu_weight">
                            <div class="d-flex justify-content-between mt-2">
                                <small class="text-muted">0%</small>
                                <strong class="text-primary" id="eduValue">20%</strong>
                                <small class="text-muted">100%</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="feature-card">
                            <h5 class="mb-3">Skills Match Weight</h5>
                            <p class="text-muted small mb-3">Technical Skills Match</p>
                            <input type="range" class="form-range scoring-slider" id="skillsSlider" min="0" max="100" value="35" name="skills_weight">
                            <div class="d-flex justify-content-between mt-2">
                                <small class="text-muted">0%</small>
                                <strong class="text-primary" id="skillsValue">35%</strong>
                                <small class="text-muted">100%</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="feature-card">
                            <h5 class="mb-3">Interview Performance</h5>
                            <p class="text-muted small mb-3">Interview Score</p>
                            <input type="range" class="form-range scoring-slider" id="interviewSlider" min="0" max="100" value="15" name="interview_weight">
                            <div class="d-flex justify-content-between mt-2">
                                <small class="text-muted">0%</small>
                                <strong class="text-primary" id="interviewValue">15%</strong>
                                <small class="text-muted">100%</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="alert" id="totalWeightAlert" style="background: #e0f2fe; border: 2px solid #0ea5e9; color: #0c4a6e;">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Total Weight:</strong> <span id="totalWeight">100</span>% | 
                            <span id="weightMessage">Candidates will be automatically scored based on these criteria.</span>
                        </div>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary" id="saveBtn">
                            <i class="fas fa-save me-2"></i>Save Scoring Rules
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Scoring Rules - Interactive Sliders
document.addEventListener('DOMContentLoaded', function() {
    // Handle URL hash to show correct tab
    const hash = window.location.hash;
    if (hash === '#scoring') {
        const scoringTab = document.querySelector('[data-bs-target="#scoring"]');
        if (scoringTab) {
            const tab = new bootstrap.Tab(scoringTab);
            tab.show();
        }
    } else if (hash === '#assessments') {
        const assessmentsTab = document.querySelector('[data-bs-target="#assessments"]');
        if (assessmentsTab) {
            const tab = new bootstrap.Tab(assessmentsTab);
            tab.show();
        }
    }
    
    const expSlider = document.getElementById('expSlider');
    const eduSlider = document.getElementById('eduSlider');
    const skillsSlider = document.getElementById('skillsSlider');
    const interviewSlider = document.getElementById('interviewSlider');
    
    const expValue = document.getElementById('expValue');
    const eduValue = document.getElementById('eduValue');
    const skillsValue = document.getElementById('skillsValue');
    const interviewValue = document.getElementById('interviewValue');
    
    const totalWeight = document.getElementById('totalWeight');
    const weightMessage = document.getElementById('weightMessage');
    const totalWeightAlert = document.getElementById('totalWeightAlert');
    const saveBtn = document.getElementById('saveBtn');
    
    function updateTotal() {
        const exp = parseInt(expSlider.value);
        const edu = parseInt(eduSlider.value);
        const skills = parseInt(skillsSlider.value);
        const interview = parseInt(interviewSlider.value);
        
        const total = exp + edu + skills + interview;
        
        // Update display values
        expValue.textContent = exp + '%';
        eduValue.textContent = edu + '%';
        skillsValue.textContent = skills + '%';
        interviewValue.textContent = interview + '%';
        totalWeight.textContent = total;
        
        // Update alert styling based on total
        if (total === 100) {
            totalWeightAlert.style.background = '#d1fae5';
            totalWeightAlert.style.borderColor = '#10b981';
            totalWeightAlert.style.color = '#065f46';
            weightMessage.textContent = 'Perfect! Candidates will be automatically scored based on these criteria.';
            saveBtn.disabled = false;
        } else if (total < 100) {
            totalWeightAlert.style.background = '#fef3c7';
            totalWeightAlert.style.borderColor = '#f59e0b';
            totalWeightAlert.style.color = '#92400e';
            weightMessage.textContent = 'Total weight is below 100%. Please adjust the sliders.';
            saveBtn.disabled = true;
        } else {
            totalWeightAlert.style.background = '#fee2e2';
            totalWeightAlert.style.borderColor = '#ef4444';
            totalWeightAlert.style.color = '#991b1b';
            weightMessage.textContent = 'Total weight exceeds 100%. Please adjust the sliders.';
            saveBtn.disabled = true;
        }
    }
    
    // Add event listeners
    if (expSlider) {
        expSlider.addEventListener('input', updateTotal);
        eduSlider.addEventListener('input', updateTotal);
        skillsSlider.addEventListener('input', updateTotal);
        interviewSlider.addEventListener('input', updateTotal);
        
        // Initialize
        updateTotal();
    }
});
</script>

<?php $this->load->view('templates/admin_footer'); ?>
