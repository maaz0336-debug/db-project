<?php
// helpers/functions.php

session_start();

function redirect($url) {
    header("Location: " . BASE_URL . $url);
    exit;
}

function setFlash($key, $message) {
    $_SESSION['flash'][$key] = $message;
}

function getFlash($key) {
    if (isset($_SESSION['flash'][$key])) {
        $msg = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $msg;
    }
    return null;
}

function sanitize($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

function formatPrice($price) {
    return 'Rs. ' . number_format((float)$price, 2);
}

function getImageUrl($path, $fallback = 'https://via.placeholder.com/300x300.png?text=No+Image') {
    if (empty($path)) {
        return $fallback;
    }
    if (strpos($path, 'http://') === 0 || strpos($path, 'https://') === 0) {
        return $path;
    }
    // Remove leading slash if present so we don't double up with BASE_URL
    $path = ltrim($path, '/');
    return BASE_URL . '/' . $path;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getCurrentUserId() {
    return $_SESSION['user_id'] ?? null;
}

function getCurrentUserRole() {
    return $_SESSION['user_role'] ?? null;
}

function generateSlug($string) {
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
    return $slug;
}
