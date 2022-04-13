<?php  
require('header.php');

$order_id = get_secure_value($database_connection,$_GET['id']);

$product_length = '';
$product_breadth = '';
$product_height = '';
$product_weight = '';	
 
if(isset($_POST['update_order_status'])){

$update_order_status = $_POST['update_order_status'];
$update_products_dimenesions = '';

if($update_order_status=='3') {
 
 $product_length = $_POST['product_length'];
 $product_breadth = $_POST['product_breadth'];
 $product_height = $_POST['product_height'];
 $product_weight = $_POST['product_weight'];	
 
 $update_products_dimensions = mysqli_query($database_connection,"update Products set Product_Length='$product_length',Product_Breadth='$product_breadth',Product_Height='$product_height',Product_Weight='$product_weight' where Id='$product_id'");

 }
 
	if($update_order_status=='5'){	mysqli_query($database_connection,"update Orders set Order_Status='$update_order_status',Payment_Status='2' where Id='$order_id'");
	}else{	mysqli_query($database_connection,"update Orders set Order_Status='$update_order_status' where Id='$order_id'");
	
	}
	
	if($update_order_status=='3') {
 
	$token = shiprocket_token($database_connection);
   place_shiprocket_order($database_connection,$token,$order_id,$product_length,$product_breadth,$product_height,$product_weight);
   
 }
 
 if($update_order_status=='6') {
 
 $shipping_order_id = mysqli_fetch_array(mysqli_query($database_connection,"select Shipping_Order_Id from Orders where Id='$order_id'"));
  if($shipping_order_id['Shipping_Order_Id'] > 0) {
 			$token = shiprocket_token($database_connection);
   cancel_shiprocket_order($shipping_order_id['Shipping_Order_Id'],$token);
  }   
 }
}
?>

<!-- My Orders -->
	<div class="content pb-0">
	<div class="orders">
	   <div class="row">
		  <div class="col-xl-12">
			 <div class="card">
				<div class="card-body">
				   <h4 class="box-title">Order Details | Ecommerce Website </h4>			
				<div class="card-body--">
				   <div class="table-stats order-table ov-h">
					  <table class="table ">
						 <thead>
							<tr>
								<th>Product Id</th>
								<th>Product Name</th>
								<th>Product Image</th>
								<th>Unit Price</th>
								<th>Quantity</th>
								<th>Total Price</th> 
							</tr>
						</thead>
						<tbody>
						<?php 							
						$select_order_details = mysqli_query($database_connection,"select distinct(Order_Details.Id),Order_Details.*,Products.Product_Name,Products.Product_Image,Products.Product_Overview,Products.Id as product_id,Products.Product_Length,Products.Product_Breadth,Products.Product_Height,Products.Product_Weight,Orders.Customer_Address from Order_Details,Products,Orders where Order_Details.Order_Id='$order_id' and Order_Details.Product_Id=Products.Id");
	
$final_price = 0;

while($fetch_order_details = mysqli_fetch_array($select_order_details)){  														
$customer_address = $fetch_order_details['Customer_Address'];

$final_price = $final_price + ($fetch_order_details['Price']*$fetch_order_details['Quantity']);

$product_id = $fetch_order_details['product_id'];
							?>									
							<tr>
								<td>
									<?php echo $product_id ?></td>
								<td>
									<?php echo $fetch_order_details['Product_Name']?>
									</td>
									<td>
									<img src="../Media/Products/<?php echo $fetch_order_details['Product_Image'] ?>">
								</td>
								<td><?php echo $fetch_order_details['Price']?></td>
								<td><?php echo $fetch_order_details['Quantity'] ?>
	</td>
								<td><?php echo $fetch_order_details['Price']*$fetch_order_details['Quantity'] ?></td>
							</tr>
							<?php } ?>
    </tbody>
					</table>
					<p class="final-price" style="margin-left:9px;font-weight:bold;color:black;">Final Price : <span style="color:orange;"><?php echo $final_price ?></span>
	
					<p class="order-status" style="margin-left:1000px;font-weight:bold;color:black;margin-top:-35px;">Order Status : <span style="color:#0F8F01;"><?php  
					$order_status = mysqli_fetch_array(mysqli_query($database_connection,"select Order_Status.Status from Order_Status, Orders where Orders.Id='$order_id' and Orders.Order_Status=Order_Status.Id"));
					
					echo $order_status['Status'];
					?></span>
					
					<p class="customer-address" style="margin-left:9px;font-weight:bold;color:black;margin-top:-35px;">Address : <span style="color:black;"><?php echo $customer_address ?></span>
					</p>
					<div>
								<form method="post">
									<select class="form-control" name="update_order_status" id="update_order_status" onchange="updateOrderStatus()">
										<option value="">Select Order Status</option>
										<?php								$select_order_status = mysqli_query($database_connection,"select * from Order_Status order by Id asc");
										while($fetch_order_status = mysqli_fetch_array($select_order_status)){
												echo "<option value=".$fetch_order_status['Id'].">".$fetch_order_status['Status']."</option>";											
										}
										?>
									</select>
									<div id="products_dimensions" style="display:none;">
											<table>
<?php
$select_order_details = mysqli_query($database_connection,"select distinct(Order_Details.Id),Order_Details.*,Products.Product_Name,Products.Product_Image,Products.Product_Overview,Products.Id as product_id,Products.Product_Length,Products.Product_Breadth,Products.Product_Height,Products.Product_Weight,Orders.Customer_Address from Order_Details,Products,Orders where Order_Details.Order_Id='$order_id' and Order_Details.Product_Id=Products.Id");

while($fetch_product_dimensions = mysqli_fetch_array($select_order_details)){

$product_length = $fetch_product_dimensions['Product_Length'];
 $product_breadth = $fetch_product_dimensions['Product_Breadth'];
 $product_height = $fetch_product_dimensions['Product_Height'];
 $product_weight = $fetch_product_dimensions['Product_Weight'];	
 
?>
												<tr>
																	<td><input type="text" class="form-control" name="product_length" placeholder="Products Length" value="<?php echo $product_length ?>" required></td>
												    <td><input type="text" class="form-control" name="product_breadth" placeholder="Products Breadth" value="<?php echo $product_breadth ?>" required></td>
										     	<td>	<input type="text" class="form-control" name="product_height" placeholder="Products Height" value="<?php echo $product_height ?>" required></td>
									       <td><input type="text" class="form-control" name="product_weight" placeholder="Products Weight" value="<?php echo $product_weight ?>" required></td>
														</tr>
												<?php } ?>
											</table>										
									</div>
									<input type="submit" class="form-control"/>
								</form>
							</div>
					</div>
		 		</div>
		 	 </div>
 		  </div>
	    </div>
     	</div>
</div>
<!--/ End My Orders -->

<script>
			function updateOrderStatus() {
						var update_order_status = jQuery('#update_order_status').val();
						
						if(update_order_status == 3) {
									jQuery('#products_dimensions'). show();
						}
			}
</script>
					
<?php  
require('footer.php');
?>
