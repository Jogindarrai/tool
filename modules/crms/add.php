<?php 
  include(FS_ADMIN._MODS."/crms/crms.inc.php");
  $PAGS = new Pages();
  
  if($RW->is_post_back())
  {
	
  //print_r($_POST); exit;	
	/* $path = UP_FILES_FS_PATH."/clientdetail/";
  
  $count = 0;
   if($_FILES['upload'][name]){
	  // Loop $_FILES to execute all files
	  foreach ($_FILES['upload']['name'] as $f => $fname) {     
		  if ($_FILES['upload']['error'][$f] == 0) {	           
			   // No error found! Move uploaded files 
			   $fname=mt_rand(10,999).'_'.$fname;
				  if(move_uploaded_file($_FILES["upload"]["tmp_name"][$f], $path.$fname)) {
					  $count++; // Number of successfully uploaded files
				 $filename[]=$fname;
			  }
		  }
	  }
	  
  }
  /*	$_POST['upload']=$filename;
	  if($_POST['allfl']!=''){
		  $allflss = explode(":", $_POST['allfl']);
	  $_POST['upload']=array_merge($allflss,$_POST['upload']);
		  }*/
	 $_POST['url'] =$ADMIN->baseurl($name);
	  
	 if($uid)
	 {
		 $_POST['updateid']=$uid;
		 $flag = $PAGS->update($_POST);
	
	 }else {
		 $flag = $PAGS->add($_POST);
		 
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
		$RW->redir($ADMIN->iurl($comp.(($start)?'&start='.$start:'').(($subpage_id)?'&subpage_id='.$subpage_id:'').(($source)?'&source='.$source:'')), true);
	 }
  }
  
  
  if($uid)
  {
	  $query =$PDO->db_query("select * from #_".tblName." where pid ='".$uid."' "); 
	  $row = $PDO->db_fetch_array($query);
	  @extract($row);	
  }
  
  ?>

