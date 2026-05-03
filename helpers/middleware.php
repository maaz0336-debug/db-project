<?php
// helpers/middleware.php

function requireLogin() {
    if (!isLoggedIn()) {
        setFlash('error', 'You must be logged in to access that page.');
        redirect('/login');
    }
}

function requireRole($role) {
    requireLogin();
    if (getCurrentUserRole() !== $role) {
        setFlash('error', 'You do not have permission to access that page.');
        redirect('/');
    }
}

function redirectIfLoggedIn() {
    if (isLoggedIn()) {
        redirect('/');
    }
}
