-- Universal Team ERP Database Schema
-- MySQL 5.7+

CREATE DATABASE IF NOT EXISTS universal_team;
USE universal_team;

-- Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'manager', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Categories Table
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Products Table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    sku VARCHAR(50) UNIQUE NOT NULL,
    category_id INT,
    description TEXT,
    purchase_price DECIMAL(10,2),
    selling_price DECIMAL(10,2),
    quantity INT DEFAULT 0,
    `condition` ENUM('new', 'used') DEFAULT 'new',
    vat_rate DECIMAL(5,4) DEFAULT 0.23,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    KEY (category_id),
    INDEX (sku),
    CONSTRAINT fk_product_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Suppliers Table
CREATE TABLE IF NOT EXISTS suppliers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_name VARCHAR(255) NOT NULL,
    nip VARCHAR(10) UNIQUE,
    contact_person VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20),
    bank_account VARCHAR(34),
    ksef_id VARCHAR(255),
    default_vat_rate DECIMAL(5,4) DEFAULT 0.23,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX (nip)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Invoices Table
CREATE TABLE IF NOT EXISTS invoices (
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
    INDEX (invoice_number),
    INDEX (status),
    KEY (supplier_id),
    CONSTRAINT fk_invoice_supplier FOREIGN KEY (supplier_id) REFERENCES suppliers(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Invoice Items Table
CREATE TABLE IF NOT EXISTS invoice_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_id INT NOT NULL,
    product_id INT,
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2),
    vat_rate DECIMAL(5,4),
    line_total DECIMAL(10,2),
    INDEX (invoice_id),
    KEY (product_id),
    CONSTRAINT fk_invoice_item_invoice FOREIGN KEY (invoice_id) REFERENCES invoices(id) ON DELETE CASCADE,
    CONSTRAINT fk_invoice_item_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sales Table
CREATE TABLE IF NOT EXISTS sales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sale_date DATETIME NOT NULL,
    customer_name VARCHAR(255),
    total_amount DECIMAL(10,2),
    vat_amount DECIMAL(10,2),
    payment_method ENUM('cash', 'card', 'bank_transfer') DEFAULT 'cash',
    status ENUM('completed', 'pending', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX (status),
    INDEX (sale_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sale Items Table
CREATE TABLE IF NOT EXISTS sale_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sale_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2),
    vat_rate DECIMAL(5,4),
    line_total DECIMAL(10,2),
    INDEX (sale_id),
    KEY (product_id),
    CONSTRAINT fk_sale_item_sale FOREIGN KEY (sale_id) REFERENCES sales(id) ON DELETE CASCADE,
    CONSTRAINT fk_sale_item_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Deliveries Table
CREATE TABLE IF NOT EXISTS deliveries (
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
    INDEX (tracking_number),
    INDEX (status),
    KEY (invoice_id),
    CONSTRAINT fk_delivery_invoice FOREIGN KEY (invoice_id) REFERENCES invoices(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample data
INSERT IGNORE INTO categories (id, name, description) VALUES
(1, 'Furniture', 'Furniture items'),
(2, 'Kitchen', 'Kitchen accessories'),
(3, 'Decor', 'Home decor items');

-- Create default admin user (password: admin123)
INSERT IGNORE INTO users (username, email, password, role) VALUES
('admin', 'admin@universal-team.local', '$2y$10$YJhStoum.Eyy3OwqIy1p2OPST9/PgBkqquzi.Ss7KIUgO2nsCYL1C', 'admin');
