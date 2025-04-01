<?php 
include(FS_ADMIN._MODS."/associates/associates.inc.php");
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
	
	
	if(isset($_POST['escalate'])){
	
	$ps['sentBy']=$_SESSION["AMD"][0];
	$ps['name']=$_POST['name'];
	$ps['email']=$_POST['email'];
	$ps['phone']=$_POST['phone'];
	$ps['lid']=$_POST['lid'];
	$ps['comment']=$_POST['comment'];
	$ps['status']=44;
	$ps['type']='32';
	$PDO->sqlquery("rs",'associate_activity',$ps);
	$lead['esclate']=1;
	
	$PDO->sqlquery("rs",'associates',$lead,'pid',$_POST['lid']);
	
	$mailbody='<table width="100%" cellpadding="0" cellspacing="0"><tr><td><table style="margin:auto; width:600px; font-size:16px; line-height:24px; font-family:Verdana, Geneva, sans-serif" cellpadding="0" cellspacing="0"><tr><td><table width="100%" cellpadding="5" cellspacing="0"><tr><td><a href="https://www.registrationwala.com"><img src="https://www.registrationwala.com/images/emailer/logonrw.png" width="109" height="38" alt="Registrationwala.com" /></a></td><td align="right"><a style="margin:0 5px;" href="https://www.facebook.com/registrationwala/" target="_blank"><img src="https://www.registrationwala.com/images/emailer/facebookc.png" width="27" height="27" alt="Like On Facebook" /></a><a style="margin:0 5px;" href="https://twitter.com/Registrationwla" target="_blank"><img src="https://www.registrationwala.com/images/emailer/twitterc.png" width="27" height="27" alt="Like On Twitter" /></a><a style="margin:0 5px;" href="https://plus.google.com/u/0/115063389280026230269/posts" target="_blank"><img src="https://www.registrationwala.com/images/emailer/g-plusc.png" width="27" height="27" alt="Like On Google plus" /></a></td></tr></table></td></tr><tr><td><table width="100%" cellpadding="15" cellspacing="0"><tr><td style="border:1px solid #ccc;">
	<table width="100%" cellpadding="5" cellspacing="0">
	<tr><td style="padding:10px 20px;"><p style="padding-left:10px; margin:0">Dear Gaurav,</p></td></tr>
	
	<tr><td><table width="100%" cellpadding="0" cellspacing="0"><tr><td style="padding:10px 20px;"><p style="margin:10px 0; text-align:justify; line-height:24px;">Ticket no TMB'.$_POST['lid'].' has been Escalation. Details are given below;</p></td></tr><tr><td style="padding:10px 20px;"><p style="margin:10px 0; text-align:justify; line-height:24px; color:#00293c;"><strong>Ticket Number: TMB'.$_POST['lid'].'</strong></p></td></tr>
<tr><td style="padding:10px 20px;"><p style="margin:10px 0; text-align:justify; line-height:24px; color:#00293c;"><strong>Request By: '.$_SESSION["AMD"][1].'</strong></p></td></tr>
<tr><td style="padding:10px 20px;"><p style="margin:10px 0; text-align:justify; line-height:24px; color:#00293c;"><strong>Client Name: '.$_POST['name'].'</strong></p></td></tr>
<tr><td style="padding:10px 20px;"><p style="margin:10px 0; text-align:justify; line-height:24px; color:#00293c;"><strong>Client Email: '.$_POST['email'].'</strong></p></td></tr>
<tr><td style="padding:10px 20px;"><p style="margin:10px 0; text-align:justify; line-height:24px; color:#00293c;"><strong>Phone: '.$_POST['phone'].'</strong></p></td></tr>
<tr><td style="padding:10px 20px;"><p style="margin:10px 0; text-align:justify; line-height:24px; color:#00293c;"><strong>Reason: '.$_POST['comment'].'</strong></p></td></tr>
</table></td></tr>
<tr><td style="padding:15px 10px;">'.$RW->emailSignature($ADMIN->user_type($_SESSION["AMD"][3])).'</td></tr>
</table></td></tr></table></td></tr></table></td></tr></table>';


 $to='admin@registrationwala.com';
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: Registrationwala <support@registrationwala.com>' . "\r\n";
		
		//$headers .= 'Reply-To:support@registrationwala.com,vikram@registrationwala.com,mayank@registrationwala.com,cagauravbansal1@gmail.com,' .$_SESSION["AMD"][2]."\r\n";
	  // $headers .= 'Cc: support@registrationwala.com,vikram@registrationwala.com,mayank@registrationwala.com,cagauravbansal1@gmail.com,' .$_SESSION["AMD"][2]. "\r\n";
		$subject='Escalation of Ticket Number Associate ID'.$_POST['lid'].' | Registrationwala';

		$mails=mail($to, $subject, $mailbody, $headers, '-fsupport@registrationwala.com');
	
  $ADMIN->sessset('Record has been saved!', 's');
$RW->redir($ADMIN->iurl($comp.(($start)?'&start='.$start:'').(($subpage_id)?'&subpage_id='.$subpage_id:'')), true);
}
if(isset($_POST['qmsg'])){
	//print_r($_POST);
		$query =$PDO->db_query("select * from #_associates where pid ='".$_POST['lid']."' "); 
	$row = $PDO->db_fetch_array($query);
	@extract($row);
	$ps['comment']=$_POST['comment'];
	$ps['lid']=$_POST['lid'];
	$ps['sentBy']=$_SESSION["AMD"][0];
	$ps['status']=9;
	$ps['type']=34;
	$PDO->sqlquery("rs",'associate_activity',$ps);
	
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
	
	//print_r($_POST); exit;
	$ps['lid']=$_POST['lid'];
	$ps['sentBy']=$_SESSION["AMD"][0];
	$ps['status']=4;
	$ps['serviceid']=$_POST['service'];
	$ps['name']=$_POST['name'];
	$ps['email']=$_POST['email'];
	$ps['phone']=$_POST['phone'];
	
	$PDO->sqlquery("rs",'associate_proposalsent',$ps);
	$ps['sentBy']=$_SESSION["AMD"][0];
	$ps['status']=4;
	$ps['type']='20';
	$PDO->sqlquery("rs",'associate_activity',$ps);
		
	$lead['status']=4;
	$PDO->sqlquery("rs",'associates',$lead,'pid',$_POST['lid']);
  
	 $msql = "SELECT * FROM #_product_manager WHERE pid='".$_POST['service']."'";
$mry=$PDO->db_query($msql);

$mres = $PDO->db_fetch_array($mry);
  
	// echo $mres['body']; exit;  
	   
	   
$msg=str_replace('x,xxx',$mres['price'],$mres['proposal']);	
//$rgards=str_replace('Team Registrationwala.com',$_SESSION["AMD"][1],$msg);
//$numb=str_replace('execuivePhone',$PDO->getSingleresult("select mobile from pms_admin_users where user_id='".$_SESSION["AMD"][0]."'"),$rgards);	
$names=str_replace('signatures',$RW->emailSignature($ADMIN->user_type($_SESSION["AMD"][3])),$msg);	   
$msgf1 =str_replace('cnamexxx',$_POST['name'],$names);	

	   
//echo $msgf1; exit;

	    $to=$_POST['email'];
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: Registrationwala <support@registrationwala.com>' . "\r\n";
		
		$headers .= 'Reply-To:cagauravbansal1@gmail.com,' .$_SESSION["AMD"][2]."\r\n";
	    $headers .= 'Cc: cagauravbansal1@gmail.com,' .$_SESSION["AMD"][2]. "\r\n";
		$subject='Thank You for Requesting Proposal for '.$mres['name'].' | Registrationwala.com';
		$mails=mail($to, $subject, $msgf1, $headers, '-fsupport@registrationwala.com');
 $ADMIN->sessset('proposal has been sent to '.$_POST['name'], 's');

 $RW->redir($ADMIN->iurl($comp.(($start)?'&start='.$start:'').(($subpage_id)?'&subpage_id='.$subpage_id:'')), true);   
	
	
	}
