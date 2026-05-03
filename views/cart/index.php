<?php
// views/cart/index.php
?>
<div class="mb-4">
    <h1 style="font-size: 28px; font-weight: 700;">Shopping Cart</h1>
</div>

<div style="display: flex; flex-wrap: wrap; gap: 30px;">
    <!-- Cart Items -->
    <div style="flex: 2; min-width: 300px;">
        <?php if (empty($cartItems)): ?>
            <div class="card" style="padding: 40px; text-align: center;">
                <div style="width: 80px; height: 80px; background-color: #f8f9fa; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 40px; height: 40px; color: var(--text-muted);"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <h3 class="mb-2">Your cart is empty</h3>
                <p class="text-muted mb-4">Looks like you haven't added anything to your cart yet.</p>
                <a href="<?= BASE_URL ?>/products" class="btn btn-primary">Start Shopping</a>
            </div>
        <?php else: ?>
            <div class="card" style="padding: 20px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--border-color); text-align: left;">
                            <th style="padding: 15px 10px; color: var(--text-muted); font-weight: 500;">Product</th>
                            <th style="padding: 15px 10px; color: var(--text-muted); font-weight: 500;">Price</th>
                            <th style="padding: 15px 10px; color: var(--text-muted); font-weight: 500;">Quantity</th>
                            <th style="padding: 15px 10px; color: var(--text-muted); font-weight: 500; text-align: right;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($cartItems as $item): 
                            $price = $item['sale_price'] ? $item['sale_price'] : $item['price'];
                            $itemTotal = $price * $item['quantity'];
                        ?>
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td style="padding: 20px 10px;">
                                    <div style="display: flex; gap: 15px; align-items: center;">
                                        <div style="width: 80px; height: 80px; background-color: #f8f9fa; border-radius: var(--radius-sm); padding: 5px;">
                                            <img src="<?= getImageUrl($item['image'], 'https://via.placeholder.com/100x100.png') ?>" style="width: 100%; height: 100%; object-fit: contain; mix-blend-mode: multiply;">
                                        </div>
                                        <div>
                                            <a href="<?= BASE_URL ?>/product/<?= $item['id'] ?>" style="font-weight: 600; display: block; margin-bottom: 5px;"><?= htmlspecialchars($item['name']) ?></a>
                                            <div style="font-size: 12px; color: var(--text-muted);">Sold by: <?= htmlspecialchars($item['store_name']) ?></div>
                                            
                                            <form action="<?= BASE_URL ?>/cart/remove" method="POST" style="margin-top: 10px;">
                                                <input type="hidden" name="cart_item_id" value="<?= $item['cart_item_id'] ?>">
                                                <button type="submit" style="color: var(--danger-color); font-size: 12px; display: flex; align-items: center; gap: 4px;">
                                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    Remove
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 20px 10px; font-weight: 500;">
                                    <?= formatPrice($price) ?>
                                </td>
                                <td style="padding: 20px 10px;">
                                    <form action="<?= BASE_URL ?>/cart/update" method="POST" style="display: flex; align-items: center; border: 1px solid var(--border-color); border-radius: var(--radius-sm); width: max-content;">
                                        <input type="hidden" name="cart_item_id" value="<?= $item['cart_item_id'] ?>">
                                        <button type="button" style="padding: 5px 10px;" onclick="this.nextElementSibling.value = Math.max(1, parseInt(this.nextElementSibling.value) - 1); this.form.submit();">-</button>
                                        <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" max="<?= $item['stock'] ?>" style="width: 40px; text-align: center; border: none; border-left: 1px solid var(--border-color); border-right: 1px solid var(--border-color); padding: 5px 0; -moz-appearance: textfield;" onchange="this.form.submit()">
                                        <button type="button" style="padding: 5px 10px;" onclick="this.previousElementSibling.value = Math.min(<?= $item['stock'] ?>, parseInt(this.previousElementSibling.value) + 1); this.form.submit();">+</button>
                                    </form>
                                </td>
                                <td style="padding: 20px 10px; text-align: right; font-weight: 700; color: var(--primary-color);">
                                    <?= formatPrice($itemTotal) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- Order Summary -->
    <?php if (!empty($cartItems)): ?>
    <div style="flex: 1; min-width: 300px;">
        <div class="card" style="padding: 20px; position: sticky; top: 100px;">
            <h3 style="font-size: 18px; margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 10px;">Order Summary</h3>
            
            <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                <span class="text-muted">Subtotal (<?= count($cartItems) ?> items)</span>
                <span style="font-weight: 500;"><?= formatPrice($subtotal) ?></span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                <span class="text-muted">Shipping Fee</span>
                <span style="font-weight: 500;">Calculated at checkout</span>
            </div>
            
            <div style="display: flex; justify-content: space-between; margin-bottom: 20px; padding-top: 15px; border-top: 1px solid var(--border-color); font-size: 18px; font-weight: 700;">
                <span>Total</span>
                <span style="color: var(--primary-color);"><?= formatPrice($subtotal) ?></span>
            </div>
            
            <a href="<?= BASE_URL ?>/checkout" class="btn btn-primary btn-block" style="padding: 15px; font-size: 16px;">Proceed to Checkout</a>
            
            <div style="display: flex; gap: 10px; justify-content: center; margin-top: 20px;">
                <!-- Payment Icons -->
                <div style="background: var(--bg-main); padding: 5px 10px; border-radius: 4px; font-size: 10px; font-weight: bold;">SECURE CHECKOUT</div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
