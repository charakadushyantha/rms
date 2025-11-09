<?php
$data['page_title'] = 'My CV';
$this->load->view('templates/candidate_header', $data);
?>

<style>
.cv-container {
    padding: 2rem;
    background: #f8f9fa;
    min-height: calc(100vh - 70px);
}

.cv-wrapper {
    max-width: 1000px;
    margin: 0 auto;
}

.cv-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin-bottom: 1.5rem;
}

.cv-header {
    background: linear-gradient(135deg, #14b8a6 0%, #06b6d4 100%);
    color: white;
    padding: 2rem;
    border-radius: 12px;
    margin-bottom: 2rem;
}

.cv-header h1 {
    margin: 0 0 0.5rem 0;
    font-size: 2rem;
}

.cv-header p {
    margin: 0;
    opacity: 0.9;
}

.section-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #14b8a6;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.section-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #14b8a6 0%, #06b6d4 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
    display: block;
}

.form-control {
    width: 100%;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    padding: 0.75rem;
    transition: all 0.2s;
}

.form-control:focus {
    border-color: #14b8a6;
    box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
    outline: none;
}

.btn-save {
    background: linear-gradient(135deg, #14b8a6 0%, #06b6d4 100%);
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

.btn-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(20, 184, 166, 0.3);
}

.btn-preview {
    background: white;
    color: #14b8a6;
    border: 2px solid #14b8a6;
    padding: 1rem 2rem;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    width: 100%;
    margin-top: 0.5rem;
}

.help-text {
    font-size: 0.875rem;
    color: #6b7280;
    margin-top: 0.25rem;
}

.row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
}
</style>

