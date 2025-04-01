<?php 
include(FS_ADMIN._MODS."/custom_payments/custom_payments.inc.php");

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

$start = intval($start);
$pagesize = intval($pagesize)==0?(($_SESSION["totpaging"])?$_SESSION["totpaging"]:DEF_PAGE_SIZE):$pagesize;
list($result,$reccnt) = $PAGS->display($start,$pagesize,$fld,$otype,$search_data,$zone,$mtype,$extra,$extra1,$extra2);

?>

  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12   col-12 ">
        
         
          <div class="user-wrp saleextutive mt-3 ">
            <div class="row"> 
              
              <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" >
                  <thead>
                    <tr>
                      <th><?=$ADMIN->check_all()?></th>
                      <th>SL No</th>
                      <th> <a href="<?=$ADMIN->iurl($comp)?>&fld=name<?=(($otype=='asc')?"&otype=desc":'&otype=asc')?>" <?=(($fld=='name')?'class="selectedTab"':'')?>><span <?=(($otype=='asc')?'class="des"':'class="asc"')?>> Name</span></a> </th>
                      <th><a href="<?=$ADMIN->iurl($comp)?>&fld=email<?=(($otype=='asc')?"&otype=desc":'&otype=asc')?>" <?=(($fld=='email')?'class="selectedTab"':'')?>><span <?=(($otype=='asc')?'class="des"':'class="asc"')?>> Email</span></a> </th>
                      <th><a href="<?=$ADMIN->iurl($comp)?>&fld=servicename<?=(($otype=='asc')?"&otype=desc":'&otype=asc')?>" <?=(($fld=='servicename')?'class="selectedTab"':'')?>><span <?=(($otype=='asc')?'class="des"':'class="asc"')?>> Service </span></a></th>
                      <th><a href="<?=$ADMIN->iurl($comp)?>&fld=amount<?=(($otype=='asc')?"&otype=desc":'&otype=asc')?>" <?=(($fld=='amount')?'class="selectedTab"':'')?>><span <?=(($otype=='asc')?'class="des"':'class="asc"')?>> Amount</span></a></th>
                      <th>Link</th>
                    <!--  <th><a href="<?=$ADMIN->iurl($comp)?>&fld=status<?=(($otype=='asc')?"&otype=desc":'&otype=asc')?>" <?=(($fld=='status')?'class="selectedTab"':'')?>><span <?=(($otype=='asc')?'class="des"':'class="asc"')?>> Status</span></a></th>-->
                   
                    </tr>
                  </thead>
                  <tbody>
                    <?php if($reccnt)
			      { $nums = (($start)?$start+1:1); 
				    while ($line = $PDO->db_fetch_array($result))
				    { @extract($line);$css =($css=='odd')?'even':'odd';
			?>
                    <tr>
                      <td><?=$ADMIN->check_input($pid)?></td>
                      <td><?=$nums?></td>
                      <td><?=$name?></td>
                      <td><?=$email?> </td>
                      <td><?=$servicename?></td>
                      <td><?=$amount?></td>
                      <td>https://www.registrationwala.com/order?customuid=<?=$pid?> <input class="copy" type="button" data-clipboard-text="https://www.registrationwala.com/order?customuid=<?=$pid?>" value="Copy" /></td>
                     <!-- <td><?=$ADMIN->displayorderstatus($status)?></td>-->
                  <!--    <td class="text-nowrap"><a href="<?=SITE_PATH_ADM.'index.php?comp='.$comp.(($_GET[start])?'&start='.$_GET[start]:'').'&mode=add&uid='.$pid?><?=$catid?'&catid='.$catid:''?>"><i class="fa fa-edit"></i></a></td>-->
                    </tr>
                    
                 <?php $nums++; }  ?> 
                    
                 </tbody>
                </table>
                 <?php  }else { echo '</tbody></table><div align="center" class="norecord">No Record Found</div>'; } ?>
              </div>
            </div>
             <?php include("cuts/paging.inc.php");?> 
          </div>
        
      </div>
    </div>
  </div>


<script language="javascript">
$(document).ready(function(e) {
    $("[data-toggle=tooltip]").tooltip();
});
var fixHelperModified = function(e, tr) {
    var $originals = tr.children();
    var $helper = tr.clone();
    $helper.children().each(function(index) {
        $(this).width($originals.eq(index).width())
    });
    return $helper;
},
    updateIndex = function(e, ui) {
        $('td.index', ui.item.parent()).each(function (i) {
            $(this).html(i + 1);
        });
    };

$("#sort tbody").sortable({
    helper: fixHelperModified,
	opacity: 0.6, cursor: 'move',
	update: function() {
			var order = jQuery(this).sortable("serialize") + '&tbl=<?=tblName?>&field=pid'; 
		console.log(order)
			 $.post("<?=SITE_PATH_ADM?>modules/orders.php", order, function(theResponse){ }); 															
		},
    stop: updateIndex
}).disableSelection();
</script>
<script src='<?=SITE_PATH?>js/clipboard.min.js'></script>
<script>
    var btns = document.querySelectorAll('.copy');
    var clipboard = new Clipboard(btns);

    clipboard.on('success', function(e) {
        console.log(e);
		alert('Text has been copied to clipboard. !\n\n'+e.text);
    });

    clipboard.on('error', function(e) {
        alert('Something went wrong. Please copy manually');
    });
    </script>