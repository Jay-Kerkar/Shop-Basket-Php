<?php
require('header.php');

if(!isset($_SESSION['CUSTOMER_LOGIN'])) {
			?>
			<script>						window.location.href='customer_login.php';
			</script>
			<?php
}

$customer_id = $_SESSION['CUSTOMER_ID'];

$select_product_from_wishlist = mysqli_query($database_connection,"select Products.Product_Name,Products.Product_Image,Products.Product_Price,Products.Product_MRP,Products.Product_Overview,Wishlists.Id,Wishlists.Product_Id from Wishlists,Products where Wishlists.Product_Id = Products.Id and Wishlists.Customer_Id = '$customer_id'");

?>

<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="home.php">Home<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="wishlists.php">Wishlist</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->
			
	<!-- Shopping Cart -->
	<div class="shopping-cart section">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<!-- Shopping Summery -->
					<table class="table shopping-summery">
						<thead>
							<tr class="main-hading">
								<th>PRODUCT</th>
								<th>NAME</th>
								<th class="text-center">PRICE</th>
								<th class="text-center"><i class="ti-trash remove-icon"></i></th>
							</tr>
						</thead>
						<tbody>
<?php 
while($fetch_product_data = mysqli_fetch_array($select_product_from_wishlist)){
?>
							<tr>
								<td class="image" data-title="No">
											<a href="product_details.php?id=<?php echo $fetch_product_data['Product_Id'] ?>">
											<img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$fetch_product_data['Product_Image'] ?>"></td>
											</a>
								<td class="product-des" data-title="Description">
									<p class="product-name"><a href="product_details.php?id=<?php echo $fetch_product_data['Product_Id'] ?>"><?php echo $fetch_product_data['Product_Name'] ?></a></p>
									<p class="product-des"><?php echo $fetch_product_data['Product_Overview'] ?></p>
								</td>
								<td data-title="Price"><span style="margin-top:37px;"><?php echo $fetch_product_data['Product_Price'] ?></span></td>
								<td class="action" data-title="Remove"><a href="wishlists.php?wishlist_id=<?php echo $fetch_product_data['Id'] ?>"><i class="ti-trash remove-icon"></i></a></td>
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
			
	<!-- Start Shop Services Area  -->
	<section class="shop-services section">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-rocket"></i>
						<h4>Free shiping</h4>
						<p>Orders over $100</p>
					</div>
					<!-- End Single Service -->
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-reload"></i>
						<h4>Free Return</h4>
						<p>Within 30 days returns</p>
					</div>
					<!-- End Single Service -->
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-lock"></i>
						<h4>Sucure Payment</h4>
						<p>100% secure payment</p>
					</div>
					<!-- End Single Service -->
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-tag"></i>
						<h4>Best Peice</h4>
						<p>Guaranteed price</p>
					</div>
					<!-- End Single Service -->
				</div>
			</div>
		</div>
	</section>
	<!-- End Shop Newsletter -->
	
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
