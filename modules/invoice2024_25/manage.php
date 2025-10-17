<?php

include(FS_ADMIN._MODS."/invoice2024_25/invoice2024_25.inc.php");

$month = $_GET['month'] ?? null;
$year = $_GET['year'] ?? null;
$SalesExecutive = $_GET['SalesExecutive'] ?? null;
$status = $_GET['status'] ?? '';
$action = $_GET['action'] ?? '';
$start = 0;
$pagesize = 10;
$fld = $_GET['fld'] ?? '';
$otype = $_GET['otype'] ?? '';
$search_data = '';
$zone = '';
$mtype = '';
$extra = '';
$extra1 = '';
$extra2 = '';

// Build filters safely
$sessionId = $_SESSION["AMD"][0] ?? '';
$sessionRole = $_SESSION["AMD"][3] ?? '';

$filters = [];

// Role 5 users see only their own records
if ($sessionRole == '5') {
    $filters[] = "(create_by='{$sessionId}' OR salesecutiveid='{$sessionId}')";
}

// Month & Year filter
if ($month && $year) {
    $filters[] = "YEAR(created_on)='{$year}' AND MONTH(created_on)='{$month}'";
}

// Sales Executive filter
if ($SalesExecutive) {
    $filters[] = "salesecutiveid='{$SalesExecutive}'";
}

// Status filter
if ($status) {
    $filters[] = "status='{$status}'";
}

// Combine filters
if (!empty($filters)) {
    $extra = ' AND ' . implode(' AND ', $filters);
}

// Raid filter
if (isset($raid)) {
    $extra1 = " AND raid='{$raid}'";
}

// Initialize Pages object
$PAGS = new Pages();

// Handle actions
if ($action) {
    if (($uid ?? 0) > 0 || !empty($arr_ids)) {
        switch ($action) {
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
        }
        $RW->redir($ADMIN->iurl($comp), true);
    }
}

// Pagination
$start = intval($start);
$pagesize = intval($pagesize) ?: (($_SESSION["totpaging"] ?? 0) ?: DEF_PAGE_SIZE);

// Fetch records
list($result, $reccnt) = $PAGS->display($start, $pagesize, $fld, $otype, $search_data, $zone, $mtype, $extra, $extra1, $extra2);

// Debug: Uncomment to check filters and records
// echo "<pre>"; print_r(['filters'=>$filters, 'records_count'=>$reccnt]); exit;


$people = ["2", "9", "33"];
if (in_array($sessionId, $people)) {
?>
<style>
#add {display:block !important;width: 50px;float: right;}
</style>
<?php } ?>
<style>
.btn-info {display:none;}
</style>

<section class="mt30">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="ManageLeads-wrp">
          <div class="row">
            <div class="table-responsive">
              <table id="example" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th><?=$ADMIN->check_all()?></th>
                    <th>Invoice No.</th>
                    <th>Relationship Manager</th>
                    <th>Customer Name</th>
                    <th>Customer Email</th>
                    <th>Contact No</th>
                    <th>Date</th>
                    <th>Gross Total</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
<?php
if ($reccnt > 0) {
    $css = 'even';
    $nums = $start ? $start+1 : 1;
    while ($line = $PDO->db_fetch_array($result)) {
        @extract($line);
        $css = ($css=='odd') ? 'even' : 'odd';
?>
<tr class="<?=$css?>">
  <td><?=$ADMIN->check_input($pid)?></td>
  <td><?=$inviceno?></td>
  <td><?=$rlmanager?></td>
  <td><?=$customername?></td>
  <td><?=$customeremail?></td>
  <td><?=$customerno?></td>
  <td><?=date("d-m-Y", strtotime($invicedate))?></td>
  <td><?=$hgrasstotal?></td>
  <td>
    <?php if (!empty($filename)): ?>
    <a href="<?= SITE_PATH_ADM . _MODS . "/invoice2024_25/pdf/" . $filename . ".pdf" ?>"
       download
       class="btn btn-success">
       <i class="fa fa-download"></i>
    </a>
<?php endif; ?>

    <a href="<?=SITE_PATH_ADM.'index.php?comp='.$comp.'&mode=add&uid='.$pid?>"><i class="fa fa-edit"></i></a>
    <a href="<?=SITE_PATH_ADM.'index.php?comp='.$comp.'&uid='.$pid.'&action=del'?>" onclick="return confirm('Do you want delete this record?');"><i class="fa fa-trash-o"></i></a>


  </td>
</tr>
<?php
        $nums++;
    }
} else {
    echo '<tr><td colspan="9" align="center">No Record Found</td></tr>';
}
?>
                </tbody>
              </table>
            </div>
          </div>
                      <?php include("cuts/paging.inc.php");?>

        </div>
      </div>
    </div>
  </div>
