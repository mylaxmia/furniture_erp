<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><?php echo t('all_products', 'All Products'); ?></h2>
                <a href="/furniture_erp/?route=products/create" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i><?php echo t('add_product', 'Add Product'); ?>
                </a>
            </div>

            <?php if (empty($products)): ?>
                <div class="alert alert-info"><?php echo t('no_products_found', 'No products found. Add products to start.'); ?></div>
            <?php else: ?>
                <div class="card shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th><?php echo t('product', 'Product'); ?></th>
                                        <th><?php echo t('sku', 'SKU'); ?></th>
                                        <th><?php echo t('category', 'Category'); ?></th>
                                        <th><?php echo t('price', 'Price (PLN)'); ?></th>
                                        <th><?php echo t('stock', 'Stock'); ?></th>
                                        <th><?php echo t('condition', 'Condition'); ?></th>
                                        <th><?php echo t('actions', 'Actions'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                                        <td><?php echo htmlspecialchars($product['sku']); ?></td>
                                        <td><?php echo htmlspecialchars($product['category_name'] ?? '-'); ?></td>
                                        <td><?php echo number_format($product['selling_price'] ?: 0, 2, ',', ' ') . ' ' . get_setting('currency_symbol', 'zł'); ?></td>
                                        <td><?php echo htmlspecialchars($product['stock_quantity'] ?? $product['quantity'] ?? 0); ?></td>
                                        <td><?php echo htmlspecialchars($product['condition_name'] ?? $product['condition'] ?? '-'); ?></td>
                                        <td>
                                            <a href="/furniture_erp/?route=products/edit&id=<?php echo $product['id']; ?>" class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-edit"></i> <?php echo t('edit', 'Edit'); ?></a>
                                            <a href="/furniture_erp/?route=products/delete&id=<?php echo $product['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('<?php echo t('confirm_delete', 'Are you sure?'); ?>');"><i class="fas fa-trash"></i> <?php echo t('delete', 'Delete'); ?></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>