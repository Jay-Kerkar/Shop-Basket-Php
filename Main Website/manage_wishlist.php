<?php
require('database_connection.php');
require('functions.php');

$product_id = get_secure_value($database_connection,$_POST['product_id']);

if(isset($_SESSION['CUSTOMER_LOGIN'])) {
 $customer_id = $_SESSION['CUSTOMER_ID'];
		 if(mysqli_num_rows(mysqli_query($database_connection,"select * from Wishlists where Product_Id = '$product_id' and Customer_Id = '$customer_id'")) > 0) {
  			echo "Product Already Added To The Wishlist";
  }else{			add_product_to_wishlist($database_connection,$customer_id,$product_id);
   unset($_SESSION['WISHLIST_PRODUCT_ID']);
		 }	
echo		$total_products_in_wishlists = mysqli_num_rows(mysqli_query($database_connection,"select * from Wishlists where Customer_Id = '$customer_id'"));

}else{
   $_SESSION['WISHLIST_PRODUCT_ID'] = $product_id;
			echo "Customer Is Not Logged In";
}
?>
