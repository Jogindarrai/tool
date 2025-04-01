<?php 

include("../lib/config.inc.php");

include('excelwriter.inc.php');
if($_GET['stags']=="project")
{
	    $filepath = $_GET['stags'].@date("Ymd").".xls";
	    $excel=new ExcelWriter($filepath);
		if($excel==false) {	echo $excel->error;	}
	    $date1=$_GET['sdate'];
		$date2=$_GET['edate'];
		//print_r($_POST);
		//echo "select * from #_products where ".$wh; exit;
		if($date1!='' && $date2!=''){
			$wr="created_on between '".$date1."' and '".$date2."'";
			}else{$wr=1;}
			if($_GET['user']){
			$wr="pstatus='0' and managerid='".$_GET['user']."' and created_on between '".$date1."' and '".$date2."'";	
				}
			if($_GET['pstatus']){
			$wr="pstatus='1' and completed_on between '".$date1."' and '".$date2."'";	
			}
		//$prd_query=$PDO->db_query("select * from #_project where created_on between '".$date1."' and '".$date2."'");
		$prd_query=$PDO->db_query("select * from #_project where ".$wr);
//echo "select * from #_project where ".$wr;
//exit;
        $i=0;
		$myArr=array("Ticket No", "Client Name", "Service Name", " Sales Executive", " Manager", "Quotation", "Amount Received", " Balance Status", " Created By", " Created Date", "Completed Date","Status", "Client Email","Client Phone");

$excel->writeLine($myArr);

$contents = "Ticket No, Client Name, Service Name,  Sales Executive,  Manager, Quotation, Amount Received,  Balance Status,  Created By,  Created Date, Completed Date,Status, Client Email,Client Phone\n";
		
        while($prd_rows  = $PDO->db_fetch_array($prd_query))

        {
			
				$serviceids=str_replace(':',',',$prd_rows['servicefor']);
				$servicenames='';
				$sqry=$PDO->db_query("select package_name from rw_packages_type where id IN  ('".$serviceids."')");
				while($sdetails=$PDO->db_fetch_array($sqry)){
					$servicenames .=$sdetails['package_name'].', ';
					}
				if($prd_rows['sexecutiveid']){
				$sexecutiveid=$PDO->getSingleresult("select name from pms_admin_users where user_id='".$prd_rows['sexecutiveid']."'");}
				else{$sexecutiveid=$PDO->getSingleresult("select name from pms_admin_users where user_id='".$prd_rows['create_by']."'");}
				$manager=$PDO->getSingleresult("select name from pms_admin_users where user_id='".$prd_rows['managerid']."'");
				$createby=$PDO->getSingleresult("select name from pms_admin_users where user_id='".$prd_rows['create_by']."'");
			
			$excel->writeRow();	

			$excel->writeCol($PDO->parse_output($prd_rows['ticketnumber']));

			$excel->writeCol($prd_rows['clientname']);

			$excel->writeCol($servicenames);

			$excel->writeCol($sexecutiveid);

			$excel->writeCol($manager);

			$excel->writeCol($prd_rows['quotation']);

			$excel->writeCol($prd_rows['amountreceived']);

			$excel->writeCol($prd_rows['amountrequired']);

			$excel->writeCol($createby);

			$excel->writeCol($prd_rows['created_on']);

			$excel->writeCol($prd_rows['completed_on']);

			$excel->writeCol($ADMIN->displayprojectstatus($prd_rows['pstatus']));

			$excel->writeCol($prd_rows['clientemail']);

			$excel->writeCol($prd_rows['clientphone']);
		}

		$excel->close();

   /// Product Invantory

}

