<?php
$data['page_title'] = 'Submit Interview Feedback';
$this->load->view('templates/interviewer_header', $data);
?>

<style>
.feedback-container {
    padding: 2rem;
    background: #f8f9fa;
    min-height: calc(100vh - 70px);
}

.feedback-wrapper {
    max-width: 900px;
    margin: 0 auto;
}

.feedback-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin-bottom: 1.5rem;
}

.card-header-custom {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1.5rem;
    border-radius: 12px;
    margin-bottom: 2rem;
}

.card-header-custom h2 {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 700;
}

.candidate-info {
    background: #f9fafb;
    padding: 1.5rem;
    border-radius: 12px;
    margin-bottom: 2rem;
}

.info-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.75rem;
}

.info-label {
    font-weight: 600;
    color: #6b7280;
}

.info-value {
    color: #1f2937;
}

.form-section {
    margin-bottom: 2rem;
}

.section-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #f3f4f6;
}

.rating-group {
    margin-bottom: 1.5rem;
}

.rating-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
    display: block;
}

.star-rating {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.star {
    font-size: 2rem;
    color: #d1d5db;
    cursor: pointer;
    transition: all 0.2s;
}

.star:hover,
.star.active {
    color: #fbbf24;
    transform: scale(1.1);
}

.rating-value {
    margin-left: 1rem;
    font-weight: 600;
    color: #667eea;
    font-size: 1.25rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.form-control {
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    padding: 0.75rem;
    transition: all 0.2s;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    outline: none;
}

.recommendation-options {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
}

.recommendation-option {
    position: relative;
}

.recommendation-option input[type="radio"] {
    position: absolute;
    opacity: 0;
}

.recommendation-label {
    display: block;
    padding: 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s;
    font-weight: 600;
}

.recommendation-option input[type="radio"]:checked + .recommendation-label {
    border-color: #667eea;
    background: #f3f4f6;
    color: #667eea;
}

.recommendation-label:hover {
    border-color: #667eea;
}

.btn-submit {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 1rem 2rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.2s;
    width: 100%;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
}

.btn-cancel {
    background: #6b7280;
    color: white;
    border: none;
    padding: 1rem 2rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.2s;
    width: 100%;
    margin-top: 0.5rem;
}

.btn-cancel:hover {
    background: #4b5563;
}
</style>

<div class="feedback-container">
    <div class="feedback-wrapper">
        <div class="feedback-card">
            <div class="card-header-custom">
                <h2><i class="fas fa-clipboard-list me-2"></i>Interview Feedback Form</h2>
            </div>

            <?php if (isset($candidate)): ?>
            <!-- Candidate Information -->
            <div class="candidate-info">
                <h3 style="margin-bottom: 1rem; color: #1f2937;">Candidate Information</h3>
                <div class="info-row">
                    <span class="info-label">Name:</span>
                    <span class="info-value"><?php echo htmlspecialchars($candidate['Can_name']); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Position:</span>
                    <span class="info-value"><?php echo htmlspecialchars($candidate['Can_position']); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value"><?php echo htmlspecialchars($candidate['Can_email']); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Interview Date:</span>
                    <span class="info-value"><?php echo date('F d, Y h:i A', strtotime($interview['assigned_at'])); ?></span>
                </div>
            </div>

            <!-- Feedback Form -->
            <form id="feedbackForm">
                <input type="hidden" name="interview_id" value="<?php echo $interview['id']; ?>">
                <input type="hidden" name="candidate_id" value="<?php echo $candidate['Can_id']; ?>">

                <!-- Rating Section -->
                <div class="form-section">
                    <h3 class="section-title">Performance Ratings</h3>

                    <div class="rating-group">
                        <label class="rating-label">Technical Skills</label>
                        <div class="star-rating" data-rating="technical_skills">
                            <i class="fas fa-star star" data-value="1"></i>
                            <i class="fas fa-star star" data-value="2"></i>
                            <i class="fas fa-star star" data-value="3"></i>
                            <i class="fas fa-star star" data-value="4"></i>
                            <i class="fas fa-star star" data-value="5"></i>
                            <span class="rating-value">0/5</span>
                        </div>
                        <input type="hidden" name="technical_skills" value="0">
                    </div>

                    <div class="rating-group">
                        <label class="rating-label">Communication Skills</label>
                        <div class="star-rating" data-rating="communication">
                            <i class="fas fa-star star" data-value="1"></i>
                            <i class="fas fa-star star" data-value="2"></i>
                            <i class="fas fa-star star" data-value="3"></i>
                            <i class="fas fa-star star" data-value="4"></i>
                            <i class="fas fa-star star" data-value="5"></i>
                            <span class="rating-value">0/5</span>
                        </div>
                        <input type="hidden" name="communication" value="0">
                    </div>

                    <div class="rating-group">
                        <label class="rating-label">Problem Solving</label>
                        <div class="star-rating" data-rating="problem_solving">
                            <i class="fas fa-star star" data-value="1"></i>
                            <i class="fas fa-star star" data-value="2"></i>
                            <i class="fas fa-star star" data-value="3"></i>
                            <i class="fas fa-star star" data-value="4"></i>
                            <i class="fas fa-star star" data-value="5"></i>
                            <span class="rating-value">0/5</span>
                        </div>
                        <input type="hidden" name="problem_solving" value="0">
                    </div>

                    <div class="rating-group">
                        <label class="rating-label">Cultural Fit</label>
                        <div class="star-rating" data-rating="cultural_fit">
                            <i class="fas fa-star star" data-value="1"></i>
                            <i class="fas fa-star star" data-value="2"></i>
                            <i class="fas fa-star star" data-value="3"></i>
                            <i class="fas fa-star star" data-value="4"></i>
                            <i class="fas fa-star star" data-value="5"></i>
                            <span class="rating-value">0/5</span>
                        </div>
                        <input type="hidden" name="cultural_fit" value="0">
                    </div>

                    <div class="rating-group">
                        <label class="rating-label">Overall Rating</label>
                        <div class="star-rating" data-rating="overall_rating">
                            <i class="fas fa-star star" data-value="1"></i>
                            <i class="fas fa-star star" data-value="2"></i>
                            <i class="fas fa-star star" data-value="3"></i>
                            <i class="fas fa-star star" data-value="4"></i>
                            <i class="fas fa-star star" data-value="5"></i>
                            <span class="rating-value">0/5</span>
                        </div>
                        <input type="hidden" name="overall_rating" value="0">
                    </div>
                </div>

                <!-- Detailed Feedback -->
                <div class="form-section">
                    <h3 class="section-title">Detailed Feedback</h3>

                    <div class="form-group">
                        <label class="form-label">Strengths</label>
                        <textarea class="form-control" name="strengths" rows="3" 
                                  placeholder="What were the candidate's key strengths?"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Areas for Improvement</label>
                        <textarea class="form-control" name="weaknesses" rows="3" 
                                  placeholder="What areas could the candidate improve?"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Detailed Comments</label>
                        <textarea class="form-control" name="detailed_feedback" rows="5" 
                                  placeholder="Provide detailed feedback about the interview..."></textarea>
                    </div>
                </div>

                <!-- Recommendation -->
                <div class="form-section">
                    <h3 class="section-title">Hiring Recommendation</h3>
                    <div class="recommendation-options">
                        <div class="recommendation-option">
                            <input type="radio" name="recommendation" value="strong_hire" id="strong_hire">
                            <label for="strong_hire" class="recommendation-label">
                                <i class="fas fa-star text-success"></i><br>
                                Strong Hire
                            </label>
                        </div>
                        <div class="recommendation-option">
                            <input type="radio" name="recommendation" value="hire" id="hire">
                            <label for="hire" class="recommendation-label">
                                <i class="fas fa-thumbs-up text-success"></i><br>
                                Hire
                            </label>
                        </div>
                        <div class="recommendation-option">
                            <input type="radio" name="recommendation" value="maybe" id="maybe">
                            <label for="maybe" class="recommendation-label">
                                <i class="fas fa-question text-warning"></i><br>
                                Maybe
                            </label>
                        </div>
                        <div class="recommendation-option">
                            <input type="radio" name="recommendation" value="no_hire" id="no_hire">
                            <label for="no_hire" class="recommendation-label">
                                <i class="fas fa-thumbs-down text-danger"></i><br>
                                No Hire
                            </label>
                        </div>
                        <div class="recommendation-option">
                            <input type="radio" name="recommendation" value="strong_no_hire" id="strong_no_hire">
                            <label for="strong_no_hire" class="recommendation-label">
                                <i class="fas fa-times text-danger"></i><br>
                                Strong No Hire
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane me-2"></i>Submit Feedback
                </button>
                <a href="<?php echo base_url('I_dashboard'); ?>" class="btn-cancel">
                    <i class="fas fa-times me-2"></i>Cancel
                </a>
            </form>
            <?php else: ?>
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Interview details not found.
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
$custom_script = "
// Star Rating System
document.querySelectorAll('.star-rating').forEach(ratingGroup => {
    const stars = ratingGroup.querySelectorAll('.star');
    const ratingValue = ratingGroup.querySelector('.rating-value');
    const fieldName = ratingGroup.dataset.rating;
    const hiddenInput = document.querySelector(`input[name=\"${fieldName}\"]`);
    
    stars.forEach(star => {
        star.addEventListener('click', function() {
            const value = parseInt(this.dataset.value);
            
            // Update hidden input
            hiddenInput.value = value;
            
            // Update stars
            stars.forEach(s => {
                const starValue = parseInt(s.dataset.value);
                if (starValue <= value) {
                    s.classList.add('active');
                } else {
                    s.classList.remove('active');
                }
            });
            
            // Update rating value display
            ratingValue.textContent = value + '/5';
        });
        
        star.addEventListener('mouseenter', function() {
            const value = parseInt(this.dataset.value);
            stars.forEach(s => {
                const starValue = parseInt(s.dataset.value);
                if (starValue <= value) {
                    s.style.color = '#fbbf24';
                }
            });
        });
    });
    
    ratingGroup.addEventListener('mouseleave', function() {
        const currentValue = parseInt(hiddenInput.value);
        stars.forEach(s => {
            const starValue = parseInt(s.dataset.value);
            if (starValue > currentValue) {
                s.style.color = '#d1d5db';
            }
        });
    });
});

// Form Submission
document.getElementById('feedbackForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Validate ratings
    const ratings = ['technical_skills', 'communication', 'problem_solving', 'cultural_fit', 'overall_rating'];
    let allRated = true;
    
    ratings.forEach(rating => {
        const value = parseInt(document.querySelector(`input[name=\"${rating}\"]`).value);
        if (value === 0) {
            allRated = false;
        }
    });
    
    if (!allRated) {
        Swal.fire({
            icon: 'warning',
            title: 'Incomplete Ratings',
            text: 'Please provide ratings for all criteria'
        });
        return;
    }
    
    // Check recommendation
    const recommendation = document.querySelector('input[name=\"recommendation\"]:checked');
    if (!recommendation) {
        Swal.fire({
            icon: 'warning',
            title: 'Missing Recommendation',
            text: 'Please select a hiring recommendation'
        });
        return;
    }
    
    // Submit form
    const formData = new FormData(this);
    
    Swal.fire({
        title: 'Submitting...',
        text: 'Please wait',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    fetch('" . base_url('I_dashboard/submit_feedback') . "', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Feedback Submitted!',
                text: 'Thank you for your feedback',
                timer: 2000
            }).then(() => {
                window.location.href = '" . base_url('I_dashboard') . "';
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'Failed to submit feedback'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while submitting feedback'
        });
    });
});
";

$data['custom_script'] = $custom_script;
$this->load->view('templates/interviewer_footer', $data);
?>
