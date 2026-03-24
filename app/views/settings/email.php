<?php
$settings = $settings ?? [];
$error = $error ?? '';
$success = $success ?? '';
require APP_PATH . '/views/settings/_nav.php';
?>
<div class="card">
    <div class="card-body">
        <h4><?php echo t('email_settings', 'Email'); ?></h4>

        <?php if ($error): ?><div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
        <?php if ($success): ?><div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div><?php endif; ?>

        <form method="post" action="/furniture_erp/?route=settings/email">
            <div class="mb-3">
                <label class="form-label" for="sender_name"><?php echo t('sender_name', 'Sender Name'); ?></label>
                <input type="text" id="sender_name" name="sender_name" class="form-control" required value="<?php echo htmlspecialchars($settings['sender_name'] ?? ''); ?>">
            </div>

            <div class="mb-3">
                <label class="form-label" for="sender_email"><?php echo t('sender_email', 'Sender Email'); ?></label>
                <input type="email" id="sender_email" name="sender_email" class="form-control" required value="<?php echo htmlspecialchars($settings['sender_email'] ?? ''); ?>">
            </div>

            <div class="mb-3">
                <label class="form-label" for="smtp_host"><?php echo t('smtp_host', 'SMTP Host'); ?></label>
                <input type="text" id="smtp_host" name="smtp_host" class="form-control" required value="<?php echo htmlspecialchars($settings['smtp_host'] ?? ''); ?>">
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="smtp_port"><?php echo t('smtp_port', 'SMTP Port'); ?></label>
                    <input type="text" id="smtp_port" name="smtp_port" class="form-control" value="<?php echo htmlspecialchars($settings['smtp_port'] ?? '587'); ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="smtp_username"><?php echo t('smtp_username', 'SMTP Username'); ?></label>
                    <input type="text" id="smtp_username" name="smtp_username" class="form-control" value="<?php echo htmlspecialchars($settings['smtp_username'] ?? ''); ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="smtp_password"><?php echo t('smtp_password', 'SMTP Password'); ?></label>
                    <input type="password" id="smtp_password" name="smtp_password" class="form-control" value="<?php echo htmlspecialchars($settings['smtp_password'] ?? ''); ?>">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label" for="smtp_encryption"><?php echo t('smtp_encryption', 'Encryption'); ?></label>
                <select id="smtp_encryption" name="smtp_encryption" class="form-select">
                    <option value="tls" <?php echo ($settings['smtp_encryption'] ?? '') === 'tls' ? 'selected' : ''; ?>>TLS</option>
                    <option value="ssl" <?php echo ($settings['smtp_encryption'] ?? '') === 'ssl' ? 'selected' : ''; ?>>SSL</option>
                    <option value="" <?php echo empty($settings['smtp_encryption']) ? 'selected' : ''; ?>>None</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary"><?php echo t('save_settings', 'Save Settings'); ?></button>
        </form>
    </div>
</div>
</div>
</div>
