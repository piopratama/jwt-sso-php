
# PHP Project Setup with Phinx, Dotenv, and JWT Authentication

## Prerequisites
- Install necessary dependencies via Composer. Check your `composer.json` file for required packages.

## Configuration
1. **Create `phinx.php` File:**
   Set up your configuration to enable database migration capabilities. Ensure you create the necessary folders as specified in this configuration (e.g., `db/migrations` and `db/seeds`).

2. **Database Setup:**
   - Create a new database in MySQL according to your project requirements.

3. **Environment Variables:**
   - All database credentials should be stored in the `.env` file. Use the following PHP code to load these variables:
     ```php
     $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
     $dotenv->load();
     $servername = $_ENV['DB_HOST'];
     ```

## Migration Commands
- **Create Migration:**
  ```bash
  vendor/bin/phinx create MyNewMigration
  ```

- **Migrate Database:**
  ```bash
  vendor/bin/phinx migrate
  ```

- **Rollback Migration:**
  ```bash
  vendor/bin/phinx rollback
  ```

  To specify a target for rollback:
  ```bash
  vendor/bin/phinx rollback -t YYYYMMDDHHMMSS
  ```

## Seeding Database
- **Create Seed File:**
  ```bash
  vendor/bin/phinx seed:create
  ```

- **Run Seed:**
  ```bash
  vendor/bin/phinx seed:run
  ```

## Authentication and Security
- **JWT and Cookies:**
  Utilize JWT for user authentication via a token system. Cookies can store session-like data client-side and can be configured for security and expiry. Add CSRF security as demonstrated.

## Notes
- Ensure to secure your `.env` file and other sensitive configurations from unauthorized access (add it into .gitignore).
