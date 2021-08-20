
<?php
//data you want to sign
$data = '|Malayan Banking Berhad (M2U)|MB2U0227|firanalda@hotmail.com|||Buyer Name|KPDNKK|01|AR|Application Payment|01|EX00001071|20170729190725|SE00001438|20170729190725|20170729190725||MYR|6.0';

//create new private and public key
// $new_key_pair = openssl_pkey_new(array(
//     "private_key_bits" => 2048,
//     "private_key_type" => OPENSSL_KEYTYPE_RSA,
// ));

$priv_key = file_get_contents('/var/www/html/EX00001071.key');
$pkeyid = openssl_get_privatekey($priv_key);

$pub_key = openssl_pkey_get_public(file_get_contents('/var/www/html/fpxuat.cer'));

// Public key as PEM string
//$pem_public_key = openssl_pkey_get_details($pkeyid)['key'];


//create signature
openssl_sign($data, $signature, $pkeyid, OPENSSL_ALGO_SHA256);

//save for later
// file_put_contents('private_key.pem', $private_key_pem);
// file_put_contents('public_key.pem', $public_key_pem);
// file_put_contents('signature.dat', $signature);

//verify signature
$r = openssl_verify($data, $signature, $pub_key, OPENSSL_ALGO_SHA256);
var_dump($r);
?>
