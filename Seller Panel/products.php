<?php
require('header.php');

if(isset($_GET['type']) && $_GET['type']!=''){
	$type = get_secure_value($database_connection,$_GET['type']);
	
	if($type == 'status'){
		$operation = get_secure_value($database_connection,$_GET['operation']);
		
		$Id = get_secure_value($database_connection,$_GET['id']);
		
		if($operation == 'activate'){
			$status = '1';
		}else{
			$status = '0';
		}
		
		$update_product_status = "update Products set Status = '$status' where Id = '$Id'";
		
		$main_update_product_status = mysqli_query($database_connection,$update_product_status);
	}
	
	if($type=='delete'){
		$id = get_secure_value($database_connection,$_GET['id']);
		
		$delete_product = "delete from Products where Id = '$id'";
		
		$main_delete_product = mysqli_query($database_connection,$delete_product);
	}
}

$select_product = "select Products.*,Categories.Category from Products,Categories where Products.Product_Category = Categories.Id and Products.Listing_Person_Role = 'Seller' and Products.Listing_Person_Id = '".$_SESSION['SELLER_ID']."' order by Products.Id desc";

$main_select_product = mysqli_query($database_connection,$select_product);

?>

<div class="content pb-0">
	<div class="orders">
	   <div class="row">
		  <div class="col-xl-12">
			 <div class="card">
				<div class="card-body">
				   <h4 class="box-title">Products | Seller Panel | Ecommerce Website</h4>
				   <h4 class="box-link"><a href="manage_products.php">Add Products</a> </h4>
				</div>
				<div class="card-body--">
				   <div class="table-stats order-table ov-h">
					  <table class="table">
						 <thead>
							<tr>
							   <th>ID</th>
							   <th>Product Category</th>
							   <th>Product Name</th>
							   <th>Product Quantity</th>
							   <th>Product Image</th>
							   <th>Product MRP</th>
							   <th>Product Price</th>
							   <th>Product Overview</th>
							   <th>Product Details</th>
							   <th>Prodcut Dimensions</th>
							   <th>Best Seller</th>
							   <th>Meta Title</th>
							   <th>Meta Description</th>
							   <th>Meta Keywords</th>
							   <th>Products Sold</th>
							   <th>Status</th>
							   <th>Operations</th>
							</tr>
						 </thead>
						 <tbody>
<?php 
while($fetch_product_data = mysqli_fetch_array($main_select_product)){
?>
							<tr>
							   <td><?php echo $fetch_product_data['Id']?></td>
							   <td><?php echo $fetch_product_data['Category']?></td>
							   <td><?php echo $fetch_product_data['Product_Name']?></td>
							   <td>
<?php
$total_no_of_products_quantity = total_no_of_products_quantity($database_connection,$fetch_product_data['Id']);
			
$no_of_products_quantity_sold		= no_of_products_quantity_sold($database_connection,$fetch_product_data['Id']);
					   
$no_of_products_quantity_remaining = ($total_no_of_products_quantity - $no_of_products_quantity_sold);
							   if($no_of_products_quantity_remaining > 0) {
							   			echo $no_of_products_quantity_remaining;
}else	{
							   			echo "Out Of Stock";
} 
?>
									</td>
							  <td><img src="<?php echo PRODUCT_MAIN_IMAGE_SITE_PATH.$fetch_product_data['Product_Image'] ?>"/></td>
							   <td><?php echo $fetch_product_data['Product_MRP']?></td>
							   <td><?php echo $fetch_product_data['Product_Price']?></td>
							   <td><?php echo $fetch_product_data['Product_Overview']?></td>
							   <td><?php echo $fetch_product_data['Product_Details']?></td>
							   <td>Length : <?php echo $fetch_product_data['Product_Length']?>
							   Breadth : <?php echo $fetch_product_data['Product_Breadth']?>
							   Height : <?php echo $fetch_product_data['Product_Height']?>
							   
							   Weight : <?php echo $fetch_product_data['Product_Weight']?>
							   </td>
							   <td><?php 					   if($fetch_product_data['Best_Seller']==1) {
							   	echo 'Yes';
							   }else {
							   		echo 'No';	
							   }
							  ?></td>
							   <td><?php echo $fetch_product_data['Meta_Title']?></td>
							   <td><?php echo $fetch_product_data['Meta_Description']?></td>
							   <td><?php echo $fetch_product_data['Meta_Keywords']?></td>
							   <td><?php					   if(no_of_products_quantity_sold($database_connection,$fetch_product_data['Id'])) {
							   			echo no_of_products_quantity_sold($database_connection,$fetch_product_data['Id']);
							   }else {
							   			echo 0;
							   }	
							   ?></td>							   
							   <td>
							   <?php
if($fetch_product_data['Status']==1){
									
								echo "<span class='badge badge-complete'><a href='?type=status&operation=deactivate&id=".$fetch_product_data['Id']."'>Active</a></span>&nbsp;";
								
																}else{
																
									echo "<span class='badge badge-pending'><a href='?type=status&operation=activate&id=".$fetch_product_data['Id']."'>Inactive</a></span>&nbsp;";
							
								}
							?>
							</td>
								
							<td><?php
								echo "<span class='badge badge-edit'><a href='manage_products.php?type=edit&id=".$fetch_product_data['Id']."'>Edit</a></span>&nbsp;";
								
								echo "<span class='badge badge-delete'><a href='?type=delete&id=".$fetch_product_data['Id']."'>Delete</a></span>";
?>
							   </td>
							</tr>
							<?php } ?>
						 </tbody>
					  </table>
				   </div>
				</div>
			 </div>
		  </div>
	   </div>
	</div>
</div>

<?php
require('footer.php');
?>
