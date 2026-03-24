<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4><?php echo t('edit_supplier', 'Edit Supplier'); ?></h4>
                </div>
                <div class="card-body">
                    <?php if (isset($error) && $error): ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i><?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="/furniture_erp/?route=suppliers/update">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($supplier['id']); ?>">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="supplier_name"><?php echo t('supplier_name', 'Supplier Name'); ?> *</label>
                                <input type="text" id="supplier_name" name="supplier_name" class="form-control" required value="<?php echo htmlspecialchars($supplier['supplier_name']); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="company_name"><?php echo t('company_name', 'Company Name'); ?> *</label>
                                <input type="text" id="company_name" name="company_name" class="form-control" required value="<?php echo htmlspecialchars($supplier['company_name']); ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="contact_person"><?php echo t('contact_person', 'Contact Person'); ?></label>
                                <input type="text" id="contact_person" name="contact_person" class="form-control" value="<?php echo htmlspecialchars($supplier['contact_person']); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="nip"><?php echo t('nip', 'NIP (VAT ID)'); ?> *</label>
                                <input type="text" id="nip" name="nip" class="form-control" required pattern="[0-9]{10}" maxlength="10" value="<?php echo htmlspecialchars($supplier['nip']); ?>" placeholder="1234567890">
                                <small class="form-text text-muted"><?php echo t('nip_help', '10-digit VAT identification number'); ?></small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="phone"><?php echo t('phone', 'Phone'); ?></label>
                                <input type="tel" id="phone" name="phone" class="form-control" value="<?php echo htmlspecialchars($supplier['phone']); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="email"><?php echo t('email', 'Email'); ?></label>
                                <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($supplier['email']); ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="address"><?php echo t('address', 'Address'); ?></label>
                            <input type="text" id="address" name="address" class="form-control" value="<?php echo htmlspecialchars($supplier['address']); ?>">
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="city"><?php echo t('city', 'City'); ?></label>
                                <input type="text" id="city" name="city" class="form-control" value="<?php echo htmlspecialchars($supplier['city']); ?>">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="postal_code"><?php echo t('postal_code', 'Postal Code'); ?></label>
                                <input type="text" id="postal_code" name="postal_code" class="form-control" value="<?php echo htmlspecialchars($supplier['postal_code']); ?>">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="country"><?php echo t('country', 'Country'); ?></label>
                                <input type="text" id="country" name="country" class="form-control" value="<?php echo htmlspecialchars($supplier['country']); ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="bank_name"><?php echo t('bank_name', 'Bank Name'); ?></label>
                                <input type="text" id="bank_name" name="bank_name" class="form-control" value="<?php echo htmlspecialchars($supplier['bank_name']); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="bank_account"><?php echo t('bank_account', 'Bank Account'); ?></label>
                                <input type="text" id="bank_account" name="bank_account" class="form-control" value="<?php echo htmlspecialchars($supplier['bank_account']); ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="notes"><?php echo t('notes', 'Notes'); ?></label>
                            <textarea id="notes" name="notes" class="form-control" rows="3"><?php echo htmlspecialchars($supplier['notes']); ?></textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i><?php echo t('update_supplier', 'Update Supplier'); ?>
                            </button>
                            <a href="/furniture_erp/?route=suppliers" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i><?php echo t('cancel', 'Cancel'); ?>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>