</section>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>
<script src='js/timepicker.js'></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="css/timepicker.css">
<script >$('.time').timepicker({
	controlType: 'select',
	timeFormat: 'hh:mm tt'
});
</script>
<style>
.ui-datepicker{z-index:9999999 !important;}
</style>
<script language="javascript">
jQuery(document).ready(function(){
	jQuery(function() {
		jQuery("#ordrz ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
			var order = jQuery(this).sortable("serialize") + '&tbl=<?=tblName?>&field=pid';
			 $.post("<?=SITE_PATH_ADM?>modules/orders.php", order, function(theResponse){ });
		}
		});
	});


});
var prsub=0;
function updatepstatus(a,uid){
	var status_value=a.value;
	if(status_value!=''){
	var paidam=$('#pmount'+uid).val();
	var gtam=$('#pmount'+uid).attr("data-gt");
	if(status_value=='1'){
		paidam=gtam;
		$('#pmount'+uid).val(paidam);
		}else if(status_value=='0'){
			paidam=0;
			$('#pmount'+uid).val('0');
			}else if(status_value=='2'){
				if(prsub==0){
				$('#pmount'+uid).removeAttr('readonly').css({'border':'1px solid #ccc', 'background':'#fff'});
   				a.selectedIndex = 0;
    			alert('Please enter paid amount');
				prsub=1;
    			return false;
				}else{prsub=0
				$('#pmount'+uid).attr('readonly','readonly').css({'border':'none', 'background':'transparent'});
				}
			}else if(status_value=='2' && paidam!='0'){

				}else if(status_value=='3'){
					status_value='2';
					prsub=1
					$('#pmount'+uid).removeAttr('readonly').css({'border':'1px solid #ccc', 'background':'#fff'});
					a.selectedIndex = 0;
					$('#pupd').remove();
    				alert('Please enter paid amount');
					return false;
					}
var status = 'uid='+uid+'&pstatus='+status_value + '&tbl=<?=tblName?>&field=pid&pamount='+paidam;
$.post("<?=SITE_PATH_ADM?>modules/<?=$comp?>/status.php", status, function(theResponse){ alert(theResponse)});
	}
	}
$(document).ready(function()
{
    $(".monthPicker").datepicker({
        dateFormat: 'yy, mm',
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,

        onClose: function(dateText, inst) {
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
			/*var mn=parseInt(month)+1;
			console.log(minTwoDigits(mn));
			console.log(mn);*/
			console.log('<?=$ADMIN->iurl($comp.'&year=')?>'+year+'&month='+month);
			$(this).val($.datepicker.formatDate('yy, mm', new Date(year, month, 1)));
			window.location.href = '<?=$ADMIN->iurl($comp.'&year=')?>'+year+'&month='+minTwoDigits(parseInt(month)+1);
        }
    });

    $(".monthPicker").focus(function () {
        $(".ui-datepicker-calendar").hide();
        $("#ui-datepicker-div").position({
            my: "center top",
            at: "center bottom",
            of: $(this)
        });
    });
});
function minTwoDigits(n) {
  return (n < 10 ? '0' : '') + n;
}
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
<style>
.trns{background: transparent;}
.hwlh{border: none; height:25px;}
.newp{background: rgb(162, 212, 162) !important;}
     </style>