<?php 
include(FS_ADMIN._MODS."/crms/crms.inc.php");
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
	/*start send Porposal */
	if(isset($_POST['psend'])){
	$_POST['leadid']=str_replace('CR','',$_POST['leadid']);
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
	$PDO->sqlquery("rs",'crms',$lead,'pid',$_POST['leadid']);
  
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

 $RW->redir($ADMIN->iurl($comp.(($start)?'&start='.$start:'').(($subpage_id)?'&subpage_id='.$subpage_id:'')), true);   
	
	
	}
/*end send Porposal */
/*start  send payment link */
if(isset($_POST['paylink'])){

//print_r($_POST);  exit;

$ps['lid']=str_replace('CR','',$_POST['leadid']);	

$ps['status']=5;

$ps['sentBy']=$_SESSION["AMD"][0];

$PDO->sqlquery("rs",'plinksent',$ps);

$ps['lid']=str_replace('CR','',$_POST['leadid']);

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
				$serviceName=$PDO->getsingleresult("select name from #_product_manager where pid='".$_POST['service']."'");
			
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
                              <td bgcolor="#00293c" style="padding:10px 20px; background-color:#00293c; color:#fff;"><p style="padding-left:10px; margin:0"> Dear, '.$_POST['name'].'</p></td>
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
                                      <td style="padding:10px 20px;"><p style="margin:10px 0; text-align:center; line-height:24px; color:#00293c;"> <a href="" style="display:inline-block; padding:10px 50px; color:#fff; font-weight:bold; background:#00293c; text-decoration:none;">Rs. '.$_POST['payamount'].'/-</a></p></td>
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

         $to=$_POST['email'];
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: Registrationwala <support@registrationwala.com>' . "\r\n";
		
		$headers .= 'Reply-To:support@registrationwala.com,vikram@registrationwala.com,mayank@registrationwala.com,cagauravbansal1@gmail.com,' .$_SESSION["AMD"][2]."\r\n";
	    $headers .= 'Cc: support@registrationwala.com,vikram@registrationwala.com,mayank@registrationwala.com,cagauravbansal1@gmail.com,' .$_SESSION["AMD"][2]. "\r\n";
		$subject='Payment Request from Registrationwala | '.$serviceName.' | '.$_POST['leadid'];
		$mails=mail($to, $subject, $mailbody, $headers, '-fsupport@registrationwala.com');
		$st['status']=5;
$PDO->sqlquery("rs",'crms',$st,'pid',str_replace('CR','',$_POST['leadid']));	
	
$ADMIN->sessset('Payment link has been sent to '.$_POST['name'], 's');

$RW->redir($ADMIN->iurl($comp.(($start)?'&start='.$start:'').(($subpage_id)?'&subpage_id='.$subpage_id:'')), true);


}
}
if($_SESSION["AMD"][3]=='5'){
 $extra1 = " and  create_by='".$_SESSION["AMD"][0]."'";  
}

if($_SESSION["AMD"][3]=='4' && $_SESSION["AMD"][5]==6){

  $extra1 = " and  taxexe='".$_SESSION["AMD"][0]."'"; 
}
if($_SESSION["AMD"][3]=='4' && $_SESSION["AMD"][5]==4){

  $extra1 = " and  incexe='".$_SESSION["AMD"][0]."'"; 
}
if(isset($create_by)){
 $extra = " and create_by='".$create_by."'"; 
	}
if(isset($fy)){
 $extra = " and find_in_set('".$fy."', Replace(fy, ':', ',')) "; 
 
	}	
if($city){
 $extra = " and city='".$city."'"; 
	}
if(isset($status)){
 $extra = " and status='".$status."'"; 
	}	

$start = intval($start);
$pagesize = intval($pagesize)==0?(($_SESSION["totpaging"])?$_SESSION["totpaging"]:DEF_PAGE_SIZE):$pagesize;
list($result,$reccnt) = $PAGS->display($start,$pagesize,$fld,$otype,$search_data,$zone,$mtype,$extra,$extra1,$extra2);

