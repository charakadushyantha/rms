<style>
.create-interview-container {
    padding: 30px;
    max-width: 1000px;
    margin: 0 auto;
}

.page-header {
    margin-bottom: 30px;
}

.page-header h1 {
    color: #667eea;
    font-size: 28px;
    margin-bottom: 10px;
}

.page-header p {
    color: #666;
    font-size: 14px;
}

.form-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    padding: 30px;
}

.form-section {
    margin-bottom: 35px;
    padding-bottom: 25px;
    border-bottom: 2px solid #f0f0f0;
}

.form-section:last-of-type {
    border-bottom: none;
}

.section-title {
    font-size: 18px;
    font-weight: 700;
    color: #667eea;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.section-title i {
    font-size: 20px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}

.form-row.single {
    grid-template-columns: 1fr;
}

.form-row.triple {
    grid-template-columns: 1fr 1fr 1fr;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #333;
}

.form-group label .required {
    color: #f44336;
    margin-left: 3px;
}

.form-control {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
    transition: all 0.3s ease;
}

.form-control:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

textarea.form-control {
    min-height: 100px;
    resize: vertical;
}

.help-text {
    font-size: 12px;
    color: #666;
    margin-top: 5px;
    font-style: italic;
}

.mode-toggle {
    display: flex;
    gap: 10px;
    margin-bottom: 25px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
}

.mode-btn {
    flex: 1;
    padding: 12px 20px;
    border: 2px solid #ddd;
    background: white;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
    text-align: center;
}

.mode-btn:hover {
    border-color: #667eea;
}

.mode-btn.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-color: #667eea;
}

.candidate-section {
    display: none;
}

.candidate-section.active {
    display: block;
}

.info-badge {
    display: inline-block;
    padding: 4px 12px;
    background: #e3f2fd;
    color: #1976d2;
    border-radius: 4px;
    font-size: 12px;
    margin-left: 10px;
}

.candidate-info-text {
    font-size: 12px;
    color: #666;
    margin-top: 5px;
    padding: 8px;
    background: #f8f9fa;
    border-radius: 4px;
}

.interview-type-options {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
    margin-top: 10px;
}

.type-option {
    padding: 20px;
    border: 2px solid #ddd;
    border-radius: 8px;
    cursor: pointer;
    text-align: center;
    transition: all 0.3s ease;
    background: white;
}

.type-option:hover {
    border-color: #667eea;
    background: #f8f9fa;
}

.type-option.selected {
    border-color: #667eea;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
}

.type-option input[type="radio"] {
    display: none;
}

.type-option i {
    font-size: 32px;
    color: #667eea;
    margin-bottom: 10px;
    display: block;
}

.type-option label {
    display: block;
    font-weight: 600;
    cursor: pointer;
    margin: 0;
    color: #333;
}

.type-option .type-desc {
    font-size: 12px;
    color: #666;
    margin-top: 5px;
}

.conditional-field {
    display: none;
    margin-top: 20px;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 8px;
    border-left: 4px solid #667eea;
}

.conditional-field.active {
    display: block;
}

.duration-options {
    display: flex;
    gap: 10px;
    margin-top: 10px;
    flex-wrap: wrap;
}

.duration-btn {
    padding: 10px 20px;
    border: 2px solid #ddd;
    border-radius: 5px;
    background: white;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
    font-size: 14px;
}

.duration-btn:hover {
    border-color: #667eea;
}

.duration-btn.active {
    border-color: #667eea;
    background: #667eea;
    color: white;
}

.checkbox-group {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-top: 15px;
}

.checkbox-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    background: #f8f9fa;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.checkbox-item:hover {
    background: #e3f2fd;
}

.checkbox-item input[type="checkbox"] {
    width: 20px;
    height: 20px;
    cursor: pointer;
}

.checkbox-item label {
    margin: 0;
    cursor: pointer;
    font-weight: 500;
    flex: 1;
}

.checkbox-item i {
    font-size: 18px;
    color: #667eea;
}

.btn {
    padding: 14px 28px;
    border-radius: 6px;
    text-decoration: none;
    display: inline-block;
    font-weight: 600;
    font-size: 15px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #5a6268;
}

.form-actions {
    display: flex;
    gap: 15px;
    margin-top: 30px;
    padding-top: 25px;
    border-top: 2px solid #f0f0f0;
}

