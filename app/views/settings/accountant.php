<?php
$settings = $settings ?? [];
$error = $error ?? '';
$success = $success ?? '';
require APP_PATH . '/views/settings/_nav.php';
?>
<div class="card">
    <div class="card-body">
        <h4><?php echo t('accountant_settings', 'Accountant'); ?></h4>

        <?php if ($error): ?><div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
        <?php if ($success): ?><div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div><?php endif; ?>

        <form method="post" action="/furniture_erp/?route=settings/accountant">
            <div class="mb-3">
                <label class="form-label" for="accountant_name"><?php echo t('accountant_name', 'Accountant Name'); ?></label>
                <input type="text" id="accountant_name" name="accountant_name" class="form-control" required value="<?php echo htmlspecialchars($settings['accountant_name'] ?? ''); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label" for="accountant_email"><?php echo t('accountant_email', 'Accountant Email'); ?></label>
                <input type="email" id="accountant_email" name="accountant_email" class="form-control" required value="<?php echo htmlspecialchars($settings['accountant_email'] ?? ''); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label" for="accountant_phone"><?php echo t('accountant_phone', 'Accountant Phone'); ?></label>
                <input type="text" id="accountant_phone" name="accountant_phone" class="form-control" value="<?php echo htmlspecialchars($settings['accountant_phone'] ?? ''); ?>">
            </div>
            <button type="submit" class="btn btn-primary"><?php echo t('save_settings', 'Save Settings'); ?></button>
        </form>
    </div>
</div>
</div>
</div>
