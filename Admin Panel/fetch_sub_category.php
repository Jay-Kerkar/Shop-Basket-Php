<?php  
require('database_connection.php');
require('functions.php');

$product_category = get_secure_value($database_connection,$_POST['product_category']);

$product_sub_category = get_secure_value($database_connection,$_POST['product_sub_category']);

$select_sub_category = mysqli_query($database_connection,"select * from Sub_Categories where Category='$product_category' and Status='1'");

if(mysqli_num_rows($select_sub_category) > 0){
  $html = '';
  
			while($fetch_sub_category = mysqli_fetch_array($select_sub_category)){
			if($product_sub_category == $fetch_sub_category['Id']) {
						$html.= "<option value=".$fetch_sub_category['Id']." selected>".$fetch_sub_category['Sub_Category']."</option>";
			}else{
						$html.= "<option value=".$fetch_sub_category['Id'].">".$fetch_sub_category['Sub_Category']."</option>";
			}
		}
			echo $html;
}else{
			echo "<option value=''>No Sub Category Found</option>";
}
?>
