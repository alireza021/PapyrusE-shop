<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/web/core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';
?>

<div class="single_top">
	 <div class="container">
	  <div class="map">
	     <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3608.0708705542556!2d55.29926511501095!3d25.268201283863213!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5f4347ad16525b%3A0x424bee43bd519560!2sAl+Kabeer+St+-+Dubai+-+United+Arab+Emirates!5e0!3m2!1sen!2scz!4v1494117037631"></iframe>
	   </div>
	   <div class="col-md-9 contact_left">
		 	  <h1>Get in Touch</h1>

	  			 <form action="thankYou2.php" method="post">
					<div class="column_2">
                     	<input type="text" class="text"  placeholder="" value="Name" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Name';}">
					 	<input type="text" class="text"  placeholder="" value="Email" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Email';}" style="margin-left:2.7%">
					 	<input type="text" class="text"  placeholder="" value="Subject" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Subject';}" style="margin-left:2.7%">
					</div>
					<div class="column_3">
	                   <textarea value="Message"  placeholder="" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Message';}">Message</textarea>
	                </div>
	                <div class="form-submit1">
			          <input type="submit" value="Send Message">
					</div>
					<div class="clearfix"> </div>
				  </form>
		 </div>
		 <div class="col-md-3 contact_right">
		 	<h2>Information</h2>
		 	<address class="address">
              <p>Al Kabeer Street, Deira <br>Dubai, United Arab Emirates.</p>
              <dl>
                 <dt></dt>
                 <dd>Telephone:<span>+971 4 2266450</span></dd>
                 <dd>FAX: <span>+971 4 2290435</span></dd>
                 <dd>E-mail:&nbsp; <a href="mailto@example.com">contact@shiny.com</a></dd>
              </dl>
           </address>
		 </div>
      </div>
</div>


<?php include 'includes/footer.php'; ?>
