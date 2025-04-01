<?php 
include(FS_ADMIN._MODS."/leads/leads.inc.php");
$PAGS = new Pages();
if($action)
{  
  if($uid >0  || !empty($arr_ids))
  {
	switch($action)
	{
		  case "del":
						 $PAGS->delete($uid);
						 $ADMIN->sessset('Record has been deleted', 'e'); 
						 break;
						 
		  case "Delete":
						 $PAGS->delete($arr_ids);
						 $ADMIN->sessset(count($arr_ids).' Item(s) Deleted', 'e');
						 break;
			case "Assign":
			
						 $PAGS->assign($arr_ids,$salesecutiveid,'salesecutiveid');
						 $ADMIN->sessset(count($arr_ids).' Item(s) Assigned to '.$PDO->getSingleresult("select name from pms_admin_users where user_id='".$salesecutiveid."'"), 's');
						 break;	
			case "Assigndeid":
			
						 $PAGS->assign($arr_ids,$deid,'deid');
						 $ADMIN->sessset(count($arr_ids).' Item(s) Assigned to '.$PDO->getSingleresult("select name from pms_admin_users where user_id='".$deid."'"), 's');
						 break;				 		 
						 
		  case "Active":
						 $PAGS->status($arr_ids,1);
						 $ADMIN->sessset(count($arr_ids).' Item(s) Active', 's');
						 break;
						 
		  case "Inactive":
						 $PAGS->status($arr_ids,0);
						 $ADMIN->sessset(count($arr_ids).' Item(s) Inactive', 's');
						 break;
					 
		  
		  default:
	}
    $RW->redir($ADMIN->iurl($comp), true);
  }
}
if($RW->is_post_back())
{
	if(isset($_POST['bulkdown'])){	
	
  $filename=$_FILES["file"]["tmp_name"];
    if($_FILES["file"]["size"] > 0)
    {
        $file = fopen($filename, "r");
		
        fgetcsv($file);
		
		//print_r(fgetcsv($file));
		//echo $numcols = count($file); exit;
		
		
        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
        {   
		$created_on=date('Y-m-d H:i:s');
		$status=6;
			 $inquery = "INSERT INTO #_leads (name, email, phone,address,source,service,created_on,status) values ('".addslashes($getData[0])."','".addslashes($getData[1])."','".addslashes($getData[2])."','".addslashes($getData[3])."','20','59','$created_on','$status')"; 
$ins=$PDO->db_query($inquery); 
$insertid=$GLOBALS['dbcon']->lastInsertId();
$rwi='TMI'.$insertid;

		$jj=1;
		$myarr=array();
		$myarr2=array();
		//echo '<pre>';
			for($i=4;$i<=count($getData); $i++){
				  $myarr[]=$getData[$i];
				  if($jj%3==0){
					echo '<br>';
					array_push($myarr2,$myarr);
					$myarr=array();
					}	
				 
				 
				  
				$jj++;}
			//print_r($myarr2);
			foreach($myarr2 as $dr){
				$data['dname']=$dr[0];
				$data['demail']=$dr[1];
				$data['dphone']=$dr[2];
				
				if (!empty(array_filter($data))) {
					
				$data['lid']=$insertid;
				$PDO->sqlquery("rs","directorDetails",$data);
				$data=array();
				}}
			
$PDO->db_query('update #_leads set rwi="'.$rwi.'" where pid="'.$insertid.'"'); 
      
        }
            $ADMIN->sessset('CSV File has been successfully Imported.', 'S'); 
          $RW->redir($ADMIN->iurl($comp.(($start)?'&start='.$start:'').(($department)?'&department='.$department:'')), true);
           fclose($file);
    }

 }
	
	if(isset($_POST['escalate'])){
	$_POST['leadid']=str_replace('TMI','',$_POST['leadid']);
	$ps['sentBy']=$_SESSION["AMD"][0];
	$ps['name']=$_POST['name'];
	$ps['email']=$_POST['email'];
	$ps['phone']=$_POST['phone'];
	$ps['lid']=$_POST['leadid'];
	$ps['comment']=$_POST['comment'];
	$ps['status']=44;
	$ps['type']='32';
	$PDO->sqlquery("rs",'pms_activity',$ps);
	$lead['esclate']=1;
	
	$PDO->sqlquery("rs",'leads',$lead,'pid',$_POST['leadid']);
	
	$mailbody='<table width="100%" cellpadding="0" cellspacing="0"><tr><td><table style="margin:auto; width:600px; font-size:16px; line-height:24px; font-family:Verdana, Geneva, sans-serif" cellpadding="0" cellspacing="0"><tr><td><table width="100%" cellpadding="5" cellspacing="0"><tr><td><a href="https://www.trademarkbazaar.com"><img src="https://trademarkbazaar.com/images/emailer/tblogo.png" width="109" height="38" alt="trademarkbazaar.com" /></a></td><td align="right"><a style="margin:0 5px;" href="https://www.facebook.com/trademarkbazaar/"><img style="width:30px; height:27px;" src="https://trademarkbazaar.com/images/emailer/face.png" alt="trademarkbazaar.com" /></a>
<a style="margin:0 5px;" href="https://twitter.com/TrademarkBazaar"><img style="width:30px; height:27px;" src="https://trademarkbazaar.com/images/emailer/twitter.png" alt="trademarkbazaar.com" /></a>
<a style="margin:0 5px;" href="https://www.linkedin.com/in/trademark-bazaar-075300144/"><img style="width:30px; height:27px;" src="https://trademarkbazaar.com/images/emailer/link.png" alt="trademarkbazaar.com" /></a></td></tr></table></td></tr><tr><td><table width="100%" cellpadding="15" cellspacing="0"><tr><td style="border:1px solid #ccc;">
	<table width="100%" cellpadding="5" cellspacing="0">
	<tr><td style="padding:10px 20px;"><p style="padding-left:10px; margin:0">Dear Gaurav,</p></td></tr>
	
	<tr><td><table width="100%" cellpadding="0" cellspacing="0"><tr><td style="padding:10px 20px;"><p style="margin:10px 0; text-align:justify; line-height:24px;">Ticket no TMI'.$_POST['leadid'].' has been Escalation. Details are given below;</p></td></tr><tr><td style="padding:10px 20px;"><p style="margin:10px 0; text-align:justify; line-height:24px; color:#00293c;"><strong>Ticket Number: TMI'.$_POST['leadid'].'</strong></p></td></tr>
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
		
		
		$subject='Escalation of Ticket Number TMI'.$_POST['leadid'].' | TrademarkBazaar';

		$mails=mail($to, $subject, $mailbody, $headers, '-fsupport@trademarkbazaar.com');
	
  $ADMIN->sessset('Record has been saved!', 's');
$RW->redir($ADMIN->iurl($comp.(($start)?'&start='.$start:'').(($subpage_id)?'&subpage_id='.$subpage_id:'')), true);
}
if(isset($_POST['qmsg'])){
	//print_r($_POST);
		$query =$PDO->db_query("select * from #_leads where pid ='".str_replace('TMI','',$_POST['leadid'])."' "); 
	$row = $PDO->db_fetch_array($query);
	@extract($row);
	$ps['comment']=$_POST['comment'];
	$ps['lid']=str_replace('TMI','',$_POST['leadid']);
	$ps['sentBy']=$_SESSION["AMD"][0];
	$ps['status']=9;
	$ps['type']=34;
	$PDO->sqlquery("rs",'activity',$ps);
	
	$msg =$_POST['comment'];
$to =$_POST['phone'];
$msgss=mysql_real_escape_string($msg);
$url = 'http://www.smsgatewaycenter.com/library/send_sms_2.php?UserName=regwala&Password=8gVhgnek&Type=Bulk&To='.urlencode($to).'&Mask=RGWALA&Message='.urlencode($msg);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_NOBODY, TRUE); // remove body 
		$response = curl_exec($ch);
		curl_close($ch);
	
  $ADMIN->sessset('Record has been saved!', 's');
$RW->redir($ADMIN->iurl($comp.(($start)?'&start='.$start:'').(($subpage_id)?'&subpage_id='.$subpage_id:'')), true); 
}
	
	
	/*start send Porposal */
	if(isset($_POST['psend'])){
	$_POST['leadid']=str_replace('TMI','',$_POST['leadid']);
	//print_r($_POST); exit;
	$ps['lid']=$_POST['leadid'];
	$ps['sentBy']=$_SESSION["AMD"][0];
	$ps['status']=4;
	$ps['serviceid']=$_POST['service'];
	$ps['name']=$_POST['name'];
	$ps['email']=$_POST['email'];
	$ps['phone']=$_POST['phone'];
	
	$PDO->sqlquery("rs",'proposalsent',$ps);
	$ps['lid']=$_POST['leadid'];
	$ps['sentBy']=$_SESSION["AMD"][0];
	$ps['status']=4;
	$ps['type']='20';
	$PDO->sqlquery("rs",'pms_activity',$ps);
		
	$lead['status']=4;
	$PDO->sqlquery("rs",'leads',$lead,'pid',$_POST['leadid']);
  
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

 $RW->redir($ADMIN->iurl($comp.(($start)?'&start='.$start:'').(($subpage_id)?'&subpage_id='.$subpage_id:'')), true);   
	
	
	}
