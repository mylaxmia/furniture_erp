# Universal Team - ERP Inventory Management System
## Complete Infrastructure & Architecture Design

---

## 📁 PROJECT FOLDER STRUCTURE

```
universal-team/
│
├── public/                          # Web root (entry point)
│   ├── index.php                    # Main router/entry point
│   ├── .htaccess                    # URL rewriting for clean URLs
│   ├── css/
│   │   ├── bootstrap.min.css        # Bootstrap 5
│   │   └── style.css                # Custom styling
│   ├── js/
│   │   ├── bootstrap.bundle.min.js  # Bootstrap JS
│   │   └── app.js                   # Custom JS
│   └── uploads/                     # Product images, invoices
│
├── app/                             # Application logic
│   ├── controllers/
│   │   ├── DashboardController.php
│   │   ├── ProductController.php
│   │   ├── SupplierController.php
│   │   ├── InvoiceController.php
│   │   ├── DeliveryController.php
│   │   ├── SalesController.php
│   │   └── AuthController.php
│   │
│   ├── models/
│   │   ├── User.php
│   │   ├── Product.php
│   │   ├── Category.php
│   │   ├── Supplier.php
│   │   ├── Invoice.php
│   │   ├── InvoiceItem.php
│   │   ├── Delivery.php
│   │   └── Sale.php
│   │
│   └── views/
│       ├── layout/
│       │   ├── header.php
│       │   ├── sidebar.php
│       │   └── footer.php
│       ├── dashboard/
│       │   └── index.php
│       ├── products/
│       │   ├── index.php            # List products
│       │   └── form.php             # Add/Edit product
│       ├── suppliers/
│       │   ├── index.php
│       │   └── form.php
│       ├── invoices/
│       │   ├── index.php
│       │   └── view.php
│       ├── deliveries/
│       │   └── index.php
│       ├── sales/
│       │   └── form.php
│       └── auth/
│           ├── login.php
│           └── register.php
│
├── config/
│   ├── database.php                 # DB connection (PDO)
│   ├── constants.php                # App constants
│   ├── .env.example                 # Environment variables template
│   └── .env                         # Local environment (Git ignored)
│
├── routes/
│   └── web.php                      # All route definitions
│
├── lang/
│   ├── en.php                       # English translations
│   └── pl.php                       # Polish translations
│
├── storage/
│   └── logs/
│       └── app.log                  # Application logs
│
├── database/
│   ├── schema.sql                   # Database schema
│   └── seeders.sql                  # Sample data (optional)
│
├── .gitignore
├── README.md
└── composer.json (if using Composer later)
```

---

## 📋 FILE RESPONSIBILITIES

### **Core Entry Point**
- **public/index.php** → Routes incoming requests to appropriate controller
- **public/.htaccess** → Rewrites clean URLs (e.g., /products → /index.php?route=products)

### **Controllers** (app/controllers/)
Each handles specific business logic:
- `DashboardController.php` → Dashboard statistics, overview
- `ProductController.php` → CRUD for products (List, Create, Update, Delete)
- `SupplierController.php` → Supplier management (CRUD)
- `InvoiceController.php` → Invoice generation, viewing, PDF export
- `DeliveryController.php` → Track shipments, manage delivery status
- `SalesController.php` → Point-of-sale, customer sales transactions
- `AuthController.php` → Login, logout, authentication logic

### **Models** (app/models/)
Database interaction layer:
- `User.php` → User authentication, roles
- `Product.php` → Product queries (list, search, filter by category)
- `Category.php` → Category management
- `Supplier.php` → Supplier data, NIP validation
- `Invoice.php` → Invoice creation, storage, retrieval
- `InvoiceItem.php` → Individual invoice line items (VAT, quantity, price)
- `Delivery.php` → Shipment tracking
- `Sale.php` → Sales transactions

### **Views** (app/views/)
HTML templates rendered by controllers:
- `layout/` → Shared layout components (header, sidebar, footer)
- Module folders → Templates scoped to each feature

### **Configuration Files**
- `config/database.php` → PDO connection logic
- `config/constants.php` → App constants (VAT rates, company info)
- `config/.env` → Environment-specific variables (not Git tracked)
- `routes/web.php` → All routing definitions

### **Localization**
- `lang/en.php` → English strings (keys: 'dashboard', 'products', etc.)
- `lang/pl.php` → Polish strings (same keys, Polish values)

---

## 🗄️ DATABASE SCHEMA (NORMALIZED)

### **Table: users**
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'manager', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```
**Purpose:** Authentication & authorization

---

### **Table: categories**
```sql
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```
**Purpose:** Product categorization (Furniture, Kitchen, Decor)

---

### **Table: products**
```sql
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    sku VARCHAR(50) UNIQUE,
    category_id INT NOT NULL,
    description TEXT,
    purchase_price DECIMAL(10,2),
    selling_price DECIMAL(10,2),
    quantity INT DEFAULT 0,
    condition ENUM('new', 'used') DEFAULT 'new',
    vat_rate DECIMAL(5,4) DEFAULT 0.23,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);
