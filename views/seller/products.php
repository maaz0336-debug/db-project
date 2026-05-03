<?php
// views/seller/products.php
?>
<div class="mb-4" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 style="font-size: 28px; font-weight: 700;">My Products</h1>
        <p class="text-muted">Manage your product catalog.</p>
    </div>
    <a href="<?= BASE_URL ?>/seller/products/add" class="btn btn-primary">+ Add New Product</a>
</div>

<div class="card">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="border-bottom: 1px solid var(--border-color); background-color: #f8f9fa;">
                <th style="padding: 15px; text-align: left;">Product</th>
                <th style="padding: 15px; text-align: left;">Category</th>
                <th style="padding: 15px; text-align: left;">Price</th>
                <th style="padding: 15px; text-align: left;">Stock</th>
                <th style="padding: 15px; text-align: left;">Status</th>
                <th style="padding: 15px; text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($products as $product): ?>
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 15px;">
                        <div style="display: flex; gap: 15px; align-items: center;">
                            <img src="<?= getImageUrl($product['image'], 'https://via.placeholder.com/50') ?>" style="width: 50px; height: 50px; object-fit: contain;">
                            <div style="font-weight: 500;"><?= htmlspecialchars($product['name']) ?></div>
                        </div>
                    </td>
                    <td style="padding: 15px; color: var(--text-muted);"><?= htmlspecialchars($product['category_name']) ?></td>
                    <td style="padding: 15px; font-weight: 600;"><?= formatPrice($product['price']) ?></td>
                    <td style="padding: 15px;"><?= $product['stock'] ?></td>
                    <td style="padding: 15px;">
                        <span style="background-color: <?= $product['is_active'] ? '#2ecc71' : '#e74c3c' ?>; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold;">
                            <?= $product['is_active'] ? 'Active' : 'Inactive' ?>
                        </span>
                    </td>
                    <td style="padding: 15px; text-align: center;">
                        <!-- Edit link placeholder -->
                        <a href="#" class="btn btn-outline" style="padding: 4px 10px; font-size: 12px;">Edit</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if(empty($products)): ?>
                <tr>
                    <td colspan="6" style="padding: 30px; text-align: center; color: var(--text-muted);">No products found. Add your first product!</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
