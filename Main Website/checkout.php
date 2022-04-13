<?php  
require('header.php');

if(!isset($_SESSION['cart']) || count($_SESSION['cart'])==0){
	?>
	<script>
		window.location.href='cart.php';
	</script>
	<?php
}

if(!isset($_SESSION['CUSTOMER_LOGIN'])) {
			?>
	<script>	window.location.href='customer_login.php';
	</script>
	<?php
}

//Fetching Customers Information
$customer_id = $_SESSION['CUSTOMER_ID'];

$select_query = mysqli_query($database_connection,"select * from Customers where Id = $customer_id");

$fetch_customer_data = mysqli_fetch_array($select_query);

/*Fetching The Count Of Customers Addresses

$select_addresses = mysqli_query($database_connection,"select * from Saved_Addresses where Customer_Id = $customer_id");

$no_of_addresses = mysqli_num_rows($select_addresses);
*/

//Fetching Customers Address
$select_saved_address = mysqli_query($database_connection,"select * from Saved_Addresses where Customer_Id = $customer_id");

$fetch_customer_address = mysqli_fetch_array($select_saved_address);

if(isset($_SESSION['COUPON_CODE_ID'])) {
 			$coupon_code_id = $_SESSION['COUPON_CODE_ID'];
 			$coupon_code = $_SESSION['COUPON_CODE'];
 			$coupon_code_value = $_SESSION['COUPON_CODE_VALUE'];
 			$final_cart_value = $_SESSION['FINAL_CART_VALUE'];
 			
}

//Inseting The Data In To Orders Table And Adding The Address To Saved Addresses Table

