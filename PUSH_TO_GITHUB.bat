@echo off
echo ========================================
echo   Push Mini Mart to GitHub
echo ========================================
echo.
echo Your Git is configured as:
echo   Name: NannAmmZem
echo   Email: nannammzem7383@gmail.com
echo.
echo ========================================
echo   INSTRUCTIONS
echo ========================================
echo.
echo 1. Create a repository on GitHub:
echo    - Go to: https://github.com/new
echo    - Name: minimart-ecommerce
echo    - Don't initialize with README
echo.
echo 2. Copy your repository URL from GitHub
echo    Example: https://github.com/YOUR_USERNAME/minimart-ecommerce.git
echo.
echo ========================================
echo.
set /p REPO_URL="Paste your GitHub repository URL here: "
echo.

if "%REPO_URL%"=="" (
    echo Error: No URL provided!
    pause
    exit /b 1
)

echo.
echo Adding remote and pushing to GitHub...
echo.

git remote add origin %REPO_URL%
if errorlevel 1 (
    echo Remote might already exist, trying to update...
    git remote set-url origin %REPO_URL%
)

git branch -M main
git push -u origin main

echo.
if errorlevel 1 (
    echo ========================================
    echo   PUSH FAILED
    echo ========================================
    echo.
    echo Common issues:
    echo   - Repository already exists on GitHub
    echo   - Authentication required ^(use Personal Access Token^)
    echo   - Wrong repository URL
    echo.
    echo To create a Personal Access Token:
    echo   1. Go to: https://github.com/settings/tokens
    echo   2. Generate new token ^(classic^)
    echo   3. Select 'repo' scope
    echo   4. Use token as password when prompted
    echo.
) else (
    echo ========================================
    echo   SUCCESS!
    echo ========================================
    echo.
    echo Your Mini Mart project is now on GitHub!
    echo.
    echo View it at: %REPO_URL:.git=%
    echo.
    echo Next steps:
    echo   - Add a nice README.md
    echo   - Set up GitHub Pages for documentation
    echo   - Add repository topics: laravel, ecommerce, php
    echo.
)

echo.
pause