/*end send Porposal */
/*start  send payment link */
if(isset($_POST['paylink'])){

$ps['lid']=str_replace('TMI','',$_POST['leadid']);	

$ps['status']=5;

$ps['sentBy']=$_SESSION["AMD"][0];

$PDO->sqlquery("rs",'plinksent',$ps);

$ps['lid']=str_replace('TMI','',$_POST['leadid']);

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
		
$PDO->sqlquery("rs",'leads',$st,'pid',str_replace('TMI','',$_POST['leadid']));	
	
$ADMIN->sessset('Payment link has been sent to '.$_POST['name'], 's');

$RW->redir($ADMIN->iurl($comp.(($start)?'&start='.$start:'').(($department)?'&department='.$department:'')), true);

}


}
if($_SESSION["AMD"][3]=='5'){
 $extra = " and  salesecutiveid='".$_SESSION["AMD"][0]."'";  
}

if($_SESSION["AMD"][3]=='2' && $_SESSION["AMD"][5]==4){
			  $serviceids = $PAGS->getdeptwiseleads("'4','7'");	
 $extra = " and  payment='1'  and service IN($serviceids)";  
}
if($_SESSION["AMD"][3]=='4' && $_SESSION["AMD"][5]==4){
	$serviceids = $PAGS->getdeptwiseleads("'4','7'");	
 $extra = " and deid='".$_SESSION["AMD"][0]."' and  payment='1' and service IN($serviceids)";  
}
if($_SESSION["AMD"][3]=='2' && $_SESSION["AMD"][5]==6){
	$serviceids = $PAGS->getdeptwiseleads("'6','7'");	 
 $extra = " and  payment='1' and service IN($serviceids)";  
}
if($_SESSION["AMD"][3]=='4' && $_SESSION["AMD"][5]==6){
	 $serviceids = $PAGS->getdeptwiseleads("'6','7'");	
  $extra = " and deid='".$_SESSION["AMD"][0]."' and  payment='1' and service IN($serviceids)";  
}
if($_SESSION["AMD"][3]=='2' && $_SESSION["AMD"][5]==5){
	$serviceids = $PAGS->getdeptwiseleads("'5'");	 
 $extra = " and  payment='1' and service IN($serviceids)";  
}
if($_SESSION["AMD"][3]=='4' && $_SESSION["AMD"][5]==5){
	$serviceids = $PAGS->getdeptwiseleads("'5'");	
  $extra = " and deid='".$_SESSION["AMD"][0]."' and  payment='1' and service IN($serviceids)";  
}
/*if($_SESSION["AMD"][5]==8 && $_SESSION["AMD"][3]!='5'){
	  $compRy =$PDO->db_query("select * from #_product_manager where status=1 and steam=8"); 
	         $compRs = $PDO->db_fetch_all($compRy,PDO::FETCH_COLUMN);
			  $ids = implode(',',$compRs); 
			  
			  $sourceRy =$PDO->db_query("select * from #_lead_source where status=1 and steam=8"); 
	         $sourceRs = $PDO->db_fetch_all($sourceRy,PDO::FETCH_COLUMN);
			  $sourceids = implode(',',$sourceRs); 
			  
 $extra1 = " and (service IN($ids) OR source IN($sourceids))";  
}
if($_SESSION["AMD"][5]==2 && $_SESSION["AMD"][3]!='5'){
	  $compRy =$PDO->db_query("select * from #_product_manager where status=1 and steam=2"); 
	         $compRs = $PDO->db_fetch_all($compRy,PDO::FETCH_COLUMN);
			  $ids = implode(',',$compRs);
			    $sourceRy =$PDO->db_query("select * from #_lead_source where status=1 and steam=2"); 
	         $sourceRs = $PDO->db_fetch_all($sourceRy,PDO::FETCH_COLUMN);
			  $sourceids = implode(',',$sourceRs);
			  
 $extra1 = " and service IN($ids) and source IN($sourceids)";  
}*/
if($leadOwner){
 $extra = " and salesecutiveid='".$leadOwner."'"; 
	}
if($leadSource){
if($leadSource==13){
		 $extra = " and utm_source='".$leadSource."'"; 
		}else {
 $extra = " and source='".$leadSource."'"; }
if($_SESSION["AMD"][3]=='5'){
 $extra = " and  salesecutiveid='".$_SESSION["AMD"][0]."' and source='".$leadSource."'";  
}

if($_SESSION["AMD"][3]=='2' && $_SESSION["AMD"][5]==4){
			  $serviceids = $PAGS->getdeptwiseleads("'4','7'");	
 $extra = " and  payment='1'  and service IN($serviceids) and source='".$leadSource."'";  
}
if($_SESSION["AMD"][3]=='4' && $_SESSION["AMD"][5]==4){
	$serviceids = $PAGS->getdeptwiseleads("'4','7'");	
 $extra = " and deid='".$_SESSION["AMD"][0]."' and  payment='1' and service IN($serviceids) and source='".$leadSource."'";  
}
if($_SESSION["AMD"][3]=='2' && $_SESSION["AMD"][5]==6){
	$serviceids = $PAGS->getdeptwiseleads("'6','7'");	 
 $extra = " and  payment='1' and service IN($serviceids) and source='".$leadSource."'";  
}
if($_SESSION["AMD"][3]=='4' && $_SESSION["AMD"][5]==6){
	$serviceids = $PAGS->getdeptwiseleads("'6','7'");	
 $extra = " and deid='".$_SESSION["AMD"][0]."' and  payment='1' and service IN($serviceids) and source='".$leadSource."'";  
}
if($_SESSION["AMD"][3]=='2' && $_SESSION["AMD"][5]==5){
	$serviceids = $PAGS->getdeptwiseleads("'5'");	 
 $extra = " and  payment='1' and service IN($serviceids)  and source='".$leadSource."'";  
}
if($_SESSION["AMD"][3]=='4' && $_SESSION["AMD"][5]==5){
	$serviceids = $PAGS->getdeptwiseleads("'5'");	
  $extra = " and deid='".$_SESSION["AMD"][0]."' and  payment='1' and service IN($serviceids)  and source='".$leadSource."'";  
}

	}
	
