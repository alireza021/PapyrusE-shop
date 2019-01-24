<?php
require_once 'core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';


?>

<div class="container">
	<div class="check">
		<div class="col-md-9 cart-items">
			 <h1>My Shopping Cart</h1>

			  <?php if($cart_id == ''): ?>
					<div>
			<p>Your shopping cart is empty!</p>
		</div>
	<?php else:
		foreach($items as $item){
			$product_id = $item['id'];
			$productQ = $db->query("SELECT * FROM products WHERE id = '{$product_id}'");
			$product = mysqli_fetch_assoc($productQ);
			$sArray = explode(',', $product['size']);
			$product_photos = $product['image'];
			$photo_array = explode(',', $product_photos);
			foreach($sArray as $sizeString){
				$s = $sizeString;

			}
			?>
			 <div class="cart-header">
				 <!-- <div class="close1"> </div> -->
				 <div class="cart-sec simpleCart_shelfItem">
						<div class="cart-item cyc">
							 <img src="<?=$photo_array[0];?>" class="img-responsive" alt="<?=$product['title'];?>"/>
						</div>
					   <div class="cart-item-info">
						<h3><a href="#"><?=$product['title'];?></a><span><?=$item['stamptype'];?></span></h3>
						<div>
						<p><b>Price : <?=money($product['price']);?></b></p>
					</div>
						<ul class="qty">
							<li><p>Size : <?=$item['size'];?></p></li>
							<li><p>Color : <?=$item['colors'];?></p></li>
							<li><p>Quantity : <button class="btn btn-xs btn-default" onclick="update_cart('removeone','<?=$product['id'];?>','<?=$item['size'];?>','<?=$item['stamptype'];?>');">-</button>&nbsp;<?=$item['quantity'];?>&nbsp;
														<button class="btn btn-xs btn-default" onclick="update_cart('addone','<?=$product['id'];?>','<?=$item['size'];?>','<?=$item['stamptype'];?>');">+</button></p></li>
						</ul>

						<div class="delivery">
							 <span>Delivered in 2-3 bussiness days</span>
							 <div class="clearfix"></div>
				        </div>
					   </div>
					   <div class="clearfix"></div>

				  </div>
			 </div>

		<?php

			}


		  endif;

		if($cart_id != ''){ ?>

		 </div>
		 <div class="col-md-3 cart-total">
			 <a class="continue" href="#">Continue Shopping</a>
			 <div class="price-details">
			<h3>Price Details</h3>


				 <span>Subtotal (<?=$item_count;?> items)</span>
				 <span class="total1"><?=money($sub_total);?></span>
				 <span>Delivery Charges</span>
				 <span class="total1">---</span>
				 <div class="clearfix"></div>
			 </div>
			 <ul class="total_price">
			   <li class="last_price"> <h4>TOTAL</h4></li>
			   <li class="last_price"><span><?=money($sub_total);?></span></li>
			   <div class="clearfix"> </div>
			 </ul>


			 <div class="clearfix"></div>
			 <!-- Button trigger modal -->
<div>
<button type="button" class="btn btn-block sharp btn-danger btn-lg center-block  " id="checkoutbtn" data-toggle="modal" data-target="#checkoutModal">
  Place Order
</button>

<?php } ?>

