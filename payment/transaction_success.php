<?php
  include('AES128_php.php');
  $aes = new AESEncDec();

  $key = "pWhMnIEMc4q6hKdiE99GGY4GK5";


  if ($_REQUEST['encData'])
  {
  echo "<Br> Encrypted data = ".$_REQUEST['encData'];
  $encData = $aes->decrypt($_REQUEST['encData'],$key);
  echo "<Br> Decrypted data = ". $encData;
  echo "<pre>";
  print_r($encData);
  echo "</pre>";
  $response = explode('|',$encData);
  print_r($response);
  }
  else
  {
  die("Please try again...");
  }
 ?>

<h2>Transaction Success Page</h2>

Note : kindly change the encrypt/decypt functions accordingly 



