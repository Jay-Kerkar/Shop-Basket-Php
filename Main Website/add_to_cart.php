<?php 
class cart_operations{
			
function add_products_to_cart($product_id,$product_quantity) {

			$_SESSION['CART'][$product_id]['PRODUCT_QUANTITY'] = $product_quantity;
			
			}
			
function update_products_of_cart($product_id,$product_quantity) {

						if(isset($_SESSION['CART'][$product_id])) {
									$_SESSION['CART'][$product_id]['PRODUCT_QUANTITY'] = $product_quantity;
						}					
						
			}
			
function remove_products_from_cart($product_id) {

						if(isset($_SESSION['CART'][$product_id])) {
								unset($_SESSION['CART'][$product_id]);
						}
						
			}
			
function truncate_products_of_cart() {
						
						unset($_SESSION['CART']);
						
			}
			
			function total_no_of_products() {
						
				if(isset($_SESSION['CART'])) {
					return	count($_SESSION['CART']);
					}else{
									return 0;
					}
						
			}			
			
}
?>