if($duration){
	if($duration=='Today'){
		$dates=" and date(created_on)>DATE_SUB(NOW(), INTERVAL 1 DAY)"; 
		}
		 else if($duration=='Yesterday'){
		$dates='and date(created_on)="'.date("Y-m-d",strtotime("-1 days")).'"';
		} 
		else if($duration=='This week'){
		$dates=" and date(created_on)>DATE_SUB(NOW(), INTERVAL 1 WEEK)"; 
		}
		else if($duration=='This Month'){
		$dates=" and date(created_on)>DATE_SUB(NOW(), INTERVAL 1 MONTH)"; 
		}
		
		else if($duration=='This Year'){
		$dates=" and date(created_on)>DATE_SUB(NOW(), INTERVAL 1 YEAR)"; 
		}
		else if($duration=='Last 7 days'){
		$dates=" and date(created_on)>DATE_SUB(NOW(), INTERVAL 7 DAY)"; 
		}
		
		else if($duration=='Last 30 days'){
		$dates=" and date(created_on)>DATE_SUB(NOW(), INTERVAL 30 DAY)"; 
		}
		else if($duration=='Last month'){
		$dates=" and YEAR(created_on) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(created_on) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)"; 
		}
		
 $extra = $dates;

if($_SESSION["AMD"][3]=='5'){
 $extra = " and  salesecutiveid='".$_SESSION["AMD"][0]."' $dates ";  
}
	}
if($work_duration){
	if($work_duration=='Today'){
		$dates=" and date(paymentDate)>DATE_SUB(NOW(), INTERVAL 1 DAY)"; 
		}
		 else if($work_duration=='Yesterday'){
		$dates='and date(paymentDate)="'.date("Y-m-d",strtotime("-1 days")).'"';
		} 
		else if($work_duration=='This week'){
		$dates=" and date(paymentDate)>DATE_SUB(NOW(), INTERVAL 1 WEEK)"; 
		}
		else if($work_duration=='This Month'){
		$dates=" and date(paymentDate)>DATE_SUB(NOW(), INTERVAL 1 MONTH)"; 
		}
		
		else if($work_duration=='This Year'){
		$dates=" and date(paymentDate)>DATE_SUB(NOW(), INTERVAL 1 YEAR)"; 
		}
		else if($work_duration=='Last 7 days'){
		$dates=" and date(paymentDate)>DATE_SUB(NOW(), INTERVAL 7 DAY)"; 
		}
		
		else if($work_duration=='Last 30 days'){
		$dates=" and date(paymentDate)>DATE_SUB(NOW(), INTERVAL 30 DAY)"; 
		}
		else if($work_duration=='Last month'){
		$dates=" and YEAR(paymentDate) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(paymentDate) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)"; 
		}
		
 $extra = $dates;
 
if($_SESSION["AMD"][3]=='5'){
 $extra = " and  salesecutiveid='".$_SESSION["AMD"][0]."' $dates ";  
}
if($_SESSION["AMD"][3]=='2' && $_SESSION["AMD"][5]==4){
			  $serviceids = $PAGS->getdeptwiseleads("'4','7'");	
 $extra = " and  payment='1'  and service IN($serviceids) $dates";  
}
if($_SESSION["AMD"][3]=='4' && $_SESSION["AMD"][5]==4){
	$serviceids = $PAGS->getdeptwiseleads("'4','7'");	
 $extra = " and deid='".$_SESSION["AMD"][0]."' and  payment='1' and service IN($serviceids) $dates";  
}
if($_SESSION["AMD"][3]=='2' && $_SESSION["AMD"][5]==6){
	$serviceids = $PAGS->getdeptwiseleads("'6','7'");	 
 $extra = " and  payment='1' and service IN($serviceids) $dates";  
}
if($_SESSION["AMD"][3]=='4' && $_SESSION["AMD"][5]==6){
	$serviceids = $PAGS->getdeptwiseleads("'6','7'");	
 $extra = " and deid='".$_SESSION["AMD"][0]."' and  payment='1' and service IN($serviceids) $dates";  
}
if($_SESSION["AMD"][3]=='2' && $_SESSION["AMD"][5]==5){
	$serviceids = $PAGS->getdeptwiseleads("'5'");	 
 $extra = " and  payment='1' and service IN($serviceids) $dates";  
}
if($_SESSION["AMD"][3]=='4' && $_SESSION["AMD"][5]==5){
	$serviceids = $PAGS->getdeptwiseleads("'5'");	
  $extra = " and deid='".$_SESSION["AMD"][0]."' and  payment='1' and service IN($serviceids) $dates";  
}

	}	
	
if($leadStage){

 $extra = " and status='".$leadStage."'"; 
if($_SESSION["AMD"][3]=='5'){
 $extra = " and  salesecutiveid='".$_SESSION["AMD"][0]."'  and status='".$leadStage."'";  
}
	}
	
if($work_process){

//$work_process=($work_process==0?'0':$work_process);
  $extra = " and processStatus='".$work_process."'"; 
 
 if($_SESSION["AMD"][3]=='2' && $_SESSION["AMD"][5]==4){
	 $serviceids = $PAGS->getdeptwiseleads("'4','7'");
 $extra = " and  payment='1' and processStatus='".$work_process."' and service IN($serviceids)";  
}
if($_SESSION["AMD"][3]=='4' && $_SESSION["AMD"][5]==4){
	$serviceids = $PAGS->getdeptwiseleads("'4','7'");
 $extra = " and  deid='".$_SESSION["AMD"][0]."' and  payment='1' and processStatus='".$work_process."' and service IN($serviceids)";  
}

if($_SESSION["AMD"][3]=='2' && $_SESSION["AMD"][5]==6){
	$serviceids = $PAGS->getdeptwiseleads("'6','7'");
 $extra = "  and processStatus='".$work_process."' and service IN($serviceids)";  
}
 if($_SESSION["AMD"][3]=='4' && $_SESSION["AMD"][5]==6){
	 $serviceids = $PAGS->getdeptwiseleads("'6','7'");
 $extra = " and  deid='".$_SESSION["AMD"][0]."' and  payment='1' and processStatus='".$work_process."' and service IN($serviceids)";  
}
if($_SESSION["AMD"][3]=='2' && $_SESSION["AMD"][5]==5){
	$serviceids = $PAGS->getdeptwiseleads("'5'");	 
 $extra = " and  payment='1' and service IN($serviceids) and processStatus='".$work_process."'";  
}
if($_SESSION["AMD"][3]=='4' && $_SESSION["AMD"][5]==5){
	$serviceids = $PAGS->getdeptwiseleads("'5'");	
  $extra = " and deid='".$_SESSION["AMD"][0]."' and  payment='1' and service IN($serviceids) and processStatus='".$work_process."'";  
}

	}
