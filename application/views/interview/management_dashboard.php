<?php
$data['page_title'] = 'Interview Management';
$data['use_datatable'] = false;
$data['active_menu'] = 'interviews';
$this->load->view('templates/admin_header', $data);
?>

<style>
/* ── Modern IMS Styles ── */
body {
    background: #f5f7fa;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
}

.ims-container {
    padding: 24px;
    max-width: 1400px;
    margin: 0 auto;
}

/* Modern Header */
.ims-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 32px;
    margin-bottom: 28px;
    color: white;
    box-shadow: 0 8px 24px rgba(102, 126, 234, 0.25);
    position: relative;
    overflow: hidden;
}

.ims-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 400px;
    height: 400px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
}

.ims-header-content {
    position: relative;
    z-index: 1;
}

.ims-header h1 {
    font-size: 32px;
    font-weight: 700;
    margin: 0 0 8px 0;
    display: flex;
    align-items: center;
    gap: 12px;
}

.ims-header p {
    font-size: 15px;
    opacity: 0.95;
    margin: 0;
}

.ims-header-actions {
    display: flex;
    gap: 12px;
    margin-top: 20px;
}

.ims-btn {
    padding: 12px 24px;
    border-radius: 10px;
    border: none;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
}

.ims-btn-white {
    background: white;
    color: #667eea;
}

.ims-btn-white:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.ims-btn-outline {
    background: transparent;
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.ims-btn-outline:hover {
    background: rgba(255, 255, 255, 0.1);
    border-color: white;
}

/* Modern Stats Grid */
.ims-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
    margin-bottom: 28px;
}

.ims-stat-card {
    background: white;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
    border: 1px solid #f0f0f0;
    position: relative;
    overflow: hidden;
}

.ims-stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: currentColor;
}

.ims-stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
}

