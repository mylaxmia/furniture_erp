<div class="row">
    <div class="col-md-12">
        <h1><?php echo t('welcome_user'); ?>, <?php echo htmlspecialchars($user['username']); ?>! 👋</h1>
        <p class="text-muted"><?php echo t('overview'); ?></p>
    </div>
</div>

<!-- Top Stats -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title"><?php echo t('total_products'); ?></h5>
                <h3><?php echo number_format($stats['total_products']); ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title"><?php echo t('total_suppliers'); ?></h5>
                <h3><?php echo number_format($stats['total_suppliers']); ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title"><?php echo t('total_sales_amount'); ?></h5>
                <h3><?php echo number_format($stats['total_sales_amount'], 2, ',', ' '); ?> zł</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title"><?php echo t('total_orders'); ?></h5>
                <h3><?php echo number_format($stats['total_orders']); ?></h3>
            </div>
        </div>
    </div>
</div>

<!-- Low Stock Alert -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0"><?php echo t('low_stock_alert'); ?></h5>
            </div>
            <div class="card-body">
                <?php if (empty($data['low_stock'])): ?>
                    <p class="text-success">All products are well stocked!</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th><?php echo t('product'); ?></th>
                                    <th><?php echo t('stock'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['low_stock'] as $product): ?>
                                    <tr class="table-warning">
                                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                                        <td><span class="badge bg-danger"><?php echo $product['quantity']; ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Delivery Status -->
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0"><?php echo t('delivery_status'); ?></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="text-center">
                            <h4 class="text-warning"><?php echo $data['delivery_status']['pending']; ?></h4>
                            <small class="text-muted"><?php echo t('pending'); ?></small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center">
                            <h4 class="text-primary"><?php echo $data['delivery_status']['shipped']; ?></h4>
                            <small class="text-muted"><?php echo t('shipped'); ?></small>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-6">
                        <div class="text-center">
                            <h4 class="text-info"><?php echo $data['delivery_status']['in_transit']; ?></h4>
                            <small class="text-muted"><?php echo t('in_transit'); ?></small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center">
                            <h4 class="text-success"><?php echo $data['delivery_status']['delivered']; ?></h4>
                            <small class="text-muted"><?php echo t('delivered'); ?></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Best Sellers -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0"><?php echo t('best_sellers'); ?></h5>
            </div>
            <div class="card-body">
                <?php if (empty($data['best_sellers'])): ?>
                    <p class="text-muted">No sales data available for this month.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th><?php echo t('product'); ?></th>
                                    <th><?php echo t('qty_sold'); ?></th>
                                    <th><?php echo t('revenue'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['best_sellers'] as $product): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                                        <td><?php echo number_format($product['total_quantity']); ?></td>
                                        <td><?php echo number_format($product['total_revenue'], 2, ',', ' '); ?> zł</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Recent Sales -->
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0"><?php echo t('recent_sales'); ?></h5>
            </div>
            <div class="card-body">
                <?php if (empty($data['recent_sales'])): ?>
                    <p class="text-muted">No recent sales.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th><?php echo t('id'); ?></th>
                                    <th><?php echo t('date'); ?></th>
                                    <th><?php echo t('amount'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['recent_sales'] as $sale): ?>
                                    <tr>
                                        <td><?php echo $sale['id']; ?></td>
                                        <td><?php echo date('M d, Y', strtotime($sale['sale_date'])); ?></td>
                                        <td><?php echo number_format($sale['total_amount'], 2, ',', ' '); ?> zł</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