```
**Purpose:** Store product catalog with pricing & inventory

---

### **Table: suppliers**
```sql
CREATE TABLE suppliers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_name VARCHAR(255) NOT NULL,
    nip VARCHAR(10) UNIQUE,
    contact_person VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20),
    bank_account VARCHAR(34),
    ksef_id VARCHAR(255),
    default_vat_rate DECIMAL(5,4) DEFAULT 0.23,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```
**Purpose:** Supplier master data for purchases

---

### **Table: invoices**
```sql
CREATE TABLE invoices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_number VARCHAR(50) UNIQUE NOT NULL,
    supplier_id INT,
    invoice_date DATETIME NOT NULL,
    due_date DATETIME,
    total_amount DECIMAL(10,2),
    vat_amount DECIMAL(10,2),
    status ENUM('draft', 'issued', 'paid', 'cancelled') DEFAULT 'draft',
    xml_data LONGTEXT,
    pdf_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (supplier_id) REFERENCES suppliers(id) ON DELETE SET NULL
);
```
**Purpose:** Invoice records for purchases/sales (KSeF compliant)

---

### **Table: invoice_items**
```sql
CREATE TABLE invoice_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_id INT NOT NULL,
    product_id INT,
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2),
    vat_rate DECIMAL(5,4),
    line_total DECIMAL(10,2),
    FOREIGN KEY (invoice_id) REFERENCES invoices(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL
);
```
**Purpose:** Individual line items for each invoice

---

### **Table: sales**
```sql
CREATE TABLE sales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sale_date DATETIME NOT NULL,
    customer_name VARCHAR(255),
    total_amount DECIMAL(10,2),
    vat_amount DECIMAL(10,2),
    payment_method ENUM('cash', 'card', 'bank_transfer') DEFAULT 'cash',
    status ENUM('completed', 'pending', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```
**Purpose:** Sales transactions (POS or wholesale)

---

### **Table: sale_items**
```sql
CREATE TABLE sale_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sale_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2),
    vat_rate DECIMAL(5,4),
    line_total DECIMAL(10,2),
    FOREIGN KEY (sale_id) REFERENCES sales(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);
```
**Purpose:** Line items for sales

---

### **Table: deliveries**
```sql
CREATE TABLE deliveries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_id INT,
    tracking_number VARCHAR(100),
    shipping_date DATETIME,
    expected_delivery DATETIME,
    actual_delivery DATETIME,
    status ENUM('pending', 'shipped', 'in_transit', 'delivered', 'returned') DEFAULT 'pending',
    carrier VARCHAR(100),
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (invoice_id) REFERENCES invoices(id) ON DELETE SET NULL
);
```
**Purpose:** Track shipments & deliveries

---

### **Relationships Summary**
```
users (1) ----< many invoices
categories (1) ----< many products
products (1) ----< many invoice_items
products (1) ----< many sale_items
suppliers (1) ----< many invoices
invoices (1) ----< many invoice_items
invoices (1) ----< many deliveries
sales (1) ----< many sale_items
```

---

## 🧭 ROUTING SYSTEM

### **Router Logic** (public/index.php entry point)
```
1. Parse URL from request
2. Match route in routes/web.php
3. Instantiate controller
4. Call controller method
5. Render view
```

### **Routes Definition** (routes/web.php)

| Route | Controller | Method | Purpose |
|-------|------------|--------|---------|
| `/` | DashboardController | index | Main dashboard |
| `/products` | ProductController | index | List products |
| `/products/create` | ProductController | create | Show form |
| `/products/store` | ProductController | store | Save product (POST) |
| `/products/edit/:id` | ProductController | edit | Edit form |
| `/products/update/:id` | ProductController | update | Save changes (POST) |
| `/products/delete/:id` | ProductController | delete | Remove product |
| `/suppliers` | SupplierController | index | List suppliers |
| `/suppliers/add` | SupplierController | create | Add form |
| `/suppliers/store` | SupplierController | store | Save supplier (POST) |
| `/invoices` | InvoiceController | index | List invoices |
| `/invoices/:id` | InvoiceController | view | View single invoice |
| `/invoices/:id/pdf` | InvoiceController | pdf | Generate PDF |
| `/deliveries` | DeliveryController | index | Track deliveries |
| `/sell` | SalesController | create | POS form |
| `/sell/save` | SalesController | store | Save sale (POST) |
| `/login` | AuthController | login | Login form |
| `/logout` | AuthController | logout | Logout |
| `/settings` | SettingsController | index | App settings |

### **.htaccess Rewrite Rules**
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /universal-team/
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php?route=$1 [QSA,L]
</IfModule>
```
**Result:** `/products` → `/index.php?route=products`

