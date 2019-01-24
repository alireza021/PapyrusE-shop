<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/web/core/init.php';
if(!is_logged_in()){
  login_error_redirect();
}
include 'includes/head.php';
include 'includes/navigation.php';

//Delete Product
if(isset($_GET['delete'])){
  $id = sanitize($_GET['delete']);
  $db->query("UPDATE products SET deleted = 1 WHERE id = '$id'");
  header('Location: products.php');
}

$dbpath = '';
if (isset($_GET['add']) || isset($_GET['edit'])){
$brandQuery = $db->query("SELECT * FROM brand ORDER BY brand");
$parentQuery = $db->query("SELECT * FROM categories WHERE parent = 0 ORDER BY category");
$title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):'');
$brand = ((isset($_POST['brand']) && !empty($_POST['brand']))?sanitize($_POST['brand']):'');
$parent = ((isset($_POST['parent']) && !empty($_POST['parent']))?sanitize($_POST['parent']):'');
$category = ((isset($_POST['child'])) && !empty($_POST['child'])?sanitize($_POST['child']):'');
$price = ((isset($_POST['price']) && $_POST['price'] != '')?sanitize($_POST['price']):'');
$colors = ((isset($_POST['colors']) && $_POST['colors'] != '')?sanitize($_POST['colors']):'');
$description = ((isset($_POST['description']) && $_POST['description'] != '')?sanitize($_POST['description']):'');
$size = ((isset($_POST['size']) && $_POST['size'] != '')?sanitize($_POST['size']):'');
$size = rtrim($size,',');
$saved_image = '';

if(isset($_GET['edit'])){
  $edit_id = (int)$_GET['edit'];
  $productResults = $db->query("SELECT * FROM products WHERE id = '$edit_id'");
  $product = mysqli_fetch_assoc($productResults);
  if(isset($_GET['delete_image'])){
    $imgi = (int)$_GET['imgi'] - 1;
    $images = explode(',',$product['image']);
    $image_url = $_SERVER['DOCUMENT_ROOT'].$images[$imgi];
    unlink($image_url);
    unset($images[$imgi]);
    $imageString = implode(',',$images);
    $db->query("UPDATE products SET image = '{$imageString}' WHERE id = '$edit_id'");
    header('Location: products.php?edit='.$edit_id);
  }
  $category = ((isset($_POST['child']) && $_POST['child'] != '')?sanitize($_POST['child']):$product['categories']);
  $title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):$product['title']);
  $brand = ((isset($_POST['brand']) && $_POST['brand'] != '')?sanitize($_POST['brand']):$product['brand']);
  $parentQ = $db->query("SELECT * FROM categories WHERE id = '$category'");
  $parentResult = mysqli_fetch_assoc($parentQ);
  $parent = ((isset($_POST['parent']) && $_POST['parent'] != '')?sanitize($_POST['parent']):$parentResult['parent']);
  $price = ((isset($_POST['price']) && $_POST['price'] != '')?sanitize($_POST['price']):$product['price']);
  $colors = ((isset($_POST['colors']) && $_POST['colors'] != '')?sanitize($_POST['colors']):$product['colors']);
  $description = ((isset($_POST['description']))?sanitize($_POST['description']):$product['description']);
  $size = ((isset($_POST['size']) && $_POST['size'] != '')?sanitize($_POST['size']):$product['size']);
  $size = rtrim($size,',');
  $saved_image = (($product['image'] != '')?$product['image']:'');
  $dbpath = $saved_image;
}
if (!empty($size)) {
  $sizeString = sanitize($size);
  $sizeString = rtrim($sizeString,',');
  $sizeArray = explode(',',$sizeString);
  $sArray = array();

  foreach($sizeArray as $ss){
    $sArray[] = $ss;

  }
}else{$sizeArray = array();}

