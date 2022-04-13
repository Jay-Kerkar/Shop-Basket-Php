<?php
require('header.php');
?>

<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="home.php">Home<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="cart.php">Cart</a></li>
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
								<th>PRICE</th>
								<th>QUANTITY</th>
								<th>TOTAL</th> 
								<th><i class="ti-trash remove-icon"></i></th>
							</tr>
						</thead>
					<tbody>

<?php 
			$subtotal_cart_value = 0;
			$total_cart_value = 0;
			$total_savings = 0;
			$shipping_value = 0;
			$total_cart_mrp = 0;


if(isset($_SESSION['cart'])){
			foreach($_SESSION['cart'] as $product_key => $value){ 
			
foreach($value as $key => $value_2){			
			$select_product_attribute = mysqli_fetch_array(mysqli_query($database_connection, "select Product_Attributes.*, Colors.Color, Sizes.Size from Product_Attributes left join Colors on Product_Attributes.Product_Color = Colors.Id and Colors.Status = 1 left join Sizes on Product_Attributes.Product_Size = Sizes.Id and Sizes.Status = 1 where Product_Attributes.Id = '$key'"));

			$product_details = get_products_data($database_connection,'','','',$product_key,'','','',$key);
			

//Fetching Products Data
			$product_id = $product_details[0]['Id'];
			$product_name = $product_details[0]['Product_Name'];
			$product_mrp = $product_details[0]['Product_MRP'];
			$product_price = $product_details[0]['Product_Price'];
			$product_image = $product_details[0]['Product_Image'];
			$product_quantity = $value_2['quantity'];

			$subtotal_cart_value = $subtotal_cart_value + ($product_price * $product_quantity);

			$total_cart_mrp = $total_cart_mrp +  ($product_mrp * $product_quantity);

			$total_cart_value = ($subtotal_cart_value + $shipping_value);

			$total_savings = ($total_cart_mrp - $subtotal_cart_value);
?>
							<tr>
								<td class="image" data-title="No">
											<a target="_blank" href="<?php echo PRODUCT_MAIN_IMAGE_SITE_PATH.$product_image ?>">
											<img src="<?php echo PRODUCT_MAIN_IMAGE_SITE_PATH.$product_image ?>"></td>
											</a>
								<td class="product-des" data-title="Description">
									<p class="product-name"><a target="_blank" href="product_details.php?id=<?php echo $product_id ?>"><?php echo $product_name ?></a></p>
									<?php  
if(isset($select_product_attribute['Color']) && $select_product_attribute['Color']!=''){
			echo "<span>Color : ".$select_product_attribute['Color']."</span>";
			echo '<br>';
}

if(isset($select_product_attribute['Size']) && $select_product_attribute['Size']!=''){
			echo "<span>Size : ".$select_product_attribute['Size']."</span>";
}
									?>
								</td>
								<td data-title="Price"><span style="margin-top:37px;"><?php echo $product_price ?></span></td>
								<td class="qty" data-title="Qty">
											<!-- Input Order -->
									<div class="input-group">
										<div class="button minus">
											<button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
												<i class="ti-minus"></i>
											</button>
										</div>
										<input type="number" id="<?php echo $product_id ?>quantity" name="quant[1]" class="input-number"  data-min="1" data-max="100" value="<?php echo $product_quantity ?>">
										<div class="button plus">
											<button type="button"  class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]">													
												<i class="ti-plus"></i>
											</button>
										</div>
										<a style="cursor:pointer;color:#F7941D;margin-left:58px;" href="javascript:void(0)" onclick="manage_cart('<?php echo $product_id ?>','update')">Update</a>
									</div>
									<!--/ End Input Order -->
								</td>
								<td class="total-amount" data-title="Total"><span><?php echo $product_price * $product_quantity ?></span></td>
								<td class="action" data-title="Remove"><a href="javascript:void(0)" onclick="manage_cart('<?php echo $product_id ?>','remove')"><i class="ti-trash remove-icon"></i></a></td>
							</tr>
							<?php 
													}
										}
							}
							?>
						</tbody>
					</table>
					<!--/ End Shopping Summery -->
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<!-- Total Amount -->
					<div class="total-amount">
						<div class="row">
							<div class="col-lg-8 col-md-5 col-12">
								<div class="left">
									<div class="coupon">
											<input type="text" name="coupon_code" id="coupon_code" placeholder="Enter Your Coupon Code">
											<button class="btn" onclick="apply_coupon_code()">Apply Coupon Code</button>
									</div>
<div id="coupon_code_result"></div>
									<div class="checkbox">
										<label class="checkbox-inline" for="2"><input name="news" id="2" type="checkbox"> Shipping (+10$)</label>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-7 col-12">
								<div class="right">
									<ul>
										<li>Cart Subtotal : <span>Rs <?php echo $subtotal_cart_value ?></span></li>
										<li>Shipping : <span>Rs <?php echo $shipping_value ?></span></li>
										<li>You Save : <span>Rs <?php echo $total_savings ?></span></li>
										<li style="display:none;" id="coupon_code_value_box">Coupon Code Value : <span id="coupon_code_value"></span></li>
										<li class="last">You Pay : <span id="cart_total_value">Rs <?php echo $total_cart_value ?></span></li>
									</ul>
		
									<div class="button5">
										<a href="checkout.php" class="btn">Checkout</a>
										<a href="home.php" class="btn">Continue shopping</a>
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
	
<script>
function apply_coupon_code() {
			let coupon_code = jQuery('#coupon_code').val();
 
			if(coupon_code = '') {
jQuery('#coupon_code_result').html("Please Enter A Valid Coupon Code");
			}else { 
jQuery('#coupon_code_result').html('');
	
			jQuery.ajax({
						url: 'apply_coupon_code.php',
						type: 'post',
						data: 'coupon_code='+coupon_code,
						success: function(result) {
									let data = jQuery.parseJSON(result);

									if(data.coupon_code_error == 'yes') {
jQuery('#coupon_code_value_box').hide();
jQuery('#coupon_code_result').html(data.result);
									}

									if(data.coupon_code_error == 'no') {
jQuery('#coupon_code_value_box').show();
jQuery('#coupon_code_value').html(data.coupon_code_value);
jQuery('#cart_total_value').html(data.final_cart_value);
jQuery('#coupon_code_result').html(data.result);
						}
			 }
		});
	}
}
</script>

<?php 
require('footer.php');
?>
