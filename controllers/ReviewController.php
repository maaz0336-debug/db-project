<?php
// controllers/ReviewController.php
require_once __DIR__ . '/../models/Review.php';

class ReviewController {
    private $reviewModel;

    public function __construct() {
        $this->reviewModel = new Review();
    }

    public function submit() {
        requireLogin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/');
        }

        $productId = $_POST['product_id'] ?? null;
        $rating = $_POST['rating'] ?? 5;
        $comment = sanitize($_POST['comment'] ?? '');
        $userId = getCurrentUserId();

        if (!$productId || !$rating) {
            setFlash('error', 'Invalid review data.');
            redirect('back'); // Or back to product
        }

        if ($this->reviewModel->addReview($userId, $productId, $rating, $comment)) {
            setFlash('success', 'Your review has been submitted.');
        } else {
            setFlash('error', 'You have already reviewed this product.');
        }

        redirect('/product/' . $productId);
    }
}
