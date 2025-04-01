<?php include '../lib/config.inc.php';
//print_r($_POST);
if($_POST['readmsg']){
$PDO->db_query("update #_task set dstatus=1 where reciverid='".$_SESSION["AMD"][0]."'");

}
if($_POST['type']=='rates'){
$payry =$PDO->db_query("select * from #_hotel_manager where pid='".$_POST['pid']."'"); 
$payRs = $PDO->db_fetch_array($payry);
?>
<div class="modal-dialog">

<div class="modal-content">
<!-- Modal Header -->
<div class="modal-header">
<h4 class="modal-title"><?=$payRs['name']?></h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<!-- Modal body -->
<div class="modal-body">
<table class="table table-bordered table-responsive-xs table-responsive-sm  table-striped custom-table">
<thead>
<tr>
<th>From</th>
<th>To</th>
<th>Season</th>
<th>Cost</th>
</tr>
</thead>
<tbody>

<?php
$fromdate=explode(':',$payRs['fromdate']);
$todate=explode(':',$payRs['todate']);
$season=explode(':',$payRs['season']);
$cost=explode(':',$payRs['cost']);


//print_r($fromdate);
foreach ($fromdate as $key => $value){  ?>
<tr>
<td><?=$value?></td>
<td><?=$todate[$key]?></td>
<td><?=$season[$key]?></td>
<td><?=$cost[$key]?></td>
</tr>
<?php } ?>
</tbody></table>
</div>
<!-- Modal footer -->
<div class="modal-footer">
<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
</div>
</div>

</div>

<?php
}

