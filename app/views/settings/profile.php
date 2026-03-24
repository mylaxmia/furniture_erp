<?php
$settings = $settings ?? [];
$userData = $userData ?? [];
$error = $error ?? '';
$success = $success ?? '';
require APP_PATH . '/views/settings/_nav.php';
?>
<div class="card">
    <div class="card-body">
        <h4><?php echo t('profile_settings', 'Profile'); ?></h4>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <form method="post" action="/furniture_erp/?route=settings/profile">
            <div class="mb-3">
                <label class="form-label" for="username"><?php echo t('username', 'Username'); ?></label>
                <input type="text" id="username" name="username" class="form-control" required value="<?php echo htmlspecialchars($userData['username'] ?? ''); ?>">
            </div>

            <div class="mb-3">
                <label class="form-label" for="email"><?php echo t('sender_email', 'Email'); ?></label>
                <input type="email" id="email" name="email" class="form-control" required value="<?php echo htmlspecialchars($userData['email'] ?? ''); ?>">
            </div>

            <div class="mb-3">
                <label class="form-label" for="password"><?php echo t('password', 'Password'); ?> (<?php echo t('leave_empty', 'Leave empty to keep current'); ?>)</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="<?php echo t('leave_empty', 'Leave empty to keep current'); ?>">
            </div>

            <button type="submit" class="btn btn-primary"><?php echo t('save_settings', 'Save Settings'); ?></button>
        </form>
    </div>
</div>
</div>
</div>
