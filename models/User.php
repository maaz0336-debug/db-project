<?php
// models/User.php
require_once __DIR__ . '/../config/database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO users (name, email, password_hash, role) VALUES (?, ?, ?, ?)");
        return $stmt->execute([
            $data['name'],
            $data['email'],
            password_hash($data['password'], PASSWORD_BCRYPT),
            $data['role'] ?? 'customer'
        ]);
    }

    public function verifyPassword($email, $password) {
        $user = $this->findByEmail($email);
        if ($user && password_verify($password, $user['password_hash'])) {
            return $user;
        }
        return false;
    }
}
