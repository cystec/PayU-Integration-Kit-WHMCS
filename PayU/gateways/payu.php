<?php
function payu_config() {

    $configarray = array(
     "FriendlyName" => array("Type" => "System", "Value"=>"payu"),
     "MerchantKey" => array("FriendlyName" => "MerchantKey", "Type" => "text", "Size" => "20", ),
     "SALT" => array("FriendlyName" => "SALT", "Type" => "text", "Size" => "20",),
     "mode" => array("FriendlyName" => "mode", "Type" => "text", "Description" => "TEST or LIVE", ),
	
    );
	return $configarray;
}

function payu_link($params) {


	# Gateway Specific Variables
	$key = $params['MerchantKey'];
	$SALT = $params['SALT'];
	$gatewaymode = $params['mode'];
	

	# Invoice Variables
	$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);;
	$productinfo = $params["description"];
    $amount = $params['amount']; # Format: ##.##

	# Client Variables
	$firstname = $params['clientdetails']['firstname'];
	$lastname = $params['clientdetails']['lastname'];
	$email = $params['clientdetails']['email'];
	$address1 = $params['clientdetails']['address1'];
	$city = $params['clientdetails']['city'];
	$state = $params['clientdetails']['state'];
	$postcode = $params['clientdetails']['postcode'];
	$country = $params['clientdetails']['country'];
	$phone = $params['clientdetails']['phonenumber'];
    $hashSequence = $key.'|'.$txnid.'|'.$amount.'|'.$productinfo.'|'.$firstname.'|'.$email.'|||||||||||';
    
    $hashSequence .= $SALT;
    $hash = strtolower(hash('sha512', $hashSequence));
	# System Variables
	$companyname = 'payu';
	$systemurl = $params['systemurl'];
    $PostURL = "https://test.payu.in/_payment";
    if($gatewaymode == 'LIVE')
      $PostURL = "https://secure.payu.in/_payment";
	# Enter your code submit to the Payu gateway...

	$code = '<form method="post" action='.$PostURL.' name="frmTransaction" id="frmTransaction" onSubmit="return validate()">
<input type="hidden" name="key" value="'.$key.'" />
<input type="hidden" name="productinfo" value="'.$productinfo.'" />
<input type="hidden" name="txnid" value="'.$txnid.'" />
<input type="hidden" name="firstname" value="'.$firstname.'" />
<input type="hidden" name="address1" value="'.$address1.'" />
<input type="hidden" name="city" value="'.$city.'" />
<input type="hidden" name="state" value="'.$state.'" />
<input type="hidden" name="country" value="'.$country.'" />
<input type="hidden" name="postal_code" value="'.$postcode.'" />
<input type="hidden" name="email" value="'.$email.'" />
<input type="hidden" name="phone" value="'.$phone.'" />
<input type="hidden" name="amount" value="'.$amount.'" />
<input type="hidden" name="hash" value="'.$hash.'" />
<input type="hidden" name="surl" value="https://www.site.com/whmcs/response.php" />  # Add your site URL here
<input type="hidden" name="furl" value="https://www.site.com/whmcs/response.php" />  # Add your site URL here
<input type="submit" value="Pay Now" />
</form>';

	return $code;

}
?>
