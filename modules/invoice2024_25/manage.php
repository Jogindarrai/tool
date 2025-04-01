

<?php


include(FS_ADMIN._MODS."/invoice2024_25/invoice2024_25.inc.php");
$month = isset($_GET['month']) ? $_GET['month'] : null;
$year = isset($_GET['year']) ? $_GET['year'] : null;
$SalesExecutive = isset($_GET['SalesExecutive']) ? $_GET['SalesExecutive'] : null;
$status = "";
$action = "";
$start = 0;
$pagesize = 10;
$fld = "";
$otype = "";
$search_data = "";
$zone = "";
$mtype = "";
$extra = "";
$extra1 = "";
$extra2 = "";


if($_SESSION["AMD"][3]=='5'){
 $extra = " and create_by='".$_SESSION["AMD"][0]."' or salesecutiveid='".$_SESSION["AMD"][0]."'";
 if($month && $year){$extra="  and create_by='".$_SESSION["AMD"][0]."' or salesecutiveid='".$_SESSION["AMD"][0]."' and  year(created_on) = '".$year."' and month(created_on) = '".$month."'";}
}
else{
if($month && $year){$extra=" and  year(created_on) = '".$year."' and month(created_on) = '".$month."'";}
	}

if($SalesExecutive){
 $extra = " and salesecutiveid='".$SalesExecutive."'";
 if($month && $year){$extra=" and salesecutiveid='".$SalesExecutive."' and  year(created_on) = '".$year."' and month(created_on) = '".$month."'";}
	}

if($status){
 $extra = " and status='".$status."'";
 if($month && $year){$extra=" and status='".$status."' and  year(created_on) = '".$year."' and month(created_on) = '".$month."'";}
	}
if($status && $SalesExecutive){
 $extra = " and status='".$status."' and salesecutiveid='".$SalesExecutive."'";
if($month && $year){$extra=" and status='".$status."' and salesecutiveid='".$SalesExecutive."' and  year(created_on) = '".$year."' and month(created_on) = '".$month."'";}
	}

if(isset($raid)){
 $extra1 = " and raid='".$raid."'";}
//if($month && $year){$extra=" and  year(created_on) = '".$year."' and month(created_on) = '".$month."'";}

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

	$people = array("2", "9","33");
	if (in_array($_SESSION["AMD"][0], $people)){
?>

<style>
#add{display:block !important;width: 50px;float: right;}
</style>

<?php }?>
<style>
.btn-info{display:none;}
</style>
<section class="mt30">
  <div class="container">
