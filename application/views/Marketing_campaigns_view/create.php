<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f7fa; }
        .container { max-width: 1000px; margin: 0 auto; padding: 20px; }
        .header { background: white; padding: 25px; border-radius: 10px; margin-bottom: 25px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; margin-bottom: 10px; }
        .header p { color: #7f8c8d; }
        
        .form-card { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .form-section { margin-bottom: 30px; }
        .form-section h3 { color: #2c3e50; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #3498db; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; color: #2c3e50; font-weight: 500; }
        .form-group label .required { color: #e74c3c; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; font-family: inherit; }
        .form-group textarea { min-height: 100px; resize: vertical; }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { outline: none; border-color: #3498db; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        
        .btn { padding: 12px 24px; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; text-decoration: none; display: inline-block; }
        .btn-primary { background: #3498db; color: white; }
        .btn-primary:hover { background: #2980b9; }
        .btn-success { background: #27ae60; color: white; }
        .btn-success:hover { background: #229954; }
        .btn-secondary { background: #95a5a6; color: white; }
        .btn-secondary:hover { background: #7f8c8d; }
        
        .form-actions { display: flex; gap: 10px; justify-content: flex-end; margin-top: 30px; padding-top: 20px; border-top: 1px solid #ecf0f1; }
        .help-text { font-size: 12px; color: #7f8c8d; margin-top: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-plus-circle"></i> Create Marketing Campaign</h1>
            <p>Set up a new recruitment marketing campaign</p>
        </div>

        <form action="<?php echo base_url('Marketing_campaigns/save'); ?>" method="POST" class="form-card">
            <div class="form-section">
                <h3><i class="fas fa-info-circle"></i> Campaign Information</h3>
                
                <div class="form-group">
                    <label>Campaign Name <span class="required">*</span></label>
                    <input type="text" name="campaign_name" required placeholder="e.g., Summer 2024 Tech Talent Drive">
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Campaign Type <span class="required">*</span></label>
                        <select name="campaign_type" required>
                            <option value="">Select Type</option>
                            <option value="Email">Email Campaign</option>
                            <option value="Social Media">Social Media</option>
                            <option value="Paid Ads">Paid Advertising</option>
                            <option value="Multi-Channel">Multi-Channel</option>
                            <option value="Content Marketing">Content Marketing</option>
                            <option value="Event Marketing">Event Marketing</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Budget <span class="required">*</span></label>
                        <input type="number" name="budget" step="0.01" required placeholder="0.00">
                        <div class="help-text">Total campaign budget in USD</div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" placeholder="Describe the campaign objectives and strategy..."></textarea>
                </div>
            </div>

            <div class="form-section">
                <h3><i class="fas fa-calendar"></i> Schedule</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Start Date <span class="required">*</span></label>
                        <input type="date" name="start_date" required>
                    </div>
                    
                    <div class="form-group">
                        <label>End Date <span class="required">*</span></label>
                        <input type="date" name="end_date" required>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3><i class="fas fa-users"></i> Target Audience</h3>
                
                <div class="form-group">
                    <label>Target Audience</label>
                    <textarea name="target_audience" placeholder="Define your target audience (e.g., Software Engineers with 3-5 years experience in AI/ML)"></textarea>
                    <div class="help-text">Describe the ideal candidate profile for this campaign</div>
                </div>
                
                <div class="form-group">
                    <label>Campaign Goals</label>
                    <textarea name="goals" placeholder="List your campaign goals (e.g., Generate 100 qualified applications, Increase brand awareness by 30%)"></textarea>
                    <div class="help-text">Define measurable objectives for this campaign</div>
                </div>
            </div>

            <div class="form-actions">
                <a href="<?php echo base_url('Marketing_campaigns'); ?>" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Create Campaign
                </button>
            </div>
        </form>
    </div>

    <script>
        // Set minimum date to today
        const today = new Date().toISOString().split('T')[0];
        document.querySelector('input[name="start_date"]').setAttribute('min', today);
        
        // Update end date minimum when start date changes
        document.querySelector('input[name="start_date"]').addEventListener('change', function() {
            document.querySelector('input[name="end_date"]').setAttribute('min', this.value);
        });
    </script>
</body>
</html>
