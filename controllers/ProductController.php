<?php
// controllers/ProductController.php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Review.php';

class ProductController {
    private $productModel;
    private $categoryModel;
    private $reviewModel;
    
    public function __construct() {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
        $this->reviewModel = new Review();
    }

    public function home() {
        $featuredProducts = $this->productModel->getFeatured(8);
        $categories = $this->categoryModel->getAll();
        
        require_once VIEWS_DIR . '/layouts/header.php';
        require_once VIEWS_DIR . '/home/index.php';
        require_once VIEWS_DIR . '/layouts/footer.php';
    }

    public function index() {
        $products = $this->productModel->getAll();
        $categories = $this->categoryModel->getAll();
        $pageTitle = "All Products";
        
        require_once VIEWS_DIR . '/layouts/header.php';
        require_once VIEWS_DIR . '/products/listing.php';
        require_once VIEWS_DIR . '/layouts/footer.php';
    }

    public function category($slug) {
        $category = $this->categoryModel->getBySlug($slug);
        if (!$category) {
            redirect('/');
        }
        
        $products = $this->productModel->getByCategory($category['id']);
        $categories = $this->categoryModel->getAll();
        $pageTitle = $category['name'];
        
        require_once VIEWS_DIR . '/layouts/header.php';
        require_once VIEWS_DIR . '/products/listing.php';
        require_once VIEWS_DIR . '/layouts/footer.php';
    }

    public function search() {
        $query = sanitize($_GET['q'] ?? '');
        $products = $this->productModel->search($query);
        $categories = $this->categoryModel->getAll();
        $pageTitle = "Search Results for '" . htmlspecialchars($query) . "'";
        
        require_once VIEWS_DIR . '/layouts/header.php';
        require_once VIEWS_DIR . '/products/listing.php';
        require_once VIEWS_DIR . '/layouts/footer.php';
    }

    public function detail($id) {
        $product = $this->productModel->getById($id);
        if (!$product) {
            redirect('/products');
        }
        
        require_once VIEWS_DIR . '/layouts/header.php';
        require_once VIEWS_DIR . '/products/detail.php';
        require_once VIEWS_DIR . '/layouts/footer.php';
    }

    public function submitReview() {
        if (!isLoggedIn() || getCurrentUserRole() !== 'customer') {
            setFlash('error', 'Only customers can submit reviews.');
            redirect('/login');
        }

        $productId = (int)($_POST['product_id'] ?? 0);
        $rating = (int)($_POST['rating'] ?? 0);
        $comment = sanitize($_POST['comment'] ?? '');

        if ($productId <= 0 || $rating < 1 || $rating > 5) {
            setFlash('error', 'Invalid review data.');
            redirect('/products');
        }

        $userId = getCurrentUserId();
        $success = $this->reviewModel->addReview($userId, $productId, $rating, $comment);

        if ($success) {
            setFlash('success', 'Your review has been submitted successfully!');
        } else {
            setFlash('error', 'You have already reviewed this product.');
        }

        redirect("/product/$productId");
    }
}
