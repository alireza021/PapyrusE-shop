<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/web/core/init.php';
if(!is_logged_in()){
  header('Location: login.php');
}

include 'includes/head.php';
include 'includes/navigation.php';

?>



<!-- orders to fill -->
<?php
  $txnQuery = "SELECT o.id, o.cart_id, o.full_name, o.description, o.txn_date, o.sub_total, c.items, c.pay, c.shipped
               FROM orders o
               LEFT JOIN cart c ON o.cart_id = c.id
               WHERE c.pay = 1 AND c.shipped = 0
               ORDER BY o.txn_date";
  $txnResults = $db->query($txnQuery);


?>
<hr>
<h3 class="text-center">Orders To Deliver</h3>
<div class="container">
  <hr>
<div class="col-md-12">

  <table class="table table-condensed table-bordered table-striped">
    <thead>
      <th></th>
      <th>Name</th>
      <th>Description</th>
      <th>Total</th>
      <th>Date</th>
    </thead>
    <tbody>
    <?php while($order = mysqli_fetch_assoc($txnResults)): ?>
      <tr>
        <td align="center"><a href="orders.php?txn_id=<?=$order['id'];?>" class="btn btn-xs btn-danger">Details </a></td>
        <td><?=$order['full_name'];?></td>
        <td><?=$order['description'];?></td>
        <td><?=money($order['sub_total']);?></td>
        <td><?=pretty_date($order['txn_date']);?></td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
</div>
</div>

<?php
include 'includes/footer.php';
?>
