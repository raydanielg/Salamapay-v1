# SalamaPay Server Fix Guide

## Error: SQLSTATE[HY000]: General error: 8 attempt to write a readonly database

### Quick Fix Applied (Code)
- Changed `SESSION_DRIVER=database` → `SESSION_DRIVER=file` in `.env`
- Changed `CACHE_STORE=database` → `CACHE_STORE=file` in `.env`

### Server-Side Fix (SSH into your server)

```bash
# 1. SSH into your server
ssh user@miet.ac.tz

# 2. Navigate to project root
cd /var/www/vhosts/miet.ac.tz/httpdocs/

# 3. Fix SQLite database permissions
chmod 666 database/database.sqlite
chmod 775 database/

# 4. Fix storage & bootstrap cache (Laravel needs these writable)
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/

# 5. Set correct ownership (replace 'www-data' with your web server user if different)
chown -R www-data:www-data storage/ bootstrap/cache/ database/

# 6. Clear Laravel cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# 7. Create SQLite database if missing
if [ ! -f database/database.sqlite ]; then
    touch database/database.sqlite
    chmod 666 database/database.sqlite
fi

# 8. Run migrations
php artisan migrate --force
```

### Alternative: Use MySQL instead of SQLite (Production Recommended)

In your server, create a MySQL database and update `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=salamapay
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

Then run:
```bash
php artisan migrate --force
```