if($_POST['profitdates']){
?>
<thead>
<tr>
<?php $monthilyry =$PDO->db_query("select * from pms_admin_users where status=1 and user_type=5 ".$adminqry.""); 
$date3 = date('Y-m-d'); 
while($monthRs = $PDO->db_fetch_array($monthilyry)){

$invocieAmiount=$PDO->getSingleresult("select sum(hmaintotal) from #_invoice where DATE(created_on)='".$_POST['profitdates']."' and create_by='".$monthRs['user_id']."'");
$costAmiount=$PDO->getSingleresult("select sum(costprice) from #_cost_list where DATE(created_on)='".$_POST['profitdates']."' and create_by='".$monthRs['user_id']."'");
$profit=$invocieAmiount-$costAmiount;
$saleamount2 .=' <td> Rs '.($profit==''?'0':$profit).'</td>';
$totalquotion2 += $profit;
?>
<th><?=$monthRs['name']?></th>
<?php } ?>
</tr>
</thead>
<tbody>
<tr>
<?=$saleamount2?>
</tr>
<tr class="total-td">
<td colspan="<?=$monthilyry->rowCount()-2?>">&nbsp;</td>
<td class="text-right">Total</td>
<td>Rs  <?=$totalquotion2?></td>
</tr>
</tbody>
<?php
}	
if($_POST['dates']){
?>  
 <thead>
                <tr>
                  <th>Name</th>
                  <th>Total</th>
                 <!-- <th>Received</th>
                  <th>Pending</th>-->
                </tr>
              </thead>
              <tbody>
                 <?php 
				 $totalAmount=0; 
				  $date2 = $_POST['dates']; 
			$payry =$PDO->db_query("select * from pms_admin_users where status=1 and user_type=5"); 
	       while($payRs = $PDO->db_fetch_array($payry)){
		$salesAmiount=$PDO->getSingleresult("select sum(serviceprice) from #_crequirement where DATE(created_on)='".$date2."' and create_by='".$payRs['user_id']."'");
if($salesAmiount!=0){
$totalAmount +=$salesAmiount;

$stateDQuery=$PDO->db_query("select lid from #_crequirement where DATE(created_on)='".$date2."' and create_by='".$payRs['user_id']."'");
//print_r($pids);
 $stateDResult=$PDO->db_fetch_all($stateDQuery,PDO::FETCH_COLUMN);
if (!empty($stateDResult)) {
 $drIds = implode(',',$stateDResult);
 $staeRy="  pid IN ($drIds)";
}  else { 
	$staeRy="   pid IN (0)";
}

 $pids['lid'];
		 ?>
	<tr>
                  <td>
				  <a href="#" data-toggle="modal" data-target="#salesr<?=$payRs['user_id']?>"><?=$payRs['name']?></a>
                 
                  <div class="modal fade" id="salesr<?=$payRs['user_id']?>">
                      <div class="modal-dialog" style="max-width:80%; width:80%">
                        <div class="modal-content w-100 table-responsive"> 
                          
                          <!-- Modal Header -->
                          
                          <div class="modal-header">
                            <h4 class="modal-title">Sales Detail</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                          </div>
                          
                          <!-- Modal body -->
                          
                          <div class="modal-body table-responsive">
                            <table class="table table-bordered table-responsive-xs table-responsive-sm  table-striped custom-table">
                              <thead>
                                <tr>
                                  <th>Sl No</th>
                                  <th>Client Name </th>
                                  <th>Service</th>
                                  <th>Ticket no</th>
                                  <th>Total</th>
                                  <th>Recived</th>
                                  <th>Pending</th>
                                  <th>Source</th>
                                </tr>
                              </thead>
                              <tbody>
                              <?php $payleadsry =$PDO->db_query("select * from #_leads where  $staeRy"); 
							  $cc=1;
							  $total_price = 0;
							   $r_price = 0;
							   $noofinvoice = 0;
	       while($leadspayRs = $PDO->db_fetch_array($payleadsry)){
			 
			 $invoiamount=$PDO->getSingleresult("select sum(serviceprice) from #_crequirement where create_by='".$payRs['user_id']."' and DATE(created_on)='".$date2."' and lid='".$leadspayRs['pid']."'");
		$recieAmount=$PDO->getSingleresult("select sum(qAmount) from #_paymentdetails where sentBy='".$payRs['user_id']."' and DATE(created_on)='".$date2."' and lid='".$leadspayRs['pid']."'");
		
			 
			 $total_price += $invoiamount; 
		   $r_price += $recieAmount; 
			$noofinvoice += 1; 
			    ?>
                                <tr>
                                  <td><?=$cc?> </td>
                                  <td><?=$leadspayRs['name']?></td>
                                   <td><?=$PDO->getSingleresult("select name from #_product_manager where pid='".$leadspayRs['service']."'")?></td>
                                  <td><?=$leadspayRs['rwi']?></td>
                                  <td>Rs <?=$invoiamount?></td>
                                  <td>Rs <?=$recieAmount?></td>
                                  <td>Rs <?=(int)$invoiamount - (int)$recieAmount?></td>
                                    <td><?=$PDO->getSingleresult("select name from #_lead_source where pid='".$leadspayRs['source']."'");?></td>
                                </tr>
                               <?php $cc++;} ?> 
                              </tbody>
                            </table>
                          </div>
                          
                          <!-- Modal footer -->
                          
                          <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  
				  </td>
                  <td>Rs <?=$salesAmiount==''?'0':$salesAmiount;?></td>
              
                </tr>
	<?php }	} ?>
                
                
                
                <tr class="text-bold">
                  <td></td>
                 <td>Rs <?=$totalAmount==''?'0':$totalAmount;?></td>
                </tr>
              </tbody>
<?php
}

	
if($_POST['months']){

$Period = explode('-',$_POST['months']);
echo $Period[1];
// exit;
?>
<thead>
<tr>
<?php $monthilyry =$PDO->db_query("select * from pms_admin_users where status=1 and user_type=5 ".$adminqry.""); 
while($monthRs = $PDO->db_fetch_array($monthilyry)){

$quotion=$PDO->getSingleresult("select sum(serviceprice) from #_crequirement where YEAR(created_on)='".$Period[1]."' and MONTH(created_on)='".$Period[0]."' and create_by='".$monthRs['user_id']."'");
$saleamount .=' <td> Rs '.($quotion==''?'0':$quotion).'</td>';

$totalquotion += $quotion;
?>
<th><?=$monthRs['name']?></th>
<?php  } ?>
</tr>
</thead>
<tbody>
<tr>
<?=$saleamount?>
</tr>
<tr class="total-td">
<td colspan="<?=$monthilyry->rowCount()-2?>">&nbsp;</td>
<td class="text-right">Total</td>
<td>Rs  <?=$totalquotion?></td>
</tr>
</tbody>
<?php
}
if($_POST['sourcemonths']){

$Period = explode('-',$_POST['sourcemonths']);
echo $Period[1];
// exit;
?>
   <thead>
              <tr>
                <th>Name</th>
                <th>Total</th>
                
                <!-- <th>Received</th>

                  <th>Pending</th>--> 
                
              </tr>
            </thead>
            <tbody>
              <?php 
				 $totalAmount=0; 
			$payry =$PDO->db_query("select * from #_lead_source where status=1"); 
	       while($payRs = $PDO->db_fetch_array($payry)){
			$sq=$payRs['pid']==13?'utm_source':'source';   
		$salesAmiount=$PDO->getSingleresult("select sum(serviceprice) as serviceprice from #_crequirement as cr join #_leads as ld on cr.lid=ld.pid where YEAR(cr.created_on)='".$Period[1]."' and MONTH(cr.created_on)='".$Period[0]."' and ld.$sq='".$payRs['pid']."'");

if($salesAmiount!=0){

$totalAmount +=$salesAmiount;



$stateDQuery=$PDO->db_query("select lid from #_crequirement as cr join #_leads as ld on cr.lid=ld.pid where YEAR(cr.created_on)='".$Period[1]."' and MONTH(cr.created_on)='".$Period[0]."' and ld.source='".$payRs['pid']."'");

//print_r($pids);

 $stateDResult=$PDO->db_fetch_all($stateDQuery,PDO::FETCH_COLUMN);

if (!empty($stateDResult)) {

 $drIds = implode(',',$stateDResult);

 $staeRy="  pid IN ($drIds)";

}  else { 

	$staeRy="   pid IN (0)";

}



 $pids['lid'];

		 ?>
              <tr>
                <td><a href="#" data-toggle="modal" data-target="#salesr<?=$payRs['pid']?>">
                  <?=$payRs['name']?>
                  </a>
                  <div class="modal fade" id="salesr<?=$payRs['pid']?>">
                    <div class="modal-dialog" style="max-width:80%; width:80%">
                      <div class="modal-content w-100 table-responsive"> 
                        
                        <!-- Modal Header -->
                        
                        <div class="modal-header">
                          <h4 class="modal-title">Sales Detail</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        
                        <!-- Modal body -->
                        
                        <div class="modal-body table-responsive">
                          <table class="table table-bordered table-responsive-xs table-responsive-sm  table-striped custom-table">
                            <thead>
                              <tr>
                                <th>Sl No</th>
                                <th>Client Name </th>
                                <th>Service</th>
                                <th>Ticket no</th>
                                <th>Total</th>
                                <th>Recived</th>
                                <th>Pending</th>
                                <th>Sale Executive</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $payleadsry =$PDO->db_query("select * from #_leads where  $staeRy"); 

							  $cc=1;

							  $total_price = 0;

							   $r_price = 0;

							   $noofinvoice = 0;

	       while($leadspayRs = $PDO->db_fetch_array($payleadsry)){

			 

			 $invoiamount=$PDO->getSingleresult("select sum(serviceprice) from #_crequirement where YEAR(created_on)='".$Period[1]."' and MONTH(created_on)='".$Period[0]."' and lid='".$leadspayRs['pid']."'");

		$recieAmount=$PDO->getSingleresult("select sum(qAmount) from #_paymentdetails where YEAR(created_on)='".$Period[1]."' and MONTH(created_on)='".$Period[0]."' and lid='".$leadspayRs['pid']."'");

		

			 

			 $total_price += $invoiamount; 

		   $r_price += $recieAmount; 

			$noofinvoice += 1; 

			    ?>
                              <tr>
                                <td><?=$cc?></td>
                                <td><?=$leadspayRs['name']?></td>
                                <td><?=$PDO->getSingleresult("select name from #_product_manager where pid='".$leadspayRs['service']."'")?></td>
                                <td><?=$leadspayRs['rwi']?></td>
                                <td>Rs
                                  <?=$invoiamount?></td>
                                <td>Rs
                                  <?=$recieAmount?></td>
                                <td>Rs
                                  <?=(int)$invoiamount - (int)$recieAmount?></td>
                                <td><?=$PDO->getSingleresult("select name from pms_admin_users where user_id='".$leadspayRs['salesecutiveid']."'");?></td>
                              </tr>
                              <?php $cc++;} ?>
                            </tbody>
                          </table>
                        </div>
                        
                        <!-- Modal footer -->
                        
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div></td>
                <td>Rs
                  <?=$salesAmiount==''?'0':$salesAmiount;?></td>
              </tr>
              <?php }	} ?>
              <tr class="text-bold">
                <td></td>
                <td>Rs
                  <?=$totalAmount==''?'0':$totalAmount;?></td>
              </tr>
             
            </tbody>
<?php
}

