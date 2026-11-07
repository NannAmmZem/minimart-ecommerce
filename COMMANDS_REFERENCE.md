# 🛒 Mini Mart - Commands Reference

Quick reference for all Laravel and setup commands.

---

## 🗄️ Database Commands

### Create Database
```bash
# MySQL Console
mysql -u root -e "CREATE DATABASE minimart_laragon CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### Run Migrations
```bash
# Run all pending migrations
php artisan migrate

# Run with force (skip confirmation)
php artisan migrate --force

# Rollback last migration
php artisan migrate:rollback

# Reset and re-run all migrations
php artisan migrate:fresh

# Reset and re-run with seeding
php artisan migrate:fresh --seed
```

### Seeding
```bash
# Run all seeders
php artisan db:seed

# Run specific seeder
php artisan db:seed --class=AdminUserSeeder
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=ProductSeeder

# Force seed (production)
php artisan db:seed --force
```

---

## 🔧 Setup Commands

### First Time Setup
```bash
# 1. Install PHP dependencies
composer install

# 2. Install Node dependencies
npm install

# 3. Create database
mysql -u root -e "CREATE DATABASE minimart_laragon;"

# 4. Run migrations
php artisan migrate

# 5. Seed database
php artisan db:seed

# 6. Create storage link
php artisan storage:link

# 7. Build assets
npm run build
```

### Quick Reset (Start Fresh)
```bash
php artisan migrate:fresh --seed --force
```

---

## 🎨 Frontend Asset Commands

### Build Assets
```bash
# Production build (minified)
npm run build

# Development build (fast)
npm run dev

# Watch mode (auto-rebuild)
npm run dev
```

---

## 🧹 Cache Commands

### Clear Caches
```bash
# Clear all caches
php artisan cache:clear

# Clear config cache
php artisan config:clear

# Clear route cache
php artisan route:clear

# Clear view cache
php artisan view:clear

# Clear compiled classes
php artisan clear-compiled

# Clear everything at once
php artisan optimize:clear
```

### Create Caches (Production)
```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize everything
php artisan optimize
```

---

## 📁 Storage Commands

### Storage Link
```bash
# Create symbolic link (first time)
php artisan storage:link

# If link exists, remove and recreate
Remove-Item public\storage
php artisan storage:link
```

---

## 🔑 Key Generation

### Application Key
```bash
# Generate new APP_KEY
php artisan key:generate

# Force generation (production)
php artisan key:generate --force
```

---

## 🛠️ Artisan Make Commands

### Create New Files
```bash
# Model
php artisan make:model Product

# Controller
php artisan make:controller ProductController

# Migration
php artisan make:migration create_products_table

# Seeder
php artisan make:seeder ProductSeeder

# Middleware
php artisan make:middleware AdminMiddleware

# Request (Form validation)
php artisan make:request StoreProductRequest

# Resource (API)
php artisan make:resource ProductResource
```

---

## 🧪 Testing Commands

### Run Tests
```bash
# Run all tests
php artisan test

# Run with coverage
php artisan test --coverage

# Run specific test
php artisan test --filter=ProductTest
```

---

## 🔍 Debugging Commands

### Tinker (Interactive Shell)
```bash
# Open Tinker
php artisan tinker

# Example queries in Tinker:
>>> User::count()
>>> Product::where('in_stock', true)->get()
>>> Category::with('products')->find(1)
>>> Order::latest()->first()
```

### List Routes
```bash
# All routes
php artisan route:list

# Filter routes
php artisan route:list --name=admin
php artisan route:list --path=products
```

### Database Info
```bash
# Show database status
php artisan db:show

# Show table info
php artisan db:table users
php artisan db:table products
```

---

## 📊 Queue Commands

### Queue Workers
```bash
# Process queue jobs
php artisan queue:work

# Process single job
php artisan queue:work --once

# Retry failed jobs
php artisan queue:retry all
```

---

## 👤 User Management Commands

### Create Admin (Manual)
```bash
php artisan tinker

>>> $user = new App\Models\User();
>>> $user->name = 'New Admin';
>>> $user->email = 'newadmin@minimart.test';
>>> $user->password = Hash::make('password');
>>> $user->role = 'admin';
>>> $user->save();
```

---

## 🌐 Server Commands

### Local Development Server
```bash
# Start built-in server
php artisan serve

# Custom host and port
php artisan serve --host=192.168.1.100 --port=8080

# Note: Use Laragon instead for this project
```

---

## 📝 Logging Commands

### View Logs
```bash
# Tail logs in real-time
php artisan pail

