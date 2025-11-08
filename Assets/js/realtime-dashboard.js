/**
 * Real-Time Collaborative Hiring Dashboard
 */
class RealtimeDashboard {
    constructor(config = {}) {
        this.config = {
            baseUrl: config.baseUrl || window.location.origin + '/rms/',
            updateInterval: config.updateInterval || 5000, // 5 seconds
            ...config
        };
        
        this.stages = [];
        this.candidates = {};
        this.metrics = {};
        this.updateTimer = null;
        
        this.init();
    }

    init() {
        this.loadPipelineData();
        this.loadMetrics();
        this.startAutoUpdate();
        this.attachEventListeners();
    }

    /**
     * Load pipeline data
     */
    async loadPipelineData() {
        try {
            const response = await fetch(this.config.baseUrl + 'realtime_dashboard/get_pipeline_data');
            const result = await response.json();
            
            if (result.success) {
                this.stages = result.data;
                this.renderPipeline();
            }
        } catch (error) {
            console.error('Failed to load pipeline:', error);
        }
    }

    /**
     * Render pipeline view
     */
    renderPipeline() {
        const container = document.getElementById('pipeline-container');
        if (!container) return;
        
        container.innerHTML = '';
        
        this.stages.forEach(stage => {
            const stageEl = this.createStageElement(stage);
            container.appendChild(stageEl);
        });
        
        this.initDragAndDrop();
    }

    /**
     * Create stage element
     */
    createStageElement(stage) {
        const div = document.createElement('div');
        div.className = 'pipeline-stage';
        div.dataset.stageId = stage.id;
        
        div.innerHTML = `
            <div class="stage-header" style="background-color: ${stage.color}">
                <h3>${stage.name}</h3>
                <span class="stage-count">${stage.count}</span>
            </div>
            <div class="stage-body" data-stage-id="${stage.id}">
                ${stage.candidates.map(c => this.createCandidateCard(c)).join('')}
            </div>
        `;
        
        return div;
    }

    /**
     * Create candidate card
     */
    createCandidateCard(candidate) {
        const urgencyClass = candidate.urgency_level || 'medium';
        const daysInStage = candidate.days_in_stage || 0;
        
        return `
            <div class="candidate-card" 
                 data-candidate-id="${candidate.candidate_id}"
                 data-urgency="${urgencyClass}"
                 draggable="true">
                <div class="card-header">
                    <strong>${candidate.name || 'Unknown'}</strong>
                    <span class="urgency-badge urgency-${urgencyClass}"></span>
                </div>
                <div class="card-body">
                    <div class="card-info">
                        <i class="fas fa-briefcase"></i> ${candidate.position_applied || 'N/A'}
                    </div>
                    <div class="card-info">
                        <i class="fas fa-clock"></i> ${daysInStage} days
                    </div>
                </div>
                <div class="card-actions">
                    <button class="btn-sm" onclick="dashboard.showQuickView(${candidate.candidate_id})" title="Quick View">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn-sm" onclick="dashboard.viewCandidateDetail(${candidate.candidate_id})" title="Full Details">
                        <i class="fas fa-external-link-alt"></i>
                    </button>
                    <button class="btn-sm" onclick="dashboard.startVoting(${candidate.candidate_id})" title="Vote">
                        <i class="fas fa-vote-yea"></i>
                    </button>
                </div>
            </div>
        `;
    }

    /**
     * Initialize drag and drop
     */
    initDragAndDrop() {
        const cards = document.querySelectorAll('.candidate-card');
        const stages = document.querySelectorAll('.stage-body');
        
        cards.forEach(card => {
            card.addEventListener('dragstart', (e) => {
                e.dataTransfer.effectAllowed = 'move';
                e.dataTransfer.setData('text/html', card.innerHTML);
                e.dataTransfer.setData('candidate-id', card.dataset.candidateId);
                card.classList.add('dragging');
            });
            
            card.addEventListener('dragend', (e) => {
                card.classList.remove('dragging');
            });
        });
        
        stages.forEach(stage => {
            stage.addEventListener('dragover', (e) => {
                e.preventDefault();
                e.dataTransfer.dropEffect = 'move';
                stage.classList.add('drag-over');
            });
            
            stage.addEventListener('dragleave', (e) => {
                stage.classList.remove('drag-over');
            });
            
            stage.addEventListener('drop', (e) => {
                e.preventDefault();
                stage.classList.remove('drag-over');
                
                const candidateId = e.dataTransfer.getData('candidate-id');
                const stageId = stage.dataset.stageId;
                
                this.moveCandidate(candidateId, stageId);
            });
        });
    }

