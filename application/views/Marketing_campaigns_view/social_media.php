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
        .container { max-width: 1400px; margin: 0 auto; padding: 20px; }
        
        .header { background: white; padding: 25px; border-radius: 10px; margin-bottom: 25px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; margin-bottom: 10px; }
        .header p { color: #7f8c8d; }
        
        .content-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; }
        .card { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .card h3 { color: #2c3e50; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #3498db; }
        
        .btn { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; text-decoration: none; display: inline-block; }
        .btn-primary { background: #3498db; color: white; }
        .btn-success { background: #27ae60; color: white; }
        
        .platform-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 20px; }
        .platform-card { padding: 20px; border-radius: 8px; text-align: center; cursor: pointer; transition: transform 0.2s; }
        .platform-card:hover { transform: translateY(-3px); }
        .platform-card.linkedin { background: #0077b5; color: white; }
        .platform-card.facebook { background: #1877f2; color: white; }
        .platform-card.twitter { background: #1da1f2; color: white; }
        .platform-card.instagram { background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); color: white; }
        .platform-card i { font-size: 32px; margin-bottom: 10px; }
        .platform-card h4 { margin-bottom: 5px; }
        .platform-card p { font-size: 12px; opacity: 0.9; }
        
        .post-composer { background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        .post-composer textarea { width: 100%; padding: 15px; border: 1px solid #ddd; border-radius: 5px; min-height: 120px; font-family: inherit; resize: vertical; }
        .post-composer .actions { display: flex; justify-content: space-between; align-items: center; margin-top: 15px; }
        .post-composer .tools { display: flex; gap: 10px; }
        .post-composer .tools button { background: white; border: 1px solid #ddd; padding: 8px 12px; border-radius: 5px; cursor: pointer; }
        .post-composer .tools button:hover { background: #f8f9fa; }
        
        .calendar-view { background: white; padding: 20px; border-radius: 8px; }
        .calendar-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .calendar-header h4 { color: #2c3e50; }
        .calendar-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 10px; }
        .calendar-day { aspect-ratio: 1; background: #f8f9fa; border-radius: 5px; padding: 10px; font-size: 12px; }
        .calendar-day.has-post { background: #d4edda; border: 2px solid #27ae60; }
        .calendar-day .date { font-weight: 600; color: #2c3e50; }
        .calendar-day .posts { color: #7f8c8d; margin-top: 5px; }
        
        .stats-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; }
        .stat-box { background: #f8f9fa; padding: 20px; border-radius: 8px; text-align: center; }
        .stat-box .value { font-size: 28px; font-weight: 600; color: #2c3e50; margin-bottom: 5px; }
        .stat-box .label { color: #7f8c8d; font-size: 13px; }
        
        .quick-actions { display: flex; flex-direction: column; gap: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-share-alt"></i> Social Media Marketing</h1>
            <p>Manage and schedule social media posts across multiple platforms</p>
        </div>

        <div class="content-grid">
            <div>
                <div class="card">
                    <h3><i class="fas fa-edit"></i> Create Post</h3>
                    <div class="post-composer">
                        <textarea placeholder="What would you like to share with candidates?"></textarea>
                        <div class="actions">
                            <div class="tools">
                                <button title="Add Image"><i class="fas fa-image"></i></button>
                                <button title="Add Video"><i class="fas fa-video"></i></button>
                                <button title="Add Link"><i class="fas fa-link"></i></button>
                                <button title="Add Emoji"><i class="fas fa-smile"></i></button>
                                <button title="Schedule"><i class="fas fa-clock"></i></button>
                            </div>
                            <button class="btn btn-success" onclick="alert('Post scheduling coming soon!')">
                                <i class="fas fa-paper-plane"></i> Post Now
                            </button>
                        </div>
                    </div>
                    
                    <div class="platform-grid">
                        <div class="platform-card linkedin" onclick="alert('LinkedIn integration coming soon!')">
                            <i class="fab fa-linkedin"></i>
                            <h4>LinkedIn</h4>
                            <p>Professional network</p>
                        </div>
                        <div class="platform-card facebook" onclick="alert('Facebook integration coming soon!')">
                            <i class="fab fa-facebook"></i>
                            <h4>Facebook</h4>
                            <p>Social network</p>
                        </div>
                        <div class="platform-card twitter" onclick="alert('Twitter integration coming soon!')">
                            <i class="fab fa-twitter"></i>
                            <h4>Twitter</h4>
                            <p>Microblogging</p>
                        </div>
                        <div class="platform-card instagram" onclick="alert('Instagram integration coming soon!')">
                            <i class="fab fa-instagram"></i>
                            <h4>Instagram</h4>
                            <p>Photo sharing</p>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <h3><i class="fas fa-calendar-alt"></i> Content Calendar</h3>
                    <div class="calendar-view">
                        <div class="calendar-header">
                            <button class="btn btn-primary" style="padding: 8px 15px;">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <h4>November 2024</h4>
                            <button class="btn btn-primary" style="padding: 8px 15px;">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                        <div class="calendar-grid">
                            <?php for($i = 1; $i <= 30; $i++): ?>
                                <div class="calendar-day <?php echo ($i % 5 == 0) ? 'has-post' : ''; ?>">
                                    <div class="date"><?php echo $i; ?></div>
                                    <?php if($i % 5 == 0): ?>
                                        <div class="posts">2 posts</div>
                                    <?php endif; ?>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div class="card">
                    <h3><i class="fas fa-chart-line"></i> Performance</h3>
                    <div class="stats-grid">
                        <div class="stat-box">
                            <div class="value">12.5K</div>
                            <div class="label">Total Reach</div>
                        </div>
                        <div class="stat-box">
                            <div class="value">1,234</div>
                            <div class="label">Engagements</div>
                        </div>
                        <div class="stat-box">
                            <div class="value">456</div>
                            <div class="label">Clicks</div>
                        </div>
                        <div class="stat-box">
                            <div class="value">89</div>
                            <div class="label">Applications</div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <h3><i class="fas fa-bolt"></i> Quick Actions</h3>
                    <div class="quick-actions">
                        <button class="btn btn-primary" style="width: 100%;" onclick="alert('Coming soon!')">
                            <i class="fas fa-hashtag"></i> Trending Hashtags
                        </button>
                        <button class="btn btn-primary" style="width: 100%;" onclick="alert('Coming soon!')">
                            <i class="fas fa-images"></i> Media Library
                        </button>
                        <button class="btn btn-primary" style="width: 100%;" onclick="alert('Coming soon!')">
                            <i class="fas fa-chart-bar"></i> Analytics Report
                        </button>
                        <button class="btn btn-primary" style="width: 100%;" onclick="alert('Coming soon!')">
                            <i class="fas fa-cog"></i> Platform Settings
                        </button>
                        <a href="<?php echo base_url('Marketing_campaigns'); ?>" class="btn btn-primary" style="width: 100%; text-align: center;">
                            <i class="fas fa-arrow-left"></i> Back to Campaigns
                        </a>
                    </div>
                </div>

                <div class="card">
                    <h3><i class="fas fa-lightbulb"></i> Tips</h3>
                    <ul style="color: #7f8c8d; font-size: 14px; line-height: 1.8; padding-left: 20px;">
                        <li>Post during peak hours (9-11 AM, 1-3 PM)</li>
                        <li>Use relevant hashtags (#hiring, #jobs)</li>
                        <li>Include engaging visuals</li>
                        <li>Respond to comments promptly</li>
                        <li>Share employee testimonials</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
