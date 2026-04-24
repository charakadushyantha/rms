# Central Database Configuration Architecture

## System Overview

```
┌─────────────────────────────────────────────────────────────────┐
│                    CENTRAL CONFIGURATION                        │
│                                                                 │
│  ┌──────────────────┐         ┌─────────────────────────┐     │
│  │   .env file      │────────▶│  config/database.php    │     │
│  │  (optional)      │         │  (single source)        │     │
│  │                  │         │                         │     │
│  │ DB_HOST=...      │         │  • DB_HOST              │     │
│  │ DB_USER=...      │         │  • DB_USER              │     │
│  │ DB_PASS=...      │         │  • DB_PASS              │     │
│  │ DB_NAME=...      │         │  • DB_NAME              │     │
│  └──────────────────┘         │  • getDatabaseConnection()│   │
│                                │  • getDatabaseConfig()   │   │
│                                │  • testDatabaseConnection()│ │
│                                └─────────────────────────┘     │
└─────────────────────────────────────────────────────────────────┘
                                    │
                    ┌───────────────┼───────────────┐
                    │               │               │
                    ▼               ▼               ▼
        ┌──────────────────┐ ┌──────────────┐ ┌──────────────────┐
        │  CodeIgniter     │ │  Standalone  │ │  Migration       │
        │  Application     │ │  Scripts     │ │  Scripts         │
        │                  │ │              │ │                  │
        │ • Controllers    │ │ • setup_*.php│ │ • create_*.php   │
        │ • Models         │ │ • insert_*.php│ │ • fix_*.php     │
        │ • Libraries      │ │ • check_*.php│ │ • add_*.php      │
        └──────────────────┘ └──────────────┘ └──────────────────┘
```

## Before vs After

### BEFORE: Scattered Configuration ❌

```
┌─────────────────────┐
│ script1.php         │
│ $host = 'localhost' │
│ $user = 'root'      │
│ $pass = ''          │
│ $db = 'rmsdb'       │
└─────────────────────┘

┌─────────────────────┐
│ script2.php         │
│ $host = 'localhost' │
│ $user = 'root'      │
│ $pass = ''          │
│ $db = 'rmsdb'       │
└─────────────────────┘

┌─────────────────────┐
│ script3.php         │
│ $host = 'localhost' │
│ $user = 'root'      │
│ $pass = ''          │
│ $db = 'rmsdb'       │
└─────────────────────┘

Problem: Need to update 50+ files to change credentials!
```

### AFTER: Centralized Configuration ✅

```
┌──────────────────────────┐
│  config/database.php     │
│  (SINGLE SOURCE)         │
│                          │
│  DB_HOST = 'localhost'   │
│  DB_USER = 'root'        │
│  DB_PASS = ''            │
│  DB_NAME = 'rmsdb'       │
└──────────────────────────┘
            │
            │ require_once
            │
    ┌───────┴────────┐
    │                │
    ▼                ▼
┌─────────┐    ┌─────────┐
│script1  │    │script2  │
│script3  │    │script4  │
│script5  │    │script6  │
└─────────┘    └─────────┘

Solution: Change once, applies everywhere!
```

## Environment Flow

```
┌──────────────────────────────────────────────────────────────┐
│                    ENVIRONMENT DETECTION                     │
└──────────────────────────────────────────────────────────────┘
                            │
                            ▼
                    ┌───────────────┐
                    │ Check .env    │
                    │ DB_ENVIRONMENT│
                    └───────────────┘
                            │
        ┌───────────────────┼───────────────────┐
        │                   │                   │
        ▼                   ▼                   ▼
┌──────────────┐    ┌──────────────┐    ┌──────────────┐
│ development  │    │ production   │    │   testing    │
│              │    │              │    │              │
│ • localhost  │    │ • .env vars  │    │ • test DB    │
│ • root user  │    │ • secure     │    │ • isolated   │
│ • no password│    │ • env vars   │    │ • clean data │
└──────────────┘    └──────────────┘    └──────────────┘
```

## Connection Flow

