<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">
                    <h4>Add Product</h4>
                </div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">
                        <!-- Basic Info Section -->
                        <div class="mb-4">
                            <h5 class="mb-3">Basic Info</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="name">Product Name *</label>
                                    <input type="text" id="name" name="name" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="sku">SKU *</label>
                                    <input type="text" id="sku" name="sku" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <!-- Classification Section -->
                        <div class="mb-4">
                            <h5 class="mb-3">Classification</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="category">Category *</label>
                                    <select id="category" name="category" class="form-select" required>
                                        <option value="">Select Category</option>
                                        <option value="1">Living Room</option>
                                        <option value="2">Bedroom</option>
                                        <option value="3">Dining Room</option>
                                        <option value="4">Office</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="subcategory">Subcategory</label>
                                    <select id="subcategory" name="subcategory" class="form-select">
                                        <option value="">Select Subcategory</option>
                                        <option value="1">Sofas</option>
                                        <option value="2">Chairs</option>
                                        <option value="3">Tables</option>
                                        <option value="4">Cabinets</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Attributes Section -->
                        <div class="mb-4">
                            <h5 class="mb-3">Attributes</h5>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="size">Size</label>
                                    <select id="size" name="size" class="form-select">
                                        <option value="">Select Size</option>
                                        <option value="1">Small</option>
                                        <option value="2">Medium</option>
                                        <option value="3">Large</option>
                                        <option value="4">Extra Large</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="condition">Condition</label>
                                    <select id="condition" name="condition" class="form-select">
                                        <option value="">Select Condition</option>
                                        <option value="new">New</option>
                                        <option value="refurbished">Refurbished</option>
                                        <option value="used">Used</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="material">Material</label>
                                    <input type="text" id="material" name="material" class="form-control">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="color">Color</label>
                                    <input type="text" id="color" name="color" class="form-control">
                                </div>
                            </div>
                        </div>

                        <!-- Pricing Section -->
                        <div class="mb-4">
                            <h5 class="mb-3">Pricing</h5>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="purchase_price">Purchase Price</label>
                                    <input type="number" step="0.01" id="purchase_price" name="purchase_price" class="form-control">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="selling_price">Selling Price</label>
                                    <input type="number" step="0.01" id="selling_price" name="selling_price" class="form-control">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="vat">VAT %</label>
                                    <input type="number" step="0.01" id="vat" name="vat" class="form-control">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="discount">Discount %</label>
                                    <input type="number" step="0.01" id="discount" name="discount" class="form-control">
                                </div>
                            </div>
                        </div>

                        <!-- Inventory Section -->
                        <div class="mb-4">
                            <h5 class="mb-3">Inventory</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="stock_quantity">Stock Quantity</label>
                                    <input type="number" id="stock_quantity" name="stock_quantity" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="location">Location</label>
                                    <input type="text" id="location" name="location" class="form-control">
                                </div>
                            </div>
                        </div>

                        <!-- Media Section -->
                        <div class="mb-4">
                            <h5 class="mb-3">Media</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Upload Images (max 5)</label>
                                    <input type="file" name="images[]" class="form-control mb-2" accept="image/*">
                                    <input type="file" name="images[]" class="form-control mb-2" accept="image/*">
                                    <input type="file" name="images[]" class="form-control mb-2" accept="image/*">
                                    <input type="file" name="images[]" class="form-control mb-2" accept="image/*">
                                    <input type="file" name="images[]" class="form-control mb-2" accept="image/*">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Upload Videos (max 2)</label>
                                    <input type="file" name="videos[]" class="form-control mb-2" accept="video/*">
                                    <input type="file" name="videos[]" class="form-control mb-2" accept="video/*">
                                </div>
                            </div>
                        </div>

                        <!-- Description Section -->
                        <div class="mb-4">
                            <h5 class="mb-3">Description</h5>
                            <div class="mb-3">
                                <label class="form-label" for="description">Description</label>
                                <textarea id="description" name="description" class="form-control" rows="4"></textarea>
                            </div>
                        </div>

                        <button class="btn btn-primary" type="submit">Save Product</button>
                        <a class="btn btn-secondary" href="#">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>