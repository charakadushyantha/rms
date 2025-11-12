        </div>
        <!-- End Content Area -->

        <!-- Footer -->
        <div class="footer">
            <p>&copy; <?= date('Y') ?> Recruitment Management System. All rights reserved.</p>
        </div>
    </div>
    <!-- End Main Content -->

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- DataTables JS (if needed) -->
    <?php if(isset($use_datatable) && $use_datatable): ?>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <?php endif; ?>
    
    <!-- FullCalendar JS (if needed) -->
    <?php if(isset($use_calendar) && $use_calendar): ?>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    <?php endif; ?>
    
    <!-- Custom Page JS -->
    <?php if(isset($page_specific_js)): ?>
        <?php foreach($page_specific_js as $js): ?>
            <script src="<?= base_url($js) ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
    
    <!-- Main Script -->
    <script>
        // Sidebar Toggle
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('mobile-show');
            } else {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
            }
        });

        // Close sidebar on mobile when clicking outside
        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 768) {
                const sidebar = document.getElementById('sidebar');
                const sidebarToggle = document.getElementById('sidebarToggle');
                
                if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
                    sidebar.classList.remove('mobile-show');
                }
            }
        });

        // Initialize DataTables if present
        <?php if(isset($use_datatable) && $use_datatable): ?>
        $(document).ready(function() {
            if ($.fn.DataTable) {
                $('.data-table').DataTable({
                    responsive: true,
                    pageLength: 10,
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Search records..."
                    }
                });
            }
        });
        <?php endif; ?>

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href !== '#' && href.length > 1) {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }
            });
        });

        // Global Search Functionality
        const globalSearch = document.getElementById('globalSearch');
        const searchResults = document.getElementById('searchResults');
        let searchTimeout;

        if (globalSearch) {
            globalSearch.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const query = this.value.trim();
                
                if (query.length < 2) {
                    searchResults.classList.remove('show');
                    return;
                }
                
                searchTimeout = setTimeout(() => {
                    performSearch(query);
                }, 300);
            });

            globalSearch.addEventListener('focus', function() {
                if (this.value.trim().length >= 2) {
                    searchResults.classList.add('show');
                }
            });

            // Close search results when clicking outside
            document.addEventListener('click', function(e) {
                if (!globalSearch.contains(e.target) && !searchResults.contains(e.target)) {
                    searchResults.classList.remove('show');
                }
            });
        }

        function performSearch(query) {
            // Show loading
            searchResults.innerHTML = '<div class="text-center py-3"><i class="fas fa-spinner fa-spin"></i> Searching...</div>';
            searchResults.classList.add('show');

            // AJAX search request
            $.ajax({
                url: '<?= base_url("A_dashboard/global_search") ?>',
                method: 'POST',
                data: { query: query },
                dataType: 'json',
                success: function(response) {
                    displaySearchResults(response);
                },
                error: function() {
                    searchResults.innerHTML = '<div class="search-no-results"><i class="fas fa-exclamation-triangle"></i><p>Search failed. Please try again.</p></div>';
                }
            });
        }

        function displaySearchResults(data) {
            let html = '';
            let hasResults = false;

            // Candidates
            if (data.candidates && data.candidates.length > 0) {
                hasResults = true;
                html += '<div class="search-category">Candidates</div>';
                data.candidates.forEach(item => {
                    html += `
                        <a href="<?= base_url("A_dashboard/Acandidate_users_view") ?>" class="search-item">
                            <div class="search-item-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="search-item-content">
                                <div class="search-item-title">${item.name}</div>
                                <div class="search-item-subtitle">${item.email} • ${item.phone}</div>
                            </div>
                        </a>
                    `;
                });
            }

            // Jobs
            if (data.jobs && data.jobs.length > 0) {
                hasResults = true;
                html += '<div class="search-category">Jobs</div>';
                data.jobs.forEach(item => {
                    html += `
                        <a href="<?= base_url("A_dashboard/Ajob_post_view") ?>" class="search-item">
                            <div class="search-item-icon" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <div class="search-item-content">
                                <div class="search-item-title">${item.title}</div>
                                <div class="search-item-subtitle">${item.location} • ${item.type}</div>
                            </div>
                        </a>
                    `;
                });
            }

            // Interviews
            if (data.interviews && data.interviews.length > 0) {
                hasResults = true;
                html += '<div class="search-category">Interviews</div>';
                data.interviews.forEach(item => {
                    html += `
                        <a href="<?= base_url("A_dashboard/Ainterviewer_view") ?>" class="search-item">
                            <div class="search-item-icon" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="search-item-content">
                                <div class="search-item-title">${item.candidate}</div>
                                <div class="search-item-subtitle">${item.date} • ${item.time}</div>
                            </div>
                        </a>
                    `;
                });
            }

            if (!hasResults) {
                html = '<div class="search-no-results"><i class="fas fa-search"></i><p>No results found</p></div>';
            }

            searchResults.innerHTML = html;
        }

        // Notification System
        const notificationIcon = document.getElementById('notificationIcon');
        const notificationDropdown = document.getElementById('notificationDropdown');
        const notificationList = document.getElementById('notificationList');
        const notificationCount = document.getElementById('notificationCount');

        if (notificationIcon) {
            notificationIcon.addEventListener('click', function(e) {
                e.stopPropagation();
                notificationDropdown.classList.toggle('show');
                if (notificationDropdown.classList.contains('show')) {
                    loadNotifications();
                }
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!notificationIcon.contains(e.target) && !notificationDropdown.contains(e.target)) {
                    notificationDropdown.classList.remove('show');
                }
            });
        }

        function loadNotifications() {
            $.ajax({
                url: '<?= base_url("A_dashboard/get_notifications") ?>',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    displayNotifications(response);
                },
                error: function() {
                    notificationList.innerHTML = '<div class="text-center py-4 text-muted"><i class="fas fa-exclamation-triangle fa-2x mb-2"></i><p>Failed to load notifications</p></div>';
                }
            });
        }

        function displayNotifications(notifications) {
            if (!notifications || notifications.length === 0) {
                notificationList.innerHTML = '<div class="text-center py-4 text-muted"><i class="fas fa-bell-slash fa-2x mb-2"></i><p>No new notifications</p></div>';
                notificationCount.textContent = '0';
                notificationCount.style.display = 'none';
                return;
            }

            let html = '';
            let unreadCount = 0;

            notifications.forEach(notif => {
                const isUnread = notif.is_read == 0;
                if (isUnread) unreadCount++;

                const iconColors = {
                    'candidate': 'linear-gradient(135deg, #667eea, #764ba2)',
                    'interview': 'linear-gradient(135deg, #4facfe, #00f2fe)',
                    'job': 'linear-gradient(135deg, #f093fb, #f5576c)',
                    'system': 'linear-gradient(135deg, #fa709a, #fee140)'
                };

                const icons = {
                    'candidate': 'fa-user',
                    'interview': 'fa-calendar-check',
                    'job': 'fa-briefcase',
                    'system': 'fa-bell'
                };

                html += `
                    <div class="notification-item ${isUnread ? 'unread' : ''}" onclick="markAsRead(${notif.id}, '${notif.link}')">
                        <div class="notification-icon-wrapper" style="background: ${iconColors[notif.type] || iconColors.system};">
                            <i class="fas ${icons[notif.type] || icons.system}"></i>
                        </div>
                        <div class="notification-content">
                            <div class="notification-title">${notif.title}</div>
                            <div class="notification-message">${notif.message}</div>
                            <div class="notification-time">${notif.time_ago}</div>
                        </div>
                    </div>
                `;
            });

            notificationList.innerHTML = html;
            notificationCount.textContent = unreadCount;
            notificationCount.style.display = unreadCount > 0 ? 'block' : 'none';
        }

        function markAsRead(notificationId, link) {
            $.ajax({
                url: '<?= base_url("A_dashboard/mark_notification_read") ?>',
                method: 'POST',
                data: { id: notificationId },
                success: function() {
                    if (link) {
                        window.location.href = link;
                    } else {
                        loadNotifications();
                    }
                }
            });
        }

        function markAllAsRead() {
            $.ajax({
                url: '<?= base_url("A_dashboard/mark_all_notifications_read") ?>',
                method: 'POST',
                success: function() {
                    loadNotifications();
                }
            });
        }

        // Load notifications on page load
        $(document).ready(function() {
            loadNotifications();
            
            // Refresh notifications every 30 seconds
            setInterval(loadNotifications, 30000);
        });

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    </script>
    
    <?php if(isset($custom_script)): ?>
    <script>
        <?= $custom_script ?>
    </script>
    <?php endif; ?>
</body>
</html>
