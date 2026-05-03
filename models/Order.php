<?php
// models/Order.php
require_once __DIR__ . '/../config/database.php';

class Order {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function createOrder($userId, $totalAmount, $shippingAddress, $cartItems, $paymentMethod) {
        try {
            $this->db->beginTransaction();

            $orderNumber = 'ORD-' . strtoupper(uniqid()) . '-' . rand(1000, 9999);

            $stmt = $this->db->prepare("INSERT INTO orders (user_id, order_number, total_amount, shipping_address, status) VALUES (?, ?, ?, ?, 'pending')");
            $stmt->execute([$userId, $orderNumber, $totalAmount, $shippingAddress]);
            $orderId = $this->db->lastInsertId();

            $stmt = $this->db->prepare("INSERT INTO order_items (order_id, product_id, quantity, unit_price) VALUES (?, ?, ?, ?)");
            $updateStock = $this->db->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
            
            foreach ($cartItems as $item) {
                $price = $item['sale_price'] ? $item['sale_price'] : $item['price'];
                $stmt->execute([$orderId, $item['id'], $item['quantity'], $price]);
                $updateStock->execute([$item['quantity'], $item['id']]);
            }

            $paymentStatus = $paymentMethod === 'cod' ? 'pending' : 'completed';
            $transactionId = $paymentMethod === 'cod' ? null : 'TXN-' . strtoupper(uniqid());

            $stmt = $this->db->prepare("INSERT INTO payments (order_id, amount, method, status, transaction_id) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$orderId, $totalAmount, $paymentMethod, $paymentStatus, $transactionId]);

            // Clear cart
            $stmt = $this->db->prepare("DELETE FROM cart_items WHERE user_id = ?");
            $stmt->execute([$userId]);

            $this->db->commit();
            return $orderId;

        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function getUserOrders($userId) {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function getOrderDetails($orderId, $userId) {
        $stmt = $this->db->prepare("SELECT o.*, p.method as payment_method, p.status as payment_status 
            FROM orders o 
            LEFT JOIN payments p ON o.id = p.order_id 
            WHERE o.id = ? AND o.user_id = ?");
        $stmt->execute([$orderId, $userId]);
        $order = $stmt->fetch();

        if ($order) {
            $stmt = $this->db->prepare("SELECT oi.*, p.name as product_name, p.image 
                FROM order_items oi 
                JOIN products p ON oi.product_id = p.id 
                WHERE oi.order_id = ?");
            $stmt->execute([$orderId]);
            $order['items'] = $stmt->fetchAll();
        }

        return $order;
    }

    public function getOrderByNumber($orderNumber) {
        $stmt = $this->db->prepare("SELECT o.*, p.method as payment_method, p.status as payment_status 
            FROM orders o 
            LEFT JOIN payments p ON o.id = p.order_id 
            WHERE o.order_number = ?");
        $stmt->execute([$orderNumber]);
        $order = $stmt->fetch();

        if ($order) {
            $stmt = $this->db->prepare("SELECT oi.*, p.name as product_name, p.image 
                FROM order_items oi 
                JOIN products p ON oi.product_id = p.id 
                WHERE oi.order_id = ?");
            $stmt->execute([$order['id']]);
            $order['items'] = $stmt->fetchAll();
        }

        return $order;
    }
}
