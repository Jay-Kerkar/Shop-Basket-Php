<?php
require ('header.php');

$product_id = get_secure_value($database_connection, $_GET['id']);

if ($product_id > 0) {
			$get_products_data = get_products_data($database_connection, '','','',$product_id);
			
			// Product Multiple Images Start
    $select_multiple_images = mysqli_query($database_connection, "select Product_Images from Product_Images where Product_Id = '$product_id'");
    
    $multiple_images = [];
    
    if (mysqli_num_rows($select_multiple_images) > 0) {
    			while ($fetch_multiple_images = mysqli_fetch_array($select_multiple_images)) {
      			$multiple_images[] = $fetch_multiple_images['Product_Images'];
								}
      
    if (count($multiple_images) == 6) {
    			$flex_basis = "10%";
    } else if (count($multiple_images) == 5) {
    			$flex_basis = "15%";
    } else if (count($multiple_images) == 4) {
    			$flex_basis = "18%";
    } else if (count($multiple_images) == 3) {
      $flex_basis = "23%";
    } else if (count($multiple_images) == 3) {
      $flex_basis = "30%";
    } else if (count($multiple_images) == 2) {
    			$flex_basis = "32%";
    }
		}
		// Product Multiple Images End
		
		// Product Attributes Start
		$select_product_attributes = mysqli_query($database_connection, "select Product_Attributes.*, Colors.Color, Sizes.Size from Product_Attributes left join Colors on Product_Attributes.Product_Color = Colors.Id and Colors.Status = 1 left join Sizes on Product_Attributes.Product_Size = Sizes.Id and Sizes.Status = 1 where Product_Attributes.Product_Id = '$product_id' order by Sizes.Sorting_Order asc");
    
    $product_attributes = [];
    $color_array = [];
    $size_array = [];
    
    if (mysqli_num_rows($select_product_attributes) > 0) {
    		while ($fetch_product_attributes = mysqli_fetch_array($select_product_attributes)) {
      			$product_attributes[] = $fetch_product_attributes;
      			$color_array[$fetch_product_attributes['Product_Color']][] = $fetch_product_attributes['Color'];
      			      			
      			$size_array[$fetch_product_attributes['Product_Size']][] = $fetch_product_attributes['Size'];
      			
      			$new_color_array[] = $fetch_product_attributes['Color'];
      			
      			$new_size_array[] = $fetch_product_attributes['Size'];
								}
			}
			
			$color_validation = count(array_filter($new_color_array));
			
			$size_validation = count(array_filter($new_size_array));
				
			// Product Attributes End
} else {
    redirect_page('home.php');
}
?>

<!-- Breadcrumbs Start-->
<div class="breadcrumbs">
   <div class="container">
      <div class="row">
         <div class="col-12">
            <div class="bread-inner">
               <ul class="bread-list">
                  <li><a href="home.php">Home<i class="ti-arrow-right"></i></a></li>
                  <li class="active">
                     <a href="categories.php?id=<?php echo $get_products_data['0']['Product_Category'] ?>"><?php echo $get_products_data['0']['Category'] ?><i class="ti-arrow-right"></i></a>
                  </li>
                  <li class="active">
                     <a href="categories.php?id=<?php echo $get_products_data['0']['Product_Category'] ?>&sub_category_id=<?php echo $get_products_data['0']['Product_Sub_Category'] ?>"><?php echo $get_products_data['0']['Sub_Category'] ?><i class="ti-arrow-right"></i></a>
                  </li>
                  <li class="active">
                     <a href="product_details.php?id=<?php echo $get_products_data['0']['Id'] ?>"><?php echo $get_products_data['0']['Product_Name'] ?></a>
                  </li>
               </ul>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Breadcrumbs End-->

