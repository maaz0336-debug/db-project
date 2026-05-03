<?php
// models/Product.php
require_once __DIR__ . '/../config/database.php';

class Product {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function getFeatured($limit = 8) {
        $stmt = $this->db->prepare("SELECT p.*, c.name as category_name,
            (SELECT AVG(rating) FROM reviews WHERE product_id = p.id) as avg_rating,
            (SELECT COUNT(*) FROM reviews WHERE product_id = p.id) as review_count
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE p.is_active = 1 
            ORDER BY p.created_at DESC LIMIT ?");
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getByCategory($categoryId) {
        $stmt = $this->db->prepare("SELECT p.*, c.name as category_name,
            (SELECT AVG(rating) FROM reviews WHERE product_id = p.id) as avg_rating,
            (SELECT COUNT(*) FROM reviews WHERE product_id = p.id) as review_count
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE p.category_id = ? AND p.is_active = 1 
            ORDER BY p.created_at DESC");
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll();
    }

    public function search($query) {
        $searchTerm = "%{$query}%";
        $stmt = $this->db->prepare("SELECT p.*, c.name as category_name,
            (SELECT AVG(rating) FROM reviews WHERE product_id = p.id) as avg_rating,
            (SELECT COUNT(*) FROM reviews WHERE product_id = p.id) as review_count
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE (p.name LIKE ? OR p.description LIKE ?) AND p.is_active = 1 
            ORDER BY p.created_at DESC");
        $stmt->execute([$searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT p.*, c.name as category_name,
            (SELECT AVG(rating) FROM reviews WHERE product_id = p.id) as avg_rating,
            (SELECT COUNT(*) FROM reviews WHERE product_id = p.id) as review_count
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE p.is_active = 1 
            ORDER BY p.created_at DESC");
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT p.*, c.name as category_name, s.store_name,
            (SELECT AVG(rating) FROM reviews WHERE product_id = p.id) as avg_rating,
            (SELECT COUNT(*) FROM reviews WHERE product_id = p.id) as review_count
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id 
            LEFT JOIN sellers s ON p.seller_id = s.id
            WHERE p.id = ? AND p.is_active = 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
