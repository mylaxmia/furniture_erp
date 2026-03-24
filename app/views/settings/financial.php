<?php
$settings = $settings ?? [];
$error = $error ?? '';
$success = $success ?? '';
require APP_PATH . '/views/settings/_nav.php';
?>
<div class="card">
    <div class="card-body">
        <h4><?php echo t('financial_settings', 'Financial'); ?></h4>

        <?php if ($error): ?><div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
        <?php if ($success): ?><div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div><?php endif; ?>

        <form method="post" action="/furniture_erp/?route=settings/financial">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="default_currency"><?php echo t('default_currency', 'Default Currency'); ?></label>
                    <input type="text" id="default_currency" name="default_currency" class="form-control" required value="<?php echo htmlspecialchars($settings['default_currency'] ?? 'PLN'); ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="currency_symbol"><?php echo t('currency_symbol', 'Currency Symbol'); ?></label>
                    <input type="text" id="currency_symbol" name="currency_symbol" class="form-control" required value="<?php echo htmlspecialchars($settings['currency_symbol'] ?? 'zł'); ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="default_vat"><?php echo t('default_vat', 'Default VAT'); ?></label>
                    <select id="default_vat" name="default_vat" class="form-select" required>
                        <?php $vatSelected = $settings['default_vat'] ?? '23'; ?>
                        <option value="23" <?php echo $vatSelected === '23' ? 'selected' : ''; ?>>23%</option>
                        <option value="19" <?php echo $vatSelected === '19' ? 'selected' : ''; ?>>19% (refurbished)</option>
                        <option value="8" <?php echo $vatSelected === '8' ? 'selected' : ''; ?>>8%</option>
                        <option value="5" <?php echo $vatSelected === '5' ? 'selected' : ''; ?>>5%</option>
                        <option value="0" <?php echo $vatSelected === '0' ? 'selected' : ''; ?>>0%</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary"><?php echo t('save_settings', 'Save Settings'); ?></button>
        </form>
    </div>
</div>
</div>
</div>
