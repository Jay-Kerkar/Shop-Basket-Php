<?php  
include('../Invoice/autoload.php');

$css = file_get_contents('css/style.css');
$css.=file_get_contents('css/bootstrap.css');
$css.=file_get_contents('css/order_summary.css');
$css.=file_get_contents('css/reset.css');

$html = 
'<!-- My Orders -->
	<div class="shopping-cart section">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<!-- Shopping Summery -->
					<table class="table shopping-summery">
						<thead>							
							 <tr class="main-hading">
											<th>Product Name</th>					
											<th>Product Image</th>
											<th>Price</th>
											<th>Quantity</th>
											<th>Total Price</th> 
							 </tr>
						</thead>
					 <tbody> 
									<tr> 
												<td class="product-des" data-title="Description"> 
															<p class="product-name"> 
															<a href="product_details.php?id=14">boAt Bassheads 242 in Ear Wired Earphones with Mic (Red)
															</a> 
															</p> 
															<p class="product-des">Android Phone Control, IOS Phone Control, Tangle-Free Cord, Lightweight, Volume-Control, Microphone Feature</p> 												
												</td>
												<td class="image" data-title="No"> 
															<a href="product_details.php?id=14">
															<img src="../Media/Products/183054856_Boat Bassheads 242 Red.jfif">
															</a>
												</td> 
												<td data-title="Price">
															<span>499</span>
												</td> 
												<td class="qty" data-title="Qty">1	
												</td> 
												<td class="total-amount" data-title="Total">
															<span>499</span>
												</td> 
										</tr> 
								</tbody> 
						</table> 
						<!--/ End Shopping Summery --> 
			       			</div> 
												</div> 
				  			</div> 
						</div>
			</div> 
</div> 
<!--/ End Shopping Cart --> 

<div class="row"> 
			<div class="col-12">
						<!-- Total Amount --> 
									<div class="total-amount"> 
												<div class="row"> 
															<!-- Total Amount --> 
																		<div class="col-lg-4 col-md-7 col-12"> 
																					<div class="right"> 
																											<ul> 
																														<li>Total Price<span>Rs 499</span>
																														</li> 
																											</ul>  
																								</div> 
																					</div> 
																		</div> 
															</div> 
												<!--/ End Total Amount -->
									</div> 
						</div> 
			</div> 
</div>';
	
$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($css,1);
$mpdf->WriteHTML($html,2);
$mpdf->Output('invoice.pdf');

?>
