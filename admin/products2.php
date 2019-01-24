<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/web/core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';

$dbPath = '';
// $dbPath2 = '';
// $dbPath3 = '';
// $dbPath4 = '';
// $dbPath5 = '';

if(isset($_GET['add']) || isset($_GET['edit'])){
$brandQuery = $db->query("SELECT * FROM brand");
$parentQuery = $db->query("SELECT * FROM categories WHERE parent = 0 ORDER BY category");

$title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):'');
$brand = ((isset($_POST['brand']) && !empty($_POST['brand']))?sanitize($_POST['brand']):'');
$parent = ((isset($_POST['parent']) && !empty($_POST['parent']))?sanitize($_POST['parent']):'');
$category = ((isset($_POST['child']) && !empty($_POST['child']))?sanitize($_POST['child']):'');
$price = ((isset($_POST['price']) && $_POST['price'] != '')?sanitize($_POST['price']):'');
$colors = ((isset($_POST['colors']) && $_POST['colors'] != '')?sanitize($_POST['colors']):'');
$description = ((isset($_POST['description']) && $_POST['description'] != '')?sanitize($_POST['description']):'');
$sizes = ((isset($_POST['sizes']) && $_POST['sizes'] != '')?sanitize($_POST['sizes']):'');
$sizes = rtrim($sizes, ',');
$savedImage = '';
// $savedImage2 = '';
// $savedImage3 = '';
// $savedImage4 = '';
// $savedImage5 = '';

if(isset($_GET['edit'])){
  $edit_id = (int)$_GET['edit'];
  $productResults = $db->query("SELECT * FROM products WHERE id='$edit_id'");
  $product = mysqli_fetch_assoc($productResults);

if(isset($_GET['delete_image'])){
    $image_url = $_SERVER['DOCUMENT_ROOT'].$product['image'];
    unlink($image_url);
    $db->query("UPDATE products SET image = '' WHERE id = '$edit_id'");
    header('Location: products.php?edit='.$edit_id);
  }

  if(isset($_GET['delete_image2'])){
    $image_url = $_SERVER['DOCUMENT_ROOT'].$product['image2'];
    unlink($image_url);
    $db->query("UPDATE products SET image2 = '' WHERE id = '$edit_id'");
    header('Location: products.php?edit='.$edit_id);
  }

  if(isset($_GET['delete_image3'])){
    $image_url = $_SERVER['DOCUMENT_ROOT'].$product['image3'];
    unlink($image_url);
    $db->query("UPDATE products SET image3 = '' WHERE id = '$edit_id'");
    header('Location: products.php?edit='.$edit_id);
  }

  if(isset($_GET['delete_image4'])){
    $image_url = $_SERVER['DOCUMENT_ROOT'].$product['image4'];
    unlink($image_url);
    $db->query("UPDATE products SET image4 = '' WHERE id = '$edit_id'");
    header('Location: products.php?edit='.$edit_id);
  }

  if(isset($_GET['delete_image5'])){
    $image_url = $_SERVER['DOCUMENT_ROOT'].$product['extrainfo'];
    unlink($image_url);
    $db->query("UPDATE products SET extrainfo = '' WHERE id = '$edit_id'");
    header('Location: products.php?edit='.$edit_id);
  }

  $category = ((isset($_POST['child']) && $_POST['child'] != '')?sanitize($_POST['child']):$product['categories']);
  $title = ((isset($_POST['title']) && $_POST['title']!= '')?sanitize($_POST['title']):$product['title']);
  $brand = ((isset($_POST['brand']) && $_POST['brand']!= '')?sanitize($_POST['brand']):$product['brand']);
  $parentQ = $db->query("SELECT * FROM categories WHERE id='$category'");
  $parentResult = mysqli_fetch_assoc($parentQ);
  $parent = ((isset($_POST['parent']) && $_POST['parent'] != '')?sanitize($_POST['parent']):$parentResult['parent']);
  $price = ((isset($_POST['price']) && $_POST['price']!= '')?sanitize($_POST['price']):$product['price']);
  $description = ((isset($_POST['description']) && $_POST['description']!= '')?sanitize($_POST['description']):$product['description']);
  $sizes = ((isset($_POST['size']) && $_POST['size']!= '')?sanitize($_POST['size']):$product['size']);
  $colors = ((isset($_POST['colors']) && $_POST['colors']!= '')?sanitize($_POST['colors']):$product['colors']);
  $sizes = rtrim($sizes, ',');
  $savedImage = (($product['image'] != '')?$product['image']:'');
  // $savedImage2 = (($product['image2'] != '')?$product['image2']:'');
  // $savedImage3 = (($product['image3'] != '')?$product['image3']:'');
  // $savedImage4 = (($product['image4'] != '')?$product['image4']:'');
  // $savedImage5 = (($product['extrainfo'] != '')?$product['extrainfo']:'');
  $dbPath = $savedImage;
  // $dbPath2 = $savedImage2;
  // $dbPath3 = $savedImage3;
  // $dbPath4 = $savedImage4;
  // $dbPath5 = $savedImage5;
}
if(!empty($sizes)){
  $sizeString = sanitize($sizes);
  $sizeString = rtrim($sizeString, ',');
  $sizesArray = explode(',',$sizeString);
  $sArray = array();
  foreach($sizesArray as $ss){
    $sArray[] = $ss;
  }
}
else{
  $sizesArray = array();
}


