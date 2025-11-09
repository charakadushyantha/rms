<?php
$this->load->view('templates/admin_header', array('page_title' => 'System Setup'));
?>

<div class="row g-4">
    <div class="col-12">
        <div class="data-card">
            <div class="data-card-header">
                <h3 class="data-card-title">
                    <i class="fas fa-cog me-2"></i>System Setup
                </h3>
            </div>
            <p class="p-3">Configure and manage system settings, job categories, positions, and sample data.</p>
        </div>
    </div>

    <!-- Job Categories Setup -->
    <div class="col-md-6 col-lg-4">
        <a href="<?= base_url('Setup/job_categories') ?>" style="text-decoration: none;">
            <div class="data-card" style="cursor: pointer; transition: transform 0.2s;">
                <div class="p-4 text-center">
                    <div style="width: 80px; height: 80px; margin: 0 auto 20px; border-radius: 50%; background: linear-gradient(135deg, #667eea, #764ba2); display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-folder-open" style="font-size: 36px; color: white;"></i>
                    </div>
                    <h4 style="font-weight: 600; color: var(--dark-color); margin-bottom: 10px;">Job Categories</h4>
                    <p style="color: #999; font-size: 14px; margin: 0;">Manage job categories and classifications</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Job Positions Setup -->
    <div class="col-md-6 col-lg-4">
        <a href="<?= base_url('Setup/job_positions') ?>" style="text-decoration: none;">
            <div class="data-card" style="cursor: pointer; transition: transform 0.2s;">
                <div class="p-4 text-center">
                    <div style="width: 80px; height: 80px; margin: 0 auto 20px; border-radius: 50%; background: linear-gradient(135deg, #1cc88a, #13855c); display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-briefcase" style="font-size: 36px; color: white;"></i>
                    </div>
                    <h4 style="font-weight: 600; color: var(--dark-color); margin-bottom: 10px;">Job Positions</h4>
                    <p style="color: #999; font-size: 14px; margin: 0;">Define available job positions</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Sample Data Setup -->
    <div class="col-md-6 col-lg-4">
        <a href="<?= base_url('Setup/sample_data') ?>" style="text-decoration: none;">
            <div class="data-card" style="cursor: pointer; transition: transform 0.2s;">
                <div class="p-4 text-center">
                    <div style="width: 80px; height: 80px; margin: 0 auto 20px; border-radius: 50%; background: linear-gradient(135deg, #36b9cc, #258391); display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-database" style="font-size: 36px; color: white;"></i>
                    </div>
                    <h4 style="font-weight: 600; color: var(--dark-color); margin-bottom: 10px;">Sample Data</h4>
                    <p style="color: #999; font-size: 14px; margin: 0;">Generate and manage test data</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Database Setup -->
    <div class="col-md-6 col-lg-4">
        <a href="<?= base_url('Setup/database') ?>" style="text-decoration: none;">
            <div class="data-card" style="cursor: pointer; transition: transform 0.2s;">
                <div class="p-4 text-center">
                    <div style="width: 80px; height: 80px; margin: 0 auto 20px; border-radius: 50%; background: linear-gradient(135deg, #f6c23e, #dda20a); display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-server" style="font-size: 36px; color: white;"></i>
                    </div>
                    <h4 style="font-weight: 600; color: var(--dark-color); margin-bottom: 10px;">Database</h4>
                    <p style="color: #999; font-size: 14px; margin: 0;">View database tables and statistics</p>
                </div>
            </div>
        </a>
    </div>
</div>

<style>
.data-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}
</style>

<?php
$this->load->view('templates/admin_footer');
?>
