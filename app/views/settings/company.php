<?php
$settings = $settings ?? [];
$error = $error ?? '';
$success = $success ?? '';
require APP_PATH . '/views/settings/_nav.php';
?>
<div class="card">
    <div class="card-body">
        <h4><?php echo t('company_settings', 'Company'); ?></h4>

        <?php if ($error): ?><div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
        <?php if ($success): ?><div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div><?php endif; ?>

        <form method="post" action="/furniture_erp/?route=settings/company" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label" for="company_name"><?php echo t('company_name', 'Company Name'); ?></label>
                <input type="text" id="company_name" name="company_name" class="form-control" required value="<?php echo htmlspecialchars($settings['company_name'] ?? ''); ?>">
            </div>

            <div class="mb-3">
                <label class="form-label" for="company_logo"><?php echo t('company_logo', 'Company Logo'); ?></label>
                <input type="file" id="company_logo" name="company_logo" class="form-control">
                <small class="form-text text-muted"><?php echo t('logo_upload_help', 'Upload an image file (jpg, png, gif, svg)'); ?></small>
            </div>

            <?php if (!empty($settings['company_logo'])): ?>
                <div class="mb-3">
                    <label class="form-label"><?php echo t('current_logo', 'Current Logo'); ?></label>
                    <div><img src="<?php echo htmlspecialchars($settings['company_logo']); ?>" alt="Logo" style="max-height:80px; display:block; margin-bottom:8px;"></div>
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <label class="form-label" for="address"><?php echo t('address', 'Address'); ?></label>
                <input type="text" id="address" name="address" class="form-control" required value="<?php echo htmlspecialchars($settings['address'] ?? ''); ?>">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="city"><?php echo t('city', 'City'); ?></label>
                    <input type="text" id="city" name="city" class="form-control" required value="<?php echo htmlspecialchars($settings['city'] ?? ''); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="postal_code"><?php echo t('postal_code', 'Postal Code'); ?></label>
                    <input type="text" id="postal_code" name="postal_code" class="form-control" required value="<?php echo htmlspecialchars($settings['postal_code'] ?? ''); ?>">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label" for="country"><?php echo t('country', 'Country'); ?></label>
                <input type="text" id="country" name="country" class="form-control" value="<?php echo htmlspecialchars($settings['country'] ?? 'Poland'); ?>">
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="nip"><?php echo t('nip', 'NIP'); ?></label>
                    <input type="text" id="nip" name="nip" class="form-control" value="<?php echo htmlspecialchars($settings['nip'] ?? ''); ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="regon"><?php echo t('regon', 'REGON'); ?></label>
                    <input type="text" id="regon" name="regon" class="form-control" value="<?php echo htmlspecialchars($settings['regon'] ?? ''); ?>">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label" for="bank_account"><?php echo t('bank_account', 'Bank Account'); ?></label>
                <input type="text" id="bank_account" name="bank_account" class="form-control" value="<?php echo htmlspecialchars($settings['bank_account'] ?? ''); ?>">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="iban"><?php echo t('iban', 'IBAN'); ?></label>
                    <input type="text" id="iban" name="iban" class="form-control" value="<?php echo htmlspecialchars($settings['iban'] ?? ''); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="swift_bic"><?php echo t('swift_bic', 'SWIFT/BIC'); ?></label>
                    <input type="text" id="swift_bic" name="swift_bic" class="form-control" value="<?php echo htmlspecialchars($settings['swift_bic'] ?? ''); ?>">
                </div>
            </div>

            <button type="submit" class="btn btn-primary"><?php echo t('save_settings', 'Save Settings'); ?></button>
        </form>
    </div>
</div>
</div>
</div>