```
┌─────────────────────────────────────────────────────────────┐
│                    YOUR PHP SCRIPT                          │
└─────────────────────────────────────────────────────────────┘
                            │
                            │ require_once 'config/database.php'
                            ▼
┌─────────────────────────────────────────────────────────────┐
│              config/database.php                            │
│                                                             │
│  1. Load environment variables (if .env exists)            │
│  2. Select configuration based on environment              │
│  3. Define constants (DB_HOST, DB_USER, etc.)              │
│  4. Provide helper functions                               │
└─────────────────────────────────────────────────────────────┘
                            │
                            │ getDatabaseConnection()
                            ▼
┌─────────────────────────────────────────────────────────────┐
│                    MYSQLI CONNECTION                        │
│                                                             │
│  • Automatic error handling                                │
│  • Character set configuration                             │
│  • Connection pooling ready                                │
└─────────────────────────────────────────────────────────────┘
                            │
                            │ return $conn
                            ▼
┌─────────────────────────────────────────────────────────────┐
│              YOUR DATABASE OPERATIONS                       │
│                                                             │
│  $result = $conn->query("SELECT ...");                     │
│  $conn->close();                                           │
└─────────────────────────────────────────────────────────────┘
```

## File Dependencies

```
.env (optional)
  │
  ├─▶ config/load_env.php
  │     │
  │     └─▶ config/database.php
  │           │
  │           ├─▶ application/config/database.php (CodeIgniter)
  │           │     │
  │           │     └─▶ CodeIgniter Application
  │           │
  │           └─▶ Standalone Scripts
  │                 ├─▶ setup_*.php
  │                 ├─▶ create_*.php
  │                 ├─▶ insert_*.php
  │                 └─▶ check_*.php
  │
  └─▶ .gitignore (protects .env)
```

## Security Layers

```
┌─────────────────────────────────────────────────────────────┐
│ Layer 1: Version Control Protection                        │
│ • .env in .gitignore                                       │
│ • Only .env.example committed                              │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│ Layer 2: File Permissions                                  │
│ • .env: 600 (owner read/write only)                        │
│ • config/: 644 (owner write, all read)                     │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│ Layer 3: Environment Separation                            │
│ • Development: Local credentials                           │
│ • Production: Environment variables                        │
│ • Testing: Separate database                               │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│ Layer 4: Connection Security                               │
│ • SSL/TLS support ready                                    │
│ • Character set enforcement                                │
│ • Error handling                                           │
└─────────────────────────────────────────────────────────────┘
```

## Migration Process

```
┌─────────────────────────────────────────────────────────────┐
│ Step 1: Create Central Config                              │
│ • config/database.php                                      │
│ • config/load_env.php                                      │
│ • .env.example                                             │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│ Step 2: Test Configuration                                 │
│ • Run test_central_config.php                              │
│ • Verify all tests pass                                    │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│ Step 3: Backup Existing Files                              │
│ • Automatic backup to backups_db_migration/                │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│ Step 4: Migrate Scripts                                    │
│ • Run migrate_to_central_config.php                        │
│ • Updates all standalone scripts                           │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│ Step 5: Update CodeIgniter                                 │
│ • Run update_codeigniter_config.php                        │
│ • Updates application/config/database.php                  │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│ Step 6: Test Everything                                    │
│ • Test standalone scripts                                  │
│ • Test CodeIgniter application                             │
│ • Verify all database operations work                      │
└─────────────────────────────────────────────────────────────┘
```

## Benefits Summary

```
┌──────────────────────────────────────────────────────────────┐
│                    BEFORE                                    │
├──────────────────────────────────────────────────────────────┤
│ ❌ Credentials in 50+ files                                  │
│ ❌ Hard to update                                            │
│ ❌ Security risk (credentials in git)                        │
│ ❌ No environment support                                    │
│ ❌ Inconsistent error handling                               │
│ ❌ Manual connection management                              │
└──────────────────────────────────────────────────────────────┘

┌──────────────────────────────────────────────────────────────┐
│                     AFTER                                    │
├──────────────────────────────────────────────────────────────┤
│ ✅ Credentials in 1 file                                     │
│ ✅ Update once, applies everywhere                           │
│ ✅ Secure (.env not in git)                                  │
│ ✅ Dev/staging/production support                            │
│ ✅ Consistent error handling                                 │
│ ✅ Automatic connection management                           │
└──────────────────────────────────────────────────────────────┘
```
