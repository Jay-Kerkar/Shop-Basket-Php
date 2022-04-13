<?php 
require('database_connection.php');
require('functions.php');

unset($_SESSION['CUSTOMER_ID']);
unset($_SESSION['CUSTOMER_LOGIN']);
unset($_SESSION['CUSTOMER_NAME']);

header('location:home.php');
die();
?>
