<?php 
include("../lib/config.inc.php");
if($PDO->db_query("update #_".$tbl." set pstatus = '".$pstatus."', pamount='".$pamount."' where ".$field." ='".$uid."'")){
	echo 'Status updated successfully';
	}else{ 
echo 'Some Thing went wrong! please try again!';
	}
?>