<?php 
include(FS_ADMIN._MODS."/".basename(__DIR__)."/pagefunion.inc.php");
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
                      <th class="text-center" width="3%"><?=$ADMIN->check_all()?></th>
                      <th class="text-center" width="3%">SL No</th>
                      <th width="80%"> <a href="<?=$ADMIN->iurl($comp)?>&fld=name<?=(($otype=='asc')?"&otype=desc":'&otype=asc')?>" <?=(($fld=='name')?'class="selectedTab"':'')?>><span <?=(($otype=='asc')?'class="des"':'class="asc"')?>>Name</span></a> </th>
                      
                      <th width="7%" class="text-center"><a href="<?=$ADMIN->iurl($comp)?>&fld=status<?=(($otype=='asc')?"&otype=desc":'&otype=asc')?>" <?=(($fld=='status')?'class="selectedTab"':'')?>><span <?=(($otype=='asc')?'class="des"':'class="asc"')?>> Status</span></a></th>
                      <th width="7%" class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if($reccnt)
			      { $nums = (($start)?$start+1:1); 
				    while ($line = $PDO->db_fetch_array($result))
				    { @extract($line);$css =($css=='odd')?'even':'odd';
			?>
                    <tr>
                      <td class="text-center"><?=$ADMIN->check_input($pid)?></td>
                      <td class="text-center"><?=$nums?></td>
                      <td><?=$name?></td>
                      <td class="text-center"><?=$ADMIN->displaystatusadm($status)?></td>
                      <td class="text-center"><?=$ADMIN->action($comp, $pid)?></td>
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
	$('.datepicker').datepicker({dateFormat: 'yy-mm-dd',  minDate: '-1y',       });
    $("[data-toggle=tooltip]").tooltip();
	    $('.openPopup').on('click',function(){
        var dataURL = $(this).attr('data-href');
        $('#treatmentpdf .modal-body object').attr('data',dataURL+'#page=2');
		$('#treatmentpdf .modal-body #dnlinks').attr('href',dataURL);
		$('#treatmentpdf').modal({show:true});
    }); 
	$('.sendptreatmets').on('click',function(){
		
        var dataURL = $(this).attr('data-href');
        $('#treatmentpdfsendmail .modal-body').load(dataURL,function(){
        $('#treatmentpdfsendmail').modal({show:true});
		return false;
    });
    });
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
function changeaction(val){
	$('#action').val(val);
	}
</script>


<style>
.ui-datepicker.ui-widget {z-index: 100000 !important;}

</style>