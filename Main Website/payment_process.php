<?php
require('database_connection.php');
require('functions.php');

if(isset($_POST['paymentId']) && isset($_POST['orderId'])){
    $payment_id = get_secure_value($database_connection,$_POST['paymentId']);
    $order_id = get_secure_value($database_connection,$_POST['orderId']);
       mysqli_query($database_connection,"update Orders set Payment_Status='2',Payment_Id='$payment_id' where Id='$order_id'");
               
}

if(isset($_GET['payment_id']) && isset($_GET['payment_status']) && isset($_GET['payment_request_id'])){

			$payment_id = get_secure_value($database_connection,$_GET['payment_id']);
			$transaction_id =		$_SESSION['TRANSACTION_ID'];
				mysqli_query($database_connection,"update Orders set Payment_Status='2',Payment_Id='$payment_id' where Transaction_Id='$transaction_id'");			
							
?>
<script>			window.location.href='order_summary.php';
</script>
<?php  
}

?>
