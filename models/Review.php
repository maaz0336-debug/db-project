<?php
// models/Review.php
require_once __DIR__ . '/../config/database.php';

class Review {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function getByProductId($productId) {
        $stmt = $this->db->prepare("SELECT r.*, u.name as user_name 
            FROM reviews r 
            JOIN users u ON r.user_id = u.id 
            WHERE r.product_id = ? 
            ORDER BY r.created_at DESC");
        $stmt->execute([$productId]);
        return $stmt->fetchAll();
    }

    public function getAverageRating($productId) {
        $stmt = $this->db->prepare("SELECT AVG(rating) as avg_rating, COUNT(*) as review_count FROM reviews WHERE product_id = ?");
        $stmt->execute([$productId]);
        return $stmt->fetch();
    }

    public function addReview($userId, $productId, $rating, $comment) {
        // Check if already reviewed
        $stmt = $this->db->prepare("SELECT id FROM reviews WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$userId, $productId]);
        if ($stmt->fetch()) {
            return false; // Already reviewed
        }

        $stmt = $this->db->prepare("INSERT INTO reviews (user_id, product_id, rating, comment) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$userId, $productId, $rating, $comment]);
    }
}