if($_POST){

  $dbPath = '';

  $erros = array();

  $required = array('title', 'brand', 'price', 'parent', 'child');
  foreach($required as $field){
    if($_POST[$field] == ''){
      $errors[] = 'Please fill in all the required fields.';
      break;
    }
  }

  // if(!empty($_FILES)) {
  //
  //   $photo = $_FILES['photo'];
  //   // $photo2 = $_FILES['photo2'];
  //   // $photo3 = $_FILES['photo3'];
  //   // $photo4 = $_FILES['photo4'];
  //   // $photo5 = $_FILES['photo5'];
  //
  //   $name = $photo['name'];
  //   // $name2 = $photo2['name'];
  //   // $name3 = $photo3['name'];
  //   // $name4 = $photo4['name'];
  //   // $name5 = $photo5['name'];
  //
  //   $nameArray = explode('.',$name);
  //   // $nameArray2 = explode('.',$name2);
  //   // $nameArray3 = explode('.',$name3);
  //   // $nameArray4 = explode('.',$name4);
  //   // $nameArray5 = explode('.',$name5);
  //
  //   $fileName = $nameArray[0];
  //   $fileExt = $nameArray[1];
  //   // $fileName2 = $nameArray2[0];
  //   // $fileExt2 = $nameArray2[1];
  //   // $fileName3 = $nameArray3[0];
  //   // $fileExt3 = $nameArray3[1];
  //   // $fileName4 = $nameArray4[0];
  //   // $fileExt4 = $nameArray4[1];
  //   // $fileName5 = $nameArray5[0];
  //   // $fileExt5 = $nameArray5[1];
  //
  //   $mime = explode('/', $photo['type']);
  //   // $mime2 = explode('/', $photo2['type']);
  //   // $mime3 = explode('/', $photo3['type']);
  //   // $mime4 = explode('/', $photo4['type']);
  //   // $mime5 = explode('/', $photo5['type']);
  //
  //   $mimeType = $mime[0];
  //   $mimeExt = $mime[1];
  //   // $mimeType2 = $mime2[0];
  //   // $mimeExt2 = $mime2[1];
  //   // $mimeType3 = $mime3[0];
  //   // $mimeExt3 = $mime3[1];
  //   // $mimeType4 = $mime4[0];
  //   // $mimeExt4 = $mime4[1];
  //   // $mimeType5 = $mime5[0];
  //   // $mimeExt5 = $mime5[1];
  //
  //   $tmpLoc = $photo['tmp_name'];
  //   // $tmpLoc2 = $photo2['tmp_name'];
  //   // $tmpLoc3 = $photo3['tmp_name'];
  //   // $tmpLoc4 = $photo4['tmp_name'];
  //   // $tmpLoc5 = $photo5['tmp_name'];
  //
  //   $fileSize = $photo['size'];
  //   // $fileSize2 = $photo2['size'];
  //   // $fileSize3 = $photo3['size'];
  //   // $fileSize4 = $photo4['size'];
  //   // $fileSize5 = $photo5['size'];
  //
  //   $allowed = array('png', 'jpg', 'jpeg', 'gif');
  //
  //   $uploadName = md5(microtime()).'.'.$fileExt;
  //   // $uploadName2 = md5(microtime()).'.'.$fileExt2;
  //   // $uploadName3 = md5(microtime()).'.'.$fileExt3;
  //   // $uploadName4 = md5(microtime()).'.'.$fileExt4;
  //   // $uploadName5 = md5(microtime()).'.'.$fileExt5;
  //
  //   $uploadPath = BASEURL.'images/products/'.$uploadName;
  //   // $uploadPath2 = BASEURL.'images/products/'.$uploadName2;
  //   // $uploadPath3 = BASEURL.'images/products/'.$uploadName3;
  //   // $uploadPath4 = BASEURL.'images/products/'.$uploadName4;
  //   // $uploadPath5 = BASEURL.'images/products/'.$uploadName5;
  //
  //   $dbPath = '/web/images/products/'.$uploadName;
  //   // $dbPath2 = '/web/images/products/'.$uploadName2;
  //   // $dbPath3 = '/web/images/products/'.$uploadName3;
  //   // $dbPath4 = '/web/images/products/'.$uploadName4;
  //   // $dbPath5 = '/web/images/products/'.$uploadName5;
  //
  //   if($mimeType != 'image') {
  //     $errors[] = 'Product pictures must be an image file.';
  //   }
  //   if(!in_array($fileExt, $allowed)) {
  //     $errors[] = 'Product pictures must be PNG, JPG, JPEG, or GIF.';
  //   }
  //   if($fileSize > 10000000) {
  //     $errors[] = 'Product pictures must be less than 10MB';
  //   }
  //   if($fileExt != $mimeExt && ($mimeExt == 'jpeg' && $fileExt != 'jpg')) {
  //     $errors[] = 'File extension does not match the file, try renaming the file appropriate to its extention.';
  //   }
  // }

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
        $uploadName = md5(microtime()).'.'.$fileExt;
        $uploadPath[] = BASEURL.'images/products/'.$uploadName;
        if($i != 0 && $i < $photoCount){
          $dbPath .= ',';
        }
        $dbPath .= '/web/images/products/'.$uploadName;
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
  //   if(!empty($errors)){
  //     echo display_errors($errors);
  //   }else{
  //     if($photoCount > 0){
  //     //upload file and insert into database
  //       for($i=0;$i<$photoCount;$i++){
  //         move_uploaded_file($tmpLoc[$i],$uploadPath[$i]);
  //       }
  //     }
  //
  // if(!empty($errors)){
  //   echo display_errors($errors);
  // }
  // else{
  //   //upload files and update database
  //   move_uploaded_file($tmpLoc, $uploadPath);
  //   // move_uploaded_file($tmpLoc2, $uploadPath2);
  //   // move_uploaded_file($tmpLoc3, $uploadPath3);
  //   // move_uploaded_file($tmpLoc4, $uploadPath4);
  //   // move_uploaded_file($tmpLoc5, $uploadPath5);
  if(!empty($errors)){
    echo display_errors($errors);
  }else{
    if($photoCount > 0){
    //upload file and insert into database
      for($i=0;$i<$photoCount;$i++){
        move_uploaded_file($tmpLoc[$i],$uploadPath[$i]);
      }
    }
    $insertSql = "INSERT INTO products (`title`,`price`,`brand`,`categories`,`sizes`,`image`,`description`, `colors`)
         VALUES ('$title','$price','$brand', '$category','$sizes','$dbPath','$description', '$colors')";
         if(isset($_GET['edit'])){
           $insertSql = "UPDATE products SET `title` = '$title', `price` = '$price',
           `brand` = '$brand', `categories` = '$category', `sizes` = '$sizes', `image` = '$dbPath', `description` = '$description', `colors` = '$colors'
           WHERE id ='$edit_id'";
         }

         $db->query($insertSql);
         header('Location: products.php');
      }
    }