if($executive){
 $extra = " and deid='".$executive."'"; 
 if($_SESSION["AMD"][3]=='2' && $_SESSION["AMD"][5]==4){
	 $serviceids = $PAGS->getdeptwiseleads("'4','7'");
 $extra = " and  payment='1' and service IN($serviceids) and deid='".$executive."'";  
}
if($_SESSION["AMD"][3]=='2' && $_SESSION["AMD"][5]==6){
	$serviceids = $PAGS->getdeptwiseleads("'6','7'");
 $extra = "  and service IN($serviceids) and deid='".$executive."'";  
}
if($_SESSION["AMD"][3]=='2' && $_SESSION["AMD"][5]==5){
	$serviceids = $PAGS->getdeptwiseleads("'5'");
 $extra = "  and service IN($serviceids) and deid='".$executive."'";  
}

	}
	
if($department!=2 && in_array($_SESSION["AMD"][3],array("1", "6")) && $department!=''){
	
	
	 $serviceids = $PAGS->getdeptwiseleads($department);
 $extra = " and  payment='1' and service IN($serviceids)"; 
if($executive){
 $extra = " and  payment='1' and service IN($serviceids) and deid='".$executive."'";  	
	}
	
	if($work_process){

$work_process=($work_process==0?'0':$work_process);
  $extra = " and processStatus='".$work_process."'  and  payment='1' and service IN($serviceids)"; 
	}
	if($work_duration){
	if($work_duration=='Today'){
		$dates=" and date(paymentDate)>DATE_SUB(NOW(), INTERVAL 1 DAY)"; 
		}
		 else if($work_duration=='Yesterday'){
		$dates='and date(paymentDate)="'.date("Y-m-d",strtotime("-1 days")).'"';
		} 
		else if($work_duration=='This week'){
		$dates=" and date(paymentDate)>DATE_SUB(NOW(), INTERVAL 1 WEEK)"; 
		}
		else if($work_duration=='This Month'){
		$dates=" and date(paymentDate)>DATE_SUB(NOW(), INTERVAL 1 MONTH)"; 
		}
		
		else if($work_duration=='This Year'){
		$dates=" and date(paymentDate)>DATE_SUB(NOW(), INTERVAL 1 YEAR)"; 
		}
		else if($work_duration=='Last 7 days'){
		$dates=" and date(paymentDate)>DATE_SUB(NOW(), INTERVAL 7 DAY)"; 
		}
		
		else if($work_duration=='Last 30 days'){
		$dates=" and date(paymentDate)>DATE_SUB(NOW(), INTERVAL 30 DAY)"; 
		}
		else if($work_duration=='Last month'){
		$dates=" and YEAR(paymentDate) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(paymentDate) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)"; 
		}
		
 $extra =  " $dates and  payment='1' and service IN($serviceids)";
	}	
	if($leadSource){
 $extra = " and source='".$leadSource."' and  payment='1' and service IN($serviceids) and deid='".$executive."'"; 
	}
	
	}	
	
$start = intval($start);
$pagesize = intval($pagesize)==0?(($_SESSION["totpaging"])?$_SESSION["totpaging"]:DEF_PAGE_SIZE):$pagesize;
list($result,$reccnt) = $PAGS->display($start,$pagesize,$fld,$otype,$search_data,$extra,$extra1,$extra2);

?>
<section class="">
  <div class="container ">
    <div class="row">
        <?php
if($_SESSION["AMD"][3]=='1' || $_SESSION["AMD"][3]=='3'|| $_SESSION["AMD"][3]=='6'|| $_SESSION["AMD"][3]=='7'){
 ?>
<div class="downloadxel col-12">
<div class="row mb-5">
<div class="col-3">
        <input type="text" name="sdate" id="sdate" class="txt small form-control" placeholder="Start date (yyyy-mm-yy)" />
        </div>
        <div class="col-3">
        <input type="text" name="edate" id="edate" class="txt small form-control" placeholder="End date (yyyy-mm-yy)"/>
        </div>
        <div class="col-3">
        <select name="sourcedata" class="txt medium form-control" id="sourcedata">
        <option value="">---Select Service---</option>
     <?php 
 $service_query = $PDO->db_query("select * from #_product_manager where status='1'");
                while($service_rows = $PDO->db_fetch_array($service_query)){ ?>
                <option value="<?=$service_rows['pid']?>" <?=($service_rows['pid']==$rows1['service'])?'selected="selected"':''?>  ><?=$service_rows['name']?></option>
                <?php } ?>
        </select>
        </div>
        <div class="col-3">
        <a id="sedate" class="btn btn-primary" href="javascript:void(0)">Download Excel</a>
        </div>
        <script>
		$(document).ready(function(e) {
			$( "#sdate" ).datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true});
			$( "#edate" ).datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true});
			var srurl='';
            $('#sedate').on('click',function(){
				var sdate=$('#sdate').val();
				var edate=$('#edate').val();
				var service=$('#sourcedata').val();
				if(sdate=='' && edate!=''){
					alert('Please selct start date');
					return false;
					}else if(sdate!='' && edate==''){
					alert('Please selct end date');	
					return false;
						}else if(sdate=='' && edate==''){
					alert('Please selct dates');
					return false;		
							}
							sdate=sdate+' 00:00:00';
							edate=edate+' 23:59:59';
					if(service!=''){
						srurl='&serviceul='+service
						}	
				window.location.href = '<?=SITE_PATH_ADM._MODS."/leadexcel.php?stags=leads"?>&sdate='+sdate+'&edate='+edate+srurl;
				});
				


});
	function getstatus(a){
	window.location.href = '<?=SITE_PATH_ADM."index.php?comp=".$comp."&status="?>'+a;	
		}			
				
				
		</script>
        </div>
        </div>
        
<div class="downloadxel col-12">
<div class="row mb-5">
<div class="col-4">
        <input type="text" name="rsdate" id="rsdate" class="txt small form-control" placeholder="Start date (yyyy-mm-yy)" />
        </div>
        <div class="col-4">
        <input type="text" name="redate" id="redate" class="txt small form-control" placeholder="End date (yyyy-mm-yy)"/>
        </div>
        <div class="col-4">
        <a id="rsedate" class="btn btn-primary" href="javascript:void(0)">Download Sales Report</a>
        </div>
        <script>
		$(document).ready(function(e) {
			$( "#rsdate" ).datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true});
			$( "#redate" ).datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true});
			var srurl='';
            $('#rsedate').on('click',function(){
				var rsdate=$('#rsdate').val();
				var redate=$('#redate').val();
				if(rsdate=='' && redate!=''){
					alert('Please selct start date');
					return false;
					}else if(rsdate!='' && redate==''){
					alert('Please selct end date');	
					return false;
						}else if(rsdate=='' && redate==''){
					alert('Please selct dates');
					return false;		
							}
				window.location.href = '<?=SITE_PATH_ADM._MODS."/generateSalesReport.php?"?>&rsdate='+rsdate+'&redate='+redate;
				});
				


});		
		</script>
        </div>
        </div>
        <?php } ?>
      <div class="col-12  mb-3  ">
        <button type="button" class="btn btn-primary" onclick="checkcondition('proposal');">Proposal</button>


