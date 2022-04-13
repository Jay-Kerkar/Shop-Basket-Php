function applyCouponCode() {

	var couponCode = jQuery('#coupon_code').val();
 
	if (coupon_code = '') {
jQuery('#coupon_code_result').html("Please Enter A Valid Coupon Code");
	} else { 
	jQuery('#coupon_code_result').html('');
	
		jQuery.ajax({
			url: 'apply_coupon_code.php',
			type: 'post',
			data: 'coupon_code='+couponCode,
			success: function (result) {
				var data = jQuery.parseJSON(result);

				if (data.coupon_code_error == 'yes') {
					jQuery('#coupon_code_value_box').hide();
					jQuery('#coupon_code_result').html(data.result);
				}

				if (data.coupon_code_error == 'no') {
					jQuery('#coupon_code_value_box').show();
					jQuery('#coupon_code_value').html(data.coupon_code_value);
					jQuery('#cart_total_value').html(data.final_cart_value);
						jQuery('#coupon_code_result').html(data.result);
				}

			}
		});
	}

}
