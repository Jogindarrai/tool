<?php 
  include(FS_ADMIN._MODS."/leads/leads.inc.php");
  $PAGS = new Pages();
  
  if($RW->is_post_back())
  {
  //print_r($_POST); exit;	
	/* $path = UP_FILES_FS_PATH."/clientdetail/";
  
  $count = 0;
   if($_FILES['upload'][name]){
	  // Loop $_FILES to execute all files
	  foreach ($_FILES['upload']['name'] as $f => $fname) {     
		  if ($_FILES['upload']['error'][$f] == 0) {	           
			   // No error found! Move uploaded files 
			   $fname=mt_rand(10,999).'_'.$fname;
				  if(move_uploaded_file($_FILES["upload"]["tmp_name"][$f], $path.$fname)) {
					  $count++; // Number of successfully uploaded files
				 $filename[]=$fname;
			  }
		  }
	  }
	  
  }
  /*	$_POST['upload']=$filename;
	  if($_POST['allfl']!=''){
		  $allflss = explode(":", $_POST['allfl']);
	  $_POST['upload']=array_merge($allflss,$_POST['upload']);
		  }*/
	 $_POST['url'] =$ADMIN->baseurl($name);
	  
	 if($uid)
	 {
		 if($_POST['markassell']=='1'){
			 if($PDO->getsingleresult("select markassell from #_leads where pid='".$uid."'")!='1'){
			 $_POST['markasselldate']=$today=date("Y-m-d");}}
		 $_POST['updateid']=$uid;
		 $flag = $PAGS->update($_POST);
	
	 }else {
		 if($_POST['markassell']=='1'){$_POST['markasselldate']=$today=date("Y-m-d");}
		 $flag = $PAGS->add($_POST);
		 
	 }
	 
	 if($flag[0]==1)
	 {
	 if($_POST['markassell']=='1'){?>
<script>
	 if(confirm('Want to genrate Invoice')){
				  window.location.href='<?=SITE_PATH_ADM?>index.php?comp=invoice&mode=add2&leadId=<?=$flag[1]?>';
			  }else{
				  alert('Genrate invoice manually.');
				  }
				  </script>
<?php
		 
		 echo $flag[1];
		 }
		$RW->redir($ADMIN->iurl($comp.(($start)?'&start='.$start:'').(($subpage_id)?'&subpage_id='.$subpage_id:'').(($source)?'&source='.$source:'')), true);
	 }
  }
  
  
  if($uid)
  {
	  $query =$PDO->db_query("select * from #_".tblName." where pid ='".$uid."' "); 
	  $row = $PDO->db_fetch_array($query);
	  @extract($row);	
  }
  
  ?>

