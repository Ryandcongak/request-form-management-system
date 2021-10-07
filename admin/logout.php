<?php
session_start();
$_SESSION = [];
session_unset();
session_destroy();

// cookie
setcookie('en', '', time() - 3600);
setcookie('key', '', time() - 3600);

header("location: ../index.php");
exit;