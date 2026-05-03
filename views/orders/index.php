<?php
// views/orders/index.php
?>
<div class="mb-4">
    <h1 style="font-size: 28px; font-weight: 700;">My Orders</h1>
    <p class="text-muted">View and track your previous orders.</p>
</div>

<?php if (empty($orders)): ?>
    <div class="card" style="padding: 40px; text-align: center;">
        <div style="width: 80px; height: 80px; background-color: #f8f9fa; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 40px; height: 40px; color: var(--text-muted);"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
        </div>
        <h3 class="mb-2">No orders yet</h3>
        <p class="text-muted mb-4">When you place orders, they will appear here.</p>
        <a href="<?= BASE_URL ?>/products" class="btn btn-primary">Start Shopping</a>
    </div>
<?php else: ?>
    <div class="card">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 1px solid var(--border-color); background-color: #f8f9fa;">
                    <th style="padding: 15px; text-align: left; font-weight: 600;">Order #</th>
                    <th style="padding: 15px; text-align: left; font-weight: 600;">Date</th>
                    <th style="padding: 15px; text-align: left; font-weight: 600;">Total</th>
                    <th style="padding: 15px; text-align: left; font-weight: 600;">Status</th>
                    <th style="padding: 15px; text-align: center; font-weight: 600;">Action</th>
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
                            <?= formatPrice($order['total_amount']) ?>
                        </td>
                        <td style="padding: 15px;">
                            <?php 
                            $statusColors = [
                                'pending' => 'bg-warning',
                                'processing' => 'bg-info',
                                'shipped' => 'bg-primary',
                                'delivered' => 'bg-success',
                                'cancelled' => 'bg-danger'
                            ];
                            $colorMap = [
                                'pending' => '#f39c12',
                                'processing' => '#3498db',
                                'shipped' => '#9b59b6',
                                'delivered' => '#2ecc71',
                                'cancelled' => '#e74c3c'
                            ];
                            $color = $colorMap[$order['status']] ?? '#95a5a6';
                            ?>
                            <span style="background-color: <?= $color ?>; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; text-transform: uppercase;">
                                <?= $order['status'] ?>
                            </span>
                        </td>
                        <td style="padding: 15px; text-align: center;">
                            <a href="<?= BASE_URL ?>/orders/<?= $order['id'] ?>" class="btn btn-outline" style="padding: 5px 10px; font-size: 12px;">View Details</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
