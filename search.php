<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/web/core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';


if(!isset($_POST['search'])){
  header("Location: index.php");
}

if(isset($_POST['search'])){
  $searchQ = $_POST['search'];
  
  $sql = "SELECT * FROM products WHERE title LIKE '%$searchQ%' OR description LIKE '%$searchQ%'";
  $searchR = $db->query($sql);
  $search_number = $searchR->num_rows
?>


	<h3 class="m_1">Search Results</h3>
	<hr>
	<div class="container">
	<div class="women_main">
		<div class="col-md-9 w_content">

			<!-- grids_of_4 -->
	<div class="grids_of_4">

				<?php
        if($search_number == 0){
          echo "Your search did not have any results.";
        }else{
          $i=0;
          while($product = mysqli_fetch_assoc($searchR)):
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
}}



 include 'includes/footer.php'; ?>
