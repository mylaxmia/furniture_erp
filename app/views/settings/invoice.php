<?php
$settings = $settings ?? [];
$error = $error ?? '';
$success = $success ?? '';
require APP_PATH . '/views/settings/_nav.php';
?>
<div class="card">
    <div class="card-body">
        <h4><?php echo t('invoice_settings', 'Invoice'); ?></h4>

        <?php if ($error): ?><div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
        <?php if ($success): ?><div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div><?php endif; ?>

        <form method="post" action="/furniture_erp/?route=settings/invoice">
            <div class="mb-3">
                <label class="form-label" for="invoice_prefix"><?php echo t('invoice_prefix', 'Invoice Prefix'); ?></label>
                <input type="text" id="invoice_prefix" name="invoice_prefix" class="form-control" required value="<?php echo htmlspecialchars($settings['invoice_prefix'] ?? 'FV/2026/'); ?>">
            </div>

            <div class="mb-3">
                <label class="form-label" for="next_invoice_number"><?php echo t('next_invoice_number', 'Next Invoice Number'); ?></label>
                <input type="number" id="next_invoice_number" name="next_invoice_number" class="form-control" required value="<?php echo htmlspecialchars($settings['next_invoice_number'] ?? '1'); ?>">
                <small class="form-text text-muted"><?php echo t('next_invoice_help', 'Enter the starting invoice number for next invoice issuance.'); ?></small>
            </div>

            <div class="mb-3">
                <label class="form-label" for="invoice_footer_note"><?php echo t('invoice_footer_note', 'Invoice Footer Note'); ?></label>
                <textarea id="invoice_footer_note" name="invoice_footer_note" class="form-control" rows="4"><?php echo htmlspecialchars($settings['invoice_footer_note'] ?? ''); ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary"><?php echo t('save_settings', 'Save Settings'); ?></button>
        </form>
    </div>
</div>
</div>
</div>
