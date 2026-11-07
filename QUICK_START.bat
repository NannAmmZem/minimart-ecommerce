@echo off
echo ====================================
echo Mini Mart - Quick Start Script
echo ====================================
echo.
echo This script will:
echo - Create database
echo - Run migrations
echo - Seed sample data
echo - Create storage link
echo - Build frontend assets
echo - Clear all caches
echo.
echo Press Ctrl+C to cancel, or
pause
echo.

echo [1/7] Creating database...
mysql -u root -e "CREATE DATABASE IF NOT EXISTS minimart_laragon CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
if %errorlevel% neq 0 (
    echo.
    echo ERROR: Could not create database.
    echo Make sure MySQL is running in Laragon.
    echo.
    pause
    exit /b 1
)
echo Database created successfully!
echo.

echo [2/7] Running migrations and seeding data...
echo (This will reset the database)
php artisan migrate:fresh --seed --force
if %errorlevel% neq 0 (
    echo.
    echo ERROR: Migration or seeding failed.
    echo.
    pause
    exit /b 1
)
echo Migrations and seeding completed!
echo.

echo [3/7] Creating storage link...
php artisan storage:link
echo.

echo [4/7] Building frontend assets...
echo (This may take a minute...)
call npm run build
if %errorlevel% neq 0 (
    echo.
    echo WARNING: Asset build failed. You may need to run 'npm install' first.
    echo.
)
echo.

echo [5/7] Clearing configuration cache...
php artisan config:clear
echo.

echo [6/7] Clearing application cache...
php artisan cache:clear
echo.

echo [7/7] Clearing view cache...
php artisan view:clear
echo.

echo ====================================
echo Setup Complete!
echo ====================================
echo.
echo Your Mini Mart database and files are ready!
echo.
echo NEXT STEPS:
echo.
echo 1. Configure Virtual Host in Laragon:
echo    - Right-click Laragon tray icon
echo    - Menu → Apache → Add Virtual Host
echo    - Name: minimart.test
echo    - Path: C:\laragon\www\MiniMart\public
echo.
echo 2. Start Laragon Services:
echo    - Click "Start All" in Laragon
echo.
echo 3. Open your browser:
echo    - Frontend: http://minimart.test
echo    - Admin: http://minimart.test/admin
echo.
echo ====================================
echo LOGIN CREDENTIALS
echo ====================================
echo.
echo Admin Account:
echo    Email: admin@minimart.test
echo    Password: minimart123
echo.
echo Test Customer:
echo    Email: customer@minimart.test  
echo    Password: password
echo.
echo ====================================
echo.
echo See RUN_ALL_COMMANDS.md for detailed instructions.
echo.
pause
