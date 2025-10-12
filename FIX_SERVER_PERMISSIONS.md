# Fix Server Permission Error

## The Problem
```
file_put_contents(/var/www/html/GreenCup_Seller/storage/framework/views/...): 
Failed to open stream: Permission denied
```

Laravel cannot write compiled view files to the `storage` directory because of incorrect permissions.

## Solution

### Option 1: SSH Access (Recommended)

If you have SSH access to your server, run these commands:

```bash
# Navigate to your project directory
cd /var/www/html/GreenCup_Seller

# Fix storage and cache permissions
sudo chmod -R 775 storage bootstrap/cache

# Set correct ownership (replace www-data if your web server user is different)
sudo chown -R www-data:www-data storage bootstrap/cache

# Or if you're using Apache with a different user:
sudo chown -R apache:apache storage bootstrap/cache

# Or if you're using nginx:
sudo chown -R nginx:nginx storage bootstrap/cache

# Make sure all subdirectories exist
mkdir -p storage/framework/views
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Set permissions again after creating directories
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache
```

### Option 2: cPanel File Manager

If you only have cPanel access:

1. **Login to cPanel**
2. **Open File Manager**
3. **Navigate to** `GreenCup_Seller/storage`
4. **Right-click on `storage` folder** → Select **Change Permissions**
5. **Set permissions to `775`** or check:
   - ✅ Owner: Read, Write, Execute
   - ✅ Group: Read, Write, Execute
   - ✅ Public: Read, Execute
6. **Check "Recurse into subdirectories"**
7. **Click "Change Permissions"**

8. **Repeat for** `GreenCup_Seller/bootstrap/cache`

### Option 3: FTP Client (FileZilla)

1. **Connect via FTP**
2. **Navigate to** `GreenCup_Seller/storage`
3. **Right-click** → **File Permissions**
4. **Set to `775`** (Numeric value)
5. **Check "Recurse into subdirectories"**
6. **Check "Apply to directories only"** first, then **Apply to files only**
7. **Repeat for** `bootstrap/cache`

### Option 4: Quick PHP Script (If nothing else works)

Create a file named `fix-permissions.php` in your project root:

```php
<?php
// WARNING: Delete this file after running it once!

$directories = [
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
    'storage/app/public',
    'bootstrap/cache'
];

echo "<h2>Creating directories and setting permissions...</h2>";

foreach ($directories as $dir) {
    if (!file_exists($dir)) {
        if (mkdir($dir, 0775, true)) {
            echo "✓ Created: $dir<br>";
        } else {
            echo "✗ Failed to create: $dir<br>";
        }
    } else {
        echo "✓ Already exists: $dir<br>";
    }
    
    if (chmod($dir, 0775)) {
        echo "✓ Set permissions for: $dir<br>";
    } else {
        echo "✗ Failed to set permissions for: $dir<br>";
    }
}

echo "<h3>Done! Please delete this file now for security.</h3>";
?>
```

**Steps:**
1. Upload `fix-permissions.php` to `/var/www/html/GreenCup_Seller/`
2. Visit: `https://your-domain.com/fix-permissions.php`
3. **DELETE the file immediately after**

## Verify the Fix

After fixing permissions, run:

```bash
# Check current permissions
ls -la storage/
ls -la bootstrap/cache/

# Should show something like:
# drwxrwxr-x  user www-data  storage
# drwxrwxr-x  user www-data  bootstrap/cache
```

## Clear Cache After Fix

```bash
cd /var/www/html/GreenCup_Seller

php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

## Common Web Server Users by OS

- **Ubuntu/Debian:** `www-data`
- **CentOS/RHEL with Apache:** `apache`
- **CentOS/RHEL with Nginx:** `nginx`
- **cPanel:** Usually `your-username` or `nobody`

To find your web server user:

```bash
# Check which user is running PHP
ps aux | grep -E 'apache|httpd|nginx'

# Or check PHP info
php -r "echo exec('whoami');"
```

## If You Still Get Permission Errors

### Last Resort: Use 777 (NOT RECOMMENDED for production)

```bash
sudo chmod -R 777 storage bootstrap/cache
```

⚠️ **Security Warning:** This makes directories writable by everyone. Use only for testing, then switch back to 775.

## Recommended Production Setup

```bash
# Set directory permissions
find storage bootstrap/cache -type d -exec chmod 775 {} \;

# Set file permissions
find storage bootstrap/cache -type f -exec chmod 664 {} \;

# Set ownership
sudo chown -R www-data:www-data storage bootstrap/cache

# If you need to edit files via FTP, add your user to the web server group
sudo usermod -a -G www-data your-username
```

## After Fixing, Test the Receipt Creation Again

1. **Clear your browser cache** (Ctrl + Shift + Delete)
2. **Log out and log back in**
3. **Try creating a receipt**
4. **Check if it works now**

## If You're Using Shared Hosting

Some shared hosting providers restrict certain permissions. Contact your hosting support and tell them:

> "I need write permissions for Laravel's storage and bootstrap/cache directories. The web server needs to write compiled views and cache files. Can you set the correct permissions for /var/www/html/GreenCup_Seller/storage and /var/www/html/GreenCup_Seller/bootstrap/cache?"

## Prevention for Future Deployments

Add to your deployment script:

```bash
#!/bin/bash
# deploy.sh

git pull origin main
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Fix permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

echo "Deployment complete!"
```

## Summary

**The problem:** Laravel can't write to `storage/framework/views/`

**The solution:** Fix directory permissions to `775` and set correct ownership

**Quick fix:** Run `sudo chmod -R 775 storage bootstrap/cache && sudo chown -R www-data:www-data storage bootstrap/cache`

**After fix:** Clear caches and test receipt creation