<!-- Proposal Modal -->
<div class="modal fade" id="proposal">
  <div class="modal-dialog">
  <form name="pp" method="post" action="#" enctype="multipart/form-data">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Proposal</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
     <div class="row">
     <div class="col-8"><div class="form-group">
                    <label for=""> Lead Refrence No </label>
                    <input type="text" name="leadid" id="leadidproposal" class="validate[required] form-control" >
                  </div></div> 
     <div class="col-4">       
      <button type="button" onclick="fetchLeaddetails(document.getElementById('leadidproposal').value,'proposal');" class="btn btn-info mt-4 btn-block" >Fetch</button>
</div>
     </div> 
     <div class="row ">  
     <div class="col text-center">
     <span class="text-center badge-info rounded-circle pl-2 pt-1 pb-1 pr-2">or</span>    
     </div>
              </div>
              
              <hr>
     <div id="fetchedDataproposal">
     <div class="row">
     <div class="col-6"><div class="form-group">
                    <label for=""> Customer Name</label>
                    <input type="text" class="validate[required] form-control" >
                  </div></div> 
                  
     <div class="col"><div class="form-group">
                    <label for=""> Email ID</label>
                    <input type="text" class="validate[required] form-control" >
                  </div></div>
     </div>
     <div class="row">
     <div class="col"><div class="form-group"> <!-- State Button -->
		<label for="state_id" class="control-label">Select Service</label>
		<select class="validate[required] form-control" name="service" >
			<option value="">Select...</option>
<?php 
 $service_query = $PDO->db_query("select * from #_product_manager where status='1'");
                while($service_rows = $PDO->db_fetch_array($service_query)){ ?>
                <option value="<?=$service_rows['pid']?>" <?=($service_rows['pid']==$rows1['service'])?'selected="selected"':''?>  ><?=$service_rows['name']?></option>
                <?php } ?>
		</select>					
	</div></div> 
     
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
        
        <button type="button" class="btn btn-secondary" onclick="checkcondition('Payment');">Payment Link</button>
        
        <!-- Payment Link Modal -->
<div class="modal fade" id="Payment">
  <div class="modal-dialog">
  <form name="pay" method="post" action="#" enctype="multipart/form-data">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Payment Link</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
     <div class="row">
     <div class="col-8"><div class="form-group">
                    <label for=""> Lead Refrence No </label>
                    <input type="text" id="leadidPayment" name="leadid" class="validate[required] form-control" >
                  </div></div> 
     <div class="col-4">       
      <button type="button"  onclick="fetchLeaddetails(document.getElementById('leadidPayment').value,'Payment');" class="btn btn-info mt-4 btn-block" >Fetch</button>
</div>
     </div> 
     <div class="row ">  
     <div class="col text-center ">
     <span class="text-center badge-info rounded-circle pl-2 pt-1 pb-1 pr-2">or</span>    
     </div>
              </div>
              <hr>
              
              <div id="fetchedDataPayment">
      
     <div class="row">
     <div class="col-6"><div class="form-group">
                    <label for=""> Customer Name</label>
                    <input type="text" class="validate[required] form-control" >
                  </div></div> 
                  
     <div class="col"><div class="form-group">
                    <label for=""> Email ID</label>
                    <input type="text" class="validate[required] form-control" >
                  </div></div>
     </div>
     <div class="row">
     <div class="col-6">
     <div class="form-group">
                     <label>Phone No</label>
                    <input type="text" name="phone" class="validate[required] form-control"  placeholder="">
                  </div></div> 
         <div class="col-6"><div class="form-group">
         <label>Amount to pay</label>
                    <input type="text" name="amount" class="validate[required] form-control"  placeholder="">
                  </div></div>  
     </div>
     <div class="row">
     <div class="col-6"><div class="form-group"> <!-- State Button -->
     <label>Select Service</label>
		<select class="validate[required] form-control" name="service" >
			<option value="">Select...</option>
<?php 
 $service_query = $PDO->db_query("select * from #_product_manager where status='1'");
                while($service_rows = $PDO->db_fetch_array($service_query)){ ?>
                <option value="<?=$service_rows['pid']?>" <?=($service_rows['pid']==$rows1['service'])?'selected="selected"':''?>  ><?=$service_rows['name']?></option>
                <?php } ?>
		</select>					
	</div></div>
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
        
        <a href="<?=SITE_PATH_ADM.'index.php?comp='.$comp.'&mode=add'?>" class="btn btn-success">Quick Lead add</a>
        
        <a href="<?=SITE_PATH_ADM.'index.php?comp=invoice'?>" class="btn btn-danger">Invoice Manager</a>
        <button type="button" class="btn btn-success" onclick="checkcondition('Escalation');">Escalation  of tickets</button>

        <div class="modal fade" id="Escalation">
  <div class="modal-dialog">
  <form name="esc" method="post" action="#" enctype="multipart/form-data">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Escalation  of tickets</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
     <div class="row">
     <div class="col-8"><div class="form-group">
                    <label for=""> Lead Refrence No </label>
                    <input type="text" name="leadid" id="leadidEscalation" class="form-control validate[required]" >
                  </div></div> 
     <div class="col-4">       
      <button type="button" onclick="fetchLeaddetails(document.getElementById('leadidEscalation').value,'Escalation');" class="btn btn-info mt-4 btn-block" >Fetch</button>
</div>
     </div> 
     <div class="row ">  
     <div class="col text-center ">
     <span class="text-center badge-info rounded-circle pl-2 pt-1 pb-1 pr-2">or</span>    
     </div>
              </div>
              <hr>
   <div id="fetchedDataEscalation">   
     <div class="row">
     <div class="col"><div class="form-group">
                    <label>Customer Name</label>
                    <input type="text" class="form-control validate[required]"  placeholder="">
                  </div></div> 
     
     </div>
     <div class="row">
     <div class="col-6">
     <div class="form-group">
                     <label>Phone No</label>
                    <input type="text" class="form-control validate[required]"  placeholder="">
                  </div></div> 
                  
                  
     <div class="col-6"><div class="form-group">
     <label>Email ID</label>
                    <input type="text" class="form-control validate[required]"  placeholder="">
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
    </div>

      <!-- Modal footer -->
      <div class="modal-footer">
      <input type="hidden" name="lid" value="" id="ldd" />
              <button type="submit" name="escalate" class="btn btn-primary" >Esclate</button>

        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
    </form>
  </div>
</div>
   <!--  <button type="button" class="btn btn-dark"  onclick="checkcondition('Quick');">Quick Message</button>-->
             <!-- Quick Message Modal -->

  <div class="modal fade" id="Quick">
  <div class="modal-dialog">
  <form name="qm" method="post" action="#" enctype="multipart/form-data">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Quick Message</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
     <div class="row">
     <div class="col-8"><div class="form-group">
                    <label for=""> Lead Refrence No </label>
                    <input type="text" name="leadid" id="leadidQuick" class="form-control">
                  </div></div> 
     <div class="col-4">       
      <button type="button" onclick="fetchLeaddetails(document.getElementById('leadidQuick').value,'Quick');" class="btn btn-info mt-4 btn-block" >Fetch</button>
