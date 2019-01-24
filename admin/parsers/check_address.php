<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/web/core/init.php';

$name = sanitize($_POST['full_name']);
$email = sanitize($_POST['email']);
$telephone = sanitize($_POST['telephone']);
$company = sanitize($_POST['company']);
$street = sanitize($_POST['street']);
$street2 = sanitize($_POST['street2']);
$city = sanitize($_POST['city']);
$extra_request = sanitize($_POST['extra_request']);


$errors = array();
$required = array(
  'full_name' => 'Full Name',
  'email'     => 'Email',
  'telephone'    => 'Telephone',
  'street' => 'Street Address',
  'city' => 'City',
);

//check if all required fields are filled out
foreach($required as $f => $d){
  if(empty($_POST[$f]) || $_POST[$f] == ''){
    $errors[] = $d.' is required.';
  }
}

//check if email is valid
if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
  $errors[] = 'Please enter a valid email address.';
}

if(!empty($errors)){
  echo display_errors($errors);
}else{
  echo 'passed';
}

?>
