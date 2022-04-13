<?php 
require('header.php');

if(isset($_POST['send_message'])) {
			
$name = get_secure_value($database_connection,$_POST['name']);

$email_id = get_secure_value($database_connection,$_POST['email_id']);

$mobile_number = get_secure_value($database_connection,$_POST['mobile_number']);

$type_of_message = get_secure_value($database_connection,$_POST['type_of_message']);

$subject = get_secure_value($database_connection,$_POST['subject']);

$message = get_secure_value($database_connection,$_POST['message']);

$registration_period = date('Y-m-d h:i:s A');

$insert_query = "insert into Complaints_Suggestions(Name,Email_Id,Mobile_Number,Type_Of_Message,Subject,Message,Registration_Date_Time) values('$name','$email_id','$mobile_number','$type_of_message','$subject','$message','$registration_period')";

$main_insert_query = mysqli_query($database_connection,$insert_query);

if($main_insert_query) {
			
			$contact_us_sucess_message = 'Congratulations, Your Message Has Been Send Successfully.';
			
}else{
			
			$contact_us_error_message = 'Sorry, Failed To Send Your Message.';
			
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
							<li class="active"><a href="contact_us.php">Contact Us</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->
  
	<!-- Start Contact -->
	<section id="contact-us" class="contact-us section">
		<div class="container">
				<div class="contact-head">
					<div class="row">
						<div class="col-lg-8 col-12">
							<div class="form-main">
								<div class="title">
									<h4>Get in contact with us</h4>
									<h3>Write us a message</h3>
								</div>
								<form class="form" method="post">
									<div class="row">
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Your Name<span>*</span></label>
												<input name="name" type="text" placeholder="Enter your name" required>
											</div>
										</div>
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Your Email Id<span>*</span></label>
												<input name="email_id" type="email" placeholder="Enter your email id" required>
											</div>	
										</div>
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Your Mobile<span>*</span></label> 
												<input name="mobile_number" type="number" placeholder=" Enter your mobile number" required>
											</div>	
										</div>
										<div class="col-lg-5 col-10">
											<div class="form-group">
														<label>Type Of Message<span>*</span></label>
										<select name="type_of_message" required>
										<option selected="selected">Select Type Of Message</option>
										<option>Complaint</option>
										<option>Sugesstion</option>
									</select>
									</div>
										</div>
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Your Subject<span>*</span></label>
												<input name="subject" type="text" placeholder="Enter your subject" required>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group message">
												<label>Your Message<span>*</span></label>
												<textarea name="message" placeholder="Enter your message" required></textarea>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group button">
												<button type="submit" class="btn" name="send_message">Send Message</button>
											</div>
										</div>
									</div>
<div class="field_sucess" style="color:#F7941D;
	margin-top:20px;"><?php echo $contact_us_sucess_message ?></div>
<div class="field_error" style="color:red;
	margin-top:20px;"><?php echo $contact_us_error_message ?></div>
								</form>
							</div>
						</div>
						<div class="col-lg-4 col-12">
							<div class="single-head">
								<div class="single-info">
									<i class="fa fa-phone"></i>
									<h4 class="title">Call us Now:</h4>
									<ul>
										<li>+123 456-789-1120</li>
										<li>+522 672-452-1120</li>
									</ul>
								</div>
								<div class="single-info">
									<i class="fa fa-envelope-open"></i>
									<h4 class="title">Email:</h4>
									<ul>
										<li><a href="mailto:info@yourwebsite.com">info@yourwebsite.com</a></li>
										<li><a href="mailto:info@yourwebsite.com">support@yourwebsite.com</a></li>
									</ul>
								</div>
								<div class="single-info">
									<i class="fa fa-location-arrow"></i>
									<h4 class="title">Our Address:</h4>
									<ul>
										<li>KA-62/1, Travel Agency, 45 Grand Central Terminal, New York.</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	</section>
	<!--/ End Contact -->
	
	<!-- Map Section -->
	<div class="map-section">
		<div id="myMap"></div>
	</div>
	<!--/ End Map Section -->
	
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
