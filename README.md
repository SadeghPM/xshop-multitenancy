<div align="center">
    <img width="250" src="resources/images/xshop-logo.svg" alt="xShop logo">
</div>

# xShop Multitenancy Package

> [!NOTE]
> This package provides multitenancy support for xShop, facilitating the management of multiple tenant databases.

## New Features

- Database creation for each tenant.
- Tenant-specific migrations and seeders.
- Automatic admin user creation for tenants.

## Installation

To install the package, follow these steps:

```bash
composer require xshop/multitenancy
```
## Multitenancy Setup

### Initial Setup

Run the multitenancy:setup command to configure multitenancy and create the initial tenant:
```bash
php artisan multitenancy:setup
```
This command will:
1. Configure the necessary settings.
2. Ask for the first tenant's name and domain.
3. Create the tenant and database path in the tenants table.
4. Prompt for admin user details and create the admin user within the tenant's database.

### Adding More Tenants

To add additional tenants, use the multitenancy:create-tenant command:
```bash
php artisan multitenancy:create-tenant
```
This command will:
1. Ask for the tenant's name and domain.
2. Create the tenant in the database.
3. Prompt for admin user details and create the admin user for the new tenant.

### Summary

- multitenancy:setup: For initial configuration and creating the first tenant.
- multitenancy:create-tenant: For adding new tenants.

These commands ensure the multitenancy setup is handled easily, including database creation, migrations, seeders, and admin user setup for each tenant.

<p> 
    Developed With Love! ❤️
</p>
