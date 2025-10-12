# Deploy Instructions - Fix Network Error

## Changes Made

### 1. Force HTTPS in Production
**File:** `app/Providers/AppServiceProvider.php`
- Added URL::forceScheme('https') for production environment
- This ensures all generated URLs use HTTPS, preventing mixed content errors

### 2. Use Relative URLs
**File:** `resources/views/receipts/create.blade.php`
- Changed from `route()` helper to relative URLs
- Test endpoint: `/seller/test-json`
- Receipt endpoint: `/seller/receipts`
- This bypasses any URL generation issues

### 3. Enhanced Debugging
- Added console logs to show both generated and relative URLs
- Added protocol detection
- Better error messages

## Deployment Steps

### Step 1: Push to Server

```bash
# Commit changes
git add .
git commit -m "Fix network error - use HTTPS and relative URLs"
git push origin main
```

### Step 2: On Your Server (via SSH)

```bash
# Navigate to project
cd /var/www/html/GreenCup_Seller

# Pull latest changes
git pull origin main

# Fix permissions (from previous error)
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache

# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Rebuild caches for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Step 3: Update .env on Server

Make sure your `.env` file has the correct URL:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://seller.green-cups.app
```

After changing, run:
```bash
php artisan config:cache
```

### Step 4: Test

1. **Clear browser cache** (Ctrl + Shift + Delete)
2. **Log out and log back in**
3. **Open browser console** (F12 → Console tab)
4. **Click "Test Server Connection"**
   - Should now show the URL comparison
   - Should work with relative URL
5. **Try creating a receipt**

### Expected Console Output

When you click "Test Server Connection":
```
✓ CSRF token found: abc123...
Route URL: https://seller.green-cups.app/seller/test-json
Relative URL: /seller/test-json
Current page: https://seller.green-cups.app/seller/receipts/create
Protocol: https:
Sending test request to: /seller/test-json
✓ Response received. Status: 200
✓ SUCCESS!
```

## If It Still Doesn't Work

### Check Apache/Nginx Configuration

#### Apache - Ensure mod_rewrite is enabled:
```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

#### Apache - Check .htaccess in public folder exists

#### Nginx - Check configuration includes:
```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```

### Check Firewall

```bash
# Allow HTTP and HTTPS
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw reload
```

### Check SSL Certificate

Visit: https://www.ssllabs.com/ssltest/
Enter: seller.green-cups.app
Should show valid SSL configuration

### Check mod_security (if using)

Temporarily disable to test:
```bash
sudo a2dismod security2
sudo systemctl restart apache2
```

If this fixes it, add exception instead:
```apache
<LocationMatch "/seller/(receipts|test-json)">
    SecRuleEngine Off
</LocationMatch>
```

Then re-enable:
```bash
sudo a2enmod security2
sudo systemctl restart apache2
```

## Quick Troubleshooting

### Error: "Network Error: Failed to fetch"
- Check console for generated URLs
- Verify both use same protocol (https)
- Try accessing URL directly in browser

### Error: 404 Not Found
- Run `php artisan route:clear`
- Check routes with `php artisan route:list --path=receipts`

### Error: 419 CSRF Token Mismatch
- Clear browser cookies
- Run `php artisan session:clear`
- Log out and back in

### Error: 500 Server Error
- Check `storage/logs/laravel.log`
- Fix permissions: `chmod -R 775 storage`

### Error: 403 Forbidden
- Check directory permissions
- Check .htaccess exists
- Check Apache AllowOverride is set to All

## Verify Everything is Working

```bash
# 1. Check routes are registered
php artisan route:list --path=receipts

# 2. Check config is correct
php artisan tinker
>>> config('app.url')
>>> config('app.env')
>>> exit

# 3. Test endpoint with curl
curl -X GET https://seller.green-cups.app/seller/receipts/create

# Should return HTML page (status 200)

# 4. Check logs for errors
tail -f storage/logs/laravel.log
```

## Summary

**What was changed:**
1. ✅ Force HTTPS in AppServiceProvider
2. ✅ Use relative URLs instead of route() helper
3. ✅ Enhanced debugging and logging

**What to do:**
1. Push changes to git
2. Pull on server
3. Fix permissions
4. Clear caches
5. Update .env
6. Test!

**Most likely this will fix:**
- Mixed content errors (http/https)
- URL generation issues
- Protocol mismatches
- Domain/subdomain issues

The relative URLs (`/seller/receipts`) work regardless of:
- Domain name
- Protocol (http/https)
- Environment (local/production)
- Server configuration

This makes your application more portable and less prone to URL-related issues! 🚀
