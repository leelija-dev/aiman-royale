# WARP.md

This file provides guidance to WARP (warp.dev) when working with code in this repository.

Project overview
- Laravel 11 application built on Bagisto (modular e‑commerce). Code is split into first‑party Laravel app code under `app/` and domain modules under `packages/Webkul/*` (e.g., Core, Admin, Shop, Product, Sales, Inventory).
- Frontend assets use Vite via `laravel-vite-plugin` with entrypoints declared in `vite.config.js` (`resources/css/app.css`, `resources/js/app.js`).
- Testing is configured with PHPUnit (`phpunit.xml`) and multiple testsuites scanning package test directories. Pest is present in dev dependencies but not required for test execution.
- Optional Docker environment is provided for full stack (PHP-FPM, Nginx, MariaDB, Redis, Elasticsearch, Kibana, Node). See `docker-compose.yml` and `DOCKER.md`.

Common commands
Windows PowerShell examples use PowerShell built‑ins; adjust for your shell as needed.

Setup
- Install PHP deps: `composer install`
- Create env if missing and generate app key:
  - `Copy-Item .env.example .env` (PowerShell) then `php artisan key:generate`
- Link storage (if not already): `php artisan storage:link`
- Optimize clear (useful after pulls): `php artisan optimize:clear`

Running the app (local without Docker)
- HTTP server: `php artisan serve`
- Vite dev (hot reload): `npm run dev`
- Production asset build: `npm run build`

Database
- Migrate: `php artisan migrate`
- Seed (if seeds available): `php artisan db:seed`

Testing
- Run all tests (Laravel wrapper): `php artisan test`
- Run all tests (PHPUnit directly): `./vendor/bin/phpunit`
- Run a testsuite (example): `./vendor/bin/phpunit --testsuite "Shop Feature Test"`
- Run a single test by class/method:
  - Laravel: `php artisan test --filter "SomeTest::test_example"`
  - PHPUnit: `./vendor/bin/phpunit --filter "SomeTest::test_example"`

Code style
- Check formatting: `./vendor/bin/pint --test`
- Fix formatting: `./vendor/bin/pint`

Docker (summary)
See `DOCKER.md` for details. Core workflow:
- Start stack: `docker-compose up -d --build`
- Install PHP deps: `docker-compose exec app composer install`
- Generate key: `docker-compose exec app php artisan key:generate`
- Migrate: `docker-compose exec app php artisan migrate`
- Dev assets: `docker-compose exec node npm run dev`
- Build assets: `docker-compose exec node npm run build`
- Run tests: `docker-compose exec app php artisan test`

High‑level architecture
- Modular domain packages live under `packages/Webkul/*` and are autoloaded via PSR‑4 (see `composer.json`). Each module typically contains:
  - `src/Providers/*ServiceProvider.php` to register bindings, events, and routes.
  - `src/Routes/*.php` route files (e.g., Admin has `auth-routes.php`, `sales-routes.php`, and `web.php`).
  - `src/Models/`, `src/Repositories/`, `src/Http/Controllers/` for domain logic and transport.
  - Package resources (views/translations) under `src/Resources` where applicable.
- Core cross‑cutting concerns are in `packages/Webkul/Core/src` (helpers, facades, system config, menus, image cache, events, jobs). Many other domain packages (Product, Sales, Inventory, Checkout, CatalogRule, CartRule, Marketing, Payment/Paypal, Shipping, Sitemap, Theme, User, etc.) compose the platform.
- Tests are organized per‑package and grouped by testsuites in `phpunit.xml`:
  - Admin (Feature), Shop (Feature), Core (Unit), DataGrid (Unit). Adjust filters to target specific suites.
- Frontend build is driven by Vite with `vite.config.js` declaring entrypoints. Hot reload requires `npm run dev` alongside the Laravel server (or Nginx in Docker).

GraphQL API
- The GraphQL package (`bagisto/graphql-api`) is included. If setting up or re‑installing, run: `php artisan bagisto-graphql:install`.
- Relevant env keys (configure as needed): `GRAPHQL_ENDPOINT`, `JWT_*`, `APP_SECRET_KEY`. See `SETUP.md` for exact values and notes.

Notes for future agents
- Many services (Redis, Elasticsearch, queues, broadcasting) are optional and driven by `.env`. Defaults in `phpunit.xml` force array/mail fake, sync queues, etc., for test isolation.
- New modules should follow existing package conventions (PSR‑4 under `packages/<Vendor>/<Package>/src`, provider, routes, HTTP/controllers, repositories, resources, and tests under `packages/.../tests`).