if ($_POST) {
  $errors= array();
  $required = array('title', 'brand', 'price', 'parent', 'child', 'size');
  $allowed = array('png','jpg','jpeg','gif');
  $photoName = array();
  $tmpLoc = array();
  $uploadPath = array();
  $uploadName = array();
  foreach($required as $field){
    if($_POST[$field] == ''){
      $errors[] = 'All Fields With and Astrisk are required.';
      break;
    }
  }
  $photoCount = count($_FILES['photo']['name']);
   if ($photoCount > 0) {
     for($i=0;$i<$photoCount;$i++){
      $name = $_FILES['photo']['name'][$i];
      $nameArray = explode('.',$name);
      $fileName = $nameArray[0];
      $fileExt = $nameArray[1];
      $mime = explode('/',$_FILES['photo']['type'][$i]);
      $mimeType = $mime[0];
      $mimeExt = $mime[1];
      $tmpLoc[] = $_FILES['photo']['tmp_name'][$i];
      $fileSize = $_FILES['photo']['size'][$i];
      $uploadName = md5(microtime().$i).'.'.$fileExt;
      $uploadPath[] = BASEURL.'images/products/'.$uploadName;
      if($i != 0 && $i < $photoCount){
        $dbpath .= ',';
      }
      $dbpath .= '/web/images/products/'.$uploadName;
      if ($mimeType != 'image') {
        $errors[] = 'The file must be an image.';
      }
      if (!in_array($fileExt, $allowed)) {
        $errors[] = 'The file extension must be a png, jpg, jpeg, or gif.';
      }
      if ($fileSize > 15000000) {
        $errors[] = 'The files size must be under 15MB.';
      }
      if ($fileExt != $mimeExt && ($mimeExt == 'jpeg' && $fileExt != 'jpg')) {
        $errors[] = 'File extension does not match the file.';
      }
    }
   }
  if(!empty($errors)){
    echo display_errors($errors);
  }else{
    if($photoCount > 0){
    //upload file and insert into database
      for($i=0;$i<$photoCount;$i++){
        move_uploaded_file($tmpLoc[$i],$uploadPath[$i]);
      }
    }
    $insertSql = "INSERT INTO products (`title`,`price`,`brand`,`categories`,`size`, `colors`,`image`,`description`)
     VALUES ('$title','$price', '$brand', '$category','$size', '$colors', '$dbpath','$description')";
     if(isset($_GET['edit'])){
       $insertSql = "UPDATE products SET `title` = '$title', `price` = '$price',
       `brand` = '$brand', `categories` = '$category', `size` = '$size', `colors` = '$colors', `image` = '$dbpath', `description` = '$description'
       WHERE id ='$edit_id'";
     }

     $db->query($insertSql);
     header('Location: products.php');
  }
}

?>
  <h3 class="text-center"><?=((isset($_GET['edit']))?'Edit':'Add A New');?> Product</h3><hr>
<div class="container">

  <form action="products.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1');?>" method="POST" enctype="multipart/form-data">
    <div class="form-group col-md-3">
      <label for="title">Title*:</label>
      <input type="text" name="title" class="form-control" id="title" value="<?=$title;?>">
    </div>
    <div class="form-group col-md-3">
      <label for="brand">Brand*:</label>
      <select class="form-control" id="brand" name="brand">
        <option value=""<?=(($brand == '')?' selected':'');?>></option>
        <?php while($b = mysqli_fetch_assoc($brandQuery)): ?>
          <option value="<?=$b['id'];?>"<?=(($brand == $b['id'])?' selected':'');?>><?=$b['brand'];?></option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="form-group col-md-3">
      <label for="parent">Parent Category*:</label>
      <select class="form-control" id="parent" name="parent">
        <option value=""<?=(($parent == '')?' selected':'');?>></option>
        <?php while($p = mysqli_fetch_assoc($parentQuery)): ?>
          <option value="<?=$p['id'];?>"<?=(($parent == $p['id'])?' selected':'');?>><?=$p['category'];?></option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="form-group col-md-3">
      <label for="child">Child Category*:</label>
      <select id="child" name="child" class="form-control">
      </select>
    </div>
    <div class="form-group col-md-3">
      <label for="price">Price*:</label>
      <input type="text" id="price" name="price" class="form-control" value="<?=$price;?>">
    </div>

    <div class="form-group col-md-3">
      <label>Sizes:</label>
    <button class="btn btn-default form-control" onclick="jQuery('#sizeModal').modal('toggle'); return false;">Choose Sizes</button>
    </div>

    <div class="form-group col-md-3">
    <label for="size">Selected Sizes:</label>
    <input type="text" class="form-control" name="size" id="size" value="<?=$size;?>" readonly>
    </div>
    <div class="form-group col-md-3">
      <label for="colors">Number of Colors <small>(Seperated by commas)</small>:</label>
      <input type="text" name="colors" id="colors" min="1" class="form-control" value="<?=$colors;?>">
    </div>

    <div class="form-group col-md-6">
      <?php if($saved_image != ''): ?>
        <?php
        $imgi = 1;
        $images = explode(',',$saved_image); ?>
          <?php foreach($images as $image):?>
            <div class="saved-image col-md-4">
              <img src="<?=$image;?>" alt="saved image"/><br>
              <a href="products.php?delete_image=1&edit=<?=$edit_id;?>&imgi=<?=$imgi;?>" class="text-danger">Delete Image</a>
            </div>
          <?php $imgi++; endforeach;?>
      <?php else: ?>
        <label for="photo">Product Pictures:</label>
        <input type="file" name="photo[]" id="photo" class="form-control" multiple>
      <?php endif; ?>
    </div>
    <div class="form-group col-md-6">
      <label for="description">Short Description:</label>
      <textarea id="description" name="description" class="form-control" rows="6"><?=$description;?></textarea>
    </div>

    <div class="form-group pull-right">
      <a href="products.php" class="btn btn-default">Cancel</a>
      &nbsp;
      <input type="submit" value="<?=((isset($_GET['edit']))?'Edit':'Add');?> Product" class="btn btn-danger">
    </div><div class="clearfix"></div>
  </form>
  <!-- Modal -->
