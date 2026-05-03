<?php
// views/seller/dashboard.php
?>
<div class="mb-4">
    <h1 style="font-size: 28px; font-weight: 700;">Seller Dashboard</h1>
    <p class="text-muted">Manage your store, products, and orders.</p>
</div>

<div style="display: flex; gap: 20px; margin-bottom: 30px;">
    <div class="card" style="flex: 1; padding: 25px; border-left: 4px solid var(--primary-color);">
        <h3 class="text-muted" style="font-size: 14px; text-transform: uppercase;">Total Products</h3>
        <div style="font-size: 32px; font-weight: 700; margin-top: 10px;"><?= $totalProducts ?></div>
    </div>
    
    <div class="card" style="flex: 1; padding: 25px; border-left: 4px solid #3498db;">
        <h3 class="text-muted" style="font-size: 14px; text-transform: uppercase;">Total Orders</h3>
        <div style="font-size: 32px; font-weight: 700; margin-top: 10px;"><?= $totalOrders ?></div>
    </div>
</div>

<div style="display: flex; gap: 20px;">
    <a href="<?= BASE_URL ?>/seller/products" class="btn btn-outline" style="flex: 1; padding: 20px;">Manage Products</a>
    <a href="<?= BASE_URL ?>/seller/products/add" class="btn btn-primary" style="flex: 1; padding: 20px;">Add New Product</a>
    <a href="<?= BASE_URL ?>/seller/orders" class="btn btn-outline" style="flex: 1; padding: 20px;">View Orders</a>
</div>
