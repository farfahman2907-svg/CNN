<?php
session_start();
require_once 'db.php';

// Define a fallback image URL
$fallback_image = "https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=800";

// Fetch Categories in order for Navbar
$categories = $pdo->query("SELECT * FROM categories ORDER BY id ASC LIMIT 5")->fetchAll();

// Fetch Latest Articles for Grid with category name join
$latest_articles = $pdo->query("SELECT a.*, c.name as category_name FROM articles a JOIN categories c ON a.category_id = c.id ORDER BY created_at DESC LIMIT 6")->fetchAll();

// Featured Article (Latest 1)
$featured = $latest_articles[0] ?? null;

// Breaking News Ticker (latest 5)
$breaking_news = $pdo->query("SELECT * FROM articles ORDER BY created_at DESC LIMIT 5")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CNN CLONE | The Future of News</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

    <!-- Transparent Sticky Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container text-uppercase">
            <a class="navbar-brand glow-text fw-bold fs-3" href="index.php">CNN CLONE</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                    <?php foreach ($categories as $cat): ?>
                        <li class="nav-item"><a class="nav-link" href="category.php?id=<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></a></li>
                    <?php endforeach; ?>
                </ul>
                <div class="ms-lg-4">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="add_article.php" class="btn btn-outline-info btn-sm me-2">COMPOSE</a>
                        <a href="logout.php" class="btn btn-neon btn-sm">LOG OUT</a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-neon btn-sm me-2 text-dark fw-bold">LOG IN</a>
                        <a href="signup.php" class="btn btn-outline-secondary btn-sm">JOIN</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Breaking News Ticker -->
    <div class="ticker-wrap">
        <div class="container d-flex align-items-center">
            <span class="badge bg-danger me-4 rounded-0 py-2">BREAKING</span>
            <div class="overflow-hidden w-100 h-100">
                <div class="ticker-content">
                    <?php foreach ($breaking_news as $bn): ?>
                        <span class="mx-5"> <a href="article.php?id=<?php echo $bn['id']; ?>" class="text-white text-decoration-none">● <?php echo strtoupper($bn['title']); ?></a></span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Section -->
    <?php if ($featured): 
        $feat_img = getArticleImage($featured['title'], $featured['category_name']);
    ?>
    <section class="hero-section text-center py-5 d-flex align-items-center justify-content-center min-vh-75" style="background: radial-gradient(circle at center, rgba(15,15,25,0.8), #050505);">
        <div class="container">
            <div class="badge bg-danger mb-4 p-2 rounded-0 fs-6">FEATURED STORY</div>
            <h1 class="display-3 fw-bold mb-4 glow-text text-uppercase"><?php echo htmlspecialchars($featured['title']); ?></h1>
            <p class="lead text-muted col-lg-8 mx-auto mb-5 opacity-75"><?php echo htmlspecialchars($featured['description']); ?></p>
            <a href="article.php?id=<?php echo $featured['id']; ?>" class="btn btn-neon btn-lg shadow-lg px-5 py-3">READ THE FULL ARTICLE</a>
        </div>
    </section>
    <?php endif; ?>

    <!-- News Grid -->
    <main class="container my-5">
        <h2 class="mb-5 border-start border-info border-4 ps-4 glow-text text-uppercase">Latest Stories</h2>
        <div class="row g-4">
            <?php foreach ($latest_articles as $article): 
                $card_img = getArticleImage($article['title'], $article['category_name']);
            ?>
                <div class="col-md-6 col-lg-4">
                    <div class="neo-card h-100 fade-in">
                        <div class="overflow-hidden card-img-container">
                            <img src="<?php echo $card_img; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($article['title']); ?>" onerror="this.src='<?php echo $fallback_image; ?>'">
                        </div>
                        <div class="card-body d-flex flex-column">
                            <span class="category-badge mb-3 d-inline-block"><?php echo strtoupper($article['category_name']); ?></span>
                            <h4 class="card-title fw-bold text-white mb-3"><?php echo htmlspecialchars($article['title']); ?></h4>
                            <p class="card-text text-secondary mb-4 opacity-75"><?php echo htmlspecialchars(substr($article['description'], 0, 120)) . '...'; ?></p>
                            <div class="mt-auto">
                                <a href="article.php?id=<?php echo $article['id']; ?>" class="btn btn-sm btn-neon">READ STORY</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer class="py-5 border-top border-secondary mt-5">
        <div class="container text-center">
            <h4 class="glow-text mb-4">CNN CLONE</h4>
            <div class="mb-4">
                <a href="#" class="text-secondary mx-3 fs-4"><i class="bi bi-facebook"></i></a>
                <a href="#" class="text-secondary mx-3 fs-4"><i class="bi bi-twitter-x"></i></a>
                <a href="#" class="text-secondary mx-3 fs-4"><i class="bi bi-youtube"></i></a>
                <a href="#" class="text-secondary mx-3 fs-4"><i class="bi bi-instagram"></i></a>
            </div>
            <p class="text-muted small">&copy; 2026 CNN CLONE NETWORK. ALL RIGHTS RESERVED.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
