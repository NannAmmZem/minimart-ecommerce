# 🛒 Mini Mart E-Commerce Website

A complete, modern e-commerce platform built with Laravel 12.x, featuring a customer shopping experience and comprehensive admin dashboard.

![Laravel](https://img.shields.io/badge/Laravel-12.x-red?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue?style=flat-square&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-orange?style=flat-square&logo=mysql)
![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)

## ✨ Features

### 🛍️ Customer Features
- **Product Browsing** - View products by category with search and filtering
- **Shopping Cart** - Add, update, and remove items with real-time total calculation
- **Checkout System** - Simple and secure checkout process
- **Order Tracking** - View order history and status
- **User Authentication** - Register, login, and manage account
- **Responsive Design** - Works perfectly on desktop, tablet, and mobile

### 👨‍💼 Admin Dashboard
- **Product Management** - Create, edit, delete products with image support
- **Category Management** - Organize products into categories
- **Order Management** - View and update order statuses
- **Dashboard Analytics** - Overview of sales, orders, and products
- **User Management** - Admin and customer role separation

## 🚀 Tech Stack

- **Framework**: Laravel 12.x
- **Authentication**: Laravel Breeze
- **Database**: MySQL
- **Frontend**: Blade Templates + Custom CSS (no framework dependencies)
- **Local Development**: Laragon (Windows)

## 📦 Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- MySQL 8.0 or higher
- Node.js & NPM

### Quick Start

1. **Clone the repository**
   ```bash
   git clone https://github.com/YOUR_USERNAME/minimart-ecommerce.git
   cd minimart-ecommerce
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Set up environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database**
   
   Edit `.env` file:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=minimart_laragon
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Run migrations and seed database**
   ```bash
   php artisan migrate:fresh --seed
   ```

7. **Create storage link**
   ```bash
   php artisan storage:link
   ```

8. **Build assets**
   ```bash
   npm run build
   ```

9. **Start development server**
   ```bash
   php artisan serve
   ```

10. **Access the application**
    - Website: `http://localhost:8000`
    - Admin Panel: `http://localhost:8000/admin`

## 👤 Default Accounts

### Admin Account
- **Email**: admin@minimart.test
- **Password**: minimart123

### Customer Account
- **Email**: customer@minimart.test
- **Password**: password

## 📁 Project Structure

```
minimart-ecommerce/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Admin dashboard controllers
│   │   │   ├── Auth/           # Authentication controllers
│   │   │   ├── CartController.php
│   │   │   ├── CheckoutController.php
│   │   │   ├── HomeController.php
│   │   │   ├── OrderController.php
│   │   │   └── ShopController.php
│   │   └── Middleware/
│   │       └── AdminMiddleware.php
│   └── Models/
│       ├── Category.php
│       ├── Order.php
│       ├── OrderItem.php
│       ├── Product.php
│       └── User.php
├── database/
│   ├── migrations/             # Database schema
│   └── seeders/                # Sample data
├── public/
│   └── css/
│       └── style.css           # Custom styling
├── resources/
│   └── views/
│       ├── admin/              # Admin views
│       ├── auth/               # Authentication views
│       ├── cart/               # Shopping cart
│       ├── checkout/           # Checkout process
│       ├── layouts/            # Layout templates
│       ├── orders/             # Order views
│       └── shop/               # Product browsing
└── routes/
    └── web.php                 # Application routes
```

## 🗄️ Database Schema

### Tables
- **users** - User accounts with role-based access (admin/customer)
- **categories** - Product categories
- **products** - Product catalog with pricing and stock
- **orders** - Customer orders with status tracking
- **order_items** - Individual items in each order

### Sample Data Included
- 16 products across 6 categories
- 2 user accounts (admin + customer)
- Categories: Fresh Produce, Bakery, Beverages, Snacks, Household, Personal Care

## 🎨 Design

The application features a custom CSS design with:
- Fresh green and orange color scheme
- Clean, modern interface
- Fully responsive layout
- No external CSS framework dependencies
- Optimized for performance

## 🔒 Security Features

- Password hashing with bcrypt
- CSRF protection on all forms
- SQL injection prevention via Eloquent ORM
- XSS protection in Blade templates
- Role-based access control
- Environment variable protection

## 🧪 Testing

Run the test suite:
```bash
php artisan test
```

## 📝 Available Commands

### Development
```bash
php artisan serve              # Start development server
npm run dev                    # Watch assets for changes
php artisan migrate:fresh --seed # Reset database with fresh data
```

### Production
```bash
npm run build                  # Build assets for production
php artisan config:cache       # Cache configuration
php artisan route:cache        # Cache routes
php artisan view:cache         # Cache views
```

### Maintenance
```bash
php artisan cache:clear        # Clear application cache
php artisan view:clear         # Clear compiled views
php artisan config:clear       # Clear config cache
```

## 📚 Documentation

Detailed documentation available in the repository:
- `SETUP_GUIDE.md` - Complete setup instructions
- `FEATURES.md` - Feature documentation
- `COMMANDS_REFERENCE.md` - All available commands
- `GIT_HOSTING_GUIDE.md` - Git and deployment guide

## 🚀 Deployment

### Production Checklist
- [ ] Set `APP_ENV=production` in `.env`
- [ ] Set `APP_DEBUG=false` in production
- [ ] Generate new `APP_KEY` for production
- [ ] Configure production database
- [ ] Set up SSL certificate
- [ ] Enable caching (`config:cache`, `route:cache`)
- [ ] Set proper file permissions
- [ ] Point domain to `/public` directory

### Recommended Hosting
- **Shared Hosting**: Hostinger, Namecheap
- **VPS**: DigitalOcean, Linode, Vultr
- **Platform as a Service**: Laravel Vapor, Railway, Fly.io
- **Container-Based**: Docker, Kubernetes

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This project is open-source and available under the [MIT License](LICENSE).

## 👨‍💻 Author

**NannAmmZem**
- Email: nannammzem7383@gmail.com
- GitHub: [@YOUR_GITHUB_USERNAME](https://github.com/YOUR_USERNAME)

## 🙏 Acknowledgments

- Laravel Framework
- Laravel Breeze for authentication scaffolding
- Community contributors

## 📞 Support

If you encounter any issues or have questions:
1. Check the documentation files in the repository
2. Open an issue on GitHub
3. Contact via email

---

⭐ **Star this repository if you find it helpful!**

Built with ❤️ using Laravel
