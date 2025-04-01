<?php 
include(FS_ADMIN._MODS."/admin_users/admin_user.inc.php");
$ADU = new AdminUsers();
 function selectTimesOfDay() { $open_time = strtotime("10:00"); $close_time = strtotime("18:30"); $now = time(); $output = ""; for( $i=$open_time; $i<$close_time; $i+=1800) {  $output .= "<option>".date("H:i",$i)."</option>"; } return $output; }
function password($password)
	 {
	        $password=md5($password); 
		    $password=base64_encode($password); 	
		    return $password;
	 }
if($RW->is_post_back())
{  
if(isset($_POST['cpass'])){
	$password=password($_POST['oldpassword']);
	
$query=$PDO->db_query("select * from pms_admin_users where email ='".$_SESSION["AMD"][2]."' and password ='".$password."' and status='1' "); 
			
			if($query->rowCount()==1)
	        {
				$pass['password']=password($_POST['password']);
				 $PDO->sqlquerywithprefix("rs",'pms_admin_users',$pass,'user_id',$_SESSION["AMD"][0]);
				$ADMIN->sessset('Password has been updated', 's');
				
				 }	 else { $ADMIN->sessset('Old Password is not correct.', 'e'); }
	$RW->redir($ADMIN->iurl($comp.'&mode=my-profile'.(($start)?'&start='.$start:'').(($subpage_id)?'&subpage_id='.$subpage_id:'').(($alumniid)?'&alumniid='.$alumniid:'').(($galleryid)?'&galleryid='.$galleryid:'')).$dlr, true);
	}
	

	
if(isset($_POST['lapply'])){
	//print_r($_POST); exit;
	$_POST['userid']=$_SESSION["AMD"][0];
				 $PDO->sqlquery("rs",'leaves',$_POST);
				 $userRes=$PDO->getResult("select * from pms_admin_users where user_id='".$_POST['userid']."' and status=1"); 
				
				$ltype=$_POST['leaveType']==1?'Partial':'Full day';
                $froms=$_POST['lfrom']==''?date('d-m-Y',strtotime($_POST['partialDate'])):date('d-m-Y',strtotime($_POST['lfrom']));
				$tos=$_POST['lto']==''?$_POST['startime'].' - '.$_POST['endtime']:$_POST['lto'];
				 
				 $mailtext='<table width="100%" cellpadding="0" cellspacing="0"><tr><td><table style="margin:auto; width:600px; font-size:16px; line-height:24px; font-family:Verdana, Geneva, sans-serif" cellpadding="0" cellspacing="0"><tr><td><table width="100%" cellpadding="5" cellspacing="0"><tr><td><a href="https://www.registrationwala.com"><img src="https://www.registrationwala.com/images/emailer/logonrw.png" width="109" height="38" alt="Registrationwala.com" /></a></td><td align="right"><a style="margin:0 5px;" href="https://www.facebook.com/registrationwala/" target="_blank"><img src="https://www.registrationwala.com/images/emailer/facebookc.png" width="27" height="27" alt="Like On Facebook" /></a><a style="margin:0 5px;" href="https://twitter.com/Registrationwla" target="_blank"><img src="https://www.registrationwala.com/images/emailer/twitterc.png" width="27" height="27" alt="Like On Twitter" /></a><a style="margin:0 5px;" href="https://plus.google.com/u/0/115063389280026230269/posts" target="_blank"><img src="https://www.registrationwala.com/images/emailer/g-plusc.png" width="27" height="27" alt="Like On Google plus" /></a></td></tr></table></td></tr><tr><td><table width="100%" cellpadding="15" cellspacing="0"><tr><td style="border:1px solid #ccc;"><table width="100%" cellpadding="5" cellspacing="0"><tr><td><table width="100%" cellpadding="0" cellspacing="0"><tr><td style="padding:10px 20px;">
<p style="margin:10px 0; text-align:justify; line-height:24px;"><strong>Dear Admin,</strong></p>
<p style="margin:10px 0; text-align:justify; line-height:24px;">'.$_SESSION["AMD"][1].' , '.$ADMIN->user_type($_SESSION["AMD"][3]).' , Applied for  leave. Details are given below;</p>
<p style="margin:10px 0; text-align:justify; line-height:24px;"><table width="100%" border="0">
  <tr>
    <td>Leave Type</td>
    <td>'.$ltype.'</td>
  </tr>
  <tr>
    <td>Duration</td>
    <td>'.$froms.' - '.$tos.'</td>
  </tr>
  <tr>
    <td>Total Days</td>
    <td>'.$_POST['nodays'].'</td>
  </tr>
  <tr>
    <td>Reason</td>
    <td>'.$_POST['comments'].'</td>
  </tr>
</table>
</p>
</td></tr>
</table></td></tr>
<tr><td style="padding:15px 10px;">'.$RW->emailSignature($ADMIN->user_type($_SESSION["AMD"][3])).'</td></tr>
</table></td></tr></table></td></tr></table></td></tr></table>';
$nofdays=$_POST['leaveType']==1?'Partial':$_POST['nodays'];
        $to='cagauravbansal1@gmail.com ';
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: '.$_SESSION["AMD"][1].' <'.$_SESSION["AMD"][2].'>' . "\r\n";
		
		$headers .= 'Reply-To:'.$_SESSION["AMD"][1].' <'.$_SESSION["AMD"][2].'>' . "\r\n";
	  //  $headers .= 'Cc: dushyant@registrationwala.com,'.$_SESSION["AMD"][2]."\r\n";
		$subject='Leave Request | '.$_SESSION["AMD"][1]. ' | '.$nofdays.' Days | Registrationwala';
		$mails=mail($to, $subject, $mailtext, $headers, '-fsupport@registrationwala.com');				 
				$ADMIN->sessset('Leave has been applied', 's');
				$RW->redir($ADMIN->iurl($comp.'&mode=my-profile'.(($start)?'&start='.$start:'').(($subpage_id)?'&subpage_id='.$subpage_id:'').(($alumniid)?'&alumniid='.$alumniid:'').(($galleryid)?'&galleryid='.$galleryid:'')).$dlr, true);
				 }
				 
if(isset($_POST['lapprove'])){
	//print_r($_POST); exit;
	             $_POST['approvedBy']=$_SESSION["AMD"][0];
				 $PDO->sqlquery("rs",'leaves',$_POST,'pid',$_POST['leaveId']);
				$userRes=$PDO->getResult("select * from pms_admin_users where user_id='".$_POST['userid']."' and status=1"); 
				$leaveRes=$PDO->getResult("select * from #_leaves where pid='".$_POST['leaveId']."'"); 
				
				$ltype=$leaveRes['leaveType']==1?'Partial':'Full day';
                $froms=$leaveRes['lfrom']==''?date('d-m-Y',strtotime($leaveRes['partialDate'])):date('d-m-Y',strtotime($leaveRes['lfrom']));
				$tos=$leaveRes['lto']==''?$leaveRes['startime'].' - '.$leaveRes['endtime']:$leaveRes['lto'];
				 $mailtext='<table width="100%" cellpadding="0" cellspacing="0"><tr><td><table style="margin:auto; width:600px; font-size:16px; line-height:24px; font-family:Verdana, Geneva, sans-serif" cellpadding="0" cellspacing="0"><tr><td><table width="100%" cellpadding="5" cellspacing="0"><tr><td><a href="https://www.registrationwala.com"><img src="https://www.registrationwala.com/images/emailer/logonrw.png" width="109" height="38" alt="Registrationwala.com" /></a></td><td align="right"><a style="margin:0 5px;" href="https://www.facebook.com/registrationwala/" target="_blank"><img src="https://www.registrationwala.com/images/emailer/facebookc.png" width="27" height="27" alt="Like On Facebook" /></a><a style="margin:0 5px;" href="https://twitter.com/Registrationwla" target="_blank"><img src="https://www.registrationwala.com/images/emailer/twitterc.png" width="27" height="27" alt="Like On Twitter" /></a><a style="margin:0 5px;" href="https://plus.google.com/u/0/115063389280026230269/posts" target="_blank"><img src="https://www.registrationwala.com/images/emailer/g-plusc.png" width="27" height="27" alt="Like On Google plus" /></a></td></tr></table></td></tr><tr><td><table width="100%" cellpadding="15" cellspacing="0"><tr><td style="border:1px solid #ccc;"><table width="100%" cellpadding="5" cellspacing="0"><tr><td><table width="100%" cellpadding="0" cellspacing="0"><tr><td style="padding:10px 20px;">
<p style="margin:10px 0; text-align:justify; line-height:24px;"><strong>Dear '.$userRes['name'].',</strong></p>
<p style="margin:10px 0; text-align:justify; line-height:24px;">Your leave has been <strong>'.$ADMIN->displaystatusLeave($_POST['status']).'</strong>. Details are given below; .</p>
<p style="margin:10px 0; text-align:justify; line-height:24px;"><table width="100%" border="0">
  <tr>
    <td>Leave Type</td>
    <td>'.$ltype.'</td>
  </tr>
  <tr>
    <td>Duration</td>
    <td>'.$froms.' - '.$tos.'</td>
  </tr>
  <tr>
    <td>Total Days</td>
    <td>'.$leaveRes['nodays'].'</td>
  </tr>
  <tr>
    <td>Reason</td>
    <td>'.$leaveRes['comments'].'</td>
  </tr>
   <tr>
    <td>Reply By</td>
    <td>'.$PDO->getSingleresult("select name from pms_admin_users where user_id='".$_POST['approvedBy']."' and status=1").'</td>
  </tr>
</table>
</p>

</td></tr>
</table></td></tr>
<tr><td style="padding:15px 10px;">'.$RW->emailSignature($ADMIN->user_type($_SESSION["AMD"][3])).'</td></tr>
</table></td></tr></table></td></tr></table></td></tr></table>';
        $to=$userRes['email'];
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: '.$_SESSION["AMD"][1].' <'.$_SESSION["AMD"][2].'>' . "\r\n";
		
		//$headers .= 'Reply-To:admin@registrationwala.com,' .$_SESSION["AMD"][2]."\r\n";
	  //  $headers .= 'Cc: dushyant@registrationwala.com,'.$_SESSION["AMD"][2]."\r\n";
		$subject='Leave '.$ADMIN->displaystatusLeave($_POST['status']).' | Registrationwala';
		$mails=mail($to, $subject, $mailtext, $headers, '-fsupport@registrationwala.com');				 
				$ADMIN->sessset('Leave has been updated', 's');
				$RW->redir($ADMIN->iurl($comp.'&mode=my-profile'.(($start)?'&start='.$start:'').(($subpage_id)?'&subpage_id='.$subpage_id:'').(($alumniid)?'&alumniid='.$alumniid:'').(($galleryid)?'&galleryid='.$galleryid:'')).$dlr, true);
				 }				 
				 		
if(isset($_POST['stask'])){
	
	           $_POST['senderid']=$_SESSION["AMD"][0];
				 $PDO->sqlquery("rs",'task',$_POST);
				$ADMIN->sessset('Task has been assigned', 's');
				$RW->redir($ADMIN->iurl($comp.'&mode=my-profile'.(($start)?'&start='.$start:'').(($subpage_id)?'&subpage_id='.$subpage_id:'').(($alumniid)?'&alumniid='.$alumniid:'').(($galleryid)?'&galleryid='.$galleryid:'')).$dlr, true);
				 }	
				 
if(isset($_POST['allreply'])){
	//print_r($_POST); exit;
	             $_POST['status']=1;
				 $_POST['modified_on']=date('Y-m-d H:i:s');
				 $PDO->sqlquery("rs",'task',$_POST,'pid',$_POST['taskid']);
				$ADMIN->sessset('Task has been replied', 's');
				$RW->redir($ADMIN->iurl($comp.'&mode=my-profile'.(($start)?'&start='.$start:'').(($subpage_id)?'&subpage_id='.$subpage_id:'').(($alumniid)?'&alumniid='.$alumniid:'').(($galleryid)?'&galleryid='.$galleryid:'')).$dlr, true);
				 }					 					 
if(isset($_POST['caddr'])){
	//print_r($_POST); exit;
 $path = UP_FILES_FS_PATH."/userimg";
   if($_FILES['image'][name])
   {

			 $_POST['image'] = $RW->uploadFile($path,$_FILES['image']['name'],'image');
			if($_SESSION["AMD"][0]>0)

			{
				$delete_image=$PDO->getSingleresult("select image from pms_".tblName." where user_id='".$_SESSION["AMD"][0]."'");
				if($delete_image!='')

				{
				  @unlink($path.'/'.$delete_image);
				}
			}
	}
}
     $_POST['updateid']=$_SESSION["AMD"][0];
       $flag = $ADU->update($_POST);

   if($flag==1)
   {
     $RW->redir($ADMIN->iurl($comp.'&mode=my-profile'.(($start)?'&start='.$start:'').(($subpage_id)?'&subpage_id='.$subpage_id:'').(($alumniid)?'&alumniid='.$alumniid:'').(($galleryid)?'&galleryid='.$galleryid:'')).$dlr, true);
   }
}
if($_SESSION["AMD"][0])
{  $query =$PDO->db_query("select * from pms_admin_users where user_id ='".$_SESSION["AMD"][0]."' "); 

	$row = $PDO->db_fetch_array($query);
	@extract($row);	
}
?>

