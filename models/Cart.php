<?php
// models/Cart.php
require_once __DIR__ . '/../config/database.php';

class Cart {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function getUserCart($userId) {
        $stmt = $this->db->prepare("SELECT c.id as cart_item_id, c.quantity, p.*, cat.name as category_name, s.store_name 
            FROM cart_items c 
            JOIN products p ON c.product_id = p.id 
            LEFT JOIN categories cat ON p.category_id = cat.id
            LEFT JOIN sellers s ON p.seller_id = s.id
            WHERE c.user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function addItem($userId, $productId, $quantity = 1) {
        // Check if product already in cart
        $stmt = $this->db->prepare("SELECT id, quantity FROM cart_items WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$userId, $productId]);
        $existing = $stmt->fetch();

        if ($existing) {
            // Update quantity
            $newQuantity = $existing['quantity'] + $quantity;
            $stmt = $this->db->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
            return $stmt->execute([$newQuantity, $existing['id']]);
        } else {
            // Insert new item
            $stmt = $this->db->prepare("INSERT INTO cart_items (user_id, product_id, quantity) VALUES (?, ?, ?)");
            return $stmt->execute([$userId, $productId, $quantity]);
        }
    }

    public function updateQuantity($cartItemId, $userId, $quantity) {
        if ($quantity <= 0) {
            return $this->removeItem($cartItemId, $userId);
        }
        $stmt = $this->db->prepare("UPDATE cart_items SET quantity = ? WHERE id = ? AND user_id = ?");
        return $stmt->execute([$quantity, $cartItemId, $userId]);
    }

    public function removeItem($cartItemId, $userId) {
        $stmt = $this->db->prepare("DELETE FROM cart_items WHERE id = ? AND user_id = ?");
        return $stmt->execute([$cartItemId, $userId]);
    }

    public function clearCart($userId) {
        $stmt = $this->db->prepare("DELETE FROM cart_items WHERE user_id = ?");
        return $stmt->execute([$userId]);
    }
}
