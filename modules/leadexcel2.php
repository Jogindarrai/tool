<?php 

include("../lib/config.inc.php");

include('excelwriter.inc.php');




	    $filepath = "dotleads.xls";
	    $excel=new ExcelWriter($filepath);
		if($excel==false) {	echo $excel->error;	}
		$prd_query=$PDO->db_query("select * from #_leads where  service=34");
     // echo $prd_query->rowCount(); exit;
        $i=0;
		$myArr=array("Ticket No", "Name", "Email ID", " Phone", " Service", "Source", "Date", " Time", " Comment", " Sales Executive","Status");

$excel->writeLine($myArr);

$contents = "Ticket No,Name, Email ID,  Phone,  Service, Date, Time,  Comment,  Sales Executive ,Status\n";
		
        while($prd_rows  = $PDO->db_fetch_array($prd_query))

        {  $services=$PDO->getSingleresult("select name from #_product_manager where pid='".$prd_rows['service']."'");
				if($prd_rows['salesecutiveid']){
				$salesecutiveid=$PDO->getSingleresult("select name from pms_admin_users where user_id='".$prd_rows['salesecutiveid']."'");}
				if($prd_rows['source']){
				$source=$PDO->getSingleresult("select name from #_lead_source where pid='".$prd_rows['source']."'");}
			
			$excel->writeRow();	

			$excel->writeCol($PDO->parse_output($prd_rows['rwi']));

			$excel->writeCol($prd_rows['name']);

			$excel->writeCol($prd_rows['email']);

			$excel->writeCol($prd_rows['phone']);

			$excel->writeCol($services==''?$prd_rows['service']:$services);

			$excel->writeCol($source);

			$excel->writeCol(date("d-M-Y",strtotime($prd_rows['created_on'])));

			$excel->writeCol(date("h:i s",strtotime($prd_rows['created_on'])));

			$excel->writeCol($prd_rows['comments']);

			$excel->writeCol($salesecutiveid);

			$excel->writeCol($PDO->getSingleresult("select name from #_lead_stage where pid='".$prd_rows['status']."'"));

		}

		$excel->close();

   /// Product Invantory





header("Location:downloadleads.php?files=dotleads.xls");

exit;

?>