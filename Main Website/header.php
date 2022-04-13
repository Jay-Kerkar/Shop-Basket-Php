<?php 
require('database_connection.php');
require('functions.php');
require('add_to_cart.php');
require('constants.php');

$select_categories = "select * from Categories where Status = 1 order by Category asc";

$main_select_categories = mysqli_query($database_connection,$select_categories);

$categories_data = array();

while($fetch_categories = mysqli_fetch_array($main_select_categories)){

$categories_data[] = $fetch_categories;	
	
}

$cart_object = new add_to_cart();

$total_no_of_products = $cart_object->total_no_of_products();

$script_name = $_SERVER['SCRIPT_NAME'];
$script_name_array = explode('/',$script_name);

$page = $script_name_array[count($script_name_array) - 1];

$meta_title = "Ecommerce Website";
$meta_description = "Ecommerce Website";
$meta_keywords = "Ecommerce Website";

if($page == 'product_details.php') {
			
$product_id = get_secure_value($database_connection,$_GET['id']); 

$products_meta_data = mysqli_fetch_array(mysqli_query($database_connection,"select * from Products where Id='$product_id'"));

$meta_title = $products_meta_data['Meta_Title'];

$meta_description = $products_meta_data['Meta_Description'];

$meta_keywords = $products_meta_data['Meta_Keywords'];

$meta_url = SITE_PATH."product_details.php?id=".$product_id;

$meta_image = PRODUCT_MAIN_IMAGE_SITE_PATH.$products_meta_data['Product_Image'];
}

if($page == 'contact_us.php') {
			
$meta_title = 'Contact Us - Ecommerce Website';

}

if($page == 'categories.php') {
			
$meta_title = 'Categories - Ecommerce Website';

}

if($page == 'cart.php') {
			
$meta_title = 'Cart - Ecommerce Website';

}

if($page == 'checkout.php') {
			
$meta_title = 'Checkout - Ecommerce Website';

}

if($page == 'my_orders.php') {
			
$meta_title = 'My Orders - Ecommerce Website';

}

if($page == 'order_details.php') {
			
$meta_title = 'Order Details - Ecommerce Website';

}

if($page == 'order_summary.php') {
			
$meta_title = 'Order Summary - Ecommerce Website';

}

if(isset($_SESSION['CUSTOMER_LOGIN']))
{

$customer_id = $_SESSION['CUSTOMER_ID'];

if(isset($_GET['wishlist_id'])) {
  $wishlist_id = $_GET['wishlist_id'];
			$delete_product_from_wishlist = mysqli_query($database_connection,"delete from Wishlists where Id = '$wishlist_id' and Customer_Id = '$customer_id'");
}

$product_data_count_from_wishlist = mysqli_num_rows(mysqli_query($database_connection,"select Products.Product_Name,Products.Product_Image,Products.Product_Price,Products.Product_MRP,Products.Product_Overview,Wishlists.Id from Wishlists,Products where Wishlists.Product_Id = Products.Id and Wishlists.Customer_Id = '$customer_id'"));
}

if(isset($_SESSION['WISHLIST_PRODUCT_ID']) && isset($_SESSION['CUSTOMER_LOGIN'])){
			$product_id = $_SESSION['WISHLIST_PRODUCT_ID'];
?>

<script>
			manage_wishlist('<?php echo $product_id ?>');
</script>

<?php
unset($_SESSION['WISHLIST_PRODUCT_ID']);
}
?>

<!DOCTYPE html>
<html lang="zxx">
<head>
	<!-- Meta Tag -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name='copyright' content=''>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Title Tag  -->
    <title><?php echo $meta_title ?></title>
    <meta name="description" content="<?php echo $meta_description ?>">
    <meta name="keywords" content="<?php echo $meta_keywords ?>">
    
    <meta property="og:title" content="<?php echo $meta_title ?>">
    <meta property="og:image" content="<?php echo $meta_image ?>">
    <meta property="og:url" content="<?php echo $meta_url ?>">
    <meta property="og:site_name" content="<?php echo SITE_PATH."home.php" ?>">
    
	<!-- Favicon -->
	<link rel="icon" type="image/png" href="images/favicon.png">
	<!-- Web Font -->
	<link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
	
	<!-- StyleSheet -->
 <link rel="stylesheet" href="css/product_details.css"></link>
 <link rel="stylesheet" href="css/order_summary.css"></link>
	<!-- Bootstrap -->
	<link rel="stylesheet" href="css/bootstrap.css">
	<!-- Magnific Popup -->
    <link rel="stylesheet" href="css/magnific-popup.min.css">
	<!-- Font Awesome -->
    <link rel="stylesheet" href="css/font-awesome.css">
	<!-- Fancybox -->
	<link rel="stylesheet" href="css/jquery.fancybox.min.css">
	<!-- Themify Icons -->
    <link rel="stylesheet" href="css/themify-icons.css">
	<!-- Nice Select CSS -->
    <link rel="stylesheet" href="css/niceselect.css">
	<!-- Animate CSS -->
    <link rel="stylesheet" href="css/animate.css">
	<!-- Flex Slider CSS -->
    <link rel="stylesheet" href="css/flex-slider.min.css">
	<!-- Owl Carousel -->
    <link rel="stylesheet" href="css/owl-carousel.css">
	<!-- Slicknav -->
    <link rel="stylesheet" href="css/slicknav.min.css">
	
	<!-- Eshop StyleSheet -->
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/style.css">
 <link rel="stylesheet" href="css/responsive.css">
 <link rel="stylesheet" href="css/custom.css"></link>
