<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">
                    <h4><?php echo t('edit_product', 'Edit Product'); ?></h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>

                    <form method="post" action="/furniture_erp/?route=products/update" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['id']); ?>">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="name"><?php echo t('name', 'Product Name'); ?> *</label>
                                <input type="text" id="name" name="name" class="form-control" required value="<?php echo htmlspecialchars($product['name']); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="sku"><?php echo t('sku', 'SKU'); ?> *</label>
                                <input type="text" id="sku" name="sku" class="form-control" required value="<?php echo htmlspecialchars($product['sku']); ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="category_id"><?php echo t('category', 'Category'); ?> *</label>
                                <select id="category_id" name="category_id" class="form-select" required onchange="updateSubcategories(this.value)">
                                    <option value=""><?php echo t('select_category', 'Select Category'); ?></option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?php echo $cat['id']; ?>" <?php echo ($product['category_id'] == $cat['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($cat['name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="subcategory_id"><?php echo t('subcategory', 'Subcategory'); ?></label>
                                <select id="subcategory_id" name="subcategory_id" class="form-select">
                                    <option value=""><?php echo t('select_subcategory', 'Select Subcategory'); ?></option>
                                    <?php foreach ($currentSubcategories as $sub): ?>
                                        <option value="<?php echo $sub['id']; ?>" <?php echo ($product['subcategory_id'] == $sub['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($sub['name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="size_id"><?php echo t('size', 'Size'); ?></label>
                                <select id="size_id" name="size_id" class="form-select">
                                    <option value=""><?php echo t('select_size', 'Select Size'); ?></option>
                                    <?php foreach ($sizes as $size): ?>
                                        <option value="<?php echo $size['id']; ?>" <?php echo ($product['size_id'] == $size['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($size['name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="condition_id"><?php echo t('condition', 'Condition'); ?></label>
                                <select id="condition_id" name="condition_id" class="form-select">
                                    <option value=""><?php echo t('select_condition', 'Select Condition'); ?></option>
                                    <?php foreach ($conditions as $cond): ?>
                                        <option value="<?php echo $cond['id']; ?>" <?php echo ($product['condition_id'] == $cond['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($cond['name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="material"><?php echo t('material', 'Material'); ?></label>
                                <input type="text" id="material" name="material" class="form-control" value="<?php echo htmlspecialchars($product['material']); ?>">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="color"><?php echo t('color', 'Color'); ?></label>
                                <input type="text" id="color" name="color" class="form-control" value="<?php echo htmlspecialchars($product['color']); ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="cost_price"><?php echo t('cost_price', 'Cost Price'); ?> (PLN)</label>
                                <input type="number" step="0.01" id="cost_price" name="cost_price" class="form-control" value="<?php echo htmlspecialchars($product['cost_price']); ?>">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="selling_price"><?php echo t('selling_price', 'Selling Price'); ?> (PLN)</label>
                                <input type="number" step="0.01" id="selling_price" name="selling_price" class="form-control" value="<?php echo htmlspecialchars($product['selling_price']); ?>">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="vat_percentage"><?php echo t('vat_percentage', 'VAT Rate'); ?></label>
                                <select id="vat_percentage" name="vat_percentage" class="form-select">
                                    <?php $vat = $product['vat_percentage'] ?? '23'; ?>
                                    <option value="23" <?php echo $vat == '23' ? 'selected' : ''; ?>>23%</option>
                                    <option value="19" <?php echo $vat == '19' ? 'selected' : ''; ?>>19%</option>
                                    <option value="8" <?php echo $vat == '8' ? 'selected' : ''; ?>>8%</option>
                                    <option value="5" <?php echo $vat == '5' ? 'selected' : ''; ?>>5%</option>
                                    <option value="0" <?php echo $vat == '0' ? 'selected' : ''; ?>>0%</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="stock_quantity"><?php echo t('stock_quantity', 'Stock Quantity'); ?></label>
                                <input type="number" id="stock_quantity" name="stock_quantity" class="form-control" value="<?php echo htmlspecialchars($product['stock_quantity'] ?? $product['quantity'] ?? 0); ?>">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="location"><?php echo t('location', 'Location'); ?></label>
                                <input type="text" id="location" name="location" class="form-control" value="<?php echo htmlspecialchars($product['location']); ?>">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="image_path"><?php echo t('image', 'Image'); ?></label>
                                <input type="file" id="image_path" name="image_path" class="form-control">
                            </div>
                        </div>

                        <?php if (!empty($product['image_path'])): ?>
                            <div class="mb-3">
                                <img src="<?php echo htmlspecialchars($product['image_path']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="max-height: 120px;">
                            </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <label class="form-label" for="description"><?php echo t('description', 'Description'); ?></label>
                            <textarea id="description" name="description" class="form-control" rows="4"><?php echo htmlspecialchars($product['description']); ?></textarea>
                        </div>

                        <button class="btn btn-primary" type="submit"><?php echo t('update_product', 'Update Product'); ?></button>
                        <a class="btn btn-secondary" href="/furniture_erp/?route=products"><?php echo t('cancel', 'Cancel'); ?></a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const allSubcategories = <?php echo json_encode($subcategories); ?>;

function updateSubcategories(categoryId) {
    const subcategorySelect = document.getElementById('subcategory_id');
    subcategorySelect.innerHTML = '<option value=""><?php echo t('select_subcategory', 'Select Subcategory'); ?></option>';

    allSubcategories
        .filter(sub => sub.category_id == categoryId)
        .forEach(sub => {
            const opt = document.createElement('option');
            opt.value = sub.id;
            opt.textContent = sub.name;
            subcategorySelect.appendChild(opt);
        });
}

window.addEventListener('DOMContentLoaded', () => {
    const cat = document.getElementById('category_id').value;
    if (cat) {
        updateSubcategories(cat);
        document.getElementById('subcategory_id').value = '<?php echo htmlspecialchars($product['subcategory_id'] ?? ''); ?>';
    }
});
</script>