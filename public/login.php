<!-- نموذج تسجيل الدخول والتحقق من كلمة المرور. -->

<?php
require_once __DIR__ . "/../config/database.php";

$errors = [];

if ($_SERVER["REQUEST_METHOD"] ==="POST"){
    $email = trim($_POST["email"] ?? "");
    $password = ($_POST["password"] ?? "");

    if (empty($email)){
               $errors[] = "Email is required.";
    }
    if (empty($password)){

            $errors[] = "Password is required.";
    }

    if (empty($errors)){
        $stmt = $conn->prepare(
        "SELECT id , username , email , password , role 
        FROM users 
        WHERE email = :email"
        );

        $stmt->execute([
            "email" => $email
        ]);
       $user = $stmt->fetch();

       if (!$user || !password_verify($password , $user["password"])){
           $errors[] = "Invalid email or password.";
       }else {
        session_start();
        //  بتغيّر معرّف الجلسة بعد تسجيل الدخول لتقليل خطر Session Fixation.
        session_regenerate_id(true);

        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["email"] = $user["email"];
        $_SESSION["role"] = $user["role"];

         if ($user["role"] === "admin"){
            header("Location: admin.php");
         }else {
            header("Location: welcome.php");
         }
        exit;

       }
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
    <div class="container">
        <h2>Login</h2>

        <form action="" method="post">

          <?php if (!empty($errors)): ?>
            <div class="error-messages">
                <?php foreach($errors as $error): ?>
                  <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
                  <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit">Login</button>
        </form>
        <p>Don't have an account?
            <a href="register.php">Register here</a>
        </p>

    </div>





</body>

</html>