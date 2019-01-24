<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/web/core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';

if(isset($_GET['cat'])){
	$cat_id = sanitize($_GET['cat']);
	$sql = "SELECT * FROM products WHERE categories = '$cat_id'";

	$productQ = $db->query($sql);
	$category = get_category($cat_id);
	?>

	<h3 class="m_1"><?=$category['child'];?></h3>
	<hr>
	<div class="container">
	<div class="women_main">
		<div class="col-md-9 w_content">

			<!-- grids_of_4 -->
	<div class="grids_of_4">

				<?php
				$i=0;
				while($product = mysqli_fetch_assoc($productQ)) :
					if($i % 4 == 0){
						echo '</div><div class="grid_of_4">';
					 }
					 $product_photos = $product['image'];
					 $photo_array = explode(',', $product_photos);
			?>
			  <div class="grid1_of_4 simpleCart_shelfItem">
					<div class="content_box"><a href="single.php?id=<?=$product['id'];?>">
				   	  <div class="view view-fifth">
				   	   	 <img src="<?=$photo_array[0];?>" class="img-responsive" alt="<?=$product['title'];?>"/>
					   	   	<div class="mask1">
		                        <div class="info"> </div>
				            </div>
					   	  </a>
					   </div>
						 <hr>
					    <h5><a href="single.php?id=<?=$product['id'];?>"><?=$product['title'];?></a></h5>
							<h6>Shiny</h6>
					     <div class="size_1">
								 
					     	<span class="item_price"><?= $product['price'];  ?> AED</span>

			      		    <div class="clearfix"></div>
			      		  </div>

				     </div>
				</div>

				<?php $i++;
			endwhile; ?>

				<div class="clearfix"></div>
			</div>

			<!-- end grids_of_4 -->
		</div>
		<!-- start sidebar -->
		<?php include 'includes/filter.php';?>
		<!-- start content -->
	   <div class="clearfix"></div>
	   <!-- end content -->
	 </div>
	</div>
<?php

}else{
	$cat_id = '';

	$sql = "SELECT * FROM products";

	$productQ = $db->query($sql);

	?>

	<h3 class="m_1">All Products</h3>
	<hr>
	<div class="container">
	<div class="women_main">
		<div class="col-md-9 w_content">

			<!-- grids_of_4 -->
	<div class="grids_of_4">

				<?php
				$i=0;
				while($product = mysqli_fetch_assoc($productQ)) :
					if($i % 4 == 0){
						echo '</div><div class="grid_of_4">';
					 }
					 $product_photos = $product['image'];
					 $photo_array = explode(',', $product_photos);
			?>
			  <div class="grid1_of_4 simpleCart_shelfItem">
					<div class="content_box"><a href="single.php?id=<?=$product['id'];?>">
				   	  <div class="view view-fifth">
				   	   	 <img src="<?=$photo_array[0];?>" class="img-responsive" alt="<?=$product['title'];?>"/>
					   	   	<div class="mask1">
		                        <div class="info"> </div>
				            </div>
					   	  </a>
					   </div>
						 <hr>
					    <h5><a href="single.php?id=<?=$product['id'];?>"><?=$product['title'];?></a></h5>
							<h6>Shiny</h6>

					     <div class="size_1">
					     	<span class="item_price"><?= $product['price'];  ?> AED</span>

			      		    <div class="clearfix"></div>
			      		  </div>

				     </div>
				</div>

				<?php  $i++;
			endwhile; ?>

				<div class="clearfix"></div>
			</div>

			<!-- end grids_of_4 -->
		</div>
		<?php include 'includes/filter.php';?>
		<!-- start content -->
	   <div class="clearfix"></div>
	   <!-- end content -->
	 </div>
	</div>





	<?php

}




 include 'includes/footer.php'; ?>
