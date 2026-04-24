# Dynamic Time-Based Greeting Implementation

## Overview
This implementation adds a dynamic, time-based greeting message that changes throughout the day based on the current time in a specified timezone.

## Features
- **Good Morning** (5:00 AM - 11:59 AM)
- **Good Afternoon** (12:00 PM - 5:59 PM)
- **Good Evening** (6:00 PM - 9:59 PM)
- **Good Night** (10:00 PM - 4:59 AM)

## Implementation Details

### 1. Controller Method (`A_dashboard.php`)

```php
/**
 * Get time-based greeting message
 * @param string $timezone - Timezone identifier (e.g., 'Asia/Kolkata', 'America/New_York')
 * @return string - Greeting message based on current time
 */
private function get_time_based_greeting($timezone = 'Asia/Kolkata')
{
  try {
    // Create DateTime object with specified timezone
    $date = new DateTime('now', new DateTimeZone($timezone));
    $hour = (int)$date->format('H'); // Get hour in 24-hour format
    
    // Determine greeting based on time of day
    if ($hour >= 5 && $hour < 12) {
      return 'Good Morning';
    } elseif ($hour >= 12 && $hour < 18) {
      return 'Good Afternoon';
    } elseif ($hour >= 18 && $hour < 22) {
      return 'Good Evening';
    } else {
      return 'Good Night';
    }
  } catch (Exception $e) {
    // Fallback to default greeting if timezone is invalid
    log_message('error', 'Timezone error: ' . $e->getMessage());
    return 'Welcome back';
  }
}
```

### 2. View Update (`Adashboard_new.php`)

```php
<h2><?= isset($greeting) ? $greeting : 'Welcome back' ?>, <?= $this->session->userdata('username') ?>! 👋</h2>
```

## Timezone Configuration

### Common Timezones

| Region | Timezone Identifier |
|--------|-------------------|
| India | `Asia/Kolkata` |
| USA (Eastern) | `America/New_York` |
| USA (Pacific) | `America/Los_Angeles` |
| UK | `Europe/London` |
| Australia (Sydney) | `Australia/Sydney` |
| Japan | `Asia/Tokyo` |
| Singapore | `Asia/Singapore` |
| UAE | `Asia/Dubai` |

### How to Change Timezone

In `A_dashboard.php`, modify the `index()` method:

```php
// For India
$data['greeting'] = $this->get_time_based_greeting('Asia/Kolkata');

// For USA Eastern Time
$data['greeting'] = $this->get_time_based_greeting('America/New_York');

// For UK
$data['greeting'] = $this->get_time_based_greeting('Europe/London');
```

### Using User-Specific Timezone

If you want each user to have their own timezone preference:

1. **Add timezone column to users table:**
```sql
ALTER TABLE users ADD COLUMN user_timezone VARCHAR(50) DEFAULT 'Asia/Kolkata';
```

2. **Update controller to use user timezone:**
```php
public function index()
{
  $data['uname'] = $this->session->userdata('username');
  
  // Get user's timezone from database
  $user_timezone = $this->db->select('user_timezone')
                            ->where('u_username', $data['uname'])
                            ->get('users')
                            ->row()->user_timezone;
  
  // Use user's timezone or default to Asia/Kolkata
  $timezone = $user_timezone ? $user_timezone : 'Asia/Kolkata';
  $data['greeting'] = $this->get_time_based_greeting($timezone);
  
  // ... rest of the code
}
```

## Customizing Time Ranges

You can customize when each greeting appears by modifying the conditions in `get_time_based_greeting()`:

```php
// Example: Different time ranges
if ($hour >= 6 && $hour < 12) {
  return 'Good Morning';        // 6 AM - 11:59 AM
} elseif ($hour >= 12 && $hour < 17) {
  return 'Good Afternoon';      // 12 PM - 4:59 PM
} elseif ($hour >= 17 && $hour < 21) {
  return 'Good Evening';        // 5 PM - 8:59 PM
} else {
  return 'Good Night';          // 9 PM - 5:59 AM
}
```

## Adding Greeting Icons

You can add time-specific icons to make the greeting more visual:

```php
private function get_time_based_greeting($timezone = 'Asia/Kolkata')
{
  try {
    $date = new DateTime('now', new DateTimeZone($timezone));
    $hour = (int)$date->format('H');
    
    if ($hour >= 5 && $hour < 12) {
      return 'Good Morning ☀️';
    } elseif ($hour >= 12 && $hour < 18) {
      return 'Good Afternoon 🌤️';
    } elseif ($hour >= 18 && $hour < 22) {
      return 'Good Evening 🌆';
    } else {
      return 'Good Night 🌙';
    }
  } catch (Exception $e) {
    log_message('error', 'Timezone error: ' . $e->getMessage());
    return 'Welcome back 👋';
  }
}
```

## Applying to Other Dashboards

### Interviewer Dashboard

1. **Update `A_dashboard.php` controller:**
```php
public function Ainterviewer_view()
{
  $data['uname'] = $this->session->userdata('username');
  $data['greeting'] = $this->get_time_based_greeting('Asia/Kolkata');
  
  // ... rest of the code
  $this->load->view('Admin_dashboard_view/Ainterviewer_view', $data);
}
```

