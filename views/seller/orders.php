<?php
// views/seller/orders.php
?>
<div class="mb-4">
    <h1 style="font-size: 28px; font-weight: 700;">Order Management</h1>
    <p class="text-muted">View orders containing your products.</p>
</div>

<div class="card">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="border-bottom: 1px solid var(--border-color); background-color: #f8f9fa;">
                <th style="padding: 15px; text-align: left;">Order #</th>
                <th style="padding: 15px; text-align: left;">Date</th>
                <th style="padding: 15px; text-align: left;">Total for Your Items</th>
                <th style="padding: 15px; text-align: left;">Status</th>
                <th style="padding: 15px; text-align: center;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($orders as $order): ?>
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 15px; font-weight: 500;">
                        <?= htmlspecialchars($order['order_number']) ?>
                    </td>
                    <td style="padding: 15px; color: var(--text-muted);">
                        <?= date('M d, Y', strtotime($order['created_at'])) ?>
                    </td>
                    <td style="padding: 15px; font-weight: 600;">
                        <?= formatPrice($order['order_total']) ?>
                    </td>
                    <td style="padding: 15px;">
                        <span style="background-color: var(--primary-color); color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; text-transform: uppercase;">
                            <?= $order['status'] ?>
                        </span>
                    </td>
                    <td style="padding: 15px; text-align: center;">
                        <a href="#" class="btn btn-outline" style="padding: 5px 10px; font-size: 12px;">Manage</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if(empty($orders)): ?>
                <tr>
                    <td colspan="5" style="padding: 30px; text-align: center; color: var(--text-muted);">No orders found for your products yet.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
