<?php 

include(FS_ADMIN._MODS."/admin_users/admin_user.inc.php");

/*
if($_SESSION["AMD"][3]!=1 || $_SESSION["AMD"][3]!='6' || $_SESSION["AMD"][3]!='7'){
	$BSC->redir(SITE_PATH_ADM, true);
	}
*/

$ADU = new AdminUsers();



if($BSC->is_post_back())

{

   if($uid)

   {

	   $_POST['updateid']=$uid;

       $flag = $ADU->update($_POST);

  

   }else {

	 

	   $flag = $ADU->add($_POST);

	   

	     

   }

   

   if($flag==1)

   {

   

     $BSC->redir($ADMIN->iurl($comp.(($start)?'&start='.$start:'').(($subpage_id)?'&subpage_id='.$subpage_id:'').(($alumniid)?'&alumniid='.$alumniid:'').(($galleryid)?'&galleryid='.$galleryid:'')).$dlr, true);

   }

}





if($uid)

{

    $query =$PDO->db_query("select * from pms_admin_users where user_id ='".$uid."' "); 

	$row = $PDO->db_fetch_array($query);

	@extract($row);	

}



?>

<div class="content">

<div class="div-tbl">

        <div class="title">

          <div class="fl"><img src="images/form-icon.png" alt="">Forms</div>

          <div class="cl"></div>

        </div>

        <div class="tbl-contant">

             

          <div class="tbl-name">

            <h3  >Add - <?=$ADMIN->compname($comp)?></h3>


            <div class="cl"></div>

             <?=$ADMIN->alert()?>

          </div>

           

          <div class="section">

            <label> Name <small><span class="red">* Required field

</span></small></label>

            <div class="sectioninner">

              <input type="text" class="validate[required] txt large" name="name" value="<?=$name?>" data-errormessage-value-missing="Name is required!" >
</div>

          </div>

          

           <div class="section">

            <label> Email <small><span class="red">* Required field

</span></small></label>

            <div class="sectioninner">

              <input type="text" class="validate[required,custom[email]] txt large" name="email" value="<?=$email?>" data-errormessage-value-missing="Email is required!">

             </div>

          </div>
<div class="section">

            <label> Mobile <small><span class="red">* Required field

</span></small></label>

            <div class="sectioninner">

              <input type="text" class="txt large" name="mobile" value="<?=$mobile?>" />
</div>

          </div>
          
<div class="section">

            <label> OTP status <small><span class="red">* Required field

</span></small></label>

            <div class="sectioninner">

              <select style="width: 70.5%;" name="forotp"  class="validate[required] txt   select-txt" data-errormessage-value-missing="OTP Status is required!">

                <option  value="">-------OTP Status------</option>

                <option value="1" <?=($forotp==1)?'selected="selected"':''?>  >Active</option>

                <option value="0" <?=(isset($forotp) && $forotp==0)?'selected="selected"':''?>>Inactive</option>

              </select>
</div>

          </div>

<div class="section">

            <label> Group<small><span class="red">* Required field

</span></small></label>

            <div class="sectioninner">

              <select name="usergroup" style="width: 70.5%;" class="validate[required] txt   select-txt" data-errormessage-value-missing="Asign Group is required!">

                <option  value="">-------Asign group------</option>

                <?php
				$asignQuery =$PDO->db_query("select * from pms_admin_users where 1 "); 				
	while($asignRow = $PDO->db_fetch_array($asignQuery)){?>
		<option <?=($asignRow['user_id']==$usergroup)?'selected="selected"':''?>  value="<?=$asignRow['user_id']?>"><?=$asignRow['name']?></option>
		<?php }
				?>

              </select>

              <!--<span class="f_help">Text custom help</span>--></div>

          </div>
        

          <div class="section">
 <?php if($uid==0){?>
            <label> Password <small><span class="red">* Required field</span></small>
            </label>

            <div class="sectioninner">

              <input type="text" class="validate[required] txt large" name="password" value="" data-errormessage-value-missing="Password is required!" autocomplete="off">

             </div>
 <?php } else { ?>
  <label>Change Password 
  </label>

            <div class="sectioninner">

              <input type="text" class=" txt large" name="password" value="" autocomplete="off">

             </div>
  <?php } ?>


          </div>

          

         

          

          <div class="section">

            <label> User Type<small><span class="red">* Required field

</span></small></label>

            <div class="sectioninner">
<input value="1"  <?=(($user_type=='1')?'checked="checked"':'')?> type="radio" name="user_type"/>&nbsp;Operation Head<br/><br/>

     <input value="2"  <?=(($user_type=='2')?'checked="checked"':'')?> type="radio" name="user_type"/>&nbsp;Team Head<br/><br/>
     
     <input value="3"  <?=(($user_type=='3')?'checked="checked"':'')?> type="radio" name="user_type"/>&nbsp;Sales Head<br/><br/>
<input value="4" <?=(($user_type=='4' or !$user_type)?'checked="checked"':'')?> type="radio" name="user_type"/>&nbsp;Executive Assistance
<br/><br/>
<input value="5" <?=(($user_type=='5' or !$user_type)?'checked="checked"':'')?> type="radio" name="user_type"/>&nbsp;Sales Executive
<br/><br/>
<input value="6"  <?=(($user_type=='6')?'checked="checked"':'')?> type="radio" name="user_type"/>&nbsp;CEO<br/><br/>
<input value="7"  <?=(($user_type=='7')?'checked="checked"':'')?> type="radio" name="user_type"/>&nbsp;COO<br/><br/>

        
</div>

          </div>

          

          

          

          <div class="section">

            <label> status<small><span class="red">* Required field

</span></small></label>

            <div class="sectioninner">

              <select name="status"  class="validate[required] txt   select-txt" data-errormessage-value-missing="Status is required!">

                <option  value="">-------Select Status------</option>

                <option value="1" <?=($status==1)?'selected="selected"':''?>  >Active</option>

                <option value="0" <?=(isset($status) && $status==0)?'selected="selected"':''?>>Inactive</option>

              </select>

              <!--<span class="f_help">Text custom help</span>--></div>

          </div>

        

          

          

          <div class="section last">

            <div class="sectioninner">

              <!-- <input type="hidden" name="user_type" value="1" /> -->

              

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