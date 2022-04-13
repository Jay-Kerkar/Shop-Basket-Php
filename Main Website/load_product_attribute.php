<?php require('database_connection.php');
require('functions.php'); 

$type = get_secure_value($database_connection,$_POST['type']);

if($type == 'size') {
			$color_id = get_secure_value($database_connection,$_POST['color_id']);
			
			$product_id = get_secure_value($database_connection,$_POST['product_id']);
			
			$select_product_size = mysqli_query($database_connection, "select Product_Attributes.Product_Size, Sizes.Size from Product_Attributes, Sizes where Product_Attributes.Product_Id = '$product_id' and Product_Attributes.Product_Color = '$color_id' and Product_Attributes.Product_Quantity != 0 and Sizes.Id = Product_Attributes.Product_Size and Sizes.Status = 1 order by Sizes.Sorting_Order asc");
			
			$product_size_html = '';
			
			if (mysqli_num_rows($select_product_size) > 0) {
						while ($fetch_product_size = mysqli_fetch_array($select_product_size)) {
      			$product_size_html.= "<option value='".$fetch_product_size['Product_Size']."'>".$fetch_product_size['Size']."</option>";
						}
			}
			echo $product_size_html;
}

if($type == 'quantity') {
			$color_id = get_secure_value($database_connection,$_POST['color_id']);
			
			$size_id = get_secure_value($database_connection,$_POST['size_id']);
			
			$product_id = get_secure_value($database_connection,$_POST['product_id']);
			
			$select_product_attributes = mysqli_query($database_connection, "select Product_Price,Product_MRP,Product_Quantity from Product_Attributes where Product_Id = '$product_id' and Product_Color = '$color_id' and Product_Size = '$size_id'");
			
			if (mysqli_num_rows($select_product_attributes) > 0) {
			$fetch_product_attributes = mysqli_fetch_array($select_product_attributes);
			
			$product_quantity = $fetch_product_attributes ['Product_Quantity'];
			
			$product_price = $fetch_product_attributes ['Product_Price'];
			
			$product_mrp = $fetch_product_attributes ['Product_MRP'];
			
			$product_attributes = array("product_price" => $product_price,"product_mrp" => $product_mrp,"product_quantity" => $product_quantity);
			
			echo json_encode($product_attributes);
			}			
}
?>
