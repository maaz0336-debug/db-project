<?php
// views/orders/detail.php
?>
<div class="mb-4" style="display: flex; justify-content: space-between; align-items: flex-end;">
    <div>
        <a href="<?= BASE_URL ?>/orders" style="color: var(--text-muted); font-size: 14px; display: flex; align-items: center; gap: 5px; margin-bottom: 10px;">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Orders
        </a>
        <h1 style="font-size: 28px; font-weight: 700;">Order Details</h1>
        <p class="text-muted">Order #<?= htmlspecialchars($order['order_number']) ?> - Placed on <?= date('M d, Y h:i A', strtotime($order['created_at'])) ?></p>
    </div>
    
    <?php 
    $colorMap = [
        'pending' => '#f39c12',
        'processing' => '#3498db',
        'shipped' => '#9b59b6',
        'delivered' => '#2ecc71',
        'cancelled' => '#e74c3c'
    ];
    $color = $colorMap[$order['status']] ?? '#95a5a6';
    ?>
    <div style="background-color: <?= $color ?>; color: white; padding: 8px 15px; border-radius: 4px; font-weight: bold; text-transform: uppercase;">
        Status: <?= $order['status'] ?>
    </div>
</div>

<div style="display: flex; flex-wrap: wrap; gap: 30px;">
    <!-- Items -->
    <div style="flex: 2; min-width: 300px;">
        <div class="card" style="padding: 20px;">
            <h3 style="font-size: 18px; margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 10px;">Items in your order</h3>
            
            <table style="width: 100%; border-collapse: collapse;">
                <tbody>
                    <?php foreach($order['items'] as $item): ?>
                        <tr style="border-bottom: 1px solid var(--border-color);">
                            <td style="padding: 15px 0;">
                                <div style="display: flex; gap: 15px; align-items: center;">
                                    <div style="width: 60px; height: 60px; background-color: #f8f9fa; border-radius: var(--radius-sm); padding: 5px;">
                                        <img src="<?= getImageUrl($item['image'], 'https://via.placeholder.com/100x100.png') ?>" style="width: 100%; height: 100%; object-fit: contain; mix-blend-mode: multiply;">
                                    </div>
                                    <div>
                                        <a href="<?= BASE_URL ?>/product/<?= $item['product_id'] ?>" style="font-weight: 600; display: block; margin-bottom: 5px;"><?= htmlspecialchars($item['product_name']) ?></a>
                                        <div style="font-size: 14px; color: var(--text-muted);">Qty: <?= $item['quantity'] ?> x <?= formatPrice($item['unit_price']) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 15px 0; text-align: right; font-weight: 600;">
                                <?= formatPrice($item['quantity'] * $item['unit_price']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <div style="margin-top: 20px; width: 300px; margin-left: auto;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px;">
                    <span class="text-muted">Subtotal</span>
                    <span><?= formatPrice($order['total_amount'] - 150) ?></span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px;">
                    <span class="text-muted">Shipping</span>
                    <span><?= formatPrice(150) ?></span>
                </div>
                <div style="display: flex; justify-content: space-between; padding-top: 10px; border-top: 1px solid var(--border-color); font-weight: 700; font-size: 18px;">
                    <span>Total</span>
                    <span style="color: var(--primary-color);"><?= formatPrice($order['total_amount']) ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Details -->
    <div style="flex: 1; min-width: 300px; display: flex; flex-direction: column; gap: 20px;">
        <div class="card" style="padding: 20px;">
            <h3 style="font-size: 16px; margin-bottom: 15px; border-bottom: 1px solid var(--border-color); padding-bottom: 10px;">Shipping Address</h3>
            <p style="color: var(--text-muted); line-height: 1.6;">
                <?= htmlspecialchars($order['shipping_address']) ?>
            </p>
        </div>
        
        <div class="card" style="padding: 20px;">
            <h3 style="font-size: 16px; margin-bottom: 15px; border-bottom: 1px solid var(--border-color); padding-bottom: 10px;">Payment Information</h3>
            <div style="margin-bottom: 10px;">
                <span style="font-weight: 600; font-size: 14px;">Method: </span>
                <span class="text-muted" style="text-transform: uppercase;"><?= str_replace('_', ' ', $order['payment_method']) ?></span>
            </div>
            <div>
                <span style="font-weight: 600; font-size: 14px;">Status: </span>
                <span style="background-color: <?= $order['payment_status'] === 'completed' ? '#2ecc71' : '#f39c12' ?>; color: white; padding: 2px 6px; border-radius: 4px; font-size: 12px; font-weight: bold; text-transform: uppercase;">
                    <?= $order['payment_status'] ?>
                </span>
            </div>
        </div>
    </div>
</div>
