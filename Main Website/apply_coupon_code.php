<?php  
require('database_connection.php');
require('functions.php');

$coupon_code = get_secure_value($database_connection,$_POST['coupon_code']);

$coupon_code_details = mysqli_query($database_connection,"select * from Coupon_Codes where Coupon_Code = '$coupon_code' and Status = '1'");

$coupon_code_validation = mysqli_num_rows($coupon_code_details);

$coupon_code_result_array = array();

if(isset($_SESSION['COUPON_CODE_ID'])){
unset($_SESSION['COUPON_CODE_ID']);
unset($_SESSION['COUPON_CODE']);
unset($_SESSION['COUPON_CODE_VALUE']);
unset($_SESSION['FINAL_CART_VALUE']);
}

$total_cart_value = 0;

foreach($_SESSION['cart'] as $product_key => $value_1){ 

foreach($value_1 as $attribute_key => $value_2){
			$product_details = get_products_details($database_connection,'','','',$product_key,'','','',$attribute_key);

			//Fetching Product's Details
			$product_price = $product_details[0]['Product_Price'];

			$product_quantity = $value_2['quantity'];

			$total_cart_value = $total_cart_value + ($product_price * $product_quantity);
			}
}
$product_details = get_products_details($database_connection,'','','',$product_key);

//Fetching Product's Details
$product_price = $product_details[0]['Product_Price'];

$product_quantity = $value['Product_Quantity'];

$total_cart_value = $total_cart_value + ($product_price * $product_quantity);
if($coupon_code_validation > 0) {
   $fetch_coupon_code_details = mysqli_fetch_array($coupon_code_details);
   $coupon_code_id = $fetch_coupon_code_details['Id'];
   
   $coupon_code_value = $fetch_coupon_code_details['Coupon_Code_Value'];
   
   $coupon_code_type = $fetch_coupon_code_details['Coupon_Code_Type'];
   
   $cart_minimum_value = $fetch_coupon_code_details['Cart_Minimum_Value'];
   
   if($total_cart_value > $cart_minimum_value) {
   
   			if($coupon_code_type == 'Value') {
   						$final_cart_value = $total_cart_value - $coupon_code_value;
   			}else{
   						$final_cart_value = $total_cart_value - (($total_cart_value * $coupon_code_value) / 100);
   			}
   			
   			$coupon_code_value = $total_cart_value - $final_cart_value;
   			
   			$_SESSION['COUPON_CODE_ID'] = $coupon_code_id;
   			$_SESSION['COUPON_CODE'] = $coupon_code;
   			$_SESSION['COUPON_CODE_VALUE'] = $coupon_code_value;
   			$_SESSION['FINAL_CART_VALUE'] = $final_cart_value;
   			
   			$coupon_code_result_array = array('coupon_code_error'=>'no','result'=>'Coupon Code Applied Successfully','final_cart_value'=>$final_cart_value,'coupon_code_value'=>$coupon_code_value);   			
   }else{
     $coupon_code_result_array = array('coupon_code_error'=>'yes','result'=>'To Apply This Coupon Code The Total Cart Value Should Be '.$cart_minimum_value);
   }
 
}else{
   $coupon_code_result_array = array('coupon_code_error'=>'yes','result'=>'Coupon Code Does Not Exist');
}

echo json_encode($coupon_code_result_array);
?>
