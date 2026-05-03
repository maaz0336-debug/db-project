<?php
// views/home/index.php
?>
<section class="hero">
    <div class="hero-content">
        <h1>Discover the Best Products at <span><?= APP_NAME ?></span></h1>
        <p>Shop from thousands of premium items with fast delivery and great prices.</p>
        <div>
            <a href="<?= BASE_URL ?>/products" class="btn btn-primary" style="padding: 14px 30px; font-size: 15px;">Shop Now</a>
        </div>
    </div>
    <div class="hero-image"></div>
</section>

<!-- Categories Row -->
<section style="margin: 20px 0;">
    <div class="section-header">
        <h2>Categories</h2>
        <a href="<?= BASE_URL ?>/products">View All &raquo;</a>
    </div>
    <?php
    // Mapping of category slugs to high-quality Unsplash images
    $categoryImages = [
        'electronics' => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?w=300&q=80',
        'fashion' => 'https://images.unsplash.com/photo-1445205170230-053b83016050?w=300&q=80',
        'home-lifestyle' => 'https://images.unsplash.com/photo-1513694203232-719a280e022f?w=300&q=80',
        'sports-outdoors' => 'https://images.unsplash.com/photo-1517649763962-0c623066013b?w=300&q=80',
        'books-stationery' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=300&q=80',
        'toys-games' => 'https://images.unsplash.com/photo-1558060370-d644479cb6f7?w=300&q=80'
    ];
    ?>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 15px;">
        <?php foreach($categories as $category): ?>
            <?php 
                $imgUrl = !empty($category['image']) ? BASE_URL . $category['image'] : ($categoryImages[$category['slug']] ?? 'https://via.placeholder.com/150?text=Category');
            ?>
            <a href="<?= BASE_URL ?>/category/<?= $category['slug'] ?>" class="category-card">
                <div class="category-img">
                    <img src="<?= $imgUrl ?>" alt="<?= htmlspecialchars($category['name']) ?>">
                </div>
                <h3><?= htmlspecialchars($category['name']) ?></h3>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<!-- Just For You - Full Width Daraz Grid -->
<section style="margin: 20px 0 40px;">
    <div class="section-header">
        <h2>Just For You</h2>
    </div>
    
    <?php if (empty($featuredProducts)): ?>
        <p class="text-muted">No products available at the moment.</p>
    <?php else: ?>
        <div class="product-grid">
            <?php foreach($featuredProducts as $product): ?>
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
</section>
