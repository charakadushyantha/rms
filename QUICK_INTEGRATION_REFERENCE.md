# Quick Integration Reference Card

## 🚀 13 New Integrations Added

### 🎥 Video Platforms (3)
| Platform | Purpose | Key Feature |
|----------|---------|-------------|
| **Zoom** | Video interviews | Auto-recording, waiting room |
| **Microsoft Teams** | Enterprise meetings | Outlook sync, lobby control |
| **Google Meet** | Simple video calls | Calendar sync, Drive recording |

### 📝 Assessment Tools (2)
| Platform | Purpose | Key Feature |
|----------|---------|-------------|
| **HackerRank** | Coding tests | Anti-cheating, custom tests |
| **Codility** | Programming challenges | 50+ languages, plagiarism detection |

### 🔍 Background Checks (3)
| Service | Purpose | Key Feature |
|---------|---------|-------------|
| **Checkr** | Background screening | FCRA-compliant, real-time updates |
| **Sterling** | Professional screening | Employment & education verification |
| **Accurate** | Fast checks | Quick turnaround, custom packages |

### 🔗 ATS Systems (4)
| Platform | Purpose | Key Feature |
|----------|---------|-------------|
| **Greenhouse** | Full ATS sync | Bidirectional, auto-sync |
| **Lever** | Candidate management | Real-time updates |
| **Workday** | HRIS integration | Employee onboarding |
| **BambooHR** | HR system | Profile export, document sync |

---

## 📋 Quick Setup Checklist

- [ ] Run database migration SQL
- [ ] Create 4 model files
- [ ] Create 4 view directories
- [ ] Get API credentials
- [ ] Configure each integration
- [ ] Test connections
- [ ] Train users
- [ ] Go live!

---

## 🔑 API Endpoints Quick Reference

### Video Integrations
```
POST   /Video_integrations/create_meeting
GET    /Video_integrations/test_connection/{platform}
POST   /Video_integrations/webhook/{platform}
```

### Assessment Integrations
```
POST   /Assessment_integrations/send_assessment
GET    /Assessment_integrations/get_results/{id}
POST   /Assessment_integrations/webhook/{platform}
```

### Background Checks
```
POST   /Background_check/initiate_check
GET    /Background_check/get_status/{id}
GET    /Background_check/download_report/{id}
POST   /Background_check/webhook/{service}
```

### ATS Integrations
```
POST   /Ats_integrations/export_candidate
POST   /Ats_integrations/import_candidate
GET    /Ats_integrations/sync_now/{platform}
POST   /Ats_integrations/webhook/{platform}
```

---

## 📊 Database Tables (15 Total)

**Video**: 3 tables | **Assessment**: 3 tables | **Background**: 3 tables | **ATS**: 5 tables | **Common**: 2 tables

---

## 💡 Quick Usage Examples

### Create Zoom Meeting
```php
$this->Video_integrations_model->create_meeting('zoom', $data);
```

### Send HackerRank Test
```php
$this->Assessment_integrations_model->send_assessment('hackerrank', $data);
```

### Start Background Check
```php
$this->Background_check_model->initiate_check($data);
```

### Sync with Greenhouse
```php
$this->Ats_integrations_model->trigger_sync('greenhouse');
```

---

## 🎯 Key Benefits

✅ **Save Time** - Automate repetitive tasks
✅ **Better Hiring** - Objective assessments & verified backgrounds
✅ **Seamless Integration** - Connect with existing tools
✅ **Real-time Updates** - Webhook notifications
✅ **Compliance** - FCRA-compliant background checks
✅ **Analytics** - Track usage and performance

---

## 📞 Need Help?

- **Documentation**: See INTEGRATIONS_GUIDE.md
- **Summary**: See NEW_INTEGRATIONS_SUMMARY.md
- **Support**: support@lankantech.com

---

**Status**: Controllers ✅ | Models ⏳ | Views ⏳ | Database ✅
