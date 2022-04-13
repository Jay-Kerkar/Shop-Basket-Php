<?php
require('header.php');
?>

<div class="content pb-0">
	<div class="orders">
	   <div class="row">
		  <div class="col-xl-12">
			 <div class="card">
				<div class="card-body">
				   <h4 class="box-title">Orders | Ecommerce Website </h4>			
				<div class="card-body--">
				   <div class="table-stats order-table ov-h">
					  <table class="table ">
						 <thead>
							<tr>
							 <th>Order Id</th>
								<th>Order Date</th>
								<th>Shipping Address</th>
								<th>Payment Type</th>
								<th>Payment Id</th>
								<th>Payment Status</th> 
								<th>Order Status</th>
								<th>Shipping Details</th>
								<th>View Details</th>
							</tr>
						 </thead>
						 <tbody>
						 			
							<?php 
							$select_order_details = mysqli_query($database_connection,"select Orders.*,Order_Status.Status as order_status_string,Payment_Status.Status as payment_status_string from Orders,Order_Status,Payment_Status where Order_Status.Id=Orders.Order_Status and Payment_Status.Id=Orders.Payment_Status         order by Orders.Id desc");
							
							while($fetch_order_details = mysqli_fetch_array($select_order_details)){
    ?>
							<tr>
							   <td><?php echo $fetch_order_details['Id']?></td>
							   <td><?php echo $fetch_order_details['Order_Date_Time']?></td>
							   <td><?php echo $fetch_order_details['Customer_Address']?></td>
							   <td><?php echo $fetch_order_details['Payment_Type']?></td>							 
							   <td><?php 						   if($fetch_order_details['Payment_Id']){
							  echo $fetch_order_details['Payment_Id'];
							   }else{
							   echo '-';		
							   }
							   ?></td>
							   <td><?php echo $fetch_order_details['payment_status_string'] ?></td>
							   <td><?php echo $fetch_order_details['order_status_string']?></td>
							   	<td><?php 
	 echo "Shipping Order Id :- ".$fetch_order_details['Shipping_Order_Id'].'<br/>';
  echo "Shipment Id :- ".$fetch_order_details['Shipment_Id'].'<br/>'; ?>
							   	</td>			   		 											
							   <td><span class='badge badge-edit'><a href='order_details.php?id=<?php echo $fetch_order_details['Id']?>'>View Details</a></span></td>
							</tr>
							<?php } ?>
						 </tbody>
					  </table>
				   </div>
				</div>
			 </div>
		  </div>
	   </div>
	</div>
</div>

<?php require('footer.php'); ?>
