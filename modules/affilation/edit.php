<?php 

include(FS_ADMIN._MODS."/affilation/affilation.inc.php");

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

$PDO->sqlquery("rs",'cost_list',$_POST);
$ADMIN->sessset('Record has been saved!', 's');

$RW->redir($ADMIN->iurl($comp.'&mode=edit&uid='.$uid.(($start)?'&start='.$start:'').(($followup)?'&followup='.$followup:'')), true); }
if(isset($_POST['additionalReq'])){
$_POST['lid']=$_GET['uid'];
$_POST['create_by']=$_SESSION["AMD"][0];
$_POST['status']=1;
$checkadrq=$PDO->db_query("select lid from #_crequirement where lid='".$_GET['uid']."'");
if($checkadrq->rowCount()>0){
$PDO->sqlquery("rs",'crequirement',$_POST,'lid',$_GET['uid']);
}else{
$PDO->sqlquery("rs",'crequirement',$_POST);
}
$ADMIN->sessset('Record has been saved!', 's');

$RW->redir($ADMIN->iurl($comp.'&mode=edit&uid='.$uid.(($start)?'&start='.$start:'').(($followup)?'&followup='.$followup:'')), true); }
if(isset($_POST['paymentpay'])){

$_POST['lid']=$_GET['uid'];

$_POST['sentBy']=$_SESSION["AMD"][0];

$_POST['status']=6;

$PDO->sqlquery("rs",'paymentdetails',$_POST);
$paydate=$PDO->getSingleresult("select paymentDate from #_affilation where pid='".$uid."'");
if($paydate=='0000-00-00 00:00:00'){
$paym['paymentDate']=date('Y-m-d H:i:s');;
	}
$paym['payment']=1;
$PDO->sqlquery("rs",'affilation',$paym,'pid',$_GET['uid']);
/*$ps['lid']=$_GET['uid'];

$ps['sentBy']=$_SESSION["AMD"][0];

$ps['status']=12;

$ps['type']=51;
$PDO->sqlquery("rs",'pms_activity',$ps);*/


$ADMIN->sessset('Record has been saved!', 's');

$RW->redir($ADMIN->iurl($comp.'&mode=edit&uid='.$uid.(($start)?'&start='.$start:'').(($followup)?'&followup='.$followup:'')), true); 
}

