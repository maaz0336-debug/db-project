<?php
// models/Category.php
require_once __DIR__ . '/../config/database.php';

class Category {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM categories ORDER BY name ASC");
        return $stmt->fetchAll();
    }

    public function getBySlug($slug) {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE slug = ?");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }
}
