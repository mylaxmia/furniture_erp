<div class="row mb-4">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center">
            <h2><?php echo t('expenses', 'Expenses'); ?></h2>
            <a href="/furniture_erp/?route=expenses/create" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i><?php echo t('add_expense', 'Add Expense'); ?>
            </a>
        </div>
    </div>
</div>

<!-- Summary Cards -->
<?php if ($totals): ?>
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title"><?php echo t('total_expenses', 'Total Expenses'); ?></h5>
                <h3><?php echo number_format($totals['total_amount'] ?? 0, 2, ',', ' '); ?> zł</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title"><?php echo t('total_vat', 'Total VAT'); ?></h5>
                <h3><?php echo number_format($totals['total_vat'] ?? 0, 2, ',', ' '); ?> zł</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title"><?php echo t('total_with_vat', 'Total with VAT'); ?></h5>
                <h3><?php echo number_format($totals['total_with_vat'] ?? 0, 2, ',', ' '); ?> zł</h3>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Expenses Table -->
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0"><?php echo t('expense_list', 'Expense List'); ?></h5>
            </div>
            <div class="card-body">
                <?php if (empty($expenses)): ?>
                    <p class="text-muted text-center py-4"><?php echo t('no_expenses', 'No expenses recorded'); ?></p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th><?php echo t('title', 'Title'); ?></th>
                                    <th><?php echo t('category', 'Category'); ?></th>
                                    <th><?php echo t('amount', 'Amount'); ?></th>
                                    <th><?php echo t('vat', 'VAT'); ?></th>
                                    <th><?php echo t('date', 'Date'); ?></th>
                                    <th><?php echo t('invoice', 'Invoice'); ?></th>
                                    <th><?php echo t('actions', 'Actions'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($expenses as $expense): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($expense['title']); ?></td>
                                    <td>
                                        <span class="badge bg-info">
                                            <?php echo t('category_' . $expense['category'], ucfirst($expense['category'])); ?>
                                        </span>
                                    </td>
                                    <td><?php echo number_format($expense['amount'], 2, ',', ' '); ?> zł</td>
                                    <td><?php echo number_format($expense['amount'] * $expense['vat_percentage'], 2, ',', ' '); ?> zł</td>
                                    <td><?php echo date('d.m.Y', strtotime($expense['expense_date'])); ?></td>
                                    <td>
                                        <?php if ($expense['invoice_path']): ?>
                                            <a href="/furniture_erp/?route=expenses/file&id=<?php echo $expense['id']; ?>" class="btn btn-sm btn-outline-primary" target="_blank">
                                                <i class="fas fa-file-pdf me-1"></i><?php echo t('download', 'Download'); ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted text-sm"><?php echo t('no_file', 'No file'); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="/furniture_erp/?route=expenses/edit&id=<?php echo $expense['id']; ?>" class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="/furniture_erp/?route=expenses/delete&id=<?php echo $expense['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('<?php echo t('confirm_delete', 'Are you sure?'); ?>');">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
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