    /**
     * Move candidate to new stage
     */
    async moveCandidate(candidateId, stageId) {
        const notes = prompt('Add notes (optional):');
        
        try {
            const response = await fetch(this.config.baseUrl + 'realtime_dashboard/move_candidate', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    candidate_id: candidateId,
                    stage_id: stageId,
                    notes: notes || ''
                })
            });
            
            const result = await response.json();
            
            if (result.success) {
                this.showNotification('Candidate moved successfully!', 'success');
                this.loadPipelineData(); // Refresh
            } else {
                this.showNotification('Failed to move candidate', 'error');
            }
        } catch (error) {
            console.error('Move error:', error);
            this.showNotification('Error moving candidate', 'error');
        }
    }

    /**
     * Load metrics
     */
    async loadMetrics() {
        try {
            const response = await fetch(this.config.baseUrl + 'realtime_dashboard/get_metrics');
            const result = await response.json();
            
            if (result.success) {
                this.metrics = result.metrics;
                this.renderMetrics();
            }
        } catch (error) {
            console.error('Failed to load metrics:', error);
        }
    }

    /**
     * Render metrics
     */
    renderMetrics() {
        const container = document.getElementById('metrics-container');
        if (!container) return;
        
        container.innerHTML = `
            <div class="metric-card">
                <div class="metric-value">${this.metrics.total_candidates || 0}</div>
                <div class="metric-label">Total Candidates</div>
            </div>
            <div class="metric-card">
                <div class="metric-value">${this.metrics.avg_days_in_pipeline || 0}</div>
                <div class="metric-label">Avg Days in Pipeline</div>
            </div>
            <div class="metric-card urgent">
                <div class="metric-value">${this.metrics.urgent_count || 0}</div>
                <div class="metric-label">Urgent</div>
            </div>
            <div class="metric-card">
                <div class="metric-value">${this.metrics.today_interviews || 0}</div>
                <div class="metric-label">Today's Interviews</div>
            </div>
        `;
    }

    /**
     * Start auto-update
     */
    startAutoUpdate() {
        this.updateTimer = setInterval(() => {
            this.loadPipelineData();
            this.loadMetrics();
        }, this.config.updateInterval);
    }

    /**
     * Stop auto-update
     */
    stopAutoUpdate() {
        if (this.updateTimer) {
            clearInterval(this.updateTimer);
        }
    }

    /**
     * Start voting on candidate
     */
    async startVoting(candidateId) {
        const modal = document.getElementById('voting-modal');
        if (!modal) return;
        
        modal.dataset.candidateId = candidateId;
        modal.style.display = 'block';
    }

    /**
     * Submit vote
     */
    async submitVote(decisionId, vote, comment, isAnonymous) {
        try {
            const response = await fetch(this.config.baseUrl + 'realtime_dashboard/submit_vote', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    decision_id: decisionId,
                    vote: vote,
                    comment: comment,
                    is_anonymous: isAnonymous ? 1 : 0
                })
            });
            
            const result = await response.json();
            
            if (result.success) {
                this.showNotification('Vote submitted!', 'success');
                this.updateVoteDisplay(result.votes);
            }
        } catch (error) {
            console.error('Vote error:', error);
        }
    }

    /**
     * Show notification
     */
    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.classList.add('show');
        }, 100);
        
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    /**
     * Attach event listeners
     */
    attachEventListeners() {
        // Close user menu when clicking outside
        document.addEventListener('click', (e) => {
            const userMenu = document.getElementById('user-menu');
            const userInfo = document.querySelector('.user-info');
            
            if (userMenu && !userInfo.contains(e.target)) {
                userMenu.style.display = 'none';
            }
        });
    }
    
    /**
     * Manual refresh
     */
    manualRefresh() {
        const headerBtn = document.getElementById('refresh-btn');
        const pipelineBtn = document.getElementById('pipeline-refresh-btn');
        
        if (headerBtn) headerBtn.classList.add('spinning');
        if (pipelineBtn) pipelineBtn.classList.add('spinning');
        
        this.loadPipelineData();
        this.loadMetrics();
        
        setTimeout(() => {
            if (headerBtn) headerBtn.classList.remove('spinning');
            if (pipelineBtn) pipelineBtn.classList.remove('spinning');
            this.showNotification('Dashboard refreshed!', 'success');
        }, 1000);
    }
    
    /**
     * Toggle user menu
     */
    toggleUserMenu() {
        const menu = document.getElementById('user-menu');
        menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
    }
    
    /**
     * Open settings modal
     */
    openSettings() {
        const modal = document.getElementById('settings-modal');
        modal.style.display = 'flex';
    }
    
    /**
     * Update refresh interval
     */
    updateRefreshInterval(interval) {
        this.stopAutoUpdate();
        this.config.updateInterval = parseInt(interval);
        
        if (interval > 0) {
            this.startAutoUpdate();
            this.showNotification(`Auto-refresh set to ${interval/1000} seconds`, 'success');
        } else {
            this.showNotification('Auto-refresh disabled', 'info');
        }
    }
    
    /**
     * Toggle notifications
     */
    toggleNotifications(enabled) {
        this.config.notificationsEnabled = enabled;
        this.showNotification(enabled ? 'Notifications enabled' : 'Notifications disabled', 'info');
    }
    
    /**
     * Toggle sound
     */
    toggleSound(enabled) {
        this.config.soundEnabled = enabled;
        this.showNotification(enabled ? 'Sound alerts enabled' : 'Sound alerts disabled', 'info');
    }
    
    /**
     * Change theme
     */
    changeTheme(theme) {
        document.body.setAttribute('data-theme', theme);
        this.showNotification(`Theme changed to ${theme}`, 'success');
    }

    /**
     * Show quick view modal
     */
    async showQuickView(candidateId) {
        try {
            const response = await fetch(this.config.baseUrl + 'realtime_dashboard/get_candidate/' + candidateId);
            const result = await response.json();
            
            if (result.success) {
                this.displayQuickViewModal(result.candidate);
            } else {
                this.showNotification('Failed to load candidate details', 'error');
            }
        } catch (error) {
            console.error('Error loading candidate:', error);
            this.showNotification('Error loading candidate details', 'error');
        }
    }
    
    /**
     * Display quick view modal
     */
    displayQuickViewModal(candidate) {
        const modal = document.getElementById('quick-view-modal');
        if (!modal) return;
        
        const content = `
            <div class="candidate-header">
                <div class="candidate-avatar">
                    ${candidate.name.charAt(0).toUpperCase()}
                </div>
                <div>
                    <h3>${candidate.name}</h3>
                    <p class="text-muted">${candidate.position_applied || 'N/A'}</p>
                </div>
            </div>
            <div class="candidate-details">
                <div class="detail-row">
                    <i class="fas fa-envelope"></i>
                    <span>${candidate.email}</span>
                </div>
                <div class="detail-row">
                    <i class="fas fa-phone"></i>
                    <span>${candidate.phone || 'N/A'}</span>
                </div>
                <div class="detail-row">
                    <i class="fas fa-calendar"></i>
                    <span>Applied: ${new Date(candidate.created_at).toLocaleDateString()}</span>
                </div>
                <div class="detail-row">
                    <i class="fas fa-flag"></i>
                    <span>Status: ${candidate.status || 'Active'}</span>
                </div>
            </div>
            <div class="modal-actions">
                <button class="btn-primary" onclick="dashboard.viewCandidateDetail(${candidate.id})">
                    <i class="fas fa-external-link-alt"></i> View Full Details
                </button>
                <button class="btn-secondary" onclick="document.getElementById('quick-view-modal').style.display='none'">
                    Close
                </button>
            </div>
        `;
        
        document.getElementById('quick-view-content').innerHTML = content;
        modal.style.display = 'flex';
    }
    
    /**
     * View full candidate details page
     */
    viewCandidateDetail(candidateId) {
        window.location.href = this.config.baseUrl + 'realtime_dashboard/candidate_detail/' + candidateId;
    }
}

// Initialize when DOM is ready
let dashboard;
if (typeof dashboardConfig !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            dashboard = new RealtimeDashboard(dashboardConfig);
        });
    } else {
        dashboard = new RealtimeDashboard(dashboardConfig);
    }
}
