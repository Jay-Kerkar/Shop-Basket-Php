<?php 
require('header.php');

if(isset($_SESSION['CUSTOMER_LOGIN']) && $_SESSION['CUSTOMER_LOGIN']=='yes') {
			?>
			<script>	window.location.href='home.php';	
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
							<li class="active"><a href="customer_login.php">Login</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->
  
	<!-- Start Login Form -->
	<section id="contact-us" class="contact-us section">
		<div class="container">
				<div class="contact-head">
					<div class="row">
						<div class="col-lg-8 col-12">
							<div class="form-main">
								<div class="title">
									<h4>Login to get more exciting offers,</h4>
									<h3>Just fill the form below</h3>
								</div>
								<form class="form" method="post">
									<div class="row">
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Your Email Id<span>*</span></label>
												<input id="email_id" name="email_id" type="email" placeholder="Enter your email id " required>
												<div class="field_error" id="email_id_error"></div>
											</div>	
										</div>
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Your Password<span>*</span></label>
												<input id="password" name="password" type="password" placeholder="Enter your password" required>
												<div class="field_error" id="password_error"></div>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group button">
												<button type="button" class="btn" id="proceed_to_login" name="proceed_to_login" onclick="customer_login()">Proceed To Login</button>
											</div>
										</div>
									</div>
									<div class="field_error" id="login_error"></div>
								</form>
							</div>
						</div>
					<!-- End Login Form -->
	<script>
				function customer_login(){

	var email_id = jQuery("#email_id").val();
	var password = jQuery("#password").val();

    jQuery.ajax({
        url:'login.php',
		type:'post',			
        data:'email_id='+email_id+'&password='+password,
        success:function(result){
            if(result=='Customer Logged In Successfully'){
				window.location.href='home.php';
            }else if(result=='Failed To Login Customer'){					
                jQuery('#login_error').html('Please, Enter Correct Login Credentials');
			}
        }
    });
}

	</script>
<?php 
require('footer.php');
?>