<!-- Product Details Start -->
<section class="container single-product my-5 pt-5">
   <div class="row mt-5">
      <div class="col-lg-5 col-md-12 col-12">
        <div id="main-image-box" class="product-image-zoom">
         <img data-origin="<?php echo PRODUCT_MAIN_IMAGE_SITE_PATH.$get_products_data['0']['Product_Image'] ?>" class="img-fluid w-100 pb-2" id="main-image" src="<?php echo PRODUCT_MAIN_IMAGE_SITE_PATH . $get_products_data['0']['Product_Image'] ?>"></img>
        </div>
        
         <?php
if (isset($multiple_images[0])) {
?>
         <div class="small-img-group">
            <div class="small-img-col" style="flex-basis:<?php echo $flex_basis ?>">
               <img src="<?php echo PRODUCT_MAIN_IMAGE_SITE_PATH . $get_products_data['0']['Product_Image'] ?>" width="100%" class="small-img" onclick="multiple_images('<?php echo PRODUCT_MAIN_IMAGE_SITE_PATH . $get_products_data['0']['Product_Image'] ?>')"></img>
            </div>
            
<?php
foreach ($multiple_images as $list) {
?>
            <div class="small-img-col" style="flex-basis:<?php echo $flex_basis ?>">
               <img src="<?php echo PRODUCT_SUB_IMAGE_SITE_PATH.$list ?>" width="100%" class="small-img" onclick="multiple_images('<?php echo PRODUCT_SUB_IMAGE_SITE_PATH.$list ?>')"></img>
            </div>
												<?php } ?>
         </div>
        <?php } ?>																		
      </div>
      
<div class="col-lg-5 col-md-12 col-12"> 			
			<h6><span>Category : <a href="categories.php?id=<?php echo $get_products_data['0']['Product_Category'] ?>"><?php echo $get_products_data['0']['Category'] ?></a></span> / <span><a href="categories.php?id=<?php echo $get_products_data['0']['Product_Category'] ?>&sub_category_id=<?php echo $get_products_data['0']['Product_Sub_Category'] ?>"><?php echo $get_products_data['0']['Sub_Category'] ?></a></span></h6>
			<h2 class="py-4"><?php echo $get_products_data['0']['Product_Name'] ?></h2>
			<h5 id="product-price" style="display: inline;">Price : Rs <?php echo $get_products_data['0']['Product_Price'] ?></h5>
			<h5 id="product-mrp" style="display: inline; margin-left:75px; text-decoration: line-through; opacity:0.8;">MRP : Rs <?php echo $get_products_data['0']['Product_MRP'] ?></h5>
                              
<?php  
if($color_validation > 0){
?>
			<div id="color-box">
						<span>Color : </span>
									<?php  
								foreach($color_array as $key => $value)	{
						echo "<li><a href='javascript:void(0)' style='background-color: ".$value[0].";' onclick = load_product_size('".$key."','".$get_products_data['0']['Id']."','size') ></a></li>";
								 }
									?>
			</div>
<?php } ?>			

<?php  
if($size_validation > 0){
?>		
			<select class="my-4" id="size-box" style="width: 40%; height: 5%; text-align: center; font-size: 16px; display: inline;" onchange="load_product_quantity()">
						<option value="0">Select Size</option>
     <?php  
						foreach($size_array as $key => $value)	{
						echo "<option value='".$key."'>$value[0]</option>";
						}
						?>
			</select>	
<?php } ?>			

<?php
			$hide_quantity_box = "hide";
			
			if($color_validation == 0 && $size_validation == 0){
						$hide_quantity_box = "";						
   } 
?>

			<select id="quantity-box" class="<?php echo $hide_quantity_box ?>" style="width: 40%; height: 5%; text-align: center; font-size: 16px; margin-left: 20px;">
			<option>Select Quantity</option>
   </select>
		
<span id="color-size-error"></span>

			<div style="margin-top: 20px;">
						<a href="javascript:void(0)" onclick="manage_cart('<?php echo $get_products_data['0']['Id'] ?>','add')" class="buy-btn btn" style="text-align: center; width: 183px;">Add To Cart</a>
						
         <a href="javascript:void(0)" onclick="manage_cart('<?php echo $get_products_data['0']['Id'] ?>','add','yes')" class="buy-btn btn" style="margin-left: 20px; padding: 13px 46px; text-align: center; width: 183px;">Buy Now</a>
			</div>        

			<h4 class="mt-4 mb-3">Product Overview</h4>
         <span><?php echo $get_products_data['0']['Product_Overview'] ?></span>
         
		</div>
	</div>
