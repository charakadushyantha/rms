# 🏗️ RMS Architecture - Part 2

## 10. UI/UX Architecture

```
┌─────────────────────────────────────────────────────────────────┐
│                    FRONTEND ARCHITECTURE                        │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  LAYOUT STRUCTURE                                               │
│  ┌────────────────────────────────────────────────────────┐   │
│  │                                                        │   │
│  │  ┌──────────┐  ┌────────────────────────────────┐   │   │
│  │  │          │  │         TOPBAR                 │   │   │
│  │  │          │  │  • Search                      │   │   │
│  │  │ SIDEBAR  │  │  • Notifications               │   │   │
│  │  │          │  │  • User Menu                   │   │   │
│  │  │ • Logo   │  └────────────────────────────────┘   │   │
│  │  │ • Menu   │                                        │   │
│  │  │ • Nav    │  ┌────────────────────────────────┐   │   │
│  │  │          │  │                                │   │   │
│  │  │          │  │      MAIN CONTENT AREA         │   │   │
│  │  │          │  │                                │   │   │
│  │  │          │  │  • Dashboard Widgets           │   │   │
│  │  │          │  │  • Data Tables                 │   │   │
│  │  │          │  │  • Forms                       │   │   │
│  │  │          │  │  • Charts                      │   │   │
│  │  │          │  │                                │   │   │
│  │  └──────────┘  └────────────────────────────────┘   │   │
│  │                                                        │   │
│  └────────────────────────────────────────────────────────┘   │
│                                                                 │
│  RESPONSIVE DESIGN                                              │
│  ┌────────────────────────────────────────────────────────┐   │
│  │ Desktop (>992px)  : Full sidebar + content            │   │
│  │ Tablet (768-992px): Collapsible sidebar               │   │
│  │ Mobile (<768px)   : Hidden sidebar + hamburger menu   │   │
│  └────────────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────────┘
```



## 11. Technology Stack

```
┌─────────────────────────────────────────────────────────────────┐
│                      TECHNOLOGY STACK                           │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  BACKEND                                                        │
│  ┌────────────────────────────────────────────────────────┐   │
│  │ Framework    : CodeIgniter 3.x                         │   │
│  │ Language     : PHP 7.4+                                │   │
│  │ Architecture : MVC Pattern                             │   │
│  │ Database     : MySQL 5.7+ / MariaDB                    │   │
│  │ ORM          : Active Record (CI Query Builder)        │   │
│  │ Session      : Database/File-based Sessions            │   │
│  └────────────────────────────────────────────────────────┘   │
│                                                                 │
│  FRONTEND                                                       │
│  ┌────────────────────────────────────────────────────────┐   │
│  │ CSS Framework : Bootstrap 5.3                          │   │
│  │ Icons         : Font Awesome 6.4                       │   │
│  │ JavaScript    : jQuery 3.x                             │   │
│  │ Charts        : Chart.js                               │   │
│  │ Calendar      : FullCalendar 6.x                       │   │
│  │ Alerts        : SweetAlert2                            │   │
│  │ DataTables    : DataTables.net                         │   │
│  └────────────────────────────────────────────────────────┘   │
│                                                                 │
│  AUTHENTICATION                                                 │
│  ┌────────────────────────────────────────────────────────┐   │
│  │ OAuth 2.0     : Google Sign-In                         │   │
│  │ Password Hash : MD5 (Legacy)                           │   │
│  │ Session Mgmt  : CodeIgniter Session Library            │   │
│  └────────────────────────────────────────────────────────┘   │
│                                                                 │
│  DEVELOPMENT TOOLS                                              │
│  ┌────────────────────────────────────────────────────────┐   │
│  │ Web Server   : Apache/Nginx                            │   │
│  │ PHP Server   : XAMPP/WAMP/LAMP                         │   │
│  │ Version Ctrl : Git                                     │   │
│  │ IDE          : VS Code / PhpStorm                      │   │
│  └────────────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────────┘
```



## 12. Data Flow Diagrams

