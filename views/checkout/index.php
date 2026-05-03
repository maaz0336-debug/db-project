<?php
// views/checkout/index.php
?>
<div class="mb-4">
    <h1 style="font-size: 28px; font-weight: 700;">Checkout</h1>
    <p class="text-muted">Please provide your shipping and payment details.</p>
</div>

<form action="<?= BASE_URL ?>/checkout/place-order" method="POST">
    <div style="display: flex; flex-wrap: wrap; gap: 30px;">
        <div style="flex: 2; min-width: 300px; display: flex; flex-direction: column; gap: 20px;">
            <!-- Shipping Form -->
            <div class="card" style="padding: 25px;">
                <h3 style="font-size: 18px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                    <span style="background: var(--secondary-color); color: white; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">1</span>
                    Shipping Address
                </h3>
                
                <div class="form-group">
                    <label class="form-label">Street Address</label>
                    <input type="text" name="address" class="form-control" placeholder="123 Main St" required>
                </div>
                
                <div style="display: flex; gap: 15px;">
                    <div class="form-group" style="flex: 2;">
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-control" placeholder="New York" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">Zip Code</label>
                        <input type="text" name="zip" class="form-control" placeholder="10001" required>
                    </div>
                </div>
            </div>

            <!-- Payment Form -->
            <div class="card" style="padding: 25px;">
                <h3 style="font-size: 18px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                    <span style="background: var(--secondary-color); color: white; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">2</span>
                    Payment Method
                </h3>
                
                <div style="display: flex; flex-direction: column; gap: 15px;">
                    <label style="display: flex; align-items: center; gap: 10px; padding: 15px; border: 1px solid var(--border-color); border-radius: var(--radius-sm); cursor: pointer;">
                        <input type="radio" name="payment_method" value="card" checked>
                        <div>
                            <div style="font-weight: 600;">Credit / Debit Card</div>
                            <div style="font-size: 12px; color: var(--text-muted);">Simulated secure payment</div>
                        </div>
                    </label>
                    
                    <label style="display: flex; align-items: center; gap: 10px; padding: 15px; border: 1px solid var(--border-color); border-radius: var(--radius-sm); cursor: pointer;">
                        <input type="radio" name="payment_method" value="cod">
                        <div>
                            <div style="font-weight: 600;">Cash on Delivery</div>
                            <div style="font-size: 12px; color: var(--text-muted);">Pay when you receive the order</div>
                        </div>
                    </label>
                </div>

                <!-- Simulated Card Details -->
                <div id="card-details" style="margin-top: 20px; padding-top: 20px; border-top: 1px dashed var(--border-color);">
                    <div class="form-group">
                        <label class="form-label">Card Number</label>
                        <input type="text" class="form-control" placeholder="0000 0000 0000 0000">
                    </div>
                    <div style="display: flex; gap: 15px;">
                        <div class="form-group" style="flex: 1;">
                            <label class="form-label">Expiry</label>
                            <input type="text" class="form-control" placeholder="MM/YY">
                        </div>
                        <div class="form-group" style="flex: 1;">
                            <label class="form-label">CVV</label>
                            <input type="text" class="form-control" placeholder="123">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div style="flex: 1; min-width: 300px;">
            <div class="card" style="padding: 25px; position: sticky; top: 100px;">
                <h3 style="font-size: 18px; margin-bottom: 20px;">Order Details</h3>
                
                <div style="max-height: 300px; overflow-y: auto; margin-bottom: 20px;">
                    <?php foreach($cartItems as $item): ?>
                        <div style="display: flex; gap: 10px; margin-bottom: 15px;">
                            <img src="<?= getImageUrl($item['image'], 'https://via.placeholder.com/50x50.png') ?>" style="width: 50px; height: 50px; object-fit: contain; background: #f8f9fa; border-radius: 4px;">
                            <div style="flex: 1;">
                                <div style="font-size: 14px; font-weight: 500; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;"><?= htmlspecialchars($item['name']) ?></div>
                                <div style="font-size: 12px; color: var(--text-muted);">Qty: <?= $item['quantity'] ?></div>
                            </div>
                            <div style="font-weight: 600; font-size: 14px;">
                                <?php $price = $item['sale_price'] ? $item['sale_price'] : $item['price']; ?>
                                <?= formatPrice($price * $item['quantity']) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div style="border-top: 1px solid var(--border-color); padding-top: 15px; margin-bottom: 15px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                        <span class="text-muted">Subtotal</span>
                        <span><?= formatPrice($subtotal) ?></span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                        <span class="text-muted">Shipping</span>
                        <span><?= formatPrice(150) ?></span>
                    </div>
                </div>
                
                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border-color); padding-top: 15px; margin-bottom: 25px;">
                    <span style="font-size: 18px; font-weight: 700;">Total</span>
                    <span style="font-size: 24px; font-weight: 700; color: var(--primary-color);"><?= formatPrice($total) ?></span>
                </div>

                <button type="submit" class="btn btn-primary btn-block" style="padding: 15px; font-size: 16px;">Confirm Order</button>
            </div>
        </div>
    </div>
</form>

<script>
    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', (e) => {
            const cardDetails = document.getElementById('card-details');
            if (e.target.value === 'cod') {
                cardDetails.style.display = 'none';
            } else {
                cardDetails.style.display = 'block';
            }
        });
    });
</script>
