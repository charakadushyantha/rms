<?php
$data['page_title'] = 'Feedback History';
$this->load->view('templates/interviewer_header', $data);
?>

<style>
.history-container {
    padding: 2rem;
    background: #f8f9fa;
    min-height: calc(100vh - 70px);
}

.history-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 2px solid #f3f4f6;
}

.page-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
}

.search-box {
    position: relative;
    width: 300px;
}

.search-box input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 2.75rem;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    transition: all 0.2s;
}

.search-box input:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    outline: none;
}

.search-box i {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
}

.feedback-item {
    background: #f9fafb;
    padding: 1.5rem;
    border-radius: 12px;
    margin-bottom: 1rem;
    border-left: 4px solid #667eea;
    transition: all 0.2s;
}

.feedback-item:hover {
    background: #f3f4f6;
    transform: translateX(4px);
}

.feedback-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 1rem;
}

.candidate-info h4 {
    margin: 0 0 0.25rem 0;
    color: #1f2937;
    font-size: 1.125rem;
    font-weight: 700;
}

.candidate-info p {
    margin: 0;
    color: #6b7280;
    font-size: 0.875rem;
}

.feedback-date {
    text-align: right;
    color: #6b7280;
    font-size: 0.875rem;
}

.rating-display {
    display: flex;
    gap: 2rem;
    margin-bottom: 1rem;
    flex-wrap: wrap;
}

.rating-item {
    display: flex;
    flex-direction: column;
}

.rating-label {
    font-size: 0.75rem;
    color: #6b7280;
    margin-bottom: 0.25rem;
}

.rating-stars {
    color: #fbbf24;
}

.recommendation-badge {
    display: inline-block;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
}

.recommendation-strong_hire {
    background: #d1fae5;
    color: #065f46;
}

.recommendation-hire {
    background: #dbeafe;
    color: #1e40af;
}

.recommendation-maybe {
    background: #fef3c7;
    color: #92400e;
}

.recommendation-no_hire {
    background: #fee2e2;
    color: #991b1b;
}

.recommendation-strong_no_hire {
    background: #fecaca;
    color: #7f1d1d;
}

.feedback-details {
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #e5e7eb;
}

.detail-section {
    margin-bottom: 0.75rem;
}

.detail-title {
    font-weight: 600;
    color: #374151;
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
}

.detail-text {
    color: #6b7280;
    font-size: 0.875rem;
    line-height: 1.5;
}

.btn-view {
    background: #667eea;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-view:hover {
    background: #5568d3;
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: #9ca3af;
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.empty-state h3 {
    color: #6b7280;
    margin-bottom: 0.5rem;
}
</style>

<div class="history-container">
    <div class="history-card">
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-history me-2"></i>Feedback History
            </h1>
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchFeedback" placeholder="Search by candidate name...">
            </div>
        </div>

        <div id="feedbackList">
            <?php if (!empty($feedback_list)): ?>
                <?php foreach ($feedback_list as $feedback): ?>
                    <div class="feedback-item" data-candidate="<?php echo strtolower($feedback['Can_name']); ?>">
                        <div class="feedback-header">
                            <div class="candidate-info">
                                <h4><?php echo htmlspecialchars($feedback['Can_name']); ?></h4>
                                <p><?php echo htmlspecialchars($feedback['Can_position']); ?></p>
                            </div>
                            <div class="feedback-date">
                                <i class="fas fa-calendar me-1"></i>
                                <?php echo date('M d, Y', strtotime($feedback['submitted_at'])); ?>
                            </div>
                        </div>

                        <div class="rating-display">
                            <div class="rating-item">
                                <span class="rating-label">Technical</span>
                                <div class="rating-stars">
                                    <?php for ($i = 0; $i < 5; $i++): ?>
                                        <i class="fas fa-star<?php echo $i < $feedback['technical_skills'] ? '' : ' text-muted'; ?>"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <div class="rating-item">
                                <span class="rating-label">Communication</span>
                                <div class="rating-stars">
                                    <?php for ($i = 0; $i < 5; $i++): ?>
                                        <i class="fas fa-star<?php echo $i < $feedback['communication'] ? '' : ' text-muted'; ?>"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <div class="rating-item">
                                <span class="rating-label">Problem Solving</span>
                                <div class="rating-stars">
                                    <?php for ($i = 0; $i < 5; $i++): ?>
                                        <i class="fas fa-star<?php echo $i < $feedback['problem_solving'] ? '' : ' text-muted'; ?>"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <div class="rating-item">
                                <span class="rating-label">Cultural Fit</span>
                                <div class="rating-stars">
                                    <?php for ($i = 0; $i < 5; $i++): ?>
                                        <i class="fas fa-star<?php echo $i < $feedback['cultural_fit'] ? '' : ' text-muted'; ?>"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <div class="rating-item">
                                <span class="rating-label">Overall</span>
                                <div class="rating-stars">
                                    <?php for ($i = 0; $i < 5; $i++): ?>
                                        <i class="fas fa-star<?php echo $i < $feedback['overall_rating'] ? '' : ' text-muted'; ?>"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>

                        <div>
                            <span class="recommendation-badge recommendation-<?php echo $feedback['recommendation']; ?>">
                                <?php echo ucwords(str_replace('_', ' ', $feedback['recommendation'])); ?>
                            </span>
                        </div>

                        <div class="feedback-details">
                            <?php if (!empty($feedback['strengths'])): ?>
                            <div class="detail-section">
                                <div class="detail-title">
                                    <i class="fas fa-thumbs-up me-1"></i>Strengths
                                </div>
                                <div class="detail-text"><?php echo htmlspecialchars($feedback['strengths']); ?></div>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($feedback['weaknesses'])): ?>
                            <div class="detail-section">
                                <div class="detail-title">
                                    <i class="fas fa-exclamation-triangle me-1"></i>Areas for Improvement
                                </div>
                                <div class="detail-text"><?php echo htmlspecialchars($feedback['weaknesses']); ?></div>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($feedback['detailed_feedback'])): ?>
                            <div class="detail-section">
                                <div class="detail-title">
                                    <i class="fas fa-comment me-1"></i>Detailed Comments
                                </div>
                                <div class="detail-text"><?php echo htmlspecialchars($feedback['detailed_feedback']); ?></div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-clipboard-list"></i>
                    <h3>No Feedback Yet</h3>
                    <p>You haven't submitted any interview feedback yet.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
$custom_script = "
// Search functionality
document.getElementById('searchFeedback').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const feedbackItems = document.querySelectorAll('.feedback-item');
    
    feedbackItems.forEach(item => {
        const candidateName = item.dataset.candidate;
        if (candidateName.includes(searchTerm)) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
});
";

$data['custom_script'] = $custom_script;
$this->load->view('templates/interviewer_footer', $data);
?>
