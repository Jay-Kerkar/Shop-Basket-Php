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
