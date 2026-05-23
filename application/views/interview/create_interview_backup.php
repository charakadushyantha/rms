<style>
.create-interview-container {
    padding: 30px;
    max-width: 800px;
    margin: 0 auto;
}

.form-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    padding: 30px;
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

.form-control {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
}

.form-control:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.btn {
    padding: 12px 24px;
    border-radius: 5px;
    text-decoration: none;
    display: inline-block;
    font-weight: 600;
    font-size: 14px;
    border: none;
    cursor: pointer;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.form-actions {
    display: flex;
    gap: 10px;
    margin-top: 30px;
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

.candidate-option {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.account-badge {
    display: inline-block;
    padding: 2px 8px;
    border-radius: 3px;
    font-size: 11px;
    font-weight: 600;
    margin-left: 8px;
}

.badge-has-account {
    background: #e8f5e9;
    color: #2e7d32;
}

.badge-no-account {
    background: #fff3e0;
    color: #e65100;
}

.candidate-info-text {
    font-size: 12px;
    color: #666;
    margin-top: 5px;
    padding: 8px;
    background: #f8f9fa;
    border-radius: 4px;
}
</style>

<div class="create-interview-container">
    <h1>🎯 Create Interview</h1>
    <p>Generate a unique interview link for a candidate</p>

    <div class="form-card">
        <form method="post" action="<?= base_url('interview/create_interview') ?>" id="interviewForm">
            <div class="form-group">
                <label for="flow_id">Select Interview Flow *</label>
                <select class="form-control" id="flow_id" name="flow_id" required>
                    <option value="">Choose a flow...</option>
                    <?php foreach ($flows as $flow): ?>
                    <option value="<?= $flow['id'] ?>" <?= $this->input->get('flow_id') == $flow['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($flow['job_title']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Mode Toggle -->
            <div class="mode-toggle">
                <button type="button" class="mode-btn active" id="selectExistingBtn" onclick="switchMode('existing')">
                    <i class="fas fa-user-check"></i> Select Existing Candidate
                    <span class="info-badge"><?= count($candidates) ?> registered</span>
                </button>
                <button type="button" class="mode-btn" id="addNewBtn" onclick="switchMode('new')">
                    <i class="fas fa-user-plus"></i> Add New Candidate
                </button>
            </div>

            <!-- Select Existing Candidate Section -->
            <div class="candidate-section active" id="existingSection">
                <div class="form-group">
                    <label for="existing_candidate">Select Registered Candidate *</label>
                    <select class="form-control" id="existing_candidate" name="existing_candidate">
                        <option value="">Choose a candidate...</option>
                        <?php 
                        $has_account_count = 0;
                        $no_account_count = 0;
                        foreach ($candidates as $candidate): 
                            $has_account = $candidate['has_account'] == 1;
                            if ($has_account) $has_account_count++;
                            else $no_account_count++;
                            
                            $badge_class = $has_account ? 'badge-has-account' : 'badge-no-account';
                            $badge_text = $has_account ? '✓ Has Account' : '⚠ No Account';
                            $job_title = !empty($candidate['cd_job_title']) ? ' - ' . htmlspecialchars($candidate['cd_job_title']) : '';
                        ?>
                        <option 
                            value="<?= $candidate['cd_id'] ?? $candidate['u_id'] ?>"
                            data-name="<?= htmlspecialchars($candidate['cd_name']) ?>"
                            data-email="<?= htmlspecialchars($candidate['cd_email']) ?>"
                            data-phone="<?= htmlspecialchars($candidate['cd_phone'] ?? '') ?>"
                            data-has-account="<?= $has_account ? '1' : '0' ?>"
                            data-source="<?= $candidate['source'] ?>">
                            <?= htmlspecialchars($candidate['cd_name']) ?> - <?= htmlspecialchars($candidate['cd_email']) ?><?= $job_title ?> [<?= $badge_text ?>]
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="candidate-info-text">
                        <i class="fas fa-info-circle"></i> 
                        <strong>Total: <?= count($candidates) ?> candidates</strong> | 
                        <span style="color: #2e7d32;">✓ <?= $has_account_count ?> with user accounts</span> | 
                        <span style="color: #e65100;">⚠ <?= $no_account_count ?> without accounts</span>
                    </div>
                </div>
            </div>

            <!-- Add New Candidate Section -->
            <div class="candidate-section" id="newSection">
                <div class="form-group">
                    <label for="candidate_name">Candidate Name *</label>
                    <input type="text" class="form-control" id="candidate_name" name="candidate_name">
                </div>

                <div class="form-group">
                    <label for="candidate_email">Candidate Email *</label>
                    <input type="email" class="form-control" id="candidate_email" name="candidate_email">
                </div>

                <div class="form-group">
                    <label for="candidate_phone">Candidate Phone</label>
                    <input type="tel" class="form-control" id="candidate_phone" name="candidate_phone">
                </div>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="send_email" value="1" checked>
                    Send interview link via email
                </label>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-link"></i> Create Interview
                </button>
                <a href="<?= base_url('interview/interviews') ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <script>
    (function() {
        var currentMode = 'existing';
        
        window.switchMode = function(mode) {
            currentMode = mode;
            
            // Update button states
            var selectBtn = document.getElementById('selectExistingBtn');
            var addBtn = document.getElementById('addNewBtn');
            var existingSection = document.getElementById('existingSection');
            var newSection = document.getElementById('newSection');
            
            if (mode === 'existing') {
                selectBtn.classList.add('active');
                addBtn.classList.remove('active');
                existingSection.classList.add('active');
                newSection.classList.remove('active');
                
                // Clear and disable new candidate fields
                document.getElementById('candidate_name').value = '';
                document.getElementById('candidate_email').value = '';
                document.getElementById('candidate_phone').value = '';
                document.getElementById('candidate_name').removeAttribute('required');
                document.getElementById('candidate_email').removeAttribute('required');
                
                // Enable existing candidate dropdown
                document.getElementById('existing_candidate').setAttribute('required', 'required');
            } else {
                selectBtn.classList.remove('active');
                addBtn.classList.add('active');
                existingSection.classList.remove('active');
                newSection.classList.add('active');
                
                // Clear and disable existing candidate dropdown
                document.getElementById('existing_candidate').value = '';
                document.getElementById('existing_candidate').removeAttribute('required');
                
                // Enable new candidate fields
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
                
                // Fill the hidden fields for form submission
                document.getElementById('candidate_name').value = name;
                document.getElementById('candidate_email').value = email;
                document.getElementById('candidate_phone').value = phone;
            } else {
                document.getElementById('candidate_name').value = '';
                document.getElementById('candidate_email').value = '';
                document.getElementById('candidate_phone').value = '';
            }
        });
        
        // Form validation before submit
        document.getElementById('interviewForm').addEventListener('submit', function(e) {
            if (currentMode === 'existing') {
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
        });
        
        // Initialize with existing mode
        switchMode('existing');
    })();
    </script>
</div>
