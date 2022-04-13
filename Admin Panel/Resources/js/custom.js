function addMoreAttributes(){
			var html='<div class="row" style="margin-top:10px;">
													<div class="col-lg-2">
																<label for="categories" class=" form-control-label">Product's MRP</label>
									<input type="number" name="product_mrp" placeholder="MRP" class="form-control" required value="<?php echo $product_mrp ?>">
													</div>
													<div class="col-lg-2">
																<label for="categories" class=" form-control-label">Product's Price</label>
									<input type="number" name="product_price" placeholder="Price" class="form-control" required value="<?php echo $product_price ?>">
													</div>
													<div class="col-lg-2">
																<label for="categories" class=" form-control-label">Product's Quantity</label>
									<input type="number" name="product_quantity" placeholder="Quantity" class="form-control" required value="<?php echo $no_of_products_quantity_remaining ?>">
													</div>
													<div class="col-lg-2">
																<label for="categories" class=" form-control-label">Product's Color</label>
									<input type="number" name="product_color" placeholder="Color" class="form-control" required value="<?php echo $no_of_products_quantity_remaining ?>">
													</div>
													<div class="col-lg-2">
																<label for="categories" class=" form-control-label">Product's Size</label>
									<input type="number" name="product_size" placeholder="Size" class="form-control" required value="<?php echo $no_of_products_quantity_remaining ?>">
													</div>
										</div>';		
			jQuery("#product_attributes").append(html);
}