<!-- Modal -->
<div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="checkoutModalLabel">Contact & Delivery</h4>
      </div>
      <div class="modal-body">
				<div class="row">
        <form action="thankYou.php" method="post" id="payment-form">
					<span class="bg-danger" id="payment-errors"></span>
					<input type="hidden" name="sub_total" value="<?=$sub_total;?>">
					<input type="hidden" name="cart_id" value="<?=$cart_id;?>">
					<input type="hidden" name="description" value="<?=$item_count.' item'.(($item_count>1)?'s':'').' from Papyrus e-shop.';?>">
					<div id="step1" style="display:block;">
						<div class="form-group col-md-6">
						<label for="full_name">Full Name*:</label>
						<input class="form-control" id="full_name" name="full_name" type="text">
						</div>
						<div class="form-group col-md-6">
						<label for="email">Email*:</label>
						<input class="form-control" id="email" name="email" type="email">
						</div>
						<div class="form-group col-md-6">
						<label for="telephone">Telephone*:</label>
						<input class="form-control" id="telephone" name="telephone" type="text">
						</div>
						<div class="form-group col-md-6">
						<label for="company">Company Name:</label>
						<input class="form-control" id="company" name="company" type="text">
						</div>
						<div class="form-group col-md-6">
						<label for="street">Street Address*:</label>
						<input class="form-control" id="street" name="street" type="text" data-stripe="address_line1">
						</div>
						<div class="form-group col-md-6">
						<label for="street2">Street Address 2:</label>
						<input class="form-control" id="street2" name="street2" type="text" data-stripe="address_line2">
						</div>
						<div class="form-group col-md-6">
						<label for="city">City*:</label>
						<select class="form-control" id="city" name="city" type="text" data-stripe="address_city">
							<option value="Dubai">Dubai</option>
							<option value="Sharjah">Sharjah</option>
							<option value="Abu Dhabi">Abu Dhabi</option>
							<option value="Ajman">Ajman</option>
							<option value="Quwain">Umm al-Quwain</option>
							<option value="Fujairah">Fujairah</option>
							<option value="Khaimah">Ras al-Khaimah</option>
						</select>
						</div>
						<div class="form-group col-md-6">
						<label for="country">Country:</label>
						<input class="form-control" id="country" name="country" type="text" value="United Arab Emirates" data-stripe="address_country"readonly>
						</div>
						<div class="form-group col-md-8">
						<label for="extra_request">Extra Requests:</label>
						<textarea id="extra_request" name="extra_request" class="form-control" rows="6"></textarea>
						</div>
					</div>
					<div id="step2" style="display:none;">
						<div class="form-group col-md-3">
							<label for="name">Name on Card:</label>
							<input type="text" id="name" class="form-control" data-stripe="name">
						</div>
						<div class="form-group col-md-3">
							<label for="number">Card Number:</label>
							<input type="text" id="number" class="form-control" data-stripe="number">
						</div>
						<div class="form-group col-md-2">
							<label for="cvc">CVC:</label>
							<input type="text" id="cvc" class="form-control" data-stripe="cvc">
						</div>
						<div class="form-group col-md-2">
							<label for="exp-month">Expire Month:</label>
							<select id="exp-month" class="form-control" data-stripe="exp_month">
								<option value=""></option>
								<?php for($i=1;$i<13;$i++) :?>
									<option value="<?=$i;?>"><?=$i;?></option>
								<?php endfor;?>
								</select>
						</div>
						<div class="form-group col-md-2">
							<label for="exp-year">Expire Year:</label>
							<select id="exp-year" class="form-control" data-stripe="exp_year">
								<option value=""></option>
								<?php $yr= date("Y")?>
								<?php for($i=0;$i<11;$i++) :?>
									<option value="<?=$yr + $i;?>"><?=$yr + $i;?></option>
								<?php endfor;?>
							</select>
						</div>
					</div>
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-danger" onclick="check_address();" id="next_button">Next</button>
				<button type="button" class="btn btn-danger" onclick="back_address();" id="back_button" style="display:none;">Back</button>
				<button type="submit" class="btn btn-danger" id="checkout_button" style="display:none;">Place Order</button>
      </div>
			</form>
    </div>
  </div>
</div>
</div>
			</div>
	 </div>
</div>

<script>

	function back_address(){
		jQuery('#payment-errors').html("");
		jQuery('#step1').css("display","block");
		jQuery('#step2').css("display" ,"none");
		jQuery('#next_button').css("display","inline-block");
		jQuery('#back_button').css("display","none");
		jQuery('#checkout_button').css("display","none");
		jQuery('#checkoutModalLabel').html("Contact & Delivery");
	}

	function check_address(){
			var data = {
				'full_name' : jQuery('#full_name').val(),
				'email' : jQuery('#email').val(),
				'telephone' : jQuery('#telephone').val(),
				'company' : jQuery('#company').val(),
				'extra_request' : jQuery('#extra_request').val(),
				'street' : jQuery('#street').val(),
				'street2' : jQuery('#street2').val(),
				'city' : jQuery('#city').val(),
			};
			jQuery.ajax({
				url : '/web/admin/parsers/check_address.php',
				method : 'POST',
				data : data,
				success : function(data){
					if(data != 'passed'){
						jQuery('#payment-errors').html(data);
					}

					if(data == 'passed'){
						jQuery('#payment-errors').html("");
						jQuery('#step1').css("display","none");
						jQuery('#step2').css("display" ,"block");
						jQuery('#next_button').css("display","none");
						jQuery('#back_button').css("display","inline-block");
						jQuery('#checkout_button').css("display","inline-block");
						jQuery('#checkoutModalLabel').html("Card Details");
					}
				},
				error : function(){alert('Something went wrong!');},
			});
	}

	Stripe.setPublishableKey('<?=STRIPE_PUBLIC;?>');

	function stripeResponseHandler(status,response) {
		var $form = $('#payment-form');

		if(response.error){
			//show errors
			$form.find('#payment-errors').text(response.error.message);
			$form.find('button').prop('disabled', false);
		} else{
			var token = response.id;

			$form.append($('<input type="hidden" name="stripeToken" />').val(token));

			$form.get(0).submit();
		}

}

	jQuery(function($){
		$('#payment-form').submit(function(event){
			var $form = $(this);

			//Disable the submit button to prevent repeated clicks
			$form.find('button').prop('disabled', true);

			Stripe.card.createToken($form, stripeResponseHandler);

			//Prevent form from submitting without default action
			return false;


		});

	});


</script>

<?php include 'includes/footer.php'; ?>