if(isset($_POST['quickemail'])){
	
	$ps['comment']=$_POST['comment'];
	$ps['subject']=$_POST['subject'];
	$ps['lid']=$_GET['uid'];
	$ps['sentBy']=$_SESSION["AMD"][0];
	$ps['status']=22;
	$ps['type']=29;
	$PDO->sqlquery("rs",'pms_activity',$ps);
	
	
	$mailbody='<table cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td><table cellpadding="0" cellspacing="0" style="margin:auto; width:600px; font-size:16px; line-height:24px; font-family:Verdana, Geneva, sans-serif"><tbody><tr><td><table cellpadding="5" cellspacing="0" width="100%"><tbody><tr><td><a href="https://www.registrationwala.com"><img alt="Registrationwala.com" height="38" src="https://www.registrationwala.com/images/emailer/logonrw.png" width="109" /></a></td><td align="right"><a href="https://www.facebook.com/registrationwala/" style="margin:0 5px;" target="_blank"><img alt="Like On Facebook" height="27" src="https://www.registrationwala.com/images/emailer/facebookc.png" width="27" /></a><a href="https://twitter.com/Registrationwla" style="margin:0 5px;" target="_blank"><img alt="Like On Twitter" height="27" src="https://www.registrationwala.com/images/emailer/twitterc.png" width="27" /></a><a href="https://plus.google.com/u/0/115063389280026230269/posts" style="margin:0 5px;" target="_blank"><img alt="Like On Google plus" height="27" src="https://www.registrationwala.com/images/emailer/g-plusc.png" width="27" /></a></td></tr></tbody></table></td></tr><tr><td><table cellpadding="15" cellspacing="0" width="100%"><tbody><tr><td style="border:1px solid #ccc; background:url(https://www.registrationwala.com/images/emailer/drop-mark.png) no-repeat top left 10px;"><table cellpadding="5" cellspacing="0" width="100%"><tbody><tr><td style="padding:10px 20px;"><p style="padding-left:25px; margin:8px; font-size:20px;"> Greetings from Registrationwala.com	</p></td></tr> <tr><td  style="padding:10px 20px;"><p style="padding-left:10px; margin:0"> Dear, '.$_POST["name"].'</p></td></tr><tr><td><table cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td style="padding:10px 20px;"><p style="margin:10px 0; text-align:justify; line-height:24px;"> '.$_POST["comment"].'</p></td></tr></tbody></table></td></tr><tr><td style="padding:15px 10px;"><h4 style="margin:0 0 20px 0; padding:0;text-align:center; text-transform:uppercase;"> FOR any guidance feel free to reach us</h4></td></tr><tr><td style="padding:20px 30px 0 30px;color:#00293c;">	'.$RW->emailSignature($ADMIN->user_type($_SESSION["AMD"][3])).'</td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table>';
//echo $mailbody; exit;
         $to=$_POST["email"];
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: Registrationwala <support@registrationwala.com>' . "\r\n";
		
		$headers .= 'Reply-To:support@registrationwala.com,vikram@registrationwala.com,mayank@registrationwala.com,cagauravbansal1@gmail.com,' .$_SESSION["AMD"][2]."\r\n";
	    $headers .= 'Cc: support@registrationwala.com,vikram@registrationwala.com,mayank@registrationwala.com,cagauravbansal1@gmail.com,' .$_SESSION["AMD"][2]. "\r\n";
		$subject=$_POST['subject'];
		$mails=mail($to, $subject, $mailbody, $headers, '-fsupport@registrationwala.com');
	
  $ADMIN->sessset('e-mail has been sent to '.$_POST["name"].'!', 's');
$RW->redir($ADMIN->iurl($comp.'&mode=edit&uid='.$uid.(($start)?'&start='.$start:'').(($followup)?'&followup='.$followup:'')), true); }


