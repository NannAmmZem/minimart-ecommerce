# 🛒 Mini Mart E-Commerce - Setup Guide for Laragon

## Overview
A complete, modern Mini Mart e-commerce website built with Laravel, custom CSS, and MySQL. Designed specifically for neighborhood stores with a fresh, friendly design.

---

## 📋 Requirements
- **Laragon** (with PHP 8.2+, MySQL, Composer)
- **Node.js & NPM** (included in Laragon)
- **Browser** (Chrome, Firefox, Edge, Safari)

---

## 🚀 Step-by-Step Setup Instructions

### 1️⃣ Create Database
1. Open **Laragon**
2. Click **Menu** → **MySQL** → **MySQL Console** (or use HeidiSQL)
3. Run the following command:
   ```sql
   CREATE DATABASE minimart_laragon CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

### 2️⃣ Install Dependencies
Open terminal in project root (`C:\laragon\www\MiniMart`) and run:

```bash
# Install PHP dependencies
composer install

# Install Node dependencies  
npm install
```

### 3️⃣ Configure Environment
The `.env` file is already configured for Laragon:

```env
APP_NAME="Mini Mart"
APP_URL=http://minimart.test
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=minimart_laragon
DB_USERNAME=root
DB_PASSWORD=
```

### 4️⃣ Run Migrations & Seeders
```bash
# Run database migrations
php artisan migrate

# Seed the database with sample data
php artisan db:seed
```

This will create:
- 6 product categories
- 16 sample products
- Admin user account
- Customer user account

### 5️⃣ Create Storage Link
```bash
php artisan storage:link
```

### 6️⃣ Setup Virtual Host in Laragon

**Option A: Automatic (Recommended)**
1. In Laragon, click **Menu** → **Apache** → **Add Virtual Host**
2. Enter domain: `minimart.test`
3. Select directory: `C:\laragon\www\MiniMart\public`
4. Laragon will auto-configure and restart Apache

**Option B: Manual**
1. Right-click Laragon → **Preferences** → **General**
2. Ensure "Auto virtual hosts" is enabled
3. Laragon should auto-detect the `MiniMart` folder and create `minimart.test`

### 7️⃣ Start Laragon Services
1. Click **Start All** in Laragon
2. Wait for MySQL and Apache to start (green indicators)

### 8️⃣ Build Frontend Assets
```bash
# Build CSS/JS assets
npm run build

