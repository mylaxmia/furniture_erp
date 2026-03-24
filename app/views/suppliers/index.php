<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><?php echo t('suppliers', 'Suppliers'); ?></h2>
                <a href="/furniture_erp/?route=suppliers/add" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i><?php echo t('add_supplier', 'Add Supplier'); ?>
                </a>
            </div>

            <?php if (empty($suppliers)): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i><?php echo t('no_suppliers', 'No suppliers found. Add your first supplier.'); ?>
                </div>
            <?php else: ?>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th><?php echo t('supplier_name', 'Supplier Name'); ?></th>
                                        <th><?php echo t('company_name', 'Company Name'); ?></th>
                                        <th><?php echo t('phone', 'Phone'); ?></th>
                                        <th><?php echo t('email', 'Email'); ?></th>
                                        <th><?php echo t('nip', 'NIP'); ?></th>
                                        <th><?php echo t('city', 'City'); ?></th>
                                        <th><?php echo t('actions', 'Actions'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($suppliers as $supplier): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($supplier['supplier_name']); ?></td>
                                            <td><?php echo htmlspecialchars($supplier['company_name']); ?></td>
                                            <td><?php echo htmlspecialchars($supplier['phone']); ?></td>
                                            <td>
                                                <?php if (!empty($supplier['email'])): ?>
                                                    <a href="mailto:<?php echo htmlspecialchars($supplier['email']); ?>">
                                                        <?php echo htmlspecialchars($supplier['email']); ?>
                                                    </a>
                                                <?php else: ?>
                                                    -
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($supplier['nip']); ?></td>
                                            <td><?php echo htmlspecialchars($supplier['city']); ?></td>
                                            <td>
                                                <a href="/furniture_erp/?route=suppliers/edit&id=<?php echo $supplier['id']; ?>" class="btn btn-sm btn-outline-primary me-1">
                                                    <i class="fas fa-edit"></i> <?php echo t('edit', 'Edit'); ?>
                                                </a>
                                                <a href="/furniture_erp/?route=suppliers/delete&id=<?php echo $supplier['id']; ?>" class="btn btn-sm btn-outline-danger"
                                                   onclick="return confirm('<?php echo t('confirm_delete', 'Are you sure?'); ?>')">
                                                    <i class="fas fa-trash"></i> <?php echo t('delete', 'Delete'); ?>
                                                </a>
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