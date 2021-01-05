<?php
date_default_timezone_set('Asia/Kuala_Lumpur');
$date = date('Y/m/d H:ia');

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$db = "fdsdb";

// paypal config
define('PAYPAL_ID', 'sb-ju51r2591117@business.example.com'); 
define('PAYPAL_SANDBOX', TRUE); 
define('PAYPAL_RETURN_URL', 'http://localhost/devfdms/checkout?act=payment&flag=pay&return=paypal'); 
define('PAYPAL_CANCEL_URL', 'http://localhost/devfdms/checkout?act=payment&flag=cancel'); 
define('PAYPAL_NOTIFY_URL', 'http://localhost/devfdms'); 
define('PAYPAL_CURRENCY', 'MYR'); 
define('PAYPAL_URL', (PAYPAL_SANDBOX == true)?"https://www.sandbox.paypal.com/cgi-bin/webscr":"https://www.paypal.com/cgi-bin/webscr");

$conn = mysqli_connect("$dbhost", "$dbuser", "$dbpass", "$db") or die("Connection failed: " . $conn->connect_error);

function encryptIt( $q ) {

	$key = 'HqE0luoquf';

	return base64_encode(base64_encode($key.$q));
}


function decryptIt( $q ) {

	$key = 'HqE0luoquf';
	$decoded_key =  base64_decode(base64_decode($q));

	return str_replace("HqE0luoquf", "", $decoded_key);

}


?>