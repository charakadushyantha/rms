# 🚀 Real-Time Collaborative Hiring Dashboard

A modern, interactive hiring pipeline dashboard with real-time updates, drag-and-drop functionality, and collaborative decision-making features.

## ✨ Features

### 1. Live Hiring Pipeline View
- **Visual Kanban-style board** with drag-and-drop
- **Real-time updates** every 5 seconds (configurable)
- **Color-coded stages** for easy identification
- **Candidate cards** with key information
- **Urgency indicators** (low, medium, high, critical)
- **Days in stage tracking**

### 2. Collaborative Decision Room
- **Virtual voting system** for hiring committees
- **Anonymous feedback option**
- **Real-time vote counting**
- **Consensus tracking**
- **Comment system** for detailed feedback

### 3. Interview Panel Coordination
- **Interviewer availability matrix**
- **Automatic conflict detection**
- **Smart panel composition**
- **Workload balancing**
- **Interview scheduling**

### 4. Real-Time Analytics
- **Live metrics** updating without refresh
- **Pipeline bottleneck identification**
- **Predictive timeline** (rule-based)
- **Team performance indicators**
- **Activity feed** with recent actions

---

## 📦 Installation

### Step 1: Create Database Tables

Run the SQL schema:

```bash
mysql -u root -p rmsdb < Database/realtime_dashboard_schema.sql
```

Or import via phpMyAdmin.

### Step 2: Add Route

Add to `application/config/routes.php`:

```php
$route['dashboard/realtime'] = 'realtime_dashboard/index';
```

### Step 3: Access Dashboard

Visit:
```
http://localhost/rms/realtime_dashboard
```

---

## 🎯 Usage

### For Recruiters

1. **View Pipeline**: See all candidates across different stages
2. **Move Candidates**: Drag and drop cards between stages
3. **Add Notes**: Add context when moving candidates
4. **Vote on Candidates**: Participate in hiring decisions
5. **Schedule Interviews**: Coordinate with interviewers

### For Hiring Managers

1. **Monitor Progress**: Track candidates in real-time
2. **Identify Bottlenecks**: See where candidates are stuck
3. **Review Metrics**: Check pipeline health
4. **Make Decisions**: Vote on candidate progression

### For Admins

1. **Full Access**: All features available
2. **Configure Stages**: Customize pipeline stages
3. **Manage Users**: Assign interviewers
4. **View Analytics**: Comprehensive metrics

---

## 🎨 Features in Detail

### Drag-and-Drop Pipeline

```javascript
// Candidates can be dragged between stages
// Automatically updates database
// Shows confirmation and notes dialog
// Real-time sync across all users
```

**How it works:**
1. Click and hold a candidate card
2. Drag to desired stage
3. Drop to move
4. Add optional notes
5. All users see the update within 5 seconds

### Urgency Levels

- **Low** (Green): No rush
- **Medium** (Yellow): Normal priority
- **High** (Orange): Needs attention
- **Critical** (Red, pulsing): Urgent action required

### Voting System

**Start a vote:**
```javascript
dashboard.startVoting(candidateId);
```

**Vote options:**
- ✅ Yes - Move forward
- ❌ No - Reject
- ➖ Abstain - No opinion

**Anonymous voting:**
- Check "Submit anonymously"
- Your name won't be shown
- Vote still counts

### Real-Time Updates

The dashboard automatically refreshes every 5 seconds:
- Pipeline data
- Metrics
- Activity feed
- Vote counts

**Customize update interval:**
```javascript
const dashboardConfig = {
    updateInterval: 3000  // 3 seconds
};
```

---

## 📊 Metrics Explained

### Total Candidates
Number of candidates currently in pipeline

### Avg Days in Pipeline
Average time from application to current stage

### Urgent Count
Candidates marked as high or critical priority

### Today's Interviews
Scheduled interviews for today

---

## 🔧 Configuration

### Pipeline Stages

Edit stages in database:
```sql
UPDATE pipeline_stages 
SET color = '#your-color', 
    order_position = 1 
WHERE id = 1;
```

### Update Interval

In view file:
```javascript
const dashboardConfig = {
    updateInterval: 5000  // milliseconds
};
```

### Colors

Edit `Assets/css/realtime-dashboard.css`:
```css
.metric-card {
    background: linear-gradient(135deg, #your-color1 0%, #your-color2 100%);
}
```

---

## 🎭 Customization Examples

### Add Custom Stage

```sql
INSERT INTO pipeline_stages (name, order_position, color, description) 
VALUES ('Background Check', 6, '#9c27b0', 'Verification in progress');
```

### Change Urgency Colors

```css
.urgency-badge.urgency-high {
    background: #your-color;
}
```

### Add Custom Metrics

In `Realtime_model.php`:
```php
public function get_dashboard_metrics() {
    // Add your custom metric
    $metrics['custom_metric'] = $this->db->query('YOUR QUERY')->result();
    return $metrics;
}
```

---

## 🚀 Advanced Features

### Bottleneck Detection

Automatically identifies:
- Stages with too many candidates (>10)
- Candidates stuck >7 days
- Overloaded interviewers

### Predictive Timeline

Rule-based predictions:
- Average time per stage
- Expected completion date
- Delay warnings

### Activity Logging

All actions are logged:
- Stage changes
- Votes submitted
- Interviews scheduled
- Notes added

---

## 📱 Mobile Responsive

The dashboard is fully responsive:
- Works on tablets
- Mobile-friendly cards
- Touch-enabled drag-and-drop
- Optimized layouts

---

## 🔐 Security

- **Authentication required**: Must be logged in
- **Role-based access**: Different views for roles
- **Anonymous voting**: Optional privacy
- **Activity logging**: Full audit trail

---

## 🐛 Troubleshooting

### Dashboard not updating?

Check browser console for errors:
```javascript
// Press F12, check Console tab
```

### Drag-and-drop not working?

Ensure JavaScript is enabled and browser supports HTML5 drag API.

### Metrics not showing?

Run the SQL schema to create tables:
```bash
mysql -u root -p rmsdb < Database/realtime_dashboard_schema.sql
```

### Slow performance?

Increase update interval:
```javascript
updateInterval: 10000  // 10 seconds instead of 5
```

---

## 🎯 Best Practices

1. **Keep stages organized**: 5-8 stages is optimal
2. **Set urgency levels**: Help prioritize work
3. **Add notes**: Context helps team decisions
4. **Use voting**: Collaborative decisions are better
5. **Monitor bottlenecks**: Act on stuck candidates
6. **Regular reviews**: Check metrics weekly

---

## 🔄 Future Enhancements

Potential additions:
- WebSocket support for instant updates
- Email notifications on stage changes
- Slack/Teams integration
- Advanced analytics dashboard
- AI-powered recommendations
- Bulk operations
- Export to Excel/PDF
- Custom workflows

---

## 📞 Support

For issues:
1. Check browser console (F12)
2. Review `application/logs/`
3. Verify database tables exist
4. Check user permissions

---

## 🎉 You're Ready!

The Real-Time Collaborative Hiring Dashboard is now set up and ready to use!

**Quick Start:**
1. Import SQL schema
2. Visit `/realtime_dashboard`
3. Start dragging candidates!

**Happy Hiring! 🚀**
