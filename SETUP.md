# Bagisto E-commerce Setup Guide

This guide will help you set up the Bagisto e-commerce project on your local development environment.

## Prerequisites

- PHP 8.2 or higher
- Composer 2.0 or higher
- MySQL 5.7+ / MariaDB 10.3+ / PostgreSQL 9.4+ / SQLite 3.8.8+
- Node.js (LTS version recommended)
- NPM or Yarn
- Web Server (Apache/Nginx) or use PHP's built-in server

## Bagisto Installation Steps

### 1. Create a New Bagisto Project

```bash
composer create-project bagisto/bagisto my-project
cd my-project
```

### 2. Run Bagisto Installer

This command sets up:

- ✔ Database tables
- ✔ Demo data
- ✔ Admin user
- ✔ Application key

```bash
php artisan bagisto:install
```

Follow the on-screen prompts and enter your database and admin details.

### 3. Environment Setup (Only if needed)

If `.env` is not automatically created:

```bash
cp .env.example .env
php artisan key:generate
```

Update `.env` with your database information if required.

### 4. Install Frontend Dependencies (Optional)

Run this only if you will modify UI assets, admin theme, or storefront.

```bash
npm install
npm run dev
```

### 5. Storage Link (Usually auto-created)

```bash
php artisan storage:link
```

### 6. Clear and Optimize Cache

```bash
php artisan optimize:clear
```

### 7. Start the Development Server

```bash
php artisan serve
```

Your Bagisto store will now be available at:  
👉 http://localhost:8000 (http://localhost:8000)

### Queue Worker (Optional)

If you want to process background jobs such as emails or order events:

```bash
php artisan queue:work
```

## 🎉 You're Ready!

Log in to the admin panel using the credentials you created during installation:  
🔗 [Admin Panel](http://localhost:8000/admin)

## Default Admin Credentials (if using demo data)

- **URL**: http://localhost:8000/admin/login
- **Email**: admin@example.com
- **Password**: admin123

## Next Steps

- Customize your store's appearance
- Configure payment gateways
- Set up shipping methods
- Add your products
- Configure tax rates

## Graphql/Headless Package Installation Steps (Install via Composer)

Run the following command in your terminal to install the GraphQL API package:

### 1. Install graphql-api Package

Install The Package

```bash
composer require bagisto/graphql-api
or
composer require bagisto/graphql-api:dev-main
```

Run the following commands to complete the setup

```bash
php artisan bagisto-graphql:install
```
### 3. ENV Variables Setup

It will automatically create few .env varibles

```bash
APP_SECRET_KEY=
GRAPHQL_ENDPOINT=http://127.0.0.1:8000/graphql
JWT_TTL=525600
JWT_SHOW_BLACKLIST_EXCEPTION=true
JWT_SECRET=
JWT_ALGO=HS256
```
If Not created then create manually

Also Check The Generated API URL if Not Correct or Facing any Error.

### 4. Configure Middleware

Update your bootstrap/app.php file to ensure proper session handling:

```php
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

return Application::configure(basePath: dirname(__DIR__))
   ->withMiddleware(function (Middleware $middleware) {
      // ... rest of middleware setup

      /**
       * Remove session and cookie middleware from the 'web' middleware group.
       */
      $middleware->removeFromGroup('web', [StartSession::class, AddQueuedCookiesToResponse::class]);

      /**
       * Adding session and cookie middleware globally to apply across non-web routes (e.g. GraphQL)
       */
      $middleware->append([StartSession::class, AddQueuedCookiesToResponse::class]);
   })
   // ... rest of configuration
```

### 4. Clear Lighthouse Cache

```bash
php artisan lighthouse:cache
php artisan lighthouse:clear-cache
```
