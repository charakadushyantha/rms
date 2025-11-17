    </div> <!-- End main-content -->

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <!-- FullCalendar (if needed) -->
    <?php if (isset($use_calendar) && $use_calendar): ?>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    <?php endif; ?>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Custom Scripts -->
    <script>
        function toggleUserDropdown() {
            event.stopPropagation();
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userDropdown');
            if (dropdown && dropdown.classList.contains('show')) {
                dropdown.classList.remove('show');
            }
        });
    </script>
    
    <?php if (isset($custom_script)): ?>
    <script>
        <?php echo $custom_script; ?>
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
