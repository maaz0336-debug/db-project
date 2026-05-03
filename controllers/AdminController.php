<?php
// controllers/AdminController.php
require_once __DIR__ . '/../config/database.php';

class AdminController {
    private $db;

    public function __construct() {
        requireRole('admin');
        $this->db = getDB();
    }

    public function dashboard() {
        // Get platform stats
        $stats = [];
        
        $stats['total_users'] = $this->db->query("SELECT COUNT(*) FROM users")->fetchColumn();
        $stats['total_orders'] = $this->db->query("SELECT COUNT(*) FROM orders")->fetchColumn();
        $stats['total_revenue'] = $this->db->query("SELECT SUM(total_amount) FROM orders WHERE status != 'cancelled'")->fetchColumn();
        $stats['pending_sellers'] = $this->db->query("SELECT COUNT(*) FROM sellers WHERE is_approved = 0")->fetchColumn();

        // Get recent orders
        $recentOrders = $this->db->query("SELECT * FROM orders ORDER BY created_at DESC LIMIT 5")->fetchAll();
        
        // Get pending sellers
        $pendingSellers = $this->db->query("SELECT s.*, u.name, u.email FROM sellers s JOIN users u ON s.user_id = u.id WHERE s.is_approved = 0")->fetchAll();

        require_once VIEWS_DIR . '/layouts/header.php';
        require_once VIEWS_DIR . '/admin/dashboard.php';
        require_once VIEWS_DIR . '/layouts/footer.php';
    }

    public function approveSeller() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sellerId = $_POST['seller_id'] ?? null;
            if ($sellerId) {
                $stmt = $this->db->prepare("UPDATE sellers SET is_approved = 1 WHERE id = ?");
                $stmt->execute([$sellerId]);
                
                // Update user role
                $stmt = $this->db->prepare("UPDATE users SET role = 'seller' WHERE id = (SELECT user_id FROM sellers WHERE id = ?)");
                $stmt->execute([$sellerId]);
                
                setFlash('success', 'Seller approved successfully.');
            }
        }
        redirect('/admin/dashboard');
    }
}
