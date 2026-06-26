# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Commands

### Database
- **Migration**: `php artisan migrate` - Run all pending migrations
- **Fresh migration**: `php artisan migrate:fresh` - Drop all tables and re-run all migrations
- **Rollback**: `php artisan migrate:rollback` - Rollback the last batch of migrations
- **Status**: `php artisan migrate:status` - Check the status of each migration

### Testing
- **Run tests**: `php artisan test` - Run all feature and unit tests
- **Run specific test**: `php artisan test --filter=test_name` - Run tests matching the filter

### Development
- **Serve application**: `php artisan serve` - Start the development server
- **Clear cache**: `php artisan cache:clear` - Clear the application cache
- **Clear config cache**: `php artisan config:clear` - Clear the configuration cache
- **View routes**: `php artisan route:list` - List all registered routes

### Packages
- **Install dependencies**: `composer install` - Install PHP dependencies
- **Update dependencies**: `composer update` - Update PHP dependencies
- **Install JS dependencies**: `npm install` - Install JavaScript dependencies
- **Build assets**: `npm run dev` - Compile assets for development
- **Watch assets**: `npm run watch` - Watch for asset changes and recompile

## Code Architecture

### Overall Structure
This is a Laravel 12 application following the MVC pattern with additional layers for separation of concerns:

```
app/
├── Console/          // Artisan commands
├── Exceptions/       // Exception handlers
├── Http/             // HTTP layer (controllers, middleware, requests)
│   ├── Controllers/  // Request handlers
│   ├── Middleware/   // HTTP middleware
│   └── Requests/     // Form request validation
├── Models/           // Eloquent models
├── Providers/        // Service providers
├── Services/         // Business logic layer
└── Repositories/     // Data access layer
```

### Repository-Service Pattern
This implementation uses the Repository-Service pattern to separate concerns:

1. **Repositories** (`app/Repositories`)
   - Handle data access logic
   - Interface-based design for loose coupling
   - Each repository implements an interface
   - Responsible for CRUD operations and complex queries

2. **Services** (`app/Services`)
   - Contain business logic
   - Coordinate between multiple repositories if needed
   - Handle validation, data transformation, and workflow logic
   - Depend on repository interfaces (injected via Laravel's service container)

3. **Controllers** (`app/Http/Controllers`)
   - Handle HTTP requests and responses
   - Delegate business logic to services
   - Return appropriate HTTP responses (JSON for APIs, views for web)

4. **Models** (`app/Models`)
   - Eloquent ORM models representing database tables
   - Define relationships, mutators, accessors, and scopes

### Dependency Injection
- Repositories are bound to their interfaces in `AppServiceProvider::register()`
- Services and controllers receive dependencies via constructor injection
- Laravel's service container automatically resolves dependencies

### API Structure
- RESTful API routes in `routes/api.php`
- Authenticated routes use `auth:sanctum` middleware
- Resource controllers provide standard CRUD endpoints
- Additional custom routes for specific use cases

## Database Schema
The application uses MySQL with the following key tables (based on PRD requirements):

- **products** - Product information (SKU, name, prices, stock levels, etc.)
- **categories** - Product categories
- **brands** - Product brands
- **warehouses** - Multi-warehouse inventory system
- **product_stocks** - Current stock levels per product per warehouse
- **stock_mutations** - Stock movement history (incoming, outgoing, adjustments)
- **users** - Authentication (Laravel default)
- **roles & permissions** - Using Spatie Laravel Permission package

## Configuration
- Environment variables in `.env` file
- Database connection configured for MySQL (changed from PostgreSQL in original PRD)
- Laravel Sanctum for API authentication
- Spatie Laravel Permission for role-based access control

## Development Guidelines
1. Follow Laravel naming conventions (PascalCase for classes, snake_case for methods/tables)
2. Add type hints to method parameters and return types
3. Use Laravel's validation features (Form Requests or validation in controllers)
4. Keep controllers thin - move business logic to services
5. Keep services focused on a single business capability
6. Repositories should only contain data access logic
7. Use Eloquent relationships instead of raw queries when possible
8. Add appropriate error handling and logging
9. Follow PSR-12 coding standards
10. Write unit tests for services and features tests for controllers