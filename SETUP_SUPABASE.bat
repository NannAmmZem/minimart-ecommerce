@echo off
echo ========================================
echo   Setup Mini Mart with Supabase
echo ========================================
echo.
echo This script will help you migrate to Supabase PostgreSQL
echo.
echo Prerequisites:
echo 1. You've created a Supabase account
echo 2. You've created a new project
echo 3. You have your database credentials ready
echo.
pause
echo.

echo ========================================
echo   Step 1: Install PostgreSQL Driver
echo ========================================
echo.
echo Installing doctrine/dbal package...
call composer require doctrine/dbal
echo.

if errorlevel 1 (
    echo Error installing dependencies!
    pause
    exit /b 1
)

echo.
echo ========================================
echo   Step 2: Database Credentials
echo ========================================
echo.
echo Please provide your Supabase database credentials:
echo (Find these in Supabase Dashboard > Project Settings > Database)
echo.

set /p DB_HOST="Database Host (e.g., db.xxx.supabase.co): "
set /p DB_PASSWORD="Database Password: "

if "%DB_HOST%"=="" (
    echo Error: Host is required!
    pause
    exit /b 1
)

if "%DB_PASSWORD%"=="" (
    echo Error: Password is required!
    pause
    exit /b 1
)

echo.
echo ========================================
echo   Step 3: Update .env File
echo ========================================
echo.
echo Backing up current .env file...
copy .env .env.mysql.backup >nul

echo.
echo Updating database configuration in .env...
echo.

(
    echo # Supabase PostgreSQL Configuration
    echo DB_CONNECTION=pgsql
    echo DB_HOST=%DB_HOST%
    echo DB_PORT=5432
    echo DB_DATABASE=postgres
    echo DB_USERNAME=postgres
    echo DB_PASSWORD=%DB_PASSWORD%
    echo DB_SSLMODE=prefer
) > .env.supabase.tmp

echo.
echo ========================================
echo   Step 4: Test Connection
echo ========================================
echo.
echo Testing database connection...
php artisan config:clear
php artisan migrate:status

if errorlevel 1 (
    echo.
    echo ========================================
    echo   CONNECTION FAILED!
    echo ========================================
    echo.
    echo Please check:
    echo 1. Host is correct
    echo 2. Password is correct
    echo 3. Supabase project is running
    echo 4. Your IP is allowed (Supabase allows all by default)
    echo.
    echo Your original .env is backed up as .env.mysql.backup
    pause
    exit /b 1
)

echo.
echo ========================================
echo   Step 5: Run Migrations
echo ========================================
echo.
set /p MIGRATE="Ready to create tables in Supabase? (y/n): "

if /i "%MIGRATE%"=="y" (
    echo.
    echo Running migrations...
    php artisan migrate:fresh --seed
    
    if errorlevel 1 (
        echo Migration failed!
        pause
        exit /b 1
    )
    
    echo.
    echo ========================================
    echo   SUCCESS!
    echo ========================================
    echo.
    echo Your Mini Mart is now using Supabase!
    echo.
    echo Database: %DB_HOST%
    echo Tables created: users, categories, products, orders, order_items
    echo Sample data: 16 products, 6 categories, 2 users
    echo.
    echo You can view your data at:
    echo https://app.supabase.com
    echo.
    echo Next steps:
    echo 1. Test your application locally
    echo 2. Deploy to Railway/Heroku with Supabase
    echo 3. Your database is now online and accessible anywhere!
    echo.
) else (
    echo.
    echo Skipping migrations. Run manually when ready:
    echo   php artisan migrate:fresh --seed
    echo.
)

echo ========================================
echo   Configuration Files
echo ========================================
echo.
echo Created files:
echo   .env.mysql.backup - Your original MySQL config
echo   .env.supabase.tmp - Supabase credentials
echo.
echo To switch back to MySQL:
echo   copy .env.mysql.backup .env
echo.
echo To use Supabase permanently:
echo   Manually update your .env with values from .env.supabase.tmp
echo.
pause
