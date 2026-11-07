# 🚀 Complete Step-by-Step Commands to Run Mini Mart

Copy and paste these commands in order to get your Mini Mart running.

---

## 📍 Prerequisites Check

```powershell
# Check if you're in the right folder
cd C:\laragon\www\MiniMart

# Verify Laragon services are running
# Open Laragon and click "Start All"
```

---

## 🗄️ Step 1: Create Database

```powershell
# Create the MySQL database
mysql -u root -e "CREATE DATABASE IF NOT EXISTS minimart_laragon CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Verify database was created
mysql -u root -e "SHOW DATABASES LIKE 'minimart_laragon';"
```

**Expected Output:** You should see `minimart_laragon` in the list

---

## 📦 Step 2: Install Dependencies

```powershell
# Install PHP dependencies (Laravel packages)
composer install

# Install Node.js dependencies (for asset compilation)
npm install
```

**Expected Output:** 
- Composer will install ~112 packages
- NPM will install ~168 packages
- This may take 2-3 minutes

---

## 🗃️ Step 3: Run Database Migrations

```powershell
# Drop all tables and recreate them from scratch with sample data
php artisan migrate:fresh --seed --force
```

**Expected Output:**
```
INFO  Preparing database.
INFO  Running migrations.
✓ users table created
✓ categories table created
✓ products table created
✓ orders table created
✓ order_items table created
INFO  Seeding database.
✓ AdminUserSeeder completed
✓ CategorySeeder completed
✓ ProductSeeder completed
```

**What this does:**
- Creates all database tables
- Adds 2 users (1 admin, 1 customer)
- Adds 6 product categories
- Adds 16 sample products

---

## 🔗 Step 4: Create Storage Link

```powershell
# Create symbolic link for image uploads
php artisan storage:link
```

**Expected Output:** 
```
INFO  The [public\storage] link has been connected to [storage\app/public].
```

**What this does:** Allows product images to be accessible from the web

---

## 🎨 Step 5: Build Frontend Assets

```powershell
# Compile CSS and JavaScript
npm run build
```

**Expected Output:**
```
✓ 62 modules transformed.
✓ built in 2.15s
```

**What this does:** Compiles and minifies your CSS and JavaScript files

---

## 🧹 Step 6: Clear All Caches

```powershell
# Clear configuration cache
php artisan config:clear

# Clear application cache
php artisan cache:clear

# Clear view cache
php artisan view:clear

# Clear route cache (if exists)
php artisan route:clear
```

**Expected Output:** 
```
INFO  Configuration cache cleared successfully.
INFO  Application cache cleared successfully.
INFO  Blade views cleared successfully.
```

---

## 🌐 Step 7: Configure Virtual Host in Laragon

**Option A: Using Laragon Menu (RECOMMENDED)**

1. **Right-click Laragon icon** in system tray
2. Click **Menu → Apache → Add Virtual Host**
3. Enter:
   - **Name:** `minimart.test`
   - **Path:** `C:\laragon\www\MiniMart\public`
4. Click **OK**
5. Laragon will restart Apache automatically

**Option B: Manual Configuration**

Open this file in Notepad as Administrator:
```
C:\laragon\etc\apache2\sites-enabled\auto.minimart.test.conf
```

Add this content:
```apache
<VirtualHost *:80>
    DocumentRoot "C:/laragon/www/MiniMart/public"
    ServerName minimart.test
    ServerAlias *.minimart.test
    <Directory "C:/laragon/www/MiniMart/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Then add to hosts file (`C:\Windows\System32\drivers\etc\hosts`):
```
127.0.0.1 minimart.test
```

**Restart Apache:**
```powershell
# In Laragon, click "Reload" or "Restart"
```

---

## ✅ Step 8: Start Laragon Services

1. Open **Laragon** application
2. Click **"Start All"** button
3. Wait for green checkmarks next to:
   - ✅ Apache
   - ✅ MySQL

---

## 🎯 Step 9: Test Your Website

Open your browser and visit:

### **Frontend (Customer Store)**
```
http://minimart.test
```

**What you should see:**
- Hero banner: "Your Neighborhood Mini Mart"
- 6 category cards
- Featured products section
- Navigation bar with cart icon

### **Admin Dashboard**
```
http://minimart.test/admin
```

**Login with:**
- Email: `admin@minimart.test`
- Password: `minimart123`

**What you should see:**
- Dashboard with statistics
- Recent orders list
- Low stock alerts
- Left sidebar navigation

### **Test Customer Account**
```
http://minimart.test/login
```

**Login with:**
- Email: `customer@minimart.test`
- Password: `password`

---

## 🔍 Verification Commands

```powershell
# Check if database has data
php artisan tinker
>>> User::count()
# Should return: 2

