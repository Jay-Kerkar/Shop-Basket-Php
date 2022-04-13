<?php 
session_start();

if(isset($_SESSION['ORDER_ID']) && $_SESSION['FINAL_CART_VALUE'] > 0){
			$order_id = $_SESSION['ORDER_ID'];
			$total_amount = $_SESSION['FINAL_CART_VALUE'];
}else{
?>
<script>
			window.location.href='payment_failure.php';
</script>
<?php
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Pay Through Razorpay</title>
</head>
<body>
			
			<span id="orderId" style="display:none;"><?php echo $order_id ?></span>
			<span id="totalAmount" style="display:none;"><?php echo $total_amount ?></span>
			
			<h2>Please Wait While The Payment Is In Process</h2>
			<h6>Do not refresh the browser</h6>
			<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
			<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
	var orderId = document.getElementById('orderId').innerText;
    var totalAmount = document.getElementById('totalAmount').innerText;

var options = {
    "key": "rzp_test_cL1hIxjuzgYeWP",
    "amount": totalAmount*100,
    "currency": "INR",
    "name": "Ecommerce Website",
    "description": "Paying Through Razorpay",
    "image": "https://image.freepik.com/free-vector/logo-sample-text_355-558.jpg",
    "handler": function (response){
        jQuery.ajax({                              
            type:'post',                                  
            url:'payment_process.php',                              
            data:"paymentId="+response.razorpay_payment_id+"&orderId="+orderId,                               
            success:function(result){
                window.location.href="order_summary.php?order_id="+orderId;
           }
          });
         }
       }; 

var rzp1 = new Razorpay(options);
	rzp1.open();
</script>
</body>
</html>
