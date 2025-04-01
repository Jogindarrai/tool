<?php 

include(FS_ADMIN._MODS."/leads/leads.inc.php");

$PAGS = new Pages();



if($RW->is_post_back())

{
$query =$PDO->db_query("select * from #_".tblName." where pid ='".$uid."' "); 
$row = $PDO->db_fetch_array($query);
@extract($row);

if(isset($_POST['costist'])){
$_POST['lid']=$_GET['uid'];
$_POST['create_by']=$_SESSION["AMD"][0];
$_POST['status']=1;
if($followup){

$follow['fstatus']=1;

$PDO->sqlquery("rs",'pms_activity',$follow,'lid',$_GET['uid']);	

}


$PDO->sqlquery("rs",'cost_list',$_POST);
$ADMIN->sessset('Record has been saved!', 's');

$RW->redir($ADMIN->iurl($comp.'&mode=edit&uid='.$uid.(($start)?'&start='.$start:'').(($followup)?'&followup='.$followup:'')), true); }
if(isset($_POST['additionalReq'])){
	
	if($followup){

$follow['fstatus']=1;

$PDO->sqlquery("rs",'pms_activity',$follow,'lid',$_GET['uid']);	

}
	
$_POST['lid']=$_GET['uid'];
$_POST['create_by']=$_SESSION["AMD"][0];
$_POST['status']=1;
$PDO->sqlquery("rs",'crequirement',$_POST);
$ps['lid']=$_GET['uid'];
$ps['sentBy']=$_SESSION["AMD"][0];
$ps['status']=22;
$ps['type']=35;
$PDO->sqlquery("rs",'pms_activity',$ps);
$lead['status']=2;
$PDO->sqlquery("rs",'leads',$lead,'pid',$_GET['uid']);

$ADMIN->sessset('Record has been saved!', 's');

$RW->redir($ADMIN->iurl($comp.'&mode=edit&uid='.$uid.(($start)?'&start='.$start:'').(($followup)?'&followup='.$followup:'')), true); }
if(isset($_POST['paymentpay'])){

if($followup){

$follow['fstatus']=1;

$PDO->sqlquery("rs",'pms_activity',$follow,'lid',$_GET['uid']);	

}

$_POST['lid']=$_GET['uid'];

$_POST['sentBy']=$_SESSION["AMD"][0];

$_POST['status']=6;

$PDO->sqlquery("rs",'paymentdetails',$_POST);
$paydate=$PDO->getSingleresult("select paymentDate from #_leads where pid='".$uid."'");
if($paydate=='0000-00-00 00:00:00'){
$paym['paymentDate']=date('Y-m-d H:i:s');;
	}
$paym['payment']=1;
$paym['status']=2;
$PDO->sqlquery("rs",'leads',$paym,'pid',$_GET['uid']);
$ps['lid']=$_GET['uid'];

$ps['sentBy']=$_SESSION["AMD"][0];

$ps['status']=22;

$ps['type']=22;
$PDO->sqlquery("rs",'pms_activity',$ps);


$ADMIN->sessset('Record has been saved!', 's');

$RW->redir($ADMIN->iurl($comp.'&mode=edit&uid='.$uid.(($start)?'&start='.$start:'').(($followup)?'&followup='.$followup:'')), true); 
}

if(isset($_POST['quickemail'])){
	
	if($followup){

$follow['fstatus']=1;

$PDO->sqlquery("rs",'pms_activity',$follow,'lid',$_GET['uid']);	

}
	$ps['comment']=$_POST['comment'];
	$ps['subject']=$_POST['subject'];
	$ps['lid']=$_GET['uid'];
	$ps['sentBy']=$_SESSION["AMD"][0];
	$ps['status']=22;
	$ps['type']=29;
	$PDO->sqlquery("rs",'pms_activity',$ps);
	
	
	$mailbody='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Trademark Bazaar</title>
</head>
<body>

<div style="max-width:600px; margin:auto; font-family:\'verdana\',sans-serif, arial,\'lucida Console\'; border-radius:2px solid #343434; background-color:#eff0f0;">
<div style="padding:20px 50px 0 50px;">

<div style="display:inline-block;">
<a href="https://trademarkbazaar.com"><img style="width:118px; height:53px;" src="https://trademarkbazaar.com/images/emailer/tblogo.png" alt="trademarkbazaar.com"></a>
</div>

<div style="float:right; padding-top:10px;">
<a href="https://www.facebook.com/trademarkbazaar/"><img style="width:30px; height:27px;" src="https://trademarkbazaar.com/images/emailer/face.png" alt="trademarkbazaar.com" /></a>
<a href="https://twitter.com/TrademarkBazaar"><img style="width:30px; height:27px;" src="https://trademarkbazaar.com/images/emailer/twitter.png" alt="trademarkbazaar.com" /></a>
<a href="https://www.linkedin.com/in/trademark-bazaar-075300144/"><img style="width:30px; height:27px;" src="https://trademarkbazaar.com/images/emailer/link.png" alt="trademarkbazaar.com" /></a>
</div>

<div style="border-bottom:1px solid #d9d9d9; margin:15px 0;"></div>

<div style="color:#343434; font-size:15px; line-height:25px; text-align:justify;">
<p style="margin:25px 0;"><b>Dear '.$_POST['name'].',</b></p>

<div style="background:rgba(239, 159, 162, 0.14);padding:10px 40px;">
<p> '.$_POST["comment"].'</p>
</div>
<p>Feel free to contact us anytime for any kind of assistance.</p>
</div>
</div>

<div style="padding:10px 50px; display:block; font-size:14px; line-height:22px;">'.$RW->emailSignature($ADMIN->user_type($_SESSION["AMD"][3])).'</div>

</div>
</body>
</html>
';
//echo $mailbody; exit;
/*if($uid==116){
	echo  $mailbody; exit;
	}*/
         $to=$_POST["email"];
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: TrademarkBazaar <support@trademarkbazaar.com>' . "\r\n";
		
		$headers .= 'Reply-To:cagauravbansal1@gmail.com,' .$_SESSION["AMD"][2]."\r\n";
	    $headers .= 'Cc: cagauravbansal1@gmail.com,' .$_SESSION["AMD"][2]. "\r\n";
		$subject=$_POST['subject'];
		$mails=mail($to, $subject, $mailbody, $headers, '-fsupport@trademarkbazaar.com');
	
  $ADMIN->sessset('e-mail has been sent to '.$_POST["name"].'!', 's');
$RW->redir($ADMIN->iurl($comp.'&mode=edit&uid='.$uid.(($start)?'&start='.$start:'').(($followup)?'&followup='.$followup:'')), true); }


if(isset($_POST['allocatelead'])){
if(isset($_POST['ohid'])){
$ps['salesmid']=$_POST['salesmid'];

$ps['ohid']=$_POST['ohid'];

$ps['salesecutiveid']=$_POST['salesecutiveid'];

$PDO->sqlquery("rs",'leads',$ps,'pid',$_GET['uid']);

$aps['lid']=$_GET['uid'];

$aps['sentBy']=$_SESSION["AMD"][0];

$aps['status']=19;

$aps['type']='62';

$ps['deid']=$_POST['deid'];

$aps['sentto']=$ps['ohid'];

if($aps['sentto']!=''){

$PDO->sqlquery("rs",'pms_activity',$aps);

}}	
	
if(isset($_POST['salesecutiveid'])){
$ps['salesmid']=$_POST['salesmid'];

$ps['ohid']=$_POST['ohid'];

$ps['salesecutiveid']=$_POST['salesecutiveid'];

$PDO->sqlquery("rs",'leads',$ps,'pid',$_GET['uid']);

$aps['lid']=$_GET['uid'];

$aps['sentBy']=$_SESSION["AMD"][0];

$aps['status']=19;

$aps['type']='62';

$ps['deid']=$_POST['deid'];

$aps['sentto']=$ps['salesecutiveid'];

if($aps['sentto']!=''){

$PDO->sqlquery("rs",'pms_activity',$aps);

}}



if(isset($_POST['dhid'])){

$ps['salesmid']=$_POST['salesmid'];

$ps['ohid']=$_POST['ohid'];

$ps['dhid']=$_POST['dhid'];

$PDO->sqlquery("rs",'leads',$ps,'pid',$_GET['uid']);

$aps['lid']=$_GET['uid'];

$aps['sentBy']=$_SESSION["AMD"][0];

$aps['status']=19;

$aps['type']='62';

$aps['sentto']=$ps['dhid'];

if($aps['sentto']!=''){

$PDO->sqlquery("rs",'pms_activity',$aps);

}}

if(isset($_POST['deid'])){

$ps['salesmid']=$_POST['salesmid'];

$ps['ohid']=$_POST['ohid'];

$ps['deid']=$_POST['deid'];

$PDO->sqlquery("rs",'leads',$ps,'pid',$_GET['uid']);

$aps['lid']=$_GET['uid'];

$aps['sentBy']=$_SESSION["AMD"][0];

$aps['status']=19;

$aps['type']='62';

$aps['sentto']=$ps['deid'];

if($aps['sentto']!=''){

$PDO->sqlquery("rs",'pms_activity',$aps);

}}

$ADMIN->sessset('Record has been saved!', 's');

$RW->redir($ADMIN->iurl($comp.'&mode=edit&uid='.$uid.(($start)?'&start='.$start:'').(($followup)?'&followup='.$followup:'')), true); 
}



if(isset($_POST['phoneCall'])){

//print_r($_POST); exit;
if($followup){

$follow['fstatus']=1;

$PDO->sqlquery("rs",'pms_activity',$follow,'lid',$_GET['uid']);	

}

$ps['comment']=$_POST['comment'];

$ps['type']=$_POST['type'];

$ps['lid']=$_GET['uid'];

$ps['sentBy']=$_SESSION["AMD"][0];

$ps['status']=0;



$PDO->sqlquery("rs",'pms_activity',$ps);

$lead['status']=4;

$PDO->sqlquery("rs",'leads',$lead,'pid',$_GET['uid']);

$ADMIN->sessset('Record has been saved!', 's');

$RW->redir($ADMIN->iurl($comp.'&mode=edit&uid='.$uid.(($start)?'&start='.$start:'').(($followup)?'&followup='.$followup:'')), true); 
}

if(isset($_POST['escalate'])){
	if($followup){

$follow['fstatus']=1;

$PDO->sqlquery("rs",'pms_activity',$follow,'lid',$_GET['uid']);	

}
	
	$ps['sentBy']=$_SESSION["AMD"][0];
	$ps['name']=$_POST['name'];
	$ps['email']=$_POST['email'];
	$ps['phone']=$_POST['phone'];
	$ps['lid']=$uid;
	$ps['comment']=$_POST['comment'];
	$ps['status']=44;
	$ps['type']='32';
	$PDO->sqlquery("rs",'pms_activity',$ps);
	$lead['esclate']=1;
	
	$PDO->sqlquery("rs",'leads',$lead,'pid',$uid);
	
	$mailbody='<table width="100%" cellpadding="0" cellspacing="0"><tr><td><table style="margin:auto; width:600px; font-size:16px; line-height:24px; font-family:Verdana, Geneva, sans-serif" cellpadding="0" cellspacing="0"><tr><td><table width="100%" cellpadding="5" cellspacing="0"><tr><td><a href="https://www.trademarkbazaar.com"><img src="https://trademarkbazaar.com/images/emailer/tblogo.png" width="109" height="38" alt="trademarkbazaar.com" /></a></td><td align="right"><a style="margin:0 5px;" href="https://www.facebook.com/trademarkbazaar/"><img style="width:30px; height:27px;" src="https://trademarkbazaar.com/images/emailer/face.png" alt="trademarkbazaar.com" /></a>
<a style="margin:0 5px;" href="https://twitter.com/TrademarkBazaar"><img style="width:30px; height:27px;" src="https://trademarkbazaar.com/images/emailer/twitter.png" alt="trademarkbazaar.com" /></a>
<a style="margin:0 5px;" href="https://www.linkedin.com/in/trademark-bazaar-075300144/"><img style="width:30px; height:27px;" src="https://trademarkbazaar.com/images/emailer/link.png" alt="trademarkbazaar.com" /></a></td></tr></table></td></tr><tr><td><table width="100%" cellpadding="15" cellspacing="0"><tr><td style="border:1px solid #ccc;">
	<table width="100%" cellpadding="5" cellspacing="0">
	<tr><td style="padding:10px 20px;"><p style="padding-left:10px; margin:0">Dear Gaurav,</p></td></tr>
	
	<tr><td><table width="100%" cellpadding="0" cellspacing="0"><tr><td style="padding:10px 20px;"><p style="margin:10px 0; text-align:justify; line-height:24px;">Ticket no TMI'.$uid.' has been Escalation. Details are given below;</p></td></tr><tr><td style="padding:10px 20px;"><p style="margin:10px 0; text-align:justify; line-height:24px; color:#00293c;"><strong>Ticket Number: TMI'.$uid.'</strong></p></td></tr>
<tr><td style="padding:10px 20px;"><p style="margin:10px 0; text-align:justify; line-height:24px; color:#00293c;"><strong>Request By: '.$_SESSION["AMD"][1].'</strong></p></td></tr>
<tr><td style="padding:10px 20px;"><p style="margin:10px 0; text-align:justify; line-height:24px; color:#00293c;"><strong>Client Name: '.$_POST['name'].'</strong></p></td></tr>
<tr><td style="padding:10px 20px;"><p style="margin:10px 0; text-align:justify; line-height:24px; color:#00293c;"><strong>Client Email: '.$_POST['email'].'</strong></p></td></tr>
<tr><td style="padding:10px 20px;"><p style="margin:10px 0; text-align:justify; line-height:24px; color:#00293c;"><strong>Phone: '.$_POST['phone'].'</strong></p></td></tr>
<tr><td style="padding:10px 20px;"><p style="margin:10px 0; text-align:justify; line-height:24px; color:#00293c;"><strong>Reason: '.$_POST['comment'].'</strong></p></td></tr>
</table></td></tr>
<tr><td style="padding:15px 10px;">'.$RW->emailSignature($ADMIN->user_type($_SESSION["AMD"][3])).'</td></tr>
</table></td></tr></table></td></tr></table></td></tr></table>';


 $to='cagauravbansal1@gmail.com';
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: TrademarkBazaar <support@trademarkbazaar.com>' . "\r\n";
		
		
		$subject='Escalation of Ticket Number TMI'.$uid.' | RrademarkBazaar';

		$mails=mail($to, $subject, $mailbody, $headers, '-fsupport@trademarkbazaar.com');
	
  $ADMIN->sessset('TMI'.$uid.' Ticket Number has been Escalation', 's');
$RW->redir($ADMIN->iurl($comp.'&mode=edit&uid='.$uid.(($start)?'&start='.$start:'').(($followup)?'&followup='.$followup:'')), true); 

}



if(isset($_POST['wastes'])){

if($followup){

$follow['fstatus']=1;

$PDO->sqlquery("rs",'pms_activity',$follow,'lid',$_GET['uid']);	

}

$ps['comment']=$_POST['comment'];

$ps['lid']=$_GET['uid'];

$ps['sentBy']=$_SESSION["AMD"][0];

$ps['status']=1;

$ps['type']=$_POST['type'];



$PDO->sqlquery("rs",'pms_activity',$ps);

$lead['status']=3;
if($_POST['type']=='13'){
	$lead['status']=7;
	}

$PDO->sqlquery("rs",'leads',$lead,'pid',$_GET['uid']);

$ADMIN->sessset('Record has been saved!', 's');

$RW->redir($ADMIN->iurl($comp.'&mode=edit&uid='.$uid.(($start)?'&start='.$start:'').(($followup)?'&followup='.$followup:'')), true); 
}

if(isset($_POST['followups'])){

if($followup){

$follow['fstatus']=1;

$PDO->sqlquery("rs",'pms_activity',$follow,'lid',$_GET['uid']);	

}

$ps['comment']=$_POST['comment'];

$ps['lid']=$_GET['uid'];

$ps['sentBy']=$_SESSION["AMD"][0];

$ps['status']=2;

$ps['type']=$_POST['type'];

$ps['dates']=$_POST['dates'];

$ps['times']=$_POST['times'];

$ps['reminder']=$_POST['reminder'];


$PDO->sqlquery("rs",'pms_activity',$ps);

$lead['status']=4;

$PDO->sqlquery("rs",'leads',$lead,'pid',$_GET['uid']);

$ADMIN->sessset('Record has been saved!', 's');

$RW->redir($ADMIN->iurl($comp.'&mode=edit&uid='.$uid.(($start)?'&start='.$start:'').(($followup)?'&followup='.$followup:'')), true); 
}

if(isset($_POST['meetings'])){

if($followup){

$follow['fstatus']=1;

$PDO->sqlquery("rs",'pms_activity',$follow,'lid',$_GET['uid']);	

}

$ps['comment']=$_POST['comment'];

$ps['lid']=$_GET['uid'];

$ps['sentBy']=$_SESSION["AMD"][0];

$ps['status']=3;



$ps['type']=$_POST['type'];

$PDO->sqlquery("rs",'pms_activity',$ps);

$lead['status']=4;

$PDO->sqlquery("rs",'leads',$lead,'pid',$_GET['uid']);

$ADMIN->sessset('Record has been saved!', 's');

$RW->redir($ADMIN->iurl($comp.'&mode=edit&uid='.$uid.(($start)?'&start='.$start:'').(($followup)?'&followup='.$followup:'')), true); 
}

if(isset($_POST['proposals'])){

if($followup){

$follow['fstatus']=1;

$PDO->sqlquery("rs",'pms_activity',$follow,'lid',$_GET['uid']);	

}

$ps['comment']=$_POST['comment'];

$ps['lid']=$_GET['uid'];

$ps['sentBy']=$_SESSION["AMD"][0];

$ps['status']=4;


$ps['type']=$_POST['type'];

$PDO->sqlquery("rs",'pms_activity',$ps);

$lead['status']=4;

$PDO->sqlquery("rs",'leads',$lead,'pid',$_GET['uid']);

$ADMIN->sessset('Record has been saved!', 's');

$RW->redir($ADMIN->iurl($comp.'&mode=edit&uid='.$uid.(($start)?'&start='.$start:'').(($followup)?'&followup='.$followup:'')), true); 
}

if(isset($_POST['payments'])){
if($followup){

$follow['fstatus']=1;

$PDO->sqlquery("rs",'pms_activity',$follow,'lid',$_GET['uid']);	

}

$ps['comment']=$_POST['comment'];

$ps['lid']=$_GET['uid'];

$ps['sentBy']=$_SESSION["AMD"][0];

$ps['status']=28;


$ps['type']=$_POST['type'];

$PDO->sqlquery("rs",'pms_activity',$ps);

$lead['status']=2;

$PDO->sqlquery("rs",'leads',$lead,'pid',$_GET['uid']);

$ADMIN->sessset('Record has been saved!', 's');

$RW->redir($ADMIN->iurl($comp.'&mode=edit&uid='.$uid.(($start)?'&start='.$start:'').(($followup)?'&followup='.$followup:'')), true); 
}

if(isset($_POST['invoices'])){
if($followup){

$follow['fstatus']=1;

$PDO->sqlquery("rs",'pms_activity',$follow,'lid',$_GET['uid']);	

}

$ps['comment']=$_POST['comment'];

$ps['lid']=$_GET['uid'];

$ps['sentBy']=$_SESSION["AMD"][0];

$ps['status']=6;

$ps['type']=$_POST['type'];

$PDO->sqlquery("rs",'pms_activity',$ps);

$lead['status']=2;

$PDO->sqlquery("rs",'leads',$lead,'pid',$_GET['uid']);

$ADMIN->sessset('Record has been saved!', 's');

$RW->redir($ADMIN->iurl($comp.'&mode=edit&uid='.$uid.(($start)?'&start='.$start:'').(($followup)?'&followup='.$followup:'')), true); 
}

/*start send Porposal */

if(isset($_POST['psend'])){
	//print_r($_POST);  exit;
	if($followup){

$follow['fstatus']=1;

$PDO->sqlquery("rs",'pms_activity',$follow,'lid',$_GET['uid']);	

}
	
	$ps['lid']=$_GET['uid'];
	$ps['sentBy']=$_SESSION["AMD"][0];
	$ps['status']=4;
	$PDO->sqlquery("rs",'proposalsent',$ps);
	$ps['lid']=$_GET['uid'];
	$ps['sentBy']=$_SESSION["AMD"][0];
	$ps['status']=4;
	$ps['type']='20';
	$PDO->sqlquery("rs",'pms_activity',$ps);
		
	$lead['status']=4;
	$PDO->sqlquery("rs",'leads',$lead,'pid',$_GET['uid']);
  
	 $msql = "SELECT * FROM #_product_manager WHERE pid='".$_POST['service']."'";
$mry=$PDO->db_query($msql);

$mres = $PDO->db_fetch_array($mry);
  
	// echo $mres['body']; exit;  
	   
	   
$msg=str_replace('x,xxx',$mres['price'],$mres['proposal']);	
	
$names=str_replace('signatures',$RW->emailSignature($ADMIN->user_type($_SESSION["AMD"][3])),$msg);	   
$msgf1 =str_replace('cnamexxx',$_POST['name'],$names);	

	   
//echo $msgf1; exit;

	    $to=$_POST['email'];
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: TrademarkBazaar <support@trademarkbazaar.com>' . "\r\n";
		
		$headers .= 'Reply-To:cagauravbansal1@gmail.com,' .$_SESSION["AMD"][2]."\r\n";
	    $headers .= 'Cc: cagauravbansal1@gmail.com,' .$_SESSION["AMD"][2]. "\r\n";
		$subject='Thank You for Requesting Proposal for '.$mres['name'].' | trademarkbazaar.com';
		$mails=mail($to, $subject, $msgf1, $headers, '-fsupport@trademarkbazaar.com');
 $ADMIN->sessset('proposal has been sent to '.$_POST['name'], 's');

$RW->redir($ADMIN->iurl($comp.'&mode=edit&uid='.$uid.(($start)?'&start='.$start:'').(($subpage_id)?'&subpage_id='.$subpage_id:'')), true); 
   
	
	
	}

/*end send Porposal */
/*start  send payment link */
if(isset($_POST['paylink'])){

$ps['lid']=$_GET['uid'];	

$ps['status']=5;

$ps['sentBy']=$_SESSION["AMD"][0];

$PDO->sqlquery("rs",'plinksent',$ps);

$ps['lid']=$_GET['uid'];

$ps['sentBy']=$_SESSION["AMD"][0];

$ps['status']=28;

$ps['type']='23';

$cpid=$PDO->sqlquery("rs",'pms_activity',$ps);

$data=$_POST;
@extract($data);
				$tdquery=$PDO->db_query("select * from #_site_users where email ='".$email."' "); 
				if($tdquery->rowCount()>0){
					$row=$PDO->db_fetch_array($tdquery);
					 $data['user_id']=$row['user_id'];
					}else{
						$data['password']='tm@'.rand(100, 999);
						$data['user_id'] = $PDO->sqlquery("rs","site_users",$data);
						
						}
			$serviceName=$PDO->getsingleresult("select name from #_product_manager where pid='".$_POST['service']."'");
				$data['created_on']=date('Y-m-d H:i:s');
				$data['create_by']=$_SESSION["AMD"][0];
				$data['lid']=$ps['lid'];
				$data['servicename']=$serviceName;
				$customeorderid=$PDO->sqlquery("rs","custom_payments",$data);
				$cpi['cpid']=$customeorderid;
				$PDO->sqlquery("rs",'pms_activity',$cpi,'pid',$cpid);	
				
			
		//$post=$data;
		
				
$mailbody='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Trademark Bazaar</title>
</head>
<body>

<div style="max-width:600px; margin:auto; font-family:\'verdana\',sans-serif, arial,\'lucida Console\'; border-radius:2px solid #343434; background-color:#eff0f0;">
<div style="padding:20px 50px 0 50px;">

<div style="display:inline-block;">
<a href="https://trademarkbazaar.com"><img style="width:118px; height:53px;" src="https://trademarkbazaar.com/images/emailer/tblogo.png" alt="trademarkbazaar.com"></a>
</div>

<div style="float:right; padding-top:10px;">
<a href="https://www.facebook.com/trademarkbazaar/"><img style="width:30px; height:27px;" src="https://trademarkbazaar.com/images/emailer/face.png" alt="trademarkbazaar.com" /></a>
<a href="https://twitter.com/TrademarkBazaar"><img style="width:30px; height:27px;" src="https://trademarkbazaar.com/images/emailer/twitter.png" alt="trademarkbazaar.com" /></a>
<a href="https://www.linkedin.com/in/trademark-bazaar-075300144/"><img style="width:30px; height:27px;" src="https://trademarkbazaar.com/images/emailer/link.png" alt="trademarkbazaar.com" /></a>
</div>

<div style="border-bottom:1px solid #d9d9d9; margin:15px 0;"></div>

<div style="color:#343434; font-size:15px; line-height:25px; text-align:justify;">
<p style="margin:25px 0;"><b>Dear '.$_POST['name'].',</b></p>
<p><b>Thanks for choosing Trademark Bazaar!</b></p>
<div style="padding:10px 40px;">
<p style="text-align:center"><u>Service: <strong>'. $serviceName.'</strong></u></p>
<table cellspacing="2" cellpadding="3" style="width:60%; margin:auto;">
<tbody><tr><td align="center" style="background:#ef9fa2; width:40%;">Amount</td><td align="center" style="background:#ef9fa2; width:60%;">Rs- '. $_POST['amount'].'</td></tr>
</tbody></table>
<p style="text-align:center;"><a style="text-decoration:none; color:#fff; background:#b5181e; border-radius:5px; padding:9px 10px; font-size:15px;margin: 10px auto;   display: inline-block;" href="https://www.trademarkbazaar.com/cart/pay/'.$ADMIN->encrypt_decrypt('encrypt', $customeorderid).'" target="_blank">PAY NOW</a></p>
</div>
<div style="background:rgba(239, 159, 162, 0.14);padding:10px 40px;">
<p>Starting a business in India is no longer a peril as we are here to give you a personalized service right from the business setup to its effective functioning.</p>
</div>
<p>Feel free to contact us anytime for any kind of assistance.</p>
<p><b>Regards,</b></p>
<p>Team Trademarkbazaar.com</p>
</div>
</div>
<div style="padding:10px 50px; display:block; width:38%; float:left; background-color:#c2c2c2; font-size:14px; line-height:22px;"><b>Talk to an Expert</b><br> +91-9999-462-751</div>
<div style="padding:10px 50px; display:block; background-color:#c2c2c2; font-size:14px; line-height:22px;"><b>Support ID</b><br>support@trademarkbazaar.com</div>

</div>
</body>
</html>

';



		$st['status']=2;
		
		
$subject='Payment Request from TrademarkBazaar | '.$serviceName.' | '.$_POST['leadid'];		
		
	$email = new \SendGrid\Mail\Mail(); 
$email->setFrom("support@trademarkbazaar.com", "TrademarkBazaar");
$email->setSubject($subject);
$email->addTo($_POST['email'], $_POST['name']);
$ccEmails = ["cagauravbansal1@gmail.com" => "Gauarv Bansal"];

$email->addCcs($ccEmails);
//$email->setReplyTos($ccEmails);

$email->addContent("text/plain", "and easy to do anywhere, even with PHP");
$email->addContent(
    "text/html", $mailbody
);


$apiKey = SENDGRID_API_KEY;
$sendgrid = new \SendGrid($apiKey);
try {
    $response = $sendgrid->send($email);
 //  print $response->statusCode() . "\n";
   
   // print $response->body() . "\n";
} catch (Exception $e) {
   // echo 'Caught exception: '. $e->getMessage() ."\n";
}	
		
$PDO->sqlquery("rs",'leads',$st,'pid',$_GET['uid']);	
	
$ADMIN->sessset('Payment link has been sent to '.$_POST['name'], 's');

$RW->redir($ADMIN->iurl($comp.(($start)?'&start='.$start:'').(($department)?'&department='.$department:'')), true);

}

/*end send payment link */

if(isset($_POST['steps'])){ 
$query =$PDO->db_query("select * from #_leads where pid ='".$uid."' "); 
$row = $PDO->db_fetch_array($query);
@extract($row);	
if($_POST['dscDelivered']=='1'){
$leadss['completed_on']=date('Y-m-d H:i:s');
}
$leadss['processStatus']=$_POST['processStatus'];
$PDO->sqlquery("rs",'leads',$leadss,'pid',$uid);	
$chkquery =$PDO->db_query("select * from #_incprocess where lid='".$uid."' "); 

if($_POST['pendingDoc']=='1'){
$_POST['pendingsdate']=date('Y-m-d H:i:s');
}
if($_POST['fileSent']=='1'){
$_POST['pendingedate']=date('Y-m-d H:i:s');
$_POST['sentsdate']=date('Y-m-d H:i:s');
}
if($_POST['fileRecived']=='1'){
$_POST['sentedate']=date('Y-m-d H:i:s');
}


if($chkquery->rowCount()==1){
$rowd = $PDO->db_fetch_array($chkquery);
$now = strtotime($rowd["pendingedate"]); 
$your_date = strtotime($rowd["pendingsdate"]);
$datediff = $now - $your_date;
floor($datediff / (60 * 60 * 24));
$PDO->sqlquery("rs",'incprocess',$_POST,'lid',$uid);	



} else {
$_POST['lid']=$uid;
$PDO->sqlquery("rs",'incprocess',$_POST);	 
}

$to=$email;

$headers  = 'MIME-Version: 1.0' . "\r\n";

$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

$headers .= 'From: TrademarkBazaar <support@trademarkbazaar.com>' . "\r\n";



$headers .= 'Reply-To:cagauravbansal1@gmail.com,' .$_SESSION["AMD"][2]."\r\n";

$headers .= 'Cc: cagauravbansal1@gmail.com,' .$_SESSION["AMD"][2]."\r\n";

$subject=$_POST['payment_subject'];

$mails=mail($to, $subject, $_POST['content'], $headers, '-fsupport@trademarkbazaar.com');
$ADMIN->sessset('Email has been sent!', 's');

$RW->redir($ADMIN->iurl($comp.'&mode=edit&uid='.$uid.(($start)?'&start='.$start:'').(($followup)?'&followup='.$followup:'')), true); 
}



if(isset($_POST['projectStatus'])){
if($_POST['comments']!=''){
$POST['comments']=$_POST['comments'];

$POST['lid']=$uid;

$POST['userid']=$_SESSION["AMD"][0];

$PDO->sqlquery("rs",'comment',$POST);
}
$path = UP_FILES_FS_PATH."/clientdetail/";
$count = 1;
$comm=':';
$arrcont= sizeof($_FILES['upload']['name']);
if($_FILES['upload'][name]){
// Loop $_FILES to execute all files
$filename2='';
$filename='';
foreach ($_FILES['upload']['name'] as $f => $fname) {  
if ($_FILES['upload']['error'][$f] == 0) {	
// No error found! Move uploaded files 
$fname=mt_rand(10,999).'_'.$fname;
if($arrcont==$count){
$comm='';
}

if(move_uploaded_file($_FILES["upload"]["tmp_name"][$f], $path.$fname)) {
$count++; // Number of successfully uploaded files
$filename=$fname;
$filename2 .=$filename.$comm;
}else {echo 'uploading failed'; exit; }
}
}
}
if($_POST['allfl']!='' && $filename!=''){
//$allflss = explode(":", $_POST['allfl']);
$pst['upload']=$_POST['allfl'].':'.$filename2;
//print_r($_POST['upload']);
} else {
$pst['upload']=$filename2;
}
$PDO->sqlquery("rs",'leads',$pst,'pid',$uid);
}	
if($uid)

{

if($_POST['markassell']=='1'){

if($PDO->getsingleresult("select markassell from #_leads where pid='".$uid."'")!='1'){

$_POST['markasselldate']=$today=date("Y-m-d");}}

//$_POST['updateid']=$uid;

//$flag = $PAGS->update($_POST);



} else {

if($_POST['markassell']=='1'){$_POST['markasselldate']=$today=date("Y-m-d");}

//$flag = $PAGS->add($_POST);



}

   

   if($flag[0]==1)

   {

   if($_POST['markassell']=='1'){?>
<script>

   if(confirm('Want to genrate Invoice')){

				window.location.href='<?=SITE_PATH_ADM?>index.php?comp=invoice&mode=add2&leadId=<?=$flag[1]?>';

			}else{

				alert('Genrate invoice manually.');

				}

				</script>
<?php

	   

	   echo $flag[1];

	   }

     $RW->redir($ADMIN->iurl($comp.(($start)?'&start='.$start:'').(($uid)?'&uid='.$uid:'').(($mode)?'&mode='.$mode:'').(($_GET['view'])?'&view='.$_GET['view']:'')), true);

   }

}





