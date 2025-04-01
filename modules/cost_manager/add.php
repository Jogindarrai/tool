<?php 
include(FS_ADMIN._MODS."/".basename(__DIR__)."/pagefunion.inc.php");
$PAGS = new Pages();
if($RW->is_post_back())
{
	$_POST['url'] =$ADMIN->baseurl($name);
   if($uid)
   {
	   $_POST['updateid']=$uid;
       $flag = $PAGS->update($_POST);
   }else {
	   $flag = $PAGS->add($_POST);
   }
   if($flag['flag']==1)
   {
      $RW->redir($ADMIN->iurl($comp.(($start)?'&start='.$start:'').(($catid)?'&catid='.$catid:'')), true);
   }
}
if($uid)
{
    $query =$PDO->db_query("select * from #_".tblName." where pid ='".$uid."' "); 
	$row = $PDO->db_fetch_array($query);
	@extract($row);	
}
?>
<section>
  <div class="container ">
    <div class="row">
      <div class="col-lg-12   ">
        <div class="card">
          <div class="row">
            <div class="col-12 col-md-6">
              <h2>Add Cost</h2>
            </div>
            
          </div>
          <div class="user-wrp">
          
              <div class="row">
                <div class="col-12 col-md-12">
                  <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control validate[required]" name="name" value="<?=$name?>">
                  </div>
                </div>
                
              </div>
              
              <div class="row">
                <div class="col-12 col-md-6">
                  <div class="form-group">
                    <label for="">Status</label>
                       <select name="status"  class="validate[required] form-control" data-errormessage-value-missing="Status is required!">
            <option  value="">-------Select Status------</option>
            <option value="1" <?=($status==1)?'selected="selected"':''?>  >Active</option>
            <option value="0" <?=(isset($status) && $status==0)?'selected="selected"':''?>>Inactive</option>
          </select>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="form-group text-right">
                    <label for="">&nbsp;</label><br />
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
  
    </div>
  </div>
  </div>
</section>
<script>
$(function() {
    $('body').on('focus', ".datepickerfrom, .datepickerto", function() {
            $('.datepickerfrom').datepicker({
               	minDate: new Date('<?=$Reqrow['travelDate']?>'),
				maxDate: new Date('<?=$Reqrow['traveleDate']?>'),
                dateFormat: 'yy-mm-dd',
				defaultDate: '<?=$Reqrow['travelDate']?>',
                onClose: function(selectedDate) {
                    var theOtherDate = $(this).closest('.datepickerrng').find('.datepickerto');
                    $(theOtherDate).datepicker("option", "minDate", selectedDate);
                },
				beforeShow: function(selectedDate) {
					if($('.extrafield').length>1){
					var theOtherDateto = $(this).closest('.extrafield').prev('.extrafield').find('.datepickerto').val();
					$(this).datepicker("option", "minDate", theOtherDateto);
					}
                }
            });
            $('.datepickerto').datepicker({
                minDate: new Date('<?=$Reqrow['travelDate']?>'),
				maxDate: new Date('<?=$Reqrow['traveleDate']?>'),
                dateFormat: 'yy-mm-dd',
                onClose: function(selectedDate) {
                    var theOtherDate = $(this).closest('.datepickerrng').find('.datepickerfrom');
                    $(theOtherDate).datepicker("option", "maxDate", selectedDate);
                }
            });


    })
});
  </script>
<script src='js/timepicker.js'></script>
<link rel="stylesheet" href="css/timepicker.css">

<script>
$('.time').timepicker({
	controlType: 'select',
	timeFormat: 'HH:mm'
});
</script>
<script>
jQuery(document).ready(function(){
$('.selectpiker').selectpicker({liveSearch: true});
$('body').on('focus',".datepicker", function(){
    $(this).datepicker( {minDate: 0,dateFormat: 'yy-mm-dd'});});
	
jQuery("#formID").validationEngine({promptPosition: 'inline'});
$('.icon').iconpicker();
$('body').on('click','.removeextrafield', function(){
	$(this).parents('.extrafield').remove();
	});
	
		});

$(document).on('click', '.browse', function(){

  var file = $(this).parent().parent().parent().find('.file');

  file.trigger('click');
});

$(document).on('change', '.file', function(){

  $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
});
function checktime(field, rules, i, options){
	var filter = /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;
  if (!filter.test(field.val())) {return field[0].dataset.validationPlaceholder;}
}
function addextrafield(){
$('#extrarowwarp').append('<div class="row extrafield"><div class="col-12 col-md-5"><div class="form-group"><label for="">Select Hotels</label><select name="hotels[]"  class="validate[required] form-control selectpiker" data-errormessage-value-missing="Hotels is required!"><option  value="">-------Select Hotels------</option><?php $htlQry2=$PDO->db_query("select * from #_hotel_manager where status='1' order by name ASC");while($htlRow2=$PDO->db_fetch_array($htlQry2)){?><option value="<?=$htlRow2['pid']?>" ><?=$htlRow2['name']?></option><?php }?></select></div></div><div class="col-12 col-md-5"><div class="row datepickerrng"><div class="col-12 col-md-6"><div class="form-group"><label for="">Check In</label><input type="text" value="" class="form-control validate[required] datepickerfrom" name="checkin[]" data-errormessage-value-missing="checkin is required!" /></div></div><div class="col-12 col-md-6"><div class="form-group "><label for="">Check Out</label><input type="text" value="" class="form-control validate[required] datepickerto" name="checkout[]" data-errormessage-value-missing="checkout is required!" /></div></div></div></div><div class="col-12 col-md-2"><div class="row"><div class="col-12 col-md-6"><label for="">Inclusion</label><br /><label for="inclusion">Breakfast <input type="hidden" name="inclusion[]" value="0"><input type="checkbox" onclick="this.previousSibling.value=1-this.previousSibling.value"></label></label></div><div class="col-12 col-md-6 text-right"><label for="">&nbsp;</label><br /><button type="button" class="btn btn-danger removeextrafield">-</button></div></div></div></div>');
$('.selectpiker').selectpicker('refresh');
	}
	
function addrestorent(){
$('#restorentfld').append('<div class="row extrafield"><div class="col-12 col-md-4"><div class="form-group"><label for="">Select Restaurant</label><select name="restaurant[]" class="form-control selectpiker" id="restorents" data-errormessage-value-missing="restaurant is required!"><option  value="">-------Select Restaurant------</option><?php $rtlQry=$PDO->db_query("select * from #_restaurant_manager where status='1' order by name ASC");while($rtlRow=$PDO->db_fetch_array($rtlQry)){?><option value="<?=$rtlRow['pid']?>" ><?=addslashes($rtlRow['name'])?></option><?php }?></select></div></div><div class="col-12 col-md-3"><div class="form-group"><label for="">Date</label><input type="text" value="" class="form-control validate[condRequired[restorents]] datepickerfrom" name="rescheckin[]" data-errormessage-value-missing="checkin is required!" /></div></div><div class="col-12 col-md-4"><div class="form-group"><label for="">Select Meals Type </label><select name="restaurantbld[]"  class="form-control validate[condRequired[restorents]] selectpiker" data-errormessage-value-missing="Restaurant Meals is required!"><option  value="">-------Select Meals------</option><option  value="breakfast">Breakfast</option><option  value="lunch">Lunch</option><option  value="dinner">Dinner</option></select></div></div><div class="col-12 col-md-1"><div class="form-group text-right"><label for="">&nbsp;</label><br /><button type="button" class="btn btn-danger removeextrafield">-</button></div></div></div>');
$('.selectpiker').selectpicker('refresh');
	}
</script>
