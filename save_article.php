<?php
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['article_id'])) {
    $user_id = $_SESSION['user_id'];
    $article_id = $_POST['article_id'];

    // Check if already saved
    $check = $conn->prepare("SELECT * FROM saves WHERE user_id = ? AND article_id = ?");
    $check->bind_param("ii", $user_id, $article_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows == 0) {
        $stmt = $conn->prepare("INSERT INTO saves (user_id, article_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $article_id);
        $stmt->execute();
        $stmt->close();
    }

    $check->close();
}

header("Location: articles.php");
exit;