<section class="mt30">
  <div class="container ">
    <div class="row">
      <div class="col-lg-12   ">
        <div class="card">
          <div class="row">
            <div class="col">
              <div class="card-title">
                <h2>Add Lead</h2>
              </div>
            </div>
          </div>
          <div class="user-wrp">
            <form action="#">
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="name" value="<?=$name?>" class="validate[required] form-control">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label for="email">Country </label>
                    <select name="countryID" class="validate[required] form-control" data-errormessage-value-missing="Country is required!">
                     <option value="101">India</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="text" class="validate[required,custom[email]] form-control" name="email" value="<?=$email?>" data-errormessage-value-missing="Email is required!">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <div class="form-group">
                      <label for="">Phone</label>
                      <input type="tel" class="form-control" name="phone" value="<?=$phone?>" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="">Service</label>
                    <select name="service" class="validate[required] form-control" data-errormessage-value-missing="Service is required!">
                      <option value="">-------select service------</option>
                      <?php 
   $service_query = $PDO->db_query("select * from #_product_manager where status='1'");
				  while($service_rows = $PDO->db_fetch_array($service_query)){ ?>
                      <option value="<?=$service_rows['pid']?>" <?=($service_rows['pid']==$service)?'selected="selected"':''?>  ><?=$service_rows['name']?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label for="">Source</label>
                    <select name="source" class="validate[required] form-control" data-errormessage-value-missing="Service is required!">
                      <option value="">-------select Source------</option>
                      <?php 
   $service_query = $PDO->db_query("select * from #_lead_source where status='1'");
				  while($service_rows = $PDO->db_fetch_array($service_query)){ ?>
                      <option value="<?=$service_rows['pid']?>" <?=($service_rows['pid']==$source)?'selected="selected"':''?>  ><?=$service_rows['name']?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              
              <div class="row">
                
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="email">City </label>
                    <select name="cityID" class="validate[required] form-control" data-errormessage-value-missing="City is required!">
                      <option value="">-------select City------</option>
                      <?php 
   $service_query = $PDO->db_query("select * from #_india_cities where status='1'");
				  while($service_rows = $PDO->db_fetch_array($service_query)){ ?>
                      <option value="<?=$service_rows['pid']?>" <?=($service_rows['pid']==$cityID)?'selected="selected"':''?>  ><?=$service_rows['name']?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <?php  if(!$uid)
  { ?>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Status</label>
                    <select class="validate[required] form-control" name="status" data-errormessage-value-missing="Status is required!">
                      <option value="" >Select Status</option>
                      <?php
					   $ldStageQry=$PDO->db_query("SELECT * FROM #_lead_stage where status='1'");
					   while($ldRows=$PDO->db_fetch_array($ldStageQry)){
					   ?>
                      <option value="<?=$ldRows['pid']?>" <?=($status==$ldRows['pid'])?'selected="selected"':''?>  ><?=$ldRows['name']?></option>
                      <?php }?>
                    </select>
                  </div>
                  <div id="Follow" class="Follow" style="display:none">
                    <div class="form-group">
                      <label for="">Date &amp; Time</label>
                      <div class="input-group date" id="datetimepicker" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker">
                        <div class="input-group-append" data-target="#datetimepicker" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                      </div>
                      <script>
  $(function() {
	$('#datetimepicker').datetimepicker();
  });
  </script> 
                    </div>
                  </div>
                  <script>
	  $(function() {
		  $('#Follow_select').change(function(){
			  $('.Follow').hide();
			  $('#' + $(this).val()).show();
		  });
	  });
  </script> 
                </div>
                <?php } ?>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
					  <label for="">Duplicate Lead</label>
					  <select class="validate[required] form-control" name="dp">
							  <option  value="0">No</option>
							 <option value="1" <?=($dp==1)?'selected="selected"':''?>  >Yes</option>
					  </select>
					</div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label for="email">Assign to sales exective</label>
                    <select class="form-control" name="salesecutiveid">
                      <option value="">-------Assign to Sales Executive------</option>
                      <?php
			   $sexecutive_query = $PDO->db_query("select * from pms_admin_users where user_type='5'  and status='1'");
				  while($sexecutive_rows = $PDO->db_fetch_array($sexecutive_query)){ ?>
                      <option value="<?=$sexecutive_rows['user_id']?>" <?=($sexecutive_rows['user_id']==$salesecutiveid)?'selected="selected"':''?>  ><?=$sexecutive_rows['name']?></option>
                      <?php } ?>
                    </select>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row"> 
                
                 <div class="col">
					<div class="form-group">
                    <label>Comment</label>
                    <textarea name="comments" class="form-control"><?=stripcslashes($comments)?></textarea>
                  </div>
				  </div>  
              </div>
              <button type="submit" class="btn btn-primary pull-right">Submit</button>
            </form>
          </div>
        </div>
      </div>
      <!--<div class="col-sm-3">
		  <ul class="sidebar list-unstyled">
			<li> <a href="#"> <i class="fa fa-arrow-circle-right"></i> Proposal</a> </li>
			<li> <a href="#"> <i class="fa fa-arrow-circle-right"></i> Payment Link</a> </li>
			<li> <a href="#"><i class="fa fa-arrow-circle-right"></i> Quick Lead add</a> </li>
			<li> <a href="#"><i class="fa fa-arrow-circle-right"></i> Invoice Manager</a> </li>
			<li> <a href="#"><i class="fa fa-arrow-circle-right"></i> My Order</a> </li>
			<li> <a href="#"><i class="fa fa-arrow-circle-right"></i> My Assocaites</a> </li>
			<li> <a href="#"><i class="fa fa-arrow-circle-right"></i> Exclamation of tickets</a> </li>
		  </ul>
		</div>--> 
    </div>
  </div>
  </div>
</section>
