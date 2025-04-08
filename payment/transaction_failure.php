<?php
  include('AES128_php.php');
  $aes = new AESEncDec();

  $key = "pWhMnIEMc4q6hKdiE99GGY4GK5";


  if ($_REQUEST['encData'])
  {
  echo "<Br> Encrypted data = ".$_REQUEST['encData'];
  echo "<Br> Decrypted data = ". $encData =
 $aes->decrypt($_REQUEST['encData'],$key);
  }
  else
  {
  die("Please try again...");
  }
 ?>

<h2>Transaction Failure Page</h2>
Note : kindly change the encrypt/decypt functions accordingly 



