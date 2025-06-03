<?php
include 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        $message = "Registration successful! You can now <a href='login.php'>login</a>.";
    } else {
        $message = "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - Article Share</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="navbar">
    <a href="index.php">Home</a>
    <a href="articles.php">Articles</a>
    <a href="post_article.php">Post Article</a>
    <a href="login.php">Login</a>
</div>

<div class="container">
    <h1>Create Account</h1>

    <?php if (!empty($message)): ?>
        <div class="<?php echo strpos($message, 'successful') !== false ? 'success' : 'alert'; ?>">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <label>Full Name</label>
        <input type="text" name="name" required>

        <label>Email Address</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Register</button>
    </form>
</div>

</body>
</html>

