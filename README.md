# Task Management Multi-Tenant Backend

This is the Laravel backend for a multi-tenant task management system. The application is designed to support multiple organizations (tenants) with isolated data, project-based task tracking, and secure access through authenticated API routes.

## Overview

The backend provides the core API for:

- Multi-tenant workspaces
- User authentication and registration
- Tenant membership management
- Project creation and management
- Ticket/task management
- Ticket status updates
- Invitation link verification for tenant onboarding
- Role-based access control using Spatie Permission

## Tech Stack

- PHP 8.3
- Laravel 13
- Laravel Sanctum for API authentication
- Spatie Laravel Permission for authorization
- MySQL / SQLite compatible Laravel database setup
- REST API architecture

## Core Features

### Multi-tenant Architecture

Each user belongs to a tenant and can access data scoped to that tenant. Tenants are identified by a slug and a name, and membership is tracked through the `member` table.

### Authentication

The API supports:

- User registration
- User login
- Logout
- Protected routes with Sanctum middleware

### Tenant Onboarding

The project includes invitation-based flow support:

- Generate invitation link
- Verify invitation link
- Accept invites for tenant membership

### Project Management

Users can:

- Create projects
- View a list of projects
- Fetch a single project
- Update project details
- Delete projects

### Ticket Management

Each ticket contains:

- Title
- Description
- Status
- Priority
- Assignee
- Due date
- Creator
- Tenant association

Supported statuses:

- to-do
- in-progress
- completed

Supported priorities:

- low
- medium
- high

## Project Structure

```bash
app/
  Enums/
  Http/
  Models/
  Policies/
  Providers/
  Services/
  Traits/
config/
database/
  migrations/
  seeders/
routes/
  api.php
tests/
```

## Main API Routes

Base URL:

```bash
/api/v1
```

### Authentication

```bash
POST /api/v1/auth/register
POST /api/v1/auth/login
GET  /api/v1/auth/logout
GET  /api/v1/auth/link/verify
```

### Invitations

```bash
GET /api/v1/link/generate
```

### Projects

```bash
GET    /api/v1/project
POST   /api/v1/project
GET    /api/v1/project/{project}
PUT    /api/v1/project/{project}
DELETE /api/v1/project/{project}
```

### Tickets

```bash
GET    /api/v1/ticket
POST   /api/v1/ticket
GET    /api/v1/ticket/{ticket}1
PUT    /api/v1/ticket/{ticket}
DELETE /api/v1/ticket/{ticket}
PATCH  /api/v1/ticket-status/{ticket}
```

## Roles and Permissions

The application uses role-based permissions for project and ticket access, including:

- Owner
- Member

Permissions are managed with Spatie Permission and are applied to project and ticket operations.

## Environment Setup

1. Install PHP dependencies:

```bash
composer install
```

2. Create your environment file:

```bash
cp .env.example .env
```

3. Generate the application key:

```bash
php artisan key:generate
```

4. Configure your database in `.env`:

```env
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

6. Optionally seed roles and permissions:

```bash
php artisan db:seed
```

## Run the Application

Start the Laravel development server:

```bash
php artisan serve
```

The API will be available at:

```bash
http://localhost:8000/api/v1
```

## Example Workflow

1. Register a user using the `/auth/register` endpoint.
2. Create or join a tenant workspace.
3. Generate or verify an invitation link for teammates.
4. Create projects under the tenant.
5. Add tasks/tickets to projects.
6. Update ticket status as work progresses.

## Notes

This project is actively structured as a backend service for a multi-tenant SaaS workflow and is intended to be consumed by a frontend application or admin dashboard. The current implementation focuses on API-driven operations, tenant isolation, and task management logic.

## License

This project is open-source and uses the MIT license, consistent with the default Laravel project setup.
