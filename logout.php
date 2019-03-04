<?php // line 1 added to enable color highlight
require_once "head.html";

session_start();
unset($_SESSION['name']);
unset($_SESSION['user_id']);
unset($_SESSION['success']);
unset($_SESSION['error']);
unset($_SESSION['failure']);
header('Location: index.php');
return;
?>