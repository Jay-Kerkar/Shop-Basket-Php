<?php
session_start();

if(isset($_SESSION['ORDER_ID']) && $_SESSION['FINAL_CART_VALUE'] > 0) {

$phone = $_SESSION['PHONE'];
$buyer_name = $_SESSION['BUYER_NAME'];
$email = $_SESSION['EMAIL'];
$order_id = $_SESSION['ORDER_ID'];
$final_cart_value = $_SESSION['FINAL_CART_VALUE'];
$purpose = 'Paying To Ecommerce Website';
$redirect_url = 'http://snackspace.epizy.com/Ecommerce%20Website/Main%20Website/payment_process.php';

$ch = curl_init(); 

curl_setopt($ch, CURLOPT_URL, 'https://test.instamojo.com/api/1.1/payment-requests/'); 
curl_setopt($ch, CURLOPT_HEADER, FALSE); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE); 

curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Api-Key:test_bd88f84f3d999d393fd50651ced", "X-Auth-Token:test_f4821689a0aec1a2b1b191b238b")); 

$payload = Array( 'purpose' => $purpose, 'amount' => $final_cart_value, 'phone' => $phone, 'buyer_name' => $buyer_name, 'redirect_url' => $redirect_url, 'send_email' => false, 'webhook' => 'http://www.example.com/webhook/', 'send_sms' => false, 'email' => $email, 'allow_repeated_payments' => false );

curl_setopt($ch, CURLOPT_POST, true); curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload)); 
$response = curl_exec($ch); curl_close($ch);  

$response = json_decode($response);

$transaction_id = $response->payment_request->id;

$_SESSION['TRANSACTION_ID'] = $transaction_id;

mysqli_query($database_connection,"update Orders set Transaction_Id='$transaction_id' where Id='$order_id'");
  ?>
  <script> 			
  			window.location.href='<?php echo $response->payment_request->longurl ?>';
  </script>
  <?php
}else{
			?>
<script>
			window.location.href='payment_failure.php';
</script>
<?php			
}
?>
