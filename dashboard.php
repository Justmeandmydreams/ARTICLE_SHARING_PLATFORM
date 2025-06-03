<?php
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user_name'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Article Share</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="navbar">
    <a href="index.php">Home</a>
    <a href="articles.php">Articles</a>
    <a href="post_article.php">Post Article</a>
    <a href="logout.php">Logout</a>
</div>

<div class="container">
    <h1>Welcome, <?= htmlspecialchars($user) ?> 👋</h1>

    <p>What would you like to do?</p>

    <a class="button" href="post_article.php">✍️ Post a New Article</a>
    <a class="button" href="articles.php">📚 Browse All Articles</a>
</div>

</body>
</html>
