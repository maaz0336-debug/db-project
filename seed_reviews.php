<?php
// seed_reviews.php - Generate random reviews for all products
require_once __DIR__ . '/config/database.php';

$db = getDB();

echo "Seeding customer reviews...\n";

// Get all users who are customers
$stmt = $db->query("SELECT id FROM users WHERE role = 'customer'");
$customerIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

if (empty($customerIds)) {
    echo "No customers found. Please register some customers first.\n";
    exit;
}

// Get all products
$stmt = $db->query("SELECT id, name FROM products");
$products = $stmt->fetchAll();

$comments = [
    5 => [
        "Amazing product! Exceeded my expectations.",
        "Very high quality, definitely worth the price.",
        "Exactly what I was looking for. Fast delivery too!",
        "Highly recommended. The build quality is superb.",
        "Excellent purchase. Will buy from this store again.",
        "Super fast shipping and great packaging.",
        "Best in the market! I'm very satisfied.",
        "Works perfectly. No issues at all."
    ],
    4 => [
        "Good product, works as described.",
        "Pretty good quality for the price.",
        "Satisfied with the purchase, but delivery took a bit longer.",
        "Good value for money.",
        "Does the job well. I'm happy with it.",
        "Nice design and feels durable.",
        "Very useful item, I use it daily.",
        "Great addition to my collection."
    ],
    3 => [
        "Average quality, not bad for the price.",
        "It's okay, but I expected a bit more.",
        "Decent product, but there are better options out there.",
        "Good enough for basic use.",
        "Functional, but feels a bit cheap.",
        "Average experience, nothing special.",
        "Product is fine, but packaging was a bit damaged.",
        "It works, but has some minor flaws."
    ]
];

$db->beginTransaction();

try {
    $stmt = $db->prepare("INSERT IGNORE INTO reviews (user_id, product_id, rating, comment) VALUES (?, ?, ?, ?)");
    $reviewCount = 0;

    foreach ($products as $product) {
        // Generate 3 to 6 reviews per product
        $numReviews = rand(3, 6);
        $usedUsers = [];
        
        for ($i = 0; $i < $numReviews; $i++) {
            $userId = $customerIds[array_rand($customerIds)];
            
            // Ensure one user doesn't review the same product multiple times
            if (in_array($userId, $usedUsers)) continue;
            $usedUsers[] = $userId;
            
            $rating = rand(3, 5); // Mostly positive reviews for seeding
            $commentList = $comments[$rating];
            $comment = $commentList[array_rand($commentList)];
            
            $stmt->execute([$userId, $product['id'], $rating, $comment]);
            if ($stmt->rowCount() > 0) {
                $reviewCount++;
            }
        }
    }

    $db->commit();
    echo "Successfully added $reviewCount reviews across " . count($products) . " products!\n";

} catch (Exception $e) {
    $db->rollBack();
    echo "Error seeding reviews: " . $e->getMessage() . "\n";
}