---

## 🌍 MULTI-LANGUAGE SYSTEM

### **Language Files**
**lang/en.php**
```php
$lang = [
    'dashboard' => 'Dashboard',
    'products' => 'Products',
    'suppliers' => 'Suppliers',
    'invoices' => 'Invoices',
    'deliveries' => 'Deliveries',
    'sell' => 'Sell Product',
    'settings' => 'Settings',
    'logout' => 'Logout',
    'language' => 'Language',
    // ... more keys
];
```

**lang/pl.php**
```php
$lang = [
    'dashboard' => 'Panel Główny',
    'products' => 'Produkty',
    'suppliers' => 'Dostawcy',
    'invoices' => 'Faktury',
    'deliveries' => 'Dostawy',
    'sell' => 'Sprzedaj',
    'settings' => 'Ustawienia',
    'logout' => 'Wyloguj',
    'language' => 'Język',
    // ... more keys
];
```

### **Helper Function**
```php
// In config/constants.php
function t($key) {
    global $lang;
    return $lang[$key] ?? $key;
}

// In layout, use: echo t('dashboard');
```

### **Language Switching**
```php
// Session or cookie-based
$_SESSION['lang'] = $_POST['lang'] ?? 'en'; // Default English
require_once __DIR__ . '/../lang/' . $_SESSION['lang'] . '.php';
```

---

## 🖥️ UI LAYOUT STRUCTURE

### **Main Layout** (app/views/layout/header.php)
```
┌─────────────────────────────────────────────────────┐
│ Universal Team | EN / PL | User: John | Logout      │  ← Header
├──────────────────────────────────────────────────────┤
│      │                                                │
│ SIDEBAR  │                 CONTENT AREA              │
│      │                                                │
│ • Dashboard  │  Dashboard / Products / Invoices      │
│ • Products   │  (Dynamic based on route)             │
│ • Create Prd │                                        │
│ • Suppliers  │                                        │
│ • Invoices   │                                        │
│ • Delivery   │                                        │
│ • Sell       │                                        │
│ • Settings   │                                        │
│      │                                                │
├──────────────────────────────────────────────────────┤
│ Footer: © 2026 Universal Team                        │  ← Footer
└──────────────────────────────────────────────────────┘
```

### **Key Components**
- **Header:** Fixed top, company logo, language switcher (EN/PL), user menu
- **Sidebar:** Fixed left nav, links to modules, responsive (collapse on mobile)
- **Content:** Dynamic based on route, Bootstrap grid layout
- **Footer:** Company info, copyright

### **Responsive Design**
- Mobile: Sidebar collapsible hamburger menu
- Tablet: Sidebar sticky, content responsive
- Desktop: Full layout as shown

---

## 🔐 AUTHENTICATION SYSTEM

### **Flow**
1. User visits `/login`
2. Submits credentials (username/password)
3. AuthController validates against `users` table
4. On success: Set `$_SESSION['user_id']`, redirect to `/`
5. On failure: Show error, redirect to `/login`
6. Middleware checks `$_SESSION['user_id']` on protected routes

### **Session Management**
```php
// Protect routes
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}
```

### **Password Security**
```php
// Store: password_hash($password, PASSWORD_BCRYPT)
// Verify: password_verify($input, $stored_hash)
```

---

## ⚙️ CONFIGURATION FILES

### **config/database.php** (PDO Connection)
```php
$host = $_ENV['DB_HOST'] ?? 'localhost';
$dbname = $_ENV['DB_NAME'] ?? 'universal_team';
$user = $_ENV['DB_USER'] ?? 'root';
$pass = $_ENV['DB_PASS'] ?? '';

$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
```

### **config/constants.php**
```php
define('COMPANY_NAME', 'Universal Team');
define('VAT_STANDARD', 0.23);
define('VAT_REDUCED_8', 0.08);
define('VAT_REDUCED_5', 0.05);
define('CURRENCY', 'PLN');
```

### **config/.env** (Local Development Only - Git Ignored)
```
DB_HOST=localhost
DB_NAME=universal_team
DB_USER=root
DB_PASS=
APP_DEBUG=true
APP_ENV=local
```

### **config/.env.example** (Template for deployment)
```
DB_HOST=your_host
DB_NAME=your_database
DB_USER=your_user
DB_PASS=your_password
APP_DEBUG=false
APP_ENV=production
```

---

## 🚀 DEPLOYMENT ARCHITECTURE