<div class="cv-container">
    <div class="cv-wrapper">
        <div class="cv-header">
            <h1><i class="fas fa-id-card me-2"></i>My CV / Resume</h1>
            <p>Build your professional CV to showcase your skills and experience</p>
        </div>

        <form id="cvForm">
            <!-- Personal Information -->
            <div class="cv-card">
                <h2 class="section-title">
                    <div class="section-icon"><i class="fas fa-user"></i></div>
                    Personal Information
                </h2>

                <div class="row">
                    <div class="form-group">
                        <label class="form-label">Full Name *</label>
                        <input type="text" class="form-control" name="full_name" 
                               value="<?php echo isset($cv_data['cd_name']) ? htmlspecialchars($cv_data['cd_name']) : ''; ?>" 
                               placeholder="John Doe" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email *</label>
                        <input type="email" class="form-control" name="email" 
                               value="<?php echo isset($cv_data['cd_email']) ? htmlspecialchars($cv_data['cd_email']) : $email; ?>" 
                               placeholder="john@example.com" required>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label class="form-label">Phone *</label>
                        <input type="tel" class="form-control" name="phone" 
                               value="<?php echo isset($cv_data['cd_phone']) ? htmlspecialchars($cv_data['cd_phone']) : ''; ?>" 
                               placeholder="+1 (555) 123-4567" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">City</label>
                        <input type="text" class="form-control" name="city" 
                               value="<?php echo isset($cv_data['cd_city']) ? htmlspecialchars($cv_data['cd_city']) : ''; ?>" 
                               placeholder="New York">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Address</label>
                    <input type="text" class="form-control" name="address" 
                           value="<?php echo isset($cv_data['cd_address']) ? htmlspecialchars($cv_data['cd_address']) : ''; ?>" 
                           placeholder="123 Main Street">
                </div>

                <div class="row">
                    <div class="form-group">
                        <label class="form-label">Country</label>
                        <input type="text" class="form-control" name="country" 
                               value="<?php echo isset($cv_data['cd_country']) ? htmlspecialchars($cv_data['cd_country']) : ''; ?>" 
                               placeholder="United States">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Postal Code</label>
                        <input type="text" class="form-control" name="postal_code" 
                               value="<?php echo isset($cv_data['cd_postal_code']) ? htmlspecialchars($cv_data['cd_postal_code']) : ''; ?>" 
                               placeholder="10001">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label class="form-label">LinkedIn Profile</label>
                        <input type="url" class="form-control" name="linkedin" 
                               value="<?php echo isset($cv_data['cd_linkedin']) ? htmlspecialchars($cv_data['cd_linkedin']) : ''; ?>" 
                               placeholder="https://linkedin.com/in/johndoe">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Website / Portfolio</label>
                        <input type="url" class="form-control" name="website" 
                               value="<?php echo isset($cv_data['cd_website']) ? htmlspecialchars($cv_data['cd_website']) : ''; ?>" 
                               placeholder="https://johndoe.com">
                    </div>
                </div>
            </div>

            <!-- Professional Summary -->
            <div class="cv-card">
                <h2 class="section-title">
                    <div class="section-icon"><i class="fas fa-file-alt"></i></div>
                    Professional Summary
                </h2>

                <div class="form-group">
                    <label class="form-label">Summary / Objective</label>
                    <textarea class="form-control" name="summary" rows="5" 
                              placeholder="Write a brief summary about yourself, your career goals, and what makes you unique..."><?php echo isset($cv_data['cd_summary']) ? htmlspecialchars($cv_data['cd_summary']) : ''; ?></textarea>
                    <div class="help-text">2-3 sentences highlighting your key strengths and career objectives</div>
                </div>
            </div>

            <!-- Skills -->
            <div class="cv-card">
                <h2 class="section-title">
                    <div class="section-icon"><i class="fas fa-cogs"></i></div>
                    Skills & Expertise
                </h2>

                <div class="form-group">
                    <label class="form-label">Technical Skills</label>
                    <textarea class="form-control" name="skills" rows="4" 
                              placeholder="e.g., JavaScript, React, Node.js, Python, SQL, AWS, Docker..."><?php echo isset($cv_data['cd_skills']) ? htmlspecialchars($cv_data['cd_skills']) : ''; ?></textarea>
                    <div class="help-text">List your technical skills separated by commas</div>
                </div>
            </div>

            <!-- Work Experience -->
            <div class="cv-card">
                <h2 class="section-title">
                    <div class="section-icon"><i class="fas fa-briefcase"></i></div>
                    Work Experience
                </h2>

                <div class="form-group">
                    <label class="form-label">Professional Experience</label>
                    <textarea class="form-control" name="experience" rows="8" 
                              placeholder="Job Title | Company Name | Duration&#10;• Key responsibility or achievement&#10;• Another achievement&#10;&#10;Previous Job Title | Company | Duration&#10;• Responsibility&#10;• Achievement"><?php echo isset($cv_data['cd_experience']) ? htmlspecialchars($cv_data['cd_experience']) : ''; ?></textarea>
                    <div class="help-text">List your work experience starting with the most recent</div>
                </div>
            </div>

            <!-- Education -->
            <div class="cv-card">
                <h2 class="section-title">
                    <div class="section-icon"><i class="fas fa-graduation-cap"></i></div>
                    Education
                </h2>

                <div class="form-group">
                    <label class="form-label">Educational Background</label>
                    <textarea class="form-control" name="education" rows="5" 
                              placeholder="Degree | University Name | Year&#10;e.g., Bachelor of Science in Computer Science | MIT | 2020&#10;&#10;High School Diploma | School Name | Year"><?php echo isset($cv_data['cd_education']) ? htmlspecialchars($cv_data['cd_education']) : ''; ?></textarea>
                    <div class="help-text">List your educational qualifications</div>
                </div>
            </div>

            <!-- Certifications -->
            <div class="cv-card">
                <h2 class="section-title">
                    <div class="section-icon"><i class="fas fa-certificate"></i></div>
                    Certifications & Awards
                </h2>

                <div class="form-group">
                    <label class="form-label">Certifications</label>
                    <textarea class="form-control" name="certifications" rows="4" 
                              placeholder="Certification Name | Issuing Organization | Year&#10;e.g., AWS Certified Solutions Architect | Amazon | 2023"><?php echo isset($cv_data['cd_certifications']) ? htmlspecialchars($cv_data['cd_certifications']) : ''; ?></textarea>
                    <div class="help-text">List your professional certifications and awards</div>
                </div>
            </div>

            <!-- Languages -->
            <div class="cv-card">
                <h2 class="section-title">
                    <div class="section-icon"><i class="fas fa-language"></i></div>
                    Languages
                </h2>

                <div class="form-group">
                    <label class="form-label">Language Proficiency</label>
                    <textarea class="form-control" name="languages" rows="3" 
                              placeholder="e.g., English (Native), Spanish (Fluent), French (Intermediate)"><?php echo isset($cv_data['cd_languages']) ? htmlspecialchars($cv_data['cd_languages']) : ''; ?></textarea>
                    <div class="help-text">List languages you speak and your proficiency level</div>
                </div>
            </div>

            <!-- Hobbies & Interests -->
            <div class="cv-card">
                <h2 class="section-title">
                    <div class="section-icon"><i class="fas fa-heart"></i></div>
                    Hobbies & Interests
                </h2>

                <div class="form-group">
                    <label class="form-label">Personal Interests</label>
                    <textarea class="form-control" name="hobbies" rows="3" 
                              placeholder="e.g., Photography, Hiking, Reading, Volunteering..."><?php echo isset($cv_data['cd_hobbies']) ? htmlspecialchars($cv_data['cd_hobbies']) : ''; ?></textarea>
                    <div class="help-text">Optional: Share your hobbies and interests</div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="cv-card">
                <button type="submit" class="btn-save">
                    <i class="fas fa-save me-2"></i>Save My CV
                </button>
                <button type="button" class="btn-preview" onclick="previewCV()">
                    <i class="fas fa-eye me-2"></i>Preview CV
                </button>
            </div>
        </form>
    </div>
</div>

<?php
$custom_script = "
document.getElementById('cvForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    Swal.fire({
        title: 'Saving...',
        text: 'Please wait',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    fetch('" . base_url('C_dashboard/save_cv') . "', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'CV Saved!',
                text: data.message,
                timer: 2000
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while saving your CV'
        });
    });
});

function previewCV() {
    Swal.fire({
        icon: 'info',
        title: 'CV Preview',
        text: 'CV preview feature coming soon! Your CV will be displayed in a professional format.',
        confirmButtonText: 'OK'
    });
}
";

$data['custom_script'] = $custom_script;
$this->load->view('templates/candidate_footer', $data);
?>
