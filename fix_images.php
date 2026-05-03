<?php
require_once __DIR__ . '/config/database.php';

$db = getDB();

// High-quality fallback images based on category
$categoryImages = [
    1 => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?w=400&q=80', // Electronics
    2 => 'https://images.unsplash.com/photo-1445205170230-053b83016050?w=400&q=80', // Fashion
    3 => 'https://images.unsplash.com/photo-1513694203232-719a280e022f?w=400&q=80', // Home
    4 => 'https://images.unsplash.com/photo-1517649763962-0c623066013b?w=400&q=80', // Sports
    5 => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=400&q=80', // Books
    6 => 'https://images.unsplash.com/photo-1558060370-d644479cb6f7?w=400&q=80'  // Toys
];

echo "Checking all products for broken images... This may take a few seconds.\n";

// Fetch all products
$stmt = $db->query("SELECT id, name, category_id, image FROM products");
$products = $stmt->fetchAll();

$fixedCount = 0;

foreach ($products as $product) {
    $url = $product['image'];
    $isBroken = false;
    
    // Check if it's a known bad local path or empty
    if (empty($url) || strpos($url, '/assets') === 0 || strpos($url, '/uploads') === 0) {
        $isBroken = true;
    } else {
        // Actively ping the external URL to see if Unsplash has removed it (404)
        $headers = @get_headers($url);
        if (!$headers || strpos($headers[0], '404') !== false || strpos($headers[0], '403') !== false) {
            $isBroken = true;
            echo "Broken link detected for: {$product['name']}\n";
        }
    }
    
    if ($isBroken) {
        $newImage = $categoryImages[$product['category_id']] ?? 'https://via.placeholder.com/400?text=Product';
        
        $updateStmt = $db->prepare("UPDATE products SET image = ? WHERE id = ?");
        $updateStmt->execute([$newImage, $product['id']]);
        $fixedCount++;
    }
}

echo "========================================\n";
echo "Successfully fixed $fixedCount broken product images!\n";
?>
