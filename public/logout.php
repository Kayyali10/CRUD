<!-- إنهاء الجلسة وتسجيل الخروج. -->

<?php
session_start();
// بمسح جميع البيانات المخزنة داخل الجلسة.
$_SESSION = [];

session_destroy();

header("Location: login.php");
exit();

?>