<section class="mt30">
  <div class="container ">
    <div class="row">
      <div class="col-lg-12   ">
        <div class="card">
          <div class="row">
            <div class="col">
              <div class="card-title">
                <h2>Add <?=ucfirst($comp)?></h2>
              </div>
            </div>
          </div>
          <div class="user-wrp">
           
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="">Client Name</label>
                    <input type="text" name="name" value="<?=$name?>" class="validate[required] form-control">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label for="email">Company Name </label>
                    <input type="text" name="cname" value="<?=$cname?>" class="validate[required] form-control">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="email">Contact Email</label>
                    <input type="text" class="validate[required,custom[email]] form-control" name="email" value="<?=$email?>" data-errormessage-value-missing="Email is required!">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <div class="form-group">
                      <label for="">Contact Phone</label>
                      <input type="tel" class="validate[required,custom[mobile]] form-control" name="phone" max="10" value="<?=$phone?>" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                      <label for="">Quotation</label>
                      <input type="number" class="validate[required] form-control" name="quotation" value="<?=$quotation?>" />
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                   
                    
                  
                  <div class="p-3" data-role="dynamic-fields">
              <?php
			 
			   $fyear=explode(':',$fy);
			
			 if(count(array_filter($fyear))>0){
				foreach($fyear as $fid){
				 ?>
                  <div class="row addcontainer">
                    <div class="col">
                     <label for="" class="text-left col-12"> Financial Year</label>
                      <div class="form-group">
                        <select name="fy[]" class="validate[required] form-control" data-errormessage-value-missing="Financial Year is required!">
                    <?php $fyear=explode(':',$fy); ?>
                      <option value="">-------select Financial Year------</option>
                     <option value="2014-15" <?=(in_array('2014-15',$fyear))?'selected="selected"':''?>  >2014-15</option>
            <option value="2015-16" <?=(in_array('2015-16',$fyear))?'selected="selected"':''?>>2015-16</option>
             <option value="2016-17" <?=(in_array('2016-17',$fyear))?'selected="selected"':''?>  >2016-17</option>
              <option value="2017-18" <?=(in_array('2017-18',$fyear))?'selected="selected"':''?>  >2017-18</option>
              <option value="2018-19" <?=(in_array('2018-19',$fyear))?'selected="selected"':''?>  >2018-19</option>
               <option value="2019-20" <?=(in_array('2019-20',$fyear))?'selected="selected"':''?>  >2019-20</option>
                    </select>  
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
                  <label for="" class="text-left col-12"> Financial Year</label>
                    <div class="col">
                      <div class="form-group">
                        <select name="fy[]" class="validate[required] form-control" data-errormessage-value-missing="Financial Year is required!">
                    <?php $fyear=explode(':',$fy); ?>
                      <option value="">-------select Financial Year------</option>
             <option value="2014-15" <?=(in_array('2014-15',$fyear))?'selected="selected"':''?>  >2014-15</option>
            <option value="2015-16" <?=(in_array('2015-16',$fyear))?'selected="selected"':''?>>2015-16</option>
             <option value="2016-17" <?=(in_array('2016-17',$fyear))?'selected="selected"':''?>  >2016-17</option>
              <option value="2017-18" <?=(in_array('2017-18',$fyear))?'selected="selected"':''?>  >2017-18</option>
               <option value="2018-19" <?=(in_array('2018-19',$fyear))?'selected="selected"':''?>  >2018-19</option>
               <option value="2019-20" <?=(in_array('2019-20',$fyear))?'selected="selected"':''?>  >2019-20</option>
                    </select>  
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
                </div>
                </div>
              </div>
         
              
              <div class="row"> 
                
                 <div class="col">
					<div class="form-group">
                    <label>Comment</label>
                    <textarea name="comments" class="form-control"><?=stripcslashes($comments)?></textarea>
                  </div>
				  </div>  
              </div>
           
              <div class="row" id="otp" style="display:none;"> 
                
                 <div class="col">
                <div class="form-group col-md-6 float-right">
                  <label for="OTP">OTP <small id="aperror"></small></label>
                    <input id="OTPf" type="text" class="validate[required] form-control" name="otp">
                 
                </div>  </div>
                </div>
            <input type="hidden" name="salesmid" value="9" />
              <button type="submit"  class="btn btn-primary pull-right">Submit</button>
           
          </div>
        </div>
      </div>
      <!--<div class="col-sm-3">
		  <ul class="sidebar list-unstyled">
			<li> <a href="#"> <i class="fa fa-arrow-circle-right"></i> Proposal</a> </li>
			<li> <a href="#"> <i class="fa fa-arrow-circle-right"></i> Payment Link</a> </li>
			<li> <a href="#"><i class="fa fa-arrow-circle-right"></i> Quick Lead add</a> </li>
			<li> <a href="#"><i class="fa fa-arrow-circle-right"></i> Invoice Manager</a> </li>
			<li> <a href="#"><i class="fa fa-arrow-circle-right"></i> My Order</a> </li>
			<li> <a href="#"><i class="fa fa-arrow-circle-right"></i> My Assocaites</a> </li>
			<li> <a href="#"><i class="fa fa-arrow-circle-right"></i> Exclamation of tickets</a> </li>
		  </ul>
		</div>--> 
    </div>
  </div>
  </div>
</section>
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
         // new_field_group.find('label').html('Financial Year'); new_field_group.find('input, select, textarea').each(function(){
              //  $(this).val('');
          //  });
            container.append(new_field_group);
        }
    );
});
    </script>
<?php if(!$uid){ ?>
<script>
  $(document).ready(function(e) {
$('body').on('submit','.formular',function (event) {
	  event.preventDefault();
	$('#otp').show();
	  $(document).unbind('submit');	 
	data= {'otp':$('#OTPf').val()}
$.ajax({
    type: "POST",
    url: "<?=SITE_PATH_ADM?>modules/crmsAjax.php",
    data: data,
    success: function(msg) {
	$('#aperror').html(msg);	
	if(msg.trim()=='ok'){
		$('form')[0].submit();
		}
		},
    error: function() {
        alert('error handing here');

    }

});

	return false;

			
    //$('.formular').addClass('was-validated');
});});  
</script>
<?php } ?>