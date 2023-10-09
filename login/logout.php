<?php
session_start();
unset($_SESSION['loginUserId']);
unset($_SESSION['loginName']);
header("Location: login.php");
exit();
?>