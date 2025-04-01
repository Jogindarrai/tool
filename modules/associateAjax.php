<?php include '../lib/config.inc.php';

if($_POST['lid']){

$rys2=$PDO->db_query("SELECT * from #_associates WHERE rwi='".$_POST['lid']."' order by name ASC");
$rows1=$PDO->db_fetch_array($rys2);
if($_POST['type']=='proposal'){
?><div class="row">
<div class="col-6"><div class="form-group">
<label for=""> Customer Name</label>
<input type="text" name="name" class="validate[required] form-control"  value="<?=$rows1['name']?>">
</div></div> 

<div class="col"><div class="form-group">
<label for=""> Email ID</label>
<input type="text" name="email" class="validate[required] form-control" value="<?=$rows1['email']?>">
</div></div>
</div>
<div class="row">
<div class="col"><div class="form-group">
<label for="state_id" class="control-label">Select Service</label>
<select class="validate[required] form-control" name="service" >
<option value="">Select...</option>
<?php 
$service_query = $PDO->db_query("select * from #_product_manager where status='1' and proposal!=''");
while($service_rows = $PDO->db_fetch_array($service_query)){ ?>
<option value="<?=$service_rows['pid']?>" <?=($service_rows['pid']==$rows1['service'])?'selected="selected"':''?>  ><?=$service_rows['name']?></option>
<?php } ?>
</select>	
<input type="hidden" name="lid"  value="<?=$rows1['pid']?>">				
</div></div> 

</div> <?php } 

else if($_POST['type']=='Escalation'){
?>
<div class="row">
<div class="col"><div class="form-group">
<label for=""> Customer Name</label>
<input type="text" name="name" class="validate[required] form-control"  value="<?=$rows1['name']?>">
</div></div> 

</div>
<div class="row">
<div class="col-6">
<div class="form-group">
<label>Phone No</label>
<input type="text" name="phone" class="validate[required] form-control"  value="<?=$rows1['phone']?>" placeholder="">
</div></div> 


<div class="col-6"><div class="form-group">
<label for=""> Email ID</label>
<input type="text" name="email" class="validate[required] form-control" value="<?=$rows1['email']?>">
</div></div>
</div>
<div class="row">
<div class="col">
<div class="form-group">
<label>Issue for Escalation </label>
<textarea name="comment" class="validate[required] form-control"> </textarea>
<input type="hidden" name="lid"  value="<?=$rows1['pid']?>">	
</div></div> 



</div> <?php } 
else if($_POST['type']=='Quick'){
?>
<div class="row">
<div class="col"><div class="form-group">
<label>Email ID</label>
<input type="text" name="email" class="validate[required] form-control" value="<?=$rows1['email']?>">
<input type="hidden" name="name" class="validate[required] form-control"  value="<?=$rows1['name']?>">
<input type="hidden" name="lid"  value="<?=$rows1['pid']?>">	
</div></div>
</div>

<?php } 


else {?>

<div class="row">
<div class="col-6"><div class="form-group">
<label for=""> Customer Name</label>
<input type="text" name="name" class="validate[required] form-control"  value="<?=$rows1['name']?>">
</div></div> 

<div class="col"><div class="form-group">
<label for=""> Email ID</label>
<input type="text" name="email" class="validate[required] form-control" value="<?=$rows1['email']?>">
</div></div>
</div>
<div class="row">
<div class="col-6">
<div class="form-group">
<label>Phone No</label>
<input type="text" name="phone" class="validate[required] form-control"  value="<?=$rows1['phone']?>" placeholder="">
</div></div> 
<div class="col-6"><div class="form-group">
<label>Amount to pay</label>
<input type="text" name="amount" class="validate[required] form-control"  placeholder="">
</div></div>  
</div>
<div class="row">
<div class="col-6"><div class="form-group"> <!-- State Button -->
<label>Select Service</label>
<select class="validate[required] form-control" name="service" >
<option value="">Select...</option>
<?php 
$service_query = $PDO->db_query("select * from #_product_manager where status='1'");
while($service_rows = $PDO->db_fetch_array($service_query)){ ?>
<option value="<?=$service_rows['pid']?>" <?=($service_rows['pid']==$rows1['service'])?'selected="selected"':''?>  ><?=$service_rows['name']?></option>
<?php } ?>
</select>	
<input type="hidden" name="lid"  value="<?=$rows1['pid']?>">					
</div></div>
</div>

<?php


}
}

?>
 