if($_GET['stags']=="leads")
{
	    $filepath = $_GET['stags'].@date("Ymd").".xls";
	    $excel=new ExcelWriter($filepath);
		if($excel==false) {	echo $excel->error;	}
	    $date1=$_GET['sdate'];
		$date2=$_GET['edate'];
		//print_r($_POST);
		//echo "select * from #_products where ".$wh; exit;
		if($date1!='' && $date2!=''){
			$wr="dates between '".$date1."' and '".$date2."'";
			}else{$wr= 1;}
			if($_GET['user']){
			$wr="pstatus='0' and salesecutiveid='".$_GET['user']."' and created_on between '".$date1."' and '".$date2."'";	
				}
			if($_GET['pstatus']){
			$wr="pstatus='1' and completed_on between '".$date1."' and '".$date2."'";	
			}
			
			if($serviceul!=''){
			$wr=$wr." and service='".$serviceul."'";	
				}
		//$prd_query=$PDO->db_query("select * from #_project where created_on between '".$date1."' and '".$date2."'");
		$prd_query=$PDO->db_query("select * from #_leads where ".$wr);

        $i=0;
		$myArr=array("Ticket No", "Name", "Email ID", " Phone", " Service", "Source", "Date", " Time", " Comment", " Sales Executive","Status");

$excel->writeLine($myArr);

$contents = "Ticket No,Name, Email ID,  Phone,  Service, Date, Time,  Comment,  Sales Executive ,Status\n";
		
        while($prd_rows  = $PDO->db_fetch_array($prd_query))

        {
				if($prd_rows['salesecutiveid']){
				$salesecutiveid=$PDO->getSingleresult("select name from pms_admin_users where user_id='".$prd_rows['salesecutiveid']."'");}
				if($prd_rows['source']){
				$source=$PDO->getSingleresult("select name from #_lead_source where pid='".$prd_rows['source']."'");}
				 $services=$PDO->getSingleresult("select name from #_product_manager where pid='".$prd_rows['service']."'");
			
			$excel->writeRow();	

			$excel->writeCol($PDO->parse_output($prd_rows['rwi']));

			$excel->writeCol($prd_rows['name']);

			$excel->writeCol($prd_rows['email']);

			$excel->writeCol($prd_rows['phone']);

			$excel->writeCol($services==''?$prd_rows['service']:$services);

			$excel->writeCol($source);

			$excel->writeCol($prd_rows['dates']);

			$excel->writeCol($prd_rows['times']);

			$excel->writeCol($prd_rows['comments']);

			$excel->writeCol($salesecutiveid);

			$excel->writeCol($PDO->getSingleresult("select name from #_lead_stage where pid='".$prd_rows['status']."'"));

		}

		$excel->close();

   /// Product Invantory

}

if($_GET['stags']=="invoice")
{
	    $filepath = $_GET['stags'].@date("Ymd").".xls";
	    $excel=new ExcelWriter($filepath);
		if($excel==false) {	echo $excel->error;	}
	    $date1=$_GET['sdate'];
		$date2=$_GET['edate'];
		//print_r($_POST);
		//echo "select * from #_products where ".$wh; exit;
		if($date1!='' && $date2!=''){
			$wr="created_on between '".$date1."' and '".$date2."'";
			}else{$wr= 1;}
			
		$prd_query=$PDO->db_query("select * from #_invoice where ".$wr);

        $i=0;
		$myArr=array("S No", "Create By", "Name", "Email ID", " Phone", " Service", "Source", "Date", " Time", " Comment", " Sales Executive","Status");

$excel->writeLine($myArr);

$contents = "Ticket No,Name, Email ID,  Phone,  Service, Date, Time,  Comment,  Sales Executive ,Status\n";
		
        while($prd_rows  = $PDO->db_fetch_array($prd_query))

        {
				if($prd_rows['salesecutiveid']){
				$salesecutiveid=$PDO->getSingleresult("select name from pms_admin_users where user_id='".$prd_rows['salesecutiveid']."'");}
				
			
			$excel->writeRow();	

			$excel->writeCol($PDO->parse_output($prd_rows['rwi']));

			$excel->writeCol($prd_rows['name']);

			$excel->writeCol($prd_rows['email']);

			$excel->writeCol($prd_rows['phone']);

			$excel->writeCol($prd_rows['service']);

			$excel->writeCol($prd_rows['source']);

			$excel->writeCol($prd_rows['dates']);

			$excel->writeCol($prd_rows['times']);

			$excel->writeCol($prd_rows['comments']);

			$excel->writeCol($salesecutiveid);

			$excel->writeCol($ADMIN->displayLeadsstatus($prd_rows['status']));

		}

		$excel->close();

   /// Product Invantory

}

header("Location:downloadleads.php?files=".$_GET['stags'].@date("Ymd").".xls");

exit;

?>