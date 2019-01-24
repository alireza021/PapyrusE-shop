<div class="footer">
	<div class="container">
	   <div class="footer_top">
		<div class="col-md-4 box_3">
			<h3>Our Stores</h3>
			<address class="address">
              <p>Al-Kabeer Street, Dubai, UAE<br>P.O.Box: 30434.</p>
              <dl>
                 <dt></dt>
                 <dd>Telephone:<span> +971 4 2266450</span></dd>
                 <dd>FAX: <span>+971 4 2290435</span></dd>
                 <dd>E-mail:&nbsp; <a href="mailto@example.com">contact@shiny.com</a></dd>
              </dl>
           </address>
           <ul class="footer_social">
			  <li><a href=""> <i class="fb"> </i> </a></li>
			  <li><a href=""><i class="tw"> </i> </a></li>
			  <li><a href=""><i class="google"> </i> </a></li>
			  <li><a href=""><i class="instagram"> </i> </a></li>
		   </ul>
		</div>
		<div class="col-md-4 box_3">
			<h3>Events</h3>
			<h4><a href="#">Paperworld Middle East 2017</a></h4>
			<p>March 14 to 16 - Dubai</p>
			<h4><a href="#">Paperworld Middle East 2016</a></h4>
			<p>March 1st to 3rd - Dubai</p>
			<h4><a href="#">Paperworld Middle East 2015</a></h4>
			<p>March 1st to 3rd - Dubai</p>
		</div>
		<div class="col-md-4 box_3">
			<h3>Support</h3>
			<ul class="list_1">
				<li><a href="#">Terms & Conditions</a></li>
				<li><a href="#">FAQ</a></li>
				<li><a href="#">Payment</a></li>
				<li><a href="#">Refunds</a></li>
				<li><a href="#">Track Order</a></li>
				<li><a href="#">Services</a></li>
			</ul>
			<ul class="list_1">
				<li><a href="#">Services</a></li>
				<li><a href="#">Press</a></li>
				<li><a href="#">Blog</a></li>
				<li><a href="#">About Us</a></li>
				<li><a href="#">Contact Us</a></li>
			</ul>
			<div class="clearfix"> </div>
		</div>
		<div class="clearfix"> </div>
		</div>
		<div class="footer_bottom">
			<div class="copy">
                <p>Copyright © 2017 Alireza Shafiei</p>
	        </div>
	    </div>
	</div>
</div>

<script>
function update_cart(mode, edit_id, edit_size, edit_stamptype){
	var data = {"mode" : mode, "edit_id" : edit_id, "edit_size" : edit_size, "edit_stamptype" : edit_stamptype};
	jQuery.ajax({
		url : '/web/admin/parsers/update_cart.php',
		method : 'post',
		data : data,
		success : function(){location.reload();},
		error : function(){alert('Something went wrong!');},
	});
}

function add_to_cart(){
	jQuery('#modal_errors').html('');
	var size = jQuery('#size').val();
	var quantity = jQuery('#quantity').val();
	var stamptype = jQuery('#stamptype').val();
	var colors = jQuery('colors').val();
	var error = '';
	var data = jQuery('#add_product_form').serialize();
	if(size == '' || quantity == '' || colors == ''){
		error += '<p class ="text-danger text-center">You must select quantity, size, and color before adding to cart.</p>';
		jQuery('#modal_errors').html(error);
		return;
	}
	else{
		jQuery.ajax({
			url : '/web/admin/parsers/add_cart.php',
			method : 'post',
			data : data,
			success : function(){
				location.reload();
			},
			error : function(){
				alert('Something went wrong');
			}
		});
	}
}


</script>

</body>
</html>