if($_POST['sourceSummary']){

$Period = explode('-',$_POST['sourceSummary']);
echo $Period[1];
// exit;
?>
   <thead>
              <tr>
                <th>Name</th>
                <th>Total</th>
                
                <!-- <th>Received</th>

                  <th>Pending</th>--> 
                
              </tr>
            </thead>
            <tbody>
              <?php 
				 $totalAmount2=0; 
			$payry =$PDO->db_query("select * from #_lead_source where pid IN(1,4)"); 
	       while($payRs = $PDO->db_fetch_array($payry)){
			$sq=$payRs['pid']==13?'utm_source':'source';   
		$salesAmiount2=$PDO->getSingleresult("select sum(serviceprice) as serviceprice from #_crequirement as cr join #_leads as ld on cr.lid=ld.pid where YEAR(cr.created_on)='".$Period[1]."' and MONTH(cr.created_on)='".$Period[0]."' and ld.$sq='".$payRs['pid']."'");

if($salesAmiount2!=0){

$totalAmount2 +=$salesAmiount2;



$stateDQuery2=$PDO->db_query("select lid from #_crequirement as cr join #_leads as ld on cr.lid=ld.pid where YEAR(cr.created_on)='".$Period[1]."' and MONTH(cr.created_on)='".$Period[0]."' and ld.source='".$payRs['pid']."'");

//print_r($pids);

 $stateDResult2=$PDO->db_fetch_all($stateDQuery2,PDO::FETCH_COLUMN);

if (!empty($stateDResult2)) {

 $drIds2 = implode(',',$stateDResult2);

 $staeRy2="  pid IN ($drIds2)";

}  else { 

	$staeRy2="   pid IN (0)";

}



 $pids['lid'];
	 ?>
              <tr>
                <td><a href="#" data-toggle="modal" data-target="#salesrs<?=$payRs['pid']?>">
                  <?=$payRs['name']?>
                  </a>
                  <div class="modal fade" id="salesrs<?=$payRs['pid']?>">
                    <div class="modal-dialog" style="max-width:80%; width:80%">
                      <div class="modal-content w-100 table-responsive"> 
                        
                        <!-- Modal Header -->
                        
                        <div class="modal-header">
                          <h4 class="modal-title">Sales Detail</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        
                        <!-- Modal body -->
                        
                        <div class="modal-body table-responsive">
                          <table class="table table-bordered table-responsive-xs table-responsive-sm  table-striped custom-table">
                            <thead>
                              <tr>
                                <th>Sl No</th>
                                <th>Client Name </th>
                                <th>Service</th>
                                <th>Ticket no</th>
                                <th>Total</th>
                                <th>Recived</th>
                                <th>Pending</th>
                                <th>Sale Executive</th>
                                <th>Source</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $payleadsry =$PDO->db_query("select * from #_leads where  $staeRy2"); 
							  $cc=1;
							   $noofinvoice = 0;
	       while($leadspayRs = $PDO->db_fetch_array($payleadsry)){
			 $invoiamount=$PDO->getSingleresult("select sum(serviceprice) from #_crequirement where YEAR(created_on)='".$Period[1]."' and MONTH(created_on)='".$Period[0]."' and lid='".$leadspayRs['pid']."'");

		$recieAmount=$PDO->getSingleresult("select sum(qAmount) from #_paymentdetails where YEAR(created_on)='".$Period[1]."' and MONTH(created_on)='".$Period[0]."' and lid='".$leadspayRs['pid']."'");
			$noofinvoice += 1; 

			    ?>
                              <tr>
                                <td><?=$cc?></td>
                                <td><?=$leadspayRs['name']?></td>
                                <td><?=$PDO->getSingleresult("select name from #_product_manager where pid='".$leadspayRs['service']."'")?></td>
                                <td><?=$leadspayRs['rwi']?></td>
                                <td>Rs
                                  <?=$invoiamount?></td>
                                <td>Rs
                                  <?=$recieAmount?></td>
                                <td>Rs
                                  <?=(int)$invoiamount - (int)$recieAmount?></td>
                                <td><?=$PDO->getSingleresult("select name from pms_admin_users where user_id='".$leadspayRs['salesecutiveid']."'");?></td>  <td><?=$payRs['name']?></td>
                              </tr>
                              <?php $cc++;} ?>
                            </tbody>
                          </table>
                        </div>
                        
                        <!-- Modal footer -->
                        
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div></td>
                <td>Rs
                  <?=$salesAmiount2==''?'0':$salesAmiount2;?></td>
              </tr>
              <?php }	} ?>
               <tr>
                <td><a href="#" data-toggle="modal" data-target="#salesrits">
                  IT Source
                  </a>
                  <?php 
				  $salesAmiountit=$PDO->getSingleresult("select sum(serviceprice) as serviceprice from #_crequirement as cr join #_leads as ld on cr.lid=ld.pid where YEAR(cr.created_on)='".$Period[1]."' and MONTH(cr.created_on)='".$Period[0]."' and ld.source IN (3,5,6,7,10,11,8,9,14,29)");

$itQuery=$PDO->db_query("select lid from #_crequirement as cr join #_leads as ld on cr.lid=ld.pid where YEAR(cr.created_on)='".$Period[1]."' and MONTH(cr.created_on)='".$Period[0]."' and ld.source IN (3,5,6,7,10,11,8,9,14,29)");


 $itResult=$PDO->db_fetch_all($itQuery,PDO::FETCH_COLUMN);
//print_r($itResult);
if (!empty($itResult)) {

 $itIds = implode(',',$itResult);

 $sids="  pid IN ($itIds)";

}  else { 

	$sids="   pid IN (0)";

}
	
				   ?>
                  <div class="modal fade" id="salesrits">
                    <div class="modal-dialog" style="max-width:80%; width:80%">
                      <div class="modal-content w-100 table-responsive"> 
                        
                        <!-- Modal Header -->
                        
                        <div class="modal-header">
                          <h4 class="modal-title">Sales Detail</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        
                        <!-- Modal body -->
                        
                        <div class="modal-body table-responsive">
                          <table class="table table-bordered table-responsive-xs table-responsive-sm  table-striped custom-table">
                            <thead>
                              <tr>
                                <th>Sl No</th>
                                <th>Client Name </th>
                                <th>Service</th>
                                <th>Ticket no</th>
                                <th>Total</th>
                                <th>Recived</th>
                                <th>Pending</th>
                                <th>Sale Executive</th>
                                <th>Source</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
							 // echo "select * from #_leads where  $sids";
							   $payleadsry =$PDO->db_query("select * from #_leads where  $sids"); 
							  $cc=1;
	       while($leadspayRs = $PDO->db_fetch_array($payleadsry)){
			 $invoiamount=$PDO->getSingleresult("select sum(serviceprice) from #_crequirement where YEAR(created_on)='".$Period[1]."' and MONTH(created_on)='".$Period[0]."' and lid='".$leadspayRs['pid']."'");

		$recieAmount=$PDO->getSingleresult("select sum(qAmount) from #_paymentdetails where YEAR(created_on)='".$Period[1]."' and MONTH(created_on)='".$Period[0]."' and lid='".$leadspayRs['pid']."'");
		
			    ?>
                              <tr>
                                <td><?=$cc?></td>
                                <td><?=$leadspayRs['name']?></td>
                                <td><?=$PDO->getSingleresult("select name from #_product_manager where pid='".$leadspayRs['service']."'")?></td>
                                <td><?=$leadspayRs['rwi']?></td>
                                <td>Rs
                                  <?=$invoiamount?></td>
                                <td>Rs
                                  <?=$recieAmount?></td>
                                <td>Rs
                                  <?=(int)$invoiamount - (int)$recieAmount?></td>
                                <td><?=$PDO->getSingleresult("select name from pms_admin_users where user_id='".$leadspayRs['salesecutiveid']."'");?></td>  <td><?=$PDO->getSingleresult("select name from #_lead_source where pid='".$leadspayRs['source']."'");?></td>
                              </tr>
                              <?php $cc++;} ?>
                            </tbody>
                          </table>
                        </div>
                        
                        <!-- Modal footer -->
                        
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div></td>
                <td>Rs
                  <?=$salesAmiountit==''?'0':$salesAmiountit;?></td>
              </tr>
              
               <tr>
                <td><a href="#" data-toggle="modal" data-target="#salesrold">
                  Old Client
                  </a>
                  <?php 
				  $salesAmiountOld=$PDO->getSingleresult("select sum(serviceprice) as serviceprice from #_crequirement as cr join #_leads as ld on cr.lid=ld.pid where YEAR(cr.created_on)='".$Period[1]."' and MONTH(cr.created_on)='".$Period[0]."' and ld.source IN (28,20,19,27)");

$oldQuery=$PDO->db_query("select lid from #_crequirement as cr join #_leads as ld on cr.lid=ld.pid where YEAR(cr.created_on)='".$Period[1]."' and MONTH(cr.created_on)='".$Period[0]."' and ld.source IN (28,20,19,27)");


 $oldResult=$PDO->db_fetch_all($oldQuery,PDO::FETCH_COLUMN);
//print_r($itResult);
if (!empty($oldResult)) {

 $oldIds = implode(',',$oldResult);

 $oldids="  pid IN ($oldIds)";

}  else { 

	$sids="   pid IN (0)";

}
	
				   ?>
                  <div class="modal fade" id="salesrold">
                    <div class="modal-dialog" style="max-width:80%; width:80%">
                      <div class="modal-content w-100 table-responsive"> 
                        
                        <!-- Modal Header -->
                        
                        <div class="modal-header">
                          <h4 class="modal-title">Sales Detail</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        
                        <!-- Modal body -->
                        
                        <div class="modal-body table-responsive">
                          <table class="table table-bordered table-responsive-xs table-responsive-sm  table-striped custom-table">
                            <thead>
                              <tr>
                                <th>Sl No</th>
                                <th>Client Name </th>
                                <th>Service</th>
                                <th>Ticket no</th>
                                <th>Total</th>
                                <th>Recived</th>
                                <th>Pending</th>
                                <th>Sale Executive</th>
                                <th>Source</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
							 // echo "select * from #_leads where  $sids";
							   $payleadsry =$PDO->db_query("select * from #_leads where  $oldids"); 

							  $cc=1;

							  $total_price = 0;

							   $r_price = 0;

							   $noofinvoice = 0;

	       while($leadspayRs = $PDO->db_fetch_array($payleadsry)){

			 

			 $invoiamount=$PDO->getSingleresult("select sum(serviceprice) from #_crequirement where YEAR(created_on)='".$Period[1]."' and MONTH(created_on)='".$Period[0]."' and lid='".$leadspayRs['pid']."'");

		$recieAmount=$PDO->getSingleresult("select sum(qAmount) from #_paymentdetails where YEAR(created_on)='".$Period[1]."' and MONTH(created_on)='".$Period[0]."' and lid='".$leadspayRs['pid']."'");

		

			 

			 $total_price += $invoiamount; 

		   $r_price += $recieAmount; 

			$noofinvoice += 1; 

			    ?>
                              <tr>
                                <td><?=$cc?></td>
                                <td><?=$leadspayRs['name']?></td>
                                <td><?=$PDO->getSingleresult("select name from #_product_manager where pid='".$leadspayRs['service']."'")?></td>
                                <td><?=$leadspayRs['rwi']?></td>
                                <td>Rs
                                  <?=$invoiamount?></td>
                                <td>Rs
                                  <?=$recieAmount?></td>
                                <td>Rs
                                  <?=(int)$invoiamount - (int)$recieAmount?></td>
                                <td><?=$PDO->getSingleresult("select name from pms_admin_users where user_id='".$leadspayRs['salesecutiveid']."'");?></td>  <td><?=$PDO->getSingleresult("select name from #_lead_source where pid='".$leadspayRs['source']."'");?></td>
                              </tr>
                              <?php $cc++;} ?>
                            </tbody>
                          </table>
                        </div>
                        
                        <!-- Modal footer -->
                        
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div></td>
                <td>Rs
                  <?=$salesAmiountOld==''?'0':$salesAmiountOld;?></td>
              </tr>
              
              <tr class="text-bold">
                <td></td>
                <td>Rs
                  <?=$totalAmount2+$salesAmiountit+$salesAmiountOld;?></td>
              </tr>
             
            </tbody>
<?php
}
if($_POST['taskid']){
$task_query = $PDO->db_query("select * from #_task where pid='".$_POST['taskid']."'");
$task_rows = $PDO->db_fetch_array($task_query);
?>


<div class="modal-dialog modal-md">
<div class="modal-content"> 

<!-- Modal Header -->
<div class="modal-header">
<h4 class="modal-title m-0 p-0"><?=$task_rows['name']?> </h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

<!-- Modal body -->
<div class="modal-body">
<div class="">
<div class="row">
<div class="col-12 col-md-12">
<div class="media border p-3 bg-light mb-2">
<div class="media-body">
<h6>Deadline <i class="pull-right"><?=$task_rows['deadLine']?> </i></h6>
<hr  class="m-0 pb-2"/>
<p>Allocated by <i class="pull-right"><?=$PDO->getSingleresult("select name from pms_admin_users where user_id='".$task_rows['senderid']."'");?> </i> </p>
<p>On <i class="pull-right"><?=$task_rows['created_on']?> </i> </p>
<hr  class="m-0 pb-2"/>
<p><?=$task_rows['comments']?> </p>
</div>
</div>
</div>
</div>

<?php
if($task_rows['status']==1){?>
<div class="col-12 col-md-12">
<div class="media border p-3 bg-light mb-2">
<div class="media-body">
<p>Replied by <i class="pull-right"><?=$PDO->getSingleresult("select name from pms_admin_users where user_id='".$task_rows['reciverid']."'");?> </i> </p>
<p>On <i class="pull-right"><?=$task_rows['modified_on']?> </i> </p>
<hr  class="m-0 pb-2"/>
<p><?=$task_rows['replycontent']?> </p>
</div>
</div>
</div>
<?php 
}
if($task_rows['reciverid']==$_SESSION["AMD"][0] && $task_rows['status']!=1){ ?>
<div class="row">
<div class="col-12 col-md-12">
<div class="form-group">
<label>Status</label>
<select class="validate[required] form-control" name="rstatus">
<option value="">select status</option>
<option value="Done">Done</option>
<option value="Pending">Pending</option>
<option value="other">other</option>
</select>
</div>
</div>
</div>
<div class="row">
<div class="col-12 col-md-12">
<div class="form-group">
<label for="">Reply</label>
<textarea class="validate[required] form-control" name="replycontent"></textarea>
</div>
</div>
</div>
<?php } ?>
</div>
</div>

<!-- Modal footer -->
<?php if($task_rows['reciverid']==$_SESSION["AMD"][0] && $task_rows['status']!=1){ ?>
<div class="modal-footer">
<input type="hidden" name="taskid" value="<?=$task_rows['pid']?>" />
<button type="submit" name="allreply" class="btn btn-primary">Submit</button>
</div>
<?php } ?>
</div>
</div>

<?php
}