?>
<h2 class="text-center"><?=((isset($_GET['edit']))?'Edit':'Add a New');?> Product</h2><hr>
<form action="products.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1');?>" method="POST" enctype="multipart/form-data">
  <div class="form-group col-md-3">
  <label for="title">Title*:</label>
  <input type="text" name="title" class="form-control" id="title" value="<?=$title;?>">
</div>
<div class="form-group col-md-3">
  <label for="brand">Brand*:</label>
  <select class="form-control" id="brand" name="brand">
    <option value=""<?= (($brand == '')?' selected':'');?>></option>
    <?php while($b = mysqli_fetch_assoc($brandQuery)): ?>
      <option value = "<?=$b['id'];?>"<?=(($brand == $b['id'])?' selected':'');?>><?=$b['brand'];?></option>
      <?php endwhile; ?>
  </select>
</div>
<div class="form-group col-md-3">
  <label for="parent">Parent Category*:</label>
  <select class="form-control" id="parent" name="parent">
    <option value =""<?=(($parent == '')?' selected':'');?>></option>
    <?php while($p = mysqli_fetch_assoc($parentQuery)): ?>
      <option value="<?=$p['id'];?>"<?=(($parent == $p['id'])?' selected':'');?>><?=$p['category'];?></option>
      <?php endwhile; ?>
    </select>
