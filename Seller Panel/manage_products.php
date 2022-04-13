<?php
require('header.php');

$product_category = '';
$product_sub_category = '';
$product_name = '';
$product_image = '';
$product_images = [];
$product_overview	= '';
$product_details = '';
$product_length = '';
$product_breadth = '';
$product_height = '';
$product_weight = '';	
$best_seller	= '';
$meta_title	= '';
$meta_description	= '';
$meta_keywords = '';
$product_attributes[0]['Product_Id'] = '';
$product_attributes[0]['Product_Color'] = '';
$product_attributes[0]['Product_Size'] = '';
$product_attributes[0]['Product_Price'] = '';
$product_attributes[0]['Product_MRP'] = '';
$product_attributes[0]['Product_Quantity'] = '';
$product_attributes[0]['Attribute_Id'] = '';

$error_message = '';
$validator = 'required';

$type = get_secure_value($database_connection,$_GET['type']);

if($type=='edit'){
			$card_header = 'Edit Product';
			$button_value = 'Proceed To Edit Product';
}else {
			$card_header = 'Add Product';
			$button_value = 'Proceed To Add Product';
}

if(isset($_GET['image_id']) && $_GET['image_id'] > 0) {
			$image_id = get_secure_value($database_connection,$_GET['image_id']);
			
			$delete_image = mysqli_query($database_connection,"delete from Product_Images where Id='$image_id'");
}

if(isset($_GET['id']) && $_GET['id']!=''){
 $validator = '';

	$Id = get_secure_value($database_connection,$_GET['id']);
	
	$select_product_for_updation = "select * from Products where Id = '$Id'";
	
	$main_select_product_for_updation = mysqli_query($database_connection,$select_product_for_updation);
	
	$product_validator_for_updation = mysqli_num_rows($main_select_product_for_updation);
	
if($product_validator_for_updation > 0){
		$fetch_product_data_for_updation = mysqli_fetch_array($main_select_product_for_updation);
		
		$product_category = $fetch_product_data_for_updation['Product_Category'];
		
		$product_sub_category = $fetch_product_data_for_updation['Product_Sub_Category'];
		
		$product_name = $fetch_product_data_for_updation['Product_Name'];
		
		$product_image = $fetch_product_data_for_updation['Product_Image'];

		$product_overview = $fetch_product_data_for_updation['Product_Overview'];
		
		$product_details = $fetch_product_data_for_updation['Product_Details'];
		 
		$product_length = $fetch_product_data_for_updation['Product_Length'];
		
		$product_breadth = $fetch_product_data_for_updation['Product_Breadth'];
		
		$product_height = $fetch_product_data_for_updation['Product_Height'];
		
		$product_weight = $fetch_product_data_for_updation['Product_Weight'];
		
		$best_seller = $fetch_product_data_for_updation['Best_Seller'];
		
		$meta_title = $fetch_product_data_for_updation['Meta_Title'];
		
		$meta_description = $fetch_product_data_for_updation['Meta_Description'];
		
		$meta_keywords = $fetch_product_data_for_updation['Meta_Keywords'];
		
		//Fetching Product Multiple Images
		$product_multiple_images = mysqli_query($database_connection,"select * from Product_Images where Product_Id = '$Id'");
		if(mysqli_num_rows($product_multiple_images) > 0) {
			$loop_count = 0;
								while($fetch_product_multiple_images = mysqli_fetch_array($product_multiple_images)){
							
								$product_images[$loop_count]['Id'] = $fetch_product_multiple_images['Id'];
								
								$product_images[$loop_count]['Product_Images'] = $fetch_product_multiple_images['Product_Images'];
								
								$loop_count++;
					}
		}

		//Fetching Product Multiple Attributes
		$product_multiple_attributes = mysqli_query($database_connection,"select * from Product_Attributes where Product_Id='$Id'");
		
		$loop_count = 0;
								while($fetch_product_multiple_attributes = mysqli_fetch_array($product_multiple_attributes)){
								$product_attributes[$loop_count]['Product_Id'] = $fetch_product_multiple_attributes['Product_Id'];
															$product_attributes[$loop_count]['Product_Color'] = $fetch_product_multiple_attributes['Product_Color'];
								$product_attributes[$loop_count]['Product_Size'] = $fetch_product_multiple_attributes['Product_Size'];
								
								$product_attributes[$loop_count]['Product_Price'] = $fetch_product_multiple_attributes['Product_Price'];
								$product_attributes[$loop_count]['Product_MRP'] = $fetch_product_multiple_attributes['Product_MRP'];
								
								$product_attributes[$loop_count]['Product_Quantity'] = $fetch_product_multiple_attributes['Product_Quantity'];
											$product_attributes[$loop_count]['Attribute_Id'] = $fetch_product_multiple_attributes['Id'];
								
								$loop_count++;
				}
	}else{
	
		redirect_page('products.php');
		
	}
}

