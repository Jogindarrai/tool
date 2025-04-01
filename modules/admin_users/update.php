<?php 
include(FS_ADMIN._MODS."/admin_users/admin_user.inc.php");


$ADU = new AdminUsers();

if($BSC->is_post_back())
{
   if($uid)
   {
	   $_POST['updateid']=$uid;
	   
	   if($password!='' && $cpassword!='' && $cpassword==$password )
	   {
		   $_POST['password'] = $ADU->password($_POST['password']);
		   $flag = $ADU->update($_POST);   
	   }else {
		   
		 $ADMIN->sessset('Confirm password is not match.', 'e');  
	   }
       
  
   }
   
   
}



$query =$PDO->db_query("select * from pms_admin_users where user_id ='".$_SESSION["AMD"][0]."' "); 
$row = $PDO->db_fetch_array($query);
@extract($row);	


?>
<div class="content">
<div class="div-tbl">
        <div class="title">
          <div class="fl"><img src="images/form-icon.png" alt="">Forms</div>
          <div class="cl"></div>
        </div>
        <div class="tbl-contant">
             <?=$ADMIN->alert()?> 
          <div class="tbl-name">
            <h3>Add - <?=$ADMIN->compname($comp)?></h3>
            <!--<small>we can add user detail here</small>-->
            <div class="cl"></div>
             <?=$ADMIN->alert()?>
          </div>
           
          <div class="section">
            <label> Name <small><span class="red">* Required field
</span></small></label>
            <div class="sectioninner">
              <input type="text" class="validate[required] txt large" name="name" value="<?=$name?>" data-errormessage-value-missing="Name is required!"  >
              <!--<span class="f_help"><span class="red">* Required field
</span></span>--></div>
          </div>
          
           <div class="section">
            <label> Email <small><span class="red">* Required field
</span></small></label>
            <div class="sectioninner">
              <input type="text" class="validate[required,custom[email]] txt large" name="email" value="<?=$email?>" data-errormessage-value-missing="Email is required!" readonly="readonly">
              <!--<span class="f_help"><span class="red">* Required field
</span></span>--></div>
          </div>
          
         
          <div class="section">
            <label> Password <small><span class="red">* Required field
</span></small></label>
            <div class="sectioninner">
              <input type="password" class="validate[required] txt large" name="password" value="" data-errormessage-value-missing="Password is required!">
              <!--<span class="f_help"><span class="red">* Required field
</span></span>--></div>
          </div>
          
          <div class="section">
            <label>Confirm Password <small><span class="red">* Required field
</span></small></label>
            <div class="sectioninner">
              <input type="password" class="validate[required] txt large" name="cpassword" value="" data-errormessage-value-missing="Confirm Password is required!">
              <!--<span class="f_help"><span class="red">* Required field
</span></span>--></div>
          </div>
          
          
          
         
          
          
          <div class="section last">
            <div class="sectioninner">
              <input type="hidden" name="uid" value="<?=$_SESSION["AMD"][0]?>" />
              
              <input type="submit" class="uibutton loading"  value="submit" >
              <input type="button" class="uibutton  special"  value="clear form" onclick="location.reload();">
            </div>
          </div>
        </div>
      </div>
      
</div>
<script>
		jQuery(document).ready(function(){
			// binds form submission and fields to the validation engine
			jQuery("#formID").validationEngine({promptPosition: 'inline'});
		});
</script>