<?php 

include(FS_ADMIN._MODS."/crms/crms.inc.php");

$PAGS = new Pages();



if($RW->is_post_back())

{
$query =$PDO->db_query("select * from #_".tblName." where pid ='".$uid."' "); 
$row = $PDO->db_fetch_array($query);
@extract($row);
if(isset($_POST['additionalReq'])){
$_POST['lid']=$_GET['uid'];
$_POST['create_by']=$_SESSION["AMD"][0];
$_POST['status']=1;
$checkadrq=$PDO->db_query("select lid from #_crequirement_crms where lid='".$_GET['uid']."'");
if($checkadrq->rowCount()>0){
$PDO->sqlquery("rs",'crequirement_crms',$_POST,'lid',$_GET['uid']);
}else{
$PDO->sqlquery("rs",'crequirement_crms',$_POST);
}
$ADMIN->sessset('Record has been saved!', 's');

$RW->redir($ADMIN->iurl($comp.'&mode=edit&uid='.$uid.(($start)?'&start='.$start:'').(($followup)?'&followup='.$followup:'')), true); }
if(isset($_POST['paymentpay'])){

$_POST['lid']=$_GET['uid'];

$_POST['sentBy']=$_SESSION["AMD"][0];

$_POST['status']=6;

$PDO->sqlquery("rs",'paymentdetails_crms',$_POST);
/*$paydate=$PDO->getSingleresult("select paymentDate from #_crms where pid='".$uid."'");
if($paydate=='0000-00-00 00:00:00'){
$paym['paymentDate']=date('Y-m-d H:i:s');
	}
$paym['payment']=1;
$PDO->sqlquery("rs",'crms',$paym,'pid',$_GET['uid']);*/
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

$ps['taxhead']=$_POST['taxhead'];
$ps['taxexe']=$_POST['taxexe'];
$ps['inchead']=$_POST['inchead'];
$ps['incexe']=$_POST['incexe'];
$PDO->sqlquery("rs",'crms',$ps,'pid',$_GET['uid']);
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

$PDO->sqlquery("rs",'crms',$lead,'pid',$_GET['uid']);

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

$PDO->sqlquery("rs",'crms',$lead,'pid',$_GET['uid']);

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
	$PDO->sqlquery("rs",'crms',$lead,'pid',$_GET['uid']);
  
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

$PDO->sqlquery("rs",'plinksent_crms',$ps);

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
$PDO->sqlquery("rs",'crms',$st,'pid',$_GET['uid']);	
	
$ADMIN->sessset('Payment link has been sent to '.$_POST['name'], 's');

$RW->redir($ADMIN->iurl($comp.'&mode=edit&uid='.$uid.(($start)?'&start='.$start:'').(($followup)?'&followup='.$followup:'')), true); 


}

/*end send payment link */



if(isset($_POST['projectStatus'])){
	//print_r($_POST); exit;
				/*For OC*/
			
			   sort($_POST[ocid]);
			   $cc=0;
			   foreach($_POST[processOC] as $procesOC){
				
				  $posts[pid]=$_POST[ocid][$cc];
				  $posts[process]=$procesOC;
				  $posts[work]=$_POST[workOC][$cc];
				  $posts[executiveid]=$_POST[executiveidOC][$cc];
				  $posts[status]=$_POST[statusOC][$cc];
				 // echo $proces;
				 $PDO->sqlquery("rs",'oc',$posts,'pid',$posts[pid]); 
				  $cc++; }
				  
		$pathOc = UP_FILES_FS_PATH."/oc1doc/";
	
	if($_FILES['uploadOC-1'][name]){
	if ($_FILES['uploadOC-1']['error']== 0) {	           
	// No error found! Move uploaded files 
	$fname=mt_rand(10,999).'_'.$_FILES['uploadOC-1']['name'];
	
	if(move_uploaded_file($_FILES["uploadOC-1"]["tmp_name"], $pathOc.$fname)) {
	$_POST['oc1doc']=$fname; 
	$PDO->db_query("update #_oc set document='".$_POST['oc1doc']."' where process='oc-1' and complianceId='".$uid."'"); 
	}else {echo 'uploading failed'; exit; }
	}
	
	
	}
	
	if($_FILES['uploadOC-2'][name]){
	
  
	if ($_FILES['uploadOC-2']['error']== 0) {	           
	// No error found! Move uploaded files 
	$fname=mt_rand(10,999).'_'.$_FILES['uploadOC-2']['name'];
	
	if(move_uploaded_file($_FILES["uploadOC-2"]["tmp_name"], $pathOc.$fname)) {
	$_POST['oc2doc']=$fname; 
	 $PDO->db_query("update #_oc set document='".$_POST['oc2doc']."' where process='oc-2' and complianceId='".$uid."'"); 
	}else {echo 'uploading failed'; exit; }
	}
	
	
	}
	
	if($_FILES['uploadOC-3'][name]){
	
  
	if ($_FILES['uploadOC-3']['error']== 0) {	           
	// No error found! Move uploaded files 
	$fname=mt_rand(10,999).'_'.$_FILES['uploadOC-3']['name'];
	
	if(move_uploaded_file($_FILES["uploadOC-3"]["tmp_name"], $pathOc.$fname)) {
	echo $_POST['oc3doc']=$fname; 
	 $PDO->db_query("update #_oc set document='".$_POST['oc3doc']."' where process='oc-3' and complianceId='".$uid."'"); 
	}else {echo 'uploading failed'; exit; }
	}
	
	
	}
	
	if($_FILES['uploadOC-4'][name]){
	
  
	if ($_FILES['uploadOC-4']['error']== 0) {	           
	// No error found! Move uploaded files 
	$fname=mt_rand(10,999).'_'.$_FILES['uploadOC-4']['name'];
	
	if(move_uploaded_file($_FILES["uploadOC-4"]["tmp_name"], $pathOc.$fname)) {
	$_POST['oc4doc']=$fname; 
	 $PDO->db_query("update #_oc set document='".$_POST['oc4doc']."' where process='oc-4' and complianceId='".$uid."'"); 
	}else {echo 'uploading failed'; exit; }
	}
	
	
	}
		if($_POST[commentOC]!=''){
	$POST[commentsp]=$_POST[commentOC];
	$POST[userid]=$_SESSION["AMD"][0];
	$POST[complianceId]=$_GET[uid];
	$POST[process]='oc';
	$PDO->sqlquery("rs",'complianceComment',$POST);
		}
		/*END OC*/
		
		/*FOR QC*/
		
		 /*part 1*/
			   sort($_POST[pidqc1]);
			   $countQC=0;
			   foreach($_POST[processqc1] as $procesqc1){
				  
				  $QC1[pidqc1]=$_POST[pidqc1][$countQC];
				  $QC1[process]=$procesqc1;
				  $QC1[processtype]=$_POST[processtypeqc1][$countQC];
				  $QC1[work]=$_POST[workqc1][$countQC];
				  $QC1[executiveid]=$_POST[executiveidqc1][$countQC];
				  $QC1[status]=$_POST[statusQC1][$countQC];
				
				 $PDO->sqlquery("rs",'qc',$QC1,'pid',$QC1[pidqc1]); 
				  $countQC++; }
				  
 $pathQC = UP_FILES_FS_PATH."/qcdoc/";
	
	if($_FILES['uploadQC-1A'][name]){
		
	if ($_FILES['uploadQC-1A']['error']== 0) {	 
	$fname=mt_rand(10,999).'_'.$_FILES['uploadQC-1A']['name'];
	
	if(move_uploaded_file($_FILES["uploadQC-1A"]["tmp_name"], $pathQC.$fname)) {
	$_POST['qc1Adoc']=$fname; 
	$PDO->db_query("update #_qc set document='".$_POST['qc1Adoc']."' where processtype='QC-1' and process='A' and complianceId='".$uid."'"); 

	}else {echo 'uploading failed'; exit; }
	}}
	
	if($_FILES['uploadQC-1B'][name]){
	if ($_FILES['uploadQC-1B']['error']== 0) {	
	$fname=mt_rand(10,999).'_'.$_FILES['uploadQC-1B']['name'];
	
	if(move_uploaded_file($_FILES["uploadQC-1B"]["tmp_name"], $pathQC.$fname)) {
	$_POST['qc1Bdoc']=$fname; 
	$PDO->db_query("update #_qc set document='".$_POST['qc1Bdoc']."' where processtype='QC-1' and process='B' and complianceId='".$uid."'"); 
	}else {echo 'uploading failed'; exit; }
	}}
	
	if($_FILES['uploadQC-1C'][name]){
  
	if ($_FILES['uploadQC-1C']['error']== 0) {	 
	$fname=mt_rand(10,999).'_'.$_FILES['uploadQC-1C']['name'];
	
	if(move_uploaded_file($_FILES["uploadQC-1C"]["tmp_name"], $pathQC.$fname)) {
	$_POST['qc1Cdoc']=$fname; 
	$PDO->db_query("update #_qc set document='".$_POST['qc1Cdoc']."' where processtype='QC-1' and process='C' and complianceId='".$uid."'"); 	
	}else {echo 'uploading failed'; exit; }
	}}
	
	if($_FILES['uploadQC-1D'][name]){
	if ($_FILES['uploadQC-1D']['error']== 0) {	
	$fname=mt_rand(10,999).'_'.$_FILES['uploadQC-1D']['name'];
	if(move_uploaded_file($_FILES["uploadQC-1D"]["tmp_name"], $pathQC.$fname)) {
	$_POST['qc1Ddoc']=$fname; 
	$PDO->db_query("update #_qc set document='".$_POST['qc1Ddoc']."' where processtype='QC-1' and process='D' and complianceId='".$uid."'"); 	
	}else {echo 'uploading failed'; exit; }
	}}
	
	   
                       /*part 2*/
			
			 sort($_POST[pidqc2]);
			   $countQC2=0;
			   foreach($_POST[processqc2] as $procesqc2){
				  
				  $QC2[pidqc2]=$_POST[pidqc2][$countQC2];
				  $QC2[process]=$procesqc2;
				  $QC2[processtype]=$_POST[processtypeqc2][$countQC2];
				  $QC2[work]=$_POST[workqc2][$countQC2];
				  $QC2[executiveid]=$_POST[executiveidqc2][$countQC2];
				  $QC2[status]=$_POST[statusQC2][$countQC2];
				
				 $PDO->sqlquery("rs",'qc',$QC2,'pid',$QC2[pidqc2]); 
				  $countQC2++; }		   
				
				if($_FILES['uploadQC-2A'][name]){
		
	if ($_FILES['uploadQC-2A']['error']== 0) {	
	$fname=mt_rand(10,999).'_'.$_FILES['uploadQC-2A']['name'];
	
	if(move_uploaded_file($_FILES["uploadQC-2A"]["tmp_name"], $pathQC.$fname)) {
	$_POST['qc2Adoc']=$fname; 
	$PDO->db_query("update #_qc set document='".$_POST['qc2Adoc']."' where processtype='QC-2' and process='A' and complianceId='".$uid."'"); 

	}else {echo 'uploading failed'; exit; }
	}}
	
	if($_FILES['uploadQC-2B'][name]){
	
  
	if ($_FILES['uploadQC-2B']['error']== 0) {	
	$fname=mt_rand(10,999).'_'.$_FILES['uploadQC-2B']['name'];
	
	if(move_uploaded_file($_FILES["uploadQC-2B"]["tmp_name"], $pathQC.$fname)) {
	$_POST['qc2Bdoc']=$fname; 
	$PDO->db_query("update #_qc set document='".$_POST['qc2Bdoc']."' where processtype='QC-2' and process='B' and complianceId='".$uid."'"); 
	}else {echo 'uploading failed'; exit; }
	}}
	
	if($_FILES['uploadQC-2C'][name]){
	
  
	if ($_FILES['uploadQC-2C']['error']== 0) {	
	$fname=mt_rand(10,999).'_'.$_FILES['uploadQC-2C']['name'];
	
	if(move_uploaded_file($_FILES["uploadQC-2C"]["tmp_name"], $pathQC.$fname)) {
	$_POST['qc2Cdoc']=$fname; 
	$PDO->db_query("update #_qc set document='".$_POST['qc2Cdoc']."' where processtype='QC-2' and process='C' and complianceId='".$uid."'"); 	
	}else {echo 'uploading failed'; exit; }
	}}
	
	if($_FILES['uploadQC-2D'][name]){
	
  
	if ($_FILES['uploadQC-2D']['error']== 0) {	
	$fname=mt_rand(10,999).'_'.$_FILES['uploadQC-2D']['name'];
	
	if(move_uploaded_file($_FILES["uploadQC-2D"]["tmp_name"], $pathQC.$fname)) {
	$_POST['qc2Ddoc']=$fname; 
	$PDO->db_query("update #_qc set document='".$_POST['qc2Ddoc']."' where processtype='QC-2' and process='D' and complianceId='".$uid."'"); 	
	}else {echo 'uploading failed'; exit; }
	}}
					   


/*part 3*/
          sort($_POST[pidqc3]);
			   $countQC3=0;
			   foreach($_POST[processqc3] as $procesqc3){
				  
				  $QC3[pidqc3]=$_POST[pidqc3][$countQC3];
				  $QC3[process]=$procesqc3;
				  $QC3[processtype]=$_POST[processtypeqc3][$countQC3];
				  $QC3[work]=$_POST[workqc3][$countQC3];
				  $QC3[executiveid]=$_POST[executiveidqc3][$countQC3];
				  $QC3[status]=$_POST[statusQC3][$countQC3];
				
				 $PDO->sqlquery("rs",'qc',$QC3,'pid',$QC3[pidqc3]); 
				  $countQC3++; }		   
				

if($_FILES['uploadQC-3A'][name]){
		
	if ($_FILES['uploadQC-3A']['error']== 0) {	
	$fname=mt_rand(10,999).'_'.$_FILES['uploadQC-3A']['name'];
	if(move_uploaded_file($_FILES["uploadQC-3A"]["tmp_name"], $pathQC.$fname)) {
	$_POST['qc3Adoc']=$fname; 
	 $PDO->db_query("update #_qc set document='".$_POST['qc3Adoc']."' where processtype='QC-3' and process='A' and complianceId='".$uid."'"); 

	}else {echo 'uploading failed'; exit; }
	}}
	
	if($_FILES['uploadQC-3B'][name]){
	
  
	if ($_FILES['uploadQC-3B']['error']== 0) {	
	$fname=mt_rand(10,999).'_'.$_FILES['uploadQC-3B']['name'];
	if(move_uploaded_file($_FILES["uploadQC-3B"]["tmp_name"], $pathQC.$fname)) {
	$_POST['qc3Bdoc']=$fname; 
	$PDO->db_query("update #_qc set document='".$_POST['qc3Bdoc']."' where processtype='QC-3' and process='B' and complianceId='".$uid."'"); 
	}else {echo 'uploading failed'; exit; }
	}}
	
	if($_FILES['uploadQC-3C'][name]){
	
  
	if ($_FILES['uploadQC-3C']['error']== 0) {	
	$fname=mt_rand(10,999).'_'.$_FILES['uploadQC-3C']['name'];
	if(move_uploaded_file($_FILES["uploadQC-3C"]["tmp_name"], $pathQC.$fname)) {
	$_POST['qc3Cdoc']=$fname; 
	$PDO->db_query("update #_qc set document='".$_POST['qc3Cdoc']."' where processtype='QC-3' and process='C' and complianceId='".$uid."'"); 	
	}else {echo 'uploading failed'; exit; }
	}}
	
	if($_FILES['uploadQC-3D'][name]){
  
	if ($_FILES['uploadQC-3D']['error']== 0) {	
	$fname=mt_rand(10,999).'_'.$_FILES['uploadQC-3D']['name'];
	if(move_uploaded_file($_FILES["uploadQC-3D"]["tmp_name"], $pathQC.$fname)) {
	$_POST['qc3Ddoc']=$fname; 
	$PDO->db_query("update #_qc set document='".$_POST['qc3Ddoc']."' where processtype='QC-3' and process='D' and complianceId='".$uid."'"); 	
	}else {echo 'uploading failed'; exit; }
	}}

/*part 4*/
               sort($_POST[pidqc4]);
			   $countQC4=0;
			   foreach($_POST[processqc4] as $procesqc4){
				  
				  $QC4[pidqc4]=$_POST[pidqc4][$countQC4];
				  $QC4[process]=$procesqc4;
				  $QC4[processtype]=$_POST[processtypeqc4][$countQC4];
				  $QC4[work]=$_POST[workqc4][$countQC4];
				  $QC4[executiveid]=$_POST[executiveidqc4][$countQC4];
				  $QC4[status]=$_POST[statusQC4][$countQC4];
				
				 $PDO->sqlquery("rs",'qc',$QC4,'pid',$QC4[pidqc4]); 
				  $countQC4++; }

if($_FILES['uploadQC-4A'][name]){
		
	if ($_FILES['uploadQC-4A']['error']== 0) {	
	$fname=mt_rand(10,999).'_'.$_FILES['uploadQC-4A']['name'];
	if(move_uploaded_file($_FILES["uploadQC-4A"]["tmp_name"], $pathQC.$fname)) {
	$_POST['qc4Adoc']=$fname; 
	$PDO->db_query("update #_qc set document='".$_POST['qc4Adoc']."' where processtype='QC-4' and process='A' and complianceId='".$uid."'"); 
	}else {echo 'uploading failed'; exit; }
	}}
	
	if($_FILES['uploadQC-4B'][name]){
	if ($_FILES['uploadQC-4B']['error']== 0) {	
	$fname=mt_rand(10,999).'_'.$_FILES['uploadQC-4B']['name'];
	if(move_uploaded_file($_FILES["uploadQC-4B"]["tmp_name"], $pathQC.$fname)) {
	$_POST['qc4Bdoc']=$fname; 
	$PDO->db_query("update #_qc set document='".$_POST['qc4Bdoc']."' where processtype='QC-4' and process='B' and complianceId='".$uid."'"); 
	}else {echo 'uploading failed'; exit; }
	}}
	
	if($_FILES['uploadQC-4C'][name]){
	if ($_FILES['uploadQC-4C']['error']== 0) {	
	$fname=mt_rand(10,999).'_'.$_FILES['uploadQC-4C']['name'];
	if(move_uploaded_file($_FILES["uploadQC-4C"]["tmp_name"], $pathQC.$fname)) {
	$_POST['qc4Cdoc']=$fname; 
	$PDO->db_query("update #_qc set document='".$_POST['qc4Cdoc']."' where processtype='QC-4' and process='C' and complianceId='".$uid."'"); 	
	}else {echo 'uploading failed'; exit; }
	}}
	
	if($_FILES['uploadQC-4D'][name]){
	if ($_FILES['uploadQC-4D']['error']== 0) {	
	$fname=mt_rand(10,999).'_'.$_FILES['uploadQC-4D']['name'];
	if(move_uploaded_file($_FILES["uploadQC-4D"]["tmp_name"], $pathQC.$fname)) {
	$_POST['qc4Ddoc']=$fname; 
	$PDO->db_query("update #_qc set document='".$_POST['qc4Ddoc']."' where processtype='QC-4' and process='D' and complianceId='".$uid."'"); 	
	}else {echo 'uploading failed'; exit; }
	}}
	
	if($_POST[commentQC]!=''){
	$POST[commentsp]=$_POST[commentQC];
	$POST[userid]=$_SESSION["AMD"][0];
	$POST[complianceId]=$_GET[uid];
	$POST[process]='qc';
	$PDO->sqlquery("rs",'complianceComment',$POST);
	}
		
		/*END QC*/
		
		
		/*FOR  AC*/
		
			   sort($_POST[pidAC]);
			   $ccAC=0;
			   foreach($_POST[processAC] as $procesAC){
				  
				  $AC[pidAC]=$_POST[pidAC][$ccAC];
				  $AC[process]=$procesAC;
				  $AC[work]=$_POST[workAC][$ccAC];
				  $AC[executiveid]=$_POST[executiveidAC][$ccAC];
				  $AC[status]=$_POST[statusAC][$ccAC];
				
				 $PDO->sqlquery("rs",'ac',$AC,'pid',$AC[pidAC]); 
				  $ccAC++; }
				  
		$pathAC = UP_FILES_FS_PATH."/acdoc/";
	
	if($_FILES['uploadA'][name]){
	if ($_FILES['uploadA']['error']== 0) {	
	$fname=mt_rand(10,999).'_'.$_FILES['uploadA']['name'];
	if(move_uploaded_file($_FILES["uploadA"]["tmp_name"], $pathAC.$fname)) {
	$_POST['docA']=$fname; 
	$PDO->db_query("update #_ac set document='".$_POST['docA']."' where process='A' and complianceId='".$uid."'"); 

	}else {echo 'uploading failed'; exit; }
	}}
	
	if($_FILES['uploadB'][name]){
	if ($_FILES['uploadB']['error']== 0) {	
	$fname=mt_rand(10,999).'_'.$_FILES['uploadB']['name'];
	if(move_uploaded_file($_FILES["uploadB"]["tmp_name"], $pathAC.$fname)) {
	$_POST['docB']=$fname; 
    $PDO->db_query("update #_ac set document='".$_POST['docB']."' where process='B' and complianceId='".$uid."'"); 

	}else {echo 'uploading failed'; exit; }
	}}
	if($_FILES['uploadC'][name]){
	if ($_FILES['uploadC']['error']== 0) {
	$fname=mt_rand(10,999).'_'.$_FILES['uploadC']['name'];
	if(move_uploaded_file($_FILES["uploadC"]["tmp_name"], $pathAC.$fname)) {
	$_POST['docC']=$fname; 
    $PDO->db_query("update #_ac set document='".$_POST['docC']."' where process='C' and complianceId='".$uid."'"); 

	}else {echo 'uploading failed'; exit; }
	}}
	
	if($_FILES['uploadD'][name]){
	if ($_FILES['uploadD']['error']== 0) {	 
	$fname=mt_rand(10,999).'_'.$_FILES['uploadD']['name'];
	if(move_uploaded_file($_FILES["uploadD"]["tmp_name"], $pathAC.$fname)) {
	$_POST['docD']=$fname;
	$PDO->db_query("update #_ac set document='".$_POST['docD']."' where process='D' and complianceId='".$uid."'");  
	}else {echo 'uploading failed'; exit; }
	}}
	
	if($_FILES['uploadE'][name]){
	if ($_FILES['uploadE']['error']== 0) {
	$fname=mt_rand(10,999).'_'.$_FILES['uploadE']['name'];
	if(move_uploaded_file($_FILES["uploadE"]["tmp_name"], $pathAC.$fname)) {
	$_POST['docE']=$fname;
	$PDO->db_query("update #_ac set document='".$_POST['docE']."' where process='E' and complianceId='".$uid."'"); 
	}else {echo 'uploading failed'; exit; }
	}}
	
	if($_FILES['uploadF'][name]){
	if ($_FILES['uploadF']['error']== 0) {	
	$fname=mt_rand(10,999).'_'.$_FILES['uploadF']['name'];
	if(move_uploaded_file($_FILES["uploadF"]["tmp_name"], $pathAC.$fname)) {
	$_POST['docF']=$fname; 
	$PDO->db_query("update #_ac set document='".$_POST['docF']."' where process='F' and complianceId='".$uid."'");
	}else {echo 'uploading failed'; exit; }
	}}
	
	if($_FILES['uploadG'][name]){
	if ($_FILES['uploadG']['error']== 0) {	
	$fname=mt_rand(10,999).'_'.$_FILES['uploadG']['name'];
	if(move_uploaded_file($_FILES["uploadG"]["tmp_name"], $pathAC.$fname)) {
	$_POST['docG']=$fname; 
	$PDO->db_query("update #_ac set document='".$_POST['docG']."' where process='G' and complianceId='".$uid."'");
	}else {echo 'uploading failed'; exit; }
	}}
	
	if($_POST[commentAC]!=''){
	$POST[commentsp]=$_POST[commentAC];
	$POST[userid]=$_SESSION["AMD"][0];
	$POST[complianceId]=$_GET[uid];
	$POST[process]='ac';
	$PDO->sqlquery("rs",'complianceComment',$POST);
	}
				 
		/*END AC*/
		
		
		
		
		if($_POST[commentsp]!=''){
	$POST[commentsp]=$_POST[commentsp];
	$POST[userid]=$_SESSION["AMD"][0];
	$POST[complianceId]=$_GET[uid];
	$PDO->sqlquery("rs",'complianceComment',$POST);
		}
		
	$path = UP_FILES_FS_PATH."/compliance/";
	
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
	//echo $filename2;	
	 $pst['upload']=$filename2;
	}
$PDO->sqlquery("rs",'crms',$pst,'pid',$uid);
$ADMIN->sessset('Record has been updated!', 's');
$RW->redir($ADMIN->iurl($comp.'&mode=edit&uid='.$uid.(($start)?'&start='.$start:'').(($followup)?'&followup='.$followup:'')), true); 
}	

   if($flag[0]==1)

   {

     $RW->redir($ADMIN->iurl($comp.(($start)?'&start='.$start:'').(($uid)?'&uid='.$uid:'').(($mode)?'&mode='.$mode:'').(($_GET['view'])?'&view='.$_GET['view']:'')), true);

   }

}