2. **Update the view file** to use `$greeting` variable.

### Candidate Dashboard

If you have a candidate dashboard controller, add the same logic:

```php
public function index()
{
  $data['uname'] = $this->session->userdata('username');
  $data['greeting'] = $this->get_time_based_greeting('Asia/Kolkata');
  
  // ... rest of the code
  $this->load->view('Candidate_dashboard_view/dashboard', $data);
}
```

## Testing Different Times

To test how the greeting looks at different times, you can temporarily modify the method:

```php
// For testing only - remove in production
private function get_time_based_greeting($timezone = 'Asia/Kolkata', $test_hour = null)
{
  try {
    $date = new DateTime('now', new DateTimeZone($timezone));
    $hour = $test_hour !== null ? $test_hour : (int)$date->format('H');
    
    // ... rest of the code
  }
}

// Then in index():
$data['greeting'] = $this->get_time_based_greeting('Asia/Kolkata', 8);  // Test 8 AM
$data['greeting'] = $this->get_time_based_greeting('Asia/Kolkata', 14); // Test 2 PM
$data['greeting'] = $this->get_time_based_greeting('Asia/Kolkata', 20); // Test 8 PM
```

## Advanced: Multi-Language Support

For multi-language greetings:

```php
private function get_time_based_greeting($timezone = 'Asia/Kolkata', $language = 'en')
{
  try {
    $date = new DateTime('now', new DateTimeZone($timezone));
    $hour = (int)$date->format('H');
    
    $greetings = array(
      'en' => array(
        'morning' => 'Good Morning',
        'afternoon' => 'Good Afternoon',
        'evening' => 'Good Evening',
        'night' => 'Good Night'
      ),
      'hi' => array(
        'morning' => 'सुप्रभात',
        'afternoon' => 'शुभ दोपहर',
        'evening' => 'शुभ संध्या',
        'night' => 'शुभ रात्रि'
      ),
      'es' => array(
        'morning' => 'Buenos Días',
        'afternoon' => 'Buenas Tardes',
        'evening' => 'Buenas Tardes',
        'night' => 'Buenas Noches'
      )
    );
    
    $time_period = '';
    if ($hour >= 5 && $hour < 12) {
      $time_period = 'morning';
    } elseif ($hour >= 12 && $hour < 18) {
      $time_period = 'afternoon';
    } elseif ($hour >= 18 && $hour < 22) {
      $time_period = 'evening';
    } else {
      $time_period = 'night';
    }
    
    return $greetings[$language][$time_period];
  } catch (Exception $e) {
    log_message('error', 'Timezone error: ' . $e->getMessage());
    return 'Welcome back';
  }
}
```

## Troubleshooting

### Issue: Greeting shows wrong time

**Solution:** Verify your server's timezone settings:
```php
// Check current timezone
echo date_default_timezone_get();

// Set default timezone in config/config.php
date_default_timezone_set('Asia/Kolkata');
```

### Issue: Timezone error in logs

**Solution:** Ensure the timezone identifier is valid. Check PHP's supported timezones:
```php
$timezones = DateTimeZone::listIdentifiers();
print_r($timezones);
```

### Issue: Greeting doesn't update

**Solution:** Clear browser cache or add cache-busting:
```php
// In view
<h2 id="greeting-message"><?= $greeting ?>, <?= $uname ?>! 👋</h2>

<script>
// Optional: Auto-refresh greeting every minute
setInterval(function() {
  location.reload();
}, 60000); // 60 seconds
</script>
```

## Performance Considerations

The `get_time_based_greeting()` method is lightweight and executes in microseconds. However, if you're concerned about performance:

1. **Cache the greeting** for a few minutes:
```php
// In controller
$cache_key = 'greeting_' . $this->session->userdata('username');
$greeting = $this->cache->get($cache_key);

if (!$greeting) {
  $greeting = $this->get_time_based_greeting('Asia/Kolkata');
  $this->cache->save($cache_key, $greeting, 300); // Cache for 5 minutes
}

$data['greeting'] = $greeting;
```

2. **Use session storage:**
```php
// Check if greeting needs update (every 30 minutes)
$last_update = $this->session->userdata('greeting_last_update');
$current_time = time();

if (!$last_update || ($current_time - $last_update) > 1800) {
  $greeting = $this->get_time_based_greeting('Asia/Kolkata');
  $this->session->set_userdata('greeting', $greeting);
  $this->session->set_userdata('greeting_last_update', $current_time);
} else {
  $greeting = $this->session->userdata('greeting');
}

$data['greeting'] = $greeting;
```

## Summary

✅ **Implemented:** Dynamic time-based greeting in Admin Dashboard
✅ **Timezone Support:** Configurable timezone with fallback
✅ **Error Handling:** Graceful fallback to default greeting
✅ **Extensible:** Easy to apply to other dashboards
✅ **Customizable:** Time ranges, icons, and languages

The greeting will now automatically change based on the time of day, providing a more personalized experience for your users!
