<?php
// controllers/OrderController.php
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Cart.php';

class OrderController {
    private $orderModel;
    private $cartModel;

    public function __construct() {
        $this->orderModel = new Order();
        $this->cartModel = new Cart();
    }

    public function checkout() {
        requireLogin();
        $userId = getCurrentUserId();
        $cartItems = $this->cartModel->getUserCart($userId);
        
        if (empty($cartItems)) {
            setFlash('error', 'Your cart is empty.');
            redirect('/cart');
        }

        $subtotal = 0;
        foreach ($cartItems as $item) {
            $price = $item['sale_price'] ? $item['sale_price'] : $item['price'];
            $subtotal += $price * $item['quantity'];
        }
        $shipping = 150.00; // Fixed shipping for now
        $total = $subtotal + $shipping;

        require_once VIEWS_DIR . '/layouts/header.php';
        require_once VIEWS_DIR . '/checkout/index.php';
        require_once VIEWS_DIR . '/layouts/footer.php';
    }

    public function placeOrder() {
        requireLogin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/checkout');
        }

        $userId = getCurrentUserId();
        $cartItems = $this->cartModel->getUserCart($userId);
        
        if (empty($cartItems)) {
            setFlash('error', 'Your cart is empty.');
            redirect('/cart');
        }

        $address = sanitize($_POST['address'] ?? '');
        $city = sanitize($_POST['city'] ?? '');
        $zip = sanitize($_POST['zip'] ?? '');
        $paymentMethod = sanitize($_POST['payment_method'] ?? 'cod');

        if (empty($address) || empty($city) || empty($zip)) {
            setFlash('error', 'Please fill in all shipping details.');
            redirect('/checkout');
        }

        $fullAddress = $address . ', ' . $city . ' ' . $zip;

        $subtotal = 0;
        foreach ($cartItems as $item) {
            $price = $item['sale_price'] ? $item['sale_price'] : $item['price'];
            $subtotal += $price * $item['quantity'];
        }
        $totalAmount = $subtotal + 150.00; // adding Rs. 150 shipping

        $orderId = $this->orderModel->createOrder($userId, $totalAmount, $fullAddress, $cartItems, $paymentMethod);

        if ($orderId) {
            setFlash('success', 'Order placed successfully!');
            redirect('/orders/' . $orderId);
        } else {
            setFlash('error', 'Failed to place order. Please try again.');
            redirect('/checkout');
        }
    }

    public function myOrders() {
        requireLogin();
        $orders = $this->orderModel->getUserOrders(getCurrentUserId());
        
        require_once VIEWS_DIR . '/layouts/header.php';
        require_once VIEWS_DIR . '/orders/index.php';
        require_once VIEWS_DIR . '/layouts/footer.php';
    }

    public function detail($id) {
        requireLogin();
        $order = $this->orderModel->getOrderDetails($id, getCurrentUserId());
        
        if (!$order) {
            setFlash('error', 'Order not found.');
            redirect('/orders');
        }

        require_once VIEWS_DIR . '/layouts/header.php';
        require_once VIEWS_DIR . '/orders/detail.php';
        require_once VIEWS_DIR . '/layouts/footer.php';
    }

    public function trackOrder() {
        require_once VIEWS_DIR . '/layouts/header.php';
        require_once VIEWS_DIR . '/orders/track.php';
        require_once VIEWS_DIR . '/layouts/footer.php';
    }

    public function trackOrderPost() {
        $orderNumber = sanitize($_POST['order_number'] ?? '');
        
        if (empty($orderNumber)) {
            setFlash('error', 'Please enter an order number.');
            redirect('/track-order');
        }

        $order = $this->orderModel->getOrderByNumber($orderNumber);
        
        require_once VIEWS_DIR . '/layouts/header.php';
        require_once VIEWS_DIR . '/orders/track.php';
        require_once VIEWS_DIR . '/layouts/footer.php';
    }
}
