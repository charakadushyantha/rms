</div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Recruitment System <?= date('Y') ?></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <?php if(isset($page_specific_js)): ?>
        <?php foreach($page_specific_js as $js): ?>
            <script src="<?= base_url($js) ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
    
    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/modern/js/main.js') ?>"></script>
    
    <script>
        // Toggle sidebar
        document.getElementById('sidebarToggleTop').addEventListener('click', function() {
            document.getElementById('sidebar-wrapper').classList.toggle('collapsed');
            document.getElementById('content-wrapper').classList.toggle('expanded');
        });
        
        // Add scrolling animation to links with #
        document.querySelectorAll('a.scroll-to-top, a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                
                // Only apply to internal links that start with #
                if (href.startsWith('#') && href.length > 1) {
                    e.preventDefault();
                    
                    const targetId = this.getAttribute('href');
                    const targetElement = document.querySelector(targetId);
                    
                    if (targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 70,
                            behavior: 'smooth'
                        });
                    }
                }
            });
        });
        
        // Scroll to top button
        window.addEventListener('scroll', function() {
            const scrollToTopButton = document.querySelector('.scroll-to-top');
            if (window.pageYOffset > 100) {
                scrollToTopButton.style.display = 'block';
            } else {
                scrollToTopButton.style.display = 'none';
            }
        });
        
        // Theme toggle (example function, not yet implemented)
        function toggleTheme() {
            const body = document.body;
            if (body.classList.contains('dark-mode')) {
                body.classList.remove('dark-mode');
                localStorage.setItem('theme', 'light');
                document.getElementById('theme-stylesheet').href = '<?= base_url('assets/modern/css/themes/light.css') ?>';
            } else {
                body.classList.add('dark-mode');
                localStorage.setItem('theme', 'dark');
                document.getElementById('theme-stylesheet').href = '<?= base_url('assets/modern/css/themes/dark.css') ?>';
            }
        }
        
        // Check for saved theme preference
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                document.body.classList.add('dark-mode');
                document.getElementById('theme-stylesheet').href = '<?= base_url('assets/modern/css/themes/dark.css') ?>';
            }
            
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Initialize popovers
            const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
            popoverTriggerList.map(function (popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl);
            });
        });
    </script>
    
    <?php if(isset($custom_script)): ?>
    <script>
        <?= $custom_script ?>
    </script>
    <?php endif; ?>
</body>
</html>