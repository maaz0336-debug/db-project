<div class="container py-8">
    <div class="card" style="max-width: 600px; margin: 0 auto; padding: 40px; text-align: center;">
        <h1 style="font-size: 2rem; margin-bottom: 10px;">Track Your Order</h1>
        <p style="color: var(--text-muted); margin-bottom: 30px;">Enter your order number below to check its current status.</p>

        <form action="<?= BASE_URL ?>/track-order" method="POST" style="margin-bottom: 30px;">
            <div class="form-group" style="text-align: left;">
                <label for="order_number">Order Number (e.g., ORD-XXXXXXXX)</label>
                <input type="text" id="order_number" name="order_number" class="form-control" placeholder="Enter Order Number" required value="<?= isset($_POST['order_number']) ? htmlspecialchars($_POST['order_number']) : '' ?>">
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">Track Order</button>
        </form>

        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <div style="margin-top: 30px; text-align: left; padding: 20px; background: var(--bg-hover); border-radius: 8px;">
                <?php if (isset($order) && $order): ?>
                    <h3 style="margin-bottom: 15px; border-bottom: 1px solid var(--border-color); padding-bottom: 10px;">Order Details</h3>
                    <p><strong>Order Number:</strong> <?= htmlspecialchars($order['order_number']) ?></p>
                    <p><strong>Date Placed:</strong> <?= date('F j, Y, g:i a', strtotime($order['created_at'])) ?></p>
                    
                    <div style="margin: 20px 0;">
                        <strong>Status:</strong>
                        <span class="badge badge-<?= $order['status'] === 'delivered' ? 'success' : ($order['status'] === 'cancelled' ? 'error' : 'primary') ?>" style="font-size: 1rem; padding: 5px 10px; border-radius: 20px; display: inline-block; margin-left: 10px; text-transform: capitalize;">
                            <?= htmlspecialchars($order['status']) ?>
                        </span>
                    </div>

                    <p><strong>Total Amount:</strong> Rs. <?= number_format($order['total_amount']) ?></p>
                    <p><strong>Shipping Address:</strong> <?= htmlspecialchars($order['shipping_address']) ?></p>
                    <p><strong>Payment Status:</strong> <span style="text-transform: capitalize;"><?= htmlspecialchars($order['payment_status']) ?></span> (<?= strtoupper($order['payment_method']) ?>)</p>

                    <div style="margin-top: 20px;">
                        <h4 style="margin-bottom: 10px;">Items:</h4>
                        <ul style="list-style: none; padding: 0;">
                            <?php foreach ($order['items'] as $item): ?>
                                <li style="display: flex; align-items: center; margin-bottom: 10px; background: var(--card-bg); padding: 10px; border-radius: 8px; border: 1px solid var(--border-color);">
                                    <?php if ($item['image']): ?>
                                        <img src="<?= BASE_URL . $item['image'] ?>" alt="" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px; margin-right: 15px;">
                                    <?php endif; ?>
                                    <div>
                                        <div style="font-weight: 500;"><?= htmlspecialchars($item['product_name']) ?></div>
                                        <div style="color: var(--text-muted); font-size: 0.9rem;">Qty: <?= $item['quantity'] ?> × Rs. <?= number_format($item['unit_price']) ?></div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                <?php else: ?>
                    <div style="text-align: center; color: var(--danger-color);">
                        <svg style="width: 48px; height: 48px; margin: 0 auto 10px auto; color: #ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <h3 style="margin-bottom: 5px;">Order Not Found</h3>
                        <p style="color: var(--text-muted);">We couldn't find any order matching that number. Please check your spelling and try again.</p>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