### **Phase 1: Local Development (XAMPP)**
```
1. Clone repo to c:\xampp\htdocs\universal-team\
2. Create .env file from .env.example
3. Set DB_NAME=universal_team (local)
4. Import schema.sql to MySQL
5. Access http://localhost/universal-team/
6. Test all features locally
```

### **Phase 2: Git Setup**
```
1. Initialize Git repo: git init
2. Create .gitignore:
   - .env
   - storage/logs/*
   - public/uploads/*
3. First commit: git add . && git commit -m "Initial commit"
4. Create GitHub repo
5. Add remote: git remote add origin https://github.com/user/universal-team
6. Push: git push -u origin main
```

### **Phase 3: Shared Hosting Setup**
```
1. Hosting provider: cPanel / Plesk
2. Create MySQL database & user
3. Create FTP/SSH account
4. Point domain to public/ folder
5. Enable mod_rewrite (for .htaccess)
```

### **Phase 4: Deploy to Live**
```bash
# On live server via SSH:
cd /var/www/html/universal-team
git clone https://github.com/user/universal-team .
cp config/.env.example config/.env
# Edit .env with production DB credentials
mysql -u db_user -p db_name < database/schema.sql
chmod -R 775 storage/logs public/uploads
# Test: Visit domain.com
```

### **Phase 5: Production Config**
```
update config/.env:
- DB_HOST = hosting's MySQL host
- DB_NAME = production database
- DB_USER = production user
- DB_PASS = strong password
- APP_DEBUG = false
- APP_ENV = production
```

### **Phase 6: Ongoing Updates**
```bash
# Local development
git add . && git commit -m "Feature: Add new product field"
git push

# On live server
cd /var/www/html/universal-team
git pull
# Test if DB migration needed: mysql < database/migrations.sql
```

---

## 📊 TRAFFIC FLOW DIAGRAM

```
User Request
    ↓
Load Balancer (if multi-server)
    ↓
public/index.php (entry point)
    ↓
routes/web.php (match route)
    ↓
app/controllers/*Controller.php (business logic)
    ↓
app/models/*.php (database queries)
    ↓
app/views/*.php (render HTML)
    ↓
Send HTML to Browser
    ↓
public/css/*.css + public/js/*.js (styling & interactivity)
```

---

## 📋 FILE CREATION CHECKLIST

### **Phase 1: Setup**
- [ ] Folder structure created
- [ ] Common files: .gitignore, README.md
- [ ] config/.env files setup

### **Phase 2: Database**
- [ ] database/schema.sql created
- [ ] Tables with relationships defined
- [ ] Primary/Foreign keys set

### **Phase 3: Core**
- [ ] public/index.php (router)
- [ ] public/.htaccess (URL rewriting)
- [ ] routes/web.php (all routes defined)

### **Phase 4: Models**
- [ ] app/models/ (all model classes)
- [ ] Database connection logic in config/database.php

### **Phase 5: Controllers**
- [ ] app/controllers/ (all controller classes)
- [ ] Each controller method mapped to route

### **Phase 6: Views**
- [ ] app/views/layout/ (header, sidebar, footer)
- [ ] app/views/*/ (module views)

### **Phase 7: Localization**
- [ ] lang/en.php (English strings)
- [ ] lang/pl.php (Polish strings)
- [ ] t() helper function in config/constants.php

### **Phase 8: Auth**
- [ ] AuthController with login/logout
- [ ] Session middleware for protected routes

### **Phase 9: Styling**
- [ ] Bootstrap 5 in public/css/
- [ ] Custom CSS in public/css/style.css

### **Phase 10: Deployment**
- [ ] Git repository setup
- [ ] GitHub remote configured
- [ ] Deployment scripts/docs

---

## 🎯 SCALABILITY CONSIDERATIONS

1. **Database Optimization:**
   - Add indexes on frequently queried columns (sku, invoice_number)
   - Archive old invoices to separate table if needed

2. **Code Reusability:**
   - Base Controller class for shared methods
   - Base Model class for common database operations
   - Helper functions for repeated logic

3. **Caching:**
   - Store category list in session (rarely changes)
   - Cache product pricing if using external source

4. **Logging:**
   - Log all user actions (login, create invoice, etc.)
   - Error logging in storage/logs/app.log

5. **Security:**
   - Prepared statements for all SQL queries (prevent injection)
   - Input validation & sanitization
   - CSRF tokens for forms
   - Rate limiting on login attempts

---

## 📝 SUMMARY

This architecture provides:
✅ Clear separation of concerns (MVC pattern)
✅ Scalable folder structure
✅ Normalized database design (Polish compliance ready)
✅ Multi-language support (EN/PL)
✅ Clean routing system
✅ Production-ready deployment workflow
✅ Beginner-friendly yet enterprise-scalable
✅ Git-based version control
✅ Security foundations

**Next Steps:** Generate actual files following this architecture.