</div>
<div class="form-group col-md-3">
  <label for="child">Child Category*:</label>
  <select id="child" name="child" class="form-control"></select>
</div>
<div class="form-group col-md-3">
  <label for="price">Price*:</label>
  <input type="text" id="price" name="price" class="form-control" value="<?=$price;?>">
</div>
<div class="form-group col-md-3">
  <label>Sizes:</label>
<button class="btn btn-default form-control" onclick="jQuery('#sizesModal').modal('toggle'); return false;">Choose Sizes</button>
</div>

<div class="form-group col-md-3">
<label for="sizes">Selected Sizes:</label>
<input type="text" class="form-control" name="sizes" id="sizes" value="<?=$sizes;?>" readonly>
</div>

<div class="form-group col-md-3">
  <label for="colors">Number of Colors <small>(Seperated by commas)</small>:</label>
  <input type="text" name="colors" id="colors" min="1" class="form-control" value="<?=$colors;?>">
</div>
<?php if($savedImage != ''): ?>
<div class="form-group col-md-3">
  <?php
        $imgi = 1;
        $images = explode(',',$savedImage); ?>
        <?php foreach($images as $image):?>
    <div class = "saved-image">
      <img src="<?=$savedImage;?>" alt="saved image">
      <a href="products.php?delete_image=1&edit=<?=$edit_id;?>&imgi=<?=$imgi;?>" class="text-danger">Delete Image</a>
    </div>
    <?php $imgi++; endforeach;?>
  <?php else: ?>
        <label for="photo">Product Photo:</label>
        <input type="file" name="photo[]" id="photo" class="form-control" multiple>
      <?php endif; ?>
    </div>

<!-- <div class="form-group col-md-3">
  <?php if($savedImage2 != ''): ?>
    <div class = "saved-image">
      <img src="<?=$savedImage2;?>" alt="saved image">
      <a href="products.php?delete_image2=1&edit=<?=$edit_id;?>" class="text-danger">Delete Image</a>
    </div>
  <?php else: ?>
  <label for="photo2">Product Picture 2:</label>
  <input type="file" name="photo2" id="photo2" class="form-control">
  <?php endif; ?>
</div>

<div class="form-group col-md-3">
  <?php if($savedImage3 != ''): ?>
    <div class = "saved-image">
      <img src="<?=$savedImage3;?>" alt="saved image">
      <a href="products.php?delete_image3=1&edit=<?=$edit_id;?>" class="text-danger">Delete Image</a>
    </div>
    <?php else: ?>
  <label for="photo3">Product Picture 3:</label>
  <input type="file" name="photo3" id="photo3" class="form-control">
  <?php endif; ?>
