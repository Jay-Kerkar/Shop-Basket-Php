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
  if($secure_value!=''){
    $secure_value = trim($secure_value);
  			return strip_tags(mysqli_real_escape_string($database_connection,$secure_value));
  }
}

function get_products_data($database_connection,$type='',$no_of_products='',$category_id='',$product_id='',$search='',$sorting_order='',$sub_category_id='',$attribute_id='') {
			
			$select_products = "select Products.*,Categories.Category,Sub_Categories.Sub_Category,Product_Attributes.Product_Price,Product_Attributes.Product_MRP,Product_Attributes.Product_Quantity from Products,Categories,Sub_Categories, Product_Attributes where Products.Status = 1 and Products.Id = Product_Attributes.Product_Id";
			
			if($category_id!='') {
			$select_products.= " and Products.Product_Category = $category_id ";
			}
			
			if($product_id!='') {
			$select_products.= " and Products.Id = $product_id ";
			}
			
			if($sub_category_id!='') {
			$select_products.= " and Products.Product_Sub_Category = $sub_category_id ";
			}
			
			if($attribute_id > 0) {
			$select_products.= " and Product_Attributes.Id = $attribute_id ";
			}
			
			$select_products.= " and Products.Product_Category = Categories.Id ";
			
			if($search!='') {
			$select_products.= " and (Products.Product_Name like '%$search%' or Products.Product_Details like '%$search%' or Products.Product_Overview like '%$search%') ";
			}
			
				$select_products.= " group by Products.Id ";
				
			if($sorting_order!='') {
			$select_products.= $sorting_order;
			}else if($type=='new_arrivals'){
			
			}else if($type=='best_seller'){
			   
			}else{
						$select_products.= " order by Products.Id desc ";		
			}
			
			if($type=='new_arrivals') {
			$select_products.= " order by Products.Id desc ";
			}else if($type=='best_seller'){
			$select_products.= " and Products.Best_Seller='1' ";			
			}
			
			if($no_of_products!='') {
			$select_products.= " limit $no_of_products ";
			}
			
			$main_select_products = mysqli_query($database_connection,$select_products);
			
			$products_data = array();
			
			while($fetch_products_data = mysqli_fetch_array($main_select_products)) {
$products_data[] = $fetch_products_data;						
			}
			return $products_data;
}

function no_of_products_quantity_sold($database_connection,$product_id,$attribute_id){

			$select_products_quantity = "select sum(Order_Details.Quantity) as Quantity from Order_Details,Orders where Orders.Id=Order_Details.Order_Id and Order_Details.Product_Id=$product_id and Orders.Order_Status!=6 and ((Orders.Payment_Type='Online Payment' and Orders.Payment_Status='2') or (Orders.Payment_Type='Cash On Delivery' and Orders.Payment_Status!=''))";

			$main_select_products_quantity = mysqli_query($database_connection,$select_products_quantity);
			
			$fetch_products_quantity = mysqli_fetch_array($main_select_products_quantity);
			
			return $fetch_products_quantity['Quantity'];
}

function total_no_of_products_quantity($database_connection,$product_id,$attribute_id){
			$select_products_quantity = "select Product_Quantity from Product_Attributes where Id = '$attribute_id' and Product_Id = '$product_id'";
			
			$main_select_products_quantity = mysqli_query($database_connection,$select_products_quantity);

			$fetch_products_quantity = mysqli_fetch_array($main_select_products_quantity);
			
			return $fetch_products_quantity['Product_Quantity'];
}

function add_product_to_wishlist($database_connection,$customer_id,$product_id) {

$registration_date_time = date('d-m-Y h:i A');
	mysqli_query($database_connection,"insert into Wishlists(Customer_Id,Product_Id,Registration_Date_Time) values('$customer_id','$product_id','$registration_date_time')");
}


?>
