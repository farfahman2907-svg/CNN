<?php
session_start();
require_once 'db.php';

// Define a fallback image URL
$fallback_image = "https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=800";

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$cat_id = (int)$_GET['id'];

// Fetch Categories in order for Navbar
$categories = $pdo->query("SELECT * FROM categories ORDER BY id ASC LIMIT 5")->fetchAll();

// Fetch Current Category Name
$stmt = $pdo->prepare("SELECT name FROM categories WHERE id = ?");
$stmt->execute([$cat_id]);
$current_category = $stmt->fetch();

if (!$current_category) {
    header("Location: index.php");
    exit;
}

// Fetch Articles by Category with category name join
$stmt = $pdo->prepare("SELECT a.*, c.name as category_name FROM articles a JOIN categories c ON a.category_id = c.id WHERE a.category_id = ? ORDER BY a.created_at DESC");
$stmt->execute([$cat_id]);
$articles = $stmt->fetchAll();

// Optional: Fallback articles if none exist (for demonstration)
if (empty($articles)) {
    // This part ensures that if a category is empty, we show some generic sample articles
    $articles = [
        [
            'id' => 0,
            'title' => 'Breaking News coming soon to ' . $current_category['name'],
            'description' => 'Stay tuned for the latest updates in ' . $current_category['name'] . '.',
            'image' => $fallback_image,
            'category_name' => $current_category['name'],
            'author' => 'System'
        ],
        [
            'id' => 0,
            'title' => 'In-depth analysis of ' . $current_category['name'] . ' trends',
            'description' => 'Our editorial team is preparing comprehensive coverage of all major ' . $current_category['name'] . ' events.',
            'image' => $fallback_image,
            'category_name' => $current_category['name'],
            'author' => 'System'
        ],
        [
            'id' => 0,
            'title' => 'The Global Impact of ' . $current_category['name'],
            'description' => 'Discover how ' . $current_category['name'] . ' is shaping the future of global industries.',
            'image' => $fallback_image,
            'category_name' => $current_category['name'],
            'author' => 'System'
        ]
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $current_category['name']; ?> | CNN CLONE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand glow-text fw-bold" href="index.php">CNN CLONE</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <?php foreach ($categories as $cat): ?>
                        <li class="nav-item"><a class="nav-link <?php echo ($cat['id'] == $cat_id) ? 'active' : ''; ?>" href="category.php?id=<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5 min-vh-100">
        <h1 class="glow-text mb-5 text-uppercase fw-bold"><?php echo $current_category['name']; ?> News</h1>
        <hr class="border-secondary mb-5">

        <div class="row g-4">
            <?php foreach ($articles as $article): 
                // Fix: Fallback for broken or missing images
                $image_url = getArticleImage($article['title'], $article['category_name'] ?? $current_category['name']);
            ?>
                <div class="col-md-6 col-lg-4">
                    <div class="neo-card h-100 fade-in">
                        <div class="overflow-hidden">
                            <img src="<?php echo $image_url; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($article['title']); ?>" onerror="this.src='<?php echo $fallback_image; ?>'">
                        </div>
                        <div class="card-body d-flex flex-column">
                            <span class="category-badge mb-3 d-inline-block"><?php echo $article['category_name'] ?? $current_category['name']; ?></span>
                            <h4 class="card-title fw-bold text-white mb-3"><?php echo htmlspecialchars($article['title']); ?></h4>
                            <p class="card-text text-secondary mb-4 opacity-75">
                                <?php echo htmlspecialchars(substr($article['description'], 0, 150)) . '...'; ?>
                            </p>
                            <div class="mt-auto">
                                <a href="article.php?id=<?php echo $article['id']; ?>" class="btn btn-sm btn-neon">READ MORE</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <footer class="py-5 border-top border-secondary mt-5">
        <div class="container text-center">
            <h4 class="glow-text mb-4">CNN CLONE</h4>
            <p class="text-muted small">&copy; 2026 CNN CLONE NETWORK. ALL RIGHTS RESERVED.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
