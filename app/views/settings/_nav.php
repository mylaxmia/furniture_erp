<?php
$activeTab = $activeTab ?? 'profile';
$tabs = [
    'profile' => t('profile_settings', 'Profile'),
    'company' => t('company_settings', 'Company'),
    'email' => t('email_settings', 'Email'),
    'accountant' => t('accountant_settings', 'Accountant'),
    'financial' => t('financial_settings', 'Financial'),
    'language' => t('language_settings', 'Language'),
    'invoice' => t('invoice_settings', 'Invoice')
];
?>
<div class="row">
    <div class="col-md-3 mb-3">
        <div class="list-group">
            <?php foreach ($tabs as $key => $label): ?>
                <a href="/furniture_erp/?route=settings/<?= $key ?>" class="list-group-item list-group-item-action <?= $activeTab === $key ? 'active' : '' ?>">
                    <?= htmlspecialchars($label) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="col-md-9">
