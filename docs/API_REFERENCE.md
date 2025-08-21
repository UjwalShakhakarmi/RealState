# Real Estate Management System – API & Component Reference

## Overview

This document serves as the single source of truth for **all public, developer-facing entry-points** that your Laravel based Real-Estate Management System currently exposes.  
It covers:

* HTTP Routes (web & API) – URL, method, controller ↔ action mapping, middleware/roles, purpose, example requests & responses
* Key Controllers / Services – public methods & their responsibilities
* Core Eloquent Models – attributes & relationships
* Front-end Blade views/components that are intended for re-use

> **Note**  
> All routes reside on the same host as the Laravel application.  Replace `https://your-domain.test` with the appropriate base URL in the examples below.

---

## Authentication & Authorisation

Laravel Sanctum and the built-in session guard are used.

| Scenario | Guard | Routes | Notes |
|----------|-------|--------|-------|
| UI / Backend dashboard | `web` session | All routes in `routes/web.php` | Uses Laravel session cookies, CSRF protection applies to `POST`, `PUT/PATCH`, `DELETE` requests. |
| Programmatic API access | `sanctum` token | `/api/*` | Issue a token via Sanctum prior to hitting the endpoints. |

Role-based access is enforced with the `roles` middleware (`roles:admin`, `roles:agent`) and fine-grained permission middleware (e.g. `permission:all.type`).  Ensure the authenticated user possesses the required role/permission otherwise a `403` will be returned.

---

## Quick-start

```bash
# Log in (creates a session cookie)
curl -s -X POST \ 
     -F "email=admin@example.com" -F "password=secret" \
     -c cookies.txt \
     https://your-domain.test/login

# Hit a protected endpoint using the stored cookie
curl -s -b cookies.txt https://your-domain.test/admin/dashboard
```

For API token flow (Sanctum):

```bash
TOKEN="$(curl -s --request POST \
    --url https://your-domain.test/api/token \
    --data 'email=admin@example.com' --data 'password=secret')"

curl -H "Authorization: Bearer $TOKEN" https://your-domain.test/api/user
```

---

## Route Reference (Web Guard)

### 1. General

| Method | URI | Controller@action | Middleware | Route name |
|--------|-----|------------------|------------|------------|
| GET | `/` | Closure | – | *n/a* |
| GET | `/dashboard` | Closure | `auth`, `verified` | `dashboard` |

### 2. Profile Management

| Method | URI | Action | Middleware | Name |
|--------|-----|--------|------------|------|
| GET | `/profile` | `ProfileController@edit` | `auth` | `profile.edit` |
| PATCH | `/profile` | `ProfileController@update` | `auth` | `profile.update` |
| DELETE | `/profile` | `ProfileController@destroy` | `auth` | `profile.destroy` |

### 3. Admin Authentication

| Method | URI | Action | Middleware | Name |
|--------|-----|--------|------------|------|
| GET | `/admin/login` | `AdminController@AdminLogin` | guest | `admin.login` |
| GET | `/admin/Register` | `AdminController@AdminRegister` | guest | `admin.Register` |
| GET | `/admin/logout` | `AdminController@AdminLogout` | `auth`, `roles:admin` | `admin.logout` |

### 4. Admin Dashboard & Profile

| Method | URI | Action | Middleware | Name |
|--------|-----|--------|------------|------|
| GET | `/admin/dashboard` | `AdminController@AdminDashboard` | `auth`, `roles:admin` | `admin.dashboard` |
| GET | `/admin/Profile` | `AdminController@AdminProfile` | `auth`, `roles:admin` | `admin.profile` |
| POST | `/admin/Profile/Store` | `AdminController@AdminProfileStore` | `auth`, `roles:admin` | `admin.profile.store` |
| GET | `/admin/Profile/ChangePassword` | `AdminController@AdminChangePassword` | `auth`, `roles:admin` | `admin.profile.password` |
| POST | `/admin/update/password` | `AdminController@AdminUpdatePassword` | `auth`, `roles:admin` | `admin.update.password` |

### 5. Property Types

| Method | URI | Action | Middleware | Name | Sample |
|--------|-----|--------|------------|------|--------|
| GET | `/all/type` | `PropertyTypeController@AllType` | `auth`, `roles:admin`, `permission:all.type` | `all.type` | `curl -b cookies.txt https://your-domain.test/all/type` |
| GET | `/add/type` | `PropertyTypeController@AddType` | `auth`, `roles:admin` | `add.type` | — |
| POST | `/store/type` | `PropertyTypeController@StoreType` | `auth`, `roles:admin` | `store.type` | `curl -X POST -b cookies.txt -F "type_name=Apartment" -F "type_icon=fa-home" https://your-domain.test/store/type` |
| GET | `/edit/type/{id}` | `PropertyTypeController@EditType` | `auth`, `roles:admin` | `edit.type` | — |
| POST | `/update/type` | `PropertyTypeController@UpdateType` | `auth`, `roles:admin` | `update.type` | — |
| GET | `/delete/type/{id}` | `PropertyTypeController@DeleteType` | `auth`, `roles:admin` | `delete.type` | — |

