<?php
// views/products/detail.php
$avgRating = round($product['avg_rating'] ?? 0, 1);
$reviewCount = $product['review_count'] ?? 0;
?>
<div class="card" style="padding: 30px; margin-bottom: 30px;">
    <div style="display: flex; flex-wrap: wrap; gap: 40px;">
        <!-- Product Image -->
        <div style="flex: 1; min-width: 300px;">
            <div style="background-color: #f8f9fa; border-radius: var(--radius-md); padding: 20px; text-align: center;">
                <img src="<?= getImageUrl($product['image'], 'https://via.placeholder.com/500x500.png?text=Product+Image') ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="max-width: 100%; height: auto; mix-blend-mode: multiply;">
            </div>
        </div>

        <!-- Product Details -->
        <div style="flex: 1; min-width: 300px; display: flex; flex-direction: column;">
            <div style="margin-bottom: 10px;">
                <span style="background-color: var(--primary-color); color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold;">
                    <?= htmlspecialchars($product['category_name']) ?>
                </span>
            </div>
            
            <h1 style="font-size: 28px; line-height: 1.3; margin-bottom: 10px;"><?= htmlspecialchars($product['name']) ?></h1>
            
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; font-size: 14px;">
                <div style="color: #F1C40F;">
                    <?= str_repeat('★', round($avgRating)) ?><?= str_repeat('☆', 5 - round($avgRating)) ?>
                </div>
                <span class="text-muted">(<?= $reviewCount ?> Reviews)</span>
                <span style="color: var(--border-color);">|</span>
                <span class="text-muted">Sold by: <strong style="color: var(--secondary-color);"><?= htmlspecialchars($product['store_name']) ?></strong></span>
            </div>

            <div style="font-size: 32px; font-weight: 700; color: var(--primary-color); margin-bottom: 20px;">
                <?= formatPrice($product['price']) ?>
            </div>

            <div style="border-top: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color); padding: 20px 0; margin-bottom: 20px;">
                <p style="color: var(--text-muted); line-height: 1.8;"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
            </div>

            <form action="<?= BASE_URL ?>/cart/add" method="POST" style="margin-top: auto;">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                
                <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
                    <span style="font-weight: 600;">Quantity:</span>
                    <div style="display: flex; align-items: center; border: 1px solid var(--border-color); border-radius: var(--radius-sm);">
                        <button type="button" style="padding: 8px 15px; font-size: 18px;" onclick="document.getElementById('qty').value = Math.max(1, parseInt(document.getElementById('qty').value) - 1)">-</button>
                        <input type="number" id="qty" name="quantity" value="1" min="1" max="<?= $product['stock'] ?>" style="width: 50px; text-align: center; border: none; border-left: 1px solid var(--border-color); border-right: 1px solid var(--border-color); padding: 8px 0; -moz-appearance: textfield;">
                        <button type="button" style="padding: 8px 15px; font-size: 18px;" onclick="document.getElementById('qty').value = Math.min(<?= $product['stock'] ?>, parseInt(document.getElementById('qty').value) + 1)">+</button>
                    </div>
                    <span class="text-muted" style="font-size: 14px;"><?= $product['stock'] ?> pieces available</span>
                </div>

                <div style="display: flex; gap: 15px;">
                    <button type="submit" class="btn btn-primary" style="flex: 1; padding: 15px; font-size: 16px;">Add to Cart</button>
                    <button type="submit" formaction="<?= BASE_URL ?>/checkout/direct" class="btn btn-outline" style="flex: 1; padding: 15px; font-size: 16px;">Buy Now</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reviews Section -->
<?php
require_once MODELS_DIR . '/Review.php';
$reviewModel = new Review();
$reviews = $reviewModel->getByProductId($product['id']);
?>

<div class="card" style="padding: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h2 style="font-size: 20px;">Product Reviews</h2>
        <div style="display: flex; align-items: center; gap: 10px;">
            <div style="font-size: 24px; font-weight: 700; color: var(--primary-color);"><?= $avgRating ?></div>
            <div>
                <div style="color: #F1C40F; font-size: 14px;">
                    <?= str_repeat('★', round($avgRating)) ?><?= str_repeat('☆', 5 - round($avgRating)) ?>
                </div>
                <div style="font-size: 12px; color: var(--text-muted);"><?= $reviewCount ?> Ratings</div>
            </div>
        </div>
    </div>

    <?php if (isLoggedIn() && getCurrentUserRole() === 'customer'): ?>
        <form action="<?= BASE_URL ?>/review/submit" method="POST" style="margin-bottom: 40px; padding-bottom: 20px; border-bottom: 1px solid var(--border-color);">
            <h4 style="margin-bottom: 15px;">Write a Review</h4>
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
            
            <div class="form-group" style="display: flex; align-items: center; gap: 10px;">
                <label>Rating:</label>
                <div style="color: #F1C40F; font-size: 20px; cursor: pointer;">
                    <!-- Simple implementation, ideal would be JS star rating -->
                    <select name="rating" style="padding: 5px; border-color: var(--border-color);">
                        <option value="5">★★★★★ (5/5)</option>
                        <option value="4">★★★★☆ (4/5)</option>
                        <option value="3">★★★☆☆ (3/5)</option>
                        <option value="2">★★☆☆☆ (2/5)</option>
                        <option value="1">★☆☆☆☆ (1/5)</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <textarea name="comment" class="form-control" rows="3" placeholder="Tell others what you think about this product..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Review</button>
        </form>
    <?php endif; ?>

    <div style="display: flex; flex-direction: column; gap: 20px;">
        <?php if (empty($reviews)): ?>
            <p class="text-muted text-center" style="padding: 20px;">No reviews yet. Be the first to review this product!</p>
        <?php else: ?>
            <?php foreach($reviews as $review): ?>
                <div style="padding-bottom: 20px; border-bottom: 1px solid var(--border-color);">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <div style="font-weight: 600;"><?= htmlspecialchars($review['user_name']) ?></div>
                        <div style="color: var(--text-muted); font-size: 12px;"><?= date('M d, Y', strtotime($review['created_at'])) ?></div>
                    </div>
                    <div style="color: #F1C40F; font-size: 14px; margin-bottom: 10px;">
                        <?= str_repeat('★', $review['rating']) ?><?= str_repeat('☆', 5 - $review['rating']) ?>
                    </div>
                    <p style="color: var(--text-main); font-size: 14px; line-height: 1.5;">
                        <?= nl2br(htmlspecialchars($review['comment'])) ?>
                    </p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
