<?php
//Merchant will need to edit the below parameter to match their environment.
error_reporting(E_ALL);

/* Generating String to send to fpx */
/*For B2C, message.token = 01
 For B2B1, message.token = 02 */

$fpx_msgType="AR";
$fpx_msgToken=$acc_type;
$fpx_sellerExId="EX00000668";
$fpx_sellerExOrderNo='FPX-V2-'.$payment_fpx_id;
$fpx_sellerTxnTime=date('YmdHis');
$fpx_sellerOrderNo='FPX-V2-'.$payment_id;
$fpx_sellerId="SE00000895";//SE00001438
$fpx_sellerBankCode="01";
$fpx_txnCurrency="MYR";
$fpx_txnAmount=$amount;
$fpx_buyerEmail=$email;
$fpx_checkSum="";
$fpx_buyerName="";
$fpx_buyerBankId=$bank_id;
$fpx_buyerBankBranch="";
$fpx_buyerAccNo="";
$fpx_buyerId="";
$fpx_makerName="";
$fpx_buyerIban="";
$fpx_productDesc=$description;
$fpx_version="6.0";

/* Generating signing String */
$data=$fpx_buyerAccNo."|".$fpx_buyerBankBranch."|".$fpx_buyerBankId."|".$fpx_buyerEmail."|".$fpx_buyerIban."|".$fpx_buyerId."|".$fpx_buyerName."|".$fpx_makerName."|".$fpx_msgToken."|".$fpx_msgType."|".$fpx_productDesc."|".$fpx_sellerBankCode."|".$fpx_sellerExId."|".$fpx_sellerExOrderNo."|".$fpx_sellerId."|".$fpx_sellerOrderNo."|".$fpx_sellerTxnTime."|".$fpx_txnAmount."|".$fpx_txnCurrency."|".$fpx_version;

/* Reading key */
$priv_key = file_get_contents('/var/www/html/EX00000668.key');
$pkeyid = openssl_get_privatekey($priv_key);
openssl_sign($data, $binary_signature, $pkeyid, OPENSSL_ALGO_SHA1);
$fpx_checkSum = strtoupper(bin2hex( $binary_signature ) );

?>

<form id="fpxForm" method="post" action="https://www.mepsfpx.com.my/FPXMain/seller2DReceiver.jsp">
	<input type=hidden value="<?php print $fpx_msgType; ?>" name="fpx_msgType">
	<input type=hidden value="<?php print $fpx_msgToken; ?>" name="fpx_msgToken">
	<input type=hidden value="<?php print $fpx_sellerExId; ?>" name="fpx_sellerExId">
	<input type=hidden value="<?php print $fpx_sellerExOrderNo; ?>" name="fpx_sellerExOrderNo">
	<input type=hidden value="<?php print $fpx_sellerTxnTime; ?>" name="fpx_sellerTxnTime">
	<input type=hidden value="<?php print $fpx_sellerOrderNo; ?>" name="fpx_sellerOrderNo">
	<input type=hidden value="<?php print $fpx_sellerId; ?>" name="fpx_sellerId">
	<input type=hidden value="<?php print $fpx_sellerBankCode; ?>" name="fpx_sellerBankCode">
	<input type=hidden value="<?php print $fpx_txnCurrency; ?>" name="fpx_txnCurrency">
	<input type=hidden value="<?php print $fpx_txnAmount; ?>" name="fpx_txnAmount">
	<input type=hidden value="<?php print $fpx_buyerEmail; ?>" name="fpx_buyerEmail">
	<input type=hidden value="<?php print $fpx_checkSum; ?>" name="fpx_checkSum">
	<input type=hidden value="<?php print $fpx_buyerName; ?>" name="fpx_buyerName">
	<input type=hidden value="<?php print $fpx_buyerBankId; ?>" name="fpx_buyerBankId">
	<input type=hidden value="<?php print $fpx_buyerBankBranch; ?>" name="fpx_buyerBankBranch">
	<input type=hidden value="<?php print $fpx_buyerAccNo; ?>" name="fpx_buyerAccNo">
	<input type=hidden value="<?php print $fpx_buyerId; ?>" name="fpx_buyerId">
	<input type=hidden value="<?php print $fpx_makerName; ?>" name="fpx_makerName">
	<input type=hidden value="<?php print $fpx_buyerIban; ?>" name="fpx_buyerIban">
	<input type=hidden value="<?php print $fpx_version; ?>" name="fpx_version">
	<input type=hidden value="<?php print $fpx_productDesc; ?>" name="fpx_productDesc"> 
</form>

<script>
document.getElementById("fpxForm").submit();
</script>