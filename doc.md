# Project Feature Documentation (Without Blog Section)

## Technology Stack

- **Language:** PHP
- **Framework:** Laravel 12
- **Database:** Configurable (MySQL, SQLite, etc. — default for testing: SQLite)
- **Other Packages:** spatie/laravel-permission, spatie/laravel-backup, etc.

---

## Main Features and Endpoints (excluding blog)

### 1. Brand Utilities API

- **POST /api/generate-slug**  
  Generate a slug for a brand name (backend utility for Brands).
  - Controller: `App\Http\Controllers\API\BrandController.php`

---

### 2. Web Pages & Content
  There is no requirement for web pages and content that is completely optional for now.
  
---

### 3. Admin Panel (all endpoints prefixed with `/admin`)

- **Authentication**
  - `/admin/login` (POST): Admin login
  - `/admin/logout` (POST): Logout
  - `/admin/register` (GET/POST): Register new admin

- **Dashboard**
  - `/admin/dashboard` (GET): Dashboard overview (Requires authentication)
  - `/admin/dashboard/data` (GET): AJAX dashboard data

- **User and Roles Management**
  - `/admin/roles`, `/admin/roles/create`, `/admin/roles/edit-role/{id}`, etc.: Full CRUD for user roles
  - `/admin/users`, `/admin/users/create`, `/admin/users/edit-user/{id}`, etc.: Full CRUD for admin users

- **Product and Inventory Management**
  - `/admin/products`, `/admin/add-product`, `/admin/products/trashed`, etc.
    - List, create, edit, restore, force-delete products



- **Other Features**
  - Billing: `/admin/bill`, `/admin/print-bill`
  - Stock management: `/admin/stock`

*For a fully granular list, refer to routes in* `routes/admin.php`.

---

## Example API (OpenAPI Spec — partial for Brand utility)

```yaml
openapi: 3.0.0
info:
  title: Brand Utility API
  version: 1.0.0
paths:
  /api/generate-slug:
    post:
      summary: Generate a slug for a brand name
      responses:
        '200':
          description: Generated slug
```

---

## Notes

- All `/admin` section routes typically require authentication (Laravel middleware `auth:admin`.)
- The CMS features enable full management of static and dynamic content, products/inventory, users, and auxiliary business functions excluding blog.
- This documentation intentionally omits any endpoints, classes, or business logic related to blogging or blogs.
