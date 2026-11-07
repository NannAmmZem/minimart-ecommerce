# 🌐 Deploy Your Mini Mart - Get a Live Website Link

This guide will help you deploy your Mini Mart to the internet with a real URL that anyone can access.

## 🆓 Best FREE Deployment Options

### Option 1: Railway.app (Recommended - Easiest!)

**Why Railway:**
- ✅ FREE tier available
- ✅ Automatic Laravel detection
- ✅ Free MySQL database included
- ✅ Custom domain support
- ✅ HTTPS included
- ✅ Deploys directly from GitHub
- ✅ No credit card required for trial

**Your website will be:** `https://minimart-production.up.railway.app`

#### Step-by-Step Railway Deployment:

1. **Sign Up**
   - Go to https://railway.app
   - Click "Login" → Sign in with GitHub
   - Authorize Railway to access your repos

2. **Create New Project**
   - Click "New Project"
   - Select "Deploy from GitHub repo"
   - Choose `NannAmmZem/minimart-ecommerce`

3. **Add MySQL Database**
   - Click "New" → "Database" → "Add MySQL"
   - Railway will create a database automatically

4. **Configure Environment Variables**
   - Click on your Laravel service
   - Go to "Variables" tab
   - Add these variables:

   ```env
   APP_NAME="Mini Mart"
   APP_ENV=production
   APP_KEY=base64:YOUR_KEY_HERE
   APP_DEBUG=false
   APP_URL=https://minimart-production.up.railway.app

   DB_CONNECTION=mysql
   DB_HOST=${{MYSQL.RAILWAY_PRIVATE_DOMAIN}}
   DB_PORT=3306
   DB_DATABASE=${{MYSQL.MYSQL_DATABASE}}
   DB_USERNAME=${{MYSQL.MYSQL_USER}}
   DB_PASSWORD=${{MYSQL.MYSQL_PASSWORD}}

   SESSION_DRIVER=database
   QUEUE_CONNECTION=database
   ```

5. **Add Build Configuration**
   - In your service settings, go to "Settings"
   - Add start command: `php artisan serve --host=0.0.0.0 --port=$PORT`
   - Add build command (leave empty, Railway auto-detects)

6. **Deploy!**
   - Railway will automatically build and deploy
   - Wait 2-3 minutes
   - Click on the generated URL to see your site!

7. **Run Migrations**
   - In Railway dashboard, click your service
   - Go to "Settings" → "Connect"
   - Open the shell and run:
   ```bash
   php artisan migrate:fresh --seed
   php artisan storage:link
   ```

---

### Option 2: Fly.io (Great Alternative)

**Why Fly.io:**
- ✅ FREE tier (3 VMs included)
- ✅ Global deployment
- ✅ PostgreSQL/MySQL support
- ✅ Docker-based
- ✅ Custom domains

**Your website will be:** `https://minimart.fly.dev`

#### Step-by-Step Fly.io Deployment:

1. **Install Fly CLI**
   ```powershell
   # In PowerShell (as Administrator)
   iwr https://fly.io/install.ps1 -useb | iex
   ```

2. **Login to Fly**
   ```powershell
   cd C:\laragon\www\MiniMart
   fly auth login
   ```

