<?php
class dbc
{
	function __construct()
	{		global $ARR_DBS;

		global $PDOCONN;

		if (!isset($GLOBALS['dbcon']))
		{



			try {



				$GLOBALS['dbcon'] = new PDO('mysql:host='.$ARR_DBS["dbs"]['host'].';dbname='.$ARR_DBS["dbs"]['name'], $ARR_DBS["dbs"]['user'], $ARR_DBS["dbs"]['password'],array(PDO::ATTR_PERSISTENT => false, PDO::ATTR_EMULATE_PREPARES => false));
				} catch (PDOException $e) {



				print "Error!: " . $e->getMessage() . "<br/>";



				die();



				}







			/*$GLOBALS['dbcon'] =	mysql_connect($ARR_DBS["dbs"]['host'], $ARR_DBS["dbs"]['user'], $ARR_DBS["dbs"]['password']);



			mysql_select_db($ARR_DBS["dbs"]['name']) or die("Could not connect to database. Please check configuration and ensure MySQL is running.");*/



		}

//$GLOBALS['dbconElastic']=$ARR_DBS["dbs"]['elasticHost'].'/'.$ARR_DBS["dbs"]['elasticIndex'].'/';

$PDOCONN=$GLOBALS['dbcon'];

	}

	public function PDBC(){



		return $GLOBALS['dbcon'];



		}







	public function parse_input($val)



	{



	   $dbcon2	= $GLOBALS['dbcon'];



	   $val=$dbcon2->quote($val);



	   //$val=mysql_real_escape_string($val);



	   return $val;
	}
	public function parse_output($val)



	{







	   $val=stripslashes($val);



	   return $val;







	}







	public function checkpoint($from_start = false) {



		global $PREV_CHECKPOINT;



		if($PREV_CHECKPOINT=='') {



			$PREV_CHECKPOINT = SCRIPT_START_TIME;



		}



		$cur_microtime = $this->getmicrotime();







		if($from_start) {



			return $cur_microtime - SCRIPT_START_TIME;



		} else {



			$time_taken = $cur_microtime - $PREV_CHECKPOINT;



			$PREV_CHECKPOINT = $cur_microtime;



			return $time_taken;



		}



	}
	public function db_query_($sql, $dbcon2 = null)



	{



		 $dbcon2	= $GLOBALS['dbcon'];



		 $time_before_sql = $this->checkpoint();



		 $result	=$dbcon2->query($sql) or	die($this->db_error($sql));



		 return $result;



	}







	public function db_error($sql) {



		$dbcon2	= $GLOBALS['dbcon'];



		echo "<div style='font-family: tahoma; font-size: 11px; color: #333333'><br>".print_r($dbcon2->errorInfo())."<br>";



		$this->print_error();



		if(LOCAL_MODE) {



			echo "<br>sql: $sql";



		}



		echo "</div>";



	}







	public function getmicrotime()



	{



		list($usec,	$sec) =	explode(" ", microtime());



		return ((float)$usec + (float)$sec);



	}







	public function getSingleresult($sql, $dbcon2 = null) {



		if($dbcon2=='') {



			if(!isset($GLOBALS['dbcon'])) {



				$this->connect_db();



			}



			$dbcon2	= $GLOBALS['dbcon'];



		}



		$result	=$this->db_query($sql, $dbcon2);



		if ($line =	$this->db_fetch_array($result)) {



			$response =	$line[0];



		}



		return $response;



	}



	public function getResult($sql, $dbcon2 = null) {

		if($dbcon2=='') {

			if(!isset($GLOBALS['dbcon'])) {

				$this->connect_db();

			}

			$dbcon2	= $GLOBALS['dbcon'];

		}

		$result	=$this->db_query($sql, $dbcon2);

		if ($line =	$this->db_fetch_array($result)) {

			$response =	$line;

		}

		return $response;

	}







	public function db_query($sql, $dbcon2 = null)



	{



		$sql = str_replace("#_", tb_Prefix, $sql);



		if($dbcon2=='') {



			if(!isset($GLOBALS['dbcon'])) {



				$this->connect_db();



			}



			$dbcon2	= $GLOBALS['dbcon'];



		}




		$time_before_sql = $this->checkpoint();



		//$result	= mysql_query($sql,	$dbcon2) or	die($this->db_error($sql));



		$result	= $dbcon2->query($sql) or	die(print_r($this->db_error($sql)));



		return $result;



	}







	public function sqlquery($tablename, $arr, $rs = 'exe', $update = '', $id = '', $update2 = '', $id2 = '')



	{







		$sql = $this->db_query("DESC ".tb_Prefix."$tablename");



		$row = $sql->fetch();//mysql_fetch_array($sql);







		if($update == '')



			$makesql = "insert into ";



		else



			$makesql = "update " ;



		$makesql .= tb_Prefix."$tablename set ";







		$i = 1;



		while($row = $sql->fetch()) {



			if(array_key_exists($row['Field'], $arr)) {











				if($i != 1)



					$makesql .= ", ";







				//$makesql .= $row['Field']."='".$this->ms_addslashes((is_array($arr[$row['Field']]))?implode(":",$arr[$row['Field']]):$arr[$row['Field']])."'";







				$makesql .= $row['Field']."=".$this->parse_input((is_array($arr[$row['Field']]))?implode(":",$arr[$row['Field']]):$arr[$row['Field']]);















				$i++;



			}







		}



		if($update)



			$makesql .= " where ".$update."='".$id."'".(($update2 && $id2)?" and ".$update2."='".$id2."'":"");



		if($rs == 'show') {



			echo $makesql;



			exit;



		}



		else {



			$this->db_query($makesql);



		}



		$dbcon2	= $GLOBALS['dbcon'];



		return ($update)?$id:$dbcon2->lastInsertId();



	}