# OR for development with hot reload
npm run dev
```

### 9️⃣ Access the Website

**Frontend (Customer Store):**
- URL: http://minimart.test
- Browse products, add to cart, place orders

**Admin Dashboard:**
- URL: http://minimart.test/admin
- Email: `admin@minimart.test`
- Password: `minimart123`

**Test Customer Account:**
- Email: `customer@minimart.test`
- Password: `password`

---

## 🎯 Default Admin Credentials

```
Email: admin@minimart.test
Password: minimart123
```

---

## 📁 Project Structure

```
MiniMart/
├── app/
│   ├── Http/
│   │   ├── Controllers/           # Frontend controllers
│   │   │   ├── HomeController.php
│   │   │   ├── ShopController.php
│   │   │   ├── CartController.php
│   │   │   ├── CheckoutController.php
│   │   │   └── OrderController.php
│   │   └── Admin/                 # Admin controllers
│   │       ├── DashboardController.php
│   │       ├── ProductController.php
│   │       ├── CategoryController.php
│   │       └── OrderController.php
│   ├── Models/                    # Eloquent models
│   │   ├── User.php
│   │   ├── Product.php
│   │   ├── Category.php
│   │   ├── Order.php
│   │   └── OrderItem.php
│   └── Middleware/
│       └── AdminMiddleware.php    # Admin access protection
├── database/
│   ├── migrations/                # Database schema
│   └── seeders/                   # Sample data
│       ├── CategorySeeder.php
│       ├── ProductSeeder.php
│       └── AdminUserSeeder.php
├── resources/
│   └── views/
│       ├── layouts/               # Base templates
│       │   ├── app.blade.php      # Frontend layout
│       │   └── admin.blade.php    # Admin layout
│       ├── home.blade.php         # Homepage
│       ├── shop/                  # Product pages
│       ├── cart/                  # Shopping cart
│       ├── checkout/              # Checkout process
│       ├── orders/                # Customer orders
│       └── admin/                 # Admin views
├── public/
│   └── css/
│       └── style.css              # Custom CSS (Fresh Mini Mart design)
├── routes/
│   └── web.php                    # Application routes
└── .env                           # Environment configuration
```

---

## ✨ Features

### 🏪 Customer Frontend
- **Home Page:** Hero banner, category grid, featured products
- **Shop:** Filter by category, search, sort by price
- **Product Detail:** Full product info, quantity selector, related products
- **Shopping Cart:** Update quantity, calculate delivery fee
- **Checkout:** Delivery details, time slot selection, payment method
- **Order Tracking:** View order history and status
- **User Authentication:** Register, login, profile management

### 👨‍💼 Admin Dashboard
- **Dashboard Overview:** Today's stats, sales, low stock alerts
- **Product Management:** CRUD operations, stock tracking, image upload
- **Category Management:** Create and organize product categories
- **Order Management:** View orders, update status (pending → delivered)
- **Stock Management:** Quick view of low-stock items
- **Secure Access:** Admin-only middleware protection

---

## 🎨 Design Features
- **Color Palette:**
  - Primary: Fresh Green (#22C55E)
  - Accent: Warm Orange (#F97316)
  - Clean neutrals (white, gray tones)
- **Responsive:** Mobile-friendly design
- **Modern UI:** Rounded corners, smooth shadows, hover effects
- **Clean Typography:** System fonts, easy readability
- **Intuitive Navigation:** Sticky navbar, clear structure

---

## 🔧 Common Troubleshooting

### Port Already in Use
If Apache port 80 is taken:
1. Right-click Laragon → **Apache** → **Change Port**
2. Use port 8080 or another available port
3. Access site at: `http://minimart.test:8080`

### Database Connection Error
1. Verify MySQL is running in Laragon
2. Check database name: `minimart_laragon` exists
3. Confirm `.env` credentials match

### CSS Not Loading
```bash
# Rebuild assets
npm run build

# Clear Laravel cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Permission Issues
```bash
# Fix storage permissions (if needed)
chmod -R 775 storage bootstrap/cache
```

### Images Not Uploading
Make sure storage link exists:
```bash
php artisan storage:link
```

---

## 📝 Testing the Application

### 1. Customer Flow
1. Visit http://minimart.test
2. Browse categories and products
3. Add items to cart
4. Register/Login as customer
5. Complete checkout with delivery details
6. View order confirmation

### 2. Admin Flow
1. Login at http://minimart.test/admin
2. View dashboard statistics
3. Create/edit products and categories
4. Manage orders (update status)
5. Monitor low stock alerts

---

## 🔐 Security Notes
- Admin access is protected by `AdminMiddleware`
- Passwords are hashed using Laravel's bcrypt
- CSRF protection enabled on all forms
- Form validation on all inputs
- SQL injection protection via Eloquent ORM

---

## 🚢 Going Production (Optional)

### Set Production Environment
1. Update `.env`:
   ```env
   APP_ENV=production
   APP_DEBUG=false
   ```
2. Optimize Laravel:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan optimize
   ```

---

## 📞 Support
For issues or questions, check:
- Laravel Docs: https://laravel.com/docs
- Laragon Docs: https://laragon.org/docs

---

## 📄 License
This is a sample project for demonstration purposes.

---

**🎉 Your Mini Mart E-Commerce site is now ready!**  
**Visit http://minimart.test and start shopping!**