>>> Category::count()
# Should return: 6

>>> Product::count()
# Should return: 16

>>> exit
```

---

## 🔧 If Something Goes Wrong

### **Problem: "Page not found" or "Site can't be reached"**

```powershell
# Check if virtual host exists
Get-Content C:\laragon\etc\apache2\sites-enabled\auto.minimart.test.conf

# Check hosts file
Get-Content C:\Windows\System32\drivers\etc\hosts | Select-String "minimart"

# Should see: 127.0.0.1 minimart.test
```

### **Problem: "Database connection error"**

```powershell
# Verify database exists
mysql -u root -e "USE minimart_laragon; SHOW TABLES;"

# Should show 8 tables
```

### **Problem: "Styles not loading" (plain HTML)**

```powershell
# Check if build folder exists
Test-Path public\build

# Rebuild assets
npm run build

# Clear view cache
php artisan view:clear
```

### **Problem: "Storage link error"**

```powershell
# Remove existing link (if any)
Remove-Item public\storage -Force -ErrorAction SilentlyContinue

# Recreate link
php artisan storage:link
```

---

## 🚀 ONE-COMMAND SETUP (All in One)

If you want to run everything at once:

```powershell
# Navigate to project
cd C:\laragon\www\MiniMart

# Run all setup commands
mysql -u root -e "CREATE DATABASE IF NOT EXISTS minimart_laragon CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"; php artisan migrate:fresh --seed --force; php artisan storage:link; npm run build; php artisan config:clear; php artisan cache:clear; php artisan view:clear

# Then configure virtual host in Laragon and restart services
```

---

## 📋 Quick Reference

### **Useful Commands**

```powershell
# Reset database (WARNING: Deletes all data)
php artisan migrate:fresh --seed --force

# Clear all caches
php artisan optimize:clear

# Rebuild assets
npm run build

# View routes
php artisan route:list

# Open database shell
mysql -u root minimart_laragon

# Check application logs
Get-Content storage\logs\laravel.log -Tail 50
```

---

## ✨ Success Indicators

You'll know everything is working when:

1. ✅ `http://minimart.test` shows the homepage
2. ✅ You can see 6 categories on the homepage
3. ✅ "Shop Now" button takes you to products page
4. ✅ You can add products to cart
5. ✅ Cart counter updates in navbar
6. ✅ `http://minimart.test/admin` shows login page
7. ✅ Admin login works and shows dashboard
8. ✅ No console errors in browser (F12)
9. ✅ CSS styles are applied (colors, rounded corners)
10. ✅ Images load (product placeholders show)

---

## 📞 Final Checklist

- [ ] Database `minimart_laragon` exists
- [ ] Migrations completed (8 tables)
- [ ] Seeders completed (2 users, 6 categories, 16 products)
- [ ] Storage link created
- [ ] Assets built (public/build folder exists)
- [ ] Virtual host configured (minimart.test)
- [ ] Laragon services running (green checkmarks)
- [ ] Homepage loads at http://minimart.test
- [ ] Admin dashboard accessible
- [ ] Can login as admin
- [ ] Can browse and add products to cart

---

## 🎉 You're Done!

Your Mini Mart E-Commerce website is now **fully operational**!

**Frontend:** http://minimart.test  
**Admin:** http://minimart.test/admin  

**Admin Login:**
- Email: admin@minimart.test
- Password: minimart123

**Test Customer:**
- Email: customer@minimart.test
- Password: password

---

## 🔄 Daily Development Workflow

When you come back to work on this project:

```powershell
# 1. Start Laragon
# (Click "Start All" in Laragon)

# 2. Navigate to project
cd C:\laragon\www\MiniMart

# 3. If you made changes to CSS/JS
npm run dev
# (Leave this running while developing)

# 4. If you made database changes
php artisan migrate

# 5. Clear caches if needed
php artisan optimize:clear
```

---

**Happy Coding! 🛒✨**
