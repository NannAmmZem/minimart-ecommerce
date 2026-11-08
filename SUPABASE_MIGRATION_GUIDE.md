# 🚀 Migrate Mini Mart from MySQL to Supabase (PostgreSQL)

## What is Supabase?

Supabase is an open-source Firebase alternative with:
- ✅ **PostgreSQL database** (more powerful than MySQL)
- ✅ **FREE hosting** (500MB database, 2GB file storage)
- ✅ **Real-time subscriptions**
- ✅ **Built-in authentication**
- ✅ **REST API** auto-generated
- ✅ **No credit card required**
- ✅ **Perfect for Laravel**

Your database will be hosted online for FREE forever!

---

## 📋 Migration Steps

### Step 1: Create Supabase Account

1. Go to: https://supabase.com
2. Click "Start your project"
3. Sign up with GitHub (easiest)
4. Create a new organization (e.g., "NannAmmZem")

### Step 2: Create New Project

1. Click "New Project"
2. Fill in:
   - **Name**: minimart-ecommerce
   - **Database Password**: (create a strong password - SAVE THIS!)
   - **Region**: Choose closest to you
   - **Pricing Plan**: Free
3. Click "Create new project"
4. Wait 2-3 minutes for provisioning

### Step 3: Get Database Credentials

1. In your Supabase project, click "Project Settings" (⚙️ icon, bottom left)
2. Go to "Database" tab
3. Scroll to "Connection string" section
4. Copy the "URI" connection string
5. It looks like: `postgresql://postgres:[YOUR-PASSWORD]@db.xxx.supabase.co:5432/postgres`

---

## 💻 Update Your Laravel Project

### Step 4: Install PostgreSQL Driver

Open PowerShell in your project folder:

```powershell
cd C:\laragon\www\MiniMart
composer require doctrine/dbal
```

### Step 5: Update .env File

Open `.env` and change the database settings:

```env
# OLD MySQL Settings (comment out or delete)
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=minimart_laragon
# DB_USERNAME=root
# DB_PASSWORD=

# NEW Supabase PostgreSQL Settings
DB_CONNECTION=pgsql
DB_HOST=db.xxx.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=your-supabase-password
```

**Important:** Replace:
- `db.xxx.supabase.co` with your actual Supabase host
- `your-supabase-password` with the password you created

### Step 6: Update config/database.php (Optional)

Laravel already has PostgreSQL support, but you can verify:

```php
'pgsql' => [
    'driver' => 'pgsql',
    'url' => env('DATABASE_URL'),
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => env('DB_PORT', '5432'),
    'database' => env('DB_DATABASE', 'forge'),
    'username' => env('DB_USERNAME', 'forge'),
    'password' => env('DB_PASSWORD', ''),
    'charset' => 'utf8',
    'prefix' => '',
    'prefix_indexes' => true,
    'search_path' => 'public',
    'sslmode' => 'prefer',
],
```

### Step 7: Run Migrations on Supabase

```powershell
# Clear cached config
php artisan config:clear
php artisan cache:clear

# Run migrations (creates tables in Supabase)
php artisan migrate:fresh

# Seed the database
php artisan db:seed
```

---

## 🔧 Fix Laravel Migrations for PostgreSQL

Some MySQL syntax needs adjustment for PostgreSQL:

### Fix 1: Update User Migration

Open `database/migrations/0001_01_01_000000_create_users_table.php`

Change:
```php
$table->id(); // Already correct
```

### Fix 2: Update Product Migration

If you have `ENUM` types, change them to strings:

```php
// MySQL
$table->enum('status', ['active', 'inactive'])->default('active');

// PostgreSQL
$table->string('status', 20)->default('active');
```

### Fix 3: Update Order Migration

Same for order status:

```php
// PostgreSQL compatible
$table->string('status', 50)->default('pending');
```

---

## 📝 Complete Migration Script

I'll create updated migration files for you that work with PostgreSQL.

---

## 🎯 Benefits of Supabase

### vs MySQL on Laragon:

**Laragon (Local MySQL):**
- ❌ Only works on your computer
- ❌ Can't share/deploy easily
- ❌ No built-in backups
- ❌ Manual setup required

**Supabase:**
- ✅ Works anywhere with internet
- ✅ Easy deployment
- ✅ Automatic daily backups
- ✅ Built-in admin panel
- ✅ Real-time capabilities
- ✅ Auto-generated REST API
- ✅ Row-level security
- ✅ Free forever (for small projects)

