<?php
include ('config.inc.php');
$key='package_name';
$sids='1:2';
$sn='';
$proj_rows['mpersonid']=1;
$proj_rows['smid']=2;
$proj_rows['managerid']=1;
$proj_rows['asssitantmanagerid']=4;
$proj_rows['executivemanagerid']=4;
$product_query = $PDO->db_query("select package_name from rw_packages_type where  id in(1,2,3) ");

while($product_rows = $PDO->db_fetch_array($product_query)){
		  print_r($product_rows['package_name']);
		  
		  }
		  $email_to = array();
		array_push($email_to, $proj_rows['mpersonid'], $proj_rows['sexecutiveid'],$proj_rows['smid'],$proj_rows['managerid'],$proj_rows['asssitantmanagerid'],$proj_rows['executivemanagerid']);
		$email_to =array_unique($email_to);
		print_r($email_to);
		
		foreach($email_to as $mto){
			echo $mto;
		}
		/*$services=explode(':', $sids);
		$sc=count($services);
		$scm=$sc>1?', ':'';
		echo $sc;
		foreach($services as $service){
		$sn.= $BSC->getSingleResult("select ".$key." from rw_packages_type where id='".$service."'").$scm;
		}
		echo $sn;*/
		?>