<section class="ptb50 sectionbg userprofile-wrp">
  <div class="container ">
    <div class="row">
      <div class="col-12  col-sm-3  col-xl-3 d-flex"> 
        <!-- required for floating --> 
        <!-- Nav tabs -->
        <div class="usertab-left-wrp align-items-stretch w-100">
          <ul class="nav   usertab-left ">
            <li ><a href="#Profile" data-toggle="tab">My Profile</a></li>
            <li><a href="#Password" data-toggle="tab">My Password</a></li>
            <!--<li><a href="#Report" data-toggle="tab">My Report</a></li>-->
            <li><a href="#Leaves" data-toggle="tab">My Leaves</a></li>
            <?php if($_SESSION["AMD"][3]==1 || $_SESSION["AMD"][3]==6) { ?>
            <li><a href="#leaverequest" data-toggle="tab">Leave Request</a></li>
            <li><a href="#leaveHistory" data-toggle="tab">Leave History</a></li>
            <?php } ?>
            <li><a href="#Role" data-toggle="tab">My Role</a></li>
            <li><a href="#Calendar" data-toggle="tab">Holiday Calendar</a></li>
            <li><a href="#Task" data-toggle="tab" class="active"> Task</a></li>
            <!-- <li><a href="#logindetail" data-toggle="tab"> Login Log</a></li> -->
          </ul>
        </div>
      </div>
      <div class="col-12  col-sm-9  col-xl-9  d-flex"> 
        <!-- Tab panes -->
        <div class="tab-content  w-100">
          <div class="tab-pane" id="Profile">
            <div class="card-box align-items-stretch w-100">
              <div class="row">
                <?php if($image==''){
				  $src='images/user.jpg';
				  
				  } else {
					  
					   $src=SITE_PATH.'uploaded_files/userimg/'.$image; } ?>
                <div class="col-sm-3 col-md-3"> <img src="<?=$src;?>"
            alt="" class=" user-profile-pic img-responsive" /> </div>
                <div class="col-sm-8 col-md-8">
                  <blockquote>
                    <h4><?php echo $name;?></h4>
                    <small><cite title="Source Title">
                    <?=$ADMIN->user_type($user_type)?>
                    </cite></small> </blockquote>
                  <div class="row userprofile-icon d-flex ">
                    <div class="col  align-self-center"> <i class="fa fa-envelope-o "></i>
                      <?=$email?>
                    </div>
                    <div class="col"> <i class="fa fa-mobile justify-content-center"></i>
                      <?=$mobile?>
                    </div>
                  </div>
                  <div class="row userprofile-icon">
                    <div class="col mt-3"> <i class="fa fa-user-o justify-content-center"></i> Reporting Manager :
                      <?=$PDO->getSingleresult("select name from pms_".tblName." where user_id='".$rmanager."'");?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 text-right "> <a href="javascript:void(0)" data-toggle="collapse" data-target="#demo" > <i class="fa fa-pencil-square-o" ></i> Edit </a> </div>
              </div>
              <div class="user-wrp collapse" id="demo">
                <hr>
                <form action="#" method="post" enctype="multipart/form-data">
                  <div class="row">
                    <div class="col">
                      <label>Change Photo</label>
                      <input type="file" name="image" class="form-control">
                    </div>
                    <div class="col">
                      <div class="form-group">
                        <label>Address</label>
                        <textarea name="address" class="form-control"><?=$address?>
