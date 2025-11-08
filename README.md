# Recruitment Management System (RMS)

A modern, full-featured web application for managing recruitment processes, built with CodeIgniter 3 and Bootstrap 5.

![Version](https://img.shields.io/badge/version-2.0-blue.svg)
![PHP](https://img.shields.io/badge/PHP-8.0+-purple.svg)
![CodeIgniter](https://img.shields.io/badge/CodeIgniter-3.x-orange.svg)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-purple.svg)
![License](https://img.shields.io/badge/license-MIT-green.svg)

## 📋 Table of Contents

- [Features](#features)
- [Screenshots](#screenshots)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [User Roles](#user-roles)
- [Technology Stack](#technology-stack)
- [Project Structure](#project-structure)
- [API Endpoints](#api-endpoints)
- [Troubleshooting](#troubleshooting)
- [Contributing](#contributing)
- [License](#license)
- [Support](#support)

## ✨ Features

### 🎨 Modern UI/UX
- **Responsive Design** - Works seamlessly on desktop, tablet, and mobile devices
- **Modern Gradient Theme** - Beautiful purple gradient color scheme
- **Smooth Animations** - Enhanced user experience with smooth transitions
- **Icon-Enhanced Interface** - Font Awesome 6 icons throughout
- **Dark Mode Ready** - Theme toggle support

### 👥 User Management
- **Role-Based Access Control** - Admin and Recruiter roles
- **Secure Authentication** - Login, signup, and password reset
- **Profile Management** - Edit profile information and change password
- **Account Activation** - Email-based account activation system
- **Session Management** - Secure session handling

### 📊 Candidate Management
- **Add Candidates** - Comprehensive candidate information form
- **Track Progress** - Monitor interview rounds and status
- **Search & Filter** - DataTables integration for easy searching
- **Export Data** - Export candidate lists
- **Status Updates** - Real-time status tracking

### 📅 Interview Scheduling
- **Calendar View** - FullCalendar integration for visual scheduling
- **Event Management** - Add, edit, and delete interview events
- **Multiple Views** - Month, week, and day views
- **Color Coding** - Visual status indicators by interview round
- **Notifications** - Alert system for upcoming interviews

### 📈 Dashboard & Analytics
- **Statistics Cards** - Key metrics at a glance
- **Interactive Charts** - Chart.js visualizations
- **Recent Activity** - Track latest actions
- **Progress Tracking** - Visual progress indicators
- **Data Tables** - Sortable, searchable data tables

### 🔒 Security Features
- **Password Hashing** - MD5 encryption for passwords
- **SQL Injection Prevention** - CodeIgniter Query Builder
- **XSS Protection** - Built-in CodeIgniter security
- **CSRF Protection** - Cross-site request forgery prevention
- **Session Security** - Secure session management

## 📸 Screenshots

### Authentication Pages
- Modern login page with gradient background
- Signup page with validation
- Forgot password functionality
- Reset password with real-time validation

### Admin Dashboard
- Overview dashboard with statistics
- Calendar view for interview scheduling
- Recruiter management
- Candidate tracking
- Account settings

### Recruiter Dashboard
- Personal dashboard
- Add candidates
- Schedule interviews
- Track candidate status
- View selected candidates

## 🔧 Requirements

### Server Requirements
- **PHP**: 8.0 or higher
- **MySQL**: 5.7 or higher
- **Apache/Nginx**: Web server with mod_rewrite enabled
- **OpenSSL**: PHP extension for email functionality

### PHP Extensions
- `php-mysqli` - MySQL database support
- `php-openssl` - SSL/TLS support for emails
- `php-mbstring` - Multibyte string support
- `php-json` - JSON support
- `php-curl` - cURL support (optional)

### Browser Support
- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers

## 📦 Installation

### 1. Clone the Repository
```bash
git clone https://github.com/yourusername/rms.git
cd rms
```

### 2. Configure Database
Create a new MySQL database:
```sql
CREATE DATABASE rms_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Import the database schema:
```bash
mysql -u your_username -p rms_db < database/rms_schema.sql
```

### 3. Configure Application

#### Update Database Configuration
Edit `application/config/database.php`:
```php
$db['default'] = array(
    'hostname' => 'localhost',
    'username' => 'your_username',
    'password' => 'your_password',
    'database' => 'rms_db',
    // ... other settings
);
```

#### Update Base URL
Edit `application/config/config.php`:
```php
$config['base_url'] = 'http://localhost/rms/';
```

#### Configure Email Settings
Edit `application/config/constants.php`:
```php
define('SENDER_EMAIL', 'your-email@gmail.com');
define('SENDER_PASSWORD', 'your-app-password'); // Gmail App Password
```

**Note**: For Gmail, you need to:
1. Enable 2-Factor Authentication
2. Generate an App Password at https://myaccount.google.com/apppasswords
3. Use the 16-character App Password

### 4. Set Permissions
```bash
chmod -R 755 application/
chmod -R 777 application/logs/
chmod -R 777 application/cache/
```

### 5. Configure Web Server

#### Apache (.htaccess)
The `.htaccess` file is already included. Ensure `mod_rewrite` is enabled:
```bash
sudo a2enmod rewrite
sudo service apache2 restart
```

#### Nginx
Add this to your nginx configuration:
```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```

### 6. Access the Application
Open your browser and navigate to:
```
http://localhost/rms/
```

## ⚙️ Configuration

### Email Configuration

#### Gmail Setup
1. Enable 2FA on your Google Account
2. Generate App Password
3. Update `application/config/constants.php`

#### Alternative SMTP Services

**SendGrid:**
```php
// In application/config/email.php
$config['smtp_host'] = 'smtp.sendgrid.net';
$config['smtp_port'] = 587;
$config['smtp_user'] = 'apikey';
$config['smtp_pass'] = 'YOUR_SENDGRID_API_KEY';
```

**Mailgun:**
```php
$config['smtp_host'] = 'smtp.mailgun.org';
$config['smtp_port'] = 587;
$config['smtp_user'] = 'postmaster@your-domain.mailgun.org';
$config['smtp_pass'] = 'YOUR_MAILGUN_PASSWORD';
```

### Application Settings

#### Constants Configuration
Edit `application/config/constants.php`:
```php
// Base URL
define('BASE_URL', 'http://localhost/rms');

// Company Information
define('COMPANY_LOGO', BASE_URL.'/Assets/Recruiter_Dashboard/img/logo/CompanyLogo.png');
define('COMPANY_NAME', BASE_URL.'/Assets/Recruiter_Dashboard/img/logo/CompanyName.png');

// Email Settings
define('SENDER_EMAIL', 'your-email@gmail.com');
define('SENDER_PASSWORD', 'your-app-password');
```

## 🚀 Usage

### Default Admin Account
After installation, create an admin account:
```sql
INSERT INTO users (u_username, u_email, u_password, u_role, u_status) 
VALUES ('admin', 'admin@example.com', MD5('admin123'), 'Admin', 1);
```

**Login Credentials:**
- Username: `admin`
- Password: `admin123`

**⚠️ Important**: Change the default password immediately after first login!

### User Workflows

#### Admin Workflow
1. **Login** → Admin Dashboard
2. **Manage Recruiters** → Add/Activate recruiters
3. **View All Candidates** → Monitor recruitment pipeline
4. **Schedule Interviews** → Calendar management
5. **Track Progress** → View statistics and reports

#### Recruiter Workflow
1. **Login** → Recruiter Dashboard
2. **Add Candidates** → Enter candidate information
3. **Schedule Interviews** → Set interview dates
4. **Update Status** → Track interview rounds
5. **Mark Selected** → Finalize candidate selection

### Common Tasks

#### Adding a Candidate
1. Navigate to "Add Candidate"
2. Fill in candidate details
3. Submit the form
4. Candidate appears in the list

#### Scheduling an Interview
1. Go to Calendar view
2. Click on a date
3. Fill in interview details
4. Save the event

#### Updating Candidate Status
1. Find candidate in the list
2. Click on status dropdown
3. Select new status
4. Changes are saved automatically

## 👥 User Roles

### Administrator
**Permissions:**
- ✅ Manage recruiters (add, activate, deactivate)
- ✅ View all candidates across all recruiters
- ✅ Access all calendar events
- ✅ View system-wide statistics
- ✅ Manage own account

**Dashboard Features:**
- Total candidates overview
- Recruiter management
- System-wide calendar
- Selected candidates list
- Account management

### Recruiter
**Permissions:**
- ✅ Add new candidates
- ✅ Schedule interviews for own candidates
- ✅ Update candidate status
- ✅ View own candidates only
- ✅ Manage own account

**Dashboard Features:**
- Personal candidate list
- Interview scheduling
- Status tracking
- Selected candidates
- Account management

## 🛠️ Technology Stack

### Backend
- **Framework**: CodeIgniter 3.x
- **Language**: PHP 8.0+
- **Database**: MySQL 5.7+
- **Architecture**: MVC Pattern

### Frontend
- **Framework**: Bootstrap 5.3.0
- **Icons**: Font Awesome 6.4.0
- **Fonts**: Google Fonts (Inter, Nunito)
- **JavaScript**: jQuery 3.6.0

### Libraries & Plugins
- **DataTables**: 1.13.6 - Advanced table features
- **Chart.js**: Latest - Data visualization
- **FullCalendar**: 6.1.8 - Calendar functionality
- **SweetAlert2**: (Optional) - Beautiful alerts

### Email
- **SMTP**: Gmail, SendGrid, Mailgun support
- **Protocol**: TLS/SSL encryption
- **Library**: CodeIgniter Email Library

## 📁 Project Structure

```
rms/
├── application/
│   ├── config/
│   │   ├── autoload.php          # Auto-load configuration
│   │   ├── config.php             # Main configuration
│   │   ├── constants.php          # Application constants
│   │   ├── database.php           # Database configuration
│   │   ├── email.php              # Email configuration
│   │   └── routes.php             # URL routing
│   ├── controllers/
│   │   ├── Login.php              # Authentication controller
│   │   ├── A_dashboard.php        # Admin dashboard controller
│   │   └── R_dashboard.php        # Recruiter dashboard controller
│   ├── models/
│   │   ├── Login_model.php        # Login operations
│   │   ├── Signup_model.php       # Registration operations
│   │   ├── Candidate_model.php    # Candidate operations
│   │   ├── Calendar_model.php     # Calendar operations
│   │   └── Profile_record_model.php # Profile operations
│   ├── views/
│   │   ├── templates/
│   │   │   ├── admin_header.php   # Admin template header
│   │   │   └── admin_footer.php   # Admin template footer
│   │   ├── Admin_dashboard_view/
│   │   │   ├── Adashboard_new.php # Admin dashboard
│   │   │   ├── Acalendar_new.php  # Admin calendar
│   │   │   ├── Arecruiter_new.php # Recruiter management
│   │   │   ├── Asele_candidate_new.php # Selected candidates
│   │   │   └── Aaccount_details_new.php # Account settings
│   │   ├── Recruiter_dashboard_view/
│   │   │   └── ... (Recruiter views)
│   │   ├── login_new.php          # Login page
│   │   ├── signup_new.php         # Signup page
│   │   ├── forgotpassword_new.php # Forgot password
│   │   └── resetpassword_new.php  # Reset password
│   └── logs/                      # Application logs
├── Assets/
│   ├── Admin_Dashboard/           # Admin assets
│   ├── Recruiter_Dashboard/       # Recruiter assets
│   └── login_page/                # Login page assets
├── system/                        # CodeIgniter system files
├── .htaccess                      # Apache configuration
├── index.php                      # Application entry point
└── README.md                      # This file
```

## 🔌 API Endpoints

### Authentication
```
POST   /Login/loginproc           # Process login
POST   /Login/signupproc           # Process signup
POST   /Login/forgot_pass_process  # Process forgot password
POST   /Login/reset_password_process # Process password reset
GET    /Login/logout               # Logout user
```

### Admin Dashboard
```
GET    /A_dashboard                # Admin dashboard
GET    /A_dashboard/Acalendar_view # Calendar view
GET    /A_dashboard/Arecruiter_view # Recruiter management
GET    /A_dashboard/Ascandidate_view # Selected candidates
GET    /A_dashboard/Aaccount_details_view # Account settings
POST   /A_dashboard/update_profile # Update profile
POST   /A_dashboard/change_password # Change password
GET    /A_dashboard/get_events     # Get calendar events (JSON)
POST   /A_dashboard/add_rec        # Add recruiter
```

### Recruiter Dashboard
```
GET    /R_dashboard                # Recruiter dashboard
GET    /R_dashboard/Rcandidate_view # Add candidate
GET    /R_dashboard/Rcalendar_view # Calendar view
GET    /R_dashboard/Rstatus_view   # Status tracking
GET    /R_dashboard/Rscandidate_view # Selected candidates
GET    /R_dashboard/Raccount_details_view # Account settings
```

## 🐛 Troubleshooting

### Common Issues

#### 1. Blank Page / 500 Error
**Solution:**
```bash
# Check PHP error logs
tail -f /var/log/apache2/error.log

# Enable error reporting in index.php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

#### 2. Database Connection Error
**Solution:**
- Verify database credentials in `application/config/database.php`
- Ensure MySQL service is running
- Check database exists and user has permissions

#### 3. Email Not Sending
**Solution:**
- Verify email configuration in `application/config/constants.php`
- For Gmail, use App Password (not regular password)
- Check `application/logs/` and `email_error.log` for details
- Verify OpenSSL extension is enabled

#### 4. 404 Error on Pages
**Solution:**
- Check `.htaccess` file exists
- Verify `mod_rewrite` is enabled
- Check base URL in `application/config/config.php`

#### 5. Session Issues / Auto Logout
**Solution:**
```php
// In application/config/config.php
$config['sess_driver'] = 'files';
$config['sess_save_path'] = APPPATH . 'cache/';
$config['sess_expiration'] = 7200; // 2 hours
```

#### 6. DataTables Error
**Solution:**
- Clear browser cache (Ctrl+F5)
- Check console for JavaScript errors
- Verify jQuery is loaded before DataTables

### Debug Mode

Enable debug mode for development:
```php
// In index.php
define('ENVIRONMENT', 'development');

// In application/config/config.php
$config['log_threshold'] = 4; // Log everything
```

### Getting Help

1. Check documentation files in root directory
2. Review `application/logs/` for error messages
3. Check browser console for JavaScript errors
4. Verify all requirements are met

## 📚 Documentation

Additional documentation files:
- `FINAL_UI_UPDATE_COMPLETE.md` - Complete UI update guide
- `ADMIN_UI_UPDATE_COMPLETE.md` - Admin dashboard guide
- `ACCOUNT_PROFILE_IMPLEMENTATION.md` - Profile features guide
- `DATATABLES_FIX.md` - DataTables troubleshooting
- `ALL_UI_UPDATES_SUMMARY.txt` - Quick reference

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

### Coding Standards
- Follow CodeIgniter coding standards
- Use meaningful variable and function names
- Comment complex logic
- Test thoroughly before submitting

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- **CodeIgniter** - PHP Framework
- **Bootstrap** - CSS Framework
- **Font Awesome** - Icon Library
- **Chart.js** - Charting Library
- **FullCalendar** - Calendar Library
- **DataTables** - Table Plugin

## 📞 Support

### Getting Support
- 📧 Email: support@example.com
- 🐛 Issues: [GitHub Issues](https://github.com/yourusername/rms/issues)
- 📖 Documentation: Check the docs folder
- 💬 Community: [Discussions](https://github.com/yourusername/rms/discussions)

### Reporting Bugs
When reporting bugs, please include:
- PHP version
- Browser and version
- Steps to reproduce
- Error messages from logs
- Screenshots (if applicable)

## 🗺️ Roadmap

### Version 2.1 (Planned)
- [ ] Email templates customization
- [ ] Advanced reporting features
- [ ] Bulk candidate import (CSV/Excel)
- [ ] Interview feedback forms
- [ ] Candidate portal
- [ ] Mobile app

### Version 2.2 (Future)
- [ ] AI-powered candidate matching
- [ ] Video interview integration
- [ ] Advanced analytics dashboard
- [ ] Multi-language support
- [ ] API for third-party integrations

## 📊 Statistics

- **Total Lines of Code**: ~15,000+
- **Files**: 50+
- **Controllers**: 3
- **Models**: 5
- **Views**: 20+
- **Database Tables**: 4

## 🎯 Key Features Summary

✅ Modern, responsive UI with Bootstrap 5  
✅ Role-based access control (Admin/Recruiter)  
✅ Complete candidate management system  
✅ Interview scheduling with calendar  
✅ Real-time status tracking  
✅ Email notifications  
✅ Profile management  
✅ Data export capabilities  
✅ Interactive charts and analytics  
✅ Mobile-friendly design  
✅ Secure authentication  
✅ Password reset functionality  

---

**Made with ❤️ by Your Team**

**Version**: 2.0  
**Last Updated**: <?= date('F Y') ?>  
**Status**: Production Ready ✅

For more information, visit our [website](https://example.com) or check out the [documentation](https://docs.example.com).
