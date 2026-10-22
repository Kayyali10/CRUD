<!-- مسؤول عن الاتصال بقاعدة البيانات باستخدام PDO. -->

<?php
// معلومات الاتصال 
$host = "localhost";
$dbname = "php_auth_system";
$username = "root";
$password = "";

try {
    // محاولة الاتصال عن طريق ال PDO
    $conn = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );
// هذا السطر يجعل PDO يرمي استثناءً عند حدوث أخطاء في استعلامات قاعدة البيانات، بدل الاعتماد على فحص نتيجة كل استعلام يدويًا.
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // هذا السطر يجعل النتائج المسترجعة من قاعدة البيانات تُقرأ افتراضيًا كمصفوفات ترابطية (Associative Arrays).
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    error_log($e->getMessage());
    exit("connection filed");
}
