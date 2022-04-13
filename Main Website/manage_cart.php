<?php
require('database_connection.php');
require('functions.php');
require('add_to_cart.php');

$product_id = get_secure_value($database_connection,$_POST['product_id']);

$quantity = get_secure_value($database_connection,$_POST['quantity']);

$type = get_secure_value($database_connection,$_POST['type']);

$attribute_id = 0;

if(isset($_POST['color_id']) && isset($_POST['size_id'])){
			$condition = '';
			
			$color_id = get_secure_value($database_connection,$_POST['color_id']);

			$size_id = get_secure_value($database_connection,$_POST['size_id']);
			
			if($size_id > 0){
						$condition.= "and Product_Size = $size_id";
			}
			
			if($color_id > 0){
						$condition.= " and Product_Color = $color_id";
			}
			
			$select_product_attribute = mysqli_fetch_array(mysqli_query($database_connection, "select Id from Product_Attributes where Product_Id = '$product_id' $condition"));

			$attribute_id = $select_product_attribute['Id'];
}

$no_of_products_quantity_sold = no_of_products_quantity_sold($database_connection,$product_id,$attribute_id);

$total_no_of_products_quantity = total_no_of_products_quantity($database_connection,$product_id,$attribute_id);

$no_of_products_quantity_remaining = ($total_no_of_products_quantity - $no_of_products_quantity_sold);

if($quantity > $no_of_products_quantity_remaining){
			echo 'Products Quantity Not Available';
			die();
}

$cart_object = new add_to_cart();

if($type == 'add'){
	$cart_object->add_products_to_cart($product_id,$quantity,$attribute_id);
	
}

if($type == 'remove'){
	$cart_object->remove_products_from_cart($product_id,$attribute_id);
	
}

if($type == 'update'){
	$cart_object->update_products_of_cart($product_id,$quantity,$attribute_id);
	
}

echo $cart_object->total_no_of_products();

?>
