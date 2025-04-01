<?php 
include("../../lib/config.inc.php");
$sql = "SELECT * FROM #_affilation where pid ='".$_POST['projectid']."' ";
$query = $PDO->db_query($sql);
$list = $PDO->db_fetch_array($query);
if($_POST['step']=='basicDoc'){
$contt='<p>Thank you for associating with Registration Wala. This is to inform you that we confirm the receipt of all necessary documents required for the incorporation of your company. Moreover, we would share all the documents with you within 2 days for signing purpose.</p>
<p>Our CS Priyanka Dhyani will be your point of contact in regard to any query. Feel free to connect with us anytime. Her contact no. is 9958978343</p>
';
$signature=$RW->emailSignature($ADMIN->user_type($_SESSION["AMD"][3]));
$content= mailcontent($list['name'],$contt,$signature);
$subject='Your basic Documents are Received | Registrationwala';
}

else if($_POST['step']=='pendingDoc'){ 

$contt='<p>Our CS Priyanka Dhyani will be your point of contact in regard to any query. Feel free to connect with us anytime. Her contact no. is 9958978343</p>';
$signature=$RW->emailSignature($ADMIN->user_type($_SESSION["AMD"][3]));
$content= mailcontent($list['name'],$contt,$signature);
$subject='Your Documents are Pending for Incorporation | Registrationwala';

} 
else if($_POST['step']=='fileSent'){ 

$contt='<p>This is to inform you that we have dispatched the file of all relevant documents to you for signing purpose. You’re requested to revert back to us with the signed copies of the same at the earliest to enable further processing. </p>
<p>Our CS Priyanka Dhyani will be your point of contact in regard to any query. Feel free to connect with us anytime. Her contact no. is 9958978343</p>';
$signature=$RW->emailSignature($ADMIN->user_type($_SESSION["AMD"][3]));
$content= mailcontent($list['name'],$contt,$signature);
$subject='Your incorporation file sent | Registrationwala';
}

else if($_POST['step']=='fileRecived'){ 

$contt='<p>Our CS Priyanka Dhyani will be your point of contact in regard to any query. Feel free to connect with us anytime. Her contact no. is 9958978343</p>';
$signature=$RW->emailSignature($ADMIN->user_type($_SESSION["AMD"][3]));
$content= mailcontent($list['name'],$contt,$signature);
$subject='Your incorporation file Received | Registrationwala';
}

else if($_POST['step']=='formFilling'){ 

$contt='<p>This is to inform you that we have filed the form of company incorporation with the respective ministry. We will notify you as soon we get any response from the ministry.  </p>
<p>Our CS Priyanka Dhyani will be your point of contact in regard to any query. Feel free to connect with us anytime. Her contact no. is 9958978343</p>';
$signature=$RW->emailSignature($ADMIN->user_type($_SESSION["AMD"][3]));
$content= mailcontent($list['name'],$contt,$signature);

$subject='Form Filled for Incorporation | Registrationwala';
}
else if($_POST['step']=='balancePayment'){ 
$contt='<p>This is to inform you that there is some balance payment reflecting against your account with us. We would request you to kindly process this payment as soon as possible so that we forward all the documents (COI, MOA, and AOA) related to your company incorporation. </p>
<p>Our CS Priyanka Dhyani will be your point of contact in regard to any query. Feel free to connect with us anytime. Her contact no. is 9958978343</p>';
$signature=$RW->emailSignature($ADMIN->user_type($_SESSION["AMD"][3]));
$content= mailcontent($list['name'],$contt,$signature);

$subject='Balance Payment Reminder | Registrationwala';
}
else if($_POST['step']=='coi'){ 
$contt='<p>We feel immensely delighted to inform you that your company has been incorporated successfully. All necessary documents (COI, PAN and TAN) have been attached along with this mail. Kindly have a look at them.  </p>
<p>Our CS Priyanka Dhyani will be your point of contact in regard to any query. Feel free to connect with us anytime. Her contact no. is 9958978343</p>';
$signature=$RW->emailSignature($ADMIN->user_type($_SESSION["AMD"][3]));
$content= mailcontent($list['name'],$contt,$signature);

$subject='Your COI Applied | Registrationwala';
}

else if($_POST['step']=='dscDelivered'){ 

$contt='<p>We hope that you’re doing well. This is to notify you that we’ve started delivering all the Digital Signature Certificates of the subscribers to _________.</p>
<p>It was more than a privilege working with you. For any further query, feel free to contact our CS Priyanka Dhyani. Her contact no. is 9958978343</p>';
$signature=$RW->emailSignature($ADMIN->user_type($_SESSION["AMD"][3]));
$content= mailcontent($list['name'],$contt,$signature);
$subject='Your DSC Delivered | Registrationwala';
}
else if($_POST['step']=='basicInfo'){ 

$contt='<p>We have just received your request for apply for trademark registration. We are happy to inform you that we have forwarded your details to your officials and they have begun with the filing of your trademark application. </p>
<p>We might need some documents from you regarding the filing and please be in touch with us for this.</p>';
$signature=$RW->emailSignature($ADMIN->user_type($_SESSION["AMD"][3]));
$content= mailcontent($list['name'],$contt,$signature);
$subject='Thank you for considering us | Registrationwala';
}
else if($_POST['step']=='applicationDrafted'){ 

$contt='<p>This email is to inform you that we have drafted the application for trademark registration for your ID.......... dated ................. we are going to forward it to the trademark registration office in due time after double checking the application.</p>';
$signature=$RW->emailSignature($ADMIN->user_type($_SESSION["AMD"][3]));
$content= mailcontent($list['name'],$contt,$signature);
$subject='We have completed the application draft | Registrationwala';
}