### Candidate Management Flow
```
Recruiter Dashboard
     │
     │ Add Candidate
     ▼
┌─────────────────┐
│ Candidate Form  │
└─────────────────┘
     │
     │ Submit
     ▼
┌─────────────────┐
│ R_dashboard     │ ◀── Validate Input
│ /add_candidate  │
└─────────────────┘
     │
     │ Save Data
     ▼
┌─────────────────┐
│ Candidate_model │ ◀── Insert to DB
└─────────────────┘
     │
     │ Success
     ▼
┌─────────────────┐
│ Audit Logger    │ ◀── Log Action
└─────────────────┘
     │
     │ Redirect
     ▼
Candidate List View
```

### Interview Scheduling Flow
```
Recruiter/Admin
     │
     │ Schedule Interview
     ▼
┌─────────────────┐
│ Calendar View   │ ◀── Select Date/Time
└─────────────────┘
     │
     │ Choose Candidate
     ▼
┌─────────────────┐
│ Select Form     │ ◀── Pick Interviewer
└─────────────────┘     Pick Round
     │
     │ Submit
     ▼
┌─────────────────┐
│ Calendar_model  │ ◀── Save Event
└─────────────────┘
     │
     ├──▶ Email Notification ──▶ Interviewer
     │
     ├──▶ Email Notification ──▶ Candidate
     │
     └──▶ Audit Log ──▶ Database
```



## 13. API Endpoints

```
┌─────────────────────────────────────────────────────────────────┐
│                        API STRUCTURE                            │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  AUTHENTICATION                                                 │
│  POST   /Login/loginproc              ◀── User Login           │
│  GET    /Login/logout                 ◀── User Logout          │
│  GET    /Login/google_login           ◀── Google OAuth Init    │
│  GET    /Login/google_callback        ◀── Google OAuth Callback│
│                                                                 │
│  DASHBOARD                                                      │
│  GET    /A_dashboard                  ◀── Admin Dashboard      │
│  GET    /R_dashboard                  ◀── Recruiter Dashboard  │
│  GET    /I_dashboard                  ◀── Interviewer Dashboard│
│  GET    /C_dashboard                  ◀── Candidate Dashboard  │
│  POST   /A_dashboard/global_search    ◀── Global Search        │
│  GET    /A_dashboard/get_notifications◀── Get Notifications    │
│                                                                 │
│  CANDIDATE MANAGEMENT                                           │
│  GET    /R_dashboard/Rcandidate_view  ◀── List Candidates      │
│  POST   /R_dashboard/add_candidate    ◀── Add Candidate        │
│  POST   /R_dashboard/update_candidate ◀── Update Candidate     │
│  GET    /R_dashboard/delete_candidate ◀── Delete Candidate     │
│                                                                 │
│  INTERVIEW SCHEDULING                                           │
│  GET    /R_dashboard/Rcalendar_view   ◀── Calendar View        │
│  POST   /R_dashboard/get_events       ◀── Get Events (AJAX)    │
│  POST   /R_dashboard/schedule_interview◀── Schedule Interview  │
│                                                                 │
│  SETUP & CONFIGURATION                                          │
│  GET    /Setup                        ◀── Setup Dashboard      │
│  GET    /Setup/google_oauth_config    ◀── OAuth Config         │
│  POST   /Setup/save_google_oauth_config◀── Save OAuth Config  │
│  GET    /Setup/audit_logs             ◀── View Audit Logs      │
│  POST   /Setup/export_audit_logs      ◀── Export Logs (CSV)    │
│                                                                 │
│  REPORTS                                                        │
│  GET    /A_dashboard/reports_view     ◀── Reports Dashboard    │
│  GET    /A_dashboard/generate_report  ◀── Generate Report      │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
```



## 14. Deployment Architecture