---

## 🚀 Deploy to Railway with Supabase

Now your app can deploy anywhere since database is online!

1. Deploy Laravel app to Railway (free)
2. Point to Supabase database
3. Both are free hosting!
4. Your Mini Mart is fully online!

---

## 📊 Supabase Features You'll Get

### 1. Database Dashboard
- Visual table editor
- Run SQL queries
- View data in real-time
- Export/import data

### 2. Authentication (Built-in)
- Can replace Laravel Breeze if you want
- Email/password
- OAuth (Google, GitHub, etc.)
- Magic links

### 3. Storage
- File uploads (product images)
- CDN included
- Image transformations

### 4. Real-time Subscriptions
- Live updates
- WebSocket support
- Perfect for order tracking

### 5. Auto-generated API
- REST API for your tables
- No code needed
- Instant endpoints

---

## 🔒 Security

### Row Level Security (RLS)

Supabase has built-in row-level security:

```sql
-- Example: Users can only see their own orders
CREATE POLICY "Users see own orders"
ON orders
FOR SELECT
USING (auth.uid() = user_id);
```

---

## 💰 Pricing (Free Tier)

**FREE FOREVER includes:**
- 500 MB database space
- 1 GB file storage
- 2 GB bandwidth/month
- 50,000 monthly active users
- 500,000 Edge Function invocations
- 7-day backup retention

**More than enough for portfolio projects!**

---

## 🛠️ Supabase Dashboard Features

1. **Table Editor**: Visual database editor
2. **SQL Editor**: Run queries
3. **Database**: Schema viewer
4. **Authentication**: User management
5. **Storage**: File manager
6. **Logs**: Real-time logs
7. **Settings**: Configuration

---

## 📖 Common PostgreSQL vs MySQL Differences

### 1. Auto Increment
```php
// MySQL & PostgreSQL both work
$table->id(); // Uses bigint auto-increment
```

### 2. Boolean
```php
// MySQL uses TINYINT(1)
// PostgreSQL uses BOOLEAN
$table->boolean('is_active')->default(true); // Works in both
```

### 3. JSON
```php
// PostgreSQL has better JSON support
$table->json('metadata'); // Works in both
$table->jsonb('data');    // PostgreSQL only (faster)
```

### 4. Text Search
```php
// PostgreSQL has full-text search built-in
// Much better than MySQL LIKE queries
```

### 5. Enum
```php
// MySQL native ENUM
// PostgreSQL uses CHECK constraint or string

// Compatible way:
$table->string('status', 20)->default('pending');
```

---

## 🔄 Migration Checklist

- [ ] Create Supabase account
- [ ] Create new project
- [ ] Get database credentials
- [ ] Install doctrine/dbal
- [ ] Update .env file
- [ ] Test connection: `php artisan migrate:status`
- [ ] Run migrations: `php artisan migrate:fresh`
- [ ] Seed database: `php artisan db:seed`
- [ ] Test application locally
- [ ] Update deployment configs

---

## 🆘 Troubleshooting

### Connection Failed
```
SQLSTATE[08006] [7] could not connect to server
```
**Fix:** Check host, port, and password in .env

### SSL Error
```
SQLSTATE[08006] SSL required
```
**Fix:** Add to .env:
```env
DB_SSLMODE=require
```

### Migration Error
```
SQLSTATE[42P01]: Undefined table
```
**Fix:** Run `php artisan migrate:fresh`

### Seeder Fails
```
Integrity constraint violation
```
**Fix:** Check foreign key constraints, run in correct order

---

## 🌐 Use with GitHub Pages + Railway

**Perfect Setup:**
1. **GitHub Pages**: Portfolio/showcase (free static site)
2. **Railway**: Laravel backend (free tier)
3. **Supabase**: PostgreSQL database (free)

**Total cost: $0 per month!**

---

## 📝 Next Steps After Migration

1. Test all features locally
2. Update Railway deployment to use Supabase
3. Add Supabase credentials to Railway environment variables
4. Deploy and test online
5. Enjoy free online database!

---

## 🎓 Learn More

- Supabase Docs: https://supabase.com/docs
- Laravel PostgreSQL: https://laravel.com/docs/database#pgsql-configuration
- PostgreSQL Tutorial: https://www.postgresql.org/docs/

---

**Ready to migrate? Let's do it!** 🚀