<div class="modal fade" id="sizeModal" tabindex="-1" role="dialog" aria-labelledby="sizeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="sizeModalLabel">Size & Quantity</h4>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
        <?php for($i=1;$i <= 12;$i++): ?>
          <div class="form-group col-md-3">
            <label for="size<?=$i;?>">Size:</label>
            <input type="text" name="size<?=$i;?>" id="size<?=$i;?>" value="<?=((!empty($sArray[$i-1]))?$sArray[$i-1]:'');?>" class="form-control">
          </div>
        <?php endfor; ?>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="updateSizes();jQuery('#sizeModal').modal('toggle');return false;">Save changes</button>
      </div>
    </div>
  </div>
</div>
</div>
<?php }else{
$sql = "SELECT * FROM products WHERE deleted = 0 ORDER BY categories";
$presults = $db->query($sql);
if (isset($_GET['featured'])) {
  $id = (int)$_GET['id'];
  $featured = (int)$_GET['featured'];
  $featuredSql = "UPDATE products SET featured = '$featured' WHERE id = '$id'";
  $db->query($featuredSql);
  header('Location: products.php');
}
 ?>
 <hr>
 <div class="container">
<h3 class="text-center">Products</h3>
<a href="products.php?add=1" class="btn btn-danger pull-right" id="add-product-btn">Add Product</a><div class="clearfix"></div>
<hr>
<table class="table table-bordered table-condensed table-striped">
  <thead><th></th><th>Product</th><th>Price</th><th>Category</th><th>Featured</th></thead>
  <tbody>
    <?php while($product = mysqli_fetch_assoc($presults)):
        $childID = $product['categories'];
        $catSql = "SELECT * FROM categories WHERE id = '$childID'";
        $result = $db->query($catSql);
        $child = mysqli_fetch_assoc($result);
        $parentID = $child['parent'];
        $pSql =  "SELECT * FROM categories WHERE id = '$parentID'";
        $presult = $db->query($pSql);
        $parent = mysqli_fetch_assoc($presult);
        $category = $parent['category'].'~'.$child['category'];
      ?>
      <tr>
        <td align="center">
          <a href="products.php?edit=<?=$product['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
          <a href="products.php?delete=<?=$product['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove"></span></a>

        </td>
        <td><?=$product['title'];?></td>
        <td><?=money($product['price']);?></td>
        <td><?=$category;?></td>
        <td><a href="products.php?featured=<?=(($product['featured'] == 0)?'1':'0');?>&id=<?=$product['id'];?>" class="btn btn-xs btn-default">
          <span class="glyphicon glyphicon-<?=(($product['featured']==1)?'minus':'plus');?>"></span>
          </a>&nbsp <?=(($product['featured'] == 1)?'Featured Product':'');?></td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>
</div>

<?php } include 'includes/footer.php'; ?>
<script>
  jQuery('document').ready(function(){
    get_child_options('<?=$category;?>');
  });
</script>
