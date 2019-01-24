<?php
require_once 'core/init.php';


// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey(STRIPE_PRIVATE);

// Token is created using Stripe.js or Checkout!
// Get the payment token submitted by the form:
$token = $_POST['stripeToken'];

$full_name = sanitize($_POST['full_name']);
$email = sanitize($_POST['email']);
$telephone = sanitize($_POST['telephone']);
$extra_request = sanitize($_POST['extra_request']);
$company = sanitize($_POST['company']);
$street = sanitize($_POST['street']);
$street2 = sanitize($_POST['street2']);
$city = sanitize($_POST['city']);
$country = sanitize($_POST['country']);
$cart_id = sanitize($_POST['cart_id']);
$sub_total = sanitize($_POST['sub_total']);
$description = sanitize($_POST['description']);
$charge_amount = number_format($sub_total,2) * 100;
$metadata = array(
  "cart_id" => $cart_id,
  "sub_total" => $sub_total,
);




try{
// Charge the user's card:
$charge = \Stripe\Charge::create(array(
"amount" => $charge_amount,
"currency" => CURRENCY,
"source" => $token,
"description" => $description,
"receipt_email" => $email,
"metadata" => $metadata,
));


  $db->query("UPDATE cart SET pay = 1 WHERE id ='{$cart_id}'");
  $db->query("INSERT INTO orders
    (charge_id,cart_id,full_name,email,telephone,extra_request,street,street2,company_name, city,sub_total,description,txn_type) VALUES
    ('$charge->id','$cart_id','$full_name','$email','$telephone','$extra_request','$street','$street2','$company','$city','$sub_total','$description','$charge->object')");

  $domain = ($_SERVER['HTTP_HOST'] != 'localhost')? '.'.$_SERVER['HTTP_HOST']:false;
  setcookie(CART_COOKIE,'',1,"/",$domain,false);




    include 'includes/head.php';
    include 'includes/navigation.php';
    ?>
    <div class="container">
      <hr>
  <h1 class="text-center">Thank you!</h1>
  <p>Your card has been successfully charged <?=money($sub_total)?>. The item will be delivered to the address you have provided.</p>
  <p>Your order number is: <strong>128937<?=$cart_id;?></strong>.</p>
  <br>
  <div>
  <p>Delivery Address: </p>
  <address>
    <?=$full_name;?><br>
    <?=$telephone;?><br>
    <?=$street;?><br>
    <?=(($street2 != '')?$street2.'<br>':'');?>
    <?=$city;?><br>
    <?=$country;?><br>
  </address>
</div>


<div>





  <?php
  include 'includes/footer.php';

}catch(\Stripe\Error\Card $e){
//the card has been declined
echo $e;

}


?>
