<?php
// views/products/listing.php
?>
<div class="mb-4" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
    <div>
        <h1 style="font-size: 24px; font-weight: 700;"><?= htmlspecialchars($pageTitle) ?></h1>
        <p class="text-muted" style="font-size: 14px;">Showing <?= count($products) ?> products</p>
    </div>
    
    <!-- Category Chips (Horizontal, like Daraz) -->
    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
        <a href="<?= BASE_URL ?>/products" class="category-chip <?= $pageTitle === 'All Products' ? 'active' : '' ?>">All</a>
        <?php foreach($categories as $category): ?>
            <a href="<?= BASE_URL ?>/category/<?= $category['slug'] ?>" class="category-chip <?= $pageTitle === $category['name'] ? 'active' : '' ?>">
                <?= htmlspecialchars($category['name']) ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<?php if (empty($products)): ?>
    <div class="card" style="padding: 60px; text-align: center;">
        <h3 class="mb-2">No products found</h3>
        <p class="text-muted">Try adjusting your filters or search query.</p>
    </div>
<?php else: ?>
    <div class="product-grid">
        <?php foreach($products as $product): ?>
            <div class="card product-card">
                <a href="<?= BASE_URL ?>/product/<?= $product['id'] ?>">
                    <div class="product-img-wrapper">
                        <img src="<?= getImageUrl($product['image'], 'https://via.placeholder.com/300x300.png?text=Product+Image') ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                        <?php if ($product['sale_price']): ?>
                            <?php $discount = round((($product['price'] - $product['sale_price']) / $product['price']) * 100); ?>
                            <span class="discount-badge">-<?= $discount ?>%</span>
                        <?php endif; ?>
                    </div>
                </a>
                <div class="product-info">
                    <a href="<?= BASE_URL ?>/product/<?= $product['id'] ?>">
                        <h3 class="product-title"><?= htmlspecialchars($product['name']) ?></h3>
                    </a>
                    <div style="display: flex; align-items: center; gap: 5px; margin-bottom: 8px; font-size: 11px;">
                        <div style="color: #F1C40F;">
                            <?= str_repeat('★', round($product['avg_rating'] ?? 0)) ?><?= str_repeat('☆', 5 - round($product['avg_rating'] ?? 0)) ?>
                        </div>
                        <span class="text-muted">(<?= $product['review_count'] ?? 0 ?>)</span>
                    </div>
                    <div style="display: flex; align-items: baseline; gap: 8px; margin-top: auto;">
                        <span class="product-price"><?= formatPrice($product['sale_price'] ? $product['sale_price'] : $product['price']) ?></span>
                        <?php if ($product['sale_price']): ?>
                            <span class="product-old-price"><?= formatPrice($product['price']) ?></span>
                        <?php endif; ?>
                    </div>
                    <form action="<?= BASE_URL ?>/cart/add" method="POST">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="add-to-cart-btn">Add to Cart</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
