<?php
/*
	Sample SBI EPay 
*/
echo "<b><center>Billing, Shipping and Payment Model</center></b><br/><br/>";
include('CryptAES.php');

//encryption key
$key = "wImKoNvsqbSswM/bO0FT4A==";

//requestparameter 
$requestParameter  ="1000003|DOM|IN|INR|2|Other|https://SbiEpay/sbi_mcrypt_lib/sbi_epay/sucess.php|https://SbiEpay/sbi_mcrypt_lib/sbi_epay/fail.php|SBIEPAY|DP123|2|NB|ONLINE|ONLINE";
echo '<b>Requestparameter:-</b> '.$requestParameter.'<br/><br/>';
//Billingdetails
$billingDtls ="BillerName|Mumbai|Maharastra|403706|India|+91|222|1234567|9892456281|biller@gmail.com|N";
echo '<b>Billingdetails:-</b> '.$billingDtls.'<br/><br/>';

//Shippingdetails
$shippingDtls ="ShipperName|Mayuresh Enclave, Sector 20, Plat A-211, Nerul(w),Navi-Mumbai,403706|Mumbai|Maharastra|India|403706|+91|222|30988373|981234567";
echo '<b>Shippingdetails:-</b> '.$shippingDtls.'<br/><br/>';

//Paymentdetails
$PaymentDtls="aggGtwmapID| | | | | | |";
echo '<b>Paymentdetails:-</b> '.$PaymentDtls.'<br/><br/>';


$aes = new CryptAES();
$aes->set_key(base64_decode($key));
$aes->require_pkcs5();

$EncryptTrans = $aes->encrypt($requestParameter);
$EncryptbillingDetails  = $aes->encrypt($billingDtls);
$EncryptshippingDetais  = $aes->encrypt($shippingDtls);
$EncryptpaymentDetails  = $aes->encrypt($PaymentDtls);

echo '<b>Encrypted EncryptTrans:-</b>'.$EncryptTrans.'<br/><br/>';
echo '<b>Encrypted EncryptbillingDetails:-</b> '.$EncryptbillingDetails.'<br/><br/>';
echo '<b>Encrypted EncryptshippingDetais:-</b>'.$EncryptshippingDetais.'<br/><br/>';
echo '<b>Encrypted EncryptpaymentDetails:-</b>'.$EncryptpaymentDetails.'<br/><br/>';
echo "<br/>Action URL:https://test.sbiepay.com/secure/AggregatorHostedListener"; 


?>
<form name="ecom" method="post" action="https://test.sbiepay.com/secure/AggregatorHostedListener">
<input type="hidden" name="EncryptTrans" value="<?php echo $EncryptTrans; ?>">
<input type="hidden" name="EncryptbillingDetails" value="<?php echo $EncryptbillingDetails; ?>">
<input type="hidden" name="EncryptshippingDetais" value="<?php echo $EncryptshippingDetais; ?>">
<input type="hidden" name="EncryptpaymentDetails" value="<?php echo $EncryptpaymentDetails; ?>">
<input type="hidden" name="merchIdVal" value ="1000003"/>
<input type="submit" name="submit" value="Submit">
</form>