### 6. Amenities

| Method | URI | Action | Middleware | Name |
|--------|-----|--------|------------|------|
| GET | `/all/Amenities` | `AmenitiesController@AllAmenities` | `auth`, `roles:admin` | `all.amenities` |
| GET | `/add/Amenities` | `AmenitiesController@AddAmenities` | `auth`, `roles:admin` | `add.amenities` |
| POST | `/store/Amenities` | `AmenitiesController@StoreAmenities` | `auth`, `roles:admin` | `store.amenities` |
| POST | `/Update/Amenities` | `AmenitiesController@UpdateAmenities` | `auth`, `roles:admin` | `update.amenities` |
| GET | `/delete/Amenities/{id}` | `AmenitiesController@DeleteAmenities` | `auth`, `roles:admin` | `delete.amenities` |
| GET | `/edit/Amenities/{id}` | `AmenitiesController@EditAmenities` | `auth`, `roles:admin` | `edit.amenities` |

### 7. Roles & Permissions

| Method | URI | Action | Name |
|--------|-----|--------|------|
| GET | `/all/permission` | `RoleController@AllPermission` | `all.Permission` |
| GET | `/add/permission` | `RoleController@AddPermission` | `add.Permission` |
| POST | `/store/permission` | `RoleController@StorePermission` | `store.Permission` |
| GET | `/edit/permission/{id}` | `RoleController@EditPermission` | `edit.Permission` |
| GET | `/Delete/permission/{id}` | `RoleController@DeletePermission` | `delete.Permission` |
| POST | `/Update/permission` | `RoleController@UpdatePermission` | `Update.Permission` |
| … | *(see full route list)* | | |

> For brevity only representative routes are shown.  Refer to `routes/web.php` for the exhaustive list.

---

## API Route (`/api/*`)

| Method | URI | Description |
|--------|-----|-------------|
| GET | `/api/user` | Returns the authenticated user when a valid Sanctum token is supplied. |

Example:

```bash
curl -H "Authorization: Bearer $TOKEN" https://your-domain.test/api/user
```

---

## Controllers & Public Methods

Below is a high-level summary of the public methods that back the routes above.  Each method ultimately returns an HTML View or redirects; they are **server-rendered** endpoints, not pure JSON APIs.

### `AdminController`

* **AdminDashboard()** – Dashboard landing page for administrators.
* **AdminLogin() / AdminLogout()** – Session based authentication handlers.
* **AdminProfile() / AdminProfileStore()** – View + update own profile, including avatar upload.
* **AdminChangePassword() / AdminUpdatePassword()** – UI and logic for changing password.
* **AllAdmin() / AddAdmin() / StoreAdmin() / EditAdmin() / UpdateAdmin() / DeleteAdmin()** – CRUD for admin users including role assignment via Spatie permissions.

### `PropertyTypeController`

CRUD around property categories (e.g. *Apartment*, *Villa*, *Office Space*).  Stores `type_name` and an accompanying `type_icon` font-awesome class.

### `AmenitiesController`

Manages amenity tags that can be attached to properties (*Pool*, *Parking*, *Gym*…).

### `RoleController`

Wrapper around Spatie roles/permissions with helper screens to attach granular permissions to roles and roles to users.

### `ProfileController`

Handles the self-service profile for the currently authenticated **non-admin** user.

---

## Eloquent Models – Key Attributes

| Model | Table | Core Attributes |
|-------|-------|----------------|
| `User` | `users` | `id`, `name`, `email`, `password`, `role`, `status`, `phone`, `address`, `photo`, timestamps |
| `PropertyType` | `property_types` | `id`, `type_name`, `type_icon`, timestamps |
| `Amenities` | `amenities` | `id`, `amenities_name`, timestamps |

Relationship highlights:

* `User` ↔ `Role` – Many-to-many via Spatie’s tables (`model_has_roles`, `role_has_permissions`).
* `Role` ↔ `Permission` – Many-to-many.

---

## Blade Components & Views

Reusable UI pieces live under `resources/views/backend/…`.

| Path | Purpose |
|------|---------|
| `backend/type` | CRUD screens for property types |
| `backend/Amenities` | CRUD screens for amenities |
| `backend/pages/permission` | Permission create/edit/list views |
| `backend/pages/roles` | Role CRUD |

Blade components can be included as usual:

```blade
<x-admin.layout>
    {{-- Your content here --}}
</x-admin.layout>
```

---

## Error Handling & Validation

All create/update endpoints rely on Laravel’s built-in validation (`$request->validate([...])`).  Validation errors result in a `302` redirect back to the form with error bag data in session.


---

## Contributing

* **Add a new API** – create a controller method, register a route in `routes/web.php` (or `api.php` if JSON only), protect with the appropriate middleware, then update this reference.
* **Regenerate Docs** – After adding routes run the following artisan helper to dump the current list (example):

```bash
php artisan route:list --columns=Method,URI,Name,Middleware,Action | tee docs/route_table.txt
```

---

_Last updated: {{ date('Y-m-d') }}_