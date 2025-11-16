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
    
    <!-- Pipeline Functions -->
    <script src="<?= base_url('Assets/js/pipeline-functions.js') ?>"></script>
    
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
        // Sidebar Toggle - with null check
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            
            if (sidebar && mainContent) {
                if (window.innerWidth <= 768) {
                    sidebar.classList.toggle('mobile-show');
                } else {
                    sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('expanded');
                }
            }
        }
        
        // Attach to toggle button if it exists
        const sidebarToggle = document.getElementById('sidebarToggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', toggleSidebar);
        }

        // Close sidebar on mobile when clicking outside
        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 768) {
                const sidebar = document.getElementById('sidebar');
                const sidebarToggle = document.getElementById('sidebarToggle');
                
                if (sidebar && sidebarToggle && !sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
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

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // SweetAlert2 Toast Configuration - wait for Swal to load
        if (typeof Swal !== 'undefined') {
            window.Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                },
                customClass: {
                    popup: 'colored-toast'
                }
            });
        } else {
            console.error('SweetAlert2 not loaded!');
        }
    </script>
    
    <style>
        /* Toast custom styles */
        .colored-toast.swal2-icon-success {
            background-color: #d1fae5 !important;
            color: #065f46 !important;
        }
        
        .colored-toast.swal2-icon-error {
            background-color: #fee2e2 !important;
            color: #991b1b !important;
        }
        
        .colored-toast.swal2-icon-warning {
            background-color: #fef3c7 !important;
            color: #92400e !important;
        }
        
        .colored-toast.swal2-icon-info {
            background-color: #dbeafe !important;
            color: #1e40af !important;
        }
        
        .colored-toast .swal2-title {
            color: inherit !important;
            font-size: 1rem !important;
        }
        
        .colored-toast .swal2-icon {
            border-color: currentColor !important;
        }
    </style>
    
    <?php if(isset($custom_script)): ?>
    <script>
        <?= $custom_script ?>
    </script>
    <?php endif; ?>
    
    <!-- AI Chatbot Widget -->
    <script>
        $(document).ready(function() {
            $.get('<?= base_url('bot/widget') ?>', function(data) {
                $('body').append(data);
            }).fail(function() {
                console.log('Chatbot widget failed to load');
            });
        });
    </script>
</body>
</html>