</div>

<div class="form-group col-md-3">
  <?php if($savedImage4 != ''): ?>
    <div class = "saved-image">
      <img src="<?=$savedImage4;?>" alt="saved image">
      <a href="products.php?delete_image4=1&edit=<?=$edit_id;?>" class="text-danger">Delete Image</a>
    </div>
    <?php else: ?>
  <label for="photo4">Product Picture 4:</label>
  <input type="file" name="photo4" id="photo4" class="form-control">
    <?php endif; ?>
</div>

<div class="form-group col-md-6">
  <?php if($savedImage5 != ''): ?>
    <div class = "saved-image">
      <img src="<?=$savedImage4;?>" alt="saved image">
      <a href="products.php?delete_image5=1&edit=<?=$edit_id;?>" class="text-danger">Delete Image</a>
    </div>
    <?php else: ?>
  <label for="photo5">Description Picture:</label>
  <input type="file" name="photo5" id="photo5" class="form-control">
    <?php endif; ?>
</div> -->


<div class="form-group col-md-6">
  <lavel for="description">Short Description:</label>
    <textarea id="description" name="description" class="form-control" rows="6"><?=$description;?></textarea>

</div>
<div class="form-group pull-right">
  <a href="products.php" class="btn btn-default">Cancel</a>
  &nbsp;
<input type="submit" value="<?=((isset($_GET['edit']))?'Edit':'Add');?> Product" class="btn btn-success pull-right">
</div>
<div class="clearfix"></div>


</form>

<!-- Size Modal -->
<div class="modal fade" id="sizesModal" tabindex="-1" role="dialog" aria-labelledby="sizesModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="sizesModalLabel">Choose Sizes</h4>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
        <?php for($i=1; $i <= 12; $i++): ?>
          <div class="form-group col-md-4">
            <label for="size"<?=$i;?>>Size:</label>
            <input type="text" name="size<?=$i;?>" id="size<?=$i;?>" value="<?=((!empty($sArray[$i-1]))?$sArray[$i-1]:'');?>" class="form-control">
          </div>
        <?php endfor; ?>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="updateSizes();jQuery('#sizesModal').modal('toggle');return false">Save changes</button>
      </div>
    </div>
  </div>
</div>


<?php

}
else {

$sql = "SELECT * FROM products WHERE deleted = 0";
$presults = $db->query($sql);
if(isset($_GET['featured'])) {
  $id = (int)$_GET['id'];
  $featured = (int)$_GET['featured'];
  $featuredSql = "UPDATE products SET featured = $featured WHERE id = '$id'";
  $db->query($featuredSql);
  header('Location: products.php');
}

?>
<h2 class="text-center">Products</h2>
<a href="products.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Add Product</a><div class="clearfix"></div>
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
  $pSql = "SELECT * FROM categories WHERE id = '$parentID'";
  $presult = $db->query($pSql);
  $parent = mysqli_fetch_assoc($presult);
  $category = $parent['category'].'~'.$child['category'];
?>
<tr>
<td>
  <a href="products.php?edit=<?=$product['id'];?>" class= "btn btn-xs btn-default"><span class = "glyphicon glyphicon-pencil"></span></a>
  <a href="products.php?delete=<?=$product['id'];?>" class= "btn btn-xs btn-default"><span class = "glyphicon glyphicon-remove"></span></a>
</td>
<td><?=$product['title'];?></td>
<td><?=money($product['price']);?></td>
<td><?=$category;?></td>
<td><a href="products.php?featured=<?=(($product['featured'] == 0)?'1':'0');?>&id=<?=$product['id'];?>" class="btn btn-xs btn-default" >
  <span class = "glyphicon glyphicon-<?=(($product['featured']== 1)?'minus':'plus');?>"></span>
</a>&nbsp <?=(($product['featured'] == 1)?'Featured Product': '');?></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>


<?php
}
include 'includes/footer.php';
?>

<script>
  jQuery('document').ready(function(){
    get_child_options('<?=$category;?>');

  });
</script>