</div>
     </div> 
     <div class="row ">  
     <div class="col text-center ">
     <span class="text-center badge-info rounded-circle pl-2 pt-1 pb-1 pr-2">or</span>    
     </div>
              </div>
              <hr>
      <div id="fetchedDataQuick">    
     
     </div>
    </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <input type="hidden" name="lid" value="" id="ldd" />
              <button type="submit" name="qmsg" class="btn btn-primary" >Send</button>

        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
    </form>
    
  </div>
</div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-title">
          <div class="col-sm-6 col-md-6 col-xs-12 float-left">
            <h2>Manage Leads </h2>  
            
      </div> 
       <?php if($_SESSION["AMD"][3]=='6' || $_SESSION["AMD"][3]=='1'){ ?>
      <div class="col-sm-6 col-md-6 col-xs-12 float-right">
             <label>Select Department</label>
                <select name="department" onChange="location.href = '<?=SITE_PATH_ADM."index.php?comp=".$comp?>&department='+this.value;" class="form-control">
                  <option>-------</option>
                   <?php 
 $sem_query = $PDO->db_query("select * from #_department where status='1' and pid NOT IN('1','3') order by name ASC");
                while($sem_rows = $PDO->db_fetch_array($sem_query)){ ?>
                                <option value="<?=$sem_rows['pid']?>" <?=($sem_rows['pid']==$department)?'selected="selected"':''?>><?=$sem_rows['name']?></option>
                                <?php } ?>
                </select>
            
      </div>
      <?php } if($_SESSION["AMD"][0]==2){ ?>
     <form name="samplecsv" method="post" action="" enctype="multipart/form-data">          
   <div class="col-lg-1 float-right ml-2">
   
  <button type="submit" name="bulkdown" class="btn btn-primary pull-right">Submit</button>
  
  </div>
  
  <div class="col-lg-4 float-right">
  
        <input type="file" name="file" class="custom-file-input" id="exampleInputFile"  aria-describedby="fileHelp">
        <label class="custom-file-label" for="exampleInputFile">
           Bulk Upload <small>(CSV File)</small>
        </label>
  </div>
  </form>
  <?php } ?>
          </div>
          <div class="ManageLeads-wrp ">
          
            <div class="row mbt15 leadfilter">
              <?php
			
			   if($_SESSION["AMD"][3]=='2' || $_SESSION["AMD"][3]=='4'){
				   if($_SESSION["AMD"][3]!='4'){
				    ?>
               
			   <div class="col">
                <label>Assign Multiple Lead</label>
                <select name="deid" onchange="submitions('Assigndeid')" class="form-control" >
                 <option value="">--Select--</option>
                   <?php 
				
 $sem_query = $PDO->db_query("select * from pms_admin_users where user_type='4' and rmanager='".$_SESSION["AMD"][0]."'");
                while($sem_rows = $PDO->db_fetch_array($sem_query)){ ?>
                <option value="<?=$sem_rows['user_id']?>"><?=$sem_rows['name']?></option>
                                <?php } ?>
                </select>
              </div>
              <?php } ?>
              <div class="col">
                <label>Lead Stage</label>
                <select name="work_process" onchange="getfilter(this.value,'work_process');" class="form-control">
                  <option value="">All</option>
                    <option value="17">New</option>
                   <?php 
 $sem_query = $PDO->db_query("select * from #_work_process where status='1' and deptId='".$_SESSION["AMD"][5]."' order by pid ASC");
                while($sem_rows = $PDO->db_fetch_array($sem_query)){ ?>
           <option value="<?=$sem_rows['pid']?>" <?=($sem_rows['pid']==$work_process)?'selected="selected"':''?>><?=$sem_rows['name']?></option>
                                <?php } ?>
                </select>
              </div>
              <div class="col">
                <label>Duration</label>
                <select name="duration" onchange="getfilter(this.value,'work_duration');" class="form-control">
                <option value="">--Select--</option>
                  <option value="Today"  <?=($work_duration=='Today')?'selected="selected"':''?>>Today</option>
                  <option value="Yesterday"  <?=($work_duration=='Yesterday')?'selected="selected"':''?>>Yesterday </option>
                  <option value="This week"  <?=($work_duration=='This week')?'selected="selected"':''?>>This week </option>
                  <option value="This Month"  <?=($work_duration=='This Month')?'selected="selected"':''?>>This Month </option>
                  <option value="This Year"  <?=($work_duration=='This Year')?'selected="selected"':''?>>This Year </option>
                  <option value="Last 7 days"  <?=($work_duration=='Last 7 days')?'selected="selected"':''?>>Last 7 days </option>
                  <option value="Last 30 days"  <?=($work_duration=='Last 30 days')?'selected="selected"':''?>>Last 30 days </option>
                  <option value="Last month"  <?=($work_duration=='Last month')?'selected="selected"':''?>>Last month</option>
                </select>
              </div>
              <?php   if($_SESSION["AMD"][3]!='4'){ ?>
              <div class="col">
                <label>Lead Owner</label>
                <select name="executive" onchange="getfilter(this.value,'executive');" class="form-control" >
                 <option value="">--Select--</option>
                   <?php 
 $sem_query = $PDO->db_query("select * from pms_admin_users where user_type='4' and rmanager='".$_SESSION["AMD"][0]."'");
                while($sem_rows = $PDO->db_fetch_array($sem_query)){ ?>
                <option value="<?=$sem_rows['user_id']?>" <?=($sem_rows['user_id']==$executive)?'selected="selected"':''?>><?=$sem_rows['name']?></option>
                                <?php } ?>
                </select>
              </div>
			   <?php
			  }} 
					   
		 else  if($_SESSION["AMD"][3]=='3' || $_SESSION["AMD"][3]=='5'){
			 if($_SESSION["AMD"][3]!='5'){
						  ?>
						  <div class="col">
                <label>Assign Multiple Lead</label>
                <select name="salesecutiveid" onchange="submitions('Assign')" class="form-control" >
                 <option value="">--Select--</option>
                   <?php 
				  
 $sem_query = $PDO->db_query("select * from pms_admin_users where user_type='5' and rmanager='".$_SESSION["AMD"][0]."' order by name ASC");
                while($sem_rows = $PDO->db_fetch_array($sem_query)){ ?>
                                <option value="<?=$sem_rows['user_id']?>"><?=$sem_rows['name']?></option>
                                <?php } ?>
                </select>
              </div> <?php } ?>
              <div class="col">
                <label>Lead Stage</label>
                <select name="leadStage" onchange="getfilter(this.value,'leadStage');" class="form-control">
                  <option>All</option>
                   <?php 
 $sem_query = $PDO->db_query("select * from #_lead_stage where status='1' order by name ASC");
                while($sem_rows = $PDO->db_fetch_array($sem_query)){ ?>
                                <option value="<?=$sem_rows['pid']?>" <?=($sem_rows['pid']==$leadStage)?'selected="selected"':''?>><?=$sem_rows['name']?></option>
                                <?php } ?>
                </select>
              </div>
              <div class="col">
                <label>Duration</label>
                <select name="duration" onchange="getfilter(this.value,'duration');" class="form-control">
                <option value="">--Select--</option>
                  <option value="Today"  <?=($duration=='Today')?'selected="selected"':''?>>Today</option>
                  <option value="Yesterday"  <?=($duration=='Yesterday')?'selected="selected"':''?>>Yesterday </option>
                  <option value="This week"  <?=($duration=='This week')?'selected="selected"':''?>>This week </option>
                  <option value="This Month"  <?=($duration=='This Month')?'selected="selected"':''?>>This Month </option>
                  <option value="This Year"  <?=($duration=='This Year')?'selected="selected"':''?>>This Year </option>
                  <option value="Last 7 days"  <?=($duration=='Last 7 days')?'selected="selected"':''?>>Last 7 days </option>
                  <option value="Last 30 days"  <?=($duration=='Last 30 days')?'selected="selected"':''?>>Last 30 days </option>
                  <option value="Last month"  <?=($duration=='Last month')?'selected="selected"':''?>>Last month</option>
                </select>
              </div>
              <?php   if($_SESSION["AMD"][3]!='5'){ ?>
              <div class="col">
                <label>Lead Owner</label>
                <select name="leadOwner" onchange="getfilter(this.value,'leadOwner');" class="form-control" >
                 <option value="">--Select--</option>
                   <?php 
 $sem_query = $PDO->db_query("select * from pms_admin_users where user_type='5'");
                while($sem_rows = $PDO->db_fetch_array($sem_query)){ ?>
                                <option value="<?=$sem_rows['user_id']?>"  <?=($sem_rows['user_id']==$leadOwner)?'selected="selected"':''?>><?=$sem_rows['name']?></option>
                                <?php } ?>
                </select>
              </div>
						  <?php } }
						  
		else  if($_SESSION["AMD"][3]=='6' || $_SESSION["AMD"][3]=='1'){
						    if($department==2){
					   $assign='Assign';
					    $user_type=5;
						$suser_type=3;
					    }else {
							
					   $assign='Assigndeid';
					    $user_type=4;
						$suser_type=2;
					    
							}
						  ?>
						  <div class="col">
                <label>Assign Multiple Lead</label>
                <select name="salesecutiveid" onchange="submitions('<?=$assign?>')" class="form-control" >
                 <option value="">--Select--</option>
                   <?php 
				  
 $sem_query = $PDO->db_query("select * from pms_admin_users where user_type='".$user_type."' and rmanager='".$PDO->getSingleresult("select user_id from pms_admin_users where user_type='".$suser_type."' and dpid='".$department."'")."' order by name ASC");
                while($sem_rows = $PDO->db_fetch_array($sem_query)){ ?>
                                <option value="<?=$sem_rows['user_id']?>"><?=$sem_rows['name']?></option>
                                <?php } ?>
                </select>
              </div>
              <?php if($department==2){?>
              <div class="col">
                <label>Lead Stage</label>
                <select name="leadStage" onchange="getfilter(this.value,'leadStage');" class="form-control">
                  <option>All</option>
                   <?php 
 $sem_query = $PDO->db_query("select * from #_lead_stage where status='1' order by name ASC");
                while($sem_rows = $PDO->db_fetch_array($sem_query)){ ?>
                                <option value="<?=$sem_rows['pid']?>" <?=($sem_rows['pid']==$leadStage)?'selected="selected"':''?>><?=$sem_rows['name']?></option>
                                <?php } ?>
                </select>
              </div>
              <div class="col">
                <label>Duration</label>
                <select name="duration" onchange="getfilter(this.value,'duration');" class="form-control">
                <option value="">--Select--</option>
                  <option value="Today"  <?=($duration=='Today')?'selected="selected"':''?>>Today</option>
                  <option value="Yesterday"  <?=($duration=='Yesterday')?'selected="selected"':''?>>Yesterday </option>
                  <option value="This week"  <?=($duration=='This week')?'selected="selected"':''?>>This week </option>
                  <option value="This Month"  <?=($duration=='This Month')?'selected="selected"':''?>>This Month </option>
                  <option value="This Year"  <?=($duration=='This Year')?'selected="selected"':''?>>This Year </option>
                  <option value="Last 7 days"  <?=($duration=='Last 7 days')?'selected="selected"':''?>>Last 7 days </option>
                  <option value="Last 30 days"  <?=($duration=='Last 30 days')?'selected="selected"':''?>>Last 30 days </option>
                  <option value="Last month"  <?=($duration=='Last month')?'selected="selected"':''?>>Last month</option>
                </select>
              </div>
              <div class="col">
                <label>Lead Owner</label>
                <select name="leadOwner" onchange="getfilter(this.value,'leadOwner');" class="form-control" >
                 <option value="">--Select--</option>
                   <?php 
 $sem_query = $PDO->db_query("select * from pms_admin_users where user_type='5'");
                while($sem_rows = $PDO->db_fetch_array($sem_query)){ ?>
                                <option value="<?=$sem_rows['user_id']?>"  <?=($sem_rows['user_id']==$leadOwner)?'selected="selected"':''?>><?=$sem_rows['name']?></option>
                                <?php } ?>
                </select>
              </div>
						  <?php }else {?>
						  <div class="col">
                <label>Lead Stage</label>
                <select name="work_process" onchange="getfilter(this.value,'work_process');" class="form-control">
                   <option value="">All</option>
                    <option value="17">New</option>
                   <?php 
 $sem_query = $PDO->db_query("select * from #_work_process where status='1' and deptId='".$department."' order by pid ASC");
                while($sem_rows = $PDO->db_fetch_array($sem_query)){ ?>
           <option value="<?=$sem_rows['pid']?>" <?=($sem_rows['pid']==$work_process)?'selected="selected"':''?>><?=$sem_rows['name']?></option>
                                <?php } ?>
                </select>
              </div>
              <div class="col">
                <label>Duration</label>
                <select name="duration" onchange="getfilter(this.value,'work_duration');" class="form-control">
                <option value="">--Select--</option>
                  <option value="Today"  <?=($work_duration=='Today')?'selected="selected"':''?>>Today</option>
                  <option value="Yesterday"  <?=($work_duration=='Yesterday')?'selected="selected"':''?>>Yesterday </option>
                  <option value="This week"  <?=($work_duration=='This week')?'selected="selected"':''?>>This week </option>
                  <option value="This Month"  <?=($work_duration=='This Month')?'selected="selected"':''?>>This Month </option>
                  <option value="This Year"  <?=($work_duration=='This Year')?'selected="selected"':''?>>This Year </option>
                  <option value="Last 7 days"  <?=($work_duration=='Last 7 days')?'selected="selected"':''?>>Last 7 days </option>
                  <option value="Last 30 days"  <?=($work_duration=='Last 30 days')?'selected="selected"':''?>>Last 30 days </option>
                  <option value="Last month"  <?=($work_duration=='Last month')?'selected="selected"':''?>>Last month</option>
                </select>
              </div>
              <div class="col">
                <label>Lead Owner</label>
                <select name="executive" onchange="getfilter(this.value,'executive');" class="form-control" >
                 <option value="">--Select--</option>
                   <?php 
 $sem_query = $PDO->db_query("select * from pms_admin_users where user_type='".$user_type."' and rmanager='".$PDO->getSingleresult("select user_id from pms_admin_users where user_type='".$suser_type."' and dpid='".$department."'")."' order by name ASC");
                while($sem_rows = $PDO->db_fetch_array($sem_query)){ ?>
                <option value="<?=$sem_rows['user_id']?>" <?=($sem_rows['user_id']==$executive)?'selected="selected"':''?>><?=$sem_rows['name']?></option>
                                <?php } ?>
                </select>
              </div>
						  <?php } }  ?>
              <div class="col">
                <label>Lead source</label>
                <select name="leadSource" onchange="getfilter(this.value,'leadSource');" class="form-control">
                  <option value="">All</option>
                  <?php 
 $sem_query = $PDO->db_query("select * from #_lead_source where status='1'  order by name ASC");
                while($sem_rows = $PDO->db_fetch_array($sem_query)){ ?>
                                <option value="<?=$sem_rows['pid']?>"  <?=($sem_rows['pid']==$leadSource)?'selected="selected"':''?>><?=$sem_rows['name']?></option>
                                <?php } ?>
                </select>
              </div>
              
              <!--<div class="col text-center">
                <label class="mt30">Select colums <a href="#" data-toggle="modal" data-target="#myModal" class="text-center" ><i class="fa fa-align-justify" data-toggle="tooltip" data-placement="top" title="Select colums" ></i></a></label>
              </div>-->
            </div>
          
            <!-- The Modal -->
            <!--<div class="modal fade" id="myModal">
              <div class="modal-dialog">
                <div class="modal-content"> 
                  
                
                  <div class="modal-header">
                    <h4 class="modal-title">Select Lead Fields to view in grid</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  
                
                  <div class="modal-body">
                    <ul class="list-unstyled addgrid">
                      <li>
                        <label>
                          <input type="checkbox" name="colorCheckbox" value="datetime">
                          Date and time</label>
                      </li>
                      <li>
                        <label>
                          <input type="checkbox" name="colorCheckbox" value="status">
                          Status</label>
                      </li>
                   
                    </ul>
                  </div>
                 
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>-->
            <div class="row">
              <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" >
                  <thead>
                    <tr>
                      <th><?=$ADMIN->check_all()?></th>
                      <th>TMI</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                     
                      <th>Source</th>
                      <th> Lead Owner</th>
                      <th>Date & Time</th>
                      <th> Status</th>
                 
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if($reccnt)
			      { $nums = (($start)?$start+1:1); 
				    while ($line = $PDO->db_fetch_array($result))
				    { @extract($line);$css =($css=='odd')?'even':'odd';
					if($line['status']==7){
				$style='style="background-color:#007bff70"';
				//$style='style="background-color:#ff00007d"';
				
					}
					elseif($esclate==1){
				$style='style="background-color:#ff00007d"';
				
					} 
					 elseif($line['status']==6){
						$style='style="background-color:#28a74578"';
						} else {
						$style='';
						}
					$services=$PDO->getSingleresult("select name from #_product_manager where pid='".addslashes($service)."'");
					if($department==2 || $_SESSION["AMD"][3]=='5' || $_SESSION["AMD"][3]=='3'){
						$leadowner=$salesecutiveid;
				
						}else { $leadowner=$deid; }
						if($utm_source!=''){
		                    $source=13;
		                    }
			?>
                    <tr <?=$style?>>
                      <td><?=$ADMIN->check_input($rwi)?></td>
                      <td><?=$rwi?></td>
                      <td><?=$name?></td>
                      <td><?=$email?></td>
                      <td><?=$phone?></td>
                     
                      <td><?=$PDO->getSingleresult("select name from #_lead_source where pid='".$source."'");?> </td>
                      <td><?=$PDO->getSingleresult("select name from pms_admin_users where user_id='".$leadowner."'")?> </td>
                      <td><?=$created_on?></td>
                     
                      <td><?=$PDO->getSingleresult("select name from #_lead_stage where pid='".$status."'")?></td>
                  
                      <td>
                      
                      <a href="<?=SITE_PATH_ADM.'index.php?comp='.$comp.(($_GET[start])?'&start='.$_GET[start]:'').'&mode=edit&uid='.$pid?><?=$catid?'&catid='.$catid:''?><?=($die_id)?'&die_id='.$die_id:''?>"  data-toggle="tooltip" title=""><i class="fa fa-edit"></i></a> &nbsp; &nbsp;
                      
                      
                      <!-- <a href="<?=SITE_PATH_ADM.'index.php?comp='.$comp.(($_GET[start])?'&start='.$_GET[start]:'').'&uid='.$pid.'&action=del';?>" onclick="return confirm('Do you want delete this record?');" title="Delete"><i class="fa fa-trash-o"></i></a> --></td>
                    </tr>
                    
                    <?php $nums++;} ?>
                  
                    
                  </tbody>
                 
                </table>
                <?php  }else { echo '</tbody></table><div align="center" class="norecord">No Record Found</div>  '; } ?>
              </div>
            </div>
            <?php include("cuts/paging.inc.php");?>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