</head>
<body class="js">
	
	<!-- Preloader
	<div class="preloader">
		<div class="preloader-inner">
			<div class="preloader-icon">
				<span></span>
				<span></span>
			</div>
		</div>
	</div>
	 End Preloader -->
	
	
	<!-- Header -->
	<header class="header shop">
		<!-- Topbar -->
		<div class="topbar">
			<div class="container">
				<div class="row">
					<div class="col-lg-5 col-md-12 col-12">
						<!-- Top Left -->
						<div class="top-left">
							<ul class="list-main">
								<li><i class="ti-headphone-alt"></i> +060 (800) 801-582</li>
								<li><i class="ti-email"></i> support@shophub.com</li>
							</ul>
						</div>
						<!--/ End Top Left -->
					</div>
					<div class="col-lg-7 col-md-12 col-12">
						<!-- Top Right -->
						<div class="right-content">
							<ul class="list-main">
								<li><i class="ti-location-pin"></i> Store location</li>
								<li><i class="ti-alarm-clock"></i> <a href="#">Daily deal</a></li>
								<li><i class="ti-user"></i> <a href="my_orders.php">My orders</a></li>
								<li><i class="ti-power-off">
											<?php 
if(isset($_SESSION['CUSTOMER_LOGIN']) && $_SESSION['CUSTOMER_LOGIN'] == "yes") {

					echo '<a href="customer_logout.php">Logout</a>';
					
}else{

	echo'<a href="customer_login.php">Login</a> | <a href="customer_registration.php">Register</a>';
	
} ?></i>
</li>
							</ul>
						</div>
						<!-- End Top Right -->
					</div>
				</div>
			</div>
		</div>
		<!-- End Topbar -->
		<div class="middle-inner">
			<div class="container">
				<div class="row">
					<div class="col-lg-2 col-md-2 col-12">
						<!-- Logo -->
						<div class="logo">
							<a href="home.php"><img src="images/logo.png" alt="logo"></a>
						</div>
						<!--/ End Logo -->
						<!-- Search Form -->
						<div class="search-top">
							<div class="top-search"><a href="#0"><i class="ti-search"></i></a></div>
							<!-- Search Form -->
							<div class="search-top">
								<form class="search-form">
									<input type="text" placeholder="Search here..." name="search">
									<button value="search" type="submit"><i class="ti-search"></i></button>
								</form>
							</div>
							<!--/ End Search Form -->
						</div>
						<!--/ End Search Form -->
						<div class="mobile-nav"></div>
					</div>
					<div class="col-lg-8 col-md-7 col-12">
						<div class="search-bar-top">
							<div class="search-bar">
								<select>
									<option selected="selected">All Category</option>
										<?php
$category_options = "select Id,Category from Categories where Status = 1 order by Category asc";

$main_category_options = mysqli_query($database_connection,$category_options);

	while($fetch_category = mysqli_fetch_array($main_category_options)){
	
						echo "<option value=".$fetch_category['Id'].">".$fetch_category['Category']."</option>";				
								
		}
										?>
								</select>
								<form action="search.php" method="get">
									<input name="search" placeholder="Search Products Here....." type="search">								
									<button class="btnn"><i class="ti-search"></i></button>
								</form>
							</div>
						</div>
					</div>
					<div class="col-lg-2 col-md-3 col-12">
						<div class="right-bar">
							<!-- Search Form -->
							<div class="sinlge-bar">
								<a href="#" class="single-icon"><i class="fa fa-user-circle-o" aria-hidden="true"></i></a>
							</div>
							<div class="sinlge-bar shopping">
<?php
if(isset($_SESSION['CUSTOMER_LOGIN'])) {
 ?>
			<a href="wishlists.php" class="single-icon"><i class="ti-heart"></i> <span class="total-count" id="total-wishlist-count"><?php echo $product_data_count_from_wishlist ?></span></a>
			<?php
 }
