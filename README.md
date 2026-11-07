# 🛒 Mini Mart E-Commerce

A complete, modern neighborhood Mini Mart e-commerce website built with **Laravel**, **Custom CSS**, and **MySQL** — optimized for **Laragon**.

![Mini Mart](https://img.shields.io/badge/Laravel-12.x-red?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue?style=flat-square&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0-orange?style=flat-square&logo=mysql)

---

## ✨ Features

### 🏪 Customer Features
- **Modern Homepage:** Hero banner, category grid, featured products
- **Product Catalog:** Filter by category, search, sort by price
- **Product Details:** Full descriptions, stock status, related products
- **Shopping Cart:** Real-time cart updates, delivery fee calculation
- **Smart Checkout:** Address input, time slot selection, payment options
- **Order Management:** Order history, status tracking
- **User Authentication:** Register, login, profile management

### 👨‍💼 Admin Dashboard
- **Dashboard:** Daily statistics, sales overview, low stock alerts
- **Product Management:** Full CRUD, image upload, stock tracking
- **Category Management:** Organize products into categories
- **Order Management:** View and update order status
- **Stock Alerts:** Automatic low stock notifications
- **Secure Access:** Admin-only middleware protection

### 🎨 Design
- **Fresh & Modern:** Clean Mini Mart aesthetic
- **Fully Responsive:** Perfect on mobile, tablet, desktop
- **Custom CSS:** No Bootstrap — pure custom styling
- **Color Scheme:** Fresh Green (#22C55E) & Warm Orange (#F97316)
- **Smooth Animations:** Hover effects, transitions, shadows

---

## 🚀 Quick Start (5 Minutes)

### Prerequisites
- **Laragon** installed (includes PHP 8.2+, MySQL, Composer, Node.js)
- **Browser** (Chrome, Firefox, Edge, Safari)

### Installation

1. **Clone or place project in Laragon's www folder**
   ```
   C:\laragon\www\MiniMart
   ```

2. **Run the Quick Start script**
   ```bash
   # Double-click this file:
   QUICK_START.bat
   ```
   
   The script automatically:
   - Creates MySQL database
   - Runs migrations
   - Seeds sample data (categories, products, users)
   - Links storage directory
   - Builds frontend assets

3. **Configure Virtual Host in Laragon**
   - Open Laragon
   - Menu → Apache → Add Virtual Host
   - Domain: `minimart.test`
   - Directory: `C:\laragon\www\MiniMart\public`
   - Laragon will restart Apache automatically

4. **Start Laragon**
   - Click "Start All" button
   - Wait for services to start

5. **Access Your Site** 🎉
   - **Frontend:** http://minimart.test
   - **Admin:** http://minimart.test/admin

---

## 🔐 Default Credentials

### Admin Account
```
Email: admin@minimart.test
Password: minimart123
```

### Test Customer Account
```
Email: customer@minimart.test
Password: password
```

---

## 📁 Project Structure

```
MiniMart/
├── app/
│   ├── Http/Controllers/          # Application logic
│   │   ├── HomeController.php
│   │   ├── ShopController.php
│   │   ├── CartController.php
│   │   ├── CheckoutController.php
│   │   └── Admin/                 # Admin controllers
│   ├── Models/                    # Database models
│   │   ├── Product.php
│   │   ├── Category.php
│   │   ├── Order.php
│   │   └── OrderItem.php
│   └── Middleware/
│       └── AdminMiddleware.php
├── database/
│   ├── migrations/                # Database schema
│   └── seeders/                   # Sample data
├── public/
│   └── css/
│       └── style.css              # Custom Mini Mart CSS
├── resources/views/
│   ├── layouts/                   # Base templates
│   ├── home.blade.php
│   ├── shop/                      # Product pages
│   ├── cart/
│   ├── checkout/
│   ├── orders/
│   └── admin/                     # Admin dashboard views
└── routes/
    └── web.php
```

---

## 🎯 Sample Data Included

### Categories (6)
- 🍎 Fruits & Vegetables
- 🍿 Snacks & Drinks
- 🥛 Dairy & Eggs
- 🍞 Bread & Pastries
- 🧹 Household Essentials
- 🧴 Personal Care

### Products (16+)
Fresh Bananas, Red Apples, Tomatoes, Cola, Chips, Orange Juice, Milk, Eggs, Cheese, White Bread, Croissants, Dish Soap, Toilet Paper, Hand Soap, Toothpaste, Shampoo, and more!

---

## 💻 Manual Setup (Optional)

If you prefer manual setup instead of the batch script:

### 1. Create Database
```bash
mysql -u root -e "CREATE DATABASE minimart_laragon CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Configure Environment
The `.env` file is pre-configured for Laragon. Verify these settings:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=minimart_laragon
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Run Migrations & Seed
```bash
php artisan migrate
php artisan db:seed
```

### 5. Create Storage Link
```bash
php artisan storage:link
```

### 6. Build Assets
```bash
npm run build
```

### 7. Configure Virtual Host
- Laragon → Menu → Apache → Add Virtual Host
- Domain: `minimart.test`
- Path: `C:\laragon\www\MiniMart\public`

---

## 🔧 Troubleshooting

### Database Connection Error
**Problem:** `SQLSTATE[HY000] [1049] Unknown database`  
**Solution:** 
```bash
mysql -u root -e "CREATE DATABASE minimart_laragon;"
```

### Port 80 Already in Use
**Problem:** Apache can't start  
**Solution:** Change port in Laragon → Apache → Change Port → 8080  
Access site at: `http://minimart.test:8080`

### CSS Not Loading
**Problem:** Styles not appearing  
**Solution:**
```bash
npm run build
php artisan cache:clear
php artisan view:clear
```

### Permission Issues
**Problem:** Storage errors  
**Solution:**
```bash
chmod -R 775 storage bootstrap/cache
```

### Virtual Host Not Working
**Problem:** `minimart.test` doesn't load  
**Solution:**
1. Check `C:\Windows\System32\drivers\etc\hosts` has entry:
   ```
   127.0.0.1 minimart.test
   ```
2. Restart Laragon

---

## 🧪 Testing Guide

### Customer Flow Test
1. Visit http://minimart.test
2. Browse products by category
3. View product details
4. Add items to cart
5. Update cart quantities
6. Register new account
7. Complete checkout
8. View order confirmation

### Admin Flow Test
1. Login at http://minimart.test/admin
2. View dashboard statistics
3. Create new product
4. Edit existing category
5. View and manage orders
6. Update order status
7. Monitor low stock alerts

---

## 📚 Technology Stack

- **Backend:** Laravel 12.x
- **Frontend:** Blade Templates + Custom CSS
- **Database:** MySQL 8.0
- **Authentication:** Laravel Breeze
- **Server:** Apache (Laragon)
- **Package Manager:** Composer, NPM
- **Build Tool:** Vite

---

## 🔐 Security Features

- Admin middleware protection
- CSRF token validation
- Password hashing (bcrypt)
- SQL injection prevention (Eloquent ORM)
- Form validation on all inputs
- Authenticated routes for checkout
- Session-based cart management

---

## 🚢 Production Deployment (Optional)

To prepare for production:

1. **Update Environment**
   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://yourdomain.com
   ```

2. **Optimize Laravel**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan optimize
   ```

3. **Set Permissions**
   ```bash
   chmod -R 755 storage bootstrap/cache
   ```

4. **Configure HTTPS**
   - Set up SSL certificate
   - Update `.env` APP_URL to https://

---

## 📝 License

This project is open-source and available for educational purposes.

---

## 🤝 Contributing

Feel free to fork, modify, and enhance this Mini Mart system!

---

## 📞 Support & Documentation

- **Laravel Docs:** https://laravel.com/docs
- **Laragon Docs:** https://laragon.org/docs
- **Setup Guide:** See `SETUP_GUIDE.md` for detailed instructions

---

## 🎉 You're All Set!

Your neighborhood Mini Mart is ready to serve customers!

**Start selling:** http://minimart.test  
**Manage store:** http://minimart.test/admin

---

**Built with ❤️ for neighborhood stores everywhere** 🛒
