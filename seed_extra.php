<?php
// seed_extra.php - Add 20 more products
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/helpers/functions.php';

$db = getDB();

echo "Adding extra products...\n";

// Add more categories first
$db->exec("INSERT IGNORE INTO categories (id, name, slug, description) VALUES
(4, 'Sports & Outdoors', 'sports-outdoors', 'Fitness and outdoor gear'),
(5, 'Books & Stationery', 'books-stationery', 'Books, pens, and office supplies'),
(6, 'Toys & Games', 'toys-games', 'Fun for all ages')");

$products = [
    // Sports & Outdoors (Category 4)
    ['category_id' => 4, 'name' => 'Yoga Mat Premium Non-Slip', 'price' => 2499, 'sale_price' => 1899, 'stock' => 80, 'image' => 'https://images.unsplash.com/photo-1601925260368-ae2f83cf8b7f?w=400&q=80', 'description' => 'Premium non-slip yoga mat with extra thickness for joint protection. Perfect for yoga, pilates, and floor exercises.'],
    ['category_id' => 4, 'name' => 'Adjustable Dumbbell Set 20kg', 'price' => 8999, 'sale_price' => 6999, 'stock' => 25, 'image' => 'https://images.unsplash.com/photo-1586401100295-7a8096fd231a?w=400&q=80', 'description' => 'Adjustable dumbbell set with weight plates. Build your home gym with this versatile set.'],
    ['category_id' => 4, 'name' => 'Water Bottle Insulated 1L', 'price' => 1299, 'sale_price' => null, 'stock' => 150, 'image' => 'https://images.unsplash.com/photo-1602143407151-7111542de6e8?w=400&q=80', 'description' => 'Double-wall vacuum insulated water bottle keeps drinks cold for 24 hours and hot for 12 hours.'],
    ['category_id' => 4, 'name' => 'Resistance Bands Set of 5', 'price' => 1499, 'sale_price' => 999, 'stock' => 120, 'image' => 'https://images.unsplash.com/photo-1598289431512-b97b0917affc?w=400&q=80', 'description' => 'Set of 5 resistance bands with different tension levels. Perfect for home workouts and physical therapy.'],

    // Books & Stationery (Category 5)
    ['category_id' => 5, 'name' => 'Leather Journal Notebook A5', 'price' => 1999, 'sale_price' => 1499, 'stock' => 65, 'image' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=400&q=80', 'description' => 'Beautiful handcrafted leather journal with 200 pages of thick cream paper. Perfect for journaling and sketching.'],
    ['category_id' => 5, 'name' => 'Fountain Pen Premium Gold Nib', 'price' => 3499, 'sale_price' => null, 'stock' => 30, 'image' => 'https://images.unsplash.com/photo-1583485088034-697b5bc54ccd?w=400&q=80', 'description' => 'Elegant fountain pen with a gold-plated nib for smooth writing. Comes in a luxury gift box.'],
    ['category_id' => 5, 'name' => 'Desk Organizer Bamboo Wood', 'price' => 2299, 'sale_price' => 1799, 'stock' => 45, 'image' => 'https://images.unsplash.com/photo-1507925921958-8a62f3d1a50d?w=400&q=80', 'description' => 'Multi-compartment bamboo desk organizer for pens, phones, and stationery. Keep your workspace tidy.'],

    // Toys & Games (Category 6)
    ['category_id' => 6, 'name' => 'Rubik\'s Cube Speed Edition', 'price' => 799, 'sale_price' => 599, 'stock' => 200, 'image' => 'https://images.unsplash.com/photo-1591991564021-0662a8573199?w=400&q=80', 'description' => 'Competition-grade speed cube with smooth rotation. Perfect for beginners and speedcubers alike.'],
    ['category_id' => 6, 'name' => 'Building Blocks 1000 Pieces', 'price' => 3999, 'sale_price' => 2999, 'stock' => 40, 'image' => 'https://images.unsplash.com/photo-1587654780291-39c9404d7dd0?w=400&q=80', 'description' => 'Classic building blocks set with 1000 colorful pieces. Spark creativity and imagination in children.'],
    ['category_id' => 6, 'name' => 'Chess Set Wooden Folding Board', 'price' => 2499, 'sale_price' => null, 'stock' => 35, 'image' => 'https://images.unsplash.com/photo-1529699211952-734e80c4d42b?w=400&q=80', 'description' => 'Handcrafted wooden chess set with a folding board. Includes velvet-lined storage for pieces.'],

    // More Electronics (Category 1)
    ['category_id' => 1, 'name' => 'USB-C Fast Charging Cable 2m', 'price' => 699, 'sale_price' => 399, 'stock' => 300, 'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85f82e?w=400&q=80', 'description' => 'Braided nylon USB-C cable with fast charging support. Durable and tangle-free.'],
    ['category_id' => 1, 'name' => 'Portable Power Bank 20000mAh', 'price' => 4999, 'sale_price' => 3499, 'stock' => 70, 'image' => 'https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=400&q=80', 'description' => 'High-capacity power bank with dual USB ports and LED display. Charge your phone up to 5 times.'],
    ['category_id' => 1, 'name' => 'Webcam HD 1080p with Mic', 'price' => 3999, 'sale_price' => 2999, 'stock' => 50, 'image' => 'https://images.unsplash.com/photo-1587826080692-f439cd0b70da?w=400&q=80', 'description' => 'Full HD webcam with built-in microphone. Perfect for video calls, streaming, and online meetings.'],

    // More Fashion (Category 2)
    ['category_id' => 2, 'name' => 'Silk Scarf Floral Pattern', 'price' => 1999, 'sale_price' => 1499, 'stock' => 55, 'image' => 'https://images.unsplash.com/photo-1601924921557-45e389f3d79a?w=400&q=80', 'description' => 'Luxurious 100% silk scarf with a beautiful floral pattern. Versatile accessory for any outfit.'],
    ['category_id' => 2, 'name' => 'Sports Tracksuit Men Set', 'price' => 4999, 'sale_price' => 3499, 'stock' => 40, 'image' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=400&q=80', 'description' => 'Complete tracksuit set with jacket and pants. Breathable fabric perfect for sports and casual wear.'],
    ['category_id' => 2, 'name' => 'Canvas Backpack School Bag', 'price' => 2999, 'sale_price' => 2499, 'stock' => 75, 'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=400&q=80', 'description' => 'Durable canvas backpack with padded laptop compartment. Multiple pockets for organized storage.'],

    // More Home (Category 3)
    ['category_id' => 3, 'name' => 'Stainless Steel Kitchen Knife Set', 'price' => 5999, 'sale_price' => 4499, 'stock' => 20, 'image' => 'https://images.unsplash.com/photo-1593618998160-e34014e67546?w=400&q=80', 'description' => 'Professional 6-piece kitchen knife set with ergonomic handles and a wooden knife block.'],
    ['category_id' => 3, 'name' => 'Throw Pillow Covers Set of 4', 'price' => 1999, 'sale_price' => 1299, 'stock' => 90, 'image' => 'https://images.unsplash.com/photo-1584100936595-c0c0454b5969?w=400&q=80', 'description' => 'Set of 4 decorative throw pillow covers in complementary colors. Made from soft velvet fabric.'],
    ['category_id' => 3, 'name' => 'Digital Alarm Clock LED Display', 'price' => 1499, 'sale_price' => 999, 'stock' => 100, 'image' => 'https://images.unsplash.com/photo-1563861826100-9cb868fdbe1c?w=400&q=80', 'description' => 'Modern LED alarm clock with temperature display, adjustable brightness, and USB charging port.'],
    ['category_id' => 3, 'name' => 'Non-Stick Frying Pan 28cm', 'price' => 2499, 'sale_price' => null, 'stock' => 60, 'image' => 'https://images.unsplash.com/photo-1585837146751-a44118595680?w=400&q=80', 'description' => 'Premium non-stick frying pan with heat-resistant handle. Compatible with all stovetops including induction.'],
    // The newly processed Smart Fitness Tracker
    [
        'category_id' => 1, 
        'name' => 'Smart Fitness Tracker Watch with Heart Rate Monitor', 
        'price' => 4200, 
        'sale_price' => 2800, 
        'stock' => 100, 
        'image' => 'https://images.unsplash.com/photo-1575311373937-040b8e1fd5b0?w=400&q=80', 
        'description' => 'Advanced smart fitness tracker with continuous heart rate monitoring, sleep tracking, and waterproof design. Connects seamlessly with iOS and Android devices to keep track of your daily activities.',
        'gallery' => [
            'https://images.unsplash.com/photo-1617043786394-f977fa12eddf?w=400&q=80',
            'https://images.unsplash.com/photo-1579586337278-3befd40fd17a?w=400&q=80'
        ]
    ],
];

$db->beginTransaction();
$stmt = $db->prepare("INSERT IGNORE INTO products (seller_id, category_id, name, slug, description, price, sale_price, stock, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

$count = 0;
foreach ($products as $p) {
    $slug = generateSlug($p['name']) . '-' . substr(uniqid(), -4);
    $stmt->execute([
        1,
        $p['category_id'],
        $p['name'],
        $slug,
        $p['description'],
        $p['price'],
        $p['sale_price'],
        $p['stock'],
        $p['image']
    ]);
    
    if ($stmt->rowCount() > 0) {
        $count++;
        $productId = $db->lastInsertId();
        
        // Add main image to gallery as primary
        $imgStmt = $db->prepare("INSERT INTO product_images (product_id, image_path, is_primary) VALUES (?, ?, ?)");
        $imgStmt->execute([$productId, $p['image'], 1]);
        
        // Add additional gallery images
        if (isset($p['gallery']) && is_array($p['gallery'])) {
            foreach ($p['gallery'] as $galImg) {
                $imgStmt->execute([$productId, $galImg, 0]);
            }
        }
    }
}

$db->commit();
echo "Successfully added $count more products!\n";
echo "Total categories now: " . $db->query("SELECT COUNT(*) FROM categories")->fetchColumn() . "\n";
echo "Total products now: " . $db->query("SELECT COUNT(*) FROM products")->fetchColumn() . "\n";
?>
