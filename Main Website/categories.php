<?php 
require('header.php');

$default_sorting = 'selected';
$price_low_to_high = '';
$price_high_to_low = '';
$price_latest_first = '';
$price_oldest_first = '';
$sub_category_id = '';

$category_id = get_secure_value($database_connection,$_GET['id']);

if(isset($_GET['sub_category_id'])){
$sub_category_id = get_secure_value($database_connection,$_GET['sub_category_id']);
}

$select_category = "select * from Categories where Id = '$category_id' and Status = 1";

$main_select_category =  mysqli_query($database_connection,$select_category);

$fetch_category_data = mysqli_fetch_array($main_select_category);

if(isset($_GET['sorting_condition'])) {

			$sorting_condition = get_secure_value($database_connection,$_GET['sorting_condition']);
			
			if($sorting_condition == "price_low_to_high") {
						$sorting_order = " order by Products.Product_Price asc ";
						$price_low_to_high = 'selected';
						$default_sorting = '';
			}			
			
			if($sorting_condition == "price_high_to_low") {
						$sorting_order = " order by Products.Product_Price desc ";
						$price_high_to_low = 'selected';
						$default_sorting = '';
			}			
			
			if($sorting_condition == "latest_first") {
						$sorting_order = " order by Products.Id desc ";
						$latest_first = 'selected';
						$default_sorting = '';
			}

			if($sorting_condition == "oldest_first") {
						$sorting_order = " order by Products.Id asc ";
						$oldest_first = 'selected';
						$default_sorting = '';
			}

}

if($category_id > 0) {
			$get_products_data = get_products_data($database_connection,'','',$category_id,'','',$sorting_order,$sub_category_id);
}else{
   redirect_Page('home.php');
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
							<li class="active"><a href="categories.php"><?php echo $fetch_category_data['Category']?></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->
	
<div class="form-group">
			<select id="sorting_condition" onchange="sort_products('<?php echo $category_id ?>')">
										<option <?php echo $default_sorting ?> >Default Sorting</option>
										<option value="price_low_to_high" <?php echo $price_low_to_high ?> >Sort By Price Low To High</option>
										<option value="price_high_to_low" <?php echo $price_high_to_low ?> >Sort By Price High To Low</option>
										<option value="latest_first" <?php echo $latest_first ?> >Sort By Latest First</option>
										<option value="oldest_first" <?php echo $oldest_first ?> >Sort By Oldest First</option>
			</select>
</div>
									
	<!-- Start Categories Area -->
<div class="product-area section">
  <div class="container">
				<div class="row">
					<div class="col-12">
						<div class="section-title">
							<h2>Categories</h2>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<div class="product-info">
							<div class="nav-main">
								<!-- Tab Nav -->
								<ul class="nav nav-tabs" id="myTab" role="tablist">

<?php
foreach($categories_data as $category){
?>			
								<li class="nav-item"><a href="?id=<?php echo $category['Id'] ?>" class="nav-link active" data-toggle="tab"  role="tab"><?php echo $category['Category']?></a></li>	
<?php } ?> 
								</ul>
								<!--/ End Tab Nav -->
							</div>
							<div class="tab-content" id="myTabContent">
										<!-- Start Single Tab -->
								<div class="tab-pane fade show active" id="man" role="tabpanel">
									<div class="tab-single">
										<div class="row">
													
<?php 
if(count($get_products_data) > 0){
			foreach($get_products_data as $products_data){
					 								 
$no_of_products_quantity_sold = no_of_products_quantity_sold($database_connection,$products_data['Id']);

$total_no_of_products_quantity = total_no_of_products_quantity($database_connection,$products_data['Id']);

$no_of_products_quantity_remaining = $total_no_of_products_quantity - $no_of_products_quantity_sold;
             if($no_of_products_quantity_remaining > 0) {
             
$stock_message = '';      			if($products_data['Best_Seller'] == 1) 			{
   $best_seller = '<span class="out-of-stock">Best Seller</span>';    						
			}else {
   $best_seller = '';    						
			}
}else{
   $stock_message = '<span class="out-of-stock">Out Of Stock</span>';
}				
?>											

									<div class="col-xl-3 col-lg-4 col-md-4 col-10">
												<div class="single-product">
													<div class="product-img">
														<a href="product_details.php?id=<?php echo $products_data['Id']?>">
															<img class="default-img" src="<?php echo PRODUCT_MAIN_IMAGE_SITE_PATH.$products_data['Product_Image']?>" alt="#">
															<img class="hover-img" src="<?php echo PRODUCT_MAIN_IMAGE_SITE_PATH.$products_data['Product_Image']?>" alt="#">
										<?php echo $stock_message; ?>
										<?php echo $best_seller; ?>
														</a>
														<div class="button-head">
															<div class="product-action">
																<a data-toggle="modal" data-target="#exampleModal" title="Buy Now" href="product_details.php?id=<?php echo $products_data['Id'] ?>"><i class=" ti-eye"></i><span>Buy Now</span></a>
                           <a title="Wishlist" href="product_details.php?id=<?php echo $products_data['Id'] ?>"><i class=" ti-heart "></i><span>Add To Wishlist</span></a>
                        </div>
                        <div class="product-action-2">
                           <a title="Add To cart" href="product_details.php?id=<?php echo $products_data['Id'] ?>">Add To cart</a>
															</div>
														</div>
													</div>
													<div class="product-content">
														<h3><a href="product_details.php?id=<?php echo $products_data['Id']?>"><?php echo $products_data['Product_Name']?></a>
														</h3>
														<div class="product-price">
															<p class="price with-discount">Price : <?php echo $products_data['Product_Price']?></p>
														</div>
													</div>
												</div>
											</div>
						<!-- End Categories Area -->			
						<?php 
						 } 
					 }else{
					 	echo '<br>
					 	<div class="row">
					<div class="col-12">
						<div class="section-title">
							<h2>Sorry Failed To Fetch Products Data</h2>
						</div>
					</div>
				</div>';
					 }
						?>
						
<?php 
require('footer.php');
?>		
