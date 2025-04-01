<?php include '../lib/config.inc.php';
if($_POST['stepid']){
	$_POST['completed_on']=date('Y-m-d H:i:s');
    $_POST['executiveid']=$_SESSION["AMD"][0];
	$_POST['pid']= $_POST['stepid'];
	$_POST['crmsid']= $_POST['complianceId'];
	$_POST['status']= 1;
	
//$PDO->db_query("update #_'".$_POST['tablename']."'  set completed_on=1 where reciverid='".$_SESSION["AMD"][0]."'");	
$PDO->sqlquery("rs",$_POST['tablename'],$_POST,'pid',$_POST['pid']);
echo $_POST['completed_on'];	
	exit;}
if(!$_POST['otp']){
				
		 $digits = 6; 
		$otp= str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
		$to = '91'.$_SESSION["AMD"][4];
		$_SESSION["OTP"]=$otp;
		$msg ='Hello '.$_SESSION["AMD"][1].'! One time password for add compliance into ERP is '.$otp.' Please use the otp to complete process.';
		
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://control.msg91.com/api/sendotp.php?template=&otp_length=6&authkey=229297A3RSNnx95b6179ba&message=".rawurlencode($msg)."&sender=RGWALA&mobile=".$to."&otp=".$otp."&otp_expiry=&email=".$_SESSION["AMD"][2]."",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "",
  CURLOPT_SSL_VERIFYHOST => 0,
  CURLOPT_SSL_VERIFYPEER => 0,
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

echo '<div class="alert alert-success">Check your email or phone for the otp!</div>';		
					}
else if(isset($_POST['otp']) && $_POST['otp']==$_SESSION["OTP"]){
						
echo 'ok';

				}
					
else {
echo '<div class="alert alert-danger">Invalid OTP.Please use corrct OTP!</div>';										
						
}
	
?>
 