if($uid)

{

    $query =$PDO->db_query("select * from #_".tblName." where pid ='".$uid."' "); 

	$row = $PDO->db_fetch_array($query);

	@extract($row);	

}
$salesAmiount=$PDO->getSingleresult("select sum(serviceprice) from #_crequirement where lid='".$pid."'");

$paidAmiount=$PDO->getSingleresult("select sum(qAmount) from #_paymentdetails where lid='".$pid."'");
$costAmiount=$PDO->getSingleresult("select sum(costprice) from #_cost_list where lid='".$_GET['uid']."'");
?>

<section class="mt30">
  <div class="container ">
    <div class="row">
      <div class="col">
        <h2>Lead :
          <?=$rwi?>
        </h2>
      </div>
       <div class="col">
        <h2>Sales : Rs <?=$salesAmiount;?>	 </h2>
      </div>
      <div class="col">
        <h2>Payment : Rs <?=$paidAmiount;?>	 </h2>
      </div>
         <div class="col">
        <h2>Cost : Rs <?=$costAmiount;?></h2>
      </div>
         <div class="col">
        <h2>Profit : Rs <?=$paidAmiount-$costAmiount?>	 </h2>
      </div>
      
      
      
    </div>
    <div class="">
      <div class="row my-2">
        <div class="col-12 col-md-4">
          <div class="lead-left-sidebar ">
            <h3>
              <?=$name?>
              <a class="pull-right" href="<?=$ADMIN->iurl($comp,'add', $pid)?>"><small>Edit</small></a> </h3>
            
            <!-- Edit The Modal -->
            
            <div class="modal fade" id="edit">
              <div class="modal-dialog modal-md">
                <form action="#" method="post" enctype="multipart/form-data">
                  <div class="modal-content"> 
                    
                    <!-- Modal Header -->
                    
                    <div class="modal-header">
                      <h4 class="modal-title m-0 p-0">Edit</h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    
                    <div class="modal-body">
                      <div class="">
                        <div class="row">
                          <div class="col-12 col-md-12">
                            <div class="form-group">
                              <label>Address</label>
                              <textarea  class="form-control " name="address"/>
                              <?=$address?>
                              </textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <!-- Modal footer -->
                    
                    <div class="modal-footer">
                      <input type="hidden" name="upid" value="<?=$pid?>"  />
                      <button type="submit" name="addrUpd" class="btn btn-info">Update</button>
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <ul class="list-unstyled">
              <li> <i class="fa fa-envelope-o"></i>
                <?=$email?>
              </li>
              <li> <i class="fa fa-mobile"> </i>
                <?=$phone?>
              </li>
             
              <li> <i class="fa fa-calendar"> </i>
                <?=date('d-m-Y',strtotime($created_on))?>
                <?=date('h:i a',strtotime($created_on))?>
              </li>
              
    
              
              
            </ul>
            <hr>
            <div class="row score">
              <div class="col-sm-6">Call:
                <?=$PDO->getSingleresult("select count(*) from #_pms_activity where lid='".$_GET['uid']."' and status=0")?>
              </div>
              <?php 

			  

