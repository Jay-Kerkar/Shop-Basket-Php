<?php 
require('database_connection.php');
require('functions.php'); 

$email_id = get_secure_value($database_connection,$_POST['email_id']);
	
$password = get_secure_value($database_connection,$_POST['password']);

$select_customer = "select * from Customers where Email_Id='$email_id' and Password='$password'";

$main_select_customer = mysqli_query($database_connection,$select_customer);

$customer_validator = mysqli_num_rows($main_select_customer);

if($customer_validator > 0) {

$fetch_customer_data = mysqli_fetch_array($main_select_customer);

$customer_name = $fetch_customer_data ['Name'];

$customer_id = $fetch_customer_data ['Id'];

$_SESSION['CUSTOMER_LOGIN'] = 'yes';

$_SESSION['CUSTOMER_NAME'] = $customer_name;

$_SESSION['CUSTOMER_ID'] = $customer_id;
 if(isset($_SESSION['WISHLIST_PRODUCT_ID']) && $_SESSION['WISHLIST_PRODUCT_ID']!='') {	add_product_to_wishlist($database_connection,$_SESSION['CUSTOMER_ID'],$_SESSION['WISHLIST_PRODUCT_ID']);
  unset($_SESSION['WISHLIST_PRODUCT_ID']);
 }
 
echo "Customer Logged In Successfully";

}else{
			
echo "Failed To Login Customer";
			
}
?>
