<?php
/**
 * Route Definitions
 * Maps URLs to controller methods
 */

$routes = [
    // Auth Routes (Public - no session required)
    'login' => ['controller' => 'AuthController', 'method' => 'login', 'protected' => false],
    'logout' => ['controller' => 'AuthController', 'method' => 'logout', 'protected' => false],
    'forgot-password' => ['controller' => 'AuthController', 'method' => 'forgotPassword', 'protected' => false],
    'reset-password' => ['controller' => 'AuthController', 'method' => 'resetPassword', 'protected' => false],
    
    // Dashboard
    '/' => ['controller' => 'DashboardController', 'method' => 'index', 'protected' => true],
    'dashboard' => ['controller' => 'DashboardController', 'method' => 'index', 'protected' => true],
    
    // Products
    'products' => ['controller' => 'ProductController', 'method' => 'index', 'protected' => true],
    'products/create' => ['controller' => 'ProductController', 'method' => 'create', 'protected' => true],
    'products/store' => ['controller' => 'ProductController', 'method' => 'store', 'protected' => true],
    'products/edit' => ['controller' => 'ProductController', 'method' => 'edit', 'protected' => true],
    'products/update' => ['controller' => 'ProductController', 'method' => 'update', 'protected' => true],
    'products/delete' => ['controller' => 'ProductController', 'method' => 'delete', 'protected' => true],
    
    // Suppliers
    'suppliers' => ['controller' => 'SupplierController', 'method' => 'index', 'protected' => true],
    'suppliers/add' => ['controller' => 'SupplierController', 'method' => 'create', 'protected' => true],
    
    // Invoices
    'invoices' => ['controller' => 'InvoiceController', 'method' => 'index', 'protected' => true],
    'invoices/view' => ['controller' => 'InvoiceController', 'method' => 'view', 'protected' => true],
    
    // Deliveries
    'deliveries' => ['controller' => 'DeliveryController', 'method' => 'index', 'protected' => true],
    
    // Expenses
    'expenses' => ['controller' => 'ExpenseController', 'method' => 'index', 'protected' => true],
    'expenses/create' => ['controller' => 'ExpenseController', 'method' => 'create', 'protected' => true],
    'expenses/store' => ['controller' => 'ExpenseController', 'method' => 'store', 'protected' => true],
    'expenses/edit' => ['controller' => 'ExpenseController', 'method' => 'edit', 'protected' => true],
    'expenses/update' => ['controller' => 'ExpenseController', 'method' => 'update', 'protected' => true],
    'expenses/delete' => ['controller' => 'ExpenseController', 'method' => 'delete', 'protected' => true],
    'expenses/file' => ['controller' => 'ExpenseController', 'method' => 'getFile', 'protected' => true],
    
    // Sales
    'sell' => ['controller' => 'SalesController', 'method' => 'create', 'protected' => true],
    
    // Settings
    'settings' => ['controller' => 'SettingsController', 'method' => 'index', 'protected' => true],
];

return $routes;
?>