11111111111111
    <div class="row">
      <div class="col-lg-12   ">
        <div class="ManageLeads-wrp ">
          <div class="row">
            <div class="table-responsive">
              <table id="example" class="table table-striped table-bordered" >
                <thead>
                  <tr>
                    <th><?=$ADMIN->check_all()?></th>
                    <th><a href="<?=$ADMIN->iurl($comp)?>&fld=inviceno<?=(($otype=='asc')?"&otype=desc":'&otype=asc')?>" <?=(($fld=='inviceno')?'class="selectedTab"':'')?>><span <?=(($otype=='asc')?'class="des"':'class="asc"')?>>Invoice No.</span></a></th>
                    <th>  <a href="<?=$ADMIN->iurl($comp)?>&fld=rlmanager<?=(($otype=='asc')?"&otype=desc":'&otype=asc')?>" <?=(($fld=='rlmanager')?'class="selectedTab"':'')?>><span <?=(($otype=='asc')?'class="des"':'class="asc"')?>> Relationship Manager</span></a></th>
                    <th> <a href="<?=$ADMIN->iurl($comp)?>&fld=customername<?=(($otype=='asc')?"&otype=desc":'&otype=asc')?>" <?=(($fld=='customername')?'class="selectedTab"':'')?>><span <?=(($otype=='asc')?'class="des"':'class="asc"')?>> Customer Name</span></a></th>
                    <th> <a href="<?=$ADMIN->iurl($comp)?>&fld=customeremail<?=(($otype=='asc')?"&otype=desc":'&otype=asc')?>" <?=(($fld=='customeremail')?'class="selectedTab"':'')?>><span <?=(($otype=='asc')?'class="des"':'class="asc"')?>> Customer Email</span></a></th>
                    <th> <a href="<?=$ADMIN->iurl($comp)?>&fld=customerno<?=(($otype=='asc')?"&otype=desc":'&otype=asc')?>" <?=(($fld=='customerno')?'class="selectedTab"':'')?>><span <?=(($otype=='asc')?'class="des"':'class="asc"')?>> Contact No</span></a></th>
                    <th>Date</th>
                    <th>  <a href="<?=$ADMIN->iurl($comp)?>&fld=hgrasstotal<?=(($otype=='asc')?"&otype=desc":'&otype=asc')?>" <?=(($fld=='hgrasstotal')?'class="selectedTab"':'')?>><span <?=(($otype=='asc')?'class="des"':'class="asc"')?>> Gross Total</span></a></th>
                <!--    <th> Status </th>
                    <th> Paid amount </th>-->
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>

                  <?php
                  $css = 'even';
                  if($reccnt)
			      { $nums = (($start)?$start+1:1);
				    while ($line = $PDO->db_fetch_array($result))
				    { @extract($line);$css =($css=='odd')?'even':'odd';
			?>
                    <tr>
                     <td><?=$ADMIN->check_input($pid)?></td>
                <td><span title="<?=$created_on?>"><?=$inviceno?></span><input class="copy" type="button" data-clipboard-text="<?=$inviceno?>" value="Copy" /></td>
                <td><?=$rlmanager?></td>
                <td><?=$customername?></td>
                <td><?=$customeremail?></td>
                <td><?=$customerno?></td>
                <td><?=date("d-m-Y",strtotime($invicedate))?></td>
                <td><?=$hgrasstotal?></td>
              <!--  <td><select name="pstatus" id="usop<?=$pid?>" class="trns" style="height:28px;" onchange="updatepstatus(this,'<?=$pid?>')">
                <option value="">Select Status</option>
                <option <?=('1'==$pstatus)?'selected="selected"':''?> value="1">Paid</option>
                <option <?=('0'==$pstatus)?'selected="selected"':''?> value="0">Unpaid </option>
                <option <?=('2'==$pstatus)?'selected="selected"':''?> value="2">Partial</option>
                <?php if($pstatus=='2'){?>
                <option id="pupd" <?=('3'==$pstatus)?'selected="selected"':''?> value="3">Update Partial</option>
              <?php }?>
                </select>
                </td>
                <td><input readonly="readonly" data-gt="<?=$hgrasstotal?>" type="text" id="pmount<?=$pid?>" value="<?=$pamount?>" class="txt full trns hwlh" /></td>
              -->


                        <td>
                         <?php if($status=='1'){?>
                        <a href="<?=$ADMIN->iurl($comp.('&mode=invoice2023_24&uid='.$pid.'&sendmail=sent'))?>" data-toggle="tooltip" onclick="return confirm('Do you want mail sent again?');" title="Approved & mail sent" class="mr-1"><i class="fa fa-check"></i></a>
                    <?php } else {?>
                    <a href="<?=$ADMIN->iurl($comp.('&mode=invoice2023_24&uid='.$pid.'&sendmail=sent'))?>" onclick="return confirm('Are you sure you want to approve this invoice?');" data-toggle="tooltip" title="Approval Pending" class="mr-1"><i class="fa fa-times"></i></a>
                    <?php } ?>
                         <a href="<?=SITE_PATH.'modules/'.$comp.'/pdf/'.$filename.'.pdf'?>" data-toggle="tooltip" title="Download" class="mr-1"><i class="fa fa-arrow-down"></i></a>   <a href="<?=SITE_PATH_ADM.'index.php?comp='.$comp.(($_GET[start])?'&start='.$_GET[start]:'').'&mode=add&uid='.$pid?><?=$catid?'&catid='.$catid:''?><?=($die_id)?'&die_id='.$die_id:''?>" class="mr-1"  data-toggle="tooltip" title=""><i class="fa fa-edit"></i></a>
                      <a href="<?=SITE_PATH_ADM.'index.php?comp='.$comp.(($_GET[start])?'&start='.$_GET[start]:'').'&uid='.$pid.'&action=del';?>" onclick="return confirm('Do you want delete this record?');" title="Delete"><i class="fa fa-trash-o"></i></a></td>
                    </tr>

                    <?php $nums++;} ?>


                  </tbody>

                 </table>
                <?php  }else { echo '</tbody></table><div align="center" class="norecord">No Record Found</div>  '; } ?>
              </div>
            </div>
            <?php include("cuts/paging.inc.php");?>
          </div>
        </div>
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