if(isset($_POST['proceed_to_checkout'])) {

//Fetching Customers Details
$full_name = get_secure_value($database_connection,$_POST['full_name']);

$email_id = get_secure_value($database_connection,$_POST['email_id']);

$mobile_number = get_secure_value($database_connection,$_POST['mobile_number']);

$state = get_secure_value($database_connection,$_POST['state-province']);

$flat_no = get_secure_value($database_connection,$_POST['flat_no']);

$name_of_the_building = get_secure_value($database_connection,$_POST['name_of_the_building']);

$area_locality = get_secure_value($database_connection,$_POST['area_locality']);

$street_lane = get_secure_value($database_connection,$_POST['street_lane']);

$landmark = get_secure_value($database_connection,$_POST['landmark']);

$city = get_secure_value($database_connection,$_POST['city']);

$pincode = get_secure_value($database_connection,$_POST['pincode']);

$payment_type = get_secure_value($database_connection,$_POST['payment_type']);

$order_status = '1';

$order_date_time = date('Y-m-d H:i');

$payment_status = '1';

$shipping_order_id = 0;

$shipment_id = 0;

$customer_address = $flat_no.', '.$area_locality.', '.$street_lane.', '.$landmark.', '.$city.' - '.$pincode.', '.$state;

//Inserting Customer Address To The Saved Addresses Table

if(isset($_POST['save_addresses'])) {
  /*if($no_of_addresses > 5) {
  			
  }else{
  			$insert_into_saved_addresses = mysqli_query($database_connection,"insert into Saved_Addresses(Customer_Id,Flat_No,Area_Locality,Street_Lane,Landmark,City, Pincode,State) values('$customer_id','$flat_no', '$area_locality','$street_lane','$landmark','$city','$pincode','$state')");
  }*/
  
  $insert_into_saved_addresses = mysqli_query($database_connection,"insert into Saved_Addresses(Customer_Id,Flat_No,Name_Of_Building,Area_Locality,Street_Lane,Landmark,City, Pincode,State) values('$customer_id','$flat_no','$name_of_the_building', '$area_locality','$street_lane','$landmark','$city','$pincode','$state')");
 }

// Fetching Coupon Code If Applied
 
if(isset($_SESSION['COUPON_CODE_ID'])) {
 			$coupon_code_id = $_SESSION['COUPON_CODE_ID'];
 			$coupon_code = $_SESSION['COUPON_CODE'];
 			$coupon_code_value = $_SESSION['COUPON_CODE_VALUE'];
 			$final_cart_value = $_SESSION['FINAL_CART_VALUE'];
 			
unset($_SESSION['COUPON_CODE_ID']);
unset($_SESSION['COUPON_CODE']);
unset($_SESSION['COUPON_CODE_VALUE']);

 }else{
 
 			$coupon_code_id = 0;
 			$coupon_code = '';
 			$coupon_code_value = 0; 
 			$final_cart_value = $_SESSION['FINAL_CART_VALUE'];
 			
}
  
 $insert_into_orders = mysqli_query($database_connection,"insert into Orders(Customer_Id,Customer_Name,Customer_Email_Id,Customer_Mobile_Number,Customer_Address,Customer_City,Customer_State,Customer_Pincode,Payment_Type,Coupon_Code_Id,Coupon_Code,Coupon_Code_Value, Total_Price,Order_Status,Shipping_Order_Id,Shipment_Id, Payment_Status,Payment_Id,Transaction_Id,Order_Date_Time) values('$customer_id','$full_name','$email_id', '$mobile_number','$customer_address','$city','$state','$pincode','$payment_type','$coupon_code_id','$coupon_code','$coupon_code_value','$final_cart_value','$order_status','$shipping_order_id','$shipment_id','$payment_status','','','$order_date_time')");
 
 $order_id = mysqli_insert_id($database_connection);
 
 $_SESSION['ORDER_ID'] = $order_id;

 foreach($_SESSION['cart'] as $product_key=>$value){ 

$product_details = get_products_data($database_connection,'','','',$product_key);

//Fetching Products Data
$product_id = $product_details[0]['Id'];
$product_price = $product_details[0]['Product_Price'];
$product_quantity_sold = $value['quantity'];

$insert_into_order_details = mysqli_query($database_connection,"insert into Order_Details(Order_Id,Product_Id,Quantity,Price) values('$order_id','$product_id','$product_quantity_sold','$product_price')");
}
   
 unset($_SESSION['cart']);
 
if($payment_type == 'Razorpay'){
?>
  <script> 			window.location.href='pay_through_razorpay.php';
  </script>
  <?php      
}

if($payment_type == 'Instamojo'){
			$_SESSION['PHONE'] = $mobile_number;
			$_SESSION['BUYER_NAME'] = $customer_name;
			$_SESSION['EMAIL'] = $email_id;
			?>
  <script> 			window.location.href='pay_through_instamojo.php';
  </script>
  <?php   
}

if($payment_type == 'Cash On Delivery'){
			?>
  <script> 			window.location.href='order_summary.php';
  </script>
  <?php    
 }
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
								<li class="active"><a href="checkout.php">Checkout</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Breadcrumbs -->
				
		<!-- Start Checkout -->
		<section class="shop checkout section">
			<div class="container">
				<div class="row"> 
					<div class="col-lg-8 col-12">
						<div class="checkout-form">
							<h2>Make Your Checkout Here</h2>
							<!-- Form -->
							<form class="form" method="post">
								<div class="row">
									<div class="col-lg-6 col-md-6 col-12">
										<div class="form-group">
											<label>Full Name<span>*</span></label>
											<input type="text" id="full-name" name="full_name" placeholder="Enter your full name" required="required" value="<?php echo $fetch_customer_data['Name']?>">
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-12">
										<div class="form-group">
											<label>Email Id<span>*</span></label>
											<input type="email" name="email_id" id="email-id "placeholder="Enter your email id" required="required" value="<?php echo $fetch_customer_data['Email_Id']?>">
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-12">
										<div class="form-group">
											<label>Mobile Number<span>*</span></label>
											<input type="number" name="mobile_number" id="mobile-number" placeholder="Enter your mobile number" required="required" value="<?php echo $fetch_customer_data['Mobile_Number']?>">
										</div>
									</div>									
									<div class="col-lg-6 col-md-6 col-12">
										<div class="form-group">
											<label>Flat / Room No<span>*</span></label>
											<input type="text" name="flat_no" id="flat-no" placeholder="Enter your flat / room no" required="required" value="<?php echo $fetch_customer_address['Flat_No']?>">
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-12">
										<div class="form-group">
											<label>Name Of The Building /Plot No<span>*</span></label>
											<input type="text" name="name_of_the_building" id="name-of-building" placeholder="Enter your name of the building / plot no" required="required" value="<?php echo $fetch_customer_address['Name_Of_Building']?>">
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-12">
										<div class="form-group">
											<label>Area / Locality<span>*</span></label>
											<input type="text" name="area_locality" id="area-locality" placeholder="Enter your area / locality" required="required" value="<?php echo $fetch_customer_address['Area_Locality']?>">
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-12">
										<div class="form-group">
											<label>Street / Lane<span>*</span></label>
											<input type="text" name="street_lane" id="street-lane" placeholder="Enter your street / lane" required="required" value="<?php echo $fetch_customer_address['Street_Lane']?>">
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-12">
										<div class="form-group">
											<label>Landmark (Optional)<span>*</span></label>
											<input type="text" name="landmark" id="landmark" placeholder="Enter your nearest landmark" value="<?php echo $fetch_customer_address['Landmark']?>">
										</div>
									</div>					
									<div class="col-lg-6 col-md-6 col-12">
										<div class="form-group">
											<label>City<span>*</span></label>
											<input type="text" name="city" id="city "placeholder="Enter your city" value="<?php echo $fetch_customer_address['City']?>">
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-12">
										<div class="form-group">
											<label>State<span>*</span></label>
											<select id="state-province" name="state-province" id="state-province" value="<?php echo $fetch_customer_address['State']?>">
												<option value="Andhra Pradesh">Andhra Pradesh</option>
<option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
<option value="Arunachal Pradesh">Arunachal Pradesh</option>
<option value="Assam">Assam</option>
<option value="Bihar">Bihar</option>
<option value="Chandigarh">Chandigarh</option>
<option value="Chhattisgarh">Chhattisgarh</option>
<option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
<option value="Daman and Diu">Daman and Diu</option>
<option value="Delhi">Delhi</option>
<option value="Lakshadweep">Lakshadweep</option>
<option value="Puducherry">Puducherry</option>
<option value="Goa">Goa</option>
<option value="Gujarat">Gujarat</option>
<option value="Haryana">Haryana</option>
<option value="Himachal Pradesh">Himachal Pradesh</option>
<option value="Jammu and Kashmir">Jammu and Kashmir</option>
<option value="Jharkhand">Jharkhand</option>
<option value="Karnataka">Karnataka</option>
<option value="Kerala">Kerala</option>
<option value="Madhya Pradesh">Madhya Pradesh</option>
<option value="Maharashtra" selected="selected">Maharashtra</option>
<option value="Manipur">Manipur</option>
<option value="Meghalaya">Meghalaya</option>
<option value="Mizoram">Mizoram</option>
<option value="Nagaland">Nagaland</option>
<option value="Odisha">Odisha</option>
<option value="Punjab">Punjab</option>
<option value="Rajasthan">Rajasthan</option>
<option value="Sikkim">Sikkim</option>
<option value="Tamil Nadu">Tamil Nadu</option>
<option value="Telangana">Telangana</option>
<option value="Tripura">Tripura</option>
<option value="Uttar Pradesh">Uttar Pradesh</option>
<option value="Uttarakhand">Uttarakhand</option>
<option value="West Bengal">West Bengal</option>
											</select>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-12">
										<div class="form-group">
											<label>Pincode<span>*</span></label>
											<input type="text" name="pincode" id="pincode "placeholder="Enter your pincode" required="required" value="<?php echo $fetch_customer_address['Pincode']?>">
										</div>
									</div>
									<div class="col-12">
										<div class="form-group create-account">
											<input id="cbox" type="checkbox" name="save_addresses">
											<label>Save This Address</label>
										</div>
									</div>
								</div>
							<!--/ End Form -->
						</div>
					</div>
					
				<!--/ End Order Widget -->                      
					<div class="col-lg-4 col-12">
						<div class="order-details">
							<!-- Order Widget -->
<?php 
$subtotal_cart_value = 0;
$total_cart_value = 0;
$total_savings = 0;
$shipping_value = 0;
$total_cart_mrp = 0;

foreach($_SESSION['cart'] as $product_key=>$value){ 

$product_details = get_products_data($database_connection,'','','',$product_key);

//Fetching Products Data
$product_id = $product_details[0]['Id'];
$product_mrp = $product_details[0]['Product_MRP'];
$product_price = $product_details[0]['Product_Price'];
$product_quantity = $value['quantity'];

$subtotal_cart_value = $subtotal_cart_value + ($product_price*$product_quantity);

$total_cart_mrp = $total_cart_mrp +  ($product_mrp*$product_quantity);

$total_savings = $total_cart_mrp - $subtotal_cart_value;
}
?>
							<div class="single-widget">
								<h2>CART  TOTAL</h2>
								<div class="content">
									<ul>
										<li>Sub Total<span>Rs <?php echo $subtotal_cart_value ?></span></li>
										<li>You Save<span>Rs <?php echo $total_savings ?></span></li>

<?php  										
				if($coupon_code_id == '') {
				$_SESSION['FINAL_CART_VALUE'] = $subtotal_cart_value;
?>
					<li class="last" name="total_cart_value">Cart Total<span>Rs <?php echo $subtotal_cart_value ?></span></li>
<?php
				}else{
?>
				<li>Coupon Code Value<span>Rs <?php echo $coupon_code_value ?></span></li>
						<li class="last" name="total_cart_value">Cart Total<span>Rs <?php echo $final_cart_value ?></span></li>
<?php
}
?>
									</ul>
								</div>
							</div>
							<!--/ End Order Widget -->
							<!-- Order Widget -->
							<div class="single-widget">
								<h2>Payments</h2>
								<div class="content">
									<div class="checkbox">
										<input name="payment_type" type="radio" value="Cash On Delivery"> Cash On Delivery
										<input name="payment_type" type="radio" value="Razorpay"> Razorpay
										<input name="payment_type" type="radio" value="Instamojo"> Instamojo
									</div>
								</div>
							</div>
							<!--/ End Order Widget -->
							<!-- Payment Method Widget -->
							<div class="single-widget payement">
								<div class="content">
									<img src="images/payment-method.png" alt="#">
								</div>
							</div>
							<!--/ End Payment Method Widget -->
							<!-- Button Widget -->
							<div class="single-widget get-button">
								<div class="content">
									<div class="button">
										<button class="btn" name="proceed_to_checkout" id="proceed_to_checkout">Proceed To Checkout</button>
									</div>
								</div>
							</div>
							<!--/ End Button Widget -->
						</div>
					</div>
				</div>
			</div>
		</form>
	</section>
		<!--/ End Checkout -->
		
		<!-- Start Shop Services Area  -->
		<section class="shop-services section home">
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
		<!-- End Shop Services -->
		
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
