<?php
// controllers/CartController.php
require_once __DIR__ . '/../models/Cart.php';

class CartController {
    private $cartModel;

    public function __construct() {
        $this->cartModel = new Cart();
    }

    public function index() {
        requireLogin();
        $userId = getCurrentUserId();
        $cartItems = $this->cartModel->getUserCart($userId);
        
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $price = $item['sale_price'] ? $item['sale_price'] : $item['price'];
            $subtotal += $price * $item['quantity'];
        }
        
        require_once VIEWS_DIR . '/layouts/header.php';
        require_once VIEWS_DIR . '/cart/index.php';
        require_once VIEWS_DIR . '/layouts/footer.php';
    }

    public function add() {
        requireLogin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? null;
            $quantity = $_POST['quantity'] ?? 1;
            
            if ($productId) {
                $this->cartModel->addItem(getCurrentUserId(), $productId, $quantity);
                setFlash('success', 'Item added to cart successfully.');
            }
        }
        
        // Redirect back
        $referer = $_SERVER['HTTP_REFERER'] ?? '/';
        redirect(str_replace(BASE_URL, '', $referer));
    }

    public function update() {
        requireLogin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cartItemId = $_POST['cart_item_id'] ?? null;
            $quantity = $_POST['quantity'] ?? 1;
            
            if ($cartItemId) {
                $this->cartModel->updateQuantity($cartItemId, getCurrentUserId(), $quantity);
                setFlash('success', 'Cart updated successfully.');
            }
        }
        redirect('/cart');
    }

    public function remove() {
        requireLogin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cartItemId = $_POST['cart_item_id'] ?? null;
            
            if ($cartItemId) {
                $this->cartModel->removeItem($cartItemId, getCurrentUserId());
                setFlash('success', 'Item removed from cart.');
            }
        }
        redirect('/cart');
    }
}
