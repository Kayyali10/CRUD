<?php

// admin test email :admin@gmail.com
// password : admin@123456

session_start();

require_once __DIR__ . "/../config/database.php";

if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit;
}

if ($_SESSION["role"] !== "admin") {
    header("Location: welcome.php");
    exit;

}

// الـ CSRF Token هو قيمة عشوائية بتتخزّن في الـ Session، وبنرسلها مع الفورم حتى نتأكد إن طلب الحذف صادر من فورم مشروعنا.
if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

$stmt = $conn->prepare(
    "SELECT id, username, email, role, created_at
     FROM users
     ORDER BY id DESC"
);

$stmt->execute();

$users = $stmt->fetchAll();


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
    <div class="container" style="width: 90%; max-width: 1100px;">
        <a href="../admin/create.php"><button class="add">Add new user</button></a>

        <?php if (isset($_GET["registered"]) && $_GET["registered"] === "1"): ?>
            <div class="success-message">
                User created successfully!
            </div>
        <?php endif; ?>

        <?php if (isset($_GET["updated"]) && $_GET["updated"] === "1"): ?>
            <div class="success-message">
                User updated successfully!
            </div>
        <?php endif; ?>

        <?php if (isset($_GET["deleted"]) && $_GET["deleted"] === "1"): ?>
            <div class="success-message">
                User deleted successfully!
            </div>
        <?php endif; ?>




        <p>
            welcome,
            <?= htmlspecialchars($_SESSION["username"], ENT_QUOTES, 'UTF-8') ?>
        </p>
        <h3>Users Management</h3>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= (int) $user["id"] ?></td>

                        <td>
                            <?= htmlspecialchars($user["username"], ENT_QUOTES, 'UTF-8') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($user["email"], ENT_QUOTES, 'UTF-8') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($user["role"], ENT_QUOTES, 'UTF-8') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($user["created_at"], ENT_QUOTES, 'UTF-8') ?>
                        </td>

                        <td>
                            <a href="../admin/edit.php?id=<?= (int) $user["id"] ?>">Edit</a>
                            
                            <form action="../admin/delete.php" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this user?');">
                                <input type="hidden" name="id" value="<?= (int) $user["id"] ?>">
                                <input type="hidden" name="csrf_token"
                                    value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
                                <button type="submit" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p>
            <a href="logout.php">Logout</a>
        </p>
    </div>

</body>

</html>