.alert {
    padding: 15px 20px;
    border-radius: 6px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.alert-info {
    background: #e3f2fd;
    border-left: 4px solid #2196f3;
    color: #1565c0;
}

.alert-warning {
    background: #fff3e0;
    border-left: 4px solid #ff9800;
    color: #e65100;
}

.alert i {
    font-size: 20px;
}

.auto-generate-btn {
    padding: 8px 16px;
    background: #4caf50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-weight: 600;
    font-size: 13px;
    margin-top: 8px;
    transition: all 0.3s ease;
}

.auto-generate-btn:hover {
    background: #45a049;
}

</style>

<div class="create-interview-container">
    <div class="page-header">
        <h1>🎯 Schedule Interview</h1>
        <p>Create a comprehensive interview schedule with all necessary details</p>
    </div>

    <div class="form-card">
        <form method="post" action="<?= base_url('interview/create_interview') ?>" id="interviewForm">
            
            <!-- Section 1: Interview Flow -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-stream"></i>
                    <span>Interview Flow</span>
                </div>
                <div class="form-group">
                    <label for="flow_id">Select Interview Flow <span class="required">*</span></label>
                    <select class="form-control" id="flow_id" name="flow_id" required>
                        <option value="">Choose an interview flow...</option>
                        <?php foreach ($flows as $flow): ?>
                        <option value="<?= $flow['id'] ?>" <?= $this->input->get('flow_id') == $flow['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($flow['job_title']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="help-text">Select the interview flow/template for this interview</div>
                </div>
            </div>

            <!-- Section 2: Candidate Selection -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-user"></i>
                    <span>Candidate Information</span>
                </div>

                
                <!-- Mode Toggle -->
                <div class="mode-toggle">
                    <button type="button" class="mode-btn active" id="selectExistingBtn" onclick="switchCandidateMode('existing')">
                        <i class="fas fa-user-check"></i> Select Existing Candidate
                        <span class="info-badge"><?= count($candidates) ?> registered</span>
                    </button>
                    <button type="button" class="mode-btn" id="addNewBtn" onclick="switchCandidateMode('new')">
                        <i class="fas fa-user-plus"></i> Add New Candidate
                    </button>
                </div>

                <!-- Select Existing Candidate -->
                <div class="candidate-section active" id="existingSection">
                    <div class="form-group">
                        <label for="existing_candidate">Select Registered Candidate <span class="required">*</span></label>
                        <select class="form-control" id="existing_candidate" name="existing_candidate">
                            <option value="">Choose a candidate...</option>
                            <?php 
                            $has_account_count = 0;
                            $no_account_count = 0;
                            foreach ($candidates as $candidate): 
                                $has_account = $candidate['has_account'] == 1;
                                if ($has_account) $has_account_count++;
                                else $no_account_count++;
                                
                                $badge_text = $has_account ? '✓ Has Account' : '⚠ No Account';
                                $job_title = !empty($candidate['cd_job_title']) ? ' - ' . htmlspecialchars($candidate['cd_job_title']) : '';
                            ?>
                            <option 
                                value="<?= $candidate['cd_id'] ?? $candidate['u_id'] ?>"
                                data-name="<?= htmlspecialchars($candidate['cd_name']) ?>"
                                data-email="<?= htmlspecialchars($candidate['cd_email']) ?>"
                                data-phone="<?= htmlspecialchars($candidate['cd_phone'] ?? '') ?>">
                                <?= htmlspecialchars($candidate['cd_name']) ?> - <?= htmlspecialchars($candidate['cd_email']) ?><?= $job_title ?> [<?= $badge_text ?>]
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="candidate-info-text">
                            <i class="fas fa-info-circle"></i> 
                            <strong>Total: <?= count($candidates) ?> candidates</strong> | 
                            <span style="color: #2e7d32;">✓ <?= $has_account_count ?> with accounts</span> | 
                            <span style="color: #e65100;">⚠ <?= $no_account_count ?> without accounts</span>
                        </div>
                    </div>
                </div>


                <!-- Add New Candidate -->
                <div class="candidate-section" id="newSection">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="candidate_name">Candidate Name <span class="required">*</span></label>
                            <input type="text" class="form-control" id="candidate_name" name="candidate_name">
                        </div>
                        <div class="form-group">
                            <label for="candidate_email">Candidate Email <span class="required">*</span></label>
                            <input type="email" class="form-control" id="candidate_email" name="candidate_email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="candidate_phone">Candidate Phone</label>
                        <input type="tel" class="form-control" id="candidate_phone" name="candidate_phone" placeholder="+94 XX XXX XXXX">
                    </div>
                </div>
            </div>

            <!-- Section 3: Interview Schedule -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Interview Schedule</span>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="interview_date">Interview Date <span class="required">*</span></label>
                        <input type="date" class="form-control" id="interview_date" name="interview_date" required 
                               min="<?= date('Y-m-d') ?>">
                        <div class="help-text">Select the date for the interview</div>
                    </div>
                    <div class="form-group">
                        <label for="interview_round">Interview Round <span class="required">*</span></label>
                        <select class="form-control" id="interview_round" name="interview_round" required>
                            <?php if (isset($interview_rounds) && !empty($interview_rounds)): ?>
                                <?php foreach ($interview_rounds as $round): ?>
                                <option value="<?= htmlspecialchars($round['round_name']) ?>" 
                                        data-duration="<?= $round['default_duration'] ?>">
                                    <?= htmlspecialchars($round['round_name']) ?>
                                    <?php if ($round['default_duration']): ?>
                                        (<?= $round['default_duration'] ?> min)
                                    <?php endif; ?>
                                </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <!-- Fallback if configuration not set -->
                                <option value="Round 1">Round 1 - Initial Screening</option>
                                <option value="Round 2">Round 2 - Second Interview</option>
                                <option value="Technical Round">Technical Round</option>
                                <option value="HR Round">HR Round</option>
                                <option value="Final Round">Final Round</option>
                                <option value="Panel Interview">Panel Interview</option>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                
                <div class="form-row">
                    <div class="form-group">
                        <label for="interview_start_time">Start Time <span class="required">*</span></label>
                        <div style="display: flex; gap: 10px; align-items: center;">
                            <select class="form-control" id="start_hour" name="start_hour" required style="width: 80px;">
                                <option value="">HH</option>
                                <?php for($h = 0; $h < 24; $h++): ?>
                                <option value="<?= sprintf('%02d', $h) ?>"><?= sprintf('%02d', $h) ?></option>
                                <?php endfor; ?>
                            </select>
                            <span style="font-weight: bold;">:</span>
                            <select class="form-control" id="start_minute" name="start_minute" required style="width: 80px;">
                                <option value="">MM</option>
                                <option value="00">00</option>
                                <option value="15">15</option>
                                <option value="30">30</option>
                                <option value="45">45</option>
                                <option value="custom">Custom</option>
                            </select>
                            <input type="number" class="form-control" id="custom_minute" name="custom_minute" 
                                   min="0" max="59" placeholder="MM" style="width: 70px; display: none;">
                            <input type="hidden" id="interview_start_time" name="interview_start_time">
                        </div>
                        <div class="help-text">Select hour and minute (or choose custom)</div>
                    </div>
                    <div class="form-group">
                        <label>Duration <span class="required">*</span></label>
                        <div class="duration-options">
                            <?php if (isset($duration_presets) && !empty($duration_presets)): ?>
                                <?php foreach ($duration_presets as $preset): ?>
                                <button type="button" class="duration-btn <?= $preset['is_default'] ? 'active' : '' ?>" 
                                        onclick="setDuration(<?= $preset['duration_minutes'] ?>)">
                                    <?= htmlspecialchars($preset['preset_name']) ?>
                                </button>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <!-- Fallback if configuration not set -->
                                <button type="button" class="duration-btn" onclick="setDuration(30)">30 min</button>
                                <button type="button" class="duration-btn active" onclick="setDuration(60)">1 hour</button>
                                <button type="button" class="duration-btn" onclick="setDuration(90)">1.5 hrs</button>
                                <button type="button" class="duration-btn" onclick="setDuration(120)">2 hours</button>
                            <?php endif; ?>
                            <button type="button" class="duration-btn" onclick="setDuration('custom')">Custom</button>
                        </div>
                        <input type="number" class="form-control" id="custom_duration" name="custom_duration" 
                               min="15" max="480" placeholder="Minutes" style="display: none; margin-top: 10px;">
                        <input type="hidden" id="interview_duration" name="interview_duration" 
                               value="<?= isset($interview_config) ? $interview_config->default_duration : 60 ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>End Time (Auto-calculated)</label>
                    <div style="padding: 12px; background: #f8f9fa; border-radius: 5px; border: 1px solid #ddd;">
                        <span id="end_time_display" style="font-size: 18px; font-weight: 600; color: #667eea;">
                            <i class="fas fa-clock"></i> --:-- (Select start time and duration)
                        </span>
                    </div>
                    <input type="hidden" id="interview_end_time" name="interview_end_time">
                </div>
            </div>

            <!-- Section 4: Interview Type & Details -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-video"></i>
                    <span>Interview Mode & Details</span>
                </div>
                
                <div class="form-group">
                    <label>Interview Type <span class="required">*</span></label>
                    <div class="interview-type-options">
                        <?php 
                        $default_type = isset($interview_config) ? $interview_config->default_interview_type : 'online';
                        ?>
                        <div class="type-option <?= $default_type == 'online' ? 'selected' : '' ?>" onclick="selectInterviewType('online')">
                            <input type="radio" name="interview_type" value="online" id="type_online" <?= $default_type == 'online' ? 'checked' : '' ?>>
                            <label for="type_online">
                                <i class="fas fa-video"></i>
                                Online
                                <div class="type-desc">Video conference</div>
                            </label>
                        </div>
                        <div class="type-option <?= $default_type == 'in_person' ? 'selected' : '' ?>" onclick="selectInterviewType('in_person')">
                            <input type="radio" name="interview_type" value="in_person" id="type_in_person" <?= $default_type == 'in_person' ? 'checked' : '' ?>>
                            <label for="type_in_person">
                                <i class="fas fa-building"></i>
                                In-Person
                                <div class="type-desc">Physical location</div>
                            </label>
                        </div>
                        <div class="type-option <?= $default_type == 'phone' ? 'selected' : '' ?>" onclick="selectInterviewType('phone')">
                            <input type="radio" name="interview_type" value="phone" id="type_phone" <?= $default_type == 'phone' ? 'checked' : '' ?>>
                            <label for="type_phone">
                                <i class="fas fa-phone"></i>
                                Phone
                                <div class="type-desc">Phone call</div>
                            </label>
                        </div>
                    </div>
                </div>


                <!-- Online Interview Details -->
                <div class="conditional-field active" id="onlineDetails">
                    <h4 style="margin-top: 0; color: #667eea;">📹 Online Meeting Details</h4>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="online_platform">Platform <span class="required">*</span></label>
                            <select class="form-control" id="online_platform" name="online_platform">
                                <option value="">Select platform...</option>
                                <?php if (isset($meeting_platforms) && !empty($meeting_platforms)): ?>
                                    <?php 
                                    $default_platform = isset($interview_config) ? $interview_config->default_platform : 'Zoom';
                                    foreach ($meeting_platforms as $platform): 
                                        if ($platform['platform_type'] == 'video'):
                                    ?>
                                    <option value="<?= htmlspecialchars($platform['platform_name']) ?>" 
                                            <?= $platform['platform_name'] == $default_platform ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($platform['platform_name']) ?>
                                    </option>
                                    <?php 
                                        endif;
                                    endforeach; 
                                    ?>
                                <?php else: ?>
                                    <!-- Fallback if configuration not set -->
                                    <option value="Zoom" selected>Zoom</option>
                                    <option value="Google Meet">Google Meet</option>
                                    <option value="Microsoft Teams">Microsoft Teams</option>
                                    <option value="Skype">Skype</option>
                                <?php endif; ?>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="meeting_link">Meeting Link <span class="required">*</span></label>
                            <input type="url" class="form-control" id="meeting_link" name="meeting_link" 
                                   placeholder="https://zoom.us/j/...">
                            <button type="button" class="auto-generate-btn" onclick="generateMeetingLink()">
                                <i class="fas fa-magic"></i> Auto-Generate Link
                            </button>
                            <div class="help-text">Generates template meeting details (replace with actual meeting)</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="meeting_id">Meeting ID (Optional)</label>
                            <input type="text" class="form-control" id="meeting_id" name="meeting_id" 
                                   placeholder="123 456 7890">
                        </div>
                        <div class="form-group">
                            <label for="meeting_password">Meeting Password (Optional)</label>
                            <input type="text" class="form-control" id="meeting_password" name="meeting_password">
                        </div>
                    </div>
                </div>

                <!-- In-Person Interview Details -->
                <div class="conditional-field" id="inPersonDetails">
                    <h4 style="margin-top: 0; color: #667eea;">🏢 Venue Details</h4>
                    <div class="form-group">
                        <label for="venue_location">Venue/Location <span class="required">*</span></label>
                        <textarea class="form-control" id="venue_location" name="venue_location" rows="3"
                                  placeholder="Enter full address: Building name, street, city"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="venue_room">Room Number/Name</label>
                        <input type="text" class="form-control" id="venue_room" name="venue_room" 
                               placeholder="e.g., Conference Room A, 3rd Floor">
                    </div>
                </div>

                <!-- Phone Interview Details -->
                <div class="conditional-field" id="phoneDetails">
                    <h4 style="margin-top: 0; color: #667eea;">📞 Phone Interview Details</h4>
                    <div class="form-group">
                        <label for="phone_number">Phone Number <span class="required">*</span></label>
                        <input type="tel" class="form-control" id="phone_number" name="phone_number" 
                               placeholder="+94 XX XXX XXXX">
                        <div class="help-text">The interviewer will call this number</div>
                    </div>
                </div>
            </div>


            <!-- Section 5: Interviewer Assignment -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-user-tie"></i>
                    <span>Interviewer Assignment</span>
                </div>
                
                <?php 
                $allow_multiple = isset($interview_config) && $interview_config->allow_multiple_interviewers;
                $max_interviewers = isset($interview_config) ? $interview_config->max_interviewers : 3;
                ?>
                
                <?php if ($allow_multiple): ?>
                <!-- Multiple Interviewers Mode -->
                <div class="info-box" style="background: #e8f5e9; border-left-color: #4caf50;">
                    <i class="fas fa-users" style="color: #4caf50;"></i>
                    <strong>Panel Interview Mode:</strong> You can assign up to <?= $max_interviewers ?> interviewers for this interview.
                </div>
                
                <div id="interviewers-container">
                    <!-- Primary Interviewer -->
                    <div class="form-group interviewer-group" data-interviewer-index="1">
                        <label for="assigned_interviewer_1">
                            Primary Interviewer <span class="required">*</span>
                            <span class="badge" style="background: #667eea; color: white; font-size: 11px; padding: 3px 8px; border-radius: 3px;">Lead</span>
                        </label>
                        <select class="form-control interviewer-select" id="assigned_interviewer_1" name="assigned_interviewers[]" required>
                            <option value="">Select primary interviewer...</option>
                            <?php if (isset($interviewers) && !empty($interviewers)): ?>
                                <?php foreach ($interviewers as $interviewer): ?>
                                <option value="<?= $interviewer['u_username'] ?>" data-id="<?= $interviewer['u_id'] ?>" data-email="<?= $interviewer['u_email'] ?>">
                                    <?= htmlspecialchars($interviewer['u_username']) ?> - <?= htmlspecialchars($interviewer['u_email']) ?>
                                </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="" disabled>No interviewers available</option>
                            <?php endif; ?>
                        </select>
                        <div class="help-text">The main interviewer who will lead the interview</div>
                    </div>
                    
                    <!-- Additional Interviewers (dynamically added) -->
                    <div id="additional-interviewers"></div>
                </div>
                
                <button type="button" class="btn" id="add-interviewer-btn" 
                        style="background: #4caf50; color: white; padding: 10px 20px; margin-top: 10px;"
                        onclick="addInterviewer()">
                    <i class="fas fa-plus me-2"></i>Add Another Interviewer
                </button>
                <small class="text-muted d-block" style="margin-top: 5px;">
                    You can add up to <?= $max_interviewers - 1 ?> more interviewer(s)
                </small>
                
                <?php else: ?>
                <!-- Single Interviewer Mode -->
                <div class="form-group">
                    <label for="assigned_interviewer">Assigned Interviewer <span class="required">*</span></label>
                    <select class="form-control" id="assigned_interviewer" name="assigned_interviewer" required>
                        <option value="">Select an interviewer...</option>
                        <?php if (isset($interviewers) && !empty($interviewers)): ?>
                            <?php foreach ($interviewers as $interviewer): ?>
                            <option value="<?= $interviewer['u_username'] ?>" data-id="<?= $interviewer['u_id'] ?>">
                                <?= htmlspecialchars($interviewer['u_username']) ?> - <?= htmlspecialchars($interviewer['u_email']) ?>
                            </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="" disabled>No interviewers available</option>
                        <?php endif; ?>
                    </select>
                    <div class="help-text">Select the interviewer who will conduct this interview</div>
                </div>
                <?php endif; ?>
                
                <div id="interviewer_conflict_warning" class="alert alert-warning" style="display: none; margin-top: 10px;">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>Warning: One or more interviewers may have a scheduling conflict</span>
                </div>
            </div>

            <!-- Section 6: Job Position -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-briefcase"></i>
                    <span>Job Position</span>
                </div>
                
                <div class="form-group">
                    <label for="job_position">Job Position/Vacancy (Optional)</label>
                    <select class="form-control" id="job_position" name="job_position">
                        <option value="">Select job position...</option>
                        <?php if (isset($job_positions) && !empty($job_positions)): ?>
                            <?php foreach ($job_positions as $position): ?>
                            <option value="<?= htmlspecialchars($position['cd_job_title']) ?>">
                                <?= htmlspecialchars($position['cd_job_title']) ?>
                            </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <option value="other">Other (specify in notes)</option>
                    </select>
                    <div class="help-text">Link this interview to a specific job opening</div>
                </div>
            </div>


            <!-- Section 7: Notes & Instructions -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-sticky-note"></i>
                    <span>Notes & Instructions</span>
                </div>
                
                <div class="form-group">
                    <label for="interview_notes">Interview Notes (Visible to Candidate)</label>
                    <textarea class="form-control" id="interview_notes" name="interview_notes" rows="4"
                              placeholder="Instructions for the candidate: what to prepare, what to bring, dress code, etc."></textarea>
                    <div class="help-text">These notes will be included in the interview invitation email</div>
                </div>
                
                <div class="form-group">
                    <label for="internal_notes">Internal Notes (Admin Only)</label>
                    <textarea class="form-control" id="internal_notes" name="internal_notes" rows="3"
                              placeholder="Internal comments, special considerations, evaluation criteria, etc."></textarea>
                    <div class="help-text">These notes are only visible to admin and interviewers</div>
                </div>
            </div>

            <!-- Section 8: Notifications & Sync -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-bell"></i>
                    <span>Notifications & Calendar Sync</span>
                </div>
                
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <span>Choose how to notify the candidate and sync the interview to calendars</span>
                </div>

                <div class="checkbox-group">
                    <?php 
                    $email_enabled = !isset($interview_config) || $interview_config->enable_email_notifications;
                    $whatsapp_enabled = !isset($interview_config) || $interview_config->enable_whatsapp_notifications;
                    $sms_enabled = !isset($interview_config) || $interview_config->enable_sms_notifications;
                    $calendar_enabled = !isset($interview_config) || $interview_config->enable_calendar_sync;
                    ?>
                    
                    <?php if ($email_enabled): ?>
                    <div class="checkbox-item">
                        <input type="checkbox" id="send_email" name="send_email" value="1" checked>
                        <i class="fas fa-envelope"></i>
                        <label for="send_email">Send interview invitation via Email</label>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($whatsapp_enabled): ?>
                    <div class="checkbox-item">
                        <input type="checkbox" id="send_whatsapp" name="send_whatsapp" value="1">
                        <i class="fab fa-whatsapp"></i>
                        <label for="send_whatsapp">Send WhatsApp notification (Sri Lanka context)</label>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($sms_enabled): ?>
                    <div class="checkbox-item">
                        <input type="checkbox" id="send_sms" name="send_sms" value="1">
                        <i class="fas fa-sms"></i>
                        <label for="send_sms">Send SMS notification (requires SMS gateway)</label>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($calendar_enabled): ?>
                    <div class="checkbox-item">
                        <input type="checkbox" id="sync_calendar" name="sync_calendar" value="1">
                        <i class="fas fa-calendar-plus"></i>
                        <label for="sync_calendar">Add to Google Calendar automatically</label>
                    </div>
                    <?php endif; ?>
                    
                    <div class="checkbox-item">
                        <input type="checkbox" id="send_reminder" name="send_reminder" value="1" checked>
                        <i class="fas fa-clock"></i>
                        <label for="send_reminder">Send reminder <?= isset($interview_config) ? $interview_config->reminder_hours_before : 24 ?> hours before interview</label>
                    </div>
                    
                    <?php if (!$email_enabled && !$whatsapp_enabled && !$sms_enabled && !$calendar_enabled): ?>
                    <div class="alert alert-warning" style="margin-top: 10px;">
                        <i class="fas fa-exclamation-triangle"></i>
                        All notification channels are disabled in configuration. Please enable them in 
                        <a href="<?= base_url('Setup/interview_configuration') ?>" target="_blank">Interview Configuration</a>.
                    </div>
                    <?php endif; ?>
                </div>
            </div>


            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-calendar-check"></i> Schedule Interview
                </button>
                <a href="<?= base_url('interview/interviews') ?>" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>

        </form>
    </div>
</div>

<script>
(function() {
    var currentCandidateMode = 'existing';
    var currentInterviewType = 'online';
    
    // Candidate Mode Switching
    window.switchCandidateMode = function(mode) {
        currentCandidateMode = mode;
        
        var selectBtn = document.getElementById('selectExistingBtn');
        var addBtn = document.getElementById('addNewBtn');
        var existingSection = document.getElementById('existingSection');
        var newSection = document.getElementById('newSection');
        
        if (mode === 'existing') {
            selectBtn.classList.add('active');
            addBtn.classList.remove('active');
            existingSection.classList.add('active');
            newSection.classList.remove('active');
            
            document.getElementById('candidate_name').value = '';
            document.getElementById('candidate_email').value = '';
            document.getElementById('candidate_phone').value = '';
            document.getElementById('candidate_name').removeAttribute('required');
            document.getElementById('candidate_email').removeAttribute('required');
            document.getElementById('existing_candidate').setAttribute('required', 'required');
        } else {
            selectBtn.classList.remove('active');
            addBtn.classList.add('active');
            existingSection.classList.remove('active');
            newSection.classList.add('active');
            
            document.getElementById('existing_candidate').value = '';
            document.getElementById('existing_candidate').removeAttribute('required');
            document.getElementById('candidate_name').setAttribute('required', 'required');
            document.getElementById('candidate_email').setAttribute('required', 'required');
        }
    };

    
    // Auto-fill candidate details when selecting from dropdown
    document.getElementById('existing_candidate').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            var name = selectedOption.getAttribute('data-name');
            var email = selectedOption.getAttribute('data-email');
            var phone = selectedOption.getAttribute('data-phone');
            
            document.getElementById('candidate_name').value = name;
            document.getElementById('candidate_email').value = email;
            document.getElementById('candidate_phone').value = phone;
        } else {
            document.getElementById('candidate_name').value = '';
            document.getElementById('candidate_email').value = '';
            document.getElementById('candidate_phone').value = '';
        }
    });
    
    // Interview Type Selection
    window.selectInterviewType = function(type) {
        currentInterviewType = type;
        
        // Update radio buttons
        document.querySelectorAll('.type-option').forEach(function(option) {
            option.classList.remove('selected');
        });
        event.currentTarget.classList.add('selected');
        document.getElementById('type_' + type).checked = true;
        
        // Show/hide conditional fields
        document.getElementById('onlineDetails').classList.remove('active');
        document.getElementById('inPersonDetails').classList.remove('active');
        document.getElementById('phoneDetails').classList.remove('active');
        
        // Clear and update required fields
        document.getElementById('online_platform').removeAttribute('required');
        document.getElementById('meeting_link').removeAttribute('required');
        document.getElementById('venue_location').removeAttribute('required');
        document.getElementById('phone_number').removeAttribute('required');
        
        if (type === 'online') {
            document.getElementById('onlineDetails').classList.add('active');
            document.getElementById('online_platform').setAttribute('required', 'required');
            document.getElementById('meeting_link').setAttribute('required', 'required');
        } else if (type === 'in_person') {
            document.getElementById('inPersonDetails').classList.add('active');
            document.getElementById('venue_location').setAttribute('required', 'required');
        } else if (type === 'phone') {
            document.getElementById('phoneDetails').classList.add('active');
            document.getElementById('phone_number').setAttribute('required', 'required');
        }
    };

    
    // Duration Selection
    window.setDuration = function(minutes) {
        document.querySelectorAll('.duration-btn').forEach(function(btn) {
            btn.classList.remove('active');
        });
        event.target.classList.add('active');
        
        var customDurationInput = document.getElementById('custom_duration');
        
        if (minutes === 'custom') {
            customDurationInput.style.display = 'block';
            customDurationInput.focus();
            customDurationInput.addEventListener('input', function() {
                var customValue = parseInt(this.value);
                if (customValue >= 15 && customValue <= 480) {
                    document.getElementById('interview_duration').value = customValue;
                    calculateEndTime();
                }
            });
        } else {
            customDurationInput.style.display = 'none';
            document.getElementById('interview_duration').value = minutes;
            calculateEndTime();
        }
    };
    
    // Handle custom minute selection
    document.getElementById('start_minute').addEventListener('change', function() {
        var customMinuteInput = document.getElementById('custom_minute');
        
        if (this.value === 'custom') {
            customMinuteInput.style.display = 'inline-block';
            customMinuteInput.focus();
            customMinuteInput.addEventListener('input', function() {
                var customValue = parseInt(this.value);
                if (customValue >= 0 && customValue <= 59) {
                    calculateEndTime();
                }
            });
        } else {
            customMinuteInput.style.display = 'none';
            customMinuteInput.value = '';
            calculateEndTime();
        }
    });
    
    // Calculate end time based on start time and duration
    function calculateEndTime() {
        var startHour = document.getElementById('start_hour').value;
        var startMinuteSelect = document.getElementById('start_minute').value;
        var customMinuteInput = document.getElementById('custom_minute');
        var duration = parseInt(document.getElementById('interview_duration').value);
        
        // Determine actual start minute
        var startMinute;
        if (startMinuteSelect === 'custom') {
            startMinute = customMinuteInput.value;
            if (!startMinute || startMinute === '') {
                document.getElementById('end_time_display').innerHTML = '<i class="fas fa-clock"></i> --:-- (Enter custom minute)';
                return;
            }
        } else {
            startMinute = startMinuteSelect;
        }
        
        if (startHour && startMinute && duration) {
            // Set hidden start time field
            var startTimeStr = startHour + ':' + String(startMinute).padStart(2, '0');
            document.getElementById('interview_start_time').value = startTimeStr;
            
            // Calculate end time
            var totalMinutes = (parseInt(startHour) * 60) + parseInt(startMinute) + duration;
            var endHour = Math.floor(totalMinutes / 60) % 24;
            var endMinute = totalMinutes % 60;
            
            var endTimeStr = String(endHour).padStart(2, '0') + ':' + String(endMinute).padStart(2, '0');
            document.getElementById('interview_end_time').value = endTimeStr;
            
            // Display end time
            var displayTime = formatTime(endHour, endMinute);
            var durationText = duration >= 60 ? (duration / 60) + ' hour' + (duration > 60 ? 's' : '') : duration + ' minutes';
            document.getElementById('end_time_display').innerHTML = '<i class="fas fa-clock"></i> ' + displayTime + ' <span style="font-size: 14px; color: #666;">(' + durationText + ')</span>';
        } else {
            document.getElementById('end_time_display').innerHTML = '<i class="fas fa-clock"></i> --:-- (Select start time and duration)';
        }
    }
    
    // Format time for display
    function formatTime(hour, minute) {
        var h = parseInt(hour);
        var m = parseInt(minute);
        var ampm = h >= 12 ? 'PM' : 'AM';
        h = h % 12;
        h = h ? h : 12; // 0 should be 12
        var minuteStr = String(m).padStart(2, '0');
        return h + ':' + minuteStr + ' ' + ampm;
    }
    
    // Event listeners for time calculation
    document.getElementById('start_hour').addEventListener('change', calculateEndTime);
    
    // Auto-generate meeting link - Simple workaround
    window.generateMeetingLink = function() {
        var platform = document.getElementById('online_platform').value;
        
        if (!platform) {
            alert('Please select a platform first');
            return;
        }
        
        // Generate random meeting ID
        var meetingId = '';
        var password = '';
        var meetingLink = '';
        
        if (platform === 'Zoom') {
            // Generate 10-digit meeting ID
            meetingId = Math.floor(1000000000 + Math.random() * 9000000000).toString();
            // Format as XXX XXX XXXX
            var formatted = meetingId.match(/.{1,3}/g).join(' ');
            
            // Generate 6-character password
            password = Math.random().toString(36).substring(2, 8);
            
            // Create Zoom link
            meetingLink = 'https://zoom.us/j/' + meetingId + '?pwd=' + btoa(password).substring(0, 10);
            
            document.getElementById('meeting_link').value = meetingLink;
            document.getElementById('meeting_id').value = formatted;
            document.getElementById('meeting_password').value = password;
            
            alert('✅ Zoom meeting details generated!\n\n' +
                  'Meeting ID: ' + formatted + '\n' +
                  'Password: ' + password + '\n\n' +
                  'Note: This is a template. Create actual meeting at zoom.us');
            
        } else if (platform === 'Google Meet') {
            // Generate random Google Meet code (10 characters)
            var meetCode = Math.random().toString(36).substring(2, 5) + '-' + 
                          Math.random().toString(36).substring(2, 6) + '-' + 
                          Math.random().toString(36).substring(2, 5);
            
            meetingLink = 'https://meet.google.com/' + meetCode;
            
            document.getElementById('meeting_link').value = meetingLink;
            document.getElementById('meeting_id').value = meetCode;
            document.getElementById('meeting_password').value = 'N/A (Google Meet)';
            
            alert('✅ Google Meet link generated!\n\n' +
                  'Meeting Code: ' + meetCode + '\n\n' +
                  'Note: This is a template. Create actual meeting at meet.google.com');
            
        } else if (platform === 'Microsoft Teams') {
            // Generate random Teams meeting ID
            var teamsId = Math.random().toString(36).substring(2, 15).toUpperCase();
            
            meetingLink = 'https://teams.microsoft.com/l/meetup-join/' + teamsId;
            
            document.getElementById('meeting_link').value = meetingLink;
            document.getElementById('meeting_id').value = teamsId;
            document.getElementById('meeting_password').value = 'N/A (Teams)';
            
            alert('✅ Microsoft Teams link generated!\n\n' +
                  'Meeting ID: ' + teamsId + '\n\n' +
                  'Note: This is a template. Create actual meeting at teams.microsoft.com');
            
        } else if (platform === 'Skype') {
            // Generate Skype meeting link
            var skypeId = Math.random().toString(36).substring(2, 15);
            
            meetingLink = 'https://join.skype.com/' + skypeId;
            
            document.getElementById('meeting_link').value = meetingLink;
            document.getElementById('meeting_id').value = skypeId;
            document.getElementById('meeting_password').value = 'N/A (Skype)';
            
            alert('✅ Skype meeting link generated!\n\n' +
                  'Meeting ID: ' + skypeId + '\n\n' +
                  'Note: This is a template. Create actual meeting at skype.com');
            
        } else {
            // Generic platform
            var genericId = Math.random().toString(36).substring(2, 12).toUpperCase();
            password = Math.random().toString(36).substring(2, 8);
            
            meetingLink = 'https://' + platform.toLowerCase().replace(/\s+/g, '') + '.com/meeting/' + genericId;
            
            document.getElementById('meeting_link').value = meetingLink;
            document.getElementById('meeting_id').value = genericId;
            document.getElementById('meeting_password').value = password;
            
            alert('✅ Meeting details generated!\n\n' +
                  'Meeting ID: ' + genericId + '\n' +
                  'Password: ' + password + '\n\n' +
                  'Note: This is a template. Create actual meeting on your platform.');
        }
        
        // Highlight the fields to show they've been filled
        document.getElementById('meeting_link').style.background = '#e8f5e9';
        document.getElementById('meeting_id').style.background = '#e8f5e9';
        document.getElementById('meeting_password').style.background = '#e8f5e9';
        
        setTimeout(function() {
            document.getElementById('meeting_link').style.background = '';
            document.getElementById('meeting_id').style.background = '';
            document.getElementById('meeting_password').style.background = '';
        }, 2000);
    };

    // Fill venue details from saved locations
    window.fillVenueDetails = function(selectElement) {
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        
        if (selectedOption.value === 'custom' || selectedOption.value === '') {
            // Clear fields for custom entry
            document.getElementById('venue_location').value = '';
            document.getElementById('venue_room').value = '';
            document.getElementById('venue_location').readOnly = false;
            document.getElementById('venue_room').readOnly = false;
        } else if (selectedOption.value) {
            // Fill from saved location
            var address = selectedOption.getAttribute('data-address');
            var room = selectedOption.getAttribute('data-room');
            
            document.getElementById('venue_location').value = address || '';
            document.getElementById('venue_room').value = room || '';
            
            // Highlight the fields
            document.getElementById('venue_location').style.background = '#e8f5e9';
            document.getElementById('venue_room').style.background = '#e8f5e9';
            
            setTimeout(function() {
                document.getElementById('venue_location').style.background = '';
                document.getElementById('venue_room').style.background = '';
            }, 2000);
        }
    };

    // Multiple Interviewers Management
    var interviewerCount = 1;
    var maxInterviewers = <?= isset($interview_config) ? $interview_config->max_interviewers : 3 ?>;
    var allowMultiple = <?= isset($interview_config) && $interview_config->allow_multiple_interviewers ? 'true' : 'false' ?>;
    
    window.addInterviewer = function() {
        if (interviewerCount >= maxInterviewers) {
            alert('Maximum number of interviewers (' + maxInterviewers + ') reached.');
            return;
        }
        
        interviewerCount++;
        
        var interviewerHtml = '<div class="form-group interviewer-group" data-interviewer-index="' + interviewerCount + '" style="position: relative; padding: 15px; background: #f8f9fa; border-radius: 8px; margin-top: 15px;">' +
            '<button type="button" class="btn" onclick="removeInterviewer(' + interviewerCount + ')" ' +
            'style="position: absolute; top: 10px; right: 10px; background: #f44336; color: white; padding: 5px 10px; font-size: 12px; border-radius: 4px;">' +
            '<i class="fas fa-times"></i> Remove' +
            '</button>' +
            '<label for="assigned_interviewer_' + interviewerCount + '">' +
            'Additional Interviewer #' + (interviewerCount - 1) +
            '</label>' +
            '<select class="form-control interviewer-select" id="assigned_interviewer_' + interviewerCount + '" name="assigned_interviewers[]">' +
            '<option value="">Select interviewer...</option>';
        
        // Add interviewer options
        <?php if (isset($interviewers) && !empty($interviewers)): ?>
            <?php foreach ($interviewers as $interviewer): ?>
            interviewerHtml += '<option value="<?= $interviewer['u_username'] ?>" data-id="<?= $interviewer['u_id'] ?>" data-email="<?= $interviewer['u_email'] ?>">' +
                '<?= htmlspecialchars($interviewer['u_username']) ?> - <?= htmlspecialchars($interviewer['u_email']) ?>' +
                '</option>';
            <?php endforeach; ?>
        <?php endif; ?>
        
        interviewerHtml += '</select>' +
            '<div class="help-text">Additional panel member</div>' +
            '</div>';
        
        document.getElementById('additional-interviewers').insertAdjacentHTML('beforeend', interviewerHtml);
        
        // Update button state
        if (interviewerCount >= maxInterviewers) {
            document.getElementById('add-interviewer-btn').disabled = true;
            document.getElementById('add-interviewer-btn').style.opacity = '0.5';
            document.getElementById('add-interviewer-btn').style.cursor = 'not-allowed';
        }
        
        // Add change listener to prevent duplicates
        updateInterviewerListeners();
    };
    
    window.removeInterviewer = function(index) {
        var element = document.querySelector('[data-interviewer-index="' + index + '"]');
        if (element) {
            element.remove();
            interviewerCount--;
            
            // Re-enable add button
            document.getElementById('add-interviewer-btn').disabled = false;
            document.getElementById('add-interviewer-btn').style.opacity = '1';
            document.getElementById('add-interviewer-btn').style.cursor = 'pointer';
            
            // Renumber remaining interviewers
            renumberInterviewers();
        }
    };
    
    function renumberInterviewers() {
        var additionalInterviewers = document.querySelectorAll('#additional-interviewers .interviewer-group');
        additionalInterviewers.forEach(function(group, index) {
            var label = group.querySelector('label');
            if (label) {
                label.innerHTML = 'Additional Interviewer #' + (index + 1);
            }
        });
    }
    
    function updateInterviewerListeners() {
        var selects = document.querySelectorAll('.interviewer-select');
        selects.forEach(function(select) {
            select.addEventListener('change', function() {
                checkDuplicateInterviewers();
            });
        });
    }
    
    function checkDuplicateInterviewers() {
        var selects = document.querySelectorAll('.interviewer-select');
        var selectedValues = [];
        var hasDuplicate = false;
        
        selects.forEach(function(select) {
            if (select.value) {
                if (selectedValues.includes(select.value)) {
                    hasDuplicate = true;
                    select.style.borderColor = '#f44336';
                } else {
                    selectedValues.push(select.value);
                    select.style.borderColor = '#ddd';
                }
            }
        });
        
        if (hasDuplicate) {
            if (!document.getElementById('duplicate-warning')) {
                var warning = document.createElement('div');
                warning.id = 'duplicate-warning';
                warning.className = 'alert alert-warning';
                warning.style.marginTop = '10px';
                warning.innerHTML = '<i class="fas fa-exclamation-triangle"></i> ' +
                    '<strong>Warning:</strong> You have selected the same interviewer multiple times. Each interviewer should be unique.';
                document.getElementById('interviewers-container').appendChild(warning);
            }
        } else {
            var warning = document.getElementById('duplicate-warning');
            if (warning) {
                warning.remove();
            }
        }
        
        return !hasDuplicate;
    }
    
    // Initialize listeners if multiple interviewers are allowed
    if (allowMultiple) {
        updateInterviewerListeners();
    }

    
    // Form validation before submit
    document.getElementById('interviewForm').addEventListener('submit', function(e) {
        // Validate candidate selection
        if (currentCandidateMode === 'existing') {
            var existingCandidate = document.getElementById('existing_candidate').value;
            if (!existingCandidate) {
                e.preventDefault();
                alert('Please select a candidate from the list.');
                return false;
            }
        } else {
            var name = document.getElementById('candidate_name').value.trim();
            var email = document.getElementById('candidate_email').value.trim();
            if (!name || !email) {
                e.preventDefault();
                alert('Please fill in candidate name and email.');
                return false;
            }
        }
        
        // Validate time selection
        var startHour = document.getElementById('start_hour').value;
        var startMinuteSelect = document.getElementById('start_minute').value;
        var customMinute = document.getElementById('custom_minute').value;
        
        if (!startHour) {
            e.preventDefault();
            alert('Please select start hour.');
            return false;
        }
        
        if (!startMinuteSelect) {
            e.preventDefault();
            alert('Please select start minute.');
            return false;
        }
        
        if (startMinuteSelect === 'custom' && !customMinute) {
            e.preventDefault();
            alert('Please enter custom minute value (0-59).');
            return false;
        }
        
        // Validate duration
        var durationButtons = document.querySelectorAll('.duration-btn.active');
        if (durationButtons.length > 0) {
            var activeBtn = durationButtons[0];
            if (activeBtn.textContent.includes('Custom')) {
                var customDuration = document.getElementById('custom_duration').value;
                if (!customDuration || customDuration < 15 || customDuration > 480) {
                    e.preventDefault();
                    alert('Please enter custom duration (15-480 minutes).');
                    return false;
                }
            }
        }
        
        // Validate interview type specific fields
        if (currentInterviewType === 'online') {
            var platform = document.getElementById('online_platform').value;
            var link = document.getElementById('meeting_link').value.trim();
            if (!platform || !link) {
                e.preventDefault();
                alert('Please fill in online meeting platform and link.');
                return false;
            }
        } else if (currentInterviewType === 'in_person') {
            var venue = document.getElementById('venue_location').value.trim();
            if (!venue) {
                e.preventDefault();
                alert('Please fill in venue location for in-person interview.');
                return false;
            }
        } else if (currentInterviewType === 'phone') {
            var phone = document.getElementById('phone_number').value.trim();
            if (!phone) {
                e.preventDefault();
                alert('Please fill in phone number for phone interview.');
                return false;
            }
        }
        
        // Validate date is not in the past
        var interviewDate = new Date(document.getElementById('interview_date').value);
        var today = new Date();
        today.setHours(0, 0, 0, 0);
        
        if (interviewDate < today) {
            e.preventDefault();
            alert('Interview date cannot be in the past.');
            return false;
        }
        
        // All validations passed
        return true;
    });
    
    // Initialize
    switchCandidateMode('existing');
    selectInterviewType('online');
    
})();
</script>

