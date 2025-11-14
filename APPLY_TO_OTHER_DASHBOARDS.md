# Apply Dynamic Greeting to Other Dashboards

## Quick Reference Guide

### ✅ Already Implemented
- **Admin Dashboard** (`A_dashboard.php` → `Adashboard_new.php`)

### 📝 To Implement

## 1. Interviewer Dashboard

**File:** `application/views/Interviewer_dashboard_view/dashboard.php` (Line 224)

**Current Code:**
```php
<h1><i class="fas fa-user-tie me-2"></i>Welcome back, <?php echo htmlspecialchars($uname); ?>!</h1>
```

**Updated Code:**
```php
<h1><i class="fas fa-user-tie me-2"></i><?= isset($greeting) ? $greeting : 'Welcome back' ?>, <?php echo htmlspecialchars($uname); ?>!</h1>
```

**Controller Update:** Add to your Interviewer controller's index method:
```php
// Add this helper method to your controller
private function get_time_based_greeting($timezone = 'Asia/Kolkata')
{
  try {
    $date = new DateTime('now', new DateTimeZone($timezone));
    $hour = (int)$date->format('H');
    
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
    log_message('error', 'Timezone error: ' . $e->getMessage());
    return 'Welcome back';
  }
}

// In your index() method, add:
$data['greeting'] = $this->get_time_based_greeting('Asia/Kolkata');
```

---

## 2. Candidate Dashboard

**File:** `application/views/Candidate_dashboard_view/dashboard.php` (Line 251)

**Current Code:**
```php
<h1><i class="fas fa-user-graduate me-2"></i>Welcome back, <?php echo htmlspecialchars($uname); ?>!</h1>
```

**Updated Code:**
```php
<h1><i class="fas fa-user-graduate me-2"></i><?= isset($greeting) ? $greeting : 'Welcome back' ?>, <?php echo htmlspecialchars($uname); ?>!</h1>
```

**Controller Update:** Same as Interviewer dashboard above.

---

## 3. Recruiter Dashboard

If you have a recruiter-specific dashboard, follow the same pattern:

**View Update:**
```php
<h1><?= isset($greeting) ? $greeting : 'Welcome back' ?>, <?= $uname ?>!</h1>
```

**Controller Update:**
```php
$data['greeting'] = $this->get_time_based_greeting('Asia/Kolkata');
```

---

## 4. Login Pages (Optional)

You can also add dynamic greetings to login pages!

**File:** `application/views/login_new.php` (Line 346)

**Current Code:**
```php
<h1>Welcome Back</h1>
```

**Updated Code:**
```php
<?php
  $hour = (int)date('H');
  if ($hour >= 5 && $hour < 12) {
    $login_greeting = 'Good Morning';
  } elseif ($hour >= 12 && $hour < 18) {
    $login_greeting = 'Good Afternoon';
  } elseif ($hour >= 18 && $hour < 22) {
    $login_greeting = 'Good Evening';
  } else {
    $login_greeting = 'Good Night';
  }
?>
<h1><?= $login_greeting ?></h1>
```

---

## Complete Implementation Checklist

### Step 1: Create Helper Library (Recommended for Reusability)

Create: `application/libraries/Greeting_helper.php`

```php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Greeting_helper
{
    /**
     * Get time-based greeting
     * @param string $timezone
     * @return string
     */
    public function get_greeting($timezone = 'Asia/Kolkata')
    {
        try {
            $date = new DateTime('now', new DateTimeZone($timezone));
            $hour = (int)$date->format('H');
            
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
            log_message('error', 'Timezone error: ' . $e->getMessage());
            return 'Welcome back';
        }
    }
    
    /**
     * Get greeting with icon
     * @param string $timezone
     * @return string
     */
    public function get_greeting_with_icon($timezone = 'Asia/Kolkata')
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
}
```

### Step 2: Use in Any Controller

```php
// Load the library
$this->load->library('greeting_helper');

// Get greeting
$data['greeting'] = $this->greeting_helper->get_greeting('Asia/Kolkata');

// Or with icon
$data['greeting'] = $this->greeting_helper->get_greeting_with_icon('Asia/Kolkata');
```

### Step 3: Auto-load (Optional)

Add to `application/config/autoload.php`:

```php
$autoload['libraries'] = array('greeting_helper');
```

Then you can use it anywhere without loading:
```php
$data['greeting'] = $this->greeting_helper->get_greeting();
```

---

## Advanced: Base Controller Approach

Create: `application/core/MY_Controller.php`

```php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    protected function get_time_based_greeting($timezone = 'Asia/Kolkata')
    {
        try {
            $date = new DateTime('now', new DateTimeZone($timezone));
            $hour = (int)$date->format('H');
            
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
            log_message('error', 'Timezone error: ' . $e->getMessage());
            return 'Welcome back';
        }
    }
}
```

Then extend your controllers:
```php
class A_dashboard extends MY_Controller
{
    public function index()
    {
        $data['greeting'] = $this->get_time_based_greeting('Asia/Kolkata');
        // ... rest of code
    }
}
```

---

## Testing Each Dashboard

### Test Admin Dashboard
```
http://localhost/rms/A_dashboard
```

### Test Interviewer Dashboard
```
http://localhost/rms/Interviewer_dashboard
```

### Test Candidate Dashboard
```
http://localhost/rms/Candidate_dashboard
```

---

## Timezone Configuration by User Role

If different user roles need different timezones:

```php
public function index()
{
    $role = $this->session->userdata('role');
    
    // Set timezone based on role or user preference
    switch($role) {
        case 'Admin':
            $timezone = 'Asia/Kolkata';
            break;
        case 'Interviewer':
            $timezone = 'America/New_York';
            break;
        case 'Candidate':
            $timezone = 'Europe/London';
            break;
        default:
            $timezone = 'Asia/Kolkata';
    }
    
    $data['greeting'] = $this->get_time_based_greeting($timezone);
}
```

---

## Summary

✅ **Admin Dashboard** - Already implemented
⏳ **Interviewer Dashboard** - Ready to implement (follow guide above)
⏳ **Candidate Dashboard** - Ready to implement (follow guide above)
⏳ **Login Pages** - Optional enhancement

Choose your preferred approach:
1. **Copy method to each controller** (Simple, works immediately)
2. **Create helper library** (Reusable, clean)
3. **Use base controller** (Most elegant, requires core extension)

All approaches work perfectly - choose based on your project structure and preferences!