</section>
<!-- Product Details End -->

<!-- Product Attributes Validation Start -->
<input type="hidden" id="product-id" value="<?php echo $get_products_data['0']['Id'] ?>">
<input type="hidden" id="color-id">
<input type="hidden" id="size-id">
<!-- Product Attributes Validation End -->

<!-- Js For Multiple Images Start-->
<script>
   function multiple_images(image){    
   	jQuery('#main-image-box').html("<img data-origin='"+image+"' src='"+image+"'></img>");
   	jQuery('.product-image-zoom').imgZoom();
   }
</script>
<!-- Js For Multiple Images End-->

<!-- Js For Product Attributes Start-->
<script>
			let color_validation = <?php echo $color_validation ?>;
			let size_validation = <?php echo $size_validation ?>;

function load_product_size(color_id,product_id,type) {
		jQuery('#color-id').val(color_id);
		jQuery('#color-size-error').html('');
		
		if(size_validation == 0){
					 let product_id = jQuery('#product-id').val();
					 let color_id = jQuery('#color-id').val();
						let size_id = 0;
						let type = "quantity";
						
						jQuery.ajax({
						url: 'load_product_attribute.php', 
						type: 'post', 
						data: 'color_id=' + color_id + '&size_id=' + size_id + '&product_id=' + product_id + '&type=' + type, 
						success:function(result){
									let data = jQuery.parseJSON(result);
									let product_quantity = data.product_quantity;
									
jQuery('#product-price')	.html("Price : <span>" + data.product_price + "</span>");	

									var count = 1;
									const quantity_array = [];
									
									for(count; count <= product_quantity; count++){
									var quantity_html = `<option value="${count}">${count}</option>`;
quantity_array.push(quantity_html);
									}
									
jQuery('#quantity-box').html(`<option value="0">Select Quantity</option>` + quantity_array);
jQuery('#quantity-box').removeClass("hide");				
						}
				});
		}else{
						let product_id = jQuery('#product-id').val();
					 let color_id = jQuery('#color-id').val();
						let type = "size";
						
					jQuery.ajax({
						url: 'load_product_attribute.php', 
						type: 'post', 
						data: 'color_id=' + color_id + '&product_id=' + product_id + '&type=' + type,
						success:function(result){								jQuery('#size-box').html("<option value='0'>Select Size</option>"+result);
						}
					});
		}
}

