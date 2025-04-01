<?php 
include("../lib/config.inc.php");
include('excelwriter.inc.php');

	    $filepath = 'SalesReprt'.$_GET['rsdate']."_".$_GET['redate'].".xls";
	    $excel=new ExcelWriter($filepath);
		if($excel==false) {	echo $excel->error;	}
		
	   $date1=$_GET['rsdate'];
		$date2=$_GET['redate'];
		$prd_query=$PDO->db_query("select * from #_leads where 1");
		
		$total=$prd_query->rowCount();
        $i=0;
		$myArr=array("<b>Serial No</b>","<b>RW Lead</b>","<b>Sales Executive</b>", "<b>Name of client</b>","<b>Service taken</b>", "<b>Sales Amount</b>", "<b>Amount Recd</b>", "<b> Pending Payment</b>", "<b>Mode of payment</b>", "<b>Bank Name</b>", "<b> Payment Ref No</b>", "<b>Recieved by</b>", "<b>Invoice Ref</b>","<b>Lead Source</b>","<b>Date</b>");

$excel->writeLine($myArr);

$contents = "Serial No,RW Lead, Name of client,Service taken, Sales Amount, Amount Recd,  Pending Payment, Mode of payment, Bank Name,  Payment Ref No, Recieved by, Invoice Ref,Lead Source\n,Date";
		$jj=1;
		$total_price=0; 
		$rAmount=0;
        while($prd_rows  = $PDO->db_fetch_array($prd_query))

        {  $salesAmount=$PDO->getSingleresult("select sum(serviceprice) from #_crequirement where lid='".$prd_rows['pid']."' and DATE(created_on) between '".$date1."' and '".$date2."'");
		  
		if($salesAmount>0){
		    $services=$PDO->getSingleresult("select name from #_product_manager where pid='".$prd_rows['service']."'");
				if($prd_rows['salesecutiveid']){
				$salesecutiveid=$PDO->getSingleresult("select name from pms_admin_users where user_id='".$prd_rows['salesecutiveid']."'");}
				if($prd_rows['source']){
				$source=$PDO->getSingleresult("select name from #_lead_source where pid='".$prd_rows['source']."'");}
				
				 
				  $total_price += $salesAmount; 
				 $salesdate=$PDO->getSingleresult("select created_on from #_crequirement where lid='".$prd_rows['pid']."'");
				  $recievedAmount=$PDO->getSingleresult("select sum(qAmount) from #_paymentdetails where lid='".$prd_rows['pid']."' and DATE(created_on) between '".$date1."' and '".$date2."'");
				   $rAmount += $recievedAmount; 
				  
				  $pdetails=$PDO->getResult("select * from #_paymentdetails where lid='".$prd_rows['pid']."'");
				  
				  $invoice=$PDO->getSingleresult("select inviceno from #_invoice where lid='".$prd_rows['pid']."'");
			
			$excel->writeRow();	
            $excel->writeCol($jj);
			$excel->writeCol($PDO->parse_output($prd_rows['rwi']));
             $excel->writeCol($salesecutiveid);
			$excel->writeCol($prd_rows['name']);

			$excel->writeCol($services==''?$prd_rows['service']:$services);

			$excel->writeCol($salesAmount);

			$excel->writeCol($recievedAmount);

			$excel->writeCol( (int)$salesAmount - (int)$recievedAmount);

			$excel->writeCol($ADMIN->displayPaymentMode($pdetails['pmode']));

			$excel->writeCol($pdetails['pg'].$pdetails['bankName'].$pdetails['paytm']);

			$excel->writeCol($pdetails['tnumber']);
			$excel->writeCol($pdetails['tnumber']);

			$excel->writeCol($invoice);

			$excel->writeCol($source);
			$excel->writeCol($salesdate);
			//$excel->writeCol(date('Y-m-d',strtotime($prd_rows['created_on'])));
		$jj++;}}  
$diffrence=(int)$total_price - (int)$rAmount;
              $excel->writeRow();
			   $excel->writeRow('&nbsp;');
			   $excel->writeCol('&nbsp;');	
			    $excel->writeCol('&nbsp;');	
				 $excel->writeCol('&nbsp;');
				  $excel->writeCol('&nbsp;');	
            $excel->writeCol("<b>Total</b>");
			$excel->writeCol('<b>'.$total_price.'</b>');
			$excel->writeCol('<b>'.$rAmount.'</b>');
			$excel->writeCol('<b>'.$diffrence.'</b>');

		$excel->close();

$total=$jj-1;
	header("Location:downloadleads.php?files=".$filepath);

exit;
?>