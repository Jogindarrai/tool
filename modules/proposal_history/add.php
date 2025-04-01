<?php 

include(FS_ADMIN._MODS."/proposal_history/product_manager.inc.php");

$PAGS = new Pages();
if($RW->is_post_back())
{
	 $msql = "SELECT * FROM #_product_manager WHERE pid='".$serviceid."'";
$mry=$PDO->db_query($msql);

$mres = $PDO->db_fetch_array($mry);
$msg=str_replace('x,xxx',$price,$mres['proposal']);
$names=str_replace('signatures',$RW->emailSignature($ADMIN->user_type($_SESSION["AMD"][3])),$msg);	   
$msgf1 =str_replace('cnamexxx',$_POST['name'],$names);		
	  $to=$_POST['email'];
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: TrademarkBazaar <support@trademarkbazaar.com>' . "\r\n";
		
		$headers .= 'Reply-To:cagauravbansal1@gmail.com,' .$_SESSION["AMD"][2]."\r\n";
	    $headers .= 'Cc: cagauravbansal1@gmail.com,' .$_SESSION["AMD"][2]. "\r\n";
		$subject=$subject;
		$messagebody=$msgf1; 
		$mails=@mail($to, $subject, $messagebody, $headers, '-fsupport@trademarkbazaar.com');
		  $_POST['mailbody']=$messagebody;
		  $_POST['subject']=$subject;
   if($uid)
   {
	   $_POST['updateid']=$uid;
       $flag = $PAGS->update($_POST);
  
   }else {
	  
	   $flag = $PAGS->add($_POST);
	   
   }
   
   if($flag==1)
   {
   
      $RW->redir($ADMIN->iurl($comp.(($start)?'&start='.$start:'').(($subpage_id)?'&subpage_id='.$subpage_id:'')), true);
   }
}
if($uid)
{
    $query =$PDO->db_query("select * from #_proposalsent where pid ='".$uid."' "); 
	$row = $PDO->db_fetch_array($query);
	@extract($row);	
}
?>
<section>
  <div class="container ">
    <div class="row">
      <div class="col-lg-12   ">
        <div class="card">
          <div class="row">
            <div class="col-12 col-md-6">
            <!--  <h2>Add Package</h2>-->
            </div>
            
          </div>
          <div class="user-wrp">
          <div class="row">
                <div class="col-12 col-md-6">
                  <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="name" class="validate[required] form-control"  value="<?=$name?>">
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" name="email" class="validate[required] form-control"  value="<?=$email?>">
                  </div>
                </div>
              </div>
              
              <div class="row">
              <div class="col-12 col-md-6">
                  <div class="form-group">
                    <label for="">Price</label>
                    <input type="text" name="price" class="validate[required] form-control"  value="<?=$price?>">
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="form-group">
                    <label for="">Service</label>
                    <select name="serviceid" class="validate[required] form-control" data-errormessage-value-missing="Service is required!">
                              <option value="">-------select service------</option>
                              <?php 
 $service_query = $PDO->db_query("select * from #_product_manager where status='1' and proposal!=''");
                while($service_rows = $PDO->db_fetch_array($service_query)){ ?>
                              <option value="<?=$service_rows['pid']?>" <?=($service_rows['pid']==$serviceid)?'selected="selected"':''?>  >
                              <?=$service_rows['name']?>
                              </option>
                              <?php } ?>
                            </select>  
                  </div>
                </div>
                
              </div>
              <div class="row">
                <div class="col-12 col-md-12">
                  <div class="form-group">
                    <label for="">Email Subject</label>
                    <input type="text" name="subject" class="validate[required] form-control"  value="<?=$subject?>">
                  </div>
                </div>
                
              </div>
               <button type="submit" class="btn btn-primary pull-right">Submit</button>
         
          </div>
        </div>
      </div>
  
    </div>
  </div>
  </div>
</section>

<script>

		jQuery(document).ready(function(){

			jQuery("#formID").validationEngine({promptPosition: 'inline'});

			$('.icon').iconpicker();

		});

$(document).on('click', '.browse', function(){

  var file = $(this).parent().parent().parent().find('.file');

  file.trigger('click');

});

$(document).on('change', '.file', function(){

  $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));

});

</script>