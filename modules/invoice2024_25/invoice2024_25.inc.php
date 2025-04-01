<?php

define('tblName', 'invoice2024_25');


class Pages extends dbc {

    public function add($data) {



        @extract($data);



        $query = parent::db_query("select * from #_" . tblName . " where created_on ='" . $created_on . "' ");



        if ($query->rowCount() == 0) {
            $data['created_on'] = date('Y-m-d H:i:s');



            $data['create_by'] = $_SESSION["AMD"][0];



            $data['salesecutiveid'] = $_SESSION["AMD"][0];
            $data['shortorder'] = parent::getSingleresult("select max(shortorder) as shortorder from #_" . tblName . " where 1=1 ") + 1;



            parent::sqlquery("rs", tblName, $data);



            $insertid = $GLOBALS['dbcon']->lastInsertId();

            $upids = $insertid;



            if ($upids < 10) {

                $zero = '000';
            } else if ($upids < 100) {

                $zero = '00';
            } else if ($upids < 1000) {

                $zero = '0';
            } else {

                $zero = '';
            }



            $upid2 = $upids;





            //$POST['inviceno']='RW/'.date('Y').'-'.date('y', strtotime('+1 year')).'/'.($upid2+23);

            $POST['inviceno'] = $data['inviceno'];
            //$POST['inviceno']='GVSD/'.date('Y').'-'.date('y', strtotime('+1 year')).'/'.($zero.$upid2);


//            if ($_SERVER['REMOTE_ADDR'] == '182.69.125.195') {
//                echo "<pre>";
//                print_r($POST);
//                exit;
//            }
            parent::sqlquery("rs", tblName, $POST, 'pid', $insertid);

            if ($data['lid'] != '') {

                $leadsdata['invoiceno'] = $POST['inviceno'];

                $leadsdata['invoiceid'] = $updid;



                parent::sqlquery("rs", 'leads', $leadsdata, 'pid', $data['lid']);

                $orderQuery = parent::db_query("select * from #_project where lid='" . $data['lid'] . "'");

                if ($orderQuery->rowCount() > 0) {



                    parent::sqlquery("rs", 'project', $leadsdata, 'lid', $data['lid']);
                }
            }





            parent::sessset('Record has been added', 's');



            //parent::admsendmail('ajaymaurya.rw@gmail.com', 'registrationwala', 'Record added !');



            $flag = 1;



            $invoiceid = $insertid;



            $returnval = array($flag, $invoiceid);
        } else {



            parent::sessset('Record has already added', 'e');



            $flag = 0;



            $returnval = array($flag);
        }



        return $returnval;
    }

    public function update($data) {



        @extract($data);



        $query = parent::db_query("select * from #_" . tblName . " where created_on ='" . $created_on . "' and pid!='" . $updateid . "' ");



        if ($query->rowCount() == 0) {



            //$data['password']=$this->password($data['password']);
            // parent::sqlquery("rs",'admin_users',$data);



            $data['itemservice'] = $data['itemservice'] ? array_filter($data['itemservice']) : '';



            $data['itempriceservice'] = $data['itempriceservice'] ? array_filter($data['itempriceservice']) : '';



            $data['itemadon'] = $data['itemadon'] ? array_filter($data['itemadon']) : '';



            $data['itempriceadon'] = $data['itempriceadon'] ? array_filter($data['itempriceadon']) : '';







            $data['modified_on'] = date('Y-m-d H:i:s');



            $data['modified_by'] = $modified_by . ':' . $_SESSION["AMD"][0];



            parent::sqlquery("rs", tblName, $data, 'pid', $updateid);



            parent::sessset('Record has been updated', 's');



            // parent::admsendmail('ajaymaurya.rw@gmail.com', 'registrationwala', 'Record updated !');



            $flag = 1;
        } else {



            parent::sessset('Record has already added', 'e');



            $flag = 0;
        }







        return $flag;
    }

    public function delete($updateid) {



        if (is_array($updateid)) {



            $updateid = implode(',', $updateid);
        }







        /* $delete_image=parent::getSingleresult("select image from #_".tblName." where pid='".$updateid."'");



          if($delete_image!='')



          {



          @unlink(UP_FILES_FS_PATH."/pages/".$delete_image);



          @unlink(UP_FILES_FS_PATH."/pages/900X400/".$delete_image);



          } */







        parent::db_query("delete from #_" . tblName . " where pid in ($updateid)");
    }

    public function status($updateid, $status) {



        if (is_array($updateid)) {



            $updateid = implode(',', $updateid);
        }







        parent::db_query("update  #_" . tblName . " set status='" . $status . "' where pid in ($updateid)");
    }

    public function display($start, $pagesize, $fld, $otype, $search_data, $zone, $mtype, $extra, $extra1, $extra2) {



        $start = intval($start);



        $columns = "select * ";







        if (trim($search_data) != '') {



            $wh = " and (rlmanager like '%" . $search_data . "%' or customername like '%" . $search_data . "%' or customeremail like '%" . $search_data . "%' or customerno like '%" . $search_data . "%' or inviceno like '%" . $search_data . "%'or hgrasstotal like '%" . $search_data . "%') ";
        }



        if (trim($search_data) == 'paid') {



            $wh = " and pstatus ='1'";
        }



        if (trim($search_data) == 'unpaid') {



            $wh = " and pstatus ='0'";
        }



        if (trim($search_data) == 'partial') {



            $wh = " and pstatus ='2'";
        }



        $zone = "";
        $mtype = "";
        $extra = "";
        $extra1 = "";
        $extra2 = "";
        $wh = "";

        // Ensure variables are properly set if they come from GET/POST requests
        $zone = isset($_GET['zone']) ? $_GET['zone'] : $zone;
        $mtype = isset($_GET['mtype']) ? $_GET['mtype'] : $mtype;
        $extra = isset($_GET['extra']) ? $_GET['extra'] : $extra;
        $extra1 = isset($_GET['extra1']) ? $_GET['extra1'] : $extra1;
        $extra2 = isset($_GET['extra2']) ? $_GET['extra2'] : $extra2;
        $wh = isset($_GET['wh']) ? $_GET['wh'] : $wh;

        // Construct SQL query


        $sql = " FROM #_" . tblName . " WHERE 1 " . $zone . $mtype . $extra . $extra1 . $extra2 . $wh;



// Ensure $order_by is defined, for example as an empty string
if (!isset($order_by)) {
    $order_by = '';
}

// Initialize variables if they are not already set
if (!isset($order_by)) {
    $order_by = '';
}

if (!isset($ord)) {
    $ord = false;  // or set it to an appropriate default value
}

if (!isset($fld)) {
    $fld = '';
}

// Now your ternary operation works without warnings:
$order_by = ($order_by == '') ? (($ord) ? 'orders' : (($fld) ? $fld : 'pid')) : $order_by;



if (!isset($order_by2)) {
    $order_by2 = '';
}

$order_by2 = ($order_by2 == '') ? (($otype) ? $otype : 'DESC') : $order_by2;



        $sql_count = "select count(*) " . $sql;



        $sql .= "order by $order_by $order_by2 ";



        $sql .= "limit $start, $pagesize ";



        $sql = $columns . $sql;



        $result = parent::db_query($sql);



        $reccnt = parent::db_scalar($sql_count);



        return array($result, $reccnt);
    }

}

?>