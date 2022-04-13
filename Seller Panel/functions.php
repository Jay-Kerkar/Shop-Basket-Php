<?php
function pr($array){
	echo '<pre>';
	print_r($array);
}

function prx($array){
	echo '<pre>';
	print_r($array);
	die();
}

function get_secure_value($database_connection,$secure_value){
		return mysqli_real_escape_string($database_connection,$secure_value);
}

function no_of_products_quantity_sold($database_connection,$product_id){
			$select_products_quantity = "select sum(Order_Details.Quantity) as Quantity from Order_Details,Orders where Orders.Id=Order_Details.Order_Id and Order_Details.Product_Id=$product_id and Orders.Order_Status!=6";
			
			$main_select_products_quantity = mysqli_query($database_connection,$select_products_quantity);
			
			$fetch_products_quantity = mysqli_fetch_array($main_select_products_quantity);
			
			return $fetch_products_quantity['Quantity'];
}

function total_no_of_products_quantity($database_connection,$product_id){
			$select_products_quantity = "select Product_Quantity as Quantity from Products where Id='$product_id'";
			
			$main_select_products_quantity = mysqli_query($database_connection,$select_products_quantity);
			
			$fetch_products_quantity = mysqli_fetch_array($main_select_products_quantity);
			
			return $fetch_products_quantity['Quantity'];
}
?>
