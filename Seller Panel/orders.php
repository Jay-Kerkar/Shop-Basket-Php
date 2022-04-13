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
                              <th>Product Name</th>
                              <th>Product Quantity</th>
                              <th>Order Date</th>
                              <th>Shipping Address</th>
                              <th>Order Total</th>
                              <th>Payment Type</th>
                              <th>Payment Status</th>
                              <th>Order Status</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php 
  echo "select Order_Details.Quantity,Products.Product_Name,Orders.*,Order_Status.Status as order_status_string,Payment_Status.Status as payment_status_string from Orders,Order_Details,Order_Status,Payment_Status,Products where Order_Status.Id=Orders.Order_Status and Products.Id=Order_Details.Product_Id and Order_Details.Order_Id=Orders.Id and Products.Listing_Person_Id='".$_SESSION['SELLER_ID']."' order by Orders.Id desc";                            $select_order_details = mysqli_query($database_connection,"select Order_Details.Quantity,Products.Product_Name,Orders.*,Order_Status.Status as order_status_string,Payment_Status.Status as payment_status_string from Orders,Order_Details,Order_Status,Payment_Status,Products where Order_Status.Id=Orders.Order_Status and Products.Id=Order_Details.Product_Id and Order_Details.Order_Id=Orders.Id and Products.Listing_Person_Id='".$_SESSION['SELLER_ID']."' order by Orders.Id desc");
                              
                              while($fetch_order_details = mysqli_fetch_array($select_order_details)){
                              ?>
                           <tr>
                              <td><?php echo $fetch_order_details['Id']?></td>
                              <td><?php echo $fetch_order_details['Product_Name']?></td>
                              <td><?php echo $fetch_order_details['Quantity']?></td>
                              <td><?php echo $fetch_order_details['Order_Date_Time']?></td>
                              <td><?php echo $fetch_order_details['Customer_Address']?></td>
                              <td><?php echo $fetch_order_details['Total_Price']?></td>
                              <td><?php echo $fetch_order_details['Payment_Type']?></td>
                              <td><?php echo $fetch_order_details['payment_status_string'] ?></td>
                              <td><?php echo $fetch_order_details['order_status_string']?></td>
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

<?php 
   require('footer.php'); 
?>