3. **Launch Your App**
   ```powershell
   fly launch --name minimart
   ```
   
   Answer prompts:
   - Choose region: Choose closest to you
   - PostgreSQL: No (we'll use MySQL)
   - Redis: No

4. **Create MySQL Database**
   ```powershell
   fly postgres create --name minimart-db
   fly postgres attach minimart-db
   ```

5. **Set Environment Variables**
   ```powershell
   fly secrets set APP_KEY=base64:YOUR_KEY_HERE
   fly secrets set APP_ENV=production
   fly secrets set APP_DEBUG=false
   ```

6. **Deploy**
   ```powershell
   fly deploy
   ```

7. **Run Migrations**
   ```powershell
   fly ssh console
   php artisan migrate:fresh --seed
   php artisan storage:link
   exit
   ```

---

### Option 3: Heroku (Classic Choice)

**Why Heroku:**
- ✅ FREE tier available
- ✅ Easy to use
- ✅ Great documentation
- ✅ Add-ons ecosystem

**Your website will be:** `https://minimart-ecommerce.herokuapp.com`

#### Step-by-Step Heroku Deployment:

1. **Sign Up**
   - Go to https://heroku.com
   - Create free account

2. **Install Heroku CLI**
   - Download from: https://devcenter.heroku.com/articles/heroku-cli
   - Install and restart terminal

3. **Login**
   ```powershell
   cd C:\laragon\www\MiniMart
   heroku login
   ```

4. **Create App**
   ```powershell
   heroku create minimart-ecommerce
   ```

5. **Add MySQL Database**
   ```powershell
   heroku addons:create jawsdb:kitefin
   ```

6. **Create Procfile**
   Create file named `Procfile` (no extension) with:
   ```
   web: vendor/bin/heroku-php-apache2 public/
   ```

7. **Deploy**
   ```powershell
   git add Procfile
   git commit -m "Add Procfile for Heroku"
   git push heroku main
   ```

8. **Configure**
   ```powershell
   heroku config:set APP_KEY=$(php artisan --no-ansi key:generate --show)
   heroku config:set APP_ENV=production
   heroku config:set APP_DEBUG=false
   ```

9. **Run Migrations**
   ```powershell
   heroku run php artisan migrate:fresh --seed
   heroku run php artisan storage:link
   ```

10. **Open Your Site**
    ```powershell
    heroku open
    ```

---

### Option 4: Vercel (For Static Parts)

**Note:** Vercel is best for static/frontend. For full Laravel, use Railway/Fly.io/Heroku.

---

## 💰 Paid Hosting Options (More Professional)

### 1. **Shared Hosting** ($3-10/month)

**Recommended:**
- Hostinger (from $2.99/month)
- Namecheap (from $3.88/month)
- SiteGround (from $6.99/month)

**Features:**
- ✅ cPanel included
- ✅ MySQL database
- ✅ Custom domain
- ✅ Email accounts
- ✅ SSL certificate

**How to Deploy:**
1. Sign up for hosting plan
2. Upload files via FTP or Git
3. Create MySQL database in cPanel
4. Update `.env` with database credentials
5. Point domain to `/public` folder
6. Run migrations via SSH or cPanel terminal

---

### 2. **VPS Hosting** ($5-10/month)

**Recommended:**
- DigitalOcean (from $6/month)
- Vultr (from $6/month)
- Linode (from $5/month)

**Features:**
- ✅ Full server control
- ✅ Root access
- ✅ Choose OS (Ubuntu recommended)
- ✅ Can host multiple sites
- ✅ SSH access

**Easiest VPS Setup:**
Use Laravel Forge ($12/month) to manage your VPS automatically.

---

### 3. **Laravel-Specific Hosting**

**Laravel Vapor** (Serverless)
- AWS-based serverless platform
- Auto-scaling
- From $39/month
- Best for high-traffic sites

**Laravel Forge** (Server Management)
- Manages your VPS automatically
- $12/month + VPS cost
- One-click deployments
- SSL, queues, cron jobs

---

## 🎯 My Recommendation for You

**Start with Railway.app** because:
1. ✅ Completely FREE to start
2. ✅ Easiest setup (5 minutes)
3. ✅ Deploys directly from GitHub
4. ✅ Database included
5. ✅ HTTPS automatic
6. ✅ No credit card needed
7. ✅ Can upgrade later if needed

---

## 🚀 Quick Start: Railway Deployment

I'll create an automated setup script for you!

### 1. Files You Need

**Create `railway.json` in your project:**
```json
{
  "$schema": "https://railway.app/railway.schema.json",
  "build": {
    "builder": "NIXPACKS"
  },
  "deploy": {
    "startCommand": "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT",
    "restartPolicyType": "ON_FAILURE",
    "restartPolicyMaxRetries": 10
  }
}
```

**Create `nixpacks.toml` in your project:**
```toml
[phases.setup]
nixPkgs = ['php82', 'php82Packages.composer']

[phases.install]
cmds = ['composer install --no-dev --optimize-autoloader']

[phases.build]
cmds = ['php artisan config:cache', 'php artisan route:cache', 'php artisan view:cache']

[start]
cmd = 'php artisan serve --host=0.0.0.0 --port=$PORT'
```

### 2. Push These Files
```powershell
git add railway.json nixpacks.toml
git commit -m "Add Railway deployment configuration"
git push
```

### 3. Deploy on Railway
1. Go to https://railway.app
2. Sign in with GitHub
3. New Project → Deploy from GitHub
4. Select your repo
5. Add MySQL database
6. Done! 🎉

---

## 📝 Pre-Deployment Checklist

Before deploying, make sure:

- [ ] `.env.example` is updated with all variables
- [ ] `APP_DEBUG=false` in production
- [ ] `APP_ENV=production` in production
- [ ] Database credentials are set
- [ ] Storage link will be created after deployment
- [ ] Migrations will run after deployment

---

## 🔒 Security for Production

Update your `.env` for production:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-actual-domain.com

# Generate new key for production
APP_KEY=base64:GENERATE_NEW_KEY

# Database (Railway will provide these)
DB_CONNECTION=mysql
DB_HOST=your-railway-host
DB_PORT=3306
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=your-railway-password

SESSION_DRIVER=database
SESSION_LIFETIME=120

CACHE_DRIVER=database
QUEUE_CONNECTION=database
```

---

## 🎉 After Deployment

Once deployed, you'll have:

✅ Live website URL (e.g., https://minimart-production.up.railway.app)
✅ Anyone can visit your site
✅ Database hosted online
✅ HTTPS security included
✅ Can share link on resume/portfolio

### Update Your GitHub README

Add to your README.md:
```markdown
## 🌐 Live Demo

**Check out the live website:** [https://your-url.railway.app](https://your-url.railway.app)

**Admin Login:**
- Email: admin@minimart.test
- Password: minimart123

**Customer Login:**
- Email: customer@minimart.test
- Password: password
```

---

## ❓ Need Help?

**Railway Issues:**
- Docs: https://docs.railway.app
- Discord: https://discord.gg/railway

**Heroku Issues:**
- Docs: https://devcenter.heroku.com
- Laravel Guide: https://devcenter.heroku.com/articles/getting-started-with-laravel

**General Laravel Deployment:**
- Official Docs: https://laravel.com/docs/deployment

---

## 🎯 What's Next?

After getting your live link:

1. Test everything works online
2. Add the link to your GitHub README
3. Share on LinkedIn
4. Add to resume
5. Consider custom domain ($10-15/year)

---

**Ready to deploy? Start with Railway - it's the fastest way to get your live link!** 🚀
