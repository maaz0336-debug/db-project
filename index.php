<?php
// index.php
require_once 'config/constants.php';
require_once 'config/database.php';
require_once 'helpers/functions.php';
require_once 'helpers/middleware.php';

// Simple Router logic
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// When running with php -S localhost:8000, base path might just be /
$basePath = '/'; 

$route = str_replace($basePath, '/', $requestUri);
$route = rtrim($route, '/');
if (empty($route)) {
    $route = '/';
}

// Map routes to controllers
// Check for dynamic routes first
if (preg_match('#^/category/([^/]+)$#', $route, $matches)) {
    require_once 'controllers/ProductController.php';
    $controller = new ProductController();
    $controller->category($matches[1]);
    exit;
}
if (preg_match('#^/product/([0-9]+)$#', $route, $matches)) {
    require_once 'controllers/ProductController.php';
    $controller = new ProductController();
    $controller->detail($matches[1]);
    exit;
}
if (preg_match('#^/orders/([0-9]+)$#', $route, $matches)) {
    require_once 'controllers/OrderController.php';
    $controller = new OrderController();
    $controller->detail($matches[1]);
    exit;
}

switch ($route) {
    // Product Routes
    case '/':
        require_once 'controllers/ProductController.php';
        $controller = new ProductController();
        $controller->home();
        break;
    case '/products':
        require_once 'controllers/ProductController.php';
        $controller = new ProductController();
        $controller->index();
        break;
    case '/products/search':
        require_once 'controllers/ProductController.php';
        $controller = new ProductController();
        $controller->search();
        break;
    case '/review/submit':
        require_once 'controllers/ProductController.php';
        $controller = new ProductController();
        $controller->submitReview();
        break;
        
    // Auth Routes
    case '/login':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->loginPost();
        } else {
            $controller->login();
        }
        break;
    case '/register':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->registerPost();
        } else {
            $controller->register();
        }
        break;
    case '/logout':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController();
        $controller->logout();
        break;

    // Cart Routes
    case '/cart':
        require_once 'controllers/CartController.php';
        $controller = new CartController();
        $controller->index();
        break;
    case '/cart/add':
        require_once 'controllers/CartController.php';
        $controller = new CartController();
        $controller->add();
        break;
    case '/cart/update':
        require_once 'controllers/CartController.php';
        $controller = new CartController();
        $controller->update();
        break;
    case '/cart/remove':
        require_once 'controllers/CartController.php';
        $controller = new CartController();
        $controller->remove();
        break;

    // Checkout Routes
    case '/checkout':
        require_once 'controllers/OrderController.php';
        $controller = new OrderController();
        $controller->checkout();
        break;
    case '/checkout/place-order':
        require_once 'controllers/OrderController.php';
        $controller = new OrderController();
        $controller->placeOrder();
        break;

    // Order Routes
    case '/orders':
        require_once 'controllers/OrderController.php';
        $controller = new OrderController();
        $controller->myOrders();
        break;

    // Review Routes
    case '/review/submit':
        require_once 'controllers/ReviewController.php';
        $controller = new ReviewController();
        $controller->submit();
        break;

    // Seller Routes
    case '/seller/dashboard':
        require_once 'controllers/SellerController.php';
        $controller = new SellerController();
        $controller->dashboard();
        break;
    case '/seller/products':
        require_once 'controllers/SellerController.php';
        $controller = new SellerController();
        $controller->products();
        break;
    case '/seller/products/add':
        require_once 'controllers/SellerController.php';
        $controller = new SellerController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->addProductPost();
        } else {
            $controller->addProduct();
        }
        break;
    case '/seller/orders':
        require_once 'controllers/SellerController.php';
        $controller = new SellerController();
        $controller->orders();
        break;

    // Track Order
    case '/track-order':
        require_once 'controllers/OrderController.php';
        $controller = new OrderController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->trackOrderPost();
        } else {
            $controller->trackOrder();
        }
        break;

    // Help Center
    case '/help':
        require_once VIEWS_DIR . '/layouts/header.php';
        require_once VIEWS_DIR . '/pages/help.php';
        require_once VIEWS_DIR . '/layouts/footer.php';
        break;

    // Static Pages
    case '/about':
        require_once VIEWS_DIR . '/layouts/header.php';
        require_once VIEWS_DIR . '/pages/about.php';
        require_once VIEWS_DIR . '/layouts/footer.php';
        break;
    case '/careers':
        require_once VIEWS_DIR . '/layouts/header.php';
        require_once VIEWS_DIR . '/pages/careers.php';
        require_once VIEWS_DIR . '/layouts/footer.php';
        break;
    case '/privacy':
        require_once VIEWS_DIR . '/layouts/header.php';
        require_once VIEWS_DIR . '/pages/privacy.php';
        require_once VIEWS_DIR . '/layouts/footer.php';
        break;

    // Seller Registration
    case '/seller/register':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->sellerRegisterPost();
        } else {
            $controller->sellerRegister();
        }
        break;

    // Admin Routes
    case '/admin/dashboard':
        require_once 'controllers/AdminController.php';
        $controller = new AdminController();
        $controller->dashboard();
        break;
    case '/admin/approve-seller':
        require_once 'controllers/AdminController.php';
        $controller = new AdminController();
        $controller->approveSeller();
        break;

    // Wishlist Routes
    case '/wishlist':
        require_once 'controllers/WishlistController.php';
        $controller = new WishlistController();
        $controller->index();
        break;
    case '/wishlist/toggle':
        require_once 'controllers/WishlistController.php';
        $controller = new WishlistController();
        $controller->toggle();
        break;

    // Example 404
    default:
        http_response_code(404);
        require_once VIEWS_DIR . '/layouts/header.php';
        echo "<div class='text-center py-8'><h2>404 Page Not Found</h2><p>The page you are looking for does not exist.</p></div>";
        require_once VIEWS_DIR . '/layouts/footer.php';
        break;
}
