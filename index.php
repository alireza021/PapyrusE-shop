<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/web/core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';

$sql = "SELECT * FROM products WHERE featured = 1 LIMIT 3";
$featured = $db->query($sql);
?>

<div class="banner img-responsive">
	<div class="container img-responsive">

	</div>
</div>
<div class="content_top">
	<h3 class="m_1">Featured Products</h3>
	<div class="container">
	   <div class="box_1">
	       <div class="col-md-7">

			    <div class="section group">
						<?php while($product = mysqli_fetch_assoc($featured)) :
 						 $product_photos = $product['image'];
 						 $photo_array = explode(',', $product_photos);
 						 ?>
						<div class="col_1_of_3 span_1_of_3 simpleCart_shelfItem">
							<div class="shop-holder">
		                         <div class="product-img">
		                            <a href="single.php?id=<?=$product['id'];?>" </a>
		                                <img width="225" height="265" src="<?=$photo_array[0];?>" class="img-responsive"  alt="<?=$product['title'];?>">		                            </a>
		                            <class="button item_add"></a>		                         </div>
		                    </div>
		                    <div class="shop-content" style="height: 80px;">
		                            <div><rel="tag">Shiny</a></div>
		                            <h3><a href="single.php?id=<?=$product['id'];?>"><?= $product['title'];?></a></h3>
		                            <span class="amount item_price"><?= $product['price'];?> AED</span>
		                    </div>
						</div>
					<?php endwhile; ?>

						<div class="clearfix"></div>
				</div>
		</div>
		<div class="col-md-5 row_3">
			<div class="about-block-content">
		       <div class="border-add"></div>
				<h4>Fun Fact</h4>
				<p>By complying environmental standards, and focus on preventing pollution in advance as well as executing efficiently use of energy and raw materials from planning and development throughout the production process, Shiny received the ISO 14001 in 2009. </p>

				<p></p>
				</div>
				<img src="images/pic9.jpg" class="img-responsive" alt=""/>
	    </div>
		<div class="clearfix"></div>
	</div>
</div>
</div>

<?php include 'includes/footer.php'; ?>
