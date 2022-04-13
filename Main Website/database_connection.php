<?php 
session_start();
require('functions.php');

$database_server = 'sql208.epizy.com';
$database_username = 'epiz_29509326';
$database_password = 'JmhZV36D6zsBs';
$database = 'epiz_29509326_Ecommerce_Website';

$database_connection = mysqli_connect($database_server,$database_username,$database_password,$database);

if(!$database_connection){
redirect_page('connectivity_error.php');
}
?>
