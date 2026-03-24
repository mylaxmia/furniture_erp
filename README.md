# Universal Team ERP - Inventory Management System

A complete ERP system for furniture, kitchen accessories, and home decor management.

## Quick Start

### 1. Setup Database
```bash
mysql -u root < database/schema.sql
```

### 2. Access Application
```
http://localhost/furniture_erp/
```

### 3. Login
- **Username:** admin
- **Password:** admin123

## Project Structure

- `public/` - Web root (index.php, .htaccess)
- `app/` - Application logic (controllers, models, views)
- `config/` - Configuration files (database.php, constants.php)
- `routes/` - Route definitions (web.php)
- `lang/` - Language files (en.php, pl.php)
- `database/` - Database schema (schema.sql)

## Core Files Overview

| File | Purpose |
|------|---------|
| public/index.php | Main entry point & router |
| public/.htaccess | Clean URL rewriting |
| config/database.php | PDO database connection |
| config/constants.php | App constants & language loader |
| app/Controller.php | Base controller class |
| app/Model.php | Base model class |
| routes/web.php | Route definitions |
| lang/en.php | English translations |
| lang/pl.php | Polish translations |

## Features

- ✅ Clean MVC architecture
- ✅ RESTful-style routing
- ✅ Multi-language support (EN/PL)
- ✅ PDO database layer
- ✅ Bootstrap 5 UI
- ✅ Production-ready structure

## Next Steps

1. Create controllers (DashboardController, ProductController, etc.)
2. Create models (Product, Supplier, Invoice, etc.)
3. Build views for each module
4. Implement business logic
