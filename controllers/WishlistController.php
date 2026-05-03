<?php
// controllers/WishlistController.php
require_once __DIR__ . '/../models/Wishlist.php';

class WishlistController {
    private $wishlistModel;

    public function __construct() {
        $this->wishlistModel = new Wishlist();
    }

    public function index() {
        requireLogin();
        $wishlistItems = $this->wishlistModel->getUserWishlist(getCurrentUserId());
        
        require_once VIEWS_DIR . '/layouts/header.php';
        require_once VIEWS_DIR . '/wishlist/index.php';
        require_once VIEWS_DIR . '/layouts/footer.php';
    }

    public function toggle() {
        requireLogin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? null;
            if ($productId) {
                $status = $this->wishlistModel->toggleItem(getCurrentUserId(), $productId);
                if ($status === 'added') {
                    setFlash('success', 'Product added to wishlist.');
                } else {
                    setFlash('success', 'Product removed from wishlist.');
                }
            }
        }
        $referer = $_SERVER['HTTP_REFERER'] ?? '/';
        redirect(str_replace(BASE_URL, '', $referer));
    }
}
