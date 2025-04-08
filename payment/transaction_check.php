<?php
/*
	Sample SBI EPay 
*/
//echo "<b><center>Payment Model</center></b><br/><br/>";
include('./AES128_php.php');
for ($i = 0; $i < 10; $i++) {
	$d = rand(1, 30) % 2;
	$d = $d ? chr(rand(65, 90)) : chr(rand(48, 57));
	$orderid = $orderid . $d;
}
$orderid = time().'_22';
//encryption key

$key = "pWhMnIEMc4q6hKdi2Fx50Ii8CKAoSIqv9ScSpwuMHM4=";

//requestparameter 
// $requestParameter  = "1000605|DOM|IN|INR|10|Other|https://jnscollege.com/payment/transaction_success.php|https://jnscollege.com/payment/transaction_failure.php|SBIEPAY|$orderid|2|NB|ONLINE|ONLINE";
$requestParameter  = "1000605|DOM|IN|INR|10|30|https://localhost/jns/payment/transaction_success.php|https://localhost/jns/payment/transaction_failure.php|SBIEPAY|$orderid|43|NB|ONLINE|ONLINE";
// MerchantID|DOMESTIC|IN|INR|Amount|Payment Purpose|successpage URL|Fail page URL|Aggregrator ID (Same as above)|Unique Order ID for each transactions|Customer Id|Paymode - Debit card, credit card|Access Medium|Transaction source
//echo '<b>Requestparameter:-</b> '.$requestParameter.'<br/><br/>';



$aes = new AESEncDec();
//$aes->set_key(base64_decode($key));
//$aes->require_pkcs5();

$EncryptTrans = $aes->encrypt($requestParameter, $key);
echo $orderid;


// echo '<b>Encrypted EncryptTrans:-</b>'.$EncryptTrans.'<br/><br/>';



?>
<form name="ecom" method="post" action="https://test.sbiepay.sbi/secure/AggregatorHostedListener">
	<input type="text" name="EncryptTrans" value="<?php echo $EncryptTrans; ?>">
	<input type="text" name="merchIdVal" value="1000605" />
	<input type="submit" name="submit" value="Submit">
</form>