</textarea>
                      </div>
                    </div>
                  </div>
                  <button type="submit" name="caddr" class="btn btn-primary pull-right">Submit</button>
                </form>
              </div>
              <div class="clearfix"></div>
            </div>
          </div>
          <div class="tab-pane" id="Password">
            <div class="card-box align-items-stretch w-100 ">
              <h4>My Password</h4>
              <hr>
              <div class="user-wrp">
                <form action="#" id="changepass" method="post" enctype="multipart/form-data">
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="">Old password</label>
                        <input type="password" name="oldpassword" class="validate[required] form-control" data-errormessage-value-missing="Old Password is required!" value="">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="">New password</label>
                        <input type="password" name="password" id="pass" class="validate[required] form-control" data-errormessage-value-missing="New Password is required!"  value="">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="">Confirm password</label>
                        <input type="password" name="cpassword"  class="validate[required,equals[pass]] form-control" data-errormessage-value-missing="Confirm Password is required!"  value="">
                      </div>
                    </div>
                  </div>
                  <button type="submit" name="cpass" class="btn btn-primary ">Submit</button>
                </form>
              </div>
              <div class="clearfix"></div>
            </div>
          </div>
          <!--<div class="tab-pane" id="Report">
            <div class="card-box align-items-stretch w-100 ">
              <h4>My Report</h4>
              <hr>
              <div class="media">
                <div class="mr-3">
                  <input type="checkbox">
                </div>
                <div class="media-body">
                  <h6>Followup Report</h6>
                </div>
              </div>
              <div class="media">
                <div class="mr-3">
                  <input type="checkbox">
                </div>
                <div class="media-body">
                  <h6>Pending Payment Report</h6>
                </div>
              </div>
              <div class="media">
                <div class="mr-3">
                  <input type="checkbox">
                </div>
                <div class="media-body">
                  <h6>New Lead Additon Report</h6>
                </div>
              </div>
              <div class="media">
                <div class="mr-3">
                  <input type="checkbox">
                </div>
                <div class="media-body">
                  <h6>Pending Task report</h6>
                </div>
              </div>
              <div class="media">
                <div class="mr-3">
                  <input type="checkbox">
                </div>
                <div class="media-body">
                  <h6>Total Sales Report</h6>
                </div>
              </div>
              <div class="media">
                <div class="mr-3">
                  <input type="checkbox">
                </div>
                <div class="media-body">
                  <h6>Order Opened Report</h6>
                </div>
              </div>
              <button type="submit" name="report" class="btn btn-primary center-block pull-right">Submit</button>
              <div class="clearfix"></div>
            </div>
          </div>-->
          
          
          
          <div class="tab-pane" id="Leaves">
            <div class="card-box align-items-stretch w-100 ">
              <div class="row">
                <div class="col">
                  <h4>My Leaves</h4>
                </div>
                <div class="col">
                  <h4 class="text-right"> <a href="javascript:void(0)"  data-toggle="modal" data-target="#Leave" class="btn-info btn">Apply Leave</a></h4>
                </div>
                
                <!-- The Modal -->
                <div class="modal fade" id="Leave">
                  <div class="modal-dialog">
                    <form action="#" id="lappl" method="post" enctype="multipart/form-data">
                      <div class="modal-content"> 
                        
                        <!-- Modal Header -->
                        <div class="modal-header">
                          <h4 class="modal-title">New Leave</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        
                        <!-- Modal body -->
                        <div class="modal-body from-to">
                          <div class="row">
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label for="">Leave Type</label>
                                <select id="outer" name="leaveType" class="validate[required] form-control">
                                  <option value="0">Full day</option>
                                  <option value="1"> Partial</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div id="Full" class="group">
                            <div class="row">
                              <div class="col">
                                <div class="form-group">
                                  <label>From</label>
                                  <div class="input-group">
                                    <input type="text" name="lfrom" id="start_date" class="validate[required] form-control from" data-errormessage-value-missing="Leave From is required!" autocomplete="off"/>
                                    <div class="input-group-append">
                                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col">
                                <div class="form-group">
                                  <label>To</label>
                                  <div class="input-group " >
                                    <input type="text" name="lto" id="end_date" class="validate[required] form-control to"  onchange="daycount();" data-errormessage-value-missing="Leave to is required!" autocomplete="off" />
                                    <div class="input-group-append">
                                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-12">
                                <div class="form-group">
                                  <label for="">Days</label>
                                  <input type="text"  name="nodays" class="form-control" id="nodays" value="" readonly="readonly">
                                </div>
                              </div>
                            </div>
                          </div>
                          <div id="Partial" class="group">
                            <div class="row">
                              <div class="col">
                                <div class="form-group">
                                  <label>Date</label>
                                  <div class="input-group">
                                    <input type="text" name="partialDate" class="validate[required] form-control" id="lfrom" data-errormessage-value-missing="Leave From is required!" autocomplete="off" />
                                    <div class="input-group-append">
                                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col">
                                <div class="row">
                                  <div class="col">
                                    <div class="form-group">
                                      <label>Time From</label>
                                      <div class="input-group">
                                        <select name="startime" class="validate[required] form-control">
                                          <option value="">Start</option>
                                          <?php 
								echo selectTimesOfDay();
								?>
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col">
                                    <div class="form-group">
                                      <label>Time To</label>
                                      <div class="input-group">
                                        <select  name="endtime" class="validate[required] form-control">
                                          <option value="">End</option>
                                          <?php 
								echo selectTimesOfDay();
								?>
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <style>
                          .ui-datepicker {
    z-index: 100000 !important;}
                          </style>
                          <link rel="stylesheet" href="https://www.toursrepublic.com/admin/css/jquery-ui.css" />
                          <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script> 
                          <script>
						 $(function() {

$(".from").datepicker({
    minDate: 0,
    maxDate: '+1Y+6M',
    onSelect: function (dateStr) {
        var min = $(this).datepicker('getDate'); // Get selected date
        $(".from").datepicker('option', 'minDate', min || '0'); // Set other min, default to today
    }
});
$("#lfrom").datepicker({
    minDate: 0,
    maxDate: '+1Y+6M',
    onSelect: function (dateStr) {
        var min = $(this).datepicker('getDate'); // Get selected date
        $(".from").datepicker('option', 'minDate', min || '0'); // Set other min, default to today
    }
});
$(".to").datepicker({
    minDate: '0',
    maxDate: '+1Y+6M',
    onSelect: function (dateStr) {
        var max = $(this).datepicker('getDate'); // Get selected date
        $('#datepicker').datepicker('option', 'maxDate', max || '+1Y+6M'); // Set other max, default to +18 months
        var start = $(".from").datepicker("getDate");
        var end = $(".to").datepicker("getDate");
        var days = (end - start) / (1000 * 60 * 60 * 24);
		console.log(days);
       $("#nodays").val(days+1);
    }
});

						 });


		  
				   $(document).ready(function () {
  $('#Partial').hide();
    $('#outer').change(function(){
        if($('#outer').val() == '1') {
            $('#Partial').show(); 
			$('#Full').hide(); 
        } else {
            $('#Partial').hide(); 
			$('#Full').show(); 
        } 
    });
});
				   </script>
                          <div class="row">
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label for="">Reason</label>
                                <textarea  name="comments" class="validate[required] form-control" placeholder="Type your reason here!" data-errormessage-value-missing="Reason is required!"></textarea>
                              </div>
                            </div>
                          </div>
                        </div>
                        
                        <!-- Modal footer -->
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                          <button type="submit" name="lapply" class="btn  btn-info">Save</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="row ManageLeads-wrp">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                  <thead>
                    <tr>
                      <th>Reason</th>
                      <th>From</th>
                      <th>To</th>
                      <th>Status</th>
                      <th>Status Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
				   $leavequery=$PDO->db_query("select * from #_leaves where userid='".$_SESSION["AMD"][0]."' order by pid DESC"); 
			while($leaveRow = $PDO->db_fetch_array($leavequery)){
			?>
                    <tr>
                      <td><?=$leaveRow['comments']?></td>
                      <td><?=$leaveRow['lfrom']==''?$leaveRow['partialDate']:$leaveRow['lfrom']?></td>
                      <td><?=$leaveRow['lto']==''?$leaveRow['startime'].' - '.$leaveRow['endtime']:$leaveRow['lto']?></td>
                      <td><?=$ADMIN->displaystatusLeave($leaveRow['status'])?></td>
                      <td><?=$leaveRow['statusDate']?></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
                <script>
   $(document).ready(function() {
    $('#example').DataTable( {
        "lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]]
    } );
} );
   </script> 
              </div>
              <hr>
              <div class="clearfix"></div>
            </div>
          </div>
          <div class="tab-pane" id="leaverequest">
            <div class="card-box align-items-stretch w-100 ">
              <div class="row">
                <div class="col">
                  <h4>Leaves Request</h4>
                </div>
        
                
           
              </div>
              <div class="ManageLeads-wrp">
                <div class="table-responsive">
                <table class="table table-striped table-bordered" style="width:100%">
                  <thead>
                    <tr>
                     <th >Name</th>
                     <th>Leave Type</th>
                      <th>Reason</th>
                      <th>From</th>
                      <th>To</th>
                       <th>No of days</th>
                      <th>Status</th>
                      <th>Status Date</th>
                       <th>Action</th>
                    </tr>
                  </thead>
    <?php
				   $leavequery=$PDO->db_query("select * from #_leaves where status=0 order by pid DESC"); 
			while($leaveRow = $PDO->db_fetch_array($leavequery)){
			?>
 <tr>
                      <td><?=$PDO->getSingleresult("select name from pms_admin_users where user_id='".$leaveRow['userid']."' and status=1");?></td>
                      <td><?=$leaveRow['leaveType']==1?'Partial':'Full day'?></td>
                      <td style="width:10%"><?=$ADMIN->html_cut($leaveRow['comments'],30)?>.. </td>
                      <td><?=$leaveRow['lfrom']==''?date('d-m-Y',strtotime($leaveRow['partialDate'])):date('d-m-Y',strtotime($leaveRow['lfrom']))?></td>
                      <td><?=$leaveRow['lto']==''?$leaveRow['startime'].' - '.$leaveRow['endtime']:$leaveRow['lto']?></td>
                       <td><?=$leaveRow['nodays']?></td>
                       <td><?=$ADMIN->displaystatusLeave($leaveRow['status'])?></td>
                    <td><?=date('d-m-Y',strtotime($leaveRow['created_on']))?></td>
                      <td>  
                      <a href="javascript:void(0)"  data-toggle="modal" data-target="#approve<?=$leaveRow['pid']?>" title="approve" class="mr-1 bg-success  text-white  pr-1 pl-1 rounded-circle"><i class="fa fa-edit" aria-hidden="true"></i></a>
</a> </td>   </tr>
     
     <div class="modal fade" id="approve<?=$leaveRow['pid']?>">
                  <div class="modal-dialog">
                    <form action="#" method="post" name="approved" enctype="multipart/form-data">
                      <div class="modal-content"> 
                        <!-- Modal Header -->
                        <div class="modal-header">
                          <h4 class="modal-title">Leaves Request</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                        <div class="form-group">
                        <label for="">Reason:</label><br />
                        <?=$leaveRow['comments']?>
                        </div>
                      <div class="form-group">
                       <label for="">Leave status</label>
                      <select id='Leavestatus<?=$leaveRow['pid']?>' name="status" class="form-control">
                      <option value="1">Approved </option> 
                      <option value="2">Disapproved </option>
                      </select>
                      </div>
                   <div class="form-group">
                   <div style='display:none;' id='Dis<?=$leaveRow['pid']?>'>
					<label>Reason</label>
					<textarea class="form-control" name="disreason"></textarea>
                   </div> </div>
                    </div>                      
 <script>   
$(document).ready(function(){
    $('#Leavestatus<?=$leaveRow['pid']?>').on('change', function() {
      if ( this.value == '2')
      //.....................^.......
      {
        $("#Dis<?=$leaveRow['pid']?>").show();
      }
      else
      {
        $("#Dis<?=$leaveRow['pid']?>").hide();
      }
    });
});
    </script>     <!-- Modal footer -->
                        <div class="modal-footer">
                        
                          <input type="hidden" name="leaveId" value="<?=$leaveRow['pid']?>" />
                          <input type="hidden" name="userid" value="<?=$leaveRow['userid']?>" />
                          <button type="submit" name="lapprove" class="btn  btn-info">Submit</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>               
   <?php } ?>   </tbody>
                </table>
                
                </div>
    
              </div>
             
              <div class="clearfix"></div>
            </div>
          </div>
          
          <div class="tab-pane" id="leaveHistory">
            <div class="card-box align-items-stretch w-100 ">
              <div class="row">
                <div class="col">
                  <h4>Leaves History</h4>
                </div>
        
                
           
              </div>
              <div class="ManageLeads-wrp">
                <div class="table-responsive">
                <table class="table table-striped table-bordered" style="width:100%">
                  <thead>
                    <tr>
                     <th >Name</th>
                     <th>Leave Type</th>
                      <th>From</th>
                      <th>To</th>
                       <th>No of days</th>
                      <th>Status</th>
                      <th>Status Date</th>
                       <th>Reason</th>
                    </tr>
                  </thead>
    <?php
				   $leavequery=$PDO->db_query("select * from #_leaves where status!=0 order by pid DESC"); 
			while($leaveRow = $PDO->db_fetch_array($leavequery)){
			?>
 <tr>
                      <td><?=$PDO->getSingleresult("select name from pms_admin_users where user_id='".$leaveRow['userid']."' and status=1");?></td>
                      <td><?=$leaveRow['leaveType']==1?'Partial':'Full day'?></td>
                      <td><?=$leaveRow['lfrom']==''?date('d-m-Y',strtotime($leaveRow['partialDate'])):date('d-m-Y',strtotime($leaveRow['lfrom']))?></td>
                      <td><?=$leaveRow['lto']==''?$leaveRow['startime'].' - '.$leaveRow['endtime']:$leaveRow['lto']?></td>
                       <td><?=$leaveRow['nodays']?></td>
                       <td><?=$ADMIN->displaystatusLeave($leaveRow['status'])?></td>
                    <td><?=date('d-m-Y',strtotime($leaveRow['created_on']))?></td>
                      <td>  
                      <?=$leaveRow['comments']?> </td>   </tr>
     
                    
   <?php } ?>   </tbody>
                </table>
                
                </div>
    
              </div>
             
              <div class="clearfix"></div>
            </div>
          </div>
          <div class="tab-pane" id="Role">
            <div class="card-box align-items-stretch w-100 ">
              <h4>My Role</h4>
              <div class="row ManageLeads-wrp">
                <div class="w-100">
                  <table id="example1" class="table table-striped table-bordered  " style="width:100%">
                    <thead>
                      <tr>
                        <th>Role </th>
                        <th>Awarded By</th>
                        <th>From Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
					  
					$mdacess=explode(':',$accessmodule);
					foreach($mdacess as $ma){
					 ?>
                      <tr>
                        <td><?=$ADMIN->displaystatusModuleAccess($ma)?></td>
                        <td><?=$PDO->getSingleresult("select name from pms_".tblName." where user_id='".$rmanager."'");?></td>
                        <td><?=date('d-m-y',strtotime($created_on));?></td>
                      </tr>
                      <?php } ?>
                  </table>
                  <script>
   $(document).ready(function() {
    $('#example1').DataTable( {
        "lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]]
    } );
} );
   </script> 
                </div>
              </div>
              <hr>
              <div class="clearfix"></div>
            </div>
          </div>
          <div class="tab-pane" id="Calendar">
            <div class="card-box align-items-stretch w-100 ">
              <h4>Holiday  Calendar</h4>
              <hr>
              <div id='calendar'></div>
              <script >
$(document).ready(function() {
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
    $('#calendar').fullCalendar({
        header: {
            left: 'prev, next today',
            center: 'title',
            right: 'month, basicWeek, basicDay'
        },
        //events: "Calendar.asmx/EventList",
        //defaultView: 'dayView',
       events: [{'date':'2018-08-15','title':'Independence Day'},{'date':'2018-10-02','title':'Gandhi Jayanti'},{'date':'2018-10-19','title':'Dussehra'},{'date':'2018-11-07','title':'Diwali'},{'date':'2018-11-09','title':'Bhai Duj'},{'date':'2018-12-25','title':'Christmas Eve'}], 
        
    });
 
});

</script><style> .fc-content{ background-color: #4CAF50;color: white;}</style>
              <hr>
              <div class="clearfix"></div>
            </div>
          </div>
          
          
          <div class="tab-pane active" id="Task">
            <div class="card-box align-items-stretch w-100 ">
              <div class="row">
                <div class="col">
                  <h4 class="mb-0 pt-3 pb-0"> Task</h4>
                </div>
                <div class="col text-right"><a href="javascript:void(0)" class="btn btn-info " title="Add New Task" data-toggle="modal" data-target="#add-new-task"><i class="fa fa-plus"></i></a></div>
                
                <!-- Add New Task  Modal -->
                <div class="modal fade" id="add-new-task">
                  <div class="modal-dialog modal-md">
                    <form name="pp" method="post" action="#" enctype="multipart/form-data">
                      <div class="modal-content"> 
                        
                        <!-- Modal Header -->
                        <div class="modal-header">
                          <h4 class="modal-title m-0 p-0">Add New Task</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        
                        <!-- Modal body -->
                        <div class="modal-body">
                          <div class="">
                            <div class="row">
                              <div class="col-12 col-md-12">
                                <div class="form-group">
                                  <label>Name</label>
                                  <input type="text" name="name" class="validate[required] form-control " value=""/>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-12 col-md-12">
                                <div class="form-group">
                                  <label for="">Deadline</label>
                                  <div class="input-group">
                                    <input type="text" class="validate[required] form-control"  name="deadLine" >
                                    <div class="input-group-append">
                                      <button type="button" class="input-group-text cursor-pointer" data-toggle="datepicker" data-target-name="deadLine" ><i class="fa fa-calendar"></i></button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-12 col-md-12">
                                <div class="form-group">
                                  <label for="">Assign to</label>
                                  <select class="validate[required] form-control" name="reciverid">
                                    <option>--Select One--</option>
                                    <?php
             $sexecutive_query = $PDO->db_query("select * from pms_admin_users where  status='1'");
				while($sexecutive_rows = $PDO->db_fetch_array($sexecutive_query)){ ?>
                                    <option value="<?=$sexecutive_rows['user_id']?>" <?=($sexecutive_rows['user_id']==$salesecutiveid)?'selected="selected"':''?>  >
                                    <?=$sexecutive_rows['name']?>
                                    </option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-12 col-md-12">
                                <div class="form-group">
                                  <label for="">Description</label>
                                  <textarea class="form-control" name="comments"> </textarea>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="submit" name="stask" class="btn btn-primary">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <hr />
              <div class="row">
                <div class="col-lg-12 col-md-12 col-12 fintab">
                  <div class="tabs-section-nav user_sidebarbox w-100 align-items-stretch">
                    <div class="nav-tabs-custom">
                      <ul class="nav nav-tabs " role="tablist">
                        <li class="nav-item"> <a class="nav-link active show" href="#AllSales" role="tab" data-toggle="tab" aria-selected="true"> All Task</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="#Inbox" role="tab" data-toggle="tab" aria-selected="false">Inbox</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="#Outbox" role="tab" data-toggle="tab" aria-selected="false">Outbox</a> </li>
                      </ul>
                      
                    
                      <!-- Tab panes -->
                      <div class="tab-content pt-3 pb-3 bg-white border-left border-bottom border-right">
                        <div role="tabpanel" class="tab-pane fade in active show" id="AllSales">
                          <div class="saleextutive filter-none">
                            <div class="row">
                              <div class="col-12 col-md-6 text-right pt-1"> Serach by user </div>
                              <div class="col-12 col-md-6">
                                <div class="form-group pr-3 ">
                                  <select class="form-control" name="userId">
                                    <option>select user</option>
                                    <?php
             $sexecutive_query = $PDO->db_query("select * from pms_admin_users where  status='1'");
				while($sexecutive_rows = $PDO->db_fetch_array($sexecutive_query)){ ?>
                                    <option value="<?=$sexecutive_rows['user_id']?>" <?=($sexecutive_rows['user_id']==$salesecutiveid)?'selected="selected"':''?>  >
                                    <?=$sexecutive_rows['name']?>
                                    </option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="w-100">
                              <table id="example3" class="table table-striped table-bordered  " style="width:100%">
                                <thead>
                                  <tr>
                                    <th>Sl No </th>
                                    <th>Name of the work</th>
                                    <th>Allocated by</th>
                                    <th>Deadline </th>
                                    <th>Reply </th>
                                    <th>Action </th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
								 $nn=1;
								 
								
             $task_query = $PDO->db_query("select * from #_task where senderid='".$_SESSION["AMD"][0]."'  or reciverid='".$_SESSION["AMD"][0]."'");
				while($task_rows = $PDO->db_fetch_array($task_query)){
					if($task_rows['dstatus']==0 && $task_rows['senderid']!=$_SESSION["AMD"][0] && $task_rows['rstatus']!=''){
						 $css='style="font-weight: bold"';
						}
					 ?>
                                  <tr>
                                    <td <?=$css?>><?=$nn?></td>
                                    <td <?=$css?>><?=$task_rows['name']?></td>
                                    <td <?=$css?>><?=$PDO->getSingleresult("select name from pms_admin_users where user_id='".$task_rows['senderid']."'");?></td>
                                    <td <?=$css?>><?=$task_rows['deadLine']?></td>
                                    <td <?=$css?>><?=$task_rows['comments']?></td>
                                    <th><a href="javascript:void(0)" onclick="reply('<?=$task_rows['pid']?>');" <?=($task_rows['reciverid']==$_SESSION["AMD"][0] && $task_rows['status']!=1)?'<i class="fa fa-reply"></i>':'<i class="fa fa-eye"></i>'?></i></a> </th>
                                  </tr>
                                    
                                  <?php $nn++;} ?>
                              </table>
                              <script>
   $(document).ready(function() {
    $('#example3').DataTable( {
        "lengthMenu": [[8,10, 25, 50, -1], [8,10, 25, 50, "All"]]
    } );
} );
   </script> 
                            </div>
                          </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="Inbox">
                          <div class="saleextutive filter-none">
                            <div class="row">
                              <div class="col-12 col-md-6 text-right pt-1"> Serach by user </div>
                              <div class="col-12 col-md-6">
                                <div class="form-group pr-3 ">
                                  <select class="form-control" name="userId">
                                    <option>select user</option>
                                    <?php
             $sexecutive_query = $PDO->db_query("select * from pms_admin_users where  status='1'");
				while($sexecutive_rows = $PDO->db_fetch_array($sexecutive_query)){ ?>
                                    <option value="<?=$sexecutive_rows['user_id']?>" <?=($sexecutive_rows['user_id']==$salesecutiveid)?'selected="selected"':''?>  >
                                    <?=$sexecutive_rows['name']?>
                                    </option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="w-100">
                              <table id="example4" class="table table-striped table-bordered  " style="width:100%">
                                <thead>
                                  <tr>
                                    <th>Sl No </th>
                                    <th>Name of the work</th>
                                    <th>Allocated by</th>
                                    <th>Deadline </th>
                                    <th>Reply </th>
                                    <th>Action </th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
								 $nn=1;
             $task_query = $PDO->db_query("select * from #_task where reciverid='".$_SESSION["AMD"][0]."'");
				while($task_rows = $PDO->db_fetch_array($task_query)){
					
						if($task_rows['dstatus']==0 && $task_rows['rstatus']!=''){
						 $css='style="font-weight: bold"';
						} ?>
                                  <tr>
                                    <td <?=$css?>><?=$nn?></td>
                                    <td <?=$css?>><?=$task_rows['name']?></td>
                                    <td <?=$css?>><?=$PDO->getSingleresult("select name from pms_admin_users where user_id='".$task_rows['senderid']."'");?></td>
                                    <td <?=$css?>><?=$task_rows['deadLine']?></td>
                                    <td <?=$css?>><?=$task_rows['comments']?></td>
                                    <th><a href="javascript:void(0)" onclick="reply('<?=$task_rows['pid']?>');" <?=$task_rows['reciverid']==$_SESSION["AMD"][0] && $task_rows['status']!=1?'<i class="fa fa-reply"></i>':'<i class="fa fa-eye"></i>'?></i></a> </th>
                                  </tr>
                                  
                                  <?php $nn++;} ?>
                              </table>
                              
                            
                              
                              <script>
   $(document).ready(function() {
    $('#example4').DataTable( {
        "lengthMenu": [[8,10, 25, 50, -1], [8,10, 25, 50, "All"]]
    } );
} );
   </script> 
                            </div>
                          </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="Outbox">
                          <div class="saleextutive filter-none">
                            <div class="row">
                              <div class="col-12 col-md-6 text-right pt-1"> Serach by user </div>
                              <div class="col-12 col-md-6">
                                <div class="form-group pr-3 ">
                                  <select class="form-control" name="userId">
                                    <option>select user</option>
                                    <?php
             $sexecutive_query = $PDO->db_query("select * from pms_admin_users where  status='1'");
				while($sexecutive_rows = $PDO->db_fetch_array($sexecutive_query)){ ?>
                                    <option value="<?=$sexecutive_rows['user_id']?>" <?=($sexecutive_rows['user_id']==$salesecutiveid)?'selected="selected"':''?>  >
                                    <?=$sexecutive_rows['name']?>
                                    </option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="w-100">
                              <table id="example5" class="table table-striped table-bordered  " style="width:100%">
                                <thead>
                                  <tr>
                                    <th>Sl No </th>
                                    <th>Name of the work</th>
                                    <th>Allocated by</th>
                                    <th>Deadline </th>
                                    <th>Reply </th>
                                    <th>Action </th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
								 $nn=1;
             $task_query = $PDO->db_query("select * from #_task where senderid='".$_SESSION["AMD"][0]."'");
			 
				while($task_rows = $PDO->db_fetch_array($task_query)){
					$css='';
					if($task_rows['dstatus']==0 && $task_rows['rstatus']!=''){
						 $css='style="font-weight: bold"';
						}
					 ?>
                                  <tr>
                                    <td <?=$css?>><?=$nn?></td>
                                    <td <?=$css?>><?=$task_rows['name']?></td>
                                    <td <?=$css?>><?=$PDO->getSingleresult("select name from pms_admin_users where user_id='".$task_rows['senderid']."'");?></td>
                                    <td <?=$css?>><?=$task_rows['deadLine']?></td>
                                    <td <?=$css?>><?=$task_rows['comments']?></td>
                                    <th><a href="javascript:void(0)" onclick="reply('<?=$task_rows['pid']?>');" <?=$task_rows['reciverid']==$_SESSION["AMD"][0] && $task_rows['status']!=1?'<i class="fa fa-reply"></i>':'<i class="fa fa-eye"></i>'?></i></a></a> </th>
                                  </tr>
                                  <?php $nn++;} ?>
                              </table>
                              
                             
                              <script>
   $(document).ready(function() {
    $('#example5').DataTable( {
        "lengthMenu": [[8,10, 25, 50, -1], [8,10, 25, 50, "All"]]
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
              <div class="clearfix"></div>
            </div>
          </div>
          <!-- <div class="tab-pane active" id="logindetail">
            <div class="card-box align-items-stretch w-100 ">
            <div class="row">
              <?php
          			  
             $ntime='['.$logintime.']';
          				if($ntime!=''){
          					$di=1;
          				foreach(array_reverse(json_decode($ntime)) as $date){
          				echo '<div class="col-sm-4 col-xs-6 col-lg-3">'. date('d F Y : h:i:s A',$date).'</div>';
          				 if ($di++ == 50) break;	
          				}	
          				}
              ?>
              </div>
              <div class="clearfix"></div>
            </div>
          </div> -->
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
  </div>
</section>

                       <form name="ar" action="#" method="post" enctype="multipart/form-data">                 <!-- Reply   Modal -->
                      <div class="modal fade" id="allreply">
                      
                       </div>   
                       </form>
<script src='js/fullcalendar.min.js'></script>
<link rel='stylesheet prefetch' href='css/fullcalendar.min.css'>
<!--Date and time picker--> 
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script> 
<script src='js/timepicker.js'></script>
<link rel="stylesheet" href="css/timepicker.css">
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css">
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
