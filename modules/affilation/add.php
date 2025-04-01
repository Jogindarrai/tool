<?php 
  include(FS_ADMIN._MODS."/affilation/affilation.inc.php");
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
			 if($PDO->getsingleresult("select markassell from #_affilation where pid='".$uid."'")!='1'){
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
                <h2>Add <?=ucfirst($comp)?></h2>
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
                    <label for="">Occupation</label>
                    <select class="validate[required] form-control" name="occupation" data-validation="required">
                        <option value="">Select Occupation</option>
                        <option value="Charter Accountant">Chartered Accountant</option>
                        <option value="Company Secretary">Company Secretary</option>
                        <option value="Lawyer">Lawyer</option>
                        <option value="Business Consultant">Business Consultant</option>
                        <option value="CWA">CWA</option>
                        <option value="Sales Partner">Sales Partner</option>
                        <option value="Others">Others</option>
                  </select>
                    
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label for="">Company Name</label>
                    <input type="text" name="companyName" value="<?=$companyName?>" class="validate[required] form-control">
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
                <div class="col-md-6">
                  <!--<div class="form-group">
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
                  </div>-->
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
