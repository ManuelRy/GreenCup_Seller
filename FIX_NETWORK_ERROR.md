# Network Error: Failed to Fetch - Solutions

## The Problem
```
Network Error: Failed to fetch
This means:
- Server is unreachable
- CORS issue
- Firewall blocking request
```

The browser cannot even connect to your server to send the request.

## Root Causes & Solutions

### 1. HTTPS/Mixed Content Issue (Most Common)

If your site is on HTTPS but you're making requests to HTTP (or vice versa), browsers block it.

**Check:** Look at your URL in the browser
- Is it `https://seller.green-cups.app`?
- Are the AJAX requests going to `http://` instead of `https://`?

**Solution:** Ensure Laravel generates HTTPS URLs

Add to `app/Providers/AppServiceProvider.php`:

```php
public function boot(): void
{
    // Force HTTPS in production
    if ($this->app->environment('production')) {
        \URL::forceScheme('https');
    }
}
```

### 2. Incorrect APP_URL in .env

**Check your server's `.env` file:**

```env
# Wrong - causes route generation issues
APP_URL=http://localhost

# Correct - should match your actual domain
APP_URL=https://seller.green-cups.app
```

**After changing:**
```bash
php artisan config:clear
php artisan cache:clear
```

### 3. Server/Domain Not Accessible

**Test if server is reachable:**

Open a new browser tab and visit:
```
https://seller.green-cups.app/seller/test-json
```

**Expected:** You should see an error page (405 Method Not Allowed or CSRF error)
**Problem:** If you get "Site can't be reached" → DNS or server issue

### 4. CORS Configuration

If the domain changes (www vs non-www), you need CORS headers.

**Add to `config/cors.php`:**

```php
return [
    'paths' => ['api/*', 'seller/*'],
    
    'allowed_methods' => ['*'],
    
    'allowed_origins' => [
        'https://seller.green-cups.app',
        'https://green-cups.app',
    ],
    
    'allowed_origins_patterns' => [],
    
    'allowed_headers' => ['*'],
    
    'exposed_headers' => [],
    
    'max_age' => 0,
    
    'supports_credentials' => true,
];
```

### 5. Cloudflare/Proxy Issues

If you're using Cloudflare or similar:

1. **Check Firewall Rules** in Cloudflare dashboard
2. **Check Security Level** - set to "Medium" not "I'm Under Attack"
3. **Disable "Browser Integrity Check"** temporarily
4. **Add Firewall Rule:**
   - Field: `URL Path`
   - Operator: `contains`
   - Value: `/seller/receipts`
   - Action: `Allow`

### 6. Check Browser Console for Exact Error

Open DevTools (F12) → Console tab, you might see:

**Error:** `net::ERR_SSL_PROTOCOL_ERROR`
**Fix:** SSL certificate issue - check with hosting provider

**Error:** `Mixed Content: The page was loaded over HTTPS, but requested an insecure XMLHttpRequest`
**Fix:** Force HTTPS in Laravel (see Solution #1)

**Error:** `CORS policy: No 'Access-Control-Allow-Origin' header`
**Fix:** Configure CORS (see Solution #4)

**Error:** `net::ERR_CONNECTION_REFUSED`
**Fix:** Server is down or firewall blocking

### 7. Temporary Workaround: Use Relative URLs

Instead of using Laravel routes, try relative URLs directly:

**Edit `resources/views/receipts/create.blade.php`:**

Find the test connection function around line 1195:

```javascript
// Change from:
const response = await fetch('{{ route("seller.test-json") }}', {

// To:
const response = await fetch('/seller/test-json', {
```

And in the generate receipt function around line 1218:

```javascript
// Change from:
const response = await fetch('{{ route("seller.receipts.store") }}', {

// To:
const response = await fetch('/seller/receipts', {
```

This bypasses any URL generation issues.

### 8. Check .htaccess Configuration

If using Apache, ensure `.htaccess` exists in `public/` folder:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

### 9. Check Server Configuration (Apache/Nginx)

#### For Apache Virtual Host:

```apache
<VirtualHost *:443>
    ServerName seller.green-cups.app
    DocumentRoot /var/www/html/GreenCup_Seller/public

    <Directory /var/www/html/GreenCup_Seller/public>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    SSLEngine on
    SSLCertificateFile /path/to/cert.pem
    SSLCertificateKeyFile /path/to/key.pem
</VirtualHost>
```

#### For Nginx:

```nginx
server {
    listen 443 ssl http2;
    server_name seller.green-cups.app;
    root /var/www/html/GreenCup_Seller/public;

    ssl_certificate /path/to/cert.pem;
    ssl_certificate_key /path/to/key.pem;

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

## Debugging Steps

### Step 1: Check what URL is being generated

Add this to your create receipt page temporarily:

```html
<script>
console.log('Test route:', '{{ route("seller.test-json") }}');
console.log('Store route:', '{{ route("seller.receipts.store") }}');
console.log('Current URL:', window.location.href);
console.log('Protocol:', window.location.protocol);
</script>
```

Refresh the page and check the console. The routes should:
- Use the same protocol (http/https) as the current page
- Point to the correct domain

### Step 2: Test with cURL

On your server, test the endpoint:

```bash
curl -X POST https://seller.green-cups.app/seller/test-json \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"test": "data"}'
```

**Expected:** Should get a CSRF error (that's OK, means endpoint is reachable)
**Problem:** Connection refused → server/firewall issue

### Step 3: Check SSL Certificate

```bash
openssl s_client -connect seller.green-cups.app:443 -servername seller.green-cups.app
```

Look for certificate details. If error → SSL issue.

### Step 4: Disable HTTPS temporarily (for testing only)

In `.env`:
```env
APP_URL=http://seller.green-cups.app
```

Visit: `http://seller.green-cups.app` (not https)

If it works → SSL/HTTPS configuration issue
If still fails → different problem

## Quick Fix Implementation

Based on the most common cause (HTTPS/URL issues), let's fix it:

1. **Update AppServiceProvider:**
   Add HTTPS forcing

2. **Update .env on server:**
   Set correct APP_URL with https

3. **Use relative URLs:**
   Bypass route generation

4. **Clear caches:**
   Remove stale configurations

Would you like me to implement these fixes in your code?

## Summary

**Most Likely Cause:** HTTPS/HTTP mismatch or incorrect APP_URL
**Quick Test:** Check browser console for the actual generated URLs
**Quick Fix:** Use relative URLs `/seller/receipts` instead of `route()` helper