if(isset($_POST['allocatelead'])){
if(isset($_POST['ohid'])){
$ps['salesmid']=$_POST['salesmid'];

$ps['ohid']=$_POST['ohid'];

$ps['salesecutiveid']=$_POST['salesecutiveid'];

$PDO->sqlquery("rs",'affilation',$ps,'pid',$_GET['uid']);

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

$PDO->sqlquery("rs",'affilation',$ps,'pid',$_GET['uid']);

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

$PDO->sqlquery("rs",'affilation',$ps,'pid',$_GET['uid']);

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

$PDO->sqlquery("rs",'affilation',$ps,'pid',$_GET['uid']);

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

$ps['comment']=$_POST['comment'];

$ps['type']=$_POST['type'];

$ps['lid']=$_GET['uid'];

$ps['sentBy']=$_SESSION["AMD"][0];

$ps['status']=0;

if($followup){

$follow['fstatus']=1;

$PDO->sqlquery("rs",'pms_activity',$follow,'pid',$_GET['followup']);	

}

$PDO->sqlquery("rs",'pms_activity',$ps);

$lead['status']=4;

$PDO->sqlquery("rs",'affilation',$lead,'pid',$_GET['uid']);

$ADMIN->sessset('Record has been saved!', 's');

$RW->redir($ADMIN->iurl($comp.'&mode=edit&uid='.$uid.(($start)?'&start='.$start:'').(($followup)?'&followup='.$followup:'')), true); 
}

if(isset($_POST['escalate'])){

$ps['comment']=$_POST['comment'];

$ps['lid']=$_GET['uid'];

$ps['sentBy']=$_SESSION["AMD"][0];

$ps['status']=8;

$ps['type']=33;

$PDO->sqlquery("rs",'pms_activity',$ps);

$lead['esclate']=1;

$PDO->sqlquery("rs",'affilation',$lead,'pid',$_GET['uid']);



$mailbody='<table width="100%" cellpadding="0" cellspacing="0"><tr><td><table style="margin:auto; width:600px; font-size:16px; line-height:24px; font-family:Verdana, Geneva, sans-serif" cellpadding="0" cellspacing="0"><tr><td><table width="100%" cellpadding="5" cellspacing="0"><tr><td><a href="https://www.registrationwala.com"><img src="https://www.registrationwala.com/images/emailer/logonrw.png" width="109" height="38" alt="Registrationwala.com" /></a></td><td align="right"><a style="margin:0 5px;" href="https://www.facebook.com/registrationwala/" target="_blank"><img src="https://www.registrationwala.com/images/emailer/facebookc.png" width="27" height="27" alt="Like On Facebook" /></a><a style="margin:0 5px;" href="https://twitter.com/Registrationwla" target="_blank"><img src="https://www.registrationwala.com/images/emailer/twitterc.png" width="27" height="27" alt="Like On Twitter" /></a><a style="margin:0 5px;" href="https://plus.google.com/u/0/115063389280026230269/posts" target="_blank"><img src="https://www.registrationwala.com/images/emailer/g-plusc.png" width="27" height="27" alt="Like On Google plus" /></a></td></tr></table></td></tr><tr><td><table width="100%" cellpadding="15" cellspacing="0"><tr><td style="border:1px solid #ccc;"><table width="100%" cellpadding="5" cellspacing="0"><tr><td style="padding:10px 20px; background-color:#00293c; color:#fff;" bgcolor="#00293c"><p style="padding-left:10px; margin:0">Dear Team,</p></td></tr><tr><td><table width="100%" cellpadding="0" cellspacing="0"><tr><td style="padding:10px 20px;"><p style="margin:10px 0; text-align:justify; line-height:24px;">Ticket no '.$rwi.' has been need Escalation. Details are given below;</p></td></tr><tr><td style="padding:10px 20px;"><p style="margin:10px 0; text-align:justify; line-height:24px; color:#00293c;"><strong>Ticket Number: '.$rwi.'</strong></p></td></tr>

<tr><td style="padding:10px 20px;"><p style="margin:10px 0; text-align:justify; line-height:24px; color:#00293c;"><strong>Request By: '.$_SESSION["AMD"][1].'</strong></p></td></tr>

<tr><td style="padding:10px 20px;"><p style="margin:10px 0; text-align:justify; line-height:24px; color:#00293c;"><strong>Client Name: '.$name.'</strong></p></td></tr>

<tr><td style="padding:10px 20px;"><p style="margin:10px 0; text-align:justify; line-height:24px; color:#00293c;"><strong>Client Email: '.$email.'</strong></p></td></tr>

<tr><td style="padding:10px 20px;"><p style="margin:10px 0; text-align:justify; line-height:24px; color:#00293c;"><strong>Service: '.$PDO->getSingleresult("select name from #_product_manager where pid='".$service."'").'</strong></p></td></tr>

</table></td></tr><tr><td style="padding:5px 20px;background-color:#00293c;color:#fff" bgcolor="#00293c"><p style="padding-left:10px;margin:0"></p></td></tr>

<tr><td style="padding:15px 10px;">'.$RW->emailSignature($ADMIN->user_type($_SESSION["AMD"][3])).'</td></tr>

</table></td></tr></table></td></tr></table></td></tr></table>';





$to='support@registrationwala.com';

$headers  = 'MIME-Version: 1.0' . "\r\n";

$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

$headers .= 'From: Registrationwala <support@registrationwala.com>' . "\r\n";



$headers .= 'Reply-To:support@registrationwala.com,vikram@registrationwala.com,mayank@registrationwala.com,cagauravbansal1@gmail.com,' .$_SESSION["AMD"][2]."\r\n";

$headers .= 'Cc: support@registrationwala.com,vikram@registrationwala.com,mayank@registrationwala.com,cagauravbansal1@gmail.com,' .$_SESSION["AMD"][2]. "\r\n";

$subject='Escalation of Ticket Number '.$rwi. ' | Registrationwala';

$mails=mail($to, $subject, $mailbody, $headers, '-fsupport@registrationwala.com');



$ADMIN->sessset('Record has been saved!', 's');

$RW->redir($ADMIN->iurl($comp.'&mode=edit&uid='.$uid.(($start)?'&start='.$start:'').(($followup)?'&followup='.$followup:'')), true); 
}



if(isset($_POST['wastes'])){



$ps['comment']=$_POST['comment'];

$ps['lid']=$_GET['uid'];

$ps['sentBy']=$_SESSION["AMD"][0];

$ps['status']=1;

$ps['type']=$_POST['type'];

if($followup){

$follow['fstatus']=1;

$PDO->sqlquery("rs",'pms_activity',$follow,'pid',$_GET['followup']);	

}

$PDO->sqlquery("rs",'pms_activity',$ps);

$lead['status']=2;

$PDO->sqlquery("rs",'affilation',$lead,'pid',$_GET['uid']);

$ADMIN->sessset('Record has been saved!', 's');

$RW->redir($ADMIN->iurl($comp.'&mode=edit&uid='.$uid.(($start)?'&start='.$start:'').(($followup)?'&followup='.$followup:'')), true); 
}

if(isset($_POST['followups'])){



$ps['comment']=$_POST['comment'];

$ps['lid']=$_GET['uid'];

$ps['sentBy']=$_SESSION["AMD"][0];

$ps['status']=2;

$ps['type']=$_POST['type'];

$ps['dates']=$_POST['dates'];

$ps['times']=$_POST['times'];

$ps['reminder']=$_POST['reminder'];

if($followup){

$follow['fstatus']=1;

$PDO->sqlquery("rs",'pms_activity',$follow,'pid',$_GET['followup']);	

}

$PDO->sqlquery("rs",'pms_activity',$ps);

$lead['status']=3;

$PDO->sqlquery("rs",'affilation',$lead,'pid',$_GET['uid']);

$ADMIN->sessset('Record has been saved!', 's');

$RW->redir($ADMIN->iurl($comp.'&mode=edit&uid='.$uid.(($start)?'&start='.$start:'').(($followup)?'&followup='.$followup:'')), true); 
}

if(isset($_POST['meetings'])){



$ps['comment']=$_POST['comment'];

$ps['lid']=$_GET['uid'];

$ps['sentBy']=$_SESSION["AMD"][0];

$ps['status']=3;

if($followup){

$follow['fstatus']=1;

$PDO->sqlquery("rs",'pms_activity',$follow,'pid',$_GET['followup']);	

}

$ps['type']=$_POST['type'];

$PDO->sqlquery("rs",'pms_activity',$ps);

$lead['status']=4;

$PDO->sqlquery("rs",'affilation',$lead,'pid',$_GET['uid']);

$ADMIN->sessset('Record has been saved!', 's');

$RW->redir($ADMIN->iurl($comp.'&mode=edit&uid='.$uid.(($start)?'&start='.$start:'').(($followup)?'&followup='.$followup:'')), true); 
}

if(isset($_POST['proposals'])){

$ps['comment']=$_POST['comment'];

$ps['lid']=$_GET['uid'];

$ps['sentBy']=$_SESSION["AMD"][0];

$ps['status']=4;

if($followup){

$follow['fstatus']=1;

$PDO->sqlquery("rs",'pms_activity',$follow,'pid',$_GET['followup']);	

}

$ps['type']=$_POST['type'];

$PDO->sqlquery("rs",'pms_activity',$ps);

$lead['status']=4;

$PDO->sqlquery("rs",'affilation',$lead,'pid',$_GET['uid']);

$ADMIN->sessset('Record has been saved!', 's');

$RW->redir($ADMIN->iurl($comp.'&mode=edit&uid='.$uid.(($start)?'&start='.$start:'').(($followup)?'&followup='.$followup:'')), true); 
}

if(isset($_POST['payments'])){

$ps['comment']=$_POST['comment'];

$ps['lid']=$_GET['uid'];

$ps['sentBy']=$_SESSION["AMD"][0];

$ps['status']=28;

if($followup){

$follow['fstatus']=1;

$PDO->sqlquery("rs",'pms_activity',$follow,'pid',$_GET['followup']);	

}

$ps['type']=$_POST['type'];

$PDO->sqlquery("rs",'pms_activity',$ps);

$lead['status']=2;

$PDO->sqlquery("rs",'affilation',$lead,'pid',$_GET['uid']);

$ADMIN->sessset('Record has been saved!', 's');

$RW->redir($ADMIN->iurl($comp.'&mode=edit&uid='.$uid.(($start)?'&start='.$start:'').(($followup)?'&followup='.$followup:'')), true); 
}

if(isset($_POST['invoices'])){

$ps['comment']=$_POST['comment'];

$ps['lid']=$_GET['uid'];

$ps['sentBy']=$_SESSION["AMD"][0];

$ps['status']=6;

if($followup){

$follow['fstatus']=1;

$PDO->sqlquery("rs",'pms_activity',$follow,'pid',$_GET['followup']);	

}

$ps['type']=$_POST['type'];

$PDO->sqlquery("rs",'pms_activity',$ps);

$lead['status']=5;

$PDO->sqlquery("rs",'affilation',$lead,'pid',$_GET['uid']);

$ADMIN->sessset('Record has been saved!', 's');

$RW->redir($ADMIN->iurl($comp.'&mode=edit&uid='.$uid.(($start)?'&start='.$start:'').(($followup)?'&followup='.$followup:'')), true); 
}

/*start send Porposal */

if(isset($_POST['psend'])){
	//print_r($_POST);  exit;
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
	$PDO->sqlquery("rs",'affilation',$lead,'pid',$_GET['uid']);
  
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
		
		$headers .= 'Reply-To:support@registrationwala.com,vikram@registrationwala.com,mayank@registrationwala.com,cagauravbansal1@gmail.com,' .$_SESSION["AMD"][2]."\r\n";
	    $headers .= 'Cc: support@registrationwala.com,vikram@registrationwala.com,mayank@registrationwala.com,cagauravbansal1@gmail.com,' .$_SESSION["AMD"][2]. "\r\n";
		$subject='Thank You for Requesting Proposal for '.$mres['name'].' | Registrationwala.com';
		$mails=mail($to, $subject, $msgf1, $headers, '-fsupport@registrationwala.com');
 $ADMIN->sessset('proposal has been sent to '.$_POST['name'], 's');

$RW->redir($ADMIN->iurl($comp.'&mode=edit&uid='.$uid.(($start)?'&start='.$start:'').(($subpage_id)?'&subpage_id='.$subpage_id:'')), true); 
   
	
	
	}

/*end send Porposal */
/*start  send payment link */

if(isset($_POST['paylink'])){

//print_r($_POST);  exit;

$ps['lid']=$_POST['leadid'];	

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
					 $data['user_id']=$row['pid'];
					}else{
						$data['password']='RW@'.rand(100, 999);
						$data['user_id'] = $PDO->sqlquery("rs","site_users",$data);
						
						}
			
				$data['created_on']=date('Y-m-d H:i:s');
				$data['create_by']=$_SESSION["AMD"][0];
				$data['lid']=$uid;
				$data['servicename']='Payment Request';
				$customeorderid=$PDO->sqlquery("rs","custom_payments",$data);
				$cpi['cpid']=$customeorderid;
				$PDO->sqlquery("rs",'pms_activity',$cpi,'pid',$cpid);	
				$serviceName=$PDO->getsingleresult("select name from #_product_manager where pid='".$service."'");
			
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
                              <td bgcolor="#00293c" style="padding:10px 20px; background-color:#00293c; color:#fff;"><p style="padding-left:10px; margin:0"> Dear, '.$name.'</p></td>
                            </tr>
                            <tr>
                              <td><table cellpadding="0" cellspacing="0" width="100%">
                                  <tbody>
                                    <tr>
                                      <td style="padding:10px 20px;"><p style="margin:10px 0; text-align:justify; line-height:24px;"> We are glad that you choose our Trademark Registration service. You are requested to make the payment of Rs 6000 in order to ensure fast-track processing of you request.</p></td>
                                    </tr>
                                    <tr>
                                      <td style="padding:10px 20px;"><p style="margin:10px 0; text-align:justify; line-height:24px; color:#00293c;"> <strong>Service: '.$serviceName.'</strong></p></td>
                                    </tr>
                                    <tr>
                                      <td style="padding:10px 20px;"><p style="margin:10px 0; text-align:center; line-height:24px; color:#00293c;"> <a href="" style="display:inline-block; padding:10px 50px; color:#fff; font-weight:bold; background:#00293c; text-decoration:none;">Rs. '.$amount.'/-</a></p></td>
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

         $to=$email;
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: Registrationwala <support@registrationwala.com>' . "\r\n";
		
		$headers .= 'Reply-To:support@registrationwala.com,vikram@registrationwala.com,mayank@registrationwala.com,cagauravbansal1@gmail.com,' .$_SESSION["AMD"][2]."\r\n";
	    $headers .= 'Cc: support@registrationwala.com,vikram@registrationwala.com,mayank@registrationwala.com,cagauravbansal1@gmail.com,' .$_SESSION["AMD"][2]. "\r\n";
		$subject='Payment Request from Registrationwala | '.$serviceName.' | '.$leadid;
		$mails=mail($to, $subject, $mailbody, $headers, '-fsupport@registrationwala.com');
		$st['status']=5;
$PDO->sqlquery("rs",'affilation',$st,'pid',$_GET['uid']);	
	
$ADMIN->sessset('Payment link has been sent to '.$_POST['name'], 's');

$RW->redir($ADMIN->iurl($comp.'&mode=edit&uid='.$uid.(($start)?'&start='.$start:'').(($followup)?'&followup='.$followup:'')), true); 


}

