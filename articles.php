<?php
include 'db.php';

$articles = [];
$user_id = $_SESSION['user_id'] ?? null;

$sql = "SELECT a.id, a.title, a.content, u.name,
           (SELECT COUNT(*) FROM likes WHERE article_id = a.id) AS like_count,
           (SELECT COUNT(*) FROM saves WHERE article_id = a.id) AS save_count
        FROM articles a
        JOIN users u ON a.user_id = u.id
        ORDER BY a.id DESC";

$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $articles[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Articles - Article Share</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="navbar">
    <a href="index.php">Home</a>
    <a href="post_article.php">Post Article</a>
    <a href="dashboard.php">Dashboard</a>
    <?php if ($user_id): ?>
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="login.php">Login</a>
    <?php endif; ?>
</div>

<div class="container">
    <h1>📚 Articles</h1>

    <?php foreach ($articles as $article): ?>
        <div class="article-box">
            <h3><?= htmlspecialchars($article['title']) ?></h3>
            <p><?= nl2br(htmlspecialchars($article['content'])) ?></p>
            <small>By <?= htmlspecialchars($article['name']) ?></small>
            <div style="margin-top: 10px;">
                <form style="display:inline;" method="POST" action="like_article.php">
                    <input type="hidden" name="article_id" value="<?= $article['id'] ?>">
                    <button type="submit">❤️ Like (<?= $article['like_count'] ?>)</button>
                </form>

                <form style="display:inline;" method="POST" action="save_article.php">
                    <input type="hidden" name="article_id" value="<?= $article['id'] ?>">
                    <button type="submit">🔖 Save (<?= $article['save_count'] ?>)</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
