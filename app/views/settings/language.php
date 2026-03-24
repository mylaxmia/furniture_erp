<?php
$settings = $settings ?? [];
$error = $error ?? '';
$success = $success ?? '';
require APP_PATH . '/views/settings/_nav.php';
?>
<div class="card">
    <div class="card-body">
        <h4><?php echo t('language_settings', 'Language'); ?></h4>

        <?php if ($error): ?><div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
        <?php if ($success): ?><div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div><?php endif; ?>

        <form method="post" action="/furniture_erp/?route=settings/language">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="default_language"><?php echo t('default_language_option', 'Default Language'); ?></label>
                    <select id="default_language" name="default_language" class="form-select">
                        <?php $langVal = $settings['default_language'] ?? 'en'; ?>
                        <option value="en" <?php echo $langVal === 'en' ? 'selected' : ''; ?>>English</option>
                        <option value="pl" <?php echo $langVal === 'pl' ? 'selected' : ''; ?>>Polski</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="allow_switch"><?php echo t('allow_switch_option', 'Allow switch between languages'); ?></label>
                    <select id="allow_switch" name="allow_switch" class="form-select">
                        <?php $allow = $settings['allow_switch'] ?? '1'; ?>
                        <option value="1" <?php echo $allow === '1' ? 'selected' : ''; ?>><?php echo t('yes', 'Yes'); ?></option>
                        <option value="0" <?php echo $allow === '0' ? 'selected' : ''; ?>><?php echo t('no', 'No'); ?></option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary"><?php echo t('save_settings', 'Save Settings'); ?></button>
        </form>
    </div>
</div>
</div>
</div>