.ims-stat-card.scheduled { color: #667eea; }
.ims-stat-card.completed { color: #22c55e; }
.ims-stat-card.pending { color: #f59e0b; }
.ims-stat-card.cancelled { color: #ef4444; }

.ims-stat-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 16px;
}

.ims-stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    background: currentColor;
    color: white;
    opacity: 0.9;
}

.ims-stat-value {
    font-size: 36px;
    font-weight: 700;
    color: #1a1a1a;
    line-height: 1;
}

.ims-stat-label {
    font-size: 14px;
    color: #666;
    margin-top: 8px;
    font-weight: 500;
}

.ims-layout { 
    display: block;
    max-width: 100%;
}

/* Modern Filters */
.ims-filters-card {
    background: white;
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    border: 1px solid #f0f0f0;
}

.ims-filters-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.ims-filters-header h3 {
    font-size: 16px;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.ims-filter-grid {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr 1fr;
    gap: 16px;
    align-items: end;
}

.ims-filter-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.ims-filter-group label {
    font-size: 13px;
    font-weight: 600;
    color: #555;
    display: flex;
    align-items: center;
    gap: 6px;
}

.ims-filter-group input,
.ims-filter-group select {
    padding: 11px 14px;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.2s;
    background: white;
    width: 100%;
}

.ims-filter-group input:focus,
.ims-filter-group select:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.ims-filter-actions {
    display: flex;
    gap: 10px;
}

.ims-btn-filter {
    padding: 11px 24px;
    border-radius: 8px;
    border: none;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
}

.ims-btn-primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.ims-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.ims-btn-secondary {
    background: #f5f5f5;
    color: #666;
    border: 1px solid #e0e0e0;
}

.ims-btn-secondary:hover {
    background: #e0e0e0;
}

/* Modern Interview Cards */
.ims-interviews-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.ims-interview-card {
    background: white;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    border: 1px solid #f0f0f0;
    transition: all 0.3s ease;
    position: relative;
}

.ims-interview-card:hover {
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    transform: translateY(-2px);
}

.ims-card-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 16px;
}

.ims-card-title {
    flex: 1;
}

.ims-candidate-name {
    font-size: 18px;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0 0 6px 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.ims-position-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
    color: #667eea;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
}

.ims-status-badge {
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.ims-status-badge.status-pending {
    background: linear-gradient(135deg, #fff3cd, #ffe69c);
    color: #856404;
}

.ims-status-badge.status-in_progress {
    background: linear-gradient(135deg, #cfe2ff, #9ec5fe);
    color: #084298;
}

.ims-status-badge.status-completed {
    background: linear-gradient(135deg, #d1e7dd, #a3cfbb);
    color: #0a3622;
}

.ims-status-badge.status-cancelled {
    background: linear-gradient(135deg, #f8d7da, #f1aeb5);
    color: #842029;
}

.ims-card-meta {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    margin-bottom: 16px;
    padding: 16px;
    background: #f8f9fa;
    border-radius: 12px;
}

.ims-meta-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
    color: #555;
}

.ims-meta-item i {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: white;
    border-radius: 8px;
    color: #667eea;
    font-size: 16px;
}

.ims-meta-item strong {
    display: block;
    color: #1a1a1a;
    font-size: 13px;
    font-weight: 600;
}

.ims-card-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.ims-action-btn {
    padding: 10px 18px;
    border-radius: 8px;
    border: none;
    font-weight: 600;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.ims-action-btn.primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.ims-action-btn.primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.ims-action-btn.secondary {
    background: #f5f5f5;
    color: #666;
    border: 1px solid #e0e0e0;
}

.ims-action-btn.secondary:hover {
    background: #e0e0e0;
}

.ims-action-btn.info {
    background: #e3f2fd;
    color: #1976d2;
    border: 1px solid #bbdefb;
}

.ims-action-btn.info:hover {
    background: #bbdefb;
}

.ims-action-btn.danger {
    background: #ffebee;
    color: #c62828;
    border: 1px solid #ef9a9a;
}

.ims-action-btn.danger:hover {
    background: #ef9a9a;
    color: white;
}

.ims-expanded {
    display: none;
    margin-top: 20px;
    padding-top: 20px;
    border-top: 2px solid #f0f0f0;
}

.ims-expanded-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
}

.ims-info-section h4 {
    font-size: 14px;
    font-weight: 700;
    color: #667eea;
    margin-bottom: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.ims-info-section p {
    font-size: 14px;
    color: #555;
    margin-bottom: 8px;
    line-height: 1.6;
}

.ims-info-section strong {
    color: #1a1a1a;
    font-weight: 600;
}

/* Sidebar Widgets */
.ims-widget {
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    margin-bottom: 20px;
    overflow: hidden;
    border: 1px solid #f0f0f0;
}

.ims-widget-header {
    padding: 20px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.ims-widget-header h3 {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 8px;
}

.ims-widget-body {
    padding: 20px;
}

.ims-cal-nav {
    display: flex;
    align-items: center;
    gap: 10px;
}

.ims-cal-nav button {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
    border-radius: 8px;
    width: 32px;
    height: 32px;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.ims-cal-nav button:hover {
    background: rgba(255, 255, 255, 0.3);
}

.ims-cal-nav span {
    font-size: 14px;
    font-weight: 600;
}

.ims-mini-cal {
    width: 100%;
}

.ims-cal-weekdays {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    text-align: center;
    font-size: 12px;
    font-weight: 700;
    color: #999;
    margin-bottom: 8px;
}

.ims-cal-days {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 4px;
}

.ims-cal-day {
    text-align: center;
    padding: 8px 4px;
    font-size: 13px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
    font-weight: 500;
}

.ims-cal-day.today {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    font-weight: 700;
}

.ims-cal-day.has-interview {
    background: rgba(102, 126, 234, 0.15);
    color: #667eea;
    font-weight: 700;
}

.ims-cal-day.other-month {
    color: #ccc;
}

.ims-cal-day:hover:not(.today) {
    background: #f5f5f5;
}

.ims-today-item {
    display: flex;
    gap: 12px;
    padding: 12px;
    border-bottom: 1px solid #f5f5f5;
    border-radius: 8px;
    transition: all 0.2s;
}

.ims-today-item:hover {
    background: #f8f9fa;
}

.ims-today-item:last-child {
    border-bottom: none;
}

.ims-today-time {
    font-size: 13px;
    font-weight: 700;
    color: #667eea;
    white-space: nowrap;
    min-width: 60px;
}

.ims-today-info strong {
    display: block;
    font-size: 14px;
    color: #1a1a1a;
    font-weight: 600;
}

.ims-today-info span {
    font-size: 13px;
    color: #888;
}

.ims-quick-btn {
    display: flex;
    align-items: center;
    gap: 12px;
    width: 100%;
    padding: 14px 16px;
    margin-bottom: 10px;
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    color: #333;
    cursor: pointer;
    transition: all 0.2s;
    text-align: left;
}

.ims-quick-btn:hover {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
    border-color: #667eea;
    color: #667eea;
    transform: translateX(4px);
}

.ims-quick-btn i {
    width: 20px;
    color: #667eea;
    font-size: 16px;
}

.ims-upcoming-item {
    display: flex;
    gap: 14px;
    padding: 14px;
    border-bottom: 1px solid #f5f5f5;
    border-radius: 8px;
    transition: all 0.2s;
}

.ims-upcoming-item:hover {
    background: #f8f9fa;
}

.ims-upcoming-item:last-child {
    border-bottom: none;
}

.ims-upcoming-date {
    text-align: center;
    min-width: 48px;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
    border-radius: 10px;
    padding: 8px;
}

.ims-upcoming-date .day {
    font-size: 22px;
    font-weight: 700;
    color: #667eea;
    line-height: 1;
}

.ims-upcoming-date .month {
    font-size: 11px;
    color: #764ba2;
    text-transform: uppercase;
    font-weight: 600;
    margin-top: 4px;
}

.ims-upcoming-info strong {
    display: block;
    font-size: 14px;
    color: #1a1a1a;
    font-weight: 600;
}

.ims-upcoming-info span {
    font-size: 13px;
    color: #888;
}

.ims-upcoming-info small {
    font-size: 12px;
    color: #aaa;
}

.ims-pagination {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 16px;
    margin-top: 28px;
    padding: 20px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
}

.ims-pagination button {
    padding: 10px 20px;
    border-radius: 8px;
    border: 1px solid #e0e0e0;
    background: white;
    color: #666;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.ims-pagination button:hover:not(:disabled) {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border-color: #667eea;
}

.ims-pagination button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.ims-empty {
    text-align: center;
    padding: 60px 20px;
    color: #999;
}

.ims-empty i {
    font-size: 64px;
    margin-bottom: 20px;
    display: block;
    color: #ddd;
}

.ims-empty h3 {
    font-size: 20px;
    color: #555;
    margin-bottom: 12px;
    font-weight: 700;
}

.no-interviews {
    font-size: 14px;
    color: #999;
    text-align: center;
    padding: 16px 0;
}

@media (max-width: 1200px) {
    .ims-container {
        padding: 16px;
    }
}

@media (max-width: 768px) {
    .ims-stats-grid {
        grid-template-columns: 1fr 1fr;
    }
    
    .ims-filter-grid {
        grid-template-columns: 1fr;
    }
    
    .ims-filter-actions {
        flex-direction: column;
    }
    
    .ims-btn-filter {
        width: 100%;
        justify-content: center;
    }
    
    .ims-expanded-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 576px) {
    .ims-stats-grid {
        grid-template-columns: 1fr;
    }
    
    .ims-header h1 {
        font-size: 24px;
    }
    
    .ims-card-meta {
        grid-template-columns: 1fr;
    }
}

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

<div class="ims-container">
    <!-- Modern Header -->
    <div class="ims-header">
        <div class="ims-header-content">
            <h1>
                <i class="fas fa-calendar-check"></i>
                Interview Management System
            </h1>
            <p>Manage, schedule, and track all your interviews in one place</p>
            <div class="ims-header-actions">
                <a href="<?= base_url('interview/create_interview') ?>" class="ims-btn ims-btn-white">
                    <i class="fas fa-plus"></i>
                    Schedule New Interview
                </a>
                <button onclick="exportReport()" class="ims-btn ims-btn-outline">
                    <i class="fas fa-download"></i>
                    Export Report
                </button>
            </div>
        </div>
    </div>

    <!-- Modern Statistics -->
    <div class="ims-stats-grid">
        <div class="ims-stat-card scheduled">
            <div class="ims-stat-header">
                <div>
                    <div class="ims-stat-value"><?= $stats['scheduled'] ?? 0 ?></div>
                    <div class="ims-stat-label">Scheduled</div>
                </div>
                <div class="ims-stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
        <div class="ims-stat-card completed">
            <div class="ims-stat-header">
                <div>
                    <div class="ims-stat-value"><?= $stats['completed'] ?? 0 ?></div>
                    <div class="ims-stat-label">Completed</div>
                </div>
                <div class="ims-stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
        <div class="ims-stat-card pending">
            <div class="ims-stat-header">
                <div>
                    <div class="ims-stat-value"><?= $stats['pending'] ?? 0 ?></div>
                    <div class="ims-stat-label">In Progress</div>
                </div>
                <div class="ims-stat-icon">
                    <i class="fas fa-hourglass-half"></i>
                </div>
            </div>
        </div>
        <div class="ims-stat-card cancelled">
            <div class="ims-stat-header">
                <div>
                    <div class="ims-stat-value"><?= $stats['cancelled'] ?? 0 ?></div>
                    <div class="ims-stat-label">Cancelled</div>
                </div>
                <div class="ims-stat-icon">
                    <i class="fas fa-times-circle"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Layout -->
    <div class="ims-layout">
        <!-- Modern Filters -->
        <div class="ims-filters-card">
            <div class="ims-filter-grid">
                <div class="ims-filter-group">
                    <label>
                        <i class="fas fa-search"></i>
                        Search
                    </label>
                    <input type="text" id="search-input" placeholder="Search by name, email..." class="form-control">
                </div>
                <div class="ims-filter-group">
                    <label>
                        <i class="fas fa-tag"></i>
                        Status
                    </label>
                    <select id="status-filter" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="scheduled">Scheduled</option>
                        <option value="completed">Completed</option>
                        <option value="pending">In Progress</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="ims-filter-group">
                    <label>
                        <i class="fas fa-briefcase"></i>
                        Position
                    </label>
                    <select id="position-filter" class="form-select">
                        <option value="">All Positions</option>
                        <?php foreach ($positions as $position): ?>
                        <option value="<?= $position ?>"><?= htmlspecialchars($position) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="ims-filter-group">
                    <label>
                        <i class="fas fa-calendar"></i>
                        From
                    </label>
                    <input type="date" id="date-from" class="form-control">
                </div>
                <div class="ims-filter-group">
                    <label>
                        <i class="fas fa-calendar"></i>
                        To
                    </label>
                    <input type="date" id="date-to" class="form-control">
                </div>
            </div>
            <div class="ims-filter-actions" style="margin-top: 16px;">
                <button class="ims-btn-filter ims-btn-primary" onclick="applyFilters()">
                    <i class="fas fa-search"></i>
                    Apply Filters
                </button>
                <button class="ims-btn-filter ims-btn-secondary" onclick="clearFilters()">
                    <i class="fas fa-times"></i>
                    Clear
                </button>
            </div>
        </div>

        <!-- Interview List -->
        <div class="ims-interviews-list" id="interview-list">
            <?php if (!empty($interviews)): ?>
                <?php foreach ($interviews as $interview): ?>
                <div class="ims-interview-card" data-id="<?= $interview['id'] ?>">
                    <div class="ims-card-header">
                        <div class="ims-card-title">
                            <h3 class="ims-candidate-name">
                                <i class="fas fa-user-circle"></i>
                                <?= htmlspecialchars($interview['candidate_name'] ?? 'Unknown Candidate') ?>
                            </h3>
                            <span class="ims-position-badge">
                                <i class="fas fa-briefcase"></i>
                                <?= htmlspecialchars($interview['job_title'] ?? 'Position Not Set') ?>
                            </span>
                        </div>
                        <span class="ims-status-badge status-<?= $interview['status'] ?>">
                            <?= ucfirst(str_replace('_', ' ', $interview['status'])) ?>
                        </span>
                    </div>
                    
                    <div class="ims-card-meta">
                        <div class="ims-meta-item">
                            <i class="fas fa-calendar-day"></i>
                            <div>
                                <strong>Date</strong>
                                <span>
                                    <?php if (!empty($interview['interview_date'])): ?>
                                        <?= date('M d, Y', strtotime($interview['interview_date'])) ?>
                                    <?php else: ?>
                                        Not Scheduled
                                    <?php endif; ?>
                                </span>
                            </div>
                        </div>
                        <div class="ims-meta-item">
                            <i class="fas fa-clock"></i>
                            <div>
                                <strong>Time</strong>
                                <span>
                                    <?php if (!empty($interview['interview_start_time'])): ?>
                                        <?= date('h:i A', strtotime($interview['interview_start_time'])) ?>
                                    <?php else: ?>
                                        Not Set
                                    <?php endif; ?>
                                </span>
                            </div>
                        </div>
                        <div class="ims-meta-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <strong>Email</strong>
                                <span><?= htmlspecialchars($interview['candidate_email'] ?? 'No Email') ?></span>
                            </div>
                        </div>
                        <?php if (!empty($interview['assigned_interviewer'])): ?>
                        <div class="ims-meta-item">
                            <i class="fas fa-user-tie"></i>
                            <div>
                                <strong>Interviewer</strong>
                                <span><?= htmlspecialchars($interview['assigned_interviewer']) ?></span>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="ims-card-actions">
                        <button class="ims-action-btn primary" onclick="viewInterview(<?= $interview['id'] ?>)">
                            <i class="fas fa-eye"></i>
                            View Details
                        </button>
                        <button class="ims-action-btn secondary" onclick="rescheduleInterview(<?= $interview['id'] ?>)">
                            <i class="fas fa-calendar-alt"></i>
                            Reschedule
                        </button>
                        <button class="ims-action-btn info" onclick="sendReminder(<?= $interview['id'] ?>)">
                            <i class="fas fa-paper-plane"></i>
                            Send Reminder
                        </button>
                        <button class="ims-action-btn danger" onclick="cancelInterview(<?= $interview['id'] ?>)">
                            <i class="fas fa-ban"></i>
                            Cancel
                        </button>
                        <button class="ims-action-btn secondary" onclick="toggleDetails(<?= $interview['id'] ?>)">
                            <i class="fas fa-chevron-down"></i>
                            More Info
                        </button>
                    </div>
                    
                    <div class="ims-expanded" id="details-<?= $interview['id'] ?>">
                        <div class="ims-expanded-grid">
                            <div class="ims-info-section">
                                <h4><i class="fas fa-user"></i> Candidate Information</h4>
                                <p><strong>Email:</strong> <?= htmlspecialchars($interview['candidate_email'] ?? 'Not provided') ?></p>
                                <p><strong>Phone:</strong> <?= htmlspecialchars($interview['candidate_phone'] ?? 'Not provided') ?></p>
                                <p><strong>Token:</strong> <?= htmlspecialchars($interview['token'] ?? 'N/A') ?></p>
                            </div>
                            <div class="ims-info-section">
                                <h4><i class="fas fa-info-circle"></i> Interview Details</h4>
                                <p><strong>Status:</strong> <?= ucfirst(str_replace('_', ' ', $interview['status'])) ?></p>
                                <?php if (!empty($interview['interview_date'])): ?>
                                <p><strong>Scheduled Date:</strong> <?= date('M d, Y', strtotime($interview['interview_date'])) ?></p>
                                <?php endif; ?>
                                <?php if (!empty($interview['interview_start_time']) && !empty($interview['interview_end_time'])): ?>
                                <p><strong>Time:</strong> <?= date('h:i A', strtotime($interview['interview_start_time'])) ?> - <?= date('h:i A', strtotime($interview['interview_end_time'])) ?></p>
                                <?php endif; ?>
                                <?php if (!empty($interview['interview_duration'])): ?>
                                <p><strong>Duration:</strong> <?= $interview['interview_duration'] ?> minutes</p>
                                <?php endif; ?>
                                <?php if (!empty($interview['interview_round'])): ?>
                                <p><strong>Round:</strong> <?= htmlspecialchars($interview['interview_round']) ?></p>
                                <?php endif; ?>
                                <?php if (!empty($interview['interview_type'])): ?>
                                <p><strong>Type:</strong> <?= ucfirst($interview['interview_type']) ?></p>
                                <?php endif; ?>
                                <?php if ($interview['interview_type'] === 'online' && !empty($interview['online_platform'])): ?>
                                <p><strong>Platform:</strong> <?= htmlspecialchars($interview['online_platform']) ?></p>
                                <?php endif; ?>
                                <?php if ($interview['interview_type'] === 'in_person' && !empty($interview['venue_location'])): ?>
                                <p><strong>Location:</strong> <?= htmlspecialchars($interview['venue_location']) ?></p>
                                <?php endif; ?>
                                <p><strong>Created:</strong> <?= isset($interview['created_at']) ? date('M d, Y h:i A', strtotime($interview['created_at'])) : 'N/A' ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="ims-empty">
                    <i class="fas fa-calendar-times"></i>
                    <h3>No Interviews Found</h3>
                    <p>Schedule your first interview to get started</p>
                    <a href="<?= base_url('interview/create_interview') ?>" class="ims-btn ims-btn-primary" style="display: inline-flex; margin-top: 16px;">
                        <i class="fas fa-plus"></i>
                        Schedule Interview
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <?php if (!empty($interviews)): ?>
        <div class="ims-pagination">
            <button <?= $page <= 1 ? 'disabled' : '' ?> onclick="changePage(<?= $page - 1 ?>)">
                <i class="fas fa-chevron-left"></i>
                Previous
            </button>
            <span style="font-weight: 600; color: #667eea;">Page <?= $page ?> of <?= $total_pages ?></span>
            <button <?= $page >= $total_pages ? 'disabled' : '' ?> onclick="changePage(<?= $page + 1 ?>)">
                Next
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
        <?php endif; ?>
    </div><!-- /.ims-layout -->
</div><!-- /.ims-container -->

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

<?php
$base_url = base_url();
$custom_script = <<<JAVASCRIPT

var imsCurrentMonth = new Date().getMonth();
var imsCurrentYear  = new Date().getFullYear();
var imsInterviewDates = {};
var confirmModalCallback = null;

// Modern Confirm Dialog
function showConfirm(title, message, callback, type) {
    type = type || 'primary';
    var modal = document.getElementById('confirmModal');
    var modalInstance = new bootstrap.Modal(modal);
    
    // Set modal type class
    modal.className = 'modal fade modern-modal';
    if (type === 'danger') modal.classList.add('danger-modal');
    else if (type === 'warning') modal.classList.add('warning-modal');
    else if (type === 'success') modal.classList.add('success-modal');
    else if (type === 'info') modal.classList.add('info-modal');
    
    // Set icon based on type
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

// Modern Alert Dialog
function showAlert(title, message, type) {
    type = type || 'info';
    var modal = document.getElementById('alertModal');
    var modalInstance = new bootstrap.Modal(modal);
    
    // Set modal type class
    modal.className = 'modal fade modern-modal';
    if (type === 'danger') modal.classList.add('danger-modal');
    else if (type === 'warning') modal.classList.add('warning-modal');
    else if (type === 'success') modal.classList.add('success-modal');
    else if (type === 'info') modal.classList.add('info-modal');
    
    // Set icon based on type
    var icon = 'fa-info-circle';
    if (type === 'danger') icon = 'fa-times-circle';
    else if (type === 'warning') icon = 'fa-exclamation-triangle';
    else if (type === 'success') icon = 'fa-check-circle';
    
    document.querySelector('#alertModalTitle i').className = 'fas ' + icon;
    document.getElementById('alertModalTitleText').textContent = title;
    document.getElementById('alertModalBody').textContent = message;
    
    modalInstance.show();
}

// Handle confirm action
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('confirmModalAction').addEventListener('click', function() {
        if (confirmModalCallback) {
            confirmModalCallback();
            confirmModalCallback = null;
        }
        var modal = bootstrap.Modal.getInstance(document.getElementById('confirmModal'));
        modal.hide();
    });
});

function renderCalendar(month, year) {
    var months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
    document.getElementById('current-month').textContent = months[month] + ' ' + year;
    
    // Fetch interview dates for this month
    $.ajax({
        url: '{$base_url}interview/get_calendar_data',
        type: 'GET',
        data: { month: month + 1, year: year },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                imsInterviewDates = response.dates;
                drawCalendar(month, year);
            }
        }
    });
}

function drawCalendar(month, year) {
    var firstDay = new Date(year, month, 1).getDay();
    var daysInMonth = new Date(year, month + 1, 0).getDate();
    var today = new Date();
    var html = '';
    
    for (var i = 0; i < firstDay; i++) html += '<div class="ims-cal-day other-month"></div>';
    
    for (var d = 1; d <= daysInMonth; d++) {
        var cls = 'ims-cal-day';
        var dateStr = year + '-' + String(month + 1).padStart(2, '0') + '-' + String(d).padStart(2, '0');
        
        if (d === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
            cls += ' today';
        }
        
        if (imsInterviewDates[dateStr]) {
            cls += ' has-interview';
        }
        
        html += '<div class="' + cls + '">' + d + '</div>';
    }
    
    document.getElementById('calendar-days').innerHTML = html;
}

function previousMonth() {
    imsCurrentMonth--;
    if (imsCurrentMonth < 0) { imsCurrentMonth = 11; imsCurrentYear--; }
    renderCalendar(imsCurrentMonth, imsCurrentYear);
}

function nextMonth() {
    imsCurrentMonth++;
    if (imsCurrentMonth > 11) { imsCurrentMonth = 0; imsCurrentYear++; }
    renderCalendar(imsCurrentMonth, imsCurrentYear);
}

function toggleDetails(id) {
    var el = document.getElementById('details-' + id);
    if (el) {
        if (el.style.display === 'none' || el.style.display === '') {
            el.style.display = 'block';
        } else {
            el.style.display = 'none';
        }
    }
}

function changePage(page) {
    window.location.href = '{$base_url}interview/management?page=' + page;
}

function applyFilters() {
    var search   = document.getElementById('search-input').value.toLowerCase();
    var status   = document.getElementById('status-filter').value.toLowerCase();
    var position = document.getElementById('position-filter').value.toLowerCase();
    var dateFrom = document.getElementById('date-from').value;
    var dateTo   = document.getElementById('date-to').value;
    
    var cards = document.querySelectorAll('.ims-interview-card');
    
    cards.forEach(function(card) {
        var text = card.textContent.toLowerCase();
        var show = true;
        
        if (search && !text.includes(search)) show = false;
        if (status && !text.includes(status)) show = false;
        if (position && !text.includes(position)) show = false;
        
        card.style.display = show ? '' : 'none';
    });
}

function clearFilters() {
    document.getElementById('search-input').value = '';
    document.getElementById('status-filter').value = '';
    document.getElementById('position-filter').value = '';
    document.getElementById('date-from').value = '';
    document.getElementById('date-to').value = '';
    
    var cards = document.querySelectorAll('.ims-interview-card');
    cards.forEach(function(card) {
        card.style.display = '';
    });
}

function exportReport() {
    window.location.href = '{$base_url}interview/export_report';
}

function scheduleInterview() {
    window.location.href = '{$base_url}interview/create_interview';
}

function viewInterview(id) {
    window.location.href = '{$base_url}interview/view/' + id;
}

function rescheduleInterview(id) {
    showConfirm(
        'Reschedule Interview',
        'Do you want to reschedule this interview?',
        function() {
            window.location.href = '{$base_url}interview/create_interview?reschedule=' + id;
        },
        'info'
    );
}

function sendReminder(id) {
    showConfirm(
        'Send Reminder',
        'Send reminder email to the candidate?',
        function() {
            $.ajax({
                url: '{$base_url}interview/send_reminder_ajax',
                type: 'POST',
                data: { interview_id: id },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        showAlert('Success', response.message, 'success');
                    } else {
                        showAlert('Error', response.message, 'danger');
                    }
                },
                error: function() {
                    showAlert('Error', 'Failed to send reminder. Please try again.', 'danger');
                }
            });
        },
        'info'
    );
}

function cancelInterview(id) {
    showConfirm(
        'Cancel Interview',
        'Are you sure you want to cancel this interview? This action cannot be undone.',
        function() {
            $.ajax({
                url: '{$base_url}interview/cancel_interview_ajax',
                type: 'POST',
                data: { interview_id: id },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        showAlert('Success', response.message, 'success');
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        showAlert('Error', response.message, 'danger');
                    }
                },
                error: function() {
                    showAlert('Error', 'Failed to cancel interview. Please try again.', 'danger');
                }
            });
        },
        'danger'
    );
}

function openEmailTemplates() {
    window.location.href = '{$base_url}Setup/interview_templates';
}

function manageInterviewers() {
    window.location.href = '{$base_url}A_dashboard/Ainterviewer_users_view';
}

function viewFeedbackForms() {
    showAlert('Coming Soon', 'Feedback forms feature is under development. Stay tuned!', 'info');
}

function viewNotifications() {
    showAlert('Coming Soon', 'Notifications center is under development. Stay tuned!', 'info');
}

function generateReports() {
    showAlert('Coming Soon', 'Advanced reports feature is under development. Stay tuned!', 'info');
}

function viewSettings() {
    window.location.href = '{$base_url}Setup/interview_configuration';
}

$(document).ready(function() {
    renderCalendar(imsCurrentMonth, imsCurrentYear);
    $('#search-input').on('keyup', applyFilters);
    $('#status-filter, #position-filter').on('change', applyFilters);
    $('#date-from, #date-to').on('change', applyFilters);
});
JAVASCRIPT;

$data['custom_script'] = $custom_script;
$this->load->view('templates/admin_footer', $data);
?>