else if($_POST['step']=='approvalonDraft'){ 

$contt='<p>Your trademark application ID number..........................has been approved by the trademark registration office and soon, the trademark will be published in the journal.</p>';
$signature=$RW->emailSignature($ADMIN->user_type($_SESSION["AMD"][3]));
$content= mailcontent($list['name'],$contt,$signature);
$subject='Your trademark application has been approved | Registrationwala';
}

else if($_POST['step']=='applicationSubmitted'){ 

$contt='<p>This mail is to inform you that the application has been completed and has been submitted to the trademark registration office and all that remains is scrutiny from their part. We will keep you informed regarding any developments.</p>';
$signature=$RW->emailSignature($ADMIN->user_type($_SESSION["AMD"][3]));
$content= mailcontent($list['name'],$contt,$signature);
$subject='Your trademark filing has been completed | Registrationwala';
}



 function mailcontent($name,$content,$signature){
	 $content='<table width="100%" cellpadding="0" cellspacing="0">
<tr><td>
<table style="margin:auto; width:600px; font-size:16px; line-height:24px; font-family:Verdana, Geneva, sans-serif" cellpadding="0" cellspacing="0">
<tr><td>
<table width="100%" cellpadding="5" cellspacing="0">
<tr><td><a href="https://www.registrationwala.com"><img src="https://www.registrationwala.com/images/emailer/logonrw.png" width="109" height="38" alt="Registrationwala.com" /></a></td>
<td align="right"><a style="margin:0 5px;" href="https://www.facebook.com/registrationwala/" target="_blank"><img src="https://www.registrationwala.com/images/emailer/facebookc.png" width="27" height="27" alt="Like On Facebook" /></a><a style="margin:0 5px;" href="https://twitter.com/Registrationwla" target="_blank"><img src="https://www.registrationwala.com/images/emailer/twitterc.png" width="27" height="27" alt="Like On Twitter" /></a><a style="margin:0 5px;" href="https://plus.google.com/u/0/115063389280026230269/posts" target="_blank"><img src="https://www.registrationwala.com/images/emailer/g-plusc.png" width="27" height="27" alt="Like On Google plus" /></a></td></tr>
</table>
</td></tr>
<tr><td>
<table width="100%" cellpadding="15" cellspacing="0">
<tr><td style="border:1px solid #ccc; background:url(https://www.registrationwala.com/images/emailer/drop-mark.png) no-repeat top left 10px;">
<table width="100%" cellpadding="5" cellspacing="0">
<tr><td style="padding:10px 20px;">

<p style="padding-left:25px; margin:8px; text-transform:uppercase; font-size:13px;">GREETINGS FROM REGISTARTIONWALA !</p>
</td></tr>
<tr><td style="padding:10px 20px;">
<img src="https://www.registrationwala.com/images/emailer/welcome-bg.jpg" height="200" width="483" style="width:100%" alt="Welcome" />
</td></tr>
<tr><td style="background-color:#00293c; color:#fff;" bgcolor="#00293c">
<p style="padding-left:10px; margin:0">Dear '.$name.',</p>
</td></tr>
<tr><td>

<table width="100%" cellpadding="0" cellspacing="0">
<tr><td style="padding:10px 20px;">
'.$content.'
</td></tr>
</table>

</td></tr>
<tr>
<td style="background-color:#00293c; color:#fff;" bgcolor="#00293c"><p style="padding-left:10px; margin:0">Hoping for a prompt response from your end.</p></td>
</tr>
<tr><td style="padding:20px 30px 0 30px;color:#00293c;">	'.$signature.'</td></tr>
</table>
</td></tr>
</table>
</td></tr>
</table>
</td></tr>
</table>'; 
	 
return $content;	 
	 }
?>  
      
      
      
  
   
                             <div class="row">
                                <div class="col-12 col-md-12">
                                  <div class="form-group">
                                    <label>Subject</label>
                                    <input  class="form-control mb5 " name="payment_subject" value="<?=$subject?>" />
                                    <input type="hidden" name="<?=$_POST['step']?>" value="1"> 
                                      <input type="hidden" name="processStatus" value="<?=$_POST['processStatus']?>">
                                    <input type="hidden" name="projectid" value="<?=$_POST['projectid']?>">
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-12">
                                  <div class="form-group">
                                    <label>Mail body</label>
                                    <?=$ADMIN->get_editor_s('content', $content,'','100%')?>
                                  </div>
                                </div>
                              </div>
                         

      