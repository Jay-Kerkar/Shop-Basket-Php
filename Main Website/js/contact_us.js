function send_message(){
alert("Function Called Successfully");
	var name = jQuery("#name").val();
	var email_id = jQuery("#email_id").val();
	var mobile_number = jQuery("#mobile_number").val();
	var type_of_message = jQuery("#type_of_messagee").val();
	var subject = jQuery("#subject").val();
	var message = jQuery("#message").val();
	var field_error = '';
	
	if(name == ""){
		jQuery('#name_error').html('Please enter your name');
		field_error = 'yes';
	}else if(email_id == ""){
		jQuery('#email_id_error').html('Please enter your email id');
		field_error = 'yes';
	}else if(mobile_number == ""){
		jQuery('#mobile_number_error').html('Please enter your mobile number');
		field_error = 'yes';
	}else if(type_of_message == ""){
		jQuery('#type_of_message_error').html('Please enter your type_of_message');
		field_error = 'yes';
	}else if(subject == ""){
		jQuery('#subject_error').html('Please enter your subject');
		field_error = 'yes';
	}else if(message == ""){
		jQuery('#message_error').html('Please enter your message');
		field_error = 'yes';
	}else{
		jQuery.ajax({
			url:'send_message.php',
			type:'post',
			data:'name='+name+'&email_id='+email_id+'&mobile_number='+mobile_number+'&type_of_message='+type_of_message+'&subject='+subject+'&message='+message,
			success:function(result){			jQuery('#contact_us_error').html('Congratulations, sent message successfully');
			}	
		});
	}
}
