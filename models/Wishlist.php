<?php
// models/Wishlist.php
require_once __DIR__ . '/../config/database.php';

class Wishlist {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function getUserWishlist($userId) {
        $stmt = $this->db->prepare("SELECT w.id as wishlist_id, p.*, c.name as category_name 
            FROM wishlists w 
            JOIN products p ON w.product_id = p.id 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE w.user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function toggleItem($userId, $productId) {
        $stmt = $this->db->prepare("SELECT id FROM wishlists WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$userId, $productId]);
        
        if ($stmt->fetch()) {
            // Remove
            $stmt = $this->db->prepare("DELETE FROM wishlists WHERE user_id = ? AND product_id = ?");
            $stmt->execute([$userId, $productId]);
            return 'removed';
        } else {
            // Add
            $stmt = $this->db->prepare("INSERT INTO wishlists (user_id, product_id) VALUES (?, ?)");
            $stmt->execute([$userId, $productId]);
            return 'added';
        }
    }

    public function removeItem($wishlistId, $userId) {
        $stmt = $this->db->prepare("DELETE FROM wishlists WHERE id = ? AND user_id = ?");
        return $stmt->execute([$wishlistId, $userId]);
    }
}