```
┌─────────────────────────────────────────────────────────────────┐
│                    DEPLOYMENT DIAGRAM                           │
└─────────────────────────────────────────────────────────────────┘

PRODUCTION ENVIRONMENT
┌─────────────────────────────────────────────────────────────────┐
│                                                                 │
│  ┌──────────────────────────────────────────────────────┐     │
│  │              LOAD BALANCER (Optional)                │     │
│  │                   Nginx/HAProxy                      │     │
│  └──────────────────────────────────────────────────────┘     │
│                          │                                     │
│         ┌────────────────┼────────────────┐                   │
│         │                │                │                   │
│         ▼                ▼                ▼                   │
│  ┌──────────┐    ┌──────────┐    ┌──────────┐               │
│  │ Web      │    │ Web      │    │ Web      │               │
│  │ Server 1 │    │ Server 2 │    │ Server 3 │               │
│  │          │    │          │    │          │               │
│  │ Apache   │    │ Apache   │    │ Apache   │               │
│  │ PHP-FPM  │    │ PHP-FPM  │    │ PHP-FPM  │               │
│  │ RMS App  │    │ RMS App  │    │ RMS App  │               │
│  └──────────┘    └──────────┘    └──────────┘               │
│         │                │                │                   │
│         └────────────────┼────────────────┘                   │
│                          │                                     │
│                          ▼                                     │
│  ┌──────────────────────────────────────────────────────┐     │
│  │              DATABASE SERVER                         │     │
│  │                                                      │     │
│  │  ┌────────────────┐      ┌────────────────┐       │     │
│  │  │  MySQL Master  │─────▶│  MySQL Slave   │       │     │
│  │  │  (Read/Write)  │      │  (Read Only)   │       │     │
│  │  └────────────────┘      └────────────────┘       │     │
│  │                                                      │     │
│  └──────────────────────────────────────────────────────┘     │
│                          │                                     │
│                          ▼                                     │
│  ┌──────────────────────────────────────────────────────┐     │
│  │              FILE STORAGE                            │     │
│  │                                                      │     │
│  │  • Profile Pictures                                  │     │
│  │  • Candidate Documents                               │     │
│  │  • System Logs                                       │     │
│  │                                                      │     │
│  │  (NFS / S3 / Local Storage)                         │     │
│  └──────────────────────────────────────────────────────┘     │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘

EXTERNAL SERVICES
┌─────────────────────────────────────────────────────────────────┐
│  • Google OAuth API                                             │
│  • SMTP Server (Email)                                          │
│  • SMS Gateway (Optional)                                       │
│  • WhatsApp API (Optional)                                      │
└─────────────────────────────────────────────────────────────────┘
```



## 15. System Integration Points

```
┌─────────────────────────────────────────────────────────────────┐
│                    INTEGRATION ARCHITECTURE                     │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  RMS CORE                                                       │
│  ┌────────────────────────────────────────────────────────┐   │
│  │                                                        │   │
│  │                  RMS Application                       │   │
│  │                                                        │   │
│  └────────────────────────────────────────────────────────┘   │
│         │           │           │           │                  │
│         │           │           │           │                  │
│         ▼           ▼           ▼           ▼                  │
│  ┌──────────┐ ┌──────────┐ ┌──────────┐ ┌──────────┐        │
│  │  Google  │ │  Email   │ │   SMS    │ │ WhatsApp │        │
│  │  OAuth   │ │  SMTP    │ │ Gateway  │ │   API    │        │
│  └──────────┘ └──────────┘ └──────────┘ └──────────┘        │
│       │            │            │            │                 │
│       │            │            │            │                 │
│       ▼            ▼            ▼            ▼                 │
│  Authentication  Notifications  Alerts    Messaging           │
│                                                                 │
│  FUTURE INTEGRATIONS (Planned)                                 │
│  ┌────────────────────────────────────────────────────────┐   │
│  │ • LinkedIn OAuth                                       │   │
│  │ • Facebook OAuth                                       │   │
│  │ • GitHub OAuth                                         │   │
│  │ • Calendar Sync (Google Calendar, Outlook)            │   │
│  │ • Video Interview (Zoom, Teams, Meet)                 │   │
│  │ • ATS Integration                                      │   │
│  │ • Payment Gateway                                      │   │
│  └────────────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────────┘
```

