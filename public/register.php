<!-- نموذج التسجيل ومعالجة طلب إنشاء الحساب. -->


<?php

require_once __DIR__ . "/../config/database.php";

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if (empty($username)) {
        $errors[] = "Username is required";
    }

    if (empty($email)) {
        $errors[] = "Email is required";
    }

    if (empty($password)) {
        $errors[] = "Password is required";
    }

    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    if (!empty($password) && strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long";
    }

    if (
        !empty($username) &&
        !empty($email) &&
        filter_var($email, FILTER_VALIDATE_EMAIL)
    ) {
        $sql = "SELECT id FROM users
                WHERE username = :username OR email = :email";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            ":username" => $username,
            ":email" => $email
        ]);

        $user = $stmt->fetch();

        if ($user) {
            $errors[] = "Username or email already exists";
        }
    }

    if (empty($errors)) {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            $sql = "INSERT INTO users (username, email, password)
                    VALUES (:username, :email, :password)";

            $stmt = $conn->prepare($sql);

            $stmt->execute([
                ":username" => $username,
                ":email" => $email,
                ":password" => $hashedPassword
            ]);

            echo "Registration successful!";
            header("Location: login.php?registered=1");
            exit;

        } catch (PDOException $e) {
            error_log($e->getMessage());
            $errors[] = "Registration failed. Please try again.";
        }
    }

    foreach ($errors as $error) {
        echo htmlspecialchars($error, ENT_QUOTES, "UTF-8") . "<br>";
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
   <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <form action="register.php" method="POST" class="register-form">

        <h2>Create Account</h2>
       
<?php if (!empty($errors)): ?>
    <div class="error-messages">
        <?php foreach ($errors as $error): ?>
            <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>


        <label for="username">UserName:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="email">Email : </label>
        <input type="email" id="email" name="email" autocomplete="email" required><br>

        <label for="password">Password : </label>
        <input type="password"  id="password" autocomplete="password" name="password" required>

        <button type="submit">Register</button>
        <p>Do you have account?
            <a href="login.php">Login</a>
        </p>
    </form>
    
</body>
</html>