# Laravel log location
Get-Content storage\logs\laravel.log -Tail 50
```

---

## 🔐 Permission Commands (Windows)

### Fix Storage Permissions
```bash
# Windows (if needed)
icacls storage /grant Everyone:(OI)(CI)F /T
icacls bootstrap\cache /grant Everyone:(OI)(CI)F /T
```

---

## 🚀 Production Deployment Commands

### Prepare for Production
```bash
# 1. Set environment
# Edit .env:
# APP_ENV=production
# APP_DEBUG=false

# 2. Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# 3. Build assets
npm run build

# 4. Migrate (if needed)
php artisan migrate --force

# 5. Clear logs
Remove-Item storage\logs\*.log
```

---

## 🔄 Maintenance Mode

### Enable/Disable Maintenance
```bash
# Enable maintenance mode
php artisan down

# Enable with secret bypass
php artisan down --secret="mini-mart-2024"
# Access: http://minimart.test/mini-mart-2024

# Disable maintenance mode
php artisan up
```

---

## 📦 Composer Commands

### Dependency Management
```bash
# Install dependencies
composer install

# Update dependencies
composer update

# Update specific package
composer update laravel/framework

# Dump autoload
composer dump-autoload

# Show installed packages
composer show
```

---

## 🌍 NPM Commands

### Package Management
```bash
# Install dependencies
npm install

# Update packages
npm update

# Check for outdated packages
npm outdated

# Install specific package
npm install axios
```

---

## 🗃️ Backup Commands (Manual)

### Database Backup
```bash
# Export database
mysqldump -u root minimart_laragon > backup_$(Get-Date -Format "yyyy-MM-dd").sql

# Import database
mysql -u root minimart_laragon < backup_2024-11-07.sql
```

### File Backup
```bash
# Backup uploaded files
Copy-Item -Path "storage\app\public" -Destination "backup\storage" -Recurse
```

---

## 🆘 Troubleshooting Commands

### Common Issues

#### Clear Everything
```bash
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear
composer dump-autoload
npm run build
```

#### Database Issues
```bash
# Drop and recreate
mysql -u root -e "DROP DATABASE IF EXISTS minimart_laragon; CREATE DATABASE minimart_laragon;"
php artisan migrate:fresh --seed
```

#### Permission Issues
```bash
# Windows - Grant full access
icacls storage /grant Everyone:(OI)(CI)F /T
icacls bootstrap /grant Everyone:(OI)(CI)F /T
```

#### CSS Not Loading
```bash
# Rebuild assets
npm run build

# Clear view cache
php artisan view:clear

# Check public/build folder exists
Test-Path public\build
```

---

## 🎯 Quick Start Commands (All-in-One)

### Complete Fresh Setup
```bash
# Run this batch file:
QUICK_START.bat

# Or manually:
mysql -u root -e "CREATE DATABASE IF NOT EXISTS minimart_laragon;"
php artisan migrate:fresh --seed --force
php artisan storage:link
npm run build
php artisan config:clear
php artisan cache:clear
```

---

## 📱 Useful PowerShell Aliases

### Create Shortcuts
```powershell
# Add to PowerShell profile
function art { php artisan $args }
function migrate { php artisan migrate $args }
function seed { php artisan db:seed $args }
function fresh { php artisan migrate:fresh --seed --force }
function cc { php artisan optimize:clear }
```

Usage after aliases:
```powershell
art migrate
art db:seed
fresh
cc
```

---

## 🔍 Database Query Commands

### Quick Database Checks
```bash
# Count records
php artisan tinker
>>> User::count()
>>> Product::count()
>>> Order::count()

# Find admin
>>> User::where('role', 'admin')->first()

# Products in stock
>>> Product::where('in_stock', true)->count()

# Recent orders
>>> Order::latest()->take(5)->get()
```

---

## 🎨 Development Workflow

### Typical Development Session
```bash
# 1. Pull latest changes (if team)
git pull

# 2. Install/update dependencies
composer install
npm install

# 3. Migrate any new changes
php artisan migrate

# 4. Clear caches
php artisan optimize:clear

# 5. Start asset watcher
npm run dev

# 6. Start Laragon
# (Use Laragon GUI)

# 7. Make changes...

# 8. Build for production
npm run build

# 9. Test
php artisan test

# 10. Commit
git add .
git commit -m "Feature: Add new product filter"
git push
```

---

## 📝 Notes

- Always run `php artisan` commands from project root
- Use `--force` flag in production to skip confirmations
- Clear caches after .env changes
- Rebuild assets after CSS/JS changes
- Run migrations before seeding
- Backup database before major migrations

---

**Need help?** Check the full setup guide in `SETUP_GUIDE.md`
