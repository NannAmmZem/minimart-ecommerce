# Git Hosting Guide for Mini Mart

Your project is now ready for Git hosting! This guide covers hosting on **GitHub**, **GitLab**, and **Bitbucket**.

## ✅ Current Status
- ✓ Git repository initialized
- ✓ Initial commit created (166 files)
- ✓ `.gitignore` configured (Laravel defaults)
- ✓ Branch: `master`

---

## 🚀 Option 1: GitHub (Recommended)

### Step 1: Create GitHub Repository

1. Go to [GitHub](https://github.com) and sign in
2. Click the **+** icon (top-right) → **New repository**
3. Fill in:
   - **Repository name**: `minimart-ecommerce` (or your preferred name)
   - **Description**: "Complete Mini Mart E-Commerce Website built with Laravel"
   - **Visibility**: Choose Public or Private
   - **DO NOT** initialize with README, .gitignore, or license (we already have them)
4. Click **Create repository**

### Step 2: Connect and Push to GitHub

```powershell
# Add GitHub as remote (replace YOUR_USERNAME with your GitHub username)
git remote add origin https://github.com/YOUR_USERNAME/minimart-ecommerce.git

# Rename branch to main (GitHub's default)
git branch -M main

# Push to GitHub
git push -u origin main
```

### Step 3: Configure Repository (Optional)

On GitHub, go to your repository and:
- Add topics: `laravel`, `ecommerce`, `php`, `mysql`, `shopping-cart`
- Edit description
- Add a website link if deployed

### Authentication Options:
- **HTTPS**: You'll be prompted for username/password (use Personal Access Token)
- **SSH**: Set up SSH keys for passwordless push ([Guide](https://docs.github.com/en/authentication/connecting-to-github-with-ssh))

---

## 🦊 Option 2: GitLab

### Step 1: Create GitLab Project

1. Go to [GitLab](https://gitlab.com) and sign in
2. Click **New project** → **Create blank project**
3. Fill in:
   - **Project name**: `minimart-ecommerce`
   - **Visibility Level**: Private/Internal/Public
   - **Uncheck** "Initialize repository with a README"
4. Click **Create project**

### Step 2: Connect and Push to GitLab

```powershell
# Add GitLab as remote (replace YOUR_USERNAME)
git remote add origin https://gitlab.com/YOUR_USERNAME/minimart-ecommerce.git

# Rename branch to main
git branch -M main

# Push to GitLab
git push -u origin main
```

---

## 🪣 Option 3: Bitbucket

### Step 1: Create Bitbucket Repository

1. Go to [Bitbucket](https://bitbucket.org) and sign in
2. Click **Create** → **Repository**
3. Fill in:
   - **Repository name**: `minimart-ecommerce`
   - **Access level**: Private/Public
   - **Include a README**: No
4. Click **Create repository**

### Step 2: Connect and Push to Bitbucket

```powershell
# Add Bitbucket as remote (replace YOUR_USERNAME)
git remote add origin https://bitbucket.org/YOUR_USERNAME/minimart-ecommerce.git

# Rename branch to main
git branch -M main

# Push to Bitbucket
git push -u origin main
```

---

## 📝 Essential Git Commands

### Daily Workflow
```powershell
# Check status
git status

# Stage changes
git add .

# Commit changes
git commit -m "Your commit message"

# Push to remote
git push

# Pull latest changes
git pull
```

### Branching
```powershell
# Create new branch
git checkout -b feature/your-feature-name

# Switch branches
git checkout main

# List branches
git branch

# Push new branch
git push -u origin feature/your-feature-name
```

### Viewing History
```powershell
# View commit history
git log --oneline

# View changes
git diff

# View file history
git log --follow filename
```

---

## 🔒 Important: Protect Sensitive Data

Your `.env` file is already in `.gitignore`, but **double-check**:

### Files That Should NEVER Be Committed:
- `.env` - Contains database credentials and app key
- `/vendor/` - Composer dependencies
- `/node_modules/` - NPM dependencies
- `/storage/` - Uploaded files and logs
- `/bootstrap/cache/*` - Cache files

### Check Your .gitignore:
```powershell
# View .gitignore
Get-Content .gitignore

# Check if sensitive file is tracked
git check-ignore -v .env
```

If `.env` was accidentally committed:
```powershell
# Remove from Git (keeps local file)
git rm --cached .env
git commit -m "Remove .env from repository"
git push
```

---

## 📦 Setting Up on Another Machine

When cloning to a new machine:

```powershell
# Clone the repository
git clone https://github.com/YOUR_USERNAME/minimart-ecommerce.git
cd minimart-ecommerce

# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Copy environment file
Copy-Item .env.example .env

# Generate application key
php artisan key:generate

# Create database and update .env with credentials

# Run migrations and seeders
php artisan migrate:fresh --seed

# Create storage link
php artisan storage:link

# Build assets
npm run build
```

---

## 🌐 Deployment to Production

### Popular Hosting Options:

1. **Shared Hosting** (Hostinger, Namecheap, etc.)
   - Upload files via FTP/cPanel
   - Point web root to `/public`
   - Set up database
   - Configure `.env`

2. **VPS** (DigitalOcean, Linode, Vultr)
   - More control, requires server management
   - Use Laravel Forge or Deployer for easier deployment

3. **Platform as a Service**
   - [Laravel Vapor](https://vapor.laravel.com) - Serverless (AWS)
   - [Heroku](https://heroku.com) - Free tier available
   - [Railway](https://railway.app) - Modern deployment
   - [Fly.io](https://fly.io) - Global deployment

4. **Container-Based**
   - Docker + Docker Compose
   - Kubernetes for large scale

### Pre-Deployment Checklist:
- [ ] Change `APP_ENV=production` in `.env`
- [ ] Set `APP_DEBUG=false` in production
- [ ] Generate new `APP_KEY` for production
- [ ] Use production database credentials
- [ ] Configure email settings
- [ ] Set up HTTPS/SSL certificate
- [ ] Enable caching (`php artisan config:cache`, `php artisan route:cache`)
- [ ] Set proper file permissions (755 for directories, 644 for files)
- [ ] Point domain to `/public` folder

---

## 🔗 Useful Git Resources

- [Git Documentation](https://git-scm.com/doc)
- [GitHub Guides](https://guides.github.com)
- [Atlassian Git Tutorials](https://www.atlassian.com/git/tutorials)
- [Laravel Deployment Docs](https://laravel.com/docs/deployment)

---

## ❓ Common Issues

### Issue: "Permission denied (publickey)"
**Solution**: Set up SSH keys or use HTTPS with Personal Access Token

### Issue: "Repository not found"
**Solution**: Check remote URL with `git remote -v`, update if needed

### Issue: Large files rejected
**Solution**: Use Git LFS for files >100MB

### Issue: Merge conflicts
**Solution**: 
```powershell
git pull
# Resolve conflicts in files
git add .
git commit -m "Resolve merge conflicts"
git push
```

---

## 📊 Repository Statistics

**Initial Commit:**
- 166 files
- 25,576 lines of code
- Complete Laravel e-commerce application

**Includes:**
- ✓ Laravel 12.x framework
- ✓ Authentication (Laravel Breeze)
- ✓ Admin dashboard
- ✓ Product management
- ✓ Shopping cart
- ✓ Checkout system
- ✓ Order management
- ✓ Custom CSS (no Bootstrap)
- ✓ Database seeders
- ✓ Complete documentation

---

**Ready to push!** Choose your platform and follow the steps above. 🚀
