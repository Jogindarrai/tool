<?php
include '../../lib/config.inc.php';
 $sql = "SELECT * FROM #_product_manager WHERE name LIKE '%".$_POST['keyword']."%' ORDER BY name ASC LIMIT 0, 10";

 $query = $PDO->db_query($sql);
 $list=$PDO->db_fetch_all($query,PDO::FETCH_BOTH);

echo '<ul>';

foreach ($list as $rs) {

	// put in bold the written text

	$service_name = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $rs['name']);

	// add new option

    echo '<li onclick="set_item(this,\''.str_replace("'", "\'", $rs['name']).'\',\''.$rs['sacCode'].'\',\''.$rs['price'].'\')">'.$service_name.'</li>';

}

echo '</ul>';

 


?>