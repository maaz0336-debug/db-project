<?php
// controllers/AuthController.php
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function login() {
        redirectIfLoggedIn();
        require_once VIEWS_DIR . '/layouts/header.php';
        require_once VIEWS_DIR . '/auth/login.php';
        require_once VIEWS_DIR . '/layouts/footer.php';
    }

    public function loginPost() {
        redirectIfLoggedIn();
        $email = sanitize($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            setFlash('error', 'Please fill in all fields.');
            redirect('/login');
        }

        $user = $this->userModel->verifyPassword($email, $password);

        if ($user) {
            if (!$user['is_active']) {
                setFlash('error', 'Your account has been deactivated.');
                redirect('/login');
            }
            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            
            setFlash('success', 'Welcome back, ' . $user['name'] . '!');
            if ($user['role'] === 'admin') {
                redirect('/admin/dashboard');
            } else if ($user['role'] === 'seller') {
                redirect('/seller/dashboard');
            } else {
                redirect('/');
            }
        } else {
            setFlash('error', 'Invalid email or password.');
            redirect('/login');
        }
    }

    public function register() {
        redirectIfLoggedIn();
        require_once VIEWS_DIR . '/layouts/header.php';
        require_once VIEWS_DIR . '/auth/register.php';
        require_once VIEWS_DIR . '/layouts/footer.php';
    }

    public function registerPost() {
        redirectIfLoggedIn();
        $name = sanitize($_POST['name'] ?? '');
        $email = sanitize($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
            setFlash('error', 'Please fill in all fields.');
            redirect('/register');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            setFlash('error', 'Invalid email format.');
            redirect('/register');
        }

        if ($password !== $confirm_password) {
            setFlash('error', 'Passwords do not match.');
            redirect('/register');
        }

        if (strlen($password) < 6) {
            setFlash('error', 'Password must be at least 6 characters.');
            redirect('/register');
        }

        if ($this->userModel->findByEmail($email)) {
            setFlash('error', 'Email is already registered.');
            redirect('/register');
        }

        if ($this->userModel->create(['name' => $name, 'email' => $email, 'password' => $password, 'role' => 'customer'])) {
            setFlash('success', 'Registration successful! Please login.');
            redirect('/login');
        } else {
            setFlash('error', 'Something went wrong. Please try again.');
            redirect('/register');
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        session_start();
        setFlash('success', 'You have been successfully logged out.');
        redirect('/');
    }

    public function sellerRegister() {
        require_once VIEWS_DIR . '/layouts/header.php';
        require_once VIEWS_DIR . '/auth/seller_register.php';
        require_once VIEWS_DIR . '/layouts/footer.php';
    }

    public function sellerRegisterPost() {
        $db = getDB();
        
        $storeName = sanitize($_POST['store_name'] ?? '');
        $storeDescription = sanitize($_POST['store_description'] ?? '');

        if (empty($storeName)) {
            setFlash('error', 'Store Name is required.');
            redirect('/seller/register');
        }

        if (isLoggedIn()) {
            // User is already logged in, upgrade their account
            $userId = getCurrentUserId();
            
            // Check if they are already a seller
            if (getCurrentUserRole() === 'seller') {
                setFlash('error', 'You are already registered as a seller.');
                redirect('/seller/dashboard');
            }

            try {
                $db->beginTransaction();
                
                // Insert into sellers
                $stmt = $db->prepare("INSERT INTO sellers (user_id, store_name, store_description) VALUES (?, ?, ?)");
                $stmt->execute([$userId, $storeName, $storeDescription]);
                
                // Update user role to seller
                $stmt = $db->prepare("UPDATE users SET role = 'seller' WHERE id = ?");
                $stmt->execute([$userId]);
                
                $db->commit();
                
                // Update session
                $_SESSION['user_role'] = 'seller';
                
                setFlash('success', 'Your seller account has been created and is pending approval by an admin.');
                redirect('/seller/dashboard');
                
            } catch (Exception $e) {
                $db->rollBack();
                setFlash('error', 'Failed to register seller account.');
                redirect('/seller/register');
            }

        } else {
            // User is not logged in
            $name = sanitize($_POST['name'] ?? '');
            $email = sanitize($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
                setFlash('error', 'Please fill in all user details.');
                redirect('/seller/register');
            }

            if ($password !== $confirm_password) {
                setFlash('error', 'Passwords do not match.');
                redirect('/seller/register');
            }

            if ($this->userModel->findByEmail($email)) {
                setFlash('error', 'Email is already registered. Please login first to upgrade your account to a seller.');
                redirect('/seller/register');
            }

            try {
                $db->beginTransaction();
                
                // 1. Create User
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $db->prepare("INSERT INTO users (name, email, password_hash, role) VALUES (?, ?, ?, 'seller')");
                $stmt->execute([$name, $email, $passwordHash]);
                $userId = $db->lastInsertId();

                // 2. Create Seller
                $stmt = $db->prepare("INSERT INTO sellers (user_id, store_name, store_description) VALUES (?, ?, ?)");
                $stmt->execute([$userId, $storeName, $storeDescription]);
                
                $db->commit();
                
                setFlash('success', 'Seller account created successfully! Please login.');
                redirect('/login');
                
            } catch (Exception $e) {
                $db->rollBack();
                setFlash('error', 'Failed to register seller account.');
                redirect('/seller/register');
            }
        }
    }
}