/*end send Porposal */
/*start  send payment link */
if(isset($_POST['paylink'])){
$ps['lid']=$_POST['lid'];
$ps['status']=5;

$ps['sentBy']=$_SESSION["AMD"][0];

$PDO->sqlquery("rs",'associate_plinksent',$ps);
$ps['status']=28;

$ps['type']='23';

$cpid=$PDO->sqlquery("rs",'associate_activity',$ps);

$data=$_POST;
@extract($data);
				$tdquery=$PDO->db_query("select * from #_site_users where email ='".$email."' "); 
				if($tdquery->rowCount()>0){
					$row=$PDO->db_fetch_array($tdquery);
					 $data['user_id']=$row['user_id'];
					}else{
						$data['password']='RW@'.rand(100, 999);
						$data['user_id'] = $PDO->sqlquery("rs","site_users",$data);
						
						}
			$serviceName=$PDO->getsingleresult("select name from #_product_manager where pid='".$_POST['service']."'");
				$data['created_on']=date('Y-m-d H:i:s');
				$data['create_by']=$_SESSION["AMD"][0];
				$data['lid']=$uid;
				$data['servicename']=$serviceName;
				$customeorderid=$PDO->sqlquery("rs","custom_payments",$data);
				$cpi['cpid']=$customeorderid;
				$PDO->sqlquery("rs",'associate_activity',$cpi,'pid',$cpid);	
				
			
		//$post=$data;
		
				$mailbody='<table cellpadding="0" cellspacing="0" width="100%">
  <tbody>
    <tr>
      <td><table cellpadding="0" cellspacing="0" style="margin:auto; width:600px; font-size:16px; line-height:24px; font-family:Verdana, Geneva, sans-serif">
          <tbody>
            <tr>
              <td><table cellpadding="5" cellspacing="0" width="100%">
                  <tbody>
                    <tr>
                      <td><a href="https://www.registrationwala.com"><img alt="Registrationwala.com" height="38" src="https://www.registrationwala.com/images/emailer/logonrw.png" width="109" /></a></td>
                      <td align="right"><a href="https://www.facebook.com/registrationwala/" style="margin:0 5px;" target="_blank"><img alt="Like On Facebook" height="27" src="https://www.registrationwala.com/images/emailer/facebookc.png" width="27" /></a><a href="https://twitter.com/Registrationwla" style="margin:0 5px;" target="_blank"><img alt="Like On Twitter" height="27" src="https://www.registrationwala.com/images/emailer/twitterc.png" width="27" /></a><a href="https://plus.google.com/u/0/115063389280026230269/posts" style="margin:0 5px;" target="_blank"><img alt="Like On Google plus" height="27" src="https://www.registrationwala.com/images/emailer/g-plusc.png" width="27" /></a></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            <tr>
              <td><table cellpadding="15" cellspacing="0" width="100%">
                  <tbody>
                    <tr>
                      <td style="border:1px solid #ccc; background:url(https://www.registrationwala.com/images/emailer/drop-mark.png) no-repeat top left 10px;"><table cellpadding="5" cellspacing="0" width="100%">
                          <tbody>
                            <tr>
                              <td style="padding:10px 20px;"><h1 style="margin:8px; padding-left:25px; font-size:40px; font-weight:300; text-transform:uppercase; color:#00293c; font-family:\'Times New Roman\', Times, serif"> Payment</h1>
                                <p style="padding-left:25px; margin:8px; font-size:13px;"> Thank You for choosing Registrationwala.com</p></td>
                            </tr>
                            <tr>
                              <td style="padding:0"><img alt="Thank You for contacting Registrationwala!" height="215" src="https://www.registrationwala.com/images/emailer/custome-payment.jpg" style="height:auto; width:100%" width="483" /></td>
                            </tr>
                            <tr>
                              <td bgcolor="#00293c" style="padding:10px 20px; background-color:#00293c; color:#fff;"><p style="padding-left:10px; margin:0"> Dear '.$_POST['name'].',</p></td>
                            </tr>
                            <tr>
                              <td><table cellpadding="0" cellspacing="0" width="100%">
                                  <tbody>
                                    <tr>
                                      <td style="padding:10px 20px;"><p style="margin:10px 0; text-align:justify; line-height:24px;"> We are glad that you choose our '.$serviceName.' service. You are requested to make the payment of Rs '.$_POST['amount'].' in order to ensure fast-track processing of you request.</p></td>
                                    </tr>
                                    <tr>
                                      <td style="padding:10px 20px;"><p style="margin:10px 0; text-align:justify; line-height:24px; color:#00293c;"> <strong>Service: '.$serviceName.'</strong></p></td>
                                    </tr>
                                    <tr>
                                      <td style="padding:10px 20px;"><p style="margin:10px 0; text-align:center; line-height:24px; color:#00293c;"> <a href="" style="display:inline-block; padding:10px 50px; color:#fff; font-weight:bold; background:#00293c; text-decoration:none;">Rs. '.$_POST['amount'].'/-</a></p></td>
                                    </tr>
                                    <tr>
                                      <td style="padding:10px 20px;"><p style="margin:10px 0; text-align:center; line-height:24px; color:#00293c;"> <a href="http://www.registrationwala.com/order?customuid='.$customeorderid.'" style="display:inline-block; padding:10px 50px; color:#fff; font-weight:bold; background:#f52900; text-decoration:none;">Pay Online</a></p></td>
                                    </tr>
                                    
                                  </tbody>
                                </table></td>
                            </tr>
                            <tr>
                              <td style="padding:15px 10px; background-color:#00293c;"><h2 style="color:#fff; margin:0 0 20px 0; padding:0; font-size:18px; text-align:center; text-transform:uppercase;"> FOR any guidance feel free to reach us</h2>
                                <table cellpadding="0" cellspacing="0" width="100%">
                                  <tbody>
                                    <tr>
                                      <td align="center"><a href="mailto:support@Registrationwala.com" style="text-decoration:none; color:#fff;">support@Registrationwala.com</a></td>
                                      <td align="center"><a href="tel:+918882580580" style="text-decoration:none; color:#fff;">+91-888-2580-580</a></td>
                                    </tr>
                                  </tbody>
                                </table></td>
                            </tr>
                            
                            <tr>
															<td style="padding:20px 30px 0 30px;color:#00293c;">
																'.$RW->emailSignature($ADMIN->user_type($_SESSION["AMD"][3])).'</td>
														</tr>
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
          </tbody>
        </table></td>
    </tr>
  </tbody>
</table>

';

        /* $to=$_POST['email'];
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: Registrationwala <support@registrationwala.com>' . "\r\n";
		
		$headers .= 'Reply-To:support@registrationwala.com,vikram@registrationwala.com,mayank@registrationwala.com,cagauravbansal1@gmail.com,' .$_SESSION["AMD"][2]."\r\n";
	    $headers .= 'Cc: support@registrationwala.com,vikram@registrationwala.com,mayank@registrationwala.com,cagauravbansal1@gmail.com,' .$_SESSION["AMD"][2]. "\r\n";
		$subject='Payment Request from Registrationwala | '.$serviceName.' | '.$_POST['lid'];
		$mails=mail($to, $subject, $mailbody, $headers, '-fsupport@registrationwala.com');*/
		$st['status']=2;
		
		
$subject='Payment Request from Registrationwala | '.$serviceName.' | '.$_POST['leadid'];		
		
	$email = new \SendGrid\Mail\Mail(); 
$email->setFrom("support@registrationwala.com", "Registrationwala");
$email->setSubject($subject);
$email->addTo($_POST['email'], $_POST['name']);
$ccEmails = [ 
   "cagauravbansal1@gmail.com" => "Gauarv Bansal",
    "vikramnagi.rw@gmail.com" => "Vikram Nagi"
];

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
		
		
		
		
		
		
		
		
		
		
		
		
$PDO->sqlquery("rs",'associates',$st,'pid',$_POST['lid']);	
	
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
 $extra = " and source='".$leadSource."'"; 
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
<!--<div class="downloadxel col-12">
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
				window.location.href = '<?=SITE_PATH_ADM._MODS."/leadexcel.php?stags=associates"?>&sdate='+sdate+'&edate='+edate+srurl;
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
        </div>-->
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
        
       
        <button type="button" class="btn btn-danger" onclick="checkcondition('Escalation');">Escalation  of tickets</button>

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
            <h2>Manage Associates </h2>  
            
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
      <?php }?>

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
                      <th>AXN</th>
                      <th>TMB</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                   
                      <th>Occupation</th>
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
			?>
                    <tr <?=$style?>>
                      <td><?=$ADMIN->check_input($rwi)?></td>
                      <td>
                      
                      <a href="<?=SITE_PATH_ADM.'index.php?comp='.$comp.(($_GET[start])?'&start='.$_GET[start]:'').'&mode=edit&uid='.$pid?><?=$catid?'&catid='.$catid:''?><?=($die_id)?'&die_id='.$die_id:''?>"  data-toggle="tooltip" title=""><i class="fa fa-edit"></i></a> &nbsp; &nbsp;
                      
                      
                      <!-- <a href="<?=SITE_PATH_ADM.'index.php?comp='.$comp.(($_GET[start])?'&start='.$_GET[start]:'').'&uid='.$pid.'&action=del';?>" onclick="return confirm('Do you want delete this record?');" title="Delete"><i class="fa fa-trash-o"></i></a> --></td>
                      <td><?=$rwi?></td>
                      <td><?=$name?></td>
                      <td><?=$email?></td>
                      <td><?=$phone?></td>
                       
                      <td><?=$occupation?></td>
                      <td><?=$PDO->getSingleresult("select name from #_lead_source where pid='".$source."'");?> </td>
                    
                      <td><?=$PDO->getSingleresult("select name from pms_admin_users where user_id='".$leadowner."'")?> </td>
                      <td><?=$created_on?></td>
                     
                      <td><?=$PDO->getSingleresult("select name from #_lead_stage where pid='".$status."'")?></td>
                  <td>
                      
                      <a href="<?=SITE_PATH_ADM.'index.php?comp='.$comp.(($_GET[start])?'&start='.$_GET[start]:'').'&mode=edit&uid='.$pid?><?=$catid?'&catid='.$catid:''?><?=($die_id)?'&die_id='.$die_id:''?>"  data-toggle="tooltip" title=""><i class="fa fa-edit"></i></a> &nbsp; &nbsp;
                      
                   <?php if($_SESSION["AMD"][0]==2){ ?>   
                       <a href="<?=SITE_PATH_ADM.'index.php?comp='.$comp.(($_GET[start])?'&start='.$_GET[start]:'').'&uid='.$pid.'&action=del';?>" onclick="return confirm('Do you want delete this record?');" title="Delete"><i class="fa fa-trash-o"></i></a> </td>
                     <?php } ?> 
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
    url: "<?=SITE_PATH_ADM?>modules/associateAjax.php",
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