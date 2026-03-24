<div class="row">
    <div class="col-md-12">
        <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?>! 👋</h1>
        <p class="text-muted">Dashboard will be fully implemented in the next phase.</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Total Products</h5>
                <h3><?php echo number_format($stats['total_products']); ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Total Suppliers</h5>
                <h3><?php echo number_format($stats['total_suppliers']); ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Total Sales</h5>
                <h3><?php echo number_format($stats['total_sales']); ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="alert alert-info mt-4">
    <strong>✅ Authentication System Ready!</strong><br>
    You are successfully logged in. The dashboard and other modules will be added in the next phase.
</div>
