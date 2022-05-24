<?php
require('daraja.php');

$api = new mpesa();     // Create an example for the Mpesa class

// 1. Example one - registering the call back url
$confirmationUrl    = "https://yourdomain.com/yourconfirmationfile.php";
$validationUrl      = "https://yourdomain.php/yourvalidationfile.php";

$api->register_url($confirmationUrl,$validationUrl);
?>