<?php
function pr($array){
	echo '<pre>';
	print_r($array);
}

function prx($array){
	echo '<pre>';
	print_r($array);
	die();
}

function get_secure_value($database_connection,$secure_value){
		return mysqli_real_escape_string($database_connection,$secure_value);
}

function no_of_products_quantity_sold($database_connection,$product_id){
			$select_products_quantity = "select sum(Order_Details.Quantity) as Quantity from Order_Details,Orders where Orders.Id=Order_Details.Order_Id and Order_Details.Product_Id=$product_id and Orders.Order_Status!=6";
			
			$main_select_products_quantity = mysqli_query($database_connection,$select_products_quantity);
			
			$fetch_products_quantity = mysqli_fetch_array($main_select_products_quantity);
			
			return $fetch_products_quantity['Quantity'];
}

function total_no_of_products_quantity($database_connection,$product_id){
			$select_products_quantity = "select Product_Quantity as Quantity from Products where Id='$product_id'";
			
			$main_select_products_quantity = mysqli_query($database_connection,$select_products_quantity);
			
			$fetch_products_quantity = mysqli_fetch_array($main_select_products_quantity);
			
			return $fetch_products_quantity['Quantity'];
}

function shiprocket_token($database_connection) {
   date_default_timezone_set('Asia/Kolkata');
   
			$fetch_shiprocket_token = mysqli_fetch_array(mysqli_query($database_connection,"select * from ShipRocket_Token"));
		
		$registration_date_time = strtotime($fetch_shiprocket_token['Registration_Date_Time']);
			
			$current_date_time = strtotime(date('Y-m-d h:i:s'));
			
			$time_period = $current_date_time - $registration_date_time;
			
			if($time_period > 86400) {			
   $token = generate_shiprocket_token($database_connection);
			}else{
				$token = $fetch_shiprocket_token['Token'];
			}
			return $token;
}

function generate_shiprocket_token($database_connection) {

date_default_timezone_set('Asia/Kolkata');

   $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://apiv2.shiprocket.in/v1/external/auth/login",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS =>"{\n    \"email\": \"snackspace.gaming@gmail.com\",\n    \"password\": \"SnackSpace@5321\"\n}",
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json"
    ),
  ));
  $SR_login_Response = curl_exec($curl);
  curl_close($curl);
  $SR_login_Response_out = json_decode($SR_login_Response);
  $token = $SR_login_Response_out->{'token'};
  $registration_date_time = date('Y-m-d h:i:s');
  
  $update_token = mysqli_query($database_connection,"update ShipRocket_Token set Token='$token',Registration_Date_Time='$registration_date_time' where Id='1'");
  return $token;
}

function place_shiprocket_order($database_connection,$token,$order_id,$product_length,$product_breadth,$product_height,$product_weight) {
			
			$fetch_order_details = mysqli_fetch_array(mysqli_query($database_connection,"select * from Orders where Id='$order_id'"));
			
	$order_date_time = $fetch_order_details['Order_Date_Time']; 
			
		$customer_name = $fetch_order_details['Customer_Name'];
			
		$customer_email_id = $fetch_order_details['Customer_Email_Id'];
			
		$customer_mobile_number = $fetch_order_details['Customer_Mobile_Number'];
			
		$customer_address = $fetch_order_details['Customer_Address'];
			
		$customer_pincode = $fetch_order_details['Customer_Pincode'];
			
		$customer_state = $fetch_order_details['Customer_State'];
			
		$customer_city = $fetch_order_details['Customer_City'];
			
		$total_price = $fetch_order_details['Total_Price'];
			
		$payment_type = $fetch_order_details['Payment_Type'];
			
if($payment_type == 'Online Payment') {
			$payment_metod = 'Prepaid'	;
			}else{
			$payment_metod = 'COD'	;		
			}
						
			$order_items = mysqli_query($database_connection,"select Order_Details.*,Products.Product_Name from Order_Details,Products where Order_Details.Order_Id='$order_id' and Products.Id=Order_Details.Product_Id");
			
			$insert_order_items = '';
			
			while($fetch_order_items = mysqli_fetch_array($order_items)){
			$insert_order_items.= '{
      "name": "'.$fetch_order_items['Product_Name'].'",
      "sku": "'.$fetch_order_items['Product_Id'].'",
      "units": '.$fetch_order_items['Quantity'].',
      "selling_price": "'.$fetch_order_items['Price'].'",
      "discount": "",
      "tax": "",
      "hsn": ""
    },';		
			}
			
  $insert_order_items = rtrim($insert_order_items,",");

			$curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://apiv2.shiprocket.in/v1/external/orders/create/adhoc",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS =>'{"order_id": "'.$order_id.'",
  "order_date": "'.$order_date_time.'",
  "pickup_location": "Dombivli",
  "billing_customer_name": "'.$customer_name.'",
  "billing_last_name": "",
  "billing_address": "'.$customer_address.'",
  "billing_address_2": "",
  "billing_city": "'.$customer_city.'",
  "billing_pincode": "'.$customer_pincode.'",
  "billing_state": "'.$customer_state.'",
  "billing_country": "India",
  "billing_email": "'.$customer_email_id.'",
  "billing_phone": "'.$customer_mobile_number.'",
  "shipping_is_billing": true,
  "shipping_customer_name": "",
  "shipping_last_name": "",
  "shipping_address": "",
  "shipping_address_2": "",
  "shipping_city": "",
  "shipping_pincode": "",
  "shipping_country": "",
  "shipping_state": "",
  "shipping_email": "",
  "shipping_phone": "",
  "order_items": ['.$insert_order_items.'],
  "payment_method": "'.$payment_metod.'",
  "shipping_charges": 0,
  "giftwrap_charges": 0,
  "transaction_charges": 0,
  "total_discount": 0,
  "sub_total": "'.$total_price.'",
  "length": "'.$product_length.'",
  "breadth": "'.$product_breadth.'",
  "height": "'.$product_height.'",
  "weight": "'.$product_weight.'"
	}',
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json",
	   "Authorization: Bearer $token"
    ),
  ));
  $SR_login_Response = curl_exec($curl);
  curl_close($curl);
  $SR_login_Response_out = json_decode($SR_login_Response);
  
  $shipping_order_id = $SR_login_Response_out->order_id;
  
  $shipment_id = $SR_login_Response_out->shipment_id;
  
  $update_shipping_details = mysqli_query($database_connection,"update Orders set Shipping_Order_Id='$shipping_order_id',Shipment_Id='$shipment_id' where Id='$order_id'");
  
  echo "Shipping Order Id :- ".$shipping_order_id.'<br/>';
  echo "Shipment Id :- ".$shipment_id.'<br/>';
}

function cancel_shiprocket_order($shipping_order_id,$token){

			$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://apiv2.shiprocket.in/v1/external/orders/cancel",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>"{\n  \"ids\": [".$shipping_order_id."]\n}",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    "Authorization: Bearer $token"
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
}

function redirect_page($destination){
			?>
			<script>
						window.location.href='<?php echo $destination ?>';
			</script>
			<?php
}
?>