?>
<section class="">
  <div class="container ">
    <div class="row">
      <div class="col-12  mb-3  ">
    
        
        <a href="<?=SITE_PATH_ADM.'index.php?comp='.$comp.'&mode=add'?>" class="btn btn-success">Quick Lead add</a>
  
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-title">
          <div class="col-sm-6 col-md-6 col-xs-12 float-left">
            <h2>Manage CRMS </h2>  
            
      </div> 
    
   
          </div>
          <div class="ManageLeads-wrp ">
          
            <div class="row mbt15 leadfilter">
             
             
              <div class="col">
              <label>Financial Year</label>
              <select name="fy" onchange="getfilter(this.value,'fy');" class="form-control" >
             <option value="">All</option>
             <option value="2014-15" <?=('2014-15'==$fy)?'selected="selected"':''?>  >2014-15</option>
            <option value="2015-16" <?=('2015-16'==$fy)?'selected="selected"':''?>>2015-16</option>
             <option value="2016-17" <?=('2016-17'==$fy)?'selected="selected"':''?>  >2016-17</option>
              <option value="2017-18" <?=('2017-18'==$fy)?'selected="selected"':''?>  >2017-18</option>
               <option value="2018-19" <?=('2018-19'==$fy)?'selected="selected"':''?>  >2018-19</option>
               <option value="2019-20" <?=('2019-20'==$fy)?'selected="selected"':''?>  >2019-20</option>
                </select>
              </div>
				<div class="col">
                <label>Lead Owner</label>
                <select name="create_by" onchange="getfilter(this.value,'create_by');" class="form-control" >
                 <option value="">--Select--</option>
                   <?php 
 $sem_query = $PDO->db_query("select create_by from #_crms where 1 GROUP BY create_by");
                while($sem_rows = $PDO->db_fetch_array($sem_query)){ ?>
                <option value="<?=$sem_rows['create_by']?>" <?=($sem_rows['create_by']==$create_by)?'selected="selected"':''?>><?=$PDO->getSingleresult("select name from pms_admin_users where user_id='".$sem_rows['create_by']."'")?></option>
                                <?php } ?>
                </select>
              </div>	
						  
		
              <div class="col">
                <label>Status</label>
                <select name="status" onchange="getfilter(this.value,'status');" class="form-control">
                   <option value="">All</option>
             <option value="0" <?=('0'==$status)?'selected="selected"':''?>>Open</option>
           <option value="1" <?=('1'==$status)?'selected="selected"':''?>>Close</option>
                </select>
              </div>
              
              
            </div>
          
            
            <div class="row">
              <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" >
                  <thead>
                    <tr>
                      <th><?=$ADMIN->check_all()?></th>
                      <th>CRMS#</th>
                      <th>Company Name</th>
                      <th>Email</th>
                       <th>Phone</th>
                      <th>Amount</th>
                      <th>Balance</th>
                      <th>Lead Owner</th>
                       <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if($reccnt)
			      { $nums = (($start)?$start+1:1); 
				    while ($line = $PDO->db_fetch_array($result))
				    { @extract($line);$css =($css=='odd')?'even':'odd';
					if($dp==1){
				$style='style="background-color:red"';
					} else {
						$style='';
						}
					$services=$PDO->getSingleresult("select name from #_product_manager where pid='".$service."'");
					if($department==2 || $_SESSION["AMD"][3]=='5' || $_SESSION["AMD"][3]=='3'){
						$leadowner=$salesecutiveid;
						}else { $leadowner=$deid; }
$recAmount=$PDO->getSingleresult("select sum(qAmount) from #_paymentdetails_crms where lid='".$pid."'");	
$costAmiount=$PDO->getSingleresult("select sum(costprice) from #_cost_list where lid='".$pid."'");
			?>
                    <tr <?=$style?>>
                      <td><?=$ADMIN->check_input($rwi)?></td>
                      <td><?=$rwi?></td>
                      <td><?=$cname?></td>
                      <td><?=$email?></td>
                      <td><?=$phone?> </td>
                      <td><?=$quotation?></td>
                      <td><?=$quotation-$recAmount?></td>
                      
                       <td><?=$PDO->getSingleresult("select name from pms_admin_users where user_id='".$create_by."'")?> </td>
                      <td><?=$ADMIN->displaystatusCompliance($status);?> </td>
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
if(a==''){
	window.location.href = '<?=SITE_PATH_ADM."index.php?comp=".$comp?>';	
	}else {
		
 	window.location.href = '<?=SITE_PATH_ADM."index.php?comp=".$comp?>&'+b+'='+a;	
	}
				}

</script>

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