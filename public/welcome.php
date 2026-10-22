<!-- صفحة الترحيب بالمستخدم العادي. -->

<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>welcome</title>
</head>
<body>
    <div class="container">
        <h2>Welcome, <?= htmlspecialchars($_SESSION["username"], ENT_QUOTES, 'UTF-8') ?>!</h2>

          <p>You have successfully logged in.</p>

            <p>Your role: <?= htmlspecialchars($_SESSION["role"], ENT_QUOTES, 'UTF-8') ?></p>

            <a href="logout.php">Logout</a>

    </div>
    
</body>
</html>