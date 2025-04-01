<?php 
include(FS_ADMIN._MODS."/proposal_history/product_manager.inc.php");

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
                     
                      <th>SL No</th>
                      <th>Service Name </th>
                      <th>Client Name</th>
                      <th>Client Email</th>
                      <th>Date</th>
                      <th>Lead No.</th>
                     <!-- <th>Action</th>-->
                    </tr>
                  </thead>
                  <tbody>
                    <?php if($reccnt)
			      { $nums = (($start)?$start+1:1); 
				    while ($line = $PDO->db_fetch_array($result))
				    { @extract($line);$css =($css=='odd')?'even':'odd';
			?>
                    <tr>
                      
                      <td><?=$nums?></td>
                      <td><?=$PDO->getSingleresult("select name from #_product_manager where status=1 and pid='".$serviceid."'");?></td>
                      <td><?=$name?></td>
                      <td><?=$email?></td>
                      <td><?=$created_on?></td>
                     <td><?=$PDO->getSingleresult("select rwi from #_leads where pid='".$lid."'");?></td>
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