if($_POST['lid']){

$rys2=$PDO->db_query("SELECT * from #_leads WHERE rwi='".$_POST['lid']."' order by name ASC");
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
</div></div> 



</div> <?php } 
else if($_POST['type']=='Quick'){
?>
<div class="row">
<div class="col"><div class="form-group">
<label>Email ID</label>
<input type="text" name="email" class="validate[required] form-control" value="<?=$rows1['email']?>">
<input type="hidden" name="name" class="validate[required] form-control"  value="<?=$rows1['name']?>">
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
</div></div>
</div>

<?php


}
}

if($_POST['followdate']){ ?>
<thead>
<tr>
<th>Sl.No.</th>
<th>RW Ticket</th>
<th>Sale Executive</th>
<th>Customer Name</th>
<th>Customer Phone</th>
<th>Service</th>
<th>Date/Time</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php  

$folups="where 1";

if($_SESSION["AMD"][3]=='5'){
$folups="where sentBy='".$_SESSION["AMD"][0]."'";
}

$date2 = $_POST['followdate']; 
$jj=1;
$payry =$PDO->db_query("select * from #_pms_activity ".$folups." and status=2 and dates='".$date2."' and fstatus=0"); 

while($payRs = $PDO->db_fetch_array($payry)){
$leadsresult=$PDO->getResult("select * from #_leads where pid='".$payRs['lid']."'");
?>
<tr>
 <td><?=$jj?></td>
                  <td><?=$leadsresult['rwi'];?>
                  <td><?=$PDO->getSingleresult("select name from pms_admin_users where user_id='".$payRs['sentBy']."'");?></td>
                  
                  <td><?=$leadsresult['name']?></td>
                  <td><?=$leadsresult['phone']?></td>
                  <td><?=$PDO->getSingleresult("select name from #_product_manager where pid='".$leadsresult['service']."'");?></td>
<td><?=date('jS \ M y', strtotime($payRs['dates']))?>
<?=date('h:i', strtotime($payRs['times']))?></td>
<td><a href="<?=SITE_PATH_ADM.'index.php?comp=leads&mode=edit&followup='.$payRs['pid'].'&uid='.$PDO->getSingleresult("select pid from #_leads where pid='".$payRs['lid']."'")?>"  data-toggle="tooltip" title=""><i class="fa fa-edit"></i></a></td>
</tr>
<?php  $jj++;}

?>
</tbody>

<?php }
if($_POST['pdate']){
$wrchart="where 1";
$folups="where 1";

if($_SESSION["AMD"][3]=='5'){

$extra = " and create_by='".$_SESSION["AMD"][0]."' or salesecutiveid='".$_SESSION["AMD"][0]."'"; 
$adminqry="and user_id='".$_SESSION["AMD"][0]."'";

$wrchart="where salesecutiveid='".$_SESSION["AMD"][0]."'";
$folups="where sentBy='".$_SESSION["AMD"][0]."'";

}

$paid=$PDO->getSingleresult("select count(*) from #_leads ".$wrchart." and DATE(created_on)='".$_POST['pdate']."' and source IN (select pid from #_lead_source where ltype='Paid') ");

$organic=$PDO->getSingleresult("select count(*) from #_leads ".$wrchart." and DATE(created_on)='".$_POST['pdate']."' and source IN (select pid from #_lead_source where ltype='Organic') ");
$audatas='{"name": "Paid", "y": '.$paid.'},{"name": "Organic", "y": '.$organic.'}';
?>
<script type="text/javascript">


// Make monochrome colors
var pieColors = (function () {
var colors = [],
base = Highcharts.getOptions().colors[0],
i;

for (i = 0; i < 10; i += 1) {
// Start out with a darkened base color (negative brighten), and end
// up with a much brighter color
colors.push(Highcharts.Color(base).brighten((i - 3) / 7).get());
}
return colors;
}());

// Build the chart
Highcharts.chart('countrymana', {
colors: ['#81b537', '#ea4335', '#FFA500', '#0f1b2f', '#34a853', '#ea4335', '#0000ff', '#ff0000', '#9900cc', '#099346', '#aaeeee'],

chart: {
type: 'pie'
},
credits: {
enabled: false
},
legend: {
align: 'left',
layout: 'vertical',
verticalAlign: 'top',
labelFormatter: function () {
return this.name +' '+ this.y;
},
x: 0,
y: 0,
},
title: {
text: 'Paid v/s Organic'
},
subtitle: {
// text: 'Lead Allocation by Salesecutive'
},
plotOptions: {
series: {
dataLabels: {
enabled: true,
format: '{point.name}: {point.y}'
},
showInLegend: true,

}
},
"series": [
{
"name": "Total",
"colorByPoint": true,
"data": [
<?=$audatas?>
]
}
]
});


</script>
<?php
}	