	public function sqlquerywithPrefix($tablename, $arr, $rs = 'exe', $update = '', $id = '', $update2 = '', $id2 = '')



	{







		$sql = $this->db_query("DESC $tablename");



		$row = $sql->fetch();//mysql_fetch_array($sql);







		if($update == '')



			$makesql = "insert into ";



		else



			$makesql = "update " ;



		$makesql .= "$tablename set ";







		$i = 1;



		while($row = $sql->fetch()) {



			if(array_key_exists($row['Field'], $arr)) {











				if($i != 1)



					$makesql .= ", ";







				//$makesql .= $row['Field']."='".$this->ms_addslashes((is_array($arr[$row['Field']]))?implode(":",$arr[$row['Field']]):$arr[$row['Field']])."'";







				$makesql .= $row['Field']."=".$this->parse_input((is_array($arr[$row['Field']]))?implode(":",$arr[$row['Field']]):$arr[$row['Field']]);















				$i++;



			}







		}



		if($update)



			$makesql .= " where ".$update."='".$id."'".(($update2 && $id2)?" and ".$update2."='".$id2."'":"");



		if($rs == 'show') {



			echo $makesql;



			exit;



		}



		else {



			$this->db_query($makesql);



		}



		$dbcon2	= $GLOBALS['dbcon'];



		return ($update)?$id:$dbcon2->lastInsertId();



	}







	public function db_scalar($sql, $dbcon2 = null) {



		if($dbcon2=='') {



			if(!isset($GLOBALS['dbcon'])) {



				$this->connect_db();



			}



			$dbcon2	= $GLOBALS['dbcon'];



		}



		$result	= $this->db_query($sql, $dbcon2);



		if ($line =	$this->db_fetch_array($result)) {



			$response =	$line[0];



		}



		return $response;



	}











	public function db_fetch_array($rs,$m=PDO::FETCH_BOTH) {



		//$array	= mysql_fetch_array($rs);



		$array	= $rs->fetch($m);



		return $array;



	}



	public function db_fetch_all($rs,$m=PDO::FETCH_BOTH) {



		//$array	= mysql_fetch_array($rs);

		$array	= $rs->fetchAll($m);



		return $array;



	}

public function encrypt_decrypt($action, $string) {
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = '786';
    $secret_iv = '07';
    // hash
    $key = hash('sha256', $secret_key);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if( $action == 'decrypt' ) {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}

	public function sessset($val, $msg="")



	{



		$_SESSION['sessmsg'] = $val;



		$_SESSION['alert'] = $msg;



	}







	public function print_error() {



		$debug_backtrace = debug_backtrace();



		for ($i = 1; $i < count($debug_backtrace); $i++) {



			$error = $debug_backtrace[$i];



			echo "<br><div><span>File:</span> ".str_replace(SITE_FS_PATH, '',$error['file'])."<br><span>Line:</span> ".$error['line']."<br><span>Function:</span> ".$error['function']."<br></div>";



		}



	}







	function product_url($proid)



	{



		   $product_query = $this->db_query("select * from #_products where status ='1' and pp_id='".$proid."' ");



		   $product_rows = $this->db_fetch_array($product_query);







		   $brand_url=$this->getSingleResult("select url from #_brands where status ='1' and brand_id='".$product_rows['brand_id']."' ");



           $series_url=$this->getSingleResult("select url from #_series where status ='1' and sid='".$product_rows['series_id']."' ");



		   $model_url=$this->getSingleResult("select url from #_models where status ='1' and model_id='".$product_rows['model_id']."' ");







		   $die_type_url=$this->getSingleResult("select DT.url FROM  #_die_types as DT INNER JOIN   #_dies as D ON DT.dt_id =D.die_type where D.die_id='".$product_rows['die_id']."'");







		   $designer_url=$this->getSingleResult("select url from #_print_images where status ='1' and img_id='".$product_rows['design_id']."' ");



	       $product_url =  SITE_PATH.'product/'.$brand_url.(($series_url)?'/'.$series_url:'').'/'.$model_url.'/'.$die_type_url.'/'.$designer_url.'/'.$product_rows['product_code'].".html";







		   return $product_url;



	}







	public function pageinfo($page){



		$pageInfo = array();



		$pageInfo[title] = $this->get_static_content('meta_title',$page);



		$pageInfo[keyword] = $this->get_static_content('meta_keyword',$page);



		$pageInfo[description] = $this->get_static_content('meta_description',$page);



		$pageInfo[heading] = $this->get_static_content('heading',$page);



		$pageInfo[body] = $this->get_static_content('body',$page);



		//$pageInfo[sort_body] = $this->get_static_content('sort_body',$page);



		//$pageInfo[pimage] = $this->get_static_content('pimage',$page);



		return $pageInfo;







	}



	public function get_static_content($key,$pname){



		return $rs = $this->db_scalar("select ".$key." from #_pages where url='$pname'");



	}

	public function executeElasticQry ($node,$method, $qry) {

	$url=$GLOBALS['dbconElastic'].$node.'/_search';

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_PORT, 9200);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));

    curl_setopt($ch, CURLOPT_POSTFIELDS, $qry);

    $result = curl_exec($ch);

    curl_close($ch);

	return $result;

}

public function elasticResult ($node,$method,$elQuery) {

 $result=$this->executeElasticQry($node,$method, $elQuery);

 $newresult= json_decode($result, true);

	$data= $newresult['hits']['hits'];

	if(!$data){

		return $newresult['error'];

		}else{

		return $data;

			}

}

public function elasticTotal ($node,$method,$elQuery) {

 $result=$this->executeElasticQry($method, $elQuery);

 $newresult= json_decode($result, true);

	return $newresult['hits']['total'];

}

}



?>