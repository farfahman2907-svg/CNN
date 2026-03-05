<?php
require_once 'db.php';

echo "<h2>Fixing News Data...</h2>";

try {
    // 1. Ensure Categories Exist with specific IDs
    $categories = [
        ['id' => 1, 'name' => 'Entertainment'],
        ['id' => 2, 'name' => 'Politics'],
        ['id' => 3, 'name' => 'Sports'],
        ['id' => 4, 'name' => 'Technology'],
        ['id' => 5, 'name' => 'World'],
        ['id' => 6, 'name' => 'Business'],
        ['id' => 7, 'name' => 'Health']
    ];

    foreach ($categories as $cat) {
        $stmt = $pdo->prepare("INSERT IGNORE INTO categories (id, name) VALUES (?, ?)");
        $stmt->execute([$cat['id'], $cat['name']]);
        echo "Category '{$cat['name']}' checked.<br>";
    }

    // 2. Add Politics Articles specifically
    $politics_articles = [
        [
            'title' => 'Global Election Results',
            'desc' => 'Major shift in legislative control as billions head to the polls.',
            'content' => 'Full report on the recent global elections...',
            'img' => 'https://images.unsplash.com/photo-1540910419892-4a36d2c3266c?auto=format&fit=crop&w=800&q=80',
            'cid' => 2
        ],
        [
            'title' => 'New Policy Reform Announced',
            'desc' => 'Government introduces new measures to tackle inflation.',
            'content' => 'Details about the economic reforms...',
            'img' => 'https://images.unsplash.com/photo-1521791136064-7986c2959213?auto=format&fit=crop&w=800&q=80',
            'cid' => 2
        ],
        [
            'title' => 'Diplomatic Summit in Geneva',
            'desc' => 'World leaders gather to discuss peace treaties.',
            'content' => 'Analysis of the Geneva summit talks...',
            'img' => 'https://images.unsplash.com/photo-1529107386315-e1a2ed48a620?auto=format&fit=crop&w=800&q=80',
            'cid' => 2
        ]
    ];

    foreach ($politics_articles as $art) {
        $stmt = $pdo->prepare("INSERT INTO articles (title, description, content, image, category_id, author) VALUES (?, ?, ?, ?, ?, 'Admin')");
        $stmt->execute([$art['title'], $art['desc'], $art['content'], $art['img'], $art['cid']]);
        echo "Article '{$art['title']}' for Politics added.<br>";
    }

    echo "<h3>Success! Data has been forced into the database.</h3>";
    echo "<a href='index.php'>Go to Homepage</a>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
