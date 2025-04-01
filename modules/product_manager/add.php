<?php 
include(FS_ADMIN._MODS."/product_manager/product_manager.inc.php");

$PAGS = new Pages();
if($RW->is_post_back())
{
	$_POST['url'] =$ADMIN->baseurl($name);
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
    $query =$PDO->db_query("select * from #_".tblName." where pid ='".$uid."' "); 
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
              <h2>Add Service</h2>
            </div>
            
          </div>
          <div class="user-wrp">
          
              <div class="row">
                <div class="col-12 col-md-6">
                  <div class="form-group">
                    <label for="">Name of Service</label>
                    <input type="text" name="name" class="validate[required] form-control"  value="<?=$name?>">
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="form-group">
                    <label for="">Price</label>
                    <input type="text" name="price" class="validate[required] form-control" value="<?=$price?>" >
                  </div>
                </div>
              </div>
              
              
              <div class="row">
                <div class="col-12 col-md-6">
                  <div class="form-group">
                    <label for="">SAC/HSN</label>
                    <input type="text" name="sacCode" class="validate[required] form-control"  value="<?=$sacCode?>">
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="form-group">
                    <label for="">Tax</label>
                    <input type="text" name="tax" class="validate[required] form-control" value="<?=$tax?>" >
                  </div>
                </div>
              </div>
              <div class="row">
              <div class="col-12 col-md-6">
                  <div class="form-group">
                    <label for="">Department </label>
                    <select name="dpid" class="validate[required] form-control" data-errormessage-value-missing="Department is required!">

                      <option value="">Select Department</option>
                       <?php
				$asignQuery =$PDO->db_query("select * from #_department where status=1"); 				
	while($asignRow = $PDO->db_fetch_array($asignQuery)){?>
		<option <?=($asignRow['pid']==$dpid)?'selected="selected"':''?>  value="<?=$asignRow['pid']?>"><?=$asignRow['name']?></option>
		<?php }
				?>
                    </select>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="form-group">
                    <label for="">Status</label>
                       <select name="status"  class="validate[required] form-control" data-errormessage-value-missing="Status is required!">
            <option  value="">-------Select Status------</option>
            <option value="1" <?=($status==1)?'selected="selected"':''?>  >Active</option>
            <option value="0" <?=(isset($status) && $status==0)?'selected="selected"':''?>>Inactive</option>
          </select>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="form-group">
                 
                  </div>
                </div>
              </div>
              <div class="row">
                
                <div class="col-12 col-md-12">
                  <div class="form-group">
                    <label for="">Proposal</label>
                     <?=$ADMIN->get_editor('proposal', stripcslashes($proposal),'','100%')?>
               
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