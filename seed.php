<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/helpers/functions.php';

$db = getDB();

echo "Starting Database Seeding...\n";

// 1. Create a dummy seller
$db->exec("INSERT IGNORE INTO users (id, name, email, password_hash, role, is_active) VALUES 
(2, 'Official Store', 'store@selling.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'seller', 1)
ON DUPLICATE KEY UPDATE name='Official Store'");

$db->exec("INSERT IGNORE INTO sellers (id, user_id, store_name, store_description, is_approved) VALUES 
(1, 2, 'Selling Official', 'The official store for premium goods.', 1)
ON DUPLICATE KEY UPDATE store_name='Selling Official'");

// 2. Sample Products Data
$products = [
    // Electronics (Category 1)
    ['category_id' => 1, 'name' => 'Premium Wireless Headphones', 'price' => 199.99, 'sale_price' => 149.99, 'stock' => 50, 'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&q=80', 'description' => 'Experience crystal clear sound with our premium noise-canceling wireless headphones. Features 30-hour battery life and ultra-comfortable ear cushions.'],
    ['category_id' => 1, 'name' => '4K Ultra HD Smart TV - 55"', 'price' => 699.00, 'sale_price' => 599.00, 'stock' => 20, 'image' => 'https://images.unsplash.com/photo-1593359677879-a4bb92f829d1?w=500&q=80', 'description' => 'Immersive 4K visuals with smart capabilities. Stream your favorite shows with built-in apps and voice control.'],
    ['category_id' => 1, 'name' => 'Pro Gaming Laptop 15.6"', 'price' => 1299.00, 'sale_price' => null, 'stock' => 15, 'image' => 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=500&q=80', 'description' => 'High-performance gaming laptop with RTX 3060 graphics, 16GB RAM, and 512GB NVMe SSD. Play the latest games at ultra settings.'],
    ['category_id' => 1, 'name' => 'Smartphone Pro Max', 'price' => 999.00, 'sale_price' => null, 'stock' => 100, 'image' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=500&q=80', 'description' => 'The ultimate smartphone experience. Features a pro-grade camera system, all-day battery, and an ultra-fast processor.'],
    ['category_id' => 1, 'name' => 'Smart Watch Series 7', 'price' => 399.00, 'sale_price' => 349.00, 'stock' => 45, 'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&q=80', 'description' => 'Track your fitness, receive notifications, and monitor your health with the latest Smart Watch.'],
    ['category_id' => 1, 'name' => 'Wireless Bluetooth Speaker', 'price' => 89.99, 'sale_price' => 59.99, 'stock' => 200, 'image' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=500&q=80', 'description' => 'Portable bluetooth speaker with 360-degree sound, waterproof design, and 12-hour playtime.'],
    ['category_id' => 1, 'name' => 'Mechanical Gaming Keyboard', 'price' => 120.00, 'sale_price' => null, 'stock' => 30, 'image' => 'https://images.unsplash.com/photo-1595225476474-87563907a212?w=500&q=80', 'description' => 'RGB mechanical keyboard with tactile switches for fast and precise typing or gaming.'],
    ['category_id' => 1, 'name' => 'Wireless Gaming Mouse', 'price' => 75.00, 'sale_price' => 50.00, 'stock' => 60, 'image' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=500&q=80', 'description' => 'Ergonomic wireless mouse with ultra-low latency, custom RGB lighting, and adjustable DPI.'],
    ['category_id' => 1, 'name' => 'Digital Camera DSLR', 'price' => 550.00, 'sale_price' => 499.00, 'stock' => 12, 'image' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=500&q=80', 'description' => 'Capture stunning photos and 4K videos with this entry-level DSLR camera with an 18-55mm lens kit.'],
    ['category_id' => 1, 'name' => 'Noise Cancelling Earbuds', 'price' => 149.99, 'sale_price' => 129.99, 'stock' => 85, 'image' => 'https://images.unsplash.com/photo-1572569438065-809e07246419?w=500&q=80', 'description' => 'True wireless earbuds with active noise cancellation, transparency mode, and a compact charging case.'],

    // Fashion (Category 2)
    ['category_id' => 2, 'name' => 'Classic White Sneakers', 'price' => 89.99, 'sale_price' => null, 'stock' => 120, 'image' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=500&q=80', 'description' => 'Versatile and comfortable classic white sneakers that pair perfectly with any casual outfit.'],
    ['category_id' => 2, 'name' => 'Men\'s Leather Jacket', 'price' => 199.00, 'sale_price' => 149.00, 'stock' => 25, 'image' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=500&q=80', 'description' => 'Genuine leather biker jacket for men. Features durable zippers, multiple pockets, and a sleek fit.'],
    ['category_id' => 2, 'name' => 'Women\'s Summer Dress', 'price' => 45.00, 'sale_price' => 35.00, 'stock' => 80, 'image' => 'https://images.unsplash.com/photo-1572804013309-82a89b434447?w=500&q=80', 'description' => 'Light and breezy floral summer dress, perfect for beach trips and sunny days.'],
    ['category_id' => 2, 'name' => 'Designer Sunglasses', 'price' => 150.00, 'sale_price' => null, 'stock' => 40, 'image' => 'https://images.unsplash.com/photo-1511499767150-a48a237f0083?w=500&q=80', 'description' => 'Protect your eyes in style with these premium UV-blocking designer sunglasses.'],
    ['category_id' => 2, 'name' => 'Unisex Cotton Hoodie', 'price' => 55.00, 'sale_price' => null, 'stock' => 150, 'image' => 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=500&q=80', 'description' => 'Cozy and comfortable unisex hoodie made from 100% organic cotton. Available in multiple colors.'],
    ['category_id' => 2, 'name' => 'Running Shoes', 'price' => 110.00, 'sale_price' => 85.00, 'stock' => 65, 'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500&q=80', 'description' => 'High-performance running shoes with breathable mesh, superior cushioning, and durable outsole.'],
    ['category_id' => 2, 'name' => 'Leather Crossbody Bag', 'price' => 120.00, 'sale_price' => 99.00, 'stock' => 35, 'image' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=500&q=80', 'description' => 'Elegant crossbody bag crafted from genuine leather. Features an adjustable strap and secure closures.'],
    ['category_id' => 2, 'name' => 'Men\'s Denim Jeans', 'price' => 65.00, 'sale_price' => null, 'stock' => 90, 'image' => 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=500&q=80', 'description' => 'Classic straight-leg denim jeans. Durable, comfortable, and perfect for everyday wear.'],
    ['category_id' => 2, 'name' => 'Casual Wrist Watch', 'price' => 180.00, 'sale_price' => 150.00, 'stock' => 20, 'image' => 'https://images.unsplash.com/photo-1524592094714-0f0654e20314?w=500&q=80', 'description' => 'Minimalist analog wrist watch with a genuine leather strap and water-resistant casing.'],
    ['category_id' => 2, 'name' => 'Winter Knit Beanie', 'price' => 25.00, 'sale_price' => 15.00, 'stock' => 200, 'image' => 'https://images.unsplash.com/photo-1576871337632-b9aef4c17ab9?w=500&q=80', 'description' => 'Keep warm during the winter with this soft, stretchable, and stylish knit beanie.'],

    // Home & Lifestyle (Category 3)
    ['category_id' => 3, 'name' => 'Modern Armchair', 'price' => 299.00, 'sale_price' => 249.00, 'stock' => 10, 'image' => 'https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?w=500&q=80', 'description' => 'Add a touch of modern elegance to your living room with this comfortable fabric armchair.'],
    ['category_id' => 3, 'name' => 'Ceramic Coffee Mug', 'price' => 15.00, 'sale_price' => null, 'stock' => 300, 'image' => 'https://images.unsplash.com/photo-1514228742587-6b1558fcca3d?w=500&q=80', 'description' => 'Handcrafted ceramic coffee mug. Microwave and dishwasher safe, perfect for your morning brew.'],
    ['category_id' => 3, 'name' => 'Indoor Potted Plant', 'price' => 35.00, 'sale_price' => null, 'stock' => 45, 'image' => 'https://images.unsplash.com/photo-1485955900006-10f4d324d411?w=500&q=80', 'description' => 'Bring life to your home with this beautiful, easy-to-care-for indoor potted plant.'],
    ['category_id' => 3, 'name' => 'Scented Soy Candle', 'price' => 20.00, 'sale_price' => 16.00, 'stock' => 150, 'image' => 'https://images.unsplash.com/photo-1603006905003-be475563bc59?w=500&q=80', 'description' => 'Relax with our lavender-scented soy wax candle. Offers a clean burn with up to 40 hours of fragrance.'],
    ['category_id' => 3, 'name' => 'Minimalist Table Lamp', 'price' => 65.00, 'sale_price' => null, 'stock' => 35, 'image' => 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?w=500&q=80', 'description' => 'Sleek and minimalist table lamp. Provides warm, ambient lighting perfect for reading or working.'],
    ['category_id' => 3, 'name' => 'Cotton Bed Sheets Set', 'price' => 85.00, 'sale_price' => 65.00, 'stock' => 50, 'image' => 'https://images.unsplash.com/photo-1522771731470-3138dd8b896f?w=500&q=80', 'description' => 'Experience ultimate comfort with this 100% Egyptian cotton bed sheets set. Includes 1 flat sheet, 1 fitted sheet, and 2 pillowcases.'],
    ['category_id' => 3, 'name' => 'Woven Storage Basket', 'price' => 28.00, 'sale_price' => null, 'stock' => 80, 'image' => 'https://images.unsplash.com/photo-1590725140246-2009ab0f6208?w=500&q=80', 'description' => 'Organize your home with this beautiful hand-woven storage basket, ideal for blankets, toys, or laundry.'],
    ['category_id' => 3, 'name' => 'Wall Art Canvas', 'price' => 45.00, 'sale_price' => 35.00, 'stock' => 60, 'image' => 'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?w=500&q=80', 'description' => 'Abstract wall art printed on high-quality canvas. Adds a modern touch to any bedroom or living space.'],
    ['category_id' => 3, 'name' => 'Essential Oil Diffuser', 'price' => 40.00, 'sale_price' => null, 'stock' => 100, 'image' => 'https://images.unsplash.com/photo-1608528577891-eb055944f2e7?w=500&q=80', 'description' => 'Ultrasonic essential oil diffuser and humidifier. Features LED lights and auto-shutoff safety function.'],
    ['category_id' => 3, 'name' => 'Wooden Cutting Board', 'price' => 30.00, 'sale_price' => null, 'stock' => 70, 'image' => 'https://images.unsplash.com/photo-1581452654316-25f056dd3d4f?w=500&q=80', 'description' => 'Durable and aesthetic solid wood cutting board, perfect for food preparation and serving cheese.'],
];

$db->beginTransaction();
$stmt = $db->prepare("INSERT IGNORE INTO products (seller_id, category_id, name, slug, description, price, sale_price, stock, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

$count = 0;
foreach ($products as $p) {
    $slug = generateSlug($p['name']);
    $stmt->execute([
        1, // seller_id = 1 (Official Store)
        $p['category_id'],
        $p['name'],
        $slug,
        $p['description'],
        $p['price'],
        $p['sale_price'],
        $p['stock'],
        $p['image']
    ]);
    $count += $stmt->rowCount();
}

$db->commit();
echo "Successfully seeded $count new products!\n";
?>
