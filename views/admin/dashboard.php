<?php
// views/admin/dashboard.php
?>
<div class="mb-4">
    <h1 style="font-size: 28px; font-weight: 700;">Admin Dashboard</h1>
    <p class="text-muted">Platform overview and management.</p>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <div class="card" style="padding: 25px; border-left: 4px solid #3498db;">
        <h3 class="text-muted" style="font-size: 14px; text-transform: uppercase;">Total Users</h3>
        <div style="font-size: 32px; font-weight: 700; margin-top: 10px;"><?= $stats['total_users'] ?></div>
    </div>
    
    <div class="card" style="padding: 25px; border-left: 4px solid #2ecc71;">
        <h3 class="text-muted" style="font-size: 14px; text-transform: uppercase;">Total Orders</h3>
        <div style="font-size: 32px; font-weight: 700; margin-top: 10px;"><?= $stats['total_orders'] ?></div>
    </div>
    
    <div class="card" style="padding: 25px; border-left: 4px solid #9b59b6;">
        <h3 class="text-muted" style="font-size: 14px; text-transform: uppercase;">Total Revenue</h3>
        <div style="font-size: 32px; font-weight: 700; margin-top: 10px;"><?= formatPrice($stats['total_revenue']) ?></div>
    </div>
    
    <div class="card" style="padding: 25px; border-left: 4px solid #e74c3c;">
        <h3 class="text-muted" style="font-size: 14px; text-transform: uppercase;">Pending Sellers</h3>
        <div style="font-size: 32px; font-weight: 700; margin-top: 10px;"><?= $stats['pending_sellers'] ?></div>
    </div>
</div>

<div style="display: flex; flex-wrap: wrap; gap: 30px;">
    <!-- Pending Sellers -->
    <div style="flex: 1; min-width: 300px;">
        <div class="card" style="padding: 20px;">
            <h3 style="font-size: 18px; margin-bottom: 20px;">Pending Seller Approvals</h3>
            
            <?php if(empty($pendingSellers)): ?>
                <p class="text-muted">No pending approvals at this time.</p>
            <?php else: ?>
                <table style="width: 100%; border-collapse: collapse;">
                    <tbody>
                        <?php foreach($pendingSellers as $seller): ?>
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td style="padding: 15px 0;">
                                    <div style="font-weight: 600;"><?= htmlspecialchars($seller['store_name']) ?></div>
                                    <div style="font-size: 12px; color: var(--text-muted);"><?= htmlspecialchars($seller['name']) ?> (<?= htmlspecialchars($seller['email']) ?>)</div>
                                </td>
                                <td style="padding: 15px 0; text-align: right;">
                                    <form action="<?= BASE_URL ?>/admin/approve-seller" method="POST">
                                        <input type="hidden" name="seller_id" value="<?= $seller['id'] ?>">
                                        <button type="submit" class="btn btn-primary" style="padding: 5px 15px; font-size: 12px;">Approve</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <!-- Recent Orders -->
    <div style="flex: 1; min-width: 300px;">
        <div class="card" style="padding: 20px;">
            <h3 style="font-size: 18px; margin-bottom: 20px;">Recent Platform Orders</h3>
            
            <table style="width: 100%; border-collapse: collapse;">
                <tbody>
                    <?php foreach($recentOrders as $order): ?>
                        <tr style="border-bottom: 1px solid var(--border-color);">
                            <td style="padding: 15px 0;">
                                <div style="font-weight: 600;">#<?= htmlspecialchars($order['order_number']) ?></div>
                                <div style="font-size: 12px; color: var(--text-muted);"><?= date('M d, Y', strtotime($order['created_at'])) ?></div>
                            </td>
                            <td style="padding: 15px 0;">
                                <span style="background-color: var(--primary-color); color: white; padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: bold; text-transform: uppercase;">
                                    <?= $order['status'] ?>
                                </span>
                            </td>
                            <td style="padding: 15px 0; text-align: right; font-weight: 600;">
                                <?= formatPrice($order['total_amount']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
