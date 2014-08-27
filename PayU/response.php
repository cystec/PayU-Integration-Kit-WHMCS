<?php	
//error_reporting(E_WARNING);
include("../dbconnect.php");
include("../includes/functions.php");
include("../includes/gatewayfunctions.php");
include("../includes/invoicefunctions.php");
$gatewaymodule = "payu"; 
$GATEWAY = getGatewayVariables($gatewaymodule);

$response = array();
$response = $_POST;
$fee = $response['amount'];
$amount = $response['amount'];
$transid = $response['mihpayid'];
$txnid = $response['txnid'];
?>
<? 
$txnid = checkCbInvoiceID($txnid,'payu');


checkCbTransID($transid);
if($response['status']=='success'){


		$gatewayresult = "success";
		addInvoicePayment($txnid,$transid,$amount,$fee,$gatewaymodule);
	
        header('Location:https://www.ideacubehosting.com/whmcs/viewinvoice.php?id='.$txnid);

}
	else{
		$gatewayresult = "failed";

        header('Location:https://www.ideacubehosting.com/whmcs/viewinvoice.php?id='.$txnid);

    }	
# PUT DEBUG DATE into $desc
	$debugdata = "Response Code => 1\nResult => Successful\nAVS Result => 0";
?>		
	
