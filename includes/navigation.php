<?php
$sql = "SELECT * FROM categories WHERE parent = 0";
$pquery = $db->query($sql);
?>

<body>

<div class="wrap-box"></div>
<div class="header_bottom">
	    <div class="container">
			<div class="col-xs-8 header-bottom-left">
				<div class="col-xs-2 logo">
					<a href = "index.php">
					<img width="115" height="70" src="images/logo.png" class="img-responsive"  alt="item1">
				</a>
				</div>
				<div class="col-xs-6 menu">
		            <ul class="megamenu skyblue">
									<?php while($parent = mysqli_fetch_assoc($pquery)) : ?>
										<?php
										$parent_id = $parent['id'];
										$sql2 = "SELECT * FROM categories WHERE parent = '$parent_id'";
										$cquery = $db->query($sql2);
										?>
				    	<li><a class="color1" href="index.php">Home</a></li>
				    <li><a class="color1" href="category.php">Products</a></li>

				<li><a class="color1" href="about.php">About</a></li>
				<li><a class="color1" href="404.php">Blog</a></li>
				<li><a class="color1" href="contact.php">Support</a></li>
			<?php endwhile;
				?>
			  </ul>
			</div>
		</div>

	    <div class="col-xs-4 header-bottom-right">
	       <div class="box_1-cart">
		     <div class="box_11"><a href="cart.php">
					 <?php
					  if($cart_id != ''){
					 	$cartQ = $db->query("SELECT * FROM cart WHERE id ='{$cart_id}'");
					 	$result = mysqli_fetch_assoc($cartQ);
					 	$items = json_decode($result['items'],true);
					 	$i = 1;
					 	$sub_total = 0;
					 	$item_count = 0;


					 foreach($items as $item){
			 			$product_id = $item['id'];
			 			$productQ = $db->query("SELECT * FROM products WHERE id = '{$product_id}'");
			 			$product = mysqli_fetch_assoc($productQ);
						$item_count += $item['quantity'];
						$sub_total += ($product['price'] * $item['quantity']);
					}

					 ?>

		      <h4><p>Cart: <span><?=money($sub_total);?></span></p><img src="images/bag.png" alt=""/><div class="clearfix"> </div></h4>
			<?php	}else{ ?>
					<h4><p>Cart Empty</p><img src="images/bag.png" alt=""/><div class="clearfix"> </div></h4>
				<?php } ?>
		      </a></div>

	          <div class="clearfix"> </div>
	        </div>
	        <div class="search">
						<form action="search.php" method="post">
				<input type="text" name="search" class="textbox" placeholder="Search">
				<input type="submit" value="Subscribe" id="submit">
				<div id="response"> </div>
				 </form>
		     </div>

	         <div class="clearfix"></div>
       </div>
        <div class="clearfix"></div>
	 </div>
</div>
&nbsp;
