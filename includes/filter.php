<?php
$cart_id = ((isset($_REQUEST['cat']))?sanitize($_REQUEST['cat']):'');
$b = ((isset($_REQUEST['brand']))?sanitize($_REQUEST['brand']):'');
$brandQ = $db->query("SELECT * FROM brand ORDER BY brand");
$sql = "SELECT * FROM categories WHERE parent = 0";
$pquery = $db->query($sql);



?>


<!-- start sidebar -->
<div class="col-md-3">
  <div class="w_sidebar">
  <div class="w_nav1">

      <?php while($parent = mysqli_fetch_assoc($pquery)) : ?>
        <?php
        $parent_id = $parent['id'];
        $sql2 = "SELECT * FROM categories WHERE parent = '$parent_id'";
        $cquery = $db->query($sql2);
        ?>
      <?php endwhile; ?>
        <h4><a href="category.php">All Products</a></h4>



  </div>

  <section class="sky-form">
          <h4>Categories</h4>
          <div class="row1 scroll-pane">
            <div class="col col-4">
              <?php while ($child = mysqli_fetch_assoc($cquery)) : ?>
              <label class="radio"><input type="radio" name="category" onclick="window.location='category.php?cat=<?=$child['id'];?>'"><i></i><?=$child['category'];?></label>
            <?php endwhile; ?>

            </div>
          </div>
  </section>

  </div>
 </div>
