<?php
require('header.php');

$main_heading = '';
$sub_heading = '';
$button_text = '';
$button_link = '';
$banner_image = '';
$error_message = '';
$image_validator = 'required';

$type = get_secure_value($database_connection,$_GET['type']);

if($type=='edit'){
			$card_header = 'Edit Banner';
			$button_value = 'Proceed To Edit Banner';
			$error_type = '$type';
}else {
			$card_header = 'Add Banner';
			$button_value = 'Proceed To Add Banner';
			$error_type = '$type';
}

if(isset($_GET['id']) && $_GET['id']!=''){
$image_validator = '';

$Id = get_secure_value($database_connection,$_GET['id']);
	
$select_banner = "select * from Banners where Id='$Id'";

$main_select_banner = mysqli_query($database_connection,$select_banner);

$fetch_banner_data = mysqli_fetch_array($main_select_banner);

$validate_banner = mysqli_num_rows($main_select_banner);

if($validate_banner > 0){
			$main_heading = $fetch_banner_data['Main_Heading'];
			$sub_heading = $fetch_banner_data['Sub_Heading'];
			$button_text = $fetch_banner_data['Button_Text'];
			$button_link = $fetch_banner_data['Button_Link'];
			$banner_image = $fetch_banner_data['Banner_Image'];
}else{
			redirect_page('banners.php');
}

}

if(isset($_POST['submit'])){
$main_heading = get_secure_value($database_connection,$_POST['main_heading']);

$sub_heading = get_secure_value($database_connection,$_POST['sub_heading']);

$button_text = get_secure_value($database_connection,$_POST['button_text']);

$button_link = get_secure_value($database_connection,$_POST['button_link']);

if(isset($_FILES['banner_image'])) {
	if($_FILES['banner_image']['type']!='') {
				if($_FILES['banner_image']['type']!='image/png' && $_FILES['banner_image']['type']!='image/jpg' && $_FILES['banner_image']['type']!='image/jpeg') {
						$error_message = "Failed To Add / Edit The Banner ($main_heading) Because The Banner Image Is Not In The Format Of (PNG, JPG, JPEG)";
						}
			}			
}

if(isset($type) && $type == 'add'){
			$banner_validation_query = mysqli_query($database_connection,"select * from Banners where Main_Heading='$main_heading' and Sub_Heading='$sub_heading'");
			
			if(mysqli_num_rows($banner_validation_query) > 0){
						$error_message = "Failed To Add / Edit The Banner ($main_heading) Because The Banner Already Exists";
			}
}

if($error_message == ''){
			if(isset($_GET['id']) && $_GET['id']!=''){
						if($_FILES['banner_image']['name']!=''){
						$banner_image  = rand(111111111,999999999).'_'.$_FILES['banner_image']['name'];
			move_uploaded_file($_FILES['banner_image']['tmp_name'],'../Media/Banners/'.$banner_image);
			
			$update_banner = "update Banners set Main_Heading='$main_heading',Sub_Heading='$sub_heading',Button_Text='$button_text',Button_Link='$button_link',Banner_Image='$banner_image' where Id='$Id'";
									}else{
			$update_banner = "update Banners set Main_Heading='$main_heading',Sub_Heading='$sub_heading',Button_Text='$button_text',Button_Link='$button_link' where Id='$Id'";					
									}

			$main_update_banner = mysqli_query($database_connection,$update_banner);
									}else{
												
						$banner_image  = rand(111111111,999999999).'_'.$_FILES['banner_image']['name'];

move_uploaded_file($_FILES['banner_image']['tmp_name'],'../Media/Banners/'.$banner_image);

			$insert_banner = "insert into Banners(Main_Heading,Sub_Heading,Button_Text,Button_Link,Banner_Image,Status) values('$main_heading','$sub_heading','$button_text','$button_link','$banner_image','1')";

			$main_insert_banner = mysqli_query($database_connection,$insert_banner);																												
						}
						redirect_page('banners.php');
			}
}
?>

<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong><?php echo $card_header ?></strong></div>
                        <form method="post" enctype="multipart/form-data">
							<div class="card-body card-block">
							   <div class="form-group">
									<label for="Banners" class=" form-control-label">Main Heading</label>
									<input type="text" name="main_heading" placeholder="Enter Banner's Main Heading" class="form-control" required value="<?php echo $main_heading ?>">
									
								</div>
								<div class="form-group">
									<label for="Banners" class=" form-control-label">Sub Heading</label>
									<input type="text" name="sub_heading" placeholder="Enter Banner's Sub Heading" class="form-control" required value="<?php echo $sub_heading ?>">
									
								</div>
								<div class="form-group">
									<label for="Banners" class=" form-control-label">Button Text</label>
									<input type="text" name="button_text" placeholder="Enter Banner's Button Text" class="form-control" value="<?php echo $button_text ?>">
									
								</div>
								<div class="form-group">
									<label for="Banners" class=" form-control-label">Button Link</label>
									<input type="text" name="button_link" placeholder="Enter Banner's Button Link" class="form-control" value="<?php echo $button_link ?>">
									
								</div>
								<div class="form-group">
									<label for="Banners" class=" form-control-label">Banner Image</label>
									<input type="file" name="banner_image" class="form-control" <?php echo $image_validator ?>>
									
									<?php  
												if($banner_image!='') {
															echo "<div class='banner_image'><a target='_blank' href='".BANNER_IMAGE_SITE_PATH.$banner_image."'><img width='200px' src='".BANNER_IMAGE_SITE_PATH.$banner_image."'/></a></div>";
												}
									?>
								</div>
							   <button id="payment-button" name="submit" type="submit" class="btn btn-lg btn-info btn-block">
							   <span id="payment-button-amount"><?php echo $button_value ?></span>
							   </button>
							   <div class="field_error"><?php echo $error_message ?></div>
							</div>
						</form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
<?php
require('footer.php');
?>