if($_POST['funneldate']){
$wrchart="where 1";
$folups="where 1";

if($_SESSION["AMD"][3]=='5'){

$extra = " and create_by='".$_SESSION["AMD"][0]."' or salesecutiveid='".$_SESSION["AMD"][0]."'"; 
$adminqry="and user_id='".$_SESSION["AMD"][0]."'";

$wrchart="where salesecutiveid='".$_SESSION["AMD"][0]."'";
$folups="where sentBy='".$_SESSION["AMD"][0]."'";

}

$comm=',';
$ii=1;
$lSry =$PDO->db_query("select * from #_lead_stage where status=1 order by shortorder ASC"); 
while($lSRs = $PDO->db_fetch_array($lSry)){
if($lSry->rowCount()==$ii){
$comm='';
}  
$cnt= $PDO->getSingleresult("select count(*) from #_leads ".$wrchart."  and status='".$lSRs['pid']."' and DATE(created_on)='".$_POST['funneldate']."'");
$stages .= '['.'\''.$lSRs['name'].'\','.$cnt.']'.$comm;
$ii++;
}
?>
<script>

Highcharts.chart('Funnel', {
colors: ['#28a745', '#1e406d', '#d1b655', '#454545', '#aaeeee',

'#ff0066', '#eeaaee', '#55BF3B', '#DF5353', '#7798BF', '#aaeeee'],	
chart: { backgroundColor: '#fafafa',  type: 'funnel' },
credits: { enabled: false},
title: { text: ''  },
plotOptions: {
series: {
dataLabels: {

enabled: true,

format: '<b>{point.name}</b> ({point.y:,.0f})',

color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',

softConnector: true

},

center: ['40%', '50%'],

neckWidth: '30%',

neckHeight: '25%',

width: '70%'

}

},

legend: {

enabled: false

},

series: [{

name: 'Registrationwala',

data: [<?=$stages?>]

}]

});

</script>
<?php  


}
if($_POST['saledate']){
?>     <?php 
		   $sry =$PDO->db_query("select * from #_product_manager where status=1"); 
		   $num=1;
	       while($sRs = $PDO->db_fetch_array($sry)){
		
		 $scnt2=$PDO->getSingleresult("select count(*),pid from #_leads  where service='".$sRs['pid']."' and salesecutiveid='".$_SESSION["AMD"][0]."' and DATE(created_on)='".$_POST['saledate']."'");
		 
	 $sequotion=$PDO->getSingleresult("select sum(serviceprice) from #_crequirement where  create_by='".$_SESSION["AMD"][0]."' and serviceid='".$sRs['pid']."' and DATE(created_on)='".$_POST['saledate']."'");
		$serecievedAmount=$PDO->getSingleresult("select sum(qAmount) from #_paymentdetails where sentBy='".$_SESSION["AMD"][0]."' and serviceid='".$sRs['pid']."' and DATE(created_on)='".$_POST['saledate']."'");
		 if($scnt2!='' && $sequotion!=''){
				?>
				<tr>
                  <td><?=$num?> </td>
                  <td><?=$sRs['name']?></td>
                   <td>Rs <?=$sequotion==''?'0':$sequotion;?></td>
                <!--  <td>Rs <?=$serecievedAmount==''?'0':$serecievedAmount;?></td>
                  <td>Rs <?=(int)$sequotion - (int)$serecievedAmount?></td>-->
                  <td><?=$scnt2?></td>
                </tr>
				
				<?php
		  $num++; }}
		  
		
}	
?>
 