<?php
define('BASEURL', $_SERVER['DOCUMENT_ROOT'].'/web/');
define('CART_COOKIE','SBwi72UCLlwiqzz2');
define('CART_COOKIE_EXPIRE',time() + (86400*30));
define('TAXRATE', 0);

define('CURRENCY', 'aed');
define('CHECKOUTMODE', 'TEST');//Change TEST to LIVE when ready to go live!

if(CHECKOUTMODE == 'TEST'){
  define('STRIPE_PRIVATE', 'sk_test_OdJSN8rDWstCANU7FsZ1Moq3');
  define('STRIPE_PUBLIC', 'pk_test_HeZtE3T4J8RJlxDHr8GULkAk');
}

if(CHECKOUTMODE == 'LIVE'){
  define('STRIPE_PRIVATE', 'sk_live_6urN8EP55AkM790B2k8cbaBF');
  define('STRIPE_PUBLIC', 'pk_live_SQuJz7pOZFsFfNvNswHacbht');
}
?>