</section>
       
<script language="javascript">
function checkcondition(source){
	var numberOfChecked = $('input:checkbox:checked').length;
	if(numberOfChecked>1){
	alert('Two or more '+ source +' can not sent at a time!');
	$('#Proposal').modal('hide');
	} else if(numberOfChecked==1) {
		var lid=$('input:checkbox:checked').val();
		$('#leadid'+source).val(lid);
		fetchLeaddetails(lid,source);
		$('#'+source).modal('show');
		
		} else {
			$('#'+source).modal('show');
			}
	}
	function fetchLeaddetails(lid,type){
	$('#ldd'+type).val(lid);		
	data= {'lid':lid,'type':type}
	console.log(data);
$.ajax({
    type: "POST",
    url: "<?=SITE_PATH_ADM?>modules/leadsAjax.php",
    data: data,
    success: function(data) {
	
	$('#fetchedData'+type).html(data);
	
		},
    error: function() {
        alert('error handing here');
    }
});
	return false;}
$(document).ready(function(){/* 
	$(function() {
		$("#example td").sortable({ opacity: 0.6, cursor: 'move', update: function() {
			var order = jQuery(this).sortable("serialize") + '&tbl=<?=tblName?>&field=user_id'; 
			 $.post("<?=SITE_PATH_ADM?>modules/orders.php", order, function(theResponse){ }); 															
		}								  
		});
	});
*/});	
	function getfilter(a,b){


		
 	window.location.href = '<?=SITE_PATH_ADM."index.php?comp=".$comp?>&'+b+'='+a+'<?=$department?'&department='.$department:''?>';	

				}

</script>

<!--Date and time picker--> 
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script> 
<script src='js/timepicker.js'></script>
<link rel="stylesheet" href="css/timepicker.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css">
<script >$('.time').timepicker({
	controlType: 'select',
	timeFormat: 'hh:mm tt'
});
</script> 
<script>
  $('[data-toggle=datepicker]').each(function() {
  var target = $(this).data('target-name');
  var t = $('input[name=' + target + ']');
  t.datepicker({
    dateFormat: 'dd-mm-yy',
	changeMonth: true,
    changeYear: true ,
	  //  yearRange: "2005:2015"
	  yearRange: "-100:+0", // last hundred years
  });
  $(this).on("click", function() {
    t.datepicker("show");
  });
});
function reply(taskid){
	data= {'taskid':taskid}
$.ajax({
    type: "POST",
    url: "<?=SITE_PATH_ADM?>modules/leadsAjax.php",
    data: data,
    success: function(data) {
	console.log(data);	
	$('#allreply').html(data);
	$('#allreply').modal('show');
		},
    error: function() {
        alert('error handing here');

    }
});
	return false;}

  </script>