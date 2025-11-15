<!DOCTYPE html>
<html>
<head>
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f7fa; padding: 20px; }
        .container { max-width: 1400px; margin: 0 auto; }
        .header { background: white; padding: 25px; border-radius: 10px; margin-bottom: 25px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; margin-bottom: 10px; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 25px; }
        .stat-card { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center; }
        .stat-card .value { font-size: 32px; font-weight: 600; color: #2c3e50; margin-bottom: 5px; }
        .stat-card .label { color: #7f8c8d; font-size: 14px; }
        .events-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 20px; }
        .event-card { background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .event-card h3 { color: #2c3e50; margin-bottom: 10px; }
        .event-type { display: inline-block; padding: 4px 10px; background: #3498db; color: white; border-radius: 4px; font-size: 12px; margin-bottom: 10px; }
        .event-meta { color: #7f8c8d; font-size: 13px; margin: 10px 0; }
        .event-meta i { margin-right: 5px; }
        .status-badge { padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .status-badge.upcoming { background: #d4edda; color: #155724; }
        .btn { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-primary { background: #3498db; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-calendar-alt"></i> Recruitment Events</h1>
            <p>Manage job fairs, career days, and recruitment events</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="value"><?php echo $stats['total_events']; ?></div>
                <div class="label">Total Events</div>
            </div>
            <div class="stat-card">
                <div class="value"><?php echo $stats['upcoming_events']; ?></div>
                <div class="label">Upcoming Events</div>
            </div>
            <div class="stat-card">
                <div class="value"><?php echo number_format($stats['total_registrations']); ?></div>
                <div class="label">Total Registrations</div>
            </div>
            <div class="stat-card">
                <div class="value">$<?php echo number_format($stats['total_budget'], 0); ?></div>
                <div class="label">Total Budget</div>
            </div>
        </div>

        <div class="events-grid">
            <?php foreach($events as $event): ?>
                <div class="event-card">
                    <span class="event-type"><?php echo $event['event_type']; ?></span>
                    <h3><?php echo htmlspecialchars($event['event_name']); ?></h3>
                    <div class="event-meta">
                        <div><i class="fas fa-calendar"></i> <?php echo date('M d, Y', strtotime($event['event_date'])); ?></div>
                        <div><i class="fas fa-clock"></i> <?php echo date('g:i A', strtotime($event['start_time'])); ?> - <?php echo date('g:i A', strtotime($event['end_time'])); ?></div>
                        <div><i class="fas fa-map-marker-alt"></i> <?php echo $event['venue_type'] == 'Virtual' ? 'Virtual Event' : htmlspecialchars($event['location']); ?></div>
                        <div><i class="fas fa-users"></i> <?php echo $event['registered_count']; ?> / <?php echo $event['max_attendees']; ?> registered</div>
                    </div>
                    <span class="status-badge upcoming"><?php echo $event['status']; ?></span>
                </div>
            <?php endforeach; ?>
        </div>

        <div style="margin-top: 20px; text-align: center;">
            <a href="<?php echo base_url('Sales_marketing'); ?>" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Back to Hub
            </a>
        </div>
    </div>
</body>
</html>
