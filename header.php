 <?php require_once "db.php"; ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>NEON CNN</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<header class="header">
    <div class="logo">NEON<span>CNN</span></div>

    <nav>
        <a href="index.php">Home</a>
        <a href="category.php?cat=Politics">Politics</a>
        <a href="category.php?cat=Sports">Sports</a>
        <a href="category.php?cat=Tech">Tech</a>
        <a href="category.php?cat=World">World</a>
        <a href="category.php?cat=Business">Business</a>
        <a href="category.php?cat=Entertainment">Entertainment</a>

        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="dashboard.php" class="btn neon">Dashboard</a>
            <a href="logout.php" class="btn red">Logout</a>
        <?php else: ?>
            <a href="login.php" class="btn neon">Login</a>
            <a href="signup.php" class="btn purple">Signup</a>
        <?php endif; ?>
    </nav>
</header>
