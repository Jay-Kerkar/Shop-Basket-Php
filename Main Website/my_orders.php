<?php  
require('header.php');

if(!isset($_SESSION['CUSTOMER_LOGIN'])) {
			?>
	<script>	window.location.href='customer_login.php?type=my_orders_login';
	</script>
	<?php
}
?>

<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="home.php">Home<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="my_orders.php">My Orders</a></li>
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
								<th>Order Id</th>
								<th>Order Date</th>
								<th>Shipping Address</th>
								<th>Payment Type</th>
								<th>Payment Status</th> 
								<th>Order Status</th>
								<th>View Details</th>
							</tr>
						</thead>
						<tbody>
						<?php 
							$customer_id = $_SESSION['CUSTOMER_ID'];
							$select_order_details = mysqli_query($database_connection,"select Orders.*,Order_Status.Status as order_status_string,Payment_Status.Status as payment_status_string from Orders,Order_Status,Payment_Status where Orders.Customer_Id='$customer_id' and Order_Status.Id=Orders.Order_Status and Payment_Status.Id=Orders.Payment_Status order by Orders.Id");
							
							while($fetch_order_details = mysqli_fetch_array($select_order_details)){
							?>
							<tr>
								<td>
											<a href="product_details.php?id=<?php echo $product_id ?>"><?php echo $fetch_order_details['Id']?>						
											</a>
											</td>
								<td>
									<?php echo $fetch_order_details['Order_Date_Time']?>
									</td>
									<td>
									<?php echo $fetch_order_details['Customer_Address']?>
								</td>
								<td><?php echo $fetch_order_details['Payment_Type'] ?></td>
								<td><?php echo $fetch_order_details['payment_status_string'] ?></td>
								<td><?php echo $fetch_order_details['order_status_string'] ?></td>
								<td><a href="order_details.php?id=<?php echo $fetch_order_details['Id']?>">View Details</a></td>
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
	
	<!-- Start Shop Newsletter  -->
	<section class="shop-newsletter section">
		<div class="container">
			<div class="inner-top">
				<div class="row">
					<div class="col-lg-8 offset-lg-2 col-12">
						<!-- Start Newsletter Inner -->
						<div class="inner">
							<h4>Newsletter</h4>
							<p> Subscribe to our newsletter and get <span>10%</span> off your first purchase</p>
							<form action="mail/mail.php" method="get" target="_blank" class="newsletter-inner">
								<input name="EMAIL" placeholder="Your email address" required="" type="email">
								<button class="btn">Subscribe</button>
							</form>
						</div>
						<!-- End Newsletter Inner -->
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Shop Newsletter -->
						
<?php  
require('footer.php');
?>
