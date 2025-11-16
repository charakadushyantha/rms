# Central Database Configuration System

## Overview

Your database configuration is now centralized in a single location, making it easier to manage credentials across all scripts and environments.

## File Structure

```
config/
├── database.php       # Central database configuration
└── load_env.php       # Environment variable loader

.env.example           # Example environment file
.env                   # Your actual environment file (create this)
```

## Quick Start

### 1. Create Your Environment File

```bash
copy .env.example .env
```

Edit `.env` with your database credentials:

```env
DB_ENVIRONMENT=development
DB_HOST=localhost
DB_USER=root
DB_PASS=your_password
DB_NAME=rmsdb
```

### 2. Migrate Existing Scripts

Run the migration script to update all standalone PHP files:

```
http://localhost/your-project/migrate_to_central_config.php
```

This will:
- Update all scripts to use the central config
- Create backups of original files
- Show a summary of changes

### 3. Update CodeIgniter Config

Update `application/config/database.php` to use the central config:

```php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Load central database configuration
require_once FCPATH . 'config/database.php';

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
    'dsn'       => '',
    'hostname'  => DB_HOST,
    'username'  => DB_USER,
    'password'  => DB_PASS,
    'database'  => DB_NAME,
    'dbdriver'  => 'mysqli',
    'dbprefix'  => '',
    'pconnect'  => FALSE,
    'db_debug'  => (ENVIRONMENT !== 'production'),
    'cache_on'  => FALSE,
    'cachedir'  => '',
    'char_set'  => DB_CHARSET,
    'dbcollat'  => DB_COLLATION,
    'swap_pre'  => '',
    'encrypt'   => FALSE,
    'compress'  => FALSE,
    'stricton'  => FALSE,
    'failover'  => array(),
    'save_queries' => TRUE
);
```

## Usage

### In Standalone Scripts

```php
<?php
// Use central database configuration
require_once __DIR__ . '/config/database.php';

// Get connection
$conn = getDatabaseConnection();

// Use the connection
$result = $conn->query("SELECT * FROM users");

// Close when done
$conn->close();
```

### In CodeIgniter Controllers/Models

No changes needed! CodeIgniter will automatically use the updated config.

```php
// In controllers
$this->load->database();
$query = $this->db->query("SELECT * FROM users");

// In models
$this->db->get('users');
```

## Environment Support

The system supports three environments:

### Development (default)
- Uses hardcoded credentials in `config/database.php`
- Good for local development

### Production
- Uses environment variables from `.env` file
- Secure for production servers
- Set `DB_ENVIRONMENT=production` in `.env`

### Testing
- Uses separate test database
- Set `DB_ENVIRONMENT=testing` in `.env`

## Available Functions

### getDatabaseConnection()
Returns a mysqli connection object with error handling.

```php
try {
    $conn = getDatabaseConnection();
    // Use connection
} catch (Exception $e) {
    die("Database error: " . $e->getMessage());
}
```

### getDatabaseConfig()
Returns database configuration as an array.

```php
$config = getDatabaseConfig();
echo "Database: " . $config['database'];
```

### testDatabaseConnection()
Tests if database connection is working.

```php
if (testDatabaseConnection()) {
    echo "Database connection OK";
} else {
    echo "Database connection failed";
}
```

## Security Best Practices

1. **Never commit .env file**
   - Add `.env` to `.gitignore`
   - Only commit `.env.example`

2. **Use environment variables in production**
   - Set `DB_ENVIRONMENT=production`
   - Configure server environment variables

3. **Restrict file permissions**
   ```bash
   chmod 600 .env
   chmod 644 config/database.php
   ```

4. **Use strong passwords**
   - Never use empty passwords in production
   - Use different credentials per environment

## Troubleshooting

### Connection fails after migration

1. Check if `config/database.php` exists
2. Verify credentials in `.env` file
3. Ensure database server is running
4. Check file paths in require_once statements

### Scripts still using old config

1. Run migration script again
2. Manually update any custom scripts
3. Clear any PHP opcode cache

### CodeIgniter not connecting

1. Verify `application/config/database.php` is updated
2. Check FCPATH constant is defined
3. Ensure config file is readable

## Benefits

✓ Single source of truth for database credentials
✓ Easy environment switching (dev/staging/production)
✓ Secure credential management with .env files
✓ Consistent error handling across all scripts
✓ Easy to update credentials (change once, apply everywhere)
✓ Better security (credentials not in version control)

## Migration Checklist

- [ ] Create `.env` file from `.env.example`
- [ ] Run `migrate_to_central_config.php`
- [ ] Update `application/config/database.php`
- [ ] Test standalone scripts
- [ ] Test CodeIgniter application
- [ ] Add `.env` to `.gitignore`
- [ ] Document credentials for team
- [ ] Set up production environment variables

## Support

If you encounter issues:
1. Check the backups in `backups_db_migration/`
2. Review error messages carefully
3. Verify file permissions
4. Test database connection manually
