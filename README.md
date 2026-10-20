# Task Management Multi-Tenant Backend

This repository contains the Laravel API backend for a multi-tenant task management application. The project is built around tenant-scoped data access, role-based permissions, project management, and ticket tracking for users working inside isolated workspaces.

## Overview

The backend is designed to support:

- Multiple tenants (organizations/workspaces)
- User authentication and account management
- Tenant membership and invitation-based onboarding
- Project creation and tenant-scoped project access
- Ticket creation, assignment, updates, and status tracking
- Role and permission management for project and ticket operations
- API-first usage for a frontend or admin dashboard

## Tech Stack

- PHP 8.3
- Laravel 13
- Laravel Sanctum
- Spatie Laravel Permission
- MySQL / SQLite / Laravel-supported DBs
- REST API architecture

## Core Domain Model

The app uses a tenant-first data model:

- User: authenticates through Sanctum and belongs to a tenant via membership
- Tenant: represents a company or workspace
- Member: links users to tenants
- Project: belongs to a tenant and can contain many tickets
- Ticket: belongs to a project and a tenant, with assignee, creator, status, and priority
- InvitationLink: used for tenant invite verification/onboarding

## Key Project Features

### Authentication and user lifecycle

- User registration
- User login
- Logout via protected middleware
- Password reset link request and verification
- Account activation/deactivation through user status toggling

### Multi-tenant access control

- Tenant-specific data scoping
- Membership-based access to resources
- Identity check endpoint to confirm the active tenant and account state
- Permission enforcement for project and ticket resources

### Project management

- List all accessible projects
- Create projects within the active tenant
- View project details
- Update existing projects
- Delete projects
- Fetch project tickets by status

### Ticket management

- List tickets
- Create new tickets
- View ticket details
- Update ticket metadata
- Delete tickets
- Change ticket status via a dedicated endpoint
- Set assignee and priority values

### Roles and permissions

- Role listing and role removal endpoints
- Permission listing and update endpoints
- Spatie permission integration for access control

## Repository Structure

```bash
app/
  Enums/
  Http/
    Controllers/
    Requests/
    Resources/
  Models/
  Policies/
  Providers/
  Services/
  Traits/
bootstrap/
config/
database/
  factories/
  migrations/
  seeders/
public/
routes/
  api.php
storage/
tests/
```

## Prerequisites

Before running the app, make sure you have:

- PHP 8.3+
- Composer
- A supported database (MySQL, SQLite, or another Laravel-supported driver)
- Node.js and npm are optional for the frontend asset build, but the project includes Vite config

## Environment Setup

1. Install PHP dependencies:

```bash
composer install
```

2. Copy the example environment file:

```bash
cp .env.example .env
```

3. Generate the Laravel app key:

```bash
php artisan key:generate
```

4. Configure your database in `.env`:

```env
APP_NAME="Task Management"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_management
DB_USERNAME=root
DB_PASSWORD=
```

5. Run database migrations:

```bash
php artisan migrate
```

6. Optional: seed the database if roles or default fixtures are required:

```bash
php artisan db:seed
```

## Run the Application

Start the Laravel development server:

```bash
php artisan serve
```

The API base URL will be:

```bash
http://localhost:8000/api/v1
```

## API Routes

All protected routes are guarded by the `login.verify` middleware unless otherwise noted.

### Authentication

```http
POST /api/v1/auth/register
POST /api/v1/auth/login
GET  /api/v1/auth/logout
POST /api/v1/auth/reset-password
GET  /api/v1/auth/reset-password
```

### Tenant invite and identity checks

```http
GET /api/v1/link/generate
GET /api/v1/auth/link/verify
GET /api/v1/identity-check
```

### Projects

```http
GET    /api/v1/project
POST   /api/v1/project
GET    /api/v1/project/{projectId}/details
PATCH  /api/v1/project/{projectId}
PUT    /api/v1/project/{projectId}
DELETE /api/v1/project/{projectId}
GET    /api/v1/project/{projectId}/tickets
```

### Tickets

```http
GET    /api/v1/ticket
POST   /api/v1/ticket
GET    /api/v1/ticket/{ticketId}/details
PATCH  /api/v1/ticket/{ticketId}
PUT    /api/v1/ticket/{ticketId}
DELETE /api/v1/ticket/{ticketId}/delete
PATCH  /api/v1/ticket/{ticketId}/status
```

### Users, permissions, and roles

```http
GET /api/v1/users/list
GET /api/v1/assignee
PATCH /api/v1/users/{userId}/{status}
GET /api/v1/permission/list
POST /api/v1/permission/update
GET /api/v1/role
DELETE /api/v1/role/{roleId}/delete
```

## Default Behavior and Notes

- Project and ticket resources are scoped by the authenticated user's tenant.
- Tickets include a `status` field and a `priority` field, with enum-backed values in the app.
- The app expects users to belong to a tenant before accessing workspace-scoped data.
- The project is intended to be consumed via a frontend client, mobile client, or admin application using a JSON API.

## Testing

Run the test suite with:

```bash
php artisan test
```

## License

This project is open-source and follows the MIT license used by the Laravel default project setup.
