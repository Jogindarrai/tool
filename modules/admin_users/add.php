<?php 
include(FS_ADMIN._MODS."/admin_users/admin_user.inc.php");
$ADU = new AdminUsers();
if($RW->is_post_back())
{ 
//print_r($_FILES); exit;
 $path = UP_FILES_FS_PATH."/userdoc";
   if($_FILES['userdoc'][name])
   {

			 $_POST['userdoc'] = $RW->uploadFile($path,$_FILES['userdoc']['name'],'userdoc');
			if($uid>0)

			{
				$delete_image=$PDO->getSingleresult("select userdoc from pms_".tblName." where user_id='".$uid."'");
				if($delete_image!='')

				{
				  @unlink($path.'/'.$delete_image);
				}
			}
	}
	
   if($uid)
   {
	    if($_POST['password']==''){
		   $pass=$PDO->getSingleResult("select password from pms_admin_users where user_id ='".$uid."'");
				  $_POST['password']=$pass;  
				   } else{
				 $_POST['password']=$ADU->password($_POST['password']);
				   }
	   
	   
	   $_POST['updateid']=$uid;
       $flag = $ADU->update($_POST);
   }else {
	   $flag = $ADU->add($_POST);
   }
   if($flag==1)
   {
     $RW->redir($ADMIN->iurl($comp.(($start)?'&start='.$start:'').(($subpage_id)?'&subpage_id='.$subpage_id:'').(($alumniid)?'&alumniid='.$alumniid:'').(($galleryid)?'&galleryid='.$galleryid:'')).$dlr, true);
   }
}
if($uid)
{  $query =$PDO->db_query("select * from pms_admin_users where user_id ='".$uid."' "); 

	$row = $PDO->db_fetch_array($query);
	@extract($row);	
}
?>
<section class="mt-5 mb-5">
<div class="container">
    <div class="row">
      <div class="col-lg-12   ">
        <div class="card">
          <div class="row">
            <div class="col">
              <div class="card-title">
                <h2>Add User</h2>
              </div>
            </div>
          </div>
          <div class="user-wrp">
        
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="">Name</label>
              <input type="text" class="validate[required] form-control" name="name" value="<?=$name?>" data-errormessage-value-missing="Name is required!" >
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label for="email">Email address</label>
              <input type="text" class="validate[required,custom[email]] form-control" name="email" value="<?=$email?>" data-errormessage-value-missing="Email is required!">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="">Mobile</label>
                     <input type="text" class="form-control" name="mobile" value="<?=$mobile?>" />
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label for="">OTP  Status</label>
                     <select name="forotp"  class="validate[required] form-control" data-errormessage-value-missing="OTP Status is required!">

                <option  value="">-------OTP Status------</option>

                <option value="1" <?=($forotp==1)?'selected="selected"':''?>  >Active</option>

                <option value="0" <?=(isset($forotp) && $forotp==0)?'selected="selected"':''?>>Inactive</option>

              </select>
                  </div>
                </div>
              </div>
 
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="">Reporting Manager </label>
                    <select name="rmanager" class="validate[required] form-control" data-errormessage-value-missing="Reporting Manager is required!">

                      <option value="">select manager</option>
                       <?php
				$asignQuery =$PDO->db_query("select * from pms_admin_users where 1 "); 				
	while($asignRow = $PDO->db_fetch_array($asignQuery)){?>
		<option <?=($asignRow['user_id']==$rmanager)?'selected="selected"':''?>  value="<?=$asignRow['user_id']?>"><?=$asignRow['name']?></option>
		<?php }
				?>
                    </select>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                   <?php if($uid==0){?>
            <label for="Password">Password </label>

          

              <input type="text" class="validate[required] form-control" name="password" value="" data-errormessage-value-missing="Password is required!" autocomplete="off">

           
 <?php } else { ?>
  <label for="Password">Change Password </label>

           

              <input type="text" class="form-control" name="password" value="" autocomplete="off">

           
  <?php } ?>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label>Position</label>
                 

<div class="row usertype-label">
<div class="col">
<div class="custom-control custom-checkbox">
  <input type="radio" value="1"  <?=(($user_type=='1')?'checked="checked"':'')?> class="custom-control-input" id="customCheck1"  name="user_type">
  <label class="custom-control-label" for="customCheck1">Operation Head</label>
  
</div>     
</div>

<div class="col">
                    
    <div class="custom-control custom-checkbox">
  <input type="radio" value="2"  <?=(($user_type=='2')?'checked="checked"':'')?> class="custom-control-input" id="customCheck2"  name="user_type">
  <label class="custom-control-label" for="customCheck2">Team Head</label>
  
</div>