$pkIds=$PDO->db_query("select type from #_pms_activity where lid='".$uid."'"); 

if($pkIds->rowCount()>0)



	        {

$pkIdResult=$PDO->db_fetch_all($pkIds,PDO::FETCH_COLUMN);

  $spkgId = implode(',',$pkIdResult);

  $scores=$PDO->getSingleresult("select sum(score) from #_activites_score where pid IN($spkgId)");

			}
$leadSource=$PDO->getSingleresult("select name from #_lead_source where pid='".$source."'");
$worksttus=$PDO->getSingleresult("select name from #_work_process where pid='".$processStatus."'");
$services=$PDO->getSingleresult("select name from #_product_manager where pid='".addslashes($service)."'");
if($deptType==4){$nn=8;}elseif($deptType==5 || $deptType==7){$nn=12;}elseif($deptType==6){$nn=16;}
			   ?>
              <div class="col-sm-6">Score:
                <?=$scores?>
              </div>
            </div>
          </div>
          <?php $drQuery=$PDO->db_query("select * from #_directorDetails where lid='".$uid."'"); 

if($drQuery->rowCount()>0){
?>
  <div class="lead-left-sidebar">
            <h4 class="head">Director Details </h4>
<?php 
$kk=1;	
	while($drRes=$PDO->db_fetch_array($drQuery)){
	 ?>
          
        
            <ul class="list-unstyled text-bold">
              <li style="background: 1px #00293c2e;" class="text-center"> Director <?=$kk?> </li>
              <li>Name <span class="pull-right"><?=$drRes['dname']?></span></li>
              <li>Email <span class="pull-right"><?=$drRes['demail']?></span></li>
              <li>Phone <span class="pull-right"><?=$drRes['dphone']?></span></li>
                
            </ul>
          
          <?php $kk++;} echo '</div>';}?>
          <div class="lead-left-sidebar">
            <h4 class="head">Special Request</h4>
            <ul class="list-unstyled text-bold">
              <li>
                <?=$comments?>
              </li>
            </ul>
          </div>
          <!--<div class="lead-left-sidebar">
            <h4 class="head">Product Type</h4>
            <div class="form-group p-4">
            <select  class="form-control">
              <option value="">-------select Product Type------</option>
              <option value="Only Activities">Only Activities</option>
              <option value="Complete Package">Complete Package</option>
              <option value="Land Arrangement">Land Arrangement</option>
              <option value="Visa Only">Visa Only</option>
              <option value="Hotel Only">Hotel Only</option>
              <option value="Flight Only">Flight Only</option>
            </select>
            </div>
          </div>-->
          <div class="lead-left-sidebar">
            <h4 class="head ">
              <?=$services==''?$service:$services?>
            </h4>
            <ul class="list-unstyled text-bold">
              <li> <a href="javascript:void(0)" data-toggle="modal" data-target="#Proposal"> Proposal</a> <span class="pull-right">
                <?=$PDO->getSingleresult("select count(*) from #_proposalsent where lid='".$_GET['uid']."'")?>
                </span></li>
					<?php
                    $drQuery2=$PDO->db_query("select * from #_directorDetails where lid='".$uid."'"); 
                    if($drQuery2->rowCount()>0){
                   $emailfield .=
                   ' <select class="validate[required] form-control" name="email" >
                    <option value="">Select...</option>';
                    while($drRes=$PDO->db_fetch_array($drQuery2)){
						  
                 $emailfield .='<option value="'.$drRes['demail'].'">'.$drRes['demail'].' </option>';
                     }
					$emailfield .='</select>'; 
					  } else {
					
           $emailfield='<input type="text" name="email" class="validate[required] form-control" value="'.$email.'" readonly="readonly" >';
 
					 } ?>
	
              <!-- Proposal Modal -->
              <div class="modal fade" id="Proposal">
                <div class="modal-dialog">
                  <form name="pp" method="post" action="#" enctype="multipart/form-data">
                    <div class="modal-content"> 
                      
                      <!-- Modal Header -->
                      <div class="modal-header">
                        <h4 class="modal-title m-0 p-0">Proposal</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      
                      <!-- Modal body -->
                      <div class="modal-body">
                        <div class="row">
                          <div class="col-6">
                            <div class="form-group">
                              <label for=""> Customer Name</label>
                              <input type="text" name="name" class="validate[required] form-control" value="<?=$name?>"  readonly="readonly">
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-group">
                              <label for=""> Email ID</label>
                        <?=$emailfield?>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <div class="form-group"> <!-- State Button -->
                              <label for="state_id" class="control-label">Select Service</label>
                              <select class="validate[required] form-control" name="service" >
                                <option value="">Select...</option>
                                <?php 
 $service_query = $PDO->db_query("select * from #_product_manager where status='1'");
                while($service_rows = $PDO->db_fetch_array($service_query)){ ?>
                                <option value="<?=$service_rows['pid']?>" <?=($service_rows['pid']==$service)?'selected="selected"':''?>  >
                                <?=$service_rows['name']?>
                                </option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                      <!-- Modal footer -->
                      <div class="modal-footer">
                        <button type="submit" name="psend" class="btn btn-primary">Send</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <li> <a href="javascript:void(0)"  data-toggle="modal" data-target="#Payment">Payment Link</a> <span class="pull-right">
                <?=$PDO->getSingleresult("select count(*) from #_plinksent where lid='".$pid."'")?>
                </span></li>
              
              <!-- Payment Link Modal -->
              <div class="modal fade" id="Payment">
                <div class="modal-dialog">
                  <form name="pay" method="post" action="#" enctype="multipart/form-data">
                    <div class="modal-content"> 
                      
                      <!-- Modal Header -->
                      <div class="modal-header">
                        <h4 class="modal-title m-0 p-0">Payment Link</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      
                      <!-- Modal body -->
                      <div class="modal-body">
                        <div class="row">
                          <div class="col-6">
                            <div class="form-group">
                              <label for=""> Customer Name</label>
                              <input type="text" name="name" class="validate[required] form-control" value="<?=$name?>"  readonly="readonly">
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-group">
                              <label for=""> Email ID</label>
                 <?=$emailfield?>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-6">
                            <div class="form-group">
                              <label>Phone No</label>
                              <input type="text" name="phone" class="validate[required] form-control" value="<?=$phone?>" readonly="readonly">
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="form-group">
                              <label>Amount to pay</label>
                              <input type="text" name="amount" class="validate[required] form-control"  placeholder="">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <div class="form-group"> <!-- State Button -->
                              <label>Select Service</label>
                              <select class="validate[required] form-control" name="service" >
                                <option value="">Select...</option>
                                <?php 
 $service_query = $PDO->db_query("select * from #_product_manager where status='1'");
                while($service_rows = $PDO->db_fetch_array($service_query)){ ?>
                                <option value="<?=$service_rows['pid']?>" <?=($service_rows['pid']==$service)?'selected="selected"':''?>  >
                                <?=$service_rows['name']?>
                                </option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- Modal footer -->
                      <div class="modal-footer">
                      
                        <button type="submit" name="paylink" class="btn btn-primary">Send</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              
              <!--<li><a href="javascript:void(0)" data-toggle="modal" data-target="#QuickMsg">Quick Msg</a></li>
              <div class="modal fade" id="QuickMsg">
                <div class="modal-dialog">
                  <form name="pay" method="post" action="#" enctype="multipart/form-data">
                    <div class="modal-content"> 
                      
                    
                      <div class="modal-header">
                        <h4 class="modal-title m-0 p-0">Quick Message</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      
                     
                      <div class="modal-body">
                        <div class="row">
                          <div class="col-md-6 col-12">
                            <div class="form-group">
                              <label for=""> Customer Name</label>
                              <input type="text" name="name" class="validate[required] form-control" value="<?=$name?>"  readonly="readonly">
                            </div>
                          </div>
                          <div class="col-md-6 col-12">
                            <div class="form-group">
                              <label>Phone No</label>
                              <input type="text" name="phone" class="validate[required] form-control" value="<?=$phone?>" readonly="readonly">
                            </div>
                          </div>
                        </div>
                        
                        
                        
                        
                        <div class="row">
                          <div class="col-12">
                            <div class="form-group">
                                <label> Message</label>
                                 <textarea class="form-control"> </textarea>

                            </div>
                          </div>
                        </div>
                      </div>
                    
                      <div class="modal-footer">
                        <input type="hidden" name="leadid" value="<?=$rwi?>" >
                        <button type="submit" name="QuickMsg" class="btn btn-primary">Send</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              -->
              
              
              
              <li><a href="javascript:void(0)" data-toggle="modal" data-target="#QuickEmail">Quick Email</a>  <span class="pull-right">
                <?=$PDO->getSingleresult("select count(*) from #_pms_activity where lid='".$_GET['uid']."' and type=29")?>
                </span></li>
                     <!--Quick Email-->
              <div class="modal fade" id="QuickEmail">
                <div class="modal-dialog">
                  <form name="pay" method="post" action="#" enctype="multipart/form-data">
                    <div class="modal-content"> 
                      
                      <!-- Modal Header -->
                      <div class="modal-header">
                        <h4 class="modal-title m-0 p-0">Quick Email</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      
                      <!-- Modal body -->
                      <div class="modal-body">
                        <div class="row">
                          <div class="col-6">
                            <div class="form-group">
                              <label for=""> Customer Name</label>
                              <input type="text" name="name" class="validate[required] form-control" value="<?=$name?>"  readonly="readonly">
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-group">
                              <label for=""> Email ID</label>
                   <?=$emailfield?>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <div class="form-group">
                              <label> Subject</label>
                              <input type="text" name="subject" class="validate[required] form-control" >
                            </div>
                          </div>
                        </div>
                        
                        
                        
                        <div class="row">
                          <div class="col-12">
                            <div class="form-group">
                                 <label> Message</label>

                              <textarea name="comment" class="form-control validate[required]"></textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- Modal footer -->
                      <div class="modal-footer">
                        
                        <button type="submit" name="quickemail" class="btn btn-primary">Send</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>

              
              
              
              
              
              <a href="javascript:void(0)"  data-toggle="modal" data-target="#Escalation" >
              <li class="btn-danger btn text-white " > Escalation </li>
              </a>
          <?php
					   if (!in_array($_SESSION["AMD"][3], array("5", "4",))){ ?>    
            <a href="javascript:void(0)"   data-toggle="modal" data-target="#Allocate"><li class="btn-info btn text-white" > Allocate </li>
              </a>
              <?php } ?>
            </ul>
            <div class="modal fade" id="Escalation">
  <div class="modal-dialog">
  <form name="esc" method="post" action="#" enctype="multipart/form-data">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Escalation  of tickets : <?=$rwi?></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
   
     <div class="row">
     <div class="col"><div class="form-group">
                    <label>Customer Name</label>
                    <input type="text" name="name" class="form-control validate[required]" value="<?=$name?>"  placeholder="">
                  </div></div> 
     
     </div>
     <div class="row">
     <div class="col-6">
     <div class="form-group">
                     <label>Phone No</label>
                    <input type="text" name="phone" class="form-control validate[required]" value="<?=$phone?>"  placeholder="">
                  </div></div> 
                  
                  
     <div class="col-6"><div class="form-group">
     <label>Email ID</label>
                    <input type="text" name="email" class="form-control validate[required]" value="<?=$email?>"  placeholder="">
                  </div></div>
     </div>
     <div class="row">
     <div class="col">
     <div class="form-group">
                     <label>Issue for Escalation </label>
                    <textarea name="comment" class="form-control validate[required]"> </textarea>
                  </div></div> 
                  
                
     
     </div>
     
    </div>

      <!-- Modal footer -->
      <div class="modal-footer">
    
              <button type="submit" name="escalate" class="btn btn-primary" >Esclate</button>

        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
    </form>
  </div>
</div>
            <!-- Allocate model -->
            <form name="allocate" method="post" action="#" enctype="multipart/form-data">
              <div class="modal fade" id="Allocate">
                <div class="modal-dialog modal-md">
                  <div class="modal-content"> 
                    
                    <!-- Modal Header -->
                    <div class="modal-header">
                      <h4 class="modal-title m-0 p-0">Allocate Lead</h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                      <div class="">
                       <?php
					   if (!in_array($_SESSION["AMD"][3], array("2", "4",))){ ?>
                        <div class="row">
                          <div class="col-12 col-md-6">
                            <div class="form-group">
                              <label >Sales Manager</label>
                              <select name="salesmid" class="form-control">
                                <?php 
 $sm_query = $PDO->db_query("select * from pms_admin_users where user_type='3'");
                while($sm_rows = $PDO->db_fetch_array($sm_query)){ ?>
                                <option value="<?=$sm_rows['user_id']?>" <?=($sm_rows['user_id']==$salesmid)?'selected="selected"':''?>  >
                                <?=$sm_rows['name']?>
                                </option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-12 col-md-6">
                            <div class="form-group">
                              <label >Sales Executive</label>
                              <select name="salesecutiveid" class="form-control">
                                <option value="">Select...</option>
                                <?php 
 $sem_query = $PDO->db_query("select * from pms_admin_users where user_type='5'");
                while($sem_rows = $PDO->db_fetch_array($sem_query)){ ?>
                                <option value="<?=$sem_rows['user_id']?>" <?=($sem_rows['user_id']==$salesecutiveid)?'selected="selected"':''?>  >
                                <?=$sem_rows['name']?>
                                </option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                        </div>
                        <?php } 
						if (!in_array($_SESSION["AMD"][3], array("3", "5",)))
						{ ?>
                        <div class="row">
                        <?php 
						if (in_array($_SESSION["AMD"][3], array("1", "6",))){ ?>
                          <div class="col-12 col-md-6">
                            <div class="form-group">
                              <label >Operation head</label>
                              <select name="ohid" class="form-control">
                                <option value="">Select...</option>
                                <?php 
 $sem_query = $PDO->db_query("select * from pms_admin_users where user_type IN ('1','6')");
                while($sem_rows = $PDO->db_fetch_array($sem_query)){ ?>
                                <option value="<?=$sem_rows['user_id']?>" <?=($sem_rows['user_id']==$ohid)?'selected="selected"':''?>  >
                                <?=$sem_rows['name']?>
                                </option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                          <?php } /*?><div class="col-12 col-md-6">
                            <div class="form-group">
                              <label >Department Head</label>
                              <select name="dhid" class="form-control">
                                <option value="">Select...</option>
                                <?php 
 $sem_query = $PDO->db_query("select * from pms_admin_users where user_type='2'");
                while($sem_rows = $PDO->db_fetch_array($sem_query)){ ?>
                                <option value="<?=$sem_rows['user_id']?>" <?=($sem_rows['user_id']==$dhid)?'selected="selected"':''?>  >
                                <?=$sem_rows['name']?>
                                </option>
                                <?php } ?>
                              </select>
                            </div>
                          </div><?php */?>
                          
                          <div class="col-12 col-md-6">
                            <div class="form-group">
                              <label >Operation Executive</label>
                              <select name="deid" class="form-control">
                                <option value="">Select...</option>
                                <?php
						if($_SESSION["AMD"][3]==2){
							$oe="and rmanager='".$_SESSION["AMD"][0]."'";
							}		 
 $sem_query = $PDO->db_query("select * from pms_admin_users where user_type='4' ".$oe."");
                while($sem_rows = $PDO->db_fetch_array($sem_query)){ ?>
                                <option value="<?=$sem_rows['user_id']?>" <?=($sem_rows['user_id']==$deid)?'selected="selected"':''?>  >
                                <?=$sem_rows['name']?>
                                </option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                        </div>
                        <?php } ?>
                        <div class="row">
                          
                        </div>
                      </div>
                    </div>
                    
                    <!-- Modal footer -->
                    <div class="modal-footer">
                      <button type="submit" name="allocatelead" class="btn btn-primary" >Submit</button>
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="col-12 col-md-8">
          <div class="lead-wrp-rightside">
            <ul class="nav nav-tabs">
              <li class="nav-item"> <a href="#Activity" data-target="#Activity" data-toggle="tab" class="nav-link  active">Activity </a> </li>
               <li class="nav-item"> <a href="#AdditionalReq" data-target="#" data-toggle="tab" class="nav-link">Sales</a> </li>
               <li class="nav-item "> <a href="#WorkingTeam" data-target="#WorkingTeam" data-toggle="tab" class="nav-link"> Allocated To</a> </li>
               <li class="nav-item "> <a href="#paymentDetails" data-target="#paymentDetails" data-toggle="tab" class="nav-link gen profile-link ">Payments</a> </li>
                <li class="nav-item "> <a href="#Cost" data-target="#Cost" data-toggle="tab" class="nav-link">Cost</a> </li>
                 <li class="nav-item "> <a href="#Invoices" data-target="#Invoices" data-toggle="tab" class="nav-link">Invoices</a> </li>
                  <li class="nav-item"> <a href="#WorkDetails" data-target="#WorkDetails" data-toggle="tab" class="nav-link">Work </a> </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active " id="Activity">
                <div class="p-3">
                  <div class="row">
                    <div class="col"><a href="javascript:void(0)" data-toggle="modal" data-target="#Phone" class="btn btn-primary btn-block mb-1" role="button">Phone</a> 
                      <!--Phone Call Modal -->
                      <div class="modal fade" id="Phone">
                        <div class="modal-dialog modal-md">
                          <div class="modal-content"> 
                            
                            <!-- Modal Header -->
                            
                            <div class="modal-header">
                              <h4 class="modal-title">Phone Call</h4>
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            
                            <!-- Modal body -->
                            
                            <form name="pcall" action="#" method="post" enctype="multipart/form-data">
                              <div class="modal-body">
                                <div>
                                  <div class="row">
                                    <div class="col-12 col-md-12">
                                      <div class="form-group">
                                        <label>Select Activity</label>
                                        <select name="type" class="form-control validate[required]">
                                          <?php

             $lead_stage_query = $PDO->db_query("select * from #_activites_score where  status='1' and agroup='1' order by name ASC");

				while($lead_stage_rows = $PDO->db_fetch_array($lead_stage_query)){ ?>
                                          <option value="<?=$lead_stage_rows['pid']?>" <?=($lead_stage_rows['pid']==$type)?'selected="selected"':''?>  >
                                          <?=$lead_stage_rows['name']?>
                                          </option>
                                          <?php } ?>
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-12 col-md-12">
                                      <div class="form-group">
                                        <label>Call Description</label>
                        <textarea name="comment" class="form-control validate[required]" placeholder="Type your comment for call"/></textarea>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              
                              <!-- Modal footer -->
                              
                              <div class="modal-footer">
                                <button type="submit" name="phoneCall" class="btn btn-info">Save</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col"><a href="javascript:void(0)" data-toggle="modal" data-target="#Waste" class="btn btn-primary btn-block mb-1 " role="button">Waste</a> 
                      <!--Waste Call Modal -->
                      <form name="waste" action="#" method="post" enctype="multipart/form-data">
                        <div class="modal fade" id="Waste">
                          <div class="modal-dialog modal-md">
                            <div class="modal-content"> 
                              
                              <!-- Modal Header -->
                              
                              <div class="modal-header">
                                <h4 class="modal-title">Waste</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                              
                              <!-- Modal body -->
                              
                              <div class="modal-body">
                                <div class="row">
                                  <div class="col-12 col-md-12">
                                    <div class="form-group">
                                      <label>Reason for Waste</label>
                                      <select name="type" class="form-control validate[required]">
                                        <?php

             $lead_stage_query = $PDO->db_query("select * from #_activites_score where  status='1' and agroup='2' order by name asc");

				while($lead_stage_rows = $PDO->db_fetch_array($lead_stage_query)){ ?>
                                        <option value="<?=$lead_stage_rows['pid']?>" <?=($lead_stage_rows['pid']==$type)?'selected="selected"':''?>  >
                                        <?=$lead_stage_rows['name']?>
                                        </option>
                                        <?php } ?>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-12">
                                    <div class="form-group">
                                      <label>Comment</label>
            <textarea name="comment"  class="form-control validate[required]"  placeholder="Type here comment"/></textarea>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              
                              <!-- Modal footer -->
                              
                              <div class="modal-footer">
                                <button type="submit" name="wastes" class="btn btn-info">Save</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="col"><a href="javascript:void(0)" data-toggle="modal" data-target="#createfollowup" class="btn btn-primary btn-block mb-1" role="button">Followup</a> 
                      <!-- Create follow task -->
                      <form name="followup" action="#" method="post" enctype="multipart/form-data">
                        <div class="modal fade" id="createfollowup">
                          <div class="modal-dialog modal-md">
                            <div class="modal-content"> 
                              
                              <!-- Modal Header -->
                              
                              <div class="modal-header">
                                <h4 class="modal-title">Create followup </h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                              
                              <!-- Modal body -->
                              
                              <div class="modal-body">
                                <div class="row">
                                  <div class="col-12 col-md-12">
                                    <div class="form-group">
                                      <label>Subject</label>
                                      <select name="type" class="form-control validate[required]">
                                        <?php

             $lead_stage_query = $PDO->db_query("select * from #_activites_score where  status='1' and agroup='3' order by name asc");

				while($lead_stage_rows = $PDO->db_fetch_array($lead_stage_query)){ ?>
                                        <option value="<?=$lead_stage_rows['pid']?>" <?=($lead_stage_rows['pid']==$type)?'selected="selected"':''?>  >
                                        <?=$lead_stage_rows['name']?>
                                        </option>
                                        <?php } ?>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-12 col-md-12">
                                    <label>Schedule</label>
                                  </div>
                                  <div class="col-6 col-md-6">
                                    <div class="form-group">
                                      <input type="text" name="dates" autocomplete="off" class="form-control mb5 date validate[required]" placeholder="select date" />
                                    </div>
                                  </div>
                                  <div class="col-6 col-md-6">
                                    <div class="form-group">
                                      <input  type="text" name="times" autocomplete="off"  class="form-control mb5 time validate[required]"  placeholder="time" />
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-12">
                                    <div class="form-group">
                                      <input type="checkbox"  value="1" name="reminder">
                                      Remind 15 Minute before the task </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-12">
                                    <div class="form-group">
                                      <label>Note</label>
                                      <textarea  name="comment" class="form-control validate[required]"/></textarea>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              
                              <!-- Modal footer -->
                              
                              <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" name="followups">Save</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="col"> <a href="javascript:void(0)" data-toggle="modal" data-target="#Meeting" class="btn btn-primary btn-block mb-1" role="button">Meeting</a> 
                      <!--Meeting Model -->
                      <form name="Meeting" action="#" method="post" enctype="multipart/form-data">
                        <div class="modal fade" id="Meeting">
                          <div class="modal-dialog modal-md">
                            <div class="modal-content"> 
                              
                              <!-- Modal Header -->
                              
                              <div class="modal-header">
                                <h4 class="modal-title">Meeting</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                              
                              <!-- Modal body -->
                              
                              <div class="modal-body">
                                <div class="row">
                                  <div class="col-12 col-md-12">
                                    <div class="form-group">
                                      <label>Select Activity</label>
                                      <select name="type" class="form-control validate[required]">
                                        <?php

             $lead_stage_query = $PDO->db_query("select * from #_activites_score where  status='1' and agroup='4' order by name asc");

				while($lead_stage_rows = $PDO->db_fetch_array($lead_stage_query)){ ?>
                                        <option value="<?=$lead_stage_rows['pid']?>" <?=($lead_stage_rows['pid']==$type)?'selected="selected"':''?>  >
                                        <?=$lead_stage_rows['name']?>
                                        </option>
                                        <?php } ?>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-12">
                                    <div class="form-group">
                                      <label>Comment</label>
                                      <textarea name="comment"  class="form-control validate[required]"/></textarea>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              
                              <!-- Modal footer -->
                              
                              <div class="modal-footer">
                                <button type="submit" class="btn btn-info" name="meetings">Save</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                    
                    
                  </div>
                  <div class="row mt-2">
                  <div class="col"> <a href="javascript:void(0)" data-toggle="modal" data-target="#aproposal" class="btn btn-primary btn-block mb-1" role="button">Proposal</a> 
                      <!--Proposal Model -->
                      <form name="Proposal" action="#" method="post" enctype="multipart/form-data">
                        <div class="modal fade" id="aproposal">
                          <div class="modal-dialog modal-md">
                            <div class="modal-content"> 
                              
                              <!-- Modal Header -->
                              
                              <div class="modal-header">
                                <h4 class="modal-title">Proposal</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                              
                              <!-- Modal body -->
                              
                              <div class="modal-body">
                                <div class="row">
                                  <div class="col-12 col-md-12">
                                    <div class="form-group">
                                      <label>Select Activity</label>
                                      <select name="type" class="form-control validate[required]">
                                        <?php

             $lead_stage_query = $PDO->db_query("select * from #_activites_score where  status='1' and agroup='5' order by name asc");

				while($lead_stage_rows = $PDO->db_fetch_array($lead_stage_query)){ ?>
                                        <option value="<?=$lead_stage_rows['pid']?>" <?=($lead_stage_rows['pid']==$type)?'selected="selected"':''?>  >
                                        <?=$lead_stage_rows['name']?>
                                        </option>
                                        <?php } ?>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-12">
                                    <div class="form-group">
                                      <label>Comment</label>
                                      <textarea name="comment"  class="form-control validate[required]"/></textarea>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              
                              <!-- Modal footer -->
                              
                              <div class="modal-footer">
                                <button type="submit" class="btn btn-info" name="proposals">Save</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="col"><a href="javascript:void(0)" data-toggle="modal" data-target="#Paymentact" class="btn btn-primary btn-block mb-1" role="button">Payment</a> 
                      <!--Payment -->
                      <form name="Payment" action="#" method="post" enctype="multipart/form-data">
                        <div class="modal fade" id="Paymentact">
                          <div class="modal-dialog modal-md">
                            <div class="modal-content"> 
                              
                              <!-- Modal Header -->
                              
                              <div class="modal-header">
                                <h4 class="modal-title">payments</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                              
                              <!-- Modal body -->
                              
                              <div class="modal-body">
                                <div class="row">
                                  <div class="col-12 col-md-12">
                                    <div class="form-group">
                                      <label>Select Activity</label>
                                      <select name="type" class="form-control validate[required]">
                                        <?php

             $lead_stage_query = $PDO->db_query("select * from #_activites_score where  status='1' and agroup='6' order by name asc");

				while($lead_stage_rows = $PDO->db_fetch_array($lead_stage_query)){ ?>
                                        <option value="<?=$lead_stage_rows['pid']?>" <?=($lead_stage_rows['pid']==$type)?'selected="selected"':''?>  >
                                        <?=$lead_stage_rows['name']?>
                                        </option>
                                        <?php } ?>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-12">
                                    <div class="form-group">
                                      <label>Comment</label>
                                      <textarea name="comment"  class="form-control validate[required]"/></textarea>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              
                              <!-- Modal footer -->
                              
                              <div class="modal-footer">
                                <button type="submit" class="btn btn-info" name="payments">Save</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="col"> 
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#Invoice" class="btn btn-primary btn-block mb-1" role="button">Invoice</a> 
                 <form name="Invoice" action="#" method="post" enctype="multipart/form-data">
                        <div class="modal fade" id="Invoice">
                          <div class="modal-dialog modal-md">
                            <div class="modal-content"> 
                              
                              <!-- Modal Header -->
                              
                              <div class="modal-header">
                                <h4 class="modal-title">Invoice</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                              
                              <!-- Modal body -->
                              
                              <div class="modal-body">
                                <div class="row">
                                  <div class="col-12 col-md-12">
                                    <div class="form-group">
                                      <label>Select Activity</label>
                                      <select name="type" class="form-control validate[required]">
                                        <?php

             $lead_stage_query = $PDO->db_query("select * from #_activites_score where  status='1' and agroup='7' order by name asc");

				while($lead_stage_rows = $PDO->db_fetch_array($lead_stage_query)){ ?>
                                        <option value="<?=$lead_stage_rows['pid']?>" <?=($lead_stage_rows['pid']==$type)?'selected="selected"':''?>  >
                                        <?=$lead_stage_rows['name']?>
                                        </option>
                                        <?php } ?>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-12">
                                    <div class="form-group">
                                      <label>Comment</label>
                                      <textarea name="comment"  class="form-control validate[required]"/></textarea>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              
                              <!-- Modal footer -->
                              
                              <div class="modal-footer">
                                <button type="submit" class="btn btn-info" name="invoices">Save</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>  
                    </div>
                    
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="paymentDetails">
                <div class="p-3">
             <button type="button" class="btn btn-primary btn-sm mb-1" data-toggle="modal" data-target="#add_payment">Add Payment </button>

                
                  <div class="table-responsive saleextutive">
                    <table  class="table table-striped table-bordered sale">
                      <tr>
                        <th>Amount </th>
                        <th>Payment Mode</th>
                        <th>Particulars</th>
                        <th>Date</th>
                         <th>Details</th>
                        <!--<th>Status</th>-->
                      </tr>
                      <?php 
 $pay_query = $PDO->db_query("select * from #_paymentdetails where lid='".$uid."' order by pid DESC");
 while($pay_rows = $PDO->db_fetch_array($pay_query)){ ?>
                      <tr>
                        <td>Rs
                          <?=$pay_rows['qAmount']?></td>
                   
                        <td><?=$ADMIN->displayPaymentMode($pay_rows['pmode']);?></td>
                        <td><?=$pay_rows['tnumber']?></td>
                        <td><?=$pay_rows['dates']?></td>
                        <!--<td><?=$pay_rows['status']==0?'Not Verified':'Verified'?></td>-->
                        <td><?=$pay_rows['pg'].$pay_rows['bankName'].$pay_rows['paytm']?></td>
                      </tr>
                      <?php } ?>
                    </table>
                  </div>
                  <div class="row">
                    <div class="col-12">
                      <div class="form-group">
                        <!-- Genrate Order model -->
                        <form name="payments" action="#" method="post" enctype="multipart/form-data">
                          <div class="modal fade" id="add_payment">
                            <div class="modal-dialog modal-md">
                              <div class="modal-content"> 
                                <!-- Modal Header -->
                                <div class="modal-header">
                                  <h4 class="modal-title">Add Payment</h4>
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body">
                                  <div class="row">
                                    <div class="col-12 col-md-6">
                                      <div class="form-group">
                                        <label > Amount</label>
                                        <input type="text" name="qAmount" class="form-control validate[required]" >
                                      </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                      <div class="form-group">
                                        <label>Payment mode</label>
                                        <select class="form-control validate[required]" name="pmode" id="outer">
                                          <option value="">Select..</option>
                                          <option value="0">Cash</option>
                                          <option value="1">Cheque</option>
                                          <option value="2">NEFT</option>
                                          <option value="3">Link</option>
                                          <option value="4">Paytm</option>
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    
                                    <div class="col-12 col-md-6">
                                      <div class="form-group" id="cash">
                                        <label ><span id="ttext">Received By</span> </label>
                                        <input type="text" name="tnumber" class="form-control validate[required]" >
                                      </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                      <div class="form-group">
                                        <label for=""> Date</label>
                                        <div class="input-group">
                                          <input type="text" autocomplete="off" class="form-control"  name="dates" >
                                          <div class="input-group-append">
                                            <button type="button"  class="input-group-text cursor-pointer" data-toggle="datepicker" data-target-name="dates" ><i class="fa fa-calendar"></i></button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    
                                    
                                  </div>
                                  
                                  <div class="row" id="bnks" style="display:none">
                                    <div class="col-12 col-md-6">
                                      <div class="form-group">
                                        <label for=""> Select Bank</label>
                                        <select name="bankName" class="form-control validate[required]">
<option value="" selected="">Select</option>
<option value="ICICI Bank">ICICI Bank</option>
<option value="YES Bank">YES Bank</option>
<option value="State Bank of India">State Bank of India</option>
<option value="Indusind Bank">Indusind Bank</option>
</select>
                                      </div>
                                    </div>
                                    
                                    
                                  </div>
                                  
                                  <div class="row"  id="pg" style="display:none">
                                    <div class="col-12 col-md-6">
                                      <div class="form-group">
                                        <label ><span id="ttext">Payment Gateway</span> </label>
                                         <select name="pg" class="form-control validate[required]">
<option value="" selected="">Select</option>
<option value="PayuBiz">PayuBiz</option>
<option value="Freecharge">Freecharge</option>
<option value="Ko Payments">Ko Payments</option>
<option value="Razorpay">Razorpay</option>
</select>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row"  id="paytm" style="display:none">
                                    <div class="col-12 col-md-6">
                                      <div class="form-group">
                                        <label ><span id="ttext">Paytm Holder Name</span> </label>
                                         <select name="paytm" class="form-control validate[required]">
<option value="" selected="">Select</option>
<option value="Gaurav Bansal">Gaurav Bansal</option>
<option value="Mayank Goel">Mayank Goel</option>
<option value="Company">Company</option>
</select>
                                      </div>
                                    </div>
                                  </div>
                                   <div class="row"></div>
                                  <script>
                  $(document).ready(function () {
    $('#outer').change(function(){
        if($('#outer').val() == '0') {
			$('#ttext').text('Received By'); 
			$('#bnks').hide();	
			$('#pg').hide();
			$('#paytm').hide();	
        } 
		else  if($('#outer').val() == '2') {
			$('#ttext').text('Transaction No');	
			$('#bnks').show();
			$('#pg').hide();
			$('#paytm').hide();		
        }   
		else  if($('#outer').val() == '3') {
			$('#ttext').text('Reference No');
			$('#bnks').hide();
			$('#pg').show();
			$('#paytm').hide();			
        } 
		else  if($('#outer').val() == '4') {
			$('#ttext').text('Reference No');
			$('#bnks').hide();
			$('#pg').hide();	
			$('#paytm').show();	
        }
		else {
			$('#ttext').text('Cheque No');
			$('#bnks').hide();
			$('#pg').hide();
			$('#paytm').hide();		
			
        } 
    });
});
                 </script> 
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                  <input type="hidden" name="serviceid" value="<?=$service?>" />
                                  <button type="submit" name="paymentpay" class="btn btn-primary" >Submit</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </form>
                        <!-- Genrate Order model --> 
                      </div>
                    </div>
                  </div>
                  

<div class="clearfix"></div>
                  
                  
                  
                </div>
              </div>
              <div class="tab-pane" id="AdditionalReq">
              <div class="p-3">
              <button type="button" class="btn btn-primary btn-sm mb-2" data-toggle="modal" data-target="#saleMark">Mark Sale </button>
              <div class="modal fade" id="saleMark">
                            <div class="modal-dialog modal-md">
                              <div class="modal-content"> 
                                <div class="modal-header">
                                  <h4 class="modal-title">Mark Sale</h4>
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                      <div class="row">
                                    <div class="col-12 col-md-12">
                                      <div class="form-group">
                              <label for="" class="text-left col-12"> Select Service</label>
                              <select name="serviceid" class="validate[required] form-control" data-errormessage-value-missing="Service is required!">
                              <option value="">-------select service------</option>
                              <?php 
 $service_query = $PDO->db_query("select * from #_product_manager where status='1'");
                while($service_rows = $PDO->db_fetch_array($service_query)){ ?>
                              <option value="<?=$service_rows['pid']?>">
                              <?=$service_rows['name']?>
                              </option>
                              <?php } ?>
                            </select>
                            </div>
                                    </div>
                                     
                                    
                                    <div class="col-12 col-md-12">
                                      <div class="form-group">
                                        <label >Price</label>
                                         <input type="number" name="serviceprice" class="validate[required] form-control" value="" >
                                      </div>
                                    </div>
                                  </div>
                              
                                  <div class="row">
                                    
                                  </div>
      
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                  <button type="submit" name="additionalReq" class="btn btn-sm btn-primary mr-5" >Submit </button>
                                </div>
                              </div>
                            </div>
                          </div>
              
                      
                      <div class="table-responsive saleextutive">
                    <table  class="table table-striped table-bordered sale  bg-white">
                    <thead>
                      <tr>
                        <th>Service Name</th>
                        <th>Price</th>
                      </tr>
                      </thead>
						<tbody>
                        <?php
						  $sale_query=$PDO->db_query("select * from #_crequirement where lid='".$_GET['uid']."'");
						  if($sale_query->rowCount()>0){
							  while($sales_row=$PDO->db_fetch_array($sale_query)){
								  
								  $totalcost+=$sales_row['serviceprice'];
						  ?>
                      <tr>
                          <td><?=$PDO->getsingleresult("select name from #_product_manager where pid='".$sales_row['serviceid']."'")?></td>
              
                          <td>Rs <?=$sales_row['serviceprice']?></td>
                      </tr>
                      <?php }?>
					   <tr>
                          <td>Total</td> <td>Rs <?=$totalcost?></td>
                      </tr>
					  <?php }else{?>
                      <tr>
                          <td colspan="2">No Result Found</td>
                      </tr>
                      <?php }?>
                      </tbody>
                    </table>
             
             
             </div>
                  </div>
                </div>
             
              <div class="tab-pane" id="WorkingTeam">
                <div class="p-3">
                  <div class="saleextutive mb-3">
                    <div class="table-responsive ">
                      <table  class="table table-striped table-bordered sale">
                        <tr>
                          <th>Sales Manager </th>
                          <th>Sales Executive </th>
                          <th>Operation Head</th>
                          <th>Operation Executive</th>
                        </tr>
                        <tr>
                          <td><?=$PDO->getsingleresult("select name from pms_admin_users where user_id='".$salesmid."'")?></td>
                          <td><?=$PDO->getsingleresult("select name from pms_admin_users where user_id='".$salesecutiveid."'")?></td>
                          <td><?=$PDO->getsingleresult("select name from pms_admin_users where user_id='".$ohid."'")?></td>
                          <td><?=$PDO->getsingleresult("select name from pms_admin_users where user_id='".$deid."'")?></td>
                        </tr>
                      </table>
                    </div>
                    
                  </div>
                  
                  
                </div>
              </div>
              <div class="tab-pane" id="Client">
                <div class="p-3">
                  <div class="table-responsive  saleextutive ">
                    <table  class="table table-striped table-bordered sale">
                      <tr>
                        <th>Client Name </th>
                        <th>Client Email</th>
                        <th>Client Number</th>
                        <th>Service request</th>
                      </tr>
                      <tr>
                        <td><?=$name?></td>
                        <td><?=$email?></td>
                        <td> +91-
                          <?=$phone?></td>
                        <td><?=$PDO->getSingleresult("select name from #_product_manager where pid='".addslashes($service)."'")?></td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="Cost">
             <div class="p-3">
                     <button type="button" class="btn btn-primary btn-sm mb-2" data-toggle="modal" data-target="#add_cost">Add Cost </button>
                          <div class="modal fade" id="add_cost">
                            <div class="modal-dialog modal-md">
                              <div class="modal-content"> 
                                <div class="modal-header">
                                  <h4 class="modal-title">Add Cost</h4>
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                      <div class="row">
                                    <div class="col-12 col-md-12">
                                      <div class="form-group">
                              <label>Select Cost Type </label>
                              <select class="validate[required] form-control" name="costid" >
                                <option value="">Select...</option>
                                <?php
								$costlistqry=$PDO->db_query("select * from #_cost_manager where status='1'");
								while($castlistrow=$PDO->db_fetch_array($costlistqry)){
								?>
                                <option value="<?=$castlistrow['pid']?>"><?=$castlistrow['name']?></option>
                                <?php }?>
                              </select>
                            </div>
                                    </div>
                                     
                                    
                                    <div class="col-12 col-md-12">
                                      <div class="form-group">
                                        <label >Price</label>
                                        <input type="text" class="form-control validate[required]" name="costprice" >
                                      </div>
                                    </div>
                                  </div>
                              
                                  <div class="row">
                                    
                                  </div>
      
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                  <button type="submit" name="costist" class="btn btn-primary" >Submit</button>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="table-responsive saleextutive">
                    <table  class="table table-striped table-bordered sale  bg-white">
                    <thead>
                      <tr>
                        <th>Service Name</th>
                        <th>Price</th>
                      </tr>
                      </thead>
						<tbody>
                        <?php
						  $cost_listquery=$PDO->db_query("select * from #_cost_list where lid='".$_GET['uid']."'");
						  if($cost_listquery->rowCount()>0){
							  while($cost_list_row=$PDO->db_fetch_array($cost_listquery)){
								  
								  $totalcost+=$cost_list_row['costprice'];
						  ?>
                      <tr>
                          <td><?=$PDO->getsingleresult("select name from #_cost_manager where pid='".$cost_list_row['costid']."'")?></td>
              
                          <td>Rs <?=$cost_list_row['costprice']?></td>
                      </tr>
                      <?php }?>
					   <tr>
                          <td>Total</td> <td>Rs <?=$totalcost?></td>
                      </tr>
					  <?php }else{?>
                      <tr>
                          <td colspan="2">No Result Found</td>
                      </tr>
                      <?php }?>
                      </tbody>
                    </table>
             
             
             </div>
             
             
             
              </div> 
              </div>
              <div class="tab-pane" id="Invoices">
                <div class="p-3">
                 <div class="user-wrp saleextutive mt-3 ">
            <div> 
            
             <a href="<?=SITE_PATH_ADM.'index.php?comp=invoice&mode=add&lid='.$pid?>"  class="btn btn-primary btn-sm mb-1">Genrate Invoice</a>
              
              <div class="table-responsive">
                <table  class="table table-striped table-bordered" >
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Invoice No</th>
                      <th>Date</th>
                      <th>Amount </th> 
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
       <?php $invoicequery =$PDO->db_query("select * from #_invoice where lid ='".$pid."'"); 
	   if($invoicequery->rowCount()>0){
		   $nums=1;
	          while($invoiceRow = $PDO->db_fetch_array($invoicequery)){ ?>
                    <tr>
                      <td><?=$nums?></td>
                       <td><?=$invoiceRow['inviceno']?></td>
         <td><?=date('d-m-Y',strtotime($invoiceRow['invicedate']))?></td>
           <td>Rs <?=$invoiceRow['hgrasstotal']?></td>
                      <td class="text-nowrap">
                      <a href="javascript:void(0);" class="openPopup" data-href="<?=SITE_PATH_ADM._MODS.'/invoice/pdf/'.$invoiceRow['filename'].'.pdf'?>" title="View Invoice"> <i class="fa fa-eye" aria-hidden="true"></i></a>
               <a href="<?=SITE_PATH_ADM._MODS.'/download.php?files='.SITE_PATH_ADM._MODS.'/invoice/pdf/'.$invoiceRow['filename'].'.pdf'?>" data-toggle="tooltip" title="Download"><i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i></a>
                      
                      
                      
                      </td>
                    </tr>
               <?php $nums++;}} else { echo '<tr><td colspan="5">No Record Found!</td></tr>';} ?>    
                    
                  </tbody>
                </table>
              </div>
            </div>
             <?php include("cuts/paging.inc.php");?> 
          </div>
          
                </div>
                </div>
              <div class="tab-pane" id="WorkDetails">
                <div class="p-3">
                <?php $deptType=$PDO->getsingleresult("select dpid from #_product_manager where pid='".addslashes($service)."'");
				if($deptType==4){
				 ?>
                <div class="row">
                <div class="col">
<a href="javascript:void(0)" onclick="sendemailrs('basicDoc','<?=$uid?>','Basic Doc','1');" class="btn btn-primary btn-block mb-1" role="button">Basic Doc </a> 
</div>  <div class="col">
<a href="javascript:void(0)" onclick="sendemailrs('pendingDoc','<?=$uid?>','Pending Doc','2');" class="btn btn-primary btn-block mb-1" role="button">Pending Doc </a> </div>
<div class="col"> 
<a href="javascript:void(0)"  onclick="sendemailrs('fileSent','<?=$uid?>','File Sent','3');" class="btn btn-primary btn-block mb-1" role="button">File Sent </a> 
</div>
<div class="col">
<a href="javascript:void(0)" onclick="sendemailrs('fileRecived','<?=$uid?>','File Received','4');"  class="btn btn-primary btn-block mb-1" role="button">File Received </a> 
</div>
</div>
                <div class="row mt-2">
<div class="col">
<a href="javascript:void(0)" onclick="sendemailrs('formFilling','<?=$uid?>','Form Filling','5');" class="btn btn-primary btn-block mb-1" role="button"> Form Filling </a> 

</div><div class="col">
<a href="javascript:void(0)" onclick="sendemailrs('balancePayment','<?=$uid?>','Balance Payment','6');" class="btn btn-primary btn-block mb-1" role="button">Balance Payment</a> </div><div class="col">
<a href="javascript:void(0)"  onclick="sendemailrs('coi','<?=$uid?>','COI','7');" class="btn btn-primary btn-block mb-1" role="button">COI </a>  
</div><div class="col">
<a href="javascript:void(0)" onclick="sendemailrs('dscDelivered','<?=$uid?>','DSC Delivered','8');" class="btn btn-primary btn-block mb-1" role="button"> DSC  Delivered</a> 
                  </div></div> 
                 <?php }else if($deptType==5 || $deptType==7){?> <div class="row">
                <div class="col">
<a href="javascript:void(0)" onclick="sendemailrs('basicInfo','<?=$uid?>','Basic Info','9');" class="btn btn-primary btn-block mb-1" role="button">Basic Info </a> 
</div>  <div class="col">
<a href="javascript:void(0)" onclick="sendemailrs('applicationDrafted','<?=$uid?>','Application Drafted','10');" class="btn btn-primary btn-block mb-1" role="button">Application Drafted </a> </div>
<div class="col"> 
<a href="javascript:void(0)"  onclick="sendemailrs('approvalonDraft','<?=$uid?>','Approval on Draft','11');" class="btn btn-primary btn-block mb-1" role="button">Approval on Draft </a> 
</div>
<div class="col">
<a href="javascript:void(0)" onclick="sendemailrs('applicationSubmitted','<?=$uid?>','Application Submitted','12');"  class="btn btn-primary btn-block mb-1" role="button">Application Submitted </a> 
</div>
</div> <?php } 
    else if($deptType==6){?> <div class="row">
                <div class="col">
<a href="javascript:void(0)" onclick="sendemailrs('taxbasicDoc','<?=$uid?>','Basic Doc','13');" class="btn btn-primary btn-block mb-1" role="button">Basic Doc </a> 
</div>  <div class="col">
<a href="javascript:void(0)" onclick="sendemailrs('taxPendingDoc','<?=$uid?>','Pending Doc','14');" class="btn btn-primary btn-block mb-1" role="button">Pending Doc </a> </div>
<div class="col"> 
<a href="javascript:void(0)"  onclick="sendemailrs('formSubmitted','<?=$uid?>','Form Submitted','15');" class="btn btn-primary btn-block mb-1" role="button">Form Submitted </a> 
</div>
<div class="col">
<a href="javascript:void(0)" onclick="sendemailrs('workComplete','<?=$uid?>','Work Complete','16');"  class="btn btn-primary btn-block mb-1" role="button">Work Complete </a> 
</div>
</div> <?php } ?>   


                  
                  <hr>
                 
                  </div>
                  <style>
                  .docu td, .table-bordered th {
    border: 1px solid #dee2e6;
    height: 30px;
    padding: 0 0 0 5px;
}.docu tr:nth-of-type(odd) {
    background-color: rgb(244, 244, 244) !important;
}
                  </style>
                  <table  class="table table-striped table-bordered sale">
                   <tr>
                        <th colspan="2">Comments Are - </th>
                      </tr>
                    <?php  $comment_ry =$PDO->db_query("select * from #_comment where lid ='".$uid."' order by pid DESC"); 
					if($comment_ry->rowCount()>0){
	                       while($comment_rs = $PDO->db_fetch_array($comment_ry)){ ?>
                      <tr>
                        <th><?=$PDO->getsingleresult("select name from pms_admin_users where user_id='".$comment_rs['userid']."'")?> <small class="pull-right font-weight-normal "> <i class="fa fa-clock-o"></i> Comment on <?=date("F j, Y, g:i a",strtotime($comment_rs['created_on']))?></small> </th>
                      </tr>
                      <tr>
                        <td class="text-justify"><?=$comment_rs['comments']?></td>
                      </tr>
                      
                      <?php }} ?>
                    </table>
                    
                    <table  class="table table-striped table-bordered docu">
                    <?php 
					if($upload!=''){ ?>
                      <tr>
                        <th colspan="2">Documents Are - </th>
                      </tr>
                     <?php
                $allfiles = explode(":", $upload);
                foreach($allfiles as $fn){?>
                  <tr>
                        <td class="text-justify"><?=preg_replace('/\\.[^.\\s]{3,4}$/', '', $fn)?></td>
                        <td>
                <a href="<?=SITE_PATH.'uploaded_files/clientdetail/'.$fn?>" title="Please click on for view"  target="_blank"><span class="btn btn-link mr-1"><i class="fa fa-eye"></i></span></a>
                
                  <a href="<?=SITE_PATH._MODS.'/download.php?files='.SITE_PATH.'uploaded_files/clientdetail/'.$fn?>" title="Please click on for view"  target="_blank"><span class="btn btn-link"><i class="fa fa-download"></i></span></a>
</td></tr>
                <?php
                }
                ?></td>
                      </tr>
                      
                      <?php } ?>
                    </table>
                   <form name="projectstatus" method="post" enctype="multipart/form-data" action="">
                  <div class="row">
                    <div class="col-12 col-md-6">
                      <div class="form-group">
                        <label> Upload Document <small>(Select multiple files)</small></label>
                 <input name="upload[]" class="form-control" type="file" multiple />
                <input type="hidden" name="allfl" value="<?=$orderRS['upload']?>" />
                      </div>
                    </div>
                    <div class="col-12 col-md-6">
                      <div class="form-group">
                        <label>Post a comment</label>
                      <textarea name="comments" class="form-control"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                  <!--  <div class="col-12 col-md-6">
                      <div class="form-group">
                        <label>Processing Status</label>
                        <select name="processstatus"  class="validate[required] form-control" data-errormessage-value-missing="Status is required!">
                <option  value="">-------Select Work Status------</option>
               <?php 
 $sm_query = $PDO->db_query("select * from #_work_process where status='1'");
                while($sm_rows = $PDO->db_fetch_array($sm_query)){ ?>
             <option value="<?=$sm_rows['pid']?>" <?=($sm_rows['pid']==$processstatus)?'selected="selected"':''?>><?=$sm_rows['name']?></option>
                                <?php } ?>
                
                </select>
                      </div>
                    </div>
                    <div class="col-12 col-md-6">
                      <div class="form-group">
                        <label>Project Status</label>
                        <select name="pstatus"  class="validate[required] form-control" data-errormessage-value-missing="Project Status is required!">
                <option  value="">-------Select Status------</option>
                <option value="0" <?=(isset($orderRS['pstatus']) && $orderRS['pstatus']==0)?'selected="selected"':''?>  >Open</option>
                <option value="1" <?=($orderRS['pstatus']==1)?'selected="selected"':''?>  >Close</option>
                </select>
                      </div>
                    </div>-->
                    <div class="col-12 col-md-12 justify-content-end d-flex ">
                    <input type="hidden" name="projectid" value="<?=$uid?>" />
                      <button name="projectStatus" type="submit" class="btn btn-primary ">Submit</button>
                    </div>
                  </div>
                  </form>
                  
                </div>
              
            </div>
            <div class="row"> 
              
              <!-- The Modal -->
              
              
              <div class="saleextutive activitytable  table-responsive mt-3">
                <div class="col-md-12 ">
                  <table id="example" class="table table-striped table-bordered " >
                    <thead>
                      <tr>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 

 $act_query = $PDO->db_query("select * from #_pms_activity where lid='".$uid."' order by pid DESC");
                while($act_rows = $PDO->db_fetch_array($act_query)){

					if($act_rows['comment']!=''){

						$cls='collapse';

						$collsps='collapsed';

						$area='aria-expanded="false"';

						$st='style="display:block;"';

						}

					

					 ?>
                      <tr class="card-header <?=$collsps?>"  data-toggle="<?=$cls?>" href="#details<?=$act_rows['pid']?>" <?=$area?>> <a class="card-title">
                        <td><?=date('d M Y',strtotime($act_rows['created_on']))?></td>
                        <td><?=$PDO->getsingleresult("select name from #_activites_score where pid='".$act_rows['type']."'")?>
                        -  <?=$PDO->getsingleresult("select name from pms_admin_users where user_id='".$act_rows['sentBy']."'").' <small>'.$ADMIN->user_type($PDO->getsingleresult("select user_type from pms_admin_users where user_id='".$act_rows['sentBy']."'")).'</small>'?>
                        
                          <?=$act_rows['type']=='62'?$PDO->getsingleresult("select name from pms_admin_users where user_id='".$act_rows['sentto']."'").' <small>'.$ADMIN->user_type($PDO->getsingleresult("select user_type from pms_admin_users where user_id='".$act_rows['sentto']."'")).'</small>':''?></td>
                        <td><i <?=$st?> style="display:none;" class="fa fa-plus"></i></td>
                        </a> </tr>
                      <tr id="details<?=$act_rows['pid']?>" class="<?=$cls?>">
                        <td colspan="3"><?php if($act_rows['status']==2){?>
                          <table>
                            <tr style="background-color:rgb(255, 255, 255);">
                              <td>Followup Date</td>
                              <td><?=$act_rows['dates'].'-'.$act_rows['times']?></td>
                            </tr>
                            <tr>
                              <td colspan="3">
							   <?=$act_rows['subject']==''?'':'<strong>'.$act_rows['subject'].'</strong><br>';?>
							  <?=$act_rows['comment']?></td>
                            </tr>
                          </table>
                          <?php }else if($act_rows['status']==28){
							  echo 'https://www.trademarkbazaar.com/cart/pay/'.$RW->encrypt_decrypt('encrypt', $act_rows['cpid']);
							  }else{ ?>
                           <?=$act_rows['subject']==''?'':'<strong>'.$act_rows['subject'].'</strong><br>';?>
                          <?php echo $act_rows['comment']; }?></td>
                      </tr>
                      <?php } ?>
                      <tr>
                        <td><?=date('d M Y',strtotime($row['created_on']))?></td>
                        <td>Lead into Funnel </td>
                        <td>&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <script>

   $(document).ready(function() {

    $('#example').DataTable( {

        "lengthMenu": [[7,10, 25, 50, -1], [7,10, 25, 50, "All"]]

    } );

} );

   </script> 
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
</section>
<form name="paynow" action="" method="post"  class="form-horizontal"  enctype="multipart/form-data">
  <div class="modal fade" id="sendmail">
    <div class="modal-dialog modal-lg">
      <div class="modal-content"> 
        
        <!-- Modal Header -->
        
        <div class="modal-header">
          <h4 class="modal-title" id="stpname">Basic doc</h4>
          <button type="button" onclick="clearBox('cnt')" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        
        <div class="modal-body" id="cnt"> </div>
        
        <!-- Modal footer -->
        
        <div class="modal-footer">
          <button type="submit" name="steps" class="btn btn-info">Send</button>
          <button type="button" class="btn btn-danger" onclick="clearBox('cnt')" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</form>

<script src='js/timepicker.js'></script>
<link rel="stylesheet" href="css/timepicker.css">
<script>
$(function() {
    $('body').on('focus', ".datepickerfrom, .datepickerto", function() {

            $('.datepickerfrom').datepicker({
               	minDate:0,
                dateFormat: 'yy-mm-dd',
                onClose: function(selectedDate) {
                    var theOtherDate = $(this).closest('.datepickerrng').find('.datepickerto');
                    $(theOtherDate).datepicker("option", "minDate", selectedDate);
                }
            });
            $('.datepickerto').datepicker({
                minDate: 0,
                dateFormat: 'yy-mm-dd',
                onClose: function(selectedDate) {
                    var fromdate = $(this).closest('.datepickerrng').find('.datepickerfrom');
					var todate = $(this).closest('.datepickerrng').find('.datepickerto');
					var nit = $(this).closest('body').find('#dNight');
					var ddays = $(this).closest('body').find('#ddays');
                    $(fromdate).datepicker("option", "maxDate", selectedDate);
					datepicked(fromdate,todate,nit,ddays)
                }
            });


    })
});
function datepicked(from,to,nights,days) {
     var fromDate = from.datepicker('getDate')
 
        var toDate = to.datepicker('getDate')
 
        if (toDate && fromDate) {
        var difference = 0;
            var oneDay = 1000*60*60*24; 
            var difference = Math.ceil((toDate.getTime() - fromDate.getTime()) / oneDay); 
			var diffDays = Math.floor((toDate.getTime() - fromDate.getTime()) / oneDay);
            nights.val(difference);
			days.val(diffDays);
            } 
}
  </script>
  
<script>
jQuery(document).ready(function(){
			$('.selectpiker').selectpicker({liveSearch: true});
			$('body').on('click','.removebtn', function(){
				$(this).parents('.addnewinput').addClass('ada').remove();
				})
		});


$('.time').timepicker({

	controlType: 'select',

	timeFormat: 'hh:mm tt'

});

$('.dates').datepicker( {minDate: 0,dateFormat: 'yy-mm-dd'});

</script>
<style>

.ui-datepicker{z-index:9999999 !important;}

h4.head>select {font-size: .7rem;}

</style>
<script>

  $('[data-toggle=datepicker]').each(function() {

  var target = $(this).data('target-name');

  var t = $('input[name=' + target + ']');

  t.datepicker({

    dateFormat: 'yy-mm-dd',

	changeMonth: true,

    changeYear: true ,

	  //  yearRange: "2005:2015"

	  yearRange: "-100:+0", // last hundred years

  });

  $(this).on("click", function() {

    t.datepicker("show");

  });

});

function sendemailrs(step,projectid,stepname,processStatus){

 $("#stpname").text(stepname);

	$.ajax({



			url: '<?=SITE_PATH_ADM._MODS.'/leads/'?>send.php',



			type: 'POST',



			data: {step:step,projectid:projectid,processStatus:processStatus},



			success:function(data){



				console.log(data);



	     

          $("#cnt").html(data);

    $('#sendmail').modal({backdrop: 'static', keyboard: false});



			}



		});



	}

function clearBox(elementID)

{  CKEDITOR.remove(CKEDITOR.instances['content']);



    document.getElementById(elementID).innerHTML = "";

}

function setservice(ser){



	if(!ser) {

        alert('Please select currect option!');

        return false;

    }

    else {

        //return confirm('Do you really want to submit the form?');

		var r = confirm("Do you realy want to change!");

if (r == true) {

   document.forms["aforms"].submit();

} else {

    //alert("You pressed Cancel!");

}

		

	}

	}

function showhidesr(sl){

	$('#'+sl).slideToggle();

	}
$(document).ready(function(e) {
$('.openPopup').on('click',function(){
        var dataURL = $(this).attr('data-href');
        $('#treatmentpdf .modal-body object').attr('data',dataURL);
		$('#treatmentpdf .modal-body #dnlinks').attr('href',dataURL);
		$('#treatmentpdf').modal({show:true});
    }); 
$('.sendptreatmets').on('click',function(){
        var dataURL = $(this).attr('data-href');
        $('#treatmentpdfsendmail .modal-body').load(dataURL,function(){
        $('#treatmentpdfsendmail').modal({show:true});
		return false;
    });
    });

});
  </script> 
<div class="modal fade" id="treatmentpdf" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
<object data="" type="application/pdf" width="100%" height="500px">
   <p>This browser does not support PDFs. Please download the PDF to view it: <a target="_blank" href="" id="dnlinks">Download PDF</a>.</p>
</object>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="treatmentpdfsendmail" role="dialog">
    <div class="modal-dialog modal-lg">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
			<object data="" type="application/pdf" width="100%" height="500px">
   <p>This browser does not support PDFs. Please download the PDF to view it: <a target="_blank" href="" id="dnlinks">Download PDF</a>.</p>
</object>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
      
    </div>
</div>
<style>
.addcontainer:first-child [data-role="remove"]{display:none;}
.addcontainer [data-role="add"]{display:none;}
.addcontainer:first-child [data-role="add"]{display:inline-block;}

#treatmentpdfsendmail .modal-body .header, #treatmentpdfsendmail .modal-body .footer, #treatmentpdfsendmail .modal-body .mainnav, #treatmentpdfsendmail .modal-body .brdbg{display:none;}
</style>
<script>
$(function() {
    $(document).on('click', '[data-role="dynamic-fields"] > .addcontainer [data-role="remove"]', function(e) {
            e.preventDefault();
            $(this).closest('.addcontainer').remove();
        }
    );
    $(document).on('click', '[data-role="dynamic-fields"] > .addcontainer [data-role="add"]', function(e) {
            e.preventDefault();
            var container = $(this).closest('[data-role="dynamic-fields"]');
            new_field_group = container.children().filter('.addcontainer:first-child').clone();
         // new_field_group.find('label').html('Select Service');
		   new_field_group.find('input, select, textarea').each(function(){
                $(this).val('');
            });
            container.append(new_field_group);
        }
    );
});
    </script>