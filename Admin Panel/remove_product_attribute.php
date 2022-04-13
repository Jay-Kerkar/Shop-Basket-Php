<?php  
require('database_connection.php');
require('functions.php');

if(isset($_POST['attribute_id'])){
			if(isset($_SESSION['ADMIN_LOGIN']) && $_SESSION['ADMIN_LOGIN']!=''){
			
			}else{
			redirect_page('admin_login.php');
			}
			
			$attribute_id = get_secure_value($database_connection,$_POST['attribute_id']);
			
			mysqli_query($database_connection,"delete from Product_Attributes where Id='$attribute_id'");
}
?>