<?php
include("../../lib/config.inc.php");
$msg =$_POST['msg'];
$to =$_POST['phone'];
$msgss=mysql_real_escape_string($msg);
//$url='http://www.smsgateway.center/SMSApi/rest/send?userId=regwala&password=8gVhgnek&senderId=RGWALA&sendMethod=simpleMsg&msgType=TEXT&msg='.urlencode($msg).'&mobile=91'.urlencode($to).'&duplicateCheck=true&format=json';

$url = 'http://www.smsgatewaycenter.com/library/send_sms_2.php?UserName=regwala&Password=8gVhgnek&Type=Bulk&To='.urlencode($to).'&Mask=RGWALA&Message='.urlencode($msg);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_NOBODY, TRUE); // remove body 
		$response = curl_exec($ch);
		curl_close($ch);
		print_r($response);
		$PDO->db_query("INSERT INTO #_sendsms (`mobile`, `msg`) VALUES ('$to','$msgss')");
		
		?>