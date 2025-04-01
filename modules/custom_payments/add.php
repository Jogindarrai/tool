<?php 

include(FS_ADMIN._MODS."/custom_payments/custom_payments.inc.php");

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
   if($flag==1)
   {
      $RW->redir($ADMIN->iurl($comp.(($start)?'&start='.$start:'').(($subpage_id)?'&subpage_id='.$subpage_id:'')), true);
   }
}
if($uid)
{
    $query =$PDO->db_query("select * from #_".tblName." where pid ='".$uid."' "); 
	$row = $PDO->db_fetch_array($query);
	@extract($row);	
$readonly='readonly="readonly"';	
}
?>
<section>
  <div class="container ">
    <div class="row">
      <div class="col-lg-12   ">
        <div class="card">
          <div class="row">
            <div class="col-12 col-md-6">
              <h2>Send Payment Link</h2>
            </div>
            
          </div>
          <div class="user-wrp">
          
              <div class="row">
                <div class="col-12 col-md-6">
                  <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="name" class="validate[required] form-control"  value="<?=$name?>" <?=$readonly?>>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="form-group">
                    <label for="">Email id</label>
                    <input type="text" name="email" class="validate[required] form-control" value="<?=$email?>" <?=$readonly?>>
                  </div>
                </div>
              </div>
              
              
              <div class="row">
                <div class="col-12 col-md-6">
                  <div class="form-group">
                    <label for="">Phone No.</label>
                    <input type="text" name="phone" class="validate[required] form-control"  value="<?=$phone?>" <?=$readonly?>>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="form-group">
                    <label for="">Service</label>
                    <input type="text" name="servicename" class="validate[required] form-control" value="<?=$servicename?>" <?=$readonly?> >
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-md-6">
                  <div class="form-group">
                    <label for="">Amount</label>
                    <input type="text" name="amount" class="validate[required] form-control"  value="<?=$amount?>" <?=$readonly?>>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="form-group">
                    <label for="">Payment Subject</label>
                    <input type="text" name="subject" class="validate[required] form-control" value="<?=$subject?>" <?=$readonly?>>
                  </div>
                </div>
              </div>
              <?php if(!$uid)
{ ?>
              <div class="row">
                <div class="col-12 col-md-6">
                  <div class="form-group">
                    <label for="">Attach File</label>
                   <div class="input-group border-bottom mb-3">
                <input type="file" name="attachment" class="form-control border-0" data-validation="mime size" data-validation-allowing="pdf, doc, docx"  data-validation-max-size="2M">
                </div>
                  </div>
                </div>
                
              </div>
              <?php } ?>
              <div class="row">
                
                <div class="col-12 col-md-12">
                  <div class="form-group">
                    <label for="">Payment Description</label>
                     <?php if(!$uid)
{ ?>
                     <?=$ADMIN->get_editor('body', stripcslashes($body),'','100%')?>
               <?php } else{ echo stripcslashes($body); } ?>
                  </div>
                </div>
              </div>
              
              
               <button type="submit" class="btn btn-primary pull-right">Submit</button>
         
          </div>
        </div>
      </div>
  
    </div>
  </div>
  </div>
</section>

<script>

		jQuery(document).ready(function(){

			jQuery("#formID").validationEngine({promptPosition: 'inline'});

			$('.icon').iconpicker();

		});

$(document).on('click', '.browse', function(){

  var file = $(this).parent().parent().parent().find('.file');

  file.trigger('click');

});

$(document).on('change', '.file', function(){

  $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));

});

</script>