if(isset($_POST['submit'])){

	$product_category = get_secure_value($database_connection,$_POST['product_category']);
	
	$product_sub_category = get_secure_value($database_connection,$_POST['product_sub_category']);
	
	$product_name = get_secure_value($database_connection,$_POST['product_name']);

 $product_overview = get_secure_value($database_connection,$_POST['product_overview']);

 $product_details = get_secure_value($database_connection,$_POST['product_details']);

 $product_length = get_secure_value($database_connection,$_POST['product_length']);

 $product_breadth = get_secure_value($database_connection,$_POST['product_breadth']);

 $product_height = get_secure_value($database_connection,$_POST['product_height']);

 $product_weight = get_secure_value($database_connection,$_POST['product_weight']);

 $best_seller = get_secure_value($database_connection,$_POST['best_seller']);

 $meta_title = get_secure_value($database_connection,$_POST['meta_title']);

 $meta_description = get_secure_value($database_connection,$_POST['meta_description']);

 $meta_keywords = get_secure_value($database_connection,$_POST['meta_keywords']);
	
	$select_product = "select * from Products where Product_Name = '$product_name'";
	
	$main_select_product = mysqli_query($database_connection,$select_product);
	
	$product_validator = mysqli_num_rows($main_select_product);
	
	if($product_validator){
	
		if(isset($_GET['id']) && $_GET['id']!=''){
		
			$fetch_product_data = mysqli_fetch_array($main_select_product);
			if($Id == $fetch_product_data['Id']){
			
			}else{
				$error_message = "Failed To Add / Edit The Product ($product_name) Because The Product Already Exists";
			}
		}else{	
			$error_message = "Failed To Add / Edit The Product ($product_name) Because The Product Already Exists";
		}
}

if(isset($_FILES['product_image'])) {
	if($_FILES['product_image']['type']!='') {
				if($_FILES['product_image']['type']!='image/png' && $_FILES['product_image']['type']!='image/jpg' && $_FILES['product_image']['type']!='image/jpeg') {
			
						$error_message = "Failed To Add / Edit The Product ($product_name) Because The Main Image Is Not In The Format Of (PNG, JPG, JPEG)";
						}
			}			
}
			
if(isset($_FILES['product_images'])) {
			foreach($_FILES['product_images']['type'] as $key=>$value){
			if($_FILES['product_images']['type'][$key]!=''){
						if($_FILES['product_images']['type'][$key]!='image/png' && $_FILES['product_images']['type'][$key]!='image/jpg' && $_FILES['product_images']['type'][$key]!='image/jpeg') {
			
			$error_message = "Failed To Add / Edit The Product ($product_name) Because The Sub Image Is Not In The Format Of (PNG, JPG, JPEG)";
									}
						}					
			}
}

if($error_message == ''){

		if(isset($_GET['id']) && $_GET['id']!=''){
		
		if($_FILES['product_image']['name']!=''){
		$product_image  = rand(111111111,999999999).'_'.$_FILES['product_image']['name'];
			move_uploaded_file($_FILES['product_image']['tmp_name'],'../Media/Products/Product_Main_Images/'.$product_image);
		
		$update_product = "update Products set Product_Category='$product_category',Product_Name='$product_name',Product_Overview='$product_overview',Product_Details='$product_details',Product_Length='$product_length' ,Product_Breadth='$product_breadth',Product_Height='$product_height',Product_Weight='$product_weight',Best_Seller='$best_seller',Meta_Title='$meta_title',Meta_Description='$meta_description',Meta_Keywords='$meta_keywords',Product_Image='$product_image',Product_Sub_Category='$product_sub_category' where Id='$Id'";
		
		}else{
					
	$update_product = "update Products set Product_Category='$product_category',Product_Name='$product_name',Product_Overview='$product_overview',Product_Details='$product_details',Product_Length='$product_length' ,Product_Breadth='$product_breadth',Product_Height='$product_height',Product_Weight='$product_weight',Best_Seller='$best_seller',Meta_Title='$meta_title',Meta_Description='$meta_description',Meta_Keywords='$meta_keywords',Product_Sub_Category='$product_sub_category' where Id='$Id'";
					
		}
		
		$main_update_product = mysqli_query($database_connection,$update_product);
		
			}else{
			$product_image  = rand(111111111,999999999).'_'.$_FILES['product_image']['name'];

move_uploaded_file($_FILES['product_image']['tmp_name'],'../Media/Products/Product_Main_Images/'.$product_image);

				$insert_product ="insert into Products(Product_Category,Product_Sub_Category, Product_Name,Product_Overview,Product_Details,Product_Length,Product_Breadth,Product_Height,Product_Weight,Best_Seller,Meta_Title,Meta_Description,Meta_Keywords,Status,Product_Image,Listing_Person_Id,Listing_Person_Name,Listing_Person_Role) values('$product_category','$product_sub_category','$product_name','$product_overview','$product_details','$product_length' ,'$product_breadth','$product_height','$product_weight','$best_seller','$meta_title','$meta_description','$meta_keywords','1','$product_image','".$_SESSION['SELLER_ID']."','".$_SESSION['SELLER_USERNAME']."','Seller')";

			$main_insert_product = mysqli_query($database_connection,$insert_product);
			
			$Id = mysqli_insert_id($database_connection);
			}
			
			/* Product Multiple Images Uploading Start */
			
			if(isset($_GET['id']) && $_GET['id']!=''){
			
						if($_FILES['product_images']['name']) {
									foreach($_FILES['product_images']['name'] as $key=>$value){
						
									if($_FILES['product_images']['name'][$key]!=''){
												 			if(isset($_POST['product_images_id'][$key])){
															$product_images  = rand(111111111,999999999).'_'.$_FILES['product_images']['name'][$key];

move_uploaded_file($_FILES['product_images']['tmp_name'][$key],'../Media/Products/Product_Sub_Images/'.$product_images);

									mysqli_query($database_connection,"update Product_Images set Product_Images='$product_images' where Id='".$_POST['product_images_id'][$key]."'");
									
												}else{
								
															$product_images  = rand(111111111,999999999).'_'.$_FILES['product_images']['name'][$key];

move_uploaded_file($_FILES['product_images']['tmp_name'][$key],'../Media/Products/Product_Sub_Images/'.$product_images);

									mysqli_query($database_connection,"insert into Product_Images(Product_Id,Product_Images) values('$Id','$product_images')");
												}
									}
						}
			}					
	}else{
			if(isset($_FILES['product_images']['name'])) {
							 										
						foreach($_FILES['product_images']['name'] as $key=>$value){
									$product_images  = rand(111111111,999999999).'_'.$_FILES['product_images']['name'][$key];

move_uploaded_file($_FILES['product_images']['tmp_name'][$key],'../Media/Products/Product_Sub_Images/'.$product_images);

									mysqli_query($database_connection,"insert into Product_Images(Product_Id,Product_Images) values('$Id','$product_images')");
									
						}
			}
}		
			/* Product Multiple Images Uploading End */
			
/* Product Multiple Attributes Start */

			foreach($_POST['product_mrp'] as $key=>$value){
						$product_mrp = get_secure_value($database_connection, $_POST['product_mrp'][$key]);
						$product_price = get_secure_value($database_connection, $_POST['product_price'][$key]);
						$product_quantity = get_secure_value($database_connection, $_POST['product_quantity'][$key]);
						$product_color = get_secure_value($database_connection, $_POST['product_color'][$key]);
						$product_size = get_secure_value($database_connection, $_POST['product_size'][$key]);
						$attribute_id = get_secure_value($database_connection, $_POST['attribute_id'][$key]);
												
						if($attribute_id > 0) {
									mysqli_query($database_connection,"update Product_Attributes set Product_MRP='$product_mrp',Product_Price='$product_price',Product_Quantity='$product_quantity',Product_Color='$product_color',Product_Size='$product_size' where Id='$attribute_id'");
		
						}else{
									mysqli_query($database_connection,"insert into Product_Attributes(Product_Id, Product_Size, Product_Color, Product_MRP, Product_Price, Product_Quantity,Status) values('$Id','$product_size', '$product_color','$product_mrp','$product_price','$product_quantity','1')");
														
						}	
			}
			
/* Product Multiple Attributes End */

		redirect_page('products.php');
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
							 			<div class="row">
							 						<div class="col-lg-6">
							 									<label for="categories" class=" form-control-label">Product's Category</label>
									<select class="form-control" name="product_category" id="product_category" onchange="fetch_sub_category('')" required>
										<option value="0">Select Product's Category</option>
										<?php
$category_options = "select Id,Category from Categories order by Category asc";

$main_category_options = mysqli_query($database_connection,$category_options);

while($fetch_category = mysqli_fetch_array($main_category_options)){
    if($fetch_category['Id'] == $product_category){
    
									echo "<option selected value=".$fetch_category['Id'].">".$fetch_category['Category']."</option>";
									
									}else{
									
												echo "<option value=".$fetch_category['Id'].">".$fetch_category['Category']."</option>";
												
											}
									}
										?>
									</select>
							 						</div>
							 						<div class="col-lg-6">
							 									<label for="categories" class=" form-control-label">Product's Sub Category</label>
									<select class="form-control" name="product_sub_category" id="product_sub_category">
										<option>Select Product's Sub Category</option>
									</select>
							 						</div>
							 			</div>
								</div>
								<div class="form-group">
											<div class="row">
														<div class="col-lg-7">
												<label for="categories" class=" form-control-label">Product's Name</label>
									<input type="text" name="product_name" placeholder="Enter Product's Name" class="form-control" required value="<?php echo $product_name ?>">
									</div>
									<div class="col-lg-5">
																<label for="categories" class=" form-control-label">Best Seller</label>
									<select class="form-control" name="best_seller" required>
										<option value="">Select Option</option>
										<?php  
										if($best_seller==1) {
											echo "<option value='1' selected>Yes, It's The Best Selling Product</option>
											<option value='0'>No, It's Not The Best Selling Product</option>
											";
										}else if($best_seller==0){
											echo "<option value='1'>Yes, It's The Best Selling Product</option>
											<option value='0' selected>No, It's Not The Best Selling Product</option>
											";
										}else{
													echo "<option value='1'>Yes, It's The Best Selling Product</option>
											<option value='0'>No, It's Not The Best Selling Product</option>
											";
										}
										?>
										</select>
													</div>
							</div>
						</div>
							<div class="form-group" id="product_attributes">
										<?php
										$loop_count = 1;
										  
										foreach($product_attributes as $list){
										?>
										<div class="row" id="attribute_<?php echo $loop_count ?>">
													<div class="col-lg-2">
																<label for="categories" class=" form-control-label">Product's MRP</label>
									<input type="number" name="product_mrp[]" placeholder="MRP" class="form-control" required value="<?php echo $list['Product_MRP'] ?>">
													</div>
													<div class="col-lg-2">
																<label for="categories" class=" form-control-label">Product's Price</label>
									<input type="number" name="product_price[]" placeholder="Price" class="form-control" required value="<?php echo $list['Product_Price'] ?>">
													</div>
													<div class="col-lg-2">
																<label for="categories" class=" form-control-label">Product's Quantity</label>
									<input type="number" name="product_quantity[]" placeholder="Quantity" class="form-control" required value="<?php echo $list['Product_Quantity'] ?>">
													</div>
													<div class="col-lg-2">
																<label for="categories" class=" form-control-label">Product's Color</label>
									<select class="form-control" name="product_color[]" id="product_color">
										<option value="0">Color</option>
										<?php
$color_options = "select Id,Color from Colors order by Color asc";

$main_color_options = mysqli_query($database_connection,$color_options);

while($fetch_color = mysqli_fetch_array($main_color_options)){
			if($list['Product_Color'] == $fetch_color['Id']){
					
    echo "<option value=".$fetch_color['Id']." selected>".$fetch_color['Color']."</option>";
				
				}else{
				
					echo "<option value=".$fetch_color['Id'].">".$fetch_color['Color']."</option>";		
					
				}		
		}
	?>
									</select>
													</div>
													<div class="col-lg-2">
																<label for="categories" class=" form-control-label">Product's Size</label>
									<select class="form-control" name="product_size[]" id="product_size">
										<option value="0">Size</option>
										<?php
$size_options = "select Id,Size from Sizes order by Sorting_Order asc";

$main_size_options = mysqli_query($database_connection,$size_options);

while($fetch_size = mysqli_fetch_array($main_size_options)){

    if($list['Product_Size'] == $fetch_size['Id']){
					
    echo "<option value=".$fetch_size['Id']." selected>".$fetch_size['Size']."</option>";
				
				}else{
				
					echo "<option value=".$fetch_size['Id'].">".$fetch_size['Size']."</option>";		
					
				}									
		}
										?>
									</select>
													</div>
													<div class="col-lg-2">
																<label for="categories" class=" form-control-label"></label>
																
																<?php  
																if($loop_count == 1){
																?>
																<button type="button" class="btn btn-lg btn-info btn-block" onclick="add_more_attributes()">
							   <span id="payment-button-amount">Add More</span>
							   </button>
																<?php
																}else{
																?>
																<button type="button" class="btn btn-lg btn-danger btn-block" onclick="remove_attributes('<?php echo $loop_count ?>','<?php echo $list['Attribute_Id'] ?>')">
							   <span id="payment-button-amount">Remove</span>
							   </button>
															<?php		
																}
															?>
															<input type="hidden" name="attribute_id[]" value="<?php echo $list['Attribute_Id'] ?>">
													</div>
										</div>
					<?php 
							$loop_count++;
								} 
			  ?>
							</div>	
						
						<div class="form-group">
							<div class="row" id="image_box">
										<div class="col-lg-10">
													<label for="categories" class=" form-control-label">Product's Main Image</label>
									<input type="file" name="product_image" class="form-control" <?php echo  $validator ?>>
									
									<?php  
												if($product_image!='') {
															echo "<a target='_blank' href='".PRODUCT_MAIN_IMAGE_SITE_PATH.$product_image."'><img width='200px' src='".PRODUCT_MAIN_IMAGE_SITE_PATH.$product_image."'/></a>";
												}
									?>
									
									</div>
									<div class="col-lg-2">
												<label for="categories" class=" form-control-label"></label>
										<button type="button" class="btn btn-lg btn-info btn-block" onclick="add_more_images()">
							   <span id="payment-button-amount">Add Image</span>
							   </button>
							</div>
							
							<?php
								if(isset($product_images[0])){
											foreach($product_images as $list){												
																echo '<div class="col-lg-6" style="margin-top:20px;" id="image_box_'.$list['Id'].'">
															<label for="categories" class="form-control-label">Product Sub Image</label>
									<input type="file" name="product_images[]" class="form-control">
									<a href="manage_products.php?id='.$Id.'&image_id='.$list['Id'].'" style="color:white;">
									<button type="button" class="btn btn-lg btn-danger btn-block">
<span id="payment-button-amount">Remove</span>
</button>	</a>';
echo "<a target='_blank' href='".PRODUCT_SUB_IMAGE_SITE_PATH.$list['Product_Images']."'><img width='200px' src='".PRODUCT_SUB_IMAGE_SITE_PATH.$list['Product_Images']."'/></a>";
echo '<input type="hidden" name="product_images_id[]" value="'.$list['Id'].'"/>
											</div>';
													}
										}
							?>
							
						</div>
					</div>
				 
							<div class="row">
										<div class="col-lg-3">
													<label for="categories" class=" form-control-label">Product's Length</label>
									<input type="number" name="product_length" placeholder="Length" class="form-control" required value="<?php echo $product_length ?>">
										</div>
										<div class="col-lg-3">
													<label for="categories" class="form-control-label">Product's Breadth</label>
									<input type="number" name="product_breadth" placeholder="Breadth" class="form-control" required value="<?php echo $product_breadth ?>">
										</div>
										<div class="col-lg-3">
													<label for="categories" class=" form-control-label">Product's Height</label>
									<input type="number" name="product_height" placeholder="Height" class="form-control" required value="<?php echo $product_height ?>">
										</div>
										<div class="col-lg-3">
													<label for="categories" class=" form-control-label">Product's Weight</label>
									<input type="number" name="product_weight" placeholder="Weight" class="form-control" required value="<?php echo $product_weight ?>">
										</div>
							</div>
								
									<label for="categories" class=" form-control-label">Product's Overview</label>
									<textarea name="product_overview" placeholder="Enter Product's Overview" class="form-control" required><?php echo $product_overview ?></textarea>
								
									<label for="categories" class=" form-control-label">Product's Details</label>
									<textarea name="product_details" placeholder="Enter Product's Details" class="form-control" required><?php echo $product_details ?></textarea>
									
						<label for="categories" class=" form-control-label">Meta Title</label>
									<textarea name="meta_title" placeholder="Enter Product's Meta Title" class="form-control"><?php echo $meta_title?></textarea>
								
									<label for="categories" class=" form-control-label">Meta Description</label>
									<textarea name="meta_description" placeholder="Enter Product's Meta Description" class="form-control"><?php echo $meta_description?></textarea>
								
									<label for="categories" class=" form-control-label">Meta Keywords</label>
									<textarea name="meta_keywords" placeholder="Enter Product's Meta Keywords" class="form-control"><?php echo $meta_keywords?></textarea>
								</div>
																
							   <button id="payment-button" name="submit" type="submit" class="btn btn-lg btn-info btn-block">
							   <span id="payment-button-amount"><?php echo $button_value ?>
							   </span>
							   </button>
							   <div class="field_error"><?php echo $error_message ?></div>
							</div>
						</form>
                     </div>
                  </div>
               </div>
            </div>
         </div>

<script>
			
function fetch_sub_category(product_sub_category) {
			var product_category = jQuery('#product_category').val();
			
			jQuery.ajax({
					 	url:'fetch_sub_category.php', 
					 type:'post',					 data:'product_category='+product_category+'&product_sub_category='+product_sub_category, 
				  success:function(result) {		  			jQuery('#product_sub_category').html(result);
				  }
			});
}

			var attribute_count = 1;
			function add_more_attributes() {
						attribute_count++;
						
						var size = jQuery('#attribute_1 #product_size').html();
						size = size.replace('selected','');
						
						var color = jQuery('#attribute_1 #product_color').html();
						color = color.replace('selected','');
						
						var attributes = `<div class="row" style="margin-top:20px;" id="attribute_${attribute_count}">
<div class="col-lg-2">
<label for="categories" class=" form-control-label">Product's MRP
</label>
<input type="number" name="product_mrp[]" placeholder="MRP" class="form-control" required>
</div>
<div class="col-lg-2">
<label for="categories" class=" form-control-label">Product's Price
</label>
<input type="number" name="product_price[]" placeholder="Price" class="form-control" required>
</div>
<div class="col-lg-2">
<label for="categories" class=" form-control-label">Product's Quantity
</label>
<input type="number" name="product_quantity[]" placeholder="Quantity" class="form-control" required>
</div>
<div class="col-lg-2">
<label for="categories" class=" form-control-label">Product's Color
</label>
<select class="form-control" name="product_color[]" id="product_color">
${color}
</select>
</div>
<div class="col-lg-2">
<label for="categories" class=" form-control-label">Product's Size
</label>
<select class="form-control" name="product_size[]" id="product_size">
${size}
</select>
</div>
<div class="col-lg-2">
<label for="categories" class=" form-control-label">&nbsp;
</label>
<button type="button" class="btn btn-lg btn-danger btn-block" onclick="remove_attributes(${attribute_count})">
<span id="payment-button-amount">Remove</span>
</button>
<input type="hidden" name="attribute_id[]" value="">
</div>
</div>`;
						
						jQuery('#product_attributes').append(attributes);					
			}
			
			function remove_attributes(removing_attribute_count,attribute_id) {
					jQuery.ajax({
								url:'remove_product_attribute.php', 
								type:'post',
								data:'attribute_id='+attribute_id, 
								success:function(result){
											jQuery('#attribute_'+removing_attribute_count).remove();
								}
					});
			}
			
			let image_count = 1;
			function add_more_images() {
						image_count++;
						
					 let color = jQuery('#attribute_1 #product_color').html();
						color = color.replace('selected','');
						
						var image_boxes = `<div class="col-lg-6" style="margin-top:20px;" id="image_box_${image_count}">
						<label for="categories" class=" form-control-label">Product's Sub Image</label>
									<input type="file" name="product_images[]" class="form-control" required>
									<button type="button" class="btn btn-lg btn-danger btn-block" onclick="remove_images(${image_count})">
<span id="payment-button-amount">Remove</span>
									</button>
</div>`;
									
						jQuery('#image_box').append(image_boxes);
			}
			
			function remove_images(image_box_id){
						jQuery('#image_box_'+image_box_id).remove();
			}
			
</script>

<?php
if(isset($_GET['id'])) {
?>
fetch_sub_category('<?php echo $product_sub_category ?>');			
<?php } ?>	

<?php
require('footer.php');
?>