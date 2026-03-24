<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0"><?php echo t('edit_expense', 'Edit Expense'); ?></h5>
            </div>
            <div class="card-body">
                <?php if (isset($error) && !empty($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($error); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form method="POST" action="/furniture_erp/?route=expenses/update" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $expense['id']; ?>">

                    <div class="mb-3">
                        <label for="title" class="form-label"><?php echo t('title', 'Title'); ?> *</label>
                        <input type="text" class="form-control" id="title" name="title" required value="<?php echo htmlspecialchars($expense['title']); ?>">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="amount" class="form-label"><?php echo t('amount', 'Amount (PLN)'); ?> *</label>
                                <input type="number" class="form-control" id="amount" name="amount" step="0.01" required value="<?php echo $expense['amount']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="vat_percentage" class="form-label"><?php echo t('vat_percentage', 'VAT %'); ?> *</label>
                                <select class="form-select" id="vat_percentage" name="vat_percentage">
                                    <option value="0.23" <?php echo ($expense['vat_percentage'] == 0.23) ? 'selected' : ''; ?>>23% (<?php echo t('standard', 'Standard'); ?>)</option>
                                    <option value="0.08" <?php echo ($expense['vat_percentage'] == 0.08) ? 'selected' : ''; ?>>8% (<?php echo t('reduced', 'Reduced'); ?>)</option>
                                    <option value="0.05" <?php echo ($expense['vat_percentage'] == 0.05) ? 'selected' : ''; ?>>5% (<?php echo t('reduced', 'Reduced'); ?>)</option>
                                    <option value="0.00" <?php echo ($expense['vat_percentage'] == 0.00) ? 'selected' : ''; ?>>0% (<?php echo t('exempt', 'Exempt'); ?>)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category" class="form-label"><?php echo t('category', 'Category'); ?> *</label>
                                <select class="form-select" id="category" name="category" required>
                                    <option value="">-- Select Category --</option>
                                    <?php foreach ($categories as $key => $name): ?>
                                        <option value="<?php echo $key; ?>" <?php echo ($expense['category'] === $key) ? 'selected' : ''; ?>><?php echo htmlspecialchars($name); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="expense_date" class="form-label"><?php echo t('date', 'Expense Date'); ?> *</label>
                                <input type="date" class="form-control" id="expense_date" name="expense_date" value="<?php echo $expense['expense_date']; ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label"><?php echo t('notes', 'Notes'); ?></label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"><?php echo htmlspecialchars($expense['notes'] ?? ''); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="invoice_file" class="form-label"><?php echo t('invoice_file', 'Invoice File'); ?> (PDF, JPG, PNG - Max 5 MB)</label>
                        <?php if ($expense['invoice_path']): ?>
                            <div class="alert alert-info mb-3">
                                <strong><?php echo t('current_file', 'Current File'); ?>:</strong>
                                <a href="/furniture_erp/?route=expenses/file&id=<?php echo $expense['id']; ?>" target="_blank">
                                    <i class="fas fa-file-pdf me-1"></i><?php echo basename($expense['invoice_path']); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        <input type="file" class="form-control" id="invoice_file" name="invoice_file" accept=".pdf,.jpg,.jpeg,.png">
                        <small class="text-muted"><?php echo t('leave_empty', 'Leave empty to keep current file'); ?></small>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i><?php echo t('update_expense', 'Update Expense'); ?>
                        </button>
                        <a href="/furniture_erp/?route=expenses" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i><?php echo t('cancel', 'Cancel'); ?>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>