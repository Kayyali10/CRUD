<!-- حذف مستخدم. -->
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

$id = $_POST["id"] ?? null;

if (!$id || !filter_var($id, FILTER_VALIDATE_INT) || $id < 1) {
    header("Location: ../public/admin.php");
    exit;
}
 

// hash_equals() بتقارن القيمتين بطريقة آمنة. إذا الـ Token مفقود أو غير مطابق، بنرفض الطلب.
if (
    !isset($_POST["csrf_token"], $_SESSION["csrf_token"]) ||
    !hash_equals($_SESSION["csrf_token"], $_POST["csrf_token"])
) {
    http_response_code(403);
    exit("Invalid request");
}

try {
    $sql = "DELETE FROM users WHERE id = :id";
    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ":id" => $id
    ]);

    if ($stmt->rowCount() === 0) {
        header("Location: ../public/admin.php?deleted=0");
        exit;
    }

    header("Location: ../public/admin.php?deleted=1");
    exit;

} catch (PDOException $e) {
    error_log($e->getMessage());
    header("Location: ../public/admin.php?deleted=0");
    exit;
}
 
 
 ?>