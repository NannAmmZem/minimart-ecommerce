@echo off
echo ========================================
echo   Check and Start Laragon Services
echo ========================================
echo.

echo Checking MySQL service...
echo.

REM Check if MySQL is running on port 3306
netstat -ano | findstr ":3306" >nul 2>&1

if errorlevel 1 (
    echo ❌ MySQL is NOT running
    echo.
    echo Please do ONE of these:
    echo.
    echo OPTION 1: Start Laragon
    echo   1. Open Laragon app
    echo   2. Click "Start All"
    echo   3. Wait for green indicators
    echo.
    echo OPTION 2: Use Supabase ^(Recommended!^)
    echo   1. Open: SUPABASE_QUICK_START.txt
    echo   2. Follow the guide
    echo   3. Never worry about local database again!
    echo.
) else (
    echo ✅ MySQL is running on port 3306
    echo.
    echo Your database connection should work now!
    echo Try accessing: http://127.0.0.1:8000
    echo.
)

echo ========================================
echo   Current Database Configuration
echo ========================================
echo.
findstr /B "DB_" .env 2>nul
echo.

echo ========================================
echo   Recommendations
echo ========================================
echo.
echo For DEVELOPMENT (Local):
echo   ✓ Keep using Laragon MySQL
echo   ✓ Make sure Laragon is running
echo.
echo For DEPLOYMENT (Online):
echo   ✓ Switch to Supabase
echo   ✓ Free 500MB database
echo   ✓ No local server needed
echo   ✓ Works anywhere!
echo.

pause
