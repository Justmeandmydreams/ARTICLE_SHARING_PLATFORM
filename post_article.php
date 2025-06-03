<?php
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO articles (user_id, title, content) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $title, $content);

    if ($stmt->execute()) {
        $message = "Article posted successfully!";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Post Article - Article Share</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="navbar">
    <a href="index.php">Home</a>
    <a href="articles.php">Articles</a>
    <a href="dashboard.php">Dashboard</a>
    <a href="logout.php">Logout</a>
</div>

<div class="container">
    <h1>✍️ Share a New Article</h1>

    <?php if (!empty($message)): ?>
        <div class="success"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>Title</label>
        <input type="text" name="title" required>

        <label>Content</label>
        <textarea name="content" rows="10" required></textarea>

        <button type="submit">Post Article</button>
    </form>
</div>

</body>
</html>
