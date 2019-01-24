<?php
require_once '../core/init.php';
if(!is_logged_in()){
  header('Location: login.php');
}
include 'includes/head.php';
include 'includes/navigation.php';

//complete order
if(isset($_GET['complete']) && $_GET['complete'] == 1){
  $cart_id = sanitize((int)$_GET['cart_id']);
  $db->query("UPDATE cart SET shipped = 1 WHERE id = '{$cart_id}'");
  $_SESSION['success_flash'] = 'The order has been completed!';
  header('Location: index.php');
}

$txn_id = sanitize((int)$_GET['txn_id']);
$txnQuery = $db->query("SELECT * FROM orders WHERE id='$txn_id'");
$txn = mysqli_fetch_assoc($txnQuery);
$cart_id = $txn['cart_id'];
$cartQ = $db->query("SELECT * FROM cart WHERE id='$cart_id'");
$cart = mysqli_fetch_assoc($cartQ);
$items = json_decode($cart['items'],true);
$idArray = array();
$products = array();
foreach($items as $item){
  $idArray[] = $item['id'];
}
$ids = implode(',',$idArray);
$productQ = $db->query(
  "SELECT i.id as 'id', i.title as 'title', c.id as 'cid', c.category as 'child', p.category as 'parent'
   FROM products i
   LEFT JOIN categories c ON i.categories = c.id
   LEFT JOIN categories p ON c.parent = p.id
   WHERE i.id IN({$ids})"
);
while($p = mysqli_fetch_assoc($productQ)){
  foreach($items as $item){
    if($item['id'] == $p['id']){
      $x = $item;
      continue;
    }
  }
  $products[] = array_merge($x,$p);
}

?>
<hr>
<h3 class="text-center">Items Ordered</h3>
<div class="container">
<hr>
<table class="table table-condensed table-bordered table-striped">
  <thead>
    <th>Quantity</th>
    <th>Category</th>
    <th>Title</th>
    <th>Type</th>
    <th>Size</th>
    <th>Color</th>
  </thead>
  <tbody>
    <?php foreach($products as $product): ?>
    <tr>
      <td><?=$product['quantity'];?></td>
      <td><?=$product['parent'].' ~ '.$product['child'];?></td>
      <td><?=$product['title'];?></td>
      <td><?=$product['stamptype'];?></td>
      <td><?=$product['size'];?></td>
      <td><?=$product['colors'];?></td>

    </tr>
  <?php endforeach;?>
  </tbody>
</table>
<hr>
<div class="row">
  <div class="col-md-6">
    <h4 class="text-center">Order details</h4>
    <table class="table table-condensed table-bordered table-striped">
      <tbody>
        <tr>
          <td>Full Name</td>
          <td><?=$txn['full_name'];?></td>
        </tr>
        <tr>
          <td>Email</td>
          <td><?=$txn['email'];?></td>
        </tr>
        <tr>
          <td>Telephone</td>
          <td><?=$txn['telephone'];?></td>
        </tr>
        <tr>
          <td>Company Name</td>
          <td><?=$txn['company_name'];?></td>
        </tr>
        <tr>
          <td>Extra Requests</td>
          <td><?=$txn['extra_request'];?></td>
        </tr>
        <tr>
          <td>Order Date</td>
          <td><?=pretty_date($txn['txn_date']);?> </td>
        </tr>
        <tr>
          <td>Total Paid</td>
          <td><?=money($txn['sub_total']);?></td>
        </tr>

      </tbody>
    </table>
  </div>
  <div class="col-md-6">
    <h4 class="text-center">Delivery Address</h4>
    <address>
      <?=$txn['full_name'];?><br>
      <?=$txn['street'];?><br>
      <?=($txn['street2'] != '')?$txn['full_name'].'<br>':'';?>
      <?=$txn['city'];?><br>
      United Arab Emirates
    </address>
  </div>

</div>
<div class="pull-right" id="order-btns">
  <a href="index.php" class="btn btn-large btn-default">Cancel</a>
  &nbsp;
  <a href="orders.php?complete=1&cart_id=<?=$cart_id;?>" class="btn btn-large btn-danger">Complete Order</a>
  &nbsp;
</div>
</div>

<?php
include 'includes/footer.php';
?>
