session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$error = '';
$success = '';
<?php

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $content = trim($_POST['content']);
    $image = trim($_POST['image']);
    $category_id = $_POST['category_id'];
    $author = $_SESSION['user_name'];

    if (empty($title) || empty($description) || empty($content) || empty($image) || empty($category_id)) {
        $error = "All fields are required.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO articles (title, description, content, image, category_id, author) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$title, $description, $content, $image, $category_id, $author])) {
            $success = "Article published successfully! <a href='index.php'>View Homepage</a>";
        } else {
            $error = "Database error. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post New Article - NEO NEWS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card bg-black border border-info shadow-lg p-4">
                    <h2 class="glow-text text-center mb-4">Post New Article</h2>
                    
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    
                    <?php if ($success): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Article Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Short Description</label>
                            <textarea name="description" class="form-control" rows="2" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Main Content</label>
                            <textarea name="content" class="form-control" rows="8" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Image URL</label>
                            <input type="text" name="image" class="form-control" placeholder="https://..." required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-control" required>
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="d-flex justify-content-between mt-4">
                            <a href="index.php" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" name="add" class="btn btn-neon">Publish Article</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