function load_product_quantity() {
jQuery('#color-size-error').html('');

			if(color_validation == 0){
						let size_selected = jQuery('#size-box').val();
jQuery('#size-id').val(size_selected);

						let product_id = jQuery('#product-id').val();
						let color_id = 0;
						let size_id = jQuery('#size-id').val();
						let type = "quantity";
						
						jQuery.ajax({
						url: 'load_product_attribute.php', 
						type: 'post', 
						data: 'color_id=' + color_id + '&size_id=' + size_id + '&product_id=' + product_id + '&type=' + type,
						success:function(result) {
									let data = jQuery.parseJSON(result);
									let product_quantity = data.product_quantity;
									
jQuery('#product-price')	.html("Price : <span>" + data.product_price + "</span>");	

									var count = 1;
									const quantity_array = [];
									
									for(count; count <= product_quantity; count++){
									var quantity_html = `<option value="${count}">${count}</option>`;
quantity_array.push(quantity_html);
									}
									
jQuery('#quantity-box').html(`<option value="0">Select Quantity</option>` + quantity_array);
jQuery('#quantity-box').removeClass("hide");
						}
						});
			}else if(color_validation > 0 && size_validation > 0){
						let size_selected = jQuery('#size-box').val();
jQuery('#size-id').val(size_selected);

						let product_id = jQuery('#product-id').val();
						let color_id = jQuery('#color-id').val();
						let size_id = jQuery('#size-id').val();
						let type = "quantity";
						
						jQuery.ajax({
						url: 'load_product_attribute.php', 
						type: 'post', 
						data: 'color_id=' + color_id + '&size_id=' + size_id + '&product_id=' + product_id + '&type=' + type,
						success:function(result) {
									let data = jQuery.parseJSON(result);
									let product_quantity = data.product_quantity;
									
jQuery('#product-price')	.html("Price : <span>" + data.product_price + "</span>");	

									var count = 1;
									const quantity_array = [];
									
									for(count; count <= product_quantity; count++){
									var quantity_html = `<option value="${count}">${count}</option>`;
quantity_array.push(quantity_html);
									}
									
jQuery('#quantity-box').html(`<option value="0">Select Quantity</option>` + quantity_array);
jQuery('#quantity-box').removeClass("hide");
						}
						});
			}else if(color_validation == 0 && size_validation == 0){
						let product_id = jQuery('#product-id').val();
					 let color_id = 0;
						let size_id = 0;
						let type = "quantity";
						
						jQuery.ajax({
						url: 'load_product_attribute.php', 
						type: 'post', 
						data: 'color_id=' + color_id + '&size_id=' + size_id + '&product_id=' + product_id + '&type=' + type,
						success:function(result) {
									let data = jQuery.parseJSON(result);
									let product_quantity = data.product_quantity;
									
jQuery('#product-price')	.html("Price : <span>" + data.product_price + "</span>");
jQuery('#product-mrp')	.html("MRP : <span>" + data.product_mrp + "</span>");

									var count = 1;
									const quantity_array = [];
									
									for(count; count <= product_quantity; count++){
									var quantity_html = `<option value="${count}">${count}</option>`;
quantity_array.push(quantity_html);
									}
									
jQuery('#quantity-box').html(`<option value="0">Select Quantity</option>` + quantity_array);
jQuery('#quantity-box').removeClass("hide");
						}
						});
			}
}

if(color_validation == 0 && size_validation == 0) {
			load_product_quantity()
}

function manage_cart(product_id,type,buy_now){
		jQuery('#color-size-error').html('');
		var product_attribute_error = '';
		
		if(type == 'update'){
					var quantity = jQuery("#"+product_id+"quantity").val();
		}else{
					var quantity = jQuery("#quantity-box").val();
		}
		
		let color_id = jQuery("#color-id").val();
		let size_id = jQuery("#size-id").val();

		if(color_validation!= 0 && color_id == ''){
jQuery('#color-size-error').html('Please Select The Color');
product_attribute_error = 'yes';
		}
				
		if(size_validation!= 0 && size_id == '' && product_attribute_error == ''){
jQuery('#color-size-error').html('Please Select The Size');
product_attribute_error = 'yes';
		}
		
		if(quantity == 0 && product_attribute_error == ''){
jQuery('#color-size-error').html('Please Select The Quantity');
product_attribute_error = 'yes';
		}
		
		if(product_attribute_error == ''){
					jQuery.ajax({
								url:'manage_cart.php',
								type:'post',
data:'product_id='+product_id+'&quantity='+quantity+'&type='+type+'&color_id='+color_id+'&size_id='+size_id,
								success:function(result){
												if(type == 'add'|| type == 'update' || type == 'remove'){
															window.location.href = window.location.href;
												}
												
												if(result == 'Products Quantity Not Available'){
															alert('Product Quantity Not Available');
												}else{
			jQuery('.total-count').html(result);
												}
												
												if(buy_now == 'yes'){
															window.location.href = 'checkout.php';
												}
									}
					});
		}
}
</script>
<!-- Js For Product Attributes End-->

<!-- Js For Product Image Zoom Start-->
<script src="js/jquery.imgzoom.js"></script>

<script>
	jQuery('.product-image-zoom').imgZoom();
</script>
<!-- Js For Product Image Zoom End-->

<?php
require ('footer.php');
?>
