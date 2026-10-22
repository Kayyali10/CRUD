<!-- تعديل بيانات مستخدم. -->

<?php

session_start();

require_once __DIR__ . "/../config/database.php";


if (!isset($_SESSION["user_id"])) {
    header("Location: ../public/login.php");
    exit;
}



if ($_SESSION["role"] !== "admin") {
    header("Location: ../public/welcome.php");
    exit;

}

$id = $_GET["id"] ?? null;

if (!$id || !filter_var($id, FILTER_VALIDATE_INT) || $id < 1) {
    header("Location: ../public/admin.php");
    exit;
}

$sql = "SELECT id,username,email,role
        FROM users
        WHERE id = :id ";

$stmt = $conn->prepare($sql);

$stmt->execute([
    ":id" => $id
]);

// PDO::FETCH_ASSOC فبتخلي البيانات ترجع على شكل Associative Array، أي مصفوفة مفاتيحها أسماء الأعمدة.
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header("Location: ../public/admin.php");
    exit;
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $role = trim($_POST["role"] ?? "");

    if (empty($username)) {
        $errors[] = "Username is required";
    }

    if (empty($email)) {
        $errors[] = "Email is required";
    }

    // if (empty($password)) {
    //     $errors[] = "Password is required";
    // }

    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    // if (!empty($password) && strlen($password) < 8) {
    //     $errors[] = "Password must be at least 8 characters long";
    // }
    if (!in_array($role, ["user", "admin"], true)) {
        $errors[] = "Invalid role selected";
    }

    if (!empty($username) && !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $sql = "SELECT id FROM users
                WHERE (username = :username OR email = :email)
                AND id != :id";


        $stmt = $conn->prepare($sql);

        $stmt->execute([
            ":username" => $username,
            ":email" => $email,
            ":id" => $id
        ]);

        $existingUser = $stmt->fetch();

        if ($existingUser) {
            $errors[] = "Username or email already exists";
        }
    }

    if (empty($errors)) {

        // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            $sql = "UPDATE users
                    SET username = :username,email = :email,role = :role 
                    WHERE id = :id;";

            $stmt = $conn->prepare($sql);

            $stmt->execute([
                ":id" => $id,
                ":username" => $username,
                ":email" => $email,
                // ":password" => $hashedPassword,
                ":role" => $role
            ]);

            header("Location: ../public/admin.php?updated=1");
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
        <h2>ُEdit user</h2>

        <?php if (!empty($errors)): ?>
            <div class="error-messages">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
                <?php endforeach ?>
            </div>
        <?php endif ?>
        <label for="username">UserName:</label>
        <input type="text" id="username" name="username"
            value="<?= htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8') ?>" required><br>

        <label for="email">Email : </label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?>"
            required><br>

        <!-- <label for="password">Password : </label>
        <input type="password"  id="password" autocomplete="new-password" name="password" required> -->

        <select name="role" id="role" required>
            <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>
                User
            </option>
            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>
                Admin
            </option>
        </select>

        <button type="submit">Edit User</button>
    </form>

</body>

</html>