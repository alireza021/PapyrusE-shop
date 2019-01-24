<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/web/core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';
?>

<?php
$id = $_GET['id'];
$id = (int)$id;
$sql = "SELECT * FROM products WHERE id = '$id'";
$result = $db->query($sql);
$product = mysqli_fetch_assoc($result);
$sizestring = $product['size'];
$sizestring = rtrim($sizestring, ',');
$size_array = explode(',', $sizestring);

$colorstring = $product['colors'];
$color_array = explode(',', $colorstring);

?>
<link rel="stylesheet" href="css/etalage.css"/>
<script src="js/jquery.etalage.min.js"></script>
<script>
			jQuery(document).ready(function($){

				$('#etalage').etalage({
					thumb_image_width: 300,
					thumb_image_height: 400,
					source_image_width: 900,
					source_image_height: 1200,
					show_hint: true,
					click_callback: function(image_anchor, instance_id){
						alert('Callback example:\nYou clicked on an image with the anchor: "'+image_anchor+'"\n(in Etalage instance: "'+instance_id+'")');
					}
				});

			});
		</script>
<!--initiate accordion-->
<script type="text/javascript">
	$(function() {

	    var menu_ul = $('.menu_drop > li > ul'),
	           menu_a  = $('.menu_drop > li > a');

	    menu_ul.hide();

	    menu_a.click(function(e) {
	        e.preventDefault();
	        if(!$(this).hasClass('active')) {
	            menu_a.removeClass('active');
	            menu_ul.filter(':visible').slideUp('normal');
	            $(this).addClass('active').next().stop(true,true).slideDown('normal');
	        } else {
	            $(this).removeClass('active');
	            $(this).next().stop(true,true).slideUp('normal');
	        }
	    });

	});
</script>
<hr>
<div class="single_top">
	 <div class="container">
	      <div class="single_grid">
				<div class="grid images_3_of_2">
						<ul id="etalage">
							<?php $photos = explode(',', $product['image']);
							foreach($photos as $photo): ?>
							<li>
								<a href="optionallink.php">

									<img class="etalage_thumb_image" src="<?= $photo; ?>"class="img-responsive" />
									<img class="etalage_source_image" src="<?= $photo; ?>" class="img-responsive" title="" />
								</a>
							</li>
						<?php endforeach; ?>

						</ul>

						 <div class="clearfix"></div>
				  </div>
				  <div class="desc1 span_3_of_2">

					<h1><?=$product['title']; ?></h1>
					<hr>
					<p><?=$product['description']; ?></p>
					<form method="post" id="add_product_form">
						<input type="hidden" name="product_id" value="<?=$id;?>">
						<div class="form-group">
							<div class="dropdown_top">
							<label for="quantity">Quantity:</label>
							<input type="number" name="quantity" min="1" id="quantity">
							&ensp;

							 <select name="stamptype" class="dropdown" id="stamptype">
								 <?php if($product['categories'] == 10){ ?>
									 <option value="Self-inking Stamp">Self Inking Stamp</option>
						 <option value="Pre-inked Stamp">Pre-inked Stamp</option>
						 <?php	} ?>
						 <?php if($product['categories'] == 13){ ?>
							 <option value="Eminent Kit">Eminent Kit</option>
				 <option value="Eminent Line (Assembled Stamp)">Eminent Line (Assembled Stamp)</option>
				 <?php	} ?>
									</select>

										 &ensp;
					     <select class="dropdown" name="size" id="size">
	            			<option value="">Select size</option>
										<?php foreach($size_array as $string){
											$string_array = explode(':', $string);
											$size = $string_array[0];
											$metric = $string_array[1];
											echo '<option value="'.$size.'">'.$size.' '.$metric.'</option>';
										} ?>

			             </select>
											&ensp;
										<select class="dropdown" name="colors" id="colors">
			 	            			<option value="">Select color</option>
			 										<?php foreach($color_array as $string){
			 											$color = $string;
			 											echo '<option value="'.$color.'">'.$color.'</option>';
			 										} ?>

			 			             </select>

											 </div>
								</form>



						 <div class="clearfix"></div>
						 <span id="modal_errors" class="bg-danger"></span>
			         </div>
			         <div class="simpleCart_shelfItem">
			         	<div class="price_single">
						  <div class="head"><h2><?= $product['price'];?> AED</h2></div>
					       <div class="clearfix"></div>
					     </div>
			               <!--<div class="single_but"><a href="" class="item_add btn_3" value=""></a></div>-->
			              <div class="size_2-right"><button class="btn btn-danger btn-lg sharp" onclick="add_to_cart();return false;"/>Add to Cart</button></div>

			         </div>
				</div>
          	    <div class="clearfix"></div>
          	   </div>
							<hr>


					<div class="extraInfo">
						<img src="<?=$product['extrainfo'];?>" class="img-responsive"></img>
					</div>


   </div>
	  &nbsp;

	 <hr>


   <h3 class="m_2">Related Products</h3>

	     <div class="container">
          		<div class="box_3" id="related_products" >
								<?php
								$cats = $product['categories'];
								$sql = "SELECT * FROM products WHERE categories = '$cats' ORDER BY id DESC LIMIT 4";
								$productQ = $db->query($sql);

								while($rproduct = mysqli_fetch_assoc($productQ)) :
									$product_photos = $rproduct['image'];
		  					  $photo_array = explode(',', $product_photos);
								?>
          			<div class="col-md-3">
          				<div class="content_box"><a href="single.php?id=<?=$rproduct['id'];?>">
			   	          <img src="<?=$photo_array[0];?>" class="img-responsive" alt="<?=$rproduct['title'];?>">
				   	   </a>
				   </div>
				    <h4><a href="single.php?id=<?=$rproduct['id'];?>"><?=$rproduct['title'];?></a></h4>
				    <p><?=money($rproduct['price']);?></p>
			        </div>
						<?php endwhile;?>

			        <div class="clearfix"> </div>
          		</div>
          	</div>
        </div>
<?php include 'includes/footer.php'; ?>
