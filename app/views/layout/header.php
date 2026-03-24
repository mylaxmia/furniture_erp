<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?> - ERP System</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }
        .main-container {
            display: flex;
            flex: 1;
        }
        .sidebar {
            width: 250px;
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
            padding: 20px 0;
            min-height: calc(100vh - 56px);
        }
        .nav-link {
            color: #333;
            padding: 10px 20px;
        }
        .nav-link:hover {
            background-color: #e9ecef;
            text-decoration: none;
        }
        .content {
            flex: 1;
            padding: 20px;
        }
    </style>
</head>
<body>
    <!-- Top Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="/furniture_erp/">
                <?php $companyLogo = get_setting('company_logo'); ?>
                <?php $companyName = get_setting('company_name', APP_NAME); ?>
                <?php if (!empty($companyLogo)): ?>
                    <img src="<?php echo htmlspecialchars($companyLogo); ?>" alt="Logo" style="height: 32px; margin-right: 8px; object-fit: contain;" />
                <?php else: ?>
                    <i class="fas fa-cubes me-2"></i>
                <?php endif; ?>
                <strong><?php echo htmlspecialchars($companyName); ?></strong>
            </a>
            <div class="ms-auto d-flex align-items-center gap-3">
                <!-- User Info (only if logged in) -->
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span class="text-muted">
                        <i class="fas fa-user me-1"></i>
                        <?php echo htmlspecialchars($_SESSION['username']); ?>
                    </span>
                <?php endif; ?>
                
                <!-- Language Switcher -->
                <?php $allowSwitch = get_setting('allow_switch', '1'); ?>
                <?php if ($allowSwitch === '1' || $allowSwitch === 1): ?>
                    <form method="post" style="display:inline;">
                        <select class="form-select form-select-sm d-inline-block w-auto" name="lang" onchange="this.form.submit();">
                            <option value="en" <?php echo ($_SESSION['lang'] ?? 'en') === 'en' ? 'selected' : ''; ?>>EN</option>
                            <option value="pl" <?php echo ($_SESSION['lang'] ?? 'en') === 'pl' ? 'selected' : ''; ?>>PL</option>
                        </select>
                        <input type="hidden" name="set_lang" value="1">
                    </form>
                <?php endif; ?>
                
                <!-- Logout (only if logged in) -->
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/furniture_erp/?route=logout" class="btn btn-outline-danger btn-sm">Logout</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <div class="main-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="px-3 mb-4">
                <h6 class="text-muted"><?php echo t('menu'); ?></h6>
            </div>
            <nav class="nav flex-column">
                <a class="nav-link" href="/furniture_erp/">
                    <i class="fas fa-home me-2"></i> <?php echo t('dashboard'); ?>
                </a>

                <!-- Products Menu -->
                <div class="nav-item">
                    <a class="nav-link" href="#productsSubmenu" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="productsSubmenu">
                        <i class="fas fa-box me-2"></i> <?php echo t('products'); ?> <i class="fas fa-chevron-down float-end"></i>
                    </a>
                    <div class="collapse" id="productsSubmenu">
                        <a class="nav-link ms-3" href="/furniture_erp/?route=products">
                            <i class="fas fa-list me-2"></i> <?php echo t('all_products'); ?>
                        </a>
                        <a class="nav-link ms-3" href="/furniture_erp/?route=products/create">
                            <i class="fas fa-plus me-2"></i> <?php echo t('add_product'); ?>
                        </a>
                    </div>
                </div>

                <a class="nav-link" href="/furniture_erp/?route=purchases">
                    <i class="fas fa-shopping-cart me-2"></i> <?php echo t('purchases'); ?>
                </a>
                <a class="nav-link" href="/furniture_erp/?route=suppliers">
                    <i class="fas fa-truck me-2"></i> <?php echo t('suppliers'); ?>
                </a>
                <a class="nav-link" href="/furniture_erp/?route=customers">
                    <i class="fas fa-users me-2"></i> <?php echo t('customers'); ?>
                </a>
                <a class="nav-link" href="/furniture_erp/?route=sales">
                    <i class="fas fa-cash-register me-2"></i> <?php echo t('sales'); ?>
                </a>
                <a class="nav-link" href="/furniture_erp/?route=invoices">
                    <i class="fas fa-file-invoice me-2"></i> <?php echo t('invoices'); ?>
                </a>
                <a class="nav-link" href="/furniture_erp/?route=deliveries">
                    <i class="fas fa-shipping-fast me-2"></i> <?php echo t('deliveries'); ?>
                </a>
                <a class="nav-link" href="/furniture_erp/?route=expenses">
                    <i class="fas fa-receipt me-2"></i> <?php echo t('expenses'); ?>
                </a>
                <a class="nav-link" href="/furniture_erp/?route=settings">
                    <i class="fas fa-cog me-2"></i> <?php echo t('settings'); ?>
                </a>
            <hr>
            <a class="nav-link text-danger" href="/furniture_erp/?route=logout">
                <i class="fas fa-sign-out-alt me-2"></i> <?php echo t('logout'); ?>
            </a>
        </div>

        <!-- Content -->
        <div class="content">
