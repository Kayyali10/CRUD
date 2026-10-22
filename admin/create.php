<!-- إضافة مستخدم جديد. -->

<?php
session_start();

require_once __DIR__ . "/../config/database.php";


if (!isset($_SESSION["user_id"])) {
    header("Location: ../public/login.php");
    exit;
}



if ($_SESSION["role"] !== "admin"){
    header("Location: ../public/welcome.php");
    exit; 

}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $role = trim($_POST["role"] ??"");

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
    if (!in_array($role, ["user", "admin"], true)) {
    $errors[] = "Invalid role selected";
}

if ( !empty($username) && !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) ){
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
            $sql = "INSERT INTO users (username, email, password ,role)
                    VALUES (:username, :email, :password ,:role)";

            $stmt = $conn->prepare($sql);

            $stmt->execute([
                ":username" => $username,
                ":email" => $email,
                ":password" => $hashedPassword,
                ":role" => $role
            ]);

            header("Location: ../public/admin.php?registered=1");
            exit;

        } catch (PDOException $e) {
            error_log($e->getMessage());
            $errors[] = "add failed. Please try again.";
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

<form action="" method="POST" class="register-form">
   <h2>add new user</h2>

      <?php if(!empty($errors)):?>
        <div class="error-messages">
            <?php foreach ($errors as $error): ?>
           <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
           <?php endforeach ?>
        </div>

        <?php endif ?>
   <label for="username">UserName:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="email">Email : </label>
        <input type="email" id="email" name="email" autocomplete="email" required><br>

        <label for="password">Password : </label>
        <input type="password"  id="password" autocomplete="new-password" name="password" required>

        <select name="role" id="role" required>
            <option value="user">user</option>
            <option value="admin">admin</option>
        </select>

        <button type="submit">add New User</button>
</form>
    
</body>
</html>