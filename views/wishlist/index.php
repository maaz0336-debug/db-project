<?php
// views/wishlist/index.php
?>
<div class="mb-4">
    <h1 style="font-size: 28px; font-weight: 700;">My Wishlist</h1>
    <p class="text-muted">Saved items you want to buy later.</p>
</div>

<?php if (empty($wishlistItems)): ?>
    <div class="card" style="padding: 40px; text-align: center;">
        <div style="width: 80px; height: 80px; background-color: #f8f9fa; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 40px; height: 40px; color: var(--text-muted);"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
        </div>
        <h3 class="mb-2">Your wishlist is empty</h3>
        <p class="text-muted mb-4">Explore products and save them for later.</p>
        <a href="<?= BASE_URL ?>/products" class="btn btn-primary">Discover Products</a>
    </div>
<?php else: ?>
    <div class="product-grid">
        <?php foreach($wishlistItems as $product): ?>
            <div class="card product-card">
                <a href="<?= BASE_URL ?>/product/<?= $product['id'] ?>">
                    <div class="product-img-wrapper">
                        <img src="<?= getImageUrl($product['image'], 'https://via.placeholder.com/300x300.png?text=Product+Image') ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                    </div>
                </a>
                <div class="product-info">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 5px;">
                        <div style="font-size: 12px; color: var(--text-muted);"><?= htmlspecialchars($product['category_name']) ?></div>
                        <form action="<?= BASE_URL ?>/wishlist/toggle" method="POST">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <button type="submit" style="color: var(--danger-color);" title="Remove from wishlist">
                                <svg fill="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            </button>
                        </form>
                    </div>
                    <a href="<?= BASE_URL ?>/product/<?= $product['id'] ?>">
                        <h3 class="product-title"><?= htmlspecialchars($product['name']) ?></h3>
                    </a>
                    <div style="display: flex; align-items: baseline; gap: 10px; margin-top: auto;">
                        <span class="product-price"><?= formatPrice($product['price']) ?></span>
                        <?php if ($product['sale_price']): ?>
                            <span class="product-old-price"><?= formatPrice($product['sale_price']) ?></span>
                        <?php endif; ?>
                    </div>
                    <form action="<?= BASE_URL ?>/cart/add" method="POST">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="add-to-cart-btn">Move to Cart</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