<!-- Modern Confirmation Modal -->
<div class="modal fade modern-modal" id="confirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalTitle">
                    <i class="fas fa-question-circle"></i>
                    <span id="confirmModalTitleText">Confirm Action</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="confirmModalBody">
                Are you sure you want to proceed?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-gradient" id="confirmModalAction">Confirm</button>
            </div>
        </div>
    </div>
</div>

<!-- Modern Alert Modal -->
<div class="modal fade modern-modal" id="alertModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alertModalTitle">
                    <i class="fas fa-info-circle"></i>
                    <span id="alertModalTitleText">Notification</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="alertModalBody">
                Message content here
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-gradient" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<style>
/* Modern Modal Styles */
.modern-modal .modal-content {
    border-radius: 16px;
    border: none;
    box-shadow: 0 10px 40px rgba(0,0,0,.15);
}
.modern-modal .modal-header {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: #fff;
    border-radius: 16px 16px 0 0;
    padding: 20px 24px;
    border: none;
}
.modern-modal .modal-title {
    font-weight: 600;
    font-size: 18px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.modern-modal .btn-close {
    filter: brightness(0) invert(1);
    opacity: 0.8;
}
.modern-modal .btn-close:hover {
    opacity: 1;
}
.modern-modal .modal-body {
    padding: 24px;
    font-size: 15px;
    color: #333;
    line-height: 1.6;
}
.modern-modal .modal-footer {
    border: none;
    padding: 16px 24px 24px;
    gap: 10px;
}
.modern-modal .btn-gradient {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border: none;
    color: #fff;
    padding: 10px 24px;
    border-radius: 8px;
    font-weight: 500;
    transition: transform 0.2s, box-shadow 0.2s;
}
.modern-modal .btn-gradient:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    color: #fff;
}
.modern-modal .btn-outline-secondary {
    border: 2px solid #e0e0e0;
    color: #666;
    padding: 10px 24px;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.2s;
}
.modern-modal .btn-outline-secondary:hover {
    background: #f5f5f5;
    border-color: #ccc;
    color: #333;
}
.modern-modal.success-modal .modal-header {
    background: linear-gradient(135deg, #22c55e, #16a34a);
}
.modern-modal.danger-modal .modal-header {
    background: linear-gradient(135deg, #ef4444, #dc2626);
}
.modern-modal.info-modal .modal-header {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
}
.modern-modal.warning-modal .modal-header {
    background: linear-gradient(135deg, #f59e0b, #d97706);
}
</style>

<script>
// Modern Alert and Confirm Functions - Override default alert()
var confirmModalCallback = null;

// Override native alert
window.alert = function(message) {
    var title = 'Notification';
    var type = 'info';
    
    // Parse message for type indicators
    if (message.includes('✅') || message.toLowerCase().includes('success')) {
        type = 'success';
        title = 'Success';
    } else if (message.toLowerCase().includes('error') || message.toLowerCase().includes('failed')) {
        type = 'danger';
        title = 'Error';
    } else if (message.toLowerCase().includes('warning')) {
        type = 'warning';
        title = 'Warning';
    }
    
    showAlert(title, message, type);
};

function showAlert(title, message, type) {
    type = type || 'info';
    var modal = document.getElementById('alertModal');
    if (!modal) return; // Fallback if modal not loaded yet
    
    var modalInstance = new bootstrap.Modal(modal);
    
    modal.className = 'modal fade modern-modal';
    if (type === 'danger') modal.classList.add('danger-modal');
    else if (type === 'warning') modal.classList.add('warning-modal');
    else if (type === 'success') modal.classList.add('success-modal');
    else if (type === 'info') modal.classList.add('info-modal');
    
    var icon = 'fa-info-circle';
    if (type === 'danger') icon = 'fa-times-circle';
    else if (type === 'warning') icon = 'fa-exclamation-triangle';
    else if (type === 'success') icon = 'fa-check-circle';
    
    document.querySelector('#alertModalTitle i').className = 'fas ' + icon;
    document.getElementById('alertModalTitleText').textContent = title;
    document.getElementById('alertModalBody').innerHTML = message.replace(/\n/g, '<br>');
    
    modalInstance.show();
}

function showConfirm(title, message, callback, type) {
    type = type || 'primary';
    var modal = document.getElementById('confirmModal');
    if (!modal) return; // Fallback if modal not loaded yet
    
    var modalInstance = new bootstrap.Modal(modal);
    
    modal.className = 'modal fade modern-modal';
    if (type === 'danger') modal.classList.add('danger-modal');
    else if (type === 'warning') modal.classList.add('warning-modal');
    else if (type === 'success') modal.classList.add('success-modal');
    else if (type === 'info') modal.classList.add('info-modal');
    
    var icon = 'fa-question-circle';
    if (type === 'danger') icon = 'fa-exclamation-triangle';
    else if (type === 'warning') icon = 'fa-exclamation-circle';
    else if (type === 'success') icon = 'fa-check-circle';
    else if (type === 'info') icon = 'fa-info-circle';
    
    document.querySelector('#confirmModalTitle i').className = 'fas ' + icon;
    document.getElementById('confirmModalTitleText').textContent = title;
    document.getElementById('confirmModalBody').textContent = message;
    
    confirmModalCallback = callback;
    modalInstance.show();
}

document.addEventListener('DOMContentLoaded', function() {
    var confirmBtn = document.getElementById('confirmModalAction');
    if (confirmBtn) {
        confirmBtn.addEventListener('click', function() {
            if (confirmModalCallback) {
                confirmModalCallback();
                confirmModalCallback = null;
            }
            var modal = bootstrap.Modal.getInstance(document.getElementById('confirmModal'));
            if (modal) modal.hide();
        });
    }
});
</script>
