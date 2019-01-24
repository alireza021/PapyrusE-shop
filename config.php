<?php
define('BASEURL', $_SERVER['DOCUMENT_ROOT'].'/web/');
define('CART_COOKIE','SBwi72UCLlwiqzz2');
define('CART_COOKIE_EXPIRE',time() + (86400*30));
define('TAXRATE', 0);

define('CURRENCY', 'aed');
define('CHECKOUTMODE', 'TEST');//Change TEST to LIVE when ready to go live!

if(CHECKOUTMODE == 'TEST'){
  define('STRIPE_PRIVATE', '');
  define('STRIPE_PUBLIC', '');
}

if(CHECKOUTMODE == 'LIVE'){
  define('STRIPE_PRIVATE', '');
  define('STRIPE_PUBLIC', '');
}
?>