if($uid)

{

    $query =$PDO->db_query("select * from #_".tblName." where pid ='".$uid."' "); 

	$row = $PDO->db_fetch_array($query);

	@extract($row);	

}
$recAmount=$PDO->getSingleresult("select sum(qAmount) from #_paymentdetails_crms where lid='".$_GET['uid']."'");	
$costAmiount=$PDO->getSingleresult("select sum(costprice) from #_cost_list where lid='".$_GET['uid']."'");
?>

<section class="mt30">
  <div class="container ">
    <div class="row">
      <div class="col">
        <h2>CRMS No. :
          <?=$rwi?>
        </h2>
      </div>
         <div class="col">
        <h2>Quotation Amount: Rs <?=$quotation;?></h2>
      </div>
       <div class="col">
        <h2>Received Amount : Rs <?=$recAmount;?></h2>
      </div>
         <div class="col">
        <h2>Pending Amount: Rs <?=$quotation-$recAmount?>	 </h2>
      </div>
      
      
      
    </div>
    <div class="">
      <div class="row my-2">
        <div class="col-12 col-md-4">
          <div class="lead-left-sidebar ">
            <h3>
              <?=$cname?>
              <a class="pull-right" href="<?=$ADMIN->iurl($comp,'add', $pid)?>"><small>Edit</small></a> </h3>
            
            <!-- Edit The Modal -->
            
            
            <ul class="list-unstyled">
            <li> 
           Name <span class="pull-right"> <?=$name?></span>
              </li>
              <li> Email <span class="pull-right"> <?=$email?></span>
              </li>
              <li>Phone <span class="pull-right"> <?=$phone?> </span></li>
               <li> Quotation <span class="pull-right"> <?=$quotation?></span> </li>
                <li> Financial Years <span class="pull-right"> <?=str_replace(':','&nbsp;,',$fy)?></span> </li>
              
              <li> Created On <span class="pull-right"> 
                <?=date('d-m-Y',strtotime($created_on))?>
                <?=date('h:i a',strtotime($created_on))?></span>
              </li>
             
              
    
              
              
            </ul>
            <hr>
          </div>
          <div class="lead-left-sidebar">
            <h4 class="head">Working Team </h4>
            <ul class="list-unstyled ">
              <li> Lead Owner  <span class="pull-right"> <?=$PDO->getSingleresult("select name from pms_admin_users where user_id='".$create_by."'")?> </span></li>
              <li> Sales Manager <span class="pull-right">
               <?=$PDO->getsingleresult("select name from pms_admin_users where user_id='".$salesmid."'")?>
                </span></li>
            
             
              <li> Taxation Head <span class="pull-right">
               <?=$PDO->getSingleresult("select name from pms_admin_users where user_id='".$taxhead."'")?></span></li>
                 <li> Taxation Executive <span class="pull-right">
               <?=$PDO->getSingleresult("select name from pms_admin_users where user_id='".$taxexe."'")?></span></li>
                
                   <li> Incorporation Head <span class="pull-right">
               <?=$PDO->getSingleresult("select name from pms_admin_users where user_id='".$inchead."'")?></span></li>
                 <li> Incorporation Executive <span class="pull-right">
               <?=$PDO->getSingleresult("select name from pms_admin_users where user_id='".$incexe."'")?></span></li>
                <li> Work Status <span class="pull-right"><?=$worksttus==''?'Open':'Close'?></span></li>
                
                
            </ul>
          </div>
          <div class="lead-left-sidebar">
            <h4 class="head">Comment</h4>
            <ul class="list-unstyled text-bold">
              <li>
                <?=$comments?>
              </li>
            </ul>
             
          </div>
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
                      
                        <div class="row">
                          <div class="col-12 col-md-6">
                            <div class="form-group">
                              <label >Taxation Head</label>
                              <select name="taxhead" class="form-control">
                                <?php 
 $sm_query = $PDO->db_query("select * from pms_admin_users where user_type='2' and dpid=6");
                while($sm_rows = $PDO->db_fetch_array($sm_query)){ ?>
                                <option value="<?=$sm_rows['user_id']?>" <?=($sm_rows['user_id']==$taxhead)?'selected="selected"':''?>  >
                                <?=$sm_rows['name']?>
                                </option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-12 col-md-6">
                            <div class="form-group">
                              <label >Taxation Executive</label>
                              <select name="taxexe" class="form-control">
                              <option value="">Select...</option>
                                <?php 
 $sm_query = $PDO->db_query("select * from pms_admin_users where user_type='4' and dpid=6");
                while($sm_rows = $PDO->db_fetch_array($sm_query)){ ?>
                                <option value="<?=$sm_rows['user_id']?>" <?=($sm_rows['user_id']==$taxexe)?'selected="selected"':''?>  >
                                <?=$sm_rows['name']?>
                                </option>
                                <?php } ?>
                              
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12 col-md-6">
                            <div class="form-group">
                              <label >Incorporation Head</label>
                              <select name="inchead" class="form-control">
                                <?php 
 $sm_query = $PDO->db_query("select * from pms_admin_users where user_type='2' and dpid=4");
                while($sm_rows = $PDO->db_fetch_array($sm_query)){ ?>
                                <option value="<?=$sm_rows['user_id']?>" <?=($sm_rows['user_id']==$inchead)?'selected="selected"':''?>  >
                                <?=$sm_rows['name']?>
                                </option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-12 col-md-6">
                            <div class="form-group">
                              <label >Incorporation Executive</label>
                              <select name="incexe" class="form-control">
                              <option value="">Select...</option>
                                <?php 
 $sm_query = $PDO->db_query("select * from pms_admin_users where user_type='4' and dpid=4");
                while($sm_rows = $PDO->db_fetch_array($sm_query)){ ?>
                                <option value="<?=$sm_rows['user_id']?>" <?=($sm_rows['user_id']==$incexe)?'selected="selected"':''?>  >
                                <?=$sm_rows['name']?>
                                </option>
                                <?php } ?>
                              
                              </select>
                            </div>
                          </div>
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
          <div class="lead-left-sidebar" style="display:none">
           
            <ul class="list-unstyled text-bold">
            <!--  <li> <a href="javascript:void(0)" data-toggle="modal" data-target="#Proposal"> Proposal</a> <span class="pull-right">
                <?=$PDO->getSingleresult("select count(*) from #_proposalsent where lid='".$_GET['uid']."'")?>
                </span></li>-->
              
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
 $service_query = $PDO->db_query("select * from rw_product_manager where status='1'");
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
           <!--   <li> <a href="javascript:void(0)"  data-toggle="modal" data-target="#Payment">Payment Link</a> <span class="pull-right">
                <?=$PDO->getSingleresult("select count(*) from #_plinksent_crms where lid='".$rwi."'")?>
                </span></li>-->
              
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
 $service_query = $PDO->db_query("select * from rw_product_manager where status='1'");
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
              
              
              
            <!--  <li><a href="javascript:void(0)" data-toggle="modal" data-target="#QuickEmail">Quick Email</a>  <span class="pull-right">
                <?=$PDO->getSingleresult("select count(*) from #_pms_activity where lid='".$_GET['uid']."' and type=29")?>
                </span></li>-->
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
       
            </ul>
            
          
          </div>
        
            
        </div>
        <div class="col-12 col-md-8">
          <div class="lead-wrp-rightside">
            <ul class="nav nav-tabs">
            
               <li class="nav-item"> <a href="#AdditionalReq" data-target="#" data-toggle="tab" class="nav-link">Additional Req.</a> </li>
                <?php
					   if (!in_array($_SESSION["AMD"][3], array("5", "4",))){ ?>
               <li class="nav-item "> <a href="javascript:void(0)" data-toggle="modal" data-target="#Allocate" class="nav-link"> Allocate To</a> </li><?php } ?>
               <li class="nav-item "> <a href="#paymentDetails" data-target="#paymentDetails" data-toggle="tab" class="nav-link gen profile-link ">Payments</a> </li>
             
                  <li class="nav-item "> <a href="#WorkDetails" data-target="#WorkDetails" data-toggle="tab" class="nav-link active">Work </a> </li>
            </ul>
            <div class="tab-content">
              
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
 $pay_query = $PDO->db_query("select * from #_paymentdetails_crms where lid='".$uid."' order by pid DESC");
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
              <div class="p-3">
              <button type="button" class="btn btn-primary btn-sm mb-2" data-toggle="modal" data-target="#saleMark">Add Service </button>
              <div class="modal fade" id="saleMark">
                            <div class="modal-dialog modal-md">
                              <div class="modal-content"> 
                                <div class="modal-header">
                                  <h4 class="modal-title">Add Service</h4>
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                      <div class="row">
                                    <div class="col-12 col-md-12">
                                      <div class="form-group">
                              <label for="" class="text-left col-12"> Select Service</label>
                              <select name="serviceid" class="validate[required] form-control" data-errormessage-value-missing="Service is required!">
                              <option value="">-------select service------</option>
                              <option value="TDS compliances" >TDS compliances</option>
            <option value="Service tax compliances">Service tax compliances</option>
             <option value="Vat Compliances" >Vat Compliances</option>
             <option value="other compliances">other compliance</option>
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
                        <th>Sale Date</th>
                        <th>Price</th>
                      </tr>
                      </thead>
						<tbody>
                        <?php
						  $sale_query=$PDO->db_query("select * from #_crequirement_crms where lid='".$_GET['uid']."'");
						  if($sale_query->rowCount()>0){
							  while($sales_row=$PDO->db_fetch_array($sale_query)){
								  
								  $totalcost+=$sales_row['serviceprice'];
						  ?>
                      <tr>
                          <td><?=$sales_row['serviceid']?></td>
                       <td><?=date('d M Y',strtotime($sales_row['created_on']))?></td>
                          <td>Rs <?=$sales_row['serviceprice']?></td>
                      </tr>
                      <?php }?>
					   <tr>
                          <td colspan="2">Total</td> <td>Rs <?=$totalcost?></td>
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
                <div class="form-group text-right">
                      <button type="submit" name="additionalReq" class="btn btn-sm btn-primary mr-5" >Submit </button>
                      </div>
                  </div>
              
             
              <div class="tab-pane" id="WorkingTeam">
                <div class="p-3">
                  <div class="saleextutive mb-3">
                    
                    
                  </div>
                  
                  
                </div>
              </div>
              
              
              
              <div class="tab-pane active" id="WorkDetails">
               <form name="projectstatus" method="post" enctype="multipart/form-data" action="">
                <div class="p-3">
              <div class="table-responsive saleextutive">
                    <table  class="table table-striped table-bordered sale">
                      <tr>
                        <th>Process </th>
                        <th>Work</th>
                        <th>Document</th>
                        <th>Work Status</th>
                   
                      </tr>
                      <tr>
                        <th>Process - 1 </th>
                      </tr>
                   
                     <?php 
			 $p1_query = $PDO->db_query("select * from #_oc where complianceId='".$uid."' order by process ASC");
				while($p1_rows = $PDO->db_fetch_array($p1_query)){
				$css =($css=='odd')?'even':'odd';
			
			?>
             <tr class="<?=$css?>">
                    <td>
                    <input name='ocid[]' type='hidden' value='<?=$p1_rows['pid']?>'>
                    <input name='processOC[]' type='hidden' value='<?=$p1_rows[process]?>'><?=$p1_rows[process]?></td>
                    <td><input name='workOC[]' type='hidden' value='<?=$p1_rows[work]?>'><?=$p1_rows[work]?></td>
                    <td>
					 <?php if($p1_rows['document']){ ?>
           <a href="<?=SITE_PATH._MODS.'/download.php?files='.SITE_PATH.'uploaded_files/oc1doc/'.$p1_rows['document']?>" title="<?=str_replace('.pdf',' ',$p1_rows['document'])?>"  target="_blank">Download</a>
          <?php } else { ?>
			 <input name="upload<?=$p1_rows['process']?>" type="file"  />
			 <?php  } ?>
                    </td>
                    <td id="oc<?=$p1_rows['pid']?>">
                    <?php if($p1_rows['status']==1){ echo $p1_rows['completed_on'];} else { ?>
                    <select name="statusOC[]" style="float: none;"  onchange="closestep('<?=$p1_rows['pid']?>','<?=$p1_rows['complianceId']?>','oc<?=$p1_rows['pid']?>','oc');"  class="validate[required] txt select-txt" data-errormessage-value-missing="Status is required!">
            <option  value="">-------Select Status------</option>
             <option value="0" <?=($p1_rows[status]==0)?'selected="selected"':''?>>Open</option>
           <option value="1" <?=($p1_rows[status]==1)?'selected="selected"':''?>  >Close</option>
            </select>
            <?php } ?>
            </td>
            </tr>
<?php } ?>
                    
                 </table>
                    <div class="col-12">
                      <div class="form-group">
                        <label>Post new comment</label>
                      <textarea name="commentOC" class="form-control"></textarea>
                      </div>
                    </div>
                    <table  class="table table-striped table-bordered sale">
                      
                      <tr>
                        <th>Process - 2 </th>
                      </tr>
                     <tr>
                        <th colspan="3">QC - 1 </th>
                      </tr>
                       <?php 
			 $pqc1_query = $PDO->db_query("select * from #_qc where complianceId='".$uid."' and processtype='QC-1' order by process ASC");
				while($pqc1_rows = $PDO->db_fetch_array($pqc1_query)){
				$css1 =($css1=='odd')?'even':'odd';
				
			?>
             <tr class="<?=$css1?> ">

    <td> <input name='pidqc1[]' type='hidden' value='<?=$pqc1_rows[pid]?>'>
                    <input name='processtypeqc1[]' type='hidden' value='<?=$pqc1_rows[processtype]?>'>
					 <input name='processqc1[]' type='hidden' value='<?=$pqc1_rows[process]?>'>
                     <input name='workqc1[]' type='hidden' value='<?=$pqc1_rows[work]?>'>
					<?=$pqc1_rows[process]?></td>
                    <td><?=$pqc1_rows[work]?></td>
                    
                     <td>
					 <?php if($pqc1_rows[document]){ ?>
           <a href="<?=SITE_PATH._MODS.'/download.php?files='.SITE_PATH.'uploaded_files/qcdoc/'.$pqc1_rows[document]?>" title="<?=str_replace('.pdf',' ',$pqc1_rows[document])?>"  target="_blank">Download</a>
          <?php } else {
			 ?>
			 <input name="upload<?=$pqc1_rows[processtype].$pqc1_rows[process]?>" type="file"  />
			 <?php  } ?>
                    </td>
                    <td id="qc1<?=$pqc1_rows['pid']?>">
                      <?php if($pqc1_rows['status']==1){ echo $pqc1_rows['completed_on'];} else { ?>
                    <select name="statusQC1[]" style="float: none;" onchange="closestep('<?=$pqc1_rows['pid']?>','<?=$pqc1_rows['complianceId']?>','qc1<?=$pqc1_rows['pid']?>','qc');"  class="validate[required] txt select-txt" data-errormessage-value-missing="Status is required!">
            <option  value="">-------Select Status------</option>
             <option value="0" <?=($pqc1_rows[status]==0)?'selected="selected"':''?>>Open</option>
           <option value="1" <?=($pqc1_rows[status]==1)?'selected="selected"':''?>  >Close</option>
            </select>
            <?php } ?>
            </td>
            </tr>
<?php } ?>
                    
                    </table>
                    
                    <table  class="table table-striped table-bordered sale">
                      
                      <tr>
                        <th colspan="5">QC - 2 </th>
                      </tr>
                   
                       <?php 
			 $pqc2_query = $PDO->db_query("select * from #_qc where complianceId='".$uid."' and processtype='QC-2' order by process ASC");
				while($pqc2_rows = $PDO->db_fetch_array($pqc2_query)){
				$css2 =($css2=='odd')?'even':'odd';
				
			?>
             <tr class="<?=$css2?> ">

                    <td>
					<input name='pidqc2[]' type='hidden' value='<?=$pqc2_rows[pid]?>'>
                    <input name='processtypeqc2[]' type='hidden' value='<?=$pqc2_rows[processtype]?>'>
					 <input name='processqc2[]' type='hidden' value='<?=$pqc2_rows[process]?>'>
                     <input name='workqc2[]' type='hidden' value='<?=$pqc2_rows[work]?>'>
					
					<?=$pqc2_rows[process]?></td>
                    <td><?=$pqc2_rows[work]?></td>
                   
                    
                     <td>
					 <?php if($pqc2_rows[document]){ ?>
           <a href="<?=SITE_PATH._MODS.'/download.php?files='.SITE_PATH.'uploaded_files/qcdoc/'.$pqc2_rows[document]?>" title="<?=str_replace('.pdf',' ',$pqc2_rows[document])?>"  target="_blank">Download</a>
          <?php } else {
			 ?>
			 <input name="upload<?=$pqc2_rows[processtype].$pqc2_rows[process]?>" type="file"  />
			 <?php  } ?>
                    </td>
                    <td id="qc2<?=$pqc2_rows['pid']?>">
                     <?php if($pqc2_rows['status']==1){ echo $pqc2_rows['completed_on'];} else { ?>
                    <select name="statusQC2[]" style="float: none;" onchange="closestep('<?=$pqc2_rows['pid']?>','<?=$pqc2_rows['complianceId']?>','qc2<?=$pqc2_rows['pid']?>','qc');"  class="validate[required] txt select-txt" data-errormessage-value-missing="Status is required!">
            <option  value="">-------Select Status------</option>
             <option value="0" <?=($pqc2_rows[status]==0)?'selected="selected"':''?>>Open</option>
           <option value="1" <?=($pqc2_rows[status]==1)?'selected="selected"':''?>  >Close</option>
            </select>
            <?php } ?>
            </td>
            </tr>
<?php } ?>
                    </table>
                    
                    <table  class="table table-striped table-bordered sale">
                      
                      <tr>
                        <th colspan="5">QC - 3 </th>
                      </tr>
                   
                    <?php 
			 $pqc3_query = $PDO->db_query("select * from #_qc where complianceId='".$uid."' and processtype='QC-3' order by process ASC");
				while($pqc3_rows = $PDO->db_fetch_array($pqc3_query)){
				$css3 =($css3=='odd')?'even':'odd';
				
			?>
             <tr class="<?=$css3?> ">

                    <td>
					<input name='pidqc3[]' type='hidden' value='<?=$pqc3_rows[pid]?>'>
                    <input name='processtypeqc3[]' type='hidden' value='<?=$pqc3_rows[processtype]?>'>
					 <input name='processqc3[]' type='hidden' value='<?=$pqc3_rows[process]?>'>
                     <input name='workqc3[]' type='hidden' value='<?=$pqc3_rows[work]?>'>
					
					<?=$pqc3_rows[process]?></td>
                    <td><?=$pqc3_rows[work]?></td>
                   
                    
                     <td>
					 <?php if($pqc3_rows[document]){ ?>
           <a href="<?=SITE_PATH._MODS.'/download.php?files='.SITE_PATH.'uploaded_files/qcdoc/'.$pqc3_rows[document]?>" title="<?=str_replace('.pdf',' ',$pqc3_rows[document])?>"  target="_blank">Download</a>
          <?php } else {
			 ?>
			 <input name="upload<?=$pqc3_rows[processtype].$pqc3_rows[process]?>" type="file"  />
			 <?php  } ?>
                    </td>
                    <td id="qc3<?=$pqc3_rows['pid']?>">
                     <?php if($pqc3_rows['status']==1){ echo $pqc3_rows['completed_on'];} else { ?>
                    <select name="statusQC3[]" style="float: none;" onchange="closestep('<?=$pqc3_rows['pid']?>','<?=$pqc3_rows['complianceId']?>','qc3<?=$pqc3_rows['pid']?>','qc');"  class="validate[required] txt select-txt" data-errormessage-value-missing="Status is required!">
            <option  value="">-------Select Status------</option>
             <option value="0" <?=($pqc3_rows[status]==0)?'selected="selected"':''?>>Open</option>
           <option value="1" <?=($pqc3_rows[status]==1)?'selected="selected"':''?>  >Close</option>
            </select>
            <?php } ?>
            </td>
            </tr>
<?php } ?>
                    </table>
                    <table  class="table table-striped table-bordered sale">
                      
                      <tr>
                        <th colspan="5">QC - 4 </th>
                      </tr>
                   
                  <?php 
			 $pqc4_query = $PDO->db_query("select * from #_qc where complianceId='".$uid."' and processtype='QC-4' order by process ASC");
				while($pqc4_rows = $PDO->db_fetch_array($pqc4_query)){
				$css2 =($css4=='odd')?'even':'odd';
				
			?>
             <tr class="<?=$css4?> ">

                    <td>
					<input name='pidqc4[]' type='hidden' value='<?=$pqc4_rows[pid]?>'>
                    <input name='processtypeqc4[]' type='hidden' value='<?=$pqc4_rows[processtype]?>'>
					 <input name='processqc4[]' type='hidden' value='<?=$pqc4_rows[process]?>'>
                     <input name='workqc4[]' type='hidden' value='<?=$pqc4_rows[work]?>'>
					
					<?=$pqc4_rows[process]?></td>
                    <td><?=$pqc4_rows[work]?></td>
                   
                    
                     <td>
					 <?php if($pqc4_rows[document]){ ?>
           <a href="<?=SITE_PATH._MODS.'/download.php?files='.SITE_PATH.'uploaded_files/qcdoc/'.$pqc4_rows[document]?>" title="<?=str_replace('.pdf',' ',$pqc4_rows[document])?>"  target="_blank">Download</a>
          <?php } else {
			 ?>
			 <input name="upload<?=$pqc4_rows[processtype].$pqc4_rows[process]?>" type="file"  />
			 <?php  } ?>
                    </td>
                    <td id="qc4<?=$pqc4_rows['pid']?>">
                     <?php if($pqc4_rows['status']==1){ echo $pqc4_rows['completed_on'];} else { ?>
                    <select name="statusQC4[]" style="float: none;" onchange="closestep('<?=$pqc4_rows['pid']?>','<?=$pqc4_rows['complianceId']?>','qc4<?=$pqc4_rows['pid']?>','qc');"  class="validate[required] txt select-txt" data-errormessage-value-missing="Status is required!">
            <option  value="">-------Select Status------</option>
             <option value="0" <?=($pqc4_rows[status]==0)?'selected="selected"':''?>>Open</option>
           <option value="1" <?=($pqc4_rows[status]==1)?'selected="selected"':''?>  >Close</option>
            </select>
            <?php } ?>
            </td>
            </tr>
<?php } ?>
                    </table>
                    <div class="col-12">
                      <div class="form-group">
                        <label>Post new comment</label>
                      <textarea name="commentQC" class="form-control"></textarea>
                      </div>
                    </div>
                    <table  class="table table-striped table-bordered sale">
                      
                      <tr>
                        <th>Process - 3 </th>
                      </tr>
                     <tr>
                        <th colspan="3">AC</th>
                      </tr>
                      <?php 
			 $pqac_query = $PDO->db_query("select * from #_ac where complianceId='".$uid."' order by process ASC");
				while($pqac_rows = $PDO->db_fetch_array($pqac_query)){
				$css2 =($css4=='odd')?'even':'odd';
				
			?>
             <tr class="<?=$css4?> ">

                    <td>
					<input name='pidAC[]' type='hidden' value='<?=$pqac_rows[pid]?>'>
					 <input name='processAC[]' type='hidden' value='<?=$pqac_rows[process]?>'>
                     <input name='workAC[]' type='hidden' value='<?=$pqac_rows[work]?>'>
					
					<?=$pqac_rows[process]?></td>
                    <td><?=$pqac_rows[work]?></td>
                   
                   
                     <td>
					 <?php if($pqac_rows[document]){ ?>
           <a href="<?=SITE_PATH._MODS.'/download.php?files='.SITE_PATH.'uploaded_files/acdoc/'.$pqac_rows[document]?>" title="<?=str_replace('.pdf',' ',$pqac_rows[document])?>"  target="_blank">Download</a>
          <?php } else {
			 ?>
			 <input name="upload<?=$pqac_rows[process]?>" type="file"  />
			 <?php  } ?>
                    </td>
                    <td id="ac<?=$pqac_rows['pid']?>">
                     <?php if($pqac_rows['status']==1){ echo $pqac_rows['completed_on'];} else { ?>
                    <select name="statusAC[]" style="float: none;" onchange="closestep('<?=$pqac_rows['pid']?>','<?=$pqac_rows['complianceId']?>','ac<?=$pqac_rows['pid']?>','ac');"  class="validate[required] txt select-txt" data-errormessage-value-missing="Status is required!">
            <option  value="">-------Select Status------</option>
             <option value="0" <?=($pqac_rows[status]==0)?'selected="selected"':''?>>Open</option>
           <option value="1" <?=($pqac_rows[status]==1)?'selected="selected"':''?>  >Close</option>
            </select>
            <?php } ?>
            </td>
            </tr>
<?php } ?>
                    
                    </table>
                    <div class="col-12">
                      <div class="form-group">
                        <label>Post new comment</label>
                      <textarea name="commentAC" class="form-control"></textarea>
                      </div>
                    </div>
                  </div>

                  
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
                    <?php  $comment_ry =$PDO->db_query("select * from #_complianceComment where complianceId ='".$uid."' order by pid DESC"); 
					if($comment_ry->rowCount()>0){
	                       while($comment_rs = $PDO->db_fetch_array($comment_ry)){ ?>
                      <tr>
                        <th><?=$PDO->getsingleresult("select name from pms_admin_users where user_id='".$comment_rs['userid']."'")?> <small class="pull-right font-weight-normal "> <i class="fa fa-clock-o"></i> Comment on <?=date("F j, Y, g:i a",strtotime($comment_rs['created_on']))?></small> </th>
                      </tr>
                      <tr>
                        <td class="text-justify"><?=$comment_rs['commentsp']?></td>
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
                      <textarea name="commentsp" class="form-control"></textarea>
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
              
              
              <!--<div class="saleextutive activitytable  table-responsive mt-3">
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
              </div>-->
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



			url: '<?=SITE_PATH_ADM._MODS.'/crms/'?>send.php',



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
function closestep(stepid,crmsid,placeid,tablename){
	  if (confirm('Are you sure you want to close this step ?')) {
        console.log(placeid);
		data= {'stepid':stepid,'crmsid':crmsid,'tablename':tablename}
	console.log(data);
$.ajax({
    type: "POST",
    url: "<?=SITE_PATH_ADM?>modules/crmsAjax.php",
    data: data,
    success: function(data) {
	console.log(data);
	$('#'+placeid).html(data);
	
		},
    error: function() {
        alert('error handing here');
    }});
    }
	}
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