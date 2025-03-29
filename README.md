# Recruitment Management System (RMS)

A comprehensive web-based application built using PHP CodeIgniter framework to streamline and manage the entire recruitment process.

## Overview

The Recruitment Management System (RMS) is designed to help organizations efficiently manage their recruitment workflow. The system provides separate interfaces for administrators and recruiters, allowing them to track candidates, schedule interviews, and manage the entire hiring process from a centralized platform.

## Features

### Administrator Features

- **Dashboard**: Overview of recruitment metrics and statistics
- **Calendar Management**: View all scheduled interviews across recruiters
- **Candidate Management**: Access to all candidate information
- **Recruiter Management**: Add, manage, and activate recruiter accounts
- **Reports**: Generate comprehensive recruitment reports

### Recruiter Features

- **Dashboard**: Personal recruitment metrics and statistics
- **Calendar Management**: Schedule and manage interviews
- **Candidate Management**: Add, update, and track candidate status
- **Status Updates**: Update candidate interview progress and hiring status
- **Profile Management**: Update personal account information

### General Features

- **Secure Authentication**: Role-based access control system
- **Interview Scheduling**: Interactive calendar for scheduling interviews
- **Email Notifications**: Automated email notifications for account activation and password reset
- **Responsive Design**: Mobile-friendly interface
- **Data Analytics**: Visual representation of recruitment metrics

## Technology Stack

- **Framework**: CodeIgniter (PHP MVC Framework)
- **Frontend**: HTML5, CSS3, JavaScript, jQuery, Bootstrap
- **Database**: MySQL
- **Libraries**:
  - Full Calendar (for interview scheduling)
  - FontAwesome (for UI icons)
  - jQuery Validation (for form validation)
  - Bootstrap (for responsive design)

## System Architecture

The system follows the MVC (Model-View-Controller) architecture pattern of CodeIgniter:

- **Models**: Handle data access and business logic
- **Views**: Present data and user interface
- **Controllers**: Process user requests and coordinate between models and views

## Installation and Setup

1. Clone the repository to your web server directory
2. Create a MySQL database and import the provided SQL file
3. Configure the database connection in `application/config/database.php`
4. Configure base URL in `application/config/config.php`
5. Make sure your server meets these requirements:
   - PHP 7.2 or higher
   - MySQL 5.7 or higher
   - mod_rewrite enabled

## Directory Structure

```
rms/
├── application/
│   ├── controllers/          # Contains all controllers
│   ├── models/               # Contains all models
│   ├── views/                # Contains all view files
│   │   ├── Admin_dashboard_view/    # Admin interface views
│   │   ├── Recruiter_dashboard_view/  # Recruiter interface views
│   ├── config/               # Configuration files
├── Assets/
│   ├── Admin_Dashboard/      # Admin-specific assets
│   ├── Recruiter_Dashboard/  # Recruiter-specific assets
├── uploads/                  # Uploaded resumes/CVs
```

## User Roles

1. **Administrator**
   - Full access to all system features
   - Can add/manage recruiters
   - Can view all candidates and interviews

2. **Recruiter**
   - Limited access based on assigned permissions
   - Can add and manage their own candidates
   - Can schedule interviews for their candidates

## Usage Flow

1. **Admin Login**
   - Admin logs in and can view the dashboard
   - Admin can add new recruiters to the system
   - Admin can view all scheduled interviews and candidates

2. **Recruiter Login**
   - Recruiter logs in after account activation
   - Recruiter adds candidate information
   - Recruiter schedules interviews for interested candidates
   - Recruiter updates status after each interview round

3. **Candidate Management**
   - Recruiters can track candidate progress
   - Update candidate status (Interested, Not interested, etc.)
   - Schedule multiple interview rounds

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Contributors

- Charaka - Developer

## Acknowledgments

- University of Colombo School of Computing (UCSC)
- MIT program 2024

## Support

For any issues or questions, please contact the system administrator.