/*end send payment link */

if(isset($_POST['steps'])){ 
$query =$PDO->db_query("select * from #_affilation where pid ='".$uid."' "); 
$row = $PDO->db_fetch_array($query);
@extract($row);	
if($_POST['dscDelivered']=='1'){
$leadss['completed_on']=date('Y-m-d H:i:s');
}
$leadss['processStatus']=$_POST['processStatus'];
$PDO->sqlquery("rs",'affilation',$leadss,'pid',$uid);	
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

$headers .= 'From: Registrationwala <support@registrationwala.com>' . "\r\n";



$headers .= 'Reply-To:vikram@registrationwala.com,mayank@registrationwala.com,incorporation@registrationwala.com,' .$_SESSION["AMD"][2]."\r\n";

$headers .= 'Cc: vikram@registrationwala.com,mayank@registrationwala.com,incorporation@registrationwala.com,' .$_SESSION["AMD"][2]."\r\n";

$subject=$_POST['payment_subject'];

$mails=mail($to, $subject, $_POST['content'], $headers, '-fsupport@registrationwala.com');
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
$PDO->sqlquery("rs",'affilation',$pst,'pid',$uid);
}	
if($uid)

{

if($_POST['markassell']=='1'){

if($PDO->getsingleresult("select markassell from #_affilation where pid='".$uid."'")!='1'){

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
$invocieAmiount=$PDO->getSingleresult("select sum(hmaintotal) from #_invoice where lid='".$pid."'");
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
        <h2>Invoice : Rs <?=$invocieAmiount;?>	 </h2>
      </div>
         <div class="col">
        <h2>Cost : Rs <?=$costAmiount;?></h2>
      </div>
         <div class="col">
        <h2>Profit : Rs <?=$invocieAmiount-$costAmiount?>	 </h2>
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
              <li> <i class="fa fa-globe" aria-hidden="true"></i>
                 <?=$PDO->getSingleresult("select name from #_india_cities where pid='".$cityID."' and status=1").', '.$PDO->getSingleresult("select name from #_country_manager where pid='".$countryID."' and status=1")?>
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
$services=$PDO->getSingleresult("select name from #_product_manager where pid='".$service."'");
if($deptType==4){$nn=8;}elseif($deptType==5){$nn=12;}elseif($deptType==6){$nn=16;}
			   ?>
              <div class="col-sm-6">Score:
                <?=$scores?>
              </div>
            </div>
          </div>
          <div class="lead-left-sidebar">
            <h4 class="head">Lead Properties </h4>
            <ul class="list-unstyled text-bold">
              <li> Source <span class="pull-right">
                <?=$PDO->getSingleresult("select name from #_lead_source where pid='".$source."'")?>
                </span></li>
              <li> Lead age <span class="pull-right">
                <?php  $start =strtotime(date('Y-m-d',strtotime($created_on))) ;
 $end = strtotime(date('Y-m-d'));

echo $days_between = ceil(abs($end - $start) / 86400); ?>
                Days</span></li>
              <li> Potential <span class="pull-right">Rs
                <?=$PDO->getSingleresult("select price from #_product_manager where pid='".$service."'")?>
                </span></li>
                
                 
                <li> Lead Stage <span class="pull-right"><?=$PDO->getSingleresult("select name from #_lead_stage where pid='".$status."'")?></span></li>
                <li> Lead Owner <span class="pull-right"><?=$PDO->getSingleresult("select name from pms_admin_users where user_id='".$salesecutiveid."'")?> </span></li>
  
                
                <li> Work Status <span class="pull-right"><?=$worksttus==''?'N/A':$worksttus?></span></li>
                 <li> Order Status <span class="pull-right"><?=$worksttus==$nn?'Completed':'Open'?></span></li>
                
                
                
                
            </ul>
          </div>
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
                              <input type="text" name="email" class="validate[required] form-control" value="<?=$email?>" readonly="readonly" >
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
                <?=$PDO->getSingleresult("select count(*) from #_plinksent where lid='".$rwi."'")?>
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
                              <input type="text" name="email" class="validate[required] form-control" value="<?=$email?>" readonly="readonly" >
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
                              <input type="text" name="email" class="validate[required] form-control" value="<?=$email?>" readonly="readonly" >
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

              
              
              
              
              
             <!-- <a href="javascript:void(0)"  data-toggle="modal" data-target="#Escalation" >
              <li class="btn-danger btn text-white " > Escalation </li>-->
              </a>
          <?php
					   if (!in_array($_SESSION["AMD"][3], array("5", "4",))){ ?>    
            <a href="javascript:void(0)"   data-toggle="modal" data-target="#Allocate"><li class="btn-info btn text-white" > Allocate </li>
              </a>
              <?php } ?>
            </ul>
            <form name="esc" method="post" enctype="multipart/form-data">
            <div class="modal fade" id="Escalation">
              <div class="modal-dialog modal-md">
                <div class="modal-content"> 
                  
                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title p-0 m-0" >Escalation</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  
                  <!-- Modal body -->
                  <div class="modal-body">
                    <div class="">
                      <div class="row">
                        <div class="col-12 col-md-12">
                          <h3 class="m-0 p-0 mb-2">Lead <?=$rwi?> </h3>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12">
                          <div class="form-group">
                            <label>Issue for Escalation</label>
                            <textarea name="comment" class="form-control validate[required]" placeholder=" Type reason for escalation"/></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Modal footer -->
                  <div class="modal-footer">
                    <button type="submit" name="escalate" class="btn btn-info" >Escalate</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
            </form>
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
               <li class="nav-item"> <a href="#AdditionalReq" data-target="#" data-toggle="tab" class="nav-link">Additional Req.</a> </li>
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
                        <th>Status</th>
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
                        <td><?=$pay_rows['status']==0?'Not Verified':'Verified'?></td>
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
                                  <div class="row">
                                    
                                  </div>
                                  <script>
                  $(document).ready(function () {
    $('#outer').change(function(){
        if($('#outer').val() == '0') {
			$('#ttext').text('Received By'); 
        } 
		else  if($('#outer').val() == '2') {
			$('#ttext').text('Transaction No');	
        }   
		else  if($('#outer').val() == '3') {
			$('#ttext').text('Reference No');	
        } 
		
		else {
			$('#ttext').text('Cheque No');
			
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
              <div class="p-3" data-role="dynamic-fields">
              <?php
			  $adrqRow=$PDO->getResult("select * from #_crequirement where lid='".$_GET['uid']."'");
			  $serviceprice=explode(':',$adrqRow['serviceprice']);
			  $serviceid=explode(':',$adrqRow['serviceid']);
			  $serviceidprive=array_combine($serviceid,$serviceprice);
			 if(count($serviceidprive)>0){
				foreach($serviceidprive as $sid=>$sprice){
				 ?>
                  <div class="row addcontainer">
                    <div class="col col-md-6">
                     <label for="" class="text-left col-12"> Select Service</label>
                      <div class="form-group">
                        <select name="serviceid[]" class="validate[required] form-control col-md-8" data-errormessage-value-missing="Service is required!">
                              <option value="">-------select service------</option>
                              <?php 
 $service_query = $PDO->db_query("select * from #_product_manager where status='1'");
                while($service_rows = $PDO->db_fetch_array($service_query)){ ?>
                              <option value="<?=$service_rows['pid']?>" <?=($service_rows['pid']==$sid)?'selected="selected"':''?>  >
                              <?=$service_rows['name']?>
                              </option>
                              <?php } ?>
                            </select>  
                          </div>
                       </div>
                    <div class="col col-md-4">
                     <label for="" class="text-left col-12">Service selling price</label>
                      <div class="form-group">
                             <input type="text" name="serviceprice[]" class="validate[required] form-control" value="<?=$sprice?>" >
                          </div>    
                        </div>
                    <div class="col col-md-2">
                    <label for="" class="text-left col-12">&nbsp;</label>
                      <div class="form-group">
                            <button class="btn btn-sm btn-danger ml-1  mb-1 mr-1" data-role="remove"> <i class="fa fa-minus"></i> </button>
                            <button class="btn btn-sm btn-primary  mb-1" data-role="add"> <i class="fa fa-plus"></i> </button>
                          </div>    
                        </div>    
                      </div>
			<?php } }else{?>
                  <div class="row addcontainer">
                  <label for="" class="text-left col-12"> Select Service</label>
                    <div class="col col-md-6">
                      <div class="form-group">
                        <select name="serviceid[]" class="validate[required] form-control col-md-8" data-errormessage-value-missing="Service is required!">
                              <option value="">-------select service------</option>
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
                    <div class="col col-md-4">
                      <div class="form-group">
                             <input type="text" name="serviceprice[]" class="validate[required] form-control" value="<?=$serviceprice?>" >
                          </div>    
                        </div>
                    <div class="col col-md-2">
                      <div class="form-group">
                            <button class="btn btn-sm btn-danger ml-1  mb-1 mr-1" data-role="remove"> <i class="fa fa-minus"></i> </button>
                            <button class="btn btn-sm btn-primary  mb-1" data-role="add"> <i class="fa fa-plus"></i> </button>
                          </div>    
                        </div>    
                      </div>
                <?php }?>
                </div>
                <div class="form-group text-right">
                      <button type="submit" name="additionalReq" class="btn btn-sm btn-primary mr-5" >Submit </button>
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
                        <td><?=$PDO->getSingleresult("select name from #_product_manager where pid='".$service."'")?></td>
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
           <td>Rs <?=$invoiceRow['hmaintotal']?></td>
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
                <?php $deptType=$PDO->getsingleresult("select dpid from #_product_manager where pid='".$service."'");
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
                          <?php }else if($act_rows['status']==28){echo 'http://www.registrationwala.com/order?customuid='.$act_rows['cpid'];}else{ ?>
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



			url: '<?=SITE_PATH_ADM._MODS.'/affilation/'?>send.php',



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
          new_field_group.find('label').html('Select Service'); new_field_group.find('input, select, textarea').each(function(){
                $(this).val('');
            });
            container.append(new_field_group);
        }
    );
});
    </script>