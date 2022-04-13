function manage_wishlist(product_id) {
		jQuery.ajax({
					url:'manage_wishlist.php', 
					type:'post', 					data:'product_id='+product_id, 
					success:function(result){
								if(result == 'Customer Is Not Logged In') {											window.location.href='customer_login.php';
								}else{									jQuery('#total-wishlist-count').html(result);
								}
					}
		});
}
