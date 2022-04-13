<?php 
session_start();

unset($_SESSION['SELLER_LOGIN']);
unset($_SESSION['SELLER_USERNAME']);
unset($_SESSION['SELLER_ID']);

header('location:seller_login.php');
?>