?>	
</div>
<div class="sinlge-bar shopping">
								<a href="cart.php" class="single-icon"><i class="ti-bag"></i> <span class="total-count"><?php echo $total_no_of_products ?></span></a>
								<!-- Shopping Item -->
								<div class="shopping-item">
									<div class="dropdown-cart-header">
<?php
$item_text = '';
if($total_no_of_products == 1){
			$item_text = 'ITEM';
}else{
			$item_text = 'ITEMS';
}
?>
										<span><?php echo $total_no_of_products ?>  <?php echo $item_text ?></span>
										<a href="cart.php">View Cart</a>
									</div>
									<ul class="shopping-list">
<?php 
$cart_value = 0;

foreach($_SESSION['cart'] as $product_key=>$value){ 

$product_details = get_products_data($database_connection,'','','',$product_key);

//Fetching Products Data
$product_id = $product_details[0]['Id'];
$product_name = $product_details[0]['Product_Name'];
$product_price = $product_details[0]['Product_Price'];
$product_image = $product_details[0]['Product_Image'];
$product_quantity = $value['quantity'];
$cart_value = $cart_value + ($product_price*$product_quantity);
?>											
										<li>
											<a href="javascript:void(0)" onclick="manage_cart('<?php echo $product_id ?>','remove')" class="remove" title="Remove this item"><i class="fa fa-remove"></i></a>
											<a class="cart-img" href="product_details.php?id=<?php echo $product_id ?>"><img src="../Media/Products/<?php echo $product_image ?>"></a>
											<h4><a href="product_details.php?id=<?php echo $product_id ?>"><?php echo $product_name ?></a></h4>
											<p class="quantity"><?php echo $product_quantity ?>x - <span class="amount"><?php echo $product_price ?></span></p>
										</li>
<?php } ?>
									</ul>
									<div class="bottom">
										<div class="total">
											<span>Total</span>
											<span class="total-amount"><?php echo $cart_value ?></span>
										</div>
										<a href="checkout.php" class="btn animate">Checkout</a>
									</div>
								</div>
								<!--/ End Shopping Item -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Header Inner -->
		<div class="header-inner">
			<div class="container">
				<div class="cat-nav-head">
					<div class="row">
						<div class="col-lg-9 col-12">
							<div class="menu-area">
								<!-- Main Menu -->
								<nav class="navbar navbar-expand-lg">
									<div class="navbar-collapse">	
										<div class="nav-inner">	
											<ul class="nav main-menu menu navbar-nav">
													<li class="active"><a href=" home.php">Home</a></li>
													<li><a href="#">Products</a></li>										
												 <li><a href="categories.php">Categories<i class="ti-angle-down"></i></a>
													<ul class="dropdown">
<?php
foreach($categories_data as $category){
?>
	<li><a href="categories.php?id=<?php echo $category['Id']?>"><?php echo $category['Category']?><i class="ti-angle-down"></i></a>
	
<?php
$category_id = $category['Id'];
  
$select_sub_category = mysqli_query($database_connection,"select * from Sub_Categories where Status='1' and Category='$category_id'");

if(mysqli_num_rows($select_sub_category) > 0) {
?>	
				<ul>
							<?php 
							while($fetch_sub_category = mysqli_fetch_array($select_sub_category)){
							?>
						 <li class="dropdown-item"><a href="categories.php?id=<?php echo $category['Id'].'&sub_category_id='.$fetch_sub_category['Id'] ?>"><?php echo $fetch_sub_category['Sub_Category'] ?></a></li>
<?php } ?>
				</ul>
<?php } ?>
 </li>
<?php } ?>


<?php  
while($fetch_sub_category = mysqli_fetch_array($select_sub_category)){
			echo '<li class="dropdown-item"><a href="categories.php?id='.$category['Id'].'&sub_category_id='.$fetch_sub_category['Id'].'">'.$fetch_sub_category['Sub_Category'].'</a></li>';
}
?>	



												
													</ul>
													</li>
															
													<li><a href="#">Service</a></li>
													<li><a href="#">Shop<i class="ti-angle-down"></i></a>
														<ul class="dropdown">
															<li><a href="cart.php">Cart</a></li>
															<li><a href="checkout.html">Checkout</a></li>
														</ul>
													</li>
													<li><a href="#">Pages</a></li>									
													<li><a href="#">Blog<i class="ti-angle-down"></i></a>
														<ul class="dropdown">
															<li><a href="blog-single-sidebar.html">Blog Single Sidebar</a></li>
														</ul>
													</li>
													<li><a href="contact_us.php">Contact Us</a></li>
												</ul>
										</div>
									</div>
								</nav>
								<!--/ End Main Menu -->	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--/ End Header Inner -->
	</header>
	<!--/ End Header -->
