<?php
// controllers/SellerController.php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Category.php';

class SellerController {
    private $db;
    private $sellerId;

    public function __construct() {
        requireRole('seller');
        $this->db = getDB();
        
        // Get seller profile
        $stmt = $this->db->prepare("SELECT id FROM sellers WHERE user_id = ? AND is_approved = 1");
        $stmt->execute([getCurrentUserId()]);
        $seller = $stmt->fetch();
        
        if (!$seller) {
            setFlash('error', 'Your seller account is pending approval.');
            redirect('/');
        }
        
        $this->sellerId = $seller['id'];
    }

    public function dashboard() {
        // Get stats
        $stmt = $this->db->prepare("SELECT COUNT(*) as total_products FROM products WHERE seller_id = ?");
        $stmt->execute([$this->sellerId]);
        $totalProducts = $stmt->fetchColumn();

        $stmt = $this->db->prepare("SELECT COUNT(DISTINCT oi.order_id) as total_orders 
            FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE p.seller_id = ?");
        $stmt->execute([$this->sellerId]);
        $totalOrders = $stmt->fetchColumn();

        require_once VIEWS_DIR . '/layouts/header.php';
        require_once VIEWS_DIR . '/seller/dashboard.php';
        require_once VIEWS_DIR . '/layouts/footer.php';
    }

    public function products() {
        $stmt = $this->db->prepare("SELECT p.*, c.name as category_name 
            FROM products p LEFT JOIN categories c ON p.category_id = c.id 
            WHERE p.seller_id = ? ORDER BY p.created_at DESC");
        $stmt->execute([$this->sellerId]);
        $products = $stmt->fetchAll();

        require_once VIEWS_DIR . '/layouts/header.php';
        require_once VIEWS_DIR . '/seller/products.php';
        require_once VIEWS_DIR . '/layouts/footer.php';
    }

    public function addProduct() {
        $categoryModel = new Category();
        $categories = $categoryModel->getAll();

        require_once VIEWS_DIR . '/layouts/header.php';
        require_once VIEWS_DIR . '/seller/add_product.php';
        require_once VIEWS_DIR . '/layouts/footer.php';
    }

    public function addProductPost() {
        $name = sanitize($_POST['name'] ?? '');
        $description = sanitize($_POST['description'] ?? '');
        $price = $_POST['price'] ?? 0;
        $stock = $_POST['stock'] ?? 0;
        $categoryId = $_POST['category_id'] ?? null;
        $slug = generateSlug($name) . '-' . uniqid();

        // Handle File Upload Simple
        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $tmp_name = $_FILES['image']['tmp_name'];
            $name_file = basename($_FILES['image']['name']);
            $ext = strtolower(pathinfo($name_file, PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                $newName = uniqid() . '.' . $ext;
                $destination = UPLOAD_DIR . '/products/' . $newName;
                if (move_uploaded_file($tmp_name, $destination)) {
                    $imagePath = '/uploads/products/' . $newName;
                }
            }
        }

        $stmt = $this->db->prepare("INSERT INTO products (seller_id, category_id, name, slug, description, price, stock, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$this->sellerId, $categoryId, $name, $slug, $description, $price, $stock, $imagePath])) {
            setFlash('success', 'Product added successfully.');
        } else {
            setFlash('error', 'Failed to add product.');
        }
        redirect('/seller/products');
    }

    public function orders() {
        $stmt = $this->db->prepare("SELECT o.id, o.order_number, o.created_at, o.status, 
            SUM(oi.quantity * oi.unit_price) as order_total 
            FROM orders o 
            JOIN order_items oi ON o.id = oi.order_id 
            JOIN products p ON oi.product_id = p.id 
            WHERE p.seller_id = ? 
            GROUP BY o.id ORDER BY o.created_at DESC");
        $stmt->execute([$this->sellerId]);
        $orders = $stmt->fetchAll();

        require_once VIEWS_DIR . '/layouts/header.php';
        require_once VIEWS_DIR . '/seller/orders.php';
        require_once VIEWS_DIR . '/layouts/footer.php';
    }
}
