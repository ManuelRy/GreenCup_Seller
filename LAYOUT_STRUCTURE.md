# GreenCup Seller - Layout Structure

This document explains the new layout structure implemented for the GreenCup Seller application.

## Layout Files

### 1. `layouts/app.blade.php`
**Main layout for authenticated pages**
- Used for all authenticated user pages except dashboard
- Includes central navbar with navigation
- Responsive design with mobile support
- Flash message handling
- Contains main content area with proper spacing

**Usage:**
```php
@extends('layouts.app')
@section('title', 'Page Title')
@section('page-title', 'Display Title')
@section('page-subtitle', 'Optional subtitle')
@section('content')
    <!-- Your page content -->
@endsection
```

### 2. `layouts/dashboard.blade.php`
**Special layout for the dashboard page**
- Similar to app layout but optimized for dashboard structure
- Uses the same navbar component
- Handles dashboard-specific styling

**Usage:**
```php
@extends('layouts.dashboard')
@section('title', 'Dashboard Title')
@section('content')
    <!-- Dashboard content -->
@endsection
```

### 3. `layouts/guest.blade.php`
**Layout for guest pages (login, register, etc.)**
- Clean, minimal design for authentication pages
- No navbar (users aren't authenticated)
- Centered content with brand header
- Includes alert handling

**Usage:**
```php
@extends('layouts.guest')
@section('title', 'Login - Green Cup App')
@section('content')
    <!-- Login/Register form -->
@endsection
```

## Components

### `components/navbar.blade.php`
**Central navigation component**
- Dynamic navigation based on current route
- User dropdown with all navigation links
- Back button functionality for non-dashboard pages
- Mobile-responsive design
- Includes user profile information and logout

**Features:**
- Dashboard shows brand name and user menu
- Other pages show back button + page title + user menu
- Dropdown contains all main navigation links
- Active state indication for current page
- Mobile optimization

### `components/footer.blade.php`
**Application footer**
- Simple footer with copyright and version info
- Links to important pages
- Mobile responsive

## Navigation Structure

The navbar includes all important pages:

**Main Navigation:**
- Dashboard
- Items Management
- Rewards Management
- Reward Redemptions
- Receipts
- Reports

**Account Section:**
- Account Settings
- Photo Gallery
- Location Management
- QR Scanner

## Implementation Benefits

1. **Consistent Design:** All pages now use the same navbar and styling
2. **DRY Principle:** No more duplicated navbar code in each page
3. **Easy Maintenance:** Central navbar means updates only need to be made in one place
4. **Better UX:** Consistent navigation experience across all pages
5. **Mobile Responsive:** All layouts are optimized for mobile devices
6. **Accessibility:** Better structure and navigation for screen readers

## Page Updates

The following pages have been updated to use the new layout system:

### Completed:
- ✅ `layouts/app.blade.php` - Main authenticated layout
- ✅ `layouts/dashboard.blade.php` - Dashboard layout
- ✅ `layouts/guest.blade.php` - Guest pages layout
- ✅ `components/navbar.blade.php` - Central navigation
- ✅ `components/footer.blade.php` - Application footer
- ✅ `sellers/dashboard.blade.php` - Updated to use dashboard layout
- ✅ `items/index.blade.php` - Updated to use app layout
- ✅ `rewards/index.blade.php` - Updated to use app layout
- ✅ `sellers/login.blade.php` - Updated to use guest layout

### To Be Updated:
- `sellers/create.blade.php` - Registration page
- `sellers/account.blade.php` - Account page
- `rewards/create.blade.php` - Create reward page
- `rewards/edit.blade.php` - Edit reward page
- `rewards/redemptions.blade.php` - Redemptions page
- `report/index.blade.php` - Reports page
- `report/create.blade.php` - Create report page
- `location/show.blade.php` - Location page
- `location/edit.blade.php` - Edit location page
- `receipts/index.blade.php` - Receipts page
- All other existing pages

## Migration Guide

To update existing pages:

1. **Change the extends directive:**
   ```php
   // Old
   @extends('master')
   
   // New - for authenticated pages
   @extends('layouts.app')
   @section('page-title', 'Your Page Title')
   
   // New - for guest pages
   @extends('layouts.guest')
   ```

2. **Remove duplicate navbar/header code:**
   - Remove any custom header/navbar HTML
   - Remove duplicate styles for headers
   - Keep only the main content

3. **Update styles:**
   - Move page-specific styles to `@push('styles')` section
   - Remove base/reset CSS that's now in layouts
   - Clean up redundant styling

4. **Update scripts:**
   - Move page-specific scripts to `@push('scripts')` section
   - Remove navbar-related JavaScript (now in navbar component)

## Technical Notes

- All layouts use responsive design principles
- Font Awesome icons are included globally
- Layouts support both light and dark themes
- All layouts include CSRF token meta tag
- Layouts are optimized for mobile devices
- Flash messages are handled automatically in all layouts

## Styling Guidelines

- Use `@push('styles')` for page-specific CSS
- Use `@push('scripts')` for page-specific JavaScript
- Maintain consistent spacing and typography
- Follow mobile-first responsive design principles
- Use the project's color scheme (green theme)

This new structure provides a much cleaner, more maintainable codebase while ensuring a consistent user experience across all pages.
