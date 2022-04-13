<?php 
require('header.php');

$order_id = get_secure_value($database_connection,$_GET['id']);
?>

<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="home.php">Home<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="order_details.php">Order Details</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->
	
<!-- My Orders -->
	<div class="shopping-cart section">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<!-- Shopping Summery -->
					<table class="table shopping-summery">
						<thead>							
							 <tr class="main-hading">
								<th>Product Name</th>					
								<th>Product Image</th>
								<th class="text-center">Price</th>
								<th class="text-center">Quantity</th>
								<th class="text-center">Total Price</th> 
							</tr>
						</thead>
						<tbody>
						<?php 
							$customer_id = $_SESSION['CUSTOMER_ID'];
							$select_order_details = mysqli_query($database_connection,"select distinct(Order_Details.Id),Order_Details.*,Products.Product_Name,Products.Product_Image,Products.Product_Overview,Products.Id as product_id from Order_Details,Products, Orders where Order_Details.Order_Id='$order_id' and Orders.Customer_Id='$customer_id' and Order_Details.Product_Id=Products.Id");
							
							$total_price = 0;
							
							while($fetch_order_details = mysqli_fetch_array($select_order_details)){
							$total_price = $total_price + ($fetch_order_details['Price']*$fetch_order_details['Quantity']);
							?>
							<tr>
										<td class="product-des" data-title="Description">
									<p class="product-name">
									<a href="product_details.php?id=<?php echo $fetch_order_details['product_id'] ?>">		
							 <?php echo $fetch_order_details['Product_Name'] ?>
							 </a>
							 </p>
									<p class="product-des"><?php echo $fetch_order_details['Product_Overview'] ?></p>
								</td>
								<td class="image" data-title="No">
											<a href="product_details.php?id=<?php echo $fetch_order_details['product_id'] ?>">		
											<img src="../Media/Products/<?php echo $fetch_order_details['Product_Image'] ?>"></td>
											</a>
								<td data-title="Price"><span><?php echo $fetch_order_details['Price'] ?></span></td>
								<td class="qty" data-title="Qty">
								<?php echo $fetch_order_details['Quantity'] ?>
								</td>
								<td class="total-amount" data-title="Total"><span><?php echo $fetch_order_details['Price']*$fetch_order_details['Quantity'] ?></span></td>
							</tr>
							<?php } ?>
</tbody>
</table>
						<!--/ End Shopping Summery -->
				</div>
			</div>
				</div>
			</div>
		</div>
	</div>
	<!--/ End Shopping Cart -->
	
	<div class="row">
				<div class="col-12">
					<!-- Total Amount -->
					<div class="total-amount">
						<div class="row">
							<!-- Total Amount -->
					<div class="col-lg-4 col-md-7 col-12">
								<div class="right">
									<ul>
										<li>Total Price<span>Rs <?php echo $total_price ?></span></li>
									</ul>
									<div class="button5">
										<a href="my_orders.php" class="btn">Back To My Orders</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--/ End Total Amount -->
				</div>
			</div>
		</div>
	</div>
	<!--/ End Shopping Cart -->
	
<?php  
require('footer.php');
?>
