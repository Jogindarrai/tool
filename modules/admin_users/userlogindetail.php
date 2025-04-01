<?php 
include(FS_ADMIN._MODS."/admin_users/admin_user.inc.php");
?>
<section class="mt-5 mb-5">
<div class="container">
    <div class="row">
      <div class="col-lg-12   ">
        <div class="card">
          <div class="row">
            <div class="col">
              <div class="card-title">
                <h2>Show User Login Time</h2>
              </div>
            </div>
          </div>
          <div class="user-wrp">
              <div class="row">
<div class="col-sm-12">
<?php
$pmsusrqry=$PDO->db_query("select * from pms_admin_users where status='1' ");
$pmsusrRow=$PDO->db_fetch_all($pmsusrqry);
?>
<select name="users" class="form-control" onchange="location.assign('<?=$ADMIN->iurl($comp,'userlogindetail')?>&userid='+this.value)">
<option value="">Select User</option>
<?php foreach($pmsusrRow as $us){?>
<option value="<?=$us['user_id']?>"  <?=($us['user_id']==$_GET['userid'])?'selected="selected"':''?>><?=$us['name']?></option>
<?php }?>
</select>
<div class="row">
<?php
if($_GET['userid']){
foreach($pmsusrRow as $pmsusrRow){
	if($pmsusrRow['user_id']==$_GET['userid']){
echo '<div class="col-12 p-3"><h2>'.$pmsusrRow['name'].'</h2></div>';
$ntime='['.$pmsusrRow['logintime'].']';
if($pmsusrRow['logintime']!=''){
foreach(array_reverse(json_decode($ntime)) as $date){
echo '<div class="col-sm-4 col-xs-6 col-lg-3 col-xl-2">'. date('d F Y : h:i:s A',$date).'</div>';	
	}	
}
	}
}
}
?>
</div>
</div>
</div>
          </div>
        </div>
      </div>
     
    </div>
    </div>
</section>
