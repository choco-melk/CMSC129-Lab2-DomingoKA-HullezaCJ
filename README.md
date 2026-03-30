# Project Manager

A Laravel-based web application for managing projects, including features like project creation, editing, deletion, assignment to collaborators, and due date tracking.

## Application Description and Purpose

This is a simple project management application built with Laravel. It allows users to create, view, edit, and delete projects. Each project can have a title, description, assigned collaborators from a predefined list, an optional thumbnail image, and a due date. The application uses Laravel's MVC architecture, Eloquent ORM for database interactions, and Blade templating for views.

The purpose of this application is to demonstrate a basic CRUD (Create, Read, Update, Delete) system in Laravel, with file uploads, form validation, and database migrations.

## Installation and Setup Instructions

### Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js and npm (for frontend assets)
- PostgreSQL database

### Steps
1. **Clone the repository:**
   ```bash
   git clone <repository-url>
   cd project-manager
   ```

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies:**
   ```bash
   npm install
   ```

4. **Build frontend assets:**
   ```bash
   npm run build
   ```

5. **Set up environment file:**
   - Copy `.env.example` to `.env`
   - Update the database configuration in `.env` (see Database Setup below)

6. **Generate application key:**
   ```bash
   php artisan key:generate
   ```

## Database Setup Guide (PostgreSQL)

1. **Install PostgreSQL:**
   - Download and install PostgreSQL from [postgresql.org](https://www.postgresql.org/download/).
   - During installation, set a password for the `postgres` user (e.g., `hulleza04`).

2. **Create a database:**
   - Open pgAdmin or use the command line.
   - Create a new database named `project-management-app`.

3. **Update .env file:**
   Ensure your `.env` file has the following database configuration:
   ```
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=project-management-app
   DB_USERNAME=postgres
   DB_PASSWORD=your_password_here
   ```

4. **Run migrations:**
   ```bash
   php artisan migrate
   ```

## Migration Commands

- **Run all pending migrations:**
  ```bash
  php artisan migrate
  ```

- **Rollback the last migration:**
  ```bash
  php artisan migrate:rollback
  ```

- **Reset and rerun all migrations:**
  ```bash
  php artisan migrate:fresh
  ```

- **Seed the database (if seeders exist):**
  ```bash
  php artisan db:seed
  ```

## Screenshots of Your Application
- Home page showing list of projects
<div><img width="1889" height="906" alt="image" src="https://github.com/user-attachments/assets/aca42bde-06c6-427c-8ca5-7f6ece23e246" /></div>

- Create project form
<div><img width="1895" height="908" alt="image" src="https://github.com/user-attachments/assets/76dfb156-5961-4587-bee7-8ed8270787e0" /></div>

- Edit project form
<div><img width="1059" height="867" alt="image" src="https://github.com/user-attachments/assets/817e3bee-8ba5-4b9f-8c79-f231429becb9" /></div>
  
- Delete project page
<div><img width="1223" height="538" alt="image" src="https://github.com/user-attachments/assets/4fdb00cd-8e95-4460-afc8-fbe9f0efa58d" /></div>

## List of Features Implemented

- **Project CRUD Operations:**
  - Create new projects with title, description, collaborators, thumbnail, and due date
  - View all projects in a card-based layout
  - Edit existing projects
  - Delete projects with confirmation

- **Collaborator Assignment:**
  - Assign projects to multiple collaborators from a predefined list (Clyde, Jave, Keith, Neyro, Mark)

- **File Upload:**
  - Upload thumbnail images for projects (stored in `storage/app/public/projects`)

- **Form Validation:**
  - Server-side validation for all form inputs
  - Error display on forms

- **Due Date Tracking:**
  - Optional due date field for projects
  - Display formatted due dates

- **Responsive Design:**
  - Basic CSS styling for desktop and mobile

## MVC Architecture Explanation

This application follows Laravel's Model-View-Controller (MVC) architecture:

### Models
Located in `app/Models/`:
- **Project.php**: Represents the Project entity. Uses Eloquent ORM for database interactions.
  - `fillable`: Defines mass-assignable attributes (title, description, assigned_to, thumbnail, due_date)
  - `getAssignedToArrayAttribute()`: Accessor to get assigned collaborators as an array

### Views
Located in `resources/views/`:
- **layouts/app.blade.php**: Main layout template with header and footer
- **projects/index.blade.php**: Lists all projects using project-card component
- **projects/create.blade.php**: Form to create new projects
- **projects/edit.blade.php**: Form to edit existing projects
- **projects/confirm_delete.blade.php**: Confirmation page for deletion
- **projects/form.blade.php**: Shared form component for create/edit
- **components/project-card.blade.php**: Displays individual project information

### Controllers
Located in `app/Http/Controllers/`:
- **ProjectController.php**: Handles all project-related HTTP requests
  - `index()`: Display list of projects
  - `create()`: Show create form
  - `store()`: Validate and save new project
  - `edit()`: Show edit form
  - `update()`: Validate and update project
  - `confirmDelete()`: Show delete confirmation
  - `destroy()`: Delete project
  - `collaborators()`: Returns list of available collaborators

### Project Structure with Comments

```
project-manager/
├── app/                          # Application core
│   ├── Http/Controllers/         # Controllers handle requests
│   │   └── ProjectController.php # Main controller for projects
│   └── Models/                   # Eloquent models
│       ├── Project.php           # Project model with ORM
│       └── User.php              # User model (Laravel default)
├── bootstrap/                    # Laravel bootstrap files
├── config/                       # Configuration files
│   ├── app.php                   # App configuration
│   ├── database.php              # Database configuration
│   └── ...                       # Other configs
├── database/                     # Database related files
│   ├── factories/                # Model factories for testing
│   ├── migrations/               # Database schema migrations
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   └── 2026_03_30_120000_create_projects_table.php # Projects table
│   └── seeders/                  # Database seeders
├── public/                       # Public assets (CSS, JS, images)
│   ├── index.php                 # Entry point
│   └── storage/                  # Symlinked storage for uploaded files
├── resources/                    # Frontend resources
│   ├── css/                      # Stylesheets
│   ├── js/                       # JavaScript files
│   └── views/                    # Blade templates
│       ├── components/           # Reusable view components
│       ├── layouts/              # Layout templates
│       └── projects/             # Project-specific views
├── routes/                       # Route definitions
│   └── web.php                   # Web routes
├── storage/                      # File storage
│   ├── app/                      # App storage (uploads, etc.)
│   └── logs/                     # Application logs
├── tests/                        # Test files
└── vendor/                       # Composer dependencies
```

### Routing
- Routes are defined in `routes/web.php`
- Uses resource routing for projects: `Route::resource('projects', ProjectController::class)`

### Database
- Uses PostgreSQL with Eloquent ORM
- Migrations define schema changes
- Models handle data access and relationships

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