</div>
<div class="col">
    <div class="custom-control custom-checkbox">
  <input type="radio" value="3"  <?=(($user_type=='3')?'checked="checked"':'')?> class="custom-control-input" id="customCheck3"  name="user_type">
  <label class="custom-control-label" for="customCheck3"> Sales Head</label>
  
</div>
</div>
</div>
  <div class="row  usertype-label">
<div class="col">
<div class="custom-control custom-checkbox">
  <input type="radio" value="4" <?=(($user_type=='4' or !$user_type)?'checked="checked"':'')?> class="custom-control-input" id="customCheck4"  name="user_type">
  <label class="custom-control-label" for="customCheck4">Executive Assistance</label>
  
</div>     
</div>

<div class="col">
                    
    <div class="custom-control custom-checkbox">
  <input type="radio" value="5" <?=(($user_type=='5' or !$user_type)?'checked="checked"':'')?> class="custom-control-input" id="customCheck5"  name="user_type">
  <label class="custom-control-label" for="customCheck5"> Sales Executive</label>
  
</div>

</div>
<div class="col">
    <div class="custom-control custom-checkbox">
  <input type="radio" value="6"  <?=(($user_type=='6')?'checked="checked"':'')?> class="custom-control-input" id="customCheck6"   name="user_type">
  <label class="custom-control-label" for="customCheck6"> CEO</label>
  
</div>

</div>

</div>     </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label for="email">Status</label>
                    <select name="status"  class="validate[required] form-control" data-errormessage-value-missing="Status is required!">

                <option  value="">-------Select Status------</option>

                <option value="1" <?=($status==1)?'selected="selected"':''?>  >Active</option>

                <option value="0" <?=(isset($status) && $status==0)?'selected="selected"':''?>>Inactive</option>

              </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label>PMS Access</label>
                    <?php 
					$acc=explode(':',$accessmodule);
					//print_r($acc);
					?>
<div class="row usertype-label">
<div class="col">
<div class="custom-control custom-checkbox">
  <input type="checkbox" name="accessmodule[]" value="1" <?=in_array('1',$acc)?'checked="checked"':''?>  class="custom-control-input" id="1">
  <label class="custom-control-label" for="1">SEO Master</label>
</div> 
</div>
<div class="col">
<div class="custom-control custom-checkbox">
  <input type="checkbox" name="accessmodule[]" value="2" <?=in_array('2',$acc)?'checked="checked"':''?>  class="custom-control-input" id="2">
  <label class="custom-control-label" for="2">TM Master </label>
</div> 
</div>
<div class="col">
<div class="custom-control custom-checkbox">
  <input type="checkbox" name="accessmodule[]" value="3" <?=in_array('3',$acc)?'checked="checked"':''?>  class="custom-control-input" id="3">
  <label class="custom-control-label" for="3">Proposals Manager </label>
</div> 
</div>
<div class="col">
<div class="custom-control custom-checkbox">
  <input type="checkbox" name="accessmodule[]" value="4" <?=in_array('4',$acc)?'checked="checked"':''?>  class="custom-control-input" id="4">
  <label class="custom-control-label" for="4">My Leads</label>
</div>  
</div>
<div class="col">
<div class="custom-control custom-checkbox">
  <input type="checkbox" name="accessmodule[]" value="5" <?=in_array('5',$acc)?'checked="checked"':''?>  class="custom-control-input" id="5">
  <label class="custom-control-label" for="5">Invoice Manager</label>
</div>  
</div>
<div class="col">
<div class="custom-control custom-checkbox">
  <input type="checkbox" name="accessmodule[]" value="6" <?=in_array('6',$acc)?'checked="checked"':''?>  class="custom-control-input" id="6">
  <label class="custom-control-label" for="6">Master</label>
</div>  
</div>
<!-- <div class="col">
<div class="custom-control custom-checkbox">
  <input type="checkbox" name="accessmodule[]" value="7" <?=in_array('7',$acc)?'checked="checked"':''?>  class="custom-control-input" id="7">
  <label class="custom-control-label" for="7">CRMS</label>
</div> 
</div> -->
</div>
</div>  
 </div>
</div>    
 <div class="row">
 <div class="col">
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
   <div class="col">  <div class="form-group">
 
    <label for="">Upload document <small>(aadhar card, pan card , driving licence)</small></label>  <?=$ADMIN->viewimage('userdoc',$userdoc);?>
    <input type="file" name="userdoc" class="form-control" id="userdoc">
  </div></div>
   
   </div>  <button type="submit" name="submit" class="btn btn-primary pull-right">Submit</button>
         
          </div>
        </div>
      </div>
     
    </div>
    </div>
</section>
