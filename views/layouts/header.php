<?php
// views/layouts/header.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_NAME ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>
<script>
    // Theme toggle logic
    function toggleTheme() {
        document.body.classList.toggle('dark-mode');
        const isDark = document.body.classList.contains('dark-mode');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
    }

    // Apply theme immediately
    if (localStorage.getItem('theme') === 'dark') {
        document.body.classList.add('dark-mode');
    }
</script>

<div class="topbar">
    <div class="container">
        <div class="topbar-info">
            Welcome to <?= APP_NAME ?> - Premium Online Shopping
        </div>
        <div class="topbar-links">
            <a href="<?= BASE_URL ?>/track-order">Track Order</a>
            <a href="<?= BASE_URL ?>/help">Help Center</a>
            <?php if (getCurrentUserRole() === 'seller'): ?>
                <a href="<?= BASE_URL ?>/seller/dashboard">Seller Dashboard</a>
            <?php else: ?>
                <a href="<?= BASE_URL ?>/seller/register">Sell on <?= APP_NAME ?></a>
            <?php endif; ?>
        </div>
    </div>
</div>

<header class="main-header">
    <div class="container">
        <a href="<?= BASE_URL ?>/" class="logo">
            Selling<span>.</span>
        </a>

        <div class="search-bar">
            <form action="<?= BASE_URL ?>/products/search" method="GET" style="display: flex; width: 100%;">
                <input type="text" name="q" placeholder="Search for products, categories..." required>
                <button type="submit">Search</button>
            </form>
        </div>

        <div class="header-actions">
            <?php if (isLoggedIn()): ?>
                <a href="<?= BASE_URL ?>/profile" class="action-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Account
                </a>
                <?php if (getCurrentUserRole() === 'admin'): ?>
                    <a href="<?= BASE_URL ?>/admin/dashboard" class="action-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Admin
                    </a>
                <?php endif; ?>
                <a href="<?= BASE_URL ?>/logout" class="action-item" onclick="return confirm('Are you sure you want to logout?');">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </a>
            <?php else: ?>
                <a href="<?= BASE_URL ?>/login" class="action-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Login
                </a>
            <?php endif; ?>
            <button onclick="toggleTheme()" class="action-item" style="border: none; background: none; cursor: pointer;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                <span>Theme</span>
            </button>
            <a href="<?= BASE_URL ?>/cart" class="action-item">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Cart
                <?php
                // Count items in cart
                $cartCount = 0;
                if (isLoggedIn()) {
                    require_once MODELS_DIR . '/Cart.php';
                    $cartModel = new Cart();
                    $cartItems = $cartModel->getUserCart(getCurrentUserId());
                    foreach($cartItems as $item) {
                        $cartCount += $item['quantity'];
                    }
                }
                ?>
                <?php if ($cartCount > 0): ?>
                    <span class="cart-badge"><?= $cartCount ?></span>
                <?php endif; ?>
            </a>
        </div>
    </div>
</header>

<?php
// Dynamically load all categories for navigation
require_once MODELS_DIR . '/Category.php';
$navCategoryModel = new Category();
$navCategories = $navCategoryModel->getAll();
?>
<nav class="nav-categories">
    <div class="container">
        <ul>
            <li><a href="<?= BASE_URL ?>/">Home</a></li>
            <li><a href="<?= BASE_URL ?>/products">All Products</a></li>
            <?php foreach($navCategories as $navCat): ?>
                <li><a href="<?= BASE_URL ?>/category/<?= $navCat['slug'] ?>"><?= htmlspecialchars($navCat['name']) ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</nav>

<main class="container py-8">
    <?php if ($flash = getFlash('success')): ?>
        <div class="alert alert-success"><?= htmlspecialchars($flash) ?></div>
    <?php endif; ?>
    <?php if ($flash = getFlash('error')): ?>
        <div class="alert alert-error"><?= htmlspecialchars($flash) ?></div>
    <?php endif; ?>
