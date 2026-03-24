<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0"><?php echo t('add_expense', 'Add New Expense'); ?></h5>
            </div>
            <div class="card-body">
                <?php if (isset($error) && !empty($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($error); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form method="POST" action="/furniture_erp/?route=expenses/store" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title" class="form-label"><?php echo t('title', 'Title'); ?> *</label>
                        <input type="text" class="form-control" id="title" name="title" required placeholder="e.g. ChatGPT subscription">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="amount" class="form-label"><?php echo t('amount', 'Amount (PLN)'); ?> *</label>
                                <input type="number" class="form-control" id="amount" name="amount" step="0.01" required placeholder="1250.50">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="vat_percentage" class="form-label"><?php echo t('vat_percentage', 'VAT %'); ?> *</label>
                                <select class="form-select" id="vat_percentage" name="vat_percentage">
                                    <option value="0.23">23% (<?php echo t('standard', 'Standard'); ?>)</option>
                                    <option value="0.08">8% (<?php echo t('reduced', 'Reduced'); ?>)</option>
                                    <option value="0.05">5% (<?php echo t('reduced', 'Reduced'); ?>)</option>
                                    <option value="0.00">0% (<?php echo t('exempt', 'Exempt'); ?>)</option>
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
                                        <option value="<?php echo $key; ?>"><?php echo htmlspecialchars($name); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="expense_date" class="form-label"><?php echo t('date', 'Expense Date'); ?> *</label>
                                <input type="date" class="form-control" id="expense_date" name="expense_date" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label"><?php echo t('notes', 'Notes'); ?></label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Optional notes..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="invoice_file" class="form-label"><?php echo t('invoice_file', 'Invoice File'); ?> (PDF, JPG, PNG - Max 5 MB)</label>
                        <input type="file" class="form-control" id="invoice_file" name="invoice_file" accept=".pdf,.jpg,.jpeg,.png">
                        <small class="text-muted"><?php echo t('invoice_help', 'Upload invoice or receipt for accountant records'); ?></small>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i><?php echo t('save_expense', 'Save Expense'); ?>
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