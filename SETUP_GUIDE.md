# FlowCheck MVP - Complete Setup Guide

## Table of Contents
1. [System Requirements](#system-requirements)
2. [Local Development Setup](#local-development-setup)
3. [Database Configuration](#database-configuration)
4. [Running the Application](#running-the-application)
5. [Demo Credentials](#demo-credentials)
6. [Development Workflow](#development-workflow)
7. [Troubleshooting](#troubleshooting)

---

## System Requirements

### Minimum Requirements
- **PHP 8.2** or higher
- **MySQL 8.0** or higher
- **Node.js 18+** and npm 9+
- **Composer 2.5+**
- 2GB RAM (development)
- 500MB disk space

### Recommended Development Environment
- **Windows:** WSL2 + Ubuntu 22.04 LTS
- **macOS:** M1/M2 with Homebrew
- **Linux:** Ubuntu 22.04 LTS

### Optional but Recommended
- Docker Desktop (for MySQL container)
- Git for version control
- VS Code with PHP & Blade extensions
- Postman or Insomnia (for API testing)

---

## Local Development Setup

### Step 1: Install PHP and Composer

**Windows (using Laravel Installer):**
```bash
composer global require laravel/installer
```

**macOS (using Homebrew):**
```bash
brew install php php-ctype php-curl php-dom php-fileinfo php-filter php-hash php-json php-mbstring php-openssl php-pdo php-tokenizer php-xml
brew install mysql
brew install composer
```

**Linux (Ubuntu):**
```bash
sudo apt-get update
sudo apt-get install php8.2 php8.2-common php8.2-cli php8.2-curl php8.2-fileinfo php8.2-gd php8.2-json php8.2-mbstring php8.2-mysql php8.2-xml php8.2-zip
sudo apt-get install mysql-server composer
```

### Step 2: Verify Installations

```bash
php --version
# PHP 8.2.x or higher ✓

composer --version
# Composer 2.5.x or higher ✓

node --version
# v18.0.0 or higher ✓

npm --version
# 9.0.0 or higher ✓

mysql --version
# mysql  Ver 8.0.x ✓
```

### Step 3: Clone/Setup Project

```bash
cd c:\Users\XPS\Desktop\flowcheck.ai
# or navigate to your project directory
```

### Step 4: Install Dependencies

```bash
# Install PHP packages
composer install

# Install Node packages
npm install
```

This will take 5-10 minutes depending on your internet connection.

---

## Database Configuration

### Option A: Use Docker (Recommended)

1. **Install Docker Desktop:** https://www.docker.com/products/docker-desktop

2. **Start MySQL container:**
```bash
docker run --name flowcheck_mysql \
  -e MYSQL_ROOT_PASSWORD=root \
  -e MYSQL_DATABASE=flowcheck \
  -p 3306:3306 \
  -d mysql:8.0
```

3. **Verify connection:**
```bash
mysql -h 127.0.0.1 -u root -proot -e "SELECT VERSION();"
```

### Option B: Local MySQL Installation

**Windows (via MySQL Installer):**
- Download: https://dev.mysql.com/downloads/windows/installer/
- Run installer, select default settings
- Note: password set during installation

**macOS (via Homebrew):**
```bash
brew services start mysql
mysql_secure_installation
# Follow prompts (no root password recommended for dev)
```

**Linux (Ubuntu):**
```bash
sudo systemctl start mysql
sudo mysql_secure_installation
```

### Configure .env File

1. **Copy environment template:**
```bash
cp .env.example .env
```

2. **Edit `.env` with your database credentials:**
```env
# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=flowcheck
DB_USERNAME=root
DB_PASSWORD=  # leave empty if no password, or enter your password

# Mail Configuration (for development, use 'log')
MAIL_MAILER=log
MAIL_HOST=mailpit
MAIL_PORT=1025

# Application
APP_NAME=FlowCheck
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# SI 68 Compliance (Zambian regulation)
SI68_COMPLIANCE_MODE=true
GOOGLE2FA_ENABLED=false  # Can enable for testing MFA
CURRENCY_DEFAULT=ZMW
```

3. **Test database connection:**
```bash
php artisan migrate:fresh
# If successful, you'll see "Migration table created successfully"
```

---

## Running the Application

### Step 1: Generate Application Key

```bash
php artisan key:generate
# Application key set successfully.
```

### Step 2: Run Database Migrations

```bash
php artisan migrate
# Migrating: 2024_01_01_000000_create_plans_table
# Migrated:  2024_01_01_000000_create_plans_table (0.12s)
# ... (25 migrations total)
```

### Step 3: Seed Demo Data

```bash
php artisan db:seed
# Seeding: RolesAndPermissionsSeeder
# Seeded:  RolesAndPermissionsSeeder
# Seeding: PlanSeeder
# Seeded:  PlanSeeder
# Seeding: DemoDataSeeder
# Seeded:  DemoDataSeeder
```

### Step 4: Build Frontend Assets

**Development mode (with hot reload):**
```bash
npm run dev
# VITE v5.0.0  ready in 234 ms
# ➜  Local:   http://localhost:5173/
```

**Production build:**
```bash
npm run build
# ✓ 1234 modules transformed in 2345ms
```

### Step 5: Start Laravel Development Server

**In a new terminal window:**
```bash
php artisan serve
# INFO  Server running on [http://127.0.0.1:8000].
```

---

## Demo Credentials

After running seeders, you can login with these test accounts:

### Super Admin (Platform)
- **Email:** `admin@copperbelt.test`
- **Password:** `password`
- **Role:** Organisation Admin
- **Access:** Full dashboard, user management, settings

### Procurement Officer
- **Email:** `jane@copperbelt.test`
- **Password:** `password`
- **Role:** Procurement Officer
- **Access:** Create POs, manage vendors, create RFQs

### Approver / Manager
- **Email:** `bob@copperbelt.test`
- **Password:** `password`
- **Role:** Approver
- **Access:** Approve/reject purchase requests

### CFO / Finance
- **Email:** `alice@copperbelt.test`
- **Password:** `password`
- **Role:** CFO
- **Access:** Final approval, invoice sign-off, reporting

### Test Organisation
- **Name:** Copperbelt Mining Co
- **Slug:** copperbelt-mining
- **Plan:** Enterprise
- **Industry:** Mining
- **Currency:** ZMW

---

## Development Workflow

### Common Development Tasks

#### 1. Create a New Model
```bash
php artisan make:model Models/NewModel -m
# Creates: app/Models/NewModel.php and database/migrations/...
```

#### 2. Create a New Migration
```bash
php artisan make:migration create_table_name_table
# Creates: database/migrations/YYYY_MM_DD_HHMMSS_create_table_name_table.php
```

#### 3. Create a New Controller
```bash
php artisan make:controller Web/NewController
# Creates: app/Http/Controllers/Web/NewController.php
```

#### 4. Create a New Policy
```bash
php artisan make:policy Models/NewModel
# Creates: app/Policies/NewModelPolicy.php
```

#### 5. Create a New Form Request
```bash
php artisan make:request StoreNewModelRequest
# Creates: app/Http/Requests/StoreNewModelRequest.php
```

#### 6. Create a Service Class
```bash
php artisan make:class Services/NewService
# Creates: app/Services/NewService.php
```

### Running Tests

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/PurchaseRequestTest.php

# Run with output
php artisan test --verbose

# Generate coverage report
php artisan test --coverage
```

### Database Management

```bash
# Fresh migration (wipes all data)
php artisan migrate:fresh

# Migrate with seeders
php artisan migrate:fresh --seed

# Rollback last batch
php artisan migrate:rollback

# Rollback all
php artisan migrate:reset

# Refresh and seed
php artisan migrate:refresh --seed
```

### Debugging

```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Generate IDE helper (for autocomplete)
php artisan ide-helper:generate

# Check routes
php artisan route:list

# Check migrations status
php artisan migrate:status
```

---

## Troubleshooting

### "Class 'PDO' not found"
**Solution:** Install PHP PDO extension
```bash
# Windows: Enable in php.ini - uncomment extension=pdo_mysql
# macOS: brew install php@8.2 php@8.2-mysql
# Linux: sudo apt-get install php8.2-mysql
```

### "SQLSTATE[HY000]: General error: 1030 Got error"
**Solution:** Check MySQL is running
```bash
# Check MySQL status
mysql -u root -p -e "SELECT 1"

# Restart MySQL
# Docker: docker restart flowcheck_mysql
# macOS: brew services restart mysql
# Linux: sudo systemctl restart mysql
```

### "Access denied for user 'root'@'localhost'"
**Solution:** Update .env DB credentials
```env
DB_USERNAME=root
DB_PASSWORD=your_actual_password
```

### Port 8000 already in use
**Solution:** Use different port
```bash
php artisan serve --port=8001
```

### npm/node not found
**Solution:** Install Node.js
- **Windows/macOS:** https://nodejs.org (LTS version)
- **Linux:** `sudo apt-get install nodejs npm`

### Vite port already in use
**Solution:** Kill existing process or use different port
```bash
# Kill process on port 5173
lsof -ti:5173 | xargs kill -9

# Or run on different port
npm run dev -- --port 5174
```

### "The database driver PDO is not installed"
**Solution:** Verify DB_CONNECTION in .env
```env
DB_CONNECTION=mysql  # Not pgsql or sqlite
```

### Redis/Cache issues in production
**Solution:** For MVP, use database driver (already configured)
```env
CACHE_DRIVER=file
QUEUE_CONNECTION=database
```

---

## What's Next?

### Immediate Development Tasks

1. ✅ **Core infrastructure** - Migrations, models, services
2. 🔄 **Complete views** - Purchase request UI, invoice management, dashboards
3. 🔄 **GRN mobile UI** - Mobile-friendly goods receipt
4. 🔄 **Vendor portal** - Separate login for external vendors
5. 🔄 **PDF generation** - PO and BOQ exports

### Testing
- Write unit tests for business logic
- Write feature tests for workflows
- Test 3-way matching edge cases

### Performance
- Add pagination to data tables
- Implement caching for dashboards
- Optimize database queries (eager loading)

### Deployment
- Set up GitHub Actions CI/CD
- Configure staging environment
- Prepare production environment

---

## Getting Help

### Resources
- **Laravel Docs:** https://laravel.com/docs
- **Tailwind Docs:** https://tailwindcss.com/docs
- **Spatie Permission:** https://spatie.be/docs/laravel-permission
- **DomPDF:** https://github.com/barryvdh/laravel-dompdf

### Common Issues
Check `storage/logs/laravel.log` for detailed error messages:
```bash
tail -f storage/logs/laravel.log
```

---

**Estimated time to complete all setup:** 30-45 minutes
