<?php 
include(FS_ADMIN._MODS."/admin_users/admin_user.inc.php");
$ADU = new AdminUsers();
if($action)
{
  
  if($uid >0  || !empty($arr_ids))
  {
   
	switch($action)
	{
		  case "del":
						 $ADU->delete($uid);
						 $ADMIN->sessset('Record has been deleted', 'e'); 
						 break;
						 
		  case "Delete":
						 $ADU->delete($arr_ids);
						 $ADMIN->sessset(count($arr_ids).' Item(s) Deleted', 'e');
						 break;
						 
						 
		  case "Active":
						 $ADU->status($arr_ids,1);
						 $ADMIN->sessset(count($arr_ids).' Item(s) Active', 's');
						 break;
						 
		  case "Inactive":
						 $ADU->status($arr_ids,0);
						 $ADMIN->sessset(count($arr_ids).' Item(s) Inactive', 's');
						 break;
					 
		  
		  default:
	}
    $RW->redir($ADMIN->iurl($comp), true);
  }
}

$start = intval($start);
$pagesize = intval($pagesize)==0?(($_SESSION["totpaging"])?$_SESSION["totpaging"]:DEF_PAGE_SIZE):$pagesize;
list($result,$reccnt) = $ADU->display($start,$pagesize,$fld,$otype,$search_data);

?>
 <div class="container">
<div class="user-wrp">
              <div class="table-responsive">
				<table id="example" class="table table-striped table-bordered" >
<thead>
<tr>
<th><?=$ADMIN->check_all()?></th>
<th>SL No</th>
<th>  <a href="<?=$ADMIN->iurl($comp)?>&fld=name<?=(($otype=='asc')?"&otype=desc":'&otype=asc')?>" <?=(($fld=='name')?'class="selectedTab"':'')?>><span <?=(($otype=='asc')?'class="des"':'class="asc"')?>> User Name</span></a>
</th>
<th> <a href="<?=$ADMIN->iurl($comp)?>&fld=email<?=(($otype=='asc')?"&otype=desc":'&otype=asc')?>" <?=(($fld=='email')?'class="selectedTab"':'')?>><span <?=(($otype=='asc')?'class="des"':'class="asc"')?>> User Email</span></a></th>
<th> <a href="<?=$ADMIN->iurl($comp)?>&fld=user_type<?=(($otype=='asc')?"&otype=desc":'&otype=asc')?>" <?=(($fld=='user_type')?'class="selectedTab"':'')?>><span <?=(($otype=='asc')?'class="des"':'class="asc"')?>> Position</span></a></th>
  <th><a href="<?=$ADMIN->iurl($comp)?>&fld=dpid<?=(($otype=='asc')?"&otype=desc":'&otype=asc')?>" <?=(($fld=='dpid')?'class="selectedTab"':'')?>><span <?=(($otype=='asc')?'class="des"':'class="asc"')?>> Department</span></a></th>
<th> <a href="<?=$ADMIN->iurl($comp)?>&fld=status<?=(($otype=='asc')?"&otype=desc":'&otype=asc')?>" <?=(($fld=='status')?'class="selectedTab"':'')?>><span <?=(($otype=='asc')?'class="des"':'class="asc"')?>> Status</span></a></th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php if($reccnt)
	  { 
		$nums = (($start)?$start+1:1); 
		while ($line = $PDO->db_fetch_array($result))
		{
			@extract($line);
			$css =($css=='odd')?'even':'odd';
?>
<tr>
<td><?=$ADMIN->check_input($user_id)?></td>
<td><?=$nums?></td>
<td><?=$name?></td>
<td><?=$email?></td>
<td><?=$ADMIN->user_type($user_type)?></td>
 <td><?=$PDO->getSingleResult("select name from #_department where pid='".$dpid."'")?></td>
<td><?=$ADMIN->displaystatusadm($status)?></td>
<td><?=$ADMIN->action($comp, $user_id)?></td>
</tr>
                    
                    <?php $nums++; } ?>
</tbody>
</table>
                     <?php  }else { echo '<div align="center" class="norecord">No Record Found</div>'; } ?>
              </div>
            <?php include("cuts/paging.inc.php");?>
          </div>
</div>
<script language="javascript">
$(document).ready(function(){/* 
	$(function() {
		$("#example td").sortable({ opacity: 0.6, cursor: 'move', update: function() {
			var order = jQuery(this).sortable("serialize") + '&tbl=<?=tblName?>&field=user_id'; 
			 $.post("<?=SITE_PATH_ADM?>modules/orders.php", order, function(theResponse){ }); 															
		}								  
